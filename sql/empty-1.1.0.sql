
-- -----------------------------------------------------
-- Table `glpi_plugin_dataflows_dataflows`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `glpi_plugin_dataflows_dataflows`;
CREATE  TABLE `glpi_plugin_dataflows_dataflows` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Internal ID' ,
  `entities_id` INT(11) NOT NULL default '0',
  `is_recursive` tinyint(1) NOT NULL default '0',
  `name` VARCHAR(45) NOT NULL COMMENT 'flow name (or code)' ,
  `plugin_dataflows_flowgroups_id` INT(11) NOT NULL default '0' COMMENT 'group name for similar flows ' ,
  `shortdescription` VARCHAR(100) NULL ,
  `longdescription` TINYTEXT NULL ,
  `plugin_dataflows_types_id` INT(11) NOT NULL default '0' COMMENT 'flow type : low, medium, high ...' ,
  `plugin_dataflows_indicators_id` INT(11) NOT NULL default '0' COMMENT 'flow indicators : undocumented, documented ...' ,
  `plugin_dataflows_states_id` INT(11) NOT NULL default '0' COMMENT 'flow status : active, closed, in development ...' ,
  `statedate` DATETIME NULL COMMENT 'validity date of flow status',
  `plugin_dataflows_servicelevels_id` INT(11) NOT NULL default '0' ,
  `plugin_dataflows_fromswcomponents_id` INT(11) NOT NULL default '0' COMMENT 'from swcomponent',
  `plugin_dataflows_toswcomponents_id` INT(11) NOT NULL default '0' COMMENT 'to swcomponent',
  `transferfrequency` VARCHAR(45) NULL ,
  `transfertimetable` VARCHAR(45) NULL ,
  `transfervolume` VARCHAR(45) NULL ,
  `transferpriority` VARCHAR(45) NULL ,
  `plugin_dataflows_transferprotocols_id` INT(11) NOT NULL default '0' ,
  `plugin_dataflows_sourceconnectors_id` INT(11) NOT NULL default '0' ,
  `extractmethod` VARCHAR(45) NULL ,
  `plugin_dataflows_destinationconnectors_id` INT(11) NOT NULL default '0' ,
  `loadmethod` VARCHAR(45) NULL ,
  `groups_id` INT(11) NOT NULL default '0' COMMENT 'data owner',
  `users_id` INT(11) NOT NULL default '0' COMMENT 'technical maintainer',
  `is_helpdesk_visible` int(11) NOT NULL default '1',
  `date_mod` datetime default NULL,
  `is_deleted` tinyint(1) NOT NULL default '0',
  PRIMARY KEY (`id`) ,
  KEY `entities_id` (`entities_id`),
  KEY `plugin_dataflows_flowgroups_id` (`plugin_dataflows_flowgroups_id`),
  KEY `plugin_dataflows_types_id` (`plugin_dataflows_types_id`),
  KEY `plugin_dataflows_indicators_id` (`plugin_dataflows_indicators_id`),
  KEY `plugin_dataflows_states_id` (`plugin_dataflows_states_id`),
  KEY `plugin_dataflows_servicelevels_id` (`plugin_dataflows_servicelevels_id`),
  KEY `plugin_dataflows_fromswcomponents_id` (`plugin_dataflows_fromswcomponents_id`),
  KEY `plugin_dataflows_toswcomponents_id` (`plugin_dataflows_toswcomponents_id`),
  KEY `plugin_dataflows_transferprotocols_id` (`plugin_dataflows_transferprotocols_id`),
  KEY `plugin_dataflows_sourceconnectors_id` (`plugin_dataflows_sourceconnectors_id`),
  KEY `plugin_dataflows_destinationconnectors_id` (`plugin_dataflows_destinationconnectors_id`),
  KEY `groups_id` (`groups_id`),
  KEY `users_id` (`users_id`),
  KEY is_helpdesk_visible (is_helpdesk_visible),
  KEY `is_deleted` (`is_deleted`),
  UNIQUE INDEX `flowname_UNIQUE` (`name` ASC) )
ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------------------------------------------
-- Table `glpi_plugin_dataflows_dataflows_items`
-- ----------------------------------------------------------------
DROP TABLE IF EXISTS `glpi_plugin_dataflows_dataflows_items`;
CREATE TABLE `glpi_plugin_dataflows_dataflows_items` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`plugin_dataflows_dataflows_id` int(11) NOT NULL default '0' COMMENT 'RELATION to glpi_plugin_dataflows_dataflows (id)',
	`items_id` int(11) NOT NULL default '0' COMMENT 'RELATION to various tables, according to itemtype (id)',
   `itemtype` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT 'see .class.php file',
	PRIMARY KEY  (`id`),
	UNIQUE KEY `unicity` (`plugin_dataflows_dataflows_id`,`items_id`,`itemtype`),
  KEY `FK_device` (`items_id`,`itemtype`),
  KEY `item` (`itemtype`,`items_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- -----------------------------------------------------
-- Table `glpi_plugin_dataflows_profiles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `glpi_plugin_dataflows_profiles`;
CREATE TABLE `glpi_plugin_dataflows_profiles` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`profiles_id` int(11) NOT NULL default '0' COMMENT 'RELATION to glpi_profiles (id)',
	`dataflows` char(1) collate utf8_unicode_ci default NULL,
	`open_ticket` char(1) collate utf8_unicode_ci default NULL,
	PRIMARY KEY  (`id`),
	KEY `profiles_id` (`profiles_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- -----------------------------------------------------
-- Table `glpi_plugin_dataflows_types`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `glpi_plugin_dataflows_types`;
CREATE  TABLE `glpi_plugin_dataflows_types` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `comment` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `glpi_plugin_dataflows_types_name` (`name` ASC) )
ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `glpi_plugin_dataflows_types` ( `id` , `name` , `comment` )  VALUES (1,'Low complexity','');
INSERT INTO `glpi_plugin_dataflows_types` ( `id` , `name` , `comment` )  VALUES (2,'Medium complexity','');
INSERT INTO `glpi_plugin_dataflows_types` ( `id` , `name` , `comment` )  VALUES (3,'High complexity','');

-- -----------------------------------------------------
-- Table `glpi_plugin_dataflows_indicators`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `glpi_plugin_dataflows_indicators`;
CREATE  TABLE `glpi_plugin_dataflows_indicators` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `comment` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `glpi_plugin_dataflows_indicators_name` (`name` ASC) )
ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `glpi_plugin_dataflows_indicators` ( `id` , `name` , `comment` )  VALUES (1,'No documentation','Undocumented');
INSERT INTO `glpi_plugin_dataflows_indicators` ( `id` , `name` , `comment` )  VALUES (2,'Partial documentation','Partially documented');
INSERT INTO `glpi_plugin_dataflows_indicators` ( `id` , `name` , `comment` )  VALUES (3,'Good documentation','Well documented');
-- -----------------------------------------------------
-- Table `glpi_plugin_dataflows_states`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `glpi_plugin_dataflows_states`;
CREATE  TABLE `glpi_plugin_dataflows_states` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `comment` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `glpi_plugin_dataflows_states_name` (`name` ASC) )
ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `glpi_plugin_dataflows_states` ( `id` , `name` , `comment` )  VALUES (1,'ACTIVE','Active');
INSERT INTO `glpi_plugin_dataflows_states` ( `id` , `name` , `comment` )  VALUES (2,'STOPPED','Stopped');
INSERT INTO `glpi_plugin_dataflows_states` ( `id` , `name` , `comment` )  VALUES (3,'DEVEL','In development');
INSERT INTO `glpi_plugin_dataflows_states` ( `id` , `name` , `comment` )  VALUES (4,'REMOVED','Removed');
-- -----------------------------------------------------
-- Table `glpi_plugin_dataflows_flowgroups`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `glpi_plugin_dataflows_flowgroups`;
CREATE  TABLE `glpi_plugin_dataflows_flowgroups` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL ,
  `comment` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `glpi_plugin_dataflows_flowgroup_name` (`name` ASC) )
ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `glpi_plugin_dataflows_servicelevels`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `glpi_plugin_dataflows_servicelevels`;
CREATE  TABLE `glpi_plugin_dataflows_servicelevels` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL ,
  `comment` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `glpi_plugin_dataflows_servicelevel_name` (`name` ASC) )
ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `glpi_plugin_dataflows_transferprotocols`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `glpi_plugin_dataflows_transferprotocols`;
CREATE  TABLE IF NOT EXISTS `glpi_plugin_dataflows_transferprotocols` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL ,
  `comment` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `glpi_plugin_dataflows_transferprotocol_name` (`name` ASC) )
ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- -----------------------------------------------------
-- Table `glpi_plugin_dataflows_sourceconnectors`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `glpi_plugin_dataflows_sourceconnectors`;
CREATE  TABLE IF NOT EXISTS `glpi_plugin_dataflows_sourceconnectors` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL ,
  `comment` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `glpi_plugin_dataflows_sourceconnector_name` (`name` ASC) )
ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- -----------------------------------------------------
-- Table `glpi_plugin_dataflows_destinationconnectors`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `glpi_plugin_dataflows_destinationconnectors`;
CREATE OR REPLACE VIEW glpi_plugin_dataflows_destinationconnectors as
SELECT `id`,`name`, `comment` FROM glpi_plugin_dataflows_sourceconnectors

-- -----------------------------------------------------
-- View `glpi_plugin_dataflows_fromswcomponents`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `glpi_plugin_dataflows_fromswcomponents`;
CREATE OR REPLACE VIEW `glpi_plugin_dataflows_fromswcomponents` (`id`,`name`, `comment`) AS
SELECT `id`,`completename`, `comment` from `glpi_plugin_archisw_swcomponents` where level = '1';

-- -----------------------------------------------------
-- View `glpi_plugin_dataflows_toswcomponents`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `glpi_plugin_dataflows_toswcomponents`;
CREATE OR REPLACE VIEW `glpi_plugin_dataflows_toswcomponents` (`id`,`name`, `comment`) AS
SELECT `id`,`completename`, `comment` from `glpi_plugin_archisw_swcomponents` where level = '1';

INSERT INTO `glpi_displaypreferences` VALUES (NULL,'PluginDataflowsDataflow','2','2','0');
INSERT INTO `glpi_displaypreferences` VALUES (NULL,'PluginDataflowsDataflow','6','3','0');
INSERT INTO `glpi_displaypreferences` VALUES (NULL,'PluginDataflowsDataflow','7','4','0');
	
