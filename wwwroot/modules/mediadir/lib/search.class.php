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
 * Media Directory Search Class
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Comvation Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_mediadir
 * @todo        Edit PHP DocBlocks!
 */

/**
 * Media Directory Search Class
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_mediadir
 */
class mediaDirectorySearch extends mediaDirectoryLibrary
{
    public $arrFoundIds = array();

    private $arrSearchLevels = array();
    private $arrSearchCategories = array();

    /**
     * Constructor
     */
    function __construct()
    {
        parent::getSettings();
    }



    function getSearchform($objTpl)
    {
        global $_ARRAYLANG, $_CORELANG, $objDatabase, $_LANGID;

        if (isset($_GET['cmd'])) {
            $strSearchFormCmd = '<input name="cmd" value="'.$_GET['cmd'].'" type="hidden" />';
        } else {
            $strSearchFormCmd = '';
        }

        if (isset($_GET['term'])) {
            $strSearchFormTerm = $_GET['term'];
        } else {
            $strSearchFormTerm = '';
        }

        $strSearchFormAction = CONTREXX_SCRIPT_PATH;
        $strTextSearch = $_CORELANG['TXT_SEARCH'];
        $strTextSearchterm = $_ARRAYLANG['TXT_MEDIADIR_SEARCH_TERM'];
        $strExpandedInputfields = $this->getExpandedInputfields();
        $strSearchFormId = $this->moduleName."SearchForm";
        $strSectionValue = $this->moduleName;
        $strInputfieldSearch = $this->moduleName."InputfieldSearch";
        $strButtonSearch = $this->moduleName."ButtonSearch";

        $strSearchNormalForm = <<<EOF
<div class="$strSearchFormId">
<form method="get" action="$strSearchFormAction">
<input name="section" value="$strSectionValue" type="hidden" />
<input name="type" value="normal" type="hidden" />
<input type="hidden" value="Suchen" name="search">
$strSearchFormCmd
<input name="term" class="$strInputfieldSearch" value="$strSearchFormTerm" onfocus="this.select();" type="text" /><input class="$strButtonSearch" value="$strTextSearch" name="search" type="submit">
</form>
</div>
EOF;

        $strSearchExpandedForm = <<<EOF

<div class="$strSearchFormId">
<form method="get" action="$strSearchFormAction">
<div class="normal">
<input name="section" value="$strSectionValue" type="hidden" />
<input name="type" value="exp" type="hidden" />
<input type="hidden" value="Suchen" name="search">
$strSearchFormCmd
<p><label>$strTextSearchterm</label><input name="term" class="$strInputfieldSearch" value="$strSearchFormTerm" onfocus="this.select();" type="text" /></p>
</div>
<div class="expanded">
$strExpandedInputfields
</div>
<p><input class="$strButtonSearch" value="$strTextSearch" name="search" type="submit"></p>
</form>
</div>
EOF;

        $objTpl->setVariable(array(
            'TXT_'.$this->moduleLangVar.'_SEARCH' => $_CORELANG['TXT_SEARCH'],
            'TXT_'.$this->moduleLangVar.'_EXP_SEARCH' => $_CORELANG['TXT_EXP_SEARCH'],
            $this->moduleLangVar.'_NORMAL_SEARCH_FORM' => $strSearchNormalForm,
            $this->moduleLangVar.'_EXPANDED_SEARCH_FORM' => $strSearchExpandedForm
        ));

        $objTpl->parse($this->moduleName.'Searchform');
    }



