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
 * Cart
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Reto Kohli <reto.kohli@comvation.com>
 * @version     3.0.0
 * @package     contrexx
 * @subpackage  module_shop
 * @todo        Test!
 */

/**
 * Shop Cart
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Reto Kohli <reto.kohli@comvation.com>
 * @version     3.0.0
 * @package     contrexx
 * @subpackage  module_shop
 * @todo        Test!
 */
class Cart
{
    /**
     * The extensive Cart information with more Product details
     * @var   array
     */
    private static $products = null;


    /**
     * Initialises the Cart
     *
     * Doesn't change anything if it already exists.
     * Otherwise, resets the Cart array in $_SESSION['shop']['cart'].
     * Thank you for respecting its privacy.
     * @static
     */
    static function init()
    {
        if (empty($_SESSION['shop']['cart'])) {
            $_SESSION['shop']['cart'] = array(
                'items' => array(),
                'shipment' => false,
                'total_price' => 0.00,
                'total_vat_amount' => 0.00,
                'total_weight' => 0,
                'total_discount_amount' => 0.00,
            );
        }
    }


    /**
     * Receives a product sent in JSON
     *
     * The parameter $old_cart_id specifies the Product index in the cart.
     * @param   integer $old_cart_id        The product index in the cart
     * @return  array                       Array of the product
     * @static
     */
    static function receive_json()
    {
        if (   empty($_REQUEST['id'])
            || empty($_REQUEST['quantity'])) {
            return;
        }
        if (!include_once(ASCMS_LIBRARY_PATH.'/PEAR/Services/JSON.php')) {
            return;
        }
        $cart_id = null;
        if (isset($_REQUEST['updateProduct'])) {
            $cart_id = intval($_REQUEST['updateProduct']);
        }
        // Note that Cart::add_product() insists on "options" being an array!
        $arrProduct = array(
            'id' => intval($_REQUEST['id']),
            'options' => (isset($_REQUEST['options'])
                ? contrexx_input2raw($_REQUEST['options']) : array()),
            'quantity' => floatval($_REQUEST['quantity']),
        );
        self::add_product($arrProduct, $cart_id);
    }


    /**
     * Sends the cart in JSON
     * @param   array     $arrProducts    The array of Products, as returned
     *                                    by {@see receive_json()} or
     *                                    {@see receive_post()}
     * @see     aCurrencyUnitName, Services_JSON::encode
     * @static
     */
    static function send_json()
    {
        /** @ignore */
        if (!include_once(ASCMS_LIBRARY_PATH.'/PEAR/Services/JSON.php')) {
            die('Could not load JSON library');
        }
        $arrCart = array(
            'items' => self::$products,
            'total_price' => Currency::formatPrice(
                  self::get_price()
                + (Vat::isEnabled() && !Vat::isIncluded()
                    ? self::get_vat_amount() : 0)),
            'item_count' => $_SESSION['shop']['cart']['total_items'],
            'unit' => Currency::getActiveCurrencySymbol()
        );
        $objJson = new Services_JSON();
//DBG::log("send_json(): Sending ".var_export($arrCart, true));
        die($objJson->encode($arrCart));
    }


    /**
     * Gets a product that has been sent through a POST request
     *
     * The reference parameter $old_cart_id specifies the product ID of the cart and
     * is changed to the first key found in $_REQUEST['updateProduct'], if any.
     * @return  array                       Product array of the product that has been
     *                                      specified by the productId field in a (POST) request.
     * @internal    Documentation: Be more elaborate about the meaning of $old_cart_id
     * @static
     */
    static function receive_post()
    {
        if (empty($_REQUEST['productId'])) return;
        $arrProduct = array();
        $cart_id = null;
        if (   isset($_REQUEST['updateProduct'])
            && is_array($_REQUEST['updateProduct'])) {
            $keys = array_keys($_REQUEST['updateProduct']);
            $cart_id = intval($keys[0]);
        }
        $arrOptions = array();
        // Add names of uploaded files to options array, so they will be
        // recognized and added to the product in the cart
        if (!empty($_FILES['productOption']['name'])) {
            $arrOptions = $_FILES['productOption']['name'];
        }
        if (!empty($_POST['productOption'])) {
            $arrOptions = $arrOptions + $_POST['productOption'];
        }
        $arrProduct = array(
            'id' => intval($_REQUEST['productId']),
            'options' => $arrOptions,
            'quantity' => (empty($_POST['productQuantity'])
                ? 1 : intval($_POST['productQuantity'])
            ),
        );
        self::add_product($arrProduct, $cart_id);
    }


