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
 * Search and view results from the DB
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Comvation Development Team <info@comvation.com>
 * @version     2.0.0
 * @package     contrexx
 * @subpackage  coremodule_search
 * @todo: add namespace
 */

//Security-Check
if (strstr($_SERVER['PHP_SELF'], 'index.class.php')) {
    header("Location: ../../index.php");
    die();
}

/**
 * Search and view results from the DB
 * @copyright   CONTREXX CMS - COMVATION AG
 * @version     3.1.0
 * @package     contrexx
 * @subpackage  coremodule_search
 * @author      Comvation Development Team <info@comvation.com>
 * @author      Reto Kohli <reto.kohli@comvation.com> (class)
 */
class Search
{
    public static function getPage($pos, $page_content, $license)
    {
        global $_CONFIG, $_ARRAYLANG;

        $objTpl = new \Cx\Core\Html\Sigma('.');
        \CSRF::add_placeholder($objTpl);
        $objTpl->setErrorHandling(PEAR_ERROR_DIE);
        $objTpl->setTemplate($page_content);
        $objTpl->setGlobalVariable($_ARRAYLANG);
        $term = (isset($_REQUEST['term'])
            ? trim(contrexx_input2raw($_REQUEST['term'])) : '');
        if (strlen($term) >= 3) {
            $term = trim(contrexx_input2raw($_REQUEST['term']));
            $arrayContent = $arrayNews = $arrayDocsys = $arrayShopProducts =
                $arrayPodcastMedia = $arrayPodcastCategory = $arrayGalleryCats =
                $arrayGalleryPics = $arrayMemberdir = $arrayMemberdirCats =
                $arrayDirectory = $arrayDirectoryCats = $arrayCalendar =
                $arrayCalendarCats = $arrayForum = array();
            $pageRepo = \Env::em()->getRepository('Cx\Core\ContentManager\Model\Entity\Page');

            // $term is already escaped, therefore we must unescape (using stripslashes()) it before passing it to searchResultsForSearchModule()
            $arrayContent = $pageRepo->searchResultsForSearchModule(
                $term, $license);
            if (contrexx_isModuleActive('news')) {
                $querynews = self::getQuery('news', $term);
                if (!empty($querynews)) {
                    $arrayNews = self::getResultArray(
                        $querynews, 'news', 'details', 'newsid=', $term);
                }
            }
            if (contrexx_isModuleActive('docsys')) {
                $querydocsys = self::getQuery('docsys', $term);
                if (!empty($querydocsys)) {
                    $arrayDocsys = self::getResultArray(
                        $querydocsys, 'docsys', 'details', 'id=', $term);
                }
            }
            if (contrexx_isModuleActive('podcast')) {
                $queryPodcast = self::getQuery('podcast', $term);
                $queryPodcastCategory = self::getQuery('podcastCategory', $term);
                if (!empty($queryPodcast)) {
                    $arrayPodcastMedia = self::getResultArray(
                        $queryPodcast, 'podcast', '', 'id=', $term);
                    $arrayPodcastCategory = self::getResultArray(
                        $queryPodcastCategory, 'podcast', '', 'cid=', $term);
                }
            }
            if (contrexx_isModuleActive('shop')) {
                $queryshop = self::getQuery('shop', $term);
                if (!empty($queryshop)) {
                    $arrayShopProducts = self::getResultArray(
                        $queryshop, 'shop', 'details', 'productId=', $term);
                }
            }
            if (contrexx_isModuleActive('gallery')) {
                $queryGalleryCats = self::getQuery('gallery_cats', $term);
                $queryGalleryPics = self::getQuery('gallery_pics', $term);
                if (!empty($queryGalleryCats)) {
                    $arrayGalleryCats = self::getResultArray(
                        $queryGalleryCats, 'gallery', 'showCat', 'cid=', $term);
                    $arrayGalleryPics = self::getResultArray(
                        $queryGalleryPics, 'gallery', 'showCat', 'cid=', $term);
                }
            }
            if (contrexx_isModuleActive('memberdir')) {
                $queryMemberdir = self::getQuery('memberdir', $term);
                $queryMemberdirCats = self::getQuery('memberdir_cats', $term);
                if (!empty($queryMemberdir)) {
                    $arrayMemberdir = self::getResultArray(
                        $queryMemberdir, 'memberdir', '', 'mid=', $term);
                    $arrayMemberdirCats = self::getResultArray(
                        $queryMemberdirCats, 'memberdir', '', 'id=', $term);
                }
            }
            if (contrexx_isModuleActive('directory')) {
                $queryDirectory = self::getQuery('directory', $term);
                $queryDirectoryCats = self::getQuery('directory_cats', $term);
                if (!empty($queryDirectory)) {
                    $arrayDirectory = self::getResultArray(
                        $queryDirectory, 'directory', 'detail', 'id=', $term);
                    $arrayDirectoryCats = self::getResultArray(
                        $queryDirectoryCats, 'directory', '', 'lid=', $term);
                }
            }
            if (contrexx_isModuleActive('calendar')) {
                $queryCalendar = self::getQuery('calendar', $term);
                if (!empty($queryCalendar)) {
                    $arrayCalendar = self::getResultArray(
                        $queryCalendar, 'calendar', 'detail', 'id=', $term);
                }
            }
            if (contrexx_isModuleActive('forum')) {
                $queryForum = self::getQuery('forum', $term);
                if (!empty($queryForum)) {
                    $arrayForum = self::getResultArray(
                        $queryForum, 'forum', 'thread', 'id=', $term);
                }
            }
            $arraySearchResults = array_merge(
                $arrayContent, $arrayNews, $arrayDocsys, $arrayPodcastMedia,
                $arrayPodcastCategory, $arrayShopProducts, $arrayGalleryCats,
                $arrayGalleryPics, $arrayMemberdir, $arrayMemberdirCats,
                $arrayDirectory, $arrayDirectoryCats, $arrayCalendar,
                $arrayCalendarCats, $arrayForum);
            usort($arraySearchResults,
                /**
                 * Compares scores (and dates, if available) of two result array elements
                 *
                 * Compares the scores first; when equal, compares the dates, if available.
                 * Returns
                 *  -1 if $a  > $b
                 *   0 if $a == $b
                 *  +1 if $a  < $b
                 * Used for ordering search results.
                 * @author  Christian Wehrli <christian.wehrli@astalavista.ch>
                 * @param  	string  $a      The first element
                 * @param  	string  $b      The second element
                 * @return 	integer         The comparison result
                 */
                function($a, $b) {
                    if ($a['Score'] == $b['Score']) {
                        if (isset($a['Date'])) {
                            if ($a['Date'] == $b['Date']) {
                                return 0;
                            }
                            if ($a['Date'] > $b['Date']) {
                                return -1;
                            }
                            return 1;
                        }
                        return 0;
                    }
                    if ($a['Score'] > $b['Score']) {
                        return -1;
                    }
                    return 1;
                }
            );
            $countResults = sizeof($arraySearchResults);
            if (!is_numeric($pos)) {
                $pos = 0;
            }
            $paging = getPaging(
                $countResults, $pos,
                '&amp;section=search&amp;term='.contrexx_raw2encodedUrl(
                    $term), '<b>'.$_ARRAYLANG['TXT_SEARCH_RESULTS'].'</b>', true);
            $objTpl->setVariable('SEARCH_PAGING', $paging);
            $objTpl->setVariable('SEARCH_TERM', contrexx_raw2xhtml($term));
            if ($countResults > 0) {
                $searchComment = sprintf(
                    $_ARRAYLANG['TXT_SEARCH_RESULTS_ORDER_BY_RELEVANCE'],
                    contrexx_raw2xhtml($term), $countResults);
                $objTpl->setVariable('SEARCH_TITLE', $searchComment);
                $arraySearchOut = array_slice($arraySearchResults, $pos,
                                              $_CONFIG['corePagingLimit']);
                foreach ($arraySearchOut as $details) {
                    $objTpl->setVariable(array(
                        'COUNT_MATCH' =>
                        $_ARRAYLANG['TXT_RELEVANCE'].' '.$details['Score'].'%',
                        'LINK' => '<b><a href="'.$details['Link'].
                        '" title="'.contrexx_raw2xhtml($details['Title']).'">'.
                        contrexx_raw2xhtml($details['Title']).'</a></b>',
                        'SHORT_CONTENT' => contrexx_raw2xhtml($details['Content']),
                    ));
                    $objTpl->parse('search_result');
                }
                return $objTpl->get();
            }
        }
        $noresult = ($term != ''
                ? sprintf($_ARRAYLANG['TXT_NO_SEARCH_RESULTS'], $term)
                : $_ARRAYLANG['TXT_PLEASE_ENTER_SEARCHTERM']);
        $objTpl->setVariable('SEARCH_TITLE', $noresult);
        return $objTpl->get();
    }

