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
 * my Administrator manager
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Comvation Development Team <info@comvation.com>
 * @version     1.0.1
 * @package     contrexx
 * @subpackage  core
 * @todo        Edit PHP DocBlocks!
 */

/**
 * @ignore
 */
require_once(ASCMS_LIBRARY_PATH.'/PEAR/XML/RSS.class.php');

/**
 * my Administrator manager
 *
 * Class to show the my admin pages
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Comvation Development Team <info@comvation.com>
 * @version	   1.0.1
 * @package     contrexx
 * @subpackage  core
 */
class myAdminManager {
    var $statusMessage;

    /**
    * Constructor
    *
    * @param  string
    * @access public
    */
    function __construct()
    {
        global $_CORELANG, $objTemplate;

        if ($objUser = FWUser::getFWUserObject()->objUser->getUsers($filter = array('is_admin' => true, 'active' => true, 'last_activity' => array('>' => (time()-3600))))) {
            $arrAdministratorsOnline = array();
            $i = 0;
            while (!$objUser->EOF) {
                $arrAdministratorsOnline[$i]['id'] = $objUser->getId();
                $arrAdministratorsOnline[$i++]['username'] = $objUser->getUsername();
                $objUser->next();
            }
            $administratorsOnline = '';
            for ($i = 0; $i < count($arrAdministratorsOnline); $i++) {
                $administratorsOnline .= '<a href="index.php?cmd=access&amp;act=user&amp;tpl=modify&amp;id='.$arrAdministratorsOnline[$i]['id'].'">'.$arrAdministratorsOnline[$i]['username'].($i == (count($arrAdministratorsOnline)-1) ? '' : ',').'</a>';
            }
        }
        $objTemplate->setVariable('CONTENT_NAVIGATION', '<span id="administrators_online">'.$_CORELANG['TXT_ADMINISTSRATORS_ONLINE'].': </span>'.$administratorsOnline);
    }

    function getPage()
    {
        global $_CORELANG, $_CONFIG, $objTemplate;

        if (!isset($_GET['act'])) {
            $_GET['act']='';
        }

        switch($_GET['act']) {
            case 'deactivateSetting':
                $this->deactivateSetting($_GET['id']);
                break;
            default:
                $this->getHomePage();
                break;
        }

        $objTemplate->setVariable(array(
            'CONTENT_TITLE'		=> '',
            'CONTENT_STATUS_MESSAGE'	=> trim($this->statusMessage),
        ));
    }

