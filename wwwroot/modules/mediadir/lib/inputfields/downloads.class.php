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
 * Media Directory Inputfield Downloads Class
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
 * Media Directory Inputfield Downloads Class
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_mediadir
 */
class mediaDirectoryInputfieldDownloads extends mediaDirectoryLibrary
{
    public $arrPlaceholders = array('TXT_MEDIADIR_INPUTFIELD_NAME','MEDIADIR_INPUTFIELD_VALUE');



    /**
     * Constructor
     */
    function __construct()
    {
        $this->imagePath = constant('ASCMS_'.$this->moduleConstVar.'_IMAGES_PATH').'/';
        $this->imageWebPath = constant('ASCMS_'.$this->moduleConstVar.'_IMAGES_WEB_PATH').'/';
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
                $arrValue = null;
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
                        $arrParents = null;
                        while (!$objInputfieldValue->EOF) {
                            $strValue = htmlspecialchars($objInputfieldValue->fields['value'], ENT_QUOTES, CONTREXX_CHARSET);
                            $arrParents = explode("||", $strValue);  
                            
                            foreach($arrParents as $intKey => $strChildes) {
                                $arrChildes = array();  
                                $arrChildes = explode("##", $strChildes);
                                
                                $arrValue[intval($objInputfieldValue->fields['lang_id'])][$intKey]['title'] = $arrChildes[0];  
                                $arrValue[intval($objInputfieldValue->fields['lang_id'])][$intKey]['desc'] = $arrChildes[1];   
                                $arrValue[intval($objInputfieldValue->fields['lang_id'])][$intKey]['file'] = $arrChildes[2];      
                                
                                if(!empty($arrChildes[2]) && file_exists(ASCMS_PATH.$arrChildes[2])) {
                                    $arrFileInfo    = pathinfo($arrChildes[2]);
                                    $strFileName    = htmlspecialchars($arrFileInfo['basename'], ENT_QUOTES, CONTREXX_CHARSET);       

                                    $pos = strrpos($arrChildes[2], ".");

                                    if ($pos != false) {
                                        $ext = strtolower(trim(substr($arrChildes[2], $pos)));
                                        $imgExts = array(".gif", ".jpg", ".jpeg", ".png", ".tiff", ".tif"); // this is far from complete but that's always going to be the case...
                                        if (in_array($ext, $imgExts)) {
                                            $strFilePreview = '<img src="'.urldecode($arrChildes[2]).'" />';
                                        } else {
                                            $strFilePreview = '<a href="'.urldecode($arrChildes[2]).'" target="_blank">'.$strFileName.'</a><br />';
                                        }
                                    } else {
                                        $strFilePreview = '<a href="'.urldecode($arrChildes[2]).'" target="_blank">'.$strFileName.'</a><br />';
                                    }
                                } else {
                                    $strFilePreview = null;
                                }
                                
                                $arrValue[intval($objInputfieldValue->fields['lang_id'])][$intKey]['preview'] = $strFilePreview;
                                
                                if(empty($arrChildes[2]) || $arrChildes[2] == "new_file") {
                                    $strValueHidden = "new_file";
                                    $arrChildes[2] = "";
                                } else {
                                    $strValueHidden = $arrChildes[2];
                                }
                                
                                $arrValue[intval($objInputfieldValue->fields['lang_id'])][$intKey]['hidden'] = $strValueHidden;  
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
                
                /*$arrInfoValue = array();
                
                if(!empty($arrInputfield['info'][0])){
                    $arrInfoValue[0] = 'title="'.$arrInputfield['info'][0].'"';
                    foreach($arrInputfield['info'] as $intLangKey => $strInfoValue) {
                        $strInfoClass = 'mediadirInputfieldHint';
                        $arrInfoValue[$intLangKey] = empty($strInfoValue) ? 'title="'.$arrInputfield['info'][0].'"' : 'title="'.$strInfoValue.'"';
                    }
                } else {
                    $arrInfoValue = null;
                    $strInfoClass = '';
                }*/
                   
                $intNextElementId = $intNumElements;   
                
                if($objInit->mode == 'backend') {
                    $strFieldsetStyle = 'border: 1px solid #0A50A1; width: 402px; margin-bottom: 10px; position: relative;';
                    $strLegendStyle = 'color: #0A50A1;';
                    $strInputStyle = 'width: 300px';
                    $strInputFlagStyle = 'width: 279px; margin-bottom: 2px; padding-left: 21px;';
                    $strTextAreaStyle = 'width: 300px; height: 60px;'; 
                    $strTextAreaFlagStyle = 'width: 279px; margin-bottom: 2px; padding-left: 21px;';
                    $strDeleteImagePath = 'images/icons/delete.gif';  
                } else {
                    $strFieldsetStyle = 'margin-bottom: 10px; position: relative;';
                    $strLegendStyle = '';
                    $strInputStyle = ''; 
                    $strInputFlagStyle = '';
                    $strTextAreaStyle = ''; 
                    $strTextAreaFlagStyle = '';
                    $strDeleteImagePath = 'cadmin/images/icons/delete.gif';  
                }                
                
                $strBlankElement =
                    '<fieldset style="'.$strFieldsetStyle.'"  id="'.$this->moduleName.'DownloadsElement_'.$intId.'_ELEMENT-KEY">'.
                    '<img src="'.$strDeleteImagePath.'" onclick="downloadsDeleteElement_'.$intId.'(ELEMENT-KEY);" style="cursor: pointer; position: absolute; top: -7px; right: 10px; z-index: 1000;"/>'.
                    '<legend style="'.$strLegendStyle.'">'.$arrInputfield['name'][0].' #ELEMENT-NR</legend>'.
                    '<div id="'.$this->moduleName.'Inputfield_'.$intId.'_ELEMENT-KEY_Minimized" style="display: block;">'.
                    '<input type="text" name="'.$this->moduleName.'Inputfield['.$intId.'][0][ELEMENT-KEY][title]" id="'.$this->moduleName.'Inputfield_'.$intId.'_ELEMENT-KEY_0_title" value="'.$_ARRAYLANG['TXT_MEDIADIR_TITLE'].'"  style="'.$strInputStyle.'" onfocus="this.select();" />&nbsp;'.
                    $arrLang['name'].
                    '<br />';        
                $strBlankElement .= '<textarea name="'.$this->moduleName.'Inputfield['.$intId.'][0][ELEMENT-KEY][desc]" id="'.$this->moduleName.'Inputfield_'.$intId.'_ELEMENT-KEY_0_title" style="'.$strTextAreaStyle.'" onfocus="this.select();">'.$_CORELANG['TXT_CORE_SETTING_NAME'].'</textarea><br />';    
                
                if($objInit->mode == 'backend') {
                    $strBlankElement .= '<input type="text" name="'.$this->moduleName.'Inputfield['.$intId.'][0][ELEMENT-KEY][file]" id="'.$this->moduleName.'Inputfield_'.$intId.'_ELEMENT-KEY_0_file" style="width: 213px;" onfocus="this.select();" />&nbsp;<input type="button" value="Durchsuchen" onClick="getFileBrowser(\\\''.$this->moduleName.'Inputfield_'.$intId.'_ELEMENT-KEY_0_file\\\', \\\''.$this->moduleName.'\\\', \\\'/uploads\\\')" />';
                } else {
                    $strBlankElement .= '<input type="file" name="fileUpload_'.$intId.'[0][ELEMENT-KEY]" id="'.$this->moduleName.'Inputfield_'.$intId.'_0_ELEMENT-KEY"  onfocus="this.select();" />';
                }
                   
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
                        
                        $strBlankElement .= '<input type="text" name="'.$this->moduleName.'Inputfield['.$intId.']['.$intLangId.'][ELEMENT-KEY][title]" id="'.$this->moduleName.'Inputfield_'.$intId.'_ELEMENT-KEY_'.$intLangId.'_title" value=""  style="'.$strInputFlagStyle.' background: #ffffff url(images/flags/flag_'.$arrLang['lang'].'.gif) no-repeat 3px 3px;" onfocus="this.select();" />&nbsp;'.$arrLang['name'].'<br />';      
                        $strBlankElement .= '<textarea name="'.$this->moduleName.'Inputfield['.$intId.']['.$intLangId.'][ELEMENT-KEY][desc]" id="'.$this->moduleName.'Inputfield_'.$intId.'_ELEMENT-KEY_'.$intLangId.'_title" style="'.$strTextAreaFlagStyle.' background: #ffffff url(images/flags/flag_'.$arrLang['lang'].'.gif) no-repeat 3px 3px;" onfocus="this.select();" /></textarea><br />';
                        
                        if($objInit->mode == 'backend') {
                            $strBlankElement .= '<input type="text" name="'.$this->moduleName.'Inputfield['.$intId.']['.$intLangId.'][ELEMENT-KEY][file]" id="'.$this->moduleName.'Inputfield_'.$intId.'_ELEMENT-KEY_'.$intLangId.'_file" style="width: 192px; margin-bottom: 2px; padding-left: 21px; background: #ffffff url(images/flags/flag_'.$arrLang['lang'].'.gif) no-repeat 3px 3px;" onfocus="this.select();" />&nbsp;<input type="button" value="Durchsuchen" onClick="getFileBrowser(\\\''.$this->moduleName.'Inputfield_'.$intId.'_ELEMENT-KEY_'.$intLangId.'_file\\\', \\\''.$this->moduleName.'\\\', \\\'/uploads\\\')" />'.$minimize.'<br /><br />';
                        } else {
                            $strBlankElement .= '<input type="file" name="fileUpload_'.$intId.'['.$intLangId.'][ELEMENT-KEY]" id="'.$this->moduleName.'Inputfield_'.$intId.'_'.$intLangId.'_ELEMENT-KEY" onfocus="this.select();" />'.$minimize.'<br /><br />';  
                        }
                    }  
                    $strBlankElement .= '</div>';   
                } else {
                    $strBlankElement .= '</div>';  
                }   
                
                $strBlankElement .= '</fieldset>';    
                
                $strElementSetId =  $this->moduleName.'DownloadsElements_'.$intId; 
                $strElementId =  $this->moduleName.'DownloadsElement_'.$intId.'_'; 
                
                $strInputfield = <<< EOF
<script type="text/javascript">
/* <![CDATA[ */                      
  
var nextDownloadId_$intId = $intNextElementId;
var blankDownload_$intId  = '$strBlankElement';

function downloadsAddElement_$intId(){       
    var replace1BlankDownload_$intId = blankDownload_$intId.replace(/ELEMENT-KEY/g, nextDownloadId_$intId);
    var replace2BlankDownload_$intId = replace1BlankDownload_$intId.replace(/ELEMENT-NR/g, nextDownloadId_$intId+1);
                                            
    \$J('#$strElementSetId').append(replace2BlankDownload_$intId);
    \$J('#$strElementId' + nextDownloadId_$intId).css('display', 'none');
    \$J('#$strElementId' + nextDownloadId_$intId).fadeIn("fast");
    
    nextDownloadId_$intId = nextDownloadId_$intId + 1;
}

function downloadsDeleteElement_$intId(key){     
    \$J('#$strElementId'+key).fadeOut("fast", function(){ \$J('#$strElementId'+key).remove();}); 
}

/* ]]> */
</script>

EOF;
                $strInputfield .= '<div class="'.$this->moduleName.'GroupMultilang">';
                $strInputfield .= '<div id="'.$this->moduleName.'DownloadsElements_'.$intId.'">';   
                
                if($objInit->mode == 'backend') {
                    $strFieldsetStyle = 'border: 1px solid #0A50A1; width: 402px; margin-bottom: 10px; position: relative;';
                    $strLegendStyle = 'color: #0A50A1;';
                    $strInputStyle = 'width: 300px';
                    $strInputFlagStyle = 'width: 279px; margin-bottom: 2px; padding-left: 21px;';
                    $strTextAreaStyle = 'width: 300px; height: 60px;'; 
                    $strTextAreaFlagStyle = 'width: 279px; margin-bottom: 2px; padding-left: 21px;';                            
                    $strDeleteImagePath = 'images/icons/delete.gif';  
                } else {
                    $strFieldsetStyle = 'margin-bottom: 10px; position: relative;';
                    $strLegendStyle = '';
                    $strInputStyle = '';                                
                    $strInputFlagStyle = '';
                    $strTextAreaStyle = '';
                    $strTextAreaFlagStyle = ''; 
                    $strDeleteImagePath = 'cadmin/images/icons/delete.gif';  
                }        
                
                for($intKey = 0; $intKey < $intNumElements; $intKey++) {
                    $intNummer = $intKey+1;  
                      
                    $strInputfield .= '<fieldset id="'.$this->moduleName.'DownloadsElement_'.$intId.'_'.$intKey.'" style="'.$strFieldsetStyle.'">';
                    $strInputfield .= '<img src="'.$strDeleteImagePath.'" onclick="downloadsDeleteElement_'.$intId.'('.$intKey.');" style="cursor: pointer; position: absolute; top: -7px; right: 10px; z-index: 1000;"/>'; 
                    $strInputfield .= '<legend style="'.$strLegendStyle.'">'.$arrInputfield['name'][0].' #'.$intNummer.'</legend>';    
                    $strInputfield .= '<div id="'.$this->moduleName.'Inputfield_'.$intId.'_'.$intKey.'_Minimized" style="display: block;">';
                    $strInputfield .= '<input type="text" name="'.$this->moduleName.'Inputfield['.$intId.'][0]['.$intKey.'][title]" id="'.$this->moduleName.'Inputfield_'.$intId.'_'.$intKey.'_0_title" value="'.$arrValue[0][$intKey]['title'].'" style="'.$strInputStyle.'" onfocus="this.select();" /><br />'; 
                    $strInputfield .= '<textarea name="'.$this->moduleName.'Inputfield['.$intId.'][0]['.$intKey.'][desc]" id="'.$this->moduleName.'Inputfield_'.$intId.'_'.$intKey.'_0_title" style="'.$strTextAreaStyle.'" onfocus="this.select();" />'.$arrValue[0][$intKey]['desc'].'</textarea><br />';
                    
                    if($objInit->mode == 'backend') {
                        $strInputfield .= '<input type="text" name="'.$this->moduleName.'Inputfield['.$intId.'][0]['.$intKey.'][file]" value="'.$arrValue[0][$intKey]['file'].'" id="'.$this->moduleName.'Inputfield_'.$intId.'_'.$intKey.'_0_file" style="width: 213px;" onfocus="this.select();" />&nbsp;<input type="button" value="Durchsuchen" onClick="getFileBrowser(\''.$this->moduleName.'Inputfield_'.$intId.'_'.$intKey.'_0_file\', \''.$this->moduleName.'\', \'/uploads\')" />';
                    } else {
                        $strInputfield .= '<input type="file" name="fileUpload_'.$intId.'[0]['.$intKey.']" id="'.$this->moduleName.'Inputfield_'.$intId.'_0_'.$intKey.'" onfocus="this.select();" />';
                        $strInputfield .= '<input id="'.$this->moduleName.'Inputfield_'.$intId.'_0_'.$intKey.'_hidden" name="'.$this->moduleName.'Inputfield['.$intId.'][0]['.$intKey.'][file]" value="'.$arrValue[0][$intKey]['hidden'].'" type="hidden">';
                    }
                    if($this->arrSettings['settingsFrontendUseMultilang'] == 0 && $objInit->mode == 'frontend') {  
                        $strInputfield .= '<br />'.$arrValue[0][$intKey]['preview'];    
                    }
                   
                    if($this->arrSettings['settingsFrontendUseMultilang'] == 1 || $objInit->mode == 'backend') {  
                        $strInputfield .= '&nbsp;<a href="javascript:ExpandMinimizeMultiple('.$intId.', '.$intKey.');">'.$_ARRAYLANG['TXT_MEDIADIR_MORE'].'&nbsp;&raquo;</a><br />';  
                        $strInputfield .= $arrValue[0][$intKey]['preview'];  
                        $strInputfield .= '</div>';  
                                
                        $strInputfield .= '<div id="'.$this->moduleName.'Inputfield_'.$intId.'_'.$intKey.'_Expanded" style="display: none;">';  
                        foreach ($this->arrFrontendLanguages as $key => $arrLang) {
                            $intLangId = $arrLang['id'];

                            if(($key+1) == count($this->arrFrontendLanguages)) {
                                $minimize = "&nbsp;<a href=\"javascript:ExpandMinimizeMultiple(".$intId.", ".$intKey.");\">&laquo;&nbsp;".$_ARRAYLANG['TXT_MEDIADIR_MINIMIZE']."</a>";
                            } else {
                                $minimize = "";
                            }
                            
                            $strInputfield .= '<input type="text" name="'.$this->moduleName.'Inputfield['.$intId.']['.$intLangId.']['.$intKey.'][title]" id="'.$this->moduleName.'Inputfield_'.$intId.'_'.$intKey.'_'.$intLangId.'_title" value="'.$arrValue[$intLangId][$intKey]['title'].'"  style="'.$strInputFlagStyle.' background: #ffffff url(\'images/flags/flag_'.$arrLang['lang'].'.gif\') no-repeat 3px 3px;" onfocus="this.select();" />&nbsp;'.$arrLang['name'].'<br />'; 
                            $strInputfield .= '<textarea name="'.$this->moduleName.'Inputfield['.$intId.']['.$intLangId.']['.$intKey.'][desc]" id="'.$this->moduleName.'Inputfield_'.$intId.'_'.$intKey.'_'.$intLangId.'_title" style="'.$strTextAreaFlagStyle.' background: #ffffff url(\'images/flags/flag_'.$arrLang['lang'].'.gif\') no-repeat 3px 3px;" onfocus="this.select();" />'.$arrValue[$intLangId][$intKey]['desc'].'</textarea><br />';
                        
                            if($objInit->mode == 'backend') {
                                $strInputfield .= '<input type="text" name="'.$this->moduleName.'Inputfield['.$intId.']['.$intLangId.']['.$intKey.'][file]" value="'.$arrValue[$intLangId][$intKey]['file'].'" id="'.$this->moduleName.'Inputfield_'.$intId.'_'.$intKey.'_'.$intLangId.'_file" style="width: 192px; margin-bottom: 2px; padding-left: 21px; background: #ffffff url(images/flags/flag_'.$arrLang['lang'].'.gif) no-repeat 3px 3px;" onfocus="this.select();" />&nbsp;<input type="button" value="Durchsuchen" onClick="getFileBrowser(\''.$this->moduleName.'Inputfield_'.$intId.'_'.$intKey.'_'.$intLangId.'_file\', \''.$this->moduleName.'\', \'/uploads\')" />'.$minimize.'<br />'.$arrValue[$intLangId][$intKey]['preview'].'<br />'; 
                            } else {
                                $strInputfield .= '<input type="file" name="fileUpload_'.$intId.'['.$intLangId.']['.$intKey.']" id="'.$this->moduleName.'Inputfield_'.$intId.'_'.$intLangId.'_'.$intKey.'" value="'.$strValue.'" onfocus="this.select();" />'.$minimize.'<br />'.$arrValue[$intLangId][$intKey]['preview'].'<br />';
                                $strInputfield .= '<input id="'.$this->moduleName.'Inputfield_'.$intId.'_'.$intLangId.'_'.$intKey.'_hidden" name="'.$this->moduleName.'Inputfield['.$intId.']['.$intLangId.']['.$intKey.'][file]" value="'.$arrValue[$intLangId][$intKey]['hidden'].'" type="hidden">';
                            }
                        }  
                        $strBlankElement .= '</div>';   
                    } else {
                        $strBlankElement .= '</div>';  
                    }   
                    
                    $strInputfield .= '<input type="hidden" name="'.$this->moduleName.'Inputfield['.$intId.'][old]['.$intKey.'][title]" value="'.$arrValue[0][$intKey]['title'].'" />';  
                    $strInputfield .= '<input type="hidden" name="'.$this->moduleName.'Inputfield['.$intId.'][old]['.$intKey.'][desc]" value="'.$arrValue[0][$intKey]['desc'].'" />';  
                    $strInputfield .= '<input type="hidden" name="'.$this->moduleName.'Inputfield['.$intId.'][old]['.$intKey.'][file]" value="'.$arrValue[0][$intKey]['file'].'" />';    
                     
                    $strInputfield .= '</div>'; 
                    $strInputfield .= '</fieldset>';      
                }       
                    
                $strInputfield .= '</div>';  
                $strInputfield .= '<input type="button" value="'.$arrInputfield['name'][0].' '.$_ARRAYLANG['TXT_MEDIADIR_ADD'].'" onclick="downloadsAddElement_'.$intId.'();" />'; 
                $strInputfield .= '</div>';                                                                                                                                       
                
                return $strInputfield;

                break;  
            case 2:
                //search View  
                break;
        }
        return null;
    }



    function saveInputfield($intInputfieldId, $arrValue, $intLangId) 
    {         
        global $objInit, $_LANGID;  
        
        $arrValues = array();    
        
        if($objInit->mode == 'backend') {          
            foreach($arrValue as $intKey => $arrValuesTmp) {
                $arrValues[] = join("##", $arrValuesTmp);
            }
        } else {     
            foreach($arrValue as $intKey => $arrValuesTmp) { 
                if ($_FILES['fileUpload_'.$intInputfieldId]['name'][0][$intKey] != ''  && $intLangId == $_LANGID) { 
                    $this->deleteFile($arrValuesTmp['file']);                                                              
                    $arrValuesTmp['file'] = $this->uploadMedia($intInputfieldId, $intKey, 0);  
                }  
                
                if ($_FILES['fileUpload_'.$intInputfieldId]['name'][$intLangId][$intKey] != '') {
                    $this->deleteFile($arrValuesTmp['file']);                                
                    $arrValuesTmp['file'] = $this->uploadMedia($intInputfieldId, $intKey, $intLangId);
                } else {       
                    if($arrValuesTmp['file'] == '' || $arrValuesTmp['file'] == 'new_file') {       
                        $arrValuesTmp['file'] = $this->imageWebPath.'uploads/'.$_FILES['fileUpload_'.$intInputfieldId]['name'][0][$intKey];     
                    }
                }
                
                $arrValues[] = join("##", $arrValuesTmp);          
            }    
        }           
        
        $strValue = contrexx_input2raw(contrexx_strip_tags(join("||", $arrValues)));
        return $strValue;
    }
    
    
    function uploadMedia($intInputfieldId, $intKey, $intLangId)
    {
        global $objDatabase;  
                                                                                      
        if (isset($_FILES)) {     
            $tmpFile   = $_FILES['fileUpload_'.$intInputfieldId]['tmp_name'][$intLangId][$intKey];
            $fileName  = $_FILES['fileUpload_'.$intInputfieldId]['name'][$intLangId][$intKey];
            //$fileType  = $_FILES['fileUpload_'.$intInputfieldId]['type'][$intLangId][$intKey];
            //$fileSize  = $_FILES['fileUpload_'.$intInputfieldId]['size'][$intLangId][$intKey];   
            
            if ($fileName != "") {      
                //get extension
                $arrFileInfo   = pathinfo($fileName);
                $fileExtension = !empty($arrFileInfo['extension']) ? '.'.$arrFileInfo['extension'] : '';
                $fileBasename  = $arrFileInfo['filename'];
                $randomSum      = rand(10, 99);

                //encode filename
                if ($this->arrSettings['settingsEncryptFilenames'] == 1) {
                    $fileName = md5($randomSum.$fileBasename).$fileExtension;
                }

                //check filename
                if (file_exists($this->imagePath.'uploads/'.$fileName)) {            
                    $fileName = $fileBasename.'_'.time().$randomSum.$fileExtension;
                }                                 

                //upload file
                if (move_uploaded_file($tmpFile, $this->imagePath.'uploads/'.$fileName)) {     
                    $objFile = new File();
                    $objFile->setChmod($this->imagePath, $this->imageWebPath, 'uploads/'.$fileName);

                    return $this->imageWebPath.'uploads/'.$fileName;
                } else {
                    return false;
                }
            } else {      
                return false;
            }  
        } else {              
            return false;
        }
    }
    
    
    function deleteFile($strPathFile)
    {
        if(!empty($strPathFile)) {      
            $objFile = new File();
            $arrFileInfo = pathinfo($strPathFile);
            $fileName    = $arrFileInfo['basename'];

            //delete file
            if (file_exists(ASCMS_PATH.$strPathFile)) {
                $objFile->delFile($this->imagePath, $this->imageWebPath, 'uploads/'.$fileName);
            } 
        }
    }
    


    function deleteContent($intEntryId, $intIputfieldId)
    {
        global $objDatabase;

        return (boolean)$objDatabase->Execute("
            DELETE FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_inputfields
             WHERE `entry_id`='".intval($intEntryId)."'
               AND  `field_id`='".intval($intIputfieldId)."'");
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
            
            foreach($arrParents as $strChildes) {
                $arrChildes = array();  
                $arrChildes = explode("##", $strChildes);    
                
                $strTitle = '<span class="'.$this->moduleName.'DownloadTitle">'.$arrChildes[0].'</span>';
                $strDesc = '<span class="'.$this->moduleName.'DownloadDescription">'.$arrChildes[1].'</span>'; 
                $arrFileInfo    = pathinfo($arrChildes[2]);
                $strFileName    = htmlspecialchars($arrFileInfo['basename'], ENT_QUOTES, CONTREXX_CHARSET);
                $strFile = '<span class="'.$this->moduleName.'DownloadFile"><a href="'.$arrChildes[2].'">'.$strFileName.'</a></span>';                                                                                  
                
                $strValue .= '<div class="'.$this->moduleName.'Download">'.$strTitle.$strDesc.$strFile.'</div>';
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
        //$fieldName = $this->moduleName."Inputfield_";
        $strJavascriptCheck = <<<EOF

            case 'downloads':  
                break;

EOF;
        return $strJavascriptCheck;
    }
    
    
    function getFormOnSubmit($intInputfieldId)
    {
        return null;
    }
}