    /**
     * Adds a single Product to the Cart
     * @param   array     $arrNewProduct    The array of Product data
     * @param   integer   $old_cart_id      The optional Cart ID (index)
     * @static
     */
    static function add_product($arrNewProduct, $old_cart_id=null)
    {
//DBG::log("Cart::add_product(): Entered, Items: ".var_export($_SESSION['shop']['cart']['items'], true));
        if (empty($arrNewProduct['id'])) {
//DBG::log("Cart::add_product(): No ID");
            return;
        }
        // Do not add zero or negative quantities
        if (   empty($arrNewProduct['quantity'])
            || intval($arrNewProduct['quantity']) <= 0) {
//DBG::log("Cart::add_product(): Invalid quantity");
            return;
        }
        $quantity = intval($arrNewProduct['quantity']);
        $products = $_SESSION['shop']['cart']['items']->toArray(); // $_SESSION is a object so convert into array
        $cart_id = null;
        // Add as a new product if true
        $new = true;
        if (is_null($old_cart_id)) {
            foreach ($products as $cart_id => $arrProduct) {
                // Check whether the same product is already in the cart
                if ($arrProduct['id'] != $arrNewProduct['id']) {
//DBG::log("Cart::add_product(): Different ID, skipping");
                    continue;
                }
//DBG::log("Cart::add_product(): Comparing options: New: ".var_export($arrNewProduct['options'], true).", Old: ".var_export($arrProduct['options'], true));
                // Same ID from here, compare the options
                if (empty($arrNewProduct['options'])) {
                    if (empty($arrProduct['options'])) {
                        // Both got no options, so must be identical
                        $new = false;
//DBG::log("Cart::add_product(): Both no options, match");
                        break;
                    }
                } else {
                    if (empty($arrProduct['options'])) {
                        // The new one's got options, while the old one does not
//DBG::log("Cart::add_product(): Only new options, skipping");
                        continue;
                    }
                }
                // Refuse invalid options
                if (!is_array($arrNewProduct['options'])) {
//DBG::log("Cart::add_product(): Invalid options: {$arrNewProduct['options']}, exiting");
                    return;
                }
                $old_attribute_ids = array_keys($arrProduct['options']);
                sort($old_attribute_ids);
                $new_attribute_ids = array();
                foreach ($arrNewProduct['options'] as $attribute_id => $value) {
                    if (empty($value)) {
//DBG::log("Cart::add_product(): New: no options for Attribute ID $attribute_id");
                        continue;
                    }
                    $new_attribute_ids[] = $attribute_id;
                }
                sort($new_attribute_ids);
                if (!$old_attribute_ids === $new_attribute_ids) {
//DBG::log("Cart::add_product(): Different Attributes: New: ".var_export($new_attribute_ids, true).", Old: ".var_export($old_attribute_ids, true));
                    continue;
                }

                // Compare options
                // check for the same option values
                foreach ($arrNewProduct['options'] as $attribute_id => $value) {
                    if (empty($value)) {
//DBG::log("Cart::add_product(): New: Empty option value for Attribute ID $attribute_id");
                        continue;
                    }
                    if (isset ($arrProduct['options'][$attribute_id])
                     && is_array($arrProduct['options'][$attribute_id])) {
                        $arrPostValues = array();
                        if (is_array($value)) {
                            $arrPostValues = array_values($value);
                        } else {
                            array_push($arrPostValues, $value);
                        }
                        if ($arrPostValues !== $arrProduct['options'][$attribute_id]) {
//DBG::log("Cart::add_product(): Different options: New: ".var_export($arrPostValues, true).", Old: ".var_export($arrProduct['options'][$attribute_id], true));
                            continue 2;
                        }
                    } else {
                        if (!isset($arrProduct['options'][$attribute_id][$value])) {
//DBG::log("Cart::add_product(): Missing option");
                            continue 2;
                        }
                    }
                }
                // All options identical
                $new = false;
//DBG::log("Cart::add_product(): Identical options as Cart ID $cart_id: New: ".var_export($arrNewProduct['options'], true).", Old: ".var_export($arrProduct['options'], true));
                break;
            }
//DBG::log("Cart::add_product(): No match!");
        }
//DBG::log("Cart::add_product(): Comparing done, cart ID $cart_id");
        if ($new) {
            if (isset($old_cart_id)) {
//DBG::log("Cart::add_product(): New Product: Replacing cart ID with old $old_cart_id");
                $cart_id = $old_cart_id;
            } else {
//DBG::log("Cart::add_product(): New Product: Creating new cart ID");
// TODO: True? // $arrNewProduct['id'] may be undefined!
                $arrProduct = array(
                    'id' => $arrNewProduct['id'],
                    'quantity' => $quantity,
                );
                array_push($products, $arrProduct);
                $arrKeys = array_keys($products);
                $cart_id = $arrKeys[count($arrKeys)-1];
            }
        } else {
            if (isset($old_cart_id)) {
//DBG::log("Cart::add_product(): Old Product: Have cart ID...");
                if ($old_cart_id != $cart_id) {
//DBG::log("Cart::add_product(): Old Product: Merging");
                    $products[$cart_id]['quantity'] +=
                        $products[$old_cart_id]['quantity'];
                    unset($products[$old_cart_id]);
                } else {
//DBG::log("Cart::add_product(): Old Product: Same cart ID, not merged!");
                }
            } else {
//DBG::log("Cart::add_product(): Old Product: Adding quantity $quantity to {$products[$cart_id]['quantity']} in cart ID $cart_id (old ID $old_cart_id)");
                $products[$cart_id]['quantity'] +=
                    $quantity;
//DBG::log("Cart::add_product(): Old Product: Updated quantity to {$_SESSION['shop']['cart']['items'][$cart_id]['quantity']}");
            }
        }
        // Add options
// TODO: I suspect that this could be completely skipped when $new === false!?
        $products[$cart_id]['options'] = array();
        if (isset($arrNewProduct['options']) && count($arrNewProduct['options']) > 0) {
//DBG::log("Cart::add_product(): Adding options: New: ".var_export($arrNewProduct['options'], true));
            foreach ($arrNewProduct['options'] as $attribute_id => $option_id) {
                $attribute_id = intval($attribute_id);
                // Get Attribute
                $objAttribute = Attribute::getById($attribute_id);
                if (!$objAttribute) continue;
                $type = $objAttribute->getType();
                if (   $type == Attribute::TYPE_TEXT_OPTIONAL
                    || $type == Attribute::TYPE_TEXT_MANDATORY) {
                    if ($option_id == '') continue;
                }
                if (   $type == Attribute::TYPE_UPLOAD_OPTIONAL
                    || $type == Attribute::TYPE_UPLOAD_MANDATORY) {
                    $option_id = Shop::uploadFile($attribute_id);
                    if ($option_id == '') {
                        continue;
                    }
                }
                if (!isset($products[$cart_id]['options'][$attribute_id])) {
                    $products[$cart_id]['options'][$attribute_id] = array();
                }
                if (is_array($option_id) && count($option_id)) {
                    foreach ($option_id as $id) {
                        array_push($products[$cart_id]['options'][$attribute_id], $id);
                    }
                } elseif (!empty($option_id)) {
                    array_push($products[$cart_id]['options'][$attribute_id],
                        contrexx_input2raw($option_id));
                }
            }
        }
        $_SESSION['shop']['cart']['items'] = $products;
//DBG::log("Cart::add_product(): New options: ".var_export($products[$cart_id]['options'], true));
//DBG::log("Cart::add_product(): Leaving");
    }


