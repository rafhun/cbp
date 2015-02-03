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
 * Calendar Class Host Manager
 * 
 * @package    contrexx
 * @subpackage module_calendar
 * @author     Comvation <info@comvation.com>
 * @copyright  CONTREXX CMS - COMVATION AG
 * @version    1.00
 */
class CalendarCategory extends CalendarLibrary
{
    /**
     * category id
     * 
     * @access public
     * @var integer
     */
    public $id;
    
    /**
     * category name
     *
     * @access public
     * @var string
     */
    public $name;
    
    /**
     * position
     *
     * @access public
     * @var integer
     */
    public $pos;
    
    /**
     * status
     *
     * @access public
     * @var boolean
     */
    public $status;
    
    /**
     * Category data
     *
     * @access public
     * @var array
     * @see getData();
     */
    public $arrData = array();
    
    /**
     * category manager constructor
     * 
     * Loads the category by given id
     * 
     * @param integer $id category id     
     */
    function __construct($id=null){
        if($id != null) {
            self::get($id);
        }
    }
    
    /**
     * Loads the catgory
     *      
     * @param integer $catId
     * 
     * @return null
     */
    function get($catId) {
        global $objDatabase, $_LANGID;
        
        $query = "SELECT category.`id` AS `id`, 
                         category.`pos` AS `pos`, 
                         category.`status` AS `status`, 
                         name.`name` AS `name`
                    FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_category AS category,
                         ".DBPREFIX."module_".$this->moduleTablePrefix."_category_name AS name
                   WHERE category.id = '".intval($catId)."'
                     AND category.id = name.cat_id
                     AND name.lang_id = '".intval($_LANGID)."'
                   LIMIT 1";
        
        $objResult = $objDatabase->Execute($query);
        
        if ($objResult !== false) {
        	$this->id = intval($catId);
	        $this->name = $objResult->fields['name'];
	        $this->pos = intval($objResult->fields['pos']);
	        $this->status = intval($objResult->fields['status']);
        }
    }
    
    /**
     * Loads the category data
     * 
     * @return null
     */
    function getData() {
        global $objDatabase, $_LANGID;
        
        //get category name(s)
        $query = "SELECT `name`,`lang_id` 
                    FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_category_name
                   WHERE cat_id = '".intval($this->id)."'";
        
        $objResult = $objDatabase->Execute($query);
        
        if ($objResult !== false) {
            while (!$objResult->EOF) {
            	if($objResult->fields['lang_id'] == $_LANGID) {
            		$this->arrData['name'][0] = htmlentities($objResult->fields['name'], ENT_QUOTES, CONTREXX_CHARSET);
            	}
                $this->arrData['name'][intval($objResult->fields['lang_id'])] = htmlentities($objResult->fields['name'], ENT_QUOTES, CONTREXX_CHARSET);
                $objResult->MoveNext();
            }
        }
        
        //get category host(s)
        $query = "SELECT `title`,`id` 
                    FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_host
                   WHERE cat_id = '".intval($this->id)."'
                     AND confirmed = '1'";
        
        $objResult = $objDatabase->Execute($query);
        
        if ($objResult !== false) {
            while (!$objResult->EOF) {
                $this->arrData['hosts'][intval($objResult->fields['id'])] = htmlentities($objResult->fields['title'], ENT_QUOTES, CONTREXX_CHARSET);
                $objResult->MoveNext();
            }
        }
    }
    
