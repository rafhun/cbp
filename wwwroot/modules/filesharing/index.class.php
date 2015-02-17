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
 * Filesharing
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_filesharing
 */

/**
 * FilesharingException
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_filesharing
 */
class FilesharingException extends Exception
{
}

/**
 * @ignore
 */
include_once ASCMS_MODULE_PATH . "/filesharing/lib/FilesharingLib.class.php";

/**
 * Filesharing
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_filesharing
 */
class Filesharing extends FilesharingLib
{
    /**
     * Template object
     *
     * @access private
     * @var object
     */
    protected $objTemplate;

    /**
     * @var object $objUrl the url object
     */
    private $objUrl;

    /**
     * @var array $uriParams the parameters of the uri
     */
    private $uriParams;

    /**
     * @var array $files uploaded files
     */
    private $files;

    /**
     * Constructor
     *
     * @param string $pageContent page content from content manager
     */
    public function Filesharing($pageContent)
    {
        $this->__construct($pageContent);
    }

    /**
     * PHP5 Constructor
     *
     * @param string $pageContent page content from content manager
     */
    public function __construct($pageContent)
    {
        $this->objTemplate = new \Cx\Core\Html\Sigma(".");
        CSRF::add_placeholder($this->objTemplate);
        $this->objTemplate->setErrorHandling(PEAR_ERROR_DIE);
        $this->objTemplate->setTemplate($pageContent);
        $this->objUrl = \Env::get("Resolver")->getUrl();
        $this->uriParams = $this->objUrl->getParamArray();
    }

    /**
     * get the page
     *
     * @return string html code of the page
     * @throws FilesharingException
     */
    public function getPage()
    {
        $hash = contrexx_input2raw($this->uriParams["hash"]);
        $check = contrexx_input2raw($this->uriParams["check"]);

        if ($this->uriParams["uploadId"])
            $this->files = $this->getSharedFiles($this->uriParams["uploadId"]);

        switch ($this->uriParams["act"]) {
            case "image":
                $this->loadImage($hash);
                break;

            default:
                try {
                    if (!empty($hash) && !empty($check)) {
                        $fileDeleted = $this->deleteFile($hash, $check);
                    } elseif (!empty($hash)) {
                        $this->downloadFile($hash);
                    } else {
                        if (empty($this->files) && is_array($this->files))
                            throw new FilesharingException('no_files_uploaded');
                    }

                    $this->objTemplate->hideBlock('error_file_not_found');
                    $this->objTemplate->hideBlock('error_no_files_uploaded');
                } catch (FilesharingException $e) {
                    switch ($e->getMessage()) {
                        case 'file_not_found':
                            $this->objTemplate->touchBlock('error_file_not_found');
                            $this->objTemplate->hideBlock('error_no_files_uploaded');
                            break;
                        case 'no_files_uploaded':
                            $this->objTemplate->touchBlock('error_no_files_uploaded');
                            $this->objTemplate->hideBlock('error_file_not_found');
                            break;
                    }
                }

                // don't show for delete page
                if (empty($hash) || (isset($fileDeleted) && $fileDeleted)) {
                    $this->uploadPage();
                }
                break;
        }
        
        FilesharingLib::cleanUp();

        return $this->objTemplate->get();
    }

