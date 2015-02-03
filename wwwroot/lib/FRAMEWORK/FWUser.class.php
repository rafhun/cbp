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
 * Framework user
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Comvation Development Team <info@comvation.com>
 * @version     1.0.0
 * @package     contrexx
 * @subpackage  lib_framework
 */

/**
 * Framework user
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Comvation Development Team <info@comvation.com>
 * @version     1.0.0
 * @package     contrexx
 * @subpackage  lib_framework
 */
class FWUser extends User_Setting
{
    public $arrStatusMsg = array(
        'ok'    => array(),
        'error' => array(),
    );

    public $backendMode;
    /**
     * User
     * @var   User
     */
    public $objUser;
    /**
     * User Group
     * @var   UserGroup
     */
    public $objGroup;

    /**
     * Host names which are allowed to redirect on the login/logout function.
     * eg : (http://example.com, http://www.example.com)
     * @var array
     */
    public static $allowedHosts = array();
            
    function __construct($backend = false)
    {
        parent::__construct();
        $this->setMode($backend);
        $this->objUser = new User();
        $this->objGroup = new UserGroup();
    }


    /**
     * Toggle backend mode on (true) or off (false)
     * @param   boolean   $backend    Turn on backend mode if true,
     *                                off otherwise.
     */
    function setMode($backend=false)
    {
        $this->backendMode = $backend;
    }


    /**
     * Get the backend mode flag
     * @return  boolean             Backend mode is on if this evaluates to
     *                              boolean true.
     */
    function isBackendMode()
    {
        return $this->backendMode;
    }


    /**
     * Verify user authentication
     * @return  boolean           True if authentication is okay,
     *                            false otherwise
     */
    function checkAuth()
    {
        global $sessionObj, $_CORELANG, $objInit;

        $username = isset($_POST['USERNAME']) && $_POST['USERNAME'] != '' ? contrexx_stripslashes($_POST['USERNAME']) : null;
        $password = isset($_POST['PASSWORD']) && $_POST['PASSWORD'] != '' ? md5(contrexx_stripslashes($_POST['PASSWORD'])) : null;

        if (isset($username) && isset($password)) {
            if (empty($sessionObj)) $sessionObj = cmsSession::getInstance();
		    if (!isset($_SESSION['auth'])) {
		        $_SESSION['auth'] = array();
		    }
            if ($this->objUser->auth($username, $password, $this->isBackendMode(), FWCaptcha::getInstance()->check())) {
                if ($this->isBackendMode()) {
                    $this->log();
                }
                $this->loginUser($this->objUser);
                return true;
            }
            $_SESSION['auth']['loginLastAuthFailed'] = 1;
            User::registerFailedLogin($username);
            $this->arrStatusMsg['error'][] = $_CORELANG['TXT_PASSWORD_OR_USERNAME_IS_INCORRECT'];
            $_SESSION->cmsSessionUserUpdate();
            $_SESSION->cmsSessionStatusUpdate($this->isBackendMode() ? 'backend' : 'frontend');
        }
        return false;
    }

    /**
     * Checks the login
     *
     * @return  bool|mixed  false or user id
     */
    public function checkLogin()
    {
        $username = isset($_POST['USERNAME']) && $_POST['USERNAME'] != '' ? contrexx_stripslashes($_POST['USERNAME']) : null;
        $password = isset($_POST['PASSWORD']) && $_POST['PASSWORD'] != '' ? md5(contrexx_stripslashes($_POST['PASSWORD'])) : null;

        if (isset($username) && isset($password)) {
            return $this->objUser->checkLoginData($username, $password, \FWCaptcha::getInstance()->check());
        }

        return false;
    }

    /**
     * Log in the current user with the object given
     * @param mixed $objUser the user to be logged in
     */
    function loginUser($objUser) {
        global $objInit;

        $_SESSION->cmsSessionUserUpdate($objUser->getId());
        $objUser->registerSuccessfulLogin();
        unset($_SESSION['auth']['loginLastAuthFailed']);
        // Store frontend lang_id in cookie
        if (empty($_COOKIE['langId'])) {
            // TODO: Seems that this method returns zero at first when the Users' language is set to "default"!
            $langId = $objUser->getFrontendLanguage();
            // Temporary fix:
            if (empty($langId)) $langId = FWLanguage::getDefaultLangId();
            if ($objInit->arrLang[$langId]['frontend']) {
                setcookie("langId", $langId, time()+3600*24*30, ASCMS_PATH_OFFSET.'/');
            }
        }
    }


