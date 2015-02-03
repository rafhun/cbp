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
 * Digital Asset Management
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_downloads
 * @version     1.0.0
 */

/**
* Digital Asset Management Frontend
* @copyright    CONTREXX CMS - COMVATION AG
* @author       COMVATION Development Team <info@comvation.com>
* @package      contrexx
* @subpackage   module_downloads
* @version      1.0.0
*/
class downloads extends DownloadsLibrary
{
    private $htmlLinkTemplate = '<a href="%s" title="%s">%s</a>';
    private $htmlImgTemplate = '<img src="%s" alt="%s" />';
    private $moduleParamsHtml = '?section=downloads';
    private $moduleParamsJs = '?section=downloads';
    private $userId;
    private $categoryId;
    private $cmd = '';
    private $pageTitle;
    /**
     * @var \Cx\Core\Html\Sigma
     */
    private $objTemplate;
    /**
     * Contains the info messages about done operations
     * @var array
     * @access private
     */
    private $arrStatusMsg = array('ok' => array(), 'error' => array());


    /**
    * Constructor
    *
    * Calls the parent constructor and creates a local template object
    * @param $strPageContent string The content of the page as string.
    * @param $queryParams array The constructor accepts an array parameter $queryParams, which will
    *                           override the request parameters cmd and/or category, if given
    * override the request parameters cmd and/or category
    */
    function __construct($strPageContent, array $queryParams = array())
    {
        parent::__construct();

        $objFWUser = FWUser::getFWUserObject();
        $this->userId = $objFWUser->objUser->login() ? $objFWUser->objUser->getId() : 0;
        $this->parseURLModifiers($queryParams);
        $this->objTemplate = new \Cx\Core\Html\Sigma('.');
        CSRF::add_placeholder($this->objTemplate);
        $this->objTemplate->setErrorHandling(PEAR_ERROR_DIE);
        $this->objTemplate->setTemplate($strPageContent);
    }

    private function parseURLModifiers($queryParams)
    {
        $cmd = isset($queryParams['cmd']) ? $queryParams['cmd'] : (isset($_REQUEST['cmd']) ? $_REQUEST['cmd'] : '');

        if (isset($_GET['download'])) {
            $this->cmd = 'download_file';
        } elseif (isset($_GET['delete_file'])) {
            $this->cmd = 'delete_file';
        } elseif (isset($_GET['delete_category'])) {
            $this->cmd = 'delete_category';
        } elseif ($cmd) {
            $this->cmd = $cmd;
        }

        if ($cmd) {
            $this->moduleParamsHtml .= '&cmd='.htmlentities($cmd, ENT_QUOTES, CONTREXX_CHARSET);
            $this->moduleParamsJs .= '&cmd='.htmlspecialchars($cmd, ENT_QUOTES, CONTREXX_CHARSET);
        }

        if (intval($cmd)) {
            $this->categoryId = isset($queryParams['category']) ? $queryParams['category'] : (!empty($_REQUEST['category']) ? intval($_REQUEST['category']) : intval($cmd));
        } else {
            $this->categoryId = isset($queryParams['category']) ? $queryParams['category'] : (!empty($_REQUEST['category']) ? intval($_REQUEST['category']) : 0);
        }
    }

    /**
    * Reads $this->cmd and selects (depending on the value) an action
    *
    */
    public function getPage()
    {
        CSRF::add_code();
        switch ($this->cmd) {
            case 'download_file':
                $this->download();
                exit;
                break;

            case 'delete_file':
                $this->deleteDownload();
                $this->overview();
                break;

            case 'delete_category':
                $this->deleteCategory();
                $this->overview();
                break;

            default:
                $this->overview();
                break;
        }

        $this->parseMessages();

        return $this->objTemplate->get();
    }


    private function parseMessages()
    {
        $this->objTemplate->setVariable(array(
            'DOWNLOADS_MSG_OK'      => count($this->arrStatusMsg['ok']) ? implode('<br />', $this->arrStatusMsg['ok']) : '',
            'DOWNLOADS_MSG_ERROR'   => count($this->arrStatusMsg['error']) ? implode('<br />', $this->arrStatusMsg['error']) : ''
        ));
    }


    private function deleteDownload()
    {
        global $_LANGID, $_ARRAYLANG;

        CSRF::check_code();
        $objDownload = new Download();
        $objDownload->load(isset($_GET['delete_file']) ? $_GET['delete_file'] : 0);

        if (!$objDownload->EOF) {
            $name = '<strong>'.htmlentities($objDownload->getName($_LANGID), ENT_QUOTES, CONTREXX_CHARSET).'</strong>';
            if ($objDownload->delete($this->categoryId)) {
                $this->arrStatusMsg['ok'][] = sprintf($_ARRAYLANG['TXT_DOWNLOADS_DOWNLOAD_DELETE_SUCCESS'], $name);
            } else {
                $this->arrStatusMsg['error'] = array_merge($this->arrStatusMsg['error'], $objDownload->getErrorMsg());
            }
        }
    }


    private function deleteCategory()
    {
        global $_LANGID, $_ARRAYLANG;

        CSRF::check_code();
        $objCategory = Category::getCategory(isset($_GET['delete_category']) ? $_GET['delete_category'] : 0);

        if (!$objCategory->EOF) {
            $name = '<strong>'.htmlentities($objCategory->getName($_LANGID), ENT_QUOTES, CONTREXX_CHARSET).'</strong>';
            if ($objCategory->delete()) {
                $this->arrStatusMsg['ok'][] = sprintf($_ARRAYLANG['TXT_DOWNLOADS_CATEGORY_DELETE_SUCCESS'], $name);
            } else {
                $this->arrStatusMsg['error'] = array_merge($this->arrStatusMsg['error'], $objCategory->getErrorMsg());
            }
        }
    }


