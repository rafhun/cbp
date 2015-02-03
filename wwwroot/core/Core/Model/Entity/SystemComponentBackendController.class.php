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
 * Backend controller to create a default backend view.
 *
 * Create a subclass of this in order to create a normal backend view
 *
 * @copyright   Comvation AG
 * @author      Michael Ritter <michael.ritter@comvation.com>
 * @package     contrexx
 * @subpackage  core_core
 * @version     3.1.0
 */

namespace Cx\Core\Core\Model\Entity;

/**
 * Backend controller to create a default backend view.
 *
 * Create a subclass of this in order to create a normal backend view
 *
 * @copyright   Comvation AG
 * @author      Michael Ritter <michael.ritter@comvation.com>
 * @package     contrexx
 * @subpackage  core_core
 * @version     3.1.0
 */
abstract class SystemComponentBackendController extends Controller {
    
    /**
     * Returns a list of available commands (?act=XY)
     * @return array List of acts
     */
    public abstract function getCommands();
    
    /**
     * This is called by the default ComponentController and does all the repeating work
     * 
     * This loads a template named after current $act and calls parsePage($actTemplate)
     * @todo $this->cx->getTemplate()->setVariable() should not be called here but in Cx class
     * @global array $_ARRAYLANG Language data
     * @param \Cx\Core\ContentManager\Model\Entity\Page $page Resolved page
     */
    public function getPage(\Cx\Core\ContentManager\Model\Entity\Page $page) {
        global $_ARRAYLANG, $subMenuTitle;
        $subMenuTitle = $_ARRAYLANG['TXT_' . strtoupper($this->getType()) . '_' . strtoupper($this->getName())];
        
        $cmd = array('');
        if (isset($_GET['act'])) {
            $cmd = explode('/', contrexx_input2raw($_GET['act']));
        }
        
        $actTemplate = new \Cx\Core\Html\Sigma($this->getDirectory() . '/View/Template');
        $filename = $cmd[0] . '.html';
        $testFilename = $cmd[0];
        if (!\Env::get('ClassLoader')->getFilePath($actTemplate->getRoot() . '/' . $filename)) {
            $filename = 'Default.html';
            $testFilename = 'Default';
        }
        foreach ($cmd as $index=>$name) {
            if ($index == 0) {
                continue;
            }
            
            $testFilename .= $name;
            if (\Env::get('ClassLoader')->getFilePath($actTemplate->getRoot() . '/' . $testFilename . '.html')) {
                $filename = $testFilename . '.html';
            } else {
                break;
            }
        }
        $actTemplate->loadTemplateFile($filename);
        
        // todo: Messages
        $this->parsePage($actTemplate, $cmd);
        
        // set tabs
        $navigation = new \Cx\Core\Html\Sigma(ASCMS_CORE_PATH . '/Core/View/Template');
        $navigation->loadTemplateFile('Navigation.html');
        $commands = array_merge(array(''), $this->getCommands());
        foreach ($commands as $key=>$command) {
            $subnav = array();
            if (is_array($command)) {
                $subnav = array_merge(array(''), $command);
                $command = $key;
            }
            
            if ($key !== '') {
                if ($cmd[0] == $command) {
                    $navigation->touchBlock('tab_active');
                } else {
                    $navigation->hideBlock('tab_active');
                }
                $act = '&amp;act=' . $command;
                $txt = $command;
                if (empty($command)) {
                    $act = '';
                    $txt = 'DEFAULT';
                }
                $actTxtKey = 'TXT_' . strtoupper($this->getType()) . '_' . strtoupper($this->getName() . '_ACT_' . $txt);
                $actTitle = isset($_ARRAYLANG[$actTxtKey]) ? $_ARRAYLANG[$actTxtKey] : $actTxtKey;
                $navigation->setVariable(array(
                    'HREF' => 'index.php?cmd=' . $this->getName() . $act,
                    'TITLE' => $actTitle,
                ));
                $navigation->parse('tab_entry');
            }
            
            // subnav
            if ($cmd[0] == $command && count($subnav)) {
                $first = true;
                foreach ($subnav as $subcommand) {
                    if ((!isset($cmd[1]) && $first) || ((isset($cmd[1]) ? $cmd[1] : '') == $subcommand)) {
                        $navigation->touchBlock('subnav_active');
                    } else {
                        $navigation->hideBlock('subnav_active');
                    }
                    $act = '&amp;act=' . $cmd[0] . '/' . $subcommand;
                    $txt = (empty($cmd[0]) ? 'DEFAULT' : $cmd[0]) . '_';
                    if (empty($subcommand)) {
                        $act = '&amp;act=' . $cmd[0] . '/';
                        $txt .= 'DEFAULT';
                    } else {
                        $txt .= strtoupper($subcommand);
                    }
                    $actTxtKey = 'TXT_' . strtoupper($this->getType()) . '_' . strtoupper($this->getName() . '_ACT_' . $txt);
                    $actTitle = isset($_ARRAYLANG[$actTxtKey]) ? $_ARRAYLANG[$actTxtKey] : $actTxtKey;
                    $navigation->setVariable(array(
                        'HREF' => 'index.php?cmd=' . $this->getName() . $act,
                        'TITLE' => $actTitle,
                    ));
                    $navigation->parse('subnav_entry');
                    $first = false;
                }
            }
        }
        $txt = $cmd[0];
        if (empty($txt)) {
            $txt = 'DEFAULT';
        }
        
        // default css and js
        if (file_exists($this->cx->getClassLoader()->getFilePath($this->getDirectory() . '/View/Style/Backend.css'))) {
            \JS::registerCSS(substr($this->getDirectory(false, true) . '/View/Style/Backend.css', 1));
        }
        if (file_exists($this->cx->getClassLoader()->getFilePath($this->getDirectory() . '/View/Script/Backend.js'))) {
            \JS::registerJS(substr($this->getDirectory(false, true) . '/View/Script/Backend.js', 1));
        }
        
        // finish
        $actTemplate->setGlobalVariable($_ARRAYLANG);
        \CSRF::add_placeholder($actTemplate);
        $page->setContent($actTemplate->get());
        $cachedRoot = $this->cx->getTemplate()->getRoot();
        $this->cx->getTemplate()->setRoot(ASCMS_CORE_PATH . '/Core/View/Template');
        $this->cx->getTemplate()->addBlockfile('CONTENT_OUTPUT', 'content_master', 'ContentMaster.html');
        $this->cx->getTemplate()->setRoot($cachedRoot);
        $this->cx->getTemplate()->setVariable(array(
            'CONTENT_NAVIGATION' => $navigation->get(),
            'ADMIN_CONTENT' => $page->getContent(),
            'CONTENT_TITLE' => $_ARRAYLANG['TXT_' . strtoupper($this->getType()) . '_' . strtoupper($this->getName() . '_ACT_' . $txt)],
        ));
    }
    
    /**
     * Use this to parse your backend page
     * 
     * You will get the template located in /View/Template/{CMD}.html
     * You can access Cx class using $this->cx
     * To show messages, use \Message class
     * @param \Cx\Core\Html\Sigma $template Template for current CMD
     * @param array $cmd CMD separated by slashes
     */
    public abstract function parsePage(\Cx\Core\Html\Sigma $template, array $cmd);
}