    /**
     * Logs the User off and destroys the session.
     *
     * If the User was in backend mode, redirects her to the frontend home page.
     * Otherwise, if a redirect was requested, the desired page is called.
     * If no redirect parameter is present, the frontend login page is shown.
     */
    function logout()
    {        
        
         $this->logoutAndDestroySession();
        
        if ($this->backendMode) {
            $pathOffset = ASCMS_PATH_OFFSET;
            
            CSRF::header('Location: '.(!empty($pathOffset)
                ? $pathOffset
                : '/'));
        } else {
            $redirect = '';
            if (!empty($_REQUEST['redirect'])) {
                $redirect = self::getRedirectUrl($_REQUEST['redirect']);
            }

            CSRF::header('Location: '.(!empty($redirect)
                ? $redirect
                : CONTREXX_DIRECTORY_INDEX.'?section=login'));
        }
        exit;
    }

    public static function getRedirectUrl($redirectUrl)
    {
        global $_CONFIG;
        
        $pathOffset = ASCMS_PATH_OFFSET;
        
        $redirect = $baseUrl = ASCMS_PROTOCOL . '://' . $_CONFIG['domainUrl'] . (!empty($pathOffset) ? $pathOffset : '/');
        $rawUrl   = trim(self::getRawUrL(urldecode($redirectUrl), $baseUrl));

        if (
                self::hostFromUri($baseUrl) == self::hostFromUri($rawUrl) 
             || (!empty(self::$allowedHosts) && in_array(self::hostFromUri($rawUrl), array_map(array('FWUser', 'hostFromUri'), self::$allowedHosts)))
           ) {            
            $redirect = $rawUrl;
        }

        return $redirect;
    }

    /**
     * Returns the host name from the given url
     * www will be striped from the given url
     * 
     * @param string $uri url string
     * @return string
     */
    public static function hostFromUri($uri)
    {
        extract(parse_url($uri));
        
        return str_ireplace('www.', '', $scheme.'://'.$host);
    }

    /**
     * Return the Absolute URL associated of the given string.
     *     
     * @return string The URL     
     */
    public static function getRawUrL($url, $baseUrl)
    {
        /* return if already absolute URL */
        if (parse_url($url, PHP_URL_SCHEME) != '') return $url;

        /* queries and anchors */
        if ($url[0]=='#' || $url[0]=='?') return $baseUrl.$url;

        /* parse base URL and convert to local variables:
           $scheme, $host, $path */
        extract(parse_url($baseUrl));

        /* remove non-directory element from path */
        $path = preg_replace('#/[^/]*$#', '', $path);

        /* destroy path if relative url points to root */
        if ($url[0] == '/') $path = '';

        /* dirty absolute URL // with port number if exists */
        if (parse_url($baseUrl, PHP_URL_PORT) != ''){
            $abs = "$host:".parse_url($baseUrl, PHP_URL_PORT)."$path/$url";
        }else{
            $abs = "$host$path/$url";
        }
        /* replace '//' or '/./' or '/foo/../' with '/' */
        $re = array('#(/\.?/)#', '#/(?!\.\.)[^/]+/\.\./#');
        for($n=1; $n>0; $abs=preg_replace($re, '/', $abs, -1, $n)) {}

        /* absolute URL is ready! */
        return $scheme.'://'.$abs;        
        
    }
    
    /**
     * Logs the user off and destroys the session.
     */
    public function logoutAndDestroySession()
    {
        if (isset($_SESSION['auth'])) {
            unset($_SESSION['auth']);
        }
        session_destroy();
        setcookie(session_name(), '', time() - 3600, ASCMS_PATH_OFFSET.'/');
    }

