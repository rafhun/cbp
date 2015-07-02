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
 * Media Library
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author        Comvation Development Team <info@comvation.com>
 * @version       1.0.1
 * @package     contrexx
 * @subpackage  coremodule_media
 * @todo        Edit PHP DocBlocks!
 */

/**
 * Media Library
 *
 * LibClass to manage cms media manager
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author        Comvation Development Team <info@comvation.com>
 * @access        public
 * @version       1.0.1
 * @package     contrexx
 * @subpackage  coremodule_media
 */
class MediaLibrary
{
    protected $sortBy    = 'name';
    protected $sortDesc  = false;

    public $_arrSettings = array();


    // act: newDir
    // creates a new directory through php or ftp
    function _createNewDir($dirName)
    {
        global $_ARRAYLANG, $objTemplate;

        $dirName = \Cx\Lib\FileSystem\FileSystem::replaceCharacters($dirName);
        $status = \Cx\Lib\FileSystem\FileSystem::make_folder($this->path.$dirName);
        if ($status) {
            $this->highlightName[] = $this->dirLog;
            $objTemplate->setVariable('CONTENT_OK_MESSAGE',$_ARRAYLANG['TXT_MEDIA_MSG_NEW_DIR']);
        } else {
            $objTemplate->setVariable('CONTENT_STATUS_MESSAGE',$_ARRAYLANG['TXT_MEDIA_MSG_ERROR_NEW_DIR']);
        }
    }


    // act: preview
    // previews the edited image
    function _previewImage()
    {
        $arr = explode(',', $this->getData);
        $this->_objImage->loadImage($this->path.$this->getFile);
        $this->_objImage->resizeImage($arr[0], $arr[1], $arr[2]);
        $this->_objImage->showNewImage();
    }


    // act: previewSize
    // previews the size of the edite image
    function _previewImageSize()
    {
        $arr = explode(',', $this->getData);
        $this->_objImage->loadImage($this->path.$this->getFile);
        $this->_objImage->resizeImage($arr[0], $arr[1], $arr[2]);

        $time = time();
        $this->_objImage->saveNewImage($this->path.$time);
        $size = @filesize($this->path.$time);

        @unlink($this->path.$time);
        $size = $this->_formatSize($size);

        $width   = strlen($size) * 7 + 10;
        $img     = imagecreate($width, 20);
        $colBody = imagecolorallocate($img, 255, 255, 255);
        ImageFilledRectangle($img, 0, 0, $width, 20, $colBody);
        $colFont = imagecolorallocate($img, 0, 0, 0);
        imagettftext($img, 10, 0, 5, 15, $colFont, self::_getIconPath().'arial.ttf', $size);

        header("Content-type: image/jpeg");
        imagejpeg($img, '', 100);
    }

    /**
     * downloads the media
     *
     * act: download
     */
    function _downloadMediaOLD()
    {
        if (is_file($this->path.$this->getFile)) {
            CSRF::header("Location: ".$this->webPath.$this->getFile);
            exit;
        }
    }

    /**
     * Send a file for downloading
     *
     */
    function _downloadMedia()
    {
        // The file is already checked (media paths only)
        $file = $this->path.$this->getFile;
        //First, see if the file exists
        if (!is_file($file)) { die("<b>404 File not found!</b>"); }

        $filename = basename($file);
        $file_extension = strtolower(substr(strrchr($filename,"."),1));

        //This will set the Content-Type to the appropriate setting for the file
        switch( $file_extension ) {
            case "pdf": $ctype="application/pdf"; break;
            case "exe": $ctype="application/octet-stream"; break;
            case "zip": $ctype="application/zip"; break;
            case "docx" :
            case "doc": $ctype="application/msword"; break;
            case "xlsx":
            case "xls": $ctype="application/vnd.ms-excel"; break;
            case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
            case "gif": $ctype="image/gif"; break;
            case "png": $ctype="image/png"; break;
            case "jpeg":
            case "jpg": $ctype="image/jpg"; break;
            case "mp3": $ctype="audio/mpeg"; break;
            case "wav": $ctype="audio/x-wav"; break;
            case "mpeg":
            case "mpg":
            case "mpe": $ctype="video/mpeg"; break;
            case "mov": $ctype="video/quicktime"; break;
            case "avi": $ctype="video/x-msvideo"; break;

            //The following are for extensions that shouldn't be downloaded (sensitive stuff, like php files)
            case "phps":
            case "php4":
            case "php5":
            case "php": die("<b>Cannot be used for ". $file_extension ." files!</b>"); break;

            default: $ctype="application/force-download";
        }

        require_once ASCMS_LIBRARY_PATH.'/PEAR/Download.php';
        $dl = new HTTP_Download(array(
          "file"                  => $file,
          "contenttype"           => $ctype
        ));
        $dl->send();

        exit;
    }


    /**
     * cuts the media -> paste insterts the media
     *
     * act: cut
     */
    function _cutMedia()
    {
        if (isset($_POST['formSelected']) && !empty($_POST['formSelected'])) {
            if (isset($_SESSION['mediaCutFile'])) {
                unset($_SESSION['mediaCutFile']);
            }
            if (isset($_SESSION['mediaCopyFile'])) {
                unset($_SESSION['mediaCopyFile']);
            }
            $_SESSION['mediaCutFile'] = array();
            $_SESSION['mediaCutFile'][] = $this->path;
            $_SESSION['mediaCutFile'][] = $this->webPath;
            $_SESSION['mediaCutFile'][] = $_POST['formSelected'];
        }
    }


