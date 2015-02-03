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
 * Theme
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Ueli Kramer <ueli.kramer@comvation.com>
 * @package     contrexx
 * @subpackage  core_view_model
 */

namespace Cx\Core\View\Model\Entity;

/**
 * Theme
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Ueli Kramer <ueli.kramer@comvation.com>
 * @package     contrexx
 * @subpackage  core_view_model
 */
class Theme extends \Cx\Model\Base\EntityBase
{
    private $id = null;
    private $themesname;
    private $foldername;
    private $expert;
    
    private $defaults = array();
    private $db;
    private $componentData;
    
    private $configurableLibraries;
    
    const THEME_TYPE_WEB = 'web';
    const THEME_TYPE_PRINT = 'print';
    const THEME_TYPE_MOBILE = 'mobile';
    const THEME_TYPE_APP = 'app';
    const THEME_TYPE_PDF = 'pdf';
    
    public function __construct($id = null, $themesname = null, $foldername = null, $expert = 1) {
        $this->db = \Env::get('db');
        
        $this->setId($id);
        $this->setThemesname($themesname);
        $this->setFoldername($foldername);
        $this->setExpert($expert);
    }
    
    /**
     * @return string the version number of template
     */
    public function getVersionNumber() {
        if (empty($this->componentData['versions'])) {
            return null;
        }
        $versionInformation = current($this->componentData['versions']);
        $version = $versionInformation['number'];
        if (strpos(".", $version) === false) {
            $version = number_format($version, 1);
        }
        return $version;
    }
    
    /**
     * @return string the publisher of template
     */
    public function getPublisher() {
        if (empty($this->componentData['publisher'])) {
            return null;
        }
        return $this->componentData['publisher'];
    }
    
    /**
     * @return string the description
     */
    public function getDescription() {
        if (empty($this->componentData['description'])) {
            return null;
        }
        return $this->componentData['description'];
    }
    
    /**
     * @return string the preview image source web path
     */
    public function getPreviewImage() {
        if (file_exists(ASCMS_THEMES_PATH . '/' . $this->foldername . '/images/preview.gif')) {
            return ASCMS_THEMES_WEB_PATH . '/' . $this->foldername . '/images/preview.gif';
        }
        return ASCMS_ADMIN_TEMPLATE_WEB_PATH.'/images/preview.gif';
    }
    
    /**
     * @return string the extra description includes the names of end devices, where
     * the theme is set as default
     */
    public function getExtra() {
        global $_CORELANG;
        if (in_array(static::THEME_TYPE_WEB, $this->defaults)){
            return ' ('.$_CORELANG['TXT_DEFAULT'].')';
        } elseif (in_array(static::THEME_TYPE_MOBILE, $this->defaults)){
            return ' ('.$_CORELANG['TXT_ACTIVE_MOBILE_TEMPLATE'].')';
        } elseif (in_array(static::THEME_TYPE_PRINT, $this->defaults)){
            return ' ('.$_CORELANG['TXT_THEME_PRINT'].')';
        } elseif (in_array(static::THEME_TYPE_PDF, $this->defaults)) {
            return ' ('.$_CORELANG['TXT_THEME_PDF'].')';
        } elseif (in_array(static::THEME_TYPE_APP, $this->defaults)) {
            return ' ('.$_CORELANG['TXT_APP_VIEW'].')';
        }
        return null;
    }
    
    /**
     * @return string the language abbreviations of activated languages
     * with this template, separated by comma
     */
    public function getLanguages() {
        $languagesWithThisTheme = array();
        $query = 'SELECT `name`
                    FROM `'.DBPREFIX.'languages`
                  WHERE
                    `frontend` = 1
                    AND (
                        `themesid` = '.$this->id.'
                        OR `mobile_themes_id` = '.$this->id.'
                        OR `print_themes_id` = '.$this->id.'
                        OR `pdf_themes_id` = '.$this->id.'
                        OR `app_themes_id` = '.$this->id.'
                    )';
        $result = $this->db->Execute($query);
        if ($result !== false) {
            while(!$result->EOF){
                $languagesWithThisTheme[] = $result->fields['name'];
                $result->MoveNext();
            }
        }
        return implode(', ', $languagesWithThisTheme);
    }
    
    /**
     * @return array all dependencies (javascript libraries) which contrexx should
     * load when showing this template
     */
    public function getDependencies() {
        $dependencies = array();
        if (!isset($this->componentData['dependencies'])) {
            return $dependencies;
        }
        foreach ($this->componentData['dependencies'] as $dependency) {
            $dependencies[$dependency['name']] = array(
                $dependency['minimumVersionNumber'],
                $dependency['maximumVersionNumber']
            );
        }
        return $dependencies;
    }

    /**
     * @param string $type the type of end device
     * @return boolean true if it is set as default, false if not
     */
    public function isDefault($type = null) {
        if (!$type) {
            return !empty($this->defaults);
        }
        return in_array($type, $this->defaults);
    }
    
    /**
     * Checks whether the template is a valid component with component.yml file
     * @return bool true if a component.yml exists
     */
    public function isComponent() {
        return !empty($this->componentData);
    }
    
    /**
     * Compares two dependencies so they are loaded in the correct order.
     * @param array $a the dependency A
     * @param array $b the dependency B
     * @return int
     */
    protected function sortDependencies($a, $b) {
        $aName = $a['name'];
        $aVersion = $a['minimumVersionNumber'];
        $bName = $b['name'];
        $bVersion = $b['minimumVersionNumber'];
        
        $aDependencies =
                isset($this->configurableLibraries[$aName]['versions'][$aVersion]['dependencies']) ?
                    $this->configurableLibraries[$aName]['versions'][$aVersion]['dependencies'] : array();
        $bDependencies = 
                isset($this->configurableLibraries[$bName]['versions'][$bVersion]['dependencies']) ?
                    isset($this->configurableLibraries[$bName]['versions'][$bVersion]['dependencies']) : array();
        
        // b is a dependency of a, b have to be loaded in front of a
        if (isset($aDependencies[$bName])) {
            return 1;
        }
        // a is a dependency of b, a have to be loaded in front of b
        if (isset($bDependencies[$aName])) {
            return -1;
        }
        // a sort is not needed because a and b have no relation
        return 0;
    }

    public function getId() {
        return $this->id;
    }

    public function getThemesname() {
        return $this->themesname;
    }

    public function getFoldername() {
        return $this->foldername;
    }

    public function getExpert() {
        return $this->expert;
    }
    
    public function getComponentData() {
        return $this->componentData;
    }

    public function setId($id) {
        $this->id = intval($id);
    }

    public function setThemesname($themesname) {
        $this->themesname = $themesname;
    }

    public function setFoldername($foldername) {
        $this->foldername = $foldername;
    }

    public function setExpert($expert) {
        $this->expert = intval($expert);
    }
    
    public function setComponentData($componentData) {
        $this->componentData = $componentData;
    }
    
    public function setDependencies($dependencies = array()) {
        $this->configurableLibraries = \JS::getConfigurableLibraries();
        usort($dependencies, array($this, 'sortDependencies'));
        $this->componentData['dependencies'] = $dependencies;
    }
    
    public function addDefault($type) {
        $this->defaults[] = $type;
    }
}
