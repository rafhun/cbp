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
 * KnowledgeInterface
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_knowledge
 */

/**
 * KnowledgeInterface
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_knowledge
 */
class KnowledgeInterface extends KnowledgeLibrary 
{
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Replace the placeholders
     *
     * @param unknown_type $content
     */
    public function parse(&$content)
    {
        $content = preg_replace("/{KNOWLEDGE_TAG_CLOUD}/i", $this->getTagCloud(), $content);
        $content = preg_replace("/{KNOWLEDGE_MOST_READ}/i", $this->getMostRead(), $content);
        $content = preg_replace("/{KNOWLEDGE_BEST_RATED}/i", $this->getBestRated(), $content);
    }
    
    /**
     * Return a tag cloud
     *
     * @return string
     */
    public function getTagCloud()
    {
        global $_LANGID, $objInit;
        
        $tpl = new \Cx\Core\Html\Sigma();
        CSRF::add_placeholder($tpl);
        $tpl->setErrorHandling(PEAR_ERROR_DIE);
        $template = $this->settings->formatTemplate($this->settings->get("tag_cloud_sidebar_template"));
        $tpl->setTemplate($template);
        
        
        $highestFontSize = 20;
        $lowestFontSize = 10;
        
        try {
            $tags_pop = $this->tags->getAllOrderByPopularity($_LANGID, true);
            $tags = $this->tags->getAll($_LANGID, true);
        } catch (DatabaseError $e) {
            echo $e->plain();
        }
        
        $tagCloud = new TagCloud();
        $tagCloud->setTags($tags);
        $tagCloud->setTagVals($tags_pop[0]['popularity'], $tags_pop[count($tags_pop)-1]['popularity']);
        $tagCloud->setFont(20, 10);
        $tagCloud->setUrlFormat("index.php?section=knowledge".MODULE_INDEX."&amp;tid=%id");
        
        
        $tpl->setVariable("CLOUD", $tagCloud->getCloud());
        
        //$tpl->parse("cloud");
        return $tpl->get();
    }
    
    /**
     * Return the most popular
     *
     * @return unknown
     */
    public function getBestRated()
    {
        global $_LANGID;
        
        try {
            $articles = $this->articles->getBestRated($_LANGID, $this->settings->get('best_rated_sidebar_amount'));
        } catch (DatabaseError $e) { 
            return;
        }
        
        $template = $this->settings->formatTemplate($this->settings->get("best_rated_sidebar_template"));
        
        $objTemplate = new \Cx\Core\Html\Sigma(ASCMS_THEMES_PATH);
        CSRF::add_placeholder($objTemplate);
        $objTemplate->setErrorHandling(PEAR_ERROR_DIE);
        
        $objTemplate->setTemplate($template);
        
        $max_length = $this->settings->get("best_rated_sidebar_length");
        foreach ($articles as $key => $article) {
            $question = $article['content'][$_LANGID]['question'];
            if (strlen($question) >= $max_length) {
                $question = substr($question, 0, $max_length-3)."...";
            }
            $objTemplate->setVariable(array(
                "URL"        => "index.php?section=knowledge&amp;cmd=article&amp;id=".$key,
                "ARTICLE"   => $question
            ));
            $objTemplate->parse("article");
        }
        return $objTemplate->get();
    }
    
    /**
     * Get the best rated articles
     *
     */
    public function getMostRead()
    {
        global $_LANGID;
        
        try {
           $articles = $this->articles->getMostRead($_LANGID, $this->settings->get('best_rated_sidebar_amount')); 
        } catch (DatabaseError $e) {
            return;
        }
        
        $template = $this->settings->formatTemplate($this->settings->get("most_read_sidebar_template"));
        
        $objTemplate = new \Cx\Core\Html\Sigma(ASCMS_THEMES_PATH);
        CSRF::add_placeholder($objTemplate);
        $objTemplate->setErrorHandling(PEAR_ERROR_DIE);
        
        $objTemplate->setTemplate($template);
        
        
        $max_length = $this->settings->get("most_read_sidebar_length");
        foreach ($articles as $key => $article) {
            $question = $article['content'][$_LANGID]['question'];
            if (strlen($question) >= $max_length) {
                $question = substr($question, 0, $max_length-3)."...";
            }
            $objTemplate->setVariable(array(
                "URL"       => "index.php?section=knowledge&amp;cmd=article&amp;id=".$key,
                "ARTICLE"   => $question
            ));
            $objTemplate->parse("article");
        }
        return$objTemplate->get();
    }
}