    /**
     * copies the media -> paste inserts the media
     *
     * act: copy
     */
    function _copyMedia()
    {
        if (isset($_POST['formSelected']) && !empty($_POST['formSelected'])) {
            if (isset($_SESSION['mediaCutFile'])) {
                unset($_SESSION['mediaCutFile']);
            }
            if (isset($_SESSION['mediaCopyFile'])) {
                unset($_SESSION['mediaCopyFile']);
            }

            $_SESSION['mediaCopyFile'] = array();
            $_SESSION['mediaCopyFile'][] = $this->path;
            $_SESSION['mediaCopyFile'][] = $this->webPath;
            $_SESSION['mediaCopyFile'][] = $_POST['formSelected'];
        }
    }


    /**
     * Inserts the file
     *
     * act: paste
     */
    function _pasteMedia()
    {
        global $_ARRAYLANG, $objTemplate;

        // cut
        if (isset($_SESSION['mediaCutFile']) && !empty($_SESSION['mediaCutFile'])) {
            $check = true;

            foreach ($_SESSION['mediaCutFile'][2] as $name) {
                if ($_SESSION['mediaCutFile'][0] != $this->path) {
                    $obj_file = new File();

                    if (is_dir($_SESSION['mediaCutFile'][0].$name)) {
                        $this->dirLog=$obj_file->copyDir($_SESSION['mediaCutFile'][0], $_SESSION['mediaCutFile'][1], $name, $this->path, $this->webPath, $name);
                        if ($this->dirLog == "error") {
                            $check = false;
                        } else {
                            $obj_file->delDir($_SESSION['mediaCutFile'][0], $_SESSION['mediaCutFile'][1], $name);
                        }
                    } else {
                        $this->dirLog=$obj_file->copyFile($_SESSION['mediaCutFile'][0], $name, $this->path, $name);
                        if ($this->dirLog == "error") {
                            $check = false;
                        } else {
                            $obj_file->delFile($_SESSION['mediaCutFile'][0], $_SESSION['mediaCutFile'][1], $name);
                        }
                    }

                    $this->highlightName[] = $this->dirLog;
                }
                else
                {
                    $this->highlightName[] = $name;
                }
            }

            if ($check != false) {
                $objTemplate->setVariable('CONTENT_OK_MESSAGE',$_ARRAYLANG['TXT_MEDIA_MSG_CUT']);
                unset($_SESSION['mediaCutFile']);
            } else {
                $objTemplate->setVariable('CONTENT_STATUS_MESSAGE',$_ARRAYLANG['TXT_MEDIA_MSG_ERROR_CUT']);
            }
        }

        // copy
        if (isset($_SESSION['mediaCopyFile']) && !empty($_SESSION['mediaCopyFile']))
        {
            $check = true;

            foreach ($_SESSION['mediaCopyFile'][2] as $name) {
                $obj_file = new File();

                if (is_dir($_SESSION['mediaCopyFile'][0].$name)) {
                    $this->dirLog=$obj_file->copyDir($_SESSION['mediaCopyFile'][0], $_SESSION['mediaCopyFile'][1], $name, $this->path, $this->webPath, $name);
                    if ($this->dirLog == "error") {
                        $check = false;
                    }
                } else {
                    $this->dirLog=$obj_file->copyFile($_SESSION['mediaCopyFile'][0], $name, $this->path, $name);
                    if ($this->dirLog == "error") {
                        $check = false;
                    }
                }

                $this->highlightName[] = $this->dirLog;
            }

            if ($check != false) {
                $objTemplate->setVariable('CONTENT_OK_MESSAGE',$_ARRAYLANG['TXT_MEDIA_MSG_COPY']);
                unset($_SESSION['mediaCopyFile']);
            } else {
                $objTemplate->setVariable('CONTENT_STATUS_MESSAGE',$_ARRAYLANG['TXT_MEDIA_MSG_ERROR_COPY']);
            }
        }
    }


    // act: delete
    // deletes a file or an directory
    function _deleteMedia()
    {
        global $objTemplate;

        if (!empty($this->getFile)) {
            $objTemplate->setVariable('CONTENT_OK_MESSAGE', $this->_deleteMedia2($this->getFile));
        } elseif (!empty($_POST['formSelected'])) {
            foreach ($_POST['formSelected'] as $file) {
                $objTemplate->setVariable('CONTENT_OK_MESSAGE', $this->_deleteMedia2($file));
            }
        }
    }


    function _deleteMedia2($file)
    {
        global $_ARRAYLANG;

        $obj_file = new File();
        if (is_dir($this->path.$file)) {
            $this->dirLog=$obj_file->delDir($this->path, $this->webPath, $file);
            if ($this->dirLog != "error") {
                $status = $_ARRAYLANG['TXT_MEDIA_MSG_DIR_DELETE'];
            } else {
                $status = $_ARRAYLANG['TXT_MEDIA_MSG_ERROR_DIR'];
            }
         } else {
            if ($this->_isImage($this->path.$file)) {
                $thumb_name = ImageManager::getThumbnailFilename($file);
                if (file_exists($this->path.$thumb_name)) {
                    $this->dirLog=$obj_file->delFile($this->path, $this->webPath, $thumb_name);
                }
            }
            $this->dirLog=$obj_file->delFile($this->path, $this->webPath, $file);
            if ($this->dirLog != "error") {
                $status = $_ARRAYLANG['TXT_MEDIA_MSG_FILE_DELETE'];
            } else {
                $status = $_ARRAYLANG['TXT_MEDIA_MSG_ERROR_FILE'];
            }
        }
        return $status;
    }


