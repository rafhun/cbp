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
 * SettingsYellowpay
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_checkout
 */

/**
 * SettingsYellowpay
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_checkout
 */
class SettingsYellowpay {

    /**
     * Database object.
     *
     * @access      private
     * @var         ADONewConnection
     */
    private $objDatabase;

    /**
     * Initialize the database object.
     *
     * @access      public
     * @param       ADONewConnection    $objDatabase
     */
    public function __construct($objDatabase)
    {
        $this->objDatabase = $objDatabase;
    }

    /**
     * Get settings.
     *
     * @access      public
     */
    public function get()
    {
        $objResult = $this->objDatabase->Execute('SELECT `name`, `value` FROM `'.DBPREFIX.'module_checkout_settings_yellowpay`');

        $arrYellowpay = array();
        if ($objResult) {
            while (!$objResult->EOF) {
                $arrYellowpay[$objResult->fields['name']] = $objResult->fields['value'];
                $objResult->MoveNext();
            }
            return $arrYellowpay;
        } else {
            return false;
        }
    }

    /**
     * Update settings.
     *
     * @access      public
     * @param       array       $arrYellowpay
     */
    public function update($arrYellowpay)
    {
        foreach ($arrYellowpay as $name => $value) {
            $objResult = $this->objDatabase->Execute('
                UPDATE `'.DBPREFIX.'module_checkout_settings_yellowpay`
                SET `value`="'.contrexx_raw2db($value).'"
                WHERE `name`="'.$name.'"
            ');

            if (!$objResult) {
                return false;
            }
        }

        return true;
    }

}
