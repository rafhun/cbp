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
 * Jobs
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
 * Jobs
 * This module will get all the jobs pages
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Comvation Development Team <info@comvation.com>
 * @access      public
 * @version     1.0.0
 * @package     contrexx
 * @subpackage  module_jobs
 */
class jobs extends jobsLibrary
{
    var $jobsTitle;
    var $langId;
    var $dateFormat = 'd.m.Y';
    var $dateLongFormat = 'H:i:s d.m.Y';
    var $_objTpl;


    function jobs($pageContent)
    {
        $this->__construct($pageContent);
    }


    // CONSTRUCTOR
    function __construct($pageContent)
    {
        global $_LANGID;
        $this->pageContent = $pageContent;
        $this->_objTpl = new \Cx\Core\Html\Sigma('.');
        CSRF::add_placeholder($this->_objTpl);
        $this->_objTpl->setErrorHandling(PEAR_ERROR_DIE);
        $this->langId = $_LANGID;
    }



    // GET PAGE
    function getjobsPage()
    {
        if (!isset($_REQUEST['cmd'])) {
            $_REQUEST['cmd'] = '';
        }

        switch( $_REQUEST['cmd']) {
            case 'details':
                return $this->getDetails();
                break;
            default:
                return $this->getTitles();
                break;
        }
    }



