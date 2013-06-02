DROP TABLE IF EXISTS `wp_user_locations`;
CREATE TABLE `wp_user_locations` (
	`id` int(11) NOT NULL AUTO_INCREMENT,

	`name` char(64) NOT NULL DEFAULT '',
	`address_1` char(64) NOT NULL DEFAULT '',
	`address_2` char(64) NOT NULL DEFAULT '',
	`city` char(64) NOT NULL DEFAULT '',
	`state` char(2) NOT NULL DEFAULT '',
	`zip` char(10) NOT NULL DEFAULT '',

-- More to come from the GEO data needs

	`created` datetime DEFAULT NULL,
	`created_by` int(11) NOT NULL DEFAULT '0',
	`modified` datetime DEFAULT NULL,
	`modified_by` int(11) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;



DROP TABLE IF EXISTS `wp_properties`;
CREATE TABLE `wp_properties` (
	`id` int(11) NOT NULL AUTO_INCREMENT,

	`hash` char(32) NOT NULL DEFAULT '',

	`status` int(1) NOT NULL DEFAULT '0',

	`address_line_1` char(64) NOT NULL DEFAULT '',
	`city` char(64) NOT NULL DEFAULT '',
	`state` char(24) NOT NULL DEFAULT '',
	`zip` char(11) NOT NULL DEFAULT '',
	`latitude` char(64) NOT NULL DEFAULT '',
	`longitude` char(64) NOT NULL DEFAULT '',

	`311_case_id` char(64) NOT NULL DEFAULT '',
	`311_name` char(24) NOT NULL DEFAULT '',
	`311_case_summary` char(24) NOT NULL DEFAULT '',
	`311_creation_date` char(24) NOT NULL DEFAULT '',
	`311_close_date` char(24) NOT NULL DEFAULT '',
	`311_status` char(24) NOT NULL DEFAULT '',
	`311_address` char(24) NOT NULL DEFAULT '',
	`311_postal` char(24) NOT NULL DEFAULT '',
	`311_pin` char(24) NOT NULL DEFAULT '',
	`311_xcoordinate` char(24) NOT NULL DEFAULT '',
	`311_ycoordinate` char(24) NOT NULL DEFAULT '',


-- More to come from the GEO data

	`created` datetime DEFAULT NULL,
	`created_by` int(11) NOT NULL DEFAULT '0',
	`modified` datetime DEFAULT NULL,
	`modified_by` int(11) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`),
	KEY (`hash`),
	KEY (`311_case_id`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- 
-- Record get added to this table at two times
-- 
--   1) When a new demo is found
--   2) When a user signs up, and request an email of existing demolitions
-- 
-- 
DROP TABLE IF EXISTS `wp_maillist`;
CREATE TABLE `wp_maillist` (
	`id` int(11) NOT NULL AUTO_INCREMENT,

	`wp_user_location_id` int(11) NOT NULL DEFAULT 0,
	`wp_property_id` int(11) NOT NULL DEFAULT 0,

-- To send, Sent
	`status` int(10) NOT NULL DEFAULT 0,

-- Yes, No
	`reply` int(10) NOT NULL DEFAULT 0,

	`created` datetime DEFAULT NULL,
	`created_by` int(11) NOT NULL DEFAULT '0',
	`modified` datetime DEFAULT NULL,
	`modified_by` int(11) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;


