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
 * Validator
 *
 * Global request validator
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Comvation Development Team <info@comvation.com>
 * @access      public
 * @version     1.0.0
 * @package     contrexx
 * @subpackage  core
 * @todo        Edit PHP DocBlocks!
 * @todo        Isn't this supposed to be a class?
 */

if (stristr(__FILE__, $_SERVER['PHP_SELF'])) {
    Header("Location: index.php");
    die();
}


/**
 * Wrapper for strip_tags() that complies with gpc_magic_quotes
 * @param     string     $string
 * @return    string     $string (cleaned)
 */
function contrexx_strip_tags($string)
{
    if (CONTREXX_ESCAPE_GPC) return strip_tags($string);
    return addslashes(strip_tags($string));
}


/**
 * Wrapper for addslashes() that complies with gpc_magic_quotes
 * @param     string     $string
 * @return    string              cleaned
 */
function contrexx_addslashes($string)
{
    // If magic quotes is on the string is already quoted,
    // just return it
    if (CONTREXX_ESCAPE_GPC) return $string;
    return addslashes($string);
}


/**
 * Wrapper for stripslashes() that complies with gpc_magic_quotes
 * @param   string    $string
 * @return  string
 */
function contrexx_stripslashes($string)
{
    if (CONTREXX_ESCAPE_GPC) return stripslashes($string);
    return $string;
}


/**
 * Processes the argument like {@see contrexx_stripslashes()}, but also
 * handles arrays
 *
 * Recurses down into array parameters and applies
 * {@see contrexx_stripslashes()} to any scalar value encountered.
 * @param   mixed   $param      A scalar or array value
 * @return  mixed               The parameter with magic slashes removed
 *                              recursively, if any.
 */
function contrexx_stripslashes_recursive($param)
{
    if (is_array($param)) {
        foreach ($param as &$thing) {
            $thing = contrexx_stripslashes_recursive($thing);
        }
        return $param;
    }
    return contrexx_stripslashes($param);
}


/**
 * Convenient match-and-replace-in-one function
 *
 * Parameters are those of preg_match() and preg_replace() combined.
 * @param   string  $pattern      The regex pattern to match
 * @param   string  $replace      The replacement string for matches
 * @param   string  $subject      The string to be matched/replaced on
 * @param   array   $subpatterns  The optional array for the matches found
 * @param   integer $limit        The optional limit for replacements
 * @param   integer $count        The optional counter for the replacements done
 * @return  string                The resulting string
 */
function preg_match_replace(
    $pattern, $replace, $subject, &$subpatterns=null, $limit=-1, &$count=null
) {
    if (preg_match($pattern, $subject, $subpatterns)) {
        $subject = preg_replace($pattern, $replace, $subject, $limit, $count);
        return $subject;
    }
    return $subject;
}


/**
 * Checks whether the request comes from a known spider
 * @return  boolean
 */
function checkForSpider()
{
    $arrRobots = array();
    require_once ASCMS_CORE_MODULE_PATH.'/stats/lib/spiders.inc.php';
    $useragent =  htmlspecialchars($_SERVER['HTTP_USER_AGENT'], ENT_QUOTES, CONTREXX_CHARSET);
    foreach ($arrRobots as $spider) {
        $spiderName = trim($spider);
        if (preg_match('/'.preg_quote($spiderName, '/').'/', $useragent)) {
            return true;
        }
    }
    return false;
}


/////////////////////////////////////////////////////////////
// Convenience escaping function layer - use these rather than
// contrexx_addslashes() and so on please.

/**
 * Encodes raw strings or arrays thereof for use with [X]HTML
 *
 * Apply to raw strings and those taken from the database, or arrays of
 * these, before writing the contents to the HTML response stream.
 * Note that arrays may be nested, and all scalar (leaf) elements are treated
 * the same way.  Array keys are preserved.
 * @param   mixed     $raw      The raw string or array
 * @return  mixed               The HTML encoded string or array
 * @author  Severin Raez <severin.raez@comvation.com>
 * @author  Reto Kohli <reto.kohli@comvation.com>
 */
function contrexx_raw2xhtml($raw)
{
    if (is_array($raw)) {
        $arr = array();
        foreach ($raw as $i => $_raw) {
            $arr[$i] = contrexx_raw2xhtml($_raw);
        }
        return $arr;
    }
    return htmlentities($raw, ENT_QUOTES, CONTREXX_CHARSET);
}


/**
 * Unescapes data from any request and returns a raw string or an array
 * thereof.
 *
 * Apply to any string or array taken from a get or post request, or from a
 * cookie.
 * @param   mixed   $input    The input string or array
 * @return  mixed             The raw string or array
 */
function contrexx_input2raw($input)
{
    if (is_array($input)) {
        $arr = array();
        foreach ($input as $i => $_input) {
            $arr[$i] = contrexx_input2raw($_input);
        }
        return $arr;
    }
    return contrexx_stripslashes($input);
}


/**
 * Ensures that data from any request is limited to integer values
 *
 * Apply to any string or array taken from a get or post request, or from a
 * cookie.
 * @param   mixed   $input    The input string or array
 * @return  mixed             The integer or array thereof
 * @author  Reto Kohli <reto.kohli@comvation.com>
 */
function contrexx_input2int($input)
{
    if (is_array($input)) {
        $arr = array();
        foreach ($input as $i => $_input) {
            $arr[$i] = contrexx_input2int($_input);
        }
        return $arr;
    }
    return intval($input);
}


