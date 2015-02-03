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
 * Security
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Gerben van der Lubbe <spoofedexistence@gmail.com>
 * @author      Ivan Schmid <ivan.schmid@comvation.com>
 * @version     2.1
 * @package     contrexx
 * @subpackage  core
 * @todo        Edit PHP DocBlocks!
 */

/**
 * Security
 *
 * The security class checks for possible attacks to the server
 * and supports a few functions to make everything more secure.
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Gerben van der Lubbe <spoofedexistence@gmail.com>
 * @author      Ivan Schmid <ivan.schmid@comvation.com>
 * @version     2.1
 * @package     contrexx
 * @subpackage  core
 */
class Security
{
    /**
     * Title of the active page
     * @var boolean
     */
    public $reportingMode = false;

    /**
     * $_SERVER variable indexes used by Contrexx
     *
     * @var array
     */
    public $criticalServerVars = array (
        'DOCUMENT_ROOT',
        'HTTPS',
        'HTTP_ACCEPT_LANGUAGE',
        'HTTP_CLIENT_IP',
        'HTTP_HOST',
        'HTTP_REFERER',
        'HTTP_USER_AGENT',
        'HTTP_VIA',
        'HTTP_X_FORWARDED_FOR',
        'PHP_SELF',
        'QUERY_STRING',
        'REMOTE_ADDR',
        'REQUEST_URI',
        'SCRIPT_FILENAME',
        'SCRIPT_NAME',
        'SCRIPT_URI',
        'SERVER_ADDR',
        'SERVER_NAME',
        'SERVER_PORT',
        'SERVER_PROTOCOL',
        'SERVER_SOFTWARE',
        'argv',
    );


    /**
    * Constructor
    * @access public
    */
    function __construct()
    {
        global $_CONFIG;
        if ($_CONFIG['coreIdsStatus']=='on') {
            $this->reportingMode = true;
        }
    }


    /**
    * Get request info
    *
    * Lists the content for an array for sending it with an e-mail
    * @param     $reqarray The array to send the contents from.
    * @param    $arrname  The name in the array.
    * @return    string    The value ready to send
    **/
    function getRequestInfo($reqarray, $arrname)
    {
        $retdata = "";
        if(!is_array($reqarray))
            return "";

        // For each content of the $reqarray
        foreach($reqarray as $nname => $nval){
            // If this is an array
            if(is_array($nval)){
                // It's an array. Add the contents of it.
                $retdata .= $arrname." [$nname] : array {\r\n";
                $retdata .= $this->getRequestInfo($nval, $arrname." [$nname]");
                $retdata .= $arrname." [$nname] : }\r\n";
            } else {
                // It's no array, just add it
                $retdata .= $arrname." [$nname] : $nval\r\n";
            }
        }
        return $retdata;
    }


