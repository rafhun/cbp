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
 * Library Class CRM
 * CrmLibrary class
 *
 * @category   CrmLibrary
 * @package    contrexx
 * @subpackage module_crm
 * @author     SoftSolutions4U Development Team <info@softsolutions4u.com>
 * @copyright  2012 and CONTREXX CMS - COMVATION AG
 * @license    trial license
 * @link       www.contrexx.com
 */

define('CRM_MODULE_LIB_PATH', ASCMS_MODULE_PATH.'/crm/lib/');
define('CRM_ACCESS_PROFILE_IMG_WEB_PATH', ASCMS_PATH_OFFSET.ASCMS_IMAGES_FOLDER.'/crm/profile');
define('CRM_ACCESS_PROFILE_IMG_PATH',     ASCMS_DOCUMENT_ROOT.ASCMS_IMAGES_FOLDER.'/crm/profile');
define('CRM_ACCESS_OTHER_IMG_WEB_PATH', ASCMS_PATH_OFFSET.ASCMS_IMAGES_FOLDER.'/crm');
define('CRM_ACCESS_OTHER_IMG_PATH',     ASCMS_DOCUMENT_ROOT.ASCMS_IMAGES_FOLDER.'/crm');
define('CRM_MEDIA_PATH', ASCMS_MEDIA_PATH.'/crm/');

define('CRM_EVENT_ON_USER_ACCOUNT_CREATED', 'crm_user_account_created');
define('CRM_EVENT_ON_TASK_CREATED', 'crm_task_assigned');
define('CRM_EVENT_ON_ACCOUNT_UPDATED', 'crm_notify_staff_on_contact_added');

/**
 * Library Class CRM
 * CrmLibrary class
 *
 * @category   CrmLibrary
 * @package    contrexx
 * @subpackage module_crm
 * @author     SoftSolutions4U Development Team <info@softsolutions4u.com>
 * @copyright  2012 and CONTREXX CMS - COMVATION AG
 * @license    trial license
 * @link       www.contrexx.com
 */
class CrmLibrary
{
    /**
    * Csv seperator
    *
    * @access private
    * @var String
    */
    var $_csvSeparator          = ';';

    /**
    * Module Name
    *
    * @access private
    * @var string
    */
    var $moduleName             = 'crm';

    /**
    * PM Module Name
    *
    * @access private
    * @var string
    */
    var $pm_moduleName          = 'pm';

    /**
    * PM Module Status
    *
    * @access private
    * @var boolean
    */
    var $isPmInstalled          = false;

    /**
    * Admin Access Id
    *
    * @access public
    * @var integer
    */
    var $adminAccessId          = 557;

    /**
    * Customer Access Id
    *
    * @access public
    * @var integer
    */
    var $customerAccessId       = 556;

    /**
    * Settings value stored in array
    *
    * @access public
    * @var array
    */
    var $_arrSettings           = array();

    /**
    * All Countries name take it as array
    *
    * @access public
    * @var array
    */
    var $countries              = array();

    /**
    * All customer types take it as array
    *
    * @access public
    * @var array
    */
    var $customerTypes          = array();

    /**
    * All Languages take it as array
    *
    * @access public
    * @var array
    */
    var $_arrLanguages          = array();

    /**
    * All Memberships take it as array
    *
    * @access public
    * @var array
    */
    var $_memberShips           = array();

    /**
    * Email Options
    *
    * @access public
    * @var array
    */
    var $emailOptions           = array("TXT_CRM_HOME", "TXT_CRM_WORK", "TXT_CRM_OTHERS");

    /**
    * Phone Options
    *
    * @access public
    * @var array
    */
    var $phoneOptions           = array("TXT_CRM_HOME", "TXT_CRM_WORK", "TXT_CRM_MOBILE", "TXT_CRM_FAX", "TXT_CRM_DIRECT", "TXT_CRM_OTHERS");

    /**
    * Website Options
    *
    * @access public
    * @var array
    */
    var $websiteOptions         = array("TXT_CRM_HOME", "TXT_CRM_WORK", "TXT_CRM_BUSINESS1", "TXT_CRM_BUSINESS2", "TXT_CRM_BUSINESS3", "TXT_CRM_PRIVATE", "TXT_CRM_OTHERS");

    /**
    * Website Profile Options
    *
    * @access public
    * @var array
    */
    var $websiteProfileOptions  = array("TXT_CRM_HOME", "TXT_CRM_WORK", "TXT_CRM_OTHERS", "TXT_CRM_BUSINESS1", "TXT_CRM_BUSINESS2", "TXT_CRM_BUSINESS3");

    /**
    * Social Profile Options
    *
    * @access public
    * @var array
    */
    var $socialProfileOptions   = array("", "TXT_CRM_SKYPE", "TXT_CRM_TWITTER", "TXT_CRM_LINKEDIN", "TXT_CRM_FACEBOOK", "TXT_CRM_LIVEJOURNAL",
            "TXT_CRM_MYSPACE", "TXT_CRM_GMAIL", "TXT_CRM_BLOGGER", "TXT_CRM_YAHOO", "TXT_CRM_MSN", "TXT_CRM_ICQ", "TXT_CRM_JABBER",
            "TXT_CRM_AIM", "TXT_CRM_GOOGLE_PLUS", "TXT_CRM_XING");

    /**
    * Address Values
    *
    * @access public
    * @var array
    */
    var $addressValues          = array(
                                        "",
                                        array('label' => 'address', 'lang_variable' => "TXT_CRM_ADDRESS"), 
                                        array('label' => 'city', 'lang_variable' => "TXT_CRM_CITY"), 
                                        array('label' => 'state', 'lang_variable' => "TXT_CRM_STATE"),
                                        array('label' => 'zip', 'lang_variable' => "TXT_CRM_ZIP"), 
                                        array('label' => 'country', 'lang_variable' => "TXT_CRM_COUNTRY"),
                                        "type"
                                  );

    /**
    * Address Types
    *
    * @access public
    * @var array
    */
    var $addressTypes           = array("TXT_CRM_HOME", "TXT_CRM_DELIVERY", "TXT_CRM_OFFICE", "TXT_CRM_BILLING", "TXT_CRM_OTHERS", "TXT_CRM_WORK");

    /**
     * Status message
     *
     * @access private
     * @var string
     */
    var $_statusMessage = '';

    /**
     * Status Ok message
     *
     * @access private
     * @var string
     */
    var $_strOkMessage  = '';

    /**
     * Status Error message
     *
     * @access private
     * @var string
     */
    var $_strErrMessage  = '';

    /**
     * Status Warning message
     *
     * @access private
     * @var string
     */
    var $_strWarMessage  = '';

    /**
     * Support Case Status
     *
     * @access private
     * @var array
     */
    var $supportCaseStatus = array(
            0 => 'Open',
            1 => 'Pending',
            2 => 'Closed'
    );

    /**
     * object for loading class
     *
     * @access protected
     * @var object
     */
    protected $load;

    /**
     * Class Object
     *
     * @access protected
     * @var object
     */
    protected static $instance;


    /**
     * Initialize a class
     *
     * @return object
     */
    public static function init()
    {
        if (is_null(self::$instance)) {
            $class = __CLASS__;
            self::$instance = new $class;
        }

        return self::$instance;
    }

    /**
     * constructor
     */
    function __construct()
    {
        $this->_arrLanguages = $this->createLanguageArray();
        $this->isPmInstalled = contrexx_isModuleActive($this->pm_moduleName);
    }

    /**
     * Get the Settings value from the DB
     *
     * @global ADO Connection $objDatabase
     *
     * @return array Setting values
     */
    function getSettings()
    {
        global $objDatabase;

        if (!empty($this->_arrSettings)) {
            return $this->_arrSettings;
        }

        $query = "SELECT `setid`, `setname`, `setvalue` FROM ".DBPREFIX."module_{$this->moduleName}_settings";
        $settings = $objDatabase->execute($query);

        if (false !== $settings) {
            while (!$settings->EOF) {
                $this->_arrSettings[$settings->fields['setname']] = $settings->fields['setvalue'];
                $settings->moveNext();
            }
        }

        return $this->_arrSettings;
    }

