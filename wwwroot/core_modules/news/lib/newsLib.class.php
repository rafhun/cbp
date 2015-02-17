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
 * News library
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author Comvation Development Team <info@comvation.com>
 * @version 1.0.0
 * @package     contrexx
 * @subpackage  coremodule_news
 * @todo        Edit PHP DocBlocks!
 */

/**
 * News library
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author Comvation Development Team <info@comvation.com>
 * @access public
 * @version 1.0.0
 * @package     contrexx
 * @subpackage  coremodule_news
 */
class newsLibrary
{
    /**
    * NestedSet object
    *
    * @access   protected
    * @var      DB_NestedSet
    */
    protected $objNestedSet;

    /**
    * Id of the nested set root node
    *
    * @access   protected
    * @var      integer
    */
    protected $nestedSetRootId;

    /**
     * Initializes the NestedSet object
     * which is needed to manage the news categories.
     *
     * @access  public
     */
    public function __construct()
    {
        global $objDatabase;

        //nestedSet setup
        $arrTableStructure = array(
            'catid'     => 'id',
            'parent_id' => 'rootid',
            'left_id'   => 'l',
            'right_id'  => 'r',
            'sorting'   => 'norder',
            'level'     => 'level',
        );
        $objNs = new DB_NestedSet($arrTableStructure);
        $this->objNestedSet = $objNs->factory('ADODB', $objDatabase, $arrTableStructure);
        $this->objNestedSet->setAttr(array(
            'node_table'    => DBPREFIX.'module_news_categories',
            'lock_table'    => DBPREFIX.'module_news_categories_locks',
        ));

        if (count($rootNodes = $this->objNestedSet->getRootNodes()) > 0) {
            foreach ($rootNodes as $rootNode) {
                $this->nestedSetRootId = $rootNode->id;
                break;
            }
        } else {
            // create first entry of sequence table for NestedSet
            $objResult = $objDatabase->SelectLimit("SELECT `id` FROM `".DBPREFIX."module_news_categories_catid`", 1);
            if ($objResult->RecordCount() == 0) {
                $objDatabase->Execute("INSERT INTO `".DBPREFIX."module_news_categories_catid` VALUES (0)");
            }
            $this->nestedSetRootId = $this->objNestedSet->createRootNode(array(), false, false);
        }
    }

    /**
     * Gets the categorie option menu string
     *
     * @global    ADONewConnection
     * @param     string     $lang
     * @param     string     $selectedOption
     * @return    string     $modulesMenu
     */
    function getSettings()
    {
        global $objDatabase;

        $query = "SELECT name, value FROM ".DBPREFIX."module_news_settings";
        $objResult = $objDatabase->Execute($query);
        while (!$objResult->EOF) {
            $this->arrSettings[$objResult->fields['name']] = $objResult->fields['value'];
            $objResult->MoveNext();
        }

        // get multilanguage settings (for now only news_feed_title and news_feed_description)
        $query = "SELECT lang_id, name, value FROM ".DBPREFIX."module_news_settings_locale";
        $objResult = $objDatabase->Execute($query);
        while (!$objResult->EOF) {
            $this->arrSettings[$objResult->fields['name']][$objResult->fields['lang_id']] = $objResult->fields['value'];
            $objResult->MoveNext();
        }
    }

    /**
     * Generates the formated ul/li of Archive list
     * Used in the template's
     * 
     * @return string Formated ul/li of Archive list
     */
    public function getNewsArchiveList() {
        $monthlyStats = $this->getMonthlyNewsStats();

        $html = '';
        if (!empty($monthlyStats)) {
            $newsArchiveLink = \Cx\Core\Routing\Url::fromModuleAndCmd('news', 'archive');
            
            $html  = '<ul class="news_archive">';
            foreach ($monthlyStats as $key => $value) {
                $html .= '<li><a href="'.$newsArchiveLink.'#'.$key.'" title="'.$value['name'].'">'.$value['name'].'</a></li>';
            }
            $html .= '</ul>';
        }
        
        return $html;
    }
    
    /**
     * Generates the formated ul/li of categories
     * Used in the template's
     * 
     * @return string Formated ul/li of categories
     */
    public function getNewsCategories()
    {
        
        $categoriesLang = $this->getCategoriesLangData();
        
        return $this->_buildNewsCategories($this->nestedSetRootId, $categoriesLang);
    }
    
    /**
     * Generates the formated ul/li of categories
     * Used in the template's
     * 
     * @return string Formated ul/li of categories
     */
    function _buildNewsCategories($catId, $categoriesLang)
    {
        if ($this->categoryExists($catId)) {
            
            $category = $this->objNestedSet->pickNode($catId, true);            
            if ($catId != $this->nestedSetRootId) {
                $html .= "<li>";
                
                $newsUrl = \Cx\Core\Routing\Url::fromModuleAndCmd('news');                
                $newsUrl->setParam('category', $catId);
                
                $html .= '<a href="'.$newsUrl.'" title="'.contrexx_raw2xhtml($categoriesLang[$catId][FRONTEND_LANG_ID]).'">'.contrexx_raw2xhtml($categoriesLang[$catId][FRONTEND_LANG_ID]).'</a>';
            }
            
            $subCategories = $this->objNestedSet->getChildren($catId, true);
            if (!empty($subCategories)) {
                $html .= "<ul class='news_category_lvl_{$category['level']}'>";
                foreach ($subCategories as $subCat) {
                    $html .= $this->_buildNewsCategories($subCat['id'], $categoriesLang);
                }
                $html .= "</ul>";
            }
            
            if ($catId != $this->nestedSetRootId) {
                $html .= "</li>";
            }
        }
        
        return $html;
    }

