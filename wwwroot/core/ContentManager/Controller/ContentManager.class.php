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
 * ContentManager
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  core_contentmanager
 */

namespace Cx\Core\ContentManager\Controller;
use Doctrine\Common\Util\Debug as DoctrineDebug;

/**
 * ContentManager
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  core_contentmanager
 */
class ContentManagerException extends \ModuleException
{

}

/**
 * ContentManager
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  core_contentmanager
 */
class ContentManager extends \Module
{

    //doctrine entity manager
    protected $em = null;
    //the mysql connection
    protected $db = null;
    //the init object
    protected $init = null;
    protected $pageRepository = null;
    protected $nodeRepository = null;
    //renderCM access state
    protected $backendGroups = array();
    protected $frontendGroups = array();
    protected $assignedBackendGroups = array();
    protected $assignedFrontendGroups = array();

    /**
     * @param string $act
     * @param        $template
     * @param        $db   the ADODB db object
     * @param        $init the Init object
     */
    public function __construct($act, $template, $db, $init)
    {
        parent::__construct($act, $template);

        if ($this->act == 'new') {
            $this->act = ''; //default action;
        }

        $this->em             = \Env::em();
        $this->db             = $db;
        $this->init           = $init;
        $this->pageRepository = $this->em->getRepository('Cx\Core\ContentManager\Model\Entity\Page');
        $this->nodeRepository = $this->em->getRepository('Cx\Core\ContentManager\Model\Entity\Node');
        $this->defaultAct     = 'actRenderCM';
    }