    /**
     * Updates a Products' quantity in the Cart
     *
     * Picks all quantities from the $_REQUEST['quantity'] array, where
     * Products are listed by their Cart IDs, like:
     *  $_REQUEST = array(
     *    'quantity' => array(
     *      cart_id => quantity,
     *      [... more ...]
     *    ),
     *    [... more ...]
     *  );
     * @static
     */
    static function update_quantity()
    {
      if (   empty($_REQUEST['quantity'])
          || !is_array($_REQUEST['quantity'])) {
//DBG::log("Cart::update_quantity(): No Quantities array");
              return;
        }
//DBG::log("Cart::update_quantity(): Quantities: ".var_export($_REQUEST['quantity'], true));
        // Update quantity to cart
        if (empty($_SESSION['shop']['cart']['items'])) return;
        foreach (array_keys($_SESSION['shop']['cart']['items']->toArray()) as $cartId) {
            // Remove Products
            if (isset($_REQUEST['quantity'][$cartId])) {
                if (intval($_REQUEST['quantity'][$cartId] < 1)) {
                    unset($_SESSION['shop']['cart']['items'][$cartId]);
                } else {
                    $_SESSION['shop']['cart']['items'][$cartId]['quantity'] =
                        intval($_REQUEST['quantity'][$cartId]);
                }
//DBG::log("Cart::update_quantity(): Cart ID $cartId quantity: {$_SESSION['shop']['cart']['items'][$cartId]['quantity']}");
            }
        }
    }