    /**
     * Generates the category menu.
     *
     * @access  protected
     * @param   array or integer    $categories                   categories which have to be listed
     * @param   integer             $selectedCategory             selected category
     * @param   array               $hiddenCategories             the categories which shouldn't be shown as option
     * @param   boolean             $onlyCategoriesWithEntries    only categories which have entries
     * @return  string              $options                      html options
     */
    protected function getCategoryMenu($categories, $selectedCategory = 0, $hiddenCategories = array(), $onlyCategoriesWithEntries = false)
    {
        if (empty($categories)) {
            $categories = array($this->nestedSetRootId);
        } else if (!is_array($categories)) {
            $categories = array(intval($categories));
        }

        $nestedSetCategories = $this->getNestedSetCategories($categories);

        if ($onlyCategoriesWithEntries) {
            $hiddenCategories = array_merge($hiddenCategories, $this->getEmptyCategoryIds());
        }

        $levels = array();
        foreach($nestedSetCategories as $category) {
            $levels[] = $category['level'];
        }
        $level = min($levels);

        $categoriesLang = $this->getCategoriesLangData();
        $options = '';
        foreach ($nestedSetCategories as $category) {
            if(in_array($category['id'], $hiddenCategories)) {
                continue;
            }
            $selected = $category['id'] == $selectedCategory ? 'selected="selected"' : '';
            $options .= '<option value="'.$category['id'].'" '.$selected.'>'
                    .str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', ($category['level'] - $level))
                    .contrexx_raw2xhtml($categoriesLang[$category['id']][
                        \Env::get('cx')->getMode() == \Cx\Core\Core\Controller\Cx::MODE_BACKEND ? BACKEND_LANG_ID : FRONTEND_LANG_ID
                    ])
                    .'</option>';
        }

        return $options;
    }

    /**
     * Returns an array containing the nested set information 
     * for the passed categories and their subcategories 
     * (ordered by their left id).
     *
     * @access  protected
     * @param   array or integer    $categories
     * @return  array                               nested set information
     */
    protected function getNestedSetCategories($categories) {
        if (!is_array($categories)) {
            $categories = array(intval($categories));
        }

        $nestedSetCategories = array();
        foreach ($categories as $category) {
            if ($this->categoryExists($category)) {
                if ($category != $this->nestedSetRootId) {
                    $nestedSetCategories[$category] = $this->objNestedSet->pickNode($category, true);
                }
                if ($nodes = $this->objNestedSet->getSubBranch($category, true)) {
                    $nestedSetCategories = $nestedSetCategories + $nodes;
                }
            }
        }

        return $this->sortNestedSetArray($nestedSetCategories);
    }

    /**
     * Returns an array containing the ids of empty categories.
     *
     * @access  protected
     * @global  object     $objDatabase              ADONewConnection
     * @return  array      $arrEmptyCategoryIds      ids of categories without entries
     */
    protected function getEmptyCategoryIds() {
        global $objDatabase;

        $orCatIdNotIn = '';
        if (!empty($_GET['monthFilter']) && preg_match('/^\d{4}(?:_\d{2})?$/', $_GET['monthFilter'])) {
            $monthFilter    = $_GET['monthFilter'];
            $arrMonthFilter = explode('_', $monthFilter);
            $year           = $arrMonthFilter[0];
            $month          = 0;

            if (count($arrMonthFilter) > 1) {
                if ($arrMonthFilter[1] >= 1 && $arrMonthFilter[1] <= 12) {
                    $month = $arrMonthFilter[1];
                }
            }

            if ($month > 0) {
                $daysOfMonth = date("t", mktime(0, 0, 0, $month, 1, $year));
                $whereDate   = 'WHERE `n`.`date` BETWEEN ' . mktime(0, 0, 0, $month, 1, $year) . ' AND ' . mktime(23, 59, 59, $month, $daysOfMonth, $year);
            } else {
                $whereDate   = 'WHERE `n`.`date` BETWEEN ' . mktime(0, 0, 0, 1, 1, $year) . ' AND ' . mktime(23, 59, 59, 12, 31, $year);
            }
            $selectCatIdBetweenDate = '
                SELECT `n`.`catid`
                  FROM `' . DBPREFIX . 'module_news_categories` AS `c`
             LEFT JOIN `' . DBPREFIX . 'module_news` AS `n`
                    ON `c`.`catid` = `n`.`catid`
                   ' . $whereDate . '
              GROUP BY `c`.`catid`
            ';
            $orCatIdNotIn = 'OR (`n`.`catid` NOT IN (' . $selectCatIdBetweenDate . '))';
        }

        $query = '
                SELECT `c`.`catid`
                  FROM `' . DBPREFIX . 'module_news_categories` AS `c`
             LEFT JOIN `' . DBPREFIX . 'module_news` AS `n`
                    ON `c`.`catid` = `n`.`catid`
                 WHERE `n`.`catid` IS NULL
                   ' . $orCatIdNotIn . '
              GROUP BY `c`.`catid`
        ';

        $objResult = $objDatabase->Execute($query);

        $arrEmptyCategoryIds = array();
        if ($objResult !== false) {
            while (!$objResult->EOF) {
                $arrEmptyCategoryIds[] = $objResult->fields['catid'];
                $objResult->MoveNext();
            }
        }

        return $arrEmptyCategoryIds;
    }

