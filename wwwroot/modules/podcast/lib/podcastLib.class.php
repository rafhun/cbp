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
 * Class podcast library
 *
 * podcast library class
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author        Comvation Development Team <info@comvation.com>
 * @access        public
 * @version        1.0.0
 * @package     contrexx
 * @subpackage  module_podcast
 * @todo        Edit PHP DocBlocks!
 */
class podcastLib
{
    /**
     * the default thumbnail image path
     *
     * @access private
     * @var $_noThumbnail string path to default image, without offset
     */
    var $_noThumbnail = '';

    /**
     * settings array
     *
     * @access private
     * @var array
     */
    var $_arrSettings = array();

    /**
     * The default thumbnail picture
     *
     * @access private
     * @var string path to the default thumbnail, relative to the backend admin path
     */
    var $_defaultThumbnail = 'images/podcast/no_picture.gif';

    /**
     * allowed characters in a YouTube Video ID (regex class)
     *
     * @access private
     * @var string allowed characters in a YouTube Video ID
     */
    var $_youTubeAllowedCharacters = '[a-zA-Z0-9_-]';

    /**
     * length of a YouTube Video ID used in the ID regex
     *
     * @access private
     * @var string length of a YouTube Video ID
     */
    var $_youTubeIdLength = '11';

    /**
     * Youtube ID Regex
     *
     * @access private
     * @var string
     */
    var $_youTubeIdRegex;

    /**
     * Youtube ID Regex for Javascript
     *
     * @access private
     * @var string
     */
    var $_youTubeIdRegexJS;

    /**
     * YouTube default flashobject width
     *
     * @access private
     * @var int
     */
    var $_youTubeDefaultWidth = 425;

    /**
     * YouTube default flashobject height
     *
     * @access private
     * @var int
     */
    var $_youTubeDefaultHeight = 350;

    /**
     * categories for the public. If empty, all will be available to the community
     *
     * @var array
     */
    var $_communityCategories = array();


    function __construct()
    {
        $this->_arrSettings = $this->_getSettings();
        $this->_youTubeIdRegex = '#.*[\?&/]v[=/]('.$this->_youTubeAllowedCharacters.'{'.$this->_youTubeIdLength.'}).*#';
        //youtubeIdCharacters and youtubeIdLength are JS variables.
        $this->_youTubeIdRegexJS = '.*[\\?&/]v[=/]("+youtubeIdCharacters+"{"+youtubeIdLength+"}).*';
        $this->_noThumbnail = ASCMS_PATH_OFFSET . '/images/podcast/no_picture.gif';
    }

    function _getMedia($ofCategory = false, $isActive = false, $limit = 0, $pos = 0)
    {
        global $objDatabase, $_CONFIG;

        $arrMedia = array();
        $cat = false;
        $sqlLimit = ($limit == 0) ? $_CONFIG['corePagingLimit'] : $limit;
        if(is_array($ofCategory)){
            $cat = implode(',', $ofCategory);
            if(empty($cat)){
                $cat = '-1';
            }
        }elseif(!empty($ofCategory) && intval($ofCategory) > 0){
            $cat = $ofCategory;
        }

        $objMedium = $objDatabase->SelectLimit('
            SELECT DISTINCT tblMedium.id,
                   tblMedium.title,
                   tblMedium.youtube_id,
                   tblMedium.author,
                   tblMedium.description,
                   tblMedium.source,
                   tblMedium.thumbnail,
                   tblMedium.width,
                   tblMedium.height,
                   tblMedium.playlenght,
                   tblMedium.size,
                   tblMedium.status,
                   tblMedium.date_added,
                   tblMedium.template_id
            FROM '.(!empty($cat) ? DBPREFIX.'module_podcast_rel_medium_category AS tblRel INNER JOIN ' : '').DBPREFIX.'module_podcast_medium AS tblMedium '.
            (!empty($cat) ? ' ON tblMedium.id=tblRel.medium_id ' : '').
            ($isActive || !empty($cat) ? ' WHERE ' : '').
            (!empty($cat) ? ' tblRel.category_id IN ('.$cat.') ' : '').
            ($isActive ? (!empty($cat) ? ' AND ' : '').' tblMedium.status=1 ' : '').
            ' ORDER BY tblMedium.date_added DESC', $sqlLimit, $pos);
        if ($objMedium != false) {
            while (!$objMedium->EOF) {
                if(!empty($objMedium->fields['youtube_id'])){
                    $mediumSource = 'http://youtube.com/v/'.$objMedium->fields['youtube_id'];
                }else{
                    $mediumSource = str_replace(array('%domain%', '%offset%'), array($_CONFIG['domainUrl'], ASCMS_PATH_OFFSET), $objMedium->fields['source']);
                }
                $arrMedia[$objMedium->fields['id']] = array(
                    'title'         => $objMedium->fields['title'],
                    'youtube_id'    => $objMedium->fields['youtube_id'],
                    'author'        => $objMedium->fields['author'],
                    'description'   => $objMedium->fields['description'],
                    'source'        => $mediumSource,
                    'thumbnail'     => !empty($objMedium->fields['thumbnail']) ? $objMedium->fields['thumbnail'] : $this->_noThumbnail,
                    'width'         => $objMedium->fields['width'],
                    'height'        => $objMedium->fields['height'],
                    'playlength'    => $objMedium->fields['playlenght'],
                    'size'          => $objMedium->fields['size'],
                    'status'        => $objMedium->fields['status'],
                    'date_added'    => $objMedium->fields['date_added'],
                    'template_id'   => $objMedium->fields['template_id']
                );
                $objMedium->MoveNext();
            }
            return $arrMedia;
        } else {
            return false;
        }
    }

    function _getMedium($mediumId, $isActive = false)
    {
        global $objDatabase, $_CONFIG;

        $objMedium = $objDatabase->SelectLimit("
            SELECT
                   title,
                   youtube_id,
                   author,
                   description,
                   source,
                   thumbnail,
                   width,
                   height,
                   playlenght,
                   size,
                   status,
                   date_added,
                   template_id
            FROM ".DBPREFIX."module_podcast_medium
            WHERE id=".$mediumId.
            ($isActive ? " AND status=1" : ""), 1);
        if ($objMedium !== false && $objMedium->RecordCount() == 1) {
            if(!empty($objMedium->fields['youtube_id'])){
                $mediumSource = 'http://youtube.com/v/'.$objMedium->fields['youtube_id'];
            }else{
                $mediumSource = str_replace(array('%domain%', '%offset%'), array($_CONFIG['domainUrl'], ASCMS_PATH_OFFSET), $objMedium->fields['source']);
            }
            $arrMedium = array(
                'title'         => $objMedium->fields['title'],
                'youtube_id'    => $objMedium->fields['youtube_id'],
                'author'        => $objMedium->fields['author'],
                'description'   => $objMedium->fields['description'],
                'source'        => $mediumSource,
                'thumbnail'     => !empty($objMedium->fields['thumbnail']) ? $objMedium->fields['thumbnail'] : $this->_noThumbnail,
                'width'         => $objMedium->fields['width'],
                'height'        => $objMedium->fields['height'],
                'playlength'    => $objMedium->fields['playlenght'],
                'size'          => $objMedium->fields['size'],
                'status'        => $objMedium->fields['status'],
                'date_added'    => $objMedium->fields['date_added'],
                'template_id'   => $objMedium->fields['template_id'],
                'category'      => array()
            );

            $objCategory = $objDatabase->Execute("SELECT category_id FROM ".DBPREFIX."module_podcast_rel_medium_category WHERE medium_id=".$mediumId);
            if ($objCategory !== false) {
                while (!$objCategory->EOF) {
                    array_push($arrMedium['category'], $objCategory->fields['category_id']);
                    $objCategory->MoveNext();
                }
            }

            return $arrMedium;
        } else {
            return false;
        }
    }

    /**
     * Get media count
     *
     * Return the count of media in the system.
     * If $ofCategory is specified, then the count of media of the specified category is returned.
     *
     * @param mixed $ofCategory
     * @return mixed media count on successfull, false on failure
     */
    function _getMediaCount($ofCategory = false, $isActive = false)
    {
        global $objDatabase;

        $objCount = $objDatabase->Execute("SELECT COUNT(1) AS media_count FROM ".DBPREFIX."module_podcast_medium AS tblMedium".
            ($ofCategory !== false ? " ,".DBPREFIX."module_podcast_rel_medium_category AS tblRel WHERE tblRel.medium_id=tblMedium.id AND tblRel.category_id=".$ofCategory : "").
            ($isActive ? ($ofCategory !== false ? " AND " : " WHERE ")."tblMedium.status=1" : "").
            ($ofCategory !== false ? " GROUP BY tblRel.category_id" : ""));

        if ($objCount !== false) {
            return intval($objCount->fields['media_count']);
        } else {
            return false;
        }
    }

