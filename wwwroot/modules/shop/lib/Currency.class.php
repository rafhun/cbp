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
 * Currency class
 * @copyright   CONTREXX CMS - COMVATION AG
 * @package     contrexx
 * @subpackage  module_shop
 * @author      Reto Kohli <reto.kohli@comvation.com>
 * @version     3.0.0
 * @todo        Edit PHP DocBlocks!
 */

/**
 * Currency related static methods
 * @copyright   CONTREXX CMS - COMVATION AG
 * @package     contrexx
 * @subpackage  module_shop
 * @author      Reto Kohli <reto.kohli@comvation.com>
 * @version     3.0.0
 */
class Currency
{
    /**
     * Text key
     */
    const TEXT_NAME = 'currency_name';

    /**
     * class suffixes for active/inactive currencies
     */
    const STYLE_NAME_INACTIVE = 'inactive';
    const STYLE_NAME_ACTIVE   = 'active';

    /**
     * Array of available currencies (default null).
     *
     * Use {@link getCurrencyArray()} to access it from outside this class.
     * @access  private
     * @static
     * @var     array
     */
    private static $arrCurrency = null;

    /**
     * Active currency object id (default null).
     *
     * Use {@link getActiveCurrencyId()} to access it from outside this class.
     * @access  private
     * @static
     * @var     integer
     */
    private static $activeCurrencyId = false;

    /**
     * Default currency object id (defaults to null).
     *
     * Use {@link getDefaultCurrencyId()} to access it from outside this class.
     * @access  private
     * @static
     * @var     integer
     */
    private static $defaultCurrencyId = false;


    /**
     * Initialize currencies
     *
     * Sets up the Currency array, and picks the selected Currency from the
     * 'currency' request parameter, if available.
     * @author  Reto Kohli <reto.kohli@comvation.com>
     * @static
     */
    static function init($active_currency_id=0)
    {
        global $objDatabase;

        $arrSqlName = Text::getSqlSnippets(
            '`currency`.`id`', FRONTEND_LANG_ID, 'shop',
            array('name' => self::TEXT_NAME));
        $query = "
            SELECT `currency`.`id`, `currency`.`code`, `currency`.`symbol`,
                   `currency`.`rate`, `currency`.`increment`,
                   `currency`.`ord`,
                   `currency`.`active`, `currency`.`default`, ".
                   $arrSqlName['field']."
              FROM `".DBPREFIX."module_shop".MODULE_INDEX."_currencies` AS `currency`".
                   $arrSqlName['join']."
             ORDER BY `currency`.`id` ASC";
        $objResult = $objDatabase->Execute($query);
        if (!$objResult) return self::errorHandler();
        while (!$objResult->EOF) {
            $id = $objResult->fields['id'];
            $strName = $objResult->fields['name'];
            if ($strName === null) {
                $strName = Text::getById($id, 'shop', self::TEXT_NAME)->content();
            }
            self::$arrCurrency[$objResult->fields['id']] = array(
                'id' => $objResult->fields['id'],
                'code' => $objResult->fields['code'],
                'symbol' => $objResult->fields['symbol'],
                'name' => $strName,
                'rate' => $objResult->fields['rate'],
                'increment' => $objResult->fields['increment'],
                'ord' => $objResult->fields['ord'],
                'active' => $objResult->fields['active'],
                'default' => $objResult->fields['default'],
            );
            if ($objResult->fields['default'])
                self::$defaultCurrencyId = $objResult->fields['id'];
            $objResult->MoveNext();
        }
        if (!isset($_SESSION['shop'])) {
            $_SESSION['shop'] = array();
        }
        if (isset($_REQUEST['currency'])) {
            $currency_id = intval($_REQUEST['currency']);
            $_SESSION['shop']['currencyId'] =
                (isset(self::$arrCurrency[$currency_id])
                    ? $currency_id : self::$defaultCurrencyId
                );
        }
        if (!empty($active_currency_id)) {
            $_SESSION['shop']['currencyId'] =
                (isset(self::$arrCurrency[$active_currency_id])
                    ? $active_currency_id : self::$defaultCurrencyId
                );
        }
        if (empty($_SESSION['shop']['currencyId'])) {
            $_SESSION['shop']['currencyId'] = self::$defaultCurrencyId;
        }
        self::$activeCurrencyId = intval($_SESSION['shop']['currencyId']);
        return true;
    }


    /**
     * Resets the $arrCurrency class array to null to enforce
     * reinitialisation
     *
     * Call this after changing the database table
     */
    static function reset()
    {
        self::$arrCurrency = null;
    }

    /**
     * Returns the currency array
     * @author  Reto Kohli <reto.kohli@comvation.com>
     * @access  public
     * @static
     * @return  array   The currency array
     */
    static function getCurrencyArray()
    {
        if (!is_array(self::$arrCurrency)) self::init();
        return self::$arrCurrency;
    }


