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
 * Medi Directory Add Step Class
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Comvation Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_mediadir
 * @todo        Edit PHP DocBlocks!
 */

/**
 * Media Directory Add Step Class
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_mediadir
 */
class mediaDirectoryAddStep extends mediaDirectoryLibrary
{
    var $arrSteps = array();

    /**
     * Constructor
     */
    function __construct()
    {
    }

    function addNewStep($strStepName) {
        $this->arrSteps[] = $strStepName;
    }

    function getStepNavigation($objTpl) {
        foreach ($this->arrSteps as $intStepId => $strStepName){
            $objTpl->setVariable(array(
                $this->moduleLangVar.'_ENTRY_ADDSTEP_NAME' => $strStepName,
                $this->moduleLangVar.'_ENTRY_ADDSTEP_HREF' => "javascript:selectAddStep('Step_".$intStepId."');",
                $this->moduleLangVar.'_ENTRY_ADDSTEP_ID' => $this->moduleName."AddStep_Step_".$intStepId,
                $this->moduleLangVar.'_ENTRY_ADDSTEP_CLASS' => $intStepId == 0 ? "active" : "",
            ));

            $objTpl->parse($this->moduleName.'EntryAddStepNavigationElement');
        }
    }

    function getLastStepInformations() {
        $arrStepInfos['name'] = end($this->arrSteps);
        $arrStepInfos['id'] = current(array_keys($this->arrSteps, $arrStepInfos['name']));;
        $arrStepInfos['position'] = count($this->arrSteps);
        $arrStepInfos['first'] = $arrStepInfos['position'] == 1 ? true : false;

        return $arrStepInfos;
    }
}
