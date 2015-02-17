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
 * Navigation
 * Note: modified 27/06/2006 by Sébastien Perret => sva.perret@bluewin.ch
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author        Comvation Development Team <info@comvation.com>
 * @version        1.0.0
 * @package     contrexx
 * @subpackage  core
 * @todo        Edit PHP DocBlocks!
 */

/**
 * Class Navigation
 * This class creates the navigation tree
 * Note: modified 27/06/2006 by Sébastien Perret => sva.perret@bluewin.ch
 *
 * @deprecated  Use \Cx\Core\PageTree directly instead
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author        Comvation Development Team <info@comvation.com>
 * @access        public
 * @version        1.0.0
 * @package     contrexx
 * @subpackage  core
 */
class Navigation
{
    private $langId;
    private $pageId;
    private $separator = ' > ';
    private $subNavTag = '<ul id="menubuilder%s" class="menu">{SUB_MENU}</ul>';
    private $_objTpl;

    protected $page = null;


    /**
    * Constructor
    * @global   integer
    * @param     integer  $pageId
    * @param Cx\Core\ContentManager\Model\Entity\Page $page
    */
    public function __construct($pageId, $page)
    {
        global $_LANGID;

        $this->langId = $_LANGID;
        $this->pageId = $pageId;
        $this->page = $page;
    }


    public function getSubnavigation($templateContent, $license, $boolShop=false)
    {
        return $this->parseNavigation($templateContent, $license, $boolShop, true);
    }
    

    public function getNavigation($templateContent, $license, $boolShop=false)
    {
        return $this->parseNavigation($templateContent, $license, $boolShop, false);
    }

    /**
     * This is just a wrapper for \Cx\Core\PageTree\ classes and Shop::getNavbar()
     * @param   string  $templateContent
     * @param   boolean $boolShop         If true, parse the shop navigation
     *                                    into {SHOPNAVBAR_FILE}
     * @param   \Cx\Core\ContentManager\Model\Entity\Page requestedPage
     * @access  private
     * @return mixed parsed navigation
     */
    private function parseNavigation($templateContent, $license, $boolShop=false, $parseSubnavigation=false)
    {
        // only proceed if a navigation template had been set
        if (empty($templateContent)) {
            return;
        }

        $this->_objTpl = new \Cx\Core\Html\Sigma('.');
        CSRF::add_placeholder($this->_objTpl);
        $this->_objTpl->setErrorHandling(PEAR_ERROR_DIE);
        $this->_objTpl->setTemplate($templateContent);

        if ($boolShop) {
            $this->_objTpl->setVariable('SHOPNAVBAR_FILE', Shop::getNavbar());
        }

        $rootNode = null;
        if ($parseSubnavigation) {
// TODO: add comment to why the subnavigation will need the rootNode
            $rootNode = $this->page->getNode();
            while($rootNode->getLvl() > 1) {
                $rootNode = $rootNode->getParent();
            }
        }

        if (isset($this->_objTpl->_blocks['navigation_dropdown'])) {
            // set submenu tag
            if ($this->_objTpl->blockExists('sub_menu')) {
                $this->subNavTag = trim($this->_objTpl->_blocks['sub_menu']);
                $templateContent = preg_replace('<!--\s+BEGIN\s+sub_menu\s+-->.*<!--\s+END\s+sub_menu\s+-->/ms', NULL, $templateContent);
            }
            $navi = new \Cx\Core\PageTree\DropdownNavigationPageTree(Env::em(), $license, 0, $rootNode, $this->langId, $this->page);
            $navi->setVirtualLanguageDirectory(Env::get('virtualLanguageDirectory'));
            $navi->setTemplate($this->_objTpl);
            $renderedNavi = $navi->render();
            $templateContent = preg_replace('/<!--\s+BEGIN\s+level_\d+\s+-->.*<!--\s+END\s+level_\d+\s+-->/ms', $renderedNavi, $templateContent);
            return preg_replace('/<!--\s+BEGIN\s+navigation_dropdown\s+-->(.*)<!--\s+END\s+navigation_dropdown\s+-->/ms', '\1', $templateContent);
        }

        if (isset($this->_objTpl->_blocks['navigation'])) {
            $navi = new \Cx\Core\PageTree\NavigationPageTree(Env::em(), $license, 0, $rootNode, $this->langId, $this->page);
            $navi->setVirtualLanguageDirectory(Env::get('virtualLanguageDirectory'));
            $navi->setTemplate($this->_objTpl);
            return $navi->render();
        }

        // Create a nested list, formatted with ul and li-Tags
        if (isset($this->_objTpl->_blocks['nested_navigation'])) {
            $navi = new \Cx\Core\PageTree\NestedNavigationPageTree(Env::em(), $license, 0, $rootNode, $this->langId, $this->page);
            $navi->setVirtualLanguageDirectory(Env::get('virtualLanguageDirectory'));
            $navi->setTemplate($this->_objTpl);
            $renderedNavi = $navi->render();
            return preg_replace('/<!--\s+BEGIN\s+nested_navigation\s+-->.*<!--\s+END\s+nested_navigation\s+-->/ms', $renderedNavi, $templateContent);
        }
    }


