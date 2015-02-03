<?php

/**
 * Contrexx
 *
 * @link      http://www.contrexx.com
 * @copyright Comvation AG 2007-2014
 * @version   Contrexx 4.0
 * 
 * According to our dual licensing model, this program can be used either
 * under the terms of the GNU Affero General Public License, version 3,
 * or under a proprietary license.
 *
 * The texts of the GNU Affero General Public License with an additional
 * permission and of our proprietary license can be found at and
 * in the LICENSE file you have received along with this program.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * "Contrexx" is a registered trademark of Comvation AG.
 * The licensing of the program under the AGPLv3 does not imply a
 * trademark license. Therefore any rights, title and interest in
 * our trademarks remain entirely with us.
 */

/**
 * FTPFile
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  lib_filesystem
 */

namespace Cx\Lib\FileSystem;

/**
 * FTPFileException
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Thomas Däppen <thomas.daeppen@comvation.com>
 * @version     3.0.0
 * @package     contrexx
 * @subpackage  lib_filesystem
 */

class FTPFileException extends \Exception {};

/**
 * FTP File
 *
 * This class provides an object based interface to a file located 
 * on an FTP server.
 * In general, do no use this class. Instead use the class Cx\Lib\FileSystem\File
 * which is a wrapper that uses either this class or
 * Cx\Lib\FileSystem\FileSystemFile for file operations, depending on the
 * system configuration.
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Thomas Däppen <thomas.daeppen@comvation.com>
 * @version     3.0.0
 * @package     contrexx
 * @subpackage  lib_filesystem
 */
class FTPFile implements FileInterface
{
    private $file = null;
    private $filePath = null;
    private $passedFilePath = null;
    private $connection = null;
    private $connected = false;
    private $tempFileHandler = null;
    private $tempFile = null;
    private $ftpConfig = null;

    /**
     * Create a new FTPFile object that acts as an interface to
     * a file located on the FTP server.
     *
     * @param   string  Path to file on FTP server.
     * @param   array   FTP configuration array.
     */
    public function __construct($file, $ftpConfig = null)
    {
        if (empty($file)) {
            throw new FTPFileException('No file path specified!');
        }

        if (isset($ftpConfig)) {
            $this->ftpConfig = $ftpConfig;
        } else {
            $this->ftpConfig = \Env::get('ftpConfig');
        }

        $this->passedFilePath = $file;
        $pathInfo = pathinfo($file);
        $this->file = $pathInfo['basename'];
        $path = $pathInfo['dirname'];

        if ($file == ASCMS_PATH) {
            $this->file = '';
        }

        $this->filePath = $this->getValidFilePath($file, $path);
    }

    private function getValidFilePath($file, $path)
    {
        if ($file == ASCMS_PATH) {
            $filePath = $this->ftpConfig['path'];
        } elseif (strpos($path, ASCMS_PATH) === 0) {
            $filePath = $this->ftpConfig['path'].substr($path, strlen(ASCMS_PATH));
        } elseif (ASCMS_PATH_OFFSET && strpos($path, ASCMS_PATH_OFFSET) === 0) {
            $filePath = $this->ftpConfig['path'].$path;
        } elseif (strpos($path, '/') === 0) {
            $filePath = $this->ftpConfig['path'].ASCMS_PATH_OFFSET.$path;
        } else {
            $filePath = $this->ftpConfig['path'].ASCMS_PATH_OFFSET.'/'.$path;
        }

        return preg_replace('#^/+#', '', $filePath);
    }

    /**
     * Writes data specified by $data to the file the object had been initialized with.
     * @param   string  $data
     */
    public function write($data)
    {
        $this->initConnection();
        $this->writeToTempFile($data);
        $this->uploadTempFile();
        $this->deleteTempFile();
    }
    
    public function append($data)
    {
        $this->write($data);
    }

    public function touch()
    {
        // abort if file already exists
        if (file_exists($this->passedFilePath)) {
            return true;
        }

        $this->write('');
    }
    
    public function copy($dst)
    {
        $this->initConnection();
        
        try {
            $src = fopen($this->passedFilePath, 'r');
            
            $pathInfo = pathinfo($dst);
            $path     = $pathInfo['dirname'];
            $file     = $pathInfo['basename'];
            $filePath = $this->getValidFilePath($file, $path);
            $dst      = $filePath . '/' . $file;
            
            ftp_set_option($this->connection, FTP_TIMEOUT_SEC, 600);
            
            if (!ftp_fput($this->connection, $dst, $src, FTP_BINARY)) {
                throw new FTPFileException('FTP upload from ' . $this->passedFilePath . ' to ' . $dst . ' failed.');
            }
        } catch (FTPFileException $e) {
            throw new FTPFileException($e->getMessage());
        }
        
    }
    
    public function rename($dst)
    {
        $this->move($dst);
    }
    
    public function move($dst)
    {
        $this->initConnection();
        
        try {
            $pathInfo = pathinfo($dst);
            $path     = $pathInfo['dirname'];
            $file     = $pathInfo['basename'];
            $filePath = $this->getValidFilePath($file, $path);
            $dst      = $filePath . '/' . $file;
            
            if (!ftp_rename($this->connection, $this->passedFilePath, $dst)) {
                throw new FTPFileException('FTP rename from ' . $this->passedFilePath . ' to ' . $dst . ' failed.');
            }
        } catch (FTPFileException $e) {
            throw new FTPFileException($e->getMessage());
        }
        
    }

