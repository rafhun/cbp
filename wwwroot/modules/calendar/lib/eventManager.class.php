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
 * Calendar Class EventManager
 * 
 * @package    contrexx
 * @subpackage module_calendar
 * @author     Comvation <info@comvation.com>
 * @copyright  CONTREXX CMS - COMVATION AG
 * @version    1.00
 */
class CalendarEventManager extends CalendarLibrary
{   
    /**
     * Start date
     *
     * @access private
     * @var integer 
     */
    private $startDate;
    
    /**
     * End date
     *
     * @access private
     * @var integer 
     */
    private $endDate;
    
    /**
     * Date
     *
     * @access private
     * @var string 
     */
    private $date;
    
    /**
     * Seprator date time
     *
     * @access private
     * @var string 
     */
    private $sepDateTime;
    
    /**
     * Time
     * 
     * @access private
     * @var string
     */
    private $time;
    
    /**
     * Clock
     *
     * @access private
     * @var string
     */
    private $clock;
    
    /**
     * Category id
     *
     * @access private
     * @var integer
     */
    private $categoryId;
    
    /**
     * show series
     * 
     * @access private
     * @var boolean
     */
    private $showSeries;
    
    /**
     * Search term
     *
     * @access private
     * @var string
     */
    private $searchTerm;
    
    /**
     * Need authorization
     *
     * @access private
     * @var boolean 
     */
    private $needAuth;
    
    /**
     * Only active
     *
     * @access public
     * @var boolean 
     */
    private $onlyActive;
    
    /**
     * Start position
     *
     * @access private
     * @var integer
     */
    private $startPos;
    
    /**
     * Num Events
     *
     * @access private
     * @var integer
     */
    private $numEvents;
    
    /**
     * Sort Direction
     *
     * @access private
     * @var string
     */
    private $sortDirection;
    
    /**
     * Only confirmed
     *
     * @access private
     * @var boolean
     */
    private $onlyConfirmed;
    
    /**
     * Author name
     *
     * @access private
     * @var string
     */
    private $author;
    
    /**
     * Event list
     *
     * @access private
     * @var array
     */
    public $eventList = array();
    
    /**
     * Event count
     *
     * @access private
     * @var integer
     */
    public $countEvents; 
    
    /**
     * show only upcoming events or all events
     * possible options are all or upcoming
     * 
     * default is all
     *
     * @var string 
     */
    public $listType;
    
    /**
     * Loads the event manager configuration
     * 
     * @param integer $startDate     Start date Unix timestamp
     * @param integer $endDate       End date timestamp
     * @param integer $categoryId    Category Id
     * @param string  $searchTerm    Search Term
     * @param boolean $showSeries    Show Series
     * @param boolean $needAuth      Need authorization
     * @param boolean $onlyActive    Only active Events
     * @param integer $startPos      Start position
     * @param integer $numEvents     Number of events
     * @param string  $sortDirection Sort direction, possible values ASC, DESC
     * @param boolean $onlyConfirmed only confirmed Entries
     * @param string  $author        author name
     */
    function __construct($startDate=null, $endDate=null, $categoryId=null, $searchTerm=null, $showSeries=true, $needAuth=false, $onlyActive=false, $startPos=0, $numEvents='n', $sortDirection='ASC', $onlyConfirmed=true, $author=null, $listType = 'all') {
        $this->startDate = intval($startDate);
        $this->endDate = intval($endDate);
        $this->categoryId = intval($categoryId);
        $this->showSeries = $showSeries;
        $this->searchTerm = contrexx_addslashes($searchTerm);
        $this->needAuth = $needAuth;
        $this->onlyActive = $onlyActive;
        $this->startPos = $startPos;
        $this->numEvents = $numEvents;
        $this->sortDirection = $sortDirection;   
        $this->onlyConfirmed = $onlyConfirmed;                  
        $this->author = $author;                  
        $this->listType = $listType;
    }
    