    /**
     * Updates values in the session array with the current Cart contents,
     * and returns an array of Product data
     *
     * Called right after a Product has been added by {@see add_product()} or
     * quantities changed by {@see update_quantity()}.
     * Also computes the new count of items in the cart and calculates the
     * amount.
     * Stores details of the Products in the Cart in $products.
     * Note that the $objCustomer parameter is mandatory, but may be empty
     * in case it is a new Customer shopping.
     * @param   Customer    $objCustomer          The Customer
     * @global  ADONewConnection  $objDatabase    Database connection object
     * @return  boolean                           True on success,
     *                                            false otherwise
     * @static
     */
    static function update($objCustomer)
    {
//DBG::log("Cart::update(): Cart: ".var_export($_SESSION['shop']['cart'], true));
        if (empty($_SESSION['shop']['cart'])) {
            self::init();
            return true;//self::get_products_array();
        }
        // No shipment by default.  Only if at least one Product with
        // type "delivery" is encountered, it is switched on.
        $_SESSION['shop']['cart']['shipment'] = false;
        $total_discount_amount = 0;
        $coupon_code = (isset($_SESSION['shop']['coupon_code'])
            ? $_SESSION['shop']['coupon_code'] : '');
        $payment_id = (isset($_SESSION['shop']['paymentId'])
            ? $_SESSION['shop']['paymentId'] : 0);
        $customer_id = ($objCustomer ? $objCustomer->id() : 0);
//DBG::log("Cart::update(): Coupon Code: $coupon_code");
        self::$products = array();
        $items = 0;
        $total_price = 0;
        $total_vat_amount = 0;
        $total_weight = 0;
        $total_discount_amount = 0;
//DBG::log("Cart::update(): Products: ".var_export($products, true));
        // Loop 1: Collect necessary Product data
        $products = $_SESSION['shop']['cart']['items']->toArray();
        foreach ($products as $cart_id => &$product) {
            $objProduct = Product::getById($product['id']);
            if (!$objProduct) {
                unset($products[$cart_id]);
                continue;
            }
            // Limit Products in the cart to the stock available if the
            // stock_visibility is enabled.
            if ($objProduct->stock_visible()
             && $product['quantity'] > $objProduct->stock()) {
                $product['quantity'] = $objProduct->stock();
            }
            // Remove Products with quatities of zero or less
            if ($product['quantity'] <= 0) {
                unset($products[$cart_id]);
                continue;
            }
            $options_price = 0;
            // Array!
            $options_strings = Attributes::getAsStrings(
                $product['options'], $options_price);
//DBG::log("Cart::update(): options_price $options_price");
/* Replaced by Attributes::getAsStrings()
            foreach ($product['options'] as $attribute_id => $arrOptionIds) {
                $objAttribute = Attribute::getById($attribute_id);
                // Should be tested!
                if (!$objAttribute) {
                    unset($product['options'][$attribute_id]);
                    continue;
                }
                $arrOptions = $objAttribute->getOptionArray();
                foreach ($arrOptionIds as $option_id) {
                    $arrOption = null;
                    // Note that the options are indexed starting from 1!
                    // For types 4..7, the value entered in the text box is
                    // stored in $option_id.  Overwrite the value taken from
                    // the database.
                    if ($objAttribute->getType() >= Attribute::TYPE_TEXT_OPTIONAL) {
                        $arrOption = current($arrOptions);
                        $arrOption['value'] = $option_id;
                    } else {
                        $arrOption = $arrOptions[$option_id];
                    }
                    if (!is_array($arrOption)) continue;
                    $option_value = ShopLibrary::stripUniqidFromFilename($arrOption['value']);
                    $path = Order::UPLOAD_FOLDER.$arrOption['value'];
                    if (   $option_value != $arrOption['value']
                        && File::exists($path)) {
                        $option_value =
                            '<a href="$path" target="uploadimage">'.
                            $option_value.'</a>';
                    }
                    $options .= " [$option_value]";
                    $options_price += $arrOption['price'];
                }
            }
            if ($options_price != 0) {
                $product['optionPrice'] = $options_price;
            }
 */
            $quantity = $product['quantity'];
            $items += $quantity;
            $itemprice = $objProduct->get_custom_price(
                $objCustomer,
                $options_price,
                $quantity
            );
            $price = $itemprice * $quantity;
            $handler = $objProduct->distribution();
            $itemweight = ($handler == 'delivery' ? $objProduct->weight() : 0);
            // Requires shipment if the distribution type is 'delivery'
            if ($handler == 'delivery') {
//DBG::log("Cart::update(): Product ID ".$objProduct->id()." needs delivery");
                $_SESSION['shop']['cart']['shipment'] = true;
            }
            $weight = $itemweight * $quantity;
            $vat_rate = Vat::getRate($objProduct->vat_id());
            $total_price += $price;
            $total_weight += $weight;
            self::$products[$cart_id] = array(
                'id' => $objProduct->id(),
                'product_id' => $objProduct->code(),
                'cart_id' => $cart_id,
                'title' =>
                    (empty($_GET['remoteJs'])
                      ? $objProduct->name()
                      : htmlspecialchars(
                          (strtolower(CONTREXX_CHARSET) == 'utf-8'
                            ? $objProduct->name()
                            : utf8_encode($objProduct->name())),
                          ENT_QUOTES, CONTREXX_CHARSET)),
                'options' => $product['options'],
                'options_long' => $options_strings[0],
                'options_cart' => $options_strings[1],
                'price' => Currency::formatPrice($price),
                'quantity' => $quantity,
                'itemprice' => Currency::formatPrice($itemprice),
                'vat_rate' => $vat_rate,
                'itemweight' => $itemweight, // in grams!
                'weight' => $weight,
                'group_id' => $objProduct->group_id(),
                'article_id' => $objProduct->article_id(),
            );
//DBG::log("Cart::update(): Loop 1: Product: ".var_export(self::$products[$cart_id], true));
        }
        $_SESSION['shop']['cart']['items'] = $products;
        // Loop 2: Calculate Coupon discounts and VAT
        $objCoupon = null;
        $hasCoupon = false;
        $discount_amount = 0;
        foreach (self::$products as $cart_id => &$product) {
            $discount_amount = 0;
            // Coupon:  Either the payment ID or the code are needed
            if ($payment_id || $coupon_code) {
                $objCoupon = Coupon::available(
                    $coupon_code, $total_price, $customer_id,
                    $product['id'], $payment_id);
                if ($objCoupon) {
                    $hasCoupon = true;
//DBG::log("Cart::update(): PRODUCT; Coupon available: $coupon_code, Product ID {$product['id']}");
//DBG::log("Cart::update(): Loop 2: Product: ".var_export($product, true));
                    $discount_amount = $objCoupon->getDiscountAmount(
                        $product['price'], $customer_id);
                    if (   $objCoupon->discount_amount() > 0
                        && ($total_discount_amount + $discount_amount)
                            > $objCoupon->discount_amount()) {
//DBG::log("Cart::update(): COUPON prelimit: PRODUCT: price ".$product['price'].", coupon discount amount ".$objCoupon->discount_amount().", discount_amount $discount_amount, total discount amount $total_discount_amount");
                        $discount_amount =
                            $objCoupon->discount_amount()
                          - $total_discount_amount;
//DBG::log("Cart::update(): COUPON postlimit: PRODUCT: price ".$product['price'].", coupon discount amount ".$objCoupon->discount_amount().", discount_amount $discount_amount, total discount amount $total_discount_amount");
                    }
                    $total_discount_amount += $discount_amount;
//                    $product['price'] = Currency::formatPrice(
//                        $product['price'] - $discount_amount);
                    $product['discount_amount'] = $discount_amount;
// UNUSED
//                        $arrProduct['coupon_string'] =
//                            $objCoupon->getString($discount_amount);
//DBG::log("Cart::update(): PRODUCT: price ".$product['price'].", discount_amount $discount_amount, total discount $total_discount_amount");
                }
            }
            // Calculate the amount if it's excluded; we might add it later:
            // - If it's included, we don't care.
            // - If it's disabled, it's set to zero.
            $vat_amount = Vat::amount($product['vat_rate'],
                $product['price']
              - $product['discount_amount']
            );
            if (!Vat::isIncluded()) {
                self::$products[$cart_id]['price'] += $vat_amount;
                self::$products[$cart_id]['price'] = Currency::formatPrice(self::$products[$cart_id]['price']);
            }
            $total_vat_amount += $vat_amount;
            self::$products[$cart_id]['vat_amount'] =
                Currency::formatPrice($vat_amount);
        }
        // Global Coupon:  Either the payment ID or the code are needed
        if (!$objCoupon && ($payment_id || $coupon_code)) {
            $discount_amount = 0;
//DBG::log("Cart::update(): GLOBAL; Got Coupon code $coupon_code");
            $total_price_incl_vat = $total_price;
            if (!Vat::isIncluded()) {
                $total_price_incl_vat += $total_vat_amount;
            }
            $objCoupon = Coupon::available(
                $coupon_code, $total_price_incl_vat, $customer_id, 0, $payment_id);
            if ($objCoupon) {
                $hasCoupon = true;
                $discount_amount = $objCoupon->getDiscountAmount(
                    $total_price_incl_vat, $customer_id);
                $total_discount_amount = $discount_amount;
//DBG::log("Cart::update(): GLOBAL; Coupon available: $coupon_code");
//DBG::log("Cart::update(): GLOBAL; total price $total_price, discount_amount $discount_amount, total discount $total_discount_amount");
            }
        }
        if ($objCoupon) {
//DBG::log("Cart::update(): Got Coupon ".var_export($objCoupon, true));
            $total_price -= $discount_amount;
//DBG::log("Cart::update(): COUPON; total price $total_price, discount_amount $discount_amount, total discount $total_discount_amount");
        }
        if ($hasCoupon) {
            Message::clear();
        }

        $_SESSION['shop']['cart']['total_discount_amount'] =
            $total_discount_amount;
        $_SESSION['shop']['cart']['total_price'] =
            Currency::formatPrice($total_price);
        $_SESSION['shop']['cart']['total_vat_amount'] =
            Currency::formatPrice($total_vat_amount);
//DBG::log("Cart::update(): Updated Cart (session): VAT amount: ".$_SESSION['shop']['cart']['total_vat_amount']);
        $_SESSION['shop']['cart']['total_items'] = $items;
        $_SESSION['shop']['cart']['total_weight'] = $total_weight; // In grams!
//DBG::log("Cart::update(): Updated Cart (session): ".var_export($_SESSION['shop']['cart'], true));
        return true;
    }


