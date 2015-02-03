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
 * Calendar Class Event
 * 
 * @package    contrexx
 * @subpackage module_calendar
 * @author     Comvation <info@comvation.com>
 * @copyright  CONTREXX CMS - COMVATION AG
 * @version    1.00
 */


/**
 * Calendar Class Event
 * 
 * @package    contrexx
 * @subpackage module_calendar
 * @author     Comvation <info@comvation.com>
 * @copyright  CONTREXX CMS - COMVATION AG
 * @version    1.00
 */    
class CalendarEvent extends CalendarLibrary
{
    /**
     * Event id
     * 
     * @access public
     * @var integer 
     */
    public $id;
    
    /**
     * Event Type
     * 
     * @access public
     * @var integer 
     */
    public $type;
    
    /**
     * Event title
     *
     * @var string 
     * @access public
     */
    public $title;
    
    /**
     * Event Picture
     * 
     * @access public
     * @var string 
     */
    public $pic;
    
    /**
     * Event attachment file name
     *  
     * @access public
     * @var string 
     */
    public $attach;
    
    /** 
     * Event Start date timestamp
     * 
     * @access public
     * @var integer
     */
    public $startDate;
    
    /**
     * Event enddate timestamp 
     * 
     * @access public
     * @var integer
     */
    public $endDate;
    
    /**
     * Event show start date on list view
     * 
     * @access public
     * @var boolean
     */
    public $showStartDateList;
    
    /**
     * Event show End date on list view
     * 
     * @access public
     * @var boolean
     */
    public $showEndDateList;
    
    /**
     * Event show start time on list view
     * 
     * @access public
     * @var boolean
     */
    public $showStartTimeList;
    
    /**
     * Event show End time on list view
     * 
     * @access public
     * @var boolean
     */
    public $showEndTimeList;
    
    /**
     * Event time type on list view
     * 
     * @access public
     * @var integer
     */
    public $showTimeTypeList;
    
    /**
     * Event show start date on detail view
     * 
     * @access public
     * @var boolean
     */
    public $showStartDateDetail;
    
    /**
     * Event show end date on detail view
     * 
     * @access public
     * @var boolean
     */
    public $showEndDateDetail;
    
    /**
     * Event show start time on detail view
     * 
     * @access public
     * @var boolean
     */
    public $showStartTimeDetail;
    
    /**
     * Event show end time on detail view
     * 
     * @access public
     * @var boolean
     */
    public $showEndTimeDetail;
    
    /**
     * Event time type on detail view
     * 
     * @access public
     * @var integer
     */
    public $showTimeTypeDetail;
    
    /**
     * Event price
     * 
     * @access public
     * @var integer
     */
    public $price;
    
    /**
     * Event link
     * 
     * @access public
     * @var string
     */
    public $link;
    
    /**
     * Event priority
     * 
     * @access public
     * @var integer
     */
    public $priority;
    
    /**
     * Event show end date on detail view
     * 
     * @access public
     * @var boolean
     */
    public $access;
    
    /**
     * Event description
     * 
     * @access public
     * @var string
     */
    public $description;
    
    /**
     * Event location type 
     * 1 => Manual Entry
     * 2 => Refer to mediadir module
     * 
     * @access public
     * @var integer
     */
    public $locationType;
    
    /**
     * Event Host type 
     * 1 => Manual Entry
     * 2 => Refer to mediadir module
     * 
     * @access public
     * @var integer
     */
    public $hostType;
    
    /**
     * Event place
     * 
     * @access public
     * @var string
     */
    public $place;
    
    /**
     * Event status
     * 
     * @access public
     * @var integer
     */
    public $status;
    
    /**
     * Event confirmed
     * 
     * @access public
     * @var boolean
     */
    public $confirmed;
    
    /**
     * Event author
     * 
     * @access public
     * @var string
     */
    public $author;
    
    /**
     * Event category id
     *
     * @access public
     * @var integer 
     */
    public $catId;
    
    /**
     * Event series status
     *
     * @access public
     * @var integer 
     */
    public $seriesStatus;
    
    /**
     * Event series data
     *
     * @access public
     * @var array
     */
    public $seriesData = array();
    
    /**
     * Event languages to show
     *
     * @access public
     * @var array 
     */
    public $showIn;
    
    /**
     * Avaliable languages
     *
     * @access public
     * @var array
     */
    public $availableLang;
    
    /**
     * Event map status
     *
     * @access public
     * @var integer 
     */
    public $map;
    
    /**
     * Event invited group
     *
     * @access public
     * @var array
     */
    public $invitedGroups = array();
    
    /**
     * Event invited mail
     *
     * @access public
     * @var array
     */
    public $invitedMails = array();
    
    /**
     * is Event invitation sent
     *
     * @access public
     * @var boolean
     */
    public $invitationSent;
    
    /**
     * Template Id of the invitation mail
     * 
     * @var integer
     */
    public $invitationTemplate;

    /**
     * Event status of registration
     *
     * @access public
     * @var boolean
     */
    public $registration;
    
    /**
     * Event registration form
     *
     * @access public
     * @var integer
     */
    public $registrationForm;
    
    /**
     * Event number of subscriber
     *
     * @access public
     * @var integer
     */
    public $numSubscriber;
    
    /**
     * Event notification the event
     *
     * @access public
     * @var string
     */
    public $notificationTo;
    
    /**
     * Event E-mail template
     *
     * @access public
     * @var integer
     */
    public $emailTemplate;
    
    /**
     * Event ticket sales
     *
     * @access public
     * @var integer
     */
    public $ticketSales;
    
    /**
     * Event available seating
     *
     * @access public
     * @var integer
     */
    public $numSeating;
    
    /**
     * Event free palces
     *
     * @access public
     * @var integer
     */
    public $freePlaces;
    
    /**
     * Event related websites
     *
     * @access public
     * @var array
     */
    public $relatedHosts = array();
    
    /**
     * Event data
     *
     * @access public
     * @var array
     */
    public $arrData = array();
    
    /**
     * External
     *
     * @access public
     * @var boolean
     */
    public $external = false;
    
    /**
     * Event host id
     *
     * @access public
     * @var string
     */
    public $hostId = "local";
    
    /**
     * module image upload physical path
     *
     * @access public
     * @var string 
     */
    public $uploadImgPath = '';
    
    /**
     * module uploaded image web path
     *
     * @access public
     * @var string 
     */
    public $uploadImgWebPath = '';
    
    /**
     * Registered members count for the event
     * 
     * @var integer
     */
    public $registrationCount = 0;
    
    /**
     * Waitlist members count for the event
     * 
     * @var integer
     */
    public $waitlistCount = 0;
    
    /**
     * Cancellation members count for the event
     * 
     * @var integer
     */
    public $cancellationCount = 0;
    
    /**
     * Constructor
     * 
     * Loads the event object of given id
     * Call the parent constructor to initialize the settings values
     * 
     * @param integer $id Event id     
     */
    function __construct($id=null){
        if($id != null) {
            self::get($id);
        }
        
        $this->uploadImgPath    = ASCMS_PATH.ASCMS_IMAGE_PATH.'/'.$this->moduleName.'/';
        $this->uploadImgWebPath = ASCMS_IMAGE_PATH.'/'.$this->moduleName.'/';
        
        parent::getSettings();
    }
        