    /**
     * Returns the default currency ID
     * @author  Reto Kohli <reto.kohli@comvation.com>
     * @access  public
     * @static
     * @return  integer     The ID of the default currency
     */
    static function getDefaultCurrencyId()
    {
        if (!is_array(self::$arrCurrency)) self::init();
        return self::$defaultCurrencyId;
    }


    /**
     * Returns the default currency symbol
     * @author  Reto Kohli <reto.kohli@comvation.com>
     * @access  public
     * @static
     * @return  string      The string representing the default currency
     */
    static function getDefaultCurrencySymbol()
    {
        if (!is_array(self::$arrCurrency)) self::init();
        return self::$arrCurrency[self::$defaultCurrencyId]['symbol'];
    }


    /**
     * Returns the default currency code
     * @author  Reto Kohli <reto.kohli@comvation.com>
     * @access  public
     * @static
     * @return  string      The string representing the default currency code
     */
    static function getDefaultCurrencyCode()
    {
        if (!is_array(self::$arrCurrency)) self::init();
        return self::$arrCurrency[self::$defaultCurrencyId]['code'];
    }


    /**
     * Returns the active currency ID
     * @author  Reto Kohli <reto.kohli@comvation.com>
     * @access  public
     * @static
     * @return  integer     The ID of the active currency
     */
    static function getActiveCurrencyId()
    {
        if (!is_array(self::$arrCurrency)) self::init();
        return self::$activeCurrencyId;
    }


    /**
     * Set the active currency ID
     * @param   integer     $currency_id    The active Currency ID
     * @author  Reto Kohli <reto.kohli@comvation.com>
     * @access  public
     * @static
     */
    static function setActiveCurrencyId($currency_id)
    {
        if (!is_array(self::$arrCurrency)) self::init($currency_id);
        self::$activeCurrencyId = $currency_id;
    }


    /**
     * Returns the active currency symbol
     *
     * This is a custom Currency name that does not correspond to any
     * ISO standard, like "sFr.", or "Euro".
     * @author  Reto Kohli <reto.kohli@comvation.com>
     * @access  public
     * @static
     * @return  string      The string representing the active currency
     */
    static function getActiveCurrencySymbol()
    {
        if (!is_array(self::$arrCurrency)) self::init();
        return self::$arrCurrency[self::$activeCurrencyId]['symbol'];
    }


    /**
     * Returns the active currency code
     *
     * This usually corresponds to the ISO 4217 code for the Currency,
     * like CHF, or USD.
     * @author  Reto Kohli <reto.kohli@comvation.com>
     * @access  public
     * @static
     * @return  string      The string representing the active currency code
     */
    static function getActiveCurrencyCode()
    {
        if (!is_array(self::$arrCurrency)) self::init();
        return self::$arrCurrency[self::$activeCurrencyId]['code'];
    }


    /**
     * Returns the currency symbol for the given ID
     * @author  Reto Kohli <reto.kohli@comvation.com>
     * @access  public
     * @static
     * @return  string      The string representing the active currency
     */
    static function getCurrencySymbolById($currency_id)
    {
        if (!is_array(self::$arrCurrency)) self::init();
        return self::$arrCurrency[$currency_id]['symbol'];
    }


    /**
     * Returns the currency code for the given ID
     * @author  Reto Kohli <reto.kohli@comvation.com>
     * @access  public
     * @static
     * @return  string      The string representing the active currency code
     */
    static function getCurrencyCodeById($currency_id)
    {
        if (!is_array(self::$arrCurrency)) self::init();
        return self::$arrCurrency[$currency_id]['code'];
    }


    /**
     * Returns the amount converted from the default to the active currency
     *
     * Note that the amount is rounded to five cents before formatting.
     * @author  Reto Kohli <reto.kohli@comvation.com>
     * @access  public
     * @static
     * @param   double  $price  The amount in default currency
     * @return  string          Formatted amount in the active currency
     * @todo    In case that the {@link formatPrice()} function is localized,
     *          the returned value *MUST NOT* be treated as a number anymore!
     */
    static function getCurrencyPrice($price)
    {
        if (!is_array(self::$arrCurrency)) self::init();
        $rate = self::$arrCurrency[self::$activeCurrencyId]['rate'];
        $increment = self::$arrCurrency[self::$activeCurrencyId]['increment'];
        if ($increment <= 0) $increment = 0.01;
        return self::formatPrice(round($price*$rate/$increment)*$increment);
    }


    /**
     * Returns the amount converted from the active to the default currency
     *
     * Note that the amount is rounded to five cents before formatting.
     * @author  Reto Kohli <reto.kohli@comvation.com>
     * @access  public
     * @static
     * @param   double  $price  The amount in active currency
     * @return  string          Formated amount in default currency
     * @todo    In case that the {@link formatPrice()} function is localized,
     *          the returned value *MUST NOT* be treated as a number anymore!
     */
    static function getDefaultCurrencyPrice($price)
    {
        if (!is_array(self::$arrCurrency)) self::init();
        if (self::$activeCurrencyId == self::$defaultCurrencyId) {
            return self::formatPrice($price);
        }
        $rate = self::$arrCurrency[self::$activeCurrencyId]['rate'];
        $defaultRate = self::$arrCurrency[self::$defaultCurrencyId]['rate'];
        $defaultIncrement = self::$arrCurrency[self::$defaultCurrencyId]['increment'];
        return self::formatPrice(round(
            $price*$defaultRate/$rate/$defaultIncrement)*$defaultIncrement);
    }


