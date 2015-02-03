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
 * OBSOLETE
 *
 * Use core/Country.class.php instead.
 * Shop Country class
 * @version     3.0.0
 * @since       2.1.0
 * @package     contrexx
 * @subpackage  module_shop
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Reto Kohli <reto.kohli@comvation.com>
 * @todo        Test!
 * @todo        To be unified with the core Country class
 */

/**
 * Country helper methods
 * @version     3.0.0
 * @since       2.1.0
 * @package     contrexx
 * @subpackage  module_shop
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Reto Kohli <reto.kohli@comvation.com>
 * @todo        Test!
 * @todo        To be unified with the core Country class
 */
class ShopCountry
{
    /**
     * Text key
     */
    const TEXT_NAME = 'country_name';

    /**
     * Array of all countries
     * @var     array
     * @access  private
     * @see     init()
     */
    private static $arrCountries = false;

    /**
     * Array of all country-zone relations
     * @var     array
     * @access  private
     * @see     initCountryRelations()
     */
    private static $arrCountryRelations = false;


    /**
     * Initialise the static array with all countries from the database
     *
     * Note that the Countries are always shown in the selected
     * frontend language.
     * @global  ADONewConnection  $objDatabase
     * @return  boolean                     True on success, false otherwise
     */
    function init()
    {
die("Obsolete class modules/shop/lib/Country.class.php called");
    }


    /**
     * Initialise the static array with all country relations from the database
     * @global  ADONewConnection  $objDatabase
     * @return  boolean                 True on success, false otherwise
     */
    function initCountryRelations()
    {
        global $objDatabase;

        $query = "
            SELECT zone_id, country_id
              FROM ".DBPREFIX."module_shop".MODULE_INDEX."_rel_countries
             ORDER BY id ASC";
        $objResult = $objDatabase->Execute($query);
        if (!$objResult) return false;
        while (!$objResult->EOF) {
            self::$arrCountryRelations[] = array(
                'zone_id' => $objResult->fields['zone_id'],
                'country_id' => $objResult->fields['country_id']
            );
            $objResult->MoveNext();
        }
        return true;
    }


    /**
     * Returns array of all countries
     * @return  array               The country array
     * @static
     */
    static function getArray()
    {
        if (empty(self::$arrCountries)) self::init();
        return self::$arrCountries;
    }


    /**
     * Returns the name of the country selected by its ID
     *
     * If a country with the given ID does not exist, returns the empty string.
     * @param   integer   $country_id     The country ID
     * @return  string                    The country name, or the empty string
     * @static
     */
    static function getNameById($country_id)
    {
        if (empty($country_id)) return '';
        if (empty(self::$arrCountries)) self::init();
        return self::$arrCountries[$country_id]['name'];
    }


    /**
     * Returns the HTML dropdown menu code for the active countries.
     * @param   string  $menuName   Optional name of the menu,
     *                              defaults to "countryId"
     * @param   string  $selectedId Optional preselected country ID
     * @param   string  $onchange   Optional onchange callback function
     * @return  string              The HTML dropdown menu code
     * @static
     */
    static function getMenu($menuName='countryId', $selectedId='', $onchange='')
    {
        $strMenu =
            '<select name="'.$menuName.'" '.
            ($onchange ? ' onchange="'.$onchange.'"' : '').">\n".
            self::getCountryMenuoptions($selectedId).
            "</select>\n";
        return $strMenu;
    }


    /**
     * Returns the HTML code for the countries dropdown menu options
     * @param   string  $selectedId   Optional preselected country ID
     * @param   boolean $flagActiveonly   If true, only active countries
     *                                are added to the options, all otherwise.
     * @return  string                The HTML dropdown menu options code
     * @static
     */
    static function getMenuoptions($selected_id=0, $flagActiveonly=true)
    {
        static $strMenuoptions = '';
        static $last_selected_id = 0;

        if (empty(self::$arrCountries)) self::init();
        if ($strMenuoptions && $last_selected_id == $selected_id)
            return $strMenuoptions;
        if (empty(self::$arrCountries)) self::init();
        foreach (self::$arrCountries as $id => $arrCountry) {
            if (   $flagActiveonly
                && empty($arrCountry['active'])) continue;
            $strMenuoptions .=
                '<option value="'.$id.'"'.
                ($selected_id == $id ? ' selected="selected"' : '').'>'.
                $arrCountry['name']."</option>\n";
        }
        $last_selected_id = $selected_id;
        return $strMenuoptions;
    }


    /**
     * Returns an array of two arrays; one with countries in the given zone,
     * the other with the remaining countries.
     *
     * The array looks like this:
     *  array(
     *    'in' => array(    // Countries in the zone
     *      country ID => array(
     *        'id' => country ID,
     *        'name' => country name,
     *      ),
     *      ... more ...
     *    ),
     *    'out' => array(   // Countries not in the zone
     *      country ID => array(
     *        'id' => country ID,
     *        'name' => country name,
     *      ),
     *      ... more ...
     *    ),
     *  );
     * @param   integer     $zone_id        The zone ID
     * @return  array                       Countries array, as described above
     */
    static function getArraysByZoneId($zone_id)
    {
        global $objDatabase;

        if (empty(self::$arrCountries)) self::init();

        // Query relations between zones and countries:
        // Get all country IDs and names associated with that zone ID
        $arrSqlName = Text::getSqlSnippets(
            '`country`.`id`', FRONTEND_LANG_ID, 'shop',
            array('name' => self::TEXT_NAME));
        $query = "
            SELECT `country`.`id`, `relation`.`country_id`, `zone_id`, ".
                   $arrSqlName['field']."
              FROM `".DBPREFIX."module_shop".MODULE_INDEX."_countries` AS `country`".
                   $arrSqlName['join']."
              LEFT JOIN `".DBPREFIX."module_shop".MODULE_INDEX."_rel_countries` AS `relation`
                ON `country`.`id`=`relation`.`country_id`
             WHERE `country`.`active`=1
             ORDER BY `name` ASC";
//               AND `relation`.`zone_id`=$zone_id
        $objResult = $objDatabase->Execute($query);
        if (!$objResult) return false;
        // Initialize the array to avoid notices when one or the other is empty
        $arrZoneCountries = array('in' => array(), 'out' => array());
        while (!$objResult->EOF) {
            $id = $objResult->fields['countries_id'];
            $name = $objResult->fields['name'];
            $country_zone_id = $objResult->fields['zone_id'];
            // Country may only be in the Zone if it exists and is active
//            if (   empty(self::$arrCountries[$id])
//                || empty(self::$arrCountries[$id]['active']))
//                continue;
            $arrZoneCountries[($zone_id == $country_zone_id ? 'in' : 'out')][$id] =
                array(
                    'id' => $id,
                    'name' => $name,
                );
            $objResult->MoveNext();
        }
        return $arrZoneCountries;
    }

}
