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
 * Calendar Class Headlines
 * 
 * @package    contrexx
 * @subpackage module_calendar
 * @author     Comvation <info@comvation.com>
 * @copyright  CONTREXX CMS - COMVATION AG
 * @version    1.00
 */
class CalendarHeadlines extends CalendarLibrary
{    
    /**
     * Event manager object
     *
     * @access public
     * @var object 
     */
    private $objEventManager;
    
    /**
     * Headlines constructor
     * 
     * @param string $pageContent Template content
     */
    function __construct($pageContent) {
        parent::__construct('.');   
        parent::getSettings();   
        
        $this->pageContent = $pageContent;    
        
        CSRF::add_placeholder($this->_objTpl);
    }
    
    /**
     * Load the event manager
     * 
     * @return null
     */
    function loadEventManager()
    {
        if($this->arrSettings['headlinesStatus'] == 1 && $this->_objTpl->blockExists('calendar_headlines_row')) {                        
            $startDate = mktime(0, 0, 0, date("m", mktime()), date("d", mktime()), date("Y", mktime()));                                   
            $enddate = mktime(23, 59, 59, date("m", mktime()), date("d", mktime()), date("Y", mktime())+10);       
            $categoryId = intval($this->arrSettings['headlinesCategory']) != 0 ? intval($this->arrSettings['headlinesCategory']) : null;        
            
            $startPos = 0;   
            $endPos = $this->arrSettings['headlinesNum'];             

            $this->objEventManager = new CalendarEventManager($startDate,$endDate,$categoryId,$searchTerm,true,$needAuth,true,$startPos,$endPos);
            $this->objEventManager->getEventList();
        }
    }
    
    /**
     * Return's headlines
     *      
     * @return string parsed template content
     */
    function getHeadlines()
    {                        
        global $_CONFIG;
        
        $this->_objTpl->setTemplate($this->pageContent,true,true);  
        
        if($this->arrSettings['headlinesStatus'] == 1) {   
            if($this->_objTpl->blockExists('calendar_headlines_row')) {                  
                self::loadEventManager();  
                if (!empty($this->objEventManager->eventList)) {              
                    $this->objEventManager->showEventList($this->_objTpl); 
                }   
            }                                               
        } else {
            if($this->_objTpl->blockExists('calendar_headlines_row')) { 
                $this->_objTpl->hideBlock('calendar_headlines_row');
            }
        }  
        
        
        return $this->_objTpl->get();
    }      
}