    function getExpandedInputfields()
    {
        global $_ARRAYLANG, $objDatabase, $_LANGID;

        $formId = null;
        $strPleaseChoose = $_ARRAYLANG['TXT_MEDIADIR_PLEASE_CHOOSE'];

        //get ids
        if (!empty($_GET['cmd'])) {
            $bolShowLevelSelector = false;
            $bolShowCategorySelector = false;

            $arrIds = explode('-', $_GET['cmd']);  

            if ($arrIds[0] != 'search' && $arrIds[0] != 'alphabetical'){
                $objForms = new mediaDirectoryForm();
                foreach ($objForms->arrForms as $id => $arrForm) {
                    if (!empty($arrForm['formCmd']) && ($arrForm['formCmd'] == $_GET['cmd'])) {
                        $formId = intval($id);
                    }
                }

                if (($objForms->arrForms[$formId]['formUseLevel'] == 1) && ($this->arrSettings['levelSelectorExpSearch'][$formId] == 1)) {
                    $bolShowLevelSelector = true;
                }
                if (($objForms->arrForms[$formId]['formUseCategory'] == 1) && ($this->arrSettings['categorySelectorExpSearch'][$formId] == 1)) {
                    $bolShowCategorySelector = true;
                }
            } else {
                $bolShowLevelSelector = in_array(1, $this->arrSettings['levelSelectorExpSearch']);
                $bolShowCategorySelector = in_array(1, $this->arrSettings['categorySelectorExpSearch']);
            }
        } else {
            $bolShowLevelSelector = in_array(1, $this->arrSettings['levelSelectorExpSearch']);
            $bolShowCategorySelector = in_array(1, $this->arrSettings['categorySelectorExpSearch']);
        }

        if ($this->arrSettings['settingsShowLevels'] && $bolShowLevelSelector) {
            if (intval($arrIds[0]) != 0) {
                $intLevelId = intval($arrIds[0]);
            } else {
                $intLevelId = 0;
            }

            $intLevelId = isset($_GET['lid']) ? intval($_GET['lid']) : $intLevelId;

            $objLevels = new mediaDirectoryLevel(null, null, 1);
            $strLevelDropdown = $objLevels->listLevels($this->_objTpl, 3, $intLevelId);
            $strLevelName = $_ARRAYLANG['TXT_MEDIADIR_LEVEL'];
            $strInputfieldSearch = $this->moduleName."InputfieldSearch";

            $strExpandedInputfields .= <<<EOF
<p><label>$strLevelName</label><select class="$strInputfieldSearch" name="lid"><option value="">$strPleaseChoose</option>$strLevelDropdown</select></p>
EOF;

            if (intval($arrIds[1]) != 0) {
                $intCategoryCmd = $arrIds[1];
            } else {
                $intCategoryCmd = 0;
            }
        } else {
            if (intval($arrIds[0]) != 0) {
                $intCategoryCmd = $arrIds[0];
            } else {
                $intCategoryCmd = 0;
            }
        }

        if ($intCategoryCmd != 0) {
            $intCategoryId = intval($intCategoryCmd);
        } else {
            $intCategoryId = 0;
        }

        $intCategoryId = isset($_GET['cid']) ? intval($_GET['cid']) : $intCategoryId;

        if ($bolShowCategorySelector) {
        	$objCategories = new mediaDirectoryCategory(null, null, 1);
            $strCategoryDropdown = $objCategories->listCategories($this->_objTpl, 3, $intCategoryId);
            $strCategoryName = $_ARRAYLANG['TXT_MEDIADIR_CATEGORY'];

            $strExpandedInputfields .= <<<EOF
<p><label>$strCategoryName</label><select class="mediadirInputfieldSearch" name="cid"><option value="">$strPleaseChoose</option>$strCategoryDropdown</select></p>
EOF;
        }

        $objInputfields = new mediaDirectoryInputfield($formId, true);
        $strExpandedInputfields .= $objInputfields->listInputfields(null, 4, null);

        return $strExpandedInputfields;
    }


