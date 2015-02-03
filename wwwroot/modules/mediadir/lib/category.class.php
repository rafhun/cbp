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
 * Media  Directory Category Class
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Comvation Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_mediadir
 * @todo        Edit PHP DocBlocks!
 */

/**
 * Media Directory Category Class
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_mediadir
 */
class mediaDirectoryCategory extends mediaDirectoryLibrary
{
    private $intCategoryId;
    private $intParentId;
    private $intNumEntries;
    private $bolGetChildren;
    private $intRowCount;
    private $arrExpandedCategoryIds = array();

    private $strSelectedOptions;
    private $strNotSelectedOptions;
    private $arrSelectedCategories;
    private $intCategoriesSortCounter = 0;
    private $strNavigationPlaceholder;

    public $arrCategories = array();


    /**
     * Constructor
     */
    function __construct($intCategoryId=null, $intParentId=null, $bolGetChildren=1)
    {
        $this->intCategoryId = intval($intCategoryId);
        $this->intParentId = intval($intParentId);
        $this->bolGetChildren = intval($bolGetChildren);

        parent::getSettings();
        parent::getFrontendLanguages();
        $this->loadCategories();
    }

    public function loadCategories() {
        $this->arrCategories = self::getCategories($this->intCategoryId, $this->intParentId);
    }

