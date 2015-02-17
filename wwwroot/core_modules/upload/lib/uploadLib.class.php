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
 * UploadLib
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  coremodule_upload
 */

/**
 * UploadLib
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  coremodule_upload
 */
class UploadLib
{
    //processes uploads sent by an uploader
    public function upload() 
    {
        //create the right upload handler...
        $uploader = UploadFactory::getInstance()->uploaderFromRequest();
        //...and let him do the work.
        $uploader->handleRequest();
    }

    //gets the uploader code as requested
    public function ajaxUploaderCode()
    {
        $uploader = UploadFactory::getInstance()->uploaderFromRequest();
        die($uploader->getXHtml());
    }

    public function formUploaderFrame() {
        //send the formuploader iframe content
        $uploader = UploadFactory::getInstance()->uploaderFromRequest('form');
        die($uploader->getFrameXHtml());
    }
    
    //show the upload finished page.
    public function formUploaderFrameFinished() {
        $uploader = UploadFactory::getInstance()->uploaderFromRequest('form');
        die($uploader->getFrameFinishedXHtml());        
    }

    //send the jumpUploader applet
    public function jumpUploaderApplet() {
        //the applet is sent via request because of basic auth problems with a path for the .jar-file that is different from the path the browser authenticated himself against.
        require_once ASCMS_LIBRARY_PATH . '/PEAR/Download.php';
        $download = new HTTP_Download();
        $download->setFile(ASCMS_CORE_MODULE_PATH.'/upload/ressources/uploaders/jump/jumpLoader.jar');
        $download->setContentType('application/java-archive');
        $download->send();
        die();      
    }

    //send the jumpUploader messages
    public function jumpUploaderL10n($langCode) {
        //the messages are sent via request because of basic auth problems with a path for the .zip-file that is different from the path the browser authenticated himself against.
        require_once ASCMS_LIBRARY_PATH . '/PEAR/Download.php';
        $download = new HTTP_Download();
        //load correct language file
        $objFWUser = FWUser::getFWUserObject();

        $download->setFile(ASCMS_CORE_MODULE_PATH.'/upload/ressources/uploaders/jump/messages_'.$langCode.'.zip');
        $download->setContentType('application/zip');
        $download->send();
        die();      
    }

    //gets the current folder contents for a folderwidget
    public function refreshFolder()
    {
        $folderWidget = UploadFactory::getInstance()->folderWidgetFromRequest();
        die($folderWidget->getFilesJSON());
    }

    //deletes a file upon a folderWidget's request
    public function deleteFile() {
        $fw = UploadFactory::getInstance()->folderWidgetFromRequest();      
        $fw->delete($_REQUEST['file']);        
        die();
    }

    public function response($uploadId) {

        if(isset($_SESSION['upload']['handlers'][$uploadId]['response_data'])) {
            $r = UploadResponse::fromSession($_SESSION['upload']['handlers'][$uploadId]['response_data']);
            if($r->isUploadFinished()) {
                echo $r->getJSON();
                unset($_SESSION['upload']['handlers'][$uploadId]['response_data']);
                die();
            }
        }

        // don't write session-data to database
        $_SESSION->discardChanges();
        echo '{}';
        die();
    }
}