    /**
     * Creates an array containing all frontend-languages. Example: $arrValue[$langId]['short'] or $arrValue[$langId]['long']
     *
     * @global  ADONewConnection $objDatabase
     *
     * @return  array $arrReturn
     */
    function createLanguageArray()
    {
        global $objDatabase;

        $arrReturn = array();

        $objResult = $objDatabase->Execute('SELECT      id,
                                                        lang,
                                                        name
                                            FROM        '.DBPREFIX.'languages
                                            WHERE       frontend=1
                                            ORDER BY    id
                                        ');
        while (!$objResult->EOF) {
            $arrReturn[$objResult->fields['id']] = array(   'short' =>  stripslashes($objResult->fields['lang']),
                    'long'  =>  htmlentities(stripslashes($objResult->fields['name']), ENT_QUOTES, CONTREXX_CHARSET)
            );
            $objResult->MoveNext();
        }

        return $arrReturn;
    }

    /**
     * Usort for multiple key values
     *
     * @param Integer $key       key values
     * @param String  $direction sorting order
     *
     * @return integer
     */
    function _usortByMultipleKeys($key, $direction=SORT_ASC)
    {
        if ($direction == 0) {
            $direction = SORT_ASC;
        } else if ($direction == 1) {
            $direction = SORT_DESC;
        }

        $sortFlags = array(SORT_ASC, SORT_DESC);
        if (!in_array($direction, $sortFlags)) {
            throw new InvalidArgumentException('Sort flag only accepts SORT_ASC or SORT_DESC');
        }
        return function ($a, $b) use ($key, $direction, $sortFlags) {
            if (!is_array($key)) { //just one key and sort direction
                if (!isset($a[$key]) || !isset($b[$key])) {
//                  throw new Exception('Attempting to sort on non-existent keys');
                }
                if ($a[$key] == $b[$key]) {
                    return 0;
                }
                return ($direction==SORT_ASC xor strtolower($a[$key]) < strtolower($b[$key])) ? 1 : -1;
            } else { //using multiple keys for sort and sub-sort
                foreach ($key as $subKey => $subAsc) {
                    //array can come as 'sort_key'=>SORT_ASC|SORT_DESC or just 'sort_key', so need to detect which
                    if (!in_array($subAsc, $sortFlags)) {
                        $subKey = $subAsc;
                        $subAsc = $direction;
                    }
                    //just like above, except 'continue' in place of return 0
                    if (!isset($a->$subKey) || !isset($b->$subKey)) {
                        throw new Exception('Attempting to sort on non-existent keys');
                    }
                    if ($a->$subKey == $b->$subKey) {
                        continue;
                    }
                    return ($subAsc==SORT_ASC xor $a->$subKey < $b->$subKey) ? 1 : -1;
                }
                return 0;
            }
        };
    }

    /**
     *  Save Task Type values to DB
     *
     * @param Integer $id task type id
     *
     * @global ADO Connection $objDatabase
     *
     * @return null
     */
    function saveTaskTypes($id = 0)
    {
        global $objDatabase;

        $name       = isset($_POST['name']) ? contrexx_input2db($_POST['name']) : '';
        $active     = isset($_POST['active']) ? 1 : 0;
        $sortOrder  = isset($_POST['sort']) ? (int) $_POST['sort'] : 0;
        $description= isset($_POST['description']) ? contrexx_input2db($_POST['description']) : '';
        $icon       = isset($_POST['icon']) ? contrexx_input2db($_POST['icon']) : '';

        $where = '';
        if ($id)
            $where = "WHERE `id` = $id";

        $Update = ($id) ? "UPDATE" : "INSERT INTO";
        $query = "$Update `".DBPREFIX."module_{$this->moduleName}_task_types`
                        SET `name` = '$name',
                            `status` = $active,
                            `sorting` = $sortOrder,
                            `description` = '$description',
                            `icon`        = '$icon'
                $where";
        $objDatabase->Execute($query);
    }

    /**
     *  Show all the Task Types
     *
     * @global Array          $_ARRAYLANG
     * @global ADO Connection $objDatabase
     *
     * @return null
     */
    function showTaskTypes()
    {
        global $_ARRAYLANG, $objDatabase;

        $objTpl = $this->_objTpl;
        $objTpl->addBlockfile('CRM_TASK_TYPES_TABLE_FILE', 'settings_tasktype', 'module_'.$this->moduleName.'_settings_task_type_table.html');

        $objResult = $objDatabase->Execute("SELECT * FROM `".DBPREFIX."module_{$this->moduleName}_task_types` ORDER BY `sorting`");

        if (isset($_GET['sortf']) && isset($_GET['sorto'])) {
            $sortf = ($_GET['sortf'] == 1)? 'name':'sorting';
            $sorto = ($_GET['sorto'] == 'ASC')? 'DESC' : 'ASC';
            $query = "SELECT * FROM `".DBPREFIX."module_{$this->moduleName}_task_types` ORDER BY $sortf $sorto";
            $objResult      = $objDatabase->Execute($query);
        }

        if ($objResult->RecordCount()) {
            $objTpl->hideBlock("noTasktypes");
        } else {
            $objTpl->touchBlock("noTasktypes");
            $objTpl->hideBlock("taskTypes");
        }

        if ($objResult) {
            $row = "row2";
            while (!$objResult->EOF) {
                $iconPath = '';
                $status   = ($objResult->fields['status']) ? "led_green.gif" : "led_red.gif";

                if ($objResult->fields['system_defined']) {
                    $objTpl->hideBlock('delete_icon_block');
                } else {
                    $objTpl->touchBlock('delete_icon_block');
                }
                if (!empty ($objResult->fields['icon'])) {
                    $iconPath = CRM_ACCESS_OTHER_IMG_WEB_PATH.'/'.contrexx_raw2xhtml($objResult->fields['icon'])."_24X24.thumb";
                } else {
                    $iconPath  = '../modules/crm/View/Media/task_default.png';
                }
                $objTpl->setVariable(array(
                        'CRM_TASK_TYPE_ID'          => (int) $objResult->fields['id'],
                        'CRM_TASK_TYPE_NAME'        => contrexx_raw2xhtml($objResult->fields['name']),
                        'CRM_TASK_TYPE_SORTING'     => (int) $objResult->fields['sorting'],
                        'CRM_TASK_TYPE_ICON'        => $iconPath,
                        'CRM_TASK_TYPE_ACTIVE'      => $status,
                        'ROW_CLASS'                 => $row = ($row == "row2") ? "row1" : "row2",
                        'TXT_ORDER'                 => $sorto
                ));
                $objTpl->parse("taskTypes");
                $objResult->MoveNext();
            }
        }
    }

    /**
     * Get Modify Task type values From DB
     *
     * @param Integer $id Task type id
     *
     * @global ADO Connection $objDatabase
     * @global Array          $_ARRAYLANG
     *
     * @return null
     */
    function getModifyTaskTypes($id = 0)
    {
        global $objDatabase, $_ARRAYLANG;

        $objTpl = $this->_objTpl;
        $objTpl->addBlockfile('CRM_TASK_TYPES_MODIFY_FILE', 'settings_modify_taskType', 'module_'.$this->moduleName.'_settings_task_type_modify.html');

        $name       = isset($_POST['name']) && $id ? $_POST['name'] : '';
        $active     = isset($_POST['active']) || !$id ? 1 : 0;
        $sortOrder  = isset($_POST['sort']) && $id ? (int) $_POST['sort'] : '';
        $description= isset($_POST['description']) && $id ? $_POST['description'] : '';
        $icon       = isset($_POST['icon']) && $id ? $_POST['icon'] : '';

        if ($id) {
            $objResult = $objDatabase->SelectLimit("SELECT * FROM `".DBPREFIX."module_{$this->moduleName}_task_types` WHERE id = $id", 1);

            $name       = $objResult->fields['name'];
            $active     = ($objResult->fields['status']) ? 1 : 0;
            $sortOrder  = $objResult->fields['sorting'];
            $description= $objResult->fields['description'];
            $icon       = $objResult->fields['icon'];
        } else {
            $objTpl->hideBlock("taskBackButton");
        }

        $objTpl->setVariable(array(
                'CRM_TASK_TYPE_ID'          => $id,
                'CRM_TASK_TYPE_NAME'        => contrexx_raw2xhtml($name),
                'CRM_TASK_TYPE_SORTING'     => $sortOrder,
                'CRM_TASK_TYPE_DESCRIPTION' => contrexx_raw2xhtml($description),
                'CRM_TASK_TYPE_ICON'        => contrexx_raw2xhtml($icon),
                'CRM_TASK_TYPE_ADD_ACTIVE'  => (empty($_POST) && empty($id)) || ($active) ? "checked" : '',

                'TXT_CRM_ICON'                 => $_ARRAYLANG['TXT_CRM_ICON'],
                'TXT_CRM_TASK_TYPE_NAME'        => $_ARRAYLANG['TXT_CRM_TASK_TYPE_NAME'],
                'TXT_CRM_TASK_TYPE_SORTING'     => $_ARRAYLANG['TXT_CRM_TASK_TYPE_SORTING'],
                'TXT_CRM_TASK_TYPE_DESCRIPTION' => $_ARRAYLANG['TXT_CRM_TASK_TYPE_DESCRIPTION'],
                'TXT_CRM_TASK_TYPE_SORTING1'     => $_ARRAYLANG['TXT_CRM_TASK_TYPE_SORTING1'],
                'TXT_CRM_TASK_TYPE_ACTIVE'      => $_ARRAYLANG['TXT_CRM_TASK_TYPE_ACTIVE'],
                'TXT_CRM_SAVE'                      => $_ARRAYLANG['TXT_CRM_SAVE'],
                'TXT_BROWSE'                         => $_ARRAYLANG['TXT_BROWSE'],
        ));
    }

    /**
     * Get Tasktype Dropdown
     *
     * @param Object  $objTpl
     * @param Integer $selectedType
     *
     * @global ADO Connection $objDatabase
     * @global Array          $_ARRAYLANG
     *
     * @return null
     */
    function taskTypeDropDown($objTpl, $selectedType = 0)
    {
        global $objDatabase, $_ARRAYLANG;

        $objResult = $objDatabase->Execute("SELECT id, name, icon FROM ".DBPREFIX."module_{$this->moduleName}_task_types WHERE status=1 ORDER BY sorting");
        $first     = true;
        while (!$objResult->EOF) {
            $selected = $selectedType == $objResult->fields['id'] ? "selected" : '';
            if ($first || $selectedType == $objResult->fields['id']) {
                $objTpl->setVariable(array(
                    'DEFAULT_CRM_NOTES_TYPE_ID' => (int) $objResult->fields['id'],
                    'DEFAULT_CRM_NOTES_TYPE'    => contrexx_input2xhtml($objResult->fields['name'])
                ));
                $first = false;
            }
            if (!empty ($objResult->fields['icon'])) {
                $icons  = CRM_ACCESS_OTHER_IMG_WEB_PATH.'/'.contrexx_raw2xhtml($objResult->fields['icon'])."_24X24.thumb";
            } else {
                $icons  = '../modules/crm/View/Media/task_default.png';
            }
            $objTpl->setVariable(array(
                    'TXT_TASKTYPE_ID'       => (int) $objResult->fields['id'],
                    'TXT_TASKTYPE_NAME'     => contrexx_input2xhtml($objResult->fields['name']),
                    'TXT_TASKTYPE_IMAGE'    => $icons,
                    'TXT_TASKTYPE_SELECTED' => $selected,
            ));
            $objTpl->parse('Tasktype');
            $objResult->MoveNext();
        }
    }

    /**
     * Get Customer Types From DB
     *
     * @global ADO Connection $objDatabase
     *
     * @return Integer
     */
    function getCustomerTypes()
    {
        global $objDatabase;

        if (!empty($this->customerTypes)) return $this->customerTypes;

        $objResult = $objDatabase->Execute('SELECT id,label FROM  '.DBPREFIX.'module_'.$this->moduleName.'_customer_types WHERE  active!="0" ORDER BY pos,label');

        while (!$objResult->EOF) {
            $this->customerTypes[$objResult->fields['id']] = array(
                    'id'    => $objResult->fields['id'],
                    'label' => $objResult->fields['label']
            );
            $objResult->MoveNext();
        }

    }

    /**
     * Get Customertype Dropdown From DB
     *
     * @param Object  $objTpl
     * @param Integer $selectedId
     * @param String  $block
     * @param Array   $options
     *
     * @global Array $_ARRAYLANG
     *
     * @return null
     */
    function getCustomerTypeDropDown($objTpl, $selectedId = 0, $block = "customerTypes", $options = array()) {
        global $_ARRAYLANG;

        $this->getCustomerTypes();

        if ($options['is_hide'] && count($this->customerTypes) < 2) {
            $objTpl->hideBlock('block_customer_type');
        } else {
            if ($objTpl->blockExists('block_customer_type')) {
                $objTpl->touchBlock('block_customer_type');
            }
            foreach ($this->customerTypes as $key => $value) {

                $selected = ($value['id'] == $selectedId ) ? 'selected ="selected"' : '';
                $objTpl->setVariable(array(
                        'CRM_CUSTOMER_TYPE_SELECTED' => $selected,
                        'CRM_CUSTOMER_TYPE'          => contrexx_raw2xhtml($value['label']),
                        'CRM_CUSTOMER_TYPE_ID'       => (int) $value['id']));
                $objTpl->parse($block);
            }
        }


    }

    /**
     * Get Customer's Currency Dropdown From DB
     *
     * @param Template Object $objTpl
     * @param Integer         $selectedId
     * @param String          $block
     *
     * @global Array $_ARRAYLANG
     * @global ADO Connection $objDatabase
     *
     * @return null
     */
    function getCustomerCurrencyDropDown($objTpl, $selectedId = 0, $block = "currency")
    {
        global $_ARRAYLANG, $objDatabase;

        if (empty ($selectedId)) {
            $objDefaultCur = $objDatabase->getOne("SELECT id FROM `".DBPREFIX."module_{$this->moduleName}_currency` WHERE default_currency = 1");
            $selectedId    = $objDefaultCur;
        }
        $objResultCurrency = $objDatabase->Execute('SELECT   id,name,pos,active
                                                FROM     '.DBPREFIX.'module_'.$this->moduleName.'_currency
                                                WHERE    active!="0"
                                                ORDER BY pos,name');
        while (!$objResultCurrency->EOF) {
            //$selected = ($selectedId$contactObj->getCustomerCurrency() == $objResultCurrency->fields['id']) ? "selected" : '';
            $selected = ($selectedId == $objResultCurrency->fields['id']) ? "selected" : '';

            $objTpl->setVariable(array(
                    'CRM_CURRENCYNAME'      =>    contrexx_raw2xhtml($objResultCurrency->fields['name']),
                    'CRM_CURRENCYID'        =>    (int) $objResultCurrency->fields['id'],
                    'CRM_CURRENCY_SELECTED' =>    $selected,
            ));
            $objTpl->parse($block);
            $objResultCurrency->MoveNext();
        }
    }

    /**
     * Get Industry Type Dropdown From DB
     *
     * @param Object  $objTpl
     * @param Integer $selectedId
     * @param String  $block
     *
     * @global Array          $_ARRAYLANG
     * @global ADO Connection $objDatabase
     * @global Array          $_LANGID
     *
     * @return null
     */
    function getIndustryTypeDropDown($objTpl, $selectedId = 0, $block = "industryType")
    {
        global $_ARRAYLANG, $objDatabase, $_LANGID;

        $objResultIndustryType = $objDatabase->Execute("SELECT Intype.id,
                                                              Inloc.value
                                                         FROM `".DBPREFIX."module_{$this->moduleName}_industry_types` AS Intype
                                                         LEFT JOIN `".DBPREFIX."module_{$this->moduleName}_industry_type_local` AS Inloc
                                                            ON Intype.id = Inloc.entry_id
                                                         WHERE Inloc.lang_id = ".$_LANGID." AND Intype.status = 1 ORDER BY sorting ASC ");
        while (!$objResultIndustryType->EOF) {
            $selected = ($selectedId == $objResultIndustryType->fields['id']) ? "selected" : '';

            $objTpl->setVariable(array(
                    'CRM_INDUSTRY_TYPE_NAME'      =>    contrexx_raw2xhtml($objResultIndustryType->fields['value']),
                    'CRM_INDUSTRY_TYPE_ID'        =>    (int) $objResultIndustryType->fields['id'],
                    'CRM_INDUSTRY_TYPE_SELECTED'  =>    $selected,
            ));
            $objTpl->parse($block);
            $objResultIndustryType->MoveNext();
        }
    }

    /**
     * Parse the contacts
     *
     * @param Array $input input value
     *
     * @return Array
     */
    function parseContacts($input)
    {

        foreach ($input as $key => $value) {
            $splitKeys = explode("_", $key);
            switch ($splitKeys[0]) {
            case 'contactemail':
            case 'contactphone':
                    $result[$splitKeys[0]][] = array('type' => $splitKeys[2], 'primary' => $splitKeys[3], 'value' => $value);
                break;
            case 'contactwebsite':
            case 'contactsocial':
                    $result[$splitKeys[0]][$splitKeys[1]] = array('profile' => $splitKeys[2], 'primary' => $splitKeys[3], 'value' => $value);
                break;
            case 'website':
                    $result['contactwebsite'][$splitKeys[1]]['id'] = $value;
                break;
            case 'contactAddress':
                if ($this->addressValues[$splitKeys[2]]['label'] == "address") $result[$splitKeys[0]][$splitKeys[1]]["primary"] = $splitKeys[3];
                $label = is_array($this->addressValues[$splitKeys[2]]) ? $this->addressValues[$splitKeys[2]]['label'] : $this->addressValues[$splitKeys[2]];
                $result[$splitKeys[0]][$splitKeys[1]][$label] = $value;
                break;
            default:
                    $result[$key] = $value;
                break;
            }
        }

        return $result;
    }

    /**
     * Get the contact Address Country value From DB
     *
     * @param Template Object $objTpl
     * @param Integer         $selectedCountry
     * @param String          $block
     *
     * @return null
     */
    function getContactAddressCountry($objTpl, $selectedCountry, $block = "crmCountry")
    {
        $countryArr = $this->getCountry();
        $settings = $this->getSettings();

        if (empty($selectedCountry)) {
            $selectedCountry = $countryArr[$settings['default_country_value']]['name'];
        }

        foreach ($countryArr as $value) {
            $selected = ($selectedCountry == contrexx_raw2xhtml($value['name'])) ? "selected" : "";
            $objTpl->setVariable(array(
                    'CRM_COUNTRY_SELECTED' => $selected,
                    'CRM_COUNTRY'          => contrexx_raw2xhtml($value['name']),
            ));
            $objTpl->parse($block);
        }
    }

    /**
     * Get Country value from DB
     *
     * @global ADO Connection $objDatabase
     *
     * @return Array
     */
    function getCountry()
    {
        global $objDatabase;

        if (!empty($this->countries)) return $this->countries;

        // Selecting the Country Name from the Database
        $objResult =   $objDatabase->Execute('SELECT  iso_code_2,id,name FROM '.DBPREFIX.'lib_country ORDER BY id' );

        while (!$objResult->EOF) {
            $this->countries[$objResult->fields['id']] = array("id" => $objResult->fields['id'], "name" => $objResult->fields['name'], "iso_code_2" => $objResult->fields['iso_code_2']);

            $objResult->MoveNext();
        }
        return $this->countries;
    }

    /**
     * Get Contact Address Type Country value
     *
     * @param Template Object $objTpl
     * @param Integer         $selectedType
     * @param String          $block
     *
     * @global Array $_ARRAYLANG
     *
     * @return null
     */
    function getContactAddrTypeCountry($objTpl, $selectedType, $block = "addressType")
    {
        global $_ARRAYLANG;

        foreach ($this->addressTypes as $key => $value) {
            $selected = ($key == $selectedType) ? "selected" : '';
            $objTpl->setVariable(array(
                    'CRM_ADDRESS_TYPE'          => (int) $key,
                    'CRM_ADDRESS_TYPE_NAME'     => contrexx_raw2xhtml($_ARRAYLANG[$value]),
                    'CRM_ADDRESS_TYPE_SELECTED' => $selected
            ));
            $objTpl->parse($block);
        }

    }

    /**
     * Update Customer Contacts
     *
     * @param Array   $contacts
     * @param Integer $customerId
     *
     * @global ADO Connection $objDatabase
     *
     * @return null
     */
    function updateCustomerContacts($contacts, $customerId)
    {
        global $objDatabase;

        // Reset the contacts
        $objDatabase->Execute("UPDATE ".DBPREFIX."module_".$this->moduleName."_contacts SET contact_customer = 0
                                                                       WHERE  customer_id = '".intval($customerId)."'");

        foreach ($contacts as $value) {
            $objDatabase->Execute("UPDATE ".DBPREFIX."module_".$this->moduleName."_contacts SET contact_customer = $customerId
                                                                       WHERE  id = '".intval($value)."'");
        }
    }

    /**
     * Update Customer Memberships
     *
     * @param Array   $memberShips
     * @param Integer $customerId
     *
     * @global ADO Connection $objDatabase
     *
     * @return null
     */
    function updateCustomerMemberships($memberShips, $customerId)
    {
        global $objDatabase;

        $objDatabase->Execute("DELETE FROM `".DBPREFIX."module_{$this->moduleName}_customer_membership` WHERE contact_id = $customerId");
        foreach ($memberShips as $value) {
            $objDatabase->Execute("INSERT INTO `".DBPREFIX."module_{$this->moduleName}_customer_membership` SET
                                    membership_id = '$value',
                                    contact_id    = '$customerId'
                    ");
        }
    }

    /**
     * Unlink the contact
     *
     * @param Integer $contactId
     *
     * @global ADO Connection $objDatabase
     *
     * @return null
     */
    function unlinkContact($contactId)
    {
        global $objDatabase;
        $objDatabase->Execute("UPDATE `".DBPREFIX."module_".$this->moduleName."_contacts` SET `contact_customer` = 0
                                                                       WHERE  id = '".intval($contactId)."'");
    }

    /**
     *  Validate the Customer
     *
     * @param String  $customerName
     * @param Integer $customerId
     * @param Integer $id
     *
     * @global ADO Connection $objDatabase
     *
     * @return boolean
     */
    function validateCustomer($customerName = '', $customerId ='', $id = 0)
    {
        global $objDatabase;

        $customerName = contrexx_input2db(trim($customerName));
        $customerId   = contrexx_input2db(trim($customerId));
        $id           = (int) $id;

        $objResult = $objDatabase->Execute("SELECT 1 FROM `".DBPREFIX."module_{$this->moduleName}_customers`
                                                  WHERE (`customer_id`  = '$customerId' OR
                                                        `company_name` = '$customerName') AND
                                                         id != $id");
        if ($objResult) {
            if ($objResult->RecordCount() > 0)
                return false;
        }

        return TRUE;

    }

    /**
     * Formatting the website
     *
     * @param String  $url
     * @param Integer $urlProfile
     *
     * @return string
     */
    function formattedWebsite($url = '', $urlProfile = 0)
    {
        switch ($urlProfile) {
        // linkedIn
        case 3:
                $formattedValue = "<a href='http://".preg_replace("`^http://`is", "", html_entity_decode(contrexx_raw2xhtml($url), ENT_QUOTES, CONTREXX_CHARSET))."'>".html_entity_decode(contrexx_raw2xhtml($url), ENT_QUOTES, CONTREXX_CHARSET)."</a>";
            break;
        // skype
        case 1:
                $formattedValue = "<a href='skype:".contrexx_raw2xhtml($url)."?chat'>".contrexx_raw2xhtml($url)."</a>";
            break;
        // livejournal, myspace, bologger, jabber,aim
        case 5:case 6:case 8: case 12: case 13:
                $formattedValue = contrexx_raw2xhtml($url);
            break;
        // gmail, yahoo, msn (mail)
        case 7:case 9:case 10:
                $formattedValue = "<a href='mailto:".contrexx_raw2xhtml($url)."'>".contrexx_raw2xhtml($url)."</a>";
            break;
        // twitter
        case 2:
                $formattedValue = "<a href='http://twitter.com/".contrexx_raw2xhtml($url)."'>".contrexx_raw2xhtml($url)."</a>";
            break;
        // facebook
        case 4:
                $formattedValue = "<a href='http://facebook.com/".contrexx_raw2xhtml($url)."'>".contrexx_raw2xhtml($url)."</a>";
            break;
        // icq
        case 11:
                $formattedValue = "<a href='http://icq.com/people/".contrexx_raw2xhtml($url)."'>".contrexx_raw2xhtml($url)."</a>";
            break;
        default:
                $formattedValue = "<a href='http://".preg_replace("`^http://`is", "", html_entity_decode(contrexx_raw2xhtml($url), ENT_QUOTES, CONTREXX_CHARSET))."'>".html_entity_decode(contrexx_raw2xhtml($url), ENT_QUOTES, CONTREXX_CHARSET)."</a>";
            break;
        }
        return $formattedValue;
    }

    /**
     * Get Success Rate
     *
     * @param Integer $selectedRate
     * @param String  $block
     *
     * @global ADO Connection $objDatabase
     *
     * @return null
     */
    function getSuccessRate($selectedRate = 0, $block = "sRate")
    {
        global  $objDatabase;
        $objRates = $objDatabase->Execute("SELECT id, label,rate
                                                FROM `".DBPREFIX."module_{$this->moduleName}_success_rate` ORDER BY sorting ASC");
        if ($objRates) {
            while (!$objRates->EOF) {
                $selected = ($objRates->fields['id'] == $selectedRate) ? "selected" : '';
                $this->_objTpl->setVariable(array(
                        'SRATE_VALUE'     => (int) $objRates->fields['id'],
                        'SRATE_NAME'      => "[".contrexx_raw2xhtml($objRates->fields['rate'])."&nbsp;&#37;]&nbsp;".contrexx_raw2xhtml($objRates->fields['label']),
                        'SRATE_SELECTED'  => $selected,
                ));
                $this->_objTpl->parse($block);
                $objRates->MoveNext();
            }

        }

    }

    /**
     * Get Deals Stages
     *
     * @param Integer $selectedStage
     * @param String  $block
     *
     * @global ADO Connection $objDatabase
     *
     * @return null
     */
    function getDealsStages($selectedStage = 0, $block = "dealsStages")
    {
        global  $objDatabase;

        $objRates = $objDatabase->Execute("SELECT id, label,stage
                                                FROM `".DBPREFIX."module_{$this->moduleName}_stages` ORDER BY sorting ASC");
        if ($objRates) {
            while (!$objRates->EOF) {
                $selected = ($objRates->fields['id'] == $selectedStage) ? "selected" : '';
                $this->_objTpl->setVariable(array(
                        'STAGE_VALUE'     => (int) $objRates->fields['id'],
                        'STAGE_NAME'      => "[".contrexx_raw2xhtml($objRates->fields['stage'])."&nbsp;&#37;]&nbsp;".contrexx_raw2xhtml($objRates->fields['label']),
                        'STAGE_SELECTED'  => $selected,
                ));
                $this->_objTpl->parse($block);
                $objRates->MoveNext();
            }

        }

    }

    /**
     * Get Domain name Id
     *
     * @param Integer $websiteId  website id
     * @param Integer $cusId      customer id
     * @param String  $domainName domain name
     *
     * @global ADO Connection $objDatabase
     *
     * @return Integer
     */
    public function _getDomainNameId($websiteId, $cusId, $domainName)
    {
        global $objDatabase;

        if (empty($domainName)) {
            return 0;
        }

        $websiteId  = (int) $websiteId;
        $cusId      = (int) $cusId;
        $domainName = contrexx_input2db($domainName);
        $query = "SELECT
                        `id`
                    FROM `".DBPREFIX."module_{$this->moduleName}_customer_contact_websites`
                    WHERE (`url` = '$domainName')
                        AND `contact_id` = $cusId";
        $objResult = $objDatabase->Execute($query);

        if ($objResult->RecordCount() > 0) {
            return $objResult->fields['id'];
        } else {
            $insertWebsite = $objDatabase->Execute("INSERT INTO
                                                    `".DBPREFIX."module_{$this->moduleName}_customer_contact_websites`
                                                    SET `contact_id` = $cusId,
                                                        `url_type`   = 3,
                                                        `url_profile`= 1,
                                                        `is_primary` = '0',
                                                        `url`        = '".  contrexx_raw2encodedUrl($domainName)."'");
            return $objDatabase->Insert_Id();
        }
    }

    /**
     * Success Rate Status Change
     *
     * @param Array   $successEntrys success entry ids
     * @param Boolean $deactivate    status
     *
     * @global ADO Connection $objDatabase
     * @global Array          $_ARRAYLANG
     *
     * @return null
     */
    function activateSuccessRate($successEntrys, $deactivate = false)
    {
        global $objDatabase,$_ARRAYLANG;

        if (!empty($successEntrys) && is_array($successEntrys)) {

            $ids = implode(',', $successEntrys);
            $setValue = $deactivate ? 0 : 1;

            $query = "UPDATE `".DBPREFIX."module_".$this->moduleName."_success_rate` SET `status` = CASE id ";
            foreach ($successEntrys as $count => $idValue) {
                $query .= sprintf("WHEN %d THEN $setValue ", $idValue);
            }
            $query .= "END WHERE id IN ($ids)";
            $objResult = $objDatabase->Execute($query);

            if ($_GET['ajax']) {
                echo $_ARRAYLANG['TXT_CRM_CATALOGS_UPDATED_SUCCESSFULLY'];
                exit();
            } else {
                $this->strOkMessage = sprintf($_ARRAYLANG['TXT_CRM_CATALOGS_UPDATED_SUCCESSFULLY'], ($deactivate) ? $_ARRAYLANG['TXT_CRM_DEACTIVATED'] : $_ARRAYLANG['TXT_CRM_ACTIVATED']);
            }
        }
    }

    /**
     * Success Rate sorting function
     *
     * @param Array $successEntrySorting sorting value in array
     *
     * @global ADO Connection $objDatabase
     * @global Array          $_ARRAYLANG
     *
     * @return null
     */
    function saveSortingSuccessRate($successEntrySorting)
    {
        global $objDatabase,$_ARRAYLANG;

        if (!empty($successEntrySorting) && is_array($successEntrySorting)) {

            $ids = implode(',', array_keys($successEntrySorting));

            $query = "UPDATE `".DBPREFIX."module_".$this->moduleName."_success_rate` SET `sort` = CASE id ";
            foreach ($successEntrySorting as $idValue => $value ) {
                $query .= sprintf("WHEN %d THEN %d ", $idValue, $value);
            }
            $query .= "END WHERE id IN ($ids)";
            $objResult = $objDatabase->Execute($query);

        }
    }

    /**
     * Delete Multiple Success rate records
     *
     * @param Array $successEntries Success entry ids
     *
     * @global ADO Connection $objDatabase
     *
     * @return null
     */
    function deleteSuccessRates($successEntries)
    {
        global $objDatabase;

        if (!empty($successEntries) && is_array($successEntries)) {

            $ids = implode(',', $successEntries);

            $query = "DELETE FROM `".DBPREFIX."module_".$this->moduleName."_success_rate` WHERE id IN ($ids)";
            $objResult = $objDatabase->Execute($query);

        }
    }

    /**
     * Delete SuccessRate record
     *
     * @global ADO Connection $objDatabase
     *
     * @return null
     */
    function deleteSuccessRate()
    {
        global $objDatabase;

        $id     = (int) $_GET['id'];
        $query = "DELETE FROM `".DBPREFIX."module_{$this->moduleName}_success_rate`
                        WHERE id = $id";
        $db = $objDatabase->Execute($query);

    }

    /**
     * Industry type Change Status
     *
     * @param Array   $industryEntrys entry ids
     * @param Boolean $deactivate     status
     *
     * @global ADO Connection $objDatabase
     * @global Array          $_ARRAYLANG
     *
     * @return null
     */
    function activateIndustryType($industryEntrys, $deactivate = false)
    {
        global $objDatabase,$_ARRAYLANG;

        if (!empty($industryEntrys) && is_array($industryEntrys)) {

            $ids = implode(',', $industryEntrys);
            $setValue = $deactivate ? 0 : 1;

            $query = "UPDATE `".DBPREFIX."module_".$this->moduleName."_industry_types` SET `status` = CASE id ";
            foreach ($industryEntrys as $count => $idValue) {
                $query .= sprintf("WHEN %d THEN $setValue ", $idValue);
            }
            $query .= "END WHERE id IN ($ids)";
            $objResult = $objDatabase->Execute($query);

            if ($_GET['ajax']) {
                exit();
            } else {
                $this->_strOkMessage = sprintf($_ARRAYLANG['TXT_CRM_INDUSTRY_UPDATED_SUCCESSFULLY'], ($deactivate) ? $_ARRAYLANG['TXT_CRM_DEACTIVATED'] : $_ARRAYLANG['TXT_CRM_ACTIVATED']);
            }
        } else {
            $objDatabase->Execute("UPDATE `".DBPREFIX."module_".$this->moduleName."_industry_types` SET `status` = IF(status = 1, 0, 1) WHERE id = $industryEntrys");
        }
    }

    /**
     * Industry type sorting function
     *
     * @param Array $industryEntrySorting entries id
     *
     * @global ADO Connection $objDatabase
     * @global Array          $_ARRAYLANG
     *
     * @return null
     */
    function saveSortingIndustryType($industryEntrySorting)
    {
        global $objDatabase,$_ARRAYLANG;

        if (!empty($industryEntrySorting) && is_array($industryEntrySorting)) {

            $ids = implode(',', array_keys($industryEntrySorting));

            $query = "UPDATE `".DBPREFIX."module_".$this->moduleName."_industry_types` SET `sorting` = CASE id ";
            foreach ($industryEntrySorting as $idValue => $value ) {
                $query .= sprintf("WHEN %d THEN %d ", $idValue, $value);
            }
            $query .= "END WHERE id IN ($ids)";
            $objResult = $objDatabase->Execute($query);
            $this->_strOkMessage = $_ARRAYLANG['TXT_CRM_PROJECTSTATUS_SORTING_COMPLETE'];
        }
    }

    /**
     * Delete Multiple Industry types record
     *
     * @param Array $indusEntries
     *
     * @global ADO Connection $objDatabase
     * @global Array          $_ARRAYLANG
     *
     * @return null
     */
    function deleteIndustryTypes($indusEntries)
    {
        global $objDatabase, $_ARRAYLANG;

        if (!empty($indusEntries) && is_array($indusEntries)) {

            $ids = implode(',', $indusEntries);

            $query = "DELETE FROM `".DBPREFIX."module_".$this->moduleName."_industry_types` WHERE id IN ($ids)";
            $objResult = $objDatabase->Execute($query);
            $this->_strOkMessage = $_ARRAYLANG['TXT_CRM_ENTRY_DELETED_SUCCESS'];
        }
    }

    function getContactsQuery($filter = array(), $sortField = 'c.id', $sortOrder = 0)
    {
        global $_LANGID, $_ARRAYLANG;
        
        $where = array();

        $alphaFilter = isset($filter['companyname_filter']) ? contrexx_input2raw($filter['companyname_filter']) : '';
        
        if (!empty($alphaFilter)) {
            $where[] = " (c.customer_name LIKE '".contrexx_input2raw($alphaFilter)."%')";
        }
        
        $searchContactTypeFilter = isset($filter['contactSearch']) ? (array) $filter['contactSearch'] : array(1,2);
        $searchContactTypeFilter = array_map('intval', $searchContactTypeFilter);
        $where[] = " c.contact_type IN (".implode(',', $searchContactTypeFilter).")";

        if (isset($filter['advanced-search'])) {
            if (isset($filter['s_name']) && !empty($filter['s_name'])) {
                $where[] = " (c.customer_name LIKE '".contrexx_input2db($filter['s_name'])."%' OR c.contact_familyname LIKE '".contrexx_input2db($filter['s_name'])."%')";
            }
            if (isset($filter['s_email']) && !empty($filter['s_email'])) {
                $where[] = " (email.email LIKE '".contrexx_input2db($filter['s_email'])."%')";
            }
            if (isset($filter['s_address']) && !empty($filter['s_address'])) {
                $where[] = " (addr.address LIKE '".contrexx_input2db($filter['s_address'])."%')";
            }
            if (isset($filter['s_city']) && !empty($filter['s_city'])) {
                $where[] = " (addr.city LIKE '".contrexx_input2db($filter['s_city'])."%')";
            }
            if (isset($filter['s_postal_code']) && !empty($filter['s_postal_code'])) {
                $where[] = " (addr.zip LIKE '".contrexx_input2db($filter['s_postal_code'])."%')";
            }
            if (isset($filter['s_notes']) && !empty($filter['s_notes'])) {
                $where[] = " (c.notes LIKE '".contrexx_input2db($filter['s_notes'])."%')";
            }
        }
        if (isset($filter['customer_type']) && !empty($filter['customer_type'])) {
            $where[] = " (c.customer_type = '".intval($filter['customer_type'])."')";
        }
        if (isset($filter['filter_membership']) && !empty($filter['filter_membership'])) {
            $where[] = " mem.membership_id = '".intval($filter['filter_membership'])."'";
        }

        $orderBy = '';
        $orderQuery = '';
        if (isset($filter['term']) && !empty($filter['term'])) {
            $gender     = ($filter['term'] == 'male' || $filter['term'] == 'MÃ¤nnlich') ? 2 : (($filter['term'] == 'female' || $filter['term'] == 'Weiblich') ? 1 : '');
            switch (true) {
            case (preg_match("/(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+)+)/i", $filter['term'])):
                $filter['term'] = '"'.$filter['term'].'"';
                break;
            case (preg_match("/(^|[\n ])([\w]*?)((ht|f)tp(s)?:\/\/[\w]+[^ \,\"\n\r\t<]*)/is", $filter['term']) || preg_match("/(^|[\n ])([\w]*?)((www|ftp)\.[^ \,\"\t\n\r<]*)/is", $filter['term'])):
                $filter['term'] = '"'.$filter['term'].'"';
                break;
            case (preg_match('/[^a-z0-9 _]+/i', $filter['term'])):
                $filter['term'] = '"'.$filter['term'].'"';
                break;
            case (preg_match('/(\w+[+-.]\w+[\w]+[^ \,\"\n\r\t<]*)/is', $filter['term'])):
                $filter['term'] = preg_replace('/(\w+[+-.]\w+[\w]+[^ \,\"\n\r\t<]*)/is', '+"$0"', $filter['term']);
                break;
//            case (!preg_match('/[\+|\-]/', $filter['term'])):
//                $filter['term'] = preg_replace('/\s+/', ' +', "+".$filter['term']);
//                break;
            default:
                $filter['term'] = '"'.$filter['term'].'"';
                break;
            } 
            if (!empty($gender)) {
                $genderQuery = "OR (SELECT 1 FROM `".DBPREFIX."module_{$this->moduleName}_contacts` WHERE id = c.id AND gender = '".$gender."' LIMIT 1)";
            } 
            $orderBy    = "nameRelevance DESC, familyNameRelevance DESC, c.customer_name ASC";
            $orderQuery = "MATCH (c.customer_name) AGAINST ('".contrexx_raw2db($filter['term'])."*' IN BOOLEAN MODE) AS nameRelevance,
                           MATCH (c.contact_familyname) AGAINST ('".contrexx_raw2db($filter['term'])."*' IN BOOLEAN MODE) AS familyNameRelevance,";
            $where[]    = "((SELECT 1 FROM `".DBPREFIX."module_{$this->moduleName}_customer_contact_emails` WHERE c.id = contact_id AND MATCH (email) AGAINST ('".contrexx_raw2db($filter['term'])."*' IN BOOLEAN MODE) LIMIT 1) 
                            OR MATCH (c.customer_id, c.customer_name, c.contact_familyname, c.contact_role, c.notes) AGAINST ('".contrexx_raw2db($filter['term'])."*' IN BOOLEAN MODE) 
                            OR (SELECT 1 FROM `".DBPREFIX."module_{$this->moduleName}_customer_contact_websites` WHERE c.id = contact_id AND MATCH (url) AGAINST ('".contrexx_raw2db($filter['term'])."*' IN BOOLEAN MODE) LIMIT 1) 
                            OR (SELECT 1 FROM `".DBPREFIX."module_{$this->moduleName}_customer_contact_social_network` WHERE c.id = contact_id AND MATCH (url) AGAINST ('".contrexx_raw2db($filter['term'])."*' IN BOOLEAN MODE) LIMIT 1) 
                            OR (SELECT 1 FROM `".DBPREFIX."module_{$this->moduleName}_customer_contact_phone` WHERE c.id = contact_id AND MATCH (phone) AGAINST ('".contrexx_raw2db($filter['term'])."*' IN BOOLEAN MODE) LIMIT 1) 
                            OR (SELECT 1 FROM `".DBPREFIX."module_{$this->moduleName}_customer_comment` WHERE c.id = customer_id AND MATCH (comment) AGAINST ('".contrexx_raw2db($filter['term'])."*' IN BOOLEAN MODE) LIMIT 1) 
                            OR MATCH (cur.name) AGAINST ('".contrexx_raw2db($filter['term'])."*' IN BOOLEAN MODE) OR MATCH (t.label) AGAINST ('".contrexx_raw2db($filter['term'])."*' IN BOOLEAN MODE) 
                            OR (select 1 FROM `".DBPREFIX."module_{$this->moduleName}_customer_membership` as m JOIN `".DBPREFIX."module_{$this->moduleName}_membership_local` As ml ON (ml.entry_id=m.membership_id AND ml.lang_id = '".$_LANGID."') WHERE c.id = m.contact_id AND MATCH (ml.value) AGAINST ('".contrexx_raw2db($filter['term'])."*' IN BOOLEAN MODE) LIMIT 1) 
                            OR MATCH (Inloc.value) AGAINST ('".contrexx_raw2db($filter['term'])."*' IN BOOLEAN MODE) 
                            OR MATCH (lang.name) AGAINST ('".contrexx_raw2db($filter['term'])."*' IN BOOLEAN MODE) 
                            OR (SELECT 1 FROM `".DBPREFIX."module_{$this->moduleName}_customer_contact_address` WHERE c.id = contact_id AND MATCH (address, city, state, zip, country) AGAINST ('".contrexx_raw2db($filter['term'])."*' IN BOOLEAN MODE) LIMIT 1) {$genderQuery})";
        }

        //  Join where conditions
        $filters = '';
        if (!empty ($where)) {
            $filters = " WHERE ".implode(' AND ', $where);
        }

        $sortingFields = array("c.customer_name" ,  "activities", "c.added_date");
        $sortOrder = (isset ($filter['sorto'])) ? (((int) $filter['sorto'] == 0) ? 'DESC' : 'ASC') : 'DESC';
        $sortField = (isset ($filter['sortf']) && in_array($sortingFields[$filter['sortf']], $sortingFields)) ? $sortingFields[$filter['sortf']] : 'c.id';
        
        $query = "SELECT
                       DISTINCT c.id,
                       c.customer_id,
                       c.customer_type,
                       c.customer_name,
                       c.contact_familyname,
                       c.contact_type,
                       c.contact_customer AS contactCustomerId,
                       c.status,
                       c.added_date,
                       con.customer_name AS contactCustomer,
                       email.email,
                       phone.phone,
                       t.label AS cType,
                       Inloc.value AS industryType,
                       ".$orderQuery."
                           ((SELECT count(1) AS notesCount FROM `".DBPREFIX."module_{$this->moduleName}_customer_comment` AS com WHERE com.customer_id = c.id ) +
                           (SELECT count(1) AS tasksCount FROM `".DBPREFIX."module_{$this->moduleName}_task` AS task WHERE task.customer_id = c.id ) +
                           (SELECT count(1) AS dealsCount FROM `".DBPREFIX."module_{$this->moduleName}_deals` AS deal WHERE deal.customer = c.id )) AS activities
                   FROM `".DBPREFIX."module_{$this->moduleName}_contacts` AS c
                   LEFT JOIN `".DBPREFIX."module_{$this->moduleName}_contacts` AS con
                     ON c.contact_customer =con.id
                   LEFT JOIN `".DBPREFIX."module_{$this->moduleName}_currency` As cur 
                     ON (cur.id=c.customer_currency)
                   LEFT JOIN `".DBPREFIX."languages` As lang 
                     ON (lang.id=c.contact_language)  
                   LEFT JOIN ".DBPREFIX."module_{$this->moduleName}_customer_types AS t
                     ON c.customer_type = t.id
                   LEFT JOIN `".DBPREFIX."module_{$this->moduleName}_customer_contact_emails` as email
                     ON (c.id = email.contact_id AND email.is_primary = '1')
                   LEFT JOIN `".DBPREFIX."module_{$this->moduleName}_customer_contact_phone` as phone
                     ON (c.id = phone.contact_id AND phone.is_primary = '1')
                   LEFT JOIN `".DBPREFIX."module_{$this->moduleName}_customer_contact_address` as addr
                     ON (c.id = addr.contact_id AND addr.is_primary = '1')
                   LEFT JOIN `".DBPREFIX."module_{$this->moduleName}_customer_membership` as mem
                     ON (c.id = mem.contact_id)
                   LEFT JOIN `".DBPREFIX."module_{$this->moduleName}_industry_types` AS Intype
                     ON c.industry_type = Intype.id
                   LEFT JOIN `".DBPREFIX."module_{$this->moduleName}_industry_type_local` AS Inloc
                     ON Intype.id = Inloc.entry_id AND Inloc.lang_id = ".$_LANGID."
            $filters";
                   
        if (!empty($orderBy) && empty($sortField) && empty($sortOrder)) {
            $query = $query." ORDER BY $orderBy";
        } else {
            $query = $query." ORDER BY $sortField $sortOrder";
        }
        
        return $query;
    }
    
    /**
     * Delete Industry type
     *
     * @global ADO Connection $objDatabase
     *
     * @return null
     */
    function deleteIndustryType()
    {
        global $objDatabase;

        $id     = (int) $_GET['id'];
        $query = "DELETE FROM `".DBPREFIX."module_{$this->moduleName}_industry_types`
                        WHERE id = $id";
        $db = $objDatabase->Execute($query);

    }

    /**
     * Change Membership Status
     *
     * @param Array   $entries    entries id
     * @param Boolean $deactivate Status
     *
     * @global ADO Connection $objDatabase
     * @global Array          $_ARRAYLANG
     *
     * @return null
     */
    function activateMembership($entries, $deactivate = false)
    {
        global $objDatabase,$_ARRAYLANG;

        if (!empty($entries) && is_array($entries)) {

            $ids = implode(',', $entries);
            $setValue = $deactivate ? 0 : 1;

            $query = "UPDATE `".DBPREFIX."module_".$this->moduleName."_memberships` SET `status` = CASE id ";
            foreach ($entries as $count => $idValue) {
                $query .= sprintf("WHEN %d THEN $setValue ", $idValue);
            }
            $query .= "END WHERE id IN ($ids)";
            $objResult = $objDatabase->Execute($query);

            if ($_GET['ajax']) {
                exit();
            } else {
                $_SESSION['strOkMessage'] = sprintf($_ARRAYLANG['TXT_CRM_MEMBERSHIP_UPDATED_SUCCESSFULLY'], ($deactivate) ? $_ARRAYLANG['TXT_CRM_DEACTIVATED'] : $_ARRAYLANG['TXT_CRM_ACTIVATED']);
            }
        } else {
            $objDatabase->Execute("UPDATE `".DBPREFIX."module_".$this->moduleName."_memberships` SET `status` = IF(status = 1, 0, 1) WHERE id = $entries");
        }
    }

    /**
     * Membership Sorting functionality
     *
     * @param Array $entriesSorting entries ids
     *
     * @global ADO Connection $objDatabase
     * @global Array          $_ARRAYLANG
     *
     * @return null
     */
    function saveSortingMembership($entriesSorting)
    {
        global $objDatabase,$_ARRAYLANG;

        if (!empty($entriesSorting) && is_array($entriesSorting)) {

            $ids = implode(',', array_keys($entriesSorting));

            $query = "UPDATE `".DBPREFIX."module_".$this->moduleName."_memberships` SET `sorting` = CASE id ";
            foreach ($entriesSorting as $idValue => $value ) {
                $query .= sprintf("WHEN %d THEN %d ", $idValue, $value);
            }
            $query .= "END WHERE id IN ($ids)";
            $objResult = $objDatabase->Execute($query);

        }
        if (isset($_POST['save_entries'])) {
            $_SESSION['strOkMessage'] = $_ARRAYLANG['TXT_CRM_SORTING_COMPLETE'];
        }
    }

    /**
     * Delete Multiple Membership Records
     *
     * @param Array $entries entry id
     *
     * @global ADO Connection $objDatabase
     * @global Array          $_ARRAYLANG
     *
     * @return null
     */
    function deleteMemberships($entries)
    {
        global $objDatabase, $_ARRAYLANG;

        if (!empty($entries) && is_array($entries)) {

            $ids = implode(',', $entries);

            $query = "DELETE m.*, ml.* FROM `".DBPREFIX."module_{$this->moduleName}_memberships` AS m
                                   LEFT JOIN `".DBPREFIX."module_{$this->moduleName}_membership_local` AS ml
                                   ON m.id = ml.entry_id
                        WHERE id IN ($ids)";
            $objResult = $objDatabase->Execute($query);

        }
        if ($_GET['ajax']) {
            exit();
        } else {
            $_SESSION['strOkMessage'] = $_ARRAYLANG['TXT_CRM_MEMBERSHIP_DELETED_SUCCESSFULLY'];
        }

    }

    /**
     * delete Membership
     *
     * @global ADO Connection $objDatabase
     *
     * @return null
     */
    function deleteMembership()
    {
        global $objDatabase;

        $id     = (int) $_GET['id'];
        $query  = "DELETE m.*, ml.* FROM `".DBPREFIX."module_{$this->moduleName}_memberships` AS m
                                   LEFT JOIN `".DBPREFIX."module_{$this->moduleName}_membership_local` AS ml
                                   ON m.id = ml.entry_id
                        WHERE id = $id";
        $db = $objDatabase->Execute($query);

    }

    /**
     * change stage status
     *
     * @param Array   $successEntrys entry ids
     * @param Boolean $deactivate    status
     *
     * @global ADO Connection $objDatabase
     * @global Array          $_ARRAYLANG
     *
     * @return null
     */
    function activateStage($successEntrys, $deactivate = false)
    {
        global $objDatabase,$_ARRAYLANG;

        if (!empty($successEntrys) && is_array($successEntrys)) {

            $ids = implode(',', $successEntrys);
            $setValue = $deactivate ? 0 : 1;

            $query = "UPDATE `".DBPREFIX."module_".$this->moduleName."_stages` SET `status` = CASE id ";
            foreach ($successEntrys as $count => $idValue) {
                $query .= sprintf("WHEN %d THEN $setValue ", $idValue);
            }
            $query .= "END WHERE id IN ($ids)";
            $objResult = $objDatabase->Execute($query);

            if ($_GET['ajax']) {
                echo $_ARRAYLANG['TXT_CRM_CATALOGS_UPDATED_SUCCESSFULLY'];
                exit();
            } else {
                $this->_strOkMessage = sprintf($_ARRAYLANG['TXT_CRM_CATALOGS_UPDATED_SUCCESSFULLY'], ($deactivate) ? $_ARRAYLANG['TXT_CRM_DEACTIVATED'] : $_ARRAYLANG['TXT_CRM_ACTIVATED']);
            }
        }
    }

    /**
     * save sorting stage
     *
     * @param Array $successEntrySorting entry ids
     *
     * @global ADO Connection $objDatabase
     * @global Array          $_ARRAYLANG
     *
     * @return null
     */
    function saveStageSorting($successEntrySorting)
    {
        global $objDatabase, $_ARRAYLANG;

        if (!empty($successEntrySorting) && is_array($successEntrySorting)) {

            $ids = implode(',', array_keys($successEntrySorting));

            $query = "UPDATE `".DBPREFIX."module_".$this->moduleName."_stages` SET `sorting` = CASE id ";
            foreach ($successEntrySorting as $idValue => $value ) {
                $query .= sprintf("WHEN %d THEN %d ", $idValue, $value);
            }
            $query .= "END WHERE id IN ($ids)";
            $objResult = $objDatabase->Execute($query);
            $this->_strOkMessage = $_ARRAYLANG['TXT_CRM_PROJECTSTATUS_SORTING_COMPLETE'];

        }
    }

    /**
     * Delete Multiple Stages
     *
     * @param Array $successEntries entries ids
     *
     * @global ADO Connection $objDatabase
     * @global Array          $_ARRAYLANG
     *
     * @return null
     */
    function deleteStages($successEntries)
    {
        global $objDatabase, $_ARRAYLANG;

        if (!empty($successEntries) && is_array($successEntries)) {

            $ids = implode(',', $successEntries);

            $query = "DELETE FROM `".DBPREFIX."module_".$this->moduleName."_stages` WHERE id IN ($ids)";
            $objResult = $objDatabase->Execute($query);
            $this->_strOkMessage = $_ARRAYLANG['TXT_CRM_ENTRY_DELETED_SUCCESS'];
        }
    }

    /**
     * Delete stage record
     *
     * @global ADO Connection $objDatabase
     *
     * @return null
     */
    function deleteStage()
    {
        global $objDatabase;

        $id     = (int) $_GET['id'];
        $query = "DELETE FROM `".DBPREFIX."module_{$this->moduleName}_stages`
                        WHERE id = $id";
        $db = $objDatabase->Execute($query);

    }

    /**
     * Delete Multiple Deals
     *
     * @param Array   $dealsEntries   entry ids
     * @param Boolean $deleteProjects status
     *
     * @global ADO Connection $objDatabase
     *
     * @return null
     */
    function deleteDeals($dealsEntries, $deleteProjects = false)
    {
        global $objDatabase;

        if (!empty($dealsEntries) && is_array($dealsEntries)) {

            $ids = implode(',', $dealsEntries);

            // cahnge project to deleted status if pm module integrated
            if ($deleteProjects) {
                $deletedStatusId = $objDatabase->getOne("SELECT projectstatus_id FROM ".DBPREFIX."module_".$this->pm_moduleName."_project_status WHERE deleted = 1");
                $objProjects     = $objDatabase->Execute("SELECT project_id FROM `".DBPREFIX."module_".$this->moduleName."_deals` WHERE id IN ($ids)");

                $projectToBeDeleted = array();
                if ($objProjects) {
                    while (!$objProjects->EOF) {
                        $projectToBeDeleted[] = (int) $objProjects->fields['project_id'];
                        $objProjects->MoveNext();
                    }
                    $projectIds = implode(',', $projectToBeDeleted);
                    $updateProjectStatus = $objDatabase->Execute("UPDATE `".DBPREFIX."module_{$this->pm_moduleName}_projects`
                                                                    SET `status`    = '$deletedStatusId'
                                                                    WHERE id IN  ($projectIds)");
                }
            }
            $query = "DELETE FROM `".DBPREFIX."module_".$this->moduleName."_deals` WHERE id IN ($ids)";
            $objResult = $objDatabase->Execute($query);

        }
        $message = base64_encode("dealsdeleted");
        csrf::header("location:".ASCMS_ADMIN_WEB_PATH."/index.php?cmd=".$this->moduleName."&act=deals&mes=$message");
    }

    /**
     * Delete Deal record
     *
     * @param Boolean $deleteProjects record status
     *
     * @global ADO Connection $objDatabase
     *
     * @return null
     */
    function deleteDeal($deleteProjects = false)
    {
        global $objDatabase;

        $id     = (int) $_GET['id'];

        // cahnge project to deleted status if pm module integrated
        if ($deleteProjects) {
            $deletedStatusId = $objDatabase->getOne("SELECT projectstatus_id FROM ".DBPREFIX."module_".$this->pm_moduleName."_project_status WHERE deleted = 1");
            $objProjects     = $objDatabase->Execute("SELECT project_id FROM `".DBPREFIX."module_".$this->moduleName."_deals` WHERE id = $id");

            if ($objProjects) {
                $projectId = (int) $objProjects->fields['project_id'];
                $updateProjectStatus = $objDatabase->Execute("UPDATE `".DBPREFIX."module_{$this->pm_moduleName}_projects`
                                                                SET `status`    = '$deletedStatusId'
                                                                WHERE id = $projectId");
            }
        }
        $query = "DELETE FROM `".DBPREFIX."module_{$this->moduleName}_deals`
                        WHERE id = $id";
        $db = $objDatabase->Execute($query);

    }

    /**
     * Populates the Contrexx user Filter Drop Down
     *
     * @param String  $block      The name of the template block to parse
     * @param Integer $selectedId The ID of the selected user
     * @param Integer $groupId    Resource froup id
     *
     * @return null
     */
    function _getResourceDropDown($block= 'members', $selectedId=0, $groupId = 0)
    {
        $resources = $this->getResources($groupId);
        foreach ($resources as $resource) {
            $selected = $selectedId ==  $resource['id'] ? 'selected="selected"' : '';

            $this->_objTpl->setVariable(array(
                    'TXT_USER_MEMBERID'   => $resource['id'],
                    'TXT_USER_MEMBERNAME' => $resource['username'],
                    'TXT_SELECTED'        => $selected));
            $this->_objTpl->parse($block);
        }
    }

    /**
     * Get Resource data's
     *
     * @param Integer $groupId resource group id
     *
     * @global ADO Connection $objDatabase
     *
     * @return boolean
     */
    function getResources($groupId)
    {
        global $objDatabase;
        static $resources = array();

        if (!empty($resources)) {
            return $resources;
        }
        if (empty ($groupId)) {
            return false;
        }

        $objFWUser  = FWUser::getFWUserObject();
        //for settings default mode as backend then only get the users details under the group
        $objFWUser->setMode(true);
        $objUsers   = $objFWUser->objUser->getUsers($filter = array('group_id' => $groupId));

        if (false !== $objUsers) {
            while (!$objUsers->EOF) {
                $userName    = $objUsers->getRealUsername();
                $userName    = !empty ($userName) ? $userName : $objUsers->getUsername();
                $resources[] = array(
                    'id'       => $objUsers->getId(),
                    'username' => $userName,
                    'email'    => $objUsers->getEmail(),
                );
                $objUsers->next();
            }
            return $resources;
        }
        return false;
    }

    /**
     * Get Data source Dropdown
     *
     * @param Template Object $objTpl     template object
     * @param String          $block      block name
     * @param Integer         $selectedId Default value id
     *
     * @return null
     */
    function getDatasourceDropDown($objTpl, $block= 'datasource', $selectedId = 0)
    {
        $datasources = $this->getCrmDatasource();

        foreach ($datasources as $id => $datasource) {
            $selected = $id == $selectedId ? 'selected' : '';

            $objTpl->setvariable(array(
                'CRM_DATASOURCE_ID'       => (int) $id,
                'CRM_DATASOURCE_VALUE'    => contrexx_raw2xhtml($datasource['datasource']),
                'CRM_DATASOURCE_SELECTED' => $selected
            ));
            $objTpl->parse($block);
        }
    }

    /**
     * Get Crm data Source
     *
     * @global ADO Connection $objDatabase
     *
     * @return String
     */
    function getCrmDatasource()
    {
        global $objDatabase;

        static $datasource = array();

        if (!empty($datasource)) {
            return $datasource;
        }

        $objResult = $objDatabase->Execute("SELECT `id`, `datasource`, `status`  FROM `". DBPREFIX ."module_{$this->moduleName}_datasources`");

        if ($objResult) {
            while (!$objResult->EOF) {
                $datasource[$objResult->fields['id']] = $objResult->fields;
                $objResult->MoveNext();
            }
        }

        return $datasource;
    }

    /**
     * Get Membership details From DB
     *
     * @param Boolean $active membership status
     *
     * @global ADO Connection $objDatabase
     * @global Array          $_LANGID
     *
     * @return Array
     */
    function getMemberships($active = true)
    {
        global $objDatabase, $_LANGID;

        $status = ($active) ? ' AND status = 1' : '';
        $memberships = array();
        $objResult = $objDatabase->Execute("SELECT membership.*,
                                                   memberLoc.value
                                             FROM `".DBPREFIX."module_{$this->moduleName}_memberships` AS membership
                                             LEFT JOIN `".DBPREFIX."module_{$this->moduleName}_membership_local` AS memberLoc
                                                ON membership.id = memberLoc.entry_id
                                             WHERE memberLoc.lang_id = ".$_LANGID." $status ORDER BY sorting ASC");
        if ($objResult) {
            while (!$objResult->EOF) {
                $memberships[$objResult->fields['id']] = $objResult->fields['value'];
                $objResult->MoveNext();
            }
        }

        $this->_memberShips = $memberships;
        return $memberships;
    }

    /**
     * List the industry types
     *
     * @param Template Object $objTpl
     * @param Integer         $intView
     * @param Integer         $intIndustryId industry id
     * @param Array           $arrParentIds  parent ids
     *
     * @global Array          $_ARRAYLANG
     * @global ADO Connection $objDatabase
     *
     * @return String
     */
    function listIndustryTypes($objTpl, $intView, $intIndustryId=null, $arrParentIds=null)
    {
        global $_ARRAYLANG, $objDatabase;

        if (!isset($this->model_industry_types))
            $this->model_industry_types = new IndustryType();
        if (!isset($this->model_industry_types->arrIndustryTypes))
            $this->model_industry_types->arrIndustryTypes = $this->model_industry_types->getIndustryTypes(null, null, true);

        if (!isset($arrParentIds)) {
            $arrIndustries = $this->model_industry_types->arrIndustryTypes;
        } else {
            $arrChildren = $this->model_industry_types->arrIndustryTypes;

            foreach ($arrParentIds as $key => $intParentId) {
                $arrChildren = $arrChildren[$intParentId]['children'];
            }
            $arrIndustries = $arrChildren;
        }

        switch ($intView) {
        case 1:
            //backend overview page
            foreach ($arrIndustries as $key => $arrIndustry) {
            //generate space
                $spacer = null;
                $intSpacerSize = null;
                $intSpacerSize = (count($arrParentIds)*21);
                $spacer .= '<img src="images/icons/pixel.gif" border="0" width="'.$intSpacerSize.'" height="11" alt="" />';

                //parse variables
                $activeImage = ($arrIndustry['status']) ? 'images/icons/led_green.gif' : 'images/icons/led_red.gif';
                $objTpl->setVariable(array(
                    'ENTRY_ID'           => $arrIndustry['id'],
                    'CRM_SORTING'        => (int) $arrIndustry['sorting'],
                    'CRM_SUCCESS_STATUS' => $activeImage,
                    'CRM_INDUSTRY_ICON'  => $spacer,
                    'CRM_INDUSTRY_NAME'  => contrexx_raw2xhtml($arrIndustry['name'])
                ));
                $objTpl->parse('industryEntries');

                $arrParentIds[] = $arrIndustry['id'];

                //get children
                if (!empty($arrIndustry['children'])) {
                    $this->listIndustryTypes($objTpl, 1, $intIndustryId, $arrParentIds);
                }
                @array_pop($arrParentIds);
            }
            break;
        case 2: // Industry Drop down menu
            $strDropdownOptions = '';
            foreach ($arrIndustries as $key => $arrIndustry) {
                $spacer = null;
                $intSpacerSize = null;

                if ($arrIndustry['id'] == $intIndustryId) {
                    $strSelected = 'selected="selected"';
                } else {
                    $strSelected = '';
                }

                //generate space
                $intSpacerSize = (count($arrParentIds));
                for ($i = 0; $i < $intSpacerSize; $i++) {
                    $spacer .= "----";
                }

                if ($spacer != null) {
                    $spacer .= "&nbsp;";
                }

                $strDropdownOptions .= '<option value="'.$arrIndustry['id'].'" '.(($arrIndustry['status']) ? "" : "style='color:#FF7B7B'").' '.$strSelected.' >'.$spacer.contrexx_raw2xhtml($arrIndustry['name']).'</option>';

                if (!empty($arrIndustry['children'])) {
                    $arrParentIds[] = $arrIndustry['id'];
                    $strDropdownOptions .= $this->listIndustryTypes($objTpl, 2, $intIndustryId, $arrParentIds);
                    @array_pop($arrParentIds);
                }
            }
            return $strDropdownOptions;
            break;
        }
    }

    /**
     * Get Membership dropdown
     *
     * @param Template Object $objTpl      Template object
     * @param Array           $memberShips membership ids
     * @param String          $block       Block name
     * @param Array           $selected    Default membership ids
     *
     * @return null
     */
    function getMembershipDropdown($objTpl, $memberShips, $block = "assignedGroup", $selected = array())
    {

        if (!is_array($selected)) {
            return ;
        }

        foreach ($memberShips as $id) {
            $selectedVal = in_array($id, $selected) ? 'selected' : '';

            $objTpl->setVariable(array(
                    "CRM_MEMBERSHIP_ID"         => (int) $id,
                    "CRM_MEMBERSHIP_VALUE"      => contrexx_raw2xhtml($this->_memberShips[$id]),
                    "CRM_MEMBERSHIP_SELECTED"   => $selectedVal
            ));
            $objTpl->parse($block);
        }
    }

    /**
     * Get membership dropdown for overview page
     *
     * @param Template Object $objTpl          Template object
     * @param Object          $modelMembership
     * @param Integer         $selected
     * @param String          $block
     * @param Array           $options
     *
     * @return null
     */
    function getOverviewMembershipDropdown($objTpl, $modelMembership, $selected = 0, $block = "memberships", $options = array())
    {
        $data = array(
                'status = 1'
        );
        $result = $modelMembership->findAllByLang($data);

        if ($options['is_hide'] && $result->RecordCount() < 2) {
            $objTpl->hideBlock('block_memberships');
        } else {
            while (!$result->EOF) {
                $objTpl->setVariable(array(
                        "CRM_MEMBERSHIP_ID"         => (int) $result->fields['id'],
                        "CRM_MEMBERSHIP_VALUE"      => contrexx_raw2xhtml($result->fields['value']),
                        "CRM_MEMBERSHIP_SELECTED"   => ($result->fields['id'] == $selected) ? "selected='selected'" : '',
                ));
                $objTpl->parse($block);
                $result->MoveNext();
            }
        }


    }

    /**
     * Add User in the time of adding a customer based on the account settings
     *
     * @param String  $email            user email id
     * @param String  $password         user password
     * @param Boolean $sendLoginDetails status
     *
     * @return boolean
     */
    function addUser($email, $password, $sendLoginDetails = false, $result = array(), $id)
    {
        global $objDatabase, $_CORELANG, $_ARRAYLANG;

        $settings = $this->getSettings();

        if (!isset($this->contact))
            $this->contact = new crmContact();

        $objFWUser = FWUser::getFWUserObject();

        $modify = isset($this->contact->id) && !empty($this->contact->id);
        $accountId = 0;

        if (!empty($id)) {
            $objUsers = $objFWUser->objUser->getUsers($filter = array('id' => intval($id)));
            if ($objUsers) {
                $accountId = $objUsers->getId();
                $email     = $objUsers->getEmail();
            }
        } else if (empty($id)) {
            $objUsers = $objFWUser->objUser->getUsers($filter = array('email' => addslashes($email)));
            if ($objUsers) {
                $accountId = $objUsers->getId();
            }
        }
        if ($modify) {
            $useralExists = $objDatabase->SelectLimit("SELECT id FROM `".DBPREFIX."module_{$this->moduleName}_contacts` WHERE user_account = {$accountId}", 1);
            if ($useralExists && !empty($useralExists->fields['id']) && !empty($accountId) && intval($useralExists->fields['id']) != $this->contact->id) {
                    $existId     = (int) $useralExists->fields['id'];
                    $custDetails = $this->getExistCrmDetail($existId);
                    $existLink   = "<a href='index.php?cmd={$this->moduleName}&act=customers&tpl=showcustdetail&id=$existId' target='_blank'>{$custDetails['customer_name']} {$custDetails['contact_familyname']}</a>";
                    $this->_strErrMessage = sprintf($_ARRAYLANG['TXT_CRM_CONTACT_ALREADY_EXIST_ERROR'], $existLink);
                    return false;
            }
            $this->contact->account_id = $objDatabase->getOne("SELECT user_account FROM `".DBPREFIX."module_{$this->moduleName}_contacts` WHERE id = {$this->contact->id}");
            if (empty ($this->contact->account_id) && !empty($accountId)) {
                $objUser = $objFWUser->objUser->getUser($accountId);
//            $objUser = new User($accountId);
            } elseif ((!empty($this->contact->account_id) && $objUser = $objFWUser->objUser->getUser($this->contact->account_id)) === false) {
                if (!empty ($accountId)) {
                    $objUser = $objFWUser->objUser->getUser($accountId);
                } else {
                    $objUser = new User();
                    $objUser->setPassword($password);
                }
            } elseif (!empty($accountId) && $useralExists && $useralExists->RecordCount() == 0) {
                $objUser = $objFWUser->objUser->getUser($accountId);
            } else if ((!empty($this->contact->account_id) && $objUser = $objFWUser->objUser->getUser($this->contact->account_id)) === true) {
                if (empty($accountId)) {
                    $objUser = new User();
                    $objUser->setPassword($password);
                } else {
                    $objUser = $objFWUser->objUser->getUser($this->contact->account_id);
                }
            } else if (empty($this->contact->account_id) && empty($accountId)) {
                $objUser = new User();
                $objUser->setPassword($password);
            }
        } else {
            if (empty($accountId)){
                $objUser = new User();
                $objUser->setPassword($password);
            } else {
                $userExists = $objDatabase->getOne("SELECT id FROM `".DBPREFIX."module_{$this->moduleName}_contacts` WHERE user_account = {$accountId}");
                if (empty ($userExists)) {
                    $objUser = $objFWUser->objUser->getUser($accountId);
                } else {
                    $custDetails = $this->getExistCrmDetail($userExists);
                    $existLink   = "<a href='index.php?cmd={$this->moduleName}&act=customers&tpl=showcustdetail&id=$userExists' target='_blank'>{$custDetails['customer_name']} {$custDetails['contact_familyname']}</a>";
                    $this->_strErrMessage = sprintf($_ARRAYLANG['TXT_CRM_CONTACT_ALREADY_EXIST_ERROR'], $existLink);
                    return false;
                }
            }
        }

        //update/insert additional fields
        //company
        if (!empty($result['company'])) {
            $company = $objDatabase->getOne("SELECT customer_name FROM `".DBPREFIX."module_{$this->moduleName}_contacts` WHERE id = '".$result['company']."'");
        }
        //get default website
        foreach ($result['contactwebsite'] as $value) {
            if (!empty($value['value']) && $value['primary'] == '1') {
                $website = contrexx_raw2db($value['value']);
            }
        }
        //get default phone
        foreach ($result['contactphone'] as $value) {
            if (!empty($value['value']) && $value['primary'] == '1')
                $phone = contrexx_input2db($value['value']);
        }
        //get default address
        foreach ($result['contactAddress'] as $value) {
            if ((!empty($value['address']) || !empty($value['city']) || !empty($value['state']) || !empty($value['zip']) || !empty($value['country'])) && $value['primary'] == '1') {
                $address = contrexx_input2db($value['address']);
                $city    = contrexx_input2db($value['city']);
                $zip     = contrexx_input2db($value['zip']);
                $country = $objDatabase->getOne("SELECT id FROM `".DBPREFIX."lib_country` WHERE name = '".$value['country']."'");
            }
        }
        $gender = ($this->contact->contact_gender == 1) ? 'gender_female' : ($this->contact->contact_gender == 2 ? 'gender_male' : 'gender_undefined');
        $setProfileData = array(
            'firstname'    => array(0 => $this->contact->customerName),
            'lastname'     => array(0 => $this->contact->family_name),
            'gender'       => array(0 => $gender),
            'website'      => array(0 => $website),
            'company'      => array(0 => $company),
            'phone_office' => array(0 => $phone),
            'address'      => array(0 => $address),
            'city'         => array(0 => $city),
            'zip'          => array(0 => $zip),
            'country'      => array(0 => $country)
        );
        
        //set profile picture
        $picture = $objDatabase->getOne("SELECT profile_picture FROM `".DBPREFIX."module_{$this->moduleName}_contacts` WHERE id = '".$this->contact->id."'");
        if ($picture && !empty($picture)) {
            if (!file_exists(ASCMS_ACCESS_PROFILE_IMG_PATH.'/'.$picture)) {
                $file = CRM_ACCESS_PROFILE_IMG_PATH.'/';
                if (($picture = self::moveUploadedImageInToPlace($objUser, $file.$picture, $picture, true)) == true) {
                    // create thumbnail
                    if (self::createThumbnailOfImage($picture, true) !== false) {
                        $setProfileData['picture'] = array();
                        array_push($setProfileData['picture'], $picture);
                    }
                }
            }
        }
        $objUser->setUsername($email);
        
        $objUser->setEmail($email);
        $objUser->setGroups((array) $settings['default_user_group']);
        $objUser->setFrontendLanguage($result['contact_language']);
        $objUser->setBackendLanguage($settings['customer_default_language_backend']);
        $objUser->setActiveStatus(true);
        $objUser->setProfile($setProfileData);

        if (empty($objUser->error_msg) && $objUser->store()) {
            if (empty($this->contact->account_id) && $sendLoginDetails) {
                if (trim($objUser->getProfileAttribute('gender')) == 'gender_female') {
                    $saluation = $_ARRAYLANG['TXT_CRM_SALUATION_FEMALE'];
                } else if (trim($objUser->getProfileAttribute('gender')) == 'gender_male') {
                    $saluation = $_ARRAYLANG['TXT_CRM_SALUATION_MALE'];
                } else {
                    $saluation = $_ARRAYLANG['TXT_CRM_SALUATION'];
                }
                $info['substitution'] = array(
                        'CRM_CONTACT_FIRSTNAME'          => contrexx_raw2xhtml($objUser->getProfileAttribute('firstname')),
                        'CRM_CONTACT_LASTNAME'           => contrexx_raw2xhtml($objUser->getProfileAttribute('lastname')),
                        'CRM_ASSIGNED_USER_EMAIL'        => $objUser->getEmail(),
                        'CRM_CONTACT_SALUTATION'         => contrexx_raw2xhtml($saluation),
                        'CRM_ASSIGNED_USER_NAME'         => contrexx_raw2xhtml(FWUser::getParsedUserTitle($objUser->getId())),
                        'CRM_CUSTOMER_COMPANY'           => $this->contact->customerName." ".$this->contact->family_name,
                        'CRM_DOMAIN'                     => ASCMS_PROTOCOL."://{$_SERVER['HTTP_HOST']}".ASCMS_PATH_OFFSET,
                        'CRM_CONTACT_EMAIL'              => $email,
                        'CRM_CONTACT_USERNAME'           => $email,
                        'CRM_CONTACT_PASSWORD'           => $password,
                );
                //setting email template lang id
                $availableMailTempLangAry = $this->getActiveEmailTemLangId('crm', CRM_EVENT_ON_USER_ACCOUNT_CREATED);
                $availableLangId          = $this->getEmailTempLang($availableMailTempLangAry, $email);
                $info['lang_id']          = $availableLangId;  
                
                $dispatcher = CrmEventDispatcher::getInstance();
                $dispatcher->triggerEvent(CRM_EVENT_ON_USER_ACCOUNT_CREATED, null, $info);
            }
            $this->contact->account_id = $objUser->getId();

            return true;
        } else {
            $objUser->reset();
            $this->_strErrMessage = implode("<br />", $objUser->error_msg);
            return  false;
        }

        $this->_strErrMessage = 'Some thing went wrong';
        return false;
    }

    /**
     * get the available email template lang ids
     *
     * @param String $section mail template section name
     * @param String $key     mail template key value
     *
     * @return array
     */
    function getActiveEmailTemLangId($section = 'crm', $key = '')
    {
        global $objDatabase;

        if (empty($section) || empty($key)) {
            return false;
        }
        
        $activeFrontLangId = FWLanguage::getActiveFrontendLanguages();
        $query = "SELECT DISTINCT ct.lang_id FROM `".DBPREFIX."core_text` as ct LEFT JOIN
                                `".DBPREFIX."core_mail_template` as mt ON (ct.id=mt.text_id)
                                    WHERE mt.key = '".$key."' AND mt.section = '".$section."'";
        $objResult = $objDatabase->Execute($query);
        if ($objResult && $objResult->RecordCount() > 0) {
            $activeLangArray = array();
            $finalActiveLangArray = array();
            while (!$objResult->EOF) {
                array_push($activeLangArray, (int) $objResult->fields['lang_id']);
                $objResult->MoveNext();
            }
            foreach ($activeFrontLangId As $val) {
                if (in_array($val['id'], $activeLangArray)) {
                    array_push($finalActiveLangArray, $val['id']);
                }
            }
            return $finalActiveLangArray;
        }
        return false;
    }

    /**
     * get the email template lang id for sending mail
     *
     * @param Array  $availableEmailTemp available email template ids
     * @param String $email              recipient email id
     *
     * @return Integer
     */
    function getEmailTempLang($availableEmailTemp = array(), $email = '')
    {
        global $objFWUser;
        
        if (empty($email))
            return false;
        $defaultLangId = FWLanguage::getDefaultLangId();
        
        /**
         * This IF clause fixes #1799, but there has to be a better solution for this!
         */
        if (!$objFWUser->objUser) {
            return false;
        }
        $objUsers = $objFWUser->objUser->getUsers($filter = array('email' => addslashes($email)));
        if ($objUsers) {
            $availableLangId = '';
            switch (true) {
            case ($objUsers->getBackendLanguage() && in_array($objUsers->getBackendLanguage(), $availableEmailTemp)):
                $availableLangId = $objUsers->getBackendLanguage();
                break;
            case ($objUsers->getFrontendLanguage() && in_array($objUsers->getFrontendLanguage(), $availableEmailTemp)):
                $availableLangId =  $objUsers->getFrontendLanguage();
                break;
            case ($defaultLangId && in_array($defaultLangId, $availableEmailTemp)):
                $availableLangId =  $defaultLangId;
                break;
            default:
                $availableLangId = $availableEmailTemp[0];
                break;
            }
            return $availableLangId;
        } else {
            switch (true) {
            case ($defaultLangId && in_array($defaultLangId, $availableEmailTemp)):
                $availableLangId =  $defaultLangId;
                break;
            default:
                $availableLangId = $availableEmailTemp[0];
                break;
            }
            return $availableLangId;
        }
        return false;
    }
    
    /**
     * get exist crm account detail
     *
     * @param integer $id
     *
     * @return array
     */
    function getExistCrmDetail($id)
    {
        global $objDatabase;

        if (empty($id)) {
            return false;
        }

        $query = "SELECT id, customer_name, contact_familyname FROM `".DBPREFIX."module_{$this->moduleName}_contacts` WHERE `id` = {$id}";
        $objResult = $objDatabase->Execute($query);

        if ($objResult && $objResult->RecordCount()) {
            $result = array(
                'customer_name'      => contrexx_raw2xhtml($objResult->fields['customer_name']),
                'contact_familyname' => contrexx_raw2xhtml($objResult->fields['contact_familyname'])
            );
            return $result;
        }
    }
    /**
     * Make the url string's into clickable link's.
     * Example: <p> http://www.contrexx.com </p> will be
     * <p> <a href="http://www.contrexx.com" rel="nofollow"> http://www.contrexx.com </a> </p>
     *
     * @param String $html
     *
     * @return string $html
     */
    function makeLinksInTheContent($html)
    {
        $html= preg_replace("/(^|[\n ])([\w]*?)((ht|f)tp(s)?:\/\/[\w]+[^ \,\"\n\r\t<]*)/is", "$1$2<a href=\"$3\" rel=\"nofollow\" >$3</a>", $html);
        $html= preg_replace("/(^|[\n ])([\w]*?)((www|ftp)\.[^ \,\"\t\n\r<]*)/is", "$1$2<a href=\"http://$3\" rel=\"nofollow\" >$3</a>", $html);
        $html= preg_replace("/(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+)+)/i", "$1<a href=\"mailto:$2@$3\" rel=\"nofollow\">$2@$3</a>", $html);

        return($html);
    }

    /**
     * Adding Crm Contact
     *
     * @param Array $arrFormData form data's
     *
     * @return null
     */
    function addCrmContact($arrFormData = array())
    {
        global $objDatabase;

        $this->contact = new crmContact();
        $objFWUser = FWUser::getFWUserObject();

        $fieldValues = array();
        foreach ($arrFormData['fields'] as $key => $value) {
            $fieldName = isset ($arrFormData['fields'][$key]['special_type']) ? $arrFormData['fields'][$key]['special_type'] : '';
            $fieldValue = isset ($arrFormData['data'][$key]) ? $arrFormData['data'][$key] : '';
            if (!empty ($fieldName)) {
                $fieldValues[$fieldName] = $fieldValue;
            }
        }

        if (!empty ($fieldValues['access_email'])) {
            $objEmail = $objFWUser->objUser->getUsers($filter = array('email' => contrexx_input2db($fieldValues['access_email'])));

            if (!empty ($fieldValues['access_gender'])) {
                $gender            = '';
                $accessAttributeId = 'gender';
                $objAttribute = FWUser::getFWUserObject()->objUser->objAttribute->getById($accessAttributeId);

                // get options
                $arrAttribute = $objAttribute->getChildren();

                foreach ($arrAttribute as $attributeId) {
                    $objAttribute = FWUser::getFWUserObject()->objUser->objAttribute->getById($attributeId);
                    if ($objAttribute->getName(FRONTEND_LANG_ID) == $fieldValues['access_gender']) {
                        $gender = $attributeId;
                    }
                }
            }

            $this->contact->customerName   = !empty ($fieldValues['access_firstname']) ? contrexx_input2raw($fieldValues['access_firstname']) : '';
            $this->contact->family_name    = !empty ($fieldValues['access_lastname']) ? contrexx_input2raw($fieldValues['access_lastname']) : '';
            $this->contact->contact_gender = !empty ($fieldValues['access_gender']) ? ($gender == 'gender_female' ? 1 : ($gender == 'gender_male' ? 2 : '')) : '';

            $this->contact->contactType    = 2;
            $this->contact->datasource     = 2;

            if ($objEmail) {
                $accountId = $objEmail->getId();
                $userExists = $objDatabase->SelectLimit("SELECT 1 FROM `".DBPREFIX."module_{$this->moduleName}_contacts` WHERE user_account = {$accountId}", 1);

                if ($userExists && $userExists->RecordCount() == 0) {
                    $this->contact->account_id     = $accountId;
                }
            }

            if ($this->contact->save()) {

                //insert email
                $query = "INSERT INTO `".DBPREFIX."module_{$this->moduleName}_customer_contact_emails` SET
                                email      = '". contrexx_input2db($fieldValues['access_email']) ."',
                                email_type = '0',
                                is_primary = '1',
                                contact_id = '{$this->contact->id}'";
                $objDatabase->Execute($query);
                // insert website
                if (!empty ($fieldValues['access_website'])) {
                    $fields = array(
                        'url'           => $fieldValues['access_website'],
                        'url_profile'   => 1,
                        'is_primary'    => 1,
                        'contact_id'    => $this->contact->id
                    );
                    $query  = SQL::insert("module_{$this->moduleName}_customer_contact_websites", $fields, array('escape' => true));
                    $db = $objDatabase->Execute($query);
                }

                //insert address
                if (!empty ($fieldValues['access_address']) || !empty ($fieldValues['access_city']) || !empty ($fieldValues['access_zip']) || !empty ($fieldValues['access_country'])) {

                    $query = "INSERT INTO `".DBPREFIX."module_{$this->moduleName}_customer_contact_address` SET
                                    address      = '". contrexx_input2db($fieldValues['access_address']) ."',
                                    city         = '". contrexx_input2db($fieldValues['access_city']) ."',
                                    state        = '". contrexx_input2db($fieldValues['access_state']) ."',
                                    zip          = '". contrexx_input2db($fieldValues['access_zip']) ."',
                                    country      = '". contrexx_input2db($fieldValues['access_country']) ."',
                                    Address_Type = '2',
                                    is_primary   = '1',
                                    contact_id   = '{$this->contact->id}'";

                    $objDatabase->Execute($query);
                }

                // insert Phone
                $contactPhone = array();
                if (!empty($fieldValues['access_phone_office'])) {
                    $contactPhone[] = array(
                        'value'   => $fieldValues['access_phone_office'],
                        'type'    => 1
                    );
                }
                if (!empty($fieldValues['access_phone_private'])) {
                    $contactPhone[] = array(
                        'value'   => $fieldValues['access_phone_private'],
                        'type'    => 0
                    );
                }
                if (!empty($fieldValues['access_phone_mobile'])) {
                    $contactPhone[] = array(
                        'value'   => $fieldValues['access_phone_mobile'],
                        'type'    => 3
                    );
                }
                if (!empty($fieldValues['access_phone_fax'])) {
                    $contactPhone[] = array(
                        'value'   => $fieldValues['access_phone_fax'],
                        'type'    => 4
                    );
                }
                if (!empty($contactPhone)) {
                    $query = "INSERT INTO `".DBPREFIX."module_{$this->moduleName}_customer_contact_phone` (phone, phone_type, is_primary, contact_id) VALUES ";

                    $first = true;
                    foreach ($contactPhone as $value) {
                        $primary = $first ? 1 : 0;
                        $values[] = "('".contrexx_input2db($value['value'])."', '".(int) $value['type']."', '".$primary."', '".$this->contact->id."')";
                        $first = false;
                    }

                    $query .= implode(",", $values);
                    $objDatabase->Execute($query);
                }
                // notify the staff's
                $this->notifyStaffOnContactAccModification($this->contact->id, $this->contact->customerName, $this->contact->family_name, $this->contact->contact_gender);
            }
        }
    }

    /**
     * Adding Crm Contact
     *
     * @param Array $arrFormData form data's
     *
     * @return null
     */
    function setContactPersonProfile($arrFormData = array(), $userAccountId = 0, $frontendLanguage)
    {
        global $objDatabase, $_LANGID;

        $this->contact = new crmContact();

        if (!empty ($userAccountId)) {
            $userExists = $objDatabase->Execute("SELECT id FROM `".DBPREFIX."module_{$this->moduleName}_contacts` WHERE user_account = {$userAccountId}");
            if ($userExists && $userExists->RecordCount()) {
                $id = (int) $userExists->fields['id'];
                $this->contact->load($id);
                $this->contact->customerName   = !empty ($arrFormData['firstname'][0]) ? contrexx_input2raw($arrFormData['firstname'][0]) : '';
                $this->contact->family_name    = !empty ($arrFormData['lastname'][0]) ? contrexx_input2raw($arrFormData['lastname'][0]) : '';
                $this->contact->contact_language = !empty ($frontendLanguage) ? (int) $frontendLanguage : $_LANGID;
                $this->contact->contact_gender = !empty ($arrFormData['gender'][0]) ? ($arrFormData['gender'][0] == 'gender_female' ? 1 : ($arrFormData['gender'][0] == 'gender_male' ? 2 : '')) : '';

                $this->contact->contactType    = 2;
                $this->contact->datasource     = 2;
                $this->contact->account_id     = $userAccountId;

                //set profile picture
                if (!empty ($arrFormData['picture'][0])) {
                    $picture = $arrFormData['picture'][0];
                    if (!file_exists(CRM_ACCESS_PROFILE_IMG_PATH.'/'.$picture)) {
                        $file    = ASCMS_ACCESS_PROFILE_IMG_PATH.'/';
                        $newFile = CRM_ACCESS_PROFILE_IMG_PATH.'/';
                        if (copy($file.$picture, $newFile.$picture)) {
                            if ($this->createThumbnailOfPicture($picture)) {
                                $this->contact->profile_picture = $picture;
                            }
                        }
                    }
                } else {
                    $this->contact->profile_picture = 'profile_person_big.png';
                }

                if ($this->contact->save()) {

                    // insert website
                    if (!empty ($arrFormData['website'][0])) {
                        $webExists = $objDatabase->SelectLimit("SELECT 1 FROM `".DBPREFIX."module_{$this->moduleName}_customer_contact_websites` WHERE is_primary = '1' AND contact_id = '{$this->contact->id}'");
                        $fields = array(
                            'url'           => $arrFormData['website'][0],
                            'url_profile'   => '1',
                            'is_primary'    => '1',
                            'contact_id'    => $this->contact->id
                        );
                        if ($webExists) {
                            $query  = SQL::update("module_{$this->moduleName}_customer_contact_websites", $fields, array('escape' => true))." WHERE is_primary = '1' AND `contact_id` = {$this->contact->id}";
                        } else {
                            $query  = SQL::insert("module_{$this->moduleName}_customer_contact_websites", $fields, array('escape' => true));
                        }
                        $db = $objDatabase->Execute($query);
                    }

                    //insert address
                    if (!empty ($arrFormData['address'][0]) || !empty ($arrFormData['city'][0]) || !empty ($arrFormData['zip'][0]) || !empty ($arrFormData['country'][0])) {
                        $addressExists = $objDatabase->SelectLimit("SELECT 1 FROM `".DBPREFIX."module_{$this->moduleName}_customer_contact_address` WHERE is_primary = 1 AND contact_id = '{$this->contact->id}'");
                        if ($addressExists) {
                            $query = "UPDATE `".DBPREFIX."module_{$this->moduleName}_customer_contact_address` SET
                                    address      = '". contrexx_input2db($arrFormData['address'][0]) ."',
                                    city         = '". contrexx_input2db($arrFormData['city'][0]) ."',
                                    zip          = '". contrexx_input2db($arrFormData['zip'][0]) ."',
                                    country      = '". $objDatabase->getOne("SELECT name FROM `".DBPREFIX."lib_country` WHERE id = '".$arrFormData['country'][0]."'") ."',
                                    Address_Type = '2'
                                 WHERE is_primary   = '1' AND contact_id   = '{$this->contact->id}'";
                        } else {
                            $query = "INSERT INTO `".DBPREFIX."module_{$this->moduleName}_customer_contact_address` SET
                                    address      = '". contrexx_input2db($arrFormData['address'][0]) ."',
                                    city         = '". contrexx_input2db($arrFormData['city'][0]) ."',
                                    state        = '". contrexx_input2db($arrFormData['city'][0]) ."',
                                    zip          = '". contrexx_input2db($arrFormData['zip'][0]) ."',
                                    country      = '". $objDatabase->getOne("SELECT name FROM `".DBPREFIX."lib_country` WHERE id = '".$arrFormData['country'][0]."'") ."',
                                    Address_Type = '2',
                                    is_primary   = '1',
                                    contact_id   = '{$this->contact->id}'";
                        }
                        $objDatabase->Execute($query);
                    }

                    // insert Phone
                    $contactPhone = array();
                    if (!empty($arrFormData['phone_office'][0])) {
                        $phoneExists = $objDatabase->SelectLimit("SELECT 1 FROM `".DBPREFIX."module_{$this->moduleName}_customer_contact_phone` WHERE is_primary = '1' AND contact_id = '{$this->contact->id}'");
                        $fields = array(
                            'phone'         => $arrFormData['phone_office'][0],
                            'phone_type'    => '1',
                            'is_primary'    => '1',
                            'contact_id'    => $this->contact->id
                        );
                        if ($phoneExists) {
                            $query  = SQL::update("module_{$this->moduleName}_customer_contact_phone", $fields, array('escape' => true))." WHERE is_primary = '1' AND `contact_id` = {$this->contact->id}";
                        } else {
                            $query  = SQL::insert("module_{$this->moduleName}_customer_contact_phone", $fields, array('escape' => true));
                        }
                        $objDatabase->Execute($query);
                    }
                }
            }
        }
    }

    /**
     * Create thumbnail of image
     *
     * @param String  $imageName
     * @param Boolean $profilePic
     *
     * @return String
     */
    static function createThumbnailOfImage($imageName, $profilePic=false)
    {
        if (empty($objImage)) {
            $objImage = new ImageManager();
        }

        return $objImage->_createThumbWhq(
                ASCMS_ACCESS_PROFILE_IMG_PATH.'/',
                ASCMS_ACCESS_PROFILE_IMG_WEB_PATH.'/',
                $imageName,
                80,
                60,
                90
            );
    }

    /**
     * Move uploaded image into respective folder
     *
     * @param Object  $objUser
     * @param String  $tmpImageName
     * @param String  $name
     * @param Boolean $profilePic
     *
     * @return String
     */
    protected static function moveUploadedImageInToPlace($objUser, $tmpImageName, $name, $profilePic = false)
    {
        static $objImage, $arrSettings;

        if (empty($objImage)) {
            $objImage = new ImageManager();
        }
        if (empty($arrSettings)) {
            $arrSettings = array();
            $arrSettings['profile_thumbnail_pic_width']['value'] = 80;
            $arrSettings['profile_thumbnail_pic_height']['value'] = 60;
            $arrSettings['profile_thumbnail_scale_color']['value'] = '';
            $arrSettings['profile_thumbnail_method']['value'] = '';
            $arrSettings['max_profile_pic_width']['value'] = 160;
            $arrSettings['max_profile_pic_height']['value'] = 160;
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
        if ($objImage->orgImageWidth > $arrSettings['max_profile_pic_width']['value'] ||
            $objImage->orgImageHeight > $arrSettings['max_profile_pic_height']['value']
        ) {
            $ratioWidth = $arrSettings['max_profile_pic_width']['value'] / $objImage->orgImageWidth;
            $ratioHeight = $arrSettings['max_profile_pic_height']['value'] / $objImage->orgImageHeight;
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
    
    /**
     * Create thumbnail of image
     *
     * @param String $imageName
     *
     * @return String
     */
    protected function createThumbnailOfPicture($imageName)
    {
        if (empty($objImage)) {
            $objImage = new ImageManager();
        }

        $objImage->_createThumbWhq(
                CRM_ACCESS_PROFILE_IMG_PATH.'/',
                CRM_ACCESS_PROFILE_IMG_WEB_PATH.'/',
                $imageName,
                40,
                40,
                70,
                '_40X40.thumb'
            );

        return $objImage->_createThumbWhq(
                CRM_ACCESS_PROFILE_IMG_PATH.'/',
                CRM_ACCESS_PROFILE_IMG_WEB_PATH.'/',
                $imageName,
                121,
                160,
                70
            );

    }
    
    /**
     * Inits the uploader when displaying a contact form.
     *
     * @param Integer $fieldId
     * @param Boolean $restrictUpload2SingleFile
     * @param String  $callBackFun
     * @param Integer $data
     * @param String  $dir
     *
     * @return null
     */
    function initUploader($fieldId, $restrictUpload2SingleFile = true, $callBackFun = 'uploadFinished', $data, $dir) {
        try {
            //init the uploader
            JS::activate('cx'); //the uploader needs the framework
            $f = UploadFactory::getInstance();

            /**
            * Name of the upload instance
            */
            $uploaderInstanceName = 'exposed_combo_uploader_'.$fieldId;

            /**
            * jQuery selector of the HTML-element where the upload folder-widget shall be put in
            */
            $uploaderFolderWidgetContainer = '#contactFormField_uploadWidget_'.$fieldId;
            $uploaderWidgetName = 'uploadWidget'.$fieldId;

            $uploader = $f->newUploader('exposedCombo', 0, $restrictUpload2SingleFile);
            $uploadId = $uploader->getUploadId();

            //set instance name so we are able to catch the instance with js
            $uploader->setJsInstanceName($uploaderInstanceName);

            // specifies the function to call when upload is finished. must be a static function
            $uploader->setFinishedCallback(array(ASCMS_MODULE_PATH.'/crm/admin.class.php', 'CrmManager', $callBackFun));
            $uploadId = $uploader->getUploadId();
            $uploader->setData($data);


            //retrieve temporary location for uploaded files
            $tup = self::getTemporaryUploadPath($uploadId, $fieldId, $dir);

            //create the folder
            if (!\Cx\Lib\FileSystem\FileSystem::make_folder($tup[1].'/'.$tup[2])) {
                throw new ContactException("Could not create temporary upload directory '".$tup[0].'/'.$tup[2]."'");
            }

            if (!\Cx\Lib\FileSystem\FileSystem::makeWritable($tup[1].'/'.$tup[2])) {
                //some hosters have problems with ftp and file system sync.
                //this is a workaround that seems to somehow show php that
                //the directory was created. clearstatcache() sadly doesn't
                //work in those cases.
                @closedir(@opendir($tup[0]));

                if (!\Cx\Lib\FileSystem\FileSystem::makeWritable($tup[1].'/'.$tup[2])) {
                    throw new ContactException("Could not chmod temporary upload directory '".$tup[0].'/'.$tup[2]."'");
                }
            }

            //initialize the widget displaying the folder contents
            $folderWidget = $f->newFolderWidget($tup[0].'/'.$tup[2], $uploaderInstanceName);

            $strInputfield = $folderWidget->getXHtml($uploaderFolderWidgetContainer, $uploaderWidgetName);
            $strInputfield .= $uploader->getXHtml();

            JS::registerJS('core_modules/upload/js/uploaders/exposedCombo/extendedFileInput.js');

            $strInputfield .= <<<CODE
            <script type="text/javascript">
            cx.ready(function() {
                    var ef = new ExtendedFileInput({
                            field:  cx.jQuery('#contactFormFieldId_$fieldId'),
                            instance: '$uploaderInstanceName',
                            widget: '$uploaderWidgetName'
                    });
            });
            </script>
CODE;
            return $strInputfield;
        }
        catch (Exception $e) {
            return '<!-- failed initializing uploader, exception '.get_class($e).' with message "'.$e->getMessage().'" -->';
        }
    }

    /**
     * Gets the temporary upload location for files.
     * @param integer $submissionId
     * @return array('path','webpath', 'dirname')
     * @throws ContactException
     */
    protected static function getTemporaryUploadPath($submissionId, $fieldId, $dir) {
        global $sessionObj;

        if (!isset($sessionObj)) $sessionObj = new cmsSession();

        $tempPath = $sessionObj->getTempPath();
        $tempWebPath = $sessionObj->getWebTempPath();
        if($tempPath === false || $tempWebPath === false)
            throw new ContactException('could not get temporary session folder');

        $dirname = $dir.$submissionId.'_'.$fieldId;
        $result = array(
            $tempPath,
            $tempWebPath,
            $dirname
        );
        return $result;
    }

    /**
     * notify the staffs regarding the account modification of a contact
     *
     * @param Integer $customerId    customer id
     * @param String  $first_name customer first name
     * @param String  $last_name customer last name
     *
     * @access public
     * @global object $objTemplate
     * @global array  $_ARRAYLANG
     *
     * @return null
     */
    public function notifyStaffOnContactAccModification($customerId = 0, $first_name = '', $last_name = '', $gender = 0)
    {
        global $objDatabase, $_ARRAYLANG;

        if (empty($customerId)) return false;
        
        $objFWUser = FWUser::getFWUserObject();
        $settings = $this->getSettings();
        $resources = $this->getResources($settings['emp_default_user_group']);
        $customer_name = $first_name." ".$last_name;
        $contact_gender = ($gender == 1) ? "gender_female" : ($gender == 2 ? "gender_male" : 'gender_undefined');
        $emailIds    = array();
        foreach ($resources as $key => $value) {
            $emailIds[]    = $value['email'];
        }
        
        foreach ($emailIds As $emails) {
            if (!empty ($emails)) {
                $objUsers = $objFWUser->objUser->getUsers($filter = array('email' => addslashes($emails)));
                $info['substitution'] = array(
                    'CRM_ASSIGNED_USER_NAME'            => contrexx_raw2xhtml(FWUser::getParsedUserTitle($objUsers->getId())),
                    'CRM_ASSIGNED_USER_EMAIL'           => $emails,
                    'CRM_CONTACT_FIRSTNAME'             => contrexx_raw2xhtml($first_name),
                    'CRM_CONTACT_LASTNAME'              => contrexx_raw2xhtml($last_name),
                    'CRM_CONTACT_GENDER'                => contrexx_raw2xhtml($contact_gender),
                    'CRM_DOMAIN'                        => ASCMS_PROTOCOL."://{$_SERVER['HTTP_HOST']}".ASCMS_PATH_OFFSET,
                    'CRM_CONTACT_DETAILS_URL'           => ASCMS_PROTOCOL."://{$_SERVER['HTTP_HOST']}". ASCMS_ADMIN_WEB_PATH ."/index.php?cmd={$this->moduleName}&act=customers&tpl=showcustdetail&id=$customerId",
                    'CRM_CONTACT_DETAILS_LINK'          => "<a href='". ASCMS_PROTOCOL."://{$_SERVER['HTTP_HOST']}". ASCMS_ADMIN_WEB_PATH ."/index.php?cmd={$this->moduleName}&act=customers&tpl=showcustdetail&id=$customerId'>".$customer_name."</a>"
                );
                //setting email template lang id
                $availableMailTempLangAry = $this->getActiveEmailTemLangId('crm', CRM_EVENT_ON_ACCOUNT_UPDATED);
                $availableLangId          = $this->getEmailTempLang($availableMailTempLangAry, $emails);
                $info['lang_id']          = $availableLangId;
                
                $dispatcher = CrmEventDispatcher::getInstance();
                $dispatcher->triggerEvent(CRM_EVENT_ON_ACCOUNT_UPDATED, null, $info);
            }
        }
    }

     /**
     * Escape a value that it could be inserted into a csv file.
     *
     * @param string $value
      *
     * @return string
     */
    function _escapeCsvValue($value)
    {

        $csvSeparator = $this->_csvSeparator;
        $value = in_array(strtolower(CONTREXX_CHARSET), array('utf8', 'utf-8')) ? utf8_decode($value) : $value;
        $value = preg_replace('/\r\n/', "\n", $value);
        $valueModified = str_replace('"', '""', $value);

        if ($valueModified != $value || preg_match('/['.$csvSeparator.'\n]+/', $value)) {
            $value = '"'.$valueModified.'"';
        }
        return $value;
    }

    /**
     * Returns true if the given $username is valid
     *
     * @param string $username
     *
     * @return  boolean
     */
    protected function isValidUsername($username)
    {
        if (preg_match('/^[a-zA-Z0-9-_]+$/', $username)) {
            return true;
        }

        if (FWValidator::isEmail($username)) {
            return true;
        }
        return false;
    }

    /**
     * Returns true if $username is a unique user name
     *
     * Returns false if the test for uniqueness fails, or if the $username
     * exists already.
     * If non-empty, the given User ID is excluded from the search, so the
     * User does not match herself.
     *
     * @param string  $email The email to test
     * @param integer $id    The optional current User ID
     *
     * @return boolean True if the username is available,
     *                 false otherwise
     */
    protected function isUniqueUsername($email, $id=0)
    {
        global $objDatabase, $_ARRAYLANG;

        $objFWUser = FWUser::getFWUserObject();
        $objResult = $objFWUser->objUser->isUniqueEmail($email, $id);
        if (!$objResult) {
            $objEmail = $objFWUser->objUser->getUsers($filter = array('email' => addslashes($email)));
            if ($objEmail) {
                $accountId = $objEmail->getId();
                if ($accountId != $id) {
                    $error = $_ARRAYLANG['TXT_CRM_ERROR_EMAIL_USED_BY_OTHER_PERSON'];
                } else {
                    $error = $_ARRAYLANG['TXT_CRM_USER_EMAIL_ALERT'];
                }
                return $error;
            }
        }
        return false;
    }

    /**
     * Returns true or false for task edit and delete permission
     *
     * Returns true or false for task edit and delete permission.
     *
     * @param Integer $added_user    The addeduser of the task
     * @param Integer $assigned_user responsible user
     *
     * @return boolean True if the user has the access,
     *                 false otherwise
     */
    protected function getTaskPermission($added_user, $assigned_user)
    {

        $task_edit_permission          = false;
        $task_delete_permission        = false;
        $task_status_update_permission = false;

        $objFWUser              = FWUser::getFWUserObject();
        if ($objFWUser->objUser->login() &&
            (
                $objFWUser->objUser->getAdminStatus() ||
                $objFWUser->objUser->getId() == $added_user ||
                $objFWUser->objUser->getId() == $assigned_user
            )
        ) {
            $task_edit_permission          = true;
            $task_status_update_permission = true;
        }

        if ($objFWUser->objUser->login() &&
            (
                $objFWUser->objUser->getAdminStatus() ||
                $objFWUser->objUser->getId() == $added_user
            )
        ) {
            $task_delete_permission = true;
        }

        return array($task_edit_permission, $task_delete_permission, $task_status_update_permission);
    }

    /**
     * Get username
     *
     * @param Integer $userId
     *
     * @return String
     */
    function getUserName($userId)
    {
        if (!empty ($userId)) {
            $objFWUser  = FWUser::getFWUserObject();
            $objUser    = $objFWUser->objUser->getUser($userId);
            $userName   = $objUser->getRealUsername();
            if ($userName) {
                return $userName;
            } else {
                return $objUser->getUsername();
            }
        }
    }

    /**
     * Get username
     *
     * @param Integer $userId
     *
     * @return String
     */
    function getEmail($userId)
    {
        if (!empty ($userId)) {
            $objFWUser  = FWUser::getFWUserObject();
            $objUser    = $objFWUser->objUser->getUser($userId);
            $email      = $objUser ? $objUser->getEmail() : '';
            if ($email) {
                return $email;
            }

            return false;
        }
    }

    /**
     * get the count of entries
     *
     * @param String $query
     *
     * @global array $_ARRAYLANG
     * @global object $objDatabase
     *
     * @return true
     */
    function countRecordEntries($query)
    {
        global $objDatabase;

        $objEntryResult = $objDatabase->Execute('SELECT  COUNT(*) AS numberOfEntries
                                                    FROM    ('.$query.') AS num');

        return intval($objEntryResult->fields['numberOfEntries']);
    }

    /**
     * Counts all existing entries in the database.
     *
     * @param String $table table name
     * @param String $where condition
     *
     * @global  ADONewConnection
     *
     * @return integer number of entries in the database
     */
    function countEntries($table, $where=null)
    {

        global $objDatabase;
        $objEntryResult = $objDatabase->Execute('SELECT  COUNT(*) AS numberOfEntries FROM '.DBPREFIX.'module_'.
                $table.$where);

        return intval($objEntryResult->fields['numberOfEntries']);
    }

    /**
     * Counts all existing entries in the database.
     *
     * @param String $table table name
     *
     * @global ADONewConnection
     *
     * @return integer number of entries in the database
     */
    function countEntriesOfJoin($table)
    {
        global $objDatabase;

        $objEntryResult = $objDatabase->Execute('SELECT  COUNT(*) AS numberOfEntries
                                                    FROM    ('.$table.') AS num');

        return intval($objEntryResult->fields['numberOfEntries']);
    }

    /**
     * Default PM Calendar Month Page
     *
     * @param String $URI            url
     * @param String $paramName      parameter name
     * @param String $selectedLetter Selected letter
     *
     * @global array $_ARRAYLANG
     * @global object $objDatabase
     *
     * @return true
     */
    function parseLetterIndexList($URI, $paramName, $selectedLetter)
    {
        global $_CORELANG;

        if ($this->_objTpl->blockExists('module_'.$this->moduleName.'_letter_index_list')) {
            $arrLetters[]   = 48;
            $arrLetters     = array_merge($arrLetters, range(65, 90)); // ascii codes of characters "A" to "Z"
            $arrLetters[]   = '';

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
                        'ACCESS_USER_LETTER_INDEX_URI'      => $URI.(!empty($letter) ? '&amp;'.$paramName.'='.chr($letter) : null),
                        'ACCESS_USER_LETTER_INDEX_LETTER'   => $parsedLetter
                ));

                $this->_objTpl->parse('module_'.$this->moduleName.'_letter_index_list');
            }
        }
    }

    /**
     * Returns the allowed maximum element per page. Can be used for paging.
     *
     * @global  array
     *
     * @return  integer     allowed maximum of elements per page.
     */
    function getPagingLimit()
    {
        global $_CONFIG;
        return intval($_CONFIG['corePagingLimit']);
    }

    /**
     * Registers all css and js to be loaded for crm module
     *
     */
    public function _initCrmModule()
    {
        JS::activate('cx');
        JS::activate('jqueryui');
        JS::registerJS("modules/crm/View/Script/main.js");
        JS::registerCSS("modules/crm/View/Style/main.css");
    }

}
