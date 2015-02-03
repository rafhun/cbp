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
 * Calendar 
 * 
 * @package    contrexx
 * @subpackage module_calendar
 * @author     Comvation <info@comvation.com>
 * @copyright  CONTREXX CMS - COMVATION AG
 * @version    1.00
 */


/**
 * CalendarAdmin
 * 
 * @package    contrexx
 * @subpackage module_calendar
 * @author     Comvation <info@comvation.com>
 * @copyright  CONTREXX CMS - COMVATION AG
 * @version    1.00
 */
class CalendarManager extends CalendarLibrary
{
    /**
     * Page title
     *
     * @access private
     * @var string 
     */
    var $_pageTitle;
    
    /**
     * Action Name
     *
     * @access public
     * @var string
     */
    public $act = '';

    /**
     * Constructor   -> Create the module-menu and an internal template-object
     * @global array  $_ARRAYLANG
     * @global object $objTemplate
     */
    function __construct()
    {
        global $_ARRAYLANG, $objTemplate;
                
        parent::__construct(ASCMS_MODULE_PATH.'/'.$this->moduleName.'/template');  
        
        $this->act = $_REQUEST['act'];
        
        $contentNavigation = '<a href="index.php?cmd='.$this->moduleName.'" class="'.($this->act == '' ? 'active' : '').'">'.$_ARRAYLANG['TXT_CALENDAR_MENU_OVERVIEW'].' </a>';
        $contentNavigation .= Permission::checkAccess(180, 'static', true) ? '<a href="index.php?cmd='.$this->moduleName.'&amp;act=modify_event" class="'.($this->act == 'modify_event' ? 'active' : '').'">'.$_ARRAYLANG['TXT_CALENDAR_NEW_EVENT'].' </a>' : '';              
        $contentNavigation .= Permission::checkAccess(165, 'static', true) ? '<a href="index.php?cmd='.$this->moduleName.'&amp;act=categories" class="'.($this->act == 'categories' ? 'active' : '').'">'.$_ARRAYLANG['TXT_CALENDAR_CATEGORIES'].' </a>' : '';                
        $contentNavigation .= Permission::checkAccess(181, 'static', true) ? '<a href="index.php?cmd='.$this->moduleName.'&amp;act=settings" class="'.($this->act == 'settings' ? 'active' : '').'">'.$_ARRAYLANG['TXT_CALENDAR_MENU_SETTINGS'].' </a>' : '';             
        
        $objTemplate->setVariable("CONTENT_NAVIGATION", $contentNavigation);
    }

    /**
    * Perform the right operation depending on the $_GET-params
    *
    * @global   \Cx\Core\Html\Sigma
    */
    function getCalendarPage()
    {
        global $objTemplate, $objDatabase, $_ARRAYLANG;
        
        switch ($_GET['act']) {
            case 'settings':
                Permission::checkAccess(181, 'static');
                $this->showSettings();
                break;
            case 'categories':              
                Permission::checkAccess(165, 'static');
                $this->showCategories();
                break;
            case 'modify_event':
                Permission::checkAccess(180, 'static');
                $this->modifyEvent(intval($_GET['id']));
                break;
            case 'export_registrations':
                Permission::checkAccess(182, 'static');
                $this->exportRegistrations(intval($_GET['id']), $_GET['tpl']);
                break;
            case 'event_registrations':
                Permission::checkAccess(182, 'static');
                $this->showEventRegistrations(intval($_GET['id']));
                break;
            case 'modify_registration':
            case 'add_registration':    
                Permission::checkAccess(182, 'static');
                $this->modifyRegistration(intval($_GET['event_id']), intval($_GET['reg_id']));
                break;
            case 'get_exception_dates':
                $this->getExeceptionDates();
                break;
            default:
                $this->showOverview();
                break;
        } 
        
        $objTemplate->setVariable(array(
            'CONTENT_OK_MESSAGE'        => $this->okMessage,
            'CONTENT_STATUS_MESSAGE'    => $this->errMessage,
            'ADMIN_CONTENT'             => $this->_objTpl->get(),
            'CONTENT_TITLE'             => $this->_pageTitle,
        ));
    }
    
    /**
     * Perform the overview page functionalities
     * 
     * @return null
     */
    function showOverview(){
        global $objDatabase, $_ARRAYLANG, $_CORELANG;
        
        $this->_objTpl->loadTemplateFile('module_calendar_overview.html');
        $this->_pageTitle = $_ARRAYLANG['TXT_CALENDAR_MENU_OVERVIEW'];
        
        parent::getSettings();
        
        if(isset($_GET['switch_status'])) {
            Permission::checkAccess(180, 'static');  
            
            $objEvent = new CalendarEvent(intval($_GET['switch_status']));
            if($objEvent->switchStatus()) {
                $this->okMessage = $_ARRAYLANG['TXT_CALENDAR_EVENT_SUCCESSFULLY_EDITED'];
            } else {
                 $this->errMessage = $_ARRAYLANG['TXT_CALENDAR_EVENT_CORRUPT_EDITED'];
            }
        }
        
        if(isset($_GET['delete'])) {
            Permission::checkAccess(180, 'static');  
            
            $objEvent = new CalendarEvent(intval($_GET['delete']));
            if($objEvent->delete()) {
                $this->okMessage = $_ARRAYLANG['TXT_CALENDAR_EVENT_SUCCESSFULLY_DELETED'];
            } else {
                 $this->errMessage = $_ARRAYLANG['TXT_CALENDAR_EVENT_CORRUPT_DELETED'];
            }
        }
        
        if(isset($_GET['confirm'])) {
            Permission::checkAccess(180, 'static');  
            
            $objEvent = new CalendarEvent(intval($_GET['confirm']));
            if($objEvent->confirm()) {
                $this->okMessage = $_ARRAYLANG['TXT_CALENDAR_EVENT_SUCCESSFULLY_EDITED'];  
            } else {
                $this->errMessage = $_ARRAYLANG['TXT_CALENDAR_EVENT_CORRUPT_EDITED'];   
            }
        }
        
        if(isset($_GET['export'])) {
            $objEvent = new CalendarEvent(intval($_GET['export']));
            $objEvent->export();    
        }
        
        if(isset($_GET['multi'])) {
            Permission::checkAccess(180, 'static');   
                                    
            $status = true;  
            $messageVar = 'EDITED';
            
            foreach($_POST['selectedEventId'] as $key => $eventId) {     
                $objEvent = new CalendarEvent(intval($eventId)); 
                
                switch($_GET['multi']) {
                    case 'delete':
                        $status = $objEvent->delete() ? true : false; 
                        $messageVar = 'DELETED';
                        break; 
                    case 'activate':
                        $objEvent->status = 0;
                        $status = $objEvent->switchStatus() ? true : false;
                        $messageVar = 'EDITED';
                        break;      
                    case 'deactivate':
                        $objEvent->status = 1;
                        $status = $objEvent->switchStatus() ? true : false;
                        $messageVar = 'EDITED';
                        break;        
                    case 'export':                                                
                        $objEvent->export();              
                        break;
                }  
            }
            
            if($status) {
                $this->okMessage = $_ARRAYLANG['TXT_CALENDAR_EVENT_SUCCESSFULLY_'.$messageVar];
            } else {
                 $this->errMessage = $_ARRAYLANG['TXT_CALENDAR_EVENT_CORRUPT_'.$messageVar];
            }
        }
        
        $categoryId = intval($_REQUEST['categoryId']) != 0 ? $categoryId = intval($_REQUEST['categoryId']) : $categoryId = null;
        $searchTerm =  isset($_REQUEST['term']) ? $_REQUEST['term'] : $searchTerm = $_ARRAYLANG['TXT_CALENDAR_KEYWORD'];
        $startPos =  isset($_REQUEST['pos']) ? $_REQUEST['pos'] : 0;
        
        $listType = 'all';
        if($_GET['list'] == 'actual' || !isset($_GET['list'])) {
            $styleListActual = 'underline';  
            $styleListAll = '';                                 
            $startDate = mktime(); 
            $listType = 'upcoming';
        } else {
            $styleListActual = '';  
            $styleListAll = 'underline';                                  
            $startDate = null; 
        }                 
        
        $this->_objTpl->setGlobalVariable(array(
            'TXT_'.$this->moduleLangVar.'_OVERVIEW'                 => $this->_pageTitle,
            'TXT_'.$this->moduleLangVar.'_UPCOMING_EVENTS'          => $_ARRAYLANG['TXT_CALENDAR_UPCOMING_EVENTS'],
            'TXT_'.$this->moduleLangVar.'_ALL_EVENTS'               => $_ARRAYLANG['TXT_CALENDAR_ALL_EVENTS'],
            'TXT_'.$this->moduleLangVar.'_FILTER'                   => $_ARRAYLANG['TXT_CALENDAR_FILTER'],
            'TXT_'.$this->moduleLangVar.'_CONFIRMLIST'              => $_ARRAYLANG['TXT_CALENDAR_CONFIRMLIST'],
            'TXT_SEARCH'                                            => $_CORELANG['TXT_USER_SEARCH'],
            'TXT_'.$this->moduleLangVar.'_SEARCH'                   => $_CORELANG['TXT_USER_SEARCH'],
            'TXT_'.$this->moduleLangVar.'_KEYWORD'                  => $searchTerm,
            'TXT_'.$this->moduleLangVar.'_EVENTS'                   => $_ARRAYLANG['TXT_CALENDAR_EVENTS'],
            'TXT_'.$this->moduleLangVar.'_STATUS'                   => $_ARRAYLANG['TXT_CALENDAR_STATUS'],
            'TXT_'.$this->moduleLangVar.'_DATE'                     => $_ARRAYLANG['TXT_CALENDAR_DATE'],
            'TXT_'.$this->moduleLangVar.'_TITLE'                    => $_ARRAYLANG['TXT_CALENDAR_TITLE'],
            'TXT_'.$this->moduleLangVar.'_CATEGORY'                 => $_ARRAYLANG['TXT_CALENDAR_CATEGORY'],
            'TXT_'.$this->moduleLangVar.'_SERIES'                   => $_ARRAYLANG['TXT_CALENDAR_SERIES'],
            'TXT_'.$this->moduleLangVar.'_RE_DEREGISTRATIONS'       => $_ARRAYLANG['TXT_CALENDAR_RE_DEGISTRATIONS'],
            'TXT_'.$this->moduleLangVar.'_REGISTRATIONS'            => $_ARRAYLANG['TXT_CALENDAR_REGISTRATIONS'],
            'TXT_'.$this->moduleLangVar.'_WAITLIST'                 => $_ARRAYLANG['TXT_CALENDAR_WAITLIST'],
            'TXT_'.$this->moduleLangVar.'_ACTION'                   => $_ARRAYLANG['TXT_CALENDAR_ACTION'],
            'TXT_'.$this->moduleLangVar.'_EXPORT_ICAL_FORMAT'       => $_ARRAYLANG['TXT_CALENDAR_EXPORT_ICAL_FORMAT'],
            'TXT_'.$this->moduleLangVar.'_EDIT'                     => $_ARRAYLANG['TXT_CALENDAR_EDIT'],
            'TXT_'.$this->moduleLangVar.'_COPY'                     => $_ARRAYLANG['TXT_CALENDAR_COPY'],
            'TXT_'.$this->moduleLangVar.'_DELETE'                   => $_ARRAYLANG['TXT_CALENDAR_DELETE'],
            'TXT_'.$this->moduleLangVar.'_LANGUAGES'                => $_ARRAYLANG['TXT_CALENDAR_LANGUAGES'],
            'TXT_SELECT_ALL'                                        => $_ARRAYLANG['TXT_CALENDAR_MARK_ALL'],
            'TXT_DESELECT_ALL'                                      => $_ARRAYLANG['TXT_CALENDAR_REMOVE_CHOICE'],
            'TXT_SUBMIT_SELECT'                                     => $_ARRAYLANG['TXT_SUBMIT_SELECT'],
            'TXT_SUBMIT_ACTIVATE'                                   => $_ARRAYLANG['TXT_SUBMIT_ACTIVATE'],
            'TXT_SUBMIT_DEACTIVATE'                                 => $_ARRAYLANG['TXT_SUBMIT_DEACTIVATE'],
            'TXT_SUBMIT_DELETE'                                     => $_ARRAYLANG['TXT_SUBMIT_DELETE'],
            'TXT_SUBMIT_EXPORT'                                     => $_ARRAYLANG['TXT_SUBMIT_EXPORT'],
            'TXT_'.$this->moduleLangVar.'_CONFIRM_DELETE_DATA'      => $_ARRAYLANG['TXT_CALENDAR_CONFIRM_DELETE_DATA'],
            'TXT_'.$this->moduleLangVar.'_ACTION_IS_IRREVERSIBLE'   => $_ARRAYLANG['TXT_CALENDAR_ACTION_IS_IRREVERSIBLE'],
            'TXT_'.$this->moduleLangVar.'_MAKE_SELECTION'           => $_ARRAYLANG['TXT_CALENDAR_MAKE_SELECTION'],
            'TXT_'.$this->moduleLangVar.'_LIST_ACTUAL'              => $_ARRAYLANG['TXT_CALENDAR_LIST_ACTUAL'],
            'TXT_'.$this->moduleLangVar.'_LIST_ALL'                 => $_ARRAYLANG['TXT_CALENDAR_LIST_ALL'],
            $this->moduleLangVar.'_LINKSTYLE_LIST_ACTUAL'           => $styleListActual,
            $this->moduleLangVar.'_LINKSTYLE_LIST_ALL'              => $styleListAll,
        ));
        
        $objCategoryManager = new CalendarCategoryManager(true);
        $objCategoryManager->getCategoryList();
        
        $this->_objTpl->setVariable(array(
            'CALENDAR_CATEGORIES' => $objCategoryManager->getCategoryDropdown($categoryId, 1),
        ));  
        
        $objConfirmEventManager = new CalendarEventManager(null,null,null,null,null,null,true,null,null,false,null);  
        $objConfirmEventManager->getEventList();                 
        
        if(count($objConfirmEventManager->eventList) > 0) {                 
            $objConfirmEventManager->showEventList($this->_objTpl, 'confirm');        
        } else {
           $this->_objTpl->hideBlock('showConfirmList');   
        }       
        
        if($this->arrSettings['rssFeedStatus'] == 1) {
            $objFeedEventManager = new CalendarEventManager(mktime(),null,null,null,true);
            $objFeed = new CalendarFeed($objFeedEventManager);
            $objFeed->creatFeed();   
        }                                                                             
        
        $showSeries = ($listType == 'upcoming');        
        $objEventManager = new CalendarEventManager($startDate,$endDate,$categoryId,$searchTerm,$showSeries,null,null,$startPos,$this->arrSettings['numPaging'], 'ASC', true, null, $listType);
        $objEventManager->getEventList();
        
        if($objEventManager->countEvents > $this->arrSettings['numPaging']) {
            $pagingCategory = !empty($categoryId) ? '&amp;categoryId='.$categoryId : '';
            $pagingTerm = !empty($searchTerm) ? '&amp;term='.$searchTerm : '';
            $pagingList = !empty($_GET['list']) ? '&amp;list='.$_GET['list'] : '';

            $this->_objTpl->setVariable(array(
                $this->moduleLangVar.'_PAGING' =>  getPaging($objEventManager->countEvents, $startPos, "&cmd=".$this->moduleName.$pagingCategory.$pagingTerm.$pagingList, "<b>".$_ARRAYLANG['TXT_CALENDAR_EVENTS']."</b>", true, $this->arrSettings['numPaging']),
            ));
        }   
                                             
        $objEventManager->showEventList($this->_objTpl);
    }
    
    
    /**
     * Add / Edit of the Event
     *      
     * @param integer $eventId Event id
     * 
     * @return null
     */
    function modifyEvent($eventId){
        global $objDatabase, $_ARRAYLANG, $_CORELANG, $_LANGID;
        
        $this->_objTpl->loadTemplateFile('module_calendar_modify_event.html');
        JS::registerJS("modules/{$this->moduleName}/View/Script/jquery.pagination.js");
        
        parent::getSettings();
        parent::getFrontendLanguages();
        if(isset($_POST['submitModifyEvent']) || isset($_POST['save_and_publish'])) {
        	$objEvent = new CalendarEvent();
	        
	        if($objEvent->save($_POST)) {
                    $this->okMessage = $_ARRAYLANG['TXT_CALENDAR_EVENT_SUCCESSFULLY_SAVED'];
                    
                    if (isset($_POST['save_and_publish'])) {
                        Permission::checkAccess(180, 'static');

                        if($objEvent->confirm()) {
                            // do nothing
                        } else {
                            $this->errMessage = $_ARRAYLANG['TXT_CALENDAR_EVENT_CORRUPT_EDITED'];   
                        }
                    }
                    
                    $this->showOverview();
                    return;
	        } else {
                    $this->errMessage = $_ARRAYLANG['TXT_CALENDAR_EVENT_CORRUPT_SAVED']; 
	        }
            
                if($this->arrSettings['rssFeedStatus'] == 1) {
                    $objFeedEventManager = new CalendarEventManager(mktime(),null,null,null,true);
                    $objFeed = new CalendarFeed($objFeedEventManager);
                    $objFeed->creatFeed();   
                }     
        }
        
        $dateFomat = parent::getDateFormat();
        
        $objCategoryManager = new CalendarCategoryManager(true);   
        $objCategoryManager->getCategoryList();  
        
        $objFormManager = new CalendarFormManager(true);   
        $objFormManager->getFormList();   
        
        $objMail = new CalendarMail();
        $objMail->getTemplateList();
                
        $copy = isset($_REQUEST['copy']) && !empty($_REQUEST['copy']);
        $this->_pageTitle = $copy || empty($eventId) ? $_ARRAYLANG['TXT_CALENDAR_INSERT_EVENT'] : $_ARRAYLANG['TXT_CALENDAR_EVENT']." ".$_ARRAYLANG['TXT_CALENDAR_EDIT'];
        
        if($eventId != 0) {
            $objEvent = new CalendarEvent($eventId);
            $objEvent->getData();  
        }
        
        //parse weekdays
        $arrWeekdays = array(
            "1000000" => $_ARRAYLANG['TXT_CALENDAR_DAYS_MONDAY'],
            "0100000" => $_ARRAYLANG['TXT_CALENDAR_DAYS_TUESDAY'],
            "0010000" => $_ARRAYLANG['TXT_CALENDAR_DAYS_WEDNESDAY'],
            "0001000" => $_ARRAYLANG['TXT_CALENDAR_DAYS_THURSDAY'],
            "0000100" => $_ARRAYLANG['TXT_CALENDAR_DAYS_FRIDAY'],
            "0000010" => $_ARRAYLANG['TXT_CALENDAR_DAYS_SATURDAY'],
            "0000001" => $_ARRAYLANG['TXT_CALENDAR_DAYS_SUNDAY'],
        );
        
        foreach ($arrWeekdays as $value => $name) {
            $selectedWeekday = $value == $objEvent->seriesData['seriesPatternWeekday'] ? 'selected="selected"' : ''; 
            $weekdays .= '<option value="'.$value.'" '.$selectedWeekday.'>'.$name.'</option>';
        }           

        //parse count  
        $arrCount = array(
            1 => $_ARRAYLANG['TXT_CALENDAR_SERIES_PATTERN_FIRST'],
            2 => $_ARRAYLANG['TXT_CALENDAR_SERIES_PATTERN_SECOND'],
            3 => $_ARRAYLANG['TXT_CALENDAR_SERIES_PATTERN_THIRD'],
            4 => $_ARRAYLANG['TXT_CALENDAR_SERIES_PATTERN_FOURTH'],
            5 => $_ARRAYLANG['TXT_CALENDAR_SERIES_PATTERN_LAST'],
        );
        
        foreach ($arrCount as $value => $name) { 
            $selectedCount = $value == $objEvent->seriesData['seriesPatternCount'] ? 'selected="selected"' : '';  
            $count .= '<option value="'.$value.'" '.$selectedCount.'>'.$name.'</option>';
        }
                        
        if (empty($eventId)) {
            $startDate = new DateTime("NOW");
            $startMin  = (int) $startDate->format('i');
            // Adjust the time to next half hour
            if (!in_array($startMin, array(0, 30))) {
                $minAdj = (60 - $startMin) > 30 ? (30 - $startMin) : (60 - $startMin);
                $startDate->setTime($startDate->format('H'), $startDate->format('i') + $minAdj, 00);
            }
            $endDate   = clone $startDate;
            $endDate->modify("+30 mins");
        }
        
        //parse globals  
        $this->_objTpl->setGlobalVariable(array(
            'TXT_'.$this->moduleLangVar.'_TITLE'                            => $this->_pageTitle,
            'TXT_'.$this->moduleLangVar.'_EVENT'                            => $_ARRAYLANG['TXT_CALENDAR_EVENT'],
            'TXT_'.$this->moduleLangVar.'_SAVE'                             => $_ARRAYLANG['TXT_CALENDAR_SAVE'],
            'TXT_'.$this->moduleLangVar.'_DELETE'                             => $_ARRAYLANG['TXT_CALENDAR_DELETE'],
            'TXT_'.$this->moduleLangVar.'_CANCEL'                           => $_CORELANG['TXT_CANCEL'],      
            'TXT_'.$this->moduleLangVar.'_EXPAND'                           => $_ARRAYLANG['TXT_CALENDAR_EXPAND'],
            'TXT_'.$this->moduleLangVar.'_MINIMIZE'                         => $_ARRAYLANG['TXT_CALENDAR_MINIMIZE'],
            'TXT_'.$this->moduleLangVar.'_EVENT_DETAILS'                    => $_ARRAYLANG['TXT_CALENDAR_EVENT_DETAILS'],
            'TXT_'.$this->moduleLangVar.'_EVENT_INVITE'                     => $_ARRAYLANG['TXT_CALENDAR_EVENT_INVITE'],
            'TXT_'.$this->moduleLangVar.'_EVENT_SERIES'                     => $_ARRAYLANG['TXT_CALENDAR_EVENT_SERIES'],
            'TXT_'.$this->moduleLangVar.'_EVENT_SERIES_TYPE'                => $_ARRAYLANG['TXT_CALENDAR_EVENT_SERIES_TYPE'],
            'TXT_'.$this->moduleLangVar.'_EVENT_SERIES_PATTERN'             => $_ARRAYLANG['TXT_CALENDAR_EVENT_SERIES_PATTERN'],
            'TXT_'.$this->moduleLangVar.'_EVENT_SERIES_EXCEPTIONS'          => $_ARRAYLANG['TXT_CALENDAR_EVENT_SERIES_EXCEPTIONS'],
            'TXT_'.$this->moduleLangVar.'_EVENT_PUBLICATE'                  => $_ARRAYLANG['TXT_CALENDAR_EVENT_PUBLICATE'],
            'TXT_'.$this->moduleLangVar.'_YES'                              => $_ARRAYLANG['TXT_CALENDAR_YES'],
            'TXT_'.$this->moduleLangVar.'_NEXT'                             => $_ARRAYLANG['TXT_CALENDAR_NEXT'],
            'TXT_'.$this->moduleLangVar.'_BACK'                             => $_ARRAYLANG['TXT_CALENDAR_STEP_BACK'],
            'TXT_'.$this->moduleLangVar.'_EVENT_PRIORITY'                   => $_ARRAYLANG['TXT_CALENDAR_EVENT_PRIORITY'],
            'TXT_'.$this->moduleLangVar.'_EVENT_START'                      => $_ARRAYLANG['TXT_CALENDAR_EVENT_START'],
            'TXT_'.$this->moduleLangVar.'_EVENT_END'                        => $_ARRAYLANG['TXT_CALENDAR_EVENT_END'],
            'TXT_'.$this->moduleLangVar.'_EVENT_ACCESS'                     => $_ARRAYLANG['TXT_CALENDAR_EVENT_ACCESS'],
            'TXT_'.$this->moduleLangVar.'_EVENT_WHOLE_DAY'                  => $_ARRAYLANG['TXT_CALENDAR_EVENT_WHOLE_DAY'],
            'TXT_'.$this->moduleLangVar.'_BROWSE'                           => $_ARRAYLANG['TXT_CALENDAR_BROWSE'],
            'TXT_'.$this->moduleLangVar.'_ACTIVATE'                         => $_ARRAYLANG['TXT_CALENDAR_ACTIVATE'],
            'TXT_'.$this->moduleLangVar.'_EVENT_PRICE'                      => $_ARRAYLANG['TXT_CALENDAR_PRICE'],
            'TXT_'.$this->moduleLangVar.'_EVENT_LINK'                       => $_ARRAYLANG['TXT_CALENDAR_EVENT_LINK'],
            'TXT_'.$this->moduleLangVar.'_EVENT_PICTURE'                    => $_ARRAYLANG['TXT_CALENDAR_EVENT_PICTURE'],
            'TXT_'.$this->moduleLangVar.'_EVENT_ATTACHMENT'                 => $_ARRAYLANG['TXT_CALENDAR_EVENT_ATTACHMENT'],
            'TXT_'.$this->moduleLangVar.'_EVENT_CATEGORY'                   => $_ARRAYLANG['TXT_CALENDAR_CATEGORY'],
            'TXT_'.$this->moduleLangVar.'_COMMUNITY_GROUPS'                 => $_ARRAYLANG['TXT_CALENDAR_COMMUNITY_GROUPS'],
            'TXT_'.$this->moduleLangVar.'_PLEASE_CHECK_INPUT'               => $_ARRAYLANG['TXT_CALENDAR_PLEASE_CHECK_INPUT'],
            'TXT_'.$this->moduleLangVar.'_EVENT_MORE_INVITATIONS'           => $_ARRAYLANG['TXT_CALENDAR_EVENT_MORE_INVITATIONS'],
            'TXT_'.$this->moduleLangVar.'_EVENT_REGISTRATION'               => $_ARRAYLANG['TXT_CALENDAR_EVENT_REGISTRATION'],
            'TXT_'.$this->moduleLangVar.'_EVENT_NUM_SUBSCRIBER'             => $_ARRAYLANG['TXT_CALENDAR_EVENT_NUM_SUBSCRIBER'],
            'TXT_'.$this->moduleLangVar.'_EVENT_NOTIFICATION_TO'            => $_ARRAYLANG['TXT_CALENDAR_EVENT_NOTIFICATION_TO'],
            'TXT_'.$this->moduleLangVar.'_EVENT_EMAIL_TEMPLATE'             => $_ARRAYLANG['TXT_CALENDAR_EVENT_EMAIL_TEMPLATE'],
            'TXT_'.$this->moduleLangVar.'_EVENT_TICKET_SALES'               => $_ARRAYLANG['TXT_CALENDAR_EVENT_TICKET_SALES'],
            'TXT_'.$this->moduleLangVar.'_EVENT_NUM_SEATING'                => $_ARRAYLANG['TXT_CALENDAR_EVENT_NUM_SEATING'],
            'TXT_'.$this->moduleLangVar.'_SERIES_PATTERN'                   => $_ARRAYLANG['TXT_CALENDAR_SERIES_PATTERN'],
            'TXT_'.$this->moduleLangVar.'_SERIES_PATTERN_DURANCE'           => $_ARRAYLANG['TXT_CALENDAR_SERIES_PATTERN_DURANCE'],
            'TXT_'.$this->moduleLangVar.'_SERIES_ACTIVATE'                  => $_ARRAYLANG['TXT_CALENDAR_SERIES_ACTIVATE'],
            'TXT_'.$this->moduleLangVar.'_SERIES'                           => $_ARRAYLANG['TXT_CALENDAR_SERIES'],
            'TXT_'.$this->moduleLangVar.'_SERIES_PATTERN_DAILY'             => $_ARRAYLANG['TXT_CALENDAR_SERIES_PATTERN_DAILY'],
            'TXT_'.$this->moduleLangVar.'_SERIES_PATTERN_WEEKLY'            => $_ARRAYLANG['TXT_CALENDAR_SERIES_PATTERN_WEEKLY'],
            'TXT_'.$this->moduleLangVar.'_SERIES_PATTERN_MONTHLY'           => $_ARRAYLANG['TXT_CALENDAR_SERIES_PATTERN_MONTHLY'],     
            'TXT_'.$this->moduleLangVar.'_DAYS'                             => $_ARRAYLANG['TXT_CALENDAR_DAYS'],
            'TXT_'.$this->moduleLangVar.'_DAYS_DAY'                         => $_ARRAYLANG['TXT_CALENDAR_DAYS_DAY'],
            'TXT_'.$this->moduleLangVar.'_DAYS_MONDAY'                      => $_ARRAYLANG['TXT_CALENDAR_DAYS_MONDAY'],
            'TXT_'.$this->moduleLangVar.'_DAYS_TUESDAY'                     => $_ARRAYLANG['TXT_CALENDAR_DAYS_TUESDAY'],
            'TXT_'.$this->moduleLangVar.'_DAYS_WEDNESDAY'                   => $_ARRAYLANG['TXT_CALENDAR_DAYS_WEDNESDAY'],
            'TXT_'.$this->moduleLangVar.'_DAYS_THURSDAY'                    => $_ARRAYLANG['TXT_CALENDAR_DAYS_THURSDAY'],
            'TXT_'.$this->moduleLangVar.'_DAYS_FRIDAY'                      => $_ARRAYLANG['TXT_CALENDAR_DAYS_FRIDAY'],
            'TXT_'.$this->moduleLangVar.'_DAYS_SATURDAY'                    => $_ARRAYLANG['TXT_CALENDAR_DAYS_SATURDAY'],
            'TXT_'.$this->moduleLangVar.'_DAYS_SUNDAY'                      => $_ARRAYLANG['TXT_CALENDAR_DAYS_SUNDAY'],
            'TXT_'.$this->moduleLangVar.'_DAYS_WORKDAY'                     => $_ARRAYLANG['TXT_CALENDAR_DAYS_WORKDAY'],  
            'TXT_'.$this->moduleLangVar.'_AT'                               => $_ARRAYLANG['TXT_CALENDAR_AT'],
            'TXT_'.$this->moduleLangVar.'_EVERY_1'                          => $_ARRAYLANG['TXT_CALENDAR_EVERY_1'],
            'TXT_'.$this->moduleLangVar.'_ALL'                              => $_ARRAYLANG['TXT_CALENDAR_ALL'],
            'TXT_'.$this->moduleLangVar.'_EVERY_2'                          => $_ARRAYLANG['TXT_CALENDAR_EVERY_2'],
            'TXT_'.$this->moduleLangVar.'_WEEKS'                            => $_ARRAYLANG['TXT_CALENDAR_WEEKS'],
            'TXT_'.$this->moduleLangVar.'_MONTHS'                           => $_ARRAYLANG['TXT_CALENDAR_MONTHS'],   
            'TXT_'.$this->moduleLangVar.'_SERIES_PATTERN_BEGINS'            => $_ARRAYLANG['TXT_CALENDAR_SERIES_PATTERN_BEGINS'],
            'TXT_'.$this->moduleLangVar.'_SERIES_PATTERN_NO_ENDDATE'        => $_ARRAYLANG['TXT_CALENDAR_SERIES_PATTERN_NO_ENDDATE'],
            'TXT_'.$this->moduleLangVar.'_SERIES_PATTERN_ENDS_AFTER'        => $_ARRAYLANG['TXT_CALENDAR_SERIES_PATTERN_ENDS_AFTER'],
            'TXT_'.$this->moduleLangVar.'_SERIES_PATTERN_APPONTMENTS'       => $_ARRAYLANG['TXT_CALENDAR_SERIES_PATTERN_APPONTMENTS'],
            'TXT_'.$this->moduleLangVar.'_SERIES_PATTERN_ENDS'              => $_ARRAYLANG['TXT_CALENDAR_SERIES_PATTERN_ENDS'],   
            'TXT_'.$this->moduleLangVar.'_EVENT_SEND_INVITATION'            => $objEvent->invitationSent == 0 ? $_ARRAYLANG['TXT_CALENDAR_EVENT_SEND_INVITATION'] : $_ARRAYLANG['TXT_CALENDAR_EVENT_SEND_AGAIN_INVITATION'],
            'TXT_'.$this->moduleLangVar.'_EVENT_TYPE'                       => $_ARRAYLANG['TXT_CALENDAR_EVENT_TYPE'],
            'TXT_'.$this->moduleLangVar.'_EVENT_TYPE_EVENT'                 => $_ARRAYLANG['TXT_CALENDAR_EVENT_TYPE_EVENT'],
            'TXT_'.$this->moduleLangVar.'_EVENT_TYPE_REDIRECT'              => $_ARRAYLANG['TXT_CALENDAR_EVENT_TYPE_REDIRECT'],
            'TXT_'.$this->moduleLangVar.'_EVENT_REGISTRATION_FORM'          => $_ARRAYLANG['TXT_CALENDAR_REGISTRATION_FORM'],
            'TXT_'.$this->moduleLangVar.'_EVENT_MORE_INVITATIONS_INFO'      => $_ARRAYLANG['TXT_CALENDAR_EVENT_MORE_INVITATIONS_INFO'],
            'TXT_'.$this->moduleLangVar.'_EVENT_NUM_SUBSCRIBER_INFO'        => $_ARRAYLANG['TXT_CALENDAR_EVENT_NUM_SUBSCRIBER_INFO'],
            'TXT_'.$this->moduleLangVar.'_EVENT_NOTIFICATION_TO_INFO'       => $_ARRAYLANG['TXT_CALENDAR_EVENT_NOTIFICATION_TO_INFO'],
            'TXT_'.$this->moduleLangVar.'_EVENT_EMAIL_TEMPLATE_INFO'        => $_ARRAYLANG['TXT_CALENDAR_EVENT_EMAIL_TEMPLATE_INFO'],
            'TXT_'.$this->moduleLangVar.'_EVENT_NUM_SEATING_INFO'           => $_ARRAYLANG['TXT_CALENDAR_EVENT_NUM_SEATING_INFO'],
            'TXT_'.$this->moduleLangVar.'_SHOW_START_DATE'                  => $_ARRAYLANG['TXT_CALENDAR_SHOW_START_DATE'],
            'TXT_'.$this->moduleLangVar.'_SHOW_END_DATE'                    => $_ARRAYLANG['TXT_CALENDAR_SHOW_END_DATE'],
            'TXT_'.$this->moduleLangVar.'_SHOW_TIME_TYPE'                   => $_ARRAYLANG['TXT_CALENDAR_SHOW_TIME_TYPE'],
            'TXT_'.$this->moduleLangVar.'_SHOW_START_TIME'                  => $_ARRAYLANG['TXT_CALENDAR_SHOW_START_TIME'],
            'TXT_'.$this->moduleLangVar.'_SHOW_END_TIME'                    => $_ARRAYLANG['TXT_CALENDAR_SHOW_END_TIME'],
            'TXT_'.$this->moduleLangVar.'_LIST'                             => $_ARRAYLANG['TXT_CALENDAR_LIST'],
            'TXT_'.$this->moduleLangVar.'_DETAIL'                           => $_ARRAYLANG['TXT_CALENDAR_DETAIL'],
            'TXT_'.$this->moduleLangVar.'_BASIC_DATA'                       => $_ARRAYLANG['TXT_CALENDAR_BASIC_DATA'],
            'TXT_'.$this->moduleLangVar.'_LANGUAGE'                         => $_ARRAYLANG['TXT_CALENDAR_LANG'],
            'TXT_'.$this->moduleLangVar.'_ADDITIONAL_OPTIONS'               => $_ARRAYLANG['TXT_CALENDAR_ADDITIONAL_OPTIONS'],
            'TXT_'.$this->moduleLangVar.'_EVENT_LOCATION'                   => $_ARRAYLANG['TXT_CALENDAR_EVENT_LOCATION'],            
            'TXT_'.$this->moduleLangVar.'_EVENT_ALL_DAY'                    => $_ARRAYLANG['TXT_CALENDAR_EVENT_ALL_DAY'],            
            'TXT_'.$this->moduleLangVar.'_EVENT_NAME'                       => $_ARRAYLANG['TXT_CALENDAR_EVENT_NAME'],            
            'TXT_'.$this->moduleLangVar.'_EVENT_HOST'                       => $_ARRAYLANG['TXT_CALENDAR_EVENT_HOST'],
            'TXT_'.$this->moduleLangVar.'_EVENT_EMAIL'                      => $_ARRAYLANG['TXT_CALENDAR_EVENT_EMAIL'],
            'TXT_'.$this->moduleLangVar.'_SELECT_EXCEPTION_DATE_INFO'       => $_ARRAYLANG['TXT_CALENDAR_SELECT_EXCEPTION_DATE_INFO'],
            'TXT_'.$this->moduleLangVar.'_OK'                               => $_ARRAYLANG['TXT_CALENDAR_OK'],    
            'TXT_'.$this->moduleLangVar.'_CANCEL'                           => $_ARRAYLANG['TXT_CALENDAR_CANCEL'],    
            'TXT_'.$this->moduleLangVar.'_MANAGE'                           => $_ARRAYLANG['TXT_CALENDAR_MANAGE'],
            'TXT_'.$this->moduleLangVar.'_EVENT_SHOW_IN'                    => $_ARRAYLANG['TXT_CALENDAR_EVENT_SHOW_IN'],
            'TXT_'.$this->moduleLangVar.'_EVENT_TITLE'                      => $_ARRAYLANG['TXT_CALENDAR_EVENT_TITLE'],
            'TXT_'.$this->moduleLangVar.'_EVENT_PLACE'                      => $_ARRAYLANG['TXT_CALENDAR_EVENT_PLACE'],
            'TXT_'.$this->moduleLangVar.'_EVENT_STREET'                     => $_ARRAYLANG['TXT_CALENDAR_EVENT_STREET'],
            'TXT_'.$this->moduleLangVar.'_EVENT_ZIP'                        => $_ARRAYLANG['TXT_CALENDAR_EVENT_ZIP'],
            'TXT_'.$this->moduleLangVar.'_EVENT_CITY'                       => $_ARRAYLANG['TXT_CALENDAR_EVENT_CITY'],
            'TXT_'.$this->moduleLangVar.'_EVENT_COUNTRY'                    => $_ARRAYLANG['TXT_CALENDAR_EVENT_COUNTRY'],
            'TXT_'.$this->moduleLangVar.'_EVENT_MAP'                        => $_ARRAYLANG['TXT_CALENDAR_EVENT_MAP'],
            'TXT_'.$this->moduleLangVar.'_EVENT_USE_GOOGLEMAPS'             => $_ARRAYLANG['TXT_CALENDAR_EVENT_USE_GOOGLEMAPS'],
            'TXT_'.$this->moduleLangVar.'_PLACE_DATA_DEFAULT'               => $_ARRAYLANG['TXT_CALENDAR_PLACE_DATA_DEFAULT'],
            'TXT_'.$this->moduleLangVar.'_PLACE_DATA_FROM_MEDIADIR'         => $_ARRAYLANG['TXT_CALENDAR_PLACE_DATA_FROM_MEDIADIR'],
            'TXT_'.$this->moduleLangVar.'_PREV'                             => $_ARRAYLANG['TXT_CALENDAR_PREV'],
            'TXT_'.$this->moduleLangVar.'_NEXT'                             => $_ARRAYLANG['TXT_CALENDAR_NEXT'],
            
            $this->moduleLangVar.'_EVENT_ID'                                => $eventId,
            $this->moduleLangVar.'_EVENT_DEFAULT_LANG_ID'                   => $_LANGID,
            $this->moduleLangVar.'_EVENT_DATE_FORMAT'                       => parent::getDateFormat(1),            
            $this->moduleLangVar.'_EVENT_CURRENCY'                          => $this->arrSettings['paymentCurrency'],
            $this->moduleLangVar.'_EVENT_CATEGORIES'                        => $objCategoryManager->getCategoryDropdown(intval($objEvent->catId), 2),
            $this->moduleLangVar.'_EVENT_SERIES_PATTERN_MONTHLY_COUNT'      => $count,
            $this->moduleLangVar.'_EVENT_SERIES_PATTERN_MONTHLY_WEEKDAY'    => $weekdays,
            $this->moduleLangVar.'_EVENT_REGISTRATION_FORMS'                => $objFormManager->getFormDorpdown(intval($objEvent->registrationForm)),
            
            $this->moduleLangVar.'_EVENT_TYPE_EVENT'                        => $eventId != 0 ? ($objEvent->type == 0 ? 'selected="selected"' : '') : '',      
            $this->moduleLangVar.'_EVENT_TYPE_REDIRECT'                     => $eventId != 0 ? ($objEvent->type == 1 ? 'selected="selected"' : '') : '',
            $this->moduleLangVar.'_EVENT_START_DATE'                        => $eventId != 0 ? date("$dateFomat H:i", $objEvent->startDate) : $startDate->format("$dateFomat H:i"),
            $this->moduleLangVar.'_EVENT_END_DATE'                          => $eventId != 0 ? date("$dateFomat H:i", $objEvent->endDate) : $endDate->format("$dateFomat H:i"),
            $this->moduleLangVar.'_EVENT_PRICE'                             => $eventId != 0 ? $objEvent->price : '',
            $this->moduleLangVar.'_EVENT_LINK'                              => $eventId != 0 ? $objEvent->link : '',
            $this->moduleLangVar.'_EVENT_PICTURE'                           => $eventId != 0 ? $objEvent->pic : '',
            $this->moduleLangVar.'_EVENT_ATTACHMENT'                        => $eventId != 0 ? $objEvent->attach : '',
            $this->moduleLangVar.'_EVENT_MORE_INVITATIONS'                  => $eventId != 0 ? $objEvent->invitedMails : '',
            $this->moduleLangVar.'_EVENT_REGISTRATION'                      => $eventId != 0 ? ($objEvent->registration == 1 ? 'checked="checked"' : '') : '',
            $this->moduleLangVar.'_EVENT_NUM_SUBSCRIBER'                    => $eventId != 0 ? $objEvent->numSubscriber : '',
            $this->moduleLangVar.'_EVENT_NOTIFICATION_TO'                   => $eventId != 0 ? $objEvent->notificationTo : '',
            $this->moduleLangVar.'_EVENT_TICKET_SALES'                      => $eventId != 0 ? ($objEvent->ticketSales ? 'checked="checked"' : '') : '',
            $this->moduleLangVar.'_EVENT_NUM_SEATING'                       => $eventId != 0 ? $objEvent->numSeating : '',
            $this->moduleLangVar.'_EVENT_ALL_DAY'                           => $eventId != 0 && $objEvent->all_day ? 'checked="checked"' : '',
            $this->moduleLangVar.'_HIDE_ON_SINGLE_LANG'                     => count($this->arrFrontendLanguages) == 1 ? "display: none;" : "",
            $this->moduleLangVar.'_LOCATION_TYPE'                           => $this->arrSettings['placeData'] == 3 ? ($eventId != 0 ? $objEvent->locationType : 1) : $this->arrSettings['placeData'],
            $this->moduleLangVar.'_EVENT_LOCATION_TYPE_MANUAL'              => $eventId != 0 ? ($objEvent->locationType == 1 ? "checked='checked'" : '') : "checked='checked'",
            $this->moduleLangVar.'_EVENT_LOCATION_TYPE_MEDIADIR'            => $eventId != 0 ? ($objEvent->locationType == 2 ? "checked='checked'" : '') : "",            
            $this->moduleLangVar.'_EVENT_PLACE'                             => $eventId != 0 ? $objEvent->place : '',
            $this->moduleLangVar.'_EVENT_STREET'                            => $eventId != 0 ? $objEvent->place_street : '',
            $this->moduleLangVar.'_EVENT_ZIP'                               => $eventId != 0 ? $objEvent->place_zip : '',
            $this->moduleLangVar.'_EVENT_CITY'                              => $eventId != 0 ? $objEvent->place_city : '',
            $this->moduleLangVar.'_EVENT_COUNTRY'                           => $eventId != 0 ? $objEvent->place_country : '',
            $this->moduleLangVar.'_EVENT_PLACE_LINK'                        => $eventId != 0 ? $objEvent->place_link : '', 
            $this->moduleLangVar.'_PLACE_MAP_SOURCE'                        => $eventId != 0 ? $objEvent->place_map : '',    
            //$this->moduleLangVar.'_EVENT_MAP'                               => $objEvent->map == 1 ? 'checked="checked"' : '',    
            $this->moduleLangVar.'_EVENT_HOST_TYPE'                         => $this->arrSettings['placeDataHost'] == 3 ? ($eventId != 0 ? $objEvent->hostType : 1) : $this->arrSettings['placeDataHost'],
            $this->moduleLangVar.'_EVENT_HOST'                              => $eventId != 0 ? $objEvent->org_name : '',
            $this->moduleLangVar.'_EVENT_HOST_ADDRESS'                      => $eventId != 0 ? $objEvent->org_street : '',
            $this->moduleLangVar.'_EVENT_HOST_ZIP'                          => $eventId != 0 ? $objEvent->org_zip : '',
            $this->moduleLangVar.'_EVENT_HOST_CITY'                         => $eventId != 0 ? $objEvent->org_city : '',
            $this->moduleLangVar.'_EVENT_HOST_COUNTRY'                      => $eventId != 0 ? $objEvent->org_country : '',
            $this->moduleLangVar.'_EVENT_HOST_LINK'                         => $eventId != 0 ? $objEvent->org_link : '',
            $this->moduleLangVar.'_EVENT_HOST_EMAIL'                        => $eventId != 0 ? $objEvent->org_email : '',
            $this->moduleLangVar.'_EVENT_HOST_TYPE_MANUAL'                  => $eventId != 0 ? ($objEvent->hostType == 1 ? "checked='checked'" : '') : "checked='checked'",
            $this->moduleLangVar.'_EVENT_HOST_TYPE_MEDIADIR'                => $eventId != 0 ? ($objEvent->hostType == 2 ? "checked='checked'" : '') : "",            
            $this->moduleLangVar.'_EVENT_COPY'                              => $copy ? 1 : 0,
        ));
        
        // parse invitation E-mail template
        foreach ($this->arrFrontendLanguages as $language) {
            $this->_objTpl->setVariable(array(
                $this->moduleLangVar.'_EVENT_INVITATION_EMAIL_LANG'     => \Html::getLanguageIcon($language['id'], 'active', 'javascript:void()'),
                $this->moduleLangVar.'_EVENT_INVITATION_EMAIL_LANG_ID'  => (int) $language['id'],
                $this->moduleLangVar.'_EVENT_INVITATION_EMAIL_TEMPLATE' => $objMail->getTemplateDropdown(intval($objEvent->invitationTemplate[$language['id']]), CalendarMailManager::MAIL_INVITATION, $language['id']),
            ));
            $this->_objTpl->parse('invitation_email_template');
            
            $this->_objTpl->setVariable(array(
                $this->moduleLangVar.'_EVENT_REGISTRATION_EMAIL_LANG'     => \Html::getLanguageIcon($language['id'], 'active', 'javascript:void()'),
                $this->moduleLangVar.'_EVENT_REGISTRATION_EMAIL_LANG_ID'  => (int) $language['id'],
                $this->moduleLangVar.'_EVENT_REGISTRATION_EMAIL_TEMPLATE' => $objMail->getTemplateDropdown(intval($objEvent->emailTemplate[$language['id']]), CalendarMailManager::MAIL_CONFIRM_REG, $language['id']),
            ));
            $this->_objTpl->parse('registration_email_template');
        }
        
        //parse access  
        for ($i = 0; $i < 2; $i++) {
            $selectedAccess = $eventId == 0 && $i == 0 ? 'selected="selected"' : $objEvent->access == $i ? 'selected="selected"' : '';
    
            $this->_objTpl->setVariable(array(
                $this->moduleLangVar.'_EVENT_ACCESS'            => $i,
                $this->moduleLangVar.'_EVENT_ACCESS_SELECT'     => $selectedAccess,
                $this->moduleLangVar.'_EVENT_ACCESS_NAME'       => $_ARRAYLANG['TXT_CALENDAR_EVENT_ACCESS_'.$i],
            ));
            
            $this->_objTpl->parse('eventAccess');
        }
        
        //parse priority   
        for ($i = 1; $i <= 5; $i++) {
        	$selectedPriority = $eventId == 0 && $i == 3 ? 'selected="selected"' : $objEvent->priority == $i ? 'selected="selected"' : '';
 	
        	$this->_objTpl->setVariable(array(
	            $this->moduleLangVar.'_EVENT_PRIORITY'          => $i,
                $this->moduleLangVar.'_EVENT_PRIORITY_SELECT'   => $selectedPriority,
	            $this->moduleLangVar.'_EVENT_PRIORITY_NAME'     => $_ARRAYLANG['TXT_CALENDAR_EVENT_PRIORITY_'.$i],
	        ));
	        
            $this->_objTpl->parse('eventPriority');
        }   
                
        //parse timetypes
        if($eventId != 0) {
            // list view
            $showStartDateList      = $objEvent->showStartDateList;
            $showEndDateList        = $objEvent->showEndDateList;
            $showStartTimeList      = $objEvent->showStartTimeList;
            $showEndTimeList        = $objEvent->showEndTimeList;
            $showTimeTypeList       = $objEvent->showTimeTypeList;
            // detail view
            $showStartDateDetail    = $objEvent->showStartDateDetail;
            $showEndDateDetail      = $objEvent->showEndDateDetail;
            $showStartTimeDetail    = $objEvent->showStartTimeDetail;
            $showEndTimeDetail      = $objEvent->showEndTimeDetail;
            $showTimeTypeDetail     = $objEvent->showTimeTypeDetail;
        } else {
            // list view
            $showStartDateList      = ($this->arrSettings['showStartDateList'] == 1);
            $showEndDateList        = ($this->arrSettings['showEndDateList'] == 1);
            $showStartTimeList      = ($this->arrSettings['showStartTimeList'] == 1);
            $showEndTimeList        = ($this->arrSettings['showEndTimeList'] == 1);
            // check if start- or endtime is selected in settings to set type "show time" by default
            if(!$_POST['showTimeTypeList'] && ($showStartTimeList == 1 || $showEndTimeList == 1)) {
                $showTimeTypeList       = 1;
            } else {
                $showTimeTypeList       = $_POST['showTimeTypeList'];
            }
            // detail view
            $showStartDateDetail    = ($this->arrSettings['showStartDateDetail'] == 1);
            $showEndDateDetail      = ($this->arrSettings['showEndDateDetail'] == 1);
            $showStartTimeDetail    = ($this->arrSettings['showStartTimeDetail'] == 1);
            $showEndTimeDetail      = ($this->arrSettings['showEndTimeDetail'] == 1);
            // check if start- or endtime is selected in settings to set type "show time" by default
            if(!$_POST['showTimeTypeDetail'] && ($showStartTimeDetail == 1 || $showEndTimeDetail == 1)) {
                $showTimeTypeDetail       = 1;
            } else {
                $showTimeTypeDetail       = $_POST['showTimeTypeDetail'];
            }
        }

        //time type dropdown for list
        $c = 0;
        $arrListOptions = array($_ARRAYLANG['TXT_CALENDAR_TIME_TYPE_NOTHING'], $_ARRAYLANG['TXT_CALENDAR_TIME_TYPE_TIME'], $_ARRAYLANG['TXT_CALENDAR_TIME_TYPE_FULLTIME']);
        $strTimeTypeListDropdown     =  '<select id="showTimeTypeList" name="showTimeTypeList" onchange="showTimeListSelection();" >';
                                        foreach( $arrListOptions as $key => $option )
                                        {
                                            ($c == $showTimeTypeList) ? $selected = 'selected="selected"' : $selected = '';
                                            $strTimeTypeListDropdown .= '<option value="'.$c.'" '.$selected.'  >'.$arrListOptions[$c].'</option>';
                                            $c++;
                                        }
        $strTimeTypeListDropdown    .=  '</select>';

        //time type dropdown for detail
        $c = 0;
        $arrDetailOptions = array($_ARRAYLANG['TXT_CALENDAR_TIME_TYPE_NOTHING'], $_ARRAYLANG['TXT_CALENDAR_TIME_TYPE_TIME'], $_ARRAYLANG['TXT_CALENDAR_TIME_TYPE_FULLTIME']);
        $strTimeTypeDetailDropdown     =  '<select id="showTimeTypeDetail" name="showTimeTypeDetail" onchange="showTimeDetailSelection();" >';
                                        foreach( $arrDetailOptions as $key => $option )
                                        {
                                            ($c == $showTimeTypeDetail) ? $selected = 'selected="selected"' : $selected = '';
                                            $strTimeTypeDetailDropdown .= '<option value="'.$c.'" '.$selected.'  >'.$arrDetailOptions[$c].'</option>';
                                            $c++;
                                        }
        $strTimeTypeDetailDropdown    .=  '</select>';

        //time type placeholders
        $this->_objTpl->setVariable(array(            
                $this->moduleLangVar.'_USE_CUSTOM_DATE_DISPLAY'         => ($objEvent->useCustomDateDisplay) ? 'checked="checked"' :'',
                $this->moduleLangVar.'_START_DATE_CHECKED_LIST'         => ($showStartDateList) ? 'checked="checked"' :'',
                $this->moduleLangVar.'_START_DATE_VALUE_LIST'           => 1,
                $this->moduleLangVar.'_END_DATE_CHECKED_LIST'           => ($showEndDateList) ? 'checked="checked"' :'',
                $this->moduleLangVar.'_END_DATE_VALUE_LIST'             => 1,
                $this->moduleLangVar.'_SHOW_TIME_TYPE_DROPDOWN_LIST'    => $strTimeTypeListDropdown,
                $this->moduleLangVar.'_START_TIME_CHECKED_LIST'         => ($showStartTimeList) ? 'checked="checked"' :'',
                $this->moduleLangVar.'_START_TIME_VALUE_LIST'           => 1,
                $this->moduleLangVar.'_END_TIME_CHECKED_LIST'           => ($showEndTimeList) ? 'checked="checked"' :'',
                $this->moduleLangVar.'_END_TIME_VALUE_LIST'             => 1,
                $this->moduleLangVar.'_START_DATE_CHECKED_DETAIL'       => ($showStartDateDetail) ? 'checked="checked"' :'',
                $this->moduleLangVar.'_START_DATE_VALUE_DETAIL'         => 1,
                $this->moduleLangVar.'_END_DATE_CHECKED_DETAIL'         => ($showEndDateDetail) ? 'checked="checked"' :'',
                $this->moduleLangVar.'_END_DATE_VALUE_DETAIL'           => 1,
                $this->moduleLangVar.'_SHOW_TIME_TYPE_DROPDOWN_DETAIL'  => $strTimeTypeDetailDropdown,
                $this->moduleLangVar.'_START_TIME_CHECKED_DETAIL'       => ($showStartTimeDetail) ? 'checked="checked"' :'',
                $this->moduleLangVar.'_START_TIME_VALUE_DETAIL'         => 1,
                $this->moduleLangVar.'_END_TIME_CHECKED_DETAIL'         => ($showEndTimeDetail) ? 'checked="checked"' :'',
                $this->moduleLangVar.'_END_TIME_VALUE_DETAIL'           => 1,
        ));
        
        //parse series
        $lastExeptionId = 4;
        $seriesStatus = $objEvent->seriesStatus == 1 ? 'checked="checked"' : '';
        
        $seriesPatternDailyDays   = 1;
        $seriesPatternWeeklyWeeks = 1;
        $seriesPatternMonthlyDay  = 1;
        $seriesPatternMonthl1     = 1;
        $seriesPatternMonthl2     = 1;
        $seriesPatternEndsEvents  = 5;
        if($eventId != 0 && $objEvent->seriesStatus == 1) {
            $seriesPatternDaily = $objEvent->seriesData['seriesType'] == 1 ? 'selected="selected"' : '';
            $seriesPatternWeekly = $objEvent->seriesData['seriesType'] == 2 ? 'selected="selected"' : '';
            $seriesPatternMonthly = $objEvent->seriesData['seriesType'] == 3 ? 'selected="selected"' : '';
            
            //daily
            if($objEvent->seriesData['seriesType'] == 1) {
                $seriesPatternDaily1 = $objEvent->seriesData['seriesPatternType'] == 1 ? 'checked="checked"' : '';
                $seriesPatternDaily2 = $objEvent->seriesData['seriesPatternType'] == 2 ? 'checked="checked"' : '';
                
                $seriesPatternDailyDays = $objEvent->seriesData['seriesPatternType'] == 1 ? $objEvent->seriesData['seriesPatternDay'] : 1;
            }
            
            //weekly
            if($objEvent->seriesData['seriesType'] == 2) {
                $seriesPatternWeeklyWeeks = $objEvent->seriesData['seriesPatternWeek'];
                
                $seriesPatternWeeklyMon = substr($objEvent->seriesData['seriesPatternWeekday'],0,1) == 1 ?  'checked="checked"' : '';
                $seriesPatternWeeklyTue = substr($objEvent->seriesData['seriesPatternWeekday'],1,1) == 1 ?  'checked="checked"' : '';
                $seriesPatternWeeklyWed = substr($objEvent->seriesData['seriesPatternWeekday'],2,1) == 1 ?  'checked="checked"' : '';
                $seriesPatternWeeklyThu = substr($objEvent->seriesData['seriesPatternWeekday'],3,1) == 1 ?  'checked="checked"' : '';
                $seriesPatternWeeklyFri = substr($objEvent->seriesData['seriesPatternWeekday'],4,1) == 1 ?  'checked="checked"' : '';
                $seriesPatternWeeklySat = substr($objEvent->seriesData['seriesPatternWeekday'],5,1) == 1 ?  'checked="checked"' : '';
                $seriesPatternWeeklySun = substr($objEvent->seriesData['seriesPatternWeekday'],6,1) == 1 ?  'checked="checked"' : '';
            }
            
            //monthly
            if($objEvent->seriesData['seriesType'] == 3) {
                $seriesPatternMonthly1 = $objEvent->seriesData['seriesPatternType'] == 1 ? 'checked="checked"' : '';
                $seriesPatternMonthly2 = $objEvent->seriesData['seriesPatternType'] == 2 ? 'checked="checked"' : '';
                
                if($objEvent->seriesData['seriesPatternType'] == 1) { 
                    $seriesPatternMonthlyDay = $objEvent->seriesData['seriesPatternDay'];
                    $seriesPatternMonthl1    = $objEvent->seriesData['seriesPatternMonth'];
                }
                
                if($objEvent->seriesData['seriesPatternType'] == 2) { 
                    $seriesPatternMonthl2    = $objEvent->seriesData['seriesPatternMonth'];
                }          
            }
            
            //douration
            $seriesPatternDourance1 = $objEvent->seriesData['seriesPatternDouranceType'] == 1 ? 'checked="checked"' : '';
            $seriesPatternDourance2 = $objEvent->seriesData['seriesPatternDouranceType'] == 2 ? 'checked="checked"' : '';
            $seriesPatternDourance3 = $objEvent->seriesData['seriesPatternDouranceType'] == 3 ? 'checked="checked"' : '';
            
            $seriesPatternEndsEvents = $objEvent->seriesData['seriesPatternDouranceType'] == 2 ? $objEvent->seriesData['seriesPatternEnd'] : 5;
            $seriesPatternEndsDate   = $objEvent->seriesData['seriesPatternDouranceType'] == 3 ? date($dateFomat, $objEvent->seriesData['seriesPatternEndDate']) : '';
            
            
            
            foreach ($objEvent->seriesData['seriesPatternExceptions'] as $key => $seriesExceptionDate) {                     
                
                if($seriesExceptionDate != null) {
                    $this->_objTpl->setVariable(array(                        
                        $this->moduleLangVar.'_SERIES_EXEPTION_DATE'        => date($dateFomat, $seriesExceptionDate),
                    ));  
                    
                    $this->_objTpl->parse('eventExeptions');                      
                } 
            }
        } else { 
            $seriesPatternDaily = 'checked="checked"';
            $seriesPatternDaily1 = 'checked="checked"';
            $seriesPatternMonthly1 = 'checked="checked"';
            $seriesPatternDourance1 = 'checked="checked"';
            
            $this->_objTpl->hideBlock('eventExeptions');   
        }
        
        $this->_objTpl->setVariable(array(            
            $this->moduleLangVar.'_EVENT_SERIES_STATUS'             => $seriesStatus,
            $this->moduleLangVar.'_SERIES_PATTERN_DAILY'            => $seriesPatternDaily,
            $this->moduleLangVar.'_SERIES_PATTERN_WEEKLY'           => $seriesPatternWeekly,
            $this->moduleLangVar.'_SERIES_PATTERN_MONTHLY'          => $seriesPatternMonthly,
            $this->moduleLangVar.'_SERIES_PATTERN_DAILY_1'          => $seriesPatternDaily1,
            $this->moduleLangVar.'_SERIES_PATTERN_DAILY_2'          => $seriesPatternDaily2,
            $this->moduleLangVar.'_SERIES_PATTERN_DAILY_DAYS'       => $seriesPatternDailyDays,
            $this->moduleLangVar.'_SERIES_PATTERN_MONTHLY_1'        => $seriesPatternMonthly1,
            $this->moduleLangVar.'_SERIES_PATTERN_MONTHLY_DAY'      => $seriesPatternMonthlyDay,
            $this->moduleLangVar.'_SERIES_PATTERN_MONTHLY_MONTH_1'  => $seriesPatternMonthl1,
            $this->moduleLangVar.'_SERIES_PATTERN_MONTHLY_MONTH_2'  => $seriesPatternMonthl2,
            $this->moduleLangVar.'_SERIES_PATTERN_MONTHLY_2'        => $seriesPatternMonthly2,
            $this->moduleLangVar.'_SERIES_PATTERN_DOURANCE_1'       => $seriesPatternDourance1,
            $this->moduleLangVar.'_SERIES_PATTERN_DOURANCE_2'       => $seriesPatternDourance2,
            $this->moduleLangVar.'_SERIES_PATTERN_DOURANCE_3'       => $seriesPatternDourance3,
            $this->moduleLangVar.'_SERIES_PATTERN_ENDS_EVENTS'      => $seriesPatternEndsEvents,
            $this->moduleLangVar.'_SERIES_PATTERN_ENDS_DATE'        => $seriesPatternEndsDate,
            $this->moduleLangVar.'_SERIES_PATTERN_ENDS_INPUT_ID'    => $seriesPatternEndsInputId,
            $this->moduleLangVar.'_SERIES_PATTERN_WEEKLY_WEEKS'     => $seriesPatternWeeklyWeeks,
            $this->moduleLangVar.'_SERIES_PATTERN_WEEKLY_MONDAY'    => $seriesPatternWeeklyMon,
            $this->moduleLangVar.'_SERIES_PATTERN_WEEKLY_TUESDAY'   => $seriesPatternWeeklyTue,
            $this->moduleLangVar.'_SERIES_PATTERN_WEEKLY_WEDNESDAY' => $seriesPatternWeeklyWed,
            $this->moduleLangVar.'_SERIES_PATTERN_WEEKLY_THURSDAY'  => $seriesPatternWeeklyThu,
            $this->moduleLangVar.'_SERIES_PATTERN_WEEKLY_FRIDAY'    => $seriesPatternWeeklyFri,
            $this->moduleLangVar.'_SERIES_PATTERN_WEEKLY_SATURDAY'  => $seriesPatternWeeklySat,
            $this->moduleLangVar.'_SERIES_PATTERN_WEEKLY_SUNDAY'    => $seriesPatternWeeklySun,
        ));  
        

        //parse publicate
        $objHostManager = new CalendarHostManager(null,true);
        $objHostManager->getHostList();
        
        foreach ($objHostManager->hostList as $key => $objHost) {       
            if(in_array($objHost->id, $objEvent->relatedHosts)) {   
                $selectetHosts .= '<option value="'.$objHost->id.'">'.$objHost->title.'</option>';
            } else {
                $deselectetHosts .= '<option value="'.$objHost->id.'">'.$objHost->title.'</option>';
            }
        }
        
        $this->_objTpl->setVariable(array(
            $this->moduleLangVar.'_EVENT_DESELECTED_HOSTS'    => $deselectetHosts,
            $this->moduleLangVar.'_EVENT_SELECTED_HOSTS'      => $selectetHosts,
        ));                
        
        /*if($this->arrSettings['publicationStatus'] == 1 && !empty($objHostManager->hostList)) { 
            $onsubmitPublications = "selectAll(document.formModifyEvent.elements['selectedHosts[]']);"; 
            $this->_objTpl->touchBlock('eventPublicateMenu');            
            $this->_objTpl->touchBlock('eventPublicateTab');
        } else { */
            $onsubmitPublications = "";   
            $this->_objTpl->hideBlock('eventPublicateMenu');               
            $this->_objTpl->hideBlock('eventPublicateTab');
        /* } */   
        
        //parse ivited groups   
        parent::getCommunityGroups();       
        foreach ($this->arrCommunityGroups as $key => $arrGroup) {
             if(in_array($arrGroup['id'], $objEvent->invitedGroups)) {
                 $selectedGroups .=  '<option value="'.$arrGroup['id'].'">'.htmlentities($arrGroup['name'], ENT_QUOTES, CONTREXX_CHARSET).'</option>';
             } else {
                 $deselectedGroups .=  '<option value="'.$arrGroup['id'].'">'.htmlentities($arrGroup['name'], ENT_QUOTES, CONTREXX_CHARSET).'</option>';        
             }    
        }
        
        $this->_objTpl->setVariable(array(
            $this->moduleLangVar.'_EVENT_DESELECTED_GROUPS'  => $deselectedGroups,
            $this->moduleLangVar.'_EVENT_SELECTED_GROUPS'  => $selectedGroups,     
            $this->moduleLangVar.'_EVENT_ONSUBMIT_PUBLICATIONS'  => $onsubmitPublications,     
        ));
        
        $forcedLanguage = null;
        if (isset($_GET['langId']) && in_array(contrexx_input2raw($_GET['langId']), \FWLanguage::getIdArray())) {
            $forcedLanguage = contrexx_input2raw($_GET['langId']);
        }
        
        //parse placeSelect
        if ((int) $this->arrSettings['placeData'] > 1) {
            $objMediadirEntries = new mediaDirectoryEntry();
            $objMediadirEntries->getEntries(null,null,null,null,null,null,true,0,'n',null,null,intval($this->arrSettings['placeDataForm']));

            $placeOptions = '<option value="">'.$_ARRAYLANG['TXT_CALENDAR_PLEASE_CHOOSE'].'</option>';

            foreach($objMediadirEntries->arrEntries as $key => $arrEntry) {
                $selectedPlace = ($arrEntry['entryId'] == $objEvent->place_mediadir_id) ? 'selected="selected"' : '';   
                $placeOptions .= '<option '.$selectedPlace.' value="'.$arrEntry['entryId'].'">'.$arrEntry['entryFields'][0].'</option>';   
            }

            $this->_objTpl->setVariable(array(   
                $this->moduleLangVar.'_EVENT_PLACE_OPTIONS'    => $placeOptions,    
            ));
            $this->_objTpl->parse('eventPlaceSelect');  
            
            if ((int) $this->arrSettings['placeData'] == 2) {
                $this->_objTpl->hideBlock('eventPlaceInput');
                $this->_objTpl->hideBlock('eventPlaceTypeRadio');
            } else {
                $this->_objTpl->touchBlock('eventPlaceInput');
                $this->_objTpl->touchBlock('eventPlaceTypeRadio');
            }
        } else {
            $this->_objTpl->touchBlock('eventPlaceInput');
            $this->_objTpl->hideBlock('eventPlaceSelect');  
            $this->_objTpl->hideBlock('eventPlaceTypeRadio');
        }
        
        //parse placeHostSelect
        if ((int) $this->arrSettings['placeDataHost'] > 1) {
            $objMediadirEntries = new mediaDirectoryEntry();
            $objMediadirEntries->getEntries(null,null,null,null,null,null,true,0,'n',null,null,intval($this->arrSettings['placeDataHostForm']));

            $placeOptions = '<option value="">'.$_ARRAYLANG['TXT_CALENDAR_PLEASE_CHOOSE'].'</option>';

            foreach($objMediadirEntries->arrEntries as $key => $arrEntry) {
                $selectedPlace = ($arrEntry['entryId'] == $objEvent->host_mediadir_id) ? 'selected="selected"' : '';   
                $placeOptions .= '<option '.$selectedPlace.' value="'.$arrEntry['entryId'].'">'.$arrEntry['entryFields'][0].'</option>';   
            }

            $this->_objTpl->setVariable(array(   
                $this->moduleLangVar.'_EVENT_PLACE_OPTIONS'    => $placeOptions,    
            ));
            $this->_objTpl->parse('eventHostSelect');  
            
            if ((int) $this->arrSettings['placeDataHost'] == 2) {
                $this->_objTpl->hideBlock('eventHostInput');
                $this->_objTpl->hideBlock('eventHostTypeRadio');
            } else {
                $this->_objTpl->touchBlock('eventHostInput');
                $this->_objTpl->touchBlock('eventHostTypeRadio');
            }
        } else {
            $this->_objTpl->touchBlock('eventHostInput');
            $this->_objTpl->hideBlock('eventHostSelect');  
            $this->_objTpl->hideBlock('eventHostTypeRadio');
        }
        
        foreach ($this->arrFrontendLanguages as $key => $arrLang) {
            //parse globals
        	$this->_objTpl->setGlobalVariable(array(
                $this->moduleLangVar.'_EVENT_LANG_SHORTCUT'  => $arrLang['lang'],
                $this->moduleLangVar.'_EVENT_LANG_ID'  => $arrLang['id'],
                'TXT_'.$this->moduleLangVar.'_EVENT_LANG_NAME'  => $arrLang['name'],
            ));
        	
            //parse "show in" checkboxes
            $arrShowIn = explode(",", $objEvent->showIn);
            
            $langChecked = false;
            if($eventId != 0) {
                $langChecked = in_array($arrLang['id'], $arrShowIn);
                if ($forcedLanguage && !$langChecked) {
                    $langChecked = $forcedLanguage == $arrLang['id'];
                }
            } else {
                $langChecked = $arrLang['is_default'] == 'true';
            }

            if ($langChecked) {
                $langChecked = 'checked="checked"';
            } else {
                $langChecked =  '';
            }
        	
            $this->_objTpl->setVariable(array(
                $this->moduleLangVar.'_EVENT_LANG_CHECKED'  => $langChecked,
            ));
            
            $this->_objTpl->parse('eventShowIn');
                        
            $this->_objTpl->setVariable(array(        	
                $this->moduleLangVar.'_EVENT_TAB_DISPLAY'   => $arrLang['is_default'] == 'true' ? 'block' : 'none',
                $this->moduleLangVar.'_EVENT_TITLE'         => !empty($objEvent->arrData['title'][$arrLang['id']]) ? $objEvent->arrData['title'][$arrLang['id']] : $objEvent->title,                
	    ));
	                  	    	        
	    //parse eventTabMenuDescTab
            $this->_objTpl->setVariable(array(
                $this->moduleLangVar.'_EVENT_TAB_CLASS'  => $defaultLang ? 'active' : '',
            ));
            
            $this->_objTpl->parse('eventTabMenuDescTab');
            
            //parse eventDescTab
            $this->_objTpl->setVariable(array(
                'TXT_'.$this->moduleLangVar.'_EVENT_DESCRIPTION'        => $_ARRAYLANG['TXT_CALENDAR_EVENT_DESCRIPTION'],
                'TXT_'.$this->moduleLangVar.'_EVENT_REDIRECT'           => $_ARRAYLANG['TXT_CALENDAR_EVENT_TYPE_REDIRECT'],
                $this->moduleLangVar.'_EVENT_TAB_DISPLAY'               => $arrLang['is_default'] == 'true' ? 'block' : 'none',
                $this->moduleLangVar.'_EVENT_DESCRIPTION'               => new \Cx\Core\Wysiwyg\Wysiwyg('description['.$arrLang['id'].']', !empty($objEvent->arrData['description'][$arrLang['id']]) ? $objEvent->arrData['description'][$arrLang['id']] : $objEvent->description, 'full'),
                $this->moduleLangVar.'_EVENT_REDIRECT'                  => !empty($objEvent->arrData['redirect'][$arrLang['id']]) ? $objEvent->arrData['redirect'][$arrLang['id']] : $objEvent->arrData['redirect'][$_LANGID],   
                $this->moduleLangVar.'_EVENT_TYPE_EVENT_DISPLAY'        => $objEvent->type == 0 ? 'block' : 'none',   
                $this->moduleLangVar.'_EVENT_TYPE_REDIRECT_DISPLAY'     => $objEvent->type == 1 ? 'block' : 'none',     
                $this->moduleLangVar.'_ONSUBMIT_PUBLICATION'            => $onsubmitPublications,     
            ));
            
            $this->_objTpl->parse('eventDescTab');    
        }
        
        if (isset($_GET['confirm']) && $_GET['confirm']) {
            $this->_objTpl->setGlobalVariable(array(
                $this->moduleLangVar.'_SAVE_PUBLISH' => "<input type='submit' name='save_and_publish' value='{$_ARRAYLANG['TXT_CALENDAR_SAVE_AND_PUBLISH']}'>",
                $this->moduleLangVar.'_EVENT_DELETE' => "<input type='button' name='delete' value='{$_ARRAYLANG['TXT_CALENDAR_DELETE']}' onClick='if (confirm(\"{$_ARRAYLANG['TXT_CALENDAR_CONFIRM_DELETE_DATA']}\\n{$_ARRAYLANG['TXT_CALENDAR_ACTION_IS_IRREVERSIBLE']}\")) { window.location.href = \"index.php?cmd={$this->moduleName}&delete=$eventId&".CSRF::param()."\"} return false;'>",
            ));
        }
    }
    
    
    /**
     * Category overview 
     *      
     * @return null
     */
    function showCategories(){
        global $objDatabase, $_ARRAYLANG, $_CORELANG;
                    
        if (isset($_GET['tpl'])) {
            switch ($_GET['tpl']) {
                case 'modify_category':
                    $this->modifyCategory(intval($_GET['id']));
                    break;
            }
            return;
        }
        if(isset($_POST['submitModifyCategory'])) {
            $objCategory = new CalendarCategory(intval($_POST['id']));
            if($objCategory->save($_POST)) {
                $this->okMessage = intval($_POST['id']) == 0? $_ARRAYLANG['TXT_CALENDAR_CATEGORY_SUCCESSFULLY_ADDED'] : $_ARRAYLANG['TXT_CALENDAR_CATEGORY_SUCCESSFULLY_EDITED'];
            } else {
                $this->errMessage = intval($_POST['id']) == 0? $_ARRAYLANG['TXT_CALENDAR_CATEGORY_CORRUPT_ADDED'] : $_ARRAYLANG['TXT_CALENDAR_CATEGORY_CORRUPT_EDITED'];
            }
        }
        
        if(isset($_GET['delete'])) {
            $objCategory = new CalendarCategory(intval($_GET['delete']));
            if($objCategory->delete()) {
                $this->okMessage = $_ARRAYLANG['TXT_CALENDAR_CATEGORY_SUCCESSFULLY_DELETED'];
            } else {
                 $this->errMessage = $_ARRAYLANG['TXT_CALENDAR_CATEGORY_CORRUPT_DELETED'];
            }
        }
        
        if(isset($_GET['multi'])) {                         
            $status = true;  
            $messageVar = 'EDITED';
            
            foreach($_POST['selectedCategoryId'] as $key => $catId) {     
                $objCategory = new CalendarCategory(intval($catId)); 
                
                switch($_GET['multi']) {
                    case 'delete':
                        $status = $objCategory->delete() ? true : false; 
                        $messageVar = 'DELETED';
                        break; 
                    case 'activate':
                        $objCategory->status = 0;
                        $status = $objCategory->switchStatus() ? true : false;
                        $messageVar = 'EDITED';
                        break;      
                    case 'deactivate':
                        $objCategory->status = 1;
                        $status = $objCategory->switchStatus() ? true : false;
                        $messageVar = 'EDITED';
                        break;
                }  
            }
            
            if($status) {
                $this->okMessage = $_ARRAYLANG['TXT_CALENDAR_CATEGORY_SUCCESSFULLY_'.$messageVar];
            } else {
                 $this->errMessage = $_ARRAYLANG['TXT_CALENDAR_CATEGORY_CORRUPT_'.$messageVar];
            }
        }
        
        if(isset($_GET['switch_status'])) {
            $objCategory = new CalendarCategory(intval($_GET['switch_status']));
            if($objCategory->switchStatus()) {
                $this->okMessage = $_ARRAYLANG['TXT_CALENDAR_CATEGORY_SUCCESSFULLY_EDITED'];
            } else {
                 $this->errMessage = $_ARRAYLANG['TXT_CALENDAR_CATEGORY_CORRUPT_EDITED'];
            }
        }
        
        if(isset($_POST['submitCategoryList'])) {    
            $status = true;
            foreach($_POST['categoryOrder'] as $catId => $order) {     
                $objCategory = new CalendarCategory(intval($catId)); 
                if(!$objCategory->saveOrder(intval($order))) {
                    $status = false;
                }
            }
            
            if($status) {
                $this->okMessage = $_ARRAYLANG['TXT_CALENDAR_CATEGORY_SUCCESSFULLY_EDITED'];
            } else {
                 $this->errMessage = $_ARRAYLANG['TXT_CALENDAR_CATEGORY_CORRUPT_EDITED'];
            }
        }
        
        $this->_objTpl->loadTemplateFile('module_calendar_categories.html');
        $this->_pageTitle = $_ARRAYLANG['TXT_CALENDAR_CATEGORIES'];
        
        $this->_objTpl->setGlobalVariable(array(
            'TXT_'.$this->moduleLangVar.'_CATEGORIES'               => $this->_pageTitle,
            'TXT_'.$this->moduleLangVar.'_STATUS'                   => $_ARRAYLANG['TXT_CALENDAR_STATUS'],
            'TXT_'.$this->moduleLangVar.'_SORT'                     => $_ARRAYLANG['TXT_CALENDAR_SORTING'],
            'TXT_'.$this->moduleLangVar.'_TITLE'                    => $_ARRAYLANG['TXT_CALENDAR_TITLE'],
            'TXT_'.$this->moduleLangVar.'_EVENTS'                   => $_ARRAYLANG['TXT_CALENDAR_EVENTS'],
            'TXT_'.$this->moduleLangVar.'_EDIT'                     => $_ARRAYLANG['TXT_CALENDAR_EDIT'],
            'TXT_'.$this->moduleLangVar.'_SAVE'                     => $_CORELANG['TXT_SAVE'],
            'TXT_'.$this->moduleLangVar.'_ACTION'                   => $_ARRAYLANG['TXT_CALENDAR_ACTION'],
            'TXT_'.$this->moduleLangVar.'_EDIT'                     => $_ARRAYLANG['TXT_CALENDAR_EDIT'],
            'TXT_'.$this->moduleLangVar.'_DELETE'                   => $_ARRAYLANG['TXT_CALENDAR_DELETE'],
            'TXT_SELECT_ALL'                                        => $_ARRAYLANG['TXT_CALENDAR_MARK_ALL'],
            'TXT_DESELECT_ALL'                                      => $_ARRAYLANG['TXT_CALENDAR_REMOVE_CHOICE'],
            'TXT_SUBMIT_SELECT'                                     => $_ARRAYLANG['TXT_SUBMIT_SELECT'],
            'TXT_SUBMIT_ACTIVATE'                                   => $_ARRAYLANG['TXT_SUBMIT_ACTIVATE'],
            'TXT_SUBMIT_DEACTIVATE'                                 => $_ARRAYLANG['TXT_SUBMIT_DEACTIVATE'],
            'TXT_SUBMIT_DELETE'                                     => $_ARRAYLANG['TXT_SUBMIT_DELETE'],
            'TXT_'.$this->moduleLangVar.'_CONFIRM_DELETE_DATA'      => $_ARRAYLANG['TXT_CALENDAR_CONFIRM_DELETE_DATA'],
            'TXT_'.$this->moduleLangVar.'_ACTION_IS_IRREVERSIBLE'   => $_ARRAYLANG['TXT_CALENDAR_ACTION_IS_IRREVERSIBLE'],
            'TXT_'.$this->moduleLangVar.'_INSERT_CATEGORY'          => $_ARRAYLANG['TXT_CALENDAR_INSERT_CATEGORY'] ,
            'TXT_'.$this->moduleLangVar.'_MAKE_SELECTION'           => $_ARRAYLANG['TXT_CALENDAR_MAKE_SELECTION']
        ));
        
        $objCategoryManager = new CalendarCategoryManager();
        $objCategoryManager->getCategoryList();
        $objCategoryManager->showCategoryList($this->_objTpl);
    }
    
    
    /**
     * Add / Edit  of the category
     *      
     * @param type $categoryId
     * 
     * @return null
     */
    function modifyCategory($categoryId){
        global $objDatabase, $_ARRAYLANG, $_CORELANG, $_LANGID;
        
        $this->_objTpl->loadTemplateFile('module_calendar_modify_category.html');
        
        if($categoryId != 0) {
            $this->_pageTitle = $_ARRAYLANG['TXT_CALENDAR_CATEGORY']." ".$_ARRAYLANG['TXT_CALENDAR_EDIT'];
        } else {
        	$this->_pageTitle = $_ARRAYLANG['TXT_CALENDAR_INSERT_CATEGORY'];
        }
        
        $this->_objTpl->setGlobalVariable(array(
            'TXT_'.$this->moduleLangVar.'_CATEGORY'             => $this->_pageTitle,
            'TXT_'.$this->moduleLangVar.'_FORMCHECK_NAME'       => $_ARRAYLANG['TXT_CALENDAR_FORMCHECK_NAME'],
            'TXT_'.$this->moduleLangVar.'_SAVE'                 => $_ARRAYLANG['TXT_CALENDAR_SAVE'],
            'TXT_'.$this->moduleLangVar.'_CATEGORY_NAME'        => $_ARRAYLANG['TXT_CALENDAR_CATEGORY_NAME'],
            'TXT_'.$this->moduleLangVar.'_CATEGORY_HOSTS'       => $_ARRAYLANG['TXT_CALENDAR_HOSTS'],
            'TXT_'.$this->moduleLangVar.'_CATEGORY_HOSTS_INFO'  => $_ARRAYLANG['TXT_CALENDAR_HOSTS_INFO'],
            'TXT_'.$this->moduleLangVar.'_MORE'                 => $_ARRAYLANG['TXT_CALENDAR_MORE'],
            $this->moduleLangVar.'_CATEGORY_DEFAULT_LANG_ID'    => $_LANGID,
        ));
            
        if($categoryId != 0) {
            $objCategoryManager = new CalendarCategoryManager();
            $objCategoryManager->showCategory($this->_objTpl, $categoryId);
            $objCategory = $objCategoryManager->categoryList[$categoryId]; 
        }
        
        parent::getFrontendLanguages();
        parent::getSettings();
        
        foreach ($this->arrFrontendLanguages as $key => $arrLang) {
            if($categoryId != 0){
                $categoryName = empty($objCategory->arrData['name'][$arrLang['id']]) ? $objCategory->arrData['name'][0] : $objCategory->arrData['name'][$arrLang['id']];
            } else {
                $categoryName = '';
            }

            $this->_objTpl->setVariable(array(
                $this->moduleLangVar.'_CATEGORY_NAME_LANG_ID'           => $arrLang['id'],
                'TXT_'.$this->moduleLangVar.'_CATEGORY_NAME_LANG_NAME'  => $arrLang['name'],
                $this->moduleLangVar.'_CATEGORY_NAME_LANG_SHORTCUT'     => $arrLang['lang'],
                $this->moduleLangVar.'_CATEGORY_NAME'                   => $categoryName,
            ));

            if(($key+1) == count($this->arrFrontendLanguages)) {
                $this->_objTpl->setVariable(array(
                    $this->moduleLangVar.'_MINIMIZE' =>  '<a href="javascript:ExpandMinimize(\'name\');">&laquo;&nbsp;'.$_ARRAYLANG['TXT_MEDIADIR_MINIMIZE'].'</a>',
                ));
            }

            $this->_objTpl->parse('categoryNameList');
        }
        
        if (count($this->arrFrontendLanguages) > 1) {
            $this->_objTpl->touchBlock('categoryNameExpand');            
        } else {
            $this->_objTpl->hideBlock('categoryNameExpand');
        }
        
        /* if($this->arrSettings['publicationStatus'] == 1) {
            $objHostManager = new CalendarHostManager(null,true);
            $objHostManager->getHostList();
            
            foreach ($objHostManager->hostList as $key => $objHost) {
                if($objHost->catId == $categoryId || $objHost->catId == 0) {
                    if($objHost->catId == $categoryId && $objHost->catId != 0) {
                        $selectetHosts .= '<option value="'.$objHost->id.'">'.$objHost->title.'</option>';
                    } else {
                        $deselectetHosts .= '<option value="'.$objHost->id.'">'.$objHost->title.'</option>';
                    }
                } 
            }
            
            $this->_objTpl->setVariable(array(
                $this->moduleLangVar.'_CATEGORY_DESELECTED_HOSTS'    => $deselectetHosts,
                $this->moduleLangVar.'_CATEGORY_SELECTED_HOSTS'      => $selectetHosts,
            ));
            
            $this->_objTpl->parse('hostSelector');
        } else { */
            $this->_objTpl->hideBlock('hostSelector');
        /* } */
    }
    
    
    /**
     * Performs the settings menu based on the $_GET request
     * 
     * @return null     
     */
    function showSettings() {
        global $objDatabase, $_ARRAYLANG, $_CORELANG;
        
        $this->_objTpl->loadTemplateFile('module_calendar_settings.html');
        $this->_pageTitle = $_ARRAYLANG['TXT_CALENDAR_MENU_SETTINGS'];
        
        $this->_objTpl->setGlobalVariable(array(
            'TXT_'.$this->moduleLangVar.'_GLOBAL'               => $_ARRAYLANG['TXT_CALENDAR_GLOBAL'],
            'TXT_'.$this->moduleLangVar.'_REGISTRATION_FORMS'   => $_ARRAYLANG['TXT_CALENDAR_REGISTRATION_FORMS'],
            'TXT_'.$this->moduleLangVar.'_MAIL_TEMPLATES'       => $_ARRAYLANG['TXT_CALENDAR_MAIL_TEMPLATES'],
            'TXT_'.$this->moduleLangVar.'_PUBLICATION'          => $_ARRAYLANG['TXT_CALENDAR_PUBLICATION'],
            'TXT_'.$this->moduleLangVar.'_PAYMENT'              => $_ARRAYLANG['TXT_CALENDAR_PAYMENT'],
            'TXT_'.$this->moduleLangVar.'_DATE_DISPLAY'         => $_ARRAYLANG['TXT_CALENDAR_DATE_DISPLAY'],
            'TXT_'.$this->moduleLangVar.'_SAVE'                 => $_CORELANG['TXT_SAVE'],
        ));
        
        $objSettings = new CalendarSettings();
        
        switch ($_GET['tpl']) {
            /* case 'hosts':
                $objSettings->hosts($this->_objTpl);
                break;
            case 'modify_host':
                $objSettings->modifyHost($this->_objTpl, intval($_GET['id']));
                break; */
            case 'mails':
                $objSettings->mails($this->_objTpl);
                break;
            case 'modify_mail':
                $objSettings->modifyMail($this->_objTpl, intval($_GET['id']));
                break;
            case 'forms':
                $objSettings->forms($this->_objTpl);
                break;
            case 'modify_form':
                $objSettings->modifyForm($this->_objTpl, intval($_GET['id']));
                break;
            /* case 'payment':
                $objSettings->payment($this->_objTpl);
                break; */
            case 'date':
                $objSettings->dateDisplay($this->_objTpl);
                break;
            case 'general':
            default:
                $objSettings->general($this->_objTpl);
        }

        $this->okMessage = $objSettings->okMessage!='' ? $objSettings->okMessage : null;
        $this->errMessage = $objSettings->errMessage!='' ? $objSettings->errMessage : null;
        
        $this->_objTpl->parse('settings_content');
    }
    
    /**
     * Export the registered userd of the given event
     *      
     * @param integer $eventId          Event id
     * @param integer $registrationType Registration type
     * 
     * @return mixed csv file with registered users list
     */
    function exportRegistrations($eventId, $registrationType) {
        global $_ARRAYLANG, $_LANGID;
        
        if (empty($eventId)) {
            CSRF::header("Location: index.php?cmd=".$this->moduleName);
            return;
        }   
        
        switch ($registrationType) {
            case 'r':            
                $getRegistrations = true; 
                $getDeregistrations = false;  
                $getWaitlist = false;
                break;
            case 'd':
                $getRegistrations = false; 
                $getDeregistrations = true;  
                $getWaitlist = false;
                break;
            case 'w':
                $getRegistrations = false; 
                $getDeregistrations = false;  
                $getWaitlist = true;
                break;
            default:
                $getRegistrations = true; 
                $getDeregistrations = true;  
                $getWaitlist = true;
                break;
        }
             
        parent::getFrontendLanguages();   
        
        $objEvent = new CalendarEvent($eventId);      
        
        $filename = urlencode($objEvent->title).".csv"; 
        
        $objRegistrationManager = new CalendarRegistrationManager($eventId, $getRegistrations, $getDeregistrations, $getWaitlist);  
        $objRegistrationManager->getRegistrationList(); 
        
        if(!empty($objRegistrationManager->registrationList)) {                 
            header("Content-Type: text/comma-separated-values; charset=".CONTREXX_CHARSET, true);
            header("Content-Disposition: attachment; filename=\"$filename\"", true);        
            
            print ($_ARRAYLANG['TXT_CALENDAR_FIRST_EXPORT'].$this->csvSeparator);   
            print ($_ARRAYLANG['TXT_CALENDAR_TYPE'].$this->csvSeparator);  
            print ($_ARRAYLANG['TXT_CALENDAR_EVENT'].$this->csvSeparator);  
            print ($_ARRAYLANG['TXT_CALENDAR_LANG'].$this->csvSeparator); 
            
            $firstKey = key($objRegistrationManager->registrationList);   
                
            foreach ($objRegistrationManager->registrationList[$firstKey]->fields as $id => $arrField) {
                if ($arrField['type'] != 'fieldset') {
                    print (self::escapeCsvValue(html_entity_decode($arrField['name'], ENT_QUOTES)).$this->csvSeparator);
                }
            }

            print ("\r\n");
            
            foreach ($objRegistrationManager->registrationList as $key => $objRegistration) {   
             
                if(intval($objRegistration->firstExport) == 0) {
                    $objRegistration->tagExport();   
                }  
                
                print (date(parent::getDateFormat(), $objRegistration->firstExport).$this->csvSeparator);
                   
                if($objRegistration->type == '1') {                               
                    print ($_ARRAYLANG['TXT_CALENDAR_REG_REGISTRATION'].$this->csvSeparator);       
                } else if($objRegistration->type == '2') {                               
                    print ($_ARRAYLANG['TXT_CALENDAR_WAITLIST'].$this->csvSeparator);       
                } else {   
                    print ($_ARRAYLANG['TXT_CALENDAR_REG_SIGNOFF'].$this->csvSeparator);    
                }
                
                print (html_entity_decode($objEvent->title, ENT_QUOTES)." - ".date(parent::getDateFormat(), $objRegistration->eventDate).$this->csvSeparator);  
                
                if($objRegistration->langId == null) {  
                    print ($this->arrFrontendLanguages[$_LANGID]['name'].$this->csvSeparator); 
                } else {              
                    print ($this->arrFrontendLanguages[$objRegistration->langId]['name'].$this->csvSeparator); 
                }                                                          
                   
                foreach ($objRegistration->fields as $id => $arrField) {
                    $output = array();
                    switch($arrField['type']) {
                        case 'inputtext':
                        case 'mail':
                        case 'textarea':
                        case 'seating':
                        case 'firstname':
                        case 'lastname':
                            print (self::escapeCsvValue(html_entity_decode($arrField['value'], ENT_QUOTES)).$this->csvSeparator); 
                            break ;
                        case 'salutation':
                        case 'select': 
                        case 'radio':  
                        case 'checkbox':   
                            $options = explode(",", $arrField['default']);  
                            $values = explode(",", $arrField['value']);
                            
                            foreach ($values as $key => $value) {  
                                $arrValue = explode('[[', $value);    
                                $value = $arrValue[0];
                                $input = str_replace(']]','', $arrValue[1]); 
                                
                                if(!empty($input)) {
                                    $arrOption = explode('[[', $options[$value-1]);      
                                    $output[] = $arrOption[0].": ".$input; 
                                } else {   
                                    if($options[0] == '' && $value == 1) {
                                        $options[$value-1] = '1';
                                    }
                                    $output[] = $options[$value-1];        
                                }        
                            } 
                            
                            print (html_entity_decode(self::escapeCsvValue(join(", ", $output)), ENT_QUOTES).$this->csvSeparator);     
                            
                            break;
                        case 'agb':
                            print (($arrField['value'] ? $_ARRAYLANG["TXT_{$this->moduleLangVar}_YES"] : $_ARRAYLANG["TXT_{$this->moduleLangVar}_NO"]).$this->csvSeparator);
                            break;
                    }  
                         
                }                         
                
                print ("\r\n");
            }   
            
            exit();   
       } else {   
            CSRF::header("Location: index.php?cmd=".$this->moduleName);
            return;
       }
    }
    
