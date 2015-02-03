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
 * Newsletter Modul
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author Comvation Development Team <info@comvation.com>
 * @access public
 * @version 1.1.0
 * @package     contrexx
 * @subpackage  module_newsletter
 * @todo        Edit PHP DocBlocks!
 */
 
/**
 * Newsletter Modul
 *
 * frontend newsletter class
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author Comvation Development Team <info@comvation.com>
 * @access public
 * @version 1.1.0
 * @package     contrexx
 * @subpackage  module_newsletter
 * @todo        Edit PHP DocBlocks!
 */
class newsletter extends NewsletterLib
{
    public $_objTpl;
    public $months = array();

    /**
     * Constructor
     * @param  string  $pageContent
     */
    function __construct($pageContent)
    {
        global $_ARRAYLANG;
        $this->pageContent = $pageContent;
        $this->_objTpl = new \Cx\Core\Html\Sigma('.');
        CSRF::add_placeholder($this->_objTpl);
        $this->_objTpl->setErrorHandling(PEAR_ERROR_DIE);
        $months = explode(',', $_ARRAYLANG['TXT_NEWSLETTER_MONTHS_ARRAY']);
        $i=0;
        foreach ($months as $month) {
            $this->months[++$i] = $month;
        }
    }

    function getPage()
    {
        if (!isset($_REQUEST['cmd'])) {
            $_REQUEST['cmd'] = '';
        }

        switch($_REQUEST['cmd']) {
            case 'profile':
                $this->_profile();
                break;
            case 'unsubscribe':
                $this->_unsubscribe();
                break;
             case 'subscribe':
                $this->_profile();
                break;
            case 'confirm':
                $this->_confirm();
                break;
            case 'displayInBrowser':
                $this->displayInBrowser();
                break;
            default:
                $this->_profile();
                break;
        }
        return $this->_objTpl->get();
    }


    function _confirm()
    {
        global $objDatabase, $_ARRAYLANG, $_CONFIG;
        $this->_objTpl->setTemplate($this->pageContent, true, true);

        $query         = "SELECT id FROM ".DBPREFIX."module_newsletter_user where status=0 and email='".contrexx_addslashes($_GET['email'])."'";
        $objResult     = $objDatabase->Execute($query);
        $count         = $objResult->RecordCount();
        $userId        = $objResult->fields['id'];

        if($count == 1){
            $objResult     = $objDatabase->Execute("UPDATE ".DBPREFIX."module_newsletter_user SET status=1 where email='".contrexx_addslashes($_GET['email'])."'");
            if ($objResult !== false) {
                $this->_objTpl->setVariable("NEWSLETTER_MESSAGE", $_ARRAYLANG['TXT_NEWSLETTER_CONFIRMATION_SUCCESSFUL']);

                //send notification
                $this->_sendNotificationEmail(1, $userId);

                //send mail
                $query = "SELECT id, sex, salutation, firstname, lastname, email, code FROM ".DBPREFIX."module_newsletter_user WHERE email='".contrexx_addslashes($_GET['email'])."'";
                $objResult = $objDatabase->Execute($query);

                if ($objResult !== false) {
                    $userFirstname    = $objResult->fields['firstname'];
                    $userLastname    = $objResult->fields['lastname'];
                    $userTitle        = $objResult->fields['salutation'];
                    $userSex = $objResult->fields['sex'];

// TODO: use FWUSER
                    $arrRecipientTitles = &$this->_getRecipientTitles();
                    $userTitle = $arrRecipientTitles[$userTitle];


                    switch($userSex){
                        case "m":
                            $userSex = $_ARRAYLANG['TXT_NEWSLETTER_MALE'];
                            break;

                        case "f":
                            $userSex = $_ARRAYLANG['TXT_NEWSLETTER_FEMALE'];
                            break;

                        default:
                            $userSex = '';
                            break;
                    }

                    $query_conf         = "SELECT setvalue FROM ".DBPREFIX."module_newsletter_settings WHERE setid=1";
                    $objResult_conf     = $objDatabase->Execute($query_conf);
                    if ($objResult_conf !== false) {
                        $value_sender_emailDEF     = $objResult_conf->fields['setvalue'];
                    }

                    $query_conf         = "SELECT setvalue FROM ".DBPREFIX."module_newsletter_settings WHERE setid=2";
                    $objResult_conf     = $objDatabase->Execute($query_conf);
                    if ($objResult_conf !== false) {
                        $value_sender_nameDEF     = $objResult_conf->fields['setvalue'];
                    }

                    $query_conf         = "SELECT setvalue FROM ".DBPREFIX."module_newsletter_settings WHERE setid=3";
                    $objResult_conf     = $objDatabase->Execute($query_conf);
                    if ($objResult_conf !== false) {
                        $value_reply_mailDEF     = $objResult_conf->fields['setvalue'];
                    }

                    $query_content         = "SELECT title, content FROM ".DBPREFIX."module_newsletter_confirm_mail WHERE id='2'";
                    $objResult_content      = $objDatabase->Execute($query_content );
                    if ($objResult_content !== false) {
                        $subject     = $objResult_content->fields['title'];
                        $content     = $objResult_content->fields['content'];
                    }

                    require_once ASCMS_LIBRARY_PATH . '/phpmailer/class.phpmailer.php';

                    $url            = $_SERVER['SERVER_NAME'];
                    $now             = date(ASCMS_DATE_FORMAT);



                    //replase placeholder
                    $array_1 = array('[[sex]]', '[[title]]', '[[firstname]]', '[[lastname]]', '[[url]]', '[[date]]');
                    $array_2 = array($userSex, $userTitle, $userFirstname, $userLastname, $url, $now);

                    $mailTitle = str_replace($array_1, $array_2, $subject);
                    $mailContent = str_replace($array_1, $array_2, $content);


                    $mail = new phpmailer();

                    if ($_CONFIG['coreSmtpServer'] > 0 && @include_once ASCMS_CORE_PATH.'/SmtpSettings.class.php') {
                        if (($arrSmtp = SmtpSettings::getSmtpAccount($_CONFIG['coreSmtpServer'])) !== false) {
                            $mail->IsSMTP();
                            $mail->Host = $arrSmtp['hostname'];
                            $mail->Port = $arrSmtp['port'];
                            $mail->SMTPAuth = true;
                            $mail->Username = $arrSmtp['username'];
                            $mail->Password = $arrSmtp['password'];
                        }
                    }

                    $mail->CharSet = CONTREXX_CHARSET;
                    $mail->From             = $value_sender_emailDEF;
                    $mail->FromName         = $value_sender_nameDEF;
                    $mail->AddReplyTo($value_reply_mailDEF);
                    $mail->Subject             = $mailTitle;
                    $mail->Priority         = 3;
                    $mail->IsHTML(false);
                    $mail->Body             = $mailContent;
                    $mail->AddAddress($_GET['email']);
                    $mail->Send();

                }
            }
        }else{
            $this->_objTpl->setVariable("NEWSLETTER_MESSAGE", '<font color="red">'.$_ARRAYLANG['TXT_NOT_VALID_EMAIL'].'</font>');
        }
    }

