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
 * Login
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author        Comvation Development Team <info@comvation.com>
 * @version       1.0.0
 * @package     contrexx
 * @subpackage  coremodule_login
 * @todo        Edit PHP DocBlocks!
 */

/**
 * Login
 *
 * Class to login into the system
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author        Comvation Development Team <info@comvation.com>
 * @version       1.0.0
 * @package     contrexx
 * @subpackage  coremodule_login
 */
class Login
{
    var $_statusMessage;
    var $_objTpl;


    /**
    * constructor
    */
    function Login($pageContent)
    {
       $this->__construct($pageContent);
    }

    /**
    * constructor
    */
    function __construct($pageContent)
    {
        $this->_objTpl = new \Cx\Core\Html\Sigma('.');
        CSRF::add_placeholder($this->_objTpl);
        $this->_objTpl->setErrorHandling(PEAR_ERROR_DIE);
        $this->_objTpl->setTemplate($pageContent);
    }

    /**
    * Get content
    *
    * Get the login pages
    *
    * @access	public
    * @see _lostPassword(), _resetPassword(), _noaccess(), _login()
    * @return	mixed	Template content
    */
    function getContent()
    {
        if (!isset($_GET['cmd'])) {
            $_GET['cmd'] = "";
        }

        switch ($_GET['cmd']) {
        case 'lostpw':
            return $this->_lostPassword();
            break;

        case 'resetpw':
            return $this->_resetPassword();
            break;

        case 'noaccess':
            return $this->_noaccess();
            break;

        default:
            return $this->_login();
            break;
        }
    }

    /**
    * Calls the method restorePassword of the class FWUser
    * and displays the lostpw page of the login module
    *
    * @global array
    * @see FWUser::restorePassword()
    * @return string \Cx\Core\Html\Sigma::get()
    */
    function _lostPassword()
    {
        global $_CORELANG;

        // set language variables
        $this->_objTpl->setVariable(array(
            'TXT_LOST_PASSWORD_TEXT'    => $_CORELANG['TXT_LOST_PASSWORD_TEXT'],
            'TXT_EMAIL'					=> $_CORELANG['TXT_EMAIL'],
            'TXT_RESET_PASSWORD'        => $_CORELANG['TXT_RESET_PASSWORD']
        ));

        if (isset($_POST['email'])) {
            $objFWUser = FWUser::getFWUserObject();
            $email = contrexx_stripslashes($_POST['email']);

            if (($objFWUser->restorePassword($email))) {
                $statusMessage = str_replace("%EMAIL%", $email, $_CORELANG['TXT_LOST_PASSWORD_MAIL_SENT']);
                if ($this->_objTpl->blockExists('login_lost_password')) {
                    $this->_objTpl->hideBlock('login_lost_password');
                }
            } else {
                $statusMessage = $objFWUser->getErrorMsg();
            }

            $this->_objTpl->setVariable(array(
                'LOGIN_STATUS_MESSAGE'        => $statusMessage
            ));
        }

        return $this->_objTpl->get();
    }

