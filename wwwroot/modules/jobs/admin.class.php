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
 * jobsManager
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Comvation Development Team <info@comvation.com>
 * @access      public
 * @version     1.0.0
 * @package     contrexx
 * @subpackage  module_jobs
 * @todo        Edit PHP DocBlocks!
 */

/**
 * jobsManager
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Comvation Development Team <info@comvation.com>
 * @access      public
 * @version     1.0.0
 * @package     contrexx
 * @subpackage  module_jobs
 */
class jobsManager extends jobsLibrary
{
    /**
     * @var    \Cx\Core\Html\Sigma
     */
    public $_objTpl;
    public $pageTitle;
    public $pageContent;
    public $strErrMessage = '';
    public $strOkMessage = '';
    public $langId;

    private $act = '';

    /**
    * Constructor
    *
    * @param  string
    * @access public
    */
    function __construct()
    {
        global  $_ARRAYLANG, $objInit, $objTemplate;

        $this->pageTitle = $_ARRAYLANG["TXT_JOBS_MANAGER"];
        $this->_objTpl = new \Cx\Core\Html\Sigma(ASCMS_MODULE_PATH.'/jobs/template');
        CSRF::add_placeholder($this->_objTpl);
        $this->_objTpl->setErrorHandling(PEAR_ERROR_DIE);        
        $this->langId=$objInit->userFrontendLangId;
    }
    private function setNavigation()
    {
        global $objTemplate, $_ARRAYLANG;

        $objTemplate->setVariable(
            'CONTENT_NAVIGATION',
            '<a href="index.php?cmd=jobs" class="'.($this->act == '' ? 'active' : '').'">'.$_ARRAYLANG["TXT_JOBS_MENU_OVERVIEW"].'</a>'.
            '<a href="index.php?cmd=jobs&amp;act=add" class="'.($this->act == 'add' ? 'active' : '').'">'.$_ARRAYLANG["TXT_CREATE_DOCUMENT"].'</a>'.
            '<a href="index.php?cmd=jobs&amp;act=cat" class="'.($this->act == 'cat' ? 'active' : '').'">'.$_ARRAYLANG["TXT_CATEGORY_MANAGER"].'</a>'.
            '<a href="index.php?cmd=jobs&amp;act=loc" class="'.($this->act == 'loc' ? 'active' : '').'">'.$_ARRAYLANG["TXT_LOCATION_MANAGER"].'</a>'.
            '<a href="index.php?cmd=jobs&amp;act=settings" class="'.($this->act == 'settings' ? 'active' : '').'">'.$_ARRAYLANG["TXT_SETTINGS"].'</a>'
        );
    }


    /**
    * Do the requested action
    * @return    string    parsed content
    */
    function getJobsPage()
    {
        global $objTemplate;

        if (!isset($_GET['act'])) {
            $_GET['act']='';
        }

        switch($_GET['act']) {
            case 'add':
                $this->add();
                // $this->overview();
                break;
            case 'edit':
                $this->edit();
                break;
            case 'delete':
                $this->delete();
                $this->overview();
                break;
            case 'update':
                $this->update();
                $this->overview();
                break;
            case 'cat':
                $this->manageCategories();
                break;
            case 'loc':
                $this->manageLocations();
                break;
            case 'delcat':
                $this->deleteCat();
                $this->manageCategories();
                break;
            case 'delloc':
                $this->deleteLoc();
                $this->manageLocations();
                break;
            case 'changeStatus':
                $this->changeStatus();
                $this->overview();
                break;
            case 'settings':
                $this->settings();
                break;
            default:
                $this->overview();
        }
        $objTemplate->setVariable(array(
            'CONTENT_TITLE'          => $this->pageTitle,
            'CONTENT_OK_MESSAGE'     => $this->strOkMessage,
            'CONTENT_STATUS_MESSAGE' => $this->strErrMessage,
            'ADMIN_CONTENT'          => $this->_objTpl->get()
        ));

        $this->act = $_REQUEST['act'];
        $this->setNavigation();
    }


    /**
    * List the jobs
    * @global     object   $objDatabase
    * @param     integer   $newsid
    * @param     string    $what
    * @return    string    $output
    */
    function overview()
    {
        global $objDatabase, $_ARRAYLANG, $_CONFIG;

        // initialize variables
        $i=0;
        $jobslocationform = '';
        $location = '';
        $docFilter = '';
        $locationFilter = ' WHERE ';
        $this->pageTitle = $_ARRAYLANG['TXT_JOBS_MANAGER'];
        $this->_objTpl->loadTemplateFile('module_jobs_list.html',true,true);
        $this->_objTpl->setVariable(array(
            'TXT_EDIT_JOBS_MESSAGE'      => $_ARRAYLANG['TXT_EDIT_DOCUMENTS'],
            'TXT_EDIT_JOBS_ID'           => $_ARRAYLANG['TXT_DOCUMENT_ID'],
            'TXT_ARCHIVE'                => $_ARRAYLANG['TXT_ARCHIVE'],
            'TXT_DATE'                   => $_ARRAYLANG['TXT_DATE'],
            'TXT_TITLE'                  => $_ARRAYLANG['TXT_TITLE'],
            'TXT_USER'                   => $_ARRAYLANG['TXT_USER'],
            'TXT_LAST_EDIT'              => $_ARRAYLANG['TXT_LAST_EDIT'],
            'TXT_ACTION'                 => $_ARRAYLANG['TXT_ACTION'],
            'TXT_CATEGORY'               => $_ARRAYLANG['TXT_CATEGORY'],
            'TXT_CONFIRM_DELETE_DATA'    => $_ARRAYLANG['TXT_DOCUMENT_DELETE_CONFIRM'],
            'TXT_ACTION_IS_IRREVERSIBLE' => $_ARRAYLANG['TXT_ACTION_IS_IRREVERSIBLE'],
            'TXT_SELECT_ALL'             => $_ARRAYLANG['TXT_SELECT_ALL'],
            'TXT_REMOVE_SELECTION'       => $_ARRAYLANG['TXT_REMOVE_SELECTION'],
            'TXT_EDIT'                   => $_ARRAYLANG['TXT_EDIT'],
            'TXT_TEMPLATE'               => $_ARRAYLANG['TXT_TEMPLATE'],
            'TXT_MARKED'                 => $_ARRAYLANG['TXT_MARKED'],
            'TXT_ACTIVATE'               => $_ARRAYLANG['TXT_ACTIVATE'],
            'TXT_DEACTIVATE'             => $_ARRAYLANG['TXT_DEACTIVATE'],
            'TXT_STATUS'                 => $_ARRAYLANG['TXT_STATUS'],
            'TXT_AUTHOR'                 => $_ARRAYLANG['TXT_AUTHOR'],
            'TXT_JOBS_SEARCH'            => $_ARRAYLANG['TXT_JOBS_SEARCH']
        ));

        /* check if locations are activated */
        $query = "
            SELECT `value`
              FROM `".DBPREFIX."module_jobs_settings`
             WHERE name='show_location_fe'";
        $objResult = $objDatabase->Execute($query);

        //return if location fields are not activated in the backend
        if (!$objResult->EOF) {
            if (intval($objResult->fields['value']) == 1) {
                if (isset($_REQUEST['location']) &&
                        is_numeric($_REQUEST['location'])) {
                    $location = $_REQUEST['location'];
                    $locationFilter = ", `".DBPREFIX."module_jobs_rel_loc_jobs` AS rel WHERE rel.job = n.id AND rel.location = '".$location."' AND ";
                }
                $jobslocationform =
                    '<select name="location">'.
                    '<option selected="selected" value="">'.
                    $_ARRAYLANG['TXT_LOCATION'].'</option>'.
                    $this->getLocationMenu($location).
                    '</select>';
            }
        }
        if (isset($_REQUEST['category']) &&
                is_numeric($_REQUEST['category'])) {
            $category = $_REQUEST['category'];
            $docFilter = " n.catid='$category' AND ";
        }
        $jobscategoryform =
            '<select name="category">'.
            '<option selected="selected" value="">'.
            $_ARRAYLANG['TXT_CATEGORY'].'</option>'.
            $this->getCategoryMenu($this->langId, $category).
            '</select>';
        $this->_objTpl->setVariable(array(
            'JOBS_CATEGORY_FORM' => $jobscategoryform,
            'JOBS_LOCATION_FORM' => $jobslocationform,
            'TXT_SUBMIT' => $_ARRAYLANG['TXT_SUBMIT']
        ));
        $this->_objTpl->setGlobalVariable(array(
            'TXT_DELETE'    => $_ARRAYLANG['TXT_DELETE']
        ));
        $query = "SELECT n.id AS jobsId, n.date, n.changelog,
                         n.title, n.status, n.author,
                         l.name,
                         nc.name AS catname,
                         n.userid
                    FROM ".DBPREFIX."module_jobs_categories AS nc,
                         ".DBPREFIX."module_jobs AS n,
                         ".DBPREFIX."languages AS l
                         $locationFilter
                         n.lang=l.id
                     AND n.lang=$this->langId
                     AND $docFilter nc.catid=n.catid
                   ORDER BY n.id DESC";
        $objResult = $objDatabase->Execute($query);
        $count = $objResult->RecordCount();
        $pos = (isset($_GET['pos'])) ? intval($_GET['pos']) : 0;
        $paging = ($count>intval($_CONFIG['corePagingLimit'])) ? getPaging($count, $pos, "&cmd=jobs&location=".$location."&category=".$category."&", $_ARRAYLANG['TXT_DOCUMENTS '],true) : "";
        $objResult = $objDatabase->SelectLimit($query, $_CONFIG['corePagingLimit'],$pos);
        if (!$objResult || $objResult->EOF) {
            $this->_objTpl->hideBlock('row');
            return;
        }
        while ($objResult !== false && !$objResult->EOF) {
            $statusPicture = ($objResult->fields['status']==1) ? "status_green.gif" : "status_red.gif";
            $jobUser = \FWUser::getFWUserObject()->objUser->getUser($objResult->fields['userid']);
            $username = $_ARRAYLANG['TXT_ACCESS_UNKNOWN'];
            if ($jobUser) {
                $username = $jobUser->getUsername();
            }
            $this->_objTpl->setVariable(array(
                'JOBS_ID'         => $objResult->fields['jobsId'],
                'JOBS_DATE'       => date(ASCMS_DATE_FORMAT, $objResult->fields['date']),
                'JOBS_TITLE'      => stripslashes($objResult->fields['title']),
                'JOBS_AUTHOR'      => stripslashes($objResult->fields['author']),
                'JOBS_USER'       => $username,
                'JOBS_CHANGELOG'  => date(ASCMS_DATE_FORMAT, $objResult->fields['changelog']),
                'JOBS_PAGING'     => $paging,
                'JOBS_CLASS'      => (++$i % 2 ? "row2" : "row1"),
                'JOBS_CATEGORY'   => $objResult->fields['catname'],
                'JOBS_STATUS'     => $objResult->fields['status'],
                'JOBS_STATUS_PICTURE' => $statusPicture,
                'TXT_TEMPLATE'    => $_ARRAYLANG['TXT_TEMPLATE'],
                'TXT_EDIT'    => $_ARRAYLANG['TXT_EDIT'],
            ));
            $this->_objTpl->parse('row');
            $objResult->MoveNext();
        }
    }


