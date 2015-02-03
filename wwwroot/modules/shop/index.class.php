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
 * The Shop
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Reto Kohli <reto.kohli@comvation.com>
 * @author      Ivan Schmid <ivan.schmid@comvation.com>
 * @access      public
 * @package     contrexx
 * @subpackage  module_shop
 * @version     3.0.0
 */

/**
 * Shop
 * @internal    Extract code from this class and move it to other classes:
 *              Customer, Product, Order, ...
 * @internal    It doesn't really make sense to extend ShopLibrary.
 *              Instead, dissolve ShopLibrary into classes like
 *              Shop, Zones, Country, Payment, etc.
 * @author      Reto Kohli <reto.kohli@comvation.com>
 * @author      Ivan Schmid <ivan.schmid@comvation.com>
 * @access      public
 * @package     contrexx
 * @subpackage  module_shop
 * @version     3.0.0
 */
class Shop extends ShopLibrary
{
    private static $defaultImage = '';

    /**
     * Currency navbar indicator
     * @var     boolean
     * @access  private
     */
    private static $show_currency_navbar = true;
    /**
     * Currency navbar indicator
     * @var     boolean
     * @access  private
     */
    private static $use_js_cart = false;

    /**
     * The PEAR Template Sigma object
     * @var     \Cx\Core\Html\Sigma
     * @access  private
     * @static
     */
    private static $objTemplate = null;

    /**
     * The Customer object
     * @var     Customer
     * @access  private
     * @static
     * @see     lib/Customer.class.php
     */
    private static $objCustomer = null;

    /**
     * True if the shop has been initialized
     * @var boolean
     */
    private static $initialized = false;

    /**
     * The current page's title
     * If the user is on the detail page, show the product name
     * @var null|string
     */
    protected static $pageTitle = null;

    /**
     * Initialize
     * @access public
     */
    static function init()
    {

//DBG::log("Shop::init(): Entered");
        if (self::$initialized) {
die("Shop::init(): ERROR: Shop::init() called more than once!");
        }
        if (self::use_session()) {
            global $sessionObj;
            if (empty($sessionObj)) $sessionObj = \cmsSession::getInstance();
        }
        if (!isset($_SESSION['shop'])) {
            $_SESSION['shop'] = array();
		}
        if (   empty($_REQUEST['section'])
            || $_REQUEST['section'] != 'shop'.MODULE_INDEX) {
            global $_ARRAYLANG, $objInit;
            $_ARRAYLANG = array_merge($_ARRAYLANG,
                $objInit->loadLanguageData('shop'));
        }
        // Check session and user data, log in if present.
        // The Customer is required to properly calculate prices in the Cart
        self::_authenticate();
        SettingDb::init('shop', 'config');
        if (isset($_REQUEST['remoteJs'])) return;
        // Javascript Cart: Shown when active,
        // either on shop pages only, or on any
        if (   SettingDb::getValue('use_js_cart')
            && (   SettingDb::getValue('shopnavbar_on_all_pages')
                || (   isset($_REQUEST['section'])
                    && $_REQUEST['section'] == 'shop'.MODULE_INDEX
                    && (   empty($_REQUEST['cmd'])
                        || in_array($_REQUEST['cmd'],
                              array('discounts', 'details')))))
// Optionally limit to the first instance
//            && MODULE_INDEX == ''
        ) {
//DBG::log("Shop::init(): section {$_REQUEST['section']}, cmd {$_REQUEST['cmd']}: Calling setJsCart()");
            self::setJsCart();
        }
//DBG::log("Shop::init(): After setJsCart: shopnavbar: {$themesPages['shopnavbar']}");
        self::$initialized = true;
    }


    /**
     * Returns true if the shop has been initialized
     * @return  boolean             True if initialized, false otherwise
     */
    public static function isInitialized()
    {
        return self::$initialized;
    }


    /**
     * Returns the Shop page for the present parameters
     * @param   string  $template     The page template
     * @return  string                The page content
     */
    static function getPage($template)
    {
//\DBG::activate(DBG_ERROR_FIREPHP|DBG_LOG);
//\DBG::activate(DBG_LOG_FILE);
        self::init();
        self::registerJavascriptCode();
        self::$defaultImage = ASCMS_SHOP_IMAGES_WEB_PATH.'/'.ShopLibrary::noPictureName;
        // PEAR Sigma template
        self::$objTemplate = new \Cx\Core\Html\Sigma('.');
        self::$objTemplate->setErrorHandling(PEAR_ERROR_DIE);
        self::$objTemplate->setTemplate($template);
        // Global module index for clones
        self::$objTemplate->setGlobalVariable('MODULE_INDEX', MODULE_INDEX);
        // Do this *before* calling our friends, especially Customer methods!
        // Pick the default Country for delivery
        if (empty($_SESSION['shop']['countryId2'])) {
            $_SESSION['shop']['countryId2'] =
                (isset($_POST['countryId2'])
                  ? intval($_POST['countryId2'])
                  : SettingDb::getValue('country_id'));
        }
// TODO: This should be set up in a more elegant way
        Vat::is_reseller(self::$objCustomer && self::$objCustomer->is_reseller());
        // The coupon code may be set when entering the Shop already
        if (isset($_REQUEST['coupon_code'])) {
            global $sessionObj;
            if (!$sessionObj) {
                $sessionObj = \cmsSession::getInstance();
            }
            $_SESSION['shop']['coupon_code'] =
                trim(strip_tags(contrexx_input2raw($_REQUEST['coupon_code'])));
//DBG::log("Coupon Code: Set to ".$_SESSION['shop']['coupon_code']);
        }
//DBG::log("Shop::getPage(): Entered");
        // Global placeholders that are used on (almost) all pages.
        // Add more as desired.
        self::$objTemplate->setGlobalVariable(array(
            'SHOP_CURRENCY_CODE' => Currency::getActiveCurrencyCode(),
            'SHOP_CURRENCY_SYMBOL' => Currency::getActiveCurrencySymbol(),
        ));
        if (!isset($_GET['cmd'])) $_GET['cmd'] = '';
        if (!isset($_GET['act'])) $_GET['act'] = $_GET['cmd'];
        switch ($_GET['act']) {
            case 'shipment':
                self::showShipmentTerms();
                break;
            case 'success':
                self::success();
                break;
            case 'confirm':
                self::confirm();
                break;
            case 'lsv':
            case 'lsv_form':
                self::view_lsv_form();
                break;
            case 'payment':
                self::payment();
                break;
            case 'account':
                self::view_account();
                break;
            case 'cart':
                self::cart();
                break;
            case 'discounts':
                self::discounts();
                break;
            case 'login':
                self::login();
                break;
            case 'paypalIpnCheck':
                // OBSOLETE -- Handled by PaymentProcessing::checkIn() now
                $objPaypal = new PayPal;
                $objPaypal->ipnCheck();
                exit;
            case 'sendpass':
                self::view_sendpass();
                break;
            case 'changepass';
                self::_changepass();
                break;
            // Test for PayPal IPN.
            // *DO NOT* remove this!  Needed for site testing.
            case 'testIpn':
                PayPal::testIpn(); // die()s!
            // Test for PayPal IPN validation
            // *DO NOT* remove this!  Needed for site testing.
            case 'testIpnValidate':
                PayPal::testIpnValidate(); // die()s!
            // Test mail body generation
            // *DO NOT* remove this!  Needed for site testing.
            case 'testMail':
                // Test with
                // http://localhost/contrexx_300/de/index.php?section=shop&act=testMail&key=&order_id=5
//MailTemplate::errorHandler();die();
                $order_id = (!empty($_GET['order_id']) ? $_GET['order_id'] : 10);
                $key = (!empty($_GET['key']) ? $_GET['key'] : 'order_confirmation');
                $arrSubstitution = Orders::getSubstitutionArray($order_id);
                $customer_id = $arrSubstitution['CUSTOMER_ID'];
                $objCustomer = Customer::getById($customer_id);
                if (!$objCustomer) {
die("Failed to get Customer for ID $customer_id");
                    return false;
                }
                $arrSubstitution +=
                      $objCustomer->getSubstitutionArray($customer_id)
                    + self::getSubstitutionArray();
                $arrMailTemplate = array(
                    'section' => 'shop',
                    'key' => $key,
                    'lang_id' => $arrSubstitution['LANG_ID'],
                    'substitution' => &$arrSubstitution,
                    'to' => 'reto.kohli@comvation.com',
//                        $arrSubstitution['CUSTOMER_EMAIL'].','.
//                        SettingDb::getValue('email_confirmation'),
//                    'do_not_strip_empty_placeholders' => true,
                );
                DBG::activate(DBG_LOG_FIREPHP);
//                DBG::activate(DBG_LOG_FILE);
                die(nl2br(contrexx_raw2xhtml(var_export($arrMailTemplate, true))));
//                DBG::log(MailTemplate::send($arrMailTemplate) ? "Sent successfully" : "Sending FAILED!");
//                DBG::deactivate(DBG_LOG_FILE);
                break;

            case 'testAttachment':
                MailTemplate::send(array(
                    'from' => 'reto.kohli@comvation.com',
                    'to' => 'reto.kohli@comvation.com',
                    'subject' => 'Test Attachment',
                    'message' => 'Test',
                    'attachments' => array(
                        0 => 'images/content/banner/qualidator.gif',
                        'images/content/banner/itnews.gif' =>
                            'Sch�nes Bild',
                    ),
                ));
                die("Done!");

            case 'pricelist':
                self::send_pricelist();
                break;
            case 'terms':
                // Static content only (fttb)
                break;

// TODO: Add Order history view (see History.class.php)
//            case 'history':
//                self::view_history();
//                break;

            case 'destroy':
                self::destroyCart();
// TODO: Experimental
//                self::destroyCart(true);
                // No break on purpose
            case 'lastFive':
            case 'products':
            default:
                self::view_product_overview();
        }
        // Note that the Shop Navbar *MUST* be set up *after* the request
        // has been processed, otherwise the cart info won't be up to date!
        self::setNavbar();
// TODO: Set the Messages in the global template instead when that's ready
        Message::show(self::$objTemplate);
//DBG::deactivate();
        return self::$objTemplate->get();
    }

    /**
     * Returns the product name if the user is on the product details page
     * @return string|null the page title to show
     */
    public static function getPageTitle() {
        if (isset(self::$pageTitle)) {
            return contrexx_raw2xhtml(self::$pageTitle);
        }
        return null;
    }

    /**
     * Sets up the Shop Navbar content and returns it as a string
     *
     * Note that {@see init()} must have been called before.
     * The content is created once and stored statically.
     * Repeated calls will always return the same string, unless either
     * a non-empty template is given, or $use_cache is set to false.
     * @global  array   $_ARRAYLANG
     * @global  array   $themesPages
     * @global  array   $_CONFIGURATION
     * @staticvar string    $strContent Caches created content
     * @param   type    $template   Replaces the default template
     *                              ($themesPages['shopnavbar']) and sets
     *                              $use_cache to false unless empty.
     *                              Defaults to NULL
     * @param   type    $use_cache  Does not use any cached content, but builds
     *                              it new from scratch if false.
     *                              Defaults to true.
     * @return  string              The Shop Navbar content
     * @static
     */
    static function getNavbar($template=NULL, $use_cache=true)
    {
        global $_ARRAYLANG, $themesPages;
        static $strContent = NULL;

        if (!$use_cache) $strContent = NULL;
        // Note: This is valid only as long as the content is the same every
        // time this method is called!
        if ($strContent) return $strContent;
        $objTpl = new \Cx\Core\Html\Sigma('.');
        $objTpl->setErrorHandling(PEAR_ERROR_DIE);
        $objTpl->setTemplate(empty($template)
            ? $themesPages['shopnavbar'] : $template);
        $objTpl->setGlobalVariable($_ARRAYLANG);
        $loginInfo = $loginStatus = $redirect = '';
//DBG::log("Shop::getNavbar(): Customer: ".(self::$objCustomer ? "Logged in" : "nada"));
        if (self::$objCustomer) {
            if (self::$objCustomer->company()) {
                $loginInfo = self::$objCustomer->company().'<br />';
            } else {
                $loginInfo =
                    $_ARRAYLANG['TXT_SHOP_'.
                        strtoupper(self::$objCustomer->gender())].' '.
                    self::$objCustomer->lastname().'<br />';
            }
            $loginStatus = $_ARRAYLANG['TXT_LOGGED_IN_AS'];
            // Show link to change the password
            if ($objTpl->blockExists('shop_changepass')) {
                $objTpl->touchBlock('shop_changepass');
            }
        } else {
            // Show login form if the customer is not logged in already.
            $loginStatus = $_ARRAYLANG['TXT_LOGGED_IN_AS_SHOP_GUEST'];
            // $redirect contains something like "section=shop&cmd=details&productId=1"
            if (isset($_REQUEST['redirect'])) {
                $redirect = $_REQUEST['redirect'];
            } else {
                $queryString = $_SERVER['QUERY_STRING'];
                $redirect = base64_encode(preg_replace('/\&?act\=\w*/', '', $queryString));
            }
            $objTpl->setVariable(
                'SHOP_LOGIN_ACTION',
                Cx\Core\Routing\Url::fromModuleAndCmd('shop', 'login').
                '?redirect='.$redirect);
        }
        $objTpl->setVariable(array(
            'SHOP_LOGIN_STATUS' => $loginStatus,
            'SHOP_LOGIN_INFO' => $loginInfo,
        ));
        // Currencies
        if (self::$show_currency_navbar
         && $objTpl->blockExists('shopCurrencies')) {
            $curNavbar = Currency::getCurrencyNavbar();
            if (!empty($curNavbar)) {
                $objTpl->setVariable('SHOP_CURRENCIES', $curNavbar);
            }
        }
        if ($objTpl->blockExists('shopNavbar')) {
            $selectedCatId = 0;
            if (isset($_REQUEST['catId'])) {
                $selectedCatId = intval($_REQUEST['catId']);
                $objCategory = ShopCategory::getById($selectedCatId);
                if (!$objCategory) $selectedCatId = 0;
            }
            if (empty($selectedCatId) && isset($_REQUEST['productId'])) {
                $product_id = intval($_REQUEST['productId']);
                if (isset($_REQUEST['referer']) && $_REQUEST['referer'] == 'cart') {
                    $product_id = Cart::get_product_id($product_id);
                }
                $objProduct = Product::getById($product_id);
                if ($objProduct) {
                    $selectedCatId = $objProduct->category_id();
                    $selectedCatId = preg_replace('/,.+$/', '', $selectedCatId);
                }
            }
            // If there is no distinct Category ID, use the previous one, if any
            if (is_numeric($selectedCatId)) {
                $_SESSION['shop']['previous_category_id'] = $selectedCatId;
            } else {
                if (isset($_SESSION['shop']['previous_category_id']))
                    $selectedCatId = $_SESSION['shop']['previous_category_id'];
            }
            // Only the visible ShopCategories are present
            $arrShopCategoryTree = ShopCategories::getTreeArray(
                false, true, true, $selectedCatId, 0, 0
            );
            // The trail of IDs from root to the selected ShopCategory,
            // built along with the tree array when calling getTreeArray().
            $arrTrail = ShopCategories::getTrailArray($selectedCatId);
            // Display the ShopCategories
            foreach ($arrShopCategoryTree as $arrShopCategory) {
                $level = $arrShopCategory['level'];
                // Skip levels too deep: if ($level >= 2) { continue; }
                $id = $arrShopCategory['id'];
                $style = 'shopnavbar'.($level+1);
                if (in_array($id, $arrTrail)) {
                    $style .= '_active';
                }
                $objTpl->setVariable(array(
                    'SHOP_CATEGORY_STYLE' => $style,
                    'SHOP_CATEGORY_ID' => $id,
                    'SHOP_CATEGORY_NAME' =>
                        str_repeat('&nbsp;', 3*$level).
                        str_replace('"', '&quot;', $arrShopCategory['name']),
                ));
                $objTpl->parse("shopNavbar");
            }
        }
        // Only show the cart info when the JS cart is not active!
        if (!self::$use_js_cart) {
            $objTpl->setVariable(array(
                'SHOP_CART_INFO' => self::cart_info(),
            ));
        }
//        if ($objTpl->blockExists('shopJsCart')) {
//            $objTpl->touchBlock('shopJsCart');
//        }
        $strContent = $objTpl->get();
        return $strContent;
    }


    /**
     * Sets up the Shop Navbar in the global Template only
     *
     * To get the content for use with another Template, see {@see getNavbar()}
     * @global  $objTemplate
     * @global  $themesPages
     */
    static function setNavbar()
    {
        global $objTemplate;

        $objTemplate->setVariable('SHOPNAVBAR_FILE', self::getNavbar());
    }


    /**
     * Sets up the JavsScript cart
     *
     * Searches all $themesPages elements for the first occurrence of the
     * "shopJsCart" template block.
     * Generates the structure of the Javascript cart, puts it in the template,
     * and registers all required JS code.
     * Note that this is only ever called when the JS cart is enabled in the
     * extended settings!
     * @access  public
     * @global  array   $_ARRAYLANG   Language array
     * @global  array   $themesPages  Theme template array
     * @return  void
     * @static
     */
    static function setJsCart()
    {
        global $_ARRAYLANG, $themesPages;

        if (!SettingDb::getValue('use_js_cart')) return;
        $objTemplate = new \Cx\Core\Html\Sigma('.');
        $objTemplate->setErrorHandling(PEAR_ERROR_DIE);
        $match = null;
        $div_cart = $div_product = '';
        foreach ($themesPages as $index => $content) {
//DBG::log("Shop::setJsCart(): Section $index");
            $objTemplate->setTemplate($content, false, false);
            if (!$objTemplate->blockExists('shopJsCart')) {
                continue;
            }
//DBG::log("Shop::setJsCart(): In themespage $index: {$themesPages[$index]}");
            $objTemplate->setCurrentBlock('shopJsCart');
            // Set all language entries and replace formats
            $objTemplate->setGlobalVariable($_ARRAYLANG);
            if ($objTemplate->blockExists('shopJsCartProducts')) {
                $objTemplate->parse('shopJsCartProducts');
                $div_product = $objTemplate->get('shopJsCartProducts');
//DBG::log("Shop::setJsCart(): Got Product: $div_product");
                $objTemplate->replaceBlock('shopJsCartProducts',
                    '[[SHOP_JS_CART_PRODUCTS]]');
            }
            $objTemplate->touchBlock('shopJsCart');
            $objTemplate->parse('shopJsCart');
            $div_cart = $objTemplate->get('shopJsCart');
//DBG::log("Shop::setJsCart(): Got Cart: $div_cart");
            if (preg_match('#^([\n\r]?[^<]*<.*id=["\']shopJsCart["\'][^>]*>)(([\n\r].*)*)(</[^>]*>[^<]*[\n\r]?)$#',
                $div_cart, $match)) {
//DBG::log("Shop::setJsCart(): Matched DIV {$match[1]}, content: {$match[2]}");
                $themesPages[$index] = preg_replace(
                    '@(<!--\s*BEGIN\s+(shopJsCart)\s*-->.*?<!--\s*END\s+\2\s*-->)@s',
                    $match[1].$_ARRAYLANG['TXT_SHOP_CART_IS_LOADING'].$match[4],
                    $content);
/*
// Template use won't work, because it kills the remaining <!-- blocks -->!
                $objTemplate->setTemplate($content, false, false);
                $objTemplate->replaceBlock('shopJsCart',
                    $match[1].
                    $_ARRAYLANG['TXT_SHOP_CART_IS_LOADING'].
                    $match[4]);
                $themesPages[$index] = $objTemplate->get();
*/
//DBG::log("Shop::setJsCart(): Out themespage $index: {$themesPages[$index]}");
            }
            // One instance only (mind that there's a unique id attribute)
            self::$use_js_cart = true;
            break;
        }
        if (!self::$use_js_cart) return;

        self::registerJavascriptCode();
        ContrexxJavascript::getInstance()->setVariable('TXT_SHOP_CART_IS_LOADING', $_ARRAYLANG['TXT_SHOP_CART_IS_LOADING'] ,'shop/cart');
        ContrexxJavascript::getInstance()->setVariable('TXT_SHOP_COULD_NOT_LOAD_CART', $_ARRAYLANG['TXT_SHOP_COULD_NOT_LOAD_CART'] ,'shop/cart');
        ContrexxJavascript::getInstance()->setVariable('TXT_EMPTY_SHOPPING_CART', $_ARRAYLANG['TXT_EMPTY_SHOPPING_CART'] ,'shop/cart');
        ContrexxJavascript::getInstance()->setVariable("url", (String)\Cx\Core\Routing\URL::fromModuleAndCMd('shop'.MODULE_INDEX, 'cart', FRONTEND_LANG_ID, array('remoteJs' => 'addProduct')), 'shop/cart');
        JS::registerJS(ASCMS_MODULE_WEB_PATH . '/shop/js/cart.js');
        JS::registerCode(
            "cartTpl = '".preg_replace(
              array('/\'/', '/[\n\r]/', '/\//'),
              array('\\\'', '\n', '\\/'),
              $div_cart)."';\n".
            "cartProductsTpl = '".preg_replace(
              array('/\'/', '/[\n\r]/', '/\//'),
              array('\\\'', '\n', '\\/'),
              $div_product)."';\n"
        );
    }


