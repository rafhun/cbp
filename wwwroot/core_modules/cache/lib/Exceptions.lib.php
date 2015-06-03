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
 * Cache Module - Exceptions: A list of all pages which shouldn't be cached
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Comvation Development Team <info@comvation.com>
 * @version     1.0.1
 *
 * @package     contrexx
 * @subpackage  coremodule_cache
 * @todo        Edit PHP DocBlocks!
 */
$_EXCEPTIONS = array( 	// Filter specific Pages in alphabetical order
	array('section'	=> 'access','cmd' => '/settings.*/'),		// User Profile
	array('section'	=> 'contact'),								// Contact
    array('section'	=> 'guestbook'	),							// Guestbook
	//array('section'	=> 'login','redirect' => '/.*/'),			// Login
	//array('section'	=> 'login', 'restore_pw' => '/.*/'),		// Login
	array('section' => 'login'),
	//array('section'	=> 'news', 'cmd' => '=submit='),			// News
	array('section' => 'news'),
	array('section'	=> 'search', 'term' =>	'/.*/'),			// Search
	array('section'	=> 'gallery'),								// Gallery
	//array('section' => 'memberdir', 'search' => '=search='),	// Memberdir
	array('section' => 'memberdir'),
	array('section'	=> 'directory'),							// Directory
	array('section'	=> 'forum'),								// Forum
	array('section' => 'shop'),									// Shop
	array('section' => 'calendar'),								// Calendar
	array('section'	=> 'market'),								// Market
	array('section' => 'feed'),
	array('section' => 'docsys'),
	array('section' => 'media1'),
	array('section' => 'media2'),
	array('section' => 'media3'),
	array('section' => 'livecam'),
	array('section' => 'voting'),
	array('section' => 'egov')
);
?>