    /**
     * Load the requested event by id
     * 
     * @param integer $eventId        Event Id
     * @param integer $eventStartDate Event start date
     * @param integer $langId         Language id
     * 
     * @return null 
     */
    function get($eventId, $eventStartDate=null, $langId=null) {
        global $objDatabase, $_ARRAYLANG, $_LANGID, $objInit;
        
        parent::getSettings();
        
        if($objInit->mode == 'backend' || $langId == null) {
            $lang_where = "AND field.lang_id = '".intval($_LANGID)."' ";
        } else {
            $lang_where = "AND field.lang_id = '".intval($langId)."' ";                             
        }

        $query = "SELECT event.id AS id,
                         event.type AS type,
                         event.startdate AS startdate,
                         event.enddate AS enddate,
                         event.use_custom_date_display AS useCustomDateDisplay,
                         event.showStartDateList AS showStartDateList,
                         event.showEndDateList AS showEndDateList,
                         event.showStartTimeList AS showStartTimeList,
                         event.showEndTimeList AS showEndTimeList,
                         event.showTimeTypeList AS showTimeTypeList,
                         event.showStartDateDetail AS showStartDateDetail,
                         event.showEndDateDetail AS showEndDateDetail,
                         event.showStartTimeDetail AS showStartTimeDetail,
                         event.showEndTimeDetail AS showEndTimeDetail,
                         event.showTimeTypeDetail AS showTimeTypeDetail,
                         event.access AS access,
                         event.price AS price,
                         event.link AS link,
                         event.pic AS pic,
                         event.attach AS attach,
                         event.place_mediadir_id AS place_mediadir_id,
                         event.host_mediadir_id AS host_mediadir_id,
                         event.priority AS priority,
                         event.catid AS catid,
                         event.status AS status,
                         event.author AS author,
                         event.confirmed AS confirmed,
                         event.show_in AS show_in,
                         event.google AS google,
                         event.invited_groups AS invited_groups,
                         event.invited_mails AS invited_mails,
                         event.invitation_sent AS invitation_sent,
                         event.invitation_email_template AS invitation_email_template,
                         event.registration AS registration,
                         event.registration_form AS registration_form,
                         event.registration_num AS registration_num,
                         event.registration_notification AS registration_notification,
                         event.email_template AS email_template,
                         event.ticket_sales AS ticket_sales,
                         event.num_seating AS num_seating,
                         event.series_status AS series_status,
                         event.series_type AS series_type,
                         event.series_pattern_count AS series_pattern_count,
                         event.series_pattern_weekday AS series_pattern_weekday,
                         event.series_pattern_day AS series_pattern_day,
                         event.series_pattern_week AS series_pattern_week,
                         event.series_pattern_month AS series_pattern_month,
                         event.series_pattern_type AS series_pattern_type,
                         event.series_pattern_dourance_type AS series_pattern_dourance_type,
                         event.series_pattern_end AS series_pattern_end,
                         event.series_pattern_end_date AS series_pattern_end_date,
                         event.series_pattern_begin AS series_pattern_begin,
                         event.series_pattern_exceptions AS series_pattern_exceptions,
                         event.all_day,
                         event.location_type AS location_type,
                         event.place AS place, 
                         event.place_street AS place_street, 
                         event.place_zip AS place_zip, 
                         event.place_city AS place_city, 
                         event.place_country AS place_country, 
                         event.place_link AS place_link, 
                         event.place_map AS place_map, 
                         event.host_type AS host_type,
                         event.org_name AS org_name, 
                         event.org_street AS org_street, 
                         event.org_zip AS org_zip, 
                         event.org_city AS org_city, 
                         event.org_country AS org_country, 
                         event.org_link AS org_link, 
                         event.org_email AS org_email, 
                         field.title AS title,
                         field.description AS description,
                         event.place AS place
                    FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_event AS event,
                         ".DBPREFIX."module_".$this->moduleTablePrefix."_event_field AS field
                   WHERE event.id = '".intval($eventId)."'  
                     AND (event.id = field.event_id ".$lang_where.")                                          
                   LIMIT 1";

        
        $objResult = $objDatabase->Execute($query);  

        if($this->arrSettings['showEventsOnlyInActiveLanguage'] == 2) {
            if($objResult->RecordCount() == 0) {
                
                if($langId == null) {
                    $langId = 1;   
                } else {
                    $langId++;
                }
                
                if($langId <= 99) {
                    self::get($eventId,$eventStartDate,$langId); 
                }
            } else {
                if($langId == null) {
                    $langId = $_LANGID;   
                }
            }
        } else {
           $langId = $_LANGID;
        }
        
        if ($objResult !== false) {
            if(!empty($objResult->fields['title'])) {
                $this->id = intval($eventId);   
                $this->type = intval($objResult->fields['type']); 
                $this->title = htmlentities(stripslashes($objResult->fields['title']), ENT_QUOTES, CONTREXX_CHARSET);            
                $this->pic = htmlentities($objResult->fields['pic'], ENT_QUOTES, CONTREXX_CHARSET);
                $this->attach = htmlentities($objResult->fields['attach'], ENT_QUOTES, CONTREXX_CHARSET);
                $this->author = htmlentities($objResult->fields['author'], ENT_QUOTES, CONTREXX_CHARSET);
                $this->startDate = strtotime($objResult->fields['startdate']);
                $this->endDate = strtotime($objResult->fields['enddate']);
                $this->useCustomDateDisplay = intval($objResult->fields['useCustomDateDisplay']);
                $this->showStartDateList = intval($objResult->fields['showStartDateList']);
                $this->showEndDateList = intval($objResult->fields['showEndDateList']);
                $this->showStartTimeList = intval($objResult->fields['showStartTimeList']);
                $this->showEndTimeList = intval($objResult->fields['showEndTimeList']);
                $this->showTimeTypeList = intval($objResult->fields['showTimeTypeList']);
                $this->showStartDateDetail = intval($objResult->fields['showStartDateDetail']);
                $this->showEndDateDetail = intval($objResult->fields['showEndDateDetail']);
                $this->showStartTimeDetail = intval($objResult->fields['showStartTimeDetail']);
                $this->showEndTimeDetail = intval($objResult->fields['showEndTimeDetail']);
                $this->showTimeTypeDetail = intval($objResult->fields['showTimeTypeDetail']);
                $this->all_day  = intval($objResult->fields['all_day']);
                $this->confirmed = intval($objResult->fields['confirmed']);
                $this->invitationSent = intval($objResult->fields['invitation_sent']);
                $this->invitationTemplate = json_decode($objResult->fields['invitation_email_template'], true);
                $this->access = intval($objResult->fields['access']);
                $this->price = intval($objResult->fields['price']);
                $this->link = htmlentities(stripslashes($objResult->fields['link']), ENT_QUOTES, CONTREXX_CHARSET);
                $this->priority = intval($objResult->fields['priority']);
                $this->description = $objResult->fields['description'];
                
                $this->locationType = (int) $objResult->fields['location_type'];                
                $this->place_mediadir_id = (int) $objResult->fields['place_mediadir_id'];                
                $this->place        = htmlentities(stripslashes($objResult->fields['place']), ENT_QUOTES, CONTREXX_CHARSET);
                $this->place_street = htmlentities(stripslashes($objResult->fields['place_street']), ENT_QUOTES, CONTREXX_CHARSET);
                $this->place_zip    = htmlentities(stripslashes($objResult->fields['place_zip']), ENT_QUOTES, CONTREXX_CHARSET);
                $this->place_city   = htmlentities(stripslashes($objResult->fields['place_city']), ENT_QUOTES, CONTREXX_CHARSET);
                $this->place_country = htmlentities(stripslashes($objResult->fields['place_country']), ENT_QUOTES, CONTREXX_CHARSET);
                $this->place_link   = contrexx_raw2xhtml($objResult->fields['place_link']);
                $this->place_map    = contrexx_raw2xhtml($objResult->fields['place_map']);
                $this->hostType = (int) $objResult->fields['host_type'];
                $this->host_mediadir_id = (int) $objResult->fields['host_mediadir_id'];
                $this->org_name     = contrexx_raw2xhtml($objResult->fields['org_name']);
                $this->org_street   = contrexx_raw2xhtml($objResult->fields['org_street']);
                $this->org_zip      = contrexx_raw2xhtml($objResult->fields['org_zip']);
                $this->org_city     = contrexx_raw2xhtml($objResult->fields['org_city']);
                $this->org_country  = contrexx_raw2xhtml($objResult->fields['org_country']);
                $this->org_link     = contrexx_raw2xhtml($objResult->fields['org_link']);
                $this->org_email    = contrexx_raw2xhtml($objResult->fields['org_email']);
                                
                $this->showIn = htmlentities($objResult->fields['show_in'], ENT_QUOTES, CONTREXX_CHARSET);
                $this->availableLang = intval($langId);
                $this->status = intval($objResult->fields['status']);
                $this->catId = intval($objResult->fields['catid']);
                $this->map = intval($objResult->fields['google']);
                $this->seriesStatus = intval($objResult->fields['series_status']);   
                     
                if($this->seriesStatus == 1) {
                    $this->seriesData['seriesPatternCount'] = intval($objResult->fields['series_pattern_count']); 
                    $this->seriesData['seriesType'] = intval($objResult->fields['series_type']); 
                    $this->seriesData['seriesPatternCount'] = intval($objResult->fields['series_pattern_count']); 
                    $this->seriesData['seriesPatternWeekday'] = htmlentities($objResult->fields['series_pattern_weekday'], ENT_QUOTES, CONTREXX_CHARSET);     
                    $this->seriesData['seriesPatternDay'] = intval($objResult->fields['series_pattern_day']); 
                    $this->seriesData['seriesPatternWeek'] = intval($objResult->fields['series_pattern_week']); 
                    $this->seriesData['seriesPatternMonth'] = intval($objResult->fields['series_pattern_month']); 
                    $this->seriesData['seriesPatternType'] = intval($objResult->fields['series_pattern_type']); 
                    $this->seriesData['seriesPatternDouranceType'] = intval($objResult->fields['series_pattern_dourance_type']); 
                    $this->seriesData['seriesPatternEnd'] = intval($objResult->fields['series_pattern_end']); 
                    $this->seriesData['seriesPatternEndDate'] = strtotime($objResult->fields['series_pattern_end_date']); 
                    $this->seriesData['seriesPatternBegin'] = intval($objResult->fields['series_pattern_begin']); 
                    $this->seriesData['seriesPatternExceptions'] = array_map('strtotime', (array) explode(",", $objResult->fields['series_pattern_exceptions']));
                }    
                  
                $this->invitedGroups = explode(',', $objResult->fields['invited_groups']);     
                $this->invitedMails =  htmlentities($objResult->fields['invited_mails'], ENT_QUOTES, CONTREXX_CHARSET);  
                $this->registration = intval($objResult->fields['registration']);  
                $this->registrationForm = intval($objResult->fields['registration_form']);  
                $this->numSubscriber = intval($objResult->fields['registration_num']); 
                $this->notificationTo = htmlentities($objResult->fields['registration_notification'], ENT_QUOTES, CONTREXX_CHARSET);
                $this->emailTemplate = json_decode($objResult->fields['email_template'], true);
                $this->ticketSales = intval($objResult->fields['ticket_sales']);
                $this->arrNumSeating = json_decode($objResult->fields['num_seating']);
                $this->numSeating = implode(',', $this->arrNumSeating);
                
                $queryCountRegistration = "SELECT 
                                                COUNT(1) AS numSubscriber, 
                                                `type` 
                                            FROM 
                                                `".DBPREFIX."module_".$this->moduleTablePrefix."_registration`
                                            WHERE  
                                                `event_id` = ". (int) $eventId ." 
                                            GROUP BY 
                                                `type`";
                $objCountRegistration = $objDatabase->Execute($queryCountRegistration);
                
                if ($objCountRegistration) {
                    while (!$objCountRegistration->EOF) {
                        switch ($objCountRegistration->fields['type']) {
                            case 1:
                                $this->registrationCount = (int) $objCountRegistration->fields['numSubscriber'];
                                break;
                            case 2:
                                $this->waitlistCount = (int) $objCountRegistration->fields['numSubscriber'];
                                break;
                            case 0:
                                $this->cancellationCount = (int) $objCountRegistration->fields['numSubscriber'];
                                break;
                        }
                        $objCountRegistration->MoveNext();
                    }
                }
                                
                $queryRegistrations = '
                    SELECT `v`.`value` AS `reserved_seating`
                    FROM `'.DBPREFIX.'module_'.$this->moduleTablePrefix.'_registration_form_field_value` AS `v`
                    INNER JOIN `'.DBPREFIX.'module_'.$this->moduleTablePrefix.'_registration` AS `r`
                    ON `v`.`reg_id` = `r`.`id`
                    INNER JOIN `'.DBPREFIX.'module_'.$this->moduleTablePrefix.'_registration_form_field` AS `f`
                    ON `v`.`field_id` = `f`.`id`
                    WHERE `r`.`event_id` = '.intval($eventId).'
                    AND `r`.`type` = 1
                    AND `f`.`type` = "seating"
                ';
                $objResultRegistrations = $objDatabase->Execute($queryRegistrations);
                
                $reservedSeating = 0;
                if ($objResultRegistrations !== false) {
                    while (!$objResultRegistrations->EOF) {
                        $reservedSeating += intval($objResultRegistrations->fields['reserved_seating']);
                        $objResultRegistrations->MoveNext();
                    }
                }
                
                $freePlaces = intval($this->numSubscriber - $reservedSeating);
                $this->freePlaces = $freePlaces < 0 ? 0 : $freePlaces;
                
                $queryHosts = '
                    SELECT host_id                            
                    FROM '.DBPREFIX.'module_'.$this->moduleTablePrefix.'_rel_event_host
                    WHERE event_id = '.intval($eventId)
                ;
                                
                $objResultHosts = $objDatabase->Execute($queryHosts); 
                
                if ($objResultHosts !== false) {      
                    while (!$objResultHosts->EOF) {                                             
                        $this->relatedHosts[] = intval($objResultHosts->fields['host_id']);
                        $objResultHosts->MoveNext();
                    }
                }
                
                self::getData(); 
            }
        }
    }
    
