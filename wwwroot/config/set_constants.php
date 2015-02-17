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
 * @copyright   CONTREXX CMS - COMVATION AG
 * @package     contrexx
 * @subpackage  config
 * @todo        Edit PHP DocBlocks!
 */

global $_PATHCONFIG, $_DBCONFIG, $_CONFIG;
static $match = null;

/**
 * Define constants
 */
define('ASCMS_PATH',                        $_PATHCONFIG['ascms_installation_root']);
define('ASCMS_PATH_OFFSET',                 $_PATHCONFIG['ascms_installation_offset']); // example '/cms'
define('ASCMS_INSTANCE_PATH',               $_PATHCONFIG['ascms_root']);
define('ASCMS_INSTANCE_OFFSET',             $_PATHCONFIG['ascms_root_offset']);
define('ASCMS_BACKEND_PATH',                '/cadmin');
define('ASCMS_PROTOCOL',                    empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == 'off' ? 'http' : 'https');
define('ASCMS_WEBSERVER_SOFTWARE',          !empty($_SERVER['SERVER_SOFTWARE']) && stristr($_SERVER['SERVER_SOFTWARE'], 'apache') ? 'apache' : (!empty($_SERVER['SERVER_SOFTWARE']) && stristr($_SERVER['SERVER_SOFTWARE'], 'iis') ? 'iis' : ''));

define('CONTREXX_ESCAPE_GPC',               get_magic_quotes_gpc());
define('CONTREXX_CHARSET',                  $_CONFIG['coreCharacterEncoding']);
define('CONTREXX_PHP5',                     version_compare(PHP_VERSION, '5', '>='));
define('CONTREXX_DIRECTORY_INDEX',          'index.php');

define('DBPREFIX',                          $_DBCONFIG['tablePrefix']);
define('ASCMS_DOCUMENT_ROOT',               ASCMS_PATH.ASCMS_PATH_OFFSET);
define('ASCMS_CUSTOMIZING_PATH',            ASCMS_INSTANCE_PATH.ASCMS_INSTANCE_OFFSET.'/customizing');
define('ASCMS_CUSTOMIZING_WEB_PATH',        ASCMS_INSTANCE_OFFSET.'/customizing');

require_once ASCMS_DOCUMENT_ROOT.'/config/settings.php';

if (
    isset($_CONFIG['useCustomizings']) && $_CONFIG['useCustomizings'] == 'on' &&
    file_exists(ASCMS_CUSTOMIZING_PATH.'/config/SetCustomizableConstants.php')
) {
    require_once ASCMS_CUSTOMIZING_PATH.'/config/SetCustomizableConstants.php';
    
    // load constants from basepath
} else if (file_exists(ASCMS_DOCUMENT_ROOT.'/config/SetCustomizableConstants.php')) {
    require_once ASCMS_DOCUMENT_ROOT.'/config/SetCustomizableConstants.php';
}
