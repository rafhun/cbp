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
 * User Settings Object
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Thomas Daeppen <thomas.daeppen@comvation.com>
 * @version     2.0.0
 * @package     contrexx
 * @subpackage  lib_framework
 */

/**
 * User Settings Object
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Thomas Daeppen <thomas.daeppen@comvation.com>
 * @version     2.0.0
 * @package     contrexx
 * @subpackage  lib_framework
 */
class User_Setting
{
    /**
     * The user mail object
     * @var   User_Setting_Mail
     */
    protected $objMail;

    function __construct()
    {
        $this->objMail = new User_Setting_Mail();
    }


    function getMail()
    {
        return $this->objMail;
    }


    /**
     * Returns the current settings array
     *
     * Note that the records are read from the database on the first call
     * and stored locally.  Successive calls will yield the same array,
     * regardless of changes made to the table, unless $reload is set to true.
     * @global      ADOConnection   $objDatabase
     * @staticvar   array           $arrSettings    The settings array
     * @param       boolean         $reload         Force reloading if true.
     *                                              Defaults to false
     * @return      array                           The settings array
     * @static
     */
    static function getSettings($reload=false)
    {
        global $objDatabase;
        static $arrSettings = array();

        if (empty($arrSettings) || $reload) {
// TODO: This seems to be bogus
            $arrDebugBackTrace = debug_backtrace();
            $objSetting = $objDatabase->Execute('SELECT `key`, `value`, `status` FROM `'.DBPREFIX.'access_settings`');
            if ($objSetting !== false) {
                while (!$objSetting->EOF) {
                    $arrSettings[$objSetting->fields['key']] = array(
                        'value'  => $objSetting->fields['value'],
                        'status' => $objSetting->fields['status']
                    );
                    $objSetting->MoveNext();
                }
            }
        }
        return $arrSettings;
    }


    function setSettings($arrSettings)
    {
        global $objDatabase;

        $status = true;
        foreach ($arrSettings as $key => $arrSetting) {
            if ($objDatabase->Execute('UPDATE `'.DBPREFIX.'access_settings` SET `value` = \''.contrexx_addslashes($arrSetting['value']).'\', `status` = '.intval($arrSetting['status']).' WHERE `key` = \''.contrexx_addslashes($key).'\'') === false) {
                $status = false;
            }
        }
        return $status;
    }


    /**
     * Returns an array containing the available account validity
     * time periods in days in ascending order.
     * @return  array                   The time periods
     * @global  ADONewConnection
     * @static
     */
    public static function getUserValidities()
    {
        global $objDatabase;
        static $arrValidityPeriod = array();

        if (empty($arrValidityPeriod)) {
            $objRecordSet = $objDatabase->Execute("
                SELECT `validity`
                  FROM `".DBPREFIX."access_user_validity`
                 ORDER BY `validity` ASC"
            );
            if ($objRecordSet) {
                while (!$objRecordSet->EOF) {
                    $arrValidityPeriod[] = $objRecordSet->fields['validity'];
                    $objRecordSet->MoveNext();
                }
            }
        }
        return $arrValidityPeriod;
    }

}
