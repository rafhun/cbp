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
 * Skins
 * @copyright    CONTREXX CMS - COMVATION AG
 * @author        Comvation Development Team <info@comvation.com>
 * @access        public
 * @package      contrexx
 * @subpackage   core
 * @version        1.1.0
 */

/**
 * Skins class
 * Skins and Themes management functions
 *
 * @copyright    CONTREXX CMS - COMVATION AG
 * @author        Comvation Development Team <info@comvation.com>
 * @access        public
 * @package      contrexx
 * @subpackage   core
 * @version        1.1.0
 */
class skins
{
    /**
     * Title of the active page
     * @var string
     */
    public $pageTitle;

    /**
     * Error message
     * @var string
     */
    public $strErrMessage = '';

    /**
     * Success message
     * @var unknown_type
     */
    public $strOkMessage = '';

    /**
     * Temporary archive location, relative to the document root
     * @var string
     */
    public $_archiveTempWebPath;

    /**
     * Temporary archive location, absolute path
     * @var string
     */
    public $_archiveTempPath;

    /**
     * Name of the theme directory
     * @var string
     */
    public $_themeDir;

    /**
     * Required files
     * @var array
     */
    public $filenames = array("index.html","style.css","content.html","home.html","navbar.html","navbar2.html","navbar3.html","subnavbar.html","subnavbar2.html","subnavbar3.html","sidebar.html","shopnavbar.html","headlines.html","events.html","javascript.js","buildin_style.css","directory.html","component.yml","forum.html","podcast.html","blog.html","immo.html");

    /**
     * Required directories
     * @var array
     */
    public $directories = array("images/",);

    /**
     * File extenstions to display in filelist
     * @var array
     */
    public $fileextensions = array("htm", "shtml", "html", "txt", "css", "js", "php", "java", "tpl", "xml",);

    /**
     * Subdirectores and contents of selected theme
     * @var array
     */
    public $subDirs = array();

    /**
     * Path to the parent directory of the theme
     * @var string
     */
    public $_parentPath = '';
    
    private $themeRepository;

    public $arrWebPaths;                      // array web paths
    public $getAct;                           // $_GET['act']
    public $getPath;                          // $_GET['path']
    public $path;                             // current path
    public $webPath;                          // current web path
    public $tableExists;                      // Table exists
    public $oldTable;                         // old Theme-Table name

    private $act = '';

    function __construct()
    {
        global  $_CORELANG, $objTemplate, $objDatabase;

        //add preview.gif to required files
        $this->filenames[] = 'images/preview.gif';
        //get path variables
        $this->path = ASCMS_THEMES_PATH.'/';
        $this->arrWebPaths  = array(ASCMS_THEMES_WEB_PATH.'/');
        $this->themeZipPath = '/themezips/';
        $this->_archiveTempWebPath = ASCMS_TEMP_WEB_PATH.$this->themeZipPath;
        $this->_archiveTempPath = ASCMS_PATH.$this->_archiveTempWebPath;
        //create /tmp/zip path if it doesnt exists
        if (!file_exists($this->_archiveTempPath)){
            if (!\Cx\Lib\FileSystem\FileSystem::make_folder(ASCMS_TEMP_PATH.$this->themeZipPath)){
                $this->strErrMessage=ASCMS_TEMP_PATH.$this->themeZipPath .":".$_CORELANG['TXT_THEME_UNABLE_TO_CREATE'];
            }
        }
        $this->webPath = $this->arrWebPaths[0];
        if (substr($this->webPath, -1) != '/'){
            $this->webPath = $this->webPath . '/';
        }

        $objDatabase->Execute("OPTIMIZE TABLE ".DBPREFIX."skins");
        $this->oldTable = DBPREFIX."themes";
        
        $this->themeRepository = new \Cx\Core\View\Model\Repository\ThemeRepository();
        //\Cx\Lib\FileSystem\FileSystem::makeWritable($this->webPath);
    }
    

    /**
     * checks whether this contrexx has the possibility to use multi language mode
     * @return bool is this contrexx in multi language mode
     */
    private function isInLanguageFullMode() {
        global $_CONFIG, $objDatabase;
        return \Cx\Core_Modules\License\License::getCached($_CONFIG, $objDatabase)->isInLegalComponents("fulllanguage");
    }