    function _getCategories($isActive = false, $limit = false, $langId = false)
    {
        global $objDatabase, $_CONFIG, $_LANGID;

        $arrCategory = array();

        if ($limit === false) {
            $objCategory = $objDatabase->Execute("SELECT id, title, description, status FROM ".DBPREFIX."module_podcast_category".($isActive ? " WHERE status=1" : "" ));
        } else {
            $pos = isset($_GET['pos']) ? intval($_GET['pos']) : 0;
            $objCategory = $objDatabase->SelectLimit("SELECT id, title, description, status FROM ".DBPREFIX."module_podcast_category".($isActive ? " WHERE status=1" : "" ), $_CONFIG['corePagingLimit'], $pos);
        }
        if ($objCategory !== false) {
            while (!$objCategory->EOF) {
                if ($langId !== false) {
                    $arrLangIds = &$this->_getLangIdsOfCategory($objCategory->fields['id']);
                    if (!in_array($_LANGID, $arrLangIds)) {
                        $objCategory->MoveNext();
                        continue;
                    }
                }
                $arrCategory[$objCategory->fields['id']] = array(
                    'title'         => $objCategory->fields['title'],
                    'description'   => $objCategory->fields['description'],
                    'status'        => $objCategory->fields['status']
                );
                $objCategory->MoveNext();
            }

            return $arrCategory;
        } else {
            return false;
        }
    }

    function _getCategory($categoryId, $isActive = false)
    {
        global $objDatabase;

        $objCategory = $objDatabase->SelectLimit("SELECT title, description, status FROM ".DBPREFIX."module_podcast_category WHERE id=".$categoryId.($isActive ? " AND status=1" : ""), 1);
        if ($objCategory !== false && $objCategory->RecordCount() == 1) {
            $arrCategory = array(
                'title'         => $objCategory->fields['title'],
                'description'   => $objCategory->fields['description'],
                'status'        => $objCategory->fields['status']
            );

            return $arrCategory;
        } else {
            return false;
        }
    }

    function _getCategoriesCount($isActive = false)
    {
        global $objDatabase;

        $objCount = $objDatabase->Execute("SELECT COUNT(1) AS categories_count FROM ".DBPREFIX."module_podcast_category".($isActive ? " WHERE status=1" : ""));
        if ($objCount !== false) {
            return $objCount->fields['categories_count'];
        } else {
            return false;
        }
    }

    function _getCategoriesMenu($selectedCategoryId = 0, $attrs = '', $areActive = false, $langId = false)
    {
        global $_ARRAYLANG;

        $menu = "<select ".$attrs.">\n";
        $menu .= "<option value=\"0\">".$_ARRAYLANG['TXT_PODCAST_SELECT_CATEGORY']."</option>\n";
        $menu .= "<option value=\"0\">".$_ARRAYLANG['TXT_PODCAST_ALL']."</option>\n";

        if (($arrCategories = &$this->_getCategories($areActive, false, $langId)) !== false && count($arrCategories) > 0) {

            foreach ($arrCategories as $categoryId => $arrCategory) {
                $menu .= "<option value=\"".$categoryId.($categoryId == $selectedCategoryId ? "\" selected=\"selected\"" : "\"").">".htmlentities($arrCategory['title'], ENT_QUOTES, CONTREXX_CHARSET)."</option>\n";
            }
            $menu .= "</select>\n";

            return $menu;
        } else {
            return false;
        }
    }

    function _isUniqueCategoryTitle($title, $categoryId)
    {
        global $objDatabase;

        $objCount = $objDatabase->SelectLimit("SELECT id FROM ".DBPREFIX."module_podcast_category WHERE title='".contrexx_addslashes($title)."' AND id!=".$categoryId, 1);
        if ($objCount !== false && $objCount->RecordCount() == 0) {
            return true;
        } else {
            return false;
        }
    }

    function _addCategory($title, $description, $arrLangIds, $status)
    {
        global $objDatabase;

        if ($objDatabase->Execute("INSERT INTO ".DBPREFIX."module_podcast_category (`title`, `description`, `status`) VALUES ('".contrexx_addslashes($title)."', '".contrexx_addslashes($description)."', ".$status.")") !== false) {
            return $this->_setCategoryLangIds($objDatabase->Insert_ID(), $arrLangIds);
        } else {
            return false;
        }
    }

    function _updateCategory($id, $title, $description, $arrLangIds, $status)
    {
        global $objDatabase;

        if ($objDatabase->Execute("UPDATE ".DBPREFIX."module_podcast_category SET `title`='".contrexx_addslashes($title)."', `description`='".contrexx_addslashes($description)."', `status`=".$status." WHERE id=".$id) !== false) {
            return $this->_setCategoryLangIds($id, $arrLangIds);
        } else {
            return false;
        }
    }

    function _deleteCategory($id)
    {
        global $objDatabase;

        if ($objDatabase->Execute("DELETE FROM ".DBPREFIX."module_podcast_category WHERE id=".$id) !== false) {
            if ($objDatabase->Execute("DELETE FROM ".DBPREFIX."module_podcast_rel_category_lang WHERE category_id=".$id) !== false) {
                return true;
            }
        }
        return false;
    }

    function _getLangIdsOfCategory($categoryId)
    {
        global $objDatabase;

        $arrLangIds = array();
        $objLang = $objDatabase->Execute("SELECT lang_id FROM ".DBPREFIX."module_podcast_rel_category_lang WHERE category_id=".$categoryId);
        if ($objLang !== false) {
            while (!$objLang->EOF) {
                array_push($arrLangIds, $objLang->fields['lang_id']);
                $objLang->MoveNext();
            }

            return $arrLangIds;
        } else {
            return false;
        }
    }

    function _setCategoryLangIds($categoryId, $arrLangIds)
    {
        global $objDatabase;

        $arrCurrentLangIds = array();

        $objLang = $objDatabase->Execute("SELECT lang_id FROM ".DBPREFIX."module_podcast_rel_category_lang WHERE category_id=".$categoryId);
        if ($objLang !== false) {
            while (!$objLang->EOF) {
                array_push($arrCurrentLangIds, $objLang->fields['lang_id']);
                $objLang->MoveNext();
            }

            $arrAddedLangIds = array_diff($arrLangIds, $arrCurrentLangIds);
            $arrRemovedLangIds = array_diff($arrCurrentLangIds, $arrLangIds);

            foreach ($arrAddedLangIds as $langId) {
                $objDatabase->Execute("INSERT INTO ".DBPREFIX."module_podcast_rel_category_lang (`category_id`, `lang_id`) VALUES (".$categoryId.", ".$langId.")");
            }

            foreach ($arrRemovedLangIds as $langId) {
                $objDatabase->Execute("DELETE FROM ".DBPREFIX."module_podcast_rel_category_lang WHERE category_id=".$categoryId." AND lang_id=".$langId);
            }

            return true;
        } else {
            return false;
        }
    }

    function _addMedium($title, $youtubeID, $author, $description, $source, $thumbnail, $template, $width, $height, $playlength, $size, $arrCategories, $status)
    {
        global $objDatabase;

        if ($objDatabase->Execute("INSERT INTO ".DBPREFIX."module_podcast_medium (`title`, `youtube_id`, `author`,`description`, `source`, `thumbnail`, `template_id`, `width`, `height`, `playlenght`, `size`, `status`, `date_added`) VALUES ('".contrexx_addslashes($title)."', '".contrexx_addslashes($youtubeID)."', '".contrexx_addslashes($author)."','".contrexx_addslashes($description)."', '".contrexx_addslashes($source)."', '".contrexx_addslashes($thumbnail)."', ".$template.", ".$width.", ".$height.", ".$playlength.", ".$size.", ".$status.", ".time().")") !== false) {
            return $this->_setMediumCategories($objDatabase->Insert_ID(), $arrCategories);
        } else {
            return false;
        }
    }