    /**
     * Returns the formatted amount in a non-localized notation
     *
     * The optional $length is inserted into the sprintf()
     * format string and determines the maximum length of the number.
     * If present, the optional $padding character is inserted into the
     * sprintf() format string.
     * The optional $increment parameter overrides the increment value
     * of the *active* Currency, which is used by default.
     * The $increment value limits the number of digits printed after the
     * decimal point.
     * Currently, the number is formatted as a float, using no thousands,
     * and '.' as decimal separator.
     * @todo    Localize!  Create language and country dependant
     *          settings in the database, and make this behave accordingly.
     * @author  Reto Kohli <reto.kohli@comvation.com>
     * @static
     * @param   double  $price      The amount
     * @param   string  $length     The optional number length
     * @param   string  $padding    The optional padding character
     * @param   float   $increment  The optional increment
     * @return  double            The formatted amount
     */
    static function formatPrice($price, $length='', $padding='', $increment=null)
    {
//\DBG::log("formatPrice($price, $length, $padding, $increment): Entered");
        $decimals = 2;
        if (empty ($increment)) {
            if (!is_array(self::$arrCurrency)) self::init();
            $increment =
                self::$arrCurrency[self::$activeCurrencyId]['increment'];
        }
        $increment = floatval($increment);
        if ($increment > 0) {
            $decimals = max(0, -floor(log10($increment)));
            $price = round($price/$increment)*$increment;
        }
        $price = sprintf('%'.$padding.$length.'.'.$decimals.'f', $price);
//\DBG::log("formatPrice($price, $length, $padding, $increment): Decimals: $decimals");
        return $price;
    }


    /**
     * Returns the amount in a non-localized notation in cents,
     * rounded to one cent.
     *
     * Note that the amount argument is supposed to be in decimal format
     * with decimal separator and the appropriate number of decimal places,
     * as returned by {@link formatPrice()}, but it also works for integer
     * values like the ones returned by itself.
     * Removes underscores (_) as well as decimal (.) and thousands (')
     * separators, and replaces dashes (-) by zeroes (0).
     * @author  Reto Kohli <reto.kohli@comvation.com>
     * @static
     * @param   string    $amount   The amount in decimal format
     * @return  integer             The amount in cents, rounded to one cent
     * @since   2.1.0
     * @version 3.0.0
     */
    static function formatCents($amount)
    {
        $amount = preg_replace('/[_\\.\']/', '', $amount);
        $amount = preg_replace('/-/', '0', $amount);
        return intval($amount);
    }


    /**
     * Set up the Currency navbar
     * @author  Reto Kohli <reto.kohli@comvation.com>
     * @return  string            The HTML code for the Currency navbar
     * @access  public
     * @static
     */
    static function getCurrencyNavbar()
    {
        if (!is_array(self::$arrCurrency)) self::init();
        $strCurNavbar = '';
        $uri = $_SERVER['REQUEST_URI'];
        Html::stripUriParam($uri, 'currency');
        foreach (self::$arrCurrency as $id => $arrCurrency) {
            if (!$arrCurrency['active']) continue;
            $strCurNavbar .=
                '<a class="'.($id == self::$activeCurrencyId
                    ? self::STYLE_NAME_ACTIVE : self::STYLE_NAME_INACTIVE
                ).
                '" href="'.htmlspecialchars(
                    $uri, ENT_QUOTES, CONTREXX_CHARSET
                ).
                '&amp;currency='.$id.'" title="'.$arrCurrency['code'].'">'.
                $arrCurrency['code'].
                '</a>';
        }
        return $strCurNavbar;
    }


    /**
     * Return the currency code for the ID given
     *
     * Mind that some methods rely on the return value being NULL for
     * unknown Currencies, see {@see PaymentProcessing::checkIn()}.
     * @author  Reto Kohli <reto.kohli@comvation.com>
     * @static
     * @param   integer   $currencyId   The currency ID
     * @return  mixed                   The currency code on success,
     *                                  NULL otherwise
     * @global  ADONewConnection
     */
    static function getCodeById($currencyId)
    {
        if (!is_array(self::$arrCurrency)) self::init();
        if (isset(self::$arrCurrency[$currencyId]['code']))
            return self::$arrCurrency[$currencyId]['code'];
        return NULL;
    }


