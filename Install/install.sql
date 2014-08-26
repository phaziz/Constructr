CREATE TABLE IF NOT EXISTS `constructr_backenduser` (
  `beu_id` int(25) NOT NULL AUTO_INCREMENT,
  `beu_username` varchar(255) COLLATE latin1_german2_ci NOT NULL,
  `beu_password` varchar(255) COLLATE latin1_german2_ci NOT NULL,
  `beu_email` varchar(255) COLLATE latin1_german2_ci NOT NULL,
  `beu_art` int(1) NOT NULL,
  `beu_last_login` datetime NOT NULL,
  `beu_active` int(1) NOT NULL,
  UNIQUE KEY `beu_id` (`beu_id`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `constructr_backenduser_rights` (
  `cbr_id` int(25) NOT NULL AUTO_INCREMENT,
  `cbr_right` int(11) NOT NULL,
  `cbr_value` int(1) NOT NULL DEFAULT '0',
  `cbr_user_id` int(25) NOT NULL,
  `cbr_info` text NOT NULL,
  PRIMARY KEY (`cbr_id`),
  UNIQUE KEY `cbr_id` (`cbr_id`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `constructr_config` (
  `constructr_config_id` int(20) NOT NULL AUTO_INCREMENT,
  `constructr_config_expression` varchar(200) NOT NULL,
  `constructr_config_value` varchar(200) NOT NULL,
  PRIMARY KEY (`constructr_config_id`),
  UNIQUE KEY `constructr_config_id` (`constructr_config_id`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `constructr_content` (
  `content_id` int(11) NOT NULL AUTO_INCREMENT,
  `content_order` int(11) NOT NULL DEFAULT '0',
  `content_page_id` int(11) NOT NULL,
  `content_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `content_content` text NOT NULL,
  `content_temp_marker` int(10) NOT NULL DEFAULT '0',
  `content_active` int(11) NOT NULL DEFAULT '1',
  `content_deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`content_id`),
  UNIQUE KEY `content_id` (`content_id`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `constructr_content_history` (
  `content_id` int(11) NOT NULL AUTO_INCREMENT,
  `content_page_id` int(11) NOT NULL,
  `content_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `content_content` text NOT NULL,
  `content_content_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`content_id`),
  UNIQUE KEY `content_id` (`content_id`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `constructr_media` (
  `media_id` int(255) NOT NULL AUTO_INCREMENT,
  `media_datetime` datetime NOT NULL,
  `media_file` varchar(255) NOT NULL,
  `media_originalname` varchar(255) NOT NULL,
  `media_description` text NOT NULL,
  `media_title` varchar(255) NOT NULL,
  `media_keywords` text NOT NULL,
  `media_copyright` varchar(255) NOT NULL,
  PRIMARY KEY (`media_id`),
  UNIQUE KEY `media_id` (`media_id`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `constructr_pages` (
  `pages_id` int(20) NOT NULL AUTO_INCREMENT,
  `pages_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pages_name` varchar(100) NOT NULL DEFAULT 'PAGE_NAME',
  `pages_url` varchar(255) NOT NULL DEFAULT 'PAGE_URL',
  `pages_template` varchar(50) NOT NULL DEFAULT 'index.php',
  `pages_title` varchar(255) NOT NULL,
  `pages_description` text NOT NULL,
  `pages_keywords` text NOT NULL,
  `pages_lft` int(100) NOT NULL DEFAULT '0',
  `pages_rgt` int(100) NOT NULL DEFAULT '0',
  `pages_active` int(1) NOT NULL DEFAULT '0',
  `pages_nav_visible` int(1) NOT NULL DEFAULT '1',
  `pages_temp_marker` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pages_id`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `constructr_plugins` (
  `plugin_id` int(255) NOT NULL AUTO_INCREMENT,
  `plugin_name` varchar(255) NOT NULL,
  `plugin_status` int(1) NOT NULL,
  PRIMARY KEY (`plugin_id`)
) ENGINE=MyISAM;