
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
  `longdescription` TEXT NULL ,
  `plugin_dataflows_types_id` INT(11) NOT NULL default '0' COMMENT 'flow type : low, medium, high ...' ,
  `plugin_dataflows_indicators_id` INT(11) NOT NULL default '0' COMMENT 'flow indicators : undocumented, documented ...' ,
  `plugin_dataflows_states_id` INT(11) NOT NULL default '0' COMMENT 'flow status : active, closed, in development ...' ,
  `statedate` DATETIME NULL COMMENT 'validity date of flow status',
  `plugin_dataflows_servicelevels_id` INT(11) NOT NULL default '0' ,
  `plugin_dataflows_modes_id` INT(11) NOT NULL default '0' ,
  `plugin_dataflows_patterns_id` INT(11) NOT NULL default '0' ,
--  `plugin_dataflows_fromcredentials_id` INT(11) NOT NULL default '0' ,
--  `plugin_dataflows_tocredentials_id` INT(11) NOT NULL default '0' ,
  `plugin_dataflows_fromswcomponents_id` INT(11) NOT NULL default '0' COMMENT 'from swcomponent',
  `plugin_dataflows_toswcomponents_id` INT(11) NOT NULL default '0' COMMENT 'to swcomponent',
  `plugin_dataflows_fromexternal` VARCHAR(100) NULL COMMENT 'from external address',
  `plugin_dataflows_toexternal` VARCHAR(100) NULL COMMENT 'to external address',
  `plugin_dataflows_fromcredentials_id` INT(11) NOT NULL default '0' ,
  `plugin_dataflows_tocredentials_id` INT(11) NOT NULL default '0' ,
  `plugin_dataflows_triggertypes_id` INT(11) NOT NULL default '0' ,
  `triggerformat` varchar(100) default NULL,
  `plugin_dataflows_transferfreqs_id` INT(11) NOT NULL default '0' ,
  `plugin_dataflows_transfertimetables_id` INT(11) NOT NULL default '0' ,
  `plugin_dataflows_holidayactions_id` INT(11) NOT NULL default '0' ,
  `transfervolume` VARCHAR(45) NULL ,
  `transferpriority` VARCHAR(45) NULL ,
  `plugin_dataflows_transferprotocols_id` INT(11) NOT NULL default '0' ,
  `plugin_dataflows_sourceconnectors_id` INT(11) NOT NULL default '0' ,
  `extractmethod` TINYTEXT NULL ,
  `srcformat` TINYTEXT NULL,
  `srcstructure` MEDIUMTEXT NULL ,
  `plugin_dataflows_srcuris_id` INT(11) NOT NULL default '0' ,
  `plugin_dataflows_srcuri` VARCHAR(100) NULL,
  `plugin_dataflows_srcpreprocs_id` INT(11) NOT NULL default '0' ,
  `plugin_dataflows_destinationconnectors_id` INT(11) NOT NULL default '0' ,
  `loadmethod` TINYTEXT NULL ,
  `destformat` TINYTEXT NULL,
  `deststructure` MEDIUMTEXT NULL ,
  `plugin_dataflows_desturis_id` INT(11) NOT NULL default '0' ,
  `plugin_dataflows_desturi` VARCHAR(100) NULL ,
  `plugin_dataflows_destpostprocs_id` INT(11) NOT NULL default '0' ,
  `plugin_dataflows_errorhandlings_id` INT(11) NOT NULL default '0' ,
  `mappingdocurl` varchar(255) default NULL,
  `technicaldocurl` varchar(255) default NULL,
  `groups_id` INT(11) NOT NULL default '0' COMMENT 'data owner',
  `plugin_dataflows_othergroups_id` INT(11) NOT NULL default '0' COMMENT 'other group',
  `plugin_dataflows_supportgroups_id` INT(11) NOT NULL default '0' COMMENT 'other group',
  `users_id` INT(11) NOT NULL default '0' COMMENT 'technical maintainer',
  `plugin_dataflows_otherusers_id` INT(11) NOT NULL default '0' COMMENT 'other user',
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
  KEY `plugin_dataflows_modes_id` (`plugin_dataflows_modes_id`),
  KEY `plugin_dataflows_patterns_id` (`plugin_dataflows_patterns_id`),
  KEY `plugin_dataflows_fromswcomponents_id` (`plugin_dataflows_fromswcomponents_id`),
  KEY `plugin_dataflows_toswcomponents_id` (`plugin_dataflows_toswcomponents_id`),
  KEY `plugin_dataflows_fromcredentials_id` (`plugin_dataflows_fromcredentials_id`),
  KEY `plugin_dataflows_tocredentials_id` (`plugin_dataflows_tocredentials_id`),
  KEY `plugin_dataflows_triggertypes_id` (`plugin_dataflows_triggertypes_id`),
  KEY `plugin_dataflows_transferfreqs_id` (`plugin_dataflows_transferfreqs_id`),
  KEY `plugin_dataflows_transfertimetables_id` (`plugin_dataflows_transfertimetables_id`),
  KEY `plugin_dataflows_holidayactions_id` (`plugin_dataflows_holidayactions_id`),
  KEY `plugin_dataflows_transferprotocols_id` (`plugin_dataflows_transferprotocols_id`),
  KEY `plugin_dataflows_sourceconnectors_id` (`plugin_dataflows_sourceconnectors_id`),
  KEY `plugin_dataflows_srcuris_id` (`plugin_dataflows_srcuris_id`),
  KEY `plugin_dataflows_srcpreprocs_id` (`plugin_dataflows_srcpreprocs_id`),
  KEY `plugin_dataflows_destinationconnectors_id` (`plugin_dataflows_destinationconnectors_id`),
  KEY `plugin_dataflows_desturis_id` (`plugin_dataflows_desturis_id`),
  KEY `plugin_dataflows_destpostprocs_id` (`plugin_dataflows_destpostprocs_id`),
  KEY `plugin_dataflows_errorhandlings_id` (`plugin_dataflows_errorhandlings_id`),
  KEY `groups_id` (`groups_id`),
  KEY `users_id` (`users_id`),
  KEY `plugin_dataflows_othergroups_id` (`plugin_dataflows_othergroups_id`),
  KEY `plugin_dataflows_supportgroups_id` (`plugin_dataflows_supportgroups_id`),
  KEY `plugin_dataflows_otherusers_id` (`plugin_dataflows_otherusers_id`),
  KEY is_helpdesk_visible (is_helpdesk_visible),
  KEY `is_deleted` (`is_deleted`),
  UNIQUE INDEX `flowname_UNIQUE` (`name` ASC, `plugin_dataflows_transferprotocols_id` ASC) )
DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
)
DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
)
DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


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
DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `glpi_plugin_dataflows_modes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `glpi_plugin_dataflows_modes`;
CREATE  TABLE `glpi_plugin_dataflows_modes` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL ,
  `comment` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `glpi_plugin_dataflows_mode_name` (`name` ASC) )
DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `glpi_plugin_dataflows_modes` ( `id` , `name` , `comment` )  VALUES (1,'Full transfer','');
INSERT INTO `glpi_plugin_dataflows_modes` ( `id` , `name` , `comment` )  VALUES (2,'Delta transfer','');

-- -----------------------------------------------------
-- Table `glpi_plugin_dataflows_patterns`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `glpi_plugin_dataflows_patterns`;
CREATE  TABLE `glpi_plugin_dataflows_patterns` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL ,
  `comment` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `glpi_plugin_dataflows_pattern_name` (`name` ASC) )
DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `glpi_plugin_dataflows_patterns` ( `id` , `name` , `comment` )  VALUES (1,'Guaranteed delivery','');
INSERT INTO `glpi_plugin_dataflows_patterns` ( `id` , `name` , `comment` )  VALUES (2,'Fire and forget','');
INSERT INTO `glpi_plugin_dataflows_patterns` ( `id` , `name` , `comment` )  VALUES (3,'Request-Reply, synchronous','');
INSERT INTO `glpi_plugin_dataflows_patterns` ( `id` , `name` , `comment` )  VALUES (4,'Request-Reply, asynchronous','');

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
DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- -----------------------------------------------------
-- Table `glpi_plugin_dataflows_destinationconnectors`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `glpi_plugin_dataflows_destinationconnectors`;
CREATE OR REPLACE VIEW glpi_plugin_dataflows_destinationconnectors as
SELECT `id`,`name`, `comment` FROM glpi_plugin_dataflows_sourceconnectors;

-- -----------------------------------------------------
-- View `glpi_plugin_dataflows_fromswcomponents`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `glpi_plugin_dataflows_fromswcomponents`;
CREATE OR REPLACE VIEW `glpi_plugin_dataflows_fromswcomponents` (`id`, `entities_id`, `name`, `comment`) AS
SELECT `id`, `entities_id`, `completename`, `comment` from `glpi_plugin_archisw_swcomponents` where level = '1';

-- -----------------------------------------------------
-- View `glpi_plugin_dataflows_toswcomponents`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `glpi_plugin_dataflows_toswcomponents`;
CREATE OR REPLACE VIEW `glpi_plugin_dataflows_toswcomponents` (`id`, `entities_id`, `name`, `comment`) AS
SELECT `id`, `entities_id`, `completename`, `comment` from `glpi_plugin_archisw_swcomponents` where level = '1';

-- -----------------------------------------------------
-- View `glpi_plugin_dataflows_fromcomputers`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `glpi_plugin_dataflows_fromcomputers`;
CREATE OR REPLACE VIEW `glpi_plugin_dataflows_fromcomputers` (`id`, `entities_id`, `name`, `comment`) AS
SELECT `id`, `entities_id`, `name`, `comment` from `glpi_computers`;

-- -----------------------------------------------------
-- View `glpi_plugin_dataflows_tocomputers`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `glpi_plugin_dataflows_tocomputers`;
CREATE OR REPLACE VIEW `glpi_plugin_dataflows_tocomputers` (`id`, `entities_id`, `name`, `comment`) AS
SELECT `id`, `entities_id`, `name`, `comment` from `glpi_computers`;

-- -----------------------------------------------------
-- View `glpi_plugin_dataflows_othergroups`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `glpi_plugin_dataflows_othergroups`;
CREATE OR REPLACE VIEW `glpi_plugin_dataflows_othergroups` AS
SELECT * from `glpi_groups`;

-- -----------------------------------------------------
-- View `glpi_plugin_dataflows_supportgroups`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `glpi_plugin_dataflows_supportgroups`;
CREATE OR REPLACE VIEW `glpi_plugin_dataflows_supportgroups` AS
SELECT * from `glpi_groups`;

-- -----------------------------------------------------
-- View `glpi_plugin_dataflows_otherusers`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `glpi_plugin_dataflows_otherusers`;
CREATE OR REPLACE VIEW `glpi_plugin_dataflows_otherusers` AS
SELECT * from `glpi_users`;

-- -----------------------------------------------------
-- Table `plugin_dataflows_triggertypes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `glpi_plugin_dataflows_triggertypes`;
CREATE  TABLE IF NOT EXISTS `glpi_plugin_dataflows_triggertypes` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL ,
  `comment` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `plugin_dataflows_triggertype_name` (`name` ASC) )
DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
insert glpi_plugin_dataflows_triggertypes (name,comment) values 
('FILE','Flow triggered by file presence'),
('EVENTJMS','Flow triggered by JMS event message');

-- -----------------------------------------------------
-- Table `plugin_dataflows_transferfreqs`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `glpi_plugin_dataflows_transferfreqs`;
CREATE  TABLE IF NOT EXISTS `glpi_plugin_dataflows_transferfreqs` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL ,
  `comment` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `plugin_dataflows_transferfreq_name` (`name` ASC) )
DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- -----------------------------------------------------
-- Table `plugin_dataflows_transfertimetables`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `glpi_plugin_dataflows_transfertimetables`;
CREATE  TABLE IF NOT EXISTS `glpi_plugin_dataflows_transfertimetables` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL ,
  `comment` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `plugin_dataflows_transfertimetable_name` (`name` ASC) )
DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- -----------------------------------------------------
-- Table `plugin_dataflows_holidayactions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `glpi_plugin_dataflows_holidayactions`;
CREATE  TABLE IF NOT EXISTS `glpi_plugin_dataflows_holidayactions` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL ,
  `comment` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `plugin_dataflows_holidayaction_name` (`name` ASC) )
DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- -----------------------------------------------------
-- Table `plugin_dataflows_srcuris`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `glpi_plugin_dataflows_srcuris`;
CREATE  TABLE IF NOT EXISTS `glpi_plugin_dataflows_srcuris` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL ,
  `comment` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `plugin_dataflows_srcuri_name` (`name` ASC) )
DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- -----------------------------------------------------
-- Table `plugin_dataflows_srcpreprocs`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `glpi_plugin_dataflows_srcpreprocs`;
CREATE  TABLE IF NOT EXISTS `glpi_plugin_dataflows_srcpreprocs` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL ,
  `comment` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `plugin_dataflows_srcpreproc_name` (`name` ASC) )
DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- -----------------------------------------------------
-- Table `plugin_dataflows_desturis`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `glpi_plugin_dataflows_desturis`;
CREATE  TABLE IF NOT EXISTS `glpi_plugin_dataflows_desturis` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL ,
  `comment` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `plugin_dataflows_desturi_name` (`name` ASC) )
DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- -----------------------------------------------------
-- Table `plugin_dataflows_destpostprocs`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `glpi_plugin_dataflows_destpostprocs`;
CREATE  TABLE IF NOT EXISTS `glpi_plugin_dataflows_destpostprocs` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL ,
  `comment` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `plugin_dataflows_destpostproc_name` (`name` ASC) )
DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- -----------------------------------------------------
-- Table `plugin_dataflows_errorhandlings`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `glpi_plugin_dataflows_errorhandlings`;
CREATE  TABLE IF NOT EXISTS `glpi_plugin_dataflows_errorhandlings` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL ,
  `comment` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `plugin_dataflows_errorhandling_name` (`name` ASC) )
DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `glpi_displaypreferences` VALUES (NULL,'PluginDataflowsDataflow','2','2','0');
INSERT INTO `glpi_displaypreferences` VALUES (NULL,'PluginDataflowsDataflow','6','3','0');
INSERT INTO `glpi_displaypreferences` VALUES (NULL,'PluginDataflowsDataflow','7','4','0');
	