    /**
     * Returns a string containing a short Cart overview
     * @return  string        The Cart information
     * @static
     * @todo    The cart info is not updated in time when the cart is
     *          destroyed and the product overview is shown again!
     */
    static function cart_info()
    {
        global $_ARRAYLANG;

        if (Cart::is_empty()) return $_ARRAYLANG['TXT_EMPTY_SHOPPING_CART'];
        $cartInfo =
            $_ARRAYLANG['TXT_SHOPPING_CART'].' '.
            Cart::get_item_count().' '.
            $_ARRAYLANG['TXT_SHOPPING_CART_VALUE'].' '.
            Cart::get_price().' '.
            Currency::getActiveCurrencySymbol();
        $cartInfo =
            '<a href="'.
            Cx\Core\Routing\Url::fromModuleAndCmd('shop', 'cart').
            '" title="'.$cartInfo.'">'.$cartInfo.'</a>';
        return $cartInfo;
    }


    /**
     * Update the cart, and/or set up the view
     * @see Cart::receive_json(), Cart::add_product(), Cart::update_quantity(),
     *      _gotoLoginPage(), Cart::update(), view_cart(), Cat::send_json()
     */
    static function cart()
    {
//DBG::log("Shop::cart(): Entered");
        Cart::init();
        if (!empty($_POST['countryId2'])) {
            $_SESSION['shop']['countryId2'] = intval($_POST['countryId2']);
        }
        if (empty($_GET['remoteJs'])) {
//DBG::log("Shop::cart(): POST");
            Cart::receive_post();
        } else {
//DBG::log("Shop::cart(): JSON");
            Cart::receive_json();
        }
        Cart::update_quantity();
        if (!Cart::update(self::$objCustomer)) {
// TODO: Handle this properly!
die("Failed to update the Cart!");
        }
        // Apply VAT and discounts
        Shop::update_session();
        // *MUST NOT* return if continue is set
        self::_gotoLoginPage();
        if (empty($_GET['remoteJs'])) {
            self::view_cart();
        } else {
//DBG::log("cart(): Sending JSON");
            Cart::send_json();
        }
    }


    /**
     * The cart view
     * @global  array $_ARRAYLANG   Language array
     */
    static function view_cart()
    {
        // hide currency navbar
        // self::$show_currency_navbar = false;
        return Cart::view(self::$objTemplate);
    }


    /**
     * Empties the shopping cart
     *
     * Note that $full=true will not log the User off; it just flushes the
     * static Customer object.  That's somewhat experimental.
     * @param   boolean   $logout   If true, drops the entire Shop session
     *                              and the Customer
     * @static
     */
    static function destroyCart($full=null)
    {
        // Necessary, otherwise no successive orders are possible
        $_SESSION['shop']['order_id'] = $_SESSION['shop']['order_id_checkin'] =
            NULL;
        $_SESSION['shop']['coupon_code'] = NULL;
// TEST ONLY, to not clear the cart: return;
        Cart::destroy();
        // In case you want to flush everything, including the Customer:
        if ($full) {
            unset($_SESSION['shop']);
            self::$objCustomer = null;
        }
    }


    /**
     * Updates the session with all data relevant to the current order
     *
     * - Counts the items in the Cart, sums up the amounts
     * - Calculates all taxes and fees
     * Sets fields in the global $_SESSION['shop'] array, namely
     *  'grand_total_price', 'vat_price', 'vat_products_txt',
     *  'vat_grand_txt', and 'vat_procentual'.
     */
    static function update_session()
    {
        global $_ARRAYLANG;

        if (empty($_SESSION['shop']['payment_price']))
            $_SESSION['shop']['payment_price'] = 0;
        if (empty($_SESSION['shop']['shipment_price']))
            $_SESSION['shop']['shipment_price'] = 0;
        Vat::is_home_country(
               empty($_SESSION['shop']['countryId2'])
            || $_SESSION['shop']['countryId2'] == SettingDb::getValue('country_id'));
        // VAT enabled?
        if (Vat::isEnabled()) {
            // VAT included?
            if (Vat::isIncluded()) {
                // home country equals shop country; VAT is included already
                if (Vat::is_home_country()) {
                    $_SESSION['shop']['vat_price'] = Currency::formatPrice(
                        Cart::get_vat_amount() +
                        Vat::calculateOtherTax(
                              $_SESSION['shop']['payment_price']
                            + $_SESSION['shop']['shipment_price']
                        )
                    );
                    $_SESSION['shop']['grand_total_price'] = Currency::formatPrice(
                          Cart::get_price()
                        + $_SESSION['shop']['payment_price']
                        + $_SESSION['shop']['shipment_price']
                    );
                    $_SESSION['shop']['vat_products_txt'] = $_ARRAYLANG['TXT_TAX_INCLUDED'];
                    $_SESSION['shop']['vat_grand_txt'] = $_ARRAYLANG['TXT_TAX_INCLUDED'];
                } else {
                    // Foreign country; subtract VAT from grand total price.
                    $_SESSION['shop']['vat_price'] = Cart::get_vat_amount();
                    $_SESSION['shop']['grand_total_price'] = Currency::formatPrice(
                          Cart::get_price()
                        + $_SESSION['shop']['payment_price']
                        + $_SESSION['shop']['shipment_price']
                        - $_SESSION['shop']['vat_price']
                    );
                    $_SESSION['shop']['vat_products_txt'] = $_ARRAYLANG['TXT_TAX_INCLUDED'];
                    $_SESSION['shop']['vat_grand_txt'] = $_ARRAYLANG['TXT_TAX_EXCLUDED'];
                }
            } else {
                // VAT is excluded
// When the VAT is excluded, but enabled for foreign countries,
// it must be added nonetheless!
// Otherwise, you would expect it to be disabled for that case.
//                if (Vat::is_home_country()) {
                    // home country equals shop country; add VAT.
                    // the VAT on the products has already been calculated and set in the cart.
                    // now we add the default VAT to the shipping and payment cost.
                    $_SESSION['shop']['vat_price'] = Currency::formatPrice(
                        Cart::get_vat_amount() +
                        Vat::calculateOtherTax(
                            $_SESSION['shop']['payment_price'] +
                            $_SESSION['shop']['shipment_price']
                        ));
                    $_SESSION['shop']['grand_total_price'] = Currency::formatPrice(
                          Cart::get_price()
                        + $_SESSION['shop']['payment_price']
                        + $_SESSION['shop']['shipment_price']
                        + $_SESSION['shop']['vat_price']);
                    $_SESSION['shop']['vat_products_txt'] = $_ARRAYLANG['TXT_TAX_EXCLUDED'];
                    $_SESSION['shop']['vat_grand_txt'] = $_ARRAYLANG['TXT_TAX_INCLUDED'];
//                } else {
//                    // foreign country; do not add VAT
//                    $_SESSION['shop']['vat_price'] = '0.00';
//                    $_SESSION['shop']['grand_total_price'] = Currency::formatPrice(
//                          Cart::get_price()
//                        + $_SESSION['shop']['payment_price']
//                        + $_SESSION['shop']['shipment_price']);
//                    $_SESSION['shop']['vat_products_txt'] = $_ARRAYLANG['TXT_TAX_EXCLUDED'];
//                    $_SESSION['shop']['vat_grand_txt'] = $_ARRAYLANG['TXT_TAX_EXCLUDED'];
//                }
            }
        } else {
            // VAT is disabled
            $_SESSION['shop']['vat_price'] = '0.00';
            $_SESSION['shop']['vat_products_txt'] = '';
            $_SESSION['shop']['vat_grand_txt'] = '';
            $_SESSION['shop']['grand_total_price'] = Currency::formatPrice(
                  Cart::get_price()
                + $_SESSION['shop']['payment_price']
                + $_SESSION['shop']['shipment_price']);
        }
//DBG::log("Shop::update_session(): VAT: ".$_SESSION['shop']['vat_price']);
    }


    /**
     * Set up the subcategories block in the current shop page.
     * @param   integer     $parent_id   The optional parent ShopCategory ID,
     *                                  defaults to 0 (zero).
     * @return  boolean                 True on success, false otherwise
     * @global  array
     */
    static function showCategories($parent_id=0)
    {
        if ($parent_id) {
            $objCategory = ShopCategory::getById($parent_id);
            // If we can't get this ShopCategory, it most probably does
            // not exist.
            if (!$objCategory) {
                // Retry using the root.
                $parent_id = 0;
            } else {
                // Show the parent ShopCategory's image, if available
                $imageName = $objCategory->picture();
                if ($imageName) {
                    self::$objTemplate->setVariable(array(
                        'SHOP_CATEGORY_CURRENT_IMAGE' =>
                            ASCMS_SHOP_IMAGES_WEB_PATH.'/'.$imageName,
                        'SHOP_CATEGORY_CURRENT_IMAGE_ALT' => $objCategory->name(),
                    ));
                }
            }
        }
        // Get all active child categories with parent ID $parent_id
        $arrShopCategory =
            ShopCategories::getChildCategoriesById($parent_id, true);
        if (!is_array($arrShopCategory)) {
            return false;
        }
        $cell = 0;
        $arrDefaultImageSize = false;
        // For all child categories do...
        foreach ($arrShopCategory as $objCategory) {
            $id = $objCategory->id();
            $catName = $objCategory->name();
            $imageName = $objCategory->picture();
            $thumbnailPath = self::$defaultImage;
            $description = $objCategory->description();
            $description = nl2br(htmlentities($description, ENT_QUOTES, CONTREXX_CHARSET));
            $description = preg_replace('/[\n\r]/', '', $description);
            if (empty($arrDefaultImageSize)) {
                $arrDefaultImageSize = getimagesize(ASCMS_PATH.self::$defaultImage);
                self::scaleImageSizeToThumbnail($arrDefaultImageSize);
            }
            $arrSize = $arrDefaultImageSize;
            if (!$imageName) {
                // Look for a picture in the Products.
                $imageName = Products::getPictureByCategoryId($id);
            }
            if (!$imageName) {
                // Look for a picture in the subcategories and their Products.
                $imageName = ShopCategories::getPictureById($id);
            }
            if ($imageName) {
                $thumb_name = ImageManager::getThumbnailFilename($imageName);
                if (file_exists(ASCMS_SHOP_IMAGES_PATH.'/'.$thumb_name)) {
                    // Image found!  Use that instead of the default.
                    $thumbnailPath =
                        ASCMS_SHOP_IMAGES_WEB_PATH.'/'.$thumb_name;
                    $arrSize = getimagesize(ASCMS_PATH.$thumbnailPath);
                    self::scaleImageSizeToThumbnail($arrSize);
                }
            }
            if ($imageName) {
                self::$objTemplate->setVariable(
                    'SHOP_CATEGORY_IMAGE',
                    contrexx_raw2encodedUrl(
                        ASCMS_SHOP_IMAGES_WEB_PATH.'/'.$imageName));
            }
            self::$objTemplate->setVariable(array(
                'SHOP_CATEGORY_ID' => $id,
                'SHOP_CATEGORY_NAME' => htmlentities($catName, ENT_QUOTES, CONTREXX_CHARSET),
                'SHOP_CATEGORY_THUMBNAIL' => contrexx_raw2encodedUrl(
                    $thumbnailPath),
                'SHOP_CATEGORY_THUMBNAIL_SIZE' => $arrSize[3],
                'SHOP_CATEGORY_DESCRIPTION' => $description,
// OBSOLETE since V3.0.0, as are any placeholders for Categories
// containing "PRODUCT"!
//                'SHOP_CATEGORY_DETAILLINK_IMAGE' => 'index.php?section=shop'.MODULE_INDEX.'&amp;catId={SHOP_CATEGORY_ID}',
//                'SHOP_CATEGORY_SUBMIT_FUNCTION' => 'location.replace("index.php?section=shop'.MODULE_INDEX.'&catId='.$id.'")',
//                'SHOP_CATEGORY_SUBMIT_TYPE' => "button",
            ));
            // Add flag images for flagged ShopCategories
            $strImage = '';
            $arrVirtual = ShopCategories::getVirtualCategoryNameArray();
            foreach ($arrVirtual as $strFlag) {
                if ($objCategory->testFlag($strFlag)) {
                    $strImage .=
                        '<img src="images/content/'.$strFlag.
                        '.jpg" alt="'.$strFlag.'" />';
                }
            }
            if ($strImage) {
                self::$objTemplate->setVariable(
                    'SHOP_CATEGORY_FLAG_IMAGE', $strImage
                );
            }
            if (self::$objTemplate->blockExists('subCategories')) {
                self::$objTemplate->parse('subCategories');
                if (++$cell % 4 == 0) {
                    self::$objTemplate->parse('subCategoriesRow');
                }
            }
        }
        return true;
    }