    private function overview()
    {
        global $_LANGID;

        $objDownload = new Download();
        $objCategory = Category::getCategory($this->categoryId);

        if ($objCategory->getId()) {
            // check access permissions to selected category
            if (!Permission::checkAccess(143, 'static', true)
                && $objCategory->getReadAccessId()
                && !Permission::checkAccess($objCategory->getReadAccessId(), 'dynamic', true)
                && $objCategory->getOwnerId() != $this->userId
            ) {
// TODO: might we have to add a soft noAccess handler in case the output is meant for a regular page (not section=downloads)
                Permission::noAccess(base64_encode(CONTREXX_SCRIPT_PATH.$this->moduleParamsJs.'&category='.$objCategory->getId()));
            }

            // parse crumbtrail
            $this->parseCrumbtrail($objCategory);

            if ($objDownload->load(!empty($_REQUEST['id']) ? intval($_REQUEST['id']) : 0)
                && (!$objDownload->getExpirationDate() || $objDownload->getExpirationDate() > time())
            ) {
                /* DOWNLOAD DETAIL PAGE */
                $this->pageTitle = contrexx_raw2xhtml($objDownload->getName(FRONTEND_LANG_ID));

                $metakeys = $objDownload->getMetakeys(FRONTEND_LANG_ID);
                if ($this->arrConfig['use_attr_metakeys'] && !empty($metakeys)) {
                    \Env::get('cx')->getPage()->setMetakeys($metakeys);
                }

                $this->parseRelatedCategories($objDownload);
                $this->parseRelatedDownloads($objDownload, $objCategory->getId());

                $this->parseDownload($objDownload, $objCategory->getId());

                // hide unwanted blocks on the detail page
                if ($this->objTemplate->blockExists('downloads_category')) {
                    $this->objTemplate->hideBlock('downloads_category');
                }
                if ($this->objTemplate->blockExists('downloads_subcategory_list')) {
                    $this->objTemplate->hideBlock('downloads_subcategory_list');
                }
                if ($this->objTemplate->blockExists('downloads_file_list')) {
                    $this->objTemplate->hideBlock('downloads_file_list');
                }
                if ($this->objTemplate->blockExists('downloads_simple_file_upload')) {
                    $this->objTemplate->hideBlock('downloads_simple_file_upload');
                }
                if ($this->objTemplate->blockExists('downloads_advanced_file_upload')) {
                    $this->objTemplate->hideBlock('downloads_advanced_file_upload');
                }
            } else {
                /* CATEGORY DETAIL PAGE */
                $this->pageTitle = htmlentities($objCategory->getName($_LANGID), ENT_QUOTES, CONTREXX_CHARSET);

                // process create directory
                $this->processCreateDirectory($objCategory);

                // parse selected category
                $this->parseCategory($objCategory);

                // parse subcategories
                $this->parseCategories($objCategory, array('downloads_subcategory_list', 'downloads_subcategory'), null, 'SUB');

                // parse downloads of selected category
                $this->parseDownloads($objCategory);

                // parse upload form
                $this->parseUploadForm($objCategory);

                // parse create directory form
                $this->parseCreateCategoryForm($objCategory);

                // hide unwanted blocks on the category page
                if ($this->objTemplate->blockExists('downloads_download')) {
                    $this->objTemplate->hideBlock('downloads_download');
                }
                if ($this->objTemplate->blockExists('downloads_file_detail')) {
                    $this->objTemplate->hideBlock('downloads_file_detail');
                }
            }

            // hide unwanted blocks on the category/detail page
            if ($this->objTemplate->blockExists('downloads_overview')) {
                $this->objTemplate->hideBlock('downloads_overview');
            }
            if ($this->objTemplate->blockExists('downloads_most_viewed_file_list')) {
                $this->objTemplate->hideBlock('downloads_most_viewed_file_list');
            }
            if ($this->objTemplate->blockExists('downloads_most_downloaded_file_list')) {
                $this->objTemplate->hideBlock('downloads_most_downloaded_file_list');
            }
            if ($this->objTemplate->blockExists('downloads_most_popular_file_list')) {
                $this->objTemplate->hideBlock('downloads_most_popular_file_list');
            }
            if ($this->objTemplate->blockExists('downloads_newest_file_list')) {
                $this->objTemplate->hideBlock('downloads_newest_file_list');
            }
            if ($this->objTemplate->blockExists('downloads_updated_file_list')) {
                $this->objTemplate->hideBlock('downloads_updated_file_list');
            }
        } else {
            /* CATEGORY OVERVIEW PAGE */
            $this->parseCategories($objCategory, array('downloads_overview', 'downloads_overview_category'), null, null, 'downloads_overview_row', array('downloads_overview_subcategory_list', 'downloads_overview_subcategory'), $this->arrConfig['overview_max_subcats']);

            if (!empty($this->searchKeyword)) {
                $this->parseDownloads($objCategory);
            } else {
                if ($this->objTemplate->blockExists('downloads_file_list')) {
                    $this->objTemplate->hideBlock('downloads_file_list');
                }
            }

            /* PARSE MOST VIEWED DOWNLOADS */
            $this->parseSpecialDownloads(array('downloads_most_viewed_file_list', 'downloads_most_viewed_file'), array('is_active' => true, 'expiration' => array('=' => 0, '>' => time())) /* this filters purpose is only that the method Download::getFilteredIdList() gets processed */, array('views' => 'desc'), $this->arrConfig['most_viewed_file_count']);

            /* PARSE MOST DOWNLOADED DOWNLOADS */
            $this->parseSpecialDownloads(array('downloads_most_downloaded_file_list', 'downloads_most_downloaded_file'), array('is_active' => true, 'expiration' => array('=' => 0, '>' => time())) /* this filters purpose is only that the method Download::getFilteredIdList() gets processed */, array('download_count' => 'desc'), $this->arrConfig['most_downloaded_file_count']);

            /* PARSE MOST POPULAR DOWNLOADS */
            // TODO: Rating system has to be implemented first!
            //$this->parseSpecialDownloads(array('downloads_most_popular_file_list', 'downloads_most_popular_file'), null, array('rating' => 'desc'), $this->arrConfig['most_popular_file_count']);

            /* PARSE RECENTLY UPDATED DOWNLOADS */
            $filter = array(
                'ctime' => array(
                    '>=' => time() - $this->arrConfig['new_file_time_limit']
                ),
                'expiration' => array(
                    '=' => 0,
                    '>' => time()
                )
            );
            $this->parseSpecialDownloads(array('downloads_newest_file_list', 'downloads_newest_file'), $filter, array('ctime' => 'desc'), $this->arrConfig['newest_file_count']);

            // parse recently updated downloads
            $filter = array(
                'mtime' => array(
                    '>=' => time() - $this->arrConfig['updated_file_time_limit']
                ),
                // exclude newest downloads
                'ctime' => array(
                    '<' => time() - $this->arrConfig['new_file_time_limit']
                ),
                'expiration' => array(
                    '=' => 0,
                    '>' => time()
                )
            );
            $this->parseSpecialDownloads(array('downloads_updated_file_list', 'downloads_updated_file'), $filter, array('mtime' => 'desc'), $this->arrConfig['updated_file_count']);


            // hide unwanted blocks on the overview page
            if ($this->objTemplate->blockExists('downloads_category')) {
                $this->objTemplate->hideBlock('downloads_category');
            }
            if ($this->objTemplate->blockExists('downloads_crumbtrail')) {
                $this->objTemplate->hideBlock('downloads_crumbtrail');
            }
            if ($this->objTemplate->blockExists('downloads_subcategory_list')) {
                $this->objTemplate->hideBlock('downloads_subcategory_list');
            }
            if ($this->objTemplate->blockExists('downloads_file_detail')) {
                $this->objTemplate->hideBlock('downloads_file_detail');
            }
            if ($this->objTemplate->blockExists('downloads_simple_file_upload')) {
                $this->objTemplate->hideBlock('downloads_simple_file_upload');
            }
            if ($this->objTemplate->blockExists('downloads_advanced_file_upload')) {
                $this->objTemplate->hideBlock('downloads_advanced_file_upload');
            }
        }
        $this->parseGlobalStuff($objCategory);
    }

    public static function uploadFinished($tempPath, $tempWebPath, $data, $uploadId, $fileInfos) {
        global $objDatabase, $_ARRAYLANG, $_CONFIG;

        $originalNames = $fileInfos['originalFileNames'];

        $path = $data['path'];
        $webPath = $data['webPath'];
        $objCategory = Category::getCategory($data['category_id']);

        // check for sufficient permissions
        if ($objCategory->getAddFilesAccessId() && !Permission::checkAccess($objCategory->getAddFilesAccessId(), 'dynamic', true) && $objCategory->getOwnerId() != FWUser::getFWUserObject()->objUser->getId()) { return; }

        //we remember the names of the uploaded files here. they are stored in the session afterwards,
        //so we can later display them highlighted.
        $arrFiles = array();

        //rename files, delete unwanted
        $arrFilesToRename = array(); //used to remember the files we need to rename
        $h = opendir($tempPath);
        while (false !== ($file = readdir($h))) {
            //skip . and ..
            if ($file == '.' || $file == '..') { continue; }

            //delete potentially malicious files
            if (!FWValidator::is_file_ending_harmless($file)) {
                @unlink($tempPath.'/'.$file);
                continue;
            }

            $info = pathinfo($file);

            $cleanFile = \Cx\Lib\FileSystem\FileSystem::replaceCharacters($file);
            if ($cleanFile != $file) {
                rename($tempPath.'/'.$file, $tempPath.'/'.$cleanFile);
                $file = $cleanFile;
            }

            //check if file needs to be renamed
            $newName = '';
            $suffix = '';

            if (file_exists($path.'/'.$file)) {
                if (empty($_REQUEST['uploadForceOverwrite']) || !intval($_REQUEST['uploadForceOverwrite'] > 0)) {
                    $suffix = '_'.time();
                    $newName = $info['filename'].$suffix.'.'.$info['extension'];
                    $arrFilesToRename[$file] = $newName;
                    array_push($arrFiles, $newName);
                }
            }

            if(!isset($arrFilesToRename[$file])) { //file will keep this name - create thumb
                ImageManager::_createThumb($tempPath.'/', $tempWebPath.'/', $file);
            }

            $objDownloads = new downloads('');
            $objDownloads->addDownloadFromUpload($info['filename'], $info['extension'], $suffix, $objCategory, $objDownloads, $originalNames[$file]);
        }

        //rename files where needed
        foreach($arrFilesToRename as $oldName => $newName){
            rename($tempPath.'/'.$oldName, $tempPath.'/'.$newName);
            //file will keep this name - create thumb
            ImageManager::_createThumb($tempPath.'/', $tempWebPath.'/', $newName);
        }

        //remeber the uploaded files
        $_SESSION['media_upload_files_'.$uploadId] = $arrFiles;

        /* unwanted files have been deleted, unallowed filenames corrected.
           we can now simply return the desired target path, as only valid
           files are present in $tempPath */

        return array($path, $webPath);
    }

