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

/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Cx\Core_Modules\License;

/**
 * Description of License
 *
 * @author ritt0r
 */
class License {
    const LICENSE_OK = 'OK';
    const LICENSE_NOK = 'NOK';
    const LICENSE_DEMO = 'DEMO';
    const LICENSE_ERROR = 'ERROR';
    const INFINITE_VALIDITY = 0;
    private static $staticModules = array(
        'license',
        'logout',
        'error',
        'captcha',
        'upgrade',
        'noaccess',
    );
    private $state;
    private $frontendLocked = false;
    private $editionName;
    private $availableComponents;
    private $legalComponents;
    private $legalFrontendComponents;
    private $validTo;
    private $upgradeUrl;
    private $createdAt;
    private $registeredDomains = array();
    private $instId;
    private $licenseKey;
    private $messages;
    private $version;
    private $partner;
    private $customer;
    private $grayzoneTime;
    private $grayzoneMessages;
    private $frontendLockTime;
    private $requestInterval;
    private $firstFailedUpdate;
    private $lastSuccessfulUpdate;
    private $isUpgradable = false;
    private $dashboardMessages;
    
    public function __construct(
            $state = self::LICENSE_DEMO,
            $editionName = '',
            $availableComponents = array(),
            $legalComponents = array(),
            $validTo = '',
            $createdAt = '',
            $registeredDomains = array(),
            $instId = '',
            $licenseKey = '',
            $messages = array(),
            $version = '',
            $partner = null,
            $customer = null,
            $grayzoneTime = 14,
            $grayzoneMessages = array(),
            $frontendLockTime = 10,
            $requestInterval = 1,
            $firstFailedUpdate = 0,
            $lastSuccessfulUpdate = 0,
            $upgradeUrl = '',
            $isUpgradable,
            $dashboardMessages
    ) {
        $this->state = $state;
        $this->editionName = $editionName;
        $this->availableComponents = $availableComponents;
        $this->legalComponents = $this->loadLegalComponentsHack();
        $this->validTo = $validTo;
        $this->createdAt = $createdAt;
        $this->registeredDomains = is_array($registeredDomains) ? $registeredDomains : array();
        $this->instId = $instId;
        $this->licenseKey = $licenseKey;
        $this->messages = is_array($messages) ? $messages : array();
        $this->version = $version;

        if ($partner instanceof Person) {
            $this->partner = $partner;
        } else { 
            $this->partner = new Person();
        }

        if ($customer instanceof Person) {
            $this->customer = $customer;
        } else {
            $this->customer = new Person();
        }

        $this->grayzoneTime = $grayzoneTime;
        $this->grayzoneMessages = is_array($grayzoneMessages) ? $grayzoneMessages : array();
        $this->frontendLockTime = $frontendLockTime;
        $this->requestInterval = $requestInterval;
        $this->upgradeUrl = $upgradeUrl;
        $this->isUpgradable = $isUpgradable;
        $this->dashboardMessages = $dashboardMessages;
        $this->setFirstFailedUpdateTime($firstFailedUpdate);
        $this->setLastSuccessfulUpdateTime($lastSuccessfulUpdate);
    }
    