    /**
     * Set up the shop page with products and discounts
     *
     * @return  boolean                      True on success, false otherwise
     * @global  ADONewConnection  $objDatabase    Database connection object
     * @global  array       $_ARRAYLANG     Language array
     * @global  array       $_CONFIG        Core configuration array, see {@link /config/settings.php}
     * @global  string(?)   $themesPages    Themes pages(?)
     */
    static function view_product_overview()
    {
        global $_ARRAYLANG;

        // activate javascript shadowbox
        JS::activate('shadowbox');

        $flagSpecialoffer = intval(SettingDb::getValue('show_products_default'));
        if (isset($_REQUEST['cmd']) && $_REQUEST['cmd'] == 'discounts') {
            $flagSpecialoffer = Products::DEFAULT_VIEW_DISCOUNTS;
        }
        $flagLastFive = isset($_REQUEST['lastFive']);
        $product_id = (isset($_REQUEST['productId'])
            ? intval($_REQUEST['productId']) : null);
        $cart_id = null;
        if (isset($_REQUEST['referer']) && $_REQUEST['referer'] == 'cart') {
            $cart_id = $product_id;
            $product_id = Cart::get_product_id($cart_id);
        }
        $manufacturer_id = (isset($_REQUEST['manufacturerId'])
            ? intval($_REQUEST['manufacturerId']) : null);
        $term = (isset($_REQUEST['term'])
            ? trim(contrexx_input2raw($_REQUEST['term'])) : null);
        $category_id = (isset($_REQUEST['catId'])
            ? intval($_REQUEST['catId']) : null);
        if (!(   $product_id || $category_id || $manufacturer_id
              || $term || $cart_id)) {
            // NOTE: This is different from NULL
            // in that it enables listing the subcategories
            $category_id = 0;
        }
        // Validate parameters
        if ($product_id && empty($category_id)) {
            $objProduct = Product::getById($product_id);
            if ($objProduct) {
                $category_id = $objProduct->category_id();
            }
            if (isset($_SESSION['shop']['previous_category_id'])) {
                $category_id_previous = $_SESSION['shop']['previous_category_id'];
                foreach (preg_split('/\s*,\s*/', $category_id) as $id) {
                    if ($category_id_previous == intval($id)){
                        $category_id = $category_id_previous;
                    }
                }
            }

        }
        $objCategory = null;
        if ($category_id && empty($product_id)) {
            $objCategory = ShopCategory::getById($category_id);
            if (!$objCategory) {
                $category_id = null;
            }
        }
        $shopMenu =
            '<form method="post" action="'.
            Cx\Core\Routing\Url::fromModuleAndCmd('shop', '').'">'.
            '<input type="text" name="term" value="'.
            htmlentities($term, ENT_QUOTES, CONTREXX_CHARSET).
            '" style="width:150px;" />&nbsp;'.
            '<select name="catId" style="width:150px;">'.
            '<option value="0">'.$_ARRAYLANG['TXT_ALL_PRODUCT_GROUPS'].
            '</option>'.ShopCategories::getMenuoptions($category_id).
            '</select>&nbsp;'.Manufacturer::getMenu(
                'manufacturerId', $manufacturer_id, true).
            '<input type="submit" name="bsubmit" value="'.$_ARRAYLANG['TXT_SEARCH'].
            '" style="width:66px;" />'.
            '</form>';
        self::$objTemplate->setGlobalVariable(
            $_ARRAYLANG
          + array(
            'SHOP_MENU' => $shopMenu,
            'SHOP_SEARCH_TERM' => htmlentities($term, ENT_QUOTES, CONTREXX_CHARSET),
            // New from 3.0.0 - More flexible Shop menu
            'SHOP_CATEGORIES_MENUOPTIONS' =>
                ShopCategories::getMenuoptions($category_id, true, 0, true),
            'SHOP_MANUFACTURER_MENUOPTIONS' =>
                Manufacturer::getMenuoptions($manufacturer_id, true),
        ));
        // Only show the cart info when the JS cart is not active!
        global $_CONFIGURATION;
        if (empty ($_CONFIGURATION['custom']['shopJsCart'])) {
            self::$objTemplate->setVariable(array(
                'SHOP_CART_INFO' => self::cart_info(),
            ));
        }
        // Exclude Category list from search results
        if ($term == '') {
            self::showCategories($category_id);
        }
        if (self::$objTemplate->blockExists('shopNextCategoryLink')) {
            $nextCat = ShopCategory::getNextShopCategoryId($category_id);
            $objCategory = ShopCategory::getById($nextCat);
            if ($objCategory) {
                self::$objTemplate->setVariable(array(
                    'SHOP_NEXT_CATEGORY_ID' => $nextCat,
                    'SHOP_NEXT_CATEGORY_TITLE' => str_replace(
                        '"', '&quot;', $objCategory->name()),
                ));
            }
        }
        $pagingCatId = '';
        $pagingManId = '';
        $pagingTerm = '';
// TODO: This probably breaks paging in search results!
// Should only reset the flag conditionally, but add the URL parameters in
// any case, methinks!
        if ($category_id > 0 && $term == '') {
            $flagSpecialoffer = false;
            $pagingCatId = "&amp;catId=$category_id";
        }
        if ($manufacturer_id > 0) {
            $flagSpecialoffer = false;
            $pagingManId =
                "&amp;manufacturer_id=$manufacturer_id";
        }
        if ($term != '') {
            $flagSpecialoffer = false;
            $pagingTerm =
                '&amp;term='.htmlentities($term, ENT_QUOTES, CONTREXX_CHARSET);
        }
        // The Product count is passed by reference and set to the total
        // number of records, though only as many as specified by the core
        // paging limit are returned in the array.
        $limit = SettingDb::getValue('numof_products_per_page_frontend');
// TODO: Use Sorting class for the Product order
        $order = SettingDb::getValue('product_sorting');
        $count = $limit;
        $arrProduct = Products::getByShopParams(
            $count, Paging::getPosition(),
            $product_id, $category_id, $manufacturer_id, $term,
            $flagSpecialoffer, $flagLastFive,
            $order,
            self::$objCustomer && self::$objCustomer->is_reseller()
        );
        if ($count == 0
         && !ShopCategories::getChildCategoryIdArray($category_id)) {
            //if ($term != '' || $manufacturer_id != 0 || $flagSpecialoffer) {
            if (self::$objTemplate->blockExists('no_product')) {
                self::$objTemplate->touchBlock('no_product');
            }
            return true;
        }
        if ($objCategory) {
        // Only indicate the category name when there are products
            if ($count) {
                self::$objTemplate->setVariable(array(
                    // Old, kept for convenience
                    'SHOP_CATEGORY_CURRENT_NAME' =>
                        contrexx_raw2xhtml($objCategory->name()),
                    // New (3.0.0)
                    'SHOP_PRODUCTS_IN_CATEGORY' => sprintf(
                        $_ARRAYLANG['TXT_SHOP_PRODUCTS_IN_CATEGORY'],
                        contrexx_raw2xhtml($objCategory->name())),
                ));
            }
        } else {
// TODO: There are other cases of flag combinations that are not indivuidually
// handled here yet.
            if ($term == '') {
                if ($flagSpecialoffer == Products::DEFAULT_VIEW_DISCOUNTS) {
                    self::$objTemplate->setVariable(
                        'SHOP_PRODUCTS_IN_CATEGORY',
                            $_ARRAYLANG['TXT_SHOP_PRODUCTS_SPECIAL_OFFER']);
                } else {
                    if (self::$objTemplate->blockExists('products_in_category'))
                        self::$objTemplate->hideBlock('products_in_category');
                }
            } else {
                self::$objTemplate->setVariable(
                    'SHOP_PRODUCTS_IN_CATEGORY', sprintf(
                        $_ARRAYLANG['TXT_SHOP_PRODUCTS_SEARCH_RESULTS'],
                        contrexx_raw2xhtml($term)));
            }
        }
        $uri =
// TODO: Use the alias, if any
            '&amp;section=shop'.MODULE_INDEX.
            $pagingCatId.$pagingManId.$pagingTerm;
        self::$objTemplate->setVariable(array(
            'SHOP_PRODUCT_PAGING' => Paging::get($uri, '',
                $count, $limit, ($count > 0)),
            'SHOP_PRODUCT_TOTAL' => $count,
        ));
        // Global microdata: Seller information
        $seller_url =
            \Cx\Core\Routing\Url::fromModuleAndCmd('shop', '')->toString();
        $seller_name = SettingDb::getValue('company');
        if (empty ($seller_name)) $seller_name = $seller_url;
        self::$objTemplate->setVariable(array(
            'SHOP_SELLER_NAME' => $seller_name,
            'SHOP_SELLER_URL' => $seller_url,
        ));
        $formId = 0;
        $arrDefaultImageSize = $arrSize = null;
        foreach ($arrProduct as $objProduct) {
            if (!empty($product_id)) {
                self::$pageTitle = $objProduct->name();
            }
            $id = $objProduct->id();
            $productSubmitFunction = '';
            $arrPictures = Products::get_image_array_from_base64($objProduct->pictures());
            $havePicture = false;
            $arrProductImages = array();
            foreach ($arrPictures as $index => $image) {
                $thumbnailPath = $pictureLink = '';
                if (   empty($image['img'])
                    || $image['img'] == ShopLibrary::noPictureName) {
                    // We have at least one picture on display already.
                    // No need to show "no picture" three times!
                    if ($havePicture) { continue; }
                    $thumbnailPath = self::$defaultImage;
                    $pictureLink = '#'; //"javascript:alert('".$_ARRAYLANG['TXT_NO_PICTURE_AVAILABLE']."');";
                    if (empty($arrDefaultImageSize)) {
                        $arrDefaultImageSize = getimagesize(ASCMS_PATH.self::$defaultImage);
                        self::scaleImageSizeToThumbnail($arrDefaultImageSize);
                    }
                    $arrSize = $arrDefaultImageSize;
                } else {
                    $thumbnailPath = ASCMS_SHOP_IMAGES_WEB_PATH.'/'.
                        ImageManager::getThumbnailFilename($image['img']);
                    if ($image['width'] && $image['height']) {
                        $pictureLink =
                            contrexx_raw2encodedUrl(ASCMS_SHOP_IMAGES_WEB_PATH.'/'.$image['img']).
                            // Hack ahead!
                            '" rel="shadowbox['.($formId+1).']';
                        // Thumbnail display size
                        $arrSize = array($image['width'], $image['height']);
                    } else {
                        $pictureLink = '#';
                        $arrSize = getimagesize(ASCMS_PATH.$thumbnailPath);
                    }
                    self::scaleImageSizeToThumbnail($arrSize);
                    // Use the first available picture in microdata, if any
                    if (!$havePicture) {
                        $picture_url = Cx\Core\Routing\Url::fromCapturedRequest(
                            ASCMS_SHOP_IMAGES_WEB_PATH.'/'.$image['img'],
                            ASCMS_PATH_OFFSET, array());
                        self::$objTemplate->setVariable(
                            'SHOP_PRODUCT_IMAGE', $picture_url->toString());
//\DBG::log("Set image to ".$picture_url->toString());
                    }
                }
                $arrProductImages[] = array(
                    'THUMBNAIL' => contrexx_raw2encodedUrl($thumbnailPath),
                    'THUMBNAIL_SIZE' => $arrSize[3],
                    'THUMBNAIL_LINK' => $pictureLink,
                    'POPUP_LINK' => $pictureLink,
                    'POPUP_LINK_NAME' => $_ARRAYLANG['TXT_SHOP_IMAGE'].' '.$index,
                );
                $havePicture = true;
            }
            $i = 1;
            foreach ($arrProductImages as $arrProductImage) {
// TODO: Instead of several numbered image blocks, use a single one repeatedly
                self::$objTemplate->setVariable(array(
                    'SHOP_PRODUCT_THUMBNAIL_'.$i => $arrProductImage['THUMBNAIL'],
                    'SHOP_PRODUCT_THUMBNAIL_SIZE_'.$i => $arrProductImage['THUMBNAIL_SIZE'],
                ));
                if (!empty($arrProductImage['THUMBNAIL_LINK'])) {
                    self::$objTemplate->setVariable(array(
                        'SHOP_PRODUCT_THUMBNAIL_LINK_'.$i => $arrProductImage['THUMBNAIL_LINK'],
                        'TXT_SEE_LARGE_PICTURE' => $_ARRAYLANG['TXT_SEE_LARGE_PICTURE'],
                    ));
                } else {
                    self::$objTemplate->setVariable(
                        'TXT_SEE_LARGE_PICTURE',
                        contrexx_raw2xhtml($objProduct->name()));
                }
                if ($arrProductImage['POPUP_LINK']) {
                    self::$objTemplate->setVariable(
                        'SHOP_PRODUCT_POPUP_LINK_'.$i, $arrProductImage['POPUP_LINK']
                    );
                }
                self::$objTemplate->setVariable(
                    'SHOP_PRODUCT_POPUP_LINK_NAME_'.$i, $arrProductImage['POPUP_LINK_NAME']
                );
                ++$i;
            }
            $stock = ($objProduct->stock_visible()
                ? $_ARRAYLANG['TXT_STOCK'].': '.intval($objProduct->stock())
                : '');
            $price = $objProduct->get_custom_price(
                self::$objCustomer,
                0,    // No options yet
                1,    // Apply discount for one article
                true  // Ignore special offers
            );
            // If there is a discountprice and it's enabled
            $discountPrice = '';
            if (   $objProduct->discountprice() > 0
                && $objProduct->discount_active()) {
                $price = '<s>'.$price.'</s>';
                $discountPrice = $objProduct->get_custom_price(
                    self::$objCustomer,
                    0,    // No options yet
                    1,    // Apply discount for one article
                    false // Consider special offers
                );
            }

            $groupCountId = $objProduct->group_id();
            $groupArticleId = $objProduct->article_id();
            $groupCustomerId = 0;
            if (self::$objCustomer) {
                $groupCustomerId = self::$objCustomer->group_id();
            }
            self::showDiscountInfo(
                $groupCustomerId, $groupArticleId, $groupCountId, 1
            );
/* OLD
            $price = Currency::getCurrencyPrice(
                $objProduct->getCustomerPrice(self::$objCustomer)
            );
            $discountPrice = '';
            $discount_active = $objProduct->discount_active();
            if ($discount_active) {
                $discountPrice = $objProduct->discountprice();
                if ($discountPrice > 0) {
                    $price = "<s>$price</s>";
                    $discountPrice =
                        Currency::getCurrencyPrice($discountPrice);
                }
            }
*/
            $short = $objProduct->short();
            $longDescription = $objProduct->long();

            $detailLink = null;
            // Detaillink is required for microdata (even when longdesc
            // is empty)
            $detail_url = \Cx\Core\Routing\Url::fromModuleAndCmd(
                'shop', 'details', FRONTEND_LANG_ID,
                array('productId' => $objProduct->id()))->toString();
            self::$objTemplate->setVariable(
                'SHOP_PRODUCT_DETAIL_URL', $detail_url);
            if (!$product_id && !empty($longDescription)) {
                $detailLink =
// TODO: Use the alias, if any
                '<a href="'.$detail_url.'"'.
                ' title="'.$_ARRAYLANG['TXT_MORE_INFORMATIONS'].'">'.
                $_ARRAYLANG['TXT_MORE_INFORMATIONS'].'</a>';
                self::$objTemplate->setVariable(
                    'SHOP_PRODUCT_DETAILLINK', $detailLink);
            }

            // Check Product flags.
            // Only the meter flag is currently implemented and in use.
            $flagMeter = $objProduct->testFlag('__METER__');

            // Submit button name and function.
            // Calling productOptions() also sets the $flagMultipart variable
            // to the appropriate encoding type for the form if
            // any upload fields are in use.
            $flagMultipart = false;
            $productSubmitName = $productSubmitFunction = '';
            if (isset($_GET['cmd']) && $_GET['cmd'] == 'details'
             && isset($_GET['referer']) && $_GET['referer'] == 'cart') {
                $productSubmitName = "updateProduct[$cart_id]";
                $productSubmitFunction = self::productOptions(
                    $id, $formId, $cart_id, $flagMultipart
                );
            } else {
                $productSubmitName = 'addProduct';
                $productSubmitFunction = self::productOptions(
                    $id, $formId, $cart_id, $flagMultipart
                );
            }
            $shopProductFormName = "shopProductForm$formId";
            $row = $formId % 2 + 1;
            self::$objTemplate->setVariable(array(
                'SHOP_ROWCLASS' => 'row'.$row,
                'SHOP_PRODUCT_ID' => $objProduct->id(),
                'SHOP_PRODUCT_TITLE' => contrexx_raw2xhtml($objProduct->name()),
                'SHOP_PRODUCT_DESCRIPTION' => $short,
// TODO: Test whether this produces double descriptions in some views
                'SHOP_PRODUCT_DETAILDESCRIPTION' => ($longDescription
                    ? $longDescription : $short),
                'SHOP_PRODUCT_FORM_NAME' => $shopProductFormName,
                'SHOP_PRODUCT_SUBMIT_NAME' => $productSubmitName,
                'SHOP_PRODUCT_SUBMIT_FUNCTION' => $productSubmitFunction,
                'SHOP_FORM_ENCTYPE' =>
                    ($flagMultipart ? ' enctype="multipart/form-data"' : ''),
                // Meter flag
                'TXT_SHOP_PRODUCT_COUNT' =>
                    ($flagMeter
                        ? $_ARRAYLANG['TXT_SHOP_PRODUCT_METER']
                        : $_ARRAYLANG['TXT_SHOP_PRODUCT_COUNT']
                    ),
                'SHOP_CURRENCY_CODE' => Currency::getActiveCurrencyCode(),
            ));
            if ($objProduct->code()) {
                self::$objTemplate->setVariable(
                    'SHOP_PRODUCT_CUSTOM_ID', htmlentities(
                        $objProduct->code(), ENT_QUOTES, CONTREXX_CHARSET));
            }
            $manufacturer_name = $manufacturer_url = $manufacturer_link = '';
            $manufacturer_id = $objProduct->manufacturer_id();
            if ($manufacturer_id) {
                $manufacturer_name =
                    Manufacturer::getNameById($manufacturer_id, FRONTEND_LANG_ID);
                $manufacturer_url =
                    Manufacturer::getUrlById($manufacturer_id, FRONTEND_LANG_ID);
            }
            if (!empty($manufacturer_url) || !empty($manufacturer_name)) {
                if (empty($manufacturer_name)) {
                    $manufacturer_name = $manufacturer_url;
                }
                if (!empty($manufacturer_url)) {
                    $manufacturer_link =
                        '<a href="'.$manufacturer_url.'">'.
                        $manufacturer_name.'</a>';
                }
// TODO: Test results for any combination of name and url
                self::$objTemplate->setVariable(array(
                    'SHOP_MANUFACTURER_NAME' => $manufacturer_name,
                    'SHOP_MANUFACTURER_URL' => $manufacturer_url,
                    'SHOP_MANUFACTURER_LINK' => $manufacturer_link,
                    'TXT_SHOP_MANUFACTURER_LINK' => $_ARRAYLANG['TXT_SHOP_MANUFACTURER_LINK'],
                ));
            }

            // This is the old Product field for the Manufacturer URI.
            // This is now extended by the Manufacturer table and should thus
            // get a new purpose.  As it is product specific, it could be
            // renamed and reused as a link to individual Products!
            $externalLink = $objProduct->uri();
            if (!empty($externalLink)) {
                self::$objTemplate->setVariable(array(
                    'SHOP_EXTERNAL_LINK' =>
                    '<a href="'.$externalLink.
                    '" title="'.$_ARRAYLANG['TXT_SHOP_EXTERNAL_LINK'].
                    '" target="_blank">'.
                    $_ARRAYLANG['TXT_SHOP_EXTERNAL_LINK'].'</a>',
                ));
            }

            if ($price) {
                self::$objTemplate->setGlobalVariable(array(
                    'SHOP_PRODUCT_PRICE' => $price,
                    'SHOP_PRODUCT_PRICE_UNIT' => Currency::getActiveCurrencySymbol(),
                ));
            }
            // Only show the discount price if it's actually in use,
            // avoid an "empty <font> tag" HTML warning
            if ($discountPrice) {
                self::$objTemplate->setGlobalVariable(array(
                    'SHOP_PRODUCT_DISCOUNTPRICE' => $discountPrice,
                    'SHOP_PRODUCT_DISCOUNTPRICE_UNIT' => Currency::getActiveCurrencySymbol(),
                ));
                if (self::$objTemplate->blockExists('price_discount'))
                    self::$objTemplate->touchBlock('price_discount');
            } else {
                if (self::$objTemplate->blockExists('price'))
                    self::$objTemplate->touchBlock('price');
            }
            // Special outlet ShopCategory with discounts varying daily.
            // This should be implemented in a more generic way, in the
            // Discount class maybe.
            if ($objProduct->is_outlet()) {
                self::$objTemplate->setVariable(array(
                    'TXT_SHOP_DISCOUNT_TODAY' =>
                        $_ARRAYLANG['TXT_SHOP_DISCOUNT_TODAY'],
                    'SHOP_DISCOUNT_TODAY' =>
                        $objProduct->getOutletDiscountRate().'%',
                    'TXT_SHOP_PRICE_TODAY' =>
                        $_ARRAYLANG['TXT_SHOP_PRICE_TODAY'],
                    'SHOP_PRICE_TODAY' =>
                        Currency::getCurrencyPrice(
                            $objProduct->getDiscountedPrice()
                        ),
                    'SHOP_PRICE_TODAY_UNIT' =>
                        Currency::getActiveCurrencySymbol(),
                ));
            }
            if ($objProduct->stock_visible()) {
                self::$objTemplate->setVariable(array(
                    'SHOP_PRODUCT_STOCK' => $stock,
                ));
            }
            if ($detailLink) {
                self::$objTemplate->setVariable(array(
                    'SHOP_PRODUCT_DETAILLINK' => $detailLink,
                ));
            }
            $distribution = $objProduct->distribution();
            $weight = '';
            if ($distribution == 'delivery') {
                $weight = $objProduct->weight();
            }

            // Hide the weight if it is zero or disabled in the configuration
            if (   $weight > 0
                && SettingDb::getValue('weight_enable')) {
                self::$objTemplate->setVariable(array(
                    'TXT_SHOP_PRODUCT_WEIGHT' => $_ARRAYLANG['TXT_SHOP_PRODUCT_WEIGHT'],
                    'SHOP_PRODUCT_WEIGHT' => Weight::getWeightString($weight),
                ));
            }
            if (Vat::isEnabled()) {
                self::$objTemplate->setVariable(array(
                    'SHOP_PRODUCT_TAX_PREFIX' =>
                        (Vat::isIncluded()
                            ? $_ARRAYLANG['TXT_SHOP_VAT_PREFIX_INCL']
                            : $_ARRAYLANG['TXT_SHOP_VAT_PREFIX_EXCL']
                         ),
                    'SHOP_PRODUCT_TAX' =>
                        Vat::getShort($objProduct->vat_id())
                ));
            }

            // Add flag images for flagged Products
            $strImage = '';
            $strFlags = $objProduct->flags();
            $arrVirtual = ShopCategories::getVirtualCategoryNameArray(FRONTEND_LANG_ID);
            foreach (explode(' ', $strFlags) as $strFlag) {
                if (in_array($strFlag, $arrVirtual)) {
                    $strImage .=
                        '<img src="images/content/'.$strFlag.
                        '.jpg" alt="'.$strFlag.'" />';
                }
            }
            if ($strImage) {
                self::$objTemplate->setVariable(
                    'SHOP_PRODUCT_FLAG_IMAGE', $strImage
                );
            }
            if (self::$objTemplate->blockExists('shopProductRow')) {
                self::$objTemplate->parse('shopProductRow');
            }
            ++$formId;
        }
        return true;
    }


    /**
     * Sets up a Product list in the given template string with all Products
     * taken from the Category with the given ID
     *
     * Changes the $_REQUEST array temporarily and calls
     * {@see view_product_overview()}, then restores the original request.
     * On failure, the empty string is returned.
     * @param   string      $objTemplate    The template string
     * @param   integer     $category_id    The Category ID
     * @return  string                      The filled template string
     *                                      on success, the empty string
     *                                      otherwise
     */
    static function get_products_block($content, $category_id)
    {
        global $objInit, $_ARRAYLANG;

        $_ARRAYLANG += $objInit->loadLanguageData('shop');
        if (!SettingDb::init('shop', 'config')) return false;
        $original_REQUEST = &$_REQUEST;
        self::$objTemplate = new \Cx\Core\Html\Sigma();
        self::$objTemplate->setTemplate($content);
        // You might add more parameters here!
        $_REQUEST = array('catId' => $category_id);
        $result = self::view_product_overview();
        $_REQUEST = &$original_REQUEST;
        if (!$result) {
            return ''; // You might want the original $content back, maybe?
        }
        $content = self::$objTemplate->get();
        return $content;
    }


