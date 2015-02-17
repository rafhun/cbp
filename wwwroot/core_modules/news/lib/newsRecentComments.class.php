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
 * News : Get recent comments
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Thomas Däppen <thomas.daeppen@comvation.com>
 * @author      ss4u <ss4u.comvation@gmail.com>
 * @version     3.1.1
 * @package     contrexx
 * @subpackage  module_news
 */

/**
 * News : Get recent comments
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Thomas Däppen <thomas.daeppen@comvation.com>
 * @author      ss4u <ss4u.comvation@gmail.com>
 * @version     3.1.1
 * @package     contrexx
 * @subpackage  module_news
 */
class newsRecentComments extends newsLibrary 
{
    public $_pageContent;
    public $_objTemplate;
    public $arrSettings = array();

    function __construct($pageContent)
    {
        parent::__construct();
        $this->getSettings();
        $this->_pageContent = $pageContent;
        $this->_objTemplate = new \Cx\Core\Html\Sigma('.');
        CSRF::add_placeholder($this->_objTemplate);
    }
    
    function getRecentNewsComments()
    {
        global $objDatabase;
        
        $this->_objTemplate->setTemplate($this->_pageContent,true,true);
        
        // abort if template block is missing
        if (!$this->_objTemplate->blockExists('news_comments')) {
            return;
        }

        // abort if commenting system is not active
        if (!$this->arrSettings['news_comments_activated']) {
            $this->_objTemplate->hideBlock('news_comments');            
        } else {
            $_ARRAYLANG = \Env::get('init')->loadLanguageData('news');
            $commentsCount = (int) $this->arrSettings['recent_news_message_limit'];

            $query = "SELECT  `nComment`.`title`,
                              `nComment`.`date`,
                              `nComment`.`poster_name`,
                              `nComment`.`userid`,
                              `nComment`.`text`,
                              `news`.`id`,
                              `news`.`catid`
                        FROM  
                              `".DBPREFIX."module_news_comments` AS nComment
                        LEFT JOIN 
                              `".DBPREFIX."module_news` AS news
                        ON
                            `nComment`.newsid = `news`.id
                        LEFT JOIN 
                              `".DBPREFIX."module_news_locale` AS nLocale
                        ON
                            `news`.id = `nLocale`.news_id AND `nLocale`.lang_id = ". FRONTEND_LANG_ID ."
                        WHERE
                            `news`.status = 1
                        AND
                            `news`.allow_comments = 1
                        AND
                            `nLocale`.is_active = 1
                        AND
                            `nComment`.`is_active` = '1'
                        ORDER BY
                              `date` DESC 
                        LIMIT 0, $commentsCount";

            $objResult = $objDatabase->Execute($query);

            // no comments for this message found
            if (!$objResult || $objResult->EOF) {
                if ($this->_objTemplate->blockExists('news_no_comment')) {
                    $this->_objTemplate->setVariable('TXT_NEWS_COMMENTS_NONE_EXISTING', $_ARRAYLANG['TXT_NEWS_COMMENTS_NONE_EXISTING']);
                    $this->_objTemplate->parse('news_no_comment');
                }

                $this->_objTemplate->hideBlock('news_comment_list');
                $this->_objTemplate->parse('news_comments');

                return $this->_objTemplate->get();
            }

            $i = 0;
            while (!$objResult->EOF) {
                self::parseUserAccountData($this->_objTemplate, $objResult->fields['userid'], $objResult->fields['poster_name'], 'news_comments_poster');
                
                $commentTitle = $objResult->fields['title'];
                
                $newsUrl  = \Cx\Core\Routing\Url::fromModuleAndCmd('news', $this->findCmdById('details', $objResult->fields['catid']), FRONTEND_LANG_ID, array('newsid' => $objResult->fields['id']));
                $newsLink = self::parseLink($newsUrl, $commentTitle, contrexx_raw2xhtml($commentTitle));
                
                $this->_objTemplate->setVariable(array(
                   'NEWS_COMMENTS_CSS'          => 'row'.($i % 2 + 1),
                   'NEWS_COMMENTS_TITLE'        => contrexx_raw2xhtml($commentTitle),
                   'NEWS_COMMENTS_MESSAGE'      => nl2br(contrexx_raw2xhtml($objResult->fields['text'])),
                   'NEWS_COMMENTS_LONG_DATE'    => date(ASCMS_DATE_FORMAT, $objResult->fields['date']),
                   'NEWS_COMMENTS_DATE'         => date(ASCMS_DATE_FORMAT_DATE, $objResult->fields['date']),
                   'NEWS_COMMENTS_TIME'         => date(ASCMS_DATE_FORMAT_TIME, $objResult->fields['date']),
                   'NEWS_COMMENT_LINK'          => $newsLink,
                   'NEWS_COMMENT_URL'           => $newsUrl
                ));

                $this->_objTemplate->parse('news_comment');
                $i++;
                $objResult->MoveNext();
            }

            $this->_objTemplate->parse('news_comment_list');
            $this->_objTemplate->hideBlock('news_no_comment');
        }
         
        return $this->_objTemplate->get();
    }
}
