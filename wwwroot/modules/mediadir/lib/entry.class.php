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
 * Media  Directory Entry Class
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Comvation Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_mediadir
 * @todo        Edit PHP DocBlocks!
 */

/**
 * Media Directory Entry Class
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_mediadir
 */
class mediaDirectoryEntry extends mediaDirectoryInputfield
{
    private $intEntryId;
    private $intLevelId;
    private $intCatId;
    private $strSearchTerm;
    private $bolLatest;
    private $bolUnconfirmed;
    private $bolActive;
    private $intLimitStart;
    private $intLimitEnd;
    private $intUserId;
    private $bolPopular;
    private $intCmdFormId;
    private $bolReadyToConfirm;
    private $intLimit;
    private $intOffset;

    private $arrSubCategories = array();
    private $arrSubLevels = array();
    private $strBlockName;

    public $arrEntries = array();
    public $recordCount = 0;

    /**
     * Constructor
     */
    function __construct()
    {
        /*if($bolGetEnties == 1) {
            $this->arrEntries = self::getEntries();
        }*/

        parent::getSettings();
        parent::getFrontendLanguages();
    }

    function getEntries($intEntryId=null, $intLevelId=null, $intCatId=null, $strSearchTerm=null, $bolLatest=null, $bolUnconfirmed=null, $bolActive=null, $intLimitStart=null, $intLimitEnd='n', $intUserId=null, $bolPopular=null, $intCmdFormId=null, $bolReadyToConfirm=null, $intLimit=0, $intOffset=0)
    {
        global $_ARRAYLANG, $_CORELANG, $objDatabase, $_LANGID, $objInit;
 
        $this->intEntryId = intval($intEntryId);
        $this->intLevelId = intval($intLevelId);
        $this->intCatId = intval($intCatId);
        $this->bolLatest = intval($bolLatest);
        $this->bolUnconfirmed = intval($bolUnconfirmed);
        $this->bolActive = intval($bolActive);
        $this->strBlockName = null;
        $this->intLimitStart = intval($intLimitStart);
        $this->intLimitEnd = $intLimitEnd;
        $this->intUserId = intval($intUserId);
        $this->bolPopular = intval($bolPopular);
        $this->intCmdFormId = intval($intCmdFormId);
        $this->bolReadyToConfirm = intval($bolReadyToConfirm);
        $this->intLimit = intval($intLimit);
        $this->intOffset = intval($intOffset);

		$strWhereEntryId = '';
		$strWhereLevel = '';
		$strFromLevel = '';
		$strWhereActive = '';
		$strWhereTerm = '';
		$strWhereLangId = '';
		$strWhereFormId = '';
		$strFromCategory = '';
		$strWhereCategory = '';
        $strOrder = "rel_inputfield.`value` ASC";

        if(($strSearchTerm != $_ARRAYLANG['TXT_MEDIADIR_ID_OR_SEARCH_TERM']) && !empty($strSearchTerm)) {
            $this->strSearchTerm = contrexx_addslashes($strSearchTerm);
        } else {
            $this->strSearchTerm = null;
        }

        if($this->intCmdFormId != 0) {
            $strWhereFormId = "AND (entry.`form_id` = ".$this->intCmdFormId.") ";
        }

        if(!empty($this->intEntryId)) {
            $strWhereEntryId = "AND (entry.`id` = ".$this->intEntryId.") ";
        }


        if(!empty($this->intUserId)) {
            $strWhereEntryId = "AND (entry.`added_by` = ".$this->intUserId.") ";
        }

        if(!empty($this->intLevelId)) {
            $strWhereLevel = "AND ((level.`level_id` = ".$this->intLevelId.") AND (level.`entry_id` = entry.`id`)) ";
            $strFromLevel = " ,".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_levels AS level";
        }

        if(!empty($this->intCatId)) {
        	$strWhereCategory = "AND ((category.`category_id` = ".$this->intCatId.") AND (category.`entry_id` = entry.`id`)) ";
        	$strFromCategory = " ,".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_categories AS category";
        }

        if(!empty($this->bolLatest)) {
            $strOrder = "entry.`validate_date` DESC";
            $this->strBlockName = $this->moduleName."LatestList";
        }

        if(!empty($this->bolPopular)) {
            $strOrder = "entry.`popular_hits` DESC";
        }                                                  
        
        if(empty($this->bolLatest) && empty($this->bolPopular) && $this->arrSettings['settingsIndividualEntryOrder'] == 1) {
            $strOrder = "entry.`order` ASC, rel_inputfield.`value` ASC";
        }

        if(!empty($this->bolUnconfirmed)) {
            $strWhereUnconfirmed = "AND (entry.`confirmed` = 0) ";
            $this->strBlockName = $this->moduleName."ConfirmList";

            if(!empty($this->bolReadyToConfirm)) {
                $strWhereReadyToConfirm = "AND (entry.`ready_to_confirm` = '1' AND entry.`confirmed` = 0) ";
            } else {
                $strWhereReadyToConfirm = '';
            }
        } else {
            if(!empty($this->bolReadyToConfirm)) {
                $strWhereReadyToConfirm = "AND ((entry.`ready_to_confirm` = '0' AND entry.`confirmed` = 0) OR (entry.`confirmed` = 1)) ";
                $strWhereUnconfirmed = "";
            } else {
                $strWhereUnconfirmed = "AND (entry.`confirmed` = 1) ";
                $strWhereReadyToConfirm = "";
            }
        }

        if(!empty($this->bolActive)) {
            $strWhereActive = "AND (entry.`active` = 1) ";
        }

        if(empty($this->intLimitStart) && $this->intLimitStart == 0) {
            $strSelectLimit = "LIMIT ".$this->intLimitEnd;
        } else {
            $strSelectLimit = "LIMIT ".$this->intLimitStart.",".$this->intLimitEnd;
        }

        if($this->intLimitEnd === 'n') {
            $strSelectLimit = '';
        }

        if(empty($this->strSearchTerm)) {
            $query = "
                SELECT
                    first_rel_inputfield.`field_id` AS `id`
                FROM
                    ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_inputfields AS first_rel_inputfield
                LEFT JOIN
                    ".DBPREFIX."module_".$this->moduleTablePrefix."_inputfields AS inputfield
                ON 
                    first_rel_inputfield.`field_id` = inputfield.`id`
                WHERE
                    (inputfield.`type` != 16 AND inputfield.`type` != 17 AND inputfield.`type` != 30)
                AND
                    (first_rel_inputfield.`entry_id` = entry.`id`)
                AND 
                    (first_rel_inputfield.`form_id` = entry.`form_id`)
                ORDER BY
                    inputfield.`order` ASC
                LIMIT 1
            ";

            $strWhereFirstInputfield = "AND (rel_inputfield.`form_id` = entry.`form_id`) AND (rel_inputfield.`field_id` = (".$query.")) AND (rel_inputfield.`lang_id` = '".$_LANGID."')";
        } else {
            $strWhereTerm = "AND ((rel_inputfield.`value` LIKE '%".$this->strSearchTerm."%') OR (entry.`id` = '".$this->strSearchTerm."')) ";
            $strWhereFirstInputfield = '';
            $this->strBlockName = "";
        }

        if(empty($this->strBlockName)) {
            $this->strBlockName = $this->moduleName."EntryList";
        }

        if($objInit->mode == 'frontend') {
	        if(intval($this->arrSettings['settingsShowEntriesInAllLang']) == 0) {
	        	$strWhereLangId = "AND (entry.`lang_id` = ".$_LANGID.") ";
	        }
        }
        
        $strLimit  = '';
        $strOffset = '';
        if ($this->intLimit > 0) {
            $strLimit = 'LIMIT ' . $this->intLimit;
        }
        if ($this->intOffset > 0) {
            $strOffset = 'OFFSET ' . $this->intOffset;
        }
        
        if($objInit->mode == 'frontend') {
            $strWhereDuration = "AND (`duration_type` = 1 OR (`duration_type` = 2 AND (`duration_start` < '" . time() . "' AND `duration_end` > '" . time() . "'))) ";
        } else {
            $strWhereDuration = null;
        }

        $query = "
            SELECT
                entry.`id` AS `id`,
                entry.`order` AS `order`,
                entry.`form_id` AS `form_id`,
                entry.`create_date` AS `create_date`,
                entry.`update_date` AS `update_date`,
                entry.`validate_date` AS `validate_date`,
                entry.`added_by` AS `added_by`,
                entry.`updated_by` AS `updated_by`,
                entry.`lang_id` AS `lang_id`,
                entry.`hits` AS `hits`,
                entry.`popular_hits` AS `popular_hits`,
                entry.`popular_date` AS `popular_date`,
                entry.`last_ip` AS `last_ip`,
                entry.`confirmed` AS `confirmed`,
                entry.`active` AS `active`,
                entry.`duration_type` AS `duration_type`,
                entry.`duration_start` AS `duration_start`,
                entry.`duration_end` AS `duration_end`,
                entry.`duration_notification` AS `duration_notification`,
                entry.`translation_status` AS `translation_status`,
                entry.`ready_to_confirm` AS `ready_to_confirm`,
                rel_inputfield.`value` AS `value`
            FROM
                ".DBPREFIX."module_".$this->moduleTablePrefix."_entries AS entry,
                ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_inputfields AS rel_inputfield
                ".$strFromCategory."
                ".$strFromLevel."
            WHERE
                (rel_inputfield.`entry_id` = entry.`id`)
                ".$strWhereFirstInputfield."
                ".$strWhereTerm."
                ".$strWhereUnconfirmed."
                ".$strWhereCategory."
                ".$strWhereLevel."
                ".$strWhereEntryId."
                ".$strWhereActive."
                ".$strWhereLangId."
                ".$strWhereFormId."
                ".$strWhereReadyToConfirm."
                ".$strWhereDuration."
            GROUP BY
                entry.`id`
            ORDER BY
                ".$strOrder."
                ".$strSelectLimit."
            ".$strLimit."
            ".$strOffset."
        ";

        $objEntries = $objDatabase->Execute($query);

        $arrEntries = array();

        if ($objEntries !== false) {
            while (!$objEntries->EOF) {
                $arrEntry = array();
                $arrEntryFields = array();

                if(array_key_exists($objEntries->fields['id'], $arrEntries)) {
                    $arrEntries[intval($objEntries->fields['id'])]['entryFields'][] = !empty($objEntries->fields['value']) ? $objEntries->fields['value'] : '-';
                } else {
                    $arrEntryFields[] = !empty($objEntries->fields['value']) ? $objEntries->fields['value'] : '-';

                    $arrEntry['entryId'] = intval($objEntries->fields['id']);
                    $arrEntry['entryOrder'] = intval($objEntries->fields['order']);
                    $arrEntry['entryFormId'] = intval($objEntries->fields['form_id']);
                    $arrEntry['entryFields'] = $arrEntryFields;
                    $arrEntry['entryCreateDate'] = intval($objEntries->fields['create_date']);
                    $arrEntry['entryValdateDate'] = intval($objEntries->fields['validate_date']);
                    $arrEntry['entryAddedBy'] = intval($objEntries->fields['added_by']);
                    $arrEntry['entryHits'] = intval($objEntries->fields['hits']);
                    $arrEntry['entryPopularHits'] = intval($objEntries->fields['popular_hits']);
                    $arrEntry['entryPopularDate'] = intval($objEntries->fields['popular_date']);
                    $arrEntry['entryLastIp'] = htmlspecialchars($objEntries->fields['last_ip'], ENT_QUOTES, CONTREXX_CHARSET);
                    $arrEntry['entryConfirmed'] = intval($objEntries->fields['confirmed']);
                    $arrEntry['entryActive'] = intval($objEntries->fields['active']);
                    $arrEntry['entryDurationType'] = intval($objEntries->fields['duration_type']);
                    $arrEntry['entryDurationStart'] = intval($objEntries->fields['duration_start']);
                    $arrEntry['entryDurationEnd'] = intval($objEntries->fields['duration_end']);
                    $arrEntry['entryDurationNotification'] = intval($objEntries->fields['duration_notification']);
                    $arrEntry['entryTranslationStatus'] = explode(",",$objEntries->fields['translation_status']);
                    $arrEntry['entryReadyToConfirm'] = intval($objEntries->fields['ready_to_confirm']);

                    $this->arrEntries[$objEntries->fields['id']] = $arrEntry;
                }

                $objEntries->MoveNext();
            }

            $this->recordCount = $objEntries->RecordCount();
        }
    }



