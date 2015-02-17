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
 * Block
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Comvation Development Team <info@comvation.com>
 * @version     1.0.0
 * @package     contrexx
 * @subpackage  module_block
 * @todo        Edit PHP DocBlocks!
 */


/**
 * Block
 *
 * block module class
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Comvation Development Team <info@comvation.com>
 * @access      public
 * @version     1.0.0
 * @package     contrexx
 * @subpackage  module_block
 */
class block extends blockLibrary
{
    public static function setBlocks(&$content, $page)
    {
        $config = Env::get('config');

        $objBlock = new block();

        if (!is_array($content)) {
            $arrTemplates = array(&$content);
        } else {
            $arrTemplates = &$content;
        }

        foreach ($arrTemplates as &$template) { 
            // Set blocks [[BLOCK_<ID>]]
            if (preg_match_all('/{'.$objBlock->blockNamePrefix.'([0-9]+)}/', $template, $arrMatches)) {
                $objBlock->setBlock($arrMatches[1], $template, $page->getId());
            }

            // Set global block [[BLOCK_GLOBAL]]
            if (preg_match('/{'.$objBlock->blockNamePrefix.'GLOBAL}/', $template)) {
                $objBlock->setBlockGlobal($template, $page->getId());
            }

            // Set category blocks [[BLOCK_CAT_<ID>]]
            if (preg_match_all('/{'.$objBlock->blockNamePrefix.'CAT_([0-9]+)}/', $template, $arrMatches)) {
                $objBlock->setCategoryBlock($arrMatches[1], $template, $page->getId());
            }

            /* Set random blocks [[BLOCK_RANDOMIZER]], [[BLOCK_RANDOMIZER_2]],
                                 [[BLOCK_RANDOMIZER_3]], [[BLOCK_RANDOMIZER_4]] */
            if ($config['blockRandom'] == '1') {
                $placeholderSuffix = '';

                $randomBlockIdx = 1;

                while ($randomBlockIdx <= 4) {
                    if (preg_match('/{'.$objBlock->blockNamePrefix.'RANDOMIZER'.$placeholderSuffix.'}/', $template)) {
                        $objBlock->setBlockRandom($template, $randomBlockIdx);
                    }

                    $randomBlockIdx++;
                    $placeholderSuffix = '_'.$randomBlockIdx;
                }
            }
        }
    }


    /**
    * Set block
    *
    * Parse a block
    *
    * @access public
    * @param array $arrBlocks
    * @param string &$code
    * @param int $pageId
    * @see blockLibrary::_setBlock()
    */
    function setBlock($arrBlocks, &$code, $pageId)
    {
        foreach ($arrBlocks as $blockId) {
            $this->_setBlock(intval($blockId), $code, $pageId);
        }
    }


    /**
    * Set category block
    *
    * Parse a category block
    *
    * @access public
    * @param array $arrCategoryBlocks
    * @param string &$code
    * @param int $pageId
    * @see blockLibrary::_setBlock()
    */
    function setCategoryBlock($arrCategoryBlocks, &$code, $pageId)
    {
        foreach ($arrCategoryBlocks as $blockId) {
            $this->_setCategoryBlock(intval($blockId), $code, $pageId);
        }
    }

    /**
    * Set block Random
    *
    * Parse a block Random
    *
    * @access public
    * @param array $arrBlocks
    * @param string &$code
    * @see blockLibrary::_setBlock()
    */
    function setBlockRandom(&$code, $id)
    {
        $this->_setBlockRandom($code, $id);
    }

    function setBlockGlobal(&$code, $pageId)
    {
        $this->_setBlockGlobal($code, $pageId);
    }
}
?>
