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
 * This handles exceptions for new Component structure. This is old code
 * and should be replaced so that this class becomes unnecessary
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Michael Ritter <michael.ritter@comvation.com>
 * @package     contrexx
 * @subpackage  core_core
 * @link        http://www.contrexx.com/ contrexx homepage
 * @since       v3.1.0
 * @todo: Remove this code (move all exceptions to components)
 */

namespace Cx\Core\Core\Controller;

/**
 * This handles exceptions for new Component structure. This is old code
 * and should be replaced so that this class becomes unnecessary
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Michael Ritter <michael.ritter@comvation.com>
 * @package     contrexx
 * @subpackage  core_core
 * @link        http://www.contrexx.com/ contrexx homepage
 * @since       v3.1.0
 * @todo: Remove this code (move all exceptions to components)
 */
class LegacyComponentHandler {
    /**
     * This is the list of exceptions
     *
     * array[
     *     frontend|
     *     backend
     * ][
     *     preResolve|
     *     postResolve|
     *     preContentLoad|
     *     preContentParse|
     *     load|
     *     postContentParse|
     *     postContentLoad|
     *     preFinalize|
     *     postFinalize
     * ] = {callable}
     * @var array
     */
    private $exceptions = array();

    /**
     * Tells wheter there is an exception for a certain action and component or not
     * @param boolean $frontend Are we in frontend mode or not
     * @param string $action Name of action
     * @param string $componentName Component name
     * @return boolean True if there is an exception listed, false otherwise
     */
    public function hasExceptionFor($frontend, $action, $componentName) {
        if (!isset($this->exceptions[$frontend ? 'frontend' : 'backend'][$action])) {
            return false;
        }
        return isset($this->exceptions[$frontend ? 'frontend' : 'backend'][$action][$componentName]);
    }

    /**
     * Checks if the component is active and in the list of legal components (license)
     * @param  boolean $frontend      Are we in frontend mode or not
     * @param  string  $componentName Component name
     * @return boolean True if the component is active and legal, false otherwise
     */
    public function isActive($frontend, $componentName) {
        $cx = \Env::get('cx');
        $cn = strtolower($componentName);
        $mc = \Cx\Core\ModuleChecker::getInstance($cx->getDb()->getEntityManager(), $cx->getDb()->getAdoDb(), $cx->getClassLoader());

        if (!in_array($cn, $mc->getModules())) {
            return true;
        }

        if ($frontend) {
            if (!$cx->getLicense()->isInLegalFrontendComponents($cn)) {
                return false;
            }
        } else {
            if (!$cx->getLicense()->isInLegalComponents($cn)) {
                return false;
            }
        }

        if (!$mc->isModuleInstalled($cn)) {
            return false;
        }

        return true;
    }

    /**
     * Executes an exception (if any) for a certain action and component
     * @param boolean $frontend Are we in frontend mode or not
     * @param string $action Name of action
     * @param string $componentName Component name
     * @return mixed Return value of called exception (most of them return null)
     */
    public function executeException($frontend, $action, $componentName) {
        if (!$this->hasExceptionFor($frontend, $action, $componentName)
            || !$this->isActive($frontend, $componentName)) {
            return false;
        }

        return $this->exceptions[$frontend ? 'frontend' : 'backend'][$action][$componentName]();
    }