    public static function addDownloadFromUpload($fileName, $fileExtension, $suffix, $objCategory, $objDownloads, $sourceName)
    {
        $objDownload = new Download();

        // parse name and description attributres
        $arrLanguageIds = array_keys(FWLanguage::getLanguageArray());

        foreach ($arrLanguageIds as $langId) {
            $arrNames[$langId] = $sourceName;
            $arrDescriptions[$langId] = '';
            $arrSourcePaths[$langId] = ASCMS_DOWNLOADS_IMAGES_WEB_PATH.'/'.$fileName.$suffix.'.'.$fileExtension;
            $arrSourceNames[$langId] = $sourceName;
        }

        $fileMimeType = null;
        foreach (Download::$arrMimeTypes as $mimeType => $arrMimeType) {
            if (!count($arrMimeType['extensions'])) {
                continue;
            }
            if (in_array(strtolower($fileExtension), $arrMimeType['extensions'])) {
                $fileMimeType = $mimeType;
                break;
            }
        }

        $objDownload->setNames($arrNames);
        $objDownload->setDescriptions($arrDescriptions);
        $objDownload->setType('file');
        $objDownload->setSources($arrSourcePaths, $arrSourceNames);
        $objDownload->setActiveStatus(true);
        $objDownload->setMimeType($fileMimeType);
        if ($objDownload->getMimeType() == 'image') {
            $objDownload->setImage(ASCMS_DOWNLOADS_IMAGES_WEB_PATH.'/'.$fileName.$suffix.'.'.$fileExtension);
        }
        $objDownloads->arrConfig['use_attr_size'] ? $objDownload->setSize(filesize(ASCMS_DOWNLOADS_IMAGES_PATH.'/'.$fileName.$suffix.'.'.$fileExtension)) : null;
        $objDownload->setVisibility(true);
        $objDownload->setProtection(false);
        $objDownload->setGroups(array());
        $objDownload->setCategories(array($objCategory->getId()));
        $objDownload->setDownloads(array());

        if (!$objDownload->store($objCategory)) {
            $objDownloads->arrStatusMsg['error'] = array_merge($objDownloads->arrStatusMsg['error'], $objDownload->getErrorMsg());
            return false;
        } else {
            return true;
        }
    }

    private function processCreateDirectory($objCategory)
    {
        if (empty($_POST['downloads_category_name'])) {
            return;
        } else {
            $name = contrexx_stripslashes($_POST['downloads_category_name']);
        }

        CSRF::check_code();

        // check for sufficient permissiosn
        if ($objCategory->getAddSubcategoriesAccessId()
            && !Permission::checkAccess($objCategory->getAddSubcategoriesAccessId(), 'dynamic', true)
            && $objCategory->getOwnerId() != $this->userId
        ) {
            return;
        }

        // parse name and description attributres
        $arrLanguageIds = array_keys(FWLanguage::getLanguageArray());


        foreach ($arrLanguageIds as $langId) {
            $arrNames[$langId] = $name;
            $arrDescriptions[$langId] = '';
        }

        $objSubcategory = new Category();
        $objSubcategory->setParentId($objCategory->getId());
        $objSubcategory->setActiveStatus(true);
        $objSubcategory->setVisibility($objCategory->getVisibility());
        $objSubcategory->setNames($arrNames);
        $objSubcategory->setDescriptions($arrDescriptions);
        $objSubcategory->setPermissions(array(
            'read' => array(
                'protected' => (bool) $objCategory->getAddSubcategoriesAccessId(),
                'groups'    => array()
            ),
            'add_subcategories' => array(
                'protected' => (bool) $objCategory->getAddSubcategoriesAccessId(),
                'groups'    => array()
            ),
            'manage_subcategories' => array(
                'protected' => (bool) $objCategory->getAddSubcategoriesAccessId(),
                'groups'    => array()
            ),
            'add_files' => array(
                'protected' => (bool) $objCategory->getAddSubcategoriesAccessId(),
                'groups'    => array()
            ),
            'manage_files' => array(
                'protected' => (bool) $objCategory->getAddSubcategoriesAccessId(),
                'groups'    => array()
            )
        ));

//
//            foreach ($this->arrPermissionTypes as $protectionType) {
//                $arrCategoryPermissions[$protectionType]['protected'] = isset($_POST['downloads_category_'.$protectionType]) && $_POST['downloads_category_'.$protectionType];
//                $arrCategoryPermissions[$protectionType]['groups'] = !empty($_POST['downloads_category_'.$protectionType.'_associated_groups']) ? array_map('intval', $_POST['downloads_category_'.$protectionType.'_associated_groups']) : array();
//            }
//
//            $objCategory->setPermissionsRecursive(!empty($_POST['downloads_category_apply_recursive']));
//            $objCategory->setPermissions($arrCategoryPermissions);

        if (!$objSubcategory->store()) {
            $this->arrStatusMsg['error'] = array_merge($this->arrStatusMsg['error'], $objSubcategory->getErrorMsg());
        }
    }


    private function parseUploadForm($objCategory)
    {
        global $_CONFIG, $_ARRAYLANG;

        if (!$this->objTemplate->blockExists('downloads_simple_file_upload') && !$this->objTemplate->blockExists('downloads_advanced_file_upload')) {
            return;
        }

        // check for upload permissiosn
        if ($objCategory->getAddFilesAccessId()
            && !Permission::checkAccess($objCategory->getAddFilesAccessId(), 'dynamic', true)
            && $objCategory->getOwnerId() != $this->userId
        ) {
            if ($this->objTemplate->blockExists('downloads_simple_file_upload')) {
                $this->objTemplate->hideBlock('downloads_simple_file_upload');
            }
            if ($this->objTemplate->blockExists('downloads_advanced_file_upload')) {
                $this->objTemplate->hideBlock('downloads_advanced_file_upload');
            }
            return;
        }

        if ($this->objTemplate->blockExists('downloads_simple_file_upload')) {
            $objFWSystem = new FWSystem();

            //Uploader button handling
            JS::activate('cx');
            require_once ASCMS_CORE_MODULE_PATH.'/upload/share/uploadFactory.class.php';
            //paths we want to remember for handling the uploaded files
            $data = array(
                'path' => ASCMS_DOWNLOADS_IMAGES_PATH,
                'webPath' => ASCMS_DOWNLOADS_IMAGES_WEB_PATH,
                'category_id' => $objCategory->getId(),
            );
            $comboUp = UploadFactory::getInstance()->newUploader('exposedCombo');
            $comboUp->setFinishedCallback(array(ASCMS_MODULE_PATH.'/downloads/index.class.php', 'downloads', 'uploadFinished'));
            $comboUp->setData($data);
            //set instance name to combo_uploader so we are able to catch the instance with js
            $comboUp->setJsInstanceName('exposed_combo_uploader');
            $this->objTemplate->setVariable(array(
                'COMBO_UPLOADER_CODE'           => $comboUp->getXHtml(true),
                'DOWNLOADS_UPLOAD_REDIRECT_URL' => \Env::get('Resolver')->getURL()->toString(),
                'TXT_DOWNLOADS_BROWSE'          => $_ARRAYLANG['TXT_DOWNLOADS_BROWSE'],
                'TXT_DOWNLOADS_UPLOAD_FILE'     => $_ARRAYLANG['TXT_DOWNLOADS_UPLOAD_FILE'],
                'TXT_DOWNLOADS_MAX_FILE_SIZE'   => $_ARRAYLANG['TXT_DOWNLOADS_MAX_FILE_SIZE'],
                'TXT_DOWNLOADS_ADD_NEW_FILE'    => $_ARRAYLANG['TXT_DOWNLOADS_ADD_NEW_FILE'],
                'DOWNLOADS_MAX_FILE_SIZE'       => $this->getFormatedFileSize($objFWSystem->getMaxUploadFileSize())
            ));
            $this->objTemplate->parse('downloads_simple_file_upload');

            if ($this->objTemplate->blockExists('downloads_advanced_file_upload')) {
                $this->objTemplate->hideBlock('downloads_advanced_file_upload');
            }
        }
    }


