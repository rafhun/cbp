--
-- Contrexx WCMS SQL Dump
--
-- version: 4.0.0
-- created: 17.12.2014 00:00
--
-- http://www.contrexx.com
--
CREATE TABLE `contrexx_access_group_dynamic_ids` (
  `access_id` int(11) unsigned NOT NULL default '0',
  `group_id` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`access_id`,`group_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_access_group_static_ids` (
  `access_id` int(11) unsigned NOT NULL default '0',
  `group_id` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`access_id`,`group_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_access_rel_user_group` (
  `user_id` int(10) unsigned NOT NULL default '0',
  `group_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`group_id`)
) ENGINE=InnoDB;

CREATE TABLE `contrexx_access_settings` (
  `key` varchar(32) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  `status` tinyint(1) unsigned NOT NULL default '0',
  UNIQUE KEY `key` (`key`)
) ENGINE=InnoDB;

CREATE TABLE `contrexx_access_users` (
  `id` int(5) unsigned NOT NULL auto_increment,
  `is_admin` tinyint(1) unsigned NOT NULL default '0',
  `username` varchar(255) default NULL,
  `password` varchar(32) default NULL,
  `regdate` int(14) unsigned NOT NULL default '0',
  `expiration` int(14) unsigned NOT NULL default '0',
  `validity` int(10) unsigned NOT NULL default '0',
  `last_auth` int(14) unsigned NOT NULL default '0',
  `last_auth_status` int(1) NOT NULL default '1',
  `last_activity` int(14) unsigned NOT NULL default '0',
  `email` varchar(255) default NULL,
  `email_access` enum('everyone','members_only','nobody') NOT NULL default 'nobody',
  `frontend_lang_id` int(2) unsigned NOT NULL default '0',
  `backend_lang_id` int(2) unsigned NOT NULL default '0',
  `active` tinyint(1) NOT NULL default '0',
  `primary_group` int(6) unsigned NOT NULL default '0',
  `profile_access` enum('everyone','members_only','nobody') NOT NULL default 'members_only',
  `restore_key` varchar(32) NOT NULL default '',
  `restore_key_time` int(14) unsigned NOT NULL default '0',
  `u2u_active` enum('0','1') NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `username` (`username`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_access_user_attribute` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `parent_id` int(10) unsigned NOT NULL default '0',
  `type` enum('text','textarea','mail','uri','date','image','checkbox','menu','menu_option','group','frame','history') NOT NULL default 'text',
  `mandatory` enum('0','1') NOT NULL default '0',
  `sort_type` enum('asc','desc','custom') NOT NULL default 'asc',
  `order_id` int(10) unsigned NOT NULL default '0',
  `access_special` enum('','menu_select_higher','menu_select_lower') NOT NULL default '',
  `access_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB;

CREATE TABLE `contrexx_access_user_attribute_name` (
  `attribute_id` int(10) unsigned NOT NULL default '0',
  `lang_id` int(10) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`attribute_id`,`lang_id`)
) ENGINE=InnoDB;

CREATE TABLE `contrexx_access_user_attribute_value` (
  `attribute_id` int(10) unsigned NOT NULL default '0',
  `user_id` int(10) unsigned NOT NULL default '0',
  `history_id` int(10) unsigned NOT NULL default '0',
  `value` text NOT NULL,
  PRIMARY KEY  (`attribute_id`,`user_id`,`history_id`),
  FULLTEXT KEY `value` (`value`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_access_user_core_attribute` (
  `id` varchar(25) NOT NULL,
  `mandatory` enum('0','1') NOT NULL default '0',
  `sort_type` enum('asc','desc','custom') NOT NULL default 'asc',
  `order_id` int(10) unsigned NOT NULL default '0',
  `access_special` enum('','menu_select_higher','menu_select_lower') NOT NULL default '',
  `access_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB;

CREATE TABLE `contrexx_access_user_groups` (
  `group_id` int(6) unsigned NOT NULL auto_increment,
  `group_name` varchar(100) NOT NULL default '',
  `group_description` varchar(255) NOT NULL default '',
  `is_active` tinyint(4) NOT NULL default '1',
  `type` enum('frontend','backend') NOT NULL default 'frontend',
  `homepage` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`group_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_access_user_mail` (
  `type` enum('reg_confirm','reset_pw','user_activated','user_deactivated','new_user') NOT NULL default 'reg_confirm',
  `lang_id` tinyint(2) unsigned NOT NULL default '0',
  `sender_mail` varchar(255) NOT NULL default '',
  `sender_name` varchar(255) NOT NULL default '',
  `subject` varchar(255) NOT NULL default '',
  `format` enum('text','html','multipart') NOT NULL default 'text',
  `body_text` text NOT NULL,
  `body_html` text NOT NULL,
  UNIQUE KEY `mail` (`type`,`lang_id`)
) ENGINE=InnoDB;

CREATE TABLE `contrexx_access_user_network` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `oauth_provider` varchar(100) NOT NULL default '',
  `oauth_id` varchar(100) NOT NULL default '',
  `user_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB;

CREATE TABLE `contrexx_access_user_profile` (
  `user_id` int(5) unsigned NOT NULL default '0',
  `gender` enum('gender_undefined','gender_female','gender_male') NOT NULL default 'gender_undefined',
  `title` int(10) unsigned NOT NULL default '0',
  `firstname` varchar(255) NOT NULL default '',
  `lastname` varchar(255) NOT NULL default '',
  `company` varchar(255) NOT NULL default '',
  `address` varchar(255) NOT NULL default '',
  `city` varchar(50) NOT NULL default '',
  `zip` varchar(10) NOT NULL default '',
  `country` smallint(5) unsigned NOT NULL default '0',
  `phone_office` varchar(20) NOT NULL default '',
  `phone_private` varchar(20) NOT NULL default '',
  `phone_mobile` varchar(20) NOT NULL default '',
  `phone_fax` varchar(20) NOT NULL default '',
  `birthday` varchar(11) default NULL,
  `website` varchar(255) NOT NULL default '',
  `profession` varchar(150) NOT NULL default '',
  `interests` text ,
  `signature` text ,
  `picture` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`user_id`),
  KEY `profile` (`firstname`(100),`lastname`(100),`company`(50))
) ENGINE=InnoDB;

CREATE TABLE `contrexx_access_user_title` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `order_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB;

CREATE TABLE `contrexx_access_user_validity` (
  `validity` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`validity`)
) ENGINE=InnoDB;

CREATE TABLE `contrexx_backend_areas` (
  `area_id` int(6) unsigned NOT NULL auto_increment,
  `parent_area_id` int(6) unsigned NOT NULL default '0',
  `type` enum('group','function','navigation') default 'navigation',
  `scope` enum('global','frontend','backend') NOT NULL default 'global',
  `area_name` varchar(100) default NULL,
  `is_active` tinyint(4) NOT NULL default '1',
  `uri` varchar(255) NOT NULL default '',
  `target` varchar(50) NOT NULL default '_self',
  `module_id` int(6) unsigned NOT NULL default '0',
  `order_id` int(6) unsigned NOT NULL default '0',
  `access_id` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`area_id`),
  KEY `area_name` (`area_name`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_backups` (
  `id` int(5) unsigned NOT NULL auto_increment,
  `date` varchar(14) NOT NULL default '',
  `version` varchar(20) NOT NULL default '',
  `edition` varchar(30) NOT NULL default '',
  `type` enum('sql','csv') NOT NULL default 'sql',
  `description` varchar(100) NOT NULL default '',
  `usedtables` text NOT NULL,
  `size` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `date` (`date`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_component` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `type` enum('core','core_module','module') NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB;

CREATE TABLE `contrexx_content_node` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) default NULL,
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `lvl` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `IDX_E5A18FDD727ACA70` (`parent_id`),
  CONSTRAINT `contrexx_content_node_ibfk_2` FOREIGN KEY (`parent_id`) REFERENCES `contrexx_content_node` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB;

CREATE TABLE `contrexx_content_page` (
  `id` int(11) NOT NULL auto_increment,
  `node_id` int(11) default NULL,
  `nodeIdShadowed` int(11) default NULL,
  `lang` int(11) NOT NULL,
  `type` varchar(16) NOT NULL,
  `caching` tinyint(1) NOT NULL,
  `updatedAt` timestamp NULL default NULL,
  `updatedBy` char(40) NOT NULL,
  `title` varchar(255) NOT NULL,
  `linkTarget` varchar(16) default NULL,
  `contentTitle` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `sourceMode` tinyint(1) NOT NULL default '0',
  `customContent` varchar(64) default NULL,
  `useCustomContentForAllChannels` int(2) default NULL,
  `cssName` varchar(255) default NULL,
  `cssNavName` varchar(255) default NULL,
  `skin` int(11) default NULL,
  `useSkinForAllChannels` int(2) default NULL,
  `metatitle` varchar(255) default NULL,
  `metadesc` text NOT NULL,
  `metakeys` text NOT NULL,
  `metarobots` varchar(7) default NULL,
  `start` timestamp NULL default NULL,
  `end` timestamp NULL default NULL,
  `editingStatus` varchar(16) NOT NULL,
  `protection` int(11) NOT NULL,
  `frontendAccessId` int(11) NOT NULL,
  `backendAccessId` int(11) NOT NULL,
  `display` tinyint(1) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `target` varchar(255) default NULL,
  `module` varchar(255) default NULL,
  `cmd` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `node_id` (`node_id`,`lang`),
  KEY `IDX_D8E86F54460D9FD7` (`node_id`),
  CONSTRAINT `contrexx_content_page_ibfk_3` FOREIGN KEY (`node_id`) REFERENCES `contrexx_content_node` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB;

CREATE TABLE `contrexx_core_country` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `alpha2` char(2) NOT NULL default '',
  `alpha3` char(3) NOT NULL default '',
  `ord` int(5) unsigned NOT NULL default '0',
  `active` tinyint(1) unsigned NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_core_mail_template` (
  `key` tinytext NOT NULL,
  `section` tinytext NOT NULL,
  `text_id` int(10) unsigned NOT NULL,
  `html` tinyint(1) unsigned NOT NULL default '0',
  `protected` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`key`(32),`section`(32))
) ENGINE=MyISAM;

CREATE TABLE `contrexx_core_setting` (
  `section` varchar(32) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `group` varchar(32) NOT NULL default '',
  `type` varchar(32) NOT NULL default 'text',
  `value` text NOT NULL,
  `values` text NOT NULL,
  `ord` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`section`,`name`,`group`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_core_text` (
  `id` int(10) unsigned NOT NULL default '0',
  `lang_id` int(10) unsigned NOT NULL default '1',
  `section` varchar(32) NOT NULL default '',
  `key` varchar(255) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY  (`id`,`lang_id`,`section`,`key`(32)),
  FULLTEXT KEY `text` (`text`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_ids` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `timestamp` int(14) default NULL,
  `type` varchar(100) NOT NULL default '',
  `remote_addr` varchar(15) default NULL,
  `http_x_forwarded_for` varchar(15) NOT NULL default '',
  `http_via` varchar(255) NOT NULL default '',
  `user` mediumtext ,
  `gpcs` mediumtext NOT NULL,
  `file` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_languages` (
  `id` int(2) unsigned NOT NULL auto_increment,
  `lang` varchar(5) NOT NULL default '',
  `name` varchar(250) NOT NULL default '',
  `charset` varchar(20) NOT NULL default 'iso-8859-1',
  `themesid` int(2) unsigned NOT NULL default '1',
  `print_themes_id` int(2) unsigned NOT NULL default '1',
  `pdf_themes_id` int(2) unsigned NOT NULL default '0',
  `frontend` tinyint(1) unsigned NOT NULL default '0',
  `backend` tinyint(1) unsigned NOT NULL default '0',
  `is_default` set('true','false') NOT NULL default 'false',
  `mobile_themes_id` int(2) unsigned NOT NULL default '0',
  `fallback` int(2) unsigned default '0',
  `app_themes_id` int(2) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `lang` (`lang`),
  KEY `defaultstatus` (`is_default`),
  KEY `name` (`name`),
  FULLTEXT KEY `name_2` (`name`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_lib_country` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(64) NOT NULL,
  `iso_code_2` char(2) NOT NULL,
  `iso_code_3` char(3) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `unique` (`iso_code_2`),
  KEY `INDEX_COUNTRIES_NAME` (`name`)
) ENGINE=InnoDB;

CREATE TABLE `contrexx_log` (
  `id` int(6) unsigned NOT NULL auto_increment,
  `userid` int(6) unsigned default NULL,
  `datetime` timestamp NULL default '0000-00-00 00:00:00',
  `useragent` varchar(250) default NULL,
  `userlanguage` varchar(250) default NULL,
  `remote_addr` varchar(250) default NULL,
  `remote_host` varchar(250) default NULL,
  `http_via` varchar(250) NOT NULL default '',
  `http_client_ip` varchar(250) NOT NULL default '',
  `http_x_forwarded_for` varchar(250) NOT NULL default '',
  `referer` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_log_entry` (
  `id` int(11) NOT NULL auto_increment,
  `action` varchar(8) NOT NULL,
  `logged_at` timestamp NULL default NULL,
  `version` int(11) NOT NULL,
  `object_id` varchar(32) default NULL,
  `object_class` varchar(255) NOT NULL,
  `data` longtext ,
  `username` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `log_class_unique_version_idx` (`version`,`object_id`,`object_class`),
  KEY `log_class_lookup_idx` (`object_class`),
  KEY `log_date_lookup_idx` (`logged_at`),
  KEY `log_user_lookup_idx` (`username`)
) ENGINE=InnoDB;

CREATE TABLE `contrexx_modules` (
  `id` int(2) unsigned default NULL,
  `name` varchar(250) NOT NULL default '',
  `distributor` char(50) NOT NULL,
  `description_variable` varchar(50) NOT NULL default '',
  `status` set('y','n') NOT NULL default 'n',
  `is_required` tinyint(1) NOT NULL default '0',
  `is_core` tinyint(4) NOT NULL default '0',
  `is_active` tinyint(1) NOT NULL default '0',
  `is_licensed` tinyint(1) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_block_blocks` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `start` int(10) NOT NULL default '0',
  `end` int(10) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `random` int(1) NOT NULL default '0',
  `random_2` int(1) NOT NULL default '0',
  `random_3` int(1) NOT NULL default '0',
  `random_4` int(1) NOT NULL default '0',
  `global` int(1) NOT NULL default '0',
  `category` int(1) NOT NULL default '0',
  `direct` int(1) NOT NULL default '0',
  `active` int(1) NOT NULL default '0',
  `order` int(1) NOT NULL default '0',
  `cat` int(10) NOT NULL default '0',
  `wysiwyg_editor` int(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_block_categories` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `parent` int(10) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `seperator` varchar(255) NOT NULL default '',
  `order` int(10) NOT NULL default '0',
  `status` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_block_rel_lang_content` (
  `block_id` int(10) unsigned NOT NULL default '0',
  `lang_id` int(10) unsigned NOT NULL default '0',
  `content` mediumtext NOT NULL,
  `active` int(1) NOT NULL default '0',
  UNIQUE KEY `id_lang` (`block_id`,`lang_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_block_rel_pages` (
  `block_id` int(7) NOT NULL default '0',
  `page_id` int(7) NOT NULL default '0',
  `placeholder` enum('global','direct','category') NOT NULL default 'global',
  PRIMARY KEY  (`block_id`,`page_id`,`placeholder`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_block_settings` (
  `id` int(7) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `value` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_blog_categories` (
  `category_id` int(4) unsigned NOT NULL default '0',
  `lang_id` int(2) unsigned NOT NULL default '0',
  `is_active` enum('0','1') NOT NULL default '1',
  `name` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`category_id`,`lang_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_blog_comments` (
  `comment_id` int(7) unsigned NOT NULL auto_increment,
  `message_id` int(6) unsigned NOT NULL default '0',
  `lang_id` int(2) unsigned NOT NULL default '0',
  `is_active` enum('0','1') NOT NULL default '1',
  `time_created` int(14) unsigned NOT NULL default '0',
  `ip_address` varchar(15) NOT NULL default '0.0.0.0',
  `user_id` int(5) unsigned NOT NULL default '0',
  `user_name` varchar(50) default NULL,
  `user_mail` varchar(250) default NULL,
  `user_www` varchar(255) default NULL,
  `subject` varchar(250) NOT NULL default '',
  `comment` text NOT NULL,
  PRIMARY KEY  (`comment_id`),
  KEY `message_id` (`message_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_blog_messages` (
  `message_id` int(6) unsigned NOT NULL auto_increment,
  `user_id` int(5) unsigned NOT NULL default '0',
  `time_created` int(14) unsigned NOT NULL default '0',
  `time_edited` int(14) unsigned NOT NULL default '0',
  `hits` int(7) unsigned NOT NULL default '0',
  PRIMARY KEY  (`message_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_blog_messages_lang` (
  `message_id` int(6) unsigned NOT NULL,
  `lang_id` int(2) unsigned NOT NULL,
  `is_active` enum('0','1') NOT NULL default '1',
  `subject` varchar(250) NOT NULL default '',
  `content` text NOT NULL,
  `tags` varchar(250) NOT NULL default '',
  `image` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`message_id`,`lang_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_blog_message_to_category` (
  `message_id` int(6) unsigned NOT NULL default '0',
  `category_id` int(4) unsigned NOT NULL default '0',
  `lang_id` int(2) unsigned NOT NULL default '0',
  PRIMARY KEY  (`message_id`,`category_id`,`lang_id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_blog_networks` (
  `network_id` int(8) unsigned NOT NULL auto_increment,
  `name` varchar(250) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  `url_link` varchar(255) NOT NULL default '',
  `icon` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`network_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_blog_networks_lang` (
  `network_id` int(8) unsigned NOT NULL default '0',
  `lang_id` int(2) unsigned NOT NULL default '0',
  PRIMARY KEY  (`network_id`,`lang_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_blog_settings` (
  `name` varchar(50) NOT NULL,
  `value` varchar(250) NOT NULL,
  PRIMARY KEY  (`name`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_blog_votes` (
  `vote_id` int(8) unsigned NOT NULL auto_increment,
  `message_id` int(6) unsigned NOT NULL default '0',
  `time_voted` int(14) unsigned NOT NULL default '0',
  `ip_address` varchar(15) NOT NULL default '0.0.0.0',
  `vote` enum('1','2','3','4','5','6','7','8','9','10') NOT NULL default '1',
  PRIMARY KEY  (`vote_id`),
  KEY `message_id` (`message_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_calendar_category` (
  `id` int(5) NOT NULL auto_increment,
  `pos` int(5) default NULL,
  `status` int(1) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_calendar_category_name` (
  `cat_id` int(11) NOT NULL,
  `lang_id` int(11) default NULL,
  `name` varchar(225) default NULL,
  KEY `fk_contrexx_module_calendar_category_names_contrexx_module_ca1` (`cat_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_calendar_event` (
  `id` int(11) NOT NULL auto_increment,
  `type` int(11) NOT NULL default '0',
  `startdate` timestamp NOT NULL default '0000-00-00 00:00:00',
  `enddate` timestamp NOT NULL default '0000-00-00 00:00:00',
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
  `access` int(1) NOT NULL default '0',
  `priority` int(1) NOT NULL default '3',
  `price` int(11) NOT NULL default '0',
  `link` varchar(255) NOT NULL,
  `pic` varchar(255) NOT NULL default '',
  `attach` varchar(255) NOT NULL,
  `place_mediadir_id` int(11) NOT NULL,
  `catid` int(11) NOT NULL default '0',
  `show_in` varchar(255) NOT NULL,
  `invited_groups` varchar(45) default NULL,
  `invited_mails` mediumtext ,
  `invitation_sent` int(1) NOT NULL,
  `invitation_email_template` varchar(255) NOT NULL,
  `registration` int(1) NOT NULL default '0',
  `registration_form` int(11) NOT NULL,
  `registration_num` varchar(45) default NULL,
  `registration_notification` varchar(1024) default NULL,
  `email_template` varchar(255) NOT NULL,
  `ticket_sales` tinyint(1) NOT NULL default '0',
  `num_seating` text NOT NULL,
  `series_status` tinyint(4) NOT NULL default '0',
  `series_type` int(11) NOT NULL default '0',
  `series_pattern_count` int(11) NOT NULL default '0',
  `series_pattern_weekday` varchar(7) NOT NULL,
  `series_pattern_day` int(11) NOT NULL default '0',
  `series_pattern_week` int(11) NOT NULL default '0',
  `series_pattern_month` int(11) NOT NULL default '0',
  `series_pattern_type` int(11) NOT NULL default '0',
  `series_pattern_dourance_type` int(11) NOT NULL default '0',
  `series_pattern_end` int(11) NOT NULL default '0',
  `series_pattern_end_date` timestamp NOT NULL default '0000-00-00 00:00:00',
  `series_pattern_begin` int(11) NOT NULL default '0',
  `series_pattern_exceptions` longtext NOT NULL,
  `status` tinyint(1) NOT NULL default '1',
  `confirmed` tinyint(1) NOT NULL default '1',
  `author` varchar(255) NOT NULL,
  `all_day` tinyint(1) NOT NULL default '0',
  `location_type` tinyint(1) NOT NULL default '1',
  `place` varchar(255) NOT NULL,
  `place_id` int(11) NOT NULL,
  `place_street` varchar(255) default NULL,
  `place_zip` varchar(10) default NULL,
  `place_city` varchar(255) default NULL,
  `place_country` varchar(255) default NULL,
  `place_link` varchar(255) NOT NULL,
  `place_map` varchar(255) NOT NULL,
  `host_type` tinyint(1) NOT NULL default '1',
  `org_name` varchar(255) NOT NULL,
  `org_street` varchar(255) NOT NULL,
  `org_zip` varchar(10) NOT NULL,
  `org_city` varchar(255) NOT NULL,
  `org_country` varchar(255) NOT NULL,
  `org_link` varchar(255) NOT NULL,
  `org_email` varchar(255) NOT NULL,
  `host_mediadir_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `fk_contrexx_module_calendar_notes_contrexx_module_calendar_ca1` (`catid`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_calendar_event_field` (
  `event_id` int(11) NOT NULL default '0',
  `lang_id` varchar(225) default NULL,
  `title` varchar(255) default NULL,
  `description` mediumtext ,
  `redirect` varchar(255) NOT NULL,
  KEY `lang_field` (`title`),
  KEY `fk_contrexx_module_calendar_note_field_contrexx_module_calend1` (`event_id`),
  FULLTEXT KEY `eventIndex` (`title`,`description`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_calendar_host` (
  `id` int(1) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `uri` mediumtext NOT NULL,
  `cat_id` int(11) NOT NULL,
  `key` varchar(40) NOT NULL,
  `confirmed` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `fk_contrexx_module_calendar_shared_hosts_contrexx_module_cale1` (`cat_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_calendar_mail` (
  `id` int(7) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `content_text` longtext NOT NULL,
  `content_html` longtext NOT NULL,
  `recipients` mediumtext NOT NULL,
  `lang_id` int(1) NOT NULL,
  `action_id` int(1) NOT NULL,
  `is_default` int(1) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_calendar_mail_action` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `default_recipient` enum('empty','admin','author') NOT NULL,
  `need_auth` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_calendar_registration` (
  `id` int(7) NOT NULL auto_increment,
  `event_id` int(7) NOT NULL,
  `date` int(15) NOT NULL,
  `host_name` varchar(255) NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `type` int(1) NOT NULL,
  `key` varchar(45) NOT NULL,
  `user_id` int(7) NOT NULL,
  `lang_id` int(11) NOT NULL,
  `export` int(11) NOT NULL,
  `payment_method` int(11) NOT NULL,
  `paid` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_calendar_registration_form` (
  `id` int(11) NOT NULL auto_increment,
  `status` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_calendar_registration_form_field` (
  `id` int(7) NOT NULL auto_increment,
  `form` int(11) NOT NULL,
  `type` enum('inputtext','textarea','select','radio','checkbox','mail','seating','agb','salutation','firstname','lastname','selectBillingAddress','fieldset') NOT NULL,
  `required` int(1) NOT NULL,
  `order` int(3) NOT NULL,
  `affiliation` varchar(45) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_calendar_registration_form_field_name` (
  `field_id` int(7) NOT NULL,
  `form_id` int(11) NOT NULL,
  `lang_id` int(1) NOT NULL,
  `name` varchar(255) NOT NULL,
  `default` mediumtext NOT NULL
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_calendar_registration_form_field_value` (
  `reg_id` int(7) NOT NULL,
  `field_id` int(7) NOT NULL,
  `value` mediumtext NOT NULL
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_calendar_rel_event_host` (
  `host_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_calendar_settings` (
  `id` int(7) NOT NULL auto_increment,
  `section_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `info` mediumtext NOT NULL,
  `type` int(11) NOT NULL,
  `options` mediumtext NOT NULL,
  `special` varchar(255) NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_calendar_settings_section` (
  `id` int(11) NOT NULL auto_increment,
  `parent` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_calendar_style` (
  `id` int(11) NOT NULL auto_increment,
  `tableWidth` varchar(4) NOT NULL default '141',
  `tableHeight` varchar(4) NOT NULL default '92',
  `tableColor` varchar(7) NOT NULL default '',
  `tableBorder` int(11) NOT NULL default '0',
  `tableBorderColor` varchar(7) NOT NULL default '',
  `tableSpacing` int(11) NOT NULL default '0',
  `fontSize` int(11) NOT NULL default '10',
  `fontColor` varchar(7) NOT NULL default '',
  `numColor` varchar(7) NOT NULL default '',
  `normalDayColor` varchar(7) NOT NULL default '',
  `normalDayRollOverColor` varchar(7) NOT NULL default '',
  `curDayColor` varchar(7) NOT NULL default '',
  `curDayRollOverColor` varchar(7) NOT NULL default '',
  `eventDayColor` varchar(7) NOT NULL default '',
  `eventDayRollOverColor` varchar(7) NOT NULL default '',
  `shownEvents` int(4) NOT NULL default '10',
  `periodTime` varchar(5) NOT NULL default '00 23',
  `stdCat` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_checkout_settings_general` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `value` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_checkout_settings_mails` (
  `id` int(11) NOT NULL auto_increment,
  `title` text NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_checkout_settings_yellowpay` (
  `id` int(11) NOT NULL auto_increment,
  `name` text NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_checkout_transactions` (
  `id` int(11) NOT NULL auto_increment,
  `time` int(10) NOT NULL default '0',
  `status` enum('confirmed','waiting','cancelled') NOT NULL,
  `invoice_number` varchar(255) NOT NULL,
  `invoice_currency` int(11) NOT NULL default '1',
  `invoice_amount` int(15) NOT NULL,
  `contact_title` enum('mister','miss') NOT NULL,
  `contact_forename` varchar(255) NOT NULL default '',
  `contact_surname` varchar(255) NOT NULL default '',
  `contact_company` varchar(255) NOT NULL default '',
  `contact_street` varchar(255) NOT NULL default '',
  `contact_postcode` varchar(255) NOT NULL default '',
  `contact_place` varchar(255) NOT NULL default '',
  `contact_country` int(11) NOT NULL default '204',
  `contact_phone` varchar(255) NOT NULL default '',
  `contact_email` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_contact_form` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `mails` text NOT NULL,
  `showForm` tinyint(1) unsigned NOT NULL default '0',
  `use_captcha` tinyint(1) unsigned NOT NULL default '1',
  `use_custom_style` tinyint(1) unsigned NOT NULL default '0',
  `save_data_in_crm` tinyint(1) NOT NULL default '0',
  `send_copy` tinyint(1) NOT NULL default '0',
  `use_email_of_sender` tinyint(1) NOT NULL default '0',
  `html_mail` tinyint(1) unsigned NOT NULL default '1',
  `send_attachment` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_contact_form_data` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `id_form` int(10) unsigned NOT NULL default '0',
  `id_lang` int(10) unsigned NOT NULL default '1',
  `time` int(14) unsigned NOT NULL default '0',
  `host` varchar(255) NOT NULL default '',
  `lang` varchar(64) NOT NULL default '',
  `browser` varchar(255) NOT NULL default '',
  `ipaddress` varchar(15) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_contact_form_field` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `id_form` int(10) unsigned NOT NULL default '0',
  `type` enum('text','label','checkbox','checkboxGroup','country','date','file','multi_file','fieldset','hidden','horizontalLine','password','radio','select','textarea','recipient','special','datetime') NOT NULL default 'text',
  `special_type` varchar(20) NOT NULL,
  `is_required` set('0','1') NOT NULL default '0',
  `check_type` int(3) NOT NULL default '1',
  `order_id` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_contact_form_field_lang` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `fieldID` int(10) unsigned NOT NULL,
  `langID` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `attributes` text NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `fieldID` (`fieldID`,`langID`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_contact_form_lang` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `formID` int(10) unsigned NOT NULL,
  `langID` int(10) unsigned NOT NULL,
  `is_active` tinyint(1) unsigned NOT NULL default '1',
  `name` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `feedback` text NOT NULL,
  `mailTemplate` text NOT NULL,
  `subject` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `formID` (`formID`,`langID`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_contact_form_submit_data` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `id_entry` int(10) unsigned NOT NULL,
  `id_field` int(10) unsigned NOT NULL,
  `formlabel` text NOT NULL,
  `formvalue` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_contact_recipient` (
  `id` int(11) NOT NULL auto_increment,
  `id_form` int(11) NOT NULL default '0',
  `email` varchar(250) NOT NULL default '',
  `sort` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_contact_recipient_lang` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `recipient_id` int(10) unsigned NOT NULL,
  `langID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `recipient_id` (`recipient_id`,`langID`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_contact_settings` (
  `setid` int(6) unsigned NOT NULL auto_increment,
  `setname` varchar(250) NOT NULL default '',
  `setvalue` text NOT NULL,
  `status` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`setid`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_crm_contacts` (
  `id` int(11) NOT NULL auto_increment,
  `customer_id` varchar(256) default NULL,
  `customer_type` int(11) default NULL,
  `customer_name` varchar(256) default NULL,
  `customer_website` varchar(256) default NULL,
  `customer_addedby` int(11) default NULL,
  `customer_currency` int(11) default NULL,
  `contact_familyname` varchar(256) default NULL,
  `contact_role` varchar(256) default NULL,
  `contact_customer` int(11) default NULL,
  `contact_language` int(11) default NULL,
  `gender` tinyint(2) NOT NULL,
  `notes` text ,
  `industry_type` int(11) default NULL,
  `contact_type` tinyint(2) default NULL,
  `user_account` int(11) default NULL,
  `datasource` int(11) default NULL,
  `profile_picture` varchar(256) NOT NULL,
  `status` tinyint(2) NOT NULL default '1',
  `added_date` date NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `contact_customer` (`contact_customer`),
  KEY `customer_id` (`customer_id`),
  KEY `customer_name` (`customer_name`),
  KEY `contact_familyname` (`contact_familyname`),
  KEY `contact_role` (`contact_role`),
  FULLTEXT KEY `customer_id_2` (`customer_id`,`customer_name`,`contact_familyname`,`contact_role`,`notes`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_crm_currency` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(400) NOT NULL,
  `active` int(1) NOT NULL default '1',
  `pos` int(5) NOT NULL default '0',
  `hourly_rate` text NOT NULL,
  `default_currency` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`(333)),
  FULLTEXT KEY `name_2` (`name`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_crm_customer_comment` (
  `id` int(11) NOT NULL auto_increment,
  `customer_id` int(11) default NULL,
  `notes_type_id` int(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `comment` text ,
  `added_date` datetime default NULL,
  `updated_by` int(11) default NULL,
  `updated_on` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `customer_id` (`customer_id`),
  FULLTEXT KEY `comment` (`comment`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_crm_customer_contact_address` (
  `id` int(11) NOT NULL auto_increment,
  `address` varchar(256) NOT NULL,
  `city` varchar(256) NOT NULL,
  `state` varchar(256) NOT NULL,
  `zip` varchar(256) NOT NULL,
  `country` varchar(256) NOT NULL,
  `Address_Type` tinyint(4) NOT NULL,
  `is_primary` enum('0','1') NOT NULL,
  `contact_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `contact_id` (`contact_id`),
  KEY `address` (`address`),
  KEY `city` (`city`),
  KEY `state` (`state`),
  KEY `zip` (`zip`),
  KEY `country` (`country`),
  FULLTEXT KEY `address_2` (`address`,`city`,`state`,`zip`,`country`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_crm_customer_contact_emails` (
  `id` int(11) NOT NULL auto_increment,
  `email` varchar(256) NOT NULL,
  `email_type` tinyint(4) NOT NULL,
  `is_primary` enum('0','1') default '0',
  `contact_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `contact_id` (`contact_id`),
  KEY `email` (`email`),
  FULLTEXT KEY `email_2` (`email`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_crm_customer_contact_phone` (
  `id` int(11) NOT NULL auto_increment,
  `phone` varchar(256) NOT NULL,
  `phone_type` tinyint(4) NOT NULL,
  `is_primary` enum('0','1') default '0',
  `contact_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `contact_id` (`contact_id`),
  KEY `phone` (`phone`),
  FULLTEXT KEY `phone_2` (`phone`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_crm_customer_contact_social_network` (
  `id` int(11) NOT NULL auto_increment,
  `url` varchar(256) NOT NULL,
  `url_profile` tinyint(4) NOT NULL,
  `is_primary` enum('0','1') default '0',
  `contact_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `contact_id` (`contact_id`),
  KEY `url` (`url`),
  FULLTEXT KEY `url_2` (`url`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_crm_customer_contact_websites` (
  `id` int(11) NOT NULL auto_increment,
  `url` varchar(256) NOT NULL,
  `url_type` tinyint(4) NOT NULL,
  `url_profile` tinyint(4) NOT NULL,
  `is_primary` enum('0','1') default '0',
  `contact_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `contact_id` (`contact_id`),
  KEY `url` (`url`),
  FULLTEXT KEY `url_2` (`url`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_crm_customer_documents` (
  `id` int(11) NOT NULL auto_increment,
  `document_name` varchar(256) NOT NULL,
  `added_by` int(11) NOT NULL,
  `uploaded_date` datetime NOT NULL,
  `contact_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `contact_id` (`contact_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_crm_customer_membership` (
  `contact_id` int(11) NOT NULL,
  `membership_id` int(11) NOT NULL
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_crm_customer_types` (
  `id` int(11) NOT NULL auto_increment,
  `label` varchar(250) NOT NULL,
  `hourly_rate` varchar(256) NOT NULL,
  `active` int(1) NOT NULL,
  `pos` int(10) NOT NULL default '0',
  `default` tinyint(2) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `label` (`label`),
  FULLTEXT KEY `label_2` (`label`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_crm_datasources` (
  `id` int(11) NOT NULL auto_increment,
  `datasource` varchar(256) NOT NULL,
  `status` tinyint(2) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_crm_deals` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(256) NOT NULL,
  `website` int(11) NOT NULL,
  `customer` int(11) NOT NULL,
  `customer_contact` int(11) NOT NULL,
  `quoted_price` decimal(10,2) NOT NULL default '0.00',
  `quote_number` varchar(256) NOT NULL,
  `assigned_to` int(11) NOT NULL,
  `due_date` date default NULL,
  `stage` int(11) NOT NULL,
  `description` text NOT NULL,
  `project_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `customer` (`customer`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_crm_industry_types` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL,
  `sorting` int(11) NOT NULL,
  `status` smallint(2) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_crm_industry_type_local` (
  `entry_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL,
  `value` varchar(256) NOT NULL,
  KEY `entry_id` (`entry_id`),
  KEY `value` (`value`),
  FULLTEXT KEY `value_2` (`value`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_crm_memberships` (
  `id` int(11) NOT NULL auto_increment,
  `sorting` int(11) NOT NULL,
  `status` smallint(2) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_crm_membership_local` (
  `entry_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL,
  `value` varchar(256) NOT NULL,
  KEY `entry_id` (`entry_id`),
  KEY `value` (`value`),
  FULLTEXT KEY `value_2` (`value`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_crm_notes` (
  `id` int(1) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `pos` int(1) NOT NULL,
  `system_defined` tinyint(2) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `name` (`name`),
  FULLTEXT KEY `name_2` (`name`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_crm_settings` (
  `setid` int(7) NOT NULL auto_increment,
  `setname` varchar(255) NOT NULL,
  `setvalue` text NOT NULL,
  PRIMARY KEY  (`setid`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_crm_stages` (
  `id` int(11) NOT NULL auto_increment,
  `label` varchar(256) NOT NULL,
  `stage` varchar(256) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `sorting` int(4) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_crm_success_rate` (
  `id` int(11) NOT NULL auto_increment,
  `label` varchar(256) NOT NULL,
  `rate` varchar(256) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `sorting` int(4) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_crm_task` (
  `id` int(2) NOT NULL auto_increment,
  `task_id` varchar(10) NOT NULL,
  `task_title` varchar(255) NOT NULL,
  `task_type_id` int(2) NOT NULL,
  `customer_id` int(2) NOT NULL,
  `due_date` datetime NOT NULL,
  `assigned_to` int(11) NOT NULL,
  `description` text NOT NULL,
  `task_status` tinyint(1) NOT NULL default '1',
  `added_by` int(11) NOT NULL,
  `added_date_time` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_crm_task_types` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(256) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `sorting` int(11) NOT NULL,
  `description` text NOT NULL,
  `icon` varchar(255) NOT NULL,
  `system_defined` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`),
  FULLTEXT KEY `name_2` (`name`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_data_categories` (
  `category_id` int(4) unsigned NOT NULL default '0',
  `lang_id` int(2) unsigned NOT NULL default '0',
  `is_active` enum('0','1') NOT NULL default '1',
  `parent_id` int(10) unsigned NOT NULL default '0',
  `name` varchar(100) NOT NULL default '',
  `active` enum('0','1') NOT NULL default '1',
  `cmd` int(10) unsigned NOT NULL default '1',
  `action` enum('content','overlaybox','subcategories') NOT NULL default 'content',
  `sort` int(10) unsigned NOT NULL default '1',
  `box_height` int(10) unsigned NOT NULL default '500',
  `box_width` int(11) NOT NULL default '350',
  `template` text NOT NULL,
  PRIMARY KEY  (`category_id`,`lang_id`)
) ENGINE=InnoDB;

CREATE TABLE `contrexx_module_data_messages` (
  `message_id` int(6) unsigned NOT NULL auto_increment,
  `user_id` int(5) unsigned NOT NULL default '0',
  `time_created` int(14) unsigned NOT NULL default '0',
  `time_edited` int(14) unsigned NOT NULL default '0',
  `hits` int(7) unsigned NOT NULL default '0',
  `active` enum('0','1') NOT NULL default '1',
  `sort` int(10) unsigned NOT NULL default '1',
  `mode` set('normal','forward') NOT NULL default 'normal',
  `release_time` int(15) NOT NULL default '0',
  `release_time_end` int(15) NOT NULL default '0',
  PRIMARY KEY  (`message_id`)
) ENGINE=InnoDB;

CREATE TABLE `contrexx_module_data_messages_lang` (
  `message_id` int(6) unsigned NOT NULL default '0',
  `lang_id` int(2) unsigned NOT NULL default '0',
  `is_active` enum('0','1') NOT NULL default '1',
  `subject` varchar(250) NOT NULL default '',
  `content` text NOT NULL,
  `tags` varchar(250) NOT NULL default '',
  `image` varchar(250) NOT NULL default '',
  `thumbnail` varchar(250) NOT NULL,
  `thumbnail_type` enum('original','thumbnail') NOT NULL default 'original',
  `thumbnail_width` tinyint(3) unsigned NOT NULL default '0',
  `thumbnail_height` tinyint(3) unsigned NOT NULL default '0',
  `attachment` varchar(255) NOT NULL default '',
  `attachment_description` varchar(255) NOT NULL default '',
  `mode` set('normal','forward') NOT NULL default 'normal',
  `forward_url` varchar(255) NOT NULL default '',
  `forward_target` varchar(40) default NULL,
  PRIMARY KEY  (`message_id`,`lang_id`)
) ENGINE=InnoDB;

CREATE TABLE `contrexx_module_data_message_to_category` (
  `message_id` int(6) unsigned NOT NULL default '0',
  `category_id` int(4) unsigned NOT NULL default '0',
  `lang_id` int(2) unsigned NOT NULL default '0',
  PRIMARY KEY  (`message_id`,`category_id`,`lang_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB;

CREATE TABLE `contrexx_module_data_placeholders` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `type` set('cat','entry') NOT NULL default '',
  `ref_id` int(11) NOT NULL default '0',
  `placeholder` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `placeholder` (`placeholder`),
  UNIQUE KEY `type` (`type`,`ref_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_data_settings` (
  `name` varchar(50) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`name`)
) ENGINE=InnoDB;

CREATE TABLE `contrexx_module_directory_categories` (
  `id` int(6) unsigned NOT NULL auto_increment,
  `parentid` int(6) unsigned NOT NULL default '0',
  `name` varchar(100) NOT NULL default '',
  `description` varchar(250) NOT NULL default '',
  `displayorder` smallint(6) unsigned NOT NULL default '1000',
  `metadesc` varchar(250) NOT NULL default '',
  `metakeys` varchar(250) NOT NULL default '',
  `showentries` int(1) NOT NULL default '1',
  `status` int(1) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `name` (`name`),
  KEY `parentid` (`parentid`),
  KEY `displayorder` (`displayorder`),
  KEY `status` (`status`),
  FULLTEXT KEY `directoryindex` (`name`,`description`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_directory_dir` (
  `id` int(7) unsigned NOT NULL auto_increment,
  `title` varchar(100) NOT NULL default '',
  `attachment` varchar(255) NOT NULL default '',
  `rss_file` varchar(255) NOT NULL default '',
  `rss_link` varchar(255) NOT NULL default '',
  `link` varchar(255) NOT NULL default '',
  `date` varchar(14) default NULL,
  `description` mediumtext NOT NULL,
  `platform` varchar(40) NOT NULL default '',
  `language` varchar(40) NOT NULL default '',
  `relatedlinks` varchar(255) NOT NULL default '',
  `hits` int(9) NOT NULL default '0',
  `status` tinyint(1) NOT NULL default '0',
  `addedby` varchar(50) NOT NULL default '',
  `provider` varchar(255) NOT NULL default '',
  `ip` varchar(255) NOT NULL default '',
  `validatedate` varchar(14) NOT NULL default '',
  `lastip` varchar(50) NOT NULL default '',
  `popular_date` varchar(30) NOT NULL default '',
  `popular_hits` int(7) NOT NULL default '0',
  `xml_refresh` varchar(15) NOT NULL default '',
  `canton` varchar(50) NOT NULL default '',
  `searchkeys` varchar(255) NOT NULL default '',
  `company_name` varchar(100) NOT NULL default '',
  `street` varchar(255) NOT NULL default '',
  `zip` varchar(5) NOT NULL default '',
  `city` varchar(50) NOT NULL default '',
  `country` varchar(255) NOT NULL default '',
  `phone` varchar(20) NOT NULL default '',
  `contact` varchar(100) NOT NULL default '',
  `information` varchar(100) NOT NULL default '',
  `fax` varchar(20) NOT NULL default '',
  `mobile` varchar(20) NOT NULL default '',
  `mail` varchar(50) NOT NULL default '',
  `homepage` varchar(50) NOT NULL default '',
  `industry` varchar(100) NOT NULL default '',
  `legalform` varchar(50) NOT NULL default '',
  `conversion` varchar(50) NOT NULL default '',
  `employee` varchar(255) NOT NULL default '',
  `foundation` varchar(10) NOT NULL default '',
  `mwst` varchar(50) NOT NULL default '',
  `opening` varchar(255) NOT NULL default '',
  `holidays` varchar(255) NOT NULL default '',
  `places` varchar(255) NOT NULL default '',
  `logo` varchar(50) default NULL,
  `team` varchar(255) NOT NULL default '',
  `portfolio` varchar(255) NOT NULL default '',
  `offers` varchar(255) NOT NULL default '',
  `concept` varchar(255) NOT NULL default '',
  `map` varchar(255) default NULL,
  `lokal` varchar(255) default NULL,
  `spezial` int(4) NOT NULL default '0',
  `premium` int(1) NOT NULL default '0',
  `longitude` decimal(18,15) NOT NULL default '0.000000000000000',
  `latitude` decimal(18,15) NOT NULL default '0.000000000000000',
  `zoom` decimal(18,15) NOT NULL default '1.000000000000000',
  `spez_field_1` varchar(255) NOT NULL default '',
  `spez_field_2` varchar(255) NOT NULL default '',
  `spez_field_3` varchar(255) NOT NULL default '',
  `spez_field_4` varchar(255) NOT NULL default '',
  `spez_field_5` varchar(255) NOT NULL default '',
  `spez_field_6` mediumtext NOT NULL,
  `spez_field_7` mediumtext NOT NULL,
  `spez_field_8` mediumtext NOT NULL,
  `spez_field_9` mediumtext NOT NULL,
  `spez_field_10` mediumtext NOT NULL,
  `spez_field_11` varchar(255) default NULL,
  `spez_field_12` varchar(255) default NULL,
  `spez_field_13` varchar(255) default NULL,
  `spez_field_14` varchar(255) default NULL,
  `spez_field_15` varchar(255) default NULL,
  `spez_field_21` varchar(255) NOT NULL default '',
  `spez_field_22` varchar(255) NOT NULL default '',
  `spez_field_16` varchar(255) default NULL,
  `spez_field_17` varchar(255) default NULL,
  `spez_field_18` varchar(255) default NULL,
  `spez_field_19` varchar(255) default NULL,
  `spez_field_20` varchar(255) default NULL,
  `spez_field_23` varchar(255) NOT NULL default '',
  `spez_field_24` varchar(255) NOT NULL default '',
  `spez_field_25` varchar(255) NOT NULL default '',
  `spez_field_26` varchar(255) NOT NULL default '',
  `spez_field_27` varchar(255) NOT NULL default '',
  `spez_field_28` varchar(255) NOT NULL default '',
  `spez_field_29` varchar(255) NOT NULL default '',
  `youtube` mediumtext NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `date` (`date`),
  KEY `temphitsout` (`hits`),
  KEY `status` (`status`),
  FULLTEXT KEY `name` (`title`,`description`),
  FULLTEXT KEY `description` (`description`),
  FULLTEXT KEY `title` (`title`,`description`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_directory_inputfields` (
  `id` int(7) NOT NULL auto_increment,
  `typ` int(2) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `active` int(1) NOT NULL default '0',
  `active_backend` int(1) NOT NULL default '0',
  `is_required` int(11) NOT NULL default '0',
  `read_only` int(1) NOT NULL default '0',
  `sort` int(5) NOT NULL default '0',
  `exp_search` int(1) NOT NULL default '0',
  `is_search` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_directory_levels` (
  `id` int(7) NOT NULL auto_increment,
  `parentid` int(7) NOT NULL default '0',
  `name` varchar(100) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  `metadesc` varchar(100) NOT NULL default '',
  `metakeys` varchar(100) NOT NULL default '',
  `displayorder` int(7) NOT NULL default '0',
  `showlevels` int(1) NOT NULL default '0',
  `showcategories` int(1) NOT NULL default '0',
  `onlyentries` int(1) NOT NULL default '0',
  `status` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `displayorder` (`displayorder`),
  KEY `parentid` (`parentid`),
  KEY `name` (`name`),
  KEY `status` (`status`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_directory_mail` (
  `id` tinyint(4) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `content` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_directory_rel_dir_cat` (
  `dir_id` int(7) NOT NULL default '0',
  `cat_id` int(7) NOT NULL default '0',
  PRIMARY KEY  (`dir_id`,`cat_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_directory_rel_dir_level` (
  `dir_id` int(7) NOT NULL default '0',
  `level_id` int(7) NOT NULL default '0',
  PRIMARY KEY  (`dir_id`,`level_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_directory_settings` (
  `setid` int(6) unsigned NOT NULL auto_increment,
  `setname` varchar(250) NOT NULL default '',
  `setvalue` text NOT NULL,
  `settyp` int(1) NOT NULL default '0',
  PRIMARY KEY  (`setid`),
  KEY `setname` (`setname`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_directory_settings_google` (
  `setid` int(6) unsigned NOT NULL auto_increment,
  `setname` varchar(250) NOT NULL default '',
  `setvalue` text NOT NULL,
  `settyp` int(1) NOT NULL default '0',
  PRIMARY KEY  (`setid`),
  KEY `setname` (`setname`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_directory_vote` (
  `id` int(7) NOT NULL auto_increment,
  `feed_id` int(7) NOT NULL default '0',
  `vote` int(2) NOT NULL default '0',
  `count` int(7) NOT NULL default '0',
  `client` varchar(255) NOT NULL default '',
  `time` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_docsys` (
  `id` int(6) unsigned NOT NULL auto_increment,
  `date` int(14) default NULL,
  `title` varchar(250) NOT NULL default '',
  `author` varchar(150) NOT NULL default '',
  `text` mediumtext NOT NULL,
  `source` varchar(250) NOT NULL default '',
  `url1` varchar(250) NOT NULL default '',
  `url2` varchar(250) NOT NULL default '',
  `lang` int(2) unsigned NOT NULL default '0',
  `userid` int(6) unsigned NOT NULL default '0',
  `startdate` int(14) unsigned NOT NULL default '0',
  `enddate` int(14) unsigned NOT NULL default '0',
  `status` tinyint(4) NOT NULL default '1',
  `changelog` int(14) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  FULLTEXT KEY `newsindex` (`title`,`text`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_docsys_categories` (
  `catid` int(2) unsigned NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `lang` int(2) unsigned NOT NULL default '1',
  `sort_style` enum('alpha','date','date_alpha') NOT NULL default 'alpha',
  PRIMARY KEY  (`catid`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_docsys_entry_category` (
  `entry` int(10) unsigned NOT NULL default '0',
  `category` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`entry`,`category`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_downloads_category` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `parent_id` int(11) unsigned NOT NULL default '0',
  `is_active` tinyint(1) unsigned NOT NULL default '1',
  `visibility` tinyint(1) unsigned NOT NULL default '1',
  `owner_id` int(5) unsigned NOT NULL default '0',
  `order` int(3) unsigned NOT NULL default '0',
  `deletable_by_owner` tinyint(1) unsigned NOT NULL default '1',
  `modify_access_by_owner` tinyint(1) unsigned NOT NULL default '1',
  `read_access_id` int(11) unsigned NOT NULL default '0',
  `add_subcategories_access_id` int(11) unsigned NOT NULL default '0',
  `manage_subcategories_access_id` int(11) unsigned NOT NULL default '0',
  `add_files_access_id` int(11) unsigned NOT NULL default '0',
  `manage_files_access_id` int(11) unsigned NOT NULL default '0',
  `image` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `is_active` (`is_active`),
  KEY `visibility` (`visibility`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_downloads_category_locale` (
  `lang_id` int(11) unsigned NOT NULL default '0',
  `category_id` int(11) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `description` text NOT NULL,
  PRIMARY KEY  (`lang_id`,`category_id`),
  FULLTEXT KEY `name` (`name`),
  FULLTEXT KEY `description` (`description`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_downloads_download` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `type` enum('file','url') NOT NULL default 'file',
  `mime_type` enum('image','document','pdf','media','archive','application','link') NOT NULL default 'image',
  `icon` enum('_blank','avi','bmp','css','doc','dot','exe','fla','gif','htm','html','inc','jpg','js','mp3','nfo','pdf','php','png','pps','ppt','rar','swf','txt','wma','xls','zip') NOT NULL default '_blank',
  `size` int(10) unsigned NOT NULL default '0',
  `image` varchar(255) NOT NULL default '',
  `owner_id` int(5) unsigned NOT NULL default '0',
  `access_id` int(10) unsigned NOT NULL default '0',
  `license` varchar(255) NOT NULL default '',
  `version` varchar(10) NOT NULL default '',
  `author` varchar(100) NOT NULL default '',
  `website` varchar(255) NOT NULL default '',
  `ctime` int(14) unsigned NOT NULL default '0',
  `mtime` int(14) unsigned NOT NULL default '0',
  `is_active` tinyint(3) unsigned NOT NULL default '0',
  `visibility` tinyint(1) unsigned NOT NULL default '1',
  `order` int(3) unsigned NOT NULL default '0',
  `views` int(10) unsigned NOT NULL default '0',
  `download_count` int(10) unsigned NOT NULL default '0',
  `expiration` int(14) unsigned NOT NULL default '0',
  `validity` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `is_active` (`is_active`),
  KEY `visibility` (`visibility`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_downloads_download_locale` (
  `lang_id` int(11) unsigned NOT NULL default '0',
  `download_id` int(11) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `source` varchar(1024) default NULL,
  `source_name` varchar(1024) default NULL,
  `description` text NOT NULL,
  `metakeys` text NOT NULL,
  PRIMARY KEY  (`lang_id`,`download_id`),
  FULLTEXT KEY `name` (`name`),
  FULLTEXT KEY `description` (`description`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_downloads_group` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `is_active` tinyint(1) NOT NULL default '1',
  `type` enum('file','url') NOT NULL default 'file',
  `info_page` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_downloads_group_locale` (
  `lang_id` int(11) unsigned NOT NULL default '0',
  `group_id` int(11) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`lang_id`,`group_id`),
  FULLTEXT KEY `name` (`name`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_downloads_rel_download_category` (
  `download_id` int(10) unsigned NOT NULL default '0',
  `category_id` int(10) unsigned NOT NULL default '0',
  `order` int(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`download_id`,`category_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_downloads_rel_download_download` (
  `id1` int(10) unsigned NOT NULL default '0',
  `id2` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id1`,`id2`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_downloads_rel_group_category` (
  `group_id` int(10) unsigned NOT NULL default '0',
  `category_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`group_id`,`category_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_downloads_settings` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(32) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_ecard_ecards` (
  `code` varchar(35) NOT NULL default '',
  `date` int(10) unsigned NOT NULL default '0',
  `TTL` int(10) unsigned NOT NULL default '0',
  `salutation` varchar(100) NOT NULL default '',
  `senderName` varchar(100) NOT NULL default '',
  `senderEmail` varchar(100) NOT NULL default '',
  `recipientName` varchar(100) NOT NULL default '',
  `recipientEmail` varchar(100) NOT NULL default '',
  `message` text NOT NULL,
  PRIMARY KEY  (`code`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_ecard_settings` (
  `setting_name` varchar(100) NOT NULL default '',
  `setting_value` text NOT NULL,
  PRIMARY KEY  (`setting_name`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_egov_configuration` (
  `name` varchar(255) NOT NULL default '',
  `value` text NOT NULL,
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_egov_orders` (
  `order_id` int(11) NOT NULL auto_increment,
  `order_date` timestamp NOT NULL default '0000-00-00 00:00:00',
  `order_ip` varchar(255) NOT NULL default '',
  `order_product` int(11) NOT NULL default '0',
  `order_values` text NOT NULL,
  `order_state` tinyint(4) NOT NULL default '0',
  `order_quant` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`order_id`),
  KEY `order_product` (`order_product`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_egov_products` (
  `product_id` int(11) NOT NULL auto_increment,
  `product_autostatus` tinyint(1) NOT NULL default '0',
  `product_name` varchar(255) NOT NULL default '',
  `product_desc` text NOT NULL,
  `product_price` decimal(11,2) NOT NULL default '0.00',
  `product_per_day` enum('yes','no') NOT NULL default 'no',
  `product_quantity` tinyint(2) NOT NULL default '0',
  `product_quantity_limit` tinyint(2) unsigned NOT NULL default '1',
  `product_target_email` varchar(255) NOT NULL default '',
  `product_target_url` varchar(255) NOT NULL default '',
  `product_message` text NOT NULL,
  `product_status` tinyint(1) NOT NULL default '1',
  `product_electro` tinyint(1) NOT NULL default '0',
  `product_file` varchar(255) NOT NULL default '',
  `product_sender_name` varchar(255) NOT NULL default '',
  `product_sender_email` varchar(255) NOT NULL default '',
  `product_target_subject` varchar(255) NOT NULL,
  `product_target_body` text NOT NULL,
  `product_paypal` tinyint(1) NOT NULL default '0',
  `product_paypal_sandbox` varchar(255) NOT NULL default '',
  `product_paypal_currency` varchar(255) NOT NULL default '',
  `product_orderby` int(11) NOT NULL default '0',
  `yellowpay` tinyint(1) unsigned NOT NULL default '0',
  `alternative_names` text NOT NULL,
  PRIMARY KEY  (`product_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_egov_product_calendar` (
  `calendar_id` int(11) NOT NULL auto_increment,
  `calendar_product` int(11) NOT NULL default '0',
  `calendar_order` int(11) NOT NULL default '0',
  `calendar_day` int(2) NOT NULL default '0',
  `calendar_month` int(2) unsigned zerofill NOT NULL default '00',
  `calendar_year` int(4) NOT NULL default '0',
  `calendar_act` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`calendar_id`),
  KEY `calendar_product` (`calendar_product`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_egov_product_fields` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `product` int(10) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `type` enum('text','label','checkbox','checkboxGroup','file','hidden','password','radio','select','textarea') NOT NULL default 'text',
  `attributes` text NOT NULL,
  `is_required` set('0','1') NOT NULL default '0',
  `check_type` int(3) NOT NULL default '1',
  `order_id` int(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `product` (`product`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_egov_settings` (
  `set_id` int(11) NOT NULL default '0',
  `set_sender_name` varchar(255) NOT NULL default '',
  `set_sender_email` varchar(255) NOT NULL default '',
  `set_recipient_email` varchar(255) NOT NULL default '',
  `set_state_subject` varchar(255) NOT NULL default '',
  `set_state_email` text NOT NULL,
  `set_calendar_color_1` varchar(255) NOT NULL default '',
  `set_calendar_color_2` varchar(255) NOT NULL default '',
  `set_calendar_color_3` varchar(255) NOT NULL default '',
  `set_calendar_legende_1` varchar(255) NOT NULL default '',
  `set_calendar_legende_2` varchar(255) NOT NULL default '',
  `set_calendar_legende_3` varchar(255) NOT NULL default '',
  `set_calendar_background` varchar(255) NOT NULL default '',
  `set_calendar_border` varchar(255) NOT NULL default '',
  `set_calendar_date_label` varchar(255) NOT NULL default '',
  `set_calendar_date_desc` varchar(255) NOT NULL default '',
  `set_orderentry_subject` varchar(255) NOT NULL default '',
  `set_orderentry_email` text NOT NULL,
  `set_orderentry_name` varchar(255) NOT NULL default '',
  `set_orderentry_sender` varchar(255) NOT NULL default '',
  `set_orderentry_recipient` varchar(255) NOT NULL default '',
  `set_paypal_email` text NOT NULL,
  `set_paypal_currency` text NOT NULL,
  `set_paypal_ipn` tinyint(1) NOT NULL default '0',
  KEY `set_id` (`set_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_feed_category` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(150) NOT NULL default '',
  `status` int(1) NOT NULL default '1',
  `time` int(100) NOT NULL default '0',
  `lang` int(1) NOT NULL default '0',
  `pos` int(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_feed_news` (
  `id` int(11) NOT NULL auto_increment,
  `subid` int(11) NOT NULL default '0',
  `name` varchar(150) NOT NULL default '',
  `link` varchar(150) NOT NULL default '',
  `filename` varchar(150) NOT NULL default '',
  `articles` int(2) NOT NULL default '0',
  `cache` int(4) NOT NULL default '3600',
  `time` int(100) NOT NULL default '0',
  `image` int(1) NOT NULL default '1',
  `status` int(1) NOT NULL default '1',
  `pos` int(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_feed_newsml_association` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pId_master` text NOT NULL,
  `pId_slave` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_feed_newsml_categories` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `providerId` text NOT NULL,
  `name` varchar(40) NOT NULL default '',
  `subjectCodes` text NOT NULL,
  `showSubjectCodes` enum('all','only','exclude') NOT NULL default 'all',
  `template` text NOT NULL,
  `limit` smallint(6) NOT NULL default '0',
  `showPics` enum('0','1') NOT NULL default '1',
  `auto_update` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_feed_newsml_documents` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `publicIdentifier` varchar(255) NOT NULL default '',
  `providerId` text NOT NULL,
  `dateId` int(8) unsigned NOT NULL default '0',
  `newsItemId` text NOT NULL,
  `revisionId` int(5) unsigned NOT NULL default '0',
  `thisRevisionDate` int(14) NOT NULL default '0',
  `urgency` smallint(5) unsigned NOT NULL default '0',
  `subjectCode` int(10) unsigned NOT NULL default '0',
  `headLine` varchar(67) NOT NULL default '',
  `dataContent` text NOT NULL,
  `is_associated` tinyint(1) unsigned NOT NULL default '0',
  `media_type` enum('Text','Graphic','Photo','Audio','Video','ComplexData') NOT NULL default 'Text',
  `source` text NOT NULL,
  `properties` text NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `unique` (`publicIdentifier`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_feed_newsml_providers` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `providerId` text NOT NULL,
  `name` varchar(40) NOT NULL default '',
  `path` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_filesharing` (
  `id` int(10) NOT NULL auto_increment,
  `file` varchar(250) NOT NULL,
  `source` varchar(250) NOT NULL,
  `cmd` varchar(50) NOT NULL,
  `hash` varchar(50) NOT NULL,
  `check` varchar(50) NOT NULL,
  `expiration_date` timestamp NULL default NULL,
  `upload_id` int(10) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_filesharing_mail_template` (
  `id` int(10) NOT NULL auto_increment,
  `lang_id` int(1) NOT NULL,
  `subject` varchar(250) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_forum_access` (
  `category_id` int(5) unsigned NOT NULL default '0',
  `group_id` int(5) unsigned NOT NULL default '0',
  `read` set('0','1') NOT NULL default '0',
  `write` set('0','1') NOT NULL default '0',
  `edit` set('0','1') NOT NULL default '0',
  `delete` set('0','1') NOT NULL default '0',
  `move` set('0','1') NOT NULL default '0',
  `close` set('0','1') NOT NULL default '0',
  `sticky` set('0','1') NOT NULL default '0',
  PRIMARY KEY  (`category_id`,`group_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_forum_categories` (
  `id` int(5) unsigned NOT NULL auto_increment,
  `parent_id` int(5) unsigned NOT NULL default '0',
  `order_id` int(5) unsigned NOT NULL default '0',
  `status` set('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_forum_categories_lang` (
  `category_id` int(5) unsigned NOT NULL default '0',
  `lang_id` int(5) unsigned NOT NULL default '0',
  `name` varchar(100) NOT NULL default '',
  `description` text NOT NULL,
  PRIMARY KEY  (`category_id`,`lang_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_forum_notification` (
  `category_id` int(10) unsigned NOT NULL default '0',
  `thread_id` int(10) unsigned NOT NULL default '0',
  `user_id` int(5) unsigned NOT NULL default '0',
  `is_notified` set('0','1') NOT NULL default '0',
  PRIMARY KEY  (`category_id`,`thread_id`,`user_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_forum_postings` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `category_id` int(5) unsigned NOT NULL default '0',
  `thread_id` int(10) unsigned NOT NULL default '0',
  `prev_post_id` int(10) unsigned NOT NULL default '0',
  `user_id` int(5) unsigned NOT NULL default '0',
  `time_created` int(14) unsigned NOT NULL default '0',
  `time_edited` int(14) unsigned NOT NULL default '0',
  `is_locked` set('0','1') NOT NULL default '0',
  `is_sticky` set('0','1') NOT NULL default '0',
  `rating` int(11) NOT NULL default '0',
  `views` int(10) unsigned NOT NULL default '0',
  `icon` smallint(5) unsigned NOT NULL default '0',
  `keywords` text NOT NULL,
  `subject` varchar(250) NOT NULL default '',
  `content` text NOT NULL,
  `attachment` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `category_id` (`category_id`,`thread_id`,`prev_post_id`,`user_id`),
  FULLTEXT KEY `fulltext` (`keywords`,`subject`,`content`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_forum_rating` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL default '0',
  `post_id` int(11) NOT NULL default '0',
  `time` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`,`post_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_forum_settings` (
  `id` int(5) unsigned NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_forum_statistics` (
  `category_id` int(5) unsigned NOT NULL default '0',
  `thread_count` int(10) unsigned NOT NULL default '0',
  `post_count` int(10) unsigned NOT NULL default '0',
  `last_post_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`category_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_gallery_categories` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) NOT NULL default '0',
  `sorting` int(6) NOT NULL default '0',
  `status` set('0','1') NOT NULL default '1',
  `comment` set('0','1') NOT NULL default '0',
  `voting` set('0','1') NOT NULL default '0',
  `backendProtected` int(11) NOT NULL default '0',
  `backend_access_id` int(11) NOT NULL default '0',
  `frontendProtected` int(11) NOT NULL default '0',
  `frontend_access_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_gallery_comments` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `picid` int(10) unsigned NOT NULL default '0',
  `date` int(14) unsigned NOT NULL default '0',
  `ip` varchar(15) NOT NULL default '',
  `name` varchar(50) NOT NULL default '',
  `email` varchar(250) NOT NULL default '',
  `www` varchar(250) NOT NULL default '',
  `comment` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_gallery_language` (
  `gallery_id` int(10) unsigned NOT NULL default '0',
  `lang_id` int(10) unsigned NOT NULL default '0',
  `name` set('name','desc') NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`gallery_id`,`lang_id`,`name`),
  FULLTEXT KEY `galleryindex` (`value`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_gallery_language_pics` (
  `picture_id` int(10) unsigned NOT NULL default '0',
  `lang_id` int(10) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `desc` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`picture_id`,`lang_id`),
  FULLTEXT KEY `galleryindex` (`name`,`desc`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_gallery_pictures` (
  `id` int(11) NOT NULL auto_increment,
  `catid` int(11) NOT NULL default '0',
  `validated` set('0','1') NOT NULL default '0',
  `status` set('0','1') NOT NULL default '1',
  `catimg` set('0','1') NOT NULL default '0',
  `sorting` int(6) unsigned NOT NULL default '999',
  `size_show` set('0','1') NOT NULL default '1',
  `path` text NOT NULL,
  `link` text NOT NULL,
  `lastedit` int(14) NOT NULL default '0',
  `size_type` set('abs','proz') NOT NULL default 'proz',
  `size_proz` int(3) NOT NULL default '0',
  `size_abs_h` int(11) NOT NULL default '0',
  `size_abs_w` int(11) NOT NULL default '0',
  `quality` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  FULLTEXT KEY `galleryPicturesIndex` (`path`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_gallery_settings` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(30) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_gallery_votes` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `picid` int(10) unsigned NOT NULL default '0',
  `date` int(14) unsigned NOT NULL default '0',
  `ip` varchar(15) NOT NULL default '',
  `md5` varchar(32) NOT NULL default '',
  `mark` int(2) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_guestbook` (
  `id` int(6) unsigned NOT NULL auto_increment,
  `status` tinyint(1) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `forename` varchar(255) NOT NULL default '',
  `gender` char(1) NOT NULL default '',
  `url` tinytext NOT NULL,
  `email` tinytext NOT NULL,
  `comment` text NOT NULL,
  `ip` varchar(15) NOT NULL default '',
  `location` tinytext NOT NULL,
  `lang_id` tinyint(2) NOT NULL default '1',
  `datetime` timestamp NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  FULLTEXT KEY `comment` (`comment`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_guestbook_settings` (
  `name` varchar(50) NOT NULL default '',
  `value` varchar(250) NOT NULL default '',
  KEY `name` (`name`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_jobs` (
  `id` int(6) unsigned NOT NULL auto_increment,
  `date` int(14) default NULL,
  `title` varchar(250) NOT NULL default '',
  `author` varchar(150) NOT NULL default '',
  `text` mediumtext NOT NULL,
  `workloc` varchar(250) NOT NULL default '',
  `workload` varchar(250) NOT NULL default '',
  `work_start` int(14) NOT NULL default '0',
  `catid` int(2) unsigned NOT NULL default '0',
  `lang` int(2) unsigned NOT NULL default '0',
  `userid` int(6) unsigned NOT NULL default '0',
  `startdate` timestamp NOT NULL default '0000-00-00 00:00:00',
  `enddate` timestamp NOT NULL default '0000-00-00 00:00:00',
  `status` tinyint(4) NOT NULL default '1',
  `changelog` int(14) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  FULLTEXT KEY `newsindex` (`title`,`text`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_jobs_categories` (
  `catid` int(2) unsigned NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `lang` int(2) unsigned NOT NULL default '1',
  `sort_style` enum('alpha','date','date_alpha') NOT NULL default 'alpha',
  PRIMARY KEY  (`catid`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_jobs_location` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_jobs_rel_loc_jobs` (
  `job` int(10) unsigned NOT NULL default '0',
  `location` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`job`,`location`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_jobs_settings` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(250) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_knowledge_articles` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `category` int(10) unsigned NOT NULL default '0',
  `active` tinyint(1) NOT NULL default '1',
  `hits` int(11) NOT NULL default '0',
  `votes` int(11) NOT NULL default '0',
  `votevalue` int(11) NOT NULL default '0',
  `sort` int(11) NOT NULL default '0',
  `date_created` int(14) NOT NULL default '0',
  `date_updated` int(14) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_knowledge_article_content` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `article` int(10) unsigned NOT NULL default '0',
  `lang` int(10) unsigned NOT NULL default '0',
  `question` text NOT NULL,
  `answer` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `module_knowledge_article_content_lang` (`lang`),
  KEY `module_knowledge_article_content_article` (`article`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_knowledge_categories` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `active` tinyint(1) unsigned NOT NULL default '1',
  `parent` int(10) unsigned NOT NULL default '0',
  `sort` int(10) unsigned NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `module_knowledge_categories_sort` (`sort`),
  KEY `module_knowledge_categories_parent` (`parent`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_knowledge_categories_content` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `category` int(10) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `lang` int(11) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_knowledge_settings` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `module_knowledge_settings_name` (`name`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_knowledge_tags` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `lang` int(10) unsigned NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `module_knowledge_tags_name` (`name`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_knowledge_tags_articles` (
  `article` int(10) unsigned NOT NULL default '0',
  `tag` int(10) unsigned NOT NULL default '0',
  UNIQUE KEY `article` (`article`,`tag`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_livecam` (
  `id` int(10) unsigned NOT NULL default '1',
  `currentImagePath` varchar(255) NOT NULL default '/webcam/cam1/current.jpg',
  `archivePath` varchar(255) NOT NULL default '/webcam/cam1/archive/',
  `thumbnailPath` varchar(255) NOT NULL default '/webcam/cam1/thumbs/',
  `maxImageWidth` int(10) unsigned NOT NULL default '400',
  `thumbMaxSize` int(10) unsigned NOT NULL default '200',
  `shadowboxActivate` set('1','0') NOT NULL default '1',
  `showFrom` int(14) NOT NULL default '0',
  `showTill` int(14) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_livecam_settings` (
  `setid` int(10) unsigned NOT NULL auto_increment,
  `setname` varchar(255) NOT NULL default '',
  `setvalue` text NOT NULL,
  PRIMARY KEY  (`setid`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_market` (
  `id` int(9) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `type` set('search','offer') NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `description` mediumtext NOT NULL,
  `color` varchar(50) NOT NULL default '',
  `premium` int(1) NOT NULL default '0',
  `picture` varchar(255) NOT NULL default '',
  `catid` int(4) NOT NULL default '0',
  `price` varchar(10) NOT NULL default '',
  `regdate` varchar(20) NOT NULL default '',
  `enddate` varchar(20) NOT NULL default '',
  `userid` int(4) NOT NULL default '0',
  `userdetails` int(1) NOT NULL default '0',
  `status` int(1) NOT NULL default '0',
  `regkey` varchar(50) NOT NULL default '',
  `paypal` int(1) NOT NULL default '0',
  `sort_id` int(4) NOT NULL default '0',
  `spez_field_1` varchar(255) NOT NULL,
  `spez_field_2` varchar(255) NOT NULL,
  `spez_field_3` varchar(255) NOT NULL,
  `spez_field_4` varchar(255) NOT NULL,
  `spez_field_5` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  FULLTEXT KEY `description` (`description`),
  FULLTEXT KEY `title` (`description`,`title`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_market_categories` (
  `id` int(6) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  `displayorder` int(4) NOT NULL default '0',
  `status` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_market_mail` (
  `id` int(4) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `content` longtext NOT NULL,
  `mailto` varchar(10) NOT NULL,
  `mailcc` mediumtext NOT NULL,
  `active` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_market_paypal` (
  `id` int(4) NOT NULL auto_increment,
  `active` int(1) NOT NULL default '0',
  `profile` varchar(255) NOT NULL default '',
  `price` varchar(10) NOT NULL default '',
  `price_premium` varchar(10) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_market_settings` (
  `id` int(6) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  `type` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_market_spez_fields` (
  `id` int(5) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `value` varchar(100) NOT NULL,
  `type` int(1) NOT NULL default '1',
  `lang_id` int(2) NOT NULL default '0',
  `active` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_mediadir_categories` (
  `id` int(7) NOT NULL auto_increment,
  `parent_id` int(7) NOT NULL,
  `order` int(7) NOT NULL,
  `show_subcategories` int(11) NOT NULL,
  `show_entries` int(1) NOT NULL,
  `picture` mediumtext NOT NULL,
  `active` int(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_mediadir_categories_names` (
  `lang_id` int(1) NOT NULL,
  `category_id` int(7) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_description` mediumtext NOT NULL,
  KEY `lang_id` (`lang_id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_mediadir_comments` (
  `id` int(7) NOT NULL auto_increment,
  `entry_id` int(7) NOT NULL,
  `added_by` varchar(255) NOT NULL,
  `date` varchar(100) NOT NULL,
  `ip` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `notification` int(1) NOT NULL default '0',
  `comment` mediumtext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_mediadir_entries` (
  `id` int(10) NOT NULL auto_increment,
  `order` int(7) NOT NULL default '0',
  `form_id` int(7) NOT NULL,
  `create_date` int(50) NOT NULL,
  `update_date` int(50) NOT NULL,
  `validate_date` int(50) NOT NULL,
  `added_by` int(10) NOT NULL,
  `updated_by` int(10) NOT NULL,
  `lang_id` int(1) NOT NULL,
  `hits` int(10) NOT NULL,
  `popular_hits` int(10) NOT NULL,
  `popular_date` varchar(20) NOT NULL,
  `last_ip` varchar(50) NOT NULL,
  `ready_to_confirm` int(1) NOT NULL default '0',
  `confirmed` int(1) NOT NULL,
  `active` int(1) NOT NULL,
  `duration_type` int(1) NOT NULL,
  `duration_start` int(50) NOT NULL,
  `duration_end` int(50) NOT NULL,
  `duration_notification` int(1) NOT NULL,
  `translation_status` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `lang_id` (`lang_id`),
  KEY `active` (`active`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_mediadir_forms` (
  `id` int(7) NOT NULL auto_increment,
  `order` int(7) NOT NULL,
  `picture` mediumtext NOT NULL,
  `active` int(1) NOT NULL,
  `use_level` int(1) NOT NULL,
  `use_category` int(1) NOT NULL,
  `use_ready_to_confirm` int(1) NOT NULL,
  `cmd` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_mediadir_form_names` (
  `lang_id` int(1) NOT NULL,
  `form_id` int(7) NOT NULL,
  `form_name` varchar(255) NOT NULL,
  `form_description` mediumtext NOT NULL
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_mediadir_inputfields` (
  `id` int(10) NOT NULL auto_increment,
  `form` int(7) NOT NULL,
  `type` int(10) NOT NULL,
  `verification` int(10) NOT NULL,
  `search` int(10) NOT NULL,
  `required` int(10) NOT NULL,
  `order` int(10) NOT NULL,
  `show_in` int(10) NOT NULL,
  `context_type` enum('none','title','address','zip','city','country') NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_mediadir_inputfield_names` (
  `lang_id` int(10) NOT NULL,
  `form_id` int(7) NOT NULL,
  `field_id` int(10) NOT NULL,
  `field_name` varchar(255) NOT NULL,
  `field_default_value` mediumtext NOT NULL,
  `field_info` mediumtext NOT NULL,
  KEY `field_id` (`field_id`),
  KEY `lang_id` (`lang_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_mediadir_inputfield_types` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `active` int(1) NOT NULL,
  `multi_lang` int(1) NOT NULL,
  `exp_search` int(7) NOT NULL,
  `dynamic` int(1) NOT NULL,
  `comment` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_mediadir_inputfield_verifications` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `regex` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_mediadir_levels` (
  `id` int(7) NOT NULL auto_increment,
  `parent_id` int(7) NOT NULL,
  `order` int(7) NOT NULL,
  `show_sublevels` int(11) NOT NULL,
  `show_categories` int(1) NOT NULL,
  `show_entries` int(1) NOT NULL,
  `picture` mediumtext NOT NULL,
  `active` int(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_mediadir_level_names` (
  `lang_id` int(1) NOT NULL,
  `level_id` int(7) NOT NULL,
  `level_name` varchar(255) NOT NULL,
  `level_description` mediumtext NOT NULL,
  KEY `lang_id` (`lang_id`),
  KEY `category_id` (`level_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_mediadir_mails` (
  `id` int(7) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `recipients` mediumtext NOT NULL,
  `lang_id` int(1) NOT NULL,
  `action_id` int(1) NOT NULL,
  `is_default` int(1) NOT NULL,
  `active` int(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_mediadir_mail_actions` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `default_recipient` enum('admin','author') NOT NULL,
  `need_auth` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_mediadir_masks` (
  `id` int(7) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `fields` mediumtext NOT NULL,
  `active` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_mediadir_order_rel_forms_selectors` (
  `selector_id` int(7) NOT NULL,
  `form_id` int(7) NOT NULL,
  `selector_order` int(7) NOT NULL,
  `exp_search` int(1) NOT NULL
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_mediadir_rel_entry_categories` (
  `entry_id` int(10) NOT NULL,
  `category_id` int(10) NOT NULL,
  KEY `entry_id` (`entry_id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_mediadir_rel_entry_inputfields` (
  `entry_id` int(7) NOT NULL,
  `lang_id` int(7) NOT NULL,
  `form_id` int(7) NOT NULL,
  `field_id` int(7) NOT NULL,
  `value` longtext NOT NULL,
  UNIQUE KEY `entry_id` (`entry_id`,`lang_id`,`form_id`,`field_id`),
  FULLTEXT KEY `value` (`value`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_mediadir_rel_entry_levels` (
  `entry_id` int(10) NOT NULL,
  `level_id` int(10) NOT NULL,
  KEY `entry_id` (`entry_id`),
  KEY `category_id` (`level_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_mediadir_settings` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_mediadir_settings_num_categories` (
  `group_id` int(1) NOT NULL,
  `num_categories` varchar(10) NOT NULL
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_mediadir_settings_num_entries` (
  `group_id` int(1) NOT NULL,
  `num_entries` varchar(10) NOT NULL default 'n'
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_mediadir_settings_num_levels` (
  `group_id` int(1) NOT NULL,
  `num_levels` varchar(10) NOT NULL
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_mediadir_settings_perm_group_forms` (
  `group_id` int(7) NOT NULL,
  `form_id` int(1) NOT NULL,
  `status_group` int(1) NOT NULL
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_mediadir_votes` (
  `id` int(7) NOT NULL auto_increment,
  `entry_id` int(7) NOT NULL,
  `added_by` varchar(255) NOT NULL,
  `date` varchar(100) NOT NULL,
  `ip` varchar(100) NOT NULL,
  `vote` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_media_settings` (
  `name` varchar(50) NOT NULL,
  `value` varchar(250) NOT NULL,
  KEY `name` (`name`)
) ENGINE=InnoDB;

CREATE TABLE `contrexx_module_memberdir_directories` (
  `dirid` int(10) unsigned NOT NULL auto_increment,
  `parentdir` int(11) NOT NULL default '0',
  `active` set('1','0') NOT NULL default '1',
  `name` varchar(255) NOT NULL default '',
  `description` text NOT NULL,
  `displaymode` set('0','1','2') NOT NULL default '0',
  `sort` int(11) NOT NULL default '1',
  `pic1` set('1','0') NOT NULL default '0',
  `pic2` set('1','0') NOT NULL default '0',
  `lang_id` int(2) unsigned NOT NULL default '1',
  PRIMARY KEY  (`dirid`),
  FULLTEXT KEY `memberdir_dir` (`name`,`description`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_memberdir_name` (
  `field` int(10) unsigned NOT NULL default '0',
  `dirid` int(10) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `active` set('0','1') NOT NULL default '',
  `lang_id` int(2) unsigned NOT NULL default '1'
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_memberdir_settings` (
  `setid` int(4) unsigned NOT NULL auto_increment,
  `setname` varchar(255) NOT NULL default '',
  `setvalue` text NOT NULL,
  `lang_id` int(2) unsigned NOT NULL default '1',
  PRIMARY KEY  (`setid`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_memberdir_values` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `dirid` int(14) NOT NULL default '0',
  `pic1` varchar(255) NOT NULL default '',
  `pic2` varchar(255) NOT NULL default '',
  `0` smallint(5) unsigned NOT NULL default '0',
  `1` text NOT NULL,
  `2` text NOT NULL,
  `3` text NOT NULL,
  `4` text NOT NULL,
  `5` text NOT NULL,
  `6` text NOT NULL,
  `7` text NOT NULL,
  `8` text NOT NULL,
  `9` text NOT NULL,
  `10` text NOT NULL,
  `11` text NOT NULL,
  `12` text NOT NULL,
  `13` text NOT NULL,
  `14` text NOT NULL,
  `15` text NOT NULL,
  `16` text NOT NULL,
  `17` text NOT NULL,
  `18` text NOT NULL,
  `lang_id` int(2) unsigned NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_news` (
  `id` int(6) unsigned NOT NULL auto_increment,
  `date` int(14) default NULL,
  `redirect` varchar(250) NOT NULL default '',
  `source` varchar(250) NOT NULL default '',
  `url1` varchar(250) NOT NULL default '',
  `url2` varchar(250) NOT NULL default '',
  `catid` int(2) unsigned NOT NULL default '0',
  `typeid` int(2) unsigned NOT NULL default '0',
  `publisher` varchar(255) NOT NULL default '',
  `publisher_id` int(5) unsigned NOT NULL default '0',
  `author` varchar(255) NOT NULL default '',
  `author_id` int(5) unsigned NOT NULL default '0',
  `userid` int(6) unsigned NOT NULL default '0',
  `startdate` timestamp NOT NULL default '0000-00-00 00:00:00',
  `enddate` timestamp NOT NULL default '0000-00-00 00:00:00',
  `status` tinyint(4) NOT NULL default '1',
  `validated` enum('0','1') NOT NULL default '0',
  `frontend_access_id` int(10) unsigned NOT NULL default '0',
  `backend_access_id` int(10) unsigned NOT NULL default '0',
  `teaser_only` enum('0','1') NOT NULL default '0',
  `teaser_frames` text NOT NULL,
  `teaser_show_link` tinyint(1) unsigned NOT NULL default '1',
  `teaser_image_path` text NOT NULL,
  `teaser_image_thumbnail_path` text NOT NULL,
  `changelog` int(14) NOT NULL default '0',
  `allow_comments` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_newsletter` (
  `id` int(11) NOT NULL auto_increment,
  `subject` varchar(255) NOT NULL default '',
  `template` int(11) NOT NULL default '0',
  `content` text NOT NULL,
  `attachment` enum('0','1') NOT NULL default '0',
  `priority` tinyint(1) NOT NULL default '0',
  `sender_email` varchar(255) NOT NULL default '',
  `sender_name` varchar(255) NOT NULL default '',
  `return_path` varchar(255) NOT NULL default '',
  `smtp_server` int(10) unsigned NOT NULL default '0',
  `status` int(1) NOT NULL default '0',
  `count` int(11) NOT NULL default '0',
  `recipient_count` int(11) unsigned NOT NULL default '0',
  `date_create` int(14) unsigned NOT NULL default '0',
  `date_sent` int(14) unsigned NOT NULL default '0',
  `tmp_copy` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_newsletter_access_user` (
  `accessUserID` int(5) unsigned NOT NULL,
  `newsletterCategoryID` int(11) NOT NULL,
  `code` varchar(255) NOT NULL default '',
  UNIQUE KEY `rel` (`accessUserID`,`newsletterCategoryID`),
  KEY `accessUserID` (`accessUserID`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_newsletter_attachment` (
  `id` int(11) NOT NULL auto_increment,
  `newsletter` int(11) NOT NULL default '0',
  `file_name` varchar(255) NOT NULL default '',
  `file_nr` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `newsletter` (`newsletter`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_newsletter_category` (
  `id` int(11) NOT NULL auto_increment,
  `status` tinyint(1) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `notification_email` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_newsletter_confirm_mail` (
  `id` int(1) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `content` longtext NOT NULL,
  `recipients` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_newsletter_email_link` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `email_id` int(11) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `email_id` (`email_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_newsletter_email_link_feedback` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `link_id` int(11) unsigned NOT NULL,
  `email_id` int(11) unsigned NOT NULL,
  `recipient_id` int(11) unsigned NOT NULL,
  `recipient_type` enum('access','newsletter') NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `link_id` (`link_id`,`email_id`,`recipient_id`,`recipient_type`),
  KEY `email_id` (`email_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_newsletter_rel_cat_news` (
  `newsletter` int(11) NOT NULL default '0',
  `category` int(11) NOT NULL default '0',
  PRIMARY KEY  (`newsletter`,`category`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_newsletter_rel_usergroup_newsletter` (
  `userGroup` int(10) unsigned NOT NULL,
  `newsletter` int(10) unsigned NOT NULL,
  UNIQUE KEY `uniq` (`userGroup`,`newsletter`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_newsletter_rel_user_cat` (
  `user` int(11) NOT NULL default '0',
  `category` int(11) NOT NULL default '0',
  PRIMARY KEY  (`user`,`category`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_newsletter_settings` (
  `setid` int(6) unsigned NOT NULL auto_increment,
  `setname` varchar(250) NOT NULL default '',
  `setvalue` text NOT NULL,
  `status` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`setid`),
  UNIQUE KEY `setname` (`setname`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_newsletter_template` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  `html` text NOT NULL,
  `required` int(1) NOT NULL default '0',
  `type` enum('e-mail','news') NOT NULL default 'e-mail',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_newsletter_tmp_sending` (
  `id` int(11) NOT NULL auto_increment,
  `newsletter` int(11) NOT NULL default '0',
  `email` varchar(255) NOT NULL default '',
  `sendt` tinyint(1) NOT NULL default '0',
  `type` enum('access','newsletter','core') NOT NULL default 'newsletter',
  `code` varchar(10) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `unique_email` (`newsletter`,`email`),
  KEY `email` (`email`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_newsletter_user` (
  `id` int(11) NOT NULL auto_increment,
  `code` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `uri` varchar(255) NOT NULL default '',
  `sex` enum('m','f') default NULL,
  `salutation` int(10) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `lastname` varchar(255) NOT NULL default '',
  `firstname` varchar(255) NOT NULL default '',
  `position` varchar(255) NOT NULL default '',
  `company` varchar(255) NOT NULL default '',
  `industry_sector` varchar(255) NOT NULL default '',
  `address` varchar(255) NOT NULL default '',
  `zip` varchar(255) NOT NULL default '',
  `city` varchar(255) NOT NULL default '',
  `country_id` smallint(5) unsigned NOT NULL default '0',
  `phone_office` varchar(255) NOT NULL default '',
  `phone_private` varchar(255) NOT NULL default '',
  `phone_mobile` varchar(255) NOT NULL default '',
  `fax` varchar(255) NOT NULL default '',
  `notes` text NOT NULL,
  `birthday` varchar(10) NOT NULL default '00-00-0000',
  `status` int(1) NOT NULL default '0',
  `emaildate` int(14) unsigned NOT NULL default '0',
  `language` int(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `status` (`status`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_newsletter_user_title` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_news_categories` (
  `catid` int(2) unsigned NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL,
  `left_id` int(11) NOT NULL,
  `right_id` int(11) NOT NULL,
  `sorting` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  PRIMARY KEY  (`catid`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_news_categories_catid` (
  `id` int(11) NOT NULL
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_news_categories_locale` (
  `category_id` int(11) unsigned NOT NULL default '0',
  `lang_id` int(11) unsigned NOT NULL default '0',
  `name` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`category_id`,`lang_id`),
  FULLTEXT KEY `name` (`name`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_news_categories_locks` (
  `lockId` varchar(32) NOT NULL,
  `lockTable` varchar(32) NOT NULL,
  `lockStamp` bigint(11) NOT NULL
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_news_comments` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(250) NOT NULL default '',
  `text` mediumtext NOT NULL,
  `newsid` int(6) unsigned NOT NULL default '0',
  `date` int(14) default NULL,
  `poster_name` varchar(255) NOT NULL default '',
  `userid` int(5) unsigned NOT NULL default '0',
  `ip_address` varchar(15) NOT NULL default '0.0.0.0',
  `is_active` enum('0','1') NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_news_locale` (
  `news_id` int(11) unsigned NOT NULL default '0',
  `lang_id` int(11) unsigned NOT NULL default '0',
  `is_active` int(1) unsigned NOT NULL default '1',
  `title` varchar(250) NOT NULL default '',
  `text` mediumtext NOT NULL,
  `teaser_text` text NOT NULL,
  PRIMARY KEY  (`news_id`,`lang_id`),
  FULLTEXT KEY `newsindex` (`text`,`title`,`teaser_text`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_news_settings` (
  `name` varchar(50) NOT NULL default '',
  `value` varchar(250) NOT NULL default '',
  KEY `name` (`name`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_news_settings_locale` (
  `name` varchar(50) NOT NULL default '',
  `lang_id` int(11) unsigned NOT NULL default '0',
  `value` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`name`,`lang_id`),
  FULLTEXT KEY `name` (`name`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_news_stats_view` (
  `user_sid` char(32) NOT NULL,
  `news_id` int(6) unsigned NOT NULL,
  `time` timestamp NOT NULL ,
  KEY `idx_user_sid` (`user_sid`),
  KEY `idx_news_id` (`news_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_news_teaser_frame` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `lang_id` int(3) unsigned NOT NULL default '0',
  `frame_template_id` int(10) unsigned NOT NULL default '0',
  `name` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_news_teaser_frame_templates` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `description` varchar(100) NOT NULL default '',
  `html` text NOT NULL,
  `source_code_mode` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_news_ticker` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `charset` enum('ISO-8859-1','UTF-8') NOT NULL default 'ISO-8859-1',
  `urlencode` tinyint(1) unsigned NOT NULL default '0',
  `prefix` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_news_types` (
  `typeid` int(2) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (`typeid`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_news_types_locale` (
  `lang_id` int(11) unsigned NOT NULL default '0',
  `type_id` int(11) unsigned NOT NULL default '0',
  `name` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`lang_id`,`type_id`),
  FULLTEXT KEY `name` (`name`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_podcast_category` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  `status` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  FULLTEXT KEY `podcastindex` (`title`,`description`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_podcast_medium` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `youtube_id` varchar(25) NOT NULL default '',
  `author` varchar(255) NOT NULL default '',
  `description` text NOT NULL,
  `source` text NOT NULL,
  `thumbnail` varchar(255) NOT NULL default '',
  `template_id` int(11) unsigned NOT NULL default '0',
  `width` int(10) unsigned NOT NULL default '0',
  `height` int(10) unsigned NOT NULL default '0',
  `playlenght` int(10) unsigned NOT NULL default '0',
  `size` int(10) unsigned NOT NULL default '0',
  `views` int(10) unsigned NOT NULL default '0',
  `status` tinyint(1) NOT NULL default '0',
  `date_added` int(14) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  FULLTEXT KEY `podcastindex` (`title`,`description`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_podcast_rel_category_lang` (
  `category_id` int(10) unsigned NOT NULL default '0',
  `lang_id` int(10) unsigned NOT NULL default '0'
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_podcast_rel_medium_category` (
  `medium_id` int(10) unsigned NOT NULL default '0',
  `category_id` int(10) unsigned NOT NULL default '0'
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_podcast_settings` (
  `setid` int(6) unsigned NOT NULL auto_increment,
  `setname` varchar(250) NOT NULL default '',
  `setvalue` text NOT NULL,
  `status` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`setid`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_podcast_template` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `description` varchar(255) NOT NULL default '',
  `template` text NOT NULL,
  `extensions` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `description` (`description`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_recommend` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `value` text NOT NULL,
  `lang_id` int(11) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_repository` (
  `id` int(6) unsigned NOT NULL auto_increment,
  `moduleid` int(5) unsigned NOT NULL default '0',
  `content` mediumtext NOT NULL,
  `title` varchar(250) NOT NULL default '',
  `cmd` varchar(20) NOT NULL default '',
  `expertmode` set('y','n') NOT NULL default 'n',
  `parid` int(5) unsigned NOT NULL default '0',
  `displaystatus` set('on','off') NOT NULL default 'on',
  `username` varchar(250) NOT NULL default '',
  `displayorder` smallint(6) NOT NULL default '100',
  UNIQUE KEY `contentid` (`id`),
  FULLTEXT KEY `fulltextindex` (`title`,`content`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_shop_article_group` (
  `id` int(10) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_shop_attribute` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `type` tinyint(1) unsigned NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_shop_categories` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `parent_id` int(10) unsigned NOT NULL default '0',
  `ord` int(5) unsigned NOT NULL default '0',
  `active` tinyint(1) unsigned NOT NULL default '1',
  `picture` varchar(255) NOT NULL default '',
  `flags` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  FULLTEXT KEY `flags` (`flags`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_shop_currencies` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `code` char(3) NOT NULL default '',
  `symbol` varchar(20) NOT NULL default '',
  `rate` decimal(10,4) unsigned NOT NULL default '1.0000',
  `ord` int(5) unsigned NOT NULL default '0',
  `active` tinyint(1) unsigned NOT NULL default '1',
  `default` tinyint(1) unsigned NOT NULL default '0',
  `increment` decimal(6,5) unsigned NOT NULL default '0.01000',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_shop_customer_group` (
  `id` int(10) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_shop_discountgroup_count_name` (
  `id` int(10) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_shop_discountgroup_count_rate` (
  `group_id` int(10) unsigned NOT NULL default '0',
  `count` int(10) unsigned NOT NULL default '1',
  `rate` decimal(5,2) unsigned NOT NULL default '0.00',
  PRIMARY KEY  (`group_id`,`count`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_shop_discount_coupon` (
  `code` varchar(20) NOT NULL default '',
  `customer_id` int(10) unsigned NOT NULL default '0',
  `payment_id` int(10) unsigned NOT NULL default '0',
  `product_id` int(10) unsigned NOT NULL default '0',
  `start_time` int(10) unsigned NOT NULL default '0',
  `end_time` int(10) unsigned NOT NULL default '0',
  `uses` int(10) unsigned NOT NULL default '0',
  `global` tinyint(1) unsigned NOT NULL default '0',
  `minimum_amount` decimal(9,2) unsigned NOT NULL default '0.00',
  `discount_amount` decimal(9,2) unsigned NOT NULL default '0.00',
  `discount_rate` decimal(3,0) unsigned NOT NULL default '0',
  PRIMARY KEY  (`code`,`customer_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_shop_importimg` (
  `img_id` int(10) unsigned NOT NULL auto_increment,
  `img_name` varchar(255) NOT NULL default '',
  `img_cats` text NOT NULL,
  `img_fields_file` text NOT NULL,
  `img_fields_db` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`img_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_shop_lsv` (
  `order_id` int(10) unsigned NOT NULL,
  `holder` tinytext NOT NULL,
  `bank` tinytext NOT NULL,
  `blz` tinytext NOT NULL,
  PRIMARY KEY  (`order_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_shop_manufacturer` (
  `id` int(10) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_shop_option` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `attribute_id` int(10) unsigned NOT NULL,
  `price` decimal(9,2) NOT NULL default '0.00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_shop_orders` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `customer_id` int(10) unsigned NOT NULL default '0',
  `currency_id` int(10) unsigned NOT NULL default '0',
  `sum` decimal(9,2) unsigned NOT NULL default '0.00',
  `date_time` timestamp NOT NULL default '0000-00-00 00:00:00',
  `status` tinyint(1) unsigned NOT NULL default '0',
  `gender` varchar(50) default NULL,
  `company` varchar(100) default NULL,
  `firstname` varchar(40) default NULL,
  `lastname` varchar(100) default NULL,
  `address` varchar(40) default NULL,
  `city` varchar(50) default NULL,
  `zip` varchar(10) default NULL,
  `country_id` int(10) unsigned default NULL,
  `phone` varchar(20) default NULL,
  `vat_amount` decimal(9,2) unsigned NOT NULL default '0.00',
  `shipment_amount` decimal(9,2) unsigned NOT NULL default '0.00',
  `shipment_id` int(10) unsigned default NULL,
  `payment_id` int(10) unsigned NOT NULL default '0',
  `payment_amount` decimal(9,2) unsigned NOT NULL default '0.00',
  `ip` varchar(50) NOT NULL default '',
  `host` varchar(100) NOT NULL default '',
  `lang_id` int(10) unsigned NOT NULL default '0',
  `browser` varchar(255) NOT NULL default '',
  `note` text NOT NULL,
  `modified_on` timestamp NULL default NULL,
  `modified_by` varchar(50) default NULL,
  `billing_gender` varchar(50) default NULL,
  `billing_company` varchar(100) default NULL,
  `billing_firstname` varchar(40) default NULL,
  `billing_lastname` varchar(100) default NULL,
  `billing_address` varchar(40) default NULL,
  `billing_city` varchar(50) default NULL,
  `billing_zip` varchar(10) default NULL,
  `billing_country_id` int(10) unsigned default NULL,
  `billing_phone` varchar(20) default NULL,
  `billing_fax` varchar(20) default NULL,
  `billing_email` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `status` (`status`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_shop_order_attributes` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `item_id` int(10) unsigned NOT NULL default '0',
  `attribute_name` varchar(255) NOT NULL default '',
  `option_name` varchar(255) NOT NULL default '',
  `price` decimal(9,2) NOT NULL default '0.00',
  PRIMARY KEY  (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_shop_order_items` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `order_id` int(10) unsigned NOT NULL default '0',
  `product_id` int(10) unsigned NOT NULL default '0',
  `product_name` varchar(255) NOT NULL default '',
  `price` decimal(9,2) unsigned NOT NULL default '0.00',
  `quantity` int(10) unsigned NOT NULL default '0',
  `vat_rate` decimal(5,2) unsigned default NULL,
  `weight` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `order` (`order_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_shop_payment` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `processor_id` int(10) unsigned NOT NULL default '0',
  `fee` decimal(9,2) unsigned NOT NULL default '0.00',
  `free_from` decimal(9,2) unsigned NOT NULL default '0.00',
  `ord` int(5) unsigned NOT NULL default '0',
  `active` tinyint(1) unsigned NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_shop_payment_processors` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `type` enum('internal','external') NOT NULL default 'internal',
  `name` varchar(255) NOT NULL default '',
  `description` text NOT NULL,
  `company_url` varchar(255) NOT NULL default '',
  `status` tinyint(1) unsigned NOT NULL default '1',
  `picture` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_shop_pricelists` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(25) NOT NULL default '',
  `lang_id` int(10) unsigned NOT NULL default '0',
  `border_on` tinyint(1) unsigned NOT NULL default '1',
  `header_on` tinyint(1) unsigned NOT NULL default '1',
  `header_left` text ,
  `header_right` text ,
  `footer_on` tinyint(1) unsigned NOT NULL default '0',
  `footer_left` text ,
  `footer_right` text ,
  `categories` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_shop_products` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `picture` varchar(4096) default NULL,
  `category_id` varchar(255) NOT NULL default '',
  `distribution` varchar(16) NOT NULL default '',
  `normalprice` decimal(9,2) NOT NULL default '0.00',
  `resellerprice` decimal(9,2) NOT NULL default '0.00',
  `stock` int(10) NOT NULL default '10',
  `stock_visible` tinyint(1) unsigned NOT NULL default '1',
  `discountprice` decimal(9,2) NOT NULL default '0.00',
  `discount_active` tinyint(1) unsigned NOT NULL default '0',
  `active` tinyint(1) unsigned NOT NULL default '1',
  `b2b` tinyint(1) unsigned NOT NULL default '1',
  `b2c` tinyint(1) unsigned NOT NULL default '1',
  `date_start` timestamp NOT NULL default '0000-00-00 00:00:00',
  `date_end` timestamp NOT NULL default '0000-00-00 00:00:00',
  `manufacturer_id` int(10) unsigned default NULL,
  `ord` int(10) NOT NULL default '0',
  `vat_id` int(10) unsigned default NULL,
  `weight` int(10) unsigned default NULL,
  `flags` varchar(4096) default NULL,
  `group_id` int(10) unsigned default NULL,
  `article_id` int(10) unsigned default NULL,
  `usergroup_ids` varchar(4096) default NULL,
  PRIMARY KEY  (`id`),
  KEY `group_id` (`group_id`),
  KEY `article_id` (`article_id`),
  FULLTEXT KEY `flags` (`flags`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_shop_rel_countries` (
  `zone_id` int(10) unsigned NOT NULL default '0',
  `country_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`country_id`,`zone_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_shop_rel_customer_coupon` (
  `code` varchar(20) NOT NULL default '',
  `customer_id` int(10) unsigned NOT NULL default '0',
  `order_id` int(10) unsigned NOT NULL default '0',
  `count` int(10) unsigned NOT NULL default '0',
  `amount` decimal(9,2) unsigned NOT NULL default '0.00',
  PRIMARY KEY  (`code`,`customer_id`,`order_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_shop_rel_discount_group` (
  `customer_group_id` int(10) unsigned NOT NULL default '0',
  `article_group_id` int(10) unsigned NOT NULL default '0',
  `rate` decimal(9,2) NOT NULL default '0.00',
  PRIMARY KEY  (`customer_group_id`,`article_group_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_shop_rel_payment` (
  `zone_id` int(10) unsigned NOT NULL default '0',
  `payment_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`zone_id`,`payment_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_shop_rel_product_attribute` (
  `product_id` int(10) unsigned NOT NULL default '0',
  `option_id` int(10) unsigned NOT NULL,
  `ord` int(10) NOT NULL default '0',
  PRIMARY KEY  (`product_id`,`option_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_shop_rel_shipper` (
  `zone_id` int(10) unsigned NOT NULL default '0',
  `shipper_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`shipper_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_shop_shipment_cost` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `shipper_id` int(10) unsigned NOT NULL default '0',
  `max_weight` int(10) unsigned default NULL,
  `fee` decimal(9,2) unsigned default NULL,
  `free_from` decimal(9,2) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_shop_shipper` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `active` tinyint(1) unsigned NOT NULL default '1',
  `ord` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_shop_vat` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `rate` decimal(5,2) unsigned NOT NULL default '0.00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_shop_zones` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `active` tinyint(1) unsigned NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_module_u2u_address_list` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL default '0',
  `buddies_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB;

CREATE TABLE `contrexx_module_u2u_message_log` (
  `message_id` int(11) unsigned NOT NULL auto_increment,
  `message_text` text NOT NULL,
  `message_title` text NOT NULL,
  PRIMARY KEY  (`message_id`)
) ENGINE=InnoDB;

CREATE TABLE `contrexx_module_u2u_sent_messages` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `userid` int(11) unsigned NOT NULL default '0',
  `message_id` int(11) unsigned NOT NULL default '0',
  `receiver_id` int(11) unsigned NOT NULL default '0',
  `mesage_open_status` enum('0','1') NOT NULL default '0',
  `date_time` timestamp NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB;

CREATE TABLE `contrexx_module_u2u_settings` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB;

CREATE TABLE `contrexx_module_u2u_user_log` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `userid` int(11) unsigned NOT NULL default '0',
  `user_sent_items` int(11) unsigned NOT NULL default '0',
  `user_unread_items` int(11) unsigned NOT NULL default '0',
  `user_status` enum('0','1') NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB;

CREATE TABLE `contrexx_sessions` (
  `sessionid` varchar(255) NOT NULL default '',
  `remember_me` int(1) NOT NULL default '0',
  `startdate` varchar(14) NOT NULL default '',
  `lastupdated` varchar(14) NOT NULL default '',
  `status` varchar(20) NOT NULL default '',
  `user_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`sessionid`),
  KEY `LastUpdated` (`lastupdated`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_session_variable` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL,
  `sessionid` varchar(32) NOT NULL default '',
  `lastused` timestamp NOT NULL ,
  `key` varchar(40) NOT NULL default '',
  `value` text ,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `key_index` (`parent_id`,`key`,`sessionid`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_settings` (
  `setid` int(6) unsigned NOT NULL auto_increment,
  `setname` varchar(250) NOT NULL default '',
  `setvalue` text NOT NULL,
  `setmodule` tinyint(2) NOT NULL default '0',
  PRIMARY KEY  (`setid`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_settings_image` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_settings_smtp` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `hostname` varchar(255) NOT NULL,
  `port` smallint(5) unsigned NOT NULL default '25',
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_skins` (
  `id` int(2) unsigned NOT NULL auto_increment,
  `themesname` varchar(50) NOT NULL default '',
  `foldername` varchar(50) NOT NULL default '',
  `expert` int(1) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `theme_unique` (`themesname`),
  UNIQUE KEY `folder_unique` (`foldername`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_stats_browser` (
  `id` int(6) unsigned NOT NULL auto_increment,
  `name` varchar(255) BINARY NOT NULL default '',
  `count` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `unique` (`name`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_stats_colourdepth` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `depth` tinyint(3) unsigned NOT NULL default '0',
  `count` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `unique` (`depth`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_stats_config` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(64) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  `status` int(1) default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_stats_country` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `country` varchar(100) BINARY NOT NULL default '',
  `count` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `unique` (`country`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_stats_hostname` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `hostname` varchar(255) BINARY NOT NULL default '',
  `count` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `unique` (`hostname`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_stats_javascript` (
  `id` int(3) unsigned NOT NULL auto_increment,
  `support` enum('0','1') default '0',
  `count` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_stats_operatingsystem` (
  `id` int(6) unsigned NOT NULL auto_increment,
  `name` varchar(255) BINARY NOT NULL default '',
  `count` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `unique` (`name`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_stats_referer` (
  `id` int(8) unsigned NOT NULL auto_increment,
  `uri` varchar(255) BINARY NOT NULL default '',
  `timestamp` int(11) unsigned NOT NULL default '0',
  `count` mediumint(8) unsigned NOT NULL default '0',
  `sid` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `unique` (`uri`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_stats_requests` (
  `id` int(9) unsigned NOT NULL auto_increment,
  `timestamp` int(11) default '0',
  `pageId` int(6) unsigned NOT NULL default '0',
  `page` varchar(255) BINARY NOT NULL default '',
  `visits` int(9) unsigned NOT NULL default '0',
  `sid` varchar(32) NOT NULL default '',
  `pageTitle` varchar(250) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `unique` (`page`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_stats_requests_summary` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `type` varchar(10) NOT NULL default '',
  `timestamp` int(11) NOT NULL default '0',
  `count` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `unique` (`type`,`timestamp`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_stats_screenresolution` (
  `id` int(5) unsigned NOT NULL auto_increment,
  `resolution` varchar(11) NOT NULL default '',
  `count` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `unique` (`resolution`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_stats_search` (
  `id` int(5) unsigned NOT NULL auto_increment,
  `name` varchar(100) BINARY NOT NULL default '',
  `count` int(10) unsigned NOT NULL default '0',
  `sid` varchar(32) NOT NULL default '',
  `external` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `unique` (`name`,`external`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_stats_spiders` (
  `id` int(9) unsigned NOT NULL auto_increment,
  `last_indexed` int(14) default NULL,
  `page` varchar(100) BINARY default NULL,
  `pageId` mediumint(6) unsigned NOT NULL default '0',
  `count` int(11) NOT NULL default '0',
  `spider_useragent` varchar(255) default NULL,
  `spider_ip` varchar(100) default NULL,
  `spider_host` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `unique` (`page`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_stats_spiders_summary` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) BINARY NOT NULL default '',
  `timestamp` int(11) NOT NULL default '0',
  `count` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `unique` (`name`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_stats_visitors` (
  `id` int(8) unsigned NOT NULL auto_increment,
  `sid` varchar(32) NOT NULL default '',
  `timestamp` int(11) NOT NULL default '0',
  `client_ip` varchar(100) default NULL,
  `client_host` varchar(255) default NULL,
  `client_useragent` varchar(255) default NULL,
  `proxy_ip` varchar(100) default NULL,
  `proxy_host` varchar(255) default NULL,
  `proxy_useragent` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `unique` (`sid`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_stats_visitors_summary` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `type` varchar(10) NOT NULL default '',
  `timestamp` int(11) NOT NULL default '0',
  `count` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `unique` (`type`,`timestamp`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_voting_additionaldata` (
  `id` int(11) NOT NULL auto_increment,
  `nickname` varchar(80) NOT NULL default '',
  `surname` varchar(80) NOT NULL default '',
  `phone` varchar(80) NOT NULL default '',
  `street` varchar(80) NOT NULL default '',
  `zip` varchar(30) NOT NULL default '',
  `city` varchar(80) NOT NULL default '',
  `email` varchar(80) NOT NULL default '',
  `comment` text NOT NULL,
  `voting_system_id` int(11) NOT NULL default '0',
  `date_entered` timestamp NOT NULL ,
  `forename` varchar(80) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `voting_system_id` (`voting_system_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_voting_email` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `email` varchar(255) NOT NULL,
  `valid` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_voting_rel_email_system` (
  `email_id` int(10) unsigned NOT NULL default '0',
  `system_id` int(10) unsigned NOT NULL default '0',
  `voting_id` int(10) unsigned NOT NULL default '0',
  `valid` enum('0','1') NOT NULL default '0',
  UNIQUE KEY `email_id` (`email_id`,`system_id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_voting_results` (
  `id` int(11) NOT NULL auto_increment,
  `voting_system_id` int(11) default NULL,
  `question` char(200) default NULL,
  `votes` int(11) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `contrexx_voting_system` (
  `id` int(11) NOT NULL auto_increment,
  `date` timestamp NOT NULL ,
  `title` varchar(60) NOT NULL default '',
  `question` text ,
  `status` tinyint(1) default '1',
  `submit_check` enum('cookie','email') NOT NULL default 'cookie',
  `votes` int(11) default '0',
  `additional_nickname` tinyint(1) NOT NULL default '0',
  `additional_forename` tinyint(1) NOT NULL default '0',
  `additional_surname` tinyint(1) NOT NULL default '0',
  `additional_phone` tinyint(1) NOT NULL default '0',
  `additional_street` tinyint(1) NOT NULL default '0',
  `additional_zip` tinyint(1) NOT NULL default '0',
  `additional_email` tinyint(1) NOT NULL default '0',
  `additional_city` tinyint(1) NOT NULL default '0',
  `additional_comment` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;
