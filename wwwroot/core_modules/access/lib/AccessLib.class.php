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
 * User Management
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Thomas Daeppen <thomas.daeppen@comvation.com>
 * @version     2.0.0
 * @package     contrexx
 * @subpackage  coremodule_access
 */


/**
 * Common functions used by the front- and backend
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Thomas Daeppen <thomas.daeppen@comvation.com>
 * @version     2.0.0
 * @package     contrexx
 * @subpackage  coremodule_access
 * @uses        /lib/FRAMEWORK/Image.class.php
 */
class AccessLib
{
    /**
     * @access private
     * @var     \Cx\Core\Html\Sigma
     * @todo This is probably not meant to be public, but protected instead
     */
    public $_objTpl;

    /**
     * @access private
     * @var array
     */
    private $arrAttachedJSFunctions = array();

    /**
     * User FRAMEWORK Object
     *
     * @access private
     * @var object
     */
    protected $objUserFW;

    /**
     * Sign to mark mandatory fields as required
     *
     * @var string
     */
    private $_mandatorySign = '<strong style="padding: 0px 2px 0px 2px;color:#f00;">*</strong>';

    /**
     * @access private
     */
    private $attributeNamePrefix = 'access_profile_attribute';
    private $modulePrefix = 'ACCESS_';

    private $arrAttributeTypeTemplates;

    protected $defaultProfileThumbnailScaleColor = '#FFFFFF';

    private $arrAccountAttributes;


    /**
     * This library can be used to parse/generate the HTML code of a user's
     * profile attributes from within the whole framework. To do so, follow
     * the following steps:
     * 1. Initialize an object from this class and pass the target
     *    \Cx\Core\Html\Sigma object as a paramater to it.
     * 2. Call {@link AccessLib::setModulePrefix()} to set the \Cx\Core\Html\Sigma's
     *    placeholders prefix. Where the passed argument would be like: ACCESS_
     * 3. Call {@link AccessLib::setAttributeNamePrefix()} to set the
     *    \Cx\Core\Html\Sigma's block prefix used in the user's profile attribute
     *    template blocks. Where the passed argument would be like: access_profile_attribute
     * 4. Finaly, call {@link AccessLib::parseAttribute()} to parse a user account's profile attribute
     *    template block or to return the generated HTML code of a user account's profile attribute.
     *
     * Example:
     *    $objAccessLib = new AccessLib($objTemplate);
     *    $objAccessLib->setModulePrefix('shop');
     *    $objAccessLib->setAttributeNamePrefix('shop_customer_profile_attribute');
     *    $objAccessLib->parseAttribute($objUser, 'firstname', 0, false, false, false, false, false);
     *
     * @param   \Cx\Core\Html\Sigma \Cx\Core\Html\Sigma object in case this object's use is intended
     *                              to parse a user profile's attribute from within a different
     *                              place than the access module.
     * @see AccessLib::setModulePrefix()
     * @see AccessLib::setAttributeNamePrefix()
     * @see AccessLib::parseAttribute()
     */
    public function __construct($objTemplate = null)
    {
        global $_ARRAYLANG, $objInit;

        if (isset($objTemplate)) {
            // class has been instantiated from a foreign module
            $this->_objTpl = $objTemplate;
            $_ARRAYLANG = array_merge($_ARRAYLANG, $objInit->loadLanguageData('access'));
        }

        $this->loadAttributeTypeTemplates();
    }


    /**
     * When using this library from within a different place (not access module),
     * use this method to specify the template block prefix to be used when parsing
     * a user's profile attribute.
     * For instance when setting the prefix to 'shop_customer_profile_attribute',
     * then the method {@link AccessLib::parseAttribute()) will try to parse the
     * \Cx\Core\Html\Sigma template block shop_customer_profile_attribute_firstname
     * in the case of the profile attribute firstname.
     * Defaults to 'access_profile_attribute'
     *
     * @param string    \Cx\Core\Html\Sigma template block prefix to be used
     * @see AccessLib::parseAttribute()
     */
    public function setAttributeNamePrefix($prefix)
    {
        $this->attributeNamePrefix = $prefix;
    }


    /**
     * When using this library from within a different place (not access module),
     * use this method to specify the template placeholder prefix to be used when
     * parsing a user's profile attribute.
     * For instance when setting the prefix to 'SHOP_', then the method
     * {@link AccessLib::parseAttribute()) will parse the \Cx\Core\Html\Sigma
     * variable SHOP_PROFILE_ATTRIBUTE_FIRSTNAME in the case of the profile
     * attribute firstname.
     * Defaults to 'ACCESS_'
     *
     * @param string    \Cx\Core\Html\Sigma variable prefix to be used
     * @see AccessLib::parseAttribute()
     */
    public function setModulePrefix($prefix)
    {
        $this->modulePrefix = $prefix;
    }


