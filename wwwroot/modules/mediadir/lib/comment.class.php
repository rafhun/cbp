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
 * Media Directory Comment Class
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Comvation Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_mediadir
 * @todo        Edit PHP DocBlocks!
 */

/**
 * Media Directory Comment Class
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_mediadir
 */
class mediaDirectoryComment extends mediaDirectoryLibrary
{
    public $strOkMessage;
    public $strErrMessage;

    var $tmpPageSection;
    var $tmpPageCmd;

    /**
     * Constructor
     */
    function __construct()
    {
        parent::getSettings();
    }



    function getCommentJavascript(){
        global $_ARRAYLANG;

        $strOkMessage = $_ARRAYLANG['TXT_MEDIADIR_COMMENT_ADD_SUCCESSFULL'];
        $strErrMessage = $_ARRAYLANG['TXT_MEDIADIR_COMMENT_ADD_CORRUPT'];
        
        $strFunctionComment = $this->moduleName.'Comment';
        $strFunctionRefreshComment = $this->moduleName.'RefreshComments';
        $strFunctionCheckCommentForm = $this->moduleName.'CheckCommentForm';
        $strSection = $this->moduleName;
        $strNewComment = $this->moduleName.'NewComment_';
        $strNewAddedComment = $this->moduleName.'NewAddedComment_';
        $strCommentOk = $this->moduleName.'CommentOk';
        $strCommentErr = $this->moduleName.'CommentErr';
        $strCommentErrMessage = $this->moduleName.'ErrorMessage';

        $strCommentsJavascript  =  <<<EOF
        
var $strFunctionComment = function(entry)
{
    var elEntry = cx.jQuery('#commentForm_'+entry);
    elEntry.children().hide();
    elEntry.prepend('<img src="images/modules/$strSection/loading.gif" border="0" alt="loading..." />');

    jQuery.post('index.php?section=$strSection&comment=add&eid='+entry, cx.jQuery('#commentFormInputs_'+entry).serialize()).success(function(response) {
        var arrResponse = response.split("-");
        var status = arrResponse[0];
        var section = arrResponse[1];
        var cmd = arrResponse[2];

        if(status == 'success') {
            $strFunctionRefreshComment(entry,section,cmd);
        } else if (status == 'captcha') {
            elEntry.children('img:first').remove();
            cx.jQuery('#commentForm_'+entry+' #commentCaptcha')[0].css('border', '#ff0000 1px solid');
            elEntry.children().show();
        } else {
            cx.jQuery('#commentForm_'+entry).attr('class', '$strCommentErr');
            cx.jQuery('#commentForm_'+entry).html('$strErrMessage');
        }
    }).error(function(){
        cx.jQuery('#commentForm_'+entry).attr('class', '$strCommentErr');
        cx.jQuery('#commentForm_'+entry).html('$strErrMessage');
    });
}

var $strFunctionRefreshComment = function(entry,section,cmd)
{
    jQuery.get('index.php', {section : '$strSection', comment : 'refresh', eid : entry, pageSection : section, pageCmd : cmd}).success(function(response) {
        cx.jQuery('#$strNewAddedComment'+entry).attr('class', '$strNewComment');
        cx.jQuery('#$strNewAddedComment'+entry).html(response);
        cx.jQuery('#$strNewAddedComment'+entry).css('display', 'block');

        cx.jQuery('#commentForm_'+entry).attr('class', '$strCommentOk');
        cx.jQuery('#commentForm_'+entry).html('$strOkMessage');
    });
}

var $strFunctionCheckCommentForm = function(entry)
{
    var isOk = true;
    var commentName = cx.jQuery('#commentName').val();
    var commentComment = cx.jQuery('#commentComment').val();

    errorCSSBorderStyle = '#ff0000 1px solid';

    if (commentName == '') {
    	isOk = false;
    	cx.jQuery('#commentName').css({'border': errorCSSBorderStyle});
    } else {
        cx.jQuery('#commentName').css({'border': ''});
    }

    if(commentComment == '') {
    	isOk = false;
    	cx.jQuery('#commentComment').css({'border': errorCSSBorderStyle});
    } else {
        cx.jQuery('#commentComment').css({'border': ''});
    }

    if (!isOk) {
		cx.jQuery('#$strCommentErrMessage').css({'display': 'block'});
	} else {
	   $strFunctionComment(entry);
	}
}

EOF;
        return $strCommentsJavascript;
    }



