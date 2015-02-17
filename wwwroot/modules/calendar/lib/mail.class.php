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
 * Calendar Class Mail
 * 
 * @package    contrexx
 * @subpackage module_calendar
 * @author     Comvation <info@comvation.com>
 * @copyright  CONTREXX CMS - COMVATION AG
 * @version    1.00
 */ 
class CalendarMail extends CalendarLibrary
{
    /**
     * Mail Id
     * 
     * @access public
     * @var integer 
     */
    public $id;
    
    /**
     * Mail Title
     *
     * @access public
     * @var string 
     */
    public $title;
    
    /**
     * mail content text
     *
     * @access public
     * @var string
     */
    public $content_text;
    
    /**
     * mail content html
     *
     * @access public
     * @var string 
     */
    public $content_html;
    
    /**
     * Language id
     *
     * @access public
     * @var integer 
     */
    public $lang_id;
    
    /**
     * recipients
     *
     * @access public
     * @var string 
     */
    public $recipients;
    
    /**
     * Action id
     *
     * @access public
     * @var integer 
     */
    public $action_id;
    
    /**
     * Is default mail
     *
     * @access public
     * @var boolean 
     */
    public $is_default;
    
    /**
     * Status
     *
     * @access public
     * @var boolean 
     */
    public $status;
    
    /**
     * List of templates
     *
     * @access public
     * @var array 
     */
    public $templateList;
    
    /**
     * Mail Constructor loads the mail object with the given id
     * 
     * @param integer $id mail id
     */
    function __construct($id=null){
        if($id != null) {
            self::get($id);
        }
    }
    
    /**
     * Loads the mail by Id
     *      
     * @param integer $mailId Mail id
     * 
     * @return null
     */
    function get($mailId) {
        global $objDatabase, $_ARRAYLANG, $_LANGID;
        
        $query = "SELECT id,title,recipients,content_text,content_html,lang_id,action_id,is_default,status
                    FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_mail
                   WHERE id = '".intval($mailId)."'
                   LIMIT 1";
        $objResult = $objDatabase->Execute($query);
        if ($objResult !== false) {
            $this->id = intval($mailId);
            $this->title = stripslashes($objResult->fields['title']);
            $this->content_text = stripslashes($objResult->fields['content_text']);
            $this->content_html = stripslashes($objResult->fields['content_html']);
            $this->recipients = htmlentities($objResult->fields['recipients'], ENT_QUOTES, CONTREXX_CHARSET);            
            $this->action_id = intval($objResult->fields['action_id']);
            $this->lang_id = intval($objResult->fields['lang_id']);
            $this->is_default = intval($objResult->fields['is_default']);
            $this->status = intval($objResult->fields['status']);
        }
    }
    