    /**
     * Returns the SQL search query string for the module given
     *
     * Covers selected modules only.  Returns NULL for any other.
     * @param   string  $module     The module
     * @param   string  $term       The search term
     * @return  string              The SQL query on success, NULL otherwise
     * @todo    No queries should be made in here.
     *          See the 'shop' case for an alternative example.
     */
    protected static function getQuery($module, $term)
    {
        $term_db = contrexx_raw2db($term);
        switch ($module) {
            case 'news':
                return "
                    SELECT id, text AS content, title, date, redirect,
                           MATCH (text,title,teaser_text) AGAINST ('%$term_db%') AS score
                      FROM ".DBPREFIX."module_news AS tblN
                     INNER JOIN ".DBPREFIX."module_news_locale AS tblL ON tblL.news_id = tblN.id
                     WHERE (   text LIKE ('%$term_db%')
                            OR title LIKE ('%$term_db%')
                            OR teaser_text LIKE ('%$term_db%'))
                       AND lang_id=".FRONTEND_LANG_ID."
                       AND status=1
                       AND is_active=1
                       AND (startdate<='".date('Y-m-d')."' OR startdate='0000-00-00')
                       AND (enddate>='".date('Y-m-d')."' OR enddate='0000-00-00')";
            case 'docsys':
                return "
                    SELECT id, text AS content, title,
                     MATCH (text, title) AGAINST ('%$term_db%') AS score
                      FROM ".DBPREFIX."module_docsys
                     WHERE (   text LIKE ('%$term_db%')
                            OR title LIKE ('%$term_db%'))
                       AND lang=".FRONTEND_LANG_ID."
                       AND status=1
                       AND (startdate<='".date('Y-m-d')."' OR startdate='0000-00-00')
                       AND (enddate>='".date('Y-m-d')."' OR enddate='0000-00-00')";
            case 'podcast':
                return "
                    SELECT id, title, description AS content,
                            MATCH (description,title) AGAINST ('%$term_db%') AS score
                      FROM ".DBPREFIX."module_podcast_medium
                     WHERE (   description LIKE ('%$term_db%')
                            OR title LIKE ('%$term_db%'))
                       AND status=1";
            case 'podcastCategory':
                return "
                    SELECT tblCat.id, tblCat.title, tblCat.description,
                           MATCH (title, description) AGAINST ('%$term_db%') AS score
                      FROM ".DBPREFIX."module_podcast_category AS tblCat,
                           ".DBPREFIX."module_podcast_rel_category_lang AS tblLang
                     WHERE (   title LIKE ('%$term_db%')
                            OR description LIKE ('%$term_db%'))
                       AND tblCat.status=1
                       AND tblLang.category_id=tblCat.id
                       AND tblLang.lang_id=".FRONTEND_LANG_ID."";
            case 'shop':
                $flagIsReseller = false;
                $objUser = \FWUser::getFWUserObject()->objUser;

                if ($objUser->login()) {
                    $objCustomer = \Customer::getById($objUser->getId());
                    \SettingDb::init('shop', 'config');
                    if ($objCustomer && $objCustomer->is_reseller()) {
                        $flagIsReseller = true;
                    }
                }

                $querySelect = $queryCount = $queryOrder = null;
                list($querySelect, $queryCount, $queryTail, $queryOrder) = \Products::getQueryParts(null, null, null, $term, false, false, '', $flagIsReseller);

                return $querySelect.$queryTail.$queryOrder;
            case 'gallery_cats':
                return "
                    SELECT tblLang.gallery_id, tblLang.value AS title,
                           MATCH (tblLang.value) AGAINST ('%$term_db%') AS score
                      FROM ".DBPREFIX."module_gallery_language AS tblLang,
                           ".DBPREFIX."module_gallery_categories AS tblCat
                     WHERE tblLang.value LIKE ('%$term_db%')
                       AND tblLang.lang_id=".FRONTEND_LANG_ID."
                       AND tblLang.gallery_id=tblCat.id
                       AND tblCat.status=1";
            case 'gallery_pics':
                return "
                    SELECT tblPic.catid AS id, tblLang.name AS title, tblLang.desc AS content,
                     MATCH (tblLang.name,tblLang.desc) AGAINST ('%$term_db%') AS score
                      FROM ".DBPREFIX."module_gallery_pictures AS tblPic,
                           ".DBPREFIX."module_gallery_language_pics AS tblLang,
                           ".DBPREFIX."module_gallery_categories AS tblCat
                     WHERE (tblLang.name LIKE ('%$term_db%') OR tblLang.desc LIKE ('%$term_db%'))
                       AND tblLang.lang_id=".FRONTEND_LANG_ID."
                       AND tblLang.picture_id=tblPic.id
                       AND tblPic.status=1
                       AND tblCat.id=tblPic.catid
                       AND tblCat.status=1";
            case 'memberdir':
                return "
                    SELECT tblValue.id, tblDir.name AS title,
                           CONCAT_WS(' ', `1`, `2`, '') AS content
                      FROM ".DBPREFIX."module_memberdir_values AS tblValue,
                           ".DBPREFIX."module_memberdir_directories AS tblDir
                     WHERE tblDir.dirid=tblValue.dirid
                       AND tblValue.`lang_id`=".FRONTEND_LANG_ID."
                       AND (   tblValue.`1` LIKE '%$term_db%'
                            OR tblValue.`2` LIKE '%$term_db%'
                            OR tblValue.`3` LIKE '%$term_db%'
                            OR tblValue.`4` LIKE '%$term_db%'
                            OR tblValue.`5` LIKE '%$term_db%'
                            OR tblValue.`6` LIKE '%$term_db%'
                            OR tblValue.`7` LIKE '%$term_db%'
                            OR tblValue.`8` LIKE '%$term_db%'
                            OR tblValue.`9` LIKE '%$term_db%'
                            OR tblValue.`10` LIKE '%$term_db%'
                            OR tblValue.`11` LIKE '%$term_db%'
                            OR tblValue.`12` LIKE '%$term_db%'
                            OR tblValue.`13` LIKE '%$term_db%'
                            OR tblValue.`14` LIKE '%$term_db%'
                            OR tblValue.`15` LIKE '%$term_db%'
                            OR tblValue.`16` LIKE '%$term_db%'
                            OR tblValue.`17` LIKE '%$term_db%'
                            OR tblValue.`18` LIKE '%$term_db%')";
            case 'memberdir_cats':
                return "
                    SELECT dirid AS id, name AS title, description AS content,
                           MATCH (name, description) AGAINST ('%$term_db%') AS score
                      FROM ".DBPREFIX."module_memberdir_directories
                     WHERE active='1'
                       AND lang_id=".FRONTEND_LANG_ID."
                       AND (   name LIKE ('%$term_db%')
                            OR description LIKE ('%$term_db%'))";
            case 'directory':
                return "
                    SELECT id, title, description AS content,
                           MATCH (title, description) AGAINST ('%$term_db%') AS score
                      FROM ".DBPREFIX."module_directory_dir
                     WHERE status='1'
                       AND (   title LIKE ('%$term_db%')
                            OR description LIKE ('%$term_db%')
                            OR searchkeys LIKE ('%$term_db%')
                            OR company_name LIKE ('%$term_db%'))";
            case 'directory_cats':
                return "
                    SELECT id, name AS title, description AS content,
                           MATCH (name, description) AGAINST ('%$term_db%') AS score
                      FROM ".DBPREFIX."module_directory_categories
                     WHERE status='1'
                       AND (   name LIKE ('%$term_db%')
                            OR description LIKE ('%$term_db%'))";
            case 'calendar':                
                return \CalendarEvent::getEventSearchQuery($term_db);
            case 'forum':
                return "
                    SELECT `thread_id` AS `id`, `subject` AS `title`, `content`,
                           MATCH (`subject`, `content`, `keywords`) AGAINST ('%$term_db%') AS score
                      FROM ".DBPREFIX."module_forum_postings
                     WHERE (   subject LIKE ('%$term_db%')
                            OR content LIKE ('%$term_db%')
                            OR keywords LIKE ('%$term_db%'))";
                break;
        }
        return NULL;
    }

