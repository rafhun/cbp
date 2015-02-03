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
 * Media Directory Inputfield Product Attributes Class
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
 * Media Directory Inputfield Product Attributes Class
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_mediadir
 */
class mediaDirectoryInputfieldProduct_attributes extends mediaDirectoryLibrary implements inputfield
{
    public $arrPlaceholders = array('TXT_MEDIADIR_INPUTFIELD_NAME','MEDIADIR_INPUTFIELD_VALUE');



    /**
     * Constructor
     */
    function __construct()
    {
    }



    function getInputfield($intView, $arrInputfield, $intEntryId=null)
    {
        global $objDatabase, $_LANGID, $objInit, $_ARRAYLANG;
        
        $intId = intval($arrInputfield['id']);

        switch ($intView) {
            default:
            case 1:
                //modify (add/edit) View
                if(isset($intEntryId) && $intEntryId != 0) {
                    $objInputfieldValue = $objDatabase->Execute("
                        SELECT
                            `value`
                        FROM
                            ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_inputfields
                        WHERE
                            field_id=".$intId."
                        AND
                            entry_id=".$intEntryId."
                        LIMIT 1
                    ");
                    if(!empty($objInputfieldValue->fields['value'])) {
                        $arrValue = explode(",",$objInputfieldValue->fields['value']);
                    } else {
                        $arrValue = null;
                    }
                } else {
                    $arrValue = null;
                }

                $strOptions = empty($arrInputfield['default_value'][$_LANGID]) ? $arrInputfield['default_value'][0] : $arrInputfield['default_value'][$_LANGID];
                $arrOptions = explode(",", $strOptions);
                
                if(!empty($arrInputfield['info'][0])){
                    $strInfoValue = empty($arrInputfield['info'][$_LANGID]) ? 'title="'.$arrInputfield['info'][0].'"' : 'title="'.$arrInputfield['info'][$_LANGID].'"';
                    $strInfoClass = 'mediadirInputfieldHint';
                } else {
                    $strInfoValue = null;
                    $strInfoClass = '';
                }

                if($objInit->mode == 'backend') {
                    $strInputfield = '<span id="'.$this->moduleName.'Inputfield_'.$intId.'_list" style="display: block;">';
                    foreach($arrOptions as $intKey => $strDefaultValue) {
                        $intKey++;
                        if(in_array($intKey, $arrValue)) {
                            $strChecked = 'checked="checked"';
                        } else {
                            $strChecked = '';
                        }

                        $strInputfield .= '<input type="checkbox" name="'.$this->moduleName.'Inputfield['.$intId.'][]" id="'.$this->moduleName.'Inputfield_'.$intId.'_'.$intKey.'" value="'.$intKey.'" '.$strChecked.' />&nbsp;'.$strDefaultValue.'<br />';
                    }

                    $strInputfield .= '</span>';
                } else {
                    $strInputfield = '<span id="'.$this->moduleName.'Inputfield_'.$intId.'_list" style="display: block;">';

                    foreach($arrOptions as $intKey => $strDefaultValue) {
                        $intKey++;
                        if(in_array($intKey, $arrValue)) {
                            $strChecked = 'checked="checked"';
                        } else {
                            $strChecked = '';
                        }

                        $strInputfield .= '<input class="'.$this->moduleName.'InputfieldCheckbox '.$strInfoClass.'" '.$strInfoValue.' type="checkbox" name="'.$this->moduleName.'Inputfield['.$intId.'][]" id="'.$this->moduleName.'Inputfield_'.$intId.'_'.$intKey.'" value="'.$intKey.'" '.$strChecked.' />&nbsp;'.$strDefaultValue.'<br />';
                    }


                    $strInputfield .= '</span>';
                }


                return $strInputfield;

                break;
            case 2:
                //search View
                $strOptions = empty($arrInputfield['default_value'][$_LANGID]) ? $arrInputfield['default_value'][0] : $arrInputfield['default_value'][$_LANGID];
                $arrOptions = explode(",", $strOptions);

                $strValue = isset($_GET[$intId]) ? $_GET[$intId] : '';

                $strInputfield = '<select name="'.$intId.'" class="'.$this->moduleName.'InputfieldSearch">';
                $strInputfield .= '<option  value="">'.$_ARRAYLANG['TXT_MEDIADIR_PLEASE_CHOOSE'].'</option>';

                foreach($arrOptions as $intKey => $strDefaultValue) {
                    $intKey++;
                    if($strValue == $intKey) {
                        $strChecked = 'selected="selected"';
                    } else {
                        $strChecked = '';
                    }

                    $strInputfield .= '<option value="'.$intKey.'" '.$strChecked.'>'.$strDefaultValue.'</option>';
                }

                $strInputfield .= '</select>';

                return $strInputfield;

                break;
        }
    }



    function saveInputfield($intInputfieldId, $strValue)
    {
        $arrValue = $strValue;

        foreach($arrValue as $intKey => $strValue) {
            $arrValue[$intKey] = $strValue = contrexx_strip_tags(contrexx_input2raw($strValue));
        }

        $strValue = join(",",$arrValue);

        return $strValue;
    }


    function deleteContent($intEntryId, $intIputfieldId)
    {
        global $objDatabase;

        $objDeleteInputfield = $objDatabase->Execute("DELETE FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_inputfields WHERE `entry_id`='".intval($intEntryId)."' AND  `field_id`='".intval($intIputfieldId)."'");

        if($objDeleteEntry !== false) {
            return true;
        } else {
            return false;
        }
    }



    function getContent($intEntryId, $arrInputfield, $arrTranslationStatus)
    {
        global $objDatabase;

        $intId = intval($arrInputfield['id']);
        $objInputfieldValue = $objDatabase->Execute("
            SELECT
                `value`
            FROM
                ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_inputfields
            WHERE
                field_id=".$intId."
            AND
                entry_id=".$intEntryId."
            LIMIT 1
        ");


        $arrValues = explode(",", $arrInputfield['default_value'][0]);
        $strValue = strip_tags(htmlspecialchars($objInputfieldValue->fields['value'], ENT_QUOTES, CONTREXX_CHARSET));

        //explode elements
        $arrElements = explode(",", $strValue);

        //open <span> layer
        $strValue = '<span class="'.$this->moduleName.'InputfieldProductAttributes">';

        //make element list
        foreach ($arrElements as $intKey => $strElement) {
            $strElement = $strElement-1;
            $strValue .= '<img src="images/modules/'.$this->moduleName.'/'.strtolower($arrValues[$strElement]).'.png" alt="'.$arrValues[$strElement].'" title="'.$arrValues[$strElement].'" />';
        }

        //close <span> layer
        $strValue .= '</span>';

        if($arrElements[0] != null) {
            $arrContent['TXT_'.$this->moduleLangVar.'_INPUTFIELD_NAME'] = htmlspecialchars($arrInputfield['name'][0], ENT_QUOTES, CONTREXX_CHARSET);
            $arrContent[$this->moduleLangVar.'_INPUTFIELD_VALUE'] = $strValue;
        } else {
            $arrContent = null;
        }

        return $arrContent;
    }


    function getJavascriptCheck()
    {
        $fieldName = $this->moduleName."Inputfield_";
        $fieldName2 = $this->moduleName."Inputfield[";
        $strJavascriptCheck = <<<EOF

            case 'checkbox':
                if (isRequiredGlobal(inputFields[field][1], value)) {
                    var boxes = document.getElementsByName('$fieldName2' + field + '][]');
                    var checked = false;

                    for (var i = 0; i < boxes.length; i++) {
                        if (boxes[i].checked) {
                            checked = true;
                        }
                    }

                    if (!checked) {
                        document.getElementById('$fieldName' + field + '_list').style.border = "#ff0000 1px solid";
                        isOk = false;
                    } else {
                        document.getElementById('$fieldName' + field + '_list').style.border = "#ff0000 0px solid";
                    }
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