    /**
     * Returns the category ids of a nested set array.
     *
     * @access  protected
     * @param   array           $nestedSet
     * @return  array           $categories
     */
    protected function getCatIdsFromNestedSetArray($nestedSet) {
        $categories = array();
        if (is_array($nestedSet)) {
            foreach ($nestedSet as $node) {
                $categories[] = $node['id'];
            }
        }
        return $categories;
    }

    /**
     * Checks whether the passed category exists.
     *
     * @access  protected
     * @param   integer         $category
     * @return  boolean
     */
    protected function categoryExists($category) {
        if ($this->objNestedSet->pickNode($category)) {
            return true;
        }
        return false;
    }

    /**
     * Sorts the given nested set array by the left id.
     *
     * @access  protected
     * @param   array           $array
     * @return  array           $array
     */
    protected function sortNestedSetArray($array) {
        if (is_array($array)) {
            usort($array, array($this, 'compareNestedSetLeftIds'));
        }
        return $array;
    }

    /**
     * Compares the left id of two nested set nodes.
     *
     * @access  private
     * @param   array       $a
     * @param   array       $b
     * @return  integer
     */
    private function compareNestedSetLeftIds($a, $b) {
        $a = intval($a['l']);
        $b = intval($b['l']);

        if ($a == $b) {
            return 0;
        }

        return $a > $b ? 1 : -1;
    }

    function getTypeMenu($selectedOption='')
    {
        global $objDatabase;
        global $_ARRAYLANG;

        $strMenu = "";
        $query = "SELECT type_id, name FROM ".DBPREFIX."module_news_types_locale WHERE lang_id=".FRONTEND_LANG_ID." ORDER BY name";
        $objResult = $objDatabase->Execute($query);
        while (!$objResult->EOF) {
            $selected = $objResult->fields['type_id'] == $selectedOption ? "selected" : "";
            $strMenu .="<option value=\"".$objResult->fields['type_id']."\" $selected>".contrexx_raw2xhtml($objResult->fields['name'])."</option>\n";
            $objResult->MoveNext();
        }

        return $strMenu;
    }
    
    protected function getPublisherMenu($selectedOption = '', $categoryId = 0)
    {
        global $objDatabase, $objInit;

        $arrNewsPublisher = array();
        $arrPublisher = array();

        $query = "SELECT DISTINCT n.publisher_id
                    FROM ".DBPREFIX."module_news AS n 
                    INNER JOIN ".DBPREFIX."module_news_locale AS nl
                    ON nl.news_id = n.id
                    WHERE  nl.lang_id=".FRONTEND_LANG_ID."
                    AND n.status = 1
                    AND n.publisher_id != 0
                    ".($categoryId ? " AND n.catid=".$categoryId : '');
        $objResult = $objDatabase->Execute($query);
        while (!$objResult->EOF) {
            $arrNewsPublisher[] = $objResult->fields['publisher_id'];
            $objResult->MoveNext();
        }

        $objUser = FWUser::getFWUserObject()->objUser->getUsers(array('id' => $arrNewsPublisher), null, null, array('company', 'lastname', 'firstname'));
        if ($objUser) {
            $showUsername = ($objInit->mode == 'backend');

            while(!$objUser->EOF) {
                $arrPublisher[$objUser->getId()] = FWUser::getParsedUserTitle($objUser, '', $showUsername);
                $objUser->next();
            }

            asort($arrPublisher);
        }

        $menu = '';
        foreach ($arrPublisher as $publisherId => $publisherTitle) {
            $selected = $publisherId == $selectedOption ? 'selected="selected"' : '';
            $menu .="<option value=\"$publisherId\" $selected>".contrexx_raw2xhtml($publisherTitle)."</option>\n";
        }

        return $menu;
    }

