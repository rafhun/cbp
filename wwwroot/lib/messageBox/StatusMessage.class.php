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
 * StatusMessage
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  lib_framework
 */

/**
 * StatusMessage
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  lib_framework
 */
class StatusMessage {
	var $iconFile;
	var $width;
	var $height;
	var $mode;
	var $type;
	var $message;
	var $title;
	var $background;

    /**
     * Constructor
     */
    function __construct()
    {
    }


	// $type = error | ok | info
	function SetBox($message= '', $type = 'error') {
		switch ($type){
			case "info":
			$this->setIconFile("info.png");
			$this->setColorScheme("blue");
			break;
			case "ok":
			$this->setIconFile("ok.png");
			$this->setColorScheme("green");
			break;
            default:
            $this->setIconFile("error.png");
            $this->setColorScheme("red");
		}

		# The message itself
		$msg->setMsg($message);

		# Box title
		// $msg->setTitle("Authentication problems");
	}


	function setIconFile($icon) {
		$this->iconFile = $icon;
	}

	function setCSS($w) {
		$this->cssName = $w;
	}


	function setMsg($msg) {
		$this->message = $msg;
	}

	function setTitle($t) {
		$this->title = $t;
	}


	function generateCssStyle() {

		$css = "\n
		<style type=\"text/css\">
		.messageBox {
			margin: 3px 0px 3px 0px;
			padding: 5px;
			border: 1px dotted #ccc;
			background: #f6f9ff;
			color: #4d7097;
			font-weight: bold;
			font-family: Tahoma;
			font-size: 100%;
			}
		</style>\n";
	}


	function generateBox() {

		$html ="\n<div class=\"".$this->cssName."\">".$this->message."</div>\n";
		$result = $css . $html;
		return $result;
	}
}