    /**
     * Renames a media file
     */
    function renMedia()
    {
        global $_ARRAYLANG, $objTemplate;

        $obj_file = new File();
        // file or dir
        $fileName = !empty($_POST['renName']) ? $_POST['renName'] : 'empty';
        if (empty($_POST['oldExt'])) {
            $oldName  = $_POST['oldName'];
        } else {
            $oldName  = $_POST['oldName'].'.'.$_POST['oldExt'];
        }

        $ext      =
            (   !empty($_POST['renExt'])
            && FWValidator::is_file_ending_harmless(
                $_POST['renName'].'.'.$_POST['renExt'])
                ? $_POST['renExt'] : 'txt');
        $fileName = $fileName.'.'.$ext;

        \Cx\Lib\FileSystem\FileSystem::clean_path($fileName);

        if (!isset($_POST['mediaInputAsCopy']) || $_POST['mediaInputAsCopy'] != 1) {
            // rename old to new
            if (is_dir($this->path.$oldName)) {
                $this->dirLog=$obj_file->renameDir($this->path, $this->webPath, $oldName, $fileName);
                if ($this->dirLog == "error") {
                    $objTemplate->setVariable('CONTENT_STATUS_MESSAGE',$_ARRAYLANG['TXT_MEDIA_MSG_ERROR_EDIT']);
                } else {
                    $this->highlightName[] = $this->dirLog;
                    $objTemplate->setVariable('CONTENT_OK_MESSAGE',$_ARRAYLANG['TXT_MEDIA_MSG_EDIT']);
                }
            } else {
                $this->dirLog=$obj_file->renameFile($this->path, $this->webPath, $oldName, $fileName);
                if ($this->dirLog == "error") {
                    $objTemplate->setVariable('CONTENT_STATUS_MESSAGE',$_ARRAYLANG['TXT_MEDIA_MSG_ERROR_EDIT']);
                } else {
                    $this->highlightName[] = $this->dirLog;
                    $objTemplate->setVariable('CONTENT_OK_MESSAGE',$_ARRAYLANG['TXT_MEDIA_MSG_EDIT']);
                }
            }
        } elseif (isset($_POST['mediaInputAsCopy']) && $_POST['mediaInputAsCopy'] == 1) {
            // copy old to new
            if (is_dir($this->path.$oldName)) {
                $this->dirLog=$obj_file->copyDir($this->path, $this->webPath, $oldName, $this->path, $this->webPath, $fileName);
                if ($this->dirLog == "error") {
                    $objTemplate->setVariable('CONTENT_STATUS_MESSAGE',$_ARRAYLANG['TXT_MEDIA_MSG_ERROR_EDIT']);
                } else {
                    $this->highlightName[] = $this->dirLog;
                     $objTemplate->setVariable('CONTENT_OK_MESSAGE',$_ARRAYLANG['TXT_MEDIA_MSG_EDIT']);
                }
            } else {
                $this->dirLog=$obj_file->copyFile($this->path, $oldName, $this->path, $fileName);
                if ($this->dirLog == "error") {
                    $objTemplate->setVariable('CONTENT_STATUS_MESSAGE',$_ARRAYLANG['TXT_MEDIA_MSG_ERROR_EDIT']);
                } else {
                    $this->highlightName[] = $this->dirLog;
                    $objTemplate->setVariable('CONTENT_OK_MESSAGE',$_ARRAYLANG['TXT_MEDIA_MSG_EDIT']);
                }
            }
        }

        // save image
        $this->_objImage->loadImage($this->path.$this->dirLog);
        $this->_objImage->saveNewImage($this->path.$this->dirLog, true);
    }

    /**
     * This method is used for the image preview.
     *
     * @param   array  $arrData  Contains $_GET array.
     * @return  image  On error,
     */
    public function getImage($arrData)
    {
        if (!empty($this->path) && !empty($this->getFile)) {
            // Image loader
            if (!$this->_objImage->loadImage($this->path.$this->getFile)) {
                throw new Exception('Could not load image');
            }

            // Rotate image
            if (!empty($arrData['d'])) {
                $this->_objImage->rotateImage(intval($arrData['d']));
            }

            // Crop image
            if (isset($arrData['x']) && isset($arrData['y']) && !empty($arrData['w']) && !empty($arrData['h'])) {
                $this->_objImage->cropImage(intval($arrData['x']), intval($arrData['y']), intval($arrData['w']), intval($arrData['h']));
            }

            // Resize image
            if (!empty($arrData['rw']) && !empty($arrData['rh']) && !empty($arrData['q'])) {
                if (!$this->_objImage->resizeImage(intval($arrData['rw']), intval($arrData['rh']), intval($arrData['q']))) {
                    throw new Exception('Could not resize image');
                }
            }

            // Show edited image
            if (!$this->_objImage->showNewImage()) {
                throw new Exception('Is not a valid image or image type');
            }
        }

        throw new Exception('Path or file is empty');
    }


