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
 * SettingsMails
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_checkout
 */

/**
 * SettingsMails
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_checkout
 */
class SettingsMails {

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
     * Get admin mail.
     *
     * @access      public
     */
    public function getAdminMail()
    {
        $objResult = $this->objDatabase->Execute('SELECT `title`, `content` FROM `'.DBPREFIX.'module_checkout_settings_mails` WHERE `id`=1');

        if ($objResult) {
            $arrAdminMail['title'] = $objResult->fields['title'];
            $arrAdminMail['content'] = $objResult->fields['content'];
            return $arrAdminMail;
        } else {
            return false;
        }
    }

    /**
     * Get customer mail.
     *
     * @access      public
     */
    public function getCustomerMail()
    {
        $objResult = $this->objDatabase->Execute('SELECT `title`, `content` FROM `'.DBPREFIX.'module_checkout_settings_mails` WHERE `id`=2');

        if ($objResult) {
            $arrCustomerMail['title'] = $objResult->fields['title'];
            $arrCustomerMail['content'] = $objResult->fields['content'];
            return $arrCustomerMail;
        } else {
            return false;
        }
    }

    /**
     * Update administrator mail.
     *
     * @access      public
     * @param       array       $arrAdminMail
     */
    public function updateAdminMail($arrAdminMail)
    {
        $objResult = $this->objDatabase->Execute('
            UPDATE `'.DBPREFIX.'module_checkout_settings_mails`
            SET `title`="'.contrexx_raw2db($arrAdminMail['title']).'",
                `content`="'.contrexx_raw2db($arrAdminMail['content']).'"
            WHERE `id`=1
        ');

        if ($objResult) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Update customer mail.
     *
     * @access      public
     * @param       array       $arrCustomerMail
     */
    public function updateCustomerMail($arrCustomerMail)
    {
        $objResult = $this->objDatabase->Execute('
            UPDATE `'.DBPREFIX.'module_checkout_settings_mails`
            SET `title`="'.contrexx_raw2db($arrCustomerMail['title']).'",
                `content`="'.contrexx_raw2db($arrCustomerMail['content']).'"
            WHERE `id`=2
        ');

        if ($objResult) {
            return true;
        } else {
            return false;
        }
    }
}
