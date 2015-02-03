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
 * JSON Adapter for Block module
 * @copyright   Comvation AG
 * @author      Michael Ritter <michael.ritter@comvation.com>
 * @package     contrexx
 * @subpackage  core_json
 */

namespace Cx\Core\Json\Adapter\Block;
use \Cx\Core\Json\JsonAdapter;

/**
 * Class NoPermissionException
 * @package     contrexx
 * @subpackage  core_json
 */
class NoPermissionException extends \Exception {}

/**
 * Class NotEnoughArgumentsException
 * @package     contrexx
 * @subpackage  core_json
 */
class NotEnoughArgumentsException extends \Exception {}

/**
 * Class NoBlockFoundException
 * @package     contrexx
 * @subpackage  core_json
 */
class NoBlockFoundException extends \Exception {}

/**
 * Class BlockCouldNotBeSavedException
 * @package     contrexx
 * @subpackage  core_json
 */
class BlockCouldNotBeSavedException extends \Exception {}

/**
 * JSON Adapter for Block module
 * @copyright   Comvation AG
 * @author      Michael Ritter <michael.ritter@comvation.com>
 * @package     contrexx
 * @subpackage  core_json
 */
class JsonBlock implements JsonAdapter {
    /**
     * List of messages
     * @var Array 
     */
    private $messages = array();
    
    /**
     * Returns the internal name used as identifier for this adapter
     * @return String Name of this adapter
     */
    public function getName() {
        return 'block';
    }
    
    /**
     * Returns an array of method names accessable from a JSON request
     * @return array List of method names
     */
    public function getAccessableMethods() {
        return array('getBlocks', 'getBlockContent', 'saveBlockContent');
    }

    /**
     * Returns all messages as string
     * @return String HTML encoded error messages
     */
    public function getMessagesAsString() {
        return implode('<br />', $this->messages);
    }
    
    /**
     * Returns all available blocks for each language
     * @return array List of blocks (lang => id )
     */
    public function getBlocks() {
        global $objInit, $_CORELANG;
        
        if (!\FWUser::getFWUserObject()->objUser->login() || $objInit->mode != 'backend') {
            throw new \Exception($_CORELANG['TXT_ACCESS_DENIED_DESCRIPTION']);
        }
        
        $blockLib = new \blockLibrary();
        $blocks = $blockLib->getBlocks();
        $data = array();
        foreach ($blocks as $id=>$block) {
            $data[$id] = array(
                'id' => $id,
                'name' => $block['name'],
                'disabled' => $block['global'] == 1,
                'selected' => $block['global'] == 1,
            );
        }
        return $data;
    }
    
    /**
     * Get the block content as html
     * 
     * @param array $params all given params from http request
     * @throws \Cx\Core\Json\Adapter\Block\NoPermissionException
     * @throws \Cx\Core\Json\Adapter\Block\NotEnoughArgumentsException
     * @throws \Cx\Core\Json\Adapter\Block\NoBlockFoundException
     * @return string the html content of the block
     */
    public function getBlockContent($params) {
        global $_CORELANG, $objDatabase;
        
        // security check
        if (   !\FWUser::getFWUserObject()->objUser->login()
            || !\Permission::checkAccess(76, 'static', true)) {
            throw new \Cx\Core\Json\Adapter\Block\NoPermissionException($_CORELANG['TXT_ACCESS_DENIED_DESCRIPTION']);
        }
        
        // check for necessary arguments
        if (empty($params['get']['block']) || empty($params['get']['lang'])) {
            throw new \Cx\Core\Json\Adapter\Block\NotEnoughArgumentsException('not enough arguments');
        }
        
        // get id and langugage id
        $id = intval($params['get']['block']);
        $lang = \FWLanguage::getLanguageIdByCode($params['get']['lang']);
        if (!$lang) {
            $lang = FRONTEND_LANG_ID;
        }
        
        // database query to get the html content of a block by block id and
        // language id
        $query = "SELECT
                      c.content
                  FROM
                      `".DBPREFIX."module_block_blocks` b
                  INNER JOIN
                      `".DBPREFIX."module_block_rel_lang_content` c
                  ON c.block_id = b.id
                  WHERE
                      b.id = ".$id."
                  AND
                      (c.lang_id = ".$lang." AND c.active = 1)";

        $result = $objDatabase->Execute($query);
        
        // nothing found
        if ($result === false || $result->RecordCount() == 0) {
            throw new \Cx\Core\Json\Adapter\Block\NoBlockFoundException('no block content found with id: ' . $id);
        }

        $ls = new \LinkSanitizer(ASCMS_PATH_OFFSET.\Env::get('virtualLanguageDirectory').'/', $result->fields['content']);
        return array('content' => $ls->replace());
    }
    
    /**
     * Save the block content
     * 
     * @param array $params all given params from http request
     * @throws \Cx\Core\Json\Adapter\Block\NoPermissionException
     * @throws \Cx\Core\Json\Adapter\Block\NotEnoughArgumentsException
     * @throws \Cx\Core\Json\Adapter\Block\BlockCouldNotBeSavedException
     * @return boolean true if everything finished with success
     */
    public function saveBlockContent($params) {
        global $_CORELANG, $objDatabase;
        
        // security check
        if (   !\FWUser::getFWUserObject()->objUser->login()
            || !\Permission::checkAccess(76, 'static', true)) {
            throw new \Cx\Core\Json\Adapter\Block\NoPermissionException($_CORELANG['TXT_ACCESS_DENIED_DESCRIPTION']);
        }
        
        // check arguments
        if (empty($params['get']['block']) || empty($params['get']['lang'])) {
            throw new \Cx\Core\Json\Adapter\Block\NotEnoughArgumentsException('not enough arguments');
        }
        
        // get language and block id
        $id = intval($params['get']['block']);
        $lang = \FWLanguage::getLanguageIdByCode($params['get']['lang']);
        if (!$lang) {
            $lang = FRONTEND_LANG_ID;
        }
        $content = $params['post']['content'];
        
        // query to update content in database
        $query = "UPDATE `".DBPREFIX."module_block_rel_lang_content`
                      SET content = '".\contrexx_input2db($content)."'
                  WHERE
                      block_id = ".$id." AND lang_id = ".$lang;
        $result = $objDatabase->Execute($query);
        
        // error handling
        if ($result === false) {
            throw new \Cx\Core\Json\Adapter\Block\BlockCouldNotBeSavedException('block could not be saved');
        }
        \LinkGenerator::parseTemplate($content);
        
        $ls = new \LinkSanitizer(ASCMS_PATH_OFFSET.\Env::get('virtualLanguageDirectory').'/', $content);
        $this->messages[] = $_CORELANG['TXT_CORE_SAVED_BLOCK'];
        
        return array('content' => $ls->replace());
    }
}