    protected function actRenderCM()
    {
        global $_ARRAYLANG, $_CORELANG, $_CONFIG;

        \JS::activate('jqueryui');
        \JS::activate('cx');
        \JS::activate('ckeditor');
        \JS::activate('cx-form');
        \JS::activate('jstree');
        \JS::registerJS('lib/javascript/lock.js');
        \JS::registerJS('lib/javascript/jquery/jquery.history.js');

// this can be used to debug the tree, just add &tree=verify or &tree=fix
        $tree = null;
        if (isset($_GET['tree'])) {
            $tree = contrexx_input2raw($_GET['tree']);
        }
        if ($tree == 'verify') {
            echo '<pre>';
            print_r($this->nodeRepository->verify());
            echo '</pre>';
        } else if ($tree == 'fix') {
            // this should print "bool(true)"
            var_dump($this->nodeRepository->recover());
        }
        $objCx    = \ContrexxJavascript::getInstance();
        
        $themeRepo = new \Cx\Core\View\Model\Repository\ThemeRepository();
        $defaultTheme = $themeRepo->getDefaultTheme();
        $objCx->setVariable('themeId', $defaultTheme->getId(), 'contentmanager/theme');
        foreach ($themeRepo->findAll() as $theme) {
            if ($theme == $defaultTheme) {
                $objCx->setVariable('themeName', $theme->getFoldername(), 'contentmanager/theme');
            }
        }

        $cachedRoot = $this->template->getRoot();
        $this->template->setRoot(ASCMS_CORE_PATH . '/ContentManager/View/Template');
        $this->template->addBlockfile('ADMIN_CONTENT', 'content_manager', 'Skeleton.html');

        // user has no permission to create new page, hide navigation item in admin navigation
        if (!\Permission::checkAccess(127, 'static', true)) {
            $this->template->hideBlock('content_manager_create_new_page_navigation_item');
        }

        $this->template->touchBlock('content_manager');
        $this->template->addBlockfile('CONTENT_MANAGER_MEAT', 'content_manager_meat', 'Page.html');
        $this->template->touchBlock('content_manager_meat');
        $this->template->setRoot($cachedRoot);

        if (\Permission::checkAccess(78, 'static', true) &&
            \Permission::checkAccess(115, 'static', true)
        ) {
            \JS::registerCode("var publishAllowed = true;");
            $alias_permission = "block";
            $alias_denial     = "none !important";
        } else {
            \JS::registerCode("var publishAllowed = false;");
            $alias_permission = "none !important";
            $alias_denial     = "block";
        }
        $this->template->setVariable(array(
            'ALIAS_PERMISSION'  => $alias_permission,
            'ALIAS_DENIAL'      => $alias_denial,
            'CONTREXX_BASE_URL' => ASCMS_PROTOCOL . '://' . $_CONFIG['domainUrl'] . ASCMS_PATH_OFFSET . '/',
            'CONTREXX_LANG'     => \FWLanguage::getLanguageCodeById(BACKEND_LANG_ID),
        ));

        $this->setLanguageVars(array(
            //navi
            'TXT_NEW_PAGE', 'TXT_CONTENT_HISTORY', 'TXT_IMAGE_ADMINISTRATION',
            //site tree
            'TXT_CORE_CM_STATUS_PAGE', 'TXT_EXPAND_LINK', 'TXT_COLLAPS_LINK', 'TXT_CORE_CM_TRANSLATIONS', 'TXT_CORE_CM_APPLICATION', 'TXT_CORE_CM_VIEW', 'TXT_CORE_CM_ACTIONS', 'TXT_CORE_CM_LOG',
            //multiple actions
            'TXT_SELECT_ALL', 'TXT_DESELECT_ALL', 'TXT_MULTISELECT_SELECT', 'TXT_MULTISELECT_ACTIVATE', 'TXT_MULTISELECT_DEACTIVATE', 'TXT_MULTISELECT_SHOW', 'TXT_MULTISELECT_HIDE', 'TXT_MULTISELECT_UNPROTECT', 'TXT_MULTISELECT_DELETE',
            //type tab
            'TXT_CORE_CM_PAGE', 'TXT_CORE_CM_META', 'TXT_CORE_CM_PERMISSIONS', 'TXT_CORE_CM_MORE', 'TXT_CORE_CM_HISTORY', 'TXT_CORE_CM_PAGE_NAME', 'TXT_CORE_CM_PAGE_NAME_INFO', 'TXT_CORE_CM_PAGE_TITLE', 'TXT_CORE_CM_PAGE_TITLE_INFO', 'TXT_CORE_CM_TYPE', 'TXT_CORE_CM_TYPE_CONTENT', 'TXT_CORE_CM_TYPE_REDIRECT', 'TXT_CORE_CM_TYPE_APPLICATION', 'TXT_CORE_CM_TYPE_FALLBACK', 'TXT_CORE_CM_TYPE_CONTENT_INFO', 'TXT_CORE_CM_TYPE_REDIRECT_TARGET', 'TXT_CORE_CM_BROWSE', 'TXT_CORE_CM_TYPE_REDIRECT_INFO', 'TXT_CORE_CM_TYPE_APPLICATION', 'TXT_CORE_CM_TYPE_APPLICATION', 'TXT_CORE_CM_TYPE_APPLICATION_AREA', 'TXT_CORE_CM_TYPE_APPLICATION_INFO', 'TXT_CORE_CM_TYPE_FALLBACK_INFO', 'TXT_CORE_CM_TYPE_REDIRECT_INFO_ACTION', 'TXT_CORE_CM_SCHEDULED_PUBLISHING', 'TXT_CORE_CM_SCHEDULED_PUBLISHING_FROM', 'TXT_CORE_CM_SCHEDULED_PUBLISHING_TO', 'TXT_CORE_CM_SCHEDULED_PUBLISHING_INFO', 'TXT_INTERNAL',
            //meta tab
            'TXT_CORE_CM_SE_INDEX', 'TXT_CORE_CM_METATITLE', 'TXT_CORE_CM_METATITLE_INFO', 'TXT_CORE_CM_METADESC', 'TXT_CORE_CM_METADESC_INFO', 'TXT_CORE_CM_METAKEYS', 'TXT_CORE_CM_METAKEYS_INFO',
            //access tab
            'TXT_CORE_CM_ACCESS_PROTECTION_FRONTEND', 'TXT_CORE_CM_ACCESS_PROTECTION_BACKEND', 'TXT_CORE_CM_ACCESS_PROTECTION_AVAILABLE_GROUPS', 'TXT_CORE_CM_ACCESS_PROTECTION_ASSIGNED_GROUPS',
            //advanced tab
            'TXT_CORE_CM_THEMES', 'TXT_CORE_CM_THEMES_INFO', 'TXT_CORE_CM_CUSTOM_CONTENT', 'TXT_CORE_CM_CUSTOM_CONTENT_INFO', 'TXT_CORE_CM_CSS_CLASS', 'TXT_CORE_CM_CSS_CLASS_INFO', 'TXT_CORE_CM_CACHE', 'TXT_CORE_CM_NAVIGATION', 'TXT_CORE_CM_LINK_TARGET', 'TXT_CORE_CM_LINK_TARGET_INO', 'TXT_CORE_CM_SLUG', 'TXT_CORE_CM_SLUG_INFO', 'TXT_CORE_CM_ALIAS', 'TXT_CORE_CM_ALIAS_INFO', 'TXT_CORE_CM_CSS_NAV_CLASS', 'TXT_CORE_CM_CSS_NAV_CLASS_INFO', 'TXT_CORE_CM_SOURCE_MODE', 'TXT_RECURSIVE_CHANGE', 'TXT_CORE_CM_USE_ALL_CHANNELS', 'TXT_CORE_CM_USE_SKIN_ALL_CHANNELS_INFO', 'TXT_CORE_CM_USE_CUSTOM_CONTENT_ALL_CHANNELS_INFO',
            //blocks tab
            'TXT_CORE_CM_BLOCKS', 'TXT_CORE_CM_BLOCKS_AVAILABLE', 'TXT_CORE_CM_BLOCKS_ASSIGNED',
            //settings tab
            'TXT_CORE_APPLICATION_AREA', 'TXT_CORE_APPLICATION', 'TXT_CORE_AREA', 'TXT_CORE_SKIN', 'TXT_CORE_CUSTOMCONTENT', 'TXT_CORE_REDIRECTION', 'TXT_CORE_CACHING', 'TXT_CORE_SLUG', 'TXT_CORE_CSSNAME', 'TXT_THEME_PREVIEW', 'TXT_EDIT',
            //bottom buttons
            'TXT_CANCEL', 'TXT_CORE_PREVIEW', 'TXT_CORE_SAVE_PUBLISH', 'TXT_CORE_SAVE', 'TXT_CORE_SUBMIT_FOR_RELEASE', 'TXT_CORE_REFUSE_RELEASE'
        ));

        $objCx->setVariable('TXT_CORE_CM_VIEW', $_CORELANG['TXT_CORE_CM_VIEW'], 'contentmanager/lang');
        $objCx->setVariable('TXT_CORE_CM_ACTIONS', $_CORELANG['TXT_CORE_CM_ACTIONS'], 'contentmanager/lang');
        $objCx->setVariable('TXT_CORE_CM_VALIDATION_FAIL', $_CORELANG['TXT_CORE_CM_VALIDATION_FAIL'], 'contentmanager/lang');
        $objCx->setVariable('TXT_CORE_CM_HOME_FAIL', $_CORELANG['TXT_CORE_CM_HOME_FAIL'], 'contentmanager/lang');

        $arrLangVars = array(
            'actions' => array(
                'new'               => 'TXT_CORE_CM_ACTION_NEW',
                'copy'              => 'TXT_CORE_CM_ACTION_COPY',
                'activate'          => 'TXT_CORE_CM_ACTION_PUBLISH',
                'deactivate'        => 'TXT_CORE_CM_ACTION_UNPUBLISH',
                'publish'           => 'TXT_CORE_CM_ACTION_PUBLISH_DRAFT',
                'show'              => 'TXT_CORE_CM_ACTION_SHOW',
                'hide'              => 'TXT_CORE_CM_ACTION_HIDE',
                'delete'            => 'TXT_CORE_CM_ACTION_DELETE',
                'recursiveQuestion' => 'TXT_CORE_CM_RECURSIVE_QUESTION',
            ),
            'tooltip' => array(
                'TXT_CORE_CM_LAST_MODIFIED'                     => 'TXT_CORE_CM_LAST_MODIFIED',
                'TXT_CORE_CM_PUBLISHING_INFO_STATUSES'          => 'TXT_CORE_CM_PUBLISHING_INFO_STATUSES',
                'TXT_CORE_CM_PUBLISHING_INFO_ACTION_ACTIVATE'   => 'TXT_CORE_CM_PUBLISHING_INFO_ACTION_ACTIVATE',
                'TXT_CORE_CM_PUBLISHING_INFO_ACTION_DEACTIVATE' => 'TXT_CORE_CM_PUBLISHING_INFO_ACTION_DEACTIVATE',
                'TXT_CORE_CM_PUBLISHING_DRAFT'                  => 'TXT_CORE_CM_PUBLISHING_DRAFT',
                'TXT_CORE_CM_PUBLISHING_DRAFT_WAITING'          => 'TXT_CORE_CM_PUBLISHING_DRAFT_WAITING',
                'TXT_CORE_CM_PUBLISHING_LOCKED'                 => 'TXT_CORE_CM_PUBLISHING_LOCKED',
                'TXT_CORE_CM_PUBLISHING_PUBLISHED'              => 'TXT_CORE_CM_PUBLISHING_PUBLISHED',
                'TXT_CORE_CM_PUBLISHING_UNPUBLISHED'            => 'TXT_CORE_CM_PUBLISHING_UNPUBLISHED',
                'TXT_CORE_CM_PAGE_INFO_STATUSES'                => 'TXT_CORE_CM_PAGE_INFO_STATUSES',
                'TXT_CORE_CM_PUBLISHING_INFO_TYPES'             => 'TXT_CORE_CM_PUBLISHING_INFO_TYPES',
                'TXT_CORE_CM_PAGE_INFO_ACTION_SHOW'             => 'TXT_CORE_CM_PAGE_INFO_ACTION_SHOW',
                'TXT_CORE_CM_PAGE_INFO_ACTION_HIDE'             => 'TXT_CORE_CM_PAGE_INFO_ACTION_HIDE',
                'TXT_CORE_CM_PAGE_STATUS_BROKEN'                => 'TXT_CORE_CM_PAGE_STATUS_BROKEN',
                'TXT_CORE_CM_PAGE_STATUS_VISIBLE'               => 'TXT_CORE_CM_PAGE_STATUS_VISIBLE',
                'TXT_CORE_CM_PAGE_STATUS_INVISIBLE'             => 'TXT_CORE_CM_PAGE_STATUS_INVISIBLE',
                'TXT_CORE_CM_PAGE_STATUS_PROTECTED'             => 'TXT_CORE_CM_PAGE_STATUS_PROTECTED',
                'TXT_CORE_CM_PAGE_TYPE_HOME'                    => 'TXT_CORE_CM_PAGE_TYPE_HOME',
                'TXT_CORE_CM_PAGE_TYPE_CONTENT_SITE'            => 'TXT_CORE_CM_PAGE_TYPE_CONTENT_SITE',
                'TXT_CORE_CM_PAGE_TYPE_APPLICATION'             => 'TXT_CORE_CM_PAGE_TYPE_APPLICATION',
                'TXT_CORE_CM_PAGE_TYPE_REDIRECTION'             => 'TXT_CORE_CM_PAGE_TYPE_REDIRECTION',
                'TXT_CORE_CM_PAGE_TYPE_FALLBACK'                => 'TXT_CORE_CM_PAGE_TYPE_FALLBACK',
                'TXT_CORE_CM_PAGE_MOVE_INFO'                    => 'TXT_CORE_CM_PAGE_MOVE_INFO',
                'TXT_CORE_CM_TRANSLATION_INFO'                  => 'TXT_CORE_CM_TRANSLATION_INFO',
                'TXT_CORE_CM_PREVIEW_INFO'                      => 'TXT_CORE_CM_PREVIEW_INFO',
            ),
        );
        foreach ($arrLangVars as $subscope => $arrLang) {
            foreach ($arrLang as $name => $value) {
                $objCx->setVariable($name, $_CORELANG[$value], 'contentmanager/lang/' . $subscope);
            }
        }

        $toggleTitles      = !empty($_SESSION['contentManager']['toggleStatuses']['toggleTitles']) ? $_SESSION['contentManager']['toggleStatuses']['toggleTitles'] : 'block';
        $toggleType        = !empty($_SESSION['contentManager']['toggleStatuses']['toggleType']) ? $_SESSION['contentManager']['toggleStatuses']['toggleType'] : 'block';
        $toggleNavigation  = !empty($_SESSION['contentManager']['toggleStatuses']['toggleNavigation']) ? $_SESSION['contentManager']['toggleStatuses']['toggleNavigation'] : 'block';
        $toggleBlocks      = !empty($_SESSION['contentManager']['toggleStatuses']['toggleBlocks']) ? $_SESSION['contentManager']['toggleStatuses']['toggleBlocks'] : 'block';
        $toggleThemes      = !empty($_SESSION['contentManager']['toggleStatuses']['toggleThemes']) ? $_SESSION['contentManager']['toggleStatuses']['toggleThemes'] : 'block';
        $toggleApplication = !empty($_SESSION['contentManager']['toggleStatuses']['toggleApplication']) ? $_SESSION['contentManager']['toggleStatuses']['toggleApplication'] : 'block';
        $toggleSidebar     = !empty($_SESSION['contentManager']['toggleStatuses']['sidebar']) ? $_SESSION['contentManager']['toggleStatuses']['sidebar'] : 'block';
        $objCx->setVariable('toggleTitles', $toggleTitles, 'contentmanager/toggle');
        $objCx->setVariable('toggleType', $toggleType, 'contentmanager/toggle');
        $objCx->setVariable('toggleNavigation', $toggleNavigation, 'contentmanager/toggle');
        $objCx->setVariable('toggleBlocks', $toggleBlocks, 'contentmanager/toggle');
        $objCx->setVariable('toggleThemes', $toggleThemes, 'contentmanager/toggle');
        $objCx->setVariable('toggleApplication', $toggleApplication, 'contentmanager/toggle');
        $objCx->setVariable('sidebar', $toggleSidebar, 'contentmanager/toggle');

        // get initial tree data
        $objJsonData = new \Cx\Core\Json\JsonData();
        $treeData    = $objJsonData->jsondata('node', 'getTree', array('get' => $_GET), false);
        $objCx->setVariable('tree-data', $treeData, 'contentmanager/tree');

        if (!empty($_GET['act']) && ($_GET['act'] == 'new')) {
            $this->template->setVariable(array(
                'TITLES_DISPLAY_STYLE'          => 'display: block;',
                'TITLES_TOGGLE_CLASS'           => 'open',
                'TYPE_DISPLAY_STYLE'            => 'display: block;',
                'TYPE_TOGGLE_CLASS'             => 'open',
                'NAVIGATION_DISPLAY_STYLE'      => 'display: block;',
                'NAVIGATION_TOGGLE_CLASS'       => 'open',
                'BLOCKS_DISPLAY_STYLE'          => 'display: block;',
                'BLOCKS_TOGGLE_CLASS'           => 'open',
                'THEMES_DISPLAY_STYLE'          => 'display: block;',
                'THEMES_TOGGLE_CLASS'           => 'open',
                'APPLICATION_DISPLAY_STYLE'     => 'display: block;',
                'APPLICATION_TOGGLE_CLASS'      => 'open',
                'MULTIPLE_ACTIONS_STRIKE_STYLE' => 'display: none;',
            ));
        } else {
            $this->template->setVariable(array(
                'TITLES_DISPLAY_STYLE'      => $toggleTitles == 'none' ? 'display: none;' : 'display: block;',
                'TITLES_TOGGLE_CLASS'       => $toggleTitles == 'none' ? 'closed' : 'open',
                'TYPE_DISPLAY_STYLE'        => $toggleType == 'none' ? 'display: none;' : 'display: block;',
                'TYPE_TOGGLE_CLASS'         => $toggleType == 'none' ? 'closed' : 'open',
                'NAVIGATION_DISPLAY_STYLE'  => $toggleNavigation == 'none' ? 'display: none;' : 'display: block;',
                'NAVIGATION_TOGGLE_CLASS'   => $toggleNavigation == 'none' ? 'closed' : 'open',
                'BLOCKS_DISPLAY_STYLE'      => $toggleBlocks == 'none' ? 'display: none;' : 'display: block;',
                'BLOCKS_TOGGLE_CLASS'       => $toggleBlocks == 'none' ? 'closed' : 'open',
                'THEMES_DISPLAY_STYLE'      => $toggleThemes == 'none' ? 'display: none;' : 'display: block;',
                'THEMES_TOGGLE_CLASS'       => $toggleThemes == 'none' ? 'closed' : 'open',
                'APPLICATION_DISPLAY_STYLE' => $toggleApplication == 'none' ? 'display: none;' : 'display: block;',
                'APPLICATION_TOGGLE_CLASS'  => $toggleApplication == 'none' ? 'closed' : 'open',
            ));
        }

        $modules = $this->db->Execute("SELECT * FROM " . DBPREFIX . "modules WHERE `status` = 'y' ORDER BY `name`");
        while (!$modules->EOF) {
            $this->template->setVariable('MODULE_KEY', $modules->fields['name']);
//            $this->template->setVariable('MODULE_TITLE', $_CORELANG[$modules->fields['description_variable']]);
            $this->template->setVariable('MODULE_TITLE', ucwords($modules->fields['name']));
            $this->template->parse('module_option');
            $modules->MoveNext();
        }

        $newPageFirstLevel = isset($_GET['act']) && $_GET['act'] == 'new';

        if (\Permission::checkAccess(36, 'static', true)) {
            $this->template->touchBlock('page_permissions_tab');
            $this->template->touchBlock('page_permissions');
        } else {
            $this->template->hideBlock('page_permissions_tab');
            $this->template->hideBlock('page_permissions');
        }

        if (\Permission::checkAccess(78, 'static', true)) {
            $this->template->hideBlock('release_button');
        } else {
            $this->template->hideBlock('publish_button');
            $this->template->hideBlock('refuse_button');
        }

        // show no access page if the user wants to create new page in first level but he does not have enough permissions
        if ($newPageFirstLevel) {
            \Permission::checkAccess(127, 'static');
        }

        $editViewCssClass = '';
        if ($newPageFirstLevel) {
            $editViewCssClass = 'edit_view';
            $this->template->hideBlock('refuse_button');
        }

        $cxjs = \ContrexxJavascript::getInstance();
        $cxjs->setVariable('confirmDeleteQuestion', $_ARRAYLANG['TXT_CORE_CM_CONFIRM_DELETE'], 'contentmanager/lang');
        $cxjs->setVariable('cleanAccessData', $objJsonData->jsondata('page', 'getAccessData', array(), false), 'contentmanager');
        $cxjs->setVariable('contentTemplates', $this->getCustomContentTemplates(), 'contentmanager');
        $cxjs->setVariable('defaultTemplates', $this->getDefaultTemplates(), 'contentmanager/themes');
        $cxjs->setVariable('templateFolders', $this->getTemplateFolders(), 'contentmanager/themes');
        $cxjs->setVariable('availableBlocks', $objJsonData->jsondata('block', 'getBlocks', array(), false), 'contentmanager');

        // TODO: move including of add'l JS dependencies to cx obj from /cadmin/index.html
        $getLangOptions=$this->getLangOptions();
        $statusPageLayout='';
        $languageDisplay='';
        if (((!empty($_GET['act']) && $_GET['act'] == 'new')
                ||!empty($_GET['page'])) && $getLangOptions=="") {
            $statusPageLayout='margin0';
            $languageDisplay='display:none';
        }

        $this->template->setVariable('ADMIN_LIST_MARGIN', $statusPageLayout);
        $this->template->setVariable('LANGUAGE_DISPLAY', $languageDisplay);

        // TODO: move including of add'l JS dependencies to cx obj from /cadmin/index.html
        $this->template->setVariable('CXJS_INIT_JS', \ContrexxJavascript::getInstance()->initJs());
        $this->template->setVariable('SKIN_OPTIONS', $this->getSkinOptions());
        $this->template->setVariable('LANGSWITCH_OPTIONS', $this->getLangOptions());
        $this->template->setVariable('LANGUAGE_ARRAY', json_encode($this->getLangArray()));
        $this->template->setVariable('FALLBACK_ARRAY', json_encode($this->getFallbackArray()));
        $this->template->setVariable('LANGUAGE_LABELS', json_encode($this->getLangLabels()));
        $this->template->setVariable('EDIT_VIEW_CSS_CLASS', $editViewCssClass);
        
        $this->template->touchBlock('content_manager_language_selection');

        $editmodeTemplate = new \Cx\Core\Html\Sigma(ASCMS_ADMIN_TEMPLATE_PATH);
        $editmodeTemplate->loadTemplateFile('content_editmode.html');
        $editmodeTemplate->setVariable(array(
            'TXT_EDITMODE_TEXT'    => $_CORELANG['TXT_FRONTEND_EDITING_SELECTION_TEXT'],
            'TXT_EDITMODE_CODE'    => $_CORELANG['TXT_FRONTEND_EDITING_SELECTION_MODE_PAGE'],
            'TXT_EDITMODE_CONTENT' => $_CORELANG['TXT_FRONTEND_EDITING_SELECTION_MODE_CONTENT'],
        ));
        \Env::get('ClassLoader')->loadFile(ASCMS_FRAMEWORK_PATH . '/Validator.class.php');
        $cxjs->setVariable(array(
            'editmodetitle'      => $_CORELANG['TXT_FRONTEND_EDITING_SELECTION_TITLE'],
            'editmodecontent'    => $editmodeTemplate->get(),
            'ckeditorconfigpath' => substr(\Env::get('ClassLoader')->getFilePath(ASCMS_CORE_PATH . '/Wysiwyg/ckeditor.config.js.php'), strlen(ASCMS_DOCUMENT_ROOT) + 1),
            'regExpUriProtocol'  => VALIDATOR_REGEX_URI_PROTO,
            'contrexxBaseUrl'    => ASCMS_PROTOCOL . '://' . $_CONFIG['domainUrl'] . ASCMS_PATH_OFFSET . '/',
            'contrexxPathOffset' => ASCMS_PATH_OFFSET,
        ), 'contentmanager');
    }