    function getCommentForm($objTpl, $intEnrtyId) {
        global $_ARRAYLANG, $_CORELANG, $objDatabase;

        if($this->arrSettings['settingsAllowComments'] == 1) {
            $bolGenerateCommentForm = false;

            $objFWUser  = FWUser::getFWUserObject();
            $objUser    = $objFWUser->objUser;

            if($this->arrSettings['settingsCommentOnlyCommunity'] == 1) {
                if($objUser->login()) {
                    $bolGenerateCommentForm = true;
                }
            } else {
                $bolGenerateCommentForm = true;
            }

            if($bolGenerateCommentForm) {
                if($objUser->login()) {
                    $strCommentFormName = htmlspecialchars($objUser->getUsername(), ENT_QUOTES, CONTREXX_CHARSET);
                    $strCommentFormMail = htmlspecialchars($objUser->getEmail(), ENT_QUOTES, CONTREXX_CHARSET);
                    $strCommentFormUrl = htmlspecialchars($objUser->getProfileAttribute('website'), ENT_QUOTES, CONTREXX_CHARSET);
                } else {
                    $strCaptchaCode = $this->getCaptcha();
                }

                $strCommentForm  = '<div class="'.$this->moduleName.'CommentForm" id="commentForm_'.$intEnrtyId.'">';
                $strCommentForm .= '<form action="'.$_SERVER['REQUEST_URI'].'" name="commentFormInputs_'.$intEnrtyId.'" id="commentFormInputs_'.$intEnrtyId.'" method="post" >';
                $strCommentForm .= '<input name="commentPageSection" value="'.$_GET['section'].'" type="hidden" />';
                $strCommentForm .= '<input name="commentPageCmd" value="'.$_GET['cmd'].'" type="hidden" />';
                $strCommentForm .= '<p><label>'.$_CORELANG['TXT_NAME'].'<font color="#ff0000"> *</font></label><input name="commentName" id="commentName" class="'.$this->moduleName.'InputfieldComment" value="'.$strCommentFormName.'" type="text" /></p>';
                $strCommentForm .= '<p><label>'.$_CORELANG['TXT_ACCESS_EMAIL'].'</label><input name="commentMail" class="'.$this->moduleName.'InputfieldComment" id="commentMail" value="'.$strCommentFormMail.'" type="text" /></p>';
                $strCommentForm .= '<p><label>'.$_CORELANG['TXT_ACCESS_WEBSITE'].'</label><input name="commentUrl" class="'.$this->moduleName.'InputfieldComment" id="commentUrl" value="'.$strCommentFormUrl.'" type="text" /></p>';
                $strCommentForm .= '<p><label>'.$_ARRAYLANG['TXT_MEDIADIR_COMMENT'].'<font color="#ff0000"> *</font></label><textarea name="commentComment" id="commentComment" class="'.$this->moduleName.'TextareaComment"></textarea></p>';
                $strCommentForm .= $strCaptchaCode;
                $strCommentForm .= '<p><input class="'.$this->moduleName.'ButtonComment" value="'.$_ARRAYLANG['TXT_MEDIADIR_ADD'].'" onclick="'.$this->moduleName.'CheckCommentForm('.$intEnrtyId.');" name="add" type="button"></p>';
                $strCommentForm .= '</form>';
                $strCommentForm .= '<div style="display: none; color: rgb(255, 0, 0);" id="'.$this->moduleName.'ErrorMessage"><p>'.$_ARRAYLANG['TXT_MEDIADIR_PLEASE_CHECK_INPUT'].'</p></div>';
                $strCommentForm .= '</div>';

                $objTpl->setVariable(array(
                    $this->moduleLangVar.'_ENTRY_COMMENT_FORM' => $strCommentForm,
                    'TXT_'.$this->moduleLangVar.'_COMMENTS' => $_ARRAYLANG['TXT_MEDIADIR_COMMENTS']
                ));
            }
        }
    }



    function getCaptcha() {
        global $_CORELANG;

        $strCode = '<p><label>'.$_CORELANG['TXT_CORE_CAPTCHA'].'</label>'.FWCaptcha::getInstance()->getCode().'</p>';

        return $strCode;
    }