    /**
     * Edits and saves an image.
     *
     * @param  array  $arrData  Contains $_POST array.
     * @return bool             True on success, false otherwise.
     */
    public function editImage($arrData)
    {
        global $_ARRAYLANG, $objTemplate;

        $objFile = new File();
        $orgFile = $arrData['orgName'].'.'.$arrData['orgExt'];
        $newName = $arrData['newName'];
        $newFile = $newName.'.'.$arrData['orgExt'];
        \Cx\Lib\FileSystem\FileSystem::clean_path($newFile);

        // If new image name is set, image will be copied. Otherwise, image will be overwritten
        if ($newName != '') {
            $this->fileLog = $objFile->copyFile($this->path, $orgFile, $this->path, $newFile);
            if ($this->fileLog == 'error') {
                throw new Exception('Could not copy image');
            }
        } else {
            $this->fileLog = $orgFile;
        }

        // Edit image
        if (!empty($this->path) && !empty($this->fileLog)) {
            // Image loader
            if (!$this->_objImage->loadImage($this->path.$this->fileLog)) {
                throw new Exception('Could not load image');
            }

            // Rotate image
            if (!empty($arrData['d'])) {
                $this->_objImage->rotateImage(intval($arrData['d']));
            }

            // Crop image
            if (isset($arrData['x']) && isset($arrData['y']) && !empty($arrData['w']) && !empty($arrData['h'])) {
                $this->_objImage->cropImage(intval($arrData['x']), intval($arrData['y']), intval($arrData['w']), intval($arrData['h']));
            }

            // Resize image
            if (!empty($arrData['rw']) && !empty($arrData['rh']) && !empty($arrData['q'])) {
                if (!$this->_objImage->resizeImage(intval($arrData['rw']), intval($arrData['rh']), intval($arrData['q']))) {
                    throw new Exception('Could not resize image');
                }
            }

            // Save new image
            if (!$this->_objImage->saveNewImage($this->path.$this->fileLog, true)) {
                throw new Exception('Is not a valid image or image type');
            }

            // Update (overwrite) thumbnail
            $this->_createThumbnail($this->path.$this->fileLog, true);

            // If no error occured, return true
            return $this->fileLog;
        }

        throw new Exception('Path or file is empty');
    }


    // check if is image
    function _isImage($file)
    {
        if (is_dir($file)) return false;

// TODO: merge this function with isImage of lib/FRAMEWORK/Image.class.php
        if (class_exists('finfo', false)) {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->file($file);

            if (strpos($mimeType, 'image') !== 0) {
                return false;
            }

            $type = substr($mimeType, strpos($mimeType, '/') + 1);
            switch ($type) {
                case 'gif':
                    return 1;
                    break;

                case 'jpeg':
                    return 2;
                    break;

                case 'png':
                    return 3;
                    break;
            }
        }

        if (function_exists('exif_imagetype')) {
            $type = exif_imagetype($file);
        } elseif (function_exists('getimagesize')) {
            $img  = @getimagesize($file);
            if ($img === false) {
                return false;
            }
            $type = $img[2];
        } else {
            return false;
        }

        if ($type >= 1 && $type <= 3) {
            // 1 = gif, 2 = jpg, 3 = png
            return $type;
        } else {
            return false;
        }
    }


    // creates an image thumbnail
    function _createThumbnail($file, $overwrite = false)
    {
        global $_ARRAYLANG;

        $tmpSize    = getimagesize($file);
        $thumbWidth = $this->thumbHeight / $tmpSize[1] * $tmpSize[0];
        $thumb_name = ImageManager::getThumbnailFilename($file);

        $tmp = new ImageManager();
        $tmp->loadImage($file);
        $tmp->resizeImage($thumbWidth, $this->thumbHeight, $this->thumbQuality);
        $tmp->saveNewImage($thumb_name, $overwrite);

        if (!file_exists($thumb_name)) {
            $img     = imagecreate(100, 50);
            $colBody = imagecolorallocate($img, 255, 255, 255);
            ImageFilledRectangle($img, 0, 0, 100, 50, $colBody);
            $colFont = imagecolorallocate($img, 0, 0, 0);
            imagettftext($img, 10, 0, 18, 29, $colFont, self::_getIconPath().'arial.ttf', 'no preview');
            imagerectangle($img, 0, 0, 99, 49, $colFont);
            imagejpeg($img, $thumb_name, $this->thumbQuality);
        }
    }


    // check for manual input in $_GET['path']
    function _pathCheck($path) {
        $check = false;
        if (!empty($path)) {
            foreach ($this->arrWebPaths as $tmp) {
                if (substr($path, 0, strlen($tmp)) == $tmp && file_exists($this->docRoot.$path)) {
                    $check = true;
                }
            }
        }
        if (empty($path) || $check == false) {
            $path = $this->arrWebPaths[$this->archive];
        }
        if (substr($path, -1) != '/') {
            $path = $path.'/';
        }
        return $path;
    }


