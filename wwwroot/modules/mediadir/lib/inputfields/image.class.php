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
 * Media Directory Inputfield Image Class
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Comvation Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_mediadir
 * @todo        Edit PHP DocBlocks!
 */

/**
 * @ignore
 */
require_once ASCMS_MODULE_PATH . '/mediadir/lib/inputfields/inputfield.interface.php';

/**
 * Media Directory Inputfield Image Class
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_mediadir
 */
class mediaDirectoryInputfieldImage extends mediaDirectoryLibrary implements inputfield
{
    public $arrPlaceholders = array(
        'TXT_MEDIADIR_INPUTFIELD_NAME',
        'MEDIADIR_INPUTFIELD_VALUE',
        'MEDIADIR_INPUTFIELD_VALUE_SRC',
        'MEDIADIR_INPUTFIELD_VALUE_SRC_THUMB',
        'MEDIADIR_INPUTFIELD_VALUE_POPUP',
        'MEDIADIR_INPUTFIELD_VALUE_IMAGE',
        'MEDIADIR_INPUTFIELD_VALUE_THUMB',
        'MEDIADIR_INPUTFIELD_VALUE_FILENAME'
    );

    private $imagePath;
    private $imageWebPath;

    /**
     * Constructor
     */
    function __construct()
    {
        $this->imagePath = constant('ASCMS_'.$this->moduleConstVar.'_IMAGES_PATH').'/';
        $this->imageWebPath = constant('ASCMS_'.$this->moduleConstVar.'_IMAGES_WEB_PATH').'/';
        parent::getSettings();
    }



function getInputfield($intView, $arrInputfield, $intEntryId=null)
    {
        global $objDatabase, $_ARRAYLANG, $objInit;

        switch ($intView) {
            default:
            case 1:
                //modify (add/edit) View
                $intId = intval($arrInputfield['id']);

                if(isset($intEntryId) && $intEntryId != 0) {
                    $objResult = $objDatabase->Execute("
                        SELECT `value`
                          FROM ".DBPREFIX."module_mediadir_rel_entry_inputfields
                         WHERE field_id=$intId
                           AND entry_id=$intEntryId");
                    $strValue = htmlspecialchars($objResult->fields['value'], ENT_QUOTES, CONTREXX_CHARSET);
                } else {
                    $strValue = null;
                }

                if(!empty($strValue) && file_exists(ASCMS_PATH.$strValue.".thumb")) {
                    $objInit->mode == 'backend' ? $style = 'style="border: 1px solid rgb(10, 80, 161); margin: 0px 0px 3px;"' : '';
                    $strImagePreview = '<img src="'.$strValue.'.thumb" alt="" '.$style.'  width="'.intval($this->arrSettings['settingsThumbSize']).'" />&nbsp;<input type="checkbox" value="1" name="deleteMedia['.$intId.']" />'.$_ARRAYLANG['TXT_MEDIADIR_DELETE'].'<br />';
                } else {
                    $strImagePreview = null;
                }

                if(empty($strValue) || $strValue == "new_image") {
                    $strValueHidden = "new_image";
                    $strValue = "";
                } else {
                    $strValueHidden = $strValue;
                }

        if($objInit->mode == 'backend') {
                    $strInputfield =
                        $strImagePreview.'<input type="text" name="'.$this->moduleName.'Inputfield['.$intId.']"'.
                        ' value="'.$strValue.'" id="'.$this->moduleName.'Inputfield_'.$intId.'"'.
                        ' style="width: 300px;" onfocus="this.select();" />'.
                        '&nbsp;<input type="button" value="Durchsuchen"'.
                        ' onClick="getFileBrowser(\''.$this->moduleName.'Inputfield_'.$intId.'\', \''.$this->moduleName.'\', \'/uploads\')" />';
                } else {
                    $strInputfield =
                        $strImagePreview.
                        '<input type="file" name="imageUpload_'.$intId.'"'.
                        ' id="'.$this->moduleName.'Inputfield_'.$intId.'"'.
                        ' class="'.$this->moduleName.'InputfieldImage '.
// TODO: Not defined
//                        $strInfoClass.
                        '" '.
//                        $strInfoValue.
                        ' value="'.$strValue.'" onfocus="this.select();" />'.
                        '<input id="'.$this->moduleName.'Inputfield_'.$intId.'_hidden"'.
                        ' name="'.$this->moduleName.'Inputfield['.$intId.']"'.
                        ' value="'.$strValueHidden.'" type="hidden">'.
                        '<span class="'.$this->moduleName.'InputfieldFilesize">'.
                        $_ARRAYLANG['TXT_MEDIADIR_MAX_FILESIZE'].
                        ' '.intval($this->arrSettings['settingsImageFilesize']).
                        ' KB</span>';
                }

                return $strInputfield;

                break;
            case 2:
                // search view
                break;
        }
        return null;
    }



    function saveInputfield($intInputfieldId, $strValue)
    {
        global $objInit;

        if($objInit->mode == 'backend') {
            if (   empty($_POST["deleteMedia"][$intInputfieldId])
                || $_POST["deleteMedia"][$intInputfieldId] != 1) {
                $this->checkThumbnail($strValue);
                $strValue = contrexx_input2raw($strValue);
            } else {
                $strValue = null;
            }
        } else {
            if (!empty($_FILES['imageUpload_'.$intInputfieldId]['name']) || $_POST["deleteMedia"][$intInputfieldId] == 1) {
                $intFilsize = intval($this->arrSettings['settingsImageFilesize']*1024);
                if($_FILES['imageUpload_'.$intInputfieldId]['size'] < $intFilsize) {
	            	//delete image & thumb
	                $this->deleteImage($strValue);
	                if ($_POST["deleteMedia"][$intInputfieldId] != 1) {
	                    //upload image
	                    $strValue = $this->uploadMedia($intInputfieldId);
	                } else {
	                    $strValue = null;
	                }
                } else {
                    $strValue = null;
                }
            } else {
                $strValue = contrexx_input2raw($strValue);
            }
        }

        return $strValue;
    }


    function checkThumbnail($strPathImage)
    {
        $this->createThumbnail($strPathImage);
    }

    function deleteImage($strPathImage)
    {
        if(!empty($strPathImage)) {
            $objFile = new File();
            $arrImageInfo = pathinfo($strPathImage);
            $imageName    = $arrImageInfo['basename'];

            //delete thumb
            if (file_exists(ASCMS_PATH.$strPathImage.".thumb")) {
                $objFile->delFile($this->imagePath, $this->imageWebPath, 'images/'.$imageName.".thumb");
            }

            //delete image
            if (file_exists(ASCMS_PATH.$strPathImage)) {
                $objFile->delFile($this->imagePath, $this->imageWebPath, 'images/'.$imageName);
            }
        }
    }


    function uploadMedia($intInputfieldId)
    {
        global $objDatabase;

        if (empty($_FILES)) {
            return false;
        }
        $tmpImage   = $_FILES['imageUpload_'.$intInputfieldId]['tmp_name'];
        $imageName  = $_FILES['imageUpload_'.$intInputfieldId]['name'];
//        $imageType  = $_FILES['imageUpload_'.$intInputfieldId]['type'];
//        $imageSize  = $_FILES['imageUpload_'.$intInputfieldId]['size'];
        if ($imageName == '') {
            return false;
        }
        // get extension
        $arrImageInfo   = pathinfo($imageName);
        $imageExtension = !empty($arrImageInfo['extension']) ? '.'.$arrImageInfo['extension'] : '';
        $imageBasename  = $arrImageInfo['filename'];
        $randomSum      = rand(10, 99);
        // encode filename
        if ($this->arrSettings['settingsEncryptFilenames'] == 1) {
            $imageName = md5($randomSum.$imageBasename).$imageExtension;
        }
        // check filename
        if (file_exists($this->imagePath.'images/'.$imageName)) {
            $imageName = $imageBasename.'_'.time().$imageExtension;
        }
        // upload file
        if (!move_uploaded_file($tmpImage, $this->imagePath.'images/'.$imageName)) {
            return false;
        }
        $imageDimension = getimagesize($this->imagePath.'images/'.$imageName);
        $intNewWidth = $imageDimension[0];
        $intNewHeight = $imageDimension[1];
        $imageFormat = ($imageDimension[0] > $imageDimension[1]) ? 1 : 0;
        $setNewSize = 0;
        if ($imageDimension[0] > 640 && $imageFormat == 1) {
            $doubleFactorDimension = 640 / $imageDimension[0];
            $intNewWidth = 640;
            $intNewHeight = round($doubleFactorDimension * $imageDimension[1], 0);
            $setNewSize = 1;
        } elseif($imageDimension[1] > 480) {
            $doubleFactorDimension = 480 / $imageDimension[1];
            $intNewHeight = 480;
            $intNewWidth = round($doubleFactorDimension * $imageDimension[0], 0);
            $setNewSize = 1;
        }
        if ($setNewSize == 1) {
            $objImage = new ImageManager();
            $objImage->loadImage($this->imagePath.'images/'.$imageName);
            $objImage->resizeImage($intNewWidth, $intNewHeight, 100);
            $objImage->saveNewImage($this->imagePath.'images/'.$imageName, true);
        }
        $objFile = new File();
        $objFile->setChmod($this->imagePath, $this->imageWebPath, 'images/'.$imageName);
        // create thumbnail
        $this->checkThumbnail($this->imageWebPath.'images/'.$imageName);
        return $this->imageWebPath.'images/'.$imageName;
    }


    function createThumbnail($strPathImage)
    {
        global $objDatabase;

        $arrImageInfo = getimagesize(ASCMS_PATH.$strPathImage);

        if (   $arrImageInfo['mime'] == "image/gif"
            || $arrImageInfo['mime'] == "image/jpeg"
            || $arrImageInfo['mime'] == "image/jpg"
            || $arrImageInfo['mime'] == "image/png") {
            $objImage = new ImageManager();

            $arrImageInfo = array_merge($arrImageInfo, pathinfo($strPathImage));

            $thumbWidth = intval($this->arrSettings['settingsThumbSize']);
            $thumbHeight = intval($thumbWidth / $arrImageInfo[0] * $arrImageInfo[1]);

            $objImage->loadImage(ASCMS_PATH.$strPathImage);
            $objImage->resizeImage($thumbWidth, $thumbHeight, 100);
            $objImage->saveNewImage(ASCMS_PATH.$strPathImage . '.thumb', true);
        }
    }


    function deleteContent($intEntryId, $intIputfieldId)
    {
        global $objDatabase;

        //get image path
        /*$objDatabase->Execute("
            SELECT value
              FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_inputfields
             WHERE `entry_id`='".intval($intEntryId)."'
               AND `field_id`='".intval($intIputfieldId)."'");
        $strImagePath = $objResult->fields['value'];*/

        //delete relation
        $objResult = $objDatabase->Execute("
            DELETE FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_inputfields
             WHERE `entry_id`='".intval($intEntryId)."'
               AND  `field_id`='".intval($intIputfieldId)."'");
        if ($objResult) {
            //delete image
            //$this->deleteImage($strImagePath);
            return true;
        }
        return false;
    }



    function getContent($intEntryId, $arrInputfield, $arrTranslationStatus)
    {
        global $objDatabase;

        $intId = intval($arrInputfield['id']);

        $objResult = $objDatabase->Execute("
            SELECT `value`
              FROM ".DBPREFIX."module_mediadir_rel_entry_inputfields
             WHERE field_id=$intId
               AND entry_id=$intEntryId");
        $strValue = strip_tags(htmlspecialchars($objResult->fields['value'], ENT_QUOTES, CONTREXX_CHARSET));
        if (empty($strValue) || $strValue == 'new_image') {
            return null;
        }
        $arrImageInfo   = getimagesize(ASCMS_PATH.$strValue);
        $imageWidth     = $arrImageInfo[0]+20;
        $imageHeight    = $arrImageInfo[1]+20;
        $arrImageInfo   = pathinfo($strValue);
        $strImageName    = $arrImageInfo['basename'];

        return array(
            'TXT_MEDIADIR_INPUTFIELD_NAME' => htmlspecialchars(
                $arrInputfield['name'][0], ENT_QUOTES, CONTREXX_CHARSET),
            'MEDIADIR_INPUTFIELD_VALUE' =>
                '<a rel="shadowbox[1];options={slideshowDelay:5}" href="'.$strValue.'">'.
                '<img src="'.$strValue.'.thumb" alt="" border="0" title="" '.
                'width="'.intval($this->arrSettings['settingsThumbSize']).'" /></a>',
            'MEDIADIR_INPUTFIELD_VALUE_SRC' => $strValue,
            'MEDIADIR_INPUTFIELD_VALUE_FILENAME' => $strImageName,
            'MEDIADIR_INPUTFIELD_VALUE_SRC_THUMB' => $strValue.".thumb",
            'MEDIADIR_INPUTFIELD_VALUE_POPUP' =>
                '<a href="'.$strValue.'"'.
                ' onclick="window.open(this.href,\'\',\'resizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=no,width='.$imageWidth.',height='.$imageHeight.',status\');return false">'.
                '<img src="'.$strValue.'.thumb" title="'.$arrInputfield['name'][0].'"'.
                ' width="'.intval($this->arrSettings['settingsThumbSize']).'"'.
                ' alt="'.$arrInputfield['name'][0].'" border="0" /></a>',
            'MEDIADIR_INPUTFIELD_VALUE_IMAGE' =>
                '<img src="'.$strValue.'" title="'.$arrInputfield['name'][0].'"'.
                ' alt="'.$arrInputfield['name'][0].'" />',
            'MEDIADIR_INPUTFIELD_VALUE_THUMB' =>
                '<img src="'.$strValue.'.thumb"'.
                ' width="'.intval($this->arrSettings['settingsThumbSize']).'"'.
                ' title="'.$arrInputfield['name'][0].'"'.
                ' alt="'.$arrInputfield['name'][0].'" />',
        );
    }


    function getJavascriptCheck()
    {
    	global $objInit;
    	
        $fieldName = $this->moduleName."Inputfield_";
        
        if($objInit->mode == 'backend') {
            $hiddenField = "value_hidden = false";
        } else {
            $hiddenField = "value_hidden = document.getElementById('".$fieldName."' + field + '_hidden').value;";
        }
        $strJavascriptCheck = <<<EOF

            case 'image':
                value = document.getElementById('$fieldName' + field).value;
                $hiddenField
                filetype = value.substring(value.length-4);
                filetype = filetype.toLowerCase();

                if (value == "" && value_hidden == "" && isRequiredGlobal(inputFields[field][1], value)) {
                    isOk = false;
                    document.getElementById('$fieldName' + field).style.border = "#ff0000 1px solid";
                } else if (value != "" && filetype != ".jpg" && filetype != ".gif" && filetype != ".png" ) {
                    isOk = false;
                    document.getElementById('$fieldName' + field).style.border = "#ff0000 1px solid";
                } else {
                    document.getElementById('$fieldName' + field).style.borderColor = '';
                }
                break;

EOF;
        return $strJavascriptCheck;
    }


    function getFormOnSubmit($intInputfieldId)
    {
        return null;
    }
}
