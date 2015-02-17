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
 * MXLookup
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Thomas Däppen <thomas.daeppen@comvation.com>
 * @version     1.0
 * @package     contrexx
 * @subpackage  lib_framework
 * @todo        Edit PHP DocBlocks!
 */

/**
 * MXLookup
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Thomas Däppen <thomas.daeppen@comvation.com>
 * @version     1.0
 * @package     contrexx
 * @subpackage  lib_framework
 * @todo        Edit PHP DocBlocks!
 */
class MXLookup {
    var $timeout = 3;
    var $query;
    var $dnsReply;
    var $dnsAddr;
    var $redirectCount = 0;
    var $errorMsg;
    var $arrMXRRs = array();

    /**
    * Get the mail exchange records from an domain name
    *
    * @access public
    * @param string domain
    * @return array arrMXRRs
    */
    function getMailServers($domain) {
        global $_CONFIG;

        $this->dnsAddr = $_CONFIG['dnsServer'];
        $QNAME = $this->_createQNAME($domain);
        $this->query = $this->_createQuery($QNAME);
        if (!$this->_sendQuery()) {
            return false;
        }

        return $this->_getMXRRs();
    }

    /**
    * Get all mail exchange hosts with their preference from the DNS reply
    *
    * @access private
    * @return array arrMXRRs
    */
    function _getMXRRs() {
        global $_ARRAYLANG;

        $ANCOUNT = intval(ord(substr($this->dnsReply,6,1)).ord(substr($this->dnsReply,7,1)));
        $NSCOUNT = intval(ord(substr($this->dnsReply,8,1)).ord(substr($this->dnsReply,9,1)));

        $octNr = 12;
        $QNAME = $this->_parseMXRDATA($octNr);
        $octNr += 5; // skip QTYPE and QCLASS

        if ($ANCOUNT != 0) {
            for ($i = 0; $i < $ANCOUNT; $i++) {
                $this->arrMXRRs[$i]['NAME'] = $this->_parseMXRDATA($octNr, 1);
                $octNr++;
                $TYPE = intval(ord(substr($this->dnsReply,$octNr,1)).ord(substr($this->dnsReply,$octNr+1,1)));
                $octNr += 8; // skip CLASS and TTL
                $RDLENGTH = intval(ord(substr($this->dnsReply,$octNr,1)).ord(substr($this->dnsReply,$octNr+1,1)));
                $octNr += 2;
                if ($TYPE != 15) {
                    $octNr += $RDLENGTH;
                    continue;
                }
                $this->arrMXRRs[$i]['PREFERENCE'] = intval(ord(substr($this->dnsReply,$octNr,1)).ord(substr($this->dnsReply,$octNr+1,1)));
                $octNr += 2;
                $this->arrMXRRs[$i]['EXCHANGE'] = $this->_parseMXRDATA($octNr, $RDLENGTH-3);
                $octNr++;
            }
            return true;
        } elseif ($NSCOUNT != 0) {
            $octNr += 2;
            $TYPE = intval(ord(substr($this->dnsReply,$octNr,1)).ord(substr($this->dnsReply,$octNr+1,1)));
            $octNr += 8; // skip CLASS and TTL
            $RDLENGTH = intval(ord(substr($this->dnsReply,$octNr,1)).ord(substr($this->dnsReply,$octNr+1,1)));
            $octNr += 2;
            if ($TYPE == 2) {
                if ($this->redirectCount == 4) {
                    $this->errorMsg = $_ARRAYLANG['TXT_TOO_MANY_FORWARDS'];
                    return false;
                }
                $this->redirectCount++;
                $NSDNAME = $this->_parseMXRDATA($octNr, $RDLENGTH-1);
                $this->dnsAddr = $NSDNAME;
                if (!$this->_sendQuery()) {
                    return false;
                }
                $this->_getMXRRs();
                return true;
            }
        }
        $this->errorMsg = str_replace("%DOMAIN%", $QNAME, $_ARRAYLANG['TXT_NO_MX_RECORDS_FOUND']);
        return false;
    }