    /**
     * Set up the HTML elements for all the Product Attributes of any Product.
     *
     * The following types of Attributes are supported:
     * 0    Dropdown menu, customers may select no (the default) or one option.
     * 1    Radio buttons, customers need to select one option.
     * 2    Checkboxes, customers may select no, one or several options.
     * 3    Dropdown menu, customers need to select one option.
     * 4    Optional text field
     * 5    Mandatory text field
     * 6    Optional file upload field
     * 7    Mandatory file upload field
     * Types 1 and 3 are functionally identical, they only differ by
     * the kind of widget being used.
     * The individual Product Attributes carry a unique ID enabling the
     * JavaScript code contained within the Shop page to verify that
     * all mandatory choices have been made before any Product can
     * be added to the cart.
     * @param   integer     $product_id     The Product ID
     * @param   string      $formName       The name of the HTML form containing
     *                                      the Product and options
     * @param   integer     $cart_id        The optional cart Product ID,
     *                                      null if not applicable.
     * @param   boolean     $flagUpload     If a product has an upload
     *                                      Attribute associated with it,
     *                                      this parameter will be set to true
     * @return  string                      The string with the HTML code
     */
    static function productOptions($product_id, $formName, $cart_id=null,
        &$flagUpload=false
    ) {
        global $_ARRAYLANG;

//DBG::log("productOptions($product_id, $formName, $cart_id, $flagUpload): Entered");
        // Semicolon separated list of Attribute name IDs to verify
        // before the Product is added to the cart
        $checkOptionIds = '';
        // check if the product option block exists in the template
        if (   self::$objTemplate->blockExists('shopProductOptionsRow')
            && self::$objTemplate->blockExists('shopProductOptionsValuesRow')) {
            $domId = 0;
            $count = 0;
            $arrAttributes = Attributes::getArray(
                $count, null, null, '`ord` ASC', array('product_id' => $product_id));
//DBG::log("Attributes: ".var_export($arrAttributes, true));
            // When there are no Attributes for this Product, hide the
            // options blocks
            if (empty($arrAttributes)) {
                self::$objTemplate->hideBlock('shopProductOptionsRow');
                self::$objTemplate->hideBlock('shopProductOptionsValuesRow');
            } else {
                // Loop through the Attribute Names for the Product
                foreach ($arrAttributes as $attribute_id => $objAttribute) {
                    $mandatory = false;
                    $arrOptions = Attributes::getOptionArrayByAttributeId($attribute_id);
                    $arrRelation = Attributes::getRelationArray($product_id);
                    // This attribute does not apply for this product
                    if (empty($arrRelation)) continue;
                    $selectValues = '';
                    // create head of option menu/checkbox/radiobutton
                    switch ($objAttribute->getType()) {
                      case Attribute::TYPE_CHECKBOX:
                      case Attribute::TYPE_TEXT_OPTIONAL:
                      case Attribute::TYPE_UPLOAD_OPTIONAL:
                      case Attribute::TYPE_TEXTAREA_OPTIONAL:
                      case Attribute::TYPE_EMAIL_OPTIONAL:
                      case Attribute::TYPE_EMAIL_OPTIONAL:
                      case Attribute::TYPE_URL_OPTIONAL:
                      case Attribute::TYPE_DATE_OPTIONAL:
                      case Attribute::TYPE_NUMBER_INT_OPTIONAL:
                      case Attribute::TYPE_NUMBER_FLOAT_OPTIONAL:
                        // No container nor hidden field for optional types
                        break;
                      case Attribute::TYPE_MENU_OPTIONAL:
                        // There is no hidden input field here either,
                        // but the dropdown menu container
                        $selectValues =
                            '<select name="productOption['.$attribute_id.
                            ']" id="productOption-'.
                            $product_id.'-'.$attribute_id.'-'.$domId.
                            '" style="width:180px;">'."\n".
                            '<option value="0">'.
                            $objAttribute->getName().'&nbsp;'.
                            $_ARRAYLANG['TXT_CHOOSE']."</option>\n";
                        break;
                      case Attribute::TYPE_RADIOBUTTON:
                      case Attribute::TYPE_TEXT_MANDATORY:
                      case Attribute::TYPE_UPLOAD_MANDATORY:
                      case Attribute::TYPE_TEXTAREA_MANDATORY:
                      case Attribute::TYPE_EMAIL_MANDATORY:
                      case Attribute::TYPE_URL_MANDATORY:
                      case Attribute::TYPE_DATE_MANDATORY:
                      case Attribute::TYPE_NUMBER_INT_MANDATORY:
                      case Attribute::TYPE_NUMBER_FLOAT_MANDATORY:
                        $mandatory = true;
                        // The Attribute name, indicating a mandatory option.
                        $selectValues =
                            '<input type="hidden" id="productOption-'.
                            $product_id.'-'.$attribute_id.
                            '" value="'.$objAttribute->getName().'" />'."\n";
                        // The Attribute verification regex, if applicable
                        $regex = Attribute::getVerificationRegex(
                            $objAttribute->getType());
                        if ($regex != '') {
                            $selectValues .=
                                '<input type="hidden" id="attributeVerification-'.
                                $product_id.'-'.$attribute_id.
                                '" value="'.$regex.'" />'."\n";
                        }
                        $checkOptionIds .= "$attribute_id;";
                        break;
                      case Attribute::TYPE_MENU_MANDATORY:
                        $selectValues =
                            '<input type="hidden" id="productOption-'.
                            $product_id.'-'.$attribute_id.
                            '" value="'.$objAttribute->getName().'" />'."\n".
                            '<select name="productOption['.$attribute_id.
                            ']" id="productOption-'.
                            $product_id.'-'.$attribute_id.'-'.$domId.
                            '" style="width:180px;">'."\n".
                            // If there is only one option to choose from,
                            // why bother the customer at all?
// NOTE: To always prepend the default "please choose" option, comment the condition
                            (count($arrOptions) > 1
                                ? '<option value="0">'.
                                  $objAttribute->getName().'&nbsp;'.
                                  $_ARRAYLANG['TXT_CHOOSE']."</option>\n"
                                : ''
                            );
                        $checkOptionIds .= "$attribute_id;";
                        break;
                    }

                    $i = 0;
                    foreach ($arrOptions as $option_id => $arrOption) {
                        // This option does not apply to this product
                        if (!isset($arrRelation[$option_id])) continue;
                        $option_price = '';
                        $selected = false;
                        // Show the price only if non-zero
                        if ($arrOption['price'] != 0) {
                            $option_price =
                                '&nbsp;('.Currency::getCurrencyPrice($arrOption['price']).
                                '&nbsp;'.Currency::getActiveCurrencySymbol().')';
                        }
                        // mark the option value as selected if it was before
                        // and this page was requested from the cart
                        if (isset($cart_id)) {
                            $options = Cart::get_options_array($cart_id, $attribute_id);
                            if (   is_array($options)
                                && in_array($option_id, $options))
                                $selected = true;
                        }
                        // create option menu/checkbox/radiobutton
                        switch ($objAttribute->getType()) {
                          case Attribute::TYPE_MENU_OPTIONAL:
                            $selectValues .=
                                '<option value="'.$option_id.'" '.
                                ($selected ? 'selected="selected"' : '').
                                ' >'.$arrOption['value'].$option_price.
                                "</option>\n";
                            break;
                          case Attribute::TYPE_RADIOBUTTON:
                            $selectValues .=
                                '<input type="radio" name="productOption['.
                                $attribute_id.']" id="productOption-'.
                                $product_id.'-'.$attribute_id.'-'.$domId.
                                '" value="'.$option_id.'"'.
                                ($selected ? ' checked="checked"' : '').
                                ' /><label for="productOption-'.
                                $product_id.'-'.$attribute_id.'-'.$domId.
                                '">&nbsp;'.$arrOption['value'].$option_price.
                                "</label><br />\n";
                            break;
                          case Attribute::TYPE_CHECKBOX:
                            $selectValues .=
                                '<input type="checkbox" name="productOption['.
                                $attribute_id.']['.$i.']" id="productOption-'.
                                $product_id.'-'.$attribute_id.'-'.$domId.
                                '" value="'.$option_id.'"'.
                                ($selected ? ' checked="checked"' : '').
                                ' /><label for="productOption-'.
                                $product_id.'-'.$attribute_id.'-'.$domId.
                                '">&nbsp;'.$arrOption['value'].$option_price.
                                "</label><br />\n";
                            break;
                          case Attribute::TYPE_MENU_MANDATORY:
                            $selectValues .=
                                '<option value="'.$option_id.'"'.
                                ($selected ? ' selected="selected"' : '').
                                ' >'.$arrOption['value'].$option_price.
                                "</option>\n";
                            break;
                          case Attribute::TYPE_TEXT_OPTIONAL:
                          case Attribute::TYPE_TEXT_MANDATORY:
//                            $option_price = '&nbsp;';
                            $selectValues .=
                                '<input type="text" name="productOption['.$attribute_id.
                                ']" id="productOption-'.$product_id.'-'.$attribute_id.'-'.$domId.
                                '" value="'.$arrOption['value'].'" style="width:180px;" />'.
                                '<label for="productOption-'.$product_id.'-'.$attribute_id.'-'.$domId.'">'.
                                $option_price."</label><br />\n";
                            break;

                          case Attribute::TYPE_EMAIL_OPTIONAL:
                          case Attribute::TYPE_EMAIL_MANDATORY:
//                            $option_price = '&nbsp;';
                            $selectValues .=
                                '<input type="text" name="productOption['.$attribute_id.
                                ']" id="productOption-'.$product_id.'-'.$attribute_id.'-'.$domId.
                                '" value="'.$arrOption['value'].'" style="width:180px;" />'.
                                '<label for="productOption-'.$product_id.'-'.$attribute_id.'-'.$domId.'">'.
                                $option_price."</label><br />\n";
                            break;
                          case Attribute::TYPE_URL_OPTIONAL:
                          case Attribute::TYPE_URL_MANDATORY:
//                            $option_price = '&nbsp;';
                            $selectValues .=
                                '<input type="text" name="productOption['.$attribute_id.
                                ']" id="productOption-'.$product_id.'-'.$attribute_id.'-'.$domId.
                                '" value="'.$arrOption['value'].'" style="width:180px;" />'.
                                '<label for="productOption-'.$product_id.'-'.$attribute_id.'-'.$domId.'">'.
                                $option_price."</label><br />\n";
                            break;
                          case Attribute::TYPE_DATE_OPTIONAL:
                          case Attribute::TYPE_DATE_MANDATORY:
//                            $option_price = '&nbsp;';
                            // Passed by reference
                            $element_id =
                                'productOption-'.$product_id.'-'.
                                $attribute_id.'-'.$domId;
                            $selectValues .=
                                Html::getDatepicker(
                                    'productOption['.$attribute_id.']',
                                    array(
                                        'defaultDate' => $arrOption['value'],
                                    ),
                                    'style="width:180px;"', $element_id).
                                '<label for="productOption-'.$product_id.'-'.
                                    $attribute_id.'-'.$domId.'">'.
                                $option_price."</label><br />\n";
                            break;
                          case Attribute::TYPE_NUMBER_INT_OPTIONAL:
                          case Attribute::TYPE_NUMBER_INT_MANDATORY:
//                            $option_price = '&nbsp;';
                            $selectValues .=
                                '<input type="text" name="productOption['.$attribute_id.
                                ']" id="productOption-'.$product_id.'-'.$attribute_id.'-'.$domId.
                                '" value="'.$arrOption['value'].'" style="width:180px;" />'.
                                '<label for="productOption-'.$product_id.'-'.$attribute_id.'-'.$domId.'">'.
                                $option_price."</label><br />\n";
                            break;
                          case Attribute::TYPE_NUMBER_FLOAT_OPTIONAL:
                          case Attribute::TYPE_NUMBER_FLOAT_MANDATORY:
//                            $option_price = '&nbsp;';
                            $selectValues .=
                                '<input type="text" name="productOption['.$attribute_id.
                                ']" id="productOption-'.$product_id.'-'.$attribute_id.'-'.$domId.
                                '" value="'.$arrOption['value'].'" style="width:180px;" />'.
                                '<label for="productOption-'.$product_id.'-'.$attribute_id.'-'.$domId.'">'.
                                $option_price."</label><br />\n";
                            break;
                          case Attribute::TYPE_UPLOAD_OPTIONAL:
                          case Attribute::TYPE_UPLOAD_MANDATORY:
//                            $option_price = '&nbsp;';
                            $selectValues .=
                                '<input type="file" name="productOption['.$attribute_id.
                                ']" id="productOption-'.$product_id.'-'.$attribute_id.'-'.$domId.
                                '" style="width:180px;" />'.
                                '<label for="productOption-'.$product_id.'-'.$attribute_id.'-'.$domId.'">'.
                                $option_price."</label><br />\n";
                            break;
                          case Attribute::TYPE_TEXTAREA_OPTIONAL:
                          case Attribute::TYPE_TEXTAREA_MANDATORY:
//                            $valuePrice = '&nbsp;';
                            $selectValues .=
                                '<textarea name="productOption['.$attribute_id.
                                ']" id="productOption-'.$product_id.'-'.$attribute_id.'-'.$domId.
                                '" style="width:300px;">'.
                                contrexx_input2xhtml($arrOption['value']).
                                '</textarea>'.
                                '<label for="productOption-'.$product_id.'-'.$attribute_id.'-'.$domId.'">'.
                                $option_price."</label><br />\n";
                            break;
                        }
                        ++$i;
                        ++$domId;
                    }
                    // create foot of option menu/checkbox/radiobutton
                    switch ($objAttribute->getType()) {
                        case Attribute::TYPE_MENU_OPTIONAL:
                            $selectValues .= "</select><br />";
                            break;
                        case Attribute::TYPE_RADIOBUTTON:
                            $selectValues .= "<br />";
                            break;
                        case Attribute::TYPE_CHECKBOX:
                            $selectValues .= "";
                            break;
                        case Attribute::TYPE_MENU_MANDATORY:
                            $selectValues .= "</select><br />";
                            break;
                        // Set enctype in form if one of these is present
                        case Attribute::TYPE_UPLOAD_OPTIONAL:
                        case Attribute::TYPE_UPLOAD_MANDATORY:
                            // Avoid code analyzer warning
                            $flagUpload = true || $flagUpload;
                            break;
/* Nothing to to
                        case Attribute::TYPE_TEXT_OPTIONAL:
                        case Attribute::TYPE_TEXT_MANDATORY:
                        case Attribute::TYPE_TEXTAREA_OPTIONAL:
                        case Attribute::TYPE_TEXTAREA_MANDATORY:
                        case Attribute::TYPE_EMAIL_OPTIONAL:
                        case Attribute::TYPE_EMAIL_MANDATORY:
                        case Attribute::TYPE_URL_OPTIONAL:
                        case Attribute::TYPE_URL_MANDATORY:
                        case Attribute::TYPE_DATE_OPTIONAL:
                        case Attribute::TYPE_DATE_MANDATORY:
                        case Attribute::TYPE_NUMBER_INT_OPTIONAL:
                        case Attribute::TYPE_NUMBER_INT_MANDATORY:
                        case Attribute::TYPE_NUMBER_FLOAT_OPTIONAL:
                        case Attribute::TYPE_NUMBER_FLOAT_MANDATORY:
*/
                    }
                    $selectValues .= "\n";
                    self::$objTemplate->setVariable(array(
                        // pre-version 1.1 spelling error fixed
                        // left old spelling for comatibility (obsolete)
                        'SHOP_PRODCUT_OPTION' => $selectValues,
                        'SHOP_PRODUCT_OPTION' => $selectValues,
                        'SHOP_PRODUCT_OPTIONS_NAME' => $objAttribute->getName(),
                        'SHOP_PRODUCT_OPTIONS_TITLE' =>
                            '<a href="javascript:{}" onclick="toggleOptions('.
                            $product_id.', this)" title="'.
                            $_ARRAYLANG['TXT_OPTIONS'].'">'.
                            $_ARRAYLANG['TXT_OPTIONS']."</a>\n",
                    ));
                    if ($mandatory
                     && self::$objTemplate->blockExists(
                            'product_attribute_mandatory')) {
                        self::$objTemplate->touchBlock(
                            'product_attribute_mandatory');
                    }
                    self::$objTemplate->parse('shopProductOptionsValuesRow');
                }
                self::$objTemplate->parse('shopProductOptionsRow');
            }
        }
        return
            "return checkProductOption('shopProductForm$formName', ".
            "$product_id, '".
            substr($checkOptionIds, 0, strlen($checkOptionIds)-1)."');";
    }


    /**
     * The view of the discounted Products only
     *
     * Calls {@see view_product_overview()}, which in turn checks the value of the cmd
     * request parameter, and sets up Product query parameters accordingly.
     * @return  boolean             True on success, false otherwise
     */
    static function discounts()
    {
        return self::view_product_overview();
    }


    /**
     * Returns the shipping cost converted to the active currency.
     *
     * @param   integer $shipperId   The ID of the selected shipper
     * @param   double  $price       The total order value
     * @param   integer $weight      The total order weight in grams
     * @return  double               The shipping cost in the customers' currency
     */
    static function _calculateShipmentPrice($shipperId, $price, $weight)
    {
        $shipmentPrice = Shipment::calculateShipmentPrice(
            $shipperId, $price, $weight
        );
        return Currency::getCurrencyPrice($shipmentPrice);
    }


    /**
     * Returns the actual payment fee according to the payment ID and
     * the total order price.
     *
     * @internal    A lot of this belongs to the Payment class.
     * @param       integer     $payment_id The payment ID
     * @param       double      $totalPrice The total order price
     * @return      string                  The payment fee, formatted by
     *                                      {@link Currency::getCurrencyPrice()}
     */
    static function _calculatePaymentPrice($payment_id, $totalPrice)
    {
        $paymentPrice = 0;
        if (!$payment_id) return $paymentPrice;
        if (  Payment::getProperty($payment_id, 'free_from') == 0
           || $totalPrice < Payment::getProperty($payment_id, 'free_from')) {
            $paymentPrice = Payment::getProperty($payment_id, 'fee');
        }
        return Currency::getCurrencyPrice($paymentPrice);
    }


    /**
     * Registers Javascript used by the shop
     *
     * If at least one Product has an upload field Attribute associated
     * with it, the $flagUpload parameter *MUST* be set to true.  Note that this
     * will force the respective product form to use mutipart/form-data encoding
     * and disable the JSON cart for the complete page.
     * //@param   boolean $flagUpload         Force the POST cart to be used if true
     * @global  array   $_ARRAYLANG         Language array
     * @global  array   $_CONFIGURATION     Core configuration array, see {@link /config/settings.php}
     * @todo    Reimplement the $flagUpload parameter
     */
    static function registerJavascriptCode()//$flagUpload=false)
    {
        global $_ARRAYLANG;//, $_CONFIGURATION;

        // needed for cart
        JS::activate('cx');
        JS::activate('jquery');

// Update prices with options included
// TODO Also consider Customer type (reseller, final customer)
        ContrexxJavascript::getInstance()->setVariable('TXT_SHOP_PRODUCT_ADDED_TO_CART', $_ARRAYLANG['TXT_SHOP_PRODUCT_ADDED_TO_CART'], 'shop');
        ContrexxJavascript::getInstance()->setVariable('TXT_SHOP_CONFIRM_DELETE_PRODUCT', $_ARRAYLANG['TXT_SHOP_CONFIRM_DELETE_PRODUCT'], 'shop');
        ContrexxJavascript::getInstance()->setVariable('TXT_MAKE_DECISION_FOR_OPTIONS', $_ARRAYLANG['TXT_MAKE_DECISION_FOR_OPTIONS'], 'shop');
        JS::registerJS(ASCMS_MODULE_WEB_PATH . '/shop/js/shop.js');
    }


    /**
     * Catch-all error handling
     *
     * This should be used as a last resort only.
     * Blames the database in a Message, and returns nothing.
     */
    static function errorHandling()
    {
        global $_ARRAYLANG;

        Message::error($_ARRAYLANG['TXT_SHOP_DATABASE_QUERY_ERROR']);
    }


    /**
     * Authenticate a Customer
     *
     * @global  ADONewConnection  $objDatabase    Database connection object
     * @return  boolean                 True if the Customer could be
     *                                  authenticated successfully,
     *                                  false otherwise.
     * @access private
     */
    private static function _authenticate()
    {
        if (self::$objCustomer) return true;
        $objUser = FWUser::getFWUserObject()->objUser;
        
        if ($objUser->login()) {
            self::$objCustomer = Customer::getById($objUser->getId());
            if (self::$objCustomer) {
                // This is still required in confirm() (TODO: remove)
                $_SESSION['shop']['username'] = self::$objCustomer->username();
                $_SESSION['shop']['email'] = self::$objCustomer->email();
//DBG::log("Shop::_authenticate(): Success! (".self::$objCustomer->firstname().' '.self::$objCustomer->lastname().', '.self::$objCustomer->username().', email '.self::$objCustomer->email().")");
                $_SESSION->cmsSessionUserUpdate(self::$objCustomer->id());
                return true;
            }
        }
//DBG::log("Shop::_authenticate(): Failed!");
        return false;
    }


    static function _gotoLoginPage()
    {
        // go to the next step
        if (isset($_POST['continue'])) {
            \CSRF::redirect(
                Cx\Core\Routing\Url::fromModuleAndCmd('shop', 'login'));
        }
    }


    /**
     * Show the login page
     *
     * Redirects to the appropriate page, if necessary.
     * Verifies and handles requests for (not) registering as a customer.
     * @global  array   $_ARRAYLANG Language array
     * @see     _authenticate(), is_auth()
     * @return  boolean             True, except when redirecting
     */
    static function login()
    {
        global $_ARRAYLANG;

        if (   isset($_POST['bnoaccount'])
            && SettingDb::getValue('register') != self::REGISTER_MANDATORY) {
            $_SESSION['shop']['dont_register'] = true;
        } else {
            $_SESSION['shop']['dont_register'] = false;
        }
// TODO: Even though no one can register herself, there still might
// be registered Customers already!
//        if (SettingDb::getValue('register') == self::REGISTER_NONE) {
//            \CSRF::redirect(
//                Cx\Core\Routing\Url::fromModuleAndCmd('shop', 'account'));
//        }
        if (   isset($_POST['baccount'])
            || isset($_POST['bnoaccount'])
            || self::verify_account(true) // Silent, no messages here!
        ) {
            \CSRF::redirect(
                Cx\Core\Routing\Url::fromModuleAndCmd('shop', 'account'));
        }
        if (isset($_POST['blogin'])) {
            \CSRF::redirect(
                Cx\Core\Routing\Url::fromModuleAndCmd('shop', 'login').
                '?redirect='.
                base64_encode(
                    Cx\Core\Routing\Url::fromModuleAndCmd('shop', 'account')));
        }
        if (self::_authenticate()) {
            \CSRF::redirect(
                Cx\Core\Routing\Url::fromModuleAndCmd('shop', 'account'));
        }
        $redirect = base64_encode(
            Cx\Core\Routing\Url::fromModuleAndCmd('shop', 'account'));
        if (isset($_REQUEST['redirect'])) {
            $redirect = contrexx_input2raw($_REQUEST['redirect']);
        }
        self::$objTemplate->setGlobalVariable($_ARRAYLANG
          + array(
          'SHOP_LOGIN_REDIRECT' => base64_encode(
            Cx\Core\Routing\Url::fromModuleAndCmd('shop', 'account'))
        ));
        switch (SettingDb::getValue('register')) {
            case self::REGISTER_MANDATORY:
                if (self::$objTemplate->blockExists('register'))
                    self::$objTemplate->touchBlock('register');
                break;
            case self::REGISTER_NONE:
                self::$objTemplate->setGlobalVariable(
                    'TXT_SHOP_ACCOUNT_NOTE',
                    $_ARRAYLANG['TXT_SHOP_ACCOUNT_NOTE_NO_REGISTRATION']);
                if (self::$objTemplate->blockExists('dont_register'))
                self::$objTemplate->touchBlock('dont_register');
                break;
            case self::REGISTER_OPTIONAL:
                if (self::$objTemplate->blockExists('register'))
                    self::$objTemplate->touchBlock('register');
                if (self::$objTemplate->blockExists('dont_register'))
                    self::$objTemplate->touchBlock('dont_register');
                break;
        }
        return true;
    }


    /**
     * OBSOLETE, use core_modules/login.
     * Redirects to another page iff the Customer is logged in
     *
     * Returns the redirection target when no Customer ist logged in.
     * The default target for the redirect is the account page.
     * Other targets may be specified using the redirect parameter.
     * @return  string          The redirection target, if any
     */
    static function processRedirect()
    {
die("Shop::processRedirect(): This method is obsolete!");
/*
        $redirect = (isset($_REQUEST['redirect']) ? $_REQUEST['redirect'] : '');
        // The Customer object is initialized upon successful authentication.
        if (!self::$objCustomer) return $redirect;
        // Redirect if the login has completed successfully
        // General redirects, base64 encoded
        if (!empty($redirect)) {
            $decodedRedirect = base64_decode($redirect);
            if (!empty($decodedRedirect)) {
                \CSRF::redirect('index.php?'.$decodedRedirect);
            }
        }
        // Default: Redirect to the account page
// TODO: Use the slug
        \CSRF::redirect('index.php?section=shop&cmd=account');
*/
    }


