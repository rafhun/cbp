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
 * Media  Directory Inputfield Relation Class
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
 * Media Directory Inputfield Relation Class
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_mediadir
 */
class mediaDirectoryInputfieldRelation extends mediaDirectoryLibrary implements inputfield
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
                            $arrValue[intval($objInputfieldValue->fields['lang_id'])] = htmlspecialchars($objInputfieldValue->fields['value'], ENT_QUOTES, CONTREXX_CHARSET);
                            $objInputfieldValue->MoveNext();
                        }
                        $arrValue[0] = $arrValue[$_LANGID];
                    }
                } else {
                    $arrValue = null;
                }

                if(empty($arrValue)) {
                    $arrValue[0] = empty($arrInputfield['default_value'][$_LANGID]) ? $arrInputfield['default_value'][0] : $arrInputfield['default_value'][$_LANGID];
                }

                if($objInit->mode == 'backend') {


                   // get value
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
                            $arrValue[intval($objInputfieldValue->fields['lang_id'])] = htmlspecialchars($objInputfieldValue->fields['value'], ENT_QUOTES, CONTREXX_CHARSET);
                            $objInputfieldValue->MoveNext();
                        }
                        $arrValue[0] = $arrValue[$_LANGID];
                    }


                   if($arrValue[0] != "" && intval($arrValue[0])) {
                   	  $strWhere = "AND form_id = '".$arrValue[0]."'";
                   } else {
                   	  $strWhere = "";
                   }

                   // get forms
				   $objInputfieldValue = $objDatabase->Execute("
                       SELECT
                          `id`,
                          `form_name`
                       FROM
                          ".DBPREFIX."module_".$this->moduleTablePrefix."_forms
                       LEFT JOIN
                          ".DBPREFIX."module_".$this->moduleTablePrefix."_form_names
                       ON
                          ".DBPREFIX."module_".$this->moduleTablePrefix."_forms.id = ".DBPREFIX."module_".$this->moduleTablePrefix."_form_names.form_id
                       WHERE
                          lang_id = ".$_LANGID."
                       ".$strWhere."");

				   if ($objInputfieldValue !== false) {
				   	  $arrInputfieldOption = array();
				   	  $HeadingStyle = 'background:#dddddd; color:#000000; font-weight:900;';
                      while (!$objInputfieldValue->EOF) {
                         $arrInputfieldOption[] = '<option value="" disabled="disabled" style="'.$HeadingStyle.'">'.$objInputfieldValue->fields['form_name'].'</option>';

                         $query = "SELECT
					                    inputfield.`id` AS `id`
					                FROM
					                    ".DBPREFIX."module_".$this->moduleTablePrefix."_inputfields AS inputfield
					                WHERE
					                    (inputfield.`type` != 16 AND inputfield.`type` != 17)
					                AND
					                    (inputfield.`form` = ".DBPREFIX."module_".$this->moduleTablePrefix."_entries.`form_id`)
					                ORDER BY
					                    inputfield.`order` ASC
					                LIMIT 1";

                           // get entries from forms
                           $objInputfieldValueSub = $objDatabase->Execute("
	                          SELECT
	                             `id`,
	                             `value`
	                          FROM
	                             ".DBPREFIX."module_".$this->moduleTablePrefix."_entries
	                          LEFT JOIN
	                             ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_inputfields
	                          ON
	                             ".DBPREFIX."module_".$this->moduleTablePrefix."_entries.id = ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_inputfields.entry_id
	                          WHERE
	                             ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_inputfields.lang_id = ".$_LANGID."
	                             AND ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_inputfields.form_id = '".$objInputfieldValue->fields['id']."'
	                             AND (".$query.") = ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_inputfields.field_id
	                           ");

						   if ($objInputfieldValueSub !== false) {
	                          while (!$objInputfieldValueSub->EOF) {
	                          	 $selected = ($arrValue[0] == $objInputfieldValueSub->fields['id']) ? 'selected="selected"' : '';
	                             $arrInputfieldOption[] = '<option value="'.$objInputfieldValueSub->fields['id'].'" '.$selected.'>-- '.$objInputfieldValueSub->fields['value'].'</option>';
								 $objInputfieldValueSub->MoveNext();
	                          }
	                       }

						 $objInputfieldValue->MoveNext();
                      }
                   }

				   $strInputfield = '<select name="'.$this->moduleName.'Inputfield['.$intId.']" id="'.$this->moduleName.'Inputfield_'.$intId.'" class="'.$this->moduleName.'InputfieldRelation" style="width:302px;">';
				   foreach($arrInputfieldOption as $option) {
				   	  $strInputfield .= $option;
				   }
				   $strInputfield .= '</select>';


                } else {
                    //$strInputfield = '<input type="text" name="'.$this->moduleName.'Inputfield['.$intId.'][0]" id="'.$this->moduleName.'Inputfield_'.$intId.'_0" class="'.$this->moduleName.'InputfieldText" value="'.$arrValue[0].'" onfocus="this.select();" />';
                	$strInputfield = '<a href="">REFERENZ</a>';
                }

                return $strInputfield;

                break;
            case 2:
                //search View
                $strValue = isset($_GET[$intId]) ? $_GET[$intId] : '';

			   // get forms
			   $objInputfieldValue = $objDatabase->Execute("
                   SELECT
                      `id`,
                      `form_name`
                   FROM
                      ".DBPREFIX."module_".$this->moduleTablePrefix."_forms
                   LEFT JOIN
                      ".DBPREFIX."module_".$this->moduleTablePrefix."_form_names
                   ON
                      ".DBPREFIX."module_".$this->moduleTablePrefix."_forms.id = ".DBPREFIX."module_".$this->moduleTablePrefix."_form_names.form_id
                   WHERE
                      lang_id = ".$_LANGID."");

			   if ($objInputfieldValue !== false) {
			   	  $arrInputfieldOption = array();
                  while (!$objInputfieldValue->EOF) {
                     $arrInputfieldOption[] = '<option value="" disabled="disabled" >'.$objInputfieldValue->fields['form_name'].'</option>';

                       // get entries from forms
                       $objInputfieldValueSub = $objDatabase->Execute("
                          SELECT
                             `id`,
                             `value`
                          FROM
                             ".DBPREFIX."module_".$this->moduleTablePrefix."_entries
                          LEFT JOIN
                             ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_inputfields
                          ON
                             ".DBPREFIX."module_".$this->moduleTablePrefix."_forms.id = ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_inputfields.form_id
                          WHERE
                             lang_id = ".$_LANGID."
                             AND form_id = '".$objInputfieldValue->fields['id']."'
                           ");

					   if ($objInputfieldValueSub !== false) {
                          while (!$objInputfieldValueSub->EOF) {
                          	 $selected = ($objInputfieldValueSub == $strValue) ? 'selected = "selected"' : '';
                             $arrInputfieldOption[] = '<option value="'.$objInputfieldValueSub->fields['id'].'" '.$selected.'>-- '.$objInputfieldValueSub->fields['value'].'</option>';
							 $objInputfieldValueSub->MoveNext();
                          }
                       }

					 $objInputfieldValue->MoveNext();
                  }
               }

			   $strInputfield = '<select name="'.$this->moduleName.'Inputfield['.$intId.']" id="'.$this->moduleName.'Inputfield_'.$intId.'" class="'.$this->moduleName.'InputfieldRelation" style="width:302px;">';
			   foreach($arrInputfieldOption as $option) {
			   	  $strInputfield .= $option;
			   }
			   $strInputfield .= '</select>';

               return $strInputfield;

               break;
        }
    }



    function saveInputfield($intInputfieldId, $intValue)
    {
        $intValue = intval($intValue);
        return $intValue;
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

       $objInputfield = $objDatabase->Execute("
          SELECT
             `value`
          FROM
             ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_inputfields
          WHERE
             ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_inputfields.lang_id = ".$_LANGID."
          AND
             ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_inputfields.field_id = '".$intId."'");

       	$intEntryId = intval($objInputfield->fields['value']);

		$objEntry = new mediaDirectoryEntry;
		$objEntry->getEntries($intEntryId);
		$strEntryValue = $objEntry->arrEntries[$intEntryId]['entryFields'][0];

        if(!empty($strEntryValue)) {
            $arrContent['TXT_'.$this->moduleLangVar.'_INPUTFIELD_NAME'] = htmlspecialchars($arrInputfield['name'][0], ENT_QUOTES, CONTREXX_CHARSET);
            $arrContent[$this->moduleLangVar.'_INPUTFIELD_VALUE'] = '<a href="index.php?section='.$this->moduleName.'&cmd=detail&amp;eid='.$intEntryId.'">'.$strEntryValue.'</a>';

        } else {
            $arrContent = null;
        }

        return $arrContent;
    }


    function getJavascriptCheck()
    {
        return NULL;
    }
    
    
    function getFormOnSubmit($intInputfieldId)
    {
        return null;
    }
}