    /**
     * Returns search results
     *
     * The entries in the array returned contain the following indices:
     *  'Score':    The matching score ([0..100])
     *  'Title':    The object or content title
     *  'Content':  The content
     *  'Link':     The link to the (detailed) view of the result
     *  'Date':     The change date, optional
     * Mind that the date is not available for all types of results.
     * Note that the $term parameter is not currently used, but may be useful
     * i.e. for hilighting matches in the results.
     * @author  Christian Wehrli <christian.wehrli@astalavista.ch>
     * @param   string  $query          The query
     * @param   string  $module_var     The module (empty for core/content?)
     * @param   string  $cmd_var        The cmd (or empty)
     * @param   string  $pagevar        The ID parameter name for referencing
     *                                  found objects in the URL
     * @param   string  $term           The search term
     * @return  array                   The search results array
     */
    protected static function getResultArray($query, $module, $command, $pagevar, $term)
    {
        global $_ARRAYLANG;

        $pageRepo = \Env::em()->getRepository('Cx\Core\ContentManager\Model\Entity\Page');
        // only list results in case the associated page of the module is active
        $page = $pageRepo->findOneBy(array(
            'module' => $module,
            'lang' => FRONTEND_LANG_ID,
            'type' => \Cx\Core\ContentManager\Model\Entity\Page::TYPE_APPLICATION,
            'cmd' => $command,
        ));
        if (!$page || !$page->isActive()) {
            return array();
        }
        // don't list results in case the user doesn't have sufficient rights to access the page
        // and the option to list only unprotected pages is set (coreListProtectedPages)
        $hasPageAccess = true;
        $config = \Env::get('config');
        if ($config['coreListProtectedPages'] == 'off' && $page->isFrontendProtected()) {
            $hasPageAccess = \Permission::checkAccess(
                    $page->getFrontendAccessId(), 'dynamic', true);
        }
        if (!$hasPageAccess) {
            return array();
        }
        // In case we are handling the search result of a module ($module is not empty),
        // we have to check if we are allowed to list the results even when the associated module
        // page is invisible.
        // We don't have to check for regular pages ($module is empty) here, because they
        // are handled by an other method than this one.
        if ($config['searchVisibleContentOnly'] == 'on' && !empty($module)) {
            if (!$page->isVisible()) {
                // If $command is set, then this would indicate that we have
                // checked the visibility of the detail view page of the module.
                // Those pages are almost always invisible.
                // Therefore, we shall make the decision if we are allowed to list
                // the results based on the visibility of the main module page
                // (empty $command).
                if (!empty($command)) {
                    $mainModulePage = $pageRepo->findOneBy(array(
                        'module' => $module,
                        'lang' => FRONTEND_LANG_ID,
                        'type' => \Cx\Core\ContentManager\Model\Entity\Page::TYPE_APPLICATION,
                        'cmd' => '',
                    ));
                    if (   !$mainModulePage
                        || !$mainModulePage->isActive()
                        || !$mainModulePage->isVisible()) {
                        // main module page is also invisible
                        return array();
                    }
                } else {
                    // page is invisible
                    return array();
                }
            }
        }
        $pagePath = $pageRepo->getPath($page);
        $objDatabase = \Env::get('db');
        $objResult = $objDatabase->Execute($query);
        if (!$objResult || $objResult->EOF) {
            return array();
        }
        $max_length = intval($config['searchDescriptionLength']);
        $arraySearchResults = array();
        while (!$objResult->EOF) {
            switch ($module) {
                case '':
                case 'docsys':
                case 'podcast':
                case 'gallery':
                case 'memberdir':
                case 'directory':
                case 'forum':
                    $temp_pagelink =
                        $pagePath.'?'.$pagevar.$objResult->fields['id'];
                    break;
                case 'shop':
                    $temp_pagelink =
                        $pagePath.'?'.$pagevar.$objResult->fields['id'];
                    // The query created by the Products class results in
                    // different indices which need to be relabelled here
                    $objResult->fields['title'] = $objResult->fields['name'];
                    $objResult->fields['content'] = ($objResult->fields['long']
                        ? $objResult->fields['long']
                        : $objResult->fields['short']);
                    $objResult->fields['score'] =
                          $objResult->fields['score1']
                        + $objResult->fields['score2']
                        + $objResult->fields['score3'];
                    break;
                case 'calendar':
                    $temp_pagelink =
                         $pagePath
                        .'?'.$pagevar.$objResult->fields['id']
                        ."&date=".intval($objResult->fields['startdate']);
                    break;
                case 'news':
                    if (empty($objResult->fields['redirect'])) {
                        $temp_pagelink =
                            $pagePath.'?'.$pagevar.$objResult->fields['id'];
                    } else {
                        $temp_pagelink = $objResult->fields['redirect'];
                    }
                    break;
            }
            $content = (isset($objResult->fields['content'])
                ? trim($objResult->fields['content']) : '');
            $content = \Search::shortenSearchContent($content, $max_length);
            $score = $objResult->fields['score'];
            $scorePercent = ($score >= 1 ? 100 : intval($score * 100));
//TODO: Muss noch geändert werden, sobald das Ranking bei News funktioniert
            $scorePercent = ($score == 0 ? 25 : $scorePercent);
            $date = empty($objResult->fields['date'])
                ? NULL : $objResult->fields['date'];
            $searchtitle = empty($objResult->fields['title'])
                ? $_ARRAYLANG['TXT_UNTITLED'] : $objResult->fields['title'];
            $arraySearchResults[] = array(
                'Score' => $scorePercent,
                'Title' => $searchtitle,
                'Content' => $content,
                'Link' => $temp_pagelink,
                'Date' => $date,
            );
            $objResult->MoveNext();
        }
        return $arraySearchResults;
    }


    /**
     * Shorten and format the search result content
     *
     * Strips template placeholders and blocks, as well as certain tags,
     * and fixes the character encoding
     * @param   string  $content        The content
     * @param   integer $max_length     The maximum allowed length of the
     *                                  preview content, in characters(*)
     * @return  string                  The formatted content
     * @todo    (*) I think these are actually bytes.
     */
    public static function shortenSearchContent($content, $max_length=NULL)
    {
        $content = contrexx_html2plaintext($content);

        // Omit the content when there is no letter in it
        if (!preg_match('/\w/', $content)) return '';

        $max_length = intval($max_length);
        if (strlen($content) > $max_length) {
            $content = substr($content, 0, $max_length);
            $arrayContent = explode(' ', $content);
            array_pop($arrayContent);
            $content = join(' ', $arrayContent).' ...';
        }
        return $content;
    }
}