    /**
     * download a file by hash
     *
     * @param string $hash the hash code of the file which should be downloaded
     * @throws FilesharingException
     */
    private function downloadFile($hash)
    {
        global $objDatabase;
        $objResult = $objDatabase->SelectLimit("SELECT `file`, `source` FROM " . DBPREFIX . "module_filesharing WHERE `hash` = '" . contrexx_raw2db($hash) . "'", 1, 0);
        if ($objResult !== false && $objResult->RecordCount() > 0) {
            $fileName = $objResult->fields["file"];
            $filePath = ASCMS_PATH . ASCMS_PATH_OFFSET . $objResult->fields["source"];
            if (!file_exists($filePath))
                throw new FilesharingException('file_not_found');

            ob_end_clean();
            header("Pragma: public");
            header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"" . $fileName . "\"");
            readfile($filePath);
            die();
        } else {
            throw new FilesharingException('file_not_found');
        }
    }

    /**
     * delete a file with hash and check code
     *
     * @param string $hash the hash code of the file which should be deleted
     * @param string $check the check code of the file which should be deleted
     * @return bool delete already successful (true), confirmation form is shown (false)
     */
    private function deleteFile($hash, $check)
    {
        global $objDatabase;
        $objResult = $objDatabase->SelectLimit("SELECT `id`, `file`, `source`, `check` FROM " . DBPREFIX . "module_filesharing WHERE `hash` = '" . contrexx_raw2db($hash) . "'", 1, 0);
        if ($objResult === false || $objResult->RecordCount() == 0) {
            // no file exists with this hash
            return true;
        }
        if (!isset($_POST['delete']) && $_POST['delete'] == false) {
            // user didn't yet confirm delete action
            $this->showDeleteConfirmation($objResult->fields);
            return false;
        }
        if ($objResult->fields["check"] == $check) {
            // check whether the check code is the same as in the database
            \Cx\Lib\FileSystem\FileSystem::delete_file(ASCMS_PATH . ASCMS_PATH_OFFSET . $objResult->fields["source"]);
            $objDatabase->Execute("DELETE FROM " . DBPREFIX . "module_filesharing WHERE `id` = " . intval($objResult->fields["id"]));
        }
        return true;
    }

    /**
     * Show the delete confirmation form view
     *
     * @param array $file file data (source, filename, id, check)
     */
    protected function showDeleteConfirmation($file) {
        global $_ARRAYLANG;
        $this->objTemplate->setVariable(
            array(
                "FORM_ACTION" => (string) clone \Env::get("Resolver")->getUrl(),
                "FORM_METHOD" => "POST",

                'FILESHARING_FILE_NAME' => contrexx_raw2xhtml($file['file']),

                'TXT_FILESHARING_FILE_NAME' => $_ARRAYLANG['TXT_FILESHARING_FILE_NAME'],
                'TXT_FILESHARING_CONFIRM_DELETE' => $_ARRAYLANG['TXT_FILESHARING_CONFIRM_DELETE'],
            )
        );

        if($this->objTemplate->blockExists('confirm_delete')) {
            $this->objTemplate->parse("confirm_delete");
        }
        if($this->objTemplate->blockExists('upload_form')) {
            $this->objTemplate->hideBlock("upload_form");
        }
        if($this->objTemplate->blockExists('uploaded')) {
            $this->objTemplate->hideBlock("uploaded");
        }
    }

    /**
     * displays the image by hash
     *
     * @param string $hash the hash of the file whose image should be displayed
     *
     * @access private
     */
    private function loadImage($hash)
    {
        global $objDatabase;
        $objResult = $objDatabase->SelectLimit("SELECT `source` FROM " . DBPREFIX . "module_filesharing WHERE `hash` = '" . contrexx_raw2db($hash) . "'", 1, 0);
        if ($objResult !== false && $objResult->RecordCount() > 0) {
            $path = ASCMS_PATH_OFFSET . $objResult->fields["source"];
            $info = pathinfo($path);
            $extension = strtolower($info["extension"]);

            // check which extension it is and show the image
            if ($extension == "jpeg" || $extension == "jpg") {
                header("Content-Type: image/jpeg");
                readfile(ASCMS_PATH . $path);
            } elseif ($extension == "png") {
                header("Content-Type: image/png");
                readfile(ASCMS_PATH . $path);
            } elseif ($extension == "gif") {
                header("Content-Type: image/gif");
                readfile(ASCMS_PATH . $path);
            }
            die();
        }
    }

    /**
     * creates the upload page for the frontend
     */
    private function uploadPage()
    {
        global $_ARRAYLANG, $objDatabase, $_CONFIG;

        $params = $this->objUrl->getParamArray();

        // the upload is finished and the script has to send a mail and assign the expiration dates
        if (!empty($this->files) && $_POST["accept_terms"]) {
            // set expiration time
            $cmd = \Env::get("Resolver")->getCmd();
            if ($cmd != "downloads") {
                $expiration_date = date("Y-m-d H:i:s", time() + $_POST["expiration"]);
                $objDatabase->Execute("UPDATE " . DBPREFIX . "module_filesharing SET `expiration_date` = '" . contrexx_raw2db($expiration_date) . "' WHERE `upload_id` = '" . intval($params["uploadId"]) . "'");
            }

            // send the mail to the reciever
            if (FWValidator::isEmail($_POST["email"])) {
                parent::sendMail($params["uploadId"], $_POST["subject"], $_POST["email"], $_POST["message"]);
            }

            // send the mail to the administrator
            parent::sendMail($params["uploadId"], null, $_CONFIG['coreAdminEmail'], $_POST["message"]);

            // reset the upload id so the uploads are invisible now
            $objDatabase->Execute("UPDATE " . DBPREFIX . "module_filesharing SET `upload_id` = NULL WHERE `upload_id` = " . intval($params["uploadId"]));
            $this->getFileList();
        } else {
            $this->getForm();
        }

        // set the template-variables for the expiration dates
        foreach ($_ARRAYLANG["TXT_FILESHARING_EXPIRATION_DATES"] as $placeholder => $value) {
            $this->objTemplate->setVariable(strtoupper($placeholder), $value);
        }
    }

    /**
     * parse the upload form
     *
     * @access private
     */
    private function getForm()
    {
        global $_ARRAYLANG;

        SettingDb::init('filesharing', 'config');
        $permissionNeeded = SettingDb::getValue('permission');
        if (!$permissionNeeded) {
            SettingDb::add('permission', 'off');
            $permissionNeeded = SettingDb::getValue('permission');
        }

        if ($permissionNeeded == 'off' || (is_numeric($permissionNeeded) && !Permission::checkAccess($permissionNeeded, 'dynamic'))) {
            $this->objTemplate->setVariable('FILESHARING_NO_ACCESS', $_ARRAYLANG['TXT_FILESHARING_NO_ACCESS']);

            if($this->objTemplate->parse('no_access')) {
                $this->objTemplate->parse('no_access');
            }
            if($this->objTemplate->blockExists('upload_form')) {
                $this->objTemplate->hideBlock('upload_form');
            }
            if($this->objTemplate->blockExists('uploaded')) {
                $this->objTemplate->hideBlock('uploaded');
            }
        } else {
            // parse the upload form

            // init uploader
            $uploadId = $this->initUploader();

            // set form parameters
            $formAction = clone \Env::get("Resolver")->getUrl();
            $formAction->setParam("uploadId", $uploadId);
            $formAction->setParam("check", false);
            $formAction->setParam("hash", false);

            $this->objTemplate->setVariable(array(
                "FORM_ACTION" => $formAction,
                "FORM_METHOD" => "POST",

                "FILESHARING_EMAIL" => $_ARRAYLANG["TXT_EMAIL"],
                "FILESHARING_EMAIL_INFO" => $_ARRAYLANG["TXT_FILESHARING_EMAIL_INFO"],
                "FILESHARING_SUBJECT" => $_ARRAYLANG["TXT_FILESHARING_SUBJECT"],
                "FILESHARING_SUBJECT_INFO" => $_ARRAYLANG["TXT_FILESHARING_SUBJECT_INFO"],
                "FILESHARING_MESSAGE" => $_ARRAYLANG["TXT_FILESHARING_MESSAGE"],
                "FILESHARING_MESSAGE_INFO" => $_ARRAYLANG["TXT_FILESHARING_MESSAGE_INFO"],
                "FILESHARING_EXPIRATION" => $_ARRAYLANG["TXT_FILESHARING_EXPIRATION"],
                //"FILESHARING_ACCEPT_TERMS" => $_ARRAYLANG["TXT_FILESHARING_ACCEPT_TERMS"],
                "FILESHARING_SEND" => $_ARRAYLANG["TXT_FILESHARING_SEND"],
                "FILESHARING_MORE" => $_ARRAYLANG["TXT_FILESHARING_MORE"],

                "FILESHARING_ERROR_FILE_NOT_FOUND" => $_ARRAYLANG["TXT_FILESHARING_ERROR_FILE_NOT_FOUND"],
                "FILESHARING_ERROR_NO_FILES_UPLOADED" => $_ARRAYLANG["TXT_FILESHARING_ERROR_NO_FILES_UPLOADED"],

                'TXT_FILESHARING_EXPLANATION' => $_ARRAYLANG['TXT_FILESHARING_EXPLANATION'],
                'TXT_FILESHARING_I_AGREE' => $_ARRAYLANG['TXT_FILESHARING_I_AGREE'],
                'TXT_FILESHARING_TERMS_OF_SERVICE' => $_ARRAYLANG['TXT_FILESHARING_TERMS_OF_SERVICE'],
                'TXT_FILESHARING_I_ACCEPT' => $_ARRAYLANG['TXT_FILESHARING_I_ACCEPT'],
                'TXT_FILESHARING_FILES' => $_ARRAYLANG['TXT_FILESHARING_FILES'],
            ));

            if($this->objTemplate->blockExists('upload_form')) {
                $this->objTemplate->touchBlock("upload_form");
            }
            if($this->objTemplate->blockExists('uploaded')) {
                $this->objTemplate->hideBlock("uploaded");
            }
        }
    }

    /**
     * parse the file list
     *
     * @access private
     */
    private function getFileList()
    {
        global $_ARRAYLANG;

        $this->objUrl->setParam("uploadId", false);
        $this->objTemplate->setVariable(array(
            "NEW_UPLOAD" => $_ARRAYLANG["TXT_FILESHARING_NEW_UPLOAD"],
            "NEW_UPLOAD_HREF" => $this->objUrl,
        ));

        foreach ($this->files as $file) {
            // set the lang variables
            $this->objTemplate->setVariable(array(
                "FILESHARING_FILE_NAME" => $_ARRAYLANG["TXT_FILESHARING_FILE_NAME"],
                "FILESHARING_DOWNLOAD_LINK" => $_ARRAYLANG["TXT_FILESHARING_DOWNLOAD_LINK"],
                "FILESHARING_DELETE_LINK" => $_ARRAYLANG["TXT_FILESHARING_DELETE_LINK"],
            ));

            // set the file variables
            $this->objTemplate->setVariable(array(
                "FILE_NAME" => $file["name"],
                "FILE_IMAGE_SRC" => $file["image"],
                "FILE_DOWNLOAD_LINK_HREF" => $file["download"],
                "FILE_DELETE_LINK_HREF" => $file["delete"],
            ));

            if ($file["image"] === false) {
                if($this->objTemplate->blockExists('image')) {
                    $this->objTemplate->hideBlock("image");
                }
            }

            if($this->objTemplate->blockExists('filesharing_file')) {
                $this->objTemplate->parse("filesharing_file");
            }
        }

        if($this->objTemplate->blockExists('uploaded')) {
            $this->objTemplate->touchBlock("uploaded");
        }
        if($this->objTemplate->blockExists('upload_form')) {
            $this->objTemplate->hideBlock("upload_form");
        }
        if($this->objTemplate->blockExists('confirm_delete')) {
            $this->objTemplate->hideBlock('confirm_delete');
        }
    }

    /**
     * get the shared files by upload id
     *
     * @param integer $uploadId the upload id of the upload
     *
     * @return array with files of the last upload
     *
     * @access private
     */
    private function getSharedFiles($uploadId)
    {
        global $objDatabase;

        $files = array();

        $tup = FilesharingLib::getTemporaryFilePaths($uploadId);

        // loop through the uploaded files
        $objResult = $objDatabase->Execute("SELECT `id`, `file`, `source`, `hash`, `check` FROM " . DBPREFIX . "module_filesharing WHERE `upload_id` = " . intval($uploadId));
        if ($objResult !== false && $objResult->RecordCount() > 0) {
            while (!$objResult->EOF) {
                $filePath = explode("/", $objResult->fields["source"]);
                $fileNameSource = end($filePath);

                $fileSystem = new \Cx\Lib\FileSystem\FileSystem();
                $directory = \Env::get('Resolver')->getCmd();
                if ($directory != 'downloads') {
                    $newPath = ASCMS_FILESHARING_PATH . '/' . $directory . '/';
                } else {
                    $newPath = ASCMS_DOWNLOADS_IMAGES_PATH . '/';
                }
                $fileSystem->copyFile($tup[0] . '/' . $tup[2] . '/', $fileNameSource, $newPath, $fileNameSource, false);

                // get file name
                $fileName = $objResult->fields["file"];

                // get the image url
                $imageUrl = clone \Env::get("Resolver")->getUrl();
                $imageUrl->setParam("act", "image");
                $imageUrl->setParam("hash", $objResult->fields["hash"]);

                $info = pathinfo(ASCMS_PATH_OFFSET . $objResult->fields["source"]);
                // if the file is an image show a thumbnail of the image
                if (!in_array(strtolower($info["extension"]), array("jpeg", "jpg", "png", "gif"))) {
                    $imageUrl = false;
                }

                $files[] = array(
                    "name" => $fileName,
                    "image" => $imageUrl,
                    "download" => parent::getDownloadLink($objResult->fields["id"]),
                    "delete" => parent::getDeleteLink($objResult->fields["id"]),
                );
                $objResult->moveNext();
            }
        }
        return $files;
    }
}
