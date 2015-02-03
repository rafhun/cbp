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
 * Manages settings stored in the database
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Reto Kohli <reto.kohli@comvation.com> (parts)
 * @version     3.0.0
 * @package     contrexx
 * @subpackage  core
 * @todo        Edit PHP DocBlocks!
 */

/**
 * Manages settings stored in the database
 *
 * Before trying to access a modules' settings, *DON'T* forget to call
 * {@see SettingDb::init()} before calling getValue() for the first time!
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Reto Kohli <reto.kohli@comvation.com> (parts)
 * @version     3.0.0
 * @package     contrexx
 * @subpackage  core
 * @todo        Edit PHP DocBlocks!
 */
class SettingDb
{
    /**
     * Upload path for documents
     * Used externally only, see hotelcard module for an example.
     */
    const FILEUPLOAD_FOLDER_PATH = 'media';

    /**
     * Setting types
     * See {@see show()} for examples on how to extend these.
     */
    const TYPE_DROPDOWN = 'dropdown';
    const TYPE_DROPDOWN_USER_CUSTOM_ATTRIBUTE = 'dropdown_user_custom_attribute';
    const TYPE_DROPDOWN_USERGROUP = 'dropdown_usergroup';
    const TYPE_WYSIWYG = 'wysiwyg';
    const TYPE_FILEUPLOAD = 'fileupload';
    const TYPE_TEXT = 'text';
    const TYPE_TEXTAREA = 'textarea';
    const TYPE_EMAIL = 'email';
    const TYPE_BUTTON = 'button';
// 20110224
    const TYPE_CHECKBOX = 'checkbox';
    const TYPE_CHECKBOXGROUP = 'checkboxgroup';
// 20120508
    const TYPE_RADIO = 'radio';
// Not implemented
//    const TYPE_SUBMIT = 'submit';

    /**
     * Default width for input fields
     *
     * Note that textareas often use twice that value.
     */
    const DEFAULT_INPUT_WIDTH = 300;

    /**
     * The array of currently loaded settings settings, like
     *  array(
     *    'name' => array(
     *      'section' => section,
     *      'group' => group,
     *      'value' => current value,
     *      'type' => element type (text, dropdown, ... [more to come]),
     *      'values' => predefined values (for dropdown),
     *      'ord' => ordinal number (for sorting),
     *    ),
     *    ... more ...
     *  );
     * @var     array
     * @static
     * @access  private
     */
    private static $arrSettings = null;

    /**
     * The group last used to {@see init()} the settings.
     * Defaults to null (ignored).
     * @var     string
     * @static
     * @access  private
     */
    private static $group = null;

    /**
     * The section last used to {@see init()} the settings.
     * Defaults to null (which will cause an error in most methods).
     * @var     string
     * @static
     * @access  private
     */
    private static $section = null;

    /**
     * Changed flag
     *
     * This flag is set to true as soon as any change to the settings is detected.
     * It is cleared whenever {@see updateAll()} is called.
     * @var     boolean
     * @static
     * @access  private
     */
    private static $changed = false;
    /**
     * Returns the current value of the changed flag.
     *
     * If it returns true, you probably want to call {@see updateAll()}.
     * @return  boolean           True if values have been changed in memory,
     *                            false otherwise
     */
    static function changed()
    {
        return self::$changed;
    }

    /**
     * Tab counter for the {@see show()} and {@see show_external()}
     * @var     integer
     * @access  private
     */
    private static $tab_index = 1;


    /**
     * Optionally sets and returns the value of the tab index
     * @param   integer             The optional new tab index
     * @return  integer             The current tab index
     */
    static function tab_index($tab_index=null)
    {
        if (isset($tab_index)) {
            self::$tab_index = intval($tab_index);
        }
        return self::$tab_index;
    }


