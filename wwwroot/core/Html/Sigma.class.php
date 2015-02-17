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
 * Sigma
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  core_html
 */

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cx\Core\Html;

/**
 * Description of Sigma
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author Michael Ritter <michael.ritter@comvation.com>
 * @package     contrexx
 * @subpackage  core_html
 */
class Sigma extends \HTML_Template_Sigma {
    
    public function __construct($root = '', $cacheRoot = '') {
        parent::__construct($root, $cacheRoot);
        $this->setErrorHandling(PEAR_ERROR_DIE);
    }
    
    /**
     * Reads the file and returns its content
     *
     * @param    string    filename
     * @return   string    file content (or error object)
     * @access   private
     */
    function _getFile($filename)
    {
        $filename = \Env::get('ClassLoader')->getFilePath($filename);
        if (!($fh = @fopen($filename, 'r'))) {
            return $this->raiseError($this->errorMessage(SIGMA_TPL_NOT_FOUND, $filename), SIGMA_TPL_NOT_FOUND);
        }
        $content = fread($fh, filesize($filename));
        fclose($fh);
        return $content;
    }
    
    function getRoot() {
        return $this->fileRoot;
    }
}