    /**
     * This is a dirty fix to allow 3rd party components with disabled licensing
     */
    protected function loadLegalComponentsHack() {
        $objDatabase = \Env::get('cx')->getDb()->getAdoDb();
        $result = $objDatabase->Execute('
            SELECT
                `name`
            FROM
                `' . DBPREFIX . 'modules`
        ');
        $legalComponents = array();
        while (!$result->EOF) {
            $legalComponents[] = $result->fields['name'];
            $result->MoveNext();
        }
        return $legalComponents;
    }
    
    public function getState() {
        return $this->state;
    }
    
    public function setState($state) {
        $this->state = $state;
        if ($this->state == self::LICENSE_ERROR) {
            $this->setFirstFailedUpdateTime(time());
        }
    }
    
    public function isFrontendLocked() {
        return $this->frontendLocked;
    }
    
    public function getEditionName() {
        return $this->editionName;
    }
    
    public function getAvailableComponents() {
        return $this->availableComponents;
    }
    
    public function getLegalComponentsList() {
        return $this->legalComponents;
    }
    
    public function isInLegalComponents($componentName) {
        return in_array($componentName, $this->legalComponents);
    }
    
    public function getLegalFrontendComponentsList() {
        if (!$this->legalFrontendComponents) {
            return $this->getLegalComponentsList();
        }
        return $this->legalFrontendComponents;
    }
    
    public function isInLegalFrontendComponents($componentName) {
        return in_array($componentName, $this->getLegalFrontendComponentsList());
    }
    
    public function getValidToDate() {
        return $this->validTo;
    }
    
    public function setValidToDate($timestamp) {
        $this->validTo = $timestamp;
    }
    
    public function getUpgradeUrl() {
        return $this->upgradeUrl;
    }
    
    public function getCreatedAtDate() {
        return $this->createdAt;
    }
    
    public function getRegisteredDomains() {
        return $this->registeredDomains;
    }
    
    public function getInstallationId() {
        return $this->instId;
    }
    
    public function getLicenseKey() {
        return $this->licenseKey;
    }
    
    public function setLicenseKey($key) {
        $this->licenseKey = $key;
    }
    
    public function getMessages() {
        return $this->messages;
    }
    
    public function getDashboardMessages() {
        return $this->dashboardMessages;
    }

    public function setMessages($messages) {
        $this->messages = $messages;
    }    

    public function setGrayZoneMessages($grayzoneMessages) {
        $this->grayzoneMessages = $grayzoneMessages;
    }    

    /**
     *
     * @return Message
     */
    public function getMessage($dashboard, $langCode, $_CORELANG) {
        // return gray zone message in case of an error
        if ($this->getState() == self::LICENSE_ERROR) {
            return $this->getGrayzoneMessage($langCode, $_CORELANG);
        }

        $messages = $this->messages;
        if ($dashboard) {
            $messages = $this->dashboardMessages;
        }
        // return message in prefered localized version
        return $this->getMessageInPreferedLanguage($messages, $langCode);
    }

    /**
     * Select the prefered locale version of a message
     * @param   array   Array containing all localized versions of a message with its language code as index
     * @param   string  Preferend Language code
     * @return  mixed   Either the prefered message as string or NULL if $messages is empty
     */
    private function getMessageInPreferedLanguage($messages, $langCode)
    {
        // check if a message is available
        if (empty($messages)) {
            return new Message();
        }

        // return message in selected (=> current interface) language
        if (isset($messages[$langCode])) {
            return $messages[$langCode];
        }

        // return message in default language
        if (isset($messages[\FWLanguage::getLanguageCodeById(\FWLanguage::getDefaultLangId())])) {
            return $messages[\FWLanguage::getLanguageCodeById(\FWLanguage::getDefaultLangId())];
        }

        // return message in what ever language it is available
        reset($messages);
        return current($messages);
    }
    
    public function isUpgradable() {
        return $this->isUpgradable;
    }
    
    /**
     *
     * @return Version
     */
    public function getVersion() {
        return $this->version;
    }
    
    public function getPartner() {
        return $this->partner;
    }
    
    public function getCustomer() {
        return $this->customer;
    }
    
    public function getGrayzoneTime() {
        return $this->grayzoneTime;
    }
    
    public function getGrayzoneMessages() {
        return $this->grayzoneMessages;
    }
    
    /**
     *
     * @return Message
     */
    public function getGrayzoneMessage($langCode, $_CORELANG) {
        if (empty($this->grayzoneMessages)) {
            $this->setGrayzoneMessages(array($langCode => new Message($langCode, $_CORELANG['TXT_LICENSE_DEFAULT_GRAYZONE_MESSAGE'])));
        }

        // return message in prefered localized version
        return $this->getMessageInPreferedLanguage($this->grayzoneMessages, $langCode);
    }
    
    public function getFrontendLockTime() {
        return $this->frontendLockTime;
    }
    
    public function getRequestInterval() {
        return $this->requestInterval;
    }
    
    public function getFirstFailedUpdateTime() {
        return $this->firstFailedUpdate;
    }
    
    public function setFirstFailedUpdateTime($time) {
        if ($this->firstFailedUpdate == 0) {
            $this->firstFailedUpdate = $time;
        }
    }
    
    public function getLastSuccessfulUpdateTime() {
        return $this->lastSuccessfulUpdate;
    }
    
    public function setLastSuccessfulUpdateTime($time) {
        if ($time > $this->firstFailedUpdate) {
            $this->firstFailedUpdate = 0;
            $this->lastSuccessfulUpdate = $time;
        }
    }
    
    public function check() {
        // check checksum
        if (!$this->checkSum($this->instId, false) || !$this->checkSum($this->licenseKey)) {
            $this->state = self::LICENSE_ERROR;
        }
        $validTo = 0;
        switch ($this->state) {
            case self::LICENSE_DEMO:
            case self::LICENSE_OK:
            case self::LICENSE_NOK:
                $validTo = $this->validTo;
                break;
            case self::LICENSE_ERROR:
                $this->setFirstFailedUpdateTime(mktime(0,0,0,date('n'),date('j'),date('Y')));
                $validTo = $this->getFirstFailedUpdateTime() + 60*60*24*$this->grayzoneTime;
                break;
        }

        // in case if one of the following is TRUE, the system will be in lock-down-mode
        // - no installation-ID set
        // - no license-Key available
        // - license has expired
        // - license is invalid
        if ($validTo + 60*60*24 < time() || $validTo === self::INFINITE_VALIDITY || $this->state == self::LICENSE_NOK) {
            $this->state = self::LICENSE_NOK;
            $this->legalFrontendComponents = $this->legalComponents;
            $this->legalComponents = self::$staticModules;
            if ($this->frontendLockTime !== 'false' && $validTo + 60*60*24*($this->frontendLockTime + 1) < time()) {
                $this->frontendLocked = true;
                $this->legalFrontendComponents = self::$staticModules;
            }
        }
        $this->setValidToDate($validTo);
    }
    
    public function checkSum($key, $id = true) {
        $length = 40;
        if ($id) {
            $id = $this->getInstallationId();
            if ($key == $id) {
                return false;
            }
        }
        if (strlen($key) != $length) {
            return false;
        }
        $realKey = substr($key, 0, $length - 8);
        $realChecksum = str_pad(dechex(crc32($realKey)), 8, '0', STR_PAD_LEFT);
        return $key === $realKey.$realChecksum;
    }
    
    /**
     *
     * @global type $_POST
     * @param \settingsManager $settingsManager
     * @param \ADONewConnection $objDb 
     */
    public function save($settingsManager, $objDb) {
        // WARNING, this is the ugly way:
        global $_POST;
        $oldpost = $_POST;
        unset($_POST);
        
        $_POST['setvalue'][75] = $this->getInstallationId();                                // installationId
        $_POST['setvalue'][76] = $this->getLicenseKey();                                    // licenseKey
        $_POST['setvalue'][90] = $this->getState();                                         // licenseState
        $_POST['setvalue'][91] = $this->getValidToDate();                                   // licenseValidTo
        $_POST['setvalue'][92] = $this->getEditionName();                                   // coreCmsEdition
        
        // we must encode the serialized objects to prevent that non-ascii chars
        // get written into the config/settings.php file
        $_POST['setvalue'][93] = base64_encode(serialize($this->getMessages()));            // licenseMessage
        
        $_POST['setvalue'][94] = $this->getCreatedAtDate();                                 // licenseCreatedAt
        $_POST['setvalue'][95] = base64_encode(serialize($this->getRegisteredDomains()));   // licenseDomains
        $_POST['setvalue'][96] = base64_encode(serialize($this->getGrayzoneMessages()));    // licenseGrayzoneMessages
        
        $_POST['setvalue'][97] = $this->getVersion()->getNumber();                          // coreCmsVersion
        $_POST['setvalue'][98] = $this->getVersion()->getCodeName();                        // coreCmsCodeName
        $_POST['setvalue'][99] = $this->getVersion()->getState();                           // coreCmsStatus
        $_POST['setvalue'][100] = $this->getVersion()->getReleaseDate();                    // coreCmsReleaseDate
        
        // see comment above why we encode the serialized data here
        $_POST['setvalue'][101] = base64_encode(serialize($this->getPartner()));            // licensePartner
        $_POST['setvalue'][102] = base64_encode(serialize($this->getCustomer()));           // licenseCustomer
        
        $_POST['setvalue'][103] = base64_encode(serialize($this->getAvailableComponents()));// availableComponents
        
        $_POST['setvalue'][104] = $this->getUpgradeUrl();                                   // upgradeUrl
        $_POST['setvalue'][105] = ($this->isUpgradable() ? 'on' : 'off');                   // isUpgradable

        $_POST['setvalue'][106] = base64_encode(serialize($this->getDashboardMessages()));  // dashboardMessages

        $_POST['setvalue'][112] = $this->getVersion()->getName();                           // coreCmsName
        
        $_POST['setvalue'][114] = $this->getGrayzoneTime();                                 // licenseGrayzoneTime
        $_POST['setvalue'][115] = $this->getFrontendLockTime();                             // licenseLockTime
        $_POST['setvalue'][116] = $this->getRequestInterval();                              // licenseUpdateInterval
        
        $_POST['setvalue'][117] = $this->getFirstFailedUpdateTime();                        // licenseFailedUpdate
        $_POST['setvalue'][118] = $this->getLastSuccessfulUpdateTime();                     // licenseSuccessfulUpdate
        
        $settingsManager->updateSettings();
        $settingsManager->writeSettingsFile();
        
        $query = '
            UPDATE
                '.DBPREFIX.'modules
            SET
                `is_licensed` = \'0\'
            WHERE
                `distributor` = \'Comvation AG\'
        ';
        $objDb->Execute($query);
        $query = '
            UPDATE
                '.DBPREFIX.'modules
            SET
                `is_licensed` = \'1\'
            WHERE
                `name` IN(\'' . implode('\', \'', $this->getLegalComponentsList()) . '\')
        ';
        $objDb->Execute($query);
        unset($_POST);
        $_POST = $oldpost;
    }
    
    /**
     * @param \SettingDb $settings Reference to the settings manager object
     * @return \Cx\Core_Modules\License\License
     */
    public static function getCached(&$_CONFIG, $objDb) {
        $state = isset($_CONFIG['licenseState']) ? htmlspecialchars_decode($_CONFIG['licenseState']) : self::LICENSE_DEMO;
        $validTo = isset($_CONFIG['licenseValidTo']) ? htmlspecialchars_decode($_CONFIG['licenseValidTo']) : null;
        $editionName = isset($_CONFIG['coreCmsEdition']) ? htmlspecialchars_decode($_CONFIG['coreCmsEdition']) : null;
        $instId = isset($_CONFIG['installationId']) ? htmlspecialchars_decode($_CONFIG['installationId']) : null;
        $licenseKey = isset($_CONFIG['licenseKey']) ? htmlspecialchars_decode($_CONFIG['licenseKey']) : null;
        
        $messages = isset($_CONFIG['licenseMessage']) ? unserialize(base64_decode(htmlspecialchars_decode($_CONFIG['licenseMessage']))) : array();
        
        $createdAt = isset($_CONFIG['licenseCreatedAt']) ? htmlspecialchars_decode($_CONFIG['licenseCreatedAt']) : null;
        $registeredDomains = isset($_CONFIG['licenseDomains']) ? unserialize(base64_decode(htmlspecialchars_decode($_CONFIG['licenseDomains']))) : array();
        
        $grayzoneMessages = isset($_CONFIG['licenseGrayzoneMessages']) ? unserialize(base64_decode(htmlspecialchars_decode($_CONFIG['licenseGrayzoneMessages']))) : array();
        $dashboardMessages = isset($_CONFIG['dashboardMessages']) ? unserialize(base64_decode(htmlspecialchars_decode($_CONFIG['dashboardMessages']))) : array();
        
        $partner = isset($_CONFIG['licensePartner']) ? unserialize(base64_decode(htmlspecialchars_decode($_CONFIG['licensePartner']))) : new Person();
        $customer = isset($_CONFIG['licenseCustomer']) ? unserialize(base64_decode(htmlspecialchars_decode($_CONFIG['licenseCustomer']))) : new Person();
        
        $versionNumber = isset($_CONFIG['coreCmsVersion']) ? htmlspecialchars_decode($_CONFIG['coreCmsVersion']) : null;
        $versionName = isset($_CONFIG['coreCmsName']) ? htmlspecialchars_decode($_CONFIG['coreCmsName']) : null;
        $versionCodeName = isset($_CONFIG['coreCmsCodeName']) ? htmlspecialchars_decode($_CONFIG['coreCmsCodeName']) : null;
        $versionState = isset($_CONFIG['coreCmsStatus']) ? htmlspecialchars_decode($_CONFIG['coreCmsStatus']) : null;
        $versionReleaseDate = isset($_CONFIG['coreCmsReleaseDate']) ? htmlspecialchars_decode($_CONFIG['coreCmsReleaseDate']) : null;
        $version = new Version($versionNumber, $versionName, $versionCodeName, $versionState, $versionReleaseDate);
        
        $grayzoneTime = isset($_CONFIG['licenseGrayzoneTime']) ? htmlspecialchars_decode($_CONFIG['licenseGrayzoneTime']) : null;
        $lockTime = isset($_CONFIG['licenseLockTime']) ? htmlspecialchars_decode($_CONFIG['licenseLockTime']) : null;
        $updateInterval = isset($_CONFIG['licenseUpdateInterval']) ? htmlspecialchars_decode($_CONFIG['licenseUpdateInterval']) : null;
        $failedUpdate = isset($_CONFIG['licenseFailedUpdate']) ? htmlspecialchars_decode($_CONFIG['licenseFailedUpdate']) : null;
        $successfulUpdate = isset($_CONFIG['licenseSuccessfulUpdate']) ? htmlspecialchars_decode($_CONFIG['licenseSuccessfulUpdate']) : null;
        $upgradeUrl = isset($_CONFIG['upgradeUrl']) ? htmlspecialchars_decode($_CONFIG['upgradeUrl']) : null;
        $isUpgradable = isset($_CONFIG['isUpgradable']) ? $_CONFIG['isUpgradable'] == 'on' : false;
        
        $availableComponents = isset($_CONFIG['availableComponents']) ? unserialize(base64_decode(htmlspecialchars_decode($_CONFIG['availableComponents']))) : array();
        
        $query = '
            SELECT
                `name`
            FROM
                '.DBPREFIX.'modules
            WHERE
                `distributor` != \'Comvation AG\'
                OR
                `is_licensed` = \'1\'
        ';
        $result = $objDb->execute($query);
        $activeComponents = array();
        if ($result) {
            while (!$result->EOF) {
                $activeComponents[] = $result->fields['name'];
                $result->MoveNext();
            }
        }
        return new static(
            $state,
            $editionName,
            $availableComponents,
            $activeComponents,
            $validTo,
            $createdAt,
            $registeredDomains,
            $instId,
            $licenseKey,
            $messages,
            $version,
            $partner,
            $customer,
            $grayzoneTime,
            $grayzoneMessages,
            $lockTime,
            $updateInterval,
            $failedUpdate,
            $successfulUpdate,
            $upgradeUrl,
            $isUpgradable,
            $dashboardMessages
        );
    }
}
