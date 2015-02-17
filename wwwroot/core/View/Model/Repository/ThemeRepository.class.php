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
 * ThemeRepository
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Ueli Kramer <ueli.kramer@comvation.com>
 * @package     contrexx
 * @subpackage  core_view_model
 */

namespace Cx\Core\View\Model\Repository;

/**
 * ThemeRepository
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Ueli Kramer <ueli.kramer@comvation.com>
 * @package     contrexx
 * @subpackage  core_view_model
 */
class ThemeRepository
{
    /**
     * @var \ADOConnection database connection
     */
    private $db;
    
    public function __construct() {
        $this->db = \Env::get('db');
    }
    
    /**
     * Get the default theme by device type and language
     * @param string $type the type of output device
     * @param int $languageId the language id
     * @return \Cx\Core\View\Model\Entity\Theme the default theme
     */
    public function getDefaultTheme($type = \Cx\Core\View\Model\Entity\Theme::THEME_TYPE_WEB, $languageId = null) {
        switch ($type) {
            case \Cx\Core\View\Model\Entity\Theme::THEME_TYPE_PRINT:
                $dbField = 'print_themes_id';
                break;
            case \Cx\Core\View\Model\Entity\Theme::THEME_TYPE_MOBILE:
                $dbField = 'mobile_themes_id';
                break;
            case \Cx\Core\View\Model\Entity\Theme::THEME_TYPE_APP:
                $dbField = 'app_themes_id';
                break;
            case \Cx\Core\View\Model\Entity\Theme::THEME_TYPE_PDF:
                $dbField = 'pdf_themes_id';
                break;
            default:
                $dbField = 'themesid';
                break;
        }
        
        // select default theme of default language if no language id has been
        // provided
        $where = '`is_default` = "true"';
        if ($languageId) {
            $where = '`id` = ' . intval($languageId);
        }
        
        $result = $this->db->SelectLimit('SELECT `'.$dbField.'` FROM `'.DBPREFIX.'languages` WHERE ' . $where, 1);
        if ($result !== false && $result->RecordCount() > 0) {
            $id = current($result->fields);
            return $this->findById($id);
        }
        return null;
    }
    
    /**
     * Get a theme by theme id
     * @param int $id the id of the theme
     * @return \Cx\Core\View\Model\Entity\Theme the theme
     */
    public function findById($id) {
        $result = $this->db->SelectLimit('SELECT `id`, `themesname`, `foldername`, `expert` FROM `'.DBPREFIX.'skins` WHERE `id` = '.intval($id), 1);
        if ($result !== false && !$result->EOF) {
            return $this->getTheme(
                $result->fields['id'],
                $result->fields['themesname'],
                $result->fields['foldername'],
                $result->fields['expert'],
                null
            );
        }
        return null;
    }
    
    /**
     * Get multiple themes
     * @param array $crit the criterias
     * @param array $order the order, e.g. array( 'field' => 'ASC|DESC' ) 
     * @param int $languageId filter by language id
     * @return array theme objects
     */
    public function findBy($crit = array(), $order = array(), $languageId = null) {
        $query = 'SELECT `id`, `themesname`, `foldername`, `expert` FROM `'.DBPREFIX.'skins`';
        if (!empty($crit)) {
            $wheres = array();
            foreach ($crit as $field => $value) {
                $wheres[] = '`'.$field.'` = \''.contrexx_raw2db($value).'\'';
            }
            
            $query .= ' WHERE ' . implode(' AND ', $wheres);
        }
        if (!empty($order)) {
            $query .= ' ORDER BY ' . implode(',', $order);
        }
        $result = $this->db->Execute($query);
        $themes = array();
        if ($result !== false) {
            while (!$result->EOF) {
                $themes[] = $this->getTheme(
                    $result->fields['id'],
                    $result->fields['themesname'],
                    $result->fields['foldername'],
                    $result->fields['expert'],
                    $languageId
                );
                $result->MoveNext();
            }
        }
        return $themes;
    }
    
    /**
     * Find one theme by provided criterias and sort them in a defined order
     * @param array $crit the criterias
     * @param array $order the order, e.g. array( 'field' => 'ASC|DESC' ) 
     * @return \Cx\Core\View\Model\Entity\Theme the theme object
     */
    public function findOneBy($crit = array(), $order = array()) {
        return current($this->findBy($crit, $order));
    }
    
