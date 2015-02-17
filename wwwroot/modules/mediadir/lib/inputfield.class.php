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
 * Media  Directory Inputfield Class
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Comvation Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_mediadir
 * @todo        Edit PHP DocBlocks!
 */

/*function loadInputfieldClasses($strClassName) {
    $strClassFileName = strtolower(str_replace('mediaDirectoryInputfield', '', $strClassName));

    if(!file_exists(ASCMS_MODULE_PATH . '/mediadir/lib/inputfields/'.$strClassFileName.'.class.php')) {
        throw new Exception(ASCMS_MODULE_PATH . '/mediadir/lib/inputfields/'.$strClassFileName.'.class.php not found!<br />');
    } else {
        return require_once(ASCMS_MODULE_PATH . '/mediadir/lib/inputfields/'.$strClassFileName.'.class.php');
    }
}

spl_autoload_register('loadInputfieldClasses');*/

function safeNew($strClassName) {

    return new $strClassName;
}

/**
 * Media Directory Inputfield Class
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_mediadir
 */
class mediaDirectoryInputfield extends mediaDirectoryLibrary
{
    public $arrInputfields = array();

    public $strOkMessage;
    public $strErrMessage;

    public $intFormId;
    public $bolExpSearch;

    private $strJavascriptInputfieldArray;
    private $strJavascriptInputfieldCheck = array();
    private $arrTranslationStatus = array();

    public $arrJavascriptFormOnSubmit = array();

    /**
     * Constructor
     */
    function __construct($intFormId=null, $bolExpSearch=false, $arrTranslationStatus=null)
    {
        //get active frontent languages
        parent::getFrontendLanguages();
        parent::getSettings();
        $this->intFormId = intval($intFormId);
        $this->bolExpSearch = $bolExpSearch;
        $this->arrTranslationStatus = $arrTranslationStatus;
        $this->arrInputfields = self::getInputfields();
    }

