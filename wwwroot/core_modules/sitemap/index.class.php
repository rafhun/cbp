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
 * Sitemapping
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author Comvation Development Team <info@comvation.com>
 * @version 1.0.1
 * @package     contrexx
 * @subpackage  coremodule_sitemap
 * @todo        Edit PHP DocBlocks!
 */

/**
 * Sitemap
 *
 * Class for the sitemap
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author Comvation Development Team <info@comvation.com>
 * @access public
 * @version 1.0.1
 * @package     contrexx
 * @subpackage  coremodule_sitemap
 */
class sitemap
{
    var $pageContent;
    var $_objTpl;
    var $_sitemapPageName = array();
    var $_sitemapPageURL = array();
    var $_sitemapPageLevel = array();
    var $_sitemapPageTarget = array();
    var $_arrName = array();
    var $_arrUrl = array();
    var $_arrTarget = array();
    var $_doSitemap = true;
    var $_sitemapBlock;
    var $_cssPrefix = "sitemap_level_";
    var $_subTagStart = "<ul>";
    var $_subTagEnd = "</ul>";


    /**
    * Constructor
    *
    * @param  string
    * @access public
    */
    function __construct($pageContent, $license)
    {
        $this->pageContent = $pageContent;
        $this->_objTpl = new \Cx\Core\Html\Sigma('.');
        CSRF::add_placeholder($this->_objTpl);
        $this->_objTpl->setErrorHandling(PEAR_ERROR_DIE);

        $this->_objTpl->setTemplate($this->pageContent);

        if(isset($this->_objTpl->_blocks['sitemap'])) {
            $sm = new \Cx\Core\PageTree\SitemapPageTree(Env::em(), $license, 0, null, FRONTEND_LANG_ID);
            $sm->setVirtualLanguageDirectory(Env::get('virtualLanguageDirectory'));
            $sm->setTemplate($this->_objTpl);
            $sm->render();
        }
       
        /*        if (isset($this->_objTpl->_blocks['sitemap'])) {
            $this->_initialize();
            $this->_doSitemapArray();
        } else {
            $this->_doSitemap = false;
            }*/
    }



    function getSitemapContent() {
        return $this->_objTpl->get();
        //        return $this->doSitemap();
    }


    /*
    * Do shop categories menu
    *
    * @param    integer  $parcat
    * @param    integer  $level
    * @param    integer  $selectedid
    * @return   string   $result
    */
    function _doSitemapArray($parcat=0,$level=0)
    {
        $list = $this->_arrName[$parcat];
        if (is_array($list)) {
            while (list($key,$val) = each($list)) {
                $this->_sitemapPageName[$key] = $val;
                $this->_sitemapPageURL[$key] = $this->_arrUrl[$key];
                $this->_sitemapPageLevel[$key] = $level;
                $this->_sitemapPageTarget[$key] = $this->_arrTarget[$key];

                if (isset($this->_arrName[$key])) {
                    $this->_doSitemapArray($key,$level+1);
                }
            }
        }
    }


    /**
    * Do Sitemap rows
    *
    */
    function doSitemap()
    {
        if ($this->_doSitemap && is_array($this->_sitemapPageName)) {
            $this->_sitemapBlock = trim($this->_objTpl->_blocks['sitemap']);
            if (ereg('.*{SUB_MENU}.*', $this->_sitemapBlock)) {
                $nestedSitemap = $this->_subTagStart.$this->_buildNestedSitemap().$this->_subTagEnd."\n";
                return ereg_replace('<!-- BEGIN sitemap -->.*<!-- END sitemap -->', $nestedSitemap, $this->pageContent);
            } else {
                while (list($key,$val) = each($this->_sitemapPageName)) {
                    $lvl = $this->_sitemapPageLevel[$key]+1;
                    $cssStyle = $this->_cssPrefix.$lvl;
                    if ($this->_sitemapPageLevel[$key]!=0){
                        $width=$this->_sitemapPageLevel[$key]*25;
                    } else {
                        $width=1;
                    }
                    $spacer = "<img src='".ASCMS_MODULE_IMAGE_WEB_PATH."/sitemap/spacer.gif' width='$width' height='12' alt='' />";

                    $this->_objTpl->setVariable(array(
                        'STYLE'     => $cssStyle,
                        'SPACER'    => $spacer,
                        'NAME'      => $val,
                        'TARGET'    => $this->_sitemapPageTarget[$key],
                        'URL'       => $this->_sitemapPageURL[$key]
                    ));
                    $this->_objTpl->parse("sitemap");
                }
            }
        }
        return $this->_objTpl->get();
    }




    function _buildNestedSitemap($key = 0)
    {
        $sitemapBlock = "";

        foreach ($this->_arrName[$key] as $pageId => $pageTitle) {
            if (isset($this->_arrName[$pageId])) {
                $subPages = $this->_subTagStart.$this->_buildNestedSitemap($pageId).$this->_subTagEnd."\n";
            } else {
                $subPages = "";
            }

            if ($this->_sitemapPageLevel[$pageId] != 0) {
                $width = $this->_sitemapPageLevel[$pageId]*25;
            } else {
                $width = 1;
            }
            $spacer = "<img src='".ASCMS_MODULE_IMAGE_WEB_PATH."/sitemap/spacer.gif' width='$width' height='12' alt='' />";

            $tmpSitemapBlock = $this->_sitemapBlock;

            $tmpSitemapBlock = str_replace('{STYLE}', $this->_cssPrefix.($this->_sitemapPageLevel[$pageId]+1), $tmpSitemapBlock);
            $tmpSitemapBlock = str_replace('{SPACER}', $spacer, $tmpSitemapBlock);
            $tmpSitemapBlock = str_replace('{NAME}', $this->_sitemapPageName[$pageId], $tmpSitemapBlock);
            $tmpSitemapBlock = str_replace('{TARGET}', $this->_sitemapPageTarget[$pageId], $tmpSitemapBlock);
            $tmpSitemapBlock = str_replace('{URL}', $this->_sitemapPageURL[$pageId], $tmpSitemapBlock);
            $tmpSitemapBlock = str_replace('{SUB_MENU}', $subPages, $tmpSitemapBlock);

            $sitemapBlock .= $tmpSitemapBlock."\n";
        }
        return $sitemapBlock;
    }
}
?>