    protected function getAuthorMenu($selectedOption = '', $categoryId = 0)
    {
        global $objDatabase, $objInit;

        $arrNewsAuthor = array();
        $arrAuthor = array();

        $query = "SELECT DISTINCT n.author_id
                    FROM ".DBPREFIX."module_news AS n 
                    INNER JOIN ".DBPREFIX."module_news_locale AS nl
                    ON nl.news_id = n.id
                    WHERE  nl.lang_id=".FRONTEND_LANG_ID."
                    AND n.status = 1
                    AND n.author_id != 0
                    ".($categoryId ? " AND n.catid=".$categoryId : '');
        $objResult = $objDatabase->Execute($query);
        while (!$objResult->EOF) {
            $arrNewsAuthor[] = $objResult->fields['author_id'];
            $objResult->MoveNext();
        }

        $objUser = FWUser::getFWUserObject()->objUser->getUsers(array('id' => $arrNewsAuthor), null, null, array('company', 'lastname', 'firstname'));
        if ($objUser) {
            $showUsername = ($objInit->mode == 'backend');

            while(!$objUser->EOF) {
                $arrAuthor[$objUser->getId()] = FWUser::getParsedUserTitle($objUser, '', $showUsername);
                $objUser->next();
            }

            asort($arrAuthor);
        }

        $menu = '';
        foreach ($arrAuthor as $authorId => $authorTitle) {
            $selected = $authorId == $selectedOption ? 'selected="selected"' : '';
            $menu .="<option value=\"$authorId\" $selected>".contrexx_raw2xhtml($authorTitle)."</option>\n";
        }

        return $menu;
    }

    
    /**
     * Gets only the body content and deleted all the other tags
     *
     * @param     string     $fullContent      HTML-Content with more than BODY
     * @return    string     $content          HTML-Content between BODY-Tag
     */
    function filterBodyTag($fullContent)
    {
        $res=false;
        $posBody=0;
        $posStartBodyContent=0;
        $res=preg_match_all("/<body[^>]*>/i", $fullContent, $arrayMatches);
        if ($res==true) {
            $bodyStartTag = $arrayMatches[0][0];
            // Position des Start-Tags holen
            $posBody = strpos($fullContent, $bodyStartTag, 0);
            // Beginn des Contents ohne Body-Tag berechnen
            $posStartBodyContent = $posBody + strlen($bodyStartTag);
        }
        $posEndTag=strlen($fullContent);
        $res=preg_match_all("/<\/body>/i",$fullContent, $arrayMatches);
        if ($res==true) {
            $bodyEndTag=$arrayMatches[0][0];
            // Position des End-Tags holen
            $posEndTag = strpos($fullContent, $bodyEndTag, 0);
            // Content innerhalb der Body-Tags auslesen
         }
         $content = substr($fullContent, $posStartBodyContent, $posEndTag  - $posStartBodyContent);
         return $content;
    }


    function hasCategories()
    {
        global $objDatabase;

        $objResult = $objDatabase->Execute("SELECT 1 FROM ".DBPREFIX."module_news_categories_locale");
        return $objResult !== false && $objResult->RecordCount();
    }


