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
 * Media Directory Inputfield Add Stepp Class
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Comvation Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_mediadir
 * @todo        Edit PHP DocBlocks!
 */

/**
 * Media Directory Inputfield Add Stepp Class
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_mediadir
 */
class mediaDirectoryInputfieldAdd_step extends mediaDirectoryLibrary
{
    public $arrPlaceholders = array('TXT_MEDIADIR_INPUTFIELD_NAME');


    /**
     * Constructor
     */
    function __construct()
    {
    }


    function getInputfield($intView, $arrInputfield, $intEntryId=null, $objAddStep)
    {
        global $objDatabase, $_LANGID, $objInit;

        switch ($intView) {
            default:
            case 1:
                //modify (add/edit) View
                if($objInit->mode == 'backend') {
                    return null;
                } else {
                    $arrStepInfos = $objAddStep->getLastStepInformations();

                    $strValue = empty($arrInputfield['default_value'][$_LANGID]) ? $arrInputfield['default_value'][0] : $arrInputfield['default_value'][$_LANGID];


                    if($arrStepInfos['first'] == true) {
                        $strNotFirst = '';
                        $strDisplay = 'block';
                    } else {
                        $strNotFirst = '</div>';
                        $strDisplay = 'none';
                    }

                    return $strNotFirst.'<div id="Step_'.$arrStepInfos['id'].'" class="'.$this->moduleName.'AddStep" style="display: '.$strDisplay.'; float: left; width: 100%; height: auto !important;"><p class="'.$this->moduleName.'AddStepText">'.$strValue.'</p>';
                }

                break;
            case 2:
                //search View
                break;
        }
    }

    function saveInputfield($strValue)
    {
        return true;
    }


    function deleteContent($intEntryId, $intIputfieldId)
    {
        return true;
    }


    function getContent($intEntryId, $arrInputfield, $arrTranslationStatus)
    {
        return null;
    }


    function getJavascriptCheck()
    {
        return null;
    }
}
