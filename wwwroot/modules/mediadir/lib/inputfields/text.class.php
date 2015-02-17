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
 * Media  Directory Inputfield Text Class
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
 * Media  Directory Inputfield Text Class
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Comvation Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_mediadir
 * @todo        Edit PHP DocBlocks!
 */
class mediaDirectoryInputfieldText extends mediaDirectoryLibrary implements inputfield
{
    public $arrPlaceholders = array('TXT_MEDIADIR_INPUTFIELD_NAME','MEDIADIR_INPUTFIELD_VALUE');

    /**
     * Constructor
     */
    function __construct()
    {
        parent::getFrontendLanguages();
        parent::getSettings();
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
                            `value`,
                            `lang_id`
                        FROM
                            ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_inputfields
                        WHERE
                            field_id=".$intId."
                        AND
                            entry_id=".$intEntryId."
                    ");
                    if ($objInputfieldValue !== false) {
                        while (!$objInputfieldValue->EOF) {
                            $arrValue[intval($objInputfieldValue->fields['lang_id'])] = contrexx_raw2xhtml($objInputfieldValue->fields['value']);
                            $objInputfieldValue->MoveNext();
                        }
                        $arrValue[0] = $arrValue[$_LANGID];
                    }
                } else {
                    $arrValue = null;
                }

                if(empty($arrValue)) {
                	foreach($arrInputfield['default_value'] as $intLangKey => $strDefaultValue) {
                		$strDefaultValue = empty($strDefaultValue) ? $arrInputfield['default_value'][0] : $strDefaultValue;
                	    if(substr($strDefaultValue,0,2) == '[[') {
                            $objPlaceholder = new mediaDirectoryPlaceholder();
                            $arrValue[$intLangKey] = $objPlaceholder->getPlaceholder($strDefaultValue);
                        } else {
                            $arrValue[$intLangKey] = $strDefaultValue;
                        }
                	}
                }

                $arrInfoValue = array();
                if(!empty($arrInputfield['info'][0])){
                	$arrInfoValue[0] = 'title="'.$arrInputfield['info'][0].'"';
	                foreach($arrInputfield['info'] as $intLangKey => $strInfoValue) {
	                	$strInfoClass = 'mediadirInputfieldHint';
	                    $arrInfoValue[$intLangKey] = empty($strInfoValue) ? 'title="'.$arrInputfield['info'][0].'"' : 'title="'.$strInfoValue.'"';
	                }
                } else {
                	$arrInfoValue = null;
                    $strInfoClass = '';
                }

