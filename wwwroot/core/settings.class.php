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
 * Settings
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Comvation Development Team <info@comvation.com>
 * @version     1.1.0
 * @package     contrexx
 * @subpackage  core
 * @todo        Edit PHP DocBlocks!
 */

/**
 * @ignore
 */
isset($objInit) && $objInit->mode == 'backend' ? require_once ASCMS_CORE_MODULE_PATH.'/cache/admin.class.php' : null;

/**
 * Settings
 *
 * CMS Settings management
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author        Comvation Development Team <info@comvation.com>
 * @access        public
 * @version        1.1.0
 * @package     contrexx
 * @subpackage  core
 */
class settingsManager
{
    var $_objTpl;
    var $strPageTitle;
    var $strSettingsFile;
    var $strErrMessage = array();
    var $strOkMessage;
    private $writable;

    private $act = '';
     
    function __construct()
    {
        $this->strSettingsFile = ASCMS_INSTANCE_PATH.ASCMS_INSTANCE_OFFSET.'/config/settings.php';
        $this->checkWritePermissions();
    }

    private function setNavigation()
    {
        global $objTemplate, $_CORELANG;

        $objTemplate->setVariable('CONTENT_NAVIGATION','
            <a href="?cmd=settings" class="'.($this->act == '' ? 'active' : '').'">'.$_CORELANG['TXT_SETTINGS_MENU_SYSTEM'].'</a>
            <a href="?cmd=settings&amp;act=cache" class="'.($this->act == 'cache' ? 'active' : '').'">'.$_CORELANG['TXT_SETTINGS_MENU_CACHE'].'</a>
            <a href="?cmd=settings&amp;act=smtp" class="'.($this->act == 'smtp' ? 'active' : '').'">'.$_CORELANG['TXT_EMAIL_SERVER'].'</a>
            <a href="index.php?cmd=settings&amp;act=image" class="'.($this->act == 'image' ? 'active' : '').'">'.$_CORELANG['TXT_SETTINGS_IMAGE'].'</a>
            <a href="index.php?cmd=license">'.$_CORELANG['TXT_LICENSE'].'</a>'
        );
    }

    /**
     * Check whether the configuration in the configurations file is correct or not
     * This method displays a warning message on top of the page when the ftp connection failed or the configuration
     * is disabled
     */
    protected function checkFtpAccess() {
        global $objTemplate, $_CORELANG;
        // if ftp access is not activated or not possible to connect (not correct credentials)
        if(!\Cx\Lib\FileSystem\FileSystem::init()) {
            $objTemplate->setVariable('TXT_SETTING_FTP_CONFIG_WARNING', sprintf($_CORELANG['TXT_SETTING_FTP_CONFIG_WARNING'], ASCMS_DOCUMENT_ROOT . '/config/configuration.php'));
            $objTemplate->parse('settings_ftp_config_warning');
        }
    }

    private function checkWritePermissions()
    {
        global $_CORELANG;

        if (\Cx\Lib\FileSystem\FileSystem::makeWritable($this->strSettingsFile)
        ) {
            $this->writable = true;
        } else {
            $this->writable = false;
            $this->strErrMessage[] = sprintf($_CORELANG['TXT_SETTINGS_ERROR_NO_WRITE_ACCESS'], $this->strSettingsFile);
        }
    }

    public function isWritable()
    {
        return $this->writable;
    }

    /**
     * Perform the requested function depending on $_GET['act']
     *
     * @global  array   Core language
     * @global  \Cx\Core\Html\Sigma
     * @return  void
     */
    function getPage()
    {
           global $_CORELANG, $objTemplate;        

        if(!isset($_GET['act'])){
            $_GET['act']='';
        }

        $boolShowStatus = true;

        switch ($_GET['act']) {
            case 'update':
                $this->updateSettings();
                $this->writeSettingsFile();
                $this->showSettings();
                break;

            case 'cache':
                $boolShowStatus = false;
                $objCache = new CacheManager();
                $objCache->showSettings();
                break;

            case 'cache_update':
                $boolShowStatus = false;
                $objCache = new CacheManager();
                $objCache->updateSettings();
                $objCache->showSettings();
                $this->writeSettingsFile();
                break;

            case 'cache_empty':
                $boolShowStatus = false;
                $objCache = new CacheManager();
                $objCache->forceClearCache(isset($_GET['cache']) ? contrexx_input2raw($_GET['cache']) : null);
                $objCache->showSettings();
                break;

            case 'smtp':
                $this->smtp();
                break;
            
            case 'image':
                try {
                    $this->image($_POST);
                } catch (Exception $e) {
                    DBG::msg('Image settings: '.$e->getMessage);
                }
                break;

            default:
                $this->showSettings();
        }

        if ($boolShowStatus) {
            $objTemplate->setVariable(array(
                'CONTENT_TITLE'                =>     $this->strPageTitle,
                'CONTENT_OK_MESSAGE'        =>    $this->strOkMessage,
                'CONTENT_STATUS_MESSAGE'    =>     implode("<br />\n", $this->strErrMessage)
            ));
        }

        $this->act = $_REQUEST['act'];
        $this->setNavigation();
    }


