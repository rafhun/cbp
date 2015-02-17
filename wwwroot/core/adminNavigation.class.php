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
 * Admin CP navigation
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Comvation Development Team <info@comvation.com>
 * @version     2.0.0
 * @package     contrexx
 * @subpackage  core
 * @todo        Edit PHP DocBlocks!
 */

/**
 * Class for the Admin CP navigation
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Comvation Development Team <info@comvation.com>
 * @access      public
 * @version     2.0.0
 * @package     contrexx
 * @subpackage  core
 * @todo        Edit PHP DocBlocks!
 */
class adminMenu
{
    public $arrMenuItems = array();
    public $arrMenuGroups = array();
    public $statusMessage;
    public $arrUserRights = array();
    public $arrUserGroups = array();
    private $activeCmd = null;


    public function __construct($activeCmd)
    {
        $this->activeCmd = $activeCmd;
        $this->init();
    }


    public function getAdminNavbar()
    {
        global $objTemplate;

        $this->getMenu();
        $objTemplate->setVariable('STATUS_MESSAGE',trim($this->statusMessage));
    }


    private function init()
    {
        global $_CORELANG, $_ARRAYLANG, $objDatabase;

        $objFWUser = FWUser::getFWUserObject();
        $sqlWhereString = "";

        if (!$objFWUser->objUser->getAdminStatus()) {
            if (count($objFWUser->objUser->getStaticPermissionIds()) > 0) {
                $sqlWhereString = " AND (areas.access_id = ".implode(' OR areas.access_id = ', $objFWUser->objUser->getStaticPermissionIds()).")";
            } else {
                $sqlWhereString = " AND areas.access_id='' ";
            }
            $sqlWhereString .= " OR areas.access_id='0' ";
        }

        $query = "
            SELECT
                areas.area_id AS area_id,
                areas.parent_area_id AS parent_area_id,
                areas.area_name AS area_name,
                areas.type AS type,
                areas.uri AS uri,
                areas.target AS target,
                modules.name AS module_name,
                modules.is_active,
                modules.is_licensed,
                areas.module_id
            FROM
                ".DBPREFIX."backend_areas AS areas
            INNER JOIN
                ".DBPREFIX."modules AS modules
            ON
                modules.id=areas.module_id
            WHERE
                areas.is_active=1
                AND (areas.type = 'group' OR areas.type = 'navigation')
                ".//AND (modules.is_active = 1 OR areas.module_id = 0)
                "
                ".$sqlWhereString."
            ORDER BY
                areas.order_id ASC
        ";
        $objResult = $objDatabase->Execute($query);
        // ADD A JOIN TO MODULE TABLE HERE TO SEE IF THE MODULE IS ACTIVE
        if ($objResult !== false) {
            while (!$objResult->EOF) {
                if ($objResult->fields['type'] == "group") {
                    $this->arrMenuGroups[$objResult->fields['area_id']] = $objResult->fields['area_name'];
                }
                if (isset($_CORELANG[$objResult->fields['area_name']])) {
                    $name = $_CORELANG[$objResult->fields['area_name']];
                } else {
                    $arrLang = $_ARRAYLANG;
                    // load language file
                    \Env::get('init')->loadLanguageData($objResult->fields['module_name']);
                    if (isset($_ARRAYLANG[$objResult->fields['area_name']])) {
                        $name = $_ARRAYLANG[$objResult->fields['area_name']];
                    } else {
                        $name = '';
                    }
                    $_ARRAYLANG = $arrLang;
                }
                $this->arrMenuItems[$objResult->fields['area_id']] =
                array(
                    $objResult->fields['parent_area_id'],
                    $name,
                    $objResult->fields['uri'],
                    $objResult->fields['target'],
                    $objResult->fields['module_name'],
                    ($objResult->fields['is_licensed'] == 1 || $objResult->fields['module_id'] == 0),
                );
                $objResult->MoveNext();
            }
        }
    }


