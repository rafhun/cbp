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
 * Contrexx ClassLoader
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  core_classloader
 */
 
namespace Cx\Core\ClassLoader;

/**
 * Contrexx ClassLoader
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  core_classloader
 */
class ClassLoader {
    private $basePath;
    private $customizingPath;
    private $legacyClassLoader = null;
    
    /**
     * To use LegacyClassLoader config.php and set_constants.php must be loaded
     * If they are not present, set $useLegacyAsFallback to false!
     * @param String $basePath Base directory to load files (e.g. ASCMS_DOCUMENT_ROOT)
     * @param boolean $useLegacyAsFallback (optional) Wheter to use LegacyClassLoader too (default) or not
     */
    public function __construct($basePath, $useLegacyAsFallback = true, $customizingPath = null) {
        $this->basePath = $basePath;
        $this->customizingPath = $customizingPath;
        spl_autoload_register(array($this, 'autoload'));
        if ($useLegacyAsFallback) {
            $this->legacyClassLoader = new LegacyClassLoader($this);
        }
    }
    
    /**
     * This needs to be public because Doctrine tries to load a class using all
     * registered autoloaders.
     * @param type $name
     * @return type void
     */
    public function autoload($name) {
        //print $name."<br>";
        if ($this->load($name, $path)) {
            return;
        }
        if ($path) {
            //echo '<b>' . $name . ': ' . $path . '</b><br />';
        }
        $this->loadLegacy($name);
    }
    
    private function load($name, &$resolvedPath) {
        if (substr($name, 0, 1) == '\\') {
            $name = substr($name, 1);
        }
        $parts = explode('\\', $name);
        // new classes should be in namespace \Cx\something
        if (!in_array(current($parts), array('Cx', 'Doctrine', 'Gedmo', 'DoctrineExtension', 'Symfony')) || count($parts) < 2) {
            return false;
        }
        if (substr($name, 0, 8) == 'PHPUnit_') {
            return false;
        }
        
        $suffix = '.class';
        if ($parts[0] == 'Cx') {
            // Exception for model, its within /model/[entities|events]/cx/model/
            if ($parts[1] == 'Model') {
                $third = 'entities';
                if ($parts[2] == 'Events') {
                    $third = 'events';
                }
                if ($parts[2] == 'Proxies') {
                    $third = 'proxies';
                    $suffix = '';
                }
                $parts = array_merge(array('Cx', 'Model', $third), $parts);
                
            // Exception for lib, its within /model/FRAMEWORK/
            } else if ($parts[1] == 'Lib') {
                unset($parts[0]);
                unset($parts[1]);
                $parts = array_merge(array('Cx', 'Lib', 'FRAMEWORK'), $parts);
            }
        
        // Exception for overwritten gedmo classes, they are within /model/entities/Gedmo
        // This is not ideal, maybe move the classes somewhere
        } else if ($parts[0] == 'Gedmo') {
            $suffix = '';
            $parts = array_merge(array('Cx', 'Lib', 'doctrine'), $parts);
            //$parts = array_merge(array('Cx', 'Model', 'entities'), $parts);
        } else if ($parts[0] == 'Doctrine') {
            $suffix = '';
            if ($parts[1] == 'ORM') {
                $parts = array_merge(array('Cx', 'Lib', 'doctrine'), $parts);
            } else {
                $parts = array_merge(array('Cx', 'Lib', 'doctrine', 'vendor', 'doctrine-' . strtolower($parts[1]), 'lib'), $parts);
            }
        } else if ($parts[0] == 'DoctrineExtension') {
            $suffix = '';
            $parts = array_merge(array('Cx', 'Model', 'extensions'), $parts);
        } else if ($parts[0] == 'Symfony') {
            $suffix = '';
            $parts = array_merge(array('Cx', 'Lib', 'doctrine', 'vendor'), $parts);
        }
        
        // we don't need the Cx part
        unset($parts[0]);
        // core, lib, model, etc. are lowercase by design
        $parts[1] = strtolower($parts[1]);
        // but we need the original class name to find the correct file name
        $className = end($parts);
        unset($parts[count($parts)]);
        reset($parts);
        
        // find matching path
        $path = '';
        foreach ($parts as $part) {
            $part = '/' . $part;
            if (!is_dir($this->basePath . $path . $part) && (!$this->customizingPath || !is_dir($this->customizingPath . $path . $part))) {
                return false;
            }
            $path .= $part;
        }
        
        $resolvedPath = $path . '/' . $className . $suffix . '.php';
        if (preg_match('/Exception/', $className) && !$this->loadFile($resolvedPath)) {
            $className = preg_replace('/Exception/', '', $className);
            $resolvedPath = $path . '/' . $className . $suffix . '.php';
        }
        
        if ($this->loadFile($resolvedPath)) {
            return true;
        } else if ($this->loadFile($path.'/'.$className.'.interface.php')) {
            return true;
        }
        //echo '<span style="color: red;">' . implode('\\', $parts) . '</span>';
        return false;
    }
    
    public function loadFile($path) {
        
        $path = $this->getFilePath($path);
        if (!$path) {
            return false;
        }
        require_once($path);
        return true;
    }
    
    public function getFilePath($file, &$isCustomized = false) {
        $file = preg_replace('#\\\\#', '/', $file);
        $regex = preg_replace('#([\(\)])#', '\\\\$1', ASCMS_PATH.ASCMS_PATH_OFFSET);
        $file = preg_replace('#'.$regex.'#', '', $file);
        
        // load class from customizing folder
        if ($this->customizingPath && file_exists($this->customizingPath.$file)) {
            $isCustomized = true;
            return $this->customizingPath.$file;
        
        // load class from basepath
        } else if (file_exists($this->basePath.$file)) {
            $isCustomized = false;
            return $this->basePath.$file;
        }
        return false;
    }
    
    private function loadLegacy($name) {
        if ($this->legacyClassLoader) {
            $this->legacyClassLoader->autoload($name);
        }
    }
    
    /**
     * Tests if a class is available. You may specify if legacy and customizing
     * can be used to load it if necessary.
     * @todo $useCustomizing does not work correctly if legacy is enabled
     * @param string $class Class name to look for
     * @param boolean $useLegacy (optional) Wheter to allow usage of legacy class loader or not (default false)
     * @param boolean $useCustomizing (optional) Wheter to allow usage of customizings or not (default true)
     * @return boolean True if class could be found using the allowed methods, false otherwise 
     */
    public function classExists($class, $useLegacy = false, $useCustomizing = true) {
        if ($useLegacy) {
            return class_exists($class);
        }
        $legacy = $this->legacyClassLoader;
        $this->legacyClassLoader = null;
        $customizing = $this->customizingPath;
        if (!$useCustomizing) {
            $customizing = null;
        }
        $ret = class_exists($class);
        $this->legacyClassLoader = $legacy;
        $this->customizingPath = $customizing;
        return $ret;
    }
}
