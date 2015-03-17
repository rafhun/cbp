<?php
/**
 * This customizing removes the FrontendEditing for the page title
 * Since this is so poorly programmed by Comvation that automatic
 * paragraph elements are put around the title when FE is activated
 * the functionality has to be removed completely.
 *
 * The solution would be to load the editor around the h1 tags not just
 * inside of them, should not be too difficult.
 */



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
 * Class ComponentController
 *
 * @copyright   CONTREXX CMS - Comvation AG Thun
 * @author      Ueli Kramer <ueli.kramer@comvation.com>
 * @package     contrexx
 * @subpackage  coremodule_frontendediting
 * @version     1.0.0
 */

namespace Cx\Core_Modules\FrontendEditing\Controller;

/**
 * Class ComponentController
 *
 * The main controller for the frontend editing
 *
 * @copyright   CONTREXX CMS - Comvation AG Thun
 * @author      Ueli Kramer <ueli.kramer@comvation.com>
 * @package     contrexx
 * @subpackage  coremodule_frontendediting
 * @version     1.0.0
 */
class ComponentController extends \Cx\Core\Core\Model\Entity\SystemComponentController
{

    /**
     * Checks whether the frontend editing is active or not
     *
     * The frontend editing is deactivated for application pages except the home page
     *
     * @return bool
     */
    public function frontendEditingIsActive()
    {
        global $_CONFIG;

        // check frontend editing status in settings and don't show frontend editing on mobile phone
        if ($_CONFIG['frontendEditingStatus'] != 'on') {
            return false;
        }

        // get current request`s parameters
        $requestParams = $this->cx->getRequest()->getParamArray();

        // check whether the contrexx is in frontend mode, a content page exists and it is no pagePreview
        if (
            $this->cx->getMode() != \Cx\Core\Core\Controller\Cx::MODE_FRONTEND ||
            !$this->cx->getPage() ||
            isset($requestParams['pagePreview'])
        ) {
            return false;
        }

        // check permission
        // if the user don't have permission to edit pages or edit blocks,
        // disable the frontend editing
        if ($this->userHasPermissionToEditPage() ||
            $this->userHasPermissionToEditBlocks()
        ) {
            return true;
        }
        return false;
    }
    
    /**
     * Check the permission for editing pages
     * 
     * @return boolean TRUE if the user has permission to edit pages
     */
    protected function userHasPermissionToEditPage() {
        return $this->cx->getUser()->objUser->getAdminStatus()  ||
               (
                   \Permission::checkAccess(6, 'static', true) &&
                   \Permission::checkAccess(35, 'static', true) &&
                   (
                        !$this->cx->getPage()->isBackendProtected() ||
                        \Permission::checkAccess($this->cx->getPage()->getId(), 'page_backend', true)
                   )
               );
    }
    
    /**
     * Check the permission to edit blocks
     * 
     * @return boolean TRUE if the user has permission to edit blocks
     */
    protected function userHasPermissionToEditBlocks() {
        return $this->cx->getUser()->objUser->getAdminStatus() ||
               \Permission::checkAccess(76, 'static', true);
    }
    
    /**
     * Make the block editable, add the necessary html containers
     * for the frontend editing
     * 
     * @param integer $id the id of the block
     * @param string $output the html output of the block
     */
    public function prepareBlock($id, &$output) {
        if (!$this->frontendEditingIsActive() ||
            !$this->userHasPermissionToEditBlocks()) {
            return;
        }
        $output = '<div class="fe_block" id="fe_block_' . $id . '" data-id="' . $id . '" contenteditable="false">' . $output . '</div>';
    }

    /**
     * Add the necessary divs for the inline editing around the content and around the title
     *
     * @param \Cx\Core\ContentManager\Model\Entity\Page $page
     */
    public function preContentLoad(\Cx\Core\ContentManager\Model\Entity\Page $page)
    {
        // Is frontend editing active?
        if (!$this->frontendEditingIsActive() ||
            !$this->userHasPermissionToEditPage()) {
            return;
        }

        $componentTemplate = new \Cx\Core\Html\Sigma(ASCMS_CORE_MODULE_PATH . '/' . $this->getName() . '/View/Template');
        $componentTemplate->setErrorHandling(PEAR_ERROR_DIE);

        // add div around content
        // not used at the moment, because we have no proper way to "not parse" blocks in content and
        // it should only print a div around the content without parsing the content at this time
//        $componentTemplate->loadTemplateFile('ContentDiv.html');
//        $componentTemplate->setVariable('CONTENT', $page->getContent());
//        $page->setContent($componentTemplate->get());
        $page->setContent('<div id="fe_content">' . $page->getContent() . '</div>');

        // add div around the title
        /*$componentTemplate->loadTemplateFile('TitleDiv.html');
        $componentTemplate->setVariable('TITLE', $page->getContentTitle());
        $page->setContentTitle($componentTemplate->get());*/
    }

    /**
     * When the frontend editing is active for this page init the frontend editing
     *
     * @param \Cx\Core\Html\Sigma $template
     */
    public function preFinalize(\Cx\Core\Html\Sigma $template)
    {
        // Is frontend editing active?
        if (!$this->frontendEditingIsActive()) {
            return;
        }

        $frontendEditing = new \Cx\Core_Modules\FrontendEditing\Controller\FrontendController($this, $this->cx);
        $frontendEditing->initFrontendEditing($this);
    }
}