    /**
     * Switch the status of the catgory
     * 
     * @return boolean true if status updated successfully, false otherwise
     */
    function switchStatus(){
        global $objDatabase;
        
        if($this->status == 1) {
            $categoryStatus = 0;
        } else {
            $categoryStatus = 1;
        }
        
        
        $query = "UPDATE ".DBPREFIX."module_".$this->moduleTablePrefix."_category
                     SET status = '".intval($categoryStatus)."'
                   WHERE id = '".intval($this->id)."'";
        
        $objResult = $objDatabase->Execute($query);
        
        if ($objResult !== false) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Save the category order
     *      
     * @param integer $order order number of the category
     * 
     * @return boolean true if order updated successfully, false otherwise
     */
    function saveOrder($order) {
        global $objDatabase, $_LANGID;    
                  
        $query = "UPDATE ".DBPREFIX."module_".$this->moduleTablePrefix."_category
                     SET `pos` = '".intval($order)."'          
                   WHERE id = '".intval($this->id)."'";
                               
        $objResult = $objDatabase->Execute($query);   
        
        if ($objResult !== false) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Save the category
     *      
     * @param array $data posted data from the user
     * 
     * @return boolean true if data saved successfully, false otherwise
     */
    function save($data) {
        global $objDatabase, $_LANGID;
    	
    	$arrHosts = array();
    	$arrHosts = $data['selectedHosts'];
    	$arrNames = array();
        $arrNames = $data['name'];
        
    	if(intval($this->id) == 0) {
    		$query = "INSERT INTO ".DBPREFIX."module_".$this->moduleTablePrefix."_category
    		                      (`pos`,`status`)
                           VALUES ('0','0')";
    		
	        $objResult = $objDatabase->Execute($query);
	        
    		if($objResult === false) {
                return false;
            }
            
            $this->id = intval($objDatabase->Insert_ID());
    	}
    	
    	//names
    	$query = "DELETE FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_category_name
                        WHERE cat_id = '".intval($this->id)."'";
            
        $objResult = $objDatabase->Execute($query);
        
        if ($objResult !== false) {
        	foreach ($arrNames as $langId => $categoryName) {
        		if($langId != 0) {
	        		$categoryName = $categoryName=='' ? $arrNames[0] : $categoryName;
	        		
	        		if($_LANGID == $langId) {
	        			$categoryName = $arrNames[0] != $this->name ? $arrNames[0] : $categoryName;
	        		}
	        		
	        		$query = "INSERT INTO ".DBPREFIX."module_".$this->moduleTablePrefix."_category_name
	                                      (`cat_id`,`lang_id`,`name`)
	                               VALUES ('".intval($this->id)."','".intval($langId)."','".contrexx_addslashes(contrexx_strip_tags($categoryName))."')";
	            
	                $objResult = $objDatabase->Execute($query);
        		}
        	}
        	
	        if ($objResult !== false) {
                //hosts
		        foreach ($arrHosts as $key => $hostId) {
			        $query = "UPDATE ".DBPREFIX."module_".$this->moduleTablePrefix."_host
			                     SET cat_id = '".intval($this->id)."'          
			                   WHERE id = '".intval($hostId)."'";
			            
			        $objResult = $objDatabase->Execute($query);
		        }
		        
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
     * Delete the category
     *     
     * @return boolean true if data deleted successfully, false otherwise
     */
    function delete(){
        global $objDatabase;
        
        $query = "DELETE FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_category
                        WHERE id = '".intval($this->id)."'";
        
        $objResult = $objDatabase->Execute($query);
        
        if ($objResult !== false) {
        	$query = "DELETE FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_category_name
	                        WHERE cat_id = '".intval($this->id)."'";
	        
	        $objResult = $objDatabase->Execute($query);
	        
	        if ($objResult !== false) {
	        	$query = "UPDATE ".DBPREFIX."module_".$this->moduleTablePrefix."_host
	        	             SET cat_id = '0'          
	                       WHERE cat_id = '".intval($this->id)."'";
	            
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
     * Count the number of entries in the category
     *      
     * @return integer Entry count of the category
     */
    function countEntries($getAll = false){
        global $objDatabase;  
        
        // get startdate
        if (!empty($_GET['from'])) {
            $startDate = parent::getDateTimestamp($_GET['from']); 
        } else if ($_GET['cmd'] == 'archive') {                             
            $startDate = null; 
        } else {
            $startDay   = isset($_GET['day']) ? $_GET['day'] : date("d", mktime());   
            $startMonth = isset($_GET['month']) ? $_GET['month'] : date("m", mktime()); 
            $startYear  = isset($_GET['year']) ? $_GET['year'] : date("Y", mktime());     
            $startDay = $_GET['cmd'] == 'boxes' ? 1 : $startDay;        
            $startDate = mktime(0, 0, 0, $startMonth, $startDay, $startYear);  
        }                   
        
        // get enddate
        if (!empty($_GET['till'])) {
            $endDate = parent::getDateTimestamp($_GET['till']); 
        } else if ($_GET['cmd'] == 'archive') {
            $endDate = mktime(); 
        } else {
            $endDay   = isset($_GET['endDay']) ? $_GET['endDay'] : date("d", mktime());   
            $endMonth = isset($_GET['endMonth']) ? $_GET['endMonth'] : date("m", mktime()); 
            $endYear  = isset($_GET['endYear']) ? $_GET['endYear'] : date("Y", mktime());            
            $endYear = empty($_GET['endYear']) && empty($_GET['endMonth']) ? $endYear+10: $endYear;          
            $endDate = mktime(23, 59, 59, $endMonth, $endDay, $endYear);      
        }
        
        $searchTerm = !empty($_GET['term']) ? contrexx_addslashes($_GET['term']) : null;
        
        // set the start date as null if $getAll is true
        if ($getAll) {
            $startDate = null;
        }
        
        $objEventManager = new CalendarEventManager($startDate,$endDate,$this->id,$searchTerm);
        $objEventManager->getEventList();            
        $count = count($objEventManager->eventList);
        
        return $count;
    }
}
