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
 * Installer config
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author        Comvation Development Team <info@comvation.com>
 * @version       1.0.0
 * @package     contrexx
 * @subpackage  core
 * @todo        Edit PHP DocBlocks!
 */

$requiredPHPVersion = "5.3.0";
$requiredMySQLVersion = "5.0";
$requiredGDVersion = "1.6";
$dbType = "mysql";
$defaultLanguage = "de";
$licenseFileCommerce = "data".DIRECTORY_SEPARATOR."contrexx_lizenz_de.txt";
$licenseFileOpenSource = "data".DIRECTORY_SEPARATOR."contrexx_lizenz_opensource_de.txt";
$configFile = "/config/configuration.php";
$configTemplateFile = "data".DIRECTORY_SEPARATOR."configuration.tpl";
$apacheHtaccessFile = "/.htaccess";
$apacheHtaccessTemplateFile = "data".DIRECTORY_SEPARATOR."apache_htaccess.tpl";
$iisHtaccessFile = "/web.config";
$iisHtaccessTemplateFile = "data".DIRECTORY_SEPARATOR."iis_htaccess.tpl";
$versionTemplateFile = "data".DIRECTORY_SEPARATOR."version.tpl";
$sqlDumpFile = DIRECTORY_SEPARATOR."installer".DIRECTORY_SEPARATOR."data".DIRECTORY_SEPARATOR."contrexx_dump";
$dbPrefix = "contrexx_";
$templatePath = "template/contrexx/";
$supportEmail = "support@contrexx.com";
$supportURI = "http://www.contrexx.com/support";
$forumURI = "http://www.contrexx.com/forum/";
$contrexxURI = "http://www.contrexx.com";
$useUtf8 = true;

define('ASCMS_LIBRARY_PATH', realpath(dirname(__FILE__).'/../../lib'));
define('ASCMS_FRAMEWORK_PATH', realpath(dirname(__FILE__).'/../../lib/FRAMEWORK'));
define('ASCMS_CORE_MODULE_PATH', realpath(dirname(__FILE__).'/../../core_modules'));
define('CONTREXX_CHARSET', 'UTF-8');
define('ASCMS_DATE_FORMAT_INTERNATIONAL_DATETIME',  'Y-m-d H:i:s');

if (!empty($_SESSION['installer']['config']['documentRoot'])) {
    define('ASCMS_PATH', $_SESSION['installer']['config']['documentRoot']);
    define('ASCMS_PATH_OFFSET', $_SESSION['installer']['config']['offsetPath']);
    define('ASCMS_INSTANCE_PATH', $_SESSION['installer']['config']['documentRoot']);
    define('ASCMS_INSTANCE_OFFSET', $_SESSION['installer']['config']['offsetPath']);
    define('ASCMS_DOCUMENT_ROOT', ASCMS_PATH.ASCMS_PATH_OFFSET);
}

$arrTimezones = timezone_identifiers_list();
$selectedTimezoneId = (isset($_POST['timezone']) && array_key_exists($_POST['timezone'], $arrTimezones)) ? $_POST['timezone'] : '';
$selectedTimezoneId = (($selectedTimezoneId === '') && (isset($_SESSION['installer']['config']['timezone']) && array_key_exists($_SESSION['installer']['config']['timezone'], $arrTimezones))) ? $_SESSION['installer']['config']['timezone'] : $selectedTimezoneId;
if ($selectedTimezoneId !== '') {
    @ini_set('date.timezone', $arrTimezones[$selectedTimezoneId]);
}

$_CONFIG['coreCmsName']         = 'Contrexx';
$_CONFIG['coreCmsVersion']      = '4.0.0';
$_CONFIG['coreCmsStatus']       = 'Stable';
$_CONFIG['coreCmsEdition']      = 'Minimal';
$_CONFIG['coreCmsCodeName']     = 'Eric S. Raymond';
$_CONFIG['coreCmsReleaseDate']  = '17.12.2014';

$arrDefaultConfig = array(
    'dbHostname'        => 'localhost',
    'dbUsername'        => '',
    'dbPassword'        => '',
    'dbDatabaseName'    => '',
    'dbTablePrefix'     => 'contrexx_',
    'ftpHostname'       => 'localhost',
    'ftpUsername'       => '',
    'ftpPassword'       => '',
);

$arrLanguages = array(
    1 => array(
        'id'            => 1,
        'lang'          => 'de',
        'name'          => 'Deutsch',
        'is_default'    => true,
    ),
    2 => array(
        'id'            => 2,
        'lang'          => 'en',
        'name'          => 'English',
        'is_default'    => false,
    ),
    /*3 => array(
        'id'            => 2,
        'lang'          => 'fr',
        'name'          => 'FranÃ§ais',
        'is_default'    => false,
    )*/
);