    static function view_account()
    {
        global $_ARRAYLANG;

        // hide currency navbar
        self::$show_currency_navbar = false;
        self::account_to_session();
        // Only verify the form after it has been posted
        if (isset($_POST['lastname'])) {
            if (self::verify_account()) self::_gotoPaymentPage();
        }
        JS::activate('jquery');
        self::$objTemplate->setGlobalVariable($_ARRAYLANG);
        // Use the details stored in the database as default.
        // Once the (changed) values are posted back, they are stored
        // in the session
        $company = (isset($_SESSION['shop']['company'])
            ? $_SESSION['shop']['company']
            : (self::$objCustomer ? self::$objCustomer->company() : ''));
        $gender = (isset($_SESSION['shop']['gender'])
            ? $_SESSION['shop']['gender']
            : (self::$objCustomer ? self::$objCustomer->gender() : ''));
        $lastname = (isset($_SESSION['shop']['lastname'])
            ? $_SESSION['shop']['lastname']
            : (self::$objCustomer ? self::$objCustomer->lastname() : ''));
        $firstname = (isset($_SESSION['shop']['firstname'])
            ? $_SESSION['shop']['firstname']
            : (self::$objCustomer ? self::$objCustomer->firstname() : ''));
        $address = (isset($_SESSION['shop']['address'])
            ? $_SESSION['shop']['address']
            : (self::$objCustomer ? self::$objCustomer->address() : ''));
        $zip = (isset($_SESSION['shop']['zip'])
            ? $_SESSION['shop']['zip']
            : (self::$objCustomer ? self::$objCustomer->zip() : ''));
        $city = (isset($_SESSION['shop']['city'])
            ? $_SESSION['shop']['city']
            : (self::$objCustomer ? self::$objCustomer->city() : ''));
        $country_id = (isset($_SESSION['shop']['countryId'])
            ? $_SESSION['shop']['countryId']
            : (self::$objCustomer ? self::$objCustomer->country_id() : 0));
        $email = (isset($_SESSION['shop']['email'])
            ? $_SESSION['shop']['email']
            : (self::$objCustomer ? self::$objCustomer->email() : ''));
        $phone = (isset($_SESSION['shop']['phone'])
            ? $_SESSION['shop']['phone']
            : (self::$objCustomer ? self::$objCustomer->phone() : ''));
        $fax = (isset($_SESSION['shop']['fax'])
            ? $_SESSION['shop']['fax']
            : (self::$objCustomer ? self::$objCustomer->fax() : ''));
        self::$objTemplate->setVariable(array(
            'SHOP_ACCOUNT_COMPANY' => htmlentities($company, ENT_QUOTES, CONTREXX_CHARSET),
            'SHOP_ACCOUNT_PREFIX' => Customers::getGenderMenuoptions($gender),
            'SHOP_ACCOUNT_LASTNAME' => htmlentities($lastname, ENT_QUOTES, CONTREXX_CHARSET),
            'SHOP_ACCOUNT_FIRSTNAME' => htmlentities($firstname, ENT_QUOTES, CONTREXX_CHARSET),
            'SHOP_ACCOUNT_ADDRESS' => htmlentities($address, ENT_QUOTES, CONTREXX_CHARSET),
            'SHOP_ACCOUNT_ZIP' => htmlentities($zip, ENT_QUOTES, CONTREXX_CHARSET),
            'SHOP_ACCOUNT_CITY' => htmlentities($city, ENT_QUOTES, CONTREXX_CHARSET),
            'SHOP_ACCOUNT_PHONE' => htmlentities($phone, ENT_QUOTES, CONTREXX_CHARSET),
            'SHOP_ACCOUNT_FAX' => htmlentities($fax, ENT_QUOTES, CONTREXX_CHARSET),
            'SHOP_ACCOUNT_ACTION' =>
                Cx\Core\Routing\Url::fromModuleAndCmd('shop', 'account'),
            // New template - since 2.1.0
            'SHOP_ACCOUNT_COUNTRY_MENUOPTIONS' =>
                Country::getMenuoptions($country_id, true),
            // Old template
            // Compatibility with 2.0 and older versions
            'SHOP_ACCOUNT_COUNTRY' => Country::getMenu('countryId', $country_id),
        ));
        $register = SettingDb::getValue('register');

/**
 * @internal  Heavy logic ahead!
 * Some optional parts are visible only in certain cases:
 * - When the setting "register" is set to "optional":
 *   - Checkbox "Don't register"
 * - When no Customer is logged in:
 *   - Input "E-mail"
 *   - When registration is mandatory, or if optional and "Don't register"
 *     is unchecked:
 *     - Input "Password"
 * Here's an overview of all cases:
 * ----------------------------------------------------------------
 *           |     Optional parts visible when registration is
 * Customer  |        off        |     optional      |  mandatory
 * ----------------------------------------------------------------
 * Logged in |         -         |         -         |      -
 *           | (Accounts may     |                   |
 *           | still be created  |                   |
 *           | in the backend)   |                   |
 * ----------------------------------------------------------------
 * Guest     | "E-mail"          | "E-mail",         | "E-mail"
 *           |                   | Checkbox          | Input
 *           | (Noone can        | "Don't register"; | "Password"
 *           | register)         | If not checked:   |
 *           |                   | Input "Password"  |
 * ----------------------------------------------------------------
 * Notes:
 *  - "Don't register" is only parsed into the page when applicable, namely
 *    in the combination "guest/optional".
 *  - "Password" is parsed into the page along with the "E-Mail" field,
 *    but hidden when not applicable.
 */
        $block_password = false;
        $dontRegisterChecked = false;
        // Touches the entire surrounding block
        self::$objTemplate->setVariable(
            'SHOP_ACCOUNT_EMAIL', contrexx_raw2xhtml($email));
        if (!self::$objCustomer) {
            if ($register == ShopLibrary::REGISTER_OPTIONAL) {
//DBG::log("Shop::view_account(): Optional -> e-mail, touch 'dont_register'");
                self::$objTemplate->touchBlock('dont_register');
                if (empty($_SESSION['shop']['dont_register'])) {
//DBG::log("Shop::view_account(): Register -> block password");
                    $block_password = true;
                } else {
                    $dontRegisterChecked = true;
                }
            }
            if ($register == ShopLibrary::REGISTER_NONE) {
                $_SESSION['shop']['dont_register'] = true;
            }
            if ($register == ShopLibrary::REGISTER_MANDATORY) {
//DBG::log("Shop::view_account(): Mandatory/None -> div password");
                $block_password = true;
            }
        } else {
//DBG::log("Shop::view_account(): Got Customer -> no block");
        }
//DBG::log("Shop::view_account(): block_password ".var_export($block_password, true));
        self::$objTemplate->setGlobalVariable(array(
            'SHOP_ACCOUNT_PASSWORD_DISPLAY' => ($block_password
                ? Html::CSS_DISPLAY_BLOCK : Html::CSS_DISPLAY_NONE),
            'SHOP_DONT_REGISTER_CHECKED' =>
                $dontRegisterChecked ? Html::ATTRIBUTE_CHECKED : '',
            'TXT_SHOP_ACCOUNT_PASSWORD_HINT' => AccessLib::getPasswordInfo(),
        ));
        if (!Cart::needs_shipment()) {
            return;
        }
        if (!isset($_SESSION['shop']['equal_address'])) {
            $_SESSION['shop']['equal_address'] = true;
        }
        self::$objTemplate->setVariable(array(
            'SHOP_ACCOUNT_COMPANY2' => (empty($_SESSION['shop']['company2'])
                ? '' : htmlentities($_SESSION['shop']['company2'], ENT_QUOTES, CONTREXX_CHARSET)),
            'SHOP_ACCOUNT_PREFIX2' => Customers::getGenderMenuoptions(
                empty($_SESSION['shop']['gender2'])
                    ? '' : $_SESSION['shop']['gender2']),
            'SHOP_ACCOUNT_LASTNAME2' => (empty($_SESSION['shop']['lastname2'])
                ? '' : htmlentities($_SESSION['shop']['lastname2'], ENT_QUOTES, CONTREXX_CHARSET)),
            'SHOP_ACCOUNT_FIRSTNAME2' => (empty($_SESSION['shop']['firstname2'])
                ? '' : htmlentities($_SESSION['shop']['firstname2'], ENT_QUOTES, CONTREXX_CHARSET)),
            'SHOP_ACCOUNT_ADDRESS2' => (empty($_SESSION['shop']['address2'])
                ? '' : htmlentities($_SESSION['shop']['address2'], ENT_QUOTES, CONTREXX_CHARSET)),
            'SHOP_ACCOUNT_ZIP2' => (empty($_SESSION['shop']['zip2'])
                ? '' : htmlentities($_SESSION['shop']['zip2'], ENT_QUOTES, CONTREXX_CHARSET)),
            'SHOP_ACCOUNT_CITY2' => (empty($_SESSION['shop']['city2'])
                ? '' : htmlentities($_SESSION['shop']['city2'], ENT_QUOTES, CONTREXX_CHARSET)),
            'SHOP_ACCOUNT_COUNTRY2' =>
                Country::getNameById($_SESSION['shop']['countryId2']),
            'SHOP_ACCOUNT_COUNTRY2_ID' => $_SESSION['shop']['countryId2'],
            'SHOP_ACCOUNT_PHONE2' => (empty($_SESSION['shop']['phone2'])
                ? '' : htmlentities($_SESSION['shop']['phone2'], ENT_QUOTES, CONTREXX_CHARSET)),
            // Compatibility -- old name
            'SHOP_ACCOUNT_EQUAL_ADDRESS' => (empty($_SESSION['shop']['equal_address'])
                ? '' : Html::ATTRIBUTE_CHECKED),
            // Compatibility -- new name
            'SHOP_EQUAL_ADDRESS_CHECKED' => (empty($_SESSION['shop']['equal_address'])
                ? '' : Html::ATTRIBUTE_CHECKED),
            'SHOP_SHIPPING_ADDRESS_DISPLAY' => (empty($_SESSION['shop']['equal_address'])
                ? Html::CSS_DISPLAY_BLOCK : Html::CSS_DISPLAY_NONE),
        ));
    }


    /**
     * Copies data posted from the account form to the session
     *
     * Returns immediately unless the form has been posted indeed.
     * Considers the state of the "equal address" flag.
     * Copies the shipment country to the billing address unless the latter
     * is set.
     */
    static function account_to_session()
    {
//DBG::log("account_to_session(): POST: ".var_export($_POST, true));
        if (empty($_POST) || !is_array($_POST)) return;
//DBG::log("Shop::account_to_session(): Have POST");
        foreach ($_POST as $key => $value) {
            $_SESSION['shop'][$key] =
                trim(strip_tags(contrexx_input2raw($value)));
        }
        if (   empty($_SESSION['shop']['gender2'])
            || empty($_SESSION['shop']['lastname2'])
            || empty($_SESSION['shop']['firstname2'])
            || empty($_SESSION['shop']['address2'])
            || empty($_SESSION['shop']['zip2'])
            || empty($_SESSION['shop']['city2'])
            || empty($_SESSION['shop']['phone2'])
            || empty($_SESSION['shop']['countryId2'])
        ) {
            $_SESSION['shop']['equal_address'] = false;
        } elseif (!empty($_POST['equal_address'])) {
            // Copy address
            $_SESSION['shop']['company2'] = $_SESSION['shop']['company'];
            $_SESSION['shop']['gender2'] = $_SESSION['shop']['gender'];
            $_SESSION['shop']['lastname2'] = $_SESSION['shop']['lastname'];
            $_SESSION['shop']['firstname2'] = $_SESSION['shop']['firstname'];
            $_SESSION['shop']['address2'] = $_SESSION['shop']['address'];
            $_SESSION['shop']['zip2'] = $_SESSION['shop']['zip'];
            $_SESSION['shop']['city2'] = $_SESSION['shop']['city'];
            $_SESSION['shop']['phone2'] = $_SESSION['shop']['phone'];
            $_SESSION['shop']['countryId2'] = $_SESSION['shop']['countryId'];
            $_SESSION['shop']['equal_address'] = true;
        }
        if (empty($_SESSION['shop']['countryId'])) {
            // countryId2 is set in Cart::init() already
            $_SESSION['shop']['countryId'] = $_SESSION['shop']['countryId2'];
        }
        // Fill missing arguments with empty strings
        if (empty($_SESSION['shop']['company2']))   $_SESSION['shop']['company2'] = '';
        if (empty($_SESSION['shop']['gender2']))    $_SESSION['shop']['gender2'] = '';
        if (empty($_SESSION['shop']['lastname2']))  $_SESSION['shop']['lastname2'] = '';
        if (empty($_SESSION['shop']['firstname2'])) $_SESSION['shop']['firstname2'] = '';
        if (empty($_SESSION['shop']['address2']))   $_SESSION['shop']['address2'] = '';
        if (empty($_SESSION['shop']['zip2']))       $_SESSION['shop']['zip2'] = '';
        if (empty($_SESSION['shop']['city2']))      $_SESSION['shop']['city2'] = '';
        if (empty($_SESSION['shop']['phone2']))     $_SESSION['shop']['phone2'] = '';
        if (empty($_SESSION['shop']['countryId2'])) $_SESSION['shop']['countryId2'] = 0;
    }


    /**
     * Verifies the account data present in the session
     * @param   boolean     $silent     If true, no messages are created.
     *                                  Defaults to false
     * @return  boolean                 True if the account data is complete
     *                                  and valid, false otherwise
     */
    static function verify_account($silent=false)
    {
        global $_ARRAYLANG;

//DBG::log("Verify account");
        $status = true;
//DBG::log("POST: ".  var_export($_POST, true));
        if (isset($_POST) && !self::verifySessionAddress()) {
            if ($silent) return false;
            $status = Message::error(
                $_ARRAYLANG['TXT_FILL_OUT_ALL_REQUIRED_FIELDS']);
        }
        // Registered Customers are okay now
        if (self::$objCustomer) return $status;
        if (   SettingDb::getValue('register') == ShopLibrary::REGISTER_MANDATORY
            || (   SettingDb::getValue('register') == ShopLibrary::REGISTER_OPTIONAL
                && empty($_SESSION['shop']['dont_register']))) {
            if (   isset($_SESSION['shop']['password'])
                && !User::isValidPassword($_SESSION['shop']['password'])) {
                if ($silent) return false;
                global $objInit;
                $objInit->loadLanguageData('access');
                $status = Message::error(AccessLib::getPasswordInfo());
            }
        } else {
            // User is not trying to register, so she doesn't need a password.
            // Mind that this is necessary in order to avoid passwords filled
            // in automatically by the browser, which may be wrong, or
            // invalid, or both.
            $_SESSION['shop']['password'] = NULL;
        }
        if (   isset($_SESSION['shop']['email'])
            && !FWValidator::isEmail($_SESSION['shop']['email'])) {
            if ($silent) return false;
            $status = Message::error($_ARRAYLANG['TXT_INVALID_EMAIL_ADDRESS']);
        }
        if (!$status) {
            return false;
        }
        if (isset($_SESSION['shop']['email'])) {
            // Ignore "unregistered" Customers.  These will silently be updated
            if (Customer::getUnregisteredByEmail($_SESSION['shop']['email'])) {
                return true;
            }
            $objUser = new User();
            $objUser->setUsername($_SESSION['shop']['email']);
            $objUser->setEmail($_SESSION['shop']['email']);
            Message::save();
            // This method will set an error message we don't want here
            // (as soon as it uses the Message class, that is)
            if (!($objUser->validateUsername() && $objUser->validateEmail())) {
//DBG::log("Shop::verify_account(): Username or e-mail in use");
                Message::restore();
                $_POST['email'] = $_SESSION['shop']['email'] = NULL;
                if ($silent) return false;
            return Message::error(sprintf(
                $_ARRAYLANG['TXT_EMAIL_USED_BY_OTHER_CUSTOMER'],
                Cx\Core\Routing\Url::fromModuleAndCmd('shop', 'login').
                '?redirect='.base64_encode(
                    Cx\Core\Routing\Url::fromModuleAndCmd('shop', 'account'))))
                || Message::error(sprintf(
                $_ARRAYLANG['TXT_SHOP_GOTO_SENDPASS'],
                Cx\Core\Routing\Url::fromModuleAndCmd('shop', 'sendpass')));
            }
            Message::restore();
        }
        return $status;
    }


    /**
     * Redirects to the page following the account view
     *
     * If the cart is empty, redirects to the shop start page, or the
     * category viewed previously, if known.
     * If there is no payment view, redirects to the confirmation directly.
     * Mind that there *MUST* be a default payment and shipment set in the
     * latter case!
     * @todo    Make sure there are proper payment and shipment IDs set in
     *          the session!
     */
    static function _gotoPaymentPage()
    {
        if (Cart::is_empty()) {
            \CSRF::redirect(
                Cx\Core\Routing\Url::fromModuleAndCmd('shop', '', '',
                    (intval($_SESSION['shop']['previous_category_id']) > 0
                        ? 'catId='.
                            intval($_SESSION['shop']['previous_category_id'])
                        : '')));
        }
        if (!isset($_SESSION['shop']['note'])) {
            $_SESSION['shop']['note'] = '';
        }
        if (!isset($_SESSION['shop']['agb'])) {
            $_SESSION['shop']['agb'] = '';
        }
        if (!isset($_SESSION['shop']['cancellation_terms'])) {
            $_SESSION['shop']['cancellation_terms'] = '';
        }
        // Since 3.1.0
        $page_repository = Env::em()->getRepository('Cx\Core\ContentManager\Model\Entity\Page');
        if ($page_repository->findOneByModuleCmdLang(
            'shop', 'payment', FRONTEND_LANG_ID)) {
            \CSRF::redirect(
                Cx\Core\Routing\Url::fromModuleAndCmd('shop', 'payment'));
        }
        \CSRF::redirect(
            Cx\Core\Routing\Url::fromModuleAndCmd('shop', 'confirm'));
    }


    /**
     * Set up payment page including dropdown menus for shipment and payment options.
     * @return  void
     * @link    _getShipperMenu
     * @link    _initPaymentDetails
     * @link    _getPaymentMenu
     * @link    update_session
     * @link    verify_payment_details
     * @link    view_payment
     */
    static function payment()
    {
        if (!self::verifySessionAddress()) {
            \CSRF::redirect(
                Cx\Core\Routing\Url::fromModuleAndCmd('shop', ''));
        }
        // Call that first, because the _initPaymentDetails method requires the
        // Shipment ID which it stores in the session array.
        self::_getShipperMenu();
        self::_initPaymentDetails();
        // Will redirect to the confirmation page if all payment and shipment
        // data is complete
        self::verify_payment_details();
        self::view_payment();
    }


    static function _initPaymentDetails()
    {
        // Uses the active currency
        $cart_amount = Cart::get_price();
        // The Payment ID must be known and up to date when the cart is
        // parsed in order to consider payment dependent Coupons
        if (isset($_POST['paymentId']))
            $_SESSION['shop']['paymentId'] = intval($_POST['paymentId']);
        // Determine any valid value for it
        if (   $cart_amount
            && empty($_SESSION['shop']['paymentId'])) {
            $arrPaymentId = Payment::getCountriesRelatedPaymentIdArray(
                $_SESSION['shop']['countryId'], Currency::getCurrencyArray());
            $_SESSION['shop']['paymentId'] = current($arrPaymentId);
        }
        if (empty($_SESSION['shop']['paymentId']))
            $_SESSION['shop']['paymentId'] = null;
        // hide currency navbar
        self::$show_currency_navbar = false;
        if (isset($_POST['customer_note']))
            $_SESSION['shop']['note'] =
                trim(strip_tags(contrexx_input2raw($_POST['customer_note'])));
        if (isset($_POST['agb']))
            $_SESSION['shop']['agb'] = Html::ATTRIBUTE_CHECKED;
        if (isset($_POST['cancellation_terms']))
            $_SESSION['shop']['cancellation_terms'] = Html::ATTRIBUTE_CHECKED;
        // if shipperId is not set, there is no use in trying to determine a shipment_price
        if (isset($_SESSION['shop']['shipperId'])) {
            $shipmentPrice = self::_calculateShipmentPrice(
                $_SESSION['shop']['shipperId'],
                Cart::get_price(),
                Cart::get_weight()
            );
            // anything wrong with this kind of shipping?
            if ($shipmentPrice == -1) {
                unset($_SESSION['shop']['shipperId']);
                $_SESSION['shop']['shipment_price'] = '0.00';
            } else {
                $_SESSION['shop']['shipment_price'] = $shipmentPrice;
            }
        } else {
            $_SESSION['shop']['shipment_price'] = '0.00';
        }
        $_SESSION['shop']['payment_price'] =
            self::_calculatePaymentPrice(
                $_SESSION['shop']['paymentId'],
                $cart_amount
            );
        Cart::update(self::$objCustomer);
        self::update_session();
    }


    /**
     * Determines the shipper ID to be used, if any, stores it in
     * $_SESSION['shop']['shipperId'], and returns the shipment dropdown menu.
     * If no shipping is desired, returns an empty string.
     *
     * - If Cart::needs_shipment() evaluates to true:
     *   - If $_SESSION['shop']['shipperId'] is set, it is changed to the value
     *     of the shipment ID returned in $_POST['shipperId'], if the latter is set.
     *   - Otherwise, sets $_SESSION['shop']['shipperId'] to the default value
     *     obtained by calling {@see Shipment::getCountriesRelatedShippingIdArray()}
     *     with the country ID found in $_SESSION['shop']['countryId2'].
     *   - Returns the shipment dropdown menu as returned by
     *     {@see Shipment::getShipperMenu()}.
     * - If Cart::needs_shipment() evaluates to false, does nothing, but simply
     *   returns an empty string.
     * @return  string  Shipment dropdown menu, or an empty string
     */
    static function _getShipperMenu()
    {
        // Only show the menu if shipment is needed and the ship-to
        // country is known
        if (   !Cart::needs_shipment()
            || empty($_SESSION['shop']['countryId2'])) {
            $_SESSION['shop']['shipperId'] = null;
            return '';
        }
        // Choose a shipment in this order from
        // - post, if present,
        // - session, if present,
        // - none.
        if (   empty($_SESSION['shop']['shipperId'])
            || isset($_POST['shipperId'])) {
            $_SESSION['shop']['shipperId'] =
                (isset($_POST['shipperId'])
                  ? intval($_POST['shipperId'])
                  : (isset($_SESSION['shop']['shipperId'])
                      ? $_SESSION['shop']['shipperId'] : 0
                    )
                );
        }
        // If no shipment has been chosen yet, set the default
        // as the selected one.
// TODO: This is not the solution.  The value posted by the form should
// actually be verified, and an error message be displayed if it's invalid.
        if (empty($_SESSION['shop']['shipperId'])) {
            // Get available shipment IDs
            $arrShipmentId = Shipment::getCountriesRelatedShippingIdArray(
                $_SESSION['shop']['countryId2']);
            // First is the default shipment ID
            $_SESSION['shop']['shipperId'] = current($arrShipmentId);
        }
        $menu = Shipment::getShipperMenu(
            $_SESSION['shop']['countryId2'],
            $_SESSION['shop']['shipperId'],
            "document.forms['shopForm'].submit()"
        );
        return $menu;
    }


