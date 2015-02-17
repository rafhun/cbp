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
 * Module
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  core
 */

/**
 * ModuleException
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  core
 */
class ModuleException extends Exception {}

/**
 * Module
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  core
 */
class Module {
    protected $defaultAct = '';

    protected $act = '';
    /**
     *
     * @var \Cx\Core\Html\Sigma
     */
    protected $template = null;

    public function __construct($act, $template) {
        $this->act = $act;
        $this->template = $template;
	}

    public function getPage() {
        if($this->act == '') {
            $this->act = $this->defaultAct;
        }

        /*
         * TODO: Carify with Severin why an act method must start with 'act'.
         * (Manuel, Florian, Thomas) decided to remove this, as no benefit can be seen from this constraint.
         */
        //prevent execution of non-act methods.
        /*if(substr($this->act, 0, 3) != 'act') {
            throw new ModuleException('acts start with "act", "' . $this->act . '" given');
        }*/

        //call the right act.
        $act = $this->act;
        if(method_exists($this, $act))
            $this->$act();
        else
            throw new ModuleException('unknown act: "' . $this->act . '"');
    }
}