    /**
     * Load the html code template of the different attribute types
     *
     * @global array
     */
    private function loadAttributeTypeTemplates()
    {
        global $_CORELANG;

        JS::activate('jqueryui');
        JS::registerCode("
            cx.ready(function() {
                cx.jQuery('.access_date').datepicker({dateFormat: 'dd.mm.yy'});
            });
        ");
        $this->arrAttributeTypeTemplates = array(
            'textarea'        => '<textarea name="[NAME]" rows="1" cols="1">[VALUE]</textarea>',
            'text'            => '<input type="text" name="[NAME]" value="[VALUE]" />',
            'password'        => '<input type="password" name="[NAME]" value="" autocomplete="off" />',
            'checkbox'        => '<input type="hidden" name="[NAME]" /><input type="checkbox" name="[NAME]" value="1" [CHECKED] />',
            'menu'            => '<select name="[NAME]"[STYLE]>[VALUE]</select>',
            'menu_option'     => '<option value="[VALUE]"[SELECTED][STYLE]>[VALUE_TXT]</option>',
            'url'             => '<input type="hidden" name="[NAME]" value="[VALUE]" /><em>[VALUE_TXT]</em> <a href="javascript:void(0);" onclick="elLink=null;elDiv=null;elInput=null;pntEl=this.previousSibling;while ((typeof(elInput)==\'undefined\'||typeof(elDiv)!=\'undefined\')&& pntEl!=null) {switch(pntEl.nodeName) {case\'INPUT\':elInput=pntEl;break;case\'EM\':elDiv=pntEl;if (elDiv.getElementsByTagName(\'a\').length>0) {elLink=elDiv.getElementsByTagName(\'a\')[0];}break;}pntEl=pntEl.previousSibling;}accessSetWebsite(elInput,elDiv,elLink)" title="'.$_CORELANG['TXT_ACCESS_CHANGE_WEBSITE'].'"><img align="middle" src="'.ASCMS_PATH_OFFSET.'/images/modules/access/edit.gif" width="16" height="16" border="0" alt="'.$_CORELANG['TXT_ACCESS_CHANGE_WEBSITE'].'" /></a>',
            'date'            => '<input type="text" name="[NAME]" class="access_date" value="[VALUE]" />',
        );
    }


    /**
     * This method has two purposes (see param $return):
     * 1. Parse the \Cx\Core\Html\Sigma template block of a specific profile attribute
     * 2. Generate the HTML code of a specific profile attribute and return it
     *
     * @param User      User object of whoem's profile attribute shall be parsed
     * @param integer   ID of the profile attribute to be parsed
     * @param integer   History version of the profile attribute to be parsed
     * @param boolean   If the profile attribute's value shall be modifyable (set to TRUE)
     *                  or not (set to FALSE)
     * @param boolean   If the profile attribute's \Cx\Core\Html\Sigma template block
     *                  shall be parsed (set to FALSE) or the HTML code of the profile
     *                  attribute shall be generated and returned instead (set to TRUE).
     * @param boolean   In case the profile attribute to be parsed is an other profile
     *                  attribute's child, set this to TRUE, otherwise to FALSE
     * @param boolean   In case the profile attribute to be parsed is located within an
     *                  other profile attribute of the type frame, set this to TRUE,
     *                  otherwise to FALSE
     * @param boolean   The method can use the magic block \Cx\Core\Html\Sigma template
     *                  block access_profile_attribute_list (set to TRUE), instead of using
     *                  the profile attribute specific block like for instance
     *                  access_profile_attribute_firstname (set to FALSE)
     * @param array     Pass additional, preparsed placeholders. The array must be an associated
     *                  array, where the key represents the \Cx\Core\Html\Sigma variable suffix
     *                  and the value the placeholder's value.
     *                  For instance: array('_CSS' => 'someSpecialCSSClass');
     */
    public function parseAttribute(
        $objUser, $attributeId, $historyId=0, $edit=false, $return=false,
        $isChild=false, $inFrame=false, $useMagicBlock=true,
        $arrAdditionalPlaceholders=null)
    {
        global $_CORELANG;

        $objAttribute = $objUser->objAttribute->getById($attributeId);
        $attributeName = $this->attributeNamePrefix.'['.$attributeId.']['.$historyId.']';
        $block = strtolower($this->attributeNamePrefix.'_'.$attributeId);
        $attributeIdUC = strtoupper($attributeId);
        $parentIdUC = strtoupper($objAttribute->getParent());

        if ($edit && $objAttribute->isProtected() && !Permission::checkAccess($objAttribute->getAccessId(), 'dynamic', true) && !$objAttribute->checkModifyPermission()) {
            $edit = false;
        }
        if ($return) {
            return $this->_getAtrributeCode($objUser, $attributeId, $historyId, $edit);
        }

        $arrPlaceholders = array(
            ''            => $this->_getAtrributeCode($objUser, $attributeId, $historyId, $edit),
            '_DESC'       => htmlentities($objAttribute->getName(), ENT_QUOTES, CONTREXX_CHARSET),
            '_NAME'       => $attributeName,
            '_ID'         => $attributeId,
            '_HISTORY_ID' => $historyId,
        );
        if (is_array($arrAdditionalPlaceholders)) {
            $arrPlaceholders = array_merge($arrPlaceholders, $arrAdditionalPlaceholders);
        }

        switch ($objAttribute->getType()) {
            case 'date':
                $value = $objUser->getProfileAttribute($attributeId, $historyId);
                $arrPlaceholders['_VALUE'] = $value !== false && $value !== '' ? htmlentities(date(ASCMS_DATE_FORMAT_DATE, intval($value)), ENT_QUOTES, CONTREXX_CHARSET) : '';
                $arrPlaceholders['_MONTH'] = $this->getDateMonthMenu($attributeName, date('m', intval($objUser->getProfileAttribute($attributeId, $historyId))));
                $arrPlaceholders['_DAY'] = $this->getDateDayMenu($attributeName, date('d', intval($objUser->getProfileAttribute($attributeId, $historyId))));
                $arrPlaceholders['_YEAR'] = $this->getDateYearMenu($attributeName, date('Y', intval($objUser->getProfileAttribute($attributeId, $historyId))));
                break;
            case 'text':
            case 'mail':
                $arrPlaceholders['_VALUE'] = $edit ? htmlentities($objUser->getProfileAttribute($attributeId, $historyId), ENT_QUOTES, CONTREXX_CHARSET) : html_entity_decode(nl2br($objUser->getProfileAttribute($attributeId, $historyId)), ENT_QUOTES, CONTREXX_CHARSET);
                break;
            case 'uri':
                $uri = $objUser->getProfileAttribute($attributeId, $historyId);
                if (empty($uri)) {
                    $arrPlaceholders['_VALUE'] = '';
                    /*if ($this->_objTpl->blockExists($block.'_no_link')) {
                        $this->_objTpl->setVariable('TXT_ACCESS_NO_SPECIFIED', $_CORELANG['TXT_ACCESS_NO_SPECIFIED']);
                        $this->_objTpl->touchBlock($block.'_no_link');
                    }*/
                    if ($this->_objTpl->blockExists($block.'_link')) {
                        $this->_objTpl->hideBlock($block.'_link');
                    }
                } else {
                    $arrPlaceholders['_VALUE'] = htmlentities($objUser->getProfileAttribute($attributeId, $historyId), ENT_QUOTES, CONTREXX_CHARSET);
                    if ($this->_objTpl->blockExists($block.'_link')) {
                        $this->_objTpl->setVariable(array(
                            'TXT_ACCESS_URL_OPEN_RISK_MSG' => $_CORELANG['TXT_ACCESS_URL_OPEN_RISK_MSG'],
                            'TXT_ACCESS_CONFIRM_OPEN_URL'  => $_CORELANG['TXT_ACCESS_CONFIRM_OPEN_URL'],
                            'TXT_ACCESS_VISIT_WEBSITE'     => $_CORELANG['TXT_ACCESS_VISIT_WEBSITE'],
                        ));
                        $this->_objTpl->touchBlock($block.'_link');
                    }
                    if ($this->_objTpl->blockExists($block.'_no_link')) {
                        $this->_objTpl->hideBlock($block.'_no_link');
                    }
                }
                break;
            case 'image':
                $arrSettings = User_Setting::getSettings();

                $image = $objUser->getProfileAttribute($objAttribute->getId(), $historyId);
                if (!$edit || file_exists(($attributeId == 'picture' ? ASCMS_ACCESS_PROFILE_IMG_PATH : ASCMS_ACCESS_PHOTO_IMG_PATH).'/'.$image)) {
                    $arrPlaceholders['_VALUE'] = htmlentities($objUser->getProfileAttribute($objAttribute->getId(), $historyId), ENT_QUOTES, CONTREXX_CHARSET);
                }
                $arrPlaceholders['_SRC'] = ($attributeId == 'picture' ?
                                                  ASCMS_ACCESS_PROFILE_IMG_WEB_PATH.'/'
                                                : ASCMS_ACCESS_PHOTO_IMG_WEB_PATH.'/')
                                            .(!empty($arrPlaceholders['_VALUE']) ?
                                                  $arrPlaceholders['_VALUE']
                                                : ($attributeId == 'picture' ?
                                                          User_Profile::$arrNoAvatar['src']
                                                        : User_Profile::$arrNoPicture['src']));
                if (empty($arrPlaceholders['_VALUE'])) {
                    $arrPlaceholders['_VALUE'] = $_CORELANG['TXT_ACCESS_NO_PICTURE'];
                }
                $arrPlaceholders['_THUMBNAIL'] = $this->getImageAttributeCode($objUser, $attributeName, $image, $attributeId, '', $historyId, $edit, true);
                $arrPlaceholders['_THUMBNAIL_SRC'] =
                    ImageManager::getThumbnailFilename($arrPlaceholders['_SRC']);
                $arrPlaceholders['_UPLOAD_NAME'] = $this->attributeNamePrefix.'_images['.$objAttribute->getId().']['.$historyId.']';
                $arrPlaceholders['_MAX_FILE_SIZE'] = FWSystem::getLiteralSizeFormat($arrSettings['max_'.($attributeId == 'picture' ? 'profile_' : '').'pic_size']['value']);
                $arrPlaceholders['_MAX_WIDTH'] = $arrSettings['max_'.($attributeId == 'picture' ? 'profile_' : '').'pic_width']['value'];
                $arrPlaceholders['_MAX_HEIGHT'] = $arrSettings['max_'.($attributeId == 'picture' ? 'profile_' : '').'pic_height']['value'];
//                if ($attributeId == 'picture') {
//                    $arrPlaceholders['_DESC'] = htmlentities($objUser->getUsername(), ENT_QUOTES, CONTREXX_CHARSET);
//                }
                break;
            case 'checkbox':
                $arrPlaceholders['_CHECKED'] = $objUser->getProfileAttribute($attributeId, $historyId) ? 'checked="checked"' : '';
                $arrPlaceholders['_VALUE'] = $objUser->getProfileAttribute($attributeId, $historyId);
                break;
            case 'menu':
                $arrPlaceholders['_VALUE'] = htmlentities($objUser->getProfileAttribute($objAttribute->getId(), $historyId), ENT_QUOTES, CONTREXX_CHARSET);
                if ($arrPlaceholders['_VALUE'] == '0' || $arrPlaceholders['_VALUE'] == 'gender_undefined') {
                    $arrPlaceholders['_VALUE'] = '';
                }
                if ($this->_objTpl->blockExists($this->attributeNamePrefix.'_'.$attributeId.'_children')) {
                    foreach ($objAttribute->getChildren() as $childAttributeId) {
                        $this->parseAttribute($objUser, $childAttributeId, $historyId, $edit, false, true, false, $useMagicBlock);
                    }
                }
                break;
            case 'frame':
                foreach ($objAttribute->getChildren() as $childAttributeId) {
                    $this->parseAttribute($objUser, $childAttributeId, $historyId, $edit, false, true, true, $useMagicBlock);
                }

                $arrPlaceholders['_VALUE'] = $objAttribute->getMenuOptionValue();
                break;
            case 'menu_option':
                $arrPlaceholders['_VALUE'] = $objAttribute->getMenuOptionValue();
                $arrPlaceholders['_SELECTED'] = $objAttribute->getMenuOptionValue() == $objUser->getProfileAttribute($objAttribute->getParent(), $historyId) ? 'selected="selected"' : '';

                if ($objAttribute->isCoreAttribute() && $objAttribute->isUnknownOption()) {
                    $objParentAttribute = $objAttribute->getById($objAttribute->getParent());
                    if ($objParentAttribute->isMandatory()) {
                        $arrPlaceholders['_DESC'] = $_CORELANG['TXT_ACCESS_PLEASE_SELECT'];
                    }
                }
                break;
            case 'group':
                if ($this->_objTpl->blockExists($this->attributeNamePrefix.'_'.$attributeId.'_children')) {
                    foreach ($objAttribute->getChildren() as $childAttributeId) {
                        $this->parseAttribute($objUser, $childAttributeId, $historyId, $edit, false, true, true, $useMagicBlock);
                    }
                }
                break;
            case 'history':
                if (!isset($objUser->arrAttributeHistories[$objUser->getId()][$attributeId])) {
                    $objUser->arrAttributeHistories[$objUser->getId()][$attributeId] = array();
                }
                sort($objUser->arrAttributeHistories[$objUser->getId()][$attributeId]);

                if ($edit && !in_array(0, $objUser->arrAttributeHistories[$objUser->getId()][$attributeId])) {
                    $objUser->arrAttributeHistories[$objUser->getId()][$attributeId][] = 0;
                }
                foreach ($objUser->arrAttributeHistories[$objUser->getId()][$attributeId] as $attributeHistoryId) {
                    if ($this->_objTpl->blockExists($this->attributeNamePrefix.'_'.$attributeId.'_history_list') || $this->_objTpl->blockExists($this->attributeNamePrefix.'_'.$attributeId.'_history_'.$attributeHistoryId)) {
                        foreach ($objAttribute->getChildren() as $childAttributeId) {
                            $this->parseAttribute($objUser, $childAttributeId, $attributeHistoryId, $edit, false, false, false, $useMagicBlock);
                        }

                        $this->_objTpl->setVariable($this->modulePrefix.'PROFILE_ATTRIBUTE_'.$attributeIdUC.'_HISTORY_ID', $attributeHistoryId);
                        if ($this->_objTpl->blockExists($this->attributeNamePrefix.'_'.$attributeId.'_history_'.$attributeHistoryId)) {
                            $this->_objTpl->parse($this->attributeNamePrefix.'_'.$attributeId.'_history_'.$attributeHistoryId);
                        } else {
                            $this->_objTpl->parse($this->attributeNamePrefix.'_'.$attributeId.'_history_list');
                        }
                    }
                }
                break;
        }

        if (!$edit && isset($arrPlaceholders['_VALUE']) && $arrPlaceholders['_VALUE'] == '') {
            return false;
        }
        if ($inFrame) {
            $objFrameAttribute = $objAttribute->getById($objAttribute->getParent());
        }

        $parsed = false;
        $frameParsed = false;
        $arrPostfix = array('_history_'.$historyId, '');
        foreach ($arrPostfix as $historyPostfix) {
            if (!$parsed) {
                $parsed = true;
                if ($inFrame && $this->_objTpl->blockExists($this->attributeNamePrefix.'_'.$objFrameAttribute->getParent().'_frame_'.$objAttribute->getParent().'_child_'.$attributeId.$historyPostfix)) {
                    // specified child of a specified frame
                    $this->parseAttributePlaceholders($arrPlaceholders, true, strtoupper($objFrameAttribute->getParent()), $parentIdUC, $attributeIdUC, true, true);
                    $this->_objTpl->parse($this->attributeNamePrefix.'_'.$objFrameAttribute->getParent().'_frame_'.$objAttribute->getParent().'_child_'.$attributeId.$historyPostfix);
                } elseif ($inFrame && $this->_objTpl->blockExists($this->attributeNamePrefix.'_'.$objFrameAttribute->getParent().'_frame_'.$objAttribute->getParent().'_children'.$historyPostfix)) {
                    // children of a specified frame
                    $this->parseAttributePlaceholders($arrPlaceholders, true, $objFrameAttribute->getParent(), $parentIdUC, 0, true, true);
                    $this->_objTpl->parse($this->attributeNamePrefix.'_'.$objFrameAttribute->getParent().'_frame_'.$objAttribute->getParent().'_children'.$historyPostfix);
                } elseif ($inFrame && $this->_objTpl->blockExists($this->attributeNamePrefix.'_'.$objFrameAttribute->getParent().'_frame_children'.$historyPostfix)) {
                    // children of a frame
                    $this->parseAttributePlaceholders($arrPlaceholders, true, $objFrameAttribute->getParent(), 0, 0, true, true);
                    $this->_objTpl->parse($this->attributeNamePrefix.'_'.$objFrameAttribute->getParent().'_frame_children'.$historyPostfix);
                } elseif ($this->_objTpl->blockExists($this->attributeNamePrefix.'_'.$attributeId.$historyPostfix)) {
                    // attribute
                    $this->parseAttributePlaceholders($arrPlaceholders, true, $isChild ? $parentIdUC : $attributeIdUC, 0, 0, false, $isChild);
                    $this->_objTpl->parse($this->attributeNamePrefix.'_'.$attributeId.$historyPostfix);
                } elseif ($objAttribute->getParent() && $this->_objTpl->blockExists($this->attributeNamePrefix.'_'.$objAttribute->getParent().'_children'.$historyPostfix)) {
                    // children of an attrbiute
                    $this->parseAttributePlaceholders($arrPlaceholders, true, $parentIdUC, 0, 0, false, true);
                    $this->_objTpl->parse($this->attributeNamePrefix.'_'.$objAttribute->getParent().'_children'.$historyPostfix);
                } elseif ($useMagicBlock && !$isChild && $this->_objTpl->blockExists($this->attributeNamePrefix.'_list'.$historyPostfix)) {
                    // magic block attribute_list
                    $this->parseAttributePlaceholders($arrPlaceholders, false, $isChild ? $parentIdUC : $attributeIdUC, 0, 0);
                    $this->_objTpl->parse($this->attributeNamePrefix.'_list'.$historyPostfix);
                } elseif (!$useMagicBlock) {
                    $this->parseAttributePlaceholders($arrPlaceholders, true, $attributeIdUC, 0, 0);
                    $parsed = empty($historyPostfix);
                } else {
                    $parsed = false;
                }
            }

            if (!$frameParsed) {
                $frameParsed = true;
                if ($objAttribute->getType() == 'frame') {
                    if ($this->_objTpl->blockExists($this->attributeNamePrefix.'_'.$objAttribute->getParent().'_frame_'.$attributeId.$historyPostfix)) {
                        // current attribute is a frame which has been especially defined
                        $this->parseAttributePlaceholders($arrPlaceholders, true, $parentIdUC, $attributeIdUC, 0, true, false);
                        $this->_objTpl->parse($this->attributeNamePrefix.'_'.$objAttribute->getParent().'_frame_'.$attributeId.$historyPostfix);
                    } elseif ($this->_objTpl->blockExists($this->attributeNamePrefix.'_'.$objAttribute->getParent().'_frames'.$historyPostfix)) {
                        // current attributeis a frame
                        $this->parseAttributePlaceholders($arrPlaceholders, true, $parentIdUC, 0, 0, true, false);
                        $this->_objTpl->parse($this->attributeNamePrefix.'_'.$objAttribute->getParent().'_frames'.$historyPostfix);
                    } else {
                        $frameParsed = false;
                    }
                } else {
                    $frameParsed = false;
                }
            }
        }

        return true;
    }

    private function getDateMonthMenu($attributeName, $selectedOption)
    {
        global $_CORELANG;

        $arrMonthNames = explode(',', $_CORELANG['TXT_MONTH_ARRAY']);
        $childrenCode = array($this->getMenuOptionAttributeCode(0, $selectedOption, $_CORELANG['TXT_CORE_MONTH'].':'));
        $arrMonth = range(1, 12);
        foreach ($arrMonth as $month) {
            $childrenCode[] = $this->getMenuOptionAttributeCode($month, $selectedOption, $arrMonthNames[$month-1]);
        }
        $value = join($childrenCode);
        return $this->getMenuAttributeCode($attributeName.'[month]', $value, true, 'width:auto;min-width:0px;');
    }

    private function getDateDayMenu($attributeName, $selectedOption)
    {
        global $_CORELANG;

        $childrenCode = array($this->getMenuOptionAttributeCode(0, $selectedOption, $_CORELANG['TXT_CORE_DAY'].':'));
        $arrDay = range(1, 31);
        foreach ($arrDay as $day) {
            $childrenCode[] = $this->getMenuOptionAttributeCode($day, $selectedOption, $day);
        }
        $value = join($childrenCode);
        return $this->getMenuAttributeCode($attributeName.'[day]', $value, true, 'width:auto;min-width:0px;');
    }

    private function getDateYearMenu($attributeName, $selectedOption)
    {
        global $_CORELANG;

        $childrenCode = array($this->getMenuOptionAttributeCode(0, $selectedOption, $_CORELANG['TXT_CORE_YEAR'].':'));
        $arrYear = range(date('Y'), 1900);
        foreach ($arrYear as $year) {
            $childrenCode[] = $this->getMenuOptionAttributeCode($year, $selectedOption, $year);
        }
        $value = join($childrenCode);
        return $this->getMenuAttributeCode($attributeName.'[year]', $value, true, 'width:auto;min-width:0px;');
    }

    private function parseAttributePlaceholders($arrPlaceholders, $defined = false, $attributeIdUC = 0, $frameIdUC = 0, $childIdUC = 0, $frame = false, $child = false)
    {
        foreach ($arrPlaceholders as $key => $value) {
            $key = $this->modulePrefix.'PROFILE_ATTRIBUTE'.(
                $defined ?
                    '_'.$attributeIdUC.($frame ? (
                        '_FRAME'.($frameIdUC ?
                            '_'.$frameIdUC
                        :    ''))
                    :    '').
                    ($child ? (
                        '_CHILD'.($childIdUC ?
                            '_'.$childIdUC
                        :    ''))
                    :    '')
                : '')
                .$key;
            $this->_objTpl->setVariable($key, $value);
        }
    }


    private function loadAccountAttributes()
    {
        global $_CORELANG;

        $this->arrAccountAttributes = array(
            'username'    => array(
                'name'    => $_CORELANG['TXT_ACCESS_USERNAME'],
                'type'    => 'text',
                'value'    => 'getRealUsername'
            ),
            'password'    => array(
                'name'    => $_CORELANG['TXT_ACCESS_PASSWORD'],
                'type'    => 'password'
            ),
            'password_confirmed'    => array(
                'name'    => $_CORELANG['TXT_ACCESS_CONFIRM_PASSWORD'],
                'type'    => 'password'
            ),
            'current_password'    => array(
                'name'    => $_CORELANG['TXT_ACCESS_CURRENT_PASSWORD'],
                'type'    => 'password'),
            'email'    => array(
                'name'    => $_CORELANG['TXT_ACCESS_EMAIL'],
                'type'    => 'email',
                'value'    => 'getEmail'
            ),
            'frontend_language'    => array(
                'name'    => $_CORELANG['TXT_ACCESS_LANGUAGE'],
                'type'    => 'menu',
                'children'    => array(),
                'value'    => 'getFrontendLanguage'
            ),
            'backend_language'    => array(
                'name'    => $_CORELANG['TXT_ACCESS_LANGUAGE'],
                'type'    => 'menu',
                'children'    => array(),
                'value'    => 'getBackendLanguage'
            ),
            'email_access'    => array(
                'name'    => $_CORELANG['TXT_ACCESS_EMAIL'],
                'type'    => 'menu',
                'children'    => array(
                    'everyone'        => $_CORELANG['TXT_ACCESS_EVERYONE_ALLOWED_SEEING_EMAIL'],
                    'members_only'    => $_CORELANG['TXT_ACCESS_MEMBERS_ONLY_ALLOWED_SEEING_EMAIL'],
                    'nobody'        => $_CORELANG['TXT_ACCESS_NOBODY_ALLOWED_SEEING_EMAIL']
                ),
                'value'    => 'getEmailAccess'
            ),
            'primary_group' => array(
                'name'    => $_CORELANG['TXT_ACCESS_PRIMARY_GROUP'],
                'type'    => 'text',
                'value'   => 'getPrimaryGroupName'
            ),
            'profile_access'    => array(
                'name'    => $_CORELANG['TXT_ACCESS_PROFILE'],
                'type'    => 'menu',
                'children'    => array(
                    'everyone'        => $_CORELANG['TXT_ACCESS_EVERYONE_ALLOWED_SEEING_PROFILE'],
                    'members_only'    => $_CORELANG['TXT_ACCESS_MEMBERS_ONLY_ALLOWED_SEEING_PROFILE'],
                    'nobody'        => $_CORELANG['TXT_ACCESS_NOBODY_ALLOWED_SEEING_PROFILE']
                ),
                'value'        => 'getProfileAccess'
            )
        );

        $this->loadLanguageAccountAttribute();
    }


    private function loadLanguageAccountAttribute()
    {
        global $_CORELANG;

        $arrScope = array('frontend', 'backend');
        $this->arrAccountAttributes['frontend_language']['children'][0] = $this->arrAccountAttributes['backend_language']['children'][0] = $_CORELANG['TXT_ACCESS_DEFAULT'];
        foreach (FWLanguage::getLanguageArray() as $langId => $arrLanguage) {
            foreach ($arrScope as $scope) {
                if ($arrLanguage[$scope]) {
                    $this->arrAccountAttributes[$scope.'_language']['children'][$langId] = $arrLanguage['name'];
                }
            }
        }
    }


    protected function parseAccountAttributes($objUser, $edit = false)
    {
        if (!isset($this->arrAccountAttributes)) {
            $this->loadAccountAttributes();
        }

        foreach (array_keys($this->arrAccountAttributes) as $attributeId) {
            switch ($attributeId) {
                case 'email_access':
                    if (!$objUser->isAllowedToChangeEmailAccess()) {
                        if ($this->_objTpl->blockExists('access_user_'.$attributeId)) {
                            $this->_objTpl->hideBlock('access_user_'.$attributeId);
                        }
                        continue 2;
                    }
                    break;

                case 'profile_access':
                    if (!$objUser->isAllowedToChangeProfileAccess()) {
                        if ($this->_objTpl->blockExists('access_user_'.$attributeId)) {
                            $this->_objTpl->hideBlock('access_user_'.$attributeId);
                        }
                        continue 2;
                    }
                    break;
            }
            $this->parseAccountAttribute($objUser, $attributeId, $edit);
        }
    }


    protected function parseAccountAttribute($objUser, $attributeId, $edit=false, $value=null)
    {
        // this is required in the case we're calling this method directly
        if (!isset($this->arrAccountAttributes)) {
            $this->loadAccountAttributes();
        }

        $accountAttributePrefix = 'access_user_';
        $accountAttributePrefixUC = strtoupper($accountAttributePrefix);

        $placeholderUC = $accountAttributePrefixUC.strtoupper($attributeId);
        $arrPlaceholders = array(
            $placeholderUC.'_DESC'    => $this->arrAccountAttributes[$attributeId]['name'],
            $placeholderUC.'_NAME'    => $accountAttributePrefix.$attributeId,
            $placeholderUC.'_ID'        => $accountAttributePrefix.$attributeId
        );

        $arrSettings = User_Setting::getSettings();
        if (!$arrSettings['use_usernames']['status'] && $attributeId == 'username') {
            // display email address if usernames are deactivated
            $attributeId = 'email';
        }

        $value = $arrPlaceholders[$placeholderUC.'_VALUE'] = isset($value) ? $value : (isset($this->arrAccountAttributes[$attributeId]['value']) ? $objUser->{$this->arrAccountAttributes[$attributeId]['value']}() : '');

        switch ($this->arrAccountAttributes[$attributeId]['type']) {
            case 'text':
                $arrPlaceholders[$placeholderUC] = $this->getTextAttributeCode($accountAttributePrefix.$attributeId, $value, $edit);
                break;

            case 'password':
                $arrPlaceholders[$placeholderUC] = $this->getPasswordAttributeCode($accountAttributePrefix.$attributeId);
                break;

            case 'email':
                $arrPlaceholders[$placeholderUC] = $this->getEmailAttributeCode($accountAttributePrefix.$attributeId, $value, $edit);
                break;

            case 'menu':
                if ($edit == true) {
                    $childrenCode = array();
                    foreach ($this->arrAccountAttributes[$attributeId]['children'] as $childAttributeId => $childAttributeName) {
                        $childrenCode[] = $this->getMenuOptionAttributeCode($childAttributeId, $value, $childAttributeName);
                    }
                    $value = join($childrenCode);
                }

                $arrPlaceholders[$placeholderUC] = $this->getMenuAttributeCode($accountAttributePrefix.$attributeId, $value, $edit);
                break;

            default:
                $arrPlaceholders[$placeholderUC] = htmlentities($value, ENT_QUOTES, CONTREXX_CHARSET);
                break;
        }

        $this->_objTpl->setVariable($arrPlaceholders);
        if ($this->_objTpl->blockExists($accountAttributePrefix.$attributeId)) {
            if ($arrSettings['use_usernames']['status'] || $attributeId != 'username') {
                $this->_objTpl->parse($accountAttributePrefix.$attributeId);
            }
        }/* else {
            $this->_objTpl->setVariable($placeholderUC, $arrPlaceholders[$placeholderUC]);
        }*/
    }


    /**
     * Return the html code for a text attribute
     *
     * @param string $name
     * @param string $value
     * @param boolean $edit
     * @return string
     */
    private function getTextAttributeCode($name, $value, $edit)
    {
        $value = htmlentities($value, ENT_QUOTES, CONTREXX_CHARSET);
        return $edit ?
            str_replace(
                array('[NAME]', '[VALUE]'),
                array($name, $value),
                $this->arrAttributeTypeTemplates['text']
            )
            : $value;
    }


    /**
     * Return the html code for a password attribute
     *
     * @param string $name
     * @param string $value
     * @param boolean $edit
     * @return string
     */
    private function getPasswordAttributeCode($name)
    {
        return str_replace('[NAME]', $name, $this->arrAttributeTypeTemplates['password']);
    }


    /**
     * Return the html code for an email attribute
     *
     * @param string $name
     * @param string $value
     * @param boolean $edit
     * @return string
     */
    private function getEmailAttributeCode($name, $value, $edit)
    {
        $value = htmlentities($value, ENT_QUOTES, CONTREXX_CHARSET);
        return $edit ?
            str_replace(
                array('[NAME]', '[VALUE]'),
                array($name, $value),
                $this->arrAttributeTypeTemplates['text']
            )
            : $value;
    }


    /**
     * Return the html code for a textarea attribtue
     *
     * @param string $name
     * @param string $value
     * @param boolean $edit
     * @return string
     */
    private function getTextareaAttributeCode($name, $value, $edit)
    {
        $value = htmlentities($value, ENT_QUOTES, CONTREXX_CHARSET);
        return $edit ?
            str_replace(
                array('[NAME]', '[VALUE]'),
                array($name, $value),
                $this->arrAttributeTypeTemplates['textarea']
            )
            : nl2br($value);
    }


    /**
     * Return the html code for an URI attribute
     *
     * @param string $name
     * @param string $uri
     * @param boolean $edit
     * @return string
     */
    private function getURIAttributeCode($name, $uri, $edit)
    {
        global $_CORELANG;

        return $edit ?
            str_replace(
                array('[NAME]', '[VALUE]', '[VALUE_TXT]'),
                array($name, $uri, (!empty($uri) ? '<a href="'.$uri.'" onclick="return confirm(\''.sprintf($_CORELANG['TXT_ACCESS_URL_OPEN_RISK_MSG'], htmlentities($uri, ENT_QUOTES, CONTREXX_CHARSET)).'\n'.$_CORELANG['TXT_ACCESS_CONFIRM_OPEN_URL'].'\')" target="_blank" title="'.$_CORELANG['TXT_ACCESS_VISIT_WEBSITE'].'">'.htmlentities($uri, ENT_QUOTES, CONTREXX_CHARSET).'</a>' : $_CORELANG['TXT_ACCESS_NO_SPECIFIED'])),
                $this->arrAttributeTypeTemplates['url']
            )
            : (!empty($uri) ? '<a href="'.$uri.'" title="'.$_CORELANG['TXT_ACCESS_VISIT_WEBSITE'].'">'.htmlentities($uri, ENT_QUOTES, CONTREXX_CHARSET).'</a>' : $_CORELANG['TXT_ACCESS_NO_SPECIFIED']);
    }


    /**
     * Return the html code for a date attribute
     *
     * @param string $name
     * @param string  $value
     * @param boolean $edit
     * @return string
     */
    private function getDateAttributeCode($name, $value, $edit)
    {
        $value = $value !== false && $value !== '' ? date(ASCMS_DATE_FORMAT_DATE, intval($value)) : '';
        return $edit ?
            str_replace(
                array('[NAME]', '[VALUE]'),
                array($name, $value),
                $this->arrAttributeTypeTemplates['date']
            )
            : $value;
    }


    /**
     * Return the html code for an image attribute
     *
     * @param string $name
     * @param string $value
     * @param string $attributeId
     * @param string $attributeHtmlId
     * @param integer $historyId
     * @param boolean $edit
     * @return string
     */
    private function getImageAttributeCode($objUser, $name, $value, $attributeId, $attributeHtmlId, $historyId, $edit, $thumbnail = false)
    {
        global $_CORELANG;

        if ($attributeId == 'picture') {
            $imageRepo = ASCMS_ACCESS_PROFILE_IMG_PATH.'/';
            $imageRepoWeb = ASCMS_ACCESS_PROFILE_IMG_WEB_PATH.'/';
            $arrNoImage = User_Profile::$arrNoAvatar;
        } else {
            if ($edit) {
                $thumbnail = true;
            }
            $imageRepo = ASCMS_ACCESS_PHOTO_IMG_PATH.'/';
            $imageRepoWeb = ASCMS_ACCESS_PHOTO_IMG_WEB_PATH.'/';
            $arrNoImage = User_Profile::$arrNoPicture;
        }

        if ($value !== false && $value !== '' && (!$edit || file_exists($imageRepo.$value))) {
            $imageSet = true;
            $image['src'] =
                $imageRepoWeb.($thumbnail
                    ? ImageManager::getThumbnailFilename($value) : $value);
            $image['path'] = htmlentities($value, ENT_QUOTES, CONTREXX_CHARSET);

        } else {
            $imageSet = false;
            $image['src'] =
                $imageRepoWeb.($thumbnail
                    ? ImageManager::getThumbnailFilename($arrNoImage['src'])
                    : $arrNoImage['src']);
            $image['path'] = '';
        }

        return $edit ?
            // Input field containing the image source
            '<input type="hidden" name="'.$name.'" id="'.$attributeHtmlId.'" value="'.$image['path'].'" />'

            // The image, if defined
            .'<img src="'.$image['src'].'" id="'.$attributeHtmlId.'_image" alt="'.$image['path'].'" border="0" />'

            // Image Link to remove the image
            .($imageSet ? '<a
                href="javascript:void(0)"
                onclick="
                    document.getElementById(\''.$attributeHtmlId.'_image\').src=\''.$imageRepoWeb.'/'.$arrNoImage['src'].'\';
                    document.getElementById(\''.$attributeHtmlId.'_image\').style.width=\''.$arrNoImage['width'].'px\';
                    document.getElementById(\''.$attributeHtmlId.'_image\').style.height=\''.$arrNoImage['height'].'px\';
                    document.getElementById(\''.$attributeHtmlId.'\').value = \'\';
                    this.style.display=\'none\'"
                title="'.$_CORELANG['TXT_ACCESS_DELETE_IMAGE'].'">
                <img
                    src="'.ASCMS_PATH_OFFSET.'/images/modules/access/delete.gif"
                    alt="'.$_CORELANG['TXT_ACCESS_DELETE_IMAGE'].'"
                    border="0"
                    width="17"
                    height="17"
                />
            </a>' : '').'
            <br />'

            // File Upload field to set a new image
            .'<input
                type="file"
                name="'.$this->attributeNamePrefix.'_images['.$attributeId.']['.$historyId.']"
                onchange="this.nextSibling.style.display = this.value.length ? \'\' : \'none\';"
            />'

            // Image Link to reset the file upload field
            .'<a
                href="javascript:void(0)"
                style="display:none;"
                onclick="
                    this.previousSibling.value=\'\';
                    this.style.display=\'none\'"
                title="'.$_CORELANG['TXT_ACCESS_DELETE_IMAGE'].'">
                <img
                    src="'.ASCMS_PATH_OFFSET.'/images/modules/access/delete.gif"
                    alt="'.$_CORELANG['TXT_ACCESS_DELETE_IMAGE'].'"
                    border="0"
                    width="17"
                    height="17"
                    style="vertical-align:bottom;"
                />
            </a>'
            : '<img src="'.$image['src'].'" alt="'.($attributeId == 'picture' ? htmlentities($objUser->getUsername(), ENT_QUOTES, CONTREXX_CHARSET) : $image['path']).'" border="0" />';
    }


    /**
     * Return the html code for a checkbox attribute
     *
     * @param string $name
     * @param string $value
     * @param boolean $edit
     * @return string
     */
    private function getCheckboxAttributeCode($name, $value, $edit)
    {
        global $_ARRAYLANG;

        return $edit ?
            str_replace(
                array('[NAME]', '[CHECKED]'),
                array($name, $value ? 'checked="checked"' : ''),
                $this->arrAttributeTypeTemplates['checkbox']
            )
            : ($value ? $_ARRAYLANG['TXT_ACCESS_YES'] : $_ARRAYLANG['TXT_ACCESS_NO']);
    }


    /**
     * Return the html code of a dropdown menu option
     *
     * @param string $value
     * @param string $selected
     * @param string $valueText
     * @return string
     */
    private function getMenuOptionAttributeCode($value, $selected, $valueText, $style = null)
    {
        return str_replace(
            array('[VALUE]', '[SELECTED]', '[VALUE_TXT]', '[STYLE]'),
            array(htmlentities($value, ENT_QUOTES, CONTREXX_CHARSET), ($selected == $value ? ' selected="selected"' : ''), htmlentities($valueText, ENT_QUOTES, CONTREXX_CHARSET), ($style ? ' style="'.$style.'"' : '')),
            $this->arrAttributeTypeTemplates['menu_option']
        );
    }


    /**
     * Return the html code of a menu attribute
     *
     * @param string $name
     * @param string $value
     * @param boolean $edit
     * @return string
     */
    private function getMenuAttributeCode($name, $value, $edit, $style = null)
    {
        return $edit ?
            str_replace(
                array('[NAME]', '[VALUE]', '[STYLE]'),
                array($name, $value, ($style ? ' style="'.$style.'"' : '')),
                $this->arrAttributeTypeTemplates['menu']
            )
            :
            htmlentities($value, ENT_QUOTES, CONTREXX_CHARSET);
    }


    private function _getAtrributeCode($objUser, $attributeId, $historyId, $edit = false)
    {
        global $_CORELANG;

        $objAttribute = $objUser->objAttribute->getById($attributeId);

        $attributeName = $this->attributeNamePrefix.'['.$attributeId.']['.$historyId.']';
        $attributeHtmlId = $this->attributeNamePrefix.'_'.$attributeId.'_'.$historyId;
        $code = '';

        if ($edit && $objAttribute->isProtected() && !Permission::checkAccess($objAttribute->getAccessId(), 'dynamic', true) && !$objAttribute->checkModifyPermission()) {
            $edit = false;
        }

        switch ($objAttribute->getType())
        {
            case 'text':
                $code = $objAttribute->isMultiline() ?
                    $this->getTextareaAttributeCode($attributeName, $objUser->getProfileAttribute($objAttribute->getId(), $historyId), $edit)
                    : $this->getTextAttributeCode($attributeName, $objUser->getProfileAttribute($objAttribute->getId(), $historyId), $edit);
                break;

            case 'mail':
                $code = $this->getEmailAttributeCode($attributeName, $objUser->getProfileAttribute($objAttribute->getId(), $historyId), $edit);
                break;

            case 'uri':
                $code = $this->getURIAttributeCode($attributeName, $objUser->getProfileAttribute($objAttribute->getId(), $historyId), $edit);
                break;

            case 'date':
                $code = $this->getDateAttributeCode($attributeName, $objUser->getProfileAttribute($attributeId, $historyId), $edit);
                break;

            case 'image':
                $code = $this->getImageAttributeCode($objUser, $attributeName, $objUser->getProfileAttribute($objAttribute->getId(), $historyId), $attributeId, $attributeHtmlId, $historyId, $edit);
                break;

            case 'checkbox':
                $code = $this->getCheckboxAttributeCode($attributeName, $objUser->getProfileAttribute($objAttribute->getId(), $historyId), $edit);
                break;

            case 'menu':
                if ($edit) {
                    $childrenCode = array();
                    if ($objAttribute->isCustomAttribute()) {
                        if ($objAttribute->isMandatory()) {
                            $childrenCode[] = $this->getMenuOptionAttributeCode('0', $objUser->getProfileAttribute($objAttribute->getId(), $historyId), $_CORELANG['TXT_ACCESS_PLEASE_SELECT'], 'border-bottom:1px solid #000000;');
                        } else {
                            $childrenCode[] = $this->getMenuOptionAttributeCode('0', $objUser->getProfileAttribute($objAttribute->getId(), $historyId), $_CORELANG['TXT_ACCESS_NOT_SPECIFIED'], 'border-bottom:1px solid #000000;');
                        }
                    }

                    foreach ($objAttribute->getChildren() as $childAttributeId) {
                        $childrenCode[] = $this->_getAtrributeCode($objUser, $childAttributeId, $historyId, $edit);
                    }
                    $value = join($childrenCode);
                } elseif ($objAttribute->isCoreAttribute()) {
                    foreach ($objAttribute->getChildren() as $childAttributeId) {
                        $objChildAtrribute = $objAttribute->getById($childAttributeId);
                        if ($objChildAtrribute->getMenuOptionValue() == $objUser->getProfileAttribute($objAttribute->getId(), $historyId)) {
                            $value = $objChildAtrribute->getName();
                            break;
                        }
                    }
                } else {
                    $objSelectedAttribute = $objAttribute->getById($objUser->getProfileAttribute($objAttribute->getId(), $historyId));
                    $value = $objSelectedAttribute->getName();
                }

                $code = $this->getMenuAttributeCode($attributeName, $value, $edit);
                break;

            case 'menu_option':
                $mandatory = false;
                $selectOption = false;
                if ($objAttribute->isCoreAttribute() && $objAttribute->isUnknownOption()) {
                    $selectOption = true;
                    $objParentAttribute = $objAttribute->getById($objAttribute->getParent());
                    if ($objParentAttribute->isMandatory()) {
                        $mandatory= true;
                    }
                }
                $code = $this->getMenuOptionAttributeCode($objAttribute->getMenuOptionValue(), $objUser->getProfileAttribute($objAttribute->getParent(), $historyId), $mandatory ? $_CORELANG['TXT_ACCESS_PLEASE_SELECT'] : $objAttribute->getName(), $selectOption ? 'border-bottom:1px solid #000000' : '');
                break;

            case 'group':
                $code = '<select name="'.$attributeName.'" onchange="for (i=0; i < this.options.length; i++) {document.getElementById(this.options[i].value).style.display = (i == this.selectedIndex ? \'\' : \'none\')}">';

                $arrFramesCode = array();
                $firstFrame = true;
                foreach ($objAttribute->getChildren() as $childAttributeId) {
                    $objChildAtrribute = $objAttribute->getById($childAttributeId);
                    $code .= $this->_getAtrributeCode($objUser, $childAttributeId, $historyId, $edit);

                    $arrFramesCode[$childAttributeId] = '<div id="'.$this->attributeNamePrefix.'_'.$childAttributeId.'_'.$historyId.'" style="display:'.($firstFrame ? '' : 'none').'"><br />';
                    if ($objAttribute->hasChildren($childAttributeId)) {
                        $objChildAtrribute = $objAttribute->getById($childAttributeId);
                        foreach ($objChildAtrribute->getChildren() as $frameChildAttributeId) {
                            $objSubChildAttribute = $objChildAtrribute->getById($frameChildAttributeId);
                            $arrFramesCode[$childAttributeId] .= '<div style="width:100px; float:left;">'.htmlentities($objSubChildAttribute->getName(), ENT_QUOTES, CONTREXX_CHARSET).': </div>'.$this->_getAtrributeCode($objUser, $frameChildAttributeId, $historyId, $edit).'<br />';
                        }
                    }
                    $arrFramesCode[$childAttributeId] .= '</div>';
                    $firstFrame = false;
                }
                $code .= '</select>';
                foreach ($arrFramesCode as $frameCode) {
                    $code .= $frameCode;
                }

                break;

            case 'frame':
                $code = '<option value="'.$attributeHtmlId.'">'.htmlentities($objAttribute->getName(), ENT_QUOTES, CONTREXX_CHARSET).'</option>';
                break;

            case 'history':
                if (!count($objAttribute->getChildren())) {
                    break;
                }

                if (!isset($objUser->arrAttributeHistories[$objUser->getId()][$attributeId])) {
                    $objUser->arrAttributeHistories[$objUser->getId()][$attributeId] = array();
                }
                sort($objUser->arrAttributeHistories[$objUser->getId()][$attributeId]);

                if ($edit && !in_array(0, $objUser->arrAttributeHistories[$objUser->getId()][$attributeId])) {
                    $objUser->arrAttributeHistories[$objUser->getId()][$attributeId][] = 0;
                }

                foreach ($objAttribute->getChildren() as $childAttributeId) {
                    $objChildAtrribute = $objAttribute->getById($childAttributeId);
                    $arrCols[] = $objChildAtrribute->getName();
                }

                $code = '<table border="0" width="100%" id="'.$this->attributeNamePrefix.'_'.$attributeId.'"><thead><tr><th>'.implode('</th><th>', $arrCols).'</th>'.($edit ? '<th>#</th>' : '').'</tr></thead>';

                $arrRows = array();
                foreach ($objUser->arrAttributeHistories[$objUser->getId()][$attributeId] as $attributeHistoryId) {
                    $arrCols = array();
                    foreach ($objAttribute->getChildren() as $childAttributeId) {
                        $arrCols[] = $this->_getAtrributeCode($objUser, $childAttributeId, $attributeHistoryId, $edit);
                    }

                    if (!$attributeHistoryId) {
                    $arrRows[] = '<tr style="display:none;" id="'.$this->attributeNamePrefix.'_'.$attributeId.'_history_new"><td>'.implode('</td><td>', $arrCols).'</td><td><a href="javascript:void(0);" onclick="this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode);"><img src="'.ASCMS_PATH_OFFSET.'/images/modules/access/delete.gif" width="17" height="17" border="0" alt="'.$_CORELANG['TXT_ACCESS_DELETE_ENTRY'].'" /></a></td></tr>';
                    } else {
                        $arrRows[] = '<tr id="'.$this->attributeNamePrefix.'_'.$attributeId.'_history_'.$attributeHistoryId.'"><td>'.implode('</td><td>', $arrCols).'</td>'.($edit ? '<td><a href="javascript:void(0);" onclick="this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode);"><img src="'.ASCMS_PATH_OFFSET.'/images/modules/access/delete.gif" width="17" height="17" border="0" alt="'.$_CORELANG['TXT_ACCESS_DELETE_ENTRY'].'" /></a></td>' : '').'</tr>';
                    }
                }

                $code .= '<tbody>'.implode($arrRows).'</tbody></table>';
                if ($edit) {
                    $code .= '<br />
                        <input
                            type="button"
                            value="'.$_CORELANG['TXT_ACCESS_ADD_NEW_ENTRY'].'"
                            onclick="
                                newEntry=document.getElementById(\''.$this->attributeNamePrefix.'_'.$attributeId.'_history_new\').cloneNode(true);
                                newEntry.removeAttribute(\'id\');
                                regex=/([a-z_]+)\[([0-9]+)]\[(?:[0-9]+)\](?:\[([a-z]+)\])?/;
                                elTypes=[\'a\',\'input\',\'select\',\'radio\',\'checkbox\'];
                                for (y=0;y<elTypes.length;y++) {
                                    for (i=0;i<newEntry.getElementsByTagName(elTypes[y]).length;i++) {
                                        if (typeof(newEntry.getElementsByTagName(elTypes[y])[i].name) != \'undefined\' && newEntry.getElementsByTagName(elTypes[y])[i].name.length) {
                                            arrName=regex.exec(newEntry.getElementsByTagName(elTypes[y])[i].name);
                                            newEntry.getElementsByTagName(elTypes[y])[i].setAttribute(\'name\',arrName[1]+\'[\'+arrName[2]+\'][new][\'+(typeof(arrName[3]) != \'undefined\' ? arrName[3] : \'\')+\']\');
                                        }
                                    }
                                }
                                newEntry.style.display=\'\';
                                document.getElementById(\''.$this->attributeNamePrefix.'_'.$attributeId.'\').getElementsByTagName(\'tbody\')[0].appendChild(newEntry)"
                        />';
                }

                break;
        }

        return $code.($objAttribute->isMandatory() && $edit ? $this->_mandatorySign : '');
    }


    protected function getJavaScriptCode()
    {
        global $_ARRAYLANG, $_CORELANG;

        static $arrFunctions;

        if (empty($arrFunctions)) {
            $arrSettings = User_Setting::getSettings();

            $arrFunctions = array(
                'accessSetWebsite' => <<<JSaccessSetWebsite
<script type="text/javascript">
// <![CDATA[
function accessSetWebsite(elInput, elDiv, elLink)
{
    website = elInput.value;
    newWebsite = prompt('{$_CORELANG['TXT_ACCESS_SET_ADDRESS_OF_WEBSITE']}', (website != '' ? website : 'http://'));

    if (typeof(newWebsite) == 'string') {
        if (newWebsite == 'http://') {
            newWebsite = '';
        } else if (newWebsite != '' && newWebsite.substring(0, 7) != 'http://') {
            newWebsite = 'http://'+newWebsite;
        }

        elInput.value = newWebsite;

        if (newWebsite != '') {
            if (elLink == null) {
                accessRemoveChildsOfElement(elDiv);

                objLink = document.createElement('a');
                objLink.target = '_blank';
                objLink.title = '{$_CORELANG['TXT_ACCESS_VISIT_WEBSITE']}';
                objLinkText = document.createTextNode('');
                objLink.appendChild(objLinkText);
                objLink.setAttribute('href', newWebsite);
                objLink.childNodes[0].nodeValue = newWebsite;
                accessAddEvent(objLink, newWebsite);

                elDiv.appendChild(objLink);
            } else {
                elLink.setAttribute('href', newWebsite);
                elLink.childNodes[0].nodeValue = newWebsite;
                accessAddEvent(elLink, newWebsite);
            }
        } else {
            accessRemoveChildsOfElement(elDiv);
            objText = document.createTextNode('{$_CORELANG['TXT_ACCESS_NO_SPECIFIED']}');
            elDiv.appendChild(objText);
        }
    }
}
// ]]>
</script>
JSaccessSetWebsite
                ,'accessAddEvent' => <<<JSaccessAddEvent
<script type="text/javascript">
// <![CDATA[
function accessAddEvent( obj, url )
{
    strMsg1 = '{$_CORELANG['TXT_ACCESS_URL_OPEN_RISK_MSG']}';
    strMsg1 = strMsg1.replace('%s', url)
    strMsg2 = '{$_CORELANG['TXT_ACCESS_CONFIRM_OPEN_URL']}';

    if (obj.addEventListener) {
        obj.setAttribute('onclick', "return confirm('"+strMsg1+"\\\\n"+strMsg2+"');");
    } else if (obj.attachEvent) {
        obj.onclick = function() {return confirm(strMsg1+'\\n'+strMsg2);};
    }
}
// ]]>
</script>
JSaccessAddEvent
                ,'accessRemoveChildsOfElement' => <<<JSaccessRemoveChildsOfElement
<script type="text/javascript">
// <![CDATA[
function accessRemoveChildsOfElement(obj)
{
    for (i = obj.childNodes.length - 1 ; i >= 0 ; i--) {
        obj.removeChild(obj.childNodes[i]);
    }
}
// ]]>
</script>
JSaccessRemoveChildsOfElement
                ,
                'accessSelectAllGroups'    => <<<JSaccessSelectAllGroups
<script type="text/javascript">
// <![CDATA[
function accessSelectAllGroups(CONTROL)
{
    for (var i = 0;i < CONTROL.length;i++)
    {
        CONTROL.options[i].selected = true;
    }
}
// ]]>
</script>
JSaccessSelectAllGroups
                ,
                'accessDeselectAllGroups'    => <<<JSaccessDeselectAllGroups
<script type="text/javascript">
// <![CDATA[
function accessDeselectAllGroups(CONTROL)
{
    for (var i = 0;i < CONTROL.length;i++)
    {
        CONTROL.options[i].selected = false;
    }
}
// ]]>
</script>
JSaccessDeselectAllGroups
                ,
                'accessAddGroupToList'    => <<<JSaccessAddGroupToList
<script type="text/javascript">
// <![CDATA[
function accessAddGroupToList(from, dest)
{
    if ( from.selectedIndex < 0) {
        if (from.options[0] != null) {
            from.options[0].selected = true;
        }
        from.focus();
        return false;
    } else {
        for (var i=0; i<from.length; i++) {
            if (from.options[i].selected) {
                dest.options[dest.length] = new Option( from.options[i].text, from.options[i].value, false, false);
               }
        }
        for (var i=from.length-1; i>=0; i--) {
            if (from.options[i].selected) {
               from.options[i] = null;
               }
        }
    }
}
// ]]>
</script>
JSaccessAddGroupToList
                ,
                'accessRemoveGroupFromList'    => <<<JSaccessRemoveGroupFromList
<script type="text/javascript">
// <![CDATA[
function accessRemoveGroupFromList(from,dest)
{
    if ( dest.selectedIndex < 0) {
        if (dest.options[0] != null) {
            dest.options[0].selected = true;
        }
        dest.focus();
        return false;
    } else {
        for (var i=0; i<dest.options.length; i++) {
            if (dest.options[i].selected) {
                from.options[from.options.length] = new Option( dest.options[i].text, dest.options[i].value, false, false);
               }
        }
        for (var i=dest.options.length-1; i>=0; i--) {
            if (dest.options[i].selected) {
               dest.options[i] = null;
               }
        }
    }
}
// ]]>
</script>
JSaccessRemoveGroupFromList
                ,
                'accessGetFileBrowser' => <<<JSaccessGetFileBrowser
<script type="text/javascript">
// <![CDATA[
accessProcessingUrlElement = '';
accessProcessingUrlElementType = 'image';
function accessGetFileBrowser(elementId, type)
{
    accessProcessingUrlElement = elementId;
    if (type) {
        accessProcessingUrlElementType = type;
    }
    accessPopup = window.open('index.php?cmd=fileBrowser&standalone=true&type='+accessProcessingUrlElementType,'','width=800,height=600,resizable=yes,status=no,scrollbars=yes');
    accessPopup.focus();
}
// ]]>
</script>
JSaccessGetFileBrowser
                ,
                'accessSetUrl' => <<<JSaccessSetUrl
<script type="text/javascript">
// <![CDATA[
function SetUrl(url, width, height, alt)
{
    switch (accessProcessingUrlElementType) {
        case 'webpages':
            accessSetWebpage(url, width, height, alt);
            break;

        case 'image':
            accessSetImage(url, width, height, alt);
            break;
    }
}
// ]]>
</script>
JSaccessSetUrl
                ,
                'accessSetWebpage' => <<<JSaccessSetWebpage
<script type="text/javascript">
// <![CDATA[

function accessSetWebpage(url, width, height, alt)
{

        document.getElementById(accessProcessingUrlElement).value = url;
}
// ]]>
</script>
JSaccessSetWebpage
                ,
                'accessSetImage' => <<<JSaccessSetImage
<script type="text/javascript">
// <![CDATA[
function accessSetImage(url, width, height, alt)
{
    if (accessProcessingUrlElement.length) {
        maxPicWidth = {$arrSettings['max_pic_width']['value']};
        maxPicHeight = {$arrSettings['max_pic_height']['value']};

        // set the size of the picture layer and the zoom factor for the image
        if (width > maxPicWidth) {
            imgFactorWidth = 1 / width * (maxPicWidth);
        }
        if (height > maxPicHeight) {
            imgFactorHeight = 1 / height * (maxPicHeight);
        }

        // check if the image have to be zoom
        if (typeof(imgFactorWidth) != 'undefined') {
            if (typeof(imgFactorHeight) != 'undefined') {
                if (imgFactorWidth < imgFactorHeight) {
                    imgFactor = imgFactorWidth;
                } else {
                    imgFactor = imgFactorHeight;
                }
            } else {
                imgFactor = imgFactorWidth;
            }
        } else {
            if (typeof(imgFactorHeight) != 'undefined') {
                imgFactor = imgFactorHeight;
            } else {
                imgFactor = 1;
            }
        }

        // zoom the image if necessary
        if (imgFactor != 1) {
            document.getElementById(accessProcessingUrlElement+'_image').style.width = width * imgFactor + "px";
            document.getElementById(accessProcessingUrlElement+'_image').style.height = height * imgFactor + "px";
            intZoom = imgFactor;
        }

        document.getElementById(accessProcessingUrlElement+'_image').src = url;
        document.getElementById(accessProcessingUrlElement).value = url;
        accessProcessingUrlElement = '';
    }
}
// ]]>
</script>
JSaccessSetImage
                ,
                'confirmUserNotification' => <<<JSconfirmUserNotification
<script type="text/javascript">
// <![CDATA[
function confirmUserNotification(elementIdStatusStorage, status)
{
    if (typeof(accessUserInitialStatus) == 'undefined') {
        accessUserInitialStatus = !status;
    }
    if (status != accessUserInitialStatus) {
        document.getElementById(elementIdStatusStorage).value = Number(confirm('{$_ARRAYLANG['TXT_ACCESS_CONFIRM_USER_NOTIFY_ABOUT_ACCOUNT_STATUS']}'));
    } else {
        document.getElementById(elementIdStatusStorage).value = Number(false);
    }
}
// ]]>
</script>
JSconfirmUserNotification
                ,
                'accessAssignGroupToUser' => <<<JSaccessAssignGroupToUser
<script type="text/javascript">
// <![CDATA[
function accessAssignGroupToUser(elPrimaryGroupMenu, from, dest)
{
    addGroup = false;
    for (var i=0; i<from.length; i++) {
        if (from.options[i].value == elPrimaryGroupMenu.value) {
            from.options[i].selected = true;
            addGroup = true;
        } else {
            from.options[i].selected = false;
        }
    }
    addGroup ? accessAddGroupToList(from, dest) : false;
}
// ]]>
</script>
JSaccessAssignGroupToUser
                ,
                'accessValidatePrimaryGroupAssociation' => <<<JSaccessValidatePrimaryGroupAssociation
<script type="text/javascript">
// <![CDATA[
function accessValidatePrimaryGroupAssociation(elAssignedGroupBox)
{
    elPrimaryGroupMenu = document.getElementById('access_user_primary_group');
    if (elPrimaryGroupMenu.value) {
        groupAssigned = false;
        for (var i=0; i<elAssignedGroupBox.length; i++) {
            if (elAssignedGroupBox.options[i].value == elPrimaryGroupMenu.value) {
                groupAssigned = true;
                break;
            }
        }

        if (!groupAssigned) {
            if (elAssignedGroupBox.length) {
                elPrimaryGroupMenu.value = elAssignedGroupBox.options[0].value;
            } else {
                elPrimaryGroupMenu.value = 0;
            }
        }
    }
}

accessTmpFunction = accessRemoveGroupFromList;
accessRemoveGroupFromList = function(from, dest){
    accessTmpFunction(from, dest);
    accessValidatePrimaryGroupAssociation(dest);
}

// ]]>
</script>
JSaccessValidatePrimaryGroupAssociation
            );
        }

        $javaScriptCode = '';
        foreach ($this->arrAttachedJSFunctions as $function) {
            if (isset($arrFunctions[$function])) {
                $javaScriptCode .= $arrFunctions[$function]."\n";
            }
        }

        return $javaScriptCode;
    }


    protected function parseLetterIndexList($URI, $paramName, $selectedLetter)
    {
        global $_CORELANG;

        if ($this->_objTpl->blockExists('access_user_letter_index_list')) {
            $arrLetters[] = 48;
            $arrLetters = array_merge($arrLetters, range(65, 90)); // ascii codes of characters "A" to "Z"
            $arrLetters[] = '';

            foreach ($arrLetters as $letter) {
                switch ($letter) {
                    case 48:
                        $parsedLetter = '#';
                        break;

                    case '':
                        $parsedLetter = $_CORELANG['TXT_ACCESS_ALL'];
                        break;

                    default:
                        $parsedLetter = chr($letter);
                        break;
                }

                if ($letter == '' && $selectedLetter == '' || chr($letter) == $selectedLetter) {
                    $parsedLetter = '<strong>'.$parsedLetter.'</strong>';
                }

                $this->_objTpl->setVariable(array(
                    $this->modulePrefix.'USER_LETTER_INDEX_URI'        => $URI.(!empty($letter) ? '&amp;'.$paramName.'='.chr($letter) : null),
                    $this->modulePrefix.'USER_LETTER_INDEX_LETTER'    => $parsedLetter
                ));

                $this->_objTpl->parse('access_user_letter_index_list');
            }
        }
    }


    protected function detachAllJavaScriptFunctions()
    {
        $this->arrAttachedJSFunctions = array();
    }


    protected function attachJavaScriptFunction($function)
    {
        static $arrFunctionDependencies;

        if (empty($arrFunctionDependencies)) {
            $arrFunctionDependencies = array(
                'accessSetWebsite' => array(
                    'accessAddEvent',
                    'accessRemoveChildsOfElement'
                ),
                'accessSetWebpage' => array(
                    'accessGetFileBrowser',
                    'accessSetUrl'
                ),
                'accessSetImage' => array(
                    'accessGetFileBrowser',
                    'accessSetUrl'
                ),
                'accessAssignGroupToUser' => array(
                    'accessAddGroupToList',
                    'accessValidatePrimaryGroupAssociation'
                )
            );
        }

        if (!in_array($function, $this->arrAttachedJSFunctions)) {
            $this->arrAttachedJSFunctions[] = $function;
            if (isset($arrFunctionDependencies[$function])) {
                foreach ($arrFunctionDependencies[$function] as $dependendFunction) {
                    $this->attachJavaScriptFunction($dependendFunction);
                }
            }
        }
    }


    protected function addUploadedImagesToProfile($objUser, &$arrProfile, $arrImages)
    {
        global $_CORELANG;

        $arrErrorMsg = array();

        foreach ($arrImages['name'] as $attribute => $arrHistories) {
            foreach ($arrHistories as $historyId => $data) {
                $arrUploadedImages = array();
                if ($historyId === 'new') {
                    foreach (array_keys($data) as $historyIndex) {
                        $arrUploadedImages[] = array(
// TODO: What is contrexx_stripslashes good for here?
                            'name'            => contrexx_stripslashes($arrImages['name'][$attribute][$historyId][$historyIndex]),
                            'tmp_name'        => $arrImages['tmp_name'][$attribute][$historyId][$historyIndex],
                            'error'            => $arrImages['error'][$attribute][$historyId][$historyIndex],
                            'size'            => $arrImages['size'][$attribute][$historyId][$historyIndex],
                            'history_index'    => $historyIndex
                        );
                    }
                } else {
                    $arrUploadedImages[] = array(
// TODO: What is contrexx_stripslashes good for here?
                        'name'        => contrexx_stripslashes($arrImages['name'][$attribute][$historyId]),
                        'tmp_name'    => $arrImages['tmp_name'][$attribute][$historyId],
                        'error'        => $arrImages['error'][$attribute][$historyId],
                        'size'        => $arrImages['size'][$attribute][$historyId]
                    );
                }

                foreach ($arrUploadedImages as $arrImage) {
                    if ($arrImage['error'] === UPLOAD_ERR_OK) {
                        if (!$this->isImageWithinAllowedSize($arrImage['size'], $attribute == 'picture')) {
                            $objAttribute = $objUser->objAttribute->getById($attribute);
                            $arrErrorMsg[] = sprintf($_CORELANG['TXT_ACCESS_PIC_TOO_BIG'], htmlentities($objAttribute->getName(), ENT_QUOTES, CONTREXX_CHARSET));
                            continue;
                        }
                        // move uploaded image to ASCMS_TEMP_PATH
                        /*if (($tmpImageName = $this->loadUploadedImage($arrImage['tmp_name'], $arrImage['name'])) === false) {
                            continue;
                        }*/

                        // resize image and put it into place (ASCMS_ACCESS_PHOTO_IMG_PATH / ASCMS_ACCESS_PROFILE_IMG_PATH)
                        if (($imageName = $this->moveUploadedImageInToPlace($objUser, $arrImage['tmp_name'], $arrImage['name'], $attribute == 'picture')) === false) {
                            /*$this->unloadUploadedImage($tmpImageName);*/
                            continue;
                        }

                        // create thumbnail
                        if ($this->createThumbnailOfImage($imageName, $attribute == 'picture') !== false) {
                            if ($historyId === 'new') {
                                $arrProfile[$attribute][$historyId][$arrImage['history_index']] = $imageName;
                            } else {
                                $arrProfile[$attribute][$historyId] = $imageName;
                            }
                        }

                        /*$this->unloadUploadedImage($tmpImageName);*/
                    }
                }
            }
        }

        if (count($arrErrorMsg)) {
            return $arrErrorMsg;
        } else {
            return true;
        }
    }


    private function isImageWithinAllowedSize($size, $profilePic)
    {
        $arrSettings = User_Setting::getSettings();
        return $size <= $arrSettings['max_'.($profilePic ? 'profile_' : '').'pic_size']['value'];
    }


    private function moveUploadedImageInToPlace($objUser, $tmpImageName, $name, $profilePic = false)
    {
        static $objImage, $arrSettings;

        if (empty($objImage)) {
            $objImage = new ImageManager();
        }
        if (empty($arrSettings)) {
            $arrSettings = User_Setting::getSettings();
        }

        $imageRepo = $profilePic ? ASCMS_ACCESS_PROFILE_IMG_PATH : ASCMS_ACCESS_PHOTO_IMG_PATH;
        $index = 0;
        $imageName = $objUser->getId().'_'.$name;
        while (file_exists($imageRepo.'/'.$imageName)) {
            $imageName = $objUser->getId().'_'.++$index.'_'.$name;
        }

        if (!$objImage->loadImage($tmpImageName)) {
            return false;
        }

        // resize image if its dimensions are greater than allowed
        if ($objImage->orgImageWidth > $arrSettings['max_'.($profilePic ? 'profile_' : '').'pic_width']['value'] ||
            $objImage->orgImageHeight > $arrSettings['max_'.($profilePic ? 'profile_' : '').'pic_height']['value']
        ) {
            $ratioWidth = $arrSettings['max_'.($profilePic ? 'profile_' : '').'pic_width']['value'] / $objImage->orgImageWidth;
            $ratioHeight = $arrSettings['max_'.($profilePic ? 'profile_' : '').'pic_height']['value'] / $objImage->orgImageHeight;
            if ($ratioHeight > $ratioWidth) {
                $newWidth = $objImage->orgImageWidth * $ratioWidth;
                $newHeight = $objImage->orgImageHeight * $ratioWidth;
            } else {
                $newWidth = $objImage->orgImageWidth * $ratioHeight;
                $newHeight = $objImage->orgImageHeight * $ratioHeight;
            }

            if (!$objImage->resizeImage(
                $newWidth,
                $newHeight,
                100
            )) {
                return false;
            }

            // copy image to the image repository
            if (!$objImage->saveNewImage($imageRepo.'/'.$imageName)) {
                return false;
            }
        } else {
            if (!copy($tmpImageName, $imageRepo.'/'.$imageName)) {
                return false;
            }
        }

        return $imageName;
    }


    private function createThumbnailOfImage($imageName, $profilePic=false)
    {
        static $objImage, $arrSettings;

        if (empty($objImage)) {
            $objImage = new ImageManager();
        }
        if (empty($arrSettings)) {
            $arrSettings = User_Setting::getSettings();
        }

        if ($profilePic) {
            if (!$objImage->loadImage(ASCMS_ACCESS_PROFILE_IMG_PATH.'/'.$imageName)) {
                return false;
            }

            $rationWidth = $objImage->orgImageWidth / $arrSettings['profile_thumbnail_pic_width']['value'];
            $rationHeight = $objImage->orgImageHeight / $arrSettings['profile_thumbnail_pic_height']['value'];

            if ($arrSettings['profile_thumbnail_method']['value'] == 'crop') {
                if ($rationWidth < $rationHeight) {
                    $objImage->orgImageHeight = $objImage->orgImageHeight / $rationHeight * $rationWidth;
                } else {
                    $objImage->orgImageWidth = $objImage->orgImageWidth / $rationWidth * $rationHeight;
                }

                if (!$objImage->resizeImage(
                    $arrSettings['profile_thumbnail_pic_width']['value'],
                    $arrSettings['profile_thumbnail_pic_height']['value'],
                    70
                )) {
                    return false;
                }
            } else {
                $ration = max($rationWidth, $rationHeight);
                $objImage->addBackgroundLayer(sscanf($arrSettings['profile_thumbnail_scale_color']['value'], '#%2X%2x%2x'),
                                                $arrSettings['profile_thumbnail_pic_width']['value'],
                                                $arrSettings['profile_thumbnail_pic_height']['value']);
            }

            $thumb_name = ImageManager::getThumbnailFilename($imageName);
            return $objImage->saveNewImage(ASCMS_ACCESS_PROFILE_IMG_PATH.'/'.$thumb_name);
        } else {
            return $objImage->_createThumbWhq(
                ASCMS_ACCESS_PHOTO_IMG_PATH.'/',
                ASCMS_ACCESS_PHOTO_IMG_WEB_PATH.'/',
                $imageName,
                $arrSettings['max_thumbnail_pic_width']['value'],
                $arrSettings['max_thumbnail_pic_height']['value'],
                70
            );
        }
    }


    protected function removeUselessImages()
    {
        global $objDatabase;

        // Regex matching folders and files not to be deleted
        $noAvatarThumbSrc = ImageManager::getThumbnailFilename(
            User_Profile::$arrNoAvatar['src']);
        $noPictureThumbSrc = ImageManager::getThumbnailFilename(
            User_Profile::$arrNoPicture['src']);
        $ignoreRe =
            '/(?:\.(?:\.?|svn)'.
            '|'.preg_quote(User_Profile::$arrNoAvatar['src'], '/').
            '|'.preg_quote($noAvatarThumbSrc, '/').
            '|'.preg_quote(User_Profile::$arrNoPicture['src'], '/').
            '|'.preg_quote($noPictureThumbSrc, '/').')$/';

        $arrTrueFalse = array(true, false);
        foreach ($arrTrueFalse as $profilePics) {
            $imagePath = ($profilePics
                ? ASCMS_ACCESS_PROFILE_IMG_PATH : ASCMS_ACCESS_PHOTO_IMG_PATH);
            $arrImages = array();
            $offset = 0;
            $step = 50000;
// TODO: Never used
//            $removeImages = array();

            if (CONTREXX_PHP5) {
                $arrImages = scandir($imagePath);
            } else {
// TODO: We're PHP5 *ONLY* now.  This is obsolete
                $dh  = opendir($imagePath);
                $image = readdir($dh);
                while ($image !== false) {
                    $arrImages[] = $image;
                    $image = readdir($dh);
                }
                closedir($dh);
            }
            foreach ($arrImages as $index => $file) {
                if (preg_match($ignoreRe, $file)) unset($arrImages[$index]);
            }

            if ($profilePics) {
                $query = "
                    SELECT SUM(1) as entryCount
                    FROM `".DBPREFIX."access_user_profile`
                    WHERE `picture` != ''";
            } else {
                $query = "
                    SELECT SUM(1) as entryCount
                    FROM `".DBPREFIX."access_user_attribute` AS a
                    INNER JOIN `".DBPREFIX."access_user_attribute_value` AS v ON v.`attribute_id` = a.`id`
                    WHERE a.`type` = 'image' AND v.`value` != ''";
            }

            $objCount = $objDatabase->Execute($query);
            if ($objCount !== false) {
                $count = $objCount->fields['entryCount'];
            } else {
                return false;
            }

            if ($profilePics) {
                $query = "
                    SELECT `picture`
                    FROM `".DBPREFIX."access_user_profile`
                    WHERE `picture` != ''";
            } else {
                $query = "
                    SELECT v.`value` AS picture
                    FROM `".DBPREFIX."access_user_attribute` AS a
                    INNER JOIN `".DBPREFIX."access_user_attribute_value` AS v ON v.`attribute_id` = a.`id`
                    WHERE a.`type` = 'image' AND v.`value` != ''";
            }

            while ($offset < $count) {
                $objImage = $objDatabase->SelectLimit($query, $step, $offset);
                if ($objImage !== false) {
                    $arrImagesDb = array();
                    while (!$objImage->EOF) {
                        $arrImagesDb[] = $objImage->fields['picture'];
                        $arrImagesDb[] = ImageManager::getThumbnailFilename(
                            $objImage->fields['picture']);
                        $objImage->MoveNext();
                    }
                    $offset += $step;
                    $arrImages = array_diff($arrImages, $arrImagesDb);
                }
            }
            array_walk($arrImages, create_function('$img', 'unlink("'.$imagePath.'/".$img);'));
        }

        return true;
    }


    /*function unloadUploadedImage($tmpImageName)
    {
        unlink(ASCMS_TEMP_PATH.'/'.$tmpImageName);
    }*/

    /*function loadUploadedImage($tmpName, $name)
    {
        $index = 0;
        $tmpImageName = $name;
        while (file_exists(ASCMS_TEMP_PATH.'/'.$tmpImageName)) {
            $tmpImageName = ++$index.$name;
        }

        if (move_uploaded_file($tmpName, ASCMS_TEMP_PATH.'/'.$tmpImageName)) {
            return $tmpImageName;
        } else {
            false;
        }
    }*/


    /*function _zoomProfilePic(&$picWidth, &$picHeight)
    {
        $arrSettings = User_Setting::getSettings();

        // set the size of the picture layer and the zoom factor for the image
        if ($picWidth > $arrSettings['max_pic_width']['value']) {
            $imgFactorWidth = 1 / $picWidth * $arrSettings['max_pic_width']['value'];
        }
        if ($picHeight > $arrSettings['max_pic_height']['value']) {
            $imgFactorHeight = 1 / $picHeight * ($arrSettings['max_pic_height']['value']);
        }

        // check if the image have to be zoom
        if (isset($imgFactorWidth)) {
            if (isset($imgFactorHeight)) {
                if ($imgFactorWidth < $imgFactorHeight) {
                    $imgFactor = $imgFactorWidth;
                } else {
                    $imgFactor = $imgFactorHeight;
                }
            } else {
                $imgFactor = $imgFactorWidth;
            }
        } else {
            if (isset($imgFactorHeight)) {
                $imgFactor = $imgFactorHeight;
            } else {
                $imgFactor = 1;
            }
        }

        if ($imgFactor != 1) {
            $picWidth *= $imgFactor;
            $picHeight *= $imgFactor;
        }
    }*/


    /**
     * Parse a user's newsletter-list subscription interface
     * @param User  User object of whoem the newsletter-list subscriptions shall be parsed
     */
    protected function parseNewsletterLists($objUser)
    {
        global $_CONFIG, $objDatabase, $objInit;

        if (!$this->_objTpl->blockExists('access_newsletter')) return;

        if (\Cx\Core_Modules\License\License::getCached($_CONFIG, $objDatabase)->isInLegalComponents('newsletter')) {
            $arrSubscribedNewsletterListIDs = $objUser->getSubscribedNewsletterListIDs();
            $arrNewsletterLists = NewsletterLib::getLists();

            if (!count($arrNewsletterLists)) {
                $this->_objTpl->hideBlock('access_newsletter_list');
                return;
            }

            $row = 0;
            foreach ($arrNewsletterLists as $listId => $arrList) {
                if ($objInit->mode != 'backend' && !$arrList['status'] && !in_array($listId, $arrSubscribedNewsletterListIDs)) {
                    continue;
                }

                $this->_objTpl->setVariable(array(
                    $this->modulePrefix.'NEWSLETTER_ID'        => $listId,
                    $this->modulePrefix.'NEWSLETTER_NAME'      => contrexx_raw2xhtml($arrList['name']),
                    $this->modulePrefix.'NEWSLETTER_SELECTED'  => in_array($listId, $arrSubscribedNewsletterListIDs) ? 'checked="checked"' : '',
                    $this->modulePrefix.'NEWSLETTER_ROW_CLASS' => ($row++ % 2) + 1,
                ));
                $this->_objTpl->parse('access_newsletter_list');
            }

            $this->_objTpl->touchBlock('access_newsletter');
            if ($this->_objTpl->blockExists('access_newsletter_tab')) $this->_objTpl->touchBlock('access_newsletter_tab');
        } else {
            $this->_objTpl->hideBlock('access_newsletter');
            if ($this->_objTpl->blockExists('access_newsletter_tab')) $this->_objTpl->hideBlock('access_newsletter_tab');
        }
    }


    /**
     * Returns the password information string
     *
     * The string returned depends on the password complexity setting
     * @return  string          The password complexity information
     * @author  Reto Kohli <reto.kohli@comvation.com>
     */
    public static function getPasswordInfo()
    {
        global $_CONFIG, $_ARRAYLANG;

// FIX: Load access language entries if missing.
// Note that this may be used by other modules, i.e. the shop.
        if (empty($_ARRAYLANG['TXT_ACCESS_PASSWORD_MINIMAL_CHARACTERS'])) {
            global $objInit;
            $objInit->loadLanguageData('access');
        }
        if (   isset($_CONFIG['passwordComplexity'])
            && $_CONFIG['passwordComplexity'] == 'on') {
            return $_ARRAYLANG['TXT_ACCESS_PASSWORD_MINIMAL_CHARACTERS_WITH_COMPLEXITY'];
        }
        return $_ARRAYLANG['TXT_ACCESS_PASSWORD_MINIMAL_CHARACTERS'];
    }

}