    function _getSortingDropdown($catID, $sorting = 'alpha')
    {
        global $_ARRAYLANG;

        return '
            <select name="sortStyle['.$catID.']">
                <option value="alpha" '.($sorting == 'alpha' ? 'selected="selected"' : '').' >'.$_ARRAYLANG['TXT_JOBS_SORTING_ALPHA'].'</option>
                <option value="date" '.($sorting == 'date' ? 'selected="selected"' : '').'>'.$_ARRAYLANG['TXT_JOBS_SORTING_DATE'].'</option>
                <option value="date_alpha" '.($sorting == 'date_alpha' ? 'selected="selected"' : '').'>'.$_ARRAYLANG['TXT_JOBS_SORTING_DATE_ALPHA'].'</option>
            </select>
        ';
    }


    function getLocationTable($jobID)
    {
        global $objDatabase, $_ARRAYLANG;


        $query = "
            SELECT `value`
              FROM `".DBPREFIX."module_jobs_settings`
             WHERE name='show_location_fe'";
        $objResult = $objDatabase->Execute($query);
        //return if location fields are not activated in the backend
        if ($objResult && !$objResult->EOF) {
            if (intval($objResult->fields['value']) == 0) {
                $this->_objTpl->hideBlock('modify_location');
                return ;
            }
        }
        $AssociatedLocations = '';
        $notAssociatedLocations = '';
        $this->_objTpl->setVariable(array(
            'TXT_GENERAL'    => $_ARRAYLANG['TXT_JOBS_GENERAL'],
            'TXT_LOCATION'    => $_ARRAYLANG['TXT_LOCATION'],
            'TXT_AVAILABLE_LOCATIONS'    => $_ARRAYLANG['TXT_JOBS_AVAILABLE_LOCATIONS'],
            'TXT_ASSOCIATED_LOCATIONS'    => $_ARRAYLANG['TXT_JOBS_ASSOCIATED_LOCATIONS'],
            'TXT_CHECK_ALL' => $_ARRAYLANG['TXT_CHECK_ALL'],
            'TXT_UNCHECK_ALL' => $_ARRAYLANG['TXT_REMOVE_SELECTION'],
            'FORM_ONSUBMIT' => "onsubmit=\"SelectAllLocations(document.getElementById('associated_locations'))\"",
        ));
        if (empty($jobID)) {
            $query = "SELECT DISTINCT l.name as name,
                      l.id as id
                      FROM `".DBPREFIX."module_jobs_location` l
                      WHERE 1;";
        } else  {
            $query = "SELECT DISTINCT l.name as name,
                      l.id as id,
                      j.job as jobid ,
                      j.location as location
                      FROM `".DBPREFIX."module_jobs_location` l
                      LEFT JOIN `".DBPREFIX."module_jobs_rel_loc_jobs` as j on j.location=l.id
                      AND j.job = $jobID";
        }
        $objResult = $objDatabase->Execute($query);
        while($objResult!==false && !$objResult->EOF) {
            if (empty($jobID) or $objResult->fields['jobid'] != $jobID) {
                $notAssociatedLocations .= "<option value=\"".$objResult->fields['id']."\">".htmlentities($objResult->fields['name'], ENT_QUOTES, CONTREXX_CHARSET)."</option>\n";
            } else {
                $AssociatedLocations .= "<option value=\"".$objResult->fields['id']."\">".htmlentities($objResult->fields['name'], ENT_QUOTES, CONTREXX_CHARSET)."</option>\n";
            }
            $objResult->MoveNext();
        }
        $this->_objTpl->setVariable('ASSOCIATED_LOCATIONS',$AssociatedLocations);
        $this->_objTpl->setVariable('NOT_ASSOCIATED_LOCATIONS',$notAssociatedLocations);
    }


