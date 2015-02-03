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
 * FormUploader
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  coremodule_upload
 */

/**
 * FormUploader - Class for upload via HTML input-tags.
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  coremodule_upload
 */
class FormUploader extends Uploader
{
    /**
     * @override
     */     
    public function handleRequest()
    {
        global $_FILES;

        //get a writable directory
        $targetDir = '/upload_'.$this->uploadId;
        $tempPath = $_SESSION->getTempPath();
        $webTempPath = $_SESSION->getWebTempPath();


        //make sure target directory exists
        if(!file_exists($tempPath.$targetDir))
            \Cx\Lib\FileSystem\FileSystem::make_folder($webTempPath.$targetDir);

        //move all uploaded file to this upload's temp directory
        foreach($_FILES["uploaderFiles"]["error"] as $key => $error) {
            if($error == UPLOAD_ERR_OK) {
                $tmpName = $_FILES["uploaderFiles"]["tmp_name"][$key];
                $name = $_FILES["uploaderFiles"]["name"][$key];

                if (!FWValidator::is_file_ending_harmless($name)) {
                    die('Error:'.sprintf('The file %s was refused due to its file extension which is not allowed!', htmlentities($name, ENT_QUOTES, CONTREXX_CHARSET)));
                }

                //TODO: Uploader::addChunk does this also -> centralize in function
                // remember the "raw" file name, we want to store all original
                // file names in the session.
                $originalFileName = $name;
                // Clean the fileName for security reasons
                $name = preg_replace('/[^\w\._]+/', '', $name);
                $originalFileNames = array();
                if(isset($_SESSION['upload']['handlers'][$this->uploadId]['originalFileNames']))
                    $originalFileNames = $_SESSION['upload']['handlers'][$this->uploadId]['originalFileNames'];
                $originalFileNames[$name] = $originalFileName;
                $_SESSION['upload']['handlers'][$this->uploadId]['originalFileNames'] = $originalFileNames;
                //end of TODO-region
                
                //move file somewhere we know both the web- and normal path...
                @move_uploaded_file($tmpName,ASCMS_TEMP_PATH.'/'.$name);    
                //...then do a safe-mode-safe (yeah) move operation
                \Cx\Lib\FileSystem\FileSystem::move(ASCMS_TEMP_WEB_PATH.'/'.$name, $webTempPath.$targetDir.'/'.$name, true);
            }
        }

        //and call back.
        $this->notifyCallback();
        //redirect the user where he belongs
        $this->redirect();
    }

    /**
     * @override
     */     
    public function getXHtml()
    {
        $iframeUrl = '';   
        if($this->isBackendRequest)
            $iframeUrl = ASCMS_ADMIN_WEB_PATH.'/index.php?cmd=upload&act=formUploaderFrame&uploadId='.$this->uploadId;
        else
            $iframeUrl = CONTREXX_SCRIPT_PATH.'?section=upload&cmd=formUploaderFrame&uploadId='.$this->uploadId;
      
        $tpl = new \Cx\Core\Html\Sigma(ASCMS_CORE_MODULE_PATH.'/upload/template/uploaders');
        $tpl->setErrorHandling(PEAR_ERROR_DIE);

        $tpl->loadTemplateFile('form.html');
        $tpl->setVariable('IFRAME_URL', $iframeUrl);
        
        return $tpl->get();
    }

    public function getFrameXHtml() {
		global $_CORELANG;

        if (!empty($_SESSION['upload']['handlers'][$this->uploadId]['singleFileMode'])) {
            \ContrexxJavascript::getInstance()->setVariable('restrictUpload2SingleFile', true, "upload/widget_$this->uploadId");
        }
	
        //JS / CSS dependencies
        JS::activate('cx');
        JS::registerCSS('core_modules/upload/css/uploaders/form/formUploader.css');
        JS::registerJS('core_modules/upload/js/uploaders/form/formUploader.js');
        
        $uploadPath = $this->getUploadPath('form');

        $redirectUrl = '';   
        if($this->isBackendRequest) {
            $redirectUrl = ASCMS_ADMIN_WEB_PATH.'/index.php?cmd=upload&act=formUploaderFrameFinished&uploadId='.$this->uploadId;
        } else {
            $url = clone \Env::get('cx')->getRequest();
            $url->removeAllParams();
            $url->setParams(array(
                'section' => 'upload',
                'cmd' => 'formUploaderFrameFinished',
                'uploadId' => $this->uploadId,
            ));
            $redirectUrl = (string) $url;
        }
        $this->setRedirectUrl($redirectUrl);
      
        $tpl = new \Cx\Core\Html\Sigma(ASCMS_CORE_MODULE_PATH.'/upload/template/uploaders');
        $tpl->setErrorHandling(PEAR_ERROR_DIE);
        
        $tpl->loadTemplateFile('formFrame.html');
        $tpl->setVariable('UPLOAD_URL', $uploadPath);
        $tpl->setVariable('INCLUDES', JS::getCode());
        $tpl->setVariable('CXJS_INIT_JS', ContrexxJavascript::getInstance()->initJs());
		$tpl->setVariable('UPLOAD_FORM_ADD', $_CORELANG['UPLOAD_FORM_ADD']);
		$tpl->setVariable('UPLOAD', $_CORELANG['UPLOAD']);
		$tpl->setVariable('UPLOAD_ID', $this->uploadId);
        
        $tpl->setVariable('MAX_FILE_SIZE', FWSystem::getMaxUploadFileSize()-1000);
        
        $ls = new \LinkSanitizer(ASCMS_PATH_OFFSET, $tpl->get());
        return $ls->replace();
    }

    public function getFrameFinishedXHtml() {
        global $_CORELANG;
        $tpl = new \Cx\Core\Html\Sigma(ASCMS_CORE_MODULE_PATH.'/upload/template/uploaders');
        $tpl->setErrorHandling(PEAR_ERROR_DIE);

        $tpl->loadTemplateFile('formFrameFinished.html');

        $tpl->setVariable('FINISHED_MESSAGE',htmlentities($_CORELANG['UPLOAD_FINISHED'], ENT_QUOTES, CONTREXX_CHARSET));        
       
        return $tpl->get();
    }
}