    function _unsubscribe()
    {
        global $objDatabase, $_ARRAYLANG;

        $this->_objTpl->setTemplate($this->pageContent);
        $message = '';
        
        if (($objUser = $objDatabase->SelectLimit("SELECT id FROM ".DBPREFIX."module_newsletter_user WHERE code='".contrexx_addslashes($_REQUEST['code'])."' AND email='".urldecode(contrexx_addslashes($_REQUEST['mail']))."' AND status='1'", 1)) && $objUser->RecordCount() == 1) {
            $objSystem = $objDatabase->Execute("SELECT `setname`, `setvalue` FROM `".DBPREFIX."module_newsletter_settings`");
            if ($objSystem !== false) {
                while (!$objSystem->EOF) {
                    $arrSystem[$objSystem->fields['setname']] = $objSystem->fields['setvalue'];
                    $objSystem->MoveNext();
                }
            }

            if ($arrSystem['defUnsubscribe'] == 1) {
                //delete
                //send notification before trying to delete the record
                $this->_sendNotificationEmail(2, $objUser->fields['id']);
                if ($objDatabase->Execute("DELETE FROM ".DBPREFIX."module_newsletter_rel_user_cat WHERE user=".$objUser->fields['id']) && $objDatabase->Execute("DELETE FROM ".DBPREFIX."module_newsletter_user WHERE id=".$objUser->fields['id'])) {
                    $message = $_ARRAYLANG['TXT_EMAIL_SUCCESSFULLY_DELETED'];
                } else {
                    $message = $_ARRAYLANG['TXT_NEWSLETTER_FAILED_REMOVING_FROM_SYSTEM'];
                }
            } else {
                //deactivate
                if ($objDatabase->Execute("UPDATE ".DBPREFIX."module_newsletter_user SET status='0' WHERE id='".$objUser->fields['id']."'")) {
                    //send notification
                    $this->_sendNotificationEmail(2, $objUser->fields['id']);
                    $message = $_ARRAYLANG['TXT_EMAIL_SUCCESSFULLY_DELETED'];
                } else {
                    $message = $_ARRAYLANG['TXT_NEWSLETTER_FAILED_REMOVING_FROM_SYSTEM'];
                }
            }
        } else {
            $message = '<font color="red">'.$_ARRAYLANG['TXT_AUTHENTICATION_FAILED'].'</font>';
        }

        $this->_objTpl->setVariable("NEWSLETTER_MESSAGE", $message);
    }

