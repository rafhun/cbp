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
 * Index Class CRM
 *
 * @category   Crm
 * @package    contrexx
 * @subpackage module_crm
 * @author     SoftSolutions4U Development Team <info@softsolutions4u.com>
 * @copyright  2012 and CONTREXX CMS - COMVATION AG
 * @license    trial license
 * @link       www.contrexx.com
 */

/**
 * Index Class CRM
 *
 * @category   Crm
 * @package    contrexx
 * @subpackage module_crm
 * @author     SoftSolutions4U Development Team <info@softsolutions4u.com>
 * @copyright  2012 and CONTREXX CMS - COMVATION AG
 * @license    trial license
 * @link       www.contrexx.com
 */
class Crm
{
	/**
	* Template object
	*
	* @access private
	* @var object
	*/
	var $_objTpl;

	/**
	* Module Name
	*
	* @access private
	* @var object
	*/
        var $moduleName = 'crm';
	
	/**
	* Constructor
         *
         * @param string $pageContent page content
	*/
	function Crm($pageContent)
	{

		$this->__construct($pageContent);
	}
	
	/**
	* PHP5 constructor
	*
        * @param string $pageContent page content
        *
	* @global object $objTemplate
	* @global array $_ARRAYLANG
	*/
	function __construct($pageContent)
	{
        //$this->_intLanguageId = intval($_LANGID);
        $this->_objTpl = new HTML_Template_Sigma('.');
		$this->_objTpl->setErrorHandling(PEAR_ERROR_DIE);
		$this->_objTpl->setTemplate($pageContent);
	}

	/**
	* Get content page
	*
	* @access public
	*/
	function getPage() 
	{

 		return $this->_objTpl->get();
	}
}
?>