    private function parseCreateCategoryForm($objCategory)
    {
        global $_ARRAYLANG;

        if (!$this->objTemplate->blockExists('downloads_create_category')) {
            return;
        }

        // check for sufficient permissiosn
        if ($objCategory->getAddSubcategoriesAccessId()
            && !Permission::checkAccess($objCategory->getAddSubcategoriesAccessId(), 'dynamic', true)
            && $objCategory->getOwnerId() != $this->userId
        ) {
            if ($this->objTemplate->blockExists('downloads_create_category')) {
                $this->objTemplate->hideBlock('downloads_create_category');
            }
            return;
        }

        $this->objTemplate->setVariable(array(
            'TXT_DOWNLOADS_CREATE_DIRECTORY'        => $_ARRAYLANG['TXT_DOWNLOADS_CREATE_DIRECTORY'],
            'TXT_DOWNLOADS_CREATE_NEW_DIRECTORY'    => $_ARRAYLANG['TXT_DOWNLOADS_CREATE_NEW_DIRECTORY'],
            'DOWNLOADS_CREATE_CATEGORY_URL'         => CONTREXX_SCRIPT_PATH.$this->moduleParamsHtml.'&amp;category='.$objCategory->getId()
        ));
        $this->objTemplate->parse('downloads_create_category');
    }


    private function parseCategory($objCategory)
    {
        global $_LANGID;

        if (!$this->objTemplate->blockExists('downloads_category')) {
            return;
        }

        $description = $objCategory->getDescription($_LANGID);
        if (strlen($description) > 100) {
            $shortDescription = substr($description, 0, 97).'...';
        } else {
            $shortDescription = $description;
        }

        $imageSrc = $objCategory->getImage();
        if (!empty($imageSrc) && file_exists(ASCMS_PATH.$imageSrc)) {
            $thumb_name = ImageManager::getThumbnailFilename($imageSrc);
            if (file_exists(ASCMS_PATH.$thumb_name)) {
                $thumbnailSrc = $thumb_name;
            } else {
                $thumbnailSrc = ImageManager::getThumbnailFilename(
                    $this->defaultCategoryImage['src']);
            }
        } else {
            $imageSrc = $this->defaultCategoryImage['src'];
            $thumbnailSrc = ImageManager::getThumbnailFilename(
                $this->defaultCategoryImage['src']);
        }

        $this->objTemplate->setVariable(array(
            'DOWNLOADS_CATEGORY_ID'                 =>  $objCategory->getId(),
            'DOWNLOADS_CATEGORY_NAME'               => htmlentities($objCategory->getName($_LANGID), ENT_QUOTES, CONTREXX_CHARSET),
            'DOWNLOADS_CATEGORY_DESCRIPTION'        => nl2br(htmlentities($description, ENT_QUOTES, CONTREXX_CHARSET)),
            'DOWNLOADS_CATEGORY_SHORT_DESCRIPTION'  => htmlentities($shortDescription, ENT_QUOTES, CONTREXX_CHARSET),
            'DOWNLOADS_CATEGORY_IMAGE'              => $this->getHtmlImageTag($imageSrc, htmlentities($objCategory->getName($_LANGID), ENT_QUOTES, CONTREXX_CHARSET)),
            'DOWNLOADS_CATEGORY_IMAGE_SRC'          => $imageSrc,
            'DOWNLOADS_CATEGORY_THUMBNAIL'          => $this->getHtmlImageTag($thumbnailSrc, htmlentities($objCategory->getName($_LANGID), ENT_QUOTES, CONTREXX_CHARSET)),
            'DOWNLOADS_CATEGORY_THUMBNAIL_SRC'      => $thumbnailSrc,
        ));

        $this->parseGroups($objCategory);

        $this->objTemplate->parse('downloads_category');
    }


    private function parseGroups($objCategory)
    {
        global $_LANGID;

        if (!$this->objTemplate->blockExists('downloads_category_group_list')) {
            return;
        }

        $objGroup = Group::getGroups(array('category_id' => $objCategory->getId(), 'is_active' => true));

        if (!$objGroup->EOF) {
            while (!$objGroup->EOF) {
                $this->objTemplate->setVariable(array(
                    'DOWNLOADS_GROUP_ID'        => $objGroup->getId(),
                    'DOWNLOADS_GROUP_NAME'      => htmlentities($objGroup->getName($_LANGID), ENT_QUOTES, CONTREXX_CHARSET),
                    'DOWNLOADS_GROUP_PAGE'      => $objGroup->getInfoPage()
                ));

                $this->objTemplate->parse('downloads_category_group');
                $objGroup->next();
            }

            $this->objTemplate->parse('downloads_category_group_list');
        } else {
            $this->objTemplate->hideBlock('downloads_category_group_list');
        }
    }


    private function parseCrumbtrail($objParentCategory)
    {
        global $_ARRAYLANG, $_LANGID;

        if (!$this->objTemplate->blockExists('downloads_crumbtrail')) {
            return;
        }

        $arrCategories = array();

        do {
            $arrCategories[] = array(
                'id'    => $objParentCategory->getId(),
                'name'  => htmlentities($objParentCategory->getName($_LANGID), ENT_QUOTES, CONTREXX_CHARSET)
            );
            $objParentCategory = Category::getCategory($objParentCategory->getParentId());
        } while ($objParentCategory->getId());

        krsort($arrCategories);

        foreach ($arrCategories as $arrCategory) {
            $this->objTemplate->setVariable(array(
                'DOWNLOADS_CRUMB_ID'    => $arrCategory['id'],
                'DOWNLOADS_CRUMB_NAME'  => $arrCategory['name']
            ));
            $this->objTemplate->parse('downloads_crumb');
        }

        $this->objTemplate->setVariable('TXT_DOWNLOADS_START', $_ARRAYLANG['TXT_DOWNLOADS_START']);

        $this->objTemplate->parse('downloads_crumbtrail');
    }


    private function parseGlobalStuff($objCategory)
    {
        $this->objTemplate->setVariable(array(
            'DOWNLOADS_JS'  => $this->getJavaScriptCode($objCategory)
        ));

        $this->parseSearchForm($objCategory);
    }


    private function getJavaScriptCode($objCategory)
    {
        global $_ARRAYLANG;

        $fileDeleteTxt = preg_replace('#\n#', '\\n', addslashes($_ARRAYLANG['TXT_DOWNLOADS_CONFIRM_DELETE_DOWNLOAD']));
        $fileDeleteLink = CSRF::enhanceURI(CONTREXX_SCRIPT_PATH.$this->moduleParamsJs)
            .'&category='.$objCategory->getId().'&delete_file=';
        $categoryDeleteTxt = preg_replace('#\n#', '\\n', addslashes($_ARRAYLANG['TXT_DOWNLOADS_CONFIRM_DELETE_CATEGORY']));
        $categoryDeleteLink = CSRF::enhanceURI(CONTREXX_SCRIPT_PATH.$this->moduleParamsJs)
            .'&category='.$objCategory->getId().'&delete_category=';

        $javascript = <<<JS_CODE
<script type="text/javascript">
// <![CDATA[
function downloadsDeleteFile(id,name)
{
    msg = '$fileDeleteTxt'
    if (confirm(msg.replace('%s',name))) {
        window.location.href='$fileDeleteLink'+id;
    }
}

function downloadsDeleteCategory(id,name)
{
    msg = '$categoryDeleteTxt'
    if (confirm(msg.replace('%s',name))) {
        window.location.href='$categoryDeleteLink'+id;
    }
}

// ]]>
</script>
JS_CODE;

        return $javascript;
    }


    public function getPageTitle()
    {
        return $this->pageTitle;
    }


