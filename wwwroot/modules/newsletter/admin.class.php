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
 * Newsletter
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Comvation Development Team <info@comvation.com>
 * @access      public
 * @version     1.0.0
 * @package     contrexx
 * @subpackage  module_newsletter
 * @todo        Edit PHP DocBlocks!
 * @todo        make total mailrecipient count static in newsletter list (act=mails)
 *              (new count field)
 *              check if mail already sent when a user unsubscribes -> adjust count
 */

/**
 * Class newsletter
 *
 * Newsletter module class
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Comvation Development Team <info@comvation.com>
 * @access      public
 * @version     1.0.0
 * @package     contrexx
 * @subpackage  module_newsletter
 */
class newsletter extends NewsletterLib
{
    public $_objTpl;
    public $_pageTitle;
    public static $strErrMessage = '';
    public static $strOkMessage = '';
    public $months = array();
    public $_arrMailPriority = array(
        1 => 'TXT_NEWSLETTER_VERY_HIGH',
        2 => 'TXT_NEWSLETTER_HIGH',
        3 => 'TXT_NEWSLETTER_MEDIUM',
        4 => 'TXT_NEWSLETTER_LOW',
        5 => 'TXT_NEWSLETTER_VERY_LOW'
    );
    public $_stdMailPriority = 3;
    public $_attachmentPath = '/images/attach/';

    private $act = '';

    /**
     * PHP5 constructor
     * @global \Cx\Core\Html\Sigma
     * @global array $_ARRAYLANG
     */
    function __construct()
    {
        global $objTemplate, $_ARRAYLANG;

        $this->_objTpl = new \Cx\Core\Html\Sigma(ASCMS_MODULE_PATH.'/newsletter/template');
        CSRF::add_placeholder($this->_objTpl);
        $this->_objTpl->setErrorHandling(PEAR_ERROR_DIE);

        $this->act = isset($_GET['act']) ? $_GET['act'] : '';

        if (!isset($_REQUEST['standalone'])) {
            $objTemplate->setVariable(
                "CONTENT_NAVIGATION",
                "<a href='index.php?cmd=newsletter&amp;act=mails' class='".(($this->act == '' || $this->act == 'mails') ? 'active' : '')."'>".$_ARRAYLANG['TXT_NEWSLETTER_EMAIL_CAMPAIGNS']."</a>"
                .(Permission::checkAccess(172, 'static', true) ? "<a href='index.php?cmd=newsletter&amp;act=lists' class='".($this->act == 'lists' ? 'active' : '')."'>".$_ARRAYLANG['TXT_NEWSLETTER_LISTS']."</a>" : '')
                .(Permission::checkAccess(174, 'static', true) ? "<a href='index.php?cmd=newsletter&amp;act=users' class='".($this->act == 'users' ? 'active' : '')."'>".$_ARRAYLANG['TXT_NEWSLETTER_RECIPIENTS']."</a>" : '')
                .(Permission::checkAccess(175, 'static', true) ? "<a href='index.php?cmd=newsletter&amp;act=news' class='".($this->act == 'news' ? 'active' : '')."'>".$_ARRAYLANG['TXT_NEWSLETTER_NEWS']."</a>" : '')
                .(Permission::checkAccess(176, 'static', true) ? "<a href='index.php?cmd=newsletter&amp;act=dispatch' class='".(in_array($this->act, array('dispatch', 'templates', 'interface', 'confightml', 'activatemail', 'confirmmail', 'notificationmail', 'system', 'tpledit')) ? 'active' : '')."'>".$_ARRAYLANG['TXT_SETTINGS']."</a>" : ''));
        }
        $months = explode(',', $_ARRAYLANG['TXT_NEWSLETTER_MONTHS_ARRAY']);
        $i = 0;
        foreach ($months as $month) {
            $this->months[++$i] = $month;
        }
    }


    /**
     * Set the backend page
     * @access public
     * @global \Cx\Core\Html\Sigma
     * @global array $_ARRAYLANG
     */
    function getPage()
    {
        global $objTemplate;

        if (!isset($_GET['act'])) {
            $_GET['act'] = '';
        }

        switch ($_GET['act']) {
            case "lists":
                Permission::checkAccess(172, 'static');
                $this->_lists();
                break;
            case "editlist":
                Permission::checkAccess(172, 'static');
                $this->_editList();
                break;
            case "flushList":
                Permission::checkAccess(172, 'static');
                $this->_flushList();
                $this->_lists();
                break;
            case "changeListStatus":
                Permission::checkAccess(172, 'static');
                $this->_changeListStatus();
                $this->_lists();
                break;
            case "deleteList":
                Permission::checkAccess(172, 'static');
                $this->_deleteList();
                $this->_lists();
                break;
            case "gethtml":
                Permission::checkAccess(172, 'static');
                $this->_getListHTML();
                break;
            case "mails":
                Permission::checkAccess(171, 'static');
                $this->_mails();
                break;
            case "deleteMail":
                Permission::checkAccess(171, 'static');
                $this->_deleteMail();
                break;
            case "copyMail":
                Permission::checkAccess(171, 'static');
                $this->_copyMail();
                break;
            case "editMail":
                Permission::checkAccess(171, 'static');
                $this->_editMail();
                break;
            case "sendMail":
                Permission::checkAccess(171, 'static');
                $this->_sendMailPage();
                break;
            case "send":
                Permission::checkAccess(171, 'static');
                $this->_sendMail();
                break;
            case "news":
                Permission::checkAccess(175, 'static');
                $this->_getNewsPage();
                break;
            case "newspreview":
                Permission::checkAccess(175, 'static');
                $this->_getNewsPreviewPage();
                break;
            case "users":
                Permission::checkAccess(174, 'static');
                $this->_users();
                break;
            case "config":
                Permission::checkAccess(176, 'static');
                $this->configOverview();
                break;
            case "system":
                Permission::checkAccess(176, 'static');
                $this->ConfigSystem();
                break;
            case "editusersort":
                Permission::checkAccess(174, 'static');
                $this->edituserSort();
                break;
            case "dispatch":
                Permission::checkAccess(176, 'static');
                $this->ConfigDispatch();
                break;
            case "confightml":
                Permission::checkAccess(176, 'static');
                $this->ConfigHTML();
                break;
            case "interface":
                Permission::checkAccess(176, 'static');
                $this->interfaceSettings();
                break;
            case "templates":
                Permission::checkAccess(176, 'static');
                $this->_templates();
                break;
            case "tpledit":
                Permission::checkAccess(176, 'static');
                $this->_editTemplate();
                break;
            case "tpldel":
                Permission::checkAccess(176, 'static');
                $this->delTemplate();
                $this->_templates();
                break;
            case "confirmmail":
                Permission::checkAccess(176, 'static');
                $this->ConfirmMail();
                break;
            case "notificationmail":
                Permission::checkAccess(176, 'static');
                $this->NotificationMail();
                break;
            case "activatemail":
                Permission::checkAccess(176, 'static');
                $this->ActivateMail();
                break;
            case "update":
                Permission::checkAccess(171, 'static');
                $this->_update();
                break;
            case "deleteInactive":
                Permission::checkAccess(174, 'static');
                $this->_deleteInactiveRecipients();
                $this->_users();
                break;
            case "feedback":
                Permission::checkAccess(171, 'static');
                if (isset($_GET['id'])) {
                    $this->_showEmailFeedbackAnalysis();
                    break;
                } elseif (isset($_GET['link_id'])) {
// TODO: refactor and reactivate these extended statistics
                    /*if (isset($_GET['recipient_id']) && isset($_GET['recipient_type'])) {
                        $this->_showRecipientEmailFeedbackAnalysis();
                    } else {
                        $this->_showLinkFeedbackAnalysis();
                    }*/
                    break;
                }
            default:
                Permission::checkAccess(152, 'static');
                $this->_mails();
                //$this->overview();
                break;
        }

        if (!isset($_REQUEST['standalone'])) {
            $objTemplate->setVariable(array(
                'CONTENT_TITLE' => $this->_pageTitle,
                'CONTENT_OK_MESSAGE' => self::$strOkMessage,
                'CONTENT_STATUS_MESSAGE' => self::$strErrMessage,
                'ADMIN_CONTENT' => $this->_objTpl->get(),
            ));
        } else {
            $this->_objTpl->show();
            exit;
        }
    }

    /**
     * Takes a date in the format dd.mm.yyyy hh:mm and returns it's representation as mktime()-timestamp.
     *
     * @param $value string
     * @return long timestamp
     */
    function dateFromInput($value) {
        if($value === null || $value === '') //not set POST-param passed, return null for the other functions to know this
            return null;
        $arrDate = array();
        if (preg_match('/^([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{1,4})\s*([0-9]{1,2})\:([0-9]{1,2})/', $value, $arrDate)) {
            return mktime(intval($arrDate[4]), intval($arrDate[5]), 0, intval($arrDate[2]), intval($arrDate[1]), intval($arrDate[3]));
        } else {
            return time();
        }
    }

    /**
     * Takes a mktime()-timestamp and formats it as dd.mm.yyyy hh:mm
     *
     * @param $value long timestamp
     * @return string
     */
    function valueFromDate($value = 0, $format = 'd.m.Y H:i:s') {
        if($value === null //user provided no POST
            || $value === '0') //empty date field
            return ''; //make an empty date
        if($value)
            return date($format,$value);
        else
            return date($format);
    }

    /**
     * Takes a mktime()-timestamp and formats it as yyyy-mm-dd hh:mm:00 for insertion in db.
     *
     * @param $value long timestamp
     * @return string
     */
    function dbFromDate($value) {
        if($value !== null) {
            return date('"Y-m-d H:i:00"', $value);
        }
        else {
            return 'DEFAULT';
        }
    }

    /**
     * Display the list administration page
     * @access private
     * @global array $_ARRAYLANG
     * @global ADONewConnection
     */
    function _lists()
    {
        global $_ARRAYLANG, $objDatabase;

        $this->_objTpl->loadTemplateFile('module_newsletter_lists.html');
        $this->_pageTitle = $_ARRAYLANG['TXT_NEWSLETTER_LISTS'];
        $rowNr = 0;

        if (isset($_GET["bulkdelete"])) {
            $error=0;
            if (!empty($_POST['listid'])) {
                foreach ($_POST['listid'] as $listid) {
                    $listid=intval($listid);
                    if (    $objDatabase->Execute("DELETE FROM ".DBPREFIX."module_newsletter_category WHERE id=$listid") !== false) {
                        $objDatabase->Execute("DELETE FROM ".DBPREFIX."module_newsletter_rel_cat_news WHERE category=$listid");
                        $objDatabase->Execute("DELETE FROM ".DBPREFIX."module_newsletter_rel_user_cat WHERE category=$listid");
                        $objDatabase->Execute("DELETE FROM ".DBPREFIX."module_newsletter_access_user WHERE newsletterCategoryID=$listid");
                    } else {
                        $error=1;
                    }
                }
                if ($error) {
                    self::$strErrMessage = $_ARRAYLANG['TXT_DATA_RECORD_DELETE_ERROR'];
                } else {
                    self::$strOkMessage = $_ARRAYLANG['TXT_DATA_RECORD_DELETED_SUCCESSFUL'];
                }
            }
        }

        $arrLists = self::getLists(false, true);

        $this->_objTpl->setVariable(array(
            'TXT_NEWSLETTER_CONFIRM_DELETE_LIST' => $_ARRAYLANG['TXT_NEWSLETTER_CONFIRM_DELETE_LIST'],
            'TXT_NEWSLETTER_CANNOT_UNDO_OPERATION' => $_ARRAYLANG['TXT_NEWSLETTER_CANNOT_UNDO_OPERATION'],
            'TXT_NEWSLETTER_LISTS' => $_ARRAYLANG['TXT_NEWSLETTER_LISTS'],
            'TXT_NEWSLETTER_ID_UC' => $_ARRAYLANG['TXT_NEWSLETTER_ID_UC'],
            'TXT_NEWSLETTER_STATUS' => $_ARRAYLANG['TXT_NEWSLETTER_STATUS'],
            'TXT_NEWSLETTER_NAME' => $_ARRAYLANG['TXT_NEWSLETTER_NAME'],
            'TXT_NEWSLETTER_LAST_EMAIL' => $_ARRAYLANG['TXT_NEWSLETTER_LAST_EMAIL'],
            'TXT_NEWSLETTER_RECIPIENTS' => $_ARRAYLANG['TXT_NEWSLETTER_RECIPIENTS'],
            'TXT_NEWSLETTER_FUNCTIONS' => $_ARRAYLANG['TXT_NEWSLETTER_FUNCTIONS'],
            'TXT_NEWSLETTER_CONFIRM_CHANGE_LIST_STATUS' => $_ARRAYLANG['TXT_NEWSLETTER_CONFIRM_CHANGE_LIST_STATUS'],
            'TXT_NEWSLETTER_ADD_NEW_LIST' => $_ARRAYLANG['TXT_NEWSLETTER_ADD_NEW_LIST'],
            'TXT_EXPORT' => $_ARRAYLANG['TXT_NEWSLETTER_EXPORT'],
            'TXT_NEWSLETTER_CHECK_ALL' => $_ARRAYLANG['TXT_NEWSLETTER_CHECK_ALL'],
            'TXT_NEWSLETTER_UNCHECK_ALL' => $_ARRAYLANG['TXT_NEWSLETTER_UNCHECK_ALL'],
            'TXT_NEWSLETTER_WITH_SELECTED' => $_ARRAYLANG['TXT_NEWSLETTER_WITH_SELECTED'],
            'TXT_NEWSLETTER_DELETE' => $_ARRAYLANG['TXT_NEWSLETTER_DELETE'],
            'TXT_NEWSLETTER_FLUSH' => $_ARRAYLANG['TXT_NEWSLETTER_FLUSH'],
            'TXT_CONFIRM_DELETE_DATA' => $_ARRAYLANG['TXT_CONFIRM_DELETE_DATA'],
            'TXT_NEWSLETTER_CONFIRM_FLUSH_LIST' => $_ARRAYLANG['TXT_NEWSLETTER_CONFIRM_FLUSH_LIST'],
            'TXT_NEWSLETTER_EXPORT_ALL_LISTS' => $_ARRAYLANG['TXT_NEWSLETTER_EXPORT_ALL_LISTS'],
        ));

        $this->_objTpl->setGlobalVariable(array(
            'TXT_NEWSLETTER_MODIFY' => $_ARRAYLANG['TXT_NEWSLETTER_MODIFY'],
            'TXT_NEWSLETTER_DELETE' => $_ARRAYLANG['TXT_NEWSLETTER_DELETE'],
            'TXT_NEWSLETTER_GENERATE_HTML_SOURCE_CODE' => $_ARRAYLANG['TXT_NEWSLETTER_GENERATE_HTML_SOURCE_CODE'],
            'TXT_NEWSLETTER_SHOW_LAST_SENT_EMAIL' => $_ARRAYLANG['TXT_NEWSLETTER_SHOW_LAST_SENT_EMAIL'],
            'TXT_NEWSLETTER_CREATE_NEW_EMAIL' => $_ARRAYLANG['TXT_NEWSLETTER_CREATE_NEW_EMAIL'],
            'TXT_NEWSLETTER_NOTIFY_ON_UNSUBSCRIBE' => $_ARRAYLANG['TXT_NEWSLETTER_NOTIFY_ON_UNSUBSCRIBE'],
        ));

        if (!empty($arrLists)) {
            foreach ($arrLists as $id => $arrList) {
                $this->_objTpl->setVariable(array(
                    'NEWSLETTER_LIST_ID' => $id,
                    'NEWSLETTER_ROW_CLASS' => $rowNr % 2 == 1 ? "row1" : "row2",
                    'NEWSLETTER_LIST_STATUS_IMG' => $arrList['status'] == 1 ? "folder_on.gif" : "folder_off.gif",
                    'NEWSLETTER_LIST_NAME' => contrexx_raw2xhtml($arrList['name']),
                    'NEWSLETTER_LAST_MAIL_ID' => $arrList['mail_id'],
                    'NEWSLETTER_LIST_RECIPIENT' => $arrList['recipients'] > 0 ? '<a href="index.php?cmd=newsletter&amp;act=users&amp;newsletterListId='.$id.'" title="'.
                                                            sprintf($_ARRAYLANG['TXT_NEWSLETTER_SHOW_RECIPIENTS_OF_LIST'], contrexx_raw2xhtml($arrList['name'])).'">'.$arrList['recipients'].'</a>' : '-',
                    'NEWSLETTER_LIST_STATUS_MSG' => $arrList['status'] == 1 ? $_ARRAYLANG['TXT_NEWSLETTER_VISIBLE_STATUS_TXT'] : $_ARRAYLANG['TXT_NEWSLETTER_INVISIBLE_STATUS_TXT'],
                    'NEWSLETTER_NOTIFICATION_EMAIL' => trim($arrList['notification_email']) == '' ? '-' : contrexx_raw2xhtml($arrList['notification_email']),
                ));

                if ($arrList['mail_sent'] > 0) {
                    $this->_objTpl->setVariable('NEWSLETTER_LIST_LAST_MAIL', date(ASCMS_DATE_FORMAT_DATE, $arrList['mail_sent'])." (".contrexx_raw2xhtml($arrList['mail_name']).")");
                    $this->_objTpl->touchBlock('newsletter_list_last_mail');
                    $this->_objTpl->hideBlock('newsletter_list_no_last_mail');
                } else {
                    $this->_objTpl->hideBlock('newsletter_list_last_mail');
                    $this->_objTpl->touchBlock('newsletter_list_no_last_mail');
                }

                $this->_objTpl->parse('newsletter_lists');
                $rowNr++;
            }
        } else {
            $this->_objTpl->hideBlock('newsletter_lists');
            $this->_objTpl->setVariable('TXT_NEWSLETTER_NO_LISTS', $_ARRAYLANG['TXT_NEWSLETTER_NO_LISTS']);
            $this->_objTpl->parse('newsletter_no_lists');
        }
    }


    function _flushList()
    {
        global $objDatabase, $_ARRAYLANG;
        $listID = (!empty($_GET['id'])) ? intval($_GET['id']) : false;
        if ($listID) {
            if ($objDatabase->Execute(
                        "DELETE FROM ".DBPREFIX."module_newsletter_rel_user_cat WHERE category = $listID"
                    ) !== false &&
                $objDatabase->Execute(
                        "DELETE FROM ".DBPREFIX."module_newsletter_access_user WHERE newsletterCategoryID=$listID"
                    ) !== false) {
                self::$strOkMessage = $_ARRAYLANG['TXT_NEWSLETTER_SUCCESSFULLY_FLUSHED'];
            } else {
                self::$strErrMessage = $_ARRAYLANG['TXT_DATA_RECORD_DELETE_ERROR'];
            }
        } else {
            self::$strErrMessage = $_ARRAYLANG['TXT_NEWSLETTER_NO_ID_SPECIFIED'];
        }
    }


    function _deleteList()
    {
        global $objDatabase, $_ARRAYLANG;
        $listId = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($listId > 0) {
            if (($arrList = $this->_getList($listId)) !== false) {
                $objDatabase->Execute("DELETE FROM ".DBPREFIX."module_newsletter_rel_cat_news WHERE category=".$listId);
                $objDatabase->Execute("DELETE FROM ".DBPREFIX."module_newsletter_rel_user_cat WHERE category=".$listId);
                $objDatabase->Execute("DELETE FROM ".DBPREFIX."module_newsletter_access_user WHERE newsletterCategoryID=$listId");

                if ($objDatabase->Execute("DELETE FROM ".DBPREFIX."module_newsletter_category WHERE id=".$listId) !== false) {
                    self::$strOkMessage .= sprintf($_ARRAYLANG['TXT_NEWSLETTER_LIST_SUCCESSFULLY_DELETED'], $arrList['name']);
                } else {
                    self::$strErrMessage .= sprintf($_ARRAYLANG['TXT_NEWSLETTER_COULD_NOT_DELETE_LIST'], $arrList['name']);
                }
            }
        }
    }


    function _getList($listId)
    {
        global $objDatabase;

        $objList = $objDatabase->SelectLimit("SELECT `status`, `name`, `notification_email` FROM ".DBPREFIX."module_newsletter_category WHERE id=".$listId, 1);
        if ($objList !== false && $objList->RecordCount() == 1) {
            return array(
                'status' => $objList->fields['status'],
                'name' => $objList->fields['name'],
                'notification_email' => $objList->fields['notification_email'],
            );
        }
        return false;
    }


    function _changeListStatus()
    {
        global $objDatabase;

        $listId = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($listId > 0) {
            if (($arrList = $this->_getList($listId)) !== false) {
                $objDatabase->Execute("UPDATE ".DBPREFIX."module_newsletter_category SET `status`=".($arrList['status'] == 1 ? "0" : "1")." WHERE id=".$listId);
            }
        }
    }


    function _editList()
    {
        global $_ARRAYLANG;

        $listId = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;

        if (isset($_POST['save'])) {
            $listName = isset($_POST['newsletter_list_name']) ? contrexx_addslashes($_POST['newsletter_list_name']) : '';
            $listStatus = (isset($_POST['newsletter_list_status']) && intval($_POST['newsletter_list_status']) == '1') ? intval($_POST['newsletter_list_status']) : 0;
            $notificationMail = isset($_POST['newsletter_notification_mail']) ? contrexx_addslashes($_POST['newsletter_notification_mail']) : '';
            if (!empty($listName)) {
                if ($this->_checkUniqueListName($listId, $listName) !== false) {
                    if ($listId == 0) {
                        if ($this->_addList($listName, $listStatus, $notificationMail) !== false) {
                            self::$strOkMessage .= sprintf($_ARRAYLANG['TXT_NEWSLETTER_LIST_SUCCESSFULLY_CREATED'], $listName);
                            return $this->_lists();
                        } else {
                            self::$strErrMessage .= sprintf($_ARRAYLANG['TXT_NEWSLETTER_COULD_NOT_CREATE_LIST'], $listName);
                        }
                    } else {
                        if ($this->_updateList($listId, $listName, $listStatus, $notificationMail) !== false) {
                            self::$strOkMessage .= sprintf($_ARRAYLANG['TXT_NEWSLETTER_LIST_SUCCESSFULLY_UPDATED'], $listName);
                            return $this->_lists();
                        } else {
                            self::$strErrMessage .= sprintf($_ARRAYLANG['TXT_NEWSLETTER_COULD_NOT_UPDATE_LIST'], $listName);
                        }
                    }
                } else {
                    self::$strErrMessage .= $_ARRAYLANG['TXT_NEWSLETTER_DUPLICATE_LIST_NAME_MSG'];
                }
            } else {
                self::$strErrMessage .= $_ARRAYLANG['TXT_NEWSLETTER_DEFINE_LIST_NAME_MSG'];
            }
        } elseif ($listId > 0 && ($arrList = $this->_getList($listId)) !== false) {
            $listName = $arrList['name'];
            $listStatus = $arrList['status'];
            $notificationMail = $arrList['notification_email'];
        } else {
            $listName = isset($_POST['newsletter_list_name']) ? contrexx_addslashes($_POST['newsletter_list_name']) : '';
            $listStatus = (isset($_POST['newsletter_list_status']) && intval($_POST['newsletter_list_status']) == '1') ? intval($_POST['newsletter_list_status']) : 0;
            $notificationMail = isset($_POST['newsletter_notification_mail']) ? contrexx_addslashes($_POST['newsletter_notification_mail']) : '';
        }

        $this->_objTpl->loadTemplateFile('module_newsletter_list_edit.html');
        $this->_pageTitle = $listId > 0 ? $_ARRAYLANG['TXT_NEWSLETTER_MODIFY_LIST'] : $_ARRAYLANG['TXT_NEWSLETTER_ADD_NEW_LIST'];

        $this->_objTpl->setVariable(array(
            'TXT_NEWSLETTER_NAME' => $_ARRAYLANG['TXT_NEWSLETTER_NAME'],
            'TXT_NEWSLETTER_STATUS' => $_ARRAYLANG['TXT_NEWSLETTER_STATUS'],
            'TXT_NEWSLETTER_VISIBLE' => $_ARRAYLANG['TXT_NEWSLETTER_VISIBLE'],
            'TXT_NEWSLETTER_NOTIFICATION_SEND_BY_UNSUBSCRIBE' => $_ARRAYLANG['TXT_NEWSLETTER_NOTIFICATION_SEND_BY_UNSUBSCRIBE'],
            'TXT_NEWSLETTER_SEPARATE_MULTIPLE_VALUES_BY_COMMA' => $_ARRAYLANG['TXT_CORE_MAILTEMPLATE_NOTE_TO'],
            'TXT_ACTIVE' => $_ARRAYLANG['TXT_ACTIVE'],
            'TXT_NEWSLETTER_BACK' => $_ARRAYLANG['TXT_NEWSLETTER_BACK'],
            'TXT_NEWSLETTER_SAVE' => $_ARRAYLANG['TXT_NEWSLETTER_SAVE'],
            'TXT_NEWSLETTER_NOTIFY_ON_UNSUBSCRIBE' => $_ARRAYLANG['TXT_NEWSLETTER_NOTIFY_ON_UNSUBSCRIBE'],
        ));

        $this->_objTpl->setVariable(array(
            'NEWSLETTER_LIST_TITLE' => $listId > 0 ? $_ARRAYLANG['TXT_NEWSLETTER_MODIFY_LIST'] : $_ARRAYLANG['TXT_NEWSLETTER_ADD_NEW_LIST'],
            'NEWSLETTER_LIST_ID' => $listId,
            'NEWSLETTER_LIST_NAME' => htmlentities($listName, ENT_QUOTES, CONTREXX_CHARSET),
            'NEWSLETTER_LIST_STATUS' => $listStatus == 1 ? 'checked="checked"' : '',
            'NEWSLETTER_NOTIFICATION_MAIL' => $notificationMail,
        ));
        return true;
    }


    function _updateList($listId, $listName, $listStatus, $notificationMail)
    {
        global $objDatabase;

        if ($objDatabase->Execute("
            UPDATE ".DBPREFIX."module_newsletter_category
               SET `name`='$listName',
                   `status`=$listStatus,
                   `notification_email`='$notificationMail'
             WHERE id=".intval($listId))) {
            return true;
        }
        return false;
    }


/**
 * Moved to NewsletterLib.class.php
 */
//function _addList($listName, $listStatus)


    function _editMail($copy = false)
    {
        global $objDatabase, $_ARRAYLANG, $_CONFIG;

        $mailId = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
        $arrAttachment = array();
        $attachmentNr = 0;
        $arrAssociatedLists = array();
        $arrAssociatedGroups = array();
        $status = true;

        $mailSubject = isset($_POST['newsletter_mail_subject']) ? contrexx_stripslashes($_POST['newsletter_mail_subject']) : '';

        $objMailSentDate = $objDatabase->Execute("SELECT `date_sent` FROM ".DBPREFIX."module_newsletter WHERE id=".$mailId);
        $mailSendDate    = ($objMailSentDate) ? $objMailSentDate->fields['date_sent'] : 0;

        $arrTemplates = $this->_getTemplates();
        $mailTemplate = isset($_POST['newsletter_mail_template']) ? intval($_POST['newsletter_mail_template']) : key($arrTemplates);
		if (isset($_POST['newsletter_import_template']))
			$importTemplate = intval($_POST['newsletter_import_template']);

        if (isset($_POST['newsletter_mail_html_content'])) {
            $mailHtmlContent = $this->_getBodyContent(contrexx_input2raw($_POST['newsletter_mail_html_content']));
        } elseif (isset($_POST['selected'])) {
			$selectedNews = contrexx_input2db($_POST['selected']);
			$HTML_TemplateSource_Import = $this->_getBodyContent($this->_prepareNewsPreview($this->GetTemplateSource($importTemplate, 'html')));
			$_REQUEST['standalone'] = true;

			$this->_impTpl = new \Cx\Core\Html\Sigma();
			CSRF::add_placeholder($this->_impTpl);
			$this->_impTpl->setTemplate($HTML_TemplateSource_Import);

            $query = '  SELECT  n.id                AS newsid,
                                n.userid            AS newsuid,
                                n.date              AS newsdate,
                                n.teaser_image_path,
                                n.teaser_image_thumbnail_path,
                                n.redirect,
                                n.publisher,
                                n.publisher_id,
                                n.author,
                                n.author_id,
                                n.catid,
                                nl.title            AS newstitle,
                                nl.text             AS newscontent,
                                nl.teaser_text,
                                nc.name             AS name
                    FROM        '.DBPREFIX.'module_news AS n
                    INNER JOIN  '.DBPREFIX.'module_news_locale AS nl ON nl.news_id = n.id
                    INNER JOIN  '.DBPREFIX.'module_news_categories_locale AS nc ON nc.category_id=n.catid
                    WHERE       status = 1
                                AND nl.is_active=1
                                AND nl.lang_id='.FRONTEND_LANG_ID.'
                                AND nc.lang_id='.FRONTEND_LANG_ID.'
                                AND n.id IN ('.$selectedNews.')
                    ORDER BY nc.name ASC, n.date DESC';

			$objFWUser = FWUser::getFWUserObject();

			$objNews = $objDatabase->Execute($query);
			$current_category = '';
			if($this->_impTpl->blockExists('news_list')) {
				if ($objNews !== false) {
					while (!$objNews->EOF) {
						$this->_impTpl->setVariable(array(
							'NEWS_CATEGORY_NAME' => $objNews->fields['name']
						));
						if($current_category == $objNews->fields['catid'])
							$this->_impTpl->hideBlock("news_category");
						$current_category = $objNews->fields['catid'];
                        $newsid         = $objNews->fields['newsid'];
                        $newstitle      = $objNews->fields['newstitle'];
                        $newsUrl        = empty($objNews->fields['redirect'])
                                            ? (empty($objNews->fields['newscontent'])
                                                ? ''
                                                : 'index.php?section=news&cmd=details&newsid='.$newsid)
                                            : $objNews->fields['redirect'];
						$newstext = ltrim(strip_tags($objNews->fields['newscontent']));
						$newsteasertext = ltrim(strip_tags($objNews->fields['teaser_text']));
						$newslink = "[[" . \Cx\Core\ContentManager\Model\Entity\Page::PLACEHOLDER_PREFIX . "NEWS_DETAILS]]?newsid=" . $newsid;
						if ($objNews->fields['newsuid'] && ($objUser = $objFWUser->objUser->getUser($objNews->fields['newsuid']))) {
							$author = htmlentities($objUser->getUsername(), ENT_QUOTES, CONTREXX_CHARSET);
						} else {
							$author = $_ARRAYLANG['TXT_ANONYMOUS'];
						}
                        list($image, $htmlLinkImage, $imageSource) = newsLibrary::parseImageThumbnail($objNews->fields['teaser_image_path'],
                                                                                               $objNews->fields['teaser_image_thumbnail_path'],
                                                                                               $newstitle,
                                                                                               $newsUrl);
						$this->_impTpl->setVariable(array(
							'NEWS_CATEGORY_NAME' => $objNews->fields['name'],
							'NEWS_DATE' => date(ASCMS_DATE_FORMAT_DATE, $objNews->fields['newsdate']),
							'NEWS_LONG_DATE' => date(ASCMS_DATE_FORMAT_DATETIME, $objNews->fields['newsdate']),
							'NEWS_TITLE' => contrexx_raw2xhtml($newstitle),
							'NEWS_URL' => $newslink,
							'NEWS_TEASER_TEXT' => $newsteasertext,
							'NEWS_TEXT' => $newstext,
							'NEWS_AUTHOR' => $author,
						));

                        $imageTemplateBlock = "news_image";
                        if (!empty($image)) {
                            $this->_impTpl->setVariable(array(
                                'NEWS_IMAGE'         => $image,
                                'NEWS_IMAGE_SRC'     => contrexx_raw2xhtml($imageSource),
                                'NEWS_IMAGE_ALT'     => contrexx_raw2xhtml($newstitle),
                                'NEWS_IMAGE_LINK'    => $htmlLinkImage,
                            ));

                            if ($this->_impTpl->blockExists($imageTemplateBlock)) {
                                $this->_impTpl->parse($imageTemplateBlock);
                            }
                        } else {
                            if ($this->_impTpl->blockExists($imageTemplateBlock)) {
                                $this->_impTpl->hideBlock($imageTemplateBlock);
                            }
                        }

						$this->_impTpl->parse("news_list");
						$objNews->MoveNext();
					}
				}
				$mailHtmlContent = $this->_impTpl->get();
			}
			else {
				if ($objNews !== false) {
					$mailHtmlContent = '';
					while (!$objNews->EOF) {
						$content = $this->_getBodyContent($this->GetTemplateSource($importTemplate, 'html'));
						$newstext = ltrim(strip_tags($objNews->fields['newscontent']));
						$newsteasertext = ltrim(strip_tags($objNews->fields['teaser_text']));
						$newslink = \Cx\Core\Routing\Url::fromModuleAndCmd(
                            'news', 'details', '',
                            array('newsid' => $objNews->fields['newsid']));
						if ($objNews->fields['newsuid'] && ($objUser = $objFWUser->objUser->getUser($objNews->fields['newsuid']))) {
							$author = htmlentities($objUser->getUsername(), ENT_QUOTES, CONTREXX_CHARSET);
						} else {
							$author = $_ARRAYLANG['TXT_ANONYMOUS'];
						}
						$search = array(
							'[[NEWS_DATE]]',
							'[[NEWS_LONG_DATE]]',
							'[[NEWS_TITLE]]',
							'[[NEWS_URL]]',
							'[[NEWS_IMAGE_PATH]]',
							'[[NEWS_TEASER_TEXT]]',
							'[[NEWS_TEXT]]',
							'[[NEWS_AUTHOR]]',
							'[[NEWS_TYPE_NAME]]',
							'[[NEWS_CATEGORY_NAME]]'
						);
						$replace = array(
							date(ASCMS_DATE_FORMAT_DATE, $objNews->fields['newsdate']),
							date(ASCMS_DATE_FORMAT_DATETIME, $objNews->fields['newsdate']),
							$objNews->fields['newstitle'],
							$newslink,
							htmlentities($objNews->fields['teaser_image_thumbnail_path'], ENT_QUOTES, CONTREXX_CHARSET),
							$newsteasertext,
							$newstext,
							$author,
							$objNews->fields['typename'],
							$objNews->fields['name']
						);
						$content = str_replace($search, $replace, $content);
						if($mailHtmlContent != '')
							$mailHtmlContent .= "<br/>".$content;
						else
							$mailHtmlContent = $content;
						$objNews->MoveNext();
					}
				}
			}
			unset($_REQUEST['standalone']);
		} else {
            $mailHtmlContent = '';
        }

        if (isset($_POST['newsletter_mail_attachment']) && is_array($_POST['newsletter_mail_attachment'])) {
            foreach ($_POST['newsletter_mail_attachment'] as $attachment) {
                array_push($arrAttachment, contrexx_addslashes($attachment));
            }
        }

        if (isset($_POST['newsletter_mail_priority'])) {
            $mailPriority = intval($_POST['newsletter_mail_priority']);
            if ($mailPriority < 1 || $mailPriority > 5) {
                $mailPriority = $this->_stdMailPriority;
            }
        } else {
            $mailPriority = $this->_stdMailPriority;
        }

        if (isset($_POST['newsletter_mail_associated_list'])) {
            foreach ($_POST['newsletter_mail_associated_list'] as $listId => $status) {
                if (intval($status) == 1) {
                    array_push($arrAssociatedLists, intval($listId));
                }
            }
        }

        // get the associated groups from the post variables in case the form was already sent
        if (isset($_POST['newsletter_mail_associated_group'])) {
            foreach ($_POST['newsletter_mail_associated_group']
                        as $groupID => $status) {
                if ($status) {
                    $arrAssociatedGroups[] = intval($groupID);
                }
            }
        }

        $arrSettings = $this->_getSettings();
        $mailSenderMail = isset($_POST['newsletter_mail_sender_mail']) ? contrexx_stripslashes($_POST['newsletter_mail_sender_mail']) : $arrSettings['sender_mail']['setvalue'];
        $mailSenderName = isset($_POST['newsletter_mail_sender_name']) ? contrexx_stripslashes($_POST['newsletter_mail_sender_name']) : $arrSettings['sender_name']['setvalue'];
        $mailReply = isset($_POST['newsletter_mail_sender_reply']) ? contrexx_stripslashes($_POST['newsletter_mail_sender_reply']) : $arrSettings['reply_mail']['setvalue'];
        $mailSmtpServer = isset($_POST['newsletter_mail_smtp_account']) ? intval($_POST['newsletter_mail_smtp_account']) : $_CONFIG['coreSmtpServer'];


        $this->_objTpl->loadTemplateFile('module_newsletter_mail_edit.html');
        $this->_pageTitle = $mailId > 0 ? ($copy ? $_ARRAYLANG['TXT_NEWSLETTER_COPY_EMAIL'] : $_ARRAYLANG['TXT_NEWSLETTER_MODIFY_EMAIL']) : $_ARRAYLANG['TXT_NEWSLETTER_CREATE_NEW_EMAIL'];

        $this->_objTpl->setVariable(array(
            'NEWSLETTER_MAIL_EDIT_TITLE' => $mailId > 0 ? ($copy ? $_ARRAYLANG['TXT_NEWSLETTER_COPY_EMAIL'] : $_ARRAYLANG['TXT_NEWSLETTER_MODIFY_EMAIL']) : $_ARRAYLANG['TXT_NEWSLETTER_CREATE_NEW_EMAIL']
        ));

        if (isset($_POST['newsletter_mail_save'])) {
            $objAttachment = $objDatabase->Execute("SELECT file_name FROM ".DBPREFIX."module_newsletter_attachment WHERE newsletter=".$mailId);
            if ($objAttachment !== false) {
                $arrCurrentAttachments = array();
                while (!$objAttachment->EOF) {
                    array_push($arrCurrentAttachments, ASCMS_NEWSLETTER_ATTACH_WEB_PATH.'/'.$objAttachment->fields['file_name']);
                    $objAttachment->MoveNext();
                }

                $arrNewAttachments = array_diff($arrAttachment, $arrCurrentAttachments);
                $arrRemovedAttachments = array_diff($arrCurrentAttachments, $arrAttachment);
            }

            $mailHtmlContentReplaced = preg_replace('/\[\[([A-Z0-9_]*?)\]\]/', '{\\1}' , $mailHtmlContent);
            $mailHtmlContentReplaced = $this->_getBodyContent($mailHtmlContentReplaced);

            if ($mailId > 0) {
                $status = $this->_updateMail($mailId, $mailSubject, $mailTemplate, $mailSenderMail, $mailSenderName, $mailReply, $mailSmtpServer, $mailPriority, $arrAttachment, $mailHtmlContentReplaced);
            } else {
                $mailId = $this->_addMail($mailSubject, $mailTemplate, $mailSenderMail, $mailSenderName, $mailReply, $mailSmtpServer, $mailPriority, $arrAttachment, $mailHtmlContentReplaced);
                if ($mailId === false) {
                    $status = false;
                }
            }

            if ($status) {
                // prepare every link of HTML body for tracking function
                $this->_prepareNewsletterLinksForStore($mailId);
                $this->_setMailLists($mailId, $arrAssociatedLists, $mailSendDate);
                $this->setMailGroups($mailId, $arrAssociatedGroups, $mailSendDate);

                foreach ($arrNewAttachments as $attachment) {
                    $this->_addMailAttachment($attachment, $mailId);
                }

                foreach ($arrRemovedAttachments as $attachment) {
                    $this->_removeMailAttachment($attachment, $mailId);
                }

                self::$strOkMessage .= $_ARRAYLANG['TXT_DATA_RECORD_STORED_SUCCESSFUL'];

                if (isset($_GET['sendMail']) && $_GET['sendMail'] == '1') {
                    return $this->_sendMailPage();
                } else {
                    return $this->_mails();
                }
            }
        } elseif ((!isset($_GET['setFormat']) || $_GET['setFormat'] != '1') && $mailId > 0) {
            $objResult = $objDatabase->SelectLimit("SELECT
                subject,
                template,
                content,
                attachment,
                priority,
                sender_email,
                sender_name,
                return_path,
                smtp_server
                FROM ".DBPREFIX."module_newsletter
                WHERE id=".$mailId, 1);
            if ($objResult !== false) {
                if ($objResult->RecordCount() == 1) {
                    $mailSubject = $objResult->fields['subject'];
                    $mailTemplate = $objResult->fields['template'];
                    $mailHtmlContent = preg_replace('/\{([A-Z0-9_-]+)\}/', '[[\\1]]', $objResult->fields['content']);
                    $mailPriority = $objResult->fields['priority'];
                    $mailSenderMail = $objResult->fields['sender_email'];
                    $mailSenderName = $objResult->fields['sender_name'];
                    $mailReply = $objResult->fields['return_path'];
                    $mailSmtpServer = $objResult->fields['smtp_server'];

                    $objList = $objDatabase->Execute("SELECT category FROM ".DBPREFIX."module_newsletter_rel_cat_news WHERE newsletter=".$mailId);
                    if ($objList !== false) {
                        while (!$objList->EOF) {
                            array_push($arrAssociatedLists, $objList->fields['category']);
                            $objList->MoveNext();
                        }

                    }

                    $arrAssociatedGroups =
                        $this->emailEditGetAssociatedGroups($mailId);

                    if ($objResult->fields['attachment'] == '1') {
                        $objAttachment = $objDatabase->Execute("SELECT file_name FROM ".DBPREFIX."module_newsletter_attachment WHERE newsletter=".$mailId);
                        if ($objAttachment !== false) {
                            while (!$objAttachment->EOF) {
                                array_push($arrAttachment, ASCMS_NEWSLETTER_ATTACH_WEB_PATH.'/'.$objAttachment->fields['file_name']);
                                $objAttachment->MoveNext();
                            }
                        }
                    }
                } else {
                    return $this->_mails();
                }
            }
        } else {
            $arrSettings = $this->_getSettings();

            $mailSenderMail = $arrSettings['sender_mail']['setvalue'];
            $mailSenderName = $arrSettings['sender_name']['setvalue'];
            $mailReply = $arrSettings['reply_mail']['setvalue'];
            $mailSmtpServer = $_CONFIG['coreSmtpServer'];

            if (!empty($_POST['textfield'])) {
                $mailHtmlContent = nl2br($_POST['textfield']);
            }
        }


        $act = $copy ? 'copyMail' : 'editMail';
        // remove newsletter_link_N value from rel attribute of the links
        if ($copy) {
            $mailHtmlContent = $this->_prepareNewsletterLinksForCopy($mailHtmlContent);
        }

        $this->_objTpl->setVariable(array(
            'NEWSLETTER_MAIL_ID' => ($copy ? 0 : $mailId),
            'NEWSLETTER_MAIL_SUBJECT' => htmlentities($mailSubject, ENT_QUOTES, CONTREXX_CHARSET),
            'NEWSLETTER_MAIL_HTML_CONTENT' => new \Cx\Core\Wysiwyg\Wysiwyg('newsletter_mail_html_content', contrexx_raw2xhtml($mailHtmlContent), 'fullpage'),
            'NEWSLETTER_MAIL_PRIORITY_MENU' => $this->_getMailPriorityMenu($mailPriority, 'name="newsletter_mail_priority" style="width:300px;"'),
            'NEWSLETTER_MAIL_TEMPLATE_MENU' => $this->_getTemplateMenu($mailTemplate, 'name="newsletter_mail_template" style="width:300px;" onchange="document.getElementById(\'newsletter_mail_form\').action=\'index.php?cmd=newsletter&amp;act='.$act.'&amp;id='.$mailId.'&amp;setFormat=1\';document.getElementById(\'newsletter_mail_form\').submit()"'),
            'NEWSLETTER_MAIL_SENDER_MAIL' => htmlentities($mailSenderMail, ENT_QUOTES, CONTREXX_CHARSET),
            'NEWSLETTER_MAIL_SENDER_NAME' => htmlentities($mailSenderName, ENT_QUOTES, CONTREXX_CHARSET),
            'NEWSLETTER_MAIL_REPLY' => htmlentities($mailReply, ENT_QUOTES, CONTREXX_CHARSET),
            'NEWSLETTER_MAIL_SMTP_SERVER' => SmtpSettings::getSmtpAccountMenu($mailSmtpServer, 'name="newsletter_mail_smtp_account" style="width:300px;"'),
            'NEWSLETTER_MAIL_SEND' => $_GET['act'] == 'sendMail' ? 1 : 0
        ));

        $this->_objTpl->setVariable('TXT_NEWSLETTER_HTML_UC', $_ARRAYLANG['TXT_NEWSLETTER_HTML_UC']);
        $this->_objTpl->touchBlock('newsletter_mail_html_content');

        $this->emailEditParseLists($arrAssociatedLists);
        $this->emailEditParseGroups($arrAssociatedGroups);

        if (count($arrAttachment) > 0) {
            foreach ($arrAttachment as $attachment) {
                $this->_objTpl->setVariable(array(
                    'NEWSLETTER_MAIL_ATTACHMENT_NR' => $attachmentNr,
                    'NEWSLETTER_MAIL_ATTACHMENT_NAME' => substr($attachment, strrpos($attachment, '/')+1),
                    'NEWSLETTER_MAIL_ATTACHMENT_URL' => $attachment,
                ));
                $this->_objTpl->parse('newsletter_mail_attachment_list');
                $attachmentNr++;
            }
        } else {
            $this->_objTpl->hideBlock('newsletter_mail_attachment_list');
        }

        $this->_objTpl->setVariable(array(
            'NEWSLETTER_MAIL_ATTACHMENT_NR' => $attachmentNr,
            'NEWSLETTER_MAIL_ATTACHMENT_BOX' => $attachmentNr > 0 ? 'block' : 'none',
        ));

        if (!$copy && $mailId > 0 && $mailSendDate > 0) {
            $this->_objTpl->touchBlock('associatedListToolTip');
            $this->_objTpl->touchBlock('associatedGroupToolTipAfterSent');
            $this->_objTpl->hideBlock('associatedGroupToolTipBeforeSend');

            $this->_objTpl->setVariable(array(
                'TXT_NEWSLETTER_INFO_ABOUT_ASSOCIATED_LISTS' => $_ARRAYLANG['TXT_NEWSLETTER_INFO_ABOUT_ASSOCIATED_LISTS'],
                'NEWSLETTER_LIST_DISABLED'                   => 'disabled="disabled"'
            ));
        } else {
            $this->_objTpl->setVariable(array(
                'TXT_NEWSLETTER_INFO_ABOUT_ASSOCIATED_LISTS_SEND' => $_ARRAYLANG['TXT_NEWSLETTER_INFO_ABOUT_ASSOCIATED_LISTS_SEND'],
            ));

            $this->_objTpl->hideBlock('associatedListToolTip');
            $this->_objTpl->hideBlock('associatedGroupToolTipAfterSent');
            $this->_objTpl->touchBlock('associatedGroupToolTipBeforeSend');
        }

        $this->_objTpl->setVariable(array(
            'TXT_NEWSLETTER_EMAIL_ACCOUNT' => $_ARRAYLANG['TXT_NEWSLETTER_EMAIL_ACCOUNT'],
            'TXT_NEWSLETTER_SUBJECT' => $_ARRAYLANG['TXT_NEWSLETTER_SUBJECT'],
            'TXT_NEWSLETTER_SEND_AS' => $_ARRAYLANG['TXT_NEWSLETTER_SEND_AS'],
            'TXT_NEWSLETTER_TEMPLATE' => $_ARRAYLANG['TXT_NEWSLETTER_TEMPLATE'],
            'TXT_NEWSLETTER_SENDER' => $_ARRAYLANG['TXT_NEWSLETTER_SENDER'],
            'TXT_NEWSLETTER_EMAIL' => $_ARRAYLANG['TXT_NEWSLETTER_EMAIL'],
            'TXT_NEWSLETTER_URI' => $_ARRAYLANG['TXT_NEWSLETTER_URI'],
            'TXT_NEWSLETTER_NAME' => $_ARRAYLANG['TXT_NEWSLETTER_NAME'],
            'TXT_NEWSLETTER_REPLY_ADDRESS' => $_ARRAYLANG['TXT_NEWSLETTER_REPLY_ADDRESS'],
            'TXT_NEWSLETTER_PRIORITY' => $_ARRAYLANG['TXT_NEWSLETTER_PRIORITY'],
            'TXT_NEWSLETTER_PRIORITY' => $_ARRAYLANG['TXT_NEWSLETTER_PRIORITY'],
            'TXT_NEWSLETTER_ATTACH' => $_ARRAYLANG['TXT_NEWSLETTER_ATTACH'],
            'TXT_NEWSLETTER_DISPLAY_FILE' => $_ARRAYLANG['TXT_NEWSLETTER_DISPLAY_FILE'],
            'TXT_NEWSLETTER_REMOVE_FILE' => $_ARRAYLANG['TXT_NEWSLETTER_REMOVE_FILE'],
            'TXT_NEWSLETTER_ATTACH_FILE' => $_ARRAYLANG['TXT_NEWSLETTER_ATTACH_FILE'],
            'TXT_NEWSLETTER_HTML_CONTENT' => $_ARRAYLANG['TXT_NEWSLETTER_HTML_CONTENT'],
            'TXT_NEWSLETTER_PLACEHOLDER_DIRECTORY' => $_ARRAYLANG['TXT_NEWSLETTER_PLACEHOLDER_DIRECTORY'],
            'TXT_NEWSLETTER_USER_DATA' => $_ARRAYLANG['TXT_NEWSLETTER_USER_DATA'],
            'TXT_NEWSLETTER_EMAIL_ADDRESS' => $_ARRAYLANG['TXT_NEWSLETTER_EMAIL_ADDRESS'],
            'TXT_NEWSLETTER_SEX' => $_ARRAYLANG['TXT_NEWSLETTER_SEX'],
            'TXT_NEWSLETTER_SALUTATION' => $_ARRAYLANG['TXT_NEWSLETTER_SALUTATION'],
            'TXT_NEWSLETTER_TITLE' => $_ARRAYLANG['TXT_NEWSLETTER_TITLE'],
            'TXT_NEWSLETTER_POSITION' => $_ARRAYLANG['TXT_NEWSLETTER_POSITION'],
            'TXT_NEWSLETTER_COMPANY' => $_ARRAYLANG['TXT_NEWSLETTER_COMPANY'],
            'TXT_NEWSLETTER_INDUSTRY_SECTOR' => $_ARRAYLANG['TXT_NEWSLETTER_INDUSTRY_SECTOR'],
            'TXT_NEWSLETTER_ADDRESS' => $_ARRAYLANG['TXT_NEWSLETTER_ADDRESS'],
            'TXT_NEWSLETTER_PHONE_PRIVATE' => $_ARRAYLANG['TXT_NEWSLETTER_PHONE_PRIVATE'],
            'TXT_NEWSLETTER_PHONE_MOBILE' => $_ARRAYLANG['TXT_NEWSLETTER_PHONE_MOBILE'],
            'TXT_NEWSLETTER_FAX' => $_ARRAYLANG['TXT_NEWSLETTER_FAX'],
            'TXT_NEWSLETTER_WEBSITE' => $_ARRAYLANG['TXT_NEWSLETTER_WEBSITE'],

            'TXT_NEWSLETTER_LASTNAME' => $_ARRAYLANG['TXT_NEWSLETTER_LASTNAME'],
            'TXT_NEWSLETTER_FIRSTNAME' => $_ARRAYLANG['TXT_NEWSLETTER_FIRSTNAME'],
            'TXT_NEWSLETTER_ADDRESS' => $_ARRAYLANG['TXT_NEWSLETTER_ADDRESS'],
            'TXT_NEWSLETTER_ZIP' => $_ARRAYLANG['TXT_NEWSLETTER_ZIP'],
            'TXT_NEWSLETTER_CITY' => $_ARRAYLANG['TXT_NEWSLETTER_CITY'],
            'TXT_NEWSLETTER_COUNTRY' => $_ARRAYLANG['TXT_NEWSLETTER_COUNTRY'],
            'TXT_NEWSLETTER_PHONE' => $_ARRAYLANG['TXT_NEWSLETTER_PHONE'],
            'TXT_NEWSLETTER_BIRTHDAY' => $_ARRAYLANG['TXT_NEWSLETTER_BIRTHDAY'],
            'TXT_NEWSLETTER_GENERAL' => $_ARRAYLANG['TXT_NEWSLETTER_GENERAL'],
            'TXT_NEWSLETTER_MODIFY_PROFILE' => $_ARRAYLANG['TXT_NEWSLETTER_MODIFY_PROFILE'],
            'TXT_NEWSLETTER_UNSUBSCRIBE' => $_ARRAYLANG['TXT_NEWSLETTER_UNSUBSCRIBE'],
            'TXT_NEWSLETTER_PLACEHOLDER_NOT_ON_BROWSER_VIEW' => $_ARRAYLANG['TXT_NEWSLETTER_PLACEHOLDER_NOT_ON_BROWSER_VIEW'],
            'TXT_NEWSLETTER_DATE' => $_ARRAYLANG['TXT_NEWSLETTER_DATE'],
            'TXT_NEWSLETTER_DISPLAY_IN_BROWSER_LINK' => $_ARRAYLANG['TXT_NEWSLETTER_DISPLAY_IN_BROWSER_LINK'],
            'TXT_NEWSLETTER_SAVE' => $_ARRAYLANG['TXT_NEWSLETTER_SAVE'],
            'TXT_NEWSLETTER_BACK' => $_ARRAYLANG['TXT_NEWSLETTER_BACK'],
            'TXT_NEWSLETTER_CONFIRM_EMPTY_TEXT' => $_ARRAYLANG['TXT_NEWSLETTER_CONFIRM_EMPTY_TEXT']
        ));
        return true;
    }


    /**
     * Parse the lists to be selected as email recipients
     * @author      Stefan Heinemann <sh@adfinis.com>
     * @param       array $associatedLists
     */
    function emailEditParseLists($associatedLists)
    {
        global $_ARRAYLANG;

        $arrLists = self::getLists();
        $listNr = 0;
        foreach ($arrLists as $listID => $listItem) {
            $column = $listNr % 3;
            $this->_objTpl->setVariable(array(
                'NEWSLETTER_LIST_ID' => $listID,
                'NEWSLETTER_LIST_NAME' => contrexx_raw2xhtml($listItem['name']),
                'NEWSLETTER_SHOW_RECIPIENTS_OF_LIST_TXT' => sprintf(
                    $_ARRAYLANG['TXT_NEWSLETTER_SHOW_RECIPIENTS_OF_LIST'],
                    contrexx_raw2xhtml($listItem['name'])),
                'NEWSLETTER_LIST_ASSOCIATED' =>
                    (in_array($listID, $associatedLists)
                        ? 'checked="checked"' : ''),
                'TXT_NEWSLETTER_ASSOCIATED_LISTS' =>
                    $_ARRAYLANG['TXT_NEWSLETTER_ASSOCIATED_LISTS'],
            ));
            $this->_objTpl->parse('newsletter_mail_associated_list_'.$column);
            $listNr++;
        }
    }


    /**
     * Parse the groups into the mail edit page
     *
     * @author      Stefan Heinemann <sh@adfinis.com>
     * @todo        Apparently parses one group too much
     */
    private function emailEditParseGroups($associatedGroups = array()) {
        global $_ARRAYLANG;

        $groups = $this->_getGroups();
        $groupNr = 0;
        foreach ($groups as $groupID => $groupItem) {
            $column = $groupNr % 3;
            $this->_objTpl->setVariable(array(
                'NEWSLETTER_GROUP_ID' => $groupID,
                'NEWSLETTER_GROUP_NAME' => htmlentities(
                    $groupItem, ENT_QUOTES, CONTREXX_CHARSET),
                'NEWSLETTER_SHOW_RECIPIENTS_OF_GROUP_TXT' => sprintf(
                    $_ARRAYLANG['TXT_NEWSLETTER_SHOW_RECIPIENTS_OF_GROUP'],
                    $groupItem
                ),
                'NEWSLETTER_GROUP_ASSOCIATED' =>
                    (in_array($groupID, $associatedGroups)
                        ? 'checked="checked"' : ''),
                'TXT_NEWSLETTER_ASSOCIATED_GROUPS' =>
                    $_ARRAYLANG['TXT_NEWSLETTER_ASSOCIATED_GROUPS'],
            ));
            $this->_objTpl->parse('newsletter_mail_associated_group_'.$column);
            $groupNr++;
        }
    }


    /**
     * Return the associated access groups of an email
     * @author      Stefan Heinemann <sh@adfinis.com>
     * @param       int $mail
     * @return      array
     */
    private function emailEditGetAssociatedGroups($mail)
    {
        global $objDatabase;

        $query = sprintf('
            SELECT `userGroup`
              FROM `%1$smodule_newsletter_rel_usergroup_newsletter`
             WHERE `newsletter`=%2$s',
            DBPREFIX, $mail
        );
        $data = $objDatabase->Execute($query);
        $list = array();
        if ($data !== false) {
            while (!$data->EOF) {
                $list[] =  $data->fields['userGroup'];
                $data->MoveNext();
            }
        }
        return $list;
    }

    function _update()
    {
        die('Feature not available!');

        global $objDatabase;

        $objColumns = $objDatabase->MetaColumns(DBPREFIX."module_newsletter");
        if ($objColumns !== false) {
            if ($objColumns['DATE_CREATE']->type != 'int') {
                $query = "SELECT `id`, `date_create` FROM ".DBPREFIX."module_newsletter";
                $objNewsletter = $objDatabase->Execute($query);
                if ($objNewsletter !== false) {
                    $arrNewsletter = array();
                    while (!$objNewsletter->EOF) {
                        $arrNewsletter[$objNewsletter->fields['id']] = $objNewsletter->fields['date_create'];
                        $objNewsletter->MoveNext();
                    }

                    $query = "ALTER TABLE ".DBPREFIX."module_newsletter CHANGE `date_create` `date_create` INT( 14 ) UNSIGNED NOT NULL";
                    if ($objDatabase->Execute($query) === false) {
                        die('DB error: '.$query);
                    }

                    foreach ($arrNewsletter as $id => $dateCreate) {
                        $date = mktime(0,0,0,intval(substr($dateCreate,5,2)),intval(substr($dateCreate,8,2)),intval(substr($dateCreate,0,4)));
                        $query = "UPDATE ".DBPREFIX."module_newsletter SET `date_create`=".$date." WHERE `id`=".$id;
                        if ($objDatabase->Execute($query) === false) {
                            print "DB error: ".$query."<br />";
                        }
                    }
                }
            }

            if ($objColumns['DATE_SENT']->type != 'int') {
                $query = "SELECT `id`, `date_sent` FROM ".DBPREFIX."module_newsletter";
                $objNewsletter = $objDatabase->Execute($query);
                if ($objNewsletter !== false) {
                    $arrNewsletter = array();
                    while (!$objNewsletter->EOF) {
                        $arrNewsletter[$objNewsletter->fields['id']] = $objNewsletter->fields['date_sent'];
                        $objNewsletter->MoveNext();
                    }

                    $query = "ALTER TABLE ".DBPREFIX."module_newsletter CHANGE `date_sent` `date_sent` INT( 14 ) UNSIGNED NOT NULL";
                    if ($objDatabase->Execute($query) === false) {
                        die('DB error: '.$query);
                    }

                    foreach ($arrNewsletter as $id => $dateSent) {
                        $date = mktime(0,0,0,intval(substr($dateSent,5,2)),intval(substr($dateSent,8,2)),intval(substr($dateSent,0,4)));
                        $query = "UPDATE ".DBPREFIX."module_newsletter SET `date_sent`=".$date." WHERE `id`=".$id;
                        if ($objDatabase->Execute($query) === false) {
                            print "DB error: ".$query."<br />";
                        }
                    }
                }
            }
        }
    }


    function _mails()
    {
        global $objDatabase, $_ARRAYLANG, $_CONFIG;

        $this->_pageTitle = $_ARRAYLANG['TXT_NEWSLETTER_EMAIL_CAMPAIGNS'];
        $this->_objTpl->loadTemplateFile('module_newsletter_mails.html');
        $rowNr = 0;
        $pos = isset($_GET['pos']) ? intval($_GET['pos']) : 0;

        $this->_objTpl->setVariable(array(
            'TXT_NEWSLETTER_SUBJECT' => $_ARRAYLANG['TXT_NEWSLETTER_SUBJECT'],
            'TXT_NEWSLETTER_NAME_OF_EMAIL_CAMPAIGN' => $_ARRAYLANG['TXT_NEWSLETTER_NAME_OF_EMAIL_CAMPAIGN'],
            'TXT_NEWSLETTER_STATS' => $_ARRAYLANG['TXT_NEWSLETTER_STATS'],
            'TXT_NEWSLETTER_EMAIL_CAMPAIGNS' => $_ARRAYLANG['TXT_NEWSLETTER_EMAIL_CAMPAIGNS'],
            'TXT_NEWSLETTER_OVERVIEW' => $_ARRAYLANG['TXT_NEWSLETTER_OVERVIEW'],
            'TXT_NEWSLETTER_SENT' => $_ARRAYLANG['TXT_NEWSLETTER_SENT'],
            'TXT_NEWSLETTER_FEEDBACK' => $_ARRAYLANG['TXT_NEWSLETTER_FEEDBACK'],
            'TXT_NEWSLETTER_SENDER' => $_ARRAYLANG['TXT_NEWSLETTER_SENDER'],
            'TXT_NEWSLETTER_FORMAT' => $_ARRAYLANG['TXT_NEWSLETTER_FORMAT'],
            'TXT_NEWSLETTER_TEMPLATE' => $_ARRAYLANG['TXT_NEWSLETTER_TEMPLATE'],
            'TXT_NEWSLETTER_DATE' => $_ARRAYLANG['TXT_NEWSLETTER_DATE'],
            'TXT_NEWSLETTER_FUNCTIONS' => $_ARRAYLANG['TXT_NEWSLETTER_FUNCTIONS'],
            'TXT_NEWSLETTER_CHECK_ALL' => $_ARRAYLANG['TXT_NEWSLETTER_CHECK_ALL'],
            'TXT_NEWSLETTER_UNCHECK_ALL' => $_ARRAYLANG['TXT_NEWSLETTER_UNCHECK_ALL'],
            'TXT_NEWSLETTER_WITH_SELECTED' => $_ARRAYLANG['TXT_NEWSLETTER_WITH_SELECTED'],
            'TXT_NEWSLETTER_DELETE' => $_ARRAYLANG['TXT_NEWSLETTER_DELETE'],
            'TXT_NEWSLETTER_CREATE_NEW_EMAIL' => $_ARRAYLANG['TXT_NEWSLETTER_CREATE_NEW_EMAIL'],
            'TXT_NEWSLETTER_CREATE_NEW_EMAIL_WITH_NEWS' => $_ARRAYLANG['TXT_NEWSLETTER_CREATE_NEW_EMAIL_WITH_NEWS'],
            'TXT_NEWSLETTER_CONFIRM_DELETE_MAIL' => $_ARRAYLANG['TXT_NEWSLETTER_CONFIRM_DELETE_MAIL'],
            'TXT_NEWSLETTER_CANNOT_UNDO_OPERATION' => $_ARRAYLANG['TXT_NEWSLETTER_CANNOT_UNDO_OPERATION'],
            'TXT_NEWSLETTER_CONFIRM_DELETE_CHECKED_EMAILS' => $_ARRAYLANG['TXT_NEWSLETTER_CONFIRM_DELETE_CHECKED_EMAILS']
        ));

        $this->_objTpl->setGlobalVariable(array(
            'TXT_NEWSLETTER_SEND_EMAIL' => $_ARRAYLANG['TXT_NEWSLETTER_SEND_EMAIL'],
            'TXT_NEWSLETTER_MODIFY_EMAIL' => $_ARRAYLANG['TXT_NEWSLETTER_MODIFY_EMAIL'],
            'TXT_NEWSLETTER_COPY_EMAIL' => $_ARRAYLANG['TXT_NEWSLETTER_COPY_EMAIL'],
            'TXT_NEWSLETTER_DELETE_EMAIL' => $_ARRAYLANG['TXT_NEWSLETTER_DELETE_EMAIL'],
        ));

        $objResultCount = $objDatabase->SelectLimit("SELECT COUNT(1) AS mail_count FROM ".DBPREFIX."module_newsletter", 1);
        if ($objResultCount !== false) {
            $mailCount = $objResultCount->fields['mail_count'];
        } else {
            $mailCount = 0;
        }

        $arrTemplates = $this->_getTemplates();
        // feedback counting
        $arrFeedback = array();
        $objFeedback = $objDatabase->SelectLimit("SELECT
            tblMail.id,
            COUNT(DISTINCT tblMailLinkFB.recipient_id,tblMailLinkFB.recipient_type) AS feedback_count
            FROM ".DBPREFIX."module_newsletter AS tblMail
                INNER JOIN ".DBPREFIX."module_newsletter_email_link_feedback AS tblMailLinkFB ON tblMailLinkFB.email_id = tblMail.id
            GROUP BY tblMail.id
            ORDER BY status, id DESC", $_CONFIG['corePagingLimit'], $pos);
        if ($objFeedback !== false) {
            while (!$objFeedback->EOF) {
                $arrFeedback[$objFeedback->fields['id']] = $objFeedback->fields['feedback_count'];
                $objFeedback->MoveNext();
            }
        }
        $objResult = $objDatabase->SelectLimit("SELECT
            tblMail.id,
            tblMail.subject,
            tblMail.date_create,
            tblMail.sender_email,
            tblMail.sender_name,
            tblMail.template,
            tblMail.status,
            tblMail.`count`,
            tblMail.date_sent
            FROM ".DBPREFIX."module_newsletter AS tblMail
            ORDER BY date_create DESC, status, id DESC", $_CONFIG['corePagingLimit'], $pos);
        if ($objResult !== false) {
            $arrMailRecipientCount = $this->_getMailRecipientCount(NULL, $_CONFIG['corePagingLimit'], $pos);
            while (!$objResult->EOF) {
                $feedbackCount = isset($arrFeedback[$objResult->fields['id']]) ? $arrFeedback[$objResult->fields['id']] : 0;
                $feedbackStrFormat = '%1$s (%2$s%%)';
                $feedbackPercent = ($objResult->fields['count'] > 0 && $feedbackCount  > 0) ? round(100 / $objResult->fields['count'] * $feedbackCount) : 0;
                $feedback = sprintf($feedbackStrFormat, $feedbackCount, $feedbackPercent);
                $this->_objTpl->setVariable(array(
                    'NEWSLETTER_MAIL_ROW_CLASS' => $rowNr % 2 == 1 ? 'row1' : 'row2',
                    'NEWSLETTER_MAIL_SUBJECT' => htmlentities($objResult->fields['subject'], ENT_QUOTES, CONTREXX_CHARSET),
                    'NEWSLETTER_MAIL_SENDER_NAME' => htmlentities($objResult->fields['sender_name'], ENT_QUOTES, CONTREXX_CHARSET),
                    'NEWSLETTER_MAIL_SENDER_EMAIL' => htmlentities($objResult->fields['sender_email'], ENT_QUOTES, CONTREXX_CHARSET),
                    'NEWSLETTER_MAIL_FEEDBACK' => $feedback,
                    'NEWSLETTER_FEEDBACK_OVERVIEW' => sprintf($_ARRAYLANG['TXT_NEWSLETTER_FEEDBACK_OVERVIEW'], $feedbackCount),
                    'NEWSLETTER_MAIL_SENT_DATE' => $objResult->fields['date_sent'] > 0 ? date(ASCMS_DATE_FORMAT_DATETIME, $objResult->fields['date_sent']) : '-',
                    //'NEWSLETTER_MAIL_FORMAT' => $objResult->fields['format'],
                    'NEWSLETTER_MAIL_TEMPLATE' => htmlentities($arrTemplates[$objResult->fields['template']]['name'], ENT_QUOTES, CONTREXX_CHARSET),
                    'NEWSLETTER_MAIL_DATE' => date(ASCMS_DATE_FORMAT_DATETIME, $objResult->fields['date_create']),
                    'NEWSLETTER_MAIL_COUNT' => $objResult->fields['count'],
                    'NEWSLETTER_MAIL_USERS' => isset($arrMailRecipientCount[$objResult->fields['id']]) ? $arrMailRecipientCount[$objResult->fields['id']] : 0
                ));

                $this->_objTpl->setGlobalVariable('NEWSLETTER_MAIL_ID', $objResult->fields['id']);

                if ($objResult->fields['count'] > 0 && $feedbackCount > 0) {
                    $this->_objTpl->touchBlock('newsletter_mail_feedback_link');
                    $this->_objTpl->hideBlock('newsletter_mail_feedback_empty');
                } else {
                    $this->_objTpl->touchBlock('newsletter_mail_feedback_empty');
                    $this->_objTpl->hideBlock('newsletter_mail_feedback_link');
                }

                $this->_objTpl->parse("newsletter_list");
                $objResult->MoveNext();
                $rowNr++;
            }
            if ($rowNr > 0) {
                $this->_objTpl->touchBlock("newsletter_list_multiAction");
//                if ($mailCount > $_CONFIG['corePagingLimit']) {
// TODO: All calls to getPaging(): Shouldn't '&' be written as '&amp;'?
                $paging = getPaging($mailCount, $pos, "&cmd=newsletter&act=mails", "", false, $_CONFIG['corePagingLimit']);
//                }
                $this->_objTpl->setVariable('NEWSLETTER_MAILS_PAGING', "<br />".$paging."<br />");
            } else {
                $this->_objTpl->hideBlock("newsletter_list_multiAction");
            }
        }
    }


    function _deleteMail()
    {
        global $objDatabase, $_ARRAYLANG;

        $status = true;
        $arrMailIds = array();
        if (isset($_GET['id'])) {
            array_push($arrMailIds, intval($_GET['id']));
        } elseif (isset($_POST['newsletter_mail_selected'])) {
            foreach ($_POST['newsletter_mail_selected'] as $mailId) {
                array_push($arrMailIds, intval($mailId));
            }
        }

        if (count($arrMailIds) > 0) {
            foreach ($arrMailIds as $mailId) {
                if ($objDatabase->Execute("DELETE FROM ".DBPREFIX."module_newsletter_attachment where newsletter=".$mailId) !== false &&
                    $objDatabase->Execute("DELETE FROM ".DBPREFIX."module_newsletter_rel_cat_news where newsletter=".$mailId) !== false &&
                    $objDatabase->Execute("DELETE FROM ".DBPREFIX."module_newsletter_tmp_sending where newsletter=".$mailId) !== false &&
                    $objDatabase->Execute("DELETE FROM ".DBPREFIX."module_newsletter_email_link where email_id=".$mailId) !== false &&
                    $objDatabase->Execute("DELETE FROM ".DBPREFIX."module_newsletter_email_link_feedback where email_id=".$mailId) !== false &&
                    $objDatabase->Execute("DELETE FROM ".DBPREFIX."module_newsletter where id=".$mailId)) {
                } else {
                    $status = false;
                }
            }

            if ($status) {
                self::$strOkMessage = count($arrMailIds) > 1 ? $_ARRAYLANG['TXT_NEWSLETTER_EMAILS_DELETED'] : $_ARRAYLANG['TXT_NEWSLETTER_EMAIL_DELETED'];
            } else {
                self::$strErrMessage = count($arrMailIds) > 1 ? $_ARRAYLANG['TXT_NEWSLETTER_ERROR_DELETE_EMAILS'] : $_ARRAYLANG['TXT_NEWSLETTER_ERROR_DELETE_EMAIL'];
            }
        }
        $this->_mails();
    }


    function _copyMail()
    {
        $this->_editMail(true);
    }


    function _getBodyContent($fullContent)
    {
        $posBody = 0;
        $posStartBodyContent = 0;
        $arrayMatches = array();
        $res = preg_match_all('/<body[^>]*>/i', $fullContent, $arrayMatches);
        if ($res==true) {
            $bodyStartTag = $arrayMatches[0][0];
            // Position des Start-Tags holen
            $posBody = strpos($fullContent, $bodyStartTag, 0);
            // Beginn des Contents ohne Body-Tag berechnen
            $posStartBodyContent = $posBody + strlen($bodyStartTag);
        }
        $posEndTag=strlen($fullContent);
        $res = preg_match_all('/<\/body>/i', $fullContent, $arrayMatches);
        if ($res == true) {
            $bodyEndTag=$arrayMatches[0][0];
            // Position des End-Tags holen
            $posEndTag = strpos($fullContent, $bodyEndTag, 0);
            // Content innerhalb der Body-Tags auslesen
         }
         $content = substr($fullContent, $posStartBodyContent, $posEndTag  - $posStartBodyContent);
         return $content;
    }


    function _addMailAttachment($attachment, $mailId = 0)
    {
        global $objDatabase;

        $fileName = substr($attachment, strrpos($attachment, '/')+1);

        $objAttachment = $objDatabase->SelectLimit("SELECT id FROM ".DBPREFIX."module_newsletter_attachment WHERE file_name='".$fileName."'", 1);
        if ($objAttachment !== false) {
            if ($objAttachment->RecordCount() == 1) {
                $md5Current = @md5_file(ASCMS_NEWSLETTER_ATTACH_PATH.'/'.$fileName);
                $md5New = @md5_file(ASCMS_PATH.$attachment);

                if ($md5Current !== false && $md5Current === $md5New) {
                    if ($objDatabase->Execute("    INSERT INTO ".DBPREFIX."module_newsletter_attachment (`newsletter`, `file_name`)
                                                VALUES (".$mailId.", '".$fileName."')") !== false) {
                        return true;
                    }
                }
            }

            $nr = 0;
            $fileNameTmp = $fileName;
            while (file_exists(ASCMS_NEWSLETTER_ATTACH_PATH.'/'.$fileNameTmp)) {
                $md5Current = @md5_file(ASCMS_NEWSLETTER_ATTACH_PATH.'/'.$fileNameTmp);
                $md5New = @md5_file(ASCMS_PATH.$attachment);

                if ($md5Current !== false && $md5Current === $md5New) {
                    if ($objDatabase->Execute("INSERT INTO ".DBPREFIX."module_newsletter_attachment (`newsletter`, `file_name`) VALUES (".$mailId.", '".$fileNameTmp."')") !== false) {
                        return true;
                    }
                }
                $nr++;
                $PathInfo = pathinfo($fileName);
                $fileNameTmp = substr($PathInfo['basename'],0,strrpos($PathInfo['basename'],'.')).$nr.'.'.$PathInfo['extension'];
            }

            if (copy(ASCMS_PATH.$attachment, ASCMS_NEWSLETTER_ATTACH_PATH.'/'.$fileNameTmp)) {
                if ($objDatabase->Execute("INSERT INTO ".DBPREFIX."module_newsletter_attachment (`newsletter`, `file_name`) VALUES (".$mailId.", '".$fileNameTmp."')") !== false) {
                    return true;
                }
            }
        }
        return false;
    }


    function _removeMailAttachment($attachment, $mailId = 0)
    {
        global $objDatabase;

        $fileName = substr($attachment, strrpos($attachment, '/')+1);
        $objAttachment = $objDatabase->SelectLimit("SELECT id FROM ".DBPREFIX."module_newsletter_attachment WHERE file_name='".$fileName."'", 2);
        if ($objAttachment !== false) {
            if ($objAttachment->RecordCount() < 2) {
                @unlink(ASCMS_NEWSLETTER_ATTACH_PATH.'/'.$fileName);
            }

            if ($objDatabase->SelectLimit("DELETE FROM ".DBPREFIX."module_newsletter_attachment WHERE file_name='".$fileName."' AND newsletter=".$mailId, 1) !== false) {
                return true;
            }
        }
        return false;
    }


    function _getMailPriorityMenu($selectedPriority = 3, $attributes = '')
    {
        global $_ARRAYLANG;

        $menu = "<select".(!empty($attributes) ? " ".$attributes : "").">\n";
        foreach ($this->_arrMailPriority as $priorityId => $priority) {
            $menu .= "<option value=\"".$priorityId."\"".($selectedPriority == $priorityId ? "selected=\"selected\"" : "").">".$_ARRAYLANG[$priority]."</option>\n";
        }
        $menu .= "</select>\n";

        return $menu;
    }


    function _addMail($subject, $template, $senderMail, $senderName, $replyMail, $smtpServer, $priority, $arrAttachment, $htmlContent)
    {
        global $objDatabase, $_ARRAYLANG;

        if (!empty($subject)) {
            if ($objDatabase->Execute("INSERT INTO ".DBPREFIX."module_newsletter
                (subject,
                template,
                content,
                attachment,
                priority,
                sender_email,
                sender_name,
                return_path,
                smtp_server,
                date_create
                ) VALUES (
                '".addslashes($subject)."',
                ".intval($template).",
                '".addslashes($htmlContent)."',
                '".(count($arrAttachment) > 0 ? '1' : '0')."',
                ".intval($priority).",
                '".addslashes($senderMail)."',
                '".addslashes($senderName)."',
                '".addslashes($replyMail)."',
                ".intval($smtpServer).",
                ".time().")") !== false) {
                $mailId = $objDatabase->Insert_ID();
                return $mailId;
            } else {
                self::$strErrMessage .= $_ARRAYLANG['TXT_NEWSLETTER_ERROR_SAVE_RETRY'];


            }
        } else {
            self::$strErrMessage .= $_ARRAYLANG['TXT_NEWSLETTER_ERROR_NO_SUBJECT'];
        }
        return false;
    }


    function _updateMail($mailId, $subject, $template, $senderMail, $senderName, $replyMail, $smtpServer, $priority, $arrAttachment, $htmlContent)
    {
        global $objDatabase, $_ARRAYLANG;

        if (!empty($subject)) {
            if ($objDatabase->Execute("UPDATE ".DBPREFIX."module_newsletter
                SET subject='".addslashes($subject)."',
                template=".intval($template).",
                content='".addslashes($htmlContent)."',
                attachment='".(count($arrAttachment) > 0 ? '1' : '0')."',
                priority=".intval($priority).",
                sender_email='".addslashes($senderMail)."',
                sender_name='".addslashes($senderName)."',
                return_path='".addslashes($replyMail)."',
                smtp_server=".intval($smtpServer)."
                WHERE id=".$mailId) !== false) {
                return true;
            } else {
                self::$strErrMessage .= $_ARRAYLANG['TXT_NEWSLETTER_ERROR_SAVE_RETRY'];
            }
        } else {
            self::$strErrMessage .= $_ARRAYLANG['TXT_NEWSLETTER_ERROR_NO_SUBJECT'];
        }
        return false;
    }


    function _setMailLists($mailId, $arrLists, $mailSentDate)
    {
        global $objDatabase;

        $arrCurrentList = array();

        if ($mailSentDate > 0) {
            return false;
        }

        $objRelList = $objDatabase->Execute("SELECT category FROM ".DBPREFIX."module_newsletter_rel_cat_news WHERE newsletter=".$mailId);
        if (!$objRelList) {
            return false;
        }
        while (!$objRelList->EOF) {
            array_push($arrCurrentList, $objRelList->fields['category']);
            $objRelList->MoveNext();
        }

        $arrNewLists = array_diff($arrLists, $arrCurrentList);
        $arrRemovedLists = array_diff($arrCurrentList, $arrLists);

        foreach ($arrNewLists as $listId) {
            $objDatabase->Execute("
                INSERT INTO ".DBPREFIX."module_newsletter_rel_cat_news (
                    `newsletter`, `category`
                ) VALUES (
                    $mailId, $listId
                )
            ");
        }

        foreach ($arrRemovedLists as $listId) {
            $objDatabase->Execute("
                DELETE FROM ".DBPREFIX."module_newsletter_rel_cat_news
                 WHERE newsletter=$mailId
                   AND category=$listId
            ");
        }
        return true;
    }


    /**
     * Associate the user groups with the mail
     *
     * Associate the access user groups with the
     * newsletter email.
     * @author      Stefan Heinemann <sh@adfinis.com>
     * @param       int $mailID
     * @param       array $groups
     * @param       string $mailSentDate sent date
     */
    private function setMailGroups($mailID, $groups, $mailSentDate) {
        global $objDatabase;

        if ($mailSentDate > 0) {
            return false;
        }

        foreach ($groups as $group) {
            $objDatabase->Execute(
                sprintf('
                    REPLACE INTO
                        `%smodule_newsletter_rel_usergroup_newsletter`
                        (`newsletter`, `userGroup`)
                    VALUES
                        (%s, %s)
                    ', DBPREFIX, $mailID, intval($group)
                )
            );
        }
        if (count($groups) > 0) {
            $delString = implode(',', $groups);

            $query = sprintf('
                DELETE FROM
                    `%smodule_newsletter_rel_usergroup_newsletter`
                WHERE
                    `userGroup` NOT IN (%s)
                AND
                    `newsletter` = %s
                ',
                DBPREFIX,
                $delString,
                $mailID
            );
            $objDatabase->Execute($query);
        } else {
            // no groups were selected -> remove all group associations
            $query = sprintf('
                DELETE FROM
                    `%smodule_newsletter_rel_usergroup_newsletter`
                WHERE
                    `newsletter` = %s
                ',
                DBPREFIX,
                $mailID
            );
            $objDatabase->Execute($query);
        }
    }


    static function _checkUniqueListName($listId, $listName)
    {
        global $objDatabase;

        $result = $objDatabase->SelectLimit("
            SELECT id
              FROM ".DBPREFIX."module_newsletter_category
             WHERE `name`='".$listName."'
               AND `id`!=".$listId, 1);
        if ($result && $result->RecordCount() == 0) return true;
        return false;
    }


    function ConfigHTML()
    {
        global $_ARRAYLANG;

        $this->_pageTitle = $_ARRAYLANG['TXT_SETTINGS'];
        $this->_objTpl->loadTemplateFile('newsletter_config_html.html');

        $this->_objTpl->setVariable(array(
            'HTML_CODE' => htmlentities($this->_getHTML(), ENT_QUOTES, CONTREXX_CHARSET),
            'TXT_TITLE' => $_ARRAYLANG['TXT_GENERATE_HTML'],
            'TXT_SELECT_ALL' => $_ARRAYLANG['TXT_SELECT_ALL'],
            'TXT_DISPATCH_SETINGS' => $_ARRAYLANG['TXT_DISPATCH_SETINGS'],
            'TXT_NEWSLETTER_TEMPLATES' => $_ARRAYLANG['TXT_NEWSLETTER_TEMPLATES'],
            'TXT_NEWSLETTER_INTERFACE' => $_ARRAYLANG['TXT_NEWSLETTER_INTERFACE'],
            'TXT_GENERATE_HTML' => $_ARRAYLANG['TXT_GENERATE_HTML'],
            'TXT_PLACEHOLDER' => $_ARRAYLANG['TXT_PLACEHOLDER'],
            'TXT_CONFIRM_MAIL' => $_ARRAYLANG['TXT_NEWSLETTER_CONFIRMATION_EMAIL'],
            'TXT_ACTIVATE_MAIL' => $_ARRAYLANG['TXT_NEWSLETTER_ACTIVATION_EMAIL'],
            'TXT_NOTIFICATION_MAIL' => $_ARRAYLANG['TXT_NEWSLETTER_NOTIFICATION_MAIL'],
            'TXT_SYSTEM_SETINGS' => "System",
        ));
    }

    function interfaceSettings()
    {
        global $objDatabase, $_ARRAYLANG;

        JS::activate('jquery');

        $this->_pageTitle = $_ARRAYLANG['TXT_SETTINGS'];
        $this->_objTpl->loadTemplateFile('newsletter_config_interface.html');

        $recipientAttributeStatus = array();
        if (isset($_POST['interfaceSettings'])) {

            $recipientAttributeStatus = array(
                'recipient_sex'           => array(
                    'active'              => (isset($_POST['recipientSex'])),
                    'required'            => (isset($_POST['requiredSex'])),
                    ),
                'recipient_salutation'    => array(
                    'active'              => (isset($_POST['recipientSalutation'])),
                    'required'            => (isset($_POST['requiredSalutation'])),
                    ),
                'recipient_title'         => array(
                    'active'              => (isset($_POST['recipientTitle'])),
                    'required'            => (isset($_POST['requiredTitle'])),
                    ),
                'recipient_firstname'     => array(
                    'active'              => (isset($_POST['recipientFirstName'])),
                    'required'            => (isset($_POST['requiredFirstName'])),
                    ),
                'recipient_lastname'      => array(
                    'active'              => (isset($_POST['recipientLastName'])),
                    'required'            => (isset($_POST['requiredLastName'])),
                    ),
                'recipient_position'      => array(
                    'active'              => (isset($_POST['recipientPosition'])),
                    'required'            => (isset($_POST['requiredPosition'])),
                    ),
                'recipient_company'       => array(
                    'active'              => (isset($_POST['recipientCompany'])),
                    'required'            => (isset($_POST['requiredCompany'])),
                    ),
                'recipient_industry'      => array(
                    'active'              => (isset($_POST['recipientIndustry'])),
                    'required'            => (isset($_POST['requiredIndustry'])),
                    ),
                'recipient_address'       => array(
                    'active'              => (isset($_POST['recipientAddress'])),
                    'required'            => (isset($_POST['requiredAddress'])),
                    ),
                'recipient_city'          => array(
                    'active'              => (isset($_POST['recipientCity'])),
                    'required'            => (isset($_POST['requiredCity'])),
                    ),
                'recipient_zip'           => array(
                    'active'              => (isset($_POST['recipientZip'])),
                    'required'            => (isset($_POST['requiredZip'])),
                    ),
                'recipient_country'       => array(
                    'active'              => (isset($_POST['recipientCountry'])),
                    'required'            => (isset($_POST['requiredCountry'])),
                    ),
                'recipient_phone'         => array(
                    'active'              => (isset($_POST['recipientPhone'])),
                    'required'            => (isset($_POST['requiredPhone'])),
                    ),
                'recipient_private'       => array(
                    'active'              => (isset($_POST['recipientPrivate'])),
                    'required'            => (isset($_POST['requiredPrivate'])),
                    ),
                'recipient_mobile'        => array(
                    'active'              => (isset($_POST['recipientMobile'])),
                    'required'            => (isset($_POST['requiredMobile'])),
                    ),
                'recipient_fax'           => array(
                    'active'              => (isset($_POST['recipientFax'])),
                    'required'            => (isset($_POST['requiredFax'])),
                    ),
                'recipient_birthday'      => array(
                    'active'              => (isset($_POST['recipientBirthDay'])),
                    'required'            => (isset($_POST['requiredBirthDay'])),
                    ),
                'recipient_website'       => array(
                    'active'              => (isset($_POST['recipientWebsite'])),
                    'required'            => (isset($_POST['requiredWebsite'])),
                    ),
            );

            $objUpdateStatus = $objDatabase->Execute("UPDATE ".DBPREFIX."module_newsletter_settings
                                                        SET `setvalue`='".json_encode($recipientAttributeStatus)."'
                                                      WHERE `setname` = 'recipient_attribute_status'");

            if ($objUpdateStatus) {
                self::$strOkMessage = $_ARRAYLANG['TXT_DATA_RECORD_UPDATED_SUCCESSFUL'];
            } else {
                self::$strErrMessage = $_ARRAYLANG['TXT_DATABASE_ERROR'];
            }
        }

        $objInterface = $objDatabase->Execute('SELECT `setvalue`
                                                FROM `'.DBPREFIX.'module_newsletter_settings`
                                                WHERE `setname` = "recipient_attribute_status"');
        $recipientStatus = json_decode($objInterface->fields['setvalue'], true);

        foreach ($recipientStatus as $attributeName => $recipientStatusArray) {
            $this->_objTpl->setVariable(array(
                 'NEWSLETTER_'.strtoupper($attributeName)                       =>  ($recipientStatusArray['active']) ? 'checked="checked"' : '',
                 'NEWSLETTER_'.strtoupper($attributeName).'_REQUIRED'           =>  ($recipientStatusArray['active'] && $recipientStatusArray['required']) ? 'checked="checked"' : '',
                 'NEWSLETTER_'.strtoupper($attributeName).'_MANTOTRY_DISPLAY'   =>  ($recipientStatusArray['active']) ? 'block' : 'none',
            ));
        }

        $this->_objTpl->setVariable(array(
            'TXT_DISPATCH_SETINGS'          => $_ARRAYLANG['TXT_DISPATCH_SETINGS'],
            'TXT_NEWSLETTER_TEMPLATES' => $_ARRAYLANG['TXT_NEWSLETTER_TEMPLATES'],
            'TXT_NEWSLETTER_INTERFACE'      => $_ARRAYLANG['TXT_NEWSLETTER_INTERFACE'],
            'TXT_GENERATE_HTML'             => $_ARRAYLANG['TXT_GENERATE_HTML'],
            'TXT_ACTIVATE_MAIL'             => $_ARRAYLANG['TXT_NEWSLETTER_ACTIVATION_EMAIL'],
            'TXT_CONFIRM_MAIL'              => $_ARRAYLANG['TXT_NEWSLETTER_CONFIRMATION_EMAIL'],
            'TXT_NOTIFICATION_MAIL'         => $_ARRAYLANG['TXT_NEWSLETTER_NOTIFICATION_MAIL'],
            'TXT_NEWSLETTER_PROFILE_DETAILS' => $_ARRAYLANG['TXT_NEWSLETTER_PROFILE_DETAILS'],
            'TXT_NEWSLETTER_SALUTATION'     => $_ARRAYLANG['TXT_NEWSLETTER_SALUTATION'],
            'TXT_NEWSLETTER_TITLE'          => $_ARRAYLANG['TXT_NEWSLETTER_TITLE'],
            'TXT_NEWSLETTER_POSITION'       => $_ARRAYLANG['TXT_NEWSLETTER_POSITION'],
            'TXT_NEWSLETTER_COMPANY'        => $_ARRAYLANG['TXT_NEWSLETTER_COMPANY'],
            'TXT_NEWSLETTER_INDUSTRY_SECTOR' => $_ARRAYLANG['TXT_NEWSLETTER_INDUSTRY_SECTOR'],
            'TXT_NEWSLETTER_ADDRESS'        => $_ARRAYLANG['TXT_NEWSLETTER_ADDRESS'],
            'TXT_NEWSLETTER_PHONE_PRIVATE'  => $_ARRAYLANG['TXT_NEWSLETTER_PHONE_PRIVATE'],
            'TXT_NEWSLETTER_PHONE_MOBILE'   => $_ARRAYLANG['TXT_NEWSLETTER_PHONE_MOBILE'],
            'TXT_NEWSLETTER_FAX'            => $_ARRAYLANG['TXT_NEWSLETTER_FAX'],
            'TXT_NEWSLETTER_WEBSITE'        => $_ARRAYLANG['TXT_NEWSLETTER_WEBSITE'],
            'TXT_NEWSLETTER_EMAIL_ADDRESS'  => $_ARRAYLANG['TXT_NEWSLETTER_EMAIL_ADDRESS'],
            'TXT_NEWSLETTER_WEBSITE'        => $_ARRAYLANG['TXT_NEWSLETTER_WEBSITE'],
            'TXT_NEWSLETTER_SALUTATION'     => $_ARRAYLANG['TXT_NEWSLETTER_SALUTATION'],
            'TXT_NEWSLETTER_TITLE'          => $_ARRAYLANG['TXT_NEWSLETTER_TITLE'],
            'TXT_NEWSLETTER_SEX'            => $_ARRAYLANG['TXT_NEWSLETTER_SEX'],
            'TXT_NEWSLETTER_FEMALE'         => $_ARRAYLANG['TXT_NEWSLETTER_FEMALE'],
            'TXT_NEWSLETTER_MALE'           => $_ARRAYLANG['TXT_NEWSLETTER_MALE'],
            'TXT_NEWSLETTER_LASTNAME'       => $_ARRAYLANG['TXT_NEWSLETTER_LASTNAME'],
            'TXT_NEWSLETTER_FIRSTNAME'      => $_ARRAYLANG['TXT_NEWSLETTER_FIRSTNAME'],
            'TXT_NEWSLETTER_COMPANY'        => $_ARRAYLANG['TXT_NEWSLETTER_COMPANY'],
            'TXT_NEWSLETTER_ADDRESS'        => $_ARRAYLANG['TXT_NEWSLETTER_ADDRESS'],
            'TXT_NEWSLETTER_ZIP'            => $_ARRAYLANG['TXT_NEWSLETTER_ZIP'],
            'TXT_NEWSLETTER_CITY'           => $_ARRAYLANG['TXT_NEWSLETTER_CITY'],
            'TXT_NEWSLETTER_COUNTRY'        => $_ARRAYLANG['TXT_NEWSLETTER_COUNTRY'],
            'TXT_NEWSLETTER_PHONE'          => $_ARRAYLANG['TXT_NEWSLETTER_PHONE'],
            'TXT_NEWSLETTER_BIRTHDAY'       => $_ARRAYLANG['TXT_NEWSLETTER_BIRTHDAY'],
            'TXT_SAVE'                      => $_ARRAYLANG['TXT_SAVE'],
            'TXT_ACTIVE'                    => $_ARRAYLANG['TXT_ACTIVE'],
            'TXT_NEWSLETTER_MANDATORY_FIELD' => $_ARRAYLANG['TXT_NEWSLETTER_MANDATORY_FIELD'],
        ));


    }

    function ConfigDispatch()
    {
        global $objDatabase, $_ARRAYLANG;

        $this->_pageTitle = $_ARRAYLANG['TXT_SETTINGS'];
        $this->_objTpl->loadTemplateFile('newsletter_config_dispatch.html');
        $this->_objTpl->setVariable('TXT_TITLE', $_ARRAYLANG['TXT_DISPATCH_SETINGS']);

        if (isset($_POST["update"])) {
            $objDatabase->Execute("UPDATE ".DBPREFIX."module_newsletter_settings SET setvalue='".contrexx_addslashes($_POST['sender_email'])."' WHERE setname='sender_mail'");
            $objDatabase->Execute("UPDATE ".DBPREFIX."module_newsletter_settings SET setvalue='".contrexx_addslashes($_POST['sender_name'])."' WHERE setname='sender_name'");
            $objDatabase->Execute("UPDATE ".DBPREFIX."module_newsletter_settings SET setvalue='".contrexx_addslashes($_POST['return_path'])."' WHERE setname='reply_mail'");
            $objDatabase->Execute("UPDATE ".DBPREFIX."module_newsletter_settings SET setvalue='".intval($_POST['mails_per_run'])."' WHERE setname='mails_per_run'");
            //$objDatabase->Execute("UPDATE ".DBPREFIX."module_newsletter_settings SET setvalue='".contrexx_addslashes($_POST['bcc_mail'])."' WHERE setname='bcc_mail'");
            $objDatabase->Execute("UPDATE ".DBPREFIX."module_newsletter_settings SET setvalue='".contrexx_addslashes($_POST['test_mail'])."' WHERE setname='test_mail'");
            $objDatabase->Execute("UPDATE ".DBPREFIX."module_newsletter_settings SET setvalue='".intval($_POST['overview_entries'])."' WHERE setname='overview_entries_limit'");
            $objDatabase->Execute("UPDATE ".DBPREFIX."module_newsletter_settings SET setvalue='".intval($_POST['text_break_after'])."' WHERE setname='text_break_after'");

            $objDatabase->Execute("UPDATE ".DBPREFIX."module_newsletter_settings SET setvalue='".contrexx_addslashes($_POST['newsletter_rejected_mail_task'])."' WHERE setname='rejected_mail_operation'");
            $rejectText = contrexx_addslashes($_POST['reject_info_mail_text']);
            $objDatabase->Execute("
                INSERT INTO `".DBPREFIX."module_newsletter_settings`
                ( `setvalue`, `setname`, `status`)
                VALUES
                ('".$rejectText."', 'reject_info_mail_text', 1)
                ON DUPLICATE KEY UPDATE
                setvalue = '".$rejectText."'");
        }

        // Load Values
        $objSettings = $objDatabase->Execute("SELECT setname, setvalue FROM ".DBPREFIX."module_newsletter_settings");
        if ($objSettings !== false) {
            while (!$objSettings->EOF) {
                $arrSettings[$objSettings->fields['setname']] = $objSettings->fields['setvalue'];
                $objSettings->MoveNext();
            }
        }
        $this->_objTpl->setVariable(array(
            'TXT_SETTINGS' => $_ARRAYLANG['TXT_SETTINGS'],
            'TXT_SENDER' => $_ARRAYLANG['TXT_SENDER'],
            'TXT_LASTNAME' => $_ARRAYLANG['TXT_LASTNAME'],
            'TXT_RETURN_PATH' => $_ARRAYLANG['TXT_RETURN_PATH'],
            'TXT_SEND_LIMIT' => $_ARRAYLANG['TXT_SEND_LIMIT'],
            'TXT_SAVE' => $_ARRAYLANG['TXT_SAVE'],
            'TXT_FILL_OUT_ALL_REQUIRED_FIELDS' => $_ARRAYLANG['TXT_FILL_OUT_ALL_REQUIRED_FIELDS'],
            'TXT_WILDCART_INFOS' => $_ARRAYLANG['TXT_WILDCART_INFOS'],
            'TXT_USER_DATA' => $_ARRAYLANG["TXT_USER_DATA"],
            'TXT_EMAIL_ADDRESS' => $_ARRAYLANG['TXT_EMAIL_ADDRESS'],
            'TXT_LASTNAME' => $_ARRAYLANG['TXT_LASTNAME'],
            'TXT_FIRSTNAME' => $_ARRAYLANG['TXT_FIRSTNAME'],
            'TXT_NEWSLETTER_ADDRESS' => $_ARRAYLANG['TXT_NEWSLETTER_ADDRESS'],
            'TXT_ZIP' => $_ARRAYLANG['TXT_ZIP'],
            'TXT_CITY' => $_ARRAYLANG['TXT_CITY'],
            'TXT_COUNTRY' => $_ARRAYLANG['TXT_COUNTRY'],
            'TXT_PHONE' => $_ARRAYLANG['TXT_PHONE'],
            'TXT_BIRTHDAY' => $_ARRAYLANG['TXT_BIRTHDAY'],
            'TXT_GENERALLY' => $_ARRAYLANG['TXT_GENERALLY'],
            'TXT_DATE' => $_ARRAYLANG['TXT_DATE'],
            'TXT_NEWSLETTER_CONTENT' => $_ARRAYLANG['TXT_NEWSLETTER_CONTENT'],
            'TXT_CONFIRM_MAIL' => $_ARRAYLANG['TXT_NEWSLETTER_CONFIRMATION_EMAIL'],
            'TXT_NOTIFICATION_MAIL' => $_ARRAYLANG['TXT_NEWSLETTER_NOTIFICATION_MAIL'],
            'TXT_ACTIVATE_MAIL' => $_ARRAYLANG['TXT_NEWSLETTER_ACTIVATION_EMAIL'],
            'TXT_DISPATCH_SETINGS' => $_ARRAYLANG['TXT_DISPATCH_SETINGS'],
            'TXT_GENERATE_HTML' => $_ARRAYLANG['TXT_GENERATE_HTML'],
            'TXT_NEWSLETTER_TEMPLATES' => $_ARRAYLANG['TXT_NEWSLETTER_TEMPLATES'],
            'TXT_NEWSLETTER_INTERFACE' => $_ARRAYLANG['TXT_NEWSLETTER_INTERFACE'],
            'TXT_BREAK_AFTER' => $_ARRAYLANG['TXT_NEWSLETTER_BREAK_AFTER'],
            'TXT_TEST_MAIL' => $_ARRAYLANG['TXT_NEWSLETTER_TEST_RECIPIENT'],
            'TXT_FAILED' => $_ARRAYLANG['TXT_NEWSLETTER_FAILED'],
            'TXT_NEWSLETTER_INFO_ABOUT_ADMIN_INFORM' => $_ARRAYLANG['TXT_NEWSLETTER_INFO_ABOUT_ADMIN_INFORM'],
//            'TXT_BCC' => $_ARRAYLANG['TXT_NEWSLETTER_BCC'],
            'TXT_NEWSLETTER_OVERVIEW_ENTRIES' => $_ARRAYLANG['TXT_NEWSLETTER_OVERVIEW_ENTRIES'],
            'TXT_NEWSLETTER_REPLY_EMAIL' => $_ARRAYLANG['TXT_NEWSLETTER_REPLY_EMAIL'],
            'TXT_SYSTEM_SETINGS' => "System",
            'TXT_NEWSLETTER_DO_NOTING' => $_ARRAYLANG['TXT_NEWSLETTER_DO_NOTING'],
            'TXT_NEWSLETTER_TASK_REJECTED_EMAIL' => $_ARRAYLANG['TXT_NEWSLETTER_TASK_REJECTED_EMAIL'],
            'TXT_NEWSLETTER_DEACTIVATE_EMAIL' => $_ARRAYLANG['TXT_NEWSLETTER_DEACTIVATE_EMAIL'],
            'TXT_NEWSLETTER_DELETE_EMAIL_ADDRESS' => $_ARRAYLANG['TXT_NEWSLETTER_DELETE_EMAIL_ADDRESS'],
            'TXT_NEWSLETTER_INFORM_ADMIN' => $_ARRAYLANG['TXT_NEWSLETTER_INFORM_ADMIN'],
            'TXT_NEWSLETTER_REJECT_INFO_MAIL_TEXT' => $_ARRAYLANG['TXT_NEWSLETTER_REJECT_INFO_MAIL_TEXT'],
            'TXT_NEWSLETTER_INFO_ABOUT_INFORM_TEXT' => $_ARRAYLANG['TXT_NEWSLETTER_INFO_ABOUT_INFORM_TEXT'],

            'SENDERMAIL_VALUE' => htmlentities(
                $arrSettings['sender_mail'], ENT_QUOTES, CONTREXX_CHARSET),
            'SENDERNAME_VALUE' => htmlentities(
                $arrSettings['sender_name'], ENT_QUOTES, CONTREXX_CHARSET),
            'RETURNPATH_VALUE' => htmlentities(
                $arrSettings['reply_mail'], ENT_QUOTES, CONTREXX_CHARSET),
            'MAILSPERRUN_VALUE' => $arrSettings['mails_per_run'],
            //'BCC_VALUE' => htmlentities(
//                $arrSettings['bcc_mail'],
            'OVERVIEW_ENTRIES_VALUE' => $arrSettings['overview_entries_limit'],
            'TEST_MAIL_VALUE' => htmlentities(
                $arrSettings['test_mail'], ENT_QUOTES, CONTREXX_CHARSET),
            'BREAK_AFTER_VALUE' => htmlentities(
                $arrSettings['text_break_after'], ENT_QUOTES, CONTREXX_CHARSET),
            'NEWSLETTER_REJECTED_MAIL_IGNORE' =>
                ($arrSettings['rejected_mail_operation'] == 'ignore'
                    ? 'checked="checked"' : ''),
            'NEWSLETTER_REJECTED_MAIL_DEACTIVATE' =>
                ($arrSettings['rejected_mail_operation'] == 'deactivate'
                    ? 'checked="checked"' : ''),
            'NEWSLETTER_REJECTED_MAIL_DELETE' =>
                ($arrSettings['rejected_mail_operation'] == 'delete'
                    ? 'checked="checked"' : ''),
            'NEWSLETTER_REJECTED_MAIL_INFORM' =>
                ($arrSettings['rejected_mail_operation'] == 'inform'
                    ? 'checked="checked"' : ''),
            'NEWSLETTER_REJECT_INFO_MAIL_TEXT' => htmlentities(
                $arrSettings['reject_info_mail_text'], ENT_QUOTES, CONTREXX_CHARSET),
        ));

    }


    function _templates()
    {
        global $objDatabase, $_ARRAYLANG;

        $rowNr = 0;
        $this->_pageTitle = $_ARRAYLANG['TXT_NEWSLETTER_TEMPLATES'];
        $this->_objTpl->loadTemplateFile('module_newsletter_templates.html');
        $this->_objTpl->setVariable('TXT_TITLE', $_ARRAYLANG['TXT_NEWSLETTER_TEMPLATES']);

        $this->_objTpl->setVariable(array(
            'TXT_NEWSLETTER_CANNOT_UNDO_OPERATION' => $_ARRAYLANG['TXT_NEWSLETTER_CANNOT_UNDO_OPERATION'],
            'TXT_NEWSLETTER_CONFIRM_DELETE_TEMPLATE' => $_ARRAYLANG['TXT_NEWSLETTER_CONFIRM_DELETE_TEMPLATE'],
            'TXT_NEWSLETTER_TEMPLATES' => $_ARRAYLANG['TXT_NEWSLETTER_TEMPLATES'],
            'TXT_NEWSLETTER_ID_UC' => $_ARRAYLANG['TXT_NEWSLETTER_ID_UC'],
            'TXT_NEWSLETTER_NAME' => $_ARRAYLANG['TXT_NEWSLETTER_NAME'],
            'TXT_NEWSLETTER_DESCRIPTION' => $_ARRAYLANG['TXT_NEWSLETTER_DESCRIPTION'],
			'TXT_NEWSLETTER_TYPE' => $_ARRAYLANG['TXT_NEWSLETTER_TYPE'],
            'TXT_NEWSLETTER_FUNCTIONS' => $_ARRAYLANG['TXT_NEWSLETTER_FUNCTIONS'],
            'TXT_TEMPLATE_ADD_NEW_TEMPLATE' => $_ARRAYLANG['TXT_TEMPLATE_ADD_NEW_TEMPLATE'],
            'TXT_CONFIRM_MAIL' => $_ARRAYLANG['TXT_NEWSLETTER_CONFIRMATION_EMAIL'],
            'TXT_ACTIVATE_MAIL' => $_ARRAYLANG['TXT_NEWSLETTER_ACTIVATION_EMAIL'],
            'TXT_DISPATCH_SETINGS' => $_ARRAYLANG['TXT_DISPATCH_SETINGS'],
            'TXT_GENERATE_HTML' => $_ARRAYLANG['TXT_GENERATE_HTML'],
            'TXT_SYSTEM_SETINGS' => "System",
            'TXT_NOTIFICATION_MAIL' => $_ARRAYLANG['TXT_NEWSLETTER_NOTIFICATION_MAIL'],
            'TXT_NEWSLETTER_INTERFACE' => $_ARRAYLANG['TXT_NEWSLETTER_INTERFACE'],
            'TXT_NEWSLETTER_TEMPLATES' => $_ARRAYLANG['TXT_NEWSLETTER_TEMPLATES'],
        ));

        $this->_objTpl->setGlobalVariable(array(
            'TXT_NEWSLETTER_MODIFY_TEMPLATE' => $_ARRAYLANG['TXT_NEWSLETTER_MODIFY_TEMPLATE'],
            'TXT_NEWSLETTER_DELETE_TEMPLATE' => $_ARRAYLANG['TXT_NEWSLETTER_DELETE_TEMPLATE']
        ));

        $objTemplate = $objDatabase->Execute("SELECT id, name, required, description, type FROM ".DBPREFIX."module_newsletter_template ORDER BY id DESC");
        if ($objTemplate !== false) {
            while (!$objTemplate->EOF) {
                if ($objTemplate->fields['required'] == 0) {
                    $this->_objTpl->touchBlock('newsletter_template_delete');
                    $this->_objTpl->hideBlock('newsletter_templalte_spacer');
                } else {
                    $this->_objTpl->hideBlock('newsletter_template_delete');
                    $this->_objTpl->touchBlock('newsletter_templalte_spacer');
                }

				switch ($objTemplate->fields['type']) {
					case 'e-mail':
						$type = $_ARRAYLANG['TXT_NEWSLETTER_TYPE_EMAIL'];
						break;
					case 'news':
						$type = $_ARRAYLANG['TXT_NEWSLETTER_TYPE_NEWS_IMPORT'];
						break;
				}

                $this->_objTpl->setVariable(array(
                    'NEWSLETTER_TEMPLATE_ROW_CLASS' => $rowNr % 2 == 1 ? 'row1' : 'row2',
                    'NEWSLETTER_TEMPLATE_ID' => $objTemplate->fields['id'],
                    'NEWSLETTER_TEMPLATE_NAME' => htmlentities($objTemplate->fields['name'], ENT_QUOTES, CONTREXX_CHARSET),
                    'NEWSLETTER_TEMPLATE_NAME_JS' => htmlentities(addslashes($objTemplate->fields['name']), ENT_QUOTES, CONTREXX_CHARSET),
                    'NEWSLETTER_TEMPLATE_DESCRIPTION' => htmlentities($objTemplate->fields['description'], ENT_QUOTES, CONTREXX_CHARSET),
					'NEWSLETTER_TEMPLATE_TYPE' => $type
                ));

                $rowNr++;
                $this->_objTpl->parse("templates_row");
                $objTemplate->MoveNext();
            }
        }
    }


    function _updateTemplate($id, $name, $description, $html, $type)
    {
        global $objDatabase;
        if ($objDatabase->Execute("UPDATE ".DBPREFIX."module_newsletter_template SET name='".addslashes($name)."', description='".addslashes($description)."', html='".addslashes($html)."', type='".$type."' WHERE id=".$id) !== false) {
            return true;
        } else {
             return false;
        }
    }


    function _addTemplate($name, $description, $html, $type)
    {
        global $objDatabase;
        if ($objDatabase->Execute("INSERT INTO ".DBPREFIX."module_newsletter_template (`name`, `description`, `html`, `type`) VALUES ('".addslashes($name)."', '".addslashes($description)."', '".addslashes($html)."', '".$type."')") !== false) {
            return true;
        } else {
             return false;
        }
    }


    function _editTemplate()
    {
        global $objDatabase, $_ARRAYLANG;

		JS::activate('cx');

        $id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
        $name = '';
        $description = '';
		$type = '';
		$html = "<html>\n<head>\n<title>[[subject]]</title>\n</head>\n<body>\n[[content]]\n<br />\n<br />\n[[profile_setup]]\n[[unsubscribe]]\n</body>\n</html>";
        $saveStatus = true;

        if (isset($_POST['newsletter_template_save'])) {
            if (!empty($_POST['template_edit_name'])) {
                $name = contrexx_stripslashes($_POST['template_edit_name']);
            } else {
                $saveStatus = false;
                self::$strErrMessage .= $_ARRAYLANG['TXT_NEWSLETTER_DEFINE_TEMPLATE_NAME']."<br />";
            }

            if (isset($_POST['template_edit_description'])) {
                $description = contrexx_stripslashes($_POST['template_edit_description']);
            }

			if (isset($_POST['template_edit_type'])) {
                $type = contrexx_stripslashes($_POST['template_edit_type']);
            }

            if (isset($_POST['template_edit_html'])) {
                $html = contrexx_stripslashes($_POST['template_edit_html']);
            }
            $arrContentMatches = array();
            if (preg_match_all('/\[\[content\]\]/', $html, $arrContentMatches) ) {
                if (count($arrContentMatches[0]) > 1) {
                    $saveStatus = false;
                    self::$strErrMessage .= $_ARRAYLANG['TXT_NEWSLETTER_MAX_CONTENT_PLACEHOLDER_HTML_MSG']."<br />";
                }
			} elseif ($type != 'news') {
                $saveStatus = false;
                self::$strErrMessage .= $_ARRAYLANG['TXT_NEWSLETTER_MIN_CONTENT_PLACEHOLDER_HTML_MSG']."<br />";
            }

            if ($saveStatus) {
                $objTemplate = $objDatabase->SelectLimit("SELECT id FROM ".DBPREFIX."module_newsletter_template WHERE id!=".$id." AND name='".addslashes($name)."' AND type='".$type."'", 1);
                if ($objTemplate !== false && $objTemplate->RecordCount() == 0) {
                    if ($id > 0) {
                        $this->_updateTemplate($id, $name, $description, $html, $type);
                    } else {
                        $this->_addTemplate($name, $description, $html, $type);
                    }

                    return $this->_templates();
                } else {
                    self::$strErrMessage = $_ARRAYLANG['TXT_NEWSLETTER_DUPLICATE_LIST_NAME_MSG'];
                }
            }
        } elseif ($id > 0) {
            $objTemplate = $objDatabase->SelectLimit("SELECT id, name, description, html, type FROM ".DBPREFIX."module_newsletter_template WHERE id=".$id, 1);
            if ($objTemplate !== false && $objTemplate->RecordCount() == 1) {
                $name = $objTemplate->fields['name'];
                $description = $objTemplate->fields['description'];
				$type = $objTemplate->fields['type'];
                $html = $objTemplate->fields['html'];
            }
        }

		switch ($type) {
			case 'e-mail':
				$newsImportDirectoryDisplay = 'none';
				$emailDirectoryDisplay = 'table-row-group';
				break;
			case 'news':
				$newsImportDirectoryDisplay = 'table-row-group';
				$emailDirectoryDisplay = 'none';
				break;
			default:
				$newsImportDirectoryDisplay = 'none';
				$emailDirectoryDisplay = 'table-row-group';
				break;
		}

		$typeOps = "<option value=\"e-mail\"".($type=='e-mail' ? " selected" : "").">".$_ARRAYLANG['TXT_NEWSLETTER_TYPE_EMAIL']."</option>\n";
		$typeOps .= "<option value=\"news\"".($type=='news' ? " selected" : "").">".$_ARRAYLANG['TXT_NEWSLETTER_TYPE_NEWS_IMPORT']."</option>\n";

        $this->_pageTitle = $_ARRAYLANG['TXT_NEWSLETTER_TEMPLATES'];
        $this->_objTpl->loadTemplateFile('module_newsletter_template_edit.html');

        $this->_objTpl->setVariable(array(
            'TXT_NEWSLETTER_PLACEHOLDER_DIRECTORY' => $_ARRAYLANG['TXT_NEWSLETTER_PLACEHOLDER_DIRECTORY'],
            'TXT_NEWSLETTER_NAME' => $_ARRAYLANG['TXT_NEWSLETTER_NAME'],
            'TXT_NEWSLETTER_TYPE' => $_ARRAYLANG['TXT_NEWSLETTER_TYPE'],
            'TXT_NEWSLETTER_DESCRIPTION' => $_ARRAYLANG['TXT_NEWSLETTER_DESCRIPTION'],
            'TXT_NEWSLETTER_HTML_TEMPLATE' => $_ARRAYLANG['TXT_NEWSLETTER_HTML_TEMPLATE'],
            'TXT_NEWSLETTER_TEXT_TEMPLATE' => $_ARRAYLANG['TXT_NEWSLETTER_TEXT_TEMPLATE'],
            'TXT_NEWSLETTER_BACK' => $_ARRAYLANG['TXT_NEWSLETTER_BACK'],
            'TXT_NEWSLETTER_SAVE' => $_ARRAYLANG['TXT_NEWSLETTER_SAVE'],
            'TXT_NEWSLETTER_USER_DATA' => $_ARRAYLANG['TXT_NEWSLETTER_USER_DATA'],
            'TXT_NEWSLETTER_EMAIL_ADDRESS' => $_ARRAYLANG['TXT_NEWSLETTER_EMAIL_ADDRESS'],
            'TXT_NEWSLETTER_URI' => $_ARRAYLANG['TXT_NEWSLETTER_URI'],
            'TXT_NEWSLETTER_SEX' => $_ARRAYLANG['TXT_NEWSLETTER_SEX'],
            'TXT_NEWSLETTER_TITLE' => $_ARRAYLANG['TXT_NEWSLETTER_TITLE'],
            'TXT_NEWSLETTER_LASTNAME' => $_ARRAYLANG['TXT_NEWSLETTER_LASTNAME'],
            'TXT_NEWSLETTER_FIRSTNAME' => $_ARRAYLANG['TXT_NEWSLETTER_FIRSTNAME'],
            'TXT_NEWSLETTER_ADDRESS' => $_ARRAYLANG['TXT_NEWSLETTER_ADDRESS'],
            'TXT_NEWSLETTER_ZIP' => $_ARRAYLANG['TXT_NEWSLETTER_ZIP'],
            'TXT_NEWSLETTER_CITY' => $_ARRAYLANG['TXT_NEWSLETTER_CITY'],
            'TXT_NEWSLETTER_COUNTRY' => $_ARRAYLANG['TXT_NEWSLETTER_COUNTRY'],
            'TXT_NEWSLETTER_PHONE' => $_ARRAYLANG['TXT_NEWSLETTER_PHONE'],
            'TXT_NEWSLETTER_BIRTHDAY' => $_ARRAYLANG['TXT_NEWSLETTER_BIRTHDAY'],
            'TXT_NEWSLETTER_GENERAL' => $_ARRAYLANG['TXT_NEWSLETTER_GENERAL'],
            'TXT_NEWSLETTER_CONTENT' => $_ARRAYLANG['TXT_NEWSLETTER_CONTENT'],
            'TXT_NEWSLETTER_PROFILE_SETUP' => $_ARRAYLANG['TXT_NEWSLETTER_PROFILE_SETUP'],
            'TXT_NEWSLETTER_UNSUBSCRIBE' => $_ARRAYLANG['TXT_NEWSLETTER_UNSUBSCRIBE'],
            'TXT_NEWSLETTER_PLACEHOLDER_NOT_ON_BROWSER_VIEW' => $_ARRAYLANG['TXT_NEWSLETTER_PLACEHOLDER_NOT_ON_BROWSER_VIEW'],
            'TXT_NEWSLETTER_DATE' => $_ARRAYLANG['TXT_NEWSLETTER_DATE'],
            'TXT_NEWSLETTER_DISPLAY_IN_BROWSER_LINK' => $_ARRAYLANG['TXT_NEWSLETTER_DISPLAY_IN_BROWSER_LINK'],
			'TXT_NEWSLETTER_NEWS_IMPORT' => $_ARRAYLANG['TXT_NEWSLETTER_NEWS_IMPORT'],
            'TXT_NEWSLETTER_NEWS_DATE' => $_ARRAYLANG['TXT_NEWSLETTER_NEWS_DATE'],
            'TXT_NEWSLETTER_NEWS_LONG_DATE' => $_ARRAYLANG['TXT_NEWSLETTER_NEWS_LONG_DATE'],
            'TXT_NEWSLETTER_NEWS_TITLE' => $_ARRAYLANG['TXT_NEWSLETTER_NEWS_TITLE'],
            'TXT_NEWSLETTER_NEWS_URL' => $_ARRAYLANG['TXT_NEWSLETTER_NEWS_URL'],
			'TXT_NEWSLETTER_NEWS_IMAGE_PATH' => $_ARRAYLANG['TXT_NEWSLETTER_NEWS_IMAGE_PATH'],
			'TXT_NEWSLETTER_NEWS_TEASER_TEXT' => $_ARRAYLANG['TXT_NEWSLETTER_NEWS_TEASER_TEXT'],
			'TXT_NEWSLETTER_NEWS_TEXT' => $_ARRAYLANG['TXT_NEWSLETTER_NEWS_TEXT'],
            'TXT_NEWSLETTER_NEWS_AUTHOR' => $_ARRAYLANG['TXT_NEWSLETTER_NEWS_AUTHOR'],
			'TXT_NEWSLETTER_NEWS_TYPE_NAME' => $_ARRAYLANG['TXT_NEWSLETTER_NEWS_TYPE_NAME'],
			'TXT_NEWSLETTER_NEWS_CATEGORY_NAME' => $_ARRAYLANG['TXT_NEWSLETTER_NEWS_CATEGORY_NAME'],
            'TXT_CONFIRM_MAIL' => $_ARRAYLANG['TXT_NEWSLETTER_CONFIRMATION_EMAIL'],
            'TXT_ACTIVATE_MAIL' => $_ARRAYLANG['TXT_NEWSLETTER_ACTIVATION_EMAIL'],
            'TXT_DISPATCH_SETINGS' => $_ARRAYLANG['TXT_DISPATCH_SETINGS'],
            'TXT_GENERATE_HTML' => $_ARRAYLANG['TXT_GENERATE_HTML'],
            'TXT_SYSTEM_SETINGS' => "System",
            'TXT_NOTIFICATION_MAIL' => $_ARRAYLANG['TXT_NEWSLETTER_NOTIFICATION_MAIL'],
            'TXT_NEWSLETTER_INTERFACE' => $_ARRAYLANG['TXT_NEWSLETTER_INTERFACE'],
            'TXT_NEWSLETTER_TEMPLATES' => $_ARRAYLANG['TXT_NEWSLETTER_TEMPLATES'],
        ));

        $this->_objTpl->setVariable(array(
            'NEWSLETTER_TEMPLATE_ID' => $id,
            'NEWSLETTER_TEMPLATE_NAME' => htmlentities($name, ENT_QUOTES, CONTREXX_CHARSET),
            'NEWSLETTER_TEMPLATE_DESCRIPTION' => htmlentities($description, ENT_QUOTES, CONTREXX_CHARSET),
			'NEWSLETTER_TEMPLATE_TYPE' => $type,
            'NEWSLETTER_TEMPLATE_HTML' => new \Cx\Core\Wysiwyg\Wysiwyg('template_edit_html', contrexx_raw2xhtml($html), 'fullpage'),
            'NEWSLETTER_TEMPLATE_TITLE_TEXT' => $id > 0 ? $_ARRAYLANG['TXT_NEWSLETTER_MODIFY_TEMPLATE'] : $_ARRAYLANG['TXT_NEWSLETTER_TEMPLATE_ADD'],
			'NEWSLETTER_TEMPLATE_TYPE_MENU' => $typeOps,
			'NEWSLETTER_TEMPLATE_NEWS_IMPORT_DIRECTORY_DISPLAY' => $newsImportDirectoryDisplay,
			'NEWSLETTER_TEMPLATE_NEWS_EMAIL_DIRECTORY_DISPLAY' => $emailDirectoryDisplay
        ));
        return true;
    }


    function delTemplate()
    {
        global $objDatabase, $_ARRAYLANG;

        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($id > 0) {
            $objResult = $objDatabase->SelectLimit("SELECT id FROM ".DBPREFIX."module_newsletter WHERE template=".$id, 1);
            if ($objResult !== false) {
                if ($objResult->RecordCount() == 1) {
                    self::$strErrMessage = $_ARRAYLANG['TXT_NEWSLETTER_TEMPLATE_STILL_IN_USE'];
                    return false;
                } else {
                    if ($objDatabase->Execute("DELETE FROM ".DBPREFIX."module_newsletter_template WHERE required=0 AND id=".$id) !== false) {
                        self::$strOkMessage = $_ARRAYLANG['TXT_NEWSLETTER_TEMPLATE_DELETED'];
                        return true;
                    }
                }
            }
        }

        self::$strErrMessage = $_ARRAYLANG['TXT_NEWSLETTER_TEMPLATE_DELETE_ERROR'];
        return false;
    }


    function ActivateMail()
    {
        global $objDatabase, $_ARRAYLANG;

        $this->_pageTitle = $_ARRAYLANG['TXT_SETTINGS'];
        $this->_objTpl->loadTemplateFile('newsletter_config_activatemail.html');
        $this->_objTpl->setVariable('TXT_TITLE', $_ARRAYLANG['TXT_DISPATCH_SETINGS']);

        if (isset($_POST["update"])) {
            if ($objDatabase->Execute("
                UPDATE ".DBPREFIX."module_newsletter_confirm_mail
                   SET title='".contrexx_addslashes($_POST["mailSubject"])."',
                       content='".contrexx_addslashes($_POST["mailContent"])."'
                 WHERE id=1")) {
                self::$strOkMessage = $_ARRAYLANG['TXT_DATA_RECORD_STORED_SUCCESSFUL'];
            } else {
                self::$strErrMessage = $_ARRAYLANG['TXT_DATABASE_ERROR'];
            }
        }

        $query         = "SELECT id, title, content FROM ".DBPREFIX."module_newsletter_confirm_mail WHERE id='1'";
        $objResult     = $objDatabase->Execute($query);
        if ($objResult !== false) {
            $subject = $objResult->fields['title'];
            $content = $objResult->fields['content'];
        }

        $this->_objTpl->setVariable(array(
            'TXT_LASTNAME' => $_ARRAYLANG['TXT_LASTNAME'],
            'TXT_WILDCART_INFOS' => $_ARRAYLANG['TXT_WILDCART_INFOS'],
            'TXT_NEWSLETTER_SEX' => $_ARRAYLANG['TXT_NEWSLETTER_SEX'],
            'TXT_U_TITLE' => $_ARRAYLANG['TXT_NEWSLETTER_TITLE'],
            'TXT_FIRSTNAME' => $_ARRAYLANG['TXT_NEWSLETTER_FIRSTNAME'],
            'TXT_DATE' => $_ARRAYLANG['TXT_NEWSLETTER_REGISTRATION_DATE'],
            'TXT_CONTENT' => $_ARRAYLANG['TXT_NEWSLETTER_CONTENT'],
            'TXT_SUBJECT' => $_ARRAYLANG['TXT_NEWSLETTER_SUBJECT'],
            'TXT_TEXT' => $_ARRAYLANG['TXT_NEWSLETTER_TEXT'],
            'TXT_URL' => $_ARRAYLANG['TXT_NEWSLETTER_URL'],
            'TXT_CONFIRMMAIL' => $_ARRAYLANG['TXT_NEWSLETTER_ACTIVATION_EMAIL'],
            'TXT_CODE' => $_ARRAYLANG['TXT_NEWSLETTER_ACTIVATION_CODE'],
            'TXT_SAVE' => $_ARRAYLANG['TXT_SAVE'],
            'MAIL_SUBJECT' => $subject,
            'MAIL_CONTENT' => $content,
            'TXT_CONFIRM_MAIL' => $_ARRAYLANG['TXT_NEWSLETTER_CONFIRMATION_EMAIL'],
            'TXT_ACTIVATE_MAIL' => $_ARRAYLANG['TXT_NEWSLETTER_ACTIVATION_EMAIL'],
            'TXT_DISPATCH_SETINGS' => $_ARRAYLANG['TXT_DISPATCH_SETINGS'],
            'TXT_GENERATE_HTML' => $_ARRAYLANG['TXT_GENERATE_HTML'],
            'TXT_SYSTEM_SETINGS' => "System",
            'TXT_NOTIFICATION_MAIL' => $_ARRAYLANG['TXT_NEWSLETTER_NOTIFICATION_MAIL'],
            'TXT_NEWSLETTER_TEMPLATES' => $_ARRAYLANG['TXT_NEWSLETTER_TEMPLATES'],
            'TXT_NEWSLETTER_INTERFACE' => $_ARRAYLANG['TXT_NEWSLETTER_INTERFACE'],
        ));
    }


    function ConfirmMail() {
        global $objDatabase, $_ARRAYLANG;
        $this->_pageTitle = $_ARRAYLANG['TXT_SETTINGS'];
        $this->_objTpl->loadTemplateFile('newsletter_config_confirmmail.html');
        $this->_objTpl->setVariable('TXT_TITLE', $_ARRAYLANG['TXT_DISPATCH_SETINGS']);

        //Update
        if (isset($_POST["update"])) {
            if ($objDatabase->Execute("UPDATE ".DBPREFIX."module_newsletter_confirm_mail SET title='".contrexx_addslashes($_POST["mailSubject"])."', content='".contrexx_addslashes($_POST["mailContent"])."' WHERE id=2") !== false) {
                self::$strOkMessage = $_ARRAYLANG['TXT_NEWSLETTER_CONFIRM_MAIL_UPDATED_SUCCESSFULLY'];
            } else {
                self::$strErrMessage = $_ARRAYLANG['TXT_NEWSLETTER_ERROR_SAVE_CONFIRM_MAIL'];
            }
        }

        $query         = "SELECT id, title, content FROM ".DBPREFIX."module_newsletter_confirm_mail WHERE id='2'";
        $objResult     = $objDatabase->Execute($query);
        if ($objResult !== false) {
            $subject = $objResult->fields['title'];
            $content = $objResult->fields['content'];
        }

        $this->_objTpl->setVariable(array(
            'TXT_LASTNAME' => $_ARRAYLANG['TXT_NEWSLETTER_LASTNAME'],
            'TXT_WILDCART_INFOS' => $_ARRAYLANG['TXT_WILDCART_INFOS'],
            'TXT_U_TITLE' => $_ARRAYLANG['TXT_NEWSLETTER_TITLE'],
            'TXT_NEWSLETTER_SEX' => $_ARRAYLANG['TXT_NEWSLETTER_SEX'],
            'TXT_FIRSTNAME' => $_ARRAYLANG['TXT_NEWSLETTER_FIRSTNAME'],
            'TXT_DATE' => $_ARRAYLANG['TXT_NEWSLETTER_DATE'],
            'TXT_CONTENT' => $_ARRAYLANG['TXT_NEWSLETTER_CONTENT'],
            'TXT_SUBJECT' => $_ARRAYLANG['TXT_NEWSLETTER_SUBJECT'],
            'TXT_TEXT' => $_ARRAYLANG['TXT_NEWSLETTER_TEXT'],
            'TXT_URL' => $_ARRAYLANG['TXT_NEWSLETTER_URL'],
            'TXT_CONFIRMMAIL' => $_ARRAYLANG['TXT_NEWSLETTER_ACTIVATION_EMAIL'],
            'TXT_SAVE' => $_ARRAYLANG['TXT_SAVE'],
            'MAIL_SUBJECT' => $subject,
            'MAIL_CONTENT' => $content,
            'TXT_CONFIRM_MAIL' => $_ARRAYLANG['TXT_NEWSLETTER_CONFIRMATION_EMAIL'],
            'TXT_ACTIVATE_MAIL' => $_ARRAYLANG['TXT_NEWSLETTER_ACTIVATION_EMAIL'],
            'TXT_DISPATCH_SETINGS' => $_ARRAYLANG['TXT_DISPATCH_SETINGS'],
            'TXT_GENERATE_HTML' => $_ARRAYLANG['TXT_GENERATE_HTML'],
            'TXT_SYSTEM_SETINGS' => "System",
            'TXT_NOTIFICATION_MAIL' => $_ARRAYLANG['TXT_NEWSLETTER_NOTIFICATION_MAIL'],
            'TXT_NEWSLETTER_TEMPLATES' => $_ARRAYLANG['TXT_NEWSLETTER_TEMPLATES'],
            'TXT_NEWSLETTER_INTERFACE' => $_ARRAYLANG['TXT_NEWSLETTER_INTERFACE'],
        ));
    }


    function NotificationMail()
    {
        global $objDatabase, $_ARRAYLANG;

        $this->_pageTitle = $_ARRAYLANG['TXT_SETTINGS'];
        $this->_objTpl->loadTemplateFile('newsletter_config_notificationmail.html');
        $this->_objTpl->setVariable('TXT_TITLE', $_ARRAYLANG['TXT_DISPATCH_SETINGS']);

        //Update
        if (isset($_POST["update"])) {
            if ($objDatabase->Execute("UPDATE ".DBPREFIX."module_newsletter_confirm_mail SET title='".contrexx_addslashes($_POST["mailSubject"])."', content='".contrexx_addslashes($_POST["mailContent"])."', recipients='".contrexx_addslashes($_POST["mailRecipients"])."' WHERE id=3") !== false) {
                 if ($objDatabase->Execute("UPDATE ".DBPREFIX."module_newsletter_settings SET setvalue='".intval($_POST["mailSendSubscribe"])."' WHERE setname='notificationSubscribe'") !== false) {
                    if ($objDatabase->Execute("UPDATE ".DBPREFIX."module_newsletter_settings SET setvalue='".intval($_POST["mailSendUnsubscribe"])."' WHERE setname='notificationUnsubscribe'") !== false) {
                        self::$strOkMessage = $_ARRAYLANG['TXT_NEWSLETTER_CONFIRM_MAIL_UPDATED_SUCCESSFULLY'];
                    } else {
                        self::$strErrMessage = $_ARRAYLANG['TXT_NEWSLETTER_ERROR_SAVE_CONFIRM_MAIL'];
                    }
                } else {
                    self::$strErrMessage = $_ARRAYLANG['TXT_NEWSLETTER_ERROR_SAVE_CONFIRM_MAIL'];
                }
            } else {
                self::$strErrMessage = $_ARRAYLANG['TXT_NEWSLETTER_ERROR_SAVE_CONFIRM_MAIL'];
            }
        }

        $query         = "SELECT id, title, content, recipients FROM ".DBPREFIX."module_newsletter_confirm_mail WHERE id='3'";
        $objResult     = $objDatabase->Execute($query);
        if ($objResult !== false) {
            $subject = $objResult->fields['title'];
            $content = $objResult->fields['content'];
            $recipients = $objResult->fields['recipients'];
        }

        $query         = "SELECT setvalue FROM ".DBPREFIX."module_newsletter_settings WHERE setname='notificationSubscribe'";
        $objResult     = $objDatabase->Execute($query);
        if ($objResult !== false) {
            if ($objResult->fields['setvalue'] == 1) {
                $sendBySubscribeOn = 'checked="checked"';
                $sendBySubscribeOff = '';
            } else {
                $sendBySubscribeOn = '';
                $sendBySubscribeOff = 'checked="checked"';
            }
        }

        $query         = "SELECT setvalue FROM ".DBPREFIX."module_newsletter_settings WHERE setname='notificationUnsubscribe'";
        $objResult     = $objDatabase->Execute($query);
        if ($objResult !== false) {
            if ($objResult->fields['setvalue'] == 1) {
                $sendByUnsubscribeOn = 'checked="checked"';
                $sendByUnsubscribeOff = '';
            } else {
                $sendByUnsubscribeOn = '';
                $sendByUnsubscribeOff = 'checked="checked"';
            }
        }

        $this->_objTpl->setVariable(array(
            'TXT_WILDCART_INFOS' => $_ARRAYLANG['TXT_WILDCART_INFOS'],
            'TXT_RECIPIENTS' => $_ARRAYLANG['TXT_NEWSLETTER_RECIPIENTS'],
            'TXT_DATE' => $_ARRAYLANG['TXT_NEWSLETTER_DATE'],
            'TXT_CONTENT' => $_ARRAYLANG['TXT_NEWSLETTER_CONTENT'],
            'TXT_SUBJECT' => $_ARRAYLANG['TXT_NEWSLETTER_SUBJECT'],
            'TXT_TEXT' => $_ARRAYLANG['TXT_NEWSLETTER_TEXT'],
            'TXT_URL' => $_ARRAYLANG['TXT_NEWSLETTER_URL'],
            'TXT_CONFIRMMAIL' => $_ARRAYLANG['TXT_NEWSLETTER_ACTIVATION_EMAIL'],
            'TXT_SAVE' => $_ARRAYLANG['TXT_SAVE'],
            'MAIL_SUBJECT' => $subject,
            'MAIL_CONTENT' => $content,
            'MAIL_RECIPIENTS' => $recipients,
            'SEND_BY_SUBSCRIBE_ON' => $sendBySubscribeOn,
            'SEND_BY_SUBSCRIBE_OFF' => $sendBySubscribeOff,
            'SEND_BY_UNSUBSCRIBE_ON' => $sendByUnsubscribeOn,
            'SEND_BY_UNSUBSCRIBE_OFF' => $sendByUnsubscribeOff,
            'TXT_CONFIRM_MAIL' => $_ARRAYLANG['TXT_NEWSLETTER_CONFIRMATION_EMAIL'],
            'TXT_ACTIVATE_MAIL' => $_ARRAYLANG['TXT_NEWSLETTER_ACTIVATION_EMAIL'],
            'TXT_DISPATCH_SETINGS' => $_ARRAYLANG['TXT_DISPATCH_SETINGS'],
            'TXT_GENERATE_HTML' => $_ARRAYLANG['TXT_GENERATE_HTML'],
            'TXT_SYSTEM_SETINGS' => "System",
            'TXT_NOTIFICATION_MAIL' => $_ARRAYLANG['TXT_NEWSLETTER_NOTIFICATION_MAIL'],
            'TXT_NOTIFICATION_SETTINGS' => $_ARRAYLANG['TXT_SETTINGS'],
            'TXT_SEND_BY_SUBSCRIBE' => $_ARRAYLANG['TXT_NEWSLETTER_NOTIFICATION_SEND_BY_SUBSCRIBE'],
            'TXT_SEND_BY_UNSUBSCRIBE' => $_ARRAYLANG['TXT_NEWSLETTER_NOTIFICATION_SEND_BY_UNSUBSCRIBE'],
            'TXT_ACTION' => $_ARRAYLANG['TXT_NEWSLETTER_NOTIFICATION_ACTION'],
            'TXT_NOTIFICATION_ACTIVATE' => $_ARRAYLANG['TXT_NEWSLETTER_ACTIVATE'],
            'TXT_NOTIFICATION_DEACTIVATE' => $_ARRAYLANG['TXT_NEWSLETTER_DEACTIVATE'],
            'TXT_SEX' => $_ARRAYLANG['TXT_NEWSLETTER_SEX'],
            'TXT_TITLE' => $_ARRAYLANG['TXT_NEWSLETTER_TITLE'],
            'TXT_FIRSTNAME' => $_ARRAYLANG['TXT_NEWSLETTER_FIRSTNAME'],
            'TXT_LASTNAME' => $_ARRAYLANG['TXT_NEWSLETTER_LASTNAME'],
            'TXT_E-MAIL' => $_ARRAYLANG['TXT_EMAIL'],
            'TXT_NEWSLETTER_TEMPLATES' => $_ARRAYLANG['TXT_NEWSLETTER_TEMPLATES'],
            'TXT_NEWSLETTER_INTERFACE' => $_ARRAYLANG['TXT_NEWSLETTER_INTERFACE'],
        ));
    }


    /**
     * Show the mail send page
     */
    function _sendMailPage()
    {
        global $_ARRAYLANG;

        JS::activate('cx');

        if (isset($_POST['newsletter_mail_edit'])) {
            return $this->_editMail();
        } elseif (!isset($_REQUEST['id'])) {
            return $this->_mails();
        }

        $mailId = intval($_REQUEST['id']);
        $this->_pageTitle = $_ARRAYLANG['TXT_NEWSLETTER_SEND_EMAIL'];

        $this->_objTpl->loadTemplateFile('module_newsletter_mail_send.html');

        if (isset($_POST['newsletter_mail_send_test'])) {
            $status = $this->_sendTestMail($mailId);
        } else {
            $status = true;
        }

        if ((isset($_GET['testSent']) || isset($_POST['test_sent'])) && $status) {
            $this->_objTpl->setVariable(array(
                'TXT_NEWSLETTER_SEND_TESTMAIL_FIRST' => '',
                'NEWSLETTER_TESTMAIL_SENT2' => 'test_sent'
            ));
            $this->_objTpl->touchBlock("bulkSend");
        } else {
            $this->_objTpl->setVariable(array(
                "NEWSLETTER_TESTMAIL_SENT" => "&amp;testSent=1",
                'TXT_NEWSLETTER_SEND_TESTMAIL_FIRST' => $_ARRAYLANG['TXT_NEWSLETTER_SEND_TESTMAIL_FIRST']
            ));
            $this->_objTpl->hideBlock("bulkSend");
        }

        $arrSettings = $this->_getSettings();
        $testmail = $arrSettings['test_mail']['setvalue'];

        $this->_objTpl->setVariable(array(
            'TXT_NEWSLETTER_EMAIL_ADDRESS' => $_ARRAYLANG['TXT_NEWSLETTER_EMAIL_ADDRESS'],
            'TXT_NEWSLETTER_SEND' => $_ARRAYLANG['TXT_NEWSLETTER_SEND'],
            'TXT_SEND_TEST_EMAIL' => $_ARRAYLANG['TXT_SEND_TEST_EMAIL'],
            'TXT_NEWSLETTER_MODIFY_EMAIL' => $_ARRAYLANG['TXT_NEWSLETTER_MODIFY_EMAIL'],
            'TXT_NEWSLETTER_NOTICE_TESTMAIL' => $_ARRAYLANG['TXT_NEWSLETTER_NOTICE_TESTMAIL'],
            'TXT_NEWSLETTER_NOTICE' => $_ARRAYLANG['TXT_NEWSLETTER_NOTICE'],
        ));

        $this->_objTpl->setVariable(array(
            'NEWSLETTER_MAIL_ID' => $mailId,
            'NEWSLETTER_MAIL_TEST_EMAIL' => $testmail
        ));

        if ($status) {
            $mailRecipientCount = $this->_getMailRecipientCount($mailId);
            if ($mailRecipientCount > 0) {
				$this->_sendMail();
                $this->_objTpl->touchBlock('newsletter_mail_send_status');
                $this->_objTpl->hideBlock('newsletter_mail_list_required');
            } else {
                $this->_objTpl->setVariable(array(
                    'TXT_NEWSLETTER_MAIL_LIST_REQUIRED_TXT' => $_ARRAYLANG['TXT_CATEGORY_ERROR']
                ));

                $this->_objTpl->touchBlock('newsletter_mail_list_required');
                $this->_objTpl->hideBlock('newsletter_mail_send_status');
            }
        }
        return true;
    }


    function _sendTestMail($mailId)
    {
        global $_ARRAYLANG;

        $objValidator = new FWValidator();

        if (!empty($_POST['newsletter_test_mail']) && $objValidator->isEmail($_POST['newsletter_test_mail'])) {
            if ($this->SendEmail(0, $mailId, $_POST['newsletter_test_mail'], 0, self::USER_TYPE_ACCESS) !== false) {
                self::$strOkMessage = str_replace("%s", $_POST["newsletter_test_mail"], $_ARRAYLANG['TXT_TESTMAIL_SEND_SUCCESSFUL']);
                return true;
            } else {
                self::$strErrMessage .= $_ARRAYLANG['TXT_SENDING_MESSAGE_ERROR'];
                return false;
            }
        } else {
            self::$strErrMessage = $_ARRAYLANG['TXT_INVALID_EMAIL_ADDRESS'];
            return false;
        }
    }


    private function _getMailRecipientCount($mailId = null, $limit = 0, $pos = 0)
    {
        global $objDatabase;

        $count = empty($mailId) ? array() : 0;

        $objResult = $objDatabase->Execute("
            SELECT `id`, `tmp_copy`
            FROM   `".DBPREFIX."module_newsletter`
            ".(!empty($mailId) ? "WHERE `id` = ".$mailId : '')."
            ORDER BY status, id DESC
            ".($limit ? "LIMIT $pos, $limit" : ''));
        if ($objResult !== false) {
            if (empty($mailId)) {
                $count = $this->getFinalMailRecipientCount();
                while (!$objResult->EOF) {
                    if (!$objResult->fields['tmp_copy']) {
                        $count[$objResult->fields['id']] = $this->getCurrentMailRecipientCount($objResult->fields['id']);
                    }
                    $objResult->MoveNext();
                }
            } else {
                if ($objResult->fields['tmp_copy']) {
                    $count = $this->getFinalMailRecipientCount($mailId);
                } else {
                    $count = $this->getCurrentMailRecipientCount($mailId);
                }
            }

        }


        return $count;
    }


    /**
     * @todo I think this should be rewritten too
     */
    private function getFinalMailRecipientCount($mailId = null)
    {
        global $objDatabase;

        $count = empty($mailId) ? array() : 0;

        $objResult = $objDatabase->Execute("
            SELECT
                `id`,
                `recipient_count`
            FROM
                `".DBPREFIX."module_newsletter`
            ".(!empty($mailId) ? "WHERE `id` = ".$mailId : ''));
        if ($objResult !== false && $objResult->RecordCount() > 0) {
            if (empty($mailId)) {
                while (!$objResult->EOF) {
                    $count[$objResult->fields['id']] = $objResult->fields['recipient_count'];
                    $objResult->MoveNext();
                }
            } else {
                $count = $objResult->fields['recipient_count'];

            }
        }

        return $count;
    }


    /**
     * Return the recipient count of the emails
     * @author      Stefan Heinemann <sh@adfinis.com>
     * @param       int $mailId
     * @return      int
     */
    private function getCurrentMailRecipientCount($mailId)
    {
        global $objDatabase;

        $query = sprintf('
            SELECT COUNT(*) AS `recipientCount`
            FROM (
              SELECT `email`
                FROM `%1$smodule_newsletter_user` AS `nu`
                LEFT JOIN `%1$smodule_newsletter_rel_user_cat` AS `rc`
                  ON `rc`.`user`=`nu`.`id`
                LEFT JOIN `%1$smodule_newsletter_rel_cat_news` AS `nrn`
                  ON `nrn`.`category`=`rc`.`category`
               WHERE `nrn`.`newsletter`=%2$s
                 AND `nu`.`status` = 1
            UNION DISTINCT
              SELECT `email`
                FROM `%1$saccess_users` AS `au`
                LEFT JOIN `%1$saccess_rel_user_group` AS `rg`
                  ON `rg`.`user_id`=`au`.`id`
                LEFT JOIN `%1$smodule_newsletter_rel_usergroup_newsletter` AS `arn`
                  ON `arn`.`userGroup`=`rg`.`group_id`
               WHERE `arn`.`newsletter`=%2$s
                 AND `au`.`active` = 1
            UNION DISTINCT
              SELECT `email`
                FROM `%1$saccess_users` AS `cu`
                LEFT JOIN `%1$smodule_newsletter_access_user` AS `cnu`
                  ON `cnu`.`accessUserID`=`cu`.`id`
                LEFT JOIN `%1$smodule_newsletter_rel_cat_news` AS `crn`
                  ON `cnu`.`newsletterCategoryID`=`crn`.`category`
                WHERE `crn`.`newsletter`=%2$s
                  AND `cu`.`active` = 1
            ) AS `subquery`',
            DBPREFIX, $mailId
        );
        $objResult = $objDatabase->Execute($query);
        if ($objResult && $objResult->RecordCount() == 1) {
            return intval($objResult->fields['recipientCount']);
        }
        return 0;
    }


    /**
     * Send the mails
     */
    function _sendMail()
    {
        global $objDatabase, $_ARRAYLANG;

        if (!isset($_REQUEST['id'])) {
            die($_ARRAYLANG['TXT_NEWSLETTER_INVALID_EMAIL']);
        }
        $mailId = intval($_REQUEST['id']);

        $mailRecipientCount = $this->_getMailRecipientCount($mailId);
        if ($mailRecipientCount == 0) {
            die($_ARRAYLANG['TXT_CATEGORY_ERROR']);
        }

        //Get some newsletter data
        $newsletterData = $this->getNewsletterData($mailId);
        $progressbarStatus = round(100 / $mailRecipientCount * $newsletterData['count'], 0);

        $this->_objTpl->setVariable(array(
            'TXT_NEWSLETTER_SUBJECT'        => $_ARRAYLANG['TXT_NEWSLETTER_SUBJECT'],
            'TXT_NEWSLETTER_MAILS_SENT'     => $_ARRAYLANG['TXT_NEWSLETTER_SENT_EMAILS']
        ));

        $this->_objTpl->setVariable(array(
            'CONTREXX_CHARSET'              => CONTREXX_CHARSET,
            'NEWSLETTER_MAIL_ID'            => $mailId,
            'NEWSLETTER_MAIL_USERES'        => $mailRecipientCount,
            'NEWSLETTER_SENDT'              => $newsletterData['count'],
            'NEWSLETTER_MAIL_SUBJECT'       => contrexx_raw2xhtml($newsletterData['subject']),
            'NEWSLETTER_PROGRESSBAR_STATUS' => $progressbarStatus
        ));

        // the newsletter was not sent
        if ($newsletterData['status'] == 0) {
            if (!empty($_POST['send'])) {
                // request was sent through ajax
				$arrJsonData = array(
					'sentComplete' 		=> false,
					'count' 		    => $newsletterData['count'],
					'progressbarStatus' => $progressbarStatus
				);

                if ($newsletterData['tmp_copy'] == 0) {
                    // The newsletter recipients aren't set. Copy them to the temp table
                    $this->_setTmpSending($mailId);
                } else {
                    // send the mails
                    $arrSettings = $this->_getSettings();
                    $mails_per_run = $arrSettings['mails_per_run']['setvalue'];
                    $timeout = time() + (ini_get('max_execution_time') ? ini_get('max_execution_time') : 300 /* Default Apache and IIS Timeout */);
                    $tmpSending = $this->getTmpSending($mailId, $mails_per_run);

                    // attention: in case there happens a database error, $tmpSending->valid() will return false.
                    //            this will cause to stop the send process even if the newsletter send process wasn't complete yet!!
                    if ($tmpSending->valid()) {
                        foreach ($tmpSending as $send) {
                            $beforeSend = time();
                            $this->SendEmail($send['id'], $mailId, $send['email'], 1, $send['type']);

                            // timeout prevention
                            if (time() >= $timeout - (time() - $beforeSend) * 2) {
                                break;
                            }
                        }
                    } else {
                        // basically the send process is done.
                        // the delivery of the last e-mail failed. because of that, the $newsletterData['status'] was not set to 1
                        // we shall set it to 1 one, so that the next ajax request will abbort regularly
                        $objDatabase->Execute("
                            UPDATE ".DBPREFIX."module_newsletter
                               SET status=1
                             WHERE id=$mailId");
                    }
                }

				die(json_encode($arrJsonData));
            } else {
                // request was sent through regular POST
                $this->_objTpl->setVariable(array(
                    'NEWSLETTER_MAIL_SEND_INFO_DISPLAY'   => '',
                    'NEWSLETTER_MAIL_SEND_BUTTON_DISPLAY' => '',
                    'NEWSLETTER_MAIL_SENT_STATUS_DISPLAY' => 'none',
                ));
            }
        } else {
            $recipientCount = $this->_getMailRecipientCount($mailId);

            $message = $_ARRAYLANG['TXT_NEWSLETTER_MAIL_SENT_STATUS'];
            $message .= '<br />'.sprintf($_ARRAYLANG['TXT_NEWSLETTER_MAIL_SENT_TO_RECIPIENTS'], $newsletterData['count']);

            // in case the e-mail was not sent to all recipients, output a according message
            if ($newsletterData['count'] < $recipientCount) {
// TODO: check if there are any recipients left that were missed out in the send process (sendt=1).
//       if there are any, provide an option to continue sending the newsletter.
//       additionally, the status of the newsletter must be set back to '0'

// TODO: check if the delivery to any recipients failed (sendt=2).
//       if there are any, provide an option to resend the e-mail to those recipients.
//       the sendt flag must be set back to sendt=1 to be able to resend the e-mail to those recipients where the send process has failed
//       additionally, the status of the newsletter must be set back to '0' (see also option above, where we shall allow to resend the e-mail to those who were left out in the send process (sendt=1)

                $message .= '<br />'.sprintf($_ARRAYLANG['TXT_NEWSLETTER_MAIL_NOT_SENT_TO_RECIPIENTS'], $recipientCount - $newsletterData['count']);
            }

            if (!empty($_POST['send'])) {
                // request was sent through ajax
                $arrJsonData = array(
                    'sentComplete' 		=> true,
                    'count' 		    => $newsletterData['count'],
                    'progressbarStatus' => $progressbarStatus,
                    'message'           => $message,
                );
                die(json_encode($arrJsonData));
            } else {
                // request was sent through regular POST
                $this->_objTpl->setVariable('NEWSLETTER_MAIL_SENT_STATUS', $message);
                $this->_objTpl->setVariable(array(
                    'NEWSLETTER_MAIL_SEND_INFO_DISPLAY'   => 'none',
                    'NEWSLETTER_MAIL_SEND_BUTTON_DISPLAY' => 'none',
                    'NEWSLETTER_MAIL_SENT_STATUS_DISPLAY' => '',
                ));
            }
        }
    }


    /**
     * Get the emails from the tmp sending page
     *
     * @author      Stefan Heinemann <sh@adfinis.com>
     * @return
     */
    protected function getTmpSending($id, $amount) {
        global $objDatabase;

        $query = "
            SELECT (CASE WHEN `s`.`type` = '".self::USER_TYPE_NEWSLETTER."'
                         THEN `nu`.`id`
                         ELSE `au`.`id`
                                        END) AS `id`,
                    `s`.email,
                    `s`.type,
                    # this code is used for newsletter browser view
                    `s`.`code`

              FROM `".DBPREFIX."module_newsletter_tmp_sending` AS `s`

         LEFT JOIN `".DBPREFIX."module_newsletter_user` AS `nu`
                ON `nu`.`email` = `s`.`email`
               AND `s`.`type` = '".self::USER_TYPE_NEWSLETTER."'


         LEFT JOIN `".DBPREFIX."access_users` AS `au`
                ON `au`.`email` = `s`.`email`
               AND (`s`.`type` = '".self::USER_TYPE_ACCESS."' OR `s`.`type` = '".self::USER_TYPE_CORE."')

             WHERE `s`.`newsletter` = ".intval($id)."
               AND `s`.`sendt` = 0
               AND (`au`.`email` IS NOT NULL OR `nu`.`email` IS NOT NULL)";

        $res = $objDatabase->SelectLimit($query, $amount, 0);
        return new DBIterator($res);
    }


    /**
     * Return some newsletter data
     * @author      Stefan Heinemann <sh@adfinis.com>
     * @param       int $id
     * @throws      Exception
     * @return      array(subject, status, count, tmp_copy)
     */
    protected function getNewsletterData($id)
    {
        global $objDatabase;

        $query = "
            SELECT subject, status, `count`, tmp_copy
              FROM ".DBPREFIX."module_newsletter
             WHERE id=$id";
        $objResult = $objDatabase->Execute($query);
        if (!$objResult) return array();
        return array(
            'subject' => $objResult->fields['subject'],
            'status' => $objResult->fields['status'],
            'count' => $objResult->fields['count'],
            'tmp_copy' => $objResult->fields['tmp_copy'],
        );
    }


    /**
     * Add the email address to the temp
     * @author      Stefan Heinemann <sh@adfinis.com>
     * @param       int $mailId
     */
    function _setTmpSending($mailId)
    {
        $mailAddresses = $this->getAllRecipientEmails($mailId);
        foreach ($mailAddresses as $mail) {
            $this->insertTmpEmail($mailId, $mail['email'], $mail['type']);
        }
        $this->updateNewsletterRecipientCount($mailId);
    }


    /**
     * Insert an email address into the email table
     * @author      Stefan Heinemann <sh@adfinis.com>
     * @param       int $mail
     * @param       string $email
     */
    private function insertTmpEmail($mail, $email, $type)
    {
        global $objDatabase;

        $query = '
            INSERT IGNORE INTO `'.DBPREFIX.'module_newsletter_tmp_sending` (
                `newsletter`, `email`, `type`, `code`
            ) VALUES (
                "'.$mail.'", "'.$email.'", "'.$type.'", "'.self::_emailCode().'"
            )
        ';
        $objDatabase->Execute($query);
    }


    /**
     * Return the recipient count of a newsletter in the temp table
     *
     * @author      Stefan Heinemann <sh@adfinis.com>
     * @param       int $id
     * @return      int
     */
    private function getTmpRecipientCount($id) {
        global $objDatabase;

        $query = "
            SELECT
                COUNT(1) AS recipient_count
            FROM
                `".DBPREFIX."module_newsletter_tmp_sending`
            WHERE
                `newsletter` = $id
            GROUP BY
                `newsletter`";
        $objResult = $objDatabase->Execute($query);

        return
              $objResult !== false
            ? intval($objResult->fields['recipient_count'])
            : 0;
    }


    /**
     * Update the recipient count of a newsletter
     * @author      Stefan Heinemann <sh@adfinis.com>
     * @param       int $newsletter
     */
    private function updateNewsletterRecipientCount($newsletter)
    {
        global $objDatabase;

        $count = $this->getTmpRecipientCount($newsletter);
        $query = "
            UPDATE ".DBPREFIX."module_newsletter
               SET tmp_copy=1,
                   date_sent=".time().",
                   recipient_count=$count
             WHERE id=".intval($newsletter);
        $objDatabase->Execute($query);
    }


    /**
     * Return all email recipients
     * @author      Stefan Heinemann <sh@adfinis.com>
     * @param       int $mailID
     * @return      object
     */
    private function getAllRecipientEmails($mailID)
    {
        global $objDatabase;

        $mailID = intval($mailID);
        // this query selects the recipients in the following order
        // 1. access users that have subscribed to one of the selected recipient-lists
        // 2. newsletter recipients of one of the selected recipient-lists
        // 3. access users of one of the selected user groups
        $query = sprintf('
            SELECT `email`, "'.self::USER_TYPE_ACCESS.'" AS `type`
              FROM `%1$saccess_users` AS `cu`
        INNER JOIN `%1$smodule_newsletter_access_user` AS `cnu`
                ON `cnu`.`accessUserID`=`cu`.`id`
        INNER JOIN `%1$smodule_newsletter_rel_cat_news` AS `crn`
                ON `cnu`.`newsletterCategoryID`=`crn`.`category`
             WHERE `crn`.`newsletter`=%2$s
               AND `cu`.`active` = 1
    UNION DISTINCT
            SELECT `email`, "'.self::USER_TYPE_NEWSLETTER.'" AS `type`
              FROM `%1$smodule_newsletter_user` AS `nu`
        INNER JOIN `%1$smodule_newsletter_rel_user_cat` AS `rc`
                ON `rc`.`user`=`nu`.`id`
        INNER JOIN `%1$smodule_newsletter_rel_cat_news` AS `nrn`
                ON `nrn`.`category`=`rc`.`category`
             WHERE `nrn`.`newsletter`=%2$s
               AND `nu`.`status` = 1
    UNION DISTINCT
            SELECT `email`, "'.self::USER_TYPE_CORE.'" AS `type`
              FROM `%1$saccess_users` AS `au`
        INNER JOIN `%1$saccess_rel_user_group` AS `rg`
                ON `rg`.`user_id`=`au`.`id`
        INNER JOIN `%1$smodule_newsletter_rel_usergroup_newsletter` AS `arn`
                ON `arn`.`userGroup`=`rg`.`group_id`
             WHERE `arn`.`newsletter`=%2$s
               AND `au`.`active` = 1',
            DBPREFIX, $mailID);
        return new DBIterator($objDatabase->Execute($query));
    }


    /**
     * Send the email
     * @param      int $UserID
     * @param      int $NewsletterID
     * @param      string $TargetEmail
     * @param      string $type
     */
    function SendEmail(
        $UserID, $NewsletterID, $TargetEmail, $TmpEntry,
        $type=self::USER_TYPE_NEWSLETTER
    ) {
        global $objDatabase, $_ARRAYLANG, $_DBCONFIG;

        require_once ASCMS_LIBRARY_PATH.'/phpmailer/class.phpmailer.php';

        $newsletterValues = $this->getNewsletterValues($NewsletterID);
        if ($newsletterValues !== false) {
            $subject      = $newsletterValues['subject'];
            $template     = $newsletterValues['template'];
            $content      = $newsletterValues['content'];
            $priority     = $newsletterValues['priority'];
            $sender_email = $newsletterValues['sender_email'];
            $sender_name  = $newsletterValues['sender_name'];
            $return_path  = $newsletterValues['return_path'];
            $count        = $newsletterValues['count'];
            $smtpAccount  = $newsletterValues['smtp_server'];
        }
        $break = $this->getSetting('txt_break_after');
        $break = (intval($break) == 0 ? 80 : $break);
        $HTML_TemplateSource = $this->GetTemplateSource($template, 'html');
// TODO: Unused
//        $TEXT_TemplateSource = $this->GetTemplateSource($template, 'text');
        $newsletterUserData = $this->getNewsletterUserData($UserID, $type);

        $testDelivery = !$TmpEntry;

        $NewsletterBody_HTML = $this->ParseNewsletter(
            $subject,
            $content,
            $HTML_TemplateSource,
            '',
            $TargetEmail,
            $newsletterUserData,
            $NewsletterID,
            $testDelivery
        );
        LinkGenerator::parseTemplate($NewsletterBody_HTML, true);

        $NewsletterBody_TEXT = $this->ParseNewsletter(
            '',
            '',
            '',
            'text',
            '',
            $newsletterUserData,
            $NewsletterID,
            $testDelivery
        );
        LinkGenerator::parseTemplate($NewsletterBody_TEXT, true);

        $mail = new phpmailer();
        if ($smtpAccount > 0) {
            if (($arrSmtp = SmtpSettings::getSmtpAccount($smtpAccount)) !== false) {
                $mail->IsSMTP();
                $mail->Host     = $arrSmtp['hostname'];
                $mail->Port     = $arrSmtp['port'];
                $mail->SMTPAuth = $arrSmtp['username'] == '-' ? false : true;
                $mail->Username = $arrSmtp['username'];
                $mail->Password = $arrSmtp['password'];
            }
        }
        $mail->CharSet  = CONTREXX_CHARSET;
        $mail->From     = $sender_email;
        $mail->FromName = $sender_name;
        $mail->AddReplyTo($return_path);
        $mail->Subject  = $subject;
        $mail->Priority = $priority;
        $mail->Body     = $NewsletterBody_HTML;
        $mail->AltBody  = $NewsletterBody_TEXT;

        $queryATT     = "SELECT newsletter, file_name FROM ".DBPREFIX."module_newsletter_attachment where newsletter=".$NewsletterID."";
        $objResultATT = $objDatabase->Execute($queryATT);
        if ($objResultATT !== false) {
            while (!$objResultATT->EOF) {
                $mail->AddAttachment(ASCMS_NEWSLETTER_ATTACH_PATH."/".$objResultATT->fields['file_name'], $objResultATT->fields['file_name']);
                $objResultATT->MoveNext();
            }
        }
        $mail->AddAddress($TargetEmail);

        if ($UserID) {
            // mark recipient as in-action to prevent multiple tries of sending the newsletter to the same recipient
            $query = "UPDATE ".DBPREFIX."module_newsletter_tmp_sending SET sendt=2 where email='".$TargetEmail."' AND newsletter=".$NewsletterID." AND sendt=0";
            if ($objDatabase->Execute($query) === false || $objDatabase->Affected_Rows() == 0) {
                return $count;
            }
        }

        if ($mail->Send()) { // && $UserID == 0) {
            $ReturnVar = $count++;
            if ($TmpEntry==1) {
                // Insert TMP-ENTRY Sended Email & Count++
                $query = "UPDATE ".DBPREFIX."module_newsletter_tmp_sending SET sendt=1 where email='".$TargetEmail."' AND newsletter=".$NewsletterID."";
                if ($objDatabase->Execute($query) === false) {
                    if ($_DBCONFIG['dbType'] == 'mysql' && $objDatabase->ErrorNo() == 2006) {
                        @$objDatabase->Connect($_DBCONFIG['host'], $_DBCONFIG['user'], $_DBCONFIG['password'], $_DBCONFIG['database'], true);
                        if ($objDatabase->Execute($query) === false) {
                            return false;
                        }
                    }
                }

                $objDatabase->Execute("
                    UPDATE ".DBPREFIX."module_newsletter
                       SET count=count+1
                     WHERE id=$NewsletterID");
                $queryCheck     = "SELECT 1 FROM ".DBPREFIX."module_newsletter_tmp_sending where newsletter=".$NewsletterID." and sendt=0";
                $objResultCheck = $objDatabase->SelectLimit($queryCheck, 1);
                if ($objResultCheck->RecordCount() == 0) {
                    $objDatabase->Execute("
                        UPDATE ".DBPREFIX."module_newsletter
                           SET status=1
                         WHERE id=$NewsletterID");
                }
            } /*elseif ($mail->error_count) {
                if (strstr($mail->ErrorInfo, 'authenticate')) {
                    self::$strErrMessage .= sprintf($_ARRAYLANG['TXT_NEWSLETTER_MAIL_AUTH_FAILED'], htmlentities($arrSmtp['name'], ENT_QUOTES, CONTREXX_CHARSET)).'<br />';
                    $ReturnVar = false;
                }
            } */
        } else {
            if (strstr($mail->ErrorInfo, 'authenticate')) {
                self::$strErrMessage .= sprintf($_ARRAYLANG['TXT_NEWSLETTER_MAIL_AUTH_FAILED'], htmlentities($arrSmtp['name'], ENT_QUOTES, CONTREXX_CHARSET)).'<br />';
            } elseif (strstr($mail->ErrorInfo, 'from_failed')) {
                self::$strErrMessage .= sprintf($_ARRAYLANG['TXT_NEWSLETTER_FROM_ADDR_REJECTED'], htmlentities($sender_email, ENT_QUOTES, CONTREXX_CHARSET)).'<br />';
            } elseif (strstr($mail->ErrorInfo, 'recipients_failed')) {
                self::$strErrMessage .= sprintf($_ARRAYLANG['TXT_NEWSLETTER_RECIPIENT_FAILED'], htmlentities($TargetEmail, ENT_QUOTES, CONTREXX_CHARSET)).'<br />';
            } elseif (strstr($mail->ErrorInfo, 'instantiate')) {
                self::$strErrMessage .= $_ARRAYLANG['TXT_NEWSLETTER_LOCAL_SMTP_FAILED'].'<br />';
            } elseif (strstr($mail->ErrorInfo, 'connect_host')) {
                self::$strErrMessage .= $_ARRAYLANG['TXT_NEWSLETTER_CONNECT_SMTP_FAILED'].'<br />';
            } else {
                self::$strErrMessage .= $mail->ErrorInfo.'<br />';
            }
            $ReturnVar = false;

            if ($TmpEntry == 1) {
                $arrSettings = $this->_getSettings();
                if ($arrSettings['rejected_mail_operation']['setvalue'] != 'ignore') {
                    switch ($arrSettings['rejected_mail_operation']['setvalue']) {
                        case 'deactivate':
                            // Remove temporary data from the module
                            if ($objDatabase->Execute("DELETE FROM `".DBPREFIX."module_newsletter_tmp_sending` WHERE `email` ='".addslashes($TargetEmail)."'") !== false) {
                                switch ($type) {
                                    case self::USER_TYPE_CORE:
                                        // do nothing with system users
                                        break;

                                    case self::USER_TYPE_ACCESS:
// TODO: Remove newsletter subscription for access_user
                                        break;

                                    case self::USER_TYPE_NEWSLETTER:
                                    default:
                                        // Deactivate user
                                        $objDatabase->Execute("UPDATE `".DBPREFIX."module_newsletter_user` SET `status` = 0 WHERE `id` = ".$UserID);
                                        break;
                                }
                            }
                            break;

                        case 'delete':
                            switch ($type) {
                                case self::USER_TYPE_CORE:
                                    // do nothing with system users
                                    break;

                                case self::USER_TYPE_ACCESS:
// TODO: Remove newsletter subscription for access_user
                                    break;

                                case self::USER_TYPE_NEWSLETTER:
                                default:
                                    // Remove user data from the module
                                    $this->_deleteRecipient(UserID);
                                    break;
                            }
                            break;


                        case 'inform':
                            $this->informAdminAboutRejectedMail($NewsletterID, UserID, $TargetEmail, $type);
                            break;
                    }
                }
                $ReturnVar = $count;
            }
        }
        $mail->ClearAddresses();
        $mail->ClearAttachments();
        return $ReturnVar;
    }


    /**
     * Return the newsletter values
     * @param      int $id
     * @return     array | bool
     */
    private function getNewsletterValues($id)
    {
        global $objDatabase;

        $queryNewsletterValues = "
            SELECT id, subject, template, content,
                   attachment, priority, sender_email, sender_name,
                   return_path, smtp_server, status, count,
                   date_create, date_sent
              FROM ".DBPREFIX."module_newsletter
             WHERE id=$id";
        $result = $objDatabase->Execute($queryNewsletterValues);
        return $result !== false ? $result->fields : false;
    }


    /**
     * Inform the admin about a reject
     *
     * If an email could not be sent, inform the administrator
     * about that (only if the option to do so was set)
     * @author      Stefan Heinemann <sh@adfinis.com>
     * @param       int $newsletterID
     * @param       int $userID
     * @param       string $email
     * @param       const
     */
    protected function informAdminAboutRejectedMail($newsletterID, $userID, $email, $type)
    {
        // Get the current user's email address
        $addy = FWUser::getFWUserObject()->objUser->getEmail();
        require_once ASCMS_LIBRARY_PATH.'/phpmailer/class.phpmailer.php';
        $mail = new phpmailer();
        $newsletterValues = $this->getNewsletterValues($newsletterID);
        if ($newsletterValues['smtp_server'] > 0) {
            if (($arrSmtp = SmtpSettings::getSmtpAccount($newsletterValues['smtp_server'])) !== false) {
                $mail->IsSMTP();
                $mail->Host     = $arrSmtp['hostname'];
                $mail->Port     = $arrSmtp['port'];
                $mail->SMTPAuth = $arrSmtp['username'] == '-' ? false : true;
                $mail->Username = $arrSmtp['username'];
                $mail->Password = $arrSmtp['password'];
            }
        }
        $mail->CharSet      = CONTREXX_CHARSET;
        $mail->From         = $newsletterValues['sender_email'];
        $mail->FromName     = $newsletterValues['sender_name'];
        $mail->AddReplyTo($newsletterValues['return_path']);
        $mail->Subject      = $newsletterValues['subject'];
        $mail->Priority     = $newsletterValues['priority'];
        $mail->Body         = $this->getInformMailBody($userID, $email, $type);
        $mail->AddAddress($addy);
        $mail->send();
    }


    /**
     * Return the body of the inform email
     * @author      Stefan Heinemann <sh@adfinis.com>
     * @param       int $userID
     * @param       string $mail
     * @param       const $type
     */
    protected function getInformMailBody($userID, $mail, $type)
    {
        global $_CONFIG;

        $body = $this->getSetting('reject_info_mail_text');
        $link = 'http://'.$_CONFIG['domainUrl'].ASCMS_PATH_OFFSET;

        switch ($type) {
            case self::USER_TYPE_CORE:
            case self::USER_TYPE_ACCESS:
                $link .= '/cadmin/index.php?cmd=access&act=user&tpl=modify&id='.$userID;
                break;

            case self::USER_TYPE_NEWSLETTER:
            default:
                $link .= '/cadmin/index.php?cmd=newsletter&act=users&tpl=edit&id='.$userID;
                break;
        }

        $body = str_replace(array('[[EMAIL]]', '[[LINK]]'), array($mail, $link), $body);
        return $body;
    }


    function GetTemplateSource($TemplateID) {
        global $objDatabase;
        $TemplateSource = '';
        $queryPN = "select id, name, description, type, html from ".DBPREFIX."module_newsletter_template where id=".$TemplateID."";
        $objResultPN = $objDatabase->Execute($queryPN);
        if ($objResultPN !== false) {
            $TemplateSource = $objResultPN->fields['html'];
        }
        return $TemplateSource;
    }

    /**
     * Parse the newsletter
     * @author      Comvation AG
     * @author      Stefan Heinemann <sh@adfinis.com>
     * @param       string $userType Which type the user has (newsletter or access)
     */
    function ParseNewsletter(
        $subject, $content_text, $TemplateSource,
        $format, $TargetEmail, $userData, $NewsletterID,
        $testDelivery = false
    ) {
        global $objDatabase, $_ARRAYLANG, $_CONFIG;

        $NewsletterBody = '';
        $codeResult     = $objDatabase->Execute('SELECT `code` FROM `'.DBPREFIX.'module_newsletter_tmp_sending` WHERE `newsletter` = '.$NewsletterID.' AND `email` = "'.$userData['email'].'"');
        $code           = $codeResult->fields['code'];
// TODO: replace with new methode $this->GetBrowserViewURL()
        $browserViewUrl = ASCMS_PROTOCOL.'://'.$_CONFIG['domainUrl'].ASCMS_PATH_OFFSET.'/'.FWLanguage::getLanguageCodeById(FRONTEND_LANG_ID).'/index.php?section=newsletter&cmd=displayInBrowser&standalone=true&code='.$code.'&email='.$userData['email'].'&id='.$NewsletterID;

        if ($format == 'text') {
            $NewsletterBody = $_ARRAYLANG['TXT_NEWSLETTER_BROWSER_VIEW']."\n".$browserViewUrl;
            return $NewsletterBody;
        }

        $country = empty($userData['country_id'])
            ? ''
            : htmlentities(
                  FWUser::getFWUserObject()->objUser->objAttribute->getById('country_'.$userData['country_id'])->getName(),
                  ENT_QUOTES, CONTREXX_CHARSET
              );

        switch ($userData['sex']) {
            case 'm':
                $sex = $_ARRAYLANG['TXT_NEWSLETTER_MALE'];
                break;
            case 'f':
                $sex = $_ARRAYLANG['TXT_NEWSLETTER_FEMALE'];
                break;
            default:
                $sex = '';
                break;
        }

        switch ($userData['type']) {
            case self::USER_TYPE_ACCESS:
            case self::USER_TYPE_CORE:
                $realUser = true;
                break;

            case self::USER_TYPE_NEWSLETTER:
            default:
                $realUser = false;
                break;
        }

        // lets prepare all links for tracker before we replace placeholders
// TODO: migrate tracker to new URL-format
        $content_text = self::prepareNewsletterLinksForSend($NewsletterID, $content_text, $userData['id'], $realUser);

        $search = array(
            '[[email]]',
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
            $userData['email'],
            $sex,
            $userData['salutation'],
            $userData['title'],
            $userData['firstname'],
            $userData['lastname'],
            $userData['position'],
            $userData['company'],
            $userData['industry_sector'],
            $userData['address'],
            $userData['city'],
            $userData['zip'],
            $country,
            $userData['phone_office'],
            $userData['phone_private'],
            $userData['phone_mobile'],
            $userData['fax'],
            $userData['birthday'],
            $userData['website'],
        );

        if ($testDelivery) {
            $replace = $search;
        }
        // do the replacement
        $content_text       = str_replace($search, $replace, $content_text);
        $TemplateSource     = str_replace($search, $replace, $TemplateSource);

        $search = array(
            '[[display_in_browser_url]]',
            '[[profile_setup]]',
            '[[unsubscribe]]',
            '[[date]]'
        );
        $replace = array(
            $browserViewUrl,
            $this->GetProfileURL($userData['code'], $TargetEmail, $userData['type']),
            $this->GetUnsubscribeURL($userData['code'], $TargetEmail, $userData['type']),
            date(ASCMS_DATE_FORMAT_DATE)
        );

        // Replace the links in the content
        $content_text = str_replace($search, $replace, $content_text);

        // replace the links in the template
        $TemplateSource = str_replace($search, $replace, $TemplateSource);

        // i believe this replaces image paths...
        $allImg = array();
        preg_match_all('/src="([^"]*)"/', $content_text, $allImg, PREG_PATTERN_ORDER);
        $size = sizeof($allImg[1]);
        $i = 0;
        $port = $_SERVER['SERVER_PORT'] != 80 ? ':'.intval($_SERVER['SERVER_PORT']) : '';

        while ($i < $size) {
            $URLforReplace = $allImg[1][$i];
            if (substr($URLforReplace, 0, 7) != ASCMS_PROTOCOL.'://') {
                $ReplaceWith = '"'.ASCMS_PROTOCOL.'://'.$_SERVER['SERVER_NAME'].$port.$URLforReplace.'"';
            } else {
                $ReplaceWith = $URLforReplace;
            }
            $content_text = str_replace('"'.$URLforReplace.'"', $ReplaceWith, $content_text);
            $i++;
        }

        $NewsletterBody = str_replace("[[subject]]", $subject, $TemplateSource);
        $NewsletterBody = str_replace("[[content]]", $content_text, $TemplateSource);
        return $NewsletterBody;
    }


    /**
     * Return the user data
     * @author      Stefan Heinemann <sh@adfinis.com>
     * @param       int $id
     * @param       string $type
     * @param       int ID of newsletter e-mail
     * @return      adodb result object
     */
    private function getNewsletterUserData($id, $type)
    {
        global $objDatabase;

        $arrUserData = array(
            'code'              => '',
            'email'             => '',
            'sex'               => '',
            'salutation'        => '',
            'title'             => '',
            'firstname'         => '',
            'lastname'          => '',
            'position'          => '',
            'company'           => '',
            'industry_sector'   => '',
            'address'           => '',
            'city'              => '',
            'zip'               => '',
            'country_id'        => '0',
            'phone_office'      => '',
            'phone_private'     => '',
            'phone_mobile'      => '',
            'fax'               => '',
            'birthday'          => '00-00-0000',
            'website'           => '',
            'type'              => $type,
            'id'                => $id
        );

        if (!$id) return $arrUserData;

        switch ($type) {
            case self::USER_TYPE_ACCESS:
                $query = "
                    SELECT code
                      FROM ".DBPREFIX."module_newsletter_access_user
                     WHERE accessUserID = $id";
                $result = $objDatabase->SelectLimit($query, 1);
                if ($result && !$result->EOF) {
                    $arrUserData['code'] = $result->fields['code'];
                }

                // intentionally no break here!!

            case self::USER_TYPE_CORE:
                $objUser = FWUser::getFWUserObject()->objUser->getUser($id);

                if (!$objUser) {
                    // in case no user account exists by the supplied ID, then reset the code and abort operation
                    $arrUserData['code'] = '';
                    break;
                }

                switch ($objUser->getProfileAttribute('gender')) {
                    case 'gender_male':
                        $arrUserData['sex'] = 'm';
                        break;
                    case 'gender_female':
                        $arrUserData['sex'] = 'f';
                        break;
                }

                $arrUserData['email']           = $objUser->getEmail();
                $arrUserData['website']         = $objUser->getProfileAttribute('website');
                $arrUserData['salutation']      = $objUser->objAttribute->getById('title_'.$objUser->getProfileAttribute('title'))->getName();
                $arrUserData['lastname']        = $objUser->getProfileAttribute('lastname');
                $arrUserData['firstname']       = $objUser->getProfileAttribute('firstname');
                $arrUserData['company']         = $objUser->getProfileAttribute('company');
                $arrUserData['address']         = $objUser->getProfileAttribute('address');
                $arrUserData['zip']             = $objUser->getProfileAttribute('zip');
                $arrUserData['city']            = $objUser->getProfileAttribute('city');
                $arrUserData['country_id']      = $objUser->getProfileAttribute('country');
                $arrUserData['phone_office']    = $objUser->getProfileAttribute('phone_office');
                $arrUserData['phone_private']   = $objUser->getProfileAttribute('phone_private');
                $arrUserData['phone_mobile']    = $objUser->getProfileAttribute('phone_mobile');
                $arrUserData['fax']             = $objUser->getProfileAttribute('phone_fax');
                $arrUserData['birthday']        = $objUser->getProfileAttribute('birthday');
                break;

            case self::USER_TYPE_NEWSLETTER:
            default:
                $query = "
                    SELECT code, sex, email, uri,
                           salutation, title, lastname, firstname,
                           position, address, zip, city, country_id,
                           phone_office, company, industry_sector, birthday,
                           phone_private, phone_mobile, fax
                      FROM ".DBPREFIX."module_newsletter_user
                     WHERE id=$id";
                $result = $objDatabase->Execute($query);
                if (!$result || $result->EOF) {
                    break;
                }

// TODO: use FWUser instead of _getRecipientTitles()
                $arrRecipientTitles = $this->_getRecipientTitles();
                $arrUserData['code']            = $result->fields['code'];
                $arrUserData['sex']             = $result->fields['sex'];
                $arrUserData['email']           = $result->fields['email'];
                $arrUserData['salutation']      = $arrRecipientTitles[$result->fields['salutation']];
                $arrUserData['title']           = $result->fields['title'];
                $arrUserData['firstname']       = $result->fields['firstname'];
                $arrUserData['lastname']        = $result->fields['lastname'];
                $arrUserData['position']        = $result->fields['position'];
                $arrUserData['company']         = $result->fields['company'];
                $arrUserData['industry_sector'] = $result->fields['industry_sector'];
                $arrUserData['address']         = $result->fields['address'];
                $arrUserData['city']            = $result->fields['city'];
                $arrUserData['zip']             = $result->fields['zip'];
                $arrUserData['country_id']      = $result->fields['country_id'];
                $arrUserData['phone_office']    = $result->fields['phone_office'];
                $arrUserData['phone_private']   = $result->fields['phone_private'];
                $arrUserData['phone_mobile']    = $result->fields['phone_mobile'];
                $arrUserData['fax']             = $result->fields['fax'];
                $arrUserData['birthday']        = $result->fields['birthday'];
                $arrUserData['website']         = $result->fields['uri'];
                break;
        }

        return $arrUserData;
    }


    /**
     * Get the URL to the page to unsubscribe
     */
    function GetUnsubscribeURL($code, $email, $type = self::USER_TYPE_NEWSLETTER)
    {
        global $_ARRAYLANG, $_CONFIG;

        if ($type == self::USER_TYPE_CORE) {
            // recipients that will receive the newsletter through the selection of their user group don't have a profile
            return '';
        }

        switch ($type) {
            case self::USER_TYPE_ACCESS:
                $profileURI = '?section=newsletter&cmd=profile&code='.$code.'&mail='.urlencode($email);
                break;

            case self::USER_TYPE_NEWSLETTER:
            default:
                $profileURI = '?section=newsletter&cmd=unsubscribe&code='.$code.'&mail='.urlencode($email);
                break;
        }

        $uri =
            ASCMS_PROTOCOL.'://'.
            $_CONFIG['domainUrl'].
            ($_SERVER['SERVER_PORT'] == 80
              ? '' : ':'.intval($_SERVER['SERVER_PORT'])).
            ASCMS_PATH_OFFSET.
// TODO: use the recipient's language instead of the default language
            '/'.FWLanguage::getLanguageParameter(FWLanguage::getDefaultLangId(), 'lang').
            '/'.CONTREXX_DIRECTORY_INDEX.$profileURI;

        return '<a href="'.$uri.'">'.$_ARRAYLANG['TXT_UNSUBSCRIBE'].'</a>';
    }


    /**
     * Return link to the profile of a user
     */
    function GetProfileURL($code, $email, $type = self::USER_TYPE_NEWSLETTER)
    {
        global $_ARRAYLANG, $_CONFIG;

        if ($type == self::USER_TYPE_CORE) {
            // recipients that will receive the newsletter through the selection of their user group don't have a profile
            return '';
        }

        $profileURI = '?section=newsletter&cmd=profile&code='.$code.'&mail='.urlencode($email);
        $uri =
            ASCMS_PROTOCOL.'://'.
            $_CONFIG['domainUrl'].
            ($_SERVER['SERVER_PORT'] == 80
              ? NULL : ':'.intval($_SERVER['SERVER_PORT'])).
            ASCMS_PATH_OFFSET.
// TODO: use the recipient's language instead of the default language
            '/'.FWLanguage::getLanguageParameter(FWLanguage::getDefaultLangId(), 'lang').
            '/'.CONTREXX_DIRECTORY_INDEX.$profileURI;
        return '<a href="'.$uri.'">'.$_ARRAYLANG['TXT_EDIT_PROFILE'].'</a>';
    }


    function _getNewsPage()
    {
        global $objDatabase, $objInit, $_ARRAYLANG;

		JS::activate('cx');

// TODO: Unused
//		$objFWUser = FWUser::getFWUserObject();

        $newsdate = time() - 86400 * 30;
        if (!empty($_POST['newsDate'])) {
            $newsdate = $this->dateFromInput($_POST['newsDate']);
        }

        $this->_pageTitle = $_ARRAYLANG['TXT_NEWSLETTER_NEWS_IMPORT'];
        $this->_objTpl->loadTemplateFile('newsletter_news.html');
        $this->_objTpl->setVariable(array(
            'TXT_NEWS_IMPORT' => $_ARRAYLANG['TXT_NEWSLETTER_NEWS_IMPORT'],
			'TXT_DATE_SINCE' => $_ARRAYLANG['TXT_NEWSLETTER_NEWS_DATE_SINCE'],
			'TXT_SELECTED_MESSAGES' => $_ARRAYLANG['TXT_NEWSLETTER_NEWS_SELECTED_MESSAGES'],
			'TXT_NEXT' => $_ARRAYLANG['TXT_NEWSLETTER_NEWS_NEXT'],
			'NEWS_CREATE_DATE' => $this->valueFromDate($newsdate)
        ));

		$query = "SELECT n.id, n.date, nl.title, nl.text, n.catid, cl.name as catname, n.userid, nl.teaser_text,
			n.teaser_image_path, n.teaser_image_thumbnail_path, tl.name as typename FROM ".DBPREFIX."module_news n
			LEFT JOIN ".DBPREFIX."module_news_locale nl ON n.id = nl.news_id AND nl.lang_id=".$objInit->userFrontendLangId."
			LEFT JOIN ".DBPREFIX."module_news_categories_locale cl ON n.catid = cl.category_id AND cl.lang_id=".$objInit->userFrontendLangId."
			LEFT JOIN ".DBPREFIX."module_news_types_locale tl ON n.typeid = tl.type_id AND tl.lang_id=".$objInit->userFrontendLangId."
			WHERE n.date > ".$newsdate." AND n.status = 1 AND n.validated = '1'
			ORDER BY cl.name ASC, n.date DESC";

			/*AND (n.startdate <> '0000-00-00 00:00:00' OR n.enddate <> '0000-00-00 00:00:00')*/

		$objNews = $objDatabase->Execute($query);
		$current_category = '';
		if ($objNews !== false) {
            while (!$objNews->EOF) {
				$this->_objTpl->setVariable(array(
                    'NEWS_CATEGORY_NAME' => contrexx_raw2xhtml($objNews->fields['catname']),
					'NEWS_CATEGORY_ID' => $objNews->fields['catid'],
                ));
				if($current_category == $objNews->fields['catid'])
					$this->_objTpl->hideBlock("news_category");
				$current_category = $objNews->fields['catid'];
// TODO: Unused
//                $newstext = ltrim(strip_tags($objNews->fields['text']));
				$newsteasertext = ltrim(strip_tags($objNews->fields['teaser_text']));
                //$newslink = $this->newsletterUri.ASCMS_PROTOCOL."://".$_SERVER['HTTP_HOST'].ASCMS_PATH_OFFSET."/index.php?section=news&cmd=details&newsid=".$objNews->fields['id'];
				/*if ($objNews->fields['userid'] && ($objUser = $objFWUser->objUser->getUser($objNews->fields['userid']))) {
                        $author = htmlentities($objUser->getUsername(), ENT_QUOTES, CONTREXX_CHARSET);
                    } else {
                        $author = $_ARRAYLANG['TXT_ANONYMOUS'];
                    }*/
                $image = $objNews->fields['teaser_image_path'];
                $thumbnail = $objNews->fields['teaser_image_thumbnail_path'];

                if (!empty($thumbnail)) {
                    $imageSrc = $thumbnail;
                } elseif (!empty($image) && file_exists(ASCMS_PATH.ImageManager::getThumbnailFilename($image))) {
                    $imageSrc = ImageManager::getThumbnailFilename($image);
                } elseif (!empty($image)) {
                    $imageSrc = $image;
                } else {
                    $imageSrc = '';
                }
                $this->_objTpl->setVariable(array(
					//'NEWS_CATEGORY_NAME' => $objNews->fields['catname'],
					'NEWS_ID' => $objNews->fields['id'],
					'NEWS_CATEGORY_ID' => $objNews->fields['catid'],
                    //'NEWS_DATE' => date(ASCMS_DATE_FORMAT_DATE, $objNews->fields['date']),
					//'NEWS_LONG_DATE' => date(ASCMS_DATE_FORMAT_DATETIME, $objNews->fields['date']),
                    'NEWS_TITLE' => contrexx_raw2xhtml($objNews->fields['title']),
                    //'NEWS_URL' => $newslink,
					'NEWS_IMAGE_PATH' => contrexx_raw2encodedUrl($imageSrc),
					'NEWS_TEASER_TEXT' => contrexx_raw2xhtml($newsteasertext),
					//'NEWS_TEXT' => $newstext,
					//'NEWS_AUTHOR' => $author,
					//'NEWS_TYPE_NAME' => $objNews->fields['typename'],
                    //'TXT_LINK_TO_REPORT_INFO_SOURCES' => $_ARRAYLANG['TXT_LINK_TO_REPORT_INFO_SOURCES']
                ));
                $this->_objTpl->parse("news_list");
                $objNews->MoveNext();
            }
        } else {
			$this->_objTpl->setVariable('NEWS_EMPTY_LIST', $_ARRAYLANG['TXT_NEWSLETTER_NEWS_EMPTY_LIST']);
		}
    }

    function _getNewsPreviewPage()
    {
        global $objDatabase, $_ARRAYLANG;

		JS::activate('cx');

		$mailTemplate = isset($_POST['newsletter_mail_template']) ? intval($_POST['newsletter_mail_template']) : '1';
		$importTemplate = isset($_POST['newsletter_import_template']) ? intval($_POST['newsletter_mail_template']) : '2';
		if(isset($_GET['view']) && $_GET['view'] == 'iframe')
		{
			$selectedNews = isset($_POST['selected']) ? contrexx_input2db($_POST['selected']) : '';
			$mailTemplate = isset($_POST['emailtemplate']) ? intval($_POST['emailtemplate']) : '1';
			$importTemplate = isset($_POST['importtemplate']) ? intval($_POST['importtemplate']) : '2';

			$HTML_TemplateSource_Import = $this->_getBodyContent($this->_prepareNewsPreview($this->GetTemplateSource($importTemplate, 'html')));

			$_REQUEST['standalone'] = true;
			$this->_objTpl = new \Cx\Core\Html\Sigma();
			CSRF::add_placeholder($this->_objTpl);
			$this->_objTpl->setTemplate($HTML_TemplateSource_Import);

            $query = '  SELECT  n.id                AS newsid,
                                n.userid            AS newsuid,
                                n.date              AS newsdate,
                                n.teaser_image_path,
                                n.teaser_image_thumbnail_path,
                                n.redirect,
                                n.publisher,
                                n.publisher_id,
                                n.author,
                                n.author_id,
                                n.catid,
                                nl.title            AS newstitle,
                                nl.text             AS newscontent,
                                nl.teaser_text,
                                nc.name             AS name
                    FROM        '.DBPREFIX.'module_news AS n
                    INNER JOIN  '.DBPREFIX.'module_news_locale AS nl ON nl.news_id = n.id
                    INNER JOIN  '.DBPREFIX.'module_news_categories_locale AS nc ON nc.category_id=n.catid
                    WHERE       status = 1
                                AND nl.is_active=1
                                AND nl.lang_id='.FRONTEND_LANG_ID.'
                                AND nc.lang_id='.FRONTEND_LANG_ID.'
                                AND n.id IN ('.$selectedNews.')
                    ORDER BY nc.name ASC, n.date DESC';

			$objNews = $objDatabase->Execute($query);
			$objFWUser = FWUser::getFWUserObject();
			$current_category = '';
			if ($this->_objTpl->blockExists('news_list')) {
				if ($objNews !== false) {
					while (!$objNews->EOF) {
						$this->_objTpl->setVariable(array(
							'NEWS_CATEGORY_NAME' => $objNews->fields['name']
						));
						if($current_category == $objNews->fields['catid'])
							$this->_objTpl->hideBlock("news_category");
						$current_category = $objNews->fields['catid'];
                        $newsid         = $objNews->fields['newsid'];
                        $newstitle      = $objNews->fields['newstitle'];
                        $newsUrl        = empty($objNews->fields['redirect'])
                                            ? (empty($objNews->fields['newscontent'])
                                                ? ''
                                                : 'index.php?section=news&cmd=details&newsid='.$newsid)
                                            : $objNews->fields['redirect'];

						$newstext = ltrim(strip_tags($objNews->fields['newscontent']));
						$newsteasertext = ltrim(strip_tags($objNews->fields['teaser_text']));
						$newslink = \Cx\Core\Routing\Url::fromModuleAndCmd('news', 'details', '', array('newsid' => $objNews->fields['newsid']));
						if ($objNews->fields['newsuid'] && ($objUser = $objFWUser->objUser->getUser($objNews->fields['newsuid']))) {
							$author = htmlentities($objUser->getUsername(), ENT_QUOTES, CONTREXX_CHARSET);
						} else {
							$author = $_ARRAYLANG['TXT_ANONYMOUS'];
						}

                        list($image, $htmlLinkImage, $imageSource) = newsLibrary::parseImageThumbnail($objNews->fields['teaser_image_path'],
                                                                                               $objNews->fields['teaser_image_thumbnail_path'],
                                                                                               $newstitle,
                                                                                               $newsUrl);

						$this->_objTpl->setVariable(array(
							'NEWS_CATEGORY_NAME' => $objNews->fields['name'],
							'NEWS_DATE' => date(ASCMS_DATE_FORMAT_DATE, $objNews->fields['newsdate']),
							'NEWS_LONG_DATE' => date(ASCMS_DATE_FORMAT_DATETIME, $objNews->fields['newsdate']),
							'NEWS_TITLE' => contrexx_raw2xhtml($newstitle),
							'NEWS_URL' => $newslink,
							'NEWS_TEASER_TEXT' => $newsteasertext,
							'NEWS_TEXT' => $newstext,
							'NEWS_AUTHOR' => $author,
						));

                        $imageTemplateBlock = "news_image";
                        if (!empty($image)) {
                            $this->_objTpl->setVariable(array(
                                'NEWS_IMAGE'         => $image,
                                'NEWS_IMAGE_SRC'     => contrexx_raw2xhtml($imageSource),
                                'NEWS_IMAGE_ALT'     => contrexx_raw2xhtml($newstitle),
                                'NEWS_IMAGE_LINK'    => $htmlLinkImage,
                            ));

                            if ($this->_objTpl->blockExists($imageTemplateBlock)) {
                                $this->_objTpl->parse($imageTemplateBlock);
                            }
                        } else {
                            if ($this->_objTpl->blockExists($imageTemplateBlock)) {
                                $this->_objTpl->hideBlock($imageTemplateBlock);
                            }
                        }

						$this->_objTpl->parse("news_list");
						$objNews->MoveNext();
					}
				}
				$parsedNewsList = $this->_objTpl->get();
			}
			else {
				if ($objNews !== false) {
					$parsedNewsList = '';
					while (!$objNews->EOF) {
						$content = $this->_getBodyContent($this->GetTemplateSource($importTemplate, 'html'));
						$newstext = ltrim(strip_tags($objNews->fields['newscontent']));
						$newsteasertext = substr(ltrim(strip_tags($objNews->fields['teaser_text'])), 0, 100);
						$newslink = \Cx\Core\Routing\Url::fromModuleAndCmd(
                            'news', 'detals', '',
                            array('newsid' => $objNews->fields['newsid']));
						if ($objNews->fields['newsuid'] && ($objUser = $objFWUser->objUser->getUser($objNews->fields['newsuid']))) {
							$author = htmlentities($objUser->getUsername(), ENT_QUOTES, CONTREXX_CHARSET);
						} else {
							$author = $_ARRAYLANG['TXT_ANONYMOUS'];
						}
						$search = array(
							'[[NEWS_DATE]]',
							'[[NEWS_LONG_DATE]]',
							'[[NEWS_TITLE]]',
							'[[NEWS_URL]]',
							'[[NEWS_IMAGE_PATH]]',
							'[[NEWS_TEASER_TEXT]]',
							'[[NEWS_TEXT]]',
							'[[NEWS_AUTHOR]]',
							'[[NEWS_TYPE_NAME]]',
							'[[NEWS_CATEGORY_NAME]]'
						);
						$replace = array(
							date(ASCMS_DATE_FORMAT_DATE, $objNews->fields['newsdate']),
							date(ASCMS_DATE_FORMAT_DATETIME, $objNews->fields['newsdate']),
							$objNews->fields['newstitle'],
							$newslink,
							htmlentities($objNews->fields['teaser_image_thumbnail_path'], ENT_QUOTES, CONTREXX_CHARSET),
							$newsteasertext,
							$newstext,
							$author,
							$objNews->fields['typename'],
							$objNews->fields['name']
						);
						$content = str_replace($search, $replace, $content);
						if($parsedNewsList != '')
							$parsedNewsList .= "<br/>".$content;
						else
							$parsedNewsList = $content;
						$objNews->MoveNext();
					}
				}
			}
			$previewHTML = str_replace("[[content]]", $parsedNewsList, $this->GetTemplateSource($mailTemplate, 'html'));
			$this->_objTpl->setTemplate($previewHTML);
			return $this->_objTpl->get();
		} else {
            $selected = isset($_POST['SelectedNews']) ? $_POST['SelectedNews'] : '';
            $selectedNews = implode(",", $selected);

		    $this->_pageTitle = $_ARRAYLANG['TXT_NEWSLETTER_NEWS_IMPORT_PREVIEW'];
			$this->_objTpl->loadTemplateFile('newsletter_news_preview.html');
			$this->_objTpl->setVariable(array(
            'TXT_EMAIL_LAYOUT' => $_ARRAYLANG['TXT_NEWSLETTER_NEWS_EMAIL_LAYOUT'],
			'TXT_IMPORT_LAYOUT' => $_ARRAYLANG['TXT_NEWSLETTER_NEWS_IMPORT_LAYOUT'],
            'TXT_NEWS_PREVIEW' => $_ARRAYLANG['TXT_NEWSLETTER_NEWS_PREVIEW'],
			'TXT_CREATE_EMAIL' => $_ARRAYLANG['TXT_NEWSLETTER_NEWS_CREATE_EMAIL'],
			'NEWSLETTER_MAIL_TEMPLATE_MENU' => $this->_getTemplateMenu($mailTemplate, 'id="newsletter_mail_template" name="newsletter_mail_template" style="width:300px;" onchange="refreshIframe();"'),
			'NEWSLETTER_IMPORT_TEMPLATE_MENU' => $this->_getTemplateMenu($importTemplate, 'id="newsletter_import_template" name="newsletter_import_template" style="width:300px;" onchange="refreshIframe();"', 'news'),
			'NEWSLETTER_SELECTED_NEWS' => $selectedNews,
			'NEWSLETTER_SELECTED_EMAIL_TEMPLATE' => $mailTemplate,
			'NEWSLETTER_SELECTED_IMPORT_TEMPLATE' => $importTemplate
			));
		}
    }

	function _prepareNewsPreview($TemplateSource)
    {
		$TemplateSource = str_replace("[[","{",$TemplateSource);
		$TemplateSource = str_replace("]]","}",$TemplateSource);
		return $TemplateSource;
	}

    function exportuser()
    {
        global $_ARRAYLANG;

        $separator = ';';
        $listId = isset($_REQUEST['listId']) ? intval($_REQUEST['listId']) : 0;
// TODO: use FWUSER
        $arrRecipientTitles = $this->_getRecipientTitles();
        if ($listId > 0) {
            $list = $this->_getList($listId);
            $listname = $list['name'];
        } else {
            $listname = "all_lists";
        }
        /*
        $query    = "    SELECT * FROM ".DBPREFIX."module_newsletter_rel_user_cat
                    RIGHT JOIN ".DBPREFIX."module_newsletter_user
                        ON ".DBPREFIX."module_newsletter_rel_user_cat.user=".DBPREFIX."module_newsletter_user.id ".
                    $WhereStatement." GROUP BY user";
        */

// TODO: $WhereStatement is not defined
$WhereStatement = '';
        list ($users, $count) = $this->returnNewsletterUser(
            $WhereStatement, $order = '', $listId);
// TODO: $count is never used
++$count;

// TODO: $query is not defined, this has probably been superseeded by the
// method call above?
//        $objResult     = $objDatabase->Execute($query);
        $StringForFile = $_ARRAYLANG['TXT_NEWSLETTER_STATUS'].$separator;
        $StringForFile .= $_ARRAYLANG['TXT_NEWSLETTER_EMAIL_ADDRESS'].$separator;
        $StringForFile .= $_ARRAYLANG['TXT_NEWSLETTER_SEX'].$separator;
        $StringForFile .= $_ARRAYLANG['TXT_NEWSLETTER_SALUTATION'].$separator;
        $StringForFile .= $_ARRAYLANG['TXT_NEWSLETTER_TITLE'].$separator;
        $StringForFile .= $_ARRAYLANG['TXT_NEWSLETTER_LASTNAME'].$separator;
        $StringForFile .= $_ARRAYLANG['TXT_NEWSLETTER_FIRSTNAME'].$separator;
        $StringForFile .= $_ARRAYLANG['TXT_NEWSLETTER_POSITION'].$separator;
        $StringForFile .= $_ARRAYLANG['TXT_NEWSLETTER_COMPANY'].$separator;
        $StringForFile .= $_ARRAYLANG['TXT_NEWSLETTER_INDUSTRY_SECTOR'].$separator;
        $StringForFile .= $_ARRAYLANG['TXT_NEWSLETTER_ADDRESS'].$separator;
        $StringForFile .= $_ARRAYLANG['TXT_NEWSLETTER_ZIP'].$separator;
        $StringForFile .= $_ARRAYLANG['TXT_NEWSLETTER_CITY'].$separator;
        $StringForFile .= $_ARRAYLANG['TXT_NEWSLETTER_COUNTRY'].$separator;
        $StringForFile .= $_ARRAYLANG['TXT_NEWSLETTER_COUNTRY_ID'].$separator;
        $StringForFile .= $_ARRAYLANG['TXT_NEWSLETTER_PHONE'].$separator;
        $StringForFile .= $_ARRAYLANG['TXT_NEWSLETTER_PHONE_PRIVATE'].$separator;
        $StringForFile .= $_ARRAYLANG['TXT_NEWSLETTER_PHONE_MOBILE'].$separator;
        $StringForFile .= $_ARRAYLANG['TXT_NEWSLETTER_FAX'].$separator;
        $StringForFile .= $_ARRAYLANG['TXT_NEWSLETTER_BIRTHDAY'].$separator;
        $StringForFile .= $_ARRAYLANG['TXT_NEWSLETTER_WEBSITE'].$separator;
        $StringForFile .= $_ARRAYLANG['TXT_NEWSLETTER_NOTES'];
        $StringForFile .= chr(13).chr(10);

        foreach ($users as $user) {
            $StringForFile .= $user['status'].$separator;
            $StringForFile .= $user['email'].$separator;
            $StringForFile .= $user['sex'].$separator;
            $StringForFile .= $arrRecipientTitles[$user['salutation']].$separator;
            $StringForFile .= $user['title'].$separator;
            $StringForFile .= $user['lastname'].$separator;
            $StringForFile .= $user['firstname'].$separator;
            $StringForFile .= $user['position'].$separator;
            $StringForFile .= $user['company'].$separator;
            $StringForFile .= $user['industry_sector'].$separator;
            $StringForFile .= $user['address'].$separator;
            $StringForFile .= $user['zip'].$separator;
            $StringForFile .= $user['city'].$separator;
            $StringForFile .= FWUser::getFWUserObject()->objUser->objAttribute->getById('country_'.$user['country_id'])->getName().$separator;
            $StringForFile .= $user['country_id'].$separator;
            $StringForFile .= $user['phone_office'].$separator;
            $StringForFile .= $user['phone_private'].$separator;
            $StringForFile .= $user['phone_mobile'].$separator;
            $StringForFile .= $user['fax'].$separator;
            $StringForFile .= $user['birthday'].$separator;
            $StringForFile .= $user['uri'].$separator;
            $StringForFile .= $user['notes'];
            $StringForFile .= chr(13).chr(10);
        }
        if (strtolower(CONTREXX_CHARSET) == 'utf-8') {
            $StringForFile = utf8_decode($StringForFile);
        }
        header("Content-Type: text/comma-separated-values");
        header('Content-Disposition: attachment; filename="'.date('Y_m_d')."-".$listname.'.csv"');
        die($StringForFile);
    }


    function edituserSort()
    {
        global $_CONFIG;

        $output = array(
            'recipient_count'   => 0,
            'user' => array()
        );

        $fieldValues = array('status', 'email', 'uri', 'company', 'lastname', 'firstname', 'address', 'zip', 'city', 'country_id', 'feedback', 'emaildate', );
        $field  = !empty($_REQUEST['field']) && in_array($_REQUEST['field'], $fieldValues) ? $_REQUEST['field'] : 'emaildate';
        $order  = !empty($_REQUEST['order']) && $_REQUEST['order'] == 'desc' ? 'desc' : 'asc';
        $listId = !empty($_REQUEST['list'])  ? intval($_REQUEST['list']) : '';
        $limit  = !empty($_REQUEST['limit']) ? intval($_REQUEST['limit']) : $_CONFIG['corePagingLimit'];
        $pos    = !empty($_REQUEST['pos'])   ? intval($_REQUEST['pos']) : 0;

        if ($field == 'country') $field = 'country_id';

        $keyword = !empty($_REQUEST['keyword']) ? contrexx_raw2db(trim($_REQUEST['keyword'])) : '';
        $searchfield  = !empty($_REQUEST['filter_attribute']) && in_array($_REQUEST['filter_attribute'], $fieldValues) ? $_REQUEST['filter_attribute'] : '';
        $searchstatus = isset($_REQUEST['filter_status']) ? ($_REQUEST['filter_status'] == '1' ? '1' : ($_REQUEST['filter_status'] == '0' ? '0' : null)) : null;

        // don't ignore search stuff
        $search_where = '';
        if (!empty($keyword)) {
            if (!empty($searchfield)) {
                $search_where = "AND `$searchfield` LIKE '%$keyword%'";
            } else {
                $search_where = 'AND (     email LIKE "%'.$keyword.'%"
                                        OR company LIKE "%'.$keyword.'%"
                                        OR lastname LIKE "%'.$keyword.'%"
                                        OR firstname LIKE "%'.$keyword.'%"
                                        OR address LIKE "%'.$keyword.'%"
                                        OR zip LIKE "%'.$keyword.'%"
                                        OR city LIKE "%'.$keyword.'%"'.
                                        /*OR country_id LIKE "%'.$keyword.'%"*/'
                                        OR phone_office LIKE "%'.$keyword.'%"
                                        OR birthday LIKE "%'.$keyword.'%")';
            }
        }

        /*if ($searchstatus !== null) {
            $search_where .= " AND `status` = $searchstatus ";
        }*/

        list ($users, $output['recipient_count']) = $this->returnNewsletterUser(
            $search_where, "ORDER BY `$field` $order", $listId, $searchstatus, $limit, $pos);

        $linkCount            = array();
        $feedbackCount        = array();
        $emailCount           = array();
        $this->feedback($users, $linkCount, $feedbackCount, $emailCount);

        foreach ($users as $user) {
            $type = str_replace("_user", "", $user['type']);
            $link_count = isset($linkCount[$user['id']][$type]) ? $linkCount[$user['id']][$type] : 0;
            $feedback = isset($feedbackCount[$user['id']][$type]) ? $feedbackCount[$user['id']][$type] : 0;
            $feedbackdata = $link_count > 0 ? round(100 / $link_count * $feedback).'%' : '-';

            $country = empty($user['country_id'])
                ? ''
                : FWUser::getFWUserObject()->objUser->objAttribute->getById(
                    'country_'.$user['country_id'])->getName();

            $output['user'][] = array(
                'id'        => $user['id'],
                'status'    => $user['status'],
                'email'     => $user['email'],
                'company'   => empty($user['company']) ? '-' : $user['company'],
                'lastname'  => empty($user['lastname']) ? '-' : (mb_strlen($user['lastname'], CONTREXX_CHARSET) > 30) ? mb_substr($user['lastname'], 0, 27, CONTREXX_CHARSET).'...' : $user['lastname'],
                'firstname' => empty($user['firstname']) ? '-' : (mb_strlen($user['firstname'], CONTREXX_CHARSET) > 30) ? mb_substr($user['firstname'], 0, 27, CONTREXX_CHARSET).'...' : $user['firstname'],
                'address'   => empty($user['address']) ? '-' : $user['address'],
                'zip'       => empty($user['zip']) ? '-' : $user['zip'],
                'city'      => empty($user['city']) ? '-' : $user['city'],
                'country'   => $country,
                'feedback'  => $feedbackdata,
                'emaildate' => date(ASCMS_DATE_FORMAT, $user['emaildate']),
                'type'      => $type
            );
        }
        die(json_encode($output));
    }


// TODO: Refactor this method
// TODO: $emailCount never used!!
    function feedback(&$users, &$linkCount, &$feedbackCount, &$emailCount)
    {
        global $objDatabase;

        // count feedback
        $newsletterUserIds    = array();
        $newsletterUserEmails = array();
        $accessUserIds        = array();
        $accessUserEmails     = array();

        // ATTENTION: this very use of $user['type'] is not related to self::USER_TYPE_ACCESS, self::USER_TYPE_CORE or self::USER_TYPE_NEWSLETTER!
        foreach ($users as $user) {
            if ($user['type'] == 'newsletter_user') {
                $newsletterUserIds[] = $user['id'];
                $newsletterUserEmails[] = $user['email'];
            } elseif ($user['type'] == 'access_user') {
                $accessUserIds[] = $user['id'];
                $accessUserEmails[] = $user['email'];
            }
        }

        // select stats of native newsletter recipients
        if (count($newsletterUserIds) > 0) {
            $objLinks = $objDatabase->Execute("SELECT
                    tlbUser.id,
                    COUNT(tlbLink.id) AS link_count,
                    COUNT(DISTINCT tblSent.newsletter) AS email_count
                FROM ".DBPREFIX."module_newsletter_tmp_sending AS tblSent
                    INNER JOIN ".DBPREFIX."module_newsletter_user AS tlbUser ON tlbUser.email = tblSent.email
                    LEFT JOIN ".DBPREFIX."module_newsletter_email_link AS tlbLink ON tlbLink.email_id = tblSent.newsletter
                WHERE tblSent.email IN ('".implode("', '", $newsletterUserEmails)."') AND tblSent.sendt > 0 AND tblSent.type = '".self::USER_TYPE_NEWSLETTER."'
                GROUP BY tblSent.email");
            if ($objLinks !== false) {
                while (!$objLinks->EOF) {
                    $linkCount[$objLinks->fields['id']][self::USER_TYPE_NEWSLETTER] = $objLinks->fields['link_count'];
                    $emailCount[$objLinks->fields['id']][self::USER_TYPE_NEWSLETTER] = $objLinks->fields['email_count'];
                    $objLinks->MoveNext();
                }
            }

            $objLinks = $objDatabase->Execute("SELECT
                    tblLink.recipient_id,
                    COUNT(tblLink.id) AS feedback_count
                FROM ".DBPREFIX."module_newsletter_email_link_feedback AS tblLink
                WHERE tblLink.recipient_id IN (".implode(", ", $newsletterUserIds).") AND tblLink.recipient_type = '".self::USER_TYPE_NEWSLETTER."'
                GROUP BY tblLink.recipient_id");
            if ($objLinks !== false) {
                while (!$objLinks->EOF) {
                    $feedbackCount[$objLinks->fields['recipient_id']][self::USER_TYPE_NEWSLETTER] = $objLinks->fields['feedback_count'];
                    $objLinks->MoveNext();
                }
            }
        }

        // select stats of access users
        if (count($accessUserIds) > 0) {
            $objLinks = $objDatabase->Execute("SELECT
                    tlbUser.id,
                    COUNT(tlbLink.id) AS link_count,
                    COUNT(DISTINCT tblSent.newsletter) AS email_count
                FROM ".DBPREFIX."module_newsletter_tmp_sending AS tblSent
                    INNER JOIN ".DBPREFIX."access_users AS tlbUser ON tlbUser.email = tblSent.email
                    LEFT JOIN ".DBPREFIX."module_newsletter_email_link AS tlbLink ON tlbLink.email_id = tblSent.newsletter
                WHERE tblSent.email IN ('".implode("', '", $accessUserEmails)."') AND tblSent.sendt > 0 AND (tblSent.type = '".self::USER_TYPE_ACCESS."' OR tblSent.type = '".self::USER_TYPE_CORE."')
                GROUP BY tblSent.email");
            if ($objLinks !== false) {
                while (!$objLinks->EOF) {
                    $linkCount[$objLinks->fields['id']][self::USER_TYPE_ACCESS] = $objLinks->fields['link_count'];
                    $emailCount[$objLinks->fields['id']][self::USER_TYPE_ACCESS] = $objLinks->fields['email_count'];
                    $objLinks->MoveNext();
                }
            }
            $objLinks = $objDatabase->Execute("SELECT
                    tblLink.recipient_id,
                    COUNT(tblLink.id) AS feedback_count
                FROM ".DBPREFIX."module_newsletter_email_link_feedback AS tblLink
                WHERE tblLink.recipient_id IN (".implode(", ", $accessUserIds).") AND tblLink.recipient_type = '".self::USER_TYPE_ACCESS."'
                GROUP BY tblLink.recipient_id");
            if ($objLinks !== false) {
                while (!$objLinks->EOF) {
                    $feedbackCount[$objLinks->fields['recipient_id']][self::USER_TYPE_ACCESS] = $objLinks->fields['feedback_count'];
                    $objLinks->MoveNext();
                }
            }
        }
    }




    function importuser()
    {
        global $objDatabase, $_ARRAYLANG;

        $objTpl = new \Cx\Core\Html\Sigma(ASCMS_MODULE_PATH.'/newsletter/template');
        CSRF::add_placeholder($objTpl);
        $objTpl->setErrorHandling(PEAR_ERROR_DIE);

        require_once ASCMS_LIBRARY_PATH."/importexport/import.class.php";
        $objImport = new Import();
        $arrFields = array(
            'email'           => $_ARRAYLANG['TXT_NEWSLETTER_EMAIL_ADDRESS'],
            'sex'             => $_ARRAYLANG['TXT_NEWSLETTER_SEX'],
            'salutation'      => $_ARRAYLANG['TXT_NEWSLETTER_SALUTATION'],
            'title'           => $_ARRAYLANG['TXT_NEWSLETTER_TITLE'],
            'lastname'        => $_ARRAYLANG['TXT_NEWSLETTER_LASTNAME'],
            'firstname'       => $_ARRAYLANG['TXT_NEWSLETTER_FIRSTNAME'],
            'position'        => $_ARRAYLANG['TXT_NEWSLETTER_POSITION'],
            'company'         => $_ARRAYLANG['TXT_NEWSLETTER_COMPANY'],
            'industry_sector' => $_ARRAYLANG['TXT_NEWSLETTER_INDUSTRY_SECTOR'],
            'address'         => $_ARRAYLANG['TXT_NEWSLETTER_ADDRESS'],
            'zip'             => $_ARRAYLANG['TXT_NEWSLETTER_ZIP'],
            'city'            => $_ARRAYLANG['TXT_NEWSLETTER_CITY'],
            'country_id'      => $_ARRAYLANG['TXT_NEWSLETTER_COUNTRY'],
            'phone_office'    => $_ARRAYLANG['TXT_NEWSLETTER_PHONE'],
            'phone_private'   => $_ARRAYLANG['TXT_NEWSLETTER_PHONE_PRIVATE'],
            'phone_mobile'    => $_ARRAYLANG['TXT_NEWSLETTER_PHONE_MOBILE'],
            'fax'             => $_ARRAYLANG['TXT_NEWSLETTER_FAX'],
            'birthday'        => $_ARRAYLANG['TXT_NEWSLETTER_BIRTHDAY'],
            'uri'             => $_ARRAYLANG['TXT_NEWSLETTER_WEBSITE'],
            'notes'           => $_ARRAYLANG['TXT_NEWSLETTER_NOTES'],
            'language'        => $_ARRAYLANG['TXT_NEWSLETTER_LANGUAGE']
        );

        if (isset($_POST['import_cancel'])) {
            // Abbrechen. Siehe Abbrechen
            $objImport->cancel();
            CSRF::header("Location: index.php?cmd=newsletter&act=users&tpl=import");
            exit;
        } elseif (isset($_POST['fieldsSelected'])) {
            // Speichern der Daten. Siehe Final weiter unten.
            $arrRecipients = $objImport->getFinalData($arrFields);

            if (empty($_POST['newsletter_recipient_associated_list'])) {
                self::$strErrMessage = $_ARRAYLANG['TXT_NEWSLETTER_SELECT_CATEGORY'];
            } else {
                $arrLists = array();

                if (isset($_POST['newsletter_recipient_associated_list'])) {
                    foreach (explode(',', $_POST['newsletter_recipient_associated_list']) as $listId) {
                        array_push($arrLists, intval($listId));             
                    }                
                }
                $EmailCount = 0;
                $arrBadEmails = array();
                $ExistEmails = 0;
                $NewEmails = 0;
                $recipientSendEmailId = (isset($_POST['sendEmail'])) ? intval($_POST['sendEmail']) : 0;
                foreach ($arrRecipients as $arrRecipient) {
                    if (empty($arrRecipient['email'])) {
                        continue;
                    }
                    if (!strpos($arrRecipient['email'],'@')) {
                        continue;
                    }

                    $arrRecipient['email'] = trim($arrRecipient['email']);
                    if (!\FWValidator::isEmail($arrRecipient['email'])) {
                        array_push($arrBadEmails, $arrRecipient['email']);
                    } else {
                        $EmailCount++;
                        $arrRecipientLists = $arrLists;

// TODO: use FWUSER
                        if (in_array($arrRecipient['salutation'], $this->_getRecipientTitles())) {
                            $arrRecipientTitles = array_flip($this->_getRecipientTitles());
                            $recipientSalutationId = $arrRecipientTitles[$arrRecipient['salutation']];
                        } else {
                            $recipientSalutationId = $this->_addRecipientTitle($arrRecipient['salutation']);
                        }

                        // try to parse the imported birthday in a usable format
                        if (!empty($arrRecipient['birthday'])) {
                            $arrDate = date_parse($arrRecipient['birthday']);
                            $arrRecipient['birthday'] = $arrDate['day'].'-'.$arrDate['month'].'-'.$arrDate['year'];
                        }

                        $objRecipient = $objDatabase->SelectLimit("SELECT `id`,
                                                                          `language`,
                                                                          `status`,
                                                                          `notes`
                                                                   FROM `".DBPREFIX."module_newsletter_user`
                                                                   WHERE `email` = '".addslashes($arrRecipient['email'])."'", 1);
                        if ($objRecipient->RecordCount() == 1) {

                            $recipientId       = $objRecipient->fields['id'];
                            $recipientLanguage = $objRecipient->fields['language'];
                            $recipientStatus   = $objRecipient->fields['status'];
                            $recipientNotes    = (!empty($objRecipient->fields['notes']) ? $objRecipient->fields['notes'].' '.$arrRecipient['notes'] : $arrRecipient['notes']);

                            $objList = $objDatabase->Execute("SELECT `category` FROM ".DBPREFIX."module_newsletter_rel_user_cat WHERE user=".$recipientId);
                            if ($objList !== false) {
                                while (!$objList->EOF) {
                                    array_push($arrRecipientLists, $objList->fields['category']);
                                    $objList->MoveNext();
                                }
                            }
                            $arrRecipientLists = array_unique($arrRecipientLists);

                            $recipientAttributeStatus = array();
                            $this->_updateRecipient($recipientAttributeStatus, $recipientId, $arrRecipient['email'], $arrRecipient['uri'], $arrRecipient['sex'],
                                            $recipientSalutationId, $arrRecipient['title'], $arrRecipient['lastname'], $arrRecipient['firstname'],
                                            $arrRecipient['position'], $arrRecipient['company'], $arrRecipient['industry_sector'],
                                            $arrRecipient['address'], $arrRecipient['zip'], $arrRecipient['city'], $arrRecipient['country_id'],
                                            $arrRecipient['phone_office'], $arrRecipient['phone_private'], $arrRecipient['phone_mobile'],
                                            $arrRecipient['fax'], $recipientNotes, $arrRecipient['birthday'], $recipientStatus, $arrRecipientLists,
                                            $recipientLanguage);

                            $ExistEmails++;
                        } else {
                            $NewEmails ++;

                            if (!$this->_addRecipient($arrRecipient['email'], $arrRecipient['uri'], $arrRecipient['sex'], $recipientSalutationId, $arrRecipient['title'], $arrRecipient['lastname'], $arrRecipient['firstname'], $arrRecipient['position'], $arrRecipient['company'], $arrRecipient['industry_sector'], $arrRecipient['address'], $arrRecipient['zip'], $arrRecipient['city'], $arrRecipient['country_id'], $arrRecipient['phone_office'], $arrRecipient['phone_private'], $arrRecipient['phone_mobile'], $arrRecipient['fax'], $arrRecipient['notes'], $arrRecipient['birthday'], 1, $arrRecipientLists, $arrRecipient['language'])) {
                                array_push($arrBadEmails, $arrRecipient['email']);
                            } elseif (!empty($recipientSendEmailId)) {
                                $objRecipient = $objDatabase->SelectLimit("
                                    SELECT id
                                    FROM ".DBPREFIX."module_newsletter_user
                                        WHERE email='".contrexx_input2db(
// TODO: Undefined
//                                        $recipientEmail
// Should probably be
                                        $arrRecipient['email']
                                            )."'", 1);
                                $recipientId  = $objRecipient->fields['id'];

                                $this->insertTmpEmail($recipientSendEmailId, $arrRecipient['email'], self::USER_TYPE_NEWSLETTER);
// setting TmpEntry=1 will set the newsletter status=1, this will force an imediate stop in the newsletter send procedere.
                                if ($this->SendEmail($recipientId, $recipientSendEmailId, $arrRecipient['email'], 1, self::USER_TYPE_NEWSLETTER) == false) {
                                    self::$strErrMessage .= $_ARRAYLANG['TXT_SENDING_MESSAGE_ERROR'];
                                } else {
// TODO: Unused
//                                    $objUpdateCount    =
                                    $objDatabase->execute('
                                        UPDATE '.DBPREFIX.'module_newsletter
                                        SET recipient_count = recipient_count+1
                                        WHERE id='.intval($recipientSendEmailId));
                                }
                            }
                        }
                    }
                }
                self::$strOkMessage = $_ARRAYLANG['TXT_DATA_IMPORT_SUCCESSFUL']."<br/>"
                                        .$_ARRAYLANG['TXT_CORRECT_EMAILS'].": ".$EmailCount."<br/>"
                                        .$_ARRAYLANG['TXT_NOT_VALID_EMAILS'].": ".implode(', ', $arrBadEmails)."<br/>"
                                        .$_ARRAYLANG['TXT_EXISTING_EMAILS'].": ".$ExistEmails."<br/>"
                                        .$_ARRAYLANG['TXT_NEW_ADDED_EMAILS'].": ".$NewEmails;

                $objImport->initFileSelectTemplate($objTpl);
                $objTpl->setVariable(array(
                    "IMPORT_ACTION" => "index.php?cmd=newsletter&amp;act=users&amp;tpl=import",
                    'TXT_FILETYPE' => $_ARRAYLANG['TXT_NEWSLETTER_FILE_TYPE'],
                    'TXT_HELP' => $_ARRAYLANG['TXT_NEWSLETTER_IMPORT_HELP'],
                    'IMPORT_ADD_NAME' => $_ARRAYLANG['TXT_NEWSLETTER_SEND_EMAIL'],
                    //'IMPORT_ADD_VALUE' => $this->CategoryDropDown(),
                    'IMPORT_ADD_VALUE' => $this->_getEmailsDropDown(),
                    'IMPORT_ROWCLASS' => 'row1'
                ));
                $objTpl->parse("additional");
                $objTpl->setVariable(array(
                    'IMPORT_ADD_NAME' => $_ARRAYLANG['TXT_NEWSLETTER_LIST'],
                    'IMPORT_ADD_VALUE' => $this->_getAssociatedListSelection(),
                    'IMPORT_ROWCLASS' => 'row2'
                ));
                $objTpl->parse("additional");
                $this->_objTpl->setVariable('NEWSLETTER_USER_FILE', $objTpl->get());
            }
        } elseif (   (   empty($_FILES['importfile'])
                      || $_FILES['importfile']['size'] == 0)
                  || (   isset($_POST['imported'])
                      && empty($_POST['newsletter_recipient_associated_list']))) {
            // Dateiauswahldialog. Siehe Fileselect
            $this->_pageTitle = $_ARRAYLANG['TXT_IMPORT'];
            $this->_objTpl->addBlockfile('NEWSLETTER_USER_FILE', 'module_newsletter_user_import', 'module_newsletter_user_import.html');

            if (isset($_POST['imported']) && empty($_POST['newsletter_recipient_associated_list'])) {
                self::$strErrMessage = $_ARRAYLANG['TXT_NEWSLETTER_SELECT_CATEGORY'];
            }

            $objImport->initFileSelectTemplate($objTpl);
            $objTpl->setVariable(array(
                "IMPORT_ACTION" => "index.php?cmd=newsletter&amp;act=users&amp;tpl=import",
                'TXT_FILETYPE' => $_ARRAYLANG['TXT_NEWSLETTER_FILE_TYPE'],
                'TXT_HELP' => $_ARRAYLANG['TXT_NEWSLETTER_IMPORT_HELP'],
                'IMPORT_ADD_NAME' => $_ARRAYLANG['TXT_NEWSLETTER_SEND_EMAIL'],
                //'IMPORT_ADD_VALUE' => $this->CategoryDropDown(),
                'IMPORT_ADD_VALUE' => $this->_getEmailsDropDown(),
                'IMPORT_ROWCLASS' => 'row1'
            ));
            $objTpl->parse("additional");
            $objTpl->setVariable(array(
                'IMPORT_ADD_NAME' => $_ARRAYLANG['TXT_NEWSLETTER_LIST'],
                'IMPORT_ADD_VALUE' => $this->_getAssociatedListSelection(),
                'IMPORT_ROWCLASS' => 'row2'
            ));
            $objTpl->parse("additional");
            $this->_objTpl->setVariable(array(
                'TXT_NEWSLETTER_IMPORT_FROM_FILE' => $_ARRAYLANG['TXT_NEWSLETTER_IMPORT_FROM_FILE'],
                'TXT_IMPORT' => $_ARRAYLANG['TXT_IMPORT'],
                'TXT_NEWSLETTER_LIST' => $_ARRAYLANG['TXT_NEWSLETTER_LIST'],
                'TXT_ENTER_EMAIL_ADDRESS' => $_ARRAYLANG['TXT_ENTER_EMAIL_ADDRESS'],
                'NEWSLETTER_CATEGORY_MENU' => $this->_getAssociatedListSelection(),
                'NEWSLETTER_IMPORT_FRAME' => $objTpl->get(),
            ));

            if (isset($_POST['newsletter_import_plain'])) {
                if (empty($_POST['newsletter_recipient_associated_list'])) {
                    self::$strErrMessage = $_ARRAYLANG['TXT_NEWSLETTER_SELECT_CATEGORY'];
                } else {
                    $arrLists = array();
                
                    if (isset($_POST['newsletter_recipient_associated_list'])) {
                        foreach ($_POST['newsletter_recipient_associated_list'] as $listId) {
                            array_push($arrLists, intval($listId));
                        }                
                    }
                    $EmailList = str_replace(array(']','[',"\t","\n","\r"), ' ', $_REQUEST["Emails"]);
                    $EmailArray = preg_split('/[\s"\';,:<>\n]+/', contrexx_stripslashes($EmailList));
                    $EmailCount = 0;
                    $arrBadEmails = array();
                    $ExistEmails = 0;
                    $NewEmails = 0;
                    foreach ($EmailArray as $email) {
                        if (empty($email)) continue;
                        if (!strpos($email, '@')) continue;
                        if (!FWValidator::isEmail($email)) {
                            array_push($arrBadEmails, $email);
                        } else {
                            $EmailCount++;
                            $objRecipient = $objDatabase->SelectLimit("SELECT `id` FROM `".DBPREFIX."module_newsletter_user` WHERE `email` = '".addslashes($email)."'", 1);
                            if ($objRecipient->RecordCount() == 1) {
                                foreach ($arrLists as $listId) {
                                    $this->_addRecipient2List($objRecipient->fields['id'], $listId);
                                }
                                $ExistEmails++;
                            } else {
                                $NewEmails ++;
                                if ($objDatabase->Execute("
                                    INSERT INTO `".DBPREFIX."module_newsletter_user` (
                                        `code`, `email`, `status`, `emaildate`
                                    ) VALUES (
                                        '".$this->_emailCode()."', '".addslashes($email)."', 1, ".time()."
                                    )"
                                ) !== false) {
                                    $this->_setRecipientLists($objDatabase->Insert_ID(), $arrLists);
                                } else {
                                    array_push($arrBadEmails, $email);
                                }
                            }
                        }
                    }
                    self::$strOkMessage = $_ARRAYLANG['TXT_DATA_IMPORT_SUCCESSFUL']."<br/>".$_ARRAYLANG['TXT_CORRECT_EMAILS'].": ".$EmailCount."<br/>".$_ARRAYLANG['TXT_NOT_VALID_EMAILS'].": &quot;".implode(', ', $arrBadEmails)."&quot;<br/>".$_ARRAYLANG['TXT_EXISTING_EMAILS'].": ".$ExistEmails."<br/>".$_ARRAYLANG['TXT_NEW_ADDED_EMAILS'].": ".$NewEmails;
                }
            }
            $this->_objTpl->parse('module_newsletter_user_import');
        } else {
            // Felderzuweisungsdialog. Siehe Fieldselect
            $objImport->initFieldSelectTemplate($objTpl, $arrFields);

            $arrLists = array();
            if (isset($_POST['newsletter_recipient_associated_list'])) {
                foreach ($_POST['newsletter_recipient_associated_list'] as $listId) {
                    array_push($arrLists, intval($listId));
                }
            }

            $objTpl->setVariable(array(
                'IMPORT_HIDDEN_NAME' => 'newsletter_recipient_associated_list',
                'IMPORT_HIDDEN_VALUE' =>
                    (!empty($arrLists) ? implode(',', $arrLists) : ''),
            ));
            $objTpl->parse('hidden_fields');
            $objTpl->setVariable(array(
                'IMPORT_HIDDEN_NAME' => 'sendEmail',
                'IMPORT_HIDDEN_VALUE' => (isset($_POST['sendEmail']) ? intval($_POST['sendEmail']) : 0),
            ));
            $objTpl->parse('hidden_fields');
            $this->_objTpl->setVariable(array(
                'TXT_REMOVE_PAIR' => $_ARRAYLANG['TXT_REMOVE_PAIR'],
                'NEWSLETTER_USER_FILE' => $objTpl->get(),
            ));
        }
    }

    function _getEmailsDropDown($name='sendEmail', $selected=0, $attrs='')
    {
        global $objDatabase, $_ARRAYLANG;

        $objNewsletterMails = $objDatabase->Execute('SELECT
                                                      id,
                                                      subject
                                                      FROM '.DBPREFIX.'module_newsletter
                                                      ORDER BY status, id DESC');


        $ReturnVar = '<select name="'.$name.'"'.(!empty($attrs) ? ' '.$attrs : '').'>
        <option value="0">'.$_ARRAYLANG['TXT_NEWSLETTER_DO_NOT_SEND_EMAIL'].'</option>';

        if ($objNewsletterMails !== false) {
            while (!$objNewsletterMails->EOF) {
                $ReturnVar .= '<option value="'.$objNewsletterMails->fields['id'].'"'.($objNewsletterMails->fields['id'] == $selected ? 'selected="selected"' : '').'>'.contrexx_raw2xhtml($objNewsletterMails->fields['subject']).'</option>';
                $objNewsletterMails->MoveNext();
            }
        }
        $ReturnVar .= '</select>';

        return $ReturnVar;
    }

    /**
     * Sets the list-categories for an User

     * @param int $CreatedID the ID of the user in the Database
     */
    function _setCategories($CreatedID)
    {
        global $objDatabase, $_ARRAYLANG;

        if (empty($_REQUEST['category'])) {
            $objDatabase->Execute("DELETE FROM ".DBPREFIX."module_newsletter_rel_user_cat WHERE user=$CreatedID");
            $queryIC         = "SELECT id FROM ".DBPREFIX."module_newsletter_category";
            $objResultIC     = $objDatabase->Execute($queryIC);
            if ($objResultIC !== false) {
                while (!$objResultIC->EOF) {
                    $objDatabase->Execute("
                        INSERT INTO ".DBPREFIX."module_newsletter_rel_user_cat (
                            user, category
                        ) VALUES (
                            $CreatedID, ".$objResultIC->fields['id']."
                        )");
                    $objResultIC->MoveNext();
                }
            }
        } else {
            $currentCategories = array(intval($_REQUEST['category']));
            //fetch all current categories that this user is in
            $query = "SELECT * from ".DBPREFIX."module_newsletter_rel_user_cat WHERE user=$CreatedID";
            $objRS = $objDatabase->Execute($query);
            while(!$objRS->EOF) {
                $currentCategories[] = $objRS->fields['category'];
                $objRS->MoveNext();
            }
            //make the categories-array unique
            $uniqueCategories = array_unique($currentCategories);
            //delete all relations from this user
            $objDatabase->Execute("DELETE FROM ".DBPREFIX."module_newsletter_rel_user_cat WHERE user=$CreatedID");

            //re-import the unique categories
            foreach ($uniqueCategories as $catId) {
                if ($catId != 0) {
                    if ($objDatabase->Execute("INSERT INTO ".DBPREFIX."module_newsletter_rel_user_cat
                                    (user, category)
                                    VALUES (".$CreatedID.", ".$catId.")") === false) {
                        return self::$strErrMessage = $_ARRAYLANG['TXT_DATABASE_ERROR'];
                    }
                }
            }
        }
        return true;
    }


    function _getAssociatedListSelection()
    {
        global $_ARRAYLANG;

        $arrLists = self::getLists();
// TODO: Unused
//        $listNr = 1;
        $lists = '';
        foreach ($arrLists as $listId => $arrList) {
// TODO: Unused
//            $column = $listNr % 3;
            $lists .= ' <div style="float:left;width:33%;">
                            <input type="checkbox"
                                 name="newsletter_recipient_associated_list['.intval($listId).']"
                                 id="newsletter_mail_associated_list_'.intval($listId).'"
                                 value="'.intval($listId).'" />
                            <a href="index.php?cmd=newsletter&amp;act=users&amp;newsletterListId='.intval($listId).'"
                               target="_blank" title="'.sprintf($_ARRAYLANG['TXT_NEWSLETTER_SHOW_RECIPIENTS_OF_LIST'], contrexx_raw2xhtml($arrList['name'])).'">
                                   '.contrexx_raw2xhtml($arrList['name']).'
                            </a>
                        </div>';
        }
        return $lists;
    }
    /**
     * delete all inactice recipients
     * @return void
     */
    function _deleteInactiveRecipients()
    {
        global $objDatabase, $_ARRAYLANG;

        $count = 0;
        if ( ($objRS = $objDatabase->Execute('SELECT `id` FROM `'.DBPREFIX.'module_newsletter_user` WHERE `status` = 0 ')) !== false ) {
            while(!$objRS->EOF) {
                $objDatabase->Execute('DELETE FROM `'.DBPREFIX.'module_newsletter_user` WHERE `id` = '. $objRS->fields['id']);
                $objDatabase->Execute('DELETE FROM `'.DBPREFIX.'module_newsletter_rel_user_cat` WHERE `user` = '. $objRS->fields['id']);
                $objRS->MoveNext();
                $count++;
            }
            self::$strOkMessage = $_ARRAYLANG['TXT_NEWSLETTER_INACTIVE_RECIPIENTS_SUCCESSFULLY_DELETED'] . ' ( '. $count .' )';
        } else {
            self::$strErrMessage = $_ARRAYLANG['TXT_DATABASE_ERROR'] . $objDatabase->ErrorMsg();
        }
    }


    function _users()
    {
        global $_ARRAYLANG;

        $this->_pageTitle = $_ARRAYLANG['TXT_NEWSLETTER_RECIPIENTS'];
        $this->_objTpl->loadTemplateFile('module_newsletter_user.html');
        $this->_objTpl->setVariable(array(
            'TXT_NEWSLETTER_OVERVIEW' => $_ARRAYLANG['TXT_NEWSLETTER_OVERVIEW'],
            'TXT_NEWSLETTER_IMPORT' => $_ARRAYLANG['TXT_NEWSLETTER_IMPORT'],
            'TXT_NEWSLETTER_EXPORT' => $_ARRAYLANG['TXT_NEWSLETTER_EXPORT'],
            'TXT_NEWSLETTER_ADD_USER' => $_ARRAYLANG['TXT_NEWSLETTER_ADD_USER'],
        ));

        if (!isset($_REQUEST['tpl'])) {
            $_REQUEST['tpl'] = '';
        }
        switch ($_REQUEST['tpl']) {
            case 'edit':
                $this->_editUser();
                break;
            case 'import':
                $this->importuser();
                break;
            case 'export':
                $this->exportuser();
                break;
            case 'feedback':
                $this->_showRecipientFeedbackAnalysis();
                break;
            default:
                $this->_userList();
                break;
        }
    }


    function configOverview()
    {
        global $_ARRAYLANG;

        $this->_pageTitle = $_ARRAYLANG['TXT_SETTINGS'];
        $this->_objTpl->loadTemplateFile('newsletter_configuration.html');
        $this->_objTpl->setVariable('TXT_TITLE', $_ARRAYLANG['TXT_SETTINGS']);
        $this->_objTpl->setVariable(array(
            'TXT_DISPATCH_SETINGS' => $_ARRAYLANG['TXT_DISPATCH_SETINGS'],
            'TXT_GENERATE_HTML' => $_ARRAYLANG['TXT_GENERATE_HTML'],
            'TXT_CONFIRM_MAIL' => "Aktivierungs E-Mail",
            'TXT_NOTIFICATION_MAIL' => $_ARRAYLANG['TXT_NEWSLETTER_NOTIFICATION_MAIL'],
        ));
    }


    function UserCount()
    {
        global $objDatabase;

        $objResult_value = $objDatabase->Execute("
            SELECT COUNT(*) AS `counter`
              FROM ".DBPREFIX."module_newsletter_user");
        if ($objResult_value !== false && !$objResult_value->EOF) {
            return $objResult_value->fields["counter"];
        }
        return 0;
    }


    function NewsletterSendCount()
    {
        global $objDatabase;

        $objResult_value = $objDatabase->Execute("
            SELECT COUNT(*) AS `counter`
              FROM ".DBPREFIX."module_newsletter
             WHERE status=1");
        if ($objResult_value && !$objResult_value->EOF) {
            return $objResult_value->fields["counter"];
        }
        return 0;
    }


    function NewsletterNotSendCount()
    {
        global $objDatabase;

        $objResult_value = $objDatabase->Execute("
            SELECT COUNT(*) AS `counter`
              FROM ".DBPREFIX."module_newsletter
             WHERE status=0");
        if ($objResult_value && !$objResult_value->EOF) {
            return $objResult_value->fields["counter"];
        }
        return 0;
    }

    function _editUser()
    {
        global $objDatabase, $_ARRAYLANG, $_CORELANG;

        $activeFrontendlang = FWLanguage::getActiveFrontendLanguages();

        $copy = isset($_REQUEST['copy']) && $_REQUEST['copy'] == 1;
        $recipientId = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
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
        $recipientLanguage = (count($activeFrontendlang) == 1) ? key($activeFrontendlang) : '';
        $recipientStatus = (isset($_POST['newsletter_recipient_status'])) ? 1 : (empty($_POST) ? 1 : 0);
        $arrAssociatedLists = array();
        $recipientSendEmailId = isset($_POST['sendEmail']) ? intval($_POST['sendEmail']) : 0;
        $recipientSendMailDisplay = false;

        if (isset($_POST['newsletter_recipient_email'])) {
            $recipientEmail = $_POST['newsletter_recipient_email'];
        }
        if (isset($_POST['newsletter_recipient_uri'])) {
            $recipientUri = $_POST['newsletter_recipient_uri'];
        }
        if (isset($_POST['newsletter_recipient_sex'])) {
            $recipientSex = in_array($_POST['newsletter_recipient_sex'], array('f', 'm')) ? $_POST['newsletter_recipient_sex'] : '';
        }
        if (isset($_POST['newsletter_recipient_salutation'])) {
// TODO: use FWUSER
            $arrRecipientSalutation = $this->_getRecipientTitles();
            $recipientSalutation = in_array($_POST['newsletter_recipient_salutation'], array_keys($arrRecipientSalutation)) ? intval($_POST['newsletter_recipient_salutation']) : 0;
        }
        if (isset($_POST['newsletter_recipient_lastname'])) {
            $recipientLastname = $_POST['newsletter_recipient_lastname'];
        }
        if (isset($_POST['newsletter_recipient_firstname'])) {
            $recipientFirstname = $_POST['newsletter_recipient_firstname'];
        }
        if (isset($_POST['newsletter_recipient_company'])) {
            $recipientCompany = $_POST['newsletter_recipient_company'];
        }
        if (isset($_POST['newsletter_recipient_address'])) {
            $recipientAddress = $_POST['newsletter_recipient_address'];
        }
        if (isset($_POST['newsletter_recipient_zip'])) {
            $recipientZip = $_POST['newsletter_recipient_zip'];
        }
        if (isset($_POST['newsletter_recipient_city'])) {
            $recipientCity = $_POST['newsletter_recipient_city'];
        }
        if (isset($_POST['newsletter_country_id'])) {
            $recipientCountry = $_POST['newsletter_country_id'];
        }
        if (isset($_POST['newsletter_recipient_phone_office'])) {
            $recipientPhoneOffice = $_POST['newsletter_recipient_phone_office'];
        }
        if (isset($_POST['newsletter_recipient_notes'])) {
            $recipientNotes = $_POST['newsletter_recipient_notes'];
        }
        if (isset($_POST['day']) && isset($_POST['month']) && isset($_POST['year'])) {
            $recipientBirthday = str_pad(intval($_POST['day']),2,'0',STR_PAD_LEFT).'-'.str_pad(intval($_POST['month']),2,'0',STR_PAD_LEFT).'-'.intval($_POST['year']);
        }
        if (isset($_POST['newsletter_recipient_title'])) {
            $recipientTitle = $_POST['newsletter_recipient_title'];
        }
        if (isset($_POST['newsletter_recipient_position'])) {
            $recipientPosition = $_POST['newsletter_recipient_position'];
        }
        if (isset($_POST['newsletter_recipient_industry_sector'])) {
            $recipientIndustrySector = $_POST['newsletter_recipient_industry_sector'];
        }
        if (isset($_POST['newsletter_recipient_phone_mobile'])) {
            $recipientPhoneMobile = $_POST['newsletter_recipient_phone_mobile'];
        }
        if (isset($_POST['newsletter_recipient_phone_private'])) {
            $recipientPhonePrivate = $_POST['newsletter_recipient_phone_private'];
        }
        if (isset($_POST['newsletter_recipient_fax'])) {
            $recipientFax = $_POST['newsletter_recipient_fax'];
        }
        if (isset($_POST['language'])) {
            $recipientLanguage = $_POST['language'];
        }

        if (isset($_POST['newsletter_recipient_associated_list'])) {
            foreach ($_POST['newsletter_recipient_associated_list'] as $listId => $status) {
                if (intval($status) == 1) {
                    array_push($arrAssociatedLists, intval($listId));
                }
            }
        }

        // Get interface settings
        $objInterface = $objDatabase->Execute('SELECT `setvalue`
                                                FROM `'.DBPREFIX.'module_newsletter_settings`
                                                WHERE `setname` = "recipient_attribute_status"');
        $recipientAttributeStatus = json_decode($objInterface->fields['setvalue'], true);
          
        if (isset($_POST['newsletter_recipient_save'])) {
            $objValidator = new FWValidator();
            if ($objValidator->isEmail($recipientEmail)) {
                if ($this->_validateRecipientAttributes($recipientAttributeStatus, $recipientUri, $recipientSex, $recipientSalutation, $recipientTitle, $recipientLastname, $recipientFirstname, $recipientPosition, $recipientCompany, $recipientIndustrySector, $recipientAddress, $recipientZip, $recipientCity, $recipientCountry, $recipientPhoneOffice, $recipientPhonePrivate, $recipientPhoneMobile, $recipientFax, $recipientBirthday)) {                    
                    if ($this->_isUniqueRecipientEmail($recipientEmail, $recipientId, $copy)) {
                        //reset the $recipientId on copy function 
                        $recipientId = $copy ? 0 : $recipientId;
                        if ($recipientId > 0) {
                            if ($this->_updateRecipient($recipientAttributeStatus, $recipientId, $recipientEmail, $recipientUri, $recipientSex, $recipientSalutation, $recipientTitle, $recipientLastname, $recipientFirstname, $recipientPosition, $recipientCompany, $recipientIndustrySector, $recipientAddress, $recipientZip, $recipientCity, $recipientCountry, $recipientPhoneOffice, $recipientPhonePrivate, $recipientPhoneMobile, $recipientFax, $recipientNotes, $recipientBirthday, $recipientStatus, $arrAssociatedLists, $recipientLanguage)) {
                                self::$strOkMessage .= $_ARRAYLANG['TXT_NEWSLETTER_RECIPIENT_UPDATED_SUCCESSFULLY'];
                                return $this->_userList();
                            } else {
                                // fall back to old recipient id, if any error occurs on copy
                                $recipientId = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
                                self::$strErrMessage .= $_ARRAYLANG['TXT_NEWSLETTER_ERROR_UPDATE_RECIPIENT'];
                            }
                        } else {
                            if ($this->_addRecipient($recipientEmail, $recipientUri, $recipientSex, $recipientSalutation, $recipientTitle, $recipientLastname, $recipientFirstname, $recipientPosition, $recipientCompany, $recipientIndustrySector, $recipientAddress, $recipientZip, $recipientCity, $recipientCountry, $recipientPhoneOffice, $recipientPhonePrivate, $recipientPhoneMobile, $recipientFax, $recipientNotes, $recipientBirthday, $recipientStatus, $arrAssociatedLists, $recipientLanguage)) {
                                if (!empty($recipientSendEmailId)) {
                                    $objRecipient = $objDatabase->SelectLimit("SELECT id FROM ".DBPREFIX."module_newsletter_user WHERE email='".contrexx_input2db($recipientEmail)."'", 1);
                                    $recipientId  = $objRecipient->fields['id'];

                                    $this->insertTmpEmail($recipientSendEmailId, $recipientEmail, self::USER_TYPE_NEWSLETTER);
// setting TmpEntry=1 will set the newsletter status=1, this will force an imediate stop in the newsletter send procedere.
                                    if ($this->SendEmail($recipientId, $recipientSendEmailId, $recipientEmail, 1, self::USER_TYPE_NEWSLETTER) == false) {
                                        // fall back to old recipient id, if any error occurs on copy
                                        $recipientId = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
                                        self::$strErrMessage .= $_ARRAYLANG['TXT_SENDING_MESSAGE_ERROR'];
                                    } else {
                                        $objRecipientCount = $objDatabase->execute('SELECT subject FROM '.DBPREFIX.'module_newsletter WHERE id='.intval($recipientSendEmailId));
                                        $newsTitle         = $objRecipientCount->fields['subject'];
// TODO: Unused
//                                        $objUpdateCount    =
                                        $objDatabase->execute('
                                            UPDATE '.DBPREFIX.'module_newsletter
                                            SET recipient_count = recipient_count+1
                                            WHERE id='.intval($recipientSendEmailId));
                                        self::$strOkMessage .= sprintf($_ARRAYLANG['TXT_NEWSLETTER_RECIPIENT_MAIL_SEND_SUCCESSFULLY'].'<br />', '<strong>'.$newsTitle.'</strong>');
                                    }
                                }
                                self::$strOkMessage .= $_ARRAYLANG['TXT_NEWSLETTER_RECIPIENT_SAVED_SUCCESSFULLY'];
                                return $this->_userList();
                            } else {
                                // fall back to old recipient id, if any error occurs on copy
                                $recipientId = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
                                self::$strErrMessage .= $_ARRAYLANG['TXT_NEWSLETTER_ERROR_SAVE_RECIPIENT'];
                            }
                        }
                    } elseif (empty($recipientId)) {
                        $objRecipient      = $objDatabase->SelectLimit("SELECT id, language, status, notes FROM ".DBPREFIX."module_newsletter_user WHERE email='".contrexx_input2db($recipientEmail)."'", 1);
                        $recipientId       = $objRecipient->fields['id'];
                        $recipientLanguage = $objRecipient->fields['language'];
                        $recipientStatus   = $objRecipient->fields['status'];
                        $recipientNotes    = (!empty($objRecipient->fields['notes']) ? $objRecipient->fields['notes'].' '.$recipientNotes : $recipientNotes);

                        $objList = $objDatabase->Execute("SELECT category FROM ".DBPREFIX."module_newsletter_rel_user_cat WHERE user=".$recipientId);
                        if ($objList !== false) {
                            while (!$objList->EOF) {
                                array_push($arrAssociatedLists, $objList->fields['category']);
                                $objList->MoveNext();
                            }
                        }
                        $arrAssociatedLists = array_unique($arrAssociatedLists);

                        // set all attributes status to false to set the omitEmpty value to true
                        foreach ($recipientAttributeStatus as $attribute => $value) {
                            $recipientAttributeStatus[$attribute]['active'] = false;
                        }

                        if ($this->_updateRecipient($recipientAttributeStatus, $recipientId, $recipientEmail, $recipientUri, $recipientSex, $recipientSalutation, $recipientTitle, $recipientLastname, $recipientFirstname, $recipientPosition, $recipientCompany, $recipientIndustrySector, $recipientAddress, $recipientZip, $recipientCity, $recipientCountry, $recipientPhoneOffice, $recipientPhonePrivate, $recipientPhoneMobile, $recipientFax, $recipientNotes, $recipientBirthday, $recipientStatus, $arrAssociatedLists, $recipientLanguage)) {
                            self::$strOkMessage .= $_ARRAYLANG['TXT_NEWSLETTER_RECIPIENT_UPDATED_SUCCESSFULLY'];
                            self::$strOkMessage .= $_ARRAYLANG['TXT_NEWSLETTER_RECIPIENT_NO_EMAIL_SENT'];
                            return $this->_userList();
                        } else {
                            self::$strErrMessage .= $_ARRAYLANG['TXT_NEWSLETTER_ERROR_UPDATE_RECIPIENT'];
                        }
                    } else {
                        //reset the $recipientId on copy function                        
                        $objResult = $objDatabase->SelectLimit("SELECT id FROM ".DBPREFIX."module_newsletter_user WHERE email='".contrexx_input2db($recipientEmail)."' AND id!=".($copy ? 0 : $recipientId), 1);
                        self::$strErrMessage .= sprintf($_ARRAYLANG['TXT_NEWSLETTER_ERROR_EMAIL_ALREADY_EXISTS'], '<a href="index.php?cmd=newsletter&amp;act=users&amp;tpl=edit&amp;id=' . $objResult->fields['id'] . '" target="_blank">' . $_ARRAYLANG['TXT_NEWSLETTER_ERROR_EMAIL_ALREADY_EXISTS_CLICK_HERE'] . '</a>');
                    }
                } else {
                    self::$strErrMessage .= $_ARRAYLANG['TXT_NEWSLETTER_MANDATORY_FIELD_ERROR'];
                }
            } else {
                self::$strErrMessage .= $_ARRAYLANG['TXT_NEWSLETTER_INVALIDE_EMAIL_ADDRESS'];
            }
        } elseif ($recipientId > 0) {
            $objRecipient = $objDatabase->SelectLimit("SELECT email, uri, sex, salutation, title, lastname, firstname, position, company, industry_sector, address, zip, city, country_id, phone_office, phone_private, phone_mobile, fax, notes, birthday, status, language FROM ".DBPREFIX."module_newsletter_user WHERE id=".$recipientId, 1);
            if ($objRecipient !== false && $objRecipient->RecordCount() == 1) {
                $recipientEmail = $objRecipient->fields['email'];
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
                $recipientStatus = $objRecipient->fields['status'];
                $recipientNotes = $objRecipient->fields['notes'];

                $objList = $objDatabase->Execute("SELECT category FROM ".DBPREFIX."module_newsletter_rel_user_cat WHERE user=".$recipientId);
                if ($objList !== false) {
                    while (!$objList->EOF) {
                        array_push($arrAssociatedLists, $objList->fields['category']);
                        $objList->MoveNext();
                    }
                }
            } else {
                return $this->_userList();
            }
        }

        $this->_pageTitle = $recipientId > 0 && !$copy ? $_ARRAYLANG['TXT_NEWSLETTER_MODIFY_RECIPIENT'] : $_ARRAYLANG['TXT_NEWSLETTER_ADD_NEW_RECIPIENT'];
        $this->_objTpl->addBlockfile('NEWSLETTER_USER_FILE', 'module_newsletter_user_edit', 'module_newsletter_user_edit.html');
        $this->_objTpl->setVariable('TXT_NEWSLETTER_USER_TITLE', $recipientId > 0 && !$copy ? $_ARRAYLANG['TXT_NEWSLETTER_MODIFY_RECIPIENT'] : $_ARRAYLANG['TXT_NEWSLETTER_ADD_NEW_RECIPIENT']);

        $this->_createDatesDropdown($recipientBirthday);

        $arrLists = self::getLists();
        $listNr = 0;
        foreach ($arrLists as $listId => $arrList) {
            $column = $listNr % 3;
            $this->_objTpl->setVariable(array(
                'NEWSLETTER_LIST_ID' => $listId,
                'NEWSLETTER_LIST_NAME' => contrexx_raw2xhtml($arrList['name']),
                'NEWSLETTER_SHOW_RECIPIENTS_OF_LIST_TXT' => sprintf($_ARRAYLANG['TXT_NEWSLETTER_SHOW_RECIPIENTS_OF_LIST'], contrexx_raw2xhtml($arrList['name'])),
                'NEWSLETTER_LIST_ASSOCIATED' => in_array($listId, $arrAssociatedLists) ? 'checked="checked"' : ''
            ));
            $this->_objTpl->parse('newsletter_mail_associated_list_'.$column);
            $listNr++;
        }

        if (count($activeFrontendlang) > 1) {
            foreach ($activeFrontendlang as $lang) {
                $selected = ($lang['id'] == $recipientLanguage) ? 'selected="selected"' : '';

                $this->_objTpl->setVariable(array(
                    'NEWSLETTER_LANGUAGE_ID'        => contrexx_raw2xhtml($lang['id']),
                    'NEWSLETTER_LANGUAGE_NAME'      => contrexx_raw2xhtml($lang['name']),
                    'NEWSLETTER_LANGUAGES_SELECTED' => $selected
                ));
                $this->_objTpl->parse('languages');
            }
            $languageOptionDisplay = true;
        } else {
            $this->_objTpl->hideBlock('languageOption');
        }

        if (empty($recipientId) || $copy) {
            $objNewsletterMails = $objDatabase->Execute('SELECT
                                                      id,
                                                      subject
                                                      FROM '.DBPREFIX.'module_newsletter
                                                      ORDER BY status, id DESC');

            while (!$objNewsletterMails->EOF) {

                $selected = ($recipientSendEmailId == $objNewsletterMails->fields['id']) ? 'selected="selected"' : '';

                $this->_objTpl->setVariable(array(
                    'NEWSLETTER_EMAIL_ID'       => contrexx_raw2xhtml($objNewsletterMails->fields['id']),
                    'NEWSLETTER_EMAIL_NAME'     => contrexx_raw2xhtml($objNewsletterMails->fields['subject']),
                    'NEWSLETTER_EMAIL_SELECTED' => $selected
                ));
                $this->_objTpl->parse('allMails');
                $objNewsletterMails->MoveNext();
            }
            $recipientSendMailDisplay = true;
        } else {
            $this->_objTpl->hideBlock('sendEmail');
        }

        // Display settings recipient general attributes

        $sendMailRowClass = ($languageOptionDisplay) ? 'row2' : 'row1';

        if ($languageOptionDisplay && $recipientSendMailDisplay) {
            $associatedListRowClass = 'row1';
        } elseif ($languageOptionDisplay || $recipientSendMailDisplay) {
            $associatedListRowClass = 'row2';
        } else {
            $associatedListRowClass = 'row1';
        }

        $recipientNotesRowClass = ($associatedListRowClass == 'row1') ? 'row2' : 'row1';

        $this->_objTpl->setVariable(array(
            'NEWSLETTER_SEND_EMAIL_ROWCLASS'       => $sendMailRowClass,
            'NEWSLETTER_ASSOCIATED_LISTS_ROWCLASS' => $associatedListRowClass,
            'NEWSLETTER_NOTES_ROWCLASS'            => $recipientNotesRowClass
        ));


        //display settings recipient profile detials
        $recipientAttributeDisplay = false;
        foreach ($recipientAttributeStatus as $value) {
            if ($value['active']) {
                $recipientAttributeDisplay = true;
                break;
            }
        }

        $profileRowCount = 0;
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
        if ($recipientAttributeDisplay) {
            foreach ($recipientAttributesArray as $attribute) {
                if ($recipientAttributeStatus[$attribute]['active'] && $this->_objTpl->blockExists($attribute)) {
                    $this->_objTpl->touchBlock($attribute);
                    $this->_objTpl->setVariable(array(
                        'NEWSLETTER_'.strtoupper($attribute).'_ROW_CLASS' => ($profileRowCount%2 == 0) ? 'row2' : 'row1',
                        'NEWSLETTER_'.strtoupper($attribute).'_MANDATORY' => ($recipientAttributeStatus[$attribute]['required']) ? '*' : '',
                    ));
                    $profileRowCount++;
                } else {
                    $this->_objTpl->hideBlock($attribute);
                }
            }
        } else {
            $this->_objTpl->hideBlock('recipientProfileAttributes');
        }
        
        $filterParams = 
            (!empty($_GET['newsletterListId']) ? '&newsletterListId='.contrexx_input2raw($_GET['newsletterListId']) : '').
            (!empty($_GET['filterkeyword']) ? '&filterkeyword='.contrexx_input2raw($_GET['filterkeyword']) : '').
            (!empty($_GET['filterattribute']) ? '&filterattribute='.contrexx_input2raw($_GET['filterattribute']) : '').
            (!empty($_GET['filterStatus']) ? '&filterStatus='.contrexx_input2raw($_GET['filterStatus']) : '')
        ;

        $this->_objTpl->setVariable(array(
            'NEWSLETTER_RECIPIENT_ID'           => $recipientId,
            'NEWSLETTER_RECIPIENT_EMAIL'        => htmlentities($recipientEmail, ENT_QUOTES, CONTREXX_CHARSET),
            'TXT_NEWSLETTER_STATUS'             => $_ARRAYLANG['TXT_NEWSLETTER_STATUS'],
            'TXT_NEWSLETTER_LANGUAGE'           => $_ARRAYLANG['TXT_NEWSLETTER_LANGUAGE'],
            'TXT_NEWSLETTER_SEND_EMAIL'         => $_ARRAYLANG['TXT_NEWSLETTER_SEND_EMAIL'],
            'TXT_NEWSLETTER_ASSOCIATED_LISTS'   => $_ARRAYLANG['TXT_NEWSLETTER_ASSOCIATED_LISTS'],
            'TXT_NEWSLETTER_NOTES'              => $_ARRAYLANG['TXT_NEWSLETTER_NOTES'],
            'TXT_NEWSLETTER_PROFILE'            => $_ARRAYLANG['TXT_NEWSLETTER_PROFILE'],
            'TXT_NEWSLETTER_POSITION'           => $_ARRAYLANG['TXT_NEWSLETTER_POSITION'],
            'TXT_NEWSLETTER_INDUSTRY_SECTOR'    => $_ARRAYLANG['TXT_NEWSLETTER_INDUSTRY_SECTOR'],
            'TXT_NEWSLETTER_PHONE_MOBILE'       => $_ARRAYLANG['TXT_NEWSLETTER_PHONE_MOBILE'],
            'TXT_NEWSLETTER_PHONE_PRIVATE'      => $_ARRAYLANG['TXT_NEWSLETTER_PHONE_PRIVATE'],
            'TXT_NEWSLETTER_FAX'                => $_ARRAYLANG['TXT_NEWSLETTER_FAX'],

            'NEWSLETTER_RECIPIENT_STATUS'       => $recipientStatus == '1' ? 'checked="checked"' : '',
            'NEWSLETTER_RECIPIENT_NOTES'        => htmlentities($recipientNotes, ENT_QUOTES, CONTREXX_CHARSET),
            'NEWSLETTER_RECIPIENT_URI'          => htmlentities($recipientUri, ENT_QUOTES, CONTREXX_CHARSET),
            'NEWSLETTER_RECIPIENT_FEMALE'       => $recipientSex == 'f' ? 'checked="checked"' : '',
            'NEWSLETTER_RECIPIENT_MALE'         => $recipientSex == 'm' ? 'checked="checked"' : '',
            'NEWSLETTER_RECIPIENT_SALUTATION'   => $this->_getRecipientTitleMenu($recipientSalutation, 'name="newsletter_recipient_salutation" style="width:296px" size="1"'),
            'NEWSLETTER_RECIPIENT_TITLE'        => htmlentities($recipientTitle, ENT_QUOTES, CONTREXX_CHARSET),
            'NEWSLETTER_RECIPIENT_FIRSTNAME'    => htmlentities($recipientFirstname, ENT_QUOTES, CONTREXX_CHARSET),
            'NEWSLETTER_RECIPIENT_LASTNAME'     => htmlentities($recipientLastname, ENT_QUOTES, CONTREXX_CHARSET),
            'NEWSLETTER_RECIPIENT_POSITION'     => htmlentities($recipientPosition, ENT_QUOTES, CONTREXX_CHARSET),
            'NEWSLETTER_RECIPIENT_COMPANY'      => htmlentities($recipientCompany, ENT_QUOTES, CONTREXX_CHARSET),
            'NEWSLETTER_RECIPIENT_INDUSTRY_SECTOR' => htmlentities($recipientIndustrySector, ENT_QUOTES, CONTREXX_CHARSET),
            'NEWSLETTER_RECIPIENT_ADDRESS'      => htmlentities($recipientAddress, ENT_QUOTES, CONTREXX_CHARSET),
            'NEWSLETTER_RECIPIENT_ZIP'          => htmlentities($recipientZip, ENT_QUOTES, CONTREXX_CHARSET),
            'NEWSLETTER_RECIPIENT_CITY'         => htmlentities($recipientCity, ENT_QUOTES, CONTREXX_CHARSET),
            'NEWSLETTER_RECIPIENT_COUNTRY'      => $this->getCountryMenu($recipientCountry, ($recipientAttributeStatus['recipient_country']['active']  && $recipientAttributeStatus['recipient_country']['required'])),
            'NEWSLETTER_RECIPIENT_PHONE'        => htmlentities($recipientPhoneOffice, ENT_QUOTES, CONTREXX_CHARSET),
            'NEWSLETTER_RECIPIENT_PHONE_MOBILE' => htmlentities($recipientPhoneMobile, ENT_QUOTES, CONTREXX_CHARSET),
            'NEWSLETTER_RECIPIENT_PHONE_PRIVATE' => htmlentities($recipientPhonePrivate, ENT_QUOTES, CONTREXX_CHARSET),
            'NEWSLETTER_RECIPIENT_FAX'          => htmlentities($recipientFax, ENT_QUOTES, CONTREXX_CHARSET),
            'NEWSLETTER_RECIPIENT_BIRTHDAY'     => htmlentities($recipientBirthday, ENT_QUOTES, CONTREXX_CHARSET),
            'NEWSLETTER_RECIPIENT_COPY'         => $copy ? 1 : 0,

            'TXT_NEWSLETTER_EMAIL_ADDRESS'  => $_ARRAYLANG['TXT_NEWSLETTER_EMAIL_ADDRESS'],
            'TXT_NEWSLETTER_WEBSITE'        => $_ARRAYLANG['TXT_NEWSLETTER_WEBSITE'],
            'TXT_NEWSLETTER_SALUTATION'     => $_ARRAYLANG['TXT_NEWSLETTER_SALUTATION'],
            'TXT_NEWSLETTER_TITLE'          => $_ARRAYLANG['TXT_NEWSLETTER_TITLE'],
            'TXT_NEWSLETTER_SEX'            => $_ARRAYLANG['TXT_NEWSLETTER_SEX'],
            'TXT_NEWSLETTER_FEMALE'         => $_ARRAYLANG['TXT_NEWSLETTER_FEMALE'],
            'TXT_NEWSLETTER_MALE'           => $_ARRAYLANG['TXT_NEWSLETTER_MALE'],
            'TXT_NEWSLETTER_LASTNAME'       => $_ARRAYLANG['TXT_NEWSLETTER_LASTNAME'],
            'TXT_NEWSLETTER_FIRSTNAME'      => $_ARRAYLANG['TXT_NEWSLETTER_FIRSTNAME'],
            'TXT_NEWSLETTER_COMPANY'        => $_ARRAYLANG['TXT_NEWSLETTER_COMPANY'],
            'TXT_NEWSLETTER_ADDRESS'        => $_ARRAYLANG['TXT_NEWSLETTER_ADDRESS'],
            'TXT_NEWSLETTER_ZIP'            => $_ARRAYLANG['TXT_NEWSLETTER_ZIP'],
            'TXT_NEWSLETTER_CITY'           => $_ARRAYLANG['TXT_NEWSLETTER_CITY'],
            'TXT_NEWSLETTER_COUNTRY'        => $_ARRAYLANG['TXT_NEWSLETTER_COUNTRY'],
            'TXT_NEWSLETTER_PHONE'          => $_ARRAYLANG['TXT_NEWSLETTER_PHONE'],
            'TXT_NEWSLETTER_BIRTHDAY'       => $_ARRAYLANG['TXT_NEWSLETTER_BIRTHDAY'],
            'TXT_NEWSLETTER_SAVE'           => $_ARRAYLANG['TXT_NEWSLETTER_SAVE'],
            'TXT_CANCEL'                    => $_CORELANG['TXT_CANCEL'],
            'TXT_NEWSLETTER_DO_NOT_SEND_EMAIL'     => $_ARRAYLANG['TXT_NEWSLETTER_DO_NOT_SEND_EMAIL'],
            'TXT_NEWSLETTER_INFO_ABOUT_SEND_EMAIL' => $_ARRAYLANG['TXT_NEWSLETTER_INFO_ABOUT_SEND_EMAIL'],
            'TXT_NEWSLETTER_RECIPIENT_DATE' => $_ARRAYLANG['TXT_NEWSLETTER_RECIPIENT_DATE'],
            'TXT_NEWSLETTER_RECIPIENT_MONTH'=> $_ARRAYLANG['TXT_NEWSLETTER_RECIPIENT_MONTH'],
            'TXT_NEWSLETTER_RECIPIENT_YEAR' => $_ARRAYLANG['TXT_NEWSLETTER_RECIPIENT_YEAR'],
//            'JAVASCRIPTCODE' => $this->JSadduser(),
            'NEWSLETTER_FILTER_PARAMS'      => $filterParams,
        ));
        $this->_objTpl->parse('module_newsletter_user_edit');
        return true;
    }

    /**
     * @todo instead of just not linking the access users probably link to
     *       the access module in case the user has the appropriate rights
     */
    function _userList()
    {
        global $objDatabase, $_ARRAYLANG, $_CONFIG, $_CORELANG;

        JS::activate('cx');

        $this->_pageTitle = $_ARRAYLANG['TXT_NEWSLETTER_USER_ADMINISTRATION'];
        $this->_objTpl->addBlockfile('NEWSLETTER_USER_FILE', 'module_newsletter_user_overview', 'module_newsletter_user_overview.html');

        $limit = (!empty($_GET['limit'])) ? intval($_GET['limit']) : $_CONFIG['corePagingLimit'];

        //for User storage in Access-Module
        if(isset($_GET['store']) && $_GET['store'] == 'true'){
            self::$strOkMessage .= $_ARRAYLANG['TXT_NEWSLETTER_RECIPIENT_UPDATED_SUCCESSFULLY'];
        }
        
        $newsletterListId = isset($_REQUEST['newsletterListId']) ? intval($_REQUEST['newsletterListId']) : 0;
        $this->_objTpl->setVariable(array(
            'TXT_TITLE' => $_ARRAYLANG['TXT_SEARCH'],
            'TXT_CHANGELOG_SUBMIT' => $_CORELANG['TXT_MULTISELECT_SELECT'],
            'TXT_CHANGELOG_SUBMIT_DEL' => $_CORELANG['TXT_MULTISELECT_DELETE'],
            'TXT_SELECT_ALL' => $_CORELANG['TXT_SELECT_ALL'],
            'TXT_DESELECT_ALL' => $_CORELANG['TXT_DESELECT_ALL'],
            'TXT_DELETE_HISTORY_MSG_ALL' => $_CORELANG['TXT_DELETE_HISTORY_ALL'],
            'TXT_NEWSLETTER_REGISTRATION_DATE' => $_ARRAYLANG['TXT_NEWSLETTER_REGISTRATION_DATE'],
            'TXT_NEWSLETTER_ROWS_PER_PAGE' => $_ARRAYLANG['TXT_NEWSLETTER_ROWS_PER_PAGE'],
            'TXT_NEWSLETTER_RECIPIENTS' => $_ARRAYLANG['TXT_NEWSLETTER_RECIPIENTS'],
            'TXT_NEWSLETTER_DELETE_ALL_INACTIVE' => $_ARRAYLANG['TXT_NEWSLETTER_DELETE_ALL_INACTIVE'],
            'TXT_NEWSLETTER_REALLY_DELETE_ALL_INACTIVE' => $_ARRAYLANG['TXT_NEWSLETTER_REALLY_DELETE_ALL_INACTIVE'],
            'TXT_NEWSLETTER_CANNOT_UNDO_OPERATION' => $_ARRAYLANG['TXT_NEWSLETTER_CANNOT_UNDO_OPERATION'],
            'NEWSLETTER_PAGING_LIMIT' => $limit,
            'NEWSLETTER_LIST_ID' => $newsletterListId,
            'NEWSLETTER_FILTER_KEYWORD' => (!empty($_GET['filterkeyword']) ? contrexx_input2raw($_GET['filterkeyword']) : ''),
            'NEWSLETTER_FILTER_ATTRIBUTE' => (!empty($_GET['filterattribute']) ? contrexx_input2raw($_GET['filterattribute']) : ''),
            'NEWSLETTER_FILTER_STATUS' => (!empty($_GET['filterStatus']) ? contrexx_input2raw($_GET['filterStatus']) : ''),
            'TXT_NEWSLETTER_USER_FEEDBACK' => $_ARRAYLANG['TXT_NEWSLETTER_USER_FEEDBACK'],
        ));

        $this->_objTpl->setVariable('NEWSLETTER_LIST_MENU', $this->CategoryDropDown('newsletterListId', $newsletterListId, "id='newsletterListId' onchange=\"newsletterList.setList(this.value)\""));
        if (isset($_GET["addmailcode"])) {
            $query = "SELECT id, code FROM ".DBPREFIX."module_newsletter_user where code=''";
            $objResult = $objDatabase->Execute($query);
            if ($objResult) {
                while (!$objResult->EOF) {
                    $objDatabase->Execute("
                        UPDATE ".DBPREFIX."module_newsletter_user
                           SET code='".$this->_emailCode()."'
                         WHERE id=".$objResult->fields['id']
                    );
                    $objResult->MoveNext();
                }
            }
        }

        if (isset($_GET["delete"])) {
            $recipientId = intval($_GET["id"]);
            if ($this->_deleteRecipient($recipientId)) {
                self::$strOkMessage = $_ARRAYLANG['TXT_DATA_RECORD_DELETED_SUCCESSFUL'];
            } else {
                self::$strErrMessage = $_ARRAYLANG['TXT_DATA_RECORD_DELETE_ERROR'];
            }
        }

        if (isset($_GET["bulkdelete"])) {
            $error = 0;
            if (!empty($_POST['userid'])) {
                foreach ($_POST['userid'] as $userid) {
                    $userid=intval($userid);
                    if (!$this->_deleteRecipient($userid)) {
                        $error = 1;
                    }
                }
            }
/*
            if (!empty($_POST['accessUserid'])) {
                foreach ($_POST['accessUserid'] as $userID) {
                    if ($this->removeAccessRecipient($userID)) {
                        $error = 1;
                    }
                }
            }
*/
            if ($error) {
                self::$strErrMessage = $_ARRAYLANG['TXT_DATA_RECORD_DELETE_ERROR'];
            } else {
                self::$strOkMessage = $_ARRAYLANG['TXT_DATA_RECORD_DELETED_SUCCESSFUL'];
            }
        }

        $queryCHECK         = "SELECT id, code FROM ".DBPREFIX."module_newsletter_user where code=''";
        $objResultCHECK     = $objDatabase->Execute($queryCHECK);
        $count         = $objResultCHECK->RecordCount();
        if ($count > 0) {
            $email_code_check = '<div style="color: red;">'.$_ARRAYLANG['TXT_EMAIL_WITHOUT_CODE_MESSAGE'].'!<br/><a href="index.php?cmd=newsletter&act=users&addmailcode=1">'.$_ARRAYLANG['TXT_ADD_EMAIL_CODE_LINK'].' ></a></div/><br/>';
            $this->_objTpl->setVariable('EMAIL_CODE_CHECK', $email_code_check);
        }

        $this->_objTpl->setVariable(array(
            'TXT_NEWSLETTER_CHECK_ALL' => $_ARRAYLANG['TXT_NEWSLETTER_CHECK_ALL'],
            'TXT_NEWSLETTER_UNCHECK_ALL' => $_ARRAYLANG['TXT_NEWSLETTER_UNCHECK_ALL'],
            'TXT_NEWSLETTER_WITH_SELECTED' => $_ARRAYLANG['TXT_NEWSLETTER_WITH_SELECTED'],
            'TXT_NEWSLETTER_DELETE' => $_ARRAYLANG['TXT_NEWSLETTER_DELETE'],
            'TXT_STATUS' => $_ARRAYLANG['TXT_STATUS'],
            'TXT_SEARCH' => $_ARRAYLANG['TXT_SEARCH'],
            'TXT_EMAIL_ADDRESS' => $_ARRAYLANG['TXT_EMAIL_ADDRESS'],
            'TXT_NEWSLETTER_COMPANY' => $_ARRAYLANG['TXT_NEWSLETTER_COMPANY'],
            'TXT_LASTNAME' => $_ARRAYLANG['TXT_LASTNAME'],
            'TXT_FIRSTNAME' => $_ARRAYLANG['TXT_FIRSTNAME'],
            'TXT_NEWSLETTER_ADDRESS' => $_ARRAYLANG['TXT_NEWSLETTER_ADDRESS'],
            'TXT_ZIP' => $_ARRAYLANG['TXT_ZIP'],
            'TXT_CITY' => $_ARRAYLANG['TXT_CITY'],
            'TXT_COUNTRY' => $_ARRAYLANG['TXT_COUNTRY'],
            'TXT_PHONE' => $_ARRAYLANG['TXT_PHONE'],
            'TXT_BIRTHDAY' => $_ARRAYLANG['TXT_BIRTHDAY'],
            'TXT_USER_DATA' => $_ARRAYLANG['TXT_USER_DATA'],
            'TXT_NEWSLETTER_CATEGORYS' => $_ARRAYLANG['TXT_NEWSLETTER_CATEGORYS'],
            'TXT_STATUS' => $_ARRAYLANG['TXT_STATUS'],
            'SELECTLIST_FIELDS' => $this->SelectListFields(),
            'SELECTLIST_CATEGORY' => $this->SelectListCategory(),
            'SELECTLIST_STATUS' => $this->SelectListStatus(),
            'JAVASCRIPTCODE' => $this->JSedituser(),
            'TXT_EDIT' => $_ARRAYLANG['TXT_EDIT'],
            'TXT_ADD' => $_ARRAYLANG['TXT_ADD'],
            'TXT_IMPORT' => $_ARRAYLANG['TXT_IMPORT'],
            'TXT_EXPORT' => $_ARRAYLANG['TXT_EXPORT'],
            'TXT_FUNCTIONS' => $_CORELANG['TXT_FUNCTIONS']
        ));
        $this->_objTpl->setGlobalVariable(array(
            'TXT_NEWSLETTER_MODIFY_RECIPIENT' => $_ARRAYLANG['TXT_NEWSLETTER_MODIFY_RECIPIENT'],
            'TXT_NEWSLETTER_COPY_RECIPIENT'   => $_ARRAYLANG['TXT_NEWSLETTER_COPY_RECIPIENT'],
            'TXT_NEWSLETTER_DELETE_RECIPIENT' => $_ARRAYLANG['TXT_NEWSLETTER_DELETE_RECIPIENT'],
        ));

        $this->_objTpl->parse('module_newsletter_user_overview');
    }



    /**
     * Return all newsletter users and those access users who are assigned
     * to the list and their information
     * @author      Stefan Heinemann <sh@adfinis.com>
     * @param       string $where The where String for searching
     * @param       int $newsletterListId The id of the newsletter category
     *              to be selected (0 for all users)
     * @return      array(array, int)
     */
    private function returnNewsletterUser($where, $order = '', $newsletterListId=0, $status = null, $limit = null, $pagingPos = 0)
    {
        global $objDatabase;

        $arrRecipientFields = array(
            'newsletter'    => array(),
            'access'        => array(),
            'list'          => array(
                'id',
                'status',
                'email',
                'uri',
                'sex',
                'salutation',
                'title',
                'lastname',
                'firstname',
                'position',
                'company',
                'industry_sector',
                'address',
                'zip',
                'city',
                'country_id',
                'phone_office',
                'phone_private',
                'phone_mobile',
                'fax',
                'notes',
                'birthday',
                'type',
                'emaildate'
            )
        );

        $arrFieldsWrapperDefinition = array(
            'newsletter' => array(
                'type'              => array('type' => 'data', 'def' => 'newsletter_user')
            ),
            'access' => array(
                'status'            => array('type' => 'field', 'def' => 'active'),
                'uri'               => array('type' => 'field', 'def' => 'website'),
                'sex'               => array('type' => 'operation', 'def' => '(CASE
                                                                                    WHEN `gender`=\'gender_female\' THEN \'f\'
                                                                                    WHEN `gender`=\'gender_male\' THEN \'m\'
                                                                                    ELSE \'-\'
                                                                                END)'),
                'salutation'        => array('type' => 'field', 'def' => 'title'),
                'title'             => array('type' => 'data',  'def' => ''),
                'position'          => array('type' => 'data',  'def' => ''),
                'industry_sector'   => array('type' => 'data',  'def' => ''),
                'country_id'        => array('type' => 'field', 'def' => 'country'),
                'fax'               => array('type' => 'field', 'def' => 'phone_fax'),
                'notes'             => array('type' => 'data',  'def' => ''),
                'type'              => array('type' => 'data', 'def' => 'access_user'),
                'emaildate'          => array('type' => 'field', 'def' => 'regdate')
            )
        );

        foreach ($arrFieldsWrapperDefinition as $recipientType => $arrWrapperDefinitions) {
            foreach ($arrRecipientFields['list'] as $field) {
                $wrapper = '';

                if (isset($arrWrapperDefinitions[$field])) {
                    $wrapper = $arrWrapperDefinitions[$field]['type'];
                }

                switch ($wrapper) {
                    case 'field':
                        $wrappedField = sprintf('`%1$s` AS `%2$s`', $arrWrapperDefinitions[$field]['def'], $field);
                        break;

                    case 'data':
                        $wrappedField = sprintf('\'%1$s\' AS `%2$s`', $arrWrapperDefinitions[$field]['def'], $field);
                        break;

                    case 'operation':
                        $wrappedField = sprintf('%1$s AS `%2$s`', $arrWrapperDefinitions[$field]['def'], $field);
                        break;

                    default:
                        $wrappedField = sprintf('`%1$s`', $field);
                        break;
                }

                $arrRecipientFields[$recipientType][] = $wrappedField;
            }
        }

        $query = sprintf('
            (
                SELECT SQL_CALC_FOUND_ROWS
                %2$s
                FROM `%1$smodule_newsletter_user` AS `nu`
                %3$s
                WHERE 1
                %4$s
                %5$s
                %10$s
            )
            UNION DISTINCT
            (
                SELECT
                %6$s
                FROM `%1$smodule_newsletter_access_user` AS `cnu`
                    INNER JOIN `%1$saccess_users` AS `cu` ON `cu`.`id`=`cnu`.`accessUserID`
                    INNER JOIN `%1$saccess_user_profile` AS `cup` ON `cup`.`user_id`=`cu`.`id`
                WHERE 1
                %7$s
                %5$s
                %11$s
            )
            %8$s
            %9$s',

            // %1$s
            DBPREFIX,

            // %2$s
            implode(',', $arrRecipientFields['newsletter']),

            // %3$s
            ( !empty($newsletterListId)
                ?  'INNER JOIN `'.DBPREFIX.'module_newsletter_rel_user_cat` AS `rc` ON `rc`.`user`=`nu`.`id`' : ''),

            // %4$s
            ( !empty($newsletterListId)
                ? sprintf('AND `rc`.`category`=%s', intval($newsletterListId)) : ''),

            // %5$s
            $where,

            // %6$s
            implode(',', $arrRecipientFields['access']),

            // %7$s
            (!empty($newsletterListId)
                ? sprintf('AND `cnu`.`newsletterCategoryID`=%s', intval($newsletterListId)) : ''),

            // %8$s
            $order,

            // %9$s
            ($limit ? sprintf('LIMIT %s, %s', $pagingPos, $limit) : ''),

            // %10$s
            ($status === null ? '' : 'AND `nu`.`status` = '.$status),

            // %11$s
            ($status === null ? '' : 'AND `cu`.`active` = '.$status)
        );

        $data = $objDatabase->Execute($query);
        $users = array();
        if ($data !== false ) {
            while (!$data->EOF) {
                $users[] = $data->fields;
                $data->MoveNext();
            }
        }
        $data = $objDatabase->Execute('SELECT FOUND_ROWS() AS `count`');
        $count = $data->fields['count'];
        return array($users, $count);
    }


    function SelectListStatus()
    {
        global $_ARRAYLANG;

        return '<select id="newsletterRecipientFilterStatus">
                    <option value="">-- '.$_ARRAYLANG['TXT_STATUS'].' --</option>
                    <option value="0">'.$_ARRAYLANG['TXT_OPEN_ISSUE'].'</option>
                    <option value="1">'.$_ARRAYLANG['TXT_ACTIVE'].'</option>
                </select>';
    }


    function SelectListCategory()
    {
        global $objDatabase, $_ARRAYLANG;

        $ReturnVar = '<select name="SearchCategory">';
        $ReturnVar .= '<option value="">-- '.$_ARRAYLANG['TXT_NEWSLETTER_CATEGORYS'].' --</option>';
        $queryPS = "SELECT * FROM ".DBPREFIX."module_newsletter_category order by name";
        $objResultPS = $objDatabase->Execute($queryPS);
        if ($objResultPS) {
            while (!$objResultPS->EOF) {
                $ReturnVar .= '<option value="'.$objResultPS->fields['id'].'" >'.$objResultPS->fields['name'].'</option>';
                $objResultPS->MoveNext();
            }
        }
        $ReturnVar .= '</select>';
        return $ReturnVar;
    }


    function SelectListFields()
    {
        global $_ARRAYLANG;

        return '<select id="newsletterRecipientFilterAttribute">
                    <option value="">-- '.$_ARRAYLANG['TXT_SEARCH_ON'].' --</option>
                    <option value="email">'.$_ARRAYLANG['TXT_EMAIL_ADDRESS'].'</option>
                    <option value="company">'.$_ARRAYLANG['TXT_NEWSLETTER_COMPANY'].'</option>
                    <option value="lastname">'.$_ARRAYLANG['TXT_LASTNAME'].'</option>
                    <option value="firstname">'.$_ARRAYLANG['TXT_FIRSTNAME'].'</option>
                    <option value="address">'.$_ARRAYLANG['TXT_NEWSLETTER_ADDRESS'].'</option>
                    <option value="zip">'.$_ARRAYLANG['TXT_ZIP'].'</option>
                    <option value="city">'.$_ARRAYLANG['TXT_CITY'].'</option>
                    <option value="country_id">'.$_ARRAYLANG['TXT_COUNTRY'].'</option>
                    <option value="phone">'.$_ARRAYLANG['TXT_PHONE'].'</option>
                    <option value="birthday">'.$_ARRAYLANG['TXT_BIRTHDAY'].'</option>
                </select>';
    }


    function JSadduser()
    {
        global $_ARRAYLANG;

        JS::registerCode('
function SubmitAddForm() {
  if (CheckMail(document.adduser.email.value)==true) {
    document.adduser.submit();
  } else {
    alert("'.$_ARRAYLANG['TXT_MAILERROR'].'");
    document.adduser.email.focus();
  }
}

function CheckMail(s) {
  var a = false;
  var res = false;
  if (typeof(RegExp) == "function") {
    var b = new RegExp("abc");
    if (b.test("abc") == true) {a = true;}
  }
  if (a == true) {
    reg = new RegExp(
      "^([a-zA-Z0-9\\-\\.\\_]+)"+
      "(\\@)([a-zA-Z0-9\\-\\.]+)"+
      "(\\.)([a-zA-Z]{2,4})$");
    res = (reg.test(s));
  } else {
    res = (s.search("@") >= 1 &&
    s.lastIndexOf(".") > s.search("@") &&
    s.lastIndexOf(".") >= s.length-5)
  }
  return(res);
}
');
    }


    function JSedituser()
    {
        global $_ARRAYLANG;

        JS::registerCode('
function DeleteUser(UserID, email) {
  strConfirmMsg = "'.$_ARRAYLANG['TXT_NEWSLETTER_CONFIRM_DELETE_RECIPIENT_OF_ADDRESS'].'";
  if (confirm(strConfirmMsg.replace("%s", email)+"\n'.$_ARRAYLANG['TXT_NEWSLETTER_CANNOT_UNDO_OPERATION'].'")) {
    document.location.href = "index.php?cmd=newsletter&'.CSRF::param().'&act=users&delete=1&id="+UserID;
  }
}

function MultiAction() {
  with (document.userlist) {
    switch (userlist_MultiAction.value) {
      case "delete":
        if (confirm(\''.$_ARRAYLANG['TXT_NEWSLETTER_CONFIRM_DELETE_SELECTED_RECIPIENTS'].'\n'.$_ARRAYLANG['TXT_NEWSLETTER_CANNOT_UNDO_OPERATION'].'\')) {
          submit();
        }
        break;
    }
  }
}
');
    }


    function DateForDB()
    {
        return date(ASCMS_DATE_FORMAT_INTERNATIONAL_DATE);
    }


    function _getTemplateMenu($selectedTemplate='', $attributes='', $type='e-mail')
    {
        $menu = "<select".(!empty($attributes) ? " ".$attributes : "").">\n";
        foreach ($this->_getTemplates($type) as $templateId => $arrTemplate) {
            $menu .= "<option value=\"".$templateId."\"".($templateId == $selectedTemplate ? "selected=\"selected\"" : "").">".htmlentities($arrTemplate['name'], ENT_QUOTES, CONTREXX_CHARSET)."</option>\n";
        }
        $menu .= "</select>\n";
        return $menu;
    }


    function _getTemplates($type = 'e-mail')
    {
        global $objDatabase;

        $arrTemplates = array();
        $objTemplate = $objDatabase->Execute("SELECT id, name, description, html, type FROM ".DBPREFIX."module_newsletter_template WHERE type='".$type."'");
        if ($objTemplate !== false) {
            while (!$objTemplate->EOF) {
                $arrTemplates[$objTemplate->fields['id']] = array(
                    'name' => $objTemplate->fields['name'],
                    'description' => $objTemplate->fields['description'],
					'type' => $objTemplate->fields['type'],
                    'html' => $objTemplate->fields['html'],
                );
                $objTemplate->MoveNext();
            }
        }
        return $arrTemplates;
    }


    function CategoryDropDown($name='category', $selected=0, $attrs='')
    {
        global $objDatabase, $_ARRAYLANG;

        $ReturnVar = '<select name="'.$name.'"'.(!empty($attrs) ? ' '.$attrs : '').'>
        <option value="selectcategory">'.$_ARRAYLANG['TXT_NEWSLETTER_SELECT_CATEGORY'].'</option>
        <option value="">'.$_ARRAYLANG['TXT_NEWSLETTER_ALL'].'</option>';
        $queryCS         = "SELECT id, name FROM ".DBPREFIX."module_newsletter_category ORDER BY name";
        $objResultCS     = $objDatabase->Execute($queryCS);
        if ($objResultCS !== false) {
            $CategorysFounded = 1;
            while (!$objResultCS->EOF) {
                $ReturnVar .= '<option value="'.$objResultCS->fields['id'].'"'.($objResultCS->fields['id'] == $selected ? 'selected="selected"' : '').'>'.htmlentities($objResultCS->fields['name'], ENT_QUOTES, CONTREXX_CHARSET).'</option>';
                $objResultCS->MoveNext();
            }
        }
        $ReturnVar .= '</select>';
        if ($CategorysFounded!=1) {
            $ReturnVar = '';
        }
        return $ReturnVar;
    }


    function _getListHTML()
    {
        global $_ARRAYLANG;

        $listId = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($listId == 0) {
            return $this->_lists();
        }

        $this->_pageTitle = $_ARRAYLANG['TXT_NEWSLETTER_LISTS'];
        $this->_objTpl->loadTemplateFile('module_newsletter_list_sourcecode.html');
        $this->_objTpl->setVariable(array(
            'TXT_NEWSLETTER_GENERATE_HTML_SOURCE_CODE' => $_ARRAYLANG['TXT_NEWSLETTER_GENERATE_HTML_SOURCE_CODE'],
            'TXT_NEWSLETTER_BACK' => $_ARRAYLANG['TXT_NEWSLETTER_BACK'],
            'NEWSLETTER_HTML_CODE' => htmlentities($this->_getHTML($listId), ENT_QUOTES, CONTREXX_CHARSET)
        ));
        return true;
    }


    function ConfigSystem()
    {
        global $objDatabase, $_ARRAYLANG, $_CORELANG;
        $this->_pageTitle = $_ARRAYLANG['TXT_SETTINGS'];
        $this->_objTpl->loadTemplateFile('newsletter_config_system.html');
        $this->_objTpl->setVariable('TXT_TITLE', $_CORELANG['TXT_SETTINGS_MENU_SYSTEM']);
        if (isset($_POST["update"])) {
            $objDatabase->Execute("UPDATE ".DBPREFIX."module_newsletter_settings SET setvalue='".intval($_POST['def_unsubscribe'])."' WHERE setname='defUnsubscribe'");
        }

        // Load Values
        $objSystem = $objDatabase->Execute("SELECT setname, setvalue FROM ".DBPREFIX."module_newsletter_settings");
        if ($objSystem !== false) {
            while (!$objSystem->EOF) {
                $arrSystem[$objSystem->fields['setname']] = $objSystem->fields['setvalue'];
                $objSystem->MoveNext();
            }
        }

        if ($arrSystem['defUnsubscribe'] == 1) {
            $delete = 'checked="checked"';
            $deactivate = '';
        } else {
            $delete = '';
            $deactivate = 'checked="checked"';
        }

        $this->_objTpl->setVariable(array(
            'TXT_NEWSLETTER_ACTIVATE' => $_ARRAYLANG['TXT_NEWSLETTER_ACTIVATE'],
            'TXT_NEWSLETTER_DEACTIVATE' => $_ARRAYLANG['TXT_NEWSLETTER_DEACTIVATE'],
            'TXT_NEWSLETTER_NOTIFY_ON_UNSUBSCRIBE' => $_ARRAYLANG['TXT_NEWSLETTER_NOTIFY_ON_UNSUBSCRIBE'],
            'TXT_CONFIRM_MAIL' => $_ARRAYLANG['TXT_NEWSLETTER_CONFIRMATION_EMAIL'],
            'TXT_ACTIVATE_MAIL' => $_ARRAYLANG['TXT_NEWSLETTER_ACTIVATION_EMAIL'],
            'TXT_DISPATCH_SETINGS' => $_ARRAYLANG['TXT_DISPATCH_SETINGS'],
            'TXT_GENERATE_HTML' => $_ARRAYLANG['TXT_GENERATE_HTML'],
            'TXT_NOTIFICATION_MAIL' => $_ARRAYLANG['TXT_NEWSLETTER_NOTIFICATION_MAIL'],
            'TXT_SYSTEM_SETINGS' => $_CORELANG['TXT_SETTINGS_MENU_SYSTEM'],
            'TXT_DEF_UNSUBSCRIBE' => $_ARRAYLANG['TXT_STATE_OF_SUBSCRIBED_USER'],
            'UNSUBSCRIBE_DEACTIVATE' => $_CORELANG['TXT_DEACTIVATED'],
            'UNSUBSCRIBE_DELETE' => $_CORELANG['TXT_DELETED'],
            'TXT_SAVE' => $_CORELANG['TXT_SETTINGS_SAVE'],
            'UNSUBSCRIBE_DEACTIVATE_ON' => $deactivate,
            'UNSUBSCRIBE_DELETE_ON' => $delete,
            'TXT_NEWSLETTER_TEMPLATES' => $_ARRAYLANG['TXT_NEWSLETTER_TEMPLATES'],
            'TXT_NEWSLETTER_INTERFACE' => $_ARRAYLANG['TXT_NEWSLETTER_INTERFACE'],
        ));
    }

    // TODO: we consider, that attribute values are all included in double quotes (""):  wysiwyg editor replaces them automatically
    // In general, user can use single quotes (' ') or miss quotes
    function _prepareNewsletterLinksForStore($MailId)
    {
        global $objDatabase;

        $objMail = $objDatabase->SelectLimit("
            SELECT `content`
            FROM ".DBPREFIX."module_newsletter
            WHERE id=$MailId", 1);
        if ($objMail !== false && $objMail->RecordCount() == 1) {
            $htmlContent = $objMail->fields['content'];
            $linkIds = array();

            $matches = NULL;
            if (preg_match_all("/<a([^>]+)>(.*?)<\/a>/is", $htmlContent, $matches)) {
                $tagCount = count($matches[0]);
                $fullKey = 0;
                $attrKey = 1;
                $textKey = 2;
                $rmatches = NULL;
                for ($i = 0; $i < $tagCount; $i++) {
// TODO: wouldn't that
                   if (!preg_match("/href\s*=\s*['\"][^#]/i", $matches[$attrKey][$i])) {
// be the same as
//                     if (preg_match("/href\s*=\s*['\"][#]/i", $matches[$attrKey][$i])) {
// ?
                        // we might have a placeholder link here, it will be parsed on send
                        continue;
                    }
                    $rel = '';
                    $href = '';
                    if (preg_match("/rel\s*=\s*(['\"])(.*?)\\1/i", $matches[$attrKey][$i], $rmatches)) {
                        $rel = $rmatches[2];
                    }
                    if (preg_match("/href\s*=\s*(['\"])(.*?)\\1/i", $matches[$attrKey][$i], $rmatches)) {
                        $href = html_entity_decode($rmatches[2], ENT_QUOTES, CONTREXX_CHARSET);
                    }
                    if ($rel) {
                        if (preg_match("/newsletter_link_(\d+)/i", $rel, $rmatches)) {
                            if (in_array($rmatches[1], $linkIds)) {
                                $query = "INSERT INTO ".DBPREFIX."module_newsletter_email_link (email_id, title, url) VALUES
                                    (".intval($MailId).", '".contrexx_raw2db($matches[$textKey][$i])."', '".contrexx_raw2db($href)."')";
                                if ($objDatabase->Execute($query)) {
                                    $linkId = $objDatabase->Insert_ID();
                                    $matches[$attrKey][$i] = str_replace(
                                        'newsletter_link_'.$rmatches[1],
                                        'newsletter_link_'.$linkId,
                                        $matches[$attrKey][$i]);
                                }
                            } else {
                                // update existed link
                                $query = "UPDATE ".DBPREFIX."module_newsletter_email_link
                                    SET title = '".contrexx_raw2db($matches[$textKey][$i])."',
                                        url = '".contrexx_raw2db($href)."'
                                    WHERE id = ".intval($rmatches[1]);
                                $objDatabase->Execute($query);
                                $linkId = $rmatches[1];
                            }
                        } else {
                            // insert new link into database and update rel attribute
                            $query = "INSERT INTO ".DBPREFIX."module_newsletter_email_link (email_id, title, url) VALUES
                                (".intval($MailId).", '".
                                contrexx_raw2db($matches[$textKey][$i])."', '".
                                contrexx_raw2db($href)."')";
                            if ($objDatabase->Execute($query)) {
                                $linkId = $objDatabase->Insert_ID();
                                $matches[$attrKey][$i] = preg_replace(
                                    "/rel\s*=\s*(['\"])(.*?)\\1/i",
                                    "rel=\"$2 newsletter_link_".$linkId."\"",
                                    $matches[$attrKey][$i]);
                            }
                        }
                    } else {
                        // insert new link into database and create rel attribute
                        $query = "INSERT INTO ".DBPREFIX."module_newsletter_email_link (email_id, title, url) VALUES
                            (".intval($MailId).", '".
                            contrexx_raw2db($matches[$textKey][$i])."', '".
                            contrexx_raw2db($href)."')";
                        if ($objDatabase->Execute($query)) {
                            $linkId = $objDatabase->Insert_ID();
                            $matches[$attrKey][$i] .= ' rel="newsletter_link_'.$linkId.'"';
                        }
                    }
                    $linkIds[] = $linkId;
                    $htmlContent = preg_replace(
                        "/".preg_quote($matches[$fullKey][$i], '/')."/is",
                        "<a ".$matches[$attrKey][$i].">".$matches[$textKey][$i]."</a>",
                        $htmlContent, 1);
                }
                // update mail content
                $query = "UPDATE ".DBPREFIX."module_newsletter
                    SET content = '".contrexx_raw2db($htmlContent)."'
                    WHERE id = ".intval($MailId);
                $objDatabase->Execute($query);
            }
            // remove deleted links from database; we can remove them, because we can't edit sent email
            if (count($linkIds) > 0) {
                $query = "DELETE FROM ".DBPREFIX."module_newsletter_email_link
                    WHERE id NOT IN (".implode(", ", $linkIds).") AND email_id = ".$MailId;
                $objDatabase->Execute($query);
            }
        }
    }

    function _prepareNewsletterLinksForCopy($MailHtmlContent)
    {
        $result = $MailHtmlContent;
        $matches = NULL;
        if (preg_match_all("/<a([^>]+)>(.*?)<\/a>/is", $result, $matches)) {
            $tagCount = count($matches[0]);
            $fullKey = 0;
            $attrKey = 1;
            $textKey = 2;
            for ($i = 0; $i < $tagCount; $i++) {
                if (!preg_match("/href\s*=\s*['\"]/i", $matches[$attrKey][$i])) {
                   continue;
                }
                // remove newsletter_link_N from rel attribute
// TODO: This code should go into the library as a private method.
// See prepareNewsletterLinksForSend()
                $matches[$attrKey][$i] = preg_replace("/newsletter_link_([0-9]+)/i", "", $matches[$attrKey][$i]);
                // remove empty rel attribute
                $matches[$attrKey][$i] = preg_replace("/\s*rel\s*=\s*(['\"])\s*\\1/i", "", $matches[$attrKey][$i]);
                // remove left and right spaces
// TODO: These REs miserably fail when apostrophes (') are used
// TODO: What do they *really* do?
                $matches[$attrKey][$i] = preg_replace("/([^=])\s*\"/i", "$1\"", $matches[$attrKey][$i]);
                $matches[$attrKey][$i] = preg_replace("/=\"\s*/i", "=\"", $matches[$attrKey][$i]);
                $result = preg_replace(
// TODO: The /s flag is probably unnecessary
                    "/".preg_quote($matches[$fullKey][$i], '/')."/is",
                    "<a ".$matches[$attrKey][$i].">".$matches[$textKey][$i]."</a>",
                    $result, 1);
            }
        }
        return $result;
    }

    function _showEmailFeedbackAnalysis()
    {
        global $objDatabase, $_ARRAYLANG, $_CONFIG;

        $this->_pageTitle = $_ARRAYLANG['TXT_NEWSLETTER_EMAIL_FEEDBACK'];
        $this->_objTpl->loadTemplateFile('module_newsletter_email_feedback.html');
        $rowNr = 0;
        $pos = isset($_GET['pos']) ? intval($_GET['pos']) : 0;
        $mailId = isset($_GET['id']) ? intval($_GET['id']) : 0;

        $email = '';
        $objMail = $objDatabase->SelectLimit("SELECT `subject` FROM ".DBPREFIX."module_newsletter WHERE id=".$mailId, 1);
        if ($objMail !== false && $objMail->RecordCount() == 1) {
            $email = contrexx_raw2xhtml($objMail->fields['subject']);
        }

        $this->_objTpl->setVariable(array(
            'TXT_NEWSLETTER_LINK_TITLE' => $_ARRAYLANG['TXT_NEWSLETTER_LINK_TITLE'],
            'TXT_NEWSLETTER_FEEDBACK_RECIPIENTS' => $_ARRAYLANG['TXT_NEWSLETTER_FEEDBACK_RECIPIENTS'],
            'TXT_NEWSLETTER_LINK_SOURCE' => $_ARRAYLANG['TXT_NEWSLETTER_LINK_SOURCE'],
            'TXT_NEWSLETTER_FUNCTIONS' => $_ARRAYLANG['TXT_NEWSLETTER_FUNCTIONS'],
            'TXT_NEWSLETTER_BACK' => $_ARRAYLANG['TXT_NEWSLETTER_BACK'],
            'TXT_NEWSLETTER_EMAIL_FEEDBACK' => sprintf($_ARRAYLANG['TXT_NEWSLETTER_SELECTED_EMAIL_FEEDBACK'], $email)
        ));

        $this->_objTpl->setGlobalVariable(array(
            'TXT_NEWSLETTER_OPEN_LINK_IN_NEW_TAB' => $_ARRAYLANG['TXT_NEWSLETTER_OPEN_LINK_IN_NEW_TAB'],
            'TXT_NEWSLETTER_LINK_FEEDBACK_ANALYZE' => $_ARRAYLANG['TXT_NEWSLETTER_LINK_FEEDBACK_ANALYZE']
        ));

        $objResultCount = $objDatabase->SelectLimit("SELECT COUNT(id) AS link_count FROM ".DBPREFIX."module_newsletter_email_link
            WHERE email_id = ".$mailId, 1);
        if ($objResultCount !== false) {
            $linkCount = $objResultCount->fields['link_count'];
        } else {
            $linkCount = 0;
        }

        $objResult = $objDatabase->SelectLimit("SELECT
            tblLink.id,
            tblLink.title,
            tblLink.url,
            tblMail.count,
            COUNT(tblMailLinkFB.id) AS feedback_count
            FROM ".DBPREFIX."module_newsletter_email_link AS tblLink
                INNER JOIN ".DBPREFIX."module_newsletter AS tblMail ON tblMail.id = ".$mailId."
                LEFT JOIN ".DBPREFIX."module_newsletter_email_link_feedback AS tblMailLinkFB ON tblMailLinkFB.link_id = tblLink.id
            WHERE tblLink.email_id = ".$mailId."
            GROUP BY tblLink.id
            ORDER BY tblLink.title ASC", $_CONFIG['corePagingLimit'], $pos);
        if ($objResult !== false) {
            while (!$objResult->EOF) {

                // parse NODE-Url placeholders in link
                \LinkGenerator::parseTemplate($objResult->fields['url'], true);

                $this->_objTpl->setVariable(array(
                    'NEWSLETTER_LINK_ROW_CLASS' => $rowNr % 2 == 1 ? 'row1' : 'row2',
                    'NEWSLETTER_LINK_TITLE'     => $objResult->fields['title'],
                    'NEWSLETTER_LINK_URL'       => $objResult->fields['url'],
                    'NEWSLETTER_MAIL_USERS'     => $objResult->fields['feedback_count'], // number of users, who have clicked the link
                    'NEWSLETTER_LINK_FEEDBACK'  => $objResult->fields['count'] > 0 ? round(100 /  $objResult->fields['count'] * $objResult->fields['feedback_count']) : 0
                ));

                $this->_objTpl->setGlobalVariable('NEWSLETTER_LINK_ID', $objResult->fields['id']);

                $this->_objTpl->parse("link_list");
                $objResult->MoveNext();
                $rowNr++;
            }
            if ($rowNr > 0) {
                $paging = getPaging($linkCount, $pos, ("&cmd=newsletter&act=feedback&email_id=".$mailId), "", false, $_CONFIG['corePagingLimit']);
                $this->_objTpl->setVariable('NEWSLETTER_LINKS_PAGING', "<br />".$paging."<br />");
            }
        }
    }

    private function getLinkData($linkId)
    {
        global $objDatabase;

        $objLink = $objDatabase->SelectLimit('
            SELECT  email_id,
                    title
            FROM    `'.DBPREFIX.'module_newsletter_email_link`
            WHERE   id='.$linkId, 1);
        if ($objLink == false || !$objLink->RecordCount()) {
            return false;
        }

        return array(
            'email_id'      => $objLink->fields['email_id'],
            'link_title'    => $objLink->fields['title']
        );
    }

    function _showLinkFeedbackAnalysis()
    {
// TODO: refactor method
        die('Feature unavailable');

        global $objDatabase, $_ARRAYLANG, $_CONFIG;

        if (empty($_GET['link_id'])) return $this->_mails();

        $rowNr = 0;
        $pos = isset($_GET['pos']) ? intval($_GET['pos']) : 0;
        $linkId = intval($_GET['link_id']);

        $arrLinkData = $this->getLinkData($linkId);
        if (!$arrLinkData) return $this->_mails();

        $arrNewsletterData = $this->getNewsletterData($arrLinkData['email_id']);
        if (!$arrNewsletterData) return $this->_mails();

        $this->_pageTitle = $_ARRAYLANG['TXT_NEWSLETTER_EMAIL_FEEDBACK'];
        $this->_objTpl->loadTemplateFile('module_newsletter_link_feedback.html');

        $this->_objTpl->setVariable(array(
            'TXT_NEWSLETTER_RECIPIENT'      => $_ARRAYLANG['TXT_NEWSLETTER_RECIPIENT'],
            'TXT_NEWSLETTER_FEEDBACK_CLICKS'=> $_ARRAYLANG['TXT_NEWSLETTER_FEEDBACK_CLICKS'],
            'TXT_NEWSLETTER_LINK_SOURCE'    => $_ARRAYLANG['TXT_NEWSLETTER_LINK_SOURCE'],
            'TXT_NEWSLETTER_FUNCTIONS'      => $_ARRAYLANG['TXT_NEWSLETTER_FUNCTIONS'],
            'TXT_NEWSLETTER_BACK'           => $_ARRAYLANG['TXT_NEWSLETTER_BACK'],
            'TXT_NEWSLETTER_LINK_FEEDBACK'  => sprintf( $_ARRAYLANG['TXT_NEWSLETTER_LINK_FEEDBACK'],
                                                        contrexx_raw2xhtml($arrLinkData['link_title']),
                                                        contrexx_raw2xhtml($arrNewsletterData['subject']))
        ));

        $this->_objTpl->setGlobalVariable(array(
            'TXT_NEWSLETTER_OPEN_LINK_IN_NEW_TAB' => $_ARRAYLANG['TXT_NEWSLETTER_OPEN_LINK_IN_NEW_TAB'],
            'TXT_NEWSLETTER_RECIPIENT_FEEDBACK_ANALYZE_DETAIL' => $_ARRAYLANG['TXT_NEWSLETTER_RECIPIENT_FEEDBACK_ANALYZE_DETAIL'],
            'TXT_NEWSLETTER_MODIFY_RECIPIENT' => $_ARRAYLANG['TXT_NEWSLETTER_MODIFY_RECIPIENT'],
            'NEWSLETTER_LINK_ID' => $linkId
        ));

        // The amount of tracked links of the selected e-mail
        $objResultCount = $objDatabase->SelectLimit("SELECT COUNT(id) AS link_count FROM ".DBPREFIX."module_newsletter_email_link
            WHERE email_id = ".$arrLinkData['email_id'], 1);
        if ($objResultCount !== false) {
            $linkCount = $objResultCount->fields['link_count'];
        } else {
            $linkCount = 0;
        }

        $newsletterUserIds = array();
        $accessUserIds = array();
        $feedbackCount = array();

        $query = "SELECT
                CASE WHEN `s`.`type` = '".self::USER_TYPE_NEWSLETTER."'
                    THEN `nu`.`id`
                    ELSE `au`.`id` END AS `id`,
                CASE WHEN `s`.`type` = '".self::USER_TYPE_NEWSLETTER."'
                    THEN `nu`.`firstname`
                    ELSE `aup`.`firstname` END AS `firstname`,
                CASE WHEN `s`.`type` = '".self::USER_TYPE_NEWSLETTER."'
                    THEN `nu`.`lastname`
                    ELSE `aup`.`lastname` END AS `lastname`,
                `s`.email,
                `s`.type,
                `s`.`sendt`
            FROM `".DBPREFIX."module_newsletter_tmp_sending` AS `s`
                LEFT JOIN `".DBPREFIX."module_newsletter_user` AS `nu` ON `nu`.`email` = `s`.`email` AND `s`.`type` = '".self::USER_TYPE_NEWSLETTER."'
                LEFT JOIN `".DBPREFIX."access_users` AS `au` ON `au`.`email` = `s`.`email` AND (`s`.`type` = '".self::USER_TYPE_ACCESS."' OR `s`.`type` = '".self::USER_TYPE_CORE."')
                LEFT JOIN `".DBPREFIX."access_user_profile` AS `aup` ON `aup`.`user_id` = `au`.`id`
            WHERE `s`.`newsletter` = ".$arrLinkData['email_id']." AND `s`.`sendt` > 0 AND (`au`.`email` IS NOT NULL OR `nu`.`email` IS NOT NULL)
            ORDER BY `lastname` ASC, `firstname` ASC";

        $objResult = $objDatabase->SelectLimit($query, $_CONFIG['corePagingLimit'], $pos);
        if ($objResult !== false) {
            $users = array();
            while (!$objResult->EOF) {
                $users[] = array(
                    'id'        => $objResult->fields['id'],
                    'firstname' => $objResult->fields['firstname'],
                    'lastname'  => $objResult->fields['lastname'],
                    'type'      => $objResult->fields['type']
                );

                switch ($objResult->fields['type']) {
                    case self::USER_TYPE_ACCESS:
                    case self::USER_TYPE_CORE:
                        $accessUserIds[] = $objResult->fields['id'];
                        break;

                    case self::USER_TYPE_NEWSLETTER:
                    default:
                        $newsletterUserIds[] = $objResult->fields['id'];
                        break;
                }

                $objResult->MoveNext();
            }

            // select stats of native newsletter recipients
            if (count($newsletterUserIds) > 0) {
                $objLinks = $objDatabase->Execute("SELECT
                        tblLink.recipient_id,
                        COUNT(tblLink.id) AS link_count
                    FROM ".DBPREFIX."module_newsletter_email_link_feedback AS tblLink
                    WHERE
                        tblLink.email_id = ".$arrLinkData['email_id']."
                        AND tblLink.recipient_id IN (".implode(", ", $newsletterUserIds).")
                        AND tblLink.recipient_type = '".self::USER_TYPE_NEWSLETTER."'
                    GROUP BY tblLink.recipient_id");
                if ($objLinks !== false) {
                    while (!$objLinks->EOF) {
                        $feedbackCount[$objLinks->fields['recipient_id']][self::USER_TYPE_NEWSLETTER] = $objLinks->fields['link_count'];
                        $objLinks->MoveNext();
                    }
                }
            }

            // select stats of access users
            if (count($accessUserIds) > 0) {
                $objLinks = $objDatabase->Execute("SELECT
                        tblLink.recipient_id,
                        COUNT(tblLink.id) AS link_count
                    FROM ".DBPREFIX."module_newsletter_email_link_feedback AS tblLink
                    WHERE
                        tblLink.email_id = ".$arrLinkData['email_id']."
                        AND tblLink.recipient_id IN (".implode(", ", $accessUserIds).")
                        # we only need to select by self::USER_TYPE_ACCESS here. stats of users with self::USER_TYPE_CORE are also created using self::USER_TYPE_ACCESS
                        AND tblLink.recipient_type = '".self::USER_TYPE_ACCESS."'
                    GROUP BY tblLink.recipient_id");
                if ($objLinks !== false) {
                    while (!$objLinks->EOF) {
                        $feedbackCount[$objLinks->fields['recipient_id']][self::USER_TYPE_ACCESS] = $objLinks->fields['link_count'];
                        $objLinks->MoveNext();
                    }
                }
            }

            foreach ($users as $user) {
                // stats for users of type self::USER_TYPE_CORE are made using type self::USER_TYPE_ACCESS
                if ($user['type'] == self::USER_TYPE_CORE) {
                    $user['type'] = self::USER_TYPE_ACCESS;
                }
                // The amount of valid requests from that certain recipient of the selected e-mail
                $feedback = isset($feedbackCount[$user['id']][$user['type']]) ? $feedbackCount[$user['id']][$user['type']] : 0;
                $this->_objTpl->setVariable(array(
                    'NEWSLETTER_RECIPIENT_ROW_CLASS' => $rowNr % 2 == 1 ? 'row1' : 'row2',
                    'USER_ID' => $user['id'],
                    'USER_TYPE' => $user['type'],
                    'NEWSLETTER_RECIPIENT_NAME' => htmlentities(trim($user['lastname'].' '.$user['firstname']), ENT_QUOTES, CONTREXX_CHARSET),
                    'NEWSLETTER_RECIPIENT_FEEDBACK' => $linkCount > 0 ? round(100 /  $linkCount * $feedback) : 0,
                    'NEWSLETTER_RECIPIENT_CLICKS' => $feedback
                ));

                if ($user['type'] == self::USER_TYPE_ACCESS) {
                    $this->_objTpl->touchBlock('access_user_type');
                    $this->_objTpl->hideBlock('newsletter_user_type');
                } else {
                    $this->_objTpl->hideBlock('access_user_type');
                    $this->_objTpl->touchBlock('newsletter_user_type');
                }

                $this->_objTpl->parse("recipient_list");
                $rowNr++;
            }
            if ($rowNr > 0) {
                $paging = getPaging($arrNewsletterData['count'], $pos, ("&cmd=newsletter&act=feedback&link_id=".$linkId), "", false, $_CONFIG['corePagingLimit']);
                $this->_objTpl->setVariable('NEWSLETTER_RECIPIENTS_PAGING', "<br />".$paging."<br />");
            }
        }
        $this->_objTpl->setVariable('NEWSLETTER_EMAIL_ID', $arrLinkData['email_id']);
        return true;
    }

    function _showRecipientEmailFeedbackAnalysis()
    {
// TODO: refactor method
        die('Feature unavailable');

        global $objDatabase, $_ARRAYLANG, $_CONFIG;

        $linkId = isset($_GET['link_id']) ? intval($_GET['link_id']) : 0;

        $recipientId = isset($_REQUEST['recipient_id']) ? intval($_REQUEST['recipient_id']) : 0;
        $recipientType = isset($_REQUEST['recipient_type']) ? $_REQUEST['recipient_type'] : '';
        if ($recipientId > 0) {
            if ($recipientType == 'newsletter') {
                $query = "SELECT lastname, firstname FROM ".DBPREFIX."module_newsletter_user WHERE id=".$recipientId;
            } elseif ($recipientType == 'access') {
                $query = "SELECT tlbProfile.lastname, tlbProfile.firstname
                    FROM ".DBPREFIX."access_users AS tlbUser
                        INNER JOIN ".DBPREFIX."access_user_profile AS tlbProfile ON tlbProfile.user_id = tlbUser.id
                    WHERE tlbUser.id=".$recipientId;
            }
            $objRecipient = $objDatabase->SelectLimit($query, 1);
            if ($objRecipient !== false && $objRecipient->RecordCount() == 1) {
                $recipientLastname = $objRecipient->fields['lastname'];
                $recipientFirstname = $objRecipient->fields['firstname'];
            } else {
                return $this->_mails();
            }
        }

        $mailId = 0;
        $mailTitle = '';
        $query = "SELECT tlbMail.id, tlbMail.subject
            FROM ".DBPREFIX."module_newsletter_email_link AS tlbLink
                INNER JOIN ".DBPREFIX."module_newsletter AS tlbMail ON tlbLink.email_id = tlbMail.id
            WHERE tlbLink.id=".$linkId;
        $objMail = $objDatabase->SelectLimit($query, 1);
        if ($objMail !== false && $objMail->RecordCount() == 1) {
            $mailId = $objMail->fields['id'];
            $mailTitle = $objMail->fields['subject'];
        }

        $this->_pageTitle = $_ARRAYLANG['TXT_NEWSLETTER_EMAIL_FEEDBACK'];
        $this->_objTpl->loadTemplateFile('module_newsletter_user_email_feedback.html');
        $this->_objTpl->setVariable('TXT_NEWSLETTER_USER_FEEDBACK_TITLE', sprintf($_ARRAYLANG['TXT_NEWSLETTER_RECIPIENT_EMAIL_FEEDBACK'], htmlentities(trim($recipientLastname." ".$recipientFirstname), ENT_QUOTES, CONTREXX_CHARSET), htmlentities($mailTitle, ENT_QUOTES, CONTREXX_CHARSET)));
        $this->_objTpl->setVariable('NEWSLETTER_LINK_ID', $linkId);

        $this->_objTpl->setVariable(array(
            'TXT_NEWSLETTER_LINK_TITLE' => $_ARRAYLANG['TXT_NEWSLETTER_LINK_TITLE'],
            'TXT_NEWSLETTER_LINK_SOURCE' => $_ARRAYLANG['TXT_NEWSLETTER_LINK_SOURCE'],
            'TXT_NEWSLETTER_FUNCTIONS' => $_ARRAYLANG['TXT_NEWSLETTER_FUNCTIONS'],
            'TXT_NEWSLETTER_BACK' => $_ARRAYLANG['TXT_NEWSLETTER_BACK']
        ));

        $this->_objTpl->setGlobalVariable(array(
            'TXT_NEWSLETTER_OPEN_LINK_IN_NEW_TAB' => $_ARRAYLANG['TXT_NEWSLETTER_OPEN_LINK_IN_NEW_TAB']
        ));

        $objResultCount = $objDatabase->SelectLimit("SELECT COUNT(id) AS link_count FROM ".DBPREFIX."module_newsletter_email_link_feedback
            WHERE recipient_id = ".$recipientId." AND recipient_type = '".$recipientType."'", 1);
        if ($objResultCount !== false) {
            $linkCount = $objResultCount->fields['link_count'];
        } else {
            $linkCount = 0;
        }

        $rowNr = 0;
        $pos = isset($_GET['pos']) ? intval($_GET['pos']) : 0;
        $objResult = $objDatabase->SelectLimit("SELECT
            tblLink.id,
            tblLink.title,
            tblLink.url
            FROM ".DBPREFIX."module_newsletter_email_link_feedback AS tblMailLinkFB
                INNER JOIN ".DBPREFIX."module_newsletter AS tblMail ON tblMail.id = tblMailLinkFB.email_id
                INNER JOIN ".DBPREFIX."module_newsletter_email_link  AS tblLink ON tblLink.id = tblMailLinkFB.link_id
            WHERE
                tblMail.id = ".$mailId."
                AND tblMailLinkFB.recipient_id = ".$recipientId."
                AND tblMailLinkFB.recipient_type = '".$recipientType."'
            ORDER BY tblLink.title ASC", $_CONFIG['corePagingLimit'], $pos);
        if ($objResult !== false) {

            while (!$objResult->EOF) {
                $this->_objTpl->setVariable(array(
                    'NEWSLETTER_LINK_ROW_CLASS' => $rowNr % 2 == 1 ? 'row1' : 'row2',
                    'NEWSLETTER_LINK_TITLE' => htmlentities($objResult->fields['title'], ENT_QUOTES, CONTREXX_CHARSET),
                    'NEWSLETTER_LINK_URL' => $objResult->fields['url']
                ));

                $this->_objTpl->parse("link_list");
                $objResult->MoveNext();
                $rowNr++;
            }
            if ($rowNr > 0) {
                $paging = getPaging($linkCount, $pos, ("&cmd=newsletter&act=feedback&link_id=".$linkId."&recipient_id=".$recipientId."&recipient_type=".$recipientType), "", false, $_CONFIG['corePagingLimit']);
                $this->_objTpl->setVariable('NEWSLETTER_LINKS_PAGING', "<br />".$paging."<br />");
            } else {
                $this->_objTpl->setVariable('NEWSLETTER_USER_NO_FEEDBACK', $_ARRAYLANG['TXT_NEWSLETTER_USER_NO_FEEDBACK']);
                $this->_objTpl->touchBlock('link_list_empty');
                $this->_objTpl->hideBlock('link_list');
            }
        }

        return true;
    }

    function _showRecipientFeedbackAnalysis()
    {

        global $objDatabase, $_ARRAYLANG, $_CONFIG;

        if (   empty($_REQUEST['id'])
            || empty($_REQUEST['recipient_type'])
            || !in_array($_REQUEST['recipient_type'], array(self::USER_TYPE_NEWSLETTER, self::USER_TYPE_ACCESS))
        ) {
            return $this->_userList();
        }

        $recipientId = intval($_REQUEST['id']);
        $recipientType = $_REQUEST['recipient_type'];
        $linkCount = 0;

        if ($recipientType == self::USER_TYPE_NEWSLETTER) {
            $objRecipient = $objDatabase->SelectLimit('SELECT `lastname`, `firstname` FROM `'.DBPREFIX.'module_newsletter_user` WHERE `id`='.$recipientId, 1);
            if ($objRecipient !== false && $objRecipient->RecordCount() == 1) {
                $recipientLastname = $objRecipient->fields['lastname'];
                $recipientFirstname = $objRecipient->fields['firstname'];
            } else {
                return $this->_userList();
            }
        } else {
            $objRecipient = FWUser::getFWUserObject()->objUser->getUser($recipientId);
            if ($objRecipient) {
                $recipientLastname = $objRecipient->getProfileAttribute('lastname');
                $recipientFirstname = $objRecipient->getProfileAttribute('firstname');
            } else {
                return $this->_userList();
            }
        }

        $this->_pageTitle = $_ARRAYLANG['TXT_NEWSLETTER_USER_ADMINISTRATION'];
        $this->_objTpl->addBlockfile('NEWSLETTER_USER_FILE', 'module_newsletter_user_feedback', 'module_newsletter_user_feedback.html');
        $this->_objTpl->setVariable('TXT_NEWSLETTER_USER_FEEDBACK_TITLE', sprintf($_ARRAYLANG['TXT_NEWSLETTER_RECIPIENT_FEEDBACK'], contrexx_raw2xhtml(trim($recipientLastname." ".$recipientFirstname))));

        $this->_objTpl->setVariable(array(
            'TXT_NEWSLETTER_LINK_TITLE' => $_ARRAYLANG['TXT_NEWSLETTER_LINK_TITLE'],
            'TXT_NEWSLETTER_EMAIL' => $_ARRAYLANG['TXT_NEWSLETTER_EMAIL'],
            'TXT_NEWSLETTER_LINK_SOURCE' => $_ARRAYLANG['TXT_NEWSLETTER_LINK_SOURCE'],
            'TXT_NEWSLETTER_FUNCTIONS' => $_ARRAYLANG['TXT_NEWSLETTER_FUNCTIONS'],
            'TXT_NEWSLETTER_BACK' => $_ARRAYLANG['TXT_NEWSLETTER_BACK']
        ));

        $this->_objTpl->setGlobalVariable(array(
            'TXT_NEWSLETTER_OPEN_LINK_IN_NEW_TAB' => $_ARRAYLANG['TXT_NEWSLETTER_OPEN_LINK_IN_NEW_TAB']
        ));

        $objResultCount = $objDatabase->SelectLimit('
            SELECT COUNT(1) AS `link_count`
              FROM `'.DBPREFIX.'module_newsletter_email_link_feedback`
             WHERE `recipient_id` = '.$recipientId.'
               AND `recipient_type` = \''.$recipientType.'\'', 1);
        if ($objResultCount !== false) {
            $linkCount = $objResultCount->fields['link_count'];
        }

        $rowNr = 0;
        $pos = isset($_GET['pos']) ? intval($_GET['pos']) : 0;
        $objResult = $objDatabase->SelectLimit("SELECT
            tblLink.id,
            tblLink.title,
            tblLink.url,
            tblMail.subject
            FROM ".DBPREFIX."module_newsletter_email_link_feedback AS tblMailLinkFB
                INNER JOIN ".DBPREFIX."module_newsletter AS tblMail ON tblMail.id = tblMailLinkFB.email_id
                INNER JOIN ".DBPREFIX."module_newsletter_email_link  AS tblLink ON tblMailLinkFB.link_id = tblLink.id
            WHERE tblMailLinkFB.recipient_id = ".$recipientId."  AND tblMailLinkFB.recipient_type = '".$recipientType."'
            ORDER BY tblLink.title ASC", $_CONFIG['corePagingLimit'], $pos);
        if ($objResult !== false) {
            while (!$objResult->EOF) {
                $this->_objTpl->setVariable(array(
                    'NEWSLETTER_LINK_ROW_CLASS' => $rowNr % 2 == 1 ? 'row1' : 'row2',
                    'NEWSLETTER_LINK_TITLE'     => contrexx_raw2xhtml($objResult->fields['title']),
                    'NEWSLETTER_LINK_URL'       => $objResult->fields['url'],
                    'NEWSLETTER_EMAIL'          => $objResult->fields['subject']
                ));

                $this->_objTpl->setGlobalVariable('NEWSLETTER_LINK_ID', $objResult->fields['id']);

                $this->_objTpl->parse("link_list");
                $objResult->MoveNext();
                $rowNr++;
            }
            if ($rowNr > 0) {
                $paging = getPaging($linkCount, $pos, ("&cmd=newsletter&act=users&tpl=feedback&id=".$recipientId), "", false, $_CONFIG['corePagingLimit']);
                $this->_objTpl->setVariable('NEWSLETTER_LINKS_PAGING', "<br />".$paging."<br />");
            } else {
                $this->_objTpl->setVariable('NEWSLETTER_USER_NO_FEEDBACK', $_ARRAYLANG['TXT_NEWSLETTER_USER_NO_FEEDBACK']);
                $this->_objTpl->touchBlock('link_list_empty');
                $this->_objTpl->hideBlock('link_list');
            }
        }

        return true;
    }
}


if (!class_exists('DBIterator')) {

    /**
     * Iterator wrapper for adodb result objects
     *
     * @copyright   CONTREXX CMS - COMVATION AG
     * @author      Stefan Heinemann <sh@adfinis.com>
     * @package     contrexx
     * @subpackage  module_newsletter
     */
    class DBIterator implements Iterator {
        /**
         * The result object of adodb
         */
        private $obj;

        /**
         * If the result was empty
         *
         * (To prevent illegal object access)
         */
        private $empty;

        /**
         * The position in the rows
         *
         * Mainly just to have something to return in the
         * key() method.
         */
        private $position = 0;

        /**
         * Assign the object
         *
         * @param       object (adodb result object)
         */
        public function __construct($obj) {
            $this->empty = !($obj instanceof ADORecordSet);

            $this->obj = $obj;
        }

        /**
         * Go back to first position
         */
        public function rewind() {
            if (!$this->empty) {
                $this->obj->MoveFirst();
            }

            $this->position = 0;
        }

        /**
         * Return the current object
         *
         * @return      array
         */
        public function current() {
            return $this->obj->fields;
            // if valid return false, this function should never be called,
            // so no problem with illegal access here i guess
        }

        /**
         * Return the current key
         *
         * @return      int
         */
        public function key() {
            return $this->position;
        }

        /**
         * Go to the next item
         */
        public function next() {
            if (!$this->empty) {
                $this->obj->MoveNext();
            }

            ++$this->position;
        }

        /**
         * Return if there are any items left
         *
         * @return      bool
         */
        public function valid() {
            if ($this->empty) {
                return false;
            }

            return !$this->obj->EOF;
        }
    }

}