    function getHomePage()
    {
        global $_CORELANG, $_CONFIG, $objTemplate, $objDatabase;

        $objTemplate->addBlockfile('ADMIN_CONTENT', 'content', 'index_home.html');

        JS::activate('jquery-bootstrap');
        JS::activate('jquery-jqplot');

        $arrAccessIDs = array(5, 10, 76, '84_1', 6, 19, 75, '84_2', 17, 18, 7, 32, 21);
        foreach ($arrAccessIDs as $id) {
            $accessID = strpos($id, '_') ? substr($id, 0, strpos($id, '_')) : $id;
            if (Permission::checkAccess($accessID, 'static', true)) {
                $objTemplate->touchBlock('check_access_'.$id);
            } else {
                $objTemplate->hideBlock('check_access_'.$id);
            }
        }

        $objTemplate->setVariable(array(
            'CSRF'                          => CSRF::param(),
            'TXT_LAST_LOGIN' 				=> htmlentities($_CORELANG['TXT_LAST_LOGIN'], ENT_QUOTES, CONTREXX_CHARSET),
            'TXT_CONTREXX_NEWS' 			=> htmlentities($_CORELANG['TXT_CONTREXX_NEWS'], ENT_QUOTES, CONTREXX_CHARSET),
            'TXT_CREATING_AND_PUBLISHING'   => htmlentities($_CORELANG['TXT_CREATING_AND_PUBLISHING'], ENT_QUOTES, CONTREXX_CHARSET),
            'TXT_EVALUATE_AND_VIEW' 		=> htmlentities($_CORELANG['TXT_EVALUATE_AND_VIEW'], ENT_QUOTES, CONTREXX_CHARSET),
            'TXT_MANAGE' 					=> htmlentities($_CORELANG['TXT_MANAGE'], ENT_QUOTES, CONTREXX_CHARSET),
            'TXT_NEW_SITE' 					=> htmlentities($_CORELANG['TXT_NEW_PAGE'], ENT_QUOTES, CONTREXX_CHARSET),
            'TXT_ADD_NEWS' 					=> htmlentities($_CORELANG['TXT_ADD_NEWS'], ENT_QUOTES, CONTREXX_CHARSET),
            'TXT_ADD_BLOCK' 				=> htmlentities($_CORELANG['TXT_ADD_BLOCK'], ENT_QUOTES, CONTREXX_CHARSET),
            'TXT_ADD_FORM' 					=> htmlentities($_CORELANG['TXT_ADD_FORM'], ENT_QUOTES, CONTREXX_CHARSET),
            'TXT_CONTENT_MANAGER' 			=> htmlentities($_CORELANG['TXT_CONTENT_MANAGER'], ENT_QUOTES, CONTREXX_CHARSET),
            'TXT_STATS' 					=> htmlentities($_CORELANG['TXT_STATS'], ENT_QUOTES, CONTREXX_CHARSET),
            'TXT_WORKFLOW'					=> htmlentities($_CORELANG['TXT_WORKFLOW'], ENT_QUOTES, CONTREXX_CHARSET),
            'TXT_FORMS' 					=> htmlentities($_CORELANG['TXT_FORMS'], ENT_QUOTES, CONTREXX_CHARSET),
            'TXT_SYSTEM_SETTINGS' 			=> htmlentities($_CORELANG['TXT_SYSTEM_SETTINGS'], ENT_QUOTES, CONTREXX_CHARSET),
            'TXT_USER_MANAGER' 				=> htmlentities($_CORELANG['TXT_USER_ADMINISTRATION'], ENT_QUOTES, CONTREXX_CHARSET),
            'TXT_MEDIA_MANAGER' 			=> htmlentities($_CORELANG['TXT_MEDIA_MANAGER'], ENT_QUOTES, CONTREXX_CHARSET),
            'TXT_IMAGE_ADMINISTRATION'		=> htmlentities($_CORELANG['TXT_IMAGE_ADMINISTRATION'], ENT_QUOTES, CONTREXX_CHARSET),
            'TXT_SKINS' 					=> htmlentities($_CORELANG['TXT_DESIGN_MANAGEMENT'], ENT_QUOTES, CONTREXX_CHARSET),
            'TXT_VISITORS'                  => htmlentities($_CORELANG['TXT_CORE_VISITORS'], ENT_QUOTES, CONTREXX_CHARSET),
            'TXT_REQUESTS'                  => htmlentities($_CORELANG['TXT_CORE_REQUESTS'], ENT_QUOTES, CONTREXX_CHARSET),
            'TXT_DASHBOARD_NEWS_ALERT'      => htmlentities($_CORELANG['TXT_DASHBOARD_NEWS_ALERT'], ENT_QUOTES, CONTREXX_CHARSET),
            'TXT_DASHBOARD_STATS_ALERT'     => htmlentities($_CORELANG['TXT_DASHBOARD_STATS_ALERT'], ENT_QUOTES, CONTREXX_CHARSET),
        ));
        $objTemplate->setGlobalVariable('TXT_LOGOUT', $_CORELANG['TXT_LOGOUT']);
        
        if (Permission::checkAccess(17, 'static', true)) {
            $objTemplate->touchBlock('news_delete');
            $objTemplate->touchBlock('stats_delete');
        } else {
            $objTemplate->hideBlock('news_delete');
            $objTemplate->hideBlock('stats_delete');
        }
        $license = \Cx\Core_Modules\License\License::getCached($_CONFIG, $objDatabase);
        $message = $license->getMessage(true, \FWLanguage::getLanguageCodeById(BACKEND_LANG_ID), $_CORELANG);
        if ($message && strlen($message->getText()) && $message->showInDashboard()) {
            $licenseManager = new \Cx\Core_Modules\License\LicenseManager('', null, $_CORELANG, $_CONFIG, $objDatabase);
            $objTemplate->setVariable('MESSAGE_TITLE', contrexx_raw2xhtml($licenseManager->getReplacedMessageText($message)));
            $objTemplate->setVariable('MESSAGE_TYPE', contrexx_raw2xhtml($message->getType()));
            $objTemplate->setVariable('MESSAGE_LINK', contrexx_raw2xhtml($message->getLink()));
            $objTemplate->setVariable('MESSAGE_LINK_TARGET', contrexx_raw2xhtml($message->getLinkTarget()));
        }

        $objFWUser = FWUser::getFWUserObject();
        $objResult = $objDatabase->SelectLimit(
           'SELECT `logs`.`datetime`, `users`.`username`
            FROM `'.DBPREFIX.'log` AS `logs`
            LEFT JOIN `'.DBPREFIX.'access_users` AS `users`
            ON `users`.`id`=`logs`.`userid`
            ORDER BY `logs`.`id` DESC', 1);
        if ($objResult && $objResult->RecordCount() > 0) {
            $objTemplate->setVariable(array(
                'LAST_LOGIN_USERNAME' => contrexx_raw2xhtml($objResult->fields['username']),
                'LAST_LOGIN_TIME'     => date('d.m.Y', strtotime($objResult->fields['datetime'])),
            ));
            $objTemplate->parse('last_login');
        } else {
            $objTemplate->setVariable('LOG_ERROR_MESSAGE', $_CORELANG['TXT_NO_DATA_FOUND']);
        }

        if ($_CONFIG['dashboardStatistics'] == 'on') {
            $arrStatistics = $this->getStatistics();

            $objTemplate->setVariable(array(
                'STATS_TITLE'          => $_CORELANG['TXT_CORE_STATS_FROM'].' '.reset($arrStatistics['dates']).' - '.end($arrStatistics['dates']),
                'STATS_TICKS'          => json_encode($arrStatistics['ticks']),
                'STATS_DATES'          => json_encode($arrStatistics['dates']),
                'STATS_VISITORS'       => json_encode($arrStatistics['visitors']),
                'STATS_REQUESTS'       => json_encode($arrStatistics['requests']),
                'STATS_TOTAL_VISITORS' => array_sum($arrStatistics['visitors']),
                'STATS_TOTAL_REQUESTS' => array_sum($arrStatistics['requests']),
            ));
        } else {
            $objTemplate->hideBlock('stats');
            $objTemplate->hideBlock('stats_javascript');
        }

        /*$objRss = new XML_RSS('http://www.contrexx.com/feed/news_headlines_de.xml?version=' . $_CONFIG['coreCmsVersion']);
        $objRss->parse();
        $arrItems = $objRss->getItems();
        if (!empty($arrItems) && ($_CONFIG['dashboardNews'] == 'on')) {
            $objTemplate->setVariable(array(
                'NEWS_TITLE' => $arrItems[0]['title'],
                'NEWS_LINK'  => $arrItems[0]['link'],
            ));
            $objTemplate->parse('news');
        } else {*/
            $objTemplate->hideBlock('news');
        //}
    }

    private function getStatistics()
    {
        global $_CORELANG, $objDatabase;
        
        $rangeStart = date('j', strtotime('last month')) + 1;
        $rangeStart = $rangeStart > 31 ? 1 : $rangeStart;
        $rangeEnd   = date('j');
        $arrRange   = array();
        
        if ($rangeStart >= $rangeEnd) {
            $first = range($rangeStart, date('t', strtotime('last month')));
            $month = date('M', strtotime('last month'));
            foreach ($first as $day) {
                $arrRange[$day] = $day.' '.$month;
            }
            
            $second = range(1, $rangeEnd);
            $month  = date('M');
            foreach ($second as $day) {
                $arrRange[$day] = $day.' '.$month;
            }
        } else {
            $arrDays = range($rangeStart, $rangeEnd);
            $month = date('M');
            foreach ($arrDays as $day) {
                $arrRange[$day] = $day.' '.$month;
            }
        }
        
        $arrMonths   = explode(',', $_CORELANG['TXT_MONTH_ARRAY']);
        $arrDays     = explode(',', $_CORELANG['TXT_DAY_ARRAY']);
        $arrDays[7]  = $arrDays[0];
        unset($arrDays[0]);
        $arrVisitors = array();
        $arrRequests = array();
        $ticks       = array();
        $visitors    = array();
        $requests    = array();
        
        $query = '
            SELECT `timestamp`, `count`
            FROM `'.DBPREFIX.'stats_visitors_summary`
            WHERE `type` = "day"
            AND `timestamp` >= "'.
            mktime(
                0, 0, 0,
                $previousMonth = date('m') == 1 ? 12 : date('m') - 1,
                date('d') == date('t', mktime(0, 0, 0, $previousMonth, 0, $previousYear = (date('m') == 1 ? date('Y') -1 : date('Y')))) ? date('d') + 1 : 1,
                $previousYear
            ).'"
        ';
        $objResult = $objDatabase->Execute($query);
        
        while (!$objResult->EOF) {
            $day = date('j', $objResult->fields['timestamp']);
            $arrVisitors[$day] = $objResult->fields['count'];
            $objResult->MoveNext();
        }
        
        $query = '
            SELECT `timestamp`, `count`
            FROM `'.DBPREFIX.'stats_requests_summary`
            WHERE `type` = "day"
            AND `timestamp` >= "'.
            mktime(
                0, 0, 0,
                $previousMonth = date('m') == 1 ? 12 : date('m') - 1,
                date('d') == date('t', mktime(0, 0, 0, $previousMonth, 0, $previousYear = (date('m') == 1 ? date('Y') -1 : date('Y')))) ? date('d') + 1 : 1,
                $previousYear
            ).'"
        ';
        $objResult = $objDatabase->Execute($query);
    
        while (!$objResult->EOF) {
            $day = date('j', $objResult->fields['timestamp']);
            $arrRequests[$day] = $objResult->fields['count'];
            $objResult->MoveNext();
        }
        
        $i = 1;
        foreach ($arrRange as $day => $date) {
            $ticks[]    = $date;
            $timestamp  = strtotime($date);
            $dates[$i]  = $arrDays[date('N', $timestamp)].', '.date('j', $timestamp).'. '.$arrMonths[date('n', $timestamp) - 1].' '.date('Y', $timestamp);
            $visitors[] = isset($arrVisitors[$day]) ? intval($arrVisitors[$day]) : 0;
            $requests[] = isset($arrRequests[$day]) ? intval($arrRequests[$day]) : 0;
            $i++;
        }
        
        return array(
            'ticks'    => $ticks,
            'dates'    => $dates,
            'visitors' => $visitors,
            'requests' => $requests,
        );
    }
    
    private function deactivateSetting($id)
    {
        global $objDatabase;
        
        if (Permission::checkAccess(17, 'static', true)) {
            $query = '
                UPDATE `'.DBPREFIX.'settings`
                SET `setvalue` = "off"
                WHERE `setid` = '.$id.'
            ';
            $objResult = $objDatabase->Execute($query);
            
            if ($objResult) {
                $objSettings = new settingsManager();
                $objSettings->writeSettingsFile();
                die('success');
            }
        }
        
        die('error');
    }
}

?>