    /**
     * Determines the payment ID to be used, if any, stores it in
     * $_SESSION['shop']['paymentId'], and returns the payment dropdown menu.
     * If there is nothing to pay (products or shipping), returns an empty string.
     *
     * - If Cart::needs_shipment() evaluates to true, and Cart::get_price()
     *   is greater than zero:
     *   - If $_SESSION['shop']['paymentId'] is set, it is changed to the value
     *     of the paymentId ID returned in $_POST['paymentId'], if the latter is set.
     *   - Otherwise, sets $_SESSION['shop']['paymentId'] to the first value
     *     found in $arrPaymentId {@see Payment::getCountriesRelatedPaymentIdArray()}
     *     with the country ID found in $_SESSION['shop']['countryId'].
     *   - Returns the payment dropdown menu as returned by
     *     {@see Payment::getPaymentMenu()}.
     * - If no shipment is necessary, or the order amount is zero (or less),
     *   does nothing, but simply returns the empty string.
     * @return  string  Payment dropdown menu, or an empty string
     */
    static function get_payment_menu()
    {
        if (   !Cart::needs_shipment()
            && Cart::get_price() <= 0) {
            $_SESSION['shop']['paymentId'] = null;
            return '';
        }
        if (isset($_POST['paymentId'])) {
            $_SESSION['shop']['paymentId'] = intval($_POST['paymentId']);
        }
        if (empty($_SESSION['shop']['paymentId'])) {
            // Use the first Payment ID
            $arrPaymentId = Payment::getCountriesRelatedPaymentIdArray(
                $_SESSION['shop']['countryId'], Currency::getCurrencyArray()
            );
            $_SESSION['shop']['paymentId'] = current($arrPaymentId);
        }
        return Payment::getPaymentMenu(
            $_SESSION['shop']['paymentId'],
            "document.forms['shopForm'].submit()",
            $_SESSION['shop']['countryId']
        );
    }


    static function verify_payment_details()
    {
        global $_ARRAYLANG;

        if (empty($_POST['check'])) return true;

        // if it is the internal_lsv payment processor, store the sent data into
        // session
        if (self::processor_name() == 'internal_lsv') {
            if (!empty($_POST['account_holder']))
                $_SESSION['shop']['account_holder'] = contrexx_input2raw($_POST['account_holder']);
            if (!empty($_POST['account_bank']))
                $_SESSION['shop']['account_bank'] = contrexx_input2raw($_POST['account_bank']);
            if (!empty($_POST['account_blz']))
                $_SESSION['shop']['account_blz'] = contrexx_input2raw($_POST['account_blz']);
        }

        $status = true;
        // Payment status is true, if either
        // - the total price (including VAT and shipment) is zero (or less!?), or
        // - the paymentId is set and valid, and the LSV status evaluates to true.
        // luckily, shipping, VAT, and price have been handled in update_session()
        // above already, so we'll only have to check grand_total_price
        if (   $_SESSION['shop']['grand_total_price'] > 0
            && (   empty($_SESSION['shop']['paymentId'])
                || (   self::processor_name() == 'Internal_LSV'
                    && !self::lsv_complete()))) {
//DBG::log("Shop::verify_payment_details(): Payment missing!");
            $status = false;
            Message::error($_ARRAYLANG['TXT_FILL_OUT_ALL_REQUIRED_FIELDS']);
        }
        // Shipment status is true, if either
        // - no shipment is desired, or
        // - the shipperId is set already (and the shipment conditions were validated)
        if (Cart::needs_shipment()) {
//DBG::log("Shop::verify_payment_details(): Shipment necessary");
            if (empty($_SESSION['shop']['shipperId'])) {
//DBG::log("Shop::verify_payment_details(): Shipment missing!");
                // Ask the Customer to pick a different Shipper if none is
                // selected or it did not work
                $status = false;
                Message::error($_ARRAYLANG['TXT_SHIPPER_NO_GOOD']);
            }
        }
        // AGB status is true, if either
        // - the agb placeholder does not exist
        // - the agb checkbox has been checked
        if (!(self::$objTemplate->placeholderExists('SHOP_AGB')
            ? (!empty($_POST['agb']) ? true : false) : true)) {
//DBG::log("Shop::verify_payment_details(): AGB missing!");
            $status = false;
            Message::error($_ARRAYLANG['TXT_ACCEPT_AGB']);
        }
        // Ditto for cancellation terms
        if (!(self::$objTemplate->placeholderExists(
                'SHOP_CANCELLATION_TERMS_CHECKED')
            ? (!empty($_POST['cancellation_terms']) ? true : false) : true)) {
//DBG::log("Shop::verify_payment_details(): cancellation terms missing!");
            $status = false;
            Message::error($_ARRAYLANG['TXT_SHOP_CANCELLATION_TERMS_PLEASE_ACCEPT']);
        }
        if ($status) {
            // Everything is set and valid
            \CSRF::redirect(
                Cx\Core\Routing\Url::fromModuleAndCmd('shop', 'confirm'));
        }
        // Something is missing od invalid
        return false;
    }


    static function processor_name()
    {
        // Added initializing of the payment processor below
        // in order to determine whether to show the LSV form.
        $processor_id = 0;
        $processor_name = '';
        if (!empty($_SESSION['shop']['paymentId']))
            $processor_id = Payment::getPaymentProcessorId($_SESSION['shop']['paymentId']);
        if (!empty($processor_id))
            $processor_name = PaymentProcessing::getPaymentProcessorName($processor_id);
        return $processor_name;
    }


    /**
     * Set up the LSV partial view (internal LSV form provider)
     *
     * Returns immediately if LSV is not the selected payment type.
     * Currently, this is implemented as an optional part of the payment view.
     * @global  array   $_ARRAYLANG     Language array
     */
    static function viewpart_lsv()
    {
        global $_ARRAYLANG;

//DBG::log("Shop::viewpart_lsv(): Entered");

        if (self::processor_name() != 'internal_lsv') return;
        self::$objTemplate->setGlobalVariable($_ARRAYLANG);
        self::$objTemplate->setVariable(array(
            'SHOP_ACCOUNT_HOLDER' => (isset($_SESSION['shop']['account_holder'])
                ? $_SESSION['shop']['account_holder'] : ''),
            'SHOP_ACCOUNT_BANK' => (isset($_SESSION['shop']['account_bank'])
                ? $_SESSION['shop']['account_bank'] : ''),
            'SHOP_ACCOUNT_BLZ' => (isset($_SESSION['shop']['account_blz'])
                ? $_SESSION['shop']['account_blz'] : ''),
        ));
    }


    /**
     * Returns true if complete LSV information is present in the session
     * @return  boolean         True if LSV information is complete,
     *                          false otherwise
     */
    static function lsv_complete()
    {
        return !empty($_SESSION['shop']['account_holder'])
            && !empty($_SESSION['shop']['account_bank'])
            && !empty($_SESSION['shop']['account_blz']);
    }


    /**
     * Set up the "lsv_form" page with the user information form for LSV
     *
     * @todo		Fill in the order summary automatically.
     * @todo		Problem: If the order is big enough, it may not fit into the
     *  visible text area, thus causing some order items to be cut off
     *  when printed.  This issue should be resolved by replacing the
     *  <textarea> with a variable height element, such as a table, or
     *  a div.
     * @global  ADONewConnection  $objDatabase    Database connection object
     * @global  array   $_ARRAYLANG     Language array
     */
    static function view_lsv_form()
    {
        global $_ARRAYLANG;

        self::$objTemplate->setGlobalVariable($_ARRAYLANG);
        self::$objTemplate->setVariable(array(
            'SHOP_CUSTOMER_TITLE' => (isset($_SESSION['shop']['gender'])
                ? contrexx_raw2xhtml($_SESSION['shop']['gender']) : ''),
            'SHOP_CUSTOMER_FIRST_NAME' => (isset($_SESSION['shop']['firstname'])
                ? contrexx_raw2xhtml($_SESSION['shop']['firstname']) : ''),
            'SHOP_CUSTOMER_LAST_NAME' => (isset($_SESSION['shop']['lastname'])
                ? contrexx_raw2xhtml($_SESSION['shop']['lastname']) : ''),
            'SHOP_CUSTOMER_ADDRESS' => (isset($_SESSION['shop']['address'])
                ? contrexx_raw2xhtml($_SESSION['shop']['address']) : ''),
            'SHOP_CUSTOMER_ZIP' => (isset($_SESSION['shop']['zip'])
                ? contrexx_raw2xhtml($_SESSION['shop']['zip']) : ''),
            'SHOP_CUSTOMER_CITY' => (isset($_SESSION['shop']['city'])
                ? contrexx_raw2xhtml($_SESSION['shop']['city']) : ''),
            'SHOP_CUSTOMER_PHONE' => (isset($_SESSION['shop']['phone'])
                ? contrexx_raw2xhtml($_SESSION['shop']['phone']) : ''),
            'SHOP_CUSTOMER_FAX' => (isset($_SESSION['shop']['fax'])
                ? contrexx_raw2xhtml($_SESSION['shop']['fax']) : ''),
            'SHOP_CUSTOMER_EMAIL' => (isset($_SESSION['shop']['email'])
                ? contrexx_raw2xhtml($_SESSION['shop']['email']) : ''),
            //'SHOP_LSV_EE_PRODUCTS' => '',
            'SHOP_CUSTOMER_BANK' => (isset($_SESSION['shop']['account_bank'])
                ? contrexx_raw2xhtml($_SESSION['shop']['account_bank']) : ''),
            'SHOP_CUSTOMER_BANKCODE' => (isset($_SESSION['shop']['account_blz'])
                ? contrexx_raw2xhtml($_SESSION['shop']['account_blz']) : ''),
            'SHOP_CUSTOMER_ACCOUNT' => '', // not available
            'SHOP_DATE' => date(ASCMS_DATE_FORMAT_DATE),
            'SHOP_FAX' => contrexx_raw2xhtml(SettingDb::getValue('fax')),
            'SHOP_COMPANY' => contrexx_raw2xhtml(
                SettingDb::getValue('company')),
            'SHOP_ADDRESS' => contrexx_raw2xhtml(
                preg_replace('/[\012\015]+/', ', ',
                    SettingDb::getValue('address'))),
        ));
    }


    /**
     * The payment and shipment selection view
     * @return  void
     */
    static function view_payment()
    {
        global $_ARRAYLANG;

        self::$objTemplate->setGlobalVariable($_ARRAYLANG);
        if (   Cart::get_weight() > 0
            && SettingDb::getValue('weight_enable')) {
            self::$objTemplate->setVariable(array(
                'SHOP_TOTAL_WEIGHT' => Weight::getWeightString(Cart::get_weight()),
            ));
        }
        if (!Cart::needs_shipment()) {
            unset($_SESSION['shop']['shipperId']);
        } else {
            self::$objTemplate->setVariable(array(
                'SHOP_SHIPMENT_PRICE' => Currency::formatPrice(
                    $_SESSION['shop']['shipment_price']),
                'SHOP_SHIPMENT_MENU' => self::_getShipperMenu(),
            ));
        }
        if (   Cart::get_price()
            || $_SESSION['shop']['shipment_price']
            || $_SESSION['shop']['vat_price']) {
            self::$objTemplate->setVariable(array(
                'SHOP_PAYMENT_PRICE' => Currency::formatPrice(
                    $_SESSION['shop']['payment_price']),
                'SHOP_PAYMENT_MENU' => self::get_payment_menu(),
            ));
        }
        if (empty($_SESSION['shop']['coupon_code'])) {
            $_SESSION['shop']['coupon_code'] = '';
        }
        $total_discount_amount = 0;
        if (Cart::get_discount_amount()) {
            $total_discount_amount = Cart::get_discount_amount();
            self::$objTemplate->setVariable(array(
                'SHOP_DISCOUNT_COUPON_TOTAL' =>
                    $_ARRAYLANG['TXT_SHOP_DISCOUNT_COUPON_AMOUNT_TOTAL'],
                'SHOP_DISCOUNT_COUPON_TOTAL_AMOUNT' =>
                    Currency::formatPrice(-$total_discount_amount),
            ));
        }
        // Show the Coupon code field only if there is at least one defined
        if (Coupon::count_available()) {
            self::$objTemplate->setVariable(array(
                'SHOP_DISCOUNT_COUPON_CODE' => $_SESSION['shop']['coupon_code'],
            ));
        }
        self::$objTemplate->setVariable(array(
            'SHOP_UNIT' => Currency::getActiveCurrencySymbol(),
            'SHOP_TOTALITEM' => Cart::get_item_count(),
            'SHOP_TOTALPRICE' => Currency::formatPrice(
                  Cart::get_price()
                + Cart::get_discount_amount()),
            'SHOP_GRAND_TOTAL' => Currency::formatPrice(
                  $_SESSION['shop']['grand_total_price']),
            'SHOP_CUSTOMERNOTE' => $_SESSION['shop']['note'],
            'SHOP_AGB' => $_SESSION['shop']['agb'],
            'SHOP_CANCELLATION_TERMS_CHECKED' => $_SESSION['shop']['cancellation_terms'],
        ));
        if (Vat::isEnabled()) {
            self::$objTemplate->setVariable(array(
                'SHOP_TAX_PRICE' =>
                    $_SESSION['shop']['vat_price'].
                    '&nbsp;'.Currency::getActiveCurrencySymbol(),
                'SHOP_TAX_PRODUCTS_TXT' => $_SESSION['shop']['vat_products_txt'],
                'SHOP_TAX_GRAND_TXT' => $_SESSION['shop']['vat_grand_txt'],
                'TXT_TAX_RATE' => $_ARRAYLANG['TXT_SHOP_VAT_RATE'],
                'TXT_TAX_PREFIX' =>
                    (Vat::isIncluded()
                        ? $_ARRAYLANG['TXT_SHOP_VAT_PREFIX_INCL']
                        : $_ARRAYLANG['TXT_SHOP_VAT_PREFIX_EXCL']
                    ),
            ));
            if (Vat::isIncluded()) {
                self::$objTemplate->setVariable(array(
                    'SHOP_GRAND_TOTAL_EXCL_TAX' =>
                        Currency::formatPrice(
                        $_SESSION['shop']['grand_total_price'] - $_SESSION['shop']['vat_price']
                    ),
                ));
            }
        }
        self::viewpart_lsv();
        // Custom.
        // Enable if Discount class is customized and in use.
        //self::showCustomerDiscount(Cart::get_price());
    }


    /**
     * Generates an overview of the Order for the Customer to confirm
     *
     * Forward her to the processing of the Order after the button has been
     * clicked.
     * @return  boolean             True on success, false otherwise
     */
    static function confirm()
    {
        global $_ARRAYLANG;

        // If the cart or address is missing, return to the shop
        if (!self::verifySessionAddress()) {
            \CSRF::redirect(
                Cx\Core\Routing\Url::fromModuleAndCmd('shop', ''));
        }
        self::$show_currency_navbar = false;
        // The Customer clicked the confirm button; this must not be the case
        // the first time this method is called.
        if (isset($_POST['process'])) {
            return self::process();
        }
        // Show confirmation page.
        self::$objTemplate->hideBlock('shopProcess');
        self::$objTemplate->setGlobalVariable($_ARRAYLANG);
        // It may be necessary to refresh the cart here, as the customer
        // may return to the cart, then press "Back".
        self::_initPaymentDetails();
        foreach (Cart::get_products_array() as $arrProduct) {
            $objProduct = Product::getById($arrProduct['id']);
            if (!$objProduct) {
// TODO: Implement a proper method
//                unset(Cart::get_product_id($cart_id]);
                continue;
            }
            $price_options = 0;
            $attributes = Attributes::getAsStrings(
                $arrProduct['options'], $price_options);
            $attributes = $attributes[0];
            // Note:  The Attribute options' price is added
            // to the price here!
            $price = $objProduct->get_custom_price(
                self::$objCustomer,
                $price_options,
                $arrProduct['quantity']);
            // Test the distribution method for delivery
            $productDistribution = $objProduct->distribution();
            $weight = ($productDistribution == 'delivery'
                ? Weight::getWeightString($objProduct->weight()) : '-');
            $vatId = $objProduct->vat_id();
            $vatRate = Vat::getRate($vatId);
            $vatPercent = Vat::getShort($vatId);
            $vatAmount = Vat::amount(
                $vatRate, $price*$arrProduct['quantity']);
            self::$objTemplate->setVariable(array(
                'SHOP_PRODUCT_ID' => $arrProduct['id'],
                'SHOP_PRODUCT_CUSTOM_ID' => $objProduct->code(),
                'SHOP_PRODUCT_TITLE' => contrexx_raw2xhtml($objProduct->name()),
                'SHOP_PRODUCT_PRICE' => Currency::formatPrice(
                    $price*$arrProduct['quantity']),
                'SHOP_PRODUCT_QUANTITY' => $arrProduct['quantity'],
                'SHOP_PRODUCT_ITEMPRICE' => Currency::formatPrice($price),
                'SHOP_UNIT' => Currency::getActiveCurrencySymbol(),
            ));
            if (   $attributes
                && self::$objTemplate->blockExists('attributes')) {
                self::$objTemplate->setVariable(
                    'SHOP_PRODUCT_OPTIONS', $attributes);
            }
            if (SettingDb::getValue('weight_enable')) {
                self::$objTemplate->setVariable(array(
                    'SHOP_PRODUCT_WEIGHT' => $weight,
                    'TXT_WEIGHT' => $_ARRAYLANG['TXT_WEIGHT'],
                ));
            }
            if (Vat::isEnabled()) {
                self::$objTemplate->setVariable(array(
                    'SHOP_PRODUCT_TAX_RATE' => $vatPercent,
                    'SHOP_PRODUCT_TAX_AMOUNT' =>
                        Currency::formatPrice($vatAmount).
                        '&nbsp;'.Currency::getActiveCurrencySymbol(),
                ));
            }
            self::$objTemplate->parse("shopCartRow");
        }

        $total_discount_amount = 0;
        if (Cart::get_discount_amount()) {
            $total_discount_amount = Cart::get_discount_amount();
            self::$objTemplate->setVariable(array(
                'SHOP_DISCOUNT_COUPON_TOTAL' =>
                    $_ARRAYLANG['TXT_SHOP_DISCOUNT_COUPON_AMOUNT_TOTAL'],
                'SHOP_DISCOUNT_COUPON_TOTAL_AMOUNT' =>
                    Currency::formatPrice(-$total_discount_amount),
            ));
        }
        self::$objTemplate->setVariable(array(
            'SHOP_UNIT' => Currency::getActiveCurrencySymbol(),
            'SHOP_TOTALITEM' => Cart::get_item_count(),
            'SHOP_PAYMENT_PRICE' => Currency::formatPrice(
                $_SESSION['shop']['payment_price']),
            'SHOP_TOTALPRICE' => Currency::formatPrice(Cart::get_price()),
            'SHOP_PAYMENT' =>
                Payment::getProperty($_SESSION['shop']['paymentId'], 'name'),
            'SHOP_GRAND_TOTAL' => Currency::formatPrice(
                  $_SESSION['shop']['grand_total_price']),
            'SHOP_COMPANY' => stripslashes($_SESSION['shop']['company']),
// Old
            'SHOP_TITLE' => stripslashes($_SESSION['shop']['gender']),
// New
            'SHOP_GENDER' => stripslashes($_SESSION['shop']['gender']),
            'SHOP_LASTNAME' => stripslashes($_SESSION['shop']['lastname']),
            'SHOP_FIRSTNAME' => stripslashes($_SESSION['shop']['firstname']),
            'SHOP_ADDRESS' => stripslashes($_SESSION['shop']['address']),
            'SHOP_ZIP' => stripslashes($_SESSION['shop']['zip']),
            'SHOP_CITY' => stripslashes($_SESSION['shop']['city']),
            'SHOP_COUNTRY' => Country::getNameById($_SESSION['shop']['countryId']),
            'SHOP_EMAIL' => stripslashes($_SESSION['shop']['email']),
            'SHOP_PHONE' => stripslashes($_SESSION['shop']['phone']),
            'SHOP_FAX' => stripslashes($_SESSION['shop']['fax']),
        ));
        if (!empty($_SESSION['shop']['lastname2'])) {
            self::$objTemplate->setVariable(array(
                'SHOP_COMPANY2' => stripslashes($_SESSION['shop']['company2']),
                'SHOP_TITLE2' => stripslashes($_SESSION['shop']['gender2']),
                'SHOP_LASTNAME2' => stripslashes($_SESSION['shop']['lastname2']),
                'SHOP_FIRSTNAME2' => stripslashes($_SESSION['shop']['firstname2']),
                'SHOP_ADDRESS2' => stripslashes($_SESSION['shop']['address2']),
                'SHOP_ZIP2' => stripslashes($_SESSION['shop']['zip2']),
                'SHOP_CITY2' => stripslashes($_SESSION['shop']['city2']),
                'SHOP_COUNTRY2' => Country::getNameById($_SESSION['shop']['countryId2']),
                'SHOP_PHONE2' => stripslashes($_SESSION['shop']['phone2']),
            ));
        }
        if (!empty($_SESSION['shop']['note'])) {
            self::$objTemplate->setVariable(array(
//                    'TXT_COMMENTS' => $_ARRAYLANG['TXT_COMMENTS'],
                'SHOP_CUSTOMERNOTE' => $_SESSION['shop']['note'],
            ));
        }
        if (Vat::isEnabled()) {
            self::$objTemplate->setVariable(array(
                'TXT_TAX_RATE' => $_ARRAYLANG['TXT_SHOP_VAT_RATE'],
                'SHOP_TAX_PRICE' => Currency::formatPrice(
                    $_SESSION['shop']['vat_price']),
                'SHOP_TAX_PRODUCTS_TXT' => $_SESSION['shop']['vat_products_txt'],
                'SHOP_TAX_GRAND_TXT' => $_SESSION['shop']['vat_grand_txt'],
                'TXT_TAX_PREFIX' =>
                    (Vat::isIncluded()
                        ? $_ARRAYLANG['TXT_SHOP_VAT_PREFIX_INCL']
                        : $_ARRAYLANG['TXT_SHOP_VAT_PREFIX_EXCL']
                    ),
            ));
            if (Vat::isIncluded()) {
                self::$objTemplate->setVariable(array(
                    'SHOP_GRAND_TOTAL_EXCL_TAX' =>
                        Currency::formatPrice(
                            $_SESSION['shop']['grand_total_price']
                            - $_SESSION['shop']['vat_price']
                    ),
                ));
            }
        }
// TODO: Make sure in payment() that those two are either both empty or
// both non-empty!
        if (   !Cart::needs_shipment()
            && empty($_SESSION['shop']['shipperId'])) {
            if (self::$objTemplate->blockExists('shipping_address'))
                self::$objTemplate->hideBlock('shipping_address');
        } else {
            // Shipment is required, so
            if (empty($_SESSION['shop']['shipperId'])) {
                \CSRF::redirect(
                    Cx\Core\Routing\Url::fromModuleAndCmd('shop', 'payment'));
            }
            self::$objTemplate->setVariable(array(
                'SHOP_SHIPMENT_PRICE' => Currency::formatPrice(
                    $_SESSION['shop']['shipment_price']),
                'SHOP_SHIPMENT' =>
                    Shipment::getShipperName($_SESSION['shop']['shipperId']),
//                    'TXT_SHIPPING_METHOD' => $_ARRAYLANG['TXT_SHIPPING_METHOD'],
//                    'TXT_SHIPPING_ADDRESS' => $_ARRAYLANG['TXT_SHIPPING_ADDRESS'],
            ));
        }
        // Custom.
        // Enable if Discount class is customized and in use.
        //self::showCustomerDiscount(Cart::get_price());
        return true;
    }