    private function setNavigation()
    {
        global $objTemplate, $_CORELANG;

        $objTemplate->setVariable("CONTENT_NAVIGATION","
            <a href='index.php?cmd=skins' class='".($this->act == '' ? 'active' : '')."'>".$_CORELANG['TXT_DESIGN_OVERVIEW']."</a>
            <a href='index.php?cmd=skins&amp;act=templates' class='".($this->act == 'templates' || $this->act == 'newDir' ? 'active' : '')."'>".$_CORELANG['TXT_DESIGN_TEMPLATES']."</a>
            <a href='index.php?cmd=media&amp;archive=themes'>".$_CORELANG['TXT_DESIGN_FILES_ADMINISTRATION']."</a>
            <a href='index.php?cmd=skins&amp;act=examples' class='".($this->act == 'examples' ? 'active' : '')."'>".$_CORELANG['TXT_CORE_PLACEHOLDERS']."</a>
            <a href='index.php?cmd=skins&amp;act=manage' class='".($this->act == 'manage' ? 'active' : '')."'>".$_CORELANG['TXT_THEME_IMPORT_EXPORT']."</a>");
        }

    /**
     * Gets the requested page
     * @global    \Cx\Core\Html\Sigma
     * @return    string    parsed content
     */
    function getPage()
    {
        global $objTemplate;

        if (!isset($_GET['act'])) {
            $_GET['act']="";
        }
        switch($_GET['act']){
            case "templates":
                $this->newfile();
                $this->delfile();
                $this->deldir();
                $this->overview();
                break;
            case "examples":
                $this->examples();
                break;
            case "manage":
                $this->manage();
                break;
            case "upload":
                $this->upload();
                $this->overview();
                break;
            case "update":
                $this->update();
                $this->overview();
                break;
            case "newDir":
                $this->newdir();
                break;
            case "createDir":
                $this->createdir();
                break;
            default:
                $this->_activate();
        }
        $objTemplate->setVariable(array(
            'CONTENT_TITLE'             => $this->pageTitle,
            'CONTENT_OK_MESSAGE'        => $this->strOkMessage,
            'CONTENT_STATUS_MESSAGE'    => $this->strErrMessage,
        ));
        $this->act = (isset ($_REQUEST['act']) ? $_REQUEST['act'] : '');
        $this->setNavigation();
    }

    /**
     * show the overview page
     * @access   public
     */
    private function overview()
    {
        global $_CORELANG, $objTemplate;

        Permission::checkAccess(47, 'static');

        // initialize variables
        $objTemplate->addBlockfile('ADMIN_CONTENT', 'skins_content', 'skins_content.html');
        $this->pageTitle = $_CORELANG['TXT_DESIGN_TEMPLATES'];
        $objTemplate->setVariable(array(
            'TXT_CHOOSE_TEMPLATE_GROUP'       => $_CORELANG['TXT_CHOOSE_TEMPLATE_GROUP'],
            'TXT_SELECT_FILE'                 => $_CORELANG['TXT_SELECT_FILE'],
            'TXT_DESIGN_FOLDER'               => $_CORELANG['TXT_DESIGN_FOLDER'],
            'TXT_TEMPLATE_FILES'              => $_CORELANG['TXT_TEMPLATE_FILES'],
            'TXT_FILE_EDITOR'                 => $_CORELANG['TXT_FILE_EDITOR'],
            'TXT_UPLOAD_FILES'                => $_CORELANG['TXT_UPLOAD_FILES'],
            'TXT_CREATE_FILE'                 => $_CORELANG['TXT_CREATE_FILE'],
            'TXT_DELETE'                      => $_CORELANG['TXT_DELETE'],
            'TXT_STORE'                       => $_CORELANG['TXT_SAVE'],
            'TXT_RESET'                       => $_CORELANG['TXT_RESET'],
            'TXT_SELECT_ALL'                  => $_CORELANG['TXT_SELECT_ALL'],
            'TXT_MANAGE_FILES'                => $_CORELANG['TXT_MANAGE_FILES'],
            'TXT_SELECT_THEME'                => $_CORELANG['TXT_SELECT_THEME'],
            'TXT_THEME_NAME'                  => $_CORELANG['TXT_THEME_NAME'],
            'TXT_DESIGN_OVERVIEW'             => $_CORELANG['TXT_DESIGN_OVERVIEW'],
            'TXT_MODE'                        => $_CORELANG['TXT_MODE'],
            'TXT_THEMES_EDIT'                 => $_CORELANG['TXT_SETTINGS_MODFIY'],
            'TXT_THEMES_CREATE'               => $_CORELANG['TXT_CREATE'],
        ));
        $this->getDropdownContent();

        // get library column
        $theme = null;
        if (isset($_POST['themes'])) {
            $theme = $this->themeRepository->findOneBy(array('foldername' => $_POST['themes']));
        }
        if (!$theme) {
            $theme = $this->themeRepository->getDefaultTheme();
        }
        $this->saveLibrarySettings($theme);
        if ($theme->isComponent()) {
            $this->getLibrarySettings($theme);
        } else {
            $objTemplate->hideBlock('theme_libraries');
            $this->strErrMessage = sprintf($_CORELANG['TXT_THEME_NOT_COMPONENT'], $theme->getThemesname());
        }
    }

    /**
     * set up Import/Export page
     * call specific function depending on $_GET
     * @access private
     */
    private function manage()
    {
        global $_CORELANG, $objTemplate, $objDatabase, $_CONFIG;

        Permission::checkAccess(102, 'static');

        $objTemplate->addBlockfile('ADMIN_CONTENT', 'skins_manage', 'skins_manage.html');
        $this->pageTitle = $_CORELANG['TXT_THEME_IMPORT_EXPORT'];
        //check GETs for action
        if (!empty($_GET['export'])){
            $archiveURL=$this->_exportFile();
            if (is_string($archiveURL)){
                CSRF::header("Location: ".$archiveURL);
                exit;
            }
        }
        if (!empty($_GET['import'])){
            $this->importFile();
        }
        if (!empty($_GET['activate'])){
            $this->activateDefault(intval($_GET['activate']));
        }
        if (!empty($_GET['delete'])){
            $this->deldir(true);
            $objTemplate->setVariable('THEMES_MENU', $this->getThemesDropdown());
        }
        //set template variables
        $objTemplate->setGlobalVariable(array('TXT_THEME_THEMES'              => $_CORELANG['TXT_THEME_THEMES'],
                                              'TXT_THEME_PREVIEW'             => $_CORELANG['TXT_THEME_PREVIEW'],
                                              'TXT_THEME_IMPORT_EXPORT'       => $_CORELANG['TXT_THEME_IMPORT_EXPORT'],
                                              'TXT_THEME_NAME'                => $_CORELANG['TXT_THEME_NAME'],
                                              'TXT_THEME_IMPORT'              => $_CORELANG['TXT_THEME_IMPORT'],
                                              'TXT_THEME_EXPORT'              => $_CORELANG['TXT_THEME_EXPORT'],
                                              'TXT_THEME_PREVIEW_NEW_WINDOW'  => $_CORELANG['TXT_THEME_PREVIEW_NEW_WINDOW'],
                                              'TXT_THEME_DIRECTORY_NAME'      => $_CORELANG['TXT_THEME_DIRECTORY_NAME'],
                                              'TXT_THEME_SEND_ARCHIVE'        => $_CORELANG['TXT_THEME_SEND_ARCHIVE'],
                                              'TXT_THEME_IMPORT_ARCHIVE'      => $_CORELANG['TXT_THEME_IMPORT_ARCHIVE'],
                                              'TXT_THEME_LOCAL_FILE'          => $_CORELANG['TXT_THEME_LOCAL_FILE'],
                                              'TXT_THEME_SPECIFY_URL'         => $_CORELANG['TXT_THEME_SPECIFY_URL'],
                                              'TXT_THEME_CONFIRM_DELETE'      => $_CORELANG['TXT_THEME_CONFIRM_DELETE'],
                                              'TXT_FUNCTIONS'                 => $_CORELANG['TXT_FUNCTIONS'],
                                              'TXT_NAME'                      => $_CORELANG['TXT_NAME'],
                                              'TXT_THEME_SHOW_PRINT_THEME'    => $_CORELANG['TXT_THEME_SHOW_PRINT_THEME'],
                                              'TXT_THEME_NO_URL_SPECIFIED'    => $_CORELANG['TXT_THEME_NO_URL_SPECIFIED'],
                                              'TXT_THEME_NO_FILE_SPECIFIED'   => $_CORELANG['TXT_THEME_NO_FILE_SPECIFIED'],
                                              'TXT_THEME_DETAILS'             => $_CORELANG['TXT_THEME_DETAILS'],
                                              'TXT_THEME_IMPORT_INFO'         => $_CORELANG['TXT_THEME_IMPORT_INFO'],
                                              'TXT_THEME_IMPORT_INFO_BODY'    => $_CORELANG['TXT_THEME_IMPORT_INFO_BODY'],
                                              'TXT_SKINS_PREVIEW'             => $_CORELANG['TXT_SKINS_PREVIEW'],
                                              'TXT_THEME_PREVIEW_IMAGE'       => $_CORELANG['TXT_THEME_PREVIEW_IMAGE'],
                                              'TXT_THEME_PREVIEW_URL'         => $_CORELANG['TXT_THEME_PREVIEW_URL'],
                                              'TXT_THEME_INFORMATION'         => $_CORELANG['TXT_THEME_INFORMATION'],
                                              'TXT_LANGUAGES'                 => $_CORELANG['TXT_LANGUAGES'],
                                              'TXT_NAME'                      => $_CORELANG['TXT_NAME'],
                                              'TXT_AUTHOR'                    => $_CORELANG['TXT_AUTHOR'],
                                              'TXT_VERSION'                   => $_CORELANG['TXT_VERSION'],
                                              'TXT_DESCRIPTION'               => $_CORELANG['TXT_DESCRIPTION'],
                                              'THEMES_MENU'                   => $this->getThemesDropdown(),
                                              'CONTREXX_BASE_URL'             => ASCMS_PROTOCOL . '://' . $_CONFIG['domainUrl'] . ASCMS_PATH_OFFSET . '/',
        ));
        //create themelist
        $themes = $this->themeRepository->findAll();
        $rowclass = 0;
        foreach ($themes as $theme) {
            $htmlDeleteLink = '<a onclick="showInfo(this.parentNode.parentNode); return confirmDelete(\''.htmlspecialchars($theme->getThemesname(), ENT_QUOTES, CONTREXX_CHARSET).'\');" href="?cmd=skins&amp;act=manage&amp;delete='.urlencode($theme->getFoldername()).'" title="'.$_CORELANG['TXT_DELETE'].'"> <img border="0" src="images/icons/delete.gif" alt="" /> </a>';
            $htmlActivateLink = '<a onclick="showInfo(this.parentNode.parentNode);" href="?cmd=skins&amp;act=manage&amp;activate='.$theme->getId().'" title="'.$_CORELANG['TXT_CORE_CM_ACTION_PUBLISH'].'"> <img border="0" src="images/icons/check.gif" alt="" /> </a>';

            $version = $theme->getVersionNumber();
            if (!$version) {
                $version = '-';
            }
            $objTemplate->setVariable(array('THEME_NAME'            => contrexx_raw2xhtml($theme->getThemesname()),
                                            'THEME_LANGUAGES'       => $theme->getLanguages(),
                                            'THEME_PREVIEW'         => $theme->getPreviewImage(),
                                            'TXT_THEME_EXPORT'      => $_CORELANG['TXT_THEME_EXPORT'],
                                            'TXT_DELETE'            => $_CORELANG['TXT_DELETE'],
                                            'THEME_DELETE_LINK'     => !$theme->isDefault() ? $htmlDeleteLink : '',
                                            'THEME_ACTIVATE_LINK'   => !$theme->isDefault() ? $htmlActivateLink : '',
                                            'THEME_ID'              => $theme->getId(),
                                            'TXT_ACTIVATE_DESIGN'   => $_CORELANG['TXT_ACTIVATE_DESIGN'],
                                            'ROW_CLASS'             => $theme->isDefault() ? 'active' : (($rowclass++ % 2) ? 'row1' : 'row2'),
                                            'THEME_AUTHOR'          => contrexx_raw2xhtml($theme->getPublisher()),
                                            'THEME_VERSION'         => $version,
                                            'THEME_DESCRIPTION'     => contrexx_raw2xhtml($theme->getDescription()),


            ));
            $objTemplate->parse('themeRow');
        }
    }


    /**
     * clean tmp folder
     * @access private
     * @return void
     */
    function _cleantmp()
    {
        if (is_dir($this->_archiveTempPath)) {
            $dh = opendir($this->_archiveTempPath);
            if ($dh) {
                $file = readdir($dh);
                while ($file !== false) {
                    if ($file != '..' && $file != '.' && is_file($this->_archiveTempPath.$file)){
                        unlink($this->_archiveTempPath.$file);
                    }
                    $file = readdir($dh);
                }
                closedir($dh);
            }
        }
    }

    /**
     * check fileupload and move uploaded file if it's a valid archive
     * @return unknown
     */

    private function checkUpload()
    {
        global $_CORELANG;

        if (!isset($_FILES['importlocal'])){
            $this->strErrMessage="POST Request Error. 'importlocal' is empty";
            return false;
        }
        // Check for MIME type and whether it's a zip file
        // (not all browsers provide the type)
        if (   is_uploaded_file($_FILES['importlocal']['tmp_name'])
            && is_file($_FILES['importlocal']['tmp_name'])) {
            // this is unreliable
            /*if (isset($_FILES['importlocal']['type'])) {
                if (   !preg_match('/zip$/i', $_FILES['importlocal']['type'])
                   && !(   preg_match('/binary$/', $_FILES['importlocal']['type'])
                        || preg_match('/application\/octet\-?stream/', $_FILES['importlocal']['type'])
                        || preg_match('/application\/x-zip-compressed/', $_FILES['importlocal']['type']))) {
                    $this->strErrMessage =
                        $_FILES['importlocal']['name'].': '.
                        $_CORELANG['TXT_THEME_IMPORT_WRONG_MIMETYPE'].': '.
                        $_FILES['importlocal']['type'];
                    return false;
                }
            }*/
        } else {
            $this->strErrMessage = $_CORELANG['TXT_COULD_NOT_UPLOAD_FILE'];
            return false;
        }
        // Move the uploaded file to the themezip location
        if (!move_uploaded_file($_FILES['importlocal']['tmp_name'], $this->_archiveTempPath.basename($_FILES['importlocal']['name']))) {
            $this->strErrMessage = $this->_archiveTempPath.basename($_FILES['importlocal']['name']).': '.$_CORELANG['TXT_COULD_NOT_UPLOAD_FILE'];
            return false;
        }
        return true;
    }


    /**
     * check for valid archive structure, put directories into $arrDirectories
     * set errormessage if structure not valid
     * @access private
     * @param array $content file and directory list
     * @return boolean
     */
    private function validateArchiveStructure($content, &$themeDirectory, &$themeDirectoryFromArchive, &$themeName, &$arrDirectories)
    {
        global $_CORELANG;

        //check if archive is empty
        if (sizeof($content) == 0){
            $this->strErrMessage = $_FILES['importlocal']['name'].': '.$_CORELANG['TXT_THEME_ARCHIVE_WRONG_STRUCTURE'];
            return false;
        }

        $first_item = $content[0];
        $themeDirectoryFromArchive = substr($first_item['stored_filename'], 0, strpos($first_item['stored_filename'], '/'));
        $themeDirectory = $themeDirectoryFromArchive;

        // ensure that we're creating a new directory and not trying to overwrite an existing one
        $suffix = '';
        while (file_exists($this->path.$themeDirectory.$suffix)) {
            $suffix++;
        }
        $themeDirectory .= $suffix;

        $themeName = !empty($_POST['theme_dbname']) ? contrexx_input2raw($_POST['theme_dbname']) : $themeDirectoryFromArchive;

        $arrDirectories[] = $themeDirectory;

        foreach ($content as $item){
            //check if current file/directory contains the base directory and abort when not true
            if (strpos($item['stored_filename'], $themeDirectoryFromArchive) !== 0) {
                $this->strErrMessage = $_FILES['importlocal']['name'].': '.$_CORELANG['TXT_THEME_ARCHIVE_WRONG_STRUCTURE'];
                return false;
            }

            // skip files
            if (!$item['folder']) {
                continue;
            }

            //check if its the base directory
            if (basename($item['stored_filename']) == $themeDirectoryFromArchive) {
                //take the whole string, this is the archive base directory
                //$arrDirectories[] = $item['stored_filename'];
                $arrDirectories[] = $themeDirectory;
            } else {
                //only take the most top directory
                $arrDirectories[] = substr($item['stored_filename'], strlen($themeDirectoryFromArchive));
            }
        }

        return true;
    }

    /**
     * Create the directory structure of the archive contents and set permissions
     * @return boolean
     */

    private function createDirectoryStructure($themeDirectory, $arrDirectories)
    {
        global $_CORELANG;
        //create archive structure and set permissions
        //this is an important step on hostings where the FTP user ID differs from the PHP user ID
        foreach ($arrDirectories as $index => $directory){
            switch($index){
                //check if theme directory already exists
                case 0:
                    if (file_exists($this->path.$directory)){
                        // basically this should never happen, because the directory $themeDirectory should have been renamed
                        // automatically in case a directory with the same name is already present
                        $this->strErrMessage = $themeDirectory.': '.$_CORELANG['TXT_THEME_FOLDER_ALREADY_EXISTS'].'! '.$_CORELANG['TXT_THEME_FOLDER_DELETE_FIRST'].'.';
                        return false;
                    }

                    \Cx\Lib\FileSystem\FileSystem::make_folder($this->path.$directory);
                    //\Cx\Lib\FileSystem\FileSystem::makeWritable($this->path.$directory);
                    break;

                default:
                    \Cx\Lib\FileSystem\FileSystem::make_folder($this->path.$themeDirectory.'/'.$directory);
                    //\Cx\Lib\FileSystem\FileSystem::makeWritable($this->path.$themeDirectory.'/'.$directory);
                    break;
            }
        }

        return true;
    }


    /**
     * Extracts the archive to the themes path
     * @param pclZip Object $archive
     * @return boolean
     */
    private function extractArchive($archive, $themeDirectory, $themeDirectoryFromArchive)
    {
        global $_CORELANG;

        $valid_exts = array(
            "txt","doc","xls","pdf","ppt","gif","jpg","png","xml",
            "odt","ott","sxw","stw","dot","rtf","sdw","wpd","jtd",
            "jtt","hwp","wps","ods","ots","sxc","stc","dif","dbf",
            "xlw","xlt","sdc","vor","sdc","cvs","slk","wk1","wks",
            "123","odp","otp","sxi","sti","pps","pot","sxd","sda",
            "sdd","sdp","cgm","odg","otg","sxd","std","dxf","emf",
            "eps","met","pct","sgf","sgv","svm","wmf","bmp","jpeg",
            "jfif","jif","jpe","pbm","pcx","pgm","ppm","psd","ras",
            "tga","tif","tiff","xbm","xpm","pcd","oth","odm","sxg",
            "sgl","odb","odf","sxm","smf","mml","zip","rar","htm",
            "html","shtml","css","js","tpl","thumb","ico"
        );

        if (($files = $archive->extract(PCLZIP_OPT_PATH, $this->path.$themeDirectory, PCLZIP_OPT_REMOVE_PATH, $themeDirectoryFromArchive, PCLZIP_OPT_BY_PREG, '/('.implode('|', $valid_exts).')$/')) != 0){
            foreach ($files as $file) {
                //check status for errors while extracting the archive
                if (!in_array($file['status'],array('ok','filtered','already_a_directory'))){
                    $this->strErrMessage = $_CORELANG['TXT_THEME_ARCHIVE_ERROR'].': '.$archive->errorInfo(true);
                    return false;
                }
            }

            // add eventually missing required theme files
            $this->createDefaultFiles($themeDirectory);
        } else {
            $this->strErrMessage = $_CORELANG['TXT_THEME_ARCHIVE_ERROR'].': '.$archive->errorInfo(true);
            return false;
        }

        return true;
    }


    /**
     * import themes from archive
     * @access   private
     * @param    string   $themes
     */
    private function importFile()
    {
        global $_CORELANG;
        require_once(ASCMS_LIBRARY_PATH.'/pclzip/pclzip.lib.php');

        $this->_cleantmp();
        switch($_GET['import']) {
            case 'remote':
                $archiveFile = $this->_fetchRemoteFile($_POST['importremote']);
                if ($archiveFile === false) {
                    return false;
                }
                $archive = new PclZip($archiveFile);
                //no break
            case 'local':
                if (empty($archive)) {
                    if ($this->checkUpload() === false) {
                        return false;
                    }
                    $archive = new PclZip($this->_archiveTempPath.basename($_FILES['importlocal']['name']));
                }
                $content = $archive->listContent();
                $themeName = '';
                $themeDirectory = '';
                $themeDirectoryFromArchive = '';
                $arrDirectories = array();

                // analyze theme archive
                if (!$this->validateArchiveStructure($content, $themeDirectory, $themeDirectoryFromArchive, $themeName, $arrDirectories)) {
                    return false;
                }
                // prepare directory structure of new theme
                if (!$this->createDirectoryStructure($themeDirectory, $arrDirectories)) {
                    return false;
                }

                //extract archive files
                $this->extractArchive($archive, $themeDirectory, $themeDirectoryFromArchive);

                //create database entry
                $this->validateThemeName($themeName);
                $this->replaceThemeName($themeDirectoryFromArchive, $themeDirectory, $this->path . $arrDirectories[0]);
                $this->insertSkinIntoDb($themeName, $themeDirectory);
                $this->strOkMessage = contrexx_raw2xhtml($themeName).' ('.$themeDirectory.') '.$_CORELANG['TXT_THEME_SUCCESSFULLY_IMPORTED'];
                break;
            //everything else should never be the case
            default:
                $this->strErrMessage="GET Request Error. 'import' should be either 'local' or 'remote'";
                return false;
                break;
        }
        return true;
    }


    function _fetchRemoteFile($URL)
    {
        global $_CORELANG;

        $URL = parse_url($URL);
        $errno = $errstr = null;
        $http = @fsockopen($URL['host'], !empty($URL['port']) ? intval($URL['port']) : 80 , $errno, $errstr, 10);
        if ($http){
            $archive = '';
            fputs($http,'GET /'.$URL['path']." HTTP/1.1\r\n");
            fputs($http,'Host: '.$URL['host']."\r\n\r\n");
            while(!feof($http)){
                $archive .= fgets($http, 1024);
            }
            fclose($http);
            //cut off HTTP headers, PKZIP header = "\x50\x4B\x03\x04"
            $archive=strstr($archive,"\x50\x4B\x03\x04");
            if ($archive == ''){
                $this->strErrMessage = $_CORELANG['TXT_THEME_IMPORT_WRONG_MIMETYPE'];
                return false;
            }
            $tmpfilename = basename($URL['path']);
            if (strlen($tmpfilename) < 3) $tmpfilename = '_unknown_upload_';
// TODO: use session temp
            $tempFile = ASCMS_TEMP_PATH.'/'.$tmpfilename.microtime().'.zip';
            $fh = fopen($tempFile,'w');
            fputs($fh, $archive);
            return $tempFile;
        } else {
            $this->strErrMessage = $_CORELANG['TXT_THEME_HTTP_CONNECTION_FAILED'];
            return false;
        }
    }

    /**
     * export theme as archive
     * @access   private
     * @param    string   theme folder name
     * @return   string   path to the created archive
     */
    function _exportFile()
    {
        require_once(ASCMS_LIBRARY_PATH.'/pclzip/pclzip.lib.php');
        global $_CORELANG;
        //clean up tmp folder
        $this->_cleantmp();
        //path traversal security check
        $theme=str_replace(array('..','/'), '', trim(html_entity_decode(urldecode($_GET['export']))));
        if (!$theme){
            $this->strErrMessage = $_CORELANG['TXT_THEME_FOLDER_DOES_NOT_EXISTS'];
            return false;
        }

        //get the folder name from theme name
        $objResult = \Env::get('db')->Execute("SELECT id, themesname, foldername from `".DBPREFIX."skins` WHERE themesname = '" . contrexx_raw2db($theme) . "'");
        if ($objResult !== false && $objResult->RecordCount() > 0) {
            $theme = $objResult->fields['foldername'];
        } else {
            $this->strErrMessage = $_CORELANG['TXT_THEME_FOLDER_DOES_NOT_EXISTS'];
            return false;
        }

        if (is_dir($this->path.$theme)){
            $archive = new PclZip($this->_archiveTempPath.$theme.'.zip');
            \Cx\Lib\FileSystem\FileSystem::makeWritable($this->_archiveTempPath);
            $files = $archive->create($this->path.$theme, PCLZIP_OPT_REMOVE_PATH, $this->path);
            if (!is_array($files)){
                $this->strErrMessage = $this->_archiveTempPath.$theme.'.zip'.': '.$_CORELANG['TXT_THEME_UNABLE_TO_CREATE'];
                return false;
            }
            foreach($files as $file){
                //status check
                if (!in_array($file['status'],array('ok','filtered'))){
                    $this->strErrMessage = $_CORELANG['TXT_THEME_ARCHIVE_ERROR'].': '.$archive->errorInfo(true);
                    return false;
                }
                \Cx\Lib\FileSystem\FileSystem::makeWritable($this->_archiveTempPath.$theme.'.zip');
                return $this->_archiveTempWebPath.$theme.'.zip';
            }
        }
        $this->strErrMessage = $_CORELANG['TXT_THEME_FOLDER_DOES_NOT_EXISTS'];
        return false;
    }


    /**
     * activates the theme for the current default language
     *
     * @access  private
     * @global  ADONewConnection
     * @global  array   $_CORELANG
     * @return  boolean
     */
    private function activateDefault()
    {
        global $objDatabase, $_CORELANG;

        $newThemeId = intval($_GET['activate']);
        if (empty($newThemeId)){
            $this->strErrMessage = "GET value error. Must be numeric ID.";
        }

        $objResult = $objDatabase->Execute('SELECT `id`, `themesid` FROM `'.DBPREFIX.'languages` WHERE `is_default` = "true" LIMIT 1');
        if ($objResult->RecordCount() > 0){
            $langId = $objResult->fields['id'];
            $oldThemeId = $objResult->fields['themesid'];
            
            $objDatabase->Execute('UPDATE `'.DBPREFIX.'languages` SET `themesid` = "'.$newThemeId.'" WHERE `id` = '.$langId);

            $pageRepo = \Env::get('em')->getRepository('Cx\Core\ContentManager\Model\Entity\Page');
            $pages = $pageRepo->findBy(array(
                'skin' => intval($oldThemeId),
            ));
            foreach ($pages as $page) {
                if ($page->getSkin() != 0) {
                    $page->setSkin($newThemeId);
                    \Env::get('em')->persist($page);
                }
            }
            \Env::get('em')->flush();

            $this->strOkMessage = $_CORELANG['TXT_DATA_RECORD_UPDATED_SUCCESSFUL'];
        } else {
            $this->strErrMessage = $_CORELANG['TXT_DATABASE_QUERY_ERROR'];
            return false;
        }
        return true;
    }


    /**
     * Gets the themes assigning page
     * @access   private
     * @global   ADONewConnection
     * @global   array
     * @global   \Cx\Core\Html\Sigma
     * @return   string   parsed content
     */
    function _activate()
    {
        global $objDatabase, $_CORELANG, $objTemplate;

        Permission::checkAccess(46, 'static');

        $objTemplate->addBlockfile('ADMIN_CONTENT', 'skins_active', 'skins_activate.html');
        $this->pageTitle = $_CORELANG['TXT_OVERVIEW'];
        $objTemplate->setVariable(array(
            'TXT_ACTIVATE_DESIGN'          => $_CORELANG['TXT_ACTIVATE_DESIGN'],
            'TXT_ID'                       => $_CORELANG['TXT_ID'],
            'TXT_LANGUAGE'                 => $_CORELANG['TXT_LANGUAGE'],
            'TXT_ACTIVE_TEMPLATE'          => $_CORELANG['TXT_ACTIVE_TEMPLATE'],
            'TXT_ACTIVE_PDF_TEMPLATE'      => $_CORELANG['TXT_ACTIVE_PDF_TEMPLATE'],
            'TXT_ACTIVE_PRINT_TEMPLATE'    => $_CORELANG['TXT_ACTIVE_PRINT_TEMPLATE'],
            'TXT_SAVE'                     => $_CORELANG['TXT_SAVE'],
            'TXT_THEME_ACTIVATE_INFO'      => $_CORELANG['TXT_THEME_ACTIVATE_INFO'],
            'TXT_THEME_ACTIVATE_INFO_BODY' => $_CORELANG['TXT_THEME_ACTIVATE_INFO_BODY'],
            'TXT_ACTIVE_MOBILE_TEMPLATE'   => $_CORELANG['TXT_ACTIVE_MOBILE_TEMPLATE'],
            'TXT_ACTIVE_APP_TEMPLATE'      => $_CORELANG['TXT_APP'],
        ));
        $i=0;

        if (isset($_POST['themesId'])) {
            foreach ($_POST['themesId'] as $langid => $themesId) {
                $objDatabase->Execute("UPDATE ".DBPREFIX."languages SET themesid='".intval($themesId)."' WHERE id=".intval($langid));
            }
            foreach ($_POST['printThemesId'] as $langid => $printThemesId) {
                $objDatabase->Execute("UPDATE ".DBPREFIX."languages SET print_themes_id='".intval($printThemesId)."' WHERE id=".intval($langid));
            }
            foreach ($_POST['pdfThemesId'] as $langid => $pdfThemesId) {
                $objDatabase->Execute("UPDATE ".DBPREFIX."languages SET pdf_themes_id='".intval($pdfThemesId)."' WHERE id=".intval($langid));
            }
            foreach ($_POST['mobileThemesId'] as $langid => $mobileThemesId) {
                $objDatabase->Execute("UPDATE ".DBPREFIX."languages SET mobile_themes_id='".intval($mobileThemesId)."' WHERE id=".intval($langid));
            }
            foreach ($_POST['appThemesId'] as $langid => $appThemesId) {
                $objDatabase->Execute("UPDATE ".DBPREFIX."languages SET app_themes_id='".intval($appThemesId)."' WHERE id=".intval($langid));
            }
            $this->strOkMessage = $_CORELANG['TXT_DATA_RECORD_UPDATED_SUCCESSFUL'];
        }
        $objResult = $objDatabase->Execute('
            SELECT   `id`, `lang`, `name`, `frontend`, `themesid`, `mobile_themes_id`, `print_themes_id`, `pdf_themes_id`, `app_themes_id`, `is_default`
            FROM     `'.DBPREFIX.'languages`
            WHERE    `frontend` = 1
            ORDER BY `id`
        ');

        if ($objResult !== false) {
            while (!$objResult->EOF) {
                if (!$this->isInLanguageFullMode() && $objResult->fields['is_default'] == "false") {
                    $objResult->MoveNext();
                    continue;
                }

                if (($i % 2) == 0) {
                    $class="row1";
                } else {
                    $class="row2";
                }
                
                $objTemplate->setVariable(array(
                    'THEMES_ROWCLASS'             => $class,
                    'THEMES_LANG_ID'              => $objResult->fields['id'],
                    'THEMES_LANG_SHORTNAME'       => $objResult->fields['lang'],
                    'THEMES_LANG_NAME'            => $objResult->fields['name'],
                    'THEMES_TEMPLATE_MENU'        => $this->_getDropdownActivated($objResult->fields['themesid']),
                    'THEMES_PRINT_TEMPLATE_MENU'  => $this->_getDropdownActivated($objResult->fields['print_themes_id']),
                    'THEMES_MOBILE_TEMPLATE_MENU' => $this->_getDropdownActivated($objResult->fields['mobile_themes_id']),
                    'THEMES_PDF_TEMPLATE_MENU'    => $this->_getDropdownActivated($objResult->fields['pdf_themes_id']),
                    'THEMES_APP_TEMPLATE_MENU'    => $this->_getDropdownActivated($objResult->fields['app_themes_id']),
                ));
                $objTemplate->parse('themesLangRow');
                $i++;
                $objResult->MoveNext();
            }
        }
    }

    /**
     * Gets the themes example page
     * @access   public
     */
    function examples()
    {
        global $_CORELANG, $objTemplate, $_CONFIG;

        Permission::checkAccess(47, 'static');

        // initialize variables
        $objTemplate->addBlockfile('ADMIN_CONTENT', 'skins_examples', 'skins_examples.html');
        $this->pageTitle = $_CORELANG['TXT_DESIGN_VARIABLES_LIST'];
        $objTemplate->setVariable(array(
            'TXT_STANDARD_TEMPLATE_STRUCTURE'       => $_CORELANG['TXT_STANDARD_TEMPLATE_STRUCTURE'],
            'TXT_FRONTEND_EDITING_LOGIN_FRONTEND'   => $_CORELANG['TXT_FRONTEND_EDITING_LOGIN_FRONTEND'],
            'TXT_STARTPAGE'                         => $_CORELANG['TXT_STARTPAGE'],
            'TXT_STANDARD_PAGES'                    => $_CORELANG['TXT_STANDARD_PAGES'],
            'TXT_REPLACEMENT_LIST'                  => $_CORELANG['TXT_REPLACEMENT_LIST'],
            'TXT_FILES'                             => $_CORELANG['TXT_FILES'],
            'TXT_CONTENTS'                          => $_CORELANG['TXT_CONTENTS'],
            'TXT_PLACEHOLDER_DIRECTORY'             => $_CORELANG['TXT_DESIGN_REPLACEMENTS_DIR'],
            'TXT_PLACEHOLDER_DIRECTORY_DESCRIPTION' => $_CORELANG['TXT_PLACEHOLDER_DIRECTORY_DESCRIPTION'],
            'TXT_CHANNELS'                          => $_CORELANG['TXT_CHANNELS'],
            'TXT_MODULE_URLS'                       => $_CORELANG['TXT_MODULE_URLS'],
            'TXT_CONTACT'                           => $_CORELANG['TXT_CONTACT'],
            'CONTREXX_BASE_URL'                     => ASCMS_PROTOCOL . '://' . $_CONFIG['domainUrl'] . ASCMS_PATH_OFFSET . '/',
        ));
    }

    /**
     * create skin folder page
     * @access   public
     */
    function newdir()
    {
        global $_CORELANG, $objTemplate;

        Permission::checkAccess(47, 'static');

        $this->webPath = $this->arrWebPaths[0];
        // initialize variables
        $objTemplate->addBlockfile('ADMIN_CONTENT', 'skins_create', 'skins_create.html');
        $this->pageTitle = $_CORELANG['TXT_NEW_DIRECTORY'];
        $objTemplate->setVariable(array(
            'TXT_NEW_DIRECTORY'       => $_CORELANG['TXT_NEW_DIRECTORY'],
            'TXT_EXISTING_DIR_NAME'   => $_CORELANG['TXT_EXISTING_DIR_NAME'],
            'CREATE_DIR_ACTION'       => '?cmd=skins&amp;act=createDir&amp;path=' . $this->webPath,
            'TXT_DIR_NAME'            => $_CORELANG['TXT_DIR_NAME'],
            'TXT_DB_NAME'             => $_CORELANG['TXT_DB_NAME'],
            'TXT_DESCRIPTION'         => $this->webPath,
            'TXT_SELECT_DIR'          => $_CORELANG['TXT_SELECT_DIR'],
            'TXT_CREATE'              => $_CORELANG['TXT_CREATE'],
            'TXT_FROM_TEMPLATE'       => $_CORELANG['TXT_FROM_TEMPLATE'],
            'THEMES_TEMPLATE_MENU'    => $this->getThemesDropdown(null, false),
            'TXT_THEMES_EDIT'         => $_CORELANG['TXT_SETTINGS_MODFIY'],
            'TXT_THEMES_CREATE'       => $_CORELANG['TXT_CREATE'],
        ));
        $objTemplate->setVariable('THEMES_MENU', $this->getDropdownNotInDb());
        $this->checkTable($this->oldTable);
//      $this->newdir();
    }

    private function validateThemeName(&$themeName)
    {
        $themeName = \Cx\Lib\FileSystem\FileSystem::replaceCharacters($themeName);
        $suffix = '';
        while ($this->themeRepository->findOneBy(array('themesname' => $themeName.$suffix))) {
            $suffix++;
        }

        $themeName .= $suffix;
    }

    /**
     * create skin folder
     * @access   public
     */
    private function createdir()
    {
        global $_CORELANG, $objTemplate;

        Permission::checkAccess(47, 'static');

        $themeName = !empty($_POST['dbName']) ? contrexx_input2raw($_POST['dbName']) : null;
        $copyFromTheme = !empty($_POST['fromTheme']) && !stristr($_POST['fromTheme'], '..') ? contrexx_input2raw($_POST['fromTheme']) : null;
        $existingThemeInFilesystem = !empty($_POST['existingdirName']) && !stristr($_POST['existingdirName'], '..') ? contrexx_input2raw($_POST['existingdirName']) : null;
        $createFromDatabase = !empty($_POST['fromDB']) ? contrexx_input2raw($_POST['fromDB']) : null;
        $dirName = !empty($_POST['dirName']) && !stristr($_POST['dirName'], '..') ? contrexx_input2raw($_POST['dirName']) : null;
        $dirName = \Cx\Lib\FileSystem\FileSystem::replaceCharacters($dirName);

        if (!$themeName) {
            $this->strErrMessage = $_CORELANG['TXT_STATUS_CHECK_INPUTS'];
            $this->newdir();
            return;
        }

        $this->validateThemeName($themeName);

        if (!empty($dirName) && empty($existingThemeInFilesystem)) {

            // ensure that we're creating a new directory and not trying to overwrite an existing one
            $suffix = '';
            while (file_exists($this->path.$dirName.$suffix)) {
                $suffix++;
            }
            $dirName .= $suffix;

            if (empty($copyFromTheme) && empty($createFromDatabase)) {
                // Create new empty theme
                if (\Cx\Lib\FileSystem\FileSystem::make_folder($this->path.$dirName)) {
                    //\Cx\Lib\FileSystem\FileSystem::makeWritable($this->path.$dirName);
                    $this->insertSkinIntoDb($themeName, $dirName);
                    if ($this->createDefaultFiles($dirName)) {
                        $this->strOkMessage  = contrexx_raw2xhtml($themeName).' '.$_CORELANG['TXT_STATUS_SUCCESSFULLY_CREATE'];
                        $_POST['themes'] = $dirName;
                        $this->overview();
                        return true;
                    }
                    $this->newdir();
                }
            } elseif (!empty($copyFromTheme) && empty($createFromDatabase)) {
                // Create new theme based on existing theme
                if (\Cx\Lib\FileSystem\FileSystem::copy_folder($this->path.$copyFromTheme, $this->path.$dirName)) {
                    $this->replaceThemeName($copyFromTheme, $dirName, $this->path.$dirName);
                    $this->insertSkinIntoDb($themeName, $dirName);
                    $this->strOkMessage  = $themeName." ". $_CORELANG['TXT_STATUS_SUCCESSFULLY_CREATE'];
                    $_POST['themes'] = $dirName;
                    $this->overview();
                } else {
// TODO: add proper error message
                    $this->strErrMessage = $_CORELANG['TXT_MSG_ERROR_NEW_DIR'];
                    $this->newdir();
                }
            } elseif (empty($copyFromTheme) && !empty($createFromDatabase)) {
// TODO: remove this function -> migrate all pending themes in the update process
                // Create new theme from database (migrate existing theme from database to filesystem)
                if (\Cx\Lib\FileSystem\FileSystem::make_folder($this->path.$dirName)) {
                    $this->insertIntoDb($themeName, $dirName, $createFromDatabase);
                    $this->createFilesFromDB($dirName, intval($createFromDatabase));
                }
                $this->newdir();
            }
        } elseif (empty($dirName) && !empty($existingThemeInFilesystem)) {
            $this->insertSkinIntoDb($themeName, $existingThemeInFilesystem);
            $this->strOkMessage  = contrexx_raw2xhtml($themeName).' '.$_CORELANG['TXT_STATUS_SUCCESSFULLY_CREATE'];
            $_POST['themes'] = $existingThemeInFilesystem;
            $this->overview();
        } else {
            $this->strErrMessage = $_CORELANG['TXT_STATUS_CHECK_INPUTS'];
            $this->newdir();
        }
    }

    /**
     * Replaces remainders of the original theme in a freshly copied theme.
     * (links to stylesheets, js, images etc.)
     * CAUTION: as this is intended for subroutine-use, no validation or
     * escaping of given parameters is done.
     * @param string $org original theme name
     * @param string $copy copied theme name
     * @param string $copyPath full path to copied theme's directory
     * @return string "error" on error, else empty string
     * @see skins::createDir()
     */
    private function replaceThemeName($org, $copy, $path)
    {
        //extensions of files that could contain links still pointing to the old template
        $regexValidExtensions = '\.css|\.htm|\.html';

        $dir = opendir($path);
        $file = readdir($dir);
        while($file)
        {
            if($file!='.' && $file != '..')
            {
                $ourFile = $path.'/'.$file;
                if(!is_dir($ourFile))
                {
                    //has the file one of our extensions defined above?
                    if(preg_match('/['.$regexValidExtensions.']$/',$ourFile))
                    {
                        //replace name of old template with new template's name
                        $fileContents = file_get_contents($ourFile);
                        $fileContents = str_replace($org,$copy,$fileContents);
                        try {
                            $objFile = new \Cx\Lib\FileSystem\File($ourFile);
                            $objFile->write($fileContents);
                        } catch (\Cx\Lib\FileSystem\FileSystemException $e) {
                            \DBG::msg($e->getMessage());
                        }
                    }
                }
                else //directory, call this function again to process it
                {
                    $this->replaceThemeName($org,$copy,$ourFile);
                }
            }
            $file=readdir($dir);
        }
    }


    /**
     * Gets the dropdown menu of filesystem dirs which are not in the DB
     * @access   public
     * @global   ADONewConnection
     * @return   string   $nadm
     */
    function getDropdownNotInDb()
    {
        $dir = ($this->path);
        $dh=opendir($dir);
        $file = readdir($dh);
        $nadm = '';
        while ($file) {
            if ($file!="." && $file!=".." && $file != "zip") {
                if (!$this->themeRepository->findOneBy(array('foldername' => $file))) {
                    $nadm .= "<option value='".$file."'>".$file."</option>\n";
                }
            }
            $file = readdir($dh);
        }
        closedir($dh);
        return $nadm;
    }

    /**
     * update skin file
     * @access   public
     */
    function update()
    {
        Permission::checkAccess(47, 'static');

        $themes = !empty($_POST['themes']) && !stristr($_POST['themes'], '..') ? contrexx_input2raw($_POST['themes']) : null;
        $themesPage = !empty($_POST['themesPage']) &&  !stristr($_POST['themesPage'], '..') ? contrexx_input2raw($_POST['themesPage']) : null;

        if (empty($themes) || empty($themesPage) || ImageManager::_isImage($this->path.$themes.'/'.$themesPage)) {
            return false;
        }

        $pageContent = contrexx_input2raw($_POST['content']);

        // Change the replacement variables from [[TITLE]] into {TITLE}
        $pageContent = preg_replace('/\[\[([A-Z0-9_]*?)\]\]/', '{\\1}' ,$pageContent);

        try {
            $objFile = new \Cx\Lib\FileSystem\File($this->path.$themes.'/'.$themesPage);
            $objFile->write($pageContent);
        } catch (\Cx\Lib\FileSystem\FileSystemException $e) {
            \DBG::msg($e->getMessage());
        }
    }

    /**
     * insert Skin into db and activate the theme on content pages
     *
     * @param   string     $themesName
     * @param   string     $themesFolder
     * @param   integer    $themeIdFromDatabaseBasedTheme
     */
    private function insertIntoDb($themesName, $themesFolder, $themeIdFromDatabaseBasedTheme = null)
    {
        global $objDatabase;

        if (empty($themesName) || empty($themesFolder)) {
            return;
        }

        $themeId = $this->insertSkinIntoDb($themesName, $themesFolder);

        if ($themeIdFromDatabaseBasedTheme) {
            $pageRepo = \Env::get('em')->getRepository('Cx\Core\ContentManager\Model\Entity\Page');
            $pages = $pageRepo->findBy(array(
                'skin' => intval($themeIdFromDatabaseBasedTheme),
            ));
            foreach ($pages as $page) {
                if ($page->getSkin() != 0) {
                    $page->setSkin($themeId);
                    \Env::get('em')->persist($page);
                }
            }
            \Env::get('em')->flush();
        }
    }

    /**
     * insert skin into db
     *
     * @access  public
     * @global  ADONewConnection
     * @param   string              $themesName
     * @param   string              $themesFolder
     * @return  integer
     */
    private function insertSkinIntoDb($themesName, $themesFolder)
    {
        global $objDatabase;

        $objDatabase->Execute('INSERT INTO `'.DBPREFIX.'skins` (`themesname`, `foldername`, `expert`) VALUES ("'.contrexx_raw2db($themesName).'", "'.contrexx_raw2db($themesFolder).'", 1)');

        return $objDatabase->Insert_ID();
    }

    /**
     * add new skin file
     * @access   public
     */
    private function newfile()
    {
        global $_CORELANG;

        Permission::checkAccess(47, 'static');

        $themes = !empty($_POST['themes']) && !stristr($_POST['themes'], '..') ? contrexx_input2raw($_POST['themes']) : null;
        $themesFile = !empty($_POST['themesNewFileName']) && !stristr($_POST['themesNewFileName'], '..') ? \Cx\Lib\FileSystem\FileSystem::replaceCharacters($_POST['themesNewFileName']) : null;
        if (empty($themesFile) || empty($themes)) {
            return false;
        }
        if (!FWValidator::is_file_ending_harmless($themesFile)) {
            return false;
        }

        try {
            $objFile = new \Cx\Lib\FileSystem\File($this->path.$themes.'/'.$themesFile);
            $objFile->touch();
        } catch (\Cx\Lib\FileSystem\FileSystemException $e) {
            \DBG::msg($e->getMessage());
            return false;
        }

        $this->strOkMessage = $themesFile." ".$_CORELANG['TXT_STATUS_SUCCESSFULLY_CREATE'];
    }

    /**
     * del skin file
     * @access   public
     */
    function delfile()
    {
        global $_CORELANG;

        Permission::checkAccess(47, 'static');

        $themesFile = isset($_POST['themesDelFileName']) ? $_POST['themesDelFileName'] : '';
        $themes = isset($_POST['themes']) ? $_POST['themes'] : '';

        if (empty($themesFile) || empty($themes)) {
            return;
        }

        $directory = new RecursiveDirectoryIterator($this->path.$themes);
        $iterator = new RecursiveIteratorIterator($directory);
        $objects = new RegexIterator($iterator, '/^.+'.$themesFile.'$/i', RecursiveRegexIterator::GET_MATCH);

        // iterate through all objects in the folder and search for matching files
        foreach ($objects as $object) {
            if (\Cx\Lib\FileSystem\FileSystem::delete_file(current($object))) {
                $this->strOkMessage = $themesFile.": ".$_CORELANG['TXT_STATUS_SUCCESSFULLY_DELETE'];
            }
        }
    }

    /**
     * del skin folder and all files in it
     * @param    bool    $nockeck
     * @access   public
     * @global   ADONewConnection
     * @global   array
     */
    function deldir($nocheck = false)
    {
        global $objDatabase, $_CORELANG;

        Permission::checkAccess(47, 'static');

        $themes = isset($_POST['themesDelName']) ? contrexx_input2raw($_POST['themesDelName']) : '';
        if ($themes == '' && !empty($_GET['delete'])){
            $themes = contrexx_input2raw($_GET['delete']);
        }

        $themes = str_replace(array('..','/'), '', $themes);
        if ($themes == '') {
            return;
        }

        $_POST['themes'] = !empty($_POST['themes']) ? contrexx_input2raw($_POST['themes']) : '';
        if ($nocheck && $_POST['themes'] == $themes) {
            $this->strErrMessage = $_CORELANG['TXT_STATUS_FILE_CURRENTLY_OPEN'];
            return false;
        }

        $dir = ($this->path.$themes);
        // delete whole folder with subfolders in case it exists
        if (   file_exists($dir)
            && !\Cx\Lib\FileSystem\FileSystem::delete_folder($this->path.$themes, true)
        ) {
            $this->strErrMessage = $themes.": ".$_CORELANG['TXT_STATUS_CANNOT_DELETE'];
            return false;
        }

        $theme = $this->themeRepository->findOneBy(array('foldername' => $themes));
        if (!$theme) {
            $this->strErrMessage = $themes.": ".$_CORELANG['TXT_STATUS_CANNOT_DELETE'];
            return false;
        }

        if (!$objResult->EOF) {
            $themesId = $objResult->fields['id'];

            $pageRepo = \Env::get('em')->getRepository('Cx\Core\ContentManager\Model\Entity\Page');
            $pages = $pageRepo->findBy(array(
                'skin' => intval($themesId),
            ));
            foreach ($pages as $page) {
                $page->setSkin(0);
                \Env::get('em')->persist($page);
            }
            \Env::get('em')->flush();
        }
        
        if ($this->themeRepository->remove($theme)) {
            $this->strOkMessage = $themes.": ".$_CORELANG['TXT_STATUS_SUCCESSFULLY_DELETE'];
            return true;
        }

        $this->strErrMessage = $themes.": ".$_CORELANG['TXT_STATUS_CANNOT_DELETE'];
        return false;
    }

    /**
     * Gets the dropdown menus content
     * @access public
     */
    function getDropdownContent()
    {
        global $objTemplate;
        $themes = !empty($_REQUEST['themes']) && !stristr($_REQUEST['themes'], '..') ? contrexx_input2raw($_REQUEST['themes']) : '';
        $themesPage = !empty($_POST['themesPage']) && !stristr($_REQUEST['themes'], '..') ? contrexx_addslashes($_POST['themesPage']) : '';
        $theme = $this->themeRepository->findOneBy(array('foldername' => $themes));
        $objTemplate->setVariable(array(
            'THEMES_PAGES_MENU'     => $this->getFilesDropdown($theme, $themesPage),
            'THEMES_MENU'           => $this->getThemesDropdown($theme),
            'THEMES_PAGE_VALUE'     => $this->getFilesContent($theme, $themesPage),
            'THEMES_PAGE_DEL_VALUE' => $this->getFilesDropdownDel($theme),
            'THEMES_MENU_DEL'       => $this->_getThemesDropdownDelete(),
        ));
    }
    
    /**
     * Save the library settings which have been done on the overview page
     * @param \Cx\Core\View\Model\Entity\Theme $theme the template object
     */
    protected function saveLibrarySettings($theme)
    {
        global $_CORELANG;
        // only save if the form has been fired
        if (!isset($_POST['libraryVersion'])) return;
        
        $libraries = JS::getConfigurableLibraries();
        
        // create dependencies array with provided data from form
        $dependencies = array();
        foreach ($_POST['libraryVersion'] as $libraryName => $version) {
            if (empty($version)) continue;            
            $dependencies[$libraryName] = array(
                'name' => $libraryName,
                'type' => 'lib',
                'minimumVersionNumber' => $version,
                'maximumVersionNumber' => $version,
            );
        }
        
        $automaticallyModifiedDependencySettings = array();
        
        // check for dependencies of configured libraries
        foreach ($dependencies as $dependency) {
            $dependencyIssue = false;
            $libraryInfo = $libraries[$dependency['name']]['versions'][$dependency['minimumVersionNumber']];
            if (isset($libraryInfo['dependencies'])) {
                // loop through dependencies which are required for the activated library
                foreach ($libraryInfo['dependencies'] as $dependencyName => $dependencyVersionRegex) {
                    
                    // dependency not configured or needed version not matching regex
                    if (   !isset($dependencies[$dependencyName])
                        || !preg_match('/' . $dependencyVersionRegex . '/', $dependencies[$dependencyName]['minimumVersionNumber'])) {
                        $dependencyIssue = true;
                    }
                    
                    if ($dependencyIssue) {
                        // find matching library version
                        foreach ($libraries[$dependencyName]['versions'] as $version => $files) {
                            if (preg_match('/' . $dependencyVersionRegex . '/', $version)) {
                                $dependencies[$dependencyName] = array(
                                    'name' => $dependencyName,
                                    'type' => 'lib',
                                    'minimumVersionNumber' => $version,
                                    'maximumVersionNumber' => $version,
                                );
                                $automaticallyModifiedDependencySettings[] = $dependencyName;
                                break;
                            }
                        }
                    }
                }
            }
        }
        
        if (!empty($automaticallyModifiedDependencySettings)) {
            $this->strErrMessage = sprintf($_CORELANG['TXT_THEME_LIBRARY_AUTOMATICALLY_ADJUSTED'], implode(', ', $automaticallyModifiedDependencySettings));
        }
        
        // save component.yaml file
        $theme->setDependencies($dependencies);
        try {
            $this->themeRepository->saveComponentData($theme);
        } catch (\Cx\Lib\FileSystem\FileSystemException $e) {
            $this->strErrMessage = $_CORELANG['TXT_COULD_NOT_WRITE_TO_FILE'] . ': ' . ASCMS_THEMES_PATH . '/' . $theme->getFoldername() . '/component.yml';
        }
    }
    
    /**
     * Get the library settings column on overview page
     * @param \Cx\Core\View\Model\Entity\Theme $theme the template object
     */
    protected function getLibrarySettings($theme)
    {
        global $objTemplate, $_CORELANG;
        
        $libraries = JS::getConfigurableLibraries();
        
        $objTemplate->setVariable(array(
            'TXT_TEMPLATE_USED_LIBRARIES'     => $_CORELANG['TXT_TEMPLATE_USED_LIBRARIES'],
            'TXT_SAVE'                        => $_CORELANG['TXT_SAVE'],
            'THEMES_SELECTED_THEME'           => $theme->getFoldername(),
        ));
        $objTemplate->setGlobalVariable('TXT_THEME_LIBRARY_NOT_USED', $_CORELANG['TXT_THEME_LIBRARY_NOT_USED']);
        
        $usedLibraries = $theme->getDependencies();
        
        // parse available libraries as setting tab
        $objTemplate->setCurrentBlock('theme_library');
        foreach ($libraries as $libraryName => $libraryInfo) {
            foreach ($libraryInfo['versions'] as $version => $files) {
                $objTemplate->setVariable(array(
                    'THEME_LIBRARY_NAME' => $libraryName,
                    'THEME_LIBRARY_VERSION' => $version,
                    'THEME_LIBRARY_VERSION_SELECTED' => $version == $usedLibraries[$libraryName][0] ? 'selected="selected"' : '', 
                ));
                
                $objTemplate->parse('theme_library_version');
            }
            
            if (array_key_exists($libraryName, $usedLibraries)) {
                $objTemplate->setVariable('THEME_LIBRARY_ACTIVE_CHECKED', 'checked="checked"');
            } else {
                $objTemplate->setVariable('THEME_LIBRARY_VERSION_DROPDOWN_HIDDEN', 'style="display: none;"');
            }
            
            $objTemplate->setVariable('THEME_LIBRARY_NAME', $libraryName);
            $objTemplate->parseCurrentBlock();
        }
    }

    /**
     * Gets the activated themes dropdown menu
     * @access   public
     * @param    string   $themes (optional)
     * @return   string   $atdm
     */
    function _getDropdownActivated($selectedTheme)
    {
        $themes = $this->themeRepository->findAll();
        $selectedTheme = $this->themeRepository->findById($selectedTheme);
        $html = '';
        foreach ($themes as $theme) {
            $selected = '';
            if ($theme == $selectedTheme) {
                $selected = 'selected="selected"';
            }
            $html .= '<option value="'.$theme->getId().'" '.$selected.'>'.contrexx_raw2xhtml($theme->getThemesname()).'</option>';
            $html .= "\n";
        }
        return $html;
    }

    /**
     * Gets the themes dropdown menu
     * @param    string   $selectedTheme the currently selected theme
     * @param    boolean  $selectDefault pre select default theme if no theme is selected yet
     * @return string $tdm the html code for the drop down
     */
    function getThemesDropdown($selectedTheme = null, $selectDefault = true)
    {
        global $_CORELANG;
        if (!$selectedTheme && $selectDefault) {
            $selectedTheme = $this->themeRepository->getDefaultTheme();
        }
        
        $themes = $this->themeRepository->findAll(array('themesname', 'id'));
        usort($themes, array($this, 'sortThemesByDefault'));
        
        $tdm = '';
        foreach ($themes as $item) {
            $selected = "";
            $default = "";
            $mobilestyle = "";
            $printstyle = "";
            $pdfstyle = "";
            $appstyle = "";
            if ($item->isDefault(\Cx\Core\View\Model\Entity\Theme::THEME_TYPE_WEB)){
                $default = "(".$_CORELANG['TXT_DEFAULT'].")";
            }
            if ($item->isDefault(\Cx\Core\View\Model\Entity\Theme::THEME_TYPE_MOBILE)){
                $mobilestyle = "(".$_CORELANG['TXT_ACTIVE_MOBILE_TEMPLATE'].")";
            }
            if ($item->isDefault(\Cx\Core\View\Model\Entity\Theme::THEME_TYPE_PRINT)){
                $printstyle = "(".$_CORELANG['TXT_THEME_PRINT'].")";
            }
            if ($item->isDefault(\Cx\Core\View\Model\Entity\Theme::THEME_TYPE_PDF)){
                $pdfstyle = "(".$_CORELANG['TXT_THEME_PDF'].")";
            }
            if ($item->isDefault(\Cx\Core\View\Model\Entity\Theme::THEME_TYPE_APP)){
                $appstyle = "(".$_CORELANG['TXT_APP_VIEW'].")";
            }
            if ($selectedTheme == $item) $selected = "selected";
            $tdm .='<option id="'.$item->getId()."\" value='".$item->getFoldername()."' $selected>".contrexx_stripslashes($item->getThemesname())." ".$default.$mobilestyle.$printstyle.$pdfstyle.$appstyle."</option>\n";
        }
        return $tdm;
    }


    /**
     * Gets the themes dropdown menu
     * @access   private
     * @global   ADONewConnection
     * @param    string   $themes (optional)
     * @return   string   $tdm
     */
    function _getThemesDropdownDelete()
    {
        $html = '';
        $themes = $this->themeRepository->findAll();
        usort($themes, array($this, 'sortThemesByDefault'));
        foreach ($themes as $theme) {
            if ($theme->isDefault()) continue;
            $html .= "<option value='".contrexx_raw2xhtml($theme->getFoldername())."'>".contrexx_raw2xhtml($theme->getThemesname())."</option>\n";
        }
        return $html;
    }

    /**
     * Get subdirectory contents
     * @param string $strDir
     * @param bool $boolRecursive
     * @param bool $boolIncludeDirs
     * @return array $this->subDirs
     */
    function _getDirListing($strDir, $arrAllowedFileExtensions, $level = 0, $boolRecursive = true, $boolIncludeDirs = true) {
        $dirs = array();
        $hDir = opendir($strDir);
        if ($hDir) {
            $level++;
            $strFile = readdir($hDir);
            while ($strFile !== false) {
                // don't need ., .., .svn
                if (in_array($strFile, array('.', '..', '.svn'))) {
                    $strFile = readdir($hDir);
                    continue;
                }

                if (is_dir($strDir. "/" . $strFile)) {
                    if ($boolRecursive)
                        $dirs = array_merge($dirs, $this->_getDirListing($strDir .'/'. $strFile, $arrAllowedFileExtensions, $level, $boolRecursive, $boolIncludeDirs));
                    if ($boolIncludeDirs){
                        $strPath = $strDir .'/'. $strFile;
                        $strFile = str_replace($this->_parentPath.'/', '', $strDir .'/'. $strFile);
                        $dirs[$strPath] = array(
                            'rel'  => preg_replace('/\/\//si', '/', $strFile),
                            'file'  => basename($strFile),
                            'level' => $level,
                        );
                    }
                }
                elseif (!in_array(substr($strFile, strrpos($strFile, '.')), $arrAllowedFileExtensions)) {
                    $strPath = $strDir .'/'. $strFile;
                    $strFile = str_replace($this->_parentPath.'/', '', $strDir .'/'. $strFile);
                    $dirs[$strPath] = array(
                        'rel'  => preg_replace('/\/\//si', '/', $strFile),
                        'file'  => basename($strFile),
                        'level' => $level,
                    );
                }
                $strFile = readdir($hDir);
            }
            closedir($hDir);
        }
        return $dirs;
    }


    /**
     * Gets the themes pages dropdown menu
     * @access   public
     * @param    string   $themes
     * @param    string   $themesPage (optional)
     * @return   string   $fdm
     */
    function getFilesDropdown($themes = null, $themesPage="")
    {
        global $_CORELANG;

        if (!$themes) {
            $themes = $this->themeRepository->getDefaultTheme();
        }
        $themes = $themes->getFoldername();
        if (!isset($themesPage)) {
            $themesPage = "index.html";
        }
        $fdm = '';
        $special = '';
        $default = '';
        $defaultFiles = array();
        $selected = "";

        if ($themes != "") {
            $file = $this->path.$themes;
            if (file_exists($file)) {
                $this->_parentPath = $file;
                $skin_folder_page = opendir($file);
                $strPage = readdir($skin_folder_page);
                while (false !== $strPage) {
                    if (!in_array($strPage, array('.', '..', '.svn')) && is_dir($file.'/'.$strPage)){
                        $this->subDirs = array_merge($this->subDirs, $this->_getDirListing($file.'/'.$strPage, $this->fileextensions));
                    }
                    $extension = preg_split("/\./",$strPage);
                    $x = count($extension)-1;
                    if (in_array($extension[$x], $this->fileextensions)) {
                        if (in_array($strPage, $this->filenames)) {
                            if ($strPage != "." && $strPage != "..") {
                                $defaultFiles[] = $strPage;
                            }
                        } else {
                            if ($strPage != "." && $strPage != "..") {
                                $selected="";
                                if ($themesPage==$strPage) $selected = 'selected="selected"';
                                $special .="<option value='".$strPage."' $selected>".$strPage."</option>\n";
                            }
                        }
                    }
                    $strPage = readdir($skin_folder_page);
                }
                closedir($skin_folder_page);
                ksort($this->subDirs, SORT_STRING);
                $subdirContent = '';
                foreach ($this->subDirs as $absolutePath => $arrFile) {
                    $disabled = $selected = '';
                    $strName = str_repeat('&hellip;', $arrFile['level']).$arrFile['file'];
                    if ($themesPage == $arrFile['rel']){ $selected = 'selected="selected"'; }
                    if (is_dir($absolutePath)){ $disabled = 'disabled="disabled"'; $strName .= '/'; }
                    $subdirContent .= "<option value='".($disabled != '' ? '' : $arrFile['rel'])."' $disabled $selected>".$strName."</option>\n";
                }
                //sort files
                sort($defaultFiles);
                foreach ($defaultFiles as $strPage){
                    $selected="";
                    if ($themesPage==$strPage) $selected = "selected";
                    $default .="<option value='".$strPage."' $selected>".$strPage."</option>\n";
                }
                //create dropdown
                $seperator = "<option value=''>----------------------------------------</option>\n";
                $fdm = $default.$seperator.$special.$seperator.$subdirContent;
            } else {
                $this->strErrMessage = $_CORELANG['TXT_STATUS_CANNOT_OPEN'];
            }
        }
        else {
            $fdm .="<option value='1' $selected>".$_CORELANG['TXT_CHOOSE_DESIGN']."</option>\n";
        }
        return $fdm;
    }

    /**
     * Gets the themes pages dropdown menu del
     * @access   public
     * @return   string   $fdmd
     */
    function getFilesDropdownDel($themes = null)
    {
        global $_CORELANG;
        if (!$themes) {
            $themes = $this->themeRepository->getDefaultTheme();
        }
        $themes = $themes->getFoldername();
        $fdmd = "";

        if ($themes != "") {
            $file = $this->path.$themes;
            if (file_exists($file)) {
                $directory = new RecursiveDirectoryIterator($file);
                $objects = new RecursiveIteratorIterator($directory);

                foreach ($objects as $name => $object) {
                    $fileName = $object->getFileName();
                    $extension = preg_split("/\./", $fileName);
                    $x = count($extension)-1;
                    if (in_array($extension[$x], $this->fileextensions)) {
                        if (($fileName != ".") && ($fileName != "..") && (!in_array($fileName, $this->filenames))) {
                            $fdmd .="<option value='".$fileName."'>".$fileName."</option>\n";
                        }
                    }
                }
            } else {
                $fdmd .="<option value='1'>".$_CORELANG['TXT_CHOOSE_DESIGN']."</option>\n";
            }
        }
        return $fdmd;
    }

    /**
     * Gets the themes pages file content
     * @access   public
     * @param    string   $themes
     * @param    string   $themesPage
     * @return   string   $fileContent
     */
    function getFilesContent($themes = null, $themesPage="")
    {
        global $objDatabase, $objTemplate;
        if (!$themes) {
            $themes = $this->themeRepository->getDefaultTheme();
        }
        $themes = $themes->getFoldername();
        if (!isset($themesPage)) {
            $themesPage = "index.html";
        }        
        if ($themes != "" && $themesPage != ""){
            $file = $this->path.$themes.'/'.$themesPage;            
            if (file_exists($file)) {
                $fileIsImage = ImageManager::_isImage($file);                
                $contenthtml = '';
                if (!$fileIsImage) {
                    $contenthtml = file_get_contents($file);
                    $contenthtml = preg_replace('/\{([A-Z0-9_]*?)\}/', '[[\\1]]', $contenthtml);
                    $contenthtml = htmlspecialchars($contenthtml);
                }                
// TODO: Pointless!
//                $objResult = $objDatabase->Execute("SELECT id,expert FROM ".DBPREFIX."skins WHERE foldername = '".$themes."'");
//                if ($objResult !== false) {
//                    while (!$objResult->EOF) {
//                        $expert = $objResult->fields['expert'];
//                        $objResult->MoveNext();
//                    }
//                }                
                $objTemplate->setVariable(array(
                    'THEMES_SELECTED_THEME'    => $themes,
                    'THEMES_SELECTED_PAGENAME' => $themesPage,
                    'THEMES_FULL_PATH'         => $this->webPath.$themes.'/'.$themesPage,
                    'CONTENT_HTML'             => $contenthtml,                    
                ));                
                if ($fileIsImage) {
                    $objTemplate->touchBlock('template_image');
                    $objTemplate->hideBlock('template_content');
                    $objTemplate->hideBlock('file_actions_top');
                    $objTemplate->hideBlock('file_actions_bottom');
                } else {
                    $objTemplate->touchBlock('file_actions_top');
                    $objTemplate->touchBlock('file_actions_bottom');
                    $objTemplate->touchBlock('template_content');
                    $objTemplate->hideBlock('template_image');
                }
                //return $fileContent;
            }
        } else {
            $objTemplate->hideBlock('file_actions_top');
            $objTemplate->hideBlock('file_actions_bottom');
        }
    }

    /**
     * create default themepages
     * @todo    add proper error handling
     */
    private function createDefaultFiles($themeDirectory)
    {
        global $_CORELANG, $_FTPCONFIG;

        foreach ($this->directories as $dir) {
            if (!\Cx\Lib\FileSystem\FileSystem::make_folder($this->path.$themeDirectory.'/'.$dir)) {
                $this->strErrMessage = sprintf($_CORELANG['TXT_UNABLE_TO_CREATE_FILE'], contrexx_raw2xhtml($this->path.$themeDirectory.'/'.$dir));
                return false;
            }
        }

        //copy "not available" preview.gif as default preview image
        if (!file_exists($this->path.$themeDirectory.'/images/preview.gif')) {
            if (!\Cx\Lib\FileSystem\FileSystem::copy_file(ASCMS_ADMIN_TEMPLATE_PATH.'/images/preview.gif', $this->path.$themeDirectory.'/images/preview.gif')) {
                $this->strErrMessage = sprintf($_CORELANG['TXT_UNABLE_TO_CREATE_FILE'], contrexx_raw2xhtml($this->path.$themeDirectory.'/images/preview.gif'));
                return false;
            }
        }

        foreach ($this->filenames as $file) {
            // skip component.yml, will be created later
            if ($file == 'component.yml') continue;
            if (!file_exists($this->path.$themeDirectory.'/'.$file)) {
                try {
                    $objFile = new \Cx\Lib\FileSystem\File($this->path.$themeDirectory.'/'.$file);
                    $objFile->touch();
                    //$objFile->makeWritable();
                } catch (\Cx\Lib\FileSystem\FileSystemException $e) {
                    \DBG::msg($e->getMessage());
                    $this->strErrMessage = sprintf($_CORELANG['TXT_UNABLE_TO_CREATE_FILE'], contrexx_raw2xhtml($this->path.$themeDirectory.'/'.$file));
                    return false;
                }
            }
        }
        
        // write component.yml file
        // this line will create a default component.yml file
        $this->themeRepository->convertThemeToComponent($themeDirectory);

        return true;
    }

    /**
     * check iftable exists
     * @access   public
     * @param    string   $table
     */
    function checkTable($table)
    {
        global $objDatabase;
        $arrTables = array();
        // get tables in database
        $arrTables = $objDatabase->MetaTables('TABLES');
        if ($arrTables !== false) {
            if (in_array($table, $arrTables)) {
                $this->tableExists = "tblexists";
                $this->getDbDropdown($table);
                $this->dropTable($this->oldTable);
            }
        }
    }

    /**
     * create db themes dropdownmenu
     * @access   public
     */
    function getDbDropdown()
    {
        global $objDatabase, $_CORELANG, $objTemplate;
        if ($this->tableExists == "tblexists") {
            $tdm = "<select name='fromDB' onchange='existingdirNameValue2()' size='1' style='WIDTH: 150px'>";
            $tdm .="<option value=''>--- Aus Datenbank ----------</option>";
            $objResult = $objDatabase->query("SELECT id,themesname FROM ".$this->oldTable." ORDER BY id");
            $defaultThemeId = $this->selectDefaultTheme();
            $default = '';
            if ($objResult !== false) {
                while (!$objResult->EOF) {
                    if ($objResult->fields['id'] == $defaultThemeId){
                        $default = "(".$_CORELANG['TXT_DEFAULT'].")";
                    }
                    $tdm .="<option value='".$objResult->fields['id']."'>".$objResult->fields['themesname']." ".$default."</option>\n";
                    $default='';
                    $objResult->MoveNext();
                }
            }
            $tdm .="</select>";
            $objTemplate->setVariable('TXT_FROM_DB',$tdm);
        }
    }

    /**
     * create files from db
     * @param string $themes
     * @param string $fromDB
     */
    function createFilesFromDB($themes, $fromDB)
    {
// TODO: remove this function -> migrate all pending themes in the update process
// TODO: migrate to new filesystem \Cx\Lib\FileSystem
        global $objDatabase, $_CORELANG;

        $themePages = array();

        $objResult = $objDatabase->Execute("SELECT * FROM ".$this->oldTable." WHERE id='".$fromDB."'");
        if ($objResult !== false) {
            while (!$objResult->EOF) {
                $themePages['index.html'] = stripslashes($objResult->fields['indexpage']);
                $themePages['content.html'] =  stripslashes($objResult->fields['content']);
                $themePages['home.html'] =  stripslashes($objResult->fields['home']);
                $themePages['navbar.html'] =  stripslashes($objResult->fields['navbar']);
                $themePages['subnavbar.html'] =  stripslashes($objResult->fields['subnavbar']);
                $themePages['sidebar.html'] =  stripslashes($objResult->fields['sidebar']);
                $themePages['shopnavbar.html'] =  stripslashes($objResult->fields['shopnavbar']);
                $themePages['headlines.html'] =  stripslashes($objResult->fields['headlines']);
                $themePages['javascript.js'] =  stripslashes($objResult->fields['javascript']);
                $themePages['style.css'] =  stripslashes($objResult->fields['style']);
                $objResult->MoveNext();
            }
        }

        for($x = 0; $x < count($this->filenames); $x++) {
            $fp = fopen ($this->path.$themes.'/'.$this->filenames[$x] ,"w");
            fwrite($fp,"");
            fclose($fp);

            $filename = $this->path.$themes.'/'.$this->filenames[$x];

            //check, if file exists and is writable
            if (\Cx\Lib\FileSystem\FileSystem::makeWritable($filename)) {
                //open file
                if (!$handle = fopen($filename, "a")) {
                     $this->strErrMessage = $_CORELANG['TXT_STATUS_CANNOT_OPEN'];
                }
                //write file
                if (!fwrite($handle, $themePages[$this->filenames[$x]])) {
                    $this->strErrMessage =  $_CORELANG['TXT_STATUS_CANNOT_WRITE'];
                }
                fclose($handle);
                $this->strOkMessage = $_CORELANG['TXT_STATUS_SUCCESSFULLY_CREATE'];
                $this->overview();
            } else {
                $this->strErrMessage = $_CORELANG['TXT_STATUS_CANNOT_WRITE'];
            }
        }
    }
    
    /**
     * Sorts the themes by default value. that means,
     * the themes which have been set as default for a theme type,
     * they are listed first. 
     * @param Cx\Core\View\Model\Entity\Theme $a theme 1
     * @param Cx\Core\View\Model\Entity\Theme $b theme 2
     * @return int
     */
    public function sortThemesByDefault($a, $b) {
        if ($a->isDefault() && $b->isDefault()) {
            return 0;
        }
        if ($a->isDefault() && !$b->isDefault()) {
            return -1;
        }
        return 1;
    }


    /**
     * if now rows in table -> drop $this->oldTable
     * @access   public
     */
    function dropTable()
    {
        global $objDatabase;

        $objResult = $objDatabase->Execute("SELECT id FROM ".$this->oldTable." ORDER BY id");
        if ($objResult) {
            if ($objResult->RecordCount() == 0) {
                $objDatabase->Execute("DROP TABLE ".$this->oldTable);
            }
        }
    }
}