    function _updateMedium($id, $title, $youtubeID, $author, $description, $thumbnail, $template, $width, $height, $playlength, $size, $arrCategories, $status)
    {
        global $objDatabase;

        if ($objDatabase->Execute("UPDATE ".DBPREFIX."module_podcast_medium SET `title`='".contrexx_addslashes($title)."', `youtube_id`='".contrexx_addslashes($youtubeID)."', `author`='".contrexx_addslashes($author)."',`description`='".contrexx_addslashes($description)."', `thumbnail`='".contrexx_addslashes($thumbnail)."', `template_id`=".$template.", `width`=".$width.", `height`=".$height.", `playlenght`=".$playlength.", `size`=".$size.", `status`=".$status." WHERE id=".$id) !== false) {
            return $this->_setMediumCategories($id, $arrCategories);
        } else {
            return false;
        }
    }

    function _deleteMedium($id)
    {
        global $objDatabase;


        $query = "SELECT `thumbnail`
                  FROM `".DBPREFIX."module_podcast_medium`
                  WHERE `id` = ".$id;
        if(($objRS = $objDatabase->SelectLimit($query, 1)) !== false){
            $thumbNail = $objRS->fields['thumbnail'];
            $objFile = new File();
            $objFile->delFile(ASCMS_DOCUMENT_ROOT, ASCMS_PATH_OFFSET, $thumbNail);
        }

        if ($objDatabase->Execute("DELETE FROM ".DBPREFIX."module_podcast_rel_medium_category WHERE medium_id=".$id) !== false) {
            if ($objDatabase->Execute("DELETE FROM ".DBPREFIX."module_podcast_medium WHERE id=".$id) !== false) {
                return true;
            }
        }
        return false;
    }

    function _setMediumCategories($mediumId, $arrCategories)
    {
        global $objDatabase;

        $arrCurrentCategories = array();

        $objCategorie = $objDatabase->Execute("SELECT category_id FROM ".DBPREFIX."module_podcast_rel_medium_category WHERE medium_id=".$mediumId);
        if ($objCategorie !== false) {
            while (!$objCategorie->EOF) {
                array_push($arrCurrentCategories, $objCategorie->fields['category_id']);
                $objCategorie->MoveNext();
            }

            $arrAddedCategories = array_diff($arrCategories, $arrCurrentCategories);
            $arrRemovedCategories = array_diff($arrCurrentCategories, $arrCategories);

            foreach ($arrAddedCategories as $categoryId) {
                $objDatabase->Execute("INSERT INTO ".DBPREFIX."module_podcast_rel_medium_category (`medium_id`, `category_id`) VALUES (".$mediumId.", ".$categoryId.")");
            }

            foreach ($arrRemovedCategories as $categoryId) {
                $objDatabase->Execute("DELETE FROM ".DBPREFIX."module_podcast_rel_medium_category WHERE medium_id=".$mediumId." AND category_id=".$categoryId);
            }

            return true;
        } else {
            return false;
        }
    }

    function _setHomecontentCategories($arrCategories)
    {
        global $objDatabase;
        $arrCategories = array_filter($arrCategories, create_function('$cat', 'return intval($cat) > 0;'));
        $query = "  UPDATE  `".DBPREFIX."module_podcast_settings`
                    SET `setvalue` = '".implode(',', $arrCategories)."'
                    WHERE `setname` = 'latest_media_categories'";
        if ($objDatabase->Execute($query) !== false) {
            return true;
        } else {
            return false;
        }
    }

    function _getHomecontentCategories($langId = 0)
    {
        $arrHomeCategories = explode(',', $this->_arrSettings['latest_media_categories']);
        if($langId > 0){
            foreach ($arrHomeCategories as $index => $cat) {
                if(!in_array($langId, $this->_getLangIdsOfCategory($cat))){
                    unset($arrHomeCategories[$index]);
                }
            }
        }
        return $arrHomeCategories;
    }

    function _isUniqueMediumTitle($title, $mediumId)
    {
        global $objDatabase;

        $objCount = $objDatabase->SelectLimit("SELECT id FROM ".DBPREFIX."module_podcast_medium WHERE title='".contrexx_addslashes($title)."' AND id!=".$mediumId, 1);
        if ($objCount !== false && $objCount->RecordCount() == 0) {
            return true;
        } else {
            return false;
        }
    }

    function _getTemplates($limit = false, $limitPos = false)
    {
        global $objDatabase, $_CONFIG;

        $arrTemplates = array();
        if ($limit) {
            $objTemplate = $objDatabase->SelectLimit("SELECT id, description, template, extensions FROM ".DBPREFIX."module_podcast_template ORDER BY description", $_CONFIG['corePagingLimit'], $limitPos);
        } else {
            $objTemplate = $objDatabase->Execute("SELECT id, description, template, extensions FROM ".DBPREFIX."module_podcast_template ORDER BY description");
        }
        if ($objTemplate !== false) {
            while (!$objTemplate->EOF) {
                $arrTemplates[$objTemplate->fields['id']] = array(
                    'description'   => $objTemplate->fields['description'],
                    'template'      => $objTemplate->fields['template'],
                    'extensions'    => $objTemplate->fields['extensions']
                );
                $objTemplate->MoveNext();
            }
        }

        return $arrTemplates;
    }

    function _getTemplateCount()
    {
        global $objDatabase;

        $objCount = $objDatabase->SelectLimit("SELECT COUNT(1) AS template_count FROM ".DBPREFIX."module_podcast_template", 1);
        if ($objCount !== false && $objCount->RecordCount() == 1) {
            return $objCount->fields['template_count'];
        } else {
            return false;
        }
    }

    function _isTemplateInUse($templateId)
    {
        global $objDatabase;

        $objCount = $objDatabase->SelectLimit("SELECT id FROM ".DBPREFIX."module_podcast_medium WHERE template_id=".$templateId, 1);
        if ($objCount !== false && $objCount->RecordCount() == 0) {
            return false;
        } else {
            return true;
        }
    }

    function _getTemplate($templateId)
    {
        global $objDatabase;

        $objTemplate = $objDatabase->SelectLimit("SELECT description, template, extensions FROM ".DBPREFIX."module_podcast_template WHERE id=".$templateId, 1);
        if ($objTemplate !== false && $objTemplate->RecordCount() == 1) {
            return array(
                'description'   => $objTemplate->fields['description'],
                'template'      => $objTemplate->fields['template'],
                'extensions'    => $objTemplate->fields['extensions']
            );
        } else {
            return false;
        }
    }

    function _getTemplateMenu($selectedTemplateId, $attrs = '')
    {
        $arrTemplates = &$this->_getTemplates();
        if($selectedTemplateId == $this->_getYoutubeTemplate()){
            $attrs .= ' disabled="disabled"';
        }
        $menu = "<select".(!empty($attrs) ? " ".$attrs : "").">\n";
        foreach ($arrTemplates as $templateId => $arrTemplate) {
            $menu .= "<option value=\"".$templateId."\" ".($templateId == $selectedTemplateId ? 'selected="selected"' : '').">".$arrTemplate['description']." (".$arrTemplate['extensions'].")</option>\n";
        }
        $menu .= "</select>";

        return $menu;
    }

    function _isUniqueTemplateDescription($templateId, $description)
    {
        global $objDatabase;

        $objCount = $objDatabase->SelectLimit("SELECT id FROM ".DBPREFIX."module_podcast_template WHERE description='".contrexx_addslashes($description)."' AND id!=".$templateId, 1);
        if ($objCount !== false && $objCount->RecordCount() == 0) {
            return true;
        } else {
            return false;
        }
    }

    function _updateTemplate($templateId, $description, $template, $extensions)
    {
        global $objDatabase;

        if ($objDatabase->Execute("UPDATE ".DBPREFIX."module_podcast_template SET `description`='".contrexx_addslashes($description)."', template='".contrexx_addslashes($template)."', extensions='".contrexx_addslashes($extensions)."' WHERE id=".$templateId) !== false) {
            return true;
        } else {
            return false;
        }
    }

    function _addTemplate($description, $template, $extensions)
    {
        global $objDatabase;

        if ($objDatabase->Execute("INSERT INTO ".DBPREFIX."module_podcast_template (`description`, `template`, `extensions`) VALUES ('".contrexx_addslashes($description)."', '".contrexx_addslashes($template)."', '".contrexx_addslashes($extensions)."')") !== false) {
            return true;
        } else {
            return false;
        }
    }

