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
 * Calendar 
 * 
 * @package    contrexx
 * @subpackage module_calendar
 * @author     Comvation <info@comvation.com>
 * @copyright  CONTREXX CMS - COMVATION AG
 * @version    1.00
 */


/**
 * Calendar Class Payment
 * 
 * @package    contrexx
 * @subpackage module_calendar
 * @author     Comvation <info@comvation.com>
 * @copyright  CONTREXX CMS - COMVATION AG
 * @version    1.00
 */
class CalendarPayment {
    /**
     * Returns the HTML code for the Yellowpay payment method.
     * 
     * @param array $data post data from the user
     * 
     * @return  string  HTML code
     */
    function _yellowpay($data = array())
    {
        global $_ARRAYLANG;
        $objSettings         = new CalendarSettings();
        $arrCalendarSettings = $objSettings->getYellowpaySettings();

        $arrOrder = array(
            'ORDERID'   => $data['orderID'],            
            'AMOUNT'    => $data['amount'],
            'CURRENCY'  => $data['currency'],
            'PARAMPLUS' => "section=calendar&cmd=success&handler=yellowpay",
        );
        $arrSettings = array();
        $arrSettings['postfinance_shop_id']['value']            = $arrCalendarSettings['paymentYellowpayPspid'];
        $arrSettings['postfinance_hash_signature_in']['value']  = $arrCalendarSettings['paymentYellowpayShaIn'];
        $arrSettings['postfinance_authorization_type']['value'] = $arrCalendarSettings['paymentYellowpayAuthorization'] == 0 ? 'SAL' : 'RES';
        $arrSettings['postfinance_use_testserver']['value']     = $arrCalendarSettings['paymentTestserver'];

        $landingPage = \Env::get('em')->getRepository('Cx\Core\ContentManager\Model\Entity\Page')->findOneByModuleCmdLang('calendar', 'success', FRONTEND_LANG_ID);

        $yellowpayForm = Yellowpay::getForm($arrOrder, $_ARRAYLANG['TXT_CALENDAR_START_PAYMENT'], false, $arrSettings, $landingPage);

        if (_PAYMENT_DEBUG && Yellowpay::$arrError) {
            $strError =
                '<font color="red"><b>'.
                $_ARRAYLANG['TXT_SHOP_PSP_FAILED_TO_INITIALISE_YELLOWPAY'].
                '<br /></b>';
            if (_PAYMENT_DEBUG) {
                $strError .= join('<br />', Yellowpay::$arrError); //.'<br />';
            }

            return $strError.'</font>';
        }
        return $yellowpayForm;
    }
}
