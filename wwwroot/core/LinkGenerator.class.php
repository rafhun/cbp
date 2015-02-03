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
 * LinkGenerator
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  core
 */

/**
 * LinkGeneratorException
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  core
 */
class LinkGeneratorException extends \Exception {}

/**
 * Handles the node-Url placeholders: [[ NODE_(<node_id>|<module>[_<cmd>])[_<lang_id>] ]]
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  core
 */
class LinkGenerator {
    /**
     * array ( placeholder_name => placeholder_link
     *
     * @var array stores the placeholders found by scan()
     */
    protected $placeholders = array();
    /**
     * @var boolean whether fetch() ran.
     */
    protected $fetchingDone = false;
    protected $absoluteUris = false;

    public static function parseTemplate(&$content, $absoluteUris = false)
    {
        $lg = new LinkGenerator($absoluteUris);

        if (!is_array($content)) {
            $arrTemplates = array(&$content);
        } else {
            $arrTemplates = &$content;
        }

        foreach ($arrTemplates as &$template) {
            $lg->scan($template);
        }

        $lg->fetch(Env::get('em'));        

        foreach ($arrTemplates as &$template) {
            $lg->replaceIn($template);
        }
    }
    
    public function __construct($absoluteUris = false) {
        $this->absoluteUris = $absoluteUris;
    }

    /**
     * Scans the given string for placeholders and remembers them
     * @param string $content
     */
    public function scan(&$content) {
        $this->fetchingDone = false;

        $regex = '/\{'.\Cx\Core\ContentManager\Model\Entity\Page::NODE_URL_PCRE.'\}/xi';

        $matches = array();
        if (!preg_match_all($regex, $content, $matches)) {
            return;
        }

        for($i = 0; $i < count($matches[0]); $i++) {           
            $nodeId = isset($matches[\Cx\Core\ContentManager\Model\Entity\Page::NODE_URL_NODE_ID][$i]) ?$matches[\Cx\Core\ContentManager\Model\Entity\Page::NODE_URL_NODE_ID][$i] : 0;
            $module = isset($matches[\Cx\Core\ContentManager\Model\Entity\Page::NODE_URL_MODULE][$i]) ? strtolower($matches[\Cx\Core\ContentManager\Model\Entity\Page::NODE_URL_MODULE][$i]) : '';
            $cmd = isset($matches[\Cx\Core\ContentManager\Model\Entity\Page::NODE_URL_CMD][$i]) ? strtolower($matches[\Cx\Core\ContentManager\Model\Entity\Page::NODE_URL_CMD][$i]) : '';

            if (empty($matches[\Cx\Core\ContentManager\Model\Entity\Page::NODE_URL_LANG_ID][$i])) {
                $langId = FRONTEND_LANG_ID;
            } else {
                $langId = $matches[\Cx\Core\ContentManager\Model\Entity\Page::NODE_URL_LANG_ID][$i];
            }

            if ($nodeId) {
                # page is referenced by NODE-ID (i.e.: [[NODE_1]])
                $type = 'id';
            } else {
                # page is referenced by NODE-ID (i.e.: [[NODE_1]])
                $type = 'module';
            }

            $this->placeholders[$matches[\Cx\Core\ContentManager\Model\Entity\Page::NODE_URL_PLACEHOLDER][$i]] = array(
                'type'      => $type,
                'nodeid'    => $nodeId,
                'module'    => $module,
                'cmd'       => $cmd,
                'lang'      => $langId,
            );
        }
    }

    public function getPlaceholders() {
        return $this->placeholders;
    }