    /**
     * gets the data for the event
     * 
     * @return null
     */
    function getData() {
        global $objDatabase, $_ARRAYLANG, $_LANGID;
        
        $activeLangs = explode(",", $this->showIn);
        $this->arrData = array();
        
        foreach ($activeLangs as $key => $langId) {
            $query = "SELECT field.title AS title,
                             field.description AS description,
                             field.redirect AS redirect                                 
                        FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_event_field AS field
                       WHERE field.event_id = '".intval($this->id)."'
                         AND field.lang_id = '".intval($langId)."'
                       LIMIT 1";
            
            $objResult = $objDatabase->Execute($query);
            
            if ($objResult !== false) {
                while (!$objResult->EOF) {
                        $this->arrData['title'][$langId] = htmlentities(stripslashes($objResult->fields['title']), ENT_QUOTES, CONTREXX_CHARSET);                        
                        $this->arrData['description'][$langId] = stripslashes($objResult->fields['description']);
                        $this->arrData['redirect'][$langId] = htmlentities(stripslashes($objResult->fields['redirect']), ENT_QUOTES, CONTREXX_CHARSET);                         
                        $objResult->MoveNext();
                }
            }
        }        
    }     
    
    /**
     * Save the event to the database
     *      
     * @param array $data
     * 
     * @return boolean true if saved successfully, false otherwise
     */
    function save($data){
        global $objDatabase, $_LANGID, $_CONFIG, $objInit;
        
        parent::getSettings();

        if(empty($data['startDate']) || empty($data['endDate']) || empty($data['category']) || ($data['seriesStatus'] == 1 && $data['seriesType'] == 2 && empty($data['seriesWeeklyDays']))) {
            return false;
        }
        
        foreach ($_POST['showIn'] as $key => $langId) {
            if(empty($_POST['title'][$langId]) && empty($_POST['title'][$_LANGID])) {
                return false;
            }
        }
        
        list($startDate, $strStartTime) = explode(' ', $data['startDate']);
        list($startHour, $startMin)     = explode(':', $strStartTime);
        
        list($endDate, $strEndTime)     = explode(' ', $data['endDate']);
        list($endHour, $endMin)         = explode(':', $strEndTime);
        
        if ($data['all_day']) {
            list($startHour, $startMin) = array(0, 0);
            list($endHour, $endMin)     = array(23, 59);;
        }
        
        //event data
        $id            = isset($data['copy']) && !empty($data['copy']) ? 0 : (isset($data['id']) ? intval($data['id']) : 0);
        $type          = isset($data['type']) ? intval($data['type']) : 0;
        $startDate     = date("Y-m-d H:i:s", parent::getDateTimestamp($startDate, intval($startHour), intval($startMin)));
        $endDate       = date("Y-m-d H:i:s", parent::getDateTimestamp($endDate, intval($endHour), intval($endMin)));
        $google        = isset($data['map'][$_LANGID]) ? intval($data['map'][$_LANGID]) : 0;
        $allDay        = isset($data['all_day']) ? 1 : 0;
        $convertBBCode = ($objInit->mode == 'frontend' && empty($id));
        
        $useCustomDateDisplay = isset($data['showDateSettings']) ? 1 : 0;
        $showStartDateList    = isset($data['showStartDateList']) ? $data['showStartDateList'] : 0;
        $showEndDateList      = isset($data['showEndDateList']) ? $data['showEndDateList'] : 0;
        
        if($objInit->mode == 'backend') {            
            // reset time values if "no time" is selected
            if($data['showTimeTypeList'] == 0 ) {
                $showStartTimeList = 0;
                $showEndTimeList   = 0;
            } else {
                $showStartTimeList = isset($data['showStartTimeList']) ? $data['showStartTimeList'] : '';
                $showEndTimeList   = isset($data['showEndTimeList']) ? $data['showEndTimeList'] : '';
            }
            
            $showTimeTypeList    = isset($data['showTimeTypeList']) ? $data['showTimeTypeList'] : '';            
            $showStartDateDetail = isset($data['showStartDateDetail']) ? $data['showStartDateDetail'] : '';
            $showEndDateDetail   = isset($data['showEndDateDetail']) ? $data['showEndDateDetail'] : '';

            // reset time values if "no time" is selected
            if( $data['showTimeTypeDetail'] == 0){
                $showStartTimeDetail = 0;
                $showEndTimeDetail   = 0;
            } else {
                $showStartTimeDetail = isset($data['showStartTimeDetail']) ? $data['showStartTimeDetail'] : '';
                $showEndTimeDetail   = isset($data['showEndTimeDetail']) ? $data['showEndTimeDetail'] : '';
            }
            $showTimeTypeDetail = isset($data['showTimeTypeDetail']) ? $data['showTimeTypeDetail'] : '';
        } else {
            $showStartDateList = ($this->arrSettings['showStartDateList'] == 1) ? 1 : 0;
            $showEndDateList   = ($this->arrSettings['showEndDateList'] == 1) ? 1 : 0;            
            $showStartTimeList = ($this->arrSettings['showStartTimeList'] == 1) ? 1 : 0;
            $showEndTimeList   = ($this->arrSettings['showEndTimeList'] == 1) ? 1 : 0;
            
            // reset time values if "no time" is selected
            if($showStartTimeList == 1 || $showEndTimeList == 1) {
                $showTimeTypeList = 1;
            } else {
                $showStartTimeList = 0;
                $showEndTimeList   = 0;
                $showTimeTypeList  = 0;
            }
            
            $showStartDateDetail = ($this->arrSettings['showStartDateDetail'] == 1) ? 1 : 0;
            $showEndDateDetail   = ($this->arrSettings['showEndDateDetail'] == 1) ? 1 : 0;
            $showStartTimeDetail = ($this->arrSettings['showStartTimeDetail'] == 1) ? 1 : 0;
            $showEndTimeDetail   = ($this->arrSettings['showEndTimeDetail'] == 1) ? 1 : 0;
            
            // reset time values if "no time" is selected
            if($showStartTimeDetail == 1 || $showEndTimeDetail == 1) {
                $showTimeTypeDetail = 1;
            } else {
                $showStartTimeDetail = 0;
                $showEndTimeDetail   = 0;
                $showTimeTypeDetail  = 0;
            }
        }
                
        $access                    = isset($data['access']) ? intval($data['access']) : 0;
        $priority                  = isset($data['priority']) ? intval($data['priority']) : 0;
        $placeMediadir             = isset($data['placeMediadir']) ? intval($data['placeMediadir']) : 0;
        $hostMediadir              = isset($data['hostMediadir']) ? intval($data['hostMediadir']) : 0;
        $price                     = isset($data['price']) ? contrexx_addslashes(contrexx_strip_tags($data['price'])) : 0;
        $link                      = isset($data['link']) ? contrexx_addslashes(contrexx_strip_tags($data['link'])) : '';
        $pic                       = isset($data['picture']) ? contrexx_addslashes(contrexx_strip_tags($data['picture'])) : '';
        $attach                    = isset($data['attachment']) ? contrexx_addslashes(contrexx_strip_tags($data['attachment'])) : '';     
        $catId                     = isset($data['category']) ? intval($data['category']) : '';   
        $showIn                    = isset($data['showIn']) ? contrexx_addslashes(contrexx_strip_tags(join(",",$data['showIn']))) : '';
        $invited_groups            = isset($data['selectedGroups']) ? join(',', $data['selectedGroups']) : ''; 
        $invited_mails             = isset($data['invitedMails']) ? contrexx_addslashes(contrexx_strip_tags($data['invitedMails'])) : '';   
        $send_invitation           = isset($data['sendInvitation']) ? intval($data['sendInvitation']) : 0;        
        $invitationTemplate        = isset($data['invitationEmailTemplate']) ? contrexx_input2db($data['invitationEmailTemplate']) : 0;        
        $registration              = isset($data['registration']) ? intval($data['registration']) : 0;      
        $registration_form         = isset($data['registrationForm']) ? intval($data['registrationForm']) : 0;      
        $registration_num          = isset($data['numSubscriber']) ? intval($data['numSubscriber']) : 0;      
        $registration_notification = isset($data['notificationTo']) ? contrexx_addslashes(contrexx_strip_tags($data['notificationTo'])) : '';
        $email_template            = isset($data['emailTemplate']) ? contrexx_input2db($data['emailTemplate']) : 0;
        $ticket_sales              = isset($data['ticketSales']) ? intval($data['ticketSales']) : 0;
        $num_seating               = isset($data['numSeating']) ? json_encode(explode(',', $data['numSeating'])) : '';
        $related_hosts             = isset($data['selectedHosts']) ? $data['selectedHosts'] : '';        
        $locationType              = isset($data['eventLocationType']) ? (int) $data['eventLocationType'] : $this->arrSettings['placeData'];
        $hostType                  = isset($data['eventHostType']) ? (int) $data['eventHostType'] : $this->arrSettings['placeDataHost'];
        $place                     = isset($data['place']) ? contrexx_input2db(contrexx_strip_tags($data['place'])) : '';
        $street                    = isset($data['street']) ? contrexx_input2db(contrexx_strip_tags($data['street'])) : '';
        $zip                       = isset($data['zip']) ? contrexx_input2db(contrexx_strip_tags($data['zip'])) : '';
        $city                      = isset($data['city']) ? contrexx_input2db(contrexx_strip_tags($data['city'])) : '';
        $country                   = isset($data['country']) ? contrexx_input2db(contrexx_strip_tags($data['country'])) : '';
        $placeLink                 = isset($data['placeLink']) ? contrexx_input2db($data['placeLink']) : '';
        $placeMap                  = isset($data['placeMap']) ? contrexx_input2db($data['placeMap']) : '';
        $update_invitation_sent    = ($send_invitation == 1);
        
        if (!empty($placeLink)) {
            if (!preg_match('%^(?:ftp|http|https):\/\/%', $placeLink)) {
                $placeLink = "http://".$placeLink;
            }
        }
        
        if($objInit->mode == 'frontend') {
            $unique_id = intval($_REQUEST[self::MAP_FIELD_KEY]);

            if (!empty($unique_id)) {
                $picture = $this->_handleUpload('mapUpload', $unique_id);

                if (!empty($picture)) {
                    $placeMap = $picture;
                }
            }
        }

        $orgName   = isset($data['organizerName']) ? contrexx_input2db($data['organizerName']) : '';
        $orgStreet = isset($data['organizerStreet']) ? contrexx_input2db($data['organizerStreet']) : '';
        $orgZip    = isset($data['organizerZip']) ? contrexx_input2db($data['organizerZip']) : '';
        $orgCity   = isset($data['organizerCity']) ? contrexx_input2db($data['organizerCity']) : '';
        $orgCountry= isset($data['organizerCountry']) ? contrexx_input2db($data['organizerCountry']) : '';
        $orgLink   = isset($data['organizerLink']) ? contrexx_input2db($data['organizerLink']) : '';
        $orgEmail  = isset($data['organizerEmail']) ? contrexx_input2db($data['organizerEmail']) : '';
        if (!empty($orgLink)) {
            if (!preg_match('%^(?:ftp|http|https):\/\/%', $orgLink)) {
                $orgLink = "http://".$orgLink;
            }
        }
        
        // create thumb if not exists
        if (!file_exists(ASCMS_PATH."$placeMap.thumb")) {                    
            $objImage = new ImageManager();
            $objImage->_createThumb(dirname(ASCMS_PATH."$placeMap")."/", '', basename($placeMap), 180);
        }

        //frontend picture upload & thumbnail creation
        if($objInit->mode == 'frontend') {
            $unique_id = intval($_REQUEST[self::PICTURE_FIELD_KEY]);
            
            if (!empty($unique_id)) {
                $picture = $this->_handleUpload('pictureUpload', $unique_id);

                if (!empty($picture)) {
                    //delete thumb
                    if (file_exists("{$this->uploadImgPath}$pic.thumb")) {
                        \Cx\Lib\FileSystem\FileSystem::delete_file($this->uploadImgPath."/.$pic.thumb");
                    }

                    //delete image
                    if (file_exists("{$this->uploadImgPath}$pic")) {
                        \Cx\Lib\FileSystem\FileSystem::delete_file($this->uploadImgPath."/.$pic");
                    }

                    $pic = $picture;
                }
            }
        } else {
            // create thumb if not exists
            if (!file_exists(ASCMS_PATH."$pic.thumb")) {
                $objImage = new ImageManager();
                $objImage->_createThumb(dirname(ASCMS_PATH."$pic")."/", '', basename($pic), 180);
            }
        }
        
        $seriesStatus = isset($data['seriesStatus']) ? intval($data['seriesStatus']) : 0; 
        
        
        //series pattern
        $seriesStatus = isset($data['seriesStatus']) ? intval($data['seriesStatus']) : 0;
        $seriesType   = isset($data['seriesType']) ? intval($data['seriesType']) : 0;
        
        $seriesPatternCount             = 0;
        $seriesPatternWeekday           = 0;
        $seriesPatternDay               = 0;
        $seriesPatternWeek              = 0;
        $seriesPatternMonth             = 0;
        $seriesPatternType              = 0;
        $seriesPatternDouranceType      = 0;
        $seriesPatternEnd               = 0;
        $seriesExeptions                = '';
        $seriesPatternEndDate           = 0;
        
        if($seriesStatus == 1) {
            if(!empty($data['seriesExeptions'])) {
                $exeptions = array();
                                
                foreach($data['seriesExeptions'] as $key => $exeptionDate)  {
                    $exeptions[] = date("Y-m-d", parent::getDateTimestamp($exeptionDate, 23, 59));  
                }  
                
                sort($exeptions);
                
                $seriesExeptions = join(",", $exeptions);
            }
        
            switch($seriesType) {
                case 1;
                    if ($seriesStatus == 1) {
                        $seriesPatternType          = isset($data['seriesDaily']) ? intval($data['seriesDaily']) : 0;
                        if($seriesPatternType == 1) {
                            $seriesPatternWeekday   = 0;
                            $seriesPatternDay       = isset($data['seriesDailyDays']) ? intval($data['seriesDailyDays']) : 0;
                        } else {
                            $seriesPatternWeekday   = "1111100";
                            $seriesPatternDay       = 0;
                        }

                        $seriesPatternWeek          = 0;
                        $seriesPatternMonth         = 0;
                        $seriesPatternCount         = 0;
                    }
                break;
                case 2;
                    if ($seriesStatus == 1) {
                        $seriesPatternWeek          = isset($data['seriesWeeklyWeeks']) ? intval($data['seriesWeeklyWeeks']) : 0;

                        for($i=1; $i <= 7; $i++) {
                            if (isset($data['seriesWeeklyDays'][$i])) {
                                $weekdayPattern .= "1";
                            } else {
                                $weekdayPattern .= "0";
                            }
                        }

                        $seriesPatternWeekday       = $weekdayPattern;

                        $seriesPatternCount         = 0;
                        $seriesPatternDay           = 0;
                        $seriesPatternMonth         = 0;
                        $seriesPatternType          = 0;
                    }
                break;
                case 3;
                    if ($seriesStatus == 1) {
                        $seriesPatternType          = isset($data['seriesMonthly']) ? intval($data['seriesMonthly']) : 0;
                        if($seriesPatternType == 1) {
                            $seriesPatternMonth     = isset($data['seriesMonthlyMonth_1']) ? intval($data['seriesMonthlyMonth_1']) : 0;
                            $seriesPatternDay       = isset($data['seriesMonthlyDay']) ? intval($data['seriesMonthlyDay']) : 0;
                            $seriesPatternWeekday   = 0;
                        } else {
                            $seriesPatternCount     = isset($data['seriesMonthlyDayCount']) ? intval($data['seriesMonthlyDayCount']) : 0;
                            $seriesPatternMonth     = isset($data['seriesMonthlyMonth_2']) ? intval($data['seriesMonthlyMonth_2']) : 0;
                            
                            if ($seriesPatternMonth < 1) {
                                // the increment must be at least once a month, otherwise we will end up in a endless loop in the presence
                                $seriesPatternMonth = 1;
                            }
                            $seriesPatternWeekday   = isset($data['seriesMonthlyWeekday']) ? $data['seriesMonthlyWeekday'] : '';
                            $seriesPatternDay       = 0;
                        }

                        $seriesPatternWeek           = 0;
                    }
                break;
            }
                
            $seriesPatternDouranceType  = isset($data['seriesDouranceType']) ? intval($data['seriesDouranceType']) : 0;                        
            switch($seriesPatternDouranceType) {
                case 1:
                    $seriesPatternEnd   = 0;
                break;
                case 2:
                    $seriesPatternEnd   = isset($data['seriesDouranceEvents']) ? intval($data['seriesDouranceEvents']) : 0;
                break;
                case 3:
                    $seriesPatternEndDate = date("Y-m-d H:i:s", parent::getDateTimestamp($data['seriesDouranceDate'], 23, 59));    
                break;
            }
        }
                
        $formData = array(
            'type'                          => $type,
            'startdate'                     => $startDate,
            'enddate'                       => $endDate,
            'use_custom_date_display'       => $useCustomDateDisplay,
            'showStartDateList'             => $showStartDateList,
            'showEndDateList'               => $showEndDateList,
            'showStartTimeList'             => $showStartTimeList,
            'showEndTimeList'               => $showEndTimeList,
            'showTimeTypeList'              => $showTimeTypeList,
            'showStartDateDetail'           => $showStartDateDetail,
            'showEndDateDetail'             => $showEndDateDetail,
            'showStartTimeDetail'           => $showStartTimeDetail,
            'showEndTimeDetail'             => $showEndTimeDetail,
            'showTimeTypeDetail'            => $showTimeTypeDetail,
            'google'                        => $google,
            'access'                        => $access,
            'priority'                      => $priority,
            'price'                         => $price,
            'link'                          => $link,
            'pic'                           => $pic,
            'catid'                         => $catId,
            'attach'                        => $attach,
            'place_mediadir_id'             => $placeMediadir,
            'host_mediadir_id'              => $hostMediadir,            
            'show_in'                       => $showIn,
            'invited_groups'                => $invited_groups,             
            'invited_mails'                 => $invited_mails,
            'invitation_email_template'     => json_encode($invitationTemplate),
            'registration'                  => $registration, 
            'registration_form'             => $registration_form, 
            'registration_num'              => $registration_num, 
            'registration_notification'     => $registration_notification,
            'email_template'                => json_encode($email_template),
            'ticket_sales'                  => $ticket_sales,
            'num_seating'                   => $num_seating,            
            'series_status'                 => $seriesStatus,
            'series_type'                   => $seriesType,
            'series_pattern_count'          => $seriesPatternCount,
            'series_pattern_weekday'        => $seriesPatternWeekday,
            'series_pattern_day'            => $seriesPatternDay,
            'series_pattern_week'           => $seriesPatternWeek,
            'series_pattern_month'          => $seriesPatternMonth,
            'series_pattern_type'           => $seriesPatternType,
            'series_pattern_dourance_type'  => $seriesPatternDouranceType,
            'series_pattern_end'            => $seriesPatternEnd,
            'series_pattern_end_date'       => $seriesPatternEndDate,
            'series_pattern_exceptions'     => $seriesExeptions,
            'all_day'                       => $allDay,
            'location_type'                 => $locationType,
            'host_type'                     => $hostType,
            'place'                         => $place,
            'place_id'                      => 0,
            'place_street'                  => $street,
            'place_zip'                     => $zip,
            'place_city'                    => $city,
            'place_country'                 => $country,
            'place_link'                    => $placeLink,
            'place_map'                     => $placeMap,
            'org_name'                      => $orgName,
            'org_street'                    => $orgStreet,
            'org_zip'                       => $orgZip,
            'org_city'                      => $orgCity,
            'org_country'                   => $orgCountry,
            'org_link'                      => $orgLink,
            'org_email'                     => $orgEmail,
            'invitation_sent'               => $update_invitation_sent ? 1 : 0,
        );
        
        if ($id != 0) {            
            $query = SQL::update("module_{$this->moduleTablePrefix}_event", $formData) ." WHERE id = '$id'";
        
            $objResult = $objDatabase->Execute($query);
            
            if ($objResult !== false) {
                $this->id = $id;
                $query = "DELETE FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_event_field
                                WHERE event_id = '".$id."'";    
                                
                $objResult = $objDatabase->Execute($query);   
                
                $query = "DELETE FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_event_host
                                WHERE event_id = '".$id."'";    
                                
                $objResult = $objDatabase->Execute($query); 
            } else {
                return false;
            }
        } else {
            $objFWUser  = FWUser::getFWUserObject();
            $objUser    = $objFWUser->objUser;

            if ($objInit->mode == 'frontend') {
                $status    = 1;
                $confirmed = $this->arrSettings['confirmFrontendEvents'] == 1 ? 0 : 1;
                $author    = $objUser->login() ? intval($objUser->getId()) : 0;
            } else {
                $status    = 0;
                $confirmed = 1;
                $author    = intval($objUser->getId());
            }

            $formData['status']    = $status;
            $formData['confirmed'] = $confirmed;
            $formData['author']    = $author;
                                  
            $query = SQL::insert("module_{$this->moduleTablePrefix}_event", $formData);
            
            $objResult = $objDatabase->Execute($query); 
            
            if ($objResult !== false) {           
                $id = intval($objDatabase->Insert_ID());
                $this->id = $id;
            } else {
                return false; 
            }
        }
        
        if($id != 0) {
            foreach ($data['showIn'] as $key => $langId) {
                $title = contrexx_addslashes(contrexx_strip_tags($data['title'][$langId]));
                $description = contrexx_addslashes($data['description'][$langId]);
                if ($convertBBCode) {
                    $description = \Cx\Core\Wysiwyg\Wysiwyg::prepareBBCodeForDb($data['description'][$langId], true);
                }
                $redirect = contrexx_addslashes($data['redirect'][$langId]);

                if($type == 0) {
                    $redirect = '';
                } else {
                    $description = '';
                }

                $query = "INSERT INTO ".DBPREFIX."module_".$this->moduleTablePrefix."_event_field
                            (`event_id`,`lang_id`,`title`, `description`,`redirect`)
                          VALUES
                            ('".intval($id)."','".intval($langId)."','".$title."','".$description."','".$redirect."')";

                $objResult = $objDatabase->Execute($query); 

                if ($objResult === false) {
                    return false;
                }
            }
            
            if(!empty($related_hosts)) {
                foreach ($related_hosts as $key => $hostId) {
                    $query = "INSERT INTO ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_event_host
                                      (`host_id`,`event_id`) 
                               VALUES ('".intval($hostId)."','".intval($id)."')";
                               
                    $objResult = $objDatabase->Execute($query); 
                }
            }
        }   
            
        if($send_invitation == 1) {    
             $objMailManager = new CalendarMailManager();    
             foreach ($invitationTemplate as $templateId) {
                 $objMailManager->sendMail(intval($id), CalendarMailManager::MAIL_INVITATION, null, $templateId);
             }
        }
        
        return true;
    }
    
