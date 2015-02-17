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
 * Recommend module
 *
 * Library for the recommend module
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author Comvation Development Team <info@comvation.com>
 * @access public
 * @version 1.0.0
 * @package     contrexx
 * @subpackage  module_recommend
 * @todo        Edit PHP DocBlocks!
 */

/**
 * Recommend module
 *
 * Library for the recommend module
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author Comvation Development Team <info@comvation.com>
 * @access public
 * @version 1.0.0
 * @package     contrexx
 * @subpackage  module_recommend
 * @todo        Edit PHP DocBlocks!
 */
class RecommendLibrary
{
    /**
     * Get message body
     *
     * Reads the message body out of the database
     *
     * @return string body
     */
    function getMessageBody($lang)
    {
        global $objDatabase;

        $query = "SELECT value FROM ".DBPREFIX."module_recommend WHERE name = 'body' AND lang_id = $lang";
        $objResult = $objDatabase->Execute($query);
        if (!$objResult->EOF) {
            return stripslashes($objResult->fields['value']);
        } else {
            return $this->getStandardBody();
        }
    }

    /**
     * Get subject
     *
     * @return string subject
     */
    function getMessageSubject($lang)
    {
        global $objDatabase, $_FRONTEND_LANGID;

        $query = "SELECT value FROM ".DBPREFIX."module_recommend WHERE name = 'subject' AND lang_id = $lang";
        $objResult = $objDatabase->Execute($query);
        if (!$objResult->EOF) {
            return stripslashes($objResult->fields['value']);
        } else {
            return $this->getStandardSubject();
        }
    }

    /**
     * Get female salutation
     *
     * Returns the saved salutation for females
     */
    function getFemaleSalutation($lang)
    {
        global $objDatabase, $_FRONTEND_LANGID;

        $query = "SELECT value FROM ".DBPREFIX."module_recommend WHERE name = 'salutation_female' AND lang_id = $lang";
        $objResult = $objDatabase->Execute($query);
        if (!$objResult->EOF) {
            return stripslashes($objResult->fields['value']);
        } else {
            return "Dear";
        }
    }


    /**
     * Get female salutation
     *
     * Returns the saved salutation for females
     */
    function getMaleSalutation($lang)
    {
        global $objDatabase, $_FRONTEND_LANGID;

        $query = "SELECT value FROM ".DBPREFIX."module_recommend WHERE name = 'salutation_male' AND lang_id = $lang";
        $objResult = $objDatabase->Execute($query);
        if (!$objResult->EOF) {
            return stripslashes($objResult->fields['value']);
        } else {
            return "Dear";
        }
    }


    /**
     * Get standard body
     *
     * Returns the standard (english) body
     */
    function getStandardBody()
    {
        return "<SALUTATION> <RECEIVER_NAME>

<SENDER_NAME> (<SENDER_MAIL>) recommends following webpage:

<URL>

Comment of <SENDER_NAME>:

<COMMENT>";
    }


    /**
     * Get standard subject
     *
     * Returns the standard (english) subject
     */
    function getStandardSubject()
    {
        return  "Webpage recommendation from <SENDER_NAME>";
    }
}

?>
