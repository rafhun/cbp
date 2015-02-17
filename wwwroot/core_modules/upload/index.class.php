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
 * Upload
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  coremodule_upload
 */

/**
 * Upload
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  coremodule_upload
 */
class Upload extends UploadLib
{
    public function getPage()
    {
        $act = '';
        if(isset($_REQUEST['cmd'])) {
            $act = $_REQUEST['cmd'];
        }
        if(isset($_REQUEST['act'])) {
            $act = $_REQUEST['act'];
        }

        switch($act) {
            //uploaders
            case 'upload': //an uploader is sending data
                $this->upload();
                break;
            case 'ajaxUploaderCode':
                $this->ajaxUploaderCode();
                break;
            //uploaders - formuploader
            case 'formUploaderFrame': //send the formuploader iframe content
                $this->formUploaderFrame();
                break;
            case 'formUploaderFrameFinished': //send the formuploader iframe content
                $this->formUploaderFrameFinished();
                break;
            //uploaders - jumploader
            case 'jumpUploaderApplet': //send the jumpUploader applet
                $this->jumpUploaderApplet();
                break;
            case 'jumpUploaderL10n': //send the jumpUploader messages
                $this->jumpUploaderL10n(basename($_GET['lang']));
                break;
            case 'response':
                $this->response($_GET['upload']);
                break;

            //folderWidget
            case 'refreshFolder':
                $this->refreshFolder();
                break;
            case 'deleteFile': //a folderWidget wants to delete something
                $this->deleteFile();
                break;
        }
    }
}