    /**
     * Uses the given Entity Manager to retrieve all links for the placeholders
     * @param EntityManager $em
     */
    public function fetch($em) {
        if($this->placeholders === null)
            throw new LinkGeneratorException('Seems like scan() was never called before calling fetch().');

        $qb = $em->createQueryBuilder();
        $qb->add('select', new Doctrine\ORM\Query\Expr\Select(array('p')));
        $qb->add('from', new Doctrine\ORM\Query\Expr\From('Cx\Core\ContentManager\Model\Entity\Page', 'p'));
       
        //build a big or with all the node ids and pages 
        $arrExprs = null;
        $fetchedPages = array();
        $pIdx = 0;
        foreach($this->placeholders as $placeholder => $data) {
            if ($data['type'] == 'id') {
                # page is referenced by NODE-ID (i.e.: [[NODE_1]])

                if (isset($fetchedPages[$data['nodeid']][$data['lang']])) {
                    continue;
                }

                $arrExprs[] = $qb->expr()->andx(
                    $qb->expr()->eq('p.node', $data['nodeid']),
                    $qb->expr()->eq('p.lang', $data['lang'])
                );

                $fetchedPages[$data['nodeid']][$data['lang']] = true;
            } else {
                # page is referenced by module (i.e.: [[NODE_SHOP_CART]])

                if (isset($fetchedPages[$data['module']][$data['cmd']][$data['lang']])) {
                    continue;
                }

                $arrExprs[] = $qb->expr()->andx(
                    $qb->expr()->eq('p.type', ':type'),
                    $qb->expr()->eq('p.module', ':module_'.$pIdx),
                    $qb->expr()->eq('p.cmd', ':cmd_'.$pIdx),
                    $qb->expr()->eq('p.lang', $data['lang'])
                );
                $qb->setParameter('module_'.$pIdx, $data['module']);
                $qb->setParameter('cmd_'.$pIdx, empty($data['cmd']) ? null : $data['cmd']);
                $qb->setParameter('type', \Cx\Core\ContentManager\Model\Entity\Page::TYPE_APPLICATION);

                $fetchedPages[$data['module']][$data['cmd']][$data['lang']] = true;

                $pIdx++;
            }
        }

        //fetch the nodes if there are any in the query
        if($arrExprs) {
            foreach ($arrExprs as $expr) {
                $qb->orWhere($expr);
            }

            $pages = $qb->getQuery()->getResult();
            foreach($pages as $page) {
                // build placeholder's value -> URL
                $url = \Cx\Core\Routing\Url::fromPage($page);

                $placeholderByApp = '';
                $placeholderById = \Cx\Core\ContentManager\Model\Entity\Page::PLACEHOLDER_PREFIX.$page->getNode()->getId();
                $this->placeholders[$placeholderById.'_'.$page->getLang()] = $url;

                if ($page->getType() == \Cx\Core\ContentManager\Model\Entity\Page::TYPE_APPLICATION) {
                    $module = $page->getModule();
                    $cmd = $page->getCmd();
                    $placeholderByApp = \Cx\Core\ContentManager\Model\Entity\Page::PLACEHOLDER_PREFIX;
                    $placeholderByApp .= strtoupper($module.(empty($cmd) ? '' : '_'.$cmd));
                    $this->placeholders[$placeholderByApp.'_'.$page->getLang()] = $url;
                }

                if ($page->getLang() == FRONTEND_LANG_ID) {
                    $this->placeholders[$placeholderById] = $url;

                    if (!empty($placeholderByApp)) {
                        $this->placeholders[$placeholderByApp] = $url;
                    }
                }
            }
        }

        // there might be some placeholders we were unable to resolve.
        // try to resolve them by using the fallback-language-reverse-lookup
        // methode provided by \Cx\Core\Routing\Url::fromModuleAndCmd().
        foreach($this->placeholders as $placeholder => $data) {
            if (!$data instanceof \Cx\Core\Routing\Url) {
                if (!empty($data['module'])) {
                    try {
                        $this->placeholders[$placeholder] = \Cx\Core\Routing\Url::fromModuleAndCmd($data['module'], $data['cmd'], $data['lang'], array(), '', false)->toString($this->absoluteUris);
                    } catch (\Cx\Core\Routing\UrlException $e) {
                        if ($data['lang'] && $data['cmd']) {
                            $this->placeholders[$placeholder] = \Cx\Core\Routing\Url::fromModuleAndCmd($data['module'], $data['cmd'].'_'.$data['lang'], FRONTEND_LANG_ID)->toString($this->absoluteUris);
                        } else if ($data['lang'] && empty($data['cmd'])) {
                            $this->placeholders[$placeholder] = \Cx\Core\Routing\Url::fromModuleAndCmd($data['module'], $data['lang'], FRONTEND_LANG_ID)->toString($this->absoluteUris);
                        } else {
                            $this->placeholders[$placeholder] = \Cx\Core\Routing\Url::fromModuleAndCmd('error', '', $data['lang'])->toString($this->absoluteUris);
                        }
                    }
                } else {
                    $this->placeholders[$placeholder] = \Cx\Core\Routing\Url::fromModuleAndCmd('error', '', $data['lang'])->toString($this->absoluteUris);
                }
            } else {
                $this->placeholders[$placeholder] = $data->toString($this->absoluteUris);
            }
        }

        $this->fetchingDone = true;
    }

    /**
     * Replaces all variables in the given string
     * @var string $string
     */
    public function replaceIn(&$string) {
        if($this->placeholders === null)
            throw new LinkGeneratorException('Usage: scan(), then fetch(), then replace().');
        if($this->fetchingDone === false)
            throw new LinkGeneratorException('Seems like fetch() was not called before calling replace().');

        foreach($this->placeholders as $placeholder => $link) {
            $string = str_replace('{'.$placeholder.'}', $link, $string);
        }
    }
}