    function listEntries($objTpl, $intView)
    {
        global $_ARRAYLANG, $_CORELANG, $objDatabase;

        $objFWUser = FWUser::getFWUserObject();
        $intToday = mktime();

        switch ($intView) {
            case 1:
                //Backend View
                if(!empty($this->arrEntries)){
					$i = 0;
                    foreach ($this->arrEntries as $key => $arrEntry) {
                        if(intval($arrEntry['entryAddedBy']) != 0) {
                            if ($objUser = $objFWUser->objUser->getUser(intval($arrEntry['entryAddedBy']))) {
                                $strAddedBy = $objUser->getUsername();
                            } else {
                                $strAddedBy = "unknown";
                            }
                        } else {
                            $strAddedBy = "unknown";
                        }

                        if($arrEntry['entryActive'] == 1) {
                		    $strStatus = 'images/icons/status_green.gif';
                		    $intStatus = 0;

                		    if(($arrEntry['entryDurationStart'] > $intToday || $arrEntry['entryDurationEnd'] < $intToday) && $arrEntry['entryDurationType'] == 2) {
                		    	$strStatus = 'images/icons/status_yellow.gif';
                		    }
                		} else {
                		    $strStatus = 'images/icons/status_red.gif';
                		    $intStatus = 1;
                		}

                		$objForm = new mediaDirectoryForm($arrEntry['entryFormId']);

                        //get votes
                        if($this->arrSettings['settingsAllowVotes']) {
                            $objVoting = new mediaDirectoryVoting();
                            $objVoting->getVotes($objTpl, $arrEntry['entryId']);
                            if ($objTpl->blockExists('mediadirEntryVotes')) {
                                $objTpl->parse('mediadirEntryVotes');
                            }
                        } else {
                            if ($objTpl->blockExists('mediadirEntryVotes')) {
                                $objTpl->hideBlock('mediadirEntryVotes');
                            }
                        }

                        //get comments
                        if($this->arrSettings['settingsAllowComments']) {
                            $objComment = new mediaDirectoryComment();
                            $objComment->getComments($objTpl, $arrEntry['entryId']);
                            if ($objTpl->blockExists('mediadirEntryComments')) {
                                $objTpl->parse('mediadirEntryComments');
                            }
                        } else {
                            if ($objTpl->blockExists('mediadirEntryComments')) {
                                $objTpl->hideBlock('mediadirEntryComments');
                            }
                        }

                        $objTpl->setVariable(array(
                            $this->moduleLangVar.'_ROW_CLASS' =>  $i%2==0 ? 'row1' : 'row2',
                            $this->moduleLangVar.'_ENTRY_ID' =>  $arrEntry['entryId'],
                            $this->moduleLangVar.'_ENTRY_STATUS' => $strStatus,
                            $this->moduleLangVar.'_ENTRY_SWITCH_STATUS' => $intStatus,
                            $this->moduleLangVar.'_ENTRY_VALIDATE_DATE' =>  date("H:i:s - d.m.Y",$arrEntry['entryValdateDate']),
                            $this->moduleLangVar.'_ENTRY_CREATE_DATE' =>  date("H:i:s - d.m.Y",$arrEntry['entryCreateDate']),
                            $this->moduleLangVar.'_ENTRY_AUTHOR' =>  htmlspecialchars($strAddedBy, ENT_QUOTES, CONTREXX_CHARSET),
                            $this->moduleLangVar.'_ENTRY_HITS' =>  $arrEntry['entryHits'],
                            $this->moduleLangVar.'_ENTRY_FORM' => $objForm->arrForms[$arrEntry['entryFormId']]['formName'][0],
                        ));

                        foreach ($arrEntry['entryFields'] as $key => $strFieldValue) {
                            $intPos = $key+1;

                            $objTpl->setVariable(array(
                                                       $this->moduleLangVar.'_ENTRY_FIELD_'.$intPos.'_POS' => contrexx_raw2xhtml(substr($strFieldValue, 0, 255)),
                            ));
                        }
                        
                        //get order
                        if($this->arrSettings['settingsIndividualEntryOrder'] == 1) {
                            $objTpl->setVariable(array(
                                $this->moduleLangVar.'_ENTRY_ORDER' => '<input name="entriesOrder['.$arrEntry['entryId'].']" style="width: 30px; margin-right: 5px;" value="'.$arrEntry['entryOrder'].'" onfocus="this.select();" type="text">',
                            ));
                            
                            if(intval($objTpl->blockExists($this->moduleName.'EntriesSaveOrder')) != 0) {
                                $objTpl->touchBlock($this->moduleName.'EntriesSaveOrder');    
                            }
                        } else {
                            if(intval($objTpl->blockExists($this->moduleName.'EntriesSaveOrder')) != 0) {
                                $objTpl->hideBlock($this->moduleName.'EntriesSaveOrder');
                            }
                        }

                        $i++;
                        $objTpl->parse($this->strBlockName);
                        $objTpl->hideBlock('noEntriesFound');
                        $objTpl->clearVariables();
                    }
                } else {
                    $objTpl->setGlobalVariable(array(
                        'TXT_'.$this->moduleLangVar.'_NO_ENTRIES_FOUND' => $_ARRAYLANG['TXT_MEDIADIR_NO_ENTRIES_FOUND'],
                    ));

                    $objTpl->touchBlock('noEntriesFound');
                    $objTpl->clearVariables();
                }
                break;
            case 2:
                //Frontend View
                if(!empty($this->arrEntries)) {
                    foreach ($this->arrEntries as $key => $arrEntry) {
	                    if(($arrEntry['entryDurationStart'] < $intToday && $arrEntry['entryDurationEnd'] > $intToday) || $arrEntry['entryDurationType'] == 1) {
	                        $objInputfields = new mediaDirectoryInputfield(intval($arrEntry['entryFormId']),false,$arrEntry['entryTranslationStatus']);
	                        $objInputfields->listInputfields($objTpl, 3, intval($arrEntry['entryId']));

	                        if(intval($arrEntry['entryAddedBy']) != 0) {
		                        if ($objUser = $objFWUser->objUser->getUser(intval($arrEntry['entryAddedBy']))) {
								    $strAddedBy = $objUser->getUsername();
								} else {
	                                $strAddedBy = "unknown";
								}
	                        } else {
	                            $strAddedBy = "unknown";
	                        }

	                        $strCategoryLink = $this->intCatId != 0 ? '&amp;cid='.$this->intCatId : null;
	                        $strLevelLink = $this->intLevelId != 0 ? '&amp;lid='.$this->intLevelId : null;

	                        if($this->checkPageCmd('detail'.intval($arrEntry['entryFormId']))) {
	                            $strDetailCmd = 'detail'.intval($arrEntry['entryFormId']);
	                        } else {
	                            $strDetailCmd = 'detail';
	                        }

	                        if($arrEntry['entryReadyToConfirm'] == 1 || $arrEntry['entryConfirmed'] == 1) {
                                $strDetailUrl = 'index.php?section='.$this->moduleName.'&amp;cmd='.$strDetailCmd.$strLevelLink.$strCategoryLink.'&amp;eid='.$arrEntry['entryId'];
                            } else {
                                $strDetailUrl = '#';
                            }

                            $objForm = new mediaDirectoryForm($arrEntry['entryFormId']);

	                        $objTpl->setVariable(array(
	                            $this->moduleLangVar.'_ROW_CLASS' =>  $i%2==0 ? 'row1' : 'row2',
	                            $this->moduleLangVar.'_ENTRY_ID' =>  $arrEntry['entryId'],
	                            $this->moduleLangVar.'_ENTRY_STATUS' => $strStatus,
	                            $this->moduleLangVar.'_ENTRY_VALIDATE_DATE' =>  date("H:i:s - d.m.Y",$arrEntry['entryValdateDate']),
	                            $this->moduleLangVar.'_ENTRY_CREATE_DATE' =>  date("H:i:s - d.m.Y",$arrEntry['entryCreateDate']),
	                            $this->moduleLangVar.'_ENTRY_AUTHOR' =>  htmlspecialchars($strAddedBy, ENT_QUOTES, CONTREXX_CHARSET),
	                            $this->moduleLangVar.'_ENTRY_CATEGORIES' =>  $this->getCategoriesLevels(1, $arrEntry['entryId'], $objForm->arrForms[$arrEntry['entryFormId']]['formCmd']),
                                $this->moduleLangVar.'_ENTRY_LEVELS' =>  $this->getCategoriesLevels(2, $arrEntry['entryId'], $objForm->arrForms[$arrEntry['entryFormId']]['formCmd']),
                                $this->moduleLangVar.'_ENTRY_HITS' =>  $arrEntry['entryHits'],
	                            $this->moduleLangVar.'_ENTRY_POPULAR_HITS' =>  $arrEntry['entryPopularHits'],
	                            $this->moduleLangVar.'_ENTRY_DETAIL_URL' => $strDetailUrl,
	                            $this->moduleLangVar.'_ENTRY_EDIT_URL' =>  'index.php?section='.$this->moduleName.'&amp;cmd=edit&amp;eid='.$arrEntry['entryId'],
	                            $this->moduleLangVar.'_ENTRY_DELETE_URL' =>  'index.php?section='.$this->moduleName.'&amp;cmd=delete&amp;eid='.$arrEntry['entryId'],
	                            'TXT_'.$this->moduleLangVar.'_ENTRY_DELETE' =>  $_ARRAYLANG['TXT_MEDIADIR_DELETE'],
	                            'TXT_'.$this->moduleLangVar.'_ENTRY_EDIT' =>  $_ARRAYLANG['TXT_MEDIADIR_EDIT'],
	                            'TXT_'.$this->moduleLangVar.'_ENTRY_DETAIL' =>  $_ARRAYLANG['TXT_MEDIADIR_DETAIL'],
	                            'TXT_'.$this->moduleLangVar.'_ENTRY_CATEGORIES' =>  $_ARRAYLANG['TXT_MEDIADIR_CATEGORIES'],
	                            'TXT_'.$this->moduleLangVar.'_ENTRY_LEVELS' =>  $_ARRAYLANG['TXT_MEDIADIR_LEVELS'],
	                        ));

                            $this->parseCategoryLevels(1, $arrEntry['entryId'], $objTpl);
                            $this->parseCategoryLevels(2, $arrEntry['entryId'], $objTpl);

                            foreach ($arrEntry['entryFields'] as $key => $strFieldValue) {
                                $intPos = $key+1;

                                $objTpl->setVariable(array(
                                    'MEDIADIR_ENTRY_FIELD_'.$intPos.'_POS' => substr($strFieldValue, 0, 255),
                                ));
                                }

	                        if($this->arrSettings['settingsAllowVotes']) {
	                            $objVoting = new mediaDirectoryVoting();

	                            if(intval($objTpl->blockExists($this->moduleName.'EntryVoteForm')) != 0) {
	                                $objVoting->getVoteForm($objTpl, $arrEntry['entryId']);
	                            }
	                            if(intval($objTpl->blockExists($this->moduleName.'EntryVotes')) != 0) {
	                                $objVoting->getVotes($objTpl, $arrEntry['entryId']);
	                            }
	                        }

	                        if($this->arrSettings['settingsAllowComments']) {
	                            $objComment = new mediaDirectoryComment();

	                            if(intval($objTpl->blockExists($this->moduleName.'EntryComments')) != 0) {
	                                $objComment->getComments($objTpl, $arrEntry['entryId']);
	                            }

	                            if(intval($objTpl->blockExists($this->moduleName.'EntryCommentForm')) != 0) {
	                                $objComment->getCommentForm($objTpl, $arrEntry['entryId']);
	                            }
	                        }

	                        if(!$this->arrSettings['settingsAllowEditEntries'] && intval($objTpl->blockExists($this->moduleName.'EntryEditLink')) != 0) {
	                            $objTpl->hideBlock($this->moduleName.'EntryEditLink');
	                        }

	                        if(!$this->arrSettings['settingsAllowDelEntries'] && intval($objTpl->blockExists($this->moduleName.'EntryDeleteLink')) != 0) {
	                            $objTpl->hideBlock($this->moduleName.'EntryDeleteLink');
	                        }

	                        $i++;
	                        $objTpl->parse($this->moduleName.'EntryList');
	                        $objTpl->clearVariables();
	                    }
                    }
                } else {
                    $objTpl->setVariable(array(
                        'TXT_'.$this->moduleLangVar.'_SEARCH_MESSAGE' => $_ARRAYLANG['TXT_MEDIADIR_NO_ENTRIES_FOUND'],
                    ));

                    $objTpl->parse($this->moduleName.'NoEntriesFound');
                    $objTpl->clearVariables();
                }
                break;  
            case 3:
                //Alphabetical View    
                if(!empty($this->arrEntries)) {
                    $arrAlphaIndexes = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','0-9','#');  
                    $arrAlphaGroups = array();
                    
                    foreach ($this->arrEntries as $key => $arrEntry) {
                        $strTitle = $arrEntry['entryFields'][0];
                        $strAlphaIndex = strtoupper(substr($strTitle, 0, 1));
                        
                        if(!in_array($strAlphaIndex, $arrAlphaIndexes)){
                            if(is_numeric($strAlphaIndex)) {
                                $strAlphaIndex = '0-9';  
                            } else {
                                $strAlphaIndex = '#';      
                            }   
                        }
                        
                        $arrAlphaGroups[$strAlphaIndex][] = $arrEntry;
                    }              
                                                                                                        
                    if(intval($objTpl->blockExists($this->moduleName.'AlphaIndex')) != 0) {        
                        $objTpl->touchBlock($this->moduleName.'AlphaIndex');     
                                                                                                   
                        foreach ($arrAlphaIndexes as $key => $strIndex) {        
                            if(is_array($arrAlphaGroups[$strIndex])) {    
                                $strAlphaIndex = '<a href="#'.$strIndex.'">'.$strIndex.'</a>';   
                            } else {                             
                                $strAlphaIndex = ''.$strIndex.'';  
                            }       
                               
                            $objTpl->setVariable(array(                                        
                                $this->moduleLangVar.'_ALPHA_INDEX_LINK' => $strAlphaIndex
                            ));
                            
                            $objTpl->parse($this->moduleName.'AlphaIndexElement');   
                        }           
                    }
                    
                    
                    
                    foreach ($arrAlphaGroups as $strAlphaIndex => $arrEntries) {        
                        if(intval($objTpl->blockExists($this->moduleName.'AlphabeticalTitle')) != 0) {
                            $objTpl->setVariable(array(
                                $this->moduleLangVar.'_ALPHABETICAL_ANCHOR' => $strAlphaIndex,
                                'TXT_'.$this->moduleLangVar.'_ALPHABETICAL_TITLE' => $strAlphaIndex
                            ));
                            
                            $objTpl->parse($this->moduleName.'AlphabeticalTitle');
                        }
                        
                        foreach ($arrEntries as $key => $arrEntry) {
                            if(($arrEntry['entryDurationStart'] < $intToday && $arrEntry['entryDurationEnd'] > $intToday) || $arrEntry['entryDurationType'] == 1) {
                                $objInputfields = new mediaDirectoryInputfield(intval($arrEntry['entryFormId']),false,$arrEntry['entryTranslationStatus']);
                                $objInputfields->listInputfields($objTpl, 3, intval($arrEntry['entryId']));

                                if(intval($arrEntry['entryAddedBy']) != 0) {
                                    if ($objUser = $objFWUser->objUser->getUser(intval($arrEntry['entryAddedBy']))) {
                                        $strAddedBy = $objUser->getUsername();
                                    } else {
                                        $strAddedBy = "unknown";
                                    }
                                } else {
                                    $strAddedBy = "unknown";
                                }

                                $strCategoryLink = $this->intCatId != 0 ? '&amp;cid='.$this->intCatId : null;
                                $strLevelLink = $this->intLevelId != 0 ? '&amp;lid='.$this->intLevelId : null;

                                if($this->checkPageCmd('detail'.intval($arrEntry['entryFormId']))) {
                                    $strDetailCmd = 'detail'.intval($arrEntry['entryFormId']);
                                } else {
                                    $strDetailCmd = 'detail';
                                }

                                if($arrEntry['entryReadyToConfirm'] == 1 || $arrEntry['entryConfirmed'] == 1) {
                                    $strDetailUrl = 'index.php?section='.$this->moduleName.'&amp;cmd='.$strDetailCmd.$strLevelLink.$strCategoryLink.'&amp;eid='.$arrEntry['entryId'];
                                } else {
                                    $strDetailUrl = '#';
                                }

                                $objForm = new mediaDirectoryForm($arrEntry['entryFormId']);

                                $objTpl->setVariable(array(
                                    $this->moduleLangVar.'_ROW_CLASS' =>  $i%2==0 ? 'row1' : 'row2',
                                    $this->moduleLangVar.'_ENTRY_ID' =>  $arrEntry['entryId'],
                                    $this->moduleLangVar.'_ENTRY_STATUS' => $strStatus,
                                    $this->moduleLangVar.'_ENTRY_VALIDATE_DATE' =>  date("H:i:s - d.m.Y",$arrEntry['entryValdateDate']),
                                    $this->moduleLangVar.'_ENTRY_CREATE_DATE' =>  date("H:i:s - d.m.Y",$arrEntry['entryCreateDate']),
                                    $this->moduleLangVar.'_ENTRY_AUTHOR' =>  htmlspecialchars($strAddedBy, ENT_QUOTES, CONTREXX_CHARSET),
                                    $this->moduleLangVar.'_ENTRY_CATEGORIES' =>  $this->getCategoriesLevels(1, $arrEntry['entryId'], $objForm->arrForms[$arrEntry['entryFormId']]['formCmd']),
                                    $this->moduleLangVar.'_ENTRY_LEVELS' =>  $this->getCategoriesLevels(2, $arrEntry['entryId'], $objForm->arrForms[$arrEntry['entryFormId']]['formCmd']),
                                    $this->moduleLangVar.'_ENTRY_HITS' =>  $arrEntry['entryHits'],
                                    $this->moduleLangVar.'_ENTRY_POPULAR_HITS' =>  $arrEntry['entryPopularHits'],
                                    $this->moduleLangVar.'_ENTRY_DETAIL_URL' => $strDetailUrl,
                                    $this->moduleLangVar.'_ENTRY_EDIT_URL' =>  'index.php?section='.$this->moduleName.'&amp;cmd=edit&amp;eid='.$arrEntry['entryId'],
                                    $this->moduleLangVar.'_ENTRY_DELETE_URL' =>  'index.php?section='.$this->moduleName.'&amp;cmd=delete&amp;eid='.$arrEntry['entryId'],
                                    'TXT_'.$this->moduleLangVar.'_ENTRY_DELETE' =>  $_ARRAYLANG['TXT_MEDIADIR_DELETE'],
                                    'TXT_'.$this->moduleLangVar.'_ENTRY_EDIT' =>  $_ARRAYLANG['TXT_MEDIADIR_EDIT'],
                                    'TXT_'.$this->moduleLangVar.'_ENTRY_DETAIL' =>  $_ARRAYLANG['TXT_MEDIADIR_DETAIL'],
                                    'TXT_'.$this->moduleLangVar.'_ENTRY_CATEGORIES' =>  $_ARRAYLANG['TXT_MEDIADIR_CATEGORIES'],
                                    'TXT_'.$this->moduleLangVar.'_ENTRY_LEVELS' =>  $_ARRAYLANG['TXT_MEDIADIR_LEVELS'],
                                ));

                                $this->parseCategoryLevels(1, $arrEntry['entryId'], $objTpl);
                                $this->parseCategoryLevels(2, $arrEntry['entryId'], $objTpl);
                                   
                                foreach ($arrEntry['entryFields'] as $key => $strFieldValue) {
                                    $intPos = $key+1;

                                    $objTpl->setVariable(array(
                                                               'MEDIADIR_ENTRY_FIELD_'.$intPos.'_POS' => contrexx_raw2xhtml(substr($strFieldValue, 0, 255)),
                                    ));
                                }

                                if($this->arrSettings['settingsAllowVotes']) {
                                    $objVoting = new mediaDirectoryVoting();

                                    if(intval($objTpl->blockExists($this->moduleName.'EntryVoteForm')) != 0) {
                                        $objVoting->getVoteForm($objTpl, $arrEntry['entryId']);
                                    }
                                    if(intval($objTpl->blockExists($this->moduleName.'EntryVotes')) != 0) {
                                        $objVoting->getVotes($objTpl, $arrEntry['entryId']);
                                    }
                                }

                                if($this->arrSettings['settingsAllowComments']) {
                                    $objComment = new mediaDirectoryComment();

                                    if(intval($objTpl->blockExists($this->moduleName.'EntryComments')) != 0) {
                                        $objComment->getComments($objTpl, $arrEntry['entryId']);
                                    }

                                    if(intval($objTpl->blockExists($this->moduleName.'EntryCommentForm')) != 0) {
                                        $objComment->getCommentForm($objTpl, $arrEntry['entryId']);
                                    }
                                }

                                if(!$this->arrSettings['settingsAllowEditEntries'] && intval($objTpl->blockExists($this->moduleName.'EntryEditLink')) != 0) {
                                    $objTpl->hideBlock($this->moduleName.'EntryEditLink');
                                }

                                if(!$this->arrSettings['settingsAllowDelEntries'] && intval($objTpl->blockExists($this->moduleName.'EntryDeleteLink')) != 0) {
                                    $objTpl->hideBlock($this->moduleName.'EntryDeleteLink');
                                }

                                $i++;
                                $objTpl->parse($this->moduleName.'EntryList');
                                $objTpl->clearVariables();
                            }
                        }
                    }       
                } else {
                    $objTpl->setVariable(array(
                        'TXT_'.$this->moduleLangVar.'_SEARCH_MESSAGE' => $_ARRAYLANG['TXT_MEDIADIR_NO_ENTRIES_FOUND'],
                    ));

                    $objTpl->parse($this->moduleName.'NoEntriesFound');
                    $objTpl->clearVariables();
                }
            case 4:
                //Google Map
                $objGoogleMap = new googleMap();
                $objGoogleMap->setMapId($this->moduleName.'GoogleMap');
                $objGoogleMap->setMapStyleClass('mapLarge');
                $objGoogleMap->setMapType($this->arrSettings['settingsGoogleMapType']);

                $arrValues = explode(',', $this->arrSettings['settingsGoogleMapStartposition']);
                $objGoogleMap->setMapZoom($arrValues[2]);
                $objGoogleMap->setMapCenter($arrValues[1], $arrValues[0]);

                foreach ($this->arrEntries as $key => $arrEntry) {
                	if(($arrEntry['entryDurationStart'] < $intToday && $arrEntry['entryDurationEnd'] > $intToday) || $arrEntry['entryDurationType'] == 1) {
	                    $arrValues = array();

	                    if($this->checkPageCmd('detail'.intval($arrEntry['entryFormId']))) {
	                        $strDetailCmd = 'detail'.intval($arrEntry['entryFormId']);
	                    } else {
	                        $strDetailCmd = 'detail';
	                    }

	                    $strEntryLink = '<a href="index.php?section='.$this->moduleName.'&amp;cmd='.$strDetailCmd.'&amp;eid='.$arrEntry['entryId'].'">'.$_ARRAYLANG['TXT_MEDIADIR_DETAIL'].'</a>';
	                    $strEntryTitle = '<b>'.contrexx_raw2xhtml($arrEntry['entryFields']['0']).'</b>';
	                    $intEntryId = intval($arrEntry['entryId']);
	                    $intEntryFormId = intval($arrEntry['entryFormId']);

	                    $query = "
	                        SELECT
	                            inputfield.`id` AS `id`,
	                            rel_inputfield.`value` AS `value`
	                        FROM
	                            ".DBPREFIX."module_".$this->moduleTablePrefix."_inputfields AS inputfield,
	                            ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_inputfields AS rel_inputfield
	                        WHERE
	                            inputfield.`form` = '".$intEntryFormId."'
	                        AND
	                            inputfield.`type`= '15'
	                        AND
	                            rel_inputfield.`field_id` = inputfield.`id`
	                        AND
	                            rel_inputfield.`entry_id` = '".$intEntryId."'
	                        LIMIT 1
	                    ";

	                    $objRSMapKoordinates = $objDatabase->Execute($query);

	                    if($objRSMapKoordinates !== false) {
	                        $arrValues = explode(',', $objRSMapKoordinates->fields['value']);
	                    }

	                    $strValueLon = empty($arrValues[1]) ? 0 : $arrValues[1];
                            $strValueLat = empty($arrValues[0]) ? 0 : $arrValues[0];

                            $mapIndex      = $objGoogleMap->getMapIndex();
                            $clickFunction = "if (infowindow_$mapIndex) { infowindow_$mapIndex.close(); }
                                infowindow_$mapIndex.setContent(info$intEntryId);
                                infowindow_$mapIndex.open(map_$mapIndex, marker$intEntryId)";
	                    $objGoogleMap->addMapMarker($intEntryId, $strValueLon, $strValueLat, $strEntryTitle."<br />".$strEntryLink, true, $clickFunction);
                    }
                }

                $objTpl->setVariable(array(
                    $this->moduleLangVar.'_GOOGLE_MAP' => $objGoogleMap->getMap()
                ));

                break;
        }
    }



