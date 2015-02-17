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
 * Media Manager
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author        Comvation Development Team <info@comvation.com>
 * @version       1.0
 * @package     contrexx
 * @subpackage  coremodule_media
 * @todo        Edit PHP DocBlocks!
 */


/**
 * Media Manager
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author        Comvation Development Team <info@comvation.com>
 * @version       1.0
 * @access        public
 * @package     contrexx
 * @subpackage  coremodule_media
 */
class MediaManager extends MediaLibrary
{
    public $_objTpl;                       // var for the template object
    public $pageTitle;                     // var for the title of the active page
    public $statusMessage;                 // var for the status message
    
    public $arrPaths;                      // array paths
    public $arrWebPaths;                   // array web paths

    public $getCmd;                        // $_GET['cmd']
    public $getAct;                        // $_GET['act']
    public $getPath;                       // $_GET['path']
    public $getFile;                       // $_GET['file']

    public $path;                          // current path
    public $webPath;                       // current web path
    public $docRoot;                       // document root
    public $archive;

    var $highlightName     = array();   // highlight added name
    var $highlightColor    = '#d8ffca'; // highlight color for added name [#d8ffca]
    var $_strOkMessage  = '';           // success message
    var $_strErrorMessage  = '';        // error message


    /**
     * PHP5 constructor
     * @param  string  $template
     * @param  array   $_ARRAYLANG
     * @access public
     */
    function __construct($pageContent, $archive)
    {
        $this->_arrSettings =$this->createSettingsArray();

        $this->archive = (intval(substr($archive,-1,1)) == 0) ? 'media1' : $archive;
                
        $this->arrPaths = array(ASCMS_MEDIA1_PATH . '/',
                                    ASCMS_MEDIA2_PATH . '/',
                                    ASCMS_MEDIA3_PATH . '/',
                                    ASCMS_MEDIA4_PATH . '/');

        $this->arrWebPaths = array('media1' => ASCMS_MEDIA1_WEB_PATH . '/',
                                    'media2' => ASCMS_MEDIA2_WEB_PATH . '/',
                                    'media3' => ASCMS_MEDIA3_WEB_PATH . '/',
                                    'media4' => ASCMS_MEDIA4_WEB_PATH . '/');
        $this->docRoot = ASCMS_PATH;

        // sigma template
        $this->pageContent = $pageContent;
        $this->_objTpl     = new \Cx\Core\Html\Sigma('.');
        CSRF::add_placeholder($this->_objTpl);
        $this->_objTpl->setErrorHandling(PEAR_ERROR_DIE);
        $this->_objTpl->setTemplate($this->pageContent, true, true);

        // get variables
        $this->getAct  = (isset($_GET['act']) and !empty($_GET['act']))   ? trim($_GET['act'])  : '';
        $this->getFile = (isset($_GET['file']) and !empty($_GET['file'])) ? \Cx\Lib\FileSystem\FileSystem::sanitizeFile(trim($_GET['file'])) : '';
        if ($this->getFile === false) $this->getFile = '';
        $this->sortBy = !empty($_GET['sort']) ? trim($_GET['sort']) : 'name';
        $this->sortDesc = !empty($_GET['sort_desc']);
    }


    /**
    * checks and cleans the web path
    *
    * @param  string default web path
    * @return string  cleaned web path
    */
    function getWebPath($defaultWebPath)
    {
        $webPath = $defaultWebPath;
        if (isset($_GET['path']) AND !empty($_GET['path']) AND !stristr($_GET['path'],'..')) {
            $webPath = trim($_GET['path']);
        }
        if (substr($webPath, 0, strlen($defaultWebPath)) != $defaultWebPath || !file_exists($this->docRoot.$webPath)) {
            $webPath = $defaultWebPath;
        }
        return $webPath;
    }


