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
 * Calendar
 * 
 * @package    contrexx
 * @subpackage module_calendar
 * @author     Comvation <info@comvation.com>
 * @copyright  CONTREXX CMS - COMVATION AG
 * @version    1.00
 */
class Calendar extends CalendarLibrary
{
    /**
     * Event manager object
     *
     * @var object
     */
    private $objEventManager;
    
    /**
     * Start date
     * 
     * Unix timestamp
     *
     * @var integer
     */
    private $startDate;
    
    /**
     * End date 
     * Unix timestamp
     *
     * @var integer
     */
    private $endDate;
    
    /**
     * Category id
     *
     * @var integer
     */
    private $categoryId;
    
    /**
     * Search term
     *
     * @var string
     */
    private $searchTerm;
    
    /**
     * Need authorization
     *
     * @var boolean 
     */    
    private $needAuth;
    
    /**
     * Start position
     *
     * @var integer
     */
    private $startPos;
    
    /**
     * Number of events per  page
     *
     * @var integer
     */
    private $numEvents;
    
    /**
     * Author name
     *
     * @var string
     */
    private $author;
    
    /**
     * Sort direction
     *
     * @var string
     */
    private $sortDirection = 'ASC';

    /**
     * APge Title
     *
     * @var string
     */
    public $pageTitle;
    
    /**
     * meta title
     *
     * @var string
     */
    public $metaTitle;

    /**
     * An id unique per form submission and user.
     * This means an user can submit the same form twice at the same time,
     * and the form gets a different submission id for each submit.
     * @var integer
     */
    protected $submissionId = 0;
        
    /**
     * Event Box count
     * 
     * @var integer
     */
    public $boxCount = 3;
    
    /**
     * Constructor
     * 
     * @global array $_ARRAYLANG
     * @global object $objTemplate
     * @param string $pageContent
     */
    function __construct($pageContent)
    {
        global $_ARRAYLANG, $objTemplate;

        parent::__construct('.');
        parent::getSettings();
        
        $this->pageContent = $pageContent;
    }

    /**
     * Performs the calendar page
     * 
     * @return null
     */
    function getCalendarPage()
    {
        self::loadEventManager();


        if(isset($_GET['export'])) {
            $objEvent = new CalendarEvent(intval($_GET['export']));
            $objEvent->export();
        }

        switch ($_REQUEST['cmd']) {
            case 'detail':
                if($_GET['id'] != null && $_GET['date'] != null) {
                    self::showEvent();
                } else {
                    CSRF::header("Location: index.php?section=".$this->moduleName);
                    exit();
                }
                break;
            case 'register':
            case 'sign':
                self::showRegistrationForm();
                break;
            case 'boxes':
                if (isset($_GET['act']) && $_GET['act'] == "list") {
                    self::boxesEventList();
                } else {
                    self::showThreeBoxes();
                }
                break;
            case 'category':
                self::showCategoryView();
                break;
            case 'add':
                parent::checkAccess('add_event');
                self::modifyEvent();
                break;
            case 'edit':
                parent::checkAccess('edit_event');
                self::modifyEvent(intval($_GET['id']));
                break;
            case 'my_events':
                parent::checkAccess('my_events');
                self::myEvents();
                break;
            case 'success':
                self::showSuccessPage();
                break;
            case 'list':
            case 'eventlist':
            case 'archive':
            default:
                self::overview();
                break;
        }

        return $this->_objTpl->get();
    }

    /**
     * Loads the event manager
     *
     * @return null
     */
    function loadEventManager()
    {
        // get startdate
        if (!empty($_GET['from'])) {
            $this->startDate = parent::getDateTimestamp($_GET['from']);
        } else if ($_GET['cmd'] == 'archive') {
            $this->startDate = null;
            $this->sortDirection = 'DESC';
        } else {
            $startDay   = isset($_GET['day']) ? $_GET['day'] : date("d", mktime());
            $startMonth = isset($_GET['month']) ? $_GET['month'] : date("m", mktime());
            $startYear  = isset($_GET['year']) ? $_GET['year'] : date("Y", mktime());

            $this->startDate = mktime(0, 0, 0, $startMonth, $startDay, $startYear);
        }

        // get enddate
        if (!empty($_GET['till'])) {
            $this->endDate = parent::getDateTimestamp($_GET['till']);
        } else if ($_GET['cmd'] == 'archive') {
            $this->endDate = mktime();
        } else {
            $endDay   = isset($_GET['endDay']) ? $_GET['endDay'] : date("d", mktime());
            $endMonth = isset($_GET['endMonth']) ? $_GET['endMonth'] : date("m", mktime());
            $endYear  = isset($_GET['endYear']) ? $_GET['endYear'] : date("Y", mktime());

            $endYear = empty($_GET['endYear']) && empty($_GET['endMonth']) ? $endYear+10: $endYear;

            $this->endDate = mktime(23, 59, 59, $endMonth, $endDay, $endYear);
        }


        // get datepicker-time
         if ((isset($_REQUEST["yearID"]) ||  isset($_REQUEST["monthID"]) || isset($_REQUEST["dayID"])) && $_GET['cmd'] != 'boxes') {
            $year  = isset($_REQUEST["yearID"]) ? (int) $_REQUEST["yearID"] : date('Y');
            $month = isset($_REQUEST["monthID"]) ? (int) $_REQUEST["monthID"] : date('m');
            $day   = isset($_REQUEST["dayID"]) ? (int) $_REQUEST["dayID"] : date('d');

            $dateObj = new DateTime("{$year}-{$month}-{$day}");

            $dateObj->modify("first day of this month");
            $dateObj->setTime(0, 0, 0);
            $this->startDate = $dateObj->getTimestamp();

            // add months for the list view(month view)
            if ((empty($_GET['act']) || $_GET['act'] != 'list') && empty($_REQUEST['dayID'])) {
                $dateObj->modify("+{$this->boxCount} months");

            }

             $dateObj->modify("last day of this month");
             $dateObj->setTime(23, 59, 59);
             $this->endDate = $dateObj->getTimestamp();


         } elseif ($_GET["yearID"] && $_GET["monthID"] && $_GET["dayID"]) {

            $year = $_REQUEST["yearID"] ? $_REQUEST["yearID"] : date('Y', mktime());
            $month = $_REQUEST["monthID"] ? $_REQUEST["monthID"] : date('m', mktime());
            $day = $_REQUEST["dayID"] ? $_REQUEST["dayID"] : date('d', mktime());

            $this->startDate = mktime(0, 0, 0, $month, $day, $year);
            $this->endDate = mktime(23, 59, 59, $month, $day, $year);
        }

        $this->searchTerm = !empty($_GET['term']) ? contrexx_addslashes($_GET['term']) : null;
        $this->categoryId = !empty($_GET['catid']) ? intval($_GET['catid']) : null;




        if ($_GET['cmd'] == 'boxes' || $_GET['cmd'] == 'category') {
            $this->startPos = 0;
            $this->numEvents = 'n';
        } else if(!isset($_GET['search']) && ($_GET['cmd'] != 'list' && $_GET['cmd'] != 'eventlist' && $_GET['cmd'] != 'archive')) {
            $this->startPos = 0;
            $this->numEvents = $this->arrSettings['numEntrance'];
        } else {
            $this->startPos = isset($_GET['pos']) ? intval($_GET['pos']) : 0;
            $this->numEvents = $this->arrSettings['numPaging'];
        }

        if ($_GET['cmd'] == 'detail') {
            $this->startDate = null;
            $this->numEvents = 'n';
        }

        if ($_GET['cmd'] == 'my_events') {
            $objFWUser = FWUser::getFWUserObject();
            $objUser = $objFWUser->objUser;
            $this->author = intval($objUser->getId());
        } else {
            $this->author = null;
        }
        $this->objEventManager = new CalendarEventManager($this->startDate,$this->endDate,$this->categoryId,$this->searchTerm,true,$this->needAuth,true,$this->startPos,$this->numEvents,$this->sortDirection,true,$this->author);
        
        if($_GET['cmd'] != 'detail') {
            $this->objEventManager->getEventList();  
        } else { 
            /* if($_GET['external'] == 1 && $this->arrSettings['publicationStatus'] == 1) {
                $this->objEventManager->getExternalEvent(intval($_GET['id']), intval($_GET['date'])); 
            } else { */
                $this->objEventManager->getEvent(intval($_GET['id']), intval($_GET['date'])); 
            /* } */
        }
    }

    /**
     * performs the overview page
     * 
     * @return null
     */    
    function overview()
    {
        global $_ARRAYLANG, $_CORELANG;

        $this->_objTpl->setTemplate($this->pageContent, true, true);
        
        parent::getSettings();
        
        $dateFormat = parent::getDateFormat(1);
        
        $javascript = <<< EOF
<script language="JavaScript" type="text/javascript">

cx.ready(function() {
    var options = {
        dateFormat: '$dateFormat',        
        timeFormat: 'hh:mm'
    };
    cx.jQuery('input[name=from]').datepicker(options);
    cx.jQuery('input[name=till]').datepicker(options);
});

</script>
EOF;
        $objCategoryManager = new CalendarCategoryManager(true);
        $objCategoryManager->getCategoryList();

        $this->_objTpl->setGlobalVariable(array(
            'TXT_'.$this->moduleLangVar.'_SEARCH_TERM' =>  $_ARRAYLANG['TXT_CALENDAR_KEYWORD'],
            'TXT_'.$this->moduleLangVar.'_FROM' =>  $_ARRAYLANG['TXT_CALENDAR_FROM'],
            'TXT_'.$this->moduleLangVar.'_TILL' =>  $_ARRAYLANG['TXT_CALENDAR_TILL'],
            'TXT_'.$this->moduleLangVar.'_CATEGORY' =>  $_ARRAYLANG['TXT_CALENDAR_CAT'],
            'TXT_'.$this->moduleLangVar.'_SEARCH' =>  $_ARRAYLANG['TXT_CALENDAR_SEARCH'],
            'TXT_'.$this->moduleLangVar.'_OCLOCK' =>  $_ARRAYLANG['TXT_CALENDAR_OCLOCK'],
            'TXT_'.$this->moduleLangVar.'_DATE' =>  $_CORELANG['TXT_DATE'],
            $this->moduleLangVar.'_SEARCH_TERM' =>  $_GET['term'],
            $this->moduleLangVar.'_SEARCH_FROM' =>  $_GET['from'],
            $this->moduleLangVar.'_SEARCH_TILL' =>  $_GET['till'],
            $this->moduleLangVar.'_SEARCH_CATEGORIES' =>  $objCategoryManager->getCategoryDropdown(intval($_GET['catid']), 1),
            $this->moduleLangVar.'_JAVASCRIPT'  => $javascript
        ));
         self::showThreeBoxes();
         
        if($this->objEventManager->countEvents > $this->arrSettings['numPaging'] && (isset($_GET['search']) || $_GET['cmd'] == 'list' || $_GET['cmd'] == 'eventlist' || $_GET['cmd'] == 'archive')) {
            $pagingCmd = !empty($_GET['cmd']) ? '&amp;cmd='.$_GET['cmd'] : '';
            $pagingCategory = !empty($_GET['catid']) ? '&amp;catid='.intval($_GET['catid']) : '';
            $pagingTerm = !empty($_GET['term']) ? '&amp;term='.$_GET['term'] : '';
            $pagingSearch = !empty($_GET['search']) ? '&amp;search='.$_GET['search'] : '';
            $pagingFrom = !empty($_GET['from']) ? '&amp;from='.$_GET['from'] : '';
            $pagingTill = !empty($_GET['till']) ? '&amp;till='.$_GET['till'] : '';


            $this->_objTpl->setVariable(array(
                $this->moduleLangVar.'_PAGING' =>  getPaging($this->objEventManager->countEvents, $this->startPos, "&section=".$this->moduleName.$pagingCmd.$pagingCategory.$pagingTerm.$pagingSearch.$pagingFrom.$pagingTill, "<b>".$_ARRAYLANG['TXT_CALENDAR_EVENTS']."</b>", true, $this->arrSettings['numPaging']),
            ));
        }

        $this->objEventManager->showEventList($this->_objTpl);
    }

    /**
     * performs the my events page
     * 
     * @return null
     */    
    function myEvents()
    {
        global $_ARRAYLANG, $_CORELANG;

        $this->_objTpl->setTemplate($this->pageContent, true, true);

        $objCategoryManager = new CalendarCategoryManager(true);
        $objCategoryManager->getCategoryList();

        $this->_objTpl->setGlobalVariable(array(
            'TXT_'.$this->moduleLangVar.'_EDIT' =>  $_ARRAYLANG['TXT_CALENDAR_EDIT'],
        ));

        if($this->objEventManager->countEvents > $this->arrSettings['numPaging']) {
            $pagingCmd = !empty($_GET['cmd']) ? '&amp;cmd='.$_GET['cmd'] : '';

            $this->_objTpl->setVariable(array(
                $this->moduleLangVar.'_PAGING' =>  getPaging($this->objEventManager->countEvents, $this->startPos, "&section=".$this->moduleName.$pagingCmd, "<b>".$_ARRAYLANG['TXT_CALENDAR_EVENTS']."</b>", true, $this->arrSettings['numPaging']),
            ));
        }

        $this->objEventManager->showEventList($this->_objTpl);
    }