    /**
    * adds a job entry
    * @global     object    $objDatabase
    * @param     integer   $newsid -> the id of the news entry
    * @return    boolean   result
    */
    function add()
    {
        global $objDatabase, $_ARRAYLANG;

        JS::activate('jqueryui');

        $objFWUser = FWUser::getFWUserObject();
        $this->pageTitle = $_ARRAYLANG['TXT_CREATE_DOCUMENT'];
        $this->_objTpl->loadTemplateFile('module_jobs_modify.html',true,true);

        /*
         * if $_REQUEST['id'] is not empty handle it as a copy. unset id and time
         */
        if (!empty($_REQUEST['id'])) {
            $id = intval($_REQUEST['id']);
            $status = '';
            $startDate = '';
            $endDate = '';
            $catId = '';
            $this->_objTpl->setVariable(array(
                'TXT_JOBS_MESSAGE'  => $_ARRAYLANG['TXT_ADD_DOCUMENT'],
                'TXT_TITLE'           => $_ARRAYLANG['TXT_TITLE'],
                'TXT_CATEGORY'        => $_ARRAYLANG['TXT_CATEGORY'],
                'TXT_JOBS_SETTINGS'      => $_ARRAYLANG['TXT_JOBS_SETTINGS'],
                'TXT_LOCATION'        => $_ARRAYLANG['TXT_TXT_LOCATION'],
                'TXT_WORKLOC'         => $_ARRAYLANG['TXT_WORKLOC'],
                'TXT_WORKLOAD'        => $_ARRAYLANG['TXT_WORKLOAD'],
                'TXT_WORK_START'      => $_ARRAYLANG['TXT_WORK_START'],
                'TXT_JOBS_CONTENT'    => $_ARRAYLANG['TXT_CONTENT'],
                'TXT_STORE'           => $_ARRAYLANG['TXT_STORE'],
                'TXT_PUBLISHING'      => $_ARRAYLANG['TXT_PUBLISHING'],
                'TXT_STARTDATE'       => $_ARRAYLANG['TXT_STARTDATE'],
                'TXT_ENDDATE'         => $_ARRAYLANG['TXT_ENDDATE'],
                'TXT_OPTIONAL'        => $_ARRAYLANG['TXT_OPTIONAL'],
                'TXT_DATE'            => $_ARRAYLANG['TXT_DATE'],
                'TXT_ACTIVE'          => $_ARRAYLANG['TXT_ACTIVE'],
                'TXT_AUTHOR'          => $_ARRAYLANG['TXT_AUTHOR'],
                'TXT_JOBS_NO_CATEGORY'=> $_ARRAYLANG['TXT_JOBS_NO_CATEGORY'],
                'TXT_JOBS_NO_TITLE'   => $_ARRAYLANG['TXT_JOBS_NO_TITLE']
            ));
            $this->getLocationTable($id);
            $query = "SELECT `catid`,
                               `lang`,
                               `date`,
                               `id`,
                               `title`,
                               `author`,
                               `text`,
                               `workloc`,
                               `workload`,
                               `work_start`,
                               `startdate`,
                               `enddate`,
                               `status`
                          FROM `".DBPREFIX."module_jobs`
                         WHERE id = '$id'
                         LIMIT 1";
            $objResult = $objDatabase->Execute($query);
            if (!$objResult->EOF) {
                $jobsText = stripslashes($objResult->fields['text']);
                $catId = $objResult->fields['catid'];
                if ($objResult->fields['status']==1) {
                    $status = "checked";
                }
                if ($objResult->fields['startdate']!="0000-00-00 00:00:00") {
                    $startDate = $objResult->fields['startdate'];
                }
                if ($objResult->fields['enddate']!="0000-00-00 00:00:00") {
                    $endDate = $objResult->fields['enddate'];
                }
                $work_start = $objResult->fields['work_start'];
                if (!empty($objResult->fields['work_start'])) {
                    $work_start = date("Y-m-d", $objResult->fields['work_start']);
                }
                $this->_objTpl->setVariable(array(
                    'JOBS_ID'            => '',
                    'JOBS_STORED_ID'    => '',
                    'JOBS_TITLE'        => stripslashes(htmlspecialchars($objResult->fields['title'], ENT_QUOTES, CONTREXX_CHARSET)),
                    'JOBS_AUTHOR'        => stripslashes(htmlspecialchars($objResult->fields['author'], ENT_QUOTES, CONTREXX_CHARSET)),
                    'JOBS_TEXT'        => new \Cx\Core\Wysiwyg\Wysiwyg('jobsText', contrexx_raw2xhtml($jobsText), 'full'),
                    'JOBS_WORKLOC'        => $objResult->fields['workloc'],
                    'JOBS_WORKLOAD'        => $objResult->fields['workload'],
                    'JOBS_WORK_START'        => $work_start,
                    'JOBS_STARTDATE'    => $startDate,
                    'JOBS_ENDDATE'    => $endDate,
                    'JOBS_STATUS'        => $status,
                    'JOBS_DATE'       => date(ASCMS_DATE_FORMAT, $objResult->fields['date']),
                ));
            }

            $this->_objTpl->setVariable("JOBS_CAT_MENU",$this->getCategoryMenu($this->langId, $catId));
            $this->_objTpl->setVariable('TXT_JOBS_CATEGORY_SELECT',$_ARRAYLANG['TXT_JOBS_CATEGORY_SELECT']);
            $this->_objTpl->setVariable("JOBS_FORM_ACTION","add");
            $this->_objTpl->setVariable("JOBS_STORED_FORM_ACTION","add");
            $this->_objTpl->setVariable("JOBS_TOP_TITLE",$_ARRAYLANG['TXT_CREATE_DOCUMENT']);
        } else {
            $this->_objTpl->setVariable(array(
                'TXT_JOBS_MESSAGE'     => $_ARRAYLANG['TXT_ADD_DOCUMENT'],
                'TXT_TITLE'                => $_ARRAYLANG['TXT_TITLE'],
                'TXT_LOCATION'       => $_ARRAYLANG['TXT_TXT_LOCATION'],
                'TXT_CATEGORY'             => $_ARRAYLANG['TXT_CATEGORY'],
                'TXT_JOBS_SETTINGS'           => $_ARRAYLANG['TXT_JOBS_SETTINGS'],
                'TXT_WORKLOC'         => $_ARRAYLANG['TXT_WORKLOC'],
                'TXT_WORKLOAD'        => $_ARRAYLANG['TXT_WORKLOAD'],
                'TXT_WORK_START'      => $_ARRAYLANG['TXT_WORK_START'],
                'TXT_JOBS_CONTENT'     => $_ARRAYLANG['TXT_CONTENT'],
                'TXT_STORE'                => $_ARRAYLANG['TXT_STORE'],
                'TXT_PUBLISHING'           => $_ARRAYLANG['TXT_PUBLISHING'],
                'TXT_STARTDATE'            => $_ARRAYLANG['TXT_STARTDATE'],
                'TXT_ENDDATE'              => $_ARRAYLANG['TXT_ENDDATE'],
                'TXT_OPTIONAL'           => $_ARRAYLANG['TXT_OPTIONAL'],
                'TXT_ACTIVE'             => $_ARRAYLANG['TXT_ACTIVE'],
                'TXT_DATE'                 => $_ARRAYLANG['TXT_DATE'],
                'JOBS_TEXT'            => new \Cx\Core\Wysiwyg\Wysiwyg('jobsText', null, 'full'),
                'JOBS_FORM_ACTION'     => "add",
                'JOBS_STORED_FORM_ACTION' => "add",
                'JOBS_STATUS'          => ' checked="checked"',
                'JOBS_ID'              => "",
                'JOBS_TOP_TITLE'       => $_ARRAYLANG['TXT_CREATE_DOCUMENT'],
                'JOBS_CAT_MENU'        => $this->getCategoryMenu($this->langId),
                'TXT_JOBS_CATEGORY_SELECT'=> $_ARRAYLANG['TXT_JOBS_CATEGORY_SELECT'],
                'TXT_JOBS_NO_CATEGORY'=> $_ARRAYLANG['TXT_JOBS_NO_CATEGORY'],
                'TXT_JOBS_NO_TITLE'   => $_ARRAYLANG['TXT_JOBS_NO_TITLE'],
                'JOBS_STARTDATE'       => "",
                'JOBS_ENDDATE' => "",
                'JOBS_DATE'  => date(ASCMS_DATE_FORMAT, time()),
                'TXT_AUTHOR' => $_ARRAYLANG['TXT_AUTHOR'],
                'JOBS_AUTHOR' => htmlentities($objFWUser->objUser->getUsername(), ENT_QUOTES, CONTREXX_CHARSET),
            ));
            $this->getLocationTable('');

            if (!empty($_POST['jobsTitle'])) {
                $this->insert();
                $this->createRSS();
            }
        }
    }