    /**
     * Returns the current total number of items in the Cart
     *
     * Take care that the Cart is {@see update()}d first, if necessary.
     * @return  integer             The current total number of items
     */
    static function get_item_count()
    {
        if (empty($_SESSION['shop']['cart']['total_items'])) return 0;
        return $_SESSION['shop']['cart']['total_items'];
    }


    /**
     * Returns true if there are no Products in the Cart
     * @return    boolean           True on empty Cart, false otherwise
     */
    static function is_empty()
    {
        return empty($_SESSION['shop']['cart']['items']);
    }


    /**
     * Returns the Product ID for the given Cart ID
     *
     * If there is no Product for that Cart ID, returns null.
     * @return  integer           The Product ID, if present, or null
     */
    static function get_product_id($cart_id)
    {
        if (empty($_SESSION['shop']['cart']['items'][$cart_id]['id']))
            return null;
        return $_SESSION['shop']['cart']['items'][$cart_id]['id'];
    }


    /**
     * Returns the Product array
     *
     * Do not call this before {@see init()}.
     * Mind that that array may be empty.
     * If present, the Product data is indexed by the cart ID.
     * If there is no such array, returns null.
     * @return  array               The products array
     */
    static function get_products_array()
    {
        return $_SESSION['shop']['cart']['items']->toArray();
    }


    /**
     * Returns the Options array for the given Cart and Attribute ID
     *
     * If there is no such array, returns null.
     * @return  array               The options array
     */
    static function get_options_array($cart_id, $attribute_id)
    {
        if (empty($_SESSION['shop']['cart']['items'][$cart_id]['options'][$attribute_id]))
            return null;
        return $_SESSION['shop']['cart']['items'][$cart_id]['options'][$attribute_id];
    }


    /**
     * Returns the current total price of all items in the Cart
     *
     * Take care that the Cart is {@see update()}d first, if necessary.
     * @return  float               The current total price
     */
    static function get_price()
    {
        return $_SESSION['shop']['cart']['total_price'];
    }


    /**
     * Returns the current total weight of all items in the Cart
     *
     * Take care that the Cart is {@see update()}d first, if necessary.
     * @return  integer              The current total weight
     */
    static function get_weight()
    {
        return $_SESSION['shop']['cart']['total_weight'];
    }


    /**
     * Returns true if at least one item in the Cart needs shipment
     *
     * Take care that the Cart is {@see update()}d first, if necessary.
     * @return  boolean             True if shipment is necessary,
     *                              false otherwise
     */
    static function needs_shipment()
    {
        return (isset($_SESSION['shop']['cart']['shipment'])
            ? $_SESSION['shop']['cart']['shipment'] : FALSE);
    }


    /**
     * Returns the current total VAT amount of all items in the Cart
     *
     * Take care that the Cart is {@see update()}d first, if necessary.
     * @return  float               The current total VAT amount
     */
    static function get_vat_amount()
    {
        return $_SESSION['shop']['cart']['total_vat_amount'];
    }