    /**
     * Add / Edit Event
     * 
     * @param integer $eventId Event id
     * 
     * @return null
     */    
    function modifyEvent($eventId = null)
    {
        global $_ARRAYLANG, $_CORELANG, $_LANGID;
        JS::activate('cx');
        JS::activate('jqueryui');
        
        JS::registerJS('modules/calendar/View/Script/Frontend.js');
         
        parent::getFrontendLanguages();
        parent::getSettings();
        $this->_objTpl->setTemplate($this->pageContent, true, true);
        
        $showFrom = true;
        if(isset($_POST['submitFormModifyEvent'])) {
            $objEvent = new CalendarEvent();

            $arrData = array();
            $arrData = $_POST;
            
            $arrData['access'] = 0;
            $arrData['priority'] = 3;            

            if($objEvent->save($arrData)) {
                $showFrom = false;
                $this->_objTpl->hideBlock('calendarEventModifyForm');
                $this->_objTpl->touchBlock('calendarEventOkMessage');
                
                $objMailManager = new CalendarMailManager();
                $objMailManager->sendMail($objEvent->id, CalendarMailManager::MAIL_NOTFY_NEW_APP);
            } else {
                $this->_objTpl->touchBlock('calendarEventErrMessage');
            }
        }
        
        if($eventId != null) {
            $objEvent = new CalendarEvent($eventId);
            $objEvent->getData();
        }

        $dateFormat = parent::getDateFormat(1);
        
        $locationType = $this->arrSettings['placeData'] == 3 ? ($eventId != 0 ? $objEvent->locationType : 1) : $this->arrSettings['placeData'];
        $hostType     = $this->arrSettings['placeDataHost'] == 3 ? ($eventId != 0 ? $objEvent->hostType : 1) : $this->arrSettings['placeDataHost'];
        $javascript = <<< EOF
<script language="JavaScript" type="text/javascript">
              
cx.ready(function() {
    var options = {
        dateFormat: '$dateFormat',        
        timeFormat: 'hh:mm',
        onSelect: function(dateText, inst) {
            startDateTime = cx.jQuery(".startDate").datetimepicker("getDate").getTime() / 1000;
            endDateTime   = cx.jQuery(".endDate").datetimepicker("getDate").getTime() / 1000;                

            if (startDateTime > endDateTime) {
                cx.jQuery(".endDate").datetimepicker('setDate', cx.jQuery(".startDate").val());
            }
        },
        showSecond: false
    };
    cx.jQuery('input[name=startDate]').datetimepicker(options);
    cx.jQuery('input[name=endDate]').datetimepicker(options);
    modifyEvent._handleAllDayEvent(\$J(".all_day"));
    showOrHidePlaceFields('$locationType', 'place');
    showOrHidePlaceFields('$hostType', 'host');
});

</script>
EOF;
        
        if ($showFrom) {
            try {                                
                JS::registerJS('core_modules/upload/js/uploaders/exposedCombo/extendedFileInput.js');
                
                $javascript .= <<< UPLOADER
                {$this->getUploaderCode($this->handleUniqueId(self::PICTURE_FIELD_KEY), 'pictureUpload')}
                {$this->getUploaderCode($this->handleUniqueId(self::MAP_FIELD_KEY), 'mapUpload')}
UPLOADER;
            } catch(Exception $e) {
                \DBG::msg("Error in initializing uploader");
            } 
        }

        $this->_objTpl->setGlobalVariable(array(
            $this->moduleLangVar.'_EVENT_LANG_ID'               => $_LANGID,
            $this->moduleLangVar.'_JAVASCRIPT'                  => $javascript,            
        ));

        $objCategoryManager = new CalendarCategoryManager(true);
        $objCategoryManager->getCategoryList();
        
        $this->_objTpl->setGlobalVariable(array(
            'TXT_'.$this->moduleLangVar.'_EVENT'                    => $_ARRAYLANG['TXT_CALENDAR_EVENT'],
            'TXT_'.$this->moduleLangVar.'_EVENT_DETAILS'            => $_ARRAYLANG['TXT_CALENDAR_EVENT_DETAILS'],
            'TXT_'.$this->moduleLangVar.'_SAVE'                     => $_ARRAYLANG['TXT_CALENDAR_SAVE'],
            'TXT_'.$this->moduleLangVar.'_EVENT_START'              => $_ARRAYLANG['TXT_CALENDAR_START'],
            'TXT_'.$this->moduleLangVar.'_EVENT_END'                => $_ARRAYLANG['TXT_CALENDAR_END'],
            'TXT_'.$this->moduleLangVar.'_EVENT_TITLE'              => $_ARRAYLANG['TXT_CALENDAR_TITLE'],
            'TXT_'.$this->moduleLangVar.'_EXPAND'                   => $_ARRAYLANG['TXT_CALENDAR_EXPAND'],
            'TXT_'.$this->moduleLangVar.'_MINIMIZE'                 => $_ARRAYLANG['TXT_CALENDAR_MINIMIZE'],
            'TXT_'.$this->moduleLangVar.'_EVENT_PLACE'              => $_ARRAYLANG['TXT_CALENDAR_EVENT_PLACE'],
            'TXT_'.$this->moduleLangVar.'_EVENT_STREET'             => $_ARRAYLANG['TXT_CALENDAR_EVENT_STREET'],
            'TXT_'.$this->moduleLangVar.'_EVENT_ZIP'                => $_ARRAYLANG['TXT_CALENDAR_EVENT_ZIP'],
            'TXT_'.$this->moduleLangVar.'_EVENT_CITY'               => $_ARRAYLANG['TXT_CALENDAR_EVENT_CITY'],
            'TXT_'.$this->moduleLangVar.'_EVENT_COUNTRY'            => $_ARRAYLANG['TXT_CALENDAR_EVENT_COUNTRY'],
            'TXT_'.$this->moduleLangVar.'_EVENT_MAP'                => $_ARRAYLANG['TXT_CALENDAR_EVENT_MAP'],
            'TXT_'.$this->moduleLangVar.'_EVENT_USE_GOOGLEMAPS'     => $_ARRAYLANG['TXT_CALENDAR_EVENT_USE_GOOGLEMAPS'],
            'TXT_'.$this->moduleLangVar.'_EVENT_LINK'               => $_ARRAYLANG['TXT_CALENDAR_EVENT_LINK'],
            'TXT_'.$this->moduleLangVar.'_EVENT_EMAIL'              => $_ARRAYLANG['TXT_CALENDAR_EVENT_EMAIL'],
            'TXT_'.$this->moduleLangVar.'_EVENT_PICTURE'            => $_ARRAYLANG['TXT_CALENDAR_EVENT_PICTURE'],
            'TXT_'.$this->moduleLangVar.'_EVENT_CATEGORY'           => $_ARRAYLANG['TXT_CALENDAR_CAT'] ,
            'TXT_'.$this->moduleLangVar.'_EVENT_DESCRIPTION'        => $_ARRAYLANG['TXT_CALENDAR_EVENT_DESCRIPTION'],
            'TXT_'.$this->moduleLangVar.'_PLEASE_CHECK_INPUT'       => $_ARRAYLANG['TXT_CALENDAR_PLEASE_CHECK_INPUT'],
            'TXT_'.$this->moduleLangVar.'_EVENT_HOST'               => $_ARRAYLANG['TXT_CALENDAR_EVENT_HOST'],
            'TXT_'.$this->moduleLangVar.'_EVENT_NAME'               => $_ARRAYLANG['TXT_CALENDAR_EVENT_NAME'],
            'TXT_'.$this->moduleLangVar.'_EVENT_ALL_DAY'            => $_ARRAYLANG['TXT_CALENDAR_EVENT_ALL_DAY'],
            'TXT_'.$this->moduleLangVar.'_LANGUAGE'                 => $_ARRAYLANG['TXT_CALENDAR_LANG'],
            'TXT_'.$this->moduleLangVar.'_EVENT_TYPE'               => $_ARRAYLANG['TXT_CALENDAR_EVENT_TYPE'],
            'TXT_'.$this->moduleLangVar.'_EVENT_TYPE_EVENT'         => $_ARRAYLANG['TXT_CALENDAR_EVENT_TYPE_EVENT'],
            'TXT_'.$this->moduleLangVar.'_EVENT_TYPE_REDIRECT'      => $_ARRAYLANG['TXT_CALENDAR_EVENT_TYPE_REDIRECT'],
            'TXT_'.$this->moduleLangVar.'_EVENT_DESCRIPTION'        => $_ARRAYLANG['TXT_CALENDAR_EVENT_DESCRIPTION'],
            'TXT_'.$this->moduleLangVar.'_EVENT_REDIRECT'           => $_ARRAYLANG['TXT_CALENDAR_EVENT_TYPE_REDIRECT'],
            'TXT_'.$this->moduleLangVar.'_PLACE_DATA_DEFAULT'       => $_ARRAYLANG['TXT_CALENDAR_PLACE_DATA_DEFAULT'],
            'TXT_'.$this->moduleLangVar.'_PLACE_DATA_FROM_MEDIADIR' => $_ARRAYLANG['TXT_CALENDAR_PLACE_DATA_FROM_MEDIADIR'],
            'TXT_'.$this->moduleLangVar.'_PREV'                     => $_ARRAYLANG['TXT_CALENDAR_PREV'],
            'TXT_'.$this->moduleLangVar.'_NEXT'                     => $_ARRAYLANG['TXT_CALENDAR_NEXT'],

            $this->moduleLangVar.'_EVENT_TYPE_EVENT'                => $eventId != 0 ? ($objEvent->type == 0 ? 'selected="selected"' : '') : '',      
            $this->moduleLangVar.'_EVENT_TYPE_REDIRECT'             => $eventId != 0 ? ($objEvent->type == 1 ? 'selected="selected"' : '') : '',
            $this->moduleLangVar.'_EVENT_START_DATE'                => $eventId != 0 ? date(parent::getDateFormat()." H:i", $objEvent->startDate) : date(parent::getDateFormat()." H:i"),
            $this->moduleLangVar.'_EVENT_END_DATE'                  => $eventId != 0 ? date(parent::getDateFormat()." H:i", $objEvent->endDate) : date(parent::getDateFormat()." H:i"),
            $this->moduleLangVar.'_EVENT_PICTURE'                   => $objEvent->pic,
            $this->moduleLangVar.'_EVENT_PICTURE_THUMB'             => $objEvent->pic != '' ? '<img src="'.$objEvent->pic.'.thumb" alt="'.$objEvent->title.'" title="'.$objEvent->title.'" />' : '',
            $this->moduleLangVar.'_EVENT_CATEGORIES'                => $objCategoryManager->getCategoryDropdown(intval($objEvent->catId), 2),            
            $this->moduleLangVar.'_EVENT_LINK'                      => $objEvent->link,            
            $this->moduleLangVar.'_EVENT_PLACE'                     => $objEvent->place,
            $this->moduleLangVar.'_EVENT_STREET'                    => $objEvent->place_street,
            $this->moduleLangVar.'_EVENT_ZIP'                       => $objEvent->place_zip,
            $this->moduleLangVar.'_EVENT_CITY'                      => $objEvent->place_city,
            $this->moduleLangVar.'_EVENT_COUNTRY'                   => $objEvent->place_country,
            $this->moduleLangVar.'_EVENT_PLACE_MAP'                 => $objEvent->place_map,
            $this->moduleLangVar.'_EVENT_PLACE_LINK'                => $objEvent->place_link,
            $this->moduleLangVar.'_EVENT_MAP'                       => $objEvent->map == 1 ? 'checked="checked"' : '',
            $this->moduleLangVar.'_EVENT_HOST'                      => $objEvent->org_name,
            $this->moduleLangVar.'_EVENT_HOST_ADDRESS'              => $objEvent->org_street,
            $this->moduleLangVar.'_EVENT_HOST_ZIP'                  => $objEvent->org_zip,
            $this->moduleLangVar.'_EVENT_HOST_CITY'                 => $objEvent->org_city,
            $this->moduleLangVar.'_EVENT_HOST_COUNTRY'              => $objEvent->org_country,
            $this->moduleLangVar.'_EVENT_HOST_LINK'                 => $objEvent->org_link,
            $this->moduleLangVar.'_EVENT_HOST_EMAIL'                => $objEvent->org_email,
            $this->moduleLangVar.'_EVENT_LOCATION_TYPE_MANUAL'      => $eventId != 0 ? ($objEvent->locationType == 1 ? "checked='checked'" : '') : "checked='checked'",
            $this->moduleLangVar.'_EVENT_LOCATION_TYPE_MEDIADIR'    => $eventId != 0 ? ($objEvent->locationType == 2 ? "checked='checked'" : '') : "",
            $this->moduleLangVar.'_EVENT_HOST_TYPE_MANUAL'          => $eventId != 0 ? ($objEvent->hostType == 1 ? "checked='checked'" : '') : "checked='checked'",
            $this->moduleLangVar.'_EVENT_HOST_TYPE_MEDIADIR'        => $eventId != 0 ? ($objEvent->hostType == 2 ? "checked='checked'" : '') : "",            
            
            $this->moduleLangVar.'_EVENT_ID'                        => $eventId,
            $this->moduleLangVar.'_EVENT_ALL_DAY'                   => $eventId != 0 && $objEvent->all_day ? 'checked="checked"' : '',
            $this->moduleLangVar.'_HIDE_ON_SINGLE_LANG'             => count($this->arrFrontendLanguages) == 1 ? "display: none;" : "",
        ));
        
        foreach ($this->arrFrontendLanguages as $arrLang) {
            //parse globals
            $this->_objTpl->setGlobalVariable(array(
                $this->moduleLangVar.'_EVENT_LANG_SHORTCUT'     => $arrLang['lang'],
                $this->moduleLangVar.'_EVENT_LANG_ID'           => $arrLang['id'],
                'TXT_'.$this->moduleLangVar.'_EVENT_LANG_NAME'  => $arrLang['name'],
            ));
        	
            //parse "show in" checkboxes
            $arrShowIn = explode(",", $objEvent->showIn);
            
            $langChecked = false;
            if($eventId != 0) {
                $langChecked = in_array($arrLang['id'], $arrShowIn) ? true : false;                
            } else {
                $langChecked = $arrLang['is_default'] == 'true';
            }
            
            //parse eventTabMenuDescTab
            $this->_objTpl->setVariable(array(
                $this->moduleLangVar.'_EVENT_TAB_DISPLAY' => $langChecked ? 'block' : 'none',
                $this->moduleLangVar.'_EVENT_TAB_CLASS'   => '',
            ));
            
            $this->_objTpl->parse('eventTabMenuDescTab');
            
            //parse eventDescTab
            $this->_objTpl->setVariable(array(           
                $this->moduleLangVar.'_EVENT_TAB_DISPLAY'               => $langChecked ? 'block' : 'none',
                $this->moduleLangVar.'_EVENT_TITLE'                     => !empty($objEvent->arrData['title'][$arrLang['id']]) ? $objEvent->arrData['title'][$arrLang['id']] : $objEvent->arrData['redirect'][$_LANGID],
                $this->moduleLangVar.'_EVENT_DESCRIPTION'               => new \Cx\Core\Wysiwyg\Wysiwyg("description[{$arrLang['id']}]", contrexx_raw2xhtml($objEvent->arrData['description'][$arrLang['id']]), $eventId != 0 ? 'small' : 'bbcode'),
                $this->moduleLangVar.'_EVENT_REDIRECT'                  => !empty($objEvent->arrData['redirect'][$arrLang['id']]) ? $objEvent->arrData['redirect'][$arrLang['id']] : $objEvent->arrData['redirect'][$_LANGID],
                $this->moduleLangVar.'_EVENT_TYPE_EVENT_DISPLAY'        => $objEvent->type == 0 ? 'block' : 'none',
                $this->moduleLangVar.'_EVENT_TYPE_REDIRECT_DISPLAY'     => $objEvent->type == 1 ? 'block' : 'none',
            ));
            
            $this->_objTpl->parse('eventDescTab');
                        
            $langChecked = $langChecked ? 'checked="checked"' : '';
            	
            $this->_objTpl->setVariable(array(
                $this->moduleLangVar.'_EVENT_LANG_CHECKED'  => $langChecked,
            ));
            
            $this->_objTpl->parse('eventShowIn');
                                     
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

    }

    /**
     * Performs the Event details page
     * 
     * @return null
     */    
    function showEvent()
    {
        global $_ARRAYLANG, $_CORELANG, $_LANGID;

        
        $this->_objTpl->setTemplate($this->pageContent, true, true);
        
        $this->pageTitle = html_entity_decode($this->objEventManager->eventList[0]->title, ENT_QUOTES, CONTREXX_CHARSET);
        
        $this->_objTpl->setVariable(array(
            'TXT_'.$this->moduleLangVar.'_ATTACHMENT'        =>  $_ARRAYLANG['TXT_CALENDAR_ATTACHMENT'],
            'TXT_'.$this->moduleLangVar.'_THUMBNAIL'         =>  $_ARRAYLANG['TXT_CALENDAR_THUMBNAIL'],
            'TXT_'.$this->moduleLangVar.'_OPTIONS'           =>  $_ARRAYLANG['TXT_CALENDAR_OPTIONS'],
            'TXT_'.$this->moduleLangVar.'_CATEGORY'          =>  $_ARRAYLANG['TXT_CALENDAR_CAT'],
            'TXT_'.$this->moduleLangVar.'_PLACE'             =>  $_ARRAYLANG['TXT_CALENDAR_PLACE'],
            'TXT_'.$this->moduleLangVar.'_EVENT_HOST'        =>  $_ARRAYLANG['TXT_CALENDAR_EVENT_HOST'],
            'TXT_'.$this->moduleLangVar.'_PRIORITY'          =>  $_ARRAYLANG['TXT_CALENDAR_PRIORITY'],
            'TXT_'.$this->moduleLangVar.'_START'             =>  $_ARRAYLANG['TXT_CALENDAR_START'],
            'TXT_'.$this->moduleLangVar.'_END'               =>  $_ARRAYLANG['TXT_CALENDAR_END'],
            'TXT_'.$this->moduleLangVar.'_COMMENT'           =>  $_ARRAYLANG['TXT_CALENDAR_COMMENT'],
            'TXT_'.$this->moduleLangVar.'_OCLOCK'            =>  $_ARRAYLANG['TXT_CALENDAR_OCLOCK'],
            'TXT_'.$this->moduleLangVar.'_EXPORT'            =>  $_ARRAYLANG['TXT_CALENDAR_EXPORT'],
            'TXT_'.$this->moduleLangVar.'_EVENT_PRICE'       =>  $_ARRAYLANG['TXT_CALENDAR_EVENT_PRICE'],
            'TXT_'.$this->moduleLangVar.'_EVENT_FREE_PLACES' =>  $_ARRAYLANG['TXT_CALENDAR_EVENT_FREE_PLACES'],
            'TXT_'.$this->moduleLangVar.'_DATE'              =>  $_CORELANG['TXT_DATE'],
            'TXT_'.$this->moduleLangVar.'_NAME'              =>  $_ARRAYLANG['TXT_CALENDAR_EVENT_NAME'],
            'TXT_'.$this->moduleLangVar.'_LINK'              =>  $_ARRAYLANG['TXT_CALENDAR_EVENT_LINK'],
            'TXT_'.$this->moduleLangVar.'_EVENT'             =>  $_ARRAYLANG['TXT_CALENDAR_EVENT'],
            'TXT_'.$this->moduleLangVar.'_STREET'            =>  $_ARRAYLANG['TXT_CALENDAR_EVENT_STREET'],
            'TXT_'.$this->moduleLangVar.'_ZIP'               =>  $_ARRAYLANG['TXT_CALENDAR_EVENT_ZIP'],            
            'TXT_'.$this->moduleLangVar.'_MAP'               =>  $_ARRAYLANG['TXT_CALENDAR_EVENT_MAP'],
            'TXT_'.$this->moduleLangVar.'_HOST'              =>  $_ARRAYLANG['TXT_CALENDAR_HOST'],
            'TXT_'.$this->moduleLangVar.'_MAIL'              =>  $_ARRAYLANG['TXT_CALENDAR_EVENT_EMAIL'],
            'TXT_'.$this->moduleLangVar.'_HOST_NAME'         =>  $_ARRAYLANG['TXT_CALENDAR_EVENT_NAME'],
            'TXT_'.$this->moduleLangVar.'_TITLE'             =>  $_ARRAYLANG['TXT_CALENDAR_TITLE'],
            'TXT_'.$this->moduleLangVar.'_ACCESS'            =>  $_ARRAYLANG['TXT_CALENDAR_ACCESS'],
            'TXT_'.$this->moduleLangVar.'_REGISTRATION'      =>  $_ARRAYLANG['TXT_CALENDAR_REGISTRATION'],
            'TXT_'.$this->moduleLangVar.'_REGISTRATION_INFO' =>  $_ARRAYLANG['TXT_CALENDAR_REGISTRATION_INFO']
        ));
         
        $this->objEventManager->showEvent($this->_objTpl, intval($_GET['id']), intval($_GET['date']));
    }

    /**
     * performs the registratio page
     * 
     * @return null
     */    
    function showRegistrationForm()
    {
        global $_ARRAYLANG, $_CORELANG;

        $this->_objTpl->setTemplate($this->pageContent, true, true);

        $objFWUser      = FWUser::getFWUserObject();
        $objUser        = $objFWUser->objUser;
        $userId         = intval($objUser->getId());
        $userLogin      = $objUser->login();
        $captchaCheck   = true;

        if(!$userLogin && isset($_POST['submitRegistration'])) {
            $captchaCheck =  \FWCaptcha::getInstance()->check();
            if (!$captchaCheck) {
                $this->_objTpl->setVariable(array(
                    'TXT_'.$this->moduleLangVar.'_ERROR' => '<br /><font color="#ff0000">'.$_ARRAYLANG['TXT_CALENDAR_INVALID_CAPTCHA_CODE'].'</font>',
                ));
            }
        }
        
        $objEvent = new CalendarEvent(intval($_REQUEST['id']));
        
        $numRegistrations = (int) $objEvent->registrationCount;
        
        $this->pageTitle = date("d.m.Y", (isset($_GET['date']) ? $_GET['date'] : $objEvent->startDate)).": ".html_entity_decode($objEvent->title, ENT_QUOTES, CONTREXX_CHARSET);

        if(mktime() <= intval($_REQUEST['date'])) {
            if($numRegistrations < $objEvent->numSubscriber) {
                $this->_objTpl->setVariable(array(
                    $this->moduleLangVar.'_EVENT_ID'                   =>  intval($_REQUEST['id']),
                    $this->moduleLangVar.'_FORM_ID'                    =>  intval($objEvent->registrationForm),
                    $this->moduleLangVar.'_EVENT_DATE'                 =>  intval($_REQUEST['date']),
                    $this->moduleLangVar.'_USER_ID'                    =>  $userId,
                    'TXT_'.$this->moduleLangVar.'_REGISTRATION_SUBMIT' =>  $_ARRAYLANG['TXT_CALENDAR_REGISTRATION_SUBMIT'],
                ));

                $objFormManager = new CalendarFormManager();
                $objFormManager->getFormList();
                //$objFormManager->showForm($this->_objTpl,intval($objEvent->registrationForm), 2, $objEvent->ticketSales);
                // Made the ticket sales always true, because ticket functionality currently not implemented
                $objFormManager->showForm($this->_objTpl,intval($objEvent->registrationForm), 2, true); 
                

                /* if ($this->arrSettings['paymentStatus'] == '1' && $objEvent->ticketSales && ($this->arrSettings['paymentBillStatus'] == '1' || $this->arrSettings['paymentYellowpayStatus'] == '1')) {
                    $paymentMethods  = '<select class="calendarSelect" name="paymentMethod">';
                    $paymentMethods .= $this->arrSettings['paymentBillStatus'] == '1' || $objEvent->price == 0 ? '<option value="1">'.$_ARRAYLANG['TXT_CALENDAR_PAYMENT_BILL'].'</option>'  : '';
                    $paymentMethods .= $this->arrSettings['paymentYellowpayStatus'] == '1' && $objEvent->price > 0 ? '<option value="2">'.$_ARRAYLANG['TXT_CALENDAR_PAYMENT_YELLOWPAY'].'</option>' : '';
                    $paymentMethods .= '</select>';

                    $this->_objTpl->setVariable(array(
                        'TXT_'.$this->moduleLangVar.'_PAYMENT_METHOD' => $_ARRAYLANG['TXT_CALENDAR_PAYMENT_METHOD'],
                        $this->moduleLangVar.'_PAYMENT_METHODS'       => $paymentMethods,
                    ));
                    $this->_objTpl->parse('calendarRegistrationPayment');
                } else {
                    $this->_objTpl->hideBlock('calendarRegistrationPayment');
                } */

                if(!$userLogin) {
                    
                    $this->_objTpl->setVariable(array(
                        'TXT_'.$this->moduleLangVar.'_CAPTCHA' => $_CORELANG['TXT_CAPTCHA'],
                        $this->moduleLangVar.'_CAPTCHA_CODE'   => \FWCaptcha::getInstance()->getCode(),
                    ));
                    $this->_objTpl->parse('calendarRegistrationCaptcha');
                } else {
                    $this->_objTpl->hideBlock('calendarRegistrationCaptcha');
                }

                if(isset($_POST['submitRegistration']) && $captchaCheck) {
                    $objRegistration = new CalendarRegistration(intval($_POST['form']));

                    if($objRegistration->save($_POST)) {
                        if ($objRegistration->saveIn == 2) {
                            $status = $_ARRAYLANG['TXT_CALENDAR_REGISTRATION_SUCCESSFULLY_ADDED_WAITLIST'];
                        } else if ($objRegistration->saveIn == 0) {
                            $status =$_ARRAYLANG['TXT_CALENDAR_REGISTRATION_SUCCESSFULLY_ADDED_SIGNOFF'];
                        } else {
                            $status = $_ARRAYLANG['TXT_CALENDAR_REGISTRATION_SUCCESSFULLY_ADDED'];
                            /* if($_POST["paymentMethod"] == 2) {
                                $objRegistration->get($objRegistration->id);
                                $objEvent = new CalendarEvent($objRegistration->eventId);                                
                                parent::getSettings();
                                $amount  = (int) $objEvent->price * 100;
                                $status .= CalendarPayment::_yellowpay(array("orderID" => $objRegistration->id, "amount" => $amount, "currency" => $this->arrSettings["paymentCurrency"], "language" => "DE"));
                            } */
                        }
                        $this->_objTpl->setVariable(array(
                            $this->moduleLangVar.'_LINK_BACK' =>  '<a href="'.CONTREXX_DIRECTORY_INDEX.'?section='.$this->moduleName.'">'.$_ARRAYLANG['TXT_CALENDAR_BACK'].'</a>',
                            $this->moduleLangVar.'_REGISTRATION_STATUS' =>  $status,
                        ));

                        $this->_objTpl->touchBlock('calendarRegistrationStatus');
                        $this->_objTpl->hideBlock('calendarRegistrationForm');
                    } else {                        
                        $this->_objTpl->setVariable(array(
                            'TXT_'.$this->moduleLangVar.'_ERROR' => '<br /><font color="#ff0000">'.$_ARRAYLANG['TXT_CALENDAR_CHECK_REQUIRED'].'</font>',
                        ));

                        $this->_objTpl->parse('calendarRegistrationForm');
                        $this->_objTpl->hideBlock('calendarRegistrationStatus');
                    }
                } else {
                    $this->_objTpl->parse('calendarRegistrationForm');
                    $this->_objTpl->hideBlock('calendarRegistrationStatus');
                }
            } else {
                $this->_objTpl->setVariable(array(
                    $this->moduleLangVar.'_LINK_BACK' =>  '<a href="'.CONTREXX_DIRECTORY_INDEX.'?section='.$this->moduleName.'">'.$_ARRAYLANG['TXT_CALENDAR_BACK'].'</a>',
                    $this->moduleLangVar.'_REGISTRATION_STATUS' =>  $_ARRAYLANG['TXT_CALENDAR_EVENT_FULLY_BLOCKED'],
                ));

                $this->_objTpl->touchBlock('calendarRegistrationStatus');
                $this->_objTpl->hideBlock('calendarRegistrationForm');
            }
        } else {
            $this->_objTpl->setVariable(array(
                $this->moduleLangVar.'_LINK_BACK' =>  '<a href="'.CONTREXX_DIRECTORY_INDEX.'?section='.$this->moduleName.'">'.$_ARRAYLANG['TXT_CALENDAR_BACK'].'</a>',
                $this->moduleLangVar.'_REGISTRATION_STATUS' =>  $_ARRAYLANG['TXT_CALENDAR_EVENT_IN_PAST'],
            ));

            $this->_objTpl->touchBlock('calendarRegistrationStatus');
            $this->_objTpl->hideBlock('calendarRegistrationForm');
        }
    }

    /**
     * set the placeholders for the category view
     * 
     * @return null
     */    
    function showCategoryView()
    {
        global $_ARRAYLANG, $_CORELANG;

        $this->_objTpl->setTemplate($this->pageContent, true, true);

        $objCategoryManager = new CalendarCategoryManager(true);
        $objCategoryManager->getCategoryList();

        $this->_objTpl->setGlobalVariable(array(
            'TXT_'.$this->moduleLangVar.'_SEARCH_TERM' =>  $_ARRAYLANG['TXT_CALENDAR_KEYWORD'],
            'TXT_'.$this->moduleLangVar.'_FROM' =>  $_ARRAYLANG['TXT_CALENDAR_FROM'],
            'TXT_'.$this->moduleLangVar.'_TILL' =>  $_ARRAYLANG['TXT_CALENDAR_TILL'],
            'TXT_'.$this->moduleLangVar.'_CATEGORY' =>  $_ARRAYLANG['TXT_CALENDAR_CAT'],
            'TXT_'.$this->moduleLangVar.'_SEARCH' =>  $_ARRAYLANG['TXT_CALENDAR_SEARCH'],
            'TXT_'.$this->moduleLangVar.'_OCLOCK' =>  $_ARRAYLANG['TXT_CALENDAR_OCLOCK'],
            $this->moduleLangVar.'_SEARCH_TERM' =>  $_GET['term'],
            $this->moduleLangVar.'_SEARCH_FROM' =>  $_GET['from'],
            $this->moduleLangVar.'_SEARCH_TILL' =>  $_GET['till'],
            $this->moduleLangVar.'_SEARCH_CATEGORIES' =>  $objCategoryManager->getCategoryDropdown(intval($_GET['catid']), 1)
        ));

        if(isset($this->categoryId)) {
            $objCategory = new CalendarCategory($this->categoryId);
            $this->_objTpl->setGlobalVariable(array(
                $this->moduleLangVar.'_CATEGORY_NAME' =>  $objCategory->name,
            ));

            $this->objEventManager->showEventList($this->_objTpl);

            $this->_objTpl->parse('categoryList');
        } else {
            foreach ($objCategoryManager->categoryList as $key => $objCategory) {
                $objEventManager = new CalendarEventManager($this->startDate,$this->endDate,$objCategory->id,$this->searchTerm,true,$this->needAuth,true,$this->startPos,$this->numEvents);
                $objEventManager->getEventList();

                $objEventManager->showEventList($this->_objTpl);

                $this->_objTpl->setGlobalVariable(array(
                    $this->moduleLangVar.'_CATEGORY_NAME' =>  $objCategory->name,
                ));

                $this->_objTpl->parse('categoryList');
            }
        }
    }

    /**
     * Display the success page
     * 
     * @return null
     */    
    function showSuccessPage() {
        $this->_objTpl->setTemplate($this->pageContent, true, true);
        if($_REQUEST["handler"] == "yellowpay") {
            $orderId = Yellowpay::getOrderId();
            parent::getSettings();
            if (Yellowpay::checkin($this->arrSettings["paymentYellowpayShaOut"])) {
                switch(abs($_REQUEST["result"])) {
                    case 2:
                        // fehler aufgetreten
                        $objRegistration = new CalendarRegistration(null);
                        $objRegistration->delete($orderId);
                        $this->_objTpl->touchBlock("cancelMessage");
                        break;
                    case 1:
                        // erfolgreich
                        $objRegistration = new CalendarRegistration(null);
                        $objRegistration->get($orderId);
                        $objRegistration->setPaid(1);
                        $this->_objTpl->touchBlock("successMessage");
                        break;
                    case 0:
                        // abgebrochen
                        $objRegistration = new CalendarRegistration(null);
                        $objRegistration->delete($orderId);
                        $this->_objTpl->touchBlock("cancelMessage");
                        break;
                    default:
                        CSRF::header("Location: index.php?section=".$this->moduleName);
                        break;
                }
            } else {
                CSRF::header("Location: index.php?section=".$this->moduleName);
                return;
            }            
        } else {
            CSRF::header("Location: index.php?section=".$this->moduleName);
            return;
        }
    }
        
    protected function getUploaderCode($submissionId, $fieldName, $uploadCallBack = "uploadFinished")
    {
        try {                        
            //init the uploader
            JS::activate('cx'); //the uploader needs the framework
            $f = UploadFactory::getInstance();
                                   
            //retrieve temporary location for uploaded files
            $tup = self::getTemporaryUploadPath($fieldName, $submissionId);

            //create the folder
            if (!\Cx\Lib\FileSystem\FileSystem::make_folder($tup[1].'/'.$tup[2])) {
                throw new Exception("Could not create temporary upload directory '".$tup[0].'/'.$tup[2]."'");
            }

            if (!\Cx\Lib\FileSystem\FileSystem::makeWritable($tup[1].'/'.$tup[2])) {
                //some hosters have problems with ftp and file system sync.
                //this is a workaround that seems to somehow show php that
                //the directory was created. clearstatcache() sadly doesn't
                //work in those cases.
                @closedir(@opendir($tup[0]));

                if (!\Cx\Lib\FileSystem\FileSystem::makeWritable($tup[1].'/'.$tup[2])) {
                    throw new Exception("Could not chmod temporary upload directory '".$tup[0].'/'.$tup[2]."'");
                }
            }
            
            /**
            * Name of the upload instance
            */
            $uploaderInstanceName = "exposed_combo_uploader_{$fieldName}_{$submissionId}";
            
            //initialize the widget displaying the folder contents
            $folderWidget = $f->newFolderWidget($tup[0].'/'.$tup[2]);
         
            $uploader = $f->newUploader('exposedCombo', $submissionId, true);
            $uploader->setJsInstanceName($uploaderInstanceName);
            $uploader->setFinishedCallback(array(ASCMS_MODULE_PATH.'/calendar/index.class.php','Calendar', $uploadCallBack));
            $uploader->setData(array('submission_id' => $submissionId, 'field_name' => $fieldName));
            
            $strJs  = $uploader->getXHtml();
        $strJs .= $folderWidget->getXHtml("#{$fieldName}_uploadWidget", "uploadWidget".$submissionId);
            $strJs .= <<<JAVASCRIPT
<script type="text/javascript">
    cx.ready(function() {
            var ef = new ExtendedFileInput({
                    field:  cx.jQuery('#{$fieldName}'),
                    instance: '{$uploaderInstanceName}',
                    widget: 'uploadWidget{$submissionId}'
            });
    });
</script>
JAVASCRIPT;
            return $strJs;        
        } catch (Exception $e) {
            \DBG::msg('<!-- failed initializing uploader -->');
            throw new Exception("failed initializing uploader");
        }
    }
    
    /**
     * Uploader callback function
     * 
     * @param string  $tempPath    Temp path
     * @param string  $tempWebPath Temp webpath
     * @param string  $data        post data
     * @param integer $uploadId    upload id
     * @param array   $fileInfos   file infos
     * @param object  $response    Upload api response object
     * 
     * @return array path and webpath
     */
    public static function uploadFinished($tempPath, $tempWebPath, $data, $uploadId, $fileInfos, $response) {
        global $objInit;
        
        $lang     = $objInit->loadLanguageData('calendar');
        $tup      = self::getTemporaryUploadPath($data['field_name'], $uploadId);
        $path     = $tup[0].'/'.$tup[2];
        $webPath  = $tup[1].'/'.$tup[2];
        $arrFiles = array();
        
        //get allowed file types
        $arrAllowedFileTypes = array();
        if (imagetypes() & IMG_GIF) { $arrAllowedFileTypes[] = 'gif'; }
        if (imagetypes() & IMG_JPG) { $arrAllowedFileTypes[] = 'jpg'; $arrAllowedFileTypes[] = 'jpeg'; }
        if (imagetypes() & IMG_PNG) { $arrAllowedFileTypes[] = 'png'; }

        $h = opendir($tempPath);
        if ($h) {            
            
            while(false != ($file = readdir($h))) {

                $info = pathinfo($file);                

                //skip . and ..
                if($file == '.' || $file == '..') { continue; }
                
                //delete unwanted files
                if(!in_array(strtolower($info['extension']), $arrAllowedFileTypes)) {                                     
                    $response->addMessage(
                        UploadResponse::STATUS_ERROR,
                        $lang["TXT_{$this->moduleLangVar}_IMAGE_UPLOAD_ERROR"],
                        $file
                    );
                    \Cx\Lib\FileSystem\FileSystem::delete_file($tempPath.'/'.$file);
                    continue;
                }   
                
                $arrFiles[] = $file;
            }
            closedir($h);
            
        }
                
        // Delete existing files because we need only one file to upload
        if (!empty($arrFiles)) {
            $h = opendir($path);
            if ($h) {
                while(false != ($file = readdir($h))) {
                    //skip . and ..
                    if($file == '.' || $file == '..') { continue; }
                    \Cx\Lib\FileSystem\FileSystem::delete_file($path.'/'.$file);
                }
            }
        }
        
        return array($path, $webPath);
    }
     
    /**
     * Performs the box view
     * 
     * @return null
     */
    function showThreeBoxes()
    {
        global $_ARRAYLANG;

        $objEventManager = new CalendarEventManager($this->startDate,$this->endDate,$this->categoryId,$this->searchTerm,true,$this->needAuth,true,0,'n',$this->sortDirection,true,$this->author);
        $objEventManager->getEventList();  
        $this->_objTpl->setTemplate($this->pageContent);
        if ($_REQUEST['cmd'] == 'boxes') {
            $objEventManager->calendarBoxUrl         = Cx\Core\Routing\Url::fromModuleAndCmd('calendar', 'boxes')->toString()."?act=list";
            $objEventManager->calendarBoxMonthNavUrl = Cx\Core\Routing\Url::fromModuleAndCmd('calendar', 'boxes')->toString();
        } else {
            $objEventManager->calendarBoxUrl         = Cx\Core\Routing\Url::fromModuleAndCmd('calendar', '')->toString()."?act=list";
            $objEventManager->calendarBoxMonthNavUrl = Cx\Core\Routing\Url::fromModuleAndCmd('calendar', '')->toString();
        }
        
        if (empty($_GET['catid'])) {
            $catid = 0;
        } else {
            $catid = $_GET['catid'];
        }

        if (isset($_GET['yearID']) && isset($_GET['monthID']) &&  isset($_GET['dayID'])) {
            $day   = $_GET['dayID'];
            $month = $_GET['monthID'];
            $year  = $_GET['yearID'];
        } elseif (isset($_GET['yearID']) && isset($_GET['monthID']) && !isset($_GET['dayID'])) {
            $day   = 0;
            $month = $_GET['monthID'];
            $year  = $_GET['yearID'];
        } elseif (isset($_GET['yearID']) && !isset($_GET['monthID']) && !isset($_GET['dayID'])) {
            $day    = 0;
            $month  = 0;
            $year   = $_GET['yearID'];
        } else {
            $day   = date("d");
            $month = date("m");
            $year  = date("Y");
        }
                
        $calendarbox = $objEventManager->getBoxes($this->boxCount, $year, $month, $day, $catid);

        $objCategoryManager = new CalendarCategoryManager(true);
        $objCategoryManager->getCategoryList();

        $this->_objTpl->setVariable(array(
            "TXT_{$this->moduleLangVar}_ALL_CAT" => $_ARRAYLANG['TXT_CALENDAR_ALL_CAT'],
            "{$this->moduleLangVar}_BOX"	 => $calendarbox,
            "{$this->moduleLangVar}_JAVA_SCRIPT" => $objEventManager->getCalendarBoxJS(),
            "{$this->moduleLangVar}_CATEGORIES"	 => $objCategoryManager->getCategoryDropdown($catid, 1),            
        ));        
    }
    
    /**
     * Performs the list box view
     * 
     * @return null
     */
    function boxesEventList()
    {            
        $this->_objTpl->setTemplate($this->pageContent);

        $this->_objTpl->hideBlock("boxes");

        $this->objEventManager->showEventList($this->_objTpl);
        
    }
}
