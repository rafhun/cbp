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
 * CheckoutManager
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_checkout
 */

/**
 * CheckoutManager
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_checkout
 */
class CheckoutManager extends CheckoutLibrary {

    /**
     * Transaction object.
     *
     * @access      private
     * @var         Transaction
     */
    private $objTransaction;

    /**
     * SettingsMails object.
     *
     * @access      private
     * @var         Setting
     */
    private $objSettingsGeneral;

    /**
     * SettingsYellowpay object.
     *
     * @access      private
     * @var         Setting
     */
    private $objSettingsYellowpay;

    /**
     * SettingsMails object.
     *
     * @access      private
     * @var         Setting
     */
    private $objSettingsMails;

    /**
     * Template object.
     *
     * @access      private
     * @var         HTML_TEMPLATE_SIGMA
     */
    private $objTemplate;

    /**
     * All negative and positive status messages.
     *
     * @access      private
     * @var         array
     */
    private $arrStatusMessages = array('ok' => array(), 'alert' => array());

    /**
     * Constructor
     * Initialize the template and transaction object.
     *
     * @access      public
     */
    public function __construct()
    {
        global $objDatabase, $objTemplate, $_ARRAYLANG;

        parent::__construct();

        $this->arrStatusMessages['warning'][] = $_ARRAYLANG['TXT_CHECKOUT_SETTINGS_PSP_YELLOWPAY_ONLY_FOR_SWITZERLAND'];

        $_GET['act'] = !empty($_GET['act']) ? $_GET['act'] : '';
        $_GET['tpl'] = !empty($_GET['tpl']) ? $_GET['tpl'] : '';

        $this->objTransaction = new Transaction($objDatabase);
        $this->objSettingsGeneral = new SettingsGeneral($objDatabase);
        $this->objSettingsYellowpay = new SettingsYellowpay($objDatabase);
        $this->objSettingsMails = new SettingsMails($objDatabase);

        $objTemplate->setVariable('CONTENT_NAVIGATION', '<a href="index.php?cmd=checkout&amp;act=overview"'.(($_GET['act'] == 'overview' || $_GET['act'] == '') ? ' class="active"' : '').'>'.$_ARRAYLANG['TXT_CHECKOUT_OVERVIEW'].'</a>
                                                         <a href="index.php?cmd=checkout&amp;act=settings"'.($_GET['act'] == 'settings' ? ' class="active"' : '').'>'.$_ARRAYLANG['TXT_CHECKOUT_SETTINGS'].'</a>');
        $this->objTemplate = new \Cx\Core\Html\Sigma(ASCMS_MODULE_PATH.'/checkout/template');
        $this->objTemplate->setErrorHandling(PEAR_ERROR_DIE);
    }

    /**
     * Get page depending on the act parameter.
     *
     * @access      public
     * @return      string  content page
     */
    public function getPage()
    {
        global $objTemplate, $_CORELANG, $_ARRAYLANG;

        if (!isset($_REQUEST['act'])) {
            $_REQUEST['act'] = '';
        }

        switch ($_REQUEST['act']) {
            case 'overview':
                $objTemplate->setVariable('CONTENT_TITLE', $_ARRAYLANG['TXT_CHECKOUT_OVERVIEW']);
                $this->showOverview();
                break;
            case 'detail':
                $objTemplate->setVariable('CONTENT_TITLE', $_ARRAYLANG['TXT_CHECKOUT_DETAIL']);
                $this->showDetail();
                break;
            case 'delete':
                $this->deleteEntry();
                $this->showOverview();
                break;
            case 'settings':
                $objTemplate->setVariable('CONTENT_TITLE', $_CORELANG['TXT_SETTINGS']);
                $this->showSettings();
                break;
            default:
                $this->showOverview();
                break;
        }

        $this->parseMessages();

        $objTemplate->setVariable('ADMIN_CONTENT', $this->objTemplate->get());
    }

    /**
     * Replace status message placeholders with the value.
     *
     * @access      private
     */
    private function parseMessages()
    {
        $this->objTemplate->setVariable(array(
            'CHECKOUT_CONTENT_OK_MESSAGE'       => count($this->arrStatusMessages['ok']) ? '<div class="okbox">'.implode('<br />', $this->arrStatusMessages['ok']).'</div>' : '',
            'CHECKOUT_CONTENT_WARNING_MESSAGE'  => count($this->arrStatusMessages['warning']) ? '<div class="warningbox">'.implode('<br />', $this->arrStatusMessages['warning']).'</div>' : '',
            'CHECKOUT_CONTENT_ALERT_MESSAGE'    => count($this->arrStatusMessages['alert']) ? '<div class="alertbox">'.implode('<br />', $this->arrStatusMessages['alert']).'</div>' : '',
        ));
    }

    /**
     * Show overview of all transactions.
     *
     * @access      private
     */
    private function showOverview()
    {
        global $objDatabase, $_ARRAYLANG, $_CONFIG;

        $this->objTemplate->loadTemplateFile('module_checkout_overview.html');

        //check the payment service provider configuration
        $objSettingsGeneral = new SettingsGeneral($objDatabase);
        if (!$objSettingsGeneral->getEpaymentStatus()) {
            $this->arrStatusMessages['warning'][] = $_ARRAYLANG['TXT_CHECKOUT_EPAYMENT_DEACTIVATED'];
        }

        JS::activate('cx');

        $tableRow = '';
        $pagingCount = $this->objTransaction->getRecordCount();
        $pagingPosition = !empty($_GET['pos']) ? intval($_GET['pos']) : 0;

        $this->objTemplate->setVariable(array(
            'TXT_CHECKOUT_ALL_ENTRIES'      => $_ARRAYLANG['TXT_CHECKOUT_ALL_ENTRIES'],
            'TXT_CHECKOUT_ID'               => $_ARRAYLANG['TXT_CHECKOUT_ID'],
            'TXT_CHECKOUT_TIME'             => $_ARRAYLANG['TXT_CHECKOUT_TIME'],
            'TXT_CHECKOUT_STATUS'           => $_ARRAYLANG['TXT_CHECKOUT_STATUS'],
            'TXT_CHECKOUT_INVOICE_NUMBER'   => $_ARRAYLANG['TXT_CHECKOUT_INVOICE_NUMBER'],
            'TXT_CHECKOUT_INVOICE_AMOUNT'   => $_ARRAYLANG['TXT_CHECKOUT_INVOICE_AMOUNT'],
            'TXT_CHECKOUT_COMPANY'          => $_ARRAYLANG['TXT_CHECKOUT_COMPANY'],
            'TXT_CHECKOUT_NAME'             => $_ARRAYLANG['TXT_CHECKOUT_NAME'],
            'TXT_CHECKOUT_PHONE'            => $_ARRAYLANG['TXT_CHECKOUT_PHONE'],
            'TXT_CHECKOUT_EMAIL'            => $_ARRAYLANG['TXT_CHECKOUT_EMAIL'],
            'TXT_CHECKOUT_ACTIONS'          => $_ARRAYLANG['TXT_CHECKOUT_ACTIONS'],
            'TXT_CHECKOUT_DELETE'           => $_ARRAYLANG['TXT_CHECKOUT_DELETE'],
            'TXT_CHECKOUT_DETAIL'           => $_ARRAYLANG['TXT_CHECKOUT_DETAIL'],
        ));

        $arrTransactions = $this->objTransaction->get(array(), $pagingPosition, $_CONFIG['corePagingLimit']);
        if (!empty($arrTransactions)) {
            foreach ($arrTransactions as $arrTransaction) {
                $arrTransaction['time'] = date('j.n.Y G:i:s', $arrTransaction['time']);

                switch ($arrTransaction['status']) {
                    case self::WAITING:
                        $arrTransaction['status'] = $_ARRAYLANG['TXT_CHECKOUT_STATUS_WAITING'];
                        break;
                    case self::CONFIRMED:
                        $arrTransaction['status'] = $_ARRAYLANG['TXT_CHECKOUT_STATUS_CONFIRMED'];
                        break;
                    case self::CANCELLED:
                        $arrTransaction['status'] = $_ARRAYLANG['TXT_CHECKOUT_STATUS_CANCELLED'];
                        break;
                }

                $arrTransaction['invoice_currency'] = $this->arrCurrencies[$arrTransaction['invoice_currency']];
                $arrTransaction['invoice_amount'] = number_format($arrTransaction['invoice_amount'], 2, '.', '\'').' '.$arrTransaction['invoice_currency'];

                $this->objTemplate->setVariable(array(
                    'CHECKOUT_ROW_CLASS'        => $tableRow++ % 2 == 1 ? 'row1' : 'row2',
                    'CHECKOUT_ID'               => $arrTransaction['id'],
                    'CHECKOUT_TIME'             => contrexx_raw2xhtml($arrTransaction['time']),
                    'CHECKOUT_STATUS'           => $arrTransaction['status'],
                    'CHECKOUT_INVOICE_NUMBER'   => $arrTransaction['invoice_number'],
                    'CHECKOUT_INVOICE_AMOUNT'   => contrexx_raw2xhtml($arrTransaction['invoice_amount']),
                    'CHECKOUT_COMPANY'          => contrexx_raw2xhtml($arrTransaction['contact_company']),
                    'CHECKOUT_NAME'             => contrexx_raw2xhtml($arrTransaction['contact_forename'].' '.$arrTransaction['contact_surname']),
                    'CHECKOUT_PHONE'            => contrexx_raw2xhtml($arrTransaction['contact_phone']),
                    'CHECKOUT_EMAIL'            => contrexx_raw2xhtml($arrTransaction['contact_email']),
                ));

                $this->objTemplate->parse('transaction');
            }

            if ($pagingCount > $_CONFIG['corePagingLimit']) {
                $this->objTemplate->setVariable('CHECKOUT_PAGING', getPaging($pagingCount, $pagingPosition, "&cmd=checkout", $_ARRAYLANG['TXT_CHECKOUT_TRANSACTIONS']));
            }

            $this->objTemplate->parse('transactions');
        } else {
            if (empty($this->arrStatusMessages['warning'])) {
                $this->arrStatusMessages['warning'][] = $_ARRAYLANG['TXT_CHECKOUT_NO_ENTRIES'];
            }
            $this->objTemplate->hideBlock('transactions');
        }
    }

    /**
     * Show details of requested transaction.
     *
     * @access      private
     */
    private function showDetail()
    {
        global $objDatabase, $_ARRAYLANG, $_CONFIG;

        if (empty($_GET['id'])) {
            CSRF::header('location: index.php?cmd=checkout');
        }

        $tableRow = '';

        $this->objTemplate->loadTemplateFile('module_checkout_detail.html');
        $this->objTemplate->setVariable(array(
            'TXT_CHECKOUT_TRANSACTION'      => $_ARRAYLANG['TXT_CHECKOUT_TRANSACTION'],
            'TXT_CHECKOUT_INVOICE'          => $_ARRAYLANG['TXT_CHECKOUT_INVOICE'],
            'TXT_CHECKOUT_CONTACT'          => $_ARRAYLANG['TXT_CHECKOUT_CONTACT'],
            'TXT_CHECKOUT_ID'               => $_ARRAYLANG['TXT_CHECKOUT_ID'],
            'TXT_CHECKOUT_TIME'             => $_ARRAYLANG['TXT_CHECKOUT_TIME'],
            'TXT_CHECKOUT_STATUS'           => $_ARRAYLANG['TXT_CHECKOUT_STATUS'],
            'TXT_CHECKOUT_INVOICE_NUMBER'   => $_ARRAYLANG['TXT_CHECKOUT_INVOICE_NUMBER'],
            'TXT_CHECKOUT_INVOICE_AMOUNT'   => $_ARRAYLANG['TXT_CHECKOUT_INVOICE_AMOUNT'],
            'TXT_CHECKOUT_TITLE'            => $_ARRAYLANG['TXT_CHECKOUT_TITLE'],
            'TXT_CHECKOUT_FORENAME'         => $_ARRAYLANG['TXT_CHECKOUT_FORENAME'],
            'TXT_CHECKOUT_SURNAME'          => $_ARRAYLANG['TXT_CHECKOUT_SURNAME'],
            'TXT_CHECKOUT_COMPANY'          => $_ARRAYLANG['TXT_CHECKOUT_COMPANY'],
            'TXT_CHECKOUT_STREET'           => $_ARRAYLANG['TXT_CHECKOUT_STREET'],
            'TXT_CHECKOUT_POSTCODE'         => $_ARRAYLANG['TXT_CHECKOUT_POSTCODE'],
            'TXT_CHECKOUT_PLACE'            => $_ARRAYLANG['TXT_CHECKOUT_PLACE'],
            'TXT_CHECKOUT_COUNTRY'          => $_ARRAYLANG['TXT_CHECKOUT_COUNTRY'],
            'TXT_CHECKOUT_PHONE'            => $_ARRAYLANG['TXT_CHECKOUT_PHONE'],
            'TXT_CHECKOUT_EMAIL'            => $_ARRAYLANG['TXT_CHECKOUT_EMAIL'],
            'TXT_CHECKOUT_DELETE'           => $_ARRAYLANG['TXT_CHECKOUT_DELETE'],
        ));

        $arrTransactions = $this->objTransaction->get(array($_GET['id']));
        if (!empty($arrTransactions[0])) {
            $arrTransaction = $arrTransactions[0];

            $arrTransaction['time'] = date('j.n.Y G:i:s', $arrTransaction['time']);

            switch ($arrTransaction['status']) {
                case self::WAITING:
                    $arrTransaction['status'] = $_ARRAYLANG['TXT_CHECKOUT_STATUS_WAITING'];
                    break;
                case self::CONFIRMED:
                    $arrTransaction['status'] = $_ARRAYLANG['TXT_CHECKOUT_STATUS_CONFIRMED'];
                    break;
                case self::CANCELLED:
                    $arrTransaction['status'] = $_ARRAYLANG['TXT_CHECKOUT_STATUS_CANCELLED'];
                    break;
            }

            $arrTransaction['invoice_currency'] = $this->arrCurrencies[$arrTransaction['invoice_currency']];
            $arrTransaction['invoice_amount'] = number_format($arrTransaction['invoice_amount'], 2, '.', '\'').' '.$arrTransaction['invoice_currency'];

            switch ($arrTransaction['contact_title']) {
                case self::MISTER:
                    $arrTransaction['contact_title'] = $_ARRAYLANG['TXT_CHECKOUT_TITLE_MISTER'];
                    break;
                case self::MISS:
                    $arrTransaction['contact_title'] = $_ARRAYLANG['TXT_CHECKOUT_TITLE_MISS'];
                    break;
            }

            $this->objTemplate->setVariable(array(
                'CHECKOUT_ROW_CLASS'        => $tableRow++ % 2 == 1 ? 'row1' : 'row2',
                'CHECKOUT_ID'               => $arrTransaction['id'],
                'CHECKOUT_TIME'             => contrexx_raw2xhtml($arrTransaction['time']),
                'CHECKOUT_STATUS'           => $arrTransaction['status'],
                'CHECKOUT_INVOICE_NUMBER'   => $arrTransaction['invoice_number'],
                'CHECKOUT_INVOICE_AMOUNT'   => contrexx_raw2xhtml($arrTransaction['invoice_amount']),
                'CHECKOUT_TITLE'            => contrexx_raw2xhtml($arrTransaction['contact_title']),
                'CHECKOUT_FORENAME'         => contrexx_raw2xhtml($arrTransaction['contact_forename']),
                'CHECKOUT_SURNAME'          => contrexx_raw2xhtml($arrTransaction['contact_surname']),
                'CHECKOUT_COMPANY'          => contrexx_raw2xhtml($arrTransaction['contact_company']),
                'CHECKOUT_STREET'           => contrexx_raw2xhtml($arrTransaction['contact_street']),
                'CHECKOUT_POSTCODE'         => contrexx_raw2xhtml($arrTransaction['contact_postcode']),
                'CHECKOUT_PLACE'            => contrexx_raw2xhtml($arrTransaction['contact_place']),
                'CHECKOUT_COUNTRY'          => contrexx_raw2xhtml($arrTransaction['contact_country']),
                'CHECKOUT_PHONE'            => contrexx_raw2xhtml($arrTransaction['contact_phone']),
                'CHECKOUT_EMAIL'            => contrexx_raw2xhtml($arrTransaction['contact_email']),
            ));

            $this->objTemplate->parse('transaction');
        }
    }

    /**
     * Delete requested transaction
     *
     * @access      private
     */
    private function deleteEntry()
    {
        global $objDatabase, $_ARRAYLANG;

        if (empty($_GET['id'])) {
            CSRF::header('location: index.php?cmd=checkout');
        }

        if ($this->objTransaction->delete($_GET['id'])) {
            $this->arrStatusMessages['ok'][] = $_ARRAYLANG['TXT_CHECKOUT_ENTRY_DELETED_SUCCESSFULLY'];
        } else {
            $this->arrStatusMessages['alert'][] = $_ARRAYLANG['TXT_CHECKOUT_ENTRY_COULD_NOT_BE_DELETED'];
        }
    }

    /**
     * Show setttings page
     *
     * @access      private
     */
    private function showSettings()
    {
        global $_CORELANG, $_ARRAYLANG;

        $this->objTemplate->loadTemplateFile('module_checkout_settings.html', true, true);
        $this->objTemplate->setVariable(array(
            'TXT_CORE_GENERAL'                  => $_CORELANG['TXT_CORE_GENERAL'],
            'TXT_CHECKOUT_SETTINGS_PSP'         => $_ARRAYLANG['TXT_CHECKOUT_SETTINGS_PSP'],
            'TXT_CHECKOUT_SETTINGS_MAILS'       => $_ARRAYLANG['TXT_CHECKOUT_SETTINGS_MAILS'],
            'CHECKOUT_GENERAL_LINK_ACTIVE'      => ($_GET['tpl'] == 'general' || $_GET['tpl'] == '') ? 'active' : '',
            'CHECKOUT_PSP_LINK_ACTIVE'          => $_GET['tpl'] == 'psp' ? 'active' : '',
            'CHECKOUT_MAILS_LINK_ACTIVE'        => $_GET['tpl'] == 'mails' ? 'active' : '',
        ));

        switch ($_GET['tpl']) {
            case 'general':
                $this->showSettingsGeneral();
                break;
            case 'psp':
                $this->showSettingsPSP();
                break;
            case 'mails':
                $this->showSettingsMails();
                break;
            default:
                $this->showSettingsGeneral();
                break;
        }
    }

    /**
     * Show setttings general page
     *
     * @access      private
     */
    private function showSettingsGeneral()
    {
        global $_CORELANG, $_ARRAYLANG;

        JS::activate('jquery');
        $this->objTemplate->addBlockfile('CHECKOUT_SETTINGS_CONTENT', 'settings_content', 'module_checkout_settings_general.html');

        if (isset($_POST['submit'])) {
            if (!empty($_POST['epayment_status'])) {
                //check if the Yellowpay configuration is filled out
                $arrYellowpay = $this->objSettingsYellowpay->get();
                $yellowpayStatus = true;
                foreach ($arrYellowpay as $value) {
                    $value = trim($value);
                    if (empty($value)) {
                        $yellowpayStatus = false;
                    }
                }

                if ($yellowpayStatus) {
                    if ($this->objSettingsGeneral->setEpaymentStatus($_POST['epayment_status'])) {
                        $this->arrStatusMessages['ok'][] = $_ARRAYLANG['TXT_CHECKOUT_SETTINGS_CHANGES_SAVED_SUCCESSFULLY'];
                    } else {
                        $this->arrStatusMessages['alert'][] = $_ARRAYLANG['TXT_CHECKOUT_SETTINGS_CHANGES_COULD_NOT_BE_SAVED'];
                    }
                } else {
                    $this->arrStatusMessages['alert'][] = $_ARRAYLANG['TXT_CHECKOUT_SETTINGS_GENERAL_EPAYMENT_ACTIVATION_FAILED'];
                }
            } else {
                if ($this->objSettingsGeneral->setEpaymentStatus(0)) {
                    $this->arrStatusMessages['ok'][] = $_ARRAYLANG['TXT_CHECKOUT_SETTINGS_CHANGES_SAVED_SUCCESSFULLY'];
                } else {
                    $this->arrStatusMessages['alert'][] = $_ARRAYLANG['TXT_CHECKOUT_SETTINGS_CHANGES_COULD_NOT_BE_SAVED'];
                }
            }
        }

        $pages = Env::em()->getRepository('Cx\Core\ContentManager\Model\Entity\Page')->getFromModuleCmdByLang('checkout');

        $arrActiveFrontendLanguages = FWLanguage::getActiveFrontendLanguages();
        if (isset($arrActiveFrontendLanguages[FRONTEND_LANG_ID]) && isset($pages[FRONTEND_LANG_ID])) {
            $langId = FRONTEND_LANG_ID;
        } else if (isset($arrActiveFrontendLanguages[BACKEND_LANG_ID]) && isset($pages[BACKEND_LANG_ID])) {
            $langId = BACKEND_LANG_ID;
        } else {
            foreach ($arrActiveFrontendLanguages as $lang) {
                if (isset($pages[$lang['id']])) {
                    $langId = $lang['id'];
                    break;
                }
            }
        }

        $backendLinkURL = isset($pages[$langId]) ? 'index.php?cmd=content&page='.$pages[$langId]->getId().'&tab=content' : 'javascript:void(0);';
        $frontendLinkURL = isset($pages[$langId]) ? '../'.\FWLanguage::getLanguageCodeById($langId).$pages[$langId]->getPath() : 'javascript:void(0);';

        $parameterPassingDescription = $_ARRAYLANG['TXT_CHECKOUT_SETTINGS_GENERAL_PARAMETER_PASSING_DESCRIPTION'];
        $parameterPassingDescription = str_replace('%1$s', '<img src="../modules/checkout/images/parameter_passing/url.jpg" width="792" height="36" />', $parameterPassingDescription);
        $parameterPassingDescription = str_replace('%2$s', '<img src="../modules/checkout/images/parameter_passing/form.jpg" width="612" height="345" />', $parameterPassingDescription);

        $this->objTemplate->setVariable(array(
            'TXT_CHECKOUT_SETTINGS_GENERAL_STATUS'                          => $_ARRAYLANG['TXT_CHECKOUT_SETTINGS_GENERAL_STATUS'],
            'TXT_CHECKOUT_SETTINGS_GENERAL_EPAYMENT_ACTIVATED'              => $_ARRAYLANG['TXT_CHECKOUT_SETTINGS_GENERAL_EPAYMENT_ACTIVATED'],
            'TXT_CHECKOUT_SETTINGS_GENERAL_EPAYMENT_ACTIVATED_INFO'         => $_ARRAYLANG['TXT_CHECKOUT_SETTINGS_GENERAL_EPAYMENT_ACTIVATED_INFO'],
            'CHECKOUT_EPAYMENT_STATUS_CHECKED'                              => $this->objSettingsGeneral->getEpaymentStatus() ? 'checked="checked"' : '',
            'TXT_SAVE'                                                      => $_CORELANG['TXT_SAVE'],
            'TXT_CHECKOUT_SETTINGS_GENERAL_INFORMATION'                     => $_ARRAYLANG['TXT_CHECKOUT_SETTINGS_GENERAL_INFORMATION'],
            'TXT_CHECKOUT_SETTINGS_GENERAL_MODULE_NAME_TITLE'               => $_ARRAYLANG['TXT_CHECKOUT_SETTINGS_GENERAL_MODULE_NAME_TITLE'],
            'TXT_CHECKOUT_MODULE_NAME'                                      => $_ARRAYLANG['TXT_CHECKOUT_MODULE_NAME'],
            'TXT_CHECKOUT_SETTINGS_GENERAL_MODULE_DESCRIPTION_TITLE'        => $_ARRAYLANG['TXT_CHECKOUT_SETTINGS_GENERAL_MODULE_DESCRIPTION_TITLE'],
            'TXT_CHECKOUT_SETTINGS_GENERAL_MODULE_DESCRIPTION'              => $_ARRAYLANG['TXT_CHECKOUT_SETTINGS_GENERAL_MODULE_DESCRIPTION'],
            'TXT_CORE_EDIT_PAGE_LAYOUT'                                     => $_CORELANG['TXT_CORE_EDIT_PAGE_LAYOUT'],
            'TXT_CORE_SHOW_FRONTEND_VIEW'                                   => $_CORELANG['TXT_CORE_SHOW_FRONTEND_VIEW'],
            'TXT_CHECKOUT_LINKS'                                            => $_ARRAYLANG['TXT_CHECKOUT_LINKS'],
            'CHECKOUT_BACKEND_LINK_URL'                                     => $backendLinkURL,
            'CHECKOUT_FRONTEND_LINK_URL'                                    => $frontendLinkURL,
            'TXT_CHECKOUT_SETTINGS_GENERAL_PARAMETER_PASSING_TITLE'         => $_ARRAYLANG['TXT_CHECKOUT_SETTINGS_GENERAL_PARAMETER_PASSING_TITLE'],
            'TXT_CHECKOUT_SETTINGS_GENERAL_PARAMETER_PASSING_DESCRIPTION'   => $parameterPassingDescription,
        ));
        $this->objTemplate->touchBlock('settings_content');
    }

    /**
     * Show setttings psp page
     *
     * @access      private
     */
    private function showSettingsPSP()
    {
        global $_CORELANG, $_ARRAYLANG;

        $arrYellowpay['pspid'] = '';
        $arrYellowpay['sha_in'] = '';
        $arrYellowpay['sha_out'] = '';
        $arrYellowpay['operation'] = '';
        $arrYellowpay['testserver'] = '';

        if (isset($_POST['submit'])) {
            $arrYellowpay['pspid'] = !empty($_POST['yellowpay']['pspid']) ? contrexx_input2raw($_POST['yellowpay']['pspid']) : '';
            $arrYellowpay['sha_in'] = !empty($_POST['yellowpay']['sha_in']) ? contrexx_input2raw($_POST['yellowpay']['sha_in']) : '';
            $arrYellowpay['sha_out'] = !empty($_POST['yellowpay']['sha_out']) ? contrexx_input2raw($_POST['yellowpay']['sha_out']) : '';
            $arrYellowpay['operation'] = !empty($_POST['yellowpay']['operation']) ? contrexx_input2raw($_POST['yellowpay']['operation']) : '';
            $arrYellowpay['testserver'] = !empty($_POST['yellowpay']['testserver']) ? contrexx_input2raw($_POST['yellowpay']['testserver']) : '';

            if ($this->objSettingsYellowpay->update($arrYellowpay)) {
                $this->arrStatusMessages['ok'][] = $_ARRAYLANG['TXT_CHECKOUT_SETTINGS_CHANGES_SAVED_SUCCESSFULLY'];
            } else {
                $this->arrStatusMessages['alert'][] = $_ARRAYLANG['TXT_CHECKOUT_SETTINGS_CHANGES_COULD_NOT_BE_SAVED'];
            }
        } else {
            $arrYellowpay = $this->objSettingsYellowpay->get();
        }

        $yellowpayOperationOptions = '
            <option value="SAL"'.(($arrYellowpay['operation'] == 'SAL') ? ' selected="selected"' : '').'>Verkauf</option>
            <option value="RES"'.(($arrYellowpay['operation'] == 'RES') ? ' selected="selected"' : '').'>Authorisierung</option>
        ';
        $yellowpayTestserverChecked = !empty($arrYellowpay['testserver']) ? 'checked="checked"' : '';

        $this->objTemplate->addBlockfile('CHECKOUT_SETTINGS_CONTENT', 'settings_content', 'module_checkout_settings_psp.html');
        $this->objTemplate->setVariable(array(
            'TXT_CHECKOUT_SETTINGS_PSP_YELLOWPAY_TITLE'             => $_ARRAYLANG['TXT_CHECKOUT_SETTINGS_PSP_YELLOWPAY_TITLE'],
            'TXT_CHECKOUT_SETTINGS_PSP_YELLOWPAY_PSPID'             => $_ARRAYLANG['TXT_CHECKOUT_SETTINGS_PSP_YELLOWPAY_PSPID'],
            'TXT_CHECKOUT_SETTINGS_PSP_YELLOWPAY_PSPID_INFO'        => $_ARRAYLANG['TXT_CHECKOUT_SETTINGS_PSP_YELLOWPAY_PSPID_INFO'],
            'TXT_CHECKOUT_SETTINGS_PSP_YELLOWPAY_SHA_IN'            => $_ARRAYLANG['TXT_CHECKOUT_SETTINGS_PSP_YELLOWPAY_SHA_IN'],
            'TXT_CHECKOUT_SETTINGS_PSP_YELLOWPAY_SHA_OUT'           => $_ARRAYLANG['TXT_CHECKOUT_SETTINGS_PSP_YELLOWPAY_SHA_OUT'],
            'TXT_CHECKOUT_SETTINGS_PSP_YELLOWPAY_OPERATION'         => $_ARRAYLANG['TXT_CHECKOUT_SETTINGS_PSP_YELLOWPAY_OPERATION'],
            'TXT_CHECKOUT_SETTINGS_PSP_YELLOWPAY_TESTSERVER'        => $_ARRAYLANG['TXT_CHECKOUT_SETTINGS_PSP_YELLOWPAY_TESTSERVER'],
            'TXT_CHECKOUT_SETTINGS_PSP_YELLOWPAY_TESTSERVER_INFO'   => $_ARRAYLANG['TXT_CHECKOUT_SETTINGS_PSP_YELLOWPAY_TESTSERVER_INFO'],
            'TXT_CHECKOUT_SETTINGS_PSP_YELLOWPAY_MORE_INFORMATION'  => $_ARRAYLANG['TXT_CHECKOUT_SETTINGS_PSP_YELLOWPAY_MORE_INFORMATION'],
            'CHECKOUT_YELLOWPAY_PSPID'                              => $arrYellowpay['pspid'],
            'CHECKOUT_YELLOWPAY_SHA_IN'                             => $arrYellowpay['sha_in'],
            'CHECKOUT_YELLOWPAY_SHA_OUT'                            => $arrYellowpay['sha_out'],
            'CHECKOUT_YELLOWPAY_OPERATION_OPTIONS'                  => $yellowpayOperationOptions,
            'CHECKOUT_YELLOWPAY_TESTSERVER_CHECKED'                 => $yellowpayTestserverChecked,
            'TXT_CORE_SAVE'                                         => $_CORELANG['TXT_SAVE'],
        ));
        $this->objTemplate->parse('settings_content');
    }

    /**
     * Show setttings mails page
     *
     * @access      private
     */
    private function showSettingsMails()
    {
        global $_CORELANG, $_ARRAYLANG;

        $arrAdminMail['title'] = '';
        $arrAdminMail['content'] = '';
        $arrCustomerMail['title'] = '';
        $arrCustomerMail['content'] = '';

        if (isset($_POST['submit_admin_mail'])) {
            $arrAdminMail['title'] = !empty($_POST['adminMail']['title']) ? contrexx_input2raw($_POST['adminMail']['title']) : '';
            $arrAdminMail['content'] = !empty($_POST['adminMail']['content']) ? contrexx_input2raw($_POST['adminMail']['content']) : '';

            if ($this->objSettingsMails->updateAdminMail($arrAdminMail)) {
                $this->arrStatusMessages['ok'][] = $_ARRAYLANG['TXT_CHECKOUT_SETTINGS_CHANGES_SAVED_SUCCESSFULLY'];
            } else {
                $this->arrStatusMessages['alert'][] = $_ARRAYLANG['TXT_CHECKOUT_SETTINGS_CHANGES_COULD_NOT_BE_SAVED'];
            }
        }
        if (isset($_POST['submit_customer_mail'])) {
            $arrCustomerMail['title'] = !empty($_POST['customerMail']['title']) ? contrexx_input2raw($_POST['customerMail']['title']) : '';
            $arrCustomerMail['content'] = !empty($_POST['customerMail']['content']) ? contrexx_input2raw($_POST['customerMail']['content']) : '';

            if ($this->objSettingsMails->updateCustomerMail($arrCustomerMail)) {
                $this->arrStatusMessages['ok'][] = $_ARRAYLANG['TXT_CHECKOUT_SETTINGS_CHANGES_SAVED_SUCCESSFULLY'];
            } else {
                $this->arrStatusMessages['alert'][] = $_ARRAYLANG['TXT_CHECKOUT_SETTINGS_CHANGES_COULD_NOT_BE_SAVED'];
            }
        }

        $arrAdminMail = $this->objSettingsMails->getAdminMail();
        $arrCustomerMail = $this->objSettingsMails->getCustomerMail();

        $this->objTemplate->addBlockfile('CHECKOUT_SETTINGS_CONTENT', 'settings_content', 'module_checkout_settings_mails.html');
        $this->objTemplate->setVariable(array(
            'TXT_CHECKOUT_SETTINGS_MAILS_ADMIN'                 => $_ARRAYLANG['TXT_CHECKOUT_SETTINGS_MAILS_ADMIN'],
            'TXT_CHECKOUT_SETTINGS_MAILS_CUSTOMER'              => $_ARRAYLANG['TXT_CHECKOUT_SETTINGS_MAILS_CUSTOMER'],
            'TXT_CHECKOUT_SETTINGS_MAILS_ADMIN_MAIL_CONFIRM'    => $_ARRAYLANG['TXT_CHECKOUT_SETTINGS_MAILS_ADMIN_MAIL_CONFIRM'],
            'TXT_CHECKOUT_SETTINGS_MAILS_CUSTOMER_MAIL_CONFIRM' => $_ARRAYLANG['TXT_CHECKOUT_SETTINGS_MAILS_CUSTOMER_MAIL_CONFIRM'],
            'TXT_CHECKOUT_SETTINGS_MAILS_SUBJECT'               => $_ARRAYLANG['TXT_CHECKOUT_SETTINGS_MAILS_SUBJECT'],
            'CHECKOUT_ADMIN_MAIL_TITLE'                         => $arrAdminMail['title'],
            'CHECKOUT_ADMIN_MAIL_CONTENT'                       => new \Cx\Core\Wysiwyg\Wysiwyg('adminMail[content]', $arrAdminMail['content'], 'fullpage'),
            'CHECKOUT_CUSTOMER_MAIL_TITLE'                      => $arrCustomerMail['title'],
            'CHECKOUT_CUSTOMER_MAIL_CONTENT'                    => new \Cx\Core\Wysiwyg\Wysiwyg('customerMail[content]', $arrCustomerMail['content'], 'fullpage'),
            'TXT_CORE_SAVE'                                     => $_CORELANG['TXT_SAVE'],
            'TXT_CORE_PLACEHOLDERS'                             => $_CORELANG['TXT_CORE_PLACEHOLDERS'],
            'TXT_CHECKOUT_SETTINGS_PLACEHOLDERS_MAILS_TITLE'    => $_ARRAYLANG['TXT_CHECKOUT_SETTINGS_PLACEHOLDERS_MAILS_TITLE'],
            'TXT_CHECKOUT_SETTINGS_PLACEHOLDERS_DOMAIN'         => $_ARRAYLANG['TXT_CHECKOUT_SETTINGS_PLACEHOLDERS_DOMAIN'],
            'TXT_CHECKOUT_SETTINGS_PLACEHOLDERS_ID'             => $_ARRAYLANG['TXT_CHECKOUT_SETTINGS_PLACEHOLDERS_ID'],
            'TXT_CHECKOUT_SETTINGS_PLACEHOLDERS_STATUS'         => $_ARRAYLANG['TXT_CHECKOUT_SETTINGS_PLACEHOLDERS_STATUS'],
            'TXT_CHECKOUT_SETTINGS_PLACEHOLDERS_TIME'           => $_ARRAYLANG['TXT_CHECKOUT_SETTINGS_PLACEHOLDERS_TIME'],
            'TXT_CHECKOUT_INVOICE_NUMBER'                       => $_ARRAYLANG['TXT_CHECKOUT_INVOICE_NUMBER'],
            'TXT_CHECKOUT_INVOICE_CURRENCY'                     => $_ARRAYLANG['TXT_CHECKOUT_INVOICE_CURRENCY'],
            'TXT_CHECKOUT_INVOICE_AMOUNT'                       => $_ARRAYLANG['TXT_CHECKOUT_INVOICE_AMOUNT'],
            'TXT_CHECKOUT_TITLE'                                => $_ARRAYLANG['TXT_CHECKOUT_TITLE'],
            'TXT_CHECKOUT_FORENAME'                             => $_ARRAYLANG['TXT_CHECKOUT_FORENAME'],
            'TXT_CHECKOUT_SURNAME'                              => $_ARRAYLANG['TXT_CHECKOUT_SURNAME'],
            'TXT_CHECKOUT_COMPANY'                              => $_ARRAYLANG['TXT_CHECKOUT_COMPANY'],
            'TXT_CHECKOUT_STREET'                               => $_ARRAYLANG['TXT_CHECKOUT_STREET'],
            'TXT_CHECKOUT_POSTCODE'                             => $_ARRAYLANG['TXT_CHECKOUT_POSTCODE'],
            'TXT_CHECKOUT_PLACE'                                => $_ARRAYLANG['TXT_CHECKOUT_PLACE'],
            'TXT_CHECKOUT_COUNTRY'                              => $_ARRAYLANG['TXT_CHECKOUT_COUNTRY'],
            'TXT_CHECKOUT_PHONE'                                => $_ARRAYLANG['TXT_CHECKOUT_PHONE'],
            'TXT_CHECKOUT_EMAIL'                                => $_ARRAYLANG['TXT_CHECKOUT_EMAIL'],
        ));
        $this->objTemplate->touchBlock('settings_content');
    }
}
