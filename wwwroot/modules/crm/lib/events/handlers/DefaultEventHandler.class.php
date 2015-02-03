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
 * DefaultEventHandler Class CRM
 *
 * @category   DefaultEventHandler
 * @package    contrexx
 * @subpackage module_crm
 * @author     SoftSolutions4U Development Team <info@softsolutions4u.com>
 * @copyright  2012 and CONTREXX CMS - COMVATION AG
 * @license    trial license
 * @link       www.contrexx.com
 */

/**
 * DefaultEventHandler Class CRM
 *
 * @category   DefaultEventHandler
 * @package    contrexx
 * @subpackage module_crm
 * @author     SoftSolutions4U Development Team <info@softsolutions4u.com>
 * @copyright  2012 and CONTREXX CMS - COMVATION AG
 * @license    trial license
 * @link       www.contrexx.com
 */
class DefaultEventHandler implements EventHandler
{
    /**
     * Default Information
     *
     * @access protected
     * @var array
     */
    protected $default_info = array(
        'section'   => 'crm'
    );

    /**
     * Event handler
     * 
     * @param Event $event calling event
     *
     * @return boolean
     */
    function handleEvent(Event $event)
    {
        $info          = $event->getInfo();
        $substitutions = isset($info['substitution']) ? $info['substitution'] : array();
        $lang_id       = isset($info['lang_id']) ? $info['lang_id'] : FRONTEND_LANG_ID;
        $arrMailTemplate = array_merge(
            $this->default_info,
            array(
                'key'          => $event->getName(),
                'lang_id'      => $lang_id, 
                'substitution' => $substitutions,
        ));

        if (false === MailTemplate::send($arrMailTemplate)) {
            $event->cancel();
            return false;
        };
        return true;
    }
}

