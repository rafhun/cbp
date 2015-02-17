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

namespace Cx\Lib\User;

/**
 * User Networks
 *
 * The user object which contains the handling of other services the user is connected with.
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Ueli Kramer <ueli.kramer@comvation.com>
 * @version     1.0.0
 * @package     contrexx
 * @subpackage  lib_framework
 */
class User_Networks
{
    /**
     * @var array the networks the user is connected with
     */
    private $networks = array();

    /**
     * @var null|int the user id
     */
    private $userId = null;

    public function __construct($userId = null)
    {
        global $objDatabase;
        $this->userId = $userId;
        if (!empty($userId)) {
            $objResult = $objDatabase->Execute("SELECT `id`,
                                                        `oauth_provider`,
                                                        `oauth_id`
                                                FROM `" . DBPREFIX . "access_user_network`
                                                WHERE `user_id` = ?", array($userId));
            if ($objResult !== false) {
                while (!$objResult->EOF) {
                    $this->networks[$objResult->fields['oauth_provider']] = $objResult->fields;
                    $objResult->MoveNext();
                }
            }
        }
    }

    /**
     * Add or update the data of a network for the current user
     *
     * @param string $oauth_provider the name of the provider
     * @param string $oauth_id the user's id on the network
     * @return bool were the data saved successfully
     */
    public function setNetwork($oauth_provider, $oauth_id)
    {
        $this->networks[$oauth_provider] = array(
            'oauth_id' => $oauth_id,
        );
    }

    /**
     * Saves the current network array to the database
     *
     * @return bool
     */
    public function save()
    {
        global $objDatabase;
        foreach ($this->networks as $oauth_provider => $providerData) {
            if (empty($providerData['id'])) {
                $query = "INSERT INTO `" . DBPREFIX . "access_user_network`
                            (`oauth_provider`, `oauth_id`, `user_id`) VALUES (?, ?, ?)";
                $replacement = array($oauth_provider, $providerData['oauth_id'], $this->userId);
            } else {
                $query = "UPDATE `" . DBPREFIX . "access_user_network`
                            SET `oauth_provider` = ?, `oauth_id` = ?, `user_id` = ?
                      WHERE `user_id` = ? AND `oauth_provider` = ?";
                $replacement = array($oauth_provider, $providerData['oauth_id'], $this->userId, $this->userId, $oauth_provider);
            }

            $objDatabase->Execute($query, $replacement);
        }
        return true;
    }

    /**
     * Disconnect from a network
     *
     * @param string $oauth_provider the name of the provider to disconnect from
     */
    public function deleteNetwork($oauth_provider)
    {
        global $objDatabase;
        if (!empty($this->networks[$oauth_provider])) {
            $objDatabase->Execute("DELETE FROM `" . DBPREFIX . "access_user_network` WHERE `user_id` = " . intval($this->userId) . " AND `oauth_provider` = '" . contrexx_raw2db($oauth_provider) . "'");
            unset($this->networks[$oauth_provider]);
        }
    }

    /**
     * Get all networks as array
     *
     * @return array
     */
    public function getNetworksAsArray()
    {
        return $this->networks;
    }
}