    function _getSuitableTemplate($fileName)
    {
        global $objDatabase;

        if (($extension = substr($fileName, strrpos($fileName, '.')+1)) !== false) {
            $objTemplate = $objDatabase->SelectLimit("SELECT id FROM ".DBPREFIX."module_podcast_template WHERE extensions LIKE '%".contrexx_addslashes($extension)."%'", 1);
            if ($objTemplate !== false && $objTemplate->RecordCount() == 1) {
                return $objTemplate->fields['id'];
            }
        }

        return false;
    }

    function _getYoutubeTemplate()
    {
        global $objDatabase;

        $query = "  SELECT `id` FROM `".DBPREFIX."module_podcast_template`
                    WHERE `description` = 'YouTube Video'";
        $objRS = $objDatabase->SelectLimit($query, 1);
        if ($objRS !== false) {
            return $objRS->fields['id'];
        }
    }

    function _deleteTemplate($templateId)
    {
        global $objDatabase;

        if (!$this->_isTemplateInUse($templateId)) {
            if ($objDatabase->Execute("DELETE FROM ".DBPREFIX."module_podcast_template WHERE id=".$templateId) !== false) {
                return true;
            }
        }
        return false;
    }

    function _getHtmlTag($arrMedium, $template)
    {
        $heightSpacer = '[[MEDIUM_HEIGHT]]';
        $widthSpacer = '[[MEDIUM_WIDTH]]';
        $modifiedWidth = 0;
        $modifiedHeight = 0;

        $arrMatches = array();
        if (preg_match('/\[\[MEDIUM_HEIGHT\]\](\s*\+\s*([0-9]+))/', $template, $arrMatches)) {
            $modifiedHeight = $arrMedium['height'] + $arrMatches[2];
            $heightSpacer .= $arrMatches[1];
        }
        if (preg_match('/(([0-9]+)\s*\+\s*)\[\[MEDIUM_HEIGHT\]\]/', $template, $arrMatches)) {
            $modifiedHeight = $arrMedium['height'] + $arrMatches[2];
            $heightSpacer = $arrMatches[1].$heightSpacer;
        }
        if ($modifiedHeight > 0) {
            $template = str_replace($heightSpacer, $modifiedHeight, $template);
        }

        if (preg_match('/\[\[MEDIUM_WIDTH\]\](\s*\+\s*([0-9]+))/', $template, $arrMatches)) {
            $modifiedWidth = $arrMedium['width'] + $arrMatches[2];
            $widthSpacer .= $arrMatches[1];
        }
        if (preg_match('/(([0-9]+)\s*\+\s*)\[\[MEDIUM_WIDTH\]\]/', $template, $arrMatches)) {
            $modifiedWidth = $arrMedium['width'] + $arrMatches[2];
            $widthSpacer = $arrMatches[1].$widthSpacer;
        }
        if ($modifiedWidth > 0) {
            $template = str_replace($widthSpacer, $modifiedWidth, $template);
        }

        return str_replace(
            array('[[MEDIUM_WIDTH]]', '[[MEDIUM_HEIGHT]]', '[[MEDIUM_URL]]', '[[MEDIUM_THUMBNAIL]]', '[[ASCMS_PATH_OFFSET]]'),
            array($arrMedium['width'], $arrMedium['height'], $arrMedium['source'], $arrMedium['thumbnail'] == $this->_noThumbnail ? '' : $arrMedium['thumbnail'], ASCMS_PATH_OFFSET),
            $template);
    }

    function _getShortPlaylengthFormatOfTimestamp($timestamp)
    {
        return sprintf('%02u', floor($timestamp / 3600)).":".sprintf('%02u', floor(($timestamp % 3600) / 60)).":".sprintf('%02u', $timestamp % 60);
    }

    function _getPlaylengthFormatOfTimestamp($timestamp)
    {
        global $_ARRAYLANG;

        $format = '';

        if ($timestamp > 0) {
            $hours = floor($timestamp / 3600);
            $minutes = floor(($timestamp % 3600) / 60);
            $seconds =  $timestamp % 60;

            if ($hours > 0) {
                $format .= $hours." ".($hours > 1 ? $_ARRAYLANG['TXT_PODCAST_HOURS'] : $_ARRAYLANG['TXT_PODCAST_HOUR']);
            }
            if ($minutes > 0) {
                $format .= ($hours > 0 ? " " : "").$minutes." ".($minutes > 1 ? $_ARRAYLANG['TXT_PODCAST_MINUTES'] : $_ARRAYLANG['TXT_PODCAST_MINUTE']);
            }
            if ($seconds > 0) {
                $format .= (($hours > 0 || $minutes > 0) ? " " : "").$seconds." ".($seconds > 1 ? $_ARRAYLANG['TXT_PODCAST_SECONDS'] : $_ARRAYLANG['TXT_PODCAST_SECOND']);
            }
        } else {
            $format = '-';
        }

        return $format;
    }

    function _getSettings()
    {
        global $objDatabase;

        $arrSettings = array();
        $objSettings = $objDatabase->Execute("SELECT setname, setvalue FROM ".DBPREFIX."module_podcast_settings");
        if ($objSettings !== false) {
            while (!$objSettings->EOF) {
                $arrSettings[$objSettings->fields['setname']] = $objSettings->fields['setvalue'];
                $objSettings->MoveNext();
            }
        }

        return $arrSettings;
    }

    function _updateSettings($arrSettings)
    {
        global $objDatabase;

        $status = true;

        foreach ($arrSettings as $key => $value) {
            if ($objDatabase->Execute("UPDATE ".DBPREFIX."module_podcast_settings SET `setvalue`='".$value."' WHERE `setname`='".$key."'") === false) {
                $status = false;
            }
        }

        return $status;
    }

    function _formatFileSize($size)
    {
        global $_ARRAYLANG;

        $exp = log($size, 1024);

        if ($exp < 1) {
            return $size.' '.$_ARRAYLANG['TXT_PODCAST_BYTES'];
        } elseif ($exp < 2) {
            return round($size/1024, 2).' '.$_ARRAYLANG['TXT_PODCAST_KBYTE'];
        } elseif ($exp < 3) {
            return round($size/pow(1024, 2), 2).' '.$_ARRAYLANG['TXT_PODCAST_MBYTE'];
        } else {
            return round($size/pow(1024, 3), 2).' '.$_ARRAYLANG['TXT_PODCAST_GBYTE'];
        }
    }

    function _getViews($mediumID)
    {
        global $objDatabase;
        $query =    "SELECT `views` FROM `".DBPREFIX."module_podcast_medium` WHERE `id` = ".$mediumID;
        if(($objRS = $objDatabase->Execute($query)) !== false){
            return $objRS->fields['views'];
        }else{
            return false;
        }
    }

    /**
     * increment the amount of views for the specified podcast medium by one
     *
     * @access private
     * @param integer medium ID
     */
    function _updateViews($mediumID)
    {
        global $objDatabase;

        $query =    "UPDATE `".DBPREFIX."module_podcast_medium` SET `views` = `views` + 1 WHERE `id` = ".$mediumID;
        $objDatabase->Execute($query);
    }

    /**
     * return the thumbnail resize javascript function
     *
     * @return string javascript resize function
     */
    function _getSetSizeJS(){
        $defaultImg = $this->_noThumbnail;
        return <<< EOF
    var setSize = function(elImg, maxSize){
        try{
            if(elImg.src.indexOf("$defaultImg") > -1){
                return true;
            }
            width = elImg.offsetWidth;
            height = elImg.offsetHeight;
            if(width > maxSize || height > maxSize){
                if(width > height){
                        fact = maxSize / width;
                        elImg.style.width = width*fact+'px';
                        elImg.style.height = height*fact+'px';
                }else{
                        fact = maxSize / height;
                        elImg.style.height = height*fact+'px';
                        elImg.style.width = width*fact+'px';
                }
            }else{
                elImg.style.height = height+'px';
                elImg.style.width = width+'px';
            }
        }catch(e){}
    }
EOF;
    }

