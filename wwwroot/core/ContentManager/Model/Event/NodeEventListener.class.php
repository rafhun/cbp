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
 * This listener ensures tree consistency on Node objects.
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  model_events
 */

namespace Cx\Core\ContentManager\Model\Event;

use \Cx\Core\ContentManager\Model\Entity\Page as Page;
use Doctrine\Common\Util\Debug as DoctrineDebug;

/**
 * NodeEventListenerException
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  model_events
 */
class NodeEventListenerException extends \Exception {}

/**
 * NodeEventListener
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  model_events
 */
class NodeEventListener implements \Cx\Core\Event\Model\Entity\EventListener {
    
    public function preRemove($eventArgs) {
        $em      = $eventArgs->getEntityManager();
        $uow     = $em->getUnitOfWork();
        $entity  = $eventArgs->getEntity();
        $nodeRepo = $em->getRepository('Cx\Core\ContentManager\Model\Entity\Node');
        $pages = $entity->getPages(true);

        foreach ($pages as $page) {
            // NOTE: aliases will be removed when this hook is triggered again
            //       by the removal process of the page (see below)
            $em->remove($page);
            $uow->computeChangeSet(
                $em->getClassMetadata('Cx\Core\ContentManager\Model\Entity\Page'),
                $page
            );
        }

        // NOTE: removeFromTree() will manually remove $entity from the database using DQL.
        //       Additionally, it will detach/remove $entity from UnitOfWork,
        //       which will UnitOfWork cause to skip the final remove() operation on $entity
        //       to prevent causing an issue with the already removed $entity.
        
        // remove all child nodes
        foreach ($entity->getChildren() as $childNode) {
            $em->remove($childNode);
        }
        $nodeRepo->removeFromTree($entity);
    }
    
    public function onFlush($eventArgs) {}

    public function onEvent($eventName, $eventArgs) {
        $this->$eventName(current($eventArgs));
    }
}
