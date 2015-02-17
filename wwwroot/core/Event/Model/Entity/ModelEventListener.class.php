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
 * Model event listener
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  core_event
 */

namespace Cx\Core\Event\Model\Entity;

/**
 * Model event listener
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  core_event
 */

class ModelEventListener implements EventListener {
    protected $entityClass = null;
    protected $listener = null;
    
    public function __construct($event, $entityClass, $listener) {
        if (!is_callable($listener) && !($listener instanceof \Cx\Core\Event\Model\Entity\EventListener)) {
            throw new \Cx\Core\Event\Controller\EventManagerException('Listener must be callable or implement EventListener interface!');
        }
        $this->entityClass = $entityClass;
        $this->listener = $listener;
    }
    
    public function onEvent($eventName, $eventArgs) {
        $eventArgs = current($eventArgs);
        if (
            $eventArgs instanceof \Doctrine\ORM\Event\LifecycleEventArgs &&
            get_class($eventArgs->getEntity()) != $this->entityClass &&
            get_class($eventArgs->getEntity()) != 'Cx\\Model\\Proxies\\' . str_replace('\\', '', $this->entityClass) . 'Proxy'
        ) {
            return;
        }
        $eventName = substr($eventName, 6);
        if (is_callable($this->listener)) {
            $listener = $this->listener;
            $listener($eventName, array($eventArgs));
        } else {
            $this->listener->onEvent($eventName, array($eventArgs));
        }
    }
}