    protected function getThemes()
    {
        $query = "SELECT id,themesname FROM " . DBPREFIX . "skins ORDER BY id";
        $rs    = $this->db->Execute($query);

        $themes = array();
        while (!$rs->EOF) {
            $themes[$rs->fields['id']] = $rs->fields['themesname'];
            $rs->MoveNext();
        }

        return $themes;
    }

    protected function getSkinOptions()
    {
        $options = '';
        foreach ($this->getThemes() as $id => $name) {
            $options .= '<option value="' . $id . '">' . $name . '</option>' . "\n";
        }

        return $options;
    }

    protected function getLangOptions()
    {
        $output = '';
        $language=\FWLanguage::getActiveFrontendLanguages();
        if (count($language)>1) {
            $output .='<select id="language" class="chzn-select">';
            foreach ($language as $lang) {
                $selected = $lang['id'] == FRONTEND_LANG_ID ? ' selected="selected"' : '';
                $output .= '<option value="' . \FWLanguage::getLanguageCodeById($lang['id']) . '"' . $selected . '>' . $lang['name'] . '</option>';
            }
            $output .='</select>';
        }
        $output .= '<input type="hidden"  name="languageCount" id="languageCount" value="'.count($language).'">';
        return $output;
    }


    protected function getLangLabels()
    {
        $output = array();
        foreach (\FWLanguage::getActiveFrontendLanguages() as $lang) {
            $output[\FWLanguage::getLanguageCodeById($lang['id'])] = $lang['name'];
        }

        return $output;
    }