    /**
     * Return the currency symbol for the ID given
     * @author  Reto Kohli <reto.kohli@comvation.com>
     * @static
     * @param   integer   $currencyId   The currency ID
     * @return  mixed                   The currency symbol on success,
     *                                  false otherwise
     * @global  ADONewConnection
     */
    static function getSymbolById($currencyId)
    {
        if (!is_array(self::$arrCurrency)) self::init();
        if (isset(self::$arrCurrency[$currencyId]['symbol']))
            return self::$arrCurrency[$currencyId]['symbol'];
        return false;
    }



    /**
     * Store the currencies as present in the post request
     *
     * See {@link deleteCurrency()}, {@link addCurrency()}, and
     * {@link updateCurrencies()}.
     * @return  boolean             The empty string if nothing was changed,
     *                              boolean true upon storing everything
     *                              successfully, or false otherwise
     */
    static function store()
    {
        if (empty(self::$arrCurrency)) self::init();
        $total_result = true;
        $result = self::deleteCurrency();
        if ($result !== '') $total_result &= $result;
        $result = self::addCurrency();
        if ($result !== '') $total_result &= $result;
        $result = self::updateCurrencies();
        if ($result !== '') $total_result &= $result;
        // Reinit after storing, or the user won't see any changes at first
        self::init();
        return $total_result;
    }


