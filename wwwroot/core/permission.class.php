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
 * Permission
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Comvation Development Team <info@comvation.com>
 * @version     1.0.0
 * @package     contrexx
 * @subpackage  core
 * @todo        Edit PHP DocBlocks!
 */

/**
 * Permission
 *
 * Checks the permission of the public and backend cms
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Comvation Development Team <info@comvation.com>
 * @access      public
 * @version     1.0.0
 * @package     contrexx
 * @subpackage  core
 * @static
 */
class Permission
{
    /**
     * Check access
     *
     * Check if the user has the required access id
     *
     * @access public
     * @param integer $accessId
     * @param string $type
     * @return boolean
     */
    public static function checkAccess($accessId, $type, $return=false)
    {
        if ($accessId === 0 && $type == 'static') {
            return true;
        }
        $objFWUser = FWUser::getFWUserObject();
        if ($objFWUser->objUser->login() &&
            (
                $objFWUser->objUser->getAdminStatus() ||
                $type == 'static' && in_array($accessId, $objFWUser->objUser->getStaticPermissionIds()) ||
                $type == 'dynamic' && in_array($accessId, $objFWUser->objUser->getDynamicPermissionIds())
            )
        ) {
            return true;
        }
        if ($return) {
            return false;
        }
        Permission::noAccess();
    }

    /**
     * Checks if the current user is a super user.
     *
     * @return boolean TRUE if the user is a super user, otherwise FALSE
     */
    public static function hasAllAccess()
    {
        $objFWUser = FWUser::getFWUserObject();
        if ($objFWUser->objUser->login() && $objFWUser->objUser->getAdminStatus()) {
            return true;
        }
        return false;
    }

    /**
     * Redirects the browser to the noaccess webpage.
     *
     * @return void
     */
    public static function noAccess($redirect = null)
    {
        global $objInit;

        $objFWUser = FWUser::getFWUserObject();
        CSRF::header('Location: '.CONTREXX_DIRECTORY_INDEX.'?'.($objInit->mode == 'backend' ? '' : 'section=login&'.(!empty($redirect) ? 'redirect='.$redirect.'&' : '')).($objFWUser->objUser->login() ? 'cmd=noaccess' : ''));
        exit;
    }

    /**
     * Set access permission to either a single or a bunch of particular groups.
     *
     * @param $accessId     integer Affected Access-ID
     * @param $type         string  Permission type, which is either 'static' or 'dynamic'
     * @param $groupId      mixed   Either a single ID as integer or an array of ID's
     * @return boolean      TRUE on success, FALSE on failure.
     */
    public static function setAccess($accessId, $type, $groupId)
    {
        global $objDatabase;

        return (bool) $objDatabase->Execute('INSERT IGNORE INTO `'.DBPREFIX.'access_group_'.$type.'_ids` (`access_id`, `group_id`) VALUES ('.$accessId.', '.(is_array($groupId) ? implode('),('.$accessId.',', $groupId) : $groupId).')');
    }

    /**
     * Generates a new dynamic access-ID
     *
     * @return mixed    Returns the newly created dynamic access-ID or FALSE on failure.
     */
    public static function createNewDynamicAccessId()
    {
        global $objDatabase, $_CONFIG;

        $lastAccessId = $_CONFIG['lastAccessId'];
        $newAccessId = $_CONFIG['lastAccessId'] + 1;

        $objSettings = new settingsManager();
        if ($objSettings->isWritable()) {
            if ($objDatabase->Execute("UPDATE `".DBPREFIX."settings` SET `setvalue` = ".$newAccessId." WHERE `setname` = 'lastAccessId'")
                && $objSettings->writeSettingsFile()
            ) {
                $_CONFIG['lastAccessId'] = $newAccessId;
                return $newAccessId;
            } else {
                $objDatabase->Execute("UPDATE `".DBPREFIX."settings` SET `setvalue` = ".$lastAccessId." WHERE `setname` = 'lastAccessId'");
            }
        }        

        return false;
    }

    /**
     * Remove access permission for either a single or a bunch of particular groups, in case the $groupId is specified, or otherwise for every group.
     *
     * @param $accessId integer Affected Access-ID
     * @param $type     string  Permission type, which is either 'static' or 'dynamic'
     * @param $groupId  mixed   Either a single ID as integer or an array of ID's
     * @return boolean  TRUE on success, FALSE on failure.
     */
    public static function removeAccess($accessId, $type, $groupId = null)
    {
        global $objDatabase;

        return (bool) $objDatabase->Execute('DELETE FROM `'.DBPREFIX.'access_group_'.$type.'_ids` WHERE `access_id` = '.$accessId.(isset($groupId) ? ' AND `group_id` IN ('.(is_array($groupId) ? implode(',', $groupId) : $groupId).')' : ''));
    }
    
    public static function getGroupIdsForAccessId($accessId) {
        global $objDatabase;

        $query = 'SELECT group_id
            FROM '.DBPREFIX.'access_group_dynamic_ids
            WHERE access_id='.$accessId;
        $rs = $objDatabase->Execute($query);
        if($rs === false) {
            return false;
        }
        
        $ids = array();
        while(!$rs->EOF) {
            $ids[] = $rs->fields['group_id'];
            $rs->MoveNext();
        }

        return $ids;
    }

    /**
     * Returns an array of all front- or backend groups
     * @param boolean $frontend True for frontend access groups, false for backend
     * @return mixed Array (id=>name) or false on error
     */
    public static function getGroups($frontend) {
        global $objDatabase;

        $type = 'frontend';
        if (!$frontend) {
            $type = 'backend';
        }

        $query = "SELECT group_id, group_name FROM ".DBPREFIX."access_user_groups WHERE type='".$type."' ORDER BY group_name";
        $rs = $objDatabase->Execute($query);
        if ($rs == false) {
            return false;
        }

        $groups = array();
        while (!$rs->EOF) {
            $groups[$rs->fields['group_id']] = $rs->fields['group_name'];
            $rs->MoveNext();
        }
        return $groups;
    }
}

?>
