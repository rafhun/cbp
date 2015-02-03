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
 * Media  Directory Inputfield Accounts Class
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
 * Media  Directory Inputfield Accounts Class
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Comvation Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_mediadir
 * @todo        Edit PHP DocBlocks!
 */
class mediaDirectoryInputfieldAccounts extends mediaDirectoryLibrary implements inputfield
{
    public $arrPlaceholders = array(
        'TXT_MEDIADIR_INPUTFIELD_NAME',
        'MARKETPLACE_INPUTFIELD_VALUE'
    );


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
        global $objDatabase, $objInit, $_ARRAYLANG;

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
                    $strValue = $objInputfieldValue->fields['value'];
                } else {
                    $strValue = null;
                }

				$arrValue = explode(',',$strValue);

                //$strFormType = empty($arrInputfield['default_value'][$_LANGID]) ? $arrInputfield['default_value'][0] : $arrInputfield['default_value'][$_LANGID];
                //$arrSelectorOptions = array();

                $strSelectorSelected = "";
                $strSelectorNotSelected = "";

                $userFilter = array();
                if (!FWUser::getFWUserObject()->objUser->getAdminStatus()) {
                    $userFilter = array('contact_user_id' => FWUser::getFWUserObject()->objUser->getId());
                    //$userFilter = array('contact_user_id' => FWUser::getFWUserObject()->objUser->getId(), 'id' => FWUser::getFWUserObject()->objUser->getId());
                }

                //$arrSelectedList = array();
                $objUser = FWUser::getFWUserObject()->objUser->getUsers($userFilter, null, null, array('company', 'firstname', 'lastname'));
                if ($objUser) {
                    while (!$objUser->EOF) {
                        $userName = $objUser->getProfileAttribute('company').', '
                                    .$objUser->getProfileAttribute('lastname').' '
                                    .$objUser->getProfileAttribute('firstname');
                        /*$arrSelectedList[$objUser->getId()] = array(
                            'name'      => $userName,
                            'class'     => "childCategory_".$intId."_".intval($objUser->getId()),
                            'id'        => (in_array($objUser->getId(), $arrValue) ? '' : 'o')."childCategory".$intId."_".intval($objUser->getId()),
                            'selected'  => intval(in_array($objUser->getId(), $arrValue))
                        );*/

                        if(in_array($objUser->getId(), $arrValue)) {
                           $strSelectorSelected .= '<option  value="'.$objUser->getId().'">
                           '.contrexx_raw2xhtml($userName).'</option>';
                        } else {
                           $strSelectorNotSelected .= '<option  value="'.$objUser->getid().'">
                           '.contrexx_raw2xhtml($userName).'</option>';
                        }

                        $objUser->next();
                    }
                }


                /*if($objinit->mode == 'backend') {
                    $straddnewbutton = '';
                    $strrefreshnewbutton = '';
                    //$strstyle = 'style="overflow: auto; border: 1px solid #0a50a1; background-color: #ffffff; width: 298px; height: 200px; float: left; list-style: none; padding: 0px; margin: 0px 5px 0px 0px;"';
                } else {
                    $straddnewbutton = '<a rel="shadowbox['.$intid.'];height=500;width=650;options={onclose:new function(\'refreshselector_'.$intid.'(\\\''.$intid.'\\\', \\\''.$this->modulename.'inputfield_deselected_'.$intid.'\\\', \\\''.$this->modulename.'inputfield_'.$intid.'\\\',  \\\''.$_get['section'].'\\\', \\\''.$_get['cmd'].'\\\', \\\''.$intentryid.'\\\')\')}" href="index.php?section=marketplace&amp;cmd=adduser"><img src="cadmin/images/icons/user_add.gif" style="cursor: pointer;  border: 0px;" />&nbsp;'.$_arraylang['txt_mediadir_add_entry'].'</a>';
                    $strrefreshnewbutton = '<br /><a href="javascript:refreshselector_'.$intid.'(\''.$intid.'\', \''.$this->modulename.'inputfield_deselected_'.$intid.'\', \''.$this->modulename.'inputfield_'.$intid.'\', \''.$_get['section'].'\', \''.$_get['cmd'].'\', \''.$intentryid.'\');"><img src="cadmin/images/icons/refresh.gif" style="cursor: pointer;  border: 0px;" />&nbsp;'.$_arraylang['txt_mediadir_refresh'].'</a>';
                    //$strstyle = 'style="overflow: auto; float: left; list-style: none; padding: 0px; margin: 0px 5px 0px 0px;"';
                }*/

                if($objInit->mode == 'backend') {
                    $strAddNewButton = '';
                    //$strRefreshNewButton = '';
                    //$strStyle = 'style="overflow: auto; border: 1px solid #0A50A1; background-color: #ffffff; width: 298px; height: 200px; float: left; list-style: none; padding: 0px; margin: 0px 5px 0px 0px;"';
                } else {
                    $strAddNewButton = '<a rel="shadowbox['.$intId.'];height=500;width=650;options={onClose:new Function(\'refreshSelector_'.$intId.'(\\\''.$intId.'\\\', \\\''.$this->moduleName.'Inputfield_deselected_'.$intId.'\\\', \\\''.$this->moduleName.'Inputfield_'.$intId.'\\\',  \\\''.$_GET['section'].'\\\', \\\''.$_GET['cmd'].'\\\', \\\''.$intEntryId.'\\\')\')}" href="index.php?section=marketplace&amp;cmd=adduser"><img src="cadmin/images/icons/icon-user-add.png" style="cursor: pointer;  border: 0px;" />&nbsp;'.$_ARRAYLANG['TXT_MEDIADIR_ADD_ENTRY'].'</a>';
                    //$strRefreshNewButton = '<br /><a href="javascript:refreshSelector_'.$intId.'(\''.$intId.'\', \''.$this->moduleName.'Inputfield_deselected_'.$intId.'\', \''.$this->moduleName.'Inputfield_'.$intId.'\', \''.$_GET['section'].'\', \''.$_GET['cmd'].'\', \''.$intEntryId.'\');"><img src="cadmin/images/icons/refresh.gif" style="cursor: pointer;  border: 0px;" />&nbsp;'.$_ARRAYLANG['TXT_MEDIADIR_REFRESH'].'</a>';
                    //$strStyle = 'style="overflow: auto; float: left; list-style: none; padding: 0px; margin: 0px 5px 0px 0px;"';
                }




                /*$strSelectorWrapperClass = $this->moduleName.'Selector';
                $strSelectorListClass = $this->moduleName.'SelectorList_'.$intId;
                $strSelectorId = $this->moduleName.'Inputfield_'.$intId.'_Selector';
                $strSelectorFunction = $this->moduleName.'Inputfield_'.$intId.'_Selector';
                $strSerializeFunction = $this->moduleName.'Inputfield_'.$intId.'_SelectorSerialize';
                $strSelectedId = 'selectedInputfield_'.$intId.'_List';
                $strNotSelectedId = 'deselectedInputfield_'.$intId.'_List';
                $strInpufieldId = $this->moduleName.'Inputfield_'.$intId;
                $strInpufieldName = $this->moduleName.'Inputfield['.$intId.']';
                $strParentLeftName = 'oParent'.$intId.'_';
                $strParentRightName = 'Parent'.$intId.'_';
                $strChildName = 'child'.$intId.'_';

                $listElementsJSON = json_encode($arrSelectedList);*/

                /*$strInputfield = '<div class="'.$strSelectorWrapperClass.'" style="overflow: hidden;">';
                $strInputfield .= '<ul id="'.$strNotSelectedId.'" class="'.$strSelectorListClass.'" '.$strStyle.'>';
                $strInputfield .= '</ul>';
                $strInputfield .= '<ul id="'.$strSelectedId.'" class="'.$strSelectorListClass.'"  '.$strStyle.'>';
                $strInputfield .= '</ul><br />';
                $strInputfield .= '<input type="hidden" value="" id="'.$strInpufieldId.'" name="'.$strInpufieldName.'" />';
                $strInputfield .= '</div>';
                $strInputfield .= '<div class="'.$strSelectorWrapperClass.'Add">'.$strAddNewButton.'</div>';*/



                /*$strInputfield = '
                    <div class="marketplaceSelector">
                    <div id="selectedInputfield_'.$intId.'_Left" class="ListBoxForm drop"></div>
                    <div id="selectedInputfield_'.$intId.'_Right" class="ListBoxForm drop"></div>
                    </div>
                    <input type="hidden" value="" id="'.$strInpufieldId.'" name="'.$strInpufieldName.'" />
                ';
                $strInputfield .= '<div class="'.$strSelectorWrapperClass.'Add">'.$strAddNewButton.'</div>';*/


                $strInputfield .= <<< EOF
