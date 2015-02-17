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
 * A system component (aka "module", "core_module" or "core component")
 *
 * @copyright   Comvation AG
 * @author      Michael Ritter <michael.ritter@comvation.com>
 * @package     contrexx
 * @subpackage  core_core
 * @version     3.1.0
 */

namespace Cx\Core\Core\Model\Entity;

/**
 * Thrown for illegal component types
 *
 * @copyright   Comvation AG
 * @author      Michael Ritter <michael.ritter@comvation.com>
 * @package     contrexx
 * @subpackage  core_core
 * @version     3.1.0
 */
class SystemComponentException extends \Exception {}

/**
 * A system component (aka "module", "core_module" or "core component")
 *
 * @copyright   Comvation AG
 * @author      Michael Ritter <michael.ritter@comvation.com>
 * @package     contrexx
 * @subpackage  core
 * @version     3.1.0
 */
class SystemComponent
{
    const TYPE_CORE = 'core';
    const TYPE_CORE_MODULE = 'core_module';
    const TYPE_MODULE = 'module';
    
    /**
     * Unique ID
     * @var integer $id
     */
    private $id;

    /**
     * Component name
     * @var string $name
     */
    private $name;
    
    /**
     * Component type
     * @var enum $type
     */
    private $type;

    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set type
     *
     * @param enum $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return enum $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Checks if the component is active and in the list of legal components (license)
     * @return bool True if the component is active and legal, false otherwise
     */
    public function isActive() {
        $cx = \Env::get('cx');
        $mc = \Cx\Core\ModuleChecker::getInstance($cx->getDb()->getEntityManager(), $cx->getDb()->getAdoDb(), $cx->getClassLoader());

        if (!in_array($this->getName(), $mc->getModules())) {
            return true;
        }

        if ($cx->getMode() == \Cx\Core\Core\Controller\Cx::MODE_FRONTEND) {
            if (!$cx->getLicense()->isInLegalFrontendComponents($this->getName())) {
                return false;
            }
        } else {
            if (!$cx->getLicense()->isInLegalComponents($this->getName())) {
                return false;
            }
        }

        if (!$mc->isModuleInstalled($this->getName())) {
            return false;
        }

        return true;
    }

    /**
     * Returns the absolute path to this component's location in the file system
     * @param boolean $allowCustomizing (optional) Set to false if you want to ignore customizings
     * @param boolean $relative (optional) If set to true, the path relative to Contrexx main dir is returned, default false
     * @return string Path for this component
     */
    public function getDirectory($allowCustomizing = true, $relative = false) {
        $basepath = ASCMS_DOCUMENT_ROOT;
        if ($relative) {
            $basepath = '';
        }
        $basepath .= $this->getPathForType($this->getType());
        $componentPath = $basepath . '/' . $this->getName();
        if (!$allowCustomizing) {
            return $componentPath;
        }
        return \Env::get('ClassLoader')->getFilePath($componentPath);
    }
    
    /**
     * Returns the base namespace for this component
     * @return string Namespace
     */
    public function getNamespace() {
        $ns = self::getBaseNamespaceForType($this->getType());
        $ns .= '\\' . $this->getName();
        return $ns;
    }

    /**
     * Returns the type folder (relative to document root)
     * @param string $type Component type name
     * @throws SystemComponentException
     * @return string Component type folder relative to document root
     */
    public static function getPathForType($type) {
        switch ($type) {
            case self::TYPE_CORE:
                return ASCMS_CORE_FOLDER;
                break;
            case self::TYPE_CORE_MODULE:
                return ASCMS_CORE_MODULE_FOLDER;
                break;
            case self::TYPE_MODULE:
                return ASCMS_MODULE_FOLDER;
                break;
            case 'lib':
                return ASCMS_LIBRARY_FOLDER;
                break;
            default:
                throw new SystemComponentException('No such component type "' . $type . '"');
                break;
        }
    }

    /**
     * Returns the namespace for a component type
     * @param string $type Component type name
     * @throws SystemComponentException
     * @return string Namespace
     */
    public static function getBaseNamespaceForType($type) {
        switch ($type) {
            case 'core':
                return 'Cx\\Core';
                break;
            case 'core_module':
                return 'Cx\\Core_Modules';
                break;
            case 'module':
                return 'Cx\\Modules';
                break;
            default:
                throw new SystemComponentException('No such component type "' . $type . '"');
                break;
        }
    }
}
