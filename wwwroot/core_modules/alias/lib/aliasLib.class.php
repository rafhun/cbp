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
 * Alias library
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Comvation Development Team <info@comvation.com>
 * @version     1.0.0
 * @package     contrexx
 * @subpackage  coremodule_alias
 * @todo        Edit PHP DocBlocks!
 */

/**
 * Alias library
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Comvation Development Team <info@comvation.com>
 * @version     1.0.0
 * @package     contrexx
 * @subpackage  coremodule_alias
 * @todo        Edit PHP DocBlocks!
 */
class aliasLib
{
    public $_arrAliasTypes = array(
        'local',
        'url'
    );

    public $langId;

    public $_arrConfig = null;
    
    protected $em = null;
    
    protected $nodeRepository = null;
    
    protected $pageRepository = null;

    protected $hasLegacyPages = false;
    

    function __construct($langId = 0)
    {
        $this->langId = intval($langId) > 0 ? $langId : FRONTEND_LANG_ID;
        
        $this->em = Env::em();
        $this->nodeRepository = $this->em->getRepository('Cx\Core\ContentManager\Model\Entity\Node');
        $this->pageRepository = $this->em->getRepository('Cx\Core\ContentManager\Model\Entity\Page');
    }

    
    function _getAliases($limit = null, $all = false, $legacyPages = false, $slug = null)
    {
        $pos = !$all && isset($_GET['pos']) ? intval($_GET['pos']) : 0;
        
        if(!$slug){
            // show all entries
            $aliases = $this->pageRepository->findBy(array(
                'type' => \Cx\Core\ContentManager\Model\Entity\Page::TYPE_ALIAS,
            ), true);
        } else {
            // query builder for filtering entries
            $qb = $this->pageRepository->createQueryBuilder('p');
            $aliases = 
                $qb->select('p')
                ->add('where', $qb->expr()->andX(
                    $qb->expr()->eq('p.type', ':type'),
                    $qb->expr()->like('p.slug', ':slug')
                ))->setParameters(array(
                    'type' => \Cx\Core\ContentManager\Model\Entity\Page::TYPE_ALIAS,
                    'slug' => $slug,
                ))->getQuery()->getResult();
        }
        $i = 0;
        $pages = array();
        foreach ($aliases as $page) {
            // skip legacy page aliases if legacy page is disabled
            if (preg_match('/^legacy_page_/', $page->getSlug())) {
                $this->hasLegacyPages = true;
                if (!$legacyPages) continue;
            }
            $i++;
            if ($i < $pos) {
                continue;
            }
            $pages[] = $page;
            if ($limit && count($pages) == $limit) {
                break;
            }
        }
        
        return $pages;
    }


    function _getAliasesCount($showLegacyPagealiases, $slug)
    {
        return count($this->_getAliases(null, true, $showLegacyPagealiases, $slug));
    }
    

    function _getAlias($aliasId)
    {
        $crit = array(
            'node' => $aliasId,
        );
        return current($this->pageRepository->findBy($crit, true));
    }
    
    
    function _fetchTarget($page)
    {
        return $this->pageRepository->getTargetPage($page);
    }
    
    
    function _isLocalAliasTarget($page)
    {
        return $page->isTargetInternal();
    }
    
    
    function _getURL($page)
    {
        $lang = FWLanguage::getLanguageCodeById($page->getLang());
        return $page->getUrl('/' . $lang, '');
    }
    
    function _getAliasesWithSameTarget($aliasPage)
    {
        $aliases = array();
        $target  = $aliasPage->getTarget();

        if (!empty($target)) {
            $crit = array(
                'type'   => \Cx\Core\ContentManager\Model\Entity\Page::TYPE_ALIAS,
                'target' => $target,
            );
            $aliases = $this->pageRepository->findBy($crit, true);
        }

        return $aliases;
    }
    

    function _setAliasTarget(&$arrAlias)
    {
        if ($arrAlias['type'] == 'local') {
            $page = new Cx\Core\ContentManager\Model\Entity\Page();
            $page->setTarget($arrAlias['url']);
            $target_node_id = $page->getTargetNodeId();
            $target_lang_id = $page->getTargetLangId();
            if (!$target_lang_id) {
                $target_lang_id = $this->langId;
            }
            $crit = array(
                'node' => $target_node_id,
                'lang' => $target_lang_id,
            );
            $page_repo = Env::em()->getRepository('Cx\Core\ContentManager\Model\Entity\Page');
            $targetPage = $page_repo->findBy($crit, true);
            $targetPage = $targetPage[0];
            $targetPath = $page_repo->getPath($targetPage);
            $arrAlias['pageUrl'] = "/".$targetPath;
            $arrAlias['title'] = $targetPage->getContentTitle();
        }
    }
    
    
    function _createTemporaryAlias()
    {
        global $objFWUser;
        
        $page = new \Cx\Core\ContentManager\Model\Entity\Page();
        $page->setLang(0);
        $page->setType(\Cx\Core\ContentManager\Model\Entity\Page::TYPE_ALIAS);
        $page->setCmd('');
        $page->setActive(true);
        //$page->setUsername($objFWUser->objUser->getUsername());
        return $page;
    }
    

    function _saveAlias($slug, $target, $is_local, $id = '')
    {
        if ($slug == '') {
            return false;
        }
        
        // is internal target
        if ($is_local) {
            // get target page
            $temp_page = new \Cx\Core\ContentManager\Model\Entity\Page();
            $temp_page->setTarget($target);
            $existing_aliases = $this->_getAliasesWithSameTarget($temp_page);
            
            // if alias already exists -> fail
            foreach ($existing_aliases as $existing_alias) {
                if (($id == '' || $existing_alias->getNode()->getId() != $id) &&
                        $slug == $existing_alias->getSlug()) {
                    return false;
                }
            }
        }

        if ($id == '') {
            // create new node
            $node = new \Cx\Core\ContentManager\Model\Entity\Node();
            $node->setParent($this->nodeRepository->getRoot());
            $this->em->persist($node);

            // add a page
            $page = $this->_createTemporaryAlias();
            $page->setNode($node);
        } else {
            $node = $this->nodeRepository->find($id);
            if (!$node) {
                return false;
            }
            $pages = $node->getPages(true);
            if (count($pages) != 1) {
                return false;
            }
            $page = $pages->first();
            // we won't change anything on non aliases
            if ($page->getType() != \Cx\Core\ContentManager\Model\Entity\Page::TYPE_ALIAS) {
                return false;
            }
        }
        
        // set page attributes
        $page->setSlug($slug);
        $page->setTarget($target);
        $page->setTitle($page->getSlug());
        
        // sanitize slug
        while (file_exists(ASCMS_PATH . '/' . $page->getSlug())) {
            $page->nextSlug();
        }
        
        // save
        try {
            $page->validate();
        } catch (\Cx\Core\ContentManager\Model\Entity\PageException $e) {
            return $e->getUserMessage();
        }
        $this->em->persist($page);
        $this->em->flush();
        $this->em->refresh($node);
        $this->em->refresh($page);
        
        return true;
    }


    function _deleteAlias($aliasId)
    {
        $alias = $this->_getAlias($aliasId);
        if (!is_object($alias)) {
            die ("ALIAS NOT FOUND: ID=".$aliasId);
            return false;
        }
        $this->em->remove($alias->getNode());
        $this->em->remove($alias);
        $this->em->flush();
        return true;
    }
}