<script type="text/javascript">
// <![CDATA[
/*	\$J(document).ready(function() {
		JSONData['marketplaceData_$intId'] 	= $listElementsJSON;
		InsertJSONdataIntoElement(JSONData['marketplaceData_$intId'], 'selectedInputfield_{$intId}_Left', 'selectedInputfield_{$intId}_Right', 0, 0, 'marketplaceData_$intId');
		InsertJSONdataIntoElement(JSONData['marketplaceData_$intId'], 'selectedInputfield_{$intId}_Right', 'selectedInputfield_{$intId}_Left', 1, 0, 'marketplaceData_$intId');
		InitDrag();
	});

    var $strSerializeFunction = function() {
        \$J('#$strInpufieldId').val(marketplaceGetElList(\$J('#selectedInputfield_{$intId}_Right')));
    }

    function searchElement(elementId, term){
        elmSelector = document.getElementById(elementId);

        var pattern = term.toLowerCase()
        var reg = new RegExp(pattern);

        for (i = 0; i < elmSelector.length; ++i) {
            var text = elmSelector.options[i].text.toLowerCase()

            if (text.match(reg)) {
                elmSelector.options[i].selected = true;
            } else {
                elmSelector.options[i].selected = false;
            }
        }
    }

    function refreshSelector_$intId(fieldId,elementDeselectedId,elementSelectedId,pageSection,pageCmd,entryId) {
        \$J.ajax({
            url: 'index.php?section=' + pageSection + '&cmd=' + pageCmd + '&inputfield=refresh&field=' + fieldId + '&eid=' +  entryId,
            success:function(data){
                eval("JSONData['marketplaceData_$intId'] " + data);
                InsertJSONdataIntoElement(JSONData['marketplaceData_$intId'], 'selectedInputfield_{$intId}_Left', 'selectedInputfield_{$intId}_Right', 0, 0, 'marketplaceData_$intId');
                InsertJSONdataIntoElement(JSONData['marketplaceData_$intId'], 'selectedInputfield_{$intId}_Right', 'selectedInputfield_{$intId}_Left', 1, 0, 'marketplaceData_$intId');
                InitDrag();
            }
        });
    }


function searchElement(elementId, term){
    elmSelector = document.getElementById(elementId);

    var pattern = term.toLowerCase()
    var reg = new RegExp(pattern);

    for (i = 0; i < elmSelector.length; ++i) {
        var text = elmSelector.options[i].text.toLowerCase()

        if (text.match(reg)) {
            elmSelector.options[i].selected = true;
        } else {
            elmSelector.options[i].selected = false;
    }
    }
}

function refreshSelector_$intId(fieldId,elementDeselectedId,elementSelectedId,pageSection,pageCmd,entryId) {
    cx.jQuery.get('index.php', {section : pageSection, cmd : pageCmd,  inputfield : 'refresh', field : fieldId, eid : entryId}).success(function(response) {
        var arrResponse = response.split("|");
        cx.jQuery('#'+elementDeselectedId).html(arrResponse[0]);
        cx.jQuery('#'+elementSelectedId).html(arrResponse[1]);
    });
}

// ]]>
</script>
EOF;

                $strInputfield .= '<div id="'.$this->moduleName.'Selector_'.$intId.'" class="'.$this->moduleName.'Selector" style="float: left; height: auto !important;">';
                $strInputfield .= '<div id="'.$this->moduleName.'Selector_'.$intId.'_Left" class="'.$this->moduleName.'SelectorLeft" style="float: left; height: auto !important;"><select id="'.$this->moduleName.'Inputfield_deselected_'.$intId.'" name="'.$this->moduleName.'Inputfield[deselected_'.$intId.'][]" size="12" multiple="multiple" style="width: 240px;">';
                $strInputfield .= $strSelectorNotSelected;
                $strInputfield .= '</select><br />';
                $strInputfield .= $strAddNewButton;
                $strInputfield .= '</div>';
                //$strInputfield .= '</select><br /><input class="'.$this->moduleName.'SelectorSearch" type="text" onclick="this.value=\'\';" onkeyup="searchElement(\''.$this->moduleName.'Inputfield_deselected_'.$intId.'\', this.value);" value="Suchbegriff..."  style="width: 178px;"/></div>';
                $strInputfield .= '<div class="'.$this->moduleName.'SelectorCenter" style="float: left; height: 100px; padding: 60px 10px 0px 10px;">';
                $strInputfield .= '<input style="width: 40px; min-width: 40px;" value=" &gt;&gt; " name="addElement" onclick="moveElement(document.entryModfyForm.elements[\''.$this->moduleName.'Inputfield_deselected_'.$intId.'\'],document.entryModfyForm.elements[\''.$this->moduleName.'Inputfield_'.$intId.'\'],addElement,removeElement);" type="button" />';
                $strInputfield .= '<br />';
                $strInputfield .= '<input style="width: 40px; min-width: 40px;" value=" &lt;&lt; " name="removeElement" onclick="moveElement(document.entryModfyForm.elements[\''.$this->moduleName.'Inputfield_'.$intId.'\'],document.entryModfyForm.elements[\''.$this->moduleName.'Inputfield_deselected_'.$intId.'\'],removeElement,addElement);" type="button" />';
                $strInputfield .= '</div>';
                $strInputfield .= '<div id="'.$this->moduleName.'Selector_'.$intId.'_Right" class="'.$this->moduleName.'SelectorRight" style="float: left; height: auto !important;"><select id="'.$this->moduleName.'Inputfield_'.$intId.'" name="'.$this->moduleName.'Inputfield['.$intId.'][]" size="12" multiple="multiple" style="width: 240px;">';
                $strInputfield .= $strSelectorSelected;
                $strInputfield .= '</select></div>';
                $strInputfield .= '</div>';

                $strInputfield .= <<<EOF
<script type="text/javascript">
</script>
EOF;
               

                return $strInputfield;

                break;
            case 2:
                //search View

               return $strInputfield;

               break;
             case 3:
                // OSEC CUSTOMIZING
                //ajax reload
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
                    $strValue = $objInputfieldValue->fields['value'];
                } else {
                    $strValue = null;
                }

                $arrValue = explode(',',$strValue);

                //$strFormType = empty($arrInputfield['default_value'][$_LANGID]) ? $arrInputfield['default_value'][0] : $arrInputfield['default_value'][$_LANGID];
                //$arrSelectorOptions = array();

                $strSelectorNotSelected = "";
                $strSelectorSelected = "";

                $userFilter = array();
                if (!FWUser::getFWUserObject()->objUser->getAdminStatus()) {
                    $userFilter = array('contact_user_id' => FWUser::getFWUserObject()->objUser->getId());
                    //$userFilter = array('contact_user_id' => FWUser::getFWUserObject()->objUser->getId(), 'id' => FWUser::getFWUserObject()->objUser->getId());
                }

                //$arrSelectedList = array();
                $objUser = FWUser::getFWUserObject()->objUser->getUsers($userFilter, null, null, array('company', 'firstname', 'lastname'));
                if ($objUser) {
                    while (!$objUser->EOF) {
                        $userName = $objUser->getProfileAttribute('company').', '
                                    .$objUser->getProfileAttribute('lastname').' '
                                    .$objUser->getProfileAttribute('firstname');
                        /*$arrSelectedList[$objUser->getId()] = array(
                            'name'      => $userName,
                            'class'     => "childCategory_".$intId."_".intval($objUser->getId()),
                            'id'        => (in_array($objUser->getId(), $arrValue) ? '' : 'o')."childCategory".$intId."_".intval($objUser->getId()),
                            'selected'  => intval(in_array($objUser->getId(), $arrValue))
                        );*/
                        if(!in_array($objUser->getId(), $arrValue)) {
                           $strSelectorNotSelected .= '<option  value="'.$objUser->getId().'">
                           '.contrexx_raw2xhtml($userName).'</option>';
                        } else {
                            $strSelectorSelected .= '<option  value="'.$objUser->getId().'">
                           '.contrexx_raw2xhtml($userName).'</option>';
                        }

                        $objUser->next();
                    }
                }

                //die(json_encode($arrSelectedList));*/

                echo $strSelectorNotSelected."|".$strSelectorSelected;
                exit;

                break;
        }
    }


    /*function saveInputfield($intInputfieldId, $strValue)
    {
        $strValue = join(',', array_map('intval', explode(',', $strValue)));
        return $strValue;
    }*/
    function saveInputfield($intInputfieldId, $arrValue)
    {
        $strValue = contrexx_strip_tags(contrexx_input2raw(join(",", $arrValue)));
        return $strValue;
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
        //$objEntryDefaultLang = $objDatabase->Execute("SELECT `lang_id` FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_entries WHERE id=".intval($intEntryId)." LIMIT 1");
        //$intEntryDefaultLang = intval($objEntryDefaultLang->fields['lang_id']);
        $strValueOutputCustom = '';
        $strValueOutput = '';

        /*if($this->arrSettings['settingsTranslationStatus'] == 1) {
	        if(in_array($_LANGID, $arrTranslationStatus)) {
	        	$intLangId = $_LANGID;
	        } else {
	        	$intLangId = $intEntryDefaultLang;
	        }
        } else {
        	$intLangId = $_LANGID;
        }*/

       $objInputfield = $objDatabase->Execute("
          SELECT
             `value`
          FROM
             ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_inputfields
          WHERE
             ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_inputfields.lang_id = ".$_LANGID."
          AND
             ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_inputfields.field_id = '".$intId."'
          AND
             ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_inputfields.entry_id = '".$intEntryId."'");

        $strValue = $objInputfield->fields['value'];

        $arrValue = explode(',',$strValue);

        if(!empty($strValue)) {
            $arrContent['TXT_'.$this->moduleLangVar.'_INPUTFIELD_NAME'] = $_ARRAYLANG['TXT_'.$this->moduleLangVar.'_CONTACTPERSON'];

            foreach($arrValue as $intUserId) {
                $objUser = FWUser::getFWUserObject()->objUser->getUser($intUserId);
                if ($objUser) {
               	  if($objUser->getProfileAttribute('firstname') != "" && $objUser->getProfileAttribute('lastname') != "") {
               	  	 $strValueOutput .= '<li><a href="index.php?section=access&amp;cmd=user&amp;id='.$intUserId.'">'.contrexx_raw2xhtml($objUser->getProfileAttribute('firstname').' '.$objUser->getProfileAttribute('lastname')).'</a></li>';
		             $strValueOutputCustom .= contrexx_raw2xhtml($objUser->getProfileAttribute('firstname').' '.$objUser->getProfileAttribute('lastname')).'<br />';
//		             $strValueOutputCustom .= ($objUser->getProfileAttribute('address') != "") ? $objUser->getProfileAttribute('address').'<br />' : '';
//		             $strValueOutputCustom .= ($objUser->getProfileAttribute('zip') != "" && $objUser->getProfileAttribute('city') != "") ? $objUser->getProfileAttribute('zip').' '.$objUser->getProfileAttribute('city').'<br />' : '';
//		             $strValueOutputCustom .= ($objUser->getProfileAttribute('phone_office') != "") ? $objUser->getProfileAttribute('phone_office').'<br />' : '';
		             $strValueOutputCustom .= $objUser->getProfileAttribute('1') ? htmlentities($objUser->objAttribute->getById($objUser->getProfileAttribute('1'))->getName(), ENT_QUOTES, CONTREXX_CHARSET).'<br />' : '';
		             //$strValueOutputCustom .= '<a href="mailto:'.$objUser->getEmail().'">'.$_ARRAYLANG['TXT_MEDIADIR_GET_IN_CONTACT'].'</a><br />';
		             $strValueOutputCustom .= '<a rel="shadowbox;player=iframe;width=700;height=650" href="teilnehmer_kontakt?13='.$objUser->getId().'&amp;14='.urlencode($objUser->getProfileAttribute('company').', '.$objUser->getProfileAttribute('firstname').' '.$objUser->getProfileAttribute('lastname')).'">'.$_ARRAYLANG['TXT_MEDIADIR_GET_IN_CONTACT'].'</a><br />';
		             $strValueOutputCustom .= '<br />';
               	  }
               }
            }
            if(strlen($strValueOutput) > 0) {
            	$strValueOutput = '<ul class="'.$this->moduleName.'InputfieldAccounts">'.$strValueOutput.'</ul>';
            }
            $arrContent[$this->moduleLangVar.'_INPUTFIELD_VALUE'] = $strValueOutput;
            $arrContent[$this->moduleLangVar.'_INPUTFIELD_VALUE_CUSTOM'] = $strValueOutputCustom;
            $arrContent[$this->moduleLangVar.'_INPUTFIELD_ADD_CLIENT'] = '<a rel="shadowbox;height=760;width=920"  href="index.php?section=marketplace&cmd=adduser">Add New User</a>';


        } else {
            $arrContent = null;
        }
		$strValueOutput = "";
		$strValueOutputCustom = "";

        return $arrContent;
    }


    function getJavascriptCheck()
    {
        $fieldName = $this->moduleName."Inputfield_";
        $strJavascriptCheck = <<<EOF

            case 'accounts':
                name =  inputFields[field][0];
                value = document.getElementById('$fieldName' + field).value;
                if (value == "" && isRequiredGlobal(inputFields[field][1], value)) {
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
    	//return $this->moduleName.'Inputfield_'.$intInputfieldId.'_SelectorSerialize(); ';
        return "selectAll(document.entryModfyForm.elements['".$this->moduleName."Inputfield[".$intInputfieldId."][]']); ";
    }
}
