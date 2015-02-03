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
 * User Object
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Thomas Daeppen <thomas.daeppen@comvation.com>
 * @version     2.1.1
 * @package     contrexx
 * @subpackage  lib_framework
 */

/**
 * UserException
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  lib_framework
 */
class UserException extends Exception {}


/**
 * User Object
 *
 * The User object is used for all user related operations.
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Thomas Daeppen <thomas.daeppen@comvation.com>
 * @version     2.0.0
 * @package     contrexx
 * @subpackage  lib_framework
 */
class User extends User_Profile
{
    /**
     * ID of loaded user
     * @var integer
     * @access private
     */
    protected $id;

    /**
     * Username of user
     * @var string
     * @access private
     */
    private $username;

    /**
     * E-Mail address of user
     * @var string
     * @access private
     */
    private $email;

    /**
     * Password of user
     * @var     string
     * @access  protected
     */
    protected $password;

    /**
     * Language ID of user
     * @var integer
     * @access private
     */
    private $lang_id;

    /**
     * Language ID used for the frontend
     * @var integer
     * @access private
     */
    private $frontend_language;

    /**
     * Language ID used for the backend
     * @var integer
     * @access private
     */
    private $backend_language;

    /**
     * Active status of user
     * @var boolean
     * @access private
     */
    private $is_active;

    /**
     * The ID of a user group that should be used as the primary one
     *
     * @var integer
     * @access private
     */
    private $primary_group;

    /**
     * Administrator status
     * @var boolean
     * @access private
     */
    private $is_admin;

    /**
     * Determines who is allowed to see the user's e-mail address
     * @var boolean
     * @access private
     */
    private $email_access;

    /**
     * Determines who is allowed to see the user's profile data.
     * @var string
     * @access private
     */
    private $profile_access;

    /**
     * Registration date of user (timestamp)
     * @var integer
     * @access private
     */
    private $regdate;

    /**
     * Expiration date of the account (timestamp)
     * @var integer
     * @access private
     */
    private $expiration;

    /**
     * Validity time period
     *
     * This integer represents the expiration of the user. A user won't be able to authenticate again after his validity time period has exceeded.
     * A validity time period of zero mean that the account has no expiration date.
     * @var integer
     * @access private
     */
    private $validity;

    /**
     * Key which will be used to reset the password
     * @var string
     * @access private
     */
    private $restore_key;

    /**
     * Date as timestamp when a new password was requested
     * @var integer
     * @access private
     */
    private $restore_key_time;

    /**
     * The networks the user is connected with
     * @var object
     * @access private
     */
    private $networks;

    /**
     * The last time the user had logged in (timestamp)
     * @var integer
     * @access private
     */
    private $last_auth;

    /**
     * The last time that the user was active (timestamp)
     * @var integer
     * @access private
     */
    private $last_activity;

    /**
     * Contains the number of currently loaded users
     * @var integer
     * @access private
     */
    private $filtered_search_count = 0;

    /**
     * Contains an array of all group IDS which the user is associated to
     * @var array
     * @access private
     */
    private $arrGroups;

    /**
     * Contains an array of all newsletter-list-IDs of which the user has a subscription of
     *
     * @var array
     * @access protected
     */
    private $arrNewsletterListIDs = array();

    /**
     * @access public
     */
    public $EOF;

    /**
     * Array which holds all loaded users for later usage
     * @var array
     * @access protected
     */
    protected $arrLoadedUsers = array();

    /**
     * Array that holds all users which were ever loaded
     * @var array
     * @access protected
     */
    protected  $arrCachedUsers = array();

    /**
     * @access private
     */
    private $arrAttributes = array(
        'id'                => 'int',
        'is_admin'          => 'int',
        'username'          => 'string',
        'regdate'           => 'int',
        'expiration'        => 'int',
        'validity'          => 'int',
        'last_auth'         => 'int',
        'last_activity'     => 'int',
        'primary_group'     => 'int',
        'email'             => 'string',
        'email_access'      => 'string',
        'frontend_lang_id'  => 'int',
        'backend_lang_id'   => 'int',
        'active'            => 'int',
        'profile_access'    => 'string',
        'restore_key'       => 'string',
        'restore_key_time'  => 'int',
    );

    /**
     * @access private
     */
    private $arrPrivacyAccessTypes = array(
        'everyone'      => array(
            'email'         => 'TXT_ACCESS_EVERYONE_ALLOWED_SEEING_EMAIL',
            'profile'       => 'TXT_ACCESS_EVERYONE_ALLOWED_SEEING_PROFILE',
        ),
        'members_only'  => array(
            'email'         => 'TXT_ACCESS_MEMBERS_ONLY_ALLOWED_SEEING_EMAIL',
            'profile'       => 'TXT_ACCESS_MEMBERS_ONLY_ALLOWED_SEEING_PROFILE',
        ),
        'nobody'        => array(
            'email'         => 'TXT_ACCESS_NOBODY_ALLOWED_SEEING_EMAIL',
            'profile'       => 'TXT_ACCESS_NOBODY_ALLOWED_SEEING_PROFILE',
        ),
    );

    /**
     * @access private
     */
    private $defaultProfileAccessTyp;

    /**
     * @access private
     */
    private $defaultEmailAccessType;

    /**
     * Contains the message if an error occurs
     * @var string
     */
    public $error_msg = array();


    /**
     * TRUE if user is authenticated
     *
     * If this is TRUE the methods {@link load()} and {@link loadUsers()}
     * will be looked for further usage.
     * @todo    Explain this method in plain english...
     * @var     boolean
     * @access  private
     */
    private $loggedIn;


    public function __construct()
    {
        parent::__construct();
        $arrSettings = FWUser::getSettings();
// TODO:  Provide default values here in case the settings are missing!
        $this->defaultProfileAccessTyp = $arrSettings['default_profile_access']['value'];
        $this->defaultEmailAccessType = $arrSettings['default_email_access']['value'];
        $this->clean();
    }


    /**
     * Authenticate user against username and password
     *
     * Verifies the password of a username within the database.
     * If the password matches the appropriate users gets loaded
     * and the users last authentication time gets updated.
     * Returns TRUE on success or FALSE on failure.
     * @param   string    $username   The username
     * @param   string    $password   The MD5 hash of the password
     * @param   boolean   $backend    Tries to authenticate for the backend
     *                                if true, false otherwise
     * @return  boolean               True on success, false otherwise
     */
    public function auth($username, $password, $backend = false, $captchaCheckResult = false)
    {
        $userId = $this->checkLoginData($username, $password, $captchaCheckResult);

        if (!$userId || !$this->load($userId) || !$this->hasModeAccess($backend) || !$this->updateLastAuthTime()) {
            return false;
        }

        return true;
    }