    /**
     * Get's list of event and assign into $this->eventList
     * 
     * @return null
     */
    function getEventList() {
        global $objDatabase, $_ARRAYLANG, $_LANGID, $objInit; 
        
        parent::getSettings();
        
        // need for database TIMESTAMP
        $startDate = !empty($this->startDate) ? date("Y-m-d H:i:s", $this->startDate) : $this->startDate;
        $endDate   = !empty($this->endDate) ? date("Y-m-d H:i:s", $this->endDate) : $this->endDate;
        
        $onlyActive_where = ($this->onlyActive == true ? ' AND event.status=1' : '');  
        $categoryId_where = ($this->categoryId != 0 ? ' AND event.catid='.$this->categoryId : '');  
        
        if($objInit->mode == 'backend') {                                             
            $showIn_where = "";     
        } else {
            if($this->arrSettings['showEventsOnlyInActiveLanguage'] == 1) {
                $showIn_where = "AND FIND_IN_SET('".$_LANGID."',event.show_in)>0 ";  
            } else {                                      
                $showIn_where = "";     
            }  
            
            $objFWUser = FWUser::getFWUserObject();   
            if ($objFWUser->objUser->login()) {
                $needAuth_where = '';     
            } else {
                $needAuth_where = ' AND event.access=0';
            } 
        }                                                                                        

        if (isset($this->endDate) && $this->endDate != 0) {
            $dateScope_where = '((
                ((event.startdate <= "'.$startDate.'") AND ("'.$endDate.'" <= event.enddate)) OR
                ((("'.$startDate.'" <= event.startdate) AND ("'.$endDate.'" <= event.enddate)) AND ((event.startdate <= "'.$endDate.'") AND ("'.$endDate.'" <= event.enddate))) OR
                (((event.startdate <= "'.$startDate.'") AND (event.enddate <= "'.$endDate.'")) AND (("'.$startDate.'" <= event.enddate) AND (event.enddate <= "'.$endDate.'"))) OR
                (("'.$startDate.'" <= event.startdate) AND (event.enddate <= "'.$endDate.'"))
            ) OR (
                (event.series_status = 1) AND (event.startdate <= "'.$endDate.'")
            ))';

        } else {                                        
            $dateScope_where = '((
                ((event.enddate >= "'.$startDate.'") AND (event.startdate <= "'.$startDate.'")) OR
                ((event.startdate >= "'.$startDate.'") AND (event.enddate >= "'.$startDate.'"))
            ) OR (
                (event.series_status = 1)
            ))';
        }
        
        if(!empty($this->searchTerm) && $this->searchTerm != $_ARRAYLANG['TXT_CALENDAR_KEYWORD']) {
            $searchTerm_DB = ", ".DBPREFIX."module_".$this->moduleTablePrefix."_event_field AS field";
            $searchTerm_where = " AND ((field.title LIKE '%".$this->searchTerm."%' OR field.description LIKE '%".$this->searchTerm."%' OR event.place LIKE '%".$this->searchTerm."%') AND field.event_id = event.id)";
        } else {
            $searchTerm_DB = "";
        }
        
        if($this->onlyConfirmed) {
            $confirmed_where =' AND (event.confirmed = 1)';
        } else {
            $confirmed_where =' AND (event.confirmed = 0)';
        }
        
        if(intval($this->author) != 0) {
            $author_where =' AND (event.author = '.intval($this->author).')';
        }  
                                                   
        $query = "SELECT event.id AS id
                    FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_event AS event
                         ".$searchTerm_DB."
                   WHERE ".$dateScope_where."
                         ".$onlyActive_where."
                         ".$needAuth_where."
                         ".$categoryId_where."
                         ".$searchTerm_where."
                         ".$showIn_where."
                         ".$confirmed_where."
                         ".$author_where."
                GROUP BY event.id
                ORDER BY event.startdate";    
        
        $objResult = $objDatabase->Execute($query);
        
        if ($objResult !== false) {
            while (!$objResult->EOF) {
                $objEvent = new CalendarEvent(intval($objResult->fields['id']));

                if($objInit->mode == 'frontend' || $this->showSeries) {
                    $checkFutureEvents = true;
                    if(self::_addToEventList($objEvent)) {
                        $this->eventList[] = $objEvent;
                        if ($this->listType == 'upcoming') {
                            $checkFutureEvents = false;
                        }
                    }

                    if ($checkFutureEvents && $objEvent->seriesStatus == 1 && $_GET['cmd'] != 'my_events') {
                        self::_setNextSeriesElement($objEvent);
                    }
                } else {
                    $this->eventList[] = $objEvent;
                }
                
                //if ($this->numEvents != 'n' && count($this->eventList) > $this->numEvents && $objInit->mode == 'frontend') {
                //     break;
                //} else {
                $objResult->MoveNext();
//              //  }
            }
        }
        
        /* if($this->arrSettings['publicationStatus'] == 1) {
            self::_importEvents();  
        } */
        
        self::_clearEmptyEvents();  
        self::_sortEventList();
        
        $this->countEvents = count($this->eventList);
        
        
        if ($this->numEvents != 'n' && $this->numEvents != 0) { 
            $this->eventList = array_slice($this->eventList, $this->startPos, $this->numEvents);    
        }
    }
         
    /**
     * Import Events
     * 
     * @return null
     */
    function _importEvents() 
    {      
        global $objDatabase, $objInit, $_LANGID, $_CONFIG;               
        
        if($objInit->mode == 'frontend') {
            parent::getSettings();
            
            $objHostManager = new CalendarHostManager($this->categoryId, true, true);
            $objHostManager->getHostList();  
             
            
            foreach($objHostManager->hostList as $key => $objHost)  {
                $id = $objHost->id;       
                $name = $objHost->title;       
                $key = $objHost->key;    
                
                if(substr($objHost->uri,-1) != '/') {
                    $uri = $objHost->uri.'/'; 
                } else {
                    $uri = $objHost->uri;
                }
                
                if(substr($objHost->uri,0,7) != 'http://') {
                    $protocol = 'http://';  
                } else {
                    $protocol = '';  
                }        
                
                $location = $protocol.$uri."modules/calendar/lib/webservice/soap.server.class.php";
              
                if(self::urlfind($protocol.$uri)){
                    $connection = true;
                } else { 
                    $connection = false;
                }                     
                
                if($connection) {         
                    if($objWebserviceClient = new CalendarWebserviceClient($location, $uri)) {      
                        $myHost = $_CONFIG['domainUrl'].ASCMS_PATH_OFFSET;   
                        
                        if(substr($myHost,-1) != '/') {
                            $myHost = $myHost.'/'; 
                        }
                        
                        $catId = $objHost->catId;
                        $key = $objHost->key;           
                                                
                        $foreignHostData = $objWebserviceClient->verifyHost($myHost,$key); 
                        
                        if($foreignHostData != false) {  
                            $arrEvents = $objWebserviceClient->getEventList($this->startDate, $this->endDate, $this->needAuth, $this->searchTerm, $_LANGID, $foreignHostData['id'], $id, $this->arrSettings['showEventsOnlyInActiveLanguage']); 

                            if(!empty($arrEvents[0])) {
                                foreach ($arrEvents as $key => $objExternalEvent) {
                                    /*$objExternalEvent->showStartDateList = intval($this->arrSettings['showStartDateList']);
                                    $objExternalEvent->showEndDateList = intval($this->arrSettings['showEndDateList']);
                                    $objExternalEvent->showStartTimeList = intval($this->arrSettings['showStartTimeList']);
                                    $objExternalEvent->showEndTimeList = intval($this->arrSettings['showEndTimeList']);
                                    $objExternalEvent->showTimeTypeList = intval($this->arrSettings['showTimeTypeList']);
                                    $objExternalEvent->showStartDateDetail = intval($this->arrSettings['showStartDateDetail']);
                                    $objExternalEvent->showEndDateDetail = intval($this->arrSettings['showEndDateDetail']);
                                    $objExternalEvent->showStartTimeDetail = intval($this->arrSettings['showStartTimeDetail']);
                                    $objExternalEvent->showEndTimeDetail = intval($this->arrSettings['showEndTimeDetail']);
                                    $objExternalEvent->showTimeTypeDetail = intval($this->arrSettings['showTimeTypeDetail']);*/

                                    if($objExternalEvent->seriesStatus == 1 && $_GET['cmd'] != 'my_events') {
                                        self::_setNextSeriesElement($objExternalEvent); 
                                    }  
                                    
                                    $this->eventList[] = $objExternalEvent;
                                }   
                            }  
                        }          
                    }
                }  
            }
        }     
    }
    
    /**
     * Clears the empty events
     * 
     * Empty events will be found if event title is empty
     * 
     * @return null
     */
    function _clearEmptyEvents() { 
         foreach($this->eventList as $key => $objEvent) {
             if(empty($objEvent->title)) {
                unset($this->eventList[$key]); 
             }
         }
    }
   
    /**
     * Checks the event for adding it into eventlist
     * 
     * This will used the check the whether the gievn event object is valid to 
     * add into event list
     * 
     * @param object $objEvent Event object
     * 
     * @return boolean true if the event is valid, false oterwise
     */
    function _addToEventList($objEvent) {
        if ($this->startDate == 0) {
            if($objEvent->endDate < $this->endDate || $this->endDate == 0) {
                return true;
            } else {
                return false;
            }
        } else { 
            if ($this->endDate == 0) {
                if(($objEvent->endDate >= $this->startDate) || ($objEvent->startDate >= $this->startDate)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                if(
                     ($objEvent->startDate >= $this->startDate && $objEvent->startDate <= $this->endDate)
                  || ($objEvent->endDate >= $this->startDate && $objEvent->endDate <= $this->endDate)  
                ) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }
    
    /**
     * Sort the event list
     * 
     * @return null
     */
    function _sortEventList(){
        usort($this->eventList, array(__CLASS__, "cmp"));
    }

    /**
     * Compare function
     * 
     * @param array $a first array
     * @param array $b second array
     * 
     * @return bool TRUE on success or FALSE on failure.
     */
    function cmp($a, $b)
    {
        if ($a->startDate == $b->startDate) {
            return 0;
        }
        
        if($this->sortDirection == 'DESC') {
            return ($a->startDate > $b->startDate) ? -1 : 1;
        } else {
            return ($a->startDate < $b->startDate) ? -1 : 1;
        }
    }
    
    /**
     * Get the event using calendar event class and assign it into $this->eventList
     * 
     * @param integer $eventId        Event id
     * @param integer $eventStartDate Unix timestamp of start date
     * 
     * @return null
     */
    function getEvent($eventId, $eventStartDate) {
        global $objInit;
        
        $objEvent = new CalendarEvent(intval($eventId));
        
        $this->eventList[] = $objEvent;
        
        if($objEvent->seriesStatus == 1 && $objInit->mode == 'frontend') {
            self::_setNextSeriesElement($objEvent); 
        }
        foreach ($this->eventList as $tmpKey => $tmpObjEvent) {  
            if ($tmpObjEvent->startDate != $eventStartDate) {
                unset($this->eventList[$tmpKey]);
            }
        }
        
        sort($this->eventList);
    }
    
    /**
     * Import events
     * 
     * @param integer $eventId        Event id
     * @param integer $eventStartDate Unix timestamp of start date
     * 
     * @return null
     */
    function getExternalEvent($eventId, $eventStartDate) {
        global $objInit;
        
        self::_importEvents();  

        foreach ($this->eventList as $tmpKey => $tmpObjEvent) {          
            if ($tmpObjEvent->startDate != $eventStartDate) {
                unset($this->eventList[$tmpKey]);
            }
        }
        
        sort($this->eventList);
    }
    
    /**
     * Sets the placeholders used for the event
     * 
     * @param object  $objTpl         Template object
     * @param integer $eventId        Event Id
     * @param integer $eventStartDate Description
     * 
     * @return null
     */
    function showEvent($objTpl, $eventId, $eventStartDate) {   
        global $objInit, $_ARRAYLANG, $_LANGID, $_CONFIG;
        
        parent::getSettings();
        
        if($objInit->mode == 'frontend' && ($eventId != null && $eventStartDate != null)) {   
            $objEvent = $this->eventList[0];
            
            if(empty($objEvent)) {
                CSRF::header("Location: index.php?section=".$this->moduleName);
                return;   
            }
            
            if($objEvent->access == 1 && !FWUser::getFWUserObject()->objUser->login()){
                $link = base64_encode(CONTREXX_SCRIPT_PATH.'?'.$_SERVER['QUERY_STRING']);           
                CSRF::header("Location: ".CONTREXX_SCRIPT_PATH."?section=login&redirect=".$link);  
                return;    
            }   
            
            $objCategory = new CalendarCategory($objEvent->catId);     
            
            list ($priority, $priorityImg) = $this->getPriorityImage($objEvent);
            
            $plainDescription = contrexx_html2plaintext($objEvent->description);
            if (strlen($plainDescription) > 100) {
                $points = '...';
            } else {
                $points = '';
            }
            $parts= explode("\n", wordwrap($plainDescription, 100, "\n"));

            $attachNamePos  = strrpos($objEvent->attach, '/');
            $attachNamelength = strlen($objEvent->attach);
            $attachName        = substr($objEvent->attach, $attachNamePos+1, $attachNamelength);
            
            if($objEvent->external) {   
                $objHost = new CalendarHost($objEvent->hostId);    
                
                if(substr($objHost->uri,-1) != '/') {   
                     $hostUri = $objHost->uri.'/';  
                } else {         
                     $hostUri = $objHost->uri; 
                }     
                
                if(substr($hostUri,0,7) != 'http://') {
                    $hostUri = "http://".$hostUri;
                }
                        
                $hostTarget = 'target="_blank"';    
            }     
        
            if($this->arrSettings['showEventsOnlyInActiveLanguage'] == 2) {
                $_LANGID = $objEvent->availableLang;       
            }            

            $picThumb = file_exists(ASCMS_PATH.$objEvent->pic.".thumb") ? $objEvent->pic.".thumb" : $objEvent->pic;
                        
            $numRegistrations  = (int) $objEvent->registrationCount;                         
            $numDeregistration = (int) $objEvent->cancellationCount;
            
            $objEscortManager = new CalendarRegistrationManager($objEvent->id, true, false);            

            $objTpl->setVariable(array(
                $this->moduleLangVar.'_EVENT_ID'                => $objEvent->id,
                $this->moduleLangVar.'_EVENT_START'             => date(parent::getDateFormat()." H:i", $objEvent->startDate),
                $this->moduleLangVar.'_EVENT_END'               => date(parent::getDateFormat()." H:i", $objEvent->endDate),
                $this->moduleLangVar.'_EVENT_START_DATE'        => date(parent::getDateFormat(), $objEvent->startDate),
                $this->moduleLangVar.'_EVENT_START_TIME'        => date("H:i", $objEvent->startDate),  
                $this->moduleLangVar.'_EVENT_END_DATE'          => date(parent::getDateFormat(), $objEvent->endDate),
                $this->moduleLangVar.'_EVENT_END_TIME'          => date("H:i", $objEvent->endDate),                                                       
                $this->moduleLangVar.'_EVENT_TITLE'             => $objEvent->title,                                                      
                $this->moduleLangVar.'_EVENT_ATTACHMENT'        => $objEvent->attach != '' ? '<a href="'.$hostUri.$objEvent->attach.'" target="_blank" >'.$attachName.'</a>' : '',                             
                $this->moduleLangVar.'_EVENT_ATTACHMENT_SOURCE' => $objEvent->attach,
                $this->moduleLangVar.'_EVENT_PICTURE'           => $objEvent->pic != '' ? '<img src="'.$hostUri.$objEvent->pic.'" alt="'.$objEvent->title.'" title="'.$objEvent->title.'" />' : '',                                                          
                $this->moduleLangVar.'_EVENT_PICTURE_SOURCE'    => $objEvent->pic,
                $this->moduleLangVar.'_EVENT_THUMBNAIL'         => $picThumb != '' ? '<img src="'.$hostUri.$picThumb.'" alt="'.$objEvent->title.'" title="'.$objEvent->title.'" />' : '',   
                $this->moduleLangVar.'_EVENT_DESCRIPTION'       => $objEvent->description,    
                $this->moduleLangVar.'_EVENT_SHORT_DESCRIPTION' => $parts[0].$points,
                $this->moduleLangVar.'_EVENT_PRIORITY'          => $priority,                                                           
                $this->moduleLangVar.'_EVENT_PRIORITY_IMG'      => $priorityImg,                                                           
                $this->moduleLangVar.'_EVENT_CATEGORY'          => $objCategory->name,
                $this->moduleLangVar.'_EVENT_EXPORT_LINK'       => $hostUri.'index.php?section='.$this->moduleName.'&amp;export='.$objEvent->id,
                $this->moduleLangVar.'_EVENT_EXPORT_ICON'       => '<a href="'.$hostUri.'index.php?section='.$this->moduleName.'&amp;export='.$objEvent->id.'"><img src="images/modules/calendar/ical_export.gif" border="0" title="'.$_ARRAYLANG['TXT_CALENDAR_EXPORT_ICAL_EVENT'].'" alt="'.$_ARRAYLANG['TXT_CALENDAR_EXPORT_ICAL_EVENT'].'" /></a>',
                $this->moduleLangVar.'_EVENT_PRICE'             => $this->arrSettings['paymentCurrency'].' '.$objEvent->price,
                $this->moduleLangVar.'_EVENT_FREE_PLACES'       => $objEvent->freePlaces == 0 ? $objEvent->freePlaces.' ('.$_ARRAYLANG['TXT_CALENDAR_SAVE_IN_WAITLIST'].')' : $objEvent->freePlaces,
                $this->moduleLangVar.'_EVENT_ACCESS'            => $_ARRAYLANG['TXT_CALENDAR_EVENT_ACCESS_'.$objEvent->access],
                $this->moduleLangVar.'_EVENT_COUNT_REG'         => $numRegistrations,
                $this->moduleLangVar.'_EVENT_COUNT_SIGNOFF'     => $numDeregistration,
                $this->moduleLangVar.'_EVENT_COUNT_SUBSCRIBER'  => $objEscortManager->getEscortData(),
                $this->moduleLangVar.'_REGISTRATIONS_SUBSCRIBER'=> $objEvent->numSubscriber,
            ));

            //show date and time by user settings
            if($objTpl->blockExists('calendarDateDetail')) {
                
                $showStartDateDetail  = $objEvent->useCustomDateDisplay ? $objEvent->showStartDateDetail : ($this->arrSettings['showStartDateDetail'] == 1);
                $showEndDateDetail    = $objEvent->useCustomDateDisplay ? $objEvent->showEndDateDetail : ($this->arrSettings['showEndDateDetail'] == 1);
                $showStartTimeDetail  = ($objEvent->all_day) ? false : ($objEvent->useCustomDateDisplay ? $objEvent->showStartTimeDetail : ($this->arrSettings['showStartTimeDetail'] == 1));
                $showEndTimeDetail    = ($objEvent->all_day) ? false : ($objEvent->useCustomDateDisplay ? $objEvent->showEndTimeDetail : ($this->arrSettings['showEndTimeDetail'] == 1));
                $showTimeTypeDetail   = $objEvent->useCustomDateDisplay ? $objEvent->showTimeTypeDetail : 1;
                
                // get date for several days format > show starttime with startdate and endtime with enddate > only if several days event and all values (dates/times) are displayed
                if(date(parent::getDateFormat(), $objEvent->startDate) != date(parent::getDateFormat(), $objEvent->endDate) && ($showStartDateDetail && $showEndDateDetail && $showStartTimeDetail && $showEndTimeDetail)) {
                    //part 1
                    $part = 1;
                    $this->getMultiDateBlock($objEvent, $this->arrSettings['separatorDateTimeDetail'], $this->arrSettings['separatorSeveralDaysDetail'], ($this->arrSettings['showClockDetail'] == 1), $part);
                    
                    $objTpl->setVariable(array(
                        $this->moduleLangVar.'_DATE_DETAIL'                => $this->date,
                        $this->moduleLangVar.'_SEP_DATE_TIME_DETAIL'       => $this->sepDateTime,
                        $this->moduleLangVar.'_TIME_DETAIL'                => $this->time,
                        'TXT_'.$this->moduleLangVar.'_CLOCK_DETAIL'        => $this->clock,
                    ));
                    
                    $objTpl->parse('calendarDateDetail');

                    //part 2
                    $part = 2;
                    $this->getMultiDateBlock($objEvent, $this->arrSettings['separatorDateTimeDetail'], $this->arrSettings['separatorSeveralDaysDetail'], ($this->arrSettings['showClockDetail'] == 1), $part);

                    $objTpl->setVariable(array(
                        $this->moduleLangVar.'_DATE_DETAIL'                => $this->date,
                        $this->moduleLangVar.'_SEP_DATE_TIME_DETAIL'       => $this->sepDateTime,
                        $this->moduleLangVar.'_TIME_DETAIL'                => $this->time,
                        'TXT_'.$this->moduleLangVar.'_CLOCK_DETAIL'        => $this->clock,
                    ));
                    $objTpl->parse('calendarDateDetail');
                } else {
                    // get date for single day format
                    $this->getSingleDateBlock($objEvent, $showStartDateDetail, $showEndDateDetail, $this->arrSettings['separatorDateDetail'], $showTimeTypeDetail, $showStartTimeDetail, $showEndTimeDetail, $this->arrSettings['separatorDateTimeDetail'], $this->arrSettings['separatorTimeDetail'], ($this->arrSettings['showClockDetail'] == 1));

                    $objTpl->setVariable(array(
                        $this->moduleLangVar.'_DATE_DETAIL'                => $this->date,
                        $this->moduleLangVar.'_SEP_DATE_TIME_DETAIL'       => $this->sepDateTime,
                        $this->moduleLangVar.'_TIME_DETAIL'                => $this->time,
                        'TXT_'.$this->moduleLangVar.'_CLOCK_DETAIL'        => $this->clock,
                    ));
                    $objTpl->parse('calendarDateDetail');
                }
            }
            
            if (($this->arrSettings['placeData'] == 1) && $objEvent->place == '' && $objEvent->place_street == '' && $objEvent->place_zip == '' && $objEvent->place_city == '' && $objEvent->place_country == '') {
                $objTpl->hideBlock('calendarEventAddress');  
            } else {
                /* if($objEvent->map == 1) { 
                    $googleCoordinates = self::_getCoorinates($objEvent->place_street, $objEvent->place_zip, $objEvent->place_city);
                    if($googleCoordinates != false) {
                        $lat = $googleCoordinates[0];
                        $lon = $googleCoordinates[1];  
                                             
                        $objGoogleMap = new googleMap();
                        $objGoogleMap->setMapId($this->moduleName.'GoogleMap');
                        $objGoogleMap->setMapStyleClass('mapLarge');
                        $objGoogleMap->setMapType(0);                                                          
                        $objGoogleMap->setMapZoom(12);
                        $objGoogleMap->setMapCenter($lon, $lat);   
                        
                        $strValueClick = 'marker'.$objEvent->id.'.openInfoWindowHtml(info'.$objEvent->id.');';   
                        $objGoogleMap->addMapMarker($objEvent->id, $lon, $lat, "<b>".$objEvent->place."</b><br />".$objEvent->place_street."<br />".$objEvent->place_zip." ".$objEvent->place_city."<br />".$objEvent->place_country,true, null, true, $strValueClick, null, null);   
                        
                        $googleMap = $objGoogleMap->getMap();
                    } else {
                        $googleMap = '<a href="http://maps.google.ch/maps?q='.$objEvent->place_street.'+'.$objEvent->place_zip.'+'.$objEvent->place_city.'&z=15" target="_blank">'.$_ARRAYLANG['TXT_CALENDAR_MAP'].'</a>';
                    }
                } else {
                    $googleMap = '';
                } */
                
                //place map
                $arrInfo   = getimagesize(ASCMS_PATH.$objEvent->place_map);
                $picWidth  = $arrInfo[0]+20;
                $picHeight = $arrInfo[1]+20;
                
                $map_thumb_name = file_exists(ASCMS_PATH.$objEvent->place_map.".thumb") ? $objEvent->place_map.".thumb" : $objEvent->place_map;

                
                $placeLink         = $objEvent->place_link != '' ? "<a href='".$objEvent->place_link."' target='_blank' >".$objEvent->place_link."</a>" : "";
                $placeLinkSource   = $objEvent->place_link;
                if ($this->arrSettings['placeData'] > 1 && $objEvent->locationType == 2) {
                    $objEvent->loadPlaceFromMediadir($objEvent->place_mediadir_id, 'place');
                    list($placeLink, $placeLinkSource) = $objEvent->loadPlaceLinkFromMediadir($objEvent->place_mediadir_id, 'place');                    
                }
                
                $objTpl->setVariable(array(                                                          
                    $this->moduleLangVar.'_EVENT_PLACE'           => $objEvent->place,
                    $this->moduleLangVar.'_EVENT_LOCATION_ADDRESS'=> $objEvent->place_street,
                    $this->moduleLangVar.'_EVENT_LOCATION_ZIP'    => $objEvent->place_zip,
                    $this->moduleLangVar.'_EVENT_LOCATION_CITY'   => $objEvent->place_city,
                    $this->moduleLangVar.'_EVENT_LOCATION_COUNTRY'=> $objEvent->place_country,                                                  
                    $this->moduleLangVar.'_EVENT_LOCATION_LINK'          => $placeLink,
                    $this->moduleLangVar.'_EVENT_LOCATION_LINK_SOURCE'   => $placeLinkSource,
                    $this->moduleLangVar.'_EVENT_LOCATION_MAP_LINK'        => $objEvent->place_map != '' ? '<a href="'.$objEvent->place_map.'" onClick="window.open(this.href,\'\',\'resizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=no,width='.$picWidth.',height='.$picHeight.',status\'); return false">'.$_ARRAYLANG['TXT_CALENDAR_MAP'].'</a>' : "",
                    $this->moduleLangVar.'_EVENT_LOCATION_MAP_THUMBNAIL'   => $objEvent->place_map != '' ? '<a href="'.$objEvent->place_map.'" onClick="window.open(this.href,\'\',\'resizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=no,width='.$picWidth.',height='.$picHeight.',status\'); return false"><img src="'.$map_thumb_name.'" border="0" alt="'.$objEvent->place_map.'" /></a>' : "",
                    $this->moduleLangVar.'_EVENT_LOCATION_MAP_SOURCE'      => $objEvent->place_map,
                    //$this->moduleLangVar.'_EVENT_MAP'             => $googleMap,
                ));
                
                $objTpl->parse('calendarEventAddress'); 
            }
            
            $hostLink         = $objEvent->org_link != '' ? "<a href='".$objEvent->org_link."' target='_blank' >".$objEvent->org_link."</a>" : "";
            $hostLinkSource   = $objEvent->org_link;
            if ($this->arrSettings['placeDataHost'] > 1 && $objEvent->hostType == 2) {
                $objEvent->loadPlaceFromMediadir($objEvent->host_mediadir_id, 'host');
                list($hostLink, $hostLinkSource) = $objEvent->loadPlaceLinkFromMediadir($objEvent->host_mediadir_id, 'host');                    
            }
            if(($this->arrSettings['placeDataHost'] == 1) && $objEvent->org_name == '' && $objEvent->org_street == '' && $objEvent->org_zip == '' && $objEvent->org_city == '' && $objEvent->org_country == '') {
                $objTpl->hideBlock('calendarEventHost');  
            } else {
                $objTpl->setVariable(array(
                    $this->moduleLangVar.'_EVENT_HOST'         => $objEvent->org_name,
                    $this->moduleLangVar.'_EVENT_HOST_ADDRESS' => $objEvent->org_street,
                    $this->moduleLangVar.'_EVENT_HOST_ZIP'     => $objEvent->org_zip,
                    $this->moduleLangVar.'_EVENT_HOST_CITY'    => $objEvent->org_city,
                    $this->moduleLangVar.'_EVENT_HOST_COUNTRY' => $objEvent->org_country,
                    $this->moduleLangVar.'_EVENT_HOST_LINK'    => $hostLink,
                    $this->moduleLangVar.'_EVENT_HOST_LINK_SOURCE'  => $hostLinkSource,
                    $this->moduleLangVar.'_EVENT_HOST_EMAIL'        => $objEvent->org_email != '' ? "<a href='mailto:".$objEvent->org_email."' >".$objEvent->org_email."</a>" : "",
                    $this->moduleLangVar.'_EVENT_HOST_EMAIL_SOURCE' => $objEvent->org_email,
                ));    
                
                $objTpl->parse('calendarEventHost');
            }
             
            if(($objEvent->registration == 1) && (mktime() <= $objEvent->startDate)) {  
                
                if($numRegistrations < $objEvent->numSubscriber || $objEvent->external == 1) {
                    $regLink = '<a href="'.$hostUri.CONTREXX_DIRECTORY_INDEX.'?section='.$this->moduleName.'&amp;cmd=register&amp;id='.$objEvent->id.'&amp;date='.$objEvent->startDate.'" '.$hostTarget.'>'.$_ARRAYLANG['TXT_CALENDAR_REGISTRATION'].'</a>';
                } else {
                    $regLink = '<i>'.$_ARRAYLANG['TXT_CALENDAR_EVENT_FULLY_BLOCKED'].'</i>';
                }
                $objTpl->setVariable(array(
                    $this->moduleLangVar.'_EVENT_REGISTRATION_LINK'    => $regLink,
                ));
                
                $objTpl->parse('calendarEventRegistration');
            } else {   
                $objTpl->hideBlock('calendarEventRegistration');
            } 
        }
    }
    
    /**
     * Sets the placeholders used for the event list view
     * 
     * @param object  $objTpl Template object
     * @param integer $type   Event type
     * 
     * @return null
     */
    function showEventList($objTpl, $type='') {
        global $objInit, $_ARRAYLANG, $_LANGID;
        
        parent::getFrontendLanguages();
        
        //if($objInit->mode == 'backend') {
            $i=0;
            foreach ($this->eventList as $key => $objEvent) {
                
                $objCategory = new CalendarCategory(intval($objEvent->catId));   
                
                $showIn = explode(",",$objEvent->showIn);
                
                $languages = '';
                if (count(\FWLanguage::getActiveFrontendLanguages()) > 1) {
                    $langState = array();
                    foreach ($this->arrFrontendLanguages as $langKey => $arrLang) {
                        if (in_array($arrLang['id'], $showIn)) {
                            $langState[$langKey] = 'active';
                        }
                    }
                    $languages = \Html::getLanguageIcons($langState, 'index.php?cmd=calendar&amp;act=modify_event&amp;id=' . $objEvent->id . '&amp;langId=%1$d'.($type == 'confirm' ? "&amp;confirm=1" : ""));
                    
                    if($type == 'confirm' && $objTpl->blockExists('txt_languages_block_confirm_list')) {
                        $objTpl->touchBlock('txt_languages_block_confirm_list');
                    } elseif ($objTpl->blockExists('txt_languages_block')) {
                        $objTpl->touchBlock('txt_languages_block');
                    }
                } else {
                    if($type == 'confirm' && $objTpl->blockExists('txt_languages_block_confirm_list')) {
                        $objTpl->hideBlock('txt_languages_block_confirm_list');
                    } elseif ($objTpl->blockExists('txt_languages_block')) {
                        $objTpl->hideBlock('txt_languages_block');
                    }
                }
                
                list ($priority, $priorityImg) = $this->getPriorityImage($objEvent);
                
                $plainDescription = contrexx_html2plaintext($objEvent->description);
                if (strlen($plainDescription) > 100) {
                    $points = '...';
                } else {
                    $points = '';
                }
                $parts= explode("\n", wordwrap($plainDescription, 100, "\n"));
                
                $attachNamePos    = strrpos($objEvent->attach, '/');
                $attachNamelength = strlen($objEvent->attach);
                $attachName       = substr($objEvent->attach, $attachNamePos+1, $attachNamelength);

                if($objEvent->external) {
                    $objHost = new CalendarHost($objEvent->hostId);    

                    if(substr($objHost->uri,-1) != '/') {   
                         $hostUri = $objHost->uri.'/';  
                    } else {         
                         $hostUri = $objHost->uri; 
                    }     

                    if(substr($hostUri,0,7) != 'http://') {
                        $hostUri = "http://".$hostUri;
                    }                    
                }
                $copyLink = '';
                if($objInit->mode == 'backend') {
                    $editLink = 'index.php?cmd='.$this->moduleName.'&amp;act=modify_event&id='.$objEvent->id.($type == 'confirm' ? "&amp;confirm=1" : "");
                    $copyLink = $editLink."&amp;copy=1";
                } else {
                    $editLink = CONTREXX_DIRECTORY_INDEX.'?section='.$this->moduleName.'&amp;cmd=edit&id='.$objEvent->id;
                }
                $picThumb = file_exists(ASCMS_PATH."{$objEvent->pic}.thumb") ? "{$objEvent->pic}.thumb" : ($objEvent->pic != '' ? $objEvent->pic : '');
                
                $placeLink         = $objEvent->place_link != '' ? "<a href='".$objEvent->place_link."' target='_blank' >".$objEvent->place_link."</a>" : "";
                $placeLinkSource   = $objEvent->place_link;
                if ($this->arrSettings['placeData'] > 1 && $objEvent->locationType == 2) {
                    $objEvent->loadPlaceFromMediadir($objEvent->place_mediadir_id, 'place');
                    list($placeLink, $placeLinkSource) = $objEvent->loadPlaceLinkFromMediadir($objEvent->place_mediadir_id, 'place');                    
                }
                $hostLink         = $objEvent->org_link != '' ? "<a href='".$objEvent->org_link."' target='_blank' >".$objEvent->org_link."</a>" : "";
                $hostLinkSource   = $objEvent->org_link;
                if ($this->arrSettings['placeDataHost'] > 1 && $objEvent->hostType == 2) {
                    $objEvent->loadPlaceFromMediadir($objEvent->host_mediadir_id, 'host');
                    list($hostLink, $hostLinkSource) = $objEvent->loadPlaceLinkFromMediadir($objEvent->host_mediadir_id, 'host');                    
                }
                
                $objTpl->setVariable(array(
                    $this->moduleLangVar.'_EVENT_ROW'            => $i%2==0 ? 'row1' : 'row2',
                    $this->moduleLangVar.'_EVENT_LED'            => $objEvent->status==0 ? 'red' : 'green',
                    $this->moduleLangVar.'_EVENT_STATUS'         => $objEvent->status==0 ? $_ARRAYLANG['TXT_CALENDAR_INACTIVE'] : $_ARRAYLANG['TXT_CALENDAR_ACTIVE'],
                    $this->moduleLangVar.'_EVENT_ID'             => $objEvent->id,                                        
                    $this->moduleLangVar.'_EVENT_TITLE'          => $objEvent->title,                                                         
                    $this->moduleLangVar.'_EVENT_PICTURE'        => $objEvent->pic != '' ? '<img src="'.$objEvent->pic.'" alt="'.$objEvent->title.'" title="'.$objEvent->title.'" />' : '',                                                          
                    $this->moduleLangVar.'_EVENT_PICTURE_SOURCE' => $objEvent->pic,
                    $this->moduleLangVar.'_EVENT_THUMBNAIL'      => $objEvent->pic != '' ? '<img src="'.$picThumb.'" alt="'.$objEvent->title.'" title="'.$objEvent->title.'" />' : '',                                                               
                    $this->moduleLangVar.'_EVENT_PRIORITY'       => $priority,                                                           
                    $this->moduleLangVar.'_EVENT_PRIORITY_IMG'   => $priorityImg, 
                    $this->moduleLangVar.'_EVENT_PLACE'          => $objEvent->place,
                    $this->moduleLangVar.'_EVENT_DESCRIPTION'    => $objEvent->description,
                    $this->moduleLangVar.'_EVENT_SHORT_DESCRIPTION' => $parts[0].$points,
                    $this->moduleLangVar.'_EVENT_LINK'           => $objEvent->link ? "<a href='".$objEvent->link."' target='_blank' >".$objEvent->link."</a>" : "",
                    $this->moduleLangVar.'_EVENT_LINK_SOURCE'    => $objEvent->link,
                    $this->moduleLangVar.'_EVENT_ATTACHMENT'     => $objEvent->attach != '' ? '<a href="'.$hostUri.$objEvent->attach.'" target="_blank" >'.$attachName.'</a>' : '',
                    $this->moduleLangVar.'_EVENT_ATTACHMENT_SOURCE' => $objEvent->attach,
                    $this->moduleLangVar.'_EVENT_START'          => date(parent::getDateFormat()." H:i", $objEvent->startDate),
                    $this->moduleLangVar.'_EVENT_END'            => date(parent::getDateFormat()." H:i", $objEvent->endDate),
                    $this->moduleLangVar.'_EVENT_DATE'           => date(parent::getDateFormat(), $objEvent->startDate),
                    $this->moduleLangVar.'_EVENT_START_DATE'     => date(parent::getDateFormat(), $objEvent->startDate),
                    $this->moduleLangVar.'_EVENT_START_TIME'     => date("H:i", $objEvent->startDate),
                    $this->moduleLangVar.'_EVENT_END_DATE'       => date(parent::getDateFormat(), $objEvent->endDate),
                    $this->moduleLangVar.'_EVENT_END_TIME'       => date("H:i", $objEvent->endDate),    
                    $this->moduleLangVar.'_EVENT_LANGUAGES'      => $languages,
                    $this->moduleLangVar.'_EVENT_CATEGORY'       => $objCategory->name,
                    $this->moduleLangVar.'_EVENT_DETAIL_LINK'    => $objEvent->type==0 ? self::_getDetailLink($objEvent) : $objEvent->arrData['redirect'][$_LANGID],
                    $this->moduleLangVar.'_EVENT_EDIT_LINK'      => $editLink,                    
                    $this->moduleLangVar.'_EVENT_COPY_LINK'      => $copyLink,                    
                    $this->moduleLangVar.'_EVENT_DETAIL_TARGET'  => $objEvent->type==0 ? '_self' : '_blank',
                    $this->moduleLangVar.'_EVENT_SERIES'         => $objEvent->seriesStatus == 1 ? '<img src="'.ASCMS_MODULE_WEB_PATH.'/'.$this->moduleName.'/View/Media/Repeat.png" border="0"/>' : '<i>'.$_ARRAYLANG['TXT_CALENDAR_NO_SERIES'].'</i>',
                    $this->moduleLangVar.'_EVENT_FREE_PLACES'    => $objEvent->freePlaces,
                    $this->moduleLangVar.'_EVENT_ACCESS'         => $_ARRAYLANG['TXT_CALENDAR_EVENT_ACCESS_'.$objEvent->access],
                ));              
            
                $arrInfo   = getimagesize(ASCMS_PATH.$objEvent->place_map);
                $picWidth  = $arrInfo[0]+20;
                $picHeight = $arrInfo[1]+20;
                
                $map_thumb_name = file_exists(ASCMS_PATH.$objEvent->place_map.".thumb") ? $objEvent->place_map.".thumb" : $objEvent->place_map;
                $objTpl->setVariable(array(                                                          
                    $this->moduleLangVar.'_EVENT_LOCATION_PLACE'         => $objEvent->place,
                    $this->moduleLangVar.'_EVENT_LOCATION_ADDRESS'       => $objEvent->place_street,
                    $this->moduleLangVar.'_EVENT_LOCATION_ZIP'           => $objEvent->place_zip,
                    $this->moduleLangVar.'_EVENT_LOCATION_CITY'          => $objEvent->place_city,
                    $this->moduleLangVar.'_EVENT_LOCATION_COUNTRY'       => $objEvent->place_country,                                                  
                    $this->moduleLangVar.'_EVENT_LOCATION_LINK'          => $placeLink,
                    $this->moduleLangVar.'_EVENT_LOCATION_LINK_SOURCE'   => $placeLinkSource,
                    $this->moduleLangVar.'_EVENT_LOCATION_MAP_LINK'      => $objEvent->place_map != '' ? '<a href="'.$objEvent->place_map.'" onClick="window.open(this.href,\'\',\'resizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=no,width='.$picWidth.',height='.$picHeight.',status\'); return false">'.$_ARRAYLANG['TXT_CALENDAR_MAP'].'</a>' : "",
                    $this->moduleLangVar.'_EVENT_LOCATION_MAP_THUMBNAIL' => $objEvent->place_map != '' ? '<a href="'.$objEvent->place_map.'" onClick="window.open(this.href,\'\',\'resizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=no,width='.$picWidth.',height='.$picHeight.',status\'); return false"><img src="'.$map_thumb_name.'" border="0" alt="'.$objEvent->place_map.'" /></a>' : "",
                    $this->moduleLangVar.'_EVENT_LOCATION_MAP_SOURCE'    => $objEvent->place_map,
                    
                    $this->moduleLangVar.'_EVENT_HOST'              => $objEvent->org_name,
                    $this->moduleLangVar.'_EVENT_HOST_ADDRESS'      => $objEvent->org_street,
                    $this->moduleLangVar.'_EVENT_HOST_ZIP'          => $objEvent->org_zip,
                    $this->moduleLangVar.'_EVENT_HOST_CITY'         => $objEvent->org_city,
                    $this->moduleLangVar.'_EVENT_HOST_COUNTRY'      => $objEvent->org_country,
                    $this->moduleLangVar.'_EVENT_HOST_LINK'         => $hostLink,
                    $this->moduleLangVar.'_EVENT_HOST_LINK_SOURCE'  => $hostLinkSource,
                    $this->moduleLangVar.'_EVENT_HOST_EMAIL'        => $objEvent->org_email != '' ? "<a href='mailto:".$objEvent->org_email."' >".$objEvent->org_email."</a>" : "",
                    $this->moduleLangVar.'_EVENT_HOST_EMAIL_SOURCE' => $objEvent->org_email,
                ));
                
                if($objInit->mode == 'backend') {
                    $objTpl->setVariable(array(
                        $this->moduleLangVar.'_EVENT_COUNT_REG'      => $objEvent->registrationCount,
                        $this->moduleLangVar.'_EVENT_COUNT_DEREG'    => $objEvent->cancellationCount,
                        $this->moduleLangVar.'_EVENT_COUNT_WAITLIST' => $objEvent->waitlistCount,                                                
                    ));    
                }
                
                $i++;

                // show date block
                if($objTpl->blockExists('calendarDateList')) {
                    
                    $showStartDateList  = $objEvent->useCustomDateDisplay ? $objEvent->showStartDateList : ($this->arrSettings['showStartDateList'] == 1);
                    $showEndDateList    = $objEvent->useCustomDateDisplay ? $objEvent->showEndDateList : ($this->arrSettings['showEndDateList'] == 1);
                    $showStartTimeList  = ($objEvent->all_day) ? false : ($objEvent->useCustomDateDisplay ? $objEvent->showStartTimeList : ($this->arrSettings['showStartTimeList'] == 1));
                    $showEndTimeList    = ($objEvent->all_day) ? false : ($objEvent->useCustomDateDisplay ? $objEvent->showEndTimeList : ($this->arrSettings['showEndTimeList'] == 1));
                    $showTimeTypeList   = $objEvent->useCustomDateDisplay ? $objEvent->showTimeTypeList : 1;
                    
                    // get date for several days format > show starttime with startdate and endtime with enddate > only if several days event and all values (dates/times) are displayed
                    if(date(parent::getDateFormat(), $objEvent->startDate) != date(parent::getDateFormat(), $objEvent->endDate) && ($showStartDateList && $showEndDateList && $showStartTimeList && $showEndTimeList)) {
                        
                        //part 1
                        $part = 1;
                        $this->getMultiDateBlock($objEvent, $this->arrSettings['separatorDateTimeList'], $this->arrSettings['separatorSeveralDaysList'], ($this->arrSettings['showClockList'] == 1), $part);

                        $objTpl->setVariable(array(
                            $this->moduleLangVar.'_DATE_LIST'                => $this->date,
                            $this->moduleLangVar.'_SEP_DATE_TIME_LIST'       => $this->sepDateTime,
                            $this->moduleLangVar.'_TIME_LIST'                => $this->time,
                            'TXT_'.$this->moduleLangVar.'_CLOCK_LIST'        => $this->clock,
                        ));
                        $objTpl->parse('calendarDateList');
                        //part 2
                        $part = 2;
                        $this->getMultiDateBlock($objEvent, $this->arrSettings['separatorDateTimeList'], $this->arrSettings['separatorSeveralDaysList'], ($this->arrSettings['showClockList'] == 1), $part);

                        $objTpl->setVariable(array(
                            $this->moduleLangVar.'_DATE_LIST'                => $this->date,
                            $this->moduleLangVar.'_SEP_DATE_TIME_LIST'       => $this->sepDateTime,
                            $this->moduleLangVar.'_TIME_LIST'                => $this->time,
                            'TXT_'.$this->moduleLangVar.'_CLOCK_LIST'        => $this->clock,
                        ));
                        $objTpl->parse('calendarDateList');
                    } else {          
                        // get date for single day format
                       $this->getSingleDateBlock($objEvent, $showStartDateList, $showEndDateList, $this->arrSettings['separatorDateList'], $showTimeTypeList, $showStartTimeList, $showEndTimeList, $this->arrSettings['separatorDateTimeList'], $this->arrSettings['separatorTimeList'], ($this->arrSettings['showClockList'] == 1));
                        
                        $objTpl->setVariable(array(
                            $this->moduleLangVar.'_DATE_LIST'                => $this->date,
                            $this->moduleLangVar.'_SEP_DATE_TIME_LIST'       => $this->sepDateTime,
                            $this->moduleLangVar.'_TIME_LIST'                => $this->time,
                            'TXT_'.$this->moduleLangVar.'_CLOCK_LIST'        => $this->clock,
                        ));
                        $objTpl->parse('calendarDateList');
                    }
                }

                if($type == 'confirm') {
                    if($objTpl->blockExists('eventConfirmList')) {
                        $objTpl->parse('eventConfirmList');
                    }
                } else {
                    if($objTpl->blockExists('eventList')) {
                        $objTpl->parse('eventList');
                    }
                    
                    if($objTpl->blockExists('calendar_headlines_row')) {
                        $objTpl->parse('calendar_headlines_row');
                    }   
                }
                
            }
            if(count($this->eventList) == 0 && $type != 'confirm') {
                $objTpl->hideBlock('eventList');
                
                $objTpl->setVariable(array(
                    'TXT_'.$this->moduleLangVar.'_NO_EVENTS'        => $_ARRAYLANG['TXT_CALENDAR_EVENTS_NO'],
                ));
                
                $objTpl->parse('emptyEventList');
            }
        //}
    }

    /**
     * Returns the events with date
     * 
     * @return array Events list
     */
    function getEventsWithDate() {
        $arrEvents = array();
        foreach ($this->eventList as $objEvent) {
            $eventDate = $objEvent->startDate;
            $eventDateYear = date('Y', $eventDate);
            $eventDateMonth = date('m', $eventDate);
            $eventDateDay = date('d', $eventDate);

            $arrEvents[] = array("year" => $eventDateYear, "month" => $eventDateMonth, "day" => $eventDateDay);
        }
        return $arrEvents;
    }
    
    /**
     * Returns the Event detail page link
     * 
     * @param object $objEvent Event object
     * 
     * @return string link for the detail page
     */
    function _getDetailLink($objEvent)
    {
        $url = \Cx\Core\Routing\Url::fromModuleAndCmd($this->moduleName, 'detail');
        $url->setParams(array(
            'id' => $objEvent->id,
            'date' => intval($objEvent->startDate)
        ));
        
        if($objEvent->external) {
            $url->setParam('external', 1);
        }
        return (string)$url;
    }
    
    /**
     * Find the url exists or not
     * 
     * @param string $url url
     * 
     * @return boolean true on url exists, false otherwise
     */
    function urlfind($url){
        if (!ini_get('allow_url_fopen')) {
            ini_set('allow_url_fopen', 'On');
        } 
        
        if (ini_get('allow_url_fopen')) {  
            if($url) {
                $file = @fopen ($url.'/modules/calendar/lib/webservice/soap.server.class.php', "r");
            }                                                    
            
            if($file){
                fclose($file);
                return true;  
            } else {
                return false;
            }
        } else {
            try {
                $request  = new HTTP_Request2($url.'modules/calendar/lib/webservice/soap.server.class.php');
                $response = $request->send();
                if (404 == $response->getStatus()) {
                    return false;
                } else {
                    return true;
                }
            } catch (Exception $e) {                
                DBG::msg($e->getMessage());
                return false;
            }
        }
    }

    /**
     * _setNextSeriesElement
     * 
     * @param object $objEvent Event object
     * 
     * @return null
     */
    function _setNextSeriesElement($objEvent) {  
        $objCloneEvent = clone $objEvent;
        
        parent::getSettings();
        
        switch ($objCloneEvent->seriesData['seriesType']){
            case 1:
                //daily
                if ($objCloneEvent->seriesData['seriesPatternType'] == 1) {
                    $hour       = date("H", $objEvent->startDate);
                    $minutes    = date("i", $objEvent->startDate);
                    $seconds    = date("s", $objEvent->startDate);
                    $day        = date("d", $objEvent->startDate)+$objEvent->seriesData['seriesPatternDay'];
                    $month      = date("m", $objEvent->startDate);
                    $year       = date("Y", $objEvent->startDate);

                    $objCloneEvent->startDate = mktime($hour, $minutes, $seconds, $month, $day, $year);
                    $compareDate = mktime(0, 0, 0, $month, $day, $year);

                    $hour       = date("H", $objEvent->endDate);
                    $minutes    = date("i", $objEvent->endDate);
                    $seconds    = date("s", $objEvent->endDate);
                    $day        = date("d", $objEvent->endDate)+$objEvent->seriesData['seriesPatternDay'];
                    $month      = date("m", $objEvent->endDate);
                    $year       = date("Y", $objEvent->endDate);

                    $objCloneEvent->endDate = mktime($hour, $minutes, $seconds, $month, $day, $year);
                } else {
                    $oldWeekday = date("w", $objEvent->startDate);

                    if ($oldWeekday == 5) {
                        $addDays = 3;
                    } else {
                        $addDays = 1;
                    }

                    $hour       = date("H", $objEvent->startDate);
                    $minutes    = date("i", $objEvent->startDate);
                    $seconds    = date("s", $objEvent->startDate);
                    $day        = date("d", $objEvent->startDate)+$addDays;
                    $month      = date("m", $objEvent->startDate);
                    $year       = date("Y", $objEvent->startDate);

                    $objCloneEvent->startDate = mktime($hour, $minutes, $seconds, $month, $day, $year);
                    $compareDate = mktime(0, 0, 0, $month, $day, $year);

                    $hour       = date("H", $objEvent->endDate);
                    $minutes    = date("i", $objEvent->endDate);
                    $seconds    = date("s", $objEvent->endDate);
                    $day        = date("d", $objEvent->endDate)+$addDays;
                    $month      = date("m", $objEvent->endDate);
                    $year       = date("Y", $objEvent->endDate);

                    $objCloneEvent->endDate = mktime($hour, $minutes, $seconds, $month, $day, $year);
                }
            break;
            case 2:
                //weekly
                $oldWeekday         = date("w", $objEvent->startDate);
                $weekdayPattern     = $objEvent->seriesData['seriesPatternWeekday'];
                $match              = false;
                $i                  = 0;
                $oldKW              = date("W", $objEvent->startDate);

                while(!$match){
                    $i++;

                    if(substr($weekdayPattern, $oldWeekday, 1) == 1) {
                        $addDays = $i;
                        $match = true;
                    } else {
                        $oldWeekday++;
                    }

                    if ($oldWeekday > 6) {
                        $oldWeekday = 0;
                    }

                    if ($i > 8){
                        break;
                    }

                }
                
                $hour       = date("H", $objEvent->startDate);
                $minutes    = date("i", $objEvent->startDate);
                $seconds    = date("s", $objEvent->startDate);
                $day        = date("d", $objEvent->startDate)+$addDays;
                $month      = date("m", $objEvent->startDate);
                $year       = date("Y", $objEvent->startDate);


                $newKW = date("W", mktime($hour, $minutes, $seconds, $month, $day, $year));

                if ($objEvent->seriesData['seriesPatternWeek'] > 1) {
                    if ($oldKW < $newKW) {
                        $addWeeks = ($objEvent->seriesData['seriesPatternWeek']-1)*7;
                    }
                }

                $objCloneEvent->startDate = mktime($hour, $minutes, $seconds, $month, $day+$addWeeks, $year);
                $compareDate = mktime(0, 0, 0, $month, $day+$addWeeks, $year);

                $hour       = date("H", $objEvent->endDate);
                $minutes    = date("i", $objEvent->endDate);
                $seconds    = date("s", $objEvent->endDate);
                $day        = date("d", $objEvent->endDate)+$addDays+$addWeeks;
                $month      = date("m", $objEvent->endDate);
                $year       = date("Y", $objEvent->endDate);

                $objCloneEvent->endDate = mktime($hour, $minutes, $seconds, $month, $day, $year);
            break;
            case 3:
                //monthly
                if ($objCloneEvent->seriesData['seriesPatternType'] == 1) {
                    $monthDays = 0;
                    
                    $hour       = date("H", $objEvent->startDate);
                    $minutes    = date("i", $objEvent->startDate);
                    $seconds    = date("s", $objEvent->startDate);
                    $day        = date("d", $objEvent->startDate);
                    $month      = date("m", $objEvent->startDate);
                    $year       = date("Y", $objEvent->startDate);

                    $monthDays  = date("t", $objEvent->startDate);

                    $addDays    = $monthDays-$day+$objEvent->seriesData['seriesPatternDay'];
                    $addMonths  = $objEvent->seriesData['seriesPatternMonth'];

                    if($addMonths > 1) {
                        for ($i = 1; $i < $addMonths; $i++) {
                           $nextMonthDays = date("t", mktime($hour, $minutes, $seconds, $month+$i, $day, $year));
                           $addDays = $addDays+$nextMonthDays;
                        }
                    }

                    $objCloneEvent->startDate = mktime($hour, $minutes, $seconds, $month, $day+$addDays, $year);
                    $compareDate = mktime(0, 0, 0, $month, $day+$addDays, $year);

                    $hour       = date("H", $objEvent->endDate);
                    $minutes    = date("i", $objEvent->endDate);
                    $seconds    = date("s", $objEvent->endDate);
                    $day        = date("d", $objEvent->endDate);
                    $month      = date("m", $objEvent->endDate);
                    $year       = date("Y", $objEvent->endDate);

                    $objCloneEvent->endDate = mktime($hour, $minutes, $seconds, $month, $day+$addDays, $year);
                } else {
                    $hour       = date("H", $objEvent->startDate);
                    $minutes    = date("i", $objEvent->startDate);
                    $seconds    = date("s", $objEvent->startDate);
                    $day        = date("d", $objEvent->startDate);
                    $month      = date("m", $objEvent->startDate);
                    $year       = date("Y", $objEvent->startDate);

                    $weekdayPattern = $objEvent->seriesData['seriesPatternWeekday'];
                    $countPattern   = $objEvent->seriesData['seriesPatternCount'];
                    $monthPattern   = $objEvent->seriesData['seriesPatternMonth'];
                    $nextMonth      = $month + $monthPattern;

                    $match  = false;
                    $i      = 0;
                    
                    while (!$match) {
                        if(substr($weekdayPattern, $i, 1) == 1) {
                            $weekday = $i+1;
                            $match = true;
                        } else {
                            $i++;
                        }
                    }

                    if ($weekday > 6) {
                        $weekday = 0;
                    }

                    if($countPattern < 5) {
                        $match  = false;
                        $d      = 1;

                        while (!$match) {
                            $checkDate  = mktime($hour, $minutes, $seconds, $nextMonth, $d, $year);
                            $checkDay  = date("w", $checkDate);
                            
                            if ($checkDay == $weekday) {
                                $match = true;
                            } else {
                                $d++;
                            }
                        }

                        if($countPattern > 1) {
                           $countPattern = 7*($countPattern-1);
                        } else {
                           $countPattern = 0;
                        }
                    } else {
                        $match          = false;
                        $d              = date("t", mktime($hour, $minutes, $seconds, $nextMonth, $day, $year));
                        $countPattern   = 0;

                        while (!$match) {
                            $checkDate  = mktime($hour, $minutes, $seconds, $nextMonth, $d, $year);
                            $checkDay  = date("w", $checkDate);

                            if ($checkDay == $weekday) {
                                $match = true;
                            } else {
                                $d--;
                            }
                        }
                    }

                    $addMonth   = $nextMonth-$month;
                    $newDay     = $d+$countPattern;
                    
                    $objCloneEvent->startDate = mktime($hour, $minutes, $seconds, $month+$addMonth, $newDay, $year);
                    $compareDate = mktime(0, 0, 0, $month+$addMonth, $newDay, $year);
                    
                    $hour       = date("H", $objEvent->endDate);
                    $minutes    = date("i", $objEvent->endDate);
                    $seconds    = date("s", $objEvent->endDate);
                    $dayStart   = $objEvent->startDate;
                    $dayEnd     = $objEvent->endDate;
                    $dayDiff    = date("d",$dayEnd-$dayStart)-1;
                    $month      = date("m", $objEvent->endDate);
                    $year       = date("Y", $objEvent->endDate);

                    $objCloneEvent->endDate = mktime($hour, $minutes, $seconds, $month+$addMonth, $newDay+$dayDiff, $year);
                }
            break;
        }
        
        $isAllowedEvent = true;
        switch($objCloneEvent->seriesData['seriesPatternDouranceType']) {
            case 1:                                
                $getNextEvent = false;
                
                if ($this->startDate != null) {                    
                    $lastDate = mktime(date("H", $this->startDate), date("i", $this->startDate), date("s", $this->startDate), date("m", $this->startDate), date("d", $this->startDate), date("Y", $this->startDate)+intval($this->arrSettings['maxSeriesEndsYear'])+1); 
                    if ($objCloneEvent->startDate <= $lastDate) {
                        $getNextEvent = true;
                    } else {
                        $getNextEvent = false;
                    }
                } elseif($this->endDate != null) { // start date will be null only on archive                    
                    
                    if ($objCloneEvent->endDate <= $this->endDate) {
                        $getNextEvent = true;
                    } else {
                        $getNextEvent = false;
                    }
                }
                break;
            case 2:
                $objCloneEvent->seriesData['seriesPatternEnd'] = $objCloneEvent->seriesData['seriesPatternEnd']-1;
                
                if ($objCloneEvent->seriesData['seriesPatternEnd'] > 1) {
                    $getNextEvent = true;
                } else {
                    $getNextEvent = false;
                }
                // If pattern end count is true, then a event will be allowed to add in event list
                $isAllowedEvent = (boolean) $objCloneEvent->seriesData['seriesPatternEnd']; 
                break;
            case 3:
                if($objCloneEvent->startDate <= $objCloneEvent->seriesData['seriesPatternEnd']) {
                    $getNextEvent = true;
                } else {
                    $getNextEvent = false;
                }
                break;
        }
        
        if (   $isAllowedEvent
            && !in_array($compareDate, $objCloneEvent->seriesData['seriesPatternExceptions'])
            && self::_addToEventList($objCloneEvent)
        ) {
            array_push($this->eventList, $objCloneEvent);              
            if ($this->listType == 'upcoming') {
                // if list type is set to upcoming the the will be shown only once
                $getNextEvent = false;
            }
        }
        
        if ($getNextEvent) {
            self::_setNextSeriesElement($objCloneEvent);    
        }
    }
    
    /**
     * Return Coorinates
     *      
     * @param string $street  Street addres
     * @param string $zipcode postal code
     * @param string $city    Name of the city
     * 
     * @return boolean true or false
     */
    function _getCoorinates($street,$zipcode,$city) {
        global $_CONFIG;
        
        if (!ini_get('allow_url_fopen')) {     
            ini_set('allow_url_fopen', 'On');
        } 
        
        if(ini_get('allow_url_fopen')) { 
            $address = '';
            $address .= $street;
            $address .= ', ';
            $address .= $city;
            $address .= ', ';
            $address .= $zipcode;             
                                                    
            $key = $_CONFIG['googleMapsAPIKey'];
                                  
            $url='http://maps.google.com/maps/geo?output=xml&q=';    
            $urlcontent = file_get_contents($url . urlencode($address));  
            $urlcontent = utf8_encode($urlcontent);     
            $xml = new SimpleXMLElement($urlcontent);
            
            $arrCoordinates = explode (",",$xml->Response->Placemark->Point->coordinates);       
        } else {
            //echo "please check your Google Maps API Key or activate 'allow_url_fopen' or deactivate Goope Maps in this Event.";
            $arrCoordinates   = false;
        }   
        
        return $arrCoordinates;
    }

    /**
     * show date and time by user settings > single day view > start-/endtime separated by start-/enddate
     *      
     * @param object  $objEvent          Event object
     * @param boolean $showStartDate     true to show start date, false to hide
     * @param boolean $showEndDate       true to show clock, false to hide
     * @param string  $separatorDate     Date separator
     * @param integer $showTimeType      Event time type
     * @param boolean $showStartTime     true to show start time, false to hide
     * @param boolean $showEndTime       true to show end time, false to hide
     * @param string  $separatorDateTime Date time separator
     * @param string  $separatorTime     Time separator
     * @param boolean $showClock         true to show clock, false to hide
     * 
     * @return null
     */
    function getSingleDateBlock($objEvent, $showStartDate, $showEndDate, $separatorDate, $showTimeType, $showStartTime, $showEndTime, $separatorDateTime, $separatorTime, $showClock) {
        global $_ARRAYLANG;
        
        //date
        if($showStartDate && $showEndDate) {
            $this->date = date(parent::getDateFormat(), $objEvent->startDate).$separatorDate.date(parent::getDateFormat(), $objEvent->endDate);
        } else if($showStartDate) {
            $this->date = date(parent::getDateFormat(), $objEvent->startDate);
        } else if($showEndDate) {
            $this->date = date(parent::getDateFormat(), $objEvent->endDate);
        } else {
            $this->date = '';
        }

        //time
        if($showTimeType == 1) {
            //start and/or end time
            if($showStartTime && $showEndTime) {
                $this->sepDateTime = html_entity_decode($separatorDateTime);
                $this->time = date('H:i', $objEvent->startDate).$separatorTime.date('H:i', $objEvent->endDate);
            } else if($showStartTime) {
                $this->sepDateTime = html_entity_decode($separatorDateTime);
                $this->time = date('H:i', $objEvent->startDate);
            } else if($showEndTime) {
                $this->sepDateTime = html_entity_decode($separatorDateTime);
                $this->time = date('H:i', $objEvent->endDate);
            } else {
                $this->time = '';
            }
            //show / hide clock
            ($showClock && $this->time != '') ? $this->clock = '&nbsp;'.$_ARRAYLANG['TXT_CALENDAR_OCLOCK'] : $this->clock = '';
        } else if($showTimeType == 2) {
            //fulltime
            $this->clock = '';
            $this->sepDateTime = html_entity_decode($separatorDateTime);
            $this->time = $_ARRAYLANG['TXT_CALENDAR_TIME_TYPE_FULLTIME'];
        } else {
            //no time
            $this->clock = '';
            $this->time = '';
        }
    }

    /**
     * show date and time by user settings > several day view
     *      
     * @param object  $objEvent             Event object
     * @param string  $separatorDateTime    Date time separator
     * @param string  $separatorSeveralDays SeveralDays separator
     * @param boolean $showClock            true to show clock, false to hide
     * @param integer $part                 Part of the multi date event
     * 
     * @return null
     */
    function getMultiDateBlock($objEvent, $separatorDateTime, $separatorSeveralDays, $showClock, $part) {
        global $_ARRAYLANG;

        $this->sepDateTime = html_entity_decode($separatorDateTime);

        if($part == 1) {
            // parse part 1 (start)
            //date
            $this->date = date(parent::getDateFormat(), $objEvent->startDate);
            //time
            $this->time = date('H:i', $objEvent->startDate);
            //show / hide clock
            ($showClock && $this->time != '') ? $this->clock = '&nbsp;'.$_ARRAYLANG['TXT_CALENDAR_OCLOCK'] : $this->clock = '';
            //add separator for several days
            if($this->clock != '') {
                $this->clock .= html_entity_decode($separatorSeveralDays);
            } else {
                $this->time .= html_entity_decode($separatorSeveralDays);
            }
        } else {
            // parse part 2 (end)
            //date
            $this->date = date(parent::getDateFormat(), $objEvent->endDate);
            //time
            $this->time = date('H:i', $objEvent->endDate);
            //show / hide clock
            ($showClock && $this->time != '') ? $this->clock = '&nbsp;'.$_ARRAYLANG['TXT_CALENDAR_OCLOCK'] : $this->clock = '';
        }
    }

    /**
     * Returns the calendar boxes
     *      
     * @param  integer $boxes  Number of boxes
     * @param  year    $year   Year
     * @param  integer $month  month
     * @param  integer $day    day
     * @param  integer $catid  category id
     * 
     * @return string  calendar boxes
     */
    function getBoxes($boxes, $year, $month=0, $day=0, $catid=0)
    {
        global $_ARRAYLANG, $objInit;

        if ($catid != 0 && !empty($catid)) {
            $url_cat = "&amp;catid=$catid";
        } else {
            $url_cat = "";
        }

        $url = htmlentities($this->calendarBoxUrl, ENT_QUOTES, CONTREXX_CHARSET).$url_cat;

        $firstblock = true;
        $month      = intval($month);
        $year       = intval($year);
        $day        = intval($day);
        $monthnames = explode(",", $_ARRAYLANG['TXT_CALENDAR_MONTH_ARRAY']);
        $daynames   = explode(',', $_ARRAYLANG['TXT_CALENDAR_DAY_ARRAY']);
        $calenderBoxes = '';
        for ($i=0; $i<$boxes; $i++) {
            $cal = new activeCalendar($year, $month, $day);
            $cal->setMonthNames($monthnames);
            $cal->setDayNames($daynames);

            if ($firstblock) {
                $cal->enableMonthNav($url);
            } else {
                // This is necessary for the modification of the linkname
                // The modification makes a link on the monthname
                $cal->urlNav=$url;
            }

            // for seperate variable for the month links
            if (!empty($this->calendarBoxMonthNavUrl)) {
                $cal->urlMonthNav = htmlentities($this->calendarBoxMonthNavUrl, ENT_QUOTES, CONTREXX_CHARSET);
            }

            //load events
            foreach ($this->eventList as $objEvent) {
                
                if ($objEvent->access && $objInit->mode == 'frontend' && !Permission::checkAccess(116, 'static', true)) {
                    continue;
                }
                $startdate     = $objEvent->startDate;
                $enddate       = $objEvent->endDate;
                $eventYear     = date("Y", $startdate);
                $eventMonth    = date("m", $startdate);
                $eventDay      = date("d", $startdate);
                $eventEndDay   = date("d", $enddate);
                $eventEndMonth = date("m", $enddate);

                // do only something when the event is in the current month
                if ($eventMonth <= $month && $eventEndMonth >= $month) {
                    // if the event is longer than one day but every day is in the same month
                    if ($eventEndDay > $eventDay && $eventMonth == $eventEndMonth) {
                        $curday = $eventDay;
                        while ($curday <= $eventEndDay) {
                            $eventurl = $url."&amp;yearID=$eventYear&amp;monthID=$month&amp;dayID=$curday".$url_cat;
                            $cal->setEvent("$eventYear", "$eventMonth", "$curday", false, $eventurl);
                            $curday++;
                        }
                    } elseif ($eventEndMonth > $eventMonth) {
                        if ($eventMonth == $month) {
                            // Show the part of the event in the starting month
                            $curday = $eventDay;
                            while ($curday <= 31) {
                                $eventurl = $url."&amp;yearID=$eventYear&amp;monthID=$month&amp;dayID=$curday".$url_cat;
                                $cal->setEvent("$eventYear", "$eventMonth", "$curday", false, $eventurl);
                                $curday++;
                            }
                        } elseif ($eventEndMonth == $month) {
                            // show the part of the event in the ending month
                            $curday = $eventEndDay;
                            while ($curday > 0) {
                                $eventurl = $url."&amp;yearID=$eventYear&amp;monthID=$month&amp;dayID=$curday".$url_cat;
                                $cal->setEvent("$eventYear", "$eventEndMonth", "$curday", false, $eventurl);
                                $curday--;
                            }
                        } elseif ($eventMonth < $month && $eventEndMonth > $month) {
                            foreach (range(0,31,1) as $curday) {
                                $eventurl = $url."&amp;yearID=$eventYear&amp;monthID=$month&amp;dayID=$curday".$url_cat;
                                $cal->setEvent("$eventYear", "$month", "$curday", false, $eventurl);
                            }
                        }
                    } else {
                        $eventurl = $url."&amp;yearID=$eventYear&amp;monthID=$month&amp;dayID=$eventDay".$url_cat;
                        $cal->setEvent("$eventYear", "$eventMonth", "$eventDay", false, $eventurl);
                    }
                }
            }

            $calenderBoxes .= $cal->showMonth(false, true);
            if ($month == 12) {
                $year++;
                $month = 1;
            } else {
                $month++;
            }
            $day = 0;
            $firstblock = false;
        }
        
        return $calenderBoxes;
    }
    
    /**
     * Returns the javascript used for the calendar boxes
     * 
     * @return string javascript
     */
    function getCalendarBoxJS()
    {
            return 	'<script type="text/javascript">
                            /* <![CDATA[ */
                            function changecat()
                            {
                                    var href = window.location.href;
                                    var catid = $J("#selectcat").val();
                                    href = href.replace(/&catid=[0-9]+/g, \'\');
                                    href = href.replace(/&act=search/g, \'\');
                                    href += "&catid=" + catid;                                    
                                    window.location.href = href;
                            }
                            /* ]]> */
                            </script>';
    }    
    
    function getPriorityImage($objEvent)
    {
        global $_ARRAYLANG;

        $priority    = '';
        $priorityImg = '';
        switch ($objEvent->priority) {
            case 1:
                $priority    = $_ARRAYLANG['TXT_CALENDAR_PRIORITY_VERY_HEIGHT'];
                $priorityImg = "<img src='images/modules/calendar/very_height.gif' border='0' title='".$_ARRAYLANG['TXT_CALENDAR_PRIORITY_VERY_HEIGHT']."' alt='".$_ARRAYLANG['TXT_CALENDAR_PRIORITY_VERY_HEIGHT']."' />";
                break;
            case 2:
                $priority    = $_ARRAYLANG['TXT_CALENDAR_PRIORITY_HEIGHT'];
                $priorityImg = "<img src='images/modules/calendar/height.gif' border='0' title='".$_ARRAYLANG['TXT_CALENDAR_PRIORITY_HEIGHT']."' alt='".$_ARRAYLANG['TXT_CALENDAR_PRIORITY_HEIGHT']."' />";
                break;
            case 3:
                $priority    = $_ARRAYLANG['TXT_CALENDAR_PRIORITY_NORMAL'];
                $priorityImg = "&nbsp;";
                break;
            case 4:
                $priority    = $_ARRAYLANG['TXT_CALENDAR_PRIORITY_LOW'];
                $priorityImg = "<img src='images/modules/calendar/low.gif' border='0' title='".$_ARRAYLANG['TXT_CALENDAR_PRIORITY_LOW']."' alt='".$_ARRAYLANG['TXT_CALENDAR_PRIORITY_LOW']."' />";
                break;
            case 5:
                $priority    = $_ARRAYLANG['TXT_CALENDAR_PRIORITY_VERY_LOW'];
                $priorityImg = "<img src='images/modules/calendar/very_low.gif' border='0' title='".$_ARRAYLANG['TXT_CALENDAR_PRIORITY_VERY_LOW']."' alt='".$_ARRAYLANG['TXT_CALENDAR_PRIORITY_VERY_LOW']."' />";
                break;
        }
        
        return array($priority, $priorityImg);
    }
}
