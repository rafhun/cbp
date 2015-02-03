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
 * Repository for SystemComponents
 *
 * This decorates SystemComponents with SystemComponentController class
 *
 * @copyright   Comvation AG
 * @author      Michael Ritter <michael.ritter@comvation.com>
 * @package     contrexx
 * @subpackage  core_core
 * @version     3.1.0
 */

namespace Cx\Core\Core\Model\Repository;

/**
 * Repository for SystemComponents
 * 
 * This decorates SystemComponents with SystemComponentController class
 *
 * @copyright   Comvation AG
 * @author      Michael Ritter <michael.ritter@comvation.com>
 * @package     contrexx
 * @subpackage  core_core
 * @version     3.1.0
 */
class SystemComponentRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * List of loaded (and decorated) components
     * @var array 
     */
    protected $loadedComponents = array();
    
    /**
     * Main class instance
     * @var \Cx\Core\Core\Controller\Cx
     */
    protected $cx = null;
    
    /**
     * Initialize repository
     * @param \Doctrine\ORM\EntityManager $em Doctrine entity manager
     * @param \Doctrine\ORM\Mapping\ClassMetadata $class Metadata of entity class handled by this repository
     */
    public function __construct(\Doctrine\ORM\EntityManager $em, \Doctrine\ORM\Mapping\ClassMetadata $class) {
        parent::__construct($em, $class);
        $this->cx = \Env::get('cx');
    }
    
    /**
     * Finds an entity by its primary key / identifier.
     * 
     * Overwritten in order to decorate result
     * @param int $id The identifier.
     * @param int $lockMode
     * @param int $lockVersion
     * @return \Cx\Core\Core\Model\Entity\SystemComponentController The entity.
     */
    public function find($id, $lockMode = LockMode::NONE, $lockVersion = null) {
        return $this->decorate(parent::find($id, $lockMode, $lockVersion));
    }
    
    /**
     * Finds all entities in the repository.
     *
     * Overwritten in order to decorate result
     * @return array The entities.
     */
    public function findAll() {
        return $this->decorate(parent::findAll());
    }

    /**
     * Finds all active entities in the repository.
     *
     * @return array The active entities.
     */
    public function findActive() {
        $activeComponents = array();
        $components = $this->findAll();

        if (is_array($components)) {
            foreach ($components as $component) {
                if ($component->isActive()) {
                    $activeComponents[] = $component;
                }
            }
        }

        return $activeComponents;
    }

    /**
     * Finds entities by a set of criteria.
     *
     * Overwritten in order to decorate result
     * @param array $criteria
     * @return array
     */
    public function findBy(array $criteria) {
        return $this->decorate(parent::findBy($criteria));
    }
    
    /**
     * Finds a single entity by a set of criteria.
     *
     * Overwritten in order to decorate result
     * @param array $criteria
     * @return \Cx\Core\Core\Model\Entity\SystemComponentController The entity.
     */
    public function findOneBy(array $criteria) {
        return $this->decorate(parent::findOneBy($criteria));
    }
    
    /**
     * Decorates an entity or an array of entities
     * @param mixed $components SystemComponent or array of SystemComponents
     * @return mixed SystemComponentController or array of SystemComponentControllers
     */
    protected function decorate($components) {
        if (!$components) {
            return $components;
        }
        
        if (!is_array($components)) {
            $yamlDir = $this->cx->getClassLoader()->getFilePath($components->getDirectory(false).'/Model/Yaml');
            if (file_exists($yamlDir)) {
                $this->cx->getDb()->addSchemaFileDirectories(array($yamlDir));
            }
            $entity = $this->decorateEntity($components);
            return $entity;
        }
        
        $yamlDirs = array();
        foreach ($components as $component) {
            if (isset($this->loadedComponents[$component->getId()])) {
                continue;
            }
            $yamlDir = $this->cx->getClassLoader()->getFilePath($component->getDirectory(false).'/Model/Yaml');
            if ($yamlDir) {
                $yamlDirs[] = $yamlDir;
            }
        }
        
        $this->cx->getDb()->addSchemaFileDirectories($yamlDirs);
        foreach ($components as &$component) {
            if (isset($this->loadedComponents[$component->getId()])) {
                $component = $this->loadedComponents[$component->getId()];
                continue;
            }
            $component = $this->decorateEntity($component);
            \Cx\Core\Json\JsonData::addAdapter($component->getControllersAccessableByJson(), $component->getNamespace() . '\\Controller');
        }
        return $components;
    }
    
    /**
     * Decorates a single entity
     * @param \Cx\Core\Core\Model\Entity\SystemComponent $component
     * @return \Cx\Core\Core\Model\Entity\SystemComponentController Decorated entity
     */
    protected function decorateEntity(\Cx\Core\Core\Model\Entity\SystemComponent $component) {
        if (isset($this->loadedComponents[$component->getId()])) {
            return $this->loadedComponents[$component->getId()];
        }        
        $componentControllerClass = $this->getComponentControllerClassFor($component);
        $componentController = new $componentControllerClass($component, $this->cx);
        $this->loadedComponents[$component->getId()] = $componentController;
        return $componentController;
    }
    
    /**
     * Returns class name to use for decoration
     * 
     * If the component does not have a class named "ComponentController"
     * the default SystemComponentController class is used
     * @param \Cx\Core\Core\Model\Entity\SystemComponent $component Component to get decoration class for
     * @return string Full qualified class name
     */
    protected function getComponentControllerClassFor(\Cx\Core\Core\Model\Entity\SystemComponent $component) {
		if (!$this->cx->getClassLoader()->getFilePath($component->getDirectory(false) . '/Controller/ComponentController.class.php')) {
            return '\\Cx\\Core\\Core\\Model\\Entity\\SystemComponentController';
        }
        $className = $component->getNamespace() . '\\Controller\\ComponentController';
        return $className;
    }
    
    /**
     * Call hook script of all SystemComponents before resolving
     */
    public function callPreResolveHooks() {
        foreach ($this->findActive() as $component) {
            $component->preResolve($this->cx->getRequest());
        }
    }
    
    /**
     * Call hook script of all SystemComponents after resolving
     */
    public function callPostResolveHooks() {
        foreach ($this->findActive() as $component) {
            $component->postResolve($this->cx->getPage());
        }
    }
    
    /**
     * Call hook script of all SystemComponents before loading content
     */
    public function callPreContentLoadHooks() {
        foreach ($this->findActive() as $component) {
            $component->preContentLoad($this->cx->getPage());
        }
    }
    
    /**
     * Call hook script of all SystemComponents before loading module content
     */
    public function callPreContentParseHooks() {
        foreach ($this->findActive() as $component) {
            $component->preContentParse($this->cx->getPage());
        }
    }
    
    /**
     * Load a component (tell it to parse its content)
     * @param string $componentName Name of component to load
     */
    public function loadComponent($componentName) {
        $this->findOneBy(array('name'=>$componentName))->load($this->cx->getPage());
    }
    
    /**
     * Call hook script of all SystemComponents after loading module content
     */
    public function callPostContentParseHooks() {
        foreach ($this->findActive() as $component) {
            $component->postContentParse($this->cx->getPage());
        }
    }
    
    /**
     * Call hook script of all SystemComponents after loading content
     */
    public function callPostContentLoadHooks() {
        foreach ($this->findActive() as $component) {
            $component->postContentLoad($this->cx->getPage());
        }
    }
    
    /**
     * Call hook script of all SystemComponents before finalization
     */
    public function callPreFinalizeHooks() {
        foreach ($this->findActive() as $component) {
            $component->preFinalize($this->cx->getTemplate());
        }
    }
    
    /**
     * Call hook script of all SystemComponents after finalization
     */
    public function callPostFinalizeHooks() {
        foreach ($this->findActive() as $component) {
            $component->postFinalize();
        }
    }
}
