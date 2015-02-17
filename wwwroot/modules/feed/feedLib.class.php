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
 * Feed library
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Paulo M. Santos <pmsantos@astalavista.net>
 * @package     contrexx
 * @subpackage  module_feed
 * @todo        Edit PHP DocBlocks!
 */

// SECURITY CHECK
if (eregi('feedLib.class.php', $_SERVER['PHP_SELF']))
{
    CSRF::header('Location: index.php');
    die();
}

/**
 * Feed library
 *
 * Manage CMS feed
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Paulo M. Santos <pmsantos@astalavista.net>
 * @package     contrexx
 * @subpackage  module_feed
 */
class feedLibrary
{
    public $_objTpl;
    public $pageTitle;
    public $statusMessage;
    public $feedpath;

    function __construct()
    {
    }


    function showNewsRefresh($id, $time, $path)
    {
        global $objDatabase;

        //delete old #01
        $query = "SELECT link,
                           filename
                      FROM ".DBPREFIX."module_feed_news
                     WHERE id = '".$id."'";
        $objResult = $objDatabase->Execute($query);

        $old_link     = $objResult->fields['link'];
        $old_filename = $objResult->fields['filename'];

        if($old_link != '') {
            $filename = 'feed_' . $time . '_' . \Cx\Lib\FileSystem\FileSystem::replaceCharacters(basename($old_link));
            @copy($old_link, $path.$filename);

            //rss class
            $rss = new XML_RSS($path.$filename);
            $rss->parse();
            $content = '';

            foreach($rss->getStructure() as $array) {
                $content .= $array;
            }
        }

        if($old_link == '') {
            $filename = $old_filename;
        }

        $query = "UPDATE ".DBPREFIX."module_feed_news
                       SET filename = '".$filename."',
                           time = '".$time."'
                     WHERE id = '".$id."'";
        $objDatabase->Execute($query);

        //delete old #02
        if($old_link != '') {
            @unlink($path.$old_filename);
        }
    }
}

?>