    /**
     * Initialize the settings entries from the database with key/value pairs
     * for the current section and the given group
     *
     * An empty $group value is ignored.  All records with the section are
     * included in this case.
     * Note that all setting names *SHOULD* be unambiguous for the entire
     * section.  If there are two settings with the same name but different
     * $group values, the second one may overwrite the first!
     * @internal  The records are ordered by
     *            `group` ASC, `ord` ASC, `name` ASC
     * @param   string    $section    The section
     * @param   string    $group      The optional group.
     *                                Defaults to null
     * @return  boolean               True on success, false otherwise
     * @global  ADOConnection   $objDatabase
     */
    static function init($section, $group=null)
    {
        global $objDatabase;

        if (empty($section)) {
die("SettingDb::init($section, $group): ERROR: Missing \$section parameter!");
//                return false;
        }
        self::flush();
//echo("SettingDb::init($section, $group): Entered<br />");
        $objResult = $objDatabase->Execute("
            SELECT `name`, `group`, `value`,
                   `type`, `values`, `ord`
              FROM ".DBPREFIX."core_setting
             WHERE `section`='".addslashes($section)."'".
             ($group ? " AND `group`='".addslashes($group)."'" : '')."
             ORDER BY `group` ASC, `ord` ASC, `name` ASC");
        if (!$objResult) return self::errorHandler();
        // Set the current group to the empty string if empty
        self::$section = $section;
        self::$group = $group;
        self::$arrSettings = array();
        while (!$objResult->EOF) {
            self::$arrSettings[$objResult->fields['name']] = array(
                'section' => $section,
                'group' => $objResult->fields['group'],
                'value' => $objResult->fields['value'],
                'type' => $objResult->fields['type'],
                'values' => $objResult->fields['values'],
                'ord' => $objResult->fields['ord'],
            );
//echo("Setting ".$objResult->fields['name']." = ".$objResult->fields['value']."<br />");
            $objResult->MoveNext();
        }
        return true;
    }


    /**
     * Flush the stored settings
     *
     * Resets the class to its initial state.
     * Does *NOT* clear the section, however.
     * @return  void
     */
    static function flush()
    {
        self::$arrSettings = null;
        self::$section = null;
        self::$group = null;
        self::$changed = null;
    }


    /**
     * Returns the settings array for the given section and group
     *
     * See {@see init()} on how the arguments are used.
     * If the method is called successively using the same $group argument,
     * the current settings are returned without calling {@see init()}.
     * Thus, changes made by calling {@see set()} will be preserved.
     * @param   string    $section    The section
     * @param   string    $group        The optional group
     * @return  array                 The settings array on success,
     *                                false otherwise
     */
    static function getArray($section, $group=null)
    {
        if (self::$section !== $section
         || self::$group !== $group) {
            if (!self::init($section, $group)) return false;
        }
        return self::$arrSettings;
    }


    /**
     * Returns the settings value stored in the object for the name given.
     *
     * If the settings have not been initialized (see {@see init()}), or
     * if no setting of that name is present in the current set, null
     * is returned.
     * @param   string    $name       The settings name
     * @return  mixed                 The settings value, if present,
     *                                null otherwise
     */
    static function getValue($name)
    {
        if (is_null(self::$arrSettings)) {
DBG::log("SettingDb::getValue($name): ERROR: no settings loaded");
            return null;
        }
//echo("SettingDb::getValue($name): Value is ".(isset(self::$arrSettings[$name]['value']) ? self::$arrSettings[$name]['value'] : 'NOT FOUND')."<br />");
        if (isset(self::$arrSettings[$name]['value'])) {
            return self::$arrSettings[$name]['value'];
        };
//DBG::log("SettingDb::getValue($name): ERROR: unknown setting '$name' (current group ".var_export(self::$group, true).")");
        return null;
    }


    /**
     * Updates a setting
     *
     * If the setting name exists and the new value is not equal to
     * the old one, it is updated, and $changed set to true.
     * Otherwise, nothing happens, and false is returned
     * @see init(), updateAll()
     * @param   string    $name       The settings name
     * @param   string    $value      The settings value
     * @return  boolean               True if the value has been changed,
     *                                false otherwise, null on noop
     */
    static function set($name, $value)
    {
        if (!isset(self::$arrSettings[$name])) {
//DBG::log("SettingDb::set($name, $value): Unknown, changed: ".self::$changed);
            return false;
        }
        if (self::$arrSettings[$name]['value'] == $value) {
//DBG::log("SettingDb::set($name, $value): Identical, changed: ".self::$changed);
            return null;
        }
        self::$changed = true;
        self::$arrSettings[$name]['value'] = $value;
//DBG::log("SettingDb::set($name, $value): Added/updated, changed: ".self::$changed);
        return true;
    }


    /**
     * Stores all settings entries present in the $arrSettings object
     * array variable
     *
     * Returns boolean true if all records were stored successfully,
     * null if nothing changed (noop), false otherwise.
     * Upon success, also resets the $changed class variable to false.
     * The class *MUST* have been initialized before calling this
     * method using {@see init()}, and the new values been {@see set()}.
     * Note that this method does not work for adding new settings.
     * See {@see add()} on how to do this.
     * @return  boolean                   True on success, null on noop,
     *                                    false otherwise
     */
    static function updateAll()
    {
//        global $_CORELANG;

        if (!self::$changed) {
// TODO: These messages are inapropriate when settings are stored by another piece of code, too.
// Find a way around this.
//            Message::information($_CORELANG['TXT_CORE_SETTINGDB_INFORMATION_NO_CHANGE']);
            return null;
        }
        $success = true;
        foreach (self::$arrSettings as $name => $arrSetting) {
            $success &= self::update($name, $arrSetting['value']);
        }
        if ($success) {
            self::$changed = false;
//            return Message::ok($_CORELANG['TXT_CORE_SETTINGDB_STORED_SUCCESSFULLY']);
            return true;
        }
//        return Message::error($_CORELANG['TXT_CORE_SETTINGDB_ERROR_STORING']);
        return false;
    }


    /**
     * Updates the value for the given name in the settings table
     *
     * The class *MUST* have been initialized before calling this
     * method using {@see init()}, and the new value been {@see set()}.
     * Sets $changed to true and returns true if the value has been
     * updated successfully.
     * Note that this method does not work for adding new settings.
     * See {@see add()} on how to do this.
     * Also note that the loaded setting is not updated, only the database!
     * @param   string    $name   The settings name
     * @return  boolean           True on successful update or if
     *                            unchanged, false on failure
     * @static
     * @global  mixed     $objDatabase    Database connection object
     */
    static function update($name)
    {
        global $objDatabase;

// TODO: Add error messages for individual errors
        if (empty(self::$section)) {
DBG::log("SettingDb::update(): ERROR: Empty section!");
            return false;
        }
        // Fail if the name is invalid
        // or the setting does not exist
        if (empty($name)) {
DBG::log("SettingDb::update(): ERROR: Empty name!");
            return false;
        }
        if (!isset(self::$arrSettings[$name])) {
DBG::log("SettingDb::update(): ERROR: Unknown setting name '$name'!");
            return false;
        }
        $objResult = $objDatabase->Execute("
            UPDATE `".DBPREFIX."core_setting`
               SET `value`='".addslashes(self::$arrSettings[$name]['value'])."'
             WHERE `name`='".addslashes($name)."'
               AND `section`='".addslashes(self::$section)."'".
            (self::$group
                ? " AND `group`='".addslashes(self::$group)."'" : ''));
        if (!$objResult) return self::errorHandler();
        self::$changed = true;
        return true;
    }


    /**
     * Add a new record to the settings
     *
     * The class *MUST* have been initialized by calling {@see init()}
     * or {@see getArray()} before this method is called.
     * The present $group stored in the class is used as a default.
     * If the current class $group is empty, it *MUST* be specified in the call.
     * @param   string    $name     The setting name
     * @param   string    $value    The value
     * @param   integer   $ord      The ordinal value for sorting,
     *                              defaults to 0
     * @param   string    $type     The element type for displaying,
     *                              defaults to 'text'
     * @param   string    $values   The values for type 'dropdown',
     *                              defaults to the empty string
     * @param   string    $group      The optional group
     * @return  boolean             True on success, false otherwise
     */
    static function add(
        $name, $value, $ord=false, $type='text', $values='', $group=null)
    {
        global $objDatabase;

        if (!isset(self::$section)) {
// TODO: Error message
DBG::log("SettingDb::add(): ERROR: Empty section!");
            return false;
        }
        // Fail if the name is invalid
        if (empty($name)) {
DBG::log("SettingDb::add(): ERROR: Empty name!");
            return false;
        }
        // This can only be done with a non-empty group!
        // Use the current group, if present, otherwise fail
        if (!$group) {
            if (!self::$group) {
DBG::log("SettingDb::add(): ERROR: Empty group!");
                return false;
            }
            $group = self::$group;
        }
        // Initialize if necessary
        if (is_null(self::$arrSettings) || self::$group != $group)
            self::init(self::$section, $group);

        // Such an entry exists already, fail.
        // Note that getValue() returns null if the entry is not present
        $old_value = self::getValue($name);
        if (isset($old_value)) {
//DBG::log("SettingDb::add(): ERROR: Setting '$name' already exists and is non-empty ($old_value)");
            return false;
        }

        // Not present, insert it
        $query = "
            INSERT INTO `".DBPREFIX."core_setting` (
                `section`, `group`, `name`, `value`,
                `type`, `values`, `ord`
            ) VALUES (
                '".addslashes(self::$section)."',
                '".addslashes($group)."',
                '".addslashes($name)."',
                '".addslashes($value)."',
                '".addslashes($type)."',
                '".addslashes($values)."',
                ".intval($ord)."
            )";
        $objResult = $objDatabase->Execute($query);
        if (!$objResult) {
DBG::log("SettingDb::add(): ERROR: Query failed: $query");
            return false;
        }
        return true;
    }


    /**
     * Delete one or more records from the database table
     *
     * For maintenance/update purposes only.
     * At least one of the parameter values must be non-empty.
     * It will fail if both are empty.  Mind that in this case,
     * no records will be deleted.
     * Does {@see flush()} the currently loaded settings on success.
     * @param   string    $name     The optional setting name.
     *                              Defaults to null
     * @param   string    $group      The optional group.
     *                              Defaults to null
     * @return  boolean             True on success, false otherwise
     */
    static function delete($name=null, $group=null)
    {
        global $objDatabase;

        // Fail if both parameter values are empty
        if (empty($name) && empty($group)) return false;
        $objResult = $objDatabase->Execute("
            DELETE FROM `".DBPREFIX."core_setting`
             WHERE 1".
            ($name ? " AND `name`='".addslashes($name)."'" : '').
            ($group  ? " AND `group`='".addslashes($group)."'"   : ''));
        if (!$objResult) return self::errorHandler();
        self::flush();
        return true;
    }


    /**
     * Display the settings present in the $arrSettings class array
     *
     * Uses the indices as the names for any parameter, the values
     * as themselves, and adds language variables for the settings' name
     * with the given prefix (i.e. 'TXT_', or 'TXT_MYMODULE_') plus the
     * upper case indices.
     * Example:
     *    Settings: array('shop_dummy' => 1)
     *    Prefix:   'TXT_'
     *  Results in placeholders to be set as follows:
     *    Placeholder         Value
     *    SETTINGDB_NAME      The content of $_ARRAYLANG['TXT_SHOP_DUMMY']
     *    SETTINGDB_VALUE     The HTML element for the setting type with
     *                        a name attribute of 'shop_dummy'
     *
     * Placeholders:
     * The settings' name is to SETTINGDB_NAME, and the input element to
     * SETTINGDB_VALUE.
     * Set the default block to parse after each array entry if it
     * differs from the default 'core_setting_db'.
     * Make sure to define all the language variables that are expected
     * to be defined here!
     * In addition, some entries from $_CORELANG are set up. These are both
     * used as placeholder name and language array index:
     *  - TXT_CORE_SETTINGDB_STORE
     *  - TXT_CORE_SETTINGDB_NAME
     *  - TXT_CORE_SETTINGDB_VALUE
     *
     * The template object is given by reference, and if the block
     * 'core_settingdb_row' is not present, is replaced by the default backend
     * template.
     * $uriBase *SHOULD* be the URI for the current module page.
     * If you want your settings to be stored, you *MUST* handle the post
     * request, check for the 'bsubmit' index in the $_POST array, and call
     * {@see SettingDb::store()}.
     * @param   \Cx\Core\Html\Sigma $objTemplateLocal   Template object
     * @param   string              $uriBase      The base URI for the module.
     * @param   string              $section      The optional section header
     *                                            text to add
     * @param   string              $tab_name     The optional tab name to add
     * @param   string              $prefix       The optional prefix for
     *                                            language variables.
     *                                            Defaults to 'TXT_'
     * @return  boolean                           True on success, false otherwise
     * @todo    Add functionality to handle arrays within arrays
     * @todo    Add functionality to handle special form elements
     * @todo    Verify special values like e-mail addresses in methods
     *          that store them, like add(), update(), and updateAll()
     */
    static function show(
        &$objTemplateLocal, $uriBase, $section='', $tab_name='', $prefix='TXT_'
    ) {
        global $_CORELANG;

//$objTemplate->setCurrentBlock();
//echo(nl2br(htmlentities(var_export($objTemplate->getPlaceholderList()))));

        self::verify_template($objTemplateLocal);
// TODO: Test if everything works without this line
//        Html::replaceUriParameter($uriBase, 'act=settings');
        Html::replaceUriParameter($uriBase, 'active_tab='.self::$tab_index);
        // Default headings and elements
        $objTemplateLocal->setGlobalVariable(
            $_CORELANG
          + array(
            'URI_BASE' => $uriBase,
        ));

        if ($objTemplateLocal->blockExists('core_settingdb_row'))
            $objTemplateLocal->setCurrentBlock('core_settingdb_row');
//echo("SettingDb::show(objTemplateLocal, $prefix): got Array: ".var_export(self::$arrSettings, true)."<br />");
        if (!is_array(self::$arrSettings)) {
//die("No Settings array");
            return Message::error($_CORELANG['TXT_CORE_SETTINGDB_ERROR_RETRIEVING']);
        }
        if (empty(self::$arrSettings)) {
//die("No Settings found");
            Message::warning(
                sprintf(
                    $_CORELANG['TXT_CORE_SETTINGDB_WARNING_NONE_FOUND_FOR_TAB_AND_SECTION'],
                    $tab_name, $section));
            return false;
        }
        self::show_section($objTemplateLocal, $section, $prefix);
        // The tabindex must be set in the form name in any case
        $objTemplateLocal->setGlobalVariable(
            'CORE_SETTINGDB_TAB_INDEX', self::$tab_index);
        // Set up tab, if any
        if (!empty($tab_name)) {
            $active_tab = (isset($_REQUEST['active_tab']) ? $_REQUEST['active_tab'] : 1);
            $objTemplateLocal->setGlobalVariable(array(
                'CORE_SETTINGDB_TAB_NAME' => $tab_name,
//                'CORE_SETTINGDB_TAB_INDEX' => self::$tab_index,
                'CORE_SETTINGDB_TAB_CLASS' => (self::$tab_index == $active_tab ? 'active' : ''),
                'CORE_SETTINGDB_TAB_DISPLAY' => (self::$tab_index++ == $active_tab ? 'block' : 'none'),
            ));
            $objTemplateLocal->touchBlock('core_settingdb_tab_row');
            $objTemplateLocal->parse('core_settingdb_tab_row');
            $objTemplateLocal->touchBlock('core_settingdb_tab_div');
            $objTemplateLocal->parse('core_settingdb_tab_div');
        }

// NOK
//die(nl2br(contrexx_raw2xhtml(var_export($objTemplateLocal, true))));

        return true;
    }



    /**
     * Display a section of settings present in the $arrSettings class array
     *
     * See the description of {@see show()} for details.
     * @param   \Cx\Core\Html\Sigma $objTemplateLocal   The Template object,
     *                                                  by reference
     * @param   string              $section      The optional section header
     *                                            text to add
     * @param   string              $prefix       The optional prefix for
     *                                            language variables.
     *                                            Defaults to 'TXT_'
     * @return  boolean                           True on success, false otherwise
     */
    static function show_section(&$objTemplateLocal, $section='', $prefix='TXT_')
    {
        global $_ARRAYLANG, $_CORELANG;

        self::verify_template($objTemplateLocal);
        // This is set to multipart if necessary
        $enctype = '';
        $i = 0;
        if ($objTemplateLocal->blockExists('core_settingdb_row'))
            $objTemplateLocal->setCurrentBlock('core_settingdb_row');
        foreach (self::$arrSettings as $name => $arrSetting) {
            // Determine HTML element for type and apply values and selected
            $element = '';
            $value = $arrSetting['value'];
            $values = self::splitValues($arrSetting['values']);
            $type = $arrSetting['type'];
            // Not implemented yet:
            // Warn if some mandatory value is empty
            if (empty($value) && preg_match('/_mandatory$/', $type)) {
                Message::warning(
                    sprintf($_CORELANG['TXT_CORE_SETTINGDB_WARNING_EMPTY'],
                        $_ARRAYLANG[$prefix.strtoupper($name)],
                        $name));
            }
            // Warn if some language variable is not defined
            if (empty($_ARRAYLANG[$prefix.strtoupper($name)])) {
                Message::warning(
                    sprintf($_CORELANG['TXT_CORE_SETTINGDB_WARNING_MISSING_LANGUAGE'],
                        $prefix.strtoupper($name),
                        $name));
            }

//DBG::log("Value: $value -> align $value_align");
            switch ($type) {
              // Dropdown menu
              case self::TYPE_DROPDOWN:
                $arrValues = self::splitValues($arrSetting['values']);
//DBG::log("Values: ".var_export($arrValues, true));
                $element = Html::getSelect(
                    $name, $arrValues, $value,
                    '', '',
                    'style="width: '.self::DEFAULT_INPUT_WIDTH.'px;'.
                    (   isset ($arrValues[$value])
                     && is_numeric($arrValues[$value])
                        ? 'text-align: right;' : '').
                    '"');
                break;
              case self::TYPE_DROPDOWN_USER_CUSTOM_ATTRIBUTE:
                $element = Html::getSelect(
                    $name,
                    User_Profile_Attribute::getCustomAttributeNameArray(),
                    $arrSetting['value'], '', '',
                    'style="width: '.self::DEFAULT_INPUT_WIDTH.'px;"'
                );
                break;
              case self::TYPE_DROPDOWN_USERGROUP:
                $element = Html::getSelect(
                    $name,
                    UserGroup::getNameArray(),
                    $arrSetting['value'],
                    '', '', 'style="width: '.self::DEFAULT_INPUT_WIDTH.'px;"'
                );
                break;
              case self::TYPE_WYSIWYG:
                // These must be treated differently, as wysiwyg editors
                // claim the full width
                $element = new \Cx\Core\Wysiwyg\Wysiwyg($name, $value);
                $objTemplateLocal->setVariable(array(
                    'CORE_SETTINGDB_ROW' => $_ARRAYLANG[$prefix.strtoupper($name)],
                    'CORE_SETTINGDB_ROWCLASS1' => (++$i % 2 ? '1' : '2'),
                ));
                $objTemplateLocal->parseCurrentBlock();
                $objTemplateLocal->setVariable(array(
                    'CORE_SETTINGDB_ROW' => $element.'<br /><br />',
                    'CORE_SETTINGDB_ROWCLASS1' => (++$i % 2 ? '1' : '2'),
                ));
                $objTemplateLocal->parseCurrentBlock();
                // Skip the part below, all is done already
                continue 2;

              case self::TYPE_FILEUPLOAD:
//echo("SettingDb::show_section(): Setting up upload for $name, $value<br />");
                $element =
                    Html::getInputFileupload(
                        // Set the ID only if the $value is non-empty.
                        // This toggles the file name and delete icon on or off
                        $name, ($value ? $name : false),
                        Filetype::MAXIMUM_UPLOAD_FILE_SIZE,
                        // "values" defines the MIME types allowed
                        $arrSetting['values'],
                        'style="width: '.self::DEFAULT_INPUT_WIDTH.'px;"', true,
                        ($value
                          ? $value
                          : 'media/'.
                            (isset($_REQUEST['cmd'])
                                ? $_REQUEST['cmd'] : 'other'))
                    );
                // File uploads must be multipart encoded
                $enctype = 'enctype="multipart/form-data"';
                break;

              case self::TYPE_BUTTON:
                // The button is only available to trigger some event.
                $event =
                    'onclick=\''.
                      'if (confirm("'.$_ARRAYLANG[$prefix.strtoupper($name).'_CONFIRM'].'")) {'.
                        'document.getElementById("'.$name.'").value=1;'.
                        'document.formSettings_'.self::$tab_index.'.submit();'.
                      '}\'';
//DBG::log("SettingDb::show_section(): Event: $event");
                $element =
                    Html::getInputButton(
                        // The button itself gets a dummy name attribute value
                        '__'.$name,
                        $_ARRAYLANG[strtoupper($prefix.$name).'_LABEL'],
                        'button', false,
                        $event
                    ).
                    // The posted value is set to 1 when confirmed,
                    // before the form is posted
                    Html::getHidden($name, 0, '');
//DBG::log("SettingDb::show_section(): Element: $element");
                break;

              case self::TYPE_TEXTAREA:
                $element =
                    Html::getTextarea($name, $value, 80, 8, '');
//                        'style="width: '.self::DEFAULT_INPUT_WIDTH.'px;'.$value_align.'"');
                break;

              case self::TYPE_CHECKBOX:
                $arrValues = self::splitValues($arrSetting['values']);
                $value_true = current($arrValues);
                $element =
                    Html::getCheckbox($name, $value_true, false,
                        in_array($value, $arrValues));
                break;
              case self::TYPE_CHECKBOXGROUP:
                $checked = self::splitValues($value);
                $element =
                    Html::getCheckboxGroup($name, $values, $values, $checked,
                        '', '', '<br />', '', '');
                break;
// 20120508 UNTESTED!
              case self::TYPE_RADIO:
                $checked = self::splitValues($value);
                $element =
                    Html::getRadioGroup($name, $values, $values);
                break;

// More...
//              case self::TYPE_:
//                break;

              // Default to text input fields
              case self::TYPE_TEXT:
              case self::TYPE_EMAIL:
              default:
                $element =
                    Html::getInputText(
                        $name, $value, false,
                        'style="width: '.self::DEFAULT_INPUT_WIDTH.'px;'.
                        (is_numeric($value) ? 'text-align: right;' : '').
                        '"');
            }

            $objTemplateLocal->setVariable(array(
                'CORE_SETTINGDB_NAME' => $_ARRAYLANG[$prefix.strtoupper($name)],
                'CORE_SETTINGDB_VALUE' => $element,
                'CORE_SETTINGDB_ROWCLASS2' => (++$i % 2 ? '1' : '2'),
            ));
            $objTemplateLocal->parseCurrentBlock();
//echo("SettingDb::show(objTemplateLocal, $prefix): shown $name => $value<br />");
        }

        // Set form encoding to multipart if necessary
        if (!empty($enctype))
            $objTemplateLocal->setVariable('CORE_SETTINGDB_ENCTYPE', $enctype);

        if (   !empty($section)
            && $objTemplateLocal->blockExists('core_settingdb_section')) {
//echo("SettingDb::show(objTemplateLocal, $header, $prefix): creating section $header<br />");
            $objTemplateLocal->setVariable(array(
                'CORE_SETTINGDB_SECTION' => $section,
            ));
            $objTemplateLocal->parse('core_settingdb_section');
        }
        return true;
    }


    /**
     * Adds an external settings view to the current template
     *
     * The content must contain the full view, including the surrounding form
     * tags and submit button.
     * Note that these are always appended on the right end of the tab list.
     * @param   \Cx\Core\Html\Sigma $objTemplateLocal   Template object
     * @param   string              $tab_name           The tab name to add
     * @param   string              $content            The external content
     * @return  boolean                                 True on success
     */
    static function show_external(
        &$objTemplateLocal, $tab_name, $content
    ) {
        if (   empty($objTemplateLocal)
            || !$objTemplateLocal->blockExists('core_settingdb_row')) {
            $objTemplateLocal = new \Cx\Core\Html\Sigma(ASCMS_ADMIN_TEMPLATE_PATH);
            if (!$objTemplateLocal->loadTemplateFile('settingDb.html'))
                die("Failed to load template settingDb.html");
        }

        $active_tab = (isset($_REQUEST['active_tab']) ? $_REQUEST['active_tab'] : 1);
        // The tabindex must be set in the form name in any case
        $objTemplateLocal->setGlobalVariable(array(
            'CORE_SETTINGDB_TAB_INDEX' => self::$tab_index,
            'CORE_SETTINGDB_EXTERNAL' => $content,
        ));
        // Set up the tab, if any
        if (!empty($tab_name)) {
            $objTemplateLocal->setGlobalVariable(array(
                'CORE_SETTINGDB_TAB_NAME' => $tab_name,
//                'CORE_SETTINGDB_TAB_INDEX' => self::$tab_index,
                'CORE_SETTINGDB_TAB_CLASS' => (self::$tab_index == $active_tab ? 'active' : ''),
                'CORE_SETTINGDB_TAB_DISPLAY' => (self::$tab_index++ == $active_tab ? 'block' : 'none'),
            ));
            $objTemplateLocal->touchBlock('core_settingdb_tab_row');
            $objTemplateLocal->parse('core_settingdb_tab_row');
            $objTemplateLocal->touchBlock('core_settingdb_tab_div_external');
            $objTemplateLocal->parse('core_settingdb_tab_div_external');
        }
        return true;
    }


    /**
     * Ensures that a valid template is available
     *
     * Die()s if the template given is invalid, and settingDb.html cannot be
     * loaded to replace it.
     * @param   \Cx\Core\Html\Sigma $objTemplateLocal   The template,
     *                                                  by reference
     */
    static function verify_template(&$objTemplateLocal)
    {
        // "instanceof" considers subclasses of Sigma to be a Sigma, too!
        if (!($objTemplateLocal instanceof \Cx\Core\Html\Sigma)) {
            $objTemplateLocal = new \Cx\Core\Html\Sigma(ASCMS_ADMIN_TEMPLATE_PATH);
        }
        if (!$objTemplateLocal->blockExists('core_settingdb_row')) {
            $objTemplateLocal->setRoot(ASCMS_ADMIN_TEMPLATE_PATH);
//            $objTemplateLocal->setCacheRoot('.');
            if (!$objTemplateLocal->loadTemplateFile('settingDb.html'))
                die("Failed to load template settingDb.html");
//die(nl2br(contrexx_raw2xhtml(var_export($objTemplateLocal, true))));
        }
    }


    /**
     * Update and store all settings found in the $_POST array
     *
     * Note that you *MUST* call {@see init()} beforehand, or your settings
     * will be unknown and thus not be stored.
     * Sets up an error message on failure.
     * @return  boolean                 True on success, null on noop,
     *                                  or false on failure
     */
    static function storeFromPost()
    {
        global $_CORELANG;

//echo("SettingDb::storeFromPost(): POST:<br />".nl2br(htmlentities(var_export($_POST, true)))."<hr />");
//echo("SettingDb::storeFromPost(): FILES:<br />".nl2br(htmlentities(var_export($_FILES, true)))."<hr />");
        // There may be several tabs for different groups being edited, so
        // load the full set of settings for the module.
        // Note that this is why setting names should be unique.
// TODO: You *MUST* call this yourself *before* in order to
// properly initialize the section!
//        self::init();
        unset($_POST['bsubmit']);
        $result = true;
        // Compare POST with current settings and only store what was changed.
        foreach (array_keys(self::$arrSettings) as $name) {
            $value = (isset ($_POST[$name])
                ? contrexx_input2raw($_POST[$name])
                : null);
//            if (preg_match('/^'.preg_quote(CSRF::key(), '/').'$/', $name))
//                continue;
            switch (self::$arrSettings[$name]['type']) {
              case self::TYPE_FILEUPLOAD:
                // An empty folder path has been posted, indicating that the
                // current file should be removed
                if (empty($value)) {
//echo("Empty value, deleting file...<br />");
                    if (self::$arrSettings[$name]['value']) {
                        if (File::delete_file(self::$arrSettings[$name]['value'])) {
//echo("File deleted<br />");
                            $value = '';
                        } else {
//echo("Failed to delete file<br />");
                            Message::error(File::getErrorString());
                            $result = false;
                        }
                    }
                } else {
                    // No file uploaded.  Skip.
                    if (empty($_FILES[$name]['name'])) continue;
                    // $value is the target folder path
                    $target_path = $value.'/'.$_FILES[$name]['name'];
// TODO: Test if this works in all browsers:
                    // The path input field name is the same as the
                    // file upload input field name!
                    $result_upload = File::upload_file_http(
                        $name, $target_path,
                        Filetype::MAXIMUM_UPLOAD_FILE_SIZE,
                        // The allowed file types
                        self::$arrSettings[$name]['values']
                    );
                    // If no file has been uploaded at all, ignore the no-change
// TODO: Noop is not implemented in File::upload_file_http()
//                    if ($result_upload === '') continue;
                    if ($result_upload === true) {
                        $value = $target_path;
                    } else {
//echo("SettingDb::storeFromPost(): Error uploading file for setting $name to $target_path<br />");
// TODO: Add error message
                        Message::error(File::getErrorString());
                        $result = false;
                    }
                }
                break;
              case self::TYPE_CHECKBOX:
                  break;
              case self::TYPE_CHECKBOXGROUP:
                $value = (is_array($value)
                    ? join(',', array_keys($value))
                    : $value);
// 20120508
              case self::TYPE_RADIO:
                  break;
              default:
                // Regular value of any other type
                break;
            }
            SettingDb::set($name, $value);
        }
//echo("SettingDb::storeFromPost(): So far, the result is ".($result ? 'okay' : 'no good')."<br />");
        $result_update = self::updateAll();
        if ($result_update === false) {
            Message::error($_CORELANG['TXT_CORE_SETTINGDB_ERROR_STORING']);
        } elseif ($result_update === true) {
            Message::ok($_CORELANG['TXT_CORE_SETTINGDB_STORED_SUCCESSFULLY']);
        }
        // If nothing bad happened above, return the result of updateAll(),
        // which may be true, false, or the empty string
        if ($result === true) {
            return $result_update;
        }
        // There has been an error anyway
        return false;
    }


    /**
     * Deletes all entries for the current section
     *
     * This is for testing purposes only.  Use with care!
     * The static $section determines the module affected.
     * @return    boolean               True on success, false otherwise
     */
    static function deleteModule()
    {
        global $objDatabase;

        if (empty(self::$section)) {
// TODO: Error message
            return false;
        }
        $objResult = $objDatabase->Execute("
            DELETE FROM `".DBPREFIX."core_setting`
             WHERE `section`='".self::$section."'");
        if (!$objResult) return self::errorHandler();
        return true;
    }


    /**
     * Splits the string value at commas and returns an array of strings
     *
     * Commas escaped by a backslash (\) are ignored and replaced by a
     * single comma.
     * The values themselves may be composed of pairs of key and value,
     * separated by a colon.  Colons escaped by a backslash (\) are ignored
     * and replaced by a single colon.
     * Leading and trailing whitespace is removed from both keys and values.
     * Note that keys *MUST NOT* contain commas or colons!
     * @param   string    $strValues    The string to be split
     * @return  array                   The array of strings
     */
    static function splitValues($strValues)
    {
/*
Example:
postfinance:Postfinance Card,postfinanceecom:Postfinance E-Commerce,mastercard:Mastercard,visa:Visa,americanexpress:American Express,paypal:Paypal,invoice:Invoice,voucher:Voucher
*/
        $arrValues = array();
        $match = array();
        foreach (
            preg_split(
                '/\s*(?<!\\\\),\s*/', $strValues,
                null, PREG_SPLIT_NO_EMPTY) as $value
        ) {
            $key = null;
            if (preg_match('/^(.+?)\s*(?<!\\\\):\s*(.+$)/', $value, $match)) {
                $key = $match[1];
                $value = $match[2];
//DBG::log("Split $key and $value");
            }
            str_replace(array('\\,', '\\:'), array(',', ':'), $value);
            if (isset($key)) {
                $arrValues[$key] = $value;
            } else {
                $arrValues[] = $value;
            }
//DBG::log("Split $key and $value");
        }
//DBG::log("Array: ".var_export($arrValues, true));
        return $arrValues;
    }


    /**
     * Joins the strings in the array with commas into a single values string
     *
     * Commas within the strings are escaped by a backslash (\).
     * The array keys are prepended to the values, separated by a colon.
     * Colons within the strings are escaped by a backslash (\).
     * Note that keys *MUST NOT* contain either commas or colons!
     * @param   array     $arrValues    The array of strings
     * @return  string                  The concatenated values string
     * @todo    Untested!  May or may not work as described.
     */
    static function joinValues($arrValues)
    {
        $strValues = '';
        foreach ($arrValues as $key => $value) {
            $value = str_replace(
                array(',', ':'), array('\\,', '\\:'), $value);
            $strValues .=
                ($strValues ? ',' : '').
                "$key:$value";
        }
        return $strValues;
    }


    /**
     * Should be called whenever there's a problem with the settings table
     *
     * Tries to fix or recreate the settings table.
     * @return  boolean             False, always.
     * @static
     */
    static function errorHandler()
    {
        $table_name = DBPREFIX.'core_setting';
        $table_structure = array(
            'section' => array('type' => 'VARCHAR(32)', 'default' => '', 'primary' => true),
            'name' => array('type' => 'VARCHAR(255)', 'default' => '', 'primary' => true),
            'group' => array('type' => 'VARCHAR(32)', 'default' => '', 'primary' => true),
            'type' => array('type' => 'VARCHAR(32)', 'default' => 'text'),
            'value' => array('type' => 'TEXT', 'default' => ''),
            'values' => array('type' => 'TEXT', 'notnull' => true, 'default' => null),
            'ord' => array('type' => 'INT(10)', 'unsigned' => true, 'default' => '0'),
        );
// TODO: The index array structure is wrong here!
        $table_index =  array();
        Cx\Lib\UpdateUtil::table($table_name, $table_structure, $table_index);
//echo("SettingDb::errorHandler(): Created table ".DBPREFIX."core_setting<br />");

        // Use SettingDb::add(); in your module code to add settings; example:
//        SettingDb::init('core', 'country');
//        SettingDb::add('numof_countries_per_page_backend', 30, 1, SettingDb::TYPE_TEXT);

        // More to come...

        // Always!
        return false;
    }


    /**
     * Returns the settings from the old settings table for the given module ID,
     * if available
     *
     * If the module ID is missing or invalid, or if the settings cannot be
     * read for some other reason, returns null.
     * Don't drop the table after migrating your settings, other modules
     * might still need it!  Instead, try this method only after you failed
     * to get your settings from SettingDb.
     * @param   integer   $module_id      The module ID
     * @return  array                     The settings array on success,
     *                                    null otherwise
     * @static
     */
    static function __getOldSettings($module_id)
    {
        global $objDatabase;

        $module_id = intval($module_id);
        if ($module_id <= 0) return null;
        $objResult = $objDatabase->Execute('
            SELECT `setname`, `setvalue`
              FROM `'.DBPREFIX.'settings`
             WHERE `setmodule`='.$module_id);
        if (!$objResult) {
            return null;
        }
        $arrConfig = array();
        while (!$objResult->EOF) {
            $arrConfig[$objResult->fields['setname']] =
                $objResult->fields['setvalue'];
            $objResult->MoveNext();
        }
        return $arrConfig;
    }

}