    /**
     * Log the user session.
     *
     * Create a log entry in the database containing the users' details.
     * @global  ADONewConnection
     */
    function log()
    {
        global $objDatabase;

        if (!isset($_SESSION['auth']['log'])) {
            $remote_host = @gethostbyaddr($_SERVER['REMOTE_ADDR']);
            $referer = get_magic_quotes_gpc() ? strip_tags((strtolower($_SERVER['HTTP_REFERER']))) : addslashes(strip_tags((strtolower($_SERVER['HTTP_REFERER']))));
            $httpUserAgent = get_magic_quotes_gpc() ? strip_tags($_SERVER['HTTP_USER_AGENT']) : addslashes(strip_tags($_SERVER['HTTP_USER_AGENT']));
            $httpAcceptLanguage = get_magic_quotes_gpc() ? strip_tags($_SERVER['HTTP_ACCEPT_LANGUAGE']) : addslashes(strip_tags($_SERVER['HTTP_ACCEPT_LANGUAGE']));

            $objFWUser = FWUser::getFWUserObject();
            $objDatabase->Execute("INSERT INTO ".DBPREFIX."log
                                        SET userid=".$objFWUser->objUser->getId().",
                                            datetime = ".$objDatabase->DBTimeStamp(time()).",
                                            useragent = '".substr($httpUserAgent, 0, 250)."',
                                            userlanguage = '".substr($httpAcceptLanguage, 0, 250)."',
                                            remote_addr = '".substr(strip_tags($_SERVER['REMOTE_ADDR']), 0, 250)."',
                                            remote_host = '".substr($remote_host, 0, 250)."',
                                            http_x_forwarded_for = '".(isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? substr(strip_tags($_SERVER['HTTP_X_FORWARDED_FOR']), 0, 250) : '')."',
                                            http_via = '".(isset($_SERVER['HTTP_VIA']) ? substr(strip_tags($_SERVER['HTTP_VIA']), 0, 250) : '')."',
                                            http_client_ip = '".(isset($_SERVER['HTTP_CLIENT_IP']) ? substr(strip_tags($_SERVER['HTTP_CLIENT_IP']), 0, 250) : '')."',
                                            referer ='".substr($referer, 0, 250)."'");
            $_SESSION['auth']['log']=true;
        }
    }


    function getErrorMsg()
    {
        return implode('<br />', $this->arrStatusMsg['error']);
    }


    private static function loadTemplate($template)
    {
        $objTemplate = new \Cx\Core\Html\Sigma(ASCMS_THEMES_PATH);
        $objTemplate->setErrorHandling(PEAR_ERROR_DIE);
        $objTemplate->setTemplate($template[0]);
        self::parseLoggedInOutBlocks($objTemplate);
        return $objTemplate->get();
    }


    public static function parseLoggedInOutBlocks(&$template)
    {
        $accessLoggedInOutBlockIdx = '';
        $accessLoggedInBlock = 'access_logged_in';
        $accessLoggedInTplBlock = $accessLoggedInBlock.$accessLoggedInOutBlockIdx;
        $accessLoggedOutBlock = 'access_logged_out';
        $accessLoggedOutTplBlock = $accessLoggedOutBlock.$accessLoggedInOutBlockIdx;

        if (!is_object($template)) {
            // content provided instead of \Cx\Core\Html\Sigma object
            $template = preg_replace_callback('/<!--\s+BEGIN\s+(access_logged_(?:in|out)[0-9]*)\s+-->.*<!--\s+END\s+\1\s+-->/sm', array('self', 'loadTemplate'), $template);
            return;
        } else {
            $objTemplate = $template;
        }

        while ($accessLoggedInOutBlockIdx <= 10) {
            // parse access_logged_in[_[1-10]] blocks
            if ($objTemplate->blockExists($accessLoggedInTplBlock)) {
                $objFWUser = FWUser::getFWUserObject();
                if ($objFWUser->objUser->login()) {
                    $objFWUser->setLoggedInInfos($objTemplate, $accessLoggedInTplBlock);
                    $objTemplate->touchBlock($accessLoggedInTplBlock);
                } else {
                    $objTemplate->hideBlock($accessLoggedInTplBlock);
                }
            }

            // parse access_logged_out[_[1-10]] blocks
            if ($objTemplate->blockExists($accessLoggedOutTplBlock)) {
                $objFWUser = FWUser::getFWUserObject();
                if ($objFWUser->objUser->login()) {
                    $objTemplate->hideBlock($accessLoggedOutTplBlock);
                } else {
                    $objTemplate->touchBlock($accessLoggedOutTplBlock);
                }
            }

            $accessLoggedInOutBlockIdx++;
            $accessLoggedInTplBlock = $accessLoggedInBlock.$accessLoggedInOutBlockIdx;
            $accessLoggedOutTplBlock = $accessLoggedOutBlock.$accessLoggedInOutBlockIdx;
        }
    }


    private function setLoggedInInfos($objTemplate, $blockName = '')
    {
        global $_CORELANG;

        $objUser = FWUser::getFWUserObject()->objUser;
        if (!$objUser->login()) {
            return false;
        }

        $loggedInLabel = $_CORELANG['TXT_LOGGED_IN_AS'].' '.contrexx_raw2xhtml($objUser->getUsername());

        if (empty($blockName) || $blockName == 'access_logged_in') {
            $username = $objUser->getUsername();
            if (empty($username)) {
                $username = $objUser->getEmail();
            }

            // this is for backwards compatibility for version pre 3.0
            $objTemplate->setVariable(array(
                'LOGGING_STATUS'        => $loggedInLabel,
                'ACCESS_USER_ID'        => $objUser->getId(),
                'ACCESS_USER_USERNAME'  => contrexx_raw2xhtml($username),
                'ACCESS_USER_EMAIL'     => contrexx_raw2xhtml($objUser->getEmail()),
            ));

            $blockName = 'access_logged_in';
        }
        $placeholderPrefix = strtoupper($blockName).'_';

        $objTemplate->setVariable(array(
            $placeholderPrefix.'LOGGING_STATUS' => $loggedInLabel,
            $placeholderPrefix.'USER_ID'        => $objUser->getId(),
            $placeholderPrefix.'USER_USERNAME'  => contrexx_raw2xhtml($objUser->getUsername()),
            $placeholderPrefix.'USER_EMAIL'     => contrexx_raw2xhtml($objUser->getEmail()),
        ));

        $objAccessLib = new AccessLib($objTemplate);
        $objAccessLib->setModulePrefix($placeholderPrefix);
        $objAccessLib->setAttributeNamePrefix($blockName.'_profile_attribute');

        $objUser->objAttribute->first();
        while (!$objUser->objAttribute->EOF) {
            $objAttribute = $objUser->objAttribute->getById($objUser->objAttribute->getId());
            $objAccessLib->parseAttribute($objUser, $objAttribute->getId(), 0, false, false, false, false, false);
            $objUser->objAttribute->next();
        }

        return true;
    }


    /**
     * Restore password of user account
     *
     * Sends an email with instructions on how to reset the password to
     * the user specified by an e-mail address.
     * @param  string  $email      The e-mail address presented by the user
     * @global array
     * @global array
     * @global integer
     */
    public function restorePassword($email)
    {
        global $_CORELANG, $_CONFIG, $_LANGID;

// TODO: START: WORKAROUND FOR ACCOUNTS SOLD IN THE SHOP
// original code:
//        $objUser = $this->objUser->getUsers(
//            array('email' => $email, 'is_active' => true), null, null, null, 1
//        );
// workaround code:
        $objUser = $this->objUser->getUsers(
            array('email' => array('REGEXP' => '^(shop_customer_[0-9]+_[0-9]+_[0-9]-)?'.preg_quote($email).'$'), 'is_active' => true), null, null, null
        );
// END: WORKAROUND FOR ACCOUNTS SOLD IN THE SHOP
        if ($objUser) {
// TODO: START: WORKAROUND FOR ACCOUNTS SOLD IN THE SHOP
// workaround code:
            while (!$objUser->EOF) {
// END: WORKAROUND FOR ACCOUNTS SOLD IN THE SHOP
            $objUserMail = $this->getMail();
            $objUser->setRestoreKey();
            if ($objUser->store() &&
                (
                    $objUserMail->load('reset_pw', $_LANGID) ||
                    $objUserMail->load('reset_pw')
                ) &&
                (include_once ASCMS_LIBRARY_PATH.'/phpmailer/class.phpmailer.php') &&
                ($objMail = new PHPMailer()) !== false
            ) {
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
                $objMail->From = $objUserMail->getSenderMail();
                $objMail->FromName = $objUserMail->getSenderName();
                $objMail->AddReplyTo($objUserMail->getSenderMail());
                $objMail->Subject = $objUserMail->getSubject();

                if ($this->isBackendMode()) {
                    $restorLink = strtolower(ASCMS_PROTOCOL)."://".$_CONFIG['domainUrl'].ASCMS_PATH_OFFSET.ASCMS_BACKEND_PATH."/index.php?cmd=login&act=resetpw&email=".urlencode($objUser->getEmail())."&restoreKey=".$objUser->getRestoreKey();
                } else {
                    $restorLink = strtolower(ASCMS_PROTOCOL)."://".$_CONFIG['domainUrl'].CONTREXX_SCRIPT_PATH."?section=login&cmd=resetpw&email=".urlencode($objUser->getEmail())."&restoreKey=".$objUser->getRestoreKey();
                }

                if (in_array($objUserMail->getFormat(), array('multipart', 'text'))) {
                    $objUserMail->getFormat() == 'text' ? $objMail->IsHTML(false) : false;
                    $objMail->{($objUserMail->getFormat() == 'text' ? '' : 'Alt').'Body'} = str_replace(
                        array(
                            '[[USERNAME]]',
                            '[[URL]]',
                            '[[SENDER]]'
                        ),
                        array(
                            $objUser->getUsername(),
                            $restorLink,
                            $objUserMail->getSenderName()
                        ),
                        $objUserMail->getBodyText()
                    );
                }
                if (in_array($objUserMail->getFormat(), array('multipart', 'html'))) {
                    $objUserMail->getFormat() == 'html' ? $objMail->IsHTML(true) : false;
                    $objMail->Body = str_replace(
                        array(
                            '[[USERNAME]]',
                            '[[URL]]',
                            '[[SENDER]]'
                        ),
                        array(
                            htmlentities($objUser->getUsername(), ENT_QUOTES, CONTREXX_CHARSET),
                            $restorLink,
                            htmlentities($objUserMail->getSenderName(), ENT_QUOTES, CONTREXX_CHARSET)
                        ),
                        $objUserMail->getBodyHtml()
                    );
                }

                $objMail->AddAddress($objUser->getEmail());


                if ($objMail->Send()) {
// TODO: START: WORKAROUND FOR ACCOUNTS SOLD IN THE SHOP
// original code:
//                    return true;
// workaround code:
                    $status = true;
// END: WORKAROUND FOR ACCOUNTS SOLD IN THE SHOP
                } else {
                    $this->arrStatusMsg['error'][] = str_replace("%EMAIL%", $email, $_CORELANG['TXT_EMAIL_NOT_SENT']);
                }
            } else {
                $this->arrStatusMsg['error'][] = str_replace("%EMAIL%", $email, $_CORELANG['TXT_EMAIL_NOT_SENT']);
            }
// TODO: START: WORKAROUND FOR ACCOUNTS SOLD IN THE SHOP
// workaround code:
            $objUser->next();
        }
// END: WORKAROUND FOR ACCOUNTS SOLD IN THE SHOP
        } else {
            $this->arrStatusMsg['error'][] = $_CORELANG['TXT_ACCOUNT_WITH_EMAIL_DOES_NOT_EXIST']."<br />";
        }

// TODO: START: WORKAROUND FOR ACCOUNTS SOLD IN THE SHOP
// workaround code:
        if ($status) {
            return true;
        }
// END: WORKAROUND FOR ACCOUNTS SOLD IN THE SHOP
        return false;
    }


    /**
     * Format the author and publisher title
     * @global array
     * @param   mixed   Either the ID of the user account to parse or a User object
     *                  of the user account to parse.
     * @param   string  User name
     * @param   boolean Whether or not to add the username to the title
     * @return  string  Generated user title
     */
    public static function getParsedUserTitle($user, $name = '', $showUsername = false)
    {
        global $_CORELANG;

        static $arrTitles = array();

        if ($user) {
            if (is_object($user)) {
                $userId = $user->getId();
            } else {
                $userId = $user;
            }

            if (isset($arrTitles[$userId])) {
                $name = $arrTitles[$userId]['name'];
                $username = $arrTitles[$userId]['username'];
            } else {
                if (!is_object($user)) {
                    $user = FWUser::getFWUserObject()->objUser->getUser($userId);
                }

                if ($user) {
                    $company   = trim($user->getProfileAttribute('company'));
                    $lastname  = trim($user->getProfileAttribute('lastname'));
                    $firstname = trim($user->getProfileAttribute('firstname'));
                    $username  = $user->getUsername();

                    $nameFragments = array();
                    if (!empty($company)) {
                        $nameFragments[] = $company;
                    }
                    if (!empty($firstname) || !empty($lastname)) {
                        $nameFragments[] = trim($firstname.' '.$lastname);
                    }
                    $name = join(', ', $nameFragments);

                    $arrTitles[$userId] = array(
                        'name'      => $name,
                        'username'  => $username,
                    );
                }
            }
        }

        if (!empty($name)) {
            // set name as title
            $title = $name;
            if ($showUsername && !empty($username)) {
                // add username to name if requested
                $title = $name.' ('.$username.')';
            }
        } elseif (empty($name) && !empty($username)) {
            // no name was set, so lets just use the username instead (in case one had been set)
            $title = $username;
        } else {
            // neither a name, nor a username had been set
            $title = $_CORELANG['TXT_ACCESS_UNKNOWN'];
        }

        return $title;
    }


    /**
     * Reset the password of the user using a reset form.
     * @access  public
     * @param   mixed  $objTemplate Template
     * @global  array  Core language array
     */
    function resetPassword($username, $restoreKey, $password = null, $confirmedPassword = null, $store = false)
    {
        global $_CORELANG;

        // ensure the supplied $restoreKey is a valid restore key
        if (!preg_match('/^[0-9a-f]+$/i', $restoreKey)) {
            $this->arrStatusMsg['error'][] = $_CORELANG['TXT_INVALID_USER_ACCOUNT'];
            return false;
        }

        $userFilter = array(
            'restore_key'      => $restoreKey,
            'restore_key_time' => array(
                array (
                    '>' => time(),
                ),
                '=' => time(),
            ),
            'active'           => 1,
        );

        $arrSettings = User_Setting::getSettings();
        if ($arrSettings['use_usernames']['status']) {
            $userFilter['username'] = $username;
        } else {
            $userFilter['email'] = $username;
        }

        $objUser = $this->objUser->getUsers($userFilter, null, null, null, 1);
        if ($objUser) {
            if ($store) {
                if ($objUser->setPassword($password, $confirmedPassword, true) &&
                    $objUser->releaseRestoreKey() &&
                    $objUser->store()
                ) {
                    return true;
                }
                $this->arrStatusMsg['error'] = array_merge($this->arrStatusMsg['error'], $objUser->getErrorMsg());
            } else {
                return true;
            }
        } else {
            $this->arrStatusMsg['error'][] = $_CORELANG['TXT_INVALID_USER_ACCOUNT'];
        }
        return false;
    }


    public static function showCurrentlyOnlineUsers()
    {
        $arrSettings = User_Setting::getSettings();
        return $arrSettings['block_currently_online_users']['status'];
    }


    public static function showLastActivUsers()
    {
        $arrSettings = User_Setting::getSettings();
        return $arrSettings['block_last_active_users']['status'];
    }


    public static function showLatestRegisteredUsers()
    {
        $arrSettings = User_Setting::getSettings();
        return $arrSettings['block_latest_reg_users']['status'];
    }


    public static function showBirthdayUsers()
    {
        $arrSettings = User_Setting::getSettings();
        return $arrSettings['block_birthday_users']['status'];
    }


    /**
     * Returns the static FWUser object
     * @return  FWUser
     */
    public static function getFWUserObject()
    {
        global $objInit;
        static $objFWUser;

        if (!isset($objFWUser)) {
            $objFWUser = new FWUser($objInit->mode == 'backend');
        }
        return $objFWUser;
    }


    /**
     * Return the number of registered users.
     * Only users with an active and valid account are counted.
     * global ADONewConnection
     * Return integer
     */
    public static function getUserCount()
    {
        global $objDatabase;

        $objResult = $objDatabase->Execute('
            SELECT COUNT(`id`) AS user_count FROM `'.DBPREFIX.'access_users` WHERE `active` = 1');
        if ($objResult !== false) {
            return $objResult->fields['user_count'];
        }

        return 0;
    }


    /**
     * Returns the HTML dropdown menu string for the User account
     * validity period.
     * @param   integer   $selectedValidity   The selected validity period
     *                                        in days.  Defaults to 0 (zero).
     * @param   string    $attrs              Additional attributes for the
     *                                        menu, to be included in the
     *                                        <SELECT> tag.
     * @return  string                        The HTML dropdown menu code
     */
    public static function getValidityMenuOptions($selectedValidity=0, $attrs='')
    {
        $strOptions = '';
        foreach (User_Setting::getUserValidities() as $validity) {
            $strValidity = FWUser::getValidityString($validity);
            $strOptions .=
                // Use original value in days as option value.
                '<option value="'.$validity.'"'.
                ($selectedValidity == $validity ? ' selected="selected"' : '').
                (empty($attrs) ? '' : ' '.$attrs).
                '>'.$strValidity.'</option>';
        }
        return $strOptions;
    }


    /**
     * Returns a pretty textual representation of the validity period
     * specified by the $validity argument.
     * @param   integer   $validity     Validity period in days
     * @return  string                  The textual representation
     */
    public static function getValidityString($validity)
    {
        global $_CORELANG;

        $unit = 'DAY';
        if ($validity == 0) {
            $validity = '';
            $unit = $_CORELANG['TXT_CORE_UNLIMITED'];
        } else {
            if ($validity >= 30) {
                $unit = 'MONTH';
                $validity = intval($validity/30);
                if ($validity >= 12) {
                    $unit = 'YEAR';
                    $validity = intval($validity/12);
                }
            }
            $unit =
                $_CORELANG['TXT_CORE_'.$unit.
                ($validity > 1 ? 'S' : '')];
        }
        return "$validity $unit";
    }


    /**
     * Returns a SECID for logging in (Backend, Frontend editing)
     * This is an uppercase four-letter string with no ambiguous
     * characters (like 0/O, l/I etc.).
     */
    public static function mkSECID() {
        $chars = 'ACDEFGHJKLMNPRTUWXZ345679';
        $max   = strlen($chars) -1;
        $ret = '';
        for ($i = 0; $i < 4; ++$i) {
            $ret .= $chars{rand(0, $max)};
        }
        return $ret;
    }


    /**
     * Activates the user live search.
     * @param   array   $arrOptions
     * @return  void
     * @link    http://contrexx.com/wiki/index.php/User_Live_Search
     */
    public static function getUserLiveSearch($arrOptions = array())
    {
        global $_CORELANG;

        // Options for the dialog
        $arrOptions['minLength'] = empty($arrOptions['minLength']) ? 3 : intval($arrOptions['minLength']);
        $arrOptions['canCancel'] = empty($arrOptions['canCancel']) ? 0 : 1;
        $arrOptions['canClear']  = empty($arrOptions['canClear'])  ? 0 : 1;
        
        $txtUserSearchInfo = sprintf($_CORELANG['TXT_CORE_SEARCH_USER_INFO'], $arrOptions['minLength']);
        
        $scope = 'user/live-search';
        $objCx = \ContrexxJavascript::getInstance();
        
        $objCx->setVariable('userMinLength',     $arrOptions['minLength'],           $scope);
        $objCx->setVariable('userCanCancel',     $arrOptions['canCancel'],           $scope);
        $objCx->setVariable('userCanClear',      $arrOptions['canClear'],            $scope);
        $objCx->setVariable('txtUserSearch',     $_CORELANG['TXT_CORE_SEARCH_USER'], $scope);
        $objCx->setVariable('txtUserCancel',     $_CORELANG['TXT_CANCEL'],           $scope);
        $objCx->setVariable('txtUserSearchInfo', $txtUserSearchInfo,                 $scope);
        
        \JS::activate('user-live-search');
    }

}