    private function parseCategories($objCategory, $arrCategoryBlocks, $categoryLimit = null, $variablePrefix = '', $rowBlock = null, $arrSubCategoryBlocks = null, $subCategoryLimit = null)
    {
        global $_ARRAYLANG;

        if (!$this->objTemplate->blockExists($arrCategoryBlocks[0])) {
            return;
        }

        $allowDeleteCategories = !$objCategory->getManageSubcategoriesAccessId()
                            || Permission::checkAccess($objCategory->getManageSubcategoriesAccessId(), 'dynamic', true)
                            || $objCategory->getOwnerId() == $this->userId;
        $objSubcategory = Category::getCategories(array('parent_id' => $objCategory->getId(), 'is_active' => true), null, array('order' => 'asc', 'name' => 'asc'), null, $categoryLimit);

        if ($objSubcategory->EOF) {
            $this->objTemplate->hideBlock($arrCategoryBlocks[0]);
        } else {
            $row = 1;
            while (!$objSubcategory->EOF) {
                // set category attributes
                $this->parseCategoryAttributes($objSubcategory, $row++, $variablePrefix, $allowDeleteCategories);

                // parse subcategories
                if (isset($arrSubCategoryBlocks)) {
                    $this->parseCategories($objSubcategory, array('downloads_overview_subcategory_list', 'downloads_overview_subcategory'), $subCategoryLimit, 'SUB');
                }

                // parse category
                $this->objTemplate->parse($arrCategoryBlocks[1]);

                // parse row
                if (isset($rowBlock) && $this->objTemplate->blockExists($rowBlock) && $row % $this->arrConfig['overview_cols_count'] == 0) {
                    $this->objTemplate->parse($rowBlock);
                }

                $objSubcategory->next();
            }

            $this->objTemplate->setVariable(array(
                'TXT_DOWNLOADS_CATEGORIES'  => $_ARRAYLANG['TXT_DOWNLOADS_CATEGORIES'],
                'TXT_DOWNLOADS_DIRECTORIES' => $_ARRAYLANG['TXT_DOWNLOADS_DIRECTORIES']
            ));
            $this->objTemplate->parse($arrCategoryBlocks[0]);
        }
    }


    private function parseRelatedCategories($objDownload)
    {
        global $_ARRAYLANG;

        if (!$this->objTemplate->blockExists('downloads_file_category_list')) {
            return;
        }

        $arrCategoryIds = $objDownload->getAssociatedCategoryIds();
        if (count($arrCategoryIds)) {
            $row = 1;
            foreach ($arrCategoryIds as $categoryId) {
                $objCategory = Category::getCategory($categoryId);

                if (!$objCategory->EOF) {
                    // set category attributes
                    $this->parseCategoryAttributes($objCategory, $row++, 'FILE_');

                    // parse category
                    $this->objTemplate->parse('downloads_file_category');
                }
            }

            $this->objTemplate->setVariable('TXT_DOWNLOADS_RELATED_CATEGORIES', $_ARRAYLANG['TXT_DOWNLOADS_RELATED_CATEGORIES']);
            $this->objTemplate->parse('downloads_file_category_list');
        } else {
            $this->objTemplate->hideBlock('downloads_file_category_list');
        }
    }


    private function parseCategoryAttributes($objCategory, $row, $variablePrefix, $allowDeleteCategory = false)
    {
        global $_LANGID, $_ARRAYLANG;

        $description = $objCategory->getDescription($_LANGID);
        if (strlen($description) > 100) {
            $shortDescription = substr($description, 0, 97).'...';
        } else {
            $shortDescription = $description;
        }

        $imageSrc = $objCategory->getImage();
        if (!empty($imageSrc) && file_exists(ASCMS_PATH.$imageSrc)) {
            $thumb_name = ImageManager::getThumbnailFilename($imageSrc);
            if (file_exists(ASCMS_PATH.$thumb_name)) {
                $thumbnailSrc = $thumb_name;
            } else {
                $thumbnailSrc = ImageManager::getThumbnailFilename(
                    $this->defaultCategoryImage['src']);
            }
        } else {
            $imageSrc = $this->defaultCategoryImage['src'];
            $thumbnailSrc = ImageManager::getThumbnailFilename(
                $this->defaultCategoryImage['src']);
        }

        // parse delete icon link
        if ($allowDeleteCategory || $objCategory->getOwnerId() == $this->userId && $objCategory->getDeletableByOwner()) {
            $deleteIcon = $this->getHtmlDeleteLinkIcon(
                $objCategory->getId(),
                htmlspecialchars(str_replace("'", "\\'", $objCategory->getName($_LANGID)), ENT_QUOTES, CONTREXX_CHARSET),
                'downloadsDeleteCategory'
            );
        } else {
            $deleteIcon = '';
        }

        $this->objTemplate->setVariable(array(
            'DOWNLOADS_'.$variablePrefix.'CATEGORY_ID'                 => $objCategory->getId(),
            'DOWNLOADS_'.$variablePrefix.'CATEGORY_NAME'               => htmlentities($objCategory->getName($_LANGID), ENT_QUOTES, CONTREXX_CHARSET),
            'DOWNLOADS_'.$variablePrefix.'CATEGORY_NAME_LINK'          => $this->getHtmlLinkTag(CONTREXX_SCRIPT_PATH.$this->moduleParamsHtml.'&amp;category='.$objCategory->getId(), sprintf($_ARRAYLANG['TXT_DOWNLOADS_SHOW_CATEGORY_CONTENT'], htmlentities($objCategory->getName($_LANGID), ENT_QUOTES, CONTREXX_CHARSET)), htmlentities($objCategory->getName($_LANGID), ENT_QUOTES, CONTREXX_CHARSET)),
            'DOWNLOADS_'.$variablePrefix.'CATEGORY_FOLDER_LINK'        => $this->getHtmlFolderLinkTag(CONTREXX_SCRIPT_PATH.$this->moduleParamsHtml.'&amp;category='.$objCategory->getId(), sprintf($_ARRAYLANG['TXT_DOWNLOADS_SHOW_CATEGORY_CONTENT'], htmlentities($objCategory->getName($_LANGID), ENT_QUOTES, CONTREXX_CHARSET)), htmlentities($objCategory->getName($_LANGID), ENT_QUOTES, CONTREXX_CHARSET)),
            'DOWNLOADS_'.$variablePrefix.'CATEGORY_DESCRIPTION'        => nl2br(htmlentities($description, ENT_QUOTES, CONTREXX_CHARSET)),
            'DOWNLOADS_'.$variablePrefix.'CATEGORY_SHORT_DESCRIPTION'  => htmlentities($shortDescription, ENT_QUOTES, CONTREXX_CHARSET),
            'DOWNLOADS_'.$variablePrefix.'CATEGORY_IMAGE'              => $this->getHtmlImageTag($imageSrc, htmlentities($objCategory->getName($_LANGID), ENT_QUOTES, CONTREXX_CHARSET)),
            'DOWNLOADS_'.$variablePrefix.'CATEGORY_IMAGE_SRC'          => $imageSrc,
            'DOWNLOADS_'.$variablePrefix.'CATEGORY_THUMBNAIL'          => $this->getHtmlImageTag($thumbnailSrc, htmlentities($objCategory->getName($_LANGID), ENT_QUOTES, CONTREXX_CHARSET)),
            'DOWNLOADS_'.$variablePrefix.'CATEGORY_THUMBNAIL_SRC'      => $thumbnailSrc,
            'DOWNLOADS_'.$variablePrefix.'CATEGORY_DOWNLOADS_COUNT'    => intval($objCategory->getAssociatedDownloadsCount()),
            'DOWNLOADS_'.$variablePrefix.'CATEGORY_DELETE_ICON'        => $deleteIcon,
            'DOWNLOADS_'.$variablePrefix.'CATEGORY_ROW_CLASS'          => 'row'.($row % 2 + 1),
            'TXT_DOWNLOADS_MORE'                                       => $_ARRAYLANG['TXT_DOWNLOADS_MORE']
        ));
    }


    private function getHtmlDeleteLinkIcon($id, $name, $method)
    {
        global $_ARRAYLANG;

        return sprintf($this->htmlLinkTemplate, "javascript:void(0)\" onclick=\"$method($id,'$name')", $_ARRAYLANG['TXT_DOWNLOADS_DELETE'], sprintf($this->htmlImgTemplate, 'cadmin/images/icons/delete.gif', $_ARRAYLANG['TXT_DOWNLOADS_DELETE']));
    }