    /**
     * Processes the Order
     *
     * Verifies all data, updates and stores it in the database, and
     * initializes payment
     * @return  boolean         True on successs, false otherwise
     */
    static function process()
    {
        global $objDatabase, $_ARRAYLANG;

// FOR TESTING ONLY (repeatedly process/store the order, also disable self::destroyCart())
//$_SESSION['shop']['order_id'] = NULL;

        // Verify that the order hasn't yet been saved
        // (and has thus not yet been confirmed)
        if (isset($_SESSION['shop']['order_id'])) {
            return Message::error($_ARRAYLANG['TXT_ORDER_ALREADY_PLACED']);
        }
        // No more confirmation
        self::$objTemplate->hideBlock('shopConfirm');
        // Store the customer, register the order
        $customer_ip = $_SERVER['REMOTE_ADDR'];
        $customer_host = substr(@gethostbyaddr($_SERVER['REMOTE_ADDR']), 0, 100);
        $customer_browser = substr(getenv('HTTP_USER_AGENT'), 0, 100);
        $new_customer = false;
//DBG::log("Shop::process(): E-Mail: ".$_SESSION['shop']['email']);
        if (self::$objCustomer) {
//DBG::log("Shop::process(): Existing User username ".$_SESSION['shop']['username'].", email ".$_SESSION['shop']['email']);
        } else {
            // Registered Customers are required to be logged in!
            self::$objCustomer = Customer::getRegisteredByEmail(
                $_SESSION['shop']['email']);
            if (self::$objCustomer) {
                Message::error($_ARRAYLANG['TXT_SHOP_CUSTOMER_REGISTERED_EMAIL']);
                \CSRF::redirect(
                    Cx\Core\Routing\Url::fromModuleAndCmd('shop', 'login').
                    '?redirect='.
                    base64_encode(
                        Cx\Core\Routing\Url::fromModuleAndCmd('shop', 'confirm')));
            }
// Unregistered Customers are stored as well, as their information is needed
// nevertheless.  Their active status, however, is set to false.
            self::$objCustomer = Customer::getUnregisteredByEmail(
                $_SESSION['shop']['email']);
            if (!self::$objCustomer) {
                self::$objCustomer = new Customer();
                // Currently, the e-mail address is set as the user name
                $_SESSION['shop']['username'] = $_SESSION['shop']['email'];
//DBG::log("Shop::process(): New User username ".$_SESSION['shop']['username'].", email ".$_SESSION['shop']['email']);
                self::$objCustomer->username($_SESSION['shop']['username']);
                self::$objCustomer->email($_SESSION['shop']['email']);
                // Note that the password is unset when the Customer chooses
                // to order without registration.  The generated one
                // defaults to length 8, fulfilling the requirements for
                // complex passwords.  And it's kept absolutely secret.
                $password = (empty($_SESSION['shop']['password'])
                    ? User::make_password()
                    : $_SESSION['shop']['password']);
//\DBG::log("Password: $password (session: {$_SESSION['shop']['password']})");
                if (!self::$objCustomer->password($password)) {
                    Message::error($_ARRAYLANG['TXT_INVALID_PASSWORD']);
                    \CSRF::redirect(Cx\Core\Routing\Url::fromModuleAndCmd(
                        'shop', 'account'));
                }
                self::$objCustomer->active(empty($_SESSION['shop']['dont_register']));
                $new_customer = true;
            }
        }
        // Update the Customer object from the session array
        // (whether new or not -- it may have been edited)
        self::$objCustomer->gender($_SESSION['shop']['gender']);
        self::$objCustomer->firstname($_SESSION['shop']['firstname']);
        self::$objCustomer->lastname($_SESSION['shop']['lastname']);
        self::$objCustomer->company($_SESSION['shop']['company']);
        self::$objCustomer->address($_SESSION['shop']['address']);
        self::$objCustomer->city($_SESSION['shop']['city']);
        self::$objCustomer->zip($_SESSION['shop']['zip']);
        self::$objCustomer->country_id($_SESSION['shop']['countryId']);
        self::$objCustomer->phone($_SESSION['shop']['phone']);
        self::$objCustomer->fax($_SESSION['shop']['fax']);

        $arrGroups = self::$objCustomer->getAssociatedGroupIds();
        $usergroup_id = SettingDb::getValue('usergroup_id_reseller');
        if (empty($usergroup_id)) {
//DBG::log("Shop::process(): ERROR: Missing reseller group");
            Message::error($_ARRAYLANG['TXT_SHOP_ERROR_USERGROUP_INVALID']);
            \CSRF::redirect(
                Cx\Core\Routing\Url::fromModuleAndCmd('shop', ''));
        }
        if (!in_array($usergroup_id, $arrGroups)) {
//DBG::log("Shop::process(): Customer is not in Reseller group (ID $usergroup_id)");
            // Not a reseller.  See if she's a final customer
            $usergroup_id = SettingDb::getValue('usergroup_id_customer');
            if (empty($usergroup_id)) {
//DBG::log("Shop::process(): ERROR: Missing final customer group");
                Message::error($_ARRAYLANG['TXT_SHOP_ERROR_USERGROUP_INVALID']);
                \CSRF::redirect(
                    Cx\Core\Routing\Url::fromModuleAndCmd('shop', ''));
            }
            if (!in_array($usergroup_id, $arrGroups)) {
//DBG::log("Shop::process(): Customer is not in final customer group (ID $usergroup_id), either");
                // Neither one, add to the final customer group (default)
                $arrGroups[] = $usergroup_id;
                self::$objCustomer->setGroups(array($usergroup_id));
//DBG::log("Shop::process(): Added Customer to final customer group (ID $usergroup_id): ".var_export(self::$objCustomer->getAssociatedGroupIds(), true));
            } else {
//DBG::log("Shop::process(): Customer is a final customer (ID $usergroup_id) already: ".var_export(self::$objCustomer->getAssociatedGroupIds(), true));
            }
        } else {
//DBG::log("Shop::process(): Customer is a Reseller (ID $usergroup_id) already: ".var_export(self::$objCustomer->getAssociatedGroupIds(), true));
        }
        // Insert or update the customer
//\DBG::log("Shop::process(): Storing Customer: ".var_export(self::$objCustomer, true));
        if (!self::$objCustomer->store()) {
            return Message::error($_ARRAYLANG['TXT_SHOP_CUSTOMER_ERROR_STORING']);
        }
        // Authenticate new Customer
        if ($new_customer) {
            // Fails for "unregistered" Customers!
            if (self::$objCustomer->auth(
                $_SESSION['shop']['username'], $_SESSION['shop']['password'], false, true)) {
                if (!self::_authenticate()) {
                    return Message::error($_ARRAYLANG['TXT_SHOP_CUSTOMER_ERROR_STORING']);
                }
            }
        }
//die();
        // Clear the ship-to country if there is no shipping
        if (!Cart::needs_shipment()) {
            $_SESSION['shop']['countryId2'] = 0;
        }
        $shipper_id = (empty($_SESSION['shop']['shipperId'])
            ? null : $_SESSION['shop']['shipperId']);
        $payment_id = (empty($_SESSION['shop']['paymentId'])
            ? null : $_SESSION['shop']['paymentId']);
        $objOrder = new Order();
        $objOrder->customer_id(self::$objCustomer->id());

        $objOrder->billing_gender($_SESSION['shop']['gender']);
        $objOrder->billing_firstname($_SESSION['shop']['firstname']);
        $objOrder->billing_lastname($_SESSION['shop']['lastname']);
        $objOrder->billing_company($_SESSION['shop']['company']);
        $objOrder->billing_address($_SESSION['shop']['address']);
        $objOrder->billing_city($_SESSION['shop']['city']);
        $objOrder->billing_zip($_SESSION['shop']['zip']);
        $objOrder->billing_country_id($_SESSION['shop']['countryId']);
        $objOrder->billing_phone($_SESSION['shop']['phone']);
        $objOrder->billing_fax($_SESSION['shop']['fax']);
        $objOrder->billing_email($_SESSION['shop']['email']);

        $objOrder->currency_id($_SESSION['shop']['currencyId']);
        $objOrder->sum($_SESSION['shop']['grand_total_price']);
        $objOrder->date_time(date(ASCMS_DATE_FORMAT_INTERNATIONAL_DATETIME));
        $objOrder->status(0);
        $objOrder->company($_SESSION['shop']['company2']);
        $objOrder->gender($_SESSION['shop']['gender2']);
        $objOrder->firstname($_SESSION['shop']['firstname2']);
        $objOrder->lastname($_SESSION['shop']['lastname2']);
        $objOrder->address($_SESSION['shop']['address2']);
        $objOrder->city($_SESSION['shop']['city2']);
        $objOrder->zip($_SESSION['shop']['zip2']);
        $objOrder->country_id($_SESSION['shop']['countryId2']);
        $objOrder->phone($_SESSION['shop']['phone2']);
        $objOrder->vat_amount($_SESSION['shop']['vat_price']);
        $objOrder->shipment_amount($_SESSION['shop']['shipment_price']);
        $objOrder->shipment_id($shipper_id);
        $objOrder->payment_id($payment_id);
        $objOrder->payment_amount($_SESSION['shop']['payment_price']);
        $objOrder->ip($customer_ip);
        $objOrder->host($customer_host);
        $objOrder->lang_id(FRONTEND_LANG_ID);
        $objOrder->browser($customer_browser);
        $objOrder->note($_SESSION['shop']['note']);
        if (!$objOrder->insert()) {
            // $order_id is unset!
            return Message::error($_ARRAYLANG['TXT_SHOP_ORDER_ERROR_STORING']);
        }
        $order_id = $objOrder->id();
        $_SESSION['shop']['order_id'] = $order_id;
        // The products will be tested one by one below.
        // If any single one of them requires delivery, this
        // flag will be set to true.
        // This is used to determine the order status at the
        // end of the shopping process.
        $_SESSION['shop']['isDelivery'] = false;
        // Try to redeem the Coupon, if any
        $coupon_code = (isset($_SESSION['shop']['coupon_code'])
            ? $_SESSION['shop']['coupon_code'] : null);
//DBG::log("Cart::update(): Coupon Code: $coupon_code");
        $items_total = 0;

        // Suppress Coupon messages (see Coupon::available())
        Message::save();
        foreach (Cart::get_products_array() as $arrProduct) {
            $objProduct = Product::getById($arrProduct['id']);
            if (!$objProduct) {
                unset($_SESSION['shop']['order_id']);
                return Message::error($_ARRAYLANG['TXT_ERROR_LOOKING_UP_ORDER']);
            }
            $product_id = $arrProduct['id'];
            $name = $objProduct->name();
            $priceOptions = (!empty($arrProduct['optionPrice'])
                ? $arrProduct['optionPrice'] : 0);
            $quantity = $arrProduct['quantity'];
            $price = $objProduct->get_custom_price(
                self::$objCustomer,
                $priceOptions,
                $quantity);
            $item_total = $price*$quantity;
            $items_total += $item_total;
            $productVatId = $objProduct->vat_id();
            $vat_rate = ($productVatId && Vat::getRate($productVatId)
                ? Vat::getRate($productVatId) : '0.00');
            // Test the distribution method for delivery
            $productDistribution = $objProduct->distribution();
            if ($productDistribution == 'delivery') {
                $_SESSION['shop']['isDelivery'] = true;
            }
            $weight = ($productDistribution == 'delivery'
                ? $objProduct->weight() : 0); // grams
            if ($weight == '') { $weight = 0; }
            // Add to order items table
            $result = $objOrder->insertItem(
                $order_id, $product_id, $name, $price, $quantity,
                $vat_rate, $weight, $arrProduct['options']);
            if (!$result) {
                unset($_SESSION['shop']['order_id']);
// TODO: Verify error message set by Order::insertItem()
                return false;
            }
            // Store the Product Coupon, if applicable.
            // Note that it is not redeemed yet (uses=0)!
            if ($coupon_code) {
                $objCoupon = Coupon::available($coupon_code, $item_total,
                    self::$objCustomer->id(), $product_id, $payment_id);
                if ($objCoupon) {
//DBG::log("Shop::process(): Got Coupon for Product ID $product_id: ".var_export($objCoupon, true));
                    if (!$objCoupon->redeem($order_id, self::$objCustomer->id(),
                        $price*$quantity, 0)) {
// TODO: Do something if the Coupon does not work
DBG::log("Shop::process(): ERROR: Failed to store Coupon for Product ID $product_id");
                    }
                    $coupon_code = null;
                }
            }
        } // foreach product in cart
        // Store the Global Coupon, if applicable.
        // Note that it is not redeemed yet (uses=0)!
//DBG::log("Shop::process(): Looking for global Coupon $coupon_code");
        if ($coupon_code) {
            $objCoupon = Coupon::available($coupon_code, $items_total,
                self::$objCustomer->id(), null, $payment_id);
            if ($objCoupon) {
//DBG::log("Shop::process(): Got global Coupon: ".var_export($objCoupon, true));
                if (!$objCoupon->redeem($order_id, self::$objCustomer->id(),
                    $items_total, 0))
DBG::log("Shop::process(): ERROR: Failed to store global Coupon");
            }
        }
        Message::restore();

        $processor_id = Payment::getProperty($_SESSION['shop']['paymentId'], 'processor_id');
        $processor_name = PaymentProcessing::getPaymentProcessorName($processor_id);
         // other payment methods
        PaymentProcessing::initProcessor($processor_id);
// TODO: These arguments are no longer valid.  Set them up later?
//            Currency::getActiveCurrencyCode(),
//            FWLanguage::getLanguageParameter(FRONTEND_LANG_ID, 'lang'));
        // if the processor is Internal_LSV, and there is account information,
        // store the information.
        if ($processor_name == 'internal_lsv') {
            if (!self::lsv_complete()) {
                // Missing mandatory data; return to payment
                unset($_SESSION['shop']['order_id']);
                Message::error($_ARRAYLANG['TXT_ERROR_ACCOUNT_INFORMATION_NOT_AVAILABLE']);
                \CSRF::redirect(
                    Cx\Core\Routing\Url::fromModuleAndCmd('shop', 'payment'));
            }
            $query = "
                INSERT INTO ".DBPREFIX."module_shop".MODULE_INDEX."_lsv (
                    order_id, holder, bank, blz
                ) VALUES (
                    $order_id,
                    '".contrexx_raw2db($_SESSION['shop']['account_holder'])."',
                    '".contrexx_raw2db($_SESSION['shop']['account_bank'])."',
                    '".contrexx_raw2db($_SESSION['shop']['account_blz'])."'
                )";
            $objResult = $objDatabase->Execute($query);
            if (!$objResult) {
                // Return to payment
                unset($_SESSION['shop']['order_id']);
                Message::error($_ARRAYLANG['TXT_ERROR_INSERTING_ACCOUNT_INFORMATION']);
                \CSRF::redirect(
                    Cx\Core\Routing\Url::fromModuleAndCmd('shop', 'payment'));
            }
        }

        $_SESSION['shop']['order_id_checkin'] = $order_id;
        $strProcessorType = PaymentProcessing::getCurrentPaymentProcessorType();

        // Test whether the selected payment method can be
        // considered an instant or deferred one.
        // This is used to set the order status at the end
        // of the shopping process.
// TODO: Invert this flag, as it may no longer be present after paying
// online using one of the external payment methods!  Ensure that it is set
// instead when paying "deferred".
        $_SESSION['shop']['isInstantPayment'] = false;
        if ($strProcessorType == 'external') {
            // For the sake of simplicity, all external payment
            // methods are considered to be 'instant'.
            // All currently implemented internal methods require
            // further action from the merchant, and thus are
            // considered to be 'deferred'.
            $_SESSION['shop']['isInstantPayment'] = true;
        }
        // Send the Customer login separately, as the password possibly
        // won't be available later
        if (!empty($_SESSION['shop']['password'])) {
            self::sendLogin(
                self::$objCustomer->email(), $_SESSION['shop']['password']);
        }
        // Show payment processing page.
        // Note that some internal payments are redirected away
        // from this page in checkOut():
        // 'internal', 'internal_lsv'
        self::$objTemplate->setVariable(
            'SHOP_PAYMENT_PROCESSING', PaymentProcessing::checkOut()
        );
        // Clear the order ID.
        // The order may be resubmitted and the payment retried.
        unset($_SESSION['shop']['order_id']);
        // Custom.
        // Enable if Discount class is customized and in use.
        //self::showCustomerDiscount(Cart::get_price());
        return true;
    }


    /**
     * The payment process has completed successfully.
     *
     * Check the data from the payment provider.
     * @access public
     */
    static function success()
    {
        global $_ARRAYLANG;

        // Hide the currency navbar
        self::$show_currency_navbar = false;

        // Use the Order ID stored in the session, if possible.
        // Otherwise, get it from the payment processor.
        $order_id = (empty($_SESSION['shop']['order_id_checkin'])
            ? PaymentProcessing::getOrderId()
            : $_SESSION['shop']['order_id_checkin']);
//DBG::deactivate();
//DBG::activate(DBG_LOG_FILE);
//DBG::log("success(): Restored Order ID ".var_export($order_id, true));
        // Default new order status: As long as it's pending (0, zero),
        // update_status() will choose the new value automatically.
        $newOrderStatus = Order::STATUS_PENDING;

        $checkinresult = PaymentProcessing::checkIn();
//DBG::log("success(): CheckIn Result ".var_export($checkinresult, true));

        if ($checkinresult === false) {
            // Failed payment.  Cancel the order.
            $newOrderStatus = Order::STATUS_CANCELLED;
//DBG::log("success(): Order ID is *false*, new Status $newOrderStatus");
        } elseif ($checkinresult === true) {
            // True is returned for successful payments.
            // Update the status in any case.
            $newOrderStatus = Order::STATUS_PENDING;
//DBG::log("success(): Order ID is *true*, new Status $newOrderStatus");
        } elseif ($checkinresult === null) {
            // checkIn() returns null if no change to the order status
            // is necessary or appropriate
            $newOrderStatus = Order::STATUS_PENDING;
//DBG::log("success(): Order ID is *null* (new Status $newOrderStatus)");
        }
        // Verify the Order ID with the session, if available
        if (   isset($_SESSION['shop']['order_id_checkin'])
            && $order_id != $_SESSION['shop']['order_id_checkin']) {
            // Cancel the Order with the ID from the session, not the
            // possibly faked one from the request!
//DBG::log("success(): Order ID $order_id is not ".$_SESSION['shop']['order_id_checkin'].", new Status $newOrderStatus");
            $order_id = $_SESSION['shop']['order_id_checkin'];
            $newOrderStatus = Order::STATUS_CANCELLED;
            $checkinresult = false;
        }
//DBG::log("success(): Verification complete, Order ID ".var_export($order_id, true).", Status: $newOrderStatus");
        if (is_numeric($order_id)) {
            // The respective order state, if available, is updated.
            // The only exception is when $checkinresult is null.
            if (isset($checkinresult)) {
                $newOrderStatus =
                    Orders::update_status($order_id, $newOrderStatus);
//DBG::log("success(): Updated Order Status to $newOrderStatus (Order ID $order_id)");
            } else {
                // The old status is the new status
                $newOrderStatus = self::getOrderStatus($order_id);
            }
            switch ($newOrderStatus) {
                case Order::STATUS_CONFIRMED:
                case Order::STATUS_PAID:
                case Order::STATUS_SHIPPED:
                case Order::STATUS_COMPLETED:
                    Message::ok($_ARRAYLANG['TXT_ORDER_PROCESSED']);
                    // Custom.
                    // Enable if Discount class is customized and in use.
                    //self::showCustomerDiscount(Cart::get_price());
                    break;
                case Order::STATUS_PENDING:
                    // Pending orders must be stated as such.
                    // Certain payment methods (like PayPal with IPN) might
                    // be confirmed a little later and must cause the
                    // confirmation mail to be sent.
                    Message::information(
                        $_ARRAYLANG['TXT_SHOP_ORDER_PENDING'].'<br /><br />'.
                        $_ARRAYLANG['TXT_SHOP_ORDER_WILL_BE_CONFIRMED']);
                    break;
                case Order::STATUS_DELETED:
                case Order::STATUS_CANCELLED:
                    Message::error(
                        $_ARRAYLANG['TXT_SHOP_PAYMENT_FAILED'].'<br /><br />'.
                        $_ARRAYLANG['TXT_SHOP_ORDER_CANCELLED']);
                    break;
            }
        } else {
            Message::error($_ARRAYLANG['TXT_NO_PENDING_ORDER']);
        }
        // Avoid any output if the result is negative
        if (   isset($_REQUEST['result'])
            && $_REQUEST['result'] < 0) die('');
        self::$objTemplate->setGlobalVariable($_ARRAYLANG);
        // Comment this for testing, so you can reuse the same account and cart
        self::destroyCart();
    }