    /**
     * select medium source
     *
     * @return void
     */
    function _selectMediumSource()
    {
        global $_ARRAYLANG;

        $youtubeIdError = false;
        if (isset($_POST['podcast_select_source']) && in_array($_POST['podcast_medium_source_type'], array('local', 'remote', 'youtube'))) {
            $match = array();
            $sourceType = $_POST['podcast_medium_source_type'];
            if ($sourceType == 'local') {
                $source = isset($_POST['podcast_medium_local_source']) ? $_POST['podcast_medium_local_source'] : '';
            } elseif($sourceType == 'remote') {
                $source = isset($_POST['podcast_medium_remote_source']) ? $_POST['podcast_medium_remote_source'] : '';
            } else{
                $source = isset($_POST['podcast_medium_youtube_source']) ? $_POST['podcast_medium_youtube_source'] : '';
                preg_match("#".$this->_youTubeAllowedCharacters."{".$this->_youTubeIdLength."}#", $_POST['youtubeID'], $match);
                if(strlen($match[0]) != $this->_youTubeIdLength){
                    $youtubeIdError = true;
                }
            }

            if (!empty($source) && !$youtubeIdError) {
                return $this->_modifyMedium();
            } elseif ($youtubeIdError){
                $this->_strErrMessage = $_ARRAYLANG['TXT_PODCAST_YOUTUBE_SPECIFY_ID'];
            } else {
                $this->_strErrMessage = $_ARRAYLANG['TXT_PODCAST_SELECT_SOURCE_ERR_MSG'];
            }
        } else {
            $sourceType = 'local';
            $source = '';
        }

        if($_REQUEST['section'] != 'podcast'){
            $this->_objTpl->loadTemplatefile('module_podcast_select_medium_source.html');
            $this->_pageTitle = $_ARRAYLANG['TXT_PODCAST_ADD_MEDIUM'];
        }

        $this->_objTpl->setVariable(array(
            'TXT_PODCAST_SELECT_SOURCE'     => $_ARRAYLANG['TXT_PODCAST_SELECT_SOURCE'],
            'TXT_PODCAST_SELECT_SOURCE_TXT' => $_ARRAYLANG['TXT_PODCAST_SELECT_SOURCE_TXT'],
            'TXT_PODCAST_LOCAL'             => $_ARRAYLANG['TXT_PODCAST_LOCAL'],
            'TXT_PODCAST_ADD_MEDIUM'        => $_ARRAYLANG['TXT_PODCAST_ADD_MEDIUM'],
            'TXT_PODCAST_STEP'              => $_ARRAYLANG['TXT_PODCAST_STEP'],
            'TXT_PODCAST_REMOTE'            => $_ARRAYLANG['TXT_PODCAST_REMOTE'],
            'TXT_PODCAST_YOUTUBE'           => $_ARRAYLANG['TXT_PODCAST_YOUTUBE'],
            'TXT_PODCAST_BROWSE'            => $_ARRAYLANG['TXT_PODCAST_BROWSE'],
            'TXT_PODCAST_NEXT'              => $_ARRAYLANG['TXT_PODCAST_NEXT'],
            'TXT_PODCAST_YOUTUBE_ID_VALID'  => $_ARRAYLANG['TXT_PODCAST_YOUTUBE_ID_VALID'],
            'TXT_PODCAST_YOUTUBE_ID_INVALID'=> $_ARRAYLANG['TXT_PODCAST_YOUTUBE_ID_INVALID'],
            'TXT_PODCAST_YOUTUBE_SPECIFY_ID'=> $_ARRAYLANG['TXT_PODCAST_YOUTUBE_SPECIFY_ID']
        ));

        $this->_objTpl->setVariable(array(
            'PODCAST_SELECT_LOCAL_MEDIUM'       => $sourceType == 'local' ? 'checked="checked"' : '',
            'PODCAST_SELECT_LOCAL_MEDIUM_BOX'   => $sourceType == 'local' ? 'block' : 'none',
            'PODCAST_SELECT_REMOTE_MEDIUM'      => $sourceType == 'remote' ? 'checked="checked"' : '',
            'PODCAST_SELECT_REMOTE_MEDIUM_BOX'  => $sourceType == 'remote' ? 'block' : 'none',
            'PODCAST_SELECT_YOUTUBE_MEDIUM'     => $sourceType == 'youtube' ? 'checked="checked"' : '',
            'PODCAST_SELECT_YOUTUBE_MEDIUM_BOX' => $sourceType == 'youtube' ? 'block' : 'none',
            'PODCAST_LOCAL_SOURCE'              => $sourceType == 'local' ? $source : '',
            'PODCAST_REMOTE_SOURCE'             => $sourceType == 'remote' ? $source : 'http://',
            'PODCAST_YOUTUBE_SOURCE'            => $sourceType == 'youtube' ? $source : '',
            'PODCAST_YOUTUBE_ID_CHARACTERS'     => $this->_youTubeAllowedCharacters,
            'PODCAST_YOUTUBE_ID_LENGTH'         => $this->_youTubeIdLength,
            'PODCAST_YOUTUBE_REGEX_JS'          => $this->_youTubeIdRegexJS
        ));
    }