    function getInputfields()
    {
        global $_ARRAYLANG, $_CORELANG, $objDatabase, $_LANGID, $objInit;

        if(intval($this->intFormId)!=0) {
            $whereFormId = "AND (input.form='".$this->intFormId."')";
        } else {
            $whereFormId = null;
        }

        if($this->bolExpSearch) {
            $whereExpSearch = "AND (input.search='1')";
        } else {
            $whereExpSearch = null;
        }

        $objInputfields = $objDatabase->Execute("
            SELECT
                input.`id` AS `id`,
                input.`order` AS `order`,
                input.`form` AS `form`,
                input.`type` AS `type`,
                input.`show_in` AS `show_in`,
                input.`verification` AS `verification`,
                input.`required` AS `required`,
                input.`search` AS `search`,
                input.`context_type` AS `context_type`,
                names.`field_name` AS `field_name`,
                names.`field_default_value` AS `field_default_value`,
                names.`field_info` AS `field_info`,
                verifications.`regex` AS `pattern`,
                types.`name` AS `type_name`,
                types.`multi_lang` AS `type_multi_lang`,
                types.`dynamic` AS `type_dynamic`
            FROM
                ".DBPREFIX."module_".$this->moduleTablePrefix."_inputfields AS input,
                ".DBPREFIX."module_".$this->moduleTablePrefix."_inputfield_names AS names,
                ".DBPREFIX."module_".$this->moduleTablePrefix."_inputfield_verifications AS verifications,
                ".DBPREFIX."module_".$this->moduleTablePrefix."_inputfield_types AS types
            WHERE
                (names.field_id=input.id)
            AND
                (input.verification=verifications.id)
            AND
                (input.type=types.id)
                ".$whereFormId."
                ".$whereExpSearch."
            AND
                (names.lang_id='".$_LANGID."')
            ORDER BY
                input.`order` ASC, input.`id` ASC
        ");

        if ($objInputfields !== false) {
            while (!$objInputfields->EOF) {
                $arrInputfield = array();
                $arrInputfieldName = array();
                $arrInputfieldDefaultValue = array();

                //get default lang attributes
                $arrInputfieldName[0] = $objInputfields->fields['field_name'];
                $arrInputfieldDefaultValue[0] = $objInputfields->fields['field_default_value'];
                $arrInputfieldInfo[0] = $objInputfields->fields['field_info'];

                $objInputfieldAttributes = $objDatabase->Execute("
                    SELECT
                        `lang_id`,
                        `field_name`,
                        `field_default_value`,
                        `field_info`
                    FROM
                        ".DBPREFIX."module_".$this->moduleTablePrefix."_inputfield_names
                    WHERE
                        field_id=".$objInputfields->fields['id']."
                ");

                if ($objInputfieldAttributes !== false) {
                    while (!$objInputfieldAttributes->EOF) {
                        $arrInputfieldName[$objInputfieldAttributes->fields['lang_id']] = htmlspecialchars($objInputfieldAttributes->fields['field_name'], ENT_QUOTES, CONTREXX_CHARSET);
                        $arrInputfieldDefaultValue[$objInputfieldAttributes->fields['lang_id']] = $objInputfieldAttributes->fields['field_default_value'];
                        $arrInputfieldInfo[$objInputfieldAttributes->fields['lang_id']] = $objInputfieldAttributes->fields['field_info'];

                        $objInputfieldAttributes->MoveNext();
                    }
                }

                $arrInputfield['id'] = intval($objInputfields->fields['id']);
                $arrInputfield['order'] = intval($objInputfields->fields['order']);
                $arrInputfield['form'] = intval($objInputfields->fields['form']);
                $arrInputfield['type'] = intval($objInputfields->fields['type']);
                $arrInputfield['type_name'] = htmlspecialchars($objInputfields->fields['type_name'], ENT_QUOTES, CONTREXX_CHARSET);
                $arrInputfield['type_multi_lang'] = intval($objInputfields->fields['type_multi_lang']);
                $arrInputfield['type_dynamic'] = intval($objInputfields->fields['type_dynamic']);
                $arrInputfield['show_in'] = intval($objInputfields->fields['show_in']);
                $arrInputfield['verification'] = intval($objInputfields->fields['verification']);
                $arrInputfield['regex'] = $objInputfields->fields['pattern'];
                $arrInputfield['required'] = intval($objInputfields->fields['required']);
                $arrInputfield['search'] = intval($objInputfields->fields['search']);
                $arrInputfield['name'] = $arrInputfieldName;
                $arrInputfield['default_value'] = $arrInputfieldDefaultValue;
                $arrInputfield['info'] = $arrInputfieldInfo;
                $arrInputfield['context_type'] = $objInputfields->fields['context_type'];

                $arrInputfields[$objInputfields->fields['id']] = $arrInputfield;
                $objInputfields->MoveNext();
            }
        }

        $arrCategorySelector['id'] = 1;
        $arrCategorySelector['order'] = $this->arrSettings['categorySelectorOrder'][$this->intFormId];
        $arrCategorySelector['name'][0] = $_ARRAYLANG['TXT_MEDIADIR_CATEGORIES'];
        $arrCategorySelector['type_name'] = '';
        $arrCategorySelector['required'] = 1;
        $arrCategorySelector['type'] = 0;
        $arrCategorySelector['search'] = $this->arrSettings['categorySelectorExpSearch'][$this->intFormId];
        $arrInputfields[1] = $arrCategorySelector;

        if($this->arrSettings['settingsShowLevels']) {
            $arrLevelSelector['id'] = 2;
            $arrLevelSelector['order'] = $this->arrSettings['levelSelectorOrder'][$this->intFormId];
            $arrLevelSelector['name'][0] = $_ARRAYLANG['TXT_MEDIADIR_LEVELS'];
            $arrLevelSelector['type_name'] = '';
            $arrLevelSelector['required'] = 1;
            $arrLevelSelector['type'] = 0;
            $arrLevelSelector['search'] = $this->arrSettings['levelSelectorExpSearch'][$this->intFormId];
            $arrInputfields[2] = $arrLevelSelector;
        }

        return $arrInputfields;
    }



    function sortInputfields($a, $b)
    {
        if ($a['order'] == $b['order']) {
	        return ($a['id'] < $b['id']) ? -1 : 1;
	    }
	    return ($a['order'] < $b['order']) ? -1 : 1;
    }



    function listInputfields($objTpl, $intView, $intEntryId)
    {
        global $_ARRAYLANG, $_CORELANG, $objDatabase, $_LANGID, $objInit;

        usort($this->arrInputfields, array(__CLASS__, "sortInputfields"));

        switch ($intView) {
            case 1:
                //Settings View
                $objTpl->addBlockfile($this->moduleLangVar.'_SETTINGS_INPUTFIELDS_CONTENT', 'settings_inputfields_content', 'module_'.$this->moduleName.'_settings_inputfields.html');

                $objForms = new mediaDirectoryForm($this->intFormId);

                $arrShow = array(
                    1 => $_ARRAYLANG['TXT_MEDIADIR_SHOW_BACK_N_FRONTEND'],
                    2 => $_ARRAYLANG['TXT_MEDIADIR_SHOW_FRONTEND'],
                    3 => $_ARRAYLANG['TXT_MEDIADIR_SHOW_BACKEND'],
                );

                foreach ($this->arrInputfields as $key => $arrInputfield) {
                    $strMustfield = $arrInputfield['required']==1 ? 'checked="checked"' : '';
                    $strExpSearch = $arrInputfield['search']==1 ? 'checked="checked"' : '';

                    if($arrInputfield['id'] > $intLastId) {
                        $intLastId = $arrInputfield['id'];
                    }

                    $objTpl->setGlobalVariable(array(
                        $this->moduleLangVar.'_SETTINGS_INPUTFIELD_ROW_CLASS' => $i%2==0 ? 'row1' : 'row2',
                        $this->moduleLangVar.'_SETTINGS_INPUTFIELD_LASTID' => $intLastId,
                    ));

                    if($arrInputfield['id'] != 1 && $arrInputfield['id'] != 2) {
                        $objTpl->setGlobalVariable(array(
                            $this->moduleLangVar.'_SETTINGS_INPUTFIELD_ID' => $arrInputfield['id'],
                            $this->moduleLangVar.'_SETTINGS_INPUTFIELD_FORM_ID' => $this->intFormId,
                            $this->moduleLangVar.'_SETTINGS_INPUTFIELD_ORDER' => $arrInputfield['order'],
                            $this->moduleLangVar.'_SETTINGS_INPUTFIELD_TYPE' => $this->buildDropdownmenu($this->getInputfieldTypes(), $arrInputfield['type']),
                            $this->moduleLangVar.'_SETTINGS_INPUTFIELD_VERIFICATION' => $this->buildDropdownmenu($this->getInputfieldVerifications(), $arrInputfield['verification']),
                            $this->moduleLangVar.'_SETTINGS_INPUTFIELD_SHOW' => $this->buildDropdownmenu($arrShow, $arrInputfield['show_in']),
                            $this->moduleLangVar.'_SETTINGS_INPUTFIELD_CONTEXT' => $this->buildDropdownmenu($this->getInputContexts(), $arrInputfield['context_type']),
                            $this->moduleLangVar.'_SETTINGS_INPUTFIELD_MUSTFIELD' => $strMustfield,
                            $this->moduleLangVar.'_SETTINGS_INPUTFIELD_EXP_SEARCH' => $strExpSearch,
                            $this->moduleLangVar.'_SETTINGS_INPUTFIELD_NAME_MASTER' => $arrInputfield['name'][0],
                            $this->moduleLangVar.'_SETTINGS_INPUTFIELD_DEFAULTVALUE_MASTER' => contrexx_raw2xhtml($arrInputfield['default_value'][0]),
                            $this->moduleLangVar.'_SETTINGS_INPUTFIELD_INFO_MASTER' => $arrInputfield['info'][0],
                        ));

                        //fieldname
                        foreach ($this->arrFrontendLanguages as $key => $arrLang) {
                            $objTpl->setVariable(array(
                                $this->moduleLangVar.'_INPUTFIELD_NAME_LANG_ID' => $arrLang['id'],
                                $this->moduleLangVar.'_INPUTFIELD_NAME_LANG_SHORTCUT' => $arrLang['lang'],
                                $this->moduleLangVar.'_INPUTFIELD_NAME_LANG_NAME' => $arrLang['name'],
                                $this->moduleLangVar.'_SETTINGS_INPUTFIELD_NAME' => $arrInputfield['name'][$arrLang['id']],
                            ));
                            $objTpl->parse($this->moduleName.'InputfieldNameList');
                        }

                        //default values
                        foreach ($this->arrFrontendLanguages as $key => $arrLang) {
                            $objTpl->setVariable(array(
                                $this->moduleLangVar.'_INPUTFIELD_DEFAULTVALUE_LANG_ID' => $arrLang['id'],
                                $this->moduleLangVar.'_INPUTFIELD_DEFAULTVALUE_LANG_SHORTCUT' => $arrLang['lang'],
                                $this->moduleLangVar.'_INPUTFIELD_DEFAULTVALUE_LANG_NAME' => $arrLang['name'],
                                $this->moduleLangVar.'_SETTINGS_INPUTFIELD_DEFAULTVALUE' => contrexx_raw2xhtml($arrInputfield['default_value'][$arrLang['id']]),
                            ));
                            $objTpl->parse($this->moduleName.'InputfieldDefaultvalueList');
                        }

                        //infotext
                        foreach ($this->arrFrontendLanguages as $key => $arrLang) {
                            $objTpl->setVariable(array(
                                $this->moduleLangVar.'_INPUTFIELD_INFO_LANG_ID' => $arrLang['id'],
                                $this->moduleLangVar.'_INPUTFIELD_INFO_LANG_SHORTCUT' => $arrLang['lang'],
                                $this->moduleLangVar.'_INPUTFIELD_INFO_LANG_NAME' => $arrLang['name'],
                                $this->moduleLangVar.'_SETTINGS_INPUTFIELD_INFO' => $arrInputfield['info'][$arrLang['id']],
                            ));
                            $objTpl->parse($this->moduleName.'InputfieldInfoList');
                        }

                        //language names
                        foreach ($this->arrFrontendLanguages as $key => $arrLang) {
                            if(($key+1) == count($this->arrFrontendLanguages)) {
                                $minimize = "<a id=\"inputfieldMinimize_".$arrInputfield['id']."\" href=\"javascript:ExpandMinimizeInputfields('inputfieldName', '".$arrInputfield['id']."'); ExpandMinimizeInputfields('inputfieldDefaultvalue', '".$arrInputfield['id']."'); ExpandMinimizeInputfields('inputfieldLanguages', '".$arrInputfield['id']."'); ExpandMinimizeInputfields('inputfieldInfo', '".$arrInputfield['id']."');\">&laquo;&nbsp;".$_ARRAYLANG['TXT_MEDIADIR_MINIMIZE']."</a>";
                            } else {
                                $minimize = "";
                            }

                            $objTpl->setVariable(array(
                                $this->moduleLangVar.'_INPUTFIELD_LANG_NAME' => $arrLang['name'],
                                $this->moduleLangVar.'_INPUTFIELD_MINIMIZE' => $minimize,
                            ));
                            $objTpl->parse($this->moduleName.'InputfieldLanguagesList');
                        }

                        $objTpl->parse($this->moduleName.'Inputfield');
                    } else {
                    	if(($arrInputfield['id'] == 2 && $objForms->arrForms[$this->intFormId]['formUseLevel']) || ($arrInputfield['id'] == 1 && $objForms->arrForms[$this->intFormId]['formUseCategory'])) {

	                        $objTpl->setVariable(array(
	                            $this->moduleLangVar.'_SETTINGS_SELECTOR_ID' => $arrInputfield['id'],
	                            $this->moduleLangVar.'_SETTINGS_SELECTOR_NAME' => $arrInputfield['name'][0],
	                            $this->moduleLangVar.'_SETTINGS_SELECTOR_ORDER' => $arrInputfield['order'],
	                            $this->moduleLangVar.'_SETTINGS_SELECTOR_EXP_SEARCH' => $strExpSearch,
	                        ));

	                        $objTpl->parse($this->moduleName.'Selector');
                    	}
                    }

                    $i++;
                    $objTpl->parse($this->moduleName.'InputfieldList');
                }

                $objTpl->parse('settings_inputfields_content');
                break;
            case 2:
                //modify (add/edit) View
                $objAddStep = new mediaDirectoryAddStep();
				$i = 0;

                foreach ($this->arrInputfields as $key => $arrInputfield) {
                    $strInputfield = null;

                    if($arrInputfield['required'] == 1) {
                        $strRequiered = '<font color="#ff0000"> *</font>';
                    } else {
                        $strRequiered = null;
                    }

                    if(!empty($arrInputfield['type'])) {
                        $strType = $arrInputfield['type_name'];
                        $strInputfieldClass = "mediaDirectoryInputfield".ucfirst($strType);

                        try {
                            $objInputfield = safeNew($strInputfieldClass);

                            switch($strType) {
                                case 'add_step':
                                    $objAddStep->addNewStep(empty($arrInputfield['name'][$_LANGID]) ? $arrInputfield['name'][0].$strRequiered : $arrInputfield['name'][$_LANGID]);
                                    $strInputfield = $objInputfield->getInputfield(1, $arrInputfield, $intEntryId, $objAddStep);
                                    break;
                                case 'field_group':
                                    //to do
                                    break;
                                default:
                                    if($arrInputfield['show_in'] == 1) {
                                        $bolGetInputfield = true;
                                    } else {
                                        if($objInit->mode == 'backend' && $arrInputfield['show_in'] == 3) {
                                            $bolGetInputfield = true;
                                        } else if ($objInit->mode == 'frontend' && $arrInputfield['show_in'] == 2) {
                                            $bolGetInputfield = true;
                                        } else {
                                            $bolGetInputfield = false;
                                        }
                                    }

                                    if($bolGetInputfield) {
                                        $strInputfield = $objInputfield->getInputfield(1, $arrInputfield, $intEntryId);
                                    } else {
                                        $strInputfield = null;
                                    }

                                    break;
                            }

                            if($strInputfield != null) {
                                $this->makeJavascriptInputfieldArray($arrInputfield['id'], $this->moduleName."Inputfield[".$arrInputfield['id']."]",  $arrInputfield['required'],  $arrInputfield['regex'], $strType);
                                $this->strJavascriptInputfieldCheck[$strType] = $objInputfield->getJavascriptCheck();
                                $this->arrJavascriptFormOnSubmit[$arrInputfield['id']] = $objInputfield->getFormOnSubmit($arrInputfield['id']);
                            }
                        } catch (Exception $error) {
                            echo "Error: ".$error->getMessage();
                        }
                    } else {
                        $objForms = new mediaDirectoryForm($this->intFormId);

		                /*if($objInit->mode == 'backend') {
		                    $strStyle = 'style="overflow: auto; border: 1px solid #0A50A1; background-color: #ffffff; width: 298px; height: 200px; float: left; list-style: none; padding: 0px; margin: 0px 5px 0px 0px;"';
		                } else {
		                    $strStyle = 'style="overflow: auto; float: left; list-style: none; padding: 0px; margin: 0px 5px 0px 0px;"';
		                }*/

                        if(($arrInputfield['id'] == 2 && $objForms->arrForms[$this->intFormId]['formUseLevel']) || ($arrInputfield['id'] == 1 && $objForms->arrForms[$this->intFormId]['formUseCategory'])) {
	                        if($arrInputfield['id'] == 2) {
	                            $objLevel = new mediaDirectoryLevel();
                                $arrSelectorOptions = $objLevel->listLevels($objTpl, 4, null, null, $intEntryId);
	                            $strSelectedOptionsName = "selectedLevels";
	                            $strNotSelectedOptionsName = "deselectedLevels";
	                        } else {
	                            $objCategory = new mediaDirectoryCategory();
	                            $arrSelectorOptions = $objCategory->listCategories($objTpl, 4, null, null, $intEntryId);
	                            $strSelectedOptionsName = "selectedCategories";
	                            $strNotSelectedOptionsName = "deselectedCategories";
	                        }
                        	
                        	$strInputfield .= '<div class="mediadirSelector" style="float: left; height: auto !important;">';
	                        $strInputfield .= '<div class="mediadirSelectorLeft" style="float: left; height: auto !important;"><select id="'.$strNotSelectedOptionsName.'" name="'.$strNotSelectedOptionsName.'[]" size="12" multiple="multiple" style="width: 180px;">';
	                        $strInputfield .= $arrSelectorOptions['not_selected'];
	                        $strInputfield .= '</select></div>';
	                        $strInputfield .= '<div class="mediadirSelectorCenter" style="float: left; height: 100px; padding: 60px 10px 0px 10px;">';
	                        $strInputfield .= '<input style="width: 40px; min-width: 40px;" value=" &gt;&gt; " name="addElement" onclick="moveElement(document.entryModfyForm.elements[\''.$strNotSelectedOptionsName.'\'],document.entryModfyForm.elements[\''.$strSelectedOptionsName.'\'],addElement,removeElement);" type="button">';
	                        $strInputfield .= '<br />';
	                        $strInputfield .= '<input style="width: 40px; min-width: 40px;" value=" &lt;&lt; " name="removeElement" onclick="moveElement(document.entryModfyForm.elements[\''.$strSelectedOptionsName.'\'],document.entryModfyForm.elements[\''.$strNotSelectedOptionsName.'\'],removeElement,addElement);" type="button">';
	                        $strInputfield .= '</div>';
	                        $strInputfield .= '<div class="mediadirSelectorRight" style="float: left; height: auto !important;"><select id="'.$strSelectedOptionsName.'" name="'.$strSelectedOptionsName.'[]" size="12" multiple="multiple" style="width: 180px;">';
	                        $strInputfield .= $arrSelectorOptions['selected'];
	                        $strInputfield .= '</select></div>';
	                        $strInputfield .= '</div>';
	                        
                            $this->makeJavascriptInputfieldArray($arrInputfield['id'], $strSelectedOptionsName, 1, 1, "selector");
                            $this->arrJavascriptFormOnSubmit[$arrInputfield['id']] = "selectAll(document.entryModfyForm.elements['".$strSelectedOptionsName."[]']); "; 
                        }
                    }

                    if($arrInputfield['type_name'] == 'add_step' && $objInit->mode != 'backend') {
                        $objTpl->setVariable(array(
                            $this->moduleLangVar.'_INPUTFIELD_ADDSTEP' => $strInputfield,
                        ));

                        $objTpl->parse($this->moduleName.'InputfieldAddStep');
                    } else {
                        if($strInputfield != null) {
                            if($arrInputfield['type_name'] == 'title') {
                                $strStartTitle = '<h2>';
                                $strEndTitle = '</h2>';
                            } else {  
                                $strStartTitle = '';
                                $strEndTitle = '';
                            }  
                            
                            $objTpl->setVariable(array(
                                'TXT_'.$this->moduleLangVar.'_INPUTFIELD_NAME' => $strStartTitle.(empty($arrInputfield['name'][$_LANGID]) ? $arrInputfield['name'][0].$strRequiered : $arrInputfield['name'][$_LANGID].$strRequiered).$strEndTitle,
                                $this->moduleLangVar.'_INPUTFIELD_FIELD' => $strInputfield,
                                $this->moduleLangVar.'_INPUTFIELD_ROW_CLASS' => $i%2==0 ? 'row1' : 'row2',
                            ));

                            if($arrInputfield['type_name'] != 'add_step') {
                                $i++;
                                $objTpl->parse($this->moduleName.'InputfieldList');
                            }
                        }
                    }

                    if($objInit->mode != 'backend') {
                        $objTpl->parse($this->moduleName.'InputfieldElement');
                    }
                }

                if(!empty($objAddStep->arrSteps) && $objInit->mode != 'backend') {
                    $objAddStep->getStepNavigation($objTpl);
                    $objTpl->parse($this->moduleName.'EntryAddStepNavigation');

                    $objTpl->setVariable(array(
                        $this->moduleLangVar.'_INPUTFIELD_ADDSTEP_TERMINATOR' => "</div>",
                    ));
                }

                break;
            case 3:
                //frontend View
                foreach ($this->arrInputfields as $key => $arrInputfield) {
                    $intInputfieldId = intval($arrInputfield['id']);
                    $intInputfieldType = intval($arrInputfield['type']);

                    if(($objTpl->blockExists($this->moduleName.'_inputfield_'.$intInputfieldId) || $objTpl->blockExists($this->moduleName.'_inputfields')) && ($intInputfieldType != 16 && $intInputfieldType != 17)){
                        if(!empty($arrInputfield['type'])) {
                            $strType = $arrInputfield['type_name'];
                            $strInputfieldClass = "mediaDirectoryInputfield".ucfirst($strType);
                            try {
                                $objInputfield = safeNew($strInputfieldClass);

                                if(intval($arrInputfield['type_multi_lang']) == 1) {
                                    $arrInputfieldContent = $objInputfield->getContent($intEntryId, $arrInputfield, $this->arrTranslationStatus);
                                } else {
                                    $arrInputfieldContent = $objInputfield->getContent($intEntryId, $arrInputfield, null);
                                }

                                if(!empty($arrInputfieldContent)) {
                                    foreach ($arrInputfieldContent as $strPlaceHolder => $strContent) {
                                        $objTpl->setVariable(array(
                                            strtoupper($strPlaceHolder) => $strContent
                                        ));
                                    }

                                    if($objTpl->blockExists($this->moduleName.'_inputfields')){
                                         $objTpl->parse($this->moduleName.'_inputfields');
                                    } else {
                                        if ($objTpl->blockExists($this->moduleName.'_inputfield_'.$intInputfieldId)){
                                            $objTpl->parse($this->moduleName.'_inputfield_'.$intInputfieldId);
                                        }
                                    }
                                } else {
                                    if($objTpl->blockExists($this->moduleName.'_inputfield_'.$intInputfieldId)){
                                         $objTpl->hideBlock($this->moduleName.'_inputfield_'.$intInputfieldId);
                                    }
                                }
                            } catch (Exception $error) {
                                echo "Error: ".$error->getMessage();
                            }
                        }
                    }

                    $objTpl->clearVariables();
                }
                break;
            case 4:
                //Exp Search View
                foreach ($this->arrInputfields as $key => $arrInputfield) {
                    if($this->checkFieldTypeIsExpSeach($arrInputfield['type'])) {
                        if(!empty($arrInputfield['type'])) {
                            $strType = $arrInputfield['type_name'];
                            $strInputfieldClass = "mediaDirectoryInputfield".ucfirst($strType);
                            try {
                                $objInputfield = safeNew($strInputfieldClass);
                                $strInputfield = $objInputfield->getInputfield(2, $arrInputfield);

                                if($strInputfield != null) {
                                    $strInputfields .= '<p><label>'.$arrInputfield['name'][0].'</label>'.$strInputfield.'</p>';
                                }
                            } catch (Exception $error) {
                                echo "Error: ".$error->getMessage();
                            }
                        }
                    }
                }

                return $strInputfields;

                break;
        }
    }



    function saveInputfields($arrData)
    {
        global $_ARRAYLANG, $_CORELANG, $objDatabase, $_LANGID;

        $objDatabase->Execute("DELETE FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_inputfields WHERE form='".$this->intFormId."'");
        $objDatabase->Execute("DELETE FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_inputfield_names WHERE form_id='".$this->intFormId."'");

        foreach ($arrData['inputfieldId'] as $intKey => $intFieldId) {
            $intFieldId = intval($intFieldId);
            $intFieldOrder = intval($arrData['inputfieldOrder'][$intFieldId]);
            $arrFieldNames = $arrData['inputfieldName'][$intFieldId];
            $intFieldType = intval($arrData['inputfieldType'][$intFieldId]);
            $intFieldShowIn = intval($arrData['inputfieldShow'][$intFieldId]);
            $arrFieldDefaultValues = $arrData['inputfieldDefaultvalue'][$intFieldId];
            $arrFieldInfos = $arrData['inputfieldInfo'][$intFieldId];
            $intFieldVerification = intval($arrData['inputfieldVerification'][$intFieldId]);
            $intFieldMustfield = intval($arrData['inputfieldMustfield'][$intFieldId]);
            $intFieldExpSearch = intval($arrData['inputfieldExpSearch'][$intFieldId]);
            $fieldContextType = contrexx_input2db($arrData['inputfieldContext'][$intFieldId]);

            //add inputfield
            $objSaveInputfield = $objDatabase->Execute("
                INSERT INTO
                    ".DBPREFIX."module_".$this->moduleTablePrefix."_inputfields
                SET
                    `id` = '".$intFieldId."',
                    `form` = '".$this->intFormId."',
                    `order` = '".$intFieldOrder."',
                    `type` = '".$intFieldType."',
                    `show_in` = '".$intFieldShowIn."',
                    `verification` = '".$intFieldVerification."',
                    `required` = '".$intFieldMustfield."',
                    `search` = '".$intFieldExpSearch."',
                    `context_type` = '".$fieldContextType."'

            ");

            if ($objSaveInputfield === false) {
                return false;
            }

            //add inputfield names and default values
            foreach ($this->arrFrontendLanguages as $key => $arrLang) {
                if(empty($arrFieldNames[0])) $arrFieldNames[0] = "";

                $strFieldName = $arrFieldNames[$arrLang['id']];
                $strFieldDefaultValue = $arrFieldDefaultValues[$arrLang['id']];
                $strFieldInfo = $arrFieldInfos[$arrLang['id']];

                if($arrLang['id'] == $_LANGID) {
                    if($this->arrInputfields[$intFieldId]['name'][0] == $arrFieldNames[0] && $this->arrInputfields[$intFieldId]['name'][$arrLang['id']] != $arrFieldNames[$arrLang['id']]) {
                        $strFieldName = $arrFieldNames[$_LANGID];
                    }

                    if($this->arrInputfields[$intFieldId]['default_value'][0] == $strFieldDefaultValue[0] && $this->arrInputfields[$intFieldId]['default_value'][$arrLang['id']] != $arrFieldDefaultValues[$arrLang['id']]) {
                        $strFieldDefaultValue = $arrFieldDefaultValues[$_LANGID];
                    }

                    if($this->arrInputfields[$intFieldId]['info'][0] == $arrFieldInfos[0] && $this->arrInputfields[$intFieldId]['info'][$arrLang['id']] != $arrFieldInfos[$arrLang['id']]) {
                        $strFieldInfo = $arrFieldInfos[$_LANGID];
                    }

                    if($this->arrInputfields[$intFieldId]['name'][0] != $arrFieldNames[0] && $this->arrInputfields[$intFieldId]['name'][$arrLang['id']] == $arrFieldNames[$arrLang['id']] ||
                       $this->arrInputfields[$intFieldId]['name'][0] != $arrFieldNames[0] && $this->arrInputfields[$intFieldId]['name'][$arrLang['id']] != $arrFieldNames[$arrLang['id']] ||
                       $this->arrInputfields[$intFieldId]['name'][0] == $arrFieldNames[0] && $this->arrInputfields[$intFieldId]['name'][$arrLang['id']] == $arrFieldNames[$arrLang['id']]) {
                        $strFieldName = $arrFieldNames[0];
                    }

                    if($this->arrInputfields[$intFieldId]['default_value'][0] != $arrFieldDefaultValues[0] && $this->arrInputfields[$intFieldId]['default_value'][$arrLang['id']] == $arrFieldDefaultValues[$arrLang['id']] ||
                       $this->arrInputfields[$intFieldId]['default_value'][0] != $arrFieldDefaultValues[0] && $this->arrInputfields[$intFieldId]['default_value'][$arrLang['id']] != $arrFieldDefaultValues[$arrLang['id']] ||
                       $this->arrInputfields[$intFieldId]['default_value'][0] == $arrFieldDefaultValues[0] && $this->arrInputfields[$intFieldId]['default_value'][$arrLang['id']] == $arrFieldDefaultValues[$arrLang['id']]) {
                       $strFieldDefaultValue = $arrFieldDefaultValues[0];
                    }

                    if($this->arrInputfields[$intFieldId]['info'][0] != $arrFieldInfos[0] && $this->arrInputfields[$intFieldId]['info'][$arrLang['id']] == $arrFieldInfos[$arrLang['id']] ||
                       $this->arrInputfields[$intFieldId]['info'][0] != $arrFieldInfos[0] && $this->arrInputfields[$intFieldId]['info'][$arrLang['id']] != $arrFieldInfos[$arrLang['id']] ||
                       $this->arrInputfields[$intFieldId]['info'][0] == $arrFieldInfos[0] && $this->arrInputfields[$intFieldId]['info'][$arrLang['id']] == $arrFieldInfos[$arrLang['id']]) {
                       $strFieldInfo = $arrFieldInfos[0];
                    }
                }

                if(empty($strFieldName)) $strFieldName = $arrFieldNames[0];

                if(empty($strFieldDefaultValue)) $strFieldDefaultValue = $arrFieldDefaultValues[0];

                if(empty($strFieldInfo)) $strFieldInfo = $arrFieldInfos[0];

                $objSaveInputfieldName = $objDatabase->Execute("
                    INSERT INTO
                        ".DBPREFIX."module_".$this->moduleTablePrefix."_inputfield_names
                    SET
                        `lang_id` = '".intval($arrLang['id'])."',
                        `form_id` = '".$this->intFormId."',
                        `field_id` = '".$intFieldId."',
                        `field_name` = '".contrexx_addslashes(contrexx_strip_tags($strFieldName))."',
                        `field_default_value` = '".contrexx_addslashes($strFieldDefaultValue)."',
                        `field_info` = '".contrexx_addslashes(htmlentities($strFieldInfo, ENT_QUOTES, CONTREXX_CHARSET))."'
                ");

                if ($objSaveInputfieldName === false) {
                    return false;
                }
            }
        }

        $objCategorySelector = $objDatabase->Execute("UPDATE ".DBPREFIX."module_".$this->moduleTablePrefix."_order_rel_forms_selectors SET `selector_order`='".intval($arrData['selectorOrder'][1])."', `exp_search`='".intval($arrData['selectorExpSearch'][1])."' WHERE `selector_id`='9' AND `form_id`='".$this->intFormId."'");
        $objLevelSelector = $objDatabase->Execute("UPDATE ".DBPREFIX."module_".$this->moduleTablePrefix."_order_rel_forms_selectors SET `selector_order`='".intval($arrData['selectorOrder'][2])."', `exp_search`='".intval($arrData['selectorExpSearch'][2])."' WHERE `selector_id`='10' AND `form_id`='".$this->intFormId."'");

        if ($objCategorySelector === false || $objLevelSelector === false) {
            return false;
        }

        return true;
    }



    function addInputfield()
    {
        global $objDatabase, $_LANGID;

        $objOrderInputfield = $objDatabase->Execute("
            SELECT
                `id`
            FROM
                ".DBPREFIX."module_".$this->moduleTablePrefix."_inputfields
            WHERE
                `form` = '".$this->intFormId."'
        ");

        if($this->arrSettings['settingsShowLevels']) {
            $intOrder = $objOrderInputfield->RecordCount() + 2;
        } else {
            $intOrder = $objOrderInputfield->RecordCount() + 1;
        }
        //insert new field
        $objAddInputfield = $objDatabase->Execute("
            INSERT INTO
                ".DBPREFIX."module_".$this->moduleTablePrefix."_inputfields
            SET
                `form` = '".$this->intFormId."',
                `order` = '".intval($intOrder)."',
                `type` = '1',
                `show_in` = '1',
                `verification` = '1',
                `search` = '0',
                `required` = '0'
        ");

        $intInsertId = $objDatabase->Insert_ID();
        $objDatabase->debug = 1;
        //insert blank field name
        $objAddInputfieldName = $objDatabase->Execute("
            INSERT INTO
                ".DBPREFIX."module_".$this->moduleTablePrefix."_inputfield_names
            SET
                `lang_id` = '".intval($_LANGID)."',
                `form_id` = '".$this->intFormId."',
                `field_id` = '".intval($intInsertId)."',
                `field_name` = '',
                `field_default_value` = '',
                `field_info` = ''
        ");

        return $intInsertId;
    }



    function moveInputfield($intFieldId, $intDirectionId)
    {
        global $objDatabase;

        $bolChangeOrder = false;
        $intCountFields = count($this->arrInputfields)-1;
        $intOrder = intval($this->arrInputfields[$intFieldId]['order']);

        if($intDirectionId == 1) {
            if($intOrder > 0) {
                $intNewOrder = $intOrder-1;
                $intNeighborKey = $intNewOrder;
                $bolChangeOrder = true;
            }
        } else {
            if($intOrder < $intCountFields) {
                $intNewOrder = $intOrder+1;
                $intNeighborKey = $intNewOrder;
                $bolChangeOrder = true;
            }
        }

        if($bolChangeOrder) {
            usort($this->arrInputfields, array(__CLASS__, "sortInputfields"));

            $intNeighborId = $this->arrInputfields[$intNeighborKey]['id'];
            $intNeighborOrder = $intOrder;

            $arrElements = array();

            $arrElements[0]['id'] = $intFieldId;
            $arrElements[0]['order'] = $intNewOrder;
            $arrElements[1]['id'] = $intNeighborId;
            $arrElements[1]['order'] = $intNeighborOrder;

            foreach ($arrElements as $key => $arrData) {
                if($arrData['id'] == 1) {
                    $objDatabase->Execute("UPDATE ".DBPREFIX."module_".$this->moduleTablePrefix."_order_rel_forms_selectors SET `selector_order`='".intval($arrData['order'])."' WHERE `selector_id`='9' AND `form_id`='".$this->intFormId."'");
                } else if ($arrData['id'] == 2) {
                    $objDatabase->Execute("UPDATE ".DBPREFIX."module_".$this->moduleTablePrefix."_order_rel_forms_selectors SET `selector_order`='".intval($arrData['order'])."' WHERE `selector_id`='10' AND `form_id`='".$this->intFormId."'");
                } else {
                    $objDatabase->Execute("UPDATE ".DBPREFIX."module_".$this->moduleTablePrefix."_inputfields SET `order`='".intval($arrData['order'])."' WHERE `id`='".intval($arrData['id'])."'");
                }
            }
        }
    }



    function deleteInputfield($intFieldId)
    {
        global $objDatabase;

        //delete field
        $objAddInputfield = $objDatabase->Execute("
            DELETE FROM
                ".DBPREFIX."module_".$this->moduleTablePrefix."_inputfields
            WHERE
                `id` = '".intval($intFieldId)."'
        ");

        //delete field names
        $objAddInputfieldName = $objDatabase->Execute("
            DELETE FROM
                ".DBPREFIX."module_".$this->moduleTablePrefix."_inputfield_names
            WHERE
                `field_id` = '".intval($intFieldId)."'
        ");

        //remove from array
        unset($this->arrInputfields[$intFieldId]);

        //refresh order
        $this->refreshOrder();
    }



    function refreshOrder()
    {
        global $objDatabase;

        foreach($this->arrInputfields as $fieldId => $arrData) {
            $arrOrder[$fieldId] = $arrData['order'];
        }

        asort($arrOrder);

        $i=0;
        foreach ($arrOrder as $fieldId => $oldOrder) {
            if($fieldId == 1) {
                $objDatabase->Execute("UPDATE ".DBPREFIX."module_".$this->moduleTablePrefix."_order_rel_forms_selectors SET `selector_order`='".intval($i)."' WHERE `selector_id`='9' AND `form_id`='".$this->intFormId."'");
            } else if ($fieldId == 2) {
                $objDatabase->Execute("UPDATE ".DBPREFIX."module_".$this->moduleTablePrefix."_order_rel_forms_selectors SET `selector_order`='".intval($i)."' WHERE `selector_id`='10' AND `form_id`='".$this->intFormId."'");
            } else {
                $objDatabase->Execute("UPDATE ".DBPREFIX."module_".$this->moduleTablePrefix."_inputfields SET `order`='".intval($i)."' WHERE `id`='".intval($fieldId)."'");
            }
            $i++;
        }

    }



    function refreshInputfields($objTpl, $intEntryId)
    {
        global $_ARRAYLANG, $_CORELANG, $objDatabase, $_LANGID;

        $objTpl->loadTemplateFile('module_'.$this->moduleName.'_settings_inputfields.html',true,true);

        $objForms = new mediaDirectoryForm($this->intFormId);

        usort($this->arrInputfields, array(__CLASS__, "sortInputfields"));

        $arrShow = array(
            1 => $_ARRAYLANG['TXT_MEDIADIR_SHOW_BACK_N_FRONTEND'],
            2 => $_ARRAYLANG['TXT_MEDIADIR_SHOW_FRONTEND'],
            3 => $_ARRAYLANG['TXT_MEDIADIR_SHOW_BACKEND'],
        );

        foreach ($this->arrInputfields as $key => $arrInputfield) {
            $strMustfield = $arrInputfield['required']==1 ? 'checked="checked"' : '';
            $strExpSearch = $arrInputfield['search']==1 ? 'checked="checked"' : '';

            if($arrInputfield['id'] > $intLastId) {
                $intLastId = $arrInputfield['id'];
            }

            $objTpl->setGlobalVariable(array(
                $this->moduleLangVar.'_SETTINGS_INPUTFIELD_ROW_CLASS' => $i%2==0 ? 'row1' : 'row2',
                $this->moduleLangVar.'_SETTINGS_INPUTFIELD_LASTID' => $intLastId,
            ));

            if($arrInputfield['id'] != 1 && $arrInputfield['id'] != 2) {
                $objTpl->setGlobalVariable(array(
                    $this->moduleLangVar.'_SETTINGS_INPUTFIELD_ID' => $arrInputfield['id'],
                    $this->moduleLangVar.'_SETTINGS_INPUTFIELD_FORM_ID' => $this->intFormId,
                    $this->moduleLangVar.'_SETTINGS_INPUTFIELD_ORDER' => $arrInputfield['order'],
                    $this->moduleLangVar.'_SETTINGS_INPUTFIELD_TYPE' => $this->buildDropdownmenu($this->getInputfieldTypes(), $arrInputfield['type']),
                    $this->moduleLangVar.'_SETTINGS_INPUTFIELD_VERIFICATION' => $this->buildDropdownmenu($this->getInputfieldVerifications(), $arrInputfield['verification']),
                    $this->moduleLangVar.'_SETTINGS_INPUTFIELD_SHOW' => $this->buildDropdownmenu($arrShow, $arrInputfield['show_in']),
                    $this->moduleLangVar.'_SETTINGS_INPUTFIELD_CONTEXT' => $this->buildDropdownmenu($this->getInputContexts(), $arrInputfield['context_type']),
                    $this->moduleLangVar.'_SETTINGS_INPUTFIELD_MUSTFIELD' => $strMustfield,
                    $this->moduleLangVar.'_SETTINGS_INPUTFIELD_EXP_SEARCH' => $strExpSearch,
                    $this->moduleLangVar.'_SETTINGS_INPUTFIELD_NAME_MASTER' => $arrInputfield['name'][0],
                    $this->moduleLangVar.'_SETTINGS_INPUTFIELD_INFO_MASTER' => $arrInputfield['info'][0],
                    $this->moduleLangVar.'_SETTINGS_INPUTFIELD_DEFAULTVALUE_MASTER' => $arrInputfield['default_value'][0],
                ));

                //fieldname
                foreach ($this->arrFrontendLanguages as $key => $arrLang) {
                    $objTpl->setVariable(array(
                        $this->moduleLangVar.'_INPUTFIELD_NAME_LANG_ID' => $arrLang['id'],
                        $this->moduleLangVar.'_INPUTFIELD_NAME_LANG_SHORTCUT' => $arrLang['lang'],
                        $this->moduleLangVar.'_INPUTFIELD_NAME_LANG_NAME' => $arrLang['name'],
                        $this->moduleLangVar.'_SETTINGS_INPUTFIELD_NAME' => $arrInputfield['name'][$arrLang['id']],
                    ));
                    $objTpl->parse($this->moduleName.'InputfieldNameList');
                }

                //default values
                foreach ($this->arrFrontendLanguages as $key => $arrLang) {
                    $objTpl->setVariable(array(
                        $this->moduleLangVar.'_INPUTFIELD_DEFAULTVALUE_LANG_ID' => $arrLang['id'],
                        $this->moduleLangVar.'_INPUTFIELD_DEFAULTVALUE_LANG_SHORTCUT' => $arrLang['lang'],
                        $this->moduleLangVar.'_INPUTFIELD_DEFAULTVALUE_LANG_NAME' => $arrLang['name'],
                        $this->moduleLangVar.'_SETTINGS_INPUTFIELD_DEFAULTVALUE' => $arrInputfield['default_value'][$arrLang['id']],
                    ));
                    $objTpl->parse($this->moduleName.'InputfieldDefaultvalueList');
                }



                //infotext
                foreach ($this->arrFrontendLanguages as $key => $arrLang) {
                    $objTpl->setVariable(array(
	                    $this->moduleLangVar.'_INPUTFIELD_INFO_LANG_ID' => $arrLang['id'],
	                    $this->moduleLangVar.'_INPUTFIELD_INFO_LANG_SHORTCUT' => $arrLang['lang'],
	                    $this->moduleLangVar.'_INPUTFIELD_INFO_LANG_NAME' => $arrLang['name'],
	                    $this->moduleLangVar.'_SETTINGS_INPUTFIELD_INFO' => $arrInputfield['info'][$arrLang['id']],
	                ));
                    $objTpl->parse($this->moduleName.'InputfieldInfoList');
                }

                //language names
                foreach ($this->arrFrontendLanguages as $key => $arrLang) {
                    if(($key+1) == count($this->arrFrontendLanguages)) {
                        $minimize = "<a id=\"inputfieldMinimize_".$arrInputfield['id']."\" href=\"javascript:ExpandMinimizeInputfields('inputfieldName', '".$arrInputfield['id']."'); ExpandMinimizeInputfields('inputfieldDefaultvalue', '".$arrInputfield['id']."'); ExpandMinimizeInputfields('inputfieldLanguages', '".$arrInputfield['id']."'); ExpandMinimizeInputfields('inputfieldInfo', '".$arrInputfield['id']."');\">&laquo;&nbsp;".$_ARRAYLANG['TXT_MEDIADIR_MINIMIZE']."</a>";
                    } else {
                        $minimize = "";
                    }

                    $objTpl->setVariable(array(
                        $this->moduleLangVar.'_INPUTFIELD_LANG_NAME' => $arrLang['name'],
                        $this->moduleLangVar.'_INPUTFIELD_MINIMIZE' => $minimize,
                    ));
                    $objTpl->parse($this->moduleName.'InputfieldLanguagesList');
                }

                $objTpl->parse($this->moduleName.'Inputfield');
            } else {
            	if(($arrInputfield['id'] == 2 && $objForms->arrForms[$this->intFormId]['formUseLevel']) || ($arrInputfield['id'] == 1 && $objForms->arrForms[$this->intFormId]['formUseCategory'])) {

	                $objTpl->setVariable(array(
	                    $this->moduleLangVar.'_SETTINGS_SELECTOR_ID' => $arrInputfield['id'],
	                    $this->moduleLangVar.'_SETTINGS_SELECTOR_NAME' => $arrInputfield['name'][0],
	                    $this->moduleLangVar.'_SETTINGS_SELECTOR_ORDER' => $arrInputfield['order'],
	                    $this->moduleLangVar.'_SETTINGS_SELECTOR_EXP_SEARCH' => $strExpSearch,
	                ));

	                $objTpl->parse($this->moduleName.'Selector');
            	}
            }

            $i++;
            $objTpl->parse($this->moduleName.'InputfieldList');
        }

        return $objTpl->get();
    }



    function getInputfieldTypes()
    {
        global $_ARRAYLANG, $objDatabase;

        $objInputfieldTypes = $objDatabase->Execute("
            SELECT
                `id`,
                `name`
            FROM
                ".DBPREFIX."module_".$this->moduleTablePrefix."_inputfield_types
            WHERE
                `active` = '1'
            ORDER BY
                `id` ASC
        ");

        if ($objInputfieldTypes !== false) {
            while (!$objInputfieldTypes->EOF) {

                $arrInputfieldTypes[$objInputfieldTypes->fields['id']] = $_ARRAYLANG['TXT_MEDIADIR_INPUTFIELD_TYPE_'.strtoupper(htmlspecialchars($objInputfieldTypes->fields['name'], ENT_QUOTES, CONTREXX_CHARSET))];

                $objInputfieldTypes->MoveNext();
            }
        }

        return $arrInputfieldTypes;
    }



    function makeJavascriptInputfieldArray($intId, $strName, $intRequired, $strVerification, $strType)
    {
        $strVerification = addslashes($strVerification);
        $this->strJavascriptInputfieldArray .= <<<EOF

inputFields[$intId] = Array(
    '$strName',
    $intRequired,
    '$strVerification',
    '$strType');
EOF;
    }



    function getInputfieldJavascript()
    {
    	$strInputfieldErrorMessage = $this->moduleName."ErrorMessage";

        $strstrInputfieldJavascript = <<<EOF

function selectAddStep(stepName){
    if(document.getElementById(stepName).style.display != "block")
    {
        document.getElementById(stepName).style.display = "block";
        strClass = document.getElementById(stepName).className;                  
        document.getElementById(strClass+"_"+stepName).className = "active";

        arrTags = document.getElementsByTagName("*");
        for (i=0;i<arrTags.length;i++)
            {
                if(arrTags[i].className == strClass && arrTags[i] != document.getElementById(stepName))
                {
                    arrTags[i].style.display = "none";
                    if (document.getElementById(strClass+"_"+arrTags[i].getAttribute("id"))) {
                        document.getElementById(strClass+"_"+arrTags[i].getAttribute("id")).className = "";
                    }
                }
            }
    }
}


inputFields = new Array();
$this->strJavascriptInputfieldArray

function checkAllFields() {
    var isOk = true;

    if (document.getElementById('{$this->moduleName}Inputfield_ReadyToConfirm') != null && !document.getElementById('{$this->moduleName}Inputfield_ReadyToConfirm').checked) {
        return true;
    }

    for (var field in inputFields) {
        var type = inputFields[field][3];

        switch (type){
            case 'selector':
                name =  inputFields[field][0];
                value = document.getElementById(name).value;
                if (value == "") {
                	isOk = false;
                	document.getElementById(name).style.border = "#ff0000 1px solid";
                } else {
                	document.getElementById(name).style.borderColor = '';
                }
                break;
EOF;

        foreach($this->strJavascriptInputfieldCheck as $strType => $strCase) {
             $strstrInputfieldJavascript .= <<<EOF
             $strCase
EOF;
        }

        $strstrInputfieldJavascript .= <<<EOF
        }
    }

    if (!isOk) {
		document.getElementById('$strInputfieldErrorMessage').style.display = "block";
	}

	return isOk;
}

function isRequiredGlobal(required, value) {
	if (required == 1) {
		if (value == "") {
			return true;
		}
	}

	return false;
}

function matchType(pattern, value) {
	var reg = new RegExp(pattern);
	if (value.match(reg)) {
		return true;
	}
	return false;
}

EOF;

        return $strstrInputfieldJavascript;
    }



    function getInputfieldVerifications()
    {
        global $_ARRAYLANG, $objDatabase;

        $objInputfieldVerifications = $objDatabase->Execute("
            SELECT
                `id`,
                `name`
            FROM
                ".DBPREFIX."module_".$this->moduleTablePrefix."_inputfield_verifications
            ORDER BY
                `id` ASC
        ");

        if ($objInputfieldVerifications !== false) {
            while (!$objInputfieldVerifications->EOF) {

                $arrInputfieldVerifications[$objInputfieldVerifications->fields['id']] = $_ARRAYLANG['TXT_MEDIADIR_INPUTFIELD_VERIFICATION_'.strtoupper(htmlspecialchars($objInputfieldVerifications->fields['name'], ENT_QUOTES, CONTREXX_CHARSET))];

                $objInputfieldVerifications->MoveNext();
            }
        }

        return $arrInputfieldVerifications;
    }

    /**
     * Returns available context options
     * 
     * @return array available contexts
     */
    public static function getInputContexts()
    {
        global $_ARRAYLANG;
        
        $arrContexts = array(
          'none'    => $_ARRAYLANG["TXT_MEDIADIR_INPUTFIELD_CONTEXT_NONE"],
          'title'   => $_ARRAYLANG["TXT_MEDIADIR_INPUTFIELD_CONTEXT_TITLE"],
          'address' => $_ARRAYLANG["TXT_MEDIADIR_INPUTFIELD_CONTEXT_ADDRESS"],
          'zip'     => $_ARRAYLANG["TXT_MEDIADIR_INPUTFIELD_CONTEXT_ZIP"],
          'city'    => $_ARRAYLANG["TXT_MEDIADIR_INPUTFIELD_CONTEXT_CITY"],
          'country' => $_ARRAYLANG["TXT_MEDIADIR_INPUTFIELD_CONTEXT_COUNTRY"],
        );
        
        return $arrContexts;
    }

    function listPlaceholders($objTpl)
    {
        global $_ARRAYLANG, $_CORELANG, $objDatabase, $objTemplate;

        foreach ($this->arrInputfields as $key => $arrInputfield) {
            if($arrInputfield['id'] != 1 && $arrInputfield['id'] != 2 && $arrInputfield['type'] != 16 && $arrInputfield['type'] != 18) {
                $strType = $arrInputfield['type_name'];
                $strInputfieldClass = "mediaDirectoryInputfield".ucfirst($strType);

                try {
                    $objInputfield = safeNew($strInputfieldClass);
                } catch (Exception $e) {
                    echo "Error: ".$e->getMessage();
                }

                $objTpl->setGlobalVariable(array(
                    $this->moduleLangVar.'_SETTINGS_INPUTFIELD_ID' => $arrInputfield['id'],
                ));

                $arrPlaceholders = $objInputfield->arrPlaceholders;
                $strPlaceholders = null;

                foreach ($arrPlaceholders as $key => $strPlaceholder) {
                    $strPlaceholders .= '[['.strtoupper($strPlaceholder).']]&nbsp;';
                }


                $strBlockDescription = str_replace('%i', $arrInputfield['name'][0], $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_PLACEHOLDER_DESCRIPTION']);

                $objTpl->setVariable(array(
                    $this->moduleLangVar.'_SETTINGS_INPUTFIELD_DESCRIPTION' => $strBlockDescription,
                    $this->moduleLangVar.'_SETTINGS_INPUTFIELD_PLACEHOLDERS' => $strPlaceholders
                ));
                $objTpl->parse($this->moduleName.'InputfieldPlaceholderList');
            }
        }
    }



    function checkFieldTypeIsExpSeach($intType)
    {
        global $objDatabase;

        $objResultTypeCheck = $objDatabase->Execute("SELECT exp_search FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_inputfield_types WHERE id='".intval($intType)."' LIMIT 1");

        if ($objResultTypeCheck) {
            if($objResultTypeCheck->fields['exp_search'] == 1) {
                $status = true;
            } else {
                $status = false;
            }
        } else {
            $status = false;
        }

        return $status;
    }
}
