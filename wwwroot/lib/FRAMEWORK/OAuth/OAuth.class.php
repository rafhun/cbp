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
 * OAuth
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  lib_oauth
 */

namespace Cx\Lib\OAuth;

/**
 * OAuth_Exception
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  lib_oauth
 */
class OAuth_Exception extends \Exception {}

/**
 * OAuth superclass
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Ueli Kramer <ueli.kramer@comvation.com>
 * @version     1.0.0
 * @package     contrexx
 * @subpackage  lib_oauth
 */
abstract class OAuth implements OAuthInterface
{
    /**
     * @var array the necessary data to connect to the social media platform
     */
    protected $applicationData = array();

    /**
     * @var boolean active or not
     */
    protected $active;

    /**
     * Sets the application id and secret key for login usage of social media platform
     * For google there is also an api key
     *
     * @param array the application configuration data
     */
    public function setApplicationData($applicationData)
    {
        $this->applicationData = $applicationData;
    }

    /**
     * Get the application data of the objecty
     *
     * @return array the application configuration data
     */
    public function getApplicationData()
    {
        return $this->applicationData;
    }

    /**
     * @param boolean $active is the provider active or not
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    public function isActive()
    {
        return $this->active;
    }

    /**
     * Searchs for an user with the given user id of the social media platform.
     * If there is no user, create one and directly log in.
     *
     * @param string $oauth_id the user id of the social media platform
     * @return bool
     * @throws OAuth_Exception
     */
    protected function getContrexxUser($oauth_id)
    {
        global $sessionObj;
        
        //\DBG::activate();
        $arrSettings = \User_Setting::getSettings();

        $provider = $this::OAUTH_PROVIDER;
        $FWUser = \FWUser::getFWUserObject();
        $objUser = $FWUser->objUser->getByNetwork($provider, $oauth_id);
        if (!$objUser) {
            // check whether the user is already logged in
            // if the user is logged in just add a new network to the user object
            if ($FWUser->objUser->login()) {
                $objUser = $FWUser->objUser;
                $this->addProviderToUserObject($provider, $oauth_id, $objUser);
                $objUser->getNetworks()->save();
                return true;
            }

            // create a new user with the default profile attributes
            $objUser = new \User();
            $objUser->setEmail($this->getEmail());
            $objUser->setAdminStatus(0);
            $objUser->setProfile(
                array(
                    'firstname' => array($this->getFirstname()),
                    'lastname' => array($this->getLastname()),
                )
            );

            $registrationRedirectNeeded = (!$objUser->checkMandatoryCompliance() || $arrSettings['sociallogin_show_signup']['status']);
            $objUser->setActiveStatus(!$registrationRedirectNeeded);

            if ($registrationRedirectNeeded) {
                $objUser->setRestoreKey();
                $objUser->setRestoreKeyTime(intval($arrSettings['sociallogin_activation_timeout']['value']) * 60);
            }

            if (!empty($arrSettings['sociallogin_assign_to_groups']['value'])) {
                $groups = $arrSettings['sociallogin_assign_to_groups']['value'];
            } else {
                $groups = $arrSettings['assigne_to_groups']['value'];
            }

            $objUser->setGroups(explode(',', $groups));
            // if we can create the user without sign up page
            if (!$objUser->store()) {
                // if the email address already exists but not with the given oauth-provider
                throw new OAuth_Exception;
            }

            // add the social network to user
            $this->addProviderToUserObject($provider, $oauth_id, $objUser);
            $objUser->getNetworks()->save();

            // check whether there are empty mandatory fields or the setting to show sign up everytime
            if ($registrationRedirectNeeded) {
                // start session if no session is open
                if (!isset($sessionObj) || !is_object($sessionObj)) $sessionObj = \cmsSession::getInstance();

                // write the user id to session so we can pre-fill the sign up form
                $_SESSION['user_id'] = $objUser->getId();

                // generate url for sign up page and redirect
                $signUpPageUri = \Cx\Core\Routing\Url::fromModuleAndCmd('access', 'signup');
                \CSRF::header('Location: ' . $signUpPageUri->__toString());
                exit;
            }
        }
        $FWUser->loginUser($objUser);
    }

    /**
     * @param string $oauth_provider the network provider
     * @param string $oauth_id the id of user in network
     * @param mixed $objUser the user object
     */
    private function addProviderToUserObject($oauth_provider, $oauth_id, &$objUser)
    {
        // add the new network to the user's account
        $objUser->loadNetworks();
        $objUser->setNetwork($oauth_provider, $oauth_id);
    }

    /**
     * @static
     * @return array the configuration parameters as language array key
     */
    public static function configParams()
    {
        return $configParams = array(
            'TXT_ACCESS_SOCIALLOGIN_PROVIDER_APP_ID',
            'TXT_ACCESS_SOCIALLOGIN_PROVIDER_SECRET',
        );
    }

    public function getEmail()
    {
        /** @var $userdata array */
        return $this::$userdata['email'];
    }

    public function getFirstname()
    {
        /** @var $userdata array */
        return $this::$userdata['first_name'];
    }

    public function getLastname()
    {
        /** @var $userdata array */
        return $this::$userdata['last_name'];
    }
}
