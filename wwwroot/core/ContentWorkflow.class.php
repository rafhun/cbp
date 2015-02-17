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
 * Content Workflow
 * @copyright   CONTREXX CMS - COMVATION AG
 * @version     1.0.0
 * @package     contrexx
 * @subpackage  core
 * @todo        Edit PHP DocBlocks!
 */

use Doctrine\Common\Util\Debug as DoctrineDebug;

/**
 * ContentWorkflowException
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  core
 */
class ContentWorkflowException extends ModuleException {}

/**
 * Content Workflow
 *
 * Class for managing the content history
 * @copyright   CONTREXX CMS - COMVATION AG
 * @access      public
 * @version     1.0.0
 * @package     contrexx
 * @subpackage  core
 * @todo        Edit PHP DocBlocks!
 */
class ContentWorkflow extends Module {
    private $strErrMessage = array();
    private $strPageTitle = '';
    private $strOkMessage = '';
    private $pageId = 0;
    private $strCmd = '';
    private $intPos = 0;
    
    //doctrine entity manager
    protected $em = null;
    //template object
    protected $tpl = null;
    //the mysql connection
    protected $db = null;
    //the init object
    protected $init = null;
    
    protected $nodeRepo = null;
    protected $pageRepo = null;
    protected $logRepo  = null;
    
    /**
    * Constructor
    *
    * @param     ADONewConnection
    * @param     \Cx\Core\Html\Sigma
    * @param     string    $act
    * @param     object    $init
    * @global    array     Configuration
    */
    function __construct($act, $template, $db, $init) {
        global $_CONFIG;
        
        parent::__construct($act, $template);
        
        $this->pageId     = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $this->cmd        = $act;
        $this->defaultAct = 'showHistory';
        
        switch ($this->act) {
            case 'new':
            case 'updated':
            case 'unvalidated':
                $this->act = 'showHistory';
                break;
            case 'deleted':
                $this->act = 'showHistoryDeleted';
                break;
        }
        
        $this->em = \Env::em();
        $this->tpl = $template;
        $this->db = $db;
        $this->nodeRepo = $this->em->getRepository('Cx\Core\ContentManager\Model\Entity\Node');
        $this->pageRepo = $this->em->getRepository('Cx\Core\ContentManager\Model\Entity\Page');
        $this->logRepo  = $this->em->getRepository('Cx\Core\ContentManager\Model\Entity\LogEntry');
        
        if (isset($_GET['pos'])) {
            $this->intPos = intval($_GET['pos']);
        }
        
        $this->tpl->setVariable(array(
            'CONTENT_TITLE'             => $this->strPageTitle,
            'CONTENT_OK_MESSAGE'        => $this->strOkMessage,
            'CONTENT_STATUS_MESSAGE'    => implode("<br />\n", $this->strErrMessage)
        ));
        
        $this->setNavigation();
    }
    
    /**
     * Sets the content workflow navigation
     * 
     * @global    \Cx\Core\Html\Sigma
     * @global    array    Core language
     */
    protected function setNavigation() {
        global $_CORELANG;
        
        $this->tpl->setVariable(
            'CONTENT_NAVIGATION',
            '<a href="index.php?cmd=workflow&amp;act=new" class="'.($this->cmd == 'new' || $this->cmd == '' ? 'active' : '').'">'.$_CORELANG['TXT_NEW_PAGES'].'</a>
             <a href="index.php?cmd=workflow&amp;act=updated" class="'.($this->cmd == 'updated' ? 'active' : '').'">'.$_CORELANG['TXT_UPDATED_PAGES'].'</a>
             <a href="index.php?cmd=workflow&amp;act=deleted" class="'.($this->cmd == 'deleted' ? 'active' : '').'">'.$_CORELANG['TXT_DELETED_PAGES'].'</a>
             <a href="index.php?cmd=workflow&amp;act=unvalidated" class="'.($this->cmd == 'unvalidated' ? 'active' : '').'">'.$_CORELANG['TXT_WORKFLOW_VALIDATE'].'</a>'
             //<a href="index.php?cmd=workflow&amp;act=showClean" class="'.($this->act == 'showClean' ? 'active' : '').'">'.$_CORELANG['TXT_WORKFLOW_CLEAN_TITLE'].'</a>
        );
    }
    
