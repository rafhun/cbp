-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 19. Mai 2010 um 08:45
-- Server Version: 5.1.41
-- PHP-Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `branches_2.1.3_mediadir`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `contrexx_module_mediadir_categories`
--

CREATE TABLE IF NOT EXISTS `contrexx_module_mediadir_categories` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `parent_id` int(7) NOT NULL,
  `order` int(7) NOT NULL,
  `show_subcategories` int(11) NOT NULL,
  `show_entries` int(1) NOT NULL,
  `picture` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `active` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=39 ;

--
-- Daten für Tabelle `contrexx_module_mediadir_categories`
--

INSERT INTO `contrexx_module_mediadir_categories` (`id`, `parent_id`, `order`, `show_subcategories`, `show_entries`, `picture`, `active`) VALUES
(33, 0, 2, 1, 1, '', 1),
(35, 0, 0, 1, 0, '', 1),
(32, 0, 0, 1, 1, '', 1),
(34, 0, 0, 1, 1, '', 1),
(36, 0, 99, 1, 1, '', 1),
(37, 36, 0, 1, 1, '', 1),
(38, 0, 0, 0, 0, '', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `contrexx_module_mediadir_categories_names`
--

CREATE TABLE IF NOT EXISTS `contrexx_module_mediadir_categories_names` (
  `lang_id` int(1) NOT NULL,
  `category_id` int(7) NOT NULL,
  `category_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  KEY `lang_id` (`lang_id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `contrexx_module_mediadir_categories_names`
--

INSERT INTO `contrexx_module_mediadir_categories_names` (`lang_id`, `category_id`, `category_name`, `category_description`) VALUES
(1, 36, 'Nordwestschweiz', ''),
(2, 35, 'Zentralschweiz', ''),
(2, 34, 'Zürich', ''),
(1, 33, 'Ostschweiz', ''),
(1, 32, 'Graubünden', ''),
(1, 37, 'Chur', ''),
(2, 36, 'Nordwestschweiz', ''),
(1, 35, 'Zentralschweiz', ''),
(1, 34, 'Zürich', ''),
(2, 33, 'Ostschweiz', ''),
(2, 32, 'Graubünden', ''),
(1, 38, 'werwer', 'werwerwer'),
(2, 38, 'werwer', 'werwerwer');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `contrexx_module_mediadir_comments`
--

CREATE TABLE IF NOT EXISTS `contrexx_module_mediadir_comments` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Daten für Tabelle `contrexx_module_mediadir_comments`
--

INSERT INTO `contrexx_module_mediadir_comments` (`id`, `entry_id`, `added_by`, `date`, `ip`, `name`, `mail`, `url`, `notification`, `comment`) VALUES
(1, 5, '1', '1268810368', '::1', 'system', 'janik@comvation.com', 'sdf', 0, 'sdfsdfsdf'),
(9, 39, '1', '1271339716', '::1', 'system', 'janik@comvation.com', 'asd', 0, 'asdasdasd asd asd asd '),
(7, 32, '1', '1269949892', '::1', 'system', 'janik@comvation.com', 'aja', 0, 'da arbeite ich'),
(8, 39, '1', '1271339682', '::1', 'system', 'janik@comvation.com', 'er wer ', 0, 'wer wer ');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `contrexx_module_mediadir_entries`
--

CREATE TABLE IF NOT EXISTS `contrexx_module_mediadir_entries` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
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
  `confirmed` int(1) NOT NULL,
  `active` int(1) NOT NULL,
  `duration_type` int(1) NOT NULL,
  `duration_start` int(50) NOT NULL,
  `duration_end` int(50) NOT NULL,
  `duration_notification` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lang_id` (`lang_id`),
  KEY `active` (`active`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=74 ;

--
-- Daten für Tabelle `contrexx_module_mediadir_entries`
--

INSERT INTO `contrexx_module_mediadir_entries` (`id`, `form_id`, `create_date`, `update_date`, `validate_date`, `added_by`, `updated_by`, `lang_id`, `hits`, `popular_hits`, `popular_date`, `last_ip`, `confirmed`, `active`, `duration_type`, `duration_start`, `duration_end`, `duration_notification`) VALUES
(72, 1, 1272361826, 0, 1272361826, 1, 0, 1, 0, 0, '', '::1', 1, 1, 1, 1272319200, 1280181600, 0),
(73, 1, 1272361845, 0, 1272361845, 1, 0, 1, 0, 0, '', '::1', 1, 1, 1, 1272319200, 1272319200, 0),
(32, 1, 1269949750, 1272361934, 1272361934, 2, 1, 1, 0, 0, '', '::1', 1, 1, 1, 1272319200, 1272319200, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `contrexx_module_mediadir_forms`
--

CREATE TABLE IF NOT EXISTS `contrexx_module_mediadir_forms` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `order` int(7) NOT NULL,
  `picture` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `active` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Daten für Tabelle `contrexx_module_mediadir_forms`
--

INSERT INTO `contrexx_module_mediadir_forms` (`id`, `order`, `picture`, `active`) VALUES
(1, 99, '/branches/2.1.3_mediadir/images/mediadir/images/06.jpg', 1),
(4, 99, '', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `contrexx_module_mediadir_form_names`
--

CREATE TABLE IF NOT EXISTS `contrexx_module_mediadir_form_names` (
  `lang_id` int(1) NOT NULL,
  `form_id` int(7) NOT NULL,
  `form_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `form_description` mediumtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `contrexx_module_mediadir_form_names`
--

INSERT INTO `contrexx_module_mediadir_form_names` (`lang_id`, `form_id`, `form_name`, `form_description`) VALUES
(1, 2, 'Test', 'tertert'),
(1, 1, 'Einträge', 'Einträge'),
(2, 2, 'Testerter', 'tertert'),
(2, 1, ' erertert', 'ertertertert'),
(2, 3, '2', ''),
(1, 3, '2', ''),
(2, 4, 'Einträge 2', ''),
(1, 4, 'Einträge 2', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `contrexx_module_mediadir_inputfields`
--

CREATE TABLE IF NOT EXISTS `contrexx_module_mediadir_inputfields` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `form` int(7) NOT NULL,
  `type` int(10) NOT NULL,
  `verification` int(10) NOT NULL,
  `search` int(10) NOT NULL,
  `required` int(10) NOT NULL,
  `order` int(10) NOT NULL,
  `show_in` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=21 ;

--
-- Daten für Tabelle `contrexx_module_mediadir_inputfields`
--

INSERT INTO `contrexx_module_mediadir_inputfields` (`id`, `form`, `type`, `verification`, `search`, `required`, `order`, `show_in`) VALUES
(18, 4, 1, 1, 1, 0, 3, 1),
(17, 4, 1, 1, 1, 0, 2, 1),
(6, 1, 2, 1, 1, 0, 2, 1),
(3, 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `contrexx_module_mediadir_inputfield_names`
--

CREATE TABLE IF NOT EXISTS `contrexx_module_mediadir_inputfield_names` (
  `lang_id` int(10) NOT NULL,
  `form_id` int(7) NOT NULL,
  `field_id` int(10) NOT NULL,
  `field_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `field_default_value` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  KEY `field_id` (`field_id`),
  KEY `lang_id` (`lang_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `contrexx_module_mediadir_inputfield_names`
--

INSERT INTO `contrexx_module_mediadir_inputfield_names` (`lang_id`, `form_id`, `field_id`, `field_name`, `field_default_value`) VALUES
(2, 4, 18, '', ''),
(1, 4, 18, '', ''),
(2, 4, 17, 'Test', ''),
(1, 4, 17, 'Test', ''),
(2, 1, 6, 'Beschreibung', ''),
(1, 1, 6, 'Beschreibung', ''),
(2, 1, 3, 'Title', ''),
(1, 1, 3, 'Titel', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `contrexx_module_mediadir_inputfield_types`
--

CREATE TABLE IF NOT EXISTS `contrexx_module_mediadir_inputfield_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` int(1) NOT NULL,
  `multi_lang` int(1) NOT NULL,
  `exp_search` int(7) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=22 ;

--
-- Daten für Tabelle `contrexx_module_mediadir_inputfield_types`
--

INSERT INTO `contrexx_module_mediadir_inputfield_types` (`id`, `name`, `active`, `multi_lang`, `exp_search`) VALUES
(1, 'text', 1, 1, 1),
(2, 'textarea', 1, 1, 1),
(3, 'dropdown', 1, 0, 1),
(4, 'radio', 1, 0, 1),
(5, 'checkbox', 1, 0, 0),
(18, 'label', 0, 0, 0),
(7, 'file', 1, 0, 0),
(8, 'image', 1, 0, 0),
(9, 'gallery', 0, 0, 0),
(10, 'podcast', 0, 0, 0),
(11, 'classification', 1, 0, 1),
(12, 'link', 1, 0, 0),
(13, 'link_group', 1, 0, 0),
(14, 'rss', 0, 0, 0),
(15, 'google_map', 1, 0, 0),
(16, 'add_step', 1, 0, 0),
(17, 'field_group', 0, 0, 0),
(19, 'wysiwyg', 0, 1, 0),
(20, 'mail', 1, 0, 0),
(21, 'google_weather', 1, 0, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `contrexx_module_mediadir_inputfield_verifications`
--

CREATE TABLE IF NOT EXISTS `contrexx_module_mediadir_inputfield_verifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `regex` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Daten für Tabelle `contrexx_module_mediadir_inputfield_verifications`
--

INSERT INTO `contrexx_module_mediadir_inputfield_verifications` (`id`, `name`, `regex`) VALUES
(1, 'normal', '.*'),
(2, 'e-mail', '^[_a-zA-Z0-9-]+(\\\\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\\\\.[a-zA-Z0-9-]+)*\\\\.(([0-9]{1,3})|([a-zA-Z]{2,3})|(aero|coop|info|museum|name))$'),
(3, 'url', '^(ht|f)tp[s]?\\\\:\\\\/\\\\/[A-Za-z0-9\\\\-\\\\:\\\\.\\\\?\\\\&\\\\=\\\\/\\\\#\\\\%]*$'),
(4, 'letters', '^[A-Za-zäàáüâûôñèöéè\\\\ ]*$'),
(5, 'numbers', '^[0-9]*$');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `contrexx_module_mediadir_levels`
--

CREATE TABLE IF NOT EXISTS `contrexx_module_mediadir_levels` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `parent_id` int(7) NOT NULL,
  `order` int(7) NOT NULL,
  `show_sublevels` int(11) NOT NULL,
  `show_categories` int(1) NOT NULL,
  `show_entries` int(1) NOT NULL,
  `picture` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `active` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `contrexx_module_mediadir_levels`
--

INSERT INTO `contrexx_module_mediadir_levels` (`id`, `parent_id`, `order`, `show_sublevels`, `show_categories`, `show_entries`, `picture`, `active`) VALUES
(1, 0, 0, 1, 1, 0, '', 1),
(3, 0, 0, 1, 1, 0, '', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `contrexx_module_mediadir_level_names`
--

CREATE TABLE IF NOT EXISTS `contrexx_module_mediadir_level_names` (
  `lang_id` int(1) NOT NULL,
  `level_id` int(7) NOT NULL,
  `level_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `level_description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  KEY `lang_id` (`lang_id`),
  KEY `category_id` (`level_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `contrexx_module_mediadir_level_names`
--

INSERT INTO `contrexx_module_mediadir_level_names` (`lang_id`, `level_id`, `level_name`, `level_description`) VALUES
(2, 1, 'sfsdf', ''),
(1, 1, 'sfsdf', ''),
(2, 3, 'Test', ''),
(1, 3, 'Test', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `contrexx_module_mediadir_mails`
--

CREATE TABLE IF NOT EXISTS `contrexx_module_mediadir_mails` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `recipients` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `lang_id` int(1) NOT NULL,
  `action_id` int(1) NOT NULL,
  `is_default` int(1) NOT NULL,
  `active` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=34 ;

--
-- Daten für Tabelle `contrexx_module_mediadir_mails`
--

INSERT INTO `contrexx_module_mediadir_mails` (`id`, `title`, `content`, `recipients`, `lang_id`, `action_id`, `is_default`, `active`) VALUES
(32, '[[URL]] - Neuer Eintrag hinzugefügt', 'Hallo Admin\r\n\r\nAuf [[URL]] wurde ein neuer Eintrag mit dem Titel "[[TITLE]]" erfasst. Bitte prüfen Sie diesen und geben sie gegebenenfalls frei.\r\n\r\nMit freundlichen Grüssen\r\n[[URL]] - Team\r\n\r\n[[DATE]]\r\n', '', 1, 1, 1, 1),
(20, '[[URL]] - Eintrag  erfolgreich bestätigt', 'Hallo [[FIRSTNAME]] [[LASTNAME]] ([[USERNAME]])\r\n\r\nIhr Eintrag mit dem Titel "[[TITLE]]" wurde erfolgreich bestätigt und ist ab sofort einsehbar.. \r\n\r\nBenutzen Sie folgenden Link um direkt zu ihrem Eintrag zu gelangen:\r\n[[LINK]]\r\n\r\nMit freundlichen Grüssen\r\n[[URL]] - Team\r\n\r\n[[DATE]]', '', 1, 3, 1, 1),
(19, '[[URL]] - Eintrag erfolgteich eingetragen', 'Hallo [[FIRSTNAME]] [[LASTNAME]] ([[USERNAME]])\r\n\r\nIhr Eintrag mit dem Titel "[[TITLE]]" wurde auf [[URL]] erfolgreich eingetragen. \r\n\r\n\r\nMit freundlichen Grüssen\r\n[[URL]] - Team\r\n\r\n[[DATE]]', '', 1, 2, 1, 1),
(21, '[[URL]] - Eintrag wurde bewertet', 'Hallo [[FIRSTNAME]] [[LASTNAME]] ([[USERNAME]])\r\n\r\nZu Ihrem Eintrag mit dem Titel "[[TITLE]]" auf [[URL]] wurde eine Bewertung abgegeben. \r\n\r\nBenutzen Sie folgenden Link um direkt zu Ihrem Eintrag zu gelangen:\r\n[[LINK]]\r\n\r\nMit freundlichen Grüssen\r\n[[URL]] - Team\r\n\r\n[[DATE]]', '', 1, 4, 1, 1),
(22, '[[URL]] - Eintrag erfolgreich gelöscht', 'Hallo [[FIRSTNAME]] [[LASTNAME]] ([[USERNAME]])\r\n\r\nIhr Eintrag mit dem Titel "[[TITLE]]" auf [[URL]] wurde erfolgreich gelöscht. \r\n\r\nMit freundlichen Grüssen\r\n[[URL]] - Team\r\n\r\n[[DATE]]', '', 1, 5, 1, 1),
(23, '[[URL]] - Eintrag erfolgreich bearbeitet', 'Hallo [[FIRSTNAME]] [[LASTNAME]] ([[USERNAME]])\r\n\r\nIhr Eintrag mit dem Titel "[[TITLE]]" auf [[URL]] wurde erfolgreich bearbeitet. \r\n\r\nBenutzen Sie folgenden Link um direkt zu Ihrem Eintrag zu gelangen:\r\n[[LINK]]\r\n\r\nMit freundlichen Grüssen\r\n[[URL]] - Team\r\n\r\n[[DATE]]\r\n\r\nBenutzername  	[[USERNAME]]\r\nVorname 	[[FIRSTNAME]]\r\nNachname 	[[LASTNAME]]\r\nTitel 	[[TITLE]]\r\nLink zum Eintrag 	[[LINK]]\r\nDomain Ihrer Homepage 	[[URL]]\r\nDatum 	[[DATE]]', '', 1, 6, 1, 1),
(24, '[[URL]] - Neuer Kommentar hinzugefügt', 'Hallo [[FIRSTNAME]] [[LASTNAME]] ([[USERNAME]])\r\n\r\nZu Ihrem Eintrag mit dem Titel "[[TITLE]]" auf [[URL]] wurde ein neuer Kommentar hinzugefügt. \r\n\r\nBenutzen Sie folgenden Link um direkt zu Ihrem Eintrag zu gelangen:\r\n[[LINK]]\r\n\r\nMit freundlichen Grüssen\r\n[[URL]] - Team\r\n\r\n[[DATE]]', '', 1, 8, 1, 1),
(31, '[[URL]] - New Entry added', 'Hello Masta\r\n\r\nNew entry has been added, maaan!\r\n\r\nGreeeezzzz your CMS System', '', 2, 1, 0, 1),
(33, '[[URL]] - Die Anzeigedauer eines Eintrages läuft ', 'Hallo Admin\r\n\r\nAuf [[URL]] läuft in Kürze die Anzeigedauer des Eintrages "[[TITLE]]" ab.\r\n\r\nMit freundlichen Grüssen\r\n[[URL]] - Team\r\n\r\n[[DATE]]\r\n', '', 1, 9, 1, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `contrexx_module_mediadir_mail_actions`
--

CREATE TABLE IF NOT EXISTS `contrexx_module_mediadir_mail_actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `default_recipient` enum('admin','author') COLLATE utf8_unicode_ci NOT NULL,
  `need_auth` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Daten für Tabelle `contrexx_module_mediadir_mail_actions`
--

INSERT INTO `contrexx_module_mediadir_mail_actions` (`id`, `name`, `default_recipient`, `need_auth`) VALUES
(1, 'newEntry', 'admin', 0),
(2, 'entryAdded', 'author', 1),
(3, 'entryConfirmed', 'author', 1),
(4, 'entryVoted', 'author', 1),
(5, 'entryDeleted', 'author', 1),
(6, 'entryEdited', 'author', 1),
(8, 'newComment', 'author', 1),
(9, 'notificationDisplayduration', 'admin', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `contrexx_module_mediadir_order_rel_forms_selectors`
--

CREATE TABLE IF NOT EXISTS `contrexx_module_mediadir_order_rel_forms_selectors` (
  `selector_id` int(7) NOT NULL,
  `form_id` int(7) NOT NULL,
  `selector_order` int(7) NOT NULL,
  `exp_search` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `contrexx_module_mediadir_order_rel_forms_selectors`
--

INSERT INTO `contrexx_module_mediadir_order_rel_forms_selectors` (`selector_id`, `form_id`, `selector_order`, `exp_search`) VALUES
(10, 4, 1, 0),
(9, 4, 0, 0),
(9, 1, 0, 0),
(10, 1, 3, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `contrexx_module_mediadir_rel_entry_categories`
--

CREATE TABLE IF NOT EXISTS `contrexx_module_mediadir_rel_entry_categories` (
  `entry_id` int(10) NOT NULL,
  `category_id` int(10) NOT NULL,
  KEY `entry_id` (`entry_id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `contrexx_module_mediadir_rel_entry_categories`
--

INSERT INTO `contrexx_module_mediadir_rel_entry_categories` (`entry_id`, `category_id`) VALUES
(32, 32),
(32, 37),
(32, 36),
(32, 33),
(32, 34),
(32, 35),
(73, 32),
(72, 32);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `contrexx_module_mediadir_rel_entry_inputfields`
--

CREATE TABLE IF NOT EXISTS `contrexx_module_mediadir_rel_entry_inputfields` (
  `entry_id` int(7) NOT NULL,
  `lang_id` int(7) NOT NULL,
  `form_id` int(7) NOT NULL,
  `field_id` int(7) NOT NULL,
  `value` longtext COLLATE utf8_unicode_ci NOT NULL,
  FULLTEXT KEY `value` (`value`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `contrexx_module_mediadir_rel_entry_inputfields`
--

INSERT INTO `contrexx_module_mediadir_rel_entry_inputfields` (`entry_id`, `lang_id`, `form_id`, `field_id`, `value`) VALUES
(73, 2, 1, 6, '123'),
(73, 1, 1, 3, '123'),
(73, 2, 1, 3, '123'),
(73, 1, 1, 6, '123'),
(72, 1, 1, 3, 'qweqwe'),
(72, 2, 1, 3, 'qweqwe'),
(72, 1, 1, 6, 'qweqweqwe'),
(72, 2, 1, 6, 'qweqweqwe'),
(32, 1, 1, 4, '46.7580046,7.6168957,15,'),
(32, 1, 1, 5, '/branches/2.1.3_mediadir/images/mediadir/uploads/plain_text.txt,plain_text.pdf'),
(32, 2, 1, 6, 'Schön'),
(32, 1, 1, 6, '<a href="&image">yxcyxc</a>'),
(32, 2, 1, 3, 'Comvation AG'),
(32, 1, 1, 3, 'Comvation AG 22');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `contrexx_module_mediadir_rel_entry_levels`
--

CREATE TABLE IF NOT EXISTS `contrexx_module_mediadir_rel_entry_levels` (
  `entry_id` int(10) NOT NULL,
  `level_id` int(10) NOT NULL,
  KEY `entry_id` (`entry_id`),
  KEY `category_id` (`level_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `contrexx_module_mediadir_rel_entry_levels`
--

INSERT INTO `contrexx_module_mediadir_rel_entry_levels` (`entry_id`, `level_id`) VALUES
(32, 3),
(32, 1),
(72, 1),
(73, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `contrexx_module_mediadir_settings`
--

CREATE TABLE IF NOT EXISTS `contrexx_module_mediadir_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=44 ;

--
-- Daten für Tabelle `contrexx_module_mediadir_settings`
--

INSERT INTO `contrexx_module_mediadir_settings` (`id`, `name`, `value`) VALUES
(1, 'settingsShowCategoryDescription', '0'),
(2, 'settingsShowCategoryImage', '0'),
(3, 'settingsCategoryOrder', '0'),
(4, 'settingsShowLevels', '1'),
(5, 'settingsShowLevelDescription', '1'),
(6, 'settingsShowLevelImage', '1'),
(7, 'settingsLevelOrder', '0'),
(8, 'settingsConfirmNewEntries', '1'),
(9, 'categorySelectorOrder', '9'),
(10, 'levelSelectorOrder', '10'),
(11, 'settingsConfirmUpdatedEntries', '0'),
(12, 'settingsCountEntries', '0'),
(13, 'settingsThumbSize', '148'),
(14, 'settingsNumGalleryPics', '10'),
(15, 'settingsEncryptFilenames', '1'),
(16, 'settingsAllowAddEntries', '1'),
(17, 'settingsAllowDelEntries', '1'),
(18, 'settingsAllowEditEntries', '1'),
(19, 'settingsAddEntriesOnlyCommunity', '1'),
(20, 'settingsLatestNumXML', '10'),
(21, 'settingsLatestNumOverview', '5'),
(22, 'settingsLatestNumBackend', '5'),
(23, 'settingsLatestNumFrontend', '10'),
(24, 'settingsPopularNumFrontend', '10'),
(25, 'settingsPopularNumRestore', '30'),
(26, 'settingsLatestNumHeadlines', '4'),
(27, 'settingsGoogleMapStartposition', '46.749647513758326,7.6300048828125,8'),
(28, 'settingsAllowVotes', '1'),
(29, 'settingsVoteOnlyCommunity', '0'),
(30, 'settingsAllowComments', '1'),
(31, 'settingsCommentOnlyCommunity', '0'),
(32, 'settingsGoogleMapAllowKml', '0'),
(33, 'settingsShowEntriesInAllLang', '1'),
(34, 'settingsPagingNumEntries', '2'),
(35, 'settingsGoogleMapType', '0'),
(36, 'settingsClassificationPoints', '5'),
(37, 'settingsClassificationSearch', '1'),
(38, 'settingsEntryDisplaydurationType', '1'),
(39, 'settingsEntryDisplaydurationValue', '0'),
(40, 'settingsEntryDisplaydurationValueType', '1'),
(41, 'settingsEntryDisplaydurationNotification', '0'),
(42, 'categorySelectorExpSearch', '9'),
(43, 'levelSelectorExpSearch', '10');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `contrexx_module_mediadir_settings_num_categories`
--

CREATE TABLE IF NOT EXISTS `contrexx_module_mediadir_settings_num_categories` (
  `group_id` int(1) NOT NULL,
  `num_categories` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `contrexx_module_mediadir_settings_num_categories`
--

INSERT INTO `contrexx_module_mediadir_settings_num_categories` (`group_id`, `num_categories`) VALUES
(3, '1'),
(4, '1'),
(5, '1');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `contrexx_module_mediadir_settings_num_entries`
--

CREATE TABLE IF NOT EXISTS `contrexx_module_mediadir_settings_num_entries` (
  `group_id` int(1) NOT NULL,
  `num_entries` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `contrexx_module_mediadir_settings_num_entries`
--

INSERT INTO `contrexx_module_mediadir_settings_num_entries` (`group_id`, `num_entries`) VALUES
(3, '1'),
(4, '1'),
(5, '1');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `contrexx_module_mediadir_settings_num_levels`
--

CREATE TABLE IF NOT EXISTS `contrexx_module_mediadir_settings_num_levels` (
  `group_id` int(1) NOT NULL,
  `num_levels` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `contrexx_module_mediadir_settings_num_levels`
--

INSERT INTO `contrexx_module_mediadir_settings_num_levels` (`group_id`, `num_levels`) VALUES
(3, '1'),
(4, '1'),
(5, '1');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `contrexx_module_mediadir_settings_perm_group_forms`
--

CREATE TABLE IF NOT EXISTS `contrexx_module_mediadir_settings_perm_group_forms` (
  `group_id` int(7) NOT NULL,
  `form_id` int(1) NOT NULL,
  `status_group` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `contrexx_module_mediadir_settings_perm_group_forms`
--

INSERT INTO `contrexx_module_mediadir_settings_perm_group_forms` (`group_id`, `form_id`, `status_group`) VALUES
(5, 1, 1),
(4, 1, 1),
(3, 1, 1),
(5, 4, 1),
(4, 4, 1),
(3, 4, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `contrexx_module_mediadir_votes`
--

CREATE TABLE IF NOT EXISTS `contrexx_module_mediadir_votes` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `entry_id` int(7) NOT NULL,
  `added_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `vote` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=40 ;

--
-- Daten für Tabelle `contrexx_module_mediadir_votes`
--

INSERT INTO `contrexx_module_mediadir_votes` (`id`, `entry_id`, `added_by`, `date`, `ip`, `vote`) VALUES
(4, 120, '0', '1252584354', '127.0.0.1', 9),
(2, 135, '0', '1252574431', '127.0.0.1', 10),
(3, 121, '0', '1252575903', '127.0.0.1', 10),
(5, 140, '0', '1253019391', '127.0.0.1', 8),
(6, 141, '0', '1253019403', '127.0.0.1', 1),
(7, 147, '0', '1254992695', '127.0.0.1', 7),
(8, 148, '0', '1254992703', '127.0.0.1', 10),
(9, 154, '0', '1257238496', '127.0.0.1', 9),
(10, 174, '0', '1257425647', '127.0.0.1', 10),
(11, 186, '0', '1257774959', '127.0.0.1', 6),
(12, 187, '0', '1257775465', '127.0.0.1', 10),
(13, 191, '0', '1262610260', '127.0.0.1', 8),
(14, 193, '0', '1262612558', '127.0.0.1', 8),
(15, 194, '0', '1262686547', '127.0.0.1', 6),
(16, 195, '0', '1262687217', '127.0.0.1', 10),
(17, 196, '0', '1262783780', '127.0.0.1', 10),
(18, 215, '0', '1262798726', '127.0.0.1', 8),
(19, 226, '0', '1263221550', '127.0.0.1', 5),
(20, 225, '0', '1263221841', '127.0.0.1', 7),
(21, 253, '0', '1263806046', '127.0.0.1', 7),
(22, 254, '0', '1263810690', '212.41.216.110', 3),
(23, 256, '0', '1263819373', '212.41.216.110', 3),
(24, 255, '0', '1263819500', '212.41.216.110', 10),
(25, 265, '0', '1263919516', '147.87.143.199', 7),
(26, 266, '0', '1263992288', '212.41.216.110', 3),
(27, 263, '0', '1263994755', '212.41.216.110', 4),
(28, 258, '0', '1263996729', '212.41.216.110', 2),
(29, 258, '0', '1264179236', '80.218.43.56', 9),
(30, 1, '0', '1265304337', '::1', 3),
(31, 3, '0', '1267795755', '::1', 4),
(32, 5, '0', '1268810365', '::1', 6),
(34, 19, '0', '1269341335', '::1', 10),
(35, 30, '0', '1269868265', '::1', 8),
(36, 31, '0', '1269948295', '::1', 4),
(37, 32, '0', '1269949885', '::1', 10),
(38, 39, '0', '1271339679', '::1', 9),
(39, 69, '0', '1271841689', '::1', 8);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


INSERT INTO `contrexx_backend_areas` (`area_id`, `parent_area_id`, `type`, `scope`, `area_name`, `is_active`, `uri`, `target`, `module_id`, `order_id`, `access_id`) VALUES
(155, 2, 'navigation', 'global', 'TXT_MEDIADIR_MODULE', 1, 'index.php?cmd=mediadir', '_self', 60, 0, 155);


INSERT INTO `contrexx_modules` (`id`, `name`, `description_variable`, `status`, `is_required`, `is_core`) VALUES
(62, 'mediadir', 'TXT_MEDIADIR_MODULE_DESCTIPTION', 'y', 0, 0);

INSERT INTO `contrexx_module_repository` (`id`, `moduleid`, `content`, `title`, `cmd`, `expertmode`, `parid`, `displaystatus`, `username`, `displayorder`, `lang`) VALUES
(884, 62, '<div id="mediadir">\r\n{MEDIADIR_JAVASCRIPT}\r\n\r\n<!-- BEGIN mediadirSearchform -->\r\n{MEDIADIR_NORMAL_SEARCH_FORM}<br />\r\n<!-- END mediadirSearchform -->\r\n\r\n<!-- BEGIN mediadirNavtree -->\r\n<ul>\r\n<!-- BEGIN mediadirNavtreeElement -->\r\n<li {MEDIADIR_NAVTREE_LINK_CLASS}>{MEDIADIR_NAVTREE_LINK}</li>\r\n<!-- END mediadirNavtreeElement -->\r\n</ul>\r\n<br />\r\n<!-- END mediadirNavtree -->\r\n\r\n<!-- BEGIN mediadirCategoryLevelDetail -->\r\n<h2>{MEDIADIR_CATEGORY_LEVEL_NAME}</h2>\r\n<!-- BEGIN mediadirCategoryLevelPicture -->\r\n{MEDIADIR_CATEGORY_LEVEL_PICTURE}<br /><br />\r\n<!-- END mediadirCategoryLevelPicture -->\r\n<!-- BEGIN mediadirCategoryLevelDescription -->\r\n{MEDIADIR_CATEGORY_LEVEL_DESCRIPTION}<br />Num Entries: {MEDIADIR_CATEGORY_LEVEL_NUM_ENTRIES}<br />ID: {MEDIADIR_CATEGORY_LEVEL_ID}<br /><br />\r\n<!-- END mediadirCategoryLevelDescription -->\r\n<br />\r\n<!-- END mediadirCategoryLevelDetail -->\r\n\r\n<!-- BEGIN mediadirCategoriesLevelsList -->\r\n<table border="0" width="100%">\r\n<tr>\r\n<td width="33%" valign="top">\r\n<ul>\r\n<!-- BEGIN mediadirCategoriesLevels_row_1 -->\r\n<li>{MEDIADIR_CATEGORY_LEVEL_LINK} {MEDIADIR_CATEGORY_LEVEL_NUM_ENTRIES}</li>\r\n<!-- END mediadirCategoriesLevels_row_1 -->\r\n</ul>\r\n</td>\r\n<td width="33%" valign="top">\r\n<ul>\r\n<!-- BEGIN mediadirCategoriesLevels_row_2 -->\r\n<li>{MEDIADIR_CATEGORY_LEVEL_LINK} {MEDIADIR_CATEGORY_LEVEL_NUM_ENTRIES}</li>\r\n<!-- END mediadirCategoriesLevels_row_2 -->\r\n</ul>\r\n</td>\r\n<td width="33%" valign="top">\r\n<ul>\r\n<!-- BEGIN mediadirCategoriesLevels_row_3 -->\r\n<li>{MEDIADIR_CATEGORY_LEVEL_LINK} {MEDIADIR_CATEGORY_LEVEL_NUM_ENTRIES}</li>\r\n<!-- END mediadirCategoriesLevels_row_3 -->\r\n</ul>\r\n</td>\r\n</tr>\r\n</table>\r\n<br />\r\n<!-- END mediadirCategoriesLevelsList -->\r\n\r\n<!-- BEGIN mediadirEntryList -->\r\n<table border="1" width="100%">\r\n<tr>\r\n<td colspan="3">\r\n<h2><!-- BEGIN mediadir_inputfield_3 -->{MEDIADIR_INPUTFIELD_VALUE}<!-- END mediadir_inputfield_3 --></h2>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td width="33%">\r\n<!-- BEGIN mediadirEntryVotes -->\r\n{MEDIADIR_ENTRY_VOTES}\r\n<!-- END mediadirEntryVotes -->\r\n</td>\r\n<td width="33%">\r\n<!-- BEGIN mediadirEntryComments -->\r\n{MEDIADIR_ENTRY_COMMENTS}\r\n<!-- END mediadirEntryComments -->\r\n</td>\r\n<td width="33%">\r\n<a href="{MEDIADIR_ENTRY_DETAIL_URL}">{TXT_MEDIADIR_ENTRY_DETAIL}</a>\r\n</td>\r\n</tr>\r\n</table>\r\n<br />\r\n<!-- END mediadirEntryList -->\r\n{MEDIADIR_PAGING}\r\n<!-- BEGIN mediadirNoEntriesFound -->\r\n{TXT_MEDIADIR_SEARCH_MESSAGE}\r\n<!-- END mediadirNoEntriesFound -->\r\n</div>', 'Media Directory', '', 'y', 0, 'on', 'system', 111, '1'),
(885, 62, '<div id="mediadir">\r\n    {MEDIADIR_JAVASCRIPT}\r\n\r\n    <!-- BEGIN mediadirEntryOkMessage -->\r\n    OK: {TXT_MEDIADIR_OK_MESSAGE}\r\n    <!-- END mediadirEntryOkMessage -->\r\n    \r\n    <!-- BEGIN mediadirEntryErrMessage -->\r\n    ERR: {TXT_MEDIADIR_ERR_MESSAGE}\r\n    <!-- END mediadirEntryErrMessage -->\r\n    \r\n    <!-- BEGIN mediadirEntryModifyForm -->\r\n    <form enctype="multipart/form-data" method="post" onsubmit="{MEDIADIR_FORM_ONSUBMIT}" action="index.php?section=mediadir&amp;cmd=add" name="entryModfyForm">\r\n    \r\n        <!-- BEGIN mediadirForms -->   \r\n        <table width="100%">\r\n            <!-- BEGIN mediadirFormList -->  \r\n            <tr>\r\n                <td width="1%" valign="top"><input type="radio" name="selectedFormId" value="{TXT_MEDIADIR_FORM_ID}" onclick="document.entryModfyForm.submit();"></td>\r\n                <td width="30%" valign="top">{TXT_MEDIADIR_FORM_IMAGE_THUMB}</td>\r\n                <td width="69%" valign="top"><h2>{TXT_MEDIADIR_FORM_TITLE}</h2>{TXT_MEDIADIR_FORM_DESCRIPTION}</td>\r\n            </tr> \r\n            <!-- END mediadirFormList -->   \r\n        </table>\r\n        <!-- END mediadirForms -->\r\n    \r\n        <!-- BEGIN mediadirInputfields -->\r\n            <!-- BEGIN mediadirEntryAddStepNavigation -->\r\n            <!-- BEGIN mediadirEntryAddStepNavigationElement -->\r\n            <input type="button" value="{MEDIADIR_ENTRY_ADDSTEP_NAME}" id="{MEDIADIR_ENTRY_ADDSTEP_ID}" onclick="{MEDIADIR_ENTRY_ADDSTEP_HREF}" class="{MEDIADIR_ENTRY_ADDSTEP_CLASS}" />\r\n            <!-- END mediadirEntryAddStepNavigationElement -->\r\n            <!-- END mediadirEntryAddStepNavigation -->\r\n\r\n            <input type="hidden" value="{MEDIADIR_ENTRY_ID}" name="entryId" />\r\n            <input type="hidden" value="{MEDIADIR_FORM_ID}" name="formId" />\r\n        \r\n            <!-- BEGIN mediadirInputfieldElement -->   \r\n    \r\n                <!-- BEGIN mediadirInputfieldAddStep -->  \r\n                {MEDIADIR_INPUTFIELD_ADDSTEP}\r\n                <!-- END mediadirInputfieldAddStep -->\r\n    \r\n                <!-- BEGIN mediadirInputfieldList -->   \r\n                <p><label>{TXT_MEDIADIR_INPUTFIELD_NAME}</label>{MEDIADIR_INPUTFIELD_FIELD}</p>\r\n                <!-- END mediadirInputfieldList -->\r\n        \r\n            <!-- END mediadirInputfieldElement -->\r\n            \r\n            <p><input type="submit" value="{TXT_MEDIADIR_SUBMIT}" name="submitEntryModfyForm" /></p>\r\n            <div style="display: none; color: rgb(255, 0, 0);" id="mediadirErrorMessage"><p>{TXT_MEDIADIR_PLEASE_CHECK_INPUT}</p></div>\r\n\r\n            {MEDIADIR_INPUTFIELD_ADDSTEP_TERMINATOR}\r\n        <!-- END mediadirInputfields -->\r\n    </form>\r\n    <!-- END mediadirEntryModifyForm -->\r\n</div>', 'Add', 'add', 'y', 884, 'on', 'system', 1, '1'),
(886, 62, '<div id="mediadir">\r\n<!-- BEGIN mediadirEntryList -->\r\n<table border="1" width="100%">\r\n<tr>\r\n<td colspan="3">\r\n<h2><!-- BEGIN mediadir_inputfield_3 -->{MEDIADIR_INPUTFIELD_VALUE}<!-- END mediadir_inputfield_3 --></h2>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td width="33%">\r\n<!-- BEGIN mediadirEntryVotes -->\r\n{MEDIADIR_ENTRY_VOTES}\r\n<!-- END mediadirEntryVotes -->\r\n</td>\r\n<td width="33%">\r\n<!-- BEGIN mediadirEntryComments -->\r\n{MEDIADIR_ENTRY_COMMENTS}\r\n<!-- END mediadirEntryComments -->\r\n</td>\r\n<td width="33%">\r\n<a href="{MEDIADIR_ENTRY_DETAIL_URL}">{TXT_MEDIADIR_ENTRY_DETAIL}</a>\r\n</td>\r\n</tr>\r\n</table>\r\n<br />\r\n<!-- END mediadirEntryList -->\r\n</div>', 'Latest', 'latest', 'y', 884, 'on', 'system', 1, '1'),
(887, 62, '<div id="mediadir">\r\n<!-- BEGIN mediadirEntryList -->\r\n<table border="1" width="100%">\r\n<tr>\r\n<td colspan="3">\r\n<h2><!-- BEGIN mediadir_inputfield_3 -->{MEDIADIR_INPUTFIELD_VALUE}<!-- END mediadir_inputfield_3 --></h2>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td width="33%">\r\n<!-- BEGIN mediadirEntryVotes -->\r\n{MEDIADIR_ENTRY_VOTES}\r\n<!-- END mediadirEntryVotes -->\r\n</td>\r\n<td width="33%">\r\n<!-- BEGIN mediadirEntryComments -->\r\n{MEDIADIR_ENTRY_COMMENTS}\r\n<!-- END mediadirEntryComments -->\r\n</td>\r\n<td width="33%">\r\n<a href="{MEDIADIR_ENTRY_DETAIL_URL}">{TXT_MEDIADIR_ENTRY_DETAIL}</a>\r\n</td>\r\n</tr>\r\n</table>\r\n<br />\r\n<!-- END mediadirEntryList -->\r\n</div>', 'Popular', 'popular', 'y', 884, 'on', 'system', 1, '1'),
(888, 62, '<div id="mediadir">\r\n<!-- BEGIN mediadirSearchform -->\r\n{MEDIADIR_EXPANDED_SEARCH_FORM}\r\n<!-- END mediadirSearchform -->\r\n\r\n\r\n<!-- BEGIN mediadirEntryList -->\r\n<table border="1" width="100%">\r\n<tr>\r\n<td colspan="3">\r\n<h2><!-- BEGIN mediadir_inputfield_3 -->{MEDIADIR_INPUTFIELD_VALUE}<!-- END mediadir_inputfield_3 --></h2>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td width="33%">\r\n<!-- BEGIN mediadirEntryVotes -->\r\n{MEDIADIR_ENTRY_VOTES}\r\n<!-- END mediadirEntryVotes -->\r\n</td>\r\n<td width="33%">\r\n<!-- BEGIN mediadirEntryComments -->\r\n{MEDIADIR_ENTRY_COMMENTS}\r\n<!-- END mediadirEntryComments -->\r\n</td>\r\n<td width="33%">\r\n<a href="{MEDIADIR_ENTRY_DETAIL_URL}">{TXT_MEDIADIR_ENTRY_DETAIL}</a>\r\n</td>\r\n</tr>\r\n</table>\r\n<br />\r\n<!-- END mediadirEntryList -->\r\n\r\n{MEDIADIR_PAGING}\r\n\r\n<!-- BEGIN mediadirNoEntriesFound -->\r\n{TXT_MEDIADIR_SEARCH_MESSAGE}\r\n<!-- END mediadirNoEntriesFound -->\r\n</div>', 'Search', 'search', 'y', 884, 'on', 'system', 1, '1'),
(889, 62, '<div id="mediadir">\r\n{MEDIADIR_GOOGLE_MAP}\r\n</div>', 'Map', 'map', 'y', 884, 'on', 'system', 1, '1'),
(890, 62, '<div id="mediadir">\r\n{MEDIADIR_JAVASCRIPT}\r\n\r\n<!-- BEGIN mediadirNavtree -->\r\n<ul>\r\n<!-- BEGIN mediadirNavtreeElement -->\r\n<li {MEDIADIR_NAVTREE_LINK_CLASS}>{MEDIADIR_NAVTREE_LINK}</li>\r\n<!-- END mediadirNavtreeElement -->\r\n</ul>\r\n<br />\r\n<!-- END mediadirNavtree -->\r\n\r\n<!-- BEGIN mediadirEntryList -->\r\n<table border="0" cellpadding="2">\r\n\r\n<!-- BEGIN mediadir_inputfield_6 -->\r\n<tr>\r\n<td valign="top" width="30%">\r\n<b>{TXT_MEDIADIR_INPUTFIELD_NAME}:</b>\r\n</td>\r\n<td width="70%">\r\n{MEDIADIR_INPUTFIELD_VALUE_ALLOW_TAGS} \r\n</td>\r\n</tr>\r\n<!-- END mediadir_inputfield_6 -->\r\n<tr>\r\n<td>{TXT_MEDIADIR_ENTRY_CATEGORIES}</td>\r\n<td>{MEDIADIR_ENTRY_CATEGORIES}</td>\r\n</tr>\r\n<tr>\r\n<td>{TXT_MEDIADIR_ENTRY_LEVELS}</td>\r\n<td>{MEDIADIR_ENTRY_LEVELS}</td>\r\n</tr>\r\n\r\n<!-- BEGIN mediadirEntryVoteForm -->\r\n<tr>\r\n<td valign="top">\r\n<b>{TXT_MEDIADIR_VOTING}</b>\r\n</td>\r\n<td>\r\n<!-- BEGIN mediadirEntryVotes -->\r\n{MEDIADIR_ENTRY_VOTES}\r\n<br />\r\n<!-- END mediadirEntryVotes -->\r\n{MEDIADIR_ENTRY_VOTE_FORM}\r\n</td>\r\n</tr>\r\n<!-- END mediadirEntryVoteForm -->\r\n\r\n<!-- BEGIN mediadirEntryCommentForm -->\r\n<tr>\r\n<td valign="top">\r\n<b>{TXT_MEDIADIR_COMMENTS}</b>\r\n</td>\r\n<td>\r\n{MEDIADIR_ENTRY_COMMENTS}<br /><br />\r\n<!-- BEGIN mediadirEntryComments -->\r\n<div class="mediadirComments">\r\n<b>{MEDIADIR_ENTRY_COMMENT_NAME}</b><br />\r\n<i>{MEDIADIR_ENTRY_COMMENT_DATE}</i><br /><br />\r\n{MEDIADIR_ENTRY_COMMENT_COMMENT}<br /><br />\r\n<br />\r\n</div>\r\n<!-- END mediadirEntryComments -->\r\n{MEDIADIR_ENTRY_NEW_ADDED_COMMENT}\r\n<br />\r\n{MEDIADIR_ENTRY_COMMENT_FORM}\r\n</td>\r\n</tr>\r\n<!-- END mediadirEntryCommentForm -->\r\n\r\n<tr>\r\n<td colspan="2"><br /></td>\r\n</tr>\r\n<tr>\r\n<td><br /></td>\r\n<td>\r\n<!-- BEGIN mediadirEntryEditLink -->\r\n<a href="{MEDIADIR_ENTRY_EDIT_URL}">{TXT_MEDIADIR_ENTRY_EDIT}</a>\r\n<!-- END mediadirEntryEditLink -->\r\n\r\n<!-- BEGIN mediadirEntryDeleteLink -->\r\n | <a href="{MEDIADIR_ENTRY_DELETE_URL}">{TXT_MEDIADIR_ENTRY_DELETE}</a>\r\n<!-- END mediadirEntryDeleteLink --></td></tr>\r\n</table>\r\n<!-- END mediadirEntryList -->\r\n</div>', 'Detail', 'detail', 'y', 884, 'off', 'system', 99, '1'),
(891, 62, '<div id="mediadir">\r\n    <!-- BEGIN mediadirEntryOkMessage -->\r\n    OK: {TXT_MEDIADIR_OK_MESSAGE}\r\n    <!-- END mediadirEntryOkMessage -->\r\n    \r\n    <!-- BEGIN mediadirEntryErrMessage -->\r\n    ERR: {TXT_MEDIADIR_ERR_MESSAGE}\r\n    <!-- END mediadirEntryErrMessage -->\r\n    \r\n    <!-- BEGIN mediadirEntryModifyForm -->\r\n    <form method="post" action="index.php?section=mediadir&amp;cmd=delete" name="entryModfyForm">\r\n        <input type="hidden" value="{MEDIADIR_ENTRY_ID}" name="entryId" /> \r\n        Wollen Sie folgenden Eintrag wirklich l�schen? Die Daten werden unwiederruflich gel�scht.\r\n        <br/><br/>\r\n        <!-- BEGIN mediadirEntryList -->\r\n                <!-- BEGIN mediadir_inputfields -->\r\n                <b>{TXT_MEDIADIR_INPUTFIELD_NAME}:</b>&nbsp;{MEDIADIR_INPUTFIELD_VALUE}<br/>\r\n                <!-- END mediadir_inputfields -->\r\n        <!-- END mediadirEntryList -->\r\n        <br/>\r\n        <input type="button" value="{TXT_MEDIADIR_ABORT}" name="abort" onclick="javascript:history.go(-1);" />&nbsp;<input type="submit" value="{TXT_MEDIADIR_DELETE}" name="submitEntryModfyForm" /><br />\r\n    </form>\r\n    <!-- END mediadirEntryModifyForm -->\r\n</div>', 'Delete', 'delete', 'y', 884, 'off', 'system', 99, '1'),
(892, 62, '<div id="mediadir">\r\n    {MEDIADIR_JAVASCRIPT}\r\n\r\n    <!-- BEGIN mediadirEntryOkMessage -->\r\n    OK: {TXT_MEDIADIR_OK_MESSAGE}\r\n    <!-- END mediadirEntryOkMessage -->\r\n    \r\n    <!-- BEGIN mediadirEntryErrMessage -->\r\n    ERR: {TXT_MEDIADIR_ERROR_MESSAGE}\r\n    <!-- END mediadirEntryErrMessage -->\r\n    \r\n    <!-- BEGIN mediadirEntryModifyForm -->\r\n    <form enctype="multipart/form-data" method="post" onsubmit="{MEDIADIR_FORM_ONSUBMIT}" action="index.php?section=mediadir&amp;cmd=edit" name="entryModfyForm">\r\n    \r\n        <!-- BEGIN mediadirForms -->   \r\n        <table width="100%">\r\n            <!-- BEGIN mediadirFormList -->  \r\n            <tr>\r\n                <td width="1%" valign="top"><input type="radio" name="selectedFormId" value="{TXT_MEDIADIR_FORM_ID}" onclick="document.entryModfyForm.submit();"></td>\r\n                <td width="30%" valign="top">{TXT_MEDIADIR_FORM_IMAGE_THUMB}</td>\r\n                <td width="69%" valign="top"><h2>{TXT_MEDIADIR_FORM_TITLE}</h2>{TXT_MEDIADIR_FORM_DESCRIPTION}</td>\r\n            </tr> \r\n            <!-- END mediadirFormList -->   \r\n        </table>\r\n        <!-- END mediadirForms -->\r\n    \r\n        <!-- BEGIN mediadirInputfields -->\r\n            <!-- BEGIN mediadirEntryAddStepNavigation -->\r\n            <!-- BEGIN mediadirEntryAddStepNavigationElement -->\r\n            <input type="button" value="{MEDIADIR_ENTRY_ADDSTEP_NAME}" id="{MEDIADIR_ENTRY_ADDSTEP_ID}" onclick="{MEDIADIR_ENTRY_ADDSTEP_HREF}" class="{MEDIADIR_ENTRY_ADDSTEP_CLASS}" />\r\n            <!-- END mediadirEntryAddStepNavigationElement -->\r\n            <!-- END mediadirEntryAddStepNavigation -->\r\n\r\n            <input type="hidden" value="{MEDIADIR_ENTRY_ID}" name="entryId" />\r\n            <input type="hidden" value="{MEDIADIR_FORM_ID}" name="formId" />\r\n        \r\n            <!-- BEGIN mediadirInputfieldElement -->   \r\n    \r\n                <!-- BEGIN mediadirInputfieldAddStep -->  \r\n                {MEDIADIR_INPUTFIELD_ADDSTEP}\r\n                <!-- END mediadirInputfieldAddStep -->\r\n    \r\n                <!-- BEGIN mediadirInputfieldList -->   \r\n                <p><label>{TXT_MEDIADIR_INPUTFIELD_NAME}</label>{MEDIADIR_INPUTFIELD_FIELD}</p>\r\n                <!-- END mediadirInputfieldList -->\r\n        \r\n            <!-- END mediadirInputfieldElement -->\r\n            \r\n            <p><input type="submit" value="{TXT_MEDIADIR_SUBMIT}" name="submitEntryModfyForm" /></p>\r\n            <div style="display: none; color: rgb(255, 0, 0);" id="mediadirErrorMessage"><p>{TXT_MEDIADIR_PLEASE_CHECK_INPUT}</p></div>\r\n\r\n            {MEDIADIR_INPUTFIELD_ADDSTEP_TERMINATOR}\r\n        <!-- END mediadirInputfields -->\r\n    </form>\r\n    <!-- END mediadirEntryModifyForm -->\r\n</div>', 'Edit', 'edit', 'y', 884, 'off', 'system', 99, '1');
