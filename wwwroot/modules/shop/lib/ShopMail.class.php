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
 * OBSOLETE -- See {@see core/MailTemplate.class.php}
 *
 * Note that this partial class is left over for updating to the new
 * MailTemplate.  We use it to migrate the existing templates ONLY.
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_shop
 */

/**
 * OBSOLETE -- See {@see core/MailTemplate.class.php}
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_shop
 */
class ShopMail
{
    /**
     * The language ID used when init() was called
     * @var integer
     */
    private static $lang_id = false;

    /**
     * The array of mail templates
     * @var array
     */
    private static $arrTemplate = false;


    /**
     * Reset the class
     *
     * Forces an {@link init()} the next time content is accessed
     */
    static function reset()
    {
        self::$lang_id = false;
    }


    /**
     * Initialize the mail template array
     *
     * Uses the given language ID, if any, or the language set in the
     * LANG_ID global constant.
     * Upon success, stores the language ID used in the $lang_id class
     * variable.
     * @param   integer     $lang_id        The optional language ID
     * @return  boolean                     True on success, false otherwise
     */
    static function init($lang_id=0)
    {
        global $objDatabase;

        // The array has been initialized with that language already
        if (self::$lang_id == $lang_id) return true;
        // Reset the language ID used
        self::$lang_id = null;
        // Use the current language if none is specified
        if (empty($lang_id)) $lang_id = FRONTEND_LANG_ID;
        self::$arrTemplate = array();
        $objResult = $objDatabase->Execute("
            SELECT `mail`.`id`, `mail`.`tplname`, `mail`.`protected`
              FROM `".DBPREFIX."module_shop".MODULE_INDEX."_mail` AS `mail`");
        if (!$objResult) return false;
        while (!$objResult->EOF) {
            $id = $objResult->fields['id'];
            self::$arrTemplate[$id] = array(
                'id' => $id,
                'name' => $objResult->fields['tplname'],
                'protected' => $objResult->fields['protected'],
                // *MUST* be set!
                'available' => false,
            );
            $objResult->MoveNext();
        }
        $objResult = $objDatabase->Execute("
            SELECT `content`.`tpl_id`,
                   `content`.`from_mail`, `content`.`xsender`,
                   `content`.`subject`, `content`.`message`
              FROM `".DBPREFIX."module_shop".MODULE_INDEX."_mail_content` AS `content`
             WHERE `content`.`lang_id`=$lang_id");
        if (!$objResult) return false;
        while (!$objResult->EOF) {
            $id = $objResult->fields['tpl_id'];
            if (!self::$arrTemplate[$id]['available']) {
                self::$arrTemplate[$id]['available'] = true;
                self::$arrTemplate[$id]['from'] = $objResult->fields['from_mail'];
                self::$arrTemplate[$id]['sender'] = $objResult->fields['xsender'];
                self::$arrTemplate[$id]['subject'] = $objResult->fields['subject'];
                self::$arrTemplate[$id]['message'] = $objResult->fields['message'];
            }
            $objResult->MoveNext();
        }
        // Remember the language used
        self::$lang_id = $lang_id;
        return true;
    }


    static function getTemplateArray($lang_id=0)
    {
        if (empty($lang_id)) return false;
        self::init($lang_id);
        return self::$arrTemplate;
    }


    /**
     * Migrates existing old Shop mailtemplates to the new MailTemplate class
     * @return  boolean         False.  Always.
     * @throws  Cx\Lib\Update_DatabaseException
     */
    static function errorHandler()
    {
// Mail
        MailTemplate::errorHandler();

        if (Cx\Lib\UpdateUtil::table_empty(DBPREFIX.'core_mail_template')) {
            // Make sure there are no bodies lying around
            Text::deleteByKey('shop', MailTemplate::TEXT_NAME);
            Text::deleteByKey('shop', MailTemplate::TEXT_FROM);
            Text::deleteByKey('shop', MailTemplate::TEXT_SENDER);
            Text::deleteByKey('shop', MailTemplate::TEXT_REPLY);
            Text::deleteByKey('shop', MailTemplate::TEXT_TO);
            Text::deleteByKey('shop', MailTemplate::TEXT_CC);
            Text::deleteByKey('shop', MailTemplate::TEXT_BCC);
            Text::deleteByKey('shop', MailTemplate::TEXT_SUBJECT);
            Text::deleteByKey('shop', MailTemplate::TEXT_MESSAGE);
            Text::deleteByKey('shop', MailTemplate::TEXT_MESSAGE_HTML);
            Text::deleteByKey('shop', MailTemplate::TEXT_ATTACHMENTS);
            Text::deleteByKey('shop', MailTemplate::TEXT_INLINE);
        }
        $arrFrom = $arrSender = $arrSubject = array();
        $arrLanguageId = FWLanguage::getIdArray();
        if (empty($arrLanguageId)) {
            throw new Cx\Lib\Update_DatabaseException(
               "Failed to get frontend language IDs");
        }
        if (Cx\Lib\UpdateUtil::table_exist(DBPREFIX.'module_shop_mail')) {
            // Migrate existing templates from the shop to the MailTemplate,
            // appending "_backup_by_update" to the respective keys.
            // Make them unprotected.
            // These are the keys replacing the IDs:
            $arrKey =  array(
                // DE: Bestellungsbestätigung (includes account data, obsoletes #4)
                // EN:
                // FR: Confirmation de commande Contrexx
                // IT:
                1 => 'order_confirmation',
                // DE: Auftrag abgeschlossen
                // EN:
                // FR: Commande terminée
                // IT:
                2 => 'order_complete',
                // DE: Logindaten
                // EN:
                // FR: Identifiants de connexion
                // IT:
                3 => 'customer_login',
                // DE: Bestellungsbestätigung mit Zugangsdaten (obsolete!)
                // EN:
                // FR: Confirmation de commande et identifiants de connexion
                // IT:
                4 => 'order_confirmation_login',
            );
            foreach ($arrLanguageId as $lang_id) {
                // Mind that the template name is single language yet!
                $arrTemplates = self::getTemplateArray($lang_id);
                if (empty($arrTemplates)) continue;
                foreach ($arrTemplates as $id => $arrTemplate) {
// NOTE: utf8_encode() may be necessary in some cases.
// It usually works without it, but was necessary on a few installations.
//                    $arrTemplate = array_map("utf8_encode", $arrTemplate);
                    if (   !empty($arrTemplate['from'])
                        && empty($arrFrom[$id])) {
                        $arrFrom[$id] = $arrTemplate['from'];
                    }
                    if (   !empty($arrTemplate['sender'])
                        && empty($arrSender[$id])) {
                        $arrSender[$id] = $arrTemplate['sender'];
                    }
                    if (   !empty($arrTemplate['subject'])
                        && empty($arrSubject[$id])) {
                        $arrSubject[$id] = str_replace('<DATE>', '[ORDER_DATE]',
                            $arrTemplate['subject']);
                    }
                    if (isset($arrKey[$id])) {
                        // System templates get their default key
                        $arrTemplate['key'] = $arrKey[$id].'_backup_by_update';
                        // Clear the protected flag, so the old templates
                        // may be removed at will
                        $arrTemplate['protected'] = false;
                    } else {
                        // Custom templates:
                        // Make the name lowercase and replace any non-letter
                        $new_key = preg_replace(
                            '/[^a-z]/', '_', strtolower($arrTemplate['name']));
                        // Keep it unique!  Use the ID if the key is taken
                        if (in_array($new_key, $arrKey)) {
                            $new_key = $id;
                        }
                        // Remember used keys, and replace the former ID
                        $arrKey[$id] = $new_key;
                        $arrTemplate['key'] = $new_key;
                    }
                    // Some installations may contain corrupt templates
                    // causing empty (0 or "") keys.  Those would make
                    // MailTemplate::store() fail!
                    if (empty($arrTemplate['key'])) {
                        $arrTemplate['key'] = uniqid().'_backup_by_update)';
                    }
                    foreach ($arrTemplate as &$string) {
                        // Replace old <PLACEHOLDERS> with new [PLACEHOLDERS].
                        $string = preg_replace('/\\<([A-Z_]+)\\>/', '[$1]', $string);
// This is completely unreliable.
// Use the process as described above, not replacing the old templates,
// but adding the new ones instead.
//                    $string = str_replace('[ORDER_DATA]', $order_data, $string);
//                    $string = preg_replace('/[\\w\\s\\:]+\\[USERNAME\\](?:\\n|<br\\s?\\/?
//                          >)*[\\w\\s\\:]+\\[PASSWORD\\]/',
//                        $login_data, $string);
                    }
//                $arrTemplate['message_html'] = preg_replace(
//                    '/(?:\r|\n|\r\n)/', "<br />\n", $arrTemplate['message']);
                    $arrTemplate['lang_id'] = $lang_id;
                    if (!MailTemplate::store('shop', $arrTemplate)) {
                        throw new Cx\Lib\Update_DatabaseException(
                           "Failed to store Mailtemplate");
                    }
                }
            }
            // Drop old Mail tables after successful migration
            Cx\Lib\UpdateUtil::drop_table(DBPREFIX.'module_shop_mail_content');
            Cx\Lib\UpdateUtil::drop_table(DBPREFIX.'module_shop_mail');
        }
        // Add the new default templates with the new keys
        // and have the user migrate changes herself!
        foreach ($arrLanguageId as $lang_id) {
            if (!MailTemplate::get('shop', 'order_confirmation', $lang_id)) {
                MailTemplate::store('shop', array(
                    'lang_id' => $lang_id,
                    'key'          => 'order_confirmation',
                    'name'         => 'Bestellungsbestätigung',
                    'from'         => (isset ($arrFrom[1]) ? $arrFrom[1] : ''),
                    'sender'       => (isset ($arrSender[1]) ? $arrSender[1] : ''),
                    'to'           => '[CUSTOMER_EMAIL]',
                    'subject'      => (isset ($arrSubject[1]) ? $arrSubject[1] : ''),
                    'message'      => <<<EOF
[CUSTOMER_SALUTATION],

Herzlichen Dank für Ihre Bestellung im [SHOP_COMPANY] Online Shop.

Ihre Auftrags-Nr. lautet: [ORDER_ID]
Ihre Kunden-Nr. lautet: [CUSTOMER_ID]
Bestellungszeit: [ORDER_DATE] [ORDER_TIME]

------------------------------------------------------------------------
Bestellinformationen
------------------------------------------------------------------------[[ORDER_ITEM]
ID:             [PRODUCT_ID]
Artikel Nr.:    [PRODUCT_CODE]
Menge:          [PRODUCT_QUANTITY]
Beschreibung:   [PRODUCT_TITLE][[PRODUCT_OPTIONS]
            [PRODUCT_OPTIONS][PRODUCT_OPTIONS]]
Stückpreis:      [PRODUCT_ITEM_PRICE] [CURRENCY]                       Total [PRODUCT_TOTAL_PRICE] [CURRENCY][[USER_DATA]
Benutzername:   [USER_NAME]
Passwort:       [USER_PASS][USER_DATA]][[COUPON_DATA]
Gutschein Code: [COUPON_CODE][COUPON_DATA]][ORDER_ITEM]]
------------------------------------------------------------------------
Zwischensumme:    [ORDER_ITEM_COUNT] Artikel                             [ORDER_ITEM_SUM] [CURRENCY][[DISCOUNT_COUPON]
Gutschein Code: [DISCOUNT_COUPON_CODE]   [DISCOUNT_COUPON_AMOUNT] [CURRENCY][DISCOUNT_COUPON]]
------------------------------------------------------------------------[[SHIPMENT]
Versandart:     [SHIPMENT_NAME]   [SHIPMENT_PRICE] [CURRENCY][SHIPMENT]][[PAYMENT]
Bezahlung:      [PAYMENT_NAME]   [PAYMENT_PRICE] [CURRENCY][PAYMENT]][[VAT]
[VAT_TEXT]                   [VAT_PRICE] [CURRENCY][VAT]]
------------------------------------------------------------------------
Gesamtsumme                                                [ORDER_SUM] [CURRENCY]
------------------------------------------------------------------------

Bemerkungen:
[REMARKS]


Ihre Kundenadresse:
[CUSTOMER_COMPANY]
[CUSTOMER_FIRSTNAME] [CUSTOMER_LASTNAME]
[CUSTOMER_ADDRESS]
[CUSTOMER_ZIP] [CUSTOMER_CITY]
[CUSTOMER_COUNTRY][[SHIPPING_ADDRESS]


Lieferadresse:
[SHIPPING_COMPANY]
[SHIPPING_FIRSTNAME] [SHIPPING_LASTNAME]
[SHIPPING_ADDRESS]
[SHIPPING_ZIP] [SHIPPING_CITY]
[SHIPPING_COUNTRY][SHIPPING_ADDRESS]]

Ihr Link zum Online Store: [SHOP_HOMEPAGE][[CUSTOMER_LOGIN]

Ihre Zugangsdaten zum Shop:
Benutzername:   [CUSTOMER_USERNAME]
Passwort:       [CUSTOMER_PASSWORD][CUSTOMER_LOGIN]]

Wir freuen uns auf Ihren nächsten Besuch im [SHOP_COMPANY] Online Store und wünschen Ihnen noch einen schönen Tag.

P.S. Diese Auftragsbestätigung wurde gesendet an: [CUSTOMER_EMAIL]

Mit freundlichen Grüssen
Ihr [SHOP_COMPANY] Online Shop Team

[SHOP_HOMEPAGE]
EOF
                    ,
                    'message_html' => <<<EOF
[CUSTOMER_SALUTATION],<br />
<br />
Herzlichen Dank f&uuml;r Ihre Bestellung im [SHOP_COMPANY] Online Shop.<br />
<br />
Ihre Auftrags-Nr. lautet: [ORDER_ID]<br />
Ihre Kunden-Nr. lautet: [CUSTOMER_ID]<br />
Bestellungszeit: [ORDER_DATE] [ORDER_TIME]<br />
<br />
<br />
<table cellspacing="1" cellpadding="1" style="border: 0;">
<tbody>
<tr>
  <td colspan="6">Bestellinformationen</td>
</tr>
<tr>
  <td><div style="text-align: right;">ID</div></td>
  <td><div style="text-align: right;">Artikel Nr.</div></td>
  <td><div style="text-align: right;">Menge</div></td>
  <td>Beschreibung</td>
  <td><div style="text-align: right;">St&uuml;ckpreis</div></td>
  <td><div style="text-align: right;">Total</div></td>
</tr><!--[[ORDER_ITEM]-->
<tr>
  <td><div style="text-align: right;">[PRODUCT_ID]</div></td>
  <td><div style="text-align: right;">[PRODUCT_CODE]</div></td>
  <td><div style="text-align: right;">[PRODUCT_QUANTITY]</div></td>
  <td>[PRODUCT_TITLE]<!--[[PRODUCT_OPTIONS]--><br />
    [PRODUCT_OPTIONS]<!--[PRODUCT_OPTIONS]]--></td>
  <td><div style="text-align: right;">[PRODUCT_ITEM_PRICE] [CURRENCY]</div></td>
  <td><div style="text-align: right;">[PRODUCT_TOTAL_PRICE] [CURRENCY]</div></td>
</tr><!--[[USER_DATA]-->
<tr>
  <td colspan="3">&nbsp;</td>
  <td>Benutzername: [USER_NAME]<br />Passwort: [USER_PASS]</td>
  <td colspan="2">&nbsp;</td>
</tr><!--[USER_DATA]]--><!--[[COUPON_DATA]-->
<tr>
  <td colspan="3">&nbsp;</td>
  <td>Gutschein Code: [COUPON_CODE]</td>
  <td colspan="2">&nbsp;</td>
</tr><!--[COUPON_DATA]]--><!--[ORDER_ITEM]]-->
<tr style="border-top: 4px none;">
  <td colspan="2">Zwischensumme</td>
  <td><div style="text-align: right;">[ORDER_ITEM_COUNT]</div></td>
  <td colspan="2">Artikel</td>
  <td><div style="text-align: right;">[ORDER_ITEM_SUM] [CURRENCY]</div></td>
</tr><!--[[DISCOUNT_COUPON]-->
<tr style="border-top: 4px none;">
  <td colspan="3">Gutscheincode</td>
  <td colspan="2">[DISCOUNT_COUPON_CODE]</td>
  <td><div style="text-align: right;">[DISCOUNT_COUPON_AMOUNT] [CURRENCY]</div></td>
</tr><!--[DISCOUNT_COUPON]][[SHIPMENT]-->
<tr style="border-top: 2px none;">
  <td colspan="3">Versandart</td>
  <td colspan="2">[SHIPMENT_NAME]</td>
  <td><div style="text-align: right;">[SHIPMENT_PRICE] [CURRENCY]</div></td>
</tr><!--[SHIPMENT]][[PAYMENT]-->
<tr style="border-top: 2px none;">
  <td colspan="3">Bezahlung</td>
  <td colspan="2">[PAYMENT_NAME]</td>
  <td><div style="text-align: right;">[PAYMENT_PRICE] [CURRENCY]</div></td>
</tr><!--[PAYMENT]][[VAT]-->
<tr style="border-top: 2px none;">
  <td colspan="5">[VAT_TEXT]</td>
  <td><div style="text-align: right;">[VAT_PRICE] [CURRENCY]</div></td>
</tr><!--[VAT]]-->
<tr style="border-top: 4px none;">
  <td colspan="5">Gesamtsumme</td>
  <td><div style="text-align: right;">[ORDER_SUM] [CURRENCY]</div></td>
</tr>
</tbody>
</table>
<br />
Bemerkungen:<br />
[REMARKS]<br />
<br />
<br />
Ihre Kundenadresse:<br />
[CUSTOMER_COMPANY]<br />
[CUSTOMER_FIRSTNAME] [CUSTOMER_LASTNAME]<br />
[CUSTOMER_ADDRESS]<br />
[CUSTOMER_ZIP] [CUSTOMER_CITY]<br />
[CUSTOMER_COUNTRY]<br /><!--[[SHIPPING_ADDRESS]-->
<br />
<br />
Lieferadresse:<br />
[SHIPPING_COMPANY]<br />
[SHIPPING_FIRSTNAME] [SHIPPING_LASTNAME]<br />
[SHIPPING_ADDRESS]<br />
[SHIPPING_ZIP] [SHIPPING_CITY]<br />
[SHIPPING_COUNTRY]<br /><!--[SHIPPING_ADDRESS]]-->
<br />
<br />
Ihr Link zum Online Store: [SHOP_HOMEPAGE]<br /><!--[[CUSTOMER_LOGIN]-->
<br />
Ihre Zugangsdaten zum Shop:<br />
Benutzername:   [CUSTOMER_USERNAME]<br />
Passwort:       [CUSTOMER_PASSWORD]<br /><!--[CUSTOMER_LOGIN]]-->
<br />
Wir freuen uns auf Ihren n&auml;chsten Besuch im [SHOP_COMPANY] Online Store und w&uuml;nschen Ihnen noch einen sch&ouml;nen Tag.<br />
<br />
P.S. Diese Auftragsbest&auml;tigung wurde gesendet an: [CUSTOMER_EMAIL]<br />
<br />
Mit freundlichen Gr&uuml;ssen<br />
Ihr [SHOP_COMPANY] Online Shop Team<br />
<br />
[SHOP_HOMEPAGE]<br />
<br />
EOF
                    ,
                    'protected'    => true,
                    'html'         => true,
                ));
            }
            if (!MailTemplate::get('shop', 'order_complete', $lang_id)) {
                MailTemplate::store('shop', array(
                    'lang_id' => $lang_id,
                    'key'          => 'order_complete',
                    'name'         => 'Auftrag abgeschlossen',
                    'from'         => (isset ($arrFrom[2]) ? $arrFrom[2] : ''),
                    'sender'       => (isset ($arrSender[2]) ? $arrSender[2] : ''),
                    'to'           => '[CUSTOMER_EMAIL]',
                    'subject'      => (isset ($arrSubject[2]) ? $arrSubject[2] : ''),
                    'message'      => <<<EOF
[CUSTOMER_SALUTATION]

Ihre Bestellung wurde ausgeführt. Sie werden in den nächsten Tagen ihre Lieferung erhalten.

Herzlichen Dank für das Vertrauen.
Wir würden uns freuen, wenn Sie uns weiterempfehlen und wünschen Ihnen noch einen schönen Tag.

Mit freundlichen Grüssen
Ihr [SHOP_COMPANY] Online Shop Team

[SHOP_HOMEPAGE]
EOF
                    ,
                    'message_html' => <<<EOF
[CUSTOMER_SALUTATION]<br />
<br />
Ihre Bestellung wurde ausgeführt. Sie werden in den nächsten Tagen ihre Lieferung erhalten.<br />
<br />
Herzlichen Dank für das Vertrauen.<br />
Wir würden uns freuen, wenn Sie uns weiterempfehlen und wünschen Ihnen noch einen schönen Tag.<br />
<br />
Mit freundlichen Grüssen<br />
Ihr [SHOP_COMPANY] Online Shop Team<br />
<br />
[SHOP_HOMEPAGE]<br />
EOF
                    ,
                    'protected'    => true,
                    'html'         => true,
                ));
            }
            if (!MailTemplate::get('shop', 'customer_login', $lang_id)) {
                MailTemplate::store('shop', array(
                    'lang_id' => $lang_id,
                    'key'          => 'customer_login',
                    'name'         => 'Logindaten',
                    'from'         => (isset ($arrFrom[3]) ? $arrFrom[3] : ''),
                    'sender'       => (isset ($arrSender[3]) ? $arrSender[3] : ''),
                    'to'           => '[CUSTOMER_EMAIL]',
                    'subject'      => (isset ($arrSubject[3]) ? $arrSubject[3] : ''),
                    'message'      => <<<EOF
[CUSTOMER_SALUTATION]

Hier Ihre Zugangsdaten zum Shop:[[CUSTOMER_LOGIN]
Benutzername: [CUSTOMER_USERNAME]
Passwort: [CUSTOMER_PASSWORD][CUSTOMER_LOGIN]]

Mit freundlichen Grüssen
Ihr [SHOP_COMPANY] Online Shop Team

[SHOP_HOMEPAGE]
EOF
                    ,
                    'message_html' => <<<EOF
[CUSTOMER_SALUTATION]<br />
<br />
Hier Ihre Zugangsdaten zum Shop:<br /><!--[[CUSTOMER_LOGIN]-->
Benutzername: [CUSTOMER_USERNAME]<br />
Passwort: [CUSTOMER_PASSWORD]<br /><!--[CUSTOMER_LOGIN]]-->
<br />
Mit freundlichen Gr&uuml;ssen<br />
Ihr [SHOP_COMPANY] Online Shop Team<br />
<br />
[SHOP_HOMEPAGE]<br />
EOF
                    ,
                    'protected'    => true,
                    'html'         => true,
                ));
            }
        }
        // Always!
        return false;
    }

}
