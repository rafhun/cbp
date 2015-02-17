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
 * Media Directory Import Class
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Comvation Development Team <info@comvation.com>
 * @version     1.0.0
 * @subpackage  module_mediadir
 * @todo        Edit PHP DocBlocks!
 */

/**
 * Media Directory Import Class
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_mediadir
 */
class mediaDirectoryImport extends mediaDirectoryLibrary
{
    /**
     * Constructor
     */
    function __construct()
    {
        //...
    }
    
    function importSQL($tableName, $newKeys, $givenKeys, $importType, $formId, $categoryId=null, $levelId=null)
    {
        global $_ARRAYLANG, $_CORELANG, $_LANGID, $objDatabase;
        
        $newKeys = explode(";", $newKeys);
        $givenKeys = explode(";", $givenKeys);
        $objFWUser = FWUser::getFWUserObject(); 
        $intUserId = intval($objFWUser->objUser->getId());
        
        if($importType == 2) {
            $objResult = $objDatabase->Execute('TRUNCATE TABLE '.DBPREFIX.'module_'.$this->moduleTablePrefix.'_entries'); 
            $objResult = $objDatabase->Execute('TRUNCATE TABLE '.DBPREFIX.'module_'.$this->moduleTablePrefix.'_rel_entry_inputfields'); 
            $objResult = $objDatabase->Execute('TRUNCATE TABLE '.DBPREFIX.'module_'.$this->moduleTablePrefix.'_rel_entry_categories'); 
            $objResult = $objDatabase->Execute('TRUNCATE TABLE '.DBPREFIX.'module_'.$this->moduleTablePrefix.'_rel_entry_levels'); 
        }          
        
        $objResultImport = $objDatabase->Execute('SELECT * FROM '.$tableName);
        
        while (!$objResultImport->EOF) {                
            $objResultEntry = $objDatabase->Execute("
                INSERT INTO
                    ".DBPREFIX."module_".$this->moduleTablePrefix."_entries
                SET
                    `order` = '0',
                    `form_id` = '".$formId."',
                    `create_date` = '".mktime()."',
                    `validate_date` = '".mktime()."',
                    `added_by` = '".$intUserId."',
                    `lang_id` = '".$_LANGID."',
                    `ready_to_confirm` = '1',
                    `confirmed` =  '1',
                    `active` =  '1',
                    `duration_type` =  '1',
                    `duration_notification` =  '0',
                    `translation_status` = '".$_LANGID."'
            ");    
            
            $newEntryId = $objDatabase->Insert_ID();
            
            foreach($newKeys as $key => $fieldName) {
                if(!empty($fieldName)) {
                    $newValue = $objResultImport->fields[$fieldName];
                    $givenFieldId = $givenKeys[$key];                                                     
                    
                    $objResultInputfield = $objDatabase->Execute("
                        INSERT INTO
                            ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_inputfields
                        SET
                            `entry_id`='".intval($newEntryId)."',
                            `lang_id`='".intval($_LANGID)."',
                            `form_id`='".intval($formId)."',
                            `field_id`='".intval($givenFieldId)."',
                            `value`='".$newValue."'
                    ");
                }
            }
            
            //only for lipomed.com
            $objResultImage = $objDatabase->Execute("
                INSERT INTO
                    ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_inputfields
                SET
                    `entry_id`='".intval($newEntryId)."',
                    `lang_id`='".intval($_LANGID)."',
                    `form_id`='".intval($formId)."',
                    `field_id`='".intval(118)."',
                    `value`='/cms/images/mediadir/images/".$objResultImport->fields['refnr'].".gif'
            ");  
        
            if($categoryId != null && $categoryId != 0) {
                $special1 = true;
                
                if(!$special1) {
                    $objResultCategory = $objDatabase->Execute("
                        INSERT INTO
                            ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_categories
                        SET
                            `entry_id`='".intval($newEntryId)."',
                            `category_id`='".intval($categoryId)."'
                    ");  
                } else {
                    //only for lipomed.com   
                    $oldCategoryId = $objResultImport->fields['scid'];
                    
                    switch($oldCategoryId) {
                        case 1:
                            $newCategoryId = 148;
                            break;
                        case 3:
                            $newCategoryId = 153;
                            break;
                        case 4:
                            $newCategoryId = 154;
                            break;
                        case 17:
                            $newCategoryId = 158;
                            break;
                        case 20:
                            $newCategoryId = 152;
                            break;
                        case 21:
                            $newCategoryId = 151;
                            break;
                        case 22:
                            $newCategoryId = 156;
                            break;
                        case 24:
                            $newCategoryId = 155;
                            break;
                        case 26:
                            $newCategoryId = 157;
                            break;
                        case 27:
                            $newCategoryId = 159;
                            break;
                        case 28:
                            $newCategoryId = 147;
                            break;
                        case 30:
                            $newCategoryId = 149;
                            break;
                        case 33:
                            $newCategoryId = 150;
                            break;
                        default:
                            $newCategoryId = 162;
                            break;
                    }  
                    
                    $objResultCategory = $objDatabase->Execute("
                        INSERT INTO
                            ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_categories
                        SET
                            `entry_id`='".intval($newEntryId)."',
                            `category_id`='".intval($newCategoryId)."'
                    ");  
                }
            }
            
            if($levelId != null && $levelId != 0) {
                $special2 = false;
                
                if(!$special2) {
                    $objResultLevel = $objDatabase->Execute("
                        INSERT INTO
                            ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_levels
                        SET
                            `entry_id`='".intval($newEntryId)."',
                            `level_id`='".intval($levelId)."'
                    ");   
                } else {
                    //use this for special level relation
                }
            }
            
            $objResultImport->MoveNext(); 
        }   

        return true;
    }
    
    function importCSV($objTpl)
    {
        global $_ARRAYLANG, $_CORELANG, $_LANGID, $objDatabase;
        
        echo  'importCSV';

        return true;
    }
}
?>
