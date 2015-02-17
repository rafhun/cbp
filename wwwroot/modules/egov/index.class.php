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
 * E-Government
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Comvation Development Team <info@comvation.com>
 * @version     1.0.0
 * @package     contrexx
 * @subpackage  module_egov
 * @todo        Edit PHP DocBlocks!
 */
/**
 * E-Government
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Comvation Development Team <info@comvation.com>
 * @access      public
 * @version     1.0.0
 * @package     contrexx
 * @subpackage  module_egov
 */
class eGov extends eGovLibrary
{
    private $_arrFormFieldTypes;

    /**
     * Initialize forms and template
     * @param   string  $pageContent    The page content template
     * @return  eGov                    The eGov object
     */
    function __construct($pageContent)
    {
        $this->initContactForms();
        $this->pageContent = $pageContent;
        $this->objTemplate = new \Cx\Core\Html\Sigma('.');
        CSRF::add_placeholder($this->objTemplate);
        $this->objTemplate->setErrorHandling(PEAR_ERROR_DIE);
        $this->objTemplate->setTemplate($this->pageContent, true, true);
    }


    /**
     * Returns the page content built from the current template
     * @return  string              The page content
     */
    function getPage()
    {
        if (empty($_GET['cmd'])) {
            $_GET['cmd'] = '';
        }
        switch($_GET['cmd']) {
            case 'detail':
                $this->_ProductDetail();
                break;
            default:
                $this->_ProductsList();
        }
        return $this->objTemplate->get();
    }