    /**
     * Deletes a currency
     *
     * This method will fail if you try to delete the default Currency.
     * @return  boolean             Null if nothing was deleted,
     *                              boolean true upon deleting the currency
     *                              successfully, or false otherwise
     */
    static function delete()
    {
        global $objDatabase;

        if (empty($_GET['currencyId'])) return null;
        self::init();
        $currency_id = $_GET['currencyId'];
        if ($currency_id == self::$defaultCurrencyId) return false;
        if (!Text::deleteById($currency_id, 'shop', self::TEXT_NAME))
            return false;
        $objResult = $objDatabase->Execute("
            DELETE FROM `".DBPREFIX."module_shop".MODULE_INDEX."_currencies`
             WHERE `id`=$currency_id");
        if (!$objResult) return false;
        unset(self::$arrCurrency[$currency_id]);
        $objDatabase->Execute("OPTIMIZE TABLE `".DBPREFIX."module_shop".MODULE_INDEX."_currencies`");
        return true;
    }


    /**
     * Add a new currency
     *
     * If the posted data is incomplete sets a message, and returns null.
     * Returns false on database errors only.
     * @return  boolean             Null if nothing was added,
     *                              boolean true upon adding the currency
     *                              successfully, or false otherwise
     * @static
     */
    static function add()
    {
        global $objDatabase, $_ARRAYLANG;

        if (empty($_POST['currency_add'])) return null;
        if (empty($_POST['currencyNameNew'])
         || empty($_POST['currencyCodeNew'])
         || empty($_POST['currencySymbolNew'])
         || empty($_POST['currencyRateNew'])
         || empty($_POST['currencyIncrementNew'])) {
            Message::error($_ARRAYLANG['TXT_SHOP_CURRENCY_INCOMPLETE']);
            return false;
        }
        $code = contrexx_input2raw($_POST['currencyCodeNew']);
        foreach (self::$arrCurrency as $currency) {
            if ($code == $currency['code']) {
                Message::error(sprintf(
                    $_ARRAYLANG['TXT_SHOP_CURRENCY_EXISTS'],
                    $code));
                return null;
            }
        }
        $active = (empty($_POST['currencyActiveNew']) ? 0 : 1);
        $default = (empty($_POST['currencyDefaultNew']) ? 0 : 1);
        $query = "
            INSERT INTO `".DBPREFIX."module_shop".MODULE_INDEX."_currencies` (
                `code`, `symbol`, `rate`, `increment`, `active`
            ) VALUES (
                '".contrexx_raw2db($code)."',
                '".contrexx_input2db($_POST['currencySymbolNew'])."',
                ".floatval($_POST['currencyRateNew']).",
                ".floatval($_POST['currencyIncrementNew']).",
                $active
            )";
        $objResult = $objDatabase->Execute($query);
        if (!$objResult) return false;
        $currency_id = $objDatabase->Insert_Id();
        if (!Text::replace($currency_id, FRONTEND_LANG_ID, 'shop',
            self::TEXT_NAME, contrexx_input2raw($_POST['currencyNameNew']))) {
            return false;
        }
        if ($default) {
            return self::setDefault($currency_id);
        }
        return true;
    }


    /**
     * Update currencies
     * @return  boolean             Null if nothing was changed,
     *                              boolean true upon storing everything
     *                              successfully, or false otherwise
     * @static
     */
    static function update()
    {
        global $objDatabase;

        if (empty($_POST['currency'])) return null;
        self::init();
        $default_id = (isset($_POST['currencyDefault'])
            ? intval($_POST['currencyDefault']) : self::$defaultCurrencyId);
        $changed = false;
        foreach ($_POST['currencyCode'] as $currency_id => $code) {
            $code = contrexx_input2raw($code);
            $name = contrexx_input2raw($_POST['currencyName'][$currency_id]);
            $symbol = contrexx_input2raw($_POST['currencySymbol'][$currency_id]);
            $rate = floatval($_POST['currencyRate'][$currency_id]);
            $increment = floatval($_POST['currencyIncrement'][$currency_id]);
            if ($increment <= 0) $increment = 0.01;
            $default = ($default_id == $currency_id ? 1 : 0);
            $active = (empty ($_POST['currencyActive'][$currency_id]) ? 0 : 1);
            // The default currency must be activated
            $active = ($default ? 1 : $active);
            if (   $code == self::$arrCurrency[$currency_id]['code']
                && $name == self::$arrCurrency[$currency_id]['name']
                && $symbol == self::$arrCurrency[$currency_id]['symbol']
                && $rate == self::$arrCurrency[$currency_id]['rate']
                && $increment == self::$arrCurrency[$currency_id]['increment']
// NOTE: The ordinal is implemented, but not used yet
//                && $ord == self::$arrCurrency[$currency_id]['ord']
                && $active == self::$arrCurrency[$currency_id]['active']
                && $default == self::$arrCurrency[$currency_id]['default']) {
                continue;
            }
            $query = "
                UPDATE `".DBPREFIX."module_shop".MODULE_INDEX."_currencies`
                   SET `code`='".contrexx_raw2db($code)."',
                       `symbol`='".contrexx_raw2db($symbol)."',
                       `rate`=$rate,
                       `increment`=$increment,
                       `active`=$active
                 WHERE `id`=$currency_id";
            if (!$objDatabase->Execute($query)) return false;
            $changed = true;
            if (!Text::replace($currency_id, FRONTEND_LANG_ID,
                'shop', self::TEXT_NAME,
                contrexx_input2raw($_POST['currencyName'][$currency_id]))) {
                return false;
            }
        } // end foreach
        if ($changed) {
            return self::setDefault($default_id);
        }
        return null;
    }


    static function setDefault($currency_id)
    {
        global $objDatabase;

        $objResult = $objDatabase->Execute("
            UPDATE `".DBPREFIX."module_shop".MODULE_INDEX."_currencies`
               SET `default`=0
             WHERE `id`!=$currency_id");
        if (!$objResult) return false;
        $objResult = $objDatabase->Execute("
            UPDATE `".DBPREFIX."module_shop".MODULE_INDEX."_currencies`
               SET `default`=1
             WHERE `id`=$currency_id");
        if (!$objResult) return false;
        return true;
    }


    /**
     * Returns the array of known currencies
     *
     * The array is of the form
     *  array(
     *    array(
     *      0 => ISO 4217 code,
     *      1 => Country and currency name,
     *      2 => number of decimals,
     *    ),
     *    ... more ...
     *  )
     * Note that the code is unique, however, some currencies appear more
     * than once with different codes that may be used.
     * The number of decimals may be non-numeric if unknown.  Ignore these.
     * @return  array           The known currencies array
     * @todo    Add a symbol, symbol position, and other localization
     *          settings (decimal- and thousands separator, etc.) for each
     *          currency
     */
    static function known_currencies()
    {
        return array(
            array('AED', 'United Arab Emirates Dirham', '2', ),
            array('AFN', 'Afghanistan Afghani', '2', ),
            array('ALL', 'Albania Lek', '2', ),
            array('AMD', 'Armenia Dram', '2', ),
            array('ANG', 'Netherlands Antilles Guilder', '2', ),
            array('AOA', 'Angola Kwanza', '2', ),
            array('ARS', 'Argentina Peso', '2', ),
            array('AUD', 'Australia Dollar', '2', ),
            array('AWG', 'Aruba Guilder', '2', ),
            array('AZM', 'Azerbaijan Manat', '2', ),
            array('AZN', 'Azerbaijan New Manat', '2', ),
            array('BAM', 'Bosnia and Herzegovina Convertible Marka', '2', ),
            array('BBD', 'Barbados Dollar', '2', ),
            array('BDT', 'Bangladesh Taka', '2', ),
            array('BGN', 'Bulgaria Lev', '2', ),
            array('BHD', 'Bahrain Dinar', '3', ),
            array('BIF', 'Burundi Franc', '0', ),
            array('BMD', 'Bermuda Dollar', '2', ),
            array('BND', 'Brunei Darussalam Dollar', '2', ),
            array('BOB', 'Bolivia Boliviano', '2', ),
            array('BRL', 'Brazil Real', '2', ),
            array('BSD', 'Bahamas Dollar', '2', ),
            array('BTN', 'Bhutan Ngultrum', '2', ),
            array('BWP', 'Botswana Pula', '2', ),
            array('BYR', 'Belarus Ruble', '0', ),
            array('BZD', 'Belize Dollar', '2', ),
            array('CAD', 'Canada Dollar', '2', ),
            array('CDF', 'Congo/Kinshasa Franc', '2', ),
            array('CHF', 'Switzerland Franc', '2', ),
            array('CLP', 'Chile Peso', '0', ),
            array('CNY', 'China Yuan Renminbi', '2', ),
            array('COP', 'Colombia Peso', '2', ),
            array('CRC', 'Costa Rica Colon', '2', ),
            array('CSD', 'Serbia Dinar', '2', ),
            array('CUC', 'Cuba Convertible Peso', '2', ),
            array('CUP', 'Cuba Peso', '2', ),
            array('CVE', 'Cape Verde Escudo', '2', ),
            array('CYP', 'Cyprus Pound', '2', ),
            array('CZK', 'Czech Republic Koruna', '2', ),
            array('DJF', 'Djibouti Franc', '0', ),
            array('DKK', 'Denmark Krone', '2', ),
            array('DOP', 'Dominican Republic Peso', '2', ),
            array('DZD', 'Algeria Dinar', '2', ),
            array('EEK', 'Estonian Kroon', '2', ),
            array('EGP', 'Egypt Pound', '2', ),
            array('ERN', 'Eritrea Nakfa', '2', ),
            array('ETB', 'Ethiopia Birr', '2', ),
            array('EUR', 'Euro Member Countries', '2', ),
            array('FJD', 'Fiji Dollar', '2', ),
            array('FKP', 'Falkland Islands (Malvinas) Pound', '2', ),
            array('GBP', 'United Kingdom Pound', '2', ),
            array('GEL', 'Georgia Lari', '2', ),
            array('GGP', 'Guernsey Pound', '?', ),
            array('GHC', 'Ghana Cedi', '2', ),
            array('GHS', 'Ghana Cedi', '2', ),
            array('GIP', 'Gibraltar Pound', '2', ),
            array('GMD', 'Gambia Dalasi', '2', ),
            array('GNF', 'Guinea Franc', '0', ),
            array('GTQ', 'Guatemala Quetzal', '2', ),
            array('GYD', 'Guyana Dollar', '2', ),
            array('HKD', 'Hong Kong Dollar', '2', ),
            array('HNL', 'Honduras Lempira', '2', ),
            array('HRK', 'Croatia Kuna', '2', ),
            array('HTG', 'Haiti Gourde', '2', ),
            array('HUF', 'Hungary Forint', '2', ),
            array('IDR', 'Indonesia Rupiah', '2', ),
            array('ILS', 'Israel Shekel', '2', ),
            array('IMP', 'Isle of Man Pound', '?', ),
            array('INR', 'India Rupee', '2', ),
            array('IQD', 'Iraq Dinar', '3', ),
            array('IRR', 'Iran Rial', '2', ),
            array('ISK', 'Iceland Krona', '0', ),
            array('JEP', 'Jersey Pound', '?', ),
            array('JMD', 'Jamaica Dollar', '2', ),
            array('JOD', 'Jordan Dinar', '3', ),
            array('JPY', 'Japan Yen', '0', ),
            array('KES', 'Kenya Shilling', '2', ),
            array('KGS', 'Kyrgyzstan Som', '2', ),
            array('KHR', 'Cambodia Riel', '2', ),
            array('KMF', 'Comoros Franc', '0', ),
            array('KPW', 'Korea (North) Won', '2', ),
            array('KRW', 'Korea (South) Won', '0', ),
            array('KWD', 'Kuwait Dinar', '3', ),
            array('KYD', 'Cayman Islands Dollar', '2', ),
            array('KZT', 'Kazakhstan Tenge', '2', ),
            array('LAK', 'Laos Kip', '2', ),
            array('LBP', 'Lebanon Pound', '2', ),
            array('LKR', 'Sri Lanka Rupee', '2', ),
            array('LRD', 'Liberia Dollar', '2', ),
            array('LSL', 'Lesotho Loti', '2', ),
            array('LTL', 'Lithuania Litas', '2', ),
            array('LVL', 'Latvia Lat', '2', ),
            array('LYD', 'Libya Dinar', '3', ),
            array('MAD', 'Morocco Dirham', '2', ),
            array('MDL', 'Moldova Leu', '2', ),
            array('MGA', 'Madagascar Ariary', '2', ),
            array('MKD', 'Macedonia Denar', '2', ),
            array('MMK', 'Myanmar (Burma) Kyat', '2', ),
            array('MNT', 'Mongolia Tughrik', '2', ),
            array('MOP', 'Macau Pataca', '2', ),
            array('MRO', 'Mauritania Ouguiya', '2', ),
            array('MTL', 'Maltese Lira', '2', ),
            array('MUR', 'Mauritius Rupee', '2', ),
            array('MVR', 'Maldives (Maldive Islands) Rufiyaa', '2', ),
            array('MWK', 'Malawi Kwacha', '2', ),
            array('MXN', 'Mexico Peso', '2', ),
            array('MYR', 'Malaysia Ringgit', '2', ),
            array('MZM', 'Mozambique Metical', '2', ),
            array('MZN', 'Mozambique Metical', '2', ),
            array('NAD', 'Namibia Dollar', '2', ),
            array('NGN', 'Nigeria Naira', '2', ),
            array('NIO', 'Nicaragua Cordoba', '2', ),
            array('NOK', 'Norway Krone', '2', ),
            array('NPR', 'Nepal Rupee', '2', ),
            array('NZD', 'New Zealand Dollar', '2', ),
            array('OMR', 'Oman Rial', '3', ),
            array('PAB', 'Panama Balboa', '2', ),
            array('PEN', 'Peru Nuevo Sol', '2', ),
            array('PGK', 'Papua New Guinea Kina', '2', ),
            array('PHP', 'Philippines Peso', '2', ),
            array('PKR', 'Pakistan Rupee', '2', ),
            array('PLN', 'Poland Zloty', '2', ),
            array('PYG', 'Paraguay Guarani', '0', ),
            array('QAR', 'Qatar Riyal', '2', ),
            array('RON', 'Romania New Leu', '2', ),
            array('RSD', 'Serbia Dinar', '?', ),
            array('RUB', 'Russia Ruble', '2', ),
            array('RWF', 'Rwanda Franc', '0', ),
            array('SAR', 'Saudi Arabia Riyal', '2', ),
            array('SBD', 'Solomon Islands Dollar', '2', ),
            array('SCR', 'Seychelles Rupee', '2', ),
            array('SDD', 'Sudan Dinar', '2', ),
            array('SDG', 'Sudan Pound', '?', ),
            array('SEK', 'Sweden Krona', '2', ),
            array('SGD', 'Singapore Dollar', '2', ),
            array('SHP', 'Saint Helena Pound', '2', ),
            array('SIT', 'Slovenia Tolar', '2', ),
            array('SKK', 'Slovak Koruna', '2', ),
            array('SLL', 'Sierra Leone Leone', '2', ),
            array('SOS', 'Somalia Shilling', '2', ),
            array('SPL', 'Seborga Luigino', '?', ),
            array('SRD', 'Suriname Dollar', '2', ),
            array('STD', 'São Principe and Tome Dobra', '2', ),
            array('SVC', 'El Salvador Colon', '2', ),
            array('SYP', 'Syria Pound', '2', ),
            array('SZL', 'Swaziland Lilangeni', '2', ),
            array('THB', 'Thailand Baht', '2', ),
            array('TJS', 'Tajikistan Somoni', '2', ),
            array('TMM', 'Turkmenistan Manat', '2', ),
            array('TMT', 'Turkmenistan Manat', '2', ),
            array('TND', 'Tunisia Dinar', '3', ),
            array('TOP', 'Tonga Pa\'anga', '2', ),
            array('TRY', 'Turkey Lira', '2', ),
            array('TTD', 'Trinidad and Tobago Dollar', '2', ),
            array('TVD', 'Tuvalu Dollar', '?', ),
            array('TWD', 'Taiwan New Dollar', '2', ),
            array('TZS', 'Tanzania Shilling', '2', ),
            array('UAH', 'Ukraine Hryvna', '2', ),
            array('UGX', 'Uganda Shilling', '2', ),
            array('USD', 'United States Dollar', '2', ),
            array('UYU', 'Uruguay Peso', '2', ),
            array('UZS', 'Uzbekistan Som', '2', ),
            array('VEB', 'Venezuela Bolivar', '2', ),
            array('VEF', 'Venezuela Bolivar Fuerte', '2', ),
            array('VND', 'Viet Nam Dong', '2', ),
            array('VUV', 'Vanuatu Vatu', '0', ),
            array('WST', 'Samoa Tala', '2', ),
            array('XAF', 'Communauté Financière Africaine (BEAC) CFA Franc BEAC', '0', ),
            array('XCD', 'East Caribbean Dollar', '2', ),
            array('XDR', 'International Monetary Fund (IMF) Special Drawing Rights', '5', ),
            array('XOF', 'Communauté Financière Africaine (BCEAO) Franc', '0', ),
            array('XPF', 'Comptoirs Français du Pacifique (CFP) Franc', '0', ),
            array('YER', 'Yemen Rial', '2', ),
            array('ZAR', 'South Africa Rand', '2', ),
            array('ZMK', 'Zambia Kwacha', '2', ),
            array('ZWD', 'Zimbabwe Dollar', '2', ),
        );
    }


    /**
     * Returns the array of names for all known currencies indexed
     * by ISO 4217 code
     *
     * You can specify a custom format for the names using the $format
     * parameter.  It defaults to '%2$s (%1$s)', that is the currency
     * name (%2) followed by the ISO 4217 code (%1) in parentheses.
     * Also, the number of decimals for the currency is available as %3.
     * @param   string  $format     The optional sprintf() format
     * @return  array               The currency name array
     */
    static function get_known_currencies_name_array($format=null)
    {
        if (empty($format)) $format = '%2$s (%1$s)';
        $arrName = array();
        foreach (self::known_currencies() as $currency) {
            $arrName[$currency[0]] = sprintf($format,
                $currency[0], $currency[1], $currency[2]);
        }
        return $arrName;
    }


    /**
     * Returns the array of increments for all known currencies indexed
     * by ISO 4217 code
     * @return  array               The currency increment array
     */
    static function get_known_currencies_increment_array()
    {
        $arrIncrement = array();
        foreach (self::known_currencies() as $currency) {
            $increment = (is_numeric($currency[2])
                ? pow(10, -$currency[2]) : null);
            $arrIncrement[$currency[0]] = $increment;
        }
        return $arrIncrement;
    }


    /**
     * Handles database errors
     *
     * Also migrates old Currency names to the Text class,
     * and inserts default Currencyes if necessary
     * @return  boolean     false       Always!
     * @throws  Cx\Lib\Update_DatabaseException
     */
    static function errorHandler()
    {
        global $objDatabase;

// Currency
        Text::errorHandler();

        $table_name = DBPREFIX.'module_shop_currencies';
        $table_structure = array(
            'id' => array('type' => 'INT(10)', 'unsigned' => true, 'notnull' => true, 'auto_increment' => true, 'primary' => true),
            'code' => array('type' => 'CHAR(3)', 'notnull' => true, 'default' => ''),
            'symbol' => array('type' => 'VARCHAR(20)', 'notnull' => true, 'default' => ''),
            'rate' => array('type' => 'DECIMAL(10,4)', 'unsigned' => true, 'notnull' => true, 'default' => '1.0000'),
// TODO: Changed default increment to '0.01'.  Apply to installation database!
            'increment' => array('type' => 'DECIMAL(6,5)', 'unsigned' => true, 'notnull' => true, 'default' => '0.01'),
            'ord' => array('type' => 'INT(5)', 'unsigned' => true, 'notnull' => true, 'default' => '0', 'renamefrom' => 'sort_order'),
            'active' => array('type' => 'TINYINT(1)', 'unsigned' => true, 'notnull' => true, 'default' => '1', 'renamefrom' => 'status'),
            'default' => array('type' => 'TINYINT(1)', 'unsigned' => true, 'notnull' => true, 'default' => '0', 'renamefrom' => 'is_default'),
        );
        $table_index = array();

        $default_lang_id = FWLanguage::getDefaultLangId();
        if (Cx\Lib\UpdateUtil::table_exist($table_name)) {
            if (Cx\Lib\UpdateUtil::column_exist($table_name, 'name')) {
                // Migrate all Currency names to the Text table first
                Text::deleteByKey('shop', self::TEXT_NAME);
                $query = "
                    SELECT `id`, `code`, `name`
                      FROM `$table_name`";
                $objResult = Cx\Lib\UpdateUtil::sql($query);
                if (!$objResult) {
                    throw new Cx\Lib\Update_DatabaseException(
                       "Failed to query Currency names", $query);
                }
                while (!$objResult->EOF) {
                    $id = $objResult->fields['id'];
                    $name = $objResult->fields['name'];
                    if (!Text::replace($id, $default_lang_id,
                        'shop', self::TEXT_NAME, $name)) {
                        throw new Cx\Lib\Update_DatabaseException(
                           "Failed to migrate Currency name '$name'");
                    }
                    $objResult->MoveNext();
                }
            }
            Cx\Lib\UpdateUtil::table($table_name, $table_structure, $table_index);
            return false;
        }

        // If the table did not exist, insert defaults
        $arrCurrencies = array(
            'Schweizer Franken' => array('CHF', 'sFr.', 1.000000, '0.05', 1, 1, 1),
// TODO: I dunno if I'm just lucky, or if this will work with any charsets
// configured for PHP and mySQL?
// Anyway, neither entering the Euro-E literally nor various hacks involving
// utf8_decode()/utf8_encode() did the trick...
            'Euro' => array('EUR', html_entity_decode("&euro;"), 1.180000, '0.01', 2, 1, 0),
            'United States Dollars' => array('USD', '$', 0.880000, '0.01', 3, 1, 0),
        );
        // There is no previous version of this table!
        Cx\Lib\UpdateUtil::table($table_name, $table_structure);
        // And there aren't even records to migrate, so
        foreach ($arrCurrencies as $name => $arrCurrency) {
            $query = "
                INSERT INTO `contrexx_module_shop_currencies` (
                    `code`, `symbol`, `rate`, `increment`,
                    `ord`, `active`, `default`
                ) VALUES (
                    '".join("','", $arrCurrency)."'
                )";
            $objResult = Cx\Lib\UpdateUtil::sql($query);
            if (!$objResult) {
                throw new Cx\Lib\Update_DatabaseException(
                    "Failed to insert default Currencies");
            }
            $id = $objDatabase->Insert_ID();
            if (!Text::replace($id, FRONTEND_LANG_ID, 'shop',
                self::TEXT_NAME, $name)) {
                throw new Cx\Lib\Update_DatabaseException(
                    "Failed to add Text for default Currency name '$name'");
            }
        }

        // Always
        return false;
    }

}
