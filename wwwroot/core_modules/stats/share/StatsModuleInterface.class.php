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
 * StatsModuleInterface
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  coremodule_stats
 */

/**
 * @ignore
 */
require_once(ASCMS_FRAMEWORK_PATH.'/ModuleInterface.class.php');

/**
 * Provides public stats functions
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  coremodule_stats
 */
class StatsModuleInterface extends ModuleInterface {
    /**
     * Updates the statistic title table.
     * A copy of the current title is kept in this table. This way we can ensure titles in the statistics
     * overview are still available if the page itself (including history) has already been deleted.
     * @param integer $pageId ID of the page to update
     * @param string $title the new title
     */
    public function updateStatsTitles($pageId, $title) {
        global $objDatabase;
        $objDatabase->Execute('UPDATE '.DBPREFIX.'stats_requests
                                  SET pageTitle="'.$title.'"
                                WHERE pageId='.$pageId);
    }

}
?>
