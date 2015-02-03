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
 * Media Directory Inputfield Responsibles Class
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
 * Media Directory Inputfield Responsibles Class
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_mediadir
 */
class mediaDirectoryInputfieldResponsibles extends mediaDirectoryLibrary
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
        global $objDatabase, $_LANGID, $objInit, $_ARRAYLANG, $_CORELANG;

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
                            $strValue = htmlspecialchars($objInputfieldValue->fields['value'], ENT_QUOTES, CONTREXX_CHARSET);
                            $arrParents = array();
                            $arrParents = explode("||", $strValue);  
                            
                            foreach($arrParents as $intKey => $strChildes) {
                                $arrChildes = array();  
                                $arrChildes = explode("##", $strChildes);                        
                                
                                $arrValue[intval($objInputfieldValue->fields['lang_id'])][$intKey]['firstname'] = $arrChildes[0];  
                                $arrValue[intval($objInputfieldValue->fields['lang_id'])][$intKey]['lastname'] = $arrChildes[1];  
                                $arrValue[intval($objInputfieldValue->fields['lang_id'])][$intKey]['function'] = $arrChildes[2];  
                                $arrValue[intval($objInputfieldValue->fields['lang_id'])][$intKey]['phone'] = $arrChildes[3];  
                                $arrValue[intval($objInputfieldValue->fields['lang_id'])][$intKey]['fax'] = $arrChildes[4];  
                                $arrValue[intval($objInputfieldValue->fields['lang_id'])][$intKey]['mail'] = $arrChildes[5];  
                            } 
                                                                                                                 
                            $objInputfieldValue->MoveNext();
                        }     
                        $arrValue[0] = $arrValue[$_LANGID];                                                           
                        $intNumElements = count($arrParents);
                    }    
                } else {
                    $arrValue = null;
                    $intNumElements = 0;
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
                   
                $intNextElementId = $intNumElements;   
                
                if($objInit->mode == 'backend') {
                    $strFieldsetStyle = 'border: 1px solid #0A50A1; width: 402px; margin-bottom: 10px; position: relative;';
                    $strLegendStyle = 'color: #0A50A1;';
                    $strInputStyle = 'width: 300px';
                    $strInputFlagStyle = 'width: 279px; margin-bottom: 2px; padding-left: 21px;';
                    $strDeleteImagePath = 'images/icons/delete.gif';  
                } else {
                    $strFieldsetStyle = 'margin-bottom: 10px; position: relative;';
                    $strLegendStyle = '';
                    $strInputStyle = ''; 
                    $strInputFlagStyle = '';
                    $strDeleteImagePath = 'cadmin/images/icons/delete.gif';  
                }                
                
                $strBlankElement .= '<fieldset style="'.$strFieldsetStyle.'"  id="'.$this->moduleName.'ResponsiblesElement_'.$intId.'_ELEMENT-KEY">';   
                $strBlankElement .= '<img src="'.$strDeleteImagePath.'" onclick="responsiblesDeleteElement_'.$intId.'(ELEMENT-KEY);" style="cursor: pointer; position: absolute; top: -7px; right: 10px; z-index: 1000;"/>';  
                $strBlankElement .= '<legend style="'.$strLegendStyle.'">'.$arrInputfield['name'][0].' #ELEMENT-NR</legend>';        
                $strBlankElement .= '<div id="'.$this->moduleName.'Inputfield_'.$intId.'_ELEMENT-KEY_Minimized" style="display: block;">';                                                                                                                                                                           
                $strBlankElement .= '<input type="text" name="'.$this->moduleName.'Inputfield['.$intId.'][0][ELEMENT-KEY][firstname]" id="'.$this->moduleName.'Inputfield_'.$intId.'_ELEMENT-KEY_0_firstname" value="'.$_CORELANG['TXT_ACCESS_FIRSTNAME'].'"  style="'.$strInputStyle.'" onfocus="this.select();" />&nbsp;'.$arrLang['name'].'<br />'; 
                $strBlankElement .= '<input type="text" name="'.$this->moduleName.'Inputfield['.$intId.'][0][ELEMENT-KEY][lastname]" id="'.$this->moduleName.'Inputfield_'.$intId.'_ELEMENT-KEY_0_lastname" value="'.$_CORELANG['TXT_ACCESS_LASTNAME'].'"  style="'.$strInputStyle.'" onfocus="this.select();" /><br />';  
                $strBlankElement .= '<input type="text" name="'.$this->moduleName.'Inputfield['.$intId.'][0][ELEMENT-KEY][function]" id="'.$this->moduleName.'Inputfield_'.$intId.'_ELEMENT-KEY_0_function" value="'.$_ARRAYLANG['TXT_MEDIADIR_FUNCTION'].'"  style="'.$strInputStyle.'" onfocus="this.select();" /><br />';  
                $strBlankElement .= '<input type="text" name="'.$this->moduleName.'Inputfield['.$intId.'][0][ELEMENT-KEY][phone]" id="'.$this->moduleName.'Inputfield_'.$intId.'_ELEMENT-KEY_0_phone" value="'.$_ARRAYLANG['TXT_MEDIADIR_PHONE'].'"  style="'.$strInputStyle.'" onfocus="this.select();" /><br />';   
                $strBlankElement .= '<input type="text" name="'.$this->moduleName.'Inputfield['.$intId.'][0][ELEMENT-KEY][fax]" id="'.$this->moduleName.'Inputfield_'.$intId.'_ELEMENT-KEY_0_fax" value="'.$_ARRAYLANG['TXT_MEDIADIR_FAX'].'"  style="'.$strInputStyle.'" onfocus="this.select();" /><br />';  
                $strBlankElement .= '<input type="text" name="'.$this->moduleName.'Inputfield['.$intId.'][0][ELEMENT-KEY][mail]" id="'.$this->moduleName.'Inputfield_'.$intId.'_ELEMENT-KEY_0_mail" value="'.$_CORELANG['TXT_EMAIL'].'"  style="'.$strInputStyle.'" onfocus="this.select();" />';     
          
                if($this->arrSettings['settingsFrontendUseMultilang'] == 1 || $objInit->mode == 'backend') {  
                    $strBlankElement .= '&nbsp;<a href="javascript:ExpandMinimizeMultiple('.$intId.', ELEMENT-KEY);">'.$_ARRAYLANG['TXT_MEDIADIR_MORE'].'&nbsp;&raquo;</a>';  
                    $strBlankElement .= '</div>';  
                    
                    $strBlankElement .= '<div id="'.$this->moduleName.'Inputfield_'.$intId.'_ELEMENT-KEY_Expanded" style="display: none;">';  
                    foreach ($this->arrFrontendLanguages as $key => $arrLang) {
                        $intLangId = $arrLang['id'];

                        if(($key+1) == count($this->arrFrontendLanguages)) {
                            $minimize = "&nbsp;<a href=\"javascript:ExpandMinimizeMultiple(".$intId.", ELEMENT-KEY);\">&laquo;&nbsp;".$_ARRAYLANG['TXT_MEDIADIR_MINIMIZE']."</a>";
                        } else {
                            $minimize = "";
                        }
                        
                        $strBlankElement .= '<input type="text" name="'.$this->moduleName.'Inputfield['.$intId.']['.$intLangId.'][ELEMENT-KEY][firstname]" id="'.$this->moduleName.'Inputfield_'.$intId.'_ELEMENT-KEY_'.$intLangId.'_firstname" value=""  style="'.$strInputFlagStyle.' background: #ffffff url(images/flags/flag_'.$arrLang['lang'].'.gif) no-repeat 3px 3px;" onfocus="this.select();" />&nbsp;'.$arrLang['name'].'<br />'; 
                        $strBlankElement .= '<input type="text" name="'.$this->moduleName.'Inputfield['.$intId.']['.$intLangId.'][ELEMENT-KEY][lastname]" id="'.$this->moduleName.'Inputfield_'.$intId.'_ELEMENT-KEY_'.$intLangId.'_lastname" value=""  style="'.$strInputFlagStyle.' background: #ffffff url(images/flags/flag_'.$arrLang['lang'].'.gif) no-repeat 3px 3px;" onfocus="this.select();" /><br />';  
                        $strBlankElement .= '<input type="text" name="'.$this->moduleName.'Inputfield['.$intId.']['.$intLangId.'][ELEMENT-KEY][function]" id="'.$this->moduleName.'Inputfield_'.$intId.'_ELEMENT-KEY_'.$intLangId.'_function" value=""  style="'.$strInputFlagStyle.' background: #ffffff url(images/flags/flag_'.$arrLang['lang'].'.gif) no-repeat 3px 3px;" onfocus="this.select();" /><br />';  
                        $strBlankElement .= '<input type="text" name="'.$this->moduleName.'Inputfield['.$intId.']['.$intLangId.'][ELEMENT-KEY][phone]" id="'.$this->moduleName.'Inputfield_'.$intId.'_ELEMENT-KEY_'.$intLangId.'_phone" value=""  style="'.$strInputFlagStyle.' background: #ffffff url(images/flags/flag_'.$arrLang['lang'].'.gif) no-repeat 3px 3px;" onfocus="this.select();" /><br />';   
                        $strBlankElement .= '<input type="text" name="'.$this->moduleName.'Inputfield['.$intId.']['.$intLangId.'][ELEMENT-KEY][fax]" id="'.$this->moduleName.'Inputfield_'.$intId.'_ELEMENT-KEY_'.$intLangId.'_fax" value=""  style="'.$strInputFlagStyle.' background: #ffffff url(images/flags/flag_'.$arrLang['lang'].'.gif) no-repeat 3px 3px;" onfocus="this.select();" /><br />';  
                        $strBlankElement .= '<input type="text" name="'.$this->moduleName.'Inputfield['.$intId.']['.$intLangId.'][ELEMENT-KEY][mail]" id="'.$this->moduleName.'Inputfield_'.$intId.'_ELEMENT-KEY_'.$intLangId.'_mail" value=""  style="'.$strInputFlagStyle.' background: #ffffff url(images/flags/flag_'.$arrLang['lang'].'.gif) no-repeat 3px 3px;" onfocus="this.select();" />'.$minimize.'<br /><br />';   
                    }  
                    $strBlankElement .= '</div>';   
                } else {
                    $strBlankElement .= '</div>';  
                }   
                
                $strBlankElement .= '</fieldset>';    
                
                $strElementSetId =  $this->moduleName.'ResponsiblesElements_'.$intId; 
                $strElementId =  $this->moduleName.'ResponsiblesElement_'.$intId.'_'; 
                
                $strInputfield = <<< EOF
<script type="text/javascript">
/* <![CDATA[ */                      
  
var nextResponsibleId = $intNextElementId;
var blankResponsible  = '$strBlankElement';     

function responsiblesAddElement_$intId(){       
                                            
    var blankResponsibleReplace1 = blankResponsible.replace(/ELEMENT-KEY/g, nextResponsibleId);    
    var blankResponsibleReplace2 = blankResponsibleReplace1.replace(/ELEMENT-NR/g, nextResponsibleId+1);    
    
    \$J('#$strElementSetId').append(blankResponsibleReplace2);     
    \$J('#$strElementId' + nextResponsibleId).css('display', 'none');
    \$J('#$strElementId' + nextResponsibleId).fadeIn("fast");               
    
    nextResponsibleId = nextResponsibleId + 1; 
}

function responsiblesDeleteElement_$intId(key){     
    \$J('#$strElementId'+key).fadeOut("fast", function(){ \$J('#$strElementId'+key).remove();}); 
}

/* ]]> */
</script>

EOF;
                $strInputfield .= '<div class="'.$this->moduleName.'GroupMultilang">';
                $strInputfield .= '<div id="'.$this->moduleName.'ResponsiblesElements_'.$intId.'">';   
                
                if($objInit->mode == 'backend') {
                    $strFieldsetStyle = 'border: 1px solid #0A50A1; width: 402px; margin-bottom: 10px; position: relative;';
                    $strLegendStyle = 'color: #0A50A1;';
                    $strInputStyle = 'width: 300px';
                    $strInputFlagStyle = 'width: 279px; margin-bottom: 2px; padding-left: 21px; position: relative;';
                    $strDeleteImagePath = 'images/icons/delete.gif';  
                } else {
                    $strFieldsetStyle = 'margin-bottom: 10px; position: relative;';
                    $strLegendStyle = '';
                    $strInputStyle = ''; 
                    $strInputFlagStyle = '';
                    $strDeleteImagePath = 'cadmin/images/icons/delete.gif';  
                }        
                
                for($intKey = 0; $intKey < $intNumElements; $intKey++) {
                    $intNummer = $intKey+1;  
                      
                    $strInputfield .= '<fieldset id="'.$this->moduleName.'ResponsiblesElement_'.$intId.'_'.$intKey.'" style="'.$strFieldsetStyle.'">';         
                    $strInputfield .= '<img src="'.$strDeleteImagePath.'" onclick="responsiblesDeleteElement_'.$intId.'('.$intKey.');" style="cursor: pointer; position: absolute; top: -7px; right: 10px; z-index: 1000;"/>'; 
                    $strInputfield .= '<legend style="'.$strLegendStyle.'">'.$arrInputfield['name'][0].' #'.$intNummer.'</legend>';    
                    $strInputfield .= '<div id="'.$this->moduleName.'Inputfield_'.$intId.'_'.$intKey.'_Minimized" style="display: block;">';
                    $strInputfield .= '<input type="text" name="'.$this->moduleName.'Inputfield['.$intId.'][0]['.$intKey.'][\'firstname\']" id="'.$this->moduleName.'Inputfield_'.$intId.'_'.$intKey.'_0_firstname" value="'.$arrValue[0][$intKey]['firstname'].'" style="'.$strInputStyle.'" onfocus="this.select();" /><br />'; 
                    $strInputfield .= '<input type="text" name="'.$this->moduleName.'Inputfield['.$intId.'][0]['.$intKey.'][\'lastname\']" id="'.$this->moduleName.'Inputfield_'.$intId.'_'.$intKey.'_0_lastname" value="'.$arrValue[0][$intKey]['lastname'].'" style="'.$strInputStyle.'" onfocus="this.select();" /><br />';  
                    $strInputfield .= '<input type="text" name="'.$this->moduleName.'Inputfield['.$intId.'][0]['.$intKey.'][\'function\']" id="'.$this->moduleName.'Inputfield_'.$intId.'_'.$intKey.'_0_function" value="'.$arrValue[0][$intKey]['function'].'" style="'.$strInputStyle.'" onfocus="this.select();" /><br />';  
                    $strInputfield .= '<input type="text" name="'.$this->moduleName.'Inputfield['.$intId.'][0]['.$intKey.'][\'phone\']" id="'.$this->moduleName.'Inputfield_'.$intId.'_'.$intKey.'_0_phone" value="'.$arrValue[0][$intKey]['phone'].'" style="'.$strInputStyle.'" onfocus="this.select();" /><br />';   
                    $strInputfield .= '<input type="text" name="'.$this->moduleName.'Inputfield['.$intId.'][0]['.$intKey.'][\'fax\']" id="'.$this->moduleName.'Inputfield_'.$intId.'_'.$intKey.'_0_fax" value="'.$arrValue[0][$intKey]['fax'].'" style="'.$strInputStyle.'" onfocus="this.select();" /><br />';  
                    $strInputfield .= '<input type="text" name="'.$this->moduleName.'Inputfield['.$intId.'][0]['.$intKey.'][\'mail\']" id="'.$this->moduleName.'Inputfield_'.$intId.'_'.$intKey.'_0_mail" value="'.$arrValue[0][$intKey]['mail'].'" style="'.$strInputStyle.'" onfocus="this.select();" />';  
                    
                    if($this->arrSettings['settingsFrontendUseMultilang'] == 1 || $objInit->mode == 'backend') {  
                        $strInputfield .= '&nbsp;<a href="javascript:ExpandMinimizeMultiple('.$intId.', '.$intKey.');">'.$_ARRAYLANG['TXT_MEDIADIR_MORE'].'&nbsp;&raquo;</a>';  
                        $strInputfield .= '</div>';  
                                
                        $strInputfield .= '<div id="'.$this->moduleName.'Inputfield_'.$intId.'_'.$intKey.'_Expanded" style="display: none;">';  
                        foreach ($this->arrFrontendLanguages as $key => $arrLang) {
                            $intLangId = $arrLang['id'];

                            if(($key+1) == count($this->arrFrontendLanguages)) {
                                $minimize = "&nbsp;<a href=\"javascript:ExpandMinimizeMultiple(".$intId.", ".$intKey.");\">&laquo;&nbsp;".$_ARRAYLANG['TXT_MEDIADIR_MINIMIZE']."</a>";
                            } else {
                                $minimize = "";
                            }
                            
                            $strInputfield .= '<input type="text" name="'.$this->moduleName.'Inputfield['.$intId.']['.$intLangId.']['.$intKey.'][\'firstname\']" id="'.$this->moduleName.'Inputfield_'.$intId.'_'.$intKey.'_'.$intLangId.'_firstname" value="'.$arrValue[$intLangId][$intKey]['firstname'].'"  style="'.$strInputFlagStyle.' background: #ffffff url(\'images/flags/flag_'.$arrLang['lang'].'.gif\') no-repeat 3px 3px;" onfocus="this.select();" />&nbsp;'.$arrLang['name'].'<br />'; 
                            $strInputfield .= '<input type="text" name="'.$this->moduleName.'Inputfield['.$intId.']['.$intLangId.']['.$intKey.'][\'lastname\']" id="'.$this->moduleName.'Inputfield_'.$intId.'_'.$intKey.'_'.$intLangId.'_lastname" value="'.$arrValue[$intLangId][$intKey]['lastname'].'"  style="'.$strInputFlagStyle.' background: #ffffff url(\'images/flags/flag_'.$arrLang['lang'].'.gif\') no-repeat 3px 3px;" onfocus="this.select();" /><br />';  
                            $strInputfield .= '<input type="text" name="'.$this->moduleName.'Inputfield['.$intId.']['.$intLangId.']['.$intKey.'][\'function\']" id="'.$this->moduleName.'Inputfield_'.$intId.'_'.$intKey.'_'.$intLangId.'_function" value="'.$arrValue[$intLangId][$intKey]['function'].'"  style="'.$strInputFlagStyle.' background: #ffffff url(\'images/flags/flag_'.$arrLang['lang'].'.gif\') no-repeat 3px 3px;" onfocus="this.select();" /><br />';  
                            $strInputfield .= '<input type="text" name="'.$this->moduleName.'Inputfield['.$intId.']['.$intLangId.']['.$intKey.'][\'phone\']" id="'.$this->moduleName.'Inputfield_'.$intId.'_'.$intKey.'_'.$intLangId.'_phone" value="'.$arrValue[$intLangId][$intKey]['phone'].'"  style="'.$strInputFlagStyle.' background: #ffffff url(\'images/flags/flag_'.$arrLang['lang'].'.gif\') no-repeat 3px 3px;" onfocus="this.select();" /><br />';   
                            $strInputfield .= '<input type="text" name="'.$this->moduleName.'Inputfield['.$intId.']['.$intLangId.']['.$intKey.'][\'fax\']" id="'.$this->moduleName.'Inputfield_'.$intId.'_'.$intKey.'_'.$intLangId.'_fax" value="'.$arrValue[$intLangId][$intKey]['fax'].'"  style="'.$strInputFlagStyle.' background: #ffffff url(\'images/flags/flag_'.$arrLang['lang'].'.gif\') no-repeat 3px 3px;" onfocus="this.select();" /><br />';  
                            $strInputfield .= '<input type="text" name="'.$this->moduleName.'Inputfield['.$intId.']['.$intLangId.']['.$intKey.'][\'mail\']" id="'.$this->moduleName.'Inputfield_'.$intId.'_'.$intKey.'_'.$intLangId.'_mail" value="'.$arrValue[$intLangId][$intKey]['mail'].'"  style="'.$strInputFlagStyle.' background: #ffffff url(\'images/flags/flag_'.$arrLang['lang'].'.gif\') no-repeat 3px 3px;" onfocus="this.select();" />'.$minimize.'<br /><br />';   
                        }  
                        $strBlankElement .= '</div>';   
                    } else {
                        $strBlankElement .= '</div>';  
                    }   
                    
                    $strInputfield .= '<input type="hidden" name="'.$this->moduleName.'Inputfield['.$intId.'][old]['.$intKey.'][\'firstname\']" value="'.$arrValue[0][$intKey]['firstname'].'" />';  
                    $strInputfield .= '<input type="hidden" name="'.$this->moduleName.'Inputfield['.$intId.'][old]['.$intKey.'][\'lastname\']" value="'.$arrValue[0][$intKey]['lastname'].'" />';  
                    $strInputfield .= '<input type="hidden" name="'.$this->moduleName.'Inputfield['.$intId.'][old]['.$intKey.'][\'function\']" value="'.$arrValue[0][$intKey]['function'].'" />';  
                    $strInputfield .= '<input type="hidden" name="'.$this->moduleName.'Inputfield['.$intId.'][old]['.$intKey.'][\'phone\']" value="'.$arrValue[0][$intKey]['phone'].'" />';  
                    $strInputfield .= '<input type="hidden" name="'.$this->moduleName.'Inputfield['.$intId.'][old]['.$intKey.'][\'fax\']" value="'.$arrValue[0][$intKey]['fax'].'" />';  
                    $strInputfield .= '<input type="hidden" name="'.$this->moduleName.'Inputfield['.$intId.'][old]['.$intKey.'][\'mail\']" value="'.$arrValue[0][$intKey]['mail'].'" />'; 
                     
                    $strInputfield .= '</div>'; 
                    $strInputfield .= '</fieldset>';      
                }       
                    
                $strInputfield .= '</div>';  
                $strInputfield .= '<input type="button" value="'.$arrInputfield['name'][0].' '.$_ARRAYLANG['TXT_MEDIADIR_ADD'].'" onclick="responsiblesAddElement_'.$intId.'();" />'; 
                $strInputfield .= '</div>';                                                                                                                                       
                
                return $strInputfield;

                break;  
            case 2:
                //search View  
                break;
        }
    }



    function saveInputfield($intInputfieldId, $arrValue, $intLangId) 
    {         
        $arrValues = array();
        
        foreach($arrValue as $intKey => $arrValuesTmp) {
            $arrValues[] = join("##", $arrValuesTmp);
        }
                 
        $strValue = contrexx_strip_tags(contrexx_input2raw(join("||", $arrValues)));
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
        global $objDatabase, $_LANGID, $_ARRAYLANG;

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
            $arrParents = array();
            $arrParents = explode("||", $strValue); 
            $strValue = null;      
            
            foreach($arrParents as $intKey => $strChildes) {
                $arrChildes = array();  
                $arrChildes = explode("##", $strChildes);    
                
                $strName = '<span class="'.$this->moduleName.'ResponsibleName">'.$arrChildes[0].' '.$arrChildes[1].'</span>';
                $strFunction = '<span class="'.$this->moduleName.'ResponsibleFunction">'.$arrChildes[2].'</span>'; 
                $strPhone = '<span class="'.$this->moduleName.'ResponsiblePhone">'.$_ARRAYLANG['TXT_MEDIADIR_PHONE'].': '.$arrChildes[3].'</span>'; 
                $strFax = '<span class="'.$this->moduleName.'ResponsibleFax">'.$_ARRAYLANG['TXT_MEDIADIR_FAX'].': '.$arrChildes[4].'</span>';   
                $strMail = '<span class="'.$this->moduleName.'ResponsibleMail"><a href="mailto:'.$arrChildes[5].'">'.$arrChildes[5].'</a></span>';                                         
                
                $strValue .= '<div class="'.$this->moduleName.'Responsible">'.$strName.$strFunction.$strPhone.$strFax.$strMail.'</div>';
            }   
            
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

            case 'responsibles':  
                break;

EOF;
        return $strJavascriptCheck;
    }
    
    
    function getFormOnSubmit($intInputfieldId)
    {
        return null;
    }
}