    /**
     * Returns the current total discount amount of all items in the Cart
     *
     * Take care that the Cart is {@see update()}d first, if necessary.
     * @return  float               The current total discount amount
     */
    static function get_discount_amount()
    {
        return $_SESSION['shop']['cart']['total_discount_amount'];
    }


    /**
     * Destroys the Cart's contents
     *
     * Calls {@see update()} after flushing the items.
     */
    static function destroy()
    {
        $_SESSION['shop']['cart'] = null;
        self::update(null);
    }


    /**
     * The Cart view
     *
     * Mind that the Cart needs to be {@see update()}d before calling this
     * method.
     * @global  array $_ARRAYLANG   Language array
     * @param   \Cx\Core\Html\Sigma $objTemplate  The optional Template
     */
    static function view($objTemplate=null)
    {
        global $_ARRAYLANG;

        if (!$objTemplate) {
// TODO: Handle missing or empty Template, load one
die("Cart::view(): ERROR: No template");
//            return false;
}
        $objTemplate->setGlobalVariable($_ARRAYLANG);
        $i = 0;
        if (count(self::$products)) {
            foreach (self::$products as $arrProduct) {
                $groupCountId = $arrProduct['group_id'];
                $groupArticleId = $arrProduct['article_id'];
                $groupCustomerId = 0;
                if (Shop::customer()) {
                    $groupCustomerId = Shop::customer()->group_id();
                }
                Shop::showDiscountInfo(
                    $groupCustomerId, $groupArticleId,
                    $groupCountId, $arrProduct['quantity']
                );
/* UNUSED (and possibly obsolete, too)
                if (isset($arrProduct['discount_string'])) {
//DBG::log("Shop::view_cart(): Product ID ".$arrProduct['id'].": ".$arrProduct['discount_string']);
                    $objTemplate->setVariable(
                        'SHOP_DISCOUNT_COUPON_STRING',
                            $arrProduct['coupon_string']
                    );
                }*/
                // The fields that don't apply have been set to ''
                // (empty string) already -- see update().
                $objTemplate->setVariable(array(
                    'SHOP_PRODUCT_ROW' => 'row'.(++$i % 2 + 1),
                    'SHOP_PRODUCT_ID' => $arrProduct['id'],
                    'SHOP_PRODUCT_CODE' => $arrProduct['product_id'],
                    'SHOP_PRODUCT_CART_ID' => $arrProduct['cart_id'],
                    'SHOP_PRODUCT_TITLE' => str_replace('"', '&quot;', contrexx_raw2xhtml($arrProduct['title'])),
                    'SHOP_PRODUCT_PRICE' => $arrProduct['price'],  // items * qty
                    'SHOP_PRODUCT_PRICE_UNIT' => Currency::getActiveCurrencySymbol(),
                    'SHOP_PRODUCT_QUANTITY' => $arrProduct['quantity'],
                    'SHOP_PRODUCT_ITEMPRICE' => $arrProduct['itemprice'],
                    'SHOP_PRODUCT_ITEMPRICE_UNIT' => Currency::getActiveCurrencySymbol(),
// TODO: Move this to (global) language variables
                    'SHOP_REMOVE_PRODUCT' => $_ARRAYLANG['TXT_SHOP_REMOVE_ITEM'],
                ));
//DBG::log("Attributes String: {$arrProduct['options_long']}");
                if ($arrProduct['options_long']) {
                    $objTemplate->setVariable(
                        'SHOP_PRODUCT_OPTIONS', $arrProduct['options_long']);
                }
                if (SettingDb::getValue('weight_enable')) {
                    $objTemplate->setVariable(array(
                        'SHOP_PRODUCT_WEIGHT' => Weight::getWeightString($arrProduct['weight']),
                        'TXT_WEIGHT' => $_ARRAYLANG['TXT_TOTAL_WEIGHT'],
                    ));
                }
                if (Vat::isEnabled()) {
                    $objTemplate->setVariable(array(
                        // avoid a lonely '%' percent sign in case 'vat_rate' is unset
                        'SHOP_PRODUCT_TAX_RATE' => ($arrProduct['vat_rate']
                            ? Vat::format($arrProduct['vat_rate']) : ''),
                        'SHOP_PRODUCT_TAX_AMOUNT' =>
                            $arrProduct['vat_amount'].'&nbsp;'.
                            Currency::getActiveCurrencySymbol(),
                    ));
                }
                $objTemplate->parse('shopCartRow');
            }
        } else {
            $objTemplate->hideBlock('shopCart');
            if ($objTemplate->blockExists('shopCartEmpty')) {
                $objTemplate->touchBlock('shopCartEmpty');
                $objTemplate->parse('shopCartEmpty');
            }
        }

        $objTemplate->setGlobalVariable(array(
            'TXT_PRODUCT_ID' => $_ARRAYLANG['TXT_ID'],
            'SHOP_PRODUCT_TOTALITEM' => self::get_item_count(),
            'SHOP_PRODUCT_TOTALPRICE' => Currency::formatPrice(
                  self::get_price()),
            // Add the VAT in the intermediate sum, if active and excluded
            'SHOP_PRODUCT_TOTALPRICE_PLUS_VAT' => Currency::formatPrice(
                  self::get_price()
                + (Vat::isEnabled() && !Vat::isIncluded()
                    ? self::get_vat_amount() : 0)),
            'SHOP_PRODUCT_TOTALPRICE_UNIT' => Currency::getActiveCurrencySymbol(),
            'SHOP_TOTAL_WEIGHT' => Weight::getWeightString(self::get_weight()),
            'SHOP_PRICE_UNIT' => Currency::getActiveCurrencySymbol(),
        ));

        // Show the Coupon code field only if there is at least one defined
        if (Coupon::count_available()) {
//DBG::log("Coupons available");
            $objTemplate->setVariable(array(
                'SHOP_DISCOUNT_COUPON_CODE' =>
                    (isset ($_SESSION['shop']['coupon_code'])
                        ? $_SESSION['shop']['coupon_code'] : ''),
            ));
            if ($objTemplate->blockExists('shopCoupon')) {
                $objTemplate->parse('shopCoupon');
            }
            if (self::get_discount_amount()) {
                $total_discount_amount = self::get_discount_amount();
//DBG::log("Shop::view_cart(): Total: Amount $total_discount_amount");
                $objTemplate->setVariable(array(
//                    'SHOP_DISCOUNT_COUPON_TOTAL_AMOUNT' => $coupon_string,
                    'SHOP_DISCOUNT_COUPON_TOTAL' =>
                        $_ARRAYLANG['TXT_SHOP_DISCOUNT_COUPON_AMOUNT_TOTAL'],
                    'SHOP_DISCOUNT_COUPON_TOTAL_AMOUNT' => Currency::formatPrice(
                        -$total_discount_amount),
                ));
            }
        }

        if (Vat::isEnabled()) {
            $objTemplate->setVariable(array(
                'TXT_TAX_PREFIX' =>
                    (Vat::isIncluded()
                        ? $_ARRAYLANG['TXT_SHOP_VAT_PREFIX_INCL']
                        : $_ARRAYLANG['TXT_SHOP_VAT_PREFIX_EXCL']
                    ),
                // Removed parenthesess for 2.0.2
                // Add them to the template if desired!
                'SHOP_TOTAL_TAX_AMOUNT' =>
                    self::get_vat_amount().
                    '&nbsp;'.Currency::getActiveCurrencySymbol(),

            ));
            if (Vat::isIncluded()) {
                $objTemplate->setVariable(array(
                    'SHOP_GRAND_TOTAL_EXCL_TAX' =>
                        Currency::formatPrice(self::get_price() - self::get_vat_amount()).'&nbsp;'.
                        Currency::getActiveCurrencySymbol(),
                ));
            }
        }
        if (self::needs_shipment()) {
            $objTemplate->setVariable(array(
                'TXT_SHIP_COUNTRY' => $_ARRAYLANG['TXT_SHIP_COUNTRY'],
                // Old, obsolete
                'SHOP_COUNTRIES_MENU' => Country::getMenu(
                    'countryId2', $_SESSION['shop']['countryId2'],
                        true, "document.forms['shopForm'].submit()"),
                // New; use this so you can apply CSS more easily
                'SHOP_COUNTRIES_MENUOPTIONS' => Country::getMenuoptions(
                    $_SESSION['shop']['countryId2']),
            ));
        }
        if (   SettingDb::getValue('orderitems_amount_min') > 0
            && SettingDb::getValue('orderitems_amount_min') > self::get_price()
        ) {
            $objTemplate->setVariable(
                'MESSAGE_TEXT',
                    sprintf(
                        $_ARRAYLANG['TXT_SHOP_ORDERITEMS_AMOUNT_MIN'],
                        Currency::formatPrice(
                            SettingDb::getValue('orderitems_amount_min')),
                        Currency::getActiveCurrencySymbol()));
        } elseif (
               SettingDb::getValue('orderitems_amount_max') > 0
            && SettingDb::getValue('orderitems_amount_max') < self::get_price()
        ) {
            $objTemplate->setVariable(
                'MESSAGE_TEXT',
                    sprintf(
                        $_ARRAYLANG['TXT_SHOP_ORDERITEMS_AMOUNT_MAX'],
                        Currency::formatPrice(
                            SettingDb::getValue('orderitems_amount_max')),
                        Currency::getActiveCurrencySymbol()));
        } else {
            $objTemplate->setVariable(
                'TXT_NEXT', $_ARRAYLANG['TXT_NEXT']);
        }
    }


// TODO: implement/test this
    /**
     * Restores the Cart from the Order ID given
     *
     * Redirects to the login when nobody is logged in.
     * Redirects to the history overview when the Order cannot be loaded,
     * or when it does not belong to the current Customer.
     * When $editable is true, redirects to the detail view of the first
     * Item for editing.  Editing will be disabled otherwise.
     * @global  array   $_ARRAYLANG
     * @param   integer $order_id   The Order ID
     * @param   boolean $editable   Items in the Cart are editable iff true
     */
    static function from_order($order_id, $editable=false)
    {
        global $_ARRAYLANG;

        $objCustomer = Shop::customer();
        if (!$objCustomer) {
            Message::information($_ARRAYLANG['TXT_SHOP_ORDER_LOGIN_TO_REPEAT']);
            \CSRF::redirect(
                Cx\Core\Routing\Url::fromModuleAndCmd('shop', 'login').
                '?redirect='.base64_encode(
                    Cx\Core\Routing\Url::fromModuleAndCmd('shop', 'cart').
                    '?order_id='.$order_id));
        }
        $customer_id = $objCustomer->getId();
        $order = Order::getById($order_id);
        if (!$order || $order->customer_id() != $customer_id) {
            Message::warning($_ARRAYLANG['TXT_SHOP_ORDER_INVALID_ID']);
            \CSRF::redirect(
                Cx\Core\Routing\Url::fromModuleAndCmd('shop', 'history'));
        }
// Optional!
        self::destroy();
        $_SESSION['shop']['shipperId'] = $order->shipment_id();
        $_SESSION['shop']['paymentId'] = $order->payment_id();
        $order_attributes = $order->getOptionArray();
        $count = null;
        $arrAttributes = Attributes::getArray($count, 0, -1, null, array());
        // Find an Attribute and option IDs for the reprint type
        $attribute_id_reprint = $option_id_reprint = NULL;
        if (!$editable) {
//DBG::log("Cart::from_order(): Checking for reprint...");
            foreach ($arrAttributes as $attribute_id => $objAttribute) {
                if ($objAttribute->getType() == Attribute::TYPE_EZS_REPRINT) {
//DBG::log("Cart::from_order(): TYPE reprint");
                    $options = $objAttribute->getOptionArray();
                    if ($options) {
                        $option_id_reprint = current(array_keys($options));
                        $attribute_id_reprint = $attribute_id;
//DBG::log("Cart::from_order(): Found reprint Attribute $attribute_id_reprint, option $option_id_reprint");
                        break;
                    }
                }
            }
        }
        foreach ($order->getItems() as $item) {
            $item_id = $item['item_id'];
            $attributes = $order_attributes[$item_id];
            $options = array();
            foreach ($attributes as $attribute_id => $attribute) {
//                foreach (array_keys($attribute['options']) as $option_id) {
                foreach ($attribute['options'] as $option_id => $option) {
//DBG::log("Cart::from_order(): Option: ".var_export($option, true));
                    switch ($arrAttributes[$attribute_id]->getType()) {
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
                        case Attribute::TYPE_EZS_ACCOUNT_3:
                        case Attribute::TYPE_EZS_ACCOUNT_4:
                        case Attribute::TYPE_EZS_IBAN:
                        case Attribute::TYPE_EZS_IN_FAVOR_OF:
                        case Attribute::TYPE_EZS_REFERENCE:
                        case Attribute::TYPE_EZS_CLEARING:
                        case Attribute::TYPE_EZS_DEPOSIT_FOR_6:
                        case Attribute::TYPE_EZS_DEPOSIT_FOR_2L:
                        case Attribute::TYPE_EZS_DEPOSIT_FOR_2H:
                        case Attribute::TYPE_EZS_PURPOSE_35:
                        case Attribute::TYPE_EZS_PURPOSE_50:
                            $options[$attribute_id][] = $option['name'];
                            break;
                        case Attribute::TYPE_EZS_REDPLATE:
                        case Attribute::TYPE_EZS_CONFIRMATION:
                            if (!$attribute_id_reprint) {
//DBG::log("Cart::from_order(): No reprint, adding option {$option['name']}");
                                $options[$attribute_id][] = $option_id;
                            }
                            break;
                        case Attribute::TYPE_EZS_REPRINT:
                            // Automatically added below when appropriate
                            break;
                        default:
//                        case Attribute::TYPE_EZS_ZEWOLOGO:
//                        case Attribute::TYPE_EZS_EXPRESS:
//                        case Attribute::TYPE_EZS_PURPOSE_BOLD:
                            $options[$attribute_id][] = $option_id;
                            break;
                    }
//DBG::log("Cart::from_order(): Added option: ".var_export($options, true));
                }
            }
            if ($attribute_id_reprint) {
                $options[$attribute_id_reprint][] = $option_id_reprint;
//DBG::log("Cart::from_order(): Item has reprint Attribute, added $attribute_id_reprint => ($option_id_reprint)");
            }
            self::add_product(array(
                'id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'options' => $options,
            ));
        }
        if ($attribute_id_reprint) {
            // Mark the Cart as being unchanged since the restore, so the
            // additional cost for some Attributes won't be added again.
            self::restored_order_id($order_id);
        }
        Message::information($_ARRAYLANG['TXT_SHOP_ORDER_RESTORED']);
// Enable for production
        \CSRF::redirect(
            Cx\Core\Routing\Url::fromModuleAndCmd('shop', 'cart'));
    }


// c_sp
    /**
     * Returns the original Order ID from which the Cart has been restored
     *
     * Optionally sets the given Order ID.
     * Set to 0 (zero) in order to mark the Cart as changed (different from
     * the original Order, apart from single item quantities)
     * @param   integer   $order_id     The optional original Order ID,
     *                                  or 0 (zero)
     * @return  integer                 The original Order ID
     * @author      Reto Kohli <reto.kohli@comvation.com>
     */
    static function restored_order_id($order_id=null)
    {
        if (isset($order_id)) {
            $_SESSION['shop']['restored_order_id'] = max(0, intval($order_id));
        }
        return (isset($_SESSION['shop']['restored_order_id'])
            ? $_SESSION['shop']['restored_order_id']
            : 0);
    }


    /**
     * Returns the quantity set for the given Cart ID
     *
     * If the Cart ID is invalid, returns 0 (zero).
     * @param   integer $cart_id        The Cart ID
     * @return  integer                 The quantity
     */
    static function get_quantity_by_cart_id($cart_id)
    {
        if (empty(self::$products)) {
            self::update(null);
        }
        if (empty(self::$products[$cart_id])
            && empty(self::$products[$cart_id]['quantity'])) {
            return 0;
        }
        return self::$products[$cart_id]['quantity'];
    }

}