    /**
     * Set the cms system settings
     * @global  ADONewConnection
     * @global  array   Core language
     * @global  \Cx\Core\Html\Sigma
     */
    function showSettings()
    {
        global $objDatabase, $_CORELANG, $objTemplate, $_CONFIG, $_FRONTEND_LANGID;

        JS::activate('jquery');

        $objTemplate->addBlockfile('ADMIN_CONTENT', 'settings', 'settings.html');

        // check whether the ftp configurations are correct or not
        $this->checkFtpAccess();

        $this->strPageTitle = $_CORELANG['TXT_SYSTEM_SETTINGS'];

        $objResult = $objDatabase->Execute('SELECT setid,
                                                   setname,
                                                   setvalue,
                                                   setmodule
                                            FROM '.DBPREFIX.'settings');
        if ($objResult !== false) {
            while (!$objResult->EOF) {
                $arrSettings[$objResult->fields['setname']] = $objResult->fields['setvalue'];
                $objResult->MoveNext();
            }
        }

        $objTemplate->setGlobalVariable(array(
            'TXT_RADIO_ON'                    => $_CORELANG['TXT_ACTIVATED'],
            'TXT_RADIO_OFF'                   => $_CORELANG['TXT_DEACTIVATED']
        ));
        $objTemplate->setVariable(array(
            'TXT_TITLE_SET1'                            => $_CORELANG['TXT_SETTINGS_TITLE_MISC'],
            'TXT_TITLE_SET2'                            => $_CORELANG['TXT_ADMIN_AREA'],
            'TXT_TITLE_SET3'                            => $_CORELANG['TXT_SECURITY'],
            'TXT_TITLE_SET4'                            => $_CORELANG['TXT_SETTINGS_TITLE_CONTACT'],
            'TXT_TITLE_SET5'                            => $_CORELANG['TXT_SETTINGS_TITLE_DEVELOPMENT'],
            'TXT_TITLE_SET6'                            => $_CORELANG['TXT_OTHER_CONFIG_OPTIONS'],
            'TXT_DEBUGGING_STATUS'                      => $_CORELANG['TXT_DEBUGGING_STATUS'],
            'TXT_DEBUGGING_FLAGS'                       => $_CORELANG['TXT_DEBUGGING_FLAGS'],
            'TXT_SETTINGS_DEBUGGING_FLAG_LOG'           => $_CORELANG['TXT_SETTINGS_DEBUGGING_FLAG_LOG'],
            'TXT_SETTINGS_DEBUGGING_FLAG_PHP'           => $_CORELANG['TXT_SETTINGS_DEBUGGING_FLAG_PHP'],
            'TXT_SETTINGS_DEBUGGING_FLAG_DB'            => $_CORELANG['TXT_SETTINGS_DEBUGGING_FLAG_DB'],
            'TXT_SETTINGS_DEBUGGING_FLAG_DB_TRACE'      => $_CORELANG['TXT_SETTINGS_DEBUGGING_FLAG_DB_TRACE'],
            'TXT_SETTINGS_DEBUGGING_FLAG_DB_CHANGE'     => $_CORELANG['TXT_SETTINGS_DEBUGGING_FLAG_DB_CHANGE'],
            'TXT_SETTINGS_DEBUGGING_FLAG_DB_ERROR'      => $_CORELANG['TXT_SETTINGS_DEBUGGING_FLAG_DB_ERROR'],
            'TXT_SETTINGS_DEBUGGING_FLAG_LOG_FILE'      => $_CORELANG['TXT_SETTINGS_DEBUGGING_FLAG_LOG_FILE'],
            'TXT_SETTINGS_DEBUGGING_FLAG_LOG_FIREPHP'   => $_CORELANG['TXT_SETTINGS_DEBUGGING_FLAG_LOG_FIREPHP'],
            'TXT_DEBUGGING_EXPLANATION'                 => $_CORELANG['TXT_DEBUGGING_EXPLANATION'],
            'TXT_SAVE_CHANGES'                          => $_CORELANG['TXT_SAVE'],
            'TXT_SYSTEM_STATUS'                         => $_CORELANG['TXT_SETTINGS_SYSTEMSTATUS'],
            'TXT_SYSTEM_STATUS_HELP'                    => $_CORELANG['TXT_SETTINGS_SYSTEMSTATUS_HELP'],
            'TXT_IDS_STATUS'                            => $_CORELANG['TXT_SETTINGS_IDS'],
            'TXT_IDS_STATUS_HELP'                       => $_CORELANG['TXT_SETTINGS_IDS_HELP'],
            'TXT_XML_SITEMAP_STATUS'                    => $_CORELANG['TXT_SETTINGS_XML_SITEMAP'],
            'TXT_XML_SITEMAP_STATUS_HELP'               => $_CORELANG['TXT_SETTINGS_XML_SITEMAP_HELP'],
            'TXT_GLOBAL_TITLE'                          => $_CORELANG['TXT_SETTINGS_GLOBAL_TITLE'],
            'TXT_GLOBAL_TITLE_HELP'                     => $_CORELANG['TXT_SETTINGS_GLOBAL_TITLE_HELP'],
            'TXT_DOMAIN_URL'                            => $_CORELANG['TXT_SETTINGS_DOMAIN_URL'],
            'TXT_DOMAIN_URL_HELP'                       => $_CORELANG['TXT_SETTINGS_DOMAIN_URL_HELP'],
            'TXT_PAGING_LIMIT'                          => $_CORELANG['TXT_SETTINGS_PAGING_LIMIT'],
            'TXT_PAGING_LIMIT_HELP'                     => $_CORELANG['TXT_SETTINGS_PAGING_LIMIT_HELP'],
            'TXT_SEARCH_RESULT'                         => $_CORELANG['TXT_SETTINGS_SEARCH_RESULT'],
            'TXT_SEARCH_RESULT_HELP'                    => $_CORELANG['TXT_SETTINGS_SEARCH_RESULT_HELP'],
            'TXT_SESSION_LIVETIME'                      => $_CORELANG['TXT_SETTINGS_SESSION_LIVETIME'],
            'TXT_SESSION_LIVETIME_HELP'                 => $_CORELANG['TXT_SETTINGS_SESSION_LIVETIME_HELP'],
            'TXT_SESSION_LIFETIME_REMEMBER_ME'          => $_CORELANG['TXT_SETTINGS_SESSION_LIFETIME_REMEMBER_ME'],
            'TXT_SESSION_LIFETIME_REMEMBER_ME_HELP'     => $_CORELANG['TXT_SETTINGS_SESSION_LIFETIME_HELP_REMEMBER_ME'],
            'TXT_DNS_SERVER'                            => $_CORELANG['TXT_SETTINGS_DNS_SERVER'],
            'TXT_DNS_SERVER_HELP'                       => $_CORELANG['TXT_SETTINGS_DNS_SERVER_HELP'],
            'TXT_ADMIN_NAME'                            => $_CORELANG['TXT_SETTINGS_ADMIN_NAME'],
            'TXT_ADMIN_EMAIL'                           => $_CORELANG['TXT_SETTINGS_ADMIN_EMAIL'],
            'TXT_CONTACT_EMAIL'                         => $_CORELANG['TXT_SETTINGS_CONTACT_EMAIL'],
            'TXT_CONTACT_EMAIL_HELP'                    => $_CORELANG['TXT_SETTINGS_CONTACT_EMAIL_HELP'],
            'TXT_CONTACT_COMPANY'                       => $_CORELANG['TXT_SETTINGS_CONTACT_COMPANY'],
            'TXT_CONTACT_ADDRESS'                       => $_CORELANG['TXT_SETTINGS_CONTACT_ADDRESS'],
            'TXT_CONTACT_ZIP'                           => $_CORELANG['TXT_SETTINGS_CONTACT_ZIP'],
            'TXT_CONTACT_PLACE'                         => $_CORELANG['TXT_SETTINGS_CONTACT_PLACE'],
            'TXT_CONTACT_COUNTRY'                       => $_CORELANG['TXT_SETTINGS_CONTACT_COUNTRY'],
            'TXT_CONTACT_PHONE'                         => $_CORELANG['TXT_SETTINGS_CONTACT_PHONE'],
            'TXT_CONTACT_FAX'                           => $_CORELANG['TXT_SETTINGS_CONTACT_FAX'],
            'TXT_SEARCH_VISIBLE_CONTENT_ONLY'           => $_CORELANG['TXT_SEARCH_VISIBLE_CONTENT_ONLY'],
            'TXT_SYSTEM_DETECT_BROWSER_LANGUAGE'        => $_CORELANG['TXT_SYSTEM_DETECT_BROWSER_LANGUAGE'],
            'TXT_SYSTEM_DEFAULT_LANGUAGE_HELP'          => $_CORELANG['TXT_SYSTEM_DEFAULT_LANGUAGE_HELP'],
            'TXT_GOOGLE_MAPS_API_KEY_HELP'              => $_CORELANG['TXT_GOOGLE_MAPS_API_KEY_HELP'],
            'TXT_GOOGLE_MAPS_API_KEY'                   => $_CORELANG['TXT_GOOGLE_MAPS_API_KEY'],
            'TXT_FRONTEND_EDITING_STATUS'               => $_CORELANG['TXT_SETTINGS_FRONTEND_EDITING'],
            'TXT_FRONTEND_EDITING_STATUS_HELP'          => $_CORELANG['TXT_SETTINGS_FRONTEND_EDITING_HELP'],
            'TXT_USE_CUSTOMIZING_STATUS'                => $_CORELANG['TXT_USE_CUSTOMIZING_STATUS'],
            'TXT_USE_CUSTOMIZING_STATUS_HELP'           => preg_replace("/%1/", ASCMS_CUSTOMIZING_WEB_PATH, $_CORELANG['TXT_USE_CUSTOMIZING_STATUS_HELP']),
            'TXT_CORE_LIST_PROTECTED_PAGES'             => $_CORELANG['TXT_CORE_LIST_PROTECTED_PAGES'],
            'TXT_CORE_LIST_PROTECTED_PAGES_HELP'        => $_CORELANG['TXT_CORE_LIST_PROTECTED_PAGES_HELP'],
            'TXT_CORE_TIMEZONE'                         => $_CORELANG['TXT_CORE_TIMEZONE'],
            'TXT_DASHBOARD_NEWS'                        => $_CORELANG['TXT_DASHBOARD_NEWS'],
            'TXT_DASHBOARD_STATISTICS'                  => $_CORELANG['TXT_DASHBOARD_STATISTICS'],
            'TXT_GOOGLE_ANALYTICS_TRACKING_ID'          => $_CORELANG['TXT_GOOGLE_ANALYTICS_TRACKING_ID'],
            'TXT_GOOGLE_ANALYTICS_TRACKING_ID_INFO'     => $_CORELANG['TXT_GOOGLE_ANALYTICS_TRACKING_ID_INFO'],
            'TXT_PASSWORD_COMPLEXITY'                   => $_CORELANG['TXT_PASSWORD_COMPLEXITY'],
            'TXT_PASSWORD_COMPLEXITY_INFO'              => $_CORELANG['TXT_PASSWORD_COMPLEXITY_INFO'],
        ));

        if ($this->isWritable()) {
            $objTemplate->parse('settings_submit_button');
        } else {
            $objTemplate->hideBlock('settings_submit_button');
        }

        // There was a lot of htmlentities() in the list below, which is not needed,
        // as every setting entry is already passed through htmlspecialchars() when
        // saved. See function updateSettings() below
        $objTemplate->setVariable(array(
            'SETTINGS_CONTACT_EMAIL'                        => contrexx_raw2xhtml($arrSettings['contactFormEmail']),
            'SETTINGS_CONTACT_COMPANY'                      => contrexx_raw2xhtml($arrSettings['contactCompany']),
            'SETTINGS_CONTACT_ADDRESS'                      => contrexx_raw2xhtml($arrSettings['contactAddress']),
            'SETTINGS_CONTACT_ZIP'                          => contrexx_raw2xhtml($arrSettings['contactZip']),
            'SETTINGS_CONTACT_PLACE'                        => contrexx_raw2xhtml($arrSettings['contactPlace']),
            'SETTINGS_CONTACT_COUNTRY'                      => contrexx_raw2xhtml($arrSettings['contactCountry']),
            'SETTINGS_CONTACT_PHONE'                        => contrexx_raw2xhtml($arrSettings['contactPhone']),
            'SETTINGS_CONTACT_FAX'                          => contrexx_raw2xhtml($arrSettings['contactFax']),
            'SETTINGS_ADMIN_EMAIL'                          => $arrSettings['coreAdminEmail'],
            'SETTINGS_ADMIN_NAME'                           => $arrSettings['coreAdminName'],
            'SETTINGS_GLOBAL_TITLE'                         => $arrSettings['coreGlobalPageTitle'],
            'SETTINGS_DOMAIN_URL'                           => $arrSettings['domainUrl'],
            'SETTINGS_PAGING_LIMIT'                         => intval($arrSettings['corePagingLimit']),
            'SETTINGS_SEARCH_RESULT_LENGTH'                 => intval($arrSettings['searchDescriptionLength']),
            'SETTINGS_SESSION_LIFETIME'                     => intval($arrSettings['sessionLifeTime']),
            'SETTINGS_SESSION_LIFETIME_REMEMBER_ME'         => $arrSettings['sessionLifeTimeRememberMe'],
            'SETTINGS_DNS_SERVER'                           => $arrSettings['dnsServer'],
            'SETTINGS_IDS_RADIO_ON'                         => ($arrSettings['coreIdsStatus'] == 'on') ? 'checked="checked"' : '',
            'SETTINGS_IDS_RADIO_OFF'                        => ($arrSettings['coreIdsStatus'] == 'off') ? 'checked="checked"' : '',
            'SETTINGS_XML_SITEMAP_ON'                       => ($arrSettings['xmlSitemapStatus'] == 'on') ? 'checked="checked"' : '',
            'SETTINGS_XML_SITEMAP_OFF'                      => ($arrSettings['xmlSitemapStatus'] == 'off') ? 'checked="checked"' : '',
            'SETTINGS_SYSTEMSTATUS_ON'                      => ($arrSettings['systemStatus'] == 'on') ? 'checked="checked"' : '',
            'SETTINGS_SYSTEMSTATUS_OFF'                     => ($arrSettings['systemStatus'] == 'off') ? 'checked="checked"' : '',
            'SETTINGS_SEARCH_VISIBLE_CONTENT_ON'            => ($arrSettings['searchVisibleContentOnly'] == 'on') ? 'checked="checked"' : '',
            'SETTINGS_SEARCH_VISIBLE_CONTENT_OFF'           => ($arrSettings['searchVisibleContentOnly'] == 'off') ? 'checked="checked"' : '',
            'SETTINGS_DETECT_BROWSER_LANGUAGE_ON'           => ($arrSettings['languageDetection'] == 'on') ? 'checked="checked"' : '',
            'SETTINGS_DETECT_BROWSER_LANGUAGE_OFF'          => ($arrSettings['languageDetection'] == 'off') ? 'checked="checked"' : '',
            'SETTINGS_FRONTEND_EDITING_ON'                  => ($arrSettings['frontendEditingStatus'] == 'on') ? 'checked="checked"' : '',
            'SETTINGS_FRONTEND_EDITING_OFF'                 => ($arrSettings['frontendEditingStatus'] == 'off') ? 'checked="checked"' : '',
            'SETTINGS_USE_CUSTOMIZING_ON'                  => ($arrSettings['useCustomizings'] == 'on') ? 'checked="checked"' : '',
            'SETTINGS_USE_CUSTOMIZING_OFF'                 => ($arrSettings['useCustomizings'] == 'off') ? 'checked="checked"' : '',
            'SETTINGS_GOOGLE_MAPS_API_KEY'                  => $arrSettings['googleMapsAPIKey'],
            'SETTINGS_LIST_PROTECTED_PAGES_ON'              => ($arrSettings['coreListProtectedPages'] == 'on') ? 'checked="checked"' : '',
            'SETTINGS_LIST_PROTECTED_PAGES_OFF'             => ($arrSettings['coreListProtectedPages'] == 'off') ? 'checked="checked"' : '',
            'SETTINGS_TIMEZONE_OPTIONS'                     => $this->getTimezoneOptions($arrSettings['timezone']),
            'SETTINGS_DASHBOARD_NEWS_ON'                    => ($arrSettings['dashboardNews'] == 'on') ? 'checked="checked"' : '',
            'SETTINGS_DASHBOARD_NEWS_OFF'                   => ($arrSettings['dashboardNews'] == 'off') ? 'checked="checked"' : '',
            'SETTINGS_DASHBOARD_STATISTICS_ON'              => ($arrSettings['dashboardStatistics'] == 'on') ? 'checked="checked"' : '',
            'SETTINGS_DASHBOARD_STATISTICS_OFF'             => ($arrSettings['dashboardStatistics'] == 'off') ? 'checked="checked"' : '',
            'SETTINGS_GOOGLE_ANALYTICS_TRACKING_ID'         => $arrSettings['googleAnalyticsTrackingId'],
            'SETTINGS_PASSWORD_COMPLEXITY_ON'               => ($arrSettings['passwordComplexity'] == 'on') ? 'checked="checked"' : '',
            'SETTINGS_PASSWORD_COMPLEXITY_OFF'              => ($arrSettings['passwordComplexity'] == 'off') ? 'checked="checked"' : '',
        ));

        $objTemplate->setVariable(array(
            'TXT_ADVANCED_UPLOAD_STATUS_BACKEND'        => $_CORELANG['TXT_ADVANCED_UPLOAD_STATUS_BACKEND'],
            'TXT_ADVANCED_UPLOAD_STATUS_FRONTEND'       => $_CORELANG['TXT_ADVANCED_UPLOAD_STATUS_FRONTEND'],
            'SETTINGS_ADVANCED_UPLOAD_BACKEND_ON'       => ($arrSettings['advancedUploadBackend'] == 'on') ? 'checked="checked"' : '',
            'SETTINGS_ADVANCED_UPLOAD_BACKEND_OFF'      => ($arrSettings['advancedUploadBackend'] == 'off') ? 'checked="checked"' : '',
            'SETTINGS_ADVANCED_UPLOAD_FRONTEND_ON'      => ($arrSettings['advancedUploadFrontend'] == 'on') ? 'checked="checked"' : '',
            'SETTINGS_ADVANCED_UPLOAD_FRONTEND_OFF'     => ($arrSettings['advancedUploadFrontend'] == 'off') ? 'checked="checked"' : ''
        ));

        $objTemplate->setVariable(array(
            'TXT_SETTINGS_PROTOCOL_HTTPS_HELP'          => $_CORELANG['TXT_SETTINGS_PROTOCOL_HTTPS_HELP'],
            'TXT_SETTINGS_PROTOCOL_HTTPS_BACKEND'       => $_CORELANG['TXT_SETTINGS_PROTOCOL_HTTPS_BACKEND'],
            'TXT_SETTINGS_PROTOCOL_HTTPS_FRONTEND'      => $_CORELANG['TXT_SETTINGS_PROTOCOL_HTTPS_FRONTEND'],
            'TXT_FORCE_PROTOCOL_NONE'                   => $_CORELANG['TXT_SETTINGS_FORCE_PROTOCOL_NONE'],
            'TXT_FORCE_PROTOCOL_HTTP'                   => $_CORELANG['TXT_SETTINGS_FORCE_PROTOCOL_HTTP'],
            'TXT_FORCE_PROTOCOL_HTTPS'                  => $_CORELANG['TXT_SETTINGS_FORCE_PROTOCOL_HTTPS'],
            'SETTINGS_FORCE_PROTOCOL_FRONTEND_NONE'     => (substr($arrSettings['forceProtocolFrontend'], 0, 4) != 'http' ? ' selected="selected"' : ''),
            'SETTINGS_FORCE_PROTOCOL_FRONTEND_HTTP'     => ($arrSettings['forceProtocolFrontend'] == 'http' ? ' selected="selected"' : ''),
            'SETTINGS_FORCE_PROTOCOL_FRONTEND_HTTPS'    => ($arrSettings['forceProtocolFrontend'] == 'https' ? ' selected="selected"' : ''),
            'SETTINGS_FORCE_PROTOCOL_BACKEND_NONE'     => (substr($arrSettings['forceProtocolBackend'], 0, 4) != 'http' ? ' selected="selected"' : ''),
            'SETTINGS_FORCE_PROTOCOL_BACKEND_HTTP'     => ($arrSettings['forceProtocolBackend'] == 'http' ? ' selected="selected"' : ''),
            'SETTINGS_FORCE_PROTOCOL_BACKEND_HTTPS'    => ($arrSettings['forceProtocolBackend'] == 'https' ? ' selected="selected"' : ''),
        ));

        $objTemplate->setVariable(array(
            'TXT_SETTINGS_FORCE_DOMAIN_URL_HELP'        => $_CORELANG['TXT_SETTINGS_FORCE_DOMAIN_URL_HELP'],
            'TXT_SETTINGS_FORCE_DOMAIN_URL'             => $_CORELANG['TXT_SETTINGS_FORCE_DOMAIN_URL'],
            'SETTINGS_FORCE_DOMAIN_URL_ON'              => ($arrSettings['forceDomainUrl'] == 'on') ? 'checked="checked"' : '',
            'SETTINGS_FORCE_DOMAIN_URL_OFF'              => ($arrSettings['forceDomainUrl'] == 'off') ? 'checked="checked"' : '',
        ));
        
        $this->setDebuggingVariables($objTemplate);
    }

    /**
     * Returns all available timezones
     *
     * @access  private
     * @param   string      $selectedTimezone   name of the selected timezone
     * @return  string      $timezoneOptions    available timezones as HTML <option></option>
     */
    private function getTimezoneOptions($selectedTimezone) {
        $timezoneOptions = '';
        foreach (timezone_identifiers_list() as $timezone) {
            $dateTimeZone = new DateTimeZone($timezone);
            $dateTime     = new DateTime('now', $dateTimeZone);
            $timeOffset   = $dateTimeZone->getOffset($dateTime);
            $plusOrMinus  = $timeOffset < 0 ? '-' : '+';
            $gmt          = 'GMT ' . $plusOrMinus . ' ' . gmdate('g:i', $timeOffset);
            $timezoneOptions .= '<option value="'.$timezone.'"'.(($timezone == $selectedTimezone) ? ' selected="selected"' : '').'>'.$timezone.' ('.$gmt.')</option>';
        }
        return $timezoneOptions;
    }

    /**
     * Sets debugging related template variables according to session state.
     *
     * @param template the Sigma tpl
     */
    protected function setDebuggingVariables($template) {
        $status = $_SESSION['debugging'];
        $flags = $_SESSION['debugging_flags'];

        $flags = $this->debuggingFlagArrayFromFlags($flags);

        $template->setVariable(array(
            'DEBUGGING_HIDE_FLAGS' => $this->stringIfTrue(!$status,'style="display:none;"'),
            'SETTINGS_DEBUGGING_ON' => $this->stringIfTrue($status,'checked="checked"'),
            'SETTINGS_DEBUGGING_OFF' => $this->stringIfTrue(!$status,'checked="checked"'),
            'SETTINGS_DEBUGGING_FLAG_LOG' => $this->stringIfTrue($flags['log'] || !$status,'checked="checked"'),
            'SETTINGS_DEBUGGING_FLAG_PHP' => $this->stringIfTrue($flags['php'] || !$status,'checked="checked"'),
            'SETTINGS_DEBUGGING_FLAG_DB' => $this->stringIfTrue($flags['db'],'checked="checked"'),
            'SETTINGS_DEBUGGING_FLAG_DB_TRACE' => $this->stringIfTrue($flags['db_trace'] || !$status,'checked="checked"'),
            'SETTINGS_DEBUGGING_FLAG_DB_CHANGE' => $this->stringIfTrue($flags['db_change'] || !$status,'checked="checked"'),
            'SETTINGS_DEBUGGING_FLAG_DB_ERROR' => $this->stringIfTrue($flags['db_error'] || !$status,'checked="checked"'),
            'SETTINGS_DEBUGGING_FLAG_LOG_FIREPHP' => $this->stringIfTrue($flags['log_firephp'],'checked="checked"'),
            'SETTINGS_DEBUGGING_FLAG_LOG_FILE' => $this->stringIfTrue($flags['log_file'],'checked="checked"')
        ));
    }

    /**
     * returns $str if $check is true, else ''
     */
    protected function stringIfTrue($check, $str) {
        if($check)
            return $str;
        return '';
    }

    /**
     * Update settings
     *
     * @global  ADONewConnection
     * @global  array   Core language
     * @global  array   Configuration
     */
    function updateSettings()
    {
        global $objDatabase, $_CORELANG, $_CONFIG, $objTemplate;

        if (isset($_POST['setvalue'][87]) && !in_array((!empty($_POST['setvalue'][87]) ? $_POST['setvalue'][87] : ''), timezone_identifiers_list())) {
            $this->strErrMessage[] = $_CORELANG['TXT_CORE_TIMEZONE_INVALID'];
            return;
        }

        $checkWebsiteAccess = false;
        foreach ($_POST['setvalue'] as $id => $value) {
            switch (intval($id)) {
                case 53:
                    $arrMatch = array();
                    if (preg_match('#^https?://(.*)$#', $value, $arrMatch)) {
                        $value = $arrMatch[1];
                    }
                    $_CONFIG['domainUrl'] = htmlspecialchars($value, ENT_QUOTES, CONTREXX_CHARSET);
                    break;
                case 54:
                    $_CONFIG['xmlSitemapStatus'] = $value;
                    break;
                case 71:
                    $_CONFIG['coreListProtectedPages'] = $value;
                    break;
                case 43:
                case 50:
                case 54:
                case 55:
                case 56:
                case 63:
                case 67:
                case 69:
                case 70:
                case 71:
                case 85:
                case 86:
                case 89:
                    $value = ($value == 'on') ? 'on' : 'off';
                    break;
                case 57:
                    if ($_CONFIG['forceProtocolFrontend'] != $value) {
                        if (!$this->checkAccessibility($value)) {
                            $value = 'none';
                        }
                        $_CONFIG['forceProtocolFrontend'] = $value;
                    }
                    break;
                case 58:
                    if ($_CONFIG['forceProtocolBackend'] != $value) {
                        if (!$this->checkAccessibility($value)) {
                            $value = 'none';
                        }
                        $_CONFIG['forceProtocolBackend'] = $value;
                    }
                    break;
                case 59:
                    $useHttps = $_CONFIG['forceProtocolBackend'] == 'https';
                    $protocol = 'http';
                    if ($useHttps == 'https') {
                        $protocol = 'https';
                    }
                    $value = $this->checkAccessibility($protocol) ? $value : 'off';
                    $_CONFIG['forceDomainUrl'] = $value;
                    break;
            }
            $objDatabase->Execute(' UPDATE `'.DBPREFIX.'settings`
                                    SET `setvalue` = "'.contrexx_input2db($value).'"
                                    WHERE `setid` = '.intval($id));
        }
        
        if (isset($_POST['debugging'])) {
            $this->updateDebugSettings(!empty($_POST['debugging']) ? $_POST['debugging'] : null);
        }
        $this->strOkMessage = $_CORELANG['TXT_SETTINGS_UPDATED'];
    }
    
    /**
     * Checks whether the currently configured domain url is accessible 
     * @param string $protocol the protocol to check for access
     * @return bool true if the domain is accessable
     */
    protected function checkAccessibility($protocol = 'http') {
        global $_CONFIG;
        if (!in_array($protocol, array('http', 'https'))) {
            return false;
        }
        
        try {
            // create request to port 443 (https), to check whether the request works or not
            $request = new \HTTP_Request2($protocol . '://' . $_CONFIG['domainUrl'] . ASCMS_ADMIN_WEB_PATH . '/index.php?cmd=jsondata');

            // ignore ssl issues
            // otherwise, contrexx does not activate 'https' when the server doesn't have an ssl certificate installed
            $request->setConfig(array(
                'ssl_verify_peer' => false,
            ));

            // send the request
            // if this does not work, because there is no ssl support, an exception is thrown
            $objResponse = $request->send();

            // get the status code from the request
            $result = json_decode($objResponse->getBody());
            
            // get the status code from the request
            $status = $objResponse->getStatus();
            if (in_array($status, array(500))) {
                return false;
            }
            // the request should return a json object with the status 'error' if it is a contrexx installation
            if (!$result || $result->status != 'error') {
                return false;
            }
        } catch (\HTTP_Request2_Exception $e) {
            // https is not available, exception thrown
            return false;
        }
        return true;
    }

    /**
     * Calculates a flag value as passed to DBG::activate() from an array.
     * @param array flags array('php' => bool, 'db' => bool, 'db_error' => bool, 'log_firephp' => bool
     * @return int an int with the flags set.
     */
    protected function debuggingFlagsFromFlagArray($flags) {
        $ret = 0;
        if(isset($flags['log']) && $flags['log'])
            $ret |= DBG_LOG;
        if(isset($flags['php']) && $flags['php'])
            $ret |= DBG_PHP;
        if(isset($flags['db']) && $flags['db'])
            $ret |= DBG_DB;
        if(isset($flags['db_change']) && $flags['db_change'])
            $ret |= DBG_DB_CHANGE;
        if(isset($flags['db_error']) && $flags['db_error'])
            $ret |= DBG_DB_ERROR;
        if(isset($flags['db_trace']) && $flags['db_trace'])
            $ret |= DBG_DB_TRACE;
        if(isset($flags['log_file']) && $flags['log_file'])
            $ret |= DBG_LOG_FILE;
        if(isset($flags['log_firephp']) && $flags['log_firephp'])
            $ret |= DBG_LOG_FIREPHP;

        return $ret;
    }

    /**
     * Analyzes an int as passed to DBG::activate() and yields an array containing information about the flags.
     * @param int $flags
     * @return array('php' => bool, 'db' => bool, 'db_error' => bool, 'log_firephp' => bool
     */
    protected function debuggingFlagArrayFromFlags($flags) {
        return array(
            'log' => (bool)($flags & DBG_LOG),
            'php' => (bool)($flags & DBG_PHP),
            'db' => (bool)($flags & DBG_DB),
            'db_change' => (bool)($flags & DBG_DB_CHANGE),
            'db_error' => (bool)($flags & DBG_DB_ERROR),
            'db_trace' => (bool)($flags & DBG_DB_TRACE),
            'log_firephp' => (bool)($flags & DBG_LOG_FIREPHP),
            'log_file' => (bool)($flags & DBG_LOG_FILE)
        );
    }

    protected function updateDebugSettings($settings) {
        $status = $settings['status'] == "on";

        $flags = array();
        
        if(isset($settings['flag_log'])) {
            $flags['log'] = $settings['flag_log'];
        }
        if(isset($settings['flag_php'])) {
            $flags['php'] = $settings['flag_php'];
        }
        if(isset($settings['flag_db'])) {
            $flags['db'] = $settings['flag_db'];
        }
        if(isset($settings['flag_db_change'])) {
            $flags['db_change'] = $settings['flag_db_change'];
        }
        if(isset($settings['flag_db_error'])) {
            $flags['db_error'] = $settings['flag_db_error'];
        }
        if(isset($settings['flag_db_trace'])) {
            $flags['db_trace'] = $settings['flag_db_trace'];
        }
        if(isset($settings['flag_log_firephp'])) {
            $flags['log_firephp'] = $settings['flag_log_firephp'];
        }
        if(isset($settings['flag_log_file'])) {
            $flags['log_file'] = $settings['flag_log_file'];
        }

        $flags = $this->debuggingFlagsFromFlagArray($flags);

        $_SESSION['debugging'] = $status;
        $_SESSION['debugging_flags'] = $flags;
    }

    /**
     * Write all settings to the config file
     *
     */
    function writeSettingsFile()
    {
        global $objDatabase,$_CORELANG;

        if (!$this->isWritable()) {
            $this->strOkMessage = '';
            $this->strErrMessage[] = $this->strSettingsFile.' '.$_CORELANG['TXT_SETTINGS_ERROR_WRITABLE'];
            return false;
        }

        //Header & Footer
        $strHeader    = "<?php\n";
        $strHeader .= "/**\n";
        $strHeader .= "* This file is generated by the \"settings\"-menu in your CMS.\n";
        $strHeader .= "* Do not try to edit it manually!\n";
        $strHeader .= "*/\n\n";

        $strFooter = "?>";

        //Get module-names
        $objResult = $objDatabase->Execute('SELECT id,
                                                   name
                                            FROM '.DBPREFIX.'modules');
        if ($objResult->RecordCount() > 0) {
            while (!$objResult->EOF) {
                $arrModules[$objResult->fields['id']] = $objResult->fields['name'];
                $objResult->MoveNext();
            }
        }

        //Get values
        $objResult = $objDatabase->Execute('SELECT setname,
                                                   setmodule,
                                                   setvalue
                                            FROM '.DBPREFIX.'settings
                                            ORDER BY setmodule ASC,
                                                     setname ASC');
        $intMaxLen = 0;
        if ($objResult->RecordCount() > 0) {
            while (!$objResult->EOF) {
                $intMaxLen = (strlen($objResult->fields['setname']) > $intMaxLen) ? strlen($objResult->fields['setname']) : $intMaxLen;
                $arrValues[$objResult->fields['setmodule']][$objResult->fields['setname']] = $objResult->fields['setvalue'];
                $objResult->MoveNext();
            }
        }
        $intMaxLen += strlen('$_CONFIG[\'\']') + 1; //needed for formatted output

        //Write values
        $data = $strHeader;

        $strBody = '';
        foreach ($arrValues as $intModule => $arrInner) {
            $strBody .= "/**\n";
            $strBody .= "* -------------------------------------------------------------------------\n";
            $strBody .= "* ".ucfirst(isset($arrModules[$intModule]) ? $arrModules[$intModule] : '')."\n";
            $strBody .= "* -------------------------------------------------------------------------\n";
            $strBody .= "*/\n";

            foreach($arrInner as $strName => $strValue) {
                $strBody .= sprintf("%-".$intMaxLen."s",'$_CONFIG[\''.$strName.'\']');
                $strBody .= "= ";
                $strBody .= ($this->isANumber($strValue) ? $strValue : '"'.str_replace('"', '\"', $strValue).'"').";\n";
            }
            $strBody .= "\n";
        }

        $data .= $strBody;
        $data .= $strFooter;

        try {
            $objFile = new \Cx\Lib\FileSystem\File($this->strSettingsFile);
            $objFile->write($data);
            return true;
        } catch (\Cx\Lib\FileSystem\FileSystemException $e) {
            DBG::msg($e->getMessage());
        }

        return false;
    }
    
    /**
     * Check whether the given string is a number or not.
     * Integers with leading zero results in 0, this method prevents that.
     * @param string $value The value to check
     * @return bool true if the string is a number, false if not
     */
    protected function isANumber($value) {
        // check whether the integer value has the same length like the entered string
        return is_numeric($value) && strlen(intval($value)) == strlen($value);
    }

    function smtp()
    {
        if (empty($_REQUEST['tpl'])) {
            $_REQUEST['tpl'] = '';
        }

        switch ($_REQUEST['tpl']) {
            case 'modify':
                $this->_smtpModify();
                break;

            case 'delete':
                $this->_smtpDeleteAccount();
                $this->_smtpOverview();
                break;

            case 'default':
                $this->_smtpDefaultAccount();
                $this->_smtpOverview();
                break;

            default:
                $this->_smtpOverview();
        }
    }


    function _smtpDefaultAccount()
    {
        global $objDatabase, $_CORELANG, $_CONFIG;

        $id = intval($_GET['id']);
        $arrSmtp = SmtpSettings::getSmtpAccount($id, false);
        if ($arrSmtp || ($id = 0) !== false) {
            $objResult = $objDatabase->Execute("
                UPDATE `".DBPREFIX."settings`
                   SET `setvalue`='$id'
                 WHERE `setname`='coreSmtpServer'
            ");
            if ($objResult) {
                $_CONFIG['coreSmtpServer'] = $id;
                $objSettings = new settingsManager();
                $objSettings->writeSettingsFile();
                $this->strOkMessage .= sprintf($_CORELANG['TXT_SETTINGS_DEFAULT_SMTP_CHANGED'], htmlentities($arrSmtp['name'], ENT_QUOTES, CONTREXX_CHARSET)).'<br />';
            } else {
                $this->strErrMessage[] = $_CORELANG['TXT_SETTINGS_CHANGE_DEFAULT_SMTP_FAILED'];
            }
        }
    }


    function _smtpDeleteAccount()
    {
        global $objDatabase, $_CONFIG, $_CORELANG;

        $id = intval($_GET['id']);
        $arrSmtp = SmtpSettings::getSmtpAccount($id, false);
        if ($arrSmtp !== false) {
            if ($id != $_CONFIG['coreSmtpServer']) {
                if ($objDatabase->Execute('DELETE FROM `'.DBPREFIX.'settings_smtp` WHERE `id`='.$id) !== false) {
                    $this->strOkMessage .= sprintf($_CORELANG['TXT_SETTINGS_SMTP_DELETE_SUCCEED'], htmlentities($arrSmtp['name'], ENT_QUOTES, CONTREXX_CHARSET)).'<br />';
                } else {
                    $this->strErrMessage[] = sprintf($_CORELANG['TXT_SETTINGS_SMTP_DELETE_FAILED'], htmlentities($arrSmtp['name'], ENT_QUOTES, CONTREXX_CHARSET));
                }
            } else {
                $this->strErrMessage[] = sprintf($_CORELANG['TXT_SETTINGS_COULD_NOT_DELETE_DEAULT_SMTP'], htmlentities($arrSmtp['name'], ENT_QUOTES, CONTREXX_CHARSET));
            }
        }
    }


    function _smtpOverview()
    {
        global $_CORELANG, $objTemplate, $_CONFIG;

        $objTemplate->addBlockfile('ADMIN_CONTENT', 'settings_smtp', 'settings_smtp.html');
        $this->strPageTitle = $_CORELANG['TXT_SETTINGS_EMAIL_ACCOUNTS'];

        $objTemplate->setVariable(array(
            'TXT_SETTINGS_EMAIL_ACCOUNTS'            => $_CORELANG['TXT_SETTINGS_EMAIL_ACCOUNTS'],
            'TXT_SETTINGS_ACCOUNT'                    => $_CORELANG['TXT_SETTINGS_ACCOUNT'],
            'TXT_SETTINGS_HOST'                        => $_CORELANG['TXT_SETTINGS_HOST'],
            'TXT_SETTINGS_USERNAME'                    => $_CORELANG['TXT_SETTINGS_USERNAME'],
            'TXT_SETTINGS_STANDARD'                    => $_CORELANG['TXT_SETTINGS_STANDARD'],
            'TXT_SETTINGS_FUNCTIONS'                => $_CORELANG['TXT_SETTINGS_FUNCTIONS'],
            'TXT_SETTINGS_ADD_NEW_SMTP_ACCOUNT'        => $_CORELANG['TXT_SETTINGS_ADD_NEW_SMTP_ACCOUNT'],
            'TXT_SETTINGS_CONFIRM_DELETE_ACCOUNT'    => $_CORELANG['TXT_SETTINGS_CONFIRM_DELETE_ACCOUNT'],
            'TXT_SETTINGS_OPERATION_IRREVERSIBLE'    => $_CORELANG['TXT_SETTINGS_OPERATION_IRREVERSIBLE']
        ));

        $objTemplate->setGlobalVariable(array(
            'TXT_SETTINGS_MODFIY'                    => $_CORELANG['TXT_SETTINGS_MODFIY'],
            'TXT_SETTINGS_DELETE'                    => $_CORELANG['TXT_SETTINGS_DELETE']
        ));

        $nr = 1;
        foreach (SmtpSettings::getSmtpAccounts() as $id => $arrSmtp) {
            if ($id) {
                $objTemplate->setVariable(array(
                    'SETTINGS_SMTP_ACCOUNT_ID'    => $id,
                    'SETTINGS_SMTP_ACCOUNT_JS'    => htmlentities(addslashes($arrSmtp['name']), ENT_QUOTES, CONTREXX_CHARSET)
                ));
                $objTemplate->parse('settings_smtp_account_functions');
            } else {
                $objTemplate->hideBlock('settings_smtp_account_functions');
            }
            $objTemplate->setVariable(array(
                'SETTINGS_ROW_CLASS_ID'        => $nr++ % 2 + 1,
                'SETTINGS_SMTP_ACCOUNT_ID'    => $id,
                'SETTINGS_SMTP_ACCOUNT'        => htmlentities($arrSmtp['name'], ENT_QUOTES, CONTREXX_CHARSET),
                'SETTINGS_SMTP_HOST'        => !empty($arrSmtp['hostname']) ? htmlentities($arrSmtp['hostname'], ENT_QUOTES, CONTREXX_CHARSET) : '&nbsp;',
                'SETTINGS_SMTP_USERNAME'    => !empty($arrSmtp['username']) ? htmlentities($arrSmtp['username'], ENT_QUOTES, CONTREXX_CHARSET) : '&nbsp;',
                'SETTINGS_SMTP_DEFAULT'        => $id == $_CONFIG['coreSmtpServer'] ? 'checked="checked"' : '',
                'SETTINGS_SMTP_OPTION_DISABLED' => $this->isWritable() ? '' : 'disabled="disabled"'
            ));
            $objTemplate->parse('settings_smtp_accounts');
        }

        $objTemplate->parse('settings_smtp');
    }


    function _smtpModify()
    {
        global $objTemplate, $_CORELANG;

        $error = false;
        $id = !empty($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;

        if (isset($_POST['settings_smtp_save'])) {
            $arrSmtp = array(
                'name'        => !empty($_POST['settings_smtp_account']) ? contrexx_stripslashes(trim($_POST['settings_smtp_account'])) : '',
                'hostname'    => !empty($_POST['settings_smtp_hostname']) ? contrexx_stripslashes(trim($_POST['settings_smtp_hostname'])) : '',
                'port'        => !empty($_POST['settings_smtp_port']) ? intval($_POST['settings_smtp_port']) : 25,
                'username'    => !empty($_POST['settings_smtp_username']) ? contrexx_stripslashes(trim($_POST['settings_smtp_username'])) : '',
                'password'    => !empty($_POST['settings_smtp_password']) ? contrexx_stripslashes($_POST['settings_smtp_password']) : ''
            );

            if (!$arrSmtp['port']) {
                $arrSmtp['port'] = 25;
            }

            if (empty($arrSmtp['name'])) {
                $error = true;
                $this->strErrMessage[] = $_CORELANG['TXT_SETTINGS_EMPTY_ACCOUNT_NAME_TXT'];
            } elseif (!SmtpSettings::_isUniqueSmtpAccountName($arrSmtp['name'], $id)) {
                $error = true;
                $this->strErrMessage[] = sprintf($_CORELANG['TXT_SETTINGS_NOT_UNIQUE_SMTP_ACCOUNT_NAME'], htmlentities($arrSmtp['name']));
            }

            if (empty($arrSmtp['hostname'])) {
                $error = true;
                $this->strErrMessage[] = $_CORELANG['TXT_SETTINGS_EMPTY_SMTP_HOST_TXT'];
            }

            if (!$error) {
                if ($id) {
                    if (SmtpSettings::_updateSmtpAccount($id, $arrSmtp)) {
                        $this->strOkMessage .= sprintf($_CORELANG['TXT_SETTINGS_SMTP_ACCOUNT_UPDATE_SUCCEED'], $arrSmtp['name']).'<br />';
                        return $this->_smtpOverview();
                    } else {
                        $this->strErrMessage[] = sprintf($_CORELANG['TXT_SETTINGS_SMTP_ACCOUNT_UPDATE_FAILED'], $arrSmtp['name']);
                    }
                } else {
                    if (SmtpSettings::_addSmtpAccount($arrSmtp)) {
                        $this->strOkMessage .= sprintf($_CORELANG['TXT_SETTINGS_SMTP_ACCOUNT_ADD_SUCCEED'], $arrSmtp['name']).'<br />';
                        return $this->_smtpOverview();
                    } else {
                        $this->strErrMessage[] = $_CORELANG['TXT_SETTINGS_SMTP_ACCOUNT_ADD_FAILED'];
                    }
                }
            }
        } else {
            $arrSmtp = SmtpSettings::getSmtpAccount($id, false);
            if ($arrSmtp === false) {
                $id = 0;
                $arrSmtp = array(
                    'name'        => '',
                    'hostname'    => '',
                    'port'        => 25,
                    'username'    => '',
                    'password'    => 0
                );
            }
        }

        $objTemplate->addBlockfile('ADMIN_CONTENT', 'settings_smtp_modify', 'settings_smtp_modify.html');
        $this->strPageTitle = $id ? $_CORELANG['TXT_SETTINGS_MODIFY_SMTP_ACCOUNT'] : $_CORELANG['TXT_SETTINGS_ADD_NEW_SMTP_ACCOUNT'];

        $objTemplate->setVariable(array(
            'TXT_SETTINGS_ACCOUNT'                    => $_CORELANG['TXT_SETTINGS_ACCOUNT'],
            'TXT_SETTINGS_NAME_OF_ACCOUNT'            => $_CORELANG['TXT_SETTINGS_NAME_OF_ACCOUNT'],
            'TXT_SETTINGS_SMTP_SERVER'                => $_CORELANG['TXT_SETTINGS_SMTP_SERVER'],
            'TXT_SETTINGS_HOST'                        => $_CORELANG['TXT_SETTINGS_HOST'],
            'TXT_SETTINGS_PORT'                        => $_CORELANG['TXT_SETTINGS_PORT'],
            'TXT_SETTINGS_AUTHENTICATION'            => $_CORELANG['TXT_SETTINGS_AUTHENTICATION'],
            'TXT_SETTINGS_USERNAME'                    => $_CORELANG['TXT_SETTINGS_USERNAME'],
            'TXT_SETTINGS_PASSWORD'                    => $_CORELANG['TXT_SETTINGS_PASSWORD'],
            'TXT_SETTINGS_SMTP_AUTHENTICATION_TXT'    => $_CORELANG['TXT_SETTINGS_SMTP_AUTHENTICATION_TXT'],
            'TXT_SETTINGS_BACK'                        => $_CORELANG['TXT_SETTINGS_BACK'],
            'TXT_SETTINGS_SAVE'                        => $_CORELANG['TXT_SETTINGS_SAVE']
        ));

        $objTemplate->setVariable(array(
            'SETTINGS_SMTP_TITLE'        => $id ? $_CORELANG['TXT_SETTINGS_MODIFY_SMTP_ACCOUNT'] : $_CORELANG['TXT_SETTINGS_ADD_NEW_SMTP_ACCOUNT'],
            'SETTINGS_SMTP_ID'            => $id,
            'SETTINGS_SMTP_ACCOUNT'        => htmlentities($arrSmtp['name'], ENT_QUOTES, CONTREXX_CHARSET),
            'SETTINGS_SMTP_HOST'        => htmlentities($arrSmtp['hostname'], ENT_QUOTES, CONTREXX_CHARSET),
            'SETTINGS_SMTP_PORT'        => $arrSmtp['port'],
            'SETTINGS_SMTP_USERNAME'    => htmlentities($arrSmtp['username'], ENT_QUOTES, CONTREXX_CHARSET),
            'SETTINGS_SMTP_PASSWORD'    => str_pad('', $arrSmtp['password'], ' ')
        ));

        $objTemplate->parse('settings_smtp_modify');
        return true;
    }
    
    /**
     * Shows the image settings page
     * 
     * @access  public
     * @return  boolean  true on success, false otherwise
     */
    public function image($arrData)
    {
        global $objDatabase, $objTemplate, $_CORELANG;
        
        $this->strPageTitle = $_CORELANG['TXT_SETTINGS_IMAGE'];
        $objTemplate->addBlockfile('ADMIN_CONTENT', 'settings_image', 'settings_image.html');
        
        // Saves the settings
        if (isset($arrData['submit'])) {
            $arrSettings['image_cut_width']    = contrexx_input2db(intval($arrData['image_cut_width']));
            $arrSettings['image_cut_height']   = contrexx_input2db(intval($arrData['image_cut_height']));
            //$arrSettings['image_scale_width']  = contrexx_input2db(intval($arrData['image_scale_width']));
            //$arrSettings['image_scale_height'] = contrexx_input2db(intval($arrData['image_scale_height']));
            $arrSettings['image_compression']  = contrexx_input2db(intval($arrData['image_compression']));
            
            foreach ($arrSettings as $name => $value) {
                $query = '
                    UPDATE `'.DBPREFIX.'settings_image`
                    SET `value` = "'.$value.'"
                    WHERE `name` = "'.$name.'"
                ';
                $objResult = $objDatabase->Execute($query);
                if ($objResult === false) {
                    throw new Exception('Could not update the settings');
                }
            }
            
            $this->strOkMessage = $_CORELANG['TXT_SETTINGS_UPDATED'];
        }
        
        // Gets the settings
        $query = '
            SELECT `name`, `value`
            FROM `'.DBPREFIX.'settings_image`
        ';
        $objResult = $objDatabase->Execute($query);
        if ($objResult !== false) {
            $arrSettings = array();
            while (!$objResult->EOF) {
                // Creates the settings array
                $arrSettings[$objResult->fields['name']] = $objResult->fields['value'];
                $objResult->MoveNext();
            }
        } else {
            throw new Exception('Could not query the settings.');
        }
        
        // Defines the compression values
        $arrCompressionOptions = array();
        for ($i = 1; $i <= 20 ; $i++) {
            $arrCompressionOptions[] = $i * 5;
        }
        
        // Parses the compression options
        $imageCompression = !empty($arrSettings['image_compression']) ? intval($arrSettings['image_compression']) : 95;
        foreach ($arrCompressionOptions as $compression) {
            $objTemplate->setVariable(array(
                'IMAGE_COMPRESSION_VALUE' => $compression,
                'IMAGE_COMPRESSION_NAME'  => $compression,
                'OPTION_SELECTED'         => $compression == $imageCompression ? 'selected="selected"' : '',
            ));
            $objTemplate->parse('settings_image_compression_options');
        }
        
        // Parses the settings
        $objTemplate->setVariable(array(
            'TXT_IMAGE_TITLE'                => $_CORELANG['TXT_SETTINGS_IMAGE_TITLE'],
            'TXT_IMAGE_CUT_WIDTH'            => $_CORELANG['TXT_SETTINGS_IMAGE_CUT_WIDTH'],
            'TXT_IMAGE_CUT_HEIGHT'           => $_CORELANG['TXT_SETTINGS_IMAGE_CUT_HEIGHT'],
            //'TXT_IMAGE_SCALE_WIDTH'          => $_CORELANG['TXT_SETTINGS_IMAGE_SCALE_WIDTH'],
            //'TXT_IMAGE_SCALE_HEIGHT'         => $_CORELANG['TXT_SETTINGS_IMAGE_SCALE_HEIGHT'],
            'TXT_IMAGE_COMPRESSION'          => $_CORELANG['TXT_SETTINGS_IMAGE_COMPRESSION'],
            'TXT_SAVE'                       => $_CORELANG['TXT_SAVE'],
            
            'SETTINGS_IMAGE_CUT_WIDTH'       => !empty($arrSettings['image_cut_width'])    ? $arrSettings['image_cut_width']    : 0,
            'SETTINGS_IMAGE_CUT_HEIGHT'      => !empty($arrSettings['image_cut_height'])   ? $arrSettings['image_cut_height']   : 0,
            //'SETTINGS_IMAGE_SCALE_WIDTH'     => !empty($arrSettings['image_scale_width'])  ? $arrSettings['image_scale_width']  : 0,
            //'SETTINGS_IMAGE_SCALE_HEIGHT'    => !empty($arrSettings['image_scale_height']) ? $arrSettings['image_scale_height'] : 0,
        ));
        $objTemplate->parse('settings_image');
        
        return true;
    }
}

?>