    function getComments($objTpl, $intEnrtyId) {
        global $_ARRAYLANG, $objDatabase;

        if($this->arrSettings['settingsAllowComments'] == 1) {
            $objRSGetComments = $objDatabase->Execute("
                SELECT
                    `id`, `added_by`, `date`, `ip`, `name`, `mail`, `url`, `notification`, `comment`
                FROM
                    ".DBPREFIX."module_".$this->moduleTablePrefix."_comments
                WHERE
                    `entry_id` = '".intval($intEnrtyId)."'
                ORDER BY
                    `id` ASC
            ");

            $intCountComments = $objRSGetComments->RecordCount();

            if(intval($objTpl->blockExists($this->moduleName.'EntryComments')) != 0) {
                if ($objRSGetComments !== false) {
                    $i=0;
                    while (!$objRSGetComments->EOF) {
                        if(intval($objRSGetComments->fields['added_by']) != 0) {
                            $objFWUser  = FWUser::getFWUserObject();
                            $objUser = $objFWUser->objUser;
                            $objUser = $objUser->getUser(intval($objRSGetComments->fields['added_by']));
                            $strAddedBy = $objUser->getUsername();
                        } else {
                            $strAddedBy = "unknown";
                        }

                        if(!empty($objRSGetComments->fields['url'])) {
                            if(substr($objRSGetComments->fields['url'], 0,7) != 'http://') {
                                $strUrl = '<a href="http://'.strip_tags($objRSGetComments->fields['url']).'" class="'.$this->moduleName.'CommentUrl">'.strip_tags($objRSGetComments->fields['url']).'</a>';
                            } else {
                                $strUrl = '<a href="'.strip_tags($objRSGetComments->fields['url']).'" class="'.$this->moduleName.'CommentUrl">'.strip_tags($objRSGetComments->fields['url']).'</a>';
                            }
                        }

                        if(!empty($objRSGetComments->fields['mail'])) {
                            $strMail = '<a href="mailto:'.$objRSGetComments->fields['mail'].'" class="'.$this->moduleName.'CommentMail">'.$objRSGetComments->fields['mail'].'</a>';
                        }

                        $objTpl->setVariable(array(
                            $this->moduleLangVar.'_ENTRY_COMMENT_ROW_CLASS' => $i%2==0 ? 'row1' : 'row2',
                            $this->moduleLangVar.'_ENTRY_COMMENT_ENTRY_ID' => intval($intEnrtyId),
                            $this->moduleLangVar.'_ENTRY_COMMENT_ID' => intval($objRSGetComments->fields['id']),
                            $this->moduleLangVar.'_ENTRY_COMMENT_ADDED_BY' => contrexx_raw2xhtml($strAddedBy),
                            $this->moduleLangVar.'_ENTRY_COMMENT_NAME' => strip_tags(htmlspecialchars($objRSGetComments->fields['name'], ENT_QUOTES, CONTREXX_CHARSET)),
                            $this->moduleLangVar.'_ENTRY_COMMENT_MAIL' => $strMail,
                            $this->moduleLangVar.'_ENTRY_COMMENT_MAIL_SRC' => strip_tags(htmlspecialchars($objRSGetComments->fields['mail'], ENT_QUOTES, CONTREXX_CHARSET)),
                            $this->moduleLangVar.'_ENTRY_COMMENT_URL' => $strUrl,
                            $this->moduleLangVar.'_ENTRY_COMMENT_URL_SRC' => strip_tags(htmlspecialchars($objRSGetComments->fields['url'], ENT_QUOTES, CONTREXX_CHARSET)),
                            $this->moduleLangVar.'_ENTRY_COMMENT_COMMENT' => strip_tags(htmlspecialchars($objRSGetComments->fields['comment'], ENT_QUOTES, CONTREXX_CHARSET)),
                            $this->moduleLangVar.'_ENTRY_COMMENT_IP' => strip_tags(htmlspecialchars($objRSGetComments->fields['ip'], ENT_QUOTES, CONTREXX_CHARSET)),
                            $this->moduleLangVar.'_ENTRY_COMMENT_DATE' => date("d. M Y",$objRSGetComments->fields['date'])."  ".$_ARRAYLANG['TXT_MEDIADIR_AT']." ".date("H:i:s",$objRSGetComments->fields['date']),
                        ));

                        $i++;
                        $objTpl->parse($this->moduleName.'EntryComments');

                        $objRSGetComments->MoveNext();
                    }
                }
            }

            $objTpl->setVariable(array(
                $this->moduleLangVar.'_ENTRY_COMMENTS' => intval($intCountComments).' '.$_ARRAYLANG['TXT_MEDIADIR_COMMENTS'],
                'TXT_'.$this->moduleLangVar.'_COMMENTS' => $_ARRAYLANG['TXT_MEDIADIR_COMMENTS'],
                $this->moduleLangVar.'_ENTRY_NEW_ADDED_COMMENT' => '<div id="'.$this->moduleName.'NewAddedComment_'.$intEnrtyId.'" style="display: none;">hier erscheint der gerade eben hinzugefügte Kommentar.</div>',
            ));
        }
    }



    function saveComment($intEntryId, $arrCommentData) {
        global $_ARRAYLANG, $objDatabase;

        $strRemoteAddress = contrexx_addslashes($_SERVER['REMOTE_ADDR']);

        $objFWUser  = FWUser::getFWUserObject();
        $objUser    = $objFWUser->objUser;

        if($objUser->login()) {
            $intAddedBy = $objUser->getId();
        } else {
            $intAddedBy = 0;

            //captcha check
            if(!FWCaptcha::getInstance()->check())
                die('captcha');
        }

        $objInsertComment = $objDatabase->Execute("
            INSERT INTO
                ".DBPREFIX."module_".$this->moduleTablePrefix."_comments
            SET
                `entry_id`='".intval($intEntryId)."',
                `added_by`='".intval($intAddedBy)."',
                `date`='".mktime()."',
                `ip`='".$strRemoteAddress."',
                `name`='".contrexx_addslashes($arrCommentData['commentName'])."',
                `mail`='".contrexx_addslashes($arrCommentData['commentMail'])."',
                `url`='".contrexx_addslashes($arrCommentData['commentUrl'])."',
                `notification`='0',
                `comment`='".contrexx_addslashes($arrCommentData['commentComment'])."'
        ");

        if($objInsertComment !== false) {
            echo 'success-'.$arrCommentData['commentPageSection']."-".$arrCommentData['commentPageCmd'];
        } else {
            echo 'fail';
        }

        die();
    }



    function refreshComments($intEnrtyId, $strPageSection, $strPageCmd) {
        global $_LANGID;

        $arrComment = $this->getLastComment($intEnrtyId);

        $pageRepo = \Env::get('em')->getRepository('Cx\Core\ContentManager\Model\Entity\Page');
        $pages = $pageRepo->findBy(array(
            'module' => contrexx_addslashes($strPageSection),
            'cmd' => contrexx_addslashes($strPageCmd),
            'type' => \Cx\Core\ContentManager\Model\Entity\Page::TYPE_APPLICATION,
            'lang' => intval($_LANGID),
        ));

        if (count($pages)) {
            $strPageContent = reset($pages)->getContent();
            $regexBlock = '<!-- BEGIN '.$this->moduleName.'EntryComments -->(.*?)<!-- END '.$this->moduleName.'EntryComments -->';

            if(preg_match("/".$regexBlock."/is", $strPageContent, $matchBlock)){
                $strComment = $matchBlock[1];

                $arrPlacholders = array_keys($arrComment);
                $intNumPlaceholders = intval(count($arrPlacholders));

                for ($x = 0; $x < $intNumPlaceholders; $x++) {
                    $strComment = str_replace($arrPlacholders[$x], $arrComment[$arrPlacholders[$x]], $strComment);
                }

                echo $strComment;
            }
        }

        die();
    }



    function getLastComment($intEnrtyId) {
        global $_ARRAYLANG, $objDatabase;

        $arrComment = array();

        $objRSGetComment = $objDatabase->SelectLimit("
            SELECT
                `id`, `added_by`, `date`, `ip`, `name`, `mail`, `url`, `notification`, `comment`
            FROM
                ".DBPREFIX."module_".$this->moduleTablePrefix."_comments
            WHERE
                `entry_id` = '".intval($intEnrtyId)."'
            ORDER BY
                `id` DESC
        ", 1);

        if ($objRSGetComment !== false) {
            if(intval($objRSGetComment->fields['added_by']) != 0) {
                $objFWUser  = FWUser::getFWUserObject();
                $objUser = $objFWUser->objUser;
                $objUser = $objUser->getUser(intval($objRSGetComment->fields['added_by']));
                $strAddedBy = $objUser->getUsername();
            } else {
                $strAddedBy = "unknown";
            }

            if(!empty($objRSGetComment->fields['url'])) {
                if(substr($objRSGetComments->fields['url'], 0,7) != 'http://') {
                    $strUrl = '<a href="http://'.strip_tags($objRSGetComments->fields['url']).'" class="'.$this->moduleName.'CommentUrl">'.strip_tags($objRSGetComment->fields['url']).'</a>';
                } else {
                    $strUrl = '<a href="'.strip_tags($objRSGetComment->fields['url']).'" class="'.$this->moduleName.'CommentUrl">'.strip_tags($objRSGetComment->fields['url']).'</a>';
                }
            }

            if(!empty($objRSGetComment->fields['mail'])) {
                $strMail = '<a href="mailto:'.$objRSGetComment->fields['mail'].'" class="'.$this->moduleName.'CommentMail">'.$objRSGetComment->fields['mail'].'</a>';
            }

            $arrComment['{'.$this->moduleLangVar.'_ENTRY_COMMENT_ENTRY_ID}'] = intval($intEnrtyId);
            $arrComment['{'.$this->moduleLangVar.'_ENTRY_COMMENT_ID}'] = intval($objRSGetComment->fields['id']);
            $arrComment['{'.$this->moduleLangVar.'_ENTRY_COMMENT_ADDED_BY}'] = contrexx_raw2xhtml($strAddedBy);
            $arrComment['{'.$this->moduleLangVar.'_ENTRY_COMMENT_NAME}'] = strip_tags(htmlspecialchars($objRSGetComment->fields['name'], ENT_QUOTES, CONTREXX_CHARSET));
            $arrComment['{'.$this->moduleLangVar.'_ENTRY_COMMENT_MAIL}'] = $strMail;
            $arrComment['{'.$this->moduleLangVar.'_ENTRY_COMMENT_MAIL_SRC}'] = strip_tags(htmlspecialchars($objRSGetComment->fields['mail'], ENT_QUOTES, CONTREXX_CHARSET));
            $arrComment['{'.$this->moduleLangVar.'_ENTRY_COMMENT_URL}'] = $strUrl;
            $arrComment['{'.$this->moduleLangVar.'_ENTRY_COMMENT_URL_SRC}'] = strip_tags(htmlspecialchars($objRSGetComment->fields['url'], ENT_QUOTES, CONTREXX_CHARSET));
            $arrComment['{'.$this->moduleLangVar.'_ENTRY_COMMENT_COMMENT}'] = strip_tags(htmlspecialchars($objRSGetComment->fields['comment'], ENT_QUOTES, CONTREXX_CHARSET));
            $arrComment['{'.$this->moduleLangVar.'_ENTRY_COMMENT_IP}'] = strip_tags(htmlspecialchars($objRSGetComment->fields['ip'], ENT_QUOTES, CONTREXX_CHARSET));
            $arrComment['{'.$this->moduleLangVar.'_ENTRY_COMMENT_DATE}'] = date("d. M Y",$objRSGetComment->fields['date'])."  ".$_ARRAYLANG['TXT_MEDIADIR_AT']." ".date("H:i:s",$objRSGetComment->fields['date']);

            return $arrComment;
        }
    }



    function restoreComments($intEnrtyId) {
        global $_ARRAYLANG, $objDatabase;

        $objRestoreComments = $objDatabase->Execute("
            DELETE FROM
                ".DBPREFIX."module_".$this->moduleTablePrefix."_comments
            WHERE
                `entry_id`='".intval($intEnrtyId)."'
        ");

        if($objRestoreComments !== false) {
            return true;
        } else {
            return false;
        }
    }



    function deleteComment($intCommentId) {
        global $_ARRAYLANG, $objDatabase;

        $objDeleteComments = $objDatabase->Execute("
            DELETE FROM
                ".DBPREFIX."module_".$this->moduleTablePrefix."_comments
            WHERE
                `id`='".intval($intCommentId)."'
        ");

        if($objDeleteComments !== false) {
            return true;
        } else {
            return false;
        }
    }
}