    function searchEntries($arrData)
    {
        global $_ARRAYLANG, $_CORELANG, $objDatabase, $_LANGID, $objInit;

        $arrSelect = array();
        $arrFrom = array();
        $arrWhere = array();
        $arrOrder = array();
        $arrJoins = array();
        $arrFoundIds = array();
        $arrFoundLevelsCategories = array();
        $arrFoundCountries = array();
        $intCmdFormId = null;

        //build search term query
        $arrData['term'] = trim($arrData['term']);

        if (isset($_GET['cmd']) && $_GET['cmd'] != 'search') {
            $objForms = new mediaDirectoryForm();
            foreach ($objForms->arrForms as $intFormId => $arrForm) {
                if (!empty($arrForm['formCmd']) && ($arrForm['formCmd'] == $_GET['cmd'])) {
                    $intCmdFormId = intval($intFormId);
                }
            }

            //extract cid and lid from cmd
            if (empty($intCmdFormId)) {
                $arrLevelCategoryId = explode('-', $_GET['cmd']);
                if (count($arrLevelCategoryId) == 1) {
                    if (empty($this->arrSettings['settingsShowLevels']) && empty($arrData['cid'])) {
                        $arrData['cid'] = $arrLevelCategoryId[0];
                    } elseif (!empty($this->arrSettings['settingsShowLevels']) && empty($arrData['lid'])) {
                        $arrData['lid'] = $arrLevelCategoryId[0];
                    }
                } elseif (count($arrLevelCategoryId) == 2) {
                    if (empty($this->arrSettings['settingsShowLevels'])) {
                        $arrData['cid'] = empty($arrData['cid']) ? $arrLevelCategoryId[0] : $arrData['cid'];
                    } elseif (!empty($this->arrSettings['settingsShowLevels'])) {
                        $arrData['lid'] = empty($arrData['cid']) ? $arrLevelCategoryId[0] : $arrData['lid'];
                        $arrData['cid'] = empty($arrData['cid']) ? $arrLevelCategoryId[1] : $arrData['cid'];
                    }
                }
            }
        }

        $arrFinalFrom = array();

        //build level search query
        if (!empty($arrData['lid'])) {
            array_push($this->arrSearchLevels, intval($arrData['lid']));
            $this->getSearchLevelIds(intval($arrData['lid']));

            $arrWhere[]         = '(rel_level.level_id IN ('.join(',', $this->arrSearchLevels).') AND rel_level.entry_id=rel_inputfield.entry_id)';
            $levelFilterWhere   = '(rel_level.level_id IN ('.join(',', $this->arrSearchLevels).') AND rel_level.entry_id=rel_inputfield_final.entry_id)';
            $levelFrom          = DBPREFIX.'module_'.$this->moduleTablePrefix.'_rel_entry_levels AS rel_level';
            $arrFrom[]          = $levelFrom;
            $arrFinalFrom[]     = $levelFrom;
        }

        //build category search query
        if (!empty($arrData['cid'])) {
            array_push($this->arrSearchCategories, intval($arrData['cid']));
            $this->getSearchCategoryIds(intval($arrData['cid']));

            $arrWhere[]             = '(rel_category.category_id IN ('.join(',', $this->arrSearchCategories).') AND rel_category.entry_id=rel_inputfield.entry_id)';
            $categoryFilterWhere    = '(rel_category.category_id IN ('.join(',', $this->arrSearchCategories).') AND rel_category.entry_id=rel_inputfield_final.entry_id)';
            $categoryFrom           = DBPREFIX.'module_'.$this->moduleTablePrefix.'_rel_entry_categories AS rel_category';
            $arrFrom[]              = $categoryFrom;
            $arrFinalFrom[]         = $categoryFrom;
        }

        $arrFrom[]      = DBPREFIX.'module_'.$this->moduleName.'_entries AS entry';
        $arrWhere[]     = '(entry.`id` = rel_inputfield.`entry_id` AND entry.`confirmed` = 1 AND entry.`active` = 1)';

        if (!empty($arrData['term'])) {
            $strTerm        = contrexx_addslashes(trim($arrData['term']));

            $arrSelect[]    = 'rel_inputfield.`entry_id` AS `entry_id`';
            $arrSelect[]    = 'MATCH (rel_inputfield.`value`) AGAINST ("%'.$strTerm.'%")  AS score';
            
            $arrFrom[]      = DBPREFIX.'module_'.$this->moduleName.'_rel_entry_inputfields AS rel_inputfield';
            $arrFrom[]      = DBPREFIX.'module_'.$this->moduleName.'_inputfields AS inputfield';

            $strReplace     = '%" AND rel_inputfield.`value` LIKE "%';
            $strReplace     = preg_replace('/\s+/', $strReplace, $strTerm);
            
            $arrWhere[]     = 'rel_inputfield.`entry_id` != 0';
            $arrWhere[]     = '(rel_inputfield.`value` LIKE "%'.$strReplace.'%" AND (rel_inputfield.`field_id` = inputfield.`id` AND inputfield.`type` NOT IN (7,8,15,16,21)))';
            
            $arrOrder[]     = 'score DESC, rel_inputfield.`value` ASC';
        } else {
            $arrSelect[]    = 'rel_inputfield.`entry_id` AS `entry_id`';
            $arrFrom[]      = DBPREFIX.'module_'.$this->moduleTablePrefix.'_rel_entry_inputfields AS rel_inputfield';
            $arrWhere[]     = 'rel_inputfield.`entry_id` != 0';
            $arrOrder[]     = 'rel_inputfield.`value` ASC';
        }

        //search levels and categorie names
        if (intval($arrData['cid']) == 0 && $arrData['type'] == 'exp') {
            $arrFoundLevelsCategories = $this->searchLevelsCategories(1, $strTerm, $intCmdFormId);
        }
        $arrFoundIds = array_merge($arrFoundIds, $arrFoundLevelsCategories);
        
        //search countries
        $arrFoundCountries = $this->searchCountries($strTerm, $intCmdFormId);
        $arrFoundIds = array_merge($arrFoundIds, $arrFoundCountries);
        
        if ($intCmdFormId != 0) {
            $arrWhere[] = "rel_inputfield.`form_id` = '".$intCmdFormId."'";
        }
        
        if($objInit->mode == 'frontend') {
            $intToday = mktime();
            $arrWhere[] = "(`duration_type` = 1 OR (`duration_type` = 2 AND (`duration_start` < '$intToday' AND `duration_end` > '$intToday')))";
        }

        if (!empty($arrSelect) && !empty($arrFrom) && !empty($arrWhere) && !empty($arrOrder)) {
            $query = '
                SELECT
                    '.join(',', $arrSelect).'
                FROM
                    '.join(',', $arrFrom).'
                    '.join(',', $arrJoins).'
                WHERE
                    '.join(' AND ', $arrWhere).'
                GROUP BY
                    rel_inputfield.`entry_id`
                ORDER BY
                    '.join(',', $arrOrder).'
            ';

            if ($arrData['type'] == 'exp') {
                //build expanded search query
                $arrExternals = array('__cap', 'section', 'type', 'cmd', 'term', 'lid', 'cid', 'search', 'pos','scid','langId');
                foreach ($arrData as $intInputfieldId => $strExpTerm) {
                    if (!in_array($intInputfieldId, $arrExternals) && $strExpTerm != null) {
                        $objInputfields = new mediaDirectoryInputfield(null, true);
                        $intInputfieldType = $objInputfields->arrInputfields[$intInputfieldId]['type'];
                        $strExpTerm = contrexx_addslashes(trim($strExpTerm));
                        $strTableName = 'rel_inputfield_'.intval($intInputfieldId);
                        $arrExpJoin[]  = 'INNER JOIN '.DBPREFIX.'module_'.$this->moduleTablePrefix.'_rel_entry_inputfields AS '.$strTableName.' ON rel_inputfield_final.`entry_id` = '.$strTableName.'.`entry_id`';
                        
                        if ($intInputfieldType == '11') {
                            switch ($this->arrSettings['settingsClassificationSearch']) {
                                case 1:
                                    $strSearchOperator = '>=';
                                    break;
                                case 2:
                                    $strSearchOperator = '<=';
                                    break;
                                case 3:
                                    $strSearchOperator = '=';
                                    break;
                            }

                            $arrExpWhere[] = '('.$strTableName.'.`field_id` = '.intval($intInputfieldId).' AND '.$strTableName.'.`value` '.$strSearchOperator.' "'.$strExpTerm.'")';
                        } else if ($intInputfieldType == '3' || $intInputfieldType == '25') {
                            $arrExpWhere[] = '('.$strTableName.'.`field_id` = '.$intInputfieldId.' AND '.$strTableName.'.`value` = "'.$strExpTerm.'")';
                        } else {
                            $arrExpWhere[] = '('.$strTableName.'.`field_id` = '.intval($intInputfieldId).' AND '.$strTableName.'.`value` LIKE "%'.$strExpTerm.'%")';
                        }
                    }
                }

                if (!empty($arrExpJoin) && !empty($arrExpWhere)) {
                    if (!empty($levelFilterWhere)) {
                        $arrExpWhere[] = $levelFilterWhere;
                    }
                    if (!empty($categoryFilterWhere)) {
                        $arrExpWhere[] = $categoryFilterWhere;
                    }
                    if (!empty($arrFinalFrom)) {
                        $finalFrom = join(',', $arrFinalFrom).',';
                    }
                    
                    $expJoin  = join(' ', $arrExpJoin);
                    $expWhere = join(' AND ', $arrExpWhere);

                    if (!empty($arrData['term'])) {  
                        $query = '
                            SELECT
                                rel_inputfield_final.`entry_id` AS `entry_id`
                            FROM
                                '.$finalFrom.'
                                '.DBPREFIX.'module_'.$this->moduleTablePrefix.'_rel_entry_inputfields AS rel_inputfield_final
                            
                            INNER JOIN
                                 ('.$query.') AS rel_inputfield
                            ON rel_inputfield_final.`entry_id` = rel_inputfield.`entry_id`
                            
                            '.$expJoin.'
                            
                            WHERE
                                '.$expWhere.'
                        ';
                    } else {
                        $query = '
                            SELECT
                                rel_inputfield_final.`entry_id` AS `entry_id`
                            FROM
                                '.$finalFrom.'
                                '.DBPREFIX.'module_'.$this->moduleTablePrefix.'_rel_entry_inputfields AS rel_inputfield_final
                            
                            '.$expJoin.'
                            
                            WHERE
                                '.$expWhere.'
                        ';
                   }
                } 
            }
            
            $objRsSearchEntries = $objDatabase->Execute($query);

            if ($objRsSearchEntries !== false) {
                while (!$objRsSearchEntries->EOF) {
                    if (!in_array(intval($objRsSearchEntries->fields['entry_id']), $this->arrFoundIds)) {
                        $this->arrFoundIds[] = intval($objRsSearchEntries->fields['entry_id']);
                    }
                    $objRsSearchEntries->MoveNext();
                }
            }
        }
    }