    /**
    * Get the data from the reply
    *
    * @access private
    * @param int octNr
    * @param int rdataLength
    * @return array arrData
    */
    function _parseMXRDATA(&$octNr, $rdataLength = 0) {
        if ($rdataLength != 0) {
            $rdataEnd = $octNr + $rdataLength;
        }

        for ($i = $octNr; $i < strlen($this->dnsReply); $i++) {
            if (!$inStr) {
                $strLength = ord(substr($this->dnsReply, $octNr, 1));
                switch ($strLength) {
                    case 192:
                        $octNr++;
                        $jmpOctNr = ord(substr($this->dnsReply, $octNr,1));
                        $string = $this->_parseMXRDATA($jmpOctNr);
                        $arrData[] = $string;
                        break 2;

                    case 0:
                        break 2;

                    default:
                        $string = "";
                        $strEnd = $octNr + $strLength;
                        $inStr = true;
                }
            } else {
                $string .= substr($this->dnsReply, $octNr, 1);
            }

            if ($octNr == $rdataEnd) {
                break;
            }

            if ($inStr && ($strEnd == $octNr)) {
                $inStr = false;
                $arrData[] = $string;
            }

            $octNr++;
        }
        return implode(".", $arrData);
    }

    /**
    * Send a query the to DNS server and return its reply
    *
    * @access private
    * @param string query
    * @return string reply
    */
    function _sendQuery() {
        global $_ARRAYLANG;

        $socket = @fsockopen("udp://".$this->dnsAddr, 53, $errNr, $errStr,$this->timeout);
        if ($socket === false) {
            $this->errorMsg = str_replace("%HOST%", $this->dnsAddr, $_ARRAYLANG['TXT_COULD_NOT_CONNECT_DNS_SERVER']);
            return false;
        }
        socket_set_timeout($socket, $this->timeout);
        // send query
        fwrite($socket, $this->query, strlen($this->query));

        // get reply
        $reply = fread($socket,1);
        $arrSocketStatus = socket_get_status($socket);

        if ($arrSocketStatus['timed_out']) {
            if ($arrSocketStatus['blocked']) {
                $this->errorMsg = str_replace("%HOST%", $this->dnsAddr, $_ARRAYLANG['TXT_DNS_SERVER_BLOCK']);
            } else {
                $this->errorMsg = str_replace("%HOST%", $this->dnsAddr, $_ARRAYLANG['TXT_DNS_SERVER_REQUEST_TIMEOUT']);
            }
            return false;
        }

        $reply .= fread($socket,$arrSocketStatus['unread_bytes']);
        fclose($socket);

        $this->dnsReply = $reply;
        return true;
    }

    /**
    * Creates the QNAME from the domain name for the question section of the DNS query
    *
    * @access private
    * @param string domain
    * @return string QNAME
    */
    function _createQNAME($domain) {
        while ($dotPos = strpos($domain, ".")) {
            $part = substr($domain, 0, $dotPos);
            $domain = substr($domain, $dotPos+1);
            $QNAME .= chr(strlen($part)).$part;
        }
        $QNAME .= chr(strlen($domain)).$domain.chr(bindec('00000000'));

        return $QNAME;
    }

    /**
    * Creates the MX-Lookup DNS query with the domain name QNAME
    *
    * @access private
    * @param string QNAME
    * @return string query
    */
    function _createQuery($QNAME) {
        $header = chr(bindec('00000000')).chr(bindec('00000001')) // ID
                .chr(bindec('00000000')).chr(bindec('00000000')) // QR | OPCODE | AA | TC | RD | RA | Z | RCODE
                .chr(bindec('00000000')).chr(bindec('00000001')) // QDCOUNT
                .chr(bindec('00000000')).chr(bindec('00000000')) // ANCOUNT
                .chr(bindec('00000000')).chr(bindec('00000000')) // NSCOUNT
                .chr(bindec('00000000')).chr(bindec('00000000')); // ARCOUNT
        $question = $QNAME
                .chr(bindec('00000000')).chr(bindec('00001111')) // QTYPE
                .chr(bindec('00000000')).chr(bindec('00000001')); // CLASS
        $query = $header.$question;

        return $query;
    }
}