    /**
     * Get all themes as objects with a provided order and by language id
     * @param array $order the order, e.g. array( 'field' => 'ASC|DESC' )
     * @param int $languageId language id
     * @return array theme objects
     */
    public function findAll($order = array(), $languageId = null) {
        $query = 'SELECT `id`, `themesname`, `foldername`, `expert` FROM `'.DBPREFIX.'skins`';
        if (!empty($order)) {
            $query .= ' ORDER BY ' . implode(',', $order);
        }
        $result = $this->db->Execute($query);
        $themes = array();
        if ($result !== false) {
            while (!$result->EOF) {
                $themes[] = $this->getTheme(
                    $result->fields['id'],
                    $result->fields['themesname'],
                    $result->fields['foldername'],
                    $result->fields['expert'],
                    $languageId
                );
                $result->MoveNext();
            }
        }
        return $themes;
    }
    
    /**
     * Removes a theme from database
     * @param \Cx\Core\View\Model\Entity\Theme $theme a theme object
     * @return boolean true if the query has been successfully completed
     */
    public function remove($theme) {
        return $this->db->Execute('DELETE FROM `'.DBPREFIX.'skins` WHERE `id` = '.$theme->getId());
    }
    
    /**
     * Writes the component.yml file with the data defined in component data array
     * @param \Cx\Core\View\Model\Entity\Theme $theme the theme object
     */
    public function saveComponentData($theme) {        
        $file = new \Cx\Lib\FileSystem\File(ASCMS_THEMES_PATH . '/' . $theme->getFoldername() . '/component.yml');
        $file->touch();
        $yaml = new \Symfony\Component\Yaml\Yaml();
        $file->write(
            $yaml->dump(
                array('DlcInfo' => $theme->getComponentData())
            )
        );
    }
    
    /**
     * Get a theme object with all his attributes
     * 
     * Loads the component data from component.yml file or creates one from info.xml
     * or a new one from static array
     * @param int $id the id of a theme, used for delete
     * @param string $themesname the display name of theme
     * @param string $foldername the physical folder name
     * @param int $expert
     * @param int $languageId language id
     * @return \Cx\Core\View\Model\Entity\Theme a theme object
     */
    protected function getTheme($id, $themesname, $foldername, $expert, $languageId = null) {
        $theme = new \Cx\Core\View\Model\Entity\Theme($id, $themesname, $foldername, $expert);
        
        // select default theme of default language if no language id has been
        // provided
        $where = '`is_default` = "true"';
        if ($languageId) {
            $where = '`id` = ' . intval($languageId);
        }
        
        $result = $this->db->SelectLimit('SELECT `themesid`, `pdf_themes_id`, `app_themes_id`, `mobile_themes_id`, `print_themes_id` FROM `'.DBPREFIX.'languages` WHERE ' . $where, 1);
        if ($result !== false && !$result->EOF) {
            if ($result->fields['themesid'] == $id) {
                $theme->addDefault(\Cx\Core\View\Model\Entity\Theme::THEME_TYPE_WEB);
            }
            if ($result->fields['pdf_themes_id'] == $id) {
                $theme->addDefault(\Cx\Core\View\Model\Entity\Theme::THEME_TYPE_PDF);
            }
            if ($result->fields['app_themes_id'] == $id) {
                $theme->addDefault(\Cx\Core\View\Model\Entity\Theme::THEME_TYPE_APP);
            }
            if ($result->fields['mobile_themes_id'] == $id) {
                $theme->addDefault(\Cx\Core\View\Model\Entity\Theme::THEME_TYPE_MOBILE);
            }
            if ($result->fields['print_themes_id'] == $id) {
                $theme->addDefault(\Cx\Core\View\Model\Entity\Theme::THEME_TYPE_PRINT);
            }
        }
        
        $themePath = ASCMS_THEMES_PATH . '/' . $foldername;
        if (!file_exists($themePath)) {
            return $theme;
        }
        try {
            // create a new one if no component.yml exists
            if (!file_exists($themePath . '/component.yml')) {
                $this->convertThemeToComponent($theme);
            }
            $yamlFile = new \Cx\Lib\FileSystem\File($themePath . '/component.yml');
            $yaml = new \Symfony\Component\Yaml\Yaml();
            $themeInformation = $yaml->load($yamlFile->getData());
            $theme->setComponentData($themeInformation['DlcInfo']);
        } catch (\Cx\Lib\FileSystem\FileSystemException $e) {}
        
        return $theme;
    }
    
    /**
     * Generate a component.yml for each theme available on the system
     * only used in update process for fixing invalid themes
     */
    public function convertAllThemesToComponent() {
        foreach ($this->findAll() as $theme) {
            if ($theme->isComponent()) {
                continue;
            }
            $this->convertThemeToComponent($theme);
        }
    }
    