    function getSearchLevelIds($intLevelId)
    {
        global $objDatabase;

        $objResultSearchLevels = $objDatabase->Execute("SELECT id FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_levels WHERE parent_id='$intLevelId' ");

        if ($objResultSearchLevels) {
            while (!$objResultSearchLevels->EOF) {
                if (!empty($objResultSearchLevels->fields['id'])) {
                    array_push($this->arrSearchLevels, $objResultSearchLevels->fields['id']);
                }

                $this->getSearchLevelIds($objResultSearchLevels->fields['id']);
                $objResultSearchLevels->MoveNext();
            }
        }
    }



    function getSearchCategoryIds($intCatId)
    {
        global $objDatabase;
        
        $objResultSearchCategories = $objDatabase->Execute("SELECT id FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_categories WHERE parent_id='$intCatId'");

        if ($objResultSearchCategories) {
            while (!$objResultSearchCategories->EOF) {
                if (!empty($objResultSearchCategories->fields['id'])) {
                    array_push($this->arrSearchCategories, $objResultSearchCategories->fields['id']);
                }

                $this->getSearchCategoryIds($objResultSearchCategories->fields['id']);
                $objResultSearchCategories->MoveNext();
            }
        }
    }
    
    //OSEC CUSTOMIZING (ev. �bernehmen und f�r levels ausbauen)
    function searchLevelsCategories($intType, $strTerm, $intCmdFormId)
    {
        global $objDatabase;
        
        $arrFoundIds = array();
        
        if ($intCmdFormId != 0) {
            $strWhereForm = "AND ".DBPREFIX."module_".$this->moduleTablePrefix."_entries.form_id = '".$intCmdFormId."'";
        }
        
        $objResultSearchCategories = $objDatabase->Execute("
        SELECT
            ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_categories.entry_id AS entry_id
        FROM
            ".DBPREFIX."module_".$this->moduleTablePrefix."_categories_names
        INNER JOIN 
            ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_categories 
        ON 
            ".DBPREFIX."module_".$this->moduleTablePrefix."_categories_names.category_id = ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_categories.category_id 
        INNER JOIN 
            ".DBPREFIX."module_".$this->moduleTablePrefix."_entries 
        ON 
            ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_categories.entry_id = ".DBPREFIX."module_".$this->moduleTablePrefix."_entries.id
        WHERE
            ".DBPREFIX."module_".$this->moduleTablePrefix."_categories_names.category_name LIKE '%".$strTerm."%'
        AND 
            ".DBPREFIX."module_".$this->moduleTablePrefix."_entries.active = '1'
            ".$strWhereForm."
        GROUP BY
            ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_categories.entry_id"
        );

        if ($objResultSearchCategories) {
            while (!$objResultSearchCategories->EOF) {
                if (!empty($objResultSearchCategories->fields['entry_id'])) {
                    array_push($arrFoundIds, $objResultSearchCategories->fields['entry_id']);
                }
                
                $objResultSearchCategories->MoveNext();
            }
        }
        
        return $arrFoundIds;
    }
    