    protected function getLangArray()
    {
        $output = array();
        // set selected frontend language as first language
        // jstree does display the tree of the first language
        $output[] = \FWLanguage::getLanguageCodeById(FRONTEND_LANG_ID);
        foreach (\FWLanguage::getActiveFrontendLanguages() as $lang) {
            if ($lang['id'] == FRONTEND_LANG_ID) {
                continue;
            }
            $output[] = \FWLanguage::getLanguageCodeById($lang['id']);
        }

        return $output;
    }

    protected function getFallbackArray()
    {
        $fallbacks = \FWLanguage::getFallbackLanguageArray();
        $output    = array();
        foreach ($fallbacks as $key => $value) {
            $output[\FWLanguage::getLanguageCodeById($key)] = \FWLanguage::getLanguageCodeById($value);
        }

        return $output;
    }

    protected function setLanguageVars($ids)
    {
        global $_CORELANG;
        foreach ($ids as $id) {
            $this->template->setVariable($id, $_CORELANG[$id]);
        }
    }

    protected function getCustomContentTemplates()
    {
        $templates = array();
        // foreach theme
        foreach ($this->getThemes() as $id => $name) {
            $templates[$id] = $this->init->getCustomContentTemplatesForTheme($id);
        }

        return $templates;
    }

    protected function getDefaultTemplates()
    {
        $query = 'SELECT `id`, `lang`, `themesid` FROM `' . DBPREFIX . 'languages`';
        $rs    = $this->db->Execute($query);

        $defaultThemes = array();
        while (!$rs->EOF) {
            $defaultThemes[$rs->fields['lang']] = $rs->fields['themesid'];
            $rs->MoveNext();
        }

        return $defaultThemes;
    }

    protected function getTemplateFolders()
    {
        $query = 'SELECT `id`, `foldername` FROM `' . DBPREFIX . 'skins`';
        $rs    = $this->db->Execute($query);

        $folderNames = array();
        while (!$rs->EOF) {
            $folderNames[$rs->fields['id']] = $rs->fields['foldername'];
            $rs->MoveNext();
        }

        return $folderNames;
    }
}