/**
 * Ensures that data from any request is limited to float values
 *
 * Apply to any string or array taken from a get or post request, or from a
 * cookie.
 * @param   mixed   $input    The input string or array
 * @return  mixed             The float or array thereof
 * @author  Reto Kohli <reto.kohli@comvation.com>
 */
function contrexx_input2float($input)
{
    if (is_array($input)) {
        $arr = array();
        foreach ($input as $i => $_input) {
            $arr[$i] = contrexx_input2float($_input);
        }
        return $arr;
    }
    return floatval($input);
}


/**
 * Unescapes data from any request and adds slashes for insertion into the
 * database
 *
 * Apply to any string or array taken from a get or post request, or from a
 * cookie before inserting into the database.
 * @param   mixed   $input    The input string or array
 * @return  mixed             The unescaped slashed string or array
 */
function contrexx_input2db($input)
{
    return contrexx_raw2db(contrexx_input2raw($input));
}


/**
 * Unescapes data from any request and encodes it for use with [X]HTML
 *
 * Apply to any string or array taken from a get or post request, or from a
 * cookie before writing it to the HTML response stream.
 * @param   mixed   $input    The input string or array
 * @return  mixed             The unescaped HTML encoded string or array
 */
function contrexx_input2xhtml($input)
{
    return contrexx_raw2xhtml(contrexx_input2raw($input));
}


/**
 * Adds slashes to the given raw string or array thereof for insertion
 * into the database.
 * @param   mixed     $raw      The raw string or array
 * @return  mixed               The slashed string or array
 */
function contrexx_raw2db($raw)
{
    if (is_array($raw)) {
        $arr = array();
        foreach ($raw as $i => $_raw) {
            $arr[$i] = contrexx_raw2db($_raw);
        }
        return $arr;
    }
    return addslashes($raw);
}


/**
 * Encodes a raw string or array thereof for use with XML
 *
 * Apply to raw strings and those taken from the database or arrays thereof
 * before writing to the XML response stream.
 * @param   mixed     $raw      The raw string or array
 * @return  mixed               The XML encoded string or array
 */
function contrexx_raw2xml($raw)
{
    if (is_array($raw)) {
        $arr = array();
        foreach ($raw as $i => $_raw) {
            $arr[$i] = contrexx_raw2xml($_raw);
        }
        return $arr;
    }
    return htmlspecialchars($raw, ENT_QUOTES, CONTREXX_CHARSET);
}


/**
 * Encodes a raw string or array thereof for use as a href or src
 * attribute value.
 *
 * Apply to any raw string or array that is to be used as a link or image
 * address in any tag attribute, such as a.href or img.src.
 * @param   mixed   $source       The raw string or array
 * @param   boolean $encodeDash   Encode dashes ('-') if true.
 *                                Defaults to false
 * @return  mixed                 The URL encoded string or array
 */
function contrexx_raw2encodedUrl($source, $encodeDash=false)
{
    if (is_array($source)) {
        $arr = array();
        foreach ($source as $i => $_source) {
            $arr[$i] = contrexx_raw2encodedUrl($_source, $encodeDash);
        }
        return $arr;
    }
    $cutHttp = false;
    if (!$encodeDash && substr($source, 0, 7) == 'http://') {
        $source = substr($source, 7);
        $cutHttp = true;
    }
    $source = array_map('rawurlencode', explode('/', $source));
    if ($encodeDash) {
        $source = str_replace('-', '%2D', $source);
    }
    $result = implode('/', $source);
    if ($cutHttp) $result = 'http://'.$result;
    return $result;
}


/**
 * Removes script tags and their content from the given string or array thereof
 * @param   mixed   $raw    The original string or array
 * @return  mixed           The string or array with script tags removed
 * @todo    Check for event handlers
 */
function contrexx_remove_script_tags($raw)
{
    if (is_array($raw)) {
        $arr = array();
        foreach ($raw as $i => $_raw) {
            $arr[$i] = contrexx_remove_script_tags($_raw);
        }
        return $arr;
    }
    // Remove closed script tags and content
    $result = preg_replace('/<\s*script[^>]*>.*?<\s*\\/script\s*>/is', '', $raw);
    // Remove unclosed script tags
    $result = preg_replace('/<\s*script[^>]*>/is', '', $result);
    return $result;
}


/**
 * Extracts the plaintext out of a html code
 *
 * @param   mixed   $html   The html code as string or an array containing
 *                          multiple html code strings
 * @return  mixed           The plaintext of the provided html code
 */
function contrexx_html2plaintext($html)
{
    if (is_array($html)) {
        $arr = array();
        foreach ($html as $i => $_html) {
            $arr[$i] = contrexx_html2plaintext($_html);
        }
        return $arr;
    }

    // ensure that no html-notations are left in place
    $html = html_entity_decode($html, ENT_QUOTES, CONTREXX_CHARSET);

    // remove all placeholders, script- and style-tags
    $html = preg_replace(
        array(
            '/\{[a-zA-Z0-9_]+\}/',
            '/\[\[[a-zA-Z0-9_]+\]\]/',
            '/<script[^>]+>.*?<\/script>/ms',
            '/<style[^>]+>.*?<\/style>/ms',
        ),
        '',
        $html);

    // remove all remaining html&php tags
    $plaintext = strip_tags($html);

    // remove white-space sequences
    $plaintext = trim(preg_replace('/\s+/msu', ' ', $plaintext));

    return $plaintext;
}