    /**
     * Gets the requested page
     * @global     array     $_ARRAYLANG,$_CONFIG
     * @return    string    parsed content
     */
    function getMediaPage()
    {
        global $_ARRAYLANG, $template;
        $this->webPath = $this->getWebPath($this->arrWebPaths[$this->archive]);
        $this->path = ASCMS_PATH.$this->webPath;
        $this->getCmd = !empty($_GET['cmd']) ? '&amp;cmd='.htmlentities($_GET['cmd'], ENT_QUOTES, CONTREXX_CHARSET) : '';

        $this->_overviewMedia();
        $this->_parseMessages();
        return $this->_objTpl->get();
    }


    /**
    * Overview Media Data
    *
    * @global     array     $_CONFIG
    * @global     array     $_ARRAYLANG
    * @return    string    parsed content
    */
    function _overviewMedia()
    {
        global $_CONFIG, $_ARRAYLANG;

        switch($this->getAct) {
        case 'download':
            $this->_downloadMedia();
            break;
        case 'newDir':
            $this->_createDirectory($_POST['media_directory_name']);
            break;
        case 'upload':
            $this->_uploadFiles();
            break;
        case 'rename':
            $this->_renameFiles();
            break;
        case 'delete':
            $this->_deleteFiles();
            break;
        default:
        }

        // tree navigation
        $tmp = $this->arrWebPaths[$this->archive];
        if (substr($this->webPath, 0, strlen($tmp)) == $tmp) {
            $this->_objTpl->setVariable(array(  // navigation #1
                'MEDIA_TREE_NAV_MAIN'      => "Home /", //$this->arrWebPaths[$x],
                'MEDIA_TREE_NAV_MAIN_HREF' => CONTREXX_SCRIPT_PATH.'?section='.$this->archive.$this->getCmd.'&amp;path=' . rawurlencode($this->arrWebPaths[$this->archive])
            ));

            if (strlen($this->webPath) != strlen($tmp)) {
                $tmpPath = substr($this->webPath, -(strlen($this->webPath) - strlen($tmp)));
                $tmpPath = explode('/', $tmpPath);
                $tmpLink = '';
                foreach ($tmpPath as $path) {
                    if (!empty($path)) {
                        $tmpLink .= $path.'/';
                        $this->_objTpl->setVariable(array(  // navigation #2
                            'MEDIA_TREE_NAV_DIR'      => $path,
                            'MEDIA_TREE_NAV_DIR_HREF' => CONTREXX_SCRIPT_PATH.'?section=' . $this->archive . $this->getCmd . '&amp;path=' . rawurlencode($this->arrWebPaths[$this->archive] . $tmpLink)
                        ));
                        $this->_objTpl->parse('mediaTreeNavigation');
                    }
                }
            }
        }

        if (isset($_GET['deletefolder']) && $_GET['deletefolder'] = "success"){
            $this->_strOkMessage = $_ARRAYLANG['TXT_MEDIA_FOLDER_DELETED_SUCESSFULLY'];
        }
        if (!empty($_GET['highlightFiles'])) {
            $this->highlightName = array_merge($this->highlightName, array_map('basename', json_decode(contrexx_stripslashes(urldecode($_GET['highlightFiles'])))));
        }
        
        // media directory tree
        $i = 0;
        $dirTree = $this->_dirTree($this->path);
        $dirTree = $this->_sortDirTree($dirTree);
        foreach (array_keys($dirTree) as $key) {
            if (is_array($dirTree[$key]['icon'])) {
                for ($x = 0; $x < count($dirTree[$key]['icon']); $x++) {
                    $class = ($i % 2) ? 'row2' : 'row1';
                     // highlight
                    if (in_array($dirTree[$key]['name'][$x], $this->highlightName)) {
                        $class .= '" style="background-color: ' . $this->highlightColor . ';';
                    }

                    if (!$this->manageAccessGranted()) {
                        //if the user is not allowed to delete or rename files -- hide those blocks
                        if ($this->_objTpl->blockExists('manage_access_option')) {
                            $this->_objTpl->hideBlock('manage_access_option');
                        }
                    }
                    $this->_objTpl->setVariable(array(  // file
                        'MEDIA_DIR_TREE_ROW'  => $class,
                        'MEDIA_FILE_ICON'     => self::_getIconWebPath() . $dirTree[$key]['icon'][$x] . '.png',
                        'MEDIA_FILE_NAME'     => $dirTree[$key]['name'][$x],
                        'MEDIA_FILE_SIZE'     => $this->_formatSize($dirTree[$key]['size'][$x]),
                        'MEDIA_FILE_TYPE'     => $this->_formatType($dirTree[$key]['type'][$x]),
                        'MEDIA_FILE_DATE'     => $this->_formatDate($dirTree[$key]['date'][$x]),
                        'MEDIA_RENAME_TITLE'  => $_ARRAYLANG['TXT_MEDIA_RENAME'],
                        'MEDIA_DELETE_TITLE'  => $_ARRAYLANG['TXT_MEDIA_DELETE'],
                    ));
                    $tmpHref = $delHref = '';
                    if ($key == 'dir') {
                        $tmpHref = CONTREXX_SCRIPT_PATH.'?section=' . $this->archive . $this->getCmd . '&amp;path=' . rawurlencode($this->webPath . $dirTree[$key]['name'][$x] . '/');
                        $delHref = CONTREXX_SCRIPT_PATH.'?section=' . $this->archive . $this->getCmd . '&amp;act=delete&amp;path=' . rawurlencode($this->webPath . $dirTree[$key]['name'][$x] . '/');
                    } elseif ($key == 'file') {
                        $delHref = CONTREXX_SCRIPT_PATH.'?section=' . $this->archive . $this->getCmd . '&amp;act=delete&amp;path=' . rawurlencode($this->webPath) . '&amp;file='. rawurlencode($dirTree[$key]['name'][$x]);
                        if ($this->_isImage($this->path . $dirTree[$key]['name'][$x])) {
                            $tmpSize = getimagesize($this->path . $dirTree[$key]['name'][$x]);
                            $tmpHref = 'javascript: preview(\'' . $this->webPath . $dirTree[$key]['name'][$x] . '\', ' . $tmpSize[0] . ', ' . $tmpSize[1] . ');';
                        } else {
                            $tmpHref = CONTREXX_SCRIPT_PATH.'?section=' . $this->archive . '&amp;act=download&amp;path=' . rawurlencode($this->webPath) . '&amp;file='. rawurlencode($dirTree[$key]['name'][$x]);
                        }
                    }
                    $this->_objTpl->setVariable(array(
                        'MEDIA_FILE_NAME_HREF'  => $tmpHref,
                        'MEDIA_FILE_DELETE_HREF'=> $delHref,
                    ));
                    $this->_objTpl->parse('mediaDirectoryTree');
                    $i++;
                }
            }
        }

        // empty dir or php safe mode restriction
        if ($i == 0 && !@opendir($this->rootPath)) {
            $tmpMessage = (!@opendir($this->path)) ? 'PHP Safe Mode Restriction or wrong path' : $_ARRAYLANG['TXT_MEDIA_DIR_EMPTY'];

            $this->_objTpl->setVariable(array(
                'TXT_MEDIA_DIR_EMPTY' => $tmpMessage,
                'MEDIA_SELECT_STATUS' => ' disabled'
            ));
            $this->_objTpl->parse('mediaEmptyDirectory');
        }

        // parse variables
        $tmpHref = CONTREXX_SCRIPT_PATH.'?section=' . $this->archive . $this->getCmd . '&amp;path=' . rawurlencode($this->webPath);
        $tmpIcon = $this->_sortingIcons();

        if ($this->_objTpl->blockExists('manage_access_header')) {
            if ($this->manageAccessGranted()) {
                $this->_objTpl->touchBlock('manage_access_header');
            } else {
                $this->_objTpl->hideBlock('manage_access_header');
            }
        }
        $this->_objTpl->setVariable(array(  // parse dir content
            'MEDIA_NAME_HREF'     => $tmpHref.'&amp;sort=name&amp;sort_desc='.($this->sortBy == 'name' && !$this->sortDesc),
            'MEDIA_SIZE_HREF'     => $tmpHref.'&amp;sort=size&amp;sort_desc='.($this->sortBy == 'size' && !$this->sortDesc),
            'MEDIA_TYPE_HREF'     => $tmpHref.'&amp;sort=type&amp;sort_desc='.($this->sortBy == 'type' && !$this->sortDesc),
            'MEDIA_DATE_HREF'     => $tmpHref.'&amp;sort=date&amp;sort_desc='.($this->sortBy == 'date' && !$this->sortDesc),
            'MEDIA_PERM_HREF'     => $tmpHref.'&amp;sort=perm&amp;sort_desc='.($this->sortBy == 'perm' && !$this->sortDesc),
            'TXT_MEDIA_FILE_NAME' => $_ARRAYLANG['TXT_MEDIA_FILE_NAME'],
            'TXT_MEDIA_FILE_SIZE' => $_ARRAYLANG['TXT_MEDIA_FILE_SIZE'],
            'TXT_MEDIA_FILE_TYPE' => $_ARRAYLANG['TXT_MEDIA_FILE_TYPE'],
            'TXT_MEDIA_FILE_DATE' => $_ARRAYLANG['TXT_MEDIA_FILE_DATE'],
            'TXT_MEDIA_FILE_PERM' => $_ARRAYLANG['TXT_MEDIA_FILE_PERM'],
            'MEDIA_NAME_ICON'     => $tmpIcon['name'],
            'MEDIA_SIZE_ICON'     => $tmpIcon['size'],
            'MEDIA_TYPE_ICON'     => $tmpIcon['type'],
            'MEDIA_DATE_ICON'     => $tmpIcon['date'],
            'MEDIA_PERM_ICON'     => $tmpIcon['perm'],
            'MEDIA_JAVASCRIPT'    => $this->_getJavaScriptCodePreview()
        ));
        if (!$this->uploadAccessGranted()) {
            // if user not allowed to upload files and creating folders -- hide that blocks
            if ($this->_objTpl->blockExists('media_simple_file_upload')) {
                $this->_objTpl->hideBlock('media_simple_file_upload');
            }
            if ($this->_objTpl->blockExists('media_advanced_file_upload')) {
                $this->_objTpl->hideBlock('media_advanced_file_upload');
            }
            if ($this->_objTpl->blockExists('media_create_directory')) {
                $this->_objTpl->hideBlock('media_create_directory');
            }
        }
        else {
            // forms for uploading files and creating folders
            if ($this->_objTpl->blockExists('media_simple_file_upload')) {
                //data we want to remember for handling the uploaded files
                $data = array(
                    'path' => $this->path,
                    'webPath' => $this->webPath
                );

                $comboUp = UploadFactory::getInstance()->newUploader('exposedCombo');
                $comboUp->setFinishedCallback(array(ASCMS_CORE_MODULE_PATH.'/media/mediaLib.class.php', 'MediaLibrary', 'uploadFinished'));
                $comboUp->setData($data);
                //set instance name to combo_uploader so we are able to catch the instance with js
                $comboUp->setJsInstanceName('exposed_combo_uploader');

                $this->_objTpl->setVariable(array(
                    'TXT_MEDIA_ADD_NEW_FILE'    => $_ARRAYLANG['TXT_MEDIA_ADD_NEW_FILE'],
                    'COMBO_UPLOADER_CODE'       => $comboUp->getXHtml(true),
                    'REDIRECT_URL'              => '?section='.$_REQUEST['section'].'&path='.contrexx_raw2encodedUrl($this->webPath)
                ));
                $this->_objTpl->parse('media_simple_file_upload');
            }

            if ($this->_objTpl->blockExists('media_advanced_file_upload')) {
                $this->_objTpl->hideBlock('media_advanced_file_upload');
            }
            // create directory
            $this->_objTpl->setVariable(array(
                'TXT_MEDIA_CREATE_DIRECTORY'        => $_ARRAYLANG['TXT_MEDIA_CREATE_DIRECTORY'],
                'TXT_MEDIA_CREATE_NEW_DIRECTORY'    => $_ARRAYLANG['TXT_MEDIA_CREATE_NEW_DIRECTORY'],
                'MEDIA_CREATE_DIRECTORY_URL'        => CONTREXX_SCRIPT_PATH . '?section=' . $this->archive . $this->getCmd . '&amp;act=newDir&amp;path=' . $this->webPath
            ));
            $this->_objTpl->parse('media_create_directory');
        }
    }