    /**
     * Change the customers' password
     *
     * If no customer is logged in, redirects to the login page.
     * Returns true only after the password has been updated successfully.
     * @return  boolean             True on success, false otherwise
     */
    static function _changepass()
    {
        global $_ARRAYLANG;

        if (!self::$objCustomer) {
            \CSRF::redirect(
                Cx\Core\Routing\Url::fromModuleAndCmd('shop', 'login').
                '?redirect='.base64_encode(
                    Cx\Core\Routing\Url::fromModuleAndCmd('shop', 'changepass')));
        }
        if (isset($_POST['shopNewPassword'])) {
            if (empty($_POST['shopCurrentPassword'])) {
                return Message::error($_ARRAYLANG['TXT_SHOP_ENTER_CURRENT_PASSWORD']);
            }
            $password_old = contrexx_input2raw($_POST['shopCurrentPassword']);
            if (md5($password_old) != self::$objCustomer->password()) {
                return Message::error($_ARRAYLANG['TXT_SHOP_WRONG_CURRENT_PASSWORD']);
            }
            $password = contrexx_input2raw($_POST['shopNewPassword']);
            if (empty($password)) {
                return Message::error($_ARRAYLANG['TXT_SHOP_SPECIFY_NEW_PASSWORD']);
            }
            if (empty($_POST['shopConfirmPassword'])) {
                return Message::error($_ARRAYLANG['TXT_SHOP_PASSWORD_NOT_CONFIRMED']);
            }
            $password_confirm = contrexx_input2raw($_POST['shopConfirmPassword']);
            if ($password != $password_confirm) {
                return Message::error($_ARRAYLANG['TXT_SHOP_PASSWORD_NOT_CONFIRMED']);
            }
            if (strlen($password) < 6) {
                return Message::error($_ARRAYLANG['TXT_PASSWORD_MIN_CHARS']);
            }
            if (!self::$objCustomer->password($password)) {
                return Message::error($_ARRAYLANG['TXT_SHOP_PASSWORD_INVALID']);
            }
            if (!self::$objCustomer->store()) {
                return Message::error($_ARRAYLANG['TXT_SHOP_PASSWORD_ERROR_UPDATING']);
            }
            return Message::ok($_ARRAYLANG['TXT_SHOP_PASSWORD_CHANGED_SUCCESSFULLY']);
        }
        self::$objTemplate->setVariable(array(
            'SHOP_PASSWORD_CURRENT' => $_ARRAYLANG['SHOP_PASSWORD_CURRENT'],
            'SHOP_PASSWORD_NEW' => $_ARRAYLANG['SHOP_PASSWORD_NEW'],
            'SHOP_PASSWORD_CONFIRM' => $_ARRAYLANG['SHOP_PASSWORD_CONFIRM'],
            'SHOP_PASSWORD_CHANGE' => $_ARRAYLANG['SHOP_PASSWORD_CHANGE'],
        ));
        return false;
    }


    /**
     * Sends the Customer login data
     *
     * Note that this only works as expected *after* the Customer has logged
     * in, but *before* the Customer is redirected to an online payment service
     * provider, as the session usually gets lost in the process.
     * So, it's best to call this right after storing the Order, before the
     * payment transaction is started.
     * @param   string   $email     The e-mail address
     * @param   string   $password  The password
     * @return  boolean             True on success, false otherwise
     */
    static function sendLogin($email, $password)
    {
        global $_ARRAYLANG;

        $objCustomer = new Customer();
        $objCustomer = $objCustomer->getUsers(array('email' => $email));
        if (!$objCustomer || $objCustomer->EOF) {
            return Message::error($_ARRAYLANG['TXT_SHOP_NO_ACCOUNT_WITH_EMAIL']);
        }
        $arrSubstitution =
              $objCustomer->getSubstitutionArray()
            + self::getSubstitutionArray();
        if (!$arrSubstitution) return false;
        $arrSubstitution['CUSTOMER_LOGIN'][0]['CUSTOMER_PASSWORD'] = $password;
        // Defaults to FRONTEND_LANG_ID
        $arrMailTemplate = array(
            'section' => 'shop',
            'key' => 'customer_login',
            'substitution' => &$arrSubstitution,
            'to' => $objCustomer->email(),
        );
        return MailTemplate::send($arrMailTemplate);
    }


    /**
     * Shows the form for entering the e-mail address
     *
     * After a valid address has been posted back, creates a new password
     * and sends it to the Customer.
     * Fails if changing or sending the password fails, and when the
     * form isn't posted (i.e. on first loading the page).
     * Returns true only after the new password has been sent successfully.
     * @return    boolean                   True on success, false otherwise
     */
    static function view_sendpass()
    {
        global $_ARRAYLANG;

        while (isset($_POST['shopEmail'])) {
            $email = contrexx_input2raw($_POST['shopEmail']);
            $password = User::make_password();
            if (!Customer::updatePassword($email, $password)) {
                Message::error($_ARRAYLANG['TXT_SHOP_UNABLE_SET_NEW_PASSWORD']);
                break;
            }
            if (!self::sendLogin($email, $password)) {
                Message::error($_ARRAYLANG['TXT_SHOP_UNABLE_TO_SEND_EMAIL']);
                break;
            }
            return Message::ok($_ARRAYLANG['TXT_SHOP_ACCOUNT_DETAILS_SENT_SUCCESSFULLY']);
        }
        self::$objTemplate->setGlobalVariable($_ARRAYLANG);
        self::$objTemplate->touchBlock('shop_sendpass');
        return false;
    }


    /**
     * Show the total pending order and the resulting discount amount.
     *
     * This method fails if there is no Customer logged in or if there
     * is some weird problem with the Discount class.
     * @param   double  $orderAmount        The amount of the current order
     * @global  array   $_ARRAYLANG         Language array
     * @return  boolean                     True on success, false otherwise.
     * @author  Reto Kohli <reto.kohli@comvation.com>
     */
    static function showCustomerDiscount($orderAmount)
    {
        if (!self::$objCustomer) {
            return false;
        }
        $objDiscount = new Discount(self::$objCustomer->id(), $orderAmount);
        if (!$objDiscount) {
            return false;
        }
        // Calculate Customer "discount".
        // If this is false or zero, we don't bother to set anything at all.
        $newTotalOrderAmount = $objDiscount->getNewTotalOrderAmount();
        if ($newTotalOrderAmount) {
            $newDiscountAmount = $objDiscount->getNewDiscountAmount();
            $totalOrderAmount = $objDiscount->getTotalOrderAmount();
            $discountAmount = $objDiscount->getDiscountAmount();
            self::$objTemplate->setVariable(array(
// NOTE: Language variables *SHOULD* be set in each main view anyway
//                'TXT_SHOP_CUSTOMER_DISCOUNT_DETAILS' => $_ARRAYLANG['TXT_SHOP_CUSTOMER_DISCOUNT_DETAILS'],
//                'TXT_SHOP_CUSTOMER_TOTAL_ORDER_AMOUNT' => $_ARRAYLANG['TXT_SHOP_CUSTOMER_TOTAL_ORDER_AMOUNT'],
//                'TXT_SHOP_CUSTOMER_DISCOUNT_AMOUNT' => $_ARRAYLANG['TXT_SHOP_CUSTOMER_DISCOUNT_AMOUNT'],
//                'TXT_SHOP_CUSTOMER_NEW_TOTAL_ORDER_AMOUNT' => $_ARRAYLANG['TXT_SHOP_CUSTOMER_NEW_TOTAL_ORDER_AMOUNT'],
//                'TXT_SHOP_CUSTOMER_NEW_DISCOUNT_AMOUNT' => $_ARRAYLANG['TXT_SHOP_CUSTOMER_NEW_DISCOUNT_AMOUNT'],
                'SHOP_CUSTOMER_TOTAL_ORDER_AMOUNT' => number_format($totalOrderAmount, 2, '.', '').' '.Currency::getActiveCurrencySymbol(),
                'SHOP_CUSTOMER_DISCOUNT_AMOUNT' => number_format($discountAmount, 2, '.', '').' '.Currency::getActiveCurrencySymbol(),
                'SHOP_CUSTOMER_NEW_TOTAL_ORDER_AMOUNT' => number_format($newTotalOrderAmount, 2, '.', '').' '.Currency::getActiveCurrencySymbol(),
                'SHOP_CUSTOMER_NEW_DISCOUNT_AMOUNT' => number_format($newDiscountAmount, 2, '.', '').' '.Currency::getActiveCurrencySymbol(),
            ));
        }
        return true;
    }


    /**
     * Set up the template block with the shipment terms and conditions
     *
     * Please *DO NOT* remove this method, despite the site terms and
     * conditions have been removed from the Shop!
     * This has been requested by some shopkeepers and may be used at will.
     * @global    array   $_ARRAYLANG     Language array
     * @author    Reto Kohli <reto.kohli@comvation.com>
     */
    static function showShipmentTerms()
    {
        if (self::$objTemplate->blockExists('shopShipper')) {
// TODO: Should be set by the calling view, if any
            global $_ARRAYLANG;
            self::$objTemplate->setGlobalVariable($_ARRAYLANG + array(
                'SHOP_CURRENCY_SYMBOL' => Currency::getActiveCurrencySymbol(),
                'SHOP_CURRENCY_CODE' => Currency::getActiveCurrencyCode(),
            ));
            $arrShipment = Shipment::getShipmentConditions();
            foreach ($arrShipment as $strShipperName => $arrContent) {
                $strCountries = join(', ', $arrContent['countries']);
                $arrConditions = $arrContent['conditions'];
                self::$objTemplate->setCurrentBlock('shopShipment');
                foreach ($arrConditions as $arrData) {
                    self::$objTemplate->setVariable(array(
                        'SHOP_MAX_WEIGHT' => $arrData['max_weight'],
                        'SHOP_COST_FREE' => $arrData['free_from'],
                        'SHOP_COST' => $arrData['fee'],
                    ));
                    self::$objTemplate->parse('shopShipment');
                }
                self::$objTemplate->setVariable(array(
                    'SHOP_SHIPPER' => $strShipperName,
                    'SHOP_COUNTRIES' => $strCountries,
                ));
                self::$objTemplate->parse('shopShipper');
            }
        }
    }


    /**
     * Set up the full set of discount information placeholders
     * @param   integer   $groupCustomerId    The customer group ID of the current customer
     * @param   integer   $groupArticleId     The article group ID of the current article
     * @param   integer   $groupCountId       The count discount group ID of the current article
     * @param   integer   $count              The number of articles to be used for the count discount
     * @static
     * @author    Reto Kohli <reto.kohli@comvation.com>
     */
    static function showDiscountInfo(
        $groupCustomerId, $groupArticleId, $groupCountId, $count
    ) {
        // Pick the unit for this product (count, meter, kilo, ...)
        $unit = Discount::getUnit($groupCountId);
        if (!empty($unit)) {
            self::$objTemplate->setVariable(
                'SHOP_PRODUCT_UNIT', $unit
            );
        }
        if ($groupCustomerId > 0) {
            $rateCustomer = Discount::getDiscountRateCustomer(
                $groupCustomerId, $groupArticleId
            );
            if ($rateCustomer > 0) {
                self::$objTemplate->setVariable(array(
                    'SHOP_DISCOUNT_RATE_CUSTOMER' => $rateCustomer,
// TODO: Should be set by the calling view
//                    'TXT_SHOP_DISCOUNT_RATE_CUSTOMER' => $_ARRAYLANG['TXT_SHOP_DISCOUNT_RATE_CUSTOMER'],
                ));
            }
        }
        if ($groupCountId > 0) {
            $rateCount = Discount::getDiscountRateCount($groupCountId, $count);
            $listCount = self::getDiscountCountString($groupCountId);
            if ($rateCount > 0) {
                // Show discount rate if applicable
                self::$objTemplate->setVariable(
                    'SHOP_DISCOUNT_RATE_COUNT', $rateCount
                );
            }
            if (!empty($listCount)) {
                // Show discount rate string if applicable
                self::$objTemplate->setVariable(
                    'SHOP_DISCOUNT_RATE_COUNT_LIST', $listCount
                );
            }
        }
    }


    /**
     * Returns a string representation of the count type discounts
     * applicable for the given discount group ID, if any.
     * @param   integer   $groupCountId       The discount group ID
     * @return  string                        The string representation
     * @global  array     $_ARRAYLANG         Language array
     * @author    Reto Kohli <reto.kohli@comvation.com>
     * @static
     */
    static function getDiscountCountString($groupCountId)
    {
        global $_ARRAYLANG;

        $arrDiscount = Discount::getDiscountCountArray();
        $arrRate = Discount::getDiscountCountRateArray($groupCountId);
        $strDiscounts = '';
        if (!empty($arrRate)) {
            $unit = '';
            if (isset($arrDiscount[$groupCountId])) {
                $unit = $arrDiscount[$groupCountId]['unit'];
            }
            foreach ($arrRate as $count => $rate) {
                $strDiscounts .=
                    ($strDiscounts != '' ? ', ' : '').
                    $_ARRAYLANG['TXT_SHOP_DISCOUNT_FROM'].' '.
                    $count.' '.$unit.
                    $_ARRAYLANG['TXT_SHOP_DISCOUNT_TO'].' '.
                    $rate.'%';
            }
            $strDiscounts =
                $_ARRAYLANG['TXT_SHOP_DISCOUNT_COUNT'].' '.
                $strDiscounts;
        }
        return $strDiscounts;
    }


    /**
     * Upload a file to be associated with a product in the cart
     * @param   integer   $productAttributeId   The Attribute ID the
     *                                          file belongs to
     * @return  string                          The file name on success,
     *                                          the empty string otherwise
     * @author    Reto Kohli <reto.kohli@comvation.com>
     * @static
     */
    static function uploadFile($productAttributeId)
    {
        global $_ARRAYLANG;

        if (empty($_FILES['productOption']['tmp_name'][$productAttributeId])) {
            return '';
        }
        $uploadFileName = $_FILES['productOption']['tmp_name'][$productAttributeId];
        $originalFileName = $_FILES['productOption']['name'][$productAttributeId];
        $arrMatch = array();
        $filename = '';
        $fileext = '';
        if (preg_match('/(.+)(\.[^.]+)/', $originalFileName, $arrMatch)) {
            $filename = $arrMatch[1];
            $fileext = $arrMatch[2];
        } else {
            $filename = $originalFileName;
        }
        if (   $fileext == '.jpg'
            || $fileext == '.gif'
            || $fileext == '.png') {
            $newFileName = $filename.'['.uniqid().']'.$fileext;
            $newFilePath = Order::UPLOAD_FOLDER.$newFileName;
            if (move_uploaded_file($uploadFileName,
                    ASCMS_DOCUMENT_ROOT.$newFilePath)) {
                return $newFileName;
            }
            Message::error($_ARRAYLANG['TXT_SHOP_ERROR_UPLOADING_FILE']);
        } else {
            Message::error(sprintf(
                $_ARRAYLANG['TXT_SHOP_ERROR_WRONG_FILETYPE'], $fileext));
        }
        return '';
    }


    /**
     * Returns true if the cart is non-empty and all necessary address
     * information has been stored in the session
     * @return    boolean               True on success, false otherwise
     */
    static function verifySessionAddress()
    {
        // Note that the Country IDs are either set already, or chosen in a
        // dropdown menu, so if everything else is set, so are they.
        // They may thus be disabled entirely without affecting this.
        if (   empty($_SESSION['shop']['gender'])
            || empty($_SESSION['shop']['lastname'])
            || empty($_SESSION['shop']['firstname'])
            || empty($_SESSION['shop']['address'])
            || empty($_SESSION['shop']['zip'])
            || empty($_SESSION['shop']['city'])
            || empty($_SESSION['shop']['phone'])
// Must not check this here, would collide with Customers not willing
// to register!
//            || (empty($_SESSION['shop']['email']) && !self::$objCustomer)
//            || (empty($_SESSION['shop']['password']) && !self::$objCustomer)
            || (Cart::needs_shipment()
            && (   empty($_SESSION['shop']['gender2'])
                || empty($_SESSION['shop']['lastname2'])
                || empty($_SESSION['shop']['firstname2'])
                || empty($_SESSION['shop']['address2'])
                || empty($_SESSION['shop']['zip2'])
                || empty($_SESSION['shop']['city2'])
                || empty($_SESSION['shop']['phone2'])))
        ) return false;
// TODO: I don't see why this would be done here:
//        $_SESSION['shop']['equal_address'] = false;
        return true;
    }


    static function getOrderStatus($order_id)
    {
        global $objDatabase;

        $query = "
            SELECT status
              FROM ".DBPREFIX."module_shop".MODULE_INDEX."_orders
             WHERE id=$order_id";
        $objResult = $objDatabase->Execute($query);
        if (!$objResult || $objResult->EOF) return false;
        return $objResult->fields['status'];
    }


    static function getOrderPaymentId($order_id)
    {
        global $objDatabase;

        $query = "
            SELECT payment_id
              FROM ".DBPREFIX."module_shop".MODULE_INDEX."_orders
             WHERE id=$order_id";
        $objResult = $objDatabase->Execute($query);
        if (!$objResult || $objResult->EOF) return false;
        return $objResult->fields['payment_id'];
    }


    /**
     * Creates and sends a Pricelist as a PDF document
     *
     * Does not return on success, just sends the list and dies happily instead.
     * Note that the $lang_id is ignored if it's defined for the Pricelist.
     * @param   integer   $lang_id      The optional language ID
     * @return  boolean                 False on failure
     */
    static function send_pricelist($lang_id=null)
    {
        global $_ARRAYLANG;

        if (!$lang_id) $lang_id = FRONTEND_LANG_ID;
        $list_id = (isset($_GET['list_id'])
            ? intval($_GET['list_id']) : null);
        if (!$list_id) {
            return Message::error($_ARRAYLANG['TXT_SHOP_PRICELIST_ERROR_MISSING_LIST_ID']);
        }
        // Optional
        $currency_id = (isset($_GET['currency_id'])
            ? intval($_GET['currency_id']) : null);
        $objList = new Pricelist($list_id, $currency_id, $lang_id);
        if (!$objList->send_as_pdf()) {
            return Message::error($_ARRAYLANG['TXT_SHOP_PRICELIST_ERROR_SENDING']);
        }
        exit();
    }


    static function customer()
    {
        return self::$objCustomer;
    }


    /**
     * Returns true if the Shop will require a session
     *
     * A session must be initialized if
     * - it has been initialized before (the session cookie is set),
     * - the customer changes the currency, or
     * - the customer puts an article into the cart.
     * In the above cases, this will return true, false otherwise.
     * If true is returned, the caller *MUST* verify the existence of an
     * active session (by checking the state of global $sessionObj) and,
     * if that is empty, instantiate it.  See {@see init()} for more.
     * @return  boolean     True if a session is required, false otherwise
     */
    static function use_session()
    {
// NOTE: This method fails on some server configurations.
// If this is the case, just uncomment the next line and report it to
// <dev@contrexx.com> so that we can investigate the issue.
// Thank you!
        // return true;
//DBG::log("Shop::use_session(): Session name ".  session_name());
//DBG::log("Shop::use_session(): COOKIE: ". var_export($_COOKIE, true));
        if (!empty($_COOKIE[session_name()])) {
            // Note that, if this cookie is set, it has *not* been handled yet!
            // Otherwise, setcookie() would have been called, thus clearing it.
            // Thus, true *MUST* be returned here.
//DBG::log("Shop::use_session(): Have Session Cookie => true");
            return true;
        }
        if (!empty($_REQUEST['currency'])) {
            // The customer will probably choose to change the currency
            // *before* putting articles in the cart.  This implies that
            // no session exists to remember this yet.
//DBG::log("Shop::use_session(): Currency => true");
            return true;
        }
        // However an article is put into the cart (using the JS Cart,
        // or a POST), there *MUST* be a session from this point on.
        // These requests always go to the cart view URI, with some
        // additional parameters:
        //  - AJAX: remoteJs=addProduct&id=<Product ID>
        //  - POST: productId=<Product ID>
        if (   !empty($_GET['cmd']) && $_GET['cmd'] == 'cart'
            && (   isset($_REQUEST['productId'])
                || (   isset($_GET['remoteJs'])
                    && $_GET['remoteJs'] == 'addProduct'
                    && !empty($_GET['id'])))
        ) {
//DBG::log("Shop::use_session(): Put a Product into the Cart => true");
            return true;
        }
        return false;
    }

}
