<?php
global $_DBCONFIG, $_PATHCONFIG, $_FTPCONFIG, $_CONFIG;
/**
* @exclude
*
* Contrexx CMS Web Installer
* Please use the Contrexx CMS installer to configure this file
* or edit this file and configure the parameters for your site and
* database manually.
*/

/**
* -------------------------------------------------------------------------
* Set installation status
* -------------------------------------------------------------------------
*/
define('CONTEXX_INSTALLED', true);

/**
* -------------------------------------------------------------------------
* Database configuration section
* -------------------------------------------------------------------------
*/
$_DBCONFIG['host'] = '@@db_host'; // This is normally set to localhost
$_DBCONFIG['database'] = '@@db_name'; // Database name
$_DBCONFIG['tablePrefix'] = '@@db_prefix'; // Database table prefix
$_DBCONFIG['user'] = '@@db_user'; // Database username
$_DBCONFIG['password'] = '@@db_password'; // Database password
$_DBCONFIG['dbType'] = 'mysql';    // Database type (e.g. mysql,postgres ..)
$_DBCONFIG['charset'] = 'utf8'; // Charset (default, latin1, utf8, ..)
$_DBCONFIG['timezone'] = 'Europe/Zurich'; // Controller's timezone for model
$_DBCONFIG['collation'] = 'utf8_unicode_ci';

/**
* -------------------------------------------------------------------------
* Site path specific configuration
* -------------------------------------------------------------------------
*/
$_PATHCONFIG['ascms_root'] = '@@ascms_root';
$_PATHCONFIG['ascms_root_offset'] = '@@ascms_root_offset'; // example: '/cms';
$_PATHCONFIG['ascms_installation_root'] = $_PATHCONFIG['ascms_root'];
$_PATHCONFIG['ascms_installation_offset'] = $_PATHCONFIG['ascms_root_offset']; // example: '/cms';

/**
* -------------------------------------------------------------------------
* Ftp specific configuration
* -------------------------------------------------------------------------
*/
$_FTPCONFIG['is_activated'] = @@ftp_is_activated; // Ftp support true or false
$_FTPCONFIG['host'] = '@@ftp_host';// This is normally set to localhost
$_FTPCONFIG['port'] = @@ftp_port; // Ftp remote port
$_FTPCONFIG['username'] = '@@ftp_username'; // Ftp login username
$_FTPCONFIG['password'] = '@@ftp_password'; // Ftp login password
$_FTPCONFIG['path'] = '@@ftp_path'; // Ftp path to cms (must not include ascms_root_offset)

/**
* -------------------------------------------------------------------------
* Base setup (altering might break the system!)
* -------------------------------------------------------------------------
*/
// Set character encoding
$_CONFIG['coreCharacterEncoding'] = 'UTF-8'; // example 'UTF-8'