    private function getHtmlLinkTag($href, $title, $value)
    {
        return sprintf($this->htmlLinkTemplate, $href, $title, $value);
    }


    private function getHtmlImageTag($src, $alt)
    {
        return sprintf($this->htmlImgTemplate, $src, $alt);
    }


    private function getHtmlFolderLinkTag($href, $title, $value)
    {
        return sprintf($this->htmlLinkTemplate, $href, $title, sprintf($this->htmlImgTemplate, 'images/modules/downloads/folder_front.gif', $title).' '.$value);
    }


    private function parseDownloads($objCategory)
    {
        global $_CONFIG, $_ARRAYLANG;

        if (!$this->objTemplate->blockExists('downloads_file_list')) {
            return;
        }

        $limitOffset = isset($_GET['pos']) ? intval($_GET['pos']) : 0;
        $includeDownloadsOfSubcategories = false;

        // set downloads filter
        $filter = array(
            'expiration'    => array('=' => 0, '>' => time())
        );
        if ($objCategory->getId()) {
            $filter['category_id'] = $objCategory->getId();

            if (!empty($this->searchKeyword)) {
                $includeDownloadsOfSubcategories = true;
            }
        }

        $objDownload = new Download();
        $objDownload->loadDownloads($filter, $this->searchKeyword, null, null, $_CONFIG['corePagingLimit'], $limitOffset, $includeDownloadsOfSubcategories);
        $categoryId = $objCategory->getId();
        $allowdDeleteFiles = false;
        if (!$objCategory->EOF) {
            $allowdDeleteFiles =    !$objCategory->getManageFilesAccessId()
                                 || Permission::checkAccess($objCategory->getManageFilesAccessId(), 'dynamic', true)
                                 || (   $this->userId
                                     && $objCategory->getOwnerId() == $this->userId);
        } elseif (Permission::hasAllAccess()) {
            $allowdDeleteFiles = true;
        }

        if ($objDownload->EOF) {
            $this->objTemplate->hideBlock('downloads_file_list');
        } else {
            $row = 1;
            while (!$objDownload->EOF) {
                // select category
                if ($objCategory->EOF) {
                    $arrAssociatedCategories = $objDownload->getAssociatedCategoryIds();
                    $categoryId = $arrAssociatedCategories[0];
                }


                // parse download info
                $this->parseDownloadAttributes($objDownload, $categoryId, $allowdDeleteFiles);
                $this->objTemplate->setVariable('DOWNLOADS_FILE_ROW_CLASS', 'row'.($row++ % 2 + 1));
                $this->objTemplate->parse('downloads_file');


                $objDownload->next();
            }

            $downloadCount = $objDownload->getFilteredSearchDownloadCount();
            if ($downloadCount > $_CONFIG['corePagingLimit']) {
                if(\Env::get('cx')->getPage()->getModule() != 'downloads'){
                    $this->objTemplate->setVariable('DOWNLOADS_FILE_PAGING', getPaging($downloadCount, $limitOffset, '', "<b>".$_ARRAYLANG['TXT_DOWNLOADS_DOWNLOADS']."</b>"));
                }else{
                    $this->objTemplate->setVariable('DOWNLOADS_FILE_PAGING', getPaging($downloadCount, $limitOffset, '&'.substr($this->moduleParamsHtml, 1).'&category='.$objCategory->getId().'&downloads_search_keyword='.htmlspecialchars($this->searchKeyword), "<b>".$_ARRAYLANG['TXT_DOWNLOADS_DOWNLOADS']."</b>"));
                }
            }

            $this->objTemplate->setVariable(array(
                'TXT_DOWNLOADS_FILES'       => $_ARRAYLANG['TXT_DOWNLOADS_FILES'],
                'TXT_DOWNLOADS_DOWNLOAD'    => $_ARRAYLANG['TXT_DOWNLOADS_DOWNLOAD'],
                'TXT_DOWNLOADS_DOWNLOADS'   => $_ARRAYLANG['TXT_DOWNLOADS_DOWNLOADS']
            ));

            $this->objTemplate->parse('downloads_file_list');
        }
    }


    private function parseSpecialDownloads($arrBlocks, $arrFilter, $arrSort, $limit)
    {
        global $_ARRAYLANG;

        if (!$this->objTemplate->blockExists($arrBlocks[0])) {
            return;
        }

        $objDownload = new Download();
        $objDownload->loadDownloads($arrFilter, null, $arrSort, null, $limit);

        if ($objDownload->EOF) {
            $this->objTemplate->hideBlock($arrBlocks[0]);
        } else {
            $row = 1;
            while (!$objDownload->EOF) {
                // select category
                $arrAssociatedCategories = $objDownload->getAssociatedCategoryIds();
                $categoryId = $arrAssociatedCategories[0];

                // parse download info
                $this->parseDownloadAttributes($objDownload, $categoryId);
                $this->objTemplate->setVariable('DOWNLOADS_FILE_ROW_CLASS', 'row'.($row++ % 2 + 1));
                $this->objTemplate->parse($arrBlocks[1]);

                $objDownload->next();
            }

            $this->objTemplate->setVariable(array(
                'TXT_DOWNLOADS_MOST_VIEWED'         => $_ARRAYLANG['TXT_DOWNLOADS_MOST_VIEWED'],
                'TXT_DOWNLOADS_MOST_DOWNLOADED'     => $_ARRAYLANG['TXT_DOWNLOADS_MOST_DOWNLOADED'],
                'TXT_DOWNLOADS_NEW_DOWNLOADS'       => $_ARRAYLANG['TXT_DOWNLOADS_NEW_DOWNLOADS'],
                'TXT_DOWNLOADS_RECENTLY_UPDATED'    => $_ARRAYLANG['TXT_DOWNLOADS_RECENTLY_UPDATED']
            ));

            $this->objTemplate->touchBlock($arrBlocks[0]);
        }
    }


