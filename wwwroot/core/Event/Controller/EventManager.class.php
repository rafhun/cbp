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
 * Event manager
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  core_event
 */

namespace Cx\Core\Event\Controller;

/**
 * Event manager exception
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  core_event
 */

class EventManagerException extends \Exception {}

/**
 * Event manager
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  core_event
 */

class EventManager {
    protected $listeners = array();
    
    public function addEvent($eventName) {
        if (isset($this->listeners[$eventName])) {
            throw new EventManagerException('An event with this name is already added (' . $eventName . ')');
        }
        $this->listeners[$eventName] = array();
    }
    
    public function triggerEvent($eventName, $eventArgs = array()) {
        if (!isset($this->listeners[$eventName])) {
            throw new EventManagerException('No such event "' . $eventName . '"');
        }
        foreach ($this->listeners[$eventName] as $listener) {
            if (is_callable($listener)) {
                $listener($eventName, $eventArgs);
            } else {
                $listener->onEvent($eventName, $eventArgs);
            }
        }
    }
    
    public function addEventListener($eventName, $listener) {
        if (!isset($this->listeners[$eventName])) {
            throw new EventManagerException('No such event "' . $eventName . '"');
        }
        if (in_array($listener, $this->listeners, true)) {
            throw new EventManagerException('Cannot re-register event handler');
        }
        if (!is_callable($listener) && !($listener instanceof \Cx\Core\Event\Model\Entity\EventListener)) {
            throw new EventManagerException('Listener must be callable or implement EventListener interface!');
        }
        $this->listeners[$eventName][] = $listener;
    }
    
    public function addModelListener($eventName, $entityClass, $listener) {
        $this->addEventListener('model/' . $eventName, new \Cx\Core\Event\Model\Entity\ModelEventListener($eventName, $entityClass, $listener));
    }
}