    /**
    * Deletes a news entry
    *
    * @global     object    $objDatabase
    * @global     array     $_ARRAYLANG
    * @return    -
    */
    function delete()
    {
        global $objDatabase, $_ARRAYLANG;

        if (isset($_GET['id'])) {
            $jobsId = intval($_GET['id']);
            $query = "DELETE FROM ".DBPREFIX."module_jobs WHERE id = $jobsId";
            if ($objDatabase->Execute($query)) {
                $this->createRSS();
                $query = "DELETE FROM ".DBPREFIX."module_jobs_rel_loc_jobs WHERE job = $jobsId";
                if ($objDatabase->Execute($query)) {
                    $this->strOkMessage = $_ARRAYLANG['TXT_DATA_RECORD_DELETED_SUCCESSFUL'];
                } else {
                    $this->strErrMessage = $_ARRAYLANG['TXT_JOBS_LOCATION_NOT_DELETED'];
                }
            } else {
                $this->strErrMessage = $_ARRAYLANG['TXT_DATABASE_QUERY_ERROR'];
            }
        }

        if (is_array($_POST['selectedId'])) {
            foreach ($_POST['selectedId'] as $value) {
                if (!empty($value)) {
                    if ($objDatabase->Execute("DELETE FROM ".DBPREFIX."module_jobs WHERE id = ".intval($value))) {
                        $this->createRSS();
                        $query = "DELETE FROM ".DBPREFIX."module_jobs_rel_loc_jobs WHERE job = ".intval($value);
                        if ($objDatabase->Execute($query)) {
                            $this->strOkMessage = $_ARRAYLANG['TXT_DATA_RECORD_DELETED_SUCCESSFUL'];
                        } else {
                            $this->strErrMessage = $_ARRAYLANG['TXT_JOBS_LOCATION_NOT_DELETED'];
                        }
                    } else {
                        $this->strErrMessage = $_ARRAYLANG['TXT_DATABASE_QUERY_ERROR'];
                    }
                }
            }
        }
    }


    /**
     * Edit the news
     * @global    object     $objDatabase
     * @param     string     $pageContent
     */
    function edit($id='')
    {
        global $objDatabase, $_ARRAYLANG;

        JS::activate('jqueryui');

        if (empty($id)) {
            $id = intval($_REQUEST['id']);
        }
        $status = "";
        $startDate = "";
        $endDate = "";

        $this->pageTitle = $_ARRAYLANG['TXT_EDIT_DOCUMENTS'];
        $this->_objTpl->loadTemplateFile('module_jobs_modify.html',true,true);
        $this->_objTpl->setVariable(array(
            'TXT_JOBS_MESSAGE'  => $_ARRAYLANG['TXT_EDIT_DOCUMENTS'],
            'TXT_TITLE'           => $_ARRAYLANG['TXT_TITLE'],
            'TXT_CATEGORY'        => $_ARRAYLANG['TXT_CATEGORY'],
            'TXT_JOBS_SETTINGS'      => $_ARRAYLANG['TXT_JOBS_SETTINGS'],
            'TXT_JOBS_NO_CATEGORY'=> $_ARRAYLANG['TXT_JOBS_NO_CATEGORY'],
            'TXT_JOBS_NO_TITLE'   => $_ARRAYLANG['TXT_JOBS_NO_TITLE'],
            'TXT_LOCATION'       => $_ARRAYLANG['TXT_TXT_LOCATION'],
            'TXT_WORKLOC'         => $_ARRAYLANG['TXT_WORKLOC'],
            'TXT_WORKLOAD'        => $_ARRAYLANG['TXT_WORKLOAD'],
            'TXT_WORK_START'      => $_ARRAYLANG['TXT_WORK_START'],
            'TXT_JOBS_CONTENT'  => $_ARRAYLANG['TXT_CONTENT'],
            'TXT_STORE'           => $_ARRAYLANG['TXT_STORE'],
            'TXT_PUBLISHING'      => $_ARRAYLANG['TXT_PUBLISHING'],
            'TXT_STARTDATE'       => $_ARRAYLANG['TXT_STARTDATE'],
            'TXT_ENDDATE'         => $_ARRAYLANG['TXT_ENDDATE'],
            'TXT_OPTIONAL'        => $_ARRAYLANG['TXT_OPTIONAL'],
            'TXT_DATE'            => $_ARRAYLANG['TXT_DATE'],
            'TXT_ACTIVE'=> $_ARRAYLANG['TXT_ACTIVE'],
            'TXT_AUTHOR' => $_ARRAYLANG['TXT_AUTHOR'],
        ));

        $this->getLocationTable($id);
        $query = "
            SELECT `catid`, `lang`, `date`, `id`,
                   `title`, `author`, `text`,
                   `workloc`, `workload`, `work_start`,
                   `startdate`, `enddate`, `status`
              FROM `".DBPREFIX."module_jobs`
             WHERE id=$id";
        $objResult = $objDatabase->Execute($query);
        if (!$objResult || $objResult->EOF) {
            $id = 0;
        } else {
            $catId = $objResult->fields['catid'];
            $jobsText = stripslashes($objResult->fields['text']);
            if ($objResult->fields['status']==1) {
                $status = ' checked="checked"';
            }
            if ($objResult->fields['startdate'] != '0000-00-00 00:00:00') {
                $startDate = $objResult->fields['startdate'];
            }
            if ($objResult->fields['enddate'] != '0000-00-00 00:00:00') {
                $endDate = $objResult->fields['enddate'];
            }
            $work_start = $objResult->fields['work_start'];
            if (!empty($objResult->fields['work_start'])) {
                $work_start = date('Y-m-d', $objResult->fields['work_start']);
            }
            $this->_objTpl->setVariable(array(
                'JOBS_ID'            => $id,
                'JOBS_STORED_ID'    => $id,
                'JOBS_TITLE'        => stripslashes(htmlspecialchars($objResult->fields['title'], ENT_QUOTES, CONTREXX_CHARSET)),
                'JOBS_AUTHOR'        => stripslashes(htmlspecialchars($objResult->fields['author'], ENT_QUOTES, CONTREXX_CHARSET)),
                'JOBS_TEXT'        => new \Cx\Core\Wysiwyg\Wysiwyg('jobsText', contrexx_raw2xhtml($jobsText), 'full'),
                'JOBS_WORKLOC'        => $objResult->fields['workloc'],
                'JOBS_WORKLOAD'        => $objResult->fields['workload'],
                'JOBS_WORK_START'        => $work_start,
                'JOBS_STARTDATE'    => $startDate,
                'JOBS_ENDDATE'    => $endDate,
                'JOBS_STATUS'        => $status,
                'JOBS_DATE'       => date(ASCMS_DATE_FORMAT, $objResult->fields['date']),
            ));
        }
        $this->_objTpl->setVariable(array(
            'TXT_JOBS_CATEGORY_SELECT' => $_ARRAYLANG['TXT_JOBS_CATEGORY_SELECT'],
            'JOBS_CAT_MENU' => $this->getCategoryMenu($this->langId, $catId),
            'JOBS_FORM_ACTION' => ($id ? 'update' : 'add'),
            'JOBS_STORED_FORM_ACTION' => ($id ? 'update' : 'add'),
            'JOBS_TOP_TITLE' => $_ARRAYLANG['TXT_EDIT'],
        ));
    }