    /**
     * Chaeck access from settings.
     * If setting value is number then check access using Permission
     * If setting value is 'on' then return true
     * Else return false
     *
     * @return     boolean  true if access gented and false if access denied
     */
    private function uploadAccessGranted()
    {
        $uploadAccessSetting = $this->_arrSettings[$this->archive . '_frontend_changable'];
        if (is_numeric($uploadAccessSetting)
           && Permission::checkAccess(intval($uploadAccessSetting), 'dynamic', true)) { // access group
            return true;
        } else if ($uploadAccessSetting == 'on') {
            return true;
        }
        return false;
    }

    /**
     * Check Rename/Delete permission from settings.
     * If setting value is number then check access using Permission
     * If setting value is 'on' then return true
     * Else return false
     *
     * @return     boolean  true if access gented and false if access denied
     */
    private function manageAccessGranted()
    {
        $manageAccessSetting = $this->_arrSettings[$this->archive . '_frontend_managable'];
        if (is_numeric($manageAccessSetting)
           && Permission::checkAccess(intval($manageAccessSetting), 'dynamic', true)) { // access group
            return true;
        } else if ($manageAccessSetting == 'on') {
            return true;
        }
        return false;
    }

    /**
     * Format file size
     *
     * @global     array    $_ARRAYLANG
     * @param      int      $bytes
     * @return     string   formated size
     */
    private function getFormatedFileSize($bytes)
    {
        global $_ARRAYLANG;

        if (!$bytes) {
            return $_ARRAYLANG['TXT_MEDIA_UNKNOWN'];
        }

        $exp = log($bytes, 1024);

        if ($exp < 1) {
            return $bytes.' '.$_ARRAYLANG['TXT_MEDIA_BYTES'];
        } elseif ($exp < 2) {
            return round($bytes/1024, 2).' '.$_ARRAYLANG['TXT_MEDIA_KBYTE'];
        } elseif ($exp < 3) {
            return round($bytes/pow(1024, 2), 2).' '.$_ARRAYLANG['TXT_MEDIA_MBYTE'];
        } else {
            return round($bytes/pow(1024, 3), 2).' '.$_ARRAYLANG['TXT_MEDIA_GBYTE'];
        }
    }

