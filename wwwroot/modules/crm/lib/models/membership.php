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
 * Membership Class CRM
 *
 * @category   Membership
 * @package    contrexx
 * @subpackage module_crm
 * @author     SoftSolutions4U Development Team <info@softsolutions4u.com>
 * @copyright  2012 and CONTREXX CMS - COMVATION AG
 * @license    trial license
 * @link       www.contrexx.com
 */

/**
 * Membership Class CRM
 *
 * @category   Membership
 * @package    contrexx
 * @subpackage module_crm
 * @author     SoftSolutions4U Development Team <info@softsolutions4u.com>
 * @copyright  2012 and CONTREXX CMS - COMVATION AG
 * @license    trial license
 * @link       www.contrexx.com
 */

class membership
{

    /**
    * Module Name
    *
    * @access private
    * @var string
    */
    private $moduleName = 'crm';

    /**
    * Table Name
    *
    * @access private
    * @var string
    */
    private $table_name;

    /**
     * find all the membership by language
     *
     * @param array $data conditions
     * 
     * @return array
     */
    function findAllByLang($data = array())
    {
        global $objDatabase, $_LANGID;

        $condition = '';
        if (!empty($data)) {
            $condition = "AND ".implode("AND ", $data);
        }
        $objResult = $objDatabase->Execute("SELECT membership.*,
                                                   memberLoc.value
                                             FROM `".DBPREFIX."module_{$this->moduleName}_memberships` AS membership
                                             LEFT JOIN `".DBPREFIX."module_{$this->moduleName}_membership_local` AS memberLoc
                                                ON membership.id = memberLoc.entry_id
                                             WHERE memberLoc.lang_id = ".$_LANGID." $condition ORDER BY sorting ASC");

        return $objResult;
    }
}
?>