    /**
    * Reports a possible intrusion attempt to the administrator
    * @param   $type    The type of intrusion attempt to report.
    * @param   $file    The file requesting the report (defaults to "Filename not available")
    * @param   $line    The line number requesting the report (defaults to "Linenumber not available")
    **/
    function reportIntrusion($type, $file = "Filename not available", $line = "Linenumber not available")
    {
        global $objDatabase, $_CONFIG;

        $remoteaddr = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : "Not set";
        $httpxforwardedfor = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : "Not set";
        $httpvia = isset($_SERVER['HTTP_VIA']) ? $_SERVER['HTTP_VIA'] : "Not set";
        $httpclientip = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : "Not set";
        $gethostbyname = gethostbyname($remoteaddr);
        if($gethostbyname == $remoteaddr)
            $gethostbyname = "No matching hostname";

        // Add all the user's info to $user
        $user = "REMOTE_ADDR : $remoteaddr\r\n".
                "HTTP_X_FORWARDED_FOR : $httpxforwardedfor\r\n".
                "HTTP_VIA : $httpvia\r\n".
                "HTTP_CLIENT_IP : $httpclientip\r\n".
                "GetHostByName : $gethostbyname\r\n";
        // Add all requested information
        foreach ($this->criticalServerVars as $serverVar) {
            $_SERVERlite[$serverVar] = $_SERVER[$serverVar];
        }

        $httpheaders = function_exists('getallheaders') ? getallheaders() : null;
        $gpcs = "";
        $gpcs .= $this->getRequestInfo($httpheaders, "HTTP HEADER");
        $gpcs .= $this->getRequestInfo($_REQUEST, "REQUEST");
        $gpcs .= $this->getRequestInfo($_GET, "GET");
        $gpcs .= $this->getRequestInfo($_POST, "POST");
        $gpcs .= $this->getRequestInfo($_SERVERlite, "SERVER");
        $gpcs .= $this->getRequestInfo($_COOKIE, "COOKIE");
        $gpcs .= $this->getRequestInfo($_FILES, "FILES");
        $gpcs .= $this->getRequestInfo($_SESSION, "SESSION");

        // Get the data to insert in the database
        $cdate = time();
        $dbuser = htmlspecialchars(addslashes($user), ENT_QUOTES, CONTREXX_CHARSET);
        $dbuser = mysql_escape_string($dbuser);
        $dbgpcs = htmlspecialchars(addslashes($gpcs), ENT_QUOTES, CONTREXX_CHARSET);
        $dbgpcs = mysql_escape_string($dbgpcs);
        $where = addslashes("$file : $line");
        $where = mysql_escape_string($where);

        // Insert the intrusion in the database
        $objDatabase->Execute("INSERT INTO ".DBPREFIX."ids (timestamp, type, remote_addr, http_x_forwarded_for, http_via, user, gpcs, file)
                VALUES(".$cdate.", '".$type."', '".$remoteaddr."', '".$httpxforwardedfor."', '".$httpvia."', '".$dbuser."', '".$dbgpcs."', '".$where."')");

        // The headers for the e-mail
        $emailto = $_CONFIG['coreAdminName']." <".$_CONFIG['coreAdminEmail'].">";

        // The message to send
        $message = "DATE : $cdate\r\nFILE : $where\r\n\r\n$user\r\n\r\n$gpcs";

        // Send the e-mail to the administrator
        if (@include_once ASCMS_LIBRARY_PATH.'/phpmailer/class.phpmailer.php') {
            $objMail = new phpmailer();

            if ($_CONFIG['coreSmtpServer'] > 0 && @include_once ASCMS_CORE_PATH.'/SmtpSettings.class.php') {
                if (($arrSmtp = SmtpSettings::getSmtpAccount($_CONFIG['coreSmtpServer'])) !== false) {
                    $objMail->IsSMTP();
                    $objMail->Host = $arrSmtp['hostname'];
                    $objMail->Port = $arrSmtp['port'];
                    $objMail->SMTPAuth = true;
                    $objMail->Username = $arrSmtp['username'];
                    $objMail->Password = $arrSmtp['password'];
                }
            }

            $objMail->CharSet = CONTREXX_CHARSET;
            $objMail->From = $_CONFIG['coreAdminEmail'];
            $objMail->FromName = $_CONFIG['coreAdminName'];
            $objMail->AddReplyTo($_CONFIG['coreAdminEmail']);
            $objMail->Subject = $_SERVER['HTTP_HOST']." : $type";
            $objMail->IsHTML(false);
            $objMail->Body = $message;
            $objMail->AddAddress($emailto);
            $objMail->Send();
        }
    }


    /**
    * Detect intrusion
    *
    * Looks through an array and tries to detect possible hacking attempts.
    * @param   $array  The array (or string) to check for security.
    * @return  array   The array with the trusted values, or the string
    **/
    function detectIntrusion($array)
    {
     //print_r($array);
        // If it's not an array, test this record for safety and return the result
        if(!is_array($array)){
            while(1){
                $safe = 1;
                // Test the string (called $array) for cross site scripting attacks
                if(
                    // Disallow <*script
                    preg_match('/<[^>a-z0-9]*script[^a-z]+/i', $array) ||
                    // Disallow <*xml*
                    preg_match('/<[^>a-z0-9]*xml[^a-z]+/i', $array) ||
                    // Disallow <*style*
                    preg_match('/<[^>a-z0-9]*style[^a-z]+/i', $array) ||
                    // Disallow <*form*
                    preg_match('/<[^>a-z0-9]*form[^a-z]+/i', $array) ||
                    // Disallow <*input*
                    preg_match('/<[^>a-z0-9]*input[^a-z]+/i', $array) ||
                    // Disallow <*window*
                    preg_match('/<[^>a-z0-9]*window[^a-z]+/i', $array) ||
                    // Disallow <*alert*
                    preg_match('/<[^>a-z0-9]*alert[^a-z]+/i', $array) ||
                    // Disallow <*img*
                    preg_match('/<[^>a-z0-9]*img[^a-z]+/i', $array) ||
                     // Disallow <*cookie*
                    preg_match('/<[^>a-z0-9]*cookie[^a-z]+/i', $array) ||
                    // Disallow <*object*
                    preg_match('/<[^>a-z0-9]*object[^a-z]+/i', $array) ||
                    // Disallow <*iframe*
                    preg_match('/<[^>a-z0-9]*iframe[^a-z]+/i', $array) ||
                    // Disallow <*applet*
                    preg_match('/<[^>a-z0-9]*applet[^a-z]+/i', $array) ||
                    // Disallow <*meta*
                    preg_match('/<[^>a-z0-9]*meta[^a-z]+/i', $array) ||
                    // Disallow <*body*
                    preg_match('/<[^>a-z0-9]*body[^a-z]+/i', $array) ||
                    // Disallow <*font*
                    preg_match('/<[^>a-z0-9]*font[^a-z]+/i', $array) ||
                    // Disallow <*p*
                //    preg_match('/<[^>a-z0-9]*p[^a-z]+/i', $array) ||
                    // Disallow "javascript: and 'javascript
                    preg_match('/["|\']javascript:/i', $array) ||
                    // Disallow =javascript:
                    preg_match('/=javascript:/i', $array) ||
                    // Disallow "vbscript: and 'vbscript:
                    preg_match('/["|\']vbscript:/i', $array) ||
                    // Disallow =vbscript:
                    preg_match('/=vbscript:/i', $array) ||
                    // Disallow on*=
                    preg_match('/[^a-z0-9]*on[a-z]+\s*=/i', $array)
                  )
                {
                    // Report a potential cross site scripting attack
                    if($this->reportingMode == true){
                        $this->reportIntrusion("XSS Attack");
                    }
                    $safe = 0;

                    // Use special ways to protect to some cross site scriptings
                    if(
                        preg_match('/["|\']javascript:/i', $array) ||
                        preg_match('/=\s*javascript:/i', $array) ||
                        preg_match('/["|\']vbscript:/i', $array) ||
                        preg_match('/=\s*vbscript:/i', $array)
                      )
                    {
                        // Remove the ':'
                        $array = preg_replace('/(["|\']javascript):/i', '\1', $array);
                        $array = preg_replace('/(=\s*javascript):/i', '\1', $array);
                        $array = preg_replace('/(["|\']vbscript):/i', '\1', $array);
                        $array = preg_replace('/(=\s*vbscript):/i', '\1', $array);
                    }
                    if(preg_match('/[^a-z0-9]*on[a-z]+\s*=/i', $array)){
                        // Remove the =
                        $array = preg_replace('/([^a-z0-9]*on[a-z]+\s*)=/i', '\1', $array);
                    }
                    // Secure it using htmlspecialchars
                    $array = htmlspecialchars($array, ENT_QUOTES, CONTREXX_CHARSET);
                }

// This is crap!  Every second english language sentence matches those.
/*
                // Test for SQL injection
                if(
                    // Disallow "*or/and*=*" or "*or*like*"
                    preg_match('/([^a-z]+|^)(OR|AND)[^a-z]+.*(=|like)/i', $array) ||
                    // Disallow "*UNION*SELECT "
                    preg_match('/([^a-z]+|^)UNION[^a-z]+.*SELECT[\t ]+/i', $array)
                  )
                {
                    // Report for an intrusion attempt
                    if($this->reportingMode == true){
                        $this->reportIntrusion("SQL Injection");
                    }
                    $safe = 0;

                    // On "*or/and*=/like*", remove OR/AND
                    $array = eregi_replace("([^a-z]+|^)(OR|AND)([^a-z]+.*(=|like))", "\\1\\3", $array);

                    // On "*UNION*SELECT ", remove union
                    $array = eregi_replace("([^a-z]+|^)UNION([^a-z]+.*SELECT[\t ]+)", "\\1\\3", $array);
                }
*/

                // Return the untrusted value, it's fine
                if($safe == 1) {
                    return $array;
                }
            }
        }

        // The trusted value will become an array
        $trusted = array();

        // For each record in the array
        foreach($array as $nname => $untrusted){
            // Get untrusted's trusted value and store it
            $trusted[$nname] = $this->detectIntrusion($untrusted);
        }

        // Return the trusted array
        return $trusted;
    }

}

?>
