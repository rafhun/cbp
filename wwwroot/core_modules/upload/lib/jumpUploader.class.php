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
 * JumpUploader
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  coremodule_upload
 */

/**
 * JumpUploader
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  coremodule_upload
 */
class JumpUploader extends Uploader
{
    /**
     * @override
     */     
    public function handleRequest()
    {    
        // Get parameters
        $chunk = $_POST['partitionIndex'];
        $chunks = $_POST['partitionCount'];
        $fileName = contrexx_stripslashes($_FILES['file']['name']);
        $fileCount = $_GET['files'];

        // check if the file has a valid file extension
        if (FWValidator::is_file_ending_harmless($fileName)) {
            try {
                $this->addChunk($fileName, $chunk, $chunks);
            }
            catch (UploaderException $e) {
                die('Error:'.$e->getMessage());
            }

            if($chunk == $chunks-1) //upload of current file finished
                $this->handleCallback($fileCount);
        }
        else {
            $this->addHarmfulFileToResponse($fileName);
        }

        die(0); 
    }

    /**
     * @override
     */     
    public function getXHtml($backend = false)
    {
      global $objInit;
      $uploadPath = $this->getUploadPath('jump');

      $tpl = new \Cx\Core\Html\Sigma(ASCMS_CORE_MODULE_PATH.'/upload/template/uploaders');
      $tpl->setErrorHandling(PEAR_ERROR_DIE);
      
      $tpl->loadTemplateFile('jump.html');

      $basePath = 'index.php?';
      $basePath .= ($this->isBackendRequest ? 'cmd=upload&act' : 'section=upload&cmd'); //act and cmd vary 
      $appletPath = $basePath.'=jumpUploaderApplet';
      $l10nPath = $basePath.'=jumpUploaderL10n';

      $langId;
      if(!$this->isBackendRequest)
          $langId = $objInit->getFrontendLangId();
      else //backend
          $langId = $objInit->getBackendLangId();
      $langCode = FWLanguage::getLanguageCodeById($langId);
      if (!file_exists(ASCMS_CORE_MODULE_PATH.'/upload/ressources/uploaders/jump/messages_'.$langCode.'.zip')) {
          $langCode = 'en';
      }
      $l10nPath .= '&lang='.$langCode;

      $tpl->setVariable('UPLOAD_CHUNK_LENGTH', FWSystem::getMaxUploadFileSize()-1000);
      $tpl->setVariable('UPLOAD_APPLET_URL', $appletPath);
      $tpl->setVariable('UPLOAD_LANG_URL', $l10nPath);
      $tpl->setVariable('UPLOAD_URL', $uploadPath);
      $tpl->setVariable('UPLOAD_ID', $this->uploadId);
      
      return $tpl->get();
    }
}
