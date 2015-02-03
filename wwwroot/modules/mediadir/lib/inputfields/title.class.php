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
 * Media Directory Inputfield Title Class
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Comvation Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_mediadir
 * @todo        Edit PHP DocBlocks!
 */

/**
 * @ignore
 */
require_once ASCMS_MODULE_PATH . '/mediadir/lib/inputfields/inputfield.interface.php';

/**
 * Media Directory Inputfield Title Class
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_mediadir
 */
class mediaDirectoryInputfieldTitle extends mediaDirectoryLibrary implements inputfield
{
    public $arrPlaceholders = array('TXT_MEDIADIR_INPUTFIELD_NAME');



    /**
     * Constructor
     */
    function __construct()
    {
        parent::getFrontendLanguages();
        parent::getSettings();
    }



    function getInputfield($intView, $arrInputfield, $intEntryId=null)
    {
        global $objDatabase, $_LANGID, $objInit, $_ARRAYLANG; 
        
        switch ($intView) {
            default:
            case 1:
                //modify (add/edit) View
                if($objInit->mode == 'backend') {
                    return null;
                } else { 
                    return "<br />";
                }   
                
                break;
            case 2:
                //search View         
                break;
        }
    }



    function saveInputfield($intInputfieldId, $strValue)
    {
        //$strValue = contrexx_addslashes(contrexx_strip_tags($strValue));
        return null;
    }


    function deleteContent($intEntryId, $intIputfieldId)
    {                                                
        return true; 
    }



    function getContent($intEntryId, $arrInputfield, $arrTranslationStatus)
    {     
        $arrContent['TXT_'.$this->moduleLangVar.'_INPUTFIELD_NAME'] = '<h2>'.htmlspecialchars($arrInputfield['name'][0], ENT_QUOTES, CONTREXX_CHARSET).'</h2>';
        $arrContent[$this->moduleLangVar.'_INPUTFIELD_VALUE'] = '';
        
        return $arrContent;
    }


    function getJavascriptCheck()
    {             
        return null;
    }
    
    
    function getFormOnSubmit($intInputfieldId)
    {
        return null;
    }
}