    private function parseDownloadAttributes($objDownload, $categoryId, $allowDeleteFilesFromCategory = false)
    {
        global $_ARRAYLANG, $_LANGID;

        $description = $objDownload->getDescription($_LANGID);
        if (strlen($description) > 100) {
            $shortDescription = substr($description, 0, 97).'...';
        } else {
            $shortDescription = $description;
        }

        $imageSrc = $objDownload->getImage();
        if (!empty($imageSrc) && file_exists(ASCMS_PATH.$imageSrc)) {
            $thumb_name = ImageManager::getThumbnailFilename($imageSrc);
            if (file_exists(ASCMS_PATH.$thumb_name)) {
                $thumbnailSrc = $thumb_name;
            } else {
                $thumbnailSrc = ImageManager::getThumbnailFilename(
                    $this->defaultCategoryImage['src']);
            }

            $imageSrc = contrexx_raw2encodedUrl($imageSrc);
            $thumbnailSrc = contrexx_raw2encodedUrl($thumbnailSrc);
            $image = $this->getHtmlImageTag($imageSrc, htmlentities($objDownload->getName($_LANGID), ENT_QUOTES, CONTREXX_CHARSET));
            $thumbnail = $this->getHtmlImageTag($thumbnailSrc, htmlentities($objDownload->getName($_LANGID), ENT_QUOTES, CONTREXX_CHARSET));
        } else {
            $imageSrc = contrexx_raw2encodedUrl($this->defaultCategoryImage['src']);
            $thumbnailSrc = contrexx_raw2encodedUrl(
                ImageManager::getThumbnailFilename(
                    $this->defaultCategoryImage['src']));
            $image = $this->getHtmlImageTag($this->defaultCategoryImage['src'], htmlentities($objDownload->getName($_LANGID), ENT_QUOTES, CONTREXX_CHARSET));;
            $thumbnail = $this->getHtmlImageTag(
                ImageManager::getThumbnailFilename(
                    $this->defaultCategoryImage['src']),
                htmlentities($objDownload->getName($_LANGID), ENT_QUOTES, CONTREXX_CHARSET));
        }

        // parse delete icon link
        if ($allowDeleteFilesFromCategory || ($this->userId && $objDownload->getOwnerId() == $this->userId)) {
            $deleteIcon = $this->getHtmlDeleteLinkIcon(
                $objDownload->getId(),
                htmlspecialchars(str_replace("'", "\\'", $objDownload->getName($_LANGID)), ENT_QUOTES, CONTREXX_CHARSET),
                'downloadsDeleteFile'
            );
        } else {
            $deleteIcon = '';
        }

        $this->objTemplate->setVariable(array(
            'TXT_DOWNLOADS_DOWNLOAD'            => $_ARRAYLANG['TXT_DOWNLOADS_DOWNLOAD'],
            'TXT_DOWNLOADS_ADDED_BY'            => $_ARRAYLANG['TXT_DOWNLOADS_ADDED_BY'],
            'TXT_DOWNLOADS_LAST_UPDATED'        => $_ARRAYLANG['TXT_DOWNLOADS_LAST_UPDATED'],
            'TXT_DOWNLOADS_DOWNLOADED'          => $_ARRAYLANG['TXT_DOWNLOADS_DOWNLOADED'],
            'TXT_DOWNLOADS_VIEWED'              => $_ARRAYLANG['TXT_DOWNLOADS_VIEWED'],
            'DOWNLOADS_FILE_ID'                 => $objDownload->getId(),
            'DOWNLOADS_FILE_DETAIL_SRC'         => CONTREXX_SCRIPT_PATH.$this->moduleParamsHtml.'&amp;category='.$categoryId.'&amp;id='.$objDownload->getId(),
            'DOWNLOADS_FILE_NAME'               => htmlentities($objDownload->getName($_LANGID), ENT_QUOTES, CONTREXX_CHARSET),
            'DOWNLOADS_FILE_DESCRIPTION'        => nl2br(htmlentities($description, ENT_QUOTES, CONTREXX_CHARSET)),
            'DOWNLOADS_FILE_SHORT_DESCRIPTION'  => htmlentities($shortDescription, ENT_QUOTES, CONTREXX_CHARSET),
            'DOWNLOADS_FILE_IMAGE'              => $image,
            'DOWNLOADS_FILE_IMAGE_SRC'          => $imageSrc,
            'DOWNLOADS_FILE_THUMBNAIL'          => $thumbnail,
            'DOWNLOADS_FILE_THUMBNAIL_SRC'      => $thumbnailSrc,
            'DOWNLOADS_FILE_ICON'               => $this->getHtmlImageTag($objDownload->getIcon(), htmlentities($objDownload->getName($_LANGID), ENT_QUOTES, CONTREXX_CHARSET)),
            'DOWNLOADS_FILE_FILE_TYPE_ICON'     => $this->getHtmlImageTag($objDownload->getFileIcon(), htmlentities($objDownload->getName($_LANGID), ENT_QUOTES, CONTREXX_CHARSET)),
            'DOWNLOADS_FILE_DELETE_ICON'        => $deleteIcon,
            'DOWNLOADS_FILE_DOWNLOAD_LINK_SRC'  => CONTREXX_SCRIPT_PATH.$this->moduleParamsHtml.'&amp;download='.$objDownload->getId(),
            'DOWNLOADS_FILE_OWNER'              => $this->getParsedUsername($objDownload->getOwnerId()),
            'DOWNLOADS_FILE_OWNER_ID'           => $objDownload->getOwnerId(),
            'DOWNLOADS_FILE_SRC'                => htmlentities($objDownload->getSourceName(), ENT_QUOTES, CONTREXX_CHARSET),
            'DOWNLOADS_FILE_LAST_UPDATED'       => date(ASCMS_DATE_FORMAT, $objDownload->getMTime()),
            'DOWNLOADS_FILE_VIEWS'              => $objDownload->getViewCount(),
            'DOWNLOADS_FILE_DOWNLOAD_COUNT'     => $objDownload->getDownloadCount()
        ));

        // parse size
        if ($this->arrConfig['use_attr_size']) {
            $this->objTemplate->setVariable(array(
                'TXT_DOWNLOADS_SIZE'                => $_ARRAYLANG['TXT_DOWNLOADS_SIZE'],
                'DOWNLOADS_FILE_SIZE'               => $this->getFormatedFileSize($objDownload->getSize())
            ));
        }

        // parse license
        if ($this->arrConfig['use_attr_license']) {
            $this->objTemplate->setVariable(array(
                'TXT_DOWNLOADS_LICENSE'             => $_ARRAYLANG['TXT_DOWNLOADS_LICENSE'],
                'DOWNLOADS_FILE_LICENSE'            => htmlentities($objDownload->getLicense(), ENT_QUOTES, CONTREXX_CHARSET),
            ));
        }

        // parse version
        if ($this->arrConfig['use_attr_version']) {
            $this->objTemplate->setVariable(array(
                'TXT_DOWNLOADS_VERSION'             => $_ARRAYLANG['TXT_DOWNLOADS_VERSION'],
                'DOWNLOADS_FILE_VERSION'            => htmlentities($objDownload->getVersion(), ENT_QUOTES, CONTREXX_CHARSET),
            ));
        }

        // parse author
        if ($this->arrConfig['use_attr_author']) {
            $this->objTemplate->setVariable(array(
                'TXT_DOWNLOADS_AUTHOR'              => $_ARRAYLANG['TXT_DOWNLOADS_AUTHOR'],
                'DOWNLOADS_FILE_AUTHOR'             => htmlentities($objDownload->getAuthor(), ENT_QUOTES, CONTREXX_CHARSET),
            ));
        }

        // parse website
        if ($this->arrConfig['use_attr_website']) {
            $this->objTemplate->setVariable(array(
                'TXT_DOWNLOADS_WEBSITE'             => $_ARRAYLANG['TXT_DOWNLOADS_WEBSITE'],
                'DOWNLOADS_FILE_WEBSITE'            => $this->getHtmlLinkTag(htmlentities($objDownload->getWebsite(), ENT_QUOTES, CONTREXX_CHARSET), htmlentities($objDownload->getWebsite(), ENT_QUOTES, CONTREXX_CHARSET), htmlentities($objDownload->getWebsite(), ENT_QUOTES, CONTREXX_CHARSET)),
                'DOWNLOADS_FILE_WEBSITE_SRC'        => htmlentities($objDownload->getWebsite(), ENT_QUOTES, CONTREXX_CHARSET),
            ));
        }
    }