    function checkPageCmd($strPageCmd)
    {
        global $_LANGID;

        $pageRepo = \Env::get('em')->getRepository('Cx\Core\ContentManager\Model\Entity\Page');
        $pages = $pageRepo->findBy(array(
            'cmd' => contrexx_addslashes($strPageCmd),
            'lang' => $_LANGID,
            'type' => \Cx\Core\ContentManager\Model\Entity\Page::TYPE_APPLICATION,
            'module' => $this->moduleName,
        ));
        return count($pages) > 0;
    }



    function saveEntry($arrData, $intEntryId=null)
    {
        global $_ARRAYLANG, $_CORELANG, $objDatabase, $_LANGID, $objInit;

        $objFWUser = FWUser::getFWUserObject();

        //get data
        $intId = intval($intEntryId);
        $intFormId = intval($arrData['formId']);
        $strCreateDate = mktime();
        $strUpdateDate = mktime();
        $intUserId = intval($objFWUser->objUser->getId());
        $strLastIp = contrexx_addslashes($_SERVER['REMOTE_ADDR']);
        $strTransStatus = contrexx_addslashes(join(",", $arrData['translationStatus']));


        //$arrCategories = explode(",",$arrData['selectedCategories']);
        //$arrLevels= explode("&",$arrData['selectedLevels']);


        if($objInit->mode == 'backend') {
            $intReadyToConfirm = 1;
        } else {
        	if($this->arrSettings['settingsReadyToConfirm'] == 1) {
                $intReadyToConfirm = intval($arrData['readyToConfirm']);
        	} else {
                $intReadyToConfirm = 1;
        	}
        }

        switch($this->arrSettings['settingsEntryDisplaydurationValueType']) {
        	case 1:
        		$intDiffDay = $this->arrSettings['settingsEntryDisplaydurationValue'];
                $intDiffMonth = 0;
                $intDiffYear = 0;
        		break;
            case 2:
                $intDiffDay = 0;
                $intDiffMonth = $this->arrSettings['settingsEntryDisplaydurationValue'];
                $intDiffYear = 0;
                break;
            case 3:
                $intDiffDay = 0;
                $intDiffMonth = 0;
                $intDiffYear = $this->arrSettings['settingsEntryDisplaydurationValue'];
                break;
        }

        if(empty($intId)) {
            if($objInit->mode == 'backend') {
                $intConfirmed = 1;
                $intActive = intval($arrData['status']) ? 1 : 0;
                $intShowIn = 3;
                $intDurationType =  intval($arrData['durationType']);
                $intDurationStart = $this->dateFromInput($arrData['durationStart']);
                $intDurationEnd = $this->dateFromInput($arrData['durationEnd']);
            } else {
                $intConfirmed = $this->arrSettings['settingsConfirmNewEntries'] == 1 ? 0 : 1;
                $intActive = 1;
                $intShowIn = 2;
                $intDurationType = $this->arrSettings['settingsEntryDisplaydurationType'];
                $intDurationStart = mktime();
                $intDurationEnd = mktime(0,0,0,date("m")+$intDiffMonth,date("d")+$intDiffDay,date("Y")+$intDiffYear);
            }

            $strValidateDate = $intConfirmed == 1 ? mktime() : 0;

            //insert new entry
            $objResult = $objDatabase->Execute("
                INSERT INTO ".DBPREFIX."module_".$this->moduleTablePrefix."_entries
                   SET `form_id`='".$intFormId."',
                       `create_date`='".$strCreateDate."',
                       `validate_date`='".$strValidateDate."',
                       `update_date`='".$strValidateDate."',
                       `added_by`='".$intUserId."',
                       `lang_id`='".$_LANGID."',
                       `hits`='0',
                       `last_ip`='".$strLastIp."',
                       `confirmed`='".$intConfirmed."',
                       `active`='".$intActive."',
                       `duration_type`='".$intDurationType."',
                       `duration_start`='".$intDurationStart."',
                       `duration_end`='".$intDurationEnd."',
                       `duration_notification`='0',
                       `translation_status`='".$strTransStatus."',
                       `ready_to_confirm`='".$intReadyToConfirm."',
                       `updated_by`=".$intUserId.",
                       `popular_hits`=0,
                       `popular_date`='".$strValidateDate."'");
            if (!$objResult) {
                return false;
            }
            $intId = $objDatabase->Insert_ID();
        } else {
        	self::getEntries($intId);
        	$intOldReadyToConfirm = $this->arrEntries[$intId]['entryReadyToConfirm'];

            if($objInit->mode == 'backend') {
                $intConfirmed = 1;
                $intShowIn = 3;

                $intDurationStart = $this->dateFromInput($arrData['durationStart']);
                $intDurationEnd = $this->dateFromInput($arrData['durationEnd']);

                $arrAdditionalQuery[] = "`duration_type`='". intval($arrData['durationType'])."', `duration_start`='". intval($intDurationStart)."',  `duration_end`='". intval($intDurationEnd)."'";
                
                $arrAdditionalQuery[] = "`active`='". (intval($arrData['status']) ? 1 : 0)."'";
            } else {
                $intConfirmed = $this->arrSettings['settingsConfirmUpdatedEntries'] == 1 ? 0 : 1;
                $intShowIn = 2;
                $arrAdditionalQuery = null;
            }

            $arrAdditionalQuery[] = " `updated_by`='".$intUserId."'";

            if(intval($arrData['userId']) != 0) {
                $arrAdditionalQuery[] = "`added_by`='".intval($arrData['userId'])."'";
            }

            if (!empty($arrData['durationResetNotification'])) {
                $arrAdditionalQuery[] = "`duration_notification`='0'";
            }

            $strAdditionalQuery = join(",", $arrAdditionalQuery);
            $strValidateDate = $intConfirmed == 1 ? mktime() : 0;

            $objUpdateEntry = $objDatabase->Execute("
                UPDATE ".DBPREFIX."module_".$this->moduleTablePrefix."_entries
                   SET `update_date`='".$strUpdateDate."',
                       `translation_status`='".$strTransStatus."',
                       `ready_to_confirm`='".$intReadyToConfirm."',
                       $strAdditionalQuery
                 WHERE `id`='$intId'");

            if (!$objUpdateEntry) {
                return false;
            }
            $objDeleteCategories = $objDatabase->Execute("DELETE FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_categories WHERE entry_id='".$intId."'");
            $objDeleteLevels = $objDatabase->Execute("DELETE FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_levels WHERE entry_id='".$intId."'");
        }


        //////////////////////
        // STORE ATTRIBUTES //
        //////////////////////

        $error = false;

        foreach ($this->getInputfields() as $arrInputfield) {
            // store selected category (field = category)
            if ($arrInputfield['id'] == 1) {
                foreach ($arrData['selectedCategories'] as $intCategoryId) {
                    $objResult = $objDatabase->Execute("
                    INSERT INTO ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_categories
                       SET `entry_id`='".intval($intId)."',
                           `category_id`='".intval($intCategoryId)."'");
                    if (!$objResult) {
                        Message::error($objDatabase->ErrorMsg());
                        $error = true;
                    }
                }

                continue;
            }

            // store selected level (field = level)
            if ($arrInputfield['id'] == 2) {
                if ($this->arrSettings['settingsShowLevels'] == 1) {
                    foreach ($arrData['selectedLevels'] as $intLevelId) {
                        $objResult = $objDatabase->Execute("
                        INSERT INTO ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_levels
                           SET `entry_id`='".intval($intId)."',
                               `level_id`='".intval($intLevelId)."'");
                        if (!$objResult) {
                            Message::error($objDatabase->ErrorMsg());
                            $error = true;
                        }
                    }
                }

                continue;
            }

            // skip meta attributes or ones that are out of scope (frontend/backend)
            if (   // type = 'add_step'
                   $arrInputfield['type'] == 16 
                   // type = 'label'
                || $arrInputfield['type'] == 18 
                   // type = 'title'
                || $arrInputfield['type'] == 30 
                   // show_in is neither FRONTEND or BACKEND ($intShowIn = 2|3) nor FRONTEND AND BACKEND (show_in=1)
                || ($arrInputfield['show_in'] != $intShowIn && $arrInputfield['show_in'] != 1)
            ) {
                continue;
            }

            // truncate attribute's data ($arrInputfield) from database if it's VALUE is not set (empty) or set to it's default value
            if (   empty($arrData[$this->moduleName.'Inputfield'][$arrInputfield['id']])
                || $arrData[$this->moduleName.'Inputfield'][$arrInputfield['id']] == $arrInputfield['default_value'][$_LANGID]
            ) {
                $objResult = $objDatabase->Execute("DELETE FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_inputfields WHERE entry_id='".$intId."' AND field_id='".intval($arrInputfield['id'])."'");
                if (!$objResult) {
                    Message::error($objDatabase->ErrorMsg());
                    $error = true;
                }

                continue;
            }
            
            // initialize attribute
            $strType = $arrInputfield['type_name'];
            $strInputfieldClass = "mediaDirectoryInputfield".ucfirst($strType);
            try {
                $objInputfield = safeNew($strInputfieldClass);
            } catch (Exception $e) {
                Message::error($e->getMessage());
                $error = true;

                continue;
            }

            // attribute is non-i18n
            if ($arrInputfield['type_multi_lang'] == 0) {
                try {
                    $strInputfieldValue = $objInputfield->saveInputfield($arrInputfield['id'], $arrData[$this->moduleName.'Inputfield'][$arrInputfield['id']]);
                    $objResult = $objDatabase->Execute("
                        INSERT INTO ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_inputfields
                           SET `entry_id`='".intval($intId)."',
                               `lang_id`='".intval($_LANGID)."',
                               `form_id`='".intval($intFormId)."',
                               `field_id`='".intval($arrInputfield['id'])."',
                               `value`='".contrexx_raw2db($strInputfieldValue)."'
              ON DUPLICATE KEY
                        UPDATE `value`='".contrexx_raw2db($strInputfieldValue)."'");
                    if (!$objResult) {
                        throw new Exception($objDatabase->ErrorMsg());
                    }
                } catch (Exception $e) {
                    Message::error($e->getMessage());
                    $error = true;
                }

                continue;
            }

            // delete attribute's data of languages that are no longer in use
            $objDatabase->Execute("DELETE FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_inputfields WHERE entry_id='".$intId."' AND field_id = '".intval($arrInputfield['id'])."' AND lang_id NOT IN (".join(",", array_keys($this->arrFrontendLanguages)).")");

            // attribute is i18n
            foreach ($this->arrFrontendLanguages as $arrLang) {
                try {
                    $intLangId = $arrLang['id'];

                    // if the attribute is of type dynamic (meaning it can have an unlimited set of childs (references))
                    if ($arrInputfield['type_dynamic'] == 1) {
                        $arrDefault = array();
                        foreach ($arrData[$this->moduleName.'Inputfield'][$arrInputfield['id']][0] as $intKey => $arrValues) {
                            $arrNewDefault = $arrData[$this->moduleName.'Inputfield'][$arrInputfield['id']][$_LANGID][$intKey];
                            $arrOldDefault = $arrData[$this->moduleName.'Inputfield'][$arrInputfield['id']]['old'][$intKey];
                            $arrNewValues = $arrData[$this->moduleName.'Inputfield'][$arrInputfield['id']][$intLangId][$intKey];
                            foreach ($arrValues as $strKey => $strMasterValue) {
                                if ($intLangId == $_LANGID) {
                                    if ($arrNewDefault[$strKey] != $strMasterValue) {
                                        if ($strMasterValue != $arrOldDefault[$strKey] && $arrNewDefault[$strKey] == $arrOldDefault[$strKey]) {
                                            $arrDefault[$intKey][$strKey] = $strMasterValue;
                                        } else {
                                            $arrDefault[$intKey][$strKey] = $arrNewDefault[$strKey];
                                        }
                                    } else {
                                        $arrDefault[$intKey][$strKey] = $arrNewDefault[$strKey];
                                    }
                                } else {
                                    if ($arrNewValues[$strKey] == '') {
                                        $arrDefault[$intKey][$strKey] = $strMasterValue;
                                    } else {
                                        $arrDefault = $arrData[$this->moduleName.'Inputfield'][$arrInputfield['id']][$intLangId];
                                    }
                                }
                            }
                            $strDefault = $arrDefault;
                        }
                        $strInputfieldValue = $objInputfield->saveInputfield($arrInputfield['id'], $strDefault, $intLangId);
                    } else {
                        // regular attribute get parsed
                        $strInputfieldValue = $objInputfield->saveInputfield($arrInputfield['id'], $arrData[$this->moduleName.'Inputfield'][$arrInputfield['id']][$intLangId]);
                    }

                    $objResult = $objDatabase->Execute("
                        INSERT INTO ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_inputfields
                           SET `entry_id`='".intval($intId)."',
                               `lang_id`='".intval($intLangId)."',
                               `form_id`='".intval($intFormId)."',
                               `field_id`='".intval($arrInputfield['id'])."',
                               `value`='".contrexx_raw2db($strInputfieldValue)."'
              ON DUPLICATE KEY
                        UPDATE `value`='".contrexx_raw2db($strInputfieldValue)."'");
                    if (!$objResult) {
                        throw new Exception($objDatabase->ErrorMsg());
                    }
                } catch (Exception $e) {
                    Message::error($e->getMessage());
                    $error = true;
                }
            }
        }

        if(empty($intEntryId)) {
        	if($intReadyToConfirm == 1) {
                new mediaDirectoryMail(1, $intId);
        	}
            new mediaDirectoryMail(2, $intId);
        } else {
            if($intReadyToConfirm == 1 && $intOldReadyToConfirm == 0) {
                new mediaDirectoryMail(1, $intId);
            }
            new mediaDirectoryMail(6, $intId);
        }

        return $intId;
    }



    function deleteEntry($intEntryId)
    {
        global $_ARRAYLANG, $_CORELANG, $objDatabase;

        $objMail = new mediaDirectoryMail(5, $intEntryId);

        //delete entry
        $objDeleteEntry = $objDatabase->Execute("DELETE FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_entries WHERE `id`='".intval($intEntryId)."'");

        if($objDeleteEntry !== false) {
            //delete inputfields
            foreach ($this->getInputfields() as $key => $arrInputfield) {
                if($arrInputfield['id'] != 1 && $arrInputfield['id'] != 2) {

                    $strType = $arrInputfield['type_name'];
                    $strInputfieldClass = "mediaDirectoryInputfield".ucfirst($strType);

                    try {
                        $objInputfield = safeNew($strInputfieldClass);

                        if(!$objInputfield->deleteContent(intval($intEntryId), intval($arrInputfield['id']))) {
                            return false;
                        }
                    } catch (Exception $e) {
                        echo "Error: ".$e->getMessage();
                    }
                }
            }

            //delete categories
            $objDeleteCategories = $objDatabase->Execute("DELETE FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_categories WHERE `entry_id`='".intval($intEntryId)."'");

            //delete levels
            $objDeleteLevels = $objDatabase->Execute("DELETE FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_levels WHERE `entry_id`='".intval($intEntryId)."'");
        } else {
            return false;
        }

        return true;
    }



    function confirmEntry($intEntryId)
    {
        global $_ARRAYLANG, $_CORELANG, $objDatabase;

        $objConfirmEntry = $objDatabase->Execute("
            UPDATE
                ".DBPREFIX."module_".$this->moduleTablePrefix."_entries
            SET
                `confirmed`='1',
                `active`='1',
                `validate_date`='".time()."'
            WHERE
                `id`='".intval($intEntryId)."'
        ");

        if($objConfirmEntry !== false) {
            $objMail = new mediaDirectoryMail(3, $intEntryId);
            return true;
        } else {
           return false;
        }
    }



    function updateHits($intEntryId)
    {
        global $_ARRAYLANG, $_CORELANG, $objDatabase;

        $intHits        = intval($this->arrEntries[intval($intEntryId)]['entryHits']);
        $intPopularHits = intval($this->arrEntries[intval($intEntryId)]['entryPopularHits']);
        $strPopularDate = $this->arrEntries[intval($intEntryId)]['entryPopularDate'];
        $intPopularDays = intval($this->arrSettings['settingsPopularNumRestore']);
        $strLastIp      = $this->arrEntries[intval($intEntryId)]['entryLastIp'];
        $strNewIp       = contrexx_addslashes($_SERVER['REMOTE_ADDR']);

        $strToday  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
        $tempDays  = date("d",$strPopularDate);
        $tempMonth = date("m",$strPopularDate);
        $tempYear  = date("Y",$strPopularDate);

        $strPopularEndDate  = mktime(0, 0, 0, $tempMonth, $tempDays+$intPopularDays,  $tempYear);

        if ($strLastIp != $strNewIp) {
            if ($strToday >= $strPopularEndDate) {
                $strNewPopularDate  = $strToday;
                $intPopularHits     = 1;
            } else {
                $strNewPopularDate  = $strPopularDate;
                $intPopularHits++;
            }

            $intHits++;

            $objResult = $objDatabase->Execute("UPDATE
                                                    ".DBPREFIX."module_".$this->moduleTablePrefix."_entries
                                                SET
                                                    hits='".$intHits."',
                                                    popular_hits='".$intPopularHits."',
                                                    popular_date='".$strNewPopularDate."',
                                                    last_ip='".$strNewIp."'
                                                WHERE
                                                    id='".intval($intEntryId)."'
                                               ");
        }
    }



    function countEntries($intCategoryId, $intLevelId, $formId = null, $searchTerm = '', $countAllEntries = false)
    {
        global $objDatabase, $_ARRAYLANG, $objInit;

        $strWhereLevel      = '';
        $strFromLevel       = '';
        $strWhereCategory   = '';
        $strFromCategory    = '';
        $strWhereForm       = '';
        $strWhereSearchTerm = '';
        $strFromInputfield  = '';
        $strWhereActive     = '';

        if(!empty($intLevelId)) {
            $strWhereLevel = "AND ((level.`level_id` = ".$intLevelId.") AND (level.`entry_id` = entry.`id`)) ";
            $strFromLevel = " ,".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_levels AS level";
        }

        if(!empty($intCategoryId)) {
            $strWhereCategory = "AND ((category.`category_id` = ".$intCategoryId.") AND (category.`entry_id` = entry.`id`)) ";
            $strFromCategory = " ,".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_categories AS category";
        }

        if (!empty($formId)) {
            $strWhereForm = "AND (entry.`form_id` = ".$formId.") ";
        }
        
        if (!empty($searchTerm) && $searchTerm != $_ARRAYLANG['TXT_MEDIADIR_ID_OR_SEARCH_TERM']) {
            $term = contrexx_input2db($searchTerm);
            $strWhereSearchTerm  = 'AND (rel_inputfield.`entry_id` = entry.`id`) ';
            $strWhereSearchTerm .= 'AND ((`rel_inputfield`.`value` LIKE "%' . $term . '%") OR (`entry`.`id` = "' . $term . '"))';
            $strFromInputfield   = ', `' . DBPREFIX . 'module_' . $this->moduleTablePrefix . '_rel_entry_inputfields` AS `rel_inputfield`';
        }
        
        if (!$countAllEntries) {
            $strWhereActive = 'AND (entry.`active` = 1 AND entry.`confirmed` = 1)';
        }
        
        if($objInit->mode == 'frontend') {
            $strWhereDuration = "AND (`duration_type` = 1 OR (`duration_type` = 2 AND (`duration_start` < '$intToday' AND `duration_end` > '$intToday'))) ";
        } else {
            $strWhereDuration = null;
        }

        $query = "SELECT
                    entry.`id` AS `id`
                  FROM
                    ".DBPREFIX."module_".$this->moduleTablePrefix."_entries AS entry
                    ".$strFromCategory."
                    ".$strFromLevel."
                    ".$strFromInputfield."
                  WHERE
                    (entry.`id` != 0)
                    ".$strWhereActive."
                    ".$strWhereCategory."
                    ".$strWhereLevel."
                    ".$strWhereForm."
                    ".$strWhereSearchTerm."
                    ".$strWhereDuration."
                  GROUP BY
                    entry.`id`";

        $objNumEntries = $objDatabase->Execute($query);
        $intNumEntries = $objNumEntries->RecordCount();

        return intval($intNumEntries);
    }



    function getUsers($intEntryId=null)
    {
        global $objDatabase;

// TODO: replace by FWUser::getParsedUserTitle()
        $strDropdownUsers = '<select name="userId"style="width: 302px">';
        $objFWUser = FWUser::getFWUserObject();

		if ($objUser = $objFWUser->objUser->getUsers(null,null,null,array('username'))) {
	        while (!$objUser->EOF) {
	        	if(intval($objUser->getID()) == intval($this->arrEntries[$intEntryId]['entryAddedBy'])) {
                    $strSelected = 'selected="selected"';
                } else {
                    $strSelected = '';
                }

	        	$strDropdownUsers .= '<option value="'.intval($objUser->getID()).'" '.$strSelected.' >'.contrexx_raw2xhtml($objUser->getUsername()).'</option>';
                $objUser->next();
	        }
		}

        $strDropdownUsers .= '</select>';

        return $strDropdownUsers;
    }

    function parseCategoryLevels($intType, $intEntryId=null, $objTpl) {
        if ($intType == 1) {
            // categories
            $objCategoriesLevels = $this->getCategories($intEntryId);
            $list = 'CATEGORY';
        } else {
            // levels
            $objCategoriesLevels = $this->getLevels($intEntryId);
            $list = 'LEVEL';
        }

        if (!$objTpl->blockExists('mediadir_' . strtolower($list))) {
            return false;
        }

        if ($objCategoriesLevels !== false && $objCategoriesLevels->RecordCount() > 0) {
            while(!$objCategoriesLevels->EOF) {
                $objTpl->setVariable(array(
                    $this->moduleLangVar . '_ENTRY_' . $list . '_ID' => $objCategoriesLevels->fields['elm_id'],
                    $this->moduleLangVar . '_ENTRY_' . $list . '_NAME' => $objCategoriesLevels->fields['elm_name'],
                ));
                $objTpl->parse('mediadir_' . strtolower($list));
                $objCategoriesLevels->MoveNext();
            }
        } else {
            $objTpl->hideBlock('mediadir_' . strtolower($list));
        }
    }


    function getCategories($intEntryId = null) {
        global $objDatabase, $_LANGID;
        $query = "SELECT
            cat_rel.`category_id` AS `elm_id`,
            cat_name.`category_name` AS `elm_name`
          FROM
            ".DBPREFIX."module_mediadir_rel_entry_categories AS cat_rel,
            ".DBPREFIX."module_mediadir_categories_names AS cat_name
          WHERE
            cat_rel.`category_id` = cat_name.`category_id`
          AND
            cat_rel.`entry_id` = ?
          AND
            cat_name.`lang_id` = ?
          ORDER BY
            cat_name.`category_name` ASC
          ";

        return $objDatabase->Execute($query, array($intEntryId, $_LANGID));
    }


    function getLevels($intEntryId = null) {
        global $objDatabase, $_LANGID;
        $query = "SELECT
            level_rel.`level_id` AS `elm_id`,
            level_name.`level_name` AS `elm_name`
          FROM
            ".DBPREFIX."module_mediadir_rel_entry_levels AS level_rel,
            ".DBPREFIX."module_mediadir_level_names AS level_name
          WHERE
            level_rel.`level_id` = level_name.`level_id`
          AND
            level_rel.`entry_id` = ?
          AND
            level_name.`lang_id` = ?
          ORDER BY
            level_name.`level_name` ASC
          ";

        return $objDatabase->Execute($query, array($intEntryId, $_LANGID));
    }
    
    
    function getCategoriesLevels($intType, $intEntryId=null, $cmdName=null)
    {
        if ($intType == 1) {//categories
            $objEntryCategoriesLevels = $this->getCategories($intEntryId);
            $paramName = 'cid';
        } else {//levels
            $objEntryCategoriesLevels = $this->getLevels($intEntryId);
            $paramName = 'lid';
        }

        $pageRepo = \Env::get('em')->getRepository('Cx\Core\ContentManager\Model\Entity\Page');
        $page = $pageRepo->findOneByModuleCmdLang($this->moduleName, $cmdName, FRONTEND_LANG_ID);

        if ($objEntryCategoriesLevels !== false) {
            $list = '<ul>';
            while (!$objEntryCategoriesLevels->EOF) {
                $paramValue = intval($objEntryCategoriesLevels->fields['elm_id']);
                $url = $page ? \Cx\Core\Routing\URL::fromPage($page, array($paramName => $paramValue)) : '';
                $name = htmlspecialchars($objEntryCategoriesLevels->fields['elm_name'], ENT_QUOTES, CONTREXX_CHARSET);
                $list .= '<li>';
                $list .= !empty($url) ? '<a href="'.$url.'">'.$name.'</a>' : $name;
                $list .= '</li>';
                $objEntryCategoriesLevels->MoveNext();
            }
            $list .= '</ul>';
        }

        return $list;
    }
    
    
    function saveOrder($arrData) {
        global $objDatabase;

        foreach($arrData['entriesOrder'] as $intEntryId => $intEntryOrder) {
            $objRSEntryOrder = $objDatabase->Execute("UPDATE ".DBPREFIX."module_".$this->moduleTablePrefix."_entries SET `order`='".intval($intEntryOrder)."' WHERE `id`='".intval($intEntryId)."'");

            if ($objRSEntryOrder === false) {
                return false;
            }
        }
                                 
        return true;
    }


    function setDisplaydurationNotificationStatus($intEntryId, $bolStatus)
    {
        global $objDatabase;

        $objResult = $objDatabase->Execute("UPDATE ".DBPREFIX."module_".$this->moduleTablePrefix."_entries SET duration_notification='".intval($bolStatus)."' WHERE id='".intval($intEntryId)."'");
    }

    /**
     * Takes a date in the format dd.mm.yyyyand returns it's representation as mktime()-timestamp.
     *
     * @param $value string
     * @return long timestamp
     */
    function dateFromInput($value) {
        if($value === null || $value === '') //not set POST-param passed, return null for the other functions to know this
            return null;
        $arrDate = array();
        if (preg_match('/^([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{1,4})/', $value, $arrDate)) {
            return mktime(0, 0, 0, intval($arrDate[2]), intval($arrDate[1]), intval($arrDate[3]));
        } else {
            return time();
        }
    }
}

?>