    function getCategories($intCategoryId=null, $intParentId=null)
    {
        global $_ARRAYLANG, $_CORELANG, $objDatabase, $_LANGID, $objInit;

        $arrCategories = array();

        if(!empty($intCategoryId)) {
            $whereCategoryId = "cat.id='".$intCategoryId."' AND";
            $whereParentId = '';
        } else {
            if(!empty($intParentId)) {
                $whereParentId = "AND (cat.parent_id='".$intParentId."') ";
            } else {
                $whereParentId = "AND (cat.parent_id='0') ";
            }

            $whereCategoryId = null;
        }

        if($objInit->mode == 'frontend') {
            $whereActive = "AND (cat.active='1') ";
        } else {
			$whereActive = '';
		}

        switch($this->arrSettings['settingsCategoryOrder']) {
            case 0;
                //custom order
                $sortOrder = "cat.`order` ASC";
                break;
            case 1;
            case 2;
                //abc order
                $sortOrder = "cat_names.`category_name`";
                break;
        }

        $objCategories = $objDatabase->Execute("
            SELECT
                cat.`id` AS `id`,
                cat.`parent_id` AS `parent_id`,
                cat.`order` AS `order`,
                cat.`show_entries` AS `show_entries`,
                cat.`show_subcategories` AS `show_subcategories`,
                cat.`picture` AS `picture`,
                cat.`active` AS `active`,
                cat_names.`category_name` AS `name`,
                cat_names.`category_description` AS `description`
            FROM
                ".DBPREFIX."module_".$this->moduleTablePrefix."_categories AS cat,
                ".DBPREFIX."module_".$this->moduleTablePrefix."_categories_names AS cat_names
            WHERE
                ($whereCategoryId cat_names.category_id=cat.id)
                $whereParentId
                $whereActive
                AND (cat_names.lang_id='".$_LANGID."')
            ORDER BY
                ".$sortOrder."
        ");

        if ($objCategories !== false) {
            while (!$objCategories->EOF) {
                $arrCategory = array();
                $arrCategoryName = array();
                $arrCategoryDesc = array();
                $this->intNumEntries = 0;

                //get lang attributes
                $arrCategoryName[0] = $objCategories->fields['name'];
                $arrCategoryDesc[0] = $objCategories->fields['description'];

                $objCategoryAttributes = $objDatabase->Execute("
                    SELECT
                        `lang_id` AS `lang_id`,
                        `category_name` AS `name`,
                        `category_description` AS `description`
                    FROM
                        ".DBPREFIX."module_".$this->moduleTablePrefix."_categories_names
                    WHERE
                        category_id=".$objCategories->fields['id']."
                ");

                if ($objCategoryAttributes !== false) {
                    while (!$objCategoryAttributes->EOF) {
                        $arrCategoryName[$objCategoryAttributes->fields['lang_id']] = htmlspecialchars($objCategoryAttributes->fields['name'], ENT_QUOTES, CONTREXX_CHARSET);
                        $arrCategoryDesc[$objCategoryAttributes->fields['lang_id']] = htmlspecialchars($objCategoryAttributes->fields['description'], ENT_QUOTES, CONTREXX_CHARSET);

                        $objCategoryAttributes->MoveNext();
                    }
                }

                $arrCategory['catId'] = intval($objCategories->fields['id']);
                $arrCategory['catParentId'] = intval($objCategories->fields['parent_id']);
                $arrCategory['catOrder'] = intval($objCategories->fields['order']);
                $arrCategory['catName'] = $arrCategoryName;
                $arrCategory['catDescription'] = $arrCategoryDesc;
                $arrCategory['catPicture'] = htmlspecialchars($objCategories->fields['picture'], ENT_QUOTES, CONTREXX_CHARSET);
                if($this->arrSettings['settingsCountEntries'] == 1 || $objInit->mode == 'backend') {
                    $arrCategory['catNumEntries'] = $this->countEntries(intval($objCategories->fields['id']), isset($_GET['lid']) ? intval($_GET['lid']) : NULL);
                }
                $arrCategory['catShowEntries'] = intval($objCategories->fields['show_entries']);
                $arrCategory['catShowSubcategories'] = intval($objCategories->fields['show_subcategories']);
                $arrCategory['catActive'] = intval($objCategories->fields['active']);

                if($this->bolGetChildren){
                    $arrCategory['catChildren'] = self::getCategories(null, $objCategories->fields['id']);
                }

                $arrCategories[$objCategories->fields['id']] = $arrCategory;
                $objCategories->MoveNext();
            }
        }

        return $arrCategories;
    }



    function listCategories($objTpl, $intView, $intCategoryId=null, $arrParentIds=null, $intEntryId=null, $arrExistingBlocks=null, $intStartLevel=1)
    {
        global $_ARRAYLANG, $_CORELANG, $objDatabase, $objInit;

        if(!isset($arrParentIds)) {
            $arrCategories = $this->arrCategories;
        } else {
            $arrCategoryChildren = $this->arrCategories;

            foreach ($arrParentIds as $key => $intParentId) {
                $arrCategoryChildren = $arrCategoryChildren[$intParentId]['catChildren'];
            }
            $arrCategories = $arrCategoryChildren;
        }


        switch ($intView) {
            case 1:
                //Backend View
                $exp_cat = isset($_GET['exp_cat']) ? $_GET['exp_cat'] : '';
                foreach ($arrCategories as $key => $arrCategory) {
                    //generate space
                    $spacer = null;
                    $intSpacerSize = null;
                    $intSpacerSize = (count($arrParentIds)*21);
                    $spacer .= '<img src="images/icons/pixel.gif" border="0" width="'.$intSpacerSize.'" height="11" alt="" />';

                    //check expanded categories
                    if($exp_cat == 'all') {
                        $bolExpandCategory = true;
                    } else {
                        $this->arrExpandedCategoryIds = array();
                        $bolExpandCategory = $this->getExpandedCategories($exp_cat, array($arrCategory));
                    }

                    if(!empty($arrCategory['catChildren'])) {
                        if((in_array($arrCategory['catId'], $this->arrExpandedCategoryIds) && $bolExpandCategory) || $exp_cat == 'all'){
                            $strCategoryIcon = '<a href="index.php?cmd='.$this->moduleName.'&amp;exp_cat='.$arrCategory['catParentId'].'"><img src="images/icons/minuslink.gif" border="0" alt="{'.$this->moduleLangVar.'_CATEGORY_NAME}" title="{'.$this->moduleLangVar.'_CATEGORY_NAME}" /></a>';
                        } else {
                            $strCategoryIcon = '<a href="index.php?cmd='.$this->moduleName.'&amp;exp_cat='.$arrCategory['catId'].'"><img src="images/icons/pluslink.gif" border="0" alt="{'.$this->moduleLangVar.'_CATEGORY_NAME}" title="{'.$this->moduleLangVar.'_CATEGORY_NAME}" /></a>';
                        }
                    } else {
                        $strCategoryIcon = '<img src="images/icons/pixel.gif" border="0" width="11" height="11" alt="{'.$this->moduleLangVar.'_CATEGORY_NAME}" title="{'.$this->moduleLangVar.'_CATEGORY_NAME}" />';
                    }

                    //parse variables
                    $objTpl->setVariable(array(
                        $this->moduleLangVar.'_CATEGORY_ROW_CLASS' =>  $this->intRowCount%2==0 ? 'row1' : 'row2',
                        $this->moduleLangVar.'_CATEGORY_ID' => $arrCategory['catId'],
                        $this->moduleLangVar.'_CATEGORY_ORDER' => $arrCategory['catOrder'],
                        $this->moduleLangVar.'_CATEGORY_NAME' => contrexx_raw2xhtml($arrCategory['catName'][0]),
                        $this->moduleLangVar.'_CATEGORY_DESCRIPTION' => $arrCategory['catDescription'][0],
                        $this->moduleLangVar.'_CATEGORY_PICTURE' => $arrCategory['catPicture'],
                        $this->moduleLangVar.'_CATEGORY_NUM_ENTRIES' => $arrCategory['catNumEntries'],
                        $this->moduleLangVar.'_CATEGORY_ICON' => $spacer.$strCategoryIcon,
                        $this->moduleLangVar.'_CATEGORY_VISIBLE_STATE_ACTION' => $arrCategory['catActive'] == 0 ? 1 : 0,
                        $this->moduleLangVar.'_CATEGORY_VISIBLE_STATE_IMG' => $arrCategory['catActive'] == 0 ? 'off' : 'on',
                    ));

                    $objTpl->parse($this->moduleName.'CategoriesList');
                    $arrParentIds[] = $arrCategory['catId'];
                    $this->intRowCount++;

                    //get children
                    if(!empty($arrCategory['catChildren'])){
                        if($bolExpandCategory) {
                            self::listCategories($objTpl, 1, $intCategoryId, $arrParentIds);
                        }
                    }

                    @array_pop($arrParentIds);
                }
                break;
            case 2:
                //Frontend View
                $intNumBlocks = count($arrExistingBlocks);


                if($this->arrSettings['settingsCategoryOrder'] == 2) {
                    $i = $intNumBlocks-1;
                } else {
                    $i = 0;
                }

                //set first index header
                if($this->arrSettings['settingsCategoryOrder'] == 2) {
                    $strFirstIndexHeader = null;
                }

                $intNumCategories = count($arrCategories);

                if($intNumCategories%$intNumBlocks != 0) {
                	$intNumCategories = $intNumCategories+($intNumCategories%$intNumBlocks);
                }

                $intNumPerRow = intval($intNumCategories/$intNumBlocks);
                $x=0;

                foreach ($arrCategories as $key => $arrCategory) {
                    $strLevelId = isset($_GET['lid']) ? "&amp;lid=".intval($_GET['lid']) : '';

                    if($this->arrSettings['settingsCategoryOrder'] == 2) {
                        $strIndexHeader = strtoupper(substr($arrCategory['catName'][0],0,1));

                        if($strFirstIndexHeader != $strIndexHeader) {
                            if ($i < $intNumBlocks-1) {
                                ++$i;
                            } else {
                                $i = 0;
                            }
                            $strIndexHeaderTag = '<span class="'.$this->moduleName.'LevelCategoryIndexHeader">'.$strIndexHeader.'</span><br />';
                        } else {
                            $strIndexHeaderTag = null;
                        }
                    } else {
                        if($x == $intNumPerRow) {
                            ++$i;

                            if($i == $intNumBlocks) {
                                $i = 0;
                            }

                            $x = 1;
                        } else {
                            $x++;
                        }

                        $strIndexHeaderTag = null;
                    }

                    //get ids
                    if(isset($_GET['cmd'])) {
                        $strCategoryCmd = '&amp;cmd='.$_GET['cmd'];
                    } else {
                        $strCategoryCmd = null;
                    }

                    //parse variables
                    $objTpl->setVariable(array(
                        $this->moduleLangVar.'_CATEGORY_LEVEL_ID' => $arrCategory['catId'],
                        $this->moduleLangVar.'_CATEGORY_LEVEL_NAME' => contrexx_raw2xhtml($arrCategory['catName'][0]),
                        $this->moduleLangVar.'_CATEGORY_LEVEL_LINK' => $strIndexHeaderTag.'<a href="index.php?section='.$this->moduleName.$strCategoryCmd.$strLevelId.'&amp;cid='.$arrCategory['catId'].'">'.contrexx_raw2xhtml($arrCategory['catName'][0]).'</a>',
                        $this->moduleLangVar.'_CATEGORY_LEVEL_DESCRIPTION' => $arrCategory['catDescription'][0],
                        $this->moduleLangVar.'_CATEGORY_LEVEL_PICTURE' => '<img src="'.$arrCategories[$intCategoryId]['catPicture'].'" border="0" alt="'.contrexx_raw2xhtml($arrCategories[$intCategoryId]['catName'][0]).'" />',
                        $this->moduleLangVar.'_CATEGORY_LEVEL_PICTURE_SOURCE' => $arrCategories[$intCategoryId]['catPicture'],
                        $this->moduleLangVar.'_CATEGORY_LEVEL_NUM_ENTRIES' => $arrCategory['catNumEntries'],
                    ));

                    $intBlockId = $arrExistingBlocks[$i];


                    $objTpl->parse($this->moduleName.'CategoriesLevels_row_'.$intBlockId);
                    $objTpl->clearVariables();

                    $strFirstIndexHeader = $strIndexHeader;
                }
                break;
            case 3:
                //Category Dropdown Menu
				$strDropdownOptions = '';
                foreach ($arrCategories as $key => $arrCategory) {
                    $spacer = null;
                    $intSpacerSize = null;

                    if($arrCategory['catId'] == $intCategoryId) {
                        $strSelected = 'selected="selected"';
                    } else {
                        $strSelected = '';
                    }

                    //generate space
                    $intSpacerSize = (count($arrParentIds));
                    for($i = 0; $i < $intSpacerSize; $i++) {
                        $spacer .= "----";
                    }

                    if($spacer != null) {
                    	$spacer .= "&nbsp;";
                    }

                    $strDropdownOptions .= '<option value="'.$arrCategory['catId'].'" '.$strSelected.' >'.$spacer.contrexx_raw2xhtml($arrCategory['catName'][0]).'</option>';

                    if(!empty($arrCategory['catChildren'])) {
                        $arrParentIds[] = $arrCategory['catId'];
                        $strDropdownOptions .= self::listCategories($objTpl, 3, $intCategoryId, $arrParentIds);
                        @array_pop($arrParentIds);
                    }
                }

                return $strDropdownOptions;
                break;
            case 4:
                //Category Selector (modify view)
                if(!isset($this->arrSelectedCategories) && $intEntryId!=null) {
                    $this->arrSelectedCategories = array();

                    $objCategorySelector = $objDatabase->Execute("
                        SELECT
                            `category_id`
                        FROM
                            ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_categories
                        WHERE
                            `entry_id` = '".$intEntryId."'
                    ");

                    if ($objCategorySelector !== false) {
                        while (!$objCategorySelector->EOF) {
                            $this->arrSelectedCategories[] = intval($objCategorySelector->fields['category_id']);
                            $objCategorySelector->MoveNext();
                        }
                    }
                }

                foreach ($arrCategories as $key => $arrCategory) {
                    $spacer = null;
                    $intSpacerSize = null;
                    $strOptionId = $arrCategory['catId'];

                     //generate space
                    $intSpacerSize = (count($arrParentIds));
                    for($i = 0; $i < $intSpacerSize; $i++) {
                        $spacer .= "----";
                    }

                    if($spacer != null) {
                        $spacer .= "&nbsp;";
                    }

                    if(in_array($arrCategory['catId'], $this->arrSelectedCategories)) {
                      $this->strSelectedOptions .= '<option name="'.$strOptionId.'" value="'.$arrCategory['catId'].'">'.$spacer.contrexx_raw2xhtml($arrCategory['catName'][0]).'</option>';
                    } else {
                      $this->strNotSelectedOptions .= '<option name="'.$strOptionId.'" value="'.$arrCategory['catId'].'">'.$spacer.contrexx_raw2xhtml($arrCategory['catName'][0]).'</option>';
                    }

                    $this->intCategoriesSortCounter++;
                    if(!empty($arrCategory['catChildren'])) {
                        $arrParentIds[] = $arrCategory['catId'];
                        self::listCategories($objTpl, 4, $intCategoryId, $arrParentIds, $intEntryId);
                        @array_pop($arrParentIds);
                    }
                }

                $arrSelectorOptions['selected'] = $this->strSelectedOptions;
                $arrSelectorOptions['not_selected'] = $this->strNotSelectedOptions;

                return $arrSelectorOptions;
                
                break;
            case 5:
                //Frontend View Detail
                $strLevelId = isset($_GET['lid']) ? "&amp;lid=".intval($_GET['lid']) : '';

                $objTpl->setVariable(array(
                    $this->moduleLangVar.'_CATEGORY_LEVEL_ID' => $arrCategories[$intCategoryId]['catId'],
                    $this->moduleLangVar.'_CATEGORY_LEVEL_NAME' => contrexx_raw2xhtml($arrCategories[$intCategoryId]['catName'][0]),
                    $this->moduleLangVar.'_CATEGORY_LEVEL_LINK' => '<a href="index.php?section='.$this->moduleName.$strLevelId.'&amp;cid='.$arrCategories[$intCategoryId]['catId'].'">'.contrexx_raw2xhtml($arrCategories[$intCategoryId]['catName'][0]).'</a>',
                    $this->moduleLangVar.'_CATEGORY_LEVEL_DESCRIPTION' => $arrCategories[$intCategoryId]['catDescription'][0],
                    $this->moduleLangVar.'_CATEGORY_LEVEL_PICTURE' => '<img src="'.$arrCategories[$intCategoryId]['catPicture'].'.thumb" border="0" alt="'.$arrCategories[$intCategoryId]['catName'][0].'" />',
                    $this->moduleLangVar.'_CATEGORY_LEVEL_PICTURE_SOURCE' => $arrCategories[$intCategoryId]['catPicture'],
                    $this->moduleLangVar.'_CATEGORY_LEVEL_NUM_ENTRIES' => $arrCategories[$intCategoryId]['catNumEntries'],
                ));

                if(!empty($arrCategories[$intCategoryId]['catPicture']) && $this->arrSettings['settingsShowCategoryImage'] == 1) {
                    $objTpl->parse($this->moduleName.'CategoryLevelPicture');
                } else {
                    $objTpl->hideBlock($this->moduleName.'CategoryLevelPicture');
                }

                if(!empty($arrCategories[$intCategoryId]['catDescription'][0]) && $this->arrSettings['settingsShowCategoryDescription'] == 1) {
                    $objTpl->parse($this->moduleName.'CategoryLevelDescription');
                } else {
                    $objTpl->hideBlock($this->moduleName.'CategoryLevelDescription');
                }

                if(!empty($arrCategories)) {
                    $objTpl->parse($this->moduleName.'CategoryLevelDetail');
                } else {
                    $objTpl->hideBlock($this->moduleName.'CategoryLevelDetail');
                }

                break;
            case 6:
                //Frontend Tree Placeholder
                foreach ($arrCategories as $key => $arrCategory) {
                	$this->arrExpandedCategoryIds = array();
                    $bolExpandCategory = $this->getExpandedCategories($intCategoryId, array($arrCategory));
                    $strLevelId = isset($_GET['lid']) ? "&amp;lid=".intval($_GET['lid']) : '';
                    $strLinkClass = $bolExpandCategory ? 'active' : 'inactive';
                    $strListClass = 'level_'.intval(count($arrParentIds)+$intStartLevel);
                    
                    $this->strNavigationPlaceholder .= '<li class="'.$strListClass.'"><a href="index.php?section='.$this->moduleName.$strLevelId.'&amp;cid='.$arrCategory['catId'].'" class="'.$strLinkClass.'">'.contrexx_raw2xhtml($arrCategory['catName'][0]).'</a></li>';
            
                    $arrParentIds[] = $arrCategory['catId'];

                    //get children
                    if(!empty($arrCategory['catChildren']) && $arrCategory['catShowSubcategories'] == 1){
                    	if($bolExpandCategory) {
                            self::listCategories($objTpl, 6, $intCategoryId, $arrParentIds, null, null, $intStartLevel);
                    	}                    
                    }
                    @array_pop($arrParentIds);
                }
                
                return $this->strNavigationPlaceholder;
                
                break;
        }
    }



    function getExpandedCategories($intExpand, $arrData)
    {
        foreach ($arrData as $key => $arrCategory) {
            if ($arrCategory['catId'] != $intExpand) {
                if(!empty($arrCategory['catChildren'])) {
                    $this->arrExpandedCategoryIds[] = $arrCategory['catId'];
                    $this->getExpandedCategories($intExpand, $arrCategory['catChildren']);
                }
            } else {
                $this->arrExpandedCategoryIds[] = $arrCategory['catId'];
                $this->arrExpandedCategoryIds[] = "found";
            }
        }

        if(in_array("found", $this->arrExpandedCategoryIds)) {
            return true;
        } else {
           return false;
        }


    }



    function saveCategory($arrData, $intCategoryId=null)
    {
        global $_ARRAYLANG, $_CORELANG, $objDatabase, $_LANGID;

        //get data
        $intId = intval($intCategoryId);
        $intParentId = intval($arrData['categoryPosition']);
        $intShowEntries = intval($arrData['categoryShowEntries']);
        $intShowCategories = intval($arrData['categoryShowSubcategories']);
        $intActive = intval($arrData['categoryActive']);
        $strPicture = contrexx_addslashes(contrexx_strip_tags($arrData['categoryImage']));

        $arrName = $arrData['categoryName'];
       
        $arrDescription = $arrData['categoryDescription'];

        if(empty($intId)) {
            //insert new category
            $objInsertAttributes = $objDatabase->Execute("
                INSERT INTO
                    ".DBPREFIX."module_".$this->moduleTablePrefix."_categories
                SET
                    `parent_id`='".$intParentId."',
                    `order`= 0,
                    `show_entries`='".$intShowEntries."',
                    `show_subcategories`='".$intShowCategories."',
                    `picture`='".$strPicture."',
                    `active`='".$intActive."'
            ");

            if($objInsertAttributes !== false) {
                $intId = $objDatabase->Insert_ID();

                foreach ($this->arrFrontendLanguages as $key => $arrLang) {
                    if(empty($arrName[0])) $arrName[0] = "[[".$_ARRAYLANG['TXT_MEDIADIR_NEW_CATEGORY']."]]";

                    $strName = $arrName[$arrLang['id']];
                    $strDescription = $arrDescription[$arrLang['id']];

                    if(empty($strName)) $strName = $arrName[0];
                    if(empty($strDescription)) $strDescription = $arrDescription[0];

                    $objInsertNames = $objDatabase->Execute("
                        INSERT INTO
                            ".DBPREFIX."module_".$this->moduleTablePrefix."_categories_names
                        SET
                            `lang_id`='".intval($arrLang['id'])."',
                            `category_id`='".intval($intId)."',
                            `category_name`='".contrexx_raw2db($strName)."',
                            `category_description`='".contrexx_raw2db($strDescription)."'
                    ");
                }

                if($objInsertNames !== false) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            //update category
            if($intParentId == $intCategoryId) {
                $parentSql = null;
            } else {
                $parentSql = "`parent_id`='".$intParentId."',";
            }

            $objUpdateAttributes = $objDatabase->Execute("
                UPDATE
                    ".DBPREFIX."module_".$this->moduleTablePrefix."_categories
                SET
                    ".$parentSql."
                    `show_entries`='".$intShowEntries."',
                    `show_subcategories`='".$intShowCategories."',
                    `picture`='".$strPicture."',
                    `active`='".$intActive."'
                WHERE
                    `id`='".$intId."'
            ");

            if($objUpdateAttributes !== false) {
                
                $objDeleteNames = $objDatabase->Execute("DELETE FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_categories_names WHERE category_id='".$intId."'");

                if($objInsertNames !== false) {
                    foreach ($this->arrFrontendLanguages as $key => $arrLang) {
                        if(empty($arrName[0])) $arrName[0] = "[[".$_ARRAYLANG['TXT_MEDIADIR_NEW_CATEGORY']."]]";
                        
                        $strName = $arrName[$arrLang['id']];
                        $strDescription = $arrDescription[$arrLang['id']];

                        if(empty($strName)) $strName = $arrName[0];
                        if(empty($strDescription)) $strDescription = $arrDescription[0];

                        $objInsertNames = $objDatabase->Execute("
                            INSERT INTO
                                ".DBPREFIX."module_".$this->moduleTablePrefix."_categories_names
                            SET
                                `lang_id`='".intval($arrLang['id'])."',
                                `category_id`='".intval($intId)."',
                                `category_name`='".contrexx_raw2db(contrexx_input2raw($strName))."',
                                `category_description`='".contrexx_raw2db(contrexx_input2raw($strDescription))."'
                        ");
                    }

                    if($objInsertNames !== false) {
                        return true;
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
    }




    function deleteCategory($intCategoryId=null)
    {
        global $objDatabase;

        $intCategoryId = intval($intCategoryId);

        $objSubCategoriesRS = $objDatabase->Execute("SELECT id FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_categories WHERE parent_id='".$intCategoryId."'");
        if ($objSubCategoriesRS !== false) {
            while (!$objSubCategoriesRS->EOF) {
                $intSubCategoryId = $objSubCategoriesRS->fields['id'];
                $this->deleteCategory($intSubCategoryId);
                $objSubCategoriesRS->MoveNext();
            };
        }

        $objDeleteCategoryRS = $objDatabase->Execute("DELETE FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_categories WHERE id='$intCategoryId'");
        $objDeleteCategoryRS = $objDatabase->Execute("DELETE FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_categories_names WHERE category_id='$intCategoryId'");
        $objDeleteCategoryRS = $objDatabase->Execute("DELETE FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_categories WHERE category_id='$intCategoryId'");

        if ($objDeleteCategoryRS !== false) {
            return true;
        } else {
            return false;
        }
    }



    function countEntries($intCategoryId=null, $intLevelId=null)
    {
        global $objDatabase;

        $intCategoryId = intval($intCategoryId);
        $intLevelId = intval($intLevelId);

        $objSubCategoriesRS = $objDatabase->Execute("SELECT id FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_categories WHERE parent_id='".$intCategoryId."'");
        if ($objSubCategoriesRS !== false) {
            while (!$objSubCategoriesRS->EOF) {
                $intSubCategoryId = $objSubCategoriesRS->fields['id'];
                $this->countEntries($intSubCategoryId, $intLevelId);
                $objSubCategoriesRS->MoveNext();
            };
        }
        
        $whereCategory = '';
        if ($intCategoryId && $intCategoryId > 0) {
            $whereCategory = " AND `rel_categories`.`category_id` = " . intval($intCategoryId);
        }
        $objCountEntriesRS = $objDatabase->Execute("
                                                SELECT COUNT(*) as c
                                                    FROM
                                                        `" . DBPREFIX . "module_".$this->moduleTablePrefix."_entries` AS `entries`
                                                INNER JOIN
                                                    `".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_categories` AS `rel_categories`
                                                ON
                                                    `rel_categories`.`entry_id` = `entries`.`id`
                                                WHERE
                                                    `entries`.`active` = 1
                                                AND ((`entries`.`duration_type`=2 AND `entries`.`duration_start` <= ".time()." AND `entries`.`duration_end` >= ".time().") OR (`entries`.`duration_type`=1))
                                                " . $whereCategory . "
                                                GROUP BY
                                                    `rel_categories`.`category_id`");

        $this->intNumEntries += $objCountEntriesRS->fields['c'];

        return intval($this->intNumEntries);
    }



    function saveOrder($arrData) {
        global $objDatabase;

        foreach($arrData['catOrder'] as $intCatId => $intCatOrder) {
            $objRSCatOrder = $objDatabase->Execute("UPDATE ".DBPREFIX."module_".$this->moduleTablePrefix."_categories SET `order`='".intval($intCatOrder)."' WHERE `id`='".intval($intCatId)."'");

            if ($objRSCatOrder === false) {
                return false;
            }
        }

        return true;
    }
}
?>