    /**
    * Update job
    * @global     object    $objDatabase
    * @return    boolean   result
    */
    function update()
    {
        global $objDatabase, $_ARRAYLANG;

        if (empty($_POST['id'])) {
            return true;
        }
        $objFWUser = FWUser::getFWUserObject();
        $id = intval($_POST['id']);
        $userId = $objFWUser->objUser->getId();
        $changelog = mktime();
        $title = get_magic_quotes_gpc() ? strip_tags($_POST['jobsTitle']) : addslashes(strip_tags($_POST['jobsTitle']));
        $text = get_magic_quotes_gpc() ? $_POST['jobsText'] : addslashes($_POST['jobsText']);
        $title= str_replace("ß","ss",$title);
        $text = $this->filterBodyTag($text);
        $text = str_replace("ß","ss",$text);
        $workloc    = get_magic_quotes_gpc() ? strip_tags($_POST['workloc']) : addslashes(strip_tags($_POST['workloc']));
        $workload = get_magic_quotes_gpc() ? strip_tags($_POST['workload']) : addslashes(strip_tags($_POST['workload']));
        if (empty($_POST['work_start']))
            $work_start = "0000-00-00";
        else
            $work_start = $_POST['work_start'];
        //start 'n' end
        $dateparts         = explode("-", $work_start);
        $work_start        = mktime(00, 00,00, $dateparts[1], $dateparts[2], $dateparts[0]);

        $catId = intval($_POST['jobsCat']);
        $status = (!empty($_POST['status'])) ? intval($_POST['status']) : 0;
        $startDate = get_magic_quotes_gpc() ? strip_tags($_POST['startDate']) : addslashes(strip_tags($_POST['startDate']));
        $endDate = get_magic_quotes_gpc() ? strip_tags($_POST['endDate']) : addslashes(strip_tags($_POST['endDate']));
        $author =  get_magic_quotes_gpc() ? strip_tags($_POST['author']) : addslashes(strip_tags($_POST['author']));

        $date = $this->_checkDate(date('H:i:s d.m.Y'));
        $dberr = false;
        $locset = '';                //set of location that is associated with this job in the POST Data
        $locset_indb = '';           //set of locations that is associated with this job in the db
        $rel_loc_jobs = '';     //used to generate INSERT Statement

        foreach($_POST['associated_locations'] as $value) {
            $locset[] = $value;
        }

        $query = "SELECT DISTINCT l.name as name,
                  l.id as id
                  FROM `".DBPREFIX."module_jobs_location` l
                  LEFT JOIN `".DBPREFIX."module_jobs_rel_loc_jobs` as j on j.location=l.id
                  WHERE j.job = $id";

        //Compare Post data and database
        $objResult = $objDatabase->Execute($query);
        if (!$objResult) {
            $dberr = true;
        }

        while(!$objResult->EOF && !$dberr) {
            if (in_array($objResult->fields['id'],$locset)) {
                $locset_indb[] = $objResult->fields['id'];
            } else {
                $query = "DELETE FROM `".DBPREFIX."module_jobs_rel_loc_jobs` WHERE job = ".$id." AND location = ".$objResult->fields['id'];
                if (!$objDatabase->Execute($query)) {
                    $dberr = true;
                }
            }
            $objResult->MoveNext();
        }
        unset($value);
        if (count($locset)-count($locset_indb) > 0  && !$dberr) {
            foreach($locset as $value) {
                if (!in_array($value,$locset_indb)) {
                    $rel_loc_jobs .= " ($id,$value),";
                }
            }
            $rel_loc_jobs = substr_replace($rel_loc_jobs ,"",-1);
            $query = "INSERT INTO `".DBPREFIX."module_jobs_rel_loc_jobs` (job,location) VALUES $rel_loc_jobs ";

            if (!$objDatabase->Execute($query)) {
                $dberr = true;
            }
        }
        $query = SQL::update('module_jobs', array(
            'date' => array('val' => $this->_checkDate($_POST['creation_date']), 'omitEmpty' => true),
            'title' => $title,
            'author' => $author,
            'text' => array('val' => $text, 'omitEmpty' => true),
            'workloc' => $workloc,
            'workload' => $workload,
            'work_start' => array('val' => $work_start, 'omitEmpty' => true),
            'catid' => array('val' => $cat, 'omitEmpty' => true),
            'lang' => array('val' => $this->langId, 'omitEmpty' => true),
            'startdate' => array('val' => $startDate, 'omitEmpty' => true),
            'enddate' => array('val' => $endDate, 'omitEmpty' => true),
            'status' => array('val' => $status, 'omitEmpty' => true),
            'userid' => array('val' => $userid, 'omitEmpty' => true),
            'changelog' => array('val' => $date, 'omitEmpty' => true),
            'catId' => array('val' => $catId, 'omitEmpty' => true),
        ))." WHERE id = $id;";
      
        if (!$objDatabase->Execute($query) or $dberr) {
            $this->strErrMessage = $_ARRAYLANG['TXT_DATABASE_QUERY_ERROR'];
        } else {
            $this->createRSS();
            $this->strOkMessage = $_ARRAYLANG['TXT_DATA_RECORD_UPDATED_SUCCESSFUL'];
        }
    }


