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
 * Media Directory Inputfield Radio Class
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
 * Media Directory Inputfield Radio Class
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_mediadir
 */
class mediaDirectoryInputfieldRadio extends mediaDirectoryLibrary implements inputfield
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
                    $strValue = intval($objInputfieldValue->fields['value']);
                } else {
                    $strValue = null;
                }

                $strOptions = empty($arrInputfield['default_value'][$_LANGID]) ? $arrInputfield['default_value'][0] : $arrInputfield['default_value'][$_LANGID];
                $arrOptions = explode(",", $strOptions);
				$strInputfield = '';
				
				if(!empty($arrInputfield['info'][0])){
                    $strInfoValue = empty($arrInputfield['info'][$_LANGID]) ? 'title="'.$arrInputfield['info'][0].'"' : 'title="'.$arrInputfield['info'][$_LANGID].'"';
                    $strInfoClass = 'mediadirInputfieldHint';
                } else {
                    $strInfoValue = null;
                    $strInfoClass = '';
                }

                if($objInit->mode == 'backend') {
                    foreach($arrOptions as $intKey => $strDefaultValue) {
                        $intKey++;
                        if($strValue == $intKey || (empty($strValue) && $intKey == 1)) {
                            $strChecked = 'checked="checked"';
                        } else {
                            $strChecked = '';
                        }

                        $strInputfield .= '<input type="radio" name="'.$this->moduleName.'Inputfield['.$intId.']" id="'.$this->moduleName.'Inputfield_'.$intId.'_'.$intKey.'" value="'.$intKey.'" '.$strChecked.' />&nbsp;'.$strDefaultValue.'<br />';
                    }
                } else {
                    foreach($arrOptions as $intKey => $strDefaultValue) {
                        $intKey++;
                        if($strValue == $intKey || (empty($strValue) && $intKey == 1)) {
                            $strChecked = 'checked="checked"';
                        } else {
                            $strChecked = '';
                        }

                        $strInputfield .= '<input class="'.$this->moduleName.'InputfieldRadio '.$strInfoClass.'" '.$strInfoValue.' type="radio" name="'.$this->moduleName.'Inputfield['.$intId.']" id="'.$this->moduleName.'Inputfield_'.$intId.'_'.$intKey.'" value="'.$intKey.'" '.$strChecked.' />&nbsp;'.$strDefaultValue.'<br />';
                    }
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
        $strValue = contrexx_strip_tags(contrexx_input2raw($strValue));
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

        $intValueKey = intval($objInputfieldValue->fields['value'])-1;
        $arrValues = explode(",", $arrInputfield['default_value'][0]);
        $strValue = strip_tags(htmlspecialchars($arrValues[$intValueKey], ENT_QUOTES, CONTREXX_CHARSET));

        if(!empty($strValue)) {
            $arrContent['TXT_'.$this->moduleLangVar.'_INPUTFIELD_NAME'] = htmlspecialchars($arrInputfield['name'][0], ENT_QUOTES, CONTREXX_CHARSET);
            $arrContent[$this->moduleLangVar.'_INPUTFIELD_VALUE'] = $strValue;
        } else {
            $arrContent = null;
        }

        return $arrContent;
    }


    function getJavascriptCheck()
    {
        $strJavascriptCheck = <<<EOF
EOF;
        return $strJavascriptCheck;
    }
    
    
    function getFormOnSubmit($intInputfieldId)
    {
        return null;
    }
}