    /**
    * Gets the news details
    *
    * @global     array     $_CONFIG
    * @global     array     $_ARRAYLANG
    * @global     object    $objDatabase
    * @return    string    parsed content
    */
    function getDetails()
    {
        global $_CONFIG, $objDatabase, $_ARRAYLANG;

        $this->_objTpl->setTemplate($this->pageContent);

        $id = intval($_GET['id']);


        /**
        *
        * First get Settings and build footnote
        *
        */

        $footnotetext = "";
        $footnotelink = "";
    	$footnote = "";
        $link = "";
        $url = "";

        if($id > 0) {
	        $query = "SELECT *
	                     FROM `".DBPREFIX."module_jobs_settings`
	                     WHERE name = 'footnote'
	                     OR name = 'link'
	                     OR name = 'url'
	                     ";
	        $objResult = $objDatabase->Execute($query);

	        while(!$objResult->EOF) {

	            if($objResult->fields['name']== "footnote") {
	                $footnote = stripslashes($objResult->fields['value']);
	            }
	            elseif($objResult->fields['name']== "link") {
	                $link = stripslashes($objResult->fields['value']);
	            }
	            elseif($objResult->fields['name']== "url") {
	                $url = stripslashes($objResult->fields['value']);
	            }
	            $objResult->movenext();
	        }

        }




        $this->_objTpl->setVariable(array(
            'TXT_JOBS_AUTOR' => $_ARRAYLANG['TXT_JOBS_AUTOR'],
            'TXT_JOBS_WORKLOC' => $_ARRAYLANG['TXT_JOBS_WORKLOC'],
            'TXT_JOBS_WORK_START' => $_ARRAYLANG['TXT_JOBS_WORK_START'],
            'TXT_JOBS_WORKLOAD' => $_ARRAYLANG['TXT_JOBS_WORKLOAD'],
            'TXT_JOBS_PUBLISHED_AT'  => $_ARRAYLANG['TXT_JOBS_PUBLISHED_AT']
            ));

        if ($id > 0) {
            $query = "SELECT id,
                               workloc,
                               changelog,
                               workload,
                               work_start,
                               text,
                               date,
                               changelog,
                               title,
                               author
                          FROM ".DBPREFIX."module_jobs
                         WHERE status = 1
                           AND id = $id
                           AND lang=".$this->langId."
                           AND (startdate<='".date('Y-m-d')."' OR startdate='0000-00-00 00:00:00')
                           AND (enddate>='".date('Y-m-d')."' OR enddate='0000-00-00 00:00:00')";
            $objResult = $objDatabase->SelectLimit($query, 1);

            while(!$objResult->EOF) {
                $lastUpdate    = stripslashes($objResult->fields['changelog']);
                $date = stripslashes($objResult->fields['date']);
                $workloc    = stripslashes($objResult->fields['workloc']);
                $workload = stripslashes($objResult->fields['workload']);
                $work_start = stripslashes($objResult->fields['work_start']);

                if(empty($work_start) or time() >= $work_start ) {
                    $work_start = $_ARRAYLANG['TXT_JOBS_WORK_START_NOW'];
                } else {
                    $work_start = date("d.m.Y", $work_start);
                }

                $docLastUpdate = "";

                if (!empty($lastUpdate) AND $lastUpdate!=$date ){
                    $this->_objTpl->setVariable(array(
                        'TXT_JOBS_LASTUPDATE' => $_ARRAYLANG['TXT_JOBS_LASTUPDATE'],
                        'JOBS_LASTUPDATE' => date(ASCMS_DATE_FORMAT,$lastUpdate),
                    ));

                }

                $title = stripslashes($objResult->fields['title']);

		        /*
		        * Replace self defined placeholders in $url
		        */
		        if(!empty($footnote)) {
					$footnotetext = nl2br($footnote);
		        }

		        if(!empty($link)) {
			        $url = str_replace("%URL%",urlencode($_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']),$url);
			        $url = htmlspecialchars(str_replace("%TITLE%",urlencode(stripslashes($title)),$url), ENT_QUOTES, CONTREXX_CHARSET);
			        $footnotelink = "<a href='$url'>$link</a>";
		        }


                $this->_objTpl->setVariable(array(
                    'JOBS_DATE' => date(ASCMS_DATE_FORMAT,$date),
                    'JOBS_TITLE'=> stripslashes($title),
                    'JOBS_AUTHOR'    => stripslashes($objResult->fields['author']),
                    'JOBS_TEXT' => stripslashes($objResult->fields['text']),
                    'JOBS_FOOTNOTE' => $footnotetext,
                    'JOBS_FOOTNOTE_LINK' => $footnotelink,
                    'JOBS_WORKLOC' => $workloc,
                    'JOBS_WORKLOAD'=> $workload,
                    'JOBS_WORK_START' => $work_start));
                $objResult->MoveNext();
            }
        } else {
            CSRF::header("Location: index.php?section=jobs");
            exit;
        }

        $this->jobsTitle = strip_tags(stripslashes($title));
        return $this->_objTpl->get();
    }





    /**
    * Gets the global page title
    *
    * @param     string       (optional)$pageTitle
    */
    function getPageTitle($pageTitle="")
    {
        if(empty($this->jobsTitle)){
            $this->jobsTitle = $pageTitle;
        }
    }





    /**
    * Gets the list with the headlines
    *
    * @global     object    $objDatabase
    * @return    string    parsed content
    */

    function getTitles()
    {
        global $_CONFIG, $objDatabase, $_ARRAYLANG;

        $selectedId = "";
        $location = "";
        $docFilter = "";
        $locationFilter = " WHERE ";
        $paging = "";
        $pos = intval($_GET['pos']);
        $i = 1;
        $class  = 'row1';
        $jobscategoryform = "";
        $jobslocationform = "";
        $category = null;

        $this->_objTpl->setTemplate($this->pageContent);

        if(isset($_REQUEST['catid'])) {
            $category = intval($_REQUEST['catid']);
        }
        /**
         * This overwrites $_REQUEST['catid'] but it shouldnt be set parallel anyway
         */
        if(isset($_REQUEST['cmd']) && is_numeric($_REQUEST['cmd'])) {
        	$category = $_REQUEST['cmd'];
        }


        if(!empty($category)){
            $selectedId= intval($category);
            $query = " SELECT `sort_style` FROM `".DBPREFIX."module_jobs_categories`
                        WHERE `catid` = ".$selectedId;
            $objRS = $objDatabase->SelectLimit($query, 1);
            if($objRS !== false){
                $sortType = $objRS->fields['sort_style'];
            }else{
                die('database error. '.$objDatabase->ErrorMsg());
            }
            $docFilter =" n.catid='$selectedId' AND ";
        }



        $objRS = $objDatabase->Execute("SELECT id,value FROM `".DBPREFIX."module_jobs_settings` WHERE name = 'show_location_fe'");
        if($objRS !== false ) {
            if(intval($objRS->fields['value']) == 1) {
                if(!empty($_REQUEST['locid'])) {
                    $location = intval($_REQUEST['locid']);
                    $locationFilter = ", `".DBPREFIX."module_jobs_rel_loc_jobs` AS rel WHERE  rel.job = n.id AND rel.location = '".$location."' AND ";
                }

                $jobslocationform ="
    <select name=\"locid\" onchange=\"javascript:this.form.submit();\">
    <option selected=\"selected\" value=''>".$_ARRAYLANG['TXT_JOBS_LOCATION_ALL']."</option>
    ".$this->getLocationMenu($location)."
    </select>";
            }
        }





        $jobscategoryform ="
    <select name=\"catid\" onchange=\"javascript:this.form.submit();\">
    <option selected=\"selected\" value=''>".$_ARRAYLANG['TXT_CATEGORY_ALL']."</option>
    ".$this->getCategoryMenu($this->langId, $selectedId)."
    </select>";

        $this->_objTpl->setVariable("JOBS_CATEGORY_FORM",$jobscategoryform );
        $this->_objTpl->setVariable("JOBS_LOCATION_FORM",$jobslocationform );
        $this->_objTpl->setVariable("TXT_PERFORM", $_ARRAYLANG['TXT_PERFORM']);

        $query = "SELECT n.date AS date,
                         n.id AS docid,
                         n.title AS title,
                         n.workload AS workload,
                         n.author AS author,
                         nc.name AS name
                    FROM ".DBPREFIX."module_jobs AS n,
                         ".DBPREFIX."module_jobs_categories AS nc
                         ". $locationFilter."
                     status = 1
                     AND n.lang=".$this->langId."
                     AND $docFilter n.catid=nc.catid
                     AND (startdate<='".date('Y-m-d')."' OR startdate='0000-00-00 00:00:00')
                     AND (enddate>='".date('Y-m-d')."' OR enddate='0000-00-00 00:00:00') ";

       if(!empty($docFilter)){
            switch($sortType){
                case 'alpha':
                    $query .= " ORDER BY `title`";
                break;

                case 'date':
                    $query .= " ORDER BY `date` DESC";
                break;

                case 'date_alpha':
                    $query .= " ORDER BY DATE_FORMAT( FROM_UNIXTIME( `date` ) , '%Y%j' ) DESC, `title`";
                break;

                default:
                    $query .= " ORDER BY n.date DESC";
            }
        }else{
            $query .= " ORDER BY n.date DESC";
        }



        /* Fill table header */
        $this->_objTpl->setVariable(array(
            'JOBS_ID_TXT'       => $_ARRAYLANG['TXT_JOBS_ID'],
            'JOBS_LINK_TXT'       => $_ARRAYLANG['TXT_JOBS_NAME'],
            'JOBS_WORKLOAD_TXT'       => $_ARRAYLANG['TXT_JOBS_WORKLOAD']
        ));

        /***start paging ****/

        $objResult = $objDatabase->Execute($query);
        $count = $objResult->RecordCount();
        if ($count > intval($_CONFIG['corePagingLimit'])) {
            $paging = getPaging($count, $pos, "&section=jobs&catid=".$selectedId."&locid=".$location, $_ARRAYLANG['TXT_DOCUMENTS'], true);
        }
        $this->_objTpl->setVariable("JOBS_PAGING", $paging);
        $objResult = $objDatabase->SelectLimit($query, $_CONFIG['corePagingLimit'], $pos) ;
        /*** end paging ***/

        if($count>=1){
            while (!$objResult->EOF) {
                ($i % 2) ? $class  = 'row1' : $class  = 'row2';

                $this->_objTpl->setVariable(array(
                    'JOBS_STYLE'      => $class,
                    'JOBS_ID'			=> $objResult->fields['docid'],
                    'JOBS_LONG_DATE'  => date($this->dateLongFormat,$objResult->fields['date']),
                    'JOBS_DATE'       => date($this->dateFormat,$objResult->fields['date']),
                    'JOBS_LINK'       => "<a href=\"?section=jobs&amp;cmd=details&amp;id=".$objResult->fields['docid']."\" title=\"".stripslashes($objResult->fields['title'])."\">".stripslashes($objResult->fields['title'])."</a>",
                    'JOBS_AUTHOR'       => stripslashes($objResult->fields['author']),
                    'JOBS_WORKLOAD' => stripslashes($objResult->fields['workload'])
                ));

                $this->_objTpl->parse("row");
                $i++;
                $objResult->MoveNext();

        }
        }else{
            $this->_objTpl->setVariable('TXT_NO_DOCUMENTS_FOUND',$_ARRAYLANG['TXT_NO_DOCUMENTS_FOUND']);
            $this->_objTpl->parse("alternate_row");
            $this->_objTpl->hideblock("row");
        }
        return $this->_objTpl->get();
    }
}
?>