    /**
     * Get trail
     * @return    string     The trail with links
     */
    public function getTrail()
    {
        $lang = $this->page->getLang();
        $node = $this->page->getNode()->getParent();
        $result = '';
        while($node->getLvl() > 0) {
            $page = $node->getPage($lang);
            $title = $page->getTitle();
            $path = \Cx\Core\Routing\Url::fromPage($page);
            $result = '<a href="'.$path.'" title="'.contrexx_raw2xhtml($title).'">'.contrexx_raw2xhtml($title).'</a>'.$this->separator.' '.$result;
            $node = $node->getParent();
        }
        return $result;
    }


    /**
     * getFrontendLangNavigation()
     * @param \Cx\Core\Routing\Url $pageUrl
     * @param boolean $langNameContraction
     * @return string 
     */
    public function getFrontendLangNavigation($page, $pageUrl, $langNameContraction = false)
    {
        $activeLanguages = \FWLanguage::getActiveFrontendLanguages();
        $node = $page->getNode();

        $langNavigation = array();
        foreach ($activeLanguages as $langId => $langData) {
            $targetPage = $node->getPage($langId);
            if ($targetPage && $targetPage->isActive()) {
                $url = clone $pageUrl;
                $url->setLangDir($langData['lang']);
                $url->setPath(substr($targetPage->getPath(), 1));

                $name  = contrexx_raw2xhtml($langNameContraction ? strtoupper($langData['lang']) : $langData['name']);
                $class = $langId == FRONTEND_LANG_ID ? $langData['lang'].' active' : $langData['lang'];

                $langNavigation[] = '<a class="'.$class.'" href="'.$url.'" title="'.$name.'">'.$name.'</a>';
            }
        }

        return implode('', $langNavigation);
    }


    /**
     * Sets the language placeholders in the provided template
     * @param \Cx\Core\Routing\Url $pageUrl
     * @param \Cx\Core\Html\Sigma $objTemplate 
     */
    public function setLanguagePlaceholders($page, $pageUrl, $objTemplate)
    {
        $activeLanguages = \FWLanguage::getActiveFrontendLanguages();
        $node = $page->getNode();

        $placeholders = array();
        foreach ($activeLanguages as $langId => $langData) {
            $url = clone $pageUrl;
            $url->setLangDir($langData['lang']);

            if (($targetPage = $node->getPage($langId)) && $targetPage->isActive()) {
                $url->setPath(substr($targetPage->getPath(), 1));
                $link = $url->__toString();
            } else {
                $link = $url->fromModuleAndCmd('error', '', $langId);
            }
            $placeholders['LANG_CHANGE_'.strtoupper($langData['lang'])] = $link;
            $placeholders['LANG_SELECTED_'.strtoupper($langData['lang'])] = '';
        }
        $placeholders['LANG_SELECTED_'.strtoupper($pageUrl->getLangDir())] = 'selected';
        $objTemplate->setVariable($placeholders);
    }
}