    /**
     * Creates the administration navigation
     *
     * Considers the users' rights and only shows what he's
     * allowed to see
     * @global array  $_CORELANG
     * @global object $objTemplate
     */
    private function getMenu()
    {
        global $_CORELANG, $objTemplate, $_CONFIG;

        $objTemplate->addBlockfile('NAVIGATION_OUTPUT', 'navigation_output', 'index_navigation.html');

        reset($this->arrMenuItems);

        if (empty($_GET['cmd'])) {
            setcookie('navigation_level_2_active', '184');
            $_COOKIE['navigation_level_2_active'] = '184';
        } else {
            foreach ($this->arrMenuItems as $menuItem) {
                if (preg_match('/cmd=(.+?)(?:&amp;(.+))?$/', $menuItem[2], $arrMatch)) {
                    if ($arrMatch[1] == $this->activeCmd) {
                        setcookie('navigation_level_2_active', $menuItem[0]);
                        $_COOKIE['navigation_level_2_active'] = $menuItem[0];
                    }
                }
            }
        }

        foreach ( $this->arrMenuGroups as $group_id => $group_data ) {
            // Module group menu and module check!
            $navigation = '';

            //used to remember items in current menu group
            $arrMatchingItems = array();
            //used to remember captions of the current menu group
            //later used to perform array_multisort
            $arrMatchingItemCaptions = array();

            //(1/3) find entries of current menu group
            foreach ($this->arrMenuItems as $link_data) {
                // checks if the links are childs of this area ID
                if ($link_data[0] == $group_id) {
                    $arrMatchingItems[] = $link_data;
                    $arrMatchingItemCaptions[] = $link_data[1];
                }
            }
            if($group_id == 2) {  //modules group
                //(2/3) sort entries by captions
                array_multisort($arrMatchingItemCaptions, $arrMatchingItems);
            }

            //(3/3) display a nice ordered menu.
            $subentryActive = false;
            $nonUpgradeEntry = false;
            foreach ($arrMatchingItems as $link_data) {
                if ($this->moduleExists($link_data[4])) {

                    // active exceptions for media and content module
                    // ask: thomas.daeppen@comvation.com
                    $linkCmd = '';
                    $linkCmdSection = '';
                    if (preg_match('/cmd=(.+?)(?:&amp;(.+))?$/', $link_data[2], $arrMatch)) {
                        $linkCmd = $arrMatch[1];
                        if (isset($arrMatch[2])) {
                            $linkCmdSection = $arrMatch[2];
                        }

                        switch ($linkCmd) {
                            case 'news':
                                $news = new newsManager();
                                if ($linkCmdSection == 'act=newstype' && $news->arrSettings['news_use_types'] != '1') {
                                    continue 2;
                                } else if ($linkCmdSection == 'act=teasers' && $_CONFIG['newsTeasersStatus'] != '1') {
                                    continue 2;
                                }
                                break;
                            case 'content';
                                if (   $this->activeCmd == 'content'
                                    && (   empty($_REQUEST['act']) && !empty($linkCmdSection)
                                        || !empty($_REQUEST['act']) && empty($linkCmdSection))
                                ) {

                                    $linkCmd = '';
                                }
                                // hide new page item in navigation if the user has no permission to create new page in first level
                                if ($linkCmdSection == 'act=new' && !\Permission::checkAccess(127, 'static', true)) {
                                    continue 2;
                                }
                                break;
                            case 'stats':
                                $cssClass = 'inactive';
                                if ($this->activeCmd == 'stats') {
                                    if (!empty($_REQUEST['stat']) && !empty($linkCmdSection) && (strpos($linkCmdSection, $_REQUEST['stat']) !== false)) {
                                        $cssClass = 'active';
                                    }
                                }
                                break;
                            case 'server':
                                if ($this->activeCmd == 'nettools') {
                                    $cssClass = 'active';
                                }
                                break;
                            case 'skins':
                                if ($this->activeCmd == 'skins') {
                                    break;
                                }
                                $linkCmdSection = 'archive=themes';
                            case 'contact':
                                if ($this->activeCmd == 'contact') {
                                    break;
                                }
                                if ($linkCmd == 'contact') {
                                    $linkCmdSection = 'archive=contact';
                                }
                            case 'media':
                                if ($this->activeCmd != 'media') {
                                    break;
                                }

                                $isRequestedMediaArchive = false;
                                $requestedArchive = '';
                                if (isset($_REQUEST['archive'])) {
                                    $requestedArchive = preg_replace('/\d+$/', '', $_REQUEST['archive']);
                                }

                                switch ($requestedArchive) {
                                    case 'attach':
                                    case 'shop':
                                    case 'gallery':
                                    case 'access':
                                    case 'mediadir':
                                    case 'downloads':
                                    case 'calendar':
                                    case 'podcast':
                                    case 'blog':
                                        $requestedArchive = 'content';
                                        break;
                                    case 'themes':
                                        $linkCmd = 'media';
                                        break;
                                    case 'contact':
                                        $linkCmd = 'media';
                                        break;
                                    case 'archive':
                                        $requestedArchive = 'archive';
                                        break;
                                }

                                if (!empty($requestedArchive)) {
                                    if (preg_match('/archive=(.+?)\d*$/', $linkCmdSection, $arrMatch)) {
                                        $mediaArchive = $arrMatch[1];
                                        if ($mediaArchive == $requestedArchive) {
                                            $isRequestedMediaArchive = true;
                                        }
                                    }

                                }

                                if (!$isRequestedMediaArchive) {
                                    $linkCmd = '';
                                }

                                break;
                            case 'newsletter':
                                if (!isset($_REQUEST['act'])) {
                                    $_REQUEST['act'] = 'mails';
                                }
                                switch ($_REQUEST['act']) {
                                    case 'editMail':
                                        $_REQUEST['act'] = 'mail';
                                        break;
                                    case 'interface':
                                    case 'templates':
                                    case 'tpledit':
                                    case 'confightml':
                                    case 'activatemail':
                                    case 'confirmmail':
                                    case 'notificationmail':
                                    case 'system':
                                        $_REQUEST['act'] = 'dispatch';
                                        break;
                                    default:
                                        break;
                                }
                                break;
                            case 'crm':
                                if($link_data[1] == $_CORELANG['TXT_CRM_CUSTOMERS']){
                                    $link_data[1] = $_CORELANG['TXT_CRM_CUSTOMER'];
                                }
                                break;
                            case 'access':
                                if($link_data[0] == '189'){
                                    $cssClass = 'inactive';
                                }
                                break;
                            default:
                                break;
                        }
                    }

                    if (empty($cssClass)) {
                        if ((!empty($this->activeCmd) && !empty($linkCmd) && ($this->activeCmd == $linkCmd)) &&
                            (!empty($_REQUEST['act']) && !empty($linkCmdSection) && (strpos($linkCmdSection, $_REQUEST['act']) !== false))
                        ) {
                            $cssClass = 'active';
                        } else if (!empty($this->activeCmd) && !empty($linkCmd) && ($this->activeCmd == $linkCmd)) {
                            if (empty($_REQUEST['act']) || empty($linkCmdSection) || (strpos($_SERVER['QUERY_STRING'], $linkCmdSection) != false)) {
                                $cssClass = 'active';
                            } else  {
                                $cssClass = 'inactive';
                            }
                        } else if (empty($this->activeCmd) && $link_data[2] == 'index.php') {
                            $cssClass = 'active';
                        } else {
                            $cssClass = 'inactive';
                        }
                    }
                    if ($cssClass == 'active') {
                        $subentryActive = true;
                    }
                    $upgrade = '';
                    if (!$link_data[5]) {
                        $cssClass .= ' nav_upgrade';
                        $upgrade = '<span class="upgrade"></span>';
                    } else {
                        $nonUpgradeEntry = true;
                    }
                    $navigation .= "<li class='" . trim($cssClass) . "'>" . $upgrade . "
                        <a href='".strip_tags($link_data[2])."' title='".htmlentities($link_data[1], ENT_QUOTES, CONTREXX_CHARSET)."' target='".$link_data[3]."'>
                            ".htmlentities($link_data[1], ENT_QUOTES, CONTREXX_CHARSET)."
                        </a>
                    </li>\n";
                }
                
                $cssClass = '';
            }

            if (!empty($navigation)) {
                $objTemplate->setVariable(array(
                    'NAVIGATION_GROUP_NAME' => htmlentities($_CORELANG[$group_data], ENT_QUOTES, CONTREXX_CHARSET),
                    'NAVIGATION_GROUP_UPGRADE' => (!$nonUpgradeEntry ? '<span class="upgrade"></span>' : ''),
                    'NAVIGATION_ID'         => $group_id,
                    'NAVIGATION_MENU'       => $navigation,
                    'NAVIGATION_CLASS'      => ($subentryActive ? 'active' : 'inactive') . (!$nonUpgradeEntry ? ' nav_upgrade' : ''),
                ));
                $objTemplate->parse('navigationRow');
            }
        }

        $objTemplate->setVariable(array(
            'TXT_SEARCH'                    => $_CORELANG['TXT_SEARCH'],
            'TXT_HOME_LINKNAME'             => $_CORELANG['TXT_HOME'],
            'TXT_DASHBOARD_LINKNAME'        => $_CORELANG['TXT_DASHBOARD'],
            'NAVIGATION_HOME_CLASS'         => (isset($_COOKIE['navigation_level_2_active'])) && ($_COOKIE['navigation_level_2_active'] == 'home') ? 'active' : 'inactive',
            'NAVIGATION_DASHBOARD_CLASS'    => empty($_GET['cmd']) ? 'active' : 'inactive',
        ));
        $objTemplate->parse('navigation_output');
    }


    private function moduleExists($module)
    {
        if (empty($module)) {
            return true;
        }

        if (contrexx_isCoreModule($module)) {
            return true;
        } else {
            return contrexx_isModuleInstalled($module);
        }

    }
}