    function _modifyMedium()
    {
        global $_ARRAYLANG, $_CONFIG;

        if (!isset($_REQUEST['section'])) {
            $_REQUEST['section'] = '';
        }
        $mediumId = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
        $mediumTitle = '';
        $mediumYoutubeID = '';
        $mediumAuthor = '';
        $mediumDescription = '';
        $mediumSource = '';
        $mediumThumbnail = '';
        $mediumTemplate = '';
        $mediumWidth = 0;
        $mediumHeight = 0;
        $mediumPlaylength = 0;
        $mediumSize = 0;
        $mediumStatus = 1;
        $mediumCategories = array();
        $saveStatus = true;

        if($_REQUEST['section'] != 'podcast'){
            //load backend template
            $this->_objTpl->loadTemplatefile('module_podcast_modify_medium.html');
        }else{
            //load frontend content as template
            $pageRepo = \Env::get('em')->getRepository('Cx\Core\ContentManager\Model\Entity\Page');
            $pages = $pageRepo->findBy(array(
                'module' => 'podcast',
                'type' => \Cx\Core\ContentManager\Model\Entity\Page::TYPE_APPLICATION,
                'cmd' => 'modifyMedium',
            ));
            
            if (count($pages)) {
                //overwrite template, since _modifyMedium is called in the same request as the _selectMediumSource
                $this->_objTpl->setTemplate(current($pages)->getContent());
            }
        }

        $this->_pageTitle = $mediumId > 0 ? $_ARRAYLANG['TXT_PODCAST_MODIFY_MEDIUM'] : $_ARRAYLANG['TXT_PODCAST_ADD_MEDIUM'];

        $this->_objTpl->setVariable(array(
            'TXT_PODCAST_TITLE'             => $_ARRAYLANG['TXT_PODCAST_TITLE'],
            'TXT_PODCAST_DESCRIPTION'       => $_ARRAYLANG['TXT_PODCAST_DESCRIPTION'],
            'TXT_PODCAST_SOURCE'            => $_ARRAYLANG['TXT_PODCAST_SOURCE'],
            'TXT_PODCAST_TEMPLATE'          => $_ARRAYLANG['TXT_PODCAST_TEMPLATE'],
            'TXT_PODCAST_DIMENSIONS'        => $_ARRAYLANG['TXT_PODCAST_DIMENSIONS'],
            'TXT_PODCAST_PIXEL_WIDTH'       => $_ARRAYLANG['TXT_PODCAST_PIXEL_WIDTH'],
            'TXT_PODCAST_PIXEL_HEIGHT'      => $_ARRAYLANG['TXT_PODCAST_PIXEL_HEIGHT'],
            'TXT_PODCAST_CATEGORIES'        => $_ARRAYLANG['TXT_PODCAST_CATEGORIES'],
            'TXT_PODCAST_STATUS'            => $_ARRAYLANG['TXT_PODCAST_STATUS'],
            'TXT_PODCAST_ACTIVE'            => $_ARRAYLANG['TXT_PODCAST_ACTIVE'],
            'TXT_PODCAST_SAVE'              => $_ARRAYLANG['TXT_PODCAST_SAVE'],
// TODO: Spelling error. Fix the template as well as the language variable and remove this
            'TXT_PODCAST_PLAYLENGHT'        => $_ARRAYLANG['TXT_PODCAST_PLAYLENGHT'],
            'TXT_PODCAST_PLAYLENGTH'        => $_ARRAYLANG['TXT_PODCAST_PLAYLENGTH'],
// TODO: Spelling error. Fix the template as well as the language variable and remove this
            'TXT_PODCAST_PLAYLENGHT_FORMAT' => $_ARRAYLANG['TXT_PODCAST_PLAYLENGHT_FORMAT'],
            'TXT_PODCAST_PLAYLENGTH_FORMAT' => $_ARRAYLANG['TXT_PODCAST_PLAYLENGTH_FORMAT'],
            'TXT_PODCAST_FILESIZE'          => $_ARRAYLANG['TXT_PODCAST_FILESIZE'],
            'TXT_PODCAST_BYTES'             => $_ARRAYLANG['TXT_PODCAST_BYTES'],
            'TXT_PODCAST_AUTHOR'            => $_ARRAYLANG['TXT_PODCAST_AUTHOR'],
            'TXT_PODCAST_EDIT_OR_ADD_IMAGE' => $_ARRAYLANG['TXT_PODCAST_EDIT_OR_ADD_IMAGE'],
            'TXT_PODCAST_THUMBNAIL'         => $_ARRAYLANG['TXT_PODCAST_THUMBNAIL'],
            'TXT_PODCAST_SHOW_FILE'         => $_ARRAYLANG['TXT_PODCAST_SHOW_FILE']
        ));

        if (isset($_POST['podcast_medium_save'])) {
            if (isset($_POST['podcast_medium_title'])) {
                $mediumTitle = trim($_POST['podcast_medium_title']);
            }
            if (isset($_POST['podcast_medium_author'])) {
                $mediumAuthor = trim($_POST['podcast_medium_author']);
            }
            if (isset($_POST['podcast_medium_description'])) {
                $mediumDescription = trim($_POST['podcast_medium_description']);
            }
            if (isset($_POST['podcast_medium_template'])) {
                $mediumTemplate = intval($_POST['podcast_medium_template']);
            }

            $mediumWidth = isset($_POST['podcast_medium_width']) ? intval($_POST['podcast_medium_width']) : 0;
            $mediumHeight = isset($_POST['podcast_medium_height']) ? intval($_POST['podcast_medium_height']) : 0;
            $mediumSize = isset($_POST['podcast_medium_filesize']) ? intval($_POST['podcast_medium_filesize']) : 0;

            if (!empty($_POST['podcast_medium_playlength'])) {
                $arrPlaylength = array();
                if (preg_match('/^(([0-9]*):)?(([0-9]*):)?([0-9]*)$/', $_POST['podcast_medium_playlength'], $arrPlaylength)) {
                    $minutes = empty($arrPlaylength[3]) ? $arrPlaylength[2] : $arrPlaylength[4];
                    $hours = empty($arrPlaylength[3]) ? $arrPlaylength[4] : $arrPlaylength[2];
                    $mediumPlaylength = $hours * 3600 + $minutes * 60 + $arrPlaylength[5];
                }
            }

            if (isset($_POST['podcast_medium_source'])) {
                $mediumSource = trim($_POST['podcast_medium_source']);
            }

            if (isset($_POST['podcast_medium_thumbnail'])) {
                $mediumThumbnail = trim($_POST['podcast_medium_thumbnail']);
            }

            if (!empty($_POST['podcast_youtubeID'])) {
                $mediumYoutubeID = trim($_POST['podcast_youtubeID']);
                $mediumSize = 0;
                $mediumTemplate = $this->_getYoutubeTemplate();
            }
            $mediumStatus = $_REQUEST['section'] != 'podcast'
                            ? (isset($_POST['podcast_medium_status']) ? intval($_POST['podcast_medium_status']) : 0)
                            : ($this->_arrSettings['auto_validate'] ? 1 : 0);

            if (isset($_POST['podcast_medium_associated_category'])) {
                foreach ($_POST['podcast_medium_associated_category'] as $categoryId => $status) {
                    if (intval($status) == 1) {
                        array_push($mediumCategories, intval($categoryId));
                    }
                }
            }

            if (empty($mediumTitle)) {
                $saveStatus = false;
                $this->_strErrMessage .= $_ARRAYLANG['TXT_PODCAST_EMPTY_MEDIUM_TITLE_MSG']."<br />\n";
            } /*elseif (!$this->_isUniqueMediumTitle($mediumTitle, $mediumId)) {
                $saveStatus = false;
                $this->_strErrMessage .= $_ARRAYLANG['TXT_PODCAST_DUPLICATE_MEDIUM_TITLE_MSG']."<br />\n";
            }*/

            if (empty($mediumTemplate)) {
                $saveStatus = false;
                $this->_strErrMessage .= $_ARRAYLANG['TXT_PODCAST_EMPTY_MEDIUM_TEMPLATE_MSG']."<br />\n";
            }

            if ($saveStatus) {
                if ($mediumId > 0 && $_REQUEST['section'] != 'podcast') {
                    if ($this->_updateMedium($mediumId, $mediumTitle, $mediumYoutubeID, $mediumAuthor, $mediumDescription, $mediumThumbnail, $mediumTemplate, $mediumWidth, $mediumHeight, $mediumPlaylength, $mediumSize, $mediumCategories, $mediumStatus)) {
                        $this->_strOkMessage = $_ARRAYLANG['TXT_PODCAST_MEDIUM_ADDED_SUCCESSFULL'];
                        // Class in /core_modules/index.class.php is named Cache
                        // Class in /core_modules/admin.class.php is named CacheManager
                        if (class_exists('Cache')) {
                            $objCache = new Cache();
                        } else {
                            $objCache = new CacheManager();
                        }
                        $objCache->deleteAllFiles();
                        $this->_createRSS();
                        return $this->_media();
                    } else {
                        $this->_strErrMessage = $_ARRAYLANG['TXT_PODCAST_MEDIUM_ADDED_FAILED'];
                    }
                } else {
                    if ($this->_addMedium($mediumTitle, $mediumYoutubeID, $mediumAuthor, $mediumDescription, $mediumSource, $mediumThumbnail, $mediumTemplate, $mediumWidth, $mediumHeight, $mediumPlaylength, $mediumSize, $mediumCategories, $mediumStatus)) {
                        // Class in /core_modules/index.class.php is named Cache
                        // Class in /core_modules/admin.class.php is named CacheManager
                        if (class_exists('Cache')) {
                            $objCache = new Cache();
                        } else {
                            $objCache = new CacheManager();
                        }
                        $objCache->deleteAllFiles();
                        $this->_createRSS();

                        if($_REQUEST['section'] != 'podcast'){
                            $this->_strOkMessage = $_ARRAYLANG['TXT_PODCAST_MEDIUM_UPDATED_SUCCESSFULL'];
                            return $this->_media();
                        }else{
                            if($this->_objTpl->blockExists('podcastThanks')){
                                $this->_objTpl->touchBlock('podcastThanks');
                            }

                            if($this->_objTpl->blockExists('podcastForm')){
                                $this->_objTpl->hideBlock('podcastForm');
                            }
                            return true;
                        }
                    } else {
                        $this->_strErrMessage = $_ARRAYLANG['TXT_PODCAST_MEDIUM_UPDATED_FAILED'];
                    }
                }
            }
        } elseif ($mediumId > 0 && ($arrMedium = &$this->_getMedium($mediumId)) !== false && $_REQUEST['section'] != 'podcast') {
            $mediumTitle = $arrMedium['title'];
            $mediumAuthor = $arrMedium['author'];
            $mediumDescription = $arrMedium['description'];
            $mediumYoutubeID = $arrMedium['youtube_id'];
            $mediumSource = $arrMedium['source'];
            $mediumThumbnail = $arrMedium['thumbnail'];
            $mediumTemplate = $arrMedium['template_id'];
            $mediumWidth = $arrMedium['width'];
            $mediumHeight = $arrMedium['height'];
            $mediumStatus = $arrMedium['status'];
            $mediumCategories = $arrMedium['category'];
            $mediumPlaylength = $arrMedium['playlength'];
            $mediumSize = $arrMedium['size'];
        } elseif ($mediumId == 0) {
            $mediumSource = '';
            if (isset($_POST['podcast_medium_source_type']) && in_array($_POST['podcast_medium_source_type'], array('local', 'remote', 'youtube'))) {
                if ($_POST['podcast_medium_source_type'] == 'local') {
                    if (isset($_POST['podcast_medium_local_source'])) {
                        if (strpos($_POST['podcast_medium_local_source'], ASCMS_PATH_OFFSET) === 0) {
                            $mediumSource =  ASCMS_PROTOCOL.'://%domain%%offset%'.substr($_POST['podcast_medium_local_source'], strlen(ASCMS_PATH_OFFSET));
                        } else {
                            $mediumSource =  ASCMS_PROTOCOL.'://%domain%%offset%'.$_POST['podcast_medium_local_source'];
                        }
                    }
                } elseif ($_POST['podcast_medium_source_type'] == 'youtube') {
                    $mediumYoutubeID = contrexx_addslashes(trim($_POST['youtubeID']));
                    $mediumSource = 'http://youtube.com/v/'.$mediumYoutubeID;
                } elseif (isset($_POST['podcast_medium_remote_source'])) {
                    $mediumSource = $_POST['podcast_medium_remote_source'];
                }
            }

            if (empty($mediumSource)) {
                return $this->_selectMediumSource();
            }

            if(!empty($mediumYoutubeID)){
                $mediumTitle = $this->_getYoutubeTitle($mediumYoutubeID);
                $mediumThumbnail = ASCMS_PATH_OFFSET.$this->_saveYoutubeThumbnail($mediumYoutubeID);
                $mediumTemplate = &$this->_getYoutubeTemplate();
                $mediumDescription = &$this->_getYoutubeDescription($mediumYoutubeID);
                $mediumWidth = $this->_youTubeDefaultWidth;
                $mediumSize = 0;
                $mediumHeight = $this->_youTubeDefaultHeight;
            }else{
                $mediumTitle = ($lastSlash = strrpos($mediumSource, '/')) !== false ? substr($mediumSource, $lastSlash+1) : $mediumSource;
                $mediumTemplate = &$this->_getSuitableTemplate($mediumSource);
                $dimensions = isset($_POST['podcast_medium_local_source']) && MediaLibrary::_isImage(ASCMS_PATH.$_POST['podcast_medium_local_source']) ? @getimagesize(ASCMS_PATH.$_POST['podcast_medium_local_source']) : false;
                if ($dimensions) {
                    $mediumWidth = $dimensions[0];
                    $mediumHeight = $dimensions[1];
                } else {
                    $mediumWidth = $this->_arrSettings['default_width'];
                    $mediumHeight = $this->_arrSettings['default_height'];
                }
                $mediumSize = isset($_POST['podcast_medium_local_source']) ? filesize(ASCMS_PATH.$_POST['podcast_medium_local_source']) : 0;
                $mediumSource = htmlentities(str_replace(array('%domain%', '%offset%'), array($_CONFIG['domainUrl'], ASCMS_PATH_OFFSET), $mediumSource), ENT_QUOTES, CONTREXX_CHARSET);
            }
        }

        $this->_objTpl->setVariable(array(
            'PODCAST_MODIFY_TITLE'              => $mediumId > 0 ? $_ARRAYLANG['TXT_PODCAST_MODIFY_MEDIUM'] : $_ARRAYLANG['TXT_PODCAST_ADD_MEDIUM'].' ('.$_ARRAYLANG['TXT_PODCAST_STEP'].' 2: '.$_ARRAYLANG['TXT_PODCAST_CONFIG_MEDIUM'].')',
            'PODCAST_MEDIUM_ID'                 => $mediumId,
            'PODCAST_MEDIUM_TITLE'              => htmlentities($mediumTitle, ENT_QUOTES, CONTREXX_CHARSET),
            'PODCAST_MEDIUM_AUTHOR'             => htmlentities($mediumAuthor, ENT_QUOTES, CONTREXX_CHARSET),
            'PODCAST_MEDIUM_DESCRIPTION'        => htmlentities($mediumDescription, ENT_QUOTES, CONTREXX_CHARSET),
            'PODCAST_MEDIUM_SOURCE'             => $mediumSource,
            'PODCAST_MEDIUM_SOURCE_URL'         => htmlentities($mediumSource, ENT_QUOTES, CONTREXX_CHARSET),
            'PODCAST_MEDIUM_TEMPLATE_MENU'      => $this->_getTemplateMenu($mediumTemplate, 'name="podcast_medium_template" style="width:450px;"'),
            'PODCAST_MEDIUM_WIDTH'              => $mediumWidth,
            'PODCAST_MEDIUM_HEIGHT'             => $mediumHeight,
// TODO: Spelling error. Fix the template and remove this
            'PODCAST_MEDIUM_PLAYLENGHT'         => $this->_getShortPlaylengthFormatOfTimestamp($mediumPlaylength),
            'PODCAST_MEDIUM_PLAYLENGTH'         => $this->_getShortPlaylengthFormatOfTimestamp($mediumPlaylength),
            'PODCAST_MEDIUM_FILESIZE'           => $mediumSize,
            'PODCAST_MEDIUM_THUMBNAIL_SRC'      => !empty($mediumThumbnail) ? $mediumThumbnail : $this->_noThumbnail,
            'PODCAST_MEDIUM_STATUS'             => $mediumStatus == 1 ? 'checked="checked"' : '',
            'PODCAST_MEDIUM_YOUTUBE_DISABLED'   => !empty($mediumYoutubeID) ? 'disabled="disabled"' : '',
            'PODCAST_MEDIUM_YOUTUBE_ID'         => !empty($mediumYoutubeID) ? $mediumYoutubeID : ''
        ));

        $arrCategories = &$this->_getCategories();
        $categoryNr = 0;
        $arrLanguages = FWLanguage::getLanguageArray();

        foreach ($arrCategories as $categoryId => $arrCategory) {
            if($_REQUEST['section'] == 'podcast'){
                if(!in_array($categoryId, $this->_communityCategories) && !empty($this->_communityCategories)){
                    continue;
                }
            }

            $column = $categoryNr % 3;
            $arrCatLangIds = &$this->_getLangIdsOfCategory($categoryId);
            array_walk($arrCatLangIds, create_function('&$cat, $k, $arrLanguages', '$cat = $arrLanguages[$cat]["lang"];'), $arrLanguages);
            $arrCategory['title'] .= ' ('.implode(', ', $arrCatLangIds).')';

            $this->_objTpl->setVariable(array(
                'PODCAST_CATEGORY_ID'                   => $categoryId,
                'PODCAST_CATEGORY_ASSOCIATED'           => in_array($categoryId, $mediumCategories) ? 'checked="checked"' : '',
                'PODCAST_SHOW_MEDIA_OF_CATEGORY_TXT'    => sprintf($_ARRAYLANG['TXT_PODCAST_SHOW_MEDIA_OF_CATEGORY'], $arrCategory['title']),
                'PODCAST_CATEGORY_NAME'                 => $arrCategory['title']
            ));
            $this->_objTpl->parse('podcast_medium_associated_category_'.$column);

            $categoryNr++;
        }
    }