    /**
    * Change job active status
    * @global    object    $objDatabase
    * @global    array     $_POST
    * @param     integer   $newsid
    * @return    boolean   result
    */
    function changeStatus()
    {
        global $objDatabase, $_ARRAYLANG;

        if (isset($_POST['deactivate'])) {
            $status = 0;
        }
        if (isset($_POST['activate'])) {
            $status = 1;
        }
        if (isset($status)) {
            if (is_array($_POST['selectedId'])) {
                foreach ($_POST['selectedId'] as $value) {
                    if (!empty($value)) {
                        $retval = $objDatabase->Execute("
                            UPDATE ".DBPREFIX."module_jobs
                               SET status='$status'
                             WHERE id=".intval($value));
                    }
                    if (!$retval) {
                        $this->strErrMessage = $_ARRAYLANG['TXT_DATABASE_QUERY_ERROR'];
                    } else{
                        $this->strOkMessage = $_ARRAYLANG['TXT_DATA_RECORD_UPDATED_SUCCESSFUL'];
                    }
                }
            }
        }
    }


    /**
    * change Settings
    * @global     object    $objDatabase
    * @return    boolean   result
    */
    function settings()
    {
        global $objDatabase, $_ARRAYLANG;

        $this->pageTitle = $_ARRAYLANG['TXT_SETTINGS'];
        $this->_objTpl->loadTemplateFile('module_jobs_settings.html',true,true);
        $this->_objTpl->setVariable(array(
            'TXT_SETTINGS' => $_ARRAYLANG['TXT_SETTINGS'],
            'TXT_FOOTNOTE' => $_ARRAYLANG['TXT_JOBS_FOOTNOTE'],
            'TXT_LINK' => $_ARRAYLANG['TXT_JOBS_LINK'],
            'TXT_URL' => $_ARRAYLANG['TXT_JOBS_URL'],
            'TXT_FOOTNOTE_HELP' => $_ARRAYLANG['TXT_JOBS_FOOTNOTE_HELP'],
            'TXT_LINK_HELP' => $_ARRAYLANG['TXT_JOBS_LINK_HELP'],
            'TXT_URL_HELP' => $_ARRAYLANG['TXT_JOBS_URL_HELP'],
            'TXT_SUBMIT' => $_ARRAYLANG['TXT_ACCEPT_CHANGES'],
            'TXT_URL_INFO' => $_ARRAYLANG['TXT_JOBS_URL_INFO'],
            'TXT_SHOW_LOCATION_FE' => $_ARRAYLANG['TXT_JOBS_SHOW_LOCATION_FE']
        ));

// Unused
//        $updaterrr = false;
        if ($_POST['updateFootnote'] == "true" && !(preg_match('/^[A-Za-z0-9\.\/%&=\?\-_:#@;]+$/i', $_POST['url']) or empty($_POST['url']))) {
            $this->strErrMessage = $_ARRAYLANG['TXT_JOBS_URL_ERROR'];
            $updateerr = true;
        }

        if ($_POST['updateFootnote'] == "true" && !$updateerr) {
            $footnote = addslashes($_POST['footnote']);
            $url = addslashes($_POST['url']);
            $link = addslashes($_POST['link']);
            $show_location_fe = intval($_POST['show_location_fe']);

            $query = "UPDATE `".DBPREFIX."module_jobs_settings` SET value='$footnote' WHERE name='footnote';";

            if (!$objDatabase->Execute($query)) {
                $updateerr = true;
            }
            $query = "UPDATE `".DBPREFIX."module_jobs_settings` SET value='$url' WHERE name='url';";
            if (!$objDatabase->Execute($query)) {
                $updateerr = true;
            }

            $query = "UPDATE `".DBPREFIX."module_jobs_settings` SET value='$link' WHERE name='link';";
            if (!$objDatabase->Execute($query)) {
                $updateerr = true;
            }

            $query = "UPDATE `".DBPREFIX."module_jobs_settings` SET value='$show_location_fe' WHERE name='show_location_fe';";

            if (!$objDatabase->Execute($query)) {
                $updateerr = true;
            }

            if (!$updateerr) {
                $this->strOkMessage = $_ARRAYLANG['TXT_DATA_RECORD_UPDATED_SUCCESSFUL'];
            } else {
                $this->strErrMessage = $_ARRAYLANG['TXT_DATABASE_QUERY_ERROR'];
            }
        }

        /*
        * just in case of a database or malformed URL Error, we put the POST Data back in the forms
        */
        if (isset($_POST['updateFootnote']) &&
                $_POST['updateFootnote'] == "true") {
            $footnote = $_POST['footnote'];
            $url = $_POST['url'];
            $link = $_POST['link'];
            $show_location_fe = (intval($_POST['show_location_fe']) == 1) ? "checked" : "";
        } else {
            $query = "SELECT *
                         FROM `".DBPREFIX."module_jobs_settings`
                         WHERE 1
                         ";
            $objResult = $objDatabase->Execute($query);
            $footnote = "";
            $link = "";
            $url = "";
            $show_location_fe = "";
            $dberr = ($objResult === false);
            while(!$objResult->EOF && !$dberr) {
                if ($objResult->fields['name']== "footnote") {
                    $footnote = stripslashes($objResult->fields['value']);
                }
                elseif ($objResult->fields['name']== "link") {
                    $link = stripslashes($objResult->fields['value']);
                }
                elseif ($objResult->fields['name']== "url") {
                    $url = stripslashes($objResult->fields['value']);
                }
                elseif ($objResult->fields['name']== "show_location_fe") {
                    if (intval($objResult->fields['value']) == 1)
                       $show_location_fe = " checked ";
                }
                $objResult->movenext();
            }
        }
        $this->_objTpl->setVariable(array(
            'FOOTNOTE'            => stripslashes($footnote),
            'LINK'                => stripslashes($link),
            'URL'                 => stripslashes($url),
            'SHOW_LOCATION_FE'    => $show_location_fe
        ));
        return true;
    }


    /**
     * checks if date is valid
     * @param string $date
     * @return integer $timestamp
     */
    function _checkDate($date)
    {
        $arrDate = array();
        if (preg_match('/^([0-9]{1,2})\:([0-9]{1,2})\:([0-9]{1,2})\s*([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{1,4})/', $date, $arrDate)) {
            return mktime(intval($arrDate[1]), intval($arrDate[2]), intval($arrDate[3]), intval($arrDate[5]), intval($arrDate[4]), intval($arrDate[6]));
        }
        return time();
    }


    /**
    * Insert news
    * @global     object    $objDatabase
    * @return    boolean   result
    */
    function insert()
    {
        global $objDatabase, $_ARRAYLANG;

        $objFWUser = FWUser::getFWUserObject();
// Unused
//        $noerror = true;
        $errorlist = "";
        $date = $this->_checkDate($_POST['creation_date']);
        $title = get_magic_quotes_gpc() ? strip_tags($_POST['jobsTitle']) : addslashes(strip_tags($_POST['jobsTitle']));
        $author = get_magic_quotes_gpc() ? strip_tags($_POST['author']) : addslashes(strip_tags($_POST['author']));
        $text = get_magic_quotes_gpc() ? $_POST['jobsText'] : addslashes($_POST['jobsText']);
        $title = str_replace("ß","ss",$title);
        $text = str_replace("ß","ss",$text);
        $text = $this->filterBodyTag($text);
        $workloc = get_magic_quotes_gpc() ? strip_tags($_POST['workloc']) : addslashes(strip_tags($_POST['workloc']));
        $workload = get_magic_quotes_gpc() ? strip_tags($_POST['workload']) : addslashes(strip_tags($_POST['workload']));
        if (empty($_POST['work_start']))
             $work_start = "0000-00-00";
        else
            $work_start = $_POST['work_start'];
        //start 'n' end
        $dateparts         = explode("-", $work_start);
        $work_start        = mktime(00, 00,00, $dateparts[1], $dateparts[2], $dateparts[0]);

        $cat = intval($_POST['jobsCat']);
        $userid = $objFWUser->objUser->getId();
        $startDate = get_magic_quotes_gpc() ? strip_tags($_POST['startDate']) : addslashes(strip_tags($_POST['startDate']));
        $endDate = get_magic_quotes_gpc() ? strip_tags($_POST['endDate']) : addslashes(strip_tags($_POST['endDate']));

        $status = intval($_POST['status']);

        if (empty($title) or empty($cat)) {
            $this->strErrMessage = $_ARRAYLANG['TXT_JOBS_ERROR'];
            $this->edit();
        }

        if ($status == 0) {
            $startDate = "";
            $endDate = "";
        }

        $query = SQL::insert('module_jobs', array(
            'date' => array('val' => $date, 'omitEmpty' => true),
            'title' => $title,
            'author' => $author,
            'text' => array('val' => $text, 'omitEmpty' => true),
            'workloc' => $workloc,
            'workload' => $workload,
            'work_start' => array('val' => $work_start, 'omitEmpty' => true),
            'catid' => array('val' => $cat, 'omitEmpty' => true),
            'lang' => array('val' => $this->langId, 'omitEmpty' => true),
            'startdate' => array('val' => $startDate, 'omitEmpty' => true),
            'enddate' => array('val' => $endDate, 'omitEmpty' => true),
            'status' => array('val' => $status, 'omitEmpty' => true),
            'userid' => array('val' => $userid, 'omitEmpty' => true),
            'changelog' => array('val' => $date, 'omitEmpty' => true),
        ));

        if ($objDatabase->Execute($query)) {
            $id = $objDatabase->Insert_id();
            $rel_loc_jobs = "";

            if (!isset($id)) {
                 $this->strErrMessage = $_ARRAYLANG['TXT_JOBS_LOCATIONS_NOT_ASSIGNED'];
                 $this->overview();
                 return;
            }
            if (isset($_POST['associated_locations'])) {
                foreach($_POST['associated_locations'] as $value) {
                    $rel_loc_jobs .= " ($id,$value),";
                }
                $rel_loc_jobs = substr_replace($rel_loc_jobs ,"",-1);
            } else {
                $this->strOkMessage = $_ARRAYLANG['TXT_DATA_RECORD_ADDED_SUCCESSFUL'];
                $this->overview();
                return;
            }

            $query = "INSERT INTO `".DBPREFIX."module_jobs_rel_loc_jobs` (job,location) VALUES $rel_loc_jobs ";
            if ($objDatabase->Execute($query))
            {
                $this->strOkMessage = $_ARRAYLANG['TXT_DATA_RECORD_ADDED_SUCCESSFUL'];
            } else {
                $this->strErrMessage = $_ARRAYLANG['TXT_JOBS_LOCATIONS_NOT_ASSIGNED'];
            }
        } else {
            $this->strErrMessage = $_ARRAYLANG['TXT_DATABASE_QUERY_ERROR'];
        }

        if (!empty($errorlist)) {
            $this->strErrMessage .= "<br />" .$errorlist;
        }

        if (!empty($this->strErrMessage)) {
            $this->edit($id);
        } else {
            $this->overview();
        }
    }


    /**
    * Add or edit the news categories
    * @global    object     $objDatabase
    * @global    array      $_ARRAYLANG
    * @param     string     $pageContent
    */
    function manageCategories()
    {
        global $objDatabase,$_ARRAYLANG;

        $this->pageTitle = $_ARRAYLANG['txtCategoryManager'];
        $this->_objTpl->loadTemplateFile('module_jobs_category.html',true,true);
        $this->_objTpl->setVariable(array(
            'TXT_ADD_NEW_CATEGORY'                       => $_ARRAYLANG['TXT_ADD_NEW_CATEGORY'],
            'TXT_NAME'                                   => $_ARRAYLANG['TXT_NAME'],
            'TXT_ADD'                                    => $_ARRAYLANG['TXT_ADD'],
            'TXT_CATEGORY_LIST'                          => $_ARRAYLANG['TXT_CATEGORY_LIST'],
            'TXT_ID'                                     => $_ARRAYLANG['TXT_ID'],
            'TXT_ACTION'                                 => $_ARRAYLANG['TXT_ACTION'],
            'TXT_ACCEPT_CHANGES'                         => $_ARRAYLANG['TXT_ACCEPT_CHANGES'],
            'TXT_CONFIRM_DELETE_DATA'                    => $_ARRAYLANG['TXT_CONFIRM_DELETE_DATA'],
            'TXT_ACTION_IS_IRREVERSIBLE'                 => $_ARRAYLANG['TXT_ACTION_IS_IRREVERSIBLE'],
            'TXT_ATTENTION_SYSTEM_FUNCTIONALITY_AT_RISK' => $_ARRAYLANG['TXT_ATTENTION_SYSTEM_FUNCTIONALITY_AT_RISK'],
            'TXT_JOBS_SORTING'                          => $_ARRAYLANG['TXT_JOBS_SORTING'],
            'TXT_JOBS_SORTTYPE'                          => $_ARRAYLANG['TXT_JOBS_SORTTYPE'],
        ));
        $this->_objTpl->setGlobalVariable(array(
            'TXT_DELETE'    => $_ARRAYLANG['TXT_DELETE']
        ));

        // Add a new category
        if (isset($_POST['addCat']) AND ($_POST['addCat']==true)) {
             $catName = get_magic_quotes_gpc() ? strip_tags($_POST['newCatName']) : addslashes(strip_tags($_POST['newCatName']));
             if ($objDatabase->Execute("INSERT INTO ".DBPREFIX."module_jobs_categories (name,lang)
                                 VALUES ('$catName','$this->langId')")) {
                 $this->strOkMessage = $_ARRAYLANG['TXT_DATA_RECORD_ADDED_SUCCESSFUL'];
             } else {
                 $this->strErrMessage = $_ARRAYLANG['TXT_DATABASE_QUERY_ERROR'];
             }
        }

        // Modify a new category
        if (isset($_POST['modCat']) AND ($_POST['modCat']==true)) {
            foreach ($_POST['catName'] as $id => $name) {
                $name = get_magic_quotes_gpc() ? strip_tags($name) : addslashes(strip_tags($name));
                $id=intval($id);

                $sorting = !empty($_REQUEST['sortStyle'][$id]) ? contrexx_addslashes($_REQUEST['sortStyle'][$id]) : 'alpha';

                if ($objDatabase->Execute("UPDATE ".DBPREFIX."module_jobs_categories
                                  SET name='$name',
                                      lang='$this->langId',
                                      sort_style='$sorting'
                                WHERE catid=$id"))
                {
                    $this->strOkMessage = $_ARRAYLANG['TXT_DATA_RECORD_UPDATED_SUCCESSFUL'];
                } else {
                    $this->strErrMessage = $_ARRAYLANG['TXT_DATABASE_QUERY_ERROR'];
                }
            }
        }

        $query = "SELECT `catid`,
                           `name`,
                           `sort_style`
                      FROM `".DBPREFIX."module_jobs_categories`
                     WHERE `lang`='$this->langId'
                  ORDER BY `catid` asc";
        $objResult = $objDatabase->Execute($query);

        $this->_objTpl->setCurrentBlock('row');
        $i=0;

        while ($objResult !== false && !$objResult->EOF) {
            $class = (($i % 2) == 0) ? "row1" : "row2";
            $sorting = $objResult->fields['sort_style'];
            $this->_objTpl->setVariable(array(
                'JOBS_ROWCLASS'   => $class,
                'JOBS_CAT_ID'      => $objResult->fields['catid'],
                'JOBS_CAT_NAME'      => stripslashes($objResult->fields['name']),
                'JOBS_SORTING_DROPDOWN'    => $this->_getSortingDropdown($objResult->fields['catid'], $sorting),
            ));
            $this->_objTpl->parseCurrentBlock('row');
            $i++;
            $objResult->MoveNext();
        };
    }


    /**
    * Delete the news categories
    * @global    object     $objDatabase
    * @global    array      $_ARRAYLANG[news*]
    * @param     string     $pageContent
    */
    function deleteCat()
    {
        global $objDatabase,$_ARRAYLANG;

        if (isset($_GET['catId'])) {
            $catId=intval($_GET['catId']);
            $objResult = $objDatabase->Execute("SELECT id FROM ".DBPREFIX."module_jobs WHERE catid=$catId");

            if (!$objResult->EOF) {
                 $this->strErrMessage = $_ARRAYLANG['TXT_CATEGORY_NOT_DELETED_BECAUSE_IN_USE'];
            } else {
                if ($objDatabase->Execute("DELETE FROM ".DBPREFIX."module_jobs_categories WHERE catid=$catId")) {
                    $this->strOkMessage = $_ARRAYLANG['TXT_DATA_RECORD_DELETED_SUCCESSFUL'];
                } else {
                    $this->strErrMessage = $_ARRAYLANG['TXT_DATABASE_QUERY_ERROR'];
                }
            }
        }
    }


    /**
    * Add or edit the jobs Locations
    * @global    object     $objDatabase
    * @global    array      $_ARRAYLANG
    * @param     string     $pageContent
    */
    function manageLocations()
    {
        global $objDatabase,$_ARRAYLANG;

        $this->pageTitle = $_ARRAYLANG['TXT_LOCATION_MANAGER'];
        $this->_objTpl->loadTemplateFile('module_jobs_location.html',true,true);
        $this->_objTpl->setVariable(array(
            'TXT_ADD_NEW_LOCATION'                       => $_ARRAYLANG['TXT_ADD_NEW_LOCATION'],
            'TXT_NAME'                                   => $_ARRAYLANG['TXT_NAME'],
            'TXT_ADD'                                    => $_ARRAYLANG['TXT_ADD'],
            'TXT_SELECT_ALL'                             => $_ARRAYLANG['TXT_SELECT_ALL'],
            'TXT_REMOVE_SELECTION'                       => $_ARRAYLANG['TXT_REMOVE_SELECTION'],
            'TXT_LOCATION_LIST'                          => $_ARRAYLANG['TXT_LOCATION_LIST'],
            'TXT_ID'                                     => $_ARRAYLANG['TXT_ID'],
            'TXT_ACTION'                                 => $_ARRAYLANG['TXT_ACTION'],
            'TXT_ACCEPT_CHANGES'                         => $_ARRAYLANG['TXT_ACCEPT_CHANGES'],
            'TXT_CONFIRM_DELETE_DATA'                    => $_ARRAYLANG['TXT_CONFIRM_DELETE_DATA'],
            'TXT_ACTION_IS_IRREVERSIBLE'                 => $_ARRAYLANG['TXT_ACTION_IS_IRREVERSIBLE'],
            'TXT_ATTENTION_SYSTEM_FUNCTIONALITY_AT_RISK' => $_ARRAYLANG['TXT_ATTENTION_SYSTEM_FUNCTIONALITY_AT_RISK'],
            'TXT_JOBS_SORTING'                           => $_ARRAYLANG['TXT_JOBS_SORTING'],
            'TXT_JOBS_SORTTYPE'                          => $_ARRAYLANG['TXT_JOBS_SORTTYPE'],
        ));
        $this->_objTpl->setGlobalVariable(array(
            'TXT_DELETE'    => $_ARRAYLANG['TXT_DELETE']
        ));

        // Add a new category
        if (isset($_POST['addLoc']) AND ($_POST['addLoc']==true)) {
             $locName = get_magic_quotes_gpc() ? strip_tags($_POST['newLocName']) : addslashes(strip_tags($_POST['newLocName']));
             if ($objDatabase->Execute("INSERT INTO ".DBPREFIX."module_jobs_location (name)
                                 VALUES ('$locName')")) {
                 $this->strOkMessage = $_ARRAYLANG['TXT_DATA_RECORD_ADDED_SUCCESSFUL'];
             } else {
                 $this->strErrMessage = $_ARRAYLANG['TXT_DATABASE_QUERY_ERROR'];
             }
        }

        // Modify a new category
        if (isset($_POST['modLoc']) AND ($_POST['modLoc']==true)) {
            foreach ($_POST['locName'] as $id => $name) {
                $name = get_magic_quotes_gpc() ? strip_tags($name) : addslashes(strip_tags($name));
                $id=intval($id);

// Unused
//                $sorting = !empty($_REQUEST['sortStyle'][$id]) ? contrexx_addslashes($_REQUEST['sortStyle'][$id]) : 'alpha';
                if ($objDatabase->Execute("UPDATE ".DBPREFIX."module_jobs_location
                                  SET name='$name'
                                WHERE id=$id"))
                {
                    $this->strOkMessage = $_ARRAYLANG['TXT_DATA_RECORD_UPDATED_SUCCESSFUL'];
                } else {
                    $this->strErrMessage = $_ARRAYLANG['TXT_DATABASE_QUERY_ERROR'];
                }
            }
        }

        $query = "SELECT `id`,
                           `name`
                      FROM `".DBPREFIX."module_jobs_location`
                  ORDER BY `id` asc";
        $objResult = $objDatabase->Execute($query);

        $this->_objTpl->setCurrentBlock('row');
        $i=0;

        while ($objResult !== false && !$objResult->EOF) {
            $class = (($i % 2) == 0) ? "row1" : "row2";
// Unused
//            $sorting = $objResult->fields['sort_style'];
            $this->_objTpl->setVariable(array(
                'JOBS_ROWCLASS'   => $class,
                'JOBS_LOC_ID'      => $objResult->fields['id'],
                'JOBS_LOC_NAME'      => stripslashes($objResult->fields['name']),
            ));
            $this->_objTpl->parseCurrentBlock('row');
            $i++;
            $objResult->MoveNext();
        };
    }



    /**
    * Delete the jobs locations
    * @global    object     $objDatabase
    * @global    array      $_ARRAYLANG[news*]
    * @param     string     $pageContent
    */
    function deleteLoc() {
        global $objDatabase,$_ARRAYLANG;

        if (isset($_GET['locId'])) {
            $locId=intval($_GET['locId']);

            if ($objDatabase->Execute("DELETE FROM ".DBPREFIX."module_jobs_rel_loc_jobs WHERE location=$locId") && $objDatabase->Execute("DELETE FROM ".DBPREFIX."module_jobs_location WHERE id=$locId")) {
                $this->strOkMessage = $_ARRAYLANG['TXT_DATA_RECORD_DELETED_SUCCESSFUL'];
            } else {
                $this->strErrMessage .= $_ARRAYLANG['TXT_DATABASE_QUERY_ERROR']."<br />";
            }

        }
        unset($locId);
        if (is_array($_POST['selectedId'])) {
            foreach ($_POST['selectedId'] as $value) {
                $locId=intval($value);

                if ($objDatabase->Execute("DELETE FROM ".DBPREFIX."module_jobs_rel_loc_jobs WHERE location=$locId") && $objDatabase->Execute("DELETE FROM ".DBPREFIX."module_jobs_location WHERE id=$locId")) {
                    $this->strOkMessage = $_ARRAYLANG['TXT_DATA_RECORD_DELETED_SUCCESSFUL'];
                } else {
                    $this->strErrMessage .= $_ARRAYLANG['TXT_DATABASE_QUERY_ERROR']."<br />";
                }
            }
        }
    }


    /**
    * Gets only the body content and deleted all the other tags
    * @param     string     $fullContent      HTML-Content with more than BODY
    * @return    string     $content          HTML-Content between BODY-Tag
    */
    function filterBodyTag($fullContent)
    {
        if (empty($fullContent)) {
            return $fullContent;
        }
        $posBody = 0;
        $posStartBodyContent = 0;
        $arrayMatches = array();
        $res = preg_match_all('/<body[^>]*>/i', $fullContent, $arrayMatches);
        if ($res) {
            $bodyStartTag = $arrayMatches[0][0];
            // Position des Start-Tags holen
            $posBody = strpos($fullContent, $bodyStartTag, 0);
            // Beginn des Contents ohne Body-Tag berechnen
            $posStartBodyContent = $posBody + strlen($bodyStartTag);
        }
        $posEndTag=strlen($fullContent);
        $res=preg_match_all('/<\/body>/i', $fullContent, $arrayMatches);
        if ($res) {
            $bodyEndTag=$arrayMatches[0][0];
            // Position des End-Tags holen
            $posEndTag = strpos($fullContent, $bodyEndTag, 0);
            // Content innerhalb der Body-Tags auslesen
         }
         $content = substr($fullContent, $posStartBodyContent, $posEndTag  - $posStartBodyContent);
         return $content;
    }


    /**
    * Create the RSS-Feed
    */
    function createRSS()
    {
        \Env::get('ClassLoader')->loadFile(ASCMS_MODULE_PATH.'/jobs/xmlfeed.class.php');
        $rssFeed = new rssFeed();
        $rssFeed->channelTitle = "Jobsystem";
        $rssFeed->channelDescription = "";
        $rssFeed->xmlType = "headlines";
        $rssFeed->createXML();
        $rssFeed->xmlType = "fulltext";
        $rssFeed->createXML();
    }

}

?>