    // makes the dir tree with variables: icon, name, size, type, date, perm
    function _dirTree($path)
    {
        $dir  = array();
        $file = array();
        // customizing
        $forbidden_files = array('.', '..', '.svn', '.htaccess', 'index.php', '.git', '.DS_Store');

        if (is_dir($path)) {
            $fd = @opendir($path);
            $name = @readdir($fd);
            while ($name !== false) {
                if (!in_array($name, $forbidden_files)) {
                    if (is_dir($path.$name)) {
                        $dirName = $name;
                        if (!\FWSystem::detectUtf8($dirName)) {
                            $dirName = utf8_encode($dirName);
                        }

                        $dir['icon'][] = $this->_getIcon($path.$name);
                        $dir['name'][] = $dirName;
                        $dir['size'][] = $this->_getSize($path.$name);
                        $dir['type'][] = $this->_getType($path.$name);
                        $dir['date'][] = $this->_getDate($path.$name);
                        $dir['perm'][] = $this->_getPerm($path.$name);
                    } elseif (is_file($path.$name)) {
// TODO
// This won't work for .jpg thumbnails made from .png images and other
// ways to create thumbnail file names.  See the Image class.
                        if (substr($name, -6) == '.thumb') {
                            $tmpName = substr($name, 0, strlen($name) - strlen(substr($name, -6)));
                            if (!file_exists($path.$tmpName)) {
                                @unlink($path.$name);
                            }
                        } else {
                            $fileName = $name;
                            if (!\FWSystem::detectUtf8($fileName)) {
                                $fileName = utf8_encode($fileName);
                            }

                            $file['icon'][] = $this->_getIcon($path.$name);
                            $file['name'][] = $fileName;
                            $file['size'][] = $this->_getSize($path.$name);
                            $file['type'][] = $this->_getType($path.$name);
                            $file['date'][] = $this->_getDate($path.$name);
                            $file['perm'][] = $this->_getPerm($path.$name);
                        }
                    }
                }
                $name = @readdir($fd);
            }
            @closedir($fd);
            clearstatcache();
        }
        $dirTree['dir']  = $dir;
        $dirTree['file'] = $file;
        return $dirTree;
    }


    function _sortDirTree($tree)
    {
        $d    = $tree['dir'];
        $f    = $tree['file'];
        $direction = $this->sortDesc ? SORT_DESC : SORT_ASC;

        switch ($this->sortBy) {
            // sort by size
            case 'size':
                @array_multisort($d['size'], $direction, $d['name'], $d['type'], $d['date'], $d['perm'], $d['icon']);
                @array_multisort($f['size'], $direction, $f['name'], $f['type'], $f['date'], $f['perm'], $f['icon']);
                break;
            // sort by type
            case 'type':
                @array_multisort($d['type'], $direction, $d['name'], $d['size'], $d['date'], $d['perm'], $d['icon']);
                @array_multisort($f['type'], $direction, $f['name'], $f['size'], $f['date'], $f['perm'], $f['icon']);
                break;
            //sort by date
            case 'date':
                @array_multisort($d['date'], $direction, $d['name'], $d['size'], $d['type'], $d['perm'], $d['icon']);
                @array_multisort($f['date'], $direction, $f['name'], $f['size'], $f['type'], $f['perm'], $f['icon']);
                break;
            //sort by perm
            case 'perm':
                $direction = !$this->sortDesc ? SORT_DESC : SORT_ASC;
                @array_multisort($d['perm'], $direction, $d['name'], $d['size'], $d['type'], $d['date'], $d['icon']);
                @array_multisort($f['perm'], $direction, $f['name'], $f['size'], $f['type'], $f['date'], $f['icon']);
                break;
            // sort by name
            case 'name':
            default:
              // customizing
              // add the SORT_NATURAL keyword to make sure sort is correct
                @array_multisort($d['name'], $direction, SORT_NATURAL, $d['size'], $d['type'], $d['date'], $d['perm'], $d['icon']);
                @array_multisort($f['name'], $direction, SORT_NATURAL, $f['size'], $f['type'], $f['date'], $f['perm'], $f['icon']);
                break;
        }

        $dirTree['dir']  = $d;
        $dirTree['file'] = $f;
        return $dirTree;
    }


    // designs the sorting icons
    function _sortingIcons()
    {
        $icon         = array(
            'size'    => null,
            'type'    => null,
            'date'    => null,
            'perm'    => null,
            'name'    => null
        );
        $icon1        = '&darr;';     // sort desc
        $icon2        = '&uarr;';     // sort asc
        switch($this->sortBy) {
            case 'size':
                $icon['size'] = $this->sortDesc ? $icon1 : $icon2;
                break;
            case 'type':
                $icon['type'] = $this->sortDesc ? $icon1 : $icon2;
                break;
            case 'date':
                $icon['date'] = $this->sortDesc ? $icon1 : $icon2;
                break;
            case 'perm':
                $icon['perm'] = $this->sortDesc ? $icon1 : $icon2;
                break;
            default:
                $icon['name'] = $this->sortDesc ? $icon1 : $icon2;
        }
        return $icon;
    }


    // designs the sorting class
    function _sortingClass()
    {
        $class         = array(
            'size'    => null,
            'type'    => null,
            'date'    => null,
            'perm'    => null,
            'name'    => null
        );
        $class1        = 'sort';     // sort desc
        $class2        = 'sort';     // sort asc

        switch($this->sortBy) {
            case 'size':
                $class['size'] = $this->sortDesc ? $class1 : $class2;
                break;
            case 'type':
                $class['type'] = $this->sortDesc ? $class1 : $class2;
                break;
            case 'date':
                $class['date'] = $this->sortDesc ? $class1 : $class2;
                break;
            case 'perm':
                $class['perm'] = $this->sortDesc ? $class1 : $class2;
                break;
            default:
                $class['name'] = $this->sortDesc ? $class1 : $class2;
        }
        return $class;
    }