$arrFiles = array(
    '/config' => array(),
    '/feed' => array(
        'sub_dirs'  => true,
    ),
    '/images' => array(
        'sub_dirs'  => true,
    ),
    '/media' => array(
        'sub_dirs'  => true,
    ),
    '/themes' => array(
        'sub_dirs'  => true,
    ),
    '/tmp' => array(
        'sub_dirs'  => true,
    ),
);

$arrDatabaseTables = array(
	'access_group_dynamic_ids',
	'access_group_static_ids',
	'access_rel_user_group',
	'access_settings',
	'access_users',
	'access_user_attribute',
	'access_user_attribute_name',
	'access_user_attribute_value',
	'access_user_core_attribute',
	'access_user_groups',
	'access_user_mail',
	'access_user_network',
	'access_user_profile',
	'access_user_title',
	'access_user_validity',
	'module_block_blocks',
	'module_block_categories',
	'module_block_rel_lang_content',
	'module_block_rel_pages',
	'module_block_settings',
	'module_blog_categories',
	'module_blog_comments',
	'module_blog_messages',
	'module_blog_messages_lang',
	'module_blog_message_to_category',
	'module_blog_networks',
	'module_blog_networks_lang',
	'module_blog_settings',
	'module_blog_votes',
	'module_calendar_category',
	'module_calendar_category_name',
	'module_calendar_event',
	'module_calendar_event_field',
	'module_calendar_host',
	'module_calendar_mail',
	'module_calendar_mail_action',
	'module_calendar_registration',
	'module_calendar_registration_form',
	'module_calendar_registration_form_field',
	'module_calendar_registration_form_field_name',
	'module_calendar_registration_form_field_value',
	'module_calendar_rel_event_host',
	'module_calendar_settings',
	'module_calendar_settings_section',
	'module_calendar_style',
	'module_checkout_settings_general',
	'module_checkout_settings_mails',
	'module_checkout_settings_yellowpay',
	'module_checkout_transactions',
	'module_contact_form',
	'module_contact_form_data',
	'module_contact_form_field',
	'module_contact_form_field_lang',
	'module_contact_form_lang',
	'module_contact_form_submit_data',
	'module_contact_recipient',
	'module_contact_recipient_lang',
	'module_contact_settings',
	'backend_areas',
	'backups',
	'component',
	'content_node',
	'content_page',
	'core_country',
	'core_mail_template',
	'core_setting',
	'core_text',
	'ids',
	'languages',
	'lib_country',
	'log',
	'log_entry',
	'modules',
	'module_repository',
	'sessions',
	'session_variable',
	'settings',
	'settings_image',
	'settings_smtp',
	'skins',
	'module_crm_contacts',
	'module_crm_currency',
	'module_crm_customer_comment',
	'module_crm_customer_contact_address',
	'module_crm_customer_contact_emails',
	'module_crm_customer_contact_phone',
	'module_crm_customer_contact_social_network',
	'module_crm_customer_contact_websites',
	'module_crm_customer_documents',
	'module_crm_customer_membership',
	'module_crm_customer_types',
	'module_crm_datasources',
	'module_crm_deals',
	'module_crm_industry_types',
	'module_crm_industry_type_local',
	'module_crm_memberships',
	'module_crm_membership_local',
	'module_crm_notes',
	'module_crm_settings',
	'module_crm_stages',
	'module_crm_success_rate',
	'module_crm_task',
	'module_crm_task_types',
	'module_data_categories',
	'module_data_messages',
	'module_data_messages_lang',
	'module_data_message_to_category',
	'module_data_placeholders',
	'module_data_settings',
	'module_directory_categories',
	'module_directory_dir',
	'module_directory_inputfields',
	'module_directory_levels',
	'module_directory_mail',
	'module_directory_rel_dir_cat',
	'module_directory_rel_dir_level',
	'module_directory_settings',
	'module_directory_settings_google',
	'module_directory_vote',
	'module_docsys',
	'module_docsys_categories',
	'module_docsys_entry_category',
	'module_downloads_category',
	'module_downloads_category_locale',
	'module_downloads_download',
	'module_downloads_download_locale',
	'module_downloads_group',
	'module_downloads_group_locale',
	'module_downloads_rel_download_category',
	'module_downloads_rel_download_download',
	'module_downloads_rel_group_category',
	'module_downloads_settings',
	'module_ecard_ecards',
	'module_ecard_settings',
	'module_egov_configuration',
	'module_egov_orders',
	'module_egov_products',
	'module_egov_product_calendar',
	'module_egov_product_fields',
	'module_egov_settings',
	'module_feed_category',
	'module_feed_news',
	'module_feed_newsml_association',
	'module_feed_newsml_categories',
	'module_feed_newsml_documents',
	'module_feed_newsml_providers',
	'module_filesharing',
	'module_filesharing_mail_template',
	'module_forum_access',
	'module_forum_categories',
	'module_forum_categories_lang',
	'module_forum_notification',
	'module_forum_postings',
	'module_forum_rating',
	'module_forum_settings',
	'module_forum_statistics',
	'module_gallery_categories',
	'module_gallery_comments',
	'module_gallery_language',
	'module_gallery_language_pics',
	'module_gallery_pictures',
	'module_gallery_settings',
	'module_gallery_votes',
	'module_guestbook',
	'module_guestbook_settings',
	'module_jobs',
	'module_jobs_categories',
	'module_jobs_location',
	'module_jobs_rel_loc_jobs',
	'module_jobs_settings',
	'module_knowledge_articles',
	'module_knowledge_article_content',
	'module_knowledge_categories',
	'module_knowledge_categories_content',
	'module_knowledge_settings',
	'module_knowledge_tags',
	'module_knowledge_tags_articles',
	'module_livecam',
	'module_livecam_settings',
	'module_market',
	'module_market_categories',
	'module_market_mail',
	'module_market_paypal',
	'module_market_settings',
	'module_market_spez_fields',
	'module_media_settings',
	'module_mediadir_categories',
	'module_mediadir_categories_names',
	'module_mediadir_comments',
	'module_mediadir_entries',
	'module_mediadir_forms',
	'module_mediadir_form_names',
	'module_mediadir_inputfields',
	'module_mediadir_inputfield_names',
	'module_mediadir_inputfield_types',
	'module_mediadir_inputfield_verifications',
	'module_mediadir_levels',
	'module_mediadir_level_names',
	'module_mediadir_mails',
	'module_mediadir_mail_actions',
	'module_mediadir_masks',
	'module_mediadir_order_rel_forms_selectors',
	'module_mediadir_rel_entry_categories',
	'module_mediadir_rel_entry_inputfields',
	'module_mediadir_rel_entry_levels',
	'module_mediadir_settings',
	'module_mediadir_settings_num_categories',
	'module_mediadir_settings_num_entries',
	'module_mediadir_settings_num_levels',
	'module_mediadir_settings_perm_group_forms',
	'module_mediadir_votes',
	'module_memberdir_directories',
	'module_memberdir_name',
	'module_memberdir_settings',
	'module_memberdir_values',
	'module_newsletter',
	'module_newsletter_access_user',
	'module_newsletter_attachment',
	'module_newsletter_category',
	'module_newsletter_confirm_mail',
	'module_newsletter_email_link',
	'module_newsletter_email_link_feedback',
	'module_newsletter_rel_cat_news',
	'module_newsletter_rel_usergroup_newsletter',
	'module_newsletter_rel_user_cat',
	'module_newsletter_settings',
	'module_newsletter_template',
	'module_newsletter_tmp_sending',
	'module_newsletter_user',
	'module_newsletter_user_title',
	'module_news',
	'module_news_categories',
	'module_news_categories_catid',
	'module_news_categories_locale',
	'module_news_categories_locks',
	'module_news_comments',
	'module_news_locale',
	'module_news_settings',
	'module_news_settings_locale',
	'module_news_stats_view',
	'module_news_teaser_frame',
	'module_news_teaser_frame_templates',
	'module_news_ticker',
	'module_news_types',
	'module_news_types_locale',
	'module_podcast_category',
	'module_podcast_medium',
	'module_podcast_rel_category_lang',
	'module_podcast_rel_medium_category',
	'module_podcast_settings',
	'module_podcast_template',
	'module_recommend',
	'module_shop_article_group',
	'module_shop_attribute',
	'module_shop_categories',
	'module_shop_currencies',
	'module_shop_customer_group',
	'module_shop_discountgroup_count_name',
	'module_shop_discountgroup_count_rate',
	'module_shop_discount_coupon',
	'module_shop_importimg',
	'module_shop_lsv',
	'module_shop_manufacturer',
	'module_shop_option',
	'module_shop_orders',
	'module_shop_order_attributes',
	'module_shop_order_items',
	'module_shop_payment',
	'module_shop_payment_processors',
	'module_shop_pricelists',
	'module_shop_products',
	'module_shop_rel_countries',
	'module_shop_rel_customer_coupon',
	'module_shop_rel_discount_group',
	'module_shop_rel_payment',
	'module_shop_rel_product_attribute',
	'module_shop_rel_shipper',
	'module_shop_shipment_cost',
	'module_shop_shipper',
	'module_shop_vat',
	'module_shop_zones',
	'stats_browser',
	'stats_colourdepth',
	'stats_config',
	'stats_country',
	'stats_hostname',
	'stats_javascript',
	'stats_operatingsystem',
	'stats_referer',
	'stats_requests',
	'stats_requests_summary',
	'stats_screenresolution',
	'stats_search',
	'stats_spiders',
	'stats_spiders_summary',
	'stats_visitors',
	'stats_visitors_summary',
	'module_u2u_address_list',
	'module_u2u_message_log',
	'module_u2u_sent_messages',
	'module_u2u_settings',
	'module_u2u_user_log',
	'voting_additionaldata',
	'voting_email',
	'voting_rel_email_system',
	'voting_results',
	'voting_system'
);