    /**
     * Get language data (title, text, teaser_text) from database
     * @global ADONewConnection
     * @param  Integer $id
     * @return Array
     */
    function getLangData($id)
    {
        global $objDatabase;

        if (empty($id)) {
            return false;
        }
        $arrLangData = array();
        $objResult = $objDatabase->Execute("SELECT lang_id,
            is_active,
            title,
            text,
            teaser_text
            FROM ".DBPREFIX."module_news_locale
            WHERE news_id = " . intval($id));

        if ($objResult !== false) {
            while (!$objResult->EOF) {
                $arrLangData[$objResult->fields['lang_id']] = array(
                    'active'      => $objResult->fields['is_active'],
                    'title'       => $objResult->fields['title'],
                    'text'        => $objResult->fields['text'],
                    'teaser_text' => $objResult->fields['teaser_text']
                );
                $objResult->MoveNext();
            }
        }
        return $arrLangData;
    }


    /**
     * Get categories language data
     * @global ADONewConnection
     * @return Array
     */
    function getCategoriesLangData()
    {
        global $objDatabase;

        $objResult = $objDatabase->Execute("SELECT lang_id,
            category_id,
            name
            FROM ".DBPREFIX."module_news_categories_locale");
        if ($objResult !== false) {
            while (!$objResult->EOF) {
                if (!isset($arrLangData[$objResult->fields['category_id']])) {
                    $arrLangData[$objResult->fields['category_id']] = array();
                }
                $arrLangData[$objResult->fields['category_id']][$objResult->fields['lang_id']] = $objResult->fields['name'];
                $objResult->MoveNext();
            }
        }
        return $arrLangData;
    }


    /**
     * Get types language data
     * @global ADONewConnection
     * @return Array
     */
    function getTypesLangData()
    {
        global $objDatabase;

        $objResult = $objDatabase->Execute("SELECT lang_id,
            type_id,
            name
            FROM ".DBPREFIX."module_news_types_locale");
        if ($objResult !== false) {
            while (!$objResult->EOF) {
                if (!isset($arrLangData[$objResult->fields['type_id']])) {
                    $arrLangData[$objResult->fields['type_id']] = array();
                }
                $arrLangData[$objResult->fields['type_id']][$objResult->fields['lang_id']] = $objResult->fields['name'];
                $objResult->MoveNext();
            }
        }
        return $arrLangData;
    }

    /**
     * Saving locales after edit news
     * @global ADONewConnection
     * @param Integer $newsId
     * @param Array $newLangData
     * @return Boolean
     */
    protected function storeLocales($newsId, $newLangData)
    {
        global $objDatabase;
        
        $oldLangData = $this->getLangData($newsId);
        if (count($oldLangData) == 0 || !isset($newsId)) {
            return false;
        }
        $status = true;
        $arrNewLocales = array_diff(array_keys($newLangData['title']), array_keys($oldLangData));
        $arrRemovedLocales = array_diff(array_keys($oldLangData), array_keys($newLangData['title']));
        $arrUpdatedLocales = array_intersect(array_keys($newLangData['title']), array_keys($oldLangData));

        foreach ($arrNewLocales as $langId) {
            if ($objDatabase->Execute("INSERT INTO `".DBPREFIX."module_news_locale` (`lang_id`, `news_id`, `is_active`,  `title`, `text`, `teaser_text`)
                    VALUES ("   . intval($langId) . ", "
                                . $newsId . ", '"
                                . contrexx_input2db($newLangData['active'][$langId]) . "', '"
                                . contrexx_input2db($newLangData['title'][$langId]) . "', '"
                                . $this->filterBodyTag(contrexx_input2db($newLangData['text'][$langId])) . "', '"
                                . contrexx_input2db($newLangData['teaser_text'][$langId]) . "')") === false) {
                $status = false;
            }
        }
        foreach ($arrRemovedLocales as $langId) {
            if ($objDatabase->Execute("DELETE FROM `".DBPREFIX."module_news_locale` WHERE `news_id` = " . $newsId . " AND `lang_id` = " . $langId) === false) {
                $status = false;
            }
        }
        foreach ($arrUpdatedLocales as $langId) {
            $newLangData['active'][$langId] = isset($newLangData['active'][$langId]) ? 1 : 0;
            if ($newLangData['active'][$langId] != $oldLangData[$langId]['active']
            || $newLangData['title'][$langId] != $oldLangData[$langId]['title']
            || $newLangData['text'][$langId] != $oldLangData[$langId]['text']
            || $newLangData['teaser_text'][$langId] != $oldLangData[$langId]['teaser_text'] ) {
                if ($objDatabase->Execute("UPDATE `".DBPREFIX."module_news_locale` SET
                        `is_active` = '" . contrexx_input2db($newLangData['active'][$langId]) . "',
                        `title` = '" . contrexx_input2db($newLangData['title'][$langId]) . "',
                        " . ($this->arrSettings['news_use_teaser_text'] == 1 ? "`teaser_text` = '" . contrexx_input2db($newLangData['teaser_text'][$langId]) . "'," : "") . "
                        `text` = '" . $this->filterBodyTag(contrexx_input2db($newLangData['text'][$langId])) . "'
                        WHERE `news_id` = " . $newsId . " AND `lang_id` = " . $langId) === false) {
                    $status = false;
                }
            }
        }
        return $status;
    }


    /**
     * Saving categories locales
     * @global ADONewConnection
     * @param Array $newLangData
     * @return Boolean
     */
    protected function storeCategoriesLocales($newLangData)
    {
        global $objDatabase;

        $oldLangData = $this->getCategoriesLangData();
        if (count($oldLangData) == 0) {
            return false;
        }
        $status = true;
        $arrNewLocales = array_diff(array_keys($newLangData[key($newLangData)]), array_keys($oldLangData[key($oldLangData)]));
        $arrRemovedLocales = array_diff(array_keys($oldLangData[key($oldLangData)]), array_keys($newLangData[key($newLangData)]));
        $arrUpdatedLocales = array_intersect(array_keys($newLangData[key($newLangData)]), array_keys($oldLangData[key($oldLangData)]));
        foreach (array_keys($newLangData) as $catId) {
            foreach ($arrNewLocales as $langId) {
                if ($objDatabase->Execute("INSERT INTO `".DBPREFIX."module_news_categories_locale` (`lang_id`, `category_id`, `name`)
                        VALUES ("   . intval($langId) . ", "
                                    . $catId . ", '"
                                    . contrexx_input2db($newLangData[$catId][$langId]) . "')")
                                    === false) {
                    $status = false;
                }
            }
            foreach ($arrUpdatedLocales as $langId) {
                if ($newLangData[$catId][$langId] != $oldLangData[$catId][$langId] ) {
                    if ($objDatabase->Execute("UPDATE `".DBPREFIX."module_news_categories_locale` SET
                            `name` = '" . contrexx_input2db($newLangData[$catId][$langId]). "'
                            WHERE `category_id` = " . $catId . " AND `lang_id` = " . $langId) === false) {
                        $status = false;
                    }
                }
            }
        }
        foreach ($arrRemovedLocales as $langId) {
            if ($objDatabase->Execute("DELETE FROM `".DBPREFIX."module_news_categories_locale` WHERE `lang_id` = " . $langId) === false) {
                $status = false;
            }
        }
        return $status;
    }


    /**
     * Saving types locales
     * @global ADONewConnection
     * @param Array $newLangData
     * @return Boolean
     */
    protected function storeTypesLocales($newLangData)
    {
        global $objDatabase;

        $oldLangData = $this->getTypesLangData();
        if (count($oldLangData) == 0) {
            return false;
        }
        $status = true;
        $arrNewLocales = array_diff(array_keys($newLangData[key($newLangData)]), array_keys($oldLangData[key($oldLangData)]));
        $arrRemovedLocales = array_diff(array_keys($oldLangData[key($oldLangData)]), array_keys($newLangData[key($newLangData)]));
        $arrUpdatedLocales = array_intersect(array_keys($newLangData[key($newLangData)]), array_keys($oldLangData[key($oldLangData)]));
        foreach (array_keys($newLangData) as $typeId) {
            foreach ($arrNewLocales as $langId) {
                if ($objDatabase->Execute("INSERT INTO `".DBPREFIX."module_news_types_locale` (`lang_id`, `type_id`, `name`)
                        VALUES ("   . intval($langId) . ", "
                                    . $typeId . ", '"
                                    . contrexx_input2db($newLangData[$typeId][$langId]) . "')")
                                    === false) {
                    $status = false;
                }
            }
            foreach ($arrUpdatedLocales as $langId) {
                if ($newLangData[$typeId][$langId] != $oldLangData[$typeId][$langId] ) {
                    if ($objDatabase->Execute("UPDATE `".DBPREFIX."module_news_types_locale` SET
                            `name` = '" . contrexx_input2db($newLangData[$typeId][$langId]). "'
                            WHERE `type_id` = " . $typeId . " AND `lang_id` = " . $langId) === false) {
                        $status = false;
                    }
                }
            }
        }
        foreach ($arrRemovedLocales as $langId) {
            if ($objDatabase->Execute("DELETE FROM `".DBPREFIX."module_news_types_locale` WHERE `lang_id` = " . $langId) === false) {
                $status = false;
            }
        }
        return $status;
    }

    /**
     * Saving feed settings locales
     * @global ADONewConnection
     * @param String $newsId
     * @param Array $newLangData
     * @return Boolean
     */
    protected function storeFeedLocales($settingsName, $newLangData)
    {
        global $objDatabase;

        $this->getSettings();
        $oldLangData = $this->arrSettings[$settingsName];
        if (count($oldLangData) == 0) {
            return false;
        }
        $status = true;
        $arrNewLocales = array_diff(array_keys($newLangData), array_keys($oldLangData));
        $arrRemovedLocales = array_diff(array_keys($oldLangData), array_keys($newLangData));
        $arrUpdatedLocales = array_intersect(array_keys($newLangData), array_keys($oldLangData));
        foreach ($arrNewLocales as $langId) {
            if ($objDatabase->Execute("INSERT INTO `".DBPREFIX."module_news_settings_locale` (`lang_id`, `name`, `value`)
                    VALUES ("   . intval($langId) . ", '"
                                . $settingsName . "', '"
                                . contrexx_input2db($newLangData[$langId]) . "')")
                                === false) {
                $status = false;
            }
        }
        foreach ($arrUpdatedLocales as $langId) {
            if ($newLangData[$langId] != $oldLangData[$langId] ) {
                if ($objDatabase->Execute("UPDATE `".DBPREFIX."module_news_settings_locale` SET
                        `value` = '" . contrexx_input2db($newLangData[$langId]). "'
                        WHERE `name` LIKE '" . $settingsName . "' AND `lang_id` = " . $langId) === false) {
                    $status = false;
                }
            }
        }
        foreach ($arrRemovedLocales as $langId) {
            if ($objDatabase->Execute("DELETE FROM `".DBPREFIX."module_news_settings_locale` WHERE `lang_id` = " . $langId) === false) {
                $status = false;
            }
        }
        return $status;
    }


    /**
     * Insert new locales after create news from backend
     * @global ADONewConnection
     * @param Integer $newsId
     * @param Array $newLangData
     * @return Boolean
     */
    function insertLocales($newsId, $newLangData)
    {
        global $objDatabase;

        if (empty($newsId)) {
            return false;
        }
        $status = true;
        $arrLanguages = FWLanguage::getLanguageArray();
        foreach ($arrLanguages as $langId => $arrLanguage) {
            if ($arrLanguage['frontend'] == 1 && isset($newLangData['active'][$langId])) {
                if ($objDatabase->Execute("INSERT INTO `".DBPREFIX."module_news_locale` (`lang_id`, `news_id`, `is_active`, `title`, `text`, `teaser_text`)
                        VALUES ("   . intval($langId) . ", "
                                    . $newsId . ", '"
                                    . (isset($newLangData['active'][$langId]) ? 1 : 0) . "', '"
                                    . (isset($newLangData['title'][$langId]) ? contrexx_input2db($newLangData['title'][$langId]) : "") . "', '"
                                    . (isset($newLangData['text'][$langId]) ? $this->filterBodyTag(contrexx_input2db($newLangData['text'][$langId])) : "") . "', '"
                                    . (isset($newLangData['teaser_text'][$langId]) ? contrexx_input2db($newLangData['teaser_text'][$langId]) : "") . "')") === false) {
                    $status = false;
                }
            }
        }
        return $status;
    }


    /**
     * Insert new locales after submit news from frontend
     * One copy for all languages
     * @global ADONewConnection
     * @param Integer   $newsId
     * @param String    $title
     * @param String    $text
     * @param String    $teaser_text
     * @return Boolean
     */
    function submitLocales($newsId, $title, $text, $teaser_text)
    {
        global $objDatabase;

        if (empty($newsId)) {
            return false;
        }
        $status = true;
        $objResult = $objDatabase->Execute("SELECT id FROM ".DBPREFIX."languages");
        if ($objResult !== false) {
            while (!$objResult->EOF) {
                if ($objDatabase->Execute("INSERT INTO ".DBPREFIX."module_news_locale (`lang_id`, `news_id`, `title`, `text`, `teaser_text`)
                    VALUES ("
                        . intval($objResult->fields['id']) . ", "
                        . intval($newsId) . ", '"
                        . contrexx_input2db($title) . "', '"
                        . $this->filterBodyTag(contrexx_input2db($text)) . "', '"
                        . contrexx_input2db($teaser_text) . "')")){
                    $status = false;
                }
                $objResult->MoveNext();
            }
        }
        return $status;
    }

    protected function getHtmlImageTag($src, $alt)
    {
        static $htmlImgTag = '<img src="%1$s" alt="%2$s" />';

        return sprintf($htmlImgTag, contrexx_raw2xhtml($src), $alt);
    }

    public function parseImageThumbnail($imageSource, $thumbnailSource, $altText, $newsUrl)
    {
        $image = '';
        $imageLink = '';
        $source = '';
        if (!empty($thumbnailSource)) {
            $source = $thumbnailSource;
        } elseif (!empty($imageSource) && file_exists(ASCMS_PATH.ImageManager::getThumbnailFilename($imageSource))) {
            $source = ImageManager::getThumbnailFilename($imageSource);
        } elseif (!empty($imageSource)) {
            $source = $imageSource;
        }

        if (!empty($source)) {
            $image     = self::getHtmlImageTag($source, $altText);
            $imageLink = self::parseLink($newsUrl, $altText, $image);
        }

        return array($image, $imageLink, $source);
    }

    protected static function parseLink($href, $title, $innerHtml, $class=null)
    {
        static $htmlLinkTag = '<a href="%1$s" title="%2$s">%3$s</a>';

        if (empty($href)) return '';

        return sprintf($htmlLinkTag, contrexx_raw2xhtml($href), contrexx_raw2xhtml($title), $innerHtml);
    }

    /**
     * Searches for cmds having the passed id and 
     * returns the cmd of the result set having the lowest length.
     *
     * @access  protected
     * @param   string      $cmdName
     * @param   integer     $cmdId
     * @param   string      $cmdSeparator
     * @param   string      $module
     * @param   integer     $lang
     * @return  string      $cmd
     */
    protected function findCmdById($cmdName, $cmdId, $cmdSeparator=',', $module='news', $lang=FRONTEND_LANG_ID)
    {        
        $qb = \Env::get('em')->createQueryBuilder();
        $qb ->select('p', 'LENGTH(p.cmd) AS length')
            ->from('\Cx\Core\ContentManager\Model\Entity\Page', 'p')
            ->where($qb->expr()->andX(
                $qb->expr()->orX(
                    $qb->expr()->eq('p.cmd', ':cmd1'),
                    $qb->expr()->like('p.cmd', ':cmd2'),
                    $qb->expr()->like('p.cmd', ':cmd3'),
                    $qb->expr()->like('p.cmd', ':cmd4')
                ),
                $qb->expr()->eq('p.type', ':type'),
                $qb->expr()->eq('p.lang', ':lang'),
                $qb->expr()->eq('p.module', ':module')
            ))
            ->orderBy('length', 'ASC')
            ->setMaxResults(1)
            ->setParameters(array(
                'type' => \Cx\Core\ContentManager\Model\Entity\Page::TYPE_APPLICATION,
                'cmd1' => $cmdName.$cmdId,
                'cmd2' => $cmdName.$cmdId.$cmdSeparator.'%',
                'cmd3' => $cmdName.'%'.$cmdSeparator.$cmdId.$cmdSeparator.'%',
                'cmd4' => $cmdName.'%'.$cmdSeparator.$cmdId,
                'lang' => $lang,
                'module' => $module,
            ));
        $page = $qb->getQuery()->getResult();

        if (!empty($page[0][0])) {
            // a page having the given id in cmd was found
            return $page[0][0]->getCmd();
        } else {
            // check if there's a cmd of a parent category
            if (($parentCategory = $this->getParentCatId($cmdId)) && ($cmd = $this->findCmdById($cmdName, $parentCategory))) {
                return $cmd;
            }
            if ($page = \Env::get('em')->getRepository('\Cx\Core\ContentManager\Model\Entity\Page')->findOneByModuleCmdLang($module, $cmdName, $lang)) {
                // a page having the given cmd name without id was found
                return $page->getCmd();
            }
            return '';
        }
    }

    /**
     * Returns the parent category id of passed category.
     *
     * @access  protected
     * @param   integer                 $category
     * @return  integer or boolean      $cmd
     */
    protected function getParentCatId($category) {
        if (($parent = $this->objNestedSet->getParent($category)) && ($parent->id != $this->nestedSetRootId)) {
            return $parent->id;
        }
        return false;
    }
    
    /**
     * Returns the news monthly stats by the given filters
     * 
     * @access protected
     * @param  array     $category      category filter
     * 
     * @return array     $monthlyStats  Monthly status array
     */
    protected function getMonthlyNewsStats($categories) {
        global $objDatabase, $_CORELANG;
        
        $categoryFilter = '';
        if (!empty($categories)) {
           $categoryFilter .= ' AND (n.catid = '.implode(' OR n.catid = ', array_map('intval', $categories)).')';            
        }

        $query = "SELECT            n.id             AS id,
                                    n.date           AS date,
                                    n.changelog      AS changelog,
                                    n.redirect       AS newsredirect,
                                    nl.title         AS newstitle,
                                    n.catid          AS cat
                            FROM    ".DBPREFIX."module_news AS n LEFT JOIN  ".DBPREFIX."module_news_locale AS nl ON nl.news_id = n.id
                            WHERE   n.validated = '1'
                                    AND n.status = 1
                                    AND nl.lang_id = ".FRONTEND_LANG_ID."
                                    AND nl.is_active=1
                                    ".$categoryFilter."
                                    " .($this->arrSettings['news_message_protection'] == '1' && !Permission::hasAllAccess() ? (
                                    ($objFWUser = FWUser::getFWUserObject()) && $objFWUser->objUser->login() ?
                                        " AND (frontend_access_id IN (".implode(',', array_merge(array(0), $objFWUser->objUser->getDynamicPermissionIds())).") OR userid = ".$objFWUser->objUser->getId().") "
                                        :   " AND frontend_access_id=0 ")
                                    :   '')
                            ."ORDER BY date DESC";

        $objResult = $objDatabase->Execute($query);

        if ($objResult !== false) {
            $arrMonthTxt = explode(',', $_CORELANG['TXT_MONTH_ARRAY']);
            while (!$objResult->EOF) {
                $filterDate = $objResult->fields['date'];
                $newsYear = date('Y', $filterDate);
                $newsMonth = date('m', $filterDate);
                if (!isset($monthlyStats[$newsYear.'_'.$newsMonth])) {
                    $monthlyStats[$newsYear.'_'.$newsMonth]['name'] = $arrMonthTxt[date('n', $filterDate) - 1].' '.$newsYear;
                }
                $monthlyStats[$newsYear.'_'.$newsMonth]['news'][] = $objResult->fields;
                $objResult->MoveNext();
            }
        }
        
        return $monthlyStats;
    }
    
    /**
     * Parses a user's account and profile data specified by $userId.
     * If the \Cx\Core\Html\Sigma template block specified by $blockName
     * exists, then the user's data will be parsed inside this block.
     * Otherwise, it will try to parse a template variable by the same
     * name. For instance, if $blockName is set to news_publisher,
     * it will first try to parse the template block news_publisher,
     * if unable it will parse the template variable NEWS_PUBLISHER.
     *
     * @param   object  Template object \Cx\Core\Html\Sigma
     * @param   integer User-ID
     * @param   string  User name/title that shall be used as fallback,
     *                  if no user account specified by $userId could be found
     * @param   string  Name of the \Cx\Core\Html\Sigma template block to parse.
     *                  For instance if you have a block like:
     *                      <!-- BEGIN/END news_publisher -->
     *                  set $blockName to:
     *                      news_publisher
     */
    public static function parseUserAccountData($objTpl, $userId, $userTitle, $blockName)
    {
        $placeholderName = strtoupper($blockName);

        if ($userId && $objUser = FWUser::getFWUserObject()->objUser->getUser($userId)) {
            if ($objTpl->blockExists($blockName)) {
                // fill the template block user (i.e. news_publisher) with the user account's data 
                $objTpl->setVariable(array(
                    $placeholderName.'_ID'          => $objUser->getId(),
                    $placeholderName.'_USERNAME'    => contrexx_raw2xhtml($objUser->getUsername())
                ));
                
                $objAccessLib = new AccessLib($objTpl);
                $objAccessLib->setModulePrefix($placeholderName.'_');
                $objAccessLib->setAttributeNamePrefix($blockName.'_profile_attribute');

                $objUser->objAttribute->first();
                while (!$objUser->objAttribute->EOF) {
                    $objAttribute = $objUser->objAttribute->getById($objUser->objAttribute->getId());
                    $objAccessLib->parseAttribute($objUser, $objAttribute->getId(), 0, false, FALSE, false, false, false);
                    $objUser->objAttribute->next();
                }
            } elseif ($objTpl->placeholderExists($placeholderName)) {
                // fill the placeholder (i.e. NEWS_PUBLISHER) with the user title
                $userTitle = FWUser::getParsedUserTitle($userId);
                $objTpl->setVariable($placeholderName, contrexx_raw2xhtml($userTitle));
            }
        } elseif (!empty($userTitle)) {
            if ($objTpl->blockExists($blockName)) {
                // replace template block (i.e. news_publisher) by the user title
                $objTpl->replaceBlock($blockName, contrexx_raw2xhtml($userTitle));
            } elseif ($objTpl->placeholderExists($placeholderName)) {
                // fill the placeholder (i.e. NEWS_PUBLISHER) with the user title
                $objTpl->setVariable($placeholderName, contrexx_raw2xhtml($userTitle));
            }
        }
    }

}