    // gets the icon for the file
    public static function _getIcon($file)
    {
        $icon = '';
        if (is_file($file)) {
            $info = pathinfo($file);
            $icon = strtoupper($info['extension']);
        }

        $arrImageExt        = array('JPEG', 'JPG', 'TIFF', 'GIF', 'BMP', 'PNG');
        $arrVideoExt        = array('3GP', 'AVI', 'DAT', 'FLV', 'FLA', 'M4V', 'MOV', 'MPEG', 'MPG', 'OGG', 'WMV', 'SWF');
        $arrAudioExt        = array('WAV', 'WMA', 'AMR', 'MP3', 'AAC');
        $arrPresentationExt = array('ODP', 'PPT', 'PPTX');
        $arrSpreadsheetExt  = array('CSV', 'ODS', 'XLS', 'XLSX');
        $arrDocumentsExt    = array('DOC', 'DOCX', 'ODT', 'RTF');

        switch (true) {
            case ($icon == 'TXT'):
                $icon = 'Text';
                break;
            case ($icon == 'PDF'):
                $icon = 'Pdf';
                break;
            case in_array($icon, $arrImageExt):
                $icon = 'Image';
                break;
            case in_array($icon, $arrVideoExt):
                $icon = 'Video';
                break;
            case in_array($icon, $arrAudioExt):
                $icon = 'Audio';
                break;
            case in_array($icon, $arrPresentationExt):
                $icon = 'Presentation';
                break;
            case in_array($icon, $arrSpreadsheetExt):
                $icon = 'Spreadsheet';
                break;
            case in_array($icon, $arrDocumentsExt):
                $icon = 'TextDocument';
                break;
            default :
                $icon = 'Unknown';
                break;
        }
        if (is_dir($file)) {
            $icon = 'Folder';
        }

        if (!file_exists(self::_getIconPath().$icon.'.png') or !isset($icon)) {
            $icon = '_blank';
        }
        return $icon;
    }

    /**
     * Returns icon's absolute path
     *
     * @return string
     */
    public static function _getIconPath()
    {
        return ASCMS_CORE_MODULE_PATH.'/media/View/Media/';
    }

    /**
     * Returns icon's web path
     *
     * @return string
     */
    public static function _getIconWebPath()
    {
        return ASCMS_CORE_MODULE_WEB_PATH.'/media/View/Media/';
    }

    // gets the filesize
    function _getSize($file)
    {
        if (is_file($file)) {
            if (@filesize($file)) {
                $size = filesize($file);
            }
        }
        if (is_dir($file)) {
            $size = '[folder]';
        }
        (!isset($size) or empty($size)) ? $size = '0' : '';
        return $size;
    }


    // formats the filesize
    function _formatSize($size)
    {
        $multi = 1024;
        $divid = 1000;
        $arrEnd = array(' Byte', ' Bytes', ' KB', ' MB', ' GB');
        if ($size != '[folder]') {
            if ($size >= ($multi * $multi * $multi)) {
                $size = round($size / ($multi * $multi * $multi), 2);
                $end  = 4;
            }
            elseif ($size >= ($multi * $multi)) {
                $size = round($size / ($multi * $multi), 2);
                $end  = 3;
            }
            elseif ($size >= $multi) {
                $size = round($size / $multi, 2);
                $end  = 2;
            }
            elseif ($size < $multi && $size > 1) {
                $size = $size;
                $end  = 1;
            } else {
                $size = $size;
                $end  = 0;
            }
            if ($size >= $divid) {
                $size = round($size / $multi, 2);
                $end  = $end + 1;
            }
            $size = $size.$arrEnd[$end];
        } else {
            $size = '-';
        }
        return $size;
    }


    // gets the filetype
    function _getType($file)
    {
        if (is_file($file)) {
            $info = pathinfo($file);
            $type = strtoupper($info['extension']);
        }
        if (is_dir($file)) {
            $type = '[folder]';
        }
        (!isset($type) or empty($type)) ? $type = '-' : '';
        return $type;
    }


    // formats the filetype
    function _formatType($type)
    {
        global $_ARRAYLANG;

        if ($type != '-' && $type != '[folder]') {
            $type = $type.'-'.$_ARRAYLANG['TXT_MEDIA_FILE'];
        } elseif ($type == '[folder]') {
            $type = $_ARRAYLANG['TXT_MEDIA_FILE_DIRECTORY'];
        }
        return $type;
    }


    // gets the date of the last modification of the file
    function _getDate($file)
    {
        if (@filectime($file)) {
            $date = filectime($file);
        }
        if (!isset($file)) {
            $date = '';
        }
        return $date;
    }


    // formats the date of the last modification of the file
    function _formatDate($date)
    {
        if (!empty($date)) {
            $date = date(ASCMS_DATE_FORMAT_DATETIME, $date);
        } else {
            $date = '-';
        }
        return $date;
    }


    // gets the permission of the file
    function _getPerm($file)
    {
        if (@fileperms($file)) {
            $perm = substr(decoct(fileperms($file)), -4);
        }
        if (!isset($perm)) {
            $perm = '';
        }
        return $perm;
    }