    private function parseRelatedDownloads($objDownload, $currentCategoryId)
    {
        global $_LANGID, $_ARRAYLANG;

        if (!$this->objTemplate->blockExists('downloads_related_file_list')) {
            return;
        }

        $objRelatedDownload = $objDownload->getDownloads(array('download_id' => $objDownload->getId()), null, array('order' => 'ASC', 'name' => 'ASC', 'id' => 'ASC'));

        if ($objRelatedDownload) {
            $row = 1;
            while (!$objRelatedDownload->EOF) {
                $description = $objRelatedDownload->getDescription($_LANGID);
                if (strlen($description) > 100) {
                    $shortDescription = substr($description, 0, 97).'...';
                } else {
                    $shortDescription = $description;
                }

                $imageSrc = $objRelatedDownload->getImage();
                if (!empty($imageSrc) && file_exists(ASCMS_PATH.$imageSrc)) {
                    $thumb_name = ImageManager::getThumbnailFilename($imageSrc);
                    if (file_exists(ASCMS_PATH.$thumb_name)) {
                        $thumbnailSrc = $thumb_name;
                    } else {
                        $thumbnailSrc = ImageManager::getThumbnailFilename(
                            $this->defaultCategoryImage['src']);
                    }

                    $image = $this->getHtmlImageTag($imageSrc, htmlentities($objRelatedDownload->getName($_LANGID), ENT_QUOTES, CONTREXX_CHARSET));
                    $thumbnail = $this->getHtmlImageTag($thumbnailSrc, htmlentities($objRelatedDownload->getName($_LANGID), ENT_QUOTES, CONTREXX_CHARSET));
                } else {
                    $imageSrc = $this->defaultCategoryImage['src'];
                    $thumbnailSrc = ImageManager::getThumbnailFilename(
                        $this->defaultCategoryImage['src']);
                    $image = '';
                    $thumbnail = '';
                }

                $arrAssociatedCategories = $objRelatedDownload->getAssociatedCategoryIds();
                if (in_array($currentCategoryId, $arrAssociatedCategories)) {
                    $categoryId = $currentCategoryId;
                } else {
                    $arrPublicCategories = array();
                    $arrProtectedCategories = array();

                    foreach ($arrAssociatedCategories as $categoryId) {
                        $objCategory = Category::getCategory($categoryId);
                        if (!$objCategory->EOF) {
                            if ($objCategory->getVisibility()
                                || Permission::checkAccess($objCategory->getReadAccessId(), 'dynamic', true)
                                || $objCategory->getOwnerId() == $this->userId
                               ) {
                                $arrPublicCategories[] = $categoryId;
                                break;
                            } else {
                                $arrProtectedCategories[] = $categoryId;
                            }
                        }
                    }

                    if (count($arrPublicCategories)) {
                        $categoryId = $arrPublicCategories[0];
                    } elseif (count($arrProtectedCategories)) {
                        $categoryId = $arrProtectedCategories[0];
                    } else {
                        $objRelatedDownload->next();
                        continue;
                    }
                }

                $this->objTemplate->setVariable(array(
                    'DOWNLOADS_RELATED_FILE_ID'                 => $objRelatedDownload->getId(),
                    'DOWNLOADS_RELATED_FILE_DETAIL_SRC'         => CONTREXX_SCRIPT_PATH.$this->moduleParamsHtml.'&amp;category='.$categoryId.'&amp;id='.$objRelatedDownload->getId(),
                    'DOWNLOADS_RELATED_FILE_NAME'               => htmlentities($objRelatedDownload->getName($_LANGID), ENT_QUOTES, CONTREXX_CHARSET),
                    'DOWNLOADS_RELATED_FILE_DESCRIPTION'        => nl2br(htmlentities($description, ENT_QUOTES, CONTREXX_CHARSET)),
                    'DOWNLOADS_RELATED_FILE_SHORT_DESCRIPTION'  => htmlentities($shortDescription, ENT_QUOTES, CONTREXX_CHARSET),
                    'DOWNLOADS_RELATED_FILE_IMAGE'              => $image,
                    'DOWNLOADS_RELATED_FILE_IMAGE_SRC'          => $imageSrc,
                    'DOWNLOADS_RELATED_FILE_THUMBNAIL'          => $thumbnail,
                    'DOWNLOADS_RELATED_FILE_THUMBNAIL_SRC'      => $thumbnailSrc,
                    'DOWNLOADS_RELATED_FILE_ICON'               => $this->getHtmlImageTag($objRelatedDownload->getIcon(), htmlentities($objRelatedDownload->getName($_LANGID), ENT_QUOTES, CONTREXX_CHARSET)),
                    'DOWNLOADS_RELATED_FILE_ROW_CLASS'          => 'row'.($row++ % 2 + 1)
                ));
                $this->objTemplate->parse('downloads_related_file');


                $objRelatedDownload->next();
            }

            $this->objTemplate->setVariable('TXT_DOWNLOADS_RELATED_DOWNLOADS', $_ARRAYLANG['TXT_DOWNLOADS_RELATED_DOWNLOADS']);
            $this->objTemplate->parse('downloads_related_file_list');
        } else {
            $this->objTemplate->hideBlock('downloads_related_file_list');
        }
    }


    private function parseDownload($objDownload, $categoryId)
    {
        global $_LANGID, $_ARRAYLANG;

        if (!$this->objTemplate->blockExists('downloads_file_detail')) {
            return;
        }


        $this->parseDownloadAttributes($objDownload, $categoryId);
        $this->objTemplate->parse('downloads_file_detail');

        $objDownload->incrementViewCount();
    }


    private function parseSearchForm($objCategory)
    {
        global $_ARRAYLANG;

        $this->objTemplate->setVariable(array(
            'DOWNLOADS_SEARCH_KEYWORD'  => htmlentities($this->searchKeyword, ENT_QUOTES, CONTREXX_CHARSET),
            'DOWNLOADS_SEARCH_URL'      => CONTREXX_SCRIPT_PATH,
            'DOWNLOADS_SEARCH_CATEGORY' => $objCategory->getId(),
            'TXT_DOWNLOADS_SEARCH'      => $_ARRAYLANG['TXT_DOWNLOADS_SEARCH'],
        ));
    }


    private function download()
    {
        global $objInit;

        $objDownload = new Download();
        $objDownload->load(!empty($_GET['download']) ? intval($_GET['download']) : 0);
        if (!$objDownload->EOF) {
            // check if the download is expired
            if ($objDownload->getExpirationDate() && $objDownload->getExpirationDate() < time()) {
                CSRF::header("Location: ".CONTREXX_DIRECTORY_INDEX."?section=error&id=404");
                exit;
            }

            // check access to download-file
            if (!$this->hasUserAccessToCategoriesOfDownload($objDownload)) {
                Permission::noAccess(base64_encode($objInit->getPageUri()));
            }

            // check access to download-file
            if (// download is protected
                $objDownload->getAccessId()
                // the user isn't a admin
                && !Permission::checkAccess(143, 'static', true)
                // the user doesn't has access to this download
                && !Permission::checkAccess($objDownload->getAccessId(), 'dynamic', true)
                // the user isn't the owner of the download
                && $objDownload->getOwnerId() != $this->userId
            ) {
                Permission::noAccess(base64_encode($objInit->getPageUri()));
            }

            $objDownload->incrementDownloadCount();

            if ($objDownload->getType() == 'file') {
                $objDownload->send();
            } else {
                // add socket -> prevent to hide the source from the customer
                CSRF::header('Location: '.$objDownload->getSource());
            }
        }
    }

    /**
     * Check if currently authenticated user has read access to any
     * of a perticular download's associated categories.
     *
     * @param   Download The download-object of which the access to its
     *                   associated categories shall be checked.
     * @return  boolean  Returns TRUE, if the currently authenticated user
     *                   has read access to at least one of the download's
     *                   associated categories.
     */
    public function hasUserAccessToCategoriesOfDownload($objDownload)
    {
        // user is DAM admin (or superuser)
        if (Permission::checkAccess(143, 'static', true)) {
            return true;
        }

        $arrCategoryIds = $objDownload->getAssociatedCategoryIds();
        $filter = array(
            'is_active'     => true,
            'id'            => $arrCategoryIds,
            // read_access_id = 0 refers to unprotected categories
            'read_access_id'=> array(0), 
        );
        $objUser = FWUser::getFWUserObject()->objUser;
        if ($objUser->login()) {
            $filter['read_access_id'] = array_merge($filter['read_access_id'], $objUser->getDynamicPermissionIds());
        }
        $objCategory = Category::getCategories($filter, null, null, null, $limit = 1);

        if (!$objCategory->EOF) {
            return true;
        }

        if ($objUser->login()) {
            // In case the user is logged in, but has no access to any of the
            // download's associated categories, check if any of those categories
            // are owned by the user. If so, we will grant the access to the download anyway.
            unset($filter['read_access_id']);
            $filter['owner_id'] = $objUser->getId();
            $objCategory = Category::getCategories($filter, null, null, null, $limit = 1);
            if (!$objCategory->EOF) {
                return true;
            }
        }

        return false;
    }


    private function getFormatedFileSize($bytes)
    {
        global $_ARRAYLANG;

        if (!$bytes) {
            return $_ARRAYLANG['TXT_DOWNLOADS_UNKNOWN'];
        }

        $exp = log($bytes, 1024);

        if ($exp < 1) {
            return $bytes.' '.$_ARRAYLANG['TXT_DOWNLOADS_BYTES'];
        } elseif ($exp < 2) {
            return round($bytes/1024, 2).' '.$_ARRAYLANG['TXT_DOWNLOADS_KBYTE'];
        } elseif ($exp < 3) {
            return round($bytes/pow(1024, 2), 2).' '.$_ARRAYLANG['TXT_DOWNLOADS_MBYTE'];
        } else {
            return round($bytes/pow(1024, 3), 2).' '.$_ARRAYLANG['TXT_DOWNLOADS_GBYTE'];
        }
    }

}

?>