    //OSEC CUSTOMIZING (ev. �bernehmen)
    function searchCountries($strTerm, $intCmdFormId)
    {
        global $objDatabase;
        
        $arrFoundIds = array();
        
        if ($intCmdFormId != 0) {
            $strWhereForm = "AND ".DBPREFIX."module_".$this->moduleTablePrefix."_entries.form_id = '".$intCmdFormId."'";
        }
        
        $objResultSearchCountry = $objDatabase->Execute("
        SELECT
            ".DBPREFIX."module_".$this->moduleTablePrefix."_entries.id AS entry_id
		FROM
			".DBPREFIX."module_".$this->moduleTablePrefix."_inputfields
			INNER JOIN 
                ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_inputfields 
			ON 
			    ".DBPREFIX."module_".$this->moduleTablePrefix."_inputfields.id = ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_inputfields.field_id
			INNER JOIN 
		        contrexx_lib_country 
		    ON 
		        ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_inputfields.value = ".DBPREFIX."lib_country.id
            INNER JOIN 
                ".DBPREFIX."module_".$this->moduleTablePrefix."_entries 
            ON 
                ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_inputfields.entry_id = ".DBPREFIX."module_".$this->moduleTablePrefix."_entries.id
		WHERE
            ".DBPREFIX."module_".$this->moduleTablePrefix."_inputfields.type = '25' 
		AND 
		    ".DBPREFIX."lib_country.name LIKE '%".$strTerm."%' 
		AND 
		    ".DBPREFIX."module_".$this->moduleTablePrefix."_entries.active = '1'
            ".$strWhereForm."
		GROUP BY
		  ".DBPREFIX."module_".$this->moduleTablePrefix."_entries.id"
        );

        if ($objResultSearchCountry) {
            while (!$objResultSearchCountry->EOF) {
                if (!empty($objResultSearchCountry->fields['entry_id'])) {
                    array_push($arrFoundIds, $objResultSearchCountry->fields['entry_id']);
                }
                
                $objResultSearchCountry->MoveNext();
            }
        }
        
        return $arrFoundIds;
    }
}
