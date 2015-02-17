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
 * knowledgeLib
 * 
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author Stefan Heinemann <sh@comvation.com>
 * @package     contrexx
 * @subpackage  module_knowledge
 */

/**
 * @ignore
 */
require_once ASCMS_LIBRARY_PATH.'/activecalendar/activecalendar.php';
if (!class_exists("DatabaseError")) {
    require_once ASCMS_MODULE_PATH . '/knowledge/lib/databaseError.class.php';
}

/**
 * Some basic operations for the knowledge module.
 * 
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author Stefan Heinemann <sh@comvation.com>
 * @package contrexx
 * @subpackage  module_knowledge
 */
class KnowledgeLibrary {
    /**
     * The settings object
     *
     * @var object
     */
	protected $settings;
	
	/**
	 * The articles object
	 *
	 * @var object
	 */
	protected $articles;
	
	/**
	 * The categories object
	 *
	 * @var object
	 */
	protected $categories;
	
	/**
	 * The tags object
	 *
	 * @var object
	 */
	protected $tags;

	/**
	 * Initialise the needed objects
     */
	public function __construct() {
		$this->categories = new KnowledgeCategory();
		$this->articles = new KnowledgeArticles();
		$this->settings = new KnowledgeSettings();
		$this->tags = new KnowledgeTags();
		
		$this->_arrLanguages 	= $this->createLanguageArray();
	}
	
	/**
	 * Update the global setting
	 *
	 * @param int $value
	 * @throws DatabaseError
	 * @global $objDatabase
	 */
	protected function updateGlobalSetting($value)
	{
	    global $objDatabase;

	    // seems a bit dirty i know
	    
	    $query = " UPDATE ".DBPREFIX."settings
	               SET setvalue = '".$value."'
	               WHERE setname = 'useKnowledgePlaceholders'";
	    $objDatabase->Execute($query);
	    if ($objDatabase->Execute($query) === false) {
	        throw new DatabaseError("error setting the global value");
	    }
	    
	    
	    $objSettings = new settingsManager();
	    $objSettings->writeSettingsFile();
	}
	
	/**
	 * Return the global setting
	 *
	 * @return string
	 * @throws DatabaseError
	 * @global $objDatabase
	 * @return mixed
	 */
	protected function getGlobalSetting()
	{
	    global $objDatabase;
	    
	    $query = " SELECT setvalue FROM ".DBPREFIX."settings
	               WHERE setname = 'useKnowledgePlaceholders'";
	    $result = $objDatabase->Execute($query);
	    
	    if ($result === false) {
	       throw new DatabaseError('error getting the global value');
	    } else {
	        if ($result->RecordCount()) {
	            return $result->fields['setvalue'];
	        }
	    }
	}
	
	/**
	 * Creates an array containing all frontend-languages.
	 *
	 * Contents:
	 * $arrValue[$langId]['short']		=>	For Example: en, de, fr, ...
	 * $arrValue[$langId]['long']		=>	For Example: 'English', 'Deutsch', 'French', ...
	 *
	 * @global 	object		$objDatabase
	 * @return	array		$arrReturn
	 */
	function createLanguageArray() {
		global $objDatabase;

		$arrReturn = array();

		$objResult = $objDatabase->Execute('SELECT		id,
														lang,
														name
											FROM		'.DBPREFIX.'languages
											WHERE		frontend=1
											ORDER BY	id
										');
		while (!$objResult->EOF) {
			$arrReturn[$objResult->fields['id']] = array(	'short'	=>	stripslashes($objResult->fields['lang']),
															'long'	=>	htmlentities(stripslashes($objResult->fields['name']),ENT_QUOTES, CONTREXX_CHARSET)
														);
			$objResult->MoveNext();
		}

		return $arrReturn;
	}
}