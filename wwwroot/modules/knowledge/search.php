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
 * Search script
 *
 * This script is standalone because otherwise it would be too slow.
 * @author      Stefan Heinemann <info@comvation.com>
 * @copyright   COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_knowledge
 */

/**
 * Search script
 *
 * This script is standalone because otherwise it would be too slow.
 * @author      Stefan Heinemann <info@comvation.com>
 * @copyright   COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_knowledge
 */

global $objDatabase;
require_once dirname(__FILE__).'/../../core/Core/init.php';
$cx = init('minimal');
$objDatabase = $cx->getDb()->getAdoDb();

require_once(ASCMS_MODULE_PATH.'/knowledge/lib/databaseError.class.php');

//require_once '../../lib/CSRF.php';
// Temporary fix until all GET operation requests will be replaced by POSTs
//CSRF::setFrontendMode();

if (!defined('FRONTEND_LANG_ID') && !empty($_GET['lang'])) {
    define('FRONTEND_LANG_ID', \FWLanguage::getLanguageIdByCode($_GET['lang']));
}

require_once(ASCMS_MODULE_PATH.'/knowledge/lib/search.php');
$search = new Search();
$search->performSearch();
die();
