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
 * Import Class
 * Class which handles the main import operations
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  lib_importexport
 */

/**
 * @ignore
 */
require_once ASCMS_LIBRARY_PATH."/importexport/lib/importexport.class.php";

/**
 * Import Class
 * Class which handles the main import operations
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  lib_importexport
 */
class Import extends ImportExport
{
	var $fieldNames;
	var $importedData;
	var $pairs = array();

	/**
	 * getFinalData
	 *
	 * This function returns the associated fields and values.
	 * @param array $fields Name of the fields
	 */
	function getFinalData($fields)
	{
		$this->setType($_POST['importtype']);
		$this->setFieldPairs($_POST['pairs_left_keys'], $_POST['pairs_right_keys']);
		$this->parseFile($_POST['importfile']);

		$retval = array();
		foreach ($this->importedData as $datarow) {
			foreach ($this->pairs as $key => $value) {
				$retfields[$key] = $datarow[$value];
				$retfields[$fields[$key]] = $datarow[$value];
			}

			$retval[] = $retfields;
		}

		return $retval;

	}

	/**
	 * Sets the field Pairs
	 *
	 * @param array $left_fields
	 * @param array $right_fields
	 */
	function setFieldPairs($left_fields, $right_fields)
	{
		$lFields = explode(";", $left_fields);
		$rFields = explode(";", $right_fields);

		foreach ($rFields as $key => $rField) {
			$this->pairs[$rField] = $lFields[$key];
		}
	}

	/**
	 * Gets the fieldnames of the importing file
	 *
	 * @return array $fields
	 */
	function getDataFields()
	{
		return $this->fieldNames;
	}

	/**
	 * Parses the file
	 *
	 * @param array $file
	 * @param bool $delete Delete file after parsing or not
	 * @return string $file
	 */
	function parseFile($file, $onlyHeader = false) {
		if ($onlyHeader) {
			$path = ASCMS_TEMP_PATH . "/";

			$newpath = $path . basename($file) . "." . time() . ".import";
			move_uploaded_file($file, $newpath);
			$file = $newpath;
			$data = $this->dataClass->parse($file, true, true, 1);
		} else {
          $data = $this->dataClass->parse($file, true, true);
		}
		if (!empty($data)) {
			if (isset($data['fieldnames'])) {
				// Set the fieldnames
				$this->fieldNames = $data['fieldnames'];
			} else {
				// Take the first data line as fieldnames
				foreach ($data['data'][0] as $value) {
					$this->fieldNames[] = $value;
				}
			}

			if (isset($data['data'])) {
				$this->importedData = $data['data'];
			}
		}

		if (!$onlyHeader) {
			unlink($file);
		}

		return $file;
	}

	/**
	 * Sets the template for the file selection
	 *
	 * Sets the template and all neede variables
	 * for the file selection.
	 * @param object $tpl The template object (by reference)
	 */
	function initFileSelectTemplate(&$tpl)
	{
		global $_ARRAYLANG;

		$template = file_get_contents(ASCMS_LIBRARY_PATH . "/importexport/template/import.fileselect.html");
		$tpl->setTemplate($template,true,true);

		$tpl->setVariable(array(
			"TXT_IMPORT"		=> $_ARRAYLANG['TXT_IMPORT'],
			"IMPORT_TYPELIST"	=> $this->getTypeSelectList(),
			"TXT_FILETYPE"		=> $_ARRAYLANG['TXT_FILETYPE'],
			"TXT_CHOOSE_FILE"	=> $_ARRAYLANG['TXT_CHOOSE_FILE'],
			"TXT_SEPARATOR"		=> $_ARRAYLANG['TXT_SEPARATOR'],
			"TXT_ENCLOSURE"		=> $_ARRAYLANG['TXT_ENCLOSURE'],
			"TXT_DESC_DELIMITER"	=> $_ARRAYLANG['TXT_DESC_DELIMITER'],
			"TXT_DESC_ENCLOSURE"	=> $_ARRAYLANG['TXT_DESC_ENCLOSURE'],
			"TXT_HELP"           => $_ARRAYLANG['TXT_HELP']
		));
	}

	/**
	 * Sets the template for the field selection
	 *
	 * Parses the given file and sets the template and values
	 * for the field selection.
	 * @param object $tpl The template object (by reference)
	 */
	function initFieldSelectTemplate(&$tpl, $given_fields)
	{
		global $_ARRAYLANG;

		$template = file_get_contents(ASCMS_LIBRARY_PATH . "/importexport/template/import.fieldselect.html");
		$tpl->setTemplate($template, true, true);

		// Pass the options
		foreach ($_POST as $postkey => $postvar) {
			if (preg_match("%^import\_options\_%", $postkey)) {
				$optionvars[strtoupper($postkey)] = htmlentities(contrexx_stripslashes($postvar), ENT_QUOTES, CONTREXX_CHARSET);
			}
		}
		$tpl->setVariable($optionvars);

		$this->setType($_POST['importtype']);
		$file = $this->parseFile($_FILES['importfile']['tmp_name'], true);

		$tpl->setVariable(array(
			"TXT_REMOVE_PAIR"	=> $_ARRAYLANG['TXT_REMOVE_PAIR'],
			"TXT_ADD_PAIR"		=> $_ARRAYLANG['TXT_ADD_PAIR'],
			"TXT_IMPORT"		=> $_ARRAYLANG['TXT_IMPORT'],
			"TXT_FIELDSELECT_SELECT_DESC"	=> $_ARRAYLANG['TXT_FIELDSELECT_SELECT_DESC'],
			"TXT_FIELDSELECT_SHOW_DESC"		=> $_ARRAYLANG['TXT_FIELDSELECT_SHOW_DESC'],
			"IMPORT_FILE"	=> $file,
			"IMPORT_TYPE"	=> $_POST['importtype'],
			"TXT_CANCEL"         => $_ARRAYLANG['TXT_CANCEL']
		));

		/*
		 * Set the given fields
		 */
		foreach ($given_fields as $key => $field) {
			if ($field['active']) {
				$tpl->setVariable(array(
					"IMPORT_FIELD_VALUE" => $key,
					"IMPORT_FIELD_NAME"	=> $field
				));

				$tpl->parse("given_field_row");
			}
		}

		// Set the file fields
		$fieldnames = $this->getDataFields();
		foreach ($fieldnames as $key => $field) {
			$tpl->setVariable(array(
				"IMPORT_FIELD_VALUE" => $key,
				"IMPORT_FIELD_NAME"	=> $field,
			));

			$tpl->parse("file_field_row");
		}
	}

	/**
	 * Cancels the import operation
	 *
	 */
	function cancel()
	{
            if (!isset($_POST['importfile'])) {
                return false;
            }
        $file = $_POST['importfile'];

        $path = ASCMS_TEMP_PATH . "/";
        if (file_exists($path . $file)) {
            unlink($path);
        }
	}
}