    /**
    * Show logfile-entries (new, updated or deleted)
    *
    * @global     \Cx\Core\Html\Sigma
    * @global     array        Core language
    * @global     array        Configuration
    */
    protected function showHistory() {
        global $_CORELANG, $_CONFIG;
        
        \Permission::checkAccess(75, 'static');

        $this->tpl->addBlockfile('ADMIN_CONTENT', 'content_history', 'content_history.html');
        
        switch ($this->cmd) {
            case 'updated':
                $this->strPageTitle = $_CORELANG['TXT_UPDATED_PAGES'];
                $strPagingAct       = 'updated';
                break;
            case 'unvalidated':
                $this->strPageTitle = $_CORELANG['TXT_WORKFLOW_VALIDATE'];
                $strPagingAct       = 'unvalidated';
                break;
            default:
                $this->strPageTitle = $_CORELANG['TXT_NEW_PAGES'];
                $strPagingAct       = 'new';
        }
        
        $this->setTextVariables();
        
        // Gets the quantity of log entries
        $countLogEntries = $this->logRepo->countLogEntries($this->cmd);
        
        // Paging
        $strPaging = getPaging($countLogEntries, $this->intPos, '&cmd=workflow&act='.$strPagingAct, '', true);
        $this->tpl->setVariable('HISTORY_PAGING', $strPaging);
        
        // Gets the log entries
        $logs  = $this->logRepo->getLogs($this->cmd, $this->intPos, $_CONFIG['corePagingLimit']);
        
        foreach ($logs as $log) {
            if ($log['action'] == 'remove') {
                $page = new \Cx\Core\ContentManager\Model\Entity\Page();
                $page->setId($log['objectId']);
                $this->logRepo->revert($page, $log['version'] - 1);
            } else {
                $page = $this->pageRepo->findOneById($log['objectId']);
            }
            $data[$page->getId()] = array(
                'action'  => $log['action'],
                'version' => $log['version'],
                'updated' => $log['loggedAt'],
                'user'    => json_decode($log['username']),
                'page'    => $page,
            );
        }
        
        if (!empty($data)) {
            $intRowCount = 0;
            
            foreach ($data as $pageId => $data) {
                $act      = $data['action'];
                $history  = $data['version'] - 1;
                $updated  = $data['updated'];
                $username = $data['user']->{'name'};
                $page     = $data['page'];
                $type     = $this->pageRepo->getTypeByPage($page);
                $prefix   = '';
                
                // Only for new, updated and unvalidated pages
                if ($this->cmd  != 'deleted') {
                    $langDir     = \FWLanguage::getLanguageCodeById($page->getLang());
                    $path        = $langDir.'/'.$page->getPath();
                    $historyLink = ASCMS_PATH_OFFSET.'/'.$path.'?history='.$history;
                }

                switch ($this->cmd) {
                    case 'deleted':
                        $strIcon = '<a href="javascript:restoreDeleted(\''.$pageId.'\');"><img src="images/icons/import.gif" alt="'.$_CORELANG['TXT_DELETED_RESTORE'].'" title="'.$_CORELANG['TXT_DELETED_RESTORE'].'" border="0" align="middle" /></a>';
                        break;
                    case 'unvalidated':
                        $strIcon = '<a href="'.CONTREXX_DIRECTORY_INDEX.'?cmd=content&amp;page='.$pageId.'&amp;tab=content" target="_blank"><img src="images/icons/details.gif" alt="'.$_CORELANG['TXT_DETAILS'].'" title="'.$_CORELANG['TXT_DETAILS'].'" border="0" /></a>';
                        
                        switch ($act) {
                            case 'create':
                                $prefix = $_CORELANG['TXT_VALIDATE_PREFIX_NEW'].'&nbsp;';
                                break;
                            case 'remove':
                                $prefix = $_CORELANG['TXT_VALIDATE_PREFIX_DELETE'].'&nbsp;';
                                break;
                            default: // update
                                $prefix = $_CORELANG['TXT_VALIDATE_PREFIX_UPDATE'].'&nbsp;';
                        }

                        break;
                    default: // new
                        $strIcon  = '<a href="../'.\FWLanguage::getLanguageCodeById($page->getLang()).$page->getPath().'" target="_blank"><img src="../core/ContentManager/View/Media/Preview.png" alt="'.$_CORELANG['TXT_WORKFLOW_PAGE_PREVIEW'].'" title="'.$_CORELANG['TXT_WORKFLOW_PAGE_PREVIEW'].'" border="0" /></a>&nbsp;';
                        $strIcon .= '<a href="'.CONTREXX_DIRECTORY_INDEX.'?cmd=content&amp;page='.$pageId.'&amp;tab=content" target="_blank"><img src="images/icons/edit.gif" alt="'.$_CORELANG['TXT_EDIT_PAGE'].'" title="'.$_CORELANG['TXT_EDIT_PAGE'].'" border="0" /></a>';
                }
                
                $this->tpl->setVariable(array(
                    'HISTORY_ROWCLASS'              => $intRowCount % 2 == 0 ? 'row0' : 'row1',
                    'HISTORY_IMGDETAILS'            => $strIcon,
                    'HISTORY_RID'                   => $intRowCount,
                    'HISTORY_DATE'                  => $updated,
                    'HISTORY_LANGUAGE'              => \FWLanguage::getLanguageCodeById($page->getLang()),
                    'HISTORY_TYPE'                  => $type,
                    'HISTORY_USER'                  => $username,
                    'HISTORY_PREFIX'                => $prefix,
                    'HISTORY_TITLE'                 => $page->getTitle(),
                    'HISTORY_STARTDATE'             => $page->getStart() ? $page->getStart()->format('d.m.Y H:i') : '',
                    'HISTORY_ENDDATE'               => $page->getEnd() ? $page->getEnd()->format('d.m.Y H:i') : '',
                    'HISTORY_SLUG'                  => $page->getSlug(),
                    'HISTORY_PAGE_PATH'             => $page->getPath(),
                ));

                $this->tpl->parse('page_row');
                $intRowCount++;
            }
        } else {
            $this->tpl->hideBlock('page_row');
        }
    }

