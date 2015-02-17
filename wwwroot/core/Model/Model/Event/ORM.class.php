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
 * Wrapper class for the Gedmo\Loggable\Mapping\Event\Adapter\ORM
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      ss4u <ss4u.comvation@gmail.com>
 * @version     3.1.2
 * @package     contrexx
 * @subpackage  core 
 */

namespace Cx\Core\Model\Model\Event;

use Gedmo\Mapping\Event\Adapter\ORM as BaseAdapterORM;
use Gedmo\Loggable\Mapping\Event\LoggableAdapter;

/**
 * Wrapper class for the Gedmo\Loggable\Mapping\Event\Adapter\ORM
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      ss4u <ss4u.comvation@gmail.com>
 * @version     $Id:    Exp $
 * @package     contrexx
 * @subpackage  core
 */
final class ORM extends BaseAdapterORM implements LoggableAdapter
{
    /**
     * {@inheritDoc}
     */
    public function getDefaultLogEntryClass()
    {
        return 'Gedmo\\Loggable\\Entity\\LogEntry';
    }

    /**
     * {@inheritDoc}
     */    
    public function getNewVersion($meta, $object) {
        
        $em = $this->getObjectManager();
        $objectMeta = $em->getClassMetadata(get_class($object));
        $identifierField = $this->getSingleIdentifierFieldName($objectMeta);
        $objectId = $objectMeta->getReflectionProperty($identifierField)->getValue($object);

        $dql = "SELECT MAX(log.version) FROM {$meta->name} log";
        $dql .= " WHERE log.objectId = :objectId";
        $dql .= " AND log.objectClass = :objectClass";

        $q = $em->createQuery($dql);
        $q->setParameters(array(
            'objectId' => $objectId,
            'objectClass' => $objectMeta->name
        ));
        $q->useResultCache(false);
        
        return $q->getSingleScalarResult() + 1;
        
    }
}