    function _profile()
    {
        global $_ARRAYLANG, $objDatabase;

        $this->_objTpl->setTemplate($this->pageContent);

        $showForm = true;
        $arrStatusMessage = array('ok' => array(), 'error' => array());

        $isNewsletterRecipient = false;
        $isAccessRecipient = false;
        $recipientId = 0;
        $recipientEmail = '';
        $recipientUri = '';
        $recipientSex = '';
        $recipientSalutation = 0;
        $recipientTitle = '';
        $recipientPosition = '';
        $recipientIndustrySector = '';
        $recipientPhoneMobile = '';
        $recipientPhonePrivate = '';
        $recipientFax = '';
        $recipientNotes = '';
        $recipientLastname = '';
        $recipientFirstname = '';
        $recipientCompany = '';
        $recipientAddress = '';
        $recipientZip = '';
        $recipientCity = '';
        $recipientCountry = '';
        $recipientPhoneOffice = '';
        $recipientBirthday = '';
        $recipientLanguage = '';
        $recipientStatus = 0;
        $requestedMail = isset($_GET['mail']) ? contrexx_input2raw(urldecode($_GET['mail'])) : (isset($_POST['mail']) ? contrexx_input2raw($_POST['mail']) : '');
        $arrAssociatedLists = array();
        $arrPreAssociatedInactiveLists = array();
        $code = isset($_REQUEST['code']) ? contrexx_addslashes($_REQUEST['code']) : '';

        if (!empty($code) && !empty($requestedMail)) {
            $objRecipient = $objDatabase->SelectLimit("SELECT accessUserID
                FROM ".DBPREFIX."module_newsletter_access_user AS nu
                INNER JOIN ".DBPREFIX."access_users AS au ON au.id=nu.accessUserID
                WHERE nu.code='".$code."'
                AND email='".contrexx_raw2db($requestedMail)."'", 1);
            if ($objRecipient && $objRecipient->RecordCount() == 1) {
                $objUser = FWUser::getFWUserObject()->objUser->getUser($objRecipient->fields['accessUserID']);
                if ($objUser) {
                    $recipientId = $objUser->getId();
                    $isAccessRecipient = true;

                    //$arrAssociatedLists = $objUser->getSubscribedNewsletterListIDs();
                    $arrPreAssociatedInactiveLists = $objUser->getSubscribedNewsletterListIDs();
                }
            } else {
                $objRecipient = $objDatabase->SelectLimit("SELECT id FROM ".DBPREFIX."module_newsletter_user WHERE status=1 AND code='".$code."' AND email='".contrexx_raw2db($requestedMail)."'", 1);
                if ($objRecipient && $objRecipient->RecordCount() == 1) {
                    $recipientId = $objRecipient->fields['id'];
                    $isNewsletterRecipient = true;
                }
            }
        } else {
            if (FWUser::getFWUserObject()->objUser->login()) {
                $objUser = FWUser::getFWUserObject()->objUser;
                $recipientId = $objUser->getId();
                $isAccessRecipient = true;

                //$arrAssociatedLists = $objUser->getSubscribedNewsletterListIDs();
                $arrPreAssociatedInactiveLists = $objUser->getSubscribedNewsletterListIDs();
            }
        }
        
        // Get interface settings
        $objInterface = $objDatabase->Execute('SELECT `setvalue` 
                                                FROM `'.DBPREFIX.'module_newsletter_settings`
                                                WHERE `setname` = "recipient_attribute_status"');
    
        $recipientAttributeStatus = json_decode($objInterface->fields['setvalue'], true);
            
        if (isset($_POST['recipient_save'])) {
            if (isset($_POST['email'])) {
                $recipientEmail = $_POST['email'];
            }
            if (isset($_POST['website'])) {
                $recipientUri = $_POST['website'];
            }
            if (isset($_POST['sex'])) {
                $recipientSex = in_array($_POST['sex'], array('f', 'm')) ? $_POST['sex'] : '';
            }
            if (isset($_POST['salutation'])) {
// TODO: use FWUSER
                $arrRecipientTitles = $this->_getRecipientTitles();
                $recipientSalutation = in_array($_POST['salutation'], array_keys($arrRecipientTitles)) ? intval($_POST['salutation']) : 0;
            }
            if (isset($_POST['title'])) {
                $recipientTitle = $_POST['title'];
            }
            if (isset($_POST['lastname'])) {
                $recipientLastname = $_POST['lastname'];
            }
            if (isset($_POST['firstname'])) {
                $recipientFirstname = $_POST['firstname'];
            }
            if (isset($_POST['position'])) {
                $recipientPosition = $_POST['position'];
            }
            if (isset($_POST['company'])) {
                $recipientCompany = $_POST['company'];
            }
            if (isset($_POST['industry_sector'])) {
                $recipientIndustrySector = $_POST['industry_sector'];
            }
            if (isset($_POST['address'])) {
                $recipientAddress = $_POST['address'];
            }
            if (isset($_POST['zip'])) {
                $recipientZip = $_POST['zip'];
            }
            if (isset($_POST['city'])) {
                $recipientCity = $_POST['city'];
            }
            if (isset($_POST['newsletter_country_id'])) {
                $recipientCountry = $_POST['newsletter_country_id'];
            }
            if (isset($_POST['phone_office'])) {
                $recipientPhoneOffice = $_POST['phone_office'];
            }
            if (isset($_POST['phone_private'])) {
                $recipientPhonePrivate = $_POST['phone_private'];
            }
            if (isset($_POST['phone_mobile'])) {
                $recipientPhoneMobile = $_POST['phone_mobile'];
            }
            if (isset($_POST['fax'])) {
                $recipientFax = $_POST['fax'];
            }
            if (isset($_POST['day']) && isset($_POST['month']) && isset($_POST['year'])) {
                $recipientBirthday = str_pad(intval($_POST['day']),2,'0',STR_PAD_LEFT).'-'.str_pad(intval($_POST['month']),2,'0',STR_PAD_LEFT).'-'.intval($_POST['year']);
            }
            if (isset($_POST['language'])) {
                $recipientLanguage = $_POST['language'];
            }
            if (isset($_POST['notes'])) {
                $recipientNotes = $_POST['notes'];
            }

            if (isset($_POST['list'])) {
                foreach ($_POST['list'] as $listId => $status) {
                    if (intval($status) == 1) {
                        array_push($arrAssociatedLists, intval($listId));
                    }
                }
            } elseif (!$recipientId) {
                // Signup request where no recipient list had been selected

                // check if the user didn't select any list or if there is non or just 1 recipient list visible and was therefore not visible for the user to select
                // only show newsletter-lists that are visible for new users (not yet registered ones)
                $excludeDisabledLists = 1;
                $arrLists = self::getLists($excludeDisabledLists);
                switch (count($arrLists)) {
                    case 0:
                        // no active lists > ok
                        break;

                    case 1:
                        // only 1 list is active, therefore no list was visible for selection -> let's signup the new recipient to this very list
                        $arrAssociatedLists = array_keys($arrLists);
                        break;

                    default:
                        // more than one list is active, therefore the user would have been able to select his preferred lists.
                        // however, the fact that we landed in this case is that the user didn't make any selection at all.
                        // so lets be it like that > the user won't be subscribed to any list
                        break;
                }
            }

            if (!$isAccessRecipient) {
                    // add or update existing newsletter recipient (for access user see ELSE case)
                    $arrPreAssociatedInactiveLists = $this->_getAssociatedListsOfRecipient($recipientId, false);
                    $arrAssociatedInactiveLists = array_intersect($arrPreAssociatedInactiveLists, $arrAssociatedLists);

                    $objValidator = new FWValidator();
                    if ($objValidator->isEmail($recipientEmail)) {

                        // Let's check if a user account with the provided email address is already present
                        // Important: we must check only for active accounts (active => 1), otherwise we'll send a notification e-mail
                        //            to a user that won't be able to active himself due to his account's inactive state.
// TODO: implement feature
                        $objUser = null;//FWUser::getFWUserObject()->objUser->getUsers(array('email' => $recipientEmail, 'active' => 1));
                        if (false && $objUser) {
                            // there is already a user account present by the same email address as the one submitted by the user
// TODO: send notification e-mail about existing e-mail account
                            // Important: We must output the same status message as if the user has been newly added!
                            //            This shall prevent email-address-crawling-bots from detecting existing e-mail accounts.
                            array_push($arrStatusMessage['ok'], $_ARRAYLANG['TXT_NEWSLETTER_SUBSCRIBE_OK']);
                            $showForm = false;
                        } else {
                            if ($this->_validateRecipientAttributes($recipientAttributeStatus, $recipientUri, $recipientSex, $recipientSalutation, $recipientTitle, $recipientLastname, $recipientFirstname, $recipientPosition, $recipientCompany, $recipientIndustrySector, $recipientAddress, $recipientZip, $recipientCity, $recipientCountry, $recipientPhoneOffice, $recipientPhonePrivate, $recipientPhoneMobile, $recipientFax, $recipientBirthday)) {
                                if ($this->_isUniqueRecipientEmail($recipientEmail, $recipientId)) {                    
                                    if (!empty($arrAssociatedInactiveLists) || !empty($arrAssociatedLists) && ($objList = $objDatabase->SelectLimit('SELECT id FROM '.DBPREFIX.'module_newsletter_category WHERE status=1 AND (id='.implode(' OR id=', $arrAssociatedLists).')' , 1)) && $objList->RecordCount() > 0) {
                                        if ($recipientId > 0) {
                                            if ($this->_updateRecipient($recipientAttributeStatus, $recipientId, $recipientEmail, $recipientUri, $recipientSex, $recipientSalutation, $recipientTitle, $recipientLastname, $recipientFirstname, $recipientPosition, $recipientCompany, $recipientIndustrySector, $recipientAddress, $recipientZip, $recipientCity, $recipientCountry, $recipientPhoneOffice, $recipientPhonePrivate, $recipientPhoneMobile, $recipientFax, $recipientNotes, $recipientBirthday, 1, $arrAssociatedLists, $recipientLanguage)) {
                                                array_push($arrStatusMessage['ok'], $_ARRAYLANG['TXT_NEWSLETTER_YOUR_DATE_SUCCESSFULLY_UPDATED']);
                                                $showForm = false;
                                            } else {
                                                array_push($arrStatusMessage['error'], $_ARRAYLANG['TXT_NEWSLETTER_FAILED_UPDATE_YOUR_DATA']);
                                            }
                                        } else {
                                            if ($this->_addRecipient($recipientEmail, $recipientUri, $recipientSex, $recipientSalutation, $recipientTitle, $recipientLastname, $recipientFirstname, $recipientPosition, $recipientCompany, $recipientIndustrySector, $recipientAddress, $recipientZip, $recipientCity, $recipientCountry, $recipientPhoneOffice, $recipientPhonePrivate, $recipientPhoneMobile, $recipientFax, $recipientNotes, $recipientBirthday, $recipientStatus, $arrAssociatedLists, $recipientLanguage)) {
                                                if ($this->_sendAuthorizeEmail($recipientEmail, $recipientSex, $recipientSalutation, $recipientFirstname, $recipientLastname)) {
                                                    array_push($arrStatusMessage['ok'], $_ARRAYLANG['TXT_NEWSLETTER_SUBSCRIBE_OK']);
                                                    $showForm = false;
                                                } else {
                                                    $objDatabase->Execute("DELETE tblU, tblR FROM ".DBPREFIX."module_newsletter_user AS tblU, ".DBPREFIX."module_newsletter_rel_user_cat AS tblR WHERE tblU.email='".contrexx_addslashes($recipientEmail)."' AND tblR.user = tblU.id");
                                                    array_push($arrStatusMessage['error'], $_ARRAYLANG['TXT_NEWSLETTER_SUBSCRIPTION_CANCELED_BY_EMAIL']);
                                                }
                                            } else {
                                                array_push($arrStatusMessage['error'], $_ARRAYLANG['TXT_NEWSLETTER_FAILED_ADDING_YOU']);
                                            }
                                        }
                                    } else {
                                        array_push($arrStatusMessage['error'], $_ARRAYLANG['TXT_NEWSLETTER_MUST_SELECT_LIST']);
                                    }                       
                                } elseif (empty($recipientId)) {
                                    // We must send a new confirmation e-mail here
                                    // otherwise someone could reactivate someone else's e-mail address

                                    // It could be that a user who has unsubscribed himself from the newsletter system (recipient = deactivated) would like to subscribe the newsletter again.
                                    // Therefore, lets see if we can find a recipient by the specified e-mail address that has been deactivated (status=0)
                                    $objRecipient      = $objDatabase->SelectLimit("SELECT id, language, notes FROM ".DBPREFIX."module_newsletter_user WHERE email='".contrexx_input2db($recipientEmail)."' AND status=0", 1);
                                    if ($objRecipient && !$objRecipient->EOF) {
                                        $recipientId       = $objRecipient->fields['id'];
                                        $recipientLanguage = $objRecipient->fields['language'];
                                        
                                        // Important: We intentionally do not load existing recipient list associations, due to the fact that the user most likely had
                                        // himself been unsubscribed from the newsletter system some time in the past. Therefore the user most likey does not want
                                        // to be subscribed to any lists more than to those he just selected
                                        $arrAssociatedLists = array_unique($arrAssociatedLists);
                                        $this->_setRecipientLists($recipientId, $arrAssociatedLists);

                                        // Important: We do not update the recipient's profile data here by the reason that we can't verify the recipient's identity at this point!
                                        
                                        if ($this->_sendAuthorizeEmail($recipientEmail, $recipientSex, $recipientSalutation, $recipientFirstname, $recipientLastname)) {
                                            // Important: We must output the same status message as if the user has been newly added!
                                            //            This shall prevent email-address-crawling-bots from detecting existing e-mail accounts.
                                            array_push($arrStatusMessage['ok'], $_ARRAYLANG['TXT_NEWSLETTER_SUBSCRIBE_OK']);
                                            $showForm = false;
                                        } else {
                                            array_push($arrStatusMessage['error'], $_ARRAYLANG['TXT_NEWSLETTER_FAILED_ADDING_YOU']);
                                            array_push($arrStatusMessage['error'], $_ARRAYLANG['TXT_NEWSLETTER_SUBSCRIPTION_CANCELED_BY_EMAIL']);
                                        }
                                    }
                                } else {
                                    array_push($arrStatusMessage['error'], $_ARRAYLANG['TXT_NEWSLETTER_SUBSCRIBER_ALREADY_INSERTED']);
                                }
                            } else {                    
                                array_push($arrStatusMessage['error'], $_ARRAYLANG['TXT_NEWSLETTER_MANDATORY_FIELD_ERROR']);
                            }
                        }
                    } else {
                        array_push($arrStatusMessage['error'], $_ARRAYLANG['TXT_NOT_VALID_EMAIL']);
                    }
            } else {
                // update subscribed lists of access user
                $arrAssociatedLists = array_unique($arrAssociatedLists);
                $objUser->setSubscribedNewsletterListIDs($arrAssociatedLists);
                if ($objUser->store()) {
                    array_push($arrStatusMessage['ok'], $_ARRAYLANG['TXT_NEWSLETTER_YOUR_DATE_SUCCESSFULLY_UPDATED']);
                    $showForm = false;
                } else {
                    $arrStatusMessage['error'] = array_merge($arrStatusMessage['error'], $objUser->getErrorMsg());
                }
            }
        } elseif ($isNewsletterRecipient) {
            $objRecipient = $objDatabase->SelectLimit("SELECT uri, sex, salutation, title, lastname, firstname, position, company, industry_sector, address, zip, city, country_id, phone_office, phone_private, phone_mobile, fax, notes, birthday, status, language FROM ".DBPREFIX."module_newsletter_user WHERE id=".$recipientId, 1);
            if ($objRecipient !== false && $objRecipient->RecordCount() == 1) {
                $recipientEmail = urldecode($_REQUEST['mail']);
                $recipientUri = $objRecipient->fields['uri'];
                $recipientSex = $objRecipient->fields['sex'];
                $recipientSalutation = $objRecipient->fields['salutation'];
                $recipientTitle = $objRecipient->fields['title'];
                $recipientLastname = $objRecipient->fields['lastname'];
                $recipientFirstname = $objRecipient->fields['firstname'];
                $recipientPosition = $objRecipient->fields['position'];
                $recipientCompany = $objRecipient->fields['company'];
                $recipientIndustrySector = $objRecipient->fields['industry_sector'];
                $recipientAddress = $objRecipient->fields['address'];
                $recipientZip = $objRecipient->fields['zip'];
                $recipientCity = $objRecipient->fields['city'];
                $recipientCountry = $objRecipient->fields['country_id'];
                $recipientPhoneOffice = $objRecipient->fields['phone_office'];
                $recipientPhonePrivate = $objRecipient->fields['phone_private'];
                $recipientPhoneMobile = $objRecipient->fields['phone_mobile'];
                $recipientFax = $objRecipient->fields['fax'];
                $recipientBirthday = $objRecipient->fields['birthday'];
                $recipientLanguage = $objRecipient->fields['language'];
                $recipientNotes = $objRecipient->fields['notes'];

                $arrAssociatedLists = $this->_getAssociatedListsOfRecipient($recipientId, false);
                $arrPreAssociatedInactiveLists = $this->_getAssociatedListsOfRecipient($recipientId, false);
            } else {
                array_push($arrStatusMessage['error'], $_ARRAYLANG['TXT_NEWSLETTER_AUTHENTICATION_FAILED']);
                $showForm = false;
            }
        } elseif ($isAccessRecipient) {
            $objUser = FWUser::getFWUserObject()->objUser->getUser($recipientId);
            if ($objUser) {
                $arrAssociatedLists = $objUser->getSubscribedNewsletterListIDs();
                $arrPreAssociatedInactiveLists = $objUser->getSubscribedNewsletterListIDs();
            }
        }

        $this->_createDatesDropdown($recipientBirthday);

        if (count($arrStatusMessage['ok']) > 0) {
            $this->_objTpl->setVariable('NEWSLETTER_OK_MESSAGE', implode('<br />', $arrStatusMessage['ok']));
            $this->_objTpl->parse('newsletter_ok_message');
        } else {
            $this->_objTpl->hideBlock('newsletter_ok_message');
        }
        if (count($arrStatusMessage['error']) > 0) {
            $this->_objTpl->setVariable('NEWSLETTER_ERROR_MESSAGE', implode('<br />', $arrStatusMessage['error']));
            $this->_objTpl->parse('newsletter_error_message');
        } else {
            $this->_objTpl->hideBlock('newsletter_error_message');
        }

        $languages = '<select name="language" class="selectLanguage" id="language" >';
        $objLanguage = $objDatabase->Execute("SELECT id, name FROM ".DBPREFIX."languages WHERE frontend = 1 ORDER BY name");
        $languages .= '<option value="0">'.$_ARRAYLANG['TXT_NEWSLETTER_LANGUAGE_PLEASE_CHOSE'].'</option>';
        while (!$objLanguage->EOF) {
            $selected = ($objLanguage->fields['id'] == $recipientLanguage) ? 'selected' : '';
            $languages .= '<option value="'.$objLanguage->fields['id'].'" '.$selected.'>'.contrexx_raw2xhtml($objLanguage->fields['name']).'</option>';
            $objLanguage->MoveNext();
        }
        $languages .= '</select>';

        if ($showForm) {
            if ($isAccessRecipient) {
                if ($this->_objTpl->blockExists('recipient_profile')) {
                    $this->_objTpl->hideBlock('recipient_profile');
                }
            } else {
                //display settings recipient profile detials
                $recipientAttributesArray = array(
                    'recipient_sex',
                    'recipient_salutation',
                    'recipient_title',
                    'recipient_firstname',
                    'recipient_lastname',            
                    'recipient_position',            
                    'recipient_company',
                    'recipient_industry',
                    'recipient_address',
                    'recipient_city',
                    'recipient_zip',
                    'recipient_country',
                    'recipient_phone',
                    'recipient_private',
                    'recipient_mobile',
                    'recipient_fax',
                    'recipient_birthday',
                    'recipient_website'
                );
                foreach ($recipientAttributesArray as $attribute) {
                    if ($this->_objTpl->blockExists($attribute)) {
                        if ($recipientAttributeStatus[$attribute]['active']) {
                            $this->_objTpl->touchBlock($attribute);
                            $this->_objTpl->setVariable(array(
                                'NEWSLETTER_'.strtoupper($attribute).'_MANDATORY' => ($recipientAttributeStatus[$attribute]['required']) ? '*' : '',
                            ));
                        } else {
                            $this->_objTpl->hideBlock($attribute);
                        }
                    }
                }

                $this->_objTpl->setVariable(array(
                    'NEWSLETTER_EMAIL'        => htmlentities($recipientEmail, ENT_QUOTES, CONTREXX_CHARSET),
                    'NEWSLETTER_WEBSITE'          => htmlentities($recipientUri, ENT_QUOTES, CONTREXX_CHARSET),
                    'NEWSLETTER_SEX_F'        => $recipientSex == 'f' ? 'checked="checked"' : '',
                    'NEWSLETTER_SEX_M'        => $recipientSex == 'm' ? 'checked="checked"' : '',                
                    'NEWSLETTER_SALUTATION'        => $this->_getRecipientTitleMenu($recipientSalutation, 'name="salutation" size="1"'),
                    'NEWSLETTER_TITLE'    => htmlentities($recipientTitle, ENT_QUOTES, CONTREXX_CHARSET),
                    'NEWSLETTER_LASTNAME'    => htmlentities($recipientLastname, ENT_QUOTES, CONTREXX_CHARSET),
                    'NEWSLETTER_FIRSTNAME'    => htmlentities($recipientFirstname, ENT_QUOTES, CONTREXX_CHARSET),
                    'NEWSLETTER_POSITION'    => htmlentities($recipientPosition, ENT_QUOTES, CONTREXX_CHARSET),
                    'NEWSLETTER_COMPANY'    => htmlentities($recipientCompany, ENT_QUOTES, CONTREXX_CHARSET),
                    'NEWSLETTER_INDUSTRY_SECTOR'    => htmlentities($recipientIndustrySector, ENT_QUOTES, CONTREXX_CHARSET),
                    'NEWSLETTER_ADDRESS'        => htmlentities($recipientAddress, ENT_QUOTES, CONTREXX_CHARSET),
                    'NEWSLETTER_ZIP'        => htmlentities($recipientZip, ENT_QUOTES, CONTREXX_CHARSET),
                    'NEWSLETTER_CITY'        => htmlentities($recipientCity, ENT_QUOTES, CONTREXX_CHARSET),
                    'NEWSLETTER_COUNTRY'    => $this->getCountryMenu($recipientCountry, ($recipientAttributeStatus['recipient_country']['active']  && $recipientAttributeStatus['recipient_country']['required'])),
                    'NEWSLETTER_PHONE'        => htmlentities($recipientPhoneOffice, ENT_QUOTES, CONTREXX_CHARSET),
                    'NEWSLETTER_PHONE_PRIVATE'        => htmlentities($recipientPhonePrivate, ENT_QUOTES, CONTREXX_CHARSET),
                    'NEWSLETTER_PHONE_MOBILE'        => htmlentities($recipientPhoneMobile, ENT_QUOTES, CONTREXX_CHARSET),
                    'NEWSLETTER_FAX'        => htmlentities($recipientFax, ENT_QUOTES, CONTREXX_CHARSET),
                    'NEWSLETTER_NOTES'        => htmlentities($recipientNotes, ENT_QUOTES, CONTREXX_CHARSET),
                    'NEWSLETTER_LANGUAGE'     => $languages
                ));

                $this->_objTpl->setVariable(array(
                    'TXT_NEWSLETTER_EMAIL_ADDRESS'    => $_ARRAYLANG['TXT_NEWSLETTER_EMAIL_ADDRESS'],
                    'TXT_NEWSLETTER_SALUTATION'     => $_ARRAYLANG['TXT_NEWSLETTER_SALUTATION'],
                    'TXT_NEWSLETTER_SEX'            => $_ARRAYLANG['TXT_NEWSLETTER_SEX'],
                    'TXT_NEWSLETTER_FEMALE'            => $_ARRAYLANG['TXT_NEWSLETTER_FEMALE'],
                    'TXT_NEWSLETTER_MALE'            => $_ARRAYLANG['TXT_NEWSLETTER_MALE'],
                    'TXT_NEWSLETTER_TITLE'        => $_ARRAYLANG['TXT_NEWSLETTER_TITLE'],
                    'TXT_NEWSLETTER_LASTNAME'        => $_ARRAYLANG['TXT_NEWSLETTER_LASTNAME'],
                    'TXT_NEWSLETTER_FIRSTNAME'        => $_ARRAYLANG['TXT_NEWSLETTER_FIRSTNAME'],
                    'TXT_NEWSLETTER_POSITION'        => $_ARRAYLANG['TXT_NEWSLETTER_POSITION'],
                    'TXT_NEWSLETTER_COMPANY'        => $_ARRAYLANG['TXT_NEWSLETTER_COMPANY'],
                    'TXT_NEWSLETTER_INDUSTRY_SECTOR'        => $_ARRAYLANG['TXT_NEWSLETTER_INDUSTRY_SECTOR'],
                    'TXT_NEWSLETTER_ADDRESS'            => $_ARRAYLANG['TXT_NEWSLETTER_ADDRESS'],
                    'TXT_NEWSLETTER_ZIP'            => $_ARRAYLANG['TXT_NEWSLETTER_ZIP'],
                    'TXT_NEWSLETTER_CITY'            => $_ARRAYLANG['TXT_NEWSLETTER_CITY'],
                    'TXT_NEWSLETTER_COUNTRY'        => $_ARRAYLANG['TXT_NEWSLETTER_COUNTRY'],
                    'TXT_NEWSLETTER_PHONE_PRIVATE'            => $_ARRAYLANG['TXT_NEWSLETTER_PHONE_PRIVATE'],
                    'TXT_NEWSLETTER_PHONE_MOBILE'            => $_ARRAYLANG['TXT_NEWSLETTER_PHONE_MOBILE'],
                    'TXT_NEWSLETTER_FAX'            => $_ARRAYLANG['TXT_NEWSLETTER_FAX'],
                    'TXT_NEWSLETTER_PHONE'            => $_ARRAYLANG['TXT_NEWSLETTER_PHONE'],
                    'TXT_NEWSLETTER_NOTES'            => $_ARRAYLANG['TXT_NEWSLETTER_NOTES'],
                    'TXT_NEWSLETTER_BIRTHDAY'        => $_ARRAYLANG['TXT_NEWSLETTER_BIRTHDAY'],
                    'TXT_NEWSLETTER_LANGUAGE'      => $_ARRAYLANG['TXT_NEWSLETTER_LANGUAGE'],
                    'TXT_NEWSLETTER_WEBSITE'        => $_ARRAYLANG['TXT_NEWSLETTER_WEBSITE'],
                    'TXT_NEWSLETTER_RECIPIENT_DATE' => $_ARRAYLANG['TXT_NEWSLETTER_RECIPIENT_DATE'],
                    'TXT_NEWSLETTER_RECIPIENT_MONTH'=> $_ARRAYLANG['TXT_NEWSLETTER_RECIPIENT_MONTH'],
                    'TXT_NEWSLETTER_RECIPIENT_YEAR' => $_ARRAYLANG['TXT_NEWSLETTER_RECIPIENT_YEAR'],                
                ));

                if ($this->_objTpl->blockExists('recipient_profile')) {
                    $this->_objTpl->parse('recipient_profile');
                }
            }

            // only show newsletter-lists that are visible for new users (not yet registered ones)
            $excludeDisabledLists = $recipientId == 0;
            $arrLists = self::getLists($excludeDisabledLists);
            if ($this->_objTpl->blockExists('newsletter_lists')) {
                switch (count($arrLists)) {
                    case 0:
                        // no lists are active, therefore we shall not try to parse any non existing list
                    case 1:
                        // only one list is active, therefore we will not parse any list and will automatically subscribe the user to this very list
                        if (!$isAccessRecipient) {
                            $this->_objTpl->hideBlock('newsletter_lists');
                            break;
                        }

                    default:
                        foreach ($arrLists as $listId => $arrList) {
                            if ($arrList['status'] || in_array($listId, $arrPreAssociatedInactiveLists)) {
                                $this->_objTpl->setVariable(array(
                                    'NEWSLETTER_LIST_ID'        => $listId,
                                    'NEWSLETTER_LIST_NAME'      => contrexx_raw2xhtml($arrList['name']),
                                    'NEWSLETTER_LIST_SELECTED'  => in_array($listId, $arrAssociatedLists) ? 'checked="checked"' : ''
                                ));
                                $this->_objTpl->parse('newsletter_list');
                            }
                        }

                        $this->_objTpl->setVariable(array(
                            'TXT_NEWSLETTER_LISTS'             => $_ARRAYLANG['TXT_NEWSLETTER_LISTS'],
                        ));
                        $this->_objTpl->parse('newsletter_lists');
                        break;
                }
            }

            $this->_objTpl->setVariable(array(
                'NEWSLETTER_PROFILE_MAIL' => contrexx_raw2xhtml($requestedMail),
                'NEWSLETTER_USER_CODE'    => $code,
                'TXT_NEWSLETTER_SAVE'     => $_ARRAYLANG['TXT_NEWSLETTER_SAVE'],
            ));

            $this->_objTpl->parse('newsletterForm');
        } else {
            $this->_objTpl->hideBlock('newsletterForm');
        }
    }

// TODO: add validation CODE!!!
    function _sendAuthorizeEmail($recipientEmail, $recipientSex, $recipientTitle, $recipientFirstname, $recipientLastname)
    {
        global $_CONFIG, $_ARRAYLANG, $objDatabase;

        if (!@include_once ASCMS_LIBRARY_PATH.'/phpmailer/class.phpmailer.php') {
            return false;
        }

// TODO: use FWUSER
        $arrRecipientTitles = &$this->_getRecipientTitles();
        $recipientTitleTxt = $arrRecipientTitles[$recipientTitle];

        switch ($recipientSex) {
             case 'm':
                 $recipientSexTxt = $_ARRAYLANG['TXT_NEWSLETTER_MALE'];
                 break;

             case 'f':
                 $recipientSexTxt = $_ARRAYLANG['TXT_NEWSLETTER_FEMALE'];
                 break;

             default:
                 $recipientSexTxt = '';
                 break;
         }

        if (!($objConfirmMail = $objDatabase->SelectLimit("SELECT title, content FROM ".DBPREFIX."module_newsletter_confirm_mail WHERE id='1'", 1)) || $objConfirmMail->RecordCount() == 0) {
            return false;
        }

        $arrParsedTxts = str_replace(
            array('[[sex]]', '[[title]]', '[[firstname]]', '[[lastname]]', '[[code]]', '[[url]]', '[[date]]'),
            array($recipientSexTxt, $recipientTitleTxt, $recipientFirstname, $recipientLastname, ASCMS_PROTOCOL.'://'.$_CONFIG['domainUrl'].CONTREXX_SCRIPT_PATH.'?section=newsletter&cmd=confirm&email='.$recipientEmail, $_CONFIG['domainUrl'], date(ASCMS_DATE_FORMAT)),
            array($objConfirmMail->fields['title'], $objConfirmMail->fields['content'])
        );

        $arrSettings = &$this->_getSettings();

        $objMail = new phpmailer();

        if ($_CONFIG['coreSmtpServer'] > 0 && @include_once ASCMS_CORE_PATH.'/SmtpSettings.class.php') {
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
        $objMail->From = $arrSettings['sender_mail']['setvalue'];
        $objMail->FromName = $arrSettings['sender_name']['setvalue'];
        $objMail->AddReplyTo($arrSettings['reply_mail']['setvalue']);
        $objMail->Subject = $arrParsedTxts[0];
        $objMail->Priority = 3;
        $objMail->IsHTML(false);
        $objMail->Body = $arrParsedTxts[1];
        $objMail->AddAddress($recipientEmail);
        if ($objMail->Send()) {
            return true;
        } else {
            return false;
        }
    }

    function _sendNotificationEmail($action, $recipientId)
    {
        global $_CONFIG, $_ARRAYLANG, $objDatabase;
        //action: 1 = subscribe | 2 = unsubscribe

        $objSettings = $objDatabase->Execute("SELECT `setname`, `setvalue` FROM `".DBPREFIX."module_newsletter_settings` WHERE `setname` = 'notificationSubscribe' OR  `setname` = 'notificationUnsubscribe' ");
        if ($objSettings !== false) {
            while (!$objSettings->EOF) {
                $arrSettings[$objSettings->fields['setname']] = $objSettings->fields['setvalue'];
                $objSettings->MoveNext();
            }
        }

        if (   ($arrSettings['notificationSubscribe'] == 1 && $action == 1)
            || ($arrSettings['notificationUnsubscribe'] == 1 && $action == 2)) {

            if (!@include_once ASCMS_LIBRARY_PATH.'/phpmailer/class.phpmailer.php') {
                return false;
            }
            $objRecipient = $objDatabase->SelectLimit("SELECT sex, salutation, lastname, firstname, email FROM ".DBPREFIX."module_newsletter_user WHERE id=".$recipientId, 1);
            if ($objRecipient !== false) {
                $arrRecipient['sex'] = $objRecipient->fields['sex'];
                $arrRecipient['salutation'] = $objRecipient->fields['salutation'];
                $arrRecipient['lastname'] = $objRecipient->fields['lastname'];
                $arrRecipient['firstname'] = $objRecipient->fields['firstname'];
                $arrRecipient['email'] = $objRecipient->fields['email'];
            }

            $objRecipientTitle = $objDatabase->SelectLimit("SELECT title FROM ".DBPREFIX."module_newsletter_user_title WHERE id=".$arrRecipient['salutation'], 1);
            if ($objRecipientTitle !== false) {
                $arrRecipientTitle = $objRecipientTitle->fields['title'];
            }

            $objNotificationMail = $objDatabase->SelectLimit("SELECT title, content, recipients FROM ".DBPREFIX."module_newsletter_confirm_mail WHERE id='3'", 1);

            if($action == 1) {
                $txtAction = $_ARRAYLANG['TXT_NEWSLETTER_NOTIFICATION_SUBSCRIBE'];
            } else {
                $txtAction = $_ARRAYLANG['TXT_NEWSLETTER_NOTIFICATION_UNSUBSCRIBE'];
                $objNotificationAdressesFromLists = $objDatabase->Execute('SELECT notification_email FROM '.DBPREFIX.'module_newsletter_category AS c 
                                                                        INNER JOIN '.DBPREFIX.'module_newsletter_rel_user_cat AS r ON r.category = c.id
                                                                        WHERE r.user = '.contrexx_addslashes($recipientId));
                $notifyMails = array();
                if($objNotificationAdressesFromLists !== false) {
                    while(!$objNotificationAdressesFromLists->EOF) {
                        foreach(explode(',', $objNotificationAdressesFromLists->fields['notification_email']) as $mail) {
                            if(!in_array($mail, $notifyMails)) {
                                array_push($notifyMails, trim($mail));
                            }
                        }
                        $objNotificationAdressesFromLists->MoveNext();
                    }
                }
            }

            $arrParsedTxts = str_replace(
                array('[[action]]', '[[url]]', '[[date]]', '[[sex]]', '[[title]]', '[[lastname]]', '[[firstname]]', '[[e-mail]]'),
                array($txtAction, $_CONFIG['domainUrl'], date(ASCMS_DATE_FORMAT), $arrRecipient['sex'], $arrRecipientTitle, $arrRecipient['lastname'], $arrRecipient['firstname'], $arrRecipient['email']),
                array($objNotificationMail->fields['title'], $objNotificationMail->fields['content'])
            );

            $arrRecipients = explode(',', $objNotificationMail->fields['recipients']);

            $arrSettings = &$this->_getSettings();

            $objMail = new phpmailer();

            if ($_CONFIG['coreSmtpServer'] > 0 && @include_once ASCMS_CORE_PATH.'/SmtpSettings.class.php') {
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
            $objMail->From = $arrSettings['sender_mail']['setvalue'];
            $objMail->FromName = $arrSettings['sender_name']['setvalue'];
            $objMail->AddReplyTo($arrSettings['reply_mail']['setvalue']);
            $objMail->Subject = $arrParsedTxts[0];
            $objMail->Priority = 3;
            $objMail->IsHTML(false);
            $objMail->Body = $arrParsedTxts[1];

            foreach ($arrRecipients as $key => $recipientEmail) {
                $objMail->AddAddress($recipientEmail);
            }
            foreach($notifyMails as $mail) {
                $objMail->AddAddress($mail);
            }
            if ($objMail->Send()) {
                return true;
            }
        }
// TODO: This used to return *nothing* when notifications were turned off.
// Probably true should be returned in this case instead.
// -- See the condition way above.
        return false;
    }



    function setBlock(&$code)
    {
        $html = $this->_getHTML();
        $code = str_replace("{NEWSLETTER_BLOCK}", $html, $code);
    }
    
    
    /**
     * displays newsletter contentn in browser
     *
     */
    public static function displayInBrowser()
    {
        global $objDatabase, $_ARRAYLANG, $_CONFIG;

       
        $id    = !empty($_GET['id'])    ? contrexx_input2raw($_GET['id'])    : '';
        $email = !empty($_GET['email']) ? contrexx_input2raw($_GET['email']) : '';
        $code  = !empty($_GET['code'])  ? contrexx_input2raw($_GET['code'])  : '';

        $unsubscribe = '';
        $profile     = '';
        $date        = '';
        
        $sex         = '';
        $salutation  = '';
        $title       = '';
        $firstname   = '';
        $lastname    = '';
        $position    = '';
        $company     = '';
        $industry_sector = '';
        $address     = '';
        $city        = '';
        $zip         = '';
        $country     = '';
        $phoneOffice = '';
        $phoneMobile = '';
        $phonePrivate = '';
        $fax         = '';
        $birthday    = '';
        $website     = '';

        if (!self::checkCode($id, $email, $code)) {
            // unable to verify user, therefore we will not load any user data to prevent leaking any privacy data
            $email = '';
            $code = '';
        }
        
        // Get newsletter content and template.
        $query = '
                SELECT `n`.`content`, `t`.`html`, `n`.`date_sent`
                  FROM `'.DBPREFIX.'module_newsletter` as `n`
            INNER JOIN `'.DBPREFIX.'module_newsletter_template` as `t`
                    ON `n`.`template` = `t`.`id`
                 WHERE `n`.`id` = "'.contrexx_raw2db($id).'"
        ';
        $objResult = $objDatabase->Execute($query);
        
        if ($objResult->RecordCount()) {
            $html    = $objResult->fields['html'];
            $content = $objResult->fields['content'];
            $date    = date(ASCMS_DATE_FORMAT_DATE, $objResult->fields['date_sent']);
        } else {
            // newsletter not found > redirect to homepage
            CSRF::header('Location: '.\Cx\Core\Routing\Url::fromDocumentRoot());
            exit();
        }
        
        // Get user details.
        $query = '
            SELECT `id`, `email`, `uri`, `salutation`, `title`, `position`, `company`, `industry_sector`, `sex`,
                   `lastname`, `firstname`, `address`, `zip`, `city`, `country_id`, 
                   `phone_office`, `phone_mobile`, `phone_private`, `fax`, `birthday`
            FROM `'.DBPREFIX.'module_newsletter_user`
            WHERE `email` = "'.contrexx_raw2db($email).'"
        ';
        $objResult  = $objDatabase->Execute($query);
        
        if ($objResult->RecordCount()) {
            // set recipient sex
            switch ($objResult->fields['sex']) {
                case 'm':
                    $gender = 'gender_male';
                    break;
                case 'f':
                    $gender = 'gender_female';
                    break;
                default:
                    $gender = 'gender_undefined';
                    break;
            }

            $objUser        = FWUser::getFWUserObject()->objUser;
            $userId         = $objResult->fields['id'];
            $sex            = $objUser->objAttribute->getById($gender)->getName();

            //$salutation     = contrexx_raw2xhtml($objUser->objAttribute->getById('title_'.$objResult->fields['salutation'])->getName());
            $objNewsletterLib = new NewsletterLib();
            $arrRecipientTitles = $objNewsletterLib->_getRecipientTitles();
            $salutation     = $arrRecipientTitles[$objResult->fields['salutation']];

            $title          = contrexx_raw2xhtml($objResult->fields['title']);
            $firstname      = contrexx_raw2xhtml($objResult->fields['firstname']);
            $lastname       = contrexx_raw2xhtml($objResult->fields['lastname']);
            $position       = contrexx_raw2xhtml($objResult->fields['position']);
            $company        = contrexx_raw2xhtml($objResult->fields['company']);
            $industry_sector= contrexx_raw2xhtml($objResult->fields['industry_sector']);
            $address        = contrexx_raw2xhtml($objResult->fields['address']);
            $city           = contrexx_raw2xhtml($objResult->fields['city']);
            $zip            = contrexx_raw2xhtml($objResult->fields['zip']);
// TODO: migrate to Country class
            $country        = contrexx_raw2xhtml($objUser->objAttribute->getById('country_'.$objResult->fields['country_id'])->getName());
            $phoneOffice    = contrexx_raw2xhtml($objResult->fields['phone_office']);
            $phoneMobile    = contrexx_raw2xhtml($objResult->fields['phone_mobile']);
            $phonePrivate   = contrexx_raw2xhtml($objResult->fields['phone_private']);
            $fax            = contrexx_raw2xhtml($objResult->fields['fax']);
            $website        = contrexx_raw2xhtml($objResult->fields['uri']);
            $birthday       = contrexx_raw2xhtml($objResult->fields['birthday']);

            // unsubscribe and profile links have been removed from browser-view - 12/20/12 TD
            //$unsubscribe        = '<a href="'.\Cx\Core\Routing\Url::fromModuleAndCmd('newsletter', 'unsubscribe', '', array('code' => $code, 'mail' => $email)).'">'.$_ARRAYLANG['TXT_UNSUBSCRIBE'].'</a>';
            //$profile            = '<a href="'.\Cx\Core\Routing\Url::fromModuleAndCmd('newsletter', 'profile', '', array('code' => $code, 'mail' => $email)).'">'.$_ARRAYLANG['TXT_EDIT_PROFILE'].'</a>';
        } elseif ($objUser = FWUser::getFWUserObject()->objUser->getUsers(array('email' => contrexx_raw2db($email), 'active' => 1), null, null, null, 1)) {
            $sex            = $objUser->objAttribute->getById($objUser->getProfileAttribute('gender'))->getName();
            $salutation     = contrexx_raw2xhtml($objUser->objAttribute->getById('title_'.$objUser->getProfileAttribute('title'))->getName());
            $firstname      = contrexx_raw2xhtml($objUser->getProfileAttribute('firstname'));
            $lastname       = contrexx_raw2xhtml($objUser->getProfileAttribute('lastname'));
            $company        = contrexx_raw2xhtml($objUser->getProfileAttribute('company'));
            $address        = contrexx_raw2xhtml($objUser->getProfileAttribute('address'));
            $city           = contrexx_raw2xhtml($objUser->getProfileAttribute('city'));
            $zip            = contrexx_raw2xhtml($objUser->getProfileAttribute('zip'));
// TODO: migrate to Country class
            $country        = contrexx_raw2xhtml($objUser->objAttribute->getById('country_'.$objUser->getProfileAttribute('country'))->getName());
            $phoneOffice    = contrexx_raw2xhtml($objUser->getProfileAttribute('phone_office'));
            $phoneMobile    = contrexx_raw2xhtml($objUser->getProfileAttribute('phone_mobile'));
            $phonePrivate   = contrexx_raw2xhtml($objUser->getProfileAttribute('phone_private'));
            $fax            = contrexx_raw2xhtml($objUser->getProfileAttribute('phone_fax'));
            $website        = contrexx_raw2xhtml($objUser->getProfileAttribute('website'));
            $birthday       = date(ASCMS_DATE_FORMAT_DATE, $objUser->getProfileAttribute('birthday'));

            // unsubscribe and profile links have been removed from browser-view - 12/20/12 TD
            //$unsubscribe = '<a href="'.\Cx\Core\Routing\Url::fromModuleAndCmd('newsletter', 'unsubscribe', '', array('code' => $code, 'mail' => $email)).'">'.$_ARRAYLANG['TXT_UNSUBSCRIBE'].'</a>';
            //$profile     = '<a href="'.\Cx\Core\Routing\Url::fromModuleAndCmd('newsletter', 'profile', '', array('code' => $code, 'mail' => $email)).'">'.$_ARRAYLANG['TXT_EDIT_PROFILE'].'</a>';
        } else {
            // no user found by the specified e-mail address, therefore we will unset any profile specific data to prevent leaking any privacy data
            $email  = '';
            $code   = '';
        }
        
        $search = array(
            // meta data
            '[[email]]',
            '[[date]]',
            '[[display_in_browser_url]]',

            // subscription
            // unsubscribe and profile links have been removed from browser-view - 12/20/12 TD
            '[[unsubscribe]]',
            '[[profile_setup]]',

            // profile data
            '[[sex]]',
            '[[salutation]]',
            '[[title]]',
            '[[firstname]]',
            '[[lastname]]',
            '[[position]]',
            '[[company]]',
            '[[industry_sector]]',
            '[[address]]',
            '[[city]]',
            '[[zip]]',
            '[[country]]',
            '[[phone_office]]',
            '[[phone_private]]',
            '[[phone_mobile]]',
            '[[fax]]',
            '[[birthday]]',
            '[[website]]',
        );
        
        $replace = array(
            // meta data
            $email,
            $date,
            ASCMS_PROTOCOL.'://'.$_CONFIG['domainUrl'].ASCMS_PATH_OFFSET.'/'.FWLanguage::getLanguageCodeById(FRONTEND_LANG_ID).'/index.php?section=newsletter&cmd=displayInBrowser&standalone=true&code='.$code.'&email='.$email.'&id='.$id,

            // subscription
            // unsubscribe and profile links have been removed from browser-view - 12/20/12 TD
            // > do empty placeholder
            '',
            '',

            // profile data
            $sex,
            $salutation,
            $title,
            $firstname,
            $lastname,
            $position,
            $company,
            $industry_sector,
            $address,
            $city,
            $zip,
            $country,
            $phoneOffice,
            $phoneMobile,
            $phonePrivate,
            $fax,
            $birthday,
            $website,
        );
        
        // Replaces the placeholder in the template and content.
        $html    = str_replace($search, $replace, $html);
        $content = str_replace($search, $replace, $content);

        // prepare links in content for tracking
        if (is_object($objUser) && $objUser->getId()) {
            $userId = $objUser->getId();
            $realUser = true;
        } else {
            $userId = $userId ? $userId : 0;
            $realUser = false;
        }

        $content = self::prepareNewsletterLinksForSend($id, $content, $userId, $realUser);
        
        // Finally replace content placeholder in the template.
        $html = str_replace('[[content]]', $content, $html);

        // parse node-url placeholders
        \LinkGenerator::parseTemplate($html);
        
        // Output
        die($html);
    }
    
    
    /**
     * checks if given code matches given email adress
     *
     * @param   id       $$id
     * @param   string   $email
     * @param   string   $code
     * @return  boolean
     */
    private static function checkCode($id, $email, $code){
        global $objDatabase;
        
        $query = 'SELECT `code` FROM `'.DBPREFIX.'module_newsletter_tmp_sending` WHERE `newsletter` = '.$id.' AND `email` = "'.$email.'";';
        $objResult = $objDatabase->Execute($query);
        
        if ($objResult !== false) {
            if($objResult->fields['code'] == $code) {
                return true;
            }
        }
        
        return false;
    }
    
    public static function isTrackLink() {
        if (!isset($_GET['n'])) {
            return false;
        }
        if (!isset($_GET['l'])) {
            return false;
        }
        if (!isset($_GET['r']) && !isset($_GET['m'])) {
            return false;
        }
        return true;

// TODO: what is this?
                        $newUrl->setParam('n', $MailId);
                        $newUrl->setParam('l', $linkId);
                        if ($realUser) {
                            $newUrl->setParam('r', $UserId);
                        } else {
                            $newUrl->setParam('m', $UserId);
                        }
    }
    
    /**
     * track link: save feedback to database
     *
     * @return boolean
     */
    public static function trackLink() 
    {
        global $objDatabase;
        
        $recipientId = 0;
        $realUser = true;
        if (isset($_GET['m'])) {
            $recipientId = contrexx_input2raw($_GET['m']);
            $realUser = false;
        } else if (isset($_GET['r'])) {
            $recipientId = contrexx_input2raw($_GET['r']);
        } else {
            return false;
        }
        $emailId = isset($_GET['n']) ? contrexx_input2raw($_GET['n']) : 0;
        $linkId = isset($_GET['l']) ? contrexx_input2raw($_GET['l']) : 0;
        
        if (!empty($recipientId)) {
            // find out recipient type
            if ($realUser) {
                $objUser = FWUser::getFWUserObject()->objUser->getUser(intval($recipientId));
                if ($objUser === false) {
                    return false;
                }
                $recipientId = $objUser->getId();
                $recipientType = self::USER_TYPE_ACCESS;
            } else {
                $objUser = $objDatabase->SelectLimit("SELECT `id` FROM ".DBPREFIX."module_newsletter_user WHERE id='".contrexx_raw2db($recipientId)."'", 1);
                if ($objUser === false || $objUser->RecordCount() != 1) {
                    return false;
                }
                $recipientId = $objUser->fields['id'];
                $recipientType = self::USER_TYPE_NEWSLETTER;
            }
        }
        
        /*
        * Request must be redirected to the newsletter $linkId URL. If the $linkId 
        * can't be looked up in the database (by what reason  so ever), then the request shall be 
        * redirected to the URL provided by the url-modificator s of the request
        */
        $objLink = $objDatabase->SelectLimit("SELECT `url` FROM ".DBPREFIX."module_newsletter_email_link WHERE id=".contrexx_raw2db($linkId)." AND email_id=".contrexx_raw2db($emailId), 1);
        if ($objLink === false || $objLink->RecordCount() != 1) {
            return false;
        }

        $url = $objLink->fields['url'];
        
        \LinkGenerator::parseTemplate($url);
        
        if (!empty($recipientId)) {
            // save feedback for valid user
            $query = "
                INSERT IGNORE INTO ".DBPREFIX."module_newsletter_email_link_feedback (link_id, email_id, recipient_id, recipient_type)
                VALUES (".contrexx_raw2db($linkId).", ".contrexx_raw2db($emailId).", ".contrexx_raw2db($recipientId).", '".contrexx_raw2db($recipientType)."')
            ";
            $objDatabase->Execute($query);
        }
        CSRF::header('Location: '.$url);
        exit;
    }

}

