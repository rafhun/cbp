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
 * searchKnowledge
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_knowledge
 */

if (!defined("MODULE_INDEX")) {
    define("MODULE_INDEX", "");
}

/**
 * searchKnowledge
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_knowledge
 */
class searchKnowledge extends SearchInterface  {
    private $term;
    private $results = array();

    public function search($term)
    {
        $this->term = addslashes($term);

        $this->parseResults($this->searchArticles(), "formatArticleURI");

// TODO: the search for categories has been deactivated due that the parsing method in the index.class.php isn't ready to parse categories.
//       $this->parseResults($this->searchCategories(), "formatCategoryURI");

        return $this->results;
    }

    /**
     * Search the articles
     *
     * @return object
     */
    private function searchArticles()
    {
        global $objDatabase;

        $query = "  SELECT articles.id as id, content.question as title, MATCH (content.answer, content.question) AGAINST ('%".$this->term."%' IN BOOLEAN MODE) as Relevance
                    FROM `".DBPREFIX."module_knowledge".MODULE_INDEX."_articles` AS articles
                    INNER JOIN `".DBPREFIX."module_knowledge".MODULE_INDEX."_article_content` AS content ON articles.id = content.article
                    WHERE lang = ".FRONTEND_LANG_ID."
                    AND active = 1
                    AND (   content.answer like '%".$this->term."%' OR
                            content.question like '%".$this->term."%')
                    ORDER BY Relevance DESC";
        if (($rs = $objDatabase->Execute($query)) === false) {
            throw new DatabaseError("error searching knowledge articles");
        }

        return $rs;
    }

    /**
     * Search the categories
     *
     * @return object
     */
    private function searchCategories()
    {
        global $objDatabase;

        $query = "  SELECT categories.id as id , content.name as title, MATCH (content.name) AGAINST ('".htmlentities($this->term, ENT_QUOTES, CONTREXX_CHARSET)."' IN BOOLEAN MODE) as Relevance
                    FROM `".DBPREFIX."module_knowledge".MODULE_INDEX."_categories_content` AS content
                    INNER JOIN `".DBPREFIX."module_knowledge".MODULE_INDEX."_categories` AS categories ON content.category = categories.id
                    WHERE lang = ".FRONTEND_LANG_ID."
                    AND active = 1
                    AND MATCH (content.name) AGAINST ('".htmlentities($this->term, ENT_QUOTES, CONTREXX_CHARSET)."' IN BOOLEAN MODE) HAVING Relevance > 0.2
                    ORDER BY Relevance DESC";
        if (($rs = $objDatabase->Execute($query)) === false) {
            throw new DatabaseError("error searching knowledge".MODULE_INDEX." categories");
        }

        return $rs;
    }

    /**
     * Parse query results
     *
     * Loop through the query results and assign them to the
     * result array. $cb is the reference function which is to be
     * called to generate a proper URI.
     * @param object $rs
     * @param reference $cb
     */
    private function parseResults($rs, $cb)
    {
        while (!$rs->EOF) {
            $this->results[] = array(
                "uri"       => $this->$cb($rs->fields['id']),
                "title"     => contrexx_stripslashes($rs->fields['title']),
                "id"        => contrexx_stripslashes($rs->fields['id'])
            );

            $rs->MoveNext();
        }
    }

    /**
     * Format a category URI
     *
     * Add the necessary stuff so there's a real URI in the
     * end.
     * @param int $id
     * @return string
     */
    private function formatCategoryURI($id)
    {
        return "index.php?section=knowledge".MODULE_INDEX."&amp;id=".intval($id);
    }

    /**
     * Format an article URI
     *
     * @param int $id
     * @return string
     */
    private function formatArticleURI($id)
    {
        return "index.php?section=knowledge".MODULE_INDEX."&cmd=article&amp;id=".intval($id);
    }
}

?>