    /**
     * saves the thumbnail preview of the specified youtube video
     *
     * @param string $youTubeID youtube video ID
     * @return string path to the newly created thumbnail picture
     */
    function _saveYoutubeThumbnail($youTubeID)
    {
        $httpRequest = '';
        $response = '';
        $errmsg = '';
        $errno = 0;
        $s = @fsockopen('img.youtube.com', 80, $errno, $errmsg, 5);
        if(is_resource($s)){
            $httpRequest =  "GET /vi/%s/default.jpg HTTP/1.1\r\n".
                            "Host: img.youtube.com\r\n".
                            "User-Agent: ".$_SERVER['HTTP_USER_AGENT']."\r\n".
                            "Accept: ".$_SERVER['HTTP_ACCEPT']."\r\n".
                            "Accept-Language: ".$_SERVER['HTTP_ACCEPT_LANGUAGE']."\r\n".
                            "Accept-Encoding: \r\n".
                            "Accept-Charset: ".$_SERVER['HTTP_ACCEPT_CHARSET'].";q=0.7,*\r\n".
                            "Cache-Control: max-age=0\r\n".
                            "Connection: close\r\n\r\n";
            fwrite($s, sprintf($httpRequest, $youTubeID));
            fflush($s);

            $response = fread($s, 512);
            $match = array();
            preg_match('#Content-Length: ([0-9]+)#', $response, $match);
            $contentLength = $match[1];
            while(!feof($s)){
                $response .= fread($s, 512);
            }
            @fclose($s);
            $response = substr($response, -$contentLength);
            $mediumThumbnail = '/images/podcast/youtube_thumbnails/youtube_'.$youTubeID.'.jpg';
            $hImg = fopen(ASCMS_DOCUMENT_ROOT.$mediumThumbnail, 'w');
            fwrite($hImg, $response, $contentLength);
            fclose($hImg);
        }
        return $mediumThumbnail;
    }