    /**
     * Create directory
     *
     * @global     array    $_ARRAYLANG
     * @param      string   $dir_name
     */
    function _createDirectory($dir_name)
    {
        global $_ARRAYLANG;

        if (empty($dir_name)) {
            if (!isset($_GET['highlightFiles'])) {
                $this->_strErrorMessage = $_ARRAYLANG['TXT_MEDIA_EMPTY_DIR_NAME'];
            }
            return;
        } else {
            $dir_name = contrexx_stripslashes($dir_name);
        }

        if (!$this->uploadAccessGranted()) {
            $this->_strErrorMessage = $_ARRAYLANG['TXT_MEDIA_DIRCREATION_NOT_ALLOWED'];
            return;
        }

        $obj_file = new File();
        $dir_name = \Cx\Lib\FileSystem\FileSystem::replaceCharacters($dir_name);
        $creationStatus = $obj_file->mkDir($this->path, $this->webPath, $dir_name);
        if ($creationStatus != "error") {
            $this->highlightName[] = $dir_name;
            $this->_strOkMessage = $_ARRAYLANG['TXT_MEDIA_MSG_NEW_DIR'];
        } else {
            $this->_strErrorMessage = $_ARRAYLANG['TXT_MEDIA_MSG_ERROR_NEW_DIR'];
        }
    }