    function loadEventFromPost($data)
    {
        list($startDate, $strStartTime) = explode(' ', $data['startDate']);
        list($startHour, $startMin)     = explode(':', $strStartTime);
        
        list($endDate, $strEndTime)     = explode(' ', $data['endDate']);
        list($endHour, $endMin)         = explode(':', $strEndTime);
        
        list($startHour, $startMin) = array(0, 0);
        list($endHour, $endMin)     = array(0, 0);
        
        
        //event data        
        $startDate     = parent::getDateTimestamp($startDate, intval($startHour), intval($startMin));
        $endDate       = parent::getDateTimestamp($endDate, intval($endHour), intval($endMin));
        
        $this->startDate = $startDate;
        $this->endDate   = $endDate;
        
        //series pattern
        $seriesStatus = isset($data['seriesStatus']) ? intval($data['seriesStatus']) : 0;
        $seriesType   = isset($data['seriesType']) ? intval($data['seriesType']) : 0;
        
        $seriesPatternCount             = 0;
        $seriesPatternWeekday           = 0;
        $seriesPatternDay               = 0;
        $seriesPatternWeek              = 0;
        $seriesPatternMonth             = 0;
        $seriesPatternType              = 0;
        $seriesPatternDouranceType      = 0;
        $seriesPatternEnd               = 0;
        $seriesExeptions = '';
        
        if($seriesStatus == 1) {
        
            switch($seriesType) {
                case 1;
                    if ($seriesStatus == 1) {
                        $seriesPatternType          = isset($data['seriesDaily']) ? intval($data['seriesDaily']) : 0;
                        if($seriesPatternType == 1) {
                            $seriesPatternWeekday   = 0;
                            $seriesPatternDay       = isset($data['seriesDailyDays']) ? intval($data['seriesDailyDays']) : 0;
                        } else {
                            $seriesPatternWeekday   = "1111100";
                            $seriesPatternDay       = 0;
                        }

                        $seriesPatternWeek          = 0;
                        $seriesPatternMonth         = 0;
                        $seriesPatternCount         = 0;
                    }
                break;
                case 2;
                    if ($seriesStatus == 1) {
                        $seriesPatternWeek          = isset($data['seriesWeeklyWeeks']) ? intval($data['seriesWeeklyWeeks']) : 0;

                        $weekdayPattern = '';
                        for($i=1; $i <= 7; $i++) {
                            if (isset($data['seriesWeeklyDays'][$i])) {
                                $weekdayPattern .= "1";
                            } else {
                                $weekdayPattern .= "0";
                            }
                        }
                        
                        // To DO: not correct to set day to monday
                        $seriesPatternWeekday       = (int) $weekdayPattern == 0 ? '1000000' : $weekdayPattern;

                        $seriesPatternCount         = 0;
                        $seriesPatternDay           = 0;
                        $seriesPatternMonth         = 0;
                        $seriesPatternType          = 0;
                    }
                break;
                case 3;
                    if ($seriesStatus == 1) {
                        $seriesPatternType          = isset($data['seriesMonthly']) ? intval($data['seriesMonthly']) : 0;
                        if($seriesPatternType == 1) {
                            $seriesPatternMonth     = isset($data['seriesMonthlyMonth_1']) ? intval($data['seriesMonthlyMonth_1']) : 0;
                            $seriesPatternDay       = isset($data['seriesMonthlyDay']) ? intval($data['seriesMonthlyDay']) : 0;
                            $seriesPatternWeekday   = 0;
                        } else {
                            $seriesPatternCount     = isset($data['seriesMonthlyDayCount']) ? intval($data['seriesMonthlyDayCount']) : 0;
                            $seriesPatternMonth     = isset($data['seriesMonthlyMonth_2']) ? intval($data['seriesMonthlyMonth_2']) : 0;
                            
                            if ($seriesPatternMonth < 1) {
                                // the increment must be at least once a month, otherwise we will end up in a endless loop in the presence
                                $seriesPatternMonth = 1;
                            }
                            $seriesPatternWeekday   = isset($data['seriesMonthlyWeekday']) ? $data['seriesMonthlyWeekday'] : '';
                            $seriesPatternDay       = 0;
                        }

                        $seriesPatternWeek           = 0;
                    }
                break;
            }
                
            $seriesPatternDouranceType  = isset($data['seriesDouranceType']) ? intval($data['seriesDouranceType']) : 0;            
            $seriesPatternEndDate = '';
            switch($seriesPatternDouranceType) {
                case 1:
                    $seriesPatternEnd   = 0;
                break;
                case 2:
                    $seriesPatternEnd   = isset($data['seriesDouranceEvents']) ? intval($data['seriesDouranceEvents']) : 0;
                break;
                case 3:
                    $seriesPatternEndDate = parent::getDateTimestamp($data['seriesDouranceDate'], 0, 0) ;    
                break;
            }
        }
        
        $this->seriesData['seriesPatternCount'] = intval($seriesPatternCount); 
        $this->seriesData['seriesType'] = intval($seriesType); 
        $this->seriesData['seriesPatternCount'] = intval($seriesPatternCount); 
        $this->seriesData['seriesPatternWeekday'] = htmlentities($seriesPatternWeekday, ENT_QUOTES, CONTREXX_CHARSET);     
        $this->seriesData['seriesPatternDay'] = intval($seriesPatternDay); 
        $this->seriesData['seriesPatternWeek'] = intval($seriesPatternWeek); 
        $this->seriesData['seriesPatternMonth'] = intval($seriesPatternMonth); 
        $this->seriesData['seriesPatternType'] = intval($seriesPatternType); 
        $this->seriesData['seriesPatternDouranceType'] = intval($seriesPatternDouranceType); 
        $this->seriesData['seriesPatternEnd'] = intval($seriesPatternEnd); 
        $this->seriesData['seriesPatternEndDate'] = intval($seriesPatternEndDate); 
        $this->seriesData['seriesPatternBegin'] = 0; 
        $this->seriesData['seriesPatternExceptions'] = '';
        
    }
    