    protected function showHistoryDeleted() {
        global $_CORELANG, $_CONFIG;
        
        \Permission::checkAccess(75, 'static');
        
        $this->tpl->addBlockfile('ADMIN_CONTENT', 'content_history', 'content_history_deleted.html');
        $this->strPageTitle = $_CORELANG['TXT_DELETED_PAGES'];
        $this->setTextVariables($_CORELANG['TXT_DELETED_PAGES']);
        
        // Gets the quantity of log entries
        $countLogEntries = $this->logRepo->countLogEntries('deleted');
        
        // Paging
        $strPaging = getPaging($countLogEntries, $this->intPos, '&cmd=workflow&act=deleted', '', true);
        $this->tpl->setVariable('HISTORY_PAGING', $strPaging);
        
        // Gets the log entries
        $logsByNodeId  = $this->logRepo->getLogs('deleted', $this->intPos, $_CONFIG['corePagingLimit']);
        $dataByNodeId  = array();
        
        foreach ($logsByNodeId as $nodeId => $logsByLang) {
            $dataByLang = array();
            
            foreach ($logsByLang as $lang => $log) {
                $page = new \Cx\Core\ContentManager\Model\Entity\Page();
                $page->setId($log['objectId']);
                $this->logRepo->revert($page, $log['version'] - 1);
                
                $dataByLang[$lang] = array(
                    'version' => $log['version'],
                    'updated' => $log['loggedAt'],
                    'user'    => json_decode($log['username']),
                    'page'    => $page,
                );
            }
            
            $dataByNodeId[$nodeId] = $dataByLang;
        }
        
        if (!empty($dataByNodeId)) {
            $intRowCount = 0;
            foreach ($dataByNodeId as $dataByLang) {
                if (!empty($dataByLang)) {
                    ksort($dataByLang);
                    $pageId   = 0;
                    $updated  = '';
                    $lang     = '';
                    $type     = '';
                    $username = '';
                    $title    = '';
                    $period   = '';
                    $slug     = '';
                    
                    foreach ($dataByLang as $data) {
                        $history = $data['version'] - 1;
                        $page    = $data['page'];
                        $pageId  = $page->getId();
                        
                        $updated   = $data['updated'];
                        $lang     .= \FWLanguage::getLanguageCodeById($page->getLang()).'<br />';
                        $type     .= $this->pageRepo->getTypeByPage($page).'<br />';
                        $username .= $data['user']->{'name'}.'<br />';
                        $title    .= $page->getTitle().'<br />';
                        $start     = $page->getStart() ? $page->getStart()->format('d.m.Y H:i') : '';
                        $end       = $page->getEnd() ? $page->getEnd()->format('d.m.Y H:i') : '';
                        $period   .= $start.' - '.$end.'<br />';
                        $slug     .= $page->getSlug().'<br />';
                    }
                    
                    $data = array_shift($dataByLang);
                    $linkPageId = $data['page']->getId();
                    
                    $this->tpl->setVariable(array(
                        'HISTORY_ROW'                   => $intRowCount % 2 == 0 ? 'row1' : 'row2',
                        'HISTORY_IMGDETAILS'            => '<a href="javascript:restoreDeleted(\''.$linkPageId.'\');"><img src="images/icons/import.gif" alt="'.$_CORELANG['TXT_DELETED_RESTORE'].'" title="'.$_CORELANG['TXT_DELETED_RESTORE'].'" border="0" align="middle" /></a>',
                        'HISTORY_RID'                   => $intRowCount,
                        'HISTORY_DATE'                  => $updated,
                        'HISTORY_LANGUAGE'              => $lang,
                        'HISTORY_TYPE'                  => $type,
                        'HISTORY_USER'                  => $username,
                        'HISTORY_TITLE'                 => $title,
                        'HISTORY_PUBLICATION_PERIOD'    => $period,
                        'HISTORY_SLUG'                  => $slug,
                    ));
                    
                    $this->tpl->parse('page_row');
                    $intRowCount++;
                }
            }
        }
    }