    /**
     * Pushes all the legacy code into our array of exceptions
     * @throws \Exception If frontend is locked by license
     */
    public function __construct() {
        // now follows the loooooooooooong list of old code:
        $this->exceptions = array(
            'frontend' => array(
                'preResolve' => array(
                    'License' => function() {
                        global $license, $_CONFIG, $objDatabase;

                        // make sure license data is up to date (this updates active available modules)
                        // @todo move to core_module license
                        $license = \Cx\Core_Modules\License\License::getCached($_CONFIG, $objDatabase);
                        $oldState = $license->getState();
                        $license->check();
                        if ($oldState != $license->getState()) {
                            $license->save(new \settingsManager(), $objDatabase);
                        }
                        if ($license->isFrontendLocked()) {
                            // Since throwing an exception now results in showing offline.html, we can simply do
                            throw new \Exception('Frontend locked by license');
                        }
                    },
                    'Security' => function() {
                        global $objSecurity;

                        // Webapp Intrusion Detection System
                        $objSecurity = new \Security;
                        $_GET = $objSecurity->detectIntrusion($_GET);
                        $_POST = $objSecurity->detectIntrusion($_POST);
                        $_COOKIE = $objSecurity->detectIntrusion($_COOKIE);
                        $_REQUEST = $objSecurity->detectIntrusion($_REQUEST);
                    },
                    'Captcha' => function() {
                        global $url;

                        $params = $url->getParamArray();
                        if (isset($params['section']) && $params['section'] == 'captcha') {
                            /*
                            * Captcha Module
                            *
                            * Generates no output, requests are answered by a die()
                            * @since   2.1.5
                            */
                            \FWCaptcha::getInstance()->getPage();
                        }
                    },
                    'Upload' => function() {
                        global $isRegularPageRequest;

                        if (isset($_REQUEST['section']) && $_REQUEST['section'] == 'upload') {
                            $_REQUEST['standalone'] = 'true';
                        }
                    }
                ),
                'postResolve' => array(
                    'Upload' => function() {
                        global $url, $sessionObj;

                        if (isset($_REQUEST['section']) && $_REQUEST['section'] == 'upload') {
                            if (!isset($sessionObj) || !is_object($sessionObj)) $sessionObj = \cmsSession::getInstance(); // initialize session object                            
                            $objUploadModule = new \Upload();
                            $objUploadModule->getPage();
                            //execution never reaches this point
                        }
                    },
                    'License' => function() {
                        global $license, $_LANGID, $section, $_CORELANG;

                        if (!$license->isInLegalComponents('fulllanguage') && $_LANGID != \FWLanguage::getDefaultLangId()) {
                            $_LANGID = \FWLanguage::getDefaultLangId();
                            \Env::get('Resolver')->redirectToCorrectLanguageDir();
                        }

                        if (!empty($section) && !$license->isInLegalFrontendComponents($section)) {
                            if ($section == 'error') {
                                // If the error module is not installed, show this
                                die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                            } else {
                                //page not found, redirect to error page.
                                \CSRF::header('Location: '.\Cx\Core\Routing\Url::fromModuleAndCmd('error'));
                                exit;
                            }
                        }
                    },
                    'Newsletter' => function() {
                        global $section, $command;
                        if ($section == 'newsletter') {
                            if (\Newsletter::isTrackLink()) {
                                //handle link tracker from newsletter, since user should be redirected to the link url
                                /*
                                 * Newsletter Module
                                 *
                                 * Generates no output, requests are answered by a redirect to foreign site
                                 *
                                 */
                                \Newsletter::trackLink();
                                //execution should never reach this point, but let's be safe and call exit anyway
                                exit;
                            } elseif ($command == 'displayInBrowser') {
                                \Newsletter::displayInBrowser();
                                //execution should never reach this point, but let's be safe and call exit anyway
                                exit;
                            }

                            // regular newsletter request (like subscribing, profile management, etc).
                            // must not abort by an exit call here!
                        }
                    },
                ),
                'preContentLoad' => array(
                    'JsonData' => function() {
                        global $section, $json, $adapter, $method, $arguments;

                        if ($section == 'jsondata') {
                        // TODO: move this code to /core/Json/...
                        // TODO: handle expired sessions in any xhr callers.
                            $json = new \Cx\Core\Json\JsonData();
                        // TODO: Verify that the arguments are actually present!
                            $adapter = contrexx_input2raw($_GET['object']);
                            $method = contrexx_input2raw($_GET['act']);
                        // TODO: Replace arguments by something reasonable
                            $arguments = array('get' => $_GET, 'post' => $_POST);
                            echo $json->jsondata($adapter, $method, $arguments);
                            die();
                        }
                    },
                    'Newsletter' => function() {
                        global $section, $isRegularPageRequest, $plainSection, $cl, $_CORELANG,
                                $newsletter, $_ARRAYLANG, $page_template, $themesPages, $objInit;
                        // get Newsletter
                        /** @ignore */
                        if ($cl->loadFile(ASCMS_MODULE_PATH.'/newsletter/index.class.php')) {
                            $_ARRAYLANG = array_merge($_ARRAYLANG, $objInit->loadLanguageData('newsletter'));
                            $newsletter = new \newsletter('');
                            $content = \Env::get('cx')->getPage()->getContent();
                            if (preg_match('/{NEWSLETTER_BLOCK}/', $content)) {
                                $newsletter->setBlock($content);
                            }
                            if (preg_match('/{NEWSLETTER_BLOCK}/', $page_template)) {
                                $newsletter->setBlock($page_template);
                            }
                            if (preg_match('/{NEWSLETTER_BLOCK}/', $themesPages['index'])) {
                                $newsletter->setBlock($themesPages['index']);
                            }
                        }
                    },
                    'Immo' => function() {
                        global $isRegularPageRequest, $plainSection, $cl, $_CORELANG, $objImmo, $modulespath,
                                $immoHeadlines, $themesPages, $immoHomeHeadlines, $page_template;

                        if (!$isRegularPageRequest) {
                            // ATTENTION: These requests are not protected by the content manager
                            //            and must therefore be authorized by the calling component itself!
                            switch ($plainSection) {
                                case 'immo':
                                    /** @ignore */
                                    if (!$cl->loadFile(ASCMS_MODULE_PATH.'/immo/index.class.php'))
                                        die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                                    $objImmo = new \Immo('');
                                    $objImmo->getPage();
                                    exit;
                                    break;
                            }
                        }

                        // Get immo headline
                        $modulespath = ASCMS_MODULE_PATH.'/immo/headlines/index.class.php';
                        if (file_exists($modulespath)) {
                            $immoHeadlines = new \immoHeadlines($themesPages['immo']);
                            $immoHomeHeadlines = $immoHeadlines->getHeadlines();
                            \Env::get('cx')->getPage()->setContent(str_replace('{IMMO_FILE}', $immoHomeHeadlines, \Env::get('cx')->getPage()->getContent()));
                            $themesPages['index'] = str_replace('{IMMO_FILE}', $immoHomeHeadlines, $themesPages['index']);
                            $page_template = str_replace('{IMMO_FILE}', $immoHomeHeadlines, $page_template);
                        }
                    },
                    'Stats' => function() {
                        global $objCounter;

                        // Initialize counter and track search engine robot
                        $objCounter = new \statsLibrary();
                        $objCounter->checkForSpider();
                    },
                    'Block' => function() {
                        global $_CONFIG, $cl, $page, $themesPages, $page_template;

                        if ($_CONFIG['blockStatus'] == '1') {
                            /** @ignore */
                            if ($cl->loadFile(ASCMS_MODULE_PATH.'/block/index.class.php')) {
                                $content = \Env::get('cx')->getPage()->getContent();
                                \block::setBlocks($content, $page);
                                \Env::get('cx')->getPage()->setContent($content);
                                \block::setBlocks($themesPages, $page);
                        // TODO: this call in unhappy, becase the content/home template already gets parsed just the line above
                                \block::setBlocks($page_template, $page);
                            }
                        }
                    },
                    'Data' => function() {
                        global $_CONFIG, $cl, $lang, $objInit, $dataBlocks, $lang,
                                $dataBlocks, $themesPages, $page_template;

                        // make the replacements for the data module
                        if ($_CONFIG['dataUseModule'] && $cl->loadFile(ASCMS_MODULE_PATH.'/data/dataBlocks.class.php')) {
                            $lang = $objInit->loadLanguageData('data');
                            $dataBlocks = new \dataBlocks($lang);
                            \Env::get('cx')->getPage()->setContent($dataBlocks->replace(\Env::get('cx')->getPage()->getContent()));
                            $themesPages = $dataBlocks->replace($themesPages);
                            $page_template = $dataBlocks->replace($page_template);
                        }
                    },
                    'Teasers' => function() {
                        global $_CONFIG, $arrMatches, $cl, $objTeasers, $page_template,
                                $themesPages;

                        $arrMatches = array();
                        // Set news teasers
                        if ($_CONFIG['newsTeasersStatus'] == '1') {
                            // set news teasers in the content
                            if (preg_match_all('/{TEASERS_([0-9A-Z_-]+)}/', \Env::get('cx')->getPage()->getContent(), $arrMatches)) {
                                /** @ignore */
                                if ($cl->loadFile(ASCMS_CORE_MODULE_PATH.'/news/lib/teasers.class.php')) {
                                    $objTeasers = new \Teasers();
                                    $content = \Env::get('cx')->getPage()->getContent();
                                    $objTeasers->setTeaserFrames($arrMatches[1], $content);
                                    \Env::get('cx')->getPage()->setContent($content);
                                }
                            }
                            // set news teasers in the page design
                            if (preg_match_all('/{TEASERS_([0-9A-Z_-]+)}/', $page_template, $arrMatches)) {
                                /** @ignore */
                                if ($cl->loadFile(ASCMS_CORE_MODULE_PATH.'/news/lib/teasers.class.php')) {
                                    $objTeasers = new \Teasers();
                                    $objTeasers->setTeaserFrames($arrMatches[1], $page_template);
                                }
                            }
                            // set news teasers in the website design
                            if (preg_match_all('/{TEASERS_([0-9A-Z_-]+)}/', $themesPages['index'], $arrMatches)) {
                                /** @ignore */
                                if ($cl->loadFile(ASCMS_CORE_MODULE_PATH.'/news/lib/teasers.class.php')) {
                                    $objTeasers = new \Teasers();
                                    $objTeasers->setTeaserFrames($arrMatches[1], $themesPages['index']);
                                }
                            }
                        }
                    },
                    'Downloads' => function() {
                        global $arrMatches, $cl, $objDownloadLib, $downloadBlock, $matches,
                                $objDownloadsModule;

                        // Set download groups
                        if (preg_match_all('/{DOWNLOADS_GROUP_([0-9]+)}/', \Env::get('cx')->getPage()->getContent(), $arrMatches)) {
                            /** @ignore */
                            if ($cl->loadFile(ASCMS_MODULE_PATH.'/downloads/lib/downloadsLib.class.php')) {
                                $objDownloadLib = new \DownloadsLibrary();
                                $objDownloadLib->setGroups($arrMatches[1], \Env::get('cx')->getPage()->getContent());
                            }
                        }

                        //--------------------------------------------------------
                        // Parse the download block 'downloads_category_#ID_list'
                        //--------------------------------------------------------
                        $content = \Env::get('cx')->getPage()->getContent();
                        $downloadBlock = preg_replace_callback(
                            "/<!--\s+BEGIN\s+downloads_category_(\d+)_list\s+-->(.*)<!--\s+END\s+downloads_category_\g1_list\s+-->/s",
                            function($matches) {
                                \Env::get('init')->loadLanguageData('downloads');
                                if (isset($matches[2])) {
                                    $objDownloadsModule = new \downloads($matches[2], array('category' => $matches[1]));
                                    return $objDownloadsModule->getPage();
                                }
                            },
                            $content);
                        \Env::get('cx')->getPage()->setContent($downloadBlock);
                    },
                    'Feed' => function() {
                        global $_CONFIG, $objNewsML, $arrMatches, $page_template, $themesPages;

                        // Set NewsML messages
                        if ($_CONFIG['feedNewsMLStatus'] == '1') {
                            if (preg_match_all('/{NEWSML_([0-9A-Z_-]+)}/', \Env::get('cx')->getPage()->getContent(), $arrMatches)) {
                                /** @ignore */
                                if ($cl->loadFile(ASCMS_MODULE_PATH.'/feed/newsML.class.php')) {
                                    $objNewsML = new \NewsML();
                                    $objNewsML->setNews($arrMatches[1], \Env::get('cx')->getPage()->getContent());
                                }
                            }
                            if (preg_match_all('/{NEWSML_([0-9A-Z_-]+)}/', $page_template, $arrMatches)) {
                                /** @ignore */
                                if ($cl->loadFile(ASCMS_MODULE_PATH.'/feed/newsML.class.php')) {
                                    $objNewsML = new \NewsML();
                                    $objNewsML->setNews($arrMatches[1], $page_template);
                                }
                            }
                            if (preg_match_all('/{NEWSML_([0-9A-Z_-]+)}/', $themesPages['index'], $arrMatches)) {
                                /** @ignore */
                                if ($cl->loadFile(ASCMS_MODULE_PATH.'/feed/newsML.class.php')) {
                                    $objNewsML = new \NewsML();
                                    $objNewsML->setNews($arrMatches[1], $themesPages['index']);
                                }
                            }
                        }
                    },
                    'News' => function() {
                        global $modulespath, $headlinesNewsPlaceholder, $themesPages, $page_template,
                                $newsHeadlinesObj, $homeHeadlines, $topNewsPlaceholder, $homeTopNews;

                        // Get Headlines
                        $modulespath = ASCMS_CORE_MODULE_PATH.'/news/lib/headlines.class.php';
                        if (file_exists($modulespath)) {
                            for ($i = 0; $i < 5; $i++) {
                                $visibleI = '';
                                if ($i > 0) {
                                    $visibleI = (string) $i;
                                }
                                $headlinesNewsPlaceholder = '{HEADLINES' . $visibleI . '_FILE}';
                                if (
                                    strpos(\Env::get('cx')->getPage()->getContent(), $headlinesNewsPlaceholder) !== false
                                    || strpos($themesPages['index'], $headlinesNewsPlaceholder) !== false
                                    || strpos($themesPages['sidebar'], $headlinesNewsPlaceholder) !== false
                                    || strpos($page_template, $headlinesNewsPlaceholder) !== false
                                ) {
                                    $category = 0;
                                    $matches = array();
                                    if (preg_match('/\{CATEGORY_([0-9]+)\}/', trim($themesPages['headlines' . $visibleI]), $matches)) {
                                        $category = $matches[1];
                                    }
                                    $newsHeadlinesObj = new \newsHeadlines($themesPages['headlines' . $visibleI]);
                                    $homeHeadlines = $newsHeadlinesObj->getHomeHeadlines($category);
                                    \Env::get('cx')->getPage()->setContent(str_replace($headlinesNewsPlaceholder, $homeHeadlines, \Env::get('cx')->getPage()->getContent()));
                                    $themesPages['index']   = str_replace($headlinesNewsPlaceholder, $homeHeadlines, $themesPages['index']);
                                    $themesPages['sidebar'] = str_replace($headlinesNewsPlaceholder, $homeHeadlines, $themesPages['sidebar']);
                                    $page_template          = str_replace($headlinesNewsPlaceholder, $homeHeadlines, $page_template);
                                }
                            }
                        }


                        // Get Top news
                        $modulespath = ASCMS_CORE_MODULE_PATH.'/news/lib/top_news.class.php';
                        $topNewsPlaceholder = '{TOP_NEWS_FILE}';
                        if (   file_exists($modulespath)
                            && (   strpos(\Env::get('cx')->getPage()->getContent(), $topNewsPlaceholder) !== false
                                || strpos($themesPages['index'], $topNewsPlaceholder) !== false
                                || strpos($themesPages['sidebar'], $topNewsPlaceholder) !== false
                                || strpos($page_template, $topNewsPlaceholder) !== false)
                        ) {
                            $newsTopObj = new \newsTop($themesPages['top_news']);
                            $homeTopNews = $newsTopObj->getHomeTopNews();
                            \Env::get('cx')->getPage()->setContent(str_replace($topNewsPlaceholder, $homeTopNews, \Env::get('cx')->getPage()->getContent()));
                            $themesPages['index']   = str_replace($topNewsPlaceholder, $homeTopNews, $themesPages['index']);
                            $themesPages['sidebar'] = str_replace($topNewsPlaceholder, $homeTopNews, $themesPages['sidebar']);
                            $page_template          = str_replace($topNewsPlaceholder, $homeTopNews, $page_template);
                        }
                        
                        // Get News categories
                        $modulespath = ASCMS_CORE_MODULE_PATH.'/news/lib/newsLib.class.php';
                        $newsCategoriesPlaceholder = '{NEWS_CATEGORIES}';
                        if (   file_exists($modulespath)
                            && (   strpos(\Env::get('cx')->getPage()->getContent(), $newsCategoriesPlaceholder) !== false
                                || strpos($themesPages['index'], $newsCategoriesPlaceholder) !== false
                                || strpos($themesPages['sidebar'], $newsCategoriesPlaceholder) !== false
                                || strpos($page_template, $newsCategoriesPlaceholder) !== false)
                        ) {
                            $newsLib = new \newsLibrary();
                            $newsCategories = $newsLib->getNewsCategories();
                            
                            \Env::get('cx')->getPage()->setContent(str_replace($newsCategoriesPlaceholder, $newsCategories, \Env::get('cx')->getPage()->getContent()));
                            $themesPages['index']   = str_replace($newsCategoriesPlaceholder, $newsCategories, $themesPages['index']);
                            $themesPages['sidebar'] = str_replace($newsCategoriesPlaceholder, $newsCategories, $themesPages['sidebar']);
                            $page_template          = str_replace($newsCategoriesPlaceholder, $newsCategories, $page_template);
                        }
                        
                        // Get News Archives
                        $modulespath = ASCMS_CORE_MODULE_PATH.'/news/lib/newsLib.class.php';
                        $newsArchivePlaceholder = '{NEWS_ARCHIVES}';
                        if (   file_exists($modulespath)
                            && (   strpos(\Env::get('cx')->getPage()->getContent(), $newsArchivePlaceholder) !== false
                                || strpos($themesPages['index'], $newsArchivePlaceholder) !== false
                                || strpos($themesPages['sidebar'], $newsArchivePlaceholder) !== false
                                || strpos($page_template, $newsArchivePlaceholder) !== false)
                        ) {
                            $newsLib = new \newsLibrary();
                            $newsArchive = $newsLib->getNewsArchiveList();
                            
                            \Env::get('cx')->getPage()->setContent(str_replace($newsArchivePlaceholder, $newsArchive, \Env::get('cx')->getPage()->getContent()));
                            $themesPages['index']   = str_replace($newsArchivePlaceholder, $newsArchive, $themesPages['index']);
                            $themesPages['sidebar'] = str_replace($newsArchivePlaceholder, $newsArchive, $themesPages['sidebar']);
                            $page_template          = str_replace($newsArchivePlaceholder, $newsArchive, $page_template);
                        }
                        // Get recent News Comments
                        $modulespath = ASCMS_CORE_MODULE_PATH.'/news/lib/newsRecentComments.class.php';
                        $newsCommentsPlaceholder = '{NEWS_RECENT_COMMENTS_FILE}';
                        
                        if (   file_exists($modulespath)
                            && (   strpos(\Env::get('cx')->getPage()->getContent(), $newsCommentsPlaceholder) !== false
                                || strpos($themesPages['index'], $newsCommentsPlaceholder) !== false
                                || strpos($themesPages['sidebar'], $newsCommentsPlaceholder) !== false
                                || strpos($page_template, $newsCommentsPlaceholder) !== false)
                        ) {
                            $newsLib = new \newsRecentComments($themesPages['news_recent_comments']);
                            $newsComments = $newsLib->getRecentNewsComments();
                            
                            \Env::get('cx')->getPage()->setContent(str_replace($newsCommentsPlaceholder, $newsComments, \Env::get('cx')->getPage()->getContent()));
                            $themesPages['index']   = str_replace($newsCommentsPlaceholder, $newsComments, $themesPages['index']);
                            $themesPages['sidebar'] = str_replace($newsCommentsPlaceholder, $newsComments, $themesPages['sidebar']);
                            $page_template          = str_replace($newsCommentsPlaceholder, $newsComments, $page_template);
                        }
                    },
                    'Calendar' => function() {
                        global $modulespath, $eventsPlaceholder, $_CONFIG, $themesPages, $page_template,
                                $calHeadlinesObj, $calHeadlines, $cl, $_ARRAYLANG;

                        // Get Calendar Events
                        $modulespath = ASCMS_MODULE_PATH.'/calendar/lib/headlines.class.php';
                        $eventsPlaceholder = '{EVENTS_FILE}';
                        if (   MODULE_INDEX < 2
                            && $_CONFIG['calendarheadlines']
                            && (   strpos(\Env::get('cx')->getPage()->getContent(), $eventsPlaceholder) !== false
                                || strpos($themesPages['index'], $eventsPlaceholder) !== false
                                || strpos($themesPages['sidebar'], $eventsPlaceholder) !== false
                                || strpos($page_template, $eventsPlaceholder) !== false)
                            && file_exists($modulespath)
                        ) {
                            $_ARRAYLANG = array_merge($_ARRAYLANG, \Env::get('init')->loadLanguageData('calendar'));
                            $calHeadlinesObj = new \CalendarHeadlines($themesPages['calendar_headlines']);
                            $calHeadlines = $calHeadlinesObj->getHeadlines();
                            \Env::get('cx')->getPage()->setContent(str_replace($eventsPlaceholder, $calHeadlines, \Env::get('cx')->getPage()->getContent()));
                            $themesPages['index']   = str_replace($eventsPlaceholder, $calHeadlines, $themesPages['index']);
                            $themesPages['sidebar'] = str_replace($eventsPlaceholder, $calHeadlines, $themesPages['sidebar']);
                            $page_template          = str_replace($eventsPlaceholder, $calHeadlines, $page_template);
                        }
                    },
                    'Knowledge' => function() {
                        global $_CONFIG, $cl, $knowledgeInterface, $page_template, $themesPages;

                        // get knowledge content
                        if (MODULE_INDEX < 2 && !empty($_CONFIG['useKnowledgePlaceholders'])) {
                            if ($cl->loadFile(ASCMS_MODULE_PATH.'/knowledge/interface.class.php')) {

                                $knowledgeInterface = new \KnowledgeInterface();
                                if (preg_match('/{KNOWLEDGE_[A-Za-z0-9_]+}/i', \Env::get('cx')->getPage()->getContent())) {
                                    $knowledgeInterface->parse(\Env::get('cx')->getPage()->getContent());
                                }
                                if (preg_match('/{KNOWLEDGE_[A-Za-z0-9_]+}/i', $page_template)) {
                                    $knowledgeInterface->parse($page_template);
                                }
                                if (preg_match('/{KNOWLEDGE_[A-Za-z0-9_]+}/i', $themesPages['index'])) {
                                    $knowledgeInterface->parse($themesPages['index']);
                                }
                            }
                        }
                    },
                    'Directory' => function() {
                        global $_CONFIG, $cl, $dirc, $themesPages, $page_template, $themesPages;

                        // get Directory Homecontent
                        if ($_CONFIG['directoryHomeContent'] == '1') {
                            if ($cl->loadFile(ASCMS_MODULE_PATH.'/directory/homeContent.class.php')) {

                                $dirc = $themesPages['directory_content'];
                                if (preg_match('/{DIRECTORY_FILE}/', \Env::get('cx')->getPage()->getContent())) {
                                    \Env::get('cx')->getPage()->setContent(str_replace('{DIRECTORY_FILE}', \dirHomeContent::getObj($dirc)->getContent(), \Env::get('cx')->getPage()->getContent()));
                                }
                                if (preg_match('/{DIRECTORY_FILE}/', $page_template)) {
                                    $page_template = str_replace('{DIRECTORY_FILE}', \dirHomeContent::getObj($dirc)->getContent(), $page_template);
                                }
                                if (preg_match('/{DIRECTORY_FILE}/', $themesPages['index'])) {
                                    $themesPages['index'] = str_replace('{DIRECTORY_FILE}', \dirHomeContent::getObj($dirc)->getContent(), $themesPages['index']);
                                }
                            }
                        }
                    },
                    'Forum' => function() {
                        global $_CONFIG, $cl, $forumHomeContentInPageContent, $forumHomeContentInPageTemplate,
                                $forumHomeContentInThemesPage, $page_template, $themesPages,
                                $homeForumContent, $_ARRAYLANG, $objInit, $objForum, $objForumHome,
                                $forumHomeTagCloudInContent, $forumHomeTagCloudInTemplate, $forumHomeTagCloudInTheme,
                                $forumHomeTagCloudInSidebar, $strTagCloudSource;

                        // get + replace forum latest entries content
                        if ($_CONFIG['forumHomeContent'] == '1') {
                            /** @ignore */
                            if ($cl->loadFile(ASCMS_MODULE_PATH.'/forum/homeContent.class.php')) {
                                $forumHomeContentInPageContent = false;
                                $forumHomeContentInPageTemplate = false;
                                $forumHomeContentInThemesPage = false;
                                if (strpos(\Env::get('cx')->getPage()->getContent(), '{FORUM_FILE}') !== false) {
                                    $forumHomeContentInPageContent = true;
                                }
                                if (strpos($page_template, '{FORUM_FILE}') !== false) {
                                    $forumHomeContentInPageTemplate = true;
                                }
                                if (strpos($themesPages['index'], '{FORUM_FILE}') !== false) {
                                    $forumHomeContentInThemesPage = true;
                                }
                                $homeForumContent = '';
                                if ($forumHomeContentInPageContent || $forumHomeContentInPageTemplate || $forumHomeContentInThemesPage) {
                                    $_ARRAYLANG = array_merge($_ARRAYLANG, $objInit->loadLanguageData('forum'));
                                    $objForum = new \ForumHomeContent($themesPages['forum_content']);
                                    $homeForumContent = $objForum->getContent();
                                }
                                if ($forumHomeContentInPageContent) {
                                    \Env::get('cx')->getPage()->setContent(str_replace('{FORUM_FILE}', $homeForumContent, \Env::get('cx')->getPage()->getContent()));
                                }
                                if ($forumHomeContentInPageTemplate) {
                                    $page_template = str_replace('{FORUM_FILE}', $homeForumContent, $page_template);
                                }
                                if ($forumHomeContentInThemesPage) {
                                    $themesPages['index'] = str_replace('{FORUM_FILE}', $homeForumContent, $themesPages['index']);
                                }
                            }
                        }

                        // get + replace forum tagcloud
                        if (!empty($_CONFIG['forumTagContent'])) {
                            /** @ignore */
                            if ($cl->loadFile(ASCMS_MODULE_PATH.'/forum/homeContent.class.php')) {
                                $objForumHome = new \ForumHomeContent('');
                                //Forum-TagCloud
                                $forumHomeTagCloudInContent = $objForumHome->searchKeywordInContent('FORUM_TAG_CLOUD', \Env::get('cx')->getPage()->getContent());
                                $forumHomeTagCloudInTemplate = $objForumHome->searchKeywordInContent('FORUM_TAG_CLOUD', $page_template);
                                $forumHomeTagCloudInTheme = $objForumHome->searchKeywordInContent('FORUM_TAG_CLOUD', $themesPages['index']);
                                $forumHomeTagCloudInSidebar = $objForumHome->searchKeywordInContent('FORUM_TAG_CLOUD', $themesPages['sidebar']);
                                if (   $forumHomeTagCloudInContent
                                    || $forumHomeTagCloudInTemplate
                                    || $forumHomeTagCloudInTheme
                                    || $forumHomeTagCloudInSidebar
                                ) {
                                    $strTagCloudSource = $objForumHome->getHomeTagCloud();
                                    \Env::get('cx')->getPage()->setContent($objForumHome->fillVariableIfActivated('FORUM_TAG_CLOUD', $strTagCloudSource, \Env::get('cx')->getPage()->getContent(), $forumHomeTagCloudInContent));
                                    $page_template = $objForumHome->fillVariableIfActivated('FORUM_TAG_CLOUD', $strTagCloudSource, $page_template, $forumHomeTagCloudInTemplate);
                                    $themesPages['index'] = $objForumHome->fillVariableIfActivated('FORUM_TAG_CLOUD', $strTagCloudSource, $themesPages['index'], $forumHomeTagCloudInTheme);
                                    $themesPages['sidebar'] = $objForumHome->fillVariableIfActivated('FORUM_TAG_CLOUD', $strTagCloudSource, $themesPages['sidebar'], $forumHomeTagCloudInSidebar);
                                }
                            }
                        }
                    },
                    'Gallery' => function() {
                        global $cl, $objGalleryHome, $page_template, $themesPages, $latestImage;

                        // Get Gallery-Images (Latest, Random)
                        /** @ignore */
                        if ($cl->loadFile(ASCMS_MODULE_PATH.'/gallery/homeContent.class.php')) {
                            $objGalleryHome = new \GalleryHomeContent();
                            if ($objGalleryHome->checkRandom()) {
                                if (preg_match('/{GALLERY_RANDOM}/', \Env::get('cx')->getPage()->getContent())) {
                                    \Env::get('cx')->getPage()->setContent(str_replace('{GALLERY_RANDOM}', $objGalleryHome->getRandomImage(), \Env::get('cx')->getPage()->getContent()));
                                }
                                if (preg_match('/{GALLERY_RANDOM}/', $page_template))  {
                                    $page_template = str_replace('{GALLERY_RANDOM}', $objGalleryHome->getRandomImage(), $page_template);
                                }
                                if (preg_match('/{GALLERY_RANDOM}/', $themesPages['index'])) {
                                    $themesPages['index'] = str_replace('{GALLERY_RANDOM}', $objGalleryHome->getRandomImage(), $themesPages['index']);
                                }
                                if (preg_match('/{GALLERY_RANDOM}/', $themesPages['sidebar'])) {
                                    $themesPages['sidebar'] = str_replace('{GALLERY_RANDOM}', $objGalleryHome->getRandomImage(), $themesPages['sidebar']);
                                }
                            }
                            if ($objGalleryHome->checkLatest()) {
                                $latestImage = $objGalleryHome->getLastImage();
                                if (preg_match('/{GALLERY_LATEST}/', \Env::get('cx')->getPage()->getContent())) {
                                    \Env::get('cx')->getPage()->setContent(str_replace('{GALLERY_LATEST}', $latestImage, \Env::get('cx')->getPage()->getContent()));
                                }
                                if (preg_match('/{GALLERY_LATEST}/', $page_template)) {
                                    $page_template = str_replace('{GALLERY_LATEST}', $latestImage, $page_template);
                                }
                                if (preg_match('/{GALLERY_LATEST}/', $themesPages['index'])) {
                                    $themesPages['index'] = str_replace('{GALLERY_LATEST}', $latestImage, $themesPages['index']);
                                }
                                if (preg_match('/{GALLERY_LATEST}/', $themesPages['sidebar'])) {
                                    $themesPages['sidebar'] = str_replace('{GALLERY_LATEST}', $latestImage, $themesPages['sidebar']);
                                }
                            }
                        }
                    },
                    'Podcast' => function() {
                        global $podcastFirstBlock, $podcastContent, $_CONFIG, $cl, $podcastHomeContentInPageContent,
                                $podcastHomeContentInPageTemplate, $podcastHomeContentInThemesPage,
                                $page_template, $themesPages, $_ARRAYLANG, $objInit, $objPodcast, $podcastBlockPos,
                                $contentPos;

                        // get latest podcast entries
                        $podcastFirstBlock = false;
                        $podcastContent = null;
                        if (!empty($_CONFIG['podcastHomeContent'])) {
                            /** @ignore */
                            if ($cl->loadFile(ASCMS_MODULE_PATH.'/podcast/homeContent.class.php')) {
                                $podcastHomeContentInPageContent = false;
                                $podcastHomeContentInPageTemplate = false;
                                $podcastHomeContentInThemesPage = false;
                                if (strpos(\Env::get('cx')->getPage()->getContent(), '{PODCAST_FILE}') !== false) {
                                    $podcastHomeContentInPageContent = true;
                                }
                                if (strpos($page_template, '{PODCAST_FILE}') !== false) {
                                    $podcastHomeContentInPageTemplate = true;
                                }
                                if (strpos($themesPages['index'], '{PODCAST_FILE}') !== false) {
                                    $podcastHomeContentInThemesPage = true;
                                }
                                if (   $podcastHomeContentInPageContent
                                    || $podcastHomeContentInPageTemplate
                                    || $podcastHomeContentInThemesPage) {
                                    $_ARRAYLANG = array_merge($_ARRAYLANG, $objInit->loadLanguageData('podcast'));
                                    $objPodcast = new \podcastHomeContent($themesPages['podcast_content']);
                                    $podcastContent = $objPodcast->getContent();
                                    if ($podcastHomeContentInPageContent) {
                                        \Env::get('cx')->getPage()->setContent(str_replace('{PODCAST_FILE}', $podcastContent, \Env::get('cx')->getPage()->getContent()));
                                    }
                                    if ($podcastHomeContentInPageTemplate) {
                                        $page_template = str_replace('{PODCAST_FILE}', $podcastContent, $page_template);
                                    }
                                    if ($podcastHomeContentInThemesPage) {
                                        $podcastFirstBlock = false;
                                        if (strpos($_SERVER['REQUEST_URI'], 'section=podcast')){
                                            $podcastBlockPos = strpos($themesPages['index'], '{PODCAST_FILE}');
                                            $contentPos = strpos($themesPages['index'], '{CONTENT_FILE}');
                                            $podcastFirstBlock = $podcastBlockPos < $contentPos ? true : false;
                                        }
                                        $themesPages['index'] = str_replace('{PODCAST_FILE}',
                                            $objPodcast->getContent($podcastFirstBlock), $themesPages['index']);
                                    }
                                }
                            }
                        }
                    },
                    'Voting' => function() {
                        global $cl, $_ARRAYLANG, $objInit, $themesPages, $arrMatches, $page_template;

                        // get voting
                        /** @ignore */
                        if ($cl->loadFile(ASCMS_MODULE_PATH.'/voting/index.class.php')) {
                            $_ARRAYLANG = array_merge($_ARRAYLANG, $objInit->loadLanguageData('voting'));
                        //  if ($objTemplate->blockExists('voting_result')) {
                        //      $objTemplate->_blocks['voting_result'] = setVotingResult($objTemplate->_blocks['voting_result']);
                        //  }
                            if (preg_match('@<!--\s+BEGIN\s+(voting_result)\s+-->(.*)<!--\s+END\s+\1\s+-->@m', $themesPages['sidebar'], $arrMatches)) {
                                $themesPages['sidebar'] = preg_replace('@(<!--\s+BEGIN\s+(voting_result)\s+-->.*<!--\s+END\s+\2\s+-->)@m', setVotingResult($arrMatches[2]), $themesPages['sidebar']);
                            }
                            if (preg_match('@<!--\s+BEGIN\s+(voting_result)\s+-->(.*)<!--\s+END\s+\1\s+-->@m', $themesPages['index'], $arrMatches)) {
                                $themesPages['index'] = preg_replace('@(<!--\s+BEGIN\s+(voting_result)\s+-->.*<!--\s+END\s+\2\s+-->)@m', setVotingResult($arrMatches[2]), $themesPages['index']);
                            }
                            if (preg_match('@<!--\s+BEGIN\s+(voting_result)\s+-->(.*)<!--\s+END\s+\1\s+-->@m', \Env::get('cx')->getPage()->getContent(), $arrMatches)) {
                                \Env::get('cx')->getPage()->setContent(preg_replace('@(<!--\s+BEGIN\s+(voting_result)\s+-->.*<!--\s+END\s+\2\s+-->)@m', setVotingResult($arrMatches[2]), \Env::get('cx')->getPage()->getContent()));
                            }
                            if (preg_match('@<!--\s+BEGIN\s+(voting_result)\s+-->(.*)<!--\s+END\s+\1\s+-->@m', $page_template, $arrMatches)) {
                                $page_template = preg_replace('@(<!--\s+BEGIN\s+(voting_result)\s+-->.*<!--\s+END\s+\2\s+-->)@m', setVotingResult($arrMatches[2]), $page_template);
                            }
                        }
                    },
                    'Blog' => function() {
                        global $cl, $objBlogHome, $themesPages, $page_template, $_ARRAYLANG, $objInit,
                                $blogHomeContentInContent, $blogHomeContentInTemplate, $blogHomeContentInTheme, $blogHomeContentInSidebar, $strContentSource,
                                $blogHomeCalendarInContent, $blogHomeCalendarInTemplate, $blogHomeCalendarInTheme, $blogHomeCalendarInSidebar, $strCalendarSource,
                                $blogHomeTagCloudInContent, $blogHomeTagCloudInTemplate, $blogHomeTagCloudInTheme, $blogHomeTagCloudInSidebar, $strTagCloudSource,
                                $blogHomeTagHitlistInContent, $blogHomeTagHitlistInTemplate, $blogHomeTagHitlistInTheme, $blogHomeTagHitlistInSidebar, $strTagHitlistSource,
                                $blogHomeCategorySelectInContent, $blogHomeCategorySelectInTemplate, $blogHomeCategorySelectInTheme, $blogHomeCategorySelectInSidebar, $strCategoriesSelect,
                                $blogHomeCategoryListInContent, $blogHomeCategoryListInTemplate, $blogHomeCategoryListInTheme, $blogHomeCategoryListInSidebar, $strCategoriesList;

                        // Get content for the blog-module.
                        /** @ignore */
                        if ($cl->loadFile(ASCMS_MODULE_PATH.'/blog/homeContent.class.php')) {
                            $objBlogHome = new \BlogHomeContent($themesPages['blog_content']);
                            if ($objBlogHome->blockFunktionIsActivated()) {
                                //Blog-File
                                $blogHomeContentInContent = $objBlogHome->searchKeywordInContent('BLOG_FILE', \Env::get('cx')->getPage()->getContent());
                                $blogHomeContentInTemplate = $objBlogHome->searchKeywordInContent('BLOG_FILE', $page_template);
                                $blogHomeContentInTheme = $objBlogHome->searchKeywordInContent('BLOG_FILE', $themesPages['index']);
                                $blogHomeContentInSidebar = $objBlogHome->searchKeywordInContent('BLOG_FILE', $themesPages['sidebar']);
                                if ($blogHomeContentInContent || $blogHomeContentInTemplate || $blogHomeContentInTheme || $blogHomeContentInSidebar) {
                                    $_ARRAYLANG = array_merge($_ARRAYLANG, $objInit->loadLanguageData('blog'));
                                    $strContentSource = $objBlogHome->getLatestEntries();
                                    \Env::get('cx')->getPage()->setContent($objBlogHome->fillVariableIfActivated('BLOG_FILE', $strContentSource, \Env::get('cx')->getPage()->getContent(), $blogHomeContentInContent));
                                    $page_template = $objBlogHome->fillVariableIfActivated('BLOG_FILE', $strContentSource, $page_template, $blogHomeContentInTemplate);
                                    $themesPages['index'] = $objBlogHome->fillVariableIfActivated('BLOG_FILE', $strContentSource, $themesPages['index'], $blogHomeContentInTheme);
                                    $themesPages['sidebar'] = $objBlogHome->fillVariableIfActivated('BLOG_FILE', $strContentSource, $themesPages['sidebar'], $blogHomeContentInSidebar);
                                }
                                //Blog-Calendar
                                $blogHomeCalendarInContent = $objBlogHome->searchKeywordInContent('BLOG_CALENDAR', \Env::get('cx')->getPage()->getContent());
                                $blogHomeCalendarInTemplate = $objBlogHome->searchKeywordInContent('BLOG_CALENDAR', $page_template);
                                $blogHomeCalendarInTheme = $objBlogHome->searchKeywordInContent('BLOG_CALENDAR', $themesPages['index']);
                                $blogHomeCalendarInSidebar = $objBlogHome->searchKeywordInContent('BLOG_CALENDAR', $themesPages['sidebar']);
                                if ($blogHomeCalendarInContent || $blogHomeCalendarInTemplate || $blogHomeCalendarInTheme || $blogHomeCalendarInSidebar) {
                                    $strCalendarSource = $objBlogHome->getHomeCalendar();
                                    \Env::get('cx')->getPage()->setContent($objBlogHome->fillVariableIfActivated('BLOG_CALENDAR', $strCalendarSource, \Env::get('cx')->getPage()->getContent(), $blogHomeCalendarInContent));
                                    $page_template = $objBlogHome->fillVariableIfActivated('BLOG_CALENDAR', $strCalendarSource, $page_template, $blogHomeCalendarInTemplate);
                                    $themesPages['index'] = $objBlogHome->fillVariableIfActivated('BLOG_CALENDAR', $strCalendarSource, $themesPages['index'], $blogHomeCalendarInTheme);
                                    $themesPages['sidebar'] = $objBlogHome->fillVariableIfActivated('BLOG_CALENDAR', $strCalendarSource, $themesPages['sidebar'], $blogHomeCalendarInSidebar);
                                }
                                //Blog-TagCloud
                                $blogHomeTagCloudInContent = $objBlogHome->searchKeywordInContent('BLOG_TAG_CLOUD', \Env::get('cx')->getPage()->getContent());
                                $blogHomeTagCloudInTemplate = $objBlogHome->searchKeywordInContent('BLOG_TAG_CLOUD', $page_template);
                                $blogHomeTagCloudInTheme = $objBlogHome->searchKeywordInContent('BLOG_TAG_CLOUD', $themesPages['index']);
                                $blogHomeTagCloudInSidebar = $objBlogHome->searchKeywordInContent('BLOG_TAG_CLOUD', $themesPages['sidebar']);
                                if ($blogHomeTagCloudInContent || $blogHomeTagCloudInTemplate || $blogHomeTagCloudInTheme || $blogHomeTagCloudInSidebar) {
                                    $strTagCloudSource = $objBlogHome->getHomeTagCloud();
                                    \Env::get('cx')->getPage()->setContent($objBlogHome->fillVariableIfActivated('BLOG_TAG_CLOUD', $strTagCloudSource, \Env::get('cx')->getPage()->getContent(), $blogHomeTagCloudInContent));
                                    $page_template = $objBlogHome->fillVariableIfActivated('BLOG_TAG_CLOUD', $strTagCloudSource, $page_template, $blogHomeTagCloudInTemplate);
                                    $themesPages['index'] = $objBlogHome->fillVariableIfActivated('BLOG_TAG_CLOUD', $strTagCloudSource, $themesPages['index'], $blogHomeTagCloudInTheme);
                                    $themesPages['sidebar'] = $objBlogHome->fillVariableIfActivated('BLOG_TAG_CLOUD', $strTagCloudSource, $themesPages['sidebar'], $blogHomeTagCloudInSidebar);
                                }
                                //Blog-TagHitlist
                                $blogHomeTagHitlistInContent = $objBlogHome->searchKeywordInContent('BLOG_TAG_HITLIST', \Env::get('cx')->getPage()->getContent());
                                $blogHomeTagHitlistInTemplate = $objBlogHome->searchKeywordInContent('BLOG_TAG_HITLIST', $page_template);
                                $blogHomeTagHitlistInTheme = $objBlogHome->searchKeywordInContent('BLOG_TAG_HITLIST', $themesPages['index']);
                                $blogHomeTagHitlistInSidebar = $objBlogHome->searchKeywordInContent('BLOG_TAG_HITLIST', $themesPages['sidebar']);
                                if ($blogHomeTagHitlistInContent || $blogHomeTagHitlistInTemplate || $blogHomeTagHitlistInTheme || $blogHomeTagHitlistInSidebar) {
                                    $strTagHitlistSource = $objBlogHome->getHomeTagHitlist();
                                    \Env::get('cx')->getPage()->setContent($objBlogHome->fillVariableIfActivated('BLOG_TAG_HITLIST', $strTagHitlistSource, \Env::get('cx')->getPage()->getContent(), $blogHomeTagHitlistInContent));
                                    $page_template = $objBlogHome->fillVariableIfActivated('BLOG_TAG_HITLIST', $strTagHitlistSource, $page_template, $blogHomeTagHitlistInTemplate);
                                    $themesPages['index'] = $objBlogHome->fillVariableIfActivated('BLOG_TAG_HITLIST', $strTagHitlistSource, $themesPages['index'], $blogHomeTagHitlistInTheme);
                                    $themesPages['sidebar'] = $objBlogHome->fillVariableIfActivated('BLOG_TAG_HITLIST', $strTagHitlistSource, $themesPages['sidebar'], $blogHomeTagHitlistInSidebar);
                                }
                                //Blog-Categories (Select)
                                $blogHomeCategorySelectInContent = $objBlogHome->searchKeywordInContent('BLOG_CATEGORIES_SELECT', \Env::get('cx')->getPage()->getContent());
                                $blogHomeCategorySelectInTemplate = $objBlogHome->searchKeywordInContent('BLOG_CATEGORIES_SELECT', $page_template);
                                $blogHomeCategorySelectInTheme = $objBlogHome->searchKeywordInContent('BLOG_CATEGORIES_SELECT', $themesPages['index']);
                                $blogHomeCategorySelectInSidebar = $objBlogHome->searchKeywordInContent('BLOG_CATEGORIES_SELECT', $themesPages['sidebar']);
                                if ($blogHomeCategorySelectInContent || $blogHomeCategorySelectInTemplate || $blogHomeCategorySelectInTheme || $blogHomeCategorySelectInSidebar) {
                                    $strCategoriesSelect = $objBlogHome->getHomeCategoriesSelect();
                                    \Env::get('cx')->getPage()->setContent($objBlogHome->fillVariableIfActivated('BLOG_CATEGORIES_SELECT', $strCategoriesSelect, \Env::get('cx')->getPage()->getContent(), $blogHomeCategorySelectInContent));
                                    $page_template = $objBlogHome->fillVariableIfActivated('BLOG_CATEGORIES_SELECT', $strCategoriesSelect, $page_template, $blogHomeCategorySelectInTemplate);
                                    $themesPages['index'] = $objBlogHome->fillVariableIfActivated('BLOG_CATEGORIES_SELECT', $strCategoriesSelect, $themesPages['index'], $blogHomeCategorySelectInTheme);
                                    $themesPages['sidebar'] = $objBlogHome->fillVariableIfActivated('BLOG_CATEGORIES_SELECT', $strCategoriesSelect, $themesPages['sidebar'], $blogHomeCategorySelectInSidebar);
                                }
                                //Blog-Categories (List)
                                $blogHomeCategoryListInContent = $objBlogHome->searchKeywordInContent('BLOG_CATEGORIES_LIST', \Env::get('cx')->getPage()->getContent());
                                $blogHomeCategoryListInTemplate = $objBlogHome->searchKeywordInContent('BLOG_CATEGORIES_LIST', $page_template);
                                $blogHomeCategoryListInTheme = $objBlogHome->searchKeywordInContent('BLOG_CATEGORIES_LIST', $themesPages['index']);
                                $blogHomeCategoryListInSidebar = $objBlogHome->searchKeywordInContent('BLOG_CATEGORIES_LIST', $themesPages['sidebar']);
                                if ($blogHomeCategoryListInContent || $blogHomeCategoryListInTemplate || $blogHomeCategoryListInTheme || $blogHomeCategoryListInSidebar) {
                                    $strCategoriesList = $objBlogHome->getHomeCategoriesList();
                                    \Env::get('cx')->getPage()->setContent($objBlogHome->fillVariableIfActivated('BLOG_CATEGORIES_LIST', $strCategoriesList, \Env::get('cx')->getPage()->getContent(), $blogHomeCategoryListInContent));
                                    $page_template = $objBlogHome->fillVariableIfActivated('BLOG_CATEGORIES_LIST', $strCategoriesList, $page_template, $blogHomeCategoryListInTemplate);
                                    $themesPages['index'] = $objBlogHome->fillVariableIfActivated('BLOG_CATEGORIES_LIST', $strCategoriesList, $themesPages['index'], $blogHomeCategoryListInTheme);
                                    $themesPages['sidebar'] = $objBlogHome->fillVariableIfActivated('BLOG_CATEGORIES_LIST', $strCategoriesList, $themesPages['sidebar'], $blogHomeCategoryListInSidebar);
                                }
                            }
                        }
                    },
                    'MediaDir' => function() {
                        global $cl, $objMadiadirPlaceholders, $page_template, $themesPages;

                        // Media directory: set placeholders I
                        /** @ignore */
                        if ($cl->loadFile(ASCMS_MODULE_PATH.'/mediadir/placeholders.class.php')) {
                            $objMadiadirPlaceholders = new \mediaDirectoryPlaceholders();
                            // Level/Category Navbar
                            if (preg_match('/{MEDIADIR_NAVBAR}/', \Env::get('cx')->getPage()->getContent())) {
                                \Env::get('cx')->getPage()->setContent(str_replace('{MEDIADIR_NAVBAR}', $objMadiadirPlaceholders->getNavigationPlacholder(), \Env::get('cx')->getPage()->getContent()));
                            }
                            if (preg_match('/{MEDIADIR_NAVBAR}/', $page_template)) {
                                $page_template = str_replace('{MEDIADIR_NAVBAR}', $objMadiadirPlaceholders->getNavigationPlacholder(), $page_template);
                            }
                            if (preg_match('/{MEDIADIR_NAVBAR}/', $themesPages['index'])) {
                                $themesPages['index'] = str_replace('{MEDIADIR_NAVBAR}', $objMadiadirPlaceholders->getNavigationPlacholder(), $themesPages['index']);
                            }
                            if (preg_match('/{MEDIADIR_NAVBAR}/', $themesPages['sidebar'])) {
                                $themesPages['sidebar'] = str_replace('{MEDIADIR_NAVBAR}', $objMadiadirPlaceholders->getNavigationPlacholder(), $themesPages['sidebar']);
                            }
                            // Latest Entries
                            if (preg_match('/{MEDIADIR_LATEST}/', \Env::get('cx')->getPage()->getContent())) {
                                \Env::get('cx')->getPage()->setContent(str_replace('{MEDIADIR_LATEST}', $objMadiadirPlaceholders->getLatestPlacholder(), \Env::get('cx')->getPage()->getContent()));
                            }
                            if (preg_match('/{MEDIADIR_LATEST}/', $page_template)) {
                                $page_template = str_replace('{MEDIADIR_LATEST}', $objMadiadirPlaceholders->getLatestPlacholder(), $page_template);
                            }
                            if (preg_match('/{MEDIADIR_LATEST}/', $themesPages['index'])) {
                                $themesPages['index'] = str_replace('{MEDIADIR_LATEST}', $objMadiadirPlaceholders->getLatestPlacholder(), $themesPages['index']);
                            }
                            if (preg_match('/{MEDIADIR_LATEST}/', $themesPages['sidebar'])) {
                                $themesPages['sidebar'] = str_replace('{MEDIADIR_LATEST}', $objMadiadirPlaceholders->getLatestPlacholder(), $themesPages['sidebar']);
                            }
                        }
                    },
                    'FwUser' => function() {
                        // ACCESS: parse access_logged_in[1-9] and access_logged_out[1-9] blocks
                        $content = \Env::get('cx')->getPage()->getContent();
                        \FWUser::parseLoggedInOutBlocks($content);
                        \Env::get('cx')->getPage()->setContent($content);
                    },
                ),
                'postContentLoad' => array(
                    'Shop' => function() {
                        // Show the Shop navbar in the Shop, or on every page if configured to do so
                        if (!\Shop::isInitialized()
                        // Optionally limit to the first instance
                        // && MODULE_INDEX == ''
                        ) {
                            \SettingDb::init('shop', 'config');
                            if (\SettingDb::getValue('shopnavbar_on_all_pages')) {
                                \Shop::init();
                                \Shop::setNavbar();
                            }
                        }
                    },
                    'Directory' => function() {
                        global $directoryCheck, $objTemplate, $cl, $objDirectory, $_CORELANG;

                        // Directory Show Latest
                        //$directoryCheck = $objTemplate->blockExists('directoryLatest_row_1');
                        $directoryCheck = array();
                        for ($i = 1; $i <= 10; $i++) {
                            if ($objTemplate->blockExists('directoryLatest_row_'.$i)) {
                                array_push($directoryCheck, $i);
                            }
                        }
                        if (   !empty($directoryCheck)
                            /** @ignore */
                            && $cl->loadFile(ASCMS_MODULE_PATH.'/directory/index.class.php')) {
                            $objDirectory = new \rssDirectory('');
                            if (!empty($directoryCheck)) {
                                $objTemplate->setVariable('TXT_DIRECTORY_LATEST', $_CORELANG['TXT_DIRECTORY_LATEST']);
                                $objDirectory->getBlockLatest($directoryCheck);
                            }
                        }
                    },
                    'Market' => function() {
                        global $marketCheck, $objTemplate, $cl, $objMarket, $_CORELANG;

                        // Market Show Latest
                        $marketCheck = $objTemplate->blockExists('marketLatest');
                        if (   $marketCheck
                            /** @ignore */
                            && $cl->loadFile(ASCMS_MODULE_PATH.'/market/index.class.php')) {
                            $objMarket = new \Market('');
                            $objTemplate->setVariable('TXT_MARKET_LATEST', $_CORELANG['TXT_MARKET_LATEST']);
                            $objMarket->getBlockLatest();
                        }
                    },
                    'Banner' => function() {
                        global $objBanner, $_CONFIG, $cl, $objTemplate, $page;

                        // Set banner variables
                        $objBanner = null;
                        if (   $_CONFIG['bannerStatus']
                            /** @ignore */
                            && $cl->loadFile(ASCMS_CORE_MODULE_PATH.'/banner/index.class.php')) {
                            $objBanner = new \Banner();
                            $objTemplate->setVariable(array(
                                'BANNER_GROUP_1' => $objBanner->getBannerCode(1, $page->getNode()->getId()),
                                'BANNER_GROUP_2' => $objBanner->getBannerCode(2, $page->getNode()->getId()),
                                'BANNER_GROUP_3' => $objBanner->getBannerCode(3, $page->getNode()->getId()),
                                'BANNER_GROUP_4' => $objBanner->getBannerCode(4, $page->getNode()->getId()),
                                'BANNER_GROUP_5' => $objBanner->getBannerCode(5, $page->getNode()->getId()),
                                'BANNER_GROUP_6' => $objBanner->getBannerCode(6, $page->getNode()->getId()),
                                'BANNER_GROUP_7' => $objBanner->getBannerCode(7, $page->getNode()->getId()),
                                'BANNER_GROUP_8' => $objBanner->getBannerCode(8, $page->getNode()->getId()),
                                'BANNER_GROUP_9' => $objBanner->getBannerCode(9, $page->getNode()->getId()),
                                'BANNER_GROUP_10' => $objBanner->getBannerCode(10, $page->getNode()->getId()),
                            ));
                            if (isset($_REQUEST['bannerId'])) {
                                $objBanner->updateClicks(intval($_REQUEST['bannerId']));
                            }
                        }
                    },
                    'MediaDir' => function() {
                        global $mediadirCheck, $objTemplate, $cl, $_CORELANG;

                        // Media directory: Set placeholders II (latest / headline)
                        $mediadirCheck = array();
                        for ($i = 1; $i <= 10; ++$i) {
                            if ($objTemplate->blockExists('mediadirLatest_row_'.$i)){
                                array_push($mediadirCheck, $i);
                            }
                        }
                        if (   $mediadirCheck
                            /** @ignore */
                            && $cl->loadFile(ASCMS_MODULE_PATH.'/mediadir/index.class.php')) {
                            $objMediadir = new \mediaDirectory('');
                            $objTemplate->setVariable('TXT_MEDIADIR_LATEST', $_CORELANG['TXT_DIRECTORY_LATEST']);
                            $objMediadir->getHeadlines($mediadirCheck);
                        }
                    },
                    'FwUser' => function() {
                        global $objTemplate, $cl;

                        // ACCESS: parse access_logged_in[1-9] and access_logged_out[1-9] blocks
                        \FWUser::parseLoggedInOutBlocks($objTemplate);

                        // currently online users
                        $objAccessBlocks = false;
                        if ($objTemplate->blockExists('access_currently_online_member_list')) {
                            if (    \FWUser::showCurrentlyOnlineUsers()
                                && (    $objTemplate->blockExists('access_currently_online_female_members')
                                    ||  $objTemplate->blockExists('access_currently_online_male_members')
                                    ||  $objTemplate->blockExists('access_currently_online_members'))) {
                                if ($cl->loadFile(ASCMS_CORE_MODULE_PATH.'/access/lib/blocks.class.php'))
                                    $objAccessBlocks = new Access_Blocks();
                                if ($objTemplate->blockExists('access_currently_online_female_members'))
                                    $objAccessBlocks->setCurrentlyOnlineUsers('female');
                                if ($objTemplate->blockExists('access_currently_online_male_members'))
                                    $objAccessBlocks->setCurrentlyOnlineUsers('male');
                                if ($objTemplate->blockExists('access_currently_online_members'))
                                    $objAccessBlocks->setCurrentlyOnlineUsers();
                            } else {
                                $objTemplate->hideBlock('access_currently_online_member_list');
                            }
                        }

                        // last active users
                        if ($objTemplate->blockExists('access_last_active_member_list')) {
                            if (    \FWUser::showLastActivUsers()
                                && (    $objTemplate->blockExists('access_last_active_female_members')
                                    ||  $objTemplate->blockExists('access_last_active_male_members')
                                    ||  $objTemplate->blockExists('access_last_active_members'))) {
                                if (   !$objAccessBlocks
                                    && $cl->loadFile(ASCMS_CORE_MODULE_PATH.'/access/lib/blocks.class.php'))
                                    $objAccessBlocks = new Access_Blocks();
                                if ($objTemplate->blockExists('access_last_active_female_members'))
                                    $objAccessBlocks->setLastActiveUsers('female');
                                if ($objTemplate->blockExists('access_last_active_male_members'))
                                    $objAccessBlocks->setLastActiveUsers('male');
                                if ($objTemplate->blockExists('access_last_active_members'))
                                    $objAccessBlocks->setLastActiveUsers();
                            } else {
                                $objTemplate->hideBlock('access_last_active_member_list');
                            }
                        }

                        // latest registered users
                        if ($objTemplate->blockExists('access_latest_registered_member_list')) {
                            if (    \FWUser::showLatestRegisteredUsers()
                                && (    $objTemplate->blockExists('access_latest_registered_female_members')
                                    ||  $objTemplate->blockExists('access_latest_registered_male_members')
                                    ||  $objTemplate->blockExists('access_latest_registered_members'))) {
                                if (   !$objAccessBlocks
                                    && $cl->loadFile(ASCMS_CORE_MODULE_PATH.'/access/lib/blocks.class.php'))
                                    $objAccessBlocks = new \Access_Blocks();
                                if ($objTemplate->blockExists('access_latest_registered_female_members'))
                                    $objAccessBlocks->setLatestRegisteredUsers('female');
                                if ($objTemplate->blockExists('access_latest_registered_male_members'))
                                    $objAccessBlocks->setLatestRegisteredUsers('male');
                                if ($objTemplate->blockExists('access_latest_registered_members'))
                                    $objAccessBlocks->setLatestRegisteredUsers();
                            } else {
                                $objTemplate->hideBlock('access_latest_registered_member_list');
                            }
                        }

                        // birthday users
                        if ($objTemplate->blockExists('access_birthday_member_list')) {
                            if (    \FWUser::showBirthdayUsers()
                                && (    $objTemplate->blockExists('access_birthday_female_members')
                                    ||  $objTemplate->blockExists('access_birthday_male_members')
                                    ||  $objTemplate->blockExists('access_birthday_members'))) {
                                if (   !$objAccessBlocks
                                    && $cl->loadFile(ASCMS_CORE_MODULE_PATH.'/access/lib/blocks.class.php'))
                                    $objAccessBlocks = new Access_Blocks();
                                if ($objAccessBlocks->isSomeonesBirthdayToday()) {
                                    if ($objTemplate->blockExists('access_birthday_female_members'))
                                        $objAccessBlocks->setBirthdayUsers('female');
                                    if ($objTemplate->blockExists('access_birthday_male_members'))
                                        $objAccessBlocks->setBirthdayUsers('male');
                                    if ($objTemplate->blockExists('access_birthday_members'))
                                        $objAccessBlocks->setBirthdayUsers();
                                    $objTemplate->touchBlock('access_birthday_member_list');
                                } else {
                                    $objTemplate->hideBlock('access_birthday_member_list');
                                }
                            } else {
                                $objTemplate->hideBlock('access_birthday_member_list');
                            }
                        }
                    },
                    /*'FrontendEditing' => function() {
                        $frontendEditing = new \Cx\Core_Modules\FrontendEditing\Controller\ComponentController();
                        $frontendEditing->preFinalize();
                    },*/
                ),
                'load' => array(
                    'imprint' => function() {},
                    'agb' => function() {},
                    'ids' => function() {},
                    'privacy' => function() {},

                    'access' => function() {
                        global $cl, $_CORELANG, $objTemplate, $objAccess, $page_metatitle;

                        if (!$cl->loadFile(ASCMS_CORE_MODULE_PATH.'/access/index.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $objAccess = new \Access(\Env::get('cx')->getPage()->getContent());
                        $pageTitle = \Env::get('cx')->getPage()->getTitle();
                        \Env::get('cx')->getPage()->setContent($objAccess->getPage($page_metatitle, $pageTitle));
                    },

                    'login' => function() {
                        global $cl, $_CORELANG, $objTemplate, $sessionObj;

                        /** @ignore */
                        if (!$cl->loadFile(ASCMS_CORE_MODULE_PATH.'/login/index.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        if (!isset($sessionObj) || !is_object($sessionObj)) $sessionObj = \cmsSession::getInstance();                        
                        $objLogin = new \Login(\Env::get('cx')->getPage()->getContent());
                        \Env::get('cx')->getPage()->setContent($objLogin->getContent());
                    },

                    'nettools' => function() {
                        global $cl, $_CORELANG, $objTemplate;

                        /** @ignore */
                        if (!$cl->loadFile(ASCMS_CORE_MODULE_PATH.'/nettools/index.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $objNetTools = new \NetTools(\Env::get('cx')->getPage()->getContent());
                        \Env::get('cx')->getPage()->setContent($objNetTools->getPage());
                    },

                    'shop' => function() {
                        global $cl, $_CORELANG;

                        /** @ignore */
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/shop/index.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        \Env::get('cx')->getPage()->setContent(\Shop::getPage(\Env::get('cx')->getPage()->getContent()));

                        // show product title if the user is on the product details page
                        if ($page_metatitle = \Shop::getPageTitle()) {
                            \Env::get('cx')->getPage()->setTitle($page_metatitle);
                            \Env::get('cx')->getPage()->setContentTitle($page_metatitle);
                            \Env::get('cx')->getPage()->setMetaTitle($page_metatitle);
                        }
                    },

                    'news' => function() {
                        global $cl, $_CORELANG, $page, $objTemplate, $page_metatitle;

                        /** @ignore */
                        if (!$cl->loadFile(ASCMS_CORE_MODULE_PATH.'/news/index.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $newsObj = new \news(\Env::get('cx')->getPage()->getContent());
                        \Env::get('cx')->getPage()->setContent($newsObj->getNewsPage());
                        $newsObj->getPageTitle(\Env::get('cx')->getPage()->getTitle());
                        // Set the meta page description to the teaser text if displaying news details
                        $teaser = $newsObj->getTeaser();
                        if ($teaser !== null) //news details, else getTeaser would return null
                            $page->setMetadesc(contrexx_raw2xhtml(contrexx_strip_tags(html_entity_decode($teaser, ENT_QUOTES, CONTREXX_CHARSET))));
                        \Env::get('cx')->getPage()->setTitle($newsObj->newsTitle);
                        \Env::get('cx')->getPage()->setContentTitle($newsObj->newsTitle);
                        \Env::get('cx')->getPage()->setMetaTitle($newsObj->newsTitle);
                        $page_metatitle = $newsObj->newsTitle;
                    },

                    'livecam' => function() {
                        global $cl, $_CORELANG, $objTemplate;

                        /** @ignore */
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/livecam/index.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $objLivecam = new \Livecam(\Env::get('cx')->getPage()->getContent());
                        \Env::get('cx')->getPage()->setContent($objLivecam->getPage());
                    },

                    'guestbook' => function() {
                        global $cl, $_CORELANG, $objTemplate;

                        /** @ignore */
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/guestbook/index.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $objGuestbook = new \Guestbook(\Env::get('cx')->getPage()->getContent());
                        \Env::get('cx')->getPage()->setContent($objGuestbook->getPage());
                    },

                    'memberdir' => function() {
                        global $cl, $_CORELANG, $objTemplate;

                        /** @ignore */
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/memberdir/index.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $objMemberDir = new \memberDir(\Env::get('cx')->getPage()->getContent());
                        \Env::get('cx')->getPage()->setContent($objMemberDir->getPage());
                    },

                    'data' => function() {
                        global $cl, $_CORELANG, $objTemplate;

                        /** @ignore */
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/data/index.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        #if (!isset($objAuth) || !is_object($objAuth)) $objAuth = &new Auth($type = 'frontend');

                        $objData = new \Data(\Env::get('cx')->getPage()->getContent());
                        \Env::get('cx')->getPage()->setContent($objData->getPage());
                    },

                    'download' => function() {
                        global $cl, $_CORELANG, $objTemplate;

                        /** @ignore */
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/download/index.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $objDownload = new \Download(\Env::get('cx')->getPage()->getContent());
                        \Env::get('cx')->getPage()->setContent($objDownload->getPage());
                    },

                    'recommend' => function() {
                        global $cl, $_CORELANG, $objTemplate;

                        /** @ignore */
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/recommend/index.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $objRecommend = new \Recommend(\Env::get('cx')->getPage()->getContent());
                        \Env::get('cx')->getPage()->setContent($objRecommend->getPage());
                    },

                    'ecard' => function() {
                        global $cl, $_CORELANG, $objTemplate;

                        /** @ignore */
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/ecard/index.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $objEcard = new \Ecard(\Env::get('cx')->getPage()->getContent());
                        \Env::get('cx')->getPage()->setContent($objEcard->getPage());
                    },

                    'tools' => function() {
                        global $cl, $_CORELANG, $objTemplate;

                        /** @ignore */
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/tools/index.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $objTools = new \Tools(\Env::get('cx')->getPage()->getContent());
                        \Env::get('cx')->getPage()->setContent($objTools->getPage());
                    },

                    'dataviewer' => function() {
                        global $cl, $_CORELANG, $objTemplate;

                        /** @ignore */
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/dataviewer/index.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $objDataviewer = new \Dataviewer(\Env::get('cx')->getPage()->getContent());
                        \Env::get('cx')->getPage()->setContent($objDataviewer->getPage());
                    },

                    'docsys' => function() {
                        global $cl, $_CORELANG, $objTemplate, $page_metatitle;

                        /** @ignore */
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/docsys/index.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $docSysObj= new \docSys(\Env::get('cx')->getPage()->getContent());
                        \Env::get('cx')->getPage()->setContent($docSysObj->getDocSysPage());
                        $docSysObj->getPageTitle(\Env::get('cx')->getPage()->getTitle());
                        \Env::get('cx')->getPage()->setTitle($docSysObj->docSysTitle);
                        \Env::get('cx')->getPage()->setContentTitle($docSysObj->docSysTitle);
                        \Env::get('cx')->getPage()->setMetaTitle($docSysObj->docSysTitle);
                        $page_metatitle = $docSysObj->docSysTitle;
                    },

                    'search' => function() {
                        global $cl, $_CORELANG, $objTemplate, $pos, $license;

                        /** @ignore */
                        if (!$cl->loadFile(ASCMS_CORE_MODULE_PATH.'/search/index.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $pos = (isset($_GET['pos'])) ? intval($_GET['pos']) : '';
                        \Env::get('cx')->getPage()->setContent(\Search::getPage($pos, \Env::get('cx')->getPage()->getContent(), $license));
                        unset($pos);
                    },

                    'contact' => function() {
                        global $cl, $_CORELANG, $objTemplate, $moduleStyleFile;

                        /** @ignore */
                        if (!$cl->loadFile(ASCMS_CORE_MODULE_PATH.'/contact/index.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $contactObj = new \Contact(\Env::get('cx')->getPage()->getContent());
                        \Env::get('cx')->getPage()->setContent($contactObj->getContactPage());
                        $moduleStyleFile = ASCMS_CORE_MODULE_WEB_PATH.'/contact/frontend_style.css';
                    },

                    'sitemap' => function() {
                        global $cl, $_CORELANG, $objTemplate;

                        /** @ignore */
                        if (!$cl->loadFile(ASCMS_CORE_MODULE_PATH.'/sitemap/index.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $sitemap = new \sitemap(\Env::get('cx')->getPage()->getContent(), \Env::get('cx')->getLicense());
                        \Env::get('cx')->getPage()->setContent($sitemap->getSitemapContent());
                    },

                    'media' => function() {
                        global $cl, $_CORELANG, $objTemplate, $plainSection;

                        /** @ignore */
                        if (!$cl->loadFile(ASCMS_CORE_MODULE_PATH.'/media/index.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $objMedia = new \MediaManager(\Env::get('cx')->getPage()->getContent(), $plainSection.MODULE_INDEX);
                        \Env::get('cx')->getPage()->setContent($objMedia->getMediaPage());
                    },

                    'newsletter' => function() {
                        global $cl, $_CORELANG, $objTemplate;

                        /** @ignore */
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/newsletter/index.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $newsletter = new \newsletter(\Env::get('cx')->getPage()->getContent());
                        \Env::get('cx')->getPage()->setContent($newsletter->getPage());
                    },

                    'gallery' => function() {
                        global $cl, $_CORELANG, $objTemplate, $page_metatitle;

                        /** @ignore */
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/gallery/index.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $objGallery = new \Gallery(\Env::get('cx')->getPage()->getContent());
                        \Env::get('cx')->getPage()->setContent($objGallery->getPage());

                        $topGalleryName = $objGallery->getTopGalleryName();
                        if ($topGalleryName) {
                            \Env::get('cx')->getPage()->setTitle($topGalleryName);
                            \Env::get('cx')->getPage()->setContentTitle($topGalleryName);
                            \Env::get('cx')->getPage()->setMetaTitle($topGalleryName);
                            $page_metatitle = $topGalleryName;
                        }
                    },

                    'voting' => function() {
                        global $cl, $_CORELANG, $objTemplate;

                        /** @ignore */
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/voting/index.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        \Env::get('cx')->getPage()->setContent(votingShowCurrent(\Env::get('cx')->getPage()->getContent()));
                    },

                    'feed' => function() {
                        global $cl, $_CORELANG, $objTemplate;

                        /** @ignore */
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/feed/index.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $objFeed = new \feed(\Env::get('cx')->getPage()->getContent());
                        \Env::get('cx')->getPage()->setContent($objFeed->getFeedPage());
                    },

                    'immo' => function() {
                        global $cl, $_CORELANG, $objTemplate, $page_metatitle;

                        /** @ignore */
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/immo/index.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $objImmo = new \Immo(\Env::get('cx')->getPage()->getContent());
                        \Env::get('cx')->getPage()->setContent($objImmo->getPage());
                        if (!empty($_GET['cmd']) && $_GET['cmd'] == 'showObj') {
                            \Env::get('cx')->getPage()->setTitle($objImmo->getPageTitle(\Env::get('cx')->getPage()->getTitle()));
                            \Env::get('cx')->getPage()->setContentTitle($objImmo->getPageTitle(\Env::get('cx')->getPage()->getTitle()));
                            \Env::get('cx')->getPage()->setMetaTitle($objImmo->getPageTitle(\Env::get('cx')->getPage()->getTitle()));
                            $page_metatitle = \Env::get('cx')->getPage()->getTitle();
                        }
                    },

                    'calendar' => function() {
                        global $cl, $_CORELANG, $objTemplate, $page_metatitle;

                        define('CALENDAR_MANDATE', MODULE_INDEX);
                        /** @ignore */
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/calendar'.MODULE_INDEX.'/index.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $objCalendar = new \Calendar(\Env::get('cx')->getPage()->getContent(), MODULE_INDEX);
                        \Env::get('cx')->getPage()->setContent($objCalendar->getCalendarPage());
                        if ($objCalendar->pageTitle) {
                            $page_metatitle = $objCalendar->pageTitle;
                            \Env::get('cx')->getPage()->setTitle($objCalendar->pageTitle);
                            \Env::get('cx')->getPage()->setContentTitle($objCalendar->pageTitle);
                            \Env::get('cx')->getPage()->setMetaTitle($objCalendar->pageTitle);
                        }
                    },

                    'directory' => function() {
                        global $cl, $_CORELANG, $objTemplate, $page_metatitle;

                        /** @ignore */
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/directory/index.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $directory = new \rssDirectory(\Env::get('cx')->getPage()->getContent());
                        \Env::get('cx')->getPage()->setContent($directory->getPage());
                        $directory_pagetitle = $directory->getPageTitle();
                        if (!empty($directory_pagetitle)) {
                            $page_metatitle = $directory_pagetitle;
                            \Env::get('cx')->getPage()->setTitle($directory_pagetitle);
                            \Env::get('cx')->getPage()->setContentTitle($directory_pagetitle);
                            \Env::get('cx')->getPage()->setMetaTitle($directory_pagetitle);
                        }
                        if ($_GET['cmd'] == 'detail' && isset($_GET['id'])) {
                            $objTemplate->setVariable(array(
                                'DIRECTORY_ENTRY_ID' => intval($_GET['id']),
                            ));
                        }
                    },

                    'market' => function() {
                        global $cl, $_CORELANG, $objTemplate;

                        /** @ignore */
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/market/index.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $market = new \Market(\Env::get('cx')->getPage()->getContent());
                        \Env::get('cx')->getPage()->setContent($market->getPage());
                    },

                    'podcast' => function() {
                        global $cl, $_CORELANG, $objTemplate;

                        /** @ignore */
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/podcast/index.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $objPodcast = new \podcast(\Env::get('cx')->getPage()->getContent());
                        \Env::get('cx')->getPage()->setContent($objPodcast->getPage($podcastFirstBlock));
                    },

                    'forum' => function() {
                        global $cl, $_CORELANG, $objTemplate;

                        /** @ignore */
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/forum/index.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $objForum = new \Forum(\Env::get('cx')->getPage()->getContent());
                        \Env::get('cx')->getPage()->setContent($objForum->getPage());
                    //        $moduleStyleFile = 'modules/forum/css/frontend_style.css';
                    },

                    'blog' => function() {
                        global $cl, $_CORELANG, $objTemplate;

                        /** @ignore */
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/blog/index.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $objBlog = new \Blog(\Env::get('cx')->getPage()->getContent());
                        \Env::get('cx')->getPage()->setContent($objBlog->getPage());
                    },

                    'knowledge' => function() {
                        global $cl, $_CORELANG, $objTemplate, $page_metatitle;

                        /** @ignore */
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/knowledge/index.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $objKnowledge = new \Knowledge(\Env::get('cx')->getPage()->getContent());
                        \Env::get('cx')->getPage()->setContent($objKnowledge->getPage());
                        if (!empty($objKnowledge->pageTitle)) {
                            \Env::get('cx')->getPage()->setTitle($objKnowledge->pageTitle);
                            \Env::get('cx')->getPage()->setContentTitle($objKnowledge->pageTitle);
                            \Env::get('cx')->getPage()->setMetaTitle($objKnowledge->pageTitle);
                            $page_metatitle = $objKnowledge->pageTitle;
                        }
                    },

                    'jobs' => function() {
                        global $cl, $_CORELANG, $objTemplate, $page_metatitle;

                        /** @ignore */
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/jobs/index.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $jobsObj= new \jobs(\Env::get('cx')->getPage()->getContent());
                        \Env::get('cx')->getPage()->setContent($jobsObj->getJobsPage());
                        $jobsObj->getPageTitle(\Env::get('cx')->getPage()->getTitle());
                        \Env::get('cx')->getPage()->setTitle($jobsObj->jobsTitle);
                        \Env::get('cx')->getPage()->setContentTitle($jobsObj->jobsTitle);
                        \Env::get('cx')->getPage()->setMetaTitle($jobsObj->jobsTitle);
                        $page_metatitle = $jobsObj->jobsTitle;
                    },

                    'error' => function() {
                        global $cl, $_CORELANG, $objTemplate;

                        /** @ignore */
                        if (!$cl->loadFile(ASCMS_CORE_PATH.'/error.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $errorObj = new \error(\Env::get('cx')->getPage()->getContent());
                        \Env::get('cx')->getPage()->setContent($errorObj->getErrorPage());
                    },

                    'egov' => function() {
                        global $cl, $_CORELANG, $objTemplate;

                        /** @ignore */
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/egov/index.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $objEgov = new \eGov(\Env::get('cx')->getPage()->getContent());
                        \Env::get('cx')->getPage()->setContent($objEgov->getPage());
                    },

                    'u2u' => function() {
                        global $cl, $_CORELANG, $objTemplate;

                        /** @ignore */
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/u2u/index.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $objU2u = new \u2u(\Env::get('cx')->getPage()->getContent());
                        \Env::get('cx')->getPage()->setContent($objU2u->getPage($page_metatitle, \Env::get('cx')->getPage()->getTitle()));
                    },

                    'downloads' => function() {
                        global $cl, $_CORELANG, $objTemplate, $page_metatitle;

                        /** @ignore */
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/downloads/index.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $objDownloadsModule = new \downloads(\Env::get('cx')->getPage()->getContent());
                        \Env::get('cx')->getPage()->setContent($objDownloadsModule->getPage());
                        $downloads_pagetitle = $objDownloadsModule->getPageTitle();
                        if ($downloads_pagetitle) {
                            $page_metatitle = $downloads_pagetitle;
                            \Env::get('cx')->getPage()->setTitle($downloads_pagetitle);
                            \Env::get('cx')->getPage()->setContentTitle($downloads_pagetitle);
                            \Env::get('cx')->getPage()->setMetaTitle($downloads_pagetitle);
                        }
                    },

                    'printshop' => function() {
                        global $cl, $_CORELANG, $objTemplate, $page_metatitle;

                        /** @ignore */
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/printshop/index.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $objPrintshopModule = new \Printshop(\Env::get('cx')->getPage()->getContent());
                        \Env::get('cx')->getPage()->setContent($objPrintshopModule->getPage());
                        $page_metatitle .= ' '.$objPrintshopModule->getPageTitle();
                        \Env::get('cx')->getPage()->setTitle('');
                        \Env::get('cx')->getPage()->setContentTitle('');
                        \Env::get('cx')->getPage()->setMetaTitle('');
                    },

                    'mediadir' => function() {
                        global $cl, $_CORELANG, $objTemplate, $page_metatitle;

                        /** @ignore */
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/mediadir/index.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $objMediaDirectory = new \mediaDirectory(\Env::get('cx')->getPage()->getContent());
                        $objMediaDirectory->pageTitle = \Env::get('cx')->getPage()->getTitle();
                        $objMediaDirectory->metaTitle = $page_metatitle;
                        \Env::get('cx')->getPage()->setContent($objMediaDirectory->getPage());
                        if ($objMediaDirectory->getPageTitle() != '') {
                            \Env::get('cx')->getPage()->setTitle($objMediaDirectory->getPageTitle());
                            \Env::get('cx')->getPage()->setContentTitle($objMediaDirectory->getPageTitle());
                            \Env::get('cx')->getPage()->setMetaTitle($objMediaDirectory->getPageTitle());
                        }
                        if ($objMediaDirectory->getMetaTitle() != '') {
                            $page_metatitle = $objMediaDirectory->getMetaTitle();
                        }
                    },

                    'checkout' => function() {
                        global $cl, $_CORELANG, $objTemplate;

                        /** @ignore */
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/checkout/index.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $objCheckout = new \Checkout(\Env::get('cx')->getPage()->getContent());
                        \Env::get('cx')->getPage()->setContent($objCheckout->getPage());
                    },

                    'filesharing' => function() {
                        global $cl, $_CORELANG, $objTemplate;

                        /** @ignore */
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/filesharing/index.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $objFileshare = new \Filesharing(\Env::get('cx')->getPage()->getContent());
                        \Env::get('cx')->getPage()->setContent($objFileshare->getPage());
                    },

                    'survey' => function() {
                        global $cl, $_CORELANG;

                        /** @ignore */
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/survey/index.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $objSurvey = new \survey(\Env::get('cx')->getPage()->getContent());
                        \Env::get('cx')->getPage()->setContent($objSurvey->getPage());
                    },

                    'home' => function() {
                    },
                ),
            ),
            'backend' => array(
                'preResolve' => array(
                    'Session' => function() {
                        global $sessionObj;

                        if (empty($sessionObj)) $sessionObj = \cmsSession::getInstance();
                        $_SESSION->cmsSessionStatusUpdate('backend');
                    },
                    'Js' => function() {
                        // Load the JS helper class and set the offset
                        \JS::setOffset('../');
                        \JS::activate('backend');
                        \JS::activate('cx');
                        \JS::activate('chosen');
                    },
                    'ComponentHandler' => function() {
                        global $arrMatch, $plainCmd, $cmd;

                        // To clone any module, use an optional integer cmd suffix.
                        // E.g.: "shop2", "gallery5", etc.
                        // Mind that you *MUST* copy all necessary database tables, and fix any
                        // references to that module (section and cmd parameters, database tables)
                        // using the MODULE_INDEX constant in the right place both in your code
                        // *and* templates!
                        // See the Shop module for a working example and instructions on how to
                        // clone any module.
                        $arrMatch = array();
                        if (!isset($plainCmd)) {
                            $plainCmd = $cmd;
                        }
                        if (preg_match('/^(\D+)(\d+)$/', $cmd, $arrMatch)) {
                            // The plain section/module name, used below
                            $plainCmd = $arrMatch[1];
                        }
                        // The module index.
                        // Set to the empty string for the first instance (#1),
                        // and to an integer number of 2 or greater for any clones.
                        // This guarantees full backward compatibility with old code, templates
                        // and database tables for the default instance.
                        $moduleIndex = (empty($arrMatch[2]) ? '' : $arrMatch[2]);

                        /**
                        * @ignore
                        */
                        define('MODULE_INDEX', (intval($moduleIndex) == 0) ? '' : intval($moduleIndex));
                        // Simple way to distinguish any number of cloned modules
                        // and apply individual access rights.  This offset is added
                        // to any static access ID before checking it.
                        // @todo this is never used in Cx Init
                        //$intAccessIdOffset = intval(MODULE_INDEX)*1000;
                    },
                    'License' => function() {
                        global $license, $_CONFIG, $objDatabase, $objTemplate;

                        $license = \Cx\Core_Modules\License\License::getCached($_CONFIG, $objDatabase);

                        if ($objTemplate->blockExists('upgradable')) {
                            if ($license->isUpgradable()) {
                                $objTemplate->touchBlock('upgradable');
                            } else {
                                $objTemplate->hideBlock('upgradable');
                            }
                        }
                    },
                ),
                'postResolve' => array(
                    'License' => function() {
                        global $plainCmd, $objDatabase, $loggedIn, $_CONFIG, $_CORELANG, $license;

                        // check if the requested module is active:
                        if (!in_array($plainCmd, array('login', 'license', 'noaccess', ''))) {
                            $query = '
                                SELECT
                                    modules.is_licensed
                                FROM
                                    '.DBPREFIX.'modules AS modules,
                                    '.DBPREFIX.'backend_areas AS areas
                                WHERE
                                    areas.module_id = modules.id
                                    AND (
                                        areas.uri LIKE "%cmd=' . contrexx_raw2db($plainCmd) . '&%"
                                        OR areas.uri LIKE "%cmd=' . contrexx_raw2db($plainCmd) . '"
                                    )
                            ';
                            $res = $objDatabase->Execute($query);
                            if (!$res->fields['is_licensed']) {
                                $plainCmd = 'license';
                            }
                        }

                        // If logged in
                        if (\Env::get('cx')->getUser()->objUser->login(true)) {
                            $license->check();
                            if ($license->getState() == \Cx\Core_Modules\License\License::LICENSE_NOK) {
                                $plainCmd = 'license';
                                $license->save(new \settingsManager(), $objDatabase);
                            }
                            $lc = \Cx\Core_Modules\License\LicenseCommunicator::getInstance($_CONFIG);
                            $lc->addJsUpdateCode($_CORELANG, $license, $plainCmd == 'license');
                        }
                    },
                    'Language' => function() {
                        global $objInit, $_LANGID, $_FRONTEND_LANGID, $_CORELANG, $_ARRAYLANG, $plainCmd;

                        $objInit->_initBackendLanguage();
                        $objInit->getUserFrontendLangId();

                        $_LANGID = $objInit->getBackendLangId();
                        $_FRONTEND_LANGID = $objInit->userFrontendLangId;
                        /**
                        * Language constants
                        *
                        * Defined as follows:
                        * - BACKEND_LANG_ID is set to the visible backend language
                        *   in the backend *only*.  In the frontend, it is *NOT* defined!
                        *   It indicates a backend user and her currently selected language.
                        *   Use this in methods that are intended *for backend use only*.
                        *   It *MUST NOT* be used to determine the language for any kind of content!
                        * - FRONTEND_LANG_ID is set to the selected frontend or content language
                        *   both in the back- and frontend.
                        *   It *always* represents the language of content being viewed or edited.
                        *   Use FRONTEND_LANG_ID for that purpose *only*!
                        * - LANG_ID is set to the same value as BACKEND_LANG_ID in the backend,
                        *   and to the same value as FRONTEND_LANG_ID in the frontend.
                        *   It *always* represents the current users' selected language.
                        *   It *MUST NOT* be used to determine the language for any kind of content!
                        * @since 2.2.0
                        */
                        define('FRONTEND_LANG_ID', $_FRONTEND_LANGID);
                        define('BACKEND_LANG_ID', $_LANGID);
                        define('LANG_ID', $_LANGID);

                        /**
                        * Core language data
                        * @ignore
                        */
                        // Corelang might be initialized by CSRF already...
                        if (!is_array($_CORELANG) || !count($_CORELANG)) {
                            $_CORELANG = $objInit->loadLanguageData('core');
                        }

                        /**
                        * Module specific language data
                        * @ignore
                        */
                        $_ARRAYLANG = $objInit->loadLanguageData($plainCmd);
                        $_ARRAYLANG = array_merge($_ARRAYLANG, $_CORELANG);
                        \Env::set('lang', $_ARRAYLANG);
                    },
                    'FwUser' => function() {
                        global $objFWUser, $plainCmd, $isRegularPageRequest,
                                $objUser, $firstname, $lastname, $objTemplate;

                        $objFWUser = \FWUser::getFWUserObject();

                        /* authentification */
                        $loggedIn = $objFWUser->objUser->login(true); //check if the user is already logged in
                        if (!empty($_POST) && !$loggedIn &&
                                (
                                    (!isset($_GET['cmd']) || $_GET['cmd'] !== 'login') &&
                                    (!isset($_GET['act']) || $_GET['act'] !== 'resetpw')
                                )) { //not logged in already - do captcha and password checks
                            $objFWUser->checkAuth();
                        }

                        // User only gets the backend if he's logged in
                        if (!$objFWUser->objUser->login(true)) {
                            $plainCmd = 'login';
                            // If the user isn't logged in, the login mask will be showed.
                            // This mask has its own template handling.
                            // So we don't need to load any templates in the index.php.
                            $isRegularPageRequest = false;
                        } else {
                            $userData = array(
                                'id'   => \FWUser::getFWUserObject()->objUser->getId(),
                                'name' => \FWUser::getFWUserObject()->objUser->getUsername(),
                            );
                            \Env::get('cx')->getDb()->setUsername(json_encode($userData));
                        }

                        $objUser = \FWUser::getFWUserObject()->objUser;
                        $firstname = $objUser->getProfileAttribute('firstname');
                        $lastname = $objUser->getProfileAttribute('lastname');

                        if (!empty($firstname) && !empty($lastname)) {
                            $txtProfile = $firstname.' '.$lastname;
                        } else {
                            $txtProfile = $objUser->getUsername();
                        }

                        $objTemplate->setVariable(array(
                            'TXT_PROFILE'               => $txtProfile,
                            'USER_ID'                   => $objFWUser->objUser->getId(),
                        ));


                        if (isset($_POST['redirect']) && preg_match('/\.php/', $_POST['redirect'])) {
                            $redirect = \FWUser::getRedirectUrl(urlencode($_POST['redirect']));
                            \CSRF::header('location: '.$redirect);
                        }
                    },
                    'Csrf' => function() {
                        global $plainCmd, $cmd, $objInit, $_CORELANG;

                        // CSRF code needs to be even in the login form. otherwise, we
                        // could not do a super-generic check later.. NOTE: do NOT move
                        // this above the "new cmsSession" line!
                        \CSRF::add_code();

                        // CSRF protection.
                        // Note that we only do the check as long as there's no
                        // cmd given; this is so we can reload the main screen if
                        // the check has failed somehow.
                        // fileBrowser is an exception, as it eats CSRF codes like
                        // candy. We're doing CSRF::check_code() in the relevant
                        // parts in the module instead.
                        // The CSRF code needn't to be checked in the login module
                        // because the user isn't logged in at this point.
                        // TODO: Why is upload excluded? The CSRF check doesn't take place in the upload module!
                        if (!empty($plainCmd) && !empty($cmd) and !in_array($plainCmd, array('fileBrowser', 'upload', 'login'))) {
                            // Since language initialization in in the same hook as this
                            // and we cannot define the order of module-processing,
                            // we need to check if language is already initialized:
                            if (!is_array($_CORELANG) || !count($_CORELANG)) {
                                $objInit->_initBackendLanguage();
                                $_CORELANG = $objInit->loadLanguageData('core');
                            }
                            \CSRF::check_code();
                        }
                    },
                ),
                'load' => array(
                    'login' => function() {
                        global $cl, $_CORELANG, $objFWUser;

                        if ($objFWUser->objUser->login(true)) {
                            header('location: index.php');
                            exit;
                        }
                        if (!$cl->loadFile(ASCMS_CORE_MODULE_PATH.'/login/admin.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $objLoginManager = new \LoginManager();
                        $objLoginManager->getPage();
                    },
                    'access' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        if (!$cl->loadFile(ASCMS_CORE_MODULE_PATH."/access/admin.class.php"))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_COMMUNITY'];
                        $objAccessManager = new \AccessManager();
                        $objAccessManager->getPage();
                    },
                    'egov' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        \Permission::checkAccess(109, 'static');
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/egov/admin.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_EGOVERNMENT'];
                        $objEgov = new \eGov();
                        $objEgov->getPage();
                    },
                    'banner' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        \Permission::checkAccess(62, 'static');
                        if (!$cl->loadFile(ASCMS_CORE_MODULE_PATH.'/banner/admin.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_BANNER_ADMINISTRATION'];
                        $objBanner = new \Banner();
                        $objBanner->getPage();
                    },
                    'jobs' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        \Permission::checkAccess(148, 'static');
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/jobs/admin.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_JOBS_MANAGER'];
                        $objJobs = new \jobsManager();
                        $objJobs->getJobsPage();
                    },
                    'fileBrowser' => function() {
                        global $cl, $_CORELANG;

                        if (!$cl->loadFile(ASCMS_CORE_MODULE_PATH.'/fileBrowser/admin.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $objFileBrowser = new \FileBrowser();
                        $objFileBrowser->getPage();
                        exit;
                    },
                    'feed' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        \Permission::checkAccess(27, 'static');
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/feed/admin.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_NEWS_SYNDICATION'];
                        $objFeed = new \feedManager();
                        $objFeed->getFeedPage();
                    },
                    'server' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        \Permission::checkAccess(24, 'static');
                        if (!$cl->loadFile(ASCMS_CORE_PATH.'/serverSettings.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_SERVER_INFO'];
                        $objServer = new \serverSettings();
                        $objServer->getPage();
                    },
                    'shop' => function() {
                        global $cl, $_CORELANG, $subMenuTitle, $intAccessIdOffset;

                        \Permission::checkAccess($intAccessIdOffset+13, 'static');
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/shop/admin.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_SHOP_ADMINISTRATION'];
                        $objShopManager = new \shopmanager();
                        $objShopManager->getPage();
                    },
                    'log' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        \Permission::checkAccess(55, 'static');
                        if (!$cl->loadFile(ASCMS_CORE_PATH.'/log.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_SYSTEM_LOGS'];
                        $objLogManager = new \logmanager();
                        $objLogManager->getLogPage();
                    },
                    'skins' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        \Permission::checkAccess(21, 'static');
                        if (!$cl->loadFile(ASCMS_CORE_PATH.'/skins.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_DESIGN_MANAGEMENT'];
                        $objSkins = new \skins();
                        $objSkins->getPage();
                    },
                    'content' => function() {
                        global $objTemplate, $objDatabase, $objInit, $act;

                        \Permission::checkAccess(6, 'static');
                        $cm = new \Cx\Core\ContentManager\Controller\ContentManager($act, $objTemplate, $objDatabase, $objInit);
                        $cm->getPage();
                    },
                    'license' => function() {
                        global $_CORELANG, $objTemplate, $objDatabase, $_CONFIG, $act;

                        \Permission::checkAccess(177, 'static');
                        $lm = new \Cx\Core_Modules\License\LicenseManager($act, $objTemplate, $_CORELANG, $_CONFIG, $objDatabase);
                        $lm->getPage($_POST, $_CORELANG);
                    },
                // TODO: handle expired sessions in any xhr callers.
                    'jsondata' => function() {
                        $json = new \Cx\Core\Json\JsonData();
                // TODO: Verify that the arguments are actually present!
                        $adapter = contrexx_input2raw($_GET['object']);
                        $method = contrexx_input2raw($_GET['act']);
                // TODO: Replace arguments by something reasonable
                        $arguments = array('get' => $_GET, 'post' => $_POST);
                        echo $json->jsondata($adapter, $method, $arguments);
                        die();
                    },
                    'workflow' => function() {
                        global $cl, $_CORELANG, $subMenuTitle, $objTemplate, $objDatabase, $objInit, $act;

                        if (!$cl->loadFile(ASCMS_CORE_PATH.'/ContentWorkflow.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_CONTENT_HISTORY'];
                        $wf = new \ContentWorkflow($act, $objTemplate, $objDatabase, $objInit);
                        $wf->getPage();
                    },
                    'docsys' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        \Permission::checkAccess(11, 'static');
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/docsys/admin.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_DOC_SYS_MANAGER'];
                        $objDocSys = new \docSysManager();
                        $objDocSys->getDocSysPage();
                    },
                    'news' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        \Permission::checkAccess(10, 'static');
                        if (!$cl->loadFile(ASCMS_CORE_MODULE_PATH.'/news/admin.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_NEWS_MANAGER'];
                        $objNews = new \NewsManager();
                        $objNews->getPage();
                    },
                    'contact' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        \Permission::checkAccess(84, 'static');
                        if (!$cl->loadFile(ASCMS_CORE_MODULE_PATH.'/contact/admin.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_CONTACTS'];
                        $objContact = new \contactManager();
                        $objContact->getPage();
                    },
                    'immo' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        \Permission::checkAccess(88, 'static');
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/immo/admin.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_IMMO_MANAGEMENT'];
                        $objImmo = new \Immo();
                        $objImmo->getPage();
                    },
                    'livecam' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        \Permission::checkAccess(82, 'static');
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/livecam/admin.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_LIVECAM'];
                        $objLivecam = new \LivecamManager();
                        $objLivecam->getPage();
                    },
                    'guestbook' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        \Permission::checkAccess(9, 'static');
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/guestbook/admin.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_GUESTBOOK'];
                        $objGuestbook = new \GuestbookManager();
                        $objGuestbook->getPage();
                    },
                    'memberdir' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        \Permission::checkAccess(83, 'static');
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/memberdir/admin.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_MEMBERDIR'];
                        $objMemberdir = new \MemberDirManager();
                        $objMemberdir->getPage();
                    },
                    'media' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        if (!$cl->loadFile(ASCMS_CORE_MODULE_PATH.'/media/admin.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_MEDIA_MANAGER'];
                        $objMedia = new \MediaManager();
                        $objMedia->getMediaPage();
                    },
                    'development' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        \Permission::checkAccess(81, 'static');
                        if (!$cl->loadFile(ASCMS_CORE_MODULE_PATH.'/development/admin.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_DEVELOPMENT'];
                        $objDevelopment = new \Development();
                        $objDevelopment->getPage();
                    },
                    'dbm' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        \Permission::checkAccess(20, 'static');
                        if (!$cl->loadFile(ASCMS_CORE_PATH.'/DatabaseManager.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_DATABASE_MANAGER'];
                        $objDatabaseManager = new \DatabaseManager();
                        $objDatabaseManager->getPage();
                    },
                    'stats' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        \Permission::checkAccess(163, 'static');
                        if (!$cl->loadFile(ASCMS_CORE_MODULE_PATH.'/stats/admin.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_STATISTIC'];
                        $statistic= new \stats();
                        $statistic->getContent();
                    },
                    'alias' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        \Permission::checkAccess(115, 'static');
                        if (!$cl->loadFile(ASCMS_CORE_MODULE_PATH.'/alias/admin.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_ALIAS_ADMINISTRATION'];
                        $objAlias = new \AliasAdmin();
                        $objAlias->getPage();
                    },
                    'nettools' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        if (!$cl->loadFile(ASCMS_CORE_MODULE_PATH.'/nettools/admin.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_NETWORK_TOOLS'];
                        $nettools = new \netToolsManager();
                        $nettools->getContent();
                    },
                    'newsletter' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/newsletter/admin.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_CORE_EMAIL_MARKETING'];
                        $objNewsletter = new \newsletter();
                        $objNewsletter->getPage();
                    },
                    'settings' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        \Permission::checkAccess(17, 'static');
                        if (!$cl->loadFile(ASCMS_CORE_PATH.'/settings.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_SYSTEM_SETTINGS'];
                        $objSettings = new \settingsManager();
                        $objSettings->getPage();
                    },
                    'language' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        \Permission::checkAccess(22, 'static');
                        if (!$cl->loadFile(ASCMS_CORE_PATH.'/language.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_LANGUAGE_SETTINGS'];
                        $objLangManager = new \LanguageManager();
                        $objLangManager->getLanguagePage();
                    },
                    'modulemanager' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        \Permission::checkAccess(23, 'static');
                        if (!$cl->loadFile(ASCMS_CORE_PATH.'/modulemanager.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_MODULE_MANAGER'];
                        $objModuleManager = new \modulemanager();
                        $objModuleManager->getModulesPage();
                    },
                    'ecard' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/ecard/admin.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_ECARD_TITLE'];
                        $objEcard = new \ecard();
                        $objEcard->getPage();
                    },
                    'voting' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        \Permission::checkAccess(14, 'static');
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/voting/admin.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_CONTENT_MANAGER'];
                        $objvoting = new \votingmanager();
                        $objvoting->getVotingPage();
                    },
                    'survey' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        \Permission::checkAccess(111, 'static');
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/survey/admin.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_SURVEY'];
                        $objSurvey = new \survey();
                        $objSurvey->getPage();
                    },
                    'calendar' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        \Permission::checkAccess(16, 'static');
                        define('CALENDAR_MANDATE', MODULE_INDEX);
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/calendar'.MODULE_INDEX.'/admin.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_CALENDAR'];
                        $objCalendar = new \calendarManager();
                        $objCalendar->getCalendarPage();
                    },
                    'recommend' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        \Permission::checkAccess(64, 'static');
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/recommend/admin.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_RECOMMEND'];
                        $objCalendar = new \RecommendManager();
                        $objCalendar->getPage();
                    },
                    'forum' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        \Permission::checkAccess(106, 'static');
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/forum/admin.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_FORUM'];
                        $objForum = new \ForumAdmin();
                        $objForum->getPage();
                    },
                    'gallery' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        \Permission::checkAccess(12, 'static');
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/gallery/admin.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_GALLERY_TITLE'];
                        $objGallery = new \galleryManager();
                        $objGallery->getPage();
                    },
                    'directory' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/directory/admin.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_LINKS_MODULE_DESCRIPTION'];
                        $objDirectory = new \rssDirectory();
                        $objDirectory->getPage();
                    },
                    'block' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        \Permission::checkAccess(76, 'static');
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/block/admin.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_BLOCK_SYSTEM'];
                        $objBlock = new \blockManager();
                        $objBlock->getPage();
                    },
                    'market' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        \Permission::checkAccess(98, 'static');
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/market/admin.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_CORE_MARKET_TITLE'];
                        $objMarket = new \Market();
                        $objMarket->getPage();
                    },
                    'data' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        \Permission::checkAccess(146, 'static'); // ID !!
                        if (!$cl->loadFile(ASCMS_MODULE_PATH."/data/admin.class.php"))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_DATA_MODULE'];
                        $objData = new \DataAdmin();
                        $objData->getPage();
                    },
                    'podcast' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        \Permission::checkAccess(87, 'static');
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/podcast/admin.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_PODCAST'];
                        $objPodcast = new \podcastManager();
                        $objPodcast->getPage();
                    },
                    'blog' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        \Permission::checkAccess(119, 'static');
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/blog/admin.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_BLOG_MODULE'];
                        $objBlog = new \BlogAdmin();
                        $objBlog->getPage();
                    },
                    'knowledge' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        \Permission::checkAccess(129, 'static');
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/knowledge/admin.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_KNOWLEDGE'];
                        $objKnowledge = new \KnowledgeAdmin();
                        $objKnowledge->getPage();
                    },
                    'u2u' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        \Permission::checkAccess(149, 'static');
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/u2u/admin.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_U2U_MODULE'];
                        $objU2u = new \u2uAdmin();
                        $objU2u->getPage();
                    },
                    'upload' => function() {
                        global $cl, $_CORELANG;

                        if (!$cl->loadFile(ASCMS_CORE_MODULE_PATH.'/upload/admin.class.php'))
                            die ($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $objUploadModule = new \Upload();
                        $objUploadModule->getPage();
                        //execution never reaches this point
                    },
                    'noaccess' => function() {
                        global $cl, $_CORELANG, $objTemplate, $_CONFIG;

                        //Temporary no-acces-file and comment
                        $subMenuTitle = $_CORELANG['TXT_ACCESS_DENIED'];
                        $objTemplate->setVariable(array(
                            'CONTENT_NAVIGATION' => '<span id="noaccess_title">'.contrexx_raw2xhtml($_CONFIG['coreCmsName']).'</span>',
                            'ADMIN_CONTENT' =>
                                '<img src="images/no_access.png" alt="" /><br /><br />'.
                                $_CORELANG['TXT_ACCESS_DENIED_DESCRIPTION'],
                        ));
                    },
                    'logout' => function() {
                        global $cl, $_CORELANG, $objFWUser;

                        $objFWUser->logout();
                        exit;
                    },
                    'downloads' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/downloads/admin.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_DOWNLOADS'];
                        $objDownloadsModule = new \downloads();
                        $objDownloadsModule->getPage();
                    },
                    'country' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                // TODO: Move this define() somewhere else, allocate the IDs properly
                        define('PERMISSION_COUNTRY_VIEW', 145);
                        define('PERMISSION_COUNTRY_EDIT', 146);
                        \Permission::checkAccess(PERMISSION_COUNTRY_VIEW, 'static');
                        if (!$cl->loadFile(ASCMS_CORE_PATH.'/Country.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_CORE_COUNTRY'];
                        \Country::getPage();
                    },
                    'mediadir' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        \Permission::checkAccess(153, 'static');
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/mediadir/admin.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_MEDIADIR_MODULE'];
                        $objMediaDirectory = new \mediaDirectoryManager();
                        $objMediaDirectory->getPage();
                    },
                    'search' => function() {
                        global $cl, $_CORELANG, $subMenuTitle, $objTemplate, $license, $act;

                        if (!$cl->loadFile(ASCMS_CORE_MODULE_PATH.'/search/admin.class.php')) {
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        }
                        $subMenuTitle = $_CORELANG['TXT_SEARCH'];
                        $objSearch    = new \Cx\Core\Search\SearchManager($act, $objTemplate, $license);
                        $objSearch->getPage();
                    },
                    'checkout' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        \Permission::checkAccess(161, 'static');
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/checkout/admin.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $subMenuTitle = $_CORELANG['TXT_CHECKOUT_MODULE'];
                        $objCheckoutManager = new \CheckoutManager();
                        $objCheckoutManager->getPage();
                    },
                    'crm' => function() {
                        global $cl, $_CORELANG, $subMenuTitle;

                        \Permission::checkAccess(556, 'static');
                        if (!$cl->loadFile(ASCMS_MODULE_PATH.'/crm/admin.class.php')) {
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        }
                        $subMenuTitle = $_CORELANG['TXT_CRM'];
                        $objCrmModule = new \CrmManager();
                        $objCrmModule->getPage();
                    },
                    '' => function() {
                        global $cl, $_CORELANG, $subMenuTitle, $objTemplate;

                        if (!$cl->loadFile(ASCMS_CORE_PATH.'/myAdmin.class.php'))
                            die($_CORELANG['TXT_THIS_MODULE_DOESNT_EXISTS']);
                        $objTemplate->setVariable('CONTAINER_DASHBOARD_CLASS', 'dashboard');
                        $objFWUser = \FWUser::getFWUserObject();
                        $subMenuTitle = $_CORELANG['TXT_WELCOME_MESSAGE'].", <a href='index.php?cmd=access&amp;act=user&amp;tpl=modify&amp;id=".$objFWUser->objUser->getId()."' title='".$objFWUser->objUser->getId()."'>".($objFWUser->objUser->getProfileAttribute('firstname') || $objFWUser->objUser->getProfileAttribute('lastname') ? htmlentities($objFWUser->objUser->getProfileAttribute('firstname'), ENT_QUOTES, CONTREXX_CHARSET).' '.htmlentities($objFWUser->objUser->getProfileAttribute('lastname'), ENT_QUOTES, CONTREXX_CHARSET) : htmlentities($objFWUser->objUser->getUsername(), ENT_QUOTES, CONTREXX_CHARSET))."</a>";
                        $objAdminNav = new \myAdminManager();
                        $objAdminNav->getPage();
                    },
                ),
                'postContentLoad' => array(
                    'Message' => function() {
                        global $objTemplate;

                        // TODO: This would better be handled by the Message class
                        if (!empty($objTemplate->_variables['CONTENT_STATUS_MESSAGE'])) {
                            $objTemplate->_variables['CONTENT_STATUS_MESSAGE'] =
                                '<div id="alertbox">'.
                                $objTemplate->_variables['CONTENT_STATUS_MESSAGE'].'</div>';
                        }
                        if (!empty($objTemplate->_variables['CONTENT_OK_MESSAGE'])) {
                            if (!isset($objTemplate->_variables['CONTENT_STATUS_MESSAGE'])) {
                                $objTemplate->_variables['CONTENT_STATUS_MESSAGE'] = '';
                            }
                            $objTemplate->_variables['CONTENT_STATUS_MESSAGE'] .=
                                '<div id="okbox">'.
                                $objTemplate->_variables['CONTENT_OK_MESSAGE'].'</div>';
                        }
                        if (!empty($objTemplate->_variables['CONTENT_WARNING_MESSAGE'])) {
                            $objTemplate->_variables['CONTENT_STATUS_MESSAGE'] .=
                                '<div class="warningbox">'.
                                $objTemplate->_variables['CONTENT_WARNING_MESSAGE'].'</div>';
                        }
                    },
                    'Csrf' => function() {
                        global $objTemplate;

                        \CSRF::add_placeholder($objTemplate);
                    },
                ),
                'preFinalize' => array(
                    'Csrf' => function() {
                        global $objTemplate;
                        //This is a ugly hack.
                        $objTemplate->_variables['ADMIN_CONTENT'] = preg_replace('/(&amp;)csrf=[a-zA-Z0-9__]+/i', '',
                            preg_replace('/\?csrf=[a-zA-Z0-9__]+/i', '',
                                preg_replace('/\?csrf=[a-zA-Z0-9__]+(&amp\;|&)/i', '?', $objTemplate->_variables['ADMIN_CONTENT'])));
                    },
                )
            ),
        );
    }
}