    /**
     * return the title of the specified youtube video
     *
     * @param string $youTubeID youtube video ID
     * @return string youtube video title
     */
    function _getYoutubeTitle($youTubeID)
    {
        $httpRequest = '';
        $response = '';
        $mediumTitle = '';
        $errmsg = '';
        $errno = 0;
        $s = @fsockopen('www.youtube.com', 80, $errno, $errmsg, 5);
        if(is_resource($s)){
            $httpRequest =  "GET /watch?v=".$youTubeID." HTTP/1.1\r\n".
                            "Host: www.youtube.com\r\n".
                            "User-Agent: ".$_SERVER['HTTP_USER_AGENT']."\r\n".
                            "Accept: ".$_SERVER['HTTP_ACCEPT']."\r\n".
                            "Accept-Language: ".$_SERVER['HTTP_ACCEPT_LANGUAGE']."\r\n".
                            "Accept-Encoding: \r\n".
                            "Accept-Charset: ".$_SERVER['HTTP_ACCEPT_CHARSET'].";q=0.7,*\r\n".
                            "Cache-Control: max-age=0\r\n".
                            "Connection: close\r\n\r\n";
            fwrite($s, $httpRequest);
            fflush($s);
            while(!feof($s)){
                $response .= fread($s, 512);
            }
            @fclose($s);
            $match = array();
            preg_match('#<title>YouTube - ([^<]+)</title>#', $response, $match);
            $mediumTitle = $match[1];
        }
        return $mediumTitle;
    }

    /**
     * return the description of the specified youtube video
     *
     * @param string $youTubeID youtube video ID
     * @return string youtube video description
     */
    function _getYoutubeDescription($youTubeID)
    {
        return '';
/*
        $httpRequest = '';
        $response = '';
        $mediumDescription = '';
        $s = @fsockopen('www.youtube.com', 80, $errno, $errmsg, 5);
        if(is_resource($s)){
            $httpRequest =  "GET /watch?v=".$youTubeID." HTTP/1.1\r\n".
                            "Host: www.youtube.com\r\n".
                            "User-Agent: ".$_SERVER['HTTP_USER_AGENT']."\r\n".
                            "Accept: ".$_SERVER['HTTP_ACCEPT']."\r\n".
                            "Accept-Language: ".$_SERVER['HTTP_ACCEPT_LANGUAGE']."\r\n".
                            "Accept-Encoding: \r\n".
                            "Accept-Charset: ".$_SERVER['HTTP_ACCEPT_CHARSET'].";q=0.7,*\r\n".
                            "Cache-Control: max-age=0\r\n".
                            "Connection: close\r\n\r\n";
            fwrite($s, $httpRequest);
            fflush($s);
            while(!feof($s)){
                $response .= fread($s, 512);
            }
            @fclose($s);
            preg_match('/expand-content">(.*?)\).*?<a/im', $response, $match);
            $mediumDescription = $match[1];
        }
        return $mediumDescription;
*/
    }


    function _createRSS()
    {
        global $_CONFIG, $objDatabase;
        $this->_arrSettings = &$this->_getSettings();
        $arrMedia = array();
        $objMedium = $objDatabase->Execute("
            SELECT tblMedium.id,
                   tblMedium.title,
                   tblMedium.author,
                   tblMedium.description,
                   tblMedium.source,
                   tblMedium.size,
                   tblMedium.date_added,
                   tblCategory.id AS categoryId,
                   tblCategory.title AS categoryTitle
            FROM ".DBPREFIX."module_podcast_medium AS tblMedium
            LEFT JOIN ".DBPREFIX."module_podcast_rel_medium_category AS tblRel ON tblRel.medium_id=tblMedium.id
            LEFT JOIN ".DBPREFIX."module_podcast_category AS tblCategory ON tblCategory.id=tblRel.category_id
            WHERE tblMedium.status=1
            ORDER BY tblMedium.date_added DESC");
        if ($objMedium !== false) {
            while (!$objMedium->EOF) {
                if (!isset($arrMedia[$objMedium->fields['id']])) {
                    $arrMedia[$objMedium->fields['id']] = array(
                        'title'         => $objMedium->fields['title'],
                        'author'        => $objMedium->fields['author'],
                        'description'   => $objMedium->fields['description'],
                        'source'        => str_replace(array('%domain%', '%offset%'), array($_CONFIG['domainUrl'], ASCMS_PATH_OFFSET), $objMedium->fields['source']),
                        'size'          => $objMedium->fields['size'],
                        'date_added'    => $objMedium->fields['date_added'],
                        'categories'    => array()
                    );
                }
                if (!empty($objMedium->fields['id'])) {
                    $arrMedia[$objMedium->fields['id']]['categories'][$objMedium->fields['categoryId']] = $objMedium->fields['categoryTitle'];
                }

                $objMedium->MoveNext();
            }
        }


        $objRSSWriter = new RSSWriter();

        $objRSSWriter->characterEncoding = CONTREXX_CHARSET;
        $objRSSWriter->channelTitle = $this->_arrSettings['feed_title'];
        $objRSSWriter->channelLink = 'http://'.$_CONFIG['domainUrl'].($_SERVER['SERVER_PORT'] == 80 ? "" : ":".intval($_SERVER['SERVER_PORT'])).ASCMS_PATH_OFFSET.'/index.php?section=podcast';
        $objRSSWriter->channelDescription = $this->_arrSettings['feed_description'];
        $objRSSWriter->channelCopyright = 'Copyright '.date('Y').', http://'.$_CONFIG['domainUrl'];

        if (!empty($this->_arrSettings['feed_image'])) {
            $objRSSWriter->channelImageUrl = 'http://'.$_CONFIG['domainUrl'].($_SERVER['SERVER_PORT'] == 80 ? "" : ":".intval($_SERVER['SERVER_PORT'])).$this->_arrSettings['feed_image'];
            $objRSSWriter->channelImageTitle = $objRSSWriter->channelTitle;
            $objRSSWriter->channelImageLink = $objRSSWriter->channelLink;
        }
        $objRSSWriter->channelWebMaster = $_CONFIG['coreAdminEmail'];

        $itemLink = "http://".$_CONFIG['domainUrl'].($_SERVER['SERVER_PORT'] == 80 ? "" : ":".intval($_SERVER['SERVER_PORT'])).ASCMS_PATH_OFFSET."/index.php?section=podcast&amp;id=";
        $categoryLink = "http://".$_CONFIG['domainUrl'].($_SERVER['SERVER_PORT'] == 80 ? "" : ":".intval($_SERVER['SERVER_PORT'])).ASCMS_PATH_OFFSET."/index.php?section=podcast&amp;cid=";

        // create podcast feed
        $objRSSWriter->xmlDocumentPath = ASCMS_FEED_PATH.'/podcast.xml';
        foreach ($arrMedia as $mediumId => $arrMedium) {
            $arrCategories = array();
            foreach ($arrMedium['categories'] as $categoryId => $categoryTitle) {
                array_push($arrCategories, array(
                    'domain'    => htmlspecialchars($categoryLink.$categoryId, ENT_QUOTES, CONTREXX_CHARSET),
                    'title'     => htmlspecialchars($categoryTitle, ENT_QUOTES, CONTREXX_CHARSET)
                ));
            }

            $objRSSWriter->addItem(
                htmlspecialchars($arrMedium['title'], ENT_QUOTES, CONTREXX_CHARSET),
                $itemLink.$mediumId,
                htmlspecialchars($arrMedium['description'], ENT_QUOTES, CONTREXX_CHARSET),
                htmlspecialchars($arrMedium['author'], ENT_QUOTES, CONTREXX_CHARSET),
                $arrCategories,
                '',
                array('url' => htmlspecialchars($arrMedium['source'], ENT_QUOTES, CONTREXX_CHARSET), 'length' => !empty($arrMedium['size']) ? $arrMedium['size'] : 'N/A', 'type' => 'application/x-video'),
                '',
                $arrMedium['date_added']
            );
        }
        $status = $objRSSWriter->write();

        if (count($objRSSWriter->arrErrorMsg) > 0) {
            $this->_strErrMessage .= implode('<br />', $objRSSWriter->arrErrorMsg);
        }
        if (count($objRSSWriter->arrWarningMsg) > 0) {
            $this->_strErrMessage .= implode('<br />', $objRSSWriter->arrWarningMsg);
        }
        return $status;
    }
}
?>