    private function setTextVariables() {
        global $_CORELANG;
        
        $this->tpl->setVariable(array(
            'TXT_TITLE'                 => $this->strPageTitle,
            'TXT_DATE'                  => $_CORELANG['TXT_DATE'],
            'TXT_NAVIGATION_TITLE'      => $_CORELANG['TXT_NAVIGATION_TITLE'],
            'TXT_CONTENT_TITLE'         => $_CORELANG['TXT_PAGETITLE'],
            'TXT_LANGUAGE'              => $_CORELANG['TXT_LANGUAGE'],
            'TXT_PUBLICATION_PERIOD'    => $_CORELANG['TXT_PUBLICATION_PERIOD'],
            'TXT_TYPE'                  => $_CORELANG['TXT_TYPE'],
            'TXT_ACCESS_PROTECTION'     => $_CORELANG['TXT_ACCESS_PROTECTION'],
            'TXT_SLUG'                  => $_CORELANG['TXT_CORE_CM_SLUG'],
            'TXT_USER'                  => $_CORELANG['TXT_USER'],
            'TXT_FUNCTIONS'             => $_CORELANG['TXT_FUNCTIONS'],
            'TXT_DELETED_RESTORE_JS'    => $_CORELANG['TXT_DELETED_RESTORE_JS'],
        ));
    }
    
    /**
     *  Restores a page from histroy.
     */
    protected function restoreHistory() {
        \Permission::checkAccess(77, 'static');
        
        // Create node
        $node = new \Cx\Core\ContentManager\Model\Entity\Node();
        $node->setParent($this->nodeRepo->getRoot());
        $this->em->persist($node);
        $this->em->flush();
        
        $arrData = $this->revertPage($this->pageId);
        $currentPage    = $arrData['page'];
        $logs           = $arrData['logs'];
        $nodeIdShadowed = $currentPage->getNodeIdShadowed();
        
        $this->restorePage($node, $currentPage, $logs);
        
        $logsRemove = $this->logRepo->getLogsByAction('remove');
        foreach ($logsRemove as $logRemove) {
            $arrData = $this->revertPage($logRemove->getObjectId());
            $page    = $arrData['page'];
            $logs    = $arrData['logs'];
            if ($page->getNodeIdShadowed() == $nodeIdShadowed) {
                $this->restorePage($node, $page, $logs);
            }
        }
        
        $this->redirectPage($currentPage->getId());
    }
    
    private function revertPage($pageId) {
        $page = new \Cx\Core\ContentManager\Model\Entity\Page();
        $page->setId($pageId);
        $logs = $this->logRepo->getLogEntries($page);
        $this->logRepo->revert($page, $logs[1]->getVersion());
        $page->setId(0);
        
        return array(
            'page' => $page,
            'logs' => $logs,
        );
    }
    
    private function restorePage($node, $page, $logs) {
        // Save the restored page
        $page->setNode($node);
        $page->setNodeIdShadowed($node->getId());
        $this->em->persist($page);
        $this->em->flush();
        $pageId = $page->getId();
        
        // Remove the new 'create' log
        $newLogs = $this->logRepo->findByObjectId($pageId);
        foreach ($newLogs as $newLog) {
            $this->em->remove($newLog);
        }
        $this->em->flush();
        
        // Delete the 'remove' log
        $this->em->remove($logs[0]);
        unset($logs[0]);
        
        // Set the new object id in the old logs
        foreach ($logs as $log) {
            $log->setObjectId($pageId);
            $logData = $log->getData();
            $logData['nodeIdShadowed'] = $node->getId();
            $log->setData($logData);
            $this->em->persist($log);
        }
        $this->em->flush();
    }
    
    /**
     * Redirect to content manager (open site)
     *
     * @param  integer  The page with this id will be shown in content manager.
     */
    protected function redirectPage($intPageId) {
        \CSRF::header('location: index.php?cmd=content&page='.$intPageId.'&tab=content');
        exit;
    }

}
?>