    /**
     * Delete the event
     *      
     * @return boolean true if deleted successfully, false otherwise
     */
    function delete(){
        global $objDatabase;
        
        $query = "DELETE FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_event
                   WHERE id = '".intval($this->id)."'";
        
        $objResult = $objDatabase->Execute($query);
        
        if ($objResult !== false) {
            $query = "DELETE FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_event_field
                            WHERE event_id = '".intval($this->id)."'";
        
            $objResult = $objDatabase->Execute($query);
            if ($objResult !== false) {
                $query = "DELETE FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_event_host
                                WHERE event_id = '".intval($this->id)."'";    
                                
                $objResult = $objDatabase->Execute($query); 
                if ($objResult !== false) {   
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
    
    /**
     * Export the Event with calendar and stop excuting script
     *      
     * @return null
     */
    function export(){
        global $_CONFIG;
                                     
        //create new calendar                                                 
        $objVCalendar = new vcalendar();
        $objVCalendar->setConfig('unique_id', $_CONFIG['coreGlobalPageTitle']);
        $objVCalendar->setConfig('filename', urlencode($this->title).'.ics'); // set Your unique id     
        //$v->setProperty('X-WR-CALNAME', 'Calendar Sample');  
        //$v->setProperty('X-WR-CALDESC', 'Calendar Description');
        //$v->setProperty('X-WR-TIMEZONE', 'America/Los_Angeles');
        $objVCalendar->setProperty('X-MS-OLK-FORCEINSPECTOROPEN', 'TRUE');
        $objVCalendar->setProperty('METHOD','PUBLISH');
             
        // create an event calendar component                                                                     
        $objVEvent = new vevent(); 
        
        // start  
        $startYear = date("Y", $this->startDate);
        $startMonth = date("m", $this->startDate); 
        $startDay = date("d", $this->startDate);
        $startHour = date("H", $this->startDate);
        $startMinute = date("i", $this->startDate);
        
        $objVEvent->setProperty( 'dtstart', array( 'year'=>$startYear, 'month'=>$startMonth, 'day'=>$startDay, 'hour'=>$startHour, 'min'=>$startMinute, 'sec'=>0 ));
         
        // end  
        $endYear = date("Y", $this->endDate);
        $endMonth = date("m", $this->endDate); 
        $endDay = date("d", $this->endDate);
        $endHour = date("H", $this->endDate);
        $endMinute = date("i", $this->endDate);
          
        $objVEvent->setProperty( 'dtend', array( 'year'=>$endYear, 'month'=>$endMonth, 'day'=>$endDay, 'hour'=>$endHour, 'min'=>$endMinute, 'sec'=>0 )); 
        
        // place   
        if(!empty($this->place)) {  
            $objVEvent->setProperty( 'location', html_entity_decode($this->place, ENT_QUOTES, CONTREXX_CHARSET));
        }
        
        // title
        $objVEvent->setProperty( 'summary', html_entity_decode($this->title, ENT_QUOTES, CONTREXX_CHARSET)); 
        
        // description
        $objVEvent->setProperty( 'description', html_entity_decode(strip_tags($this->description), ENT_QUOTES, CONTREXX_CHARSET)); 
        
        // organizer                         
        $objVEvent->setProperty( 'organizer' , $_CONFIG['coreGlobalPageTitle'].' <'.$_CONFIG['coreAdminEmail'].'>');    
        
        // comment
        //$objVEvent->setProperty( 'comment', 'This is a comment' ); 
        
        // attendee 
        //$objVEvent->setProperty( 'attendee', 'attendee1@icaldomain.net' );
         
        // ressourcen
        //$objVEvent->setProperty( 'resources', 'COMPUTER PROJECTOR' );  
         
        // series type
        //$objVEvent->setProperty( 'rrule', array( 'FREQ' => 'WEEKLY', 'count' => 4));// weekly, four occasions  
        
        // add event to calendar
        $objVCalendar->setComponent ($objVEvent);                        
         
        $objVCalendar->returnCalendar();     
        exit;          
    }
    
    /**
     * set the event start date
     * 
     * @param integer $value start date
     */
    function setStartDate($value){
        $this->startDate = intval($value);
    }
    
    /**
     * set the event end date
     * 
     * @param integer $value End date
     * 
     * @return null
     */
    function setEndDate($value){
        $this->endDate = intval($value);
    }
    
    /**
     * switch status of the event
     *      
     * @return boolean true if status updated, false otherwise
     */
    function switchStatus(){
        global $objDatabase;
        
        if($this->status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }
             
        $query = "UPDATE ".DBPREFIX."module_".$this->moduleTablePrefix."_event AS event
                     SET event.status = '".intval($status)."'
                   WHERE event.id = '".intval($this->id)."'";
        
        $objResult = $objDatabase->Execute($query);
        
        if ($objResult !== false) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * confirm event
     *      
     * @return boolean true if event confirmed, false otherwise
     */
    function confirm(){
        global $objDatabase;    
             
        $query = "UPDATE ".DBPREFIX."module_".$this->moduleTablePrefix."_event AS event
                     SET event.confirmed = '1'
                   WHERE event.id = '".intval($this->id)."'";
        
        $objResult = $objDatabase->Execute($query);
        
        if ($objResult !== false) {
            return true;
        } else {
            return false;
        }
    }

   
    /**
     * Handle the calendar image upload
     * 
     * @param string $id unique form id
     * 
     * @return string image path
     */
    function _handleUpload($fieldName, $id)
    {
        $tup              = self::getTemporaryUploadPath($fieldName, $id);
        $tmpUploadDir     = ASCMS_PATH.$tup[1].'/'.$tup[2].'/'; //all the files uploaded are in here                       
        $depositionTarget = $this->uploadImgPath; //target folder
        $pic              = '';

        //move all files
        if(!\Cx\Lib\FileSystem\FileSystem::exists($tmpUploadDir))
            throw new Exception("could not find temporary upload directory '$tmpUploadDir'");

        $h = opendir($tmpUploadDir);
        if ($h) {
            while(false !== ($f = readdir($h))) {
                if($f != '..' && $f != '.') {
                    //do not overwrite existing files.
                    $prefix = '';
                    while (file_exists($depositionTarget.$prefix.$f)) {
                        if (empty($prefix)) {
                            $prefix = 0;
                        }
                        $prefix ++;
                    }

                    // move file
                    try {
                        $objFile = new \Cx\Lib\FileSystem\File($tmpUploadDir.$f);
                        $objFile->move($depositionTarget.$prefix.$f, false);
                        
                        $imageName = $prefix.$f;
                        $objImage = new ImageManager();
                        $objImage->_createThumb($this->uploadImgPath, $this->uploadImgWebPath, $imageName, 180);

                        $pic = contrexx_input2raw($this->uploadImgWebPath.$imageName);
                    } catch (\Cx\Lib\FileSystem\FileSystemException $e) {
                        \DBG::msg($e->getMessage());                        
                    }                    
                }
            }    
        }
                
        return $pic;
    }

    /**
     * Used get the event search query
     * From global search module.
     * 
     * @param mixed $term Search term
     * 
     * @return string search query
     */
    static function getEventSearchQuery($term)
    {
        global $_LANGID;
        
        $query = "SELECT event.`id` AS `id`,
                         event.`startdate`,
                         field.`title` AS `title`,
                         field.`description` AS content,
                         event.`place` AS place,
                         MATCH (field.`title`, field.`description`) AGAINST ('%$term%') AS `score`
                    FROM ".DBPREFIX."module_calendar_event AS event,
                         ".DBPREFIX."module_calendar_event_field AS field
                   WHERE   (event.id = field.event_id AND field.lang_id = '".intval($_LANGID)."')
                       AND event.status = 1
                       AND (   field.title LIKE ('%$term%')
                            OR field.description LIKE ('%$term%')
                            OR event.place LIKE ('%$term%')
                           )";
        
        return $query;
    }

    /**
     * Loads the location fields from the selected media directory entry
     * 
     * @param integer $intMediaDirId  media directory Entry id
     * @param string  $type           place type 
     *                                availble options are place or host
     * @return null   it loads the place values based on the media directory Entry id and type
     */    
    function loadPlaceFromMediadir($intMediaDirId = 0, $type = 'place')
    {
        $place         = '';
        $place_street  = '';
        $place_zip     = '';
        $place_city    = '';
        $place_country = '';        
                
        if (!empty($intMediaDirId)) {
            $objMediadirEntry = new mediaDirectoryEntry();
            $objMediadirEntry->getEntries(intval($intMediaDirId)); 
            //get inputfield object                    
            $objInputfields = new mediaDirectoryInputfield($objMediadirEntry->arrEntries[$intMediaDirId]['entryFormId'],false,$objMediadirEntry->arrEntries[$intMediaDirId]['entryTranslationStatus']);

            foreach ($objInputfields->arrInputfields as $arrInputfield) {

                $intInputfieldType = intval($arrInputfield['type']);
                if ($intInputfieldType != 16 && $intInputfieldType != 17) {
                    if(!empty($arrInputfield['type'])) {
                        $strType = $arrInputfield['type_name'];
                        $strInputfieldClass = "mediaDirectoryInputfield".ucfirst($strType);
                        try {
                            $objInputfield = safeNew($strInputfieldClass);

                            if(intval($arrInputfield['type_multi_lang']) == 1) {
                                $arrInputfieldContent = $objInputfield->getContent($intMediaDirId, $arrInputfield, $objMediadirEntry->arrEntries[$intMediaDirId]['entryTranslationStatus']);
                            } else {
                                $arrInputfieldContent = $objInputfield->getContent($intMediaDirId, $arrInputfield, null);
                            }

                            switch ($arrInputfield['context_type']) {
                                case 'title':
                                    $place = end($arrInputfieldContent);
                                    break;
                                case 'address':
                                    $place_street = end($arrInputfieldContent);
                                    break;
                                case 'zip':                                
                                    $place_zip = end($arrInputfieldContent);
                                    break;
                                case 'city':
                                    $place_city = end($arrInputfieldContent);
                                    break;
                                case 'country':
                                    $place_country = end($arrInputfieldContent);
                                    break;
                            }

                        } catch (Exception $error) {
                            echo "Error: ".$error->getMessage();
                        }
                    }
                }
            }
        }
        
        if ($type == 'place') {
            $this->place         = $place;
            $this->place_street  = $place_street;
            $this->place_zip     = $place_zip;
            $this->place_city    = $place_city;
            $this->place_country = $place_country;
            $this->place_map     = '';
        } else {            
            $this->org_name   = $place;
            $this->org_street = $place_street;
            $this->org_zip    = $place_zip;
            $this->org_city   = $place_city;
            $this->org_country= $place_country;
            $this->org_email  = '';
        }
        
    }
    
    /**
     * Return event place url and its source link     
     * 
     * @return array place url and its source link
     */
    function loadPlaceLinkFromMediadir($intMediaDirId = 0, $type = 'place')
    {
        global $_LANGID, $_CONFIG;
        
        $placeUrl       = '';
        $placeUrlSource = '';
        
        if (!empty($intMediaDirId)) {
            $objMediadirEntry = new mediaDirectoryEntry();
            $objMediadirEntry->getEntries(intval($intMediaDirId)); 

            $pageRepo = \Env::em()->getRepository('Cx\Core\ContentManager\Model\Entity\Page');
            $pages = $pageRepo->findBy(array(
                'cmd'    => contrexx_addslashes('detail'.intval($objMediadirEntry->arrEntries[$intMediaDirId]['entryFormId'])),
                'lang'   => $_LANGID,
                'type'   => \Cx\Core\ContentManager\Model\Entity\Page::TYPE_APPLICATION,
                'module' => 'mediadir',
            ));

            if(count($pages)) {
                $strDetailCmd = 'detail'.intval($objMediadirEntry->arrEntries[$intMediaDirId]['entryFormId']);
            } else {
                $strDetailCmd = 'detail';
            }

            $pages = \Env::em()->getRepository('Cx\Core\ContentManager\Model\Entity\Page')->getFromModuleCmdByLang('mediadir', $strDetailCmd);

            $arrActiveFrontendLanguages = FWLanguage::getActiveFrontendLanguages();
            if (isset($arrActiveFrontendLanguages[FRONTEND_LANG_ID]) && isset($pages[FRONTEND_LANG_ID])) {
                $langId = FRONTEND_LANG_ID;
            } else if (isset($arrActiveFrontendLanguages[BACKEND_LANG_ID]) && isset($pages[BACKEND_LANG_ID])) {
                $langId = BACKEND_LANG_ID;
            } else {
                foreach ($arrActiveFrontendLanguages as $lang) {
                    if (isset($pages[$lang['id']])) {
                        $langId = $lang['id'];
                        break;
                    }
                }
            }

            // no page for mediadir available
            $url = '';
            if (isset($pages[$langId])) {
                $url = $pages[$langId]->getUrl(ASCMS_PROTOCOL."://".$_CONFIG['domainUrl'].ASCMS_PATH_OFFSET, "?eid={$intMediaDirId}");
            }

            $place          = ($type = 'place') ? $this->place : $this->org_name;
            $placeUrl       = "<a href='".$url."' target='_blank' >". (!empty($place) ? $place : $url) ."</a>";
            $placeUrlSource = $url;
        }
        
        return array($placeUrl, $placeUrlSource);
    }
}
