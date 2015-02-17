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
 * Global file including
 *
 * Global file to include the required files
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Comvation Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  core
 * @version     1.0.0
 * @uses /core/validator.inc.php
 * @deprecated  Don't use this file anymore!
 * @todo Add comment for all require_once()s
 * @todo THIS FILE SHOULD BE MANDATORY!
 */

/**
 * @ignore
 */
\Env::get('ClassLoader')->loadFile(ASCMS_CORE_PATH.'/validator.inc.php');

/**
 * Checks if a certain module, specified by param $moduleName, is a core module.
 *
 * @param   string  $moduleName
 * @deprecated
 * @return  boolean
 */
function contrexx_isCoreModule($moduleName)
{
    static $objModuleChecker = NULL;

    if (!isset($objModuleChecker)) {
        $objModuleChecker = \Cx\Core\ModuleChecker::getInstance(\Env::get('em'), \Env::get('db'), \Env::get('ClassLoader'));
    }

    return $objModuleChecker->isCoreModule($moduleName);
}

/**
 * Checks if a certain module, specified by param $moduleName, is active.
 *
 * @param   string  $moduleName
 * @deprecated
 * @return  boolean
 */
function contrexx_isModuleActive($moduleName)
{
    static $objModuleChecker = NULL;

    if (!isset($objModuleChecker)) {
        $objModuleChecker = \Cx\Core\ModuleChecker::getInstance(\Env::get('em'), \Env::get('db'), \Env::get('ClassLoader'));
    }

    return $objModuleChecker->isModuleActive($moduleName);
}

/**
 * Checks if a certain module, specified by param $moduleName, is installed.
 *
 * @param   string  $moduleName
 * @deprecated
 * @return  boolean
 */
function contrexx_isModuleInstalled($moduleName)
{
    static $objModuleChecker = NULL;

    if (!isset($objModuleChecker)) {
        $objModuleChecker = \Cx\Core\ModuleChecker::getInstance(\Env::get('em'), \Env::get('db'), \Env::get('ClassLoader'));
    }

    return $objModuleChecker->isModuleInstalled($moduleName);
}


/**
 * OBSOLETE
 * Use the {@see Paging::get()} method instead.
 *
 * Returs a string representing the complete paging HTML code for the
 * current page.
 * Note that the old $pos parameter is obsolete as well,
 * see {@see getPosition()}.
 * @copyright CONTREXX CMS - COMVATION AG
 * @author    Comvation Development Team <info@comvation.com>
 * @access    public
 * @version   1.0.0
 * @global    array       $_CONFIG        Configuration
 * @global    array       $_CORELANG      Core language
 * @param     int         $numof_rows     The number of rows available
 * @param     int         $pos            The offset from the first row
 * @param     string      $uri_parameter
 * @param     string      $paging_text
 * @param     boolean     $showeverytime
 * @param     int         $results_per_page
 * @return    string      Result
 * @deprecated
 * @todo      Change the system to use the new, static class method,
 *            then remove this one.
 */
function getPaging($numof_rows, $pos, $uri_parameter, $paging_text,
    $showeverytime=false, $results_per_page=null
) {
    return Paging::get($uri_parameter, $paging_text, $numof_rows,
        $results_per_page, $showeverytime, $pos, 'pos');
}

/**
 * Builds a (partially localized) date string from the optional timestamp.
 *
 * If no timestamp is supplied, the current date is used.
 * The returned date has the form "Weekday, Day. Month Year".
 * @param   int     $unixtimestamp  Unix timestamp
 * @return  string                  Formatted date
 * @deprecated
 * @todo    The function is inappropriately named "showFormattedDate"
 *          as the date is returned, and not "shown" in any way.
 * @todo    The formatting is not localized.
 *          Use a date format constant and/or language variable template.
 */
function showFormattedDate($unixtimestamp='')
{
    global $_CORELANG;
    $months = explode(",",$_CORELANG['TXT_MONTH_ARRAY']);
    $weekday = explode(",",$_CORELANG['TXT_DAY_ARRAY']);

    if (empty($unixtimestamp)) {
        $date = date("w j n Y");
    } else {
        $date = date("w j n Y", $unixtimestamp);
    }
    list ($wday, $mday, $month, $year) = explode(' ', $date);
    $month -= 1;
    $formattedDate = "$weekday[$wday], $mday. $months[$month] $year";
    return $formattedDate;
}
