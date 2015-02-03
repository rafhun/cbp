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
 * Media Directory Interfaces
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Comvation Development Team <info@comvation.com>
 * @version     1.0.0
 * @subpackage  module_mediadir
 * @todo        Edit PHP DocBlocks!
 */

/**
 * Media Directory Interfaces
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_mediadir
 */
class mediaDirectoryInterfaces extends mediaDirectoryLibrary
{
    /**
     * Constructor
     */
    function __construct()
    {
        parent::getSettings();
    }
    
    function showImport($step, $objTpl)
    {
        global $_ARRAYLANG, $_CORELANG, $_LANGID, $objDatabase;

        $objTpl->addBlockfile($this->moduleLangVar.'_INTERFACES_CONTENT', 'interfaces_content', 'module_'.$this->moduleName.'_interfaces_import.html');
        
        $objTpl->setVariable(array(
            'TXT_'.$this->moduleLangVar.'_FROM_DATABASE' => $_ARRAYLANG['TXT_MEDIADIR_FROM_DATABASE'],
            'TXT_'.$this->moduleLangVar.'_FROM_FILE' => $_ARRAYLANG['TXT_MEDIADIR_FROM_FILE'],   
        ));
        
        switch($step) { 
            case 'assignCols':
                $objTpl->hideBlock($this->moduleName.'InterfacesImportSqlSetTable'); 
                
                $tableName = contrexx_stripslashes($_POST['interfacesImportSqlTable']);
                $formId = intval($_POST['interfacesImportSqlForm']);
                $formId = 15;
                $categoryId = intval($_POST['interfacesImportSqlCategory']);
                $categoryId = 162;
                
                $objResult = $objDatabase->Execute('SHOW FIELDS FROM '.$tableName);
                while (!$objResult->EOF) {
                    $avaiableCols .= '<option value="'.$objResult->fields['Field'].'">'.$objResult->fields['Field'].'</option>';
                    $objResult->MoveNext();
                } 
                
                $objInputfield = new mediaDirectoryInputfield($formId);   
                
                foreach($objInputfield->arrInputfields as $key => $inputfield) {
                    if($key != 1 && $key != 2) {
                        $givenCols .= '<option value="'.$inputfield['id'].'">'.$inputfield['name'][0].'</option>';  
                    } 
                } 
                
                $objTpl->setVariable(array(
                    $this->moduleLangVar.'_INTERFACES_IMPORT_SQL_TABLE_COLS' => $avaiableCols,
                    $this->moduleLangVar.'_INTERFACES_IMPORT_SQL_GIVEN_COLS' => $givenCols,
                    $this->moduleLangVar.'_INTERFACES_IMPORT_SQL_TABLE_NANE' => $tableName,
                    $this->moduleLangVar.'_INTERFACES_IMPORT_SQL_FORM_ID' => $formId,
                    $this->moduleLangVar.'_INTERFACES_IMPORT_SQL_CATEGORY_ID' => $categoryId,
                ));  

                $objTpl->parse($this->moduleName.'InterfacesImportSqlAssignCols'); 
                break;
            default:        
                $objTpl->hideBlock($this->moduleName.'InterfacesImportSqlAssignCols'); 
                        
                $objResult = $objDatabase->Execute('SHOW TABLE STATUS LIKE "%"');          
                
                while (!$objResult->EOF) {
                    $dbName =  $objResult->fields['Name'];
                    $avaiableTables .= '<option value="'.$dbName.'">'.$dbName.'</option>';
                    $objResult->MoveNext();
                }
                                          
                $objTpl->setVariable(array(
                    $this->moduleLangVar.'_INTERFACES_IMPORT_SQL_TABLES' => $avaiableTables
                ));
                
                $objTpl->parse($this->moduleName.'InterfacesImportSqlSetTable');
                break;
        }
              
        $objTpl->parse('interfaces_content');
    }
    
    function showExport($step, $objTpl)
    {
        global $_ARRAYLANG, $_CORELANG, $_LANGID, $objDatabase;    

        $objTpl->addBlockfile($this->moduleLangVar.'_INTERFACES_CONTENT', 'interfaces_content', 'module_'.$this->moduleName.'_interfaces_export.html');
        
        if($this->arrSettings['settingsShowLevels'] == 1) {
            $strFormOnSubmit = "selectAll(document.interfacesExportForm.elements['selectedCategories']); ";
            $strFormOnSubmit .= "selectAll(document.interfacesExportForm.elements['selectedLevels']); ";
            
            $objLevels = new mediaDirectoryLevel(null,null,true);
            $arrLevels = $objLevels->listLevels($objTpl, 4);
        
            $objTpl->parse($this->moduleName.'InterfacesExportSelectLevels');
        } else {  
            $strFormOnSubmit = "selectAll(document.interfacesExportForm.elements['selectedCategories']); ";
            $objTpl->hideBlock($this->moduleName.'InterfacesExportSelectLevels'); 
        }
        
        $objCategories = new mediaDirectoryCategory(null,null, true);
        $arrCategories = $objCategories->listCategories($objTpl, 4);
        
        $objForms = new mediaDirectoryForm(null);
        $strForms = $objForms->listForms($objTpl, 4);
        
        $strMasks .= '<option value="0">'.$_ARRAYLANG['TXT_MEDIADIR_NO_EXPORT_MASK'].'</option>';
        $objResultMasks = $objDatabase->Execute("SELECT
                                                    id,title,form_id 
                                                FROM
                                                    ".DBPREFIX."module_".$this->moduleTablePrefix."_masks 
                                                WHERE active = '1'    
                                                ORDER BY title ASC     
                                               ");
        if ($objResultMasks !== false) {
            while (!$objResultMasks->EOF) { 
                $objForm = new mediaDirectoryForm($objResultMasks->fields['form_id']);
                $strFormName = $objForm->arrForms[$objResultMasks->fields['form_id']]['formName'][0];                                                                       
                $strMasks .= '<option value="'.$objResultMasks->fields['id'].'">'.$objResultMasks->fields['title'].' ('.$strFormName.')</option>'; 
                $objResultMasks->MoveNext();
            }                   
        }
        
        
        $objTpl->setVariable(array(
            $this->moduleLangVar.'_INTERFACES_EXPORT_DESELECTED_CATEGORIES' => $arrCategories['not_selected'],
            $this->moduleLangVar.'_INTERFACES_EXPORT_DESELECTED_LEVELS' => $arrLevels['not_selected'],
            $this->moduleLangVar.'_INTERFACES_EXPORT_FORMS' => $strForms,
            $this->moduleLangVar.'_INTERFACES_EXPORT_MASKS' => $strMasks,
            $this->moduleLangVar.'_FORM_ONSUBMIT' => $strFormOnSubmit,
            'TXT_'.$this->moduleLangVar.'_EXPORT_FORMAT' => $_ARRAYLANG['TXT_MEDIADIR_EXPORT_FORMAT'],
            'TXT_'.$this->moduleLangVar.'_FORM_TEMPLATE' => $_ARRAYLANG['TXT_MEDIADIR_FORM_TEMPLATE'],
            'TXT_'.$this->moduleLangVar.'_EXPORT_MASK' => $_ARRAYLANG['TXT_MEDIADIR_EXPORT_MASK'],
            'TXT_'.$this->moduleLangVar.'_CATEGORIES' => $_ARRAYLANG['TXT_MEDIADIR_CATEGORIES'],
            'TXT_'.$this->moduleLangVar.'_LEVELS' => $_ARRAYLANG['TXT_MEDIADIR_LEVELS'],
        )); 
                                                                                                        
        $objTpl->parse('interfaces_content');
    }
}
?>