    /**
     * Perform the event registration
     *      
     * @param integer $eventId Event id
     * 
     * @return null
     */
    function showEventRegistrations($eventId)
    {
        global $_ARRAYLANG;
        
        $this->_objTpl->loadTemplateFile('module_calendar_registrations.html');
        $objEvent = new CalendarEvent(intval($eventId));
        
        $getTpl = isset($_GET['tpl']) ? $_GET['tpl'] : 'r';
        if (isset($_GET['delete'])) {
            $objRegistration = new CalendarRegistration($objEvent->registrationForm, $_GET['delete']);
            $status = $objRegistration->delete($_GET['delete']) ? true : false;
            $messageVar = 'DELETED';
        }
        
        if (isset($_GET['multi'])) {
            Permission::checkAccess(180, 'static');
            
            foreach($_POST['selectedRegistrationId'] as $regId) {
                $objRegistration = new CalendarRegistration($objEvent->registrationForm, $regId);
                
                switch($_GET['multi']) {
                    case 'r':
                        $status = $objRegistration->move($regId, 1) ? true : false;
                        $messageVar = 'MOVED';
                        break; 
                    case 'd':
                        $status = $objRegistration->move($regId, 0) ? true : false;
                        $messageVar = 'MOVED';
                        break;      
                    case 'w':
                        $status = $objRegistration->move($regId, 2) ? true : false;
                        $messageVar = 'MOVED';
                        break;        
                    case 'delete':
                        $status = $objRegistration->delete($regId) ? true : false;
                        $messageVar = 'DELETED';
                        break;
                }  
            }
        }
        
        if ($status) {
            $this->okMessage = $_ARRAYLANG['TXT_CALENDAR_EVENT_SUCCESSFULLY_'.$messageVar];
        } else {
            $this->errMessage = $_ARRAYLANG['TXT_CALENDAR_EVENT_CORRUPT_'.$messageVar];
        }
        
        $this->_objTpl->setGlobalVariable(array(            
            'TXT_'.$this->moduleLangVar.'_REGISTRATIONS'          => $_ARRAYLANG['TXT_CALENDAR_REGISTRATIONS'],
            'TXT_'.$this->moduleLangVar.'_DEREGISTRATIONS'        => $_ARRAYLANG['TXT_CALENDAR_DEREGISTRATIONS'],
            'TXT_'.$this->moduleLangVar.'_WAITLIST'               => $_ARRAYLANG['TXT_CALENDAR_WAITLIST'],
            'TXT_'.$this->moduleLangVar.'_CONFIRM_DELETE_DATA'    => $_ARRAYLANG['TXT_CALENDAR_CONFIRM_DELETE_DATA'],
            'TXT_'.$this->moduleLangVar.'_ACTION_IS_IRREVERSIBLE' => $_ARRAYLANG['TXT_CALENDAR_ACTION_IS_IRREVERSIBLE'],
            'TXT_'.$this->moduleLangVar.'_MAKE_SELECTION'         => $_ARRAYLANG['TXT_CALENDAR_MAKE_SELECTION'],
            'TXT_'.$this->moduleLangVar.'_BACK'                   => $_ARRAYLANG['TXT_CALENDAR_BACK'],
            'TXT_'.$this->moduleLangVar.'_NO_REGISTRATIONS'       => $_ARRAYLANG['TXT_CALENDAR_NO_REGISTRATIONS'],
            'TXT_'.$this->moduleLangVar.'_SUBSCRIPTIONS'          => $_ARRAYLANG['TXT_CALENDAR_SUBSCRIPTIONS'],
            'TXT_'.$this->moduleLangVar.'_ADD'                    => $_ARRAYLANG['TXT_CALENDAR_ADD'],
            'TXT_'.$this->moduleLangVar.'_EXPORT'                 => $_ARRAYLANG['TXT_CALENDAR_EXPORT'],
            'TXT_SUBMIT_SELECT'                                   => $_ARRAYLANG['TXT_SUBMIT_SELECT'],
            'TXT_SUBMIT_MOVE'                                     => $_ARRAYLANG['TXT_SUBMIT_MOVE'],
            'TXT_SELECT_ALL'                                      => $_ARRAYLANG['TXT_SELECT_ALL'],
            'TXT_DESELECT_ALL'                                    => $_ARRAYLANG['TXT_DESELECT_ALL'],
            'TXT_SUBMIT_DELETE'                                   => $_ARRAYLANG['TXT_SUBMIT_DELETE'],
            $this->moduleLangVar.'_EVENT_ID'                      => $eventId,
            $this->moduleLangVar.'_REGISTRATION_ID'               => $regId,            
            $this->moduleLangVar.'_REGISTRATION_'. strtoupper($getTpl) .'_CONTAINER_CLASS'  => 'active',
        ));
        
        $tplArr = array('r', 'd', 'w');
        
        foreach ($tplArr as $tpl) {
            $r = $d = $w = false;
        
            switch ($tpl) {
                case 'r':
                    $r = true;
                    $title = $_ARRAYLANG['TXT_CALENDAR_REGISTRATIONS'];
                    $containerId = 'registration';
                    $containerDisplay = ($getTpl == 'r');
                    break;
                case 'd':
                    $d = true;
                    $title = $_ARRAYLANG['TXT_CALENDAR_DEREGISTRATIONS'];
                    $containerId = 'deregistration';
                    $containerDisplay = ($getTpl == 'd');
                    break;
                case 'w':
                    $w = true;
                    $title = $_ARRAYLANG['TXT_CALENDAR_WAITLIST'];
                    $containerId = 'waitlist';
                    $containerDisplay = ($getTpl == 'w');
                    break;
                default:                    
                    break;
            }

            $objRegistrationManager = new CalendarRegistrationManager($eventId, $r, $d, $w);
            $objRegistrationManager->getRegistrationList();
            $objRegistrationManager->showRegistrationList($this->_objTpl, $tpl);
            
            $this->_objTpl->setVariable(array(
                $this->moduleLangVar.'_EVENT_TPL'                          => $tpl,
                'TXT_'.$this->moduleLangVar.'_REGISTRATIONS_TITLE'         => $title,
                $this->moduleLangVar.'_REGISTRATION_LIST_CONTAINER_ID'     => $containerId,                
                $this->moduleLangVar.'_REGISTRATION_LIST_CONTAINER_DISPLAY'=> $containerDisplay ? 'block' : 'none'
            ));
            $this->_objTpl->parse("calendar_registration_lists");
        }                                
    }
    
