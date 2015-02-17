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
$_DBCONFIG['host'] = '%DB_HOST%'; // This is normally set to localhost
$_DBCONFIG['database'] = '%DB_NAME%'; // Database name
$_DBCONFIG['tablePrefix'] = '%DB_TABLE_PREFIX%'; // Database table prefix
$_DBCONFIG['user'] = '%DB_USER%'; // Database username
$_DBCONFIG['password'] = '%DB_PASSWORD%'; // Database password
$_DBCONFIG['dbType'] = 'mysql';    // Database type (e.g. mysql,postgres ..)
$_DBCONFIG['charset'] = '%DB_CHARSET%'; // Charset (default, latin1, utf8, ..)
$_DBCONFIG['timezone'] = '%DB_TIMEZONE%'; // Controller's timezone for model
$_DBCONFIG['collation'] = '%DB_COLLATION%';

/**
* -------------------------------------------------------------------------
* Site path specific configuration
* -------------------------------------------------------------------------
*/
$_PATHCONFIG['ascms_root'] = '%PATH_ROOT%';
$_PATHCONFIG['ascms_root_offset'] = '%PATH_ROOT_OFFSET%'; // example: '/cms';
$_PATHCONFIG['ascms_installation_root'] = $_PATHCONFIG['ascms_root'];
$_PATHCONFIG['ascms_installation_offset'] = $_PATHCONFIG['ascms_root_offset']; // example: '/cms';

/**
* -------------------------------------------------------------------------
* Ftp specific configuration
* -------------------------------------------------------------------------
*/
$_FTPCONFIG['is_activated'] = %FTP_STATUS%; // Ftp support true or false
$_FTPCONFIG['host']	= '%FTP_HOST%';// This is normally set to localhost
$_FTPCONFIG['port'] = %FTP_PORT%; // Ftp remote port
$_FTPCONFIG['username'] = '%FTP_USER%'; // Ftp login username
$_FTPCONFIG['password']	= '%FTP_PASSWORD%'; // Ftp login password
$_FTPCONFIG['path']	= '%FTP_PATH%'; // Ftp path to cms (must not include ascms_root_offset)

/**
* -------------------------------------------------------------------------
* Base setup (altering might break the system!)
* -------------------------------------------------------------------------
*/
// Set character encoding
$_CONFIG['coreCharacterEncoding'] = '%CHARSET%'; // example 'UTF-8'