    // formats the permission of the file
    function _formatPerm($perm, $key)
    {
        if (!empty($perm)) {
            $per   = array();
            $per[] = $perm[1];
            $per[] = $perm[2];
            $per[] = $perm[3];

            ($key == 'dir')  ? $perm = 'd'       : '';
            ($key == 'file') ? $perm = '&minus;' : '';
            foreach ($per as $out) {
                switch($out) {
                    case 7:
                        $perm .= ' rwx';
                        break;
                    case 6:
                        $perm .= ' rw&minus;';
                        break;
                    case 5:
                        $perm .= ' r&minus;x';
                        break;
                    case 4:
                        $perm .= ' r&minus;&minus;';
                        break;
                    case 3:
                        $perm .= ' &minus;wx';
                        break;
                    case 2:
                        $perm .= ' &minus;w&minus;';
                        break;
                    case 1:
                        $perm .= ' &minus;&minus;x';
                        break;
                    default:
                        $perm .= ' &minus;&minus;&minus;';
                }
            }
        } else {
            $perm = '-';
        }
        return $perm;
    }


    function _getJavaScriptCodePreview()
    {
        global $_ARRAYLANG;

        JS::activate('jquery');

        $delete_msg = $_ARRAYLANG['TXT_MEDIA_CONFIRM_DELETE_2'];
        $csrfCode   = CSRF::code();
        $code       = <<<END
                    <script type="text/javascript">
                    /* <![CDATA[ */
                        function preview(file, width, height)
                        {
                            var f = file;
                            var w = width + 10;
                            var h = height + 10;
                            var l = (screen.availWidth - width) / 2;
                            var t = (screen.availHeight - 50 - height) / 2;
                            prev  = window.open('', '', "width="+w+", height="+h+", left="+l+", top="+t+", scrollbars=no, toolbars=no, status=no, resizable=yes");
                            prev.document.open();
                            prev.document.write('<html><title>'+f+'<\/title><body style="margin: 5px; padding: 0px;">');
                            prev.document.write('<img src=\"'+f+'\" width='+width+' height='+height+' alt=\"'+f+'\">');
                            prev.document.write('<\/body><\/html>');
                            prev.document.close();
                            prev.focus();
                        }

                        function mediaConfirmDelete(file)
                        {
                            if(confirm('$delete_msg')) {
                                \$J(document.fileList.deleteMedia).attr('value', '1');
                                \$J(document.fileList.file).attr('value', file);
                                document.fileList.action = 'index.php?cmd=media&archive=$this->archive&path=$this->webPath&csrf=$csrfCode';
                                document.fileList.submit();
                            }
                        }

                        /*
                           **  Returns the caret (cursor) position of the specified text field.
                           **  Return value range is 0-oField.length.
                           */
                        function doGetCaretPosition (oField) {
                                var iCaretPos = 0;
                                // IE Support
                                if (document.selection) {
                                        var oSel = document.selection.createRange ();
                                        oSel.moveStart ('character', -oField.value.length);
                                        iCaretPos = oSel.text.length;
                                } else if (oField.selectionStart || oField.selectionStart == '0') {
                                        // Firefox support
                                        iCaretPos = oField.selectionStart;
                                }
                                return (iCaretPos);
                        }

                        /*
                        **  Sets the caret (cursor) position of the specified text field.
                        **  Valid positions are 0-oField.length.
                        */
                        function doSetCaretPosition(oField, pos){
                                if (oField.setSelectionRange) {
                                        oField.setSelectionRange(pos,pos);
                                } else if (oField.createTextRange) {
                                        var range = oField.createTextRange();
                                        range.collapse(true);
                                        range.moveEnd('character', pos);
                                        range.moveStart('character', pos);
                                        range.select();
                                }
                        }

                        \$J(document).ready(function() {

                            \$J('#filename').live('keyup', function(event){
                                pos = doGetCaretPosition(document.getElementById('filename'));
                                \$J(this).val(\$J(this).val().replace(/[^0-9a-zA-Z_\-\. ]/g,'_'));
                                doSetCaretPosition(document.getElementById('filename'), pos);
                                //submit the input value on hitting Enter key to rename action
                                if(event.keyCode == 13) {
                                    var newFileName = \$J('#filename').val();
                                    var oldFileName = \$J('#oldFilename').val();
                                    var actionPath  = \$J('#actionPath').val();
                                    var fileExt     = \$J('#fileExt').val();
                                    if (newFileName != oldFileName && \$J.trim(newFileName) != "") {
                                        actionPath += '&newfile='+newFileName+fileExt;
                                        window.location = actionPath;
                                    } else {
                                        \$J('#filename').focusout();
                                    }
                                }
                                return true;
                            });

                            \$J('.rename_btn').click(function(){
                                if (\$J('#filename').length == 0) {
                                    \$J(this).parent().parent().find('.file_name a').css('display','none');
                                    file_name = "";
                                    file = \$J(this).parent().parent().find('.file_name a').html();
                                    fileSplitLength = file.split('.').length;
                                    isFolder = (\$J(this).parent().parent().find('.file_size').html() == '&nbsp;-') ? 1 : 0;

                                    //Display Filename in input box without file extension (with multi dots in filename)
                                    file_ext = (isFolder != 1 && fileSplitLength > 1) ?
                                                    ("."+file.split('.')[fileSplitLength-1])
                                                    : "";
                                    loop     = (isFolder != 1 && fileSplitLength > 1) ?
                                                    (fileSplitLength - 1)
                                                    : fileSplitLength;

                                    for (i=0; i < loop; i++) {
                                        file_name += i > 0 ? "." : "";
                                        file_name += file.split('.')[i];
                                    }
                                    actionPath = 'index.php?section=$this->archive&act=rename&path=$this->webPath&file='+file_name;

                                    if (\$J(this).parent().parent().find('.file_size').html() != '&nbsp;-') {
                                        actionPath += file_ext;
                                    }
                                    //Rename Form
                                    \$J(this).parent().parent().find('.file_name')
                                    .append('<div id="insertform"><input type="text" id="filename" name="filename" style="padding:0px;" value="'+file_name+'"/>'+file_ext
                                            +'<input type="hidden" value="'+actionPath+'" id="actionPath" name="actionPath" />'
                                            +'<input type="hidden" value="'+file_name+'" id="oldFilename" name="oldFilename" />'
                                            +'<input type="hidden" value="'+file_ext+'" id="fileExt" name="fileExt" /></div>');
                                    \$J("#filename").focus();
                                }
                            });

                            //Hide added form and display file name link on blur
                            \$J("#filename").live('blur',function(){
                                \$J(this).parent().parent().find('a').css('display','block');
                                \$J(this).parent().remove();
                            });
                        });
                    /* ]]> */
                    </script>
END;
        return $code;
    }