    /**
     * Add / Edit registration
     *      
     * @param integer $eventId Event id
     * @param integer $regId   Rgistration id
     */
    function modifyRegistration($eventId, $regId)
    {
        global $objDatabase, $_ARRAYLANG;
        
        $this->_objTpl->loadTemplateFile('module_calendar_modify_registration.html');
        
        if (isset($_POST['submitModifyRegistration'])) {
        	$objRegistration = new CalendarRegistration(intval($_POST['form']));
	        if ($objRegistration->save($_POST)) {                    
                    switch ($_POST['registrationType']) {
                        case 0:
                            $tpl = 'd';
                            break;
                        case 1:
                        default:
                            $tpl = 'r';
                            break;
                        case 2:
                            $tpl = 'w';
                            break;                   
                    }
                    $tpl = !empty($_POST['regtpl']) ? $_POST['regtpl'] : $tpl;
                    $this->okMessage = $_ARRAYLANG['TXT_CALENDAR_REGISTRATION_SUCCESSFULLY_SAVED'];                    
                    CSRF::header('Location: index.php?cmd='.$this->moduleName.'&act=event_registrations&tpl='.$tpl.'&id='.$eventId);
	        } else {
                    $this->errMessage = $_ARRAYLANG['TXT_CALENDAR_REGISTRATION_CORRUPT_SAVED'];
	        }
        }
        
        $objFWUser       = FWUser::getFWUserObject();     
        $objUser         = $objFWUser->objUser;
        $userId          = intval($objUser->getId());
        $objEvent        = new CalendarEvent($eventId);
        
        if ($regId != 0) {
            $this->_pageTitle = $_ARRAYLANG['TXT_CALENDAR_EVENT_EDIT_REGISTRATION'];
            $objRegistration = new CalendarRegistration($objEvent->registrationForm, $regId);
        } else {
            $this->_pageTitle = $_ARRAYLANG['TXT_CALENDAR_EVENT_INSERT_REGISTRATION'];
            $objRegistration = new CalendarRegistration($objEvent->registrationForm);
        }
        
        $objRegistrationManager = new CalendarRegistrationManager($eventId, true, true, true);
        $objRegistrationManager->getRegistrationList();
        $objRegistrationManager->showRegistrationInputfields($objEvent->registrationForm, $regId, $this->_objTpl);
        
        parent::getSettings();
        if ($this->arrSettings['paymentStatus'] == '1' && ($this->arrSettings['paymentBillStatus'] == '1' || $this->arrSettings['paymentYellowpayStatus'] == '1')) {
            $selectedBill      = $objRegistration->paymentMethod == 1 ? 'selected="selected"' : '';
            $selectedYellowpay = $objRegistration->paymentMethod == 2 ? 'selected="selected"' : '';
            $paymentMethods    = '<select style="width: 204px;" class="calendarSelect" name="paymentMethod">';
            $paymentMethods   .= $this->arrSettings['paymentBillStatus'] == '1'      ? '<option value="1" '.$selectedBill.'>'.$_ARRAYLANG['TXT_CALENDAR_PAYMENT_BILL'].'</option>'  : '';
            $paymentMethods   .= $this->arrSettings['paymentYellowpayStatus'] == '1' ? '<option value="2" '.$selectedYellowpay.'>'.$_ARRAYLANG['TXT_CALENDAR_PAYMENT_YELLOWPAY'].'</option>' : '';
            $paymentMethods   .= '</select>';
            
            $this->_objTpl->setVariable(array(
                'TXT_'.$this->moduleLangVar.'_PAYMENT_METHOD' => $_ARRAYLANG['TXT_CALENDAR_PAYMENT_METHOD'],
                'TXT_'.$this->moduleLangVar.'_PAID'          => $_ARRAYLANG['TXT_PAYMENT_COMPLETED'],
                $this->moduleLangVar.'_PAYMENT_METHODS'       => $paymentMethods,
                $this->moduleLangVar.'_PAID'                 => ($objRegistration->paid == true ? " checked='checked'" : "")
            ));
            $this->_objTpl->parse('calendarRegistrationPayment');
        } else {
            $this->_objTpl->hideBlock('calendarRegistrationPayment');
        }
        
        $this->_objTpl->setGlobalVariable(array(
            'TXT_'.$this->moduleLangVar.'_REGISTRATION_TITLE'    => $this->_pageTitle,
            'TXT_'.$this->moduleLangVar.'_SAVE'                  => $_ARRAYLANG['TXT_CALENDAR_SAVE'],
            'TXT_'.$this->moduleLangVar.'_BACK'                  => $_ARRAYLANG['TXT_CALENDAR_BACK'],
            $this->moduleLangVar.'_EVENT_ID'                     => $eventId,
            $this->moduleLangVar.'_REGISTRATION_TPL'             => $_GET['tpl'],
            $this->moduleLangVar.'_REGISTRATION_ID'              => $regId,
            $this->moduleLangVar.'_REGISTRATION_TYPE'            => $objRegistration->type,
            $this->moduleLangVar.'_FORM_ID'                      => $objEvent->registrationForm,
            $this->moduleLangVar.'_EVENT_DATE'                   => $objEvent->startDate,
            $this->moduleLangVar.'_USER_ID'                      => $userId,
        ));
    }
        
    /**
     * Returns the escaped value for processing csv
     * 
     * @param string $value string to be send to the csv
     * 
     * @return string escaped value for csv
     */
    function escapeCsvValue($value)
    {             
        $valueModified = stripslashes($value);                                                           
        $valueModified = preg_replace('/\r\n/', " ", $valueModified);      
        $valueModified = str_replace('"', '""', $valueModified);         

        if ($valueModified != $value || preg_match('/['.$this->csvSeparator.'\n]+/', $value)) {
            $value = '"'.$valueModified.'"';
        } 
         
        return $value;
    } 
}
