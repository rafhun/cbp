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
 * Main controller for ContentManager
 * 
 * At the moment, this is just an empty ComponentController in order to load
 * YAML files via component framework
 * @author Michael Ritter <michael.ritter@comvation.com>
 * @package contrexx
 * @subpackage core_contentmanager
 */

namespace Cx\Core\ContentManager\Controller;

/**
 * Main controller for ContentManager
 * 
 * At the moment, this is ComponentController is just used to load
 * YAML files and JsonAdapters via component framework
 * @author Michael Ritter <michael.ritter@comvation.com>
 * @package contrexx
 * @subpackage core_contentmanager
 */
class ComponentController extends \Cx\Core\Core\Model\Entity\SystemComponentController {
    
    public function __construct(\Cx\Core\Core\Model\Entity\SystemComponent $systemComponent, \Cx\Core\Core\Controller\Cx $cx) {
        parent::__construct($systemComponent, $cx);
        $evm = $cx->getEvents();
        $pageListener = new \Cx\Core\ContentManager\Model\Event\PageEventListener();
        $evm->addModelListener(\Doctrine\ORM\Events::prePersist, 'Cx\\Core\\ContentManager\\Model\\Entity\\Page', $pageListener);
        $evm->addModelListener(\Doctrine\ORM\Events::postPersist, 'Cx\\Core\\ContentManager\\Model\\Entity\\Page', $pageListener);
        $evm->addModelListener(\Doctrine\ORM\Events::preUpdate, 'Cx\\Core\\ContentManager\\Model\\Entity\\Page', $pageListener);
        $evm->addModelListener(\Doctrine\ORM\Events::postUpdate, 'Cx\\Core\\ContentManager\\Model\\Entity\\Page', $pageListener);
        $evm->addModelListener(\Doctrine\ORM\Events::preRemove, 'Cx\\Core\\ContentManager\\Model\\Entity\\Page', $pageListener);
        $evm->addModelListener(\Doctrine\ORM\Events::postRemove, 'Cx\\Core\\ContentManager\\Model\\Entity\\Page', $pageListener);
        $evm->addModelListener(\Doctrine\ORM\Events::onFlush, 'Cx\\Core\\ContentManager\\Model\\Entity\\Page', $pageListener);
        
        $nodeListener = new \Cx\Core\ContentManager\Model\Event\NodeEventListener();
        $evm->addModelListener(\Doctrine\ORM\Events::preRemove, 'Cx\\Core\\ContentManager\\Model\\Entity\\Node', $nodeListener);
        $evm->addModelListener(\Doctrine\ORM\Events::onFlush, 'Cx\\Core\\ContentManager\\Model\\Entity\\Node', $nodeListener);
        
        $evm->addModelListener(\Doctrine\ORM\Events::onFlush, 'Cx\\Core\\ContentManager\\Model\\Entity\\LogEntry', new \Cx\Core\ContentManager\Model\Event\LogEntryEventListener());
        
    }

    public function getControllersAccessableByJson() {
        return array(
            'JsonNode', 'JsonPage', 'JsonContentManager',
        );
    }
}
