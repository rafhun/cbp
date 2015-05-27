-- MySQL dump 10.13  Distrib 5.6.24, for osx10.10 (x86_64)
--
-- Host: localhost    Database: christen_ortho
-- ------------------------------------------------------
-- Server version	5.6.24

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `contrexx_access_group_dynamic_ids`
--

DROP TABLE IF EXISTS `contrexx_access_group_dynamic_ids`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_access_group_dynamic_ids` (
  `access_id` int(11) unsigned NOT NULL DEFAULT '0',
  `group_id` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`access_id`,`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_access_group_dynamic_ids`
--

LOCK TABLES `contrexx_access_group_dynamic_ids` WRITE;
/*!40000 ALTER TABLE `contrexx_access_group_dynamic_ids` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_access_group_dynamic_ids` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_access_group_static_ids`
--

DROP TABLE IF EXISTS `contrexx_access_group_static_ids`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_access_group_static_ids` (
  `access_id` int(11) unsigned NOT NULL DEFAULT '0',
  `group_id` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`access_id`,`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_access_group_static_ids`
--

LOCK TABLES `contrexx_access_group_static_ids` WRITE;
/*!40000 ALTER TABLE `contrexx_access_group_static_ids` DISABLE KEYS */;
INSERT INTO `contrexx_access_group_static_ids` VALUES (1,1),(1,2),(1,8),(1,9),(2,1),(2,2),(2,8),(3,1),(3,2),(3,8),(4,1),(4,2),(4,8),(5,1),(5,2),(5,8),(5,9),(6,1),(6,2),(6,8),(6,9),(7,1),(7,2),(7,8),(7,9),(8,8),(8,9),(9,1),(9,2),(9,8),(10,1),(10,2),(10,8),(10,9),(11,1),(11,2),(11,8),(12,1),(12,2),(12,8),(13,1),(13,2),(13,8),(14,1),(14,2),(14,8),(16,1),(16,2),(16,8),(16,9),(17,1),(17,8),(18,1),(18,2),(18,8),(19,1),(20,1),(20,8),(21,1),(21,2),(21,8),(22,1),(22,2),(22,8),(23,1),(23,8),(24,1),(24,8),(25,1),(26,1),(26,2),(26,8),(27,1),(27,2),(27,8),(31,1),(31,8),(32,1),(32,2),(32,8),(32,9),(35,1),(35,2),(35,8),(35,9),(36,1),(36,2),(36,8),(38,1),(38,8),(38,9),(39,1),(39,8),(39,9),(40,1),(41,1),(41,8),(46,1),(46,8),(47,1),(47,8),(48,1),(48,8),(49,1),(49,8),(50,1),(51,1),(51,8),(52,1),(52,8),(53,1),(53,2),(53,8),(54,1),(55,1),(55,8),(56,1),(59,1),(59,8),(60,1),(61,3),(64,1),(64,2),(64,8),(65,1),(65,2),(65,8),(66,1),(66,2),(66,8),(67,1),(67,8),(68,1),(68,8),(69,1),(69,8),(70,1),(70,2),(70,8),(75,1),(75,2),(75,8),(76,1),(76,2),(76,8),(76,9),(77,1),(77,2),(77,8),(78,1),(78,2),(78,8),(82,1),(82,2),(82,8),(83,1),(83,2),(83,8),(84,1),(84,2),(84,8),(84,9),(85,1),(85,8),(87,1),(87,2),(87,8),(88,1),(88,8),(92,1),(92,8),(94,1),(94,8),(96,1),(96,3),(96,8),(97,1),(97,8),(98,1),(98,2),(98,8),(99,3),(102,8),(106,1),(106,2),(106,8),(107,1),(107,2),(107,8),(108,1),(108,2),(108,8),(109,1),(109,2),(109,8),(110,1),(115,1),(115,2),(115,8),(119,1),(119,2),(119,8),(119,9),(120,1),(120,2),(120,8),(120,9),(121,1),(121,2),(121,8),(121,9),(122,1),(122,2),(122,8),(123,1),(123,2),(123,8),(124,1),(124,2),(124,8),(125,1),(125,2),(125,8),(127,1),(127,2),(127,8),(127,9),(129,2),(129,8),(130,1),(130,2),(130,8),(131,1),(131,2),(131,8),(132,1),(132,2),(132,8),(133,1),(133,2),(133,8),(134,1),(134,2),(134,8),(140,8),(141,2),(141,8),(141,9),(142,2),(142,8),(142,9),(146,8),(147,8),(148,2),(148,8),(149,8),(151,8),(152,2),(152,8),(153,2),(153,8),(154,8),(155,8),(156,8),(157,8),(158,8),(159,8),(160,1),(160,2),(160,8),(160,9),(161,2),(161,8),(162,2),(162,8),(162,9),(163,2),(163,8),(163,9),(164,2),(164,8),(164,9),(165,8),(165,9),(166,2),(166,8),(166,9),(167,2),(167,8),(167,9),(168,2),(168,8),(168,9),(169,2),(169,8),(169,9),(170,8),(170,9),(171,2),(171,8),(172,2),(172,8),(174,2),(174,8),(175,2),(175,8),(176,8),(177,8),(178,1),(178,2),(178,8),(178,9),(180,8),(180,9),(181,8),(181,9),(182,8),(182,9),(556,6),(556,8),(557,8);
/*!40000 ALTER TABLE `contrexx_access_group_static_ids` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_access_rel_user_group`
--

DROP TABLE IF EXISTS `contrexx_access_rel_user_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_access_rel_user_group` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `group_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_access_rel_user_group`
--

LOCK TABLES `contrexx_access_rel_user_group` WRITE;
/*!40000 ALTER TABLE `contrexx_access_rel_user_group` DISABLE KEYS */;
INSERT INTO `contrexx_access_rel_user_group` VALUES (1,8);
/*!40000 ALTER TABLE `contrexx_access_rel_user_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_access_settings`
--

DROP TABLE IF EXISTS `contrexx_access_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_access_settings` (
  `key` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_access_settings`
--

LOCK TABLES `contrexx_access_settings` WRITE;
/*!40000 ALTER TABLE `contrexx_access_settings` DISABLE KEYS */;
INSERT INTO `contrexx_access_settings` VALUES ('assigne_to_groups','3',1),('block_birthday_users','10',0),('block_birthday_users_only_with_p','',0),('block_birthday_users_pic','',0),('block_currently_online_users','10',0),('block_currently_online_users_onl','',0),('block_currently_online_users_pic','',0),('block_last_active_users','10',0),('block_last_active_users_only_wit','',0),('block_last_active_users_pic','',0),('block_latest_reg_users','5',1),('block_latest_reg_users_pic','',0),('block_latest_registered_users','10',0),('block_latest_registered_users_on','',0),('default_email_access','members_only',1),('default_profile_access','members_only',1),('max_pic_height','600',1),('max_pic_size','199987.2',1),('max_pic_width','600',1),('max_profile_pic_height','160',1),('max_profile_pic_size','30003.2',1),('max_profile_pic_width','160',1),('max_thumbnail_pic_height','130',1),('max_thumbnail_pic_width','130',1),('notification_address','webmaster@werbelinie.ch',1),('profile_thumbnail_method','crop',1),('profile_thumbnail_pic_height','60',1),('profile_thumbnail_pic_width','80',1),('profile_thumbnail_scale_color','#FFFFFF',1),('session_user_interval','0',1),('sociallogin','',0),('sociallogin_activation_timeout','10',0),('sociallogin_active_automatically','',1),('sociallogin_assign_to_groups','3',0),('sociallogin_show_signup','',0),('use_usernames','0',0),('user_accept_tos_on_signup','',1),('user_activation','',0),('user_activation_timeout','1',0),('user_captcha','',1),('user_config_email_access','',1),('user_config_profile_access','',1),('user_delete_account','',1);
/*!40000 ALTER TABLE `contrexx_access_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_access_user_attribute`
--

DROP TABLE IF EXISTS `contrexx_access_user_attribute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_access_user_attribute` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `type` enum('text','textarea','mail','uri','date','image','checkbox','menu','menu_option','group','frame','history') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'text',
  `mandatory` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `sort_type` enum('asc','desc','custom') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'asc',
  `order_id` int(10) unsigned NOT NULL DEFAULT '0',
  `access_special` enum('','menu_select_higher','menu_select_lower') COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `access_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_access_user_attribute`
--

LOCK TABLES `contrexx_access_user_attribute` WRITE;
/*!40000 ALTER TABLE `contrexx_access_user_attribute` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_access_user_attribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_access_user_attribute_name`
--

DROP TABLE IF EXISTS `contrexx_access_user_attribute_name`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_access_user_attribute_name` (
  `attribute_id` int(10) unsigned NOT NULL DEFAULT '0',
  `lang_id` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`attribute_id`,`lang_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_access_user_attribute_name`
--

LOCK TABLES `contrexx_access_user_attribute_name` WRITE;
/*!40000 ALTER TABLE `contrexx_access_user_attribute_name` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_access_user_attribute_name` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_access_user_attribute_value`
--

DROP TABLE IF EXISTS `contrexx_access_user_attribute_value`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_access_user_attribute_value` (
  `attribute_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `history_id` int(10) unsigned NOT NULL DEFAULT '0',
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`attribute_id`,`user_id`,`history_id`),
  FULLTEXT KEY `value` (`value`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_access_user_attribute_value`
--

LOCK TABLES `contrexx_access_user_attribute_value` WRITE;
/*!40000 ALTER TABLE `contrexx_access_user_attribute_value` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_access_user_attribute_value` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_access_user_core_attribute`
--

DROP TABLE IF EXISTS `contrexx_access_user_core_attribute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_access_user_core_attribute` (
  `id` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `mandatory` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `sort_type` enum('asc','desc','custom') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'asc',
  `order_id` int(10) unsigned NOT NULL DEFAULT '0',
  `access_special` enum('','menu_select_higher','menu_select_lower') COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `access_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_access_user_core_attribute`
--

LOCK TABLES `contrexx_access_user_core_attribute` WRITE;
/*!40000 ALTER TABLE `contrexx_access_user_core_attribute` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_access_user_core_attribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_access_user_groups`
--

DROP TABLE IF EXISTS `contrexx_access_user_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_access_user_groups` (
  `group_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `group_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `group_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `type` enum('frontend','backend') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'frontend',
  `homepage` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_access_user_groups`
--

LOCK TABLES `contrexx_access_user_groups` WRITE;
/*!40000 ALTER TABLE `contrexx_access_user_groups` DISABLE KEYS */;
INSERT INTO `contrexx_access_user_groups` VALUES (8,'Manager','Administrator',1,'backend',''),(3,'Community','Community',1,'frontend',''),(9,'Moderator','Inhaltspflege und Statistiken',1,'backend',''),(6,'Customer','Customer im Shop',1,'frontend',''),(7,'Reseller','Reseller im Shop',1,'frontend','');
/*!40000 ALTER TABLE `contrexx_access_user_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_access_user_mail`
--

DROP TABLE IF EXISTS `contrexx_access_user_mail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_access_user_mail` (
  `type` enum('reg_confirm','reset_pw','user_activated','user_deactivated','new_user') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'reg_confirm',
  `lang_id` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `sender_mail` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sender_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `format` enum('text','html','multipart') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'text',
  `body_text` text COLLATE utf8_unicode_ci NOT NULL,
  `body_html` text COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `mail` (`type`,`lang_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_access_user_mail`
--

LOCK TABLES `contrexx_access_user_mail` WRITE;
/*!40000 ALTER TABLE `contrexx_access_user_mail` DISABLE KEYS */;
INSERT INTO `contrexx_access_user_mail` VALUES ('reg_confirm',0,'webmaster@werbelinie.ch','admin','Benutzerregistrierung bestätigen','text','Hallo [[USERNAME]],\r\n\r\nVielen Dank für Ihre Anmeldung bei [[HOST]].\r\nBitte klicken Sie auf den folgenden Link, um Ihre E-Mail-Adresse zu bestätigen:\r\n[[ACTIVATION_LINK]]\r\n\r\nUm sich später einzuloggen, geben Sie bitte Ihren Benutzernamen \"[[USERNAME]]\" und das Passwort ein, das Sie bei der Registrierung festgelegt haben.\r\n\r\n\r\n--\r\nIhr [[SENDER]]',''),('reset_pw',0,'webmaster@werbelinie.ch','admin','Contrexx Kennwort zurücksetzen','text','Hallo [[USERNAME]],\r\n\r\nUm ein neues Passwort zu wählen, müssen Sie auf die unten aufgeführte URL gehen und dort Ihr neues Passwort eingeben.\r\n\r\nWICHTIG: Die Gültigkeit der URL wird nach 60 Minuten verfallen, nachdem diese E-Mail abgeschickt wurde.\r\nFalls Sie mehr Zeit benötigen, geben Sie Ihre E-Mail Adresse einfach ein weiteres Mal ein.\r\n\r\nIhre URL:\r\n[[URL]]\r\n\r\n\r\n--\r\n[[SENDER]]',''),('user_activated',0,'webmaster@werbelinie.ch','admin','Ihr Benutzerkonto wurde aktiviert','text','Hallo [[USERNAME]],\r\n\r\nIhr Benutzerkonto auf [[HOST]] wurde soeben aktiviert und kann von nun an verwendet werden.\r\n\r\n\r\n--\r\n[[SENDER]]',''),('user_deactivated',0,'webmaster@werbelinie.ch','admin','Ihr Benutzerkonto wurde deaktiviert','text','Hallo [[USERNAME]],\r\n\r\nIhr Benutzerkonto auf [[HOST]] wurde soeben deaktiviert.\r\n\r\n\r\n--\r\n[[SENDER]]',''),('new_user',0,'webmaster@werbelinie.ch','admin','Ein neuer Benutzer hat sich registriert','text','Der Benutzer [[USERNAME]] hat sich soeben registriert und muss nun frei geschaltet werden.\r\n\r\nÜber die folgende Adresse kann das Benutzerkonto von [[USERNAME]] verwaltet werden:\r\n[[LINK]]\r\n\r\n\r\n--\r\n[[SENDER]]','');
/*!40000 ALTER TABLE `contrexx_access_user_mail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_access_user_network`
--

DROP TABLE IF EXISTS `contrexx_access_user_network`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_access_user_network` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `oauth_provider` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `oauth_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_access_user_network`
--

LOCK TABLES `contrexx_access_user_network` WRITE;
/*!40000 ALTER TABLE `contrexx_access_user_network` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_access_user_network` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_access_user_profile`
--

DROP TABLE IF EXISTS `contrexx_access_user_profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_access_user_profile` (
  `user_id` int(5) unsigned NOT NULL DEFAULT '0',
  `gender` enum('gender_undefined','gender_female','gender_male') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'gender_undefined',
  `title` int(10) unsigned NOT NULL DEFAULT '0',
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `company` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `city` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `zip` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `country` smallint(5) unsigned NOT NULL DEFAULT '0',
  `phone_office` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `phone_private` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `phone_mobile` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `phone_fax` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `birthday` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `profession` varchar(150) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `interests` text COLLATE utf8_unicode_ci,
  `signature` text COLLATE utf8_unicode_ci,
  `picture` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`user_id`),
  KEY `profile` (`firstname`(100),`lastname`(100),`company`(50))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_access_user_profile`
--

LOCK TABLES `contrexx_access_user_profile` WRITE;
/*!40000 ALTER TABLE `contrexx_access_user_profile` DISABLE KEYS */;
INSERT INTO `contrexx_access_user_profile` VALUES (1,'gender_undefined',0,'rafhun','','','','','',0,'','','','','','','','','','');
/*!40000 ALTER TABLE `contrexx_access_user_profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_access_user_title`
--

DROP TABLE IF EXISTS `contrexx_access_user_title`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_access_user_title` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `order_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_access_user_title`
--

LOCK TABLES `contrexx_access_user_title` WRITE;
/*!40000 ALTER TABLE `contrexx_access_user_title` DISABLE KEYS */;
INSERT INTO `contrexx_access_user_title` VALUES (1,'Sehr geehrte Frau',0),(2,'Sehr geehrter Herr',0),(3,'Dear Ms',0),(4,'Dear Mr',0),(5,'Madame',0),(6,'Monsieur',0);
/*!40000 ALTER TABLE `contrexx_access_user_title` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_access_user_validity`
--

DROP TABLE IF EXISTS `contrexx_access_user_validity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_access_user_validity` (
  `validity` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`validity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_access_user_validity`
--

LOCK TABLES `contrexx_access_user_validity` WRITE;
/*!40000 ALTER TABLE `contrexx_access_user_validity` DISABLE KEYS */;
INSERT INTO `contrexx_access_user_validity` VALUES (0),(1),(15),(31),(62),(92),(123),(184),(366),(731);
/*!40000 ALTER TABLE `contrexx_access_user_validity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_access_users`
--

DROP TABLE IF EXISTS `contrexx_access_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_access_users` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `is_admin` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `regdate` int(14) unsigned NOT NULL DEFAULT '0',
  `expiration` int(14) unsigned NOT NULL DEFAULT '0',
  `validity` int(10) unsigned NOT NULL DEFAULT '0',
  `last_auth` int(14) unsigned NOT NULL DEFAULT '0',
  `last_auth_status` int(1) NOT NULL DEFAULT '1',
  `last_activity` int(14) unsigned NOT NULL DEFAULT '0',
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_access` enum('everyone','members_only','nobody') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'nobody',
  `frontend_lang_id` int(2) unsigned NOT NULL DEFAULT '0',
  `backend_lang_id` int(2) unsigned NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `primary_group` int(6) unsigned NOT NULL DEFAULT '0',
  `profile_access` enum('everyone','members_only','nobody') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'members_only',
  `restore_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `restore_key_time` int(14) unsigned NOT NULL DEFAULT '0',
  `u2u_active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_access_users`
--

LOCK TABLES `contrexx_access_users` WRITE;
/*!40000 ALTER TABLE `contrexx_access_users` DISABLE KEYS */;
INSERT INTO `contrexx_access_users` VALUES (1,1,'webmaster@werbelinie.ch','25392d787fd3c21c8906189d157165f1',1424165945,0,0,1430384588,1,1430396156,'webmaster@werbelinie.ch','nobody',1,1,1,0,'members_only','',0,'0');
/*!40000 ALTER TABLE `contrexx_access_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_backend_areas`
--

DROP TABLE IF EXISTS `contrexx_backend_areas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_backend_areas` (
  `area_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `parent_area_id` int(6) unsigned NOT NULL DEFAULT '0',
  `type` enum('group','function','navigation') COLLATE utf8_unicode_ci DEFAULT 'navigation',
  `scope` enum('global','frontend','backend') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'global',
  `area_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `uri` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `target` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '_self',
  `module_id` int(6) unsigned NOT NULL DEFAULT '0',
  `order_id` int(6) unsigned NOT NULL DEFAULT '0',
  `access_id` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`area_id`),
  KEY `area_name` (`area_name`)
) ENGINE=MyISAM AUTO_INCREMENT=210 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_backend_areas`
--

LOCK TABLES `contrexx_backend_areas` WRITE;
/*!40000 ALTER TABLE `contrexx_backend_areas` DISABLE KEYS */;
INSERT INTO `contrexx_backend_areas` VALUES (1,0,'group','backend','TXT_CONTENT_MANAGEMENT',1,'','_self',0,2,1),(2,0,'group','backend','TXT_MODULE',1,'','_self',0,8,2),(3,0,'group','backend','TXT_ADMINISTRATION',1,'','_self',0,11,3),(203,0,'group','backend','TXT_NEWS_MANAGER',1,'','_self',4,3,178),(8,0,'group','backend','TXT_CORE_ECOMMERCE',1,'','_self',0,5,4),(15,0,'group','backend','TXT_CORE_MEDIA',1,'','_self',0,4,162),(28,0,'group','backend','TXT_CORE_STATS',1,'','_self',0,9,163),(29,0,'group','backend','TXT_CORE_EMAIL_MARKETING',1,'','_self',0,7,152),(188,0,'function','backend','Nettools',1,'index.php?cmd=nettools','_self',32,0,0),(177,0,'function','global','Json Adapter',1,'index.php?cmd=jsondata','_self',63,0,0),(178,0,'function','global','File Browser',1,'index.php?cmd=fileBrowser','_self',26,0,0),(189,0,'group','backend','TXT_CRM_MODULE_DESCRIPTION',1,'','_self',0,6,556),(180,0,'function','global','TXT_SEARCH',1,'index.php?cmd=search','_self',5,0,0),(181,0,'function','global','TXT_UPLOAD',1,'index.php?cmd=upload','_self',52,0,0),(183,0,'function','global','TXT_LOGOUT',1,'index.php?cmd=logout','_self',67,0,0),(184,0,'group','backend','TXT_HOME',1,'','_self',1,1,0),(5,1,'navigation','backend','TXT_NEW_PAGE',1,'index.php?cmd=content&amp;act=new','_self',1,1,5),(6,1,'navigation','backend','TXT_CONTENT_MANAGER',1,'index.php?cmd=content','_self',1,2,6),(75,1,'navigation','backend','TXT_CONTENT_HISTORY',1,'index.php?cmd=workflow','_self',1,3,75),(76,1,'navigation','backend','TXT_BLOCK_SYSTEM',1,'index.php?cmd=block','_self',7,6,76),(90,1,'navigation','backend','TXT_CONTACTS',1,'index.php?cmd=contact','_self',6,4,84),(9,2,'navigation','backend','TXT_GUESTBOOK',1,'index.php?cmd=guestbook','_self',10,0,9),(11,2,'navigation','backend','TXT_DOC_SYS_MANAGER',1,'index.php?cmd=docsys','_self',19,0,11),(12,2,'navigation','backend','TXT_THUMBNAIL_GALLERY',1,'index.php?cmd=gallery','_self',3,0,12),(14,2,'navigation','backend','TXT_VOTING',1,'index.php?cmd=voting','_self',17,0,14),(16,2,'navigation','backend','TXT_CALENDAR',1,'index.php?cmd=calendar','_self',21,0,16),(27,2,'navigation','backend','TXT_NEWS_SYNDICATION',1,'index.php?cmd=feed','_self',22,0,27),(59,2,'navigation','backend','TXT_LINKS_MODULE_DESCRIPTION',1,'index.php?cmd=directory','_self',12,0,59),(64,2,'navigation','backend','TXT_RECOMMEND',1,'index.php?cmd=recommend','_self',27,0,64),(82,2,'navigation','backend','TXT_LIVECAM',1,'index.php?cmd=livecam','_self',30,0,82),(89,2,'navigation','backend','TXT_MEMBERDIR',1,'index.php?cmd=memberdir','_self',31,0,83),(93,2,'navigation','backend','TXT_PODCAST',1,'index.php?cmd=podcast','_self',35,0,87),(98,2,'navigation','backend','TXT_MARKET_MODULE_DESCRIPTION',1,'index.php?cmd=market','_self',33,0,98),(106,2,'navigation','backend','TXT_FORUM',1,'index.php?cmd=forum','_self',20,0,106),(109,2,'navigation','backend','TXT_EGOVERNMENT',1,'index.php?cmd=egov','_self',38,0,109),(128,2,'navigation','backend','TXT_DATA_MODULE',1,'index.php?cmd=data','_self',48,0,146),(130,2,'navigation','backend','TXT_ECARD',1,'index.php?cmd=ecard','_self',49,0,151),(134,2,'navigation','backend','TXT_U2U_MODULE',1,'index.php?cmd=u2u','_self',54,0,149),(135,2,'navigation','backend','TXT_KNOWLEDGE',1,'index.php?cmd=knowledge','_self',56,0,129),(141,2,'navigation','backend','TXT_JOBS_MODULE',1,'index.php?cmd=jobs','_self',57,0,148),(153,2,'navigation','global','TXT_MEDIADIR_MODULE',1,'index.php?cmd=mediadir','_self',60,0,153),(163,3,'navigation','backend','TXT_SYSTEM_LOGS',1,'index.php?cmd=log','_self',1,10,55),(17,3,'navigation','backend','TXT_SYSTEM_SETTINGS',1,'index.php?cmd=settings','_self',1,1,17),(18,3,'navigation','backend','TXT_USER_ADMINISTRATION',1,'index.php?cmd=access','_self',1,3,18),(20,3,'navigation','backend','TXT_DATABASE_MANAGER',1,'index.php?cmd=dbm','_self',1,8,20),(21,3,'navigation','backend','TXT_DESIGN_MANAGEMENT',1,'index.php?cmd=skins','_self',1,4,21),(22,3,'navigation','backend','TXT_LANGUAGE_SETTINGS',1,'index.php?cmd=language','_self',64,5,22),(23,3,'navigation','backend','TXT_MODULE_MANAGER',1,'index.php?cmd=modulemanager','_self',1,6,23),(24,3,'navigation','backend','TXT_SERVER_INFO',1,'index.php?cmd=server','_self',1,9,24),(110,3,'navigation','backend','TXT_ALIAS_ADMINISTRATION',1,'index.php?cmd=alias','_self',41,7,115),(182,3,'navigation','backend','TXT_LICENSE',0,'index.php?cmd=license','_self',66,2,177),(127,5,'function','backend','TXT_NEW_PAGE_ON_FIRST_LEVEL',1,'','_self',1,1,127),(26,6,'function','backend','TXT_DELETE_PAGES',1,'','_self',0,0,26),(35,6,'function','backend','TXT_EDIT_PAGES',1,'','_self',0,0,35),(36,6,'function','backend','TXT_ACCESS_CONTROL',1,'','_self',0,0,36),(53,6,'function','backend','TXT_COPY_DELETE_SITES',1,'','_self',0,0,53),(161,6,'function','backend','TXT_MOVE_NODE',1,'index.php?cmd=content','_self',1,8,160),(38,7,'function','backend','TXT_MODIFY_MEDIA_FILES',1,'','_self',0,0,38),(39,7,'function','backend','TXT_UPLOAD_MEDIA_FILES',1,'','_self',0,0,39),(13,8,'navigation','backend','TXT_SHOP',1,'index.php?cmd=shop','_self',16,1,13),(162,8,'navigation','backend','TXT_CHECKOUT_MODULE',1,'index.php?cmd=checkout','_self',62,2,161),(152,10,'function','frontend','TXT_SUBMIT_NEWS',1,'','_self',8,0,61),(65,12,'function','backend','TXT_GALLERY_MENU_OVERVIEW',1,'','_self',3,1,65),(66,12,'function','backend','TXT_GALLERY_MENU_NEW_CATEGORY',1,'','_self',3,2,66),(67,12,'function','backend','TXT_GALLERY_MENU_UPLOAD',1,'','_self',3,3,67),(68,12,'function','backend','TXT_GALLERY_MENU_IMPORT',1,'','_self',3,4,68),(69,12,'function','backend','TXT_GALLERY_MENU_VALIDATE',1,'','_self',3,5,69),(70,12,'function','backend','TXT_GALLERY_MENU_SETTINGS',1,'','_self',3,6,70),(7,15,'navigation','backend','TXT_MEDIA_MANAGER',1,'index.php?cmd=media&amp;archive=archive1','_self',1,2,7),(32,15,'navigation','backend','TXT_IMAGE_ADMINISTRATION',1,'index.php?cmd=media&amp;archive=content','_self',1,1,32),(132,15,'navigation','backend','TXT_DOWNLOADS',1,'index.php?cmd=downloads','_self',53,4,141),(187,15,'navigation','backend','TXT_FILESHARING_MODULE',1,'index.php?cmd=media&amp;archive=filesharing','_self',68,3,8),(144,16,'function','frontend','TXT_ACCESS_COMMUNITY_EVENTS',1,'','_self',21,0,145),(199,16,'function','backend','TXT_CALENDAR_ADMINEVENTS',1,'','_self',21,1,180),(200,16,'function','backend','TXT_CALENDAR_ADMINCATEGORIES',1,'','_self',21,2,165),(201,16,'function','backend','TXT_CALENDAR_SETTINGS',1,'','_self',21,4,181),(202,16,'function','backend','TXT_CALENDAR_ADMINREGISTRATIONS',1,'','_self',21,3,182),(31,18,'function','backend','TXT_EDIT_USERINFOS',1,'','_self',0,0,31),(40,19,'function','backend','TXT_SETTINGS',1,'','_self',0,0,40),(41,20,'function','backend','TXT_DBM_MAINTENANCE_TITLE',1,'','_self',0,0,41),(46,21,'function','backend','TXT_ACTIVATE_SKINS',1,'','_self',0,0,46),(47,21,'function','backend','TXT_EDIT_SKINS',1,'','_self',0,0,47),(92,21,'function','backend','TXT_THEME_IMPORT_EXPORT',1,'','_self',0,0,102),(48,22,'function','backend','TXT_EDIT_LANGUAGE_SETTINGS',1,'','_self',0,0,48),(49,22,'function','backend','TXT_DELETE_LANGUAGES',1,'','_self',0,0,49),(50,22,'function','backend','TXT_LANGUAGE_SETTINGS',1,'','_self',0,0,50),(51,23,'function','backend','TXT_REGISTER_MODULES',1,'','_self',0,0,51),(52,23,'function','backend','TXT_INST_REMO_MODULES',1,'','_self',0,0,52),(166,28,'navigation','backend','TXT_CORE_VISITOR_DETAILS',1,'index.php?cmd=stats&amp;stat=visitors','_self',1,1,166),(164,28,'navigation','backend','TXT_CORE_VISITORS_AND_PAGE_VIEWS',1,'index.php?cmd=stats&amp;stat=requests','_self',1,2,164),(167,28,'navigation','backend','TXT_CORE_REFERER',1,'index.php?cmd=stats&amp;stat=referer','_self',1,3,167),(168,28,'navigation','backend','TXT_CORE_SEARCH_ENGINES',1,'index.php?cmd=stats&amp;stat=spiders','_self',1,4,168),(169,28,'navigation','backend','TXT_CORE_SEARCH_TERMS',1,'index.php?cmd=stats&amp;stat=search','_self',1,5,169),(170,28,'navigation','backend','TXT_STATS_SETTINGS',1,'index.php?cmd=stats&amp;stat=settings','_self',1,6,170),(172,29,'navigation','backend','TXT_CORE_LISTS',1,'index.php?cmd=newsletter&amp;act=lists','_self',4,2,172),(171,29,'navigation','backend','TXT_CORE_EMAIL_CAMPAIGNS',1,'index.php?cmd=newsletter&amp;act=mails','_self',4,1,171),(174,29,'navigation','backend','TXT_CORE_RECIPIENTS',1,'index.php?cmd=newsletter&amp;act=users','_self',4,4,174),(175,29,'navigation','backend','TXT_CORE_NEWS',1,'index.php?cmd=newsletter&amp;act=news','_self',4,5,175),(176,29,'navigation','backend','TXT_NEWSLETTER_SETTINGS',1,'index.php?cmd=newsletter&amp;act=dispatch','_self',4,6,176),(145,59,'function','global','TXT_ADD_FILES',1,'','_self',12,0,96),(146,59,'function','global','TXT_MANAGE_FILES',1,'','_self',12,1,94),(147,59,'function','backend','TXT_MANAGE_CONFIGURATION',1,'','_self',12,2,92),(148,59,'function','backend','TXT_CATEGORY_AND_LEVEL_MANAGEMENT',1,'','_self',12,3,97),(77,75,'function','backend','TXT_DELETED_RESTORE',1,'','_self',0,1,77),(78,75,'function','backend','TXT_WORKFLOW_VALIDATE',1,'','_self',0,1,78),(91,90,'function','backend','TXT_CONTACT_SETTINGS',1,'','_self',6,0,85),(149,98,'function','frontend','TXT_ADD_ADVERTISEMENT',1,'','_self',33,0,99),(150,98,'function','frontend','TXT_MODIFY_ADVERTISEMENT',1,'','_self',33,1,100),(151,98,'function','frontend','TXT_DELETE_ADVERTISEMENT',1,'','_self',33,2,101),(107,106,'function','backend','TXT_FORUM_MENU_CATEGORIES',1,'','_self',20,1,107),(108,106,'function','backend','TXT_FORUM_MENU_SETTINGS',1,'','_self',20,2,108),(120,119,'function','backend','TXT_BLOG_ENTRY_MANAGE_TITLE',1,'index.php?cmd=blog&act=manageEntry','_self',47,1,120),(121,119,'function','backend','TXT_BLOG_ENTRY_ADD_TITLE',1,'index.php?cmd=blog&act=addEntry','_self',47,2,121),(122,119,'function','backend','TXT_BLOG_CATEGORY_MANAGE_TITLE',1,'index.php?cmd=blog&act=manageCategory','_self',47,3,122),(123,119,'function','backend','TXT_BLOG_CATEGORY_ADD_TITLE',1,'index.php?cmd=blog&act=addCategory','_self',47,4,123),(124,119,'function','backend','TXT_BLOG_SETTINGS_TITLE',1,'index.php?cmd=blog&act=settings','_self',47,6,124),(125,119,'function','backend','TXT_BLOG_NETWORKS_TITLE',1,'index.php?cmd=blog&act=networks','_self',47,5,125),(129,128,'function','backend','TXT_DATA_ENTRY_MANAGE_TITLE',1,'index.php?cmd=data&act=manageEntry','_self',48,1,147),(133,132,'function','backend','TXT_DOWNLOADS_ADMINISTER',1,'','_self',53,1,142),(209,132,'function','backend','TXT_DOWNLOADS_ALL_DOWNLOADS',1,'','_self',53,2,143),(136,135,'function','backend','TXT_KNOWLEDGE_ACCESS_OVERVIEW',1,'index.php?cmd=knowledge&section=articles','_self',56,1,130),(137,135,'function','backend','TXT_KNOWLEDGE_ACCESS_EDIT_ARTICLES',1,'','_self',56,2,131),(138,135,'function','backend','TXT_KNOWLEDGE_ACCESS_CATEGORIES',1,'','_self',56,3,132),(139,135,'function','backend','TXT_KNOWLEDGE_ACCESS_EDIT_CATEGORIES',1,'','_self',56,4,133),(140,135,'function','backend','TXT_KNOWLEDGE_ACCESS_SETTINGS',1,'','_self',56,5,134),(154,153,'function','global','TXT_MEDIADIR_ADD_ENTRY',1,'','_self',60,0,154),(155,153,'function','global','TXT_MEDIADIR_MODIFY_ENTRY',1,'','_self',60,0,155),(156,153,'function','global','TXT_MEDIADIR_MANAGE_LEVELS',1,'','_self',60,0,156),(157,153,'function','global','TXT_MEDIADIR_MANAGE_CATEGORIES',1,'','_self',60,0,157),(158,153,'function','global','TXT_MEDIADIR_INTERFACES',1,'','_self',60,0,158),(160,153,'function','global','TXT_MEDIADIR_SETTINGS',1,'','_self',60,0,159),(185,184,'navigation','backend','TXT_DASHBOARD',1,'index.php','_self',1,1,0),(186,184,'navigation','backend','TXT_FRONTEND',1,'../index.php','_blank',1,2,0),(191,189,'navigation','backend','TXT_CRM_CUSTOMERS',1,'index.php?cmd=crm&amp;act=customers','_self',69,1,556),(192,189,'navigation','backend','TXT_CRM_TASKS',1,'index.php?cmd=crm&amp;act=task','_self',69,3,0),(193,189,'navigation','backend','TXT_CRM_OPPORTUNITY',1,'index.php?cmd=crm&amp;act=deals','_self',69,4,0),(195,189,'navigation','backend','TXT_CRM_SETTINGS',1,'index.php?cmd=crm&amp;act=settings','_self',69,6,557),(208,189,'navigation','backend','TXT_USER_ADMINISTRATION',1,'index.php?cmd=access','_self',69,7,18),(10,203,'navigation','backend','TXT_CORE_MODULE_NEWS_MANAGER',1,'index.php?cmd=news','_self',8,1,10),(119,203,'navigation','backend','TXT_BLOG_MODULE',1,'index.php?cmd=blog','_self',47,2,119);
/*!40000 ALTER TABLE `contrexx_backend_areas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_backups`
--

DROP TABLE IF EXISTS `contrexx_backups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_backups` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `date` varchar(14) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `version` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `edition` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `type` enum('sql','csv') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'sql',
  `description` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `usedtables` text COLLATE utf8_unicode_ci NOT NULL,
  `size` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `date` (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_backups`
--

LOCK TABLES `contrexx_backups` WRITE;
/*!40000 ALTER TABLE `contrexx_backups` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_backups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_component`
--

DROP TABLE IF EXISTS `contrexx_component`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_component` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('core','core_module','module') COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_component`
--

LOCK TABLES `contrexx_component` WRITE;
/*!40000 ALTER TABLE `contrexx_component` DISABLE KEYS */;
INSERT INTO `contrexx_component` VALUES (70,'Workbench','core_module'),(71,'FrontendEditing','core_module'),(72,'ContentManager','core');
/*!40000 ALTER TABLE `contrexx_component` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_content_node`
--

DROP TABLE IF EXISTS `contrexx_content_node`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_content_node` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `lvl` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E5A18FDD727ACA70` (`parent_id`),
  CONSTRAINT `contrexx_content_node_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `contrexx_content_node` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_content_node`
--

LOCK TABLES `contrexx_content_node` WRITE;
/*!40000 ALTER TABLE `contrexx_content_node` DISABLE KEYS */;
INSERT INTO `contrexx_content_node` VALUES (1,NULL,1,94,0),(2,1,2,3,1),(3,1,4,35,1),(4,3,5,6,2),(5,3,7,8,2),(6,3,9,16,2),(7,6,10,11,3),(8,6,12,13,3),(9,6,14,15,3),(10,3,17,18,2),(11,3,19,20,2),(12,3,21,22,2),(13,3,23,24,2),(14,3,25,26,2),(15,3,27,28,2),(16,3,29,30,2),(17,1,36,37,1),(18,1,38,53,1),(19,1,54,63,1),(20,1,64,73,1),(21,1,74,81,1),(22,1,82,83,1),(23,19,55,56,2),(24,19,59,60,2),(25,19,57,58,2),(26,19,61,62,2),(27,18,39,40,2),(28,18,41,42,2),(29,18,43,44,2),(30,18,45,46,2),(31,18,47,48,2),(32,18,49,52,2),(33,20,65,66,2),(34,20,67,68,2),(35,20,69,70,2),(36,20,71,72,2),(37,21,75,76,2),(38,21,77,78,2),(39,21,79,80,2),(40,1,84,93,1),(41,40,85,86,2),(42,40,87,88,2),(43,40,89,90,2),(44,32,50,51,3),(45,40,91,92,2),(46,3,31,32,2),(47,3,33,34,2);
/*!40000 ALTER TABLE `contrexx_content_node` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_content_page`
--

DROP TABLE IF EXISTS `contrexx_content_page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_content_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `node_id` int(11) DEFAULT NULL,
  `nodeIdShadowed` int(11) DEFAULT NULL,
  `lang` int(11) NOT NULL,
  `type` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `caching` tinyint(1) NOT NULL,
  `updatedAt` timestamp NULL DEFAULT NULL,
  `updatedBy` char(40) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `linkTarget` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contentTitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `sourceMode` tinyint(1) NOT NULL DEFAULT '0',
  `customContent` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `useCustomContentForAllChannels` int(2) DEFAULT NULL,
  `cssName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cssNavName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `skin` int(11) DEFAULT NULL,
  `useSkinForAllChannels` int(2) DEFAULT NULL,
  `metatitle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `metadesc` text COLLATE utf8_unicode_ci NOT NULL,
  `metakeys` text COLLATE utf8_unicode_ci NOT NULL,
  `metarobots` varchar(7) COLLATE utf8_unicode_ci DEFAULT NULL,
  `start` timestamp NULL DEFAULT NULL,
  `end` timestamp NULL DEFAULT NULL,
  `editingStatus` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `protection` int(11) NOT NULL,
  `frontendAccessId` int(11) NOT NULL,
  `backendAccessId` int(11) NOT NULL,
  `display` tinyint(1) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `target` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `module` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cmd` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `node_id` (`node_id`,`lang`),
  KEY `IDX_D8E86F54460D9FD7` (`node_id`),
  CONSTRAINT `contrexx_content_page_ibfk_1` FOREIGN KEY (`node_id`) REFERENCES `contrexx_content_node` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_content_page`
--

LOCK TABLES `contrexx_content_page` WRITE;
/*!40000 ALTER TABLE `contrexx_content_page` DISABLE KEYS */;
INSERT INTO `contrexx_content_page` VALUES (1,2,2,1,'application',1,'2015-04-21 14:57:16','webmaster@werbelinie.ch','Willkommen','','Herzlich willkommen bei christenortho!','Willkommen','<p style=\"text-align: justify;\"><img alt=\"\" class=\"alignleft\" height=\"216\" src=\"/images/home/Christen.jpg\" width=\"364\" />Herzlich willkommen auf meiner Webseite! Hier erhalten Sie einen umfassenden Einblick in Diagnose und Therapie auf dem Fachgebiet der Orthop&auml;die und Traumatologie am Bewegungsapparat sowie meine eigenen Angeboten auf diesem Gebiet.<br />\r\n<br />\r\nSie finden nach den antomischen Regionen Knie, H&uuml;fte und Schulter geordnete Angaben, welche als Erg&auml;nzung oder Vorbereitung zu einem Gespr&auml;ch in der Praxis oder auch als Informationen oder Entscheidungshilfe vor einer geplanten Operation dienen k&ouml;nnen.<br />\r\n<br />\r\nSelbstverst&auml;ndlich ersetzt die Homepage nicht das pers&ouml;nliche Gespr&auml;ch und die Untersuchung, welche eine auf Sie abgestimmte spezifische L&ouml;sung zum Ziel hat. Alle gemeinsam beschlossenen Massnahmen sollen Ihre Lebensqualit&auml;t wieder verbessern, indem wenn m&ouml;glich die Schmerzen behoben, die Funktion und Belastbarkeit des gesch&auml;digten Gelenks verbessert werden; ganz getreu unserem Praxismoto: &quot;Beweglichkeit ist unser Rezept&quot;.<br />\r\n<br />\r\nIch hoffe, dass Sie die Homepage weiterbringt und freue mich &uuml;ber Fragen und Anregungen.<br />\r\nIhr Bernhard Christen<br />\r\n&nbsp;</p>\r\n',0,'',0,'home','',0,0,'Herzlich willkommen bei christenortho!','Herzlich willkommen bei christenortho!','Herzlich willkommen bei christenortho!','1',NULL,NULL,'',0,0,0,0,1,'','home',''),(2,2,2,2,'application',0,'2014-12-17 00:00:00','system','Welcome','','Welcome and congratulations','Willkommen','Congratulations! You successfully installed Contrexx&reg;.<br />\r\nThank you very much for choosing <a href=\"http://www.contrexx.com\" target=\"_blank\">Contrexx&reg;</a> for your web project.<br />\r\n',0,'',NULL,'','',0,NULL,'Willkommen bei der erfolgreichen Installation von Contrexx®','Willkommen bei der erfolgreichen Installation von Contrexx®','Willkommen bei der erfolgreichen Installation von Contrexx®','index',NULL,NULL,'',0,0,0,1,1,'','home',''),(3,3,3,1,'content',0,'2014-12-17 00:00:00','system','System','','System','System','<br />\r\n',0,'',NULL,'','',0,NULL,'System','System','System','',NULL,NULL,'',0,0,0,0,1,'','',''),(4,4,4,1,'application',0,'2014-12-17 00:00:00','system','Alert System','','Alert System','Alert-System','<p>Ihre Eingabe wurde vom <strong>Contrexx&reg; Angriffserkennungs System</strong> als unzul&auml;ssig erkannt. <br />\r\n<br />\r\nEinige besondere Zeichenfolgen werden vom Intrusion Detection System gefiltert und vom Intrusion Response System blockiert. Wenn Sie finden, dass diese Meldung unrechterweise erscheint, nehmen Sie doch bitte mit uns <a href=\"mailto:support%20AT%20comvation%20DOT%20com\">Kontakt</a> auf.<br />\r\n<br />\r\n<em><strong>Aktive Arbitrary Input Module:</strong></em></p>\r\n<ul>\r\n    <li>SQL Injection</li>\r\n    <li>Cross-Site Scripting</li>\r\n    <li>Session Hijacking</li>\r\n</ul>',0,'',NULL,'','',0,NULL,'Alert System','Alert System','Alert System','index',NULL,NULL,'',0,0,0,0,1,'','ids',''),(5,4,4,2,'fallback',0,'2014-12-17 00:00:00','system','Alert System','','Alert System','Alert-System','<p>Your data has been detected as possibly malicious by the&nbsp; <strong>Contrexx&reg; Intrusion Detection System</strong>.<br />\r\nSome special character strings are being filtered by our Intrusion Detection System. If you think this message is shown in error, please <a href=\"mailto:support%20AT%20comvation%20DOT%20com\">contact us</a>.<br />\r\n<br />\r\n<span style=\"font-style: italic;\"><span style=\"font-weight: bold;\">Active </span></span><em><strong>Arbitrary Input Module:</strong></em></p>\r\n<ul>\r\n    <li>SQL Injection</li>\r\n    <li>Cross-Site Scripting</li>\r\n    <li>Session Hijacking</li>\r\n</ul>',0,'',NULL,'','',0,NULL,'Alert System','Alert System','Alert System','index',NULL,NULL,'',0,0,0,0,1,'','ids',''),(6,5,5,1,'application',0,'2014-12-17 00:00:00','system','Seite nicht gefunden','','Seite nicht gefunden','Seite-nicht-gefunden','<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td scope=\"col\">\r\n				<h2>\r\n					<strong>Das gew&uuml;nschte Dokument existiert nicht an dieser Stelle oder ist deaktiviert</strong></h2>\r\n				<div align=\"left\">\r\n					<!-- {ERROR_NUMBER} {ERROR_MESSAGE}<br /> --><a href=\"{NODE_HOME}\">Startseite / Homepage</a><br />\r\n					<a href=\"{NODE_SEARCH}\">Suche / Search</a><br />\r\n					<br />\r\n					Das von Ihnen gesuchte Dokument wurde m&ouml;glicherweise umbenannt, verschoben, wurde f&uuml;r diese Sprache noch nicht erstellt oder gel&ouml;scht. Es existieren mehrere M&ouml;glichkeiten, um ein Dokument zu finden. Sie k&ouml;nnen auf die Homepage zur&uuml;ckkehren, das Dokument mit Stichworten suchen oder unsere Help Site konsultieren. Um von der letztbesuchten Seite aus weiterzufahren, klicken Sie bitte auf die Schaltfl&auml;che &#39;<a href=\"javascript:history.back()\">Zur&uuml;ck</a>&#39; Ihres Browsers.<br />\r\n					<br />\r\n					The document you requested does not exist at this location.<br />\r\n					The document you are looking for may have been renamed, moved or deleted. There are several ways to locate a document. You can return to the Homepage, search for the document using keywords or consult our Help Site. To continue on from the last page you visited, please press the &#39;<a href=\"javascript:history.back()\">Back</a>&#39; button of your browser.</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n',0,'',NULL,'','',0,NULL,'Seite nicht gefunden','Seite nicht gefunden','Seite nicht gefunden','',NULL,NULL,'',0,0,0,0,1,'','error',''),(7,5,5,2,'fallback',0,'2014-12-17 00:00:00','system','Seite nicht gefunden','','Seite nicht gefunden','Seite-nicht-gefunden','<section class=\"error-page\">\r\n	<h2>\r\n		The requested document does not exist, or it was deactivated.</h2>\r\n	<h1>\r\n		{ERROR_NUMBER}.</h1>\r\n	<p>\r\n		{ERROR_MESSAGE}</p>\r\n	<p>\r\n		The document you are looking for may have been renamed, moved or deleted. There are several ways to locate a document. You can return to the Homepage, search for the document using keywords or consult our Help Site. To continue on from the last page you visited, please press the &#39;Back&#39; button of your browser.</p>\r\n</section>\r\n',0,'',NULL,'','',0,NULL,'Seite nicht gefunden','Seite nicht gefunden','Seite nicht gefunden','',NULL,NULL,'',0,0,0,0,1,'','error',''),(8,6,6,1,'application',0,'2014-12-17 00:00:00','system','Login','','Login','Login','<div id=\"login\">\r\n    <form method=\"post\" action=\"index.php?section=login\" name=\"loginForm\">\r\n        <input type=\"hidden\" value=\"{LOGIN_REDIRECT}\" name=\"redirect\" />\r\n        <p><label for=\"USERNAME\">{TXT_USER_NAME}</label><input id=\"USERNAME\" name=\"USERNAME\" value=\"\" type=\"text\"></p>\r\n        <p><label for=\"PASSWORD\">{TXT_PASSWORD}</label><input id=\"PASSWORD\" name=\"PASSWORD\" value=\"\" type=\"password\"></p>\r\n        <!-- BEGIN captcha -->\r\n        <p><label for=\"coreCaptchaCode\">{TXT_CORE_CAPTCHA}</label>{CAPTCHA_CODE}</p>\r\n        <!-- END captcha -->\r\n        <p>\r\n            <input type=\"submit\" name=\"login\" value=\"{TXT_LOGIN}\" />\r\n            <input type=\"checkbox\" value=\"1\" name=\"remember_me\" class=\"remember_me\" id=\"remember_me\" />\r\n            <label for=\"remember_me\" class=\"remember_me\">{TXT_LOGIN_REMEMBER_ME}</label>\r\n        </p>\r\n        <a title=\"Jetzt kostenlos registrieren\" href=\"index.php?section=access&amp;cmd=signup\" class=\"register\">Haben Sie noch keinen Account? Jetzt registrieren</a><br />\r\n        <a title=\"{TXT_LOST_PASSWORD}\" href=\"index.php?section=login&amp;cmd=lostpw\" class=\"lostpw\">{TXT_PASSWORD_LOST}</a><br />\r\n        <br />\r\n        <p style=\"color: #ff0000;\">{LOGIN_STATUS_MESSAGE}</p>\r\n    </form>\r\n    <!-- BEGIN login_social_networks -->\r\n    <div id=\"sociallogin\">\r\n        <span>ODER</span>\r\n        <!-- BEGIN login_social_networks_facebook -->\r\n        <a class=\"facebook loginbutton\" href=\"{LOGIN_SOCIALLOGIN_FACEBOOK}\">Facebook</a>\r\n        <!-- END login_social_networks_facebook -->\r\n        <!-- BEGIN login_social_networks_google -->\r\n        <a class=\"google loginbutton\" href=\"{LOGIN_SOCIALLOGIN_GOOGLE}\">Google</a>\r\n        <!-- END login_social_networks_google -->\r\n        <!-- BEGIN login_social_networks_twitter -->\r\n        <a class=\"twitter loginbutton\" href=\"{LOGIN_SOCIALLOGIN_TWITTER}\">Twitter</a>\r\n        <!-- END login_social_networks_twitter -->\r\n    </div>\r\n    <!-- END login_social_networks -->\r\n</div>',1,'',NULL,'login','',0,NULL,'Login','Login','Login','index',NULL,NULL,'',0,0,0,0,1,'','login',''),(9,7,7,1,'application',0,'2014-12-17 00:00:00','system','Passwort vergessen?','','Passwort vergessen?','Passwort-vergessen','<div id=\"login\">\r\n    <form method=\"post\" action=\"index.php?section=login&amp;cmd=lostpw\">\r\n        <!-- BEGIN login_lost_password -->\r\n        <p><label for=\"email\">{TXT_EMAIL}</label><input id=\"email\" name=\"email\" value=\"\" type=\"text\"></p>\r\n        <p>{TXT_LOST_PASSWORD_TEXT}</p>\r\n        <p><input type=\"submit\" name=\"restore_pw\" value=\"{TXT_RESET_PASSWORD}\" /></p>\r\n        <!-- END login_lost_password -->\r\n        <br />\r\n        <p style=\"color: #ff0000;\">{LOGIN_STATUS_MESSAGE}</p>\r\n    </form>\r\n</div>\r\n',1,'',NULL,'','',0,NULL,'Passwort vergessen?','Passwort vergessen?','Passwort vergessen?','index',NULL,NULL,'',0,0,0,0,1,'','login','lostpw'),(10,7,7,2,'fallback',0,'2014-12-17 00:00:00','system','Passwort vergessen?','','Passwort vergessen?','Passwort-vergessen','<div id=\"login\">\r\n    <form method=\"post\" action=\"index.php?section=login&amp;cmd=lostpw\">\r\n        <!-- BEGIN login_lost_password -->\r\n        <p><label for=\"email\">{TXT_EMAIL}</label><input id=\"email\" name=\"email\" value=\"\" type=\"text\"></p>\r\n        <p>{TXT_LOST_PASSWORD_TEXT}</p>\r\n        <p><input type=\"submit\" name=\"restore_pw\" value=\"{TXT_RESET_PASSWORD}\" /></p>\r\n        <!-- END login_lost_password -->\r\n        <br />\r\n        <p style=\"color: #ff0000;\">{LOGIN_STATUS_MESSAGE}</p>\r\n    </form>\r\n</div>\r\n',1,'',NULL,'','',0,NULL,'Passwort vergessen?','Passwort vergessen?','Passwort vergessen?','index',NULL,NULL,'',0,0,0,0,1,'','login','lostpw'),(11,8,8,1,'application',0,'2014-12-17 00:00:00','system','Neues Passwort setzen','','Neues Passwort setzen','Neues-Passwort-setzen','<div id=\"login\">\r\n    <form method=\"post\" action=\"index.php?section=login&amp;cmd=resetpw\">\r\n        <input type=\"hidden\" name=\"restore_key\" value=\"{LOGIN_RESTORE_KEY}\" /> \r\n        <input type=\"hidden\" name=\"email\" value=\"{LOGIN_EMAIL}\" />\r\n        <!-- BEGIN login_reset_password -->\r\n        <p><label>{TXT_EMAIL}</label>{LOGIN_EMAIL}</p>\r\n        <p><label for=\"password\">{TXT_PASSWORD}&nbsp;{TXT_PASSWORD_MINIMAL_CHARACTERS}</label><input type=\"password\" maxlength=\"50\"  name=\"password\" /></p>\r\n        <p>{TXT_SET_PASSWORD_TEXT}</p>\r\n        <p><label for=\"password2\">{TXT_VERIFY_PASSWORD}</label><input type=\"password\" maxlength=\"50\" name=\"password2\" /></p>\r\n        <p><input type=\"submit\" value=\"{TXT_SET_NEW_PASSWORD}\" name=\"reset_password\" /></p>\r\n        <!-- END login_reset_password -->\r\n        <br />\r\n        <p style=\"color: #ff0000;\">{LOGIN_STATUS_MESSAGE}</p>   \r\n    </form>\r\n</div>',1,'',NULL,'','',0,NULL,'Neues Passwort setzen','Neues Passwort setzen','Neues Passwort setzen','index',NULL,NULL,'',0,0,0,0,1,'','login','resetpw'),(12,8,8,2,'fallback',0,'2014-12-17 00:00:00','system','Neues Passwort setzen','','Neues Passwort setzen','Neues-Passwort-setzen','<div id=\"login\">\r\n    <form method=\"post\" action=\"index.php?section=login&amp;cmd=resetpw\">\r\n        <input type=\"hidden\" name=\"restore_key\" value=\"{LOGIN_RESTORE_KEY}\" /> \r\n        <input type=\"hidden\" name=\"username\" value=\"{LOGIN_USERNAME}\" />\r\n        <!-- BEGIN login_reset_password -->\r\n        <p><label>{TXT_USERNAME}</label>{LOGIN_USERNAME}</p>\r\n        <p><label for=\"password\">{TXT_PASSWORD}&nbsp;{TXT_PASSWORD_MINIMAL_CHARACTERS}</label><input type=\"password\" maxlength=\"50\"  name=\"password\" /></p>\r\n        <p>{TXT_SET_PASSWORD_TEXT}</p>\r\n        <p><label for=\"password2\">{TXT_VERIFY_PASSWORD}</label><input type=\"password\" maxlength=\"50\" name=\"password2\" /></p>\r\n        <p><input type=\"submit\" value=\"{TXT_SET_NEW_PASSWORD}\" name=\"reset_password\" /></p>\r\n        <!-- END login_reset_password -->\r\n        <br />\r\n        <p style=\"color: #ff0000;\">{LOGIN_STATUS_MESSAGE}</p>   \r\n    </form>\r\n</div>',1,'',NULL,'','',0,NULL,'Neues Passwort setzen','Neues Passwort setzen','Neues Passwort setzen','index',NULL,NULL,'',0,0,0,0,1,'','login','resetpw'),(13,9,9,1,'application',0,'2014-12-17 00:00:00','system','Zugriff verweigert','','Zugriff verweigert','Zugriff-verweigert','<img width=\"100\" height=\"100\" alt=\"\" src=\"images/modules/login/stop_hand.gif\" /><br />\r\n{TXT_NOT_ALLOWED_TO_ACCESS}<br />\r\nKlicken Sie <a href=\"index.php?section=login&amp;redirect={LOGIN_REDIRECT}&amp;relogin=true\" title=\"neu anmelden\">hier</a> um sich mit einem anderen Benutzerkonto anzumelden.',0,'',NULL,'','',0,NULL,'Zugriff verweigert','Zugriff verweigert','Zugriff verweigert','index',NULL,NULL,'',0,0,0,0,1,'','login','noaccess'),(14,9,9,2,'fallback',0,'2014-12-17 00:00:00','system','Zugriff verweigert','','Zugriff verweigert','Zugriff-verweigert','<img width=\"100\" height=\"100\" src=\"images/modules/login/stop_hand.gif\" alt=\"\" /><br />\r\n{TXT_NOT_ALLOWED_TO_ACCESS}<br />\r\nClick <a title=\"relogin\" href=\"index.php?section=login&amp;redirect={LOGIN_REDIRECT}&amp;relogin=true\">here</a> to relogin using an other account.',0,'',NULL,'','',0,NULL,'Zugriff verweigert','Zugriff verweigert','Zugriff verweigert','index',NULL,NULL,'',0,0,0,0,1,'','login','noaccess'),(15,6,6,2,'fallback',0,'2014-12-17 00:00:00','system','Login','','Login','Login','<div id=\"login\">\r\n    <form method=\"post\" action=\"index.php?section=login\" name=\"loginForm\">\r\n        <input type=\"hidden\" value=\"{LOGIN_REDIRECT}\" name=\"redirect\" />\r\n        <p><label for=\"USERNAME\">{TXT_USER_NAME}</label><input id=\"USERNAME\" name=\"USERNAME\" value=\"\" type=\"text\"></p>\r\n        <p><label for=\"PASSWORD\">{TXT_PASSWORD}</label><input id=\"PASSWORD\" name=\"PASSWORD\" value=\"\" type=\"password\"></p>\r\n        <!-- BEGIN captcha -->\r\n        <p><label for=\"coreCaptchaCode\">{TXT_CORE_CAPTCHA}</label>{CAPTCHA_CODE}</p>\r\n        <!-- END captcha -->\r\n        <p><input type=\"submit\" name=\"login\" value=\"{TXT_LOGIN}\" /></p>\r\n        <br />\r\n        <p><a title=\"Sign up for free now\" href=\"index.php?section=access&amp;cmd=signup\" class=\"register\">Not yet a member? Sign up now</a></p>\r\n        <p><a title=\"{TXT_LOST_PASSWORD}\" href=\"index.php?section=login&amp;cmd=lostpw\" class=\"lostpw\">{TXT_PASSWORD_LOST}</a></p>\r\n        <br />\r\n        <p style=\"color: #ff0000;\">{LOGIN_STATUS_MESSAGE}</p>\r\n    </form>\r\n</div>',1,'',NULL,'login','',0,NULL,'Login','Login','Login','index',NULL,NULL,'',0,0,0,0,1,'','login',''),(16,10,10,1,'application',1,'2015-04-13 10:01:45','webmaster@werbelinie.ch','Sitemap','','Sitemap','Sitemap','<div id=\"sitemap\">\r\n<ul>\r\n	<!-- BEGIN sitemap -->\r\n	<li class=\"{STYLE}\"><a href=\"{URL}\" title=\"{NAME}\" target=\"{TARGET}\">{NAME}</a></li>\r\n	<!-- END sitemap -->\r\n</ul>\r\n</div>',1,'',0,'','',0,0,'Sitemap','Sitemap','Sitemap','index',NULL,NULL,'',0,0,0,0,1,'','sitemap',''),(17,10,10,2,'fallback',0,'2014-12-17 00:00:00','system','Sitemap','','Sitemap','Sitemap','<div id=\"sitemap\">\r\n<ul>\r\n	<!-- BEGIN sitemap -->\r\n	<li class=\"{STYLE}\"><a title=\"{NAME}\" href=\"{URL}\">{NAME}</a></li>\r\n	<!-- END sitemap -->\r\n</ul>\r\n</div>',1,'',NULL,'','',0,NULL,'Sitemap','Sitemap','Sitemap','index',NULL,NULL,'',0,0,0,0,1,'','sitemap',''),(18,11,11,1,'application',1,'2015-04-13 10:21:34','webmaster@werbelinie.ch','Disclaimer','','Disclaimer','Disclaimer','<h2>Inhalt des Onlineangebotes.</h2>\r\n\r\n<p>CHRISTENORTHO AG &uuml;bernimmt keinerlei Gew&auml;hr f&uuml;r die Aktualit&auml;t, Korrektheit, Vollst&auml;ndigkeit oder Qualit&auml;t der bereitgestellten Informationen. Die CHRISTENORTHO AG beh&auml;lt es sich ausdr&uuml;cklich vor, Teile der Seiten oder das gesamte Angebot ohne gesonderte Ank&uuml;ndigung zu ver&auml;ndern, zu erg&auml;nzen, zu l&ouml;schen oder die Ver&ouml;ffentlichung zeitweise oder endg&uuml;ltig einzustellen.</p>\r\n\r\n<h2>Links zu anderen Websites.</h2>\r\n\r\n<p>Durch Benutzung bestimmter Links auf der Website ist es Ihnen m&ouml;glich, auf die Websites von Drittpersonen zu gelangen. Die CHRISTENORTHO AG hat keinen Einfluss auf den Inhalt oder die Sicherheit dieser Websites und &uuml;bernimmt auch keine Verantwortung f&uuml;r dieselben. Sollten wider Erwarten rechts- oder sittenwidrige Inhalte &uuml;ber Links abrufbar sein, bittet die CHRISTENORTHO AG um Mitteilung.</p>\r\n\r\n<h2>Urheber- und Kennzeichenrechte.</h2>\r\n\r\n<p>Der Inhalt dieser Internetseiten ist urheberrechtlich gesch&uuml;tzt. Grafiken, Texte, Logos, Bilder usw. d&uuml;rfen nur nach schriftlicher Genehmigung durch die CHRISTENORTHO AG vervielf&auml;ltigt, kopiert, ge&auml;ndert, ver&ouml;ffentlicht, versendet, &uuml;bertragen oder in sonstiger Form f&uuml;r eigene Zwecke oder die Zwecke Dritter genutzt werden. Bei allenfalls genannten Produkt- und Firmennamen kann es sich um eingetragene Warenzeichen oder Marken handeln. Die unberechtigte Verwendung kann zu Schadensersatz- und Unterlassungsanspr&uuml;chen f&uuml;hren.</p>\r\n\r\n<h2>Datenschutz.</h2>\r\n\r\n<p>Sofern innerhalb des Internetangebotes die M&ouml;glichkeit zur Eingabe pers&ouml;nlicher oder gesch&auml;ftlicher Daten (Emailadressen, Namen, Anschriften, etc.) besteht, so erfolgt die Preisgabe dieser Daten seitens des Nutzers auf ausdr&uuml;cklich freiwilliger Basis. Wenn Sie sich entschliessen, der CHRISTENORTHO AG pers&ouml;nliche Daten &uuml;ber das Internet zu &uuml;berlassen, damit z.B. Korrespondenz abgewickelt oder eine Bestellung ausgef&uuml;hrt werden kann, so wird mit diesen Daten sorgf&auml;ltig und nach den strengen Regelungen des Bundesgesetz &uuml;ber den Datenschutz umgegangen.</p>\r\n\r\n<p>Die Nutzung durch Dritte der im Rahmen des Impressums oder vergleichbarer Angaben ver&ouml;ffentlichten Kontaktdaten der CHRISTENORTHO AG oder von Dritten wie Postanschriften, Telefon- und Faxnummern sowie Emailadressen zur &Uuml;bersendung von nicht ausdr&uuml;cklich angeforderten Informationen ist nicht gestattet. Rechtliche Schritte gegen die Versender von so genannten Spam-Mails bei Verst&ouml;ssen gegen dieses Verbot werden ausdr&uuml;cklich vorbehalten.</p>\r\n\r\n<h2>Haftungsausschluss.</h2>\r\n\r\n<p>Haftungsanspr&uuml;che gegen die CHRISTENORTHO AG, welche sich auf Sch&auml;den materieller oder ideeller Art beziehen, die durch die Nutzung oder Nichtnutzung der dargebotenen Informationen, durch die Nutzung fehlerhafter und unvollst&auml;ndiger Informationen oder durch Viren, die den Computer und die dazugeh&ouml;rige Ausr&uuml;stung befallen k&ouml;nnen verursacht wurden, sind grunds&auml;tzlich ausgeschlossen, sofern seitens der CHRISTENORTHO AG kein nachweislich vors&auml;tzliches oder grob fahrl&auml;ssiges Verschulden vorliegt.</p>\r\n\r\n<h2>Anwendbares Recht.</h2>\r\n\r\n<p>Anwendbar auf diese Website ist ausschliesslich Schweizerisches Recht. Der ausschliessliche Gerichtsstand f&uuml;r s&auml;mtliche Auseinandersetzungen im Zusammenhang liegt am Sitz der CHRISTENORTHO AG.</p>',0,'',0,'','',0,0,'Disclaimer','Disclaimer','Disclaimer','index',NULL,NULL,'',0,0,0,0,1,'','privacy',''),(19,11,11,2,'fallback',0,'2014-12-17 00:00:00','system','Rechtliche Hinweise','','Rechtliche Hinweise','Rechtliche-Hinweise','<span style=\"font-weight: bold;\">Describe here, what you do (and especially what you DO&nbsp;NOT&nbsp;DO) with your customer&#39;s data.</span><br />\r\n',0,'content_full_width.html',NULL,'','',0,NULL,'Rechtliche Hinweise','Rechtliche Hinweise','Rechtliche Hinweise','index',NULL,NULL,'',0,0,0,0,1,'','privacy',''),(20,12,12,1,'application',1,'2015-04-13 10:22:48','webmaster@werbelinie.ch','Impressum','','Impressum','Impressum','<h2>Firmenname und Domizil</h2>\r\n\r\n<p>CHRISTENORTHO AG<br />\r\nDr. med., M. H. A. Bernhard Christen<br />\r\nOrthop&auml;dische Klinik Bern Sch&auml;nzlistrasse 39<br />\r\nCH-3000 Bern</p>\r\n\r\n<p>Tel. +41 31 337 89 24<br />\r\n<a href=\"javascript:linkTo_UnCryptMailto(\'ocknvq<kphqBejtkuvgpqtvjq0ej\', 2);\">info(at)christenortho.ch</a></p>\r\n\r\n<h2>Konzept, Webdesign und Realisierung</h2>\r\n\r\n<p><a href=\"http://www.werbelinie.ch\" target=\"_blank\">Werbelinie AG &ndash; Agentur f&uuml;r Kommunikation</a><br />\r\nThun und Bern<br />\r\n<a href=\"javascript:linkTo_UnCryptMailto(\'ocknvq&lt;ygdocuvgtBygtdgnkpkg0ej\', 2);\">webmaster(at)werbelinie.ch</a></p>\r\n\r\n<h2>Rechtliche Hinweise</h2>\r\n\r\n<p>Diese Website der CHRISTENORTHO AG dient ausschliesslich der Information. F&uuml;r die inhaltliche Richtigkeit und Vollst&auml;ndigkeit wird jegliche Haftung abgelehnt. Die Website sowie ihr Inhalt k&ouml;nnen jederzeit abge&auml;ndert werden. Das Copyright f&uuml;r s&auml;mtliche Inhalte dieser Website liegt bei der CHRISTENORTHO AG.</p>\r\n',0,'',0,'','',0,0,'Impressum','Impressum','Impressum','index',NULL,NULL,'',0,0,0,0,1,'','imprint',''),(21,12,12,2,'fallback',0,'2014-12-17 00:00:00','system','Impressum','','Impressum','Impressum','<p>Responsible for content and realization of this website:</p>\r\n<p><strong>Your company name</strong><br />\r\nStreet<br />\r\nZIP - City<br />\r\nCountry</p>\r\n<h2>Web Content Management System (CMS)</h2>\r\nThis website was created using the <a target=\"_blank\" href=\"http://www.contrexx.com/\">Contrexx&reg; WCMS</a>, developed by <a href=\"http://www.comvation.com/\">COMVATION Internet Solutions</a> in Thun, Switzerland<br />',0,'',NULL,'','',0,NULL,'Impressum','Impressum','Impressum','index',NULL,NULL,'',0,0,0,0,1,'','imprint',''),(22,13,13,1,'application',0,'2014-12-17 00:00:00','system','AGBs','','Allgemeinen Geschäftsbedingungen','AGBs','<p><a href=\"http://de.wikipedia.org/wiki/Allgemeine_Gesch%C3%A4ftsbedingungen\">Allgemeine Gesch&auml;ftsbedingungen</a> (abgek&uuml;rzt &bdquo;AGB&ldquo;, nicht-standardsprachlich auch oft &bdquo;AGBs&ldquo;,&bdquo;AGB&#39;s&ldquo; oder &bdquo;AGBen&ldquo;) sind alle f&uuml;r eine Vielzahl von Vertr&auml;gen vorformulierten Vertragsbedingungen, die eine Vertragspartei (der Verwender) der anderen Vertragspartei bei Abschluss eines Vertrages stellt.</p>\r\n\r\n<p>Dabei ist es gleichg&uuml;ltig, ob die Bestimmung einen &auml;u&szlig;erlich gesonderten Bestandteil des Vertrags (umgangssprachlich &bdquo;das Kleingedruckte&ldquo; genannt) bilden oder in die Vertragsurkunde selbst aufgenommen werden.</p>\r\n',0,'',NULL,'','',0,NULL,'Allgemeinen Geschäftsbedingungen','Allgemeinen Geschäftsbedingungen','Allgemeinen Geschäftsbedingungen','index',NULL,NULL,'',0,0,0,0,1,'','agb',''),(23,13,13,2,'fallback',0,'2014-12-17 00:00:00','system','AGBs','','Allgemeinen Geschäftsbedingungen','AGBs','<p><a href=\"http://de.wikipedia.org/wiki/Allgemeine_Gesch%C3%A4ftsbedingungen\">Terms &amp;&nbsp;Conditions</a> (abbreviated&bdquo;T&amp;C&ldquo;) are a &quot;default set&quot; of rules that make certain things clear before the customer buys something off this website or enters personal data.</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>',0,'',NULL,'','',0,NULL,'Allgemeinen Geschäftsbedingungen','Allgemeinen Geschäftsbedingungen','Allgemeinen Geschäftsbedingungen','index',NULL,NULL,'',0,0,0,0,1,'','agb',''),(24,14,14,1,'application',0,'2014-12-17 00:00:00','system','Registrieren','','Registrieren','Registrieren','<div id=\"access\">\r\n    <!-- BEGIN access_signup_form -->\r\n    Hier haben Sie die M&ouml;glichkeit sich f&uuml;r dieses Portal zu registrieren und ein Benutzerkonto zu er&ouml;ffnen.\r\n    <br /><br />\r\n    <!-- BEGIN access_social_networks -->\r\n    <fieldset>\r\n        <legend>oder Login mit Social Media</legend>\r\n        <!-- BEGIN access_social_networks_facebook -->\r\n        <a class=\"facebook loginbutton\" href=\"{ACCESS_SOCIALLOGIN_FACEBOOK}\">Facebook</a>\r\n        <!-- END access_social_networks_facebook -->\r\n        <!-- BEGIN access_social_networks_google -->\r\n        <a class=\"google loginbutton\" href=\"{ACCESS_SOCIALLOGIN_GOOGLE}\">Google</a>\r\n        <!-- END access_social_networks_google -->\r\n        <!-- BEGIN access_social_networks_twitter -->\r\n        <a class=\"twitter loginbutton\" href=\"{ACCESS_SOCIALLOGIN_TWITTER}\">Twitter</a>\r\n        <!-- END access_social_networks_twitter -->\r\n    </fieldset>\r\n    <!-- END access_social_networks -->\r\n    <div class=\"message_error\">{ACCESS_SIGNUP_MESSAGE}</div><br />\r\n    <form action=\"index.php?section=access&amp;cmd=signup\" method=\"post\" enctype=\"multipart/form-data\">\r\n        <fieldset><legend>Persönliche Angaben</legend>\r\n            <!-- BEGIN access_profile_attribute_gender -->\r\n    		<p><label>{ACCESS_PROFILE_ATTRIBUTE_GENDER_DESC}</label>{ACCESS_PROFILE_ATTRIBUTE_GENDER}</p>\r\n    		<!-- END access_profile_attribute_gender --> 				\r\n    		<!-- BEGIN access_profile_attribute_firstname -->\r\n    		<p><label>{ACCESS_PROFILE_ATTRIBUTE_FIRSTNAME_DESC}</label>{ACCESS_PROFILE_ATTRIBUTE_FIRSTNAME}</p>\r\n    		<!-- END access_profile_attribute_firstname --> 			\r\n    		<!-- BEGIN access_profile_attribute_lastname -->\r\n    		<p><label>{ACCESS_PROFILE_ATTRIBUTE_LASTNAME_DESC}</label>{ACCESS_PROFILE_ATTRIBUTE_LASTNAME}</p>\r\n    		<!-- END access_profile_attribute_lastname --> 	\r\n        </fieldset>\r\n        <fieldset><legend>Kontoangaben</legend>\r\n            <!-- BEGIN access_user_email -->\r\n            <p><label>{ACCESS_USER_EMAIL_DESC}</label>{ACCESS_USER_EMAIL}<br />\r\n            Sie m&uuml;ssen eine g&uuml;ltige E-Mail Adresse angeben, um Ihren Account zu nutzen</p>\r\n            <!-- END access_user_email -->\r\n            <!-- BEGIN access_logindata -->\r\n                <!-- BEGIN access_user_username -->\r\n                <p><label>{ACCESS_USER_USERNAME_DESC}</label>{ACCESS_USER_USERNAME}<br />Bitte w&auml;hlen Sie einen Benutzername</p>\r\n                <!-- END access_user_username --><!-- BEGIN access_user_password -->\r\n                <p><label>{ACCESS_USER_PASSWORD_DESC}</label>{ACCESS_USER_PASSWORD}<br />Bitte gew&uuml;nschtes Passwort eingeben</p>\r\n                <!-- END access_user_password --><!-- BEGIN access_user_password_confirmed -->\r\n                <p><label>{ACCESS_USER_PASSWORD_CONFIRMED_DESC}</label>{ACCESS_USER_PASSWORD_CONFIRMED}<br />Zur Ihrer Sicherheit wiederholen Sie bitte Ihr Passwort</p>\r\n                <!-- END access_user_password_confirmed --> \r\n            <!-- END access_logindata -->\r\n        </fieldset>\r\n        <fieldset><legend>Zusätzliche Angaben</legend>\r\n            <p><label>{ACCESS_USER_FRONTEND_LANGUAGE_DESC}</label>{ACCESS_USER_FRONTEND_LANGUAGE}</p>\r\n            <p><b>Hinweis:</b><br />Weitere Daten k&ouml;nnen nach erfolgreicher Registrierung im Benutzerprofil hinzugef&uuml;gt werden.</p>\r\n            <!-- BEGIN access_captcha -->\r\n            <p><label>{TXT_ACCESS_CAPTCHA}</label>{ACCESS_CAPTCHA_CODE}</p>\r\n            <!-- END access_captcha -->\r\n        </fieldset>\r\n        <!-- BEGIN access_newsletter -->\r\n        <fieldset><legend>Newsletter abonnieren</legend>\r\n            <!-- BEGIN access_newsletter_list -->\r\n            <p>\r\n                <label for=\"access_user_newsletters-{ACCESS_NEWSLETTER_ID}\">&nbsp;{ACCESS_NEWSLETTER_NAME}</label>\r\n                <input type=\"checkbox\" name=\"access_user_newsletters[]\" id=\"access_user_newsletters-{ACCESS_NEWSLETTER_ID}\" value=\"{ACCESS_NEWSLETTER_ID}\"{ACCESS_NEWSLETTER_SELECTED} />\r\n            </p>\r\n            <!-- END access_newsletter_list -->\r\n        </fieldset>\r\n        <!-- END access_newsletter -->\r\n        <!-- BEGIN access_tos -->\r\n        <fieldset>\r\n            <legend>AGBs</legend>\r\n            <div class=\"contact row\">\r\n                <label>{TXT_ACCESS_TOS}</label>{ACCESS_TOS}</div>\r\n        </fieldset>\r\n        <!-- END access_tos -->\r\n        <p>{ACCESS_SIGNUP_BUTTON}</p> \r\n    </form>\r\n    <!-- END access_signup_form --> 	\r\n    <!-- BEGIN access_signup_store_success -->\r\n    <div class=\"message_ok\">{ACCESS_SIGNUP_MESSAGE}</div>\r\n    <!-- END access_signup_store_success -->   	\r\n    <!-- BEGIN access_signup_store_error -->\r\n    <div class=\"message_error\">{ACCESS_SIGNUP_MESSAGE}</div>\r\n    <!-- END access_signup_store_error -->   	\r\n    <!-- BEGIN access_signup_confirm_success -->\r\n    <div class=\"message_ok\">{ACCESS_SIGNUP_MESSAGE}</div>\r\n    <!-- END access_signup_confirm_success -->   	\r\n    <!-- BEGIN access_signup_confirm_error -->\r\n    <div class=\"message_error\">{ACCESS_SIGNUP_MESSAGE}</div>\r\n    <!-- END access_signup_confirm_error -->    	\r\n    {ACCESS_JAVASCRIPT_FUNCTIONS}\r\n</div>',1,'',NULL,'register','',0,NULL,'Registrieren','Registrieren','Registrieren','index',NULL,NULL,'',0,0,0,0,1,'','access','signup'),(25,14,14,2,'fallback',0,'2014-12-17 00:00:00','system','Registrieren','','Registrieren','Registrieren','Here, you have the possibility to join our online community.\r\n<div id=\"access\">\r\n    <!-- BEGIN access_signup_form -->\r\n    <div class=\"message_error\">{ACCESS_SIGNUP_MESSAGE}</div><br />&nbsp;<br />\r\n    <form action=\"index.php?section=access&amp;cmd=signup\" method=\"post\" enctype=\"multipart/form-data\">\r\n        <fieldset><legend>Personal data</legend>\r\n            <!-- BEGIN access_profile_attribute_gender -->\r\n    		<p><label>{ACCESS_PROFILE_ATTRIBUTE_GENDER_DESC}</label>{ACCESS_PROFILE_ATTRIBUTE_GENDER}</p>\r\n    		<!-- END access_profile_attribute_gender --> 				\r\n    		<!-- BEGIN access_profile_attribute_firstname -->\r\n    		<p><label>{ACCESS_PROFILE_ATTRIBUTE_FIRSTNAME_DESC}</label>{ACCESS_PROFILE_ATTRIBUTE_FIRSTNAME}</p>\r\n    		<!-- END access_profile_attribute_firstname --> 			\r\n    		<!-- BEGIN access_profile_attribute_lastname -->\r\n    		<p><label>{ACCESS_PROFILE_ATTRIBUTE_LASTNAME_DESC}</label>{ACCESS_PROFILE_ATTRIBUTE_LASTNAME}</p>\r\n    		<!-- END access_profile_attribute_lastname --> 	\r\n        </fieldset>\r\n        <fieldset><legend>Account data</legend>\r\n            <!-- BEGIN access_user_username -->\r\n            <p><label>{ACCESS_USER_USERNAME_DESC}</label>{ACCESS_USER_USERNAME}<br />Please choose a username</p>\r\n            <!-- END access_user_username --><!-- BEGIN access_user_password -->\r\n            <p><label>{ACCESS_USER_PASSWORD_DESC}</label>{ACCESS_USER_PASSWORD}<br />Please enter your password (at least 6 characters)</p>\r\n            <!-- END access_user_password --><!-- BEGIN access_user_password_confirmed -->\r\n            <p><label>{ACCESS_USER_PASSWORD_CONFIRMED_DESC}</label>{ACCESS_USER_PASSWORD_CONFIRMED}<br />Please repeat your password</p>\r\n            <!-- END access_user_password_confirmed --> \r\n        </fieldset>\r\n        <fieldset><legend>Additional data</legend>	\r\n            <!-- BEGIN access_user_email -->\r\n            <p><label>{ACCESS_USER_EMAIL_DESC}</label>{ACCESS_USER_EMAIL}<br />\r\n            You have to enter a valid e-mail address, so we can send you an activation code.</p>\r\n            <!-- END access_user_email -->\r\n            <p><label>{ACCESS_USER_FRONTEND_LANGUAGE_DESC}</label>{ACCESS_USER_FRONTEND_LANGUAGE}<br /><br /></p>\r\n            <p><b>Note:</b><br />You can complete your profile after the registration process is finished.</p>\r\n        </fieldset>\r\n        <!-- BEGIN access_captcha -->\r\n        <fieldset><legend>{TXT_ACCESS_CAPTCHA}</legend>	\r\n            <p>{TXT_ACCESS_CAPTCHA_DESCRIPTION}<br /></p>\r\n            <p><label>CAPTCHA</label><img class=\"captcha\" src=\"{ACCESS_CAPTCHA_URL}\" alt=\"{ACCESS_CAPTCHA_ALT}\" />\r\n            <input id=\"accessSignUpCaptcha\" type=\"text\" name=\"accessSignUpCaptcha\" />\r\n            <input type=\"hidden\" name=\"accessSignUpCaptchaOffset\" value=\"{ACCESS_CAPTCHA_OFFSET}\" />\r\n            </p>\r\n        </fieldset> \r\n        <!-- END access_captcha -->\r\n        <!-- BEGIN access_tos -->\r\n            <fieldset><legend>{TXT_ACCESS_TOS}</legend>	\r\n                {ACCESS_TOS}\r\n            </fieldset> \r\n        <!-- END access_tos -->\r\n        <p>{ACCESS_SIGNUP_BUTTON}</p> \r\n    </form>\r\n    <!-- END access_signup_form --> 	\r\n    <!-- BEGIN access_signup_store_success -->\r\n    <div class=\"message_ok\">{ACCESS_SIGNUP_MESSAGE}</div>\r\n    <!-- END access_signup_store_success -->   	\r\n    <!-- BEGIN access_signup_store_error -->\r\n    <div class=\"message_error\">{ACCESS_SIGNUP_MESSAGE}</div>\r\n    <!-- END access_signup_store_error -->   	\r\n    <!-- BEGIN access_signup_confirm_success -->\r\n    <div class=\"message_ok\">{ACCESS_SIGNUP_MESSAGE}</div>\r\n    <!-- END access_signup_confirm_success -->   	\r\n    <!-- BEGIN access_signup_confirm_error -->\r\n    <div class=\"message_error\">{ACCESS_SIGNUP_MESSAGE}</div>\r\n    <!-- END access_signup_confirm_error -->    	\r\n    {ACCESS_JAVASCRIPT_FUNCTIONS}\r\n</div>',1,'',NULL,'register','',0,NULL,'Registrieren','Registrieren','Registrieren','index',NULL,NULL,'',0,0,0,0,1,'','access','signup'),(26,15,15,1,'application',0,'2014-12-17 00:00:00','system','Suchen','','Suchen','Suchen','<form action=\"index.php\" method=\"get\">\r\n	<input type=\"hidden\" name=\"section\" value=\"search\" />\r\n	<input type=\"text\" name=\"term\" value=\"{SEARCH_TERM}\" />\r\n	<input type=\"submit\" name=\"submit\" value=\"{TXT_SEARCH}\" />\r\n</form><br />\r\n\r\n{SEARCH_TITLE}<br /><br />\r\n\r\n<!-- BEGIN search_result -->\r\n	{LINK} {COUNT_MATCH}<br />\r\n	{SHORT_CONTENT}<br /><br />\r\n<!-- END search_result -->\r\n\r\n{SEARCH_PAGING}',1,'',NULL,'','',0,NULL,'Suchen','Suchen','Suchen','index',NULL,NULL,'',0,0,0,0,1,'','search',''),(27,15,15,2,'fallback',0,'2014-12-17 00:00:00','system','Suchen','','Suchen','Suchen','<form action=\"index.php\" method=\"get\">\r\n	<input name=\"term\" value=\"{SEARCH_TERM}\" size=\"30\" maxlength=\"100\" class=\"searchinput\" />\r\n	<input value=\"search\" name=\"section\" type=\"hidden\" />\r\n	<input value=\"{TXT_SEARCH}\" name=\"Submit\" type=\"submit\" class=\"searchbutton\" />\r\n</form>\r\n<br />\r\n{SEARCH_TITLE}<br />\r\n<!-- BEGIN searchrow -->\r\n	{LINK} {COUNT_MATCH}<br />\r\n	{SHORT_CONTENT}<br />\r\n<!-- END searchrow -->\r\n<br />\r\n{SEARCH_PAGING}\r\n<br />\r\n<br />',1,'',NULL,'','',0,NULL,'Suchen','Suchen','Suchen','index',NULL,NULL,'',0,0,0,0,1,'','search',''),(28,16,16,1,'application',0,'2014-12-17 00:00:00','system','Seite weiterempfehlen','','Seite weiterempfehlen','Seite-weiterempfehlen','<div id=\"recommend\">\r\n    <div class=\"status\">{RECOM_STATUS}</div>\r\n    <!-- BEGIN recommend_form -->\r\n    {RECOM_SCRIPT}\r\n    <div class=\"text\">{RECOM_TEXT}</div>\r\n    <div class=\"form\">\r\n        <form id=\"recommendForm\" name=\"recommend\" method=\"post\" action=\"index.php?section=recommend&amp;act=sendRecomm\">\r\n            <input type=\"hidden\" value=\"{RECOM_REFERER}\" name=\"uri\" /> \r\n            <input type=\"hidden\" value=\"{RECOM_FEMALE_SALUTATION_TEXT}\" name=\"female_salutation_text\" /> \r\n            <input type=\"hidden\" value=\"{RECOM_MALE_SALUTATION_TEXT}\" name=\"male_salutation_text\" /> \r\n            <input type=\"hidden\" value=\"{RECOM_PREVIEW}\" name=\"preview_text\" />\r\n            <p><label for=\"receivername\">{RECOM_TXT_RECEIVER_NAME}</label><input type=\"text\" onchange=\"recommendUpdate();\" value=\"{RECOM_RECEIVER_NAME}\" maxlength=\"100\" name=\"receivername\" /></p>\r\n            <p><label for=\"receivermail\">{RECOM_TXT_RECEIVER_MAIL}</label><input type=\"text\" onchange=\"recommendUpdate();\" value=\"{RECOM_RECEIVER_MAIL}\" maxlength=\"100\" name=\"receivermail\" /></p>\r\n            <p><label>{RECOM_TXT_GENDER}</label><input type=\"radio\" onclick=\"recommendUpdate();\" value=\"female\" name=\"gender\" id=\"female\" /><label class=\"description\" for=\"female\">{RECOM_TXT_FEMALE}</label></p>\r\n            <p><input type=\"radio\" onclick=\"recommendUpdate();\" value=\"male\" margin-left:=\"\" name=\"gender\" id=\"male\" /><label class=\"description\" for=\"male\">{RECOM_TXT_MALE}</label></p>\r\n            <p><label for=\"sendername\">{RECOM_TXT_SENDER_NAME}</label><input type=\"text\" onchange=\"recommendUpdate();\" value=\"{RECOM_SENDER_NAME}\" maxlength=\"100\" name=\"sendername\" /></p>\r\n            <p><label for=\"sendermail\">{RECOM_TXT_SENDER_MAIL}</label><input type=\"text\" onchange=\"recommendUpdate();\" value=\"{RECOM_SENDER_MAIL}\" maxlength=\"100\" name=\"sendermail\" /></p>\r\n            <p><label for=\"comment\">{RECOM_TXT_COMMENT}</label><textarea rows=\"1\" cols=\"1\" onchange=\"recommendUpdate();\" name=\"comment\">{RECOM_COMMENT}</textarea></p>\r\n            <p><label for=\"preview\">{RECOM_TXT_PREVIEW}</label><textarea rows=\"1\" cols=\"1\" name=\"preview\"></textarea></p>\r\n            <p>\r\n                <!-- BEGIN recommend_captcha -->\r\n                <label for=\"captchaCode\">{RECOM_TXT_CAPTCHA}</label>\r\n                <div id=\"contactFormCaptcha\">\r\n                    {RECOM_CAPTCHA_CODE}\r\n                </div>\r\n                <!-- END recommend_captcha -->\r\n            </p>\r\n            <p><input type=\"submit\" value=\"Senden\" /> <input type=\"reset\" value=\"L&ouml;schen\" /></p>\r\n        </form>\r\n    </div>\r\n    <!-- END recommend_form -->\r\n</div>',1,'',NULL,'','',0,NULL,'Seite weiterempfehlen','Seite weiterempfehlen','Seite weiterempfehlen','index',NULL,NULL,'',0,0,0,0,1,'','recommend',''),(29,16,16,2,'fallback',0,'2014-12-17 00:00:00','system','Seite weiterempfehlen','','Seite weiterempfehlen','Seite-weiterempfehlen','<div id=\"recommend\">\r\n    <div class=\"status\">{RECOM_STATUS}</div>\r\n    <!-- BEGIN recommend_form -->\r\n    {RECOM_SCRIPT}\r\n    <div class=\"text\">{RECOM_TEXT}</div>\r\n    <div class=\"form\">\r\n        <form id=\"recommendForm\" name=\"recommend\" method=\"post\" action=\"index.php?section=recommend&amp;act=sendRecomm\">\r\n            <input type=\"hidden\" value=\"{RECOM_REFERER}\" name=\"uri\" /> \r\n            <input type=\"hidden\" value=\"{RECOM_FEMALE_SALUTATION_TEXT}\" name=\"female_salutation_text\" /> \r\n            <input type=\"hidden\" value=\"{RECOM_MALE_SALUTATION_TEXT}\" name=\"male_salutation_text\" /> \r\n            <input type=\"hidden\" value=\"{RECOM_PREVIEW}\" name=\"preview_text\" />\r\n            <p><label for=\"receivername\">{RECOM_TXT_RECEIVER_NAME}</label><input type=\"text\" onchange=\"recommendUpdate();\" value=\"{RECOM_RECEIVER_NAME}\" maxlength=\"100\" name=\"receivername\" /></p>\r\n            <p><label for=\"receivermail\">{RECOM_TXT_RECEIVER_MAIL}</label><input type=\"text\" onchange=\"recommendUpdate();\" value=\"{RECOM_RECEIVER_MAIL}\" maxlength=\"100\" name=\"receivermail\" /></p>\r\n            <p><label>{RECOM_TXT_GENDER}</label><input type=\"radio\" onclick=\"recommendUpdate();\" value=\"female\" name=\"gender\" id=\"female\" /><label class=\"description\" for=\"female\">{RECOM_TXT_FEMALE}</label></p>\r\n            <p><input type=\"radio\" onclick=\"recommendUpdate();\" value=\"male\" margin-left:=\"\" name=\"gender\" id=\"male\" /><label class=\"description\" for=\"male\">{RECOM_TXT_MALE}</label></p>\r\n            <p><label for=\"sendername\">{RECOM_TXT_SENDER_NAME}</label><input type=\"text\" onchange=\"recommendUpdate();\" value=\"{RECOM_SENDER_NAME}\" maxlength=\"100\" name=\"sendername\" /></p>\r\n            <p><label for=\"sendermail\">{RECOM_TXT_SENDER_MAIL}</label><input type=\"text\" onchange=\"recommendUpdate();\" value=\"{RECOM_SENDER_MAIL}\" maxlength=\"100\" name=\"sendermail\" /></p>\r\n            <p><label for=\"comment\">{RECOM_TXT_COMMENT}</label><textarea rows=\"1\" cols=\"1\" onchange=\"recommendUpdate();\" name=\"comment\">{RECOM_COMMENT}</textarea></p>\r\n            <p><label for=\"preview\">{RECOM_TXT_PREVIEW}</label><textarea rows=\"1\" cols=\"1\" name=\"preview\"></textarea></p>\r\n            <p>\r\n                <!-- BEGIN recommend_captcha -->\r\n                <label for=\"captchaCode\">{RECOM_TXT_CAPTCHA}</label>\r\n                <div id=\"contactFormCaptcha\">\r\n                    {RECOM_CAPTCHA_CODE}\r\n                </div>\r\n                <!-- END recommend_captcha -->\r\n            </p>\r\n            <p><input type=\"submit\" value=\"Send\" /> <input type=\"reset\" value=\"Reset\" /></p>\r\n        </form>\r\n    </div>\r\n    <!-- END recommend_form -->\r\n</div>',1,'',NULL,'','',0,NULL,'Seite weiterempfehlen','Seite weiterempfehlen','Seite weiterempfehlen','index',NULL,NULL,'',0,0,0,0,1,'','recommend',''),(30,3,3,2,'fallback',0,'2014-12-17 00:00:00','system','System','','System','System','These pages are not shown directly but are only here to support various functions of the website.<br />\r\n',0,'',NULL,'','',0,NULL,'System','System','System','',NULL,NULL,'',0,0,0,0,1,'','',''),(31,17,17,1,'content',0,'2014-12-17 00:00:00','system','Inhaltscontainer bearbeiten','','Inhaltscontainer bearbeiten ','Inhaltscontainer','Sofern Inhaltscontainer blau umrahmt wurden, k&ouml;nnen Sie mit der Maus in einen dieser Bereiche klicken. Alle anderen Bereiche werden dann f&uuml;r die Bearbeitung gesperrt, solange die &Auml;nderungen nicht gespeichert oder verworfen wurden.<br />\r\n<br />\r\n<img alt=\"\" src=\"/versions/3.2/1/de/images/content/screenshots/700px-Frontend_editing_block_border.png\" style=\"width: 700px; height: 234px;\" /><br />\r\n<br />\r\nWeitere Informationen zum Frontend-Editing finden Sie im Contrexx-Wiki:&nbsp;<a href=\"http://wiki.contrexx.com/de/index.php?title=Frontend_Editing\">http://wiki.contrexx.com/de/index.php?title=Frontend_Editing</a>',0,'',NULL,'','',0,NULL,'Inhaltscontainer','Inhaltscontainer','Inhaltscontainer','1',NULL,NULL,'',0,0,0,0,1,'/images/content/screenshots/700px-Frontend_editing_block_border.png','access',''),(32,18,18,1,'redirect',0,'2015-04-08 13:16:22','webmaster@werbelinie.ch','Über uns','','Über uns','Ueber-uns','',0,'',0,'','',0,0,'Über uns','Über uns','Über uns','1',NULL,NULL,'',0,0,0,1,1,'[[NODE_27]]','access',''),(33,19,19,1,'redirect',0,'2015-03-18 07:48:25','webmaster@werbelinie.ch','Behandlungen','','Behandlungen','Behandlungen','',0,'',0,'','',0,0,'Behandlungen','Behandlungen','Behandlungen','1',NULL,NULL,'',0,0,0,1,1,'[[NODE_23]]','access',''),(34,20,20,1,'redirect',0,'2015-04-08 13:15:18','webmaster@werbelinie.ch','Patienten','','Patienten','Patienten','',0,'',0,'','',0,0,'Patienten','Patienten','Patienten','1',NULL,NULL,'',0,0,0,1,1,'[[NODE_33]]','access',''),(35,21,21,1,'redirect',0,'2015-04-08 13:17:08','webmaster@werbelinie.ch','Medien','','Medien','Medien','',0,'',0,'','',0,0,'Medien','Medien','Medien','1',NULL,NULL,'',0,0,0,1,1,'[[NODE_37]]','access',''),(36,22,22,1,'content',0,'2015-04-13 13:15:39','webmaster@werbelinie.ch','Kontakt','','Kontakt','Kontakt','<section class=\"content-section-two\">\r\n<h2 id=\"kontakt\">Adresse</h2>\r\n\r\n<p><strong>CHRISTENORTHO AG</strong><br />\r\nDr. med., M.H.A. Bernhard Christen<br />\r\nOrthop&auml;dische Klinik Bern<br />\r\nSch&auml;nzlistrasse 39<br />\r\nCH-3000 Bern 25<br />\r\n<br />\r\nTelefon +41 31 337 89 24<br />\r\nTelefax +41 31 337 89 54<br />\r\n<a class=\"icon-mail link-icon\" href=\"mailto:info@christenortho.ch\">info@christenortho.ch</a></p>\r\n</section>\r\n\r\n<section class=\"content-section-two\">\r\n<h2>&Ouml;ffnungszeiten</h2>\r\n\r\n<p><strong>Montag, Dienstag, Donnerstag und Freitag</strong><br />\r\n09:00 &ndash; 12:00 und 14:00 &ndash; 16:00 Uhr&nbsp;<br />\r\n<strong>Mittwoch</strong><br />\r\n09:00 &ndash; 12:00 Uhr</p>\r\n</section>\r\n\r\n<section class=\"content-section-two\">\r\n<h2 id=\"sos\">SOS-Notfall</h2>\r\n\r\n<p><strong>Apotheken Notfalldienst</strong><br />\r\nTelefon 0900 98 99 00</p>\r\n</section>\r\n\r\n<section class=\"content-section-two\">\r\n<div class=\"heading-spacer\">&nbsp;</div>\r\n\r\n<p><strong>Notfalldienst Salemspital</strong><br />\r\nTelefon 031 335 35 35</p>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2 id=\"anfahrt\">Anfahrt</h2>\r\n\r\n  <div class=\"embed-container embed-container-maps\">\r\n<iframe src=\"https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d2723.4813925234575!2d7.453770999999998!3d46.952231!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x478e39c2a12607df%3A0xc27eb1db3037329d!2sChristen+Ortho!5e0!3m2!1sde!2sch!4v1428929767606\" width=\"750\" height=\"450\" frameborder=\"0\" style=\"border:0\"></iframe>\r\n  </div>\r\n  \r\n<p>Bus Nummer 10 Richtung Ostermundigen/R&uuml;ti, Haltestelle Salem oder Tram Nummer 9 Richtung Guisanplatz, Haltestelle Viktoriaplatz.</p>\r\n\r\n<p>Unsere Praxis befindet sich im Haus Elim im Salemspital, erreichbar &uuml;ber den Haupteingang, in Verl&auml;ngerung des Geschosses A1.</p>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2 id=\"salem\">Salemspital</h2>\r\n\r\n<p><a href=\"http://www.bernerzeitung.ch/schweiz/standard/Schweizer-Aerzte-greifen-im-Zweifel-zum-Skalpell/story/12275394\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Praxis/Salem.jpg\" width=\"300\" /></a>Das 1888 erbaute Salemspital hat eine lange Tradition. Das heute zur Privatklinikgruppe Hirslanden geh&ouml;rende Spital bietet ein breites Spektrum von medizinischen Dienstleistungen an.</p>\r\n\r\n<p>Die moderne Infrastruktur und die hohe medizinische Fachkompetenz bestimmen seit Jahren das Handeln und die Philosophie des Salemspitals.</p>\r\n\r\n<p>Steter Wandel und innovatives Schaffen stehen f&uuml;r das Spitalleitbild: &bdquo;Sich mit K&ouml;nnen, Wissen und Gewissen f&uuml;r die Patienten zu engagieren und f&uuml;r Menschen da zu sein&ldquo;!</p>\r\n\r\n<p>​Eine Aussage, die sich mit der Er&ouml;ffnung der Orthop&auml;dischen Klinik Bern im November 2002 einmal mehr untermauern liess und ein Credo, welches in der Orthop&auml;dischen Klinik und speziell auch bei christenortho Tag f&uuml;r Tag neu gelebt und praktiziert wird.</p>\r\n\r\n<ul>\r\n	<li><a class=\"icon-link link-icon\" href=\"http://www.hirslanden.ch/global/de/startseite/kliniken_zentren/salem-spital.html\" target=\"_blank\">Website besuchen</a></li>\r\n</ul>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2 id=\"siloah\">Klinik Siloah</h2>\r\n\r\n<p><a href=\"http://www.bernerzeitung.ch/schweiz/standard/Schweizer-Aerzte-greifen-im-Zweifel-zum-Skalpell/story/12275394\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Praxis/Salem.jpg\" width=\"300\" /></a>Dies ist ein Typoblindtext. An ihm kann man sehen, ob alle Buchstaben da sind und wie sie aussehen. Manchmal benutzt man Worte wie Hamburgefonts, Rafgenduks oder Handgloves, um Schriften zu testen. Manchmal S&auml;tze, die alle Buchstaben des Alphabets enthalten - man nennt diese S&auml;tze &raquo;Pangrams&laquo;. Sehr bekannt ist dieser: The quick brown fox jumps over the lazy old dog.</p>\r\n\r\n<ul>\r\n	<li><a class=\"icon-link link-icon\" href=\"http://www.siloah.ch\" target=\"_blank\">Website besuchen</a></li>\r\n</ul>\r\n</section>\r\n',0,'content_nested.html',1,'','',0,0,'Kontakt','Kontakt','Kontakt','1',NULL,NULL,'',0,0,0,1,1,'','access',''),(37,23,23,1,'content',0,'2015-04-08 14:26:10','webmaster@werbelinie.ch','Knie','','Knie: Krankheitsbilder','Knie','<h3 class=\"accordion-title in\"><a class=\"accordion-link\" href=\"#\">Arthrose des Kniegelenks (Gonarthrose)</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Verschleiss der Knorpelfl&auml;chen und Meniski im Kniegelenk. Die Arthrose kann sich isoliert innen oder aussen respektive im Kniescheibengelenk abspielen oder das ganze Gelenk betreffen.</p>\r\n\r\n<h4 class=\"accordion-subheading\">Symptome und Diagnostik</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Arthrose und Behandlungsm&ouml;glichkeiten</a></li>\r\n</ul>\r\n\r\n<h4 class=\"accordion-subheading\">Anatomie</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomie des Kniegelenkes</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomische Grundbegriffe</a></li>\r\n</ul>\r\n\r\n<h4 class=\"accordion-subheading\">Therapie und Nachbehandlung</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Der Knieprothesenwechsel</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Knie-Teilprothese</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Scharnierprothese</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Das Journey, eine Knie-Totalprothese der neuesten...</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Attune - Brainlab, die vielversprechende Kombination...</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Kontroversen in der Knieprothetik</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Arthroskopisches D&eacute;bridement</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Achsenumstellung, Achsenkorrektur</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Knie-Totalprothese</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Computernavigation</a></li>\r\n</ul>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Meniskusschaden / Meniskusl&auml;sion / Meniskusriss</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Unfall- oder verschleissbedingter Riss im Innen- oder Aussenmeniskus mit Schmerzen bei belasteten Drehbewegungen, eventuell verbunden mit Einklemmungsgef&uuml;hl und Schwellung des Knies.</p>\r\n\r\n<h4 class=\"accordion-subheading\">Symptome und Diagnostik</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Der Meniskusriss</a></li>\r\n</ul>\r\n\r\n<h4 class=\"accordion-subheading\">Anatomie</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomie des Kniegelenkes</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomische Grundbegriffe</a></li>\r\n</ul>\r\n\r\n<h4 class=\"accordion-subheading\">Therapie und Nachbehandlung</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Arthroskopische Meniskusteilresektion</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Knie-Totalprothese</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Computernavigation</a></li>\r\n</ul>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Riss / Ruptur / L&auml;sion des vorderen Kreuzbandes</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Unfallbedingter Riss des vorderen Kreuzbandes mit Instabilit&auml;tsgef&uuml;hl und dem Gef&uuml;hl des Einsinkens unter Belastung. Schmerzen und Schwellung vor allem nach dem frischen Unfall.</p>\r\n\r\n<h4 class=\"accordion-subheading\">Symptome und Diagnostik</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Riss des vorderen Kreuzbandes</a></li>\r\n</ul>\r\n\r\n<h4 class=\"accordion-subheading\">Anatomie</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomie des Kniegelenkes</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomische Grundbegriffe</a></li>\r\n</ul>\r\n\r\n<h4>Therapie und Nachbehandlung</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Knie-Totalprothese</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Computernavigation</a></li>\r\n</ul>\r\n</div>\r\n',0,'',0,'','icon-knie subnav-icon',0,0,'Knie','Knie','Knie','1',NULL,NULL,'',0,0,0,1,1,'','access',''),(38,24,24,1,'content',0,'2015-04-08 14:39:48','webmaster@werbelinie.ch','Schulter','','Schulter: Krankheitsbilder','Schulter','<h3 class=\"accordion-title in\"><a class=\"accordion-link\" href=\"#\">Riss / Verletzung / L&auml;sion / Ruptur der Rotatorenmanschette</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Teilweiser oder kompletter Einriss einer oder mehrerer Sehnen der Rotatorenmanschette. In erster Linie verursachen diese Sch&auml;den Schmerzen. Je nach Ort der L&auml;sion kommen Funktionsdefizite hinzu.</p>\r\n\r\n<h4 class=\"accordion-subheading\">Symptome und Diagnostik</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Riss der Rotatorenmanschette</a></li>\r\n</ul>\r\n\r\n<h4 class=\"accordion-subheading\">Anatomie</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomie der Schulter</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomische Grundbegriffe</a></li>\r\n</ul>\r\n\r\n<h4 class=\"accordion-subheading\">Therapie und Nachbehandlung</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Rekonstruktion der Rotatorenmanschette</a></li>\r\n</ul>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Arthrose des Schultergelenkes (Omarthrose)</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Verschleiss des Hauptgelenkes zwischen Schulterkopf und Pfanne mit Abnutzung des Gelenkknorpels. Neben Schmerzen f&uuml;hrt die Arthrose zu einer zunehmenden Einschr&auml;nkung der Beweglichkeit.</p>\r\n\r\n<h4 class=\"accordion-subheading\">Symptome und Diagnostik</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Arthrose und Behandlungsm&ouml;glichkeiten</a></li>\r\n</ul>\r\n\r\n<h4 class=\"accordion-subheading\">Anatomie</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomie der Schulter</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomische Grundbegriffe</a></li>\r\n</ul>\r\n\r\n<h4 class=\"accordion-subheading\">Therapie und Nachbehandlung</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Arthrose und Behandlungsm&ouml;glichkeiten</a></li>\r\n</ul>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Schulterinstabilit&auml;t</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Instabilit&auml;t der Schulter mit Ausrenkung oder Fast-Ausrenkung des Gelenkes in bestimmten Armpositionen oder bei gewissen Belastungen. Gef&uuml;hl eines &quot;toten&quot; Armes, gelegentlich verbunden mit Schmerzen.</p>\r\n\r\n<h4 class=\"accordion-subheading\">Symptome und Diagnostik</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Schulterinstabilit&auml;t</a></li>\r\n</ul>\r\n\r\n<h4 class=\"accordion-subheading\">Anatomie</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomie der Schulter</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomische Grundbegriffe</a></li>\r\n</ul>\r\n\r\n<h4 class=\"accordion-subheading\">Therapie und Nachbehandlung</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die operative Schulterstabilisierung</a></li>\r\n</ul>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Einklemmungserscheinung unter dem Schulterdach (Impingement)</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Schmerzen in der Schulter bei Bewegungen oder Belastungen ab der Horizontalen und dar&uuml;ber ohne Kraftverlust. Schmerzen h&auml;ufig auch beim Liegen auf der betroffenen Seite.</p>\r\n\r\n<h4 class=\"accordion-subheading\">Symptome und Diagnostik</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Das Impingementsyndrom</a></li>\r\n</ul>\r\n\r\n<h4 class=\"accordion-subheading\">Anatomie</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomie der Schulter</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomische Grundbegriffe</a></li>\r\n</ul>\r\n\r\n<h4 class=\"accordion-subheading\">Therapie und Nachbehandlung</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Operationen beim Impingementsyndrom</a></li>\r\n</ul>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Schmerzen im Schulter-Eckgelenk</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Schmerzen im Gelenk zwischen Schlüsselbein und Schulterdach (=Schultereckgelenk). Die Beschwerden werden bei Belastungen und Bewegungen ab der Horizontalen und darüber verstärkt.</p>\r\n\r\n<h4 class=\"accordion-subheading\">Symptome und Diagnostik</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Das Impingementsyndrom</a></li>\r\n</ul>\r\n\r\n<h4 class=\"accordion-subheading\">Anatomie</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomie der Schulter</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomische Grundbegriffe</a></li>\r\n</ul>\r\n\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Schultergelenksteife (Adhäsive Kapsulitis)</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Schmerzhafte Einschränkung der Beweglichkeit der Schulter mit empfindlichen Endanschlägen. Beschwerden in Ruhe, Verstärkung bei fordierten Bewegungen oder Belastungen.</p>\r\n\r\n<h4 class=\"accordion-subheading\">Symptome und Diagnostik</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Schultersteife</a></li>\r\n</ul>\r\n\r\n<h4 class=\"accordion-subheading\">Anatomie</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomie der Schulter</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomische Grundbegriffe</a></li>\r\n</ul>\r\n\r\n<h4 class=\"accordion-subheading\">Therapie und Nachbehandlung</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Schultersteife</a></li>\r\n</ul>\r\n</div>\r\n',0,'',0,'','icon-schulter subnav-icon',0,0,'Schulter','Schulter','Schulter','1',NULL,NULL,'',0,0,0,1,1,'','access',''),(39,25,25,1,'content',0,'2015-04-13 11:50:48','webmaster@werbelinie.ch','Hüfte','','Hüfte: Krankheitsbilder','Huefte','<h3 class=\"accordion-title in\"><a class=\"accordion-link\" href=\"#\">Arthrose des Hüftgelenkes (Coxarthrose)</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Verschleiss im Hüftgelenk zwischen Kopf und Pfanne mit Schmerzen, Einschränkung der Gehfähigkeit und Beweglichkeit. Beginn häufig schleichend, Verlauf wechselhaft, wetterabhängig.</p>\r\n\r\n<h4 class=\"accordion-subheading\">Symptome und Diagnostik</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Arthrose und Behandlungsm&ouml;glichkeiten</a></li>\r\n</ul>\r\n\r\n<h4 class=\"accordion-subheading\">Anatomie</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomie des Hüftgelenkes</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomische Grundbegriffe</a></li>\r\n</ul>\r\n\r\n<h4 class=\"accordion-subheading\">Therapie und Nachbehandlung</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Kontroversen in der Hüftprothetik</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Hüft-Totalprothese</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Computernavigation</a></li>\r\n</ul>\r\n</div>\r\n\r\n<h3 class=\"accordion-title in\"><a class=\"accordion-link\" href=\"#\">Einklemmungserscheinung (Impingement) beim Hüftgelenk</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Schmerzen bei Beugung der Hüfte vor allem in Kombination mit Innendrehung und Zuspreizung des Beines.</p>\r\n\r\n<h4 class=\"accordion-subheading\">Symptome und Diagnostik</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Arthrose und Behandlungsm&ouml;glichkeiten</a></li>\r\n</ul>\r\n  \r\n<h4 class=\"accordion-subheading\">Anatomie</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomie des Hüftgelenkes</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomische Grundbegriffe</a></li>\r\n</ul>\r\n\r\n<h4 class=\"accordion-subheading\">Therapie und Nachbehandlung</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Hüft-Totalprothese</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Computernavigation</a></li>\r\n</ul>\r\n</div>',0,'',0,'','icon-huefte subnav-icon',0,0,'Hüfte','Hüfte','Hüfte','1',NULL,NULL,'',0,0,0,1,1,'','access',''),(40,26,26,1,'content',0,'2015-03-13 09:03:28','webmaster@werbelinie.ch','Traumatologie','','Traumatologie','Traumatologie','',0,'',0,'','icon-traumatologie subnav-icon',0,0,'Traumatologie','Traumatologie','Traumatologie','1',NULL,NULL,'',0,0,0,1,0,'','access',''),(41,27,27,1,'content',0,'2015-04-21 15:10:52','webmaster@werbelinie.ch','Philosophie','','Philosophie','Philosophie','<p>Als Spezialist des Bewegungsapparates (Orthop&auml;de) berate ich Sie bei Erkrankungen oder Unfallfolgen, welche in erster Linie das Knie, die H&uuml;fte sowie die Schulter betreffen. Mein eigentliches Spezialgebiet sind die degenerativen Ver&auml;nderungen (Verschleisserscheinungen), also letztlich die Behandlung der Arthrose.</p>\r\n\r\n<h2>Vertrauen steht an erster Stelle!</h2>\r\n\r\n<p>Entscheidend im gesamten Prozess der Abkl&auml;rung, Diagnosestellung, Therapieplanung, Vor- und Nachbehandlung&nbsp;ist das Vertrauen zwischen Patient und Arzt. Ohne dieses Vertrauen wird die Behandlung nicht zum angestrebten Erfolg f&uuml;hren. F&uuml;r das Vertrauen gen&uuml;gen Fakten und Wissen nicht, verlassen Sie sich dabei auch auf Ihr Bauchgef&uuml;hl.</p>\r\n\r\n<h2>Beweglichkeit ist unser Rezept</h2>\r\n\r\n<p>Als engagierter Orthop&auml;de f&uuml;hle ich mich verpflichtet, alles erdenklich M&ouml;gliche zu tun, um Ihnen zu helfen, Ihr Problem mit dem Bewegungsapparat zu l&ouml;sen oder zumindest zu verbessern. Ich tue dies aus Leidenschaft, mit der gebotenen Sorgfalt und Sachkenntnis und versuche mit Ihnen, eine auf Sie abgestimmte optimale L&ouml;sung zu finden.<br />\r\nBeweglichkeit zu vermitteln und gleichzeitig beweglich zu bleiben, ist das Credo meiner t&auml;glichen Arbeit!</p>\r\n\r\n<h2>Qualit&auml;tskontrolle</h2>\r\n\r\n<p>Die st&auml;ndige &Uuml;berpr&uuml;fung der Behandlungsresultate ist unabdingbare Voraussetzung, um die Behandlungsqualit&auml;t stetig zu verbessern und Fehler sowie Komplikationen m&ouml;glichst zu minimieren. Die Nachkontrollen bei christenortho sind auch Bestandteil dieser Qualit&auml;tskontrolle. Die Daten aller Gelenkprothesen werden unter Einhaltung des Datenschutzes dem schweizerischen Prothesenregister SIRIS weiter geleitet. Bei etlichen Operationen (Knie- und H&uuml;ftprothesen) werden die Patienten vor und ein Jahr nach dem Eingriff Fragebogen zur Erfassung von Schmerzen und Einschr&auml;nkungen von Gelenkfunktionen und Lebensqualit&auml;t ausf&uuml;llen (KOOS, respektive HOOS-Fragebogen). S&auml;mtliche Komplikationen werden l&uuml;ckenlos erfasst.</p>\r\n\r\n<h2>Ausbildung</h2>\r\n\r\n<p>Es ist mir ein Anliegen, meine Erfahrung und mein Wissen weiter zu geben. Deswegen bilde ich auch im Privatspital Assistenz&auml;rzte aus und engagiere mich an orthop&auml;dischen Weiterbildungsveranstaltungen im In- und Ausland. Seit 2013 kooperiere ich hier en mit der Orthop&auml;dischen Universit&auml;tsklinik des Inselspitals Bern.</p>\r\n',0,'',0,'','',0,0,'Philosophie','Philosophie','Philosophie','1',NULL,NULL,'',0,0,0,1,1,'','access',''),(42,28,28,1,'content',0,'2015-04-13 06:11:50','webmaster@werbelinie.ch','CV','','CV','CV','<p>Bernhard Christen,&nbsp;Dr. med., Facharzt f&uuml;r Orthop&auml;dische Chirurgie und Traumatologie des Bewegungsapparates,&nbsp;Master of Health Administration (M.H.A.)</p>\r\n\r\n<h2>Lebenslauf</h2>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width: 100%;\">\r\n	<tbody>\r\n		<tr>\r\n			<td style=\"width: 231px; vertical-align: top;\">\r\n			<p><strong>1976</strong></p>\r\n			</td>\r\n			<td style=\"width: 1653px; vertical-align: top;\">\r\n			<p>C-Matura Gymnasium Neufeld Bern</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"width: 231px; vertical-align: top;\">\r\n			<p><strong>1977 &ndash; 1982</strong></p>\r\n			</td>\r\n			<td style=\"width: 1653px; vertical-align: top;\">\r\n			<p>Medizinstudium an der Universit&auml;t Bern</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"width: 231px; vertical-align: top;\">\r\n			<p><strong>1982</strong></p>\r\n			</td>\r\n			<td style=\"width: 1653px; vertical-align: top;\">\r\n			<p>Staatsexamen</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"width: 231px; vertical-align: top;\">\r\n			<p><strong>1983 &ndash; 1992</strong></p>\r\n			</td>\r\n			<td style=\"width: 1653px; vertical-align: top;\">\r\n			<p>Diverse Assistenzarztstellen in der Inneren Medizin und Allgemeiner Chirurgie, Orthop&auml;die im B&uuml;rgerspital Solothurn und im Inselspital Bern</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"width: 231px; vertical-align: top;\">\r\n			<p><strong>1987</strong></p>\r\n			</td>\r\n			<td style=\"width: 1653px; vertical-align: top;\">\r\n			<p>Dissertation</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"width: 231px; vertical-align: top;\">\r\n			<p><strong>1992</strong></p>\r\n			</td>\r\n			<td style=\"width: 1653px; vertical-align: top;\">\r\n			<p>Facharzt f&uuml;r Orthop&auml;die und Traumatologie</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"width: 231px; vertical-align: top;\">\r\n			<p><strong>1992 &ndash; 1997</strong></p>\r\n			</td>\r\n			<td style=\"width: 1653px; vertical-align: top;\">\r\n			<p>Oberarzt Orthop&auml;die im B&uuml;rgerspital Solothurn</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"width: 231px; vertical-align: top;\">\r\n			<p><strong>1996</strong></p>\r\n			</td>\r\n			<td style=\"width: 1653px; vertical-align: top;\">\r\n			<p>Fellowship Schulterchirurgie, Universit&auml;tsklinik Balgrist, Z&uuml;rich</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"width: 231px; vertical-align: top;\">\r\n			<p><strong>1997 &ndash; 2002</strong></p>\r\n			</td>\r\n			<td style=\"width: 1653px; vertical-align: top;\">\r\n			<p>Leitender Arzt f&uuml;r Orthop&auml;die und Traumatologie, Chirurgische Klinik, Spital Bern Ziegler</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"width: 231px; vertical-align: top;\">\r\n			<p><strong>2002</strong></p>\r\n			</td>\r\n			<td style=\"width: 1653px; vertical-align: top;\">\r\n			<p>Master of Health Administration (M.H.A.)</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"width: 231px; vertical-align: top;\">\r\n			<p><strong>seit 01.11.2002</strong></p>\r\n			</td>\r\n			<td style=\"width: 1653px; vertical-align: top;\">\r\n			<p>Belegarzt mit Praxis am Salemspital Bern, seit 1.7.2013 mit eigener AG (CHRISTENORTHO AG)</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<h2>F&uuml;hrungserfahrung</h2>\r\n\r\n<ul class=\"tick-list\">\r\n	<li>Jahrelange Mitarbeit als Arzt in milit&auml;rischen St&auml;ben, zuletzt als Divisionsarzt der Gebirgsdivision 10.</li>\r\n	<li>Ununterbrochene F&uuml;hrungsposition im Beruf seit 1992.</li>\r\n	<li>1999 - 2001 Berufbegleitendes Nachdiplomstudium &quot;Management im Gesundheitswesen&quot;</li>\r\n	<li>NDS MiG IV an der Universit&auml;t Bern.</li>\r\n	<li>Master of Health Administration (M.H.A.) Ende 2002.</li>\r\n	<li>Pr&auml;sident von Swiss Orthopaedics, der Schweizerischen Gesellschaft f&uuml;r Orthop&auml;die (SGOT) Juni 2012 bis Juni 2014.</li>\r\n	<li>Board Member der European Knee Associates EKA seit Mai 2014, der European Knee Society EKS seit Januar 2015<br />\r\n	&nbsp;</li>\r\n</ul>\r\n\r\n<h2>Aktuelle berufliche Aktivit&auml;ten</h2>\r\n\r\n<ul class=\"tick-list\">\r\n	<li>Belegarzt am Salemspital mit Praxis im Haus Elim und operativer T&auml;tigkeit im Salemspital</li>\r\n	<li>Gr&uuml;ndungsmitglied SportsClinic#1 AG</li>\r\n	<li>Mitglied im Stiftungsrat in der Berner Klinik Montana</li>\r\n	<li>Mitglied der Tarifkommission des Kantons Bern</li>\r\n	<li>Mitglied der parit&auml;tischen Kommission des Kantons Bern&nbsp;</li>\r\n	<li>Mitglied der Expertengruppe Knie (EGK) der Schweizerischen Geselllschaft f&uuml;r Orthop&auml;die (SGOT)</li>\r\n	<li>Past-Pr&auml;sident der Schweizerischen Gesellschaft f&uuml;r Orthop&auml;die und Traumatologie (SGOT) seit Juni 2014&nbsp;</li>\r\n	<li>Founding und Board Member der European Knee Society (EKS) im Januar 2015<br />\r\n	&nbsp;</li>\r\n</ul>\r\n\r\n<h2>Mitgliedschaften</h2>\r\n\r\n<ul class=\"tick-list\">\r\n	<li>Orthop&auml;dische Klinik Bern (OKB; www.ortho-klinik.ch)</li>\r\n	<li>Berner Gesellschaft f&uuml;r Orthop&auml;den (BGO; www.bgo-bern.ch), Pr&auml;sident 2003-2009</li>\r\n	<li>Bernische Beleg&auml;rzte-Vereinigung (BBV+; www.bbvplus.ch)</li>\r\n	<li>Medizinischer Bezirksverein Bern-Stadt</li>\r\n	<li>&Auml;rztegesellschaft des Kantons Bern</li>\r\n	<li>SOCA (Schweizerischer Orthop&auml;discher Club f&uuml;r Austausch und Weiterbildung)</li>\r\n	<li>Swiss orthopaedics (Schweizerische Gesellschaft f&uuml;r Orthop&auml;die und Traumatologie;www.swissorthopaedics.ch), Pr&auml;sident 2012-2014</li>\r\n	<li>Schweizerische Gesellschaft f&uuml;r Traumatologie und Versicherungsmedizin (SGTV; www.sgtv.org)</li>\r\n	<li>Foederatio Medicorum Chirurgicorum Helvetica (FMCH)</li>\r\n	<li>Schweizerische Beleg&auml;rzte-Vereinigung (SBV)</li>\r\n	<li>Verbindung der Schweizer &Auml;rztinnen und &Auml;rzte (FMH)</li>\r\n	<li>Arbeitsgemeinschaft Endoprothetik AE (www.ae-germany.com)</li>\r\n	<li>Akademie der Arbeitsgemeinschaft Endoprothetik AE (www.ae-germany.com)</li>\r\n	<li>Europ&auml;ische Gesellschaft f&uuml;r Kniechirurgie und Arthroskopie (ESSKA; www.esska.org)</li>\r\n	<li>European Knee Associates EKA, Board-member vom Mai 2014 bis Januar 2015&nbsp;</li>\r\n	<li>European Knee Society EKS, Board-member seit Januar 2015</li>\r\n	<li>Vereinigung der Amerikanischen Orthop&auml;dischen Chirurgen (AAOS; www.aaos.org)<br />\r\n	&nbsp;</li>\r\n</ul>\r\n\r\n<h2>Zur Person</h2>\r\n\r\n<p>Vater von drei erwachsenen Kindern, einer Tochter und zwei S&ouml;hnen, zum zweiten Mal verheiratet. Ich fahre leidenschaftlich gerne Ski, spiele regelm&auml;ssig Squash und Unihockey&nbsp;und versuche mich gelegentlich im Golf. Meine Energie hole ich bei der Familie sowie auf Reisen im In- und Ausland.<br />\r\nInteresse f&uuml;r fast Alles, Faszination f&uuml;r Natur, Historik, Fotographie, Kunst, Wein und Sein und gutes Essen.</p>\r\n',0,'',0,'','',0,0,'CV','CV','CV','1',NULL,NULL,'',0,0,0,1,1,'','access',''),(43,29,29,1,'content',0,'2015-04-08 13:19:03','webmaster@werbelinie.ch','Kompetenzen','','Kernkompetenz','Kompetenzen','<h2>Arthrose-Chirurgie am Kniegelenk und an der H&uuml;fte</h2>\r\n\r\n<p>An Knie und H&uuml;fte fokussiere ich meine Aktivit&auml;ten Richtung Behandlung von Verschleisserscheinungen (=Arthrose) als Folge von Verletzungen oder jahrelangen Fehlbelastungen. Mein Hauptaugenmerk gilt demnach nicht aktiven Leistungssportlern, sondern jenen, die ihre sportliche Karriere meist schon hinter sich haben. Alle Verbesserungsmassnahmen der letzten Jahre haben zum Ziel, die Schmerzen nach Operationen zu minimieren und m&ouml;glichst von Beginn weg eine normale Alltagsfunktion mit freien Bewegungen und voller Belastung zu erm&ouml;glichen. dies ist bei &auml;lteren, gebrechlichen Menschen noch zentraler als bei Jungen, um die Rekonvaleszenz Zeit m&ouml;glichst kurz zu halten getreu dem Motto &quot;Beweglichkeit ist unser Rezept&quot;.</p>\r\n\r\n<p>Kerngebiet Nummer 1 ist f&uuml;r mich seit Jahren die Therapie der Arthrose am Kniegelenk. Das chirurgische Spektrum beginnt mit einem arthroskopischen D&eacute;bridement oder Gl&auml;tten eines Meniskusrisses und reicht &uuml;ber die gelenkerhaltende Umstellung der Beinachse bis hin zum teilweisen oder vollst&auml;ndigen prothetischen Ersatz des Kniegelenks. Die Computernavigation geh&ouml;rt bei mir seit Jahren zum Standard bei der Knieprothetik. In Zusammenarbeit mit anderen Orthop&auml;den und der Industrie wirke ich sowohl national als auch international an den neusten Entwicklungen auf dem Gebiet der Prothetik, Instrumente und Operationstechniken mit und lasse die gewonnenen Erkenntnisse in meine t&auml;gliche Arbeit einfliessen. Immer mehr befasse ich mich mit der Behandlung von Komplikationen nach Knieprothesen wie Infektionen, schmerzhaften Lockerungen, Einsteifungen oder Instabilit&auml;ten zu.</p>\r\n\r\n<p>Bei der H&uuml;fte fokussiere ich mich im Wesentlichen auf die Behandlung der fortgeschrittenen Arthrose mit einer Totalprothese. Die von mir &uuml;bernommenen Methoden basieren auch hier auf den modernsten Techniken und Verfahren wie den zementfrei verankerten Prothesen mit keramischen Gleitpaarungen. Die weniger invasive Operationstechnik mit Schonung der Muskulatur und die Verbesserung&nbsp;</p>\r\n',0,'',0,'','',0,0,'Kompetenzen','Kompetenzen','Kompetenzen','1',NULL,NULL,'',0,0,0,1,1,'','access',''),(44,30,30,1,'content',0,'2015-03-13 12:42:35','webmaster@werbelinie.ch','Team','','Team','Team','<p>Um Ihnen die bestm&ouml;gliche und erfolgversprechendste Behandlung zu garantieren, arbeitet bei Christenortho ein eingespieltes und motiviertes Team zusammen. Langj&auml;hrige und gut ausgebildete Mitarbeiter sorgen f&uuml;r einen reibungslosen Ablauf - sowohl in administrativen, als auch in medizinischen Belangen.</p>\r\n',0,'content_team.html',1,'','',0,0,'Team','Team','Team','1',NULL,NULL,'',0,0,0,1,1,'','access',''),(45,31,31,1,'content',0,'2015-04-13 12:50:14','webmaster@werbelinie.ch','Praxis','','Praxis','Praxis','<section class=\"content-section\">\r\n<p>Unsere Praxisr&auml;umlichkeiten im Haus Elim im Salemspital, erreichen Sie &uuml;ber den Haupteingang, in Verl&auml;ngerung des Geschosses A1.&nbsp;Sie finden uns nach der Warte- und Empfangszone der orthop&auml;dischen Gemeinschaftspraxis ganz hinten, am Ende des Korridors.</p>\r\n\r\n<ul>\r\n	<li><a class=\"link-icon icon-link\" href=\"{NODE_22}\">Lageplan/Anreise</a></li>\r\n</ul>\r\n</section>\r\n\r\n<section class=\"lightbox-previews\">\r\n<figure class=\"lightbox-links\"><a data-lightbox=\"gallery-1\" data-title=\"Bild 1\" href=\"//fakeimg.pl/1000x720?text=Bild1\"><img alt=\"\" src=\"//fakeimg.pl/300?text=Bild Praxis\" /> </a>\r\n\r\n<figcaption>Bildbeschrieb</figcaption>\r\n</figure>\r\n\r\n<figure class=\"lightbox-links\"><a data-lightbox=\"gallery-1\" href=\"//fakeimg.pl/1000x500?text=Bild2\"><img alt=\"\" src=\"//fakeimg.pl/300?text=Bild Praxis\" /> </a>\r\n\r\n<figcaption>Bildbeschrieb</figcaption>\r\n</figure>\r\n\r\n<figure class=\"lightbox-links\"><a data-lightbox=\"gallery-1\" data-title=\"Bild 3\" href=\"//fakeimg.pl/1000?text=Bild3\"><img alt=\"\" src=\"//fakeimg.pl/300?text=Bild Praxis\" /> </a>\r\n\r\n<figcaption>Bildbeschrieb</figcaption>\r\n</figure>\r\n\r\n<figure class=\"lightbox-links\"><a data-lightbox=\"gallery-1\" data-title=\"Bild 4\" href=\"//fakeimg.pl/1000x1500?text=Bild4\"><img alt=\"\" src=\"//fakeimg.pl/300?text=Bild Praxis\" /> </a>\r\n\r\n<figcaption>Bildbeschrieb</figcaption>\r\n</figure>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2>Assistenz&auml;rzte bei CHRISTENORTHO AG</h2>\r\n\r\n<p>Seit dem 1. Januar 2008 werden bei CHRISTENORTHO AG Assistenz&auml;rzte ausgebildet, deren Ziel die Erlangung des Facharztes f&uuml;r Orthop&auml;die und Traumatologie des Bewegungsapparates ist.</p>\r\n\r\n<p>Vom 1. Januar 2010 bis 31. M&auml;rz 2013 fand bez&uuml;glich Weiterbildung eine enge Zusammenarbeit mit dem Bruderholzspital in Basel (Klinikleiter Prof. Dr. med. N. Friederich) statt. Am 1. Juli 2013 ist eine neue Kooperation mit der Orthop&auml;dischen Universit&auml;tsklinik des Inselspitals Bern angelaufen.</p>\r\n\r\n<p>Geeignete und interessierte Kandidaten absolvieren bis zu einem Jahr ihrer Weiterbildung bei CHRISTENORTHO AG und kehren dann ans Inselspital Bern zur&uuml;ck, um die Ausbildung zum Facharzt fort zu setzen. Die Assistenz&auml;rzte bei CHRISTENORTHO AG sind voll in den Praxisalltag integriert. Patienten werden ihnen in der Sprechstunde, auf der Abteilung oder auch im Operationssaal begegnen, gewisse Arbeiten werden an sie delegiert.</p>\r\n</section>\r\n',0,'content_praxis.html',1,'','',0,0,'Praxis','Praxis','Praxis','1',NULL,NULL,'',0,0,0,1,1,'','access',''),(46,32,32,1,'application',0,'2015-03-18 10:45:43','webmaster@werbelinie.ch','Infos / News','','Infos / News','Infos-News','<!-- BEGIN news_list --><!-- BEGIN newsrow --><div href=\"{NEWS_LINK_URL}\" class=\"news-teaser\"><div class=\"news-teaser-date\">{NEWS_DATE}</div><h3 class=\"news-teaser-title\">{NEWS_TITLE}</h3><p class=\"news-teaser-text\">{NEWS_TEASER}<a href=\"{NEWS_LINK_URL}\" class=\"icon-arrow\"></a></p></div><!-- END newsrow --><!-- END news_list -->',1,'',0,'','',0,0,'Infos / News','Infos / News','Infos / News','1',NULL,NULL,'',0,0,0,1,1,'','news',''),(47,33,33,1,'content',0,'2015-04-13 06:13:04','webmaster@werbelinie.ch','Terminvereinbarung','','Terminvereinbarung','Terminvereinbarung','<p>Sprechstunden finden nach telefonischer Vereinbarung in der Regel zweimal w&ouml;chentlich am Dienstag und Donnerstag und einmal monatlich nach Bedarf am Samstag statt. Anmeldungen erfolgen mit Vorteil via Ihren Hausarzt. Nat&uuml;rlich d&uuml;rfen Sie uns aber auch direkt kontaktieren!</p>\r\n\r\n<p>Zust&auml;ndig f&uuml;r die Praxisorganisation ist Frau Verena Vonallmen. Die Vergabe von Sprechstunden- und Operationsterminen erfolgen durch Frau <a href=\"{NODE_30}\">Verena von Allmen</a> und/oder Frau <a href=\"{NODE_30}\">Esther Wyler Christen</a>. Das ganze Praxisteam bem&uuml;ht sich, Sie kompetent, effizient und umsichtig zu betreuen.</p>\r\n\r\n<h2>Anmeldung, Termine und Sprechstunden</h2>\r\n\r\n<p>Wir sind f&uuml;r Sie telefonisch erreichbar unter:&nbsp;<a class=\"icon-phone link-icon\" href=\"#\">+41 31 337 89 24</a></p>\r\n\r\n<p><strong>Montag, Dienstag, Donnerstag und Freitag</strong><br />\r\n09:00 &ndash; 12:00 und 14:00 &ndash; 16:00 Uhr&nbsp;<br />\r\n<strong>Mittwoch</strong><br />\r\n09:00 &ndash; 12:00 Uhr</p>\r\n\r\n<p>Per E-Mail erreichen Sie uns unter:&nbsp;<a class=\"icon-mail link-icon\" href=\"mailto:info@christenortho.ch?subject=Anmeldung%20%2F%20Termin%20%2F%20Sprechstunde\">info@christenortho.ch</a></p>\r\n\r\n<p>Per Fax unter: +41 31 337 89 54</p>\r\n',0,'',0,'','',0,0,'Terminvereinbarung','Terminvereinbarung','Terminvereinbarung','1',NULL,NULL,'',0,0,0,1,1,'','access',''),(48,34,34,1,'content',0,'2015-04-13 06:13:31','webmaster@werbelinie.ch','Vorgehen','','Von der Diagnose zur Therapie ','Vorgehen','<h2>Diagnosestellung im Dialog</h2>\r\n\r\n<p>Ohne sichere oder zumindest wahrscheinliche Diagnose kann die Therapie nicht oder h&ouml;chstens zuf&auml;llig erfolgreich sein. Die Diagnosestellung erfolgt im pers&ouml;nlichen Gespr&auml;ch in der Praxis, wo ich Ihre Patientengeschichte, erg&auml;nzt mit gezielten Fragen, zu begreifen versuche. Die Untersuchung des betroffenen Gelenkes erh&auml;rtet den Verdacht. Untersuchungen wie R&ouml;ntgenbilder und Magnetresonanztomographie (MRI oder MRT), usw. dienen zur Erg&auml;nzung und der weiteren Konkretisierung.</p>\r\n\r\n<p>Abh&auml;ngig von der Diagnose kann ich Ihnen L&ouml;sungsans&auml;tze aufzeigen. Dabei er&ouml;rtere ich die diversen Therapiem&ouml;glichkeiten und zeige die Vor- und Nachteile (Chancen &amp; Risiken) auf. Das Ganze ist immer im Dialog gehalten, damit eine auf Sie pers&ouml;nlich abgestimmte optimale Therapieform heraus kristallisiert werden kann.</p>\r\n\r\n<h2>Der Arzt ber&auml;t, Patienten bestimmen</h2>\r\n\r\n<p>Obwohl ich in erster Linie orthop&auml;discher Chirurg bin und die meiste Zeit meiner Ausbildung f&uuml;r die chirurgische T&auml;tigkeit aufgewendet habe, wird nur ein kleiner Teil der zu mir in die Sprechstunden kommenden Patienten operiert. Die Operation, auch wenn sie noch so klein scheint, ist verbunden mit Risiken und ist nur dann zu rechtfertigen, wenn eine gute Aussicht auf Erfolg besteht und die konservative Behandlung keine Alternative mehr darstellt. Bei einem Wahleingriff steht der Entscheid f&uuml;r oder gegen eine Operation somit nur Ihnen zu!</p>\r\n\r\n<h2>Komplikationen</h2>\r\n\r\n<p>Jede noch so kleine Behandlung kann Komplikationen nach sich ziehen. Meistens unterliegt dann das bisher gute Patienten-Arztvertrauen einem ersten H&auml;rtetest. Ich setze auch hier auf das offene Gespr&auml;ch. Gemeinsam w&auml;gen wir ab und er&ouml;rtern das weitere Vorgehen. Ich werde auch hier versuchen, Ihnen unter Abw&auml;gung der Daf&uuml;r und Dagegen aufzuzeigen, welche Optionen bestehen. Zum obersten Ziel wird, die Komplikation m&ouml;glichst folgenlos zu meistern und gemeinsam das beste Resultat zu erreichen.</p>\r\n\r\n<h2>Die Vorbereitung und die Nachbehandlung</h2>\r\n\r\n<p>Dem Vorher und dem Nachher muss bei Operationen besondere Beachtung geschenkt werden. Somit ist es unabdingbar, dass Sie ihr privates und berufliches Umfeld (R&uuml;cksprache mit dem Arbeitgeber!) vor einem Eingriff optimal einrichten. Wenn Ihnen gewisse Jahreszeiten, Mondphasen oder Sonstiges wichtig sind, werden wir das wenn irgend m&ouml;glich gerne ber&uuml;cksichtigen.</p>\r\n\r\n<p>Die eingeleitete Behandlung aber auch die Nachbehandlung im Anschluss an die Operation m&uuml;ssen konsequent &uuml;berwacht werden. Einem sich m&ouml;glicherweise abzeichnenden Misserfolg kann so rechtzeitig begegnet werden. Dies erfordert einige gezielte Kontrollen bei mir, ausserdem wird auch Ihr Hausarzt bereits fr&uuml;h nach der Spitalentlassung in die Nachbehandlung einbezogen.</p>\r\n',0,'',0,'','',0,0,'Vorgehen','Vorgehen','Vorgehen','1',NULL,NULL,'',0,0,0,1,1,'','access',''),(49,35,35,1,'content',0,'2015-04-10 12:47:52','webmaster@werbelinie.ch','Wissenswertes','','Wissenswertes','Wissenswertes','<p>Hier finden Interessierte Wissenswertes und Allgemeine Informationen unter anderem zu Themen wie: Spitalaufenthalt, An&auml;sthesie, Operationsrisiken und vielem mehr. Bei Fragen oder Unklarheiten stehen wir jederzeit gerne zur Verf&uuml;gung.<br />\r\n&nbsp;</p>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Allgemeine Operationsrisiken</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"/media/archive1/Wissenswertes/Allgemeine_Operationsrisiken.pdf\" target=\"_blank\">Allgemeine&nbsp;Operationsrisiken</a></li>\r\n</ul>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">An&auml;sthesie (Narkose) und Analgesie (Schmerzfreiheit)</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"/media/archive1/Wissenswertes/Anaesthesie_und_Analgesie.pdf\" target=\"_blank\">An&auml;sthesie und Analgesie</a></li>\r\n</ul>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Angst vor der Operation? Eigenhypnose hilft!</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Eine Operation mit oder ohne Bewusstseins-verlust w&auml;hrend der Narkose macht Angst. Viele Menschen haben deshalb vor operativen Eingriffen Angst. Die &Auml;ngste k&ouml;nnen&hellip;</p>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"/media/archive1/Wissenswertes/Angst_vor_der_Operation_und_Narkose.pdf\" target=\"_blank\">Angst&nbsp;vor&nbsp;der&nbsp;Operation&nbsp;und&nbsp;Narkose</a></li>\r\n</ul>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Aufkl&auml;rung</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Die angemessene Aufkl&auml;rung &uuml;ber einen bevorstehenden Eingriff (= Eingriffsaufkl&auml;rung) und die Massnahmen zur Sicherstellung eines Therapieerfolges (= Sicherungsaufkl&auml;rung) ist gesetzlich im KVG&hellip;</p>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"/media/archive1/Wissenswertes/Aufklaerung.pdf\" target=\"_blank\">Aufkl&auml;rung</a></li>\r\n</ul>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">XXX Aufkl&auml;rungsprotokolle (diverse) XXX</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>An dieser Stelle finden Sie die diversen, standardisierten&nbsp;Aufkl&auml;rungsprotokolle, welche bei CHRISTENORTHO AG in Gebrauch sind. Selbstverst&auml;ndlich werden sie anl&auml;sslich des Gespr&auml;ches vor einem Eingriff individuell angepasst und erl&auml;utert.</p>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"/media/archive1/Wissenswertes/Allgemeine_Operationsrisiken.pdf\" target=\"_blank\">Kommt hier ein PDF</a></li>\r\n</ul>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Einverst&auml;ndniserkl&auml;rung </a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"/media/archive1/Wissenswertes/Einverstaendniserklaerung.pdf\" target=\"_blank\">Einverst&auml;ndniserkl&auml;rung</a></li>\r\n</ul>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">XXX H&auml;ufig gestellte Fragen (FAQ) XXX</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Im Zusammenhang mit der Abkl&auml;rung und Behandlung von Erkrankungen oder Verletzungen am Bewegungsapparat kommen immer wieder Fragen auf, welche an dieser Stelle&nbsp;zeitlich nach Phase (z.B. Fragen zur Operation)etwas&nbsp;geordnet beantwortet werden.</p>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"/media/archive1/Wissenswertes/Allgemeine_Operationsrisiken.pdf\" target=\"_blank\">Kommt hier ein PDF</a></li>\r\n</ul>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Informationen zum Spitalaufenthalt</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Die folgenden Informationen sollen Ihnen helfen, sich f&uuml;r Ihren Spitalaufenthalt optimal vorzubereiten. Sollten Sie dennoch Fragen zum Ablauf haben, k&ouml;nnen Sie diese beim Eintritt stellen. Es ist uns&hellip;</p>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"/media/archive1/Wissenswertes/Informationen_zum_Spitalaufenthalt.pdf\" target=\"_blank\">Informationen&nbsp;zum&nbsp;Spitalaufenthalt</a></li>\r\n</ul>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Orthop&auml;die</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Unter Orthop&auml;die verstehen wir heute die Lehre der konservativen und operativen Behandlung von Missbildungen, Krankheiten und Verletzungen am Bewegungsapparat. Der Orthop&auml;de ist somit ein auf den&hellip;</p>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"/media/archive1/Wissenswertes/Orthopaedie.pdf\" target=\"_blank\">Orthop&auml;die</a></li>\r\n</ul>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Physiotherapie</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Die richtigen physiotherapeutischen Massnahmen im Anschluss an eine Operation sind f&uuml;r die rasche Wiederherstellung der Gelenkfunktion und Gehf&auml;higkeit wichtig. Der Einsatz einer gezielten physiotherapeutischen Behandlung kann Schmerzen lindern, Funktionsst&ouml;rungen beseitigen und den Rehabilitationsprozess nach Erkrankungen, Unf&auml;llen und Operationen am Bewegungsapparat positiv beeinflussen.<br />\r\nAus sprichw&ouml;rtlich nahe liegenden Gr&uuml;nden &ndash; die Physiotherapie befindet sich unweit unserer Praxis im Geschoss A0 des Salemspitalhauptgeb&auml;udes - arbeiten wir von christenortho eng mit dem Therapie- und Trainings Zentrum Bern (TTZ Bern) zusammen.<br />\r\nDas TTZ Bern erm&ouml;glicht Patienten und Interessierten die Nutzung eines vielf&auml;ltigen Angebots im Bereich Therapie, Training und Pr&auml;vention. Patienten finden hier eine pers&ouml;nliche und professionelle und in Absprache mit christenortho auf sie abgestimmte physiotherapeutische Betreuung in angenehmer Atmosph&auml;re.<br />\r\nNat&uuml;rlich d&uuml;rfen und k&ouml;nnen unsere Patienten den Physiotherapeuten oder die physiotherapeutische Praxis frei w&auml;hlen. Wir beraten Sie bei Bedarf gerne!<br />\r\n<br />\r\n<a class=\"icon-link link-icon\" href=\"http://www.training-zollikofen.ch/\" target=\"_blank\">Website TTZ Bern</a></p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Prothetik</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Als Prothetik bezeichnet man die Lehre &uuml;ber den Organersatz, welche sich mit der Entwicklung, Herstellung und Implantation von Prothesen im lebendigen Gewebe befasst. Bei meiner T&auml;tigkeit mit den drei Gelenken Knie, Schulter und H&uuml;fte steht die Behandlung von degenerativen Sch&auml;den und damit der Arthrose an erster und oberster Stelle. Die letzte operative Behandlungsm&ouml;glichkeit stellt h&auml;ufig der Ersatz der Gelenkoberfl&auml;chen durch eine so genannte Gelenkprothese dar. Die Prothetik in der Orthop&auml;die befasst sich mit technischen Fragen zum Material (Verankerung, Biovertr&auml;glichkeit, Oberfl&auml;che und Reibung = Tribologie), zur Biomechanik und Kinematik (Bewegung und Funktionsweise) eines Gelenkes. Spezifische Operationstechniken geh&ouml;ren ebenso zur Prothetik wie Fragen zur Ausbildung, Logistik (Lagerhaltung, Sterilisation, Bestellwesen), Qualit&auml;tskontrolle bis hin zur Ethik</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Traumatologie</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Unter Traumatologie verstehen wir die Lehre der Diagnose und Behandlung von Verletzungen und Verletzungsfolgen&hellip;</p>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"/media/archive1/Wissenswertes/Traumatologie.pdf\" target=\"_blank\">Traumatologie</a></li>\r\n</ul>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">XXX Zahlen und Statistik 2014 XXX</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Hier finden Sie Angaben zur Zahl der durch mich durchgef&uuml;hrten Eingriffe. sie sind nach anatomischen Regionen (z.B. Knie, H&uuml;fte, usw.) und nach Eingriffsarten (z.B. Kniearthroskopie, Prothesen, usw.) aufgeschl&uuml;sselt und erlauben immer auch den Vergleich mit den Vorjahren.</p>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"/media/archive1/Wissenswertes/Allgemeine_Operationsrisiken.pdf\" target=\"_blank\">Kommt hier ein PDF</a></li>\r\n</ul>\r\n</div>\r\n',0,'',0,'','',0,0,'Wissenswertes','Wissenswertes','Wissenswertes','1',NULL,NULL,'',0,0,0,1,1,'','access',''),(50,36,36,1,'content',0,'2015-04-10 12:52:15','webmaster@werbelinie.ch','Fragen & Antworten','','Fragen & Antworten','Fragen-Antworten','<p>&nbsp;</p>\r\n\r\n<h2>Fragen zur geplanten Operation</h2>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Riss / Verletzung / L&auml;sion / Ruptur der Rotatorenmanschette</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Teilweiser oder kompletter Einriss einer oder mehrerer Sehnen der Rotatorenmanschette. In erster Linie verursachen diese Sch&auml;den Schmerzen. Je nach Ort der L&auml;sion kommen Funktionsdefizite hinzu.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Bei mir sind noch Fragen aufgetaucht, wann kann ich sie stellen?</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Jederzeit! Melden Sie sich bei Unklarheiten per Telefon oder vereinbaren Sie noch einmal einen Sprechstundentermin.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Was oder wie w&uuml;rden Sie an meiner Stelle entscheiden?</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Den Entscheid zu oder gegen eine Behandlung kann Ihnen niemand abnehmen. Nur Sie k&ouml;nnen aufgrund Ihrer Schmerzen, Einschr&auml;nkungen usw. zum richtigen Entscheid &uuml;ber das was, wann, wo und wie kommen. Ich kann Ihnen lediglich wichtige Entscheidungsgrundlagen liefern, indem ich Sie &uuml;ber die M&ouml;glichkeiten, Chancen und Risiken einer Therapie aufkl&auml;re.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Darf ich mir das noch &uuml;berlegen?</a></h3>\r\n\r\n<div class=\"accordion-container\">Selbstverst&auml;ndlich! Jeder Entscheid zu einer Operation will reiflich &uuml;berlegt sein. Dies gelingt am besten in den eigenen vier W&auml;nden ohne Beeinflussung durch Fremde oder einen Arzt.\r\n<p>&nbsp;</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Darf ich nach dem Entscheid f&uuml;r eine Operation noch einmal zu einer Besprechung kommen?</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Ja, jederzeit k&ouml;nnen telefonisch Termine zur Operationsbesprechung vereinbart werden, damit alle offenen Fragen gekl&auml;rt werden k&ouml;nnen.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Operieren Sie mich selber?</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Ja, wenn ich die Behandlung &uuml;bernehme, werde ich Sie pers&ouml;nlich operieren. Zu Ausbildungszwecken werde ich allenfalls einige Schritte meinem Assistenten in Ausbildung assistieren, trage aber immer die ausschliessliche Verantwortung.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Besuchen Sie mich vor der Operation noch in meinem Zimmer?</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Bei Eintritt am Operationstag werden Sie mich erst im Operationssaal sehen. Falls Sie am Vortag eintreten, werde ich Sie in aller Regel gegen Abend besuchen. Dies bietet Ihnen Gelegenheit, noch offene Fragen beantworten zu lassen.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Wie kann ich sicherstellen, dass die richtige Seite operiert wird?</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Sie erhalten beim Spitaleintritt von der Pflege einen wasserfesten Filzstift und m&uuml;ssen sich auf der richtigen Stelle mit einem Kreuz markieren. Bei Operationen in Regionalan&auml;sthesie werden Sie zudem noch einmal darauf angesprochen.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Ist es m&ouml;glich, dass mein K&ouml;rper die Prothese abst&ouml;sst?</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Grunds&auml;tzlich nein. Die Metall- und Kunststoffteile sind zwar Fremdk&ouml;rper, Allergien gegen einzelne Bestandteile sind aber &auml;usserst selten (Sch&auml;tzungen sprechen von 1: 1&#39;000&#39;000). Bei einer nachgewiesenen Allergie auf Nickel oder Chrom, wird man dennoch eine Prothese ohne diese Metalle w&auml;hlen.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Welche Risiken bestehen bei dieser Operation?</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Allgemeine Risiken finden Sie auf dieser Homepage unter &bdquo;Allgemeines&ldquo; aufgelistet. Auf spezifische Risiken wird bei jedem Eingriff auf www.christenortho.ch im Detail eingegangen, sie sind auch auf dem Aufkl&auml;rungsblatt aufgelistet.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Ich habe Angst vor der Operation/ An&auml;sthesie, was kann ich dagegen tun?</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Wenn die Angst derart ausgepr&auml;gt ist, dass man sich eine Operation oder Narkose nicht zutraut oder sie einen l&auml;hmt, dann sollte man Hilfe in Anspruch nehmen. Ausgezeichnet hilft die Eigenhypnose, welche &Auml;ngste abbauen hilft und eine optimale Einstellung zur Operation, Narkose und Nachbehandlung erm&ouml;glicht. Im Salemspital bietet Herr Werner Nink derartige Instruktionen an, begleitet Sie bei Bedarf auch im Operationssaal, da er gleichzeitig An&auml;sthesiepflegefachmann ist. Informationen und Anmeldungen zum Gespr&auml;ch sind m&ouml;glich unter <a class=\"icon-link link-icon\" href=\"http://www.ninkcoaching.ch\" target=\"_blank\">www.ninkcoaching.ch</a> oder unter Telefon <a class=\"icon-phone link-icon\" href=\"#\">076 562 35 06</a>.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Wie lange muss ich im Spital bleiben?</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Der Spitalaufenthalt richtet sich nach der Gr&ouml;sse der Operation, nach Ihren Schmerzen, der erreichten Funktion sowie Ihren pers&ouml;nlichen Voraussetzungen. Der Entscheid Ihrer Entlassung nach Hause oder auch in eine Kur, respektive Rehabilitation erfolgt in gegenseitiger Absprache zwischen Ihnen und mir.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Was versteht man unter Prothetik?</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Als Prothetik bezeichnet man die Lehre &uuml;ber den Organersatz, welche sich mit der Entwicklung, Herstellung und Implantation von Prothesen im lebendigen Gewebe befasst. Die Prothetik in der Orthop&auml;die befasst sich mit technischen Fragen zum Material (Verankerung, Biovertr&auml;glichkeit, Oberfl&auml;che und Reibung = Tribologie), zur Biomechanik und Kinematik (Bewegung und Funktionsweise) eines Gelenkes. Spezifische Operationstechniken geh&ouml;ren ebenso zur Prothetik wie Fragen zur Ausbildung, Logistik (Lagerhaltung, Sterilisation, Bestellwesen), Qualit&auml;tskontrolle bis hin zur Ethik.</p>\r\n</div>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h2>Administrative Fragen</h2>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Kann ich als Allgemein Versicherter im Salemspital behandelt werden?</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Ja, bis heute ist das ohne weiteres m&ouml;glich. Falls Sie nicht aus dem Kanton Bern stammen m&uuml;ssen Sie minimal Allgemein ganze Schweiz versichert sein. Bei Patienten aus dem Kanton Bern bestehen keinerlei Einschr&auml;nkungen.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Muss ich die Versicherung informieren?</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Nein. Wenn Sie sich bei und zu einer Operation anmelden, wird die Patientenaufnahme des Salemspitals rechtzeitig Kontakt mit Ihrer Krankenkasse/ Unfallversicherung aufnehmen und eine Kostengutsprache f&uuml;r die geplante Behandlung einfordern. Sie werden nur ins Spital aufgeboten, falls diese Kostengutsprache geleistet worden ist.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Wie soll ich meinen Arbeitgeber informieren?</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Am besten sprechen Sie einen Operationstermin rechtzeitig mit Ihrem Arbeitgeber ab, insbesondere wenn nach dem Eingriff eine Arbeitunf&auml;higkeit resultiert.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Wer best&auml;tigt mir die Arbeitsunf&auml;higkeit?</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Dies erfolgt nach einer Operation durch christenortho. Sie erhalten beim Spitalaustritt bei Bedarf ein Zeugnis f&uuml;r den Arbeitgeber, eine Unfallkarte wird ebenfalls bei der Entlassung ausgef&uuml;llt.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Werde ich durch das Salemspital informiert, dass bei mir eine Operation geplant ist und ein Bett reserviert wird?</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Ja, Sie werden den in der Praxis vereinbarten Operationstermin durch das Salemspital best&auml;tigt erhalten und schriftlich aufgeboten, nachdem die Administration von Ihrer Krankenkasse oder Unfallversicherung die eingeforderte Kostengutsprache erhalten hat. Im Aufgebot sind Informationen des Salemspitals beigelegt, was Sie f&uuml;r Ihren Spitalaufenthalt mitnehmen und beachten sollen. Sie erhalten zus&auml;tzlich ein Formular der An&auml;sthesie mit Fragen zu Ihrem Gesundheitszustand. Wollen Sie bitte das ausgef&uuml;llte und unterschriebene Formular ins Spital mitbringen.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Ist das Operationsdatum verbindlich, oder kann es sein, dass es verschoben wird?</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>In aller Regel ist das Operationsdatum verbindlich. Ausnahmef&auml;lle sind nicht voraussehbar, k&ouml;nnen aber bei Notf&auml;llen, Krankheitsausf&auml;llen etc. vorkommen. Wir werden uns bem&uuml;hen, Sie rechtzeitig von &Auml;nderungen in Kenntnis zu setzen.</p>\r\n</div>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h2>Fragen zur Operationsvorbereitung</h2>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Warum muss ich die Voruntersuchungen beim Hausarzt durchf&uuml;hren lassen?</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Damit dieser in den Behandlungsprozess rechtzeitig eingebunden ist und so auch den Operationstermin erf&auml;hrt. Ausserdem kann der Hausarzt uns wichtige medizinische Zusatzinformationen weiter leiten.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Darf ich das Aspirin cardio&reg; weiter einnehmen?</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Ja, meistens ist das Absetzen dieses Medikamentes nicht erforderlich, da die Risiken nach dem Absetzen h&ouml;her sind als wenn Aspirin weiter eingenommen wird.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Ich bin blutverd&uuml;nnt, wie muss ich mich verhalten?</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Die Antikoagulation mit z.B. Sintrom&reg; oder Marcoumar&reg; muss rechtzeitig aufgehoben und mit z.B. Fraxiparine&reg;-Spritzen ersetzt werden. Die Umstellung erfolgt etwa 10 Tage vor der Operation, am besten setzten Sie sich mit Ihrem Hausarzt in Verbindung.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Ich bin Diabetiker, wie muss ich mich verhalten?</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Falls Sie Insulin spritzen, informieren Sie sich bitte rechtzeitig bei Ihrem Hausarzt oder unseren An&auml;sthesisten (Zentrale Salemspital <a class=\"icon-phone link-icon\" href=\"#\">031 337 60 00</a>, Tagesarzt An&auml;sthesie verlangen).</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Darf ich meine Medikamente am morgen vor der Operation auf n&uuml;chternen Magen einnehmen?</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Ja, die Einnahme Ihrer Medikamente, welche Sie regelm&auml;ssig ben&ouml;tigen, sollte nicht ausgesetzt werden. Sie k&ouml;nnen die Tabletten mit einigen Schlucken Wasser einnehmen.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Muss ich meine gef&auml;rbten oder k&uuml;nstlichen Fingern&auml;gel f&uuml;r die Operation in den nat&uuml;rlichen Zustand zur&uuml;ckf&uuml;hren?</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Nein, dies ist auch bei Operationen an der Schulter oder am Ellbogen nicht erforderlich.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Muss ich Gehst&ouml;cke mitbringen?</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Falls vorhanden oder falls Sie ein spezielles Modell w&uuml;nschen ja. Ansonsten k&ouml;nnen Ihnen St&ouml;cke auch im Spital nach der Operation abgegeben werden.</p>\r\n</div>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h2>Fragen zur An&auml;sthesie/ Narkose</h2>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Was f&uuml;r eine Narkoseform erhalte ich?</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Diese Frage wollen Sie bitte mit dem daf&uuml;r verantwortlichen An&auml;sthesisten am Eintrittstag im Spital besprechen. Eingriffe an den Extremit&auml;ten werden h&auml;ufig in so genannter Regionalan&auml;sthesie (z.B. Spinal- oder Plexusan&auml;sthesie) vorgenommen, bei den Schulteroperationen werden Sie meistens zus&auml;tzlich schlafen.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Lerne ich den An&auml;sthesisten kennen?</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Ja, bei Eintritt am Vortag, wird der An&auml;sthesist sie im Laufe des Nachmittags besuchen und Sie &uuml;ber Ihren allgemeinen Gesundheitszustand abfragen und die An&auml;sthesieart besprechen. Treten Sie am Operationstag ein, findet das Gespr&auml;ch kurz vor dem Eingriff statt.</p>\r\n</div>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h2>Fragen zur Nachbehandlung</h2>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Muss ich in die Therapie, beginnt diese schon im Spital?</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Ja, nach den meisten Operationen beginnt die Physiotherapie bereits fr&uuml;h nach der Operation im Spital. Falls n&ouml;tig, wird Ihnen f&uuml;r die ambulante Behandlung ein Rezept f&uuml;r die ersten 9 Sitzungen durch christenortho abgegeben.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Muss ich ins Salemspital zur Therapie oder kann ich sie in der N&auml;he meines Wohnortes aufsuchen?</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Grunds&auml;tzlich sind Sie in der Wahl der Physiotherapie-Institution frei. Bei aufw&auml;ndigen F&auml;llen werde ich Ihren Entscheid m&ouml;glicherweise beeinflussen.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Werden weitere notwendige Therapie-Verordnungen durch Sie oder den Hausarzt ausgestellt?</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>In der Regel werden weitere Therapie-Verordnungen nach der Operation durch christenortho ausgestellt. Diese k&ouml;nnen jederzeit telefonisch bei uns angefordert werden.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Kann ich nach dem Spitalaufenthalt in einer Rehabilitation oder eine Kur? Wer meldet mich an?</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Station&auml;re Nachbehandlungen werden durch die Krankenkassen immer weniger bewilligt und bezahlt. Falls es bei Ihnen gute medizinische Gr&uuml;nde f&uuml;r eine Rehabilitation gibt, werden wir das f&uuml;r Sie organisieren lassen (kostenpflichtiger Sozialdienst Salemspital).</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Wird die Spitex durch Sie angemeldet?</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Nein, die Anmeldung erfolgt durch den Patienten direkt, die Spitex wird uns das entsprechende Formular zur R&uuml;ckerstattung durch die Krankenkasse zustellen.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Wann darf ich nach der Operation wieder selbst&auml;ndig duschen?</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Ist die Wunde trocken, kann sie mit einer Folie abgedeckt werden, die das Duschen erlaubt.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Wer entfernt die Hautf&auml;den?</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>In aller Regel werden Sie dazu an den Hausarzt verwiesen. Den Zeitpunkt der Fadenentfernung erfahren Sie von mir beim Spitalaustritt. In Ausnahmef&auml;llen k&ouml;nnen die F&auml;den auch bei christenortho entfernt werden.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Wann muss ich in die Kontrolle?</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Sie erhalten bei Austritt von mir einen Terminvorschlag, wann die erste Nachkontrolle bei uns in der Sprechstunde, allenfalls mit vorg&auml;ngigem R&ouml;ntgenbild, vorgesehen ist.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Wie lange kann ich nicht arbeiten?</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Dies h&auml;ngt vom Eingriff und Ihrer T&auml;tigkeit ab. Sprechen Sie dies mit mir direkt ab.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Darf ich nach der Operation Auto fahren?</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Dies h&auml;ngt von der Eingriffsart und Lokalisation ab. Sie finden detaillierte Informationen auf der Homepage www.christenortho.ch. Allf&auml;llige Einschr&auml;nkungen sind in jedem Fall einzuhalten, da Sie bei Zuwiderhandlung durch Ihre Versicherung nicht oder mit Einschr&auml;nkungen abgedeckt sind!</p>\r\n</div>\r\n\r\n<p>&nbsp;</p>\r\n',0,'',0,'','',0,0,'Fragen & Antworten','Fragen & Antworten','www.ninkcoaching.ch','1',NULL,NULL,'',0,0,0,1,1,'','access',''),(51,37,37,1,'content',0,'2015-04-13 06:34:52','webmaster@werbelinie.ch','Presseberichte','','Presseberichte','Presseberichte','<p>Hier finden Sie zusammengestellte Presseartikel und Interviews, welche sich zum Teil mit konkreten Themen aus dem Bereich der Orthop&auml;die, teilweise mehr mit aktuellen politischen Diskussionen auseinander setzen.</p>\r\n\r\n<section class=\"content-section\">\r\n<h2 class=\"content-section-title\">Schweizer &Auml;rzte greifen im Zweifel zum Skalpell</h2>\r\n\r\n<p class=\"content-section-meta\">Medium: Berner Zeitung,&nbsp;Ver&ouml;ffentlichung: 24.09.2014</p>\r\n\r\n<p><a href=\"http://www.bernerzeitung.ch/schweiz/standard/Schweizer-Aerzte-greifen-im-Zweifel-zum-Skalpell/story/12275394\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Teaser_Presse/bzbericht.gif\" /></a>Nehmen &Auml;rzte und Spit&auml;ler hierzulande unn&ouml;tige Eingriffe vor? Dieser schwere Vorwurf wird in letzter Zeit immer &ouml;fter erhoben. Besonders unter Verdacht stehen die Orthop&auml;den.</p>\r\n\r\n<ul>\r\n	<li><a class=\"icon-link link-icon\" href=\"http://www.bernerzeitung.ch/schweiz/standard/Schweizer-Aerzte-greifen-im-Zweifel-zum-Skalpell/story/12275394\" target=\"_blank\">Bericht lesen</a><br />\r\n	&nbsp;</li>\r\n</ul>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2 class=\"content-section-title\">Nicht alle Operationen sind n&ouml;tig</h2>\r\n\r\n<p class=\"content-section-meta\">Medium: NZZ am Sonntag,&nbsp;Ver&ouml;ffentlichung: 25.08.2013</p>\r\n\r\n<p><a href=\"/media/archive1/Artikel_Presse/NZZ_August_2013.pdf\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Teaser_Presse/Nzz.bmp\" /></a>Es besteht der Verdacht, dass auch in der Schweiz zumTeil unn&ouml;tig operiert wird. Die Einf&uuml;hrung der Fallpauschalen in den Spit&auml;lern d&uuml;rfte das Problem versch&auml;rft haben...</p>\r\n\r\n<ul>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"/media/archive1/Artikel_Presse/NZZ_August_2013.pdf\" target=\"_blank\">Bericht lesen</a><br />\r\n	&nbsp;</li>\r\n</ul>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2 class=\"content-section-title\">Billigprothesen in der Orthop&auml;die und DRG</h2>\r\n\r\n<p class=\"content-section-meta\">Medium: MEDIAPLANET,&nbsp;Ver&ouml;ffentlichung: 15.09.2012</p>\r\n\r\n<p><a href=\"/media/archive1/Artikel_Presse/Orthopaedie_3.pdf\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Teaser_Presse/Orthopaedie_NR3.jpg\" /></a>Die Preise f&uuml;r die Implantate verschlingen schon heute einen erheblichen Teil der jeweiligen DRG Pauschale...</p>\r\n\r\n<p><a class=\"icon-pdf link-icon\" href=\"/media/archive1/Artikel_Presse/Orthopaedie_3.pdf\" target=\"_blank\">Bericht lesen</a></p>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2 class=\"content-section-title\">Schwierige Ausganslage f&uuml;r Revisionoperationen</h2>\r\n\r\n<p class=\"content-section-meta\">Medium: MEDIAPLANET,&nbsp;Ver&ouml;ffentlichung: 15.06.2011</p>\r\n\r\n<p><a href=\"/media/archive1/Artikel_Presse/Orthopaedie_4.pdf\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Teaser_Presse/Orthopaedie_NR4.jpg\" /></a>F&uuml;r viele ist ein k&uuml;nstliches Gelenk eine Erl&ouml;sung von Schmerzen und Einschr&auml;nkungen. Doch bei rund 20 Prozent der Patienten treten nach der Operation Komplikationen auf oder sie sind mit ihrem neuen Gelenk nicht zufrieden. Sie unterziehen sich oft einer Revisionsoperation. H&auml;ufige Ursachen hierf&uuml;r sind technische Fehler, Infektionen oder mechanische Probleme.</p>\r\n\r\n<ul>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"/media/archive1/Artikel_Presse/Orthopaedie_4.pdf\" target=\"_blank\">Bericht lesen</a></li>\r\n</ul>\r\n</section>\r\n',0,'',0,'','',0,0,'Presseberichte','Presseberichte','Presseberichte','1',NULL,NULL,'',0,0,0,1,1,'','access',''),(52,38,38,1,'content',0,'2015-04-13 06:40:14','webmaster@werbelinie.ch','TV-Auftritte','','TV-Auftritte','TV-Auftritte','<p>Hier finden Sie eine Zusammenstellung von diversen Fernsehauftritten, welche ich in den letzten Jahren &ndash; meistens zum Thema Kniegelenk / Knieprothese &ndash; hatte. Die Beitr&auml;ge sind auch direkt im Kapital Kniegelenk abrufbar. Die Informationen sind bruchst&uuml;ckhaft und plakativ und sind deshalb als Erg&auml;nzung zu den schriftlichen Angaben zu den einzelnen Themen dieser Webseite gedacht. Zusammen mit Ausk&uuml;nften von Patienten geben sie aber eine wertvolle pers&ouml;nliche Einsch&auml;tzung ab. Ich w&uuml;nsche gute Unterhaltung und vor allem eine wertvolle erg&auml;nzende Information.</p>\r\n\r\n<section class=\"content-section\">\r\n<h2 class=\"content-section-title\">Computernavigation in der Knieprothetik</h2>\r\n\r\n<p class=\"content-section-meta\">TV-Sendung: TeleB&auml;rn / praxis gsundheit,&nbsp;Ausstrahlung: 01.09.2014</p>\r\n\r\n<p><a href=\"http://www.santemedia.ch/de/medizinische-sendungen.1193/praxis-gsundheit-telebarn.1668/computernavigation-in-der-knieprothetik.2132.html\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Teaser_TV/Computernavigation_Knieprothetik.jpg\" /></a>Die Computernavigation in der Orthop&auml;die bedeutet das Einbringen eines k&uuml;nstlichen Gelenkes unter Zuhilfenahme eines Computersystems. Dieses System hilft dem Operateur, die einzelnen Komponenten der Knieprothese sehr genau zu platzieren. Ein neues Computernavigationsystem bezieht nun die B&auml;nder und Weichteile mit ein. Wie ist die Anwendung? Was sind die Vorteile? Und was ist die Knieprothetik?</p>\r\n\r\n<ul>\r\n	<li><a class=\"icon-movie link-icon\" href=\"http://www.santemedia.ch/de/medizinische-sendungen.1193/praxis-gsundheit-telebarn.1668/computernavigation-in-der-knieprothetik.2132.html\" target=\"_blank\">Video anschauen</a>&nbsp;&nbsp;</li>\r\n	<li><a class=\"icon-link link-icon\" href=\"{NODE_23}\">Erg&auml;nzende Themen</a></li>\r\n</ul>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2 class=\"content-section-title\">XXX Risiko ungeeignete Implantate XXX</h2>\r\n\r\n<p class=\"content-section-meta\">TV-Sendung: Teleb&auml;rn / medizin-tv, Ausstrahlung: 01.10.2012</p>\r\n\r\n<p><a href=\"http://www.santemedia.ch/de/gesundheitspolitische-sendungen.1194/2011-12.1273/risiko-ungeeignete-implantate.1618.html\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Teaser_TV/Ungeeignete_Implantate.jpg\" /></a>Spit&auml;ler dr&auml;ngen ihre &Auml;rzte aus Spardruck dazu, g&uuml;nstige und ungeeignete Implantate einzusetzen. Nun wehrt sich die Schweizerische Gesellschaft f&uuml;r Orthop&auml;die und Traumatologie SGOT-SSOT. Die &Auml;rzte warnen vor Qualit&auml;tsverlust und dem erh&ouml;hten Risiko vor Komplikationen.</p>\r\n\r\n<ul>\r\n	<li><a class=\"icon-movie link-icon\" href=\"http://www.santemedia.ch/de/gesundheitspolitische-sendungen.1194/2011-12.1273/risiko-ungeeignete-implantate.1618.html\" target=\"_blank\">Video anschauen</a>&nbsp;(Video nicht mehr abrufbar)</li>\r\n</ul>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2 class=\"content-section-title\">F&uuml;r ganze Knieprothesen m&ouml;glichst lange warten</h2>\r\n\r\n<p class=\"content-section-meta\">TV-Sendung: SRF1 / Puls, Ausstrahlung: 10.09.2012</p>\r\n\r\n<p><a href=\"http://www.srf.ch/sendungen/puls/kniegelenkersatz-schnarchen-babyschwimmen-versuchskaninchen\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Teaser_TV/Ganze_Knieprothesen.jpg\" /></a>&Uuml;ber 15&#39;000 Kniegelenksprothesen werden in der Schweiz pro Jahr eingesetzt. Meist verringern sich dadurch die akuten Gelenkschmerzen. Wer sollte sich behandeln lassen? Welche Erwartungen sind realistisch?</p>\r\n\r\n<ul>\r\n	<li><a class=\"icon-movie link-icon\" href=\"http://www.srf.ch/sendungen/puls/kniegelenkersatz-schnarchen-babyschwimmen-versuchskaninchen\" target=\"_blank\">Video anschauen</a></li>\r\n	<li><a class=\"icon-link link-icon\" href=\"{NODE_23}\">Erg&auml;nzende Themen</a></li>\r\n</ul>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2 class=\"content-section-title\">Die Knie-Totalprothese, ein Fernsehbeitrag</h2>\r\n\r\n<p class=\"content-section-meta\">TV-Sendung: Teleb&auml;rn / Medizin Aktuell,&nbsp;Ausstrahlung: 09.01.2008</p>\r\n\r\n<ul>\r\n	<li><a href=\"http://www.srf.ch/sendungen/puls/kniegelenkersatz-schnarchen-babyschwimmen-versuchskaninchen\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Teaser_TV/Ganze_Knieprothesen.jpg\" /></a><a class=\"icon-movie link-icon\" href=\"http://www.srf.ch/sendungen/puls/kniegelenkersatz-schnarchen-babyschwimmen-versuchskaninchen\" target=\"_blank\">Video anschauen</a></li>\r\n	<li><a class=\"icon-link link-icon\" href=\"{NODE_23}\">Erg&auml;nzende Themen</a></li>\r\n</ul>\r\n</section>\r\n',0,'',0,'','',0,0,'TV-Auftritte','TV-Auftritte','TV-Auftritte','1',NULL,NULL,'',0,0,0,1,1,'','access',''),(53,39,39,1,'content',0,'2015-04-13 10:05:02','webmaster@werbelinie.ch','Studien / Artikel','','Studien / Artikel','Studien-Artikel','<p>Hier finden Sie Angaben zu eigenen Publikationen in Schrift, Ton oder Bild in medizinischen Fachzeitschriften oder sonstigen Publikationsorganen. Ausserdem erfahren Sie, was bei christenortho aus Gr&uuml;nden der Qualit&auml;tssicherung zur Zeit genauer untersucht und ausgewertet wird. Schliesslich k&ouml;nnen Sie in dieser Rubrik Hinweise auf besonders wichtige Ver&ouml;ffentlichungen anderer Autoren im Zusammenhang mit dem T&auml;tigkeitsbereich von christenortho finden.</p>\r\n\r\n<h2>Laufende Arbeiten bei christenortho</h2>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">KOOS und HOOS Score</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Alle Patienten, die sich f&uuml;r eine Knie- oder H&uuml;ftprothese&nbsp;entscheiden, werden gebeten, vor und 1 Jahr nach der Operation den KOOS Score f&uuml;r Knie und HOOS Score f&uuml;r H&uuml;fte (Beantwortung von ca. 100 Fragen) auszuf&uuml;llen. Die Fragebogen basieren ausschliesslich auf Ihren Angaben und geh&ouml;ren somit zu den heute generell verlangten Patient related outcome Messungen (PROM), ohne die eine Auswertung nicht mehr akzeptiert wird. Der KOOS und HOOS Score sind validiert und international anerkannt, um detaillierte Angaben zu Knie- und H&uuml;ftprothesen zu erhalten. Erg&auml;nzend werden Untersuchungsresultate des Arztes und R&ouml;ntgenauswertungen die Beurteilung des Resultates abrunden.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title last\"><a class=\"accordion-link\" href=\"#\">SIRIS</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Alle Knie- und H&uuml;ftprothesen bei CHRISTENORTHO AG werden seit dem 1.1.2008 systematisch auf elektronische Weise (unter Wahrung der Patientenanonymit&auml;t) ins Schweizerische Prothesenregister eingegeben. S&auml;mtliche Journey-Knieprothesen wurden retrospektiv seit der Erstimplantation am 1.12.2006 erfasst. Seit September 2012 ist die Erfassung der Knie- und H&uuml;ftprothesen in der Schweiz obligatorisch <a href=\"http://www.siris-implant.ch\" target=\"_blank\">(Schweizerisches Prothesenregister SIRIS)</a>.</p>\r\n\r\n<p>Bei allen Prothesen erfolgt die Eingabe vor und nach jeder Operation sowie anl&auml;sslich der Jahreskontrolle.&nbsp;Muss eine Prothese reoperiert werden, impliziert dies einen neuen Eintrag ins Register. Damit k&ouml;nnen in relativ kurzer Zeit viel Aussagen &uuml;ber&nbsp;Zuverl&auml;ssigkeit eines Operationsverfahrens und einer Prothese gemacht werden.</p>\r\n\r\n<p>Jederzeit k&ouml;nnen Auswertungen der eigenen, eingegebenen Daten erhoben und anonym mit anderen Zentren der Schweiz verglichen werden. Ziel ist selbstredend, das SIRIS auch mit internationalen Registern (Schweden, Finnland Norwegen,&nbsp;Australien, Neuseeland, usw.) zu verkn&uuml;pfen.</p>\r\n</div>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h2>Studien</h2>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Kein Unterschied zwischen mobilen und fixen Polyaethyleneins&auml;tzen im balanSys-Knie</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>In einer prospektiv randomisierten Arbeit in Zusammenarbeit mit dem Zieglerspital Bern und der Sint Maartenskliniek in Nijmegen konnten bei 92 Patienten 3, 6 und 12 Monate nach Knie-Totalprothese in den zwei Gruppen keine signifikanten Unterschiede in der aktiven Beugef&auml;higkeit der Kniegelenke gezeigt werden. Verglichen wurden zwei verschiedene Kunststoffteile bei sonst identischem Prothesendesign. Bei der einen Gruppe wurde das Polyaethylen fix am Schienbeinteil eingerastet, bei der anderen wurde ein sogenannt moblier L&auml;ufer verwendet, der sich drehen und besch&auml;nkt auch nach vorne, respektive hinten bewegen kann. Patienten mit dem fixen Polyaethylen hatten weniger Schwierigkeiten mit dem Treppen steigen in der Fr&uuml;hphase nach der Operation. Die Arbeit wurde im Journal KSSTA (Knee Surg Sports Traumatol Arthrosc) 2012 publiziert (Jacobs WCH et al., Funcitonal performance of mobile versus fixed bearing total knee prosthesis: a randomised controlled trial, KSSTA 2012, 20: 1450-55).</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Prospektive randomisierte Studie &uuml;ber Analgesie nach Schulteroperationen</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Zusammen mit 4 An&auml;sthesisten und des Schmerzdienstes des Salemspitals wurden 50 Patienten in eine prospektiv randomisierte Arbeit eingschlossen, deren Daten noch komplettiert und ausgewertet werden m&uuml;ssen. Verglichen wurde dabei die Schmerzbehandlung in den ersten 2 Tagen nach der Operation von gr&ouml;sseren Schultereingriffen (Rekonstuktion der Rotatorenmanschette, Schulterprothese). Die Operationen wurden alle in Allgemeinnarkose durchgef&uuml;hrt. Die eine Gruppe erhielt in klassischer Weise nach der Opration eine Schmerzpumpe, &uuml;ber welche sich der Patient selbst&auml;ndig die notwendige Menge an Schmerzmitteln zuf&uuml;gen konnte. In der anderen Gruppe wurde unmittelbar vor der Operation unter Stimulation und Ultraschallkontrolle ein Katheter auf die Armnerven auf H&ouml;he des Halsrandes eingelegt. &Uuml;ber diesen Katheter wurde ein lokales Bet&auml;ubungsmittel per Pumpe nach Bedarf eingebracht. Verglichen wurden Schmerzintensit&auml;t, Schmerzmittelbedarf und Resultate nach der Schulteroperation. Die Datenerhebung und Auswertung sind noch im Gange. Grob sind zwischen den beiden Gruppen keine gr&ouml;sseren Unterschiede festzustellen, dies bleibt statistisch auszuwerten.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Balancierung des hinteren Kreuzbandes bei Knieprothesen</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Bei 101 Kniegelenken wurden bei einer Knie-Totalprothese intraoperativ Messungen durchgef&uuml;hrt, um mehr Erkenntnisse &uuml;ber das Verhalten des hinteren Kreuzbandes zu gewinnen. Dies ist bei Prothesenmodellen zentral, bei denen das hintere Kreuzband erhalten wird und von dem man den Erhalt seiner Funktion zugrunde legt. Die Arbeit mit Journeyprothesen war insofern aufschlussreich, als bei dieser Prothese beide Kreuzb&auml;nder entfernt werden (vgl. &quot;Das Journey Knie&quot;). Somit konnten die Messungen mit prim&auml;rem Erhalt des hinteren Kreuzbandes und dann nach Entfernung durchgef&uuml;hrt werden. Die Studie liefert keine eindeutigen Resultate, welche die korrekte Balancierung des hinteren Kreuzbandes sicher erlauben w&uuml;rde.</p>\r\n\r\n<p>Die Arbeit wurde im Juni 2010 am Europ&auml;ischen Kniekongress der ESSKA in Oslo pr&auml;sentiert. Sie ist elektronisch im Journal KSSTA (Knee Surgery Sports Traumatology Arthroscopy) im Juli 2011 publiziert und ist in gedruckter Form in der Ausgabe 3 vom M&auml;rz 2012 erschienen.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Die ersten 226 Journey Kniegelenke</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Die Resultate der ersten 103 Journey Knieprothesen, welche seit dem 1.12.2006 im Salemspital eingesetzt worden sind, wurden als Poster am Europ&auml;ischen Kniekongress in Oslo 2010 vorgestellt.<br />\r\nMittlerweile wurde &uuml;ber 226 derartige Gelenke implantiert. Kurzfristige Resultate wurden vom 27.-29. April 2011 am S&uuml;ddeutschen Orthop&auml;den Kongress in Baden-Baden und im Juni an der Jahrestagung der Scheizerischen Gesellschaft f&uuml;r Orthop&auml;die und Traumatologie vorgestellt.</p>\r\n\r\n<p>Das Knie liefert &uuml;berduchschnittlich gute kurzfristige Resultate, allerdings mit mehr Komplikationen als herk&ouml;mmliche Gelenke. Die Komplikationsrate nimmt mit Zunahme der Erfahrung des Chirurgen ab, bleibt aber leicht erh&ouml;ht. Offenbar verzeiht das Journey-System keine, auch nur kleine Abweichungen von der idealen Positionierung. Es scheint auch weniger geeignet bei eher laxen Verh&auml;ltnissen, sofern nicht eine kr&auml;ftige Muskulatur vorhanden ist.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">102 herk&ouml;mmlich implantierte versus 124 navigierte Journey-Prothesen</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Durch Einsatz der Computernavigation konnte die Pr&auml;zision der Knochenschnitte an Schienbeinkopf und Oberschenkel nicht signifikant verbessert werden. Hingegen k&ouml;nnen die Ausreisser bez&uuml;glich Achsenfehler sowohl f&uuml;r das X- wie O-Bein reduziert werden. Die Wertigkeit der Navigation bleibt somit - wie in der Literatur - weiter umstritten. Es stellt sich nach wie vor die Frage, ob die Verl&auml;ngerung der Operationszeit um ca. 10-15 Minuten und die Kosten f&uuml;r die Navigation (z.B. f&uuml;r die Markerkugeln) gerechtfertigt werden kann.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Hydroxiappatit-beschichtete zementfreie H&uuml;ftsch&auml;fte vom Typus SL MIA sinken weniger ein als nicht beschichtete Sch&auml;fte</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>H&uuml;ft-Totalprothesen d&uuml;rfen heute dank der &nbsp;weniger invasiven Technik sofort voll belastet werden, dies obwohl zementfreie Verankerungen immer h&auml;ufiger Anwendung finden. In R&ouml;ntgenkontrollen nach der Operation sowie nach 3 und 12 Monaten fiel auf, dass die Sch&auml;fte zum Nachsinken neigen.</p>\r\n\r\n<p>In einer vergleichenden Studie konnten wir zeigen, dass die neuen, beschichteten Sch&auml;fte statistisch signifikant weniger nachsintern als das nicht beschichtete Vorg&auml;ngermodell. Diese wurde wurden in Baden-Baden und am SGOT Kongress in Lausanne vorgestellt. Wir verwenden nur noch die beschichteten H&uuml;ftsch&auml;fte.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Auswertung Pain Score SEQ</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Die Resultate des Pain Scores sind eindr&uuml;cklich, da sie dank dem Vergleich mit der Normalbev&ouml;lkerung die Einschr&auml;nkungen jeweils vor einer Operation (H&uuml;ft- oder Knie-Totalprothese, respektive Rekonstruktion der Rotatorenmanschette) sichtbar machen und durch die Wiederholung nach einem Jahr die Verbesserung durch den Eingriff zeigen. Zu diesem Zeitpunkt kann wiederum mit der Normalbev&ouml;lkerung verglichen werden.</p>\r\n\r\n<p>Der Score soll mit einem g&auml;ngigen Wertesystem bei Knieeingriffen (KOOS-Score) verglichen werden. Ziel sind 75 Patienten, welche beide Scores jeweils vor der Knie-Totalprothese und 1 Jahr danach ausgef&uuml;llt haben. Die Auswertung erfolgt im Rahmen einer Disseration und Masterarbeit von Matthias Christen.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">LARS Band</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Seit 3 Jahren wird bei Sehnendefekten in erster Linie im Bereich des Kniegelenkes ein Polyesterband (LARS) zur Verst&auml;rkung eingen&auml;ht, das in der Tumorchirurgie gut erprobt ist. Die ersten Resultate wurden im April 2011 in Baden-Baden am S&uuml;ddeutschen Orthop&auml;den Kongress und im Juni 2011 an der Jahrestagung der Schweizerischen Gesellschaft f&uuml;r Orthop&auml;die und Traumatologie SGOT vorgestellt.</p>\r\n</div>\r\n\r\n<p>&nbsp;</p>\r\n',0,'',0,'','',0,0,'Studien / Artikel','Studien / Artikel','Studien / Artikel','1',NULL,NULL,'',0,0,0,1,1,'','access',''),(54,40,40,1,'application',0,'2015-03-18 10:42:37','webmaster@werbelinie.ch','News',NULL,'News','News','<script type=\"text/javascript\">\r\n    $J(document).ready(function () {\r\n        $J(\'.news-image\').each(function () {\r\n            if ($J.trim($J(this).html()) == \'\') {\r\n                $J(this).siblings(\'.news-text\').css(\'width\', \'100%\');\r\n                $J(this).remove();\r\n            }\r\n        });\r\n        $J(\'#news li:last\').css(\'border\', 0);\r\n    });\r\n</script>\r\n\r\n<!-- BEGIN news_status_message -->\r\n{TXT_NEWS_NO_NEWS_FOUND}\r\n<!-- END news_status_message -->\r\n\r\n<!-- BEGIN news_menu -->\r\n<form name=\"formNews\" method=\"post\" action=\"index.php?section=news&cmd={NEWS_CMD}\">\r\n    {NEWS_CAT_DROPDOWNMENU}\r\n</form>\r\n<!-- END news_menu -->\r\n\r\n<!-- BEGIN news_list -->\r\n<ul id=\"news\">\r\n    <!-- BEGIN newsrow -->\r\n    <li class=\"{NEWS_CSS}\">\r\n        <h3>{NEWS_LINK_TITLE}</h3>\r\n        <div class=\"news-image\">{NEWS_IMAGE}</div>\r\n        <div class=\"news-text\">\r\n            <div class=\"news-teaser\">{NEWS_TEASER}</div>\r\n            <div class=\"news-info\">{NEWS_DATE} &bull; {NEWS_CATEGORY}<!-- BEGIN news_comments_count --> &bull; {NEWS_COUNT_COMMENTS}<!-- END news_comments_count --></div>\r\n        </div>\r\n    </li>\r\n    <!-- END newsrow -->\r\n</ul>\r\n<!-- END news_list -->\r\n\r\n{NEWS_PAGING}',1,NULL,NULL,NULL,NULL,NULL,NULL,'News','News','News','index',NULL,NULL,'',0,0,0,0,0,NULL,'news',''),(55,40,40,2,'fallback',0,'2015-03-18 08:55:44','webmaster@werbelinie.ch','News',NULL,'News','News','',1,NULL,NULL,NULL,NULL,NULL,NULL,'News','News','News','index',NULL,NULL,'',0,0,0,0,1,NULL,'news',''),(56,41,41,1,'application',0,'2015-03-18 10:42:38','webmaster@werbelinie.ch','News hinzufügen',NULL,'News hinzufügen','News-hinzufuegen','<font color=\"#FF0000\">{NEWS_STATUS_MESSAGE}</font> \r\n<!-- BEGIN news_submit_form -->\r\n<form method=\"post\" action=\"{NODE_NEWS_SUBMIT}\">\r\n    <fieldset>\r\n        <legend>{TXT_NEWS_MESSAGE}</legend>\r\n        <div><label for=\"newsTitle\">{TXT_TITLE}</label><input id=\"newsTitle\" name=\"newsTitle\" value=\"{NEWS_TITLE}\" type=\"text\" /></div>\r\n        <div>\r\n            <label for=\"newsCat\">{TXT_CATEGORY}</label>\r\n            <select id=\"newsCat\" name=\"newsCat\">\r\n                <!-- BEGIN news_category_menu -->\r\n                <option value=\"{NEWS_CATEGORY_ID}\">{NEWS_CATEGORY_TITLE}</option>\r\n                <!-- END news_category_menu -->\r\n            </select>\r\n        </div>\r\n        <div><label for=\"newsTeaserText\">{TXT_NEWS_TEASER_TEXT}</label><textarea id=\"newsTeaserText\" name=\"newsTeaserText\">{NEWS_TEASER_TEXT}</textarea></div>\r\n        <div>\r\n            <label>{TXT_TYPE}</label>\r\n            <div class=\"contactFormGroup\">\r\n                <input type=\"radio\" class=\"newsTypeRedirect\" name=\"newsTypeRedirect\" value=\"0\" checked=\"checked\" />\r\n                <label class=\"noCaption\">{TXT_NEWS_MESSAGE}</label><br />\r\n                <input type=\"radio\" class=\"newsTypeRedirect\" name=\"newsTypeRedirect\" value=\"1\" />\r\n                <label class=\"noCaption\">{TXT_NEWS_REDIRECT_LABEL}</label>\r\n            </div>\r\n        </div>\r\n        <div class=\"newsContent\">{NEWS_TEXT}</div>\r\n        <div class=\"newsRedirect\" style=\"display: none;\">\r\n            <label for=\"newsRedirect\">{TXT_NEWS_NEWS_URL}</label>\r\n            <input id=\"newsRedirect\" name=\"newsRedirect\" value=\"{NEWS_REDIRECT}\" type=\"text\"/>\r\n        </div>\r\n    </fieldset>\r\n    <fieldset>\r\n        <legend>{TXT_EXTERNAL_SOURCE}</legend>\r\n        <div><label for=\"newsSource\">{TXT_EXTERNAL_SOURCE}</label><input id=\"newsSource\" name=\"newsSource\" value=\"{NEWS_SOURCE}\" type=\"text\" /></div>\r\n        <div><label for=\"newsUrl1\">{TXT_LINK} #1</label><input id=\"newsUrl1\" name=\"newsUrl1\" value=\"{NEWS_URL1}\" type=\"text\" /></div>\r\n        <div><label for=\"newsUrl2\">{TXT_LINK} #2</label><input id=\"newsUrl2\" name=\"newsUrl2\" value=\"{NEWS_URL2}\" type=\"text\" /></div>\r\n    </fieldset>\r\n    <!-- BEGIN news_submit_form_captcha -->\r\n    <div><label>{TXT_NEWS_CAPTCHA}</label>{NEWS_CAPTCHA_CODE}</div>\r\n    <!-- END news_submit_form_captcha -->\r\n    <div><input type=\"submit\" name=\"submitNews\" value=\"Hinzufügen\" /><input type=\"reset\" onclick=\"CKEDITOR.instances[\'newsText\'].setData()\" /></div>\r\n</form>\r\n<!-- END news_submit_form --> \r\n<!-- BEGIN news_submitted --> \r\n<a title=\"weitere Newsmeldung hinzuf&uuml;gen\" href=\"{NODE_NEWS_SUBMIT}\">Klicken Sie hier um eine weitere Newsmeldung zu erfassen.</a> \r\n<!-- END news_submitted -->',1,NULL,NULL,NULL,NULL,NULL,NULL,'News hinzufügen','News hinzufügen','News hinzufügen','index',NULL,NULL,'',0,0,0,1,0,NULL,'news','submit'),(57,41,41,2,'fallback',0,'2015-03-18 08:55:44','webmaster@werbelinie.ch','News hinzufügen',NULL,'News hinzufügen','News-hinzufuegen','',1,NULL,NULL,NULL,NULL,NULL,NULL,'News hinzufügen','News hinzufügen','News hinzufügen','index',NULL,NULL,'',0,0,0,1,1,NULL,'news','submit'),(58,42,42,1,'application',0,'2015-03-18 10:42:39','webmaster@werbelinie.ch','Direktzugriff auf eine Newskategorie',NULL,'Direktzugriff auf eine Newskategorie','Direktzugriff-auf-eine-Newskategorie','<script type=\"text/javascript\">\r\n    $J(document).ready(function () {\r\n        $J(\'#news li:last\').css(\'border\', 0);\r\n    });\r\n</script>\r\n\r\n<!-- BEGIN news_status_message -->\r\n{TXT_NEWS_NO_NEWS_FOUND}\r\n<!-- END news_status_message -->\r\n\r\n<!-- BEGIN news_menu -->\r\n<form name=\"formNews\" method=\"post\" action=\"index.php?section=news&cmd={NEWS_CMD}\">\r\n    {NEWS_CAT_DROPDOWNMENU}\r\n</form>\r\n<!-- END news_menu -->\r\n\r\n<!-- BEGIN news_list -->\r\n<ul id=\"news\">\r\n    <!-- BEGIN newsrow -->\r\n    <li class=\"{NEWS_CSS}\">\r\n        <h3>{NEWS_LINK_TITLE}</h3>\r\n        <div class=\"news-image\">{NEWS_IMAGE}</div>\r\n        <div class=\"news-text\">\r\n            <div class=\"news-teaser\">{NEWS_TEASER}</div>\r\n            <div class=\"news-info\">{NEWS_DATE} &bull; {NEWS_CATEGORY} &bull; {NEWS_COUNT_COMMENTS}</div>\r\n        </div>\r\n    </li>\r\n    <!-- END newsrow -->\r\n</ul>\r\n<!-- END news_list -->\r\n\r\n{NEWS_PAGING}',1,NULL,NULL,NULL,NULL,NULL,NULL,'Direktzugriff auf eine Newskategorie','Direktzugriff auf eine Newskategorie','Direktzugriff auf eine Newskategorie','index',NULL,NULL,'',0,0,0,1,0,NULL,'news','1'),(59,42,42,2,'fallback',0,'2015-03-18 08:55:44','webmaster@werbelinie.ch','Direktzugriff auf eine Newskategorie',NULL,'Direktzugriff auf eine Newskategorie','Direktzugriff-auf-eine-Newskategorie','',1,NULL,NULL,NULL,NULL,NULL,NULL,'Direktzugriff auf eine Newskategorie','Direktzugriff auf eine Newskategorie','Direktzugriff auf eine Newskategorie','index',NULL,NULL,'',0,0,0,1,1,NULL,'news','1'),(60,43,43,1,'application',0,'2015-03-18 10:42:40','webmaster@werbelinie.ch','News Feed',NULL,'News Feed','News-Feed','<h3>Online Einbindung mittels RSS-Newsfeed</h3>\r\n\r\n<p><a class=\"rssfeed\" href=\"{NEWS_RSS_FEED_URL}\" target=\"_blank\" title=\"RSS Newsfeed von {NEWS_HOSTNAME}\"><img alt=\"Der Feed dieser Website kann über diesen Link aufgerufen werden\" border=\"0\" height=\"74\" src=\"images/content/icons/rss_bg.gif\" style=\"margin: 5px 20px 20px; float: right;\" width=\"48\" /></a>RSS ist ein elektronisches Nachrichtenformat, das dem Nutzer erm&ouml;glicht, die Inhalte einer Website &ndash; oder Teile davon &ndash; als sogenannte RSS-Feeds zu abonnieren oder in andere Websites zu integrieren.</p>\r\n\r\n<h3>Online Einbindung mittels Javascript</h3>\r\nDer Feed dieser Website kann auch ganz einfach auf Ihrer Website dargestellt werden. Dazu m&uuml;ssen Sie lediglich den folgenden Code in Ihre eigene Webseite einf&uuml;gen:<br />\r\n&nbsp;\r\n<form action=\"\"><textarea cols=\"30\" name=\"code\" rows=\"18\" style=\"width: 98%; font-size: 95%;\">{NEWS_RSS2JS_CODE}</textarea><br />\r\n<br />\r\n<input name=\"button\" onclick=\"javascript:this.form.code.focus();this.form.code.select();\" type=\"button\" value=\"Alles markieren\" />&nbsp;</form>\r\n',0,NULL,NULL,NULL,NULL,NULL,NULL,'News Feed','News Feed','News Feed','index',NULL,NULL,'',0,0,0,1,0,NULL,'news','feed'),(61,43,43,2,'fallback',0,'2015-03-18 08:55:44','webmaster@werbelinie.ch','News Feed',NULL,'News Feed','News-Feed','',0,NULL,NULL,NULL,NULL,NULL,NULL,'News Feed','News Feed','News Feed','index',NULL,NULL,'',0,0,0,1,1,NULL,'news','feed'),(62,44,44,1,'application',0,'2015-03-18 10:47:57','webmaster@werbelinie.ch','Newsmeldung','','Newsmeldung','Newsmeldung','<div id=\"news-date\">\r\n    {NEWS_DATE}\r\n</div>\r\n\r\n<div id=\"news-content\">\r\n    <!-- BEGIN news_text -->{NEWS_TEXT}<!-- END news_text -->\r\n    <!-- BEGIN news_redirect -->{TXT_NEWS_REDIRECT_INSTRUCTION} <a href=\"{NEWS_REDIRECT_URL}\" target=\"_blank\">{NEWS_REDIRECT_URL}</a><!-- END news_redirect -->\r\n</div>',1,'',0,'','',0,0,'Newsmeldung','Newsmeldung','Newsmeldung','index',NULL,NULL,'',0,0,0,0,1,'','news','details'),(63,44,44,2,'fallback',0,'2015-03-18 08:55:44','webmaster@werbelinie.ch','Newsmeldung',NULL,'Newsmeldung','Newsmeldung','',1,NULL,NULL,NULL,NULL,NULL,NULL,'Newsmeldung','Newsmeldung','Newsmeldung','index',NULL,NULL,'',0,0,0,0,1,NULL,'news','details'),(64,45,45,1,'application',0,'2015-03-18 10:42:41','webmaster@werbelinie.ch','Archiv',NULL,'Archiv','Archiv','<!-- BEGIN news_status_message -->\r\n{TXT_NEWS_NO_NEWS_FOUND}\r\n<!-- END news_status_message -->\r\n\r\n<!-- BEGIN news_archive_months_list -->\r\n<ul id=\"news_archive_months_list\">\r\n    <!-- BEGIN news_archive_months_list_item -->\r\n    <li><a href=\"#{NEWS_ARCHIVE_MONTH_KEY}\">{NEWS_ARCHIVE_MONTH_NAME}</a> ({NEWS_ARCHIVE_MONTH_COUNT})</li>\r\n    <!-- END news_archive_months_list_item  -->\r\n</ul>\r\n<!-- END news_archive_months_list -->\r\n<br />\r\n<!-- BEGIN news_archive_month_list -->\r\n<ul id=\"news_archive_list\">\r\n    <!-- BEGIN news_archive_month_list_item -->\r\n    <li>\r\n        <a name=\"{NEWS_ARCHIVE_MONTH_KEY}\">{NEWS_ARCHIVE_MONTH_NAME}</a>\r\n        <ul>\r\n            <!-- BEGIN news_archive_link -->\r\n            <li><a href=\"{NEWS_ARCHIVE_LINK_URL}\" title=\"{NEWS_ARCHIVE_LINK_TITLE}\">{NEWS_ARCHIVE_LINK_TITLE}</a></li>\r\n            <!-- END news_archive_link -->\r\n        </ul>\r\n    </li>\r\n    <!-- END news_archive_month_list_item -->\r\n</ul>\r\n<!-- END news_archive_month_list -->',1,NULL,NULL,NULL,NULL,NULL,NULL,'Archiv','Archiv','Archiv','index',NULL,NULL,'',0,0,0,1,0,NULL,'news','archive'),(65,45,45,2,'fallback',0,'2015-03-18 08:55:44','webmaster@werbelinie.ch','Archiv',NULL,'Archiv','Archiv','',1,NULL,NULL,NULL,NULL,NULL,NULL,'Archiv','Archiv','Archiv','index',NULL,NULL,'',0,0,0,1,1,NULL,'news','archive'),(66,32,NULL,2,'content',0,'2015-03-18 10:40:28','webmaster@werbelinie.ch','Infos / News','','Infos / News','Infos-News','',0,'',NULL,'','',0,NULL,'Infos / News','Infos / News','Infos / News','1',NULL,NULL,'',0,0,0,0,1,'','',''),(67,18,NULL,2,'content',0,'2015-03-18 10:40:28','webmaster@werbelinie.ch','Über uns','','Über uns','Ueber-uns','',0,'',NULL,'','',0,NULL,'Über uns','Über uns','Über uns','1',NULL,NULL,'',0,0,0,0,1,'','',''),(72,46,46,1,'content',0,'2015-04-13 10:21:01','webmaster@werbelinie.ch','Downloads','','Downloads','Downloads','<p>Downloads...</p>\r\n',0,'',0,'','',0,0,'Downloads','Downloads','Downloads','1',NULL,NULL,'',0,0,0,0,1,'','access',''),(73,47,47,1,'content',0,'2015-04-13 10:21:02','webmaster@werbelinie.ch','Links','','Links','Links','<p>Links...</p>\r\n',0,'',0,'','',0,0,'Links','Links','Links','1',NULL,NULL,'',0,0,0,0,1,'','access','');
/*!40000 ALTER TABLE `contrexx_content_page` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_core_country`
--

DROP TABLE IF EXISTS `contrexx_core_country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_core_country` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `alpha2` char(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `alpha3` char(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ord` int(5) unsigned NOT NULL DEFAULT '0',
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=240 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_core_country`
--

LOCK TABLES `contrexx_core_country` WRITE;
/*!40000 ALTER TABLE `contrexx_core_country` DISABLE KEYS */;
INSERT INTO `contrexx_core_country` VALUES (1,'AF','AFG',0,0),(2,'AL','ALB',0,0),(3,'DZ','DZA',0,0),(4,'AS','ASM',0,0),(5,'AD','AND',0,0),(6,'AO','AGO',0,0),(7,'AI','AIA',0,0),(8,'AQ','ATA',0,0),(9,'AG','ATG',0,0),(10,'AR','ARG',0,0),(11,'AM','ARM',0,0),(12,'AW','ABW',0,0),(13,'AU','AUS',0,0),(14,'AT','AUT',0,1),(15,'AZ','AZE',0,0),(16,'BS','BHS',0,0),(17,'BH','BHR',0,0),(18,'BD','BGD',0,0),(19,'BB','BRB',0,0),(20,'BY','BLR',0,0),(21,'BE','BEL',0,0),(22,'BZ','BLZ',0,0),(23,'BJ','BEN',0,0),(24,'BM','BMU',0,0),(25,'BT','BTN',0,0),(26,'BO','BOL',0,0),(27,'BA','BIH',0,0),(28,'BW','BWA',0,0),(29,'BV','BVT',0,0),(30,'BR','BRA',0,0),(31,'IO','IOT',0,0),(32,'BN','BRN',0,0),(33,'BG','BGR',0,0),(34,'BF','BFA',0,0),(35,'BI','BDI',0,0),(36,'KH','KHM',0,0),(37,'CM','CMR',0,0),(38,'CA','CAN',0,0),(39,'CV','CPV',0,0),(40,'KY','CYM',0,0),(41,'CF','CAF',0,0),(42,'TD','TCD',0,0),(43,'CL','CHL',0,0),(44,'CN','CHN',0,0),(45,'CX','CXR',0,0),(46,'CC','CCK',0,0),(47,'CO','COL',0,0),(48,'KM','COM',0,0),(49,'CG','COG',0,0),(50,'CK','COK',0,0),(51,'CR','CRI',0,0),(52,'CI','CIV',0,0),(53,'HR','HRV',0,0),(54,'CU','CUB',0,0),(55,'CY','CYP',0,0),(56,'CZ','CZE',0,0),(57,'DK','DNK',0,0),(58,'DJ','DJI',0,0),(59,'DM','DMA',0,0),(60,'DO','DOM',0,0),(61,'TP','TMP',0,0),(62,'EC','ECU',0,0),(63,'EG','EGY',0,0),(64,'SV','SLV',0,0),(65,'GQ','GNQ',0,0),(66,'ER','ERI',0,0),(67,'EE','EST',0,0),(68,'ET','ETH',0,0),(69,'FK','FLK',0,0),(70,'FO','FRO',0,0),(71,'FJ','FJI',0,0),(72,'FI','FIN',0,0),(73,'FR','FRA',0,0),(74,'FX','FXX',0,0),(75,'GF','GUF',0,0),(76,'PF','PYF',0,0),(77,'TF','ATF',0,0),(78,'GA','GAB',0,0),(79,'GM','GMB',0,0),(80,'GE','GEO',0,0),(81,'DE','DEU',0,1),(82,'GH','GHA',0,0),(83,'GI','GIB',0,0),(84,'GR','GRC',0,0),(85,'GL','GRL',0,0),(86,'GD','GRD',0,0),(87,'GP','GLP',0,0),(88,'GU','GUM',0,0),(89,'GT','GTM',0,0),(90,'GN','GIN',0,0),(91,'GW','GNB',0,0),(92,'GY','GUY',0,0),(93,'HT','HTI',0,0),(94,'HM','HMD',0,0),(95,'HN','HND',0,0),(96,'HK','HKG',0,0),(97,'HU','HUN',0,0),(98,'IS','ISL',0,0),(99,'IN','IND',0,0),(100,'ID','IDN',0,0),(101,'IR','IRN',0,0),(102,'IQ','IRQ',0,0),(103,'IE','IRL',0,0),(104,'IL','ISR',0,0),(105,'IT','ITA',0,0),(106,'JM','JAM',0,0),(107,'JP','JPN',0,0),(108,'JO','JOR',0,0),(109,'KZ','KAZ',0,0),(110,'KE','KEN',0,0),(111,'KI','KIR',0,0),(112,'KP','PRK',0,0),(113,'KR','KOR',0,0),(114,'KW','KWT',0,0),(115,'KG','KGZ',0,0),(116,'LA','LAO',0,0),(117,'LV','LVA',0,0),(118,'LB','LBN',0,0),(119,'LS','LSO',0,0),(120,'LR','LBR',0,0),(121,'LY','LBY',0,0),(122,'LI','LIE',0,1),(123,'LT','LTU',0,0),(124,'LU','LUX',0,0),(125,'MO','MAC',0,0),(126,'MK','MKD',0,0),(127,'MG','MDG',0,0),(128,'MW','MWI',0,0),(129,'MY','MYS',0,0),(130,'MV','MDV',0,0),(131,'ML','MLI',0,0),(132,'MT','MLT',0,0),(133,'MH','MHL',0,0),(134,'MQ','MTQ',0,0),(135,'MR','MRT',0,0),(136,'MU','MUS',0,0),(137,'YT','MYT',0,0),(138,'MX','MEX',0,0),(139,'FM','FSM',0,0),(140,'MD','MDA',0,0),(141,'MC','MCO',0,0),(142,'MN','MNG',0,0),(143,'MS','MSR',0,0),(144,'MA','MAR',0,0),(145,'MZ','MOZ',0,0),(146,'MM','MMR',0,0),(147,'NA','NAM',0,0),(148,'NR','NRU',0,0),(149,'NP','NPL',0,0),(150,'NL','NLD',0,0),(151,'AN','ANT',0,0),(152,'NC','NCL',0,0),(153,'NZ','NZL',0,0),(154,'NI','NIC',0,0),(155,'NE','NER',0,0),(156,'NG','NGA',0,0),(157,'NU','NIU',0,0),(158,'NF','NFK',0,0),(159,'MP','MNP',0,0),(160,'NO','NOR',0,0),(161,'OM','OMN',0,0),(162,'PK','PAK',0,0),(163,'PW','PLW',0,0),(164,'PA','PAN',0,0),(165,'PG','PNG',0,0),(166,'PY','PRY',0,0),(167,'PE','PER',0,0),(168,'PH','PHL',0,0),(169,'PN','PCN',0,0),(170,'PL','POL',0,0),(171,'PT','PRT',0,0),(172,'PR','PRI',0,0),(173,'QA','QAT',0,0),(174,'RE','REU',0,0),(175,'RO','ROM',0,0),(176,'RU','RUS',0,0),(177,'RW','RWA',0,0),(178,'KN','KNA',0,0),(179,'LC','LCA',0,0),(180,'VC','VCT',0,0),(181,'WS','WSM',0,0),(182,'SM','SMR',0,0),(183,'ST','STP',0,0),(184,'SA','SAU',0,0),(185,'SN','SEN',0,0),(186,'SC','SYC',0,0),(187,'SL','SLE',0,0),(188,'SG','SGP',0,0),(189,'SK','SVK',0,0),(190,'SI','SVN',0,0),(191,'SB','SLB',0,0),(192,'SO','SOM',0,0),(193,'ZA','ZAF',0,0),(194,'GS','SGS',0,0),(195,'ES','ESP',0,0),(196,'LK','LKA',0,0),(197,'SH','SHN',0,0),(198,'PM','SPM',0,0),(199,'SD','SDN',0,0),(200,'SR','SUR',0,0),(201,'SJ','SJM',0,0),(202,'SZ','SWZ',0,0),(203,'SE','SWE',0,0),(204,'CH','CHE',0,1),(205,'SY','SYR',0,0),(206,'TW','TWN',0,0),(207,'TJ','TJK',0,0),(208,'TZ','TZA',0,0),(209,'TH','THA',0,0),(210,'TG','TGO',0,0),(211,'TK','TKL',0,0),(212,'TO','TON',0,0),(213,'TT','TTO',0,0),(214,'TN','TUN',0,0),(215,'TR','TUR',0,0),(216,'TM','TKM',0,0),(217,'TC','TCA',0,0),(218,'TV','TUV',0,0),(219,'UG','UGA',0,0),(220,'UA','UKR',0,0),(221,'AE','ARE',0,0),(222,'GB','GBR',0,0),(223,'US','USA',0,0),(224,'UM','UMI',0,0),(225,'UY','URY',0,0),(226,'UZ','UZB',0,0),(227,'VU','VUT',0,0),(228,'VA','VAT',0,0),(229,'VE','VEN',0,0),(230,'VN','VNM',0,0),(231,'VG','VGB',0,0),(232,'VI','VIR',0,0),(233,'WF','WLF',0,0),(234,'EH','ESH',0,0),(235,'YE','YEM',0,0),(236,'YU','YUG',0,0),(237,'ZR','ZAR',0,0),(238,'ZM','ZMB',0,0),(239,'ZW','ZWE',0,0);
/*!40000 ALTER TABLE `contrexx_core_country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_core_mail_template`
--

DROP TABLE IF EXISTS `contrexx_core_mail_template`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_core_mail_template` (
  `key` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `section` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `text_id` int(10) unsigned NOT NULL,
  `html` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `protected` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`key`(32),`section`(32))
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_core_mail_template`
--

LOCK TABLES `contrexx_core_mail_template` WRITE;
/*!40000 ALTER TABLE `contrexx_core_mail_template` DISABLE KEYS */;
INSERT INTO `contrexx_core_mail_template` VALUES ('customer_login','shop',1,1,1),('order_complete','shop',2,1,1),('order_confirmation','shop',3,1,1),('crm_user_account_created','crm',12,1,1),('crm_notify_staff_on_contact_added','crm',14,1,1),('crm_task_assigned','crm',13,1,1);
/*!40000 ALTER TABLE `contrexx_core_mail_template` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_core_setting`
--

DROP TABLE IF EXISTS `contrexx_core_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_core_setting` (
  `section` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `group` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `type` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'text',
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `values` text COLLATE utf8_unicode_ci NOT NULL,
  `ord` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`section`,`name`,`group`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_core_setting`
--

LOCK TABLES `contrexx_core_setting` WRITE;
/*!40000 ALTER TABLE `contrexx_core_setting` DISABLE KEYS */;
INSERT INTO `contrexx_core_setting` VALUES ('core','numof_countries_per_page_backend','country','text','30','',101),('shop','address','config','text','MaxMuster AG\r\nFirmenstrasse 1\r\n4321 Irgendwo','',20),('shop','company','config','text','MaxMuster AG','',19),('shop','country_id','config','text','204','',13),('shop','datatrans_active','config','text','1','',29),('shop','datatrans_merchant_id','config','text','123456789','',28),('shop','datatrans_request_type','config','text','CAA','',30),('shop','datatrans_use_testserver','config','text','1','',31),('shop','email','config','text','webmaster@contrexx.local','',1),('shop','email_confirmation','config','text','webmaster@contrexx.local','',5),('shop','fax','config','text','012 3456790','',7),('shop','numof_coupon_per_page_backend','config','text','25','',58),('shop','numof_customers_per_page_backend','config','text','25','',55),('shop','numof_mailtemplate_per_page_backend','config','text','25','',57),('shop','numof_manufacturers_per_page_backend','config','text','25','',56),('shop','numof_orders_per_page_backend','config','text','25','',54),('shop','numof_products_per_page_backend','config','text','25','',216),('shop','numof_products_per_page_frontend','config','text','25','',53),('shop','orderitems_amount_max','config','text','0','',45),('shop','payment_lsv_active','config','text','1','',18),('shop','paypal_account_email','config','text','info@example.com','',9),('shop','paypal_active','config','text','1','',10),('shop','paypal_default_currency','config','text','EUR','',17),('shop','postfinance_accepted_payment_methods','config','text','','',25),('shop','postfinance_active','config','text','1','',12),('shop','postfinance_authorization_type','config','text','SAL','',8),('shop','postfinance_hash_signature_in','config','text','sech10zeichenminimum','',47),('shop','postfinance_hash_signature_out','config','text','sech10zeichenminimum','',48),('shop','postfinance_mobile_ijustwanttotest','config','text','1','',51),('shop','postfinance_mobile_sign','config','text','geheime_signatur','',50),('shop','postfinance_mobile_status','config','text','0','',52),('shop','postfinance_mobile_webuser','config','text','Benutzername','',49),('shop','postfinance_shop_id','config','text','demoShop','',11),('shop','postfinance_use_testserver','config','text','1','',26),('shop','product_sorting','config','text','1','',27),('shop','register','config','dropdown','optional','0:mandatory,1:optional,2:none',46),('shop','saferpay_active','config','text','1','',3),('shop','saferpay_finalize_payment','config','text','1','',15),('shop','saferpay_id','config','text','12345-12345678','',2),('shop','saferpay_use_test_account','config','text','1','',14),('shop','saferpay_window_option','config','text','2','',16),('shop','show_products_default','config','text','1','',32),('shop','telephone','config','text','012 3456789','',6),('shop','thumbnail_max_height','config','text','999','',22),('shop','thumbnail_max_width','config','text','180','',21),('shop','thumbnail_quality','config','text','95','',23),('shop','user_profile_attribute_customer_group_id','config','dropdown_user_custom_attribute','2','',351),('shop','user_profile_attribute_notes','config','dropdown_user_custom_attribute','1','',352),('shop','usergroup_id_customer','config','dropdown_usergroup','6','',341),('shop','usergroup_id_reseller','config','dropdown_usergroup','7','',342),('shop','vat_default_id','config','text','1','',41),('shop','vat_enabled_foreign_customer','config','text','0','',33),('shop','vat_enabled_foreign_reseller','config','text','0','',34),('shop','vat_enabled_home_customer','config','text','1','',35),('shop','vat_enabled_home_reseller','config','text','1','',36),('shop','vat_included_foreign_customer','config','text','0','',37),('shop','vat_included_foreign_reseller','config','text','0','',38),('shop','vat_included_home_customer','config','text','1','',39),('shop','vat_included_home_reseller','config','text','1','',40),('shop','vat_other_id','config','text','1','',42),('shop','weight_enable','config','text','0','',24),('egov','postfinance_shop_id','config','text','Ihr Kontoname','',1),('egov','postfinance_active','config','checkbox','0','1',2),('egov','postfinance_authorization_type','config','dropdown','SAL','RES:Reservation,SAL:Verkauf',3),('egov','postfinance_hash_signature_in','config','text','Mindestens 16 Buchstaben, Ziffern und Zeichen','',5),('egov','postfinance_hash_signature_out','config','text','Mindestens 16 Buchstaben, Ziffern und Zeichen','',6),('egov','postfinance_use_testserver','config','checkbox','1','1',7),('shop','use_js_cart','config','checkbox','1','1',47),('shop','shopnavbar_on_all_pages','config','checkbox','1','1',48),('filesharing','permission','config','text','off','',0),('access','providers','sociallogin','text','{\"facebook\":{\"active\":\"0\",\"settings\":[\"\",\"\"]},\"twitter\":{\"active\":\"0\",\"settings\":[\"\",\"\"]},\"google\":{\"active\":\"0\",\"settings\":[\"\",\"\",\"\"]}}','',0),('crm','numof_mailtemplate_per_page_backend','config','text','25','',1001),('shop','paymill_test_private_key','config','text','','',2),('shop','paymill_live_public_key','config','text','','',0),('shop','paymill_live_private_key','config','text','','',0),('shop','paymill_active','config','text','1','',3),('shop','paymill_test_public_key','config','text','','',16),('shop','paymill_use_test_account','config','text','0','',15),('shop','orderitems_amount_min','config','text','0','',0);
/*!40000 ALTER TABLE `contrexx_core_setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_core_text`
--

DROP TABLE IF EXISTS `contrexx_core_text`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_core_text` (
  `id` int(10) unsigned NOT NULL DEFAULT '0',
  `lang_id` int(10) unsigned NOT NULL DEFAULT '1',
  `section` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`,`lang_id`,`section`,`key`(32)),
  FULLTEXT KEY `text` (`text`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_core_text`
--

LOCK TABLES `contrexx_core_text` WRITE;
/*!40000 ALTER TABLE `contrexx_core_text` DISABLE KEYS */;
INSERT INTO `contrexx_core_text` VALUES (1,1,'core','core_country_name','Afghanistan'),(1,1,'shop','attribute_name','Zusatzleistungen'),(1,1,'shop','core_mail_template_bcc',''),(1,1,'shop','core_mail_template_cc',''),(1,1,'shop','core_mail_template_from','webmaster@contrexx.local'),(1,1,'shop','core_mail_template_message','[CUSTOMER_SALUTATION]\r\n\r\nHier Ihre Zugangsdaten zum Shop:[[CUSTOMER_LOGIN]\r\nBenutzername: [CUSTOMER_USERNAME]\r\nPasswort: [CUSTOMER_PASSWORD][CUSTOMER_LOGIN]]\r\n\r\nMit freundlichen Grüssen\r\nIhr [SHOP_COMPANY] Online Shop Team\r\n\r\n[SHOP_HOMEPAGE]\r\n'),(1,1,'shop','core_mail_template_message_html','[CUSTOMER_SALUTATION]<br />\r\n<br />\r\nHier Ihre Zugangsdaten zum Shop:<br /><!-- [[CUSTOMER_LOGIN] -->\r\nBenutzername: [CUSTOMER_USERNAME]<br />\r\nPasswort: [CUSTOMER_PASSWORD]<br /><!-- [CUSTOMER_LOGIN]] -->\r\n<br />\r\nMit freundlichen Gr&uuml;ssen<br />\r\nIhr [SHOP_COMPANY] Online Shop Team<br />\r\n<br />\r\n[SHOP_HOMEPAGE]<br />\r\n'),(1,1,'shop','core_mail_template_name','Zugangsdaten'),(1,1,'shop','core_mail_template_reply','webmaster@contrexx.local'),(1,1,'shop','core_mail_template_sender','Contrexx Demo'),(1,1,'shop','core_mail_template_subject','Zugangsdaten'),(1,1,'shop','core_mail_template_to','webmaster@contrexx.local'),(1,1,'shop','discount_group_article','Telefone'),(1,1,'shop','discount_group_customer','Neukunden'),(1,1,'shop','discount_group_name','Mengenrabatt'),(1,1,'shop','discount_group_unit','Stück'),(1,1,'shop','manufacturer_name','Comvation Internet Solutions'),(1,1,'shop','manufacturer_uri','http://www.comvation.com'),(1,1,'shop','option_name','Leder-Etui'),(12,1,'shop','product_uri','www.comvation.com'),(1,1,'shop','shipper_name','PostPac Priority'),(1,1,'shop','vat_class','Nicht Taxpflichtig'),(1,1,'shop','zone_name','All'),(1,2,'shop','category_name','Gadgets'),(1,2,'shop','currency_name','Schweizer Franken'),(2,1,'core','core_country_name','Albania'),(2,1,'shop','core_mail_template_bcc',''),(2,1,'shop','core_mail_template_cc',''),(2,1,'shop','core_mail_template_from','webmaster@contrexx.local'),(2,1,'shop','core_mail_template_message','[CUSTOMER_SALUTATION]\r\n\r\nIhre Bestellung wurde ausgeführt. Sie werden in den nächsten Tagen ihre Lieferung erhalten.\r\n\r\nHerzlichen Dank für das Vertrauen.\r\nWir würden uns freuen, wenn Sie uns weiterempfehlen und wünschen Ihnen noch einen schönen Tag.\r\n\r\nMit freundlichen Grüssen\r\nIhr [SHOP_COMPANY] Online Shop Team\r\n\r\n[SHOP_HOMEPAGE]\r\n'),(2,1,'shop','core_mail_template_name','Auftrag abgeschlossen'),(2,1,'shop','core_mail_template_reply','webmaster@contrexx.local'),(2,1,'shop','core_mail_template_sender','Contrexx Demo'),(2,1,'shop','core_mail_template_subject','Auftrag abgeschlossen'),(2,1,'shop','core_mail_template_to','webmaster@contrexx.local'),(2,1,'shop','discount_group_customer','Stammkunden'),(2,1,'shop','manufacturer_name','Apple, Inc.'),(2,1,'shop','manufacturer_uri','http://www.apple.com/'),(2,1,'shop','option_name','Pimp my Handy Kit'),(2,1,'shop','payment_name','VISA, Mastercard (Saferpay)'),(2,1,'shop','shipper_name','Express Post'),(2,1,'shop','vat_class','Deutschland Normalsatz'),(2,1,'shop','zone_name','Schweiz'),(3,1,'core','core_country_name','Algeria'),(3,1,'shop','core_mail_template_bcc',''),(3,1,'shop','core_mail_template_cc',''),(3,1,'shop','core_mail_template_from','webmaster@contrexx.local'),(3,1,'shop','core_mail_template_message','[CUSTOMER_SALUTATION],\r\n\r\nHerzlichen Dank für Ihre Bestellung im [SHOP_COMPANY] Online Shop.\r\n\r\nIhre Auftrags-Nr. lautet: [ORDER_ID]\r\nIhre Kunden-Nr. lautet: [CUSTOMER_ID]\r\nBestellungszeit: [ORDER_DATE] [ORDER_TIME]\r\n\r\n------------------------------------------------------------------------\r\nBestellinformationen\r\n------------------------------------------------------------------------[[ORDER_ITEM]\r\nID:             [PRODUCT_ID]\r\nArtikel Nr.:    [PRODUCT_CODE]\r\nMenge:          [PRODUCT_QUANTITY]\r\nBeschreibung:   [PRODUCT_TITLE][[PRODUCT_OPTIONS]\r\n                [PRODUCT_OPTIONS][PRODUCT_OPTIONS]]\r\nStückpreis:      [PRODUCT_ITEM_PRICE] [CURRENCY]                       Total [PRODUCT_TOTAL_PRICE] [CURRENCY][[USER_DATA]\r\nBenutzername:   [USER_NAME]\r\nPasswort:       [USER_PASS][USER_DATA]][[COUPON_DATA]\r\nGutschein Code: [COUPON_CODE][COUPON_DATA]][ORDER_ITEM]]\r\n------------------------------------------------------------------------\r\nZwischensumme:    [ORDER_ITEM_COUNT] Artikel                             [ORDER_ITEM_SUM] [CURRENCY][[DISCOUNT_COUPON]\r\nGutschein Code: [DISCOUNT_COUPON_CODE]   [DISCOUNT_COUPON_AMOUNT] [CURRENCY][DISCOUNT_COUPON]]\r\n------------------------------------------------------------------------[[SHIPMENT]\r\nVersandart:     [SHIPMENT_NAME]   [SHIPMENT_PRICE] [CURRENCY][SHIPMENT]][[PAYMENT]\r\nBezahlung:      [PAYMENT_NAME]   [PAYMENT_PRICE] [CURRENCY][PAYMENT]][[TAX]\r\n[TAX_TEXT]                   [TAX_PRICE] [CURRENCY][TAX]]\r\n------------------------------------------------------------------------\r\nGesamtsumme                                                [ORDER_SUM] [CURRENCY]\r\n------------------------------------------------------------------------\r\n\r\nIhre Kundenadresse:\r\n[CUSTOMER_COMPANY]\r\n[CUSTOMER_FIRSTNAME] [CUSTOMER_LASTNAME]\r\n[CUSTOMER_ADDRESS]\r\n[CUSTOMER_ZIP] [CUSTOMER_CITY]\r\n[CUSTOMER_COUNTRY][[SHIPPING_ADDRESS]\r\n\r\n\r\nLieferadresse:\r\n[SHIPPING_COMPANY]\r\n[SHIPPING_FIRSTNAME] [SHIPPING_LASTNAME]\r\n[SHIPPING_ADDRESS]\r\n[SHIPPING_ZIP] [SHIPPING_CITY]\r\n[SHIPPING_COUNTRY][SHIPPING_ADDRESS]]\r\n\r\nIhr Link zum Online Store: [SHOP_HOMEPAGE][[CUSTOMER_LOGIN]\r\n\r\nIhre Zugangsdaten zum Shop:\r\nBenutzername:   [CUSTOMER_USERNAME]\r\nPasswort:       [CUSTOMER_PASSWORD][CUSTOMER_LOGIN]]\r\n\r\nWir freuen uns auf Ihren nächsten Besuch im [SHOP_COMPANY] Online Store und wünschen Ihnen noch einen schönen Tag.\r\n\r\nP.S. Diese Auftragsbestätigung wurde gesendet an: [CUSTOMER_EMAIL]\r\n\r\nMit freundlichen Grüssen\r\nIhr [SHOP_COMPANY] Online Shop Team\r\n\r\n[SHOP_HOMEPAGE]\r\n'),(3,1,'shop','core_mail_template_message_html','[CUSTOMER_SALUTATION],<br />\r\n<br />\r\nHerzlichen Dank f&uuml;r Ihre Bestellung im [SHOP_COMPANY] Online Shop.<br />\r\n<br />\r\nIhre Auftrags-Nr. lautet: [ORDER_ID]<br />\r\nIhre Kunden-Nr. lautet: [CUSTOMER_ID]<br />\r\nBestelldatum: [ORDER_DATE]<br />\r\nBestellzeit: [ORDER_TIME]<br />\r\n<br />\r\n<br />\r\n<table cellpadding=\"1\" cellspacing=\"1\" style=\"border: 0;\">\r\n  <tbody>\r\n    <tr>\r\n      <td colspan=\"6\">Bestellinformationen</td>\r\n    </tr>\r\n    <tr>\r\n      <td><div style=\"text-align: right;\">ID</div></td>\r\n      <td><div style=\"text-align: right;\">Artikel Nr.</div></td>\r\n      <td><div style=\"text-align: right;\">Menge</div></td>\r\n      <td>Beschreibung</td>\r\n      <td><div style=\"text-align: right;\">St&uuml;ckpreis</div></td>\r\n      <td><div style=\"text-align: right;\">Total</div></td>\r\n    </tr><!--[[ORDER_ITEM]-->\r\n    <tr>\r\n      <td><div style=\"text-align: right;\">[PRODUCT_ID]</div></td>\r\n      <td><div style=\"text-align: right;\">[PRODUCT_CODE]</div></td>\r\n      <td><div style=\"text-align: right;\">[PRODUCT_QUANTITY]</div></td>\r\n      <td>[PRODUCT_TITLE]<!--[[PRODUCT_OPTIONS]--><br />\r\n        [PRODUCT_OPTIONS]<!--[PRODUCT_OPTIONS]]--></td>\r\n      <td><div style=\"text-align: right;\">[PRODUCT_ITEM_PRICE] [CURRENCY]</div></td>\r\n      <td><div style=\"text-align: right;\">[PRODUCT_TOTAL_PRICE] [CURRENCY]</div></td>\r\n    </tr><!--[[USER_DATA]-->\r\n    <tr>\r\n      <td colspan=\"3\">&nbsp;</td>\r\n      <td>Benutzername: [USER_NAME]<br />Passwort: [USER_PASS]</td>\r\n      <td colspan=\"2\">&nbsp;</td>\r\n    </tr><!--[USER_DATA]]--><!--[[COUPON_DATA]-->\r\n    <tr>\r\n      <td colspan=\"3\">&nbsp;</td>\r\n      <td>Gutschein Code: [COUPON_CODE]</td>\r\n      <td colspan=\"2\">&nbsp;</td>\r\n    </tr><!--[COUPON_DATA]]--><!--[ORDER_ITEM]]-->\r\n    <tr style=\"border-top: 4px none;\">\r\n      <td colspan=\"2\">Zwischensumme</td>\r\n      <td><div style=\"text-align: right;\">[ORDER_ITEM_COUNT]</div></td>\r\n      <td colspan=\"2\">Artikel</td>\r\n      <td><div style=\"text-align: right;\">[ORDER_ITEM_SUM] [CURRENCY]</div></td>\r\n    </tr><!--[[DISCOUNT_COUPON]-->\r\n    <tr style=\"border-top: 4px none;\">\r\n      <td colspan=\"3\">Gutscheincode</td>\r\n      <td colspan=\"2\">[DISCOUNT_COUPON_CODE]</td>\r\n      <td><div style=\"text-align: right;\">[DISCOUNT_COUPON_AMOUNT] [CURRENCY]</div></td>\r\n    </tr><!--[DISCOUNT_COUPON]][[SHIPMENT]-->\r\n    <tr style=\"border-top: 2px none;\">\r\n      <td colspan=\"3\">Versandart</td>\r\n      <td colspan=\"2\">[SHIPMENT_NAME]</td>\r\n      <td><div style=\"text-align: right;\">[SHIPMENT_PRICE] [CURRENCY]</div></td>\r\n    </tr><!--[SHIPMENT]][[PAYMENT]-->\r\n    <tr style=\"border-top: 2px none;\">\r\n      <td colspan=\"3\">Bezahlung</td>\r\n      <td colspan=\"2\">[PAYMENT_NAME]</td>\r\n      <td><div style=\"text-align: right;\">[PAYMENT_PRICE] [CURRENCY]</div></td>\r\n    </tr><!--[PAYMENT]][[VAT]-->\r\n    <tr style=\"border-top: 2px none;\">\r\n      <td colspan=\"5\">[VAT_TEXT]</td>\r\n      <td><div style=\"text-align: right;\">[VAT_PRICE] [CURRENCY]</div></td>\r\n    </tr><!--[VAT]]-->\r\n    <tr style=\"border-top: 4px none;\">\r\n      <td colspan=\"5\">Gesamtsumme</td>\r\n      <td><div style=\"text-align: right;\">[ORDER_SUM] [CURRENCY]</div></td>\r\n    </tr>\r\n  </tbody>\r\n</table>\r\n<br />\r\nBemerkungen:<br />\r\n[REMARKS]<br />\r\n<br />\r\n<br />\r\nIhre Kundenadresse:<br />\r\n[CUSTOMER_COMPANY]<br />\r\n[CUSTOMER_FIRSTNAME] [CUSTOMER_LASTNAME]<br />\r\n[CUSTOMER_ADDRESS]<br />\r\n[CUSTOMER_ZIP] [CUSTOMER_CITY]<br />\r\n[CUSTOMER_COUNTRY]<br />\r\n<!--[[SHIPPING_ADDRESS]--><br />\r\n<br />\r\nLieferadresse:<br />\r\n[SHIPPING_COMPANY]<br />\r\n[SHIPPING_FIRSTNAME] [SHIPPING_LASTNAME]<br />\r\n[SHIPPING_ADDRESS]<br />\r\n[SHIPPING_ZIP] [SHIPPING_CITY]<br />\r\n[SHIPPING_COUNTRY]<br />\r\n<!--[SHIPPING_ADDRESS]]--><br />\r\n<br />\r\nIhr Link zum Online Store: [SHOP_HOMEPAGE]<br />\r\n<!--[[CUSTOMER_LOGIN]-->\r\n<br />\r\nIhre Zugangsdaten zum Shop:<br />\r\nBenutzername:   [CUSTOMER_USERNAME]<br />\r\nPasswort:       [CUSTOMER_PASSWORD]<br />\r\n<!--[CUSTOMER_LOGIN]]-->\r\n<br />\r\nWir freuen uns auf Ihren n&auml;chsten Besuch im [SHOP_COMPANY] Online Store und w&uuml;nschen Ihnen noch einen sch&ouml;nen Tag.<br />\r\n<br />\r\nDiese Auftragsbest&auml;tigung wurde gesendet an: [CUSTOMER_EMAIL]<br />\r\n<br />\r\nMit freundlichen Gr&uuml;ssen<br />\r\nIhr [SHOP_COMPANY] Online Shop Team<br />\r\n<br />\r\n[SHOP_HOMEPAGE]\r\n'),(3,1,'shop','core_mail_template_name','Bestellungsbestätigung'),(3,1,'shop','core_mail_template_reply','webmaster@contrexx.local'),(3,1,'shop','core_mail_template_sender','Contrexx Demo'),(3,1,'shop','core_mail_template_subject','Bestellungsbestätigung'),(3,1,'shop','core_mail_template_to','webmaster@contrexx.local'),(3,1,'shop','discount_group_customer','Goldkunden'),(3,1,'shop','shipper_name','Schweizerische Post'),(3,1,'shop','vat_class','Deutschland ermässigt'),(3,1,'shop','zone_name','Deutschland'),(3,2,'shop','category_name','Mitgliedschaft'),(4,1,'core','core_country_name','American Samoa'),(4,1,'shop','shipper_name','Direct to Me'),(4,1,'shop','vat_class','Deutschland stark ermässigt'),(4,2,'shop','currency_name','Euro'),(5,1,'core','core_country_name','Andorra'),(5,1,'shop','vat_class','Deutschland Zwischensatz 1'),(5,2,'shop','currency_name','United States Dollars'),(6,1,'core','core_country_name','Angola'),(1,1,'shop','currency_name','Schweizer Franken'),(3,1,'shop','option_name','Headset'),(13,1,'shop','product_name','Contrexx® Premium'),(3,1,'shop','manufacturer_name','HTC'),(3,1,'shop','manufacturer_uri','http://www.htc.com/'),(6,1,'shop','vat_class','Deutschland Zwischensatz 2'),(7,1,'core','core_country_name','Anguilla'),(7,1,'shop','vat_class','Österreich Normalsatz'),(8,1,'core','core_country_name','Antarctica'),(8,1,'shop','vat_class','Österreich ermässigt'),(9,1,'core','core_country_name','Antigua and Barbuda'),(9,1,'shop','payment_name','Nachnahme'),(9,1,'shop','vat_class','Österreich Zwischensatz'),(10,1,'core','core_country_name','Argentina'),(10,1,'shop','vat_class','Schweiz'),(11,1,'core','core_country_name','Armenia'),(11,1,'shop','vat_class','Schweiz ermässigt 1'),(12,1,'core','core_country_name','Aruba'),(12,1,'shop','payment_name','Paypal'),(12,1,'shop','vat_class','Schweiz ermässigt 2'),(13,1,'core','core_country_name','Australia'),(13,1,'shop','payment_name','LSV'),(13,1,'shop','vat_class','Great Britain'),(14,1,'core','core_country_name','Österreich'),(14,1,'shop','payment_name','PostFinance (PostCard, Kreditkarte)'),(14,1,'shop','vat_class','Great Britain reduced'),(15,1,'core','core_country_name','Azerbaijan'),(15,1,'shop','payment_name','Datatrans'),(16,1,'core','core_country_name','Bahamas'),(17,1,'core','core_country_name','Bahrain'),(18,1,'core','core_country_name','Bangladesh'),(19,1,'core','core_country_name','Barbados'),(20,1,'core','core_country_name','Belarus'),(21,1,'core','core_country_name','Belgium'),(22,1,'core','core_country_name','Belize'),(23,1,'core','core_country_name','Benin'),(24,1,'core','core_country_name','Bermuda'),(25,1,'core','core_country_name','Bhutan'),(26,1,'core','core_country_name','Bolivia'),(27,1,'core','core_country_name','Bosnia and Herzegowina'),(28,1,'core','core_country_name','Botswana'),(29,1,'core','core_country_name','Bouvet Island'),(30,1,'core','core_country_name','Brazil'),(31,1,'core','core_country_name','British Indian Ocean Territory'),(32,1,'core','core_country_name','Brunei Darussalam'),(33,1,'core','core_country_name','Bulgaria'),(34,1,'core','core_country_name','Burkina Faso'),(35,1,'core','core_country_name','Burundi'),(36,1,'core','core_country_name','Cambodia'),(37,1,'core','core_country_name','Cameroon'),(38,1,'core','core_country_name','Canada'),(39,1,'core','core_country_name','Cape Verde'),(40,1,'core','core_country_name','Cayman Islands'),(41,1,'core','core_country_name','Central African Republic'),(42,1,'core','core_country_name','Chad'),(43,1,'core','core_country_name','Chile'),(44,1,'core','core_country_name','China'),(45,1,'core','core_country_name','Christmas Island'),(46,1,'core','core_country_name','Cocos (Keeling) Islands'),(47,1,'core','core_country_name','Colombia'),(48,1,'core','core_country_name','Comoros'),(49,1,'core','core_country_name','Congo'),(50,1,'core','core_country_name','Cook Islands'),(51,1,'core','core_country_name','Costa Rica'),(52,1,'core','core_country_name','Cote D\'Ivoire'),(53,1,'core','core_country_name','Croatia'),(54,1,'core','core_country_name','Cuba'),(55,1,'core','core_country_name','Cyprus'),(56,1,'core','core_country_name','Czech Republic'),(57,1,'core','core_country_name','Denmark'),(58,1,'core','core_country_name','Djibouti'),(59,1,'core','core_country_name','Dominica'),(60,1,'core','core_country_name','Dominican Republic'),(61,1,'core','core_country_name','East Timor'),(62,1,'core','core_country_name','Ecuador'),(63,1,'core','core_country_name','Egypt'),(64,1,'core','core_country_name','El Salvador'),(65,1,'core','core_country_name','Equatorial Guinea'),(66,1,'core','core_country_name','Eritrea'),(67,1,'core','core_country_name','Estonia'),(68,1,'core','core_country_name','Ethiopia'),(69,1,'core','core_country_name','Falkland Islands (Malvinas)'),(70,1,'core','core_country_name','Faroe Islands'),(71,1,'core','core_country_name','Fiji'),(72,1,'core','core_country_name','Finland'),(73,1,'core','core_country_name','France'),(74,1,'core','core_country_name','France, Metropolitan'),(75,1,'core','core_country_name','French Guiana'),(76,1,'core','core_country_name','French Polynesia'),(77,1,'core','core_country_name','French Southern Territories'),(78,1,'core','core_country_name','Gabon'),(79,1,'core','core_country_name','Gambia'),(80,1,'core','core_country_name','Georgia'),(81,1,'core','core_country_name','Deutschland'),(82,1,'core','core_country_name','Ghana'),(83,1,'core','core_country_name','Gibraltar'),(84,1,'core','core_country_name','Greece'),(85,1,'core','core_country_name','Greenland'),(86,1,'core','core_country_name','Grenada'),(87,1,'core','core_country_name','Guadeloupe'),(88,1,'core','core_country_name','Guam'),(89,1,'core','core_country_name','Guatemala'),(90,1,'core','core_country_name','Guinea'),(91,1,'core','core_country_name','Guinea-bissau'),(92,1,'core','core_country_name','Guyana'),(93,1,'core','core_country_name','Haiti'),(94,1,'core','core_country_name','Heard and Mc Donald Islands'),(95,1,'core','core_country_name','Honduras'),(96,1,'core','core_country_name','Hong Kong'),(97,1,'core','core_country_name','Hungary'),(98,1,'core','core_country_name','Iceland'),(99,1,'core','core_country_name','India'),(100,1,'core','core_country_name','Indonesia'),(101,1,'core','core_country_name','Iran (Islamic Republic of)'),(102,1,'core','core_country_name','Iraq'),(103,1,'core','core_country_name','Ireland'),(104,1,'core','core_country_name','Israel'),(105,1,'core','core_country_name','Italy'),(106,1,'core','core_country_name','Jamaica'),(107,1,'core','core_country_name','Japan'),(108,1,'core','core_country_name','Jordan'),(109,1,'core','core_country_name','Kazakhstan'),(110,1,'core','core_country_name','Kenya'),(111,1,'core','core_country_name','Kiribati'),(112,1,'core','core_country_name','Korea, Democratic People\'s Republic of'),(113,1,'core','core_country_name','Korea, Republic of'),(114,1,'core','core_country_name','Kuwait'),(115,1,'core','core_country_name','Kyrgyzstan'),(116,1,'core','core_country_name','Lao People\'s Democratic Republic'),(117,1,'core','core_country_name','Latvia'),(118,1,'core','core_country_name','Lebanon'),(119,1,'core','core_country_name','Lesotho'),(120,1,'core','core_country_name','Liberia'),(121,1,'core','core_country_name','Libyan Arab Jamahiriya'),(122,1,'core','core_country_name','Liechtenstein'),(123,1,'core','core_country_name','Lithuania'),(124,1,'core','core_country_name','Luxembourg'),(125,1,'core','core_country_name','Macau'),(126,1,'core','core_country_name','Macedonia, The Former Yugoslav Republic of'),(127,1,'core','core_country_name','Madagascar'),(128,1,'core','core_country_name','Malawi'),(129,1,'core','core_country_name','Malaysia'),(130,1,'core','core_country_name','Maldives'),(131,1,'core','core_country_name','Mali'),(132,1,'core','core_country_name','Malta'),(133,1,'core','core_country_name','Marshall Islands'),(134,1,'core','core_country_name','Martinique'),(135,1,'core','core_country_name','Mauritania'),(136,1,'core','core_country_name','Mauritius'),(137,1,'core','core_country_name','Mayotte'),(138,1,'core','core_country_name','Mexico'),(139,1,'core','core_country_name','Micronesia, Federated States of'),(140,1,'core','core_country_name','Moldova, Republic of'),(141,1,'core','core_country_name','Monaco'),(142,1,'core','core_country_name','Mongolia'),(143,1,'core','core_country_name','Montserrat'),(144,1,'core','core_country_name','Morocco'),(145,1,'core','core_country_name','Mozambique'),(146,1,'core','core_country_name','Myanmar'),(147,1,'core','core_country_name','Namibia'),(148,1,'core','core_country_name','Nauru'),(149,1,'core','core_country_name','Nepal'),(150,1,'core','core_country_name','Netherlands'),(151,1,'core','core_country_name','Netherlands Antilles'),(152,1,'core','core_country_name','New Caledonia'),(153,1,'core','core_country_name','New Zealand'),(154,1,'core','core_country_name','Nicaragua'),(155,1,'core','core_country_name','Niger'),(156,1,'core','core_country_name','Nigeria'),(157,1,'core','core_country_name','Niue'),(158,1,'core','core_country_name','Norfolk Island'),(159,1,'core','core_country_name','Northern Mariana Islands'),(160,1,'core','core_country_name','Norway'),(161,1,'core','core_country_name','Oman'),(162,1,'core','core_country_name','Pakistan'),(163,1,'core','core_country_name','Palau'),(164,1,'core','core_country_name','Panama'),(165,1,'core','core_country_name','Papua New Guinea'),(166,1,'core','core_country_name','Paraguay'),(167,1,'core','core_country_name','Peru'),(168,1,'core','core_country_name','Philippines'),(169,1,'core','core_country_name','Pitcairn'),(170,1,'core','core_country_name','Poland'),(171,1,'core','core_country_name','Portugal'),(172,1,'core','core_country_name','Puerto Rico'),(173,1,'core','core_country_name','Qatar'),(174,1,'core','core_country_name','Reunion'),(175,1,'core','core_country_name','Romania'),(176,1,'core','core_country_name','Russian Federation'),(177,1,'core','core_country_name','Rwanda'),(178,1,'core','core_country_name','Saint Kitts and Nevis'),(179,1,'core','core_country_name','Saint Lucia'),(180,1,'core','core_country_name','Saint Vincent and the Grenadines'),(181,1,'core','core_country_name','Samoa'),(182,1,'core','core_country_name','San Marino'),(183,1,'core','core_country_name','Sao Tome and Principe'),(184,1,'core','core_country_name','Saudi Arabia'),(185,1,'core','core_country_name','Senegal'),(186,1,'core','core_country_name','Seychelles'),(187,1,'core','core_country_name','Sierra Leone'),(188,1,'core','core_country_name','Singapore'),(189,1,'core','core_country_name','Slovakia (Slovak Republic)'),(190,1,'core','core_country_name','Slovenia'),(191,1,'core','core_country_name','Solomon Islands'),(192,1,'core','core_country_name','Somalia'),(193,1,'core','core_country_name','South Africa'),(194,1,'core','core_country_name','South Georgia and the South Sandwich Islands'),(195,1,'core','core_country_name','Spain'),(196,1,'core','core_country_name','Sri Lanka'),(197,1,'core','core_country_name','St. Helena'),(198,1,'core','core_country_name','St. Pierre and Miquelon'),(199,1,'core','core_country_name','Sudan'),(200,1,'core','core_country_name','Suriname'),(201,1,'core','core_country_name','Svalbard and Jan Mayen Islands'),(202,1,'core','core_country_name','Swaziland'),(203,1,'core','core_country_name','Sweden'),(204,1,'core','core_country_name','Schweiz'),(205,1,'core','core_country_name','Syrian Arab Republic'),(206,1,'core','core_country_name','Taiwan'),(207,1,'core','core_country_name','Tajikistan'),(208,1,'core','core_country_name','Tanzania, United Republic of'),(209,1,'core','core_country_name','Thailand'),(210,1,'core','core_country_name','Togo'),(211,1,'core','core_country_name','Tokelau'),(212,1,'core','core_country_name','Tonga'),(213,1,'core','core_country_name','Trinidad and Tobago'),(214,1,'core','core_country_name','Tunisia'),(215,1,'core','core_country_name','Turkey'),(216,1,'core','core_country_name','Turkmenistan'),(217,1,'core','core_country_name','Turks and Caicos Islands'),(218,1,'core','core_country_name','Tuvalu'),(219,1,'core','core_country_name','Uganda'),(220,1,'core','core_country_name','Ukraine'),(221,1,'core','core_country_name','United Arab Emirates'),(222,1,'core','core_country_name','United Kingdom'),(223,1,'core','core_country_name','United States'),(224,1,'core','core_country_name','United States Minor Outlying Islands'),(225,1,'core','core_country_name','Uruguay'),(226,1,'core','core_country_name','Uzbekistan'),(227,1,'core','core_country_name','Vanuatu'),(228,1,'core','core_country_name','Vatican City State (Holy See)'),(229,1,'core','core_country_name','Venezuela'),(230,1,'core','core_country_name','Viet Nam'),(231,1,'core','core_country_name','Virgin Islands (British)'),(232,1,'core','core_country_name','Virgin Islands (U.S.)'),(233,1,'core','core_country_name','Wallis and Futuna Islands'),(234,1,'core','core_country_name','Western Sahara'),(235,1,'core','core_country_name','Yemen'),(236,1,'core','core_country_name','Yugoslavia'),(237,1,'core','core_country_name','Zaire'),(238,1,'core','core_country_name','Zambia'),(239,1,'core','core_country_name','Zimbabwe'),(4,2,'shop','category_name','Lorem ipsum1'),(4,2,'shop','category_description','lorem ipsum lorem ipsum lorem ipsum lorem ipsum'),(5,2,'shop','category_name','Lorem ipsum2'),(5,2,'shop','category_description','lorem ipsum lorem ipsum lorem ipsum lorem ipsum'),(6,2,'shop','category_name','Lorem ipsum3'),(6,2,'shop','category_description','lorem ipsum lorem ipsum lorem ipsum lorem ipsum'),(12,1,'shop','product_short','K&ouml;nnen Sie dem Besucher Ihrer Website, egal ob diese vom PC, dem Tablet oder dem Smartphone surfen, bereits heute besten Surf-Komfort bieten? Falls ja, herzliche Gratulation! Dann haben Sie Ihre Website f&uuml;r die verschiedenen Endger&auml;te optimiert. Falls nein, helfen wir Ihnen gerne weiter.'),(12,1,'shop','product_long','<table border=\"0\">\r\n	<tbody>\r\n		<tr>\r\n			<td style=\"width: 120px;\"><strong>Go Left</strong></td>\r\n			<td>Navigation verschiebt Inhalt nach links</td>\r\n		</tr>\r\n		<tr>\r\n			<td><strong>Top Down</strong></td>\r\n			<td>Navigation klappt von oben nach unten auf</td>\r\n		</tr>\r\n		<tr>\r\n			<td><strong>Bottom Up</strong></td>\r\n			<td>Navigation klappt von unten nach oben auf</td>\r\n		</tr>\r\n		<tr>\r\n			<td><strong>Individual</strong></td>\r\n			<td>Individuelle Anpassungen durch Beratung</td>\r\n		</tr>\r\n	</tbody>\r\n</table>'),(12,1,'shop','product_keys','Website, Responsive, CMS, Mobile'),(12,1,'shop','product_code',''),(10,1,'shop','category_description','Alle Versionen des Contrexx Content Management Systems zur Verwaltung Ihrer Website.'),(12,1,'shop','product_name','Responsive Website'),(10,1,'shop','category_name','Contrexx CMS Software'),(8,2,'shop','category_name','Iphone'),(8,2,'shop','category_description','lorem ipsum lorem ipsum lorem ipsum lorem ipsum'),(13,1,'shop','product_code',''),(13,1,'shop','product_uri','http://www.contrexx.com'),(13,1,'shop','product_keys','Contrexx CMS'),(13,1,'shop','product_long','Mit dem Contrexx CMS stehen Ihnen &uuml;ber 20 Anwendungen zur Verf&uuml;gung, beispielsweise ein kompletter Online Shop, ein umfangreiches Newsletter-Modul und eine mehrsprachige Website.'),(13,1,'shop','product_short','Contrexx&reg; CMS f&uuml;r die schnelle Verwaltung Ihrer Website.'),(7,2,'shop','category_name','Samsung'),(7,2,'shop','category_description','lorem ipsum lorem ipsum lorem ipsum lorem ipsum'),(1,2,'shop','manufacturer_name','Samsung'),(1,2,'shop','manufacturer_uri','http://www.samsung.com'),(2,2,'shop','manufacturer_name','Apple, Inc.'),(2,2,'shop','manufacturer_uri','http://www.apple.com/'),(4,1,'shop','manufacturer_name','Contrexx'),(4,1,'shop','manufacturer_uri','http://www.contrexx.com'),(5,1,'shop','manufacturer_name','MaxMuster AG'),(5,1,'shop','manufacturer_uri',''),(2,1,'shop','core_mail_template_message_html','[CUSTOMER_SALUTATION]<br />\r\n<br />\r\nIhre Bestellung wurde ausgef&uuml;hrt. Sie werden in den n&auml;chsten Tagen ihre Lieferung erhalten.<br />\r\n<br />\r\nHerzlichen Dank f&uuml;r das Vertrauen.<br />\r\nWir w&uuml;rden uns freuen, wenn Sie uns weiterempfehlen und w&uuml;nschen Ihnen noch einen sch&ouml;nen Tag.<br />\r\n<br />\r\nMit freundlichen Gr&uuml;ssen<br />\r\nIhr [SHOP_COMPANY] Online Shop Team<br />\r\n<br />\r\n[SHOP_HOMEPAGE]'),(4,1,'shop','currency_name','Euro'),(5,1,'shop','currency_name','United States Dollars'),(12,1,'crm','core_mail_template_name','Benachrichtigung über Benutzerkonto'),(12,1,'crm','core_mail_template_from','info@example.com'),(12,1,'crm','core_mail_template_sender','Ihr Firmenname'),(12,1,'crm','core_mail_template_reply','info@example.com'),(12,1,'crm','core_mail_template_to','[CRM_CONTACT_EMAIL]'),(12,1,'crm','core_mail_template_cc',''),(12,1,'crm','core_mail_template_bcc',''),(12,1,'crm','core_mail_template_subject','Ihr persönlischer Zugang'),(12,1,'crm','core_mail_template_message','Guten Tag,\r\n\r\nNachfolgend erhalten Sie Ihre persönlichen Zugangsdaten zur Website http://www.example.com/\r\n\r\nBenutzername: [CRM_CONTACT_USERNAME]\r\nKennwort: [CRM_CONTACT_PASSWORD]'),(12,1,'crm','core_mail_template_message_html','<div>Guten Tag,<br />\r\n<br />\r\nNachfolgend erhalten Sie Ihre pers&ouml;nlichen Zugangsdaten zur Website <a href=\"http://www.example.com/\">http://www.example.com/</a><br />\r\n<br />\r\nBenutzername: [CRM_CONTACT_USERNAME]<br />\r\nKennwort: [CRM_CONTACT_PASSWORD]</div>'),(13,1,'crm','core_mail_template_bcc',''),(13,1,'crm','core_mail_template_cc',''),(13,1,'crm','core_mail_template_from','info@example.com'),(13,1,'crm','core_mail_template_message','Der Mitarbeiter [CRM_TASK_CREATED_USER] hat eine neue Aufgabe erstellt und Ihnen zugewiesen: [CRM_TASK_URL]\r\n\r\nBeschreibung: [CRM_TASK_DESCRIPTION_TEXT_VERSION]\r\n\r\nFällig am: [CRM_TASK_DUE_DATE]\r\n'),(13,1,'crm','core_mail_template_message_html','<div style=\"padding:0px; margin:0px; font-family:Tahoma, sans-serif; font-size:14px; width:620px; color: #333;\">\r\n<div style=\"padding: 0px 20px; border:1px solid #e0e0e0; margin-bottom: 10px; width:618px;\">\r\n<h1 style=\"background-color: #e0e0e0;color: #3d4a6b;font-size: 18px;font-weight: normal;padding: 15px 20px;margin-top: 0 !important;margin-bottom: 0 !important;margin-left: -20px !important;margin-right: -20px !important;-webkit-margin-before: 0 !important;-webkit-margin-after: 0 !important;-webkit-margin-start: -20px !important;-webkit-margin-end: -20px !important;\">Neue Aufgabe wurde Ihnen zugewiesen</h1>\r\n\r\n<p style=\"margin-top: 20px;word-wrap: break-word !important;\">Der Mitarbeiter [CRM_TASK_CREATED_USER] hat eine neue Aufgabe erstellt und Ihnen zugewiesen: [CRM_TASK_LINK]</p>\r\n\r\n<p style=\"margin-top: 20px;word-wrap: break-word !important;\">Beschreibung: [CRM_TASK_DESCRIPTION_HTML_VERSION]<br />\r\nF&auml;llig am: [CRM_TASK_DUE_DATE]</p>\r\n</div>\r\n</div>'),(13,1,'crm','core_mail_template_name','Neue Aufgabe'),(13,1,'crm','core_mail_template_reply','info@example.com'),(13,1,'crm','core_mail_template_sender','Ihr Firmenname'),(13,1,'crm','core_mail_template_subject','Neue Aufgabe : [CRM_TASK_NAME]'),(13,1,'crm','core_mail_template_to','[CRM_ASSIGNED_USER_EMAIL]'),(14,1,'crm','core_mail_template_bcc',''),(14,1,'crm','core_mail_template_cc',''),(14,1,'crm','core_mail_template_from','info@example.com'),(14,1,'crm','core_mail_template_message','Im CRM wurde ein neuer Kontakt erfasst: [CRM_CONTACT_DETAILS_URL]'),(14,1,'crm','core_mail_template_message_html','<div style=\"padding:0px; margin:0px; font-family:Tahoma, sans-serif; font-size:14px; width:620px; color: #333;\">\r\n<div style=\"padding: 0px 20px; border:1px solid #e0e0e0; margin-bottom: 10px; width:618px;\">\r\n<h1 style=\"background-color: #e0e0e0;color: #3d4a6b;font-size: 18px;font-weight: normal;padding: 15px 20px;margin-top: 0 !important;margin-bottom: 0 !important;margin-left: -20px !important;margin-right: -20px !important;-webkit-margin-before: 0 !important;-webkit-margin-after: 0 !important;-webkit-margin-start: -20px !important;-webkit-margin-end: -20px !important;\">Neuer Kontakt im CRM</h1>\r\n\r\n<p style=\"margin-top: 20px;word-wrap: break-word !important;\">Neuer Kontakt: [CRM_CONTACT_DETAILS_LINK].</p>\r\n</div>\r\n</div>\r\n'),(14,1,'crm','core_mail_template_name','Benachrichtigung an Mitarbeiter über neue Kontakte'),(14,1,'crm','core_mail_template_reply','info@example.com'),(14,1,'crm','core_mail_template_sender','Ihr Firmenname'),(14,1,'crm','core_mail_template_subject','Neuer Kontakt erfasst'),(14,1,'crm','core_mail_template_to','[CRM_ASSIGNED_USER_EMAIL]'),(18,1,'shop','payment_name','IBAN/BIC (Paymill)'),(16,2,'shop','payment_name','paymill'),(17,1,'shop','payment_name','ELV (Paymill)'),(16,1,'shop','payment_name','Kreditkarte (Paymill)'),(2,1,'shop','discount_group_article','Services'),(12,1,'shop','category_name','Services');
/*!40000 ALTER TABLE `contrexx_core_text` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_ids`
--

DROP TABLE IF EXISTS `contrexx_ids`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_ids` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `timestamp` int(14) DEFAULT NULL,
  `type` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `remote_addr` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `http_x_forwarded_for` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `http_via` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user` mediumtext COLLATE utf8_unicode_ci,
  `gpcs` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `file` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_ids`
--

LOCK TABLES `contrexx_ids` WRITE;
/*!40000 ALTER TABLE `contrexx_ids` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_ids` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_languages`
--

DROP TABLE IF EXISTS `contrexx_languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_languages` (
  `id` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `lang` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `charset` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'iso-8859-1',
  `themesid` int(2) unsigned NOT NULL DEFAULT '1',
  `print_themes_id` int(2) unsigned NOT NULL DEFAULT '1',
  `pdf_themes_id` int(2) unsigned NOT NULL DEFAULT '0',
  `frontend` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `backend` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_default` set('true','false') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `mobile_themes_id` int(2) unsigned NOT NULL DEFAULT '0',
  `fallback` int(2) unsigned DEFAULT '0',
  `app_themes_id` int(2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lang` (`lang`),
  KEY `defaultstatus` (`is_default`),
  KEY `name` (`name`),
  FULLTEXT KEY `name_2` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_languages`
--

LOCK TABLES `contrexx_languages` WRITE;
/*!40000 ALTER TABLE `contrexx_languages` DISABLE KEYS */;
INSERT INTO `contrexx_languages` VALUES (1,'de','Deutsch','UTF-8',2,2,2,1,1,'true',2,0,2),(2,'en','English','UTF-8',2,2,2,1,1,'false',2,0,2),(3,'fr','French','UTF-8',1,1,1,0,0,'false',1,0,1),(4,'it','Italian','UTF-8',1,1,1,0,0,'false',1,0,1),(5,'dk','Danish','UTF-8',1,1,1,0,0,'false',1,0,1),(6,'ru','Russian','UTF-8',1,1,1,0,0,'false',1,0,1);
/*!40000 ALTER TABLE `contrexx_languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_lib_country`
--

DROP TABLE IF EXISTS `contrexx_lib_country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_lib_country` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `iso_code_2` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `iso_code_3` char(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`iso_code_2`),
  KEY `INDEX_COUNTRIES_NAME` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=240 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_lib_country`
--

LOCK TABLES `contrexx_lib_country` WRITE;
/*!40000 ALTER TABLE `contrexx_lib_country` DISABLE KEYS */;
INSERT INTO `contrexx_lib_country` VALUES (1,'Afghanistan','AF','AFG'),(2,'Albania','AL','ALB'),(3,'Algeria','DZ','DZA'),(4,'American Samoa','AS','ASM'),(5,'Andorra','AD','AND'),(6,'Angola','AO','AGO'),(7,'Anguilla','AI','AIA'),(8,'Antarctica','AQ','ATA'),(9,'Antigua and Barbuda','AG','ATG'),(10,'Argentina','AR','ARG'),(11,'Armenia','AM','ARM'),(12,'Aruba','AW','ABW'),(13,'Australia','AU','AUS'),(14,'Austria','AT','AUT'),(15,'Azerbaijan','AZ','AZE'),(16,'Bahamas','BS','BHS'),(17,'Bahrain','BH','BHR'),(18,'Bangladesh','BD','BGD'),(19,'Barbados','BB','BRB'),(20,'Belarus','BY','BLR'),(21,'Belgium','BE','BEL'),(22,'Belize','BZ','BLZ'),(23,'Benin','BJ','BEN'),(24,'Bermuda','BM','BMU'),(25,'Bhutan','BT','BTN'),(26,'Bolivia','BO','BOL'),(27,'Bosnia and Herzegowina','BA','BIH'),(28,'Botswana','BW','BWA'),(29,'Bouvet Island','BV','BVT'),(30,'Brazil','BR','BRA'),(31,'British Indian Ocean Territory','IO','IOT'),(32,'Brunei Darussalam','BN','BRN'),(33,'Bulgaria','BG','BGR'),(34,'Burkina Faso','BF','BFA'),(35,'Burundi','BI','BDI'),(36,'Cambodia','KH','KHM'),(37,'Cameroon','CM','CMR'),(38,'Canada','CA','CAN'),(39,'Cape Verde','CV','CPV'),(40,'Cayman Islands','KY','CYM'),(41,'Central African Republic','CF','CAF'),(42,'Chad','TD','TCD'),(43,'Chile','CL','CHL'),(44,'China','CN','CHN'),(45,'Christmas Island','CX','CXR'),(46,'Cocos (Keeling) Islands','CC','CCK'),(47,'Colombia','CO','COL'),(48,'Comoros','KM','COM'),(49,'Congo','CG','COG'),(50,'Cook Islands','CK','COK'),(51,'Costa Rica','CR','CRI'),(52,'Cote D\'Ivoire','CI','CIV'),(53,'Croatia','HR','HRV'),(54,'Cuba','CU','CUB'),(55,'Cyprus','CY','CYP'),(56,'Czech Republic','CZ','CZE'),(57,'Denmark','DK','DNK'),(58,'Djibouti','DJ','DJI'),(59,'Dominica','DM','DMA'),(60,'Dominican Republic','DO','DOM'),(61,'East Timor','TP','TMP'),(62,'Ecuador','EC','ECU'),(63,'Egypt','EG','EGY'),(64,'El Salvador','SV','SLV'),(65,'Equatorial Guinea','GQ','GNQ'),(66,'Eritrea','ER','ERI'),(67,'Estonia','EE','EST'),(68,'Ethiopia','ET','ETH'),(69,'Falkland Islands (Malvinas)','FK','FLK'),(70,'Faroe Islands','FO','FRO'),(71,'Fiji','FJ','FJI'),(72,'Finland','FI','FIN'),(73,'France','FR','FRA'),(74,'France, Metropolitan','FX','FXX'),(75,'French Guiana','GF','GUF'),(76,'French Polynesia','PF','PYF'),(77,'French Southern Territories','TF','ATF'),(78,'Gabon','GA','GAB'),(79,'Gambia','GM','GMB'),(80,'Georgia','GE','GEO'),(81,'Germany','DE','DEU'),(82,'Ghana','GH','GHA'),(83,'Gibraltar','GI','GIB'),(84,'Greece','GR','GRC'),(85,'Greenland','GL','GRL'),(86,'Grenada','GD','GRD'),(87,'Guadeloupe','GP','GLP'),(88,'Guam','GU','GUM'),(89,'Guatemala','GT','GTM'),(90,'Guinea','GN','GIN'),(91,'Guinea-bissau','GW','GNB'),(92,'Guyana','GY','GUY'),(93,'Haiti','HT','HTI'),(94,'Heard and Mc Donald Islands','HM','HMD'),(95,'Honduras','HN','HND'),(96,'Hong Kong','HK','HKG'),(97,'Hungary','HU','HUN'),(98,'Iceland','IS','ISL'),(99,'India','IN','IND'),(100,'Indonesia','ID','IDN'),(101,'Iran (Islamic Republic of)','IR','IRN'),(102,'Iraq','IQ','IRQ'),(103,'Ireland','IE','IRL'),(104,'Israel','IL','ISR'),(105,'Italy','IT','ITA'),(106,'Jamaica','JM','JAM'),(107,'Japan','JP','JPN'),(108,'Jordan','JO','JOR'),(109,'Kazakhstan','KZ','KAZ'),(110,'Kenya','KE','KEN'),(111,'Kiribati','KI','KIR'),(112,'Korea, Democratic People\'s Republic of','KP','PRK'),(113,'Korea, Republic of','KR','KOR'),(114,'Kuwait','KW','KWT'),(115,'Kyrgyzstan','KG','KGZ'),(116,'Lao People\'s Democratic Republic','LA','LAO'),(117,'Latvia','LV','LVA'),(118,'Lebanon','LB','LBN'),(119,'Lesotho','LS','LSO'),(120,'Liberia','LR','LBR'),(121,'Libyan Arab Jamahiriya','LY','LBY'),(122,'Liechtenstein','LI','LIE'),(123,'Lithuania','LT','LTU'),(124,'Luxembourg','LU','LUX'),(125,'Macau','MO','MAC'),(126,'Macedonia, The Former Yugoslav Republic of','MK','MKD'),(127,'Madagascar','MG','MDG'),(128,'Malawi','MW','MWI'),(129,'Malaysia','MY','MYS'),(130,'Maldives','MV','MDV'),(131,'Mali','ML','MLI'),(132,'Malta','MT','MLT'),(133,'Marshall Islands','MH','MHL'),(134,'Martinique','MQ','MTQ'),(135,'Mauritania','MR','MRT'),(136,'Mauritius','MU','MUS'),(137,'Mayotte','YT','MYT'),(138,'Mexico','MX','MEX'),(139,'Micronesia, Federated States of','FM','FSM'),(140,'Moldova, Republic of','MD','MDA'),(141,'Monaco','MC','MCO'),(142,'Mongolia','MN','MNG'),(143,'Montserrat','MS','MSR'),(144,'Morocco','MA','MAR'),(145,'Mozambique','MZ','MOZ'),(146,'Myanmar','MM','MMR'),(147,'Namibia','NA','NAM'),(148,'Nauru','NR','NRU'),(149,'Nepal','NP','NPL'),(150,'Netherlands','NL','NLD'),(151,'Netherlands Antilles','AN','ANT'),(152,'New Caledonia','NC','NCL'),(153,'New Zealand','NZ','NZL'),(154,'Nicaragua','NI','NIC'),(155,'Niger','NE','NER'),(156,'Nigeria','NG','NGA'),(157,'Niue','NU','NIU'),(158,'Norfolk Island','NF','NFK'),(159,'Northern Mariana Islands','MP','MNP'),(160,'Norway','NO','NOR'),(161,'Oman','OM','OMN'),(162,'Pakistan','PK','PAK'),(163,'Palau','PW','PLW'),(164,'Panama','PA','PAN'),(165,'Papua New Guinea','PG','PNG'),(166,'Paraguay','PY','PRY'),(167,'Peru','PE','PER'),(168,'Philippines','PH','PHL'),(169,'Pitcairn','PN','PCN'),(170,'Poland','PL','POL'),(171,'Portugal','PT','PRT'),(172,'Puerto Rico','PR','PRI'),(173,'Qatar','QA','QAT'),(174,'Reunion','RE','REU'),(175,'Romania','RO','ROM'),(176,'Russian Federation','RU','RUS'),(177,'Rwanda','RW','RWA'),(178,'Saint Kitts and Nevis','KN','KNA'),(179,'Saint Lucia','LC','LCA'),(180,'Saint Vincent and the Grenadines','VC','VCT'),(181,'Samoa','WS','WSM'),(182,'San Marino','SM','SMR'),(183,'Sao Tome and Principe','ST','STP'),(184,'Saudi Arabia','SA','SAU'),(185,'Senegal','SN','SEN'),(186,'Seychelles','SC','SYC'),(187,'Sierra Leone','SL','SLE'),(188,'Singapore','SG','SGP'),(189,'Slovakia (Slovak Republic)','SK','SVK'),(190,'Slovenia','SI','SVN'),(191,'Solomon Islands','SB','SLB'),(192,'Somalia','SO','SOM'),(193,'South Africa','ZA','ZAF'),(194,'South Georgia and the South Sandwich Islands','GS','SGS'),(195,'Spain','ES','ESP'),(196,'Sri Lanka','LK','LKA'),(197,'St. Helena','SH','SHN'),(198,'St. Pierre and Miquelon','PM','SPM'),(199,'Sudan','SD','SDN'),(200,'Suriname','SR','SUR'),(201,'Svalbard and Jan Mayen Islands','SJ','SJM'),(202,'Swaziland','SZ','SWZ'),(203,'Sweden','SE','SWE'),(204,'Switzerland','CH','CHE'),(205,'Syrian Arab Republic','SY','SYR'),(206,'Taiwan','TW','TWN'),(207,'Tajikistan','TJ','TJK'),(208,'Tanzania, United Republic of','TZ','TZA'),(209,'Thailand','TH','THA'),(210,'Togo','TG','TGO'),(211,'Tokelau','TK','TKL'),(212,'Tonga','TO','TON'),(213,'Trinidad and Tobago','TT','TTO'),(214,'Tunisia','TN','TUN'),(215,'Turkey','TR','TUR'),(216,'Turkmenistan','TM','TKM'),(217,'Turks and Caicos Islands','TC','TCA'),(218,'Tuvalu','TV','TUV'),(219,'Uganda','UG','UGA'),(220,'Ukraine','UA','UKR'),(221,'United Arab Emirates','AE','ARE'),(222,'United Kingdom','GB','GBR'),(223,'United States','US','USA'),(224,'United States Minor Outlying Islands','UM','UMI'),(225,'Uruguay','UY','URY'),(226,'Uzbekistan','UZ','UZB'),(227,'Vanuatu','VU','VUT'),(228,'Vatican City State (Holy See)','VA','VAT'),(229,'Venezuela','VE','VEN'),(230,'Viet Nam','VN','VNM'),(231,'Virgin Islands (British)','VG','VGB'),(232,'Virgin Islands (U.S.)','VI','VIR'),(233,'Wallis and Futuna Islands','WF','WLF'),(234,'Western Sahara','EH','ESH'),(235,'Yemen','YE','YEM'),(236,'Yugoslavia','YU','YUG'),(237,'Zaire','ZR','ZAR'),(238,'Zambia','ZM','ZMB'),(239,'Zimbabwe','ZW','ZWE');
/*!40000 ALTER TABLE `contrexx_lib_country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_log`
--

DROP TABLE IF EXISTS `contrexx_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_log` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(6) unsigned DEFAULT NULL,
  `datetime` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `useragent` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `userlanguage` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remote_addr` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remote_host` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `http_via` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `http_client_ip` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `http_x_forwarded_for` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `referer` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_log`
--

LOCK TABLES `contrexx_log` WRITE;
/*!40000 ALTER TABLE `contrexx_log` DISABLE KEYS */;
INSERT INTO `contrexx_log` VALUES (1,1,'2015-02-26 07:07:16','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_2) AppleWebKit/600.3.18 (KHTML, like Gecko) Version/8.0.3 Safari/600.3.18','de-de','127.0.0.1','localhost','','','','http://localhost:3000/cadmin/index.php'),(2,1,'2015-03-11 14:38:09','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_2) AppleWebKit/600.3.18 (KHTML, like Gecko) Version/8.0.3 Safari/600.3.18','de-de','127.0.0.1','localhost','','','','http://localhost:3000/cadmin/'),(3,1,'2015-03-13 08:58:07','Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0','de,en-US;q=0.7,en;q=0.3','127.0.0.1','localhost','','','','http://christenortho.dev/cadmin/'),(4,1,'2015-03-16 14:24:37','Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0','de,en-US;q=0.7,en;q=0.3','127.0.0.1','localhost','','','','http://localhost:3000/cadmin/'),(5,1,'2015-03-20 12:46:15','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_2) AppleWebKit/600.4.10 (KHTML, like Gecko) Version/8.0.4 Safari/600.4.10','de-de','127.0.0.1','localhost','','','','http://localhost:3000/cadmin/'),(6,1,'2015-03-23 09:30:52','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_2) AppleWebKit/600.4.10 (KHTML, like Gecko) Version/8.0.4 Safari/600.4.10','de-de','127.0.0.1','localhost','','','','http://localhost:3000/cadmin/'),(7,1,'2015-03-30 09:09:11','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.104 Safari/537.36','de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4','127.0.0.1','localhost','','','','http://192.168.27.52:3000/cadmin/'),(8,1,'2015-03-30 11:49:18','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.104 Safari/537.36','de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4','127.0.0.1','localhost','','','','http://192.168.27.52:3000/cadmin/'),(9,1,'2015-03-30 12:32:06','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_2) AppleWebKit/600.4.10 (KHTML, like Gecko) Version/8.0.4 Safari/600.4.10','de-de','127.0.0.1','localhost','','','','http://localhost:3000/cadmin/'),(10,1,'2015-04-07 09:25:29','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36','de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4','127.0.0.1','localhost','','','','http://192.168.27.52:3000/cadmin/index.php'),(11,1,'2015-04-08 07:14:00','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36','de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4','127.0.0.1','localhost','','','','http://192.168.27.52:3000/cadmin/'),(12,1,'2015-04-08 07:21:19','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36','de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4','217.193.142.18','217.193.142.18','','','','http://christen.werbelinie.ch/cadmin/'),(13,1,'2015-04-08 11:05:52','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36','de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4','217.193.142.18','217.193.142.18','','','','http://christen.werbelinie.ch/cadmin/index.php'),(14,1,'2015-04-08 11:46:51','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36','de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4','217.193.142.18','217.193.142.18','','','','http://christen.werbelinie.ch/cadmin/'),(15,1,'2015-04-08 13:14:35','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36','de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4','217.193.142.18','217.193.142.18','','','','http://christen.werbelinie.ch/cadmin/'),(16,1,'2015-04-09 08:18:04','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36','de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4','217.193.142.18','217.193.142.18','','','','http://christen.werbelinie.ch/cadmin/'),(17,1,'2015-04-09 08:20:46','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_2) AppleWebKit/600.4.10 (KHTML, like Gecko) Version/8.0.4 Safari/600.4.10','de-de','217.193.142.18','217.193.142.18','','','','http://christen.werbelinie.ch/cadmin/'),(18,1,'2015-04-09 10:58:54','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36','de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4','217.193.142.18','217.193.142.18','','','','http://christen.werbelinie.ch/cadmin/'),(19,1,'2015-04-10 13:41:53','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_2) AppleWebKit/600.4.10 (KHTML, like Gecko) Version/8.0.4 Safari/600.4.10','de-de','127.0.0.1','localhost','','','','http://localhost:3000/cadmin/'),(20,1,'2015-04-13 06:05:16','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_2) AppleWebKit/600.4.10 (KHTML, like Gecko) Version/8.0.4 Safari/600.4.10','de-de','127.0.0.1','localhost','','','','http://christenortho.dev/cadmin/'),(21,1,'2015-04-13 06:10:21','Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:35.0) Gecko/20100101 Firefox/35.0','de,en-US;q=0.7,en;q=0.3','127.0.0.1','localhost','','','','http://christenortho.dev/cadmin/'),(22,1,'2015-04-13 11:42:15','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36','de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4','127.0.0.1','localhost','','','','http://192.168.27.52:3000/cadmin/'),(23,1,'2015-04-13 12:41:26','Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:35.0) Gecko/20100101 Firefox/35.0','de,en-US;q=0.7,en;q=0.3','127.0.0.1','localhost','','','','http://christenortho.dev/cadmin/index.php?cmd=content&page=20&version=3&tab=content&csrf=oty5odiyotq2mjm3na__'),(24,1,'2015-04-13 12:41:36','Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:35.0) Gecko/20100101 Firefox/35.0','de,en-US;q=0.7,en;q=0.3','127.0.0.1','localhost','','','','http://localhost:3000/cadmin/index.php?cmd=content&page=20&version=3&tab=content&csrf=oty5odiyotq2mjm3na__&csrf=nzgynde1njqwnzi2ng__'),(25,1,'2015-04-15 07:09:58','Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:39.0) Gecko/20100101 Firefox/39.0','de,en-US;q=0.7,en;q=0.3','217.193.142.18','217.193.142.18','','','','http://christen.werbelinie.ch/cadmin/'),(26,1,'2015-04-21 14:55:46','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36','de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4','217.193.142.18','217.193.142.18','','','','http://christen.werbelinie.ch/cadmin/'),(27,1,'2015-04-30 08:56:03','Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:39.0) Gecko/20100101 Firefox/39.0','de,en-US;q=0.7,en;q=0.3','217.193.142.18','217.193.142.18','','','','http://christen.werbelinie.ch/cadmin/'),(28,1,'2015-04-30 09:03:08','Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:39.0) Gecko/20100101 Firefox/39.0','de,en-US;q=0.7,en;q=0.3','127.0.0.1','localhost','','','','http://christenortho.dev/cadmin/index.php?cmd=workflow&act=updated&csrf=njk3otu3njkwndc5mg__');
/*!40000 ALTER TABLE `contrexx_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_log_entry`
--

DROP TABLE IF EXISTS `contrexx_log_entry`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_log_entry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `logged_at` timestamp NULL DEFAULT NULL,
  `version` int(11) NOT NULL,
  `object_id` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `object_class` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `data` longtext COLLATE utf8_unicode_ci,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `log_class_unique_version_idx` (`version`,`object_id`,`object_class`),
  KEY `log_class_lookup_idx` (`object_class`),
  KEY `log_date_lookup_idx` (`logged_at`),
  KEY `log_user_lookup_idx` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=485 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_log_entry`
--

LOCK TABLES `contrexx_log_entry` WRITE;
/*!40000 ALTER TABLE `contrexx_log_entry` DISABLE KEYS */;
INSERT INTO `contrexx_log_entry` VALUES (433,'update','2015-04-13 06:10:52',30,'42','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 06:10:52.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:7:\"content\";s:6582:\"<p>Bernhard Christen,&nbsp;Dr. med., Facharzt f&uuml;r Orthop&auml;dische Chirurgie und Traumatologie des Bewegungsapparates,&nbsp;Master of Health Administration (M.H.A.)</p>\r\n\r\n<h2>Lebenslauf</h2>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width: 100%;\">\r\n	<tbody>\r\n		<tr>\r\n			<td style=\"width: 231px; vertical-align: top;\">\r\n			<p><strong>1976</strong></p>\r\n			</td>\r\n			<td style=\"width: 1653px; vertical-align: top;\">\r\n			<p>C-Matura Gymnasium Neufeld Bern</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"width: 231px; vertical-align: top;\">\r\n			<p><strong>1977 &ndash; 1982</strong></p>\r\n			</td>\r\n			<td style=\"width: 1653px; vertical-align: top;\">\r\n			<p>Medizinstudium an der Universit&auml;t Bern</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"width: 231px; vertical-align: top;\">\r\n			<p><strong>1982</strong></p>\r\n			</td>\r\n			<td style=\"width: 1653px; vertical-align: top;\">\r\n			<p>Staatsexamen</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"width: 231px; vertical-align: top;\">\r\n			<p><strong>1983 &ndash; 1992</strong></p>\r\n			</td>\r\n			<td style=\"width: 1653px; vertical-align: top;\">\r\n			<p>Diverse Assistenzarztstellen in der Inneren Medizin und Allgemeiner Chirurgie, Orthop&auml;die im B&uuml;rgerspital Solothurn und im Inselspital Bern</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"width: 231px; vertical-align: top;\">\r\n			<p><strong>1987</strong></p>\r\n			</td>\r\n			<td style=\"width: 1653px; vertical-align: top;\">\r\n			<p>Dissertation</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"width: 231px; vertical-align: top;\">\r\n			<p><strong>1992</strong></p>\r\n			</td>\r\n			<td style=\"width: 1653px; vertical-align: top;\">\r\n			<p>Facharzt f&uuml;r Orthop&auml;die und Traumatologie</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"width: 231px; vertical-align: top;\">\r\n			<p><strong>1992 &ndash; 1997</strong></p>\r\n			</td>\r\n			<td style=\"width: 1653px; vertical-align: top;\">\r\n			<p>Oberarzt Orthop&auml;die im B&uuml;rgerspital Solothurn</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"width: 231px; vertical-align: top;\">\r\n			<p><strong>1996</strong></p>\r\n			</td>\r\n			<td style=\"width: 1653px; vertical-align: top;\">\r\n			<p>Fellowship Schulterchirurgie, Universit&auml;tsklinik Balgrist, Z&uuml;rich</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"width: 231px; vertical-align: top;\">\r\n			<p><strong>1997 &ndash; 2002</strong></p>\r\n			</td>\r\n			<td style=\"width: 1653px; vertical-align: top;\">\r\n			<p>Leitender Arzt f&uuml;r Orthop&auml;die und Traumatologie, Chirurgische Klinik, Spital Bern Ziegler</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"width: 231px; vertical-align: top;\">\r\n			<p><strong>2002</strong></p>\r\n			</td>\r\n			<td style=\"width: 1653px; vertical-align: top;\">\r\n			<p>Master of Health Administration (M.H.A.)</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"width: 231px; vertical-align: top;\">\r\n			<p><strong>seit 01.11.2002</strong></p>\r\n			</td>\r\n			<td style=\"width: 1653px; vertical-align: top;\">\r\n			<p>Belegarzt mit Praxis am Salemspital Bern, seit 1.7.2013 mit eigener AG (CHRISTENORTHO AG)</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<h2>F&uuml;hrungserfahrung</h2>\r\n\r\n<ul class=\"tick-list\">\r\n	<li>Jahrelange Mitarbeit als Arzt in milit&auml;rischen St&auml;ben, zuletzt als Divisionsarzt</li>\r\n	<li>der Gebirgsdivision 10.</li>\r\n	<li>Ununterbrochene F&uuml;hrungsposition im Beruf seit 1992.</li>\r\n	<li>1999 - 2001 Berufbegleitendes Nachdiplomstudium &quot;Management im Gesundheitswesen&quot;</li>\r\n	<li>NDS MiG IV an der Universit&auml;t Bern.</li>\r\n	<li>Master of Health Administration (M.H.A.) Ende 2002.</li>\r\n	<li>Pr&auml;sident von Swiss Orthopaedics, der Schweizerischen Gesellschaft f&uuml;r Orthop&auml;die (SGOT) Juni 2012 bis Juni 2014.</li>\r\n	<li>Board Member der European Knee Associates EKA seit Mai 2014, der European Knee Society EKS seit Januar 2015<br />\r\n	&nbsp;</li>\r\n</ul>\r\n\r\n<h2>Aktuelle berufliche Aktivit&auml;ten</h2>\r\n\r\n<ul class=\"tick-list\">\r\n	<li>Belegarzt am Salemspital mit Praxis im Haus Elim und operativer T&auml;tigkeit im Salemspital</li>\r\n	<li>Gr&uuml;ndungsmitglied SportsClinic#1 AG</li>\r\n	<li>Mitglied im Stiftungsrat in der Berner Klinik Montana</li>\r\n	<li>Mitglied der Tarifkommission des Kantons Bern</li>\r\n	<li>Mitglied der parit&auml;tischen Kommission des Kantons Bern&nbsp;</li>\r\n	<li>Mitglied der Expertengruppe Knie (EGK) der Schweizerischen Geselllschaft f&uuml;r Orthop&auml;die (SGOT)</li>\r\n	<li>Past-Pr&auml;sident der Schweizerischen Gesellschaft f&uuml;r Orthop&auml;die und Traumatologie (SGOT) seit Juni 2014&nbsp;</li>\r\n	<li>Founding und Board Member der European Knee Society (EKS) im Januar 2015<br />\r\n	&nbsp;</li>\r\n</ul>\r\n\r\n<h2>Mitgliedschaften</h2>\r\n\r\n<ul class=\"tick-list\">\r\n	<li>Orthop&auml;dische Klinik Bern (OKB; www.ortho-klinik.ch)</li>\r\n	<li>Berner Gesellschaft f&uuml;r Orthop&auml;den (BGO; www.bgo-bern.ch), Pr&auml;sident 2003-2009</li>\r\n	<li>Bernische Beleg&auml;rzte-Vereinigung (BBV+; www.bbvplus.ch)</li>\r\n	<li>Medizinischer Bezirksverein Bern-Stadt</li>\r\n	<li>&Auml;rztegesellschaft des Kantons Bern</li>\r\n	<li>SOCA (Schweizerischer Orthop&auml;discher Club f&uuml;r Austausch und Weiterbildung)</li>\r\n	<li>Swiss orthopaedics (Schweizerische Gesellschaft f&uuml;r Orthop&auml;die und Traumatologie;www.swissorthopaedics.ch), Pr&auml;sident 2012-2014</li>\r\n	<li>Schweizerische Gesellschaft f&uuml;r Traumatologie und Versicherungsmedizin (SGTV; www.sgtv.org)</li>\r\n	<li>Foederatio Medicorum Chirurgicorum Helvetica (FMCH)</li>\r\n	<li>Schweizerische Beleg&auml;rzte-Vereinigung (SBV)</li>\r\n	<li>Verbindung der Schweizer &Auml;rztinnen und &Auml;rzte (FMH)</li>\r\n	<li>Arbeitsgemeinschaft Endoprothetik AE (www.ae-germany.com)</li>\r\n	<li>Akademie der Arbeitsgemeinschaft Endoprothetik AE (www.ae-germany.com)</li>\r\n	<li>Europ&auml;ische Gesellschaft f&uuml;r Kniechirurgie und Arthroskopie (ESSKA; www.esska.org)</li>\r\n	<li>European Knee Associates EKA, Board-member vom Mai 2014 bis Januar 2015&nbsp;</li>\r\n	<li>European Knee Society EKS, Board-member seit Januar 2015</li>\r\n	<li>Vereinigung der Amerikanischen Orthop&auml;dischen Chirurgen (AAOS; www.aaos.org)<br />\r\n	&nbsp;</li>\r\n</ul>\r\n\r\n<h2>Zur Person</h2>\r\n\r\n<p>Vater von drei erwachsenen Kindern, einer Tochter und zwei S&ouml;hnen, zum zweiten Mal verheiratet. Ich fahre leidenschaftlich gerne Ski, spiele regelm&auml;ssig Squash und Unihockey&nbsp;und versuche mich gelegentlich im Golf. Meine Energie hole ich bei der Familie sowie auf Reisen im In- und Ausland.<br />\r\nInteresse f&uuml;r fast Alles, Faszination f&uuml;r Natur, Historik, Fotographie, Kunst, Wein und Sein und gutes Essen.</p>\r\n\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(434,'update','2015-04-13 06:11:50',31,'42','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 06:11:50.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:7:\"content\";s:6571:\"<p>Bernhard Christen,&nbsp;Dr. med., Facharzt f&uuml;r Orthop&auml;dische Chirurgie und Traumatologie des Bewegungsapparates,&nbsp;Master of Health Administration (M.H.A.)</p>\r\n\r\n<h2>Lebenslauf</h2>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width: 100%;\">\r\n	<tbody>\r\n		<tr>\r\n			<td style=\"width: 231px; vertical-align: top;\">\r\n			<p><strong>1976</strong></p>\r\n			</td>\r\n			<td style=\"width: 1653px; vertical-align: top;\">\r\n			<p>C-Matura Gymnasium Neufeld Bern</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"width: 231px; vertical-align: top;\">\r\n			<p><strong>1977 &ndash; 1982</strong></p>\r\n			</td>\r\n			<td style=\"width: 1653px; vertical-align: top;\">\r\n			<p>Medizinstudium an der Universit&auml;t Bern</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"width: 231px; vertical-align: top;\">\r\n			<p><strong>1982</strong></p>\r\n			</td>\r\n			<td style=\"width: 1653px; vertical-align: top;\">\r\n			<p>Staatsexamen</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"width: 231px; vertical-align: top;\">\r\n			<p><strong>1983 &ndash; 1992</strong></p>\r\n			</td>\r\n			<td style=\"width: 1653px; vertical-align: top;\">\r\n			<p>Diverse Assistenzarztstellen in der Inneren Medizin und Allgemeiner Chirurgie, Orthop&auml;die im B&uuml;rgerspital Solothurn und im Inselspital Bern</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"width: 231px; vertical-align: top;\">\r\n			<p><strong>1987</strong></p>\r\n			</td>\r\n			<td style=\"width: 1653px; vertical-align: top;\">\r\n			<p>Dissertation</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"width: 231px; vertical-align: top;\">\r\n			<p><strong>1992</strong></p>\r\n			</td>\r\n			<td style=\"width: 1653px; vertical-align: top;\">\r\n			<p>Facharzt f&uuml;r Orthop&auml;die und Traumatologie</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"width: 231px; vertical-align: top;\">\r\n			<p><strong>1992 &ndash; 1997</strong></p>\r\n			</td>\r\n			<td style=\"width: 1653px; vertical-align: top;\">\r\n			<p>Oberarzt Orthop&auml;die im B&uuml;rgerspital Solothurn</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"width: 231px; vertical-align: top;\">\r\n			<p><strong>1996</strong></p>\r\n			</td>\r\n			<td style=\"width: 1653px; vertical-align: top;\">\r\n			<p>Fellowship Schulterchirurgie, Universit&auml;tsklinik Balgrist, Z&uuml;rich</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"width: 231px; vertical-align: top;\">\r\n			<p><strong>1997 &ndash; 2002</strong></p>\r\n			</td>\r\n			<td style=\"width: 1653px; vertical-align: top;\">\r\n			<p>Leitender Arzt f&uuml;r Orthop&auml;die und Traumatologie, Chirurgische Klinik, Spital Bern Ziegler</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"width: 231px; vertical-align: top;\">\r\n			<p><strong>2002</strong></p>\r\n			</td>\r\n			<td style=\"width: 1653px; vertical-align: top;\">\r\n			<p>Master of Health Administration (M.H.A.)</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"width: 231px; vertical-align: top;\">\r\n			<p><strong>seit 01.11.2002</strong></p>\r\n			</td>\r\n			<td style=\"width: 1653px; vertical-align: top;\">\r\n			<p>Belegarzt mit Praxis am Salemspital Bern, seit 1.7.2013 mit eigener AG (CHRISTENORTHO AG)</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<h2>F&uuml;hrungserfahrung</h2>\r\n\r\n<ul class=\"tick-list\">\r\n	<li>Jahrelange Mitarbeit als Arzt in milit&auml;rischen St&auml;ben, zuletzt als Divisionsarzt der Gebirgsdivision 10.</li>\r\n	<li>Ununterbrochene F&uuml;hrungsposition im Beruf seit 1992.</li>\r\n	<li>1999 - 2001 Berufbegleitendes Nachdiplomstudium &quot;Management im Gesundheitswesen&quot;</li>\r\n	<li>NDS MiG IV an der Universit&auml;t Bern.</li>\r\n	<li>Master of Health Administration (M.H.A.) Ende 2002.</li>\r\n	<li>Pr&auml;sident von Swiss Orthopaedics, der Schweizerischen Gesellschaft f&uuml;r Orthop&auml;die (SGOT) Juni 2012 bis Juni 2014.</li>\r\n	<li>Board Member der European Knee Associates EKA seit Mai 2014, der European Knee Society EKS seit Januar 2015<br />\r\n	&nbsp;</li>\r\n</ul>\r\n\r\n<h2>Aktuelle berufliche Aktivit&auml;ten</h2>\r\n\r\n<ul class=\"tick-list\">\r\n	<li>Belegarzt am Salemspital mit Praxis im Haus Elim und operativer T&auml;tigkeit im Salemspital</li>\r\n	<li>Gr&uuml;ndungsmitglied SportsClinic#1 AG</li>\r\n	<li>Mitglied im Stiftungsrat in der Berner Klinik Montana</li>\r\n	<li>Mitglied der Tarifkommission des Kantons Bern</li>\r\n	<li>Mitglied der parit&auml;tischen Kommission des Kantons Bern&nbsp;</li>\r\n	<li>Mitglied der Expertengruppe Knie (EGK) der Schweizerischen Geselllschaft f&uuml;r Orthop&auml;die (SGOT)</li>\r\n	<li>Past-Pr&auml;sident der Schweizerischen Gesellschaft f&uuml;r Orthop&auml;die und Traumatologie (SGOT) seit Juni 2014&nbsp;</li>\r\n	<li>Founding und Board Member der European Knee Society (EKS) im Januar 2015<br />\r\n	&nbsp;</li>\r\n</ul>\r\n\r\n<h2>Mitgliedschaften</h2>\r\n\r\n<ul class=\"tick-list\">\r\n	<li>Orthop&auml;dische Klinik Bern (OKB; www.ortho-klinik.ch)</li>\r\n	<li>Berner Gesellschaft f&uuml;r Orthop&auml;den (BGO; www.bgo-bern.ch), Pr&auml;sident 2003-2009</li>\r\n	<li>Bernische Beleg&auml;rzte-Vereinigung (BBV+; www.bbvplus.ch)</li>\r\n	<li>Medizinischer Bezirksverein Bern-Stadt</li>\r\n	<li>&Auml;rztegesellschaft des Kantons Bern</li>\r\n	<li>SOCA (Schweizerischer Orthop&auml;discher Club f&uuml;r Austausch und Weiterbildung)</li>\r\n	<li>Swiss orthopaedics (Schweizerische Gesellschaft f&uuml;r Orthop&auml;die und Traumatologie;www.swissorthopaedics.ch), Pr&auml;sident 2012-2014</li>\r\n	<li>Schweizerische Gesellschaft f&uuml;r Traumatologie und Versicherungsmedizin (SGTV; www.sgtv.org)</li>\r\n	<li>Foederatio Medicorum Chirurgicorum Helvetica (FMCH)</li>\r\n	<li>Schweizerische Beleg&auml;rzte-Vereinigung (SBV)</li>\r\n	<li>Verbindung der Schweizer &Auml;rztinnen und &Auml;rzte (FMH)</li>\r\n	<li>Arbeitsgemeinschaft Endoprothetik AE (www.ae-germany.com)</li>\r\n	<li>Akademie der Arbeitsgemeinschaft Endoprothetik AE (www.ae-germany.com)</li>\r\n	<li>Europ&auml;ische Gesellschaft f&uuml;r Kniechirurgie und Arthroskopie (ESSKA; www.esska.org)</li>\r\n	<li>European Knee Associates EKA, Board-member vom Mai 2014 bis Januar 2015&nbsp;</li>\r\n	<li>European Knee Society EKS, Board-member seit Januar 2015</li>\r\n	<li>Vereinigung der Amerikanischen Orthop&auml;dischen Chirurgen (AAOS; www.aaos.org)<br />\r\n	&nbsp;</li>\r\n</ul>\r\n\r\n<h2>Zur Person</h2>\r\n\r\n<p>Vater von drei erwachsenen Kindern, einer Tochter und zwei S&ouml;hnen, zum zweiten Mal verheiratet. Ich fahre leidenschaftlich gerne Ski, spiele regelm&auml;ssig Squash und Unihockey&nbsp;und versuche mich gelegentlich im Golf. Meine Energie hole ich bei der Familie sowie auf Reisen im In- und Ausland.<br />\r\nInteresse f&uuml;r fast Alles, Faszination f&uuml;r Natur, Historik, Fotographie, Kunst, Wein und Sein und gutes Essen.</p>\r\n\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(435,'update','2015-04-13 06:13:04',13,'47','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 06:13:04.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:7:\"content\";s:1259:\"<p>Sprechstunden finden nach telefonischer Vereinbarung in der Regel zweimal w&ouml;chentlich am Dienstag und Donnerstag und einmal monatlich nach Bedarf am Samstag statt. Anmeldungen erfolgen mit Vorteil via Ihren Hausarzt. Nat&uuml;rlich d&uuml;rfen Sie uns aber auch direkt kontaktieren!</p>\r\n\r\n<p>Zust&auml;ndig f&uuml;r die Praxisorganisation ist Frau Verena Vonallmen. Die Vergabe von Sprechstunden- und Operationsterminen erfolgen durch Frau <a href=\"{NODE_30}\">Verena von Allmen</a> und/oder Frau <a href=\"{NODE_30}\">Esther Wyler Christen</a>. Das ganze Praxisteam bem&uuml;ht sich, Sie kompetent, effizient und umsichtig zu betreuen.</p>\r\n\r\n<h2>Anmeldung, Termine und Sprechstunden</h2>\r\n\r\n<p>Wir sind f&uuml;r Sie telefonisch erreichbar unter:&nbsp;<a class=\"icon-phone link-icon\" href=\"#\">+41 31 337 89 24</a></p>\r\n\r\n<p><strong>Montag, Dienstag, Donnerstag und Freitag</strong><br />\r\n09:00 &ndash; 12:00 und 14:00 &ndash; 16:00 Uhr&nbsp;<br />\r\n<strong>Mittwoch</strong><br />\r\n09:00 &ndash; 12:00 Uhr</p>\r\n\r\n<p>Per E-Mail erreichen Sie uns unter:&nbsp;<a class=\"icon-mail link-icon\" href=\"mailto:info@christenortho.ch?subject=Anmeldung%20%2F%20Termin%20%2F%20Sprechstunde\">info@christenortho.ch</a></p>\r\n\r\n<p>Per Fax unter: +41 31 337 89 54</p>\r\n\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(436,'update','2015-04-13 06:13:31',7,'48','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 06:13:31.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:7:\"content\";s:2957:\"<h2>Diagnosestellung im Dialog</h2>\r\n\r\n<p>Ohne sichere oder zumindest wahrscheinliche Diagnose kann die Therapie nicht oder h&ouml;chstens zuf&auml;llig erfolgreich sein. Die Diagnosestellung erfolgt im pers&ouml;nlichen Gespr&auml;ch in der Praxis, wo ich Ihre Patientengeschichte, erg&auml;nzt mit gezielten Fragen, zu begreifen versuche. Die Untersuchung des betroffenen Gelenkes erh&auml;rtet den Verdacht. Untersuchungen wie R&ouml;ntgenbilder und Magnetresonanztomographie (MRI oder MRT), usw. dienen zur Erg&auml;nzung und der weiteren Konkretisierung.</p>\r\n\r\n<p>Abh&auml;ngig von der Diagnose kann ich Ihnen L&ouml;sungsans&auml;tze aufzeigen. Dabei er&ouml;rtere ich die diversen Therapiem&ouml;glichkeiten und zeige die Vor- und Nachteile (Chancen &amp; Risiken) auf. Das Ganze ist immer im Dialog gehalten, damit eine auf Sie pers&ouml;nlich abgestimmte optimale Therapieform heraus kristallisiert werden kann.</p>\r\n\r\n<h2>Der Arzt ber&auml;t, Patienten bestimmen</h2>\r\n\r\n<p>Obwohl ich in erster Linie orthop&auml;discher Chirurg bin und die meiste Zeit meiner Ausbildung f&uuml;r die chirurgische T&auml;tigkeit aufgewendet habe, wird nur ein kleiner Teil der zu mir in die Sprechstunden kommenden Patienten operiert. Die Operation, auch wenn sie noch so klein scheint, ist verbunden mit Risiken und ist nur dann zu rechtfertigen, wenn eine gute Aussicht auf Erfolg besteht und die konservative Behandlung keine Alternative mehr darstellt. Bei einem Wahleingriff steht der Entscheid f&uuml;r oder gegen eine Operation somit nur Ihnen zu!</p>\r\n\r\n<h2>Komplikationen</h2>\r\n\r\n<p>Jede noch so kleine Behandlung kann Komplikationen nach sich ziehen. Meistens unterliegt dann das bisher gute Patienten-Arztvertrauen einem ersten H&auml;rtetest. Ich setze auch hier auf das offene Gespr&auml;ch. Gemeinsam w&auml;gen wir ab und er&ouml;rtern das weitere Vorgehen. Ich werde auch hier versuchen, Ihnen unter Abw&auml;gung der Daf&uuml;r und Dagegen aufzuzeigen, welche Optionen bestehen. Zum obersten Ziel wird, die Komplikation m&ouml;glichst folgenlos zu meistern und gemeinsam das beste Resultat zu erreichen.</p>\r\n\r\n<h2>Die Vorbereitung und die Nachbehandlung</h2>\r\n\r\n<p>Dem Vorher und dem Nachher muss bei Operationen besondere Beachtung geschenkt werden. Somit ist es unabdingbar, dass Sie ihr privates und berufliches Umfeld (R&uuml;cksprache mit dem Arbeitgeber!) vor einem Eingriff optimal einrichten. Wenn Ihnen gewisse Jahreszeiten, Mondphasen oder Sonstiges wichtig sind, werden wir das wenn irgend m&ouml;glich gerne ber&uuml;cksichtigen.</p>\r\n\r\n<p>Die eingeleitete Behandlung aber auch die Nachbehandlung im Anschluss an die Operation m&uuml;ssen konsequent &uuml;berwacht werden. Einem sich m&ouml;glicherweise abzeichnenden Misserfolg kann so rechtzeitig begegnet werden. Dies erfordert einige gezielte Kontrollen bei mir, ausserdem wird auch Ihr Hausarzt bereits fr&uuml;h nach der Spitalentlassung in die Nachbehandlung einbezogen.</p>\r\n\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(437,'update','2015-04-13 06:15:58',11,'53','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 06:15:58.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:7:\"content\";s:10958:\"<p>Hier finden Sie Angaben zu eigenen Publikationen in Schrift, Ton oder Bild in medizinischen Fachzeitschriften oder sonstigen Publikationsorganen. Ausserdem erfahren Sie, was bei christenortho aus Gr&uuml;nden der Qualit&auml;tssicherung zur Zeit genauer untersucht und ausgewertet wird. Schliesslich k&ouml;nnen Sie in dieser Rubrik Hinweise auf besonders wichtige Ver&ouml;ffentlichungen anderer Autoren im Zusammenhang mit dem T&auml;tigkeitsbereich von christenortho finden.</p>\r\n\r\n<h2>Laufende Arbeiten bei christenortho</h2>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">KOOS und HOOS Score</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Alle Patienten, die sich f&uuml;r eine Knie- oder H&uuml;ftprothese&nbsp;entscheiden, werden gebeten, vor und 1 Jahr nach der Operation den KOOS Score f&uuml;r Knie und HOOS Score f&uuml;r H&uuml;fte (Beantwortung von ca. 100 Fragen) auszuf&uuml;llen. Die Fragebogen basieren ausschliesslich auf Ihren Angaben und geh&ouml;ren somit zu den heute generell verlangten Patient related outcome Messungen (PROM), ohne die eine Auswertung nicht mehr akzeptiert wird. Der KOOS und HOOS Score sind validiert und international anerkannt, um detaillierte Angaben zu Knie- und H&uuml;ftprothesen zu erhalten. Erg&auml;nzend werden Untersuchungsresultate des Arztes und R&ouml;ntgenauswertungen die Beurteilung des Resultates abrunden.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">SIRIS</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Alle Knie- und H&uuml;ftprothesen bei CHRISTENORTHO AG werden seit dem 1.1.2008 systematisch auf elektronische Weise (unter Wahrung der Patientenanonymit&auml;t) ins Schweizerische Prothesenregister eingegeben. S&auml;mtliche Journey-Knieprothesen wurden retrospektiv seit der Erstimplantation am 1.12.2006 erfasst. Seit September 2012 ist die Erfassung der Knie- und H&uuml;ftprothesen in der Schweiz obligatorisch <a href=\"http://www.siris-implant.ch\" target=\"_blank\">(Schweizerisches Prothesenregister SIRIS)</a>.<br />\r\nBei allen Prothesen erfolgt die Eingabe vor und nach jeder Operation sowie anl&auml;sslich der Jahreskontrolle.&nbsp;Muss eine Prothese reoperiert werden, impliziert dies einen neuen Eintrag ins Register. Damit k&ouml;nnen in relativ kurzer Zeit viel Aussagen &uuml;ber&nbsp;Zuverl&auml;ssigkeit eines Operationsverfahrens und einer Prothese gemacht werden.</p>\r\n\r\n<p>Jederzeit k&ouml;nnen Auswertungen der eigenen, eingegebenen Daten erhoben und anonym mit anderen Zentren der Schweiz verglichen werden. Ziel ist selbstredend, das SIRIS auch mit internationalen Registern (Schweden, Finnland Norwegen,&nbsp;Australien, Neuseeland, usw.) zu verkn&uuml;pfen.</p>\r\n</div>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h2>Studien</h2>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Kein Unterschied zwischen mobilen und fixen Polyaethyleneins&auml;tzen im balanSys-Knie</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>In einer prospektiv randomisierten Arbeit in Zusammenarbeit mit dem Zieglerspital Bern und der Sint Maartenskliniek in Nijmegen konnten bei 92 Patienten 3, 6 und 12 Monate nach Knie-Totalprothese in den zwei Gruppen keine signifikanten Unterschiede in der aktiven Beugef&auml;higkeit der Kniegelenke gezeigt werden. Verglichen wurden zwei verschiedene Kunststoffteile bei sonst identischem Prothesendesign. Bei der einen Gruppe wurde das Polyaethylen fix am Schienbeinteil eingerastet, bei der anderen wurde ein sogenannt moblier L&auml;ufer verwendet, der sich drehen und besch&auml;nkt auch nach vorne, respektive hinten bewegen kann. Patienten mit dem fixen Polyaethylen hatten weniger Schwierigkeiten mit dem Treppen steigen in der Fr&uuml;hphase nach der Operation. Die Arbeit wurde im Journal KSSTA (Knee Surg Sports Traumatol Arthrosc) 2012 publiziert (Jacobs WCH et al., Funcitonal performance of mobile versus fixed bearing total knee prosthesis: a randomised controlled trial, KSSTA 2012, 20: 1450-55).</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Prospektive randomisierte Studie &uuml;ber Analgesie nach Schulteroperationen</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Zusammen mit 4 An&auml;sthesisten und des Schmerzdienstes des Salemspitals wurden 50 Patienten in eine prospektiv randomisierte Arbeit eingschlossen, deren Daten noch komplettiert und ausgewertet werden m&uuml;ssen. Verglichen wurde dabei die Schmerzbehandlung in den ersten 2 Tagen nach der Operation von gr&ouml;sseren Schultereingriffen (Rekonstuktion der Rotatorenmanschette, Schulterprothese). Die Operationen wurden alle in Allgemeinnarkose durchgef&uuml;hrt. Die eine Gruppe erhielt in klassischer Weise nach der Opration eine Schmerzpumpe, &uuml;ber welche sich der Patient selbst&auml;ndig die notwendige Menge an Schmerzmitteln zuf&uuml;gen konnte. In der anderen Gruppe wurde unmittelbar vor der Operation unter Stimulation und Ultraschallkontrolle ein Katheter auf die Armnerven auf H&ouml;he des Halsrandes eingelegt. &Uuml;ber diesen Katheter wurde ein lokales Bet&auml;ubungsmittel per Pumpe nach Bedarf eingebracht. Verglichen wurden Schmerzintensit&auml;t, Schmerzmittelbedarf und Resultate nach der Schulteroperation. Die Datenerhebung und Auswertung sind noch im Gange. Grob sind zwischen den beiden Gruppen keine gr&ouml;sseren Unterschiede festzustellen, dies bleibt statistisch auszuwerten.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Balancierung des hinteren Kreuzbandes bei Knieprothesen</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Bei 101 Kniegelenken wurden bei einer Knie-Totalprothese intraoperativ Messungen durchgef&uuml;hrt, um mehr Erkenntnisse &uuml;ber das Verhalten des hinteren Kreuzbandes zu gewinnen. Dies ist bei Prothesenmodellen zentral, bei denen das hintere Kreuzband erhalten wird und von dem man den Erhalt seiner Funktion zugrunde legt. Die Arbeit mit Journeyprothesen war insofern aufschlussreich, als bei dieser Prothese beide Kreuzb&auml;nder entfernt werden (vgl. &quot;Das Journey Knie&quot;). Somit konnten die Messungen mit prim&auml;rem Erhalt des hinteren Kreuzbandes und dann nach Entfernung durchgef&uuml;hrt werden. Die Studie liefert keine eindeutigen Resultate, welche die korrekte Balancierung des hinteren Kreuzbandes sicher erlauben w&uuml;rde.</p>\r\n\r\n<p>Die Arbeit wurde im Juni 2010 am Europ&auml;ischen Kniekongress der ESSKA in Oslo pr&auml;sentiert. Sie ist elektronisch im Journal KSSTA (Knee Surgery Sports Traumatology Arthroscopy) im Juli 2011 publiziert und ist in gedruckter Form in der Ausgabe 3 vom M&auml;rz 2012 erschienen.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Die ersten 226 Journey Kniegelenke</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Die Resultate der ersten 103 Journey Knieprothesen, welche seit dem 1.12.2006 im Salemspital eingesetzt worden sind, wurden als Poster am Europ&auml;ischen Kniekongress in Oslo 2010 vorgestellt.<br />\r\nMittlerweile wurde &uuml;ber 226 derartige Gelenke implantiert. Kurzfristige Resultate wurden vom 27.-29. April 2011 am S&uuml;ddeutschen Orthop&auml;den Kongress in Baden-Baden und im Juni an der Jahrestagung der Scheizerischen Gesellschaft f&uuml;r Orthop&auml;die und Traumatologie vorgestellt.</p>\r\n\r\n<p>Das Knie liefert &uuml;berduchschnittlich gute kurzfristige Resultate, allerdings mit mehr Komplikationen als herk&ouml;mmliche Gelenke. Die Komplikationsrate nimmt mit Zunahme der Erfahrung des Chirurgen ab, bleibt aber leicht erh&ouml;ht. Offenbar verzeiht das Journey-System keine, auch nur kleine Abweichungen von der idealen Positionierung. Es scheint auch weniger geeignet bei eher laxen Verh&auml;ltnissen, sofern nicht eine kr&auml;ftige Muskulatur vorhanden ist.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">102 herk&ouml;mmlich implantierte versus 124 navigierte Journey-Prothesen</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Durch Einsatz der Computernavigation konnte die Pr&auml;zision der Knochenschnitte an Schienbeinkopf und Oberschenkel nicht signifikant verbessert werden. Hingegen k&ouml;nnen die Ausreisser bez&uuml;glich Achsenfehler sowohl f&uuml;r das X- wie O-Bein reduziert werden. Die Wertigkeit der Navigation bleibt somit - wie in der Literatur - weiter umstritten. Es stellt sich nach wie vor die Frage, ob die Verl&auml;ngerung der Operationszeit um ca. 10-15 Minuten und die Kosten f&uuml;r die Navigation (z.B. f&uuml;r die Markerkugeln) gerechtfertigt werden kann.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Hydroxiappatit-beschichtete zementfreie H&uuml;ftsch&auml;fte vom Typus SL MIA sinken weniger ein als nicht beschichtete Sch&auml;fte</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>H&uuml;ft-Totalprothesen d&uuml;rfen heute dank der &nbsp;weniger invasiven Technik sofort voll belastet werden, dies obwohl zementfreie Verankerungen immer h&auml;ufiger Anwendung finden. In R&ouml;ntgenkontrollen nach der Operation sowie nach 3 und 12 Monaten fiel auf, dass die Sch&auml;fte zum Nachsinken neigen.</p>\r\n\r\n<p>In einer vergleichenden Studie konnten wir zeigen, dass die neuen, beschichteten Sch&auml;fte statistisch signifikant weniger nachsintern als das nicht beschichtete Vorg&auml;ngermodell. Diese wurde wurden in Baden-Baden und am SGOT Kongress in Lausanne vorgestellt. Wir verwenden nur noch die beschichteten H&uuml;ftsch&auml;fte.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Auswertung Pain Score SEQ</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Die Resultate des Pain Scores sind eindr&uuml;cklich, da sie dank dem Vergleich mit der Normalbev&ouml;lkerung die Einschr&auml;nkungen jeweils vor einer Operation (H&uuml;ft- oder Knie-Totalprothese, respektive Rekonstruktion der Rotatorenmanschette) sichtbar machen und durch die Wiederholung nach einem Jahr die Verbesserung durch den Eingriff zeigen. Zu diesem Zeitpunkt kann wiederum mit der Normalbev&ouml;lkerung verglichen werden.</p>\r\n\r\n<p>Der Score soll mit einem g&auml;ngigen Wertesystem bei Knieeingriffen (KOOS-Score) verglichen werden. Ziel sind 75 Patienten, welche beide Scores jeweils vor der Knie-Totalprothese und 1 Jahr danach ausgef&uuml;llt haben. Die Auswertung erfolgt im Rahmen einer Disseration und Masterarbeit von Matthias Christen.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">LARS Band</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Seit 3 Jahren wird bei Sehnendefekten in erster Linie im Bereich des Kniegelenkes ein Polyesterband (LARS) zur Verst&auml;rkung eingen&auml;ht, das in der Tumorchirurgie gut erprobt ist. Die ersten Resultate wurden im April 2011 in Baden-Baden am S&uuml;ddeutschen Orthop&auml;den Kongress und im Juni 2011 an der Jahrestagung der Schweizerischen Gesellschaft f&uuml;r Orthop&auml;die und Traumatologie SGOT vorgestellt.</p>\r\n</div>\r\n\r\n<p>&nbsp;</p>\r\n\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(438,'update','2015-04-13 06:17:03',42,'36','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 06:17:03.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:7:\"content\";s:3906:\"<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td style=\"width: 50%; vertical-align: top;\">\r\n			<h2>Adresse</h2>\r\n			</td>\r\n			<td style=\"vertical-align: top;\">&nbsp;</td>\r\n			<td style=\"width: 50%; vertical-align: top;\">\r\n			<h2>&Ouml;ffnungszeiten</h2>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"vertical-align: top;\">\r\n			<p><strong>CHRISTENORTHO AG</strong><br />\r\n			Dr. med., M.H.A. Bernhard Christen<br />\r\n			Orthop&auml;dische Klinik Bern<br />\r\n			Sch&auml;nzlistrasse 39<br />\r\n			CH-3000 Bern 25<br />\r\n			<br />\r\n			Telefon +41 31 337 89 24<br />\r\n			Telefax +41 31 337 89 54<br />\r\n			<a href=\"mailto:info@christenortho.ch\">info@christenortho.ch</a><br />\r\n			&nbsp;</p>\r\n			</td>\r\n			<td style=\"vertical-align: top;\">&nbsp;</td>\r\n			<td style=\"vertical-align: top;\">\r\n			<p><strong>Montag, Dienstag, Donnerstag und Freitag</strong><br />\r\n			09:00 &ndash; 12:00 und 14:00 &ndash; 16:00 Uhr&nbsp;<br />\r\n			<strong>Mittwoch</strong><br />\r\n			09:00 &ndash; 12:00 Uhr</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td style=\"width:50%\">\r\n			<h2>SOS-Notfall</h2>\r\n			</td>\r\n			<td>&nbsp;</td>\r\n			<td style=\"width:50%\">\r\n			<h2>&nbsp;</h2>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Apotheken Notfalldienst</strong><br />\r\n			Telefon 0900 98 99 00<br />\r\n			&nbsp;</p>\r\n			</td>\r\n			<td>\r\n			<p>&nbsp;</p>\r\n			</td>\r\n			<td>\r\n			<p><strong>Notfalldienst Salemspital</strong><br />\r\n			Telefon 031 335 35 35</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<h2>Anfahrt</h2>\r\n\r\n<p><img alt=\"\" src=\"http://fakeimg.pl/767x250/?text=Google Maps\" /></p>\r\n\r\n<p>Bus Nummer 10 Richtung Ostermundigen/R&uuml;ti, Haltestelle Salem oder Tram Nummer 9 Richtung Guisanplatz, Haltestelle Viktoriaplatz.</p>\r\n\r\n<p>Unsere Praxis befindet sich im Haus Elim im Salemspital, erreichbar &uuml;ber den Haupteingang, in Verl&auml;ngerung des Geschosses A1.</p>\r\n\r\n<h2>Salemspital</h2>\r\n\r\n<p><a href=\"http://www.bernerzeitung.ch/schweiz/standard/Schweizer-Aerzte-greifen-im-Zweifel-zum-Skalpell/story/12275394\" target=\"_blank\"><img alt=\"\" src=\"/media/archive1/Praxis/Salem.jpg\" style=\"margin-right: 24px; float: left;\" /></a>Das 1888 erbaute Salemspital hat eine lange Tradition. Das heute zur Privatklinikgruppe Hirslanden geh&ouml;rende Spital bietet ein breites Spektrum von medizinischen Dienstleistungen an.</p>\r\n\r\n<p>Die moderne Infrastruktur und die hohe medizinische Fachkompetenz bestimmen seit Jahren das Handeln und die Philosophie des Salemspitals.</p>\r\n\r\n<p>Steter Wandel und innovatives Schaffen stehen f&uuml;r das Spitalleitbild: &bdquo;Sich mit K&ouml;nnen, Wissen und Gewissen f&uuml;r die Patienten zu engagieren und f&uuml;r Menschen da zu sein&ldquo;!</p>\r\n\r\n<p>​Eine Aussage, die sich mit der Er&ouml;ffnung der Orthop&auml;dischen Klinik Bern im November 2002 einmal mehr untermauern liess und ein Credo, welches in der Orthop&auml;dischen Klinik und speziell auch bei christenortho Tag f&uuml;r Tag neu gelebt und praktiziert wird.</p>\r\n\r\n<ul>\r\n	<li>Website besuchen (MIT LINK ICON)</li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h2>Klinik Siloah</h2>\r\n\r\n<p><a href=\"http://www.bernerzeitung.ch/schweiz/standard/Schweizer-Aerzte-greifen-im-Zweifel-zum-Skalpell/story/12275394\" target=\"_blank\"><img alt=\"\" src=\"/media/archive1/Praxis/Salem.jpg\" style=\"margin-right: 24px; float: left;\" /></a>Dies ist ein Typoblindtext. An ihm kann man sehen, ob alle Buchstaben da sind und wie sie aussehen. Manchmal benutzt man Worte wie Hamburgefonts, Rafgenduks oder Handgloves, um Schriften zu testen. Manchmal S&auml;tze, die alle Buchstaben des Alphabets enthalten - man nennt diese S&auml;tze &raquo;Pangrams&laquo;. Sehr bekannt ist dieser: The quick brown fox jumps over the lazy old dog.</p>\r\n\r\n<ul>\r\n	<li>Website besuchen (MIT LINK ICON)</li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(439,'update','2015-04-13 06:20:46',14,'51','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 06:20:46.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:7:\"content\";s:3120:\"<p>Hier finden Sie zusammengestellte Presseartikel und Interviews, welche sich zum Teil mit konkreten Themen aus dem Bereich der Orthop&auml;die, teilweise mehr mit aktuellen politischen Diskussionen auseinander setzen.<br />\r\n&nbsp;</p>\r\n<section class=\"content-section\">\r\n<h2>Schweizer &Auml;rzte greifen im Zweifel zum Skalpell</h2>\r\n\r\n<p>Medium: Berner Zeitung,&nbsp;Ver&ouml;ffentlichung: 24.09.2014</p>\r\n\r\n<p><a href=\"http://www.bernerzeitung.ch/schweiz/standard/Schweizer-Aerzte-greifen-im-Zweifel-zum-Skalpell/story/12275394\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Teaser_Presse/bzbericht.gif\" /></a>Nehmen &Auml;rzte und Spit&auml;ler hierzulande unn&ouml;tige Eingriffe vor? Dieser schwere Vorwurf wird in letzter Zeit immer &ouml;fter erhoben. Besonders unter Verdacht stehen die Orthop&auml;den.<br />\r\n<br />\r\n<a href=\"http://www.bernerzeitung.ch/schweiz/standard/Schweizer-Aerzte-greifen-im-Zweifel-zum-Skalpell/story/12275394\" target=\"_blank\">Bericht lesen</a><br />\r\n&nbsp;</p>\r\n</section>\r\n<section class=\"content-section\">\r\n<h2>Nicht alle Operationen sind n&ouml;tig</h2>\r\n\r\n<p>Medium: NZZ am Sonntag,&nbsp;Ver&ouml;ffentlichung: 25.08.2013</p>\r\n\r\n<p><a href=\"/media/archive1/Artikel_Presse/NZZ_August_2013.pdf\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Teaser_Presse/Nzz.bmp\" /></a>Es besteht der Verdacht, dass auch in der Schweiz zumTeil unn&ouml;tig operiert wird. Die Einf&uuml;hrung der Fallpauschalen in den Spit&auml;lern d&uuml;rfte das Problem versch&auml;rft haben...<br />\r\n<br />\r\n<a href=\"/media/archive1/Artikel_Presse/NZZ_August_2013.pdf\" target=\"_blank\">Bericht lesen</a><br />\r\n&nbsp;</p>\r\n</section>\r\n<section class=\"content-section\">\r\n<h2>Billigprothesen in der Orthop&auml;die und DRG</h2>\r\n\r\n<p>Medium: MEDIAPLANET,&nbsp;Ver&ouml;ffentlichung: 15.09.2012</p>\r\n\r\n<p><a href=\"/media/archive1/Artikel_Presse/Orthopaedie_3.pdf\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Teaser_Presse/Orthopaedie_NR3.jpg\" /></a>Die Preise f&uuml;r die Implantate verschlingen schon heute einen erheblichen Teil der jeweiligen DRG Pauschale...<br />\r\n<br />\r\n<a href=\"/media/archive1/Artikel_Presse/Orthopaedie_3.pdf\" target=\"_blank\">Bericht lesen</a></p>\r\n</section>\r\n<section class=\"content-section\">\r\n<h2>Schwierige Ausganslage f&uuml;r Revisionoperationen</h2>\r\n\r\n<p>Medium: MEDIAPLANET,&nbsp;Ver&ouml;ffentlichung: 15.06.2011</p>\r\n\r\n<p><a href=\"/media/archive1/Artikel_Presse/Orthopaedie_4.pdf\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Teaser_Presse/Orthopaedie_NR4.jpg\" /></a>F&uuml;r viele ist ein k&uuml;nstliches Gelenk eine Erl&ouml;sung von Schmerzen und Einschr&auml;nkungen. Doch bei rund 20 Prozent der Patienten treten nach der Operation Komplikationen auf oder sie sind mit ihrem neuen Gelenk nicht zufrieden. Sie unterziehen sich oft einer Revisionsoperation. H&auml;ufige Ursachen hierf&uuml;r sind technische Fehler, Infektionen oder mechanische Probleme.<br />\r\n<br />\r\n<a href=\"/media/archive1/Artikel_Presse/Orthopaedie_4.pdf\" target=\"_blank\">Bericht lesen</a></p>\r\n</section>\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(440,'update','2015-04-13 06:30:44',15,'51','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 06:30:44.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:7:\"content\";s:3366:\"<p>Hier finden Sie zusammengestellte Presseartikel und Interviews, welche sich zum Teil mit konkreten Themen aus dem Bereich der Orthop&auml;die, teilweise mehr mit aktuellen politischen Diskussionen auseinander setzen.<br />\r\n&nbsp;</p>\r\n\r\n<section class=\"content-section\">\r\n<h2 class=\"content-section-title\">Schweizer &Auml;rzte greifen im Zweifel zum Skalpell</h2>\r\n\r\n<p class=\"content-section-meta\">Medium: Berner Zeitung,&nbsp;Ver&ouml;ffentlichung: 24.09.2014</p>\r\n\r\n<p><a href=\"http://www.bernerzeitung.ch/schweiz/standard/Schweizer-Aerzte-greifen-im-Zweifel-zum-Skalpell/story/12275394\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Teaser_Presse/bzbericht.gif\" /></a>Nehmen &Auml;rzte und Spit&auml;ler hierzulande unn&ouml;tige Eingriffe vor? Dieser schwere Vorwurf wird in letzter Zeit immer &ouml;fter erhoben. Besonders unter Verdacht stehen die Orthop&auml;den.<br />\r\n<br />\r\n<a href=\"http://www.bernerzeitung.ch/schweiz/standard/Schweizer-Aerzte-greifen-im-Zweifel-zum-Skalpell/story/12275394\" target=\"_blank\">Bericht lesen</a><br />\r\n&nbsp;</p>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2 class=\"content-section-title\">Nicht alle Operationen sind n&ouml;tig</h2>\r\n\r\n<p class=\"content-section-meta\">Medium: NZZ am Sonntag,&nbsp;Ver&ouml;ffentlichung: 25.08.2013</p>\r\n\r\n<p><a href=\"/media/archive1/Artikel_Presse/NZZ_August_2013.pdf\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Teaser_Presse/Nzz.bmp\" /></a>Es besteht der Verdacht, dass auch in der Schweiz zumTeil unn&ouml;tig operiert wird. Die Einf&uuml;hrung der Fallpauschalen in den Spit&auml;lern d&uuml;rfte das Problem versch&auml;rft haben...<br />\r\n<br />\r\n<a href=\"/media/archive1/Artikel_Presse/NZZ_August_2013.pdf\" target=\"_blank\">Bericht lesen</a><br />\r\n&nbsp;</p>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2 class=\"content-section-title\">Billigprothesen in der Orthop&auml;die und DRG</h2>\r\n\r\n<p class=\"content-section-meta\">Medium: MEDIAPLANET,&nbsp;Ver&ouml;ffentlichung: 15.09.2012</p>\r\n\r\n<p><a href=\"/media/archive1/Artikel_Presse/Orthopaedie_3.pdf\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Teaser_Presse/Orthopaedie_NR3.jpg\" /></a>Die Preise f&uuml;r die Implantate verschlingen schon heute einen erheblichen Teil der jeweiligen DRG Pauschale...<br />\r\n<br />\r\n<a href=\"/media/archive1/Artikel_Presse/Orthopaedie_3.pdf\" target=\"_blank\">Bericht lesen</a></p>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2 class=\"content-section-title\">Schwierige Ausganslage f&uuml;r Revisionoperationen</h2>\r\n\r\n<p class=\"content-section-meta\">Medium: MEDIAPLANET,&nbsp;Ver&ouml;ffentlichung: 15.06.2011</p>\r\n\r\n<p><a href=\"/media/archive1/Artikel_Presse/Orthopaedie_4.pdf\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Teaser_Presse/Orthopaedie_NR4.jpg\" /></a>F&uuml;r viele ist ein k&uuml;nstliches Gelenk eine Erl&ouml;sung von Schmerzen und Einschr&auml;nkungen. Doch bei rund 20 Prozent der Patienten treten nach der Operation Komplikationen auf oder sie sind mit ihrem neuen Gelenk nicht zufrieden. Sie unterziehen sich oft einer Revisionsoperation. H&auml;ufige Ursachen hierf&uuml;r sind technische Fehler, Infektionen oder mechanische Probleme.<br />\r\n<br />\r\n<a href=\"/media/archive1/Artikel_Presse/Orthopaedie_4.pdf\" target=\"_blank\">Bericht lesen</a></p>\r\n</section>\r\n\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(441,'update','2015-04-13 06:34:22',16,'51','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 06:34:22.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:7:\"content\";s:3505:\"<p>Hier finden Sie zusammengestellte Presseartikel und Interviews, welche sich zum Teil mit konkreten Themen aus dem Bereich der Orthop&auml;die, teilweise mehr mit aktuellen politischen Diskussionen auseinander setzen.<br />\r\n&nbsp;</p>\r\n\r\n<section class=\"content-section\">\r\n<h2 class=\"content-section-title\">Schweizer &Auml;rzte greifen im Zweifel zum Skalpell</h2>\r\n\r\n<p class=\"content-section-meta\">Medium: Berner Zeitung,&nbsp;Ver&ouml;ffentlichung: 24.09.2014</p>\r\n\r\n<p><a href=\"http://www.bernerzeitung.ch/schweiz/standard/Schweizer-Aerzte-greifen-im-Zweifel-zum-Skalpell/story/12275394\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Teaser_Presse/bzbericht.gif\" /></a>Nehmen &Auml;rzte und Spit&auml;ler hierzulande unn&ouml;tige Eingriffe vor? Dieser schwere Vorwurf wird in letzter Zeit immer &ouml;fter erhoben. Besonders unter Verdacht stehen die Orthop&auml;den.</p>\r\n\r\n<ul>\r\n	<li><a class=\"icon-link link-icon\" href=\"http://www.bernerzeitung.ch/schweiz/standard/Schweizer-Aerzte-greifen-im-Zweifel-zum-Skalpell/story/12275394\" target=\"_blank\">Bericht lesen</a><br />\r\n	&nbsp;</li>\r\n</ul>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2 class=\"content-section-title\">Nicht alle Operationen sind n&ouml;tig</h2>\r\n\r\n<p class=\"content-section-meta\">Medium: NZZ am Sonntag,&nbsp;Ver&ouml;ffentlichung: 25.08.2013</p>\r\n\r\n<p><a href=\"/media/archive1/Artikel_Presse/NZZ_August_2013.pdf\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Teaser_Presse/Nzz.bmp\" /></a>Es besteht der Verdacht, dass auch in der Schweiz zumTeil unn&ouml;tig operiert wird. Die Einf&uuml;hrung der Fallpauschalen in den Spit&auml;lern d&uuml;rfte das Problem versch&auml;rft haben...</p>\r\n\r\n<ul>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"/media/archive1/Artikel_Presse/NZZ_August_2013.pdf\" target=\"_blank\">Bericht lesen</a><br />\r\n	&nbsp;</li>\r\n</ul>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2 class=\"content-section-title\">Billigprothesen in der Orthop&auml;die und DRG</h2>\r\n\r\n<p class=\"content-section-meta\">Medium: MEDIAPLANET,&nbsp;Ver&ouml;ffentlichung: 15.09.2012</p>\r\n\r\n<p><a href=\"/media/archive1/Artikel_Presse/Orthopaedie_3.pdf\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Teaser_Presse/Orthopaedie_NR3.jpg\" /></a>Die Preise f&uuml;r die Implantate verschlingen schon heute einen erheblichen Teil der jeweiligen DRG Pauschale...</p>\r\n\r\n<p><a class=\"icon-pdf link-icon\" href=\"/media/archive1/Artikel_Presse/Orthopaedie_3.pdf\" target=\"_blank\">Bericht lesen</a></p>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2 class=\"content-section-title\">Schwierige Ausganslage f&uuml;r Revisionoperationen</h2>\r\n\r\n<p class=\"content-section-meta\">Medium: MEDIAPLANET,&nbsp;Ver&ouml;ffentlichung: 15.06.2011</p>\r\n\r\n<p><a href=\"/media/archive1/Artikel_Presse/Orthopaedie_4.pdf\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Teaser_Presse/Orthopaedie_NR4.jpg\" /></a>F&uuml;r viele ist ein k&uuml;nstliches Gelenk eine Erl&ouml;sung von Schmerzen und Einschr&auml;nkungen. Doch bei rund 20 Prozent der Patienten treten nach der Operation Komplikationen auf oder sie sind mit ihrem neuen Gelenk nicht zufrieden. Sie unterziehen sich oft einer Revisionsoperation. H&auml;ufige Ursachen hierf&uuml;r sind technische Fehler, Infektionen oder mechanische Probleme.</p>\r\n\r\n<ul>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"/media/archive1/Artikel_Presse/Orthopaedie_4.pdf\" target=\"_blank\">Bericht lesen</a></li>\r\n</ul>\r\n</section>\r\n\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(442,'update','2015-04-13 06:34:53',17,'51','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 06:34:52.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:7:\"content\";s:3491:\"<p>Hier finden Sie zusammengestellte Presseartikel und Interviews, welche sich zum Teil mit konkreten Themen aus dem Bereich der Orthop&auml;die, teilweise mehr mit aktuellen politischen Diskussionen auseinander setzen.</p>\r\n\r\n<section class=\"content-section\">\r\n<h2 class=\"content-section-title\">Schweizer &Auml;rzte greifen im Zweifel zum Skalpell</h2>\r\n\r\n<p class=\"content-section-meta\">Medium: Berner Zeitung,&nbsp;Ver&ouml;ffentlichung: 24.09.2014</p>\r\n\r\n<p><a href=\"http://www.bernerzeitung.ch/schweiz/standard/Schweizer-Aerzte-greifen-im-Zweifel-zum-Skalpell/story/12275394\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Teaser_Presse/bzbericht.gif\" /></a>Nehmen &Auml;rzte und Spit&auml;ler hierzulande unn&ouml;tige Eingriffe vor? Dieser schwere Vorwurf wird in letzter Zeit immer &ouml;fter erhoben. Besonders unter Verdacht stehen die Orthop&auml;den.</p>\r\n\r\n<ul>\r\n	<li><a class=\"icon-link link-icon\" href=\"http://www.bernerzeitung.ch/schweiz/standard/Schweizer-Aerzte-greifen-im-Zweifel-zum-Skalpell/story/12275394\" target=\"_blank\">Bericht lesen</a><br />\r\n	&nbsp;</li>\r\n</ul>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2 class=\"content-section-title\">Nicht alle Operationen sind n&ouml;tig</h2>\r\n\r\n<p class=\"content-section-meta\">Medium: NZZ am Sonntag,&nbsp;Ver&ouml;ffentlichung: 25.08.2013</p>\r\n\r\n<p><a href=\"/media/archive1/Artikel_Presse/NZZ_August_2013.pdf\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Teaser_Presse/Nzz.bmp\" /></a>Es besteht der Verdacht, dass auch in der Schweiz zumTeil unn&ouml;tig operiert wird. Die Einf&uuml;hrung der Fallpauschalen in den Spit&auml;lern d&uuml;rfte das Problem versch&auml;rft haben...</p>\r\n\r\n<ul>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"/media/archive1/Artikel_Presse/NZZ_August_2013.pdf\" target=\"_blank\">Bericht lesen</a><br />\r\n	&nbsp;</li>\r\n</ul>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2 class=\"content-section-title\">Billigprothesen in der Orthop&auml;die und DRG</h2>\r\n\r\n<p class=\"content-section-meta\">Medium: MEDIAPLANET,&nbsp;Ver&ouml;ffentlichung: 15.09.2012</p>\r\n\r\n<p><a href=\"/media/archive1/Artikel_Presse/Orthopaedie_3.pdf\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Teaser_Presse/Orthopaedie_NR3.jpg\" /></a>Die Preise f&uuml;r die Implantate verschlingen schon heute einen erheblichen Teil der jeweiligen DRG Pauschale...</p>\r\n\r\n<p><a class=\"icon-pdf link-icon\" href=\"/media/archive1/Artikel_Presse/Orthopaedie_3.pdf\" target=\"_blank\">Bericht lesen</a></p>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2 class=\"content-section-title\">Schwierige Ausganslage f&uuml;r Revisionoperationen</h2>\r\n\r\n<p class=\"content-section-meta\">Medium: MEDIAPLANET,&nbsp;Ver&ouml;ffentlichung: 15.06.2011</p>\r\n\r\n<p><a href=\"/media/archive1/Artikel_Presse/Orthopaedie_4.pdf\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Teaser_Presse/Orthopaedie_NR4.jpg\" /></a>F&uuml;r viele ist ein k&uuml;nstliches Gelenk eine Erl&ouml;sung von Schmerzen und Einschr&auml;nkungen. Doch bei rund 20 Prozent der Patienten treten nach der Operation Komplikationen auf oder sie sind mit ihrem neuen Gelenk nicht zufrieden. Sie unterziehen sich oft einer Revisionsoperation. H&auml;ufige Ursachen hierf&uuml;r sind technische Fehler, Infektionen oder mechanische Probleme.</p>\r\n\r\n<ul>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"/media/archive1/Artikel_Presse/Orthopaedie_4.pdf\" target=\"_blank\">Bericht lesen</a></li>\r\n</ul>\r\n</section>\r\n\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(443,'update','2015-04-13 06:36:47',38,'52','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 06:36:47.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:7:\"content\";s:4028:\"<p>Hier finden Sie eine Zusammenstellung von diversen Fernsehauftritten, welche ich in den letzten Jahren &ndash; meistens zum Thema Kniegelenk / Knieprothese &ndash; hatte. Die Beitr&auml;ge sind auch direkt im Kapital Kniegelenk abrufbar. Die Informationen sind bruchst&uuml;ckhaft und plakativ und sind deshalb als Erg&auml;nzung zu den schriftlichen Angaben zu den einzelnen Themen dieser Webseite gedacht. Zusammen mit Ausk&uuml;nften von Patienten geben sie aber eine wertvolle pers&ouml;nliche Einsch&auml;tzung ab. Ich w&uuml;nsche gute Unterhaltung und vor allem eine wertvolle erg&auml;nzende Information.</p>\r\n\r\n<h2>Computernavigation in der Knieprothetik</h2>\r\n\r\n<p>TV-Sendung: TeleB&auml;rn / praxis gsundheit,&nbsp;Ausstrahlung: 01.09.2014</p>\r\n\r\n<p><a href=\"http://www.santemedia.ch/de/medizinische-sendungen.1193/praxis-gsundheit-telebarn.1668/computernavigation-in-der-knieprothetik.2132.html\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Teaser_TV/Computernavigation_Knieprothetik.jpg\" /></a>Die Computernavigation in der Orthop&auml;die bedeutet das Einbringen eines k&uuml;nstlichen Gelenkes unter Zuhilfenahme eines Computersystems. Dieses System hilft dem Operateur, die einzelnen Komponenten der Knieprothese sehr genau zu platzieren. Ein neues Computernavigationsystem bezieht nun die B&auml;nder und Weichteile mit ein. Wie ist die Anwendung? Was sind die Vorteile? Und was ist die Knieprothetik?<br />\r\n<br />\r\n<a href=\"http://www.santemedia.ch/de/medizinische-sendungen.1193/praxis-gsundheit-telebarn.1668/computernavigation-in-der-knieprothetik.2132.html\" target=\"_blank\">Video anschauen</a>&nbsp;&nbsp;<br />\r\n<a href=\"{NODE_23}\">Erg&auml;nzende Themen</a></p>\r\n\r\n<h2>XXX Risiko ungeeignete Implantate XXX</h2>\r\n\r\n<p>TV-Sendung: Teleb&auml;rn / medizin-tv, Ausstrahlung: 01.10.2012</p>\r\n\r\n<p><a href=\"http://www.santemedia.ch/de/gesundheitspolitische-sendungen.1194/2011-12.1273/risiko-ungeeignete-implantate.1618.html\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Teaser_TV/Ungeeignete_Implantate.jpg\" /></a>Spit&auml;ler dr&auml;ngen ihre &Auml;rzte aus Spardruck dazu, g&uuml;nstige und ungeeignete Implantate einzusetzen. Nun wehrt sich die Schweizerische Gesellschaft f&uuml;r Orthop&auml;die und Traumatologie SGOT-SSOT. Die &Auml;rzte warnen vor Qualit&auml;tsverlust und dem erh&ouml;hten Risiko vor Komplikationen.<br />\r\n<br />\r\n<a href=\"http://www.santemedia.ch/de/gesundheitspolitische-sendungen.1194/2011-12.1273/risiko-ungeeignete-implantate.1618.html\" target=\"_blank\">Video anschauen</a>&nbsp;(Video nicht mehr abrufbar)<br />\r\n&nbsp;</p>\r\n\r\n<h2>F&uuml;r ganze Knieprothesen m&ouml;glichst lange warten</h2>\r\n\r\n<p>TV-Sendung: SRF1 / Puls, Ausstrahlung: 10.09.2012</p>\r\n\r\n<p><a href=\"http://www.srf.ch/sendungen/puls/kniegelenkersatz-schnarchen-babyschwimmen-versuchskaninchen\" target=\"_blank\"><img alt=\"\" src=\"/media/archive1/Teaser_TV/Ganze_Knieprothesen.jpg\" style=\"float: left; margin-right: 24px;\" /></a>&Uuml;ber 15&#39;000 Kniegelenksprothesen werden in der Schweiz pro Jahr eingesetzt. Meist verringern sich dadurch die akuten Gelenkschmerzen. Wer sollte sich behandeln lassen? Welche Erwartungen sind realistisch?<br />\r\n<br />\r\n<a href=\"http://www.srf.ch/sendungen/puls/kniegelenkersatz-schnarchen-babyschwimmen-versuchskaninchen\" target=\"_blank\">Video anschauen</a><br />\r\n<a href=\"{NODE_23}\">Erg&auml;nzende Themen</a><br />\r\n&nbsp;</p>\r\n\r\n<h2>Die Knie-Totalprothese, ein Fernsehbeitrag</h2>\r\n\r\n<p>TV-Sendung: Teleb&auml;rn / Medizin Aktuell,&nbsp;Ausstrahlung: 09.01.2008</p>\r\n\r\n<p><a href=\"http://www.srf.ch/sendungen/puls/kniegelenkersatz-schnarchen-babyschwimmen-versuchskaninchen\" target=\"_blank\"><img alt=\"\" src=\"/media/archive1/Teaser_TV/Ganze_Knieprothesen.jpg\" style=\"float: left; margin-right: 24px;\" /></a><a href=\"http://www.srf.ch/sendungen/puls/kniegelenkersatz-schnarchen-babyschwimmen-versuchskaninchen\" target=\"_blank\">Video anschauen</a><br />\r\n<a href=\"{NODE_23}\">Erg&auml;nzende Themen</a><br />\r\n&nbsp;</p>\r\n\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(444,'update','2015-04-13 06:37:11',39,'52','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 06:37:11.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:7:\"content\";s:3982:\"<p>Hier finden Sie eine Zusammenstellung von diversen Fernsehauftritten, welche ich in den letzten Jahren &ndash; meistens zum Thema Kniegelenk / Knieprothese &ndash; hatte. Die Beitr&auml;ge sind auch direkt im Kapital Kniegelenk abrufbar. Die Informationen sind bruchst&uuml;ckhaft und plakativ und sind deshalb als Erg&auml;nzung zu den schriftlichen Angaben zu den einzelnen Themen dieser Webseite gedacht. Zusammen mit Ausk&uuml;nften von Patienten geben sie aber eine wertvolle pers&ouml;nliche Einsch&auml;tzung ab. Ich w&uuml;nsche gute Unterhaltung und vor allem eine wertvolle erg&auml;nzende Information.</p>\r\n\r\n<h2>Computernavigation in der Knieprothetik</h2>\r\n\r\n<p>TV-Sendung: TeleB&auml;rn / praxis gsundheit,&nbsp;Ausstrahlung: 01.09.2014</p>\r\n\r\n<p><a href=\"http://www.santemedia.ch/de/medizinische-sendungen.1193/praxis-gsundheit-telebarn.1668/computernavigation-in-der-knieprothetik.2132.html\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Teaser_TV/Computernavigation_Knieprothetik.jpg\" /></a>Die Computernavigation in der Orthop&auml;die bedeutet das Einbringen eines k&uuml;nstlichen Gelenkes unter Zuhilfenahme eines Computersystems. Dieses System hilft dem Operateur, die einzelnen Komponenten der Knieprothese sehr genau zu platzieren. Ein neues Computernavigationsystem bezieht nun die B&auml;nder und Weichteile mit ein. Wie ist die Anwendung? Was sind die Vorteile? Und was ist die Knieprothetik?<br />\r\n<br />\r\n<a href=\"http://www.santemedia.ch/de/medizinische-sendungen.1193/praxis-gsundheit-telebarn.1668/computernavigation-in-der-knieprothetik.2132.html\" target=\"_blank\">Video anschauen</a>&nbsp;&nbsp;<br />\r\n<a href=\"{NODE_23}\">Erg&auml;nzende Themen</a></p>\r\n\r\n<h2>XXX Risiko ungeeignete Implantate XXX</h2>\r\n\r\n<p>TV-Sendung: Teleb&auml;rn / medizin-tv, Ausstrahlung: 01.10.2012</p>\r\n\r\n<p><a href=\"http://www.santemedia.ch/de/gesundheitspolitische-sendungen.1194/2011-12.1273/risiko-ungeeignete-implantate.1618.html\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Teaser_TV/Ungeeignete_Implantate.jpg\" /></a>Spit&auml;ler dr&auml;ngen ihre &Auml;rzte aus Spardruck dazu, g&uuml;nstige und ungeeignete Implantate einzusetzen. Nun wehrt sich die Schweizerische Gesellschaft f&uuml;r Orthop&auml;die und Traumatologie SGOT-SSOT. Die &Auml;rzte warnen vor Qualit&auml;tsverlust und dem erh&ouml;hten Risiko vor Komplikationen.<br />\r\n<br />\r\n<a href=\"http://www.santemedia.ch/de/gesundheitspolitische-sendungen.1194/2011-12.1273/risiko-ungeeignete-implantate.1618.html\" target=\"_blank\">Video anschauen</a>&nbsp;(Video nicht mehr abrufbar)<br />\r\n&nbsp;</p>\r\n\r\n<h2>F&uuml;r ganze Knieprothesen m&ouml;glichst lange warten</h2>\r\n\r\n<p>TV-Sendung: SRF1 / Puls, Ausstrahlung: 10.09.2012</p>\r\n\r\n<p><a href=\"http://www.srf.ch/sendungen/puls/kniegelenkersatz-schnarchen-babyschwimmen-versuchskaninchen\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Teaser_TV/Ganze_Knieprothesen.jpg\" /></a>&Uuml;ber 15&#39;000 Kniegelenksprothesen werden in der Schweiz pro Jahr eingesetzt. Meist verringern sich dadurch die akuten Gelenkschmerzen. Wer sollte sich behandeln lassen? Welche Erwartungen sind realistisch?<br />\r\n<br />\r\n<a href=\"http://www.srf.ch/sendungen/puls/kniegelenkersatz-schnarchen-babyschwimmen-versuchskaninchen\" target=\"_blank\">Video anschauen</a><br />\r\n<a href=\"{NODE_23}\">Erg&auml;nzende Themen</a><br />\r\n&nbsp;</p>\r\n\r\n<h2>Die Knie-Totalprothese, ein Fernsehbeitrag</h2>\r\n\r\n<p>TV-Sendung: Teleb&auml;rn / Medizin Aktuell,&nbsp;Ausstrahlung: 09.01.2008</p>\r\n\r\n<p><a href=\"http://www.srf.ch/sendungen/puls/kniegelenkersatz-schnarchen-babyschwimmen-versuchskaninchen\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Teaser_TV/Ganze_Knieprothesen.jpg\" /></a><a href=\"http://www.srf.ch/sendungen/puls/kniegelenkersatz-schnarchen-babyschwimmen-versuchskaninchen\" target=\"_blank\">Video anschauen</a><br />\r\n<a href=\"{NODE_23}\">Erg&auml;nzende Themen</a><br />\r\n&nbsp;</p>\r\n\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(445,'update','2015-04-13 06:40:14',40,'52','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 06:40:14.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:7:\"content\";s:4625:\"<p>Hier finden Sie eine Zusammenstellung von diversen Fernsehauftritten, welche ich in den letzten Jahren &ndash; meistens zum Thema Kniegelenk / Knieprothese &ndash; hatte. Die Beitr&auml;ge sind auch direkt im Kapital Kniegelenk abrufbar. Die Informationen sind bruchst&uuml;ckhaft und plakativ und sind deshalb als Erg&auml;nzung zu den schriftlichen Angaben zu den einzelnen Themen dieser Webseite gedacht. Zusammen mit Ausk&uuml;nften von Patienten geben sie aber eine wertvolle pers&ouml;nliche Einsch&auml;tzung ab. Ich w&uuml;nsche gute Unterhaltung und vor allem eine wertvolle erg&auml;nzende Information.</p>\r\n\r\n<section class=\"content-section\">\r\n<h2 class=\"content-section-title\">Computernavigation in der Knieprothetik</h2>\r\n\r\n<p class=\"content-section-meta\">TV-Sendung: TeleB&auml;rn / praxis gsundheit,&nbsp;Ausstrahlung: 01.09.2014</p>\r\n\r\n<p><a href=\"http://www.santemedia.ch/de/medizinische-sendungen.1193/praxis-gsundheit-telebarn.1668/computernavigation-in-der-knieprothetik.2132.html\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Teaser_TV/Computernavigation_Knieprothetik.jpg\" /></a>Die Computernavigation in der Orthop&auml;die bedeutet das Einbringen eines k&uuml;nstlichen Gelenkes unter Zuhilfenahme eines Computersystems. Dieses System hilft dem Operateur, die einzelnen Komponenten der Knieprothese sehr genau zu platzieren. Ein neues Computernavigationsystem bezieht nun die B&auml;nder und Weichteile mit ein. Wie ist die Anwendung? Was sind die Vorteile? Und was ist die Knieprothetik?</p>\r\n\r\n<ul>\r\n	<li><a class=\"icon-movie link-icon\" href=\"http://www.santemedia.ch/de/medizinische-sendungen.1193/praxis-gsundheit-telebarn.1668/computernavigation-in-der-knieprothetik.2132.html\" target=\"_blank\">Video anschauen</a>&nbsp;&nbsp;</li>\r\n	<li><a class=\"icon-link link-icon\" href=\"{NODE_23}\">Erg&auml;nzende Themen</a></li>\r\n</ul>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2 class=\"content-section-title\">XXX Risiko ungeeignete Implantate XXX</h2>\r\n\r\n<p class=\"content-section-meta\">TV-Sendung: Teleb&auml;rn / medizin-tv, Ausstrahlung: 01.10.2012</p>\r\n\r\n<p><a href=\"http://www.santemedia.ch/de/gesundheitspolitische-sendungen.1194/2011-12.1273/risiko-ungeeignete-implantate.1618.html\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Teaser_TV/Ungeeignete_Implantate.jpg\" /></a>Spit&auml;ler dr&auml;ngen ihre &Auml;rzte aus Spardruck dazu, g&uuml;nstige und ungeeignete Implantate einzusetzen. Nun wehrt sich die Schweizerische Gesellschaft f&uuml;r Orthop&auml;die und Traumatologie SGOT-SSOT. Die &Auml;rzte warnen vor Qualit&auml;tsverlust und dem erh&ouml;hten Risiko vor Komplikationen.</p>\r\n\r\n<ul>\r\n	<li><a class=\"icon-movie link-icon\" href=\"http://www.santemedia.ch/de/gesundheitspolitische-sendungen.1194/2011-12.1273/risiko-ungeeignete-implantate.1618.html\" target=\"_blank\">Video anschauen</a>&nbsp;(Video nicht mehr abrufbar)</li>\r\n</ul>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2 class=\"content-section-title\">F&uuml;r ganze Knieprothesen m&ouml;glichst lange warten</h2>\r\n\r\n<p class=\"content-section-meta\">TV-Sendung: SRF1 / Puls, Ausstrahlung: 10.09.2012</p>\r\n\r\n<p><a href=\"http://www.srf.ch/sendungen/puls/kniegelenkersatz-schnarchen-babyschwimmen-versuchskaninchen\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Teaser_TV/Ganze_Knieprothesen.jpg\" /></a>&Uuml;ber 15&#39;000 Kniegelenksprothesen werden in der Schweiz pro Jahr eingesetzt. Meist verringern sich dadurch die akuten Gelenkschmerzen. Wer sollte sich behandeln lassen? Welche Erwartungen sind realistisch?</p>\r\n\r\n<ul>\r\n	<li><a class=\"icon-movie link-icon\" href=\"http://www.srf.ch/sendungen/puls/kniegelenkersatz-schnarchen-babyschwimmen-versuchskaninchen\" target=\"_blank\">Video anschauen</a></li>\r\n	<li><a class=\"icon-link link-icon\" href=\"{NODE_23}\">Erg&auml;nzende Themen</a></li>\r\n</ul>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2 class=\"content-section-title\">Die Knie-Totalprothese, ein Fernsehbeitrag</h2>\r\n\r\n<p class=\"content-section-meta\">TV-Sendung: Teleb&auml;rn / Medizin Aktuell,&nbsp;Ausstrahlung: 09.01.2008</p>\r\n\r\n<ul>\r\n	<li><a href=\"http://www.srf.ch/sendungen/puls/kniegelenkersatz-schnarchen-babyschwimmen-versuchskaninchen\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Teaser_TV/Ganze_Knieprothesen.jpg\" /></a><a class=\"icon-movie link-icon\" href=\"http://www.srf.ch/sendungen/puls/kniegelenkersatz-schnarchen-babyschwimmen-versuchskaninchen\" target=\"_blank\">Video anschauen</a></li>\r\n	<li><a class=\"icon-link link-icon\" href=\"{NODE_23}\">Erg&auml;nzende Themen</a></li>\r\n</ul>\r\n</section>\r\n\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(446,'update','2015-04-13 07:04:02',43,'36','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 07:04:02.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:7:\"content\";s:3930:\"<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td style=\"width: 50%; vertical-align: top;\">\r\n			<h2 id=\"kontakt\">Adresse</h2>\r\n			</td>\r\n			<td style=\"vertical-align: top;\">&nbsp;</td>\r\n			<td style=\"width: 50%; vertical-align: top;\">\r\n			<h2>&Ouml;ffnungszeiten</h2>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"vertical-align: top;\">\r\n			<p><strong>CHRISTENORTHO AG</strong><br />\r\n			Dr. med., M.H.A. Bernhard Christen<br />\r\n			Orthop&auml;dische Klinik Bern<br />\r\n			Sch&auml;nzlistrasse 39<br />\r\n			CH-3000 Bern 25<br />\r\n			<br />\r\n			Telefon +41 31 337 89 24<br />\r\n			Telefax +41 31 337 89 54<br />\r\n			<a href=\"mailto:info@christenortho.ch\">info@christenortho.ch</a><br />\r\n			&nbsp;</p>\r\n			</td>\r\n			<td style=\"vertical-align: top;\">&nbsp;</td>\r\n			<td style=\"vertical-align: top;\">\r\n			<p><strong>Montag, Dienstag, Donnerstag und Freitag</strong><br />\r\n			09:00 &ndash; 12:00 und 14:00 &ndash; 16:00 Uhr&nbsp;<br />\r\n			<strong>Mittwoch</strong><br />\r\n			09:00 &ndash; 12:00 Uhr</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td style=\"width:50%\">\r\n			<h2 id=\"sos\">SOS-Notfall</h2>\r\n			</td>\r\n			<td>&nbsp;</td>\r\n			<td style=\"width:50%\">\r\n			<h2>&nbsp;</h2>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Apotheken Notfalldienst</strong><br />\r\n			Telefon 0900 98 99 00<br />\r\n			&nbsp;</p>\r\n			</td>\r\n			<td>\r\n			<p>&nbsp;</p>\r\n			</td>\r\n			<td>\r\n			<p><strong>Notfalldienst Salemspital</strong><br />\r\n			Telefon 031 335 35 35</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<h2 id=\"anfahrt\">Anfahrt</h2>\r\n\r\n<p><img alt=\"\" src=\"http://fakeimg.pl/767x250/?text=Google Maps\" /></p>\r\n\r\n<p>Bus Nummer 10 Richtung Ostermundigen/R&uuml;ti, Haltestelle Salem oder Tram Nummer 9 Richtung Guisanplatz, Haltestelle Viktoriaplatz.</p>\r\n\r\n<p>Unsere Praxis befindet sich im Haus Elim im Salemspital, erreichbar &uuml;ber den Haupteingang, in Verl&auml;ngerung des Geschosses A1.</p>\r\n\r\n<h2 id=\"salem\">Salemspital</h2>\r\n\r\n<p><a href=\"http://www.bernerzeitung.ch/schweiz/standard/Schweizer-Aerzte-greifen-im-Zweifel-zum-Skalpell/story/12275394\" target=\"_blank\"><img alt=\"\" src=\"/media/archive1/Praxis/Salem.jpg\" style=\"margin-right: 24px; float: left;\" /></a>Das 1888 erbaute Salemspital hat eine lange Tradition. Das heute zur Privatklinikgruppe Hirslanden geh&ouml;rende Spital bietet ein breites Spektrum von medizinischen Dienstleistungen an.</p>\r\n\r\n<p>Die moderne Infrastruktur und die hohe medizinische Fachkompetenz bestimmen seit Jahren das Handeln und die Philosophie des Salemspitals.</p>\r\n\r\n<p>Steter Wandel und innovatives Schaffen stehen f&uuml;r das Spitalleitbild: &bdquo;Sich mit K&ouml;nnen, Wissen und Gewissen f&uuml;r die Patienten zu engagieren und f&uuml;r Menschen da zu sein&ldquo;!</p>\r\n\r\n<p>​Eine Aussage, die sich mit der Er&ouml;ffnung der Orthop&auml;dischen Klinik Bern im November 2002 einmal mehr untermauern liess und ein Credo, welches in der Orthop&auml;dischen Klinik und speziell auch bei christenortho Tag f&uuml;r Tag neu gelebt und praktiziert wird.</p>\r\n\r\n<ul>\r\n	<li>Website besuchen (MIT LINK ICON)</li>\r\n</ul>\r\n\r\n<h2 id=\"siloah\">Klinik Siloah</h2>\r\n\r\n<p><a href=\"http://www.bernerzeitung.ch/schweiz/standard/Schweizer-Aerzte-greifen-im-Zweifel-zum-Skalpell/story/12275394\" target=\"_blank\"><img alt=\"\" src=\"/media/archive1/Praxis/Salem.jpg\" style=\"margin-right: 24px; float: left;\" /></a>Dies ist ein Typoblindtext. An ihm kann man sehen, ob alle Buchstaben da sind und wie sie aussehen. Manchmal benutzt man Worte wie Hamburgefonts, Rafgenduks oder Handgloves, um Schriften zu testen. Manchmal S&auml;tze, die alle Buchstaben des Alphabets enthalten - man nennt diese S&auml;tze &raquo;Pangrams&laquo;. Sehr bekannt ist dieser: The quick brown fox jumps over the lazy old dog.</p>\r\n\r\n<ul>\r\n	<li>Website besuchen (MIT LINK ICON)</li>\r\n</ul>\r\n\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(447,'update','2015-04-13 07:08:24',44,'36','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 07:08:24.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:7:\"content\";s:3884:\"<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td style=\"width: 50%; vertical-align: top;\">\r\n			<h2 id=\"kontakt\">Adresse</h2>\r\n			</td>\r\n			<td style=\"vertical-align: top;\">&nbsp;</td>\r\n			<td style=\"width: 50%; vertical-align: top;\">\r\n			<h2>&Ouml;ffnungszeiten</h2>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"vertical-align: top;\">\r\n			<p><strong>CHRISTENORTHO AG</strong><br />\r\n			Dr. med., M.H.A. Bernhard Christen<br />\r\n			Orthop&auml;dische Klinik Bern<br />\r\n			Sch&auml;nzlistrasse 39<br />\r\n			CH-3000 Bern 25<br />\r\n			<br />\r\n			Telefon +41 31 337 89 24<br />\r\n			Telefax +41 31 337 89 54<br />\r\n			<a href=\"mailto:info@christenortho.ch\">info@christenortho.ch</a><br />\r\n			&nbsp;</p>\r\n			</td>\r\n			<td style=\"vertical-align: top;\">&nbsp;</td>\r\n			<td style=\"vertical-align: top;\">\r\n			<p><strong>Montag, Dienstag, Donnerstag und Freitag</strong><br />\r\n			09:00 &ndash; 12:00 und 14:00 &ndash; 16:00 Uhr&nbsp;<br />\r\n			<strong>Mittwoch</strong><br />\r\n			09:00 &ndash; 12:00 Uhr</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td style=\"width:50%\">\r\n			<h2 id=\"sos\">SOS-Notfall</h2>\r\n			</td>\r\n			<td>&nbsp;</td>\r\n			<td style=\"width:50%\">\r\n			<h2>&nbsp;</h2>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Apotheken Notfalldienst</strong><br />\r\n			Telefon 0900 98 99 00<br />\r\n			&nbsp;</p>\r\n			</td>\r\n			<td>\r\n			<p>&nbsp;</p>\r\n			</td>\r\n			<td>\r\n			<p><strong>Notfalldienst Salemspital</strong><br />\r\n			Telefon 031 335 35 35</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<h2 id=\"anfahrt\">Anfahrt</h2>\r\n\r\n<p><img alt=\"\" src=\"http://fakeimg.pl/767x250/?text=Google Maps\" /></p>\r\n\r\n<p>Bus Nummer 10 Richtung Ostermundigen/R&uuml;ti, Haltestelle Salem oder Tram Nummer 9 Richtung Guisanplatz, Haltestelle Viktoriaplatz.</p>\r\n\r\n<p>Unsere Praxis befindet sich im Haus Elim im Salemspital, erreichbar &uuml;ber den Haupteingang, in Verl&auml;ngerung des Geschosses A1.</p>\r\n\r\n<h2 id=\"salem\">Salemspital</h2>\r\n\r\n<p><a href=\"http://www.bernerzeitung.ch/schweiz/standard/Schweizer-Aerzte-greifen-im-Zweifel-zum-Skalpell/story/12275394\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Praxis/Salem.jpg\" /></a>Das 1888 erbaute Salemspital hat eine lange Tradition. Das heute zur Privatklinikgruppe Hirslanden geh&ouml;rende Spital bietet ein breites Spektrum von medizinischen Dienstleistungen an.</p>\r\n\r\n<p>Die moderne Infrastruktur und die hohe medizinische Fachkompetenz bestimmen seit Jahren das Handeln und die Philosophie des Salemspitals.</p>\r\n\r\n<p>Steter Wandel und innovatives Schaffen stehen f&uuml;r das Spitalleitbild: &bdquo;Sich mit K&ouml;nnen, Wissen und Gewissen f&uuml;r die Patienten zu engagieren und f&uuml;r Menschen da zu sein&ldquo;!</p>\r\n\r\n<p>​Eine Aussage, die sich mit der Er&ouml;ffnung der Orthop&auml;dischen Klinik Bern im November 2002 einmal mehr untermauern liess und ein Credo, welches in der Orthop&auml;dischen Klinik und speziell auch bei christenortho Tag f&uuml;r Tag neu gelebt und praktiziert wird.</p>\r\n\r\n<ul>\r\n	<li>Website besuchen (MIT LINK ICON)</li>\r\n</ul>\r\n\r\n<h2 id=\"siloah\">Klinik Siloah</h2>\r\n\r\n<p><a href=\"http://www.bernerzeitung.ch/schweiz/standard/Schweizer-Aerzte-greifen-im-Zweifel-zum-Skalpell/story/12275394\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Praxis/Salem.jpg\" /></a>Dies ist ein Typoblindtext. An ihm kann man sehen, ob alle Buchstaben da sind und wie sie aussehen. Manchmal benutzt man Worte wie Hamburgefonts, Rafgenduks oder Handgloves, um Schriften zu testen. Manchmal S&auml;tze, die alle Buchstaben des Alphabets enthalten - man nennt diese S&auml;tze &raquo;Pangrams&laquo;. Sehr bekannt ist dieser: The quick brown fox jumps over the lazy old dog.</p>\r\n\r\n<ul>\r\n	<li>Website besuchen (MIT LINK ICON)</li>\r\n</ul>\r\n\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(448,'update','2015-04-13 07:27:50',45,'36','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 07:27:50.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:7:\"content\";s:3389:\"<section class=\"content-section-two\">\r\n<h2 id=\"kontakt\">Adresse</h2>\r\n\r\n<p><strong>CHRISTENORTHO AG</strong><br />\r\nDr. med., M.H.A. Bernhard Christen<br />\r\nOrthop&auml;dische Klinik Bern<br />\r\nSch&auml;nzlistrasse 39<br />\r\nCH-3000 Bern 25<br />\r\n<br />\r\nTelefon +41 31 337 89 24<br />\r\nTelefax +41 31 337 89 54<br />\r\n<a href=\"mailto:info@christenortho.ch\">info@christenortho.ch</a></p>\r\n</section>\r\n\r\n<section class=\"content-section-two\">\r\n<h2>&Ouml;ffnungszeiten</h2>\r\n\r\n<p><strong>Montag, Dienstag, Donnerstag und Freitag</strong><br />\r\n09:00 &ndash; 12:00 und 14:00 &ndash; 16:00 Uhr&nbsp;<br />\r\n<strong>Mittwoch</strong><br />\r\n09:00 &ndash; 12:00 Uhr</p>\r\n</section>\r\n\r\n<section class=\"content-section-two\">\r\n<h2 id=\"sos\">SOS-Notfall</h2>\r\n\r\n<p><strong>Apotheken Notfalldienst</strong><br />\r\nTelefon 0900 98 99 00</p>\r\n</section>\r\n\r\n<section class=\"content-section-two\">\r\n  <h2>&nbsp;</h2>\r\n<p><strong>Notfalldienst Salemspital</strong><br />\r\nTelefon 031 335 35 35</p>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2 id=\"anfahrt\">Anfahrt</h2>\r\n\r\n<p><img alt=\"\" src=\"http://fakeimg.pl/767x250/?text=Google Maps\" /></p>\r\n\r\n<p>Bus Nummer 10 Richtung Ostermundigen/R&uuml;ti, Haltestelle Salem oder Tram Nummer 9 Richtung Guisanplatz, Haltestelle Viktoriaplatz.</p>\r\n\r\n<p>Unsere Praxis befindet sich im Haus Elim im Salemspital, erreichbar &uuml;ber den Haupteingang, in Verl&auml;ngerung des Geschosses A1.</p>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2 id=\"salem\">Salemspital</h2>\r\n\r\n<p><a href=\"http://www.bernerzeitung.ch/schweiz/standard/Schweizer-Aerzte-greifen-im-Zweifel-zum-Skalpell/story/12275394\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Praxis/Salem.jpg\" /></a>Das 1888 erbaute Salemspital hat eine lange Tradition. Das heute zur Privatklinikgruppe Hirslanden geh&ouml;rende Spital bietet ein breites Spektrum von medizinischen Dienstleistungen an.</p>\r\n\r\n<p>Die moderne Infrastruktur und die hohe medizinische Fachkompetenz bestimmen seit Jahren das Handeln und die Philosophie des Salemspitals.</p>\r\n\r\n<p>Steter Wandel und innovatives Schaffen stehen f&uuml;r das Spitalleitbild: &bdquo;Sich mit K&ouml;nnen, Wissen und Gewissen f&uuml;r die Patienten zu engagieren und f&uuml;r Menschen da zu sein&ldquo;!</p>\r\n\r\n<p>​Eine Aussage, die sich mit der Er&ouml;ffnung der Orthop&auml;dischen Klinik Bern im November 2002 einmal mehr untermauern liess und ein Credo, welches in der Orthop&auml;dischen Klinik und speziell auch bei christenortho Tag f&uuml;r Tag neu gelebt und praktiziert wird.</p>\r\n\r\n<ul>\r\n	<li>Website besuchen (MIT LINK ICON)</li>\r\n</ul>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2 id=\"siloah\">Klinik Siloah</h2>\r\n\r\n<p><a href=\"http://www.bernerzeitung.ch/schweiz/standard/Schweizer-Aerzte-greifen-im-Zweifel-zum-Skalpell/story/12275394\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Praxis/Salem.jpg\" /></a>Dies ist ein Typoblindtext. An ihm kann man sehen, ob alle Buchstaben da sind und wie sie aussehen. Manchmal benutzt man Worte wie Hamburgefonts, Rafgenduks oder Handgloves, um Schriften zu testen. Manchmal S&auml;tze, die alle Buchstaben des Alphabets enthalten - man nennt diese S&auml;tze &raquo;Pangrams&laquo;. Sehr bekannt ist dieser: The quick brown fox jumps over the lazy old dog.</p>\r\n\r\n<ul>\r\n	<li>Website besuchen (MIT LINK ICON)</li>\r\n</ul>\r\n</section>\r\n\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(449,'update','2015-04-13 07:28:22',46,'36','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:3:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 07:28:22.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:13:\"customContent\";s:19:\"content_nested.html\";s:30:\"useCustomContentForAllChannels\";i:1;}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(450,'update','2015-04-13 07:36:18',47,'36','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 07:36:18.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:7:\"content\";s:3603:\"<section class=\"content-section-two\">\r\n<h2 id=\"kontakt\">Adresse</h2>\r\n\r\n<p><strong>CHRISTENORTHO AG</strong><br />\r\nDr. med., M.H.A. Bernhard Christen<br />\r\nOrthop&auml;dische Klinik Bern<br />\r\nSch&auml;nzlistrasse 39<br />\r\nCH-3000 Bern 25<br />\r\n<br />\r\nTelefon +41 31 337 89 24<br />\r\nTelefax +41 31 337 89 54<br />\r\n<a class=\"icon-mail link-icon\" href=\"mailto:info@christenortho.ch\">info@christenortho.ch</a></p>\r\n</section>\r\n\r\n<section class=\"content-section-two\">\r\n<h2>&Ouml;ffnungszeiten</h2>\r\n\r\n<p><strong>Montag, Dienstag, Donnerstag und Freitag</strong><br />\r\n09:00 &ndash; 12:00 und 14:00 &ndash; 16:00 Uhr&nbsp;<br />\r\n<strong>Mittwoch</strong><br />\r\n09:00 &ndash; 12:00 Uhr</p>\r\n</section>\r\n\r\n<section class=\"content-section-two\">\r\n<h2 id=\"sos\">SOS-Notfall</h2>\r\n\r\n<p><strong>Apotheken Notfalldienst</strong><br />\r\nTelefon 0900 98 99 00</p>\r\n</section>\r\n\r\n<section class=\"content-section-two\">\r\n<h2>&nbsp;</h2>\r\n\r\n<p><strong>Notfalldienst Salemspital</strong><br />\r\nTelefon 031 335 35 35</p>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2 id=\"anfahrt\">Anfahrt</h2>\r\n\r\n<p><img alt=\"\" src=\"http://fakeimg.pl/767x250/?text=Google Maps\" /></p>\r\n\r\n<p>Bus Nummer 10 Richtung Ostermundigen/R&uuml;ti, Haltestelle Salem oder Tram Nummer 9 Richtung Guisanplatz, Haltestelle Viktoriaplatz.</p>\r\n\r\n<p>Unsere Praxis befindet sich im Haus Elim im Salemspital, erreichbar &uuml;ber den Haupteingang, in Verl&auml;ngerung des Geschosses A1.</p>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2 id=\"salem\">Salemspital</h2>\r\n\r\n<p><a href=\"http://www.bernerzeitung.ch/schweiz/standard/Schweizer-Aerzte-greifen-im-Zweifel-zum-Skalpell/story/12275394\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Praxis/Salem.jpg\" /></a>Das 1888 erbaute Salemspital hat eine lange Tradition. Das heute zur Privatklinikgruppe Hirslanden geh&ouml;rende Spital bietet ein breites Spektrum von medizinischen Dienstleistungen an.</p>\r\n\r\n<p>Die moderne Infrastruktur und die hohe medizinische Fachkompetenz bestimmen seit Jahren das Handeln und die Philosophie des Salemspitals.</p>\r\n\r\n<p>Steter Wandel und innovatives Schaffen stehen f&uuml;r das Spitalleitbild: &bdquo;Sich mit K&ouml;nnen, Wissen und Gewissen f&uuml;r die Patienten zu engagieren und f&uuml;r Menschen da zu sein&ldquo;!</p>\r\n\r\n<p>​Eine Aussage, die sich mit der Er&ouml;ffnung der Orthop&auml;dischen Klinik Bern im November 2002 einmal mehr untermauern liess und ein Credo, welches in der Orthop&auml;dischen Klinik und speziell auch bei christenortho Tag f&uuml;r Tag neu gelebt und praktiziert wird.</p>\r\n\r\n<ul>\r\n	<li><a class=\"icon-link link-icon\" href=\"http://www.hirslanden.ch/global/de/startseite/kliniken_zentren/salem-spital.html\" target=\"_blank\">Website besuchen</a></li>\r\n</ul>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2 id=\"siloah\">Klinik Siloah</h2>\r\n\r\n<p><a href=\"http://www.bernerzeitung.ch/schweiz/standard/Schweizer-Aerzte-greifen-im-Zweifel-zum-Skalpell/story/12275394\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Praxis/Salem.jpg\" /></a>Dies ist ein Typoblindtext. An ihm kann man sehen, ob alle Buchstaben da sind und wie sie aussehen. Manchmal benutzt man Worte wie Hamburgefonts, Rafgenduks oder Handgloves, um Schriften zu testen. Manchmal S&auml;tze, die alle Buchstaben des Alphabets enthalten - man nennt diese S&auml;tze &raquo;Pangrams&laquo;. Sehr bekannt ist dieser: The quick brown fox jumps over the lazy old dog.</p>\r\n\r\n<ul>\r\n	<li><a class=\"icon-link link-icon\" href=\"http://www.siloah.ch\" target=\"_blank\">Website besuchen</a></li>\r\n</ul>\r\n</section>\r\n\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(451,'update','2015-04-13 08:23:01',48,'36','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 08:23:01.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:7:\"content\";s:3622:\"<section class=\"content-section-two\">\r\n<h2 id=\"kontakt\">Adresse</h2>\r\n\r\n<p><strong>CHRISTENORTHO AG</strong><br />\r\nDr. med., M.H.A. Bernhard Christen<br />\r\nOrthop&auml;dische Klinik Bern<br />\r\nSch&auml;nzlistrasse 39<br />\r\nCH-3000 Bern 25<br />\r\n<br />\r\nTelefon +41 31 337 89 24<br />\r\nTelefax +41 31 337 89 54<br />\r\n<a class=\"icon-mail link-icon\" href=\"mailto:info@christenortho.ch\">info@christenortho.ch</a></p>\r\n</section>\r\n\r\n<section class=\"content-section-two\">\r\n<h2>&Ouml;ffnungszeiten</h2>\r\n\r\n<p><strong>Montag, Dienstag, Donnerstag und Freitag</strong><br />\r\n09:00 &ndash; 12:00 und 14:00 &ndash; 16:00 Uhr&nbsp;<br />\r\n<strong>Mittwoch</strong><br />\r\n09:00 &ndash; 12:00 Uhr</p>\r\n</section>\r\n\r\n<section class=\"content-section-two\">\r\n<h2 id=\"sos\">SOS-Notfall</h2>\r\n\r\n<p><strong>Apotheken Notfalldienst</strong><br />\r\nTelefon 0900 98 99 00</p>\r\n</section>\r\n\r\n<section class=\"content-section-two\">\r\n<div class=\"heading-spacer\"></div>\r\n\r\n<p><strong>Notfalldienst Salemspital</strong><br />\r\nTelefon 031 335 35 35</p>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2 id=\"anfahrt\">Anfahrt</h2>\r\n\r\n<p><img alt=\"\" src=\"http://fakeimg.pl/767x250/?text=Google Maps\" /></p>\r\n\r\n<p>Bus Nummer 10 Richtung Ostermundigen/R&uuml;ti, Haltestelle Salem oder Tram Nummer 9 Richtung Guisanplatz, Haltestelle Viktoriaplatz.</p>\r\n\r\n<p>Unsere Praxis befindet sich im Haus Elim im Salemspital, erreichbar &uuml;ber den Haupteingang, in Verl&auml;ngerung des Geschosses A1.</p>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2 id=\"salem\">Salemspital</h2>\r\n\r\n<p><a href=\"http://www.bernerzeitung.ch/schweiz/standard/Schweizer-Aerzte-greifen-im-Zweifel-zum-Skalpell/story/12275394\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Praxis/Salem.jpg\" /></a>Das 1888 erbaute Salemspital hat eine lange Tradition. Das heute zur Privatklinikgruppe Hirslanden geh&ouml;rende Spital bietet ein breites Spektrum von medizinischen Dienstleistungen an.</p>\r\n\r\n<p>Die moderne Infrastruktur und die hohe medizinische Fachkompetenz bestimmen seit Jahren das Handeln und die Philosophie des Salemspitals.</p>\r\n\r\n<p>Steter Wandel und innovatives Schaffen stehen f&uuml;r das Spitalleitbild: &bdquo;Sich mit K&ouml;nnen, Wissen und Gewissen f&uuml;r die Patienten zu engagieren und f&uuml;r Menschen da zu sein&ldquo;!</p>\r\n\r\n<p>​Eine Aussage, die sich mit der Er&ouml;ffnung der Orthop&auml;dischen Klinik Bern im November 2002 einmal mehr untermauern liess und ein Credo, welches in der Orthop&auml;dischen Klinik und speziell auch bei christenortho Tag f&uuml;r Tag neu gelebt und praktiziert wird.</p>\r\n\r\n<ul>\r\n	<li><a class=\"icon-link link-icon\" href=\"http://www.hirslanden.ch/global/de/startseite/kliniken_zentren/salem-spital.html\" target=\"_blank\">Website besuchen</a></li>\r\n</ul>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2 id=\"siloah\">Klinik Siloah</h2>\r\n\r\n<p><a href=\"http://www.bernerzeitung.ch/schweiz/standard/Schweizer-Aerzte-greifen-im-Zweifel-zum-Skalpell/story/12275394\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Praxis/Salem.jpg\" /></a>Dies ist ein Typoblindtext. An ihm kann man sehen, ob alle Buchstaben da sind und wie sie aussehen. Manchmal benutzt man Worte wie Hamburgefonts, Rafgenduks oder Handgloves, um Schriften zu testen. Manchmal S&auml;tze, die alle Buchstaben des Alphabets enthalten - man nennt diese S&auml;tze &raquo;Pangrams&laquo;. Sehr bekannt ist dieser: The quick brown fox jumps over the lazy old dog.</p>\r\n\r\n<ul>\r\n	<li><a class=\"icon-link link-icon\" href=\"http://www.siloah.ch\" target=\"_blank\">Website besuchen</a></li>\r\n</ul>\r\n</section>\r\n\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(452,'update','2015-04-13 09:15:52',49,'36','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 09:15:52.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:7:\"content\";s:3646:\"<section class=\"content-section-two\">\r\n<h2 id=\"kontakt\">Adresse</h2>\r\n\r\n<p><strong>CHRISTENORTHO AG</strong><br />\r\nDr. med., M.H.A. Bernhard Christen<br />\r\nOrthop&auml;dische Klinik Bern<br />\r\nSch&auml;nzlistrasse 39<br />\r\nCH-3000 Bern 25<br />\r\n<br />\r\nTelefon +41 31 337 89 24<br />\r\nTelefax +41 31 337 89 54<br />\r\n<a class=\"icon-mail link-icon\" href=\"mailto:info@christenortho.ch\">info@christenortho.ch</a></p>\r\n</section>\r\n\r\n<section class=\"content-section-two\">\r\n<h2>&Ouml;ffnungszeiten</h2>\r\n\r\n<p><strong>Montag, Dienstag, Donnerstag und Freitag</strong><br />\r\n09:00 &ndash; 12:00 und 14:00 &ndash; 16:00 Uhr&nbsp;<br />\r\n<strong>Mittwoch</strong><br />\r\n09:00 &ndash; 12:00 Uhr</p>\r\n</section>\r\n\r\n<section class=\"content-section-two\">\r\n<h2 id=\"sos\">SOS-Notfall</h2>\r\n\r\n<p><strong>Apotheken Notfalldienst</strong><br />\r\nTelefon 0900 98 99 00</p>\r\n</section>\r\n\r\n<section class=\"content-section-two\">\r\n<div class=\"heading-spacer\"></div>\r\n\r\n<p><strong>Notfalldienst Salemspital</strong><br />\r\nTelefon 031 335 35 35</p>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2 id=\"anfahrt\">Anfahrt</h2>\r\n\r\n<p><img alt=\"\" src=\"http://fakeimg.pl/767x250/?text=Google Maps\" /></p>\r\n\r\n<p>Bus Nummer 10 Richtung Ostermundigen/R&uuml;ti, Haltestelle Salem oder Tram Nummer 9 Richtung Guisanplatz, Haltestelle Viktoriaplatz.</p>\r\n\r\n<p>Unsere Praxis befindet sich im Haus Elim im Salemspital, erreichbar &uuml;ber den Haupteingang, in Verl&auml;ngerung des Geschosses A1.</p>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2 id=\"salem\">Salemspital</h2>\r\n\r\n<p><a href=\"http://www.bernerzeitung.ch/schweiz/standard/Schweizer-Aerzte-greifen-im-Zweifel-zum-Skalpell/story/12275394\" target=\"_blank\"><img width=\"300\" alt=\"\" class=\"alignleft\" src=\"/media/archive1/Praxis/Salem.jpg\" /></a>Das 1888 erbaute Salemspital hat eine lange Tradition. Das heute zur Privatklinikgruppe Hirslanden geh&ouml;rende Spital bietet ein breites Spektrum von medizinischen Dienstleistungen an.</p>\r\n\r\n<p>Die moderne Infrastruktur und die hohe medizinische Fachkompetenz bestimmen seit Jahren das Handeln und die Philosophie des Salemspitals.</p>\r\n\r\n<p>Steter Wandel und innovatives Schaffen stehen f&uuml;r das Spitalleitbild: &bdquo;Sich mit K&ouml;nnen, Wissen und Gewissen f&uuml;r die Patienten zu engagieren und f&uuml;r Menschen da zu sein&ldquo;!</p>\r\n\r\n<p>​Eine Aussage, die sich mit der Er&ouml;ffnung der Orthop&auml;dischen Klinik Bern im November 2002 einmal mehr untermauern liess und ein Credo, welches in der Orthop&auml;dischen Klinik und speziell auch bei christenortho Tag f&uuml;r Tag neu gelebt und praktiziert wird.</p>\r\n\r\n<ul>\r\n	<li><a class=\"icon-link link-icon\" href=\"http://www.hirslanden.ch/global/de/startseite/kliniken_zentren/salem-spital.html\" target=\"_blank\">Website besuchen</a></li>\r\n</ul>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2 id=\"siloah\">Klinik Siloah</h2>\r\n\r\n<p><a href=\"http://www.bernerzeitung.ch/schweiz/standard/Schweizer-Aerzte-greifen-im-Zweifel-zum-Skalpell/story/12275394\" target=\"_blank\"><img alt=\"\" width=\"300\" class=\"alignleft\" src=\"/media/archive1/Praxis/Salem.jpg\" /></a>Dies ist ein Typoblindtext. An ihm kann man sehen, ob alle Buchstaben da sind und wie sie aussehen. Manchmal benutzt man Worte wie Hamburgefonts, Rafgenduks oder Handgloves, um Schriften zu testen. Manchmal S&auml;tze, die alle Buchstaben des Alphabets enthalten - man nennt diese S&auml;tze &raquo;Pangrams&laquo;. Sehr bekannt ist dieser: The quick brown fox jumps over the lazy old dog.</p>\r\n\r\n<ul>\r\n	<li><a class=\"icon-link link-icon\" href=\"http://www.siloah.ch\" target=\"_blank\">Website besuchen</a></li>\r\n</ul>\r\n</section>\r\n\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(453,'update','2015-04-13 09:24:52',32,'45','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 09:24:52.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:7:\"content\";s:2177:\"<section class=\"content-section\">\r\n<p>Unsere Praxisr&auml;umlichkeiten im Haus Elim im Salemspital, erreichen Sie &uuml;ber den Haupteingang, in Verl&auml;ngerung des Geschosses A1.&nbsp;Sie finden uns nach der Warte- und Empfangszone der orthop&auml;dischen Gemeinschaftspraxis ganz hinten, am Ende des Korridors.</p>\r\n\r\n<ul>\r\n	<li><a class=\"link-icon icon-link\" href=\"{NODE_22}\">Lageplan/Anreise</a></li>\r\n</ul>\r\n</section>\r\n<section class=\"lightbox-previews\">\r\n  <a class=\"lightbox-links\" data-lightbox=\"gallery-1\" data-title=\"Bild 1\" href=\"//fakeimg.pl/1000x720?text=Bild1\"><img src=\"//fakeimg.pl/300?text=Bild1\" alt></a>\r\n  <a class=\"lightbox-links\" data-lightbox=\"gallery-1\" href=\"//fakeimg.pl/1000x500?text=Bild2\"><img src=\"//fakeimg.pl/300?text=Bild2\" alt></a>\r\n  <a class=\"lightbox-links\" data-lightbox=\"gallery-1\" data-title=\"Bild 3\" href=\"//fakeimg.pl/1000?text=Bild3\"><img src=\"//fakeimg.pl/300?text=Bild3\" alt></a>\r\n  <a class=\"lightbox-links\" data-lightbox=\"gallery-1\" data-title=\"Bild 4\" href=\"//fakeimg.pl/1000x1500?text=Bild4\"><img src=\"//fakeimg.pl/300?text=Bild4\" alt></a>\r\n</section>\r\n<section class=\"content-section\">\r\n<h2>Assistenz&auml;rzte bei CHRISTENORTHO AG</h2>\r\n\r\n<p>Seit dem 1. Januar 2008 werden bei CHRISTENORTHO AG Assistenz&auml;rzte ausgebildet, deren Ziel die Erlangung des Facharztes f&uuml;r Orthop&auml;die und Traumatologie des Bewegungsapparates ist.</p>\r\n\r\n<p>Vom 1. Januar 2010 bis 31. M&auml;rz 2013 fand bez&uuml;glich Weiterbildung eine enge Zusammenarbeit mit dem Bruderholzspital in Basel (Klinikleiter Prof. Dr. med. N. Friederich) statt. Am 1. Juli 2013 ist eine neue Kooperation mit der Orthop&auml;dischen Universit&auml;tsklinik des Inselspitals Bern angelaufen.</p>\r\n\r\n<p>Geeignete und interessierte Kandidaten absolvieren bis zu einem Jahr ihrer Weiterbildung bei CHRISTENORTHO AG und kehren dann ans Inselspital Bern zur&uuml;ck, um die Ausbildung zum Facharzt fort zu setzen. Die Assistenz&auml;rzte bei CHRISTENORTHO AG sind voll in den Praxisalltag integriert. Patienten werden ihnen in der Sprechstunde, auf der Abteilung oder auch im Operationssaal begegnen, gewisse Arbeiten werden an sie delegiert.</p>\r\n</section>\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(454,'update','2015-04-13 09:42:01',33,'45','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 09:42:01.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:7:\"content\";s:2525:\"<section class=\"content-section\">\r\n<p>Unsere Praxisr&auml;umlichkeiten im Haus Elim im Salemspital, erreichen Sie &uuml;ber den Haupteingang, in Verl&auml;ngerung des Geschosses A1.&nbsp;Sie finden uns nach der Warte- und Empfangszone der orthop&auml;dischen Gemeinschaftspraxis ganz hinten, am Ende des Korridors.</p>\r\n\r\n<ul>\r\n	<li><a class=\"link-icon icon-link\" href=\"{NODE_22}\">Lageplan/Anreise</a></li>\r\n</ul>\r\n</section>\r\n<section class=\"lightbox-previews\">\r\n  <a class=\"lightbox-links\" data-lightbox=\"gallery-1\" data-title=\"Bild 1\" href=\"//fakeimg.pl/1000x720?text=Bild1\">\r\n    <figure>\r\n      <img src=\"//fakeimg.pl/300?text=Bild1\" alt>\r\n      <figcaption>Bildbeschrieb</figcaption>\r\n    </figure>\r\n  </a>\r\n  <a class=\"lightbox-links\" data-lightbox=\"gallery-1\" href=\"//fakeimg.pl/1000x500?text=Bild2\">\r\n    <figure>\r\n      <img src=\"//fakeimg.pl/300?text=Bild2\" alt>\r\n      <figcaption>Bildbeschrieb</figcaption>\r\n    </figure>\r\n  </a>\r\n  <a class=\"lightbox-links\" data-lightbox=\"gallery-1\" data-title=\"Bild 3\" href=\"//fakeimg.pl/1000?text=Bild3\">\r\n    <figure>\r\n      <img src=\"//fakeimg.pl/300?text=Bild3\" alt>\r\n      <figcaption>Bildbeschrieb</figcaption>\r\n    </figure>\r\n  </a>\r\n  <a class=\"lightbox-links\" data-lightbox=\"gallery-1\" data-title=\"Bild 4\" href=\"//fakeimg.pl/1000x1500?text=Bild4\">\r\n    <figure>\r\n      <img src=\"//fakeimg.pl/300?text=Bild4\" alt>\r\n      <figcaption>Bildbeschrieb</figcaption>\r\n    </figure>\r\n  </a>\r\n</section>\r\n<section class=\"content-section\">\r\n<h2>Assistenz&auml;rzte bei CHRISTENORTHO AG</h2>\r\n\r\n<p>Seit dem 1. Januar 2008 werden bei CHRISTENORTHO AG Assistenz&auml;rzte ausgebildet, deren Ziel die Erlangung des Facharztes f&uuml;r Orthop&auml;die und Traumatologie des Bewegungsapparates ist.</p>\r\n\r\n<p>Vom 1. Januar 2010 bis 31. M&auml;rz 2013 fand bez&uuml;glich Weiterbildung eine enge Zusammenarbeit mit dem Bruderholzspital in Basel (Klinikleiter Prof. Dr. med. N. Friederich) statt. Am 1. Juli 2013 ist eine neue Kooperation mit der Orthop&auml;dischen Universit&auml;tsklinik des Inselspitals Bern angelaufen.</p>\r\n\r\n<p>Geeignete und interessierte Kandidaten absolvieren bis zu einem Jahr ihrer Weiterbildung bei CHRISTENORTHO AG und kehren dann ans Inselspital Bern zur&uuml;ck, um die Ausbildung zum Facharzt fort zu setzen. Die Assistenz&auml;rzte bei CHRISTENORTHO AG sind voll in den Praxisalltag integriert. Patienten werden ihnen in der Sprechstunde, auf der Abteilung oder auch im Operationssaal begegnen, gewisse Arbeiten werden an sie delegiert.</p>\r\n</section>\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(455,'update','2015-04-13 10:01:46',11,'16','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 10:01:45.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:12:\"contentTitle\";s:7:\"Sitemap\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(456,'update','2015-04-13 10:04:26',12,'53','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 10:04:26.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:7:\"content\";s:10963:\"<p>Hier finden Sie Angaben zu eigenen Publikationen in Schrift, Ton oder Bild in medizinischen Fachzeitschriften oder sonstigen Publikationsorganen. Ausserdem erfahren Sie, was bei christenortho aus Gr&uuml;nden der Qualit&auml;tssicherung zur Zeit genauer untersucht und ausgewertet wird. Schliesslich k&ouml;nnen Sie in dieser Rubrik Hinweise auf besonders wichtige Ver&ouml;ffentlichungen anderer Autoren im Zusammenhang mit dem T&auml;tigkeitsbereich von christenortho finden.</p>\r\n\r\n<h2>Laufende Arbeiten bei christenortho</h2>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">KOOS und HOOS Score</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Alle Patienten, die sich f&uuml;r eine Knie- oder H&uuml;ftprothese&nbsp;entscheiden, werden gebeten, vor und 1 Jahr nach der Operation den KOOS Score f&uuml;r Knie und HOOS Score f&uuml;r H&uuml;fte (Beantwortung von ca. 100 Fragen) auszuf&uuml;llen. Die Fragebogen basieren ausschliesslich auf Ihren Angaben und geh&ouml;ren somit zu den heute generell verlangten Patient related outcome Messungen (PROM), ohne die eine Auswertung nicht mehr akzeptiert wird. Der KOOS und HOOS Score sind validiert und international anerkannt, um detaillierte Angaben zu Knie- und H&uuml;ftprothesen zu erhalten. Erg&auml;nzend werden Untersuchungsresultate des Arztes und R&ouml;ntgenauswertungen die Beurteilung des Resultates abrunden.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title last\"><a class=\"accordion-link\" href=\"#\">SIRIS</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Alle Knie- und H&uuml;ftprothesen bei CHRISTENORTHO AG werden seit dem 1.1.2008 systematisch auf elektronische Weise (unter Wahrung der Patientenanonymit&auml;t) ins Schweizerische Prothesenregister eingegeben. S&auml;mtliche Journey-Knieprothesen wurden retrospektiv seit der Erstimplantation am 1.12.2006 erfasst. Seit September 2012 ist die Erfassung der Knie- und H&uuml;ftprothesen in der Schweiz obligatorisch <a href=\"http://www.siris-implant.ch\" target=\"_blank\">(Schweizerisches Prothesenregister SIRIS)</a>.<br />\r\nBei allen Prothesen erfolgt die Eingabe vor und nach jeder Operation sowie anl&auml;sslich der Jahreskontrolle.&nbsp;Muss eine Prothese reoperiert werden, impliziert dies einen neuen Eintrag ins Register. Damit k&ouml;nnen in relativ kurzer Zeit viel Aussagen &uuml;ber&nbsp;Zuverl&auml;ssigkeit eines Operationsverfahrens und einer Prothese gemacht werden.</p>\r\n\r\n<p>Jederzeit k&ouml;nnen Auswertungen der eigenen, eingegebenen Daten erhoben und anonym mit anderen Zentren der Schweiz verglichen werden. Ziel ist selbstredend, das SIRIS auch mit internationalen Registern (Schweden, Finnland Norwegen,&nbsp;Australien, Neuseeland, usw.) zu verkn&uuml;pfen.</p>\r\n</div>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h2>Studien</h2>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Kein Unterschied zwischen mobilen und fixen Polyaethyleneins&auml;tzen im balanSys-Knie</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>In einer prospektiv randomisierten Arbeit in Zusammenarbeit mit dem Zieglerspital Bern und der Sint Maartenskliniek in Nijmegen konnten bei 92 Patienten 3, 6 und 12 Monate nach Knie-Totalprothese in den zwei Gruppen keine signifikanten Unterschiede in der aktiven Beugef&auml;higkeit der Kniegelenke gezeigt werden. Verglichen wurden zwei verschiedene Kunststoffteile bei sonst identischem Prothesendesign. Bei der einen Gruppe wurde das Polyaethylen fix am Schienbeinteil eingerastet, bei der anderen wurde ein sogenannt moblier L&auml;ufer verwendet, der sich drehen und besch&auml;nkt auch nach vorne, respektive hinten bewegen kann. Patienten mit dem fixen Polyaethylen hatten weniger Schwierigkeiten mit dem Treppen steigen in der Fr&uuml;hphase nach der Operation. Die Arbeit wurde im Journal KSSTA (Knee Surg Sports Traumatol Arthrosc) 2012 publiziert (Jacobs WCH et al., Funcitonal performance of mobile versus fixed bearing total knee prosthesis: a randomised controlled trial, KSSTA 2012, 20: 1450-55).</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Prospektive randomisierte Studie &uuml;ber Analgesie nach Schulteroperationen</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Zusammen mit 4 An&auml;sthesisten und des Schmerzdienstes des Salemspitals wurden 50 Patienten in eine prospektiv randomisierte Arbeit eingschlossen, deren Daten noch komplettiert und ausgewertet werden m&uuml;ssen. Verglichen wurde dabei die Schmerzbehandlung in den ersten 2 Tagen nach der Operation von gr&ouml;sseren Schultereingriffen (Rekonstuktion der Rotatorenmanschette, Schulterprothese). Die Operationen wurden alle in Allgemeinnarkose durchgef&uuml;hrt. Die eine Gruppe erhielt in klassischer Weise nach der Opration eine Schmerzpumpe, &uuml;ber welche sich der Patient selbst&auml;ndig die notwendige Menge an Schmerzmitteln zuf&uuml;gen konnte. In der anderen Gruppe wurde unmittelbar vor der Operation unter Stimulation und Ultraschallkontrolle ein Katheter auf die Armnerven auf H&ouml;he des Halsrandes eingelegt. &Uuml;ber diesen Katheter wurde ein lokales Bet&auml;ubungsmittel per Pumpe nach Bedarf eingebracht. Verglichen wurden Schmerzintensit&auml;t, Schmerzmittelbedarf und Resultate nach der Schulteroperation. Die Datenerhebung und Auswertung sind noch im Gange. Grob sind zwischen den beiden Gruppen keine gr&ouml;sseren Unterschiede festzustellen, dies bleibt statistisch auszuwerten.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Balancierung des hinteren Kreuzbandes bei Knieprothesen</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Bei 101 Kniegelenken wurden bei einer Knie-Totalprothese intraoperativ Messungen durchgef&uuml;hrt, um mehr Erkenntnisse &uuml;ber das Verhalten des hinteren Kreuzbandes zu gewinnen. Dies ist bei Prothesenmodellen zentral, bei denen das hintere Kreuzband erhalten wird und von dem man den Erhalt seiner Funktion zugrunde legt. Die Arbeit mit Journeyprothesen war insofern aufschlussreich, als bei dieser Prothese beide Kreuzb&auml;nder entfernt werden (vgl. &quot;Das Journey Knie&quot;). Somit konnten die Messungen mit prim&auml;rem Erhalt des hinteren Kreuzbandes und dann nach Entfernung durchgef&uuml;hrt werden. Die Studie liefert keine eindeutigen Resultate, welche die korrekte Balancierung des hinteren Kreuzbandes sicher erlauben w&uuml;rde.</p>\r\n\r\n<p>Die Arbeit wurde im Juni 2010 am Europ&auml;ischen Kniekongress der ESSKA in Oslo pr&auml;sentiert. Sie ist elektronisch im Journal KSSTA (Knee Surgery Sports Traumatology Arthroscopy) im Juli 2011 publiziert und ist in gedruckter Form in der Ausgabe 3 vom M&auml;rz 2012 erschienen.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Die ersten 226 Journey Kniegelenke</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Die Resultate der ersten 103 Journey Knieprothesen, welche seit dem 1.12.2006 im Salemspital eingesetzt worden sind, wurden als Poster am Europ&auml;ischen Kniekongress in Oslo 2010 vorgestellt.<br />\r\nMittlerweile wurde &uuml;ber 226 derartige Gelenke implantiert. Kurzfristige Resultate wurden vom 27.-29. April 2011 am S&uuml;ddeutschen Orthop&auml;den Kongress in Baden-Baden und im Juni an der Jahrestagung der Scheizerischen Gesellschaft f&uuml;r Orthop&auml;die und Traumatologie vorgestellt.</p>\r\n\r\n<p>Das Knie liefert &uuml;berduchschnittlich gute kurzfristige Resultate, allerdings mit mehr Komplikationen als herk&ouml;mmliche Gelenke. Die Komplikationsrate nimmt mit Zunahme der Erfahrung des Chirurgen ab, bleibt aber leicht erh&ouml;ht. Offenbar verzeiht das Journey-System keine, auch nur kleine Abweichungen von der idealen Positionierung. Es scheint auch weniger geeignet bei eher laxen Verh&auml;ltnissen, sofern nicht eine kr&auml;ftige Muskulatur vorhanden ist.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">102 herk&ouml;mmlich implantierte versus 124 navigierte Journey-Prothesen</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Durch Einsatz der Computernavigation konnte die Pr&auml;zision der Knochenschnitte an Schienbeinkopf und Oberschenkel nicht signifikant verbessert werden. Hingegen k&ouml;nnen die Ausreisser bez&uuml;glich Achsenfehler sowohl f&uuml;r das X- wie O-Bein reduziert werden. Die Wertigkeit der Navigation bleibt somit - wie in der Literatur - weiter umstritten. Es stellt sich nach wie vor die Frage, ob die Verl&auml;ngerung der Operationszeit um ca. 10-15 Minuten und die Kosten f&uuml;r die Navigation (z.B. f&uuml;r die Markerkugeln) gerechtfertigt werden kann.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Hydroxiappatit-beschichtete zementfreie H&uuml;ftsch&auml;fte vom Typus SL MIA sinken weniger ein als nicht beschichtete Sch&auml;fte</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>H&uuml;ft-Totalprothesen d&uuml;rfen heute dank der &nbsp;weniger invasiven Technik sofort voll belastet werden, dies obwohl zementfreie Verankerungen immer h&auml;ufiger Anwendung finden. In R&ouml;ntgenkontrollen nach der Operation sowie nach 3 und 12 Monaten fiel auf, dass die Sch&auml;fte zum Nachsinken neigen.</p>\r\n\r\n<p>In einer vergleichenden Studie konnten wir zeigen, dass die neuen, beschichteten Sch&auml;fte statistisch signifikant weniger nachsintern als das nicht beschichtete Vorg&auml;ngermodell. Diese wurde wurden in Baden-Baden und am SGOT Kongress in Lausanne vorgestellt. Wir verwenden nur noch die beschichteten H&uuml;ftsch&auml;fte.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Auswertung Pain Score SEQ</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Die Resultate des Pain Scores sind eindr&uuml;cklich, da sie dank dem Vergleich mit der Normalbev&ouml;lkerung die Einschr&auml;nkungen jeweils vor einer Operation (H&uuml;ft- oder Knie-Totalprothese, respektive Rekonstruktion der Rotatorenmanschette) sichtbar machen und durch die Wiederholung nach einem Jahr die Verbesserung durch den Eingriff zeigen. Zu diesem Zeitpunkt kann wiederum mit der Normalbev&ouml;lkerung verglichen werden.</p>\r\n\r\n<p>Der Score soll mit einem g&auml;ngigen Wertesystem bei Knieeingriffen (KOOS-Score) verglichen werden. Ziel sind 75 Patienten, welche beide Scores jeweils vor der Knie-Totalprothese und 1 Jahr danach ausgef&uuml;llt haben. Die Auswertung erfolgt im Rahmen einer Disseration und Masterarbeit von Matthias Christen.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">LARS Band</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Seit 3 Jahren wird bei Sehnendefekten in erster Linie im Bereich des Kniegelenkes ein Polyesterband (LARS) zur Verst&auml;rkung eingen&auml;ht, das in der Tumorchirurgie gut erprobt ist. Die ersten Resultate wurden im April 2011 in Baden-Baden am S&uuml;ddeutschen Orthop&auml;den Kongress und im Juni 2011 an der Jahrestagung der Schweizerischen Gesellschaft f&uuml;r Orthop&auml;die und Traumatologie SGOT vorgestellt.</p>\r\n</div>\r\n\r\n<p>&nbsp;</p>\r\n\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(457,'update','2015-04-13 10:05:02',13,'53','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 10:05:02.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:7:\"content\";s:10966:\"<p>Hier finden Sie Angaben zu eigenen Publikationen in Schrift, Ton oder Bild in medizinischen Fachzeitschriften oder sonstigen Publikationsorganen. Ausserdem erfahren Sie, was bei christenortho aus Gr&uuml;nden der Qualit&auml;tssicherung zur Zeit genauer untersucht und ausgewertet wird. Schliesslich k&ouml;nnen Sie in dieser Rubrik Hinweise auf besonders wichtige Ver&ouml;ffentlichungen anderer Autoren im Zusammenhang mit dem T&auml;tigkeitsbereich von christenortho finden.</p>\r\n\r\n<h2>Laufende Arbeiten bei christenortho</h2>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">KOOS und HOOS Score</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Alle Patienten, die sich f&uuml;r eine Knie- oder H&uuml;ftprothese&nbsp;entscheiden, werden gebeten, vor und 1 Jahr nach der Operation den KOOS Score f&uuml;r Knie und HOOS Score f&uuml;r H&uuml;fte (Beantwortung von ca. 100 Fragen) auszuf&uuml;llen. Die Fragebogen basieren ausschliesslich auf Ihren Angaben und geh&ouml;ren somit zu den heute generell verlangten Patient related outcome Messungen (PROM), ohne die eine Auswertung nicht mehr akzeptiert wird. Der KOOS und HOOS Score sind validiert und international anerkannt, um detaillierte Angaben zu Knie- und H&uuml;ftprothesen zu erhalten. Erg&auml;nzend werden Untersuchungsresultate des Arztes und R&ouml;ntgenauswertungen die Beurteilung des Resultates abrunden.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title last\"><a class=\"accordion-link\" href=\"#\">SIRIS</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Alle Knie- und H&uuml;ftprothesen bei CHRISTENORTHO AG werden seit dem 1.1.2008 systematisch auf elektronische Weise (unter Wahrung der Patientenanonymit&auml;t) ins Schweizerische Prothesenregister eingegeben. S&auml;mtliche Journey-Knieprothesen wurden retrospektiv seit der Erstimplantation am 1.12.2006 erfasst. Seit September 2012 ist die Erfassung der Knie- und H&uuml;ftprothesen in der Schweiz obligatorisch <a href=\"http://www.siris-implant.ch\" target=\"_blank\">(Schweizerisches Prothesenregister SIRIS)</a>.</p>\r\n\r\n<p>Bei allen Prothesen erfolgt die Eingabe vor und nach jeder Operation sowie anl&auml;sslich der Jahreskontrolle.&nbsp;Muss eine Prothese reoperiert werden, impliziert dies einen neuen Eintrag ins Register. Damit k&ouml;nnen in relativ kurzer Zeit viel Aussagen &uuml;ber&nbsp;Zuverl&auml;ssigkeit eines Operationsverfahrens und einer Prothese gemacht werden.</p>\r\n\r\n<p>Jederzeit k&ouml;nnen Auswertungen der eigenen, eingegebenen Daten erhoben und anonym mit anderen Zentren der Schweiz verglichen werden. Ziel ist selbstredend, das SIRIS auch mit internationalen Registern (Schweden, Finnland Norwegen,&nbsp;Australien, Neuseeland, usw.) zu verkn&uuml;pfen.</p>\r\n</div>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h2>Studien</h2>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Kein Unterschied zwischen mobilen und fixen Polyaethyleneins&auml;tzen im balanSys-Knie</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>In einer prospektiv randomisierten Arbeit in Zusammenarbeit mit dem Zieglerspital Bern und der Sint Maartenskliniek in Nijmegen konnten bei 92 Patienten 3, 6 und 12 Monate nach Knie-Totalprothese in den zwei Gruppen keine signifikanten Unterschiede in der aktiven Beugef&auml;higkeit der Kniegelenke gezeigt werden. Verglichen wurden zwei verschiedene Kunststoffteile bei sonst identischem Prothesendesign. Bei der einen Gruppe wurde das Polyaethylen fix am Schienbeinteil eingerastet, bei der anderen wurde ein sogenannt moblier L&auml;ufer verwendet, der sich drehen und besch&auml;nkt auch nach vorne, respektive hinten bewegen kann. Patienten mit dem fixen Polyaethylen hatten weniger Schwierigkeiten mit dem Treppen steigen in der Fr&uuml;hphase nach der Operation. Die Arbeit wurde im Journal KSSTA (Knee Surg Sports Traumatol Arthrosc) 2012 publiziert (Jacobs WCH et al., Funcitonal performance of mobile versus fixed bearing total knee prosthesis: a randomised controlled trial, KSSTA 2012, 20: 1450-55).</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Prospektive randomisierte Studie &uuml;ber Analgesie nach Schulteroperationen</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Zusammen mit 4 An&auml;sthesisten und des Schmerzdienstes des Salemspitals wurden 50 Patienten in eine prospektiv randomisierte Arbeit eingschlossen, deren Daten noch komplettiert und ausgewertet werden m&uuml;ssen. Verglichen wurde dabei die Schmerzbehandlung in den ersten 2 Tagen nach der Operation von gr&ouml;sseren Schultereingriffen (Rekonstuktion der Rotatorenmanschette, Schulterprothese). Die Operationen wurden alle in Allgemeinnarkose durchgef&uuml;hrt. Die eine Gruppe erhielt in klassischer Weise nach der Opration eine Schmerzpumpe, &uuml;ber welche sich der Patient selbst&auml;ndig die notwendige Menge an Schmerzmitteln zuf&uuml;gen konnte. In der anderen Gruppe wurde unmittelbar vor der Operation unter Stimulation und Ultraschallkontrolle ein Katheter auf die Armnerven auf H&ouml;he des Halsrandes eingelegt. &Uuml;ber diesen Katheter wurde ein lokales Bet&auml;ubungsmittel per Pumpe nach Bedarf eingebracht. Verglichen wurden Schmerzintensit&auml;t, Schmerzmittelbedarf und Resultate nach der Schulteroperation. Die Datenerhebung und Auswertung sind noch im Gange. Grob sind zwischen den beiden Gruppen keine gr&ouml;sseren Unterschiede festzustellen, dies bleibt statistisch auszuwerten.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Balancierung des hinteren Kreuzbandes bei Knieprothesen</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Bei 101 Kniegelenken wurden bei einer Knie-Totalprothese intraoperativ Messungen durchgef&uuml;hrt, um mehr Erkenntnisse &uuml;ber das Verhalten des hinteren Kreuzbandes zu gewinnen. Dies ist bei Prothesenmodellen zentral, bei denen das hintere Kreuzband erhalten wird und von dem man den Erhalt seiner Funktion zugrunde legt. Die Arbeit mit Journeyprothesen war insofern aufschlussreich, als bei dieser Prothese beide Kreuzb&auml;nder entfernt werden (vgl. &quot;Das Journey Knie&quot;). Somit konnten die Messungen mit prim&auml;rem Erhalt des hinteren Kreuzbandes und dann nach Entfernung durchgef&uuml;hrt werden. Die Studie liefert keine eindeutigen Resultate, welche die korrekte Balancierung des hinteren Kreuzbandes sicher erlauben w&uuml;rde.</p>\r\n\r\n<p>Die Arbeit wurde im Juni 2010 am Europ&auml;ischen Kniekongress der ESSKA in Oslo pr&auml;sentiert. Sie ist elektronisch im Journal KSSTA (Knee Surgery Sports Traumatology Arthroscopy) im Juli 2011 publiziert und ist in gedruckter Form in der Ausgabe 3 vom M&auml;rz 2012 erschienen.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Die ersten 226 Journey Kniegelenke</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Die Resultate der ersten 103 Journey Knieprothesen, welche seit dem 1.12.2006 im Salemspital eingesetzt worden sind, wurden als Poster am Europ&auml;ischen Kniekongress in Oslo 2010 vorgestellt.<br />\r\nMittlerweile wurde &uuml;ber 226 derartige Gelenke implantiert. Kurzfristige Resultate wurden vom 27.-29. April 2011 am S&uuml;ddeutschen Orthop&auml;den Kongress in Baden-Baden und im Juni an der Jahrestagung der Scheizerischen Gesellschaft f&uuml;r Orthop&auml;die und Traumatologie vorgestellt.</p>\r\n\r\n<p>Das Knie liefert &uuml;berduchschnittlich gute kurzfristige Resultate, allerdings mit mehr Komplikationen als herk&ouml;mmliche Gelenke. Die Komplikationsrate nimmt mit Zunahme der Erfahrung des Chirurgen ab, bleibt aber leicht erh&ouml;ht. Offenbar verzeiht das Journey-System keine, auch nur kleine Abweichungen von der idealen Positionierung. Es scheint auch weniger geeignet bei eher laxen Verh&auml;ltnissen, sofern nicht eine kr&auml;ftige Muskulatur vorhanden ist.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">102 herk&ouml;mmlich implantierte versus 124 navigierte Journey-Prothesen</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Durch Einsatz der Computernavigation konnte die Pr&auml;zision der Knochenschnitte an Schienbeinkopf und Oberschenkel nicht signifikant verbessert werden. Hingegen k&ouml;nnen die Ausreisser bez&uuml;glich Achsenfehler sowohl f&uuml;r das X- wie O-Bein reduziert werden. Die Wertigkeit der Navigation bleibt somit - wie in der Literatur - weiter umstritten. Es stellt sich nach wie vor die Frage, ob die Verl&auml;ngerung der Operationszeit um ca. 10-15 Minuten und die Kosten f&uuml;r die Navigation (z.B. f&uuml;r die Markerkugeln) gerechtfertigt werden kann.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Hydroxiappatit-beschichtete zementfreie H&uuml;ftsch&auml;fte vom Typus SL MIA sinken weniger ein als nicht beschichtete Sch&auml;fte</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>H&uuml;ft-Totalprothesen d&uuml;rfen heute dank der &nbsp;weniger invasiven Technik sofort voll belastet werden, dies obwohl zementfreie Verankerungen immer h&auml;ufiger Anwendung finden. In R&ouml;ntgenkontrollen nach der Operation sowie nach 3 und 12 Monaten fiel auf, dass die Sch&auml;fte zum Nachsinken neigen.</p>\r\n\r\n<p>In einer vergleichenden Studie konnten wir zeigen, dass die neuen, beschichteten Sch&auml;fte statistisch signifikant weniger nachsintern als das nicht beschichtete Vorg&auml;ngermodell. Diese wurde wurden in Baden-Baden und am SGOT Kongress in Lausanne vorgestellt. Wir verwenden nur noch die beschichteten H&uuml;ftsch&auml;fte.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">Auswertung Pain Score SEQ</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Die Resultate des Pain Scores sind eindr&uuml;cklich, da sie dank dem Vergleich mit der Normalbev&ouml;lkerung die Einschr&auml;nkungen jeweils vor einer Operation (H&uuml;ft- oder Knie-Totalprothese, respektive Rekonstruktion der Rotatorenmanschette) sichtbar machen und durch die Wiederholung nach einem Jahr die Verbesserung durch den Eingriff zeigen. Zu diesem Zeitpunkt kann wiederum mit der Normalbev&ouml;lkerung verglichen werden.</p>\r\n\r\n<p>Der Score soll mit einem g&auml;ngigen Wertesystem bei Knieeingriffen (KOOS-Score) verglichen werden. Ziel sind 75 Patienten, welche beide Scores jeweils vor der Knie-Totalprothese und 1 Jahr danach ausgef&uuml;llt haben. Die Auswertung erfolgt im Rahmen einer Disseration und Masterarbeit von Matthias Christen.</p>\r\n</div>\r\n\r\n<h3 class=\"accordion-title\"><a class=\"accordion-link\" href=\"#\">LARS Band</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Seit 3 Jahren wird bei Sehnendefekten in erster Linie im Bereich des Kniegelenkes ein Polyesterband (LARS) zur Verst&auml;rkung eingen&auml;ht, das in der Tumorchirurgie gut erprobt ist. Die ersten Resultate wurden im April 2011 in Baden-Baden am S&uuml;ddeutschen Orthop&auml;den Kongress und im Juni 2011 an der Jahrestagung der Schweizerischen Gesellschaft f&uuml;r Orthop&auml;die und Traumatologie SGOT vorgestellt.</p>\r\n</div>\r\n\r\n<p>&nbsp;</p>\r\n\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(458,'create','2015-04-13 10:12:37',1,'72','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:33:{s:14:\"nodeIdShadowed\";i:46;s:4:\"lang\";i:1;s:4:\"type\";s:7:\"content\";s:7:\"caching\";b:0;s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 10:12:36.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:9:\"updatedBy\";s:23:\"webmaster@werbelinie.ch\";s:5:\"title\";s:9:\"Downloads\";s:10:\"linkTarget\";s:0:\"\";s:12:\"contentTitle\";s:9:\"Downloads\";s:4:\"slug\";s:9:\"Downloads\";s:7:\"content\";s:21:\"<p>Downloads...</p>\r\n\";s:10:\"sourceMode\";b:0;s:13:\"customContent\";s:0:\"\";s:30:\"useCustomContentForAllChannels\";i:0;s:7:\"cssName\";s:0:\"\";s:10:\"cssNavName\";s:0:\"\";s:4:\"skin\";i:0;s:21:\"useSkinForAllChannels\";i:0;s:9:\"metatitle\";s:9:\"Downloads\";s:8:\"metadesc\";s:9:\"Downloads\";s:8:\"metakeys\";s:9:\"Downloads\";s:10:\"metarobots\";b:1;s:5:\"start\";N;s:3:\"end\";N;s:13:\"editingStatus\";s:0:\"\";s:10:\"protection\";i:0;s:16:\"frontendAccessId\";i:0;s:15:\"backendAccessId\";i:0;s:7:\"display\";b:1;s:6:\"active\";b:0;s:6:\"target\";s:0:\"\";s:6:\"module\";s:6:\"access\";s:3:\"cmd\";s:0:\"\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(459,'update','2015-04-13 10:12:37',2,'72','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 10:12:37.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:6:\"active\";b:1;}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(460,'create','2015-04-13 10:12:52',1,'73','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:33:{s:14:\"nodeIdShadowed\";i:47;s:4:\"lang\";i:1;s:4:\"type\";s:7:\"content\";s:7:\"caching\";b:0;s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 10:12:52.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:9:\"updatedBy\";s:23:\"webmaster@werbelinie.ch\";s:5:\"title\";s:5:\"Links\";s:10:\"linkTarget\";s:0:\"\";s:12:\"contentTitle\";s:5:\"Links\";s:4:\"slug\";s:5:\"Links\";s:7:\"content\";s:17:\"<p>Links...</p>\r\n\";s:10:\"sourceMode\";b:0;s:13:\"customContent\";s:0:\"\";s:30:\"useCustomContentForAllChannels\";i:0;s:7:\"cssName\";s:0:\"\";s:10:\"cssNavName\";s:0:\"\";s:4:\"skin\";i:0;s:21:\"useSkinForAllChannels\";i:0;s:9:\"metatitle\";s:5:\"Links\";s:8:\"metadesc\";s:5:\"Links\";s:8:\"metakeys\";s:5:\"Links\";s:10:\"metarobots\";b:1;s:5:\"start\";N;s:3:\"end\";N;s:13:\"editingStatus\";s:0:\"\";s:10:\"protection\";i:0;s:16:\"frontendAccessId\";i:0;s:15:\"backendAccessId\";i:0;s:7:\"display\";b:1;s:6:\"active\";b:0;s:6:\"target\";s:0:\"\";s:6:\"module\";s:6:\"access\";s:3:\"cmd\";s:0:\"\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(461,'update','2015-04-13 10:12:52',2,'73','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 10:12:52.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:6:\"active\";b:1;}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(462,'update','2015-04-13 10:20:14',2,'20','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:4:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 10:20:14.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:7:\"content\";s:1006:\"<h2>Firmenname und Domizil</h2>\r\n\r\n<p>CHRISTENORTHO AG<br />\r\nDr. med., M. H. A. Bernhard Christen<br>\r\n  Orthopädische Klinik Bern\r\n  Sch&auml;nzlistrasse 39<br />\r\nCH-3000 Bern</p>\r\n\r\n<p>Tel. +41 31 337 89 24<br />\r\n<a href=\"javascript:linkTo_UnCryptMailto(\'ocknvq&lt;dcvtgeBdcvtge0ej\', 2);\">info(at)christenortho.ch</a></p>\r\n<h2>Konzept, Webdesign und Realisierung</h2>\r\n\r\n<p><a href=\"http://www.werbelinie.ch\" target=\"_blank\">Werbelinie AG – Agentur für Kommunikation</a><br />\r\nThun und Bern<br />\r\n<a href=\"javascript:linkTo_UnCryptMailto(\'ocknvq&lt;ygdocuvgtBygtdgnkpkg0ej\', 2);\">webmaster(at)werbelinie.ch</a></p>\r\n\r\n\r\n<h2>Rechtliche Hinweise</h2>\r\n\r\n<p>Diese Website der CHRISTENORTHO AG dient ausschliesslich der Information. F&uuml;r die inhaltliche Richtigkeit und Vollst&auml;ndigkeit wird jegliche Haftung abgelehnt. Die Website sowie ihr Inhalt k&ouml;nnen jederzeit abge&auml;ndert werden. Das Copyright f&uuml;r s&auml;mtliche Inhalte dieser Website liegt bei der CHRISTENORTHO AG.</p>\";s:30:\"useCustomContentForAllChannels\";i:0;s:21:\"useSkinForAllChannels\";i:0;}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(463,'update','2015-04-13 10:21:01',3,'72','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 10:21:01.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:7:\"display\";b:0;}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(464,'update','2015-04-13 10:21:02',3,'73','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 10:21:02.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:7:\"display\";b:0;}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(465,'update','2015-04-13 10:21:34',4,'18','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:8:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 10:21:34.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:5:\"title\";s:10:\"Disclaimer\";s:12:\"contentTitle\";s:10:\"Disclaimer\";s:4:\"slug\";s:10:\"Disclaimer\";s:7:\"content\";s:3513:\"<h2>Inhalt des Onlineangebotes.</h2>\r\n\r\n<p>CHRISTENORTHO AG &uuml;bernimmt keinerlei Gew&auml;hr f&uuml;r die Aktualit&auml;t, Korrektheit, Vollst&auml;ndigkeit oder Qualit&auml;t der bereitgestellten Informationen. Die CHRISTENORTHO AG beh&auml;lt es sich ausdr&uuml;cklich vor, Teile der Seiten oder das gesamte Angebot ohne gesonderte Ank&uuml;ndigung zu ver&auml;ndern, zu erg&auml;nzen, zu l&ouml;schen oder die Ver&ouml;ffentlichung zeitweise oder endg&uuml;ltig einzustellen.</p>\r\n\r\n<h2>Links zu anderen Websites.</h2>\r\n\r\n<p>Durch Benutzung bestimmter Links auf der Website ist es Ihnen m&ouml;glich, auf die Websites von Drittpersonen zu gelangen. Die CHRISTENORTHO AG hat keinen Einfluss auf den Inhalt oder die Sicherheit dieser Websites und &uuml;bernimmt auch keine Verantwortung f&uuml;r dieselben. Sollten wider Erwarten rechts- oder sittenwidrige Inhalte &uuml;ber Links abrufbar sein, bittet die CHRISTENORTHO AG um Mitteilung.</p>\r\n\r\n<h2>Urheber- und Kennzeichenrechte.</h2>\r\n\r\n<p>Der Inhalt dieser Internetseiten ist urheberrechtlich gesch&uuml;tzt. Grafiken, Texte, Logos, Bilder usw. d&uuml;rfen nur nach schriftlicher Genehmigung durch die CHRISTENORTHO AG vervielf&auml;ltigt, kopiert, ge&auml;ndert, ver&ouml;ffentlicht, versendet, &uuml;bertragen oder in sonstiger Form f&uuml;r eigene Zwecke oder die Zwecke Dritter genutzt werden. Bei allenfalls genannten Produkt- und Firmennamen kann es sich um eingetragene Warenzeichen oder Marken handeln. Die unberechtigte Verwendung kann zu Schadensersatz- und Unterlassungsanspr&uuml;chen f&uuml;hren.</p>\r\n\r\n<h2>Datenschutz.</h2>\r\n\r\n<p>Sofern innerhalb des Internetangebotes die M&ouml;glichkeit zur Eingabe pers&ouml;nlicher oder gesch&auml;ftlicher Daten (Emailadressen, Namen, Anschriften, etc.) besteht, so erfolgt die Preisgabe dieser Daten seitens des Nutzers auf ausdr&uuml;cklich freiwilliger Basis. Wenn Sie sich entschliessen, der CHRISTENORTHO AG pers&ouml;nliche Daten &uuml;ber das Internet zu &uuml;berlassen, damit z.B. Korrespondenz abgewickelt oder eine Bestellung ausgef&uuml;hrt werden kann, so wird mit diesen Daten sorgf&auml;ltig und nach den strengen Regelungen des Bundesgesetz &uuml;ber den Datenschutz umgegangen.</p>\r\n\r\n<p>Die Nutzung durch Dritte der im Rahmen des Impressums oder vergleichbarer Angaben ver&ouml;ffentlichten Kontaktdaten der CHRISTENORTHO AG oder von Dritten wie Postanschriften, Telefon- und Faxnummern sowie Emailadressen zur &Uuml;bersendung von nicht ausdr&uuml;cklich angeforderten Informationen ist nicht gestattet. Rechtliche Schritte gegen die Versender von so genannten Spam-Mails bei Verst&ouml;ssen gegen dieses Verbot werden ausdr&uuml;cklich vorbehalten.</p>\r\n\r\n<h2>Haftungsausschluss.</h2>\r\n\r\n<p>Haftungsanspr&uuml;che gegen die CHRISTENORTHO AG, welche sich auf Sch&auml;den materieller oder ideeller Art beziehen, die durch die Nutzung oder Nichtnutzung der dargebotenen Informationen, durch die Nutzung fehlerhafter und unvollst&auml;ndiger Informationen oder durch Viren, die den Computer und die dazugeh&ouml;rige Ausr&uuml;stung befallen k&ouml;nnen verursacht wurden, sind grunds&auml;tzlich ausgeschlossen, sofern seitens der CHRISTENORTHO AG kein nachweislich vors&auml;tzliches oder grob fahrl&auml;ssiges Verschulden vorliegt.</p>\r\n\r\n<h2>Anwendbares Recht.</h2>\r\n\r\n<p>Anwendbar auf diese Website ist ausschliesslich Schweizerisches Recht. Der ausschliessliche Gerichtsstand f&uuml;r s&auml;mtliche Auseinandersetzungen im Zusammenhang liegt am Sitz der CHRISTENORTHO AG.</p>\";s:9:\"metatitle\";s:10:\"Disclaimer\";s:8:\"metadesc\";s:10:\"Disclaimer\";s:8:\"metakeys\";s:10:\"Disclaimer\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(466,'update','2015-04-13 10:22:48',3,'20','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 10:22:48.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:7:\"content\";s:1019:\"<h2>Firmenname und Domizil</h2>\r\n\r\n<p>CHRISTENORTHO AG<br />\r\nDr. med., M. H. A. Bernhard Christen<br />\r\nOrthop&auml;dische Klinik Bern Sch&auml;nzlistrasse 39<br />\r\nCH-3000 Bern</p>\r\n\r\n<p>Tel. +41 31 337 89 24<br />\r\n<a href=\"javascript:linkTo_UnCryptMailto(\'ocknvq<kphqBejtkuvgpqtvjq0ej\', 2);\">info(at)christenortho.ch</a></p>\r\n\r\n<h2>Konzept, Webdesign und Realisierung</h2>\r\n\r\n<p><a href=\"http://www.werbelinie.ch\" target=\"_blank\">Werbelinie AG &ndash; Agentur f&uuml;r Kommunikation</a><br />\r\nThun und Bern<br />\r\n<a href=\"javascript:linkTo_UnCryptMailto(\'ocknvq&lt;ygdocuvgtBygtdgnkpkg0ej\', 2);\">webmaster(at)werbelinie.ch</a></p>\r\n\r\n<h2>Rechtliche Hinweise</h2>\r\n\r\n<p>Diese Website der CHRISTENORTHO AG dient ausschliesslich der Information. F&uuml;r die inhaltliche Richtigkeit und Vollst&auml;ndigkeit wird jegliche Haftung abgelehnt. Die Website sowie ihr Inhalt k&ouml;nnen jederzeit abge&auml;ndert werden. Das Copyright f&uuml;r s&auml;mtliche Inhalte dieser Website liegt bei der CHRISTENORTHO AG.</p>\r\n\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(467,'update','2015-04-13 11:42:23',4,'39','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 11:42:23.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:7:\"display\";b:1;}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(468,'update','2015-04-13 11:44:15',5,'39','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 11:44:15.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:7:\"content\";s:1758:\"<h3 class=\"accordion-title in\"><a class=\"accordion-link\" href=\"#\">Arthrose des Hüftgelenkes (Coxarthrose)</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Verschleiss im Hüftgelenk zwischen Kopf und Pfanne mit Schmerzen, Einschränkung der Gehfähigkeit und Beweglichkeit. Beginn häufig schleichend, Verlauf wechselhaft, wetterabhängig.</p>\r\n\r\n<h4 class=\"accordion-subheading\">Symptome und Diagnostik</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Arthrose und Behandlungsm&ouml;glichkeiten</a></li>\r\n</ul>\r\n\r\n<h4 class=\"accordion-subheading\">Anatomie</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomie des Kniegelenkes</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomische Grundbegriffe</a></li>\r\n</ul>\r\n\r\n<h4 class=\"accordion-subheading\">Therapie und Nachbehandlung</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Der Knieprothesenwechsel</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Knie-Teilprothese</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Scharnierprothese</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Das Journey, eine Knie-Totalprothese der neuesten...</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Attune - Brainlab, die vielversprechende Kombination...</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Kontroversen in der Knieprothetik</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Arthroskopisches D&eacute;bridement</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Achsenumstellung, Achsenkorrektur</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Knie-Totalprothese</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Computernavigation</a></li>\r\n</ul>\r\n</div>\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(469,'update','2015-04-13 11:44:25',6,'39','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 11:44:25.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:7:\"content\";s:3520:\"<h3 class=\"accordion-title in\"><a class=\"accordion-link\" href=\"#\">Arthrose des Hüftgelenkes (Coxarthrose)</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Verschleiss im Hüftgelenk zwischen Kopf und Pfanne mit Schmerzen, Einschränkung der Gehfähigkeit und Beweglichkeit. Beginn häufig schleichend, Verlauf wechselhaft, wetterabhängig.</p>\r\n\r\n<h4 class=\"accordion-subheading\">Symptome und Diagnostik</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Arthrose und Behandlungsm&ouml;glichkeiten</a></li>\r\n</ul>\r\n\r\n<h4 class=\"accordion-subheading\">Anatomie</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomie des Kniegelenkes</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomische Grundbegriffe</a></li>\r\n</ul>\r\n\r\n<h4 class=\"accordion-subheading\">Therapie und Nachbehandlung</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Der Knieprothesenwechsel</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Knie-Teilprothese</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Scharnierprothese</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Das Journey, eine Knie-Totalprothese der neuesten...</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Attune - Brainlab, die vielversprechende Kombination...</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Kontroversen in der Knieprothetik</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Arthroskopisches D&eacute;bridement</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Achsenumstellung, Achsenkorrektur</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Knie-Totalprothese</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Computernavigation</a></li>\r\n</ul>\r\n</div>\r\n\r\n<h3 class=\"accordion-title in\"><a class=\"accordion-link\" href=\"#\">Arthrose des Hüftgelenkes (Coxarthrose)</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Verschleiss im Hüftgelenk zwischen Kopf und Pfanne mit Schmerzen, Einschränkung der Gehfähigkeit und Beweglichkeit. Beginn häufig schleichend, Verlauf wechselhaft, wetterabhängig.</p>\r\n\r\n<h4 class=\"accordion-subheading\">Symptome und Diagnostik</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Arthrose und Behandlungsm&ouml;glichkeiten</a></li>\r\n</ul>\r\n\r\n<h4 class=\"accordion-subheading\">Anatomie</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomie des Kniegelenkes</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomische Grundbegriffe</a></li>\r\n</ul>\r\n\r\n<h4 class=\"accordion-subheading\">Therapie und Nachbehandlung</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Der Knieprothesenwechsel</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Knie-Teilprothese</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Scharnierprothese</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Das Journey, eine Knie-Totalprothese der neuesten...</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Attune - Brainlab, die vielversprechende Kombination...</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Kontroversen in der Knieprothetik</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Arthroskopisches D&eacute;bridement</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Achsenumstellung, Achsenkorrektur</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Knie-Totalprothese</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Computernavigation</a></li>\r\n</ul>\r\n</div>\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(470,'update','2015-04-13 11:45:06',7,'39','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 11:45:06.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:7:\"content\";s:3452:\"<h3 class=\"accordion-title in\"><a class=\"accordion-link\" href=\"#\">Arthrose des Hüftgelenkes (Coxarthrose)</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Verschleiss im Hüftgelenk zwischen Kopf und Pfanne mit Schmerzen, Einschränkung der Gehfähigkeit und Beweglichkeit. Beginn häufig schleichend, Verlauf wechselhaft, wetterabhängig.</p>\r\n\r\n<h4 class=\"accordion-subheading\">Symptome und Diagnostik</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Arthrose und Behandlungsm&ouml;glichkeiten</a></li>\r\n</ul>\r\n\r\n<h4 class=\"accordion-subheading\">Anatomie</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomie des Kniegelenkes</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomische Grundbegriffe</a></li>\r\n</ul>\r\n\r\n<h4 class=\"accordion-subheading\">Therapie und Nachbehandlung</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Der Knieprothesenwechsel</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Knie-Teilprothese</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Scharnierprothese</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Das Journey, eine Knie-Totalprothese der neuesten...</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Attune - Brainlab, die vielversprechende Kombination...</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Kontroversen in der Knieprothetik</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Arthroskopisches D&eacute;bridement</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Achsenumstellung, Achsenkorrektur</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Knie-Totalprothese</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Computernavigation</a></li>\r\n</ul>\r\n</div>\r\n\r\n<h3 class=\"accordion-title in\"><a class=\"accordion-link\" href=\"#\">Einklemmungserscheinung (Impingement) beim Hüftgelenk</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Schmerzen bei Beugung der Hüfte vor allem in Kombination mit Innendrehung und Zuspreizung des Beines.</p>\r\n\r\n<h4 class=\"accordion-subheading\">Symptome und Diagnostik</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Arthrose und Behandlungsm&ouml;glichkeiten</a></li>\r\n</ul>\r\n\r\n<h4 class=\"accordion-subheading\">Anatomie</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomie des Kniegelenkes</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomische Grundbegriffe</a></li>\r\n</ul>\r\n\r\n<h4 class=\"accordion-subheading\">Therapie und Nachbehandlung</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Der Knieprothesenwechsel</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Knie-Teilprothese</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Scharnierprothese</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Das Journey, eine Knie-Totalprothese der neuesten...</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Attune - Brainlab, die vielversprechende Kombination...</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Kontroversen in der Knieprothetik</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Arthroskopisches D&eacute;bridement</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Achsenumstellung, Achsenkorrektur</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Knie-Totalprothese</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Computernavigation</a></li>\r\n</ul>\r\n</div>\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(471,'update','2015-04-13 11:45:16',8,'39','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:1:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 11:45:16.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(472,'update','2015-04-13 11:46:59',9,'39','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 11:46:59.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:7:\"content\";s:2829:\"<h3 class=\"accordion-title in\"><a class=\"accordion-link\" href=\"#\">Arthrose des Hüftgelenkes (Coxarthrose)</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Verschleiss im Hüftgelenk zwischen Kopf und Pfanne mit Schmerzen, Einschränkung der Gehfähigkeit und Beweglichkeit. Beginn häufig schleichend, Verlauf wechselhaft, wetterabhängig.</p>\r\n\r\n<h4 class=\"accordion-subheading\">Symptome und Diagnostik</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Arthrose und Behandlungsm&ouml;glichkeiten</a></li>\r\n</ul>\r\n\r\n<h4 class=\"accordion-subheading\">Anatomie</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomie des Hüftgelenkes</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomische Grundbegriffe</a></li>\r\n</ul>\r\n\r\n<h4 class=\"accordion-subheading\">Therapie und Nachbehandlung</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Kontroversen in der Hüftprothetik</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Hüft-Totalprothese</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Computernavigation</a></li>\r\n</ul>\r\n</div>\r\n\r\n<h3 class=\"accordion-title in\"><a class=\"accordion-link\" href=\"#\">Einklemmungserscheinung (Impingement) beim Hüftgelenk</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Schmerzen bei Beugung der Hüfte vor allem in Kombination mit Innendrehung und Zuspreizung des Beines.</p>\r\n\r\n<h4 class=\"accordion-subheading\">Symptome und Diagnostik</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Arthrose und Behandlungsm&ouml;glichkeiten</a></li>\r\n</ul>\r\n\r\n<h4 class=\"accordion-subheading\">Anatomie</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomie des Kniegelenkes</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomische Grundbegriffe</a></li>\r\n</ul>\r\n\r\n<h4 class=\"accordion-subheading\">Therapie und Nachbehandlung</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Der Knieprothesenwechsel</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Knie-Teilprothese</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Scharnierprothese</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Das Journey, eine Knie-Totalprothese der neuesten...</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Attune - Brainlab, die vielversprechende Kombination...</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Kontroversen in der Knieprothetik</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Arthroskopisches D&eacute;bridement</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Achsenumstellung, Achsenkorrektur</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Knie-Totalprothese</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Computernavigation</a></li>\r\n</ul>\r\n</div>\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(473,'update','2015-04-13 11:47:08',10,'39','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:1:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 11:47:08.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(474,'update','2015-04-13 11:48:20',11,'39','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 11:48:20.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:7:\"content\";s:1938:\"<h3 class=\"accordion-title in\"><a class=\"accordion-link\" href=\"#\">Arthrose des Hüftgelenkes (Coxarthrose)</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Verschleiss im Hüftgelenk zwischen Kopf und Pfanne mit Schmerzen, Einschränkung der Gehfähigkeit und Beweglichkeit. Beginn häufig schleichend, Verlauf wechselhaft, wetterabhängig.</p>\r\n\r\n<h4 class=\"accordion-subheading\">Symptome und Diagnostik</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Arthrose und Behandlungsm&ouml;glichkeiten</a></li>\r\n</ul>\r\n\r\n<h4 class=\"accordion-subheading\">Anatomie</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomie des Hüftgelenkes</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomische Grundbegriffe</a></li>\r\n</ul>\r\n\r\n<h4 class=\"accordion-subheading\">Therapie und Nachbehandlung</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Kontroversen in der Hüftprothetik</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Hüft-Totalprothese</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Computernavigation</a></li>\r\n</ul>\r\n</div>\r\n\r\n<h3 class=\"accordion-title in\"><a class=\"accordion-link\" href=\"#\">Einklemmungserscheinung (Impingement) beim Hüftgelenk</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Schmerzen bei Beugung der Hüfte vor allem in Kombination mit Innendrehung und Zuspreizung des Beines.</p>\r\n\r\n<h4 class=\"accordion-subheading\">Symptome und Diagnostik</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomie des Hüftgelenkes</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomische Grundbegriffe</a></li>\r\n</ul>\r\n\r\n<h4 class=\"accordion-subheading\">Therapie und Nachbehandlung</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Hüft-Totalprothese</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Computernavigation</a></li>\r\n</ul>\r\n</div>\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(475,'update','2015-04-13 11:50:00',12,'39','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 11:50:00.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:7:\"content\";s:2119:\"<h3 class=\"accordion-title in\"><a class=\"accordion-link\" href=\"#\">Arthrose des Hüftgelenkes (Coxarthrose)</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Verschleiss im Hüftgelenk zwischen Kopf und Pfanne mit Schmerzen, Einschränkung der Gehfähigkeit und Beweglichkeit. Beginn häufig schleichend, Verlauf wechselhaft, wetterabhängig.</p>\r\n\r\n<h4 class=\"accordion-subheading\">Symptome und Diagnostik</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Arthrose und Behandlungsm&ouml;glichkeiten</a></li>\r\n</ul>\r\n\r\n<h4 class=\"accordion-subheading\">Anatomie</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomie des Hüftgelenkes</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomische Grundbegriffe</a></li>\r\n</ul>\r\n\r\n<h4 class=\"accordion-subheading\">Therapie und Nachbehandlung</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Kontroversen in der Hüftprothetik</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Hüft-Totalprothese</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Computernavigation</a></li>\r\n</ul>\r\n</div>\r\n\r\n<h3 class=\"accordion-title in\"><a class=\"accordion-link\" href=\"#\">Einklemmungserscheinung (Impingement) beim Hüftgelenk</a></h3>\r\n\r\n<div class=\"accordion-container\">\r\n<p>Schmerzen bei Beugung der Hüfte vor allem in Kombination mit Innendrehung und Zuspreizung des Beines.</p>\r\n\r\n<h4 class=\"accordion-subheading\">Symptome und Diagnostik</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Arthrose und Behandlungsm&ouml;glichkeiten</a></li>\r\n</ul>\r\n  \r\n<h4 class=\"accordion-subheading\">Anatomie</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomie des Hüftgelenkes</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Anatomische Grundbegriffe</a></li>\r\n</ul>\r\n\r\n<h4 class=\"accordion-subheading\">Therapie und Nachbehandlung</h4>\r\n\r\n<ul class=\"pdf-list\">\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Hüft-Totalprothese</a></li>\r\n	<li><a class=\"icon-pdf link-icon\" href=\"#\">Die Computernavigation</a></li>\r\n</ul>\r\n</div>\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(476,'update','2015-04-13 11:50:48',13,'39','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 11:50:48.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:12:\"contentTitle\";s:24:\"Hüfte: Krankheitsbilder\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(477,'update','2015-04-13 12:48:49',34,'45','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 12:48:49.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:7:\"content\";s:2473:\"<section class=\"content-section\">\r\n<p>Unsere Praxisr&auml;umlichkeiten im Haus Elim im Salemspital, erreichen Sie &uuml;ber den Haupteingang, in Verl&auml;ngerung des Geschosses A1.&nbsp;Sie finden uns nach der Warte- und Empfangszone der orthop&auml;dischen Gemeinschaftspraxis ganz hinten, am Ende des Korridors.</p>\r\n\r\n<ul>\r\n	<li><a class=\"link-icon icon-link\" href=\"{NODE_22}\">Lageplan/Anreise</a></li>\r\n</ul>\r\n</section>\r\n\r\n<section class=\"lightbox-previews\">\r\n<figure><a class=\"lightbox-links\" data-lightbox=\"gallery-1\" data-title=\"Bild 1\" href=\"//fakeimg.pl/1000x720?text=Bild1\"><img alt=\"\" src=\"//fakeimg.pl/300?text=Bild Praxis\" /> </a>\r\n\r\n<figcaption>Bildbeschrieb</figcaption>\r\n</figure>\r\n\r\n<figure><a class=\"lightbox-links\" data-lightbox=\"gallery-1\" href=\"//fakeimg.pl/1000x500?text=Bild2\"><img alt=\"\" src=\"//fakeimg.pl/300?text=Bild Praxis\" /> </a>\r\n\r\n<figcaption>Bildbeschrieb</figcaption>\r\n</figure>\r\n\r\n<figure><a class=\"lightbox-links\" data-lightbox=\"gallery-1\" data-title=\"Bild 3\" href=\"//fakeimg.pl/1000?text=Bild3\"><img alt=\"\" src=\"//fakeimg.pl/300?text=Bild Praxis\" /> </a>\r\n\r\n<figcaption>Bildbeschrieb</figcaption>\r\n</figure>\r\n\r\n<figure><a class=\"lightbox-links\" data-lightbox=\"gallery-1\" data-title=\"Bild 4\" href=\"//fakeimg.pl/1000x1500?text=Bild4\"><img alt=\"\" src=\"//fakeimg.pl/300?text=Bild Praxis\" /> </a>\r\n\r\n<figcaption>Bildbeschrieb</figcaption>\r\n</figure>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2>Assistenz&auml;rzte bei CHRISTENORTHO AG</h2>\r\n\r\n<p>Seit dem 1. Januar 2008 werden bei CHRISTENORTHO AG Assistenz&auml;rzte ausgebildet, deren Ziel die Erlangung des Facharztes f&uuml;r Orthop&auml;die und Traumatologie des Bewegungsapparates ist.</p>\r\n\r\n<p>Vom 1. Januar 2010 bis 31. M&auml;rz 2013 fand bez&uuml;glich Weiterbildung eine enge Zusammenarbeit mit dem Bruderholzspital in Basel (Klinikleiter Prof. Dr. med. N. Friederich) statt. Am 1. Juli 2013 ist eine neue Kooperation mit der Orthop&auml;dischen Universit&auml;tsklinik des Inselspitals Bern angelaufen.</p>\r\n\r\n<p>Geeignete und interessierte Kandidaten absolvieren bis zu einem Jahr ihrer Weiterbildung bei CHRISTENORTHO AG und kehren dann ans Inselspital Bern zur&uuml;ck, um die Ausbildung zum Facharzt fort zu setzen. Die Assistenz&auml;rzte bei CHRISTENORTHO AG sind voll in den Praxisalltag integriert. Patienten werden ihnen in der Sprechstunde, auf der Abteilung oder auch im Operationssaal begegnen, gewisse Arbeiten werden an sie delegiert.</p>\r\n</section>\r\n\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(478,'update','2015-04-13 12:50:14',35,'45','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 12:50:14.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:7:\"content\";s:2473:\"<section class=\"content-section\">\r\n<p>Unsere Praxisr&auml;umlichkeiten im Haus Elim im Salemspital, erreichen Sie &uuml;ber den Haupteingang, in Verl&auml;ngerung des Geschosses A1.&nbsp;Sie finden uns nach der Warte- und Empfangszone der orthop&auml;dischen Gemeinschaftspraxis ganz hinten, am Ende des Korridors.</p>\r\n\r\n<ul>\r\n	<li><a class=\"link-icon icon-link\" href=\"{NODE_22}\">Lageplan/Anreise</a></li>\r\n</ul>\r\n</section>\r\n\r\n<section class=\"lightbox-previews\">\r\n<figure class=\"lightbox-links\"><a data-lightbox=\"gallery-1\" data-title=\"Bild 1\" href=\"//fakeimg.pl/1000x720?text=Bild1\"><img alt=\"\" src=\"//fakeimg.pl/300?text=Bild Praxis\" /> </a>\r\n\r\n<figcaption>Bildbeschrieb</figcaption>\r\n</figure>\r\n\r\n<figure class=\"lightbox-links\"><a data-lightbox=\"gallery-1\" href=\"//fakeimg.pl/1000x500?text=Bild2\"><img alt=\"\" src=\"//fakeimg.pl/300?text=Bild Praxis\" /> </a>\r\n\r\n<figcaption>Bildbeschrieb</figcaption>\r\n</figure>\r\n\r\n<figure class=\"lightbox-links\"><a data-lightbox=\"gallery-1\" data-title=\"Bild 3\" href=\"//fakeimg.pl/1000?text=Bild3\"><img alt=\"\" src=\"//fakeimg.pl/300?text=Bild Praxis\" /> </a>\r\n\r\n<figcaption>Bildbeschrieb</figcaption>\r\n</figure>\r\n\r\n<figure class=\"lightbox-links\"><a data-lightbox=\"gallery-1\" data-title=\"Bild 4\" href=\"//fakeimg.pl/1000x1500?text=Bild4\"><img alt=\"\" src=\"//fakeimg.pl/300?text=Bild Praxis\" /> </a>\r\n\r\n<figcaption>Bildbeschrieb</figcaption>\r\n</figure>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2>Assistenz&auml;rzte bei CHRISTENORTHO AG</h2>\r\n\r\n<p>Seit dem 1. Januar 2008 werden bei CHRISTENORTHO AG Assistenz&auml;rzte ausgebildet, deren Ziel die Erlangung des Facharztes f&uuml;r Orthop&auml;die und Traumatologie des Bewegungsapparates ist.</p>\r\n\r\n<p>Vom 1. Januar 2010 bis 31. M&auml;rz 2013 fand bez&uuml;glich Weiterbildung eine enge Zusammenarbeit mit dem Bruderholzspital in Basel (Klinikleiter Prof. Dr. med. N. Friederich) statt. Am 1. Juli 2013 ist eine neue Kooperation mit der Orthop&auml;dischen Universit&auml;tsklinik des Inselspitals Bern angelaufen.</p>\r\n\r\n<p>Geeignete und interessierte Kandidaten absolvieren bis zu einem Jahr ihrer Weiterbildung bei CHRISTENORTHO AG und kehren dann ans Inselspital Bern zur&uuml;ck, um die Ausbildung zum Facharzt fort zu setzen. Die Assistenz&auml;rzte bei CHRISTENORTHO AG sind voll in den Praxisalltag integriert. Patienten werden ihnen in der Sprechstunde, auf der Abteilung oder auch im Operationssaal begegnen, gewisse Arbeiten werden an sie delegiert.</p>\r\n</section>\r\n\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(479,'update','2015-04-13 12:57:42',50,'36','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 12:57:42.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:7:\"content\";s:3891:\"<section class=\"content-section-two\">\r\n<h2 id=\"kontakt\">Adresse</h2>\r\n\r\n<p><strong>CHRISTENORTHO AG</strong><br />\r\nDr. med., M.H.A. Bernhard Christen<br />\r\nOrthop&auml;dische Klinik Bern<br />\r\nSch&auml;nzlistrasse 39<br />\r\nCH-3000 Bern 25<br />\r\n<br />\r\nTelefon +41 31 337 89 24<br />\r\nTelefax +41 31 337 89 54<br />\r\n<a class=\"icon-mail link-icon\" href=\"mailto:info@christenortho.ch\">info@christenortho.ch</a></p>\r\n</section>\r\n\r\n<section class=\"content-section-two\">\r\n<h2>&Ouml;ffnungszeiten</h2>\r\n\r\n<p><strong>Montag, Dienstag, Donnerstag und Freitag</strong><br />\r\n09:00 &ndash; 12:00 und 14:00 &ndash; 16:00 Uhr&nbsp;<br />\r\n<strong>Mittwoch</strong><br />\r\n09:00 &ndash; 12:00 Uhr</p>\r\n</section>\r\n\r\n<section class=\"content-section-two\">\r\n<h2 id=\"sos\">SOS-Notfall</h2>\r\n\r\n<p><strong>Apotheken Notfalldienst</strong><br />\r\nTelefon 0900 98 99 00</p>\r\n</section>\r\n\r\n<section class=\"content-section-two\">\r\n<div class=\"heading-spacer\">&nbsp;</div>\r\n\r\n<p><strong>Notfalldienst Salemspital</strong><br />\r\nTelefon 031 335 35 35</p>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2 id=\"anfahrt\">Anfahrt</h2>\r\n\r\n<iframe src=\"https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d2723.4813925234575!2d7.453770999999998!3d46.952231!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x478e39c2a12607df%3A0xc27eb1db3037329d!2sChristen+Ortho!5e0!3m2!1sde!2sch!4v1428929767606\" width=\"750\" height=\"450\" frameborder=\"0\" style=\"border:0\"></iframe>\r\n\r\n<p>Bus Nummer 10 Richtung Ostermundigen/R&uuml;ti, Haltestelle Salem oder Tram Nummer 9 Richtung Guisanplatz, Haltestelle Viktoriaplatz.</p>\r\n\r\n<p>Unsere Praxis befindet sich im Haus Elim im Salemspital, erreichbar &uuml;ber den Haupteingang, in Verl&auml;ngerung des Geschosses A1.</p>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2 id=\"salem\">Salemspital</h2>\r\n\r\n<p><a href=\"http://www.bernerzeitung.ch/schweiz/standard/Schweizer-Aerzte-greifen-im-Zweifel-zum-Skalpell/story/12275394\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Praxis/Salem.jpg\" width=\"300\" /></a>Das 1888 erbaute Salemspital hat eine lange Tradition. Das heute zur Privatklinikgruppe Hirslanden geh&ouml;rende Spital bietet ein breites Spektrum von medizinischen Dienstleistungen an.</p>\r\n\r\n<p>Die moderne Infrastruktur und die hohe medizinische Fachkompetenz bestimmen seit Jahren das Handeln und die Philosophie des Salemspitals.</p>\r\n\r\n<p>Steter Wandel und innovatives Schaffen stehen f&uuml;r das Spitalleitbild: &bdquo;Sich mit K&ouml;nnen, Wissen und Gewissen f&uuml;r die Patienten zu engagieren und f&uuml;r Menschen da zu sein&ldquo;!</p>\r\n\r\n<p>​Eine Aussage, die sich mit der Er&ouml;ffnung der Orthop&auml;dischen Klinik Bern im November 2002 einmal mehr untermauern liess und ein Credo, welches in der Orthop&auml;dischen Klinik und speziell auch bei christenortho Tag f&uuml;r Tag neu gelebt und praktiziert wird.</p>\r\n\r\n<ul>\r\n	<li><a class=\"icon-link link-icon\" href=\"http://www.hirslanden.ch/global/de/startseite/kliniken_zentren/salem-spital.html\" target=\"_blank\">Website besuchen</a></li>\r\n</ul>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2 id=\"siloah\">Klinik Siloah</h2>\r\n\r\n<p><a href=\"http://www.bernerzeitung.ch/schweiz/standard/Schweizer-Aerzte-greifen-im-Zweifel-zum-Skalpell/story/12275394\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Praxis/Salem.jpg\" width=\"300\" /></a>Dies ist ein Typoblindtext. An ihm kann man sehen, ob alle Buchstaben da sind und wie sie aussehen. Manchmal benutzt man Worte wie Hamburgefonts, Rafgenduks oder Handgloves, um Schriften zu testen. Manchmal S&auml;tze, die alle Buchstaben des Alphabets enthalten - man nennt diese S&auml;tze &raquo;Pangrams&laquo;. Sehr bekannt ist dieser: The quick brown fox jumps over the lazy old dog.</p>\r\n\r\n<ul>\r\n	<li><a class=\"icon-link link-icon\" href=\"http://www.siloah.ch\" target=\"_blank\">Website besuchen</a></li>\r\n</ul>\r\n</section>\r\n\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(480,'update','2015-04-13 13:14:33',51,'36','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 13:14:33.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:7:\"content\";s:3941:\"<section class=\"content-section-two\">\r\n<h2 id=\"kontakt\">Adresse</h2>\r\n\r\n<p><strong>CHRISTENORTHO AG</strong><br />\r\nDr. med., M.H.A. Bernhard Christen<br />\r\nOrthop&auml;dische Klinik Bern<br />\r\nSch&auml;nzlistrasse 39<br />\r\nCH-3000 Bern 25<br />\r\n<br />\r\nTelefon +41 31 337 89 24<br />\r\nTelefax +41 31 337 89 54<br />\r\n<a class=\"icon-mail link-icon\" href=\"mailto:info@christenortho.ch\">info@christenortho.ch</a></p>\r\n</section>\r\n\r\n<section class=\"content-section-two\">\r\n<h2>&Ouml;ffnungszeiten</h2>\r\n\r\n<p><strong>Montag, Dienstag, Donnerstag und Freitag</strong><br />\r\n09:00 &ndash; 12:00 und 14:00 &ndash; 16:00 Uhr&nbsp;<br />\r\n<strong>Mittwoch</strong><br />\r\n09:00 &ndash; 12:00 Uhr</p>\r\n</section>\r\n\r\n<section class=\"content-section-two\">\r\n<h2 id=\"sos\">SOS-Notfall</h2>\r\n\r\n<p><strong>Apotheken Notfalldienst</strong><br />\r\nTelefon 0900 98 99 00</p>\r\n</section>\r\n\r\n<section class=\"content-section-two\">\r\n<div class=\"heading-spacer\">&nbsp;</div>\r\n\r\n<p><strong>Notfalldienst Salemspital</strong><br />\r\nTelefon 031 335 35 35</p>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2 id=\"anfahrt\">Anfahrt</h2>\r\n\r\n  <div class=\"embed-container-maps\">\r\n<iframe src=\"https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d2723.4813925234575!2d7.453770999999998!3d46.952231!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x478e39c2a12607df%3A0xc27eb1db3037329d!2sChristen+Ortho!5e0!3m2!1sde!2sch!4v1428929767606\" width=\"750\" height=\"450\" frameborder=\"0\" style=\"border:0\"></iframe>\r\n  </div>\r\n  \r\n<p>Bus Nummer 10 Richtung Ostermundigen/R&uuml;ti, Haltestelle Salem oder Tram Nummer 9 Richtung Guisanplatz, Haltestelle Viktoriaplatz.</p>\r\n\r\n<p>Unsere Praxis befindet sich im Haus Elim im Salemspital, erreichbar &uuml;ber den Haupteingang, in Verl&auml;ngerung des Geschosses A1.</p>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2 id=\"salem\">Salemspital</h2>\r\n\r\n<p><a href=\"http://www.bernerzeitung.ch/schweiz/standard/Schweizer-Aerzte-greifen-im-Zweifel-zum-Skalpell/story/12275394\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Praxis/Salem.jpg\" width=\"300\" /></a>Das 1888 erbaute Salemspital hat eine lange Tradition. Das heute zur Privatklinikgruppe Hirslanden geh&ouml;rende Spital bietet ein breites Spektrum von medizinischen Dienstleistungen an.</p>\r\n\r\n<p>Die moderne Infrastruktur und die hohe medizinische Fachkompetenz bestimmen seit Jahren das Handeln und die Philosophie des Salemspitals.</p>\r\n\r\n<p>Steter Wandel und innovatives Schaffen stehen f&uuml;r das Spitalleitbild: &bdquo;Sich mit K&ouml;nnen, Wissen und Gewissen f&uuml;r die Patienten zu engagieren und f&uuml;r Menschen da zu sein&ldquo;!</p>\r\n\r\n<p>​Eine Aussage, die sich mit der Er&ouml;ffnung der Orthop&auml;dischen Klinik Bern im November 2002 einmal mehr untermauern liess und ein Credo, welches in der Orthop&auml;dischen Klinik und speziell auch bei christenortho Tag f&uuml;r Tag neu gelebt und praktiziert wird.</p>\r\n\r\n<ul>\r\n	<li><a class=\"icon-link link-icon\" href=\"http://www.hirslanden.ch/global/de/startseite/kliniken_zentren/salem-spital.html\" target=\"_blank\">Website besuchen</a></li>\r\n</ul>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2 id=\"siloah\">Klinik Siloah</h2>\r\n\r\n<p><a href=\"http://www.bernerzeitung.ch/schweiz/standard/Schweizer-Aerzte-greifen-im-Zweifel-zum-Skalpell/story/12275394\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Praxis/Salem.jpg\" width=\"300\" /></a>Dies ist ein Typoblindtext. An ihm kann man sehen, ob alle Buchstaben da sind und wie sie aussehen. Manchmal benutzt man Worte wie Hamburgefonts, Rafgenduks oder Handgloves, um Schriften zu testen. Manchmal S&auml;tze, die alle Buchstaben des Alphabets enthalten - man nennt diese S&auml;tze &raquo;Pangrams&laquo;. Sehr bekannt ist dieser: The quick brown fox jumps over the lazy old dog.</p>\r\n\r\n<ul>\r\n	<li><a class=\"icon-link link-icon\" href=\"http://www.siloah.ch\" target=\"_blank\">Website besuchen</a></li>\r\n</ul>\r\n</section>\r\n\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(481,'update','2015-04-13 13:15:39',52,'36','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2015-04-13 13:15:39.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:7:\"content\";s:3957:\"<section class=\"content-section-two\">\r\n<h2 id=\"kontakt\">Adresse</h2>\r\n\r\n<p><strong>CHRISTENORTHO AG</strong><br />\r\nDr. med., M.H.A. Bernhard Christen<br />\r\nOrthop&auml;dische Klinik Bern<br />\r\nSch&auml;nzlistrasse 39<br />\r\nCH-3000 Bern 25<br />\r\n<br />\r\nTelefon +41 31 337 89 24<br />\r\nTelefax +41 31 337 89 54<br />\r\n<a class=\"icon-mail link-icon\" href=\"mailto:info@christenortho.ch\">info@christenortho.ch</a></p>\r\n</section>\r\n\r\n<section class=\"content-section-two\">\r\n<h2>&Ouml;ffnungszeiten</h2>\r\n\r\n<p><strong>Montag, Dienstag, Donnerstag und Freitag</strong><br />\r\n09:00 &ndash; 12:00 und 14:00 &ndash; 16:00 Uhr&nbsp;<br />\r\n<strong>Mittwoch</strong><br />\r\n09:00 &ndash; 12:00 Uhr</p>\r\n</section>\r\n\r\n<section class=\"content-section-two\">\r\n<h2 id=\"sos\">SOS-Notfall</h2>\r\n\r\n<p><strong>Apotheken Notfalldienst</strong><br />\r\nTelefon 0900 98 99 00</p>\r\n</section>\r\n\r\n<section class=\"content-section-two\">\r\n<div class=\"heading-spacer\">&nbsp;</div>\r\n\r\n<p><strong>Notfalldienst Salemspital</strong><br />\r\nTelefon 031 335 35 35</p>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2 id=\"anfahrt\">Anfahrt</h2>\r\n\r\n  <div class=\"embed-container embed-container-maps\">\r\n<iframe src=\"https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d2723.4813925234575!2d7.453770999999998!3d46.952231!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x478e39c2a12607df%3A0xc27eb1db3037329d!2sChristen+Ortho!5e0!3m2!1sde!2sch!4v1428929767606\" width=\"750\" height=\"450\" frameborder=\"0\" style=\"border:0\"></iframe>\r\n  </div>\r\n  \r\n<p>Bus Nummer 10 Richtung Ostermundigen/R&uuml;ti, Haltestelle Salem oder Tram Nummer 9 Richtung Guisanplatz, Haltestelle Viktoriaplatz.</p>\r\n\r\n<p>Unsere Praxis befindet sich im Haus Elim im Salemspital, erreichbar &uuml;ber den Haupteingang, in Verl&auml;ngerung des Geschosses A1.</p>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2 id=\"salem\">Salemspital</h2>\r\n\r\n<p><a href=\"http://www.bernerzeitung.ch/schweiz/standard/Schweizer-Aerzte-greifen-im-Zweifel-zum-Skalpell/story/12275394\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Praxis/Salem.jpg\" width=\"300\" /></a>Das 1888 erbaute Salemspital hat eine lange Tradition. Das heute zur Privatklinikgruppe Hirslanden geh&ouml;rende Spital bietet ein breites Spektrum von medizinischen Dienstleistungen an.</p>\r\n\r\n<p>Die moderne Infrastruktur und die hohe medizinische Fachkompetenz bestimmen seit Jahren das Handeln und die Philosophie des Salemspitals.</p>\r\n\r\n<p>Steter Wandel und innovatives Schaffen stehen f&uuml;r das Spitalleitbild: &bdquo;Sich mit K&ouml;nnen, Wissen und Gewissen f&uuml;r die Patienten zu engagieren und f&uuml;r Menschen da zu sein&ldquo;!</p>\r\n\r\n<p>​Eine Aussage, die sich mit der Er&ouml;ffnung der Orthop&auml;dischen Klinik Bern im November 2002 einmal mehr untermauern liess und ein Credo, welches in der Orthop&auml;dischen Klinik und speziell auch bei christenortho Tag f&uuml;r Tag neu gelebt und praktiziert wird.</p>\r\n\r\n<ul>\r\n	<li><a class=\"icon-link link-icon\" href=\"http://www.hirslanden.ch/global/de/startseite/kliniken_zentren/salem-spital.html\" target=\"_blank\">Website besuchen</a></li>\r\n</ul>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2 id=\"siloah\">Klinik Siloah</h2>\r\n\r\n<p><a href=\"http://www.bernerzeitung.ch/schweiz/standard/Schweizer-Aerzte-greifen-im-Zweifel-zum-Skalpell/story/12275394\" target=\"_blank\"><img alt=\"\" class=\"alignleft\" src=\"/media/archive1/Praxis/Salem.jpg\" width=\"300\" /></a>Dies ist ein Typoblindtext. An ihm kann man sehen, ob alle Buchstaben da sind und wie sie aussehen. Manchmal benutzt man Worte wie Hamburgefonts, Rafgenduks oder Handgloves, um Schriften zu testen. Manchmal S&auml;tze, die alle Buchstaben des Alphabets enthalten - man nennt diese S&auml;tze &raquo;Pangrams&laquo;. Sehr bekannt ist dieser: The quick brown fox jumps over the lazy old dog.</p>\r\n\r\n<ul>\r\n	<li><a class=\"icon-link link-icon\" href=\"http://www.siloah.ch\" target=\"_blank\">Website besuchen</a></li>\r\n</ul>\r\n</section>\r\n\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(482,'update','2015-04-21 14:57:16',14,'1','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2015-04-21 14:57:16\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:7:\"content\";s:1290:\"<p style=\"text-align: justify;\"><img alt=\"\" class=\"alignleft\" height=\"216\" src=\"/images/home/Christen.jpg\" width=\"364\" />Herzlich willkommen auf meiner Webseite! Hier erhalten Sie einen umfassenden Einblick in Diagnose und Therapie auf dem Fachgebiet der Orthop&auml;die und Traumatologie am Bewegungsapparat sowie meine eigenen Angeboten auf diesem Gebiet.<br />\r\n<br />\r\nSie finden nach den antomischen Regionen Knie, H&uuml;fte und Schulter geordnete Angaben, welche als Erg&auml;nzung oder Vorbereitung zu einem Gespr&auml;ch in der Praxis oder auch als Informationen oder Entscheidungshilfe vor einer geplanten Operation dienen k&ouml;nnen.<br />\r\n<br />\r\nSelbstverst&auml;ndlich ersetzt die Homepage nicht das pers&ouml;nliche Gespr&auml;ch und die Untersuchung, welche eine auf Sie abgestimmte spezifische L&ouml;sung zum Ziel hat. Alle gemeinsam beschlossenen Massnahmen sollen Ihre Lebensqualit&auml;t wieder verbessern, indem wenn m&ouml;glich die Schmerzen behoben, die Funktion und Belastbarkeit des gesch&auml;digten Gelenks verbessert werden; ganz getreu unserem Praxismoto: &quot;Beweglichkeit ist unser Rezept&quot;.<br />\r\n<br />\r\nIch hoffe, dass Sie die Homepage weiterbringt und freue mich &uuml;ber Fragen und Anregungen.<br />\r\nIhr Bernhard Christen<br />\r\n&nbsp;</p>\r\n\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(483,'update','2015-04-21 15:10:17',12,'41','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2015-04-21 15:10:17\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:7:\"content\";s:2739:\"<p style=\"text-align: justify;\">Als Spezialist des Bewegungsapparates (Orthop&auml;de) berate ich Sie bei Erkrankungen oder Unfallfolgen, welche in erster Linie das Knie, die H&uuml;fte sowie die Schulter betreffen. Mein eigentliches Spezialgebiet sind die degenerativen Ver&auml;nderungen (Verschleisserscheinungen), also letztlich die Behandlung der Arthrose.</p>\r\n\r\n<h2 style=\"text-align: justify;\">Vertrauen steht an erster Stelle!</h2>\r\n\r\n<p style=\"text-align: justify;\">Entscheidend im gesamten Prozess der Abkl&auml;rung, Diagnosestellung, Therapieplanung, Vor- und Nachbehandlung&nbsp;ist das Vertrauen zwischen Patient und Arzt. Ohne dieses Vertrauen wird die Behandlung nicht zum angestrebten Erfolg f&uuml;hren. F&uuml;r das Vertrauen gen&uuml;gen Fakten und Wissen nicht, verlassen Sie sich dabei auch auf Ihr Bauchgef&uuml;hl.</p>\r\n\r\n<h2 style=\"text-align: justify;\">Beweglichkeit ist unser Rezept</h2>\r\n\r\n<p style=\"text-align: justify;\">Als engagierter Orthop&auml;de f&uuml;hle ich mich verpflichtet, alles erdenklich M&ouml;gliche zu tun, um Ihnen zu helfen, Ihr Problem mit dem Bewegungsapparat zu l&ouml;sen oder zumindest zu verbessern. Ich tue dies aus Leidenschaft, mit der gebotenen Sorgfalt und Sachkenntnis und versuche mit Ihnen, eine auf Sie abgestimmte optimale L&ouml;sung zu finden.<br />\r\nBeweglichkeit zu vermitteln und gleichzeitig beweglich zu bleiben, ist das Credo meiner t&auml;glichen Arbeit!</p>\r\n\r\n<h2 style=\"text-align: justify;\">Qualit&auml;tskontrolle</h2>\r\n\r\n<p style=\"text-align: justify;\">Die st&auml;ndige &Uuml;berpr&uuml;fung der Behandlungsresultate ist unabdingbare Voraussetzung, um die Behandlungsqualit&auml;t stetig zu verbessern und Fehler sowie Komplikationen m&ouml;glichst zu minimieren. Die Nachkontrollen bei christenortho sind auch Bestandteil dieser Qualit&auml;tskontrolle. Die Daten aller Gelenkprothesen werden unter Einhaltung des Datenschutzes dem schweizerischen Prothesenregister SIRIS weiter geleitet. Bei etlichen Operationen (Knie- und H&uuml;ftprothesen) werden die Patienten vor und ein Jahr nach dem Eingriff Fragebogen zur Erfassung von Schmerzen und Einschr&auml;nkungen von Gelenkfunktionen und Lebensqualit&auml;t ausf&uuml;llen (KOOS, respektive HOOS-Fragebogen). S&auml;mtliche Komplikationen werden l&uuml;ckenlos erfasst.</p>\r\n\r\n<h2 style=\"text-align: justify;\">Ausbildung</h2>\r\n\r\n<p style=\"text-align: justify;\">Es ist mir ein Anliegen, meine Erfahrung und mein Wissen weiter zu geben. Deswegen bilde ich auch im Privatspital Assistenz&auml;rzte aus und engagiere mich an orthop&auml;dischen Weiterbildungsveranstaltungen im In- und Ausland. Seit 2013 kooperiere ich hier en mit der Orthop&auml;dischen Universit&auml;tsklinik des Inselspitals Bern.</p>\r\n\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}'),(484,'update','2015-04-21 15:10:52',13,'41','Cx\\Core\\ContentManager\\Model\\Entity\\Page','a:2:{s:9:\"updatedAt\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2015-04-21 15:10:52\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:7:\"content\";s:2478:\"<p>Als Spezialist des Bewegungsapparates (Orthop&auml;de) berate ich Sie bei Erkrankungen oder Unfallfolgen, welche in erster Linie das Knie, die H&uuml;fte sowie die Schulter betreffen. Mein eigentliches Spezialgebiet sind die degenerativen Ver&auml;nderungen (Verschleisserscheinungen), also letztlich die Behandlung der Arthrose.</p>\r\n\r\n<h2>Vertrauen steht an erster Stelle!</h2>\r\n\r\n<p>Entscheidend im gesamten Prozess der Abkl&auml;rung, Diagnosestellung, Therapieplanung, Vor- und Nachbehandlung&nbsp;ist das Vertrauen zwischen Patient und Arzt. Ohne dieses Vertrauen wird die Behandlung nicht zum angestrebten Erfolg f&uuml;hren. F&uuml;r das Vertrauen gen&uuml;gen Fakten und Wissen nicht, verlassen Sie sich dabei auch auf Ihr Bauchgef&uuml;hl.</p>\r\n\r\n<h2>Beweglichkeit ist unser Rezept</h2>\r\n\r\n<p>Als engagierter Orthop&auml;de f&uuml;hle ich mich verpflichtet, alles erdenklich M&ouml;gliche zu tun, um Ihnen zu helfen, Ihr Problem mit dem Bewegungsapparat zu l&ouml;sen oder zumindest zu verbessern. Ich tue dies aus Leidenschaft, mit der gebotenen Sorgfalt und Sachkenntnis und versuche mit Ihnen, eine auf Sie abgestimmte optimale L&ouml;sung zu finden.<br />\r\nBeweglichkeit zu vermitteln und gleichzeitig beweglich zu bleiben, ist das Credo meiner t&auml;glichen Arbeit!</p>\r\n\r\n<h2>Qualit&auml;tskontrolle</h2>\r\n\r\n<p>Die st&auml;ndige &Uuml;berpr&uuml;fung der Behandlungsresultate ist unabdingbare Voraussetzung, um die Behandlungsqualit&auml;t stetig zu verbessern und Fehler sowie Komplikationen m&ouml;glichst zu minimieren. Die Nachkontrollen bei christenortho sind auch Bestandteil dieser Qualit&auml;tskontrolle. Die Daten aller Gelenkprothesen werden unter Einhaltung des Datenschutzes dem schweizerischen Prothesenregister SIRIS weiter geleitet. Bei etlichen Operationen (Knie- und H&uuml;ftprothesen) werden die Patienten vor und ein Jahr nach dem Eingriff Fragebogen zur Erfassung von Schmerzen und Einschr&auml;nkungen von Gelenkfunktionen und Lebensqualit&auml;t ausf&uuml;llen (KOOS, respektive HOOS-Fragebogen). S&auml;mtliche Komplikationen werden l&uuml;ckenlos erfasst.</p>\r\n\r\n<h2>Ausbildung</h2>\r\n\r\n<p>Es ist mir ein Anliegen, meine Erfahrung und mein Wissen weiter zu geben. Deswegen bilde ich auch im Privatspital Assistenz&auml;rzte aus und engagiere mich an orthop&auml;dischen Weiterbildungsveranstaltungen im In- und Ausland. Seit 2013 kooperiere ich hier en mit der Orthop&auml;dischen Universit&auml;tsklinik des Inselspitals Bern.</p>\r\n\";}','{\"id\":1,\"name\":\"webmaster@werbelinie.ch\"}');
/*!40000 ALTER TABLE `contrexx_log_entry` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_block_blocks`
--

DROP TABLE IF EXISTS `contrexx_module_block_blocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_block_blocks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `start` int(10) NOT NULL DEFAULT '0',
  `end` int(10) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `random` int(1) NOT NULL DEFAULT '0',
  `random_2` int(1) NOT NULL DEFAULT '0',
  `random_3` int(1) NOT NULL DEFAULT '0',
  `random_4` int(1) NOT NULL DEFAULT '0',
  `global` int(1) NOT NULL DEFAULT '0',
  `category` int(1) NOT NULL DEFAULT '0',
  `direct` int(1) NOT NULL DEFAULT '0',
  `active` int(1) NOT NULL DEFAULT '0',
  `order` int(1) NOT NULL DEFAULT '0',
  `cat` int(10) NOT NULL DEFAULT '0',
  `wysiwyg_editor` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_block_blocks`
--

LOCK TABLES `contrexx_module_block_blocks` WRITE;
/*!40000 ALTER TABLE `contrexx_module_block_blocks` DISABLE KEYS */;
INSERT INTO `contrexx_module_block_blocks` VALUES (1,0,0,'Header Image Placeholder',0,0,0,0,0,1,0,0,0,5,1),(8,0,0,'Header Image Hüfte',0,0,0,0,0,1,0,1,7,5,1),(2,0,0,'Verena von Allmen',0,0,0,0,0,1,0,1,1,6,1),(3,0,0,'Esther Wyler Christen',0,0,0,0,0,1,0,1,2,6,1),(4,0,0,'Rebekka Malquarti',0,0,0,0,0,1,0,1,4,6,1),(5,0,0,'Andrea Wyler Wyttenbach',0,0,0,0,0,1,0,1,3,6,1),(6,0,0,'Home Karte Adresse Sidebar',0,0,0,0,0,0,0,1,5,3,1),(7,0,0,'Header Image Knie',0,0,0,0,0,1,0,1,6,5,1),(9,0,0,'Header Image Schulter',0,0,0,0,0,1,0,1,8,5,1),(10,0,0,'Header Image Über uns',0,0,0,0,0,1,0,1,9,5,1),(11,0,0,'Header Image Patienten',0,0,0,0,0,1,0,1,10,5,1),(12,0,0,'Header Image Medien',0,0,0,0,0,1,0,1,11,5,1),(13,0,0,'Header Image Kontakt',0,0,0,0,0,1,0,1,12,5,1),(14,0,0,'Milan Kravarski',0,0,0,0,0,1,0,1,130,6,1),(15,0,0,'Simon Steppacher',0,0,0,0,0,1,1,1,14,7,1),(16,0,0,'Barbara Kleer',0,0,0,0,0,1,0,1,15,7,1),(17,0,0,'Florian Schmid',0,0,0,0,0,1,0,1,16,7,1),(18,0,0,'Anne Wiebke Mertens',0,0,0,0,0,1,0,1,17,7,1),(19,0,0,'Nicolas Schmutz',0,0,0,0,0,1,0,1,18,7,1),(20,0,0,'Bertram Rieger',0,0,0,0,0,1,0,1,19,7,1),(21,0,0,'Inas Ibrahim',0,0,0,0,0,1,0,1,20,7,1),(22,0,0,'Peter Eichler',0,0,0,0,0,1,0,1,21,7,1),(23,0,0,'Michal Sarah Neukamp',0,0,0,0,0,1,0,1,22,7,1),(26,0,0,'Kontakt Navigation',0,0,0,0,0,1,1,1,23,8,1),(27,0,0,'Jeanine  Dänzer',0,0,0,0,0,1,0,1,24,6,1);
/*!40000 ALTER TABLE `contrexx_module_block_blocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_block_categories`
--

DROP TABLE IF EXISTS `contrexx_module_block_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_block_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent` int(10) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `seperator` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `order` int(10) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_block_categories`
--

LOCK TABLES `contrexx_module_block_categories` WRITE;
/*!40000 ALTER TABLE `contrexx_module_block_categories` DISABLE KEYS */;
INSERT INTO `contrexx_module_block_categories` VALUES (3,0,'Sidebar','',1,1),(2,0,'Header','',1,1),(4,0,'Footer','',1,1),(5,0,'Header Image','',1,1),(6,0,'Team','',1,1),(7,0,'Assistenzaerzte','',1,1),(8,0,'Subnavigation','',1,1);
/*!40000 ALTER TABLE `contrexx_module_block_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_block_rel_lang_content`
--

DROP TABLE IF EXISTS `contrexx_module_block_rel_lang_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_block_rel_lang_content` (
  `block_id` int(10) unsigned NOT NULL DEFAULT '0',
  `lang_id` int(10) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `active` int(1) NOT NULL DEFAULT '0',
  UNIQUE KEY `id_lang` (`block_id`,`lang_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_block_rel_lang_content`
--

LOCK TABLES `contrexx_module_block_rel_lang_content` WRITE;
/*!40000 ALTER TABLE `contrexx_module_block_rel_lang_content` DISABLE KEYS */;
INSERT INTO `contrexx_module_block_rel_lang_content` VALUES (1,1,'<img alt=\"Header Image Placeholder\" class=\"content-header-img\" src=\"//fakeimg.pl/1980x720\" />',1),(2,1,'<div class=\"staff\"><img alt=\"Verena von Allmen\" height=\"532\" src=\"/images/team/Verena-von-Allmen.jpg\" width=\"760\" />\r\n<h3 class=\"staff-name\">Verena von Allmen</h3>\r\n\r\n<p>Medizinische Praxisassistentin (MPA) und Arztsekret&auml;rin seit dem 21. Mai 2013. Verantwortlich f&uuml;r alle administrativen, organisatorischen und koordinativen Praxisbelange. Sie treffen Frau von Allmen w&auml;hrend den &Ouml;ffnungszeiten t&auml;glich in unserer Praxis an.</p>\r\n\r\n<ul>\r\n	<li><a class=\"icon-phone link-icon\" href=\"#\">+41 (0)31 337 89 24</a></li>\r\n	<li><a class=\"icon-mail link-icon\" href=\"#\">mail@christenortho.ch</a></li>\r\n</ul>\r\n</div>\r\n',1),(3,1,'<div class=\"staff\"><img alt=\"Esther Wyler Christen\" src=\"/images/team/Esther-Wyler-Christen.jpg\" />\r\n<h3 class=\"staff-name\">Esther Wyler Christen</h3>\r\n\r\n<p>Medizinische Praxisassistentin (MPA) und Arztsekret&auml;rin. Seit dem 1.11.2002 in der Praxis t&auml;tig und mit verantwortlich f&uuml;r den bisherigen Erfolg. Frau Wyler wird jetzt ihr Pensum schrittweise auf 50-60% reduzieren und vor allem f&uuml;r das Backoffice verantwortlich sein. Sie treffen sie dienstags, donnerstags und gelegentlich freitags in der Praxis an.</p>\r\n\r\n<ul>\r\n	<li><a class=\"icon-phone link-icon\" href=\"#\">+41 (0)31 337 89 24</a></li>\r\n	<li><a class=\"icon-mail link-icon\" href=\"#\">mail@christenortho.ch</a></li>\r\n</ul>\r\n</div>\r\n',1),(4,1,'<div class=\"staff\"><img alt=\"Vorname Nachname\" height=\"532\" src=\"/images/team/Rebekka-Malquarti.jpg\" width=\"760\" />\r\n<h3 class=\"staff-name\">Rebekka Malquarti</h3>\r\n\r\n<p>Rebekka Malquarti ist seit der Er&ouml;ffnung der Praxis am 01.11.2002 als selbst&auml;ndige, freie Mitarbeiterin f&uuml;r das Schreiben von Arztberichten und Gutachten zust&auml;ndig und garantiert eine speditive Information an unsere Zuweiser und Haus&auml;rzte.</p>\r\n  \r\n  <ul>\r\n	<li><a class=\"icon-phone link-icon\" href=\"#\">+41 (0)31 337 89 24</a></li>\r\n	<li><a class=\"icon-mail link-icon\" href=\"#\">mail@christenortho.ch</a></li>\r\n    <li><a class=\"icon-link link-icon\" href=\"http://www.transcription-service.ch\" target=\"_blank\">Transcription Service</a></li>\r\n</ul>\r\n</div>\r\n',1),(5,1,'<div class=\"staff\"><img alt=\"Andrea Wyler Wyttenbach\" height=\"532\" src=\"/images/team/Andrea-Wyler-Wyttenbach.jpg\" width=\"760\" />\r\n<h3 class=\"staff-name\">Andrea Wyler Wyttenbach</h3>\r\n\r\n<p>Nach knapp einem Jahr Unterbruch nimmt Andrea Wyler Wyttenbach (TOA: technische Operationsassistentin) ihre T&auml;tigkeit bei CHRISTENORTHO AG wieder in einem Teilpensum von 50% auf. Sie ist als pers&ouml;nliche Assistentin (PA) ab sofort f&uuml;r die OP-Organisation zust&auml;ndig, besetzt die Schnittstelle zwischen Praxis Operationsbetrieb und Industriepartnern. Sie hilft bei den grossen Operationen auch mit.</p>\r\n  <ul>\r\n	<li><a class=\"icon-phone link-icon\" href=\"#\">+41 (0)31 337 89 24</a></li>\r\n	<li><a class=\"icon-mail link-icon\" href=\"#\">mail@christenortho.ch</a></li>\r\n</ul>\r\n</div>\r\n',1),(6,1,'<div class=\"sidebar-map shadow\">\r\n<div class=\"image-box\"><a href=\"{NODE_22}\"><img alt=\"Standort Christen Ortho\" src=\"/images/home/Map.png\" /></a></div>\r\n</div>\r\n\r\n<address class=\"sidebar-address\">\r\n<p><br />\r\n<strong>CHRISTENORTHO AG</strong><br />\r\nDr. med., M. H. A. Bernhard Christen<br />\r\nOrthop&auml;dische Klinik Bern<br />\r\nSch&auml;nzlistrasse 39<br />\r\nCH-3000 Bern 25</p>\r\n\r\n<p>Telefon +41 31 337 89 24<br />\r\nTelefax +41 31 337 89 54<br />\r\n<a href=\"mailto:info@christenortho.ch\">info@christenortho.ch</a></p>\r\n</address>\r\n',1),(7,1,'<p><img alt=\"Header Image Placeholder\" class=\"content-header-img\" src=\"//fakeimg.pl/1980x720?text=BC erklärt Kniemodell\" /></p>\r\n',1),(8,1,'<p><img alt=\"Header Image Placeholder\" class=\"content-header-img\" src=\"//fakeimg.pl/1980x720?text=BC bei OP-Planung am Screen\" /></p>\r\n',1),(9,1,'<p><img alt=\"Header Image Placeholder\" class=\"content-header-img\" src=\"//fakeimg.pl/1980x720?text=BC bei Untersuchung von Patient\" /></p>\r\n',1),(10,1,'<p><img alt=\"Header Image Über uns\" class=\"content-header-img\" src=\"//fakeimg.pl/1980x720?text=Team am Besprechungstisch im Empfangsraum\" /></p>\r\n',1),(11,1,'<p><img alt=\"Header Image Patienten\" class=\"content-header-img\" src=\"//fakeimg.pl/1980x720?text=BC im Dialog Arzt Patient\" /></p>\r\n',1),(12,1,'<p><img alt=\"Header Image Medien\" class=\"content-header-img\" src=\"//fakeimg.pl/1980x720?text=BC bei Referat\" /></p>\r\n',1),(13,1,'<p><img alt=\"Header Image Kontakt\" class=\"content-header-img\" src=\"//fakeimg.pl/1980x720?text=BC am Telefon\" /></p>\r\n',1),(14,1,'<div class=\"staff\"><img alt=\"Vorname Nachname\" src=\"/images/content/Assistenzaerzte/Kravarski.JPG\" />\r\n<h3 class=\"staff-name\">Milan Kravarski</h3>\r\n\r\n<p>Seit dem 5. Januar 2015 arbeitet Dr. Milan Kravarski bei CHRISTENORTHO AG. Er ist bereits der dritte Assistenzarzt im Rahmen einer Rotationsstelle der Orthop&auml;dischen Universit&auml;tsklinik des Inselspitals Bern.<br />\r\nAnstellung: 01.01.2015 - 30.06.2015</p>\r\n\r\n<ul>\r\n	<li><a class=\"icon-phone link-icon\" href=\"#\">+41 (0)31 337 89 24</a></li>\r\n	<li><a class=\"icon-mail link-icon\" href=\"#\">mail@christenortho.ch</a></li>\r\n</ul>\r\n</div>\r\n',1),(15,1,'<div class=\"staff\"><img alt=\"Steppacher\" src=\"/images/content/Assistenzaerzte/Steppacher.jpg\" />\r\n<h3 class=\"staff-name\">Simon Steppacher</h3>\r\n\r\n<p>Assistenzarzt<br />\r\nAnstellung: 01.07.2014 - 31.12.2014</p>\r\n</div>\r\n',1),(16,1,'<div class=\"staff\"><img alt=\"Kleer\" src=\"/images/content/Assistenzaerzte/Kleer.jpg\" />\r\n<h3 class=\"staff-name\">Barbara Kleer</h3>\r\n\r\n<p>Assistenz&auml;rztin<br />\r\nAnstellung: 01.07.2013 - 30.06.2014</p>\r\n</div>\r\n',1),(17,1,'<div class=\"staff\"><img alt=\"Schmid\" src=\"/images/content/Assistenzaerzte/Schmid.jpg\" />\r\n<h3 class=\"staff-name\">Florian Schmid</h3>\r\n\r\n<p>Assistenzarzt<br />\r\nAnstellung: 01.04.2012 - 31.03.2013</p>\r\n</div>\r\n',1),(18,1,'<div class=\"staff\"><img alt=\"Mertens\" src=\"/images/content/Assistenzaerzte/Mertens.JPG\" />\r\n<h3 class=\"staff-name\">Anne Wiebke Mertens</h3>\r\n\r\n<p>Assistenz&auml;rztin<br />\r\nAnstellung: 15.08.2011 - 31.03.2012</p>\r\n</div>\r\n',1),(19,1,'<div class=\"staff\"><img alt=\"Schmutz\" src=\"/images/content/Assistenzaerzte/Schmutz.JPG\" />\r\n<h3 class=\"staff-name\">Nicolas Schmutz</h3>\r\n\r\n<p>Assistenzarzt<br />\r\nAnstellung: 01.01.2011 - 30.06.2011</p>\r\n</div>\r\n',1),(20,1,'<div class=\"staff\"><img alt=\"Rieger\" src=\"/images/content/Assistenzaerzte/Rieger.JPG\" />\r\n<h3 class=\"staff-name\">Bertram Rieger</h3>\r\n\r\n<p>Assistenzarzt<br />\r\nAnstellung: 01.01.2010 - 31.12.2010</p>\r\n</div>\r\n',1),(21,1,'<div class=\"staff\"><img alt=\"Ibrahim\" src=\"/images/content/Assistenzaerzte/Ibrahim.JPG\" />\r\n<h3 class=\"staff-name\">Inas Ibrahim</h3>\r\n\r\n<p>Assistenz&auml;rztin<br />\r\nAnstellung: 01.08.2009 - 31.12.2009</p>\r\n</div>\r\n',1),(22,1,'<div class=\"staff\"><img alt=\"Eichler\" src=\"/images/content/Assistenzaerzte/Eichler.JPG\" />\r\n<h3 class=\"staff-name\">Peter Eichler</h3>\r\n\r\n<p>Assistenzarzt<br />\r\nAnstellung: 01.07.2008 - 30.06.2009</p>\r\n</div>\r\n',1),(23,1,'<div class=\"staff\"><img alt=\"Neukamp\" src=\"/images/content/Assistenzaerzte/Neukamp.jpg\" />\r\n<h3 class=\"staff-name\">Michal Sarah Neukamp</h3>\r\n\r\n<p>Assistenz&auml;rztin<br />\r\nAnstellung: 01.01.2008 - 30.06.2008</p>\r\n</div>\r\n',1),(26,1,'<nav class=\"subnav\" role=\"navigation\">\r\n<ul class=\"subnav-nav\">\r\n	<li class=\"subnav-list-item\"><a class=\"subnav-link\" href=\"#kontakt\" target=\"_self\" title=\"Kontakt\">Adresse / &Ouml;ffnungszeiten</a></li>\r\n	<li class=\"subnav-list-item\"><a class=\"subnav-link\" href=\"#sos\" target=\"_self\" title=\"TV-Auftritte\">SOS-Notfall</a></li>\r\n	<li class=\"subnav-list-item\"><a class=\"subnav-link\" href=\"#anfahrt\" target=\"_self\" title=\"Studien / Artikel\">Anfahrt</a></li>\r\n	<li class=\"subnav-list-item\"><a class=\"subnav-link\" href=\"#salem\" target=\"_self\" title=\"Studien / Artikel\">Salemspital</a></li>\r\n	<li class=\"subnav-list-item\"><a class=\"subnav-link\" href=\"#siloah\" target=\"_self\" title=\"Studien / Artikel\">Klinik Siloah</a></li>\r\n</ul>\r\n</nav>\r\n',1),(27,1,'<div class=\"staff\"><img alt=\"Jeanine Dänzer\" src=\"/images/content/team/Jeanine-Daenzer.jpg\" />\r\n<h3 class=\"staff-name\">Jeanine&nbsp;&nbsp;D&auml;nzer</h3>\r\n\r\n<p>Medizinische Praxisassistentin seit dem 1. April 2015. Sie treffen Sie dienstags und donnerstags in der Praxis an. Sie ist zust&auml;ndig f&uuml;r die Sprechstunde in der SportsClinic#1 und Fragen der Qualit&auml;tssicherung bei CHRISTENORTHO AG</p>\r\n\r\n<ul>\r\n	<li><a class=\"icon-phone link-icon\" href=\"#\">+41 (0)31 337 89 24</a></li>\r\n	<li><a class=\"icon-mail link-icon\" href=\"#\">mail@christenortho.ch</a></li>\r\n</ul>\r\n</div>\r\n',1);
/*!40000 ALTER TABLE `contrexx_module_block_rel_lang_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_block_rel_pages`
--

DROP TABLE IF EXISTS `contrexx_module_block_rel_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_block_rel_pages` (
  `block_id` int(7) NOT NULL DEFAULT '0',
  `page_id` int(7) NOT NULL DEFAULT '0',
  `placeholder` enum('global','direct','category') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'global',
  PRIMARY KEY (`block_id`,`page_id`,`placeholder`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_block_rel_pages`
--

LOCK TABLES `contrexx_module_block_rel_pages` WRITE;
/*!40000 ALTER TABLE `contrexx_module_block_rel_pages` DISABLE KEYS */;
INSERT INTO `contrexx_module_block_rel_pages` VALUES (1,37,'category'),(1,38,'category'),(1,39,'category'),(1,40,'category'),(2,44,'category'),(3,44,'category'),(4,44,'category'),(5,44,'category'),(7,37,'category'),(8,39,'category'),(9,38,'category'),(10,32,'category'),(10,41,'category'),(10,42,'category'),(10,43,'category'),(11,34,'category'),(11,47,'category'),(11,48,'category'),(11,49,'category'),(11,50,'category'),(12,35,'category'),(12,51,'category'),(12,52,'category'),(12,53,'category'),(13,36,'category'),(14,44,'category'),(15,0,'direct'),(15,45,'category'),(16,45,'category'),(17,45,'category'),(18,45,'category'),(19,45,'category'),(20,45,'category'),(21,45,'category'),(22,45,'category'),(23,45,'category'),(26,0,'direct'),(26,36,'category'),(27,44,'category'),(32,12,'global'),(32,13,'global');
/*!40000 ALTER TABLE `contrexx_module_block_rel_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_block_settings`
--

DROP TABLE IF EXISTS `contrexx_module_block_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_block_settings` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `value` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_block_settings`
--

LOCK TABLES `contrexx_module_block_settings` WRITE;
/*!40000 ALTER TABLE `contrexx_module_block_settings` DISABLE KEYS */;
INSERT INTO `contrexx_module_block_settings` VALUES (1,'blockGlobalSeperator','<br /><br />');
/*!40000 ALTER TABLE `contrexx_module_block_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_blog_categories`
--

DROP TABLE IF EXISTS `contrexx_module_blog_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_blog_categories` (
  `category_id` int(4) unsigned NOT NULL DEFAULT '0',
  `lang_id` int(2) unsigned NOT NULL DEFAULT '0',
  `is_active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`category_id`,`lang_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_blog_categories`
--

LOCK TABLES `contrexx_module_blog_categories` WRITE;
/*!40000 ALTER TABLE `contrexx_module_blog_categories` DISABLE KEYS */;
INSERT INTO `contrexx_module_blog_categories` VALUES (1,1,'1','Allgemein'),(1,2,'1','General'),(1,3,'1','General'),(1,4,'1','General'),(1,5,'1','General'),(1,6,'1','General');
/*!40000 ALTER TABLE `contrexx_module_blog_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_blog_comments`
--

DROP TABLE IF EXISTS `contrexx_module_blog_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_blog_comments` (
  `comment_id` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `message_id` int(6) unsigned NOT NULL DEFAULT '0',
  `lang_id` int(2) unsigned NOT NULL DEFAULT '0',
  `is_active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `time_created` int(14) unsigned NOT NULL DEFAULT '0',
  `ip_address` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0.0.0.0',
  `user_id` int(5) unsigned NOT NULL DEFAULT '0',
  `user_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_mail` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_www` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `message_id` (`message_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_blog_comments`
--

LOCK TABLES `contrexx_module_blog_comments` WRITE;
/*!40000 ALTER TABLE `contrexx_module_blog_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_blog_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_blog_message_to_category`
--

DROP TABLE IF EXISTS `contrexx_module_blog_message_to_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_blog_message_to_category` (
  `message_id` int(6) unsigned NOT NULL DEFAULT '0',
  `category_id` int(4) unsigned NOT NULL DEFAULT '0',
  `lang_id` int(2) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`message_id`,`category_id`,`lang_id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_blog_message_to_category`
--

LOCK TABLES `contrexx_module_blog_message_to_category` WRITE;
/*!40000 ALTER TABLE `contrexx_module_blog_message_to_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_blog_message_to_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_blog_messages`
--

DROP TABLE IF EXISTS `contrexx_module_blog_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_blog_messages` (
  `message_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(5) unsigned NOT NULL DEFAULT '0',
  `time_created` int(14) unsigned NOT NULL DEFAULT '0',
  `time_edited` int(14) unsigned NOT NULL DEFAULT '0',
  `hits` int(7) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_blog_messages`
--

LOCK TABLES `contrexx_module_blog_messages` WRITE;
/*!40000 ALTER TABLE `contrexx_module_blog_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_blog_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_blog_messages_lang`
--

DROP TABLE IF EXISTS `contrexx_module_blog_messages_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_blog_messages_lang` (
  `message_id` int(6) unsigned NOT NULL,
  `lang_id` int(2) unsigned NOT NULL,
  `is_active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `subject` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `tags` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `image` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`message_id`,`lang_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_blog_messages_lang`
--

LOCK TABLES `contrexx_module_blog_messages_lang` WRITE;
/*!40000 ALTER TABLE `contrexx_module_blog_messages_lang` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_blog_messages_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_blog_networks`
--

DROP TABLE IF EXISTS `contrexx_module_blog_networks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_blog_networks` (
  `network_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `url_link` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`network_id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_blog_networks`
--

LOCK TABLES `contrexx_module_blog_networks` WRITE;
/*!40000 ALTER TABLE `contrexx_module_blog_networks` DISABLE KEYS */;
INSERT INTO `contrexx_module_blog_networks` VALUES (1,'Digg','http://www.digg.com','http://digg.com/submit?phase=2&url=[URL]&title=[SUBJECT]','images/blog/networks/digg.gif'),(2,'del.icio.ous','http://del.icio.us','http://del.icio.us/post?url=[URL]&title=[SUBJECT]','images/blog/networks/delicious.gif'),(3,'Mister Wong','http://www.mister-wong.de','http://www.mister-wong.de/index.php?action=addurl&bm_url=[URL]&bm_description=[SUBJECT]','images/blog/networks/wong.gif'),(4,'Google Bookmarks','http://www.google.com/bookmarks/','http://www.google.com/bookmarks/mark?op=edit&output=popup&bkmk=[URL]&title=[SUBJECT]','images/blog/networks/google.gif'),(5,'Furl','http://www.furl.net','http://furl.net/storeIt.jsp?t=[SUBJECT]&u=[URL]','images/blog/networks/furl.gif'),(6,'reddit','http://www.reddit.com/','http://reddit.com/submit?url=[URL]&title=[SUBJECT]','images/blog/networks/reddit.gif'),(7,'Yigg','http://www.yigg.de','http://yigg.de/neu?exturl=[URL]&exttitle=[SUBJECT]','images/blog/networks/yigg.gif'),(8,'BlinkList','http://www.blinklist.com','http://www.blinklist.com/index.php?Action=Blink/addblink.php&Description=&Url=[URL]&Title=[SUBJECT]','images/blog/networks/blinklist.gif'),(9,'Blogmarks','http://www.blogmarks.net','http://blogmarks.net/my/new.php?mini=1&simple=1&url=[URL]&title=[SUBJECT]','images/blog/networks/blogmarks.gif'),(12,'Folkd','http://www.folkd.com','http://www.folkd.com/submit/page/[URL]','images/blog/networks/folkd.gif'),(13,'Linkarena','http://www.linkarena.com','http://linkarena.com/bookmarks/addlink/?url=[URL]&title=[SUBJECT]&desc=&tags=','images/blog/networks/linkarena.gif'),(15,'Newsvine','http://www.newsvine.com','http://www.newsvine.com/_wine/save?u=[URL]&h=[SUBJECT]','images/blog/networks/newsvine.gif'),(16,'OneView','http://oneview.com','http://oneview.com/link/quickadd/?URL=[URL]&title=[SUBJECT]','images/blog/networks/oneview.gif'),(18,'Squidoo','http://www.squidoo.com','http://www.squidoo.com/lensmaster/bookmark?[URL]','images/blog/networks/squidoo.gif'),(19,'Stumble Upon','http://www.stumbleupon.com','http://www.stumbleupon.com/refer.php?url=[URL]&title=[SUBJECT]','images/blog/networks/stumbleupon.gif'),(20,'Technorati','http://www.technorati.com','http://www.technorati.com/faves?add=[URL]','images/blog/networks/technorati.gif'),(21,'Webnews','http://www.webnews.de','http://www.webnews.de/einstellen?url=[URL]&title=[SUBJECT]','images/blog/networks/webnews.gif'),(22,'Yahoo My Web','http://myweb2.search.yahoo.com','http://myweb2.search.yahoo.com/myresults/bookmarklet?u=[URL]&t=[SUBJECT]','images/blog/networks/yahoo.gif'),(23,'Facebook','http://facebook.com','https://www.facebook.com/sharer/sharer.php?u=[URL]','images/blog/networks/facebook.gif'),(24,'Google +','http://plus.google.com','https://plus.google.com/share?url=[URL]','images/blog/networks/google_plus.gif'),(25,'Twitter','http://twitter.com','http://twitter.com/intent/tweet?source=sharethiscom&text=[SUBJECT]&url=[URL]','images/blog/networks/twitter.gif');
/*!40000 ALTER TABLE `contrexx_module_blog_networks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_blog_networks_lang`
--

DROP TABLE IF EXISTS `contrexx_module_blog_networks_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_blog_networks_lang` (
  `network_id` int(8) unsigned NOT NULL DEFAULT '0',
  `lang_id` int(2) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`network_id`,`lang_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_blog_networks_lang`
--

LOCK TABLES `contrexx_module_blog_networks_lang` WRITE;
/*!40000 ALTER TABLE `contrexx_module_blog_networks_lang` DISABLE KEYS */;
INSERT INTO `contrexx_module_blog_networks_lang` VALUES (1,1),(1,2),(1,3),(2,1),(2,2),(2,3),(3,1),(3,2),(3,3),(4,1),(4,2),(4,3),(5,1),(5,2),(5,3),(6,1),(6,2),(6,3),(7,1),(7,2),(7,3),(8,1),(8,2),(8,3),(9,1),(9,2),(9,3),(12,1),(12,2),(12,3),(13,1),(13,2),(13,3),(15,1),(15,2),(15,3),(16,1),(16,2),(18,1),(18,2),(18,3),(19,1),(19,2),(19,3),(20,1),(20,2),(20,3),(21,1),(21,2),(21,3),(22,1),(22,2),(22,3),(23,1),(23,2),(24,1),(24,2),(25,1),(25,2);
/*!40000 ALTER TABLE `contrexx_module_blog_networks_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_blog_settings`
--

DROP TABLE IF EXISTS `contrexx_module_blog_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_blog_settings` (
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_blog_settings`
--

LOCK TABLES `contrexx_module_blog_settings` WRITE;
/*!40000 ALTER TABLE `contrexx_module_blog_settings` DISABLE KEYS */;
INSERT INTO `contrexx_module_blog_settings` VALUES ('blog_block_activated','1'),('blog_block_messages','5'),('blog_comments_activated','1'),('blog_comments_anonymous','1'),('blog_comments_autoactivate','1'),('blog_comments_editor','textarea'),('blog_comments_notification','1'),('blog_comments_timeout','30'),('blog_general_introduction','400'),('blog_rss_activated','1'),('blog_rss_comments','20'),('blog_rss_messages','5'),('blog_tags_hitlist','5'),('blog_voting_activated','1');
/*!40000 ALTER TABLE `contrexx_module_blog_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_blog_votes`
--

DROP TABLE IF EXISTS `contrexx_module_blog_votes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_blog_votes` (
  `vote_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `message_id` int(6) unsigned NOT NULL DEFAULT '0',
  `time_voted` int(14) unsigned NOT NULL DEFAULT '0',
  `ip_address` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0.0.0.0',
  `vote` enum('1','2','3','4','5','6','7','8','9','10') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`vote_id`),
  KEY `message_id` (`message_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_blog_votes`
--

LOCK TABLES `contrexx_module_blog_votes` WRITE;
/*!40000 ALTER TABLE `contrexx_module_blog_votes` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_blog_votes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_calendar_category`
--

DROP TABLE IF EXISTS `contrexx_module_calendar_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_calendar_category` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `pos` int(5) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_calendar_category`
--

LOCK TABLES `contrexx_module_calendar_category` WRITE;
/*!40000 ALTER TABLE `contrexx_module_calendar_category` DISABLE KEYS */;
INSERT INTO `contrexx_module_calendar_category` VALUES (46,NULL,1),(49,1,1);
/*!40000 ALTER TABLE `contrexx_module_calendar_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_calendar_category_name`
--

DROP TABLE IF EXISTS `contrexx_module_calendar_category_name`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_calendar_category_name` (
  `cat_id` int(11) NOT NULL,
  `lang_id` int(11) DEFAULT NULL,
  `name` varchar(225) COLLATE utf8_unicode_ci DEFAULT NULL,
  KEY `fk_contrexx_module_calendar_category_names_contrexx_module_ca1` (`cat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_calendar_category_name`
--

LOCK TABLES `contrexx_module_calendar_category_name` WRITE;
/*!40000 ALTER TABLE `contrexx_module_calendar_category_name` DISABLE KEYS */;
INSERT INTO `contrexx_module_calendar_category_name` VALUES (46,1,'Veranstaltungen'),(46,2,'Events'),(49,1,'Weitere'),(49,2,'Others');
/*!40000 ALTER TABLE `contrexx_module_calendar_category_name` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_calendar_event`
--

DROP TABLE IF EXISTS `contrexx_module_calendar_event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_calendar_event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL DEFAULT '0',
  `startdate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `enddate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `use_custom_date_display` tinyint(1) NOT NULL,
  `showStartDateList` int(1) NOT NULL,
  `showEndDateList` int(1) NOT NULL,
  `showStartTimeList` int(1) NOT NULL,
  `showEndTimeList` int(1) NOT NULL,
  `showTimeTypeList` int(1) NOT NULL,
  `showStartDateDetail` int(1) NOT NULL,
  `showEndDateDetail` int(1) NOT NULL,
  `showStartTimeDetail` int(1) NOT NULL,
  `showEndTimeDetail` int(1) NOT NULL,
  `showTimeTypeDetail` int(1) NOT NULL,
  `google` int(11) NOT NULL,
  `access` int(1) NOT NULL DEFAULT '0',
  `priority` int(1) NOT NULL DEFAULT '3',
  `price` int(11) NOT NULL DEFAULT '0',
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pic` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `attach` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `place_mediadir_id` int(11) NOT NULL,
  `catid` int(11) NOT NULL DEFAULT '0',
  `show_in` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `invited_groups` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `invited_mails` mediumtext COLLATE utf8_unicode_ci,
  `invitation_sent` int(1) NOT NULL,
  `invitation_email_template` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `registration` int(1) NOT NULL DEFAULT '0',
  `registration_form` int(11) NOT NULL,
  `registration_num` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `registration_notification` varchar(1024) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_template` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ticket_sales` tinyint(1) NOT NULL DEFAULT '0',
  `num_seating` text COLLATE utf8_unicode_ci NOT NULL,
  `series_status` tinyint(4) NOT NULL DEFAULT '0',
  `series_type` int(11) NOT NULL DEFAULT '0',
  `series_pattern_count` int(11) NOT NULL DEFAULT '0',
  `series_pattern_weekday` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `series_pattern_day` int(11) NOT NULL DEFAULT '0',
  `series_pattern_week` int(11) NOT NULL DEFAULT '0',
  `series_pattern_month` int(11) NOT NULL DEFAULT '0',
  `series_pattern_type` int(11) NOT NULL DEFAULT '0',
  `series_pattern_dourance_type` int(11) NOT NULL DEFAULT '0',
  `series_pattern_end` int(11) NOT NULL DEFAULT '0',
  `series_pattern_end_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `series_pattern_begin` int(11) NOT NULL DEFAULT '0',
  `series_pattern_exceptions` longtext COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `confirmed` tinyint(1) NOT NULL DEFAULT '1',
  `author` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `all_day` tinyint(1) NOT NULL DEFAULT '0',
  `location_type` tinyint(1) NOT NULL DEFAULT '1',
  `place` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `place_id` int(11) NOT NULL,
  `place_street` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `place_zip` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `place_city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `place_country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `place_link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `place_map` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `host_type` tinyint(1) NOT NULL DEFAULT '1',
  `org_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `org_street` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `org_zip` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `org_city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `org_country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `org_link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `org_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `host_mediadir_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_contrexx_module_calendar_notes_contrexx_module_calendar_ca1` (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_calendar_event`
--

LOCK TABLES `contrexx_module_calendar_event` WRITE;
/*!40000 ALTER TABLE `contrexx_module_calendar_event` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_calendar_event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_calendar_event_field`
--

DROP TABLE IF EXISTS `contrexx_module_calendar_event_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_calendar_event_field` (
  `event_id` int(11) NOT NULL DEFAULT '0',
  `lang_id` varchar(225) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci,
  `redirect` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  KEY `lang_field` (`title`),
  KEY `fk_contrexx_module_calendar_note_field_contrexx_module_calend1` (`event_id`),
  FULLTEXT KEY `eventIndex` (`title`,`description`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_calendar_event_field`
--

LOCK TABLES `contrexx_module_calendar_event_field` WRITE;
/*!40000 ALTER TABLE `contrexx_module_calendar_event_field` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_calendar_event_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_calendar_host`
--

DROP TABLE IF EXISTS `contrexx_module_calendar_host`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_calendar_host` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `uri` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `cat_id` int(11) NOT NULL,
  `key` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `confirmed` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_contrexx_module_calendar_shared_hosts_contrexx_module_cale1` (`cat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_calendar_host`
--

LOCK TABLES `contrexx_module_calendar_host` WRITE;
/*!40000 ALTER TABLE `contrexx_module_calendar_host` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_calendar_host` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_calendar_mail`
--

DROP TABLE IF EXISTS `contrexx_module_calendar_mail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_calendar_mail` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content_text` longtext COLLATE utf8_unicode_ci NOT NULL,
  `content_html` longtext COLLATE utf8_unicode_ci NOT NULL,
  `recipients` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `lang_id` int(1) NOT NULL,
  `action_id` int(1) NOT NULL,
  `is_default` int(1) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_calendar_mail`
--

LOCK TABLES `contrexx_module_calendar_mail` WRITE;
/*!40000 ALTER TABLE `contrexx_module_calendar_mail` DISABLE KEYS */;
INSERT INTO `contrexx_module_calendar_mail` VALUES (1,'[[URL]] - Einladung zu [[TITLE]]','Hallo [[FIRSTNAME]] [[LASTNAME]] \r\n\r\nSie wurden auf [[URL]] zum Event \\\"[[TITLE]]\\\" eingeladen.\r\nDetails: [[LINK_EVENT]]\r\n\r\nFolgen Sie dem unten stehenden Link um sich f&uuml;r diesen Event an- oder abzumelden.\r\nHinweis: Sollte der Link nicht funktionieren, kopieren Sie die komplette Adresse ohne Zeilenumbr&uuml;che in die Adresszeile Ihres Browsers und dr&uuml;cken Sie anschliessend \\\"Enter\\\".\r\n\r\n[[LINK_REGISTRATION]]\r\n\r\n\r\n--\r\nDiese Nachricht wurde automatisch generiert\r\n[[DATE]]','Hallo [[FIRSTNAME]] [[LASTNAME]]<br />\r\n<br />\r\nSie wurden auf <a href=\"http://[[URL]]\" title=\"[[URL]]\">[[URL]]</a> zum Event <a href=\"[[LINK_EVENT]]\" title=\"Event Details\">&quot;[[TITLE]]&quot;</a> eingeladen. <br />\r\nKlicken Sie <a href=\"[[LINK_REGISTRATION]]\" title=\"Anmeldung\">hier</a>, um sich an diesem Event an- oder abzumelden.<br />\r\n<br />\r\n<br />\r\n--<br />\r\n<em>Diese Nachricht wurde automatisch generiert</em><br />\r\n<em>[[DATE]]</em>','',1,1,1,1),(15,'[[URL]] - Neue [[REGISTRATION_TYPE]] f&uuml;r [[TITLE]]','Hallo\r\n\r\nAuf [[URL]] wurde eine neue [[REGISTRATION_TYPE]] f&uuml;r den Termin \\\"[[TITLE]]\\\" eingetragen.\r\n\r\nInformationen zur [[REGISTRATION_TYPE]]\r\n[[REGISTRATION_DATA]]\r\n\r\n-- \r\nDiese Nachricht wurde automatisch generiert [[DATE]]','Hallo<br />\r\n<br />\r\nAuf [[URL]] wurde eine neue [[REGISTRATION_TYPE]] f&uuml;r den Termin &quot;[[TITLE]]&quot; eingetragen.<br />\r\n<br />\r\n<h2>Informationen zur [[REGISTRATION_TYPE]]</h2>\r\n[[REGISTRATION_DATA]] <br />\r\n<br />\r\n-- <br />\r\nDiese Nachricht wurde automatisch generiert [[DATE]]','',1,3,1,1),(14,'[[URL]] - Erfolgreiche [[REGISTRATION_TYPE]]','Hallo [[FIRSTNAME]] [[LASTNAME]]\r\n\r\nIhre [[REGISTRATION_TYPE]] zum Event \\\"[[TITLE]]\\\" vom [[START_DATE]] wurde erfolgreich in unserem System eingetragen.\r\n\r\n\r\n--\r\nDiese Nachricht wurde automatisch generiert\r\n[[DATE]]','Hallo [[FIRSTNAME]] [[LASTNAME]]<br />\r\n<br />\r\nIhre [[REGISTRATION_TYPE]] zum Event <a title=\"[[TITLE]]\" href=\"[[LINK_EVENT]]\">[[TITLE]]</a> vom [[START_DATE]] wurde erfolgreich in unserem System eingetragen.<br />\r\n<br />\r\n--<br />\r\n<em>Diese Nachricht wurde automatisch generiert<br />\r\n[[DATE]]</em>','',1,2,1,1),(16,'[[URL]] - Neuer Termin: [[TITLE]]','Hallo [[FIRSTNAME]] [[LASTNAME]] \r\n\r\nUnter [[URL]] finden Sie den neuen Event \\\"[[TITLE]]\\\".\r\nDetails: [[LINK_EVENT]]\r\n\r\n\r\n--\r\nDiese Nachricht wurde automatisch generiert\r\n[[DATE]]','Hallo [[FIRSTNAME]] [[LASTNAME]]<br />\r\n<br />\r\nUnter <a title=\"[[URL]]\" href=\"http://[[URL]]\">[[URL]]</a> finden Sie den neuen Event <a title=\"Event Details\" href=\"[[LINK_EVENT]]\">&quot;[[TITLE]]&quot;</a>. <br />\r\n<br />\r\n<br />\r\n--<br />\r\n<em>Diese Nachricht wurde automatisch generiert</em><br />\r\n<em>[[DATE]]</em>','',1,4,1,1);
/*!40000 ALTER TABLE `contrexx_module_calendar_mail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_calendar_mail_action`
--

DROP TABLE IF EXISTS `contrexx_module_calendar_mail_action`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_calendar_mail_action` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `default_recipient` enum('empty','admin','author') COLLATE utf8_unicode_ci NOT NULL,
  `need_auth` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_calendar_mail_action`
--

LOCK TABLES `contrexx_module_calendar_mail_action` WRITE;
/*!40000 ALTER TABLE `contrexx_module_calendar_mail_action` DISABLE KEYS */;
INSERT INTO `contrexx_module_calendar_mail_action` VALUES (1,'invitationTemplate','empty',0),(2,'confirmationRegistration','author',0),(3,'notificationRegistration','empty',0),(4,'notificationNewEntryFE','admin',0);
/*!40000 ALTER TABLE `contrexx_module_calendar_mail_action` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_calendar_registration`
--

DROP TABLE IF EXISTS `contrexx_module_calendar_registration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_calendar_registration` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `event_id` int(7) NOT NULL,
  `date` int(15) NOT NULL,
  `host_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(1) NOT NULL,
  `key` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(7) NOT NULL,
  `lang_id` int(11) NOT NULL,
  `export` int(11) NOT NULL,
  `payment_method` int(11) NOT NULL,
  `paid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_calendar_registration`
--

LOCK TABLES `contrexx_module_calendar_registration` WRITE;
/*!40000 ALTER TABLE `contrexx_module_calendar_registration` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_calendar_registration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_calendar_registration_form`
--

DROP TABLE IF EXISTS `contrexx_module_calendar_registration_form`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_calendar_registration_form` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_calendar_registration_form`
--

LOCK TABLES `contrexx_module_calendar_registration_form` WRITE;
/*!40000 ALTER TABLE `contrexx_module_calendar_registration_form` DISABLE KEYS */;
INSERT INTO `contrexx_module_calendar_registration_form` VALUES (1,1,99,'Standardformular');
/*!40000 ALTER TABLE `contrexx_module_calendar_registration_form` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_calendar_registration_form_field`
--

DROP TABLE IF EXISTS `contrexx_module_calendar_registration_form_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_calendar_registration_form_field` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `form` int(11) NOT NULL,
  `type` enum('inputtext','textarea','select','radio','checkbox','mail','seating','agb','salutation','firstname','lastname','selectBillingAddress','fieldset') COLLATE utf8_unicode_ci NOT NULL,
  `required` int(1) NOT NULL,
  `order` int(3) NOT NULL,
  `affiliation` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_calendar_registration_form_field`
--

LOCK TABLES `contrexx_module_calendar_registration_form_field` WRITE;
/*!40000 ALTER TABLE `contrexx_module_calendar_registration_form_field` DISABLE KEYS */;
INSERT INTO `contrexx_module_calendar_registration_form_field` VALUES (4,1,'lastname',1,3,'form'),(3,1,'firstname',1,2,'form'),(2,1,'inputtext',0,1,'form'),(1,1,'salutation',1,0,'form'),(5,1,'mail',1,4,'form'),(6,1,'textarea',0,5,'form');
/*!40000 ALTER TABLE `contrexx_module_calendar_registration_form_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_calendar_registration_form_field_name`
--

DROP TABLE IF EXISTS `contrexx_module_calendar_registration_form_field_name`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_calendar_registration_form_field_name` (
  `field_id` int(7) NOT NULL,
  `form_id` int(11) NOT NULL,
  `lang_id` int(1) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `default` mediumtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_calendar_registration_form_field_name`
--

LOCK TABLES `contrexx_module_calendar_registration_form_field_name` WRITE;
/*!40000 ALTER TABLE `contrexx_module_calendar_registration_form_field_name` DISABLE KEYS */;
INSERT INTO `contrexx_module_calendar_registration_form_field_name` VALUES (6,1,2,'Message',''),(6,1,1,'Bemerkung',''),(5,1,2,'E-Mail',''),(5,1,1,'E-Mail',''),(4,1,2,'Lastname',''),(4,1,1,'Nachname',''),(3,1,2,'Firstname',''),(3,1,1,'Vorname',''),(2,1,2,'Company',''),(2,1,1,'Firma',''),(1,1,2,'Salutation','Dear Ms.,Dear Mr.'),(1,1,1,'Anrede','Sehr geehrte Frau,Sehr geehrter Herr');
/*!40000 ALTER TABLE `contrexx_module_calendar_registration_form_field_name` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_calendar_registration_form_field_value`
--

DROP TABLE IF EXISTS `contrexx_module_calendar_registration_form_field_value`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_calendar_registration_form_field_value` (
  `reg_id` int(7) NOT NULL,
  `field_id` int(7) NOT NULL,
  `value` mediumtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_calendar_registration_form_field_value`
--

LOCK TABLES `contrexx_module_calendar_registration_form_field_value` WRITE;
/*!40000 ALTER TABLE `contrexx_module_calendar_registration_form_field_value` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_calendar_registration_form_field_value` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_calendar_rel_event_host`
--

DROP TABLE IF EXISTS `contrexx_module_calendar_rel_event_host`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_calendar_rel_event_host` (
  `host_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_calendar_rel_event_host`
--

LOCK TABLES `contrexx_module_calendar_rel_event_host` WRITE;
/*!40000 ALTER TABLE `contrexx_module_calendar_rel_event_host` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_calendar_rel_event_host` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_calendar_settings`
--

DROP TABLE IF EXISTS `contrexx_module_calendar_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_calendar_settings` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `section_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `info` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `options` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `special` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=65 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_calendar_settings`
--

LOCK TABLES `contrexx_module_calendar_settings` WRITE;
/*!40000 ALTER TABLE `contrexx_module_calendar_settings` DISABLE KEYS */;
INSERT INTO `contrexx_module_calendar_settings` VALUES (8,5,'numPaging','TXT_CALENDAR_NUM_PAGING','15','',1,'','',1),(9,5,'numEntrance','TXT_CALENDAR_NUM_EVENTS_ENTRANCE','5','',1,'','',2),(10,6,'headlinesStatus','TXT_CALENDAR_HEADLINES_STATUS','1','',3,'TXT_CALENDAR_ACTIVATE,TXT_CALENDAR_DEACTIVATE','',1),(11,6,'headlinesCategory','TXT_CALENDAR_HEADLINES_CATEGORY','','',5,'','getCategoryDorpdown',3),(12,6,'headlinesNum','TXT_CALENDAR_HEADLINES_NUM','3','',1,'','',2),(14,7,'publicationStatus','TXT_CALENDAR_PUBLICATION_STATUS','2','TXT_CALENDAR_PUBLICATION_STATUS_INFO',3,'TXT_CALENDAR_ACTIVATE,TXT_CALENDAR_DEACTIVATE','',0),(15,15,'dateFormat','TXT_CALENDAR_DATE_FORMAT','0','TXT_CALENDAR_DATE_FORMAT_INFO',5,'TXT_CALENDAR_DATE_FORMAT_DD.MM.YYYY,TXT_CALENDAR_DATE_FORMAT_DD/MM/YYYY,TXT_CALENDAR_DATE_FORMAT_YYYY.MM.DD,TXT_CALENDAR_DATE_FORMAT_MM/DD/YYYY,TXT_CALENDAR_DATE_FORMAT_YYYY-MM-DD','',3),(16,8,'countCategoryEntries','TXT_CALENDAR_CATEGORY_COUNT_ENTRIES','2','',3,'TXT_CALENDAR_ACTIVATE,TXT_CALENDAR_DEACTIVATE','',0),(18,18,'addEventsFrontend','TXT_CALENDAR_ADD_EVENTS_FRONTEND','0','',5,'TXT_CALENDAR_DEACTIVATE,TXT_CALENDAR_ACTIVATE_ALL,TXT_CALENDAR_ACTIVATE_ONLY_COMMUNITY','',5),(19,18,'confirmFrontendEvents','TXT_CALENDAR_CONFIRM_FRONTEND_EVENTS','2','',3,'TXT_CALENDAR_ACTIVATE,TXT_CALENDAR_DEACTIVATE','',6),(22,10,'paymentStatus','TXT_CALENDAR_PAYMENT_STATUS','2','',3,'TXT_CALENDAR_ACTIVATE,TXT_CALENDAR_DEACTIVATE','',1),(23,10,'paymentCurrency','TXT_CALENDAR_PAYMENT_CURRENCY','CHF','',1,'','',2),(24,10,'paymentVatRate','TXT_CALENDAR_PAYMENT_VAT_RATE','8','',1,'','',3),(25,11,'paymentBillStatus','TXT_CALENDAR_PAYMENT_BILL_STATUS','2','',3,'TXT_CALENDAR_ACTIVATE,TXT_CALENDAR_DEACTIVATE','',1),(26,11,'paymentlBillGrace','TXT_CALENDAR_PAYMENT_BILL_GRACE','30','',1,'','',2),(27,12,'paymentYellowpayStatus','TXT_CALENDAR_PAYMENT_YELLOWPAY_STATUS','2','',3,'TXT_CALENDAR_ACTIVATE,TXT_CALENDAR_DEACTIVATE','',1),(28,12,'paymentYellowpayPspid','TXT_CALENDAR_PAYMENT_YELLOWPAY_PSPID','','',1,'','',2),(29,12,'paymentYellowpayShaIn','TXT_CALENDAR_PAYMENT_YELLOWPAY_SHA_IN','','',1,'','',3),(30,12,'paymentYellowpayShaOut','TXT_CALENDAR_PAYMENT_YELLOWPAY_SHA_OUT','','',1,'','',4),(31,12,'paymentYellowpayAuthorization','TXT_CALENDAR_PAYMENT_YELLOWPAY_AUTHORIZATION','0','',5,'TXT_CALENDAR_PAYMENT_YELLOWPAY_AUTHORIZATION_SALE,TXT_CALENDAR_PAYMENT_YELLOWPAY_AUTHORIZATION','',5),(32,12,'paymentTestserver','TXT_CALENDAR_PAYMENT_YELLOWPAY_TESTSERVER','2','',3,'TXT_CALENDAR_YES,TXT_CALENDAR_NO','',7),(33,12,'paymentYellowpayMethods','TXT_CALENDAR_PAYMENT_YELLOWPAY_METHODS','0','',4,'TXT_CALENDAR_PAYMENT_YELLOWPAY_POSTFINANCE,TXT_CALENDAR_PAYMENT_YELLOWPAY_POSTFINANCE_EFINANCE,TXT_CALENDAR_PAYMENT_YELLOWPAY_MASTERCARD,TXT_CALENDAR_PAYMENT_YELLOWPAY_VISA,TXT_CALENDAR_PAYMENT_YELLOWPAY_AMEX,TXT_CALENDAR_PAYMENT_YELLOWPAY_DINERS','',6),(34,10,'paymentVatNumber','TXT_CALENDAR_PAYMENT_VAT_NUMBER','','',1,'','',4),(35,13,'paymentBank','TXT_CALENDAR_PAYMENT_BANK','','',1,'','',1),(36,13,'paymentBankAccount','TXT_CALENDAR_PAYMENT_BANK_ACCOUNT','','',1,'','',2),(37,13,'paymentBankIBAN','TXT_CALENDAR_PAYMENT_BANK_IBAN','','',1,'','',3),(38,13,'paymentBankCN','TXT_CALENDAR_PAYMENT_BANK_CN','','',1,'','',4),(39,13,'paymentBankSC','TXT_CALENDAR_PAYMENT_BANK_SC','','',1,'','',5),(40,17,'separatorDateDetail','TXT_CALENDAR_SEPARATOR_DATE','1','TXT_CALENDAR_SEPARATOR_DATE_INFO',5,'TXT_CALENDAR_SEPARATOR_SPACE,TXT_CALENDAR_SEPARATOR_HYPHEN,TXT_CALENDAR_SEPARATOR_COLON,TXT_CALENDAR_SEPARATOR_TO','',1),(41,17,'separatorTimeDetail','TXT_CALENDAR_SEPARATOR_TIME','3','TXT_CALENDAR_SEPARATOR_TIME_INFO',5,'TXT_CALENDAR_SEPARATOR_SPACE,TXT_CALENDAR_SEPARATOR_HYPHEN,TXT_CALENDAR_SEPARATOR_COLON,TXT_CALENDAR_SEPARATOR_TO','',2),(42,17,'separatorDateTimeDetail','TXT_CALENDAR_SEPARATOR_DATE_TIME','3','TXT_CALENDAR_SEPARATOR_DATE_TIME_INFO',5,'TXT_CALENDAR_SEPARATOR_NOTHING,TXT_CALENDAR_SEPARATOR_SPACE,TXT_CALENDAR_SEPARATOR_BREAK,TXT_CALENDAR_SEPARATOR_HYPHEN,TXT_CALENDAR_SEPARATOR_COLON','',3),(43,17,'separatorSeveralDaysDetail','TXT_CALENDAR_SEPARATOR_SEVERAL_DAYS','2','TXT_CALENDAR_SEPARATOR_SEVERAL_DAYS_INFO',5,'TXT_CALENDAR_SEPARATOR_SPACE,TXT_CALENDAR_SEPARATOR_HYPHEN,TXT_CALENDAR_SEPARATOR_TO,TXT_CALENDAR_SEPARATOR_BREAK','',4),(44,17,'showClockDetail','TXT_CALENDAR_SHOW_CLOCK','1','TXT_CALENDAR_SEPARATOR_SHOW_CLOCK_INFO',3,'TXT_CALENDAR_ACTIVATE,TXT_CALENDAR_DEACTIVATE','',5),(45,17,'showStartDateDetail','TXT_CALENDAR_SHOW_START_DATE','1','TXT_CALENDAR_SHOW_START_DATE_INFO',3,'TXT_CALENDAR_ACTIVATE,TXT_CALENDAR_DEACTIVATE','',6),(46,17,'showEndDateDetail','TXT_CALENDAR_SHOW_END_DATE','1','TXT_CALENDAR_SHOW_END_DATE_INFO',3,'TXT_CALENDAR_ACTIVATE,TXT_CALENDAR_DEACTIVATE','',7),(47,17,'showStartTimeDetail','TXT_CALENDAR_SHOW_START_TIME','1','TXT_CALENDAR_SHOW_START_TIME_INFO',3,'TXT_CALENDAR_ACTIVATE,TXT_CALENDAR_DEACTIVATE','',8),(48,17,'showEndTimeDetail','TXT_CALENDAR_SHOW_END_TIME','1','TXT_CALENDAR_SHOW_END_TIME_INFO',3,'TXT_CALENDAR_ACTIVATE,TXT_CALENDAR_DEACTIVATE','',9),(49,16,'separatorDateList','TXT_CALENDAR_SEPARATOR_DATE','1','TXT_CALENDAR_SEPARATOR_DATE_INFO',5,'TXT_CALENDAR_SEPARATOR_SPACE,TXT_CALENDAR_SEPARATOR_HYPHEN,TXT_CALENDAR_SEPARATOR_COLON,TXT_CALENDAR_SEPARATOR_TO','',1),(50,16,'separatorTimeList','TXT_CALENDAR_SEPARATOR_TIME','1','TXT_CALENDAR_SEPARATOR_TIME_INFO',5,'TXT_CALENDAR_SEPARATOR_SPACE,TXT_CALENDAR_SEPARATOR_HYPHEN,TXT_CALENDAR_SEPARATOR_COLON,TXT_CALENDAR_SEPARATOR_TO','',2),(51,16,'separatorDateTimeList','TXT_CALENDAR_SEPARATOR_DATE_TIME','1','TXT_CALENDAR_SEPARATOR_DATE_TIME_INFO',5,'TXT_CALENDAR_SEPARATOR_NOTHING,TXT_CALENDAR_SEPARATOR_SPACE,TXT_CALENDAR_SEPARATOR_BREAK,TXT_CALENDAR_SEPARATOR_HYPHEN,TXT_CALENDAR_SEPARATOR_COLON','',3),(52,16,'separatorSeveralDaysList','TXT_CALENDAR_SEPARATOR_SEVERAL_DAYS','2','TXT_CALENDAR_SEPARATOR_SEVERAL_DAYS_INFO',5,'TXT_CALENDAR_SEPARATOR_SPACE,TXT_CALENDAR_SEPARATOR_HYPHEN,TXT_CALENDAR_SEPARATOR_TO,TXT_CALENDAR_SEPARATOR_BREAK','',4),(53,16,'showClockList','TXT_CALENDAR_SHOW_CLOCK','1','TXT_CALENDAR_SEPARATOR_SHOW_CLOCK_INFO',3,'TXT_CALENDAR_ACTIVATE,TXT_CALENDAR_DEACTIVATE','',5),(54,16,'showStartDateList','TXT_CALENDAR_SHOW_START_DATE','1','TXT_CALENDAR_SHOW_START_DATE_INFO',3,'TXT_CALENDAR_ACTIVATE,TXT_CALENDAR_DEACTIVATE','',6),(55,16,'showEndDateList','TXT_CALENDAR_SHOW_END_DATE','2','TXT_CALENDAR_SHOW_END_DATE_INFO',3,'TXT_CALENDAR_ACTIVATE,TXT_CALENDAR_DEACTIVATE','',7),(56,16,'showStartTimeList','TXT_CALENDAR_SHOW_START_TIME','2','TXT_CALENDAR_SHOW_START_TIME_INFO',3,'TXT_CALENDAR_ACTIVATE,TXT_CALENDAR_DEACTIVATE','',8),(57,16,'showEndTimeList','TXT_CALENDAR_SHOW_END_TIME','2','TXT_CALENDAR_SHOW_END_TIME_INFO',3,'TXT_CALENDAR_ACTIVATE,TXT_CALENDAR_DEACTIVATE','',9),(58,5,'maxSeriesEndsYear','TXT_CALENDAR_MAX_SERIES_ENDS_YEAR','0','TXT_CALENDAR_MAX_SERIES_ENDS_YEAR_INFO',5,'TXT_CALENDAR_MAX_SERIES_ENDS_YEAR_1_YEARS,TXT_CALENDAR_MAX_SERIES_ENDS_YEAR_2_YEARS,TXT_CALENDAR_MAX_SERIES_ENDS_YEAR_3_YEARS,TXT_CALENDAR_MAX_SERIES_ENDS_YEAR_4_YEARS,TXT_CALENDAR_MAX_SERIES_ENDS_YEAR_5_YEARS','',9),(59,5,'showEventsOnlyInActiveLanguage','TXT_CALENDAR_SHOW_EVENTS_ONLY_IN_ACTIVE_LANGUAGE','1','',3,'TXT_CALENDAR_ACTIVATE,TXT_CALENDAR_DEACTIVATE','',10),(60,16,'listViewPreview','TXT_CALENDAR_SHOW_PREVIEW','0','',7,'','listPreview',10),(61,17,'detailViewPreview','TXT_CALENDAR_SHOW_PREVIEW','0','',7,'','detailPreview',10),(62,19,'placeDataForm','','0','',5,'','getPlaceDataDorpdown',8),(20,19,'placeData','TXT_CALENDAR_PLACE_DATA','1','TXT_CALENDAR_PLACE_DATA_STATUS_INFO',3,'TXT_CALENDAR_PLACE_DATA_DEFAULT,TXT_CALENDAR_PLACE_DATA_FROM_MEDIADIR,TXT_CALENDAR_PLACE_DATA_FROM_BOTH','',7),(63,19,'placeDataHost','TXT_CALENDAR_PLACE_DATA_HOST','1','TXT_CALENDAR_PLACE_DATA_STATUS_INFO',3,'TXT_CALENDAR_PLACE_DATA_DEFAULT,TXT_CALENDAR_PLACE_DATA_FROM_MEDIADIR,TXT_CALENDAR_PLACE_DATA_FROM_BOTH','',9),(64,19,'placeDataHostForm','','0','',5,'','getPlaceDataDorpdown',10);
/*!40000 ALTER TABLE `contrexx_module_calendar_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_calendar_settings_section`
--

DROP TABLE IF EXISTS `contrexx_module_calendar_settings_section`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_calendar_settings_section` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_calendar_settings_section`
--

LOCK TABLES `contrexx_module_calendar_settings_section` WRITE;
/*!40000 ALTER TABLE `contrexx_module_calendar_settings_section` DISABLE KEYS */;
INSERT INTO `contrexx_module_calendar_settings_section` VALUES (5,1,0,'global','TXT_CALENDAR_GLOBAL'),(6,1,1,'headlines','TXT_CALENDAR_HEADLINES'),(1,0,0,'global',''),(2,0,1,'form',''),(3,0,2,'mails',''),(4,0,3,'hosts',''),(7,4,0,'publication','TXT_CALENDAR_PUBLICATION'),(8,1,2,'categories','TXT_CALENDAR_CATEGORIES'),(9,0,4,'payment',''),(10,9,0,'payment','TXT_CALENDAR_PAYMENT'),(11,9,1,'paymentBill','TXT_CALENDAR_PAYMENT_BILL'),(12,9,2,'paymentYellowpay','TXT_CALENDAR_PAYMENT_YELLOWPAY'),(13,9,1,'paymentBank','TXT_CALENDAR_PAYMENT_BANK'),(14,0,5,'dateDisplay','TXT_CALENDAR_DATE_DISPLAY'),(15,14,0,'dateGlobal','TXT_CALENDAR_GLOBAL'),(16,14,1,'dateDisplayList','TXT_CALENDAR_DATE_DISPLAY_LIST'),(17,14,2,'dateDisplayDetail','TXT_CALENDAR_DATE_DISPLAY_DETAIL'),(18,1,3,'frontend_submission','TXT_CALENDAR_FRONTEND_SUBMISSION'),(19,1,4,'location_host','TXT_CALENDAR_EVENT_LOCATION');
/*!40000 ALTER TABLE `contrexx_module_calendar_settings_section` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_calendar_style`
--

DROP TABLE IF EXISTS `contrexx_module_calendar_style`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_calendar_style` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tableWidth` varchar(4) COLLATE utf8_unicode_ci NOT NULL DEFAULT '141',
  `tableHeight` varchar(4) COLLATE utf8_unicode_ci NOT NULL DEFAULT '92',
  `tableColor` varchar(7) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tableBorder` int(11) NOT NULL DEFAULT '0',
  `tableBorderColor` varchar(7) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tableSpacing` int(11) NOT NULL DEFAULT '0',
  `fontSize` int(11) NOT NULL DEFAULT '10',
  `fontColor` varchar(7) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `numColor` varchar(7) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `normalDayColor` varchar(7) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `normalDayRollOverColor` varchar(7) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `curDayColor` varchar(7) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `curDayRollOverColor` varchar(7) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `eventDayColor` varchar(7) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `eventDayRollOverColor` varchar(7) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `shownEvents` int(4) NOT NULL DEFAULT '10',
  `periodTime` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '00 23',
  `stdCat` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_calendar_style`
--

LOCK TABLES `contrexx_module_calendar_style` WRITE;
/*!40000 ALTER TABLE `contrexx_module_calendar_style` DISABLE KEYS */;
INSERT INTO `contrexx_module_calendar_style` VALUES (1,'141','92','#ffffff',1,'#cccccc',0,10,'#000000','#0000ff','#ffffff','#eeeeee','#00ccff','#0066ff','#00cc00','#009900',10,'00 23',''),(2,'141','92','#ffffff',1,'#cccccc',0,10,'#000000','#0000ff','#ffffff','#eeeeee','#00ccff','#0066ff','#00cc00','#009900',10,'05 19','1>1 2>0');
/*!40000 ALTER TABLE `contrexx_module_calendar_style` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_checkout_settings_general`
--

DROP TABLE IF EXISTS `contrexx_module_checkout_settings_general`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_checkout_settings_general` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_checkout_settings_general`
--

LOCK TABLES `contrexx_module_checkout_settings_general` WRITE;
/*!40000 ALTER TABLE `contrexx_module_checkout_settings_general` DISABLE KEYS */;
INSERT INTO `contrexx_module_checkout_settings_general` VALUES (1,'epayment_status',1);
/*!40000 ALTER TABLE `contrexx_module_checkout_settings_general` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_checkout_settings_mails`
--

DROP TABLE IF EXISTS `contrexx_module_checkout_settings_mails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_checkout_settings_mails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_checkout_settings_mails`
--

LOCK TABLES `contrexx_module_checkout_settings_mails` WRITE;
/*!40000 ALTER TABLE `contrexx_module_checkout_settings_mails` DISABLE KEYS */;
INSERT INTO `contrexx_module_checkout_settings_mails` VALUES (1,'[[DOMAIN_URL]] - Neue Zahlung','Guten Tag<br />\r\n<br />\r\nAuf [[DOMAIN_URL]] wurde eine neue Zahlung abgewickelt:<br />\r\n<br />\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n	<tbody>\r\n		<tr>\r\n			<td colspan=\"2\" nowrap=\"nowrap\" width=\"150\">\r\n				<strong>Angaben zur Transaktion</strong></td>\r\n		</tr>\r\n		<tr>\r\n			<td width=\"150\">\r\n				ID</td>\r\n			<td>\r\n				[[TRANSACTION_ID]]</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				Status</td>\r\n			<td>\r\n				[[TRANSACTION_STATUS]]</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				Datum und Uhrzeit</td>\r\n			<td>\r\n				[[TRANSACTION_TIME]]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n<br />\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n	<tbody>\r\n		<tr>\r\n			<td colspan=\"2\" nowrap=\"nowrap\" width=\"150\">\r\n				<strong>Angaben zur beglichenen Rechnung</strong></td>\r\n		</tr>\r\n		<tr>\r\n			<td width=\"150\">\r\n				Nummer</td>\r\n			<td>\r\n				[[INVOICE_NUMBER]]</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				Betrag</td>\r\n			<td>\r\n				[[INVOICE_AMOUNT]] [[INVOICE_CURRENCY]]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n<br />\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n	<tbody>\r\n		<tr>\r\n			<td colspan=\"2\" nowrap=\"nowrap\" width=\"150\">\r\n				<strong>Angaben zur Kontaktperson</strong></td>\r\n		</tr>\r\n		<tr>\r\n			<td width=\"150\">\r\n				Anrede</td>\r\n			<td>\r\n				[[CONTACT_TITLE]]</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				Vorname</td>\r\n			<td>\r\n				[[CONTACT_FORENAME]]</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				Nachname</td>\r\n			<td>\r\n				[[CONTACT_SURNAME]]</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				Firma</td>\r\n			<td>\r\n				[[CONTACT_COMPANY]]</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				Strasse</td>\r\n			<td>\r\n				[[CONTACT_STREET]]</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				PLZ</td>\r\n			<td>\r\n				[[CONTACT_POSTCODE]]</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				Ort</td>\r\n			<td>\r\n				[[CONTACT_PLACE]]</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				Land</td>\r\n			<td>\r\n				[[CONTACT_COUNTRY]]</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				Telefon</td>\r\n			<td>\r\n				[[CONTACT_PHONE]]</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				E-Mail-Adresse</td>\r\n			<td>\r\n				<a href=\"[[CONTACT_EMAIL]]?csrf=ODg4MTM2Nzg1&amp;csrf=NDQzMzAwNjE0\">[[CONTACT_EMAIL]]</a></td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n<br />\r\nFreundliche Gr&uuml;sse<br />\r\nDas [[DOMAIN_URL]]&nbsp;Team'),(2,'[[DOMAIN_URL]] - Zahlungsbestätigung','Guten Tag<br />\r\n<br />\r\nGerne best&auml;tigen wir die erfolgreiche Abwicklung folgender Zahlung auf [[DOMAIN_URL]]:<br />\r\n<br />\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n	<tbody>\r\n		<tr>\r\n			<td colspan=\"2\" nowrap=\"nowrap\" width=\"150\">\r\n				<strong>Angaben zur Transaktion</strong></td>\r\n		</tr>\r\n		<tr>\r\n			<td width=\"150\">\r\n				ID</td>\r\n			<td>\r\n				[[TRANSACTION_ID]]</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				Status</td>\r\n			<td>\r\n				[[TRANSACTION_STATUS]]</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				Datum und Uhrzeit</td>\r\n			<td>\r\n				[[TRANSACTION_TIME]]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n<br />\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n	<tbody>\r\n		<tr>\r\n			<td colspan=\"2\" nowrap=\"nowrap\" width=\"150\">\r\n				<strong>Angaben zur beglichenen Rechnung</strong></td>\r\n		</tr>\r\n		<tr>\r\n			<td width=\"150\">\r\n				Nummer</td>\r\n			<td>\r\n				[[INVOICE_NUMBER]]</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				Betrag</td>\r\n			<td>\r\n				[[INVOICE_AMOUNT]] [[INVOICE_CURRENCY]]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n<br />\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n	<tbody>\r\n		<tr>\r\n			<td colspan=\"2\" nowrap=\"nowrap\" width=\"150\">\r\n				<strong>Angaben zur Kontaktperson</strong></td>\r\n		</tr>\r\n		<tr>\r\n			<td width=\"150\">\r\n				Anrede</td>\r\n			<td>\r\n				[[CONTACT_TITLE]]</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				Vorname</td>\r\n			<td>\r\n				[[CONTACT_FORENAME]]</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				Nachname</td>\r\n			<td>\r\n				[[CONTACT_SURNAME]]</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				Firma</td>\r\n			<td>\r\n				[[CONTACT_COMPANY]]</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				Strasse</td>\r\n			<td>\r\n				[[CONTACT_STREET]]</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				PLZ</td>\r\n			<td>\r\n				[[CONTACT_POSTCODE]]</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				Ort</td>\r\n			<td>\r\n				[[CONTACT_PLACE]]</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				Land</td>\r\n			<td>\r\n				[[CONTACT_COUNTRY]]</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				Telefon</td>\r\n			<td>\r\n				[[CONTACT_PHONE]]</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				E-Mail-Adresse</td>\r\n			<td>\r\n				<a href=\"[[CONTACT_EMAIL]]?csrf=MTQ3ODg2NDkx&amp;csrf=ODg4NzYwNDE2\">[[CONTACT_EMAIL]]</a></td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n<br />\r\nFreundliche Gr&uuml;sse<br />\r\nDas [[DOMAIN_URL]]&nbsp;Team');
/*!40000 ALTER TABLE `contrexx_module_checkout_settings_mails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_checkout_settings_yellowpay`
--

DROP TABLE IF EXISTS `contrexx_module_checkout_settings_yellowpay`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_checkout_settings_yellowpay` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_checkout_settings_yellowpay`
--

LOCK TABLES `contrexx_module_checkout_settings_yellowpay` WRITE;
/*!40000 ALTER TABLE `contrexx_module_checkout_settings_yellowpay` DISABLE KEYS */;
INSERT INTO `contrexx_module_checkout_settings_yellowpay` VALUES (1,'pspid',''),(2,'sha_in',''),(3,'sha_out',''),(4,'testserver','1'),(5,'operation','SAL');
/*!40000 ALTER TABLE `contrexx_module_checkout_settings_yellowpay` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_checkout_transactions`
--

DROP TABLE IF EXISTS `contrexx_module_checkout_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_checkout_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` int(10) NOT NULL DEFAULT '0',
  `status` enum('confirmed','waiting','cancelled') COLLATE utf8_unicode_ci NOT NULL,
  `invoice_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `invoice_currency` int(11) NOT NULL DEFAULT '1',
  `invoice_amount` int(15) NOT NULL,
  `contact_title` enum('mister','miss') COLLATE utf8_unicode_ci NOT NULL,
  `contact_forename` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `contact_surname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `contact_company` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `contact_street` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `contact_postcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `contact_place` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `contact_country` int(11) NOT NULL DEFAULT '204',
  `contact_phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `contact_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_checkout_transactions`
--

LOCK TABLES `contrexx_module_checkout_transactions` WRITE;
/*!40000 ALTER TABLE `contrexx_module_checkout_transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_checkout_transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_contact_form`
--

DROP TABLE IF EXISTS `contrexx_module_contact_form`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_contact_form` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mails` text COLLATE utf8_unicode_ci NOT NULL,
  `showForm` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `use_captcha` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `use_custom_style` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `save_data_in_crm` tinyint(1) NOT NULL DEFAULT '0',
  `send_copy` tinyint(1) NOT NULL DEFAULT '0',
  `use_email_of_sender` tinyint(1) NOT NULL DEFAULT '0',
  `html_mail` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `send_attachment` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_contact_form`
--

LOCK TABLES `contrexx_module_contact_form` WRITE;
/*!40000 ALTER TABLE `contrexx_module_contact_form` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_contact_form` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_contact_form_data`
--

DROP TABLE IF EXISTS `contrexx_module_contact_form_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_contact_form_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_form` int(10) unsigned NOT NULL DEFAULT '0',
  `id_lang` int(10) unsigned NOT NULL DEFAULT '1',
  `time` int(14) unsigned NOT NULL DEFAULT '0',
  `host` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `lang` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `browser` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ipaddress` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_contact_form_data`
--

LOCK TABLES `contrexx_module_contact_form_data` WRITE;
/*!40000 ALTER TABLE `contrexx_module_contact_form_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_contact_form_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_contact_form_field`
--

DROP TABLE IF EXISTS `contrexx_module_contact_form_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_contact_form_field` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_form` int(10) unsigned NOT NULL DEFAULT '0',
  `type` enum('text','label','checkbox','checkboxGroup','country','date','file','multi_file','fieldset','hidden','horizontalLine','password','radio','select','textarea','recipient','special','datetime') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'text',
  `special_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `is_required` set('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `check_type` int(3) NOT NULL DEFAULT '1',
  `order_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_contact_form_field`
--

LOCK TABLES `contrexx_module_contact_form_field` WRITE;
/*!40000 ALTER TABLE `contrexx_module_contact_form_field` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_contact_form_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_contact_form_field_lang`
--

DROP TABLE IF EXISTS `contrexx_module_contact_form_field_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_contact_form_field_lang` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fieldID` int(10) unsigned NOT NULL,
  `langID` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `attributes` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fieldID` (`fieldID`,`langID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_contact_form_field_lang`
--

LOCK TABLES `contrexx_module_contact_form_field_lang` WRITE;
/*!40000 ALTER TABLE `contrexx_module_contact_form_field_lang` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_contact_form_field_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_contact_form_lang`
--

DROP TABLE IF EXISTS `contrexx_module_contact_form_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_contact_form_lang` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `formID` int(10) unsigned NOT NULL,
  `langID` int(10) unsigned NOT NULL,
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `feedback` text COLLATE utf8_unicode_ci NOT NULL,
  `mailTemplate` text COLLATE utf8_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `formID` (`formID`,`langID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_contact_form_lang`
--

LOCK TABLES `contrexx_module_contact_form_lang` WRITE;
/*!40000 ALTER TABLE `contrexx_module_contact_form_lang` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_contact_form_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_contact_form_submit_data`
--

DROP TABLE IF EXISTS `contrexx_module_contact_form_submit_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_contact_form_submit_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_entry` int(10) unsigned NOT NULL,
  `id_field` int(10) unsigned NOT NULL,
  `formlabel` text COLLATE utf8_unicode_ci NOT NULL,
  `formvalue` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_contact_form_submit_data`
--

LOCK TABLES `contrexx_module_contact_form_submit_data` WRITE;
/*!40000 ALTER TABLE `contrexx_module_contact_form_submit_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_contact_form_submit_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_contact_recipient`
--

DROP TABLE IF EXISTS `contrexx_module_contact_recipient`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_contact_recipient` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_form` int(11) NOT NULL DEFAULT '0',
  `email` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sort` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_contact_recipient`
--

LOCK TABLES `contrexx_module_contact_recipient` WRITE;
/*!40000 ALTER TABLE `contrexx_module_contact_recipient` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_contact_recipient` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_contact_recipient_lang`
--

DROP TABLE IF EXISTS `contrexx_module_contact_recipient_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_contact_recipient_lang` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `recipient_id` int(10) unsigned NOT NULL,
  `langID` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `recipient_id` (`recipient_id`,`langID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_contact_recipient_lang`
--

LOCK TABLES `contrexx_module_contact_recipient_lang` WRITE;
/*!40000 ALTER TABLE `contrexx_module_contact_recipient_lang` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_contact_recipient_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_contact_settings`
--

DROP TABLE IF EXISTS `contrexx_module_contact_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_contact_settings` (
  `setid` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `setname` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `setvalue` text COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`setid`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_contact_settings`
--

LOCK TABLES `contrexx_module_contact_settings` WRITE;
/*!40000 ALTER TABLE `contrexx_module_contact_settings` DISABLE KEYS */;
INSERT INTO `contrexx_module_contact_settings` VALUES (1,'fileUploadDepositionPath','/images/attach',1),(2,'spamProtectionWordList','poker,casino,viagra,sex,porn',1),(3,'fieldMetaDate','1',1),(4,'fieldMetaHost','0',1),(5,'fieldMetaLang','0',1),(6,'fieldMetaIP','0',1);
/*!40000 ALTER TABLE `contrexx_module_contact_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_crm_contacts`
--

DROP TABLE IF EXISTS `contrexx_module_crm_contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_crm_contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_type` int(11) DEFAULT NULL,
  `customer_name` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_website` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_addedby` int(11) DEFAULT NULL,
  `customer_currency` int(11) DEFAULT NULL,
  `contact_familyname` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_role` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_customer` int(11) DEFAULT NULL,
  `contact_language` int(11) DEFAULT NULL,
  `gender` tinyint(2) NOT NULL,
  `notes` text COLLATE utf8_unicode_ci,
  `industry_type` int(11) DEFAULT NULL,
  `contact_type` tinyint(2) DEFAULT NULL,
  `user_account` int(11) DEFAULT NULL,
  `datasource` int(11) DEFAULT NULL,
  `profile_picture` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1',
  `added_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_customer` (`contact_customer`),
  KEY `customer_id` (`customer_id`),
  KEY `customer_name` (`customer_name`),
  KEY `contact_familyname` (`contact_familyname`),
  KEY `contact_role` (`contact_role`),
  FULLTEXT KEY `customer_id_2` (`customer_id`,`customer_name`,`contact_familyname`,`contact_role`,`notes`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_crm_contacts`
--

LOCK TABLES `contrexx_module_crm_contacts` WRITE;
/*!40000 ALTER TABLE `contrexx_module_crm_contacts` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_crm_contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_crm_currency`
--

DROP TABLE IF EXISTS `contrexx_module_crm_currency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_crm_currency` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(400) COLLATE utf8_unicode_ci NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1',
  `pos` int(5) NOT NULL DEFAULT '0',
  `hourly_rate` text COLLATE utf8_unicode_ci NOT NULL,
  `default_currency` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`(333)),
  FULLTEXT KEY `name_2` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=118 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_crm_currency`
--

LOCK TABLES `contrexx_module_crm_currency` WRITE;
/*!40000 ALTER TABLE `contrexx_module_crm_currency` DISABLE KEYS */;
INSERT INTO `contrexx_module_crm_currency` VALUES (71,'AED-United Arab Emirates Dirham',1,0,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(72,'AMD-Armenian Dram',1,1,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(73,'ARS-Argentinian Peso',1,2,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(74,'AUD-Australian Dollar',1,3,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(75,'AZN-Azerbaijani Manat',1,4,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(76,'BDT-Bangladeshi Taka',1,5,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(77,'BRL-Brazilian Real',1,6,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(78,'BYR-Belarusian Ruble',1,7,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(79,'CAD-Canadian Dollar',1,8,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(80,'CHF-Swiss Franc',1,9,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',1),(81,'CLP-Chilean Peso',1,10,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(82,'CNY-Chinese Yuan',1,11,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(83,'CZK-Czech Koruna',1,12,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(84,'DKK-Danish Krone',1,13,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(85,'DZD-Algerian Dinar',1,14,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(86,'EUR-Euro',1,15,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(87,'GBP-Pound Sterling',1,16,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(88,'GEL-Georgian Lari',1,17,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(89,'HKD-Hong Kong Dollar',1,18,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(90,'HUF-Hungarian Forint',1,19,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(91,'IDR-Indonesian Rupiah',1,20,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(92,'ILS-Israeli Shekel',1,21,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(93,'INR-Indian Rupee',1,22,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(94,'JPY-Japanese Yen',1,23,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(95,'KRW-South Korean Won',1,24,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(96,'KZT-Kazakhstani Tenge',1,25,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(97,'LVL-Latvian Lat',1,26,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(98,'MAD-Moroccan Dirham',1,27,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(99,'MGA-Malagasy Ariary',1,28,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(100,'MXN-Mexican Peso',1,29,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(101,'MYR-Malaysian Ringgit',1,30,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(102,'NOK-Norwegian Krone',1,31,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(103,'NZD-New Zealand Dollar',1,32,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(104,'PHP-Philippine Peso',1,33,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(105,'PLN-Polish Zloty',1,34,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(106,'RUB-Rouble',1,35,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(107,'SAR-Saudi Riyal',1,36,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(108,'SEK-Swedish Krona',1,37,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(109,'SGD-Singapore Dollar',1,38,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(110,'THB-Thai Baht',1,39,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(111,'TRY-Turkish New Lira',1,40,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(112,'UAH-Ukraine Hryvnia',1,41,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(113,'USD-United States Dollar',1,42,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(114,'UZS-Uzbekistani Som',1,43,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(115,'VEF-Venezuelan Bolivar',1,44,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(116,'VND-Vietnamese Dong',1,45,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0),(117,'ZAR-South African Rand',1,46,'{\"267\":0,\"273\":0,\"272\":0,\"271\":0,\"268\":0,\"266\":0,\"274\":0,\"275\":0,\"270\":0}',0);
/*!40000 ALTER TABLE `contrexx_module_crm_currency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_crm_customer_comment`
--

DROP TABLE IF EXISTS `contrexx_module_crm_customer_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_crm_customer_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `notes_type_id` int(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `comment` text COLLATE utf8_unicode_ci,
  `added_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  FULLTEXT KEY `comment` (`comment`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_crm_customer_comment`
--

LOCK TABLES `contrexx_module_crm_customer_comment` WRITE;
/*!40000 ALTER TABLE `contrexx_module_crm_customer_comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_crm_customer_comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_crm_customer_contact_address`
--

DROP TABLE IF EXISTS `contrexx_module_crm_customer_contact_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_crm_customer_contact_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `address` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `zip` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `Address_Type` tinyint(4) NOT NULL,
  `is_primary` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  `contact_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_id` (`contact_id`),
  KEY `address` (`address`),
  KEY `city` (`city`),
  KEY `state` (`state`),
  KEY `zip` (`zip`),
  KEY `country` (`country`),
  FULLTEXT KEY `address_2` (`address`,`city`,`state`,`zip`,`country`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_crm_customer_contact_address`
--

LOCK TABLES `contrexx_module_crm_customer_contact_address` WRITE;
/*!40000 ALTER TABLE `contrexx_module_crm_customer_contact_address` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_crm_customer_contact_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_crm_customer_contact_emails`
--

DROP TABLE IF EXISTS `contrexx_module_crm_customer_contact_emails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_crm_customer_contact_emails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `email_type` tinyint(4) NOT NULL,
  `is_primary` enum('0','1') COLLATE utf8_unicode_ci DEFAULT '0',
  `contact_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_id` (`contact_id`),
  KEY `email` (`email`),
  FULLTEXT KEY `email_2` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_crm_customer_contact_emails`
--

LOCK TABLES `contrexx_module_crm_customer_contact_emails` WRITE;
/*!40000 ALTER TABLE `contrexx_module_crm_customer_contact_emails` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_crm_customer_contact_emails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_crm_customer_contact_phone`
--

DROP TABLE IF EXISTS `contrexx_module_crm_customer_contact_phone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_crm_customer_contact_phone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `phone_type` tinyint(4) NOT NULL,
  `is_primary` enum('0','1') COLLATE utf8_unicode_ci DEFAULT '0',
  `contact_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_id` (`contact_id`),
  KEY `phone` (`phone`),
  FULLTEXT KEY `phone_2` (`phone`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_crm_customer_contact_phone`
--

LOCK TABLES `contrexx_module_crm_customer_contact_phone` WRITE;
/*!40000 ALTER TABLE `contrexx_module_crm_customer_contact_phone` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_crm_customer_contact_phone` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_crm_customer_contact_social_network`
--

DROP TABLE IF EXISTS `contrexx_module_crm_customer_contact_social_network`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_crm_customer_contact_social_network` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `url_profile` tinyint(4) NOT NULL,
  `is_primary` enum('0','1') COLLATE utf8_unicode_ci DEFAULT '0',
  `contact_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_id` (`contact_id`),
  KEY `url` (`url`),
  FULLTEXT KEY `url_2` (`url`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_crm_customer_contact_social_network`
--

LOCK TABLES `contrexx_module_crm_customer_contact_social_network` WRITE;
/*!40000 ALTER TABLE `contrexx_module_crm_customer_contact_social_network` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_crm_customer_contact_social_network` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_crm_customer_contact_websites`
--

DROP TABLE IF EXISTS `contrexx_module_crm_customer_contact_websites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_crm_customer_contact_websites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `url_type` tinyint(4) NOT NULL,
  `url_profile` tinyint(4) NOT NULL,
  `is_primary` enum('0','1') COLLATE utf8_unicode_ci DEFAULT '0',
  `contact_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_id` (`contact_id`),
  KEY `url` (`url`),
  FULLTEXT KEY `url_2` (`url`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_crm_customer_contact_websites`
--

LOCK TABLES `contrexx_module_crm_customer_contact_websites` WRITE;
/*!40000 ALTER TABLE `contrexx_module_crm_customer_contact_websites` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_crm_customer_contact_websites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_crm_customer_documents`
--

DROP TABLE IF EXISTS `contrexx_module_crm_customer_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_crm_customer_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `document_name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `added_by` int(11) NOT NULL,
  `uploaded_date` datetime NOT NULL,
  `contact_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_id` (`contact_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_crm_customer_documents`
--

LOCK TABLES `contrexx_module_crm_customer_documents` WRITE;
/*!40000 ALTER TABLE `contrexx_module_crm_customer_documents` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_crm_customer_documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_crm_customer_membership`
--

DROP TABLE IF EXISTS `contrexx_module_crm_customer_membership`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_crm_customer_membership` (
  `contact_id` int(11) NOT NULL,
  `membership_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_crm_customer_membership`
--

LOCK TABLES `contrexx_module_crm_customer_membership` WRITE;
/*!40000 ALTER TABLE `contrexx_module_crm_customer_membership` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_crm_customer_membership` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_crm_customer_types`
--

DROP TABLE IF EXISTS `contrexx_module_crm_customer_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_crm_customer_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `hourly_rate` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `active` int(1) NOT NULL,
  `pos` int(10) NOT NULL DEFAULT '0',
  `default` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `label` (`label`),
  FULLTEXT KEY `label_2` (`label`)
) ENGINE=MyISAM AUTO_INCREMENT=276 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_crm_customer_types`
--

LOCK TABLES `contrexx_module_crm_customer_types` WRITE;
/*!40000 ALTER TABLE `contrexx_module_crm_customer_types` DISABLE KEYS */;
INSERT INTO `contrexx_module_crm_customer_types` VALUES (268,'Genossenschaft','',1,5,0),(266,'Non-Profit-Organisation','',1,6,0),(267,'Einzelunternehmen','',1,0,0),(270,'Verein','',1,9,0),(271,'Großunternehmen','',1,3,0),(272,'Kleine und mittlere Unternehmen','',1,2,1),(273,'Kleinst- und Kleinunternehmen','',1,1,0),(274,'Nichtregierungsorganisation','',1,7,0),(275,'Privat','',1,8,0);
/*!40000 ALTER TABLE `contrexx_module_crm_customer_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_crm_datasources`
--

DROP TABLE IF EXISTS `contrexx_module_crm_datasources`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_crm_datasources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datasource` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_crm_datasources`
--

LOCK TABLES `contrexx_module_crm_datasources` WRITE;
/*!40000 ALTER TABLE `contrexx_module_crm_datasources` DISABLE KEYS */;
INSERT INTO `contrexx_module_crm_datasources` VALUES (1,'crm',1),(2,'web form',1),(3,'import',1);
/*!40000 ALTER TABLE `contrexx_module_crm_datasources` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_crm_deals`
--

DROP TABLE IF EXISTS `contrexx_module_crm_deals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_crm_deals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `website` int(11) NOT NULL,
  `customer` int(11) NOT NULL,
  `customer_contact` int(11) NOT NULL,
  `quoted_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quote_number` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `assigned_to` int(11) NOT NULL,
  `due_date` date DEFAULT NULL,
  `stage` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `project_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `customer` (`customer`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_crm_deals`
--

LOCK TABLES `contrexx_module_crm_deals` WRITE;
/*!40000 ALTER TABLE `contrexx_module_crm_deals` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_crm_deals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_crm_industry_type_local`
--

DROP TABLE IF EXISTS `contrexx_module_crm_industry_type_local`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_crm_industry_type_local` (
  `entry_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL,
  `value` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  KEY `entry_id` (`entry_id`),
  KEY `value` (`value`),
  FULLTEXT KEY `value_2` (`value`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_crm_industry_type_local`
--

LOCK TABLES `contrexx_module_crm_industry_type_local` WRITE;
/*!40000 ALTER TABLE `contrexx_module_crm_industry_type_local` DISABLE KEYS */;
INSERT INTO `contrexx_module_crm_industry_type_local` VALUES (4,1,'Industry de'),(4,2,'Industry en'),(4,3,'Industry fr'),(5,1,'test Industry'),(5,2,'test Industry'),(5,3,'test Industry'),(6,1,'t454trt45t45'),(6,2,'t454trt45t45'),(6,3,'t454trt45t45'),(7,1,'eferferferfe'),(7,2,'eferferferfe'),(7,3,'eferferferfe'),(8,3,'rakesh'),(8,2,'ravi'),(8,1,'rakesh'),(9,1,''),(9,2,'rakesh'),(9,3,''),(10,3,''),(10,2,''),(10,1,'rakesh'),(11,3,'fr'),(11,2,'test'),(11,1,'de'),(12,2,'ram testing'),(12,1,'testing'),(12,3,'rakesh'),(13,1,''),(13,2,''),(13,3,''),(14,1,''),(14,2,''),(14,3,''),(15,1,'    '),(15,2,'    '),(15,3,'    '),(16,3,'sdfaf'),(16,2,'sdfaf'),(16,1,'sdfaf'),(17,3,'Rakesh'),(17,2,'test'),(17,1,'test'),(18,1,'a'),(18,2,'a'),(18,3,'a'),(19,1,'rakesh'),(19,2,'rakesh'),(19,3,'rakesh'),(20,3,'french'),(20,2,'english'),(20,1,'deutsch'),(21,2,'English'),(22,3,'french'),(22,2,'eng'),(22,1,'deutsch'),(23,1,'1'),(23,2,'2'),(23,3,'3'),(21,3,'french123'),(21,1,'deutsch123'),(24,2,'regression'),(24,1,'eng'),(25,1,'test'),(25,2,'test'),(25,3,'test'),(26,1,'retest'),(26,2,'retest'),(26,3,'retest'),(24,3,'eng'),(27,1,'testing123'),(27,2,'american'),(27,3,'french'),(28,2,'english'),(28,1,'deutsche'),(28,3,'french'),(29,1,'tamil'),(29,2,'tamil'),(29,3,'tamil'),(30,1,'Baken'),(30,2,'Baken'),(30,3,'Baken'),(31,1,'Banken  '),(31,2,'Banken  '),(31,3,'Banken  '),(115,1,'Banken'),(32,2,'Banken'),(32,1,'Banken'),(33,1,' Bankwesen '),(33,2,' Bankwesen '),(33,3,' Bankwesen '),(34,1,'Bankwesen '),(34,2,'Bankwesen '),(34,3,'Bankwesen '),(35,3,'Bauwesen '),(35,2,'Bauwesen '),(35,1,'Bauwesen '),(36,3,'Bankwesen '),(36,2,'Bankwesen '),(36,1,'Bankwesen '),(120,2,'234'),(37,2,'Architektur/Ingenieurbüro/Planung '),(37,1,' Architektur/Ingenieurbüro/Planung '),(38,3,'Bauten/Installationen'),(38,2,'Bauten/Installationen'),(38,1,'Bauten/Installationen'),(39,1,'Diverse Dienstleistungen'),(39,2,'Diverse Dienstleistungen'),(39,3,'Diverse Dienstleistungen'),(40,3,'  Diverse Produktionsbereiche'),(40,2,'Diverse Produktionsbereiche'),(40,1,'  Diverse Produktionsbereiche'),(41,1,'Diverser Grosshandel'),(41,2,'Diverser Grosshandel'),(41,3,'Diverser Grosshandel'),(42,1,'Elektrodetailhandel'),(42,2,'Elektrodetailhandel'),(42,3,'Elektrodetailhandel'),(43,1,'Immobilienverkauf-/verwaltung'),(43,2,'Immobilienverkauf-/verwaltung'),(43,3,'Immobilienverkauf-/verwaltung'),(44,3,'Bekleidung/Textil/Lederwaren '),(44,2,'Bekleidung/Textil/Lederwaren '),(44,1,'Bekleidung/Textil/Lederwaren '),(45,3,'Ateliers'),(45,2,'Ateliers'),(45,1,'Ateliers'),(46,3,'Diverse Dienstleistungen'),(46,2,'Diverse Dienstleistungen'),(46,1,'Diverse Dienstleistungen'),(47,3,'Diverse Produktionsbereiche'),(47,2,'Diverse Produktionsbereiche'),(47,1,'Diverse Produktionsbereiche'),(48,1,'Banken'),(48,2,'Banken'),(48,3,'Banken'),(49,3,'Diverser Detailhandel'),(49,2,'Diverser Detailhandel'),(49,1,'Diverser Detailhandel'),(50,3,' Diverser Grosshande'),(50,2,'Diverser Grosshande'),(50,1,' Diverser Grosshande'),(51,1,'Mode-Detailhandel'),(51,2,'Mode-Detailhandel'),(51,3,'Mode-Detailhandel'),(52,1,'Schuh-Detailhandel'),(52,2,'Schuh-Detailhandel'),(52,3,'Schuh-Detailhandel'),(53,1,'Textil-Detailhandel'),(53,2,'Textil-Detailhandel'),(53,3,'Textil-Detailhandel'),(54,3,'Bildungswesen '),(54,2,'Bildungswesen '),(54,1,'Bildungswesen '),(55,3,' Andere Schulen'),(55,2,'Andere Schulen'),(55,1,' Andere Schulen'),(56,1,'Berufsschulen/Fachschulen'),(56,2,'Berufsschulen/Fachschulen'),(56,3,'Berufsschulen/Fachschulen'),(57,1,'Diverse Dienstleistungen'),(57,2,'Diverse Dienstleistungen'),(57,3,'Diverse Dienstleistungen'),(58,1,'Grundschulen'),(58,2,'Grundschulen'),(58,3,'Grundschulen'),(59,1,'Hochschulen'),(59,2,'Hochschulen'),(59,3,'Hochschulen'),(60,1,'Mittelschulen'),(60,2,'Mittelschulen'),(60,3,'Mittelschulen'),(61,1,'Oberstufenschulen'),(61,2,'Oberstufenschulen'),(61,3,'Oberstufenschulen'),(62,1,'Sprach-/Heilpädagogische Schulen'),(62,2,'Sprach-/Heilpädagogische Schulen'),(62,3,'Sprach-/Heilpädagogische Schulen'),(63,3,'Büro/Informatik/Übersetzungen '),(63,2,'Büro/Informatik/Übersetzungen '),(63,1,'Büro/Informatik/Übersetzungen '),(64,1,'Diverse Dienstleistungen'),(64,2,'Diverse Dienstleistungen'),(64,3,'Diverse Dienstleistungen'),(65,1,'Diverse Produktionsbereiche'),(65,2,'Diverse Produktionsbereiche'),(65,3,'Diverse Produktionsbereiche'),(66,1,'Diverser Grosshandel'),(66,2,'Diverser Grosshandel'),(66,3,'Diverser Grosshandel'),(67,1,'Informatik-Detailhandel'),(67,2,'Informatik-Detailhandel'),(67,3,'Informatik-Detailhandel'),(68,1,'Papeterien'),(68,2,'Papeterien'),(68,3,'Papeterien'),(69,1,'Sekretariatsdienste'),(69,2,'Sekretariatsdienste'),(69,3,'Sekretariatsdienste'),(70,1,'test'),(70,2,'test'),(70,3,'test'),(71,1,'Übersetzungsdienste'),(71,2,'Übersetzungsdienste'),(71,3,'Übersetzungsdienste'),(72,3,'Finanzen/Unternehmensberatung '),(72,2,'Finanzen/Unternehmensberatung '),(72,1,'Finanzen/Unternehmensberatung '),(73,3,' Treuhand/Finanzberatung'),(73,2,'Treuhand/Finanzberatung'),(73,1,' Treuhand/Finanzberatung'),(74,1,'Unternehmensberatung/Coaching'),(74,2,'Unternehmensberatung/Coaching'),(74,3,'Unternehmensberatung/Coaching'),(75,3,'Gastronomie/Tourismus '),(75,2,'Gastronomie/Tourismus '),(75,1,'Gastronomie/Tourismus '),(76,3,'Diverse Dienstleistungen'),(76,2,'Diverse Dienstleistungen'),(76,1,'Diverse Dienstleistungen'),(77,3,' Hotels/Restaurants/Cafes'),(77,2,'Hotels/Restaurants/Cafes'),(77,1,' Hotels/Restaurants/Cafes'),(78,3,' Reisebüros'),(78,2,'Reisebüros'),(78,1,' Reisebüros'),(79,3,'Verkehrsbüros'),(79,2,'Verkehrsbüros'),(79,1,'Verkehrsbüros'),(80,3,'Gesundheitswesen'),(80,2,'Gesundheitswesen'),(80,1,'Gesundheitswesen'),(81,3,' Apotheken/Drogerien/Reformhäuser'),(81,2,'Apotheken/Drogerien/Reformhäuser'),(81,1,' Apotheken/Drogerien/Reformhäuser'),(82,3,'Arztpraxen'),(82,2,'Arztpraxen'),(82,1,'Arztpraxen'),(83,3,' Diverse Dienstleistungen'),(83,2,'Diverse Dienstleistungen'),(83,1,' Diverse Dienstleistungen'),(84,3,'Diverse Produktionsbereiche'),(84,2,'Diverse Produktionsbereiche'),(84,1,'Diverse Produktionsbereiche'),(85,3,' Diverse Therapien'),(85,2,'Diverse Therapien'),(85,1,' Diverse Therapien'),(86,3,'Diverser Detailhandel'),(86,2,'Diverser Detailhandel'),(86,1,'Diverser Detailhandel'),(87,3,'  Heime'),(87,2,'Heime'),(87,1,'  Heime'),(88,3,' Kliniken/Spitäler'),(88,2,'Kliniken/Spitäler'),(88,1,' Kliniken/Spitäler'),(89,3,'Pharma-Grosshandel'),(89,2,'Pharma-Grosshandel'),(89,1,'Pharma-Grosshandel'),(90,3,'Pharma-Produktion'),(90,2,'Pharma-Produktion'),(90,1,'Pharma-Produktion'),(91,3,'Physiotherapie'),(91,2,'Physiotherapie'),(91,1,'Physiotherapie'),(92,3,'Podologie'),(92,2,'Podologie'),(92,1,'Podologie'),(93,3,'Psychologie/Psychotherapie'),(93,2,'Psychologie/Psychotherapie'),(93,1,'Psychologie/Psychotherapie'),(94,3,'Zahnarztpraxen'),(94,2,'Zahnarztpraxen'),(94,1,'Zahnarztpraxen'),(95,3,'Inneneinrichtung/Dekoration/haushalt'),(95,2,'Inneneinrichtung/Dekoration/haushalt'),(95,1,'Inneneinrichtung/Dekoration/haushalt'),(96,3,'Ateliers'),(96,2,'Ateliers'),(96,1,'Ateliers'),(97,3,' Diverse Dienstleistungen'),(97,2,'Diverse Dienstleistungen'),(97,1,' Diverse Dienstleistungen'),(98,3,'Diverse Produktionsbereiche'),(98,2,'Diverse Produktionsbereiche'),(98,1,'Diverse Produktionsbereiche'),(99,3,'Diverser Detailhandel'),(99,2,'Diverser Detailhandel'),(99,1,'Diverser Detailhandel'),(100,3,'Diverser Grosshandel'),(100,2,'Diverser Grosshandel'),(100,1,'Diverser Grosshandel'),(101,3,'Geschenkartikel-Detailhandel'),(101,2,'Geschenkartikel-Detailhandel'),(101,1,'Geschenkartikel-Detailhandel'),(102,3,' Haushaltsfachgeschäfte'),(102,2,'Haushaltsfachgeschäfte'),(102,1,' Haushaltsfachgeschäfte'),(103,3,' Innenausbau/Innendekoration'),(103,2,'Innenausbau/Innendekoration'),(103,1,' Innenausbau/Innendekoration'),(104,3,'Inneneinrichtung/Dekoration/Haushalt'),(104,2,'Inneneinrichtung/Dekoration/Haushalt'),(104,1,'Inneneinrichtung/Dekoration/Haushalt'),(105,3,'Möbel-/Inneneinrichtung-Detailhandel'),(105,2,'Möbel-/Inneneinrichtung-Detailhandel'),(105,1,'Möbel-/Inneneinrichtung-Detailhandel'),(106,3,' Möbelfabrikation  '),(106,2,'Möbelfabrikation  '),(106,1,' Möbelfabrikation  '),(107,3,'Porzellan-/Kristall-Detailhandel'),(107,2,'Porzellan-/Kristall-Detailhandel'),(107,1,'Porzellan-/Kristall-Detailhandel'),(108,3,'Körperpflege'),(108,2,'Körperpflege'),(108,1,'Körperpflege'),(109,3,' Coiffure'),(109,2,'Coiffure'),(109,1,' Coiffure'),(110,3,'Diverse Dienstleistungen'),(110,2,'Diverse Dienstleistungen'),(110,1,'Diverse Dienstleistungen'),(111,3,'Körperpflegemittelproduktion'),(111,2,'Körperpflegemittelproduktion'),(111,1,'Körperpflegemittelproduktion'),(112,3,'Parfumerie/Kosmetikfachgeschäfte'),(112,2,'Parfumerie/Kosmetikfachgeschäfte'),(112,1,'Parfumerie/Kosmetikfachgeschäfte'),(113,3,' Kosmetikstudios'),(113,2,'Kosmetikstudios'),(113,1,' Kosmetikstudios'),(114,1,'Banken'),(114,2,'Banken'),(115,2,'Banken'),(116,2,'Banken1'),(116,1,'Banken'),(117,1,'Banken'),(117,2,'Banken'),(118,2,'üßtes<<INDUSTRY>>tüasdöf'),(118,1,'üßtes<<INDUSTRY>>tüasdöf'),(119,2,'engllish test'),(119,1,'asöüerü<INDUSTRY>ßüäävaö'),(120,1,'234'),(121,1,'test'),(121,2,'test'),(122,1,'rferfre'),(122,2,'rferfre'),(123,1,'test'),(123,2,'test'),(124,1,'test'),(124,2,'test'),(125,1,'industry type testing'),(125,2,'industry type testing'),(126,1,'Informationstechnologie'),(126,2,'Informationstechnologie'),(127,1,'Energie'),(127,2,'Energie'),(128,1,'Maschinen-, Elektro- und Metallindustrie'),(128,2,'Maschinen-, Elektro- und Metallindustrie'),(129,1,'Hotellerie'),(129,2,'Hotellerie'),(130,1,'Wald- und Holzwirtschaft'),(130,2,'Wald- und Holzwirtschaft'),(131,1,'Bauwirtschaft'),(131,2,'Bauwirtschaft'),(132,1,'Immobilien'),(132,2,'Immobilien'),(133,1,'Grosshandel'),(133,2,'Grosshandel'),(134,1,'Tourismus'),(134,2,'Tourismus'),(135,1,'Öffentlicher Sektor'),(135,2,'Öffentlicher Sektor'),(136,1,'Zulieferindustrie'),(136,2,'Zulieferindustrie'),(137,1,'Rohstoffhandel'),(137,2,'Rohstoffhandel'),(138,1,'test'),(138,2,'test'),(139,2,'test'),(139,1,'test'),(140,2,'test'),(140,1,'test'),(141,1,'rfrefrferf'),(141,2,'rfrefrferf'),(142,1,'Auto, Motorrad, Transport & Verkehr'),(142,2,'Auto, Motorrad, Transport & Verkehr'),(143,1,'Autohäuser und -händler'),(143,2,'Autohäuser und -händler'),(144,1,'Werkstatt, Service '),(144,2,'Werkstatt, Service '),(145,1,'Zweiräder'),(145,2,'Zweiräder'),(146,1,'Vermietung von Fahrzeugen'),(146,2,'Vermietung von Fahrzeugen'),(147,1,'Wasserfahrzeuge'),(147,2,'Wasserfahrzeuge'),(148,1,'Spedition und Transport '),(148,2,'Spedition und Transport '),(149,1,'Verkehr Sonstiges'),(149,2,'Verkehr Sonstiges'),(150,1,'Bauen & Handwerk'),(150,2,'Bauen & Handwerk'),(151,1,'Bauhandwerk'),(151,2,'Bauhandwerk'),(152,1,'Bauunternehmen '),(152,2,'Bauunternehmen '),(153,1,'Service rund ums Bauen '),(153,2,'Service rund ums Bauen '),(154,1,'Baumaterialien'),(154,2,'Baumaterialien'),(155,1,'Wohnen & Einrichten'),(155,2,'Wohnen & Einrichten'),(156,1,'Einrichten'),(156,2,'Einrichten'),(157,1,'Einrichten'),(157,2,'Einrichten'),(158,1,'Wohnungssuche '),(158,2,'Wohnungssuche '),(159,1,'Natur, Garten, Umwelt'),(159,2,'Natur, Garten, Umwelt'),(160,1,'Land- & Forstwirtschaft'),(160,2,'Land- & Forstwirtschaft'),(161,1,'Garten'),(161,2,'Garten'),(162,1,'Energie- und Wasserversorgung'),(162,2,'Energie- und Wasserversorgung'),(163,1,'Umweltschutz, Entsorgung'),(163,2,'Umweltschutz, Entsorgung'),(164,1,'Recht, Geld, Versicherung'),(164,2,'Recht, Geld, Versicherung'),(165,1,'Recht'),(165,2,'Recht'),(166,1,'Finanzen '),(166,2,'Finanzen '),(167,1,'Steuern'),(167,2,'Steuern'),(168,1,'Versicherung'),(168,2,'Versicherung'),(169,1,'Lebenshilfe '),(169,2,'Lebenshilfe '),(170,1,'Dienstleistungen'),(170,2,'Dienstleistungen'),(171,1,'Notdienste'),(171,2,'Notdienste'),(172,1,'Vermietung '),(172,2,'Vermietung '),(173,1,'Änderungen, Reparaturen'),(173,2,'Änderungen, Reparaturen'),(174,1,'Haushalt'),(174,2,'Haushalt'),(175,1,'Hilfe im Trauerfall'),(175,2,'Hilfe im Trauerfall'),(176,1,'Lieferdienste'),(176,2,'Lieferdienste'),(177,1,'Sonstige Dienstleistungen '),(177,2,'Sonstige Dienstleistungen '),(178,1,'Computer, Elektronik, Kommunikation'),(178,2,'Computer, Elektronik, Kommunikation'),(179,1,'Computer '),(179,2,'Computer '),(180,1,'Audio, Hifi, Video '),(180,2,'Audio, Hifi, Video '),(181,1,'Telefon und Handy '),(181,2,'Telefon und Handy '),(182,1,'Einkaufen'),(182,2,'Einkaufen'),(183,1,'Alles für den Tag'),(183,2,'Alles für den Tag'),(184,1,'Mode, Accessoires'),(184,2,'Mode, Accessoires'),(185,1,'Unterhaltungselektronik'),(185,2,'Unterhaltungselektronik'),(186,1,'Haushalt & Einrichtung '),(186,2,'Haushalt & Einrichtung '),(187,1,'Freizeit'),(187,2,'Freizeit'),(188,1,'Gesundheit '),(188,2,'Gesundheit '),(189,1,'Medien'),(189,2,'Medien'),(190,1,'Sonstiger Einkauf'),(190,2,'Sonstiger Einkauf'),(191,1,'Essen Trinken, Ausgehen'),(191,2,'Essen Trinken, Ausgehen'),(192,1,'Essen & Trinken '),(192,2,'Essen & Trinken '),(193,1,'Kunst & Kultur'),(193,2,'Kunst & Kultur'),(194,1,'Urlaub & Freizeit'),(194,2,'Urlaub & Freizeit'),(195,1,'Reisen'),(195,2,'Reisen'),(196,1,'Unterkünfte '),(196,2,'Unterkünfte '),(197,1,'Freizeitspaß'),(197,2,'Freizeitspaß'),(198,1,'Hobby'),(198,2,'Hobby'),(199,1,'Fitness, Wellness, Körperpflege'),(199,2,'Fitness, Wellness, Körperpflege'),(200,1,'Sport & Fitness'),(200,2,'Sport & Fitness'),(201,1,'Friseur & Kosmetik'),(201,2,'Friseur & Kosmetik'),(202,1,'Entspannung'),(202,2,'Entspannung'),(203,1,'Gesundheit, Pflege, Medizin'),(203,2,'Gesundheit, Pflege, Medizin'),(204,1,'Ärzte & Krankenhäuser'),(204,2,'Ärzte & Krankenhäuser'),(205,1,'Krankenversicherung'),(205,2,'Krankenversicherung'),(206,1,'Medikamente, Sanitätsmaterial'),(206,2,'Medikamente, Sanitätsmaterial'),(207,1,'Medizinischer Service'),(207,2,'Medizinischer Service'),(208,1,'Medizinischer Service'),(208,2,'Medizinischer Service'),(209,1,'Heime & Pflegedienste'),(209,2,'Heime & Pflegedienste'),(210,1,'Soziale Einrichtungen'),(210,2,'Soziale Einrichtungen'),(211,1,'Therapie'),(211,2,'Therapie'),(212,1,'Aus- & Weiterbildung'),(212,2,'Aus- & Weiterbildung'),(213,1,'Hoch- & Fachschulen'),(213,2,'Hoch- & Fachschulen'),(214,1,'Schulen & Kinderbetreuung'),(214,2,'Schulen & Kinderbetreuung'),(215,1,'Hoch- & Fachschulen '),(215,2,'Hoch- & Fachschulen '),(216,1,'Unterricht, Nachhilfe '),(216,2,'Unterricht, Nachhilfe '),(217,1,'Werbung & Medien'),(217,2,'Werbung & Medien'),(218,1,'Werbeberatung'),(218,2,'Werbeberatung'),(219,1,'Agenturen'),(219,2,'Agenturen'),(220,1,'elektronische Medien'),(220,2,'elektronische Medien'),(221,1,'grafisches Gewerbe'),(221,2,'grafisches Gewerbe'),(222,1,'Verlage'),(222,2,'Verlage'),(223,1,'Werbemittel'),(223,2,'Werbemittel'),(224,1,'Printmedien'),(224,2,'Printmedien'),(225,1,'Bedarf & Leistungen für Firmen'),(225,2,'Bedarf & Leistungen für Firmen'),(226,1,'Dienstleistungen'),(226,2,'Dienstleistungen'),(227,1,'Material & Geräte'),(227,2,'Material & Geräte'),(228,1,'Personal'),(228,2,'Personal'),(229,1,'Industrie'),(229,2,'Industrie'),(230,1,'Industrie'),(230,2,'Industrie'),(231,1,'Forschung'),(231,2,'Forschung'),(232,1,'Ämter & Öffentliche Einrichtungen'),(232,2,'Ämter & Öffentliche Einrichtungen'),(233,1,'Behörden'),(233,2,'Behörden'),(234,1,'Schulen & Kinderbetreuung '),(234,2,'Schulen & Kinderbetreuung '),(235,1,'Verbände, Vereine, Kirchen, Parteien'),(235,2,'Verbände, Vereine, Kirchen, Parteien');
/*!40000 ALTER TABLE `contrexx_module_crm_industry_type_local` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_crm_industry_types`
--

DROP TABLE IF EXISTS `contrexx_module_crm_industry_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_crm_industry_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `sorting` int(11) NOT NULL,
  `status` smallint(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=236 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_crm_industry_types`
--

LOCK TABLES `contrexx_module_crm_industry_types` WRITE;
/*!40000 ALTER TABLE `contrexx_module_crm_industry_types` DISABLE KEYS */;
INSERT INTO `contrexx_module_crm_industry_types` VALUES (1,0,0,1),(2,0,0,1),(3,0,0,1),(153,150,2,1),(152,150,1,1),(151,150,0,1),(150,0,1,1),(149,142,6,1),(148,142,5,1),(147,142,4,1),(146,142,3,1),(145,142,2,1),(144,142,1,1),(143,142,0,1),(142,0,0,1),(154,150,3,1),(155,0,2,1),(157,155,0,1),(158,155,1,1),(159,0,3,1),(160,159,0,1),(161,159,1,1),(162,159,2,1),(163,159,3,1),(164,0,4,1),(165,164,0,1),(166,164,1,1),(167,164,2,1),(168,164,3,1),(169,164,4,1),(170,0,5,1),(171,170,0,1),(172,170,1,1),(173,170,2,1),(174,170,3,1),(175,170,4,1),(176,170,5,1),(177,170,6,1),(178,0,6,1),(179,178,0,1),(180,178,1,1),(181,178,2,1),(182,0,7,1),(183,182,0,1),(184,182,1,1),(185,182,2,1),(186,182,3,1),(187,182,4,1),(188,182,5,1),(189,182,6,1),(190,182,7,1),(191,0,8,1),(192,191,0,1),(193,191,1,1),(194,0,9,1),(195,194,0,1),(196,194,1,1),(197,194,2,1),(198,194,3,1),(199,0,10,1),(200,199,0,1),(201,199,1,1),(202,199,2,1),(203,0,11,1),(204,203,0,1),(205,203,1,1),(206,203,2,1),(207,203,3,1),(209,203,5,1),(210,203,6,1),(211,203,4,1),(212,0,12,1),(233,232,0,1),(214,212,1,1),(215,212,0,1),(216,212,2,1),(217,0,13,1),(218,217,0,1),(219,217,1,1),(220,217,2,1),(221,217,3,1),(222,217,4,1),(223,217,5,1),(224,217,6,1),(225,0,14,1),(226,225,0,1),(227,225,1,1),(228,225,2,1),(230,225,3,1),(231,225,4,1),(232,0,15,1),(234,232,1,1),(235,232,2,1);
/*!40000 ALTER TABLE `contrexx_module_crm_industry_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_crm_membership_local`
--

DROP TABLE IF EXISTS `contrexx_module_crm_membership_local`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_crm_membership_local` (
  `entry_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL,
  `value` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  KEY `entry_id` (`entry_id`),
  KEY `value` (`value`),
  FULLTEXT KEY `value_2` (`value`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_crm_membership_local`
--

LOCK TABLES `contrexx_module_crm_membership_local` WRITE;
/*!40000 ALTER TABLE `contrexx_module_crm_membership_local` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_crm_membership_local` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_crm_memberships`
--

DROP TABLE IF EXISTS `contrexx_module_crm_memberships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_crm_memberships` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sorting` int(11) NOT NULL,
  `status` smallint(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_crm_memberships`
--

LOCK TABLES `contrexx_module_crm_memberships` WRITE;
/*!40000 ALTER TABLE `contrexx_module_crm_memberships` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_crm_memberships` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_crm_notes`
--

DROP TABLE IF EXISTS `contrexx_module_crm_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_crm_notes` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pos` int(1) NOT NULL,
  `system_defined` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  FULLTEXT KEY `name_2` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_crm_notes`
--

LOCK TABLES `contrexx_module_crm_notes` WRITE;
/*!40000 ALTER TABLE `contrexx_module_crm_notes` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_crm_notes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_crm_settings`
--

DROP TABLE IF EXISTS `contrexx_module_crm_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_crm_settings` (
  `setid` int(7) NOT NULL AUTO_INCREMENT,
  `setname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `setvalue` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`setid`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_crm_settings`
--

LOCK TABLES `contrexx_module_crm_settings` WRITE;
/*!40000 ALTER TABLE `contrexx_module_crm_settings` DISABLE KEYS */;
INSERT INTO `contrexx_module_crm_settings` VALUES (1,'allow_pm','0'),(11,'customer_default_language_backend','0'),(12,'customer_default_language_frontend','0'),(13,'default_user_group','6'),(14,'create_user_account','1'),(15,'emp_default_user_group','8'),(16,'user_account_mantatory','0'),(17,'default_country_value','204');
/*!40000 ALTER TABLE `contrexx_module_crm_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_crm_stages`
--

DROP TABLE IF EXISTS `contrexx_module_crm_stages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_crm_stages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `stage` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(2) NOT NULL,
  `sorting` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_crm_stages`
--

LOCK TABLES `contrexx_module_crm_stages` WRITE;
/*!40000 ALTER TABLE `contrexx_module_crm_stages` DISABLE KEYS */;
INSERT INTO `contrexx_module_crm_stages` VALUES (51,'Auftragsbestätigung akzeptiert','90',1,90),(52,'Bedarfsaufnahme','10',1,10),(49,'Mündliche Zusage durch Entscheider','80',1,80),(50,'Vertrag unterzeichnet','100',1,100),(48,'Interne Beeinflusser für uns entschieden','70',1,70),(45,'Richtofferte / Grundofferte','20',1,20),(46,'Kunde favorisiert unser Angebot','50',1,50),(53,'Gute Gründe für engere Wahl','40',1,40),(47,'Beste Position, keine Mitbewerber mehr','60',1,60),(44,'Erste Evaluation durch Kunde ausgeführt','30',1,30),(56,'Auftrag nicht erhalten','1',1,110);
/*!40000 ALTER TABLE `contrexx_module_crm_stages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_crm_success_rate`
--

DROP TABLE IF EXISTS `contrexx_module_crm_success_rate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_crm_success_rate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `rate` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(2) NOT NULL,
  `sorting` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_crm_success_rate`
--

LOCK TABLES `contrexx_module_crm_success_rate` WRITE;
/*!40000 ALTER TABLE `contrexx_module_crm_success_rate` DISABLE KEYS */;
INSERT INTO `contrexx_module_crm_success_rate` VALUES (2,'Erste Evaluation durch Kunde ausgeführt','30',1,30),(4,'Richtofferte / Grundofferte','20',1,20),(6,'Kunde favorisiert unser Angebot','50',1,50),(7,'Beste Position, keine Mitbewerber mehr','60',1,60),(8,'Interne Beeinflusser für uns entschieden','70',1,70),(9,'Mündliche Zusage durch Entscheider','80',1,80),(10,'Letter or telephone of intend','90',1,90),(11,'Auftragsbestätigung akzeptiert','100',1,100),(48,'Bedarfsaufnahme','10',1,10),(49,'Gute Gründe für engere Wahl','40',1,40);
/*!40000 ALTER TABLE `contrexx_module_crm_success_rate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_crm_task`
--

DROP TABLE IF EXISTS `contrexx_module_crm_task`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_crm_task` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `task_id` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `task_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `task_type_id` int(2) NOT NULL,
  `customer_id` int(2) NOT NULL,
  `due_date` datetime NOT NULL,
  `assigned_to` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `task_status` tinyint(1) NOT NULL DEFAULT '1',
  `added_by` int(11) NOT NULL,
  `added_date_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_crm_task`
--

LOCK TABLES `contrexx_module_crm_task` WRITE;
/*!40000 ALTER TABLE `contrexx_module_crm_task` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_crm_task` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_crm_task_types`
--

DROP TABLE IF EXISTS `contrexx_module_crm_task_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_crm_task_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `sorting` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `system_defined` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  FULLTEXT KEY `name_2` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_crm_task_types`
--

LOCK TABLES `contrexx_module_crm_task_types` WRITE;
/*!40000 ALTER TABLE `contrexx_module_crm_task_types` DISABLE KEYS */;
INSERT INTO `contrexx_module_crm_task_types` VALUES (52,'Unterlagen zusenden',1,0,'','',0),(53,'Rückruf',1,0,'','',0),(54,'Nachfassen',1,0,'','',0),(55,'Treffen',1,0,'','',0),(8,'Phone call',1,1,'','',0),(9,'Demo',1,2,'','',0),(10,'E-mail',1,3,'','',0),(11,'Fax',1,4,'','',0),(12,'Execution control',1,5,'','',0),(13,'Lunch',1,6,'','',0),(14,'Appoinment',1,7,'','',0),(15,'Note',1,8,'','',0),(16,'Delivery',1,9,'','',0),(17,'Social networks',1,10,'','',0),(18,'Expression of gratitude',1,11,'','',0);
/*!40000 ALTER TABLE `contrexx_module_crm_task_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_data_categories`
--

DROP TABLE IF EXISTS `contrexx_module_data_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_data_categories` (
  `category_id` int(4) unsigned NOT NULL DEFAULT '0',
  `lang_id` int(2) unsigned NOT NULL DEFAULT '0',
  `is_active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `cmd` int(10) unsigned NOT NULL DEFAULT '1',
  `action` enum('content','overlaybox','subcategories') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'content',
  `sort` int(10) unsigned NOT NULL DEFAULT '1',
  `box_height` int(10) unsigned NOT NULL DEFAULT '500',
  `box_width` int(11) NOT NULL DEFAULT '350',
  `template` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`category_id`,`lang_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_data_categories`
--

LOCK TABLES `contrexx_module_data_categories` WRITE;
/*!40000 ALTER TABLE `contrexx_module_data_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_data_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_data_message_to_category`
--

DROP TABLE IF EXISTS `contrexx_module_data_message_to_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_data_message_to_category` (
  `message_id` int(6) unsigned NOT NULL DEFAULT '0',
  `category_id` int(4) unsigned NOT NULL DEFAULT '0',
  `lang_id` int(2) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`message_id`,`category_id`,`lang_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_data_message_to_category`
--

LOCK TABLES `contrexx_module_data_message_to_category` WRITE;
/*!40000 ALTER TABLE `contrexx_module_data_message_to_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_data_message_to_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_data_messages`
--

DROP TABLE IF EXISTS `contrexx_module_data_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_data_messages` (
  `message_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(5) unsigned NOT NULL DEFAULT '0',
  `time_created` int(14) unsigned NOT NULL DEFAULT '0',
  `time_edited` int(14) unsigned NOT NULL DEFAULT '0',
  `hits` int(7) unsigned NOT NULL DEFAULT '0',
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `sort` int(10) unsigned NOT NULL DEFAULT '1',
  `mode` set('normal','forward') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'normal',
  `release_time` int(15) NOT NULL DEFAULT '0',
  `release_time_end` int(15) NOT NULL DEFAULT '0',
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_data_messages`
--

LOCK TABLES `contrexx_module_data_messages` WRITE;
/*!40000 ALTER TABLE `contrexx_module_data_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_data_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_data_messages_lang`
--

DROP TABLE IF EXISTS `contrexx_module_data_messages_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_data_messages_lang` (
  `message_id` int(6) unsigned NOT NULL DEFAULT '0',
  `lang_id` int(2) unsigned NOT NULL DEFAULT '0',
  `is_active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `subject` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `tags` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `image` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `thumbnail` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `thumbnail_type` enum('original','thumbnail') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'original',
  `thumbnail_width` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `thumbnail_height` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `attachment` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `attachment_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `mode` set('normal','forward') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'normal',
  `forward_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `forward_target` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`message_id`,`lang_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_data_messages_lang`
--

LOCK TABLES `contrexx_module_data_messages_lang` WRITE;
/*!40000 ALTER TABLE `contrexx_module_data_messages_lang` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_data_messages_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_data_placeholders`
--

DROP TABLE IF EXISTS `contrexx_module_data_placeholders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_data_placeholders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` set('cat','entry') COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ref_id` int(11) NOT NULL DEFAULT '0',
  `placeholder` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `placeholder` (`placeholder`),
  UNIQUE KEY `type` (`type`,`ref_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_data_placeholders`
--

LOCK TABLES `contrexx_module_data_placeholders` WRITE;
/*!40000 ALTER TABLE `contrexx_module_data_placeholders` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_data_placeholders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_data_settings`
--

DROP TABLE IF EXISTS `contrexx_module_data_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_data_settings` (
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_data_settings`
--

LOCK TABLES `contrexx_module_data_settings` WRITE;
/*!40000 ALTER TABLE `contrexx_module_data_settings` DISABLE KEYS */;
INSERT INTO `contrexx_module_data_settings` VALUES ('data_block_activated','0'),('data_block_messages','3'),('data_comments_activated','1'),('data_comments_anonymous','1'),('data_comments_autoactivate','1'),('data_comments_editor','wysiwyg'),('data_comments_notification','1'),('data_comments_timeout','30'),('data_entry_action','overlaybox'),('data_general_introduction','150'),('data_rss_activated','0'),('data_rss_comments','10'),('data_rss_messages','5'),('data_shadowbox_height','300'),('data_shadowbox_width','500'),('data_tags_hitlist','5'),('data_target_cmd','0'),('data_template_category','<!-- BEGIN datalist_category -->\r\n<!-- this displays the category and the subcategories -->\r\n<div class=\"datalist_block\">\r\n<dl>\r\n	<!-- BEGIN category -->\r\n	<dt class=\"cattitle\">[[CATTITLE]]</dt>\r\n	<dd class=\"catcontent\">\r\n		<dl>\r\n		<!-- BEGIN entry -->\r\n		<dt>[[TITLE]]</dt>\r\n		<dd>\r\n			[[IMAGE]] [[CONTENT]] <a href=\"[[HREF]]\" [[CLASS]] [[TARGET]]>[[TXT_MORE]]</a>\r\n			<br style=\"clear: both;\" />\r\n		</dd>\r\n		<!-- END entry -->\r\n		</dl>\r\n	</dd>\r\n	<!-- END category -->\r\n</dl>\r\n</div>\r\n<!-- END datalist_category -->\r\n\r\n<!-- BEGIN datalist_single_category-->\r\n<!-- this displays just the entries of the category -->\r\n<div class=\"datalist_block\">\r\n<dl>\r\n    <!-- BEGIN single_entry -->\r\n    <dt class=\"cattitle\">[[TITLE]]</dt>\r\n    <dd class=\"catcontent2\">\r\n        [[IMAGE]] <p>[[CONTENT]] <a href=\"[[HREF]]\" [[CLASS]] [[TARGET]]>[[TXT_MORE]]</a></p>\r\n        <div style=\"clear: both;\"></div>\r\n    </dd>\r\n    <!-- END single_entry -->\r\n</dl>\r\n</div>\r\n<!-- END datalist_single_category -->'),('data_template_entry','<!-- BEGIN datalist_entry-->\r\n<div class=\"datalist_block\">\r\n<dl>\r\n    <dt>[[TITLE]]</dt>\r\n    <dd>\r\n        [[IMAGE]] [[CONTENT]] <a href=\"[[HREF]]\" [[CLASS]]>[[TXT_MORE]]</a>\r\n        <div style=\"clear: both;\"></div>\r\n    </dd>\r\n</dl>\r\n</div>\r\n<!-- END datalist_entry -->'),('data_template_shadowbox','<!-- BEGIN shadowbox -->\r\n<html>\r\n<head>\r\n<link rel=\"stylesheet\" type=\"text/css\" href=\"themes/[[THEMES_PATH]]/modules.css\" />\r\n</head>\r\n<body style=\"background-color:#060606;\">\r\n<dl class=\"data_module\">\r\n    <dt>[[TITLE]]</dt>\r\n    <dd style=\"clear:left;\">\r\n	<!-- BEGIN image -->\r\n	<img src=\"[[PICTURE]]\" style=\"float: left; margin-right: 5px;\" />\r\n	<!-- END image -->\r\n        [[CONTENT]]\r\n        \r\n        <!-- BEGIN attachment -->\r\n    </dd>\r\n    <br />\r\n    <dt><img src=\"themes/default/images/arrow.gif\" width=\"16\" height=\"8\" /><a href=\"javascript:void(0);\" onclick=\"window.open(\'[[HREF]]\', \'attachment\');\">[[TXT_DOWNLOAD]]</a>\r\n        <!-- END attachment -->\r\n    </dt>\r\n</dl>\r\n<!--<br />\r\n<img src=\"themes/default/images/arrow.gif\" width=\"16\" height=\"8\" /><a onclick=\"Javascript:window.print();\" style=\"cursor:pointer;\">Drucken</a>-->\r\n</body>\r\n</html>\r\n<!-- END shadowbox -->'),('data_voting_activated','0');
/*!40000 ALTER TABLE `contrexx_module_data_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_directory_categories`
--

DROP TABLE IF EXISTS `contrexx_module_directory_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_directory_categories` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `parentid` int(6) unsigned NOT NULL DEFAULT '0',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `displayorder` smallint(6) unsigned NOT NULL DEFAULT '1000',
  `metadesc` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `metakeys` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `showentries` int(1) NOT NULL DEFAULT '1',
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `parentid` (`parentid`),
  KEY `displayorder` (`displayorder`),
  KEY `status` (`status`),
  FULLTEXT KEY `directoryindex` (`name`,`description`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_directory_categories`
--

LOCK TABLES `contrexx_module_directory_categories` WRITE;
/*!40000 ALTER TABLE `contrexx_module_directory_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_directory_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_directory_dir`
--

DROP TABLE IF EXISTS `contrexx_module_directory_dir`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_directory_dir` (
  `id` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `attachment` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `rss_file` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `rss_link` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `date` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `platform` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `language` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `relatedlinks` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `hits` int(9) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `addedby` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `validatedate` varchar(14) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `lastip` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `popular_date` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `popular_hits` int(7) NOT NULL DEFAULT '0',
  `xml_refresh` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `canton` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `searchkeys` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `company_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `street` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `zip` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `city` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `contact` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `information` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fax` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `mobile` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `mail` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `homepage` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `industry` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `legalform` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `conversion` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `employee` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `foundation` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `mwst` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `opening` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `holidays` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `places` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `logo` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `team` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `portfolio` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `offers` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `concept` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `map` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lokal` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `spezial` int(4) NOT NULL DEFAULT '0',
  `premium` int(1) NOT NULL DEFAULT '0',
  `longitude` decimal(18,15) NOT NULL DEFAULT '0.000000000000000',
  `latitude` decimal(18,15) NOT NULL DEFAULT '0.000000000000000',
  `zoom` decimal(18,15) NOT NULL DEFAULT '1.000000000000000',
  `spez_field_1` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `spez_field_2` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `spez_field_3` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `spez_field_4` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `spez_field_5` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `spez_field_6` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `spez_field_7` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `spez_field_8` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `spez_field_9` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `spez_field_10` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `spez_field_11` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `spez_field_12` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `spez_field_13` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `spez_field_14` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `spez_field_15` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `spez_field_21` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `spez_field_22` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `spez_field_16` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `spez_field_17` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `spez_field_18` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `spez_field_19` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `spez_field_20` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `spez_field_23` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `spez_field_24` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `spez_field_25` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `spez_field_26` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `spez_field_27` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `spez_field_28` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `spez_field_29` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `youtube` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `date` (`date`),
  KEY `temphitsout` (`hits`),
  KEY `status` (`status`),
  FULLTEXT KEY `name` (`title`,`description`),
  FULLTEXT KEY `description` (`description`),
  FULLTEXT KEY `title` (`title`,`description`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_directory_dir`
--

LOCK TABLES `contrexx_module_directory_dir` WRITE;
/*!40000 ALTER TABLE `contrexx_module_directory_dir` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_directory_dir` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_directory_inputfields`
--

DROP TABLE IF EXISTS `contrexx_module_directory_inputfields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_directory_inputfields` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `typ` int(2) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `active` int(1) NOT NULL DEFAULT '0',
  `active_backend` int(1) NOT NULL DEFAULT '0',
  `is_required` int(11) NOT NULL DEFAULT '0',
  `read_only` int(1) NOT NULL DEFAULT '0',
  `sort` int(5) NOT NULL DEFAULT '0',
  `exp_search` int(1) NOT NULL DEFAULT '0',
  `is_search` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_directory_inputfields`
--

LOCK TABLES `contrexx_module_directory_inputfields` WRITE;
/*!40000 ALTER TABLE `contrexx_module_directory_inputfields` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_directory_inputfields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_directory_levels`
--

DROP TABLE IF EXISTS `contrexx_module_directory_levels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_directory_levels` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `parentid` int(7) NOT NULL DEFAULT '0',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `metadesc` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `metakeys` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `displayorder` int(7) NOT NULL DEFAULT '0',
  `showlevels` int(1) NOT NULL DEFAULT '0',
  `showcategories` int(1) NOT NULL DEFAULT '0',
  `onlyentries` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `displayorder` (`displayorder`),
  KEY `parentid` (`parentid`),
  KEY `name` (`name`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_directory_levels`
--

LOCK TABLES `contrexx_module_directory_levels` WRITE;
/*!40000 ALTER TABLE `contrexx_module_directory_levels` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_directory_levels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_directory_mail`
--

DROP TABLE IF EXISTS `contrexx_module_directory_mail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_directory_mail` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_directory_mail`
--

LOCK TABLES `contrexx_module_directory_mail` WRITE;
/*!40000 ALTER TABLE `contrexx_module_directory_mail` DISABLE KEYS */;
INSERT INTO `contrexx_module_directory_mail` VALUES (1,'[[URL]] - Eintrag aufgeschaltet','Hallo [[FIRSTNAME]] [[LASTNAME]] ([[USERNAME]])\r\n\r\nDein Eintrag mit dem Titel \"[[TITLE]]\" wurde auf [[URL]] erfolgreich aufgeschaltet. \r\n\r\nBenutze folgenden Link um direkt zu Deinem Eintrag zu gelangen:\r\n[[LINK]]\r\n\r\nMit freundlichen Grüssen\r\n[[URL]] - Team\r\n\r\n[[DATE]]'),(2,'[[URL]] - Neuer Eintrag','Hallo Admin\r\n\r\nAuf [[URL]] wurde ein Eintrag aufgeschaltet oder editiert. Bitte überprüfen Sie diesen und Bestätigen Sie ihn falls nötig.\r\n\r\nEintrag Details:\r\n\r\nTitel: [[TITLE]]\r\nBenutzername: [[USERNAME]]\r\nVorname: [[FIRSTNAME]]\r\nNachname:[[LASTNAME]]\r\nLink: [[LINK]]\r\n\r\nAutomatisch generierte Nachricht\r\n[[DATE]]');
/*!40000 ALTER TABLE `contrexx_module_directory_mail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_directory_rel_dir_cat`
--

DROP TABLE IF EXISTS `contrexx_module_directory_rel_dir_cat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_directory_rel_dir_cat` (
  `dir_id` int(7) NOT NULL DEFAULT '0',
  `cat_id` int(7) NOT NULL DEFAULT '0',
  PRIMARY KEY (`dir_id`,`cat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_directory_rel_dir_cat`
--

LOCK TABLES `contrexx_module_directory_rel_dir_cat` WRITE;
/*!40000 ALTER TABLE `contrexx_module_directory_rel_dir_cat` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_directory_rel_dir_cat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_directory_rel_dir_level`
--

DROP TABLE IF EXISTS `contrexx_module_directory_rel_dir_level`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_directory_rel_dir_level` (
  `dir_id` int(7) NOT NULL DEFAULT '0',
  `level_id` int(7) NOT NULL DEFAULT '0',
  PRIMARY KEY (`dir_id`,`level_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_directory_rel_dir_level`
--

LOCK TABLES `contrexx_module_directory_rel_dir_level` WRITE;
/*!40000 ALTER TABLE `contrexx_module_directory_rel_dir_level` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_directory_rel_dir_level` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_directory_settings`
--

DROP TABLE IF EXISTS `contrexx_module_directory_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_directory_settings` (
  `setid` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `setname` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `setvalue` text COLLATE utf8_unicode_ci NOT NULL,
  `settyp` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`setid`),
  KEY `setname` (`setname`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_directory_settings`
--

LOCK TABLES `contrexx_module_directory_settings` WRITE;
/*!40000 ALTER TABLE `contrexx_module_directory_settings` DISABLE KEYS */;
INSERT INTO `contrexx_module_directory_settings` VALUES (1,'levels','0',2),(5,'xmlLimit','10',1),(6,'platform','',0),(7,'language',',Deutsch,English,Italian,French',0),(10,'latest_content','3',1),(11,'latest_xml','10',1),(12,'entryStatus','1',2),(13,'description','1',2),(14,'populardays','7',1),(16,'canton',',Aargau,Appenzell-Ausserrhoden,Appenzell-Innerrhoden,Basel-Land,\r\nBasel-Stadt,Bern,Freiburg,Genf,Glarus,Graubünden,Jura,Luzern,\r\nNeuenburg,Nidwalden,Obwalden,St. Gallen,Schaffhausen,Schwyz,\r\nSolothurn,Thurgau,Tessin,Uri,Waadt,Wallis,Zug,Zürich',0),(17,'refreshfeeds','1',1),(22,'mark_new_entrees','7',1),(23,'showConfirm','1',2),(26,'addFeed','1',2),(27,'addFeed_only_community','1',2),(28,'editFeed','1',2),(29,'editFeed_status','1',2),(30,'adminMail','',1),(31,'indexview','0',2),(32,'spez_field_21',',Germany,\r\nSwitzerland,\r\nAustria,\r\nLiechtenstein,\r\nUnited States,\r\nAlbania,\r\nAlgeria,\r\nAndorra,\r\nAngola,\r\nAnguilla,\r\nAntigua and Barbuda,\r\nArgentina,\r\nArmenia,\r\nAruba,\r\nAustralia,\r\nAzerbaijan Republic,\r\nBahamas,\r\nBahrain,\r\nBarbados,\r\nBelgium,\r\nBelize,\r\nBenin,\r\nBermuda,\r\nBhutan,\r\nBolivia,\r\nBosnia and Herzegovina,\r\nBotswana,\r\nBrazil,\r\nBritish Virgin Islands,\r\nBrunei,\r\nBulgaria,\r\nBurkina Faso,\r\nBurundi,\r\nCambodia,\r\nCanada,\r\nCape Verde,\r\nCayman Islands,\r\nChad,\r\nChile,\r\nChina Worldwide,\r\nColombia,\r\nComoros,\r\nCook Islands,\r\nCosta Rica,\r\nCroatia,\r\nCyprus,\r\nCzech Republic,\r\nDemocratic Republic of the Congo,\r\nDenmark,\r\nDjibouti,\r\nDominica,\r\nDominican Republic,\r\nEcuador,\r\nEl Salvador,\r\nEritrea,\r\nEstonia,\r\nEthiopia,\r\nFalkland Islands,\r\nFaroe Islands,\r\nFederated States of Micronesia,\r\nFiji,\r\nFinland,\r\nFrance,\r\nFrench Guiana,\r\nFrench Polynesia,\r\nGabon Republic,\r\nGambia,\r\nGibraltar,\r\nGreece,\r\nGreenland,\r\nGrenada,\r\nGuadeloupe,\r\nGuatemala,\r\nGuinea,\r\nGuinea Bissau,\r\nGuyana,\r\nHonduras,\r\nHong Kong,\r\nHungary,\r\nIceland,\r\nIndia,\r\nIndonesia,\r\nIreland,\r\nIsrael,\r\nItaly,\r\nJamaica,\r\nJapan,\r\nJordan,\r\nKazakhstan,\r\nKenya,\r\nKiribati,\r\nKuwait,\r\nKyrgyzstan,\r\nLaos,\r\nLatvia,\r\nLesotho,\r\nLithuania,\r\nLuxembourg,\r\nMadagascar,\r\nMalawi,\r\nMalaysia,\r\nMaldives,\r\nMali,\r\nMalta,\r\nMarshall Islands,\r\nMartinique,\r\nMauritania,\r\nMauritius,\r\nMayotte,\r\nMexico,\r\nMongolia,\r\nMontserrat,\r\nMorocco,\r\nMozambique,\r\nNamibia,\r\nNauru,\r\nNepal,\r\nNetherlands,\r\nNetherlands Antilles,\r\nNew Caledonia,\r\nNew Zealand,\r\nNicaragua,\r\nNiger,\r\nNiue,\r\nNorfolk Island,\r\nNorway,\r\nOman,\r\nPalau,\r\nPanama,\r\nPapua New Guinea,\r\nPeru,\r\nPhilippines,\r\nPitcairn Islands,\r\nPoland,\r\nPortugal,\r\nQatar,\r\nRepublic of the Congo,\r\nReunion,\r\nRomania,\r\nRussia,\r\nRwanda,\r\nSaint Vincent and the Grenadines,\r\nSamoa,\r\nSan Marino,\r\nSão Tomé and Príncipe,\r\nSaudi Arabia,\r\nSenegal,\r\nSeychelles,\r\nSierra Leone,\r\nSingapore,\r\nSlovakia,\r\nSlovenia,\r\nSolomon Islands,\r\nSomalia,\r\nSouth Africa,\r\nSouth Korea,\r\nSpain,\r\nSri Lanka,\r\nSt. Helena,\r\nSt. Kitts and Nevis,\r\nSt. Lucia,\r\nSt. Pierre and Miquelon,\r\nSuriname,\r\nSvalbard and Jan Mayen Islands,\r\nSwaziland,\r\nSweden,\r\nTaiwan,\r\nTajikistan,\r\nTanzania,\r\nThailand,\r\nTogo,\r\nTonga,\r\nTrinidad and Tobago,\r\nTunisia,\r\nTurkey,\r\nTurkmenistan,\r\nTurks and Caicos Islands,\r\nTuvalu,\r\nUganda,\r\nUkraine,\r\nUnited Arab Emirates,\r\nUnited Kingdom,\r\nUruguay,\r\nVanuatu,\r\nVatican City State,\r\nVenezuela,\r\nVietnam,\r\nWallis and Futuna Islands,\r\nYemen,\r\nZambia',0),(33,'spez_field_22','',0),(34,'thumbSize','120',1),(35,'sortOrder','0',2),(36,'spez_field_23','',0),(37,'spez_field_24','',0),(38,'encodeFilename','1',2),(39,'country',',Schweiz,Deutschland,Österreich,Weltweit',0),(40,'pagingLimit','4',1),(41,'youtubeWidth','20',1),(42,'youtubeHeight','300',1),(43,'youtubeWidth','400',1),(44,'youtubeHeight','300',1);
/*!40000 ALTER TABLE `contrexx_module_directory_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_directory_settings_google`
--

DROP TABLE IF EXISTS `contrexx_module_directory_settings_google`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_directory_settings_google` (
  `setid` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `setname` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `setvalue` text COLLATE utf8_unicode_ci NOT NULL,
  `settyp` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`setid`),
  KEY `setname` (`setname`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_directory_settings_google`
--

LOCK TABLES `contrexx_module_directory_settings_google` WRITE;
/*!40000 ALTER TABLE `contrexx_module_directory_settings_google` DISABLE KEYS */;
INSERT INTO `contrexx_module_directory_settings_google` VALUES (1,'googleSeach','0',2),(2,'googleResults','',1),(26,'googleId','',1),(27,'googleLang','',1);
/*!40000 ALTER TABLE `contrexx_module_directory_settings_google` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_directory_vote`
--

DROP TABLE IF EXISTS `contrexx_module_directory_vote`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_directory_vote` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `feed_id` int(7) NOT NULL DEFAULT '0',
  `vote` int(2) NOT NULL DEFAULT '0',
  `count` int(7) NOT NULL DEFAULT '0',
  `client` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `time` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_directory_vote`
--

LOCK TABLES `contrexx_module_directory_vote` WRITE;
/*!40000 ALTER TABLE `contrexx_module_directory_vote` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_directory_vote` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_docsys`
--

DROP TABLE IF EXISTS `contrexx_module_docsys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_docsys` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `date` int(14) DEFAULT NULL,
  `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `author` varchar(150) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `text` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `source` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `url1` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `url2` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `lang` int(2) unsigned NOT NULL DEFAULT '0',
  `userid` int(6) unsigned NOT NULL DEFAULT '0',
  `startdate` int(14) unsigned NOT NULL DEFAULT '0',
  `enddate` int(14) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `changelog` int(14) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `newsindex` (`title`,`text`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_docsys`
--

LOCK TABLES `contrexx_module_docsys` WRITE;
/*!40000 ALTER TABLE `contrexx_module_docsys` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_docsys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_docsys_categories`
--

DROP TABLE IF EXISTS `contrexx_module_docsys_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_docsys_categories` (
  `catid` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `lang` int(2) unsigned NOT NULL DEFAULT '1',
  `sort_style` enum('alpha','date','date_alpha') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'alpha',
  PRIMARY KEY (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_docsys_categories`
--

LOCK TABLES `contrexx_module_docsys_categories` WRITE;
/*!40000 ALTER TABLE `contrexx_module_docsys_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_docsys_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_docsys_entry_category`
--

DROP TABLE IF EXISTS `contrexx_module_docsys_entry_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_docsys_entry_category` (
  `entry` int(10) unsigned NOT NULL DEFAULT '0',
  `category` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`entry`,`category`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_docsys_entry_category`
--

LOCK TABLES `contrexx_module_docsys_entry_category` WRITE;
/*!40000 ALTER TABLE `contrexx_module_docsys_entry_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_docsys_entry_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_downloads_category`
--

DROP TABLE IF EXISTS `contrexx_module_downloads_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_downloads_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0',
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `visibility` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `owner_id` int(5) unsigned NOT NULL DEFAULT '0',
  `order` int(3) unsigned NOT NULL DEFAULT '0',
  `deletable_by_owner` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `modify_access_by_owner` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `read_access_id` int(11) unsigned NOT NULL DEFAULT '0',
  `add_subcategories_access_id` int(11) unsigned NOT NULL DEFAULT '0',
  `manage_subcategories_access_id` int(11) unsigned NOT NULL DEFAULT '0',
  `add_files_access_id` int(11) unsigned NOT NULL DEFAULT '0',
  `manage_files_access_id` int(11) unsigned NOT NULL DEFAULT '0',
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `is_active` (`is_active`),
  KEY `visibility` (`visibility`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_downloads_category`
--

LOCK TABLES `contrexx_module_downloads_category` WRITE;
/*!40000 ALTER TABLE `contrexx_module_downloads_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_downloads_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_downloads_category_locale`
--

DROP TABLE IF EXISTS `contrexx_module_downloads_category_locale`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_downloads_category_locale` (
  `lang_id` int(11) unsigned NOT NULL DEFAULT '0',
  `category_id` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`lang_id`,`category_id`),
  FULLTEXT KEY `name` (`name`),
  FULLTEXT KEY `description` (`description`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_downloads_category_locale`
--

LOCK TABLES `contrexx_module_downloads_category_locale` WRITE;
/*!40000 ALTER TABLE `contrexx_module_downloads_category_locale` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_downloads_category_locale` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_downloads_download`
--

DROP TABLE IF EXISTS `contrexx_module_downloads_download`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_downloads_download` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('file','url') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'file',
  `mime_type` enum('image','document','pdf','media','archive','application','link') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'image',
  `icon` enum('_blank','avi','bmp','css','doc','dot','exe','fla','gif','htm','html','inc','jpg','js','mp3','nfo','pdf','php','png','pps','ppt','rar','swf','txt','wma','xls','zip') COLLATE utf8_unicode_ci NOT NULL DEFAULT '_blank',
  `size` int(10) unsigned NOT NULL DEFAULT '0',
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `owner_id` int(5) unsigned NOT NULL DEFAULT '0',
  `access_id` int(10) unsigned NOT NULL DEFAULT '0',
  `license` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `version` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `author` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `website` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ctime` int(14) unsigned NOT NULL DEFAULT '0',
  `mtime` int(14) unsigned NOT NULL DEFAULT '0',
  `is_active` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `visibility` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `order` int(3) unsigned NOT NULL DEFAULT '0',
  `views` int(10) unsigned NOT NULL DEFAULT '0',
  `download_count` int(10) unsigned NOT NULL DEFAULT '0',
  `expiration` int(14) unsigned NOT NULL DEFAULT '0',
  `validity` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `is_active` (`is_active`),
  KEY `visibility` (`visibility`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_downloads_download`
--

LOCK TABLES `contrexx_module_downloads_download` WRITE;
/*!40000 ALTER TABLE `contrexx_module_downloads_download` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_downloads_download` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_downloads_download_locale`
--

DROP TABLE IF EXISTS `contrexx_module_downloads_download_locale`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_downloads_download_locale` (
  `lang_id` int(11) unsigned NOT NULL DEFAULT '0',
  `download_id` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `source` varchar(1024) COLLATE utf8_unicode_ci DEFAULT NULL,
  `source_name` varchar(1024) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `metakeys` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`lang_id`,`download_id`),
  FULLTEXT KEY `name` (`name`),
  FULLTEXT KEY `description` (`description`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_downloads_download_locale`
--

LOCK TABLES `contrexx_module_downloads_download_locale` WRITE;
/*!40000 ALTER TABLE `contrexx_module_downloads_download_locale` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_downloads_download_locale` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_downloads_group`
--

DROP TABLE IF EXISTS `contrexx_module_downloads_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_downloads_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `type` enum('file','url') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'file',
  `info_page` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_downloads_group`
--

LOCK TABLES `contrexx_module_downloads_group` WRITE;
/*!40000 ALTER TABLE `contrexx_module_downloads_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_downloads_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_downloads_group_locale`
--

DROP TABLE IF EXISTS `contrexx_module_downloads_group_locale`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_downloads_group_locale` (
  `lang_id` int(11) unsigned NOT NULL DEFAULT '0',
  `group_id` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`lang_id`,`group_id`),
  FULLTEXT KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_downloads_group_locale`
--

LOCK TABLES `contrexx_module_downloads_group_locale` WRITE;
/*!40000 ALTER TABLE `contrexx_module_downloads_group_locale` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_downloads_group_locale` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_downloads_rel_download_category`
--

DROP TABLE IF EXISTS `contrexx_module_downloads_rel_download_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_downloads_rel_download_category` (
  `download_id` int(10) unsigned NOT NULL DEFAULT '0',
  `category_id` int(10) unsigned NOT NULL DEFAULT '0',
  `order` int(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`download_id`,`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_downloads_rel_download_category`
--

LOCK TABLES `contrexx_module_downloads_rel_download_category` WRITE;
/*!40000 ALTER TABLE `contrexx_module_downloads_rel_download_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_downloads_rel_download_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_downloads_rel_download_download`
--

DROP TABLE IF EXISTS `contrexx_module_downloads_rel_download_download`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_downloads_rel_download_download` (
  `id1` int(10) unsigned NOT NULL DEFAULT '0',
  `id2` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id1`,`id2`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_downloads_rel_download_download`
--

LOCK TABLES `contrexx_module_downloads_rel_download_download` WRITE;
/*!40000 ALTER TABLE `contrexx_module_downloads_rel_download_download` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_downloads_rel_download_download` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_downloads_rel_group_category`
--

DROP TABLE IF EXISTS `contrexx_module_downloads_rel_group_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_downloads_rel_group_category` (
  `group_id` int(10) unsigned NOT NULL DEFAULT '0',
  `category_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`group_id`,`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_downloads_rel_group_category`
--

LOCK TABLES `contrexx_module_downloads_rel_group_category` WRITE;
/*!40000 ALTER TABLE `contrexx_module_downloads_rel_group_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_downloads_rel_group_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_downloads_settings`
--

DROP TABLE IF EXISTS `contrexx_module_downloads_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_downloads_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_downloads_settings`
--

LOCK TABLES `contrexx_module_downloads_settings` WRITE;
/*!40000 ALTER TABLE `contrexx_module_downloads_settings` DISABLE KEYS */;
INSERT INTO `contrexx_module_downloads_settings` VALUES (1,'overview_cols_count','2'),(2,'overview_max_subcats','5'),(3,'use_attr_size','1'),(4,'use_attr_license','1'),(5,'use_attr_version','1'),(6,'use_attr_author','1'),(7,'use_attr_website','1'),(8,'most_viewed_file_count','5'),(9,'most_downloaded_file_count','5'),(10,'most_popular_file_count','5'),(11,'newest_file_count','5'),(12,'updated_file_count','5'),(13,'new_file_time_limit','604800'),(14,'updated_file_time_limit','604800'),(15,'associate_user_to_groups',''),(16,'use_attr_metakeys','1');
/*!40000 ALTER TABLE `contrexx_module_downloads_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_ecard_ecards`
--

DROP TABLE IF EXISTS `contrexx_module_ecard_ecards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_ecard_ecards` (
  `code` varchar(35) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `date` int(10) unsigned NOT NULL DEFAULT '0',
  `TTL` int(10) unsigned NOT NULL DEFAULT '0',
  `salutation` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `senderName` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `senderEmail` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `recipientName` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `recipientEmail` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_ecard_ecards`
--

LOCK TABLES `contrexx_module_ecard_ecards` WRITE;
/*!40000 ALTER TABLE `contrexx_module_ecard_ecards` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_ecard_ecards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_ecard_settings`
--

DROP TABLE IF EXISTS `contrexx_module_ecard_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_ecard_settings` (
  `setting_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `setting_value` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`setting_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_ecard_settings`
--

LOCK TABLES `contrexx_module_ecard_settings` WRITE;
/*!40000 ALTER TABLE `contrexx_module_ecard_settings` DISABLE KEYS */;
INSERT INTO `contrexx_module_ecard_settings` VALUES ('emailText','[[ECARD_SENDER_NAME]] hat Ihnen eine E-Card geschickt.<br />\r\nSie können diese während den nächsten [[ECARD_VALID_DAYS]] Tagen unter [[ECARD_URL]] abrufen.'),('maxCharacters','100'),('maxHeight','300'),('maxHeightThumb','80'),('maxLines','50'),('maxWidth','300'),('maxWidthThumb','80'),('motive_0','Bild_001.jpg'),('motive_1','Bild_002.jpg'),('motive_2',''),('motive_3',''),('motive_4',''),('motive_5',''),('motive_6',''),('motive_7',''),('motive_8',''),('subject','Sie haben eine E-Card erhalten!'),('validdays','30');
/*!40000 ALTER TABLE `contrexx_module_ecard_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_egov_configuration`
--

DROP TABLE IF EXISTS `contrexx_module_egov_configuration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_egov_configuration` (
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_egov_configuration`
--

LOCK TABLES `contrexx_module_egov_configuration` WRITE;
/*!40000 ALTER TABLE `contrexx_module_egov_configuration` DISABLE KEYS */;
INSERT INTO `contrexx_module_egov_configuration` VALUES ('set_calendar_background','#FFFFFFF'),('set_calendar_border','#C9C9C9'),('set_calendar_color_1','#D5FFDA'),('set_calendar_color_2','#F7FFB4'),('set_calendar_color_3','#FFAEAE'),('set_calendar_date_desc','(Das Datum wird durch das Anklicken im Kalender übernommen.)'),('set_calendar_date_label','Reservieren für das ausgewählte Datum'),('set_calendar_legende_1','Freie Tage'),('set_calendar_legende_2','Teilweise reserviert'),('set_calendar_legende_3','Reserviert'),('set_orderentry_email','Diese Daten wurden eingegeben:\r\n\r\n[[ORDER_VALUE]]\r\n'),('set_orderentry_name','Contrexx Demo Webseite'),('set_orderentry_recipient','info@example.com'),('set_orderentry_sender','info@example.com'),('set_orderentry_subject','Bestellung/Anfrage für [[PRODUCT_NAME]] eingegangen'),('set_paypal_currency','CHF'),('set_paypal_email','demo'),('set_paypal_ipn','1'),('set_recipient_email',''),('set_sender_email','info@example.com'),('set_sender_name','Contrexx Demo'),('set_state_email','Guten Tag\r\n\r\nHerzlichen Dank für Ihren Besuch bei der Contrexx Demo Webseite.\r\nIhre Bestellung/Anfrage wurde bearbeitet. Falls es sich um ein Download Produkt handelt, finden Sie ihre Bestellung im Anhang.\r\n\r\nIhre Angaben:\r\n[[ORDER_VALUE]]\r\n\r\nFreundliche Grüsse\r\nIhr Online-Team'),('set_state_subject','Bestellung/Anfrage: [[PRODUCT_NAME]]');
/*!40000 ALTER TABLE `contrexx_module_egov_configuration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_egov_orders`
--

DROP TABLE IF EXISTS `contrexx_module_egov_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_egov_orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `order_ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `order_product` int(11) NOT NULL DEFAULT '0',
  `order_values` text COLLATE utf8_unicode_ci NOT NULL,
  `order_state` tinyint(4) NOT NULL DEFAULT '0',
  `order_quant` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`order_id`),
  KEY `order_product` (`order_product`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_egov_orders`
--

LOCK TABLES `contrexx_module_egov_orders` WRITE;
/*!40000 ALTER TABLE `contrexx_module_egov_orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_egov_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_egov_product_calendar`
--

DROP TABLE IF EXISTS `contrexx_module_egov_product_calendar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_egov_product_calendar` (
  `calendar_id` int(11) NOT NULL AUTO_INCREMENT,
  `calendar_product` int(11) NOT NULL DEFAULT '0',
  `calendar_order` int(11) NOT NULL DEFAULT '0',
  `calendar_day` int(2) NOT NULL DEFAULT '0',
  `calendar_month` int(2) unsigned zerofill NOT NULL DEFAULT '00',
  `calendar_year` int(4) NOT NULL DEFAULT '0',
  `calendar_act` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`calendar_id`),
  KEY `calendar_product` (`calendar_product`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_egov_product_calendar`
--

LOCK TABLES `contrexx_module_egov_product_calendar` WRITE;
/*!40000 ALTER TABLE `contrexx_module_egov_product_calendar` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_egov_product_calendar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_egov_product_fields`
--

DROP TABLE IF EXISTS `contrexx_module_egov_product_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_egov_product_fields` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `type` enum('text','label','checkbox','checkboxGroup','file','hidden','password','radio','select','textarea') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'text',
  `attributes` text COLLATE utf8_unicode_ci NOT NULL,
  `is_required` set('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `check_type` int(3) NOT NULL DEFAULT '1',
  `order_id` int(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `product` (`product`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_egov_product_fields`
--

LOCK TABLES `contrexx_module_egov_product_fields` WRITE;
/*!40000 ALTER TABLE `contrexx_module_egov_product_fields` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_egov_product_fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_egov_products`
--

DROP TABLE IF EXISTS `contrexx_module_egov_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_egov_products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_autostatus` tinyint(1) NOT NULL DEFAULT '0',
  `product_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `product_desc` text COLLATE utf8_unicode_ci NOT NULL,
  `product_price` decimal(11,2) NOT NULL DEFAULT '0.00',
  `product_per_day` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `product_quantity` tinyint(2) NOT NULL DEFAULT '0',
  `product_quantity_limit` tinyint(2) unsigned NOT NULL DEFAULT '1',
  `product_target_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `product_target_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `product_message` text COLLATE utf8_unicode_ci NOT NULL,
  `product_status` tinyint(1) NOT NULL DEFAULT '1',
  `product_electro` tinyint(1) NOT NULL DEFAULT '0',
  `product_file` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `product_sender_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `product_sender_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `product_target_subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_target_body` text COLLATE utf8_unicode_ci NOT NULL,
  `product_paypal` tinyint(1) NOT NULL DEFAULT '0',
  `product_paypal_sandbox` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `product_paypal_currency` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `product_orderby` int(11) NOT NULL DEFAULT '0',
  `yellowpay` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `alternative_names` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_egov_products`
--

LOCK TABLES `contrexx_module_egov_products` WRITE;
/*!40000 ALTER TABLE `contrexx_module_egov_products` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_egov_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_egov_settings`
--

DROP TABLE IF EXISTS `contrexx_module_egov_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_egov_settings` (
  `set_id` int(11) NOT NULL DEFAULT '0',
  `set_sender_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `set_sender_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `set_recipient_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `set_state_subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `set_state_email` text COLLATE utf8_unicode_ci NOT NULL,
  `set_calendar_color_1` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `set_calendar_color_2` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `set_calendar_color_3` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `set_calendar_legende_1` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `set_calendar_legende_2` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `set_calendar_legende_3` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `set_calendar_background` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `set_calendar_border` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `set_calendar_date_label` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `set_calendar_date_desc` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `set_orderentry_subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `set_orderentry_email` text COLLATE utf8_unicode_ci NOT NULL,
  `set_orderentry_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `set_orderentry_sender` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `set_orderentry_recipient` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `set_paypal_email` text COLLATE utf8_unicode_ci NOT NULL,
  `set_paypal_currency` text COLLATE utf8_unicode_ci NOT NULL,
  `set_paypal_ipn` tinyint(1) NOT NULL DEFAULT '0',
  KEY `set_id` (`set_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_egov_settings`
--

LOCK TABLES `contrexx_module_egov_settings` WRITE;
/*!40000 ALTER TABLE `contrexx_module_egov_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_egov_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_feed_category`
--

DROP TABLE IF EXISTS `contrexx_module_feed_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_feed_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `status` int(1) NOT NULL DEFAULT '1',
  `time` int(100) NOT NULL DEFAULT '0',
  `lang` int(1) NOT NULL DEFAULT '0',
  `pos` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_feed_category`
--

LOCK TABLES `contrexx_module_feed_category` WRITE;
/*!40000 ALTER TABLE `contrexx_module_feed_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_feed_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_feed_news`
--

DROP TABLE IF EXISTS `contrexx_module_feed_news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_feed_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `link` varchar(150) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `filename` varchar(150) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `articles` int(2) NOT NULL DEFAULT '0',
  `cache` int(4) NOT NULL DEFAULT '3600',
  `time` int(100) NOT NULL DEFAULT '0',
  `image` int(1) NOT NULL DEFAULT '1',
  `status` int(1) NOT NULL DEFAULT '1',
  `pos` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_feed_news`
--

LOCK TABLES `contrexx_module_feed_news` WRITE;
/*!40000 ALTER TABLE `contrexx_module_feed_news` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_feed_news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_feed_newsml_association`
--

DROP TABLE IF EXISTS `contrexx_module_feed_newsml_association`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_feed_newsml_association` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pId_master` text COLLATE utf8_unicode_ci NOT NULL,
  `pId_slave` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_feed_newsml_association`
--

LOCK TABLES `contrexx_module_feed_newsml_association` WRITE;
/*!40000 ALTER TABLE `contrexx_module_feed_newsml_association` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_feed_newsml_association` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_feed_newsml_categories`
--

DROP TABLE IF EXISTS `contrexx_module_feed_newsml_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_feed_newsml_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `providerId` text COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `subjectCodes` text COLLATE utf8_unicode_ci NOT NULL,
  `showSubjectCodes` enum('all','only','exclude') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'all',
  `template` text COLLATE utf8_unicode_ci NOT NULL,
  `limit` smallint(6) NOT NULL DEFAULT '0',
  `showPics` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `auto_update` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_feed_newsml_categories`
--

LOCK TABLES `contrexx_module_feed_newsml_categories` WRITE;
/*!40000 ALTER TABLE `contrexx_module_feed_newsml_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_feed_newsml_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_feed_newsml_documents`
--

DROP TABLE IF EXISTS `contrexx_module_feed_newsml_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_feed_newsml_documents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `publicIdentifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `providerId` text COLLATE utf8_unicode_ci NOT NULL,
  `dateId` int(8) unsigned NOT NULL DEFAULT '0',
  `newsItemId` text COLLATE utf8_unicode_ci NOT NULL,
  `revisionId` int(5) unsigned NOT NULL DEFAULT '0',
  `thisRevisionDate` int(14) NOT NULL DEFAULT '0',
  `urgency` smallint(5) unsigned NOT NULL DEFAULT '0',
  `subjectCode` int(10) unsigned NOT NULL DEFAULT '0',
  `headLine` varchar(67) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dataContent` text COLLATE utf8_unicode_ci NOT NULL,
  `is_associated` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `media_type` enum('Text','Graphic','Photo','Audio','Video','ComplexData') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Text',
  `source` text COLLATE utf8_unicode_ci NOT NULL,
  `properties` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`publicIdentifier`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_feed_newsml_documents`
--

LOCK TABLES `contrexx_module_feed_newsml_documents` WRITE;
/*!40000 ALTER TABLE `contrexx_module_feed_newsml_documents` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_feed_newsml_documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_feed_newsml_providers`
--

DROP TABLE IF EXISTS `contrexx_module_feed_newsml_providers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_feed_newsml_providers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `providerId` text COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `path` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_feed_newsml_providers`
--

LOCK TABLES `contrexx_module_feed_newsml_providers` WRITE;
/*!40000 ALTER TABLE `contrexx_module_feed_newsml_providers` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_feed_newsml_providers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_filesharing`
--

DROP TABLE IF EXISTS `contrexx_module_filesharing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_filesharing` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `file` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `source` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `cmd` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `hash` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `check` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `expiration_date` timestamp NULL DEFAULT NULL,
  `upload_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_filesharing`
--

LOCK TABLES `contrexx_module_filesharing` WRITE;
/*!40000 ALTER TABLE `contrexx_module_filesharing` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_filesharing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_filesharing_mail_template`
--

DROP TABLE IF EXISTS `contrexx_module_filesharing_mail_template`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_filesharing_mail_template` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `lang_id` int(1) NOT NULL,
  `subject` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_filesharing_mail_template`
--

LOCK TABLES `contrexx_module_filesharing_mail_template` WRITE;
/*!40000 ALTER TABLE `contrexx_module_filesharing_mail_template` DISABLE KEYS */;
INSERT INTO `contrexx_module_filesharing_mail_template` VALUES (1,1,'Jemand teilt eine Datei mit Ihnen','Guten Tag,\r\n\r\nJemand hat auf [[DOMAIN]] eine Datei mit Ihnen geteilt.\r\n\r\n<!-- BEGIN filesharing_file -->\r\nDownload-Link: [[FILE_DOWNLOAD]]\r\n<!-- END filesharing_file -->\r\n\r\nDie Person hat eine Nachricht hinterlassen:\r\n[[MESSAGE]]\r\n\r\nFreundliche Grüsse'),(2,2,'Somebody is sharing a file with you','Hi,\r\n\r\nSomebody shared a file with you on [[DOMAIN]].\r\n\r\n<!-- BEGIN filesharing_file -->\r\nDownload link: [[FILE_DOWNLOAD]]\r\n<!-- END filesharing_file -->\r\n\r\nThe person has left a message for you:\r\n[[MESSAGE]]\r\n\r\nBest regards');
/*!40000 ALTER TABLE `contrexx_module_filesharing_mail_template` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_forum_access`
--

DROP TABLE IF EXISTS `contrexx_module_forum_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_forum_access` (
  `category_id` int(5) unsigned NOT NULL DEFAULT '0',
  `group_id` int(5) unsigned NOT NULL DEFAULT '0',
  `read` set('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `write` set('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `edit` set('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `delete` set('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `move` set('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `close` set('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `sticky` set('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`category_id`,`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_forum_access`
--

LOCK TABLES `contrexx_module_forum_access` WRITE;
/*!40000 ALTER TABLE `contrexx_module_forum_access` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_forum_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_forum_categories`
--

DROP TABLE IF EXISTS `contrexx_module_forum_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_forum_categories` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(5) unsigned NOT NULL DEFAULT '0',
  `order_id` int(5) unsigned NOT NULL DEFAULT '0',
  `status` set('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_forum_categories`
--

LOCK TABLES `contrexx_module_forum_categories` WRITE;
/*!40000 ALTER TABLE `contrexx_module_forum_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_forum_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_forum_categories_lang`
--

DROP TABLE IF EXISTS `contrexx_module_forum_categories_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_forum_categories_lang` (
  `category_id` int(5) unsigned NOT NULL DEFAULT '0',
  `lang_id` int(5) unsigned NOT NULL DEFAULT '0',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`category_id`,`lang_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_forum_categories_lang`
--

LOCK TABLES `contrexx_module_forum_categories_lang` WRITE;
/*!40000 ALTER TABLE `contrexx_module_forum_categories_lang` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_forum_categories_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_forum_notification`
--

DROP TABLE IF EXISTS `contrexx_module_forum_notification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_forum_notification` (
  `category_id` int(10) unsigned NOT NULL DEFAULT '0',
  `thread_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` int(5) unsigned NOT NULL DEFAULT '0',
  `is_notified` set('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`category_id`,`thread_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_forum_notification`
--

LOCK TABLES `contrexx_module_forum_notification` WRITE;
/*!40000 ALTER TABLE `contrexx_module_forum_notification` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_forum_notification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_forum_postings`
--

DROP TABLE IF EXISTS `contrexx_module_forum_postings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_forum_postings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(5) unsigned NOT NULL DEFAULT '0',
  `thread_id` int(10) unsigned NOT NULL DEFAULT '0',
  `prev_post_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` int(5) unsigned NOT NULL DEFAULT '0',
  `time_created` int(14) unsigned NOT NULL DEFAULT '0',
  `time_edited` int(14) unsigned NOT NULL DEFAULT '0',
  `is_locked` set('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `is_sticky` set('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `rating` int(11) NOT NULL DEFAULT '0',
  `views` int(10) unsigned NOT NULL DEFAULT '0',
  `icon` smallint(5) unsigned NOT NULL DEFAULT '0',
  `keywords` text COLLATE utf8_unicode_ci NOT NULL,
  `subject` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `attachment` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`,`thread_id`,`prev_post_id`,`user_id`),
  FULLTEXT KEY `fulltext` (`keywords`,`subject`,`content`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_forum_postings`
--

LOCK TABLES `contrexx_module_forum_postings` WRITE;
/*!40000 ALTER TABLE `contrexx_module_forum_postings` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_forum_postings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_forum_rating`
--

DROP TABLE IF EXISTS `contrexx_module_forum_rating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_forum_rating` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `post_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_forum_rating`
--

LOCK TABLES `contrexx_module_forum_rating` WRITE;
/*!40000 ALTER TABLE `contrexx_module_forum_rating` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_forum_rating` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_forum_settings`
--

DROP TABLE IF EXISTS `contrexx_module_forum_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_forum_settings` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_forum_settings`
--

LOCK TABLES `contrexx_module_forum_settings` WRITE;
/*!40000 ALTER TABLE `contrexx_module_forum_settings` DISABLE KEYS */;
INSERT INTO `contrexx_module_forum_settings` VALUES (1,'thread_paging','10'),(2,'posting_paging','10'),(3,'latest_entries_count','5'),(4,'block_template','<div id=\"forum\">    \r\n         <div class=\"div_board\">\r\n	         <div class=\"div_title\">[[TXT_FORUM_LATEST_ENTRIES]]</div>\r\n		<table cellspacing=\"0\" cellpadding=\"0\">\r\n			<tr class=\"row3\">\r\n				<th width=\"65%\" style=\"text-align: left;\">[[TXT_FORUM_THREAD]]</th>\r\n				<th width=\"15%\" style=\"text-align: left;\">[[TXT_FORUM_OVERVIEW_FORUM]]</th>		\r\n				<th width=\"15%\" style=\"text-align: left;\">[[TXT_FORUM_THREAD_STRATER]]</th>		\r\n				<th width=\"1%\" style=\"text-align: left;\">[[TXT_FORUM_POST_COUNT]]</th>		\r\n				<th width=\"4%\" style=\"text-align: left;\">[[TXT_FORUM_THREAD_CREATE_DATE]]</th>\r\n			</tr>\r\n			<!-- BEGIN latestPosts -->\r\n			<tr class=\"row_[[FORUM_ROWCLASS]]\">\r\n				<td>[[FORUM_THREAD]]</td>\r\n				<td>[[FORUM_FORUM_NAME]]</td>\r\n				<td>[[FORUM_THREAD_STARTER]]</td>\r\n				<td>[[FORUM_POST_COUNT]]</td>\r\n				<td>[[FORUM_THREAD_CREATE_DATE]]</td>\r\n			</tr>	\r\n			<!-- END latestPosts -->	\r\n		</table>\r\n	</div>\r\n</div>'),(5,'notification_template','[[FORUM_USERNAME]],\r\n\r\nEs wurde ein neuer Beitrag im Thema \\\"[[FORUM_THREAD_SUBJECT]]\\\", gestartet \r\nvon \\\"[[FORUM_THREAD_STARTER]]\\\", geschrieben.\r\n\r\nDer neue Beitrag umfasst folgenden Inhalt:\r\n\r\n-----------------NACHRICHT START-----------------\r\n-----Betreff-----\r\n[[FORUM_LATEST_SUBJECT]]\r\n\r\n----Nachricht----\r\n[[FORUM_LATEST_MESSAGE]]\r\n-----------------NACHRICHT ENDE------------------\r\n\r\nUm den ganzen Diskussionsverlauf zu sehen oder zur Abmeldung dieser \r\nBenachrichtigung, besuchen Sie folgenden Link:\r\n[[FORUM_THREAD_URL]]\r\n'),(6,'notification_subject','Neuer Beitrag in \\\"[[FORUM_THREAD_SUBJECT]]\\\"'),(7,'notification_from_email','noreply@example.com'),(8,'notification_from_name','nobody'),(9,'banned_words','penis enlargement,free porn,(?i:buy\\\\s*?(?:cheap\\\\s*?)?viagra)'),(10,'wysiwyg_editor','1'),(11,'tag_count','1'),(12,'latest_post_per_thread','0'),(13,'allowed_extensions','7z,aiff,asf,avi,bmp,csv,doc,fla,flv,gif,gz,gzip,jpeg,jpg,mid,mov,mp3,mp4,mpc,mpeg,mpg,ods,odt,pdf,png,ppt,pxd,qt,ram,rar,rm,rmi,rmvb,rtf,sdc,sitd,swf,sxc,sxw,tar,tgz,tif,tiff,txt,vsd,wav,wma,wmv,xls,xml,zip');
/*!40000 ALTER TABLE `contrexx_module_forum_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_forum_statistics`
--

DROP TABLE IF EXISTS `contrexx_module_forum_statistics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_forum_statistics` (
  `category_id` int(5) unsigned NOT NULL DEFAULT '0',
  `thread_count` int(10) unsigned NOT NULL DEFAULT '0',
  `post_count` int(10) unsigned NOT NULL DEFAULT '0',
  `last_post_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_forum_statistics`
--

LOCK TABLES `contrexx_module_forum_statistics` WRITE;
/*!40000 ALTER TABLE `contrexx_module_forum_statistics` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_forum_statistics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_gallery_categories`
--

DROP TABLE IF EXISTS `contrexx_module_gallery_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_gallery_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `sorting` int(6) NOT NULL DEFAULT '0',
  `status` set('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `comment` set('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `voting` set('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `backendProtected` int(11) NOT NULL DEFAULT '0',
  `backend_access_id` int(11) NOT NULL DEFAULT '0',
  `frontendProtected` int(11) NOT NULL DEFAULT '0',
  `frontend_access_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_gallery_categories`
--

LOCK TABLES `contrexx_module_gallery_categories` WRITE;
/*!40000 ALTER TABLE `contrexx_module_gallery_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_gallery_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_gallery_comments`
--

DROP TABLE IF EXISTS `contrexx_module_gallery_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_gallery_comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `picid` int(10) unsigned NOT NULL DEFAULT '0',
  `date` int(14) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `www` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_gallery_comments`
--

LOCK TABLES `contrexx_module_gallery_comments` WRITE;
/*!40000 ALTER TABLE `contrexx_module_gallery_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_gallery_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_gallery_language`
--

DROP TABLE IF EXISTS `contrexx_module_gallery_language`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_gallery_language` (
  `gallery_id` int(10) unsigned NOT NULL DEFAULT '0',
  `lang_id` int(10) unsigned NOT NULL DEFAULT '0',
  `name` set('name','desc') COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`gallery_id`,`lang_id`,`name`),
  FULLTEXT KEY `galleryindex` (`value`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_gallery_language`
--

LOCK TABLES `contrexx_module_gallery_language` WRITE;
/*!40000 ALTER TABLE `contrexx_module_gallery_language` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_gallery_language` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_gallery_language_pics`
--

DROP TABLE IF EXISTS `contrexx_module_gallery_language_pics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_gallery_language_pics` (
  `picture_id` int(10) unsigned NOT NULL DEFAULT '0',
  `lang_id` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `desc` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`picture_id`,`lang_id`),
  FULLTEXT KEY `galleryindex` (`name`,`desc`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_gallery_language_pics`
--

LOCK TABLES `contrexx_module_gallery_language_pics` WRITE;
/*!40000 ALTER TABLE `contrexx_module_gallery_language_pics` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_gallery_language_pics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_gallery_pictures`
--

DROP TABLE IF EXISTS `contrexx_module_gallery_pictures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_gallery_pictures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `catid` int(11) NOT NULL DEFAULT '0',
  `validated` set('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `status` set('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `catimg` set('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `sorting` int(6) unsigned NOT NULL DEFAULT '999',
  `size_show` set('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `path` text COLLATE utf8_unicode_ci NOT NULL,
  `link` text COLLATE utf8_unicode_ci NOT NULL,
  `lastedit` int(14) NOT NULL DEFAULT '0',
  `size_type` set('abs','proz') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'proz',
  `size_proz` int(3) NOT NULL DEFAULT '0',
  `size_abs_h` int(11) NOT NULL DEFAULT '0',
  `size_abs_w` int(11) NOT NULL DEFAULT '0',
  `quality` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `galleryPicturesIndex` (`path`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_gallery_pictures`
--

LOCK TABLES `contrexx_module_gallery_pictures` WRITE;
/*!40000 ALTER TABLE `contrexx_module_gallery_pictures` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_gallery_pictures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_gallery_settings`
--

DROP TABLE IF EXISTS `contrexx_module_gallery_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_gallery_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_gallery_settings`
--

LOCK TABLES `contrexx_module_gallery_settings` WRITE;
/*!40000 ALTER TABLE `contrexx_module_gallery_settings` DISABLE KEYS */;
INSERT INTO `contrexx_module_gallery_settings` VALUES (1,'max_images_upload','10'),(2,'standard_quality','95'),(3,'standard_size_proz','25'),(4,'standard_width_abs','274'),(6,'standard_height_abs','0'),(7,'standard_size_type','abs'),(8,'validation_show_limit','10'),(9,'validation_standard_type','all'),(11,'show_names','on'),(12,'quality','95'),(13,'show_comments','off'),(14,'show_voting','off'),(15,'enable_popups','on'),(16,'image_width','4000'),(17,'paging','30'),(18,'show_latest','on'),(19,'show_random','on'),(20,'header_type','hierarchy'),(21,'show_ext','on'),(22,'show_file_name','off'),(23,'slide_show','slideshow'),(24,'slide_show_seconds','3');
/*!40000 ALTER TABLE `contrexx_module_gallery_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_gallery_votes`
--

DROP TABLE IF EXISTS `contrexx_module_gallery_votes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_gallery_votes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `picid` int(10) unsigned NOT NULL DEFAULT '0',
  `date` int(14) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `md5` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `mark` int(2) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_gallery_votes`
--

LOCK TABLES `contrexx_module_gallery_votes` WRITE;
/*!40000 ALTER TABLE `contrexx_module_gallery_votes` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_gallery_votes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_guestbook`
--

DROP TABLE IF EXISTS `contrexx_module_guestbook`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_guestbook` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `forename` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `gender` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `url` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `email` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `location` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `lang_id` tinyint(2) NOT NULL DEFAULT '1',
  `datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `comment` (`comment`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_guestbook`
--

LOCK TABLES `contrexx_module_guestbook` WRITE;
/*!40000 ALTER TABLE `contrexx_module_guestbook` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_guestbook` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_guestbook_settings`
--

DROP TABLE IF EXISTS `contrexx_module_guestbook_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_guestbook_settings` (
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `value` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_guestbook_settings`
--

LOCK TABLES `contrexx_module_guestbook_settings` WRITE;
/*!40000 ALTER TABLE `contrexx_module_guestbook_settings` DISABLE KEYS */;
INSERT INTO `contrexx_module_guestbook_settings` VALUES ('guestbook_send_notification_email','0'),('guestbook_activate_submitted_entries','0'),('guestbook_replace_at','1'),('guestbook_only_lang_entries','0');
/*!40000 ALTER TABLE `contrexx_module_guestbook_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_jobs`
--

DROP TABLE IF EXISTS `contrexx_module_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_jobs` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `date` int(14) DEFAULT NULL,
  `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `author` varchar(150) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `text` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `workloc` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `workload` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `work_start` int(14) NOT NULL DEFAULT '0',
  `catid` int(2) unsigned NOT NULL DEFAULT '0',
  `lang` int(2) unsigned NOT NULL DEFAULT '0',
  `userid` int(6) unsigned NOT NULL DEFAULT '0',
  `startdate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `enddate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `changelog` int(14) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `newsindex` (`title`,`text`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_jobs`
--

LOCK TABLES `contrexx_module_jobs` WRITE;
/*!40000 ALTER TABLE `contrexx_module_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_jobs_categories`
--

DROP TABLE IF EXISTS `contrexx_module_jobs_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_jobs_categories` (
  `catid` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `lang` int(2) unsigned NOT NULL DEFAULT '1',
  `sort_style` enum('alpha','date','date_alpha') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'alpha',
  PRIMARY KEY (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_jobs_categories`
--

LOCK TABLES `contrexx_module_jobs_categories` WRITE;
/*!40000 ALTER TABLE `contrexx_module_jobs_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_jobs_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_jobs_location`
--

DROP TABLE IF EXISTS `contrexx_module_jobs_location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_jobs_location` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_jobs_location`
--

LOCK TABLES `contrexx_module_jobs_location` WRITE;
/*!40000 ALTER TABLE `contrexx_module_jobs_location` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_jobs_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_jobs_rel_loc_jobs`
--

DROP TABLE IF EXISTS `contrexx_module_jobs_rel_loc_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_jobs_rel_loc_jobs` (
  `job` int(10) unsigned NOT NULL DEFAULT '0',
  `location` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`job`,`location`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_jobs_rel_loc_jobs`
--

LOCK TABLES `contrexx_module_jobs_rel_loc_jobs` WRITE;
/*!40000 ALTER TABLE `contrexx_module_jobs_rel_loc_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_jobs_rel_loc_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_jobs_settings`
--

DROP TABLE IF EXISTS `contrexx_module_jobs_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_jobs_settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_jobs_settings`
--

LOCK TABLES `contrexx_module_jobs_settings` WRITE;
/*!40000 ALTER TABLE `contrexx_module_jobs_settings` DISABLE KEYS */;
INSERT INTO `contrexx_module_jobs_settings` VALUES (1,'footnote','Hat Ihnen diese Bewerbung zugesagt? \r\nDann können Sie sich sogleich telefonisch, per E-mail oder Web Formular bewerben.'),(2,'link','Online für diese Stelle bewerben.'),(3,'url','index.php?section=contact&cmd=5&44=%URL%&43=%TITLE%'),(4,'show_location_fe','1');
/*!40000 ALTER TABLE `contrexx_module_jobs_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_knowledge_article_content`
--

DROP TABLE IF EXISTS `contrexx_module_knowledge_article_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_knowledge_article_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `article` int(10) unsigned NOT NULL DEFAULT '0',
  `lang` int(10) unsigned NOT NULL DEFAULT '0',
  `question` text COLLATE utf8_unicode_ci NOT NULL,
  `answer` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `module_knowledge_article_content_lang` (`lang`),
  KEY `module_knowledge_article_content_article` (`article`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_knowledge_article_content`
--

LOCK TABLES `contrexx_module_knowledge_article_content` WRITE;
/*!40000 ALTER TABLE `contrexx_module_knowledge_article_content` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_knowledge_article_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_knowledge_articles`
--

DROP TABLE IF EXISTS `contrexx_module_knowledge_articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_knowledge_articles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category` int(10) unsigned NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `hits` int(11) NOT NULL DEFAULT '0',
  `votes` int(11) NOT NULL DEFAULT '0',
  `votevalue` int(11) NOT NULL DEFAULT '0',
  `sort` int(11) NOT NULL DEFAULT '0',
  `date_created` int(14) NOT NULL DEFAULT '0',
  `date_updated` int(14) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_knowledge_articles`
--

LOCK TABLES `contrexx_module_knowledge_articles` WRITE;
/*!40000 ALTER TABLE `contrexx_module_knowledge_articles` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_knowledge_articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_knowledge_categories`
--

DROP TABLE IF EXISTS `contrexx_module_knowledge_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_knowledge_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `parent` int(10) unsigned NOT NULL DEFAULT '0',
  `sort` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `module_knowledge_categories_sort` (`sort`),
  KEY `module_knowledge_categories_parent` (`parent`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_knowledge_categories`
--

LOCK TABLES `contrexx_module_knowledge_categories` WRITE;
/*!40000 ALTER TABLE `contrexx_module_knowledge_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_knowledge_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_knowledge_categories_content`
--

DROP TABLE IF EXISTS `contrexx_module_knowledge_categories_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_knowledge_categories_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `lang` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_knowledge_categories_content`
--

LOCK TABLES `contrexx_module_knowledge_categories_content` WRITE;
/*!40000 ALTER TABLE `contrexx_module_knowledge_categories_content` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_knowledge_categories_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_knowledge_settings`
--

DROP TABLE IF EXISTS `contrexx_module_knowledge_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_knowledge_settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `module_knowledge_settings_name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_knowledge_settings`
--

LOCK TABLES `contrexx_module_knowledge_settings` WRITE;
/*!40000 ALTER TABLE `contrexx_module_knowledge_settings` DISABLE KEYS */;
INSERT INTO `contrexx_module_knowledge_settings` VALUES (1,'max_subcategories','5'),(2,'column_number','2'),(3,'max_rating','8'),(6,'best_rated_sidebar_template','<div class=\"clearfix\">\r\n<ul class=\"knowledge_sidebar\">\r\n<!-- BEGIN article -->\r\n<li><a href=\"[[URL]]\">[[ARTICLE]]</a></li>\r\n<!-- END article -->\r\n</ul>\r\n</div>'),(7,'best_rated_sidebar_length','82'),(8,'best_rated_sidebar_amount','5'),(9,'tag_cloud_sidebar_template','[[CLOUD]] <br style=\"clear: both;\" />'),(10,'most_read_sidebar_template','<div class=\"clearfix\">\r\n<ul class=\"knowledge_sidebar\">\r\n<!-- BEGIN article -->\r\n<li><a href=\"[[URL]]\">[[ARTICLE]]</a></li>\r\n<!-- END article -->\r\n</ul>\r\n</div>'),(12,'most_read_sidebar_length','79'),(13,'most_read_sidebar_amount','5'),(14,'best_rated_siderbar_template',''),(15,'most_read_amount','5'),(16,'best_rated_amount','5');
/*!40000 ALTER TABLE `contrexx_module_knowledge_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_knowledge_tags`
--

DROP TABLE IF EXISTS `contrexx_module_knowledge_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_knowledge_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `lang` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `module_knowledge_tags_name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_knowledge_tags`
--

LOCK TABLES `contrexx_module_knowledge_tags` WRITE;
/*!40000 ALTER TABLE `contrexx_module_knowledge_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_knowledge_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_knowledge_tags_articles`
--

DROP TABLE IF EXISTS `contrexx_module_knowledge_tags_articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_knowledge_tags_articles` (
  `article` int(10) unsigned NOT NULL DEFAULT '0',
  `tag` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `article` (`article`,`tag`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_knowledge_tags_articles`
--

LOCK TABLES `contrexx_module_knowledge_tags_articles` WRITE;
/*!40000 ALTER TABLE `contrexx_module_knowledge_tags_articles` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_knowledge_tags_articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_livecam`
--

DROP TABLE IF EXISTS `contrexx_module_livecam`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_livecam` (
  `id` int(10) unsigned NOT NULL DEFAULT '1',
  `currentImagePath` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '/webcam/cam1/current.jpg',
  `archivePath` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '/webcam/cam1/archive/',
  `thumbnailPath` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '/webcam/cam1/thumbs/',
  `maxImageWidth` int(10) unsigned NOT NULL DEFAULT '400',
  `thumbMaxSize` int(10) unsigned NOT NULL DEFAULT '200',
  `shadowboxActivate` set('1','0') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `showFrom` int(14) NOT NULL DEFAULT '0',
  `showTill` int(14) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_livecam`
--

LOCK TABLES `contrexx_module_livecam` WRITE;
/*!40000 ALTER TABLE `contrexx_module_livecam` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_livecam` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_livecam_settings`
--

DROP TABLE IF EXISTS `contrexx_module_livecam_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_livecam_settings` (
  `setid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `setname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `setvalue` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`setid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_livecam_settings`
--

LOCK TABLES `contrexx_module_livecam_settings` WRITE;
/*!40000 ALTER TABLE `contrexx_module_livecam_settings` DISABLE KEYS */;
INSERT INTO `contrexx_module_livecam_settings` VALUES (1,'amount_of_cams','1');
/*!40000 ALTER TABLE `contrexx_module_livecam_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_market`
--

DROP TABLE IF EXISTS `contrexx_module_market`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_market` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `type` set('search','offer') COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `premium` int(1) NOT NULL DEFAULT '0',
  `picture` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `catid` int(4) NOT NULL DEFAULT '0',
  `price` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `regdate` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `enddate` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `userid` int(4) NOT NULL DEFAULT '0',
  `userdetails` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `regkey` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `paypal` int(1) NOT NULL DEFAULT '0',
  `sort_id` int(4) NOT NULL DEFAULT '0',
  `spez_field_1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `spez_field_2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `spez_field_3` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `spez_field_4` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `spez_field_5` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `description` (`description`),
  FULLTEXT KEY `title` (`description`,`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_market`
--

LOCK TABLES `contrexx_module_market` WRITE;
/*!40000 ALTER TABLE `contrexx_module_market` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_market` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_market_categories`
--

DROP TABLE IF EXISTS `contrexx_module_market_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_market_categories` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `displayorder` int(4) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_market_categories`
--

LOCK TABLES `contrexx_module_market_categories` WRITE;
/*!40000 ALTER TABLE `contrexx_module_market_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_market_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_market_mail`
--

DROP TABLE IF EXISTS `contrexx_module_market_mail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_market_mail` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `mailto` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `mailcc` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `active` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_market_mail`
--

LOCK TABLES `contrexx_module_market_mail` WRITE;
/*!40000 ALTER TABLE `contrexx_module_market_mail` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_market_mail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_market_paypal`
--

DROP TABLE IF EXISTS `contrexx_module_market_paypal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_market_paypal` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `active` int(1) NOT NULL DEFAULT '0',
  `profile` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `price` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `price_premium` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_market_paypal`
--

LOCK TABLES `contrexx_module_market_paypal` WRITE;
/*!40000 ALTER TABLE `contrexx_module_market_paypal` DISABLE KEYS */;
INSERT INTO `contrexx_module_market_paypal` VALUES (1,0,'noreply@example.com','5.00','2.00');
/*!40000 ALTER TABLE `contrexx_module_market_paypal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_market_settings`
--

DROP TABLE IF EXISTS `contrexx_module_market_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_market_settings` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `type` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_market_settings`
--

LOCK TABLES `contrexx_module_market_settings` WRITE;
/*!40000 ALTER TABLE `contrexx_module_market_settings` DISABLE KEYS */;
INSERT INTO `contrexx_module_market_settings` VALUES (1,'maxday','14','TXT_MARKET_SET_MAXDAYS',1),(2,'description','0','TXT_MARKET_SET_DESCRIPTION',2),(3,'paging','10','TXT_MARKET_SET_PAGING',1),(4,'currency','CHF','TXT_MARKET_SET_CURRENCY',1),(5,'addEntry_only_community','1','TXT_MARKET_SET_ADD_ENTRY_ONLY_COMMUNITY',2),(6,'addEntry','1','TXT_MARKET_SET_ADD_ENTRY',2),(7,'editEntry','1','TXT_MARKET_SET_EDIT_ENTRY',2),(8,'indexview','0','TXT_MARKET_SET_INDEXVIEW',2),(9,'maxdayStatus','0','TXT_MARKET_SET_MAXDAYS_ON',2),(10,'searchPrice','100,200,500,1000,2000,5000','TXT_MARKET_SET_EXP_SEARCH_PRICE',3),(11,'codeMode','1','TXT_MARKET_SET_CODE_MODE',2);
/*!40000 ALTER TABLE `contrexx_module_market_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_market_spez_fields`
--

DROP TABLE IF EXISTS `contrexx_module_market_spez_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_market_spez_fields` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(1) NOT NULL DEFAULT '1',
  `lang_id` int(2) NOT NULL DEFAULT '0',
  `active` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_market_spez_fields`
--

LOCK TABLES `contrexx_module_market_spez_fields` WRITE;
/*!40000 ALTER TABLE `contrexx_module_market_spez_fields` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_market_spez_fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_media_settings`
--

DROP TABLE IF EXISTS `contrexx_module_media_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_media_settings` (
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_media_settings`
--

LOCK TABLES `contrexx_module_media_settings` WRITE;
/*!40000 ALTER TABLE `contrexx_module_media_settings` DISABLE KEYS */;
INSERT INTO `contrexx_module_media_settings` VALUES ('media1_frontend_changable','on'),('media2_frontend_changable','off'),('media3_frontend_changable','off'),('media4_frontend_changable','off'),('media1_frontend_managable','on'),('media2_frontend_managable','off'),('media3_frontend_managable','off'),('media4_frontend_managable','off');
/*!40000 ALTER TABLE `contrexx_module_media_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_mediadir_categories`
--

DROP TABLE IF EXISTS `contrexx_module_mediadir_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_mediadir_categories` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `parent_id` int(7) NOT NULL,
  `order` int(7) NOT NULL,
  `show_subcategories` int(11) NOT NULL,
  `show_entries` int(1) NOT NULL,
  `picture` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `active` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_mediadir_categories`
--

LOCK TABLES `contrexx_module_mediadir_categories` WRITE;
/*!40000 ALTER TABLE `contrexx_module_mediadir_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_mediadir_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_mediadir_categories_names`
--

DROP TABLE IF EXISTS `contrexx_module_mediadir_categories_names`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_mediadir_categories_names` (
  `lang_id` int(1) NOT NULL,
  `category_id` int(7) NOT NULL,
  `category_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  KEY `lang_id` (`lang_id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_mediadir_categories_names`
--

LOCK TABLES `contrexx_module_mediadir_categories_names` WRITE;
/*!40000 ALTER TABLE `contrexx_module_mediadir_categories_names` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_mediadir_categories_names` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_mediadir_comments`
--

DROP TABLE IF EXISTS `contrexx_module_mediadir_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_mediadir_comments` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `entry_id` int(7) NOT NULL,
  `added_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `notification` int(1) NOT NULL DEFAULT '0',
  `comment` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_mediadir_comments`
--

LOCK TABLES `contrexx_module_mediadir_comments` WRITE;
/*!40000 ALTER TABLE `contrexx_module_mediadir_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_mediadir_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_mediadir_entries`
--

DROP TABLE IF EXISTS `contrexx_module_mediadir_entries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_mediadir_entries` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `order` int(7) NOT NULL DEFAULT '0',
  `form_id` int(7) NOT NULL,
  `create_date` int(50) NOT NULL,
  `update_date` int(50) NOT NULL,
  `validate_date` int(50) NOT NULL,
  `added_by` int(10) NOT NULL,
  `updated_by` int(10) NOT NULL,
  `lang_id` int(1) NOT NULL,
  `hits` int(10) NOT NULL,
  `popular_hits` int(10) NOT NULL,
  `popular_date` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `last_ip` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ready_to_confirm` int(1) NOT NULL DEFAULT '0',
  `confirmed` int(1) NOT NULL,
  `active` int(1) NOT NULL,
  `duration_type` int(1) NOT NULL,
  `duration_start` int(50) NOT NULL,
  `duration_end` int(50) NOT NULL,
  `duration_notification` int(1) NOT NULL,
  `translation_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lang_id` (`lang_id`),
  KEY `active` (`active`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_mediadir_entries`
--

LOCK TABLES `contrexx_module_mediadir_entries` WRITE;
/*!40000 ALTER TABLE `contrexx_module_mediadir_entries` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_mediadir_entries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_mediadir_form_names`
--

DROP TABLE IF EXISTS `contrexx_module_mediadir_form_names`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_mediadir_form_names` (
  `lang_id` int(1) NOT NULL,
  `form_id` int(7) NOT NULL,
  `form_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `form_description` mediumtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_mediadir_form_names`
--

LOCK TABLES `contrexx_module_mediadir_form_names` WRITE;
/*!40000 ALTER TABLE `contrexx_module_mediadir_form_names` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_mediadir_form_names` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_mediadir_forms`
--

DROP TABLE IF EXISTS `contrexx_module_mediadir_forms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_mediadir_forms` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `order` int(7) NOT NULL,
  `picture` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `active` int(1) NOT NULL,
  `use_level` int(1) NOT NULL,
  `use_category` int(1) NOT NULL,
  `use_ready_to_confirm` int(1) NOT NULL,
  `cmd` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_mediadir_forms`
--

LOCK TABLES `contrexx_module_mediadir_forms` WRITE;
/*!40000 ALTER TABLE `contrexx_module_mediadir_forms` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_mediadir_forms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_mediadir_inputfield_names`
--

DROP TABLE IF EXISTS `contrexx_module_mediadir_inputfield_names`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_mediadir_inputfield_names` (
  `lang_id` int(10) NOT NULL,
  `form_id` int(7) NOT NULL,
  `field_id` int(10) NOT NULL,
  `field_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `field_default_value` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `field_info` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  KEY `field_id` (`field_id`),
  KEY `lang_id` (`lang_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_mediadir_inputfield_names`
--

LOCK TABLES `contrexx_module_mediadir_inputfield_names` WRITE;
/*!40000 ALTER TABLE `contrexx_module_mediadir_inputfield_names` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_mediadir_inputfield_names` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_mediadir_inputfield_types`
--

DROP TABLE IF EXISTS `contrexx_module_mediadir_inputfield_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_mediadir_inputfield_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` int(1) NOT NULL,
  `multi_lang` int(1) NOT NULL,
  `exp_search` int(7) NOT NULL,
  `dynamic` int(1) NOT NULL,
  `comment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_mediadir_inputfield_types`
--

LOCK TABLES `contrexx_module_mediadir_inputfield_types` WRITE;
/*!40000 ALTER TABLE `contrexx_module_mediadir_inputfield_types` DISABLE KEYS */;
INSERT INTO `contrexx_module_mediadir_inputfield_types` VALUES (1,'text',1,1,1,0,''),(2,'textarea',1,1,1,0,''),(3,'dropdown',1,0,1,0,''),(4,'radio',1,0,1,0,''),(5,'checkbox',1,0,0,0,''),(7,'file',1,0,0,0,''),(8,'image',1,0,0,0,''),(9,'gallery',0,0,0,0,'not yet developed'),(10,'podcast',0,0,0,0,'not yet developed'),(11,'classification',1,0,1,0,''),(12,'link',1,0,0,0,''),(13,'link_group',1,0,0,0,''),(14,'rss',0,0,0,0,'not yet developed'),(15,'google_map',1,0,0,0,''),(16,'add_step',0,0,0,0,''),(17,'field_group',0,0,0,0,'not yet developed'),(18,'label',0,0,0,0,'not yet developed'),(19,'wysiwyg',1,1,0,0,''),(20,'mail',1,0,0,0,''),(21,'google_weather',1,0,0,0,''),(22,'relation',0,0,0,0,'developed for OSEC (unstable)'),(23,'relation_group',0,0,0,0,'developed for OSEC (unstable)'),(24,'accounts',0,0,0,0,'developed for OSEC (unstable)'),(25,'country',1,0,0,0,''),(26,'product_attributes',0,0,1,0,''),(27,'downloads',0,1,0,1,'developed for CADexchange.ch (unstable)'),(28,'responsibles',0,1,0,1,'developed for CADexchange.ch (unstable)'),(29,'references',0,1,0,1,'developed for CADexchange.ch (unstable)'),(30,'title',0,0,0,0,'developed for CADexchange.ch (unstable)');
/*!40000 ALTER TABLE `contrexx_module_mediadir_inputfield_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_mediadir_inputfield_verifications`
--

DROP TABLE IF EXISTS `contrexx_module_mediadir_inputfield_verifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_mediadir_inputfield_verifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `regex` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_mediadir_inputfield_verifications`
--

LOCK TABLES `contrexx_module_mediadir_inputfield_verifications` WRITE;
/*!40000 ALTER TABLE `contrexx_module_mediadir_inputfield_verifications` DISABLE KEYS */;
INSERT INTO `contrexx_module_mediadir_inputfield_verifications` VALUES (1,'normal','.*'),(2,'e-mail','^[a-zäàáâöôüûñéè0-9!\\#\\$\\%\\&\\\'\\*\\+\\/\\=\\?\\^_\\`\\{\\|\\}\\~-]+(?:\\.[a-zäàáâöôüûñéè0-9!\\#\\$\\%\\&\\\'\\*\\+\\/\\=\\?\\^_\\`\\{\\|\\}\\~-]+)*@(?:[a-zäàáâöôüûñéè0-9](?:[a-zäàáâöôüûñéè0-9-]*[a-zäàáâöôüûñéè0-9])?\\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$'),(3,'url','^(?:(?:ht|f)tps?\\:\\/\\/)?((([\\wÄÀÁÂÖÔÜÛÑÉÈäàáâöôüûñéè\\d-]{1,}\\.)+[a-z]{2,})|((?:(?:25[0-5]|2[0-4]\\d|[01]\\d\\d|\\d?\\d)(?:(\\.?\\d)\\.)) {4}))(?:[\\w\\d]+)?(\\/[\\w\\d\\-\\.\\?\\,\\\'\\/\\\\\\+\\&\\%\\$\\#\\=\\~]*)?$'),(4,'letters','^[A-Za-zÄÀÁÂÖÔÜÛÑÉÈäàáâöôüûñéè\\ ]*[A-Za-zÄÀÁÂÖÔÜÛÑÉÈäàáâöôüûñéè]+[A-Za-zÄÀÁÂÖÔÜÛÑÉÈäàáâöôüûñéè\\ ]*$'),(5,'numbers','^[0-9]*$');
/*!40000 ALTER TABLE `contrexx_module_mediadir_inputfield_verifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_mediadir_inputfields`
--

DROP TABLE IF EXISTS `contrexx_module_mediadir_inputfields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_mediadir_inputfields` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `form` int(7) NOT NULL,
  `type` int(10) NOT NULL,
  `verification` int(10) NOT NULL,
  `search` int(10) NOT NULL,
  `required` int(10) NOT NULL,
  `order` int(10) NOT NULL,
  `show_in` int(10) NOT NULL,
  `context_type` enum('none','title','address','zip','city','country') COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_mediadir_inputfields`
--

LOCK TABLES `contrexx_module_mediadir_inputfields` WRITE;
/*!40000 ALTER TABLE `contrexx_module_mediadir_inputfields` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_mediadir_inputfields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_mediadir_level_names`
--

DROP TABLE IF EXISTS `contrexx_module_mediadir_level_names`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_mediadir_level_names` (
  `lang_id` int(1) NOT NULL,
  `level_id` int(7) NOT NULL,
  `level_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `level_description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  KEY `lang_id` (`lang_id`),
  KEY `category_id` (`level_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_mediadir_level_names`
--

LOCK TABLES `contrexx_module_mediadir_level_names` WRITE;
/*!40000 ALTER TABLE `contrexx_module_mediadir_level_names` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_mediadir_level_names` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_mediadir_levels`
--

DROP TABLE IF EXISTS `contrexx_module_mediadir_levels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_mediadir_levels` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `parent_id` int(7) NOT NULL,
  `order` int(7) NOT NULL,
  `show_sublevels` int(11) NOT NULL,
  `show_categories` int(1) NOT NULL,
  `show_entries` int(1) NOT NULL,
  `picture` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `active` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_mediadir_levels`
--

LOCK TABLES `contrexx_module_mediadir_levels` WRITE;
/*!40000 ALTER TABLE `contrexx_module_mediadir_levels` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_mediadir_levels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_mediadir_mail_actions`
--

DROP TABLE IF EXISTS `contrexx_module_mediadir_mail_actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_mediadir_mail_actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `default_recipient` enum('admin','author') COLLATE utf8_unicode_ci NOT NULL,
  `need_auth` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_mediadir_mail_actions`
--

LOCK TABLES `contrexx_module_mediadir_mail_actions` WRITE;
/*!40000 ALTER TABLE `contrexx_module_mediadir_mail_actions` DISABLE KEYS */;
INSERT INTO `contrexx_module_mediadir_mail_actions` VALUES (1,'newEntry','admin',0),(2,'entryAdded','author',1),(3,'entryConfirmed','author',1),(4,'entryVoted','author',1),(5,'entryDeleted','author',1),(6,'entryEdited','author',1),(8,'newComment','author',1),(9,'notificationDisplayduration','admin',0);
/*!40000 ALTER TABLE `contrexx_module_mediadir_mail_actions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_mediadir_mails`
--

DROP TABLE IF EXISTS `contrexx_module_mediadir_mails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_mediadir_mails` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `recipients` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `lang_id` int(1) NOT NULL,
  `action_id` int(1) NOT NULL,
  `is_default` int(1) NOT NULL,
  `active` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_mediadir_mails`
--

LOCK TABLES `contrexx_module_mediadir_mails` WRITE;
/*!40000 ALTER TABLE `contrexx_module_mediadir_mails` DISABLE KEYS */;
INSERT INTO `contrexx_module_mediadir_mails` VALUES (19,'[[URL]] - Eintrag erfolgreich eingetragen','Hallo [[FIRSTNAME]] [[LASTNAME]] ([[USERNAME]])\r\n\r\nIhr Eintrag mit dem Titel \"[[TITLE]]\" wurde auf [[URL]] erfolgreich eingetragen. \r\n\r\n\r\nFreundliche Grüsse\r\nIhr [[URL]]-Team\r\n\r\n-- \r\nDiese Nachricht wurde am [[DATE]] automatisch von Contrexx auf http://[[URL]] generiert.','',1,2,1,0),(20,'[[URL]] - Ihr Eintrag wurde aufgeschaltet','Guten Tag,\r\n\r\nIhr Eintrag \"[[TITLE]]\" wurde geprüft und ist ab sofort einsehbar.\r\n\r\nBenutzen Sie folgenden Link um direkt zu ihrem Eintrag zu gelangen:\r\n[[LINK]]\r\n\r\n\r\nFreundliche Grüsse\r\nIhr [[URL]]-Team\r\n\r\n\r\n-- \r\nDiese Nachricht wurde am [[DATE]] automatisch von Contrexx auf http://[[URL]] generiert.','',1,3,1,0),(21,'[[URL]] - Eintrag wurde bewertet','Hallo [[FIRSTNAME]] [[LASTNAME]] ([[USERNAME]])\r\n\r\nZu Ihrem Eintrag mit dem Titel \"[[TITLE]]\" auf [[URL]] wurde eine Bewertung abgegeben. \r\n\r\nBenutzen Sie folgenden Link um direkt zu Ihrem Eintrag zu gelangen:\r\n[[LINK]]\r\n\r\nFreundliche Grüsse\r\nIhr [[URL]]-Team\r\n\r\n-- \r\nDiese Nachricht wurde am [[DATE]] automatisch von Contrexx auf http://[[URL]] generiert.','',1,4,1,0),(22,'[[URL]] - Eintrag erfolgreich gelöscht','Hallo [[FIRSTNAME]] [[LASTNAME]] ([[USERNAME]])\r\n\r\nIhr Eintrag mit dem Titel \"[[TITLE]]\" auf [[URL]] wurde erfolgreich gelöscht. \r\n\r\nFreundliche Grüsse\r\nIhr [[URL]]-Team\r\n\r\n-- \r\nDiese Nachricht wurde am [[DATE]] automatisch von Contrexx auf http://[[URL]] generiert.','',1,5,1,0),(23,'[[URL]] - Eintrag erfolgreich bearbeitet','Hallo [[FIRSTNAME]] [[LASTNAME]] ([[USERNAME]])\r\n\r\nIhr Eintrag mit dem Titel \"[[TITLE]]\" auf [[URL]] wurde erfolgreich bearbeitet. \r\n\r\nBenutzen Sie folgenden Link um direkt zu Ihrem Eintrag zu gelangen:\r\n[[LINK]]\r\n\r\nFreundliche Grüsse\r\n[[URL]]-Team\r\n\r\n-- \r\nDiese Nachricht wurde am [[DATE]] automatisch von Contrexx auf http://[[URL]] generiert.','',1,6,1,0),(24,'[[URL]] - Neuer Kommentar hinzugefügt','Hallo [[FIRSTNAME]] [[LASTNAME]] ([[USERNAME]])\r\n\r\nZu Ihrem Eintrag mit dem Titel \"[[TITLE]]\" auf [[URL]] wurde ein neuer Kommentar hinzugefügt. \r\n\r\nBenutzen Sie folgenden Link um direkt zu Ihrem Eintrag zu gelangen:\r\n[[LINK]]\r\n\r\nFreundliche Grüsse\r\nIhr [[URL]]-Team\r\n\r\n\r\n-- \r\nDiese Nachricht wurde am [[DATE]] automatisch von Contrexx auf http://[[URL]] generiert.','',1,8,1,0),(32,'[[URL]] - Neuer Eintrag zur Prüfung freigegeben','Guten Tag,\r\n\r\nAuf http://[[URL]] wurde ein neuer Eintrag mit dem Titel \"[[TITLE]]\" erfasst. Bitte prüfen Sie diesen und geben Sie ihn gegebenenfalls frei.\r\n\r\n\r\n-- \r\nDiese Nachricht wurde am [[DATE]] automatisch von Contrexx auf http://[[URL]] generiert.','',1,1,1,0),(33,'[[URL]] - Die Anzeigedauer eines Eintrages läuft ab','Hallo Admin\r\n\r\nAuf [[URL]] läuft in Kürze die Anzeigedauer des Eintrages \"[[TITLE]]\" ab.\r\n\r\nFreundliche Grüsse\r\nIhr [[URL]]-Team\r\n\r\n-- \r\nDiese Nachricht wurde am [[DATE]] automatisch von Contrexx auf http://[[URL]] generiert.','',1,9,1,0);
/*!40000 ALTER TABLE `contrexx_module_mediadir_mails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_mediadir_masks`
--

DROP TABLE IF EXISTS `contrexx_module_mediadir_masks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_mediadir_masks` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fields` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `active` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_mediadir_masks`
--

LOCK TABLES `contrexx_module_mediadir_masks` WRITE;
/*!40000 ALTER TABLE `contrexx_module_mediadir_masks` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_mediadir_masks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_mediadir_order_rel_forms_selectors`
--

DROP TABLE IF EXISTS `contrexx_module_mediadir_order_rel_forms_selectors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_mediadir_order_rel_forms_selectors` (
  `selector_id` int(7) NOT NULL,
  `form_id` int(7) NOT NULL,
  `selector_order` int(7) NOT NULL,
  `exp_search` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_mediadir_order_rel_forms_selectors`
--

LOCK TABLES `contrexx_module_mediadir_order_rel_forms_selectors` WRITE;
/*!40000 ALTER TABLE `contrexx_module_mediadir_order_rel_forms_selectors` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_mediadir_order_rel_forms_selectors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_mediadir_rel_entry_categories`
--

DROP TABLE IF EXISTS `contrexx_module_mediadir_rel_entry_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_mediadir_rel_entry_categories` (
  `entry_id` int(10) NOT NULL,
  `category_id` int(10) NOT NULL,
  KEY `entry_id` (`entry_id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_mediadir_rel_entry_categories`
--

LOCK TABLES `contrexx_module_mediadir_rel_entry_categories` WRITE;
/*!40000 ALTER TABLE `contrexx_module_mediadir_rel_entry_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_mediadir_rel_entry_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_mediadir_rel_entry_inputfields`
--

DROP TABLE IF EXISTS `contrexx_module_mediadir_rel_entry_inputfields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_mediadir_rel_entry_inputfields` (
  `entry_id` int(7) NOT NULL,
  `lang_id` int(7) NOT NULL,
  `form_id` int(7) NOT NULL,
  `field_id` int(7) NOT NULL,
  `value` longtext COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `entry_id` (`entry_id`,`lang_id`,`form_id`,`field_id`),
  FULLTEXT KEY `value` (`value`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_mediadir_rel_entry_inputfields`
--

LOCK TABLES `contrexx_module_mediadir_rel_entry_inputfields` WRITE;
/*!40000 ALTER TABLE `contrexx_module_mediadir_rel_entry_inputfields` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_mediadir_rel_entry_inputfields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_mediadir_rel_entry_levels`
--

DROP TABLE IF EXISTS `contrexx_module_mediadir_rel_entry_levels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_mediadir_rel_entry_levels` (
  `entry_id` int(10) NOT NULL,
  `level_id` int(10) NOT NULL,
  KEY `entry_id` (`entry_id`),
  KEY `category_id` (`level_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_mediadir_rel_entry_levels`
--

LOCK TABLES `contrexx_module_mediadir_rel_entry_levels` WRITE;
/*!40000 ALTER TABLE `contrexx_module_mediadir_rel_entry_levels` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_mediadir_rel_entry_levels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_mediadir_settings`
--

DROP TABLE IF EXISTS `contrexx_module_mediadir_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_mediadir_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_mediadir_settings`
--

LOCK TABLES `contrexx_module_mediadir_settings` WRITE;
/*!40000 ALTER TABLE `contrexx_module_mediadir_settings` DISABLE KEYS */;
INSERT INTO `contrexx_module_mediadir_settings` VALUES (1,'settingsShowCategoryDescription','1'),(2,'settingsShowCategoryImage','1'),(3,'settingsCategoryOrder','1'),(4,'settingsShowLevels','1'),(5,'settingsShowLevelDescription','0'),(6,'settingsShowLevelImage','0'),(7,'settingsLevelOrder','1'),(8,'settingsConfirmNewEntries','1'),(9,'categorySelectorOrder','9'),(10,'levelSelectorOrder','10'),(11,'settingsConfirmUpdatedEntries','0'),(12,'settingsCountEntries','0'),(13,'settingsThumbSize','300'),(14,'settingsNumGalleryPics','10'),(15,'settingsEncryptFilenames','1'),(16,'settingsAllowAddEntries','1'),(17,'settingsAllowDelEntries','1'),(18,'settingsAllowEditEntries','1'),(19,'settingsAddEntriesOnlyCommunity','1'),(20,'settingsLatestNumXML','10'),(21,'settingsLatestNumOverview','3'),(22,'settingsLatestNumBackend','5'),(23,'settingsLatestNumFrontend','10'),(24,'settingsPopularNumFrontend','10'),(25,'settingsPopularNumRestore','30'),(26,'settingsLatestNumHeadlines','6'),(27,'settingsGoogleMapStartposition','46.749647513758326,7.6300048828125,8'),(28,'settingsAllowVotes','1'),(29,'settingsVoteOnlyCommunity','0'),(30,'settingsAllowComments','1'),(31,'settingsCommentOnlyCommunity','0'),(32,'settingsGoogleMapAllowKml','0'),(33,'settingsShowEntriesInAllLang','1'),(34,'settingsPagingNumEntries','10'),(35,'settingsGoogleMapType','0'),(36,'settingsClassificationPoints','5'),(37,'settingsClassificationSearch','1'),(38,'settingsEntryDisplaydurationType','1'),(39,'settingsEntryDisplaydurationValue','0'),(40,'settingsEntryDisplaydurationValueType','1'),(41,'settingsEntryDisplaydurationNotification','0'),(42,'categorySelectorExpSearch','9'),(43,'levelSelectorExpSearch','10'),(44,'settingsTranslationStatus','0'),(45,'settingsReadyToConfirm','0'),(46,'settingsImageFilesize','300'),(47,'settingsActiveLanguages','2,1,3'),(48,'settingsFrontendUseMultilang','0'),(49,'settingsIndividualEntryOrder','0');
/*!40000 ALTER TABLE `contrexx_module_mediadir_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_mediadir_settings_num_categories`
--

DROP TABLE IF EXISTS `contrexx_module_mediadir_settings_num_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_mediadir_settings_num_categories` (
  `group_id` int(1) NOT NULL,
  `num_categories` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_mediadir_settings_num_categories`
--

LOCK TABLES `contrexx_module_mediadir_settings_num_categories` WRITE;
/*!40000 ALTER TABLE `contrexx_module_mediadir_settings_num_categories` DISABLE KEYS */;
INSERT INTO `contrexx_module_mediadir_settings_num_categories` VALUES (3,'n'),(4,'n'),(5,'n');
/*!40000 ALTER TABLE `contrexx_module_mediadir_settings_num_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_mediadir_settings_num_entries`
--

DROP TABLE IF EXISTS `contrexx_module_mediadir_settings_num_entries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_mediadir_settings_num_entries` (
  `group_id` int(1) NOT NULL,
  `num_entries` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_mediadir_settings_num_entries`
--

LOCK TABLES `contrexx_module_mediadir_settings_num_entries` WRITE;
/*!40000 ALTER TABLE `contrexx_module_mediadir_settings_num_entries` DISABLE KEYS */;
INSERT INTO `contrexx_module_mediadir_settings_num_entries` VALUES (3,'n'),(4,'n'),(5,'n'),(6,''),(7,'');
/*!40000 ALTER TABLE `contrexx_module_mediadir_settings_num_entries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_mediadir_settings_num_levels`
--

DROP TABLE IF EXISTS `contrexx_module_mediadir_settings_num_levels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_mediadir_settings_num_levels` (
  `group_id` int(1) NOT NULL,
  `num_levels` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_mediadir_settings_num_levels`
--

LOCK TABLES `contrexx_module_mediadir_settings_num_levels` WRITE;
/*!40000 ALTER TABLE `contrexx_module_mediadir_settings_num_levels` DISABLE KEYS */;
INSERT INTO `contrexx_module_mediadir_settings_num_levels` VALUES (3,'n'),(4,'n'),(5,'n');
/*!40000 ALTER TABLE `contrexx_module_mediadir_settings_num_levels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_mediadir_settings_perm_group_forms`
--

DROP TABLE IF EXISTS `contrexx_module_mediadir_settings_perm_group_forms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_mediadir_settings_perm_group_forms` (
  `group_id` int(7) NOT NULL,
  `form_id` int(1) NOT NULL,
  `status_group` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_mediadir_settings_perm_group_forms`
--

LOCK TABLES `contrexx_module_mediadir_settings_perm_group_forms` WRITE;
/*!40000 ALTER TABLE `contrexx_module_mediadir_settings_perm_group_forms` DISABLE KEYS */;
INSERT INTO `contrexx_module_mediadir_settings_perm_group_forms` VALUES (7,24,1),(6,24,1),(5,24,1),(4,24,1),(3,24,1),(7,23,1),(6,23,1),(5,23,1),(4,23,1),(3,23,1);
/*!40000 ALTER TABLE `contrexx_module_mediadir_settings_perm_group_forms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_mediadir_votes`
--

DROP TABLE IF EXISTS `contrexx_module_mediadir_votes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_mediadir_votes` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `entry_id` int(7) NOT NULL,
  `added_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `vote` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_mediadir_votes`
--

LOCK TABLES `contrexx_module_mediadir_votes` WRITE;
/*!40000 ALTER TABLE `contrexx_module_mediadir_votes` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_mediadir_votes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_memberdir_directories`
--

DROP TABLE IF EXISTS `contrexx_module_memberdir_directories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_memberdir_directories` (
  `dirid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parentdir` int(11) NOT NULL DEFAULT '0',
  `active` set('1','0') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `displaymode` set('0','1','2') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `sort` int(11) NOT NULL DEFAULT '1',
  `pic1` set('1','0') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `pic2` set('1','0') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `lang_id` int(2) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`dirid`),
  FULLTEXT KEY `memberdir_dir` (`name`,`description`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_memberdir_directories`
--

LOCK TABLES `contrexx_module_memberdir_directories` WRITE;
/*!40000 ALTER TABLE `contrexx_module_memberdir_directories` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_memberdir_directories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_memberdir_name`
--

DROP TABLE IF EXISTS `contrexx_module_memberdir_name`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_memberdir_name` (
  `field` int(10) unsigned NOT NULL DEFAULT '0',
  `dirid` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `active` set('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `lang_id` int(2) unsigned NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_memberdir_name`
--

LOCK TABLES `contrexx_module_memberdir_name` WRITE;
/*!40000 ALTER TABLE `contrexx_module_memberdir_name` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_memberdir_name` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_memberdir_settings`
--

DROP TABLE IF EXISTS `contrexx_module_memberdir_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_memberdir_settings` (
  `setid` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `setname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `setvalue` text COLLATE utf8_unicode_ci NOT NULL,
  `lang_id` int(2) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`setid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_memberdir_settings`
--

LOCK TABLES `contrexx_module_memberdir_settings` WRITE;
/*!40000 ALTER TABLE `contrexx_module_memberdir_settings` DISABLE KEYS */;
INSERT INTO `contrexx_module_memberdir_settings` VALUES (1,'default_listing','1',1),(3,'max_height','400',1),(4,'max_width','500',1);
/*!40000 ALTER TABLE `contrexx_module_memberdir_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_memberdir_values`
--

DROP TABLE IF EXISTS `contrexx_module_memberdir_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_memberdir_values` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dirid` int(14) NOT NULL DEFAULT '0',
  `pic1` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `pic2` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `0` smallint(5) unsigned NOT NULL DEFAULT '0',
  `1` text COLLATE utf8_unicode_ci NOT NULL,
  `2` text COLLATE utf8_unicode_ci NOT NULL,
  `3` text COLLATE utf8_unicode_ci NOT NULL,
  `4` text COLLATE utf8_unicode_ci NOT NULL,
  `5` text COLLATE utf8_unicode_ci NOT NULL,
  `6` text COLLATE utf8_unicode_ci NOT NULL,
  `7` text COLLATE utf8_unicode_ci NOT NULL,
  `8` text COLLATE utf8_unicode_ci NOT NULL,
  `9` text COLLATE utf8_unicode_ci NOT NULL,
  `10` text COLLATE utf8_unicode_ci NOT NULL,
  `11` text COLLATE utf8_unicode_ci NOT NULL,
  `12` text COLLATE utf8_unicode_ci NOT NULL,
  `13` text COLLATE utf8_unicode_ci NOT NULL,
  `14` text COLLATE utf8_unicode_ci NOT NULL,
  `15` text COLLATE utf8_unicode_ci NOT NULL,
  `16` text COLLATE utf8_unicode_ci NOT NULL,
  `17` text COLLATE utf8_unicode_ci NOT NULL,
  `18` text COLLATE utf8_unicode_ci NOT NULL,
  `lang_id` int(2) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_memberdir_values`
--

LOCK TABLES `contrexx_module_memberdir_values` WRITE;
/*!40000 ALTER TABLE `contrexx_module_memberdir_values` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_memberdir_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_news`
--

DROP TABLE IF EXISTS `contrexx_module_news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_news` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `date` int(14) DEFAULT NULL,
  `redirect` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `source` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `url1` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `url2` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `catid` int(2) unsigned NOT NULL DEFAULT '0',
  `typeid` int(2) unsigned NOT NULL DEFAULT '0',
  `publisher` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `publisher_id` int(5) unsigned NOT NULL DEFAULT '0',
  `author` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `author_id` int(5) unsigned NOT NULL DEFAULT '0',
  `userid` int(6) unsigned NOT NULL DEFAULT '0',
  `startdate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `enddate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `validated` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `frontend_access_id` int(10) unsigned NOT NULL DEFAULT '0',
  `backend_access_id` int(10) unsigned NOT NULL DEFAULT '0',
  `teaser_only` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `teaser_frames` text COLLATE utf8_unicode_ci NOT NULL,
  `teaser_show_link` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `teaser_image_path` text COLLATE utf8_unicode_ci NOT NULL,
  `teaser_image_thumbnail_path` text COLLATE utf8_unicode_ci NOT NULL,
  `changelog` int(14) NOT NULL DEFAULT '0',
  `allow_comments` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_news`
--

LOCK TABLES `contrexx_module_news` WRITE;
/*!40000 ALTER TABLE `contrexx_module_news` DISABLE KEYS */;
INSERT INTO `contrexx_module_news` VALUES (1,1422144000,'','','','',4,0,'rafhun',1,'rafhun',1,1,'0000-00-00 00:00:00','0000-00-00 00:00:00',1,'1',0,0,'0','',1,'','',1429081859,0),(2,1420848000,'','','','',4,0,'',1,'',1,1,'0000-00-00 00:00:00','0000-00-00 00:00:00',1,'1',0,0,'0','',1,'','',1420848000,0),(3,1427846400,'','','','',4,0,'',1,'',1,1,'0000-00-00 00:00:00','0000-00-00 00:00:00',1,'1',0,0,'0','',1,'','',1427846400,0),(4,1428192000,'','','','',4,0,'',1,'',1,1,'0000-00-00 00:00:00','0000-00-00 00:00:00',1,'1',0,0,'0','',1,'','',1428192000,0);
/*!40000 ALTER TABLE `contrexx_module_news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_news_categories`
--

DROP TABLE IF EXISTS `contrexx_module_news_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_news_categories` (
  `catid` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `left_id` int(11) NOT NULL,
  `right_id` int(11) NOT NULL,
  `sorting` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  PRIMARY KEY (`catid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_news_categories`
--

LOCK TABLES `contrexx_module_news_categories` WRITE;
/*!40000 ALTER TABLE `contrexx_module_news_categories` DISABLE KEYS */;
INSERT INTO `contrexx_module_news_categories` VALUES (3,3,1,4,1,1),(4,3,2,3,1,2);
/*!40000 ALTER TABLE `contrexx_module_news_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_news_categories_catid`
--

DROP TABLE IF EXISTS `contrexx_module_news_categories_catid`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_news_categories_catid` (
  `id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_news_categories_catid`
--

LOCK TABLES `contrexx_module_news_categories_catid` WRITE;
/*!40000 ALTER TABLE `contrexx_module_news_categories_catid` DISABLE KEYS */;
INSERT INTO `contrexx_module_news_categories_catid` VALUES (4);
/*!40000 ALTER TABLE `contrexx_module_news_categories_catid` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_news_categories_locale`
--

DROP TABLE IF EXISTS `contrexx_module_news_categories_locale`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_news_categories_locale` (
  `category_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lang_id` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`category_id`,`lang_id`),
  FULLTEXT KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_news_categories_locale`
--

LOCK TABLES `contrexx_module_news_categories_locale` WRITE;
/*!40000 ALTER TABLE `contrexx_module_news_categories_locale` DISABLE KEYS */;
INSERT INTO `contrexx_module_news_categories_locale` VALUES (4,1,'Infos'),(4,2,'Infos'),(4,3,'Infos'),(4,4,'Infos'),(4,5,'Infos'),(4,6,'Infos');
/*!40000 ALTER TABLE `contrexx_module_news_categories_locale` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_news_categories_locks`
--

DROP TABLE IF EXISTS `contrexx_module_news_categories_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_news_categories_locks` (
  `lockId` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `lockTable` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `lockStamp` bigint(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_news_categories_locks`
--

LOCK TABLES `contrexx_module_news_categories_locks` WRITE;
/*!40000 ALTER TABLE `contrexx_module_news_categories_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_news_categories_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_news_comments`
--

DROP TABLE IF EXISTS `contrexx_module_news_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_news_comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `text` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `newsid` int(6) unsigned NOT NULL DEFAULT '0',
  `date` int(14) DEFAULT NULL,
  `poster_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `userid` int(5) unsigned NOT NULL DEFAULT '0',
  `ip_address` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0.0.0.0',
  `is_active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_news_comments`
--

LOCK TABLES `contrexx_module_news_comments` WRITE;
/*!40000 ALTER TABLE `contrexx_module_news_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_news_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_news_locale`
--

DROP TABLE IF EXISTS `contrexx_module_news_locale`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_news_locale` (
  `news_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lang_id` int(11) unsigned NOT NULL DEFAULT '0',
  `is_active` int(1) unsigned NOT NULL DEFAULT '1',
  `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `text` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `teaser_text` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`news_id`,`lang_id`),
  FULLTEXT KEY `newsindex` (`text`,`title`,`teaser_text`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_news_locale`
--

LOCK TABLES `contrexx_module_news_locale` WRITE;
/*!40000 ALTER TABLE `contrexx_module_news_locale` DISABLE KEYS */;
INSERT INTO `contrexx_module_news_locale` VALUES (1,1,1,'Gründung der European Knee Society EKS','<p>Am 23. Januar 2015 haben Mitglieder der European Knee Associates (EKA) anl&auml;sslich ihrem Closed Meeting in Zermatt die neue Gesellschaft European Knee Society EKS gegr&uuml;ndet, die sich der Behandlung von degenerativen Erkrankungen und Ver&auml;nderungen des Kniegelenks widmet. Das Behandlungsspektrum reicht von der konservativen Therapie, &uuml;ber Knorpelersatz und -aufbau, Achsenumstellungen bis zum teilweisen oder kompletten Gelenkersatz mit einer Prothese und nat&uuml;rlich auch den daraus resultierenden Revisionseingriffen.</p>\r\n\r\n<p>Die Gr&uuml;ndungs- und gleichzeitig ersten Vorstandsmitglieder der neuen Gesellschaft sind:</p>\r\n\r\n<ul class=\"tick-list\">\r\n	<li>Johan Bellemans, Belgien, Pr&auml;sident</li>\r\n	<li>Jan Victor, Belgien, 1. Vizepr&auml;sident</li>\r\n	<li>Chris Dodd, Grossbritannien, 2. Vizepr&auml;sident</li>\r\n	<li>Jean-No&euml;l Argenson, Frankreich, Past Pr&auml;sident</li>\r\n	<li>Emannuel Thienpont, Belgien, Finanzen</li>\r\n	<li>Andrea Baldini, Italien, Generalsekret&auml;r</li>\r\n	<li>Carsten Perka, Deutschland</li>\r\n	<li>Gijs van Hellemondt, Niederlande</li>\r\n	<li>Bernhard Christen, Schweiz</li>\r\n</ul>\r\n','Am 23. Januar 2015 haben Mitglieder der European Knee Associates (EKA) anlässlich ihrem Closed Meeting in Zermatt die neue Gesellschaft European Knee Society EKS gegründet, die sich der Behandlung von degenerativen Erkrankungen und Veränderungen des Kniegelenks widmet.'),(1,2,0,'','',''),(2,1,1,'Neuer Assistenzarzt','<p>Am 1. Januar 2015 hat mit Dr. Milan Kravarski ein neuer Assistenzarzt seine T&auml;tigkeit bei CHRISTENORTHO AG begonnen. Er ersetzt Herrn Dr. Simon Steppacher, welcher als Assistenzarzt auf der so genannten Jokerposition ins Inselspital zur&uuml;ck kehrt. Dr. Kravarski ist der dritte Assistenzarzt in Folge, welcher einen Teil seiner beruflichen Weiterbildung zum Facharzt f&uuml;r Orthop&auml;die und Traumatologie am Bewegungsapparat im Rahmen einer Kooperation von CHRISTENORTHO AG mit der Orthop&auml;dischen Universit&auml;tsklinik des Inselspitals Bern absolviert.</p>\r\n\r\n<p>Wir w&uuml;nschen ihm nachtr&auml;glich einen guten Start, viel Freude und Erfolg!</p>\r\n','Am 1. Januar 2015 hat mit Dr. Milan Kravarski ein neuer Assistenzarzt seine Tätigkeit bei CHRISTENORTHO AG begonnen.'),(3,1,1,'Neue Mitarbeiterin','<p>Am 1. April hat bei uns Frau Jeanine D&auml;nzer ihr Teilzeitpensum (40%) aufgenommen. Sie werden sie an den Sprechstundentagen (dienstags und donnerstags) antreffen. Wir w&uuml;nschen Frau D&auml;nzer an dieser Stelle einen guten Start und heissen sie im Team christenortho herzlich willkommen!</p>\r\n','Am 1. April hat bei uns Frau Jeanine Dänzer ihr Teilzeitpensum (40%) aufgenommen. Sie werden sie an den Sprechstundentagen (dienstags und donnerstags) antreffen.'),(4,1,1,'SportsClinic#1','<p><img alt=\"SportsClinic #1\" class=\"alignleft\" src=\"/images/content/news/SportsClinic1.jpg\" />Oberstes Ziel ist die Behandlung von Patienten auf h&ouml;chstem fachlichem Niveau unter Vernetzung von &Auml;rzten aus der Universit&auml;tsklinik mit Spezialisten aus der Praxis. Die beteiligten Orthop&auml;den Prof. Dr. K. Siebenrock, PD Dr. M. Zumstein, Prof. Dr. R. Biedert und Dr. B. Christen haben ganz gezielt die Integration der Sportmedizin gesucht und mit Dr. M. Sch&auml;r einen idealen Partner gefunden. Die gemeinsame Praxis im Wankdorfstadion steht unmittelbar vor der Er&ouml;ffnung!</p>\r\n\r\n<p>christenortho wird einen Teil der Praxisaktivit&auml;t (Sprechstunde am Donnerstag) ins Wankdorfstadion verlegen. Keine Angst, ich werde nicht pl&ouml;tzlich noch Spitzensportler betreuen. Mein Ziel ist vielmehr, dass ehemaligen Athleten und Sportlern bei schweren Arthrosen mit gelenkerhaltenden Massnahmen oder auch Kunstgelenken (Prothesen) wieder eine gewisse Sportf&auml;higkeit und damit Lebensqualit&auml;t zur&uuml;ck gegeben werden kann</p>\r\n','Im Dezember 2014 haben 5 Ärzte nach langer Vorbereitungszeit zusammen die SportsClinic#1 gegründet!');
/*!40000 ALTER TABLE `contrexx_module_news_locale` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_news_settings`
--

DROP TABLE IF EXISTS `contrexx_module_news_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_news_settings` (
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `value` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_news_settings`
--

LOCK TABLES `contrexx_module_news_settings` WRITE;
/*!40000 ALTER TABLE `contrexx_module_news_settings` DISABLE KEYS */;
INSERT INTO `contrexx_module_news_settings` VALUES ('news_feed_status','1'),('news_headlines_limit','2'),('news_settings_activated','1'),('news_submit_news','0'),('news_submit_only_community','1'),('news_activate_submitted_news','0'),('news_feed_image',''),('news_ticker_filename','newsticker.txt'),('news_message_protection',''),('news_message_protection_restricted',''),('news_notify_user','0'),('news_notify_group','0'),('news_comments_activated','0'),('news_comments_anonymous','1'),('news_comments_autoactivate','1'),('news_comments_notification','1'),('news_comments_timeout','30'),('news_default_teasers',''),('news_use_types','1'),('news_use_top',''),('news_top_days','10'),('news_top_limit','10'),('news_assigned_author_groups','0'),('news_assigned_publisher_groups','0'),('news_use_teaser_text','1'),('recent_news_message_limit','5');
/*!40000 ALTER TABLE `contrexx_module_news_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_news_settings_locale`
--

DROP TABLE IF EXISTS `contrexx_module_news_settings_locale`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_news_settings_locale` (
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `lang_id` int(11) unsigned NOT NULL DEFAULT '0',
  `value` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`name`,`lang_id`),
  FULLTEXT KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_news_settings_locale`
--

LOCK TABLES `contrexx_module_news_settings_locale` WRITE;
/*!40000 ALTER TABLE `contrexx_module_news_settings_locale` DISABLE KEYS */;
INSERT INTO `contrexx_module_news_settings_locale` VALUES ('news_feed_description',1,'News und Mitteilungen von Christen Ortho'),('news_feed_description',2,'News und Mitteilungen von Christen Ortho'),('news_feed_description',3,'News und Mitteilungen von Christen Ortho'),('news_feed_description',4,'News und Mitteilungen von Christen Ortho'),('news_feed_description',5,'News und Mitteilungen von Christen Ortho'),('news_feed_description',6,'News und Mitteilungen von Christen Ortho'),('news_feed_title',1,'Christen Ortho: News'),('news_feed_title',2,'Christen Ortho: News'),('news_feed_title',3,'Christen Ortho: News'),('news_feed_title',4,'Christen Ortho: News'),('news_feed_title',5,'Christen Ortho: News'),('news_feed_title',6,'Christen Ortho: News');
/*!40000 ALTER TABLE `contrexx_module_news_settings_locale` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_news_stats_view`
--

DROP TABLE IF EXISTS `contrexx_module_news_stats_view`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_news_stats_view` (
  `user_sid` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `news_id` int(6) unsigned NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `idx_user_sid` (`user_sid`),
  KEY `idx_news_id` (`news_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_news_stats_view`
--

LOCK TABLES `contrexx_module_news_stats_view` WRITE;
/*!40000 ALTER TABLE `contrexx_module_news_stats_view` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_news_stats_view` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_news_teaser_frame`
--

DROP TABLE IF EXISTS `contrexx_module_news_teaser_frame`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_news_teaser_frame` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lang_id` int(3) unsigned NOT NULL DEFAULT '0',
  `frame_template_id` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_news_teaser_frame`
--

LOCK TABLES `contrexx_module_news_teaser_frame` WRITE;
/*!40000 ALTER TABLE `contrexx_module_news_teaser_frame` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_news_teaser_frame` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_news_teaser_frame_templates`
--

DROP TABLE IF EXISTS `contrexx_module_news_teaser_frame_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_news_teaser_frame_templates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `html` text COLLATE utf8_unicode_ci NOT NULL,
  `source_code_mode` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_news_teaser_frame_templates`
--

LOCK TABLES `contrexx_module_news_teaser_frame_templates` WRITE;
/*!40000 ALTER TABLE `contrexx_module_news_teaser_frame_templates` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_news_teaser_frame_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_news_ticker`
--

DROP TABLE IF EXISTS `contrexx_module_news_ticker`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_news_ticker` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `charset` enum('ISO-8859-1','UTF-8') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'ISO-8859-1',
  `urlencode` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `prefix` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_news_ticker`
--

LOCK TABLES `contrexx_module_news_ticker` WRITE;
/*!40000 ALTER TABLE `contrexx_module_news_ticker` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_news_ticker` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_news_types`
--

DROP TABLE IF EXISTS `contrexx_module_news_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_news_types` (
  `typeid` int(2) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`typeid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_news_types`
--

LOCK TABLES `contrexx_module_news_types` WRITE;
/*!40000 ALTER TABLE `contrexx_module_news_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_news_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_news_types_locale`
--

DROP TABLE IF EXISTS `contrexx_module_news_types_locale`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_news_types_locale` (
  `lang_id` int(11) unsigned NOT NULL DEFAULT '0',
  `type_id` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`lang_id`,`type_id`),
  FULLTEXT KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_news_types_locale`
--

LOCK TABLES `contrexx_module_news_types_locale` WRITE;
/*!40000 ALTER TABLE `contrexx_module_news_types_locale` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_news_types_locale` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_newsletter`
--

DROP TABLE IF EXISTS `contrexx_module_newsletter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_newsletter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `template` int(11) NOT NULL DEFAULT '0',
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `attachment` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `priority` tinyint(1) NOT NULL DEFAULT '0',
  `sender_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sender_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `return_path` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `smtp_server` int(10) unsigned NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `count` int(11) NOT NULL DEFAULT '0',
  `recipient_count` int(11) unsigned NOT NULL DEFAULT '0',
  `date_create` int(14) unsigned NOT NULL DEFAULT '0',
  `date_sent` int(14) unsigned NOT NULL DEFAULT '0',
  `tmp_copy` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_newsletter`
--

LOCK TABLES `contrexx_module_newsletter` WRITE;
/*!40000 ALTER TABLE `contrexx_module_newsletter` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_newsletter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_newsletter_access_user`
--

DROP TABLE IF EXISTS `contrexx_module_newsletter_access_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_newsletter_access_user` (
  `accessUserID` int(5) unsigned NOT NULL,
  `newsletterCategoryID` int(11) NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  UNIQUE KEY `rel` (`accessUserID`,`newsletterCategoryID`),
  KEY `accessUserID` (`accessUserID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_newsletter_access_user`
--

LOCK TABLES `contrexx_module_newsletter_access_user` WRITE;
/*!40000 ALTER TABLE `contrexx_module_newsletter_access_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_newsletter_access_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_newsletter_attachment`
--

DROP TABLE IF EXISTS `contrexx_module_newsletter_attachment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_newsletter_attachment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `newsletter` int(11) NOT NULL DEFAULT '0',
  `file_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `file_nr` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `newsletter` (`newsletter`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_newsletter_attachment`
--

LOCK TABLES `contrexx_module_newsletter_attachment` WRITE;
/*!40000 ALTER TABLE `contrexx_module_newsletter_attachment` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_newsletter_attachment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_newsletter_category`
--

DROP TABLE IF EXISTS `contrexx_module_newsletter_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_newsletter_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `notification_email` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_newsletter_category`
--

LOCK TABLES `contrexx_module_newsletter_category` WRITE;
/*!40000 ALTER TABLE `contrexx_module_newsletter_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_newsletter_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_newsletter_confirm_mail`
--

DROP TABLE IF EXISTS `contrexx_module_newsletter_confirm_mail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_newsletter_confirm_mail` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `recipients` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_newsletter_confirm_mail`
--

LOCK TABLES `contrexx_module_newsletter_confirm_mail` WRITE;
/*!40000 ALTER TABLE `contrexx_module_newsletter_confirm_mail` DISABLE KEYS */;
INSERT INTO `contrexx_module_newsletter_confirm_mail` VALUES (1,'[[url]] - Anmeldung zum Newsletter','[[title]] [[lastname]]\r\n\r\nWir freuen uns, Sie bei unserem Newsletter begrüssen zu dürfen und wünschen Ihnen viel Freude damit.\r\nSie erhalten ab sofort wöchentlich die neuesten Informationen in elektronischer Form zu gestellt.\r\n\r\nUm die Bestellung des Newsletters zu bestätigen, bitten wir Sie, auf den folgenden Link zu klicken bzw. ihn in die Adresszeile Ihres Browsers zu kopieren:\r\n\r\n[[code]]\r\n\r\nUm zu verhindern, dass unser Newsletter in Ihrem Spam-Ordner landet, fügen Sie bitte die Adresse dieser E-Mail Ihrem Adressbuch hinzu.\r\n\r\nSofern Sie diese E-Mail ungewünscht erhalten haben, bitten wir um Entschuldigung. Sie werden keine weitere E-Mail mehr von uns erhalten.\r\n\r\n--\r\nDies ist eine automatisch generierte Nachricht.\r\n[[date]]',''),(2,'[[url]] - Bestätigung zur Newsletteranmeldung','[[title]] [[lastname]]\r\n\r\nIhr Newsletter Abonnement wurde erfolgreich registriert.\r\nSie werden nun in Zukunft unsere Newsletter erhalten. \r\n\r\n--\r\nDies ist eine automatisch generierte Nachricht.\r\n[[date]]',''),(3,'[[url]] - Newsletter Empfänger [[action]]','Folgende Mutation wurde im Newsletter System getätigt:\r\n\r\nGetätigte Aktion: [[action]]\r\nGeschlecht:       [[sex]]\r\nAnrede:           [[title]]\r\nVorname:          [[firstname]]\r\nNachname:         [[lastname]]\r\nE-Mail:           [[e-mail]]\r\n\r\n--\r\nDies ist eine automatisch generierte Nachricht.\r\n[[date]]','info@example.com');
/*!40000 ALTER TABLE `contrexx_module_newsletter_confirm_mail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_newsletter_email_link`
--

DROP TABLE IF EXISTS `contrexx_module_newsletter_email_link`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_newsletter_email_link` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email_id` int(11) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `email_id` (`email_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_newsletter_email_link`
--

LOCK TABLES `contrexx_module_newsletter_email_link` WRITE;
/*!40000 ALTER TABLE `contrexx_module_newsletter_email_link` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_newsletter_email_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_newsletter_email_link_feedback`
--

DROP TABLE IF EXISTS `contrexx_module_newsletter_email_link_feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_newsletter_email_link_feedback` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `link_id` int(11) unsigned NOT NULL,
  `email_id` int(11) unsigned NOT NULL,
  `recipient_id` int(11) unsigned NOT NULL,
  `recipient_type` enum('access','newsletter') COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `link_id` (`link_id`,`email_id`,`recipient_id`,`recipient_type`),
  KEY `email_id` (`email_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_newsletter_email_link_feedback`
--

LOCK TABLES `contrexx_module_newsletter_email_link_feedback` WRITE;
/*!40000 ALTER TABLE `contrexx_module_newsletter_email_link_feedback` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_newsletter_email_link_feedback` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_newsletter_rel_cat_news`
--

DROP TABLE IF EXISTS `contrexx_module_newsletter_rel_cat_news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_newsletter_rel_cat_news` (
  `newsletter` int(11) NOT NULL DEFAULT '0',
  `category` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`newsletter`,`category`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_newsletter_rel_cat_news`
--

LOCK TABLES `contrexx_module_newsletter_rel_cat_news` WRITE;
/*!40000 ALTER TABLE `contrexx_module_newsletter_rel_cat_news` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_newsletter_rel_cat_news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_newsletter_rel_user_cat`
--

DROP TABLE IF EXISTS `contrexx_module_newsletter_rel_user_cat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_newsletter_rel_user_cat` (
  `user` int(11) NOT NULL DEFAULT '0',
  `category` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user`,`category`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_newsletter_rel_user_cat`
--

LOCK TABLES `contrexx_module_newsletter_rel_user_cat` WRITE;
/*!40000 ALTER TABLE `contrexx_module_newsletter_rel_user_cat` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_newsletter_rel_user_cat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_newsletter_rel_usergroup_newsletter`
--

DROP TABLE IF EXISTS `contrexx_module_newsletter_rel_usergroup_newsletter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_newsletter_rel_usergroup_newsletter` (
  `userGroup` int(10) unsigned NOT NULL,
  `newsletter` int(10) unsigned NOT NULL,
  UNIQUE KEY `uniq` (`userGroup`,`newsletter`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_newsletter_rel_usergroup_newsletter`
--

LOCK TABLES `contrexx_module_newsletter_rel_usergroup_newsletter` WRITE;
/*!40000 ALTER TABLE `contrexx_module_newsletter_rel_usergroup_newsletter` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_newsletter_rel_usergroup_newsletter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_newsletter_settings`
--

DROP TABLE IF EXISTS `contrexx_module_newsletter_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_newsletter_settings` (
  `setid` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `setname` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `setvalue` text COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`setid`),
  UNIQUE KEY `setname` (`setname`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_newsletter_settings`
--

LOCK TABLES `contrexx_module_newsletter_settings` WRITE;
/*!40000 ALTER TABLE `contrexx_module_newsletter_settings` DISABLE KEYS */;
INSERT INTO `contrexx_module_newsletter_settings` VALUES (1,'sender_mail','webmaster@werbelinie.ch',1),(2,'sender_name','rafhun',1),(3,'reply_mail','webmaster@werbelinie.ch',1),(4,'mails_per_run','30',1),(5,'text_break_after','100',1),(6,'test_mail','webmaster@werbelinie.ch',1),(7,'overview_entries_limit','10',1),(8,'rejected_mail_operation','delete',1),(9,'defUnsubscribe','0',1),(10,'notificationUnsubscribe','1',1),(11,'notificationSubscribe','1',1),(12,'recipient_attribute_status','{\"recipient_sex\":{\"active\":false,\"required\":false},\"recipient_salutation\":{\"active\":true,\"required\":false},\"recipient_title\":{\"active\":false,\"required\":false},\"recipient_firstname\":{\"active\":true,\"required\":false},\"recipient_lastname\":{\"active\":true,\"required\":false},\"recipient_position\":{\"active\":false,\"required\":false},\"recipient_company\":{\"active\":false,\"required\":false},\"recipient_industry\":{\"active\":false,\"required\":false},\"recipient_address\":{\"active\":false,\"required\":false},\"recipient_city\":{\"active\":false,\"required\":false},\"recipient_zip\":{\"active\":false,\"required\":false},\"recipient_country\":{\"active\":false,\"required\":false},\"recipient_phone\":{\"active\":false,\"required\":false},\"recipient_private\":{\"active\":false,\"required\":false},\"recipient_mobile\":{\"active\":false,\"required\":false},\"recipient_fax\":{\"active\":false,\"required\":false},\"recipient_birthday\":{\"active\":false,\"required\":false},\"recipient_website\":{\"active\":false,\"required\":false}}',1),(13,'reject_info_mail_text','Der Newsletter konnte an folgende E-Mail-Adresse nicht versendet werden:\r\n[[EMAIL]]\r\n\r\nUm die E-Mail Adresse zu bearbeiten, klicken Sie bitte auf den folgenden Link:\r\n[[LINK]]',1);
/*!40000 ALTER TABLE `contrexx_module_newsletter_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_newsletter_template`
--

DROP TABLE IF EXISTS `contrexx_module_newsletter_template`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_newsletter_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `html` text COLLATE utf8_unicode_ci NOT NULL,
  `required` int(1) NOT NULL DEFAULT '0',
  `type` enum('e-mail','news') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'e-mail',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_newsletter_template`
--

LOCK TABLES `contrexx_module_newsletter_template` WRITE;
/*!40000 ALTER TABLE `contrexx_module_newsletter_template` DISABLE KEYS */;
INSERT INTO `contrexx_module_newsletter_template` VALUES (1,'Standard','Standard Template','<html>\r\n    <head>\r\n        <style type=\"text/css\">\r\n        *, html, body, table {\r\n			padding: 0;\r\n			margin: 0;\r\n			font-size: 12px;\r\n			font-family: arial;\r\n			line-height: 1.5;\r\n			color: #000000;\r\n        }\r\n\r\n        h1 {\r\n			padding: 20px 0 5px 0;\r\n            font-size: 20px;\r\n			color: #487EAD;\r\n        }\r\n\r\n        h2 {\r\n			padding: 18px 0 4px 0;\r\n            font-size: 16px;\r\n			color: #487EAD;\r\n        }\r\n\r\n        h3, h4, h5, h6 {\r\n			padding: 16px 0 3px 0;\r\n            font-size: 13px;\r\n			font-weight: bold;\r\n			color: #487EAD;\r\n        }\r\n\r\n		a,\r\n        a:link,\r\n		a:hover,\r\n		a:focus,\r\n		a:active,\r\n		a:visited {\r\n            color: #487EAD !imprtant;\r\n        }\r\n        </style>\r\n    </head>\r\n    <body>\r\n        <table height=\"100%\" width=\"100%\" cellspacing=\"60\" style=\"background-color: rgb(204, 204, 204);\">\r\n            <tbody>\r\n                <tr>\r\n                    <td align=\"center\">\r\n                    <table width=\"660\" cellspacing=\"30\" bgcolor=\"#ffffff\" style=\"border: 7px solid rgb(72, 126, 173);\">\r\n                        <tbody>\r\n                            <tr>\r\n                                <td style=\"font-family: arial; font-size: 12px;\"><a target=\"_blank\" style=\"font-family: arial; font-size: 20px; text-decoration: none; color: rgb(72, 126, 173);\" href=\"http://www.example.com\">example.com</a><br />\r\n                                <span style=\"font-size: 20px; font-family: arial; text-decoration: none; color: rgb(72, 126, 173);\">Newsletter</span></td>\r\n                            </tr>\r\n                            <tr>\r\n                                <td style=\"font-family: arial; font-size: 12px; color: rgb(0, 0, 0);\">[[content]]</td>\r\n                            </tr>\r\n                            <tr>\r\n                                <td>\r\n                                <table width=\"600\" cellspacing=\"0\">\r\n                                    <tbody>\r\n                                        <tr>\r\n                                            <td height=\"30\" colspan=\"3\" style=\"border-top: 3px solid rgb(72, 126, 173);\">&nbsp;</td>\r\n                                        </tr>\r\n                                        <tr>\r\n                                            <td width=\"235\" valign=\"top\" style=\"font-family: arial; font-size: 11px; color: rgb(0, 0, 0);\">\r\n                                            <h3 style=\"padding: 0pt; margin: 0pt 0pt 5px;\">Impressum</h3>\r\n                                            Beispiel AG<br />\r\n                                            Firmenstrasse 1<br />\r\n                                            CH-1234 Irgendwo<br />\r\n                                            <br />\r\n                                            Telefon: + 41 (0)12 345 67 89<br />\r\n                                            Fax: + 41 (0)12 345 67 90<br />\r\n                                            <br />\r\n                                            E-Mail: <a href=\"mailto:info@example.com\">info@example.com</a><br />\r\n                                            Web: <a href=\"http://www.example.com\">www.example.com</a></td>\r\n                                            <td width=\"30\" valign=\"top\">&nbsp;</td>\r\n                                            <td width=\"335\" valign=\"top\" style=\"font-family: arial; font-size: 11px; color: rgb(135, 135, 135);\">Diese Art der Korrespondenz ist absichtlich von uns gew&auml;hlt worden, um wertvolle Naturressourcen zu schonen. Dieses E-Mail ist ausdr&uuml;cklich nicht verschickt worden, um Ihre betrieblichen Vorg&auml;nge zu st&ouml;ren und dient ausschliesslich dazu, Sie auf einfachste Weise unverbindlich zu informieren. Falls Sie sich dadurch trotzdem bel&auml;stigt f&uuml;hlen, bitten wir Sie, umgehend mit einem Klick auf &quot;Newsletter abmelden&quot; sich abzumelden, so dass wir Sie aus unserem Verteiler l&ouml;schen k&ouml;nnen.<br />\r\n                                            <br />\r\n                                            <span>[[unsubscribe]]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[[profile_setup]]</span></td>\r\n                                        </tr>\r\n                                    </tbody>\r\n                                </table>\r\n                                </td>\r\n                            </tr>\r\n                        </tbody>\r\n                    </table>\r\n                    </td>\r\n                </tr>\r\n            </tbody>\r\n        </table>\r\n    </body>\r\n</html>',1,'e-mail'),(2,'Standard','Standard News-Import Template','<table border=\"0\" cellpadding=\"3\" cellspacing=\"0\" width=\"100%\">\r\n    <!-- BEGIN news_list --><!-- BEGIN news_category -->\r\n    <tbody>\r\n        <tr>\r\n            <td colspan=\"2\" style=\"text-align:left;\">\r\n                <h2>\r\n                    [[NEWS_CATEGORY_NAME]]</h2>\r\n            </td>\r\n        </tr>\r\n        <!-- END news_category --><!-- BEGIN news_message -->\r\n        <tr>\r\n            <td style=\"text-align:left;\" width=\"25%\">\r\n                <!-- BEGIN news_image --><img alt=\"\" height=\"100\" src=\"[[NEWS_IMAGE_SRC]]\" width=\"150\" /><!-- END news_image --></td>\r\n            <td style=\"text-align:left;\" width=\"75%\">\r\n                <h3>\r\n                    [[NEWS_TITLE]]</h3>\r\n                <p>\r\n                    [[NEWS_TEASER_TEXT]]</p>\r\n                <p>\r\n                    <a href=\"[[NEWS_URL]]\">Meldung lesen...</a></p>\r\n            </td>\r\n        </tr>\r\n        <!-- END news_message --><!-- END news_list -->\r\n    </tbody>\r\n</table>\r\n',1,'news');
/*!40000 ALTER TABLE `contrexx_module_newsletter_template` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_newsletter_tmp_sending`
--

DROP TABLE IF EXISTS `contrexx_module_newsletter_tmp_sending`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_newsletter_tmp_sending` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `newsletter` int(11) NOT NULL DEFAULT '0',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sendt` tinyint(1) NOT NULL DEFAULT '0',
  `type` enum('access','newsletter','core') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'newsletter',
  `code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_email` (`newsletter`,`email`),
  KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_newsletter_tmp_sending`
--

LOCK TABLES `contrexx_module_newsletter_tmp_sending` WRITE;
/*!40000 ALTER TABLE `contrexx_module_newsletter_tmp_sending` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_newsletter_tmp_sending` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_newsletter_user`
--

DROP TABLE IF EXISTS `contrexx_module_newsletter_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_newsletter_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `uri` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sex` enum('m','f') COLLATE utf8_unicode_ci DEFAULT NULL,
  `salutation` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `position` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `company` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `industry_sector` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `zip` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `country_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `phone_office` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `phone_private` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `phone_mobile` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fax` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `notes` text COLLATE utf8_unicode_ci NOT NULL,
  `birthday` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '00-00-0000',
  `status` int(1) NOT NULL DEFAULT '0',
  `emaildate` int(14) unsigned NOT NULL DEFAULT '0',
  `language` int(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_newsletter_user`
--

LOCK TABLES `contrexx_module_newsletter_user` WRITE;
/*!40000 ALTER TABLE `contrexx_module_newsletter_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_newsletter_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_newsletter_user_title`
--

DROP TABLE IF EXISTS `contrexx_module_newsletter_user_title`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_newsletter_user_title` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_newsletter_user_title`
--

LOCK TABLES `contrexx_module_newsletter_user_title` WRITE;
/*!40000 ALTER TABLE `contrexx_module_newsletter_user_title` DISABLE KEYS */;
INSERT INTO `contrexx_module_newsletter_user_title` VALUES (1,'Sehr geehrte Frau'),(2,'Sehr geehrter Herr'),(3,'Dear Ms'),(4,'Dear Mr'),(5,'Chère Madame'),(6,'Cher Monsieur');
/*!40000 ALTER TABLE `contrexx_module_newsletter_user_title` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_podcast_category`
--

DROP TABLE IF EXISTS `contrexx_module_podcast_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_podcast_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `podcastindex` (`title`,`description`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_podcast_category`
--

LOCK TABLES `contrexx_module_podcast_category` WRITE;
/*!40000 ALTER TABLE `contrexx_module_podcast_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_podcast_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_podcast_medium`
--

DROP TABLE IF EXISTS `contrexx_module_podcast_medium`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_podcast_medium` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `youtube_id` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `author` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `source` text COLLATE utf8_unicode_ci NOT NULL,
  `thumbnail` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `template_id` int(11) unsigned NOT NULL DEFAULT '0',
  `width` int(10) unsigned NOT NULL DEFAULT '0',
  `height` int(10) unsigned NOT NULL DEFAULT '0',
  `playlenght` int(10) unsigned NOT NULL DEFAULT '0',
  `size` int(10) unsigned NOT NULL DEFAULT '0',
  `views` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `date_added` int(14) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `podcastindex` (`title`,`description`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_podcast_medium`
--

LOCK TABLES `contrexx_module_podcast_medium` WRITE;
/*!40000 ALTER TABLE `contrexx_module_podcast_medium` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_podcast_medium` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_podcast_rel_category_lang`
--

DROP TABLE IF EXISTS `contrexx_module_podcast_rel_category_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_podcast_rel_category_lang` (
  `category_id` int(10) unsigned NOT NULL DEFAULT '0',
  `lang_id` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_podcast_rel_category_lang`
--

LOCK TABLES `contrexx_module_podcast_rel_category_lang` WRITE;
/*!40000 ALTER TABLE `contrexx_module_podcast_rel_category_lang` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_podcast_rel_category_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_podcast_rel_medium_category`
--

DROP TABLE IF EXISTS `contrexx_module_podcast_rel_medium_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_podcast_rel_medium_category` (
  `medium_id` int(10) unsigned NOT NULL DEFAULT '0',
  `category_id` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_podcast_rel_medium_category`
--

LOCK TABLES `contrexx_module_podcast_rel_medium_category` WRITE;
/*!40000 ALTER TABLE `contrexx_module_podcast_rel_medium_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_podcast_rel_medium_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_podcast_settings`
--

DROP TABLE IF EXISTS `contrexx_module_podcast_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_podcast_settings` (
  `setid` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `setname` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `setvalue` text COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`setid`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_podcast_settings`
--

LOCK TABLES `contrexx_module_podcast_settings` WRITE;
/*!40000 ALTER TABLE `contrexx_module_podcast_settings` DISABLE KEYS */;
INSERT INTO `contrexx_module_podcast_settings` VALUES (3,'default_width','320',1),(4,'default_height','240',1),(5,'feed_title','Contrexx Demo-Seite Neuste Videos',1),(6,'feed_description','Neuste Videos',1),(7,'feed_image','',1),(8,'latest_media_count','4',1),(9,'latest_media_categories','1,4,2,5,3',1),(10,'thumb_max_size','140',1),(11,'thumb_max_size_homecontent','90',1),(12,'auto_validate','0',1);
/*!40000 ALTER TABLE `contrexx_module_podcast_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_podcast_template`
--

DROP TABLE IF EXISTS `contrexx_module_podcast_template`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_podcast_template` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `template` text COLLATE utf8_unicode_ci NOT NULL,
  `extensions` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `description` (`description`)
) ENGINE=MyISAM AUTO_INCREMENT=102 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_podcast_template`
--

LOCK TABLES `contrexx_module_podcast_template` WRITE;
/*!40000 ALTER TABLE `contrexx_module_podcast_template` DISABLE KEYS */;
INSERT INTO `contrexx_module_podcast_template` VALUES (50,'Video für Windows (Windows Media Player Plug-in)','<object id=\"podcastPlayer\" classid=\"clsid:6BF52A52-394A-11d3-B153-00C04F79FAA6\" standby=\"Loading Windows Media Player components...\" type=\"application/x-oleobject\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<embed type=\"application/x-mplayer2\" name=\"podcastPlayer\" showstatusbar=\"1\" src=\"[[MEDIUM_URL]]\" autostart=\"1\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]+70\" />\r\n<param name=\"URL\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"BufferingTime\" value=\"60\" />\r\n<param name=\"AllowChangeDisplaySize\" value=\"true\" />\r\n<param name=\"AutoStart\" value=\"true\" />\r\n<param name=\"EnableContextMenu\" value=\"true\" />\r\n<param name=\"stretchToFit\" value=\"true\" />\r\n<param name=\"ShowControls\" value=\"true\" />\r\n<param name=\"ShowTracker\" value=\"true\" />\r\n<param name=\"uiMode\" value=\"full\" />\r\n</object>','avi, wmv'),(51,'RealMedia (RealMedia Player Plug-in)','<object id=\"podcastPlayer1\" classid=\"clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\">\r\n<param name=\"controls\" value=\"all\">\r\n<param name=\"autostart\" value=\"true\">\r\n<embed src=\"[[MEDIUM_URL]]\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" autostart=\"true\" type=\"video/x-pn-realvideo\" console=\"video1\" controls=\"All\" nojava=\"true\"></embed>\r\n</object>','ram, rpm'),(52,'QuickTime Film (QuickTime Plug-in)','<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"autoplay\" value=\"true\" />\r\n<param name=\"controller\" value=\"true\" />\r\n<param name=\"target\" value=\"myself\" />\r\n<param name=\"type\" value=\"video/quicktime\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" type=\"video/quicktime\" pluginspage=\"http://www.apple.com/quicktime/download/\" autoplay=\"true\" controller=\"true\" target=\"myself\" />\r\n</object>','mov, qt, mqv'),(53,'CAF-Audio (QuickTime Plug-in)','<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"autoplay\" value=\"true\" />\r\n<param name=\"controller\" value=\"true\" />\r\n<param name=\"target\" value=\"myself\" />\r\n<param name=\"type\" value=\"audio/x-caf\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" type=\"audio/x-caf\" pluginspage=\"http://www.apple.com/quicktime/download/\" autoplay=\"true\" controller=\"true\" target=\"myself\" />\r\n</object>','caf'),(54,'AAC-Audio (QuickTime Plug-in)','<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"autoplay\" value=\"true\" />\r\n<param name=\"controller\" value=\"true\" />\r\n<param name=\"target\" value=\"myself\" />\r\n<param name=\"type\" value=\"audio/x-aac\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" type=\"audio/x-aac\" pluginspage=\"http://www.apple.com/quicktime/download/\" autoplay=\"true\" controller=\"true\" target=\"myself\" />\r\n</object>','aac, adts'),(55,'AMR-Audio (QuickTime Plug-in)','<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"autoplay\" value=\"true\" />\r\n<param name=\"controller\" value=\"true\" />\r\n<param name=\"target\" value=\"myself\" />\r\n<param name=\"type\" value=\"audio/AMR\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" type=\"audio/AMR\" pluginspage=\"http://www.apple.com/quicktime/download/\" autoplay=\"true\" controller=\"true\" target=\"myself\" />\r\n</object>','amr'),(56,'GSM-Audio (QuickTime Plug-in)','<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"autoplay\" value=\"true\" />\r\n<param name=\"controller\" value=\"true\" />\r\n<param name=\"target\" value=\"myself\" />\r\n<param name=\"type\" value=\"audio/x-gsm\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" type=\"audio/x-gsm\" pluginspage=\"http://www.apple.com/quicktime/download/\" autoplay=\"true\" controller=\"true\" target=\"myself\" />\r\n</object>','gsm'),(57,'QUALCOMM PureVoice Audio (QuickTime Plug-in)','<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"autoplay\" value=\"true\" />\r\n<param name=\"controller\" value=\"true\" />\r\n<param name=\"target\" value=\"myself\" />\r\n<param name=\"type\" value=\"audio/vnd.qcelp\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" type=\"audio/vnd.qcelp\" pluginspage=\"http://www.apple.com/quicktime/download/\" autoplay=\"true\" controller=\"true\" target=\"myself\" />\r\n</object>','qcp'),(58,'MIDI (QuickTime Plug-in)','<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"autoplay\" value=\"true\" />\r\n<param name=\"controller\" value=\"true\" />\r\n<param name=\"target\" value=\"myself\" />\r\n<param name=\"type\" value=\"audio/x-midi\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" type=\"audio/x-midi\" pluginspage=\"http://www.apple.com/quicktime/download/\" autoplay=\"true\" controller=\"true\" target=\"myself\" />\r\n</object>','mid, midi, smf, kar'),(59,'uLaw/AU-Audio (QuickTime Plug-in)','<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"autoplay\" value=\"true\" />\r\n<param name=\"controller\" value=\"true\" />\r\n<param name=\"target\" value=\"myself\" />\r\n<param name=\"type\" value=\"audio/basic\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" type=\"audio/basic\" pluginspage=\"http://www.apple.com/quicktime/download/\" autoplay=\"true\" controller=\"true\" target=\"myself\" />\r\n</object>','au, snd, ulw'),(60,'AIFF-Audio (QuickTime Plug-in)','<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"autoplay\" value=\"true\" />\r\n<param name=\"controller\" value=\"true\" />\r\n<param name=\"target\" value=\"myself\" />\r\n<param name=\"type\" value=\"audio/x-aiff\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" type=\"audio/x-aiff\" pluginspage=\"http://www.apple.com/quicktime/download/\" autoplay=\"true\" controller=\"true\" target=\"myself\" />\r\n</object>','aiff, aif, aifc, cdda'),(61,'WAVE-Audio (QuickTime Plug-in)','<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"autoplay\" value=\"true\" />\r\n<param name=\"controller\" value=\"true\" />\r\n<param name=\"target\" value=\"myself\" />\r\n<param name=\"type\" value=\"audio/x-wav\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" type=\"audio/x-wav\" pluginspage=\"http://www.apple.com/quicktime/download/\" autoplay=\"true\" controller=\"true\" target=\"myself\" />\r\n</object>','wav, bwf'),(62,'Video für Windows (AVI) (QuickTime Plug-in)','<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"autoplay\" value=\"true\" />\r\n<param name=\"controller\" value=\"true\" />\r\n<param name=\"target\" value=\"myself\" />\r\n<param name=\"type\" value=\"video/x-msvideo\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" type=\"video/x-msvideo\" pluginspage=\"http://www.apple.com/quicktime/download/\" autoplay=\"true\" controller=\"true\" target=\"myself\" />\r\n</object>','avi, vfw'),(63,'AutoDesk Animator (FLC) (QuickTime Plug-in)','<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"autoplay\" value=\"true\" />\r\n<param name=\"controller\" value=\"true\" />\r\n<param name=\"target\" value=\"myself\" />\r\n<param name=\"type\" value=\"video/flc\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" type=\"video/flc\" pluginspage=\"http://www.apple.com/quicktime/download/\" autoplay=\"true\" controller=\"true\" target=\"myself\" />\r\n</object>','flc, fli, cel'),(64,'Digitales Video (DV) (QuickTime Plug-in)','<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"autoplay\" value=\"true\" />\r\n<param name=\"controller\" value=\"true\" />\r\n<param name=\"target\" value=\"myself\" />\r\n<param name=\"type\" value=\"video/x-dv\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" type=\"video/x-dv\" pluginspage=\"http://www.apple.com/quicktime/download/\" autoplay=\"true\" controller=\"true\" target=\"myself\" />\r\n</object>','dv, dif'),(65,'SDP-Stream-Beschreibung (QuickTime Plug-in)','<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"autoplay\" value=\"true\" />\r\n<param name=\"controller\" value=\"true\" />\r\n<param name=\"target\" value=\"myself\" />\r\n<param name=\"type\" value=\"application/x-sdp\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" type=\"application/x-sdp\" pluginspage=\"http://www.apple.com/quicktime/download/\" autoplay=\"true\" controller=\"true\" target=\"myself\" />\r\n</object>','sdp'),(66,'RTSP-Stream-Beschreibung (QuickTime Plug-in)','<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"autoplay\" value=\"true\" />\r\n<param name=\"controller\" value=\"true\" />\r\n<param name=\"target\" value=\"myself\" />\r\n<param name=\"type\" value=\"application/x-rtsp\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" type=\"application/x-rtsp\" pluginspage=\"http://www.apple.com/quicktime/download/\" autoplay=\"true\" controller=\"true\" target=\"myself\" />\r\n</object>','rtsp, rts'),(67,'MP3-Wiedergabeliste (QuickTime Plug-in)','<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"autoplay\" value=\"true\" />\r\n<param name=\"controller\" value=\"true\" />\r\n<param name=\"target\" value=\"myself\" />\r\n<param name=\"type\" value=\"audio/x-mpegurl\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" type=\"audio/x-mpegurl\" pluginspage=\"http://www.apple.com/quicktime/download/\" autoplay=\"true\" controller=\"true\" target=\"myself\" />\r\n</object>','m3u, m3url'),(68,'MPEG-Medien (QuickTime Plug-in)','<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"autoplay\" value=\"true\" />\r\n<param name=\"controller\" value=\"true\" />\r\n<param name=\"target\" value=\"myself\" />\r\n<param name=\"type\" value=\"video/x-mpeg\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" type=\"video/x-mpeg\" pluginspage=\"http://www.apple.com/quicktime/download/\" autoplay=\"true\" controller=\"true\" target=\"myself\" />\r\n</object>','mpeg, mpg, m1s, m1v, m1a, m75, m15, mp2'),(69,'3GPP-Medien (QuickTime Plug-in)','<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"autoplay\" value=\"true\" />\r\n<param name=\"controller\" value=\"true\" />\r\n<param name=\"target\" value=\"myself\" />\r\n<param name=\"type\" value=\"video/3gpp\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" type=\"video/3gpp\" pluginspage=\"http://www.apple.com/quicktime/download/\" autoplay=\"true\" controller=\"true\" target=\"myself\" />\r\n</object>','3gp, 3gpp'),(70,'3GPP2-Medien (QuickTime Plug-in)','<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"autoplay\" value=\"true\" />\r\n<param name=\"controller\" value=\"true\" />\r\n<param name=\"target\" value=\"myself\" />\r\n<param name=\"type\" value=\"video/3gpp2\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" type=\"video/3gpp2\" pluginspage=\"http://www.apple.com/quicktime/download/\" autoplay=\"true\" controller=\"true\" target=\"myself\" />\r\n</object>','3g2, 3gp2'),(71,'SD-Video (QuickTime Plug-in)','<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"autoplay\" value=\"true\" />\r\n<param name=\"controller\" value=\"true\" />\r\n<param name=\"target\" value=\"myself\" />\r\n<param name=\"type\" value=\"video/sd-video\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" type=\"video/sd-video\" pluginspage=\"http://www.apple.com/quicktime/download/\" autoplay=\"true\" controller=\"true\" target=\"myself\" />\r\n</object>','sdv'),(72,'AMC-Medien (QuickTime Plug-in)','<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"autoplay\" value=\"true\" />\r\n<param name=\"controller\" value=\"true\" />\r\n<param name=\"target\" value=\"myself\" />\r\n<param name=\"type\" value=\"application/x-mpeg\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" type=\"application/x-mpeg\" pluginspage=\"http://www.apple.com/quicktime/download/\" autoplay=\"true\" controller=\"true\" target=\"myself\" />\r\n</object>','amc'),(73,'MPEG-4-Medien (QuickTime Plug-in)','<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"autoplay\" value=\"true\" />\r\n<param name=\"controller\" value=\"true\" />\r\n<param name=\"target\" value=\"myself\" />\r\n<param name=\"type\" value=\"video/mp4\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" type=\"video/mp4\" pluginspage=\"http://www.apple.com/quicktime/download/\" autoplay=\"true\" controller=\"true\" target=\"myself\" />\r\n</object>','mp4'),(74,'AAC-Audiodatei (QuickTime Plug-in)','<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"autoplay\" value=\"true\" />\r\n<param name=\"controller\" value=\"true\" />\r\n<param name=\"target\" value=\"myself\" />\r\n<param name=\"type\" value=\"audio/x-m4a\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" type=\"audio/x-m4a\" pluginspage=\"http://www.apple.com/quicktime/download/\" autoplay=\"true\" controller=\"true\" target=\"myself\" />\r\n</object>','m4a'),(75,'AAC-Audio (geschützt) (QuickTime Plug-in)','<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"autoplay\" value=\"true\" />\r\n<param name=\"controller\" value=\"true\" />\r\n<param name=\"target\" value=\"myself\" />\r\n<param name=\"type\" value=\"audio/x-m4p\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" type=\"audio/x-m4p\" pluginspage=\"http://www.apple.com/quicktime/download/\" autoplay=\"true\" controller=\"true\" target=\"myself\" />\r\n</object>','m4p'),(76,'ACC-Audiobuch (QuickTime Plug-in)','<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"autoplay\" value=\"true\" />\r\n<param name=\"controller\" value=\"true\" />\r\n<param name=\"target\" value=\"myself\" />\r\n<param name=\"type\" value=\"audio/x-m4b\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" type=\"audio/x-m4b\" pluginspage=\"http://www.apple.com/quicktime/download/\" autoplay=\"true\" controller=\"true\" target=\"myself\" />\r\n</object>','m4b'),(77,'Video (geschützt) (QuickTime Plug-in)','<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"autoplay\" value=\"true\" />\r\n<param name=\"controller\" value=\"true\" />\r\n<param name=\"target\" value=\"myself\" />\r\n<param name=\"type\" value=\"video/x-m4v\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" type=\"video/x-m4v\" pluginspage=\"http://www.apple.com/quicktime/download/\" autoplay=\"true\" controller=\"true\" target=\"myself\" />\r\n</object>','m4v'),(78,'MP3-Audio (QuickTime Plug-in)','<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"autoplay\" value=\"true\" />\r\n<param name=\"controller\" value=\"true\" />\r\n<param name=\"target\" value=\"myself\" />\r\n<param name=\"type\" value=\"audio/x-mpeg\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" type=\"audio/x-mpeg\" pluginspage=\"http://www.apple.com/quicktime/download/\" autoplay=\"true\" controller=\"true\" target=\"myself\" />\r\n</object>','mp3, swa'),(79,'Sound Designer II (QuickTime Plug-in)','<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"autoplay\" value=\"true\" />\r\n<param name=\"controller\" value=\"true\" />\r\n<param name=\"target\" value=\"myself\" />\r\n<param name=\"type\" value=\"audio/x-sd2\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" type=\"audio/x-sd2\" pluginspage=\"http://www.apple.com/quicktime/download/\" autoplay=\"true\" controller=\"true\" target=\"myself\" />\r\n</object>','sd2'),(80,'BMP-Bild (QuickTime Plug-in)','<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"autoplay\" value=\"true\" />\r\n<param name=\"controller\" value=\"true\" />\r\n<param name=\"target\" value=\"myself\" />\r\n<param name=\"type\" value=\"image/x-bmp\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" type=\"image/x-bmp\" pluginspage=\"http://www.apple.com/quicktime/download/\" autoplay=\"true\" controller=\"true\" target=\"myself\" />\r\n</object>','bmp, dib'),(81,'MacPaint Bild (QuickTime Plug-in)','<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"autoplay\" value=\"true\" />\r\n<param name=\"controller\" value=\"true\" />\r\n<param name=\"target\" value=\"myself\" />\r\n<param name=\"type\" value=\"image/x-macpaint\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" type=\"image/x-macpaint\" pluginspage=\"http://www.apple.com/quicktime/download/\" autoplay=\"true\" controller=\"true\" target=\"myself\" />\r\n</object>','pntg, pnt, mac'),(82,'PICT-Bild (QuickTime Plug-in)','<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"autoplay\" value=\"true\" />\r\n<param name=\"controller\" value=\"true\" />\r\n<param name=\"target\" value=\"myself\" />\r\n<param name=\"type\" value=\"image/x-pict\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" type=\"image/x-pict\" pluginspage=\"http://www.apple.com/quicktime/download/\" autoplay=\"true\" controller=\"true\" target=\"myself\" />\r\n</object>','pict, pic, pct'),(83,'PNG-Bild (QuickTime Plug-in)','<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"autoplay\" value=\"true\" />\r\n<param name=\"controller\" value=\"true\" />\r\n<param name=\"target\" value=\"myself\" />\r\n<param name=\"type\" value=\"image/x-png\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" type=\"image/x-png\" pluginspage=\"http://www.apple.com/quicktime/download/\" autoplay=\"true\" controller=\"true\" target=\"myself\" />\r\n</object>','png'),(84,'QuickTime Bild (QuickTime Plug-in)','<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"autoplay\" value=\"true\" />\r\n<param name=\"controller\" value=\"true\" />\r\n<param name=\"target\" value=\"myself\" />\r\n<param name=\"type\" value=\"image/x-quicktime\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" type=\"image/x-quicktime\" pluginspage=\"http://www.apple.com/quicktime/download/\" autoplay=\"true\" controller=\"true\" target=\"myself\" />\r\n</object>','qtif, qti'),(85,'SGI-Bild (QuickTime Plug-in)','<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"autoplay\" value=\"true\" />\r\n<param name=\"controller\" value=\"true\" />\r\n<param name=\"target\" value=\"myself\" />\r\n<param name=\"type\" value=\"image/x-sgi\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" type=\"image/x-sgi\" pluginspage=\"http://www.apple.com/quicktime/download/\" autoplay=\"true\" controller=\"true\" target=\"myself\" />\r\n</object>','sgi, rgb'),(86,'TGA-Bild (QuickTime Plug-in)','<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"autoplay\" value=\"true\" />\r\n<param name=\"controller\" value=\"true\" />\r\n<param name=\"target\" value=\"myself\" />\r\n<param name=\"type\" value=\"image/x-targa\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" type=\"image/x-targa\" pluginspage=\"http://www.apple.com/quicktime/download/\" autoplay=\"true\" controller=\"true\" target=\"myself\" />\r\n</object>','targa, tga'),(87,'TIFF-Bild (QuickTime Plug-in)','<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"autoplay\" value=\"true\" />\r\n<param name=\"controller\" value=\"true\" />\r\n<param name=\"target\" value=\"myself\" />\r\n<param name=\"type\" value=\"image/x-tiff\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" type=\"image/x-tiff\" pluginspage=\"http://www.apple.com/quicktime/download/\" autoplay=\"true\" controller=\"true\" target=\"myself\" />\r\n</object>','tif, tiff'),(88,'Photoshop-Bild (QuickTime Plug-in)','<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"autoplay\" value=\"true\" />\r\n<param name=\"controller\" value=\"true\" />\r\n<param name=\"target\" value=\"myself\" />\r\n<param name=\"type\" value=\"image/x-photoshop\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" type=\"image/x-photoshop\" pluginspage=\"http://www.apple.com/quicktime/download/\" autoplay=\"true\" controller=\"true\" target=\"myself\" />\r\n</object>','psd'),(89,'JPEG2000 image (QuickTime Plug-in)','<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"autoplay\" value=\"true\" />\r\n<param name=\"controller\" value=\"true\" />\r\n<param name=\"target\" value=\"myself\" />\r\n<param name=\"type\" value=\"image/jp2\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" type=\"image/jp2\" pluginspage=\"http://www.apple.com/quicktime/download/\" autoplay=\"true\" controller=\"true\" target=\"myself\" />\r\n</object>','jp2'),(90,'SMIL 1.0 (QuickTime Plug-in)','<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"autoplay\" value=\"true\" />\r\n<param name=\"controller\" value=\"true\" />\r\n<param name=\"target\" value=\"myself\" />\r\n<param name=\"type\" value=\"application/smil\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" type=\"application/smil\" pluginspage=\"http://www.apple.com/quicktime/download/\" autoplay=\"true\" controller=\"true\" target=\"myself\" />\r\n</object>','smi, sml, smil'),(91,'Flash-Medien (QuckTime Plug-in)','<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"autoplay\" value=\"true\" />\r\n<param name=\"controller\" value=\"true\" />\r\n<param name=\"target\" value=\"myself\" />\r\n<param name=\"type\" value=\"application/x-shockwave-flash\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.apple.com/quicktime/download/\" autoplay=\"true\" controller=\"true\" target=\"myself\" />\r\n</object>','swf'),(92,'QuickTime HTML (QHTML) (QuickTime Plug-in)','<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"autoplay\" value=\"true\" />\r\n<param name=\"controller\" value=\"true\" />\r\n<param name=\"target\" value=\"myself\" />\r\n<param name=\"type\" value=\"text/x-html-insertion\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" type=\"text/x-html-insertion\" pluginspage=\"http://www.apple.com/quicktime/download/\" autoplay=\"true\" controller=\"true\" target=\"myself\" />\r\n</object>','qht, qhtm'),(93,'MP3-Audio (RealPlayer Player)','<object id=\"videoplayer1\" classid=\"clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"controls\" value=\"all\" />\r\n<param name=\"autostart\" value=\"true\" />\r\n<param name=\"type\" value=\"audio/x-mpeg\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" autostart=\"true\" type=\"audio/x-mpeg\" console=\"video1\" controls=\"All\" nojava=\"true\"></embed>\r\n</object>','mp3'),(94,'MP3-Wiedergabeliste (RealPlayer Plug-in)','<object id=\"videoplayer1\" classid=\"clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"controls\" value=\"all\" />\r\n<param name=\"autostart\" value=\"true\" />\r\n<param name=\"type\" value=\"audio/x-mpegurl\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" autostart=\"true\" type=\"audio/x-mpegurl\" console=\"video1\" controls=\"All\" nojava=\"true\"></embed>\r\n</object>','m3u, m3url'),(95,'WAVE-Audio (RealPlayer Plug-in)','<object id=\"videoplayer1\" classid=\"clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\">\r\n<param name=\"src\" value=\"[[MEDIUM_URL]]\" />\r\n<param name=\"controls\" value=\"all\" />\r\n<param name=\"autostart\" value=\"true\" />\r\n<param name=\"type\" value=\"audio/x-wav\" />\r\n<embed src=\"[[MEDIUM_URL]]\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\" autostart=\"true\" type=\"audio/x-wav\" console=\"video1\" controls=\"All\" nojava=\"true\"></embed>\r\n</object>','wav'),(100,'Flash-Video (Flash Video File)','<object\r\n  type=\"application/x-shockwave-flash\"\r\n  data=\"[[ASCMS_PATH_OFFSET]]/modules/podcast/lib/FlowPlayer.swf\" \r\n	width=\"[[MEDIUM_WIDTH]]\"\r\n  height=\"[[MEDIUM_HEIGHT]]\"\r\n  id=\"FlowPlayer\">\r\n    <param name=\"movie\" value=\"[[ASCMS_PATH_OFFSET]]/modules/podcast/lib/FlowPlayer.swf\" />\r\n    <param name=\"quality\" value=\"high\" />\r\n    <param name=\"scale\" value=\"noScale\" />\r\n    <param name=\"allowfullscreen\" value=\"true\" />\r\n    <param name=\"allowScriptAccess\" value=\"always\" />\r\n    <param name=\"allownetworking\" value=\"all\" />\r\n    <param name=\"flashvars\" value=\"config={\r\n      autoPlay:true,\r\n      loop: false,\r\n      autoRewind: true,\r\n      videoFile: \'[[MEDIUM_URL]]\',\r\n      fullScreenScriptURL:\'[[ASCMS_PATH_OFFSET]]/modules/podcast/lib/fullscreen.js\',\r\n      initialScale:\'orig\'}\" />\r\n</object>','flv'),(101,'YouTube Video','<object width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\"><param name=\"movie\" value=\"[[MEDIUM_URL]]\"></param><param name=\"wmode\" value=\"transparent\"></param><embed src=\"[[MEDIUM_URL]]\" type=\"application/x-shockwave-flash\" wmode=\"transparent\" width=\"[[MEDIUM_WIDTH]]\" height=\"[[MEDIUM_HEIGHT]]\"></embed></object>','swf');
/*!40000 ALTER TABLE `contrexx_module_podcast_template` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_recommend`
--

DROP TABLE IF EXISTS `contrexx_module_recommend`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_recommend` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `lang_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_recommend`
--

LOCK TABLES `contrexx_module_recommend` WRITE;
/*!40000 ALTER TABLE `contrexx_module_recommend` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_recommend` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_repository`
--

DROP TABLE IF EXISTS `contrexx_module_repository`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_repository` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `moduleid` int(5) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cmd` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `expertmode` set('y','n') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  `parid` int(5) unsigned NOT NULL DEFAULT '0',
  `displaystatus` set('on','off') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'on',
  `username` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `displayorder` smallint(6) NOT NULL DEFAULT '100',
  UNIQUE KEY `contentid` (`id`),
  FULLTEXT KEY `fulltextindex` (`title`,`content`)
) ENGINE=MyISAM AUTO_INCREMENT=150 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_repository`
--

LOCK TABLES `contrexx_module_repository` WRITE;
/*!40000 ALTER TABLE `contrexx_module_repository` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_repository` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_shop_article_group`
--

DROP TABLE IF EXISTS `contrexx_module_shop_article_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_shop_article_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_shop_article_group`
--

LOCK TABLES `contrexx_module_shop_article_group` WRITE;
/*!40000 ALTER TABLE `contrexx_module_shop_article_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_shop_article_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_shop_attribute`
--

DROP TABLE IF EXISTS `contrexx_module_shop_attribute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_shop_attribute` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_shop_attribute`
--

LOCK TABLES `contrexx_module_shop_attribute` WRITE;
/*!40000 ALTER TABLE `contrexx_module_shop_attribute` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_shop_attribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_shop_categories`
--

DROP TABLE IF EXISTS `contrexx_module_shop_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_shop_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `ord` int(5) unsigned NOT NULL DEFAULT '0',
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `picture` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `flags` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `flags` (`flags`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_shop_categories`
--

LOCK TABLES `contrexx_module_shop_categories` WRITE;
/*!40000 ALTER TABLE `contrexx_module_shop_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_shop_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_shop_currencies`
--

DROP TABLE IF EXISTS `contrexx_module_shop_currencies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_shop_currencies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` char(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `symbol` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `rate` decimal(10,4) unsigned NOT NULL DEFAULT '1.0000',
  `ord` int(5) unsigned NOT NULL DEFAULT '0',
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `default` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `increment` decimal(6,5) unsigned NOT NULL DEFAULT '0.01000',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_shop_currencies`
--

LOCK TABLES `contrexx_module_shop_currencies` WRITE;
/*!40000 ALTER TABLE `contrexx_module_shop_currencies` DISABLE KEYS */;
INSERT INTO `contrexx_module_shop_currencies` VALUES (1,'CHF','CHF',1.0000,1,1,1,0.05000),(4,'EUR','€',0.8300,2,1,0,0.01000),(5,'USD','USD',1.0500,0,1,0,0.01000);
/*!40000 ALTER TABLE `contrexx_module_shop_currencies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_shop_customer_group`
--

DROP TABLE IF EXISTS `contrexx_module_shop_customer_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_shop_customer_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_shop_customer_group`
--

LOCK TABLES `contrexx_module_shop_customer_group` WRITE;
/*!40000 ALTER TABLE `contrexx_module_shop_customer_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_shop_customer_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_shop_discount_coupon`
--

DROP TABLE IF EXISTS `contrexx_module_shop_discount_coupon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_shop_discount_coupon` (
  `code` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `customer_id` int(10) unsigned NOT NULL DEFAULT '0',
  `payment_id` int(10) unsigned NOT NULL DEFAULT '0',
  `product_id` int(10) unsigned NOT NULL DEFAULT '0',
  `start_time` int(10) unsigned NOT NULL DEFAULT '0',
  `end_time` int(10) unsigned NOT NULL DEFAULT '0',
  `uses` int(10) unsigned NOT NULL DEFAULT '0',
  `global` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `minimum_amount` decimal(9,2) unsigned NOT NULL DEFAULT '0.00',
  `discount_amount` decimal(9,2) unsigned NOT NULL DEFAULT '0.00',
  `discount_rate` decimal(3,0) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`code`,`customer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_shop_discount_coupon`
--

LOCK TABLES `contrexx_module_shop_discount_coupon` WRITE;
/*!40000 ALTER TABLE `contrexx_module_shop_discount_coupon` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_shop_discount_coupon` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_shop_discountgroup_count_name`
--

DROP TABLE IF EXISTS `contrexx_module_shop_discountgroup_count_name`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_shop_discountgroup_count_name` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_shop_discountgroup_count_name`
--

LOCK TABLES `contrexx_module_shop_discountgroup_count_name` WRITE;
/*!40000 ALTER TABLE `contrexx_module_shop_discountgroup_count_name` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_shop_discountgroup_count_name` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_shop_discountgroup_count_rate`
--

DROP TABLE IF EXISTS `contrexx_module_shop_discountgroup_count_rate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_shop_discountgroup_count_rate` (
  `group_id` int(10) unsigned NOT NULL DEFAULT '0',
  `count` int(10) unsigned NOT NULL DEFAULT '1',
  `rate` decimal(5,2) unsigned NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`group_id`,`count`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_shop_discountgroup_count_rate`
--

LOCK TABLES `contrexx_module_shop_discountgroup_count_rate` WRITE;
/*!40000 ALTER TABLE `contrexx_module_shop_discountgroup_count_rate` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_shop_discountgroup_count_rate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_shop_importimg`
--

DROP TABLE IF EXISTS `contrexx_module_shop_importimg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_shop_importimg` (
  `img_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `img_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `img_cats` text COLLATE utf8_unicode_ci NOT NULL,
  `img_fields_file` text COLLATE utf8_unicode_ci NOT NULL,
  `img_fields_db` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`img_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_shop_importimg`
--

LOCK TABLES `contrexx_module_shop_importimg` WRITE;
/*!40000 ALTER TABLE `contrexx_module_shop_importimg` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_shop_importimg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_shop_lsv`
--

DROP TABLE IF EXISTS `contrexx_module_shop_lsv`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_shop_lsv` (
  `order_id` int(10) unsigned NOT NULL,
  `holder` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `bank` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `blz` tinytext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_shop_lsv`
--

LOCK TABLES `contrexx_module_shop_lsv` WRITE;
/*!40000 ALTER TABLE `contrexx_module_shop_lsv` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_shop_lsv` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_shop_manufacturer`
--

DROP TABLE IF EXISTS `contrexx_module_shop_manufacturer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_shop_manufacturer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_shop_manufacturer`
--

LOCK TABLES `contrexx_module_shop_manufacturer` WRITE;
/*!40000 ALTER TABLE `contrexx_module_shop_manufacturer` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_shop_manufacturer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_shop_option`
--

DROP TABLE IF EXISTS `contrexx_module_shop_option`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_shop_option` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `attribute_id` int(10) unsigned NOT NULL,
  `price` decimal(9,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_shop_option`
--

LOCK TABLES `contrexx_module_shop_option` WRITE;
/*!40000 ALTER TABLE `contrexx_module_shop_option` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_shop_option` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_shop_order_attributes`
--

DROP TABLE IF EXISTS `contrexx_module_shop_order_attributes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_shop_order_attributes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` int(10) unsigned NOT NULL DEFAULT '0',
  `attribute_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `option_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `price` decimal(9,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_shop_order_attributes`
--

LOCK TABLES `contrexx_module_shop_order_attributes` WRITE;
/*!40000 ALTER TABLE `contrexx_module_shop_order_attributes` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_shop_order_attributes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_shop_order_items`
--

DROP TABLE IF EXISTS `contrexx_module_shop_order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_shop_order_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL DEFAULT '0',
  `product_id` int(10) unsigned NOT NULL DEFAULT '0',
  `product_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `price` decimal(9,2) unsigned NOT NULL DEFAULT '0.00',
  `quantity` int(10) unsigned NOT NULL DEFAULT '0',
  `vat_rate` decimal(5,2) unsigned DEFAULT NULL,
  `weight` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `order` (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_shop_order_items`
--

LOCK TABLES `contrexx_module_shop_order_items` WRITE;
/*!40000 ALTER TABLE `contrexx_module_shop_order_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_shop_order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_shop_orders`
--

DROP TABLE IF EXISTS `contrexx_module_shop_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_shop_orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) unsigned NOT NULL DEFAULT '0',
  `currency_id` int(10) unsigned NOT NULL DEFAULT '0',
  `sum` decimal(9,2) unsigned NOT NULL DEFAULT '0.00',
  `date_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `gender` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `firstname` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zip` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country_id` int(10) unsigned DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vat_amount` decimal(9,2) unsigned NOT NULL DEFAULT '0.00',
  `shipment_amount` decimal(9,2) unsigned NOT NULL DEFAULT '0.00',
  `shipment_id` int(10) unsigned DEFAULT NULL,
  `payment_id` int(10) unsigned NOT NULL DEFAULT '0',
  `payment_amount` decimal(9,2) unsigned NOT NULL DEFAULT '0.00',
  `ip` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `host` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `lang_id` int(10) unsigned NOT NULL DEFAULT '0',
  `browser` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `note` text COLLATE utf8_unicode_ci NOT NULL,
  `modified_on` timestamp NULL DEFAULT NULL,
  `modified_by` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_gender` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_company` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_firstname` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_lastname` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_address` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_city` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_zip` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_country_id` int(10) unsigned DEFAULT NULL,
  `billing_phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_fax` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_shop_orders`
--

LOCK TABLES `contrexx_module_shop_orders` WRITE;
/*!40000 ALTER TABLE `contrexx_module_shop_orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_shop_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_shop_payment`
--

DROP TABLE IF EXISTS `contrexx_module_shop_payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_shop_payment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `processor_id` int(10) unsigned NOT NULL DEFAULT '0',
  `fee` decimal(9,2) unsigned NOT NULL DEFAULT '0.00',
  `free_from` decimal(9,2) unsigned NOT NULL DEFAULT '0.00',
  `ord` int(5) unsigned NOT NULL DEFAULT '0',
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_shop_payment`
--

LOCK TABLES `contrexx_module_shop_payment` WRITE;
/*!40000 ALTER TABLE `contrexx_module_shop_payment` DISABLE KEYS */;
INSERT INTO `contrexx_module_shop_payment` VALUES (2,1,2.00,20000.00,0,1),(9,4,10.00,15000.00,0,1),(12,2,2.00,10000.00,0,1),(13,9,0.00,0.00,0,1),(14,3,0.00,0.00,0,1),(15,10,2.00,1000.00,0,1);
/*!40000 ALTER TABLE `contrexx_module_shop_payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_shop_payment_processors`
--

DROP TABLE IF EXISTS `contrexx_module_shop_payment_processors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_shop_payment_processors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('internal','external') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'internal',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `company_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `picture` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_shop_payment_processors`
--

LOCK TABLES `contrexx_module_shop_payment_processors` WRITE;
/*!40000 ALTER TABLE `contrexx_module_shop_payment_processors` DISABLE KEYS */;
INSERT INTO `contrexx_module_shop_payment_processors` VALUES (1,'external','saferpay','Saferpay is a comprehensive Internet payment platform, specially developed for commercial applications. It provides a guarantee of secure payment processes over the Internet for merchants as well as for cardholders. Merchants benefit from the easy integration of the payment method into their e-commerce platform, and from the modularity with which they can take account of current and future requirements. Cardholders benefit from the security of buying from any shop that uses Saferpay.','http://www.saferpay.com/',1,'logo_saferpay.gif'),(2,'external','paypal','With more than 40 million member accounts in over 45 countries worldwide, PayPal is the world\'s largest online payment service. PayPal makes sending money as easy as sending email! Any PayPal member can instantly and securely send money to anyone in the U.S. with an email address. PayPal can also be used on a web-enabled cell phone. In the future, PayPal will be available to use on web-enabled pagers and other handheld devices.','http://www.paypal.com/',1,'logo_paypal.gif'),(3,'external','yellowpay','PostFinance vereinfacht das Inkasso im Online-Shop.','http://www.postfinance.ch/',1,'logo_postfinance.gif'),(4,'internal','internal','Internal no forms','',1,''),(9,'internal','internal_lsv','LSV with internal form','',1,''),(10,'external','datatrans','Die professionelle und komplette Payment-Lösung','http://datatrans.biz/',1,'logo_datatrans.gif'),(11,'external','mobilesolutions','PostFinance Mobile','https://postfinance.mobilesolutions.ch/',1,'logo_postfinance_mobile.gif'),(12,'external','paymill_cc','','https://www.paymill.com',1,''),(13,'external','paymill_elv','','https://www.paymill.com',1,''),(14,'external','paymill_iban','','https://www.paymill.com',1,'');
/*!40000 ALTER TABLE `contrexx_module_shop_payment_processors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_shop_pricelists`
--

DROP TABLE IF EXISTS `contrexx_module_shop_pricelists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_shop_pricelists` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `lang_id` int(10) unsigned NOT NULL DEFAULT '0',
  `border_on` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `header_on` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `header_left` text COLLATE utf8_unicode_ci,
  `header_right` text COLLATE utf8_unicode_ci,
  `footer_on` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `footer_left` text COLLATE utf8_unicode_ci,
  `footer_right` text COLLATE utf8_unicode_ci,
  `categories` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_shop_pricelists`
--

LOCK TABLES `contrexx_module_shop_pricelists` WRITE;
/*!40000 ALTER TABLE `contrexx_module_shop_pricelists` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_shop_pricelists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_shop_products`
--

DROP TABLE IF EXISTS `contrexx_module_shop_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_shop_products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `picture` varchar(4096) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `distribution` varchar(16) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `normalprice` decimal(9,2) NOT NULL DEFAULT '0.00',
  `resellerprice` decimal(9,2) NOT NULL DEFAULT '0.00',
  `stock` int(10) NOT NULL DEFAULT '10',
  `stock_visible` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `discountprice` decimal(9,2) NOT NULL DEFAULT '0.00',
  `discount_active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `b2b` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `b2c` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `date_start` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `manufacturer_id` int(10) unsigned DEFAULT NULL,
  `ord` int(10) NOT NULL DEFAULT '0',
  `vat_id` int(10) unsigned DEFAULT NULL,
  `weight` int(10) unsigned DEFAULT NULL,
  `flags` varchar(4096) COLLATE utf8_unicode_ci DEFAULT NULL,
  `group_id` int(10) unsigned DEFAULT NULL,
  `article_id` int(10) unsigned DEFAULT NULL,
  `usergroup_ids` varchar(4096) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  KEY `article_id` (`article_id`),
  FULLTEXT KEY `flags` (`flags`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_shop_products`
--

LOCK TABLES `contrexx_module_shop_products` WRITE;
/*!40000 ALTER TABLE `contrexx_module_shop_products` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_shop_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_shop_rel_countries`
--

DROP TABLE IF EXISTS `contrexx_module_shop_rel_countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_shop_rel_countries` (
  `zone_id` int(10) unsigned NOT NULL DEFAULT '0',
  `country_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`country_id`,`zone_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_shop_rel_countries`
--

LOCK TABLES `contrexx_module_shop_rel_countries` WRITE;
/*!40000 ALTER TABLE `contrexx_module_shop_rel_countries` DISABLE KEYS */;
INSERT INTO `contrexx_module_shop_rel_countries` VALUES (1,1),(1,2),(1,3),(1,4),(1,5),(1,6),(1,7),(1,8),(1,9),(1,10),(1,11),(1,12),(1,13),(1,14),(1,15),(1,16),(1,17),(1,18),(1,19),(1,20),(1,21),(1,22),(1,23),(1,24),(1,25),(1,26),(1,27),(1,28),(1,29),(1,30),(1,31),(1,32),(1,33),(1,34),(1,35),(1,36),(1,37),(1,38),(1,39),(1,40),(1,41),(1,42),(1,43),(1,44),(1,45),(1,46),(1,47),(1,48),(1,49),(1,50),(1,51),(1,52),(1,53),(1,54),(1,55),(1,56),(1,57),(1,58),(1,59),(1,60),(1,61),(1,62),(1,63),(1,64),(1,65),(1,66),(1,67),(1,68),(1,69),(1,70),(1,71),(1,72),(1,73),(1,74),(1,75),(1,76),(1,77),(1,78),(1,79),(1,80),(1,81),(3,81),(1,82),(1,83),(1,84),(1,85),(1,86),(1,87),(1,88),(1,89),(1,90),(1,91),(1,92),(1,93),(1,94),(1,95),(1,96),(1,97),(1,98),(1,99),(1,101),(1,102),(1,103),(1,104),(1,105),(1,106),(1,107),(1,108),(1,109),(1,110),(1,111),(1,112),(1,113),(1,114),(1,115),(1,116),(1,117),(1,118),(1,119),(1,120),(1,121),(1,122),(2,122),(1,123),(1,124),(1,125),(1,126),(1,127),(1,128),(1,129),(1,130),(1,131),(1,132),(1,133),(1,134),(1,135),(1,136),(1,137),(1,138),(1,139),(1,140),(1,141),(1,142),(1,143),(1,144),(1,145),(1,146),(1,147),(1,148),(1,149),(1,150),(1,151),(1,152),(1,153),(1,154),(1,155),(1,156),(1,157),(1,158),(1,159),(1,160),(1,161),(1,162),(1,163),(1,164),(1,165),(1,166),(1,167),(1,168),(1,169),(1,170),(1,171),(1,172),(1,173),(1,174),(1,175),(1,176),(1,177),(1,178),(1,179),(1,180),(1,181),(1,182),(1,183),(1,184),(1,185),(1,186),(1,187),(1,188),(1,189),(1,190),(1,191),(1,192),(1,193),(1,194),(1,195),(1,196),(1,197),(1,198),(1,199),(1,200),(1,201),(1,202),(1,203),(1,204),(2,204),(1,205),(1,206),(1,207),(1,208),(1,209),(1,210),(1,211),(1,212),(1,213),(1,214),(1,215),(1,216),(1,217),(1,218),(1,219),(1,220),(1,221),(1,222),(1,223),(1,224),(1,225),(1,226),(1,227),(1,228),(1,229),(1,230),(1,231),(1,232),(1,233),(1,234),(1,235),(1,236),(1,237),(1,238),(1,239);
/*!40000 ALTER TABLE `contrexx_module_shop_rel_countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_shop_rel_customer_coupon`
--

DROP TABLE IF EXISTS `contrexx_module_shop_rel_customer_coupon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_shop_rel_customer_coupon` (
  `code` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `customer_id` int(10) unsigned NOT NULL DEFAULT '0',
  `order_id` int(10) unsigned NOT NULL DEFAULT '0',
  `count` int(10) unsigned NOT NULL DEFAULT '0',
  `amount` decimal(9,2) unsigned NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`code`,`customer_id`,`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_shop_rel_customer_coupon`
--

LOCK TABLES `contrexx_module_shop_rel_customer_coupon` WRITE;
/*!40000 ALTER TABLE `contrexx_module_shop_rel_customer_coupon` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_shop_rel_customer_coupon` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_shop_rel_discount_group`
--

DROP TABLE IF EXISTS `contrexx_module_shop_rel_discount_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_shop_rel_discount_group` (
  `customer_group_id` int(10) unsigned NOT NULL DEFAULT '0',
  `article_group_id` int(10) unsigned NOT NULL DEFAULT '0',
  `rate` decimal(9,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`customer_group_id`,`article_group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_shop_rel_discount_group`
--

LOCK TABLES `contrexx_module_shop_rel_discount_group` WRITE;
/*!40000 ALTER TABLE `contrexx_module_shop_rel_discount_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_shop_rel_discount_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_shop_rel_payment`
--

DROP TABLE IF EXISTS `contrexx_module_shop_rel_payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_shop_rel_payment` (
  `zone_id` int(10) unsigned NOT NULL DEFAULT '0',
  `payment_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`zone_id`,`payment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_shop_rel_payment`
--

LOCK TABLES `contrexx_module_shop_rel_payment` WRITE;
/*!40000 ALTER TABLE `contrexx_module_shop_rel_payment` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_shop_rel_payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_shop_rel_product_attribute`
--

DROP TABLE IF EXISTS `contrexx_module_shop_rel_product_attribute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_shop_rel_product_attribute` (
  `product_id` int(10) unsigned NOT NULL DEFAULT '0',
  `option_id` int(10) unsigned NOT NULL,
  `ord` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`product_id`,`option_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_shop_rel_product_attribute`
--

LOCK TABLES `contrexx_module_shop_rel_product_attribute` WRITE;
/*!40000 ALTER TABLE `contrexx_module_shop_rel_product_attribute` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_shop_rel_product_attribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_shop_rel_shipper`
--

DROP TABLE IF EXISTS `contrexx_module_shop_rel_shipper`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_shop_rel_shipper` (
  `zone_id` int(10) unsigned NOT NULL DEFAULT '0',
  `shipper_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`shipper_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_shop_rel_shipper`
--

LOCK TABLES `contrexx_module_shop_rel_shipper` WRITE;
/*!40000 ALTER TABLE `contrexx_module_shop_rel_shipper` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_shop_rel_shipper` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_shop_shipment_cost`
--

DROP TABLE IF EXISTS `contrexx_module_shop_shipment_cost`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_shop_shipment_cost` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shipper_id` int(10) unsigned NOT NULL DEFAULT '0',
  `max_weight` int(10) unsigned DEFAULT NULL,
  `fee` decimal(9,2) unsigned DEFAULT NULL,
  `free_from` decimal(9,2) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_shop_shipment_cost`
--

LOCK TABLES `contrexx_module_shop_shipment_cost` WRITE;
/*!40000 ALTER TABLE `contrexx_module_shop_shipment_cost` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_shop_shipment_cost` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_shop_shipper`
--

DROP TABLE IF EXISTS `contrexx_module_shop_shipper`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_shop_shipper` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `ord` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_shop_shipper`
--

LOCK TABLES `contrexx_module_shop_shipper` WRITE;
/*!40000 ALTER TABLE `contrexx_module_shop_shipper` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_shop_shipper` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_shop_vat`
--

DROP TABLE IF EXISTS `contrexx_module_shop_vat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_shop_vat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rate` decimal(5,2) unsigned NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_shop_vat`
--

LOCK TABLES `contrexx_module_shop_vat` WRITE;
/*!40000 ALTER TABLE `contrexx_module_shop_vat` DISABLE KEYS */;
INSERT INTO `contrexx_module_shop_vat` VALUES (1,0.00),(2,19.00),(3,7.00),(4,5.50),(5,9.00),(6,16.00),(7,20.00),(8,10.00),(9,12.00),(10,8.00),(11,3.60),(12,2.40),(13,17.50),(14,5.00);
/*!40000 ALTER TABLE `contrexx_module_shop_vat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_shop_zones`
--

DROP TABLE IF EXISTS `contrexx_module_shop_zones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_shop_zones` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_shop_zones`
--

LOCK TABLES `contrexx_module_shop_zones` WRITE;
/*!40000 ALTER TABLE `contrexx_module_shop_zones` DISABLE KEYS */;
INSERT INTO `contrexx_module_shop_zones` VALUES (1,1),(2,1),(3,1);
/*!40000 ALTER TABLE `contrexx_module_shop_zones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_u2u_address_list`
--

DROP TABLE IF EXISTS `contrexx_module_u2u_address_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_u2u_address_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `buddies_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_u2u_address_list`
--

LOCK TABLES `contrexx_module_u2u_address_list` WRITE;
/*!40000 ALTER TABLE `contrexx_module_u2u_address_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_u2u_address_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_u2u_message_log`
--

DROP TABLE IF EXISTS `contrexx_module_u2u_message_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_u2u_message_log` (
  `message_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `message_text` text COLLATE utf8_unicode_ci NOT NULL,
  `message_title` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_u2u_message_log`
--

LOCK TABLES `contrexx_module_u2u_message_log` WRITE;
/*!40000 ALTER TABLE `contrexx_module_u2u_message_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_u2u_message_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_u2u_sent_messages`
--

DROP TABLE IF EXISTS `contrexx_module_u2u_sent_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_u2u_sent_messages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(11) unsigned NOT NULL DEFAULT '0',
  `message_id` int(11) unsigned NOT NULL DEFAULT '0',
  `receiver_id` int(11) unsigned NOT NULL DEFAULT '0',
  `mesage_open_status` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `date_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_u2u_sent_messages`
--

LOCK TABLES `contrexx_module_u2u_sent_messages` WRITE;
/*!40000 ALTER TABLE `contrexx_module_u2u_sent_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_u2u_sent_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_u2u_settings`
--

DROP TABLE IF EXISTS `contrexx_module_u2u_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_u2u_settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_u2u_settings`
--

LOCK TABLES `contrexx_module_u2u_settings` WRITE;
/*!40000 ALTER TABLE `contrexx_module_u2u_settings` DISABLE KEYS */;
INSERT INTO `contrexx_module_u2u_settings` VALUES (1,'max_posting_size','2000'),(2,'max_posting_chars','2000'),(3,'wysiwyg_editor','1'),(4,'subject','Eine neue Nachricht von [senderName]'),(5,'from','Contrexx U2U Nachrichtensystem'),(6,'email_message','Hallo <strong>[receiverName]</strong>,<br />\r\n<br />\r\n<strong>[senderName]</strong> hat Ihnen eine private Nachricht gesendet. Um die Nachricht zu lesen, folgen Sie bitte folgendem Link:<br />\r\n<br />\r\nhttp://[domainName]/index.php?section=u2u&amp;cmd=notification<br />\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br />\r\n<br />');
/*!40000 ALTER TABLE `contrexx_module_u2u_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_module_u2u_user_log`
--

DROP TABLE IF EXISTS `contrexx_module_u2u_user_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_module_u2u_user_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(11) unsigned NOT NULL DEFAULT '0',
  `user_sent_items` int(11) unsigned NOT NULL DEFAULT '0',
  `user_unread_items` int(11) unsigned NOT NULL DEFAULT '0',
  `user_status` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_module_u2u_user_log`
--

LOCK TABLES `contrexx_module_u2u_user_log` WRITE;
/*!40000 ALTER TABLE `contrexx_module_u2u_user_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_module_u2u_user_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_modules`
--

DROP TABLE IF EXISTS `contrexx_modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_modules` (
  `id` int(2) unsigned DEFAULT NULL,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `distributor` char(50) COLLATE utf8_unicode_ci NOT NULL,
  `description_variable` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `status` set('y','n') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  `is_required` tinyint(1) NOT NULL DEFAULT '0',
  `is_core` tinyint(4) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `is_licensed` tinyint(1) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_modules`
--

LOCK TABLES `contrexx_modules` WRITE;
/*!40000 ALTER TABLE `contrexx_modules` DISABLE KEYS */;
INSERT INTO `contrexx_modules` VALUES (0,'','Comvation AG','','n',0,1,0,1),(1,'core','Comvation AG','TXT_CORE_MODULE_DESCRIPTION','n',1,1,1,1),(2,'stats','Comvation AG','TXT_STATS_MODULE_DESCRIPTION','n',0,1,1,1),(3,'gallery','Comvation AG','TXT_GALLERY_MODULE_DESCRIPTION','y',0,0,1,1),(4,'newsletter','Comvation AG','TXT_NEWSLETTER_MODULE_DESCRIPTION','y',0,0,1,1),(5,'search','Comvation AG','TXT_SEARCH_MODULE_DESCRIPTION','y',0,1,1,1),(6,'contact','Comvation AG','TXT_CONTACT_MODULE_DESCRIPTION','y',1,1,1,1),(7,'block','Comvation AG','TXT_BLOCK_MODULE_DESCRIPTION','n',0,0,1,1),(8,'news','Comvation AG','TXT_NEWS_MODULE_DESCRIPTION','y',1,1,1,1),(9,'media1','Comvation AG','TXT_MEDIA_MODULE_DESCRIPTION','y',0,1,1,1),(10,'guestbook','Comvation AG','TXT_GUESTBOOK_MODULE_DESCRIPTION','y',0,0,1,1),(11,'sitemap','Comvation AG','TXT_SITEMAP_MODULE_DESCRIPTION','y',0,1,1,1),(12,'directory','Comvation AG','TXT_LINKS_MODULE_DESCRIPTION','y',0,0,1,1),(13,'ids','Comvation AG','TXT_IDS_MODULE_DESCRIPTION','y',1,1,1,1),(14,'error','Comvation AG','TXT_ERROR_MODULE_DESCRIPTION','y',1,1,1,1),(15,'home','Comvation AG','TXT_HOME_MODULE_DESCRIPTION','y',1,1,1,1),(16,'shop','Comvation AG','TXT_SHOP_MODULE_DESCRIPTION','y',0,0,1,1),(17,'voting','Comvation AG','TXT_VOTING_MODULE_DESCRIPTION','y',0,0,1,1),(18,'login','Comvation AG','TXT_LOGIN_MODULE_DESCRIPTION','y',1,1,1,1),(19,'docsys','Comvation AG','TXT_DOC_SYS_MODULE_DESCRIPTION','y',0,0,1,1),(20,'forum','Comvation AG','TXT_FORUM_MODULE_DESCRIPTION','y',0,0,1,1),(21,'calendar','Comvation AG','TXT_CALENDAR_MODULE_DESCRIPTION','y',0,0,1,1),(22,'feed','Comvation AG','TXT_FEED_MODULE_DESCRIPTION','y',0,0,1,1),(23,'access','Comvation AG','TXT_COMMUNITY_MODULE_DESCRIPTION','y',0,1,1,1),(24,'media2','Comvation AG','TXT_MEDIA_MODULE_DESCRIPTION','y',0,1,1,1),(25,'media3','Comvation AG','TXT_MEDIA_MODULE_DESCRIPTION','y',0,1,1,1),(26,'fileBrowser','Comvation AG','TXT_FILEBROWSER_DESCRIPTION','n',1,1,1,1),(27,'recommend','Comvation AG','TXT_RECOMMEND_MODULE_DESCRIPTION','y',0,0,1,1),(30,'livecam','Comvation AG','TXT_LIVECAM_MODULE_DESCRIPTION','y',0,0,1,1),(31,'memberdir','Comvation AG','TXT_MEMBERDIR_MODULE_DESCRIPTION','y',0,0,1,1),(32,'nettools','Comvation AG','TXT_NETTOOLS_MODULE_DESCRIPTION','n',0,1,1,1),(33,'market','Comvation AG','TXT_MARKET_MODULE_DESCRIPTION','y',0,0,1,1),(35,'podcast','Comvation AG','TXT_PODCAST_MODULE_DESCRIPTION','y',0,0,1,1),(37,'immo','Comvation AG','TXT_IMMO_MODULE_DESCRIPTION','n',0,0,1,1),(38,'egov','Comvation AG','TXT_EGOVERNMENT_MODULE_DESCRIPTION','y',0,0,1,1),(39,'media4','Comvation AG','TXT_MEDIA_MODULE_DESCRIPTION','y',0,1,1,1),(41,'alias','Comvation AG','TXT_ALIAS_MODULE_DESCRIPTION','n',0,1,1,1),(44,'imprint','Comvation AG','TXT_IMPRINT_MODULE_DESCRIPTION','y',1,1,1,1),(45,'agb','Comvation AG','TXT_AGB_MODULE_DESCRIPTION','y',1,1,1,1),(46,'privacy','Comvation AG','TXT_PRIVACY_MODULE_DESCRIPTION','y',1,1,1,1),(47,'blog','Comvation AG','TXT_BLOG_MODULE_DESCRIPTION','y',0,0,0,1),(48,'data','Comvation AG','TXT_DATA_MODULE_DESCRIPTION','y',0,0,1,1),(49,'ecard','Comvation AG','TXT_ECARD_MODULE_DESCRIPTION','y',0,0,1,1),(52,'upload','Comvation AG','TXT_FILEUPLOADER_MODULE_DESCRIPTION','n',0,1,1,1),(53,'downloads','Comvation AG','TXT_DOWNLOADS_MODULE_DESCRIPTION','y',0,0,1,1),(54,'u2u','Comvation AG','TXT_U2U_MODULE_DESCRIPTION','y',0,0,1,1),(56,'knowledge','Comvation AG','TXT_KNOWLEDGE_MODULE_DESCRIPTION','y',0,0,1,1),(57,'jobs','Comvation AG','TXT_JOBS_MODULE_DESCRIPTION','y',0,0,1,1),(60,'mediadir','Comvation AG','TXT_MEDIADIR_MODULE_DESCRIPTION','y',0,0,1,1),(61,'captcha','Comvation AG','Catpcha Module','n',1,1,1,1),(62,'checkout','Comvation AG','TXT_CHECKOUT_MODULE_DESCRIPTION','y',0,0,1,1),(63,'jsondata','Comvation AG','Json Adapter','n',1,1,1,1),(64,'language','Comvation AG','TXT_LANGUAGE_SETTINGS','n',1,1,1,1),(65,'fulllanguage','Comvation AG','TXT_LANGUAGE_SETTINGS','n',1,1,1,1),(66,'license','Comvation AG','TXT_LICENSE','n',1,1,1,1),(67,'logout','Comvation AG','TXT_LOGIN_MODULE_DESCRIPTION','n',1,1,1,1),(68,'filesharing','Comvation AG','TXT_FILESHARING_MODULE_DESCRIPTION','y',0,0,1,1),(69,'crm','Comvation AG','TXT_CRM_MODULE_DESCRIPTION','n',1,0,1,1),(70,'Workbench','Comvation AG','TXT_MODULE_WORKBENCH','n',0,1,1,1),(71,'FrontendEditing','Comvation AG','TXT_MODULE_FRONTEND_EDITING','n',1,1,1,1),(72,'survey','Comvation AG','TXT_SURVEY_MODULE_DESCRIPTION','n',0,0,1,1);
/*!40000 ALTER TABLE `contrexx_modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_session_variable`
--

DROP TABLE IF EXISTS `contrexx_session_variable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_session_variable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `sessionid` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `lastused` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `key` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `value` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key_index` (`parent_id`,`key`,`sessionid`)
) ENGINE=InnoDB AUTO_INCREMENT=20688528 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_session_variable`
--

LOCK TABLES `contrexx_session_variable` WRITE;
/*!40000 ALTER TABLE `contrexx_session_variable` DISABLE KEYS */;
INSERT INTO `contrexx_session_variable` VALUES (2368346,0,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','userFrontendLangId','i:1;'),(2368347,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MjA1MjcxMTI1Njc3OQ__','d:14.5;'),(2368348,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MjAyMDUwMjY4NzQzMQ__','d:14.5;'),(2368349,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MjAyNjcxMDY4OTUzMw__','d:14.5;'),(2368350,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MjcwOTg0NjE2NjQyOA__','d:14.5;'),(2368351,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MjcxOTMyNDYwMjc0NQ__','d:14.5;'),(2368352,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MjczNjg1MjE1MTM0MQ__','d:14.5;'),(2368353,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MjE0MzQ4MzIxNTQ3Nw__','i:14;'),(2368354,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MjEzNzQ5Nzk4NzU5OA__','d:14.5;'),(2368355,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MjEzODg1MTI0MTY3NA__','d:14.5;'),(2368356,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','Mjg3NDc4MDc1MTc2NA__','d:14.5;'),(2368357,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','Mjg4MjgzNTIwNzUwNw__','d:14.5;'),(2368358,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MjgwMDUyNjIwMDc5Mw__','d:14.5;'),(2368359,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MjgwMzM3MjkyMTQyMg__','d:14.5;'),(2368360,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MjgwNTA5MTI3NDQzNg__','d:14.5;'),(2368361,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MjI3NzExMzgzOTk4Mw__','d:14.5;'),(2368362,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MjkwNzgwNjA0NTM3NQ__','d:14.5;'),(2368363,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MjkxNDQyMDI1OTY1MA__','d:14.5;'),(2368364,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MjM1MTk5MzM1NDAzNw__','d:14.5;'),(2368365,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MjM1NTMxMjE5Mzc0Mw__','d:14.5;'),(2368366,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MjM2NTg1NTQ0MTg5NA__','d:14.5;'),(2368367,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MjMzMTgxNjQ2NjA1OQ__','d:14.5;'),(2368368,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MjQ2Njc4MzMxMjYxNQ__','d:14.5;'),(2368369,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MjQ3NjI2MjIyMjUwOQ__','d:14.5;'),(2368370,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MjQwOTg5NjU4NDY5Mw__','d:14.5;'),(2368371,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MjQyOTkwMTM2Mjg2Mg__','d:14.5;'),(2368372,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MjU0MDA5OTk0MTE5NA__','d:14.5;'),(2368373,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MjU2MDczNDAzMjY1Mw__','d:14.5;'),(2368374,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MjU2MjA2NTQwNTc3MQ__','d:14.5;'),(2368375,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MjY2OTAxMzY0NTQ5OQ__','d:14.5;'),(2368376,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MjY4NDU5NzkxMjcxMA__','d:14.5;'),(2368377,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MjY4NTEyOTI1NDEyNQ__','d:14.5;'),(2368378,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MjY5MDgwODYwNTQwMg__','d:14.5;'),(2368379,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MjYwODU5Mzc0ODQxNg__','d:14.5;'),(2368380,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MjYxOTI0ODYzMDk0NA__','d:14.5;'),(2368381,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MTA2MDcxODM3NjY1NQ__','d:14.5;'),(2368382,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MTc1ODc5NDIwNjE5NA__','d:14.5;'),(2368383,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MTcwNjUzNDMzOTExNQ__','d:14.5;'),(2368384,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MTczMDg1OTc4NzIwMw__','d:14.5;'),(2368385,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MTE1NDIyNjY0NTM2MQ__','d:14.5;'),(2368386,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MTE4NTA1NzE4MzcyNw__','d:14.5;'),(2368387,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MTE5OTIyMDU5MjYyMQ__','d:14.5;'),(2368388,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MTEwNzY2OTg5MjI1NQ__','d:14.5;'),(2368389,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MTExNjgzNzgyOTM1MQ__','d:14.5;'),(2368390,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MTEyMTY0MzU2NDE5OA__','d:14.5;'),(2368391,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MTgwNjkwNDMxNDU1MQ__','d:14.5;'),(2368392,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MTgxNzAzMTI2MjkwOA__','d:14.5;'),(2368393,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MTgzMTcyMDEzNzUwMg__','d:14.5;'),(2368394,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MTIxMjk3ODA0OTE4MQ__','d:14.5;'),(2368395,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MTIzNTMxNTU3ODA1OA__','d:14.5;'),(2368396,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MTMwMDc5NTcwMTMzMg__','d:14.5;'),(2368397,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MTMxMDUxMjc1MzY2OQ__','d:14.5;'),(2368398,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MTMxODgyMjg2MTY0OQ__','d:14.5;'),(2368399,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MTMzNTgzMTIxMDAxNw__','d:14.5;'),(2368400,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MTQ2NDIzNjI2MjcyMA__','d:14.5;'),(2368401,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MTQ4OTM1ODg1OTEzNg__','d:14.5;'),(2368402,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MTQ5MTI1MDY2NzI1NQ__','d:14.5;'),(2368403,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MTQyMjU2MjYwMTA0NA__','d:14.5;'),(2368404,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MTQzNzM2Mzk2MDc4MA__','d:14.5;'),(2368405,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MTU4MDkxNDYxNzk4MQ__','d:14.5;'),(2368406,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MTYwNDc2MjkwOTQ2OA__','d:14.5;'),(2368407,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MTYwODEwNzAzMzE4NQ__','d:14.5;'),(2368408,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MTYxOTY5MzgyNDA5MA__','d:14.5;'),(2368409,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MzA1MDEwMzA4ODM3NQ__','d:14.5;'),(2368410,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MzA1MDkwODQzODM5NQ__','d:14.5;'),(2368411,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MzAxMzA4NDEzMjIyNA__','d:14.5;'),(2368412,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MzAyNjA0OTQ4MjE3MA__','d:14.5;'),(2368413,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','Mzc4NTc4NjUyMjU1Mg__','d:14.5;'),(2368414,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MzE1NDU5MzY2NjA4NA__','d:14.5;'),(2368415,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MzE5NzIyMDA3MzU0Nw__','d:14.5;'),(2368416,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MzEwNDEzNTE0OTYyNA__','d:14.5;'),(2368417,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MzExMzA4ODkyMDcxMg__','d:14.5;'),(2368418,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','Mzg1NTAyNDQ1ODM3NA__','d:14.5;'),(2368419,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','Mzg3ODU4Njg1MTUyNg__','d:14.5;'),(2368420,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','Mzg3OTg1ODkxNDI5Nw__','d:14.5;'),(2368421,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','Mzg4OTI1MTkzMDYzOQ__','d:14.5;'),(2368422,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MzI0Mzk0MzY5Nzc3Mg__','d:14.5;'),(2368423,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MzI4NTg4MDczNTYwOQ__','d:14.5;'),(2368424,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MzIxMDIwMTY3NjAwMw__','d:14.5;'),(2368425,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MzIyMjQ1MTI3NDI4Mw__','d:14.5;'),(2368426,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','Mzk1OTkyMTYwODY3OA__','d:14.5;'),(2368427,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','Mzk2OTY2ODY5NzU2NQ__','d:14.5;'),(2368428,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','Mzk3ODE3NzEyMTM3NA__','d:14.5;'),(2368429,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MzkyMjE1NDMwMzY0MA__','d:14.5;'),(2368430,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MzM0NDE1NjQ2MjIzMw__','d:14.5;'),(2368431,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MzM1MjYyODg1MjI0MA__','d:14.5;'),(2368432,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MzQ1ODIyODgzMzUwNw__','d:14.5;'),(2368433,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MzQ2OTc5NDgwNzk1NQ__','d:14.5;'),(2368434,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MzQ4NjEyNDcyOTI3MQ__','d:14.5;'),(2368435,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MzUxNDk3NzE2MzYzNQ__','d:14.5;'),(2368436,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','MzY1OTUxMDczNzI4NQ__','d:14.5;'),(2368437,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NDA3OTg5MDE0MTcyOQ__','d:14.5;'),(2368438,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NDAxOTY4NzU2MjI0OQ__','d:14.5;'),(2368439,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NDc2MzIxMjQ2MzgxOA__','d:14.5;'),(2368440,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NDc5NTgwODY2MjY2MA__','d:14.5;'),(2368441,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NDcwMTM3NTA2NTM3MQ__','d:14.5;'),(2368442,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NDcyODI2Njc2NzIyNg__','d:14.5;'),(2368443,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NDE2Mzk2MjcwNTA2MA__','d:14.5;'),(2368444,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NDExMDE0OTczODM3OA__','d:14.5;'),(2368445,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NDg1Nzc2OTUwOTc3Nw__','d:14.5;'),(2368446,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NDg5NzY0MTA2MjI3MA__','d:14.5;'),(2368447,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NDI2Mjc0MjczNDA0OA__','d:14.5;'),(2368448,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NDk2NDU4NzE4NDYwMA__','d:14.5;'),(2368449,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NDk5OTM0MTc0ODY1NA__','d:14.5;'),(2368450,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NDkwMjk0Nzg5NjYyNQ__','d:14.5;'),(2368451,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NDkzNDUwNzc5NDY3OA__','d:14.5;'),(2368452,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NDM4OTQ2MjM3MDQyNQ__','d:14.5;'),(2368453,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NDMxNDAzOTAzMDExMg__','d:14.5;'),(2368454,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NDMyNTU5MTg3ODQ5OQ__','d:14.5;'),(2368455,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NDQ2Njc3Mjk3MTY3NA__','d:14.5;'),(2368456,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NDQ3OTAxMDI1NjkzOA__','d:14.5;'),(2368457,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NDQ4NDc5Mzc3MDEyNg__','d:14.5;'),(2368458,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NDU5MzM0MDUwNTg0NQ__','d:14.5;'),(2368459,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NDU5NTU3NjA5NzcyMw__','d:14.5;'),(2368460,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NDUwMDU2Njc4OTQxNA__','d:14.5;'),(2368461,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NDUxMjcwNTE4MDc5NA__','d:14.5;'),(2368462,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NDY3NTY5NjkxNjQxMg__','d:14.5;'),(2368463,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NDYwNTEzOTg2NjAwNQ__','d:14.5;'),(2368464,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NjA4NzgwMTY1NDgyMw__','d:14.5;'),(2368465,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NjAyNzY2MzgzMzkyNw__','d:14.5;'),(2368466,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','Njc2MTIyNjYwMDUwMQ__','d:14.5;'),(2368467,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','Njc2NTEyNzE0NDI4OA__','d:14.5;'),(2368468,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NjcyMzU0MzQ0OTc3MA__','d:14.5;'),(2368469,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NjcyNzY3ODM0MzE4OA__','d:14.5;'),(2368470,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NjE1MTgyODk1OTU4NA__','d:14.5;'),(2368471,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NjExOTUwNzUzNjI5Mg__','d:14.5;'),(2368472,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NjEyMjIzNzMxMjYwNw__','d:14.5;'),(2368473,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NjgwNTA3Nzg2ODA0OA__','d:14.5;'),(2368474,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NjgyMDI0NzkzMDk0MA__','d:14.5;'),(2368475,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NjgyMjkzOTM4OTM4NQ__','d:14.5;'),(2368476,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NjI0Mjk0OTE5MDU0OQ__','d:14.5;'),(2368477,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NjM3MTcyMzE2ODUyOQ__','d:14.5;'),(2368478,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NjM3MTYyODUxMTY5Nw__','d:14.5;'),(2368479,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NjM3NDIwNTQ2NDk2Mg__','d:14.5;'),(2368480,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NjM4OTA0OTMzNzcxMQ__','d:14.5;'),(2368481,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NjMxMjA3MTEyMDgzMg__','d:14.5;'),(2368482,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NjMyMTcyNzEzNjE1MA__','d:14.5;'),(2368483,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NjQ0NjY3MDkxMTI3NA__','d:14.5;'),(2368484,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NjQwMDA4NTA1NjIwMA__','d:14.5;'),(2368485,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NjUxMTY4NTQ0NDk3Mw__','d:14.5;'),(2368486,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NjYwMzg1MjQzMzE1Mg__','d:14.5;'),(2368487,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NjYxOTUwNjE3Mzc2Nw__','d:14.5;'),(2368488,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NjYzMTkzODk2NjkyMg__','d:14.5;'),(2368489,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NTA1NjA3MzUwNzc1OQ__','d:14.5;'),(2368490,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NTA2OTQzNTcyNDA1Nw__','d:14.5;'),(2368491,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NTA4ODAwODMyNDE0OQ__','d:14.5;'),(2368492,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NTAzNzcwMDg5NTY4NQ__','d:14.5;'),(2368493,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NTE2MDYwMDA4MTU1MQ__','d:14.5;'),(2368494,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NTg0MDk5MjIwNzYzOA__','d:14.5;'),(2368495,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NTg0ODk0MzM4MTU3MA__','d:14.5;'),(2368496,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NTg4NjkyMzY5NTkxNA__','d:14.5;'),(2368497,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NTgzNzA4MzYyNTYwNw__','d:14.5;'),(2368498,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NTI3MzMzNjYwNzk2Mg__','d:14.5;'),(2368499,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NTI4NDc5MTQ5NzA0Nw__','d:14.5;'),(2368500,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NTIyMzk1OTQ1NzU5NA__','d:14.5;'),(2368501,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NTkxNjMyNTA4MjA3MQ__','d:14.5;'),(2368502,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NTkyNzQ5NTU2ODk5MA__','d:14.5;'),(2368503,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NTMzOTI3Njc3NjE4Mw__','d:14.5;'),(2368504,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NTQ0NzAxMjE5ODE1Nw__','d:14.5;'),(2368505,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NTQ2MjgzMzg2NjAxMQ__','d:14.5;'),(2368506,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NTQwMjYxNDU4NTU4OQ__','d:14.5;'),(2368507,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NTQyOTc2NzA4MTk3OQ__','d:14.5;'),(2368508,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NTU2MDE2MjMwODYyNQ__','d:14.5;'),(2368509,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NTU4MDA1NjA0NzUzMg__','d:14.5;'),(2368510,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NTUxMDc2NDM3NTMyOQ__','d:14.5;'),(2368511,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NTY4OTcxMTIyNzA4MQ__','d:14.5;'),(2368512,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NTY5MjE5MTQxOTY1Nw__','d:14.5;'),(2368513,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NzA0ODc4MzIwNzMxMg__','d:14.5;'),(2368514,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NzAxMTk4MDE2NDc5Ng__','d:14.5;'),(2368515,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NzAzMTgwODI1NjYzNw__','d:14.5;'),(2368516,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NzcwMTk0MzI5NjkzOQ__','d:14.5;'),(2368517,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NzExNDg4NTU1Njk3Nw__','d:14.5;'),(2368518,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NzExNDk0OTgyNTIxOQ__','d:14.5;'),(2368519,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NzExNzIwMzY1NjExOA__','d:14.5;'),(2368520,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NzEyNDYwODM5MjgyNw__','d:14.5;'),(2368521,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','Nzg2NDU4MjUwNjQ3NA__','d:14.5;'),(2368522,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NzI0MzUzMjcxMjU3MQ__','d:14.5;'),(2368523,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NzI4MDU3NTEyNTQ3OA__','d:14.5;'),(2368524,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NzIyODIyMDI3MDQ4MA__','d:14.5;'),(2368525,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','Nzk2ODE4NTIyMjcwNw__','d:14.5;'),(2368526,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NzkyMTgzODg0Njk4OA__','d:14.5;'),(2368527,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NzM0NzE2MjM2ODI0MQ__','d:14.5;'),(2368528,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NzM3OTUzNzc1NDIyNg__','d:14.5;'),(2368529,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NzQ2NDM5NTUwNDkxMA__','d:14.5;'),(2368530,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NzQ2OTE5NjM3ODI1Mw__','d:14.5;'),(2368531,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NzQ4Njc3NzYyOTcwMw__','d:14.5;'),(2368532,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NzU0ODk5NzIyNjE3MQ__','d:14.5;'),(2368533,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NzY2Mzg3NzE0MzUyNA__','d:14.5;'),(2368534,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NzYwOTMwMzMzODkxOA__','d:14.5;'),(2368535,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','ODA2NTcxNzQwMDA1MQ__','d:14.5;'),(2368536,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','ODA3MDk4NDE4OTg2NA__','d:14.5;'),(2368537,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','ODAwMjM5MTg5MTA4OA__','d:14.5;'),(2368538,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','ODc2ODg1NjE2NzMyNw__','d:14.5;'),(2368539,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','ODcwODg1NTI4NTc3NA__','d:14.5;'),(2368540,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','ODE5NzA5NTE1MzM4Nw__','d:14.5;'),(2368541,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','ODExNTg2MzQzMDc3OQ__','d:14.5;'),(2368542,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','ODExNTM4NzUyMzA4MQ__','d:14.5;'),(2368543,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','ODg2NjI3OTA0NDY1NA__','d:14.5;'),(2368544,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','ODg3NjQ0ODE2MjM2NQ__','d:14.5;'),(2368545,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','ODg4Njc0MjY5MDExMg__','d:14.5;'),(2368546,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','ODgzNTQzNDMzNjY4MA__','d:14.5;'),(2368547,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','ODI0NTA0NzEyODc1OQ__','d:14.5;'),(2368548,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','ODI1ODY5NDIxNjYwOQ__','d:14.5;'),(2368549,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','ODI3MDQyODg1NTkwMw__','d:14.5;'),(2368550,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','ODI5NDY2NTY0NDQxMA__','d:14.5;'),(2368551,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','ODIwMjkwNjQ5NDQ5NA__','d:14.5;'),(2368552,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','ODkwMjc1MDY1NDE0Ng__','d:14.5;'),(2368553,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','ODM4OTU3MzQ3NzIwOA__','d:14.5;'),(2368554,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','ODM5MTU2MDc4NDU0MQ__','d:14.5;'),(2368555,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','ODMxNTEzMDMxMjQ2MQ__','d:14.5;'),(2368556,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','ODQ2MTcwODUxMzA4OA__','d:14.5;'),(2368557,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','ODQxNDcxNjg4MTY5OQ__','d:14.5;'),(2368558,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','ODU2NjQ3NzEzOTQ4MA__','d:14.5;'),(2368559,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','ODU4OTMwMjY3NTMzMg__','d:14.5;'),(2368560,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','ODUwMzc3ODMzNzAzNQ__','d:14.5;'),(2368561,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','ODY1MDQ3OTI0NDUzMw__','d:14.5;'),(2368562,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','ODYxNjQ3OTM5MTIzMg__','d:14.5;'),(2368563,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','ODYyNTExMzc3NDA5MQ__','d:14.5;'),(2368564,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','ODYzNzk5OTkxMDg2MQ__','d:14.5;'),(2368565,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','OTA0MzYzNzM3NDg4MQ__','d:14.5;'),(2368566,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','OTA5MDk2ODM1MTgxMQ__','d:14.5;'),(2368567,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','OTc0Mjc3Njc2NzM1MA__','d:14.5;'),(2368568,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','OTc4NjUwNzA1NDY5Nw__','d:14.5;'),(2368569,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','OTcwMzk0ODE2NjY4Nw__','d:14.5;'),(2368570,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','OTE1MDE3NzQ1MzY0NA__','d:14.5;'),(2368571,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','OTE2ODM1NjYyODE1Nw__','d:14.5;'),(2368572,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','OTE3MzQyNjg3NDkxMw__','d:14.5;'),(2368573,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','OTE4NTI5MzY5MjYyOQ__','d:14.5;'),(2368574,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','OTEyNTkwOTMyOTM5Mg__','d:14.5;'),(2368575,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','OTg1ODU3MjYzODEyNw__','d:14.5;'),(2368576,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','OTg5NjY1NjAwNzk3MQ__','d:14.5;'),(2368577,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','OTgxNjY1ODE2NDM3NA__','d:14.5;'),(2368578,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','OTI1NDg4MTUzOTM4Mg__','d:14.5;'),(2368579,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','OTk4MDI2MjM4NjYxMg__','d:14.5;'),(2368580,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','OTkxODIwNjkwMzYxNw__','d:14.5;'),(2368581,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','OTM4NjQ3OTA4Mjk4Mg__','d:14.5;'),(2368582,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','OTQ0MzQ3MzIxNjYxMQ__','d:14.5;'),(2368583,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','OTQ2MTA0NDg3OTE2NA__','d:14.5;'),(2368584,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','OTU0Nzc5MjU3NzE4NA__','d:14.5;'),(2368585,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','OTUxMDAwNjg0MDM0MA__','d:14.5;'),(2368586,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','OTY2ODI1NjgyODU2MQ__','d:14.5;'),(2368587,2334707,'22d26e8dc9f92e5f0fee5a0cc3342513','2015-04-08 11:46:17','NTY1NDE2OTk2NjkzMg__','d:14.5;'),(20686258,0,'32017490857cc86e9f76035506659bbc','2015-04-30 08:56:04','userFrontendLangId','i:1;'),(20686259,0,'32017490857cc86e9f76035506659bbc','2015-04-30 08:55:49','__csrf_data__',''),(20686260,20686259,'32017490857cc86e9f76035506659bbc','2015-04-30 08:56:13','NzExNjM1MTI1MDA5Mw__','d:14;'),(20686262,0,'32017490857cc86e9f76035506659bbc','2015-04-30 08:56:04','auth',''),(20686263,20686262,'32017490857cc86e9f76035506659bbc','2015-04-30 08:56:04','log','b:1;'),(20686265,20686259,'32017490857cc86e9f76035506659bbc','2015-04-30 08:56:13','Mzk3NjMyODQ4NDI0OA__','d:13.5;'),(20686269,20686259,'32017490857cc86e9f76035506659bbc','2015-04-30 08:56:13','OTIxMTk5MzQwNjk5Mg__','d:13.5;'),(20686274,20686259,'32017490857cc86e9f76035506659bbc','2015-04-30 08:56:13','ODgzMTM3MTE4ODE2Mw__','d:14.5;'),(20686275,0,'ith946i7r74u0fk62mle4am0q4','2015-04-30 09:03:08','userFrontendLangId','i:1;'),(20686276,0,'ith946i7r74u0fk62mle4am0q4','2015-04-30 09:03:04','__csrf_data__',''),(20686277,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','OTkzOTE4OTMwMDg3Mg__','d:5;'),(20686279,0,'ith946i7r74u0fk62mle4am0q4','2015-04-30 09:03:08','auth',''),(20686280,20686279,'ith946i7r74u0fk62mle4am0q4','2015-04-30 09:03:08','log','b:1;'),(20686282,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','NDM5OTY4MzczMjUzOQ__','d:5;'),(20686289,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','NzgxOTQwNzEwMzU4Mw__','d:4.5;'),(20686294,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','NDI5MjE3OTY4MDQyOQ__','d:4.5;'),(20686300,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','MjIwOTc0NDkzNDQ1OA__','d:5;'),(20686307,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','OTA2NzM4MjcxNTY0Mg__','d:5.5;'),(20686314,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','ODY0MjU5MTg3Nzg0MA__','d:6.5;'),(20686322,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','Mzk0MjA2MDYyMzc4Mw__','d:6.5;'),(20686332,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','ODY4OTY1NTEyNDIwOQ__','d:6;'),(20686343,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','OTU3MjcyNDI2NzM3NA__','d:7;'),(20686356,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','OTIwODE3Mzk1ODExOQ__','d:6.5;'),(20686369,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','NTY0NTc5MTE4NjAxOQ__','d:5.5;'),(20686383,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','OTgyNjA1MzM5NzcyOQ__','d:8;'),(20686398,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','NjMxNTk4MzQ3ODkxMQ__','d:8;'),(20686414,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','OTM0NjczNzQ2MjU2MQ__','d:8;'),(20686431,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','OTE1MjgwMzM0ODg0Mw__','d:8.5;'),(20686449,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','MzI5MzY1OTk5NjcwNg__','d:9;'),(20686469,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','MjgxMTc0ODY0Mjk0MA__','d:9;'),(20686489,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','ODE1ODkyMTIyOTY1Mw__','d:9;'),(20686510,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','NDA2NzYxMjc1MzI0OQ__','d:10;'),(20686527,0,'ith946i7r74u0fk62mle4am0q4','2015-04-30 11:00:02','page',''),(20686528,20686527,'ith946i7r74u0fk62mle4am0q4','2015-04-30 11:00:02','type','s:7:\"content\";'),(20686529,20686527,'ith946i7r74u0fk62mle4am0q4','2015-04-30 11:00:02','title','s:6:\"Praxis\";'),(20686530,20686527,'ith946i7r74u0fk62mle4am0q4','2015-04-30 11:00:02','contentTitle','s:6:\"Praxis\";'),(20686531,20686527,'ith946i7r74u0fk62mle4am0q4','2015-04-30 11:00:02','start','N;'),(20686532,20686527,'ith946i7r74u0fk62mle4am0q4','2015-04-30 11:00:02','end','N;'),(20686533,20686527,'ith946i7r74u0fk62mle4am0q4','2015-04-30 11:00:02','metatitle','s:6:\"Praxis\";'),(20686534,20686527,'ith946i7r74u0fk62mle4am0q4','2015-04-30 11:00:02','metakeys','s:6:\"Praxis\";'),(20686535,20686527,'ith946i7r74u0fk62mle4am0q4','2015-04-30 11:00:02','metadesc','s:6:\"Praxis\";'),(20686536,20686527,'ith946i7r74u0fk62mle4am0q4','2015-04-30 11:00:02','metarobots','b:1;'),(20686537,20686527,'ith946i7r74u0fk62mle4am0q4','2015-04-30 11:00:02','content','s:2473:\"<section class=\"content-section\">\r\n<p>Unsere Praxisr&auml;umlichkeiten im Haus Elim im Salemspital, erreichen Sie &uuml;ber den Haupteingang, in Verl&auml;ngerung des Geschosses A1.&nbsp;Sie finden uns nach der Warte- und Empfangszone der orthop&auml;dischen Gemeinschaftspraxis ganz hinten, am Ende des Korridors.</p>\r\n\r\n<ul>\r\n	<li><a class=\"link-icon icon-link\" href=\"{NODE_22}\">Lageplan/Anreise</a></li>\r\n</ul>\r\n</section>\r\n\r\n<section class=\"lightbox-previews\">\r\n<figure class=\"lightbox-links\"><a data-lightbox=\"gallery-1\" data-title=\"Bild 1\" href=\"//fakeimg.pl/1000x720?text=Bild1\"><img alt=\"\" src=\"//fakeimg.pl/300?text=Bild Praxis\" /> </a>\r\n\r\n<figcaption>Bildbeschrieb</figcaption>\r\n</figure>\r\n\r\n<figure class=\"lightbox-links\"><a data-lightbox=\"gallery-1\" href=\"//fakeimg.pl/1000x500?text=Bild2\"><img alt=\"\" src=\"//fakeimg.pl/300?text=Bild Praxis\" /> </a>\r\n\r\n<figcaption>Bildbeschrieb</figcaption>\r\n</figure>\r\n\r\n<figure class=\"lightbox-links\"><a data-lightbox=\"gallery-1\" data-title=\"Bild 3\" href=\"//fakeimg.pl/1000?text=Bild3\"><img alt=\"\" src=\"//fakeimg.pl/300?text=Bild Praxis\" /> </a>\r\n\r\n<figcaption>Bildbeschrieb</figcaption>\r\n</figure>\r\n\r\n<figure class=\"lightbox-links\"><a data-lightbox=\"gallery-1\" data-title=\"Bild 4\" href=\"//fakeimg.pl/1000x1500?text=Bild4\"><img alt=\"\" src=\"//fakeimg.pl/300?text=Bild Praxis\" /> </a>\r\n\r\n<figcaption>Bildbeschrieb</figcaption>\r\n</figure>\r\n</section>\r\n\r\n<section class=\"content-section\">\r\n<h2>Assistenz&auml;rzte bei CHRISTENORTHO AG</h2>\r\n\r\n<p>Seit dem 1. Januar 2008 werden bei CHRISTENORTHO AG Assistenz&auml;rzte ausgebildet, deren Ziel die Erlangung des Facharztes f&uuml;r Orthop&auml;die und Traumatologie des Bewegungsapparates ist.</p>\r\n\r\n<p>Vom 1. Januar 2010 bis 31. M&auml;rz 2013 fand bez&uuml;glich Weiterbildung eine enge Zusammenarbeit mit dem Bruderholzspital in Basel (Klinikleiter Prof. Dr. med. N. Friederich) statt. Am 1. Juli 2013 ist eine neue Kooperation mit der Orthop&auml;dischen Universit&auml;tsklinik des Inselspitals Bern angelaufen.</p>\r\n\r\n<p>Geeignete und interessierte Kandidaten absolvieren bis zu einem Jahr ihrer Weiterbildung bei CHRISTENORTHO AG und kehren dann ans Inselspital Bern zur&uuml;ck, um die Ausbildung zum Facharzt fort zu setzen. Die Assistenz&auml;rzte bei CHRISTENORTHO AG sind voll in den Praxisalltag integriert. Patienten werden ihnen in der Sprechstunde, auf der Abteilung oder auch im Operationssaal begegnen, gewisse Arbeiten werden an sie delegiert.</p>\r\n</section>\r\n\";'),(20686538,20686527,'ith946i7r74u0fk62mle4am0q4','2015-04-30 11:00:02','sourceMode','b:0;'),(20686539,20686527,'ith946i7r74u0fk62mle4am0q4','2015-04-30 11:00:02','frontendProtection','b:0;'),(20686540,20686527,'ith946i7r74u0fk62mle4am0q4','2015-04-30 11:00:02','backendProtection','b:0;'),(20686541,20686527,'ith946i7r74u0fk62mle4am0q4','2015-04-30 11:00:02','module','s:6:\"access\";'),(20686542,20686527,'ith946i7r74u0fk62mle4am0q4','2015-04-30 11:00:02','cmd','s:0:\"\";'),(20686543,20686527,'ith946i7r74u0fk62mle4am0q4','2015-04-30 11:00:02','target','s:0:\"\";'),(20686544,20686527,'ith946i7r74u0fk62mle4am0q4','2015-04-30 11:00:02','linkTarget','s:0:\"\";'),(20686545,20686527,'ith946i7r74u0fk62mle4am0q4','2015-04-30 11:00:02','slug','s:6:\"Praxis\";'),(20686546,20686527,'ith946i7r74u0fk62mle4am0q4','2015-04-30 11:00:02','caching','b:0;'),(20686547,20686527,'ith946i7r74u0fk62mle4am0q4','2015-04-30 11:00:02','skin','i:0;'),(20686548,20686527,'ith946i7r74u0fk62mle4am0q4','2015-04-30 11:00:02','useSkinForAllChannels','i:0;'),(20686549,20686527,'ith946i7r74u0fk62mle4am0q4','2015-04-30 11:00:02','customContent','s:19:\"content_praxis.html\";'),(20686550,20686527,'ith946i7r74u0fk62mle4am0q4','2015-04-30 11:00:02','useCustomContentForAllChannels','i:1;'),(20686551,20686527,'ith946i7r74u0fk62mle4am0q4','2015-04-30 11:00:02','cssName','s:0:\"\";'),(20686552,20686527,'ith946i7r74u0fk62mle4am0q4','2015-04-30 11:00:02','cssNavName','s:0:\"\";'),(20686600,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','NDIyMTA0NzQ0Mjg3Mg__','d:10;'),(20686647,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','ODI1OTczMTcyMDIwMQ__','d:10;'),(20686670,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','NDY0MTU3MzM2Mjk4Mw__','d:10;'),(20686694,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','NjA0NTMxMjU4MDY1Mg__','d:10;'),(20686719,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','MzY0MjE4MTM0OTQ1Mg__','d:10;'),(20686745,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','NTIxOTIyMzAzNjg5Ng__','d:10;'),(20686772,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','NTE4ODA3NTIzNTExMw__','d:10;'),(20686800,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','NDAyNTIyOTY5MzM5MA__','d:10;'),(20686829,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','MzMyNDg0OTU3Mzg5NQ__','d:10;'),(20686859,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','NzMyODk3NDc1NzM0Mw__','d:10;'),(20686890,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','MjEyODIxMjg5NjY0MQ__','d:10;'),(20686922,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','NzAwNDA4OTgwNTc2Mw__','d:10;'),(20686955,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','Nzc2NDQ5OTY5MDg0OQ__','d:10;'),(20686989,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','NjI5OTA2MjUxMTg4Mw__','d:10;'),(20687050,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','MjQ2OTc3NzQxMjI0Ng__','d:9.5;'),(20687112,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','NjgzMjc5NTA4Njc4Mg__','d:6.5;'),(20687175,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','NDg3ODMxODQ5OTc3Mw__','d:11;'),(20687265,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','NjQ2MTI3NDQzMjk0OQ__','d:11;'),(20687330,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','MzIyNDg5NjQ4MDc5NA__','d:11.5;'),(20687422,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','ODUwMDIxODYwNTYyMg__','d:11.5;'),(20687489,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','Mjc1NjY3NzEzNzY4Nw__','d:12;'),(20687583,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','NDMwMzkxMzI0MjY0OQ__','d:12;'),(20687678,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','MzY3MDYyNjU2MTYyMw__','d:12.5;'),(20687748,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','NTg0NDA4NTg4NDI4MA__','d:12.5;'),(20687819,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','MTYxODUzMDQ1MzY0OA__','d:13;'),(20687917,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','ODUxODcxOTUzMjA2MQ__','d:13;'),(20688016,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','ODI5Mjg1NTg4Njc0Mg__','d:13.5;'),(20688090,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','ODMwNjE4MDQ4OTI0OQ__','d:13.5;'),(20688165,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','MTE5OTE4MzM1MTgyNQ__','d:14;'),(20688267,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','MTMxNDk3MzI3NTY0Mg__','d:14;'),(20688370,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','ODQ4MTc0Mjg0MTY1Nw__','d:14.5;'),(20688448,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:44','OTcxNDU3NDg5ODU5Mw__','d:14.5;'),(20688527,20686276,'ith946i7r74u0fk62mle4am0q4','2015-04-30 12:13:46','OTI2NTQyMzc1MjM2Nw__','i:15;');
/*!40000 ALTER TABLE `contrexx_session_variable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_sessions`
--

DROP TABLE IF EXISTS `contrexx_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_sessions` (
  `sessionid` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `remember_me` int(1) NOT NULL DEFAULT '0',
  `startdate` varchar(14) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `lastupdated` varchar(14) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`sessionid`),
  KEY `LastUpdated` (`lastupdated`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_sessions`
--

LOCK TABLES `contrexx_sessions` WRITE;
/*!40000 ALTER TABLE `contrexx_sessions` DISABLE KEYS */;
INSERT INTO `contrexx_sessions` VALUES ('32017490857cc86e9f76035506659bbc',1,'1430384148','1430384173','backend',1),('ith946i7r74u0fk62mle4am0q4',1,'1430384584','1430396157','backend',1);
/*!40000 ALTER TABLE `contrexx_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_settings`
--

DROP TABLE IF EXISTS `contrexx_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_settings` (
  `setid` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `setname` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `setvalue` text COLLATE utf8_unicode_ci NOT NULL,
  `setmodule` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`setid`)
) ENGINE=MyISAM AUTO_INCREMENT=126 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_settings`
--

LOCK TABLES `contrexx_settings` WRITE;
/*!40000 ALTER TABLE `contrexx_settings` DISABLE KEYS */;
INSERT INTO `contrexx_settings` VALUES (3,'dnsServer','ns1.contrexxhosting.com',1),(4,'bannerStatus','0',28),(5,'spamKeywords','sex, viagra',1),(11,'coreAdminName','rafhun',1),(18,'corePagingLimit','30',1),(19,'searchDescriptionLength','150',5),(23,'coreIdsStatus','off',1),(24,'coreAdminEmail','webmaster@werbelinie.ch',1),(29,'contactFormEmail','webmaster@werbelinie.ch',6),(34,'sessionLifeTime','3600',1),(35,'lastAccessId','382',1),(37,'newsTeasersStatus','1',8),(39,'feedNewsMLStatus','0',22),(40,'calendarheadlines','1',21),(41,'calendarheadlinescount','1',21),(42,'blockStatus','1',7),(44,'calendarheadlinescat','0',21),(45,'calendardefaultcount','16',21),(48,'blockRandom','1',7),(49,'directoryHomeContent','0',12),(50,'cacheEnabled','off',1),(51,'coreGlobalPageTitle','christenortho',1),(52,'cacheExpiration','86400',1),(53,'domainUrl','localhost:3000',1),(54,'xmlSitemapStatus','on',1),(55,'systemStatus','on',1),(56,'searchVisibleContentOnly','on',1),(60,'forumHomeContent','1',20),(96,'licenseGrayzoneMessages','YToxOntzOjI6ImRlIjtPOjMxOiJDeFxDb3JlX01vZHVsZXNcTGljZW5zZVxNZXNzYWdlIjo2OntzOjQxOiIAQ3hcQ29yZV9Nb2R1bGVzXExpY2Vuc2VcTWVzc2FnZQBsYW5nQ29kZSI7czoyOiJkZSI7czozNzoiAEN4XENvcmVfTW9kdWxlc1xMaWNlbnNlXE1lc3NhZ2UAdGV4dCI7czo3MjoiRXMgaXN0IGVpbiBGZWhsZXIgYXVmZ2V0cmV0ZW4uIEJpdHRlIHdlbmRlbiBTaWUgc2ljaCBhbiBJaHJlbiBXZWJtYXN0ZXIuIjtzOjM3OiIAQ3hcQ29yZV9Nb2R1bGVzXExpY2Vuc2VcTWVzc2FnZQB0eXBlIjtzOjg6ImFsZXJ0Ym94IjtzOjM3OiIAQ3hcQ29yZV9Nb2R1bGVzXExpY2Vuc2VcTWVzc2FnZQBsaW5rIjtzOjIxOiJpbmRleC5waHA/Y21kPWxpY2Vuc2UiO3M6NDM6IgBDeFxDb3JlX01vZHVsZXNcTGljZW5zZVxNZXNzYWdlAGxpbmtUYXJnZXQiO3M6NToiX3NlbGYiO3M6NDg6IgBDeFxDb3JlX01vZHVsZXNcTGljZW5zZVxNZXNzYWdlAHNob3dJbkRhc2hib2FyZCI7YjoxO319',66),(62,'coreSmtpServer','0',1),(63,'languageDetection','on',1),(64,'podcastHomeContent','1',35),(65,'googleMapsAPIKey','',1),(66,'forumTagContent','0',20),(84,'sessionLifeTimeRememberMe','1209600',1),(68,'dataUseModule','1',48),(69,'frontendEditingStatus','off',1),(71,'coreListProtectedPages','off',1),(72,'useKnowledgePlaceholders','1',56),(73,'advancedUploadFrontend','off',52),(74,'advancedUploadBackend','on',52),(75,'installationId','CONTREXX_4_0_4cc9e83119af6520568b2683267',1),(76,'licenseKey','CONTREXX_4_0_35bcf29a638c37735c5c8f61b8f',1),(77,'contactCompany','Ihr Firmenname',1),(78,'contactAddress','Musterstrasse 12',1),(79,'contactZip','3600',1),(80,'contactPlace','Musterhausen',1),(81,'contactCountry','Schweiz',1),(82,'contactPhone','033 123 45 67',1),(83,'contactFax','033 123 45 68',1),(85,'dashboardNews','on',1),(86,'dashboardStatistics','on',1),(87,'timezone','UTC',1),(88,'googleAnalyticsTrackingId','',1),(89,'passwordComplexity','off',1),(90,'licenseState','OK',66),(91,'licenseValidTo','1761641730',66),(92,'coreCmsEdition','',66),(93,'licenseMessage','YToxOntzOjI6ImRlIjtPOjMxOiJDeFxDb3JlX01vZHVsZXNcTGljZW5zZVxNZXNzYWdlIjo2OntzOjQxOiIAQ3hcQ29yZV9Nb2R1bGVzXExpY2Vuc2VcTWVzc2FnZQBsYW5nQ29kZSI7czoyOiJkZSI7czozNzoiAEN4XENvcmVfTW9kdWxlc1xMaWNlbnNlXE1lc3NhZ2UAdGV4dCI7czowOiIiO3M6Mzc6IgBDeFxDb3JlX01vZHVsZXNcTGljZW5zZVxNZXNzYWdlAHR5cGUiO3M6MTA6Indhcm5pbmdib3giO3M6Mzc6IgBDeFxDb3JlX01vZHVsZXNcTGljZW5zZVxNZXNzYWdlAGxpbmsiO3M6Mjg6Imh0dHA6Ly9saWNlbnNlLmNvbnRyZXh4LmNvbS8iO3M6NDM6IgBDeFxDb3JlX01vZHVsZXNcTGljZW5zZVxNZXNzYWdlAGxpbmtUYXJnZXQiO3M6NjoiX2JsYW5rIjtzOjQ4OiIAQ3hcQ29yZV9Nb2R1bGVzXExpY2Vuc2VcTWVzc2FnZQBzaG93SW5EYXNoYm9hcmQiO2I6MTt9fQ==',66),(97,'coreCmsVersion','4.0.0',66),(98,'coreCmsCodeName','Eric S. Raymond',66),(99,'coreCmsStatus','Stable',66),(100,'coreCmsReleaseDate','01.12.2014',66),(101,'licensePartner','TzozMDoiQ3hcQ29yZV9Nb2R1bGVzXExpY2Vuc2VcUGVyc29uIjoxMTp7czo0MzoiAEN4XENvcmVfTW9kdWxlc1xMaWNlbnNlXFBlcnNvbgBjb21wYW55TmFtZSI7czoxMjoiQ29tdmF0aW9uIEFHIjtzOjM3OiIAQ3hcQ29yZV9Nb2R1bGVzXExpY2Vuc2VcUGVyc29uAHRpdGxlIjtzOjM6Ik1yLiI7czo0MToiAEN4XENvcmVfTW9kdWxlc1xMaWNlbnNlXFBlcnNvbgBmaXJzdG5hbWUiO3M6NDoiSGFucyI7czo0MDoiAEN4XENvcmVfTW9kdWxlc1xMaWNlbnNlXFBlcnNvbgBsYXN0bmFtZSI7czo2OiJNdXN0ZXIiO3M6Mzk6IgBDeFxDb3JlX01vZHVsZXNcTGljZW5zZVxQZXJzb24AYWRkcmVzcyI7czoxNDoiQnVyZ3N0cmFzc2UgMjAiO3M6MzU6IgBDeFxDb3JlX01vZHVsZXNcTGljZW5zZVxQZXJzb24AemlwIjtzOjQ6IjM2MDAiO3M6MzY6IgBDeFxDb3JlX01vZHVsZXNcTGljZW5zZVxQZXJzb24AY2l0eSI7czo0OiJUaHVuIjtzOjM5OiIAQ3hcQ29yZV9Nb2R1bGVzXExpY2Vuc2VcUGVyc29uAGNvdW50cnkiO3M6MTE6IlN3aXR6ZXJsYW5kIjtzOjM3OiIAQ3hcQ29yZV9Nb2R1bGVzXExpY2Vuc2VcUGVyc29uAHBob25lIjtzOjE4OiIrNDEgKDApMzMgMjI2IDYwMDAiO3M6MzU6IgBDeFxDb3JlX01vZHVsZXNcTGljZW5zZVxQZXJzb24AdXJsIjtzOjI1OiJodHRwOi8vd3d3LmNvbXZhdGlvbi5jb20vIjtzOjM2OiIAQ3hcQ29yZV9Nb2R1bGVzXExpY2Vuc2VcUGVyc29uAG1haWwiO3M6MTg6ImluZm9AY29tdmF0aW9uLmNvbSI7fQ==',66),(102,'licenseCustomer','TzozMDoiQ3hcQ29yZV9Nb2R1bGVzXExpY2Vuc2VcUGVyc29uIjoxMTp7czo0MzoiAEN4XENvcmVfTW9kdWxlc1xMaWNlbnNlXFBlcnNvbgBjb21wYW55TmFtZSI7czoxMjoiQ29tdmF0aW9uIEFHIjtzOjM3OiIAQ3hcQ29yZV9Nb2R1bGVzXExpY2Vuc2VcUGVyc29uAHRpdGxlIjtzOjM6Ik1yLiI7czo0MToiAEN4XENvcmVfTW9kdWxlc1xMaWNlbnNlXFBlcnNvbgBmaXJzdG5hbWUiO3M6NDoiSGFucyI7czo0MDoiAEN4XENvcmVfTW9kdWxlc1xMaWNlbnNlXFBlcnNvbgBsYXN0bmFtZSI7czo2OiJNdXN0ZXIiO3M6Mzk6IgBDeFxDb3JlX01vZHVsZXNcTGljZW5zZVxQZXJzb24AYWRkcmVzcyI7czoxNDoiQnVyZ3N0cmFzc2UgMjAiO3M6MzU6IgBDeFxDb3JlX01vZHVsZXNcTGljZW5zZVxQZXJzb24AemlwIjtzOjQ6IjM2MDAiO3M6MzY6IgBDeFxDb3JlX01vZHVsZXNcTGljZW5zZVxQZXJzb24AY2l0eSI7czo0OiJUaHVuIjtzOjM5OiIAQ3hcQ29yZV9Nb2R1bGVzXExpY2Vuc2VcUGVyc29uAGNvdW50cnkiO3M6MTE6IlN3aXR6ZXJsYW5kIjtzOjM3OiIAQ3hcQ29yZV9Nb2R1bGVzXExpY2Vuc2VcUGVyc29uAHBob25lIjtzOjE4OiIrNDEgKDApMzMgMjI2IDYwMDAiO3M6MzU6IgBDeFxDb3JlX01vZHVsZXNcTGljZW5zZVxQZXJzb24AdXJsIjtzOjI1OiJodHRwOi8vd3d3LmNvbXZhdGlvbi5jb20vIjtzOjM2OiIAQ3hcQ29yZV9Nb2R1bGVzXExpY2Vuc2VcUGVyc29uAG1haWwiO3M6MTg6ImluZm9AY29tdmF0aW9uLmNvbSI7fQ==',66),(104,'upgradeUrl','http://license.contrexx.com/',66),(57,'forceProtocolFrontend','none',1),(58,'forceProtocolBackend','none',1),(112,'coreCmsName','Contrexx',66),(113,'useCustomizings','on',1),(114,'licenseGrayzoneTime','14',66),(115,'licenseLockTime','false',66),(116,'licenseUpdateInterval','24',66),(117,'licenseFailedUpdate','0',66),(118,'licenseSuccessfulUpdate','1426664682',66),(94,'licenseCreatedAt','1414486530',66),(95,'licenseDomains','YToxOntpOjA7czoxNjoiaW5mb0BleGFtcGxlLmNvbSI7fQ==',66),(103,'availableComponents','Tzo4OiJzdGRDbGFzcyI6MTp7czoxMjoiQ29tdmF0aW9uIEFHIjthOjY1OntpOjA7czo2OiJhY2Nlc3MiO2k6MTtzOjM6ImFnYiI7aToyO3M6NToiYWxpYXMiO2k6MztzOjU6ImJsb2NrIjtpOjQ7czo3OiJjYXB0Y2hhIjtpOjU7czo3OiJjb250YWN0IjtpOjY7czo0OiJjb3JlIjtpOjc7czo5OiJkb3dubG9hZHMiO2k6ODtzOjU6ImVycm9yIjtpOjk7czoxMToiZmlsZUJyb3dzZXIiO2k6MTA7czoxMToiZmlsZXNoYXJpbmciO2k6MTE7czo0OiJob21lIjtpOjEyO3M6MzoiaWRzIjtpOjEzO3M6NDoiaW1tbyI7aToxNDtzOjc6ImltcHJpbnQiO2k6MTU7czo4OiJqc29uZGF0YSI7aToxNjtzOjg6Imxhbmd1YWdlIjtpOjE3O3M6NzoibGljZW5zZSI7aToxODtzOjU6ImxvZ2luIjtpOjE5O3M6NjoibG9nb3V0IjtpOjIwO3M6NjoibWVkaWExIjtpOjIxO3M6NjoibWVkaWEyIjtpOjIyO3M6NjoibWVkaWEzIjtpOjIzO3M6NjoibWVkaWE0IjtpOjI0O3M6ODoibmV0dG9vbHMiO2k6MjU7czo0OiJuZXdzIjtpOjI2O3M6NzoicHJpdmFjeSI7aToyNztzOjY6InNlYXJjaCI7aToyODtzOjc6InNpdGVtYXAiO2k6Mjk7czo1OiJzdGF0cyI7aTozMDtzOjY6InVwbG9hZCI7aTozMTtzOjQ6ImJsb2ciO2k6MzI7czo1OiJlY2FyZCI7aTozMztzOjc6ImdhbGxlcnkiO2k6MzQ7czo5OiJndWVzdGJvb2siO2k6MzU7czo5OiJyZWNvbW1lbmQiO2k6MzY7czozOiJ1MnUiO2k6Mzc7czoxMjoiZnVsbGxhbmd1YWdlIjtpOjM4O3M6NDoic2hvcCI7aTozOTtzOjg6ImNoZWNrb3V0IjtpOjQwO3M6MTA6Im5ld3NsZXR0ZXIiO2k6NDE7czo3OiJhdWN0aW9uIjtpOjQyO3M6NDoiYmxvZyI7aTo0MztzOjg6ImNhbGVuZGFyIjtpOjQ0O3M6NDoiZGF0YSI7aTo0NTtzOjk6ImRpcmVjdG9yeSI7aTo0NjtzOjY6ImRvY3N5cyI7aTo0NztzOjU6ImVjYXJkIjtpOjQ4O3M6NDoiZWdvdiI7aTo0OTtzOjQ6ImZlZWQiO2k6NTA7czo1OiJmb3J1bSI7aTo1MTtzOjc6ImdhbGxlcnkiO2k6NTI7czo5OiJndWVzdGJvb2siO2k6NTM7czo1OiJob3RlbCI7aTo1NDtzOjQ6ImpvYnMiO2k6NTU7czo5OiJrbm93bGVkZ2UiO2k6NTY7czo3OiJsaXZlY2FtIjtpOjU3O3M6NjoibWFya2V0IjtpOjU4O3M6ODoibWVkaWFkaXIiO2k6NTk7czo5OiJtZW1iZXJkaXIiO2k6NjA7czo4OiJwYXJ0bmVycyI7aTo2MTtzOjc6InBvZGNhc3QiO2k6NjI7czo5OiJyZWNvbW1lbmQiO2k6NjM7czozOiJ1MnUiO2k6NjQ7czo2OiJ2b3RpbmciO319',66),(105,'isUpgradable','off',66),(106,'dashboardMessages','YToxOntzOjI6ImRlIjtPOjMxOiJDeFxDb3JlX01vZHVsZXNcTGljZW5zZVxNZXNzYWdlIjo2OntzOjQxOiIAQ3hcQ29yZV9Nb2R1bGVzXExpY2Vuc2VcTWVzc2FnZQBsYW5nQ29kZSI7czoyOiJkZSI7czozNzoiAEN4XENvcmVfTW9kdWxlc1xMaWNlbnNlXE1lc3NhZ2UAdGV4dCI7czowOiIiO3M6Mzc6IgBDeFxDb3JlX01vZHVsZXNcTGljZW5zZVxNZXNzYWdlAHR5cGUiO3M6MTA6Indhcm5pbmdib3giO3M6Mzc6IgBDeFxDb3JlX01vZHVsZXNcTGljZW5zZVxNZXNzYWdlAGxpbmsiO3M6MjE6ImluZGV4LnBocD9jbWQ9bGljZW5zZSI7czo0MzoiAEN4XENvcmVfTW9kdWxlc1xMaWNlbnNlXE1lc3NhZ2UAbGlua1RhcmdldCI7czo1OiJfc2VsZiI7czo0ODoiAEN4XENvcmVfTW9kdWxlc1xMaWNlbnNlXE1lc3NhZ2UAc2hvd0luRGFzaGJvYXJkIjtiOjE7fX0=',66),(59,'forceDomainUrl','off',1),(119,'cacheUserCache','filesystem',1),(120,'cacheOPCache','',1),(121,'cacheUserCacheMemcacheConfig','{\"ip\":\"127.0.0.1\",\"port\":11211}',1),(122,'cacheProxyCacheVarnishConfig','{\"ip\":\"127.0.0.1\",\"port\":8080}',1),(123,'cacheOpStatus','off',1),(124,'cacheDbStatus','off',1),(125,'cacheVarnishStatus','off',1);
/*!40000 ALTER TABLE `contrexx_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_settings_image`
--

DROP TABLE IF EXISTS `contrexx_settings_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_settings_image` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_settings_image`
--

LOCK TABLES `contrexx_settings_image` WRITE;
/*!40000 ALTER TABLE `contrexx_settings_image` DISABLE KEYS */;
INSERT INTO `contrexx_settings_image` VALUES (1,'image_cut_width','500'),(2,'image_cut_height','500'),(3,'image_scale_width','800'),(4,'image_scale_height','800'),(5,'image_compression','100');
/*!40000 ALTER TABLE `contrexx_settings_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_settings_smtp`
--

DROP TABLE IF EXISTS `contrexx_settings_smtp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_settings_smtp` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `hostname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `port` smallint(5) unsigned NOT NULL DEFAULT '25',
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_settings_smtp`
--

LOCK TABLES `contrexx_settings_smtp` WRITE;
/*!40000 ALTER TABLE `contrexx_settings_smtp` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_settings_smtp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_skins`
--

DROP TABLE IF EXISTS `contrexx_skins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_skins` (
  `id` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `themesname` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `foldername` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `expert` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `theme_unique` (`themesname`),
  UNIQUE KEY `folder_unique` (`foldername`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_skins`
--

LOCK TABLES `contrexx_skins` WRITE;
/*!40000 ALTER TABLE `contrexx_skins` DISABLE KEYS */;
INSERT INTO `contrexx_skins` VALUES (1,'skeleton','skeleton_3_0',1),(2,'rafhun','rafhun',1);
/*!40000 ALTER TABLE `contrexx_skins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_stats_browser`
--

DROP TABLE IF EXISTS `contrexx_stats_browser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_stats_browser` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `count` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_stats_browser`
--

LOCK TABLES `contrexx_stats_browser` WRITE;
/*!40000 ALTER TABLE `contrexx_stats_browser` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_stats_browser` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_stats_colourdepth`
--

DROP TABLE IF EXISTS `contrexx_stats_colourdepth`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_stats_colourdepth` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `depth` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `count` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`depth`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_stats_colourdepth`
--

LOCK TABLES `contrexx_stats_colourdepth` WRITE;
/*!40000 ALTER TABLE `contrexx_stats_colourdepth` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_stats_colourdepth` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_stats_config`
--

DROP TABLE IF EXISTS `contrexx_stats_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_stats_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `status` int(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_stats_config`
--

LOCK TABLES `contrexx_stats_config` WRITE;
/*!40000 ALTER TABLE `contrexx_stats_config` DISABLE KEYS */;
INSERT INTO `contrexx_stats_config` VALUES (1,'reload_block_time','1800',1),(2,'online_timeout','3000',1),(3,'paging_limit','100',1),(4,'count_browser','',1),(5,'count_operating_system','',1),(6,'make_statistics','',1),(7,'count_spiders','',0),(9,'count_requests','',0),(10,'remove_requests','86400',0),(11,'count_search_terms','',1),(12,'count_screen_resolution','',1),(13,'count_colour_depth','',1),(14,'count_javascript','',1),(15,'count_referer','',1),(16,'count_hostname','',1),(17,'count_country','',1),(18,'paging_limit_visitor_details','100',1),(19,'count_visitor_number','',1),(20,'exclude_identifying_info','0',1);
/*!40000 ALTER TABLE `contrexx_stats_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_stats_country`
--

DROP TABLE IF EXISTS `contrexx_stats_country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_stats_country` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `country` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `count` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`country`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_stats_country`
--

LOCK TABLES `contrexx_stats_country` WRITE;
/*!40000 ALTER TABLE `contrexx_stats_country` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_stats_country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_stats_hostname`
--

DROP TABLE IF EXISTS `contrexx_stats_hostname`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_stats_hostname` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hostname` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `count` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`hostname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_stats_hostname`
--

LOCK TABLES `contrexx_stats_hostname` WRITE;
/*!40000 ALTER TABLE `contrexx_stats_hostname` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_stats_hostname` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_stats_javascript`
--

DROP TABLE IF EXISTS `contrexx_stats_javascript`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_stats_javascript` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `support` enum('0','1') COLLATE utf8_unicode_ci DEFAULT '0',
  `count` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_stats_javascript`
--

LOCK TABLES `contrexx_stats_javascript` WRITE;
/*!40000 ALTER TABLE `contrexx_stats_javascript` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_stats_javascript` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_stats_operatingsystem`
--

DROP TABLE IF EXISTS `contrexx_stats_operatingsystem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_stats_operatingsystem` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `count` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_stats_operatingsystem`
--

LOCK TABLES `contrexx_stats_operatingsystem` WRITE;
/*!40000 ALTER TABLE `contrexx_stats_operatingsystem` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_stats_operatingsystem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_stats_referer`
--

DROP TABLE IF EXISTS `contrexx_stats_referer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_stats_referer` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `uri` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `timestamp` int(11) unsigned NOT NULL DEFAULT '0',
  `count` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `sid` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`uri`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_stats_referer`
--

LOCK TABLES `contrexx_stats_referer` WRITE;
/*!40000 ALTER TABLE `contrexx_stats_referer` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_stats_referer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_stats_requests`
--

DROP TABLE IF EXISTS `contrexx_stats_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_stats_requests` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `timestamp` int(11) DEFAULT '0',
  `pageId` int(6) unsigned NOT NULL DEFAULT '0',
  `page` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `visits` int(9) unsigned NOT NULL DEFAULT '0',
  `sid` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `pageTitle` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_stats_requests`
--

LOCK TABLES `contrexx_stats_requests` WRITE;
/*!40000 ALTER TABLE `contrexx_stats_requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_stats_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_stats_requests_summary`
--

DROP TABLE IF EXISTS `contrexx_stats_requests_summary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_stats_requests_summary` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `timestamp` int(11) NOT NULL DEFAULT '0',
  `count` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`type`,`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_stats_requests_summary`
--

LOCK TABLES `contrexx_stats_requests_summary` WRITE;
/*!40000 ALTER TABLE `contrexx_stats_requests_summary` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_stats_requests_summary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_stats_screenresolution`
--

DROP TABLE IF EXISTS `contrexx_stats_screenresolution`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_stats_screenresolution` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `resolution` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `count` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`resolution`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_stats_screenresolution`
--

LOCK TABLES `contrexx_stats_screenresolution` WRITE;
/*!40000 ALTER TABLE `contrexx_stats_screenresolution` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_stats_screenresolution` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_stats_search`
--

DROP TABLE IF EXISTS `contrexx_stats_search`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_stats_search` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `count` int(10) unsigned NOT NULL DEFAULT '0',
  `sid` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `external` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`name`,`external`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_stats_search`
--

LOCK TABLES `contrexx_stats_search` WRITE;
/*!40000 ALTER TABLE `contrexx_stats_search` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_stats_search` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_stats_spiders`
--

DROP TABLE IF EXISTS `contrexx_stats_spiders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_stats_spiders` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `last_indexed` int(14) DEFAULT NULL,
  `page` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `pageId` mediumint(6) unsigned NOT NULL DEFAULT '0',
  `count` int(11) NOT NULL DEFAULT '0',
  `spider_useragent` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `spider_ip` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `spider_host` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_stats_spiders`
--

LOCK TABLES `contrexx_stats_spiders` WRITE;
/*!40000 ALTER TABLE `contrexx_stats_spiders` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_stats_spiders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_stats_spiders_summary`
--

DROP TABLE IF EXISTS `contrexx_stats_spiders_summary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_stats_spiders_summary` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `timestamp` int(11) NOT NULL DEFAULT '0',
  `count` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_stats_spiders_summary`
--

LOCK TABLES `contrexx_stats_spiders_summary` WRITE;
/*!40000 ALTER TABLE `contrexx_stats_spiders_summary` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_stats_spiders_summary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_stats_visitors`
--

DROP TABLE IF EXISTS `contrexx_stats_visitors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_stats_visitors` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `sid` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `timestamp` int(11) NOT NULL DEFAULT '0',
  `client_ip` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `client_host` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `client_useragent` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `proxy_ip` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `proxy_host` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `proxy_useragent` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_stats_visitors`
--

LOCK TABLES `contrexx_stats_visitors` WRITE;
/*!40000 ALTER TABLE `contrexx_stats_visitors` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_stats_visitors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_stats_visitors_summary`
--

DROP TABLE IF EXISTS `contrexx_stats_visitors_summary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_stats_visitors_summary` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `timestamp` int(11) NOT NULL DEFAULT '0',
  `count` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`type`,`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_stats_visitors_summary`
--

LOCK TABLES `contrexx_stats_visitors_summary` WRITE;
/*!40000 ALTER TABLE `contrexx_stats_visitors_summary` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_stats_visitors_summary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_voting_additionaldata`
--

DROP TABLE IF EXISTS `contrexx_voting_additionaldata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_voting_additionaldata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(80) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `surname` varchar(80) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `phone` varchar(80) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `street` varchar(80) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `zip` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `city` varchar(80) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(80) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `voting_system_id` int(11) NOT NULL DEFAULT '0',
  `date_entered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `forename` varchar(80) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `voting_system_id` (`voting_system_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_voting_additionaldata`
--

LOCK TABLES `contrexx_voting_additionaldata` WRITE;
/*!40000 ALTER TABLE `contrexx_voting_additionaldata` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_voting_additionaldata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_voting_email`
--

DROP TABLE IF EXISTS `contrexx_voting_email`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_voting_email` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `valid` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_voting_email`
--

LOCK TABLES `contrexx_voting_email` WRITE;
/*!40000 ALTER TABLE `contrexx_voting_email` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_voting_email` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_voting_rel_email_system`
--

DROP TABLE IF EXISTS `contrexx_voting_rel_email_system`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_voting_rel_email_system` (
  `email_id` int(10) unsigned NOT NULL DEFAULT '0',
  `system_id` int(10) unsigned NOT NULL DEFAULT '0',
  `voting_id` int(10) unsigned NOT NULL DEFAULT '0',
  `valid` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  UNIQUE KEY `email_id` (`email_id`,`system_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_voting_rel_email_system`
--

LOCK TABLES `contrexx_voting_rel_email_system` WRITE;
/*!40000 ALTER TABLE `contrexx_voting_rel_email_system` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_voting_rel_email_system` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_voting_results`
--

DROP TABLE IF EXISTS `contrexx_voting_results`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_voting_results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voting_system_id` int(11) DEFAULT NULL,
  `question` char(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `votes` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_voting_results`
--

LOCK TABLES `contrexx_voting_results` WRITE;
/*!40000 ALTER TABLE `contrexx_voting_results` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_voting_results` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrexx_voting_system`
--

DROP TABLE IF EXISTS `contrexx_voting_system`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contrexx_voting_system` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `title` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `question` text COLLATE utf8_unicode_ci,
  `status` tinyint(1) DEFAULT '1',
  `submit_check` enum('cookie','email') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'cookie',
  `votes` int(11) DEFAULT '0',
  `additional_nickname` tinyint(1) NOT NULL DEFAULT '0',
  `additional_forename` tinyint(1) NOT NULL DEFAULT '0',
  `additional_surname` tinyint(1) NOT NULL DEFAULT '0',
  `additional_phone` tinyint(1) NOT NULL DEFAULT '0',
  `additional_street` tinyint(1) NOT NULL DEFAULT '0',
  `additional_zip` tinyint(1) NOT NULL DEFAULT '0',
  `additional_email` tinyint(1) NOT NULL DEFAULT '0',
  `additional_city` tinyint(1) NOT NULL DEFAULT '0',
  `additional_comment` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrexx_voting_system`
--

LOCK TABLES `contrexx_voting_system` WRITE;
/*!40000 ALTER TABLE `contrexx_voting_system` DISABLE KEYS */;
/*!40000 ALTER TABLE `contrexx_voting_system` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-05-22  9:00:45