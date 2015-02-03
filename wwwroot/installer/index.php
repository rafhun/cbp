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
 * Install Wizard Controller
 *
 * The Install Wizard
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author        Comvation Development Team <info@comvation.com>
 * @version       $Id:     Exp $
 * @package     contrexx
 * @subpackage  installer
 * @todo        Edit PHP DocBlocks!
 */

@ini_set('display_errors', 0);
@error_reporting(E_ALL);

$php = phpversion();
if ($php < '5.3') {
    die('Das Contrexx CMS ben&ouml;tigt mindestens PHP in der Version 5.3.<br />Auf Ihrem System l&auml;uft PHP '.$php);
}

$offsetPath = '';
$arrDirectories = explode('/', $_SERVER['SCRIPT_NAME']);
for ($i = 0;$i < count($arrDirectories)-2;$i++) {
    if ($arrDirectories[$i] !== '') {
        $offsetPath .= '/'.$arrDirectories[$i];
    }
}

session_set_cookie_params(0, $offsetPath);
session_start();

$basePath = realpath(dirname(__FILE__));

if (!@include_once($basePath.'/config/config.php')) {
    die('Unable to load file '.$basePath.'/config/config.php');
}

require_once($basePath.'/classloader.inc.php');

@header('content-type: text/html; charset='.($useUtf8 ? 'UTF-8' : 'ISO-8859-1'));

if (!@include_once(ASCMS_LIBRARY_PATH.'/PEAR/HTML/Template/Sigma/Sigma.php')) {
    die('Unable to load file '.ASCMS_LIBRARY_PATH.'/PEAR/HTML/Template/Sigma/Sigma.php');
}
if (!@include_once($basePath.'/common.class.php')) {
    die('Unable to load file '.$basePath.'/common.class.php');
}
if (!@include_once($basePath.'/installer.class.php')) {
    die('Unable to load file '.$basePath.'/installer.class.php');
}
if (!@include_once($basePath.'/../core/Env.class.php')) {
    die('Unable to load file '.$basePath.'/../core/Env.class.php');
}

$objCommon = new CommonFunctions;
$objInstaller = new Installer;

$objCommon->initLanguage();
$objTpl = new HTML_Template_Sigma($templatePath);
$objTpl->setErrorHandling(PEAR_ERROR_DIE);
$objTpl->loadTemplateFile('index.html');
$objTpl->setVariable('CHARSET', ($useUtf8 ? 'UTF-8' : 'ISO-8859-1'));

$objTpl->setVariable($_ARRLANG);
$objInstaller->checkOptions();
$objInstaller->getNavigation();
$objInstaller->getPage();
$objInstaller->getContentNavigation();

$objTpl->show();
