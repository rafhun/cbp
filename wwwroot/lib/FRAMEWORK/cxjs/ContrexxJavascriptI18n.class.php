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
 * ContrexxJavascriptI18n
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  lib_cxjs
 */

/**
 * ContrexxJavascriptI18nException
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  lib_cxjs
 */
class ContrexxJavascriptI18nException extends ContrexxJavascriptException {}

/**
 * @ignore
 */
require_once ASCMS_FRAMEWORK_PATH.'/cxjs/ContrexxJavascriptI18nProvider.interface.php';

/**
 * This handles i18n for Javascript.
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  lib_cxjs
 */
class ContrexxJavascriptI18n {
   /**
    * language code used to generate i18n-files' names
    * @var string
    */
    protected $languageCode = 'en';

    public function __construct($languageCode) {
        $this->languageCode = $languageCode;
    }

    /**
     * sets all i18n variables on target
     * @param ContrexxJavascript $target
     * @throws ContrexxJavascriptI18nException
     */
    public function variablesTo($target) {
        $vars = array();
        $providers = scandir(ASCMS_FRAMEWORK_PATH.'/cxjs/i18n');
        foreach($providers as $provider) {
            if(($provider[0] == '.') || !preg_match('/\.php/', $provider)) //do not open ., .., and linux hidden directories (.*)
                continue;
            //name as used for the scope ('provider')
            $providerName = substr($provider,0,strpos($provider,'.'));
            //name of the class ('providerProvider')
            $className = ucfirst($providerName.'I18nProvider');
            try {
                require_once 'i18n/'.$provider;
                $providerInst = new $className();
                //set the variables accordingly on cxjs object
                $target->setVariable($providerInst->getVariables($this->languageCode), $providerName);
            }
            catch(Exception $e)
            {
                throw new ContrexxJavascriptI18nException("error parsing i18n module '$provider': " . $e->getMessage());
            }
        }
        return $vars;
    }
}