    /**
     * Adding success and error messages to template
     */
    private function _parseMessages()
    {
        $this->_objTpl->setVariable(array(
            'MEDIA_MSG_OK'      => $this->_strOkMessage,
            'MEDIA_MSG_ERROR'   => $this->_strErrorMessage
        ));
    }

    /**
     * Upload files
     */
    function _uploadFiles()
    {
        global $_ARRAYLANG;

        // check permissions
        if (!$this->uploadAccessGranted()) {
            $this->_strErrorMessage = $_ARRAYLANG['TXT_MEDIA_DIRCREATION_NOT_ALLOWED'];
            return;
        }
        $this->processFormUpload();
    }

    /**
     * Process upload form
     *
     * @global     array    $_ARRAYLANG
     * @return     boolean  true if file uplod successfully and false if it failed
     */
    private function processFormUpload()
    {
        global $_ARRAYLANG;

        $inputField = 'media_upload_file';
        if (!isset($_FILES[$inputField]) || !is_array($_FILES[$inputField])) {
            return false;
        }

        $fileName = !empty($_FILES[$inputField]['name']) ? contrexx_stripslashes($_FILES[$inputField]['name']) : '';
        $fileTmpName = !empty($_FILES[$inputField]['tmp_name']) ? $_FILES[$inputField]['tmp_name'] : '';

        switch ($_FILES[$inputField]['error']) {
            case UPLOAD_ERR_INI_SIZE:
                $this->_strErrorMessage = sprintf($_ARRAYLANG['TXT_MEDIA_FILE_SIZE_EXCEEDS_LIMIT'], htmlentities($fileName, ENT_QUOTES, CONTREXX_CHARSET), $this->getFormatedFileSize(FWSystem::getMaxUploadFileSize()));
                break;

            case UPLOAD_ERR_FORM_SIZE:
                $this->_strErrorMessage = sprintf($_ARRAYLANG['TXT_MEDIA_FILE_TOO_LARGE'], htmlentities($fileName, ENT_QUOTES, CONTREXX_CHARSET));
                break;

            case UPLOAD_ERR_PARTIAL:
                $this->_strErrorMessage = sprintf($_ARRAYLANG['TXT_MEDIA_FILE_CORRUPT'], htmlentities($fileName, ENT_QUOTES, CONTREXX_CHARSET));
                break;

            case UPLOAD_ERR_NO_FILE:
                $this->_strErrorMessage = $_ARRAYLANG['TXT_MEDIA_NO_FILE'];
                continue;
                break;

            default:
                if (!empty($fileTmpName)) {
                    $suffix  = '';
                    $file    = $this->path . $fileName;
                    $arrFile = pathinfo($file);
                    $i       = 0;
                    while (file_exists($file)) {
                        $suffix = '-' . (time() + (++$i));
                        $file   = $this->path . $arrFile['filename'] . $suffix . '.' . $arrFile['extension'];
                    }

                    if (FWValidator::is_file_ending_harmless($fileName)) {
                        $fileExtension = $arrFile['extension'];

                        if (@move_uploaded_file($fileTmpName, $file)) {
                            $fileName = $arrFile['filename'];
                            $obj_file = new File();
                            $obj_file->setChmod($this->path, $this->webPath, $fileName);
                            $this->_strOkMessage = $_ARRAYLANG['TXT_MEDIA_FILE_UPLOADED_SUCESSFULLY'];
                            return true;
                        } else {
                            $this->_strErrorMessage = sprintf($_ARRAYLANG['TXT_MEDIA_FILE_UPLOAD_FAILED'], htmlentities($fileName, ENT_QUOTES, CONTREXX_CHARSET));
                        }
                    } else {
                        $this->_strErrorMessage = sprintf($_ARRAYLANG['TXT_MEDIA_FILE_EXTENSION_NOT_ALLOWED'], htmlentities($fileName, ENT_QUOTES, CONTREXX_CHARSET));
                    }
                }
                break;
        }
        return false;
    }

    /**
     * Rename files
     *
     * @global     array    $_ARRAYLANG
     * @return     boolean  true if file renamed successfully and false if it failed
     */
    function _renameFiles()
    {
        global $_ARRAYLANG;
        
        // check permissions
        if (!$this->manageAccessGranted()) {
            $this->_strErrorMessage = $_ARRAYLANG['TXT_MEDIA_DIRCREATION_NOT_ALLOWED'];
            return false;
        }
        if (isset($_GET['newfile']) && file_exists($this->path.$this->getFile)) {
            $newFile = trim(preg_replace('/[^a-z0-9_\-\. ]/i', '_', $_GET['newfile']));
            if ($newFile != "") {
                if (!file_exists($this->path.$newFile)) {
                    if (rename($this->path.$this->getFile, $this->path.$newFile)) {
                        $this->_strOkMessage = sprintf($_ARRAYLANG['TXT_MEDIA_FILE_RENAME_SUCESSFULLY'], '<strong>'.htmlentities($this->getFile, ENT_QUOTES, CONTREXX_CHARSET).'</strong>', '<strong>'.htmlentities($newFile, ENT_QUOTES, CONTREXX_CHARSET).'</strong>');
                    } else {
                        $this->_strErrorMessage = $_ARRAYLANG['TXT_MEDIA_FILE_NAME_INVALID'];
                    }
                } else {
                    $this->_strErrorMessage = sprintf($_ARRAYLANG['TXT_MEDIA_FILE_AREALDY_EXSIST'], '<strong>'.htmlentities($newFile, ENT_QUOTES, CONTREXX_CHARSET).'</strong>');
                }
            } else {
                $this->_strErrorMessage = $_ARRAYLANG['TXT_MEDIA_FILE_EMPTY_NAME'];
            }
        } else {
            $this->_strErrorMessage = sprintf($_ARRAYLANG['TXT_MEDIA_FILE_NOT_FOUND'], htmlentities($this->getFile, ENT_QUOTES, CONTREXX_CHARSET));
        }
    }