    /**
     * Generate a component.yml for one theme available on the system
     * @param string|\Cx\Core\View\Model\Entity\Theme $theme
     */
    public function convertThemeToComponent($theme) {
        if ($theme instanceof \Cx\Core\View\Model\Entity\Theme) {
            $theme = $theme->getFoldername();
        }
        
        $themePath = ASCMS_THEMES_PATH . '/' . $theme;
        try {
            // check for old info file
            $infoFile = new \Cx\Lib\FileSystem\File($theme . '/info.xml');
            $this->xmlParseFile($infoFile);
            $themeInformation['DlcInfo'] = array(
                'name' => $theme,
                'description' => $this->xmlDocument['THEME']['DESCRIPTION']['cdata'],
                'type' => 'template',
                'publisher' => $this->xmlDocument['THEME']['AUTHORS']['AUTHOR']['USER']['cdata'],
                'versions' => array(
                    'state' => 'stable',
                    'number' => $this->xmlDocument['THEME']['VERSION']['cdata'],
                    'releaseDate' => '',
                ),
            );
            unset($this->xmlDocument);
        } catch (\Cx\Lib\FileSystem\FileSystemException $e) {
            // create new data for new component.yml file
            $themeInformation['DlcInfo'] = array(
                'name' => $theme,
                'description' => '',
                'type' => 'template',
                'publisher' => 'Comvation AG',
                'versions' => array(
                    'state' => 'stable',
                    'number' => '1.0.0',
                    'releaseDate' => '',
                ),                
            );
        }
        // Add default dependencies
        $themeInformation['DlcInfo']['dependencies'] = array(
            array(
                'name' => 'jquery',
                'type' => 'lib',
                'minimumVersionNumber' => '1.6.1',
                'maximumVersionNumber' => '1.6.1'
            )
        );
        $themeFolder = $theme;
        $theme = new \Cx\Core\View\Model\Entity\Theme();
        $theme->setFoldername($themeFolder);
        // write components yaml
        $theme->setComponentData($themeInformation['DlcInfo']);
        try {
            $this->saveComponentData($theme);
        } catch (\Cx\Lib\FileSystem\FileException $e) {
            // could not write new component.yml file, try next time
            throw new $e;
        }
        try {
            // delete existing info.xml file
            $infoFile->delete();
        } catch (\Cx\Lib\FileSystem\FileException $e) {
            // not critical, ignore
        }
    }
    
    private $xmlDocument;
    private $currentXmlElement;
    private $arrParentXmlElement;
    
    /**
     * get XML info of specified modulefolder
     * @param string $themes
     */
    protected function xmlParseFile($file)
    {
        // start parsing
        $xmlParser = \xml_parser_create(CONTREXX_CHARSET);
        \xml_set_object($xmlParser, $this);
        \xml_set_element_handler($xmlParser, 'xmlStartTag', 'xmlEndTag');
        \xml_set_character_data_handler($xmlParser, "xmlCharacterDataTag");
        \xml_parse($xmlParser, $file->getData());
        \xml_parser_free($xmlParser);
    }

    /**
     * XML parser start tag
     * @param resource $parser
     * @param string $name
     * @param array $attrs
     */
    protected function xmlStartTag($parser, $name, $attrs)
    {
        if (isset($this->currentXmlElement)) {
            if (!isset($this->currentXmlElement[$name])) {
                $this->currentXmlElement[$name] = array();
                $this->arrParentXmlElement[$name] = &$this->currentXmlElement;
                $this->currentXmlElement = &$this->currentXmlElement[$name];
            } else {
                if (!isset($this->currentXmlElement[$name][0])) {
                    $arrTmp = $this->currentXmlElement[$name];
                    unset($this->currentXmlElement[$name]);// = array();
                    $this->currentXmlElement[$name][0] = $arrTmp;
                }

                array_push($this->currentXmlElement[$name], array());
                $this->arrParentXmlElement[$name] = &$this->currentXmlElement;
                $this->currentXmlElement = &$this->currentXmlElement[$name][count($this->currentXmlElement[$name])-1];
            }

        } else {
            $this->xmlDocument[$name] = array();
            $this->currentXmlElement = &$this->xmlDocument[$name];
        }

        if (count($attrs)>0) {
            foreach ($attrs as $key => $value) {
                $this->currentXmlElement['attrs'][$key] = $value;
            }
        }
    }

    /**
     * XML parser character data tag
     * @param resource $parser
     * @param string $cData
     */
    protected function xmlCharacterDataTag($parser, $cData)
    {
        $cData = trim($cData);
        if (!empty($cData)) {
            if (!isset($this->currentXmlElement['cdata'])) {
                $this->currentXmlElement['cdata'] = $cData;
            } else {
                $this->currentXmlElement['cdata'] .= $cData;
            }
        }
    }

    /**
     * XML parser end tag
     * @param resource $parser
     * @param string $name
     */
    protected function xmlEndTag($parser, $name)
    {
        $this->currentXmlElement = &$this->arrParentXmlElement[$name];
        unset($this->arrParentXmlElement[$name]);
    }
}