    /**
     * Create an array containing all settings of the media-module.
     * Example: $arrSettings[$strSettingName] for the content of $strSettingsName
     * @global  ADONewConnection
     * @return  array       $arrReturn
     */
    function createSettingsArray()
    {
        global $objDatabase;

        $arrReturn = array();
        $objResult = $objDatabase->Execute('SELECT  name,
                                                    value
                                            FROM    '.DBPREFIX.'module_media_settings
                                        ');
        if ($objResult !== false) {
            while (!$objResult->EOF) {
                $arrReturn[$objResult->fields['name']] = stripslashes(htmlspecialchars($objResult->fields['value'], ENT_QUOTES, CONTREXX_CHARSET));
                $objResult->MoveNext();
            }
        }
        return $arrReturn;
    }

    /**
     * this is called as soon as uploads have finished.
     * takes care of moving them to the right folder
     *
     * @return string the directory to move to
     */
    public static function uploadFinished($tempPath, $tempWebPath, $data, $uploadId, $fileInfos, $response){
        $path = $data['path'];
        $webPath = $data['webPath'];

        //we remember the names of the uploaded files here. they are stored in the session afterwards,
        //so we can later display them highlighted.
        $arrFiles = array();

        //rename files, delete unwanted
        $arrFilesToRename = array(); //used to remember the files we need to rename
        $h = opendir($tempPath);
        if ($h) {
            while(false !== ($file = readdir($h))) {
                //delete potentially malicious files
// TODO: this is probably an overhead, because the uploader might already to this. doesn't it?
                if(!FWValidator::is_file_ending_harmless($file)) {
                    @unlink($file);
                    continue;
                }
                //skip . and ..
                if($file == '.' || $file == '..')
                    continue;

                //clean file name
                $newName = $file;
                \Cx\Lib\FileSystem\FileSystem::clean_path($newName);

                //check if file needs to be renamed
                if (file_exists($path.$newName)) {
                    $info     = pathinfo($newName);
                    $exte     = $info['extension'];
                    $exte     = (!empty($exte)) ? '.'.$exte : '';
                    $part1    = $info['filename'];
                    if (empty($_REQUEST['uploadForceOverwrite']) || !intval($_REQUEST['uploadForceOverwrite'] > 0)) {
                        $newName = $part1.'_'.time().$exte;
                    }
                }

                //if the name has changed, the file needs to be renamed afterwards
                if($newName != $file)
                    $arrFilesToRename[$file] = $newName;

                array_push($arrFiles, $newName);
            }
        }

        //rename files where needed
        foreach($arrFilesToRename as $oldName => $newName){
            rename($tempPath.'/'.$oldName, $tempPath.'/'.$newName);
        }

        //remeber the uploaded files
        $_SESSION["media_upload_files_$uploadId"] = $arrFiles;

        /* unwanted files have been deleted, unallowed filenames corrected.
           we can now simply return the desired target path, as only valid
           files are present in $tempPath                                   */

        return array($data['path'],$data['webPath']);
    }

    /**
     * Returns the image settings array.
     *
     * @global  object  $objDatabase       ADONewConnection
     * @return  array   $arrImageSettings
     */
    public function getImageSettings()
    {
        global $objDatabase;

        $query = '
            SELECT `name`, `value`
            FROM `'.DBPREFIX.'settings_image`
        ';
        $objResult = $objDatabase->Execute($query);

        $arrImageSettings = array();
        if ($objResult === false) {
            throw new Exception($objDatabase->ErrorMsg());
        }
        while (!$objResult->EOF) {
            $arrImageSettings[$objResult->fields['name']] = intval($objResult->fields['value']);
            $objResult->MoveNext();
        }

        return $arrImageSettings;
    }

}
?>