    /**
     * Save any order received from the form page.
     *
     * Calls the {@see payment()} method to handle any payment being made
     * when appropriate.
     * @return  string              The status message if an error occurred,
     *                              the empty string otherwise
     */
    function _saveOrder()
    {
        global $objDatabase, $_ARRAYLANG;

        $product_id = intval($_REQUEST['id']);
        $datum_db = date('Y-m-d H:i:s');
        $ip_adress = $_SERVER['REMOTE_ADDR'];

        $arrFields = self::getFormFields($product_id);
        $FormValue = '';
        foreach ($arrFields as $fieldId => $arrField) {
            $FormValue .= $arrField['name'].'::'.strip_tags(contrexx_addslashes($_REQUEST['contactFormField_'.$fieldId])).';;';
        }

        $quantity = (isset ($_REQUEST['contactFormField_Quantity'])
            ? intval($_REQUEST['contactFormField_Quantity'])
            : 0);
        $product_amount = self::GetProduktValue('product_price', $product_id);
        if (self::GetProduktValue('product_per_day', $product_id) == 'yes') {
            if ($quantity <= 0) {
                return 'alert("'.$_ARRAYLANG['TXT_EGOV_SPECIFY_COUNT'].'");history.go(-1);';
            }
            $FormValue = self::GetSettings('set_calendar_date_label').'::'.strip_tags(contrexx_addslashes($_REQUEST['contactFormField_1000'])).';;'.$FormValue;
            $FormValue = $_ARRAYLANG['TXT_EGOV_QUANTITY'].'::'.$quantity.';;'.$FormValue;
        }

        $objDatabase->Execute("
            INSERT INTO ".DBPREFIX."module_egov_orders (
                order_date, order_ip, order_product, order_values
            ) VALUES (
                '$datum_db', '$ip_adress', '$product_id', '$FormValue'
            )");
        $order_id = $objDatabase->Insert_ID();
        if (self::GetProduktValue('product_per_day', $product_id) == 'yes') {
            list ($calD, $calM, $calY) = explode('[.]', $_REQUEST['contactFormField_1000']);
            for($x = 0; $x < $quantity; ++$x) {
                $objDatabase->Execute("
                    INSERT INTO ".DBPREFIX."module_egov_product_calendar (
                        calendar_product, calendar_order, calendar_day,
                        calendar_month, calendar_year
                    ) VALUES (
                        '$product_id', '$order_id', '$calD',
                        '$calM', '$calY'
                    )
                ");
            }
        }

        $ReturnValue = '';
        $newStatus = 1;
        // Handle any kind of payment request
        if (!empty($_REQUEST['handler'])) {
            $ReturnValue = $this->payment($order_id, $product_amount);
            if (intval($ReturnValue) > 0) {
                $newStatus = $ReturnValue;
                $ReturnValue = '';
            }
            if (!empty($ReturnValue)) return $ReturnValue;
        }

        // If no more payment handling is required,
        // update the order right away
        if (self::GetOrderValue('order_state', $order_id) == 0) {
            // If any non-empty string is returned, an error occurred.
            $ReturnValue = self::updateOrder($order_id, $newStatus);
            if (!empty($ReturnValue)) return $ReturnValue;
        }

        return self::getSuccessMessage($product_id);
    }


    /**
     * Update the order status and send the confirmation mail
     * according to the settings
     *
     * The resulting javascript code displays a message box or
     * does some page redirect.
     * @param   integer   $order_id       The order ID
     * @return  string                    Javascript code
     * @static
     */
    static function updateOrder($order_id, $newStatus=1)
    {
        global $_ARRAYLANG, $_CONFIG;

        $product_id = self::getOrderValue('order_product', $order_id);
        if (empty($product_id)) {
            return 'alert("'.$_ARRAYLANG['TXT_EGOV_ERROR_UPDATING_ORDER'].'");'."\n";
        }

        // Has this order been updated already?
        $orderStatus = self::GetOrderValue('order_state', $order_id);
        if ($orderStatus != 0) {
            // Do not resend mails!
            return '';
        }

        $arrFields = self::getOrderValues($order_id);
        $FormValue4Mail = '';
        $arrMatch = array();
        foreach ($arrFields as $name => $value) {
            // If the value matches a calendar date, prefix the string with
            // the day of the week
            if (preg_match('/^(\d\d?)\.(\d\d?)\.(\d\d\d\d)$/', $value, $arrMatch)) {
                // ISO-8601 numeric representation of the day of the week
                // 1 (for Monday) through 7 (for Sunday)
                $dotwNumber =
                    date('N', mktime(1,1,1,$arrMatch[2],$arrMatch[1],$arrMatch[3]));
                $dotwName = $_ARRAYLANG['TXT_EGOV_DAYNAME_'.$dotwNumber];
                $value = "$dotwName, $value";
            }
            $FormValue4Mail .= html_entity_decode($name).': '.html_entity_decode($value)."\n";
        }
        // Bestelleingang-Benachrichtigung || Mail f�r den Administrator
        $recipient = self::GetProduktValue('product_target_email', $product_id);
        if (empty($recipient)) {
            $recipient = self::GetSettings('set_orderentry_recipient');
        }
        if (!empty($recipient)) {
            $SubjectText = str_replace('[[PRODUCT_NAME]]', html_entity_decode(self::GetProduktValue('product_name', $product_id)), self::GetSettings('set_orderentry_subject'));
            $SubjectText = html_entity_decode($SubjectText);
            $BodyText = str_replace('[[ORDER_VALUE]]', $FormValue4Mail, self::GetSettings('set_orderentry_email'));
            $BodyText = html_entity_decode($BodyText);
            $replyAddress = self::GetEmailAdress($order_id);
            if (empty($replyAddress)) {
                $replyAddress = self::GetSettings('set_orderentry_sender');
            }
            if (@include_once ASCMS_LIBRARY_PATH.'/phpmailer/class.phpmailer.php') {
                $objMail = new phpmailer();
                if (!empty($_CONFIG['coreSmtpServer'])) {
                    if (($arrSmtp = SmtpSettings::getSmtpAccount($_CONFIG['coreSmtpServer'])) !== false) {
                        $objMail->IsSMTP();
                        $objMail->Host = $arrSmtp['hostname'];
                        $objMail->Port = $arrSmtp['port'];
                        $objMail->SMTPAuth = true;
                        $objMail->Username = $arrSmtp['username'];
                        $objMail->Password = $arrSmtp['password'];
                    }
                }
                $objMail->CharSet = CONTREXX_CHARSET;
                $objMail->From = self::GetSettings('set_orderentry_sender');
                $objMail->FromName = self::GetSettings('set_orderentry_name');
                $objMail->AddReplyTo($replyAddress);
                $objMail->Subject = $SubjectText;
                $objMail->Priority = 3;
                $objMail->IsHTML(false);
                $objMail->Body = $BodyText;
                $objMail->AddAddress($recipient);
                $objMail->Send();
            }
        }

        // Update 29.10.2006 Statusmail automatisch abschicken || Produktdatei
        if (   self::GetProduktValue('product_electro', $product_id) == 1
            || self::GetProduktValue('product_autostatus', $product_id) == 1
        ) {
            self::updateOrderStatus($order_id, $newStatus);
            $TargetMail = self::GetEmailAdress($order_id);
            if ($TargetMail != '') {
                $FromEmail = self::GetProduktValue('product_sender_email', $product_id);
                if ($FromEmail == '') {
                    $FromEmail = self::GetSettings('set_sender_email');
                }
                $FromName = self::GetProduktValue('product_sender_name', $product_id);
                if ($FromName == '') {
                    $FromName = self::GetSettings('set_sender_name');
                }
                $SubjectDB = self::GetProduktValue('product_target_subject', $product_id);
                if ($SubjectDB == '') {
                    $SubjectDB = self::GetSettings('set_state_subject');
                }
                $SubjectText = str_replace('[[PRODUCT_NAME]]', html_entity_decode(self::GetProduktValue('product_name', $product_id)), $SubjectDB);
                $SubjectText = html_entity_decode($SubjectText);
                $BodyDB = self::GetProduktValue('product_target_body', $product_id);
                if ($BodyDB == '') {
                    $BodyDB = self::GetSettings('set_state_email');
                }
                $BodyText = str_replace('[[ORDER_VALUE]]', $FormValue4Mail, $BodyDB);
                $BodyText = str_replace('[[PRODUCT_NAME]]', html_entity_decode(self::GetProduktValue('product_name', $product_id)), $BodyText);
                $BodyText = html_entity_decode($BodyText);
                if (@include_once ASCMS_LIBRARY_PATH.'/phpmailer/class.phpmailer.php') {
                    $objMail = new phpmailer();
                    if ($_CONFIG['coreSmtpServer'] > 0) {
                        if (($arrSmtp = SmtpSettings::getSmtpAccount($_CONFIG['coreSmtpServer'])) !== false) {
                            $objMail->IsSMTP();
                            $objMail->Host = $arrSmtp['hostname'];
                            $objMail->Port = $arrSmtp['port'];
                            $objMail->SMTPAuth = true;
                            $objMail->Username = $arrSmtp['username'];
                            $objMail->Password = $arrSmtp['password'];
                        }
                    }
                    $objMail->CharSet = CONTREXX_CHARSET;
                    $objMail->From = $FromEmail;
                    $objMail->FromName = $FromName;
                    $objMail->AddReplyTo($FromEmail);
                    $objMail->Subject = $SubjectText;
                    $objMail->Priority = 3;
                    $objMail->IsHTML(false);
                    $objMail->Body = $BodyText;
                    $objMail->AddAddress($TargetMail);
                    if (self::GetProduktValue('product_electro', $product_id) == 1) {
                        $objMail->AddAttachment(ASCMS_PATH.self::GetProduktValue('product_file', $product_id));
                    }
                    $objMail->Send();
                }
            }
        }
        return '';
    }


    function payment($order_id=0, $amount=0)
    {
        $handler = $_REQUEST['handler'];
        switch ($handler) {
          case 'paypal':
            $order_id =
                (!empty($_POST['custom']) ? $_POST['custom'] : $order_id);
            return $this->paymentPaypal($order_id, $amount);
          // Payment requests
          // The following are all handled by Yellowpay.
          case 'PostFinance': // Generic
          case 'PostFinanceCard':
          case 'yellownet':
          case 'Master':
          case 'Visa':
          case 'Amex':
          case 'Diners':
          case 'yellowbill':
            return $this->paymentYellowpay($order_id, $amount);
          // Returning from Yellowpay
          case 'yellowpay':
            return $this->paymentYellowpayVerify();
          // Silently ignore invalid payment requests
        }
        // Unknown payment handler provided.
        // Should be one of the alternative payment methods,
        // use the alternative status as return value.
        return 3;
        //return $_ARRAYLANG['TXT_EGOV_PAYMENT_NOT_COMPLETED'];
    }


    function paymentPaypal($order_id, $amount=0)
    {
        global $_ARRAYLANG;

        if (isset($_GET['result'])) {
            $result = $_GET['result'];
            switch ($result) {
              case -1:
                // Go validate PayPal IPN
                $this->paymentPaypalIpn($order_id, $amount);
                die();
              case 0:
                // Payment failed
                break;
              case 1:
                // The payment has been completed.
                // The notification with result == -1 will update the order.
                // This case only redirects the customer to the list page with
                // an appropriate message according to the status of the order.
                $order_state = self::GetOrderValue('order_state', $order_id);
                if ($order_state == 1) {
                    $product_id = self::GetOrderValue('order_product', $order_id);
                    return self::getSuccessMessage($product_id);
                } elseif ($order_state == 0) {
                    if (self::GetSettings('set_paypal_ipn') == 1) {
                        return 'alert("'.$_ARRAYLANG['TXT_EGOV_PAYPAL_IPN_PENDING']."\");\n";
                    }
                }
                break;
              case 2:
                // Payment was cancelled
                return 'alert("'.$_ARRAYLANG['TXT_EGOV_PAYPAL_CANCEL']."\");\n";
            }
            return 'alert("'.$_ARRAYLANG['TXT_EGOV_PAYPAL_NOT_VALID']."\");\n";
        }

        $product_id = self::getOrderValue('order_product', $order_id);
        if (empty($product_id)) {
            return 'alert("'.$_ARRAYLANG['TXT_EGOV_ERROR_UPDATING_ORDER'].'");'."\n";
        }

        // Prepare payment
        $paypalUriIpn = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?section=egov&handler=paypal&result=-1";
        $paypalUriNok = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?section=egov&handler=paypal&result=0";
        $paypalUriOk  = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?section=egov&handler=paypal&result=1";
        $objPaypal = new paypal_class();

        $product_id = self::GetOrderValue('order_product', $order_id);
        if (empty($product_id)) {
            return 'alert("'.$_ARRAYLANG['TXT_EGOV_ERROR_PROCESSING_ORDER']."\");\n";
        }
        $product_name = self::GetProduktValue('product_name', $product_id);
        $product_amount = self::GetProduktValue('product_price', $product_id);
        $quantity =
            (self::GetProduktValue('product_per_day', $product_id) == 'yes'
                ? $_REQUEST['contactFormField_Quantity'] : 1
            );
        if ($product_amount <= 0) {
            return '';
        }
        $objPaypal->add_field('business', self::GetProduktValue('product_paypal_sandbox', $product_id));
        $objPaypal->add_field('return', $paypalUriOk);
        $objPaypal->add_field('cancel_return', $paypalUriNok);
        $objPaypal->add_field('notify_url', $paypalUriIpn);
        $objPaypal->add_field('item_name', $product_name);
        $objPaypal->add_field('amount', $product_amount);
        $objPaypal->add_field('quantity', $quantity);
        $objPaypal->add_field('currency_code', self::GetProduktValue('product_paypal_currency', $product_id));
        $objPaypal->add_field('custom', $order_id);
//die();
        $objPaypal->submit_paypal_post();
        die();
    }


    function paymentPaypalIpn($order_id)
    {
        $product_id = self::GetOrderValue('order_product', $order_id);
        if (empty($product_id)) {
            die(); //return 'alert("'.$_ARRAYLANG['TXT_EGOV_ERROR_PROCESSING_ORDER']."\");\n";
        }
        $objPaypal = new paypal_class();
        if (!self::GetProduktValue('product_paypal', $product_id)) {
            // How did we get here?  PayPal isn't even enabled for this product.
            die(); //return 'alert("'.$_ARRAYLANG['TXT_EGOV_PAYPAL_NOT_VALID']."\");\n";
        }
        if (self::GetSettings('set_paypal_ipn') == 0) {
            // PayPal IPN is disabled.
            die(); //return '';
        }
        if (!$objPaypal->validate_ipn()) {
            // Verification failed.
            die(); //return 'alert("'.$_ARRAYLANG['TXT_EGOV_PAYPAL_NOT_VALID']."\");\n";
        }
/*
        // PayPal IPN Confirmation by email
        $subject = 'Instant Payment Notification - Recieved Payment';
        $to = self::GetProduktValue('product_paypal_sandbox', $product_id);
        $body = "An instant payment notification was successfully recieved\n";
        $body .= "from ".$objPaypal->ipn_data['payer_email']." on ".date('m/d/Y');
        $body .= " at ".date('g:i A')."\n\nDetails:\n";
        foreach ($objPaypal->ipn_data as $key => $value) { $body .= "\n$key: $value"; }
        mail($to, $subject, $body);
*/
        // Update the order silently.
        $this->updateOrder($order_id);
    }


    function paymentYellowpay($order_id, $amount)
    {
        global $_ARRAYLANG, $_LANGID;

        // Prepare payment using current settings and customer selection
        $product_id = self::GetOrderValue('order_product', $order_id);
        if (empty($product_id)) {
            return 'alert("'.$_ARRAYLANG['TXT_EGOV_ERROR_PROCESSING_ORDER']."\");\n";
        }
        $quantity =
            (self::GetProduktValue('product_per_day', $product_id) == 'yes'
                ? $_REQUEST['contactFormField_Quantity'] : 1
            );
        $product_amount = (!empty($amount)
            ? $amount
            :   self::GetProduktValue('product_price', $product_id)
              * $quantity
        );
        $FormFields = "id=$product_id&send=1&";
        $arrFields = $this->getFormFields($product_id);
        foreach (array_keys($arrFields) as $fieldId) {
            $FormFields .= 'contactFormField_'.$fieldId.'='.strip_tags(contrexx_addslashes($_REQUEST['contactFormField_'.$fieldId])).'&';
        }
        if (self::GetProduktValue('product_per_day', $product_id) == 'yes') {
            $FormFields .= 'contactFormField_1000='.$_REQUEST['contactFormField_1000'].'&';
            $FormFields .= 'contactFormField_Quantity='.$_REQUEST['contactFormField_Quantity'];
        }

        SettingDb::init('egov', 'config');

        $arrOrder = array(
            'ORDERID'   => $order_id,
            'AMOUNT'    => $product_amount,
            'CURRENCY'  => self::GetProduktValue('product_paypal_currency', $product_id),
            'PARAMPLUS' => 'section=egov&order_id='.$order_id.'&handler=yellowpay',
            'COM'       => self::GetProduktValue('product_name', $product_id),
        );

        $_POST = contrexx_input2raw($_POST);
        // Note that none of these fields is present in the post in the current
        // implementation!  The meaning cannot be guessed from the actual field
        // names (i.e. "contactFormField_17").
        $arrOrder['CN'] = '';
        if (!empty($_POST['Vorname'])) {
            $arrOrder['CN'] = $_POST['Vorname'];
        }
        if (!empty($_POST['Nachname'])) {
            $arrOrder['CN'] .= ($arrOrder['CN'] ? ' ' : '').$_POST['Nachname'];
        }
        if (!empty($_POST['Adresse'])) {
            $arrOrder['OWNERADDRESS'] = $_POST['Adresse'];
        }
        if (!empty($_POST['PLZ'])) {
            $arrOrder['OWNERZIP'] = $_POST['PLZ'];
        }
        if (!empty($_POST['Ort'])) {
            $arrOrder['OWNERTOWN'] = $_POST['Ort'];
        }
        if (!empty($_POST['Land'])) {
            $arrOrder['OWNERCTY'] = $_POST['Land'];
        }
        if (!empty($_POST['Telefon'])) {
            $arrOrder['OWNERTELNO'] = $_POST['Telefon'];
        }
        if (!empty($_POST['EMail'])) {
            $arrOrder['EMAIL'] = $_POST['EMail'];
        }

        $landingPage = \Env::get('em')->getRepository('Cx\Core\ContentManager\Model\Entity\Page')->findOneByModuleCmdLang('egov', '', FRONTEND_LANG_ID);

        $yellowpayForm = Yellowpay::getForm($arrOrder, 'Send', false, null, $landingPage);

        if (count(Yellowpay::$arrError)) {
            DBG::log(
                "Yellowpay could not be initialized:\n".
                join("\n", Yellowpay::$arrError));
            die();
        }
        die("<!DOCTYPE html>
<html>
  <head>
    <title>Yellowpay</title>
  </head>
  <body>
$yellowpayForm
  </body>
</html>
");
        // Test/debug: die(htmlentities($yellowpayForm));
    }


    function paymentYellowpayVerify()
    {
        global $_ARRAYLANG;

        $result = isset($_REQUEST['result']) ? $_REQUEST['result'] : 0;
        $order_id = Yellowpay::getOrderId();
        if ($result < 0) {
            SettingDb::init('egov', 'config');
            if (Yellowpay::checkIn(SettingDb::getValue('postfinance_hash_signature_out'))) {
                // Silently process yellowpay notifications and die().
                if (abs($_REQUEST['result']) == 1) {
                    $this->updateOrder($order_id);
                }
            }
            die();
        }

        $strReturn = '';
        if ($order_id) {
            $order_id = intval($_REQUEST['order_id']);
            $product_id = self::GetOrderValue('order_product', $order_id);
            if (empty($product_id)) {
                $strReturn = 'alert("'.$_ARRAYLANG['TXT_EGOV_ERROR_PROCESSING_ORDER']."\");\n";
            }
            $status = self::GetOrderValue('order_state', $order_id);
            switch ($status) {
              case 1:
                // The payment has been completed.
                // The direct payment notification (with result == -1) has
                // successfully caused the order to be updated.
                // Show an appropriate message, and optionally redirect
                // the customer.
                $product_id = self::GetOrderValue('order_product', $order_id);
                return self::getSuccessMessage($product_id);
                break;
              // Not applicable:
              // Mind that the payment result (cancelled or failed) is not
              // available outside of the direct payment request from
              // PostFinance!  Thus, this outcome is never encountered.
              case 0:
              case 2:
              default:
                // Payment failed, or has been cancelled
                $strReturn = 'alert("'.$_ARRAYLANG['TXT_EGOV_YELLOWPAY_CANCEL']."\");\n";
            }
        }
        return $strReturn.'document.location.href="'.$_SERVER['PHP_SELF']."?section=egov\";\n";
    }


    function _ProductsList()
    {
        global $objDatabase;

        $result = '';
        if (isset($_REQUEST['result'])) {
            // Returned from payment
            $result = $this->payment();
        } elseif (isset($_REQUEST['send'])) {
            // Store order and launch payment, if necessary
            $result = $this->_saveOrder();
        }
        // Fix/replace HTML and line breaks, which will all fail in the
        // alert() call.
        $result =
            html_entity_decode(
                strip_tags(
                    preg_replace(
                        '/\<br\s*?\/?\>/', '\n',
                        preg_replace('/[\n\r]/', '', $result)
                    )
                ), ENT_QUOTES, CONTREXX_CHARSET
            );
        $this->objTemplate->setVariable(
            'EGOV_JS',
            "<script type=\"text/javascript\">\n".
            "// <![CDATA[\n$result\n// ]]>\n".
            "</script>\n"
        );

        // Show products list
        $query = "
            SELECT product_id, product_name, product_desc
              FROM ".DBPREFIX."module_egov_products
             WHERE product_status=1
             ORDER BY product_orderby, product_name
        ";
        $objResult = $objDatabase->Execute($query );
        if (!$objResult || $objResult->EOF) {
            $this->objTemplate->hideBlock('egovProducts');
            return;
        }
        while (!$objResult->EOF) {
            $this->objTemplate->setVariable(array(
                'EGOV_PRODUCT_TITLE' => $objResult->fields['product_name'],
                'EGOV_PRODUCT_ID' => $objResult->fields['product_id'],
                'EGOV_PRODUCT_DESC' => $objResult->fields['product_desc'],
                'EGOV_PRODUCT_LINK' => 'index.php?section=egov&amp;cmd=detail&amp;id='.$objResult->fields['product_id'],
            ));
            $this->objTemplate->parse('egovProducts');
            $objResult->MoveNext();
        }
    }


    function _ProductDetail()
    {
        global $objDatabase;

        if (empty($_REQUEST['id'])) {
            return;
        }
        $query = "
            SELECT product_id, product_name, product_desc, product_price ".
             "FROM ".DBPREFIX."module_egov_products
             WHERE product_id=".$_REQUEST['id'];
        $objResult = $objDatabase->Execute($query);
        if ($objResult && $objResult->RecordCount()) {
            $product_id = $objResult->fields['product_id'];
            $FormSource = $this->getSourceCode($product_id);
            $this->objTemplate->setVariable(array(
                'EGOV_PRODUCT_TITLE' => $objResult->fields['product_name'],
                'EGOV_PRODUCT_ID' => $objResult->fields['product_id'],
                'EGOV_PRODUCT_DESC' => $objResult->fields['product_desc'],
                'EGOV_PRODUCT_PRICE' => $objResult->fields['product_price'],
                'EGOV_FORM' => $FormSource,
            ));
        }
        if ($this->objTemplate->blockExists('egov_price')) {
            if (intval($objResult->fields['product_price']) > 0) {
                $this->objTemplate->touchBlock('egov_price');
            } else {
                $this->objTemplate->hideBlock('egov_price');
            }
        }
    }


    /**
     * Returns a string containing Javascript for displaying the appropriate
     * success message and/or redirects for the product ID given.
     * @param   integer   $product_id     The product ID
     * @return  string                    The Javascript string
     * @static
     */
    static function getSuccessMessage($product_id)
    {
        // Seems that we need to clear the $_POST array to prevent it from
        // being reposted on the target page.
        unset($_POST);
        unset($_REQUEST);
        //unset($_GET);

        $ReturnValue = '';
        if (self::GetProduktValue('product_message', $product_id) != '') {
            $AlertMessageTxt = preg_replace(array('/(\n|\r\n)/', '/<br\s?\/?>/i'), '\n', addslashes(html_entity_decode(self::GetProduktValue('product_message', $product_id), ENT_QUOTES, CONTREXX_CHARSET)));
            $ReturnValue = 'alert("'.$AlertMessageTxt.'");'."\n";
        }
        if (self::GetProduktValue('product_target_url', $product_id) != '') {
            $ReturnValue .=
                'document.location.href="'.
                self::GetProduktValue('product_target_url', $product_id).
                '";'."\n";
            return $ReturnValue;
        }
        // Old: $ReturnValue .= "history.go(-2);\n";
        return
            $ReturnValue.
            'document.location.href="'.$_SERVER['PHP_SELF']."?section=egov\";\n";
    }

}