    public function makeWritable()
    {
        $this->initConnection();

        // fetch current permissions on loaded file through FileSystemFile object
        try {
            $objFile = new \Cx\Lib\FileSystem\FileSystemFile($this->passedFilePath);
            $filePerms = $objFile->getFilePermissions();
            \DBG::msg('FTPFile: Fetched file permissions of '.$this->passedFilePath.': '.substr(sprintf('%o', $filePerms), -4));
        } catch (FileSystemFileException $e) {
            throw new FTPFileException($e->getMessage());
        }

        // abort process in case the file is already writable
        // test: check write access for file owner
        if ($filePerms & \Cx\Lib\FileSystem\FileSystem::CHMOD_USER_WRITE) {
            return true;
        }

        // this is probably not required for FTP - TD / 11/1/2012
        /*$parentDirectory = dirname($this->passedFilePath);
        if (!is_writable($parentDirectory)) {
            if (strpos($parentDirectory, ASCMS_DOCUMENT_ROOT) === 0) {
                // parent directory lies within the Contrexx installation directory,
                // therefore, we shall try to make it writable
                \Cx\Lib\FileSystem\FileSystem::makeWritable($parentDirectory);
            } else {
                \DBG::msg('Parent directory '.$parentDirectory.' lies outside of Contrexx installation and can therefore not be made writable!');
            }
        }*/

        // set write access to file owner
        $filePerms |= \Cx\Lib\FileSystem\FileSystem::CHMOD_USER_WRITE;

        // log file permissions into the humand readable chmod() format
        \DBG::msg('FTPFile: CHMOD: '.substr(sprintf('%o', $filePerms), -4));

        if (!ftp_chmod($this->connection, $filePerms, $this->filePath.'/'.$this->file)) {
            throw new FTPFileException('FTPFile: Unable to set write access to file '.$this->filePath.'/'.$this->file.'!');
        }
    }

    public function delete()
    {
        $this->initConnection();

        if (!ftp_delete($this->connection, $this->filePath.'/'.$this->file)) {
            throw new FTPFileException('Unable to delete file '.$this->filePath.'/'.$this->file.'!');
        }
    }

    private function uploadTempFile()
    {
        // navigate to specified directory on FTP server
        /*ftp_chdir($this->connection, '/');
        foreach (explode('/', $this->filePath) as $dir) {
            if (!empty($dir)) {
                ftp_chdir($this->connection, $dir);
            }
        }

        if ($this->filePath != ftp_pwd($this->connection)) {
            throw new FTPFileException('Unable to navigation into directory '.$this->filePath.' on FTP server');
        }*/

        ftp_set_option($this->connection, FTP_TIMEOUT_SEC, 600);
        rewind($this->tempFileHandler);
        if (!ftp_fput($this->connection, $this->filePath.'/'.$this->file, $this->tempFileHandler, FTP_BINARY)) {
            throw new FTPFileException('FTP upload of file '.$this->file.' to directory '.$this->filePath.' failed !');
        }
    }

    private function openTempFileHandler()
    {
        global $sessionObj;

        // try memory first
        if (($this->tempFileHandler = fopen("php://memory", 'r+')) === false) {
            // unable to use memory as temporary storage location,
            // try to create file in the session temp path 
            if (empty($sessionObj)) { //session hasn't been initialized so far
                $sessionObj = \cmsSession::getInstance();
            }

            $sessionTempPath = $_SESSION->getTempPath();
            $pathInfo = pathinfo($this->file);
            $tempFile = $sessionTempPath.'/'.$pathInfo['basename'];
            $idx = 1;
            while (file_exists($tempFile)) {
                $tempFile = $sessionTempPath.'/'.$pathInfo['filename'].$idx++.$pathInfo['extension'];
            }

            if (($this->tempFileHandler = fopen($tempFile, 'r+')) === false) {
                return false;
            }

            // remember tempFile, we will have to delete it after it fullfilled its purpose
            $this->tempFile = $tempFile;
        }

        return true;
    }

    private function deleteTempFile()
    {
        fclose($this->tempFileHandler);

        if (!empty($this->tempFile)) {
            unlink($this->tempFile);
            $this->tempFile = null;
        }
    }

    private function writeToTempFile($data)
    {
        if (!$this->openTempFileHandler()) {
            throw new FTPFileException('Unable to create a temporary file used to buffer the file data!');
        }

        rewind($this->tempFileHandler);
        if (fwrite($this->tempFileHandler, $data) === false) {
            throw new FTPFileException('Unable to write the data to the temporary file!');
        }
    }

    private function initConnection()
    {
        if ($this->connected) {
            return;
        }

        if (!$this->ftpConfig['is_activated']) {
            throw new FTPFileException('No FTP support on this system!');
        }

        $this->connection = ftp_connect($this->ftpConfig['host']);
        if (!$this->connection) {
            throw new FTPFileException('Unable to establish FTP connection. Probably wrong FTP host info specified in config/configuration.php');
        }
    
        if (!ftp_login($this->connection, $this->ftpConfig['username'], $this->ftpConfig['password'])) {
            throw new FTPFileException('Unable to authenticate on FTP server. Probably wrong FTP login credentials specified in config/configuration.php');
        }
    
        $this->connected = true;
    }
}

