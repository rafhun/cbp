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
 * Dummy class for simulating an external payment provider.
 *
 * Creates a dummy form for testing the payment process in the shop.
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author Reto Kohli <reto.kohli@comvation.com>
 * @package     contrexx
 * @subpackage  module_shop
 * @version     3.0.0
 * @todo        Edit PHP DocBlocks!
 */


/**
 * Lets you choose successful, failed, and aborted payments.
 *
 * This also demonstrates the requirements of the current specification
 * for any external payment service provider class.
 * See {@link PaymentProcessing.class} for details.
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Reto Kohli <reto.kohli@comvation.com>
 * @package     contrexx
 * @subpackage  module_shop
 * @version     3.0.0
 * @todo        Edit PHP DocBlocks!
 */

class Dummy
{
    /**
     * Returns the dummy payment form
     * @author Reto Kohli <reto.kohli@comvation.com>
     * @static
     * @return string  HTML code for the dummy payment form
     */
    //static
    function getForm()
    {
        $order_id    = isset($_SESSION['shop']['order_id']) ? $_SESSION['shop']['order_id'] : 0;
        $confirmURI = "index.php?section=shop".MODULE_INDEX."&amp;cmd=success&amp;handler=dummy&amp;order_id=$order_id&amp;result=-1";
        $failureURI = "index.php?section=shop".MODULE_INDEX."&amp;cmd=success&amp;handler=dummy&amp;order_id=$order_id&amp;result=0";
        $successURI = "index.php?section=shop".MODULE_INDEX."&amp;cmd=success&amp;handler=dummy&amp;order_id=$order_id&amp;result=1";
        $cancelURI  = "index.php?section=shop".MODULE_INDEX."&amp;cmd=success&amp;handler=dummy&amp;order_id=$order_id&amp;result=2";
        return <<<_
Please choose one:
<hr />
<a href='$confirmURI'>Confirm payment (silent)</a>
<br />
<a href='$successURI'>Successful payment (show success page)</a>
<br />
<a href='$failureURI'>Failed payment</a>
<br />
<a href='$cancelURI'>Cancelled payment</a>
<hr />

_;
    }


    /**
     * Commit the payment process result (dummy operation).
     *
     * After the user submitted the payment form, a result according to her
     * choices is created here.
     * The result of the payment process *SHOULD* be provided in the 'result'
     * request argument.  It *SHOULD* be one of the following:
     * 0 (zero): The payment was unsuccessful.
     * 1 (one): The payment was successful.
     * 2 (two): The payment has been cancelled.
     * Values other than these are considered to be equal to 0.
     * @author  Reto Kohli <reto.kohli@comvation.com>
     * @static
     * @return  boolean           True on success, false otherwise
     */
    static function commit()
    {
        $result = intval(isset($_GET['result']) ? $_GET['result'] : 0);
        return ($result == 1);
    }


    /**
     * Returns the Order ID
     *
     * The order ID *MUST* be provided in the 'order_id' or 'orderid'
     * request argument.
     * Otherwise, the payment is assumed to have failed.
     * @author  Reto Kohli <reto.kohli@comvation.com>
     * @static
     * @return  integer           The Order ID, or false
     */
    static function getOrderId()
    {
        return (isset($_GET['order_id'])
          ? intval($_GET['order_id'])
          : (isset($_GET['orderid'])
              ? intval($_GET['orderid'])
              : false));
    }

}