    /**
     * Delete the mail 
     *      
     * @return boolean true if data deleted, false otherwise
     */
    function delete(){
        global $objDatabase;
        
        $query = "DELETE FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_mail
                   WHERE id = '".intval($this->id)."'";
        
        $objResult = $objDatabase->Execute($query);
        if ($objResult !== false) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Set the mail as a default mail
     *      
     * @return boolean true if data updated, false otherwise
     */
    function setAsDefault(){
        global $objDatabase;
        
        $query = "UPDATE ".DBPREFIX."module_".$this->moduleTablePrefix."_mail
                     SET is_default = '0'
                   WHERE action_id = '".intval($this->action_id)."'";
        
        $objResult = $objDatabase->Execute($query);
        
        $query = "UPDATE ".DBPREFIX."module_".$this->moduleTablePrefix."_mail
                     SET is_default = '1'
                   WHERE id = '".intval($this->id)."'";
        
        $objResult = $objDatabase->Execute($query);
        if ($objResult !== false) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Switch the status of the mail
     *      
     * @return boolean true if data updated, false otherwise
     */
    function switchStatus(){
        global $objDatabase;
        
        if($this->status == 1) {
            $mailStatus = 0;
        } else {
            $mailStatus = 1;
        }
        
        $query = "UPDATE ".DBPREFIX."module_".$this->moduleTablePrefix."_mail
                     SET status = '".intval($mailStatus)."'
                   WHERE id = '".intval($this->id)."'";
        
        $objResult = $objDatabase->Execute($query);
        if ($objResult !== false) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Save the mail data
     *      
     * @param type $data Posted data from the user
     * 
     * @return boolean true if data updated, false otherwise
     */
    function save($data) {
        global $objDatabase;
        
        $title          = contrexx_addslashes(contrexx_strip_tags($data['title']));
        $content_text   = contrexx_addslashes(contrexx_strip_tags($data['content_text']));
        $content_html   = contrexx_addslashes($data['content_html']);
        $lang_id        = intval($data['lang']);
        $action_id      = intval($data['action']);
        $recipients     = contrexx_addslashes(contrexx_strip_tags($data['recipients']));
        
        if(intval($this->id) == 0) {
            $query = "INSERT INTO ".DBPREFIX."module_".$this->moduleTablePrefix."_mail
                                  (`title`,`content_text`,`content_html`,`recipients`,`lang_id`,`action_id`,`status`) 
                           VALUES ('".$title."','".$content_text."','".$content_html."','".$recipients."','".$lang_id."','".$action_id."','0')";
        } else {
            $query = "UPDATE ".DBPREFIX."module_".$this->moduleTablePrefix."_mail
                         SET `title` = '".$title."',
                             `content_text` = '".$content_text."',
                             `content_html` = '".$content_html."',
                             `recipients` = '".$recipients."',
                             `lang_id` = '".$lang_id."',
                             `action_id` = '".$action_id."'
                       WHERE `id` = '".intval($this->id)."'";
        }
        
        $objResult = $objDatabase->Execute($query);
        if($objResult !== false) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Initialize the Template list
     * 
     * @return null
     */
    public function getTemplateList() {
        global $objDatabase;
        
        $query = 'SELECT `id`,
                         `action_id`,
                         `lang_id`
                  FROM '.DBPREFIX.'module_'.$this->moduleTablePrefix.'_mail
                  ORDER BY `action_id` ASC, `lang_id` ASC, `status` DESC, `title` ASC';
        
        $objResult = $objDatabase->Execute($query);
        
        if ($objResult !== false) {
            while (!$objResult->EOF) {
                $objMail = new CalendarMail(intval($objResult->fields['id']));
                $this->templateList[$objResult->fields['action_id']][$objResult->fields['lang_id']][] = $objMail;
                $objResult->MoveNext();
            }
        }        
    }
    
    /**
     * Return's the mailing template list drop down
     * 
     * @param integer $selectedId Template list to be selected
     * @param action  $actionId   Action id
     * 
     * @return string Html drop down with the mail templates
     */
    function getTemplateDropdown($selectedId=null, $actionId=null, $languageId=null) {
        global $_ARRAYLANG;
        
        parent::getSettings();
        parent::getFrontendLanguages();
                
        if (empty($selectedId)) {
            if (empty($this->templateList[$actionId][$languageId])) {                
                // if no templates are available in associated language (or template is deactivated), select default template
                foreach ($this->arrFrontendLanguages as $lang_id=> $lang) {
                    foreach ($this->templateList[$actionId][$lang_id] as $objMail) {
                        if ($objMail->is_default) {                            
                            $selectedId = $objMail->id;
                            break;
                        }
                    }
                    if (!empty($selectedId)) {
                        break;
                    }
                }
            } else {
                // if default template is set for associated language, select default template
                foreach ($this->templateList[$actionId][$languageId] as $objMail) {
                    if ($objMail->is_default) {
                        $selectedId = $objMail->id;
                        break;
                    }
                }
                // if templates are available in associated language, select first template of own language
                if (empty($selectedId)) {
                    $mail = reset($this->templateList[$actionId][$languageId]);
                    $selectedId = $mail->id;
                }
            }
        }

        $options = '';
        foreach ($this->arrFrontendLanguages as $lang_id=> $lang) {
            if (!empty($this->templateList[$actionId][$lang_id])) {
                $options .= '<optgroup label="'. $lang['name'] .'">';
            
                foreach ($this->templateList[$actionId][$lang_id] as $objMail) {
                    
                    $options .= "<option value='{$objMail->id}'
                                    ".($selectedId == $objMail->id ? "selected='selected'" : '') ."
                                    style='". (!$objMail->status ? "color : #A0A0A0;" : '') ."'
                                 >
                                    {$objMail->title}
                                   ". ($objMail->is_default ? " (". $_ARRAYLANG["TXT_{$this->moduleLangVar}_DEFAULT"] .")" : '') ."
                                   ". (!$objMail->status ? " (". $_ARRAYLANG["TXT_{$this->moduleLangVar}_INACTIVE"] .")" : '') ."
                                 </option>";
                }
                $options .= '</optgroup>';
            }
        }
        
        return $options;
    }
}