    /**
     * Delete files
     *
     * @global     array    $_ARRAYLANG
     * @return     boolean  true if file deleted successfully and false if it failed
     */
    function _deleteFiles()
    {
        global $_ARRAYLANG;

        // check permissions
        if (!$this->manageAccessGranted()) {
            $this->_strErrorMessage = $_ARRAYLANG['TXT_MEDIA_DIRCREATION_NOT_ALLOWED'];
            return false;
        }

        if (isset($_GET['path'])) {
            if (isset($_GET['file'])) {
                $filePath = $this->path.$this->getFile;
                if (unlink($filePath)) {
                    $this->_strOkMessage = sprintf($_ARRAYLANG['TXT_MEDIA_FILE_DELETED_SUCESSFULLY'], '<strong>'.htmlentities($this->getFile, ENT_QUOTES, CONTREXX_CHARSET).'</strong>');
                    return true;
                } else {
                    $this->_strErrorMessage = sprintf($_ARRAYLANG['TXT_MEDIA_FILE_NOT_FOUND'], htmlentities($this->getFile, ENT_QUOTES, CONTREXX_CHARSET));
                    return false;
                }
            } else {
                $this->deleteDirectory($this->path);
            }
        }
    }

     /**
     * Delete Selected Folder and its contents recursively upload form
     *
     * @global     array    $_ARRAYLANG
     * @param      string   $dirName
     * @return     boolean  true if directory and its contents deleted successfully and false if it failed
     */
    private function deleteDirectory($dirName)
    {
        global $_ARRAYLANG;

        $dir_handle = is_dir($dirName) ? opendir($dirName) : "";
        if (!$dir_handle) {
            return false;
        }

        while ($file = readdir($dir_handle)) {
            if ($file != "." && $file != "..") {
                if (!is_dir($dirName."/".$file)) {
                    unlink($dirName."/".$file);
                } else {
                    $this->deleteDirectory($dirName.'/'.$file);
                }
            }
        }
        closedir($dir_handle);
        rmdir($dirName);
        /* Redirect to previous path */
        $new_path_arr = explode("/", trim($this->webPath, "/"));
        array_pop($new_path_arr);
        $newPath = "/".implode("/", $new_path_arr)."/";
        header("Location: index.php?section=" . $this->archive . $this->getCmd . "&deletefolder=success&path=". rawurlencode($newPath));
        return true;
    }

}