                if($objInit->mode == 'backend') {
                    $strInputfield = '<div id="'.$this->moduleName.'Inputfield_'.$intId.'_Minimized" style="display: block;"><input type="text" data-id="'.$intId.'" class="'.$this->moduleName.'InputfieldDefault" name="'.$this->moduleName.'Inputfield['.$intId.'][0]" id="'.$this->moduleName.'Inputfield_'.$intId.'_0" value="'.$arrValue[0].'" style="width: 300px" onfocus="this.select();" />&nbsp;<a href="javascript:ExpandMinimize(\''.$intId.'\');">'.$_ARRAYLANG['TXT_MEDIADIR_MORE'].'&nbsp;&raquo;</a></div>';

                    $strInputfield .= '<div id="'.$this->moduleName.'Inputfield_'.$intId.'_Expanded" style="display: none;">';
                    foreach ($this->arrFrontendLanguages as $key => $arrLang) {
                        $intLangId = $arrLang['id'];

                        if(($key+1) == count($this->arrFrontendLanguages)) {
                            $minimize = "&nbsp;<a href=\"javascript:ExpandMinimize('".$intId."');\">&laquo;&nbsp;".$_ARRAYLANG['TXT_MEDIADIR_MINIMIZE']."</a>";
                        } else {
                            $minimize = "";
                        }

                        $strInputfield .= '<input type="text" data-id="'.$intId.'" name="'.$this->moduleName.'Inputfield['.$intId.']['.$intLangId.']" id="'.$this->moduleName.'Inputfield_'.$intId.'_'.$intLangId.'" value="'.$arrValue[$intLangId].'" style="width: 279px; margin-bottom: 2px; padding-left: 21px; background: #ffffff url(\'images/flags/flag_'.$arrLang['lang'].'.gif\') no-repeat 3px 3px;" onfocus="this.select();" />&nbsp;'.$arrLang['name'].'&nbsp;'.$minimize.'<br />';
                    }                    
                    $strInputfield .= '</div>';
                } else {
                    if($this->arrSettings['settingsFrontendUseMultilang'] == 1) {
	                    $strInputfield = '<div id="'.$this->moduleName.'Inputfield_'.$intId.'_Minimized" style="display: block; float: left;" class="'.$this->moduleName.'GroupMultilang"><input type="text" data-id="'.$intId.'" class="'.$this->moduleName.'InputfieldDefault" name="'.$this->moduleName.'Inputfield['.$intId.'][0]" id="'.$this->moduleName.'Inputfield_'.$intId.'_0" value="'.$arrValue[0].'" class="'.$this->moduleName.'InputfieldText '.$strInfoClass.'" '.$arrInfoValue[0].'/>&nbsp;<a href="javascript:ExpandMinimize(\''.$intId.'\');">'.$_ARRAYLANG['TXT_MEDIADIR_MORE'].'&nbsp;&raquo;</a></div>';

	                    $strInputfield .= '<div id="'.$this->moduleName.'Inputfield_'.$intId.'_Expanded" style="display: none;  float: left;" class="'.$this->moduleName.'GroupMultilang">';
	                    foreach ($this->arrFrontendLanguages as $key => $arrLang) {
	                        $intLangId = $arrLang['id'];

	                        if(($key+1) == count($this->arrFrontendLanguages)) {
	                            $minimize = "&nbsp;<a href=\"javascript:ExpandMinimize('".$intId."');\">&laquo;&nbsp;".$_ARRAYLANG['TXT_MEDIADIR_MINIMIZE']."</a>";
	                        } else {
	                            $minimize = "";
	                        }

	                        $strInputfield .= '<input type="text" data-id="'.$intId.'" name="'.$this->moduleName.'Inputfield['.$intId.']['.$intLangId.']" id="'.$this->moduleName.'Inputfield_'.$intId.'_'.$intLangId.'" value="'.$arrValue[$intLangId].'" class="'.$this->moduleName.'InputfieldText '.$strInfoClass.'" '.$arrInfoValue[$intLangId].' onfocus="this.select();" />&nbsp;'.$arrLang['name'].'&nbsp;'.$minimize.'<br />';
	                    }	                    
	                    $strInputfield .= '</div>';
                    } else {
                    	$strInputfield = '<input type="text" name="'.$this->moduleName.'Inputfield['.$intId.'][0]" id="'.$this->moduleName.'Inputfield_'.$intId.'_0" value="'.$arrValue[0].'" class="'.$this->moduleName.'InputfieldText '.$strInfoClass.'" '.$arrInfoValue[0].'/>';
                    }
                }
                return $strInputfield;
            case 2:
                //search View
                $strValue = (isset ($_GET[$intId]) ? $_GET[$intId] : '');
                $strInputfield = '<input type="text" name="'.$intId.'" " class="'.$this->moduleName.'InputfieldSearch" value="'.$strValue.'" />';
                return $strInputfield;
        }
    }



    function saveInputfield($intInputfieldId, $strValue)
    {
        $strValue = contrexx_input2raw(strip_tags($strValue));
        return $strValue;
    }


    function deleteContent($intEntryId, $intIputfieldId)
    {
        global $objDatabase;

        return (boolean)$objDatabase->Execute("
            DELETE FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_inputfields
             WHERE `entry_id`='".intval($intEntryId)."'
               AND `field_id`='".intval($intIputfieldId)."'");
    }



    function getContent($intEntryId, $arrInputfield, $arrTranslationStatus)
    {
        global $objDatabase, $_LANGID;

        $intId = intval($arrInputfield['id']);
        $objEntryDefaultLang = $objDatabase->Execute("SELECT `lang_id` FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_entries WHERE id=".intval($intEntryId)." LIMIT 1");
        $intEntryDefaultLang = intval($objEntryDefaultLang->fields['lang_id']);

        if($this->arrSettings['settingsTranslationStatus'] == 1) {
	        if(in_array($_LANGID, $arrTranslationStatus)) {
	        	$intLangId = $_LANGID;
	        } else {
	        	$intLangId = $intEntryDefaultLang;
	        }
        } else {
        	$intLangId = $_LANGID;
        }

        $objInputfieldValue = $objDatabase->Execute("
            SELECT
                `value`
            FROM
                ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_inputfields
            WHERE
                field_id=".$intId."
            AND
                entry_id=".intval($intEntryId)."
            AND
                lang_id=".$intLangId."
            LIMIT 1
        ");

        if(empty($objInputfieldValue->fields['value'])) {
        	$objInputfieldValue = $objDatabase->Execute("
	            SELECT
	                `value`
	            FROM
	                ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_inputfields
	            WHERE
	                field_id=".$intId."
	            AND
	                entry_id=".intval($intEntryId)."
	            AND
	                lang_id=".intval($intEntryDefaultLang)."
	            LIMIT 1
	        ");
        }

        $strValue = strip_tags(htmlspecialchars($objInputfieldValue->fields['value'], ENT_QUOTES, CONTREXX_CHARSET));

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
    	$fieldName = $this->moduleName."Inputfield_";
        $strJavascriptCheck = <<<EOF

            case 'text':
                value = document.getElementById('$fieldName' + field + '_0').value;
                if (value == "" && isRequiredGlobal(inputFields[field][1], value)) {
                	isOk = false;
                	document.getElementById('$fieldName' + field + '_0').style.border = "#ff0000 1px solid";
                } else if (value != "" && !matchType(inputFields[field][2], value)) {
                	isOk = false;
                	document.getElementById('$fieldName' + field + '_0').style.border = "#ff0000 1px solid";
                } else {
                	document.getElementById('$fieldName' + field + '_0').style.borderColor = '';
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