    /**
    * Calls the method resetPassword of the class FWUser
    * and displays the resetpw page of the login module
    *
    * @access private
    * @see FWUser::resetPassword()
    * @return string \Cx\Core\Html\Sigma::get()
    */
    function _resetPassword()
    {
        global $_CORELANG;

        $objFWUser = FWUser::getFWUserObject();
        $email = isset($_POST['email']) ? contrexx_stripslashes($_POST['email']) : (isset($_GET['email']) ? contrexx_stripslashes($_GET['email']) : '');
        $restoreKey = isset($_POST['restore_key']) ? contrexx_stripslashes($_POST['restore_key']) : (isset($_GET['restoreKey']) ? contrexx_stripslashes($_GET['restoreKey']) : '');
        $password = isset($_POST['password']) ? trim(contrexx_stripslashes($_POST['password'])) : '';
        $confirmedPassword = isset($_POST['password2']) ? trim(contrexx_stripslashes($_POST['password2'])) : '';
        $statusMessage = '';

        if (isset($_POST['reset_password'])) {
            if ($objFWUser->resetPassword($email, $restoreKey, $password, $confirmedPassword, true)) {
                $statusMessage = $_CORELANG['TXT_PASSWORD_CHANGED_SUCCESSFULLY'];
                if ($this->_objTpl->blockExists('login_reset_password')) {
                    $this->_objTpl->hideBlock('login_reset_password');
                }
            } else {
                $statusMessage = $objFWUser->getErrorMsg();

                $this->_objTpl->setVariable(array(
                    'TXT_EMAIL'						    => $_CORELANG['TXT_EMAIL'],
                    'TXT_PASSWORD'						=> $_CORELANG['TXT_PASSWORD'],
                    'TXT_VERIFY_PASSWORD'				=> $_CORELANG['TXT_VERIFY_PASSWORD'],
                    'TXT_PASSWORD_MINIMAL_CHARACTERS'	=> $_CORELANG['TXT_PASSWORD_MINIMAL_CHARACTERS'],
                    'TXT_SET_PASSWORD_TEXT'				=> $_CORELANG['TXT_SET_PASSWORD_TEXT'],
                    'TXT_SET_NEW_PASSWORD'				=> $_CORELANG['TXT_SET_NEW_PASSWORD'],
                ));

                $this->_objTpl->parse('login_reset_password');
            }
        } elseif (!$objFWUser->resetPassword($email, $restoreKey, $password, $confirmedPassword)) {
            $statusMessage = $objFWUser->getErrorMsg();
            if ($this->_objTpl->blockExists('login_reset_password')) {
                $this->_objTpl->hideBlock('login_reset_password');
            }
        } else {
            $this->_objTpl->setVariable(array(
                'TXT_EMAIL'						    => $_CORELANG['TXT_EMAIL'],
                'TXT_PASSWORD'						=> $_CORELANG['TXT_PASSWORD'],
                'TXT_VERIFY_PASSWORD'				=> $_CORELANG['TXT_VERIFY_PASSWORD'],
                'TXT_PASSWORD_MINIMAL_CHARACTERS'	=> $_CORELANG['TXT_PASSWORD_MINIMAL_CHARACTERS'],
                'TXT_SET_PASSWORD_TEXT'				=> $_CORELANG['TXT_SET_PASSWORD_TEXT'],
                'TXT_SET_NEW_PASSWORD'				=> $_CORELANG['TXT_SET_NEW_PASSWORD'],
            ));

            $this->_objTpl->parse('login_reset_password');
        }

        $this->_objTpl->setVariable(array(
            'LOGIN_STATUS_MESSAGE'	=> $statusMessage,
            'LOGIN_USERNAME'		=> htmlentities($email, ENT_QUOTES, CONTREXX_CHARSET),
            'LOGIN_RESTORE_KEY'		=> htmlentities($restoreKey, ENT_QUOTES, CONTREXX_CHARSET)
        ));

        return $this->_objTpl->get();
    }

    /**
    * Displays the noaccess page of the login module
    *
    * @global array
    * @return string \Cx\Core\Html\Sigma::get()
    */
    function _noaccess()
    {
        global $_CORELANG;

        if (isset($_REQUEST['redirect'])) {
            $redirect = contrexx_strip_tags($_REQUEST['redirect']);
        } else {
            $redirect = '';
        }

        $this->_objTpl->setVariable('TXT_NOT_ALLOWED_TO_ACCESS', $_CORELANG['TXT_NOT_ALLOWED_TO_ACCESS']);
        $this->_objTpl->setVariable('LOGIN_REDIRECT', $redirect);
        return $this->_objTpl->get();
    }