    /**
     * Checks username, password and captcha.
     *
     * @param  string  $username
     * @param  string  $password
     * @param  bool    $captchaCheckResult
     *
     * @return  mixed  false or user id
     */
    public function checkLoginData($username, $password, $captchaCheckResult = false)
    {
        global $objDatabase;

        $loginByEmail = false;

        $arrSettings = User_Setting::getSettings();
        if (FWValidator::isEmail($username) || !$arrSettings['use_usernames']['status']) {
            $loginByEmail = true;
        }

        if ($loginByEmail) {
            $loginCheck = '`email` = "' . addslashes($username) . '"';
        } else {
            $loginCheck = '`username` = "' . addslashes($username) . '"';
        }

        $loginStatusCondition = $captchaCheckResult == false ? 'AND `last_auth_status` = 1' : '';

        $objResult = $objDatabase->SelectLimit('
            SELECT `id`
              FROM `' . DBPREFIX . 'access_users`
             WHERE ' . $loginCheck . '
               AND `password` = "'.addslashes($password).'"
               AND `active` = 1
               ' . $loginStatusCondition . '
               AND (`expiration` = 0 OR `expiration` > ' . time() . ')
        ', 1);

        if (!$objResult || $objResult->RecordCount() != 1) {
            return false;
        }

        return $objResult->fields['id'];
    }


    /**
     * Returns TRUE if the given password matches the current user,
     * FALSE otherwise.
     * @param string $password
     * @return boolean
     */
    public function checkPassword($password)
    {
        global $objDatabase;

        $query = '
            SELECT 1
              FROM `'.DBPREFIX.'access_users`
             WHERE `id` = '.$this->id.'
               AND `password` = "'.md5($password).'"
        ';
        $objResult = $objDatabase->Execute($query);

        return $objResult->RecordCount() ? true : false;
    }


    /**
     * Clean user metadata
     *
     * Reset all user metadata for a new user.
     * The metadata includes the ID of the user, the username, e-mail address,
     * password, language ID, active and administration status, registration date,
     * restore key and restore key timeout and the ID's of the associated groups.
     */
    private function clean()
    {
        global $_LANGID;

        $this->id = 0;
        $this->username = '';
        $this->email = '';
        $this->email_access = $this->defaultEmailAccessType;
        $this->password = '';
        $this->frontend_language = $_LANGID;
        $this->backend_language = $_LANGID;
        $this->is_active = false;
        $this->primary_group = 0;
        $this->is_admin = false;
        $this->profile_access = $this->defaultProfileAccessTyp;
        $this->regdate = 0;
        $this->expiration = 0;
        $this->validity = 0;
        $this->last_auth = 0;
        $this->last_activity = 0;
        $this->restore_key = '';
        $this->restore_key_time = 0;
        $this->arrGroups = null;
        $this->arrNewsletterListIDs = null;
        $this->EOF = true;
        $this->loggedIn = false;
        $this->networks = null;
    }


    /**
     * Delete the current loaded user account
     *
     * In the case that the current loaded user is the last available administrator
     * in the system, then the request will be refused and FALSE will be returned instead.
     * A user isn't able to delete its own account with which he is actually authenticated
     * at the moment unless the parameter $deleteOwnAccount is set to TRUE.
     * Returns TRUE on success or FALSE on failure.
     * @param   boolean       $deleteOwnAccount
     * @see     isLastAdmin()
     * @return boolean
     */
    public function delete($deleteOwnAccount = false)
    {
        global $objDatabase, $_CORELANG;

        $objFWUser = FWUser::getFWUserObject();
        if ($deleteOwnAccount || $this->id != $objFWUser->objUser->getId()) {
            if (!$this->isLastAdmin()) {
                if ($objDatabase->Execute(
                'DELETE tblU, tblP, tblG, tblA, tblN
                FROM `'.DBPREFIX.'access_users` AS tblU
                INNER JOIN `'.DBPREFIX.'access_user_profile` AS tblP ON tblP.`user_id` = tblU.`id`
                LEFT JOIN `'.DBPREFIX.'access_rel_user_group` AS tblG ON tblG.`user_id` = tblU.`id`
                LEFT JOIN `'.DBPREFIX.'access_user_attribute_value` AS tblA ON tblA.`user_id` = tblU.`id`
                LEFT JOIN `'.DBPREFIX.'access_user_network` AS tblN ON tblN.`user_id` = tblU.`id`
                WHERE tblU.`id` = '.$this->id) !== false
            ) {
                    return true;
                } else {
                    $this->error_msg[] = sprintf($_CORELANG['TXT_ACCESS_USER_DELETE_FAILED'], $this->username);
                }
            } else {
                $this->error_msg[] = sprintf($_CORELANG['TXT_ACCESS_LAST_ADMIN_USER'], $this->username);
            }
        } else {
            $this->error_msg[] = $_CORELANG['TXT_ACCESS_UNABLE_DELETE_YOUR_USER'];
        }

        return false;
    }


    public function finishSignUp()
    {
        $this->restore_key = '';
        $this->restore_key_time = 0;
        $this->setActiveStatus(true);
        return $this->store();
    }


    /**
     * Load first user
     */
    public function first()
    {
        $this->EOF =
               reset($this->arrLoadedUsers) === false
            || !$this->load(key($this->arrLoadedUsers));
    }


    public static function forceDefaultEmailAccess()
    {
        global $objDatabase;

        $arrSettings = FWUser::getSettings();
        return $objDatabase->Execute("
            UPDATE `".DBPREFIX."access_users`
               SET `email_access`='".$arrSettings['default_email_access']['value']."'");
    }


    public static function forceDefaultProfileAccess()
    {
        global $objDatabase;

        $arrSettings = FWUser::getSettings();
        return $objDatabase->Execute("
            UPDATE `".DBPREFIX."access_users`
               SET `profile_access`='".$arrSettings['default_profile_access']['value']."'");
    }


    public function getActiveStatus()
    {
        return $this->is_active;
    }


    public function getPrimaryGroupId()
    {
        if (empty($this->primary_group)) {
            $FWUser = FWUser::getFWUserObject();
            $this->arrGroups = $this->loadGroups(!$FWUser->isBackendMode());
            return count($this->arrGroups) ? $this->arrGroups[0] : 0;
        }
        return $this->primary_group;
    }


    public function getPrimaryGroupName()
    {
        $objFWUser = FWUser::getFWUserObject();
        if (empty($this->primary_group)) {
            $this->arrGroups = $this->loadGroups(!$objFWUser->isBackendMode());
            $groupId = isset($this->arrGroups[0]) ? $this->arrGroups[0] : 0;
        } else {
            $groupId = $this->primary_group;
        }

        $objGroup = $objFWUser->objGroup->getGroup($groupId);
        return htmlentities($objGroup->getName(), ENT_QUOTES, CONTREXX_CHARSET);
    }


    public function getAdminStatus()
    {
        return $this->is_admin;
    }


    public function getAssociatedGroupIds()
    {
        if (!isset($this->arrGroups)) {
            $this->arrGroups = $this->loadGroups();
        }
        return $this->arrGroups;
    }


    /**
     * Returns an array of all newsletter-list-IDs the user did subscribe to
     * @return      array   Newsletter-list-IDs
     */
    public function getSubscribedNewsletterListIDs()
    {
        if (!isset($this->arrNewsletterListIDs)) {
            $this->loadSubscribedNewsletterListIDs();
        }
        return $this->arrNewsletterListIDs;
    }


    public function getBackendLanguage()
    {
        return $this->backend_language;
    }


    public function getDynamicPermissionIds($reload=false)
    {
        if (!isset($this->arrCachedUsers[$this->id]['dynamic_access_ids']) || $reload) {
            $this->loadPermissionIds('dynamic');
        }
        return $this->arrCachedUsers[$this->id]['dynamic_access_ids'];
    }


    public function getEmail()
    {
        // START: WORKAROUND FOR ACCOUNTS SOLD IN THE SHOP
        $email = $this->getShopUserEmail();
        return (empty($email) ? $this->email : $email);
        // END: WORKAROUND FOR ACCOUNTS SOLD IN THE SHOP
    }


    public function getEmailAccess()
    {
        return $this->email_access;
    }


    public function getErrorMsg()
    {
        return $this->error_msg;
    }


    public function getExpirationDate()
    {
        return $this->expiration;
    }


    public function getFilteredSearchUserCount()
    {
        return $this->filtered_search_count;
    }


    private function getFilteredUserIdList($arrFilter = null, $search = null)
    {
        $arrConditions = array();
        $arrSearchConditions = array();
        $tblCoreAttributes = false;
        $tblCustomAttributes = false;
        $tblGroup = false;
        $groupTables = false;

        // parse filter
        if (isset($arrFilter) && is_array($arrFilter)) {
            if (count($arrAccountConditions = $this->parseAccountFilterConditions($arrFilter))) {
                $arrConditions[] = implode(' AND ', $arrAccountConditions);
            }
            if (count($arrCoreAttributeConditions = $this->parseCoreAttributeFilterConditions($arrFilter))) {
                $arrConditions[] = implode(' AND ', $arrCoreAttributeConditions);
                $tblCoreAttributes = true;
            }
            if (count($arrCustomAttributeConditions = $this->parseCustomAttributeFilterConditions($arrFilter))) {
                $groupTables = true;
                $arrConditions[] = implode(' AND ', $arrCustomAttributeConditions);
                $tblCustomAttributes = true;
            }

            if (in_array('group_id', array_keys($arrFilter)) && !empty($arrFilter['group_id'])) {
                $arrGroupConditions = array();
                if ($arrFilter['group_id'] == 'groupless') {
                    $arrGroupConditions[] = 'tblG.`group_id` IS NULL';
                } else if (is_array($arrFilter['group_id'])) {
                    foreach ($arrFilter['group_id'] as $groupId) {
                        $arrGroupConditions[] = 'tblG.`group_id` = '.intval($groupId);
                    }
                    $groupTables = true;
                } else {
                    $arrGroupConditions[] = 'tblG.`group_id` = '.intval($arrFilter['group_id']);
                }
                $arrConditions[] = '('.implode(' OR ', $arrGroupConditions).')';

                if (!FWUser::getFWUserObject()->isBackendMode()) {
                    $arrConditions[] = "tblGF.`is_active` = 1 AND tblGF.`type` = 'frontend'";
                }

                $tblGroup = true;
            }
        }

        // parse search
        if (!empty($search)) {
            if (count($arrAccountConditions = $this->parseAccountSearchConditions($search))) {
                $arrSearchConditions[] = implode(' OR ', $arrAccountConditions);
            }
            if (count($arrCoreAttributeConditions = $this->parseAttributeSearchConditions($search, true))) {
                $arrSearchConditions[] = implode(' OR ', $arrCoreAttributeConditions);
                $tblCoreAttributes = true;
            }
            if (count($arrCustomAttributeConditions = $this->parseAttributeSearchConditions($search, false))) {
                $groupTables = true;
                $arrSearchConditions[] = implode(' OR ', $arrCustomAttributeConditions);
                $tblCustomAttributes = true;
            }
            if (count($arrSearchConditions)) {
                $arrConditions[] = implode(' OR ', $arrSearchConditions);
            }
        }

        $arrTables = array();
        if (!empty($tblCoreAttributes)) {
            $arrTables[] = 'core';
        }
        if (!empty($tblCustomAttributes)) {
            $arrTables[] = 'custom';
        }
        if ($tblGroup) {
            $arrTables[] = 'group';
        }

        return array(
            'tables'        => $arrTables,
            'conditions'    => $arrConditions,
            'group_tables'  => $groupTables
        );
    }


    public function getFrontendLanguage()
    {
        if (!$this->frontend_language) {
            global $_LANGID;
            $this->frontend_language = $_LANGID;
        }
        return $this->frontend_language;
    }


    public function getId()
    {
        return $this->id;
    }


    public function getLastActivityTime()
    {
        return $this->last_activity;
    }


    public function getLastAuthenticationTime()
    {
        return $this->last_auth;
    }


    public function getPrivacyAccessMenu($attrs, $option)
    {
        global $_ARRAYLANG;

        $menu = '<select'.(!empty($attrs) ? ' '.$attrs : '').'>';
        foreach ($this->arrPrivacyAccessTypes as $type => $arrDesc) {
            $menu .= "<option value='".$type."'".($type == $this->{$option.'_access'} ? ' selected="selected"' : '').">".$_ARRAYLANG[$arrDesc[$option]]."</option>";
        }
        $menu .= '</select>';
        return $menu;
    }


    public function getProfileAccess()
    {
        return $this->profile_access;
    }


    public function getProfileAttribute($attributeId, $historyId = 0)
    {
        if (isset($this->arrLoadedUsers[$this->id]['profile'][$attributeId][$historyId])) {
            return $this->arrLoadedUsers[$this->id]['profile'][$attributeId][$historyId];
        }
        if (isset($this->arrCachedUsers[$this->id]['profile'][$attributeId][$historyId])) {
            return $this->arrCachedUsers[$this->id]['profile'][$attributeId][$historyId];
        }
        return false;
    }


    public function getRegistrationDate()
    {
        return $this->regdate;
    }


    public function getRestoreKey()
    {
        return $this->restore_key;
    }


    public function getRestoreKeyTime()
    {
        return $this->restore_key_time;
    }


    public function getStaticPermissionIds($reload=false)
    {
        if (!isset($this->arrCachedUsers[$this->id]['static_access_ids']) || $reload) {
            $this->loadPermissionIds('static');
        }
        return $this->arrCachedUsers[$this->id]['static_access_ids'];
    }

    public function getUser($id)
    {
        $objUser = clone $this;
        $objUser->arrCachedUsers = &$this->arrCachedUsers;
        if ($objUser->load($id)) {
            return $objUser;
        }
        return false;
    }


    public function getUsername()
    {
        $arrSettings = User_Setting::getSettings();
        if (!$arrSettings['use_usernames']['status'] || empty($this->username)) {
            return $this->getEmail();
        }
        return $this->username;
    }


    public function getRealUsername()
    {
        return $this->username;
    }


    /**
     * Returns a User object according to the given criteria
     *
     * @param   mixed   $filter An integer or array defining a filter to apply on the lookup.
     *                          $filter can be an integer, where its value is treated as the ID of a user account.
     *                          This will cause the method to return the user account specified by that ID.
     *                          Addtitionally, $filter can be an array specifing a complex set
     *                          of <em>filter conditions</em>. Each key-value pair represents a <em>user-account's attribute</em>
     *                          and its <em>filter condition</em> to apply to. Depending on the attribute's type,
     *                          the filter condition must be either an integer or a string. It is also
     *                          possible to define a <em>complex filter condition</em>. This is done by defining an array
     *                          containing a list of conditions to apply to. Each key-value pair represents the
     *                          <em>condition operator</em> and the <em>condition expression</em> of the condition.
     *                          Allowed <em>condition operators</em> are for <em>user-account attributes</em> of type
     *                          <em>Integer</em>: =, <, > and for attributes of type <em>String</em>: !=, <, >, REGEXP
     * <h5>Fetch user with ID 3</h5>
     * <pre class="brush: php">$objUser = \User::getUsers(3);</pre>
     * <br>
     * <h5>Fetch all users who's firstname contains the string 'nicole'</h5>
     * <pre class="brush: php">
     * $filter = array(
     *      'firstname' => '%nicole%',
     * );
     * $objUser = \User::getUsers($filter);
     * </pre>
     * <br>
     * <h5>Fetch all users whose lastname starts with one of the following letters (case insensitive): a, b, c, e</h5>
     * <pre class="brush: php">
     * $filter = array(
     *      'lastname' => array(
     *          'a%',
     *          'b%',
     *          'c%',
     *          'e%',
     *      )
     * );
     * $objUser = \User::getUsers($filter);
     * </pre>
     * <br>
     * <h5>This does the same as the preview example but is written in a different notation</h5>
     * <pre class="brush: php">
     * $filter = array(
     *      'lastname' => array(
     * array(
     *              '>'  => 'a',
     *              '<'  => 'e%'
     *              '!=' => 'd%'
     *          ),
     *          'LIKE'   => 'e%'
     *      )
     * );
     * $objUser = \User::getUsers($filter);
     * </pre>
     * <br>
     * <h5>Fetch all active users that have been signed in within the last hour</h5>
     * <pre class="brush: php">
     * array(
     *      'is_active' => 1,
     *      'last_auth' => array(
     *          '>' => time()-3600
     *      )
     * );
     * $objUser = \User::getUsers($filter);
     * </pre>
     * @param   string  $search        The optional parameter $search can be used to do a fulltext search on the user accounts.
     *                                 $search is an array whereas its key-value pairs represent a user-account's attribute
     *                                 and its search pattern to apply to. If multiple search conditions are set, only one
     *                                 of the search conditions must match on a user to get included in the result.
     * <h5>Fetch users that contain the literal <em>nicole</em> in their <em>firstname</em> or <em>smith</em> in their <em>lastname</em></h5>
     * <pre class="brush: php">
     * array(
     *      'firstname' => 'nicole',
     *      'lastname'  => 'smith',
     * );
     * $objUser = \User::getUsers(null, $search);
     * </pre>
     *
     * @param   array   $arrSort       Normally, the users are ordered by their ID. Optionally the order can be specified by
     *                                 an array. Whereas each key-value pair represents the user-account's attribute and its
     *                                 order direction (asc/desc) to order the result by.
     * <h5>Order the users first by their active-status and then by their firstname</h5>
     * <pre class="brush: php">
     * $arrSort = array(
     *     'is_active' => 'desc',
     *     'firstname' => 'asc',
     * );
     * $objUser = \User::getUsers(null, null, $arrSort);
     * </pre>
     * @param   array   $arrAttributes Normally, all user-account data is loaded from the database. The optional parameter
     *                                 $arrAttributes can be used to limit the data that is loaded from the database by explicitly
     *                                 specifying which user-account attributes should be loaded from the database.
     *                                 $arrAttributes is an array containing a list of user-account attributes to be loaded.
     * <h5>Load all user-account data (default)</h5>
     * <pre class="brush: php">
     * $objUser = \User::getUsers();
     * </pre>
     * <br>
     * <h5>Load only user-account data <em>firstname</em> and <em>lastname</em> from database</h5>
     * <pre class="brush: php">
     * $arrAttributes = array('firstname', 'lastname')
     * $objUser = \User::getUsers(null, null, null, $arrAttributes);
     * </pre>
     * @param   integer $limit The maximal number of Users to load from the database. If not set, all matched users will be loaded.
     * @param   integer $offset The optional parameter $offset can be used to specify the number of found records to skip in the result set.
     * @return  User
     */
    public function getUsers(
        $filter=null, $search=null, $arrSort=null, $arrAttributes=null,
        $limit=null, $offset=0
    ) {
        $objUser = clone $this;
        $objUser->arrCachedUsers = &$this->arrCachedUsers;
        if ($objUser->loadUsers($filter, $search, $arrSort, $arrAttributes, $limit, $offset)) {
            return $objUser;
        }
        return false;
    }


    public function getValidityTimePeriod()
    {
        return $this->validity;
    }


    /**
     * Load user data
     *
     * Get username, email, lang_id, is_active and is_admin states from database
     * and put them into the analogous class variables.
     * @param integer $id
     * @throws UserException
     * @return unknown
     */
    private function load($id)
    {
        global $_LANGID;

        if ($this->isLoggedIn()) {
            throw new UserException("User->load(): Illegal method call - try getUser()!");
        }
        if ($id) {
            if (!isset($this->arrCachedUsers[$id])) {
                return $this->loadUsers($id);
            }
            $this->id = $id;
            $this->username = isset($this->arrCachedUsers[$id]['username']) ? $this->arrCachedUsers[$id]['username'] : '';
            $this->email = isset($this->arrCachedUsers[$id]['email']) ? $this->arrCachedUsers[$id]['email'] : '';
            $this->email_access = isset($this->arrCachedUsers[$id]['email_access']) ? $this->arrCachedUsers[$id]['email_access'] : $this->defaultEmailAccessType;
            $this->frontend_language = isset($this->arrCachedUsers[$id]['frontend_lang_id']) ? $this->arrCachedUsers[$id]['frontend_lang_id'] : $_LANGID;
            $this->backend_language = isset($this->arrCachedUsers[$id]['backend_lang_id']) ? $this->arrCachedUsers[$id]['backend_lang_id'] : $_LANGID;
            $this->is_active = isset($this->arrCachedUsers[$id]['active']) ? (bool)$this->arrCachedUsers[$id]['active'] : false;
            $this->primary_group = isset($this->arrCachedUsers[$id]['primary_group']) ? $this->arrCachedUsers[$id]['primary_group'] : 0;            $this->is_admin = isset($this->arrCachedUsers[$id]['is_admin']) ? (bool)$this->arrCachedUsers[$id]['is_admin'] : false;
            $this->is_admin = isset($this->arrCachedUsers[$id]['is_admin']) ? (bool)$this->arrCachedUsers[$id]['is_admin'] : false;
            $this->regdate = isset($this->arrCachedUsers[$id]['regdate']) ? $this->arrCachedUsers[$id]['regdate'] : 0;
            $this->expiration = isset($this->arrCachedUsers[$id]['expiration']) ? $this->arrCachedUsers[$id]['expiration'] : 0;
            $this->validity = isset($this->arrCachedUsers[$id]['validity']) ? $this->arrCachedUsers[$id]['validity'] : 0;
            $this->last_auth = isset($this->arrCachedUsers[$id]['last_auth']) ? $this->arrCachedUsers[$id]['last_auth'] : 0;
            $this->last_activity = isset($this->arrCachedUsers[$id]['last_activity']) ? $this->arrCachedUsers[$id]['last_activity'] : 0;
            $this->profile_access = isset($this->arrCachedUsers[$id]['profile_access']) ? $this->arrCachedUsers[$id]['profile_access'] : $this->defaultProfileAccessTyp;
            $this->restore_key = isset($this->arrCachedUsers[$id]['restore_key']) ? $this->arrCachedUsers[$id]['restore_key'] : '';
            $this->restore_key_time = isset($this->arrCachedUsers[$id]['restore_key_time']) ? $this->arrCachedUsers[$id]['restore_key_time'] : 0;
            $this->password = '';
            $this->arrGroups = null;
            $this->arrNewsletterListIDs = null;
            $this->networks = isset($this->arrCachedUsers[$id]['networks']) ? $this->arrCachedUsers[$id]['networks'] : new \Cx\Lib\User\User_Networks($id);
            $this->EOF = false;
            $this->loggedIn = false;
            return true;
        }
        $this->clean();
// TODO:  I guess this is wrong, then.
        return false;
    }


    protected function loadUsers(
        $filter=null, $search=null, $arrSort=null, $arrAttributes=null,
        $limit=null, $offset=0
    ) {
        global $objDatabase;

        if ($this->isLoggedIn()) {
            $arrDebugBackTrace =  debug_backtrace();
            die("User->loadUsers(): Illegal method call in {$arrDebugBackTrace[0]['file']} on line {$arrDebugBackTrace[0]['line']}!");
        }
        $this->arrLoadedUsers = array();
        $arrSelectMetaExpressions = array();
        $arrSelectCoreExpressions = array();
        $arrSelectCustomExpressions = null;
        $this->filtered_search_count = 0;
        $sqlCondition = '';

        // set filter
        if (isset($filter) && is_array($filter) && count($filter) || !empty($search)) {
            $sqlCondition = $this->getFilteredUserIdList($filter, $search);
        } elseif (!empty($filter)) {
            $sqlCondition['tables'] = array('core');
            $sqlCondition['conditions'] = array('tblU.`id` = '.intval($filter));
            $sqlCondition['group_tables'] = false;
            $limit = 1;
        }

        // set sort order
        if (isset($filter['group_id']) && $filter['group_id'] == 'groupless') {
            $groupless = true;
        } else {
            $groupless = false;
        }

        // $filter != 1 needed because $filter can be 1 to show all active users
        $crmUser = false;
        if (isset($filter['crm']) && $filter != 1 && $filter['crm'] == 1 && is_array($filter)) {
            $crmUser = true;
        }
        if (!($arrQuery = $this->setSortedUserIdList($arrSort, $sqlCondition, $limit, $offset, $groupless, $crmUser))) {
            $this->clean();
            return false;
        }

        // set field list
        if (is_array($arrAttributes)) {
            foreach ($arrAttributes as $attribute) {
                if (isset($this->arrAttributes[$attribute]) && !in_array($attribute, $arrSelectMetaExpressions)) {
                    $arrSelectMetaExpressions[] = $attribute;
                } elseif ($this->objAttribute->isCoreAttribute($attribute) && !in_array($attribute, $arrSelectCoreExpressions)) {
                    $arrSelectCoreExpressions[] = $attribute;
                } elseif ($this->objAttribute->isCustomAttribute($attribute) && (!isset($arrSelectCustomExpressions) || !in_array($attribute, $arrSelectCustomExpressions))) {
                    $arrSelectCustomExpressions[] = $attribute;
                }
            }

            if (!in_array('id', $arrSelectMetaExpressions)) {
                $arrSelectMetaExpressions[] = 'id';
            }
        } else {
            $arrSelectMetaExpressions = array_keys($this->arrAttributes);
            $arrSelectCoreExpressions = $this->objAttribute->getCoreAttributeIds();
            $arrSelectCustomExpressions = array();
        }

        $query = 'SELECT tblU.`'.implode('`, tblU.`', $arrSelectMetaExpressions).'`'
            .(count($arrSelectCoreExpressions) ? ', tblP.`'.implode('`, tblP.`', $arrSelectCoreExpressions).'`' : '')
            .'FROM `'.DBPREFIX.'access_users` AS tblU'
            .(count($arrSelectCoreExpressions) || $arrQuery['tables']['core'] ? ' INNER JOIN `'.DBPREFIX.'access_user_profile` AS tblP ON tblP.`user_id` = tblU.`id`' : '')
            .($arrQuery['tables']['custom'] ? ' INNER JOIN `'.DBPREFIX.'access_user_attribute_value` AS tblA ON tblA.`user_id` = tblU.`id`' : '')
            .($arrQuery['tables']['group']
                ? (isset($filter['group_id']) && $filter['group_id'] == 'groupless'
                    ? ' LEFT JOIN `'.DBPREFIX.'access_rel_user_group` AS tblG ON tblG.`user_id` = tblU.`id`'
                    : ' INNER JOIN `'.DBPREFIX.'access_rel_user_group` AS tblG ON tblG.`user_id` = tblU.`id`')
                : ''
            )
            .($arrQuery['tables']['group'] && !FWUser::getFWUserObject()->isBackendMode() ? ' INNER JOIN `'.DBPREFIX.'access_user_groups` AS tblGF ON tblGF.`group_id` = tblG.`group_id`' : '')
            .(count($arrQuery['joins']) ? ' '.implode(' ',$arrQuery['joins']) : '')
// TODO: some conditions are not well enclosed, so there might be a more proper solution than adding more brackes at this point
            .(count($arrQuery['conditions']) ? ' WHERE ('.implode(') AND (', $arrQuery['conditions']).')' : '')
            .($arrQuery['group_tables'] ? ' GROUP BY tblU.`id`' : '')
            .(count($arrQuery['sort']) ? ' ORDER BY '.implode(', ', $arrQuery['sort']) : '');
        $objUser = false;
        if (empty($limit)) {
            $objUser = $objDatabase->Execute($query);
        } else {
            $objUser = $objDatabase->SelectLimit($query, $limit, $offset);
        };
        if ($objUser !== false && $objUser->RecordCount() > 0) {
            while (!$objUser->EOF) {
                foreach ($objUser->fields as $attributeId => $value) {
                    if ($this->objAttribute->isCoreAttribute($attributeId)) {
                        $this->arrCachedUsers[$objUser->fields['id']]['profile'][$attributeId][0] = $this->arrLoadedUsers[$objUser->fields['id']]['profile'][$attributeId][0] = $value;
                    } else {
                        $this->arrCachedUsers[$objUser->fields['id']][$attributeId] = $this->arrLoadedUsers[$objUser->fields['id']][$attributeId] = $value;
                    }
                }
                $this->arrCachedUsers[$objUser->fields['id']]['networks'] = $this->arrLoadedUsers[$objUser->fields['id']]['networks'] = new \Cx\Lib\User\User_Networks($objUser->fields['id']);
                $objUser->MoveNext();
            }
            isset($arrSelectCustomExpressions) ? $this->loadCustomAttributeProfileData($arrSelectCustomExpressions) : false;
            $this->first();
            return true;
        }
        $this->clean();
        return false;
    }


    public function __clone()
    {
        $this->clean();
    }


    /*private function parseFilterConditions($filter)
    {
        $arrConditions = array();

        if (count($arrAccountConditions = $this->parseAccountFilterConditions($filter))) {
            $arrConditions[] = implode(' AND ', $arrAccountConditions);
        }
        if (count($arrCoreAttributeConditions = $this->parseCoreAttributeFilterConditions($filter))) {
            $arrConditions[] = implode(' AND ', $arrCoreAttributeConditions);
        }
        if (count($arrCustomAttributeConditions = $this->parseCustomAttributeFilterConditions($filter))) {
            $arrConditions[] = implode(' AND ', $arrCustomAttributeConditions);
        }

        return $arrConditions;
    }*/


    /*private function parseSearchConditions($search)
    {
        $arrConditions = array();

        if (count($arrAccountConditions = $this->parseAccountSearchConditions($search))) {
            $arrConditions[] = implode(' OR ', $arrAccountConditions);
        }
        if (count($arrCoreAttributeConditions = $this->parseAttributeSearchConditions($search, true))) {
            $arrConditions[] = implode(' OR ', $arrCoreAttributeConditions);
        }
        if (count($arrCustomAttributeConditions = $this->parseAttributeSearchConditions($search, false))) {
            $arrConditions[] = implode(' OR ', $arrCustomAttributeConditions);
        }

        return $arrConditions;
    }*/


    /**
     * Creates the SQL query snippet to match username (and e-mail in the
     * backend) fields against the search term(s)
     *
     * Matches single (scalar) or multiple (array) search terms against a
     * number of fields.  Generally, the term(s) are enclosed in percent
     * signs ("%term%"), so any fields that contain them will match.
     * However, if the search parameter is a string and does contain a percent
     * sign already, none will be added to the query.
     * This allows searches using custom patterns, like "fields beginning
     * with "a" ("a%").
     * (You might even want to extend this to work with arrays, too.
     * Currently, only the shop module uses this feature.) -- RK 20100910
     * @param   mixed     $search   The term or array of terms
     * @return  array               The array of SQL snippets
     */
    private function parseAccountSearchConditions($search)
    {
        $FWUser = FWUser::getFWUserObject();
        $arrConditions = array();
        $arrAttribute = array('username');
        if ($FWUser->isBackendMode()) {
            $arrAttribute[] = 'email';
        }
        $percent = '%';
        if (!is_array($search) && strpos('%', $search) !== false)
            $percent = '';
        foreach ($arrAttribute as $attribute) {
            $arrConditions[] =
                "(tblU.`".$attribute."` LIKE '$percent".
                (is_array($search)
                  ? implode("$percent' OR tblU.`".$attribute."` LIKE '$percent", array_map('addslashes', $search))
                  : addslashes($search))."$percent')";
        }
        return $arrConditions;
    }


    private function setSortedUserIdList(
        $arrSort, $sqlCondition=null, $limit=null, $offset=null, $groupless=false, $crmUser=false
    ) {
        global $objDatabase;

        $arrCustomJoins = array();
        $arrCustomSelection = array();
        $joinCoreTbl = false;
        $joinCustomTbl = false;
        $joinGroupTbl = false;
        $arrUserIds = array();
        $arrSortExpressions = array();
        $groupTables = false;
        $nr = 0;
        if (!empty($sqlCondition)) {
            if (isset($sqlCondition['tables'])) {
                if (in_array('core', $sqlCondition['tables'])) {
                    $joinCoreTbl = true;
                }
                if (in_array('custom', $sqlCondition['tables'])) {
                    $joinCustomTbl = true;
                }
                if (in_array('group', $sqlCondition['tables'])) {
                    $joinGroupTbl = true;
                }
            }
            if (isset($sqlCondition['conditions']) && count($sqlCondition['conditions'])) {
                $arrCustomSelection = $sqlCondition['conditions'];
            }
            if (!empty($sqlCondition['group_tables'])) {
                $groupTables = true;
            }
        }
        if (is_array($arrSort)) {
            foreach ($arrSort as $attribute => $direction) {
                if (in_array(strtolower($direction), array('asc', 'desc'))) {
                    if (isset($this->arrAttributes[$attribute])) {
                        $arrSortExpressions[] = 'tblU.`'.$attribute.'` '.$direction;
                    } elseif ($this->objAttribute->load($attribute)) {
                        if ($this->objAttribute->isCoreAttribute($attribute)) {
                            $arrSortExpressions[] = 'tblP.`'.$attribute.'` '.$direction;
                            $joinCoreTbl = true;
                        } else {
                            $arrSortExpressions[] = 'tblA'.$nr.'.`value` '.$direction;
                            $arrCustomJoins[] = 'INNER JOIN `'.DBPREFIX.'access_user_attribute_value` AS tblA'.$nr.' ON tblA'.$nr.'.`user_id` = tblU.`id`';
                            $arrCustomSelection[] = 'tblA'.$nr.'.`attribute_id` = '.$attribute;
                            ++$nr;
                        }
                    }
                } elseif ($attribute == 'special') {
                    $arrSortExpressions[] = $direction;
                }
            }
        }
        if (!is_array($arrSort) || !array_key_exists('id', $arrSort)) {
            $arrSortExpressions[] = 'tblU.`id` ASC';
        }
        if ($crmUser == true) {
            $arrCustomJoins[] = 'INNER JOIN `'.DBPREFIX.'module_crm_contacts` AS tblCrm ON tblCrm.`user_account` = tblU.`id`';
        }
        $query = '
            SELECT SQL_CALC_FOUND_ROWS DISTINCT tblU.`id`
              FROM `'.DBPREFIX.'access_users` AS tblU'.
            ($joinCoreTbl ? ' INNER JOIN `'.DBPREFIX.'access_user_profile` AS tblP ON tblP.`user_id`=tblU.`id`' : '').
            ($joinCustomTbl ? ' INNER JOIN `'.DBPREFIX.'access_user_attribute_value` AS tblA ON tblA.`user_id`=tblU.`id`' : '').
            ($joinGroupTbl
                ? ($groupless
                    ? ' LEFT JOIN `'.DBPREFIX.'access_rel_user_group` AS tblG ON tblG.`user_id`=tblU.`id`'
                    : ' INNER JOIN `'.DBPREFIX.'access_rel_user_group` AS tblG ON tblG.`user_id`=tblU.`id`')
                : ''
            ).
            ($joinGroupTbl && !FWUser::getFWUserObject()->isBackendMode() ? ' INNER JOIN `'.DBPREFIX.'access_user_groups` AS tblGF ON tblGF.`group_id`=tblG.`group_id`' : '').
            (count($arrCustomJoins) ? ' '.implode(' ',$arrCustomJoins) : '').
            (count($arrCustomSelection) ? ' WHERE '.implode(' AND ', $arrCustomSelection) : '').
            (count($arrSortExpressions) ? ' ORDER BY '.implode(', ', $arrSortExpressions) : '');
        $objUserId = false;
        if (empty($limit)) {
            $objUserId = $objDatabase->Execute($query);
            $this->filtered_search_count = ($objUserId === false ? 0 : $objUserId->RecordCount());
        } else {
            $objUserId = $objDatabase->SelectLimit($query, $limit, intval($offset));
            $objUserCount = $objDatabase->Execute('SELECT FOUND_ROWS()');
            $this->filtered_search_count = $objUserCount->fields['FOUND_ROWS()'];
        }
        if ($objUserId !== false) {
            while (!$objUserId->EOF) {
                $arrUserIds[$objUserId->fields['id']] = '';
                $objUserId->MoveNext();
            }
        }
        $this->arrLoadedUsers = $arrUserIds;
        if (!count($arrUserIds)) {
            return false;
        }
        return array(
            'tables' => array(
                'core'      => $joinCoreTbl,
                'custom'    => $joinCustomTbl,
                'group'     => $joinGroupTbl
            ),
            'joins'         => $arrCustomJoins,
            'conditions'    => $arrCustomSelection,
            'sort'          => $arrSortExpressions,
            'group_tables'  => $groupTables,
        );
        /*$arrNotSortedUserIds = array_diff(array_keys($this->arrLoadedUsers), $arrUserIds);
        foreach ($arrNotSortedUserIds as $userId) {
            $arrUserIds[$userId] = '';
        }*/
    }


    public function setRestoreKey()
    {
        $this->restore_key = md5($this->username.$this->regdate.time());
        $this->restore_key_time = time() + 3600;
    }


    public function setRestoreKeyTime($seconds)
    {
        $this->restore_key_time = time() + $seconds;
    }


    public function releaseRestoreKey()
    {
        $this->restore_key = '';
        $this->restore_key_time = 0;
        return true;
    }


    /**
     * Parse account filter conditions
     *
     * Generate conditions of the account attributes for the SQL WHERE statement.
     * The filter conditions are defined through the two dimensional array $arrFilter.
     * Each key-value pair represents an attribute and its associated condition to which it must fit to.
     * The condition could either be a integer or string depending on the attributes type, or it could be
     * a collection of integers or strings represented in an array.
     *
     * Examples of the filer array:
     *
     * array(
     *      'firstname' => '%nicole%',
     * )
     * // will return all users who's firstname include 'nicole'
     *
     *
     * array(
     *      'firstname' => array(
     *          'd%',
     *          'e%',
     *          'f%',
     *          'g%'
     *      )
     * )
     * // will return all users which have a firstname of which its first letter is and between 'd' to 'g' (case less)
     *
     *
     * array(
     *      'firstname' => array(
     *          array(
     *              '>' => 'd',
     *              '<' => 'g'
     *          ),
     *          'LIKE'  => 'g%'
     *      )
     * )
     * // same as the preview example but in an other way
     *
     *
     * array(
     *      'is_active' => 1,
     *      'last_auth' => array(
     *          '>' => time()-3600
     *      )
     * )
     * // will return all users that are active and have been logged in at least in the last one hour
     *
     *
     *
     * @param array $arrFilter
     * @return array
     */
    private function parseAccountFilterConditions($arrFilter)
    {
        $arrConditions = array();
        foreach ($arrFilter as $attribute => $condition) {
            /**
             * $attribute is the account attribute like 'email' or 'username'
             * $condition is either a simple condition (integer or string) or an condition matrix (array)
             */
            if (isset($this->arrAttributes[$attribute])) {
                $arrComparisonOperators = array(
                    'int'       => array('=','<','>'),
                    'string'    => array('!=','<','>', 'REGEXP')
                );
                $arrDefaultComparisonOperator = array(
                    'int'       => '=',
                    'string'    => 'LIKE'
                );
                $arrEscapeFunction = array(
                    'int'       => 'intval',
                    'string'    => 'addslashes'
                );

                if (is_array($condition)) {
                    $arrRestrictions = array();
                    foreach ($condition as $operator => $restriction) {
                        /**
                         * $operator is either a comparison operator ( =, LIKE, <, >) if $restriction is an array or if $restriction is just an integer or a string then its an index which would be useless
                         * $restriction is either a integer or a string or an array which represents a restriction matrix
                         */
                        if (is_array($restriction)) {
                            $arrConditionRestriction = array();
                            foreach ($restriction as $restrictionOperator => $restrictionValue) {
                                /**
                                 * $restrictionOperator is a comparison operator ( =, <, >)
                                 * $restrictionValue represents the condition
                                 */
                                $arrConditionRestriction[] = "tblU.`{$attribute}` ".(
                                    in_array($restrictionOperator, $arrComparisonOperators[$this->arrAttributes[$attribute]], true) ?
                                        $restrictionOperator
                                    :   $arrDefaultComparisonOperator[$this->arrAttributes[$attribute]]
                                )." '".$arrEscapeFunction[$this->arrAttributes[$attribute]]($restrictionValue)."'";
                            }
                            $arrRestrictions[] = implode(' AND ', $arrConditionRestriction);
                        } else {
                            $arrRestrictions[] = "tblU.`{$attribute}` ".(
                                in_array($operator, $arrComparisonOperators[$this->arrAttributes[$attribute]], true) ?
                                    $operator
                                :   $arrDefaultComparisonOperator[$this->arrAttributes[$attribute]]
                            )." '".$arrEscapeFunction[$this->arrAttributes[$attribute]]($restriction)."'";
                        }
                    }
                    $arrConditions[] = '(('.implode(') OR (', $arrRestrictions).'))';
                } else {
                    $arrConditions[] = "(tblU.`".$attribute."` ".$arrDefaultComparisonOperator[$this->arrAttributes[$attribute]]." '".$arrEscapeFunction[$this->arrAttributes[$attribute]]($condition)."')";
                }
            }
        }

        return $arrConditions;
    }


    /**
     * Load group ID's of user
     *
     * Returns an array with the ID's of all groups to which
     * the user is associated to.
     * @param boolean $onlyActiveGroups
     * @global ADONewConnection
     * @return mixed array on success, FALSE on failure
     */
    private function loadGroups($onlyActiveGroups=false)
    {
        global $objDatabase;

        $objResult = $objDatabase->Execute('
            SELECT tblRel.`group_id`
              FROM `'.DBPREFIX.'access_rel_user_group` AS tblRel
             INNER JOIN `'.DBPREFIX.'access_user_groups` AS tblGroup
             USING (`group_id`)
             WHERE tblRel.`user_id`='.$this->id.
            ($onlyActiveGroups ? ' AND tblGroup.`is_active` = 1' : '')
        );
        if (!$objResult) {
            return false;
        }
        $arrGroups = array();
        while (!$objResult->EOF) {
            array_push($arrGroups, $objResult->fields['group_id']);
            $objResult->MoveNext();
        }
        return $arrGroups;
    }

    private function loadSubscribedNewsletterListIDs()
    {
        global $objDatabase;

        $this->arrNewsletterListIDs = array();

        $objResult = $objDatabase->Execute('
            SELECT
                `newsletterCategoryID`
            FROM
                `'.DBPREFIX.'module_newsletter_access_user`
            WHERE `accessUserID`='.$this->id
        );

        if ($objResult) {
            while (!$objResult->EOF) {
                $this->arrNewsletterListIDs[] = $objResult->fields['newsletterCategoryID'];
                $objResult->MoveNext();
            }
        }
    }

    public function reset()
    {
        $this->clean();
    }


    /**
     * Load next user
     */
    public function next()
    {
        if (next($this->arrLoadedUsers) === false || !$this->load(key($this->arrLoadedUsers))) {
            $this->EOF = true;
        }
    }


    public function signUp()
    {
        $arrSettings = User_Setting::getSettings();
        if ($arrSettings['user_activation']['status']) {
            $this->restore_key = md5($this->username.$this->password.time());
            $this->restore_key_time = $arrSettings['user_activation_timeout']['status'] ? time() + $arrSettings['user_activation_timeout']['value'] * 3600 : 0;
        }
        return $this->store();
    }


    /**
     * Store user account
     *
     * This stores the metadata of the user, which includes the username,
     * password, email, language ID, activ status and the administration status,
     * to the database.
     * If it is a new user, it also sets the registration time to the current time.
     * @global ADONewConnection
     * @global array
     * @return boolean
     */
    public function store()
    {
        global $objDatabase, $_CORELANG;

        if (!$this->validateUsername()) {
            return false;
        }
        if (!$this->validateEmail()) {
            return false;
        }
        if ($this->networks) {
            $this->networks->save();
        }
        if ($this->id) {
            if ($objDatabase->Execute("
                UPDATE `".DBPREFIX."access_users`
                SET
                    `username` = '".addslashes($this->username)."',
                    `is_admin` = ".intval($this->is_admin).",
                    ".(!empty($this->password) ? "`password` = '".$this->password."'," : '')."
                    `email` = '".addslashes($this->email)."',
                    `email_access` = '".$this->email_access."',
                    `frontend_lang_id` = ".intval($this->frontend_language).",
                    `backend_lang_id` = ".intval($this->backend_language).",
                    `expiration` = ".intval($this->expiration).",
                    `validity` = ".intval($this->validity).",
                    `active` = ".intval($this->is_active).",
                    `primary_group` = ".intval($this->primary_group).",
                    `profile_access` = '".$this->profile_access."',
                    `restore_key` = '".$this->restore_key."',
                    `restore_key_time` = ".$this->restore_key_time."
                WHERE `id` = ".$this->id
            ) === false) {
                $this->error_msg[] = $_CORELANG['TXT_ACCESS_FAILED_TO_UPDATE_USER_ACCOUNT'];
                return false;
            }
            if (!empty($this->password)) {
                // deletes all sessions which are using this user (except the session changing the password)
                $_SESSION->cmsSessionDestroyByUserId($this->id);
            }
        } else {
            if ($objDatabase->Execute("
                INSERT INTO `".DBPREFIX."access_users` (
                    `username`,
                    `is_admin`,
                    `password`,
                    `email`,
                    `email_access`,
                    `frontend_lang_id`,
                    `backend_lang_id`,
                    `regdate`,
                    `expiration`,
                    `validity`,
                    `last_auth`,
                    `last_activity`,
                    `active`,
                    `primary_group`,
                    `profile_access`,
                    `restore_key`,
                    `restore_key_time`
                ) VALUES (
                    '".addslashes($this->username)."',
                    ".intval($this->is_admin).",
                    '".$this->password."',
                    '".addslashes($this->email)."',
                    '".$this->email_access."',
                    ".intval($this->frontend_language).",
                    ".intval($this->backend_language).",
                    ".time().",
                    ".intval($this->expiration).",
                    ".intval($this->validity).",
                    ".$this->last_auth.",
                    ".$this->last_activity.",
                    ".intval($this->is_active).",
                    ".intval($this->primary_group).",
                    '".$this->profile_access."',
                    '".$this->restore_key."',
                    '".$this->restore_key_time."'
                )")) {
                $this->id = $objDatabase->Insert_ID();
                if (!$this->createProfile()) {
                    $this->delete();
                    $this->error_msg[] = $_CORELANG['TXT_ACCESS_FAILED_TO_ADD_USER_ACCOUNT'];
                    return false;
                }
            } else {
                $this->error_msg[] = $_CORELANG['TXT_ACCESS_FAILED_TO_ADD_USER_ACCOUNT'];
                return false;
            }
        }

        if (!$this->storeGroupAssociations()) {
            $this->error_msg[] = $_CORELANG['TXT_ARRAY_COULD_NOT_SET_GROUP_ASSOCIATIONS'];
            return false;
        }

        if (!$this->storeNewsletterSubscriptions()) {
            $this->error_msg[] = $_CORELANG['TXT_ARRAY_COULD_NOT_SET_NEWSLETTER_ASSOCIATIONS'];
            return false;
        }

        if (!$this->storeProfile()) {
            $this->error_msg[] = $_CORELANG['TXT_ACCESS_FAILED_STORE_PROFILE'];
            return false;
        }

        return true;
    }

    /**
     * Add or update a network connection of the user
     *
     * @param string $oauth_provider the name of the provider
     * @param string $oauth_id the user id on the side of the provider
     */
    public function setNetwork($oauth_provider, $oauth_id) {
        $this->networks->setNetwork($oauth_provider, $oauth_id);
    }

    /**
     * Check whether it exists a user with the data
     *
     * @param string $oauth_provider the name of the provider
     * @param string $oauth_id the user id on the side of the provider
     * @return object the user object
     */
    public function getByNetwork($oauth_provider, $oauth_id) {
        global $objDatabase;
        self::removeOutdatedAccounts();
        $query = "SELECT tblU.`id` FROM `" . DBPREFIX . "access_users` AS tblU
                    INNER JOIN `" . DBPREFIX . "access_user_network` AS tblN ON tblU.`id` = tblN.`user_id`
                  WHERE tblN.`oauth_provider` = ? AND tblN.`oauth_id` = ? AND tblU.`active` = 1";
        $objResult = $objDatabase->SelectLimit($query, 1, -1, array($oauth_provider, $oauth_id));
        if ($objResult !== false) {
            return $this->getUser($objResult->fields['id']);
        }
        return null;
    }

    /**
     * @return object
     */
    public function getNetworks() {
        return $this->networks;
    }

    /**
     * Load the network data
     */
    public function loadNetworks() {
        $this->networks = new \Cx\Lib\User\User_Networks($this->id);
    }

    /**
     * Store group associations
     *
     * Stores the group associations of the loaded user.
     * Returns TRUE on success, FALSE on failure.
     * @global ADONewConnection
     * @return boolean
     */
    private function storeGroupAssociations()
    {
        global $objDatabase;

        $status = true;
        $arrCurrentGroups = $this->loadGroups();
        $arrAddedGroups = array_diff($this->getAssociatedGroupIds(), $arrCurrentGroups);
        $arrRemovedGroups = array_diff($arrCurrentGroups, $this->getAssociatedGroupIds());
        foreach ($arrRemovedGroups as $groupId) {
            if (!$objDatabase->Execute('
                DELETE FROM `'.DBPREFIX.'access_rel_user_group`
                 WHERE `group_id`='.$groupId.'
                   AND `user_id`='.$this->id)) {
                $status = false;
            }
        }
        foreach ($arrAddedGroups as $groupId) {
            if (!$objDatabase->Execute('
                INSERT INTO `'.DBPREFIX.'access_rel_user_group` (
                    `user_id`, `group_id`
                ) VALUES (
                    '.$this->id.', '.$groupId.'
                )')) {
                $status = false;
            }
        }
        return $status;
    }


    /**
     * Store the user's newsletter-list-subscriptions to the database
     * @return      bool
     */
    private function storeNewsletterSubscriptions()
    {
        global $objDatabase;

        if (!isset($this->arrNewsletterListIDs)) {
            return true;
        }

        $categories = $this->arrNewsletterListIDs;

        if (count($categories)) {
            foreach (array_keys($categories) as $key) {
                // Make sure they're integers
                $categories[$key] = intval($categories[$key]);
                $query = sprintf('
                    INSERT IGNORE INTO `%smodule_newsletter_access_user` (
                        `accessUserId`, `newsletterCategoryID`, `code`
                    ) VALUES (
                        %s, %s, \'%s\'
                    )',
                    DBPREFIX,
                    $this->id,
                    $categories[$key],
                    \NewsletterLib::_emailCode()
                );
                $objDatabase->execute($query);
            }
            $delString = implode(',', $categories);
            $query = sprintf('
                DELETE FROM `%smodule_newsletter_access_user`
                WHERE `newsletterCategoryID` NOT IN (%s)
                AND `accessUserId`=%s',
                DBPREFIX,
                $delString,
                $this->id
            );
        } else {
            $query = sprintf('
                DELETE FROM `%smodule_newsletter_access_user`
                WHERE `accessUserId`=%s',
                DBPREFIX,
                $this->id
            );

        }

        return (bool)$objDatabase->Execute($query);
    }


    private static function removeOutdatedAccounts()
    {
        global $objDatabase;
        static $userActivationTimeoutStatus = null;

        if (!isset($userActivationTimeoutStatus)) {
            $arrSettings = User_Setting::getSettings();
            $userActivationTimeoutStatus =
                !empty($arrSettings['user_activation_timeout']['status']);
        }
        if ($userActivationTimeoutStatus) {
            $objDatabase->Execute('
                DELETE tblU, tblP, tblG, tblA, tblN
                  FROM `'.DBPREFIX.'access_users` AS tblU
                 INNER JOIN `'.DBPREFIX.'access_user_profile` AS tblP ON tblP.`user_id`=tblU.`id`
                  LEFT JOIN `'.DBPREFIX.'access_rel_user_group` AS tblG ON tblG.`user_id`=tblU.`id`
                  LEFT JOIN `'.DBPREFIX.'access_user_attribute_value` AS tblA ON tblA.`user_id`=tblU.`id`
                  LEFT JOIN `'.DBPREFIX.'access_user_network` AS tblN ON tblN.`user_id`=tblU.`id`
                 WHERE tblU.`active`=0
                   AND tblU.`restore_key`!=\'\'
                   AND tblU.`restore_key_time`<'.time());
        }
        // remove outdated social login users
        $objDatabase->Execute('
            DELETE tblU, tblP, tblG, tblA, tblN
              FROM `'.DBPREFIX.'access_users` AS tblU
             INNER JOIN `'.DBPREFIX.'access_user_profile` AS tblP ON tblP.`user_id`=tblU.`id`
             INNER JOIN `'.DBPREFIX.'access_user_network` AS tblN ON tblN.`user_id`=tblU.`id`
              LEFT JOIN `'.DBPREFIX.'access_rel_user_group` AS tblG ON tblG.`user_id`=tblU.`id`
              LEFT JOIN `'.DBPREFIX.'access_user_attribute_value` AS tblA ON tblA.`user_id`=tblU.`id`
             WHERE tblU.`active`=0
               AND tblU.`restore_key`!=\'\'
               AND tblU.`restore_key_time`<'.time());
    }


    /**
     * Returns true if the User name is valid and unique
     * @return  boolean       True if the User name is valid and unique,
     *                        false otherwise
     * @access  public        Called from the Shop!
     */
    public function validateUsername()
    {
        global $_CORELANG;

        if (empty($this->username)) {
            return true;
        }
        if (self::isValidUsername($this->username)) {
            if (self::isUniqueUsername($this->username, $this->id)) {
                return true;
            } else {
                $this->error_msg[] = $_CORELANG['TXT_ACCESS_USERNAME_ALREADY_USED'];
            }
        } else {
            $this->error_msg[] = $_CORELANG['TXT_ACCESS_INVALID_USERNAME'];
        }

        return false;
    }


    private function isLoggedIn()
    {
        return $this->loggedIn;
    }


    public function login($backend = false)
    {

        if ($this->loggedIn) return true;
        if(isset($_SESSION)
            && is_object($_SESSION)
            && $_SESSION->userId
            && $this->load($_SESSION->userId)
            && $this->getActiveStatus()
            && $this->hasModeAccess($backend)
            && $this->updateLastActivityTime()) {
            $this->loggedIn = true;
            return true;
        }
        return false;
    }


    /**
     * Returns true if this Users' e-mail address is valid and unique.
     *
     * Otherwise, adds appropriate error messages, and returns false.
     * Required to be public by the Shop!
     * @return  boolean         True for valid and unique e-mail addresses,
     *                          false otherwise
     */
    public function validateEmail()
    {
        global $_CORELANG;

        if (FWValidator::isEmail($this->email)) {
            if (self::isUniqueEmail($this->email, $this->id)) {
                return true;
            } else {
                $this->error_msg[] = $_CORELANG['TXT_ACCESS_EMAIL_ALREADY_USED'];
            }
        } else {
            $this->error_msg[] = $_CORELANG['TXT_ACCESS_INVALID_EMAIL_ADDRESS'];
        }

        return false;
    }


    /**
     * Validate language id
     *
     * Checks if the language ids frontend_lang_id and backend_lang_id are valid language IDs.
     * In the case that the specified language isn't valid, the ID 0 is taken instead.
     * $scope could either be 'frontend' or 'backend'
     *
     * @param string $scope
     */
    private function validateLanguageId($scope)
    {
        $this->{$scope.'_language'} =
            (FWLanguage::getLanguageParameter(
                $this->{$scope.'_language'}, $scope)
                  ? $this->{$scope.'_language'} : 0);
    }


    private function loadPermissionIds($type)
    {
        global $objDatabase;

        $query = '
            SELECT tblI.`access_id`
            FROM `'.DBPREFIX.'access_users` AS tblU
            INNER JOIN `'.DBPREFIX.'access_rel_user_group` AS tblR ON tblR.`user_id` = tblU.`id`
            INNER JOIN `'.DBPREFIX.'access_user_groups` AS tblG ON tblG.`group_id` = tblR.`group_id`
            INNER JOIN `'.DBPREFIX.'access_group_'.$type.'_ids` AS tblI ON tblI.`group_id` = tblG.`group_id`
            WHERE tblU.`id` = '.$this->id.'
                  AND tblG.`is_active`
            GROUP BY tblI.`access_id`
            ORDER BY tblI.`access_id`';
        $objAccessId = $objDatabase->Execute($query);
        if ($objAccessId !== false) {
            $this->arrCachedUsers[$this->id][$type.'_access_ids'] = array();
            while (!$objAccessId->EOF) {
                $this->arrCachedUsers[$this->id][$type.'_access_ids'][] = $objAccessId->fields['access_id'];
                $objAccessId->MoveNext();
            }
        }
    }


    public function hasModeAccess($backend = false)
    {
        global $objDatabase;

        if ($this->getAdminStatus()) {
            return true;
        }
        $query = "
            SELECT 1
              FROM `".DBPREFIX."access_user_groups` AS tblG
              INNER JOIN `".DBPREFIX."access_rel_user_group` AS tblR ON tblR.`group_id`=tblG.`group_id`
              INNER JOIN `".DBPREFIX."access_users` AS tblU ON tblU.`id`=tblR.`user_id`
             WHERE tblU.`id`=$this->id
               AND tblG.`is_active`=1
               AND (tblG.`type`='".($backend ? 'backend' : 'frontend')."'
                OR tblG.`type`='backend')";
        $objResult = $objDatabase->SelectLimit($query, 1);
        if (!$objResult) {
            return false;
        }
        if ($objResult->EOF) {
            return false;
        }
        return true;
    }


    private function updateLastActivityTime()
    {
        global $objDatabase;

        $arrSettings = User_Setting::getSettings();
        $intervalvalue = (isset($arrSettings['session_user_interval']['value'])
            ? $arrSettings['session_user_interval']['value'] : 500);
        if (time() > ($intervalvalue + $this->last_activity)) {
            return $objDatabase->Execute("
                UPDATE `".DBPREFIX."access_users`
                   SET `last_activity`='".time()."'
                 WHERE `id`=$this->id");
        }
        return true;
    }


    private function updateLastAuthTime()
    {
        global $objDatabase;

        return $objDatabase->Execute("
            UPDATE `".DBPREFIX."access_users`
               SET `last_auth`='".time()."'
             WHERE `id`=$this->id");
    }


    /**
     * Register a successful login.
     *
     * @static
     * @access  public
     * @param   string              $username
     * @global  ADONewConnection    $objDatabase
     */
    public function registerSuccessfulLogin()
    {
        global $objDatabase;

        return $objDatabase->Execute("
            UPDATE `".DBPREFIX."access_users`
               SET `last_auth_status`=1
             WHERE `id`=$this->id");
    }


    /**
     * Register a failed login.
     * This causes that the user needs to fill out
     * the captcha the next time he logs on.
     *
     * @static
     * @access  public
     * @param   string              $username
     * @global  ADONewConnection    $objDatabase
     */
    public static function registerFailedLogin($username)
    {
        global $objDatabase;

        $column = 'email';
        $arrUserSettings = \User_Setting::getSettings();
        if ($arrUserSettings['use_usernames']['status']) {
            $column = 'username';
        }

        return $objDatabase->Execute('
            UPDATE `' . DBPREFIX . 'access_users`
               SET `last_auth_status` = 0
             WHERE `' . $column . '` = "' . $username . '"
        ');
    }


    /**
     * Sets username of user
     *
     * This will set the attribute username of this object to $username
     * if the parameter $username is valid and isn't yet used by an other user.
     * @param string $username
     * @return boolean
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }


    /**
     * Sets the validity period of the account
     *
     * Administrators cannot be restricted in their validity.
     * Returns TRUE.
     * @param integer $timestamp
     * @return boolean
     */
    public function setValidityTimePeriod($validity)
    {
        if ($this->getAdminStatus()) {
            $this->validity = 0;
            $this->setExpirationDate(0);
        } else {
            $this->validity = $validity;
            $this->setExpirationDate(($validitySeconds = $validity*60*60*24) ? mktime(23, 59, 59, date('m', time() + $validitySeconds), date('d', time() + $validitySeconds), date('Y', time() + $validitySeconds)) : 0);
        }
        return true;
    }


    public function setExpirationDate($expiration)
    {
        $this->expiration = $expiration;
    }


    /**
     * Sets email address of user
     *
     * This will set the attribute email of this object to $email
     * if the parameter $email is valid and isn't yet used by an other user.
     * @param string $email
     * @return boolean
     */
    public function setEmail($email)
    {
        // START: WORKAROUND FOR ACCOUNTS SOLD IN THE SHOP
        $emailPrefix = array();
        if (preg_match(
            '/^(shop_customer_[0-9]+_[0-9]+_[0-9]-).+$/',
            $this->email, $emailPrefix)) {
            $email = $emailPrefix[1].$email;
        }
        // END: WORKAROUND FOR ACCOUNTS SOLD IN THE SHOP
        $this->email = $email;
    }


    /**
     * Sets password of user
     *
     * This will set the attribute password of this object to the md5 hash
     * of $password if $password is a valid password and if it was confirmed
     * by the second parameter $confirmedPassword.
     * @param   string    $password           The new password
     * @param   string    $confirmedPassword  The new password, again
     * @return  boolean                       True on success, false otherwise
     * @global  array     $_CORELANG
     */
    public function setPassword($password, $confirmedPassword=null, $reset=false)
    {
        global $_CORELANG, $_CONFIG;

        if ((empty($password) && empty($confirmedPassword) && $this->id && !$reset) || isset($_SESSION['user_id'])) {
            return true;
        }
        if (self::isValidPassword($password)) {
            if (isset($confirmedPassword) && $password != $confirmedPassword) {
                $this->error_msg[] = $_CORELANG['TXT_ACCESS_PASSWORD_NOT_CONFIRMED'];
                return false;
            }
            $this->password = md5($password);
            return true;
        }
        if (isset($_CONFIG['passwordComplexity']) && $_CONFIG['passwordComplexity'] == 'on') {
            $errorMsg = $_CORELANG['TXT_ACCESS_INVALID_PASSWORD_WITH_COMPLEXITY'];
        } else {
            $errorMsg = $_CORELANG['TXT_ACCESS_INVALID_PASSWORD'];
        }
        $this->error_msg[] = $errorMsg;
        return false;
    }


    /**
     * Set frontend language ID of user
     *
     * This will set the attribute frontend_lang_id of this object to $langId.
     * @param   integer   $langId
     * @return  void
     */
    public function setFrontendLanguage($langId)
    {
        $this->frontend_language = intval($langId);
        $this->validateLanguageId('frontend');
    }


    /**
     * Set backend language ID of user
     *
     * This will set the attribute backend_lang_id of this object to $langId.
     * @param   integer   $langId
     * @return  void
     */
    public function setBackendLanguage($langId)
    {
        $this->backend_language = intval($langId);
        $this->validateLanguageId('backend');
    }


    /**
     * Set active status of user
     *
     * This will set the attribute is_active of this object either
     * to TRUE or FALSE, depending of $status.
     * @param   boolean   $status
     * @return  void
     */
    public function setActiveStatus($status)
    {
        $this->is_active = (bool)$status;
    }


    /**
     * Set the Id of a user group that should be used as the user's primary group
     *
     * @param integer $groupId
     * @return void
     */
    public function setPrimaryGroup($groupId)
    {
        if (!isset($this->arrGroups)) {
            $this->arrGroups = $this->loadGroups();
        }
        if (in_array($groupId, $this->arrGroups)) {
            $this->primary_group = $groupId;
        } elseif (count($this->arrGroups)) {
            $this->primary_group = $this->arrGroups[0];
        } else {
            $this->primary_group = 0;
        }
    }


    /**
     * Set administration status of user
     *
     * This will set the attribute is_admin of this object to $status.
     * If $status is FALSE then it will only be accepted if this object
     * isn't the only administrator.
     * @param boolean $status
     * @global array
     * @return boolean
     */
    public function setAdminStatus($status)
    {
        global $_CORELANG;

        if ($status || !$this->isLastAdmin()) {
            $this->is_admin = (bool)$status;
            return true;
        }
        $this->error_msg[] = sprintf($_CORELANG['TXT_ACCESS_CHANGE_PERM_LAST_ADMIN_USER'], $this->getUsername());
        return false;
    }


    /**
     * Set ID's of groups to which this user should belong to
     * @see     UserGroup, UserGroup::getGroups(), UserGroup::getId()
     * @param   array   $arrGroups
     * @return void
     */
    public function setGroups($arrGroups)
    {
        $objFWUser = FWUser::getFWUserObject();
        $objGroup = $objFWUser->objGroup->getGroups(null,null,array());
        $this->arrGroups = array();
        while (!$objGroup->EOF) {
            if (in_array($objGroup->getId(), $arrGroups)) {
                $this->arrGroups[] = $objGroup->getId();
            }
            $objGroup->next();
        }
    }


    /**
     * Set ID's of newsletter-list the which the user subscribed to
     *
     * @param array $arrNewsletterListIDs
     * @return void
     */
    public function setSubscribedNewsletterListIDs($arrNewsletterListIDs)
    {
        $this->arrNewsletterListIDs = $arrNewsletterListIDs;
    }


    public function setEmailAccess($emailAccess)
    {
        $this->email_access = in_array($emailAccess, array_keys($this->arrPrivacyAccessTypes))
            ? $emailAccess : $this->defaultEmailAccessType;
    }


    public function setProfileAccess($profileAccess)
    {
        $this->profile_access = in_array($profileAccess, array_keys($this->arrPrivacyAccessTypes))
            ? $profileAccess : $this->defaultProfileAccessTyp;
    }


    /**
     * Returns true if the current User has the only active admin account
     * present in the system.
     *
     * Returns false if either
     *  - the current User is not an admin, or
     *  - there are at least two active admins present
     * Note that true is returned if the database query fails, so the User
     * will not be allowed to be deleted.  You might have a whole different
     * kind of problem in that case anyway.
     * @global  ADONewConnection
     * @return  boolean
     */
    private function isLastAdmin()
    {
        global $objDatabase;

        if (!$this->is_admin) return false;
        $objResult = $objDatabase->Execute('
            SELECT COUNT(*) AS `numof_admin`
              FROM `'.DBPREFIX.'access_users`
             WHERE `is_admin`=1
               AND `active`=1');
        // If the query fails, assume that he's the last one.
        if (!$objResult) return true;
        return ($objResult->fields['numof_admin'] < 2);
    }


    /**
     * Returns true if $email is a unique e-mail address in the system
     * @param   string    $email
     * @param   integer   $id
     * @return  boolean
     * @static
     */
    public static function isUniqueEmail($email, $id=0)
    {
        global $objDatabase;

        self::removeOutdatedAccounts();
        $objResult = $objDatabase->SelectLimit("
            SELECT 1
              FROM ".DBPREFIX."access_users
             WHERE email='".addslashes($email)."'
               AND id!=$id", 1);
        return ($objResult && $objResult->RecordCount() == 0);
    }


    /**
     * Returns true if $username is a unique user name
     *
     * Returns false if the test for uniqueness fails, or if the $username
     * exists already.
     * If non-empty, the given User ID is excluded from the search, so the
     * User does not match herself.
     * @param   string    $username   The username to test
     * @param   integer   $id         The optional current User ID
     * @return  boolean               True if the username is available,
     *                                false otherwise
     * @static
     */
    protected static function isUniqueUsername($username, $id=0)
    {
        global $objDatabase;

        self::removeOutdatedAccounts();
        $objResult = $objDatabase->SelectLimit("
            SELECT 1
              FROM ".DBPREFIX."access_users
             WHERE username='".addslashes($username)."'
               AND id!=$id", 1);
        return ($objResult && $objResult->RecordCount() == 0);
    }


    /**
     * Returns true if the given $username is valid
     * @param   string    $username
     * @return  boolean
     * @static
     */
    public static function isValidUsername($username)
    {
        if (preg_match('/^[a-zA-Z0-9-_]*$/', $username)) {
            return true;
        }
// For version 2.3, inspired by migrating Shop Customers to Users:
// In addition to the above, also accept usernames that look like valid
// e-mail addresses
// TODO: Maybe this should be restricted to MODULE_ID == 16 (Shop)?
        if (FWValidator::isEmail($username)) {
            return true;
        }
        return false;
    }


    /**
     * Returns true if the given $password is valid
     * @param   string    $password
     * @return  boolean
     */
    public static function isValidPassword($password)
    {
        global $_CONFIG;

        if (strlen($password) >= 6) {
            if (isset($_CONFIG['passwordComplexity']) && $_CONFIG['passwordComplexity'] == 'on') {
                // Password must contain the following characters: upper, lower case and numbers
                if (!preg_match('/[A-Z]+/', $password) || !preg_match('/[a-z]+/', $password) || !preg_match('/[0-9]+/', $password)) {
                    return false;
                }
            }
            return true;
        }
        return false;
    }


    public function isAllowedToChangeEmailAccess()
    {
        if ($this->getAdminStatus()) {
            return true;
        }
        $arrSettings = User_Setting::getSettings();
        return $arrSettings['user_config_email_access']['status'];
    }


    public function isAllowedToChangeProfileAccess()
    {
        if ($this->getAdminStatus()) {
            return true;
        }
        $arrSettings = User_Setting::getSettings();
        return $arrSettings['user_config_profile_access']['status'];
    }


    public function isAllowedToDeleteAccount()
    {
        $arrSettings = User_Setting::getSettings();
        return $arrSettings['user_delete_account']['status'];
    }


    /**
     * Returns the e-mail address if the User accounts has been created
     * by the Shop.
     *
     * Such accounts have e-mail addresses that look like
     * "shop_customer_$orderId_$productId_$instance-$email"
     * Note that this is a temporary workaround and will be changed in
     * a future release.
     * @todo    All affected customers *MUST* be migrated properly from
     *          the Shop to the User administration
     * @return  string            The e-mail address if the account was
     *                            autocreated by the Shop, the empty string
     *                            otherwise.
     */
    private function getShopUserEmail()
    {
        $email = array();
        if (preg_match(
            '/^shop_customer_[0-9]+_[0-9]+_[0-9]-(.+)$/', $this->email, $email)) {
            return $email[1];
        }
        return '';
    }

    /**
     * Checks whether the user account is connected with a crm customer
     *
     * @return int|null id of crm user if the user is associated with a customer of crm module
     */
    public function getCrmUserId() {
        /**
         * @var \Cx\Core\Core\Controller\Cx $cx
         */
        $cx = \Env::get('cx');
        if (!$cx->getLicense()->isInLegalComponents('crm')) {
            return false;
        }
        $db = $cx->getDb()->getAdoDb();
        $result = $db->SelectLimit("SELECT `id` FROM `" . DBPREFIX . "module_crm_contacts` WHERE `user_account` = " . intval($this->id), 1);
        if ($result->RecordCount() == 0) {
            return null;
        }
        return $result->fields['id'];
    }


    /**
     * Tries to form a valid and unique username from the words given
     *
     * Usually, you would use first and last names as parameters.
     * @return    string                The new user name on success,
     *                                  false otherwise
     */
    static function make_username($word1, $word2)
    {
//echo("User::makeUsername($word1, $word2): Entered<br />");
        // Just letters, please
        $word1 = preg_replace('/[^a-z]/i', '', $word1);
        $word2 = preg_replace('/[^a-z]/i', '', $word2);
        $usernames = array(
            $word2, "$word1$word2", "${word1}_$word2", "$word1.$word2", $word1,
        );
        $suffix = '';
        while (true) {
            foreach ($usernames as $username) {
//echo("Username /$username/$suffix/ ");
                if (!self::isValidUsername($username.$suffix)) {
//echo("not valid<br />");
                    continue;
                }
                if (!self::isUniqueUsername($username.$suffix)) {
//echo("not unique<br />");
                    continue;
                }
//echo("OK<br />");
                return $username.$suffix;
            }
            // Note that this method will run for a long time, or even
            // forever, for very common names.
            $suffix = intval(mt_rand(0, 99));
        }
        // Never reached
        return null;
    }


    /**
     * Returns a valid password
     *
     * Generated passwords consist of
     *  - at most 4 lower caps letters [qwertzupasdfghjkyxcvbnm],
     *  - at most 4 upper caps letters [QWERTZUPASDFGHJKLYXCVBNM],
     *  - at most 2 digits [23456789], and
     *  - at most 1 special character [-+_!?%&], if enabled.
     * If $length is less than 6, the length will be 6 characters.
     * If $length is bigger than 8, the length will be 8 characters.
     * @param     integer   $length       Desired password length,
     *                                    6 to 8 characters.  Defaults to 8
     * @param     boolean   $use_special  Use "special" characters [-+_!?%&]
     *                                    if true.  Defaults to false
     * @return    string                  The new password
     */
    static function make_password($length=8, $use_special=false)
    {
        static $lower = 'qwertzupasdfghjkyxcvbnm';
        static $upper = 'QWERTZUPASDFGHJKLYXCVBNM';
        static $digit = '23456789';
        static $special = '-+_!?%&';

        $length = min(max($length, 6), 8);
        while (true) {
            $password = '';
            $have_lower = 0;
            $have_upper = 0;
            $have_digit = 0;
            $have_other = 0;
            while (strlen($password) < $length) {
                if ($have_lower < 4 && mt_rand(0, 6) < 2) {
                    $password .= substr($lower, mt_rand(0, strlen($lower))-1, 1);
                    ++$have_lower;
                    continue;
                }
                if ($have_upper < 4 && mt_rand(0, 6) < 2) {
                    $password .= substr($upper, mt_rand(0, strlen($upper))-1, 1);
                    ++$have_upper;
                    continue;
                }
                if ($have_digit < 2 && mt_rand(0, 6) < 1) {
                    $password .= substr($digit, mt_rand(0, strlen($digit))-1, 1);
                    ++$have_digit;
                    continue;
                }
                if ($use_special && $have_other < 1 && mt_rand(0, 6) < 1) {
                    $password .= substr($special, mt_rand(0, strlen($special))-1, 1);
                    ++$have_other;
                }
            }
            if (self::isValidPassword($password)) return $password;
        }
        // Never reached
        return null;
    }


    /**
     * Set the active status of one or more Users
     *
     * The $mix_user_id parameter may either be a user ID or an array thereof.
     * Sets appropriate messages.
     * @param   mixed   $mix_user_id        The User ID or an array of those
     * @param   boolean $active             Activate (true) or deactivate
     *                                      (false) the User(s).
     * @return  void
     */
    static function set_active($mix_user_id, $active)
    {
        global $_CORELANG;

        if (empty($mix_user_id)) return;
        if (!is_array($mix_user_id)) {
            $mix_user_id = array($mix_user_id);
        }
        $count = 0;
        global $objFWUser;
        $objUser = $objFWUser->objUser;
        foreach ($mix_user_id as $user_id) {
            $objUser = $objUser->getUser($user_id);
            if (!$objUser) {
                Message::warning(sprintf(
                    $_CORELANG['TXT_ACCESS_NO_USER_WITH_ID'], $user_id));
                continue;
            }
//$objUser = new User();
            $objUser->setActiveStatus($active);
            if (!$objUser->store()) {
                Message::warning(sprintf(
                    $_CORELANG['TXT_SHOP_ERROR_CUSTOMER_UPDATING'], $user_id));
                continue;
            }
            ++$count;
        }
        if ($count) {
            Message::ok(
                $_CORELANG['TXT_ACCESS_USER_ACCOUNT'.
                ($count > 1 ? 'S' : '').'_'.
                ($active ? '' : 'DE').'ACTIVATED']);
        }
        return;
    }

}