    /**
    * Checks if the user has been successfully authenticated
    *
    * If a user has been successfully authenticated then he will be
    * redirected to the requested page, otherwise the login page will be displayed
    *
    * @access private
    * @global array
    * @see cmsSession::cmsSessionStatusUpdate(), contrexx_strip_tags, \Cx\Core\Html\Sigma::get()
    * @return string \Cx\Core\Html\Sigma::get()
    */
    function _login()
    {
        global $_CORELANG, $sessionObj;

        $objFWUser = FWUser::getFWUserObject();

        if (isset($_REQUEST['redirect'])) {
            $redirect = contrexx_strip_tags($_REQUEST['redirect']);
        } elseif (isset($_SESSION['redirect'])) {
            $redirect = $_SESSION['redirect'];
        } else {
            $redirect = "";
        }

        \Cx\Lib\SocialLogin::parseSociallogin($this->_objTpl);
        $arrSettings = User_Setting::getSettings();
        if (function_exists('curl_init') && $arrSettings['sociallogin']['status'] && !empty($_GET['provider'])) {
            $providerLogin = $this->loginWithProvider($_GET['provider']);
            if ($providerLogin) {
                return $providerLogin;
            }
        }
        if (isset($_POST['login']) && $objFWUser->objUser->login()) {
            if ($objFWUser->checkLogin()) {
                $objFWUser->objUser->reset();
                $objFWUser->logoutAndDestroySession();
                $sessionObj = \cmsSession::getInstance();
            } else {
                $_GET['relogin'] = 'true';
            }
        }
        if ((!isset($_GET['relogin']) || $_GET['relogin'] != 'true') && $objFWUser->objUser->login() || $objFWUser->checkAuth()) {
            $groupRedirect = ($objGroup = $objFWUser->objGroup->getGroup($objFWUser->objUser->getPrimaryGroupId())) && $objGroup->getHomepage() ? preg_replace('/\\[\\[([A-Z0-9_-]+)\\]\\]/', '{\\1}', $objGroup->getHomepage()) : CONTREXX_SCRIPT_PATH;
            LinkGenerator::parseTemplate($groupRedirect);
            if (isset($_SESSION['redirect'])) {
                unset($_SESSION['redirect']);
            }
            if (!empty($redirect)) {
                $redirect = \FWUser::getRedirectUrl(urlencode(base64_decode($redirect)));
            }
            CSRF::header('Location: '.(empty($redirect) ? $groupRedirect : $redirect));
            exit;
        } else {
            if (isset($_POST['login'])) {
                $this->_statusMessage = $_CORELANG['TXT_PASSWORD_OR_USERNAME_IS_INCORRECT'];
            }
        }
        if (isset($_SESSION['auth']['loginLastAuthFailed'])) {
            $this->_objTpl->setVariable(array(
                'TXT_CORE_CAPTCHA'  => $_CORELANG['TXT_CORE_CAPTCHA'],
                'CAPTCHA_CODE'      => FWCaptcha::getInstance()->getCode(),
            ));
            $this->_objTpl->parse('captcha');
        } else {
            $this->_objTpl->hideBlock('captcha');
        }

        $this->_objTpl->setVariable(array(
            'TXT_LOGIN'             => $_CORELANG['TXT_LOGIN'],
            'TXT_USER_NAME'         => $_CORELANG['TXT_USER_NAME'],
            'TXT_PASSWORD'          => $_CORELANG['TXT_PASSWORD'],
            'TXT_LOGIN_REMEMBER_ME' => $_CORELANG['TXT_CORE_REMEMBER_ME'],
            'TXT_PASSWORD_LOST'     => $_CORELANG['TXT_PASSWORD_LOST'],
            'LOGIN_REDIRECT'        => $redirect,
            'LOGIN_STATUS_MESSAGE'  => $this->_statusMessage,
        ));
        return $this->_objTpl->get();
    }

    /**
     * Login with an oauth authentication method.
     *
     * @param string $provider The chosen oauth provider
     * @return string|string \Cx\Core\Html\Sigma
     * @access private
     */
    private function loginWithProvider($provider) {
        global $objInit, $_ARRAYLANG;

        $SocialLogin = new \Cx\Lib\SocialLogin();
        try {
            $login = $SocialLogin->loginWithProvider($provider);
        } catch (\Cx\Lib\OAuth\OAuth_Exception $e) {
            $_ARRAYLANG = array_merge($_ARRAYLANG, $objInit->loadLanguageData('access'));
            $this->_statusMessage = $_ARRAYLANG['TXT_ACCESS_EMAIL_ALREADY_USED_SOCIALLOGIN'];
        }
        if (is_null($login)) {
            return null;
        }

        return $this->_objTpl->get();
    }
}
