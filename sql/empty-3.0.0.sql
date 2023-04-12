
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
  `plugin_dataflows_fromcredentials_id` INT(11) NOT NULL default '0',
  `plugin_dataflows_tocredentials_id` INT(11) NOT NULL default '0',
  `plugin_dataflows_fromauthtypes_id` INT(11) NOT NULL default '0' COMMENT 'source authentication type',
  `plugin_dataflows_toauthtypes_id` INT(11) NOT NULL default '0' COMMENT 'destination authentication type',
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
  `plugin_dataflows_srcstructuretypes_id` INT(11) NOT NULL default '0' COMMENT 'source structure type',
  `srcstructure` MEDIUMTEXT NULL ,
  `plugin_dataflows_srcuris_id` INT(11) NOT NULL default '0' ,
  `plugin_dataflows_srcuri` VARCHAR(100) NULL,
  `plugin_dataflows_srcpreprocs_id` INT(11) NOT NULL default '0' ,
  `plugin_dataflows_destinationconnectors_id` INT(11) NOT NULL default '0' ,
  `loadmethod` TINYTEXT NULL ,
  `destformat` TINYTEXT NULL,
  `plugin_dataflows_deststructuretypes_id` INT(11) NOT NULL default '0' COMMENT 'destination structure type',
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
  KEY `plugin_dataflows_fromauthtypes_id` (`plugin_dataflows_fromauthtypes_id`),
  KEY `plugin_dataflows_toauthtypes_id` (`plugin_dataflows_toauthtypes_id`),
  KEY `plugin_dataflows_triggertypes_id` (`plugin_dataflows_triggertypes_id`),
  KEY `plugin_dataflows_transferfreqs_id` (`plugin_dataflows_transferfreqs_id`),
  KEY `plugin_dataflows_transfertimetables_id` (`plugin_dataflows_transfertimetables_id`),
  KEY `plugin_dataflows_holidayactions_id` (`plugin_dataflows_holidayactions_id`),
  KEY `plugin_dataflows_transferprotocols_id` (`plugin_dataflows_transferprotocols_id`),
  KEY `plugin_dataflows_sourceconnectors_id` (`plugin_dataflows_sourceconnectors_id`),
  KEY `plugin_dataflows_srcuris_id` (`plugin_dataflows_srcuris_id`),
  KEY `plugin_dataflows_srcstructuretypes_id` (`plugin_dataflows_srcstructuretypes_id`),
  KEY `plugin_dataflows_srcpreprocs_id` (`plugin_dataflows_srcpreprocs_id`),
  KEY `plugin_dataflows_destinationconnectors_id` (`plugin_dataflows_destinationconnectors_id`),
  KEY `plugin_dataflows_desturis_id` (`plugin_dataflows_desturis_id`),
  KEY `plugin_dataflows_deststructuretypes_id` (`plugin_dataflows_deststructuretypes_id`),
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
DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------
-- Table `glpi_plugin_dataflows_dataflows_items`
-- ----------------------------------------------------------------
DROP TABLE IF EXISTS `glpi_plugin_dataflows_dataflows_items`;
CREATE TABLE `glpi_plugin_dataflows_dataflows_items` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`plugin_dataflows_dataflows_id` int(11) NOT NULL default '0' COMMENT 'RELATION to glpi_plugin_dataflows_dataflows (id)',
	`items_id` int(11) NOT NULL default '0' COMMENT 'RELATION to various tables, according to itemtype (id)',
   `itemtype` varchar(100) collate utf8mb4_unicode_ci NOT NULL COMMENT 'see .class.php file',
	PRIMARY KEY  (`id`),
	UNIQUE KEY `unicity` (`plugin_dataflows_dataflows_id`,`items_id`,`itemtype`),
  KEY `FK_device` (`items_id`,`itemtype`),
  KEY `item` (`itemtype`,`items_id`)
)
DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- Table `glpi_plugin_dataflows_profiles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `glpi_plugin_dataflows_profiles`;
CREATE TABLE `glpi_plugin_dataflows_profiles` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`profiles_id` int(11) NOT NULL default '0' COMMENT 'RELATION to glpi_profiles (id)',
	`dataflows` char(1) collate utf8mb4_unicode_ci default NULL,
	`open_ticket` char(1) collate utf8mb4_unicode_ci default NULL,
	PRIMARY KEY  (`id`),
	KEY `profiles_id` (`profiles_id`)
)
DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


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
DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


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
DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- Table `glpi_plugin_dataflows_srcstructuretypes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `glpi_plugin_dataflows_srcstructuretypes`;
CREATE  TABLE IF NOT EXISTS `glpi_plugin_dataflows_srcstructuretypes` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL ,
  `comment` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `glpi_plugin_dataflows_srcstructuretype_name` (`name` ASC) )
DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `glpi_plugin_dataflows_srcstructuretypes` ( `id` , `name` , `comment` ) VALUES (1,'XSD','XML Schema Definition');

-- -----------------------------------------------------
-- Table `glpi_plugin_dataflows_deststructuretypes`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `glpi_plugin_dataflows_deststructuretypes`;
CREATE OR REPLACE VIEW glpi_plugin_dataflows_deststructuretypes as
SELECT `id`,`name`, `comment` FROM glpi_plugin_dataflows_srcstructuretypes;

-- -----------------------------------------------------
-- Table `glpi_plugin_dataflows_fromauthtypes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `glpi_plugin_dataflows_fromauthtypes`;
CREATE  TABLE IF NOT EXISTS `glpi_plugin_dataflows_fromauthtypes` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL ,
  `comment` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `glpi_plugin_dataflows_fromauthtype_name` (`name` ASC) )
DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `glpi_plugin_dataflows_fromauthtypes` ( `id` , `name` , `comment` ) VALUES (1,'Basic authentication','Login/Password');

-- -----------------------------------------------------
-- Table `glpi_plugin_dataflows_toauthtypes`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `glpi_plugin_dataflows_toauthtypes`;
CREATE OR REPLACE VIEW glpi_plugin_dataflows_toauthtypes as
SELECT `id`,`name`, `comment` FROM glpi_plugin_dataflows_fromauthtypes;
	
-- -----------------------------------------------------
-- Table `glpi_plugin_dataflows_configdffieldgroups`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `glpi_plugin_dataflows_configdffieldgroups`;
CREATE  TABLE `glpi_plugin_dataflows_configdffieldgroups` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL,
  `comment` VARCHAR(45) NULL,
  `sortorder` TINYINT UNSIGNED NOT NULL,
  `is_visible` TINYINT UNSIGNED NOT NULL COMMENT '0=False/1=True',
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `plugin_dataflows_configdffieldgroups_name` (`name` ASC) )
 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `glpi_plugin_dataflows_configdffieldgroups` (`id` ,`name` ,`comment` ,`sortorder` ,`is_visible`)  VALUES (1,'A_main','Main characteristics',1,1);
INSERT INTO `glpi_plugin_dataflows_configdffieldgroups` (`id` ,`name` ,`comment` ,`sortorder` ,`is_visible`)  VALUES (2,'B_detail','Detailed characteristics',2,1);
INSERT INTO `glpi_plugin_dataflows_configdffieldgroups` (`id` ,`name` ,`comment` ,`sortorder` ,`is_visible`)  VALUES (3,'C_operation','Operational characteristics',3,1);
INSERT INTO `glpi_plugin_dataflows_configdffieldgroups` (`id` ,`name` ,`comment` ,`sortorder` ,`is_visible`)  VALUES (4,'D_contact','Contacts',4,1);

-- -----------------------------------------------------
-- Table `glpi_plugin_dataflows_configdfhaligns`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `glpi_plugin_dataflows_configdfhaligns`;
CREATE  TABLE `glpi_plugin_dataflows_configdfhaligns` (
  `id` INT(11) UNSIGNED NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `plugin_dataflows_configdfhaligns_name` (`name`) )
 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `glpi_plugin_dataflows_configdfhaligns` (`id` ,`name`)  VALUES ('1','Full row');
INSERT INTO `glpi_plugin_dataflows_configdfhaligns` (`id` ,`name`)  VALUES ('2','Left column');
INSERT INTO `glpi_plugin_dataflows_configdfhaligns` (`id` ,`name`)  VALUES ('3','Left+Center columns');
INSERT INTO `glpi_plugin_dataflows_configdfhaligns` (`id` ,`name`)  VALUES ('4','Center column');
INSERT INTO `glpi_plugin_dataflows_configdfhaligns` (`id` ,`name`)  VALUES ('5','Center+Right columns');
INSERT INTO `glpi_plugin_dataflows_configdfhaligns` (`id` ,`name`)  VALUES ('6','Right column');
INSERT INTO `glpi_plugin_dataflows_configdfhaligns` (`id` ,`name`)  VALUES ('7','Straddling 2 columns');

-- -----------------------------------------------------
-- Table `glpi_plugin_dataflows_configdfdbfieldtypes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `glpi_plugin_dataflows_configdfdbfieldtypes`;
CREATE  TABLE `glpi_plugin_dataflows_configdfdbfieldtypes` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL,
  `comment` VARCHAR(255) NULL,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `plugin_dataflows_configdfdbfieldtypes_name` (`name` ASC) )
 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `glpi_plugin_dataflows_configdfdbfieldtypes` (`id` ,`name` ,`comment`)  VALUES (10,'INT UNSIGNED','Unsigned Integer (range 0 to 4294967295');
INSERT INTO `glpi_plugin_dataflows_configdfdbfieldtypes` (`id` ,`name` ,`comment`)  VALUES (11,'TINYINT UNSIGNED','Unsigned Tiny Integer (range 0 to 255)');
INSERT INTO `glpi_plugin_dataflows_configdfdbfieldtypes` (`id` ,`name` ,`comment`)  VALUES (12,'SMALLINT UNSIGNED','Unsigned Small Integer (range 0 to 65535)');
INSERT INTO `glpi_plugin_dataflows_configdfdbfieldtypes` (`id` ,`name` ,`comment`)  VALUES (20,'INT','Integer (range -2147483648 to 2147483647');
INSERT INTO `glpi_plugin_dataflows_configdfdbfieldtypes` (`id` ,`name` ,`comment`)  VALUES (21,'TINYINT','Tiny Integer (range -128 to 127)');
INSERT INTO `glpi_plugin_dataflows_configdfdbfieldtypes` (`id` ,`name` ,`comment`)  VALUES (22,'SMALLINT','Small Integer (range -32768 to 32767)');
INSERT INTO `glpi_plugin_dataflows_configdfdbfieldtypes` (`id` ,`name` ,`comment`)  VALUES (30,'VARCHAR(255)','Variable character string (max. 255 char.)');
INSERT INTO `glpi_plugin_dataflows_configdfdbfieldtypes` (`id` ,`name` ,`comment`)  VALUES (31,'TEXT','Variable character string (max. 65535 char.)');
INSERT INTO `glpi_plugin_dataflows_configdfdbfieldtypes` (`id` ,`name` ,`comment`)  VALUES (32,'MEDIUMTEXT','Variable character string (max. 16777215 char.)');
INSERT INTO `glpi_plugin_dataflows_configdfdbfieldtypes` (`id` ,`name` ,`comment`)  VALUES (40,'DATETIME','Date and time');
INSERT INTO `glpi_plugin_dataflows_configdfdbfieldtypes` (`id` ,`name` ,`comment`)  VALUES (41,'DATE','Date (YYYY-MM-DD)');
INSERT INTO `glpi_plugin_dataflows_configdfdbfieldtypes` (`id` ,`name` ,`comment`)  VALUES (42,'TIME','Year (hhh:mm:ss)');
INSERT INTO `glpi_plugin_dataflows_configdfdbfieldtypes` (`id` ,`name` ,`comment`)  VALUES (43,'YEAR','Year (YYYY)');

-- -----------------------------------------------------
-- Table `glpi_plugin_dataflows_configdfdatatypes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `glpi_plugin_dataflows_configdfdatatypes`;
CREATE  TABLE `glpi_plugin_dataflows_configdfdatatypes` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL,
  `comment` VARCHAR(255) NULL,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `plugin_dataflows_configdfdatatypes_name` (`name` ASC) )
 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `glpi_plugin_dataflows_configdfdatatypes` (`id` ,`name` ,`comment`)  VALUES (1,'text','Text');
INSERT INTO `glpi_plugin_dataflows_configdfdatatypes` (`id` ,`name` ,`comment`)  VALUES (2,'bool','Boolean');
INSERT INTO `glpi_plugin_dataflows_configdfdatatypes` (`id` ,`name` ,`comment`)  VALUES (3,'date','Date');
INSERT INTO `glpi_plugin_dataflows_configdfdatatypes` (`id` ,`name` ,`comment`)  VALUES (4,'datetime','Date and time');
INSERT INTO `glpi_plugin_dataflows_configdfdatatypes` (`id` ,`name` ,`comment`)  VALUES (5,'number','Key or number');
INSERT INTO `glpi_plugin_dataflows_configdfdatatypes` (`id` ,`name` ,`comment`)  VALUES (6,'dropdown','Dropdown');
INSERT INTO `glpi_plugin_dataflows_configdfdatatypes` (`id` ,`name` ,`comment`)  VALUES (7,'itemlink','Itemlink');
INSERT INTO `glpi_plugin_dataflows_configdfdatatypes` (`id` ,`name` ,`comment`)  VALUES (8,'textarea','Text editor');

-- -----------------------------------------------------
-- Table `glpi_plugin_dataflows_configdflinks`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `glpi_plugin_dataflows_configdflinks`;
CREATE  TABLE `glpi_plugin_dataflows_configdflinks` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(255) NOT NULL,
  `has_dropdown` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '0=False/1=True',
  `is_entity_limited` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '0=False/1=True',
  `is_tree_dropdown` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '0=False/1=True',
  `as_view_on` VARCHAR(255) NULL COMMENT 'empty or table name',
  `viewlimit` VARCHAR(255) NULL COMMENT 'empty or where clause (without where reserved word)',
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `plugin_dataflows_configdflinks_name` (`name` ASC) )
 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`) VALUES (1,'PluginArchiswSwcomponent',0,1);
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`) VALUES (2,'PluginArchidataDataelement',0,1);
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`) VALUES (3,'PluginArchibpTask',0,1);
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`) VALUES (4,'PluginArchifunFuncarea',0,1);
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`) VALUES (5,'Computer',0,1);
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`) VALUES (6,'Software',0,1);
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`) VALUES (7,'Appliance',0,1);
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`) VALUES (8,'Contract',0,1);
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`) VALUES (9,'Entity',0,0);
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`) VALUES (10,'Project',0,1);
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`) VALUES (11,'ProjectTask',0,1);
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`) VALUES (12,'User',1,0);
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`,`viewlimit`) VALUES (13,'Group',1,1,'"is_assign" == 1');
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`) VALUES (14,'Location',0,1);
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`) VALUES (15,'Supplier',0,1);
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`) VALUES (16,'Manufacturer',0,0);
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`) VALUES (17,'PluginDataflowsState',0,0);
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`) VALUES (18,'PluginDataflowsType',0,0);
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`) VALUES (19,'PluginDataflowsFlowgroup',0,0);
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`) VALUES (20,'PluginDataflowsIndicator',0,0);
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`) VALUES (21,'PluginDataflowsServicelevel',0,0);
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`) VALUES (22,'PluginDataflowsMode',0,0);
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`) VALUES (23,'PluginDataflowsPattern',0,0);
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`) VALUES (24,'PluginDataflowsTransferProtocol',0,0);
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`) VALUES (25,'PluginDataflowsSourceConnector',0,0);
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`) VALUES (26,'PluginDataflowsTriggerType',0,0);
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`) VALUES (27,'PluginDataflowsTransferFreq',0,0);
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`) VALUES (28,'PluginDataflowsTransferTimetable',0,0);
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`) VALUES (29,'PluginDataflowsHolidayAction',0,0);
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`) VALUES (30,'PluginDataflowsSrcUri',0,0);
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`) VALUES (31,'PluginDataflowsSrcPreproc',0,0);
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`) VALUES (32,'PluginDataflowsDestUri',0,0);
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`) VALUES (33,'PluginDataflowsDestPostproc',0,0);
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`) VALUES (34,'PluginDataflowsErrorHandling',0,0);
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`) VALUES (35,'PluginDataflowsSrcStructureType',0,0);
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`) VALUES (36,'PluginDataflowsFromAuthType',0,0);
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`,`is_tree_dropdown`,`as_view_on`,`viewlimit`) VALUES (37,'PluginDataflowsDestinationConnector',0,0,0,'glpi_plugin_dataflows_sourceconnectors', '');
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`,`is_tree_dropdown`,`as_view_on`,`viewlimit`) VALUES (38,'PluginDataflowsFromSwcomponent',0,1,1,'glpi_plugin_archisw_swcomponents', 'level = ''1'' ');
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`,`is_tree_dropdown`,`as_view_on`,`viewlimit`) VALUES (39,'PluginDataflowsToSwcomponent',0,1,1,'glpi_plugin_archisw_swcomponents', 'level = ''1'' ');
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`,`is_tree_dropdown`,`as_view_on`,`viewlimit`) VALUES (40,'PluginDataflowsOtherGroup',0,1,0,'glpi_groups', '');
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`,`is_tree_dropdown`,`as_view_on`,`viewlimit`) VALUES (41,'PluginDataflowsSupportGroup',0,1,0,'glpi_groups', '');
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`,`is_tree_dropdown`,`as_view_on`,`viewlimit`) VALUES (42,'PluginDataflowsOtherUser',0,0,0,'glpi_users', '');
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`,`is_tree_dropdown`,`as_view_on`,`viewlimit`) VALUES (43,'PluginDataflowsDestStructureType',0,0,0,'glpi_plugin_dataflows_srcstructuretypes', '');
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`,`is_tree_dropdown`,`as_view_on`,`viewlimit`) VALUES (44,'PluginDataflowsToAuthType',0,0,0,'glpi_plugin_dataflows_fromauthtypes', '');
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`,`is_tree_dropdown`,`as_view_on`,`viewlimit`) VALUES (45,'PluginDataflowsFromCredential',0,0,0,'glpi_plugin_accounts_accounts', '');
INSERT INTO `glpi_plugin_dataflows_configdflinks` (`id`,`name`,`has_dropdown`,`is_entity_limited`,`is_tree_dropdown`,`as_view_on`,`viewlimit`) VALUES (46,'PluginDataflowsToCredential',0,0,0,'glpi_plugin_accounts_accounts', '');

-- -----------------------------------------------------
-- Table `glpi_plugin_dataflows_configdfs`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `glpi_plugin_dataflows_configdfs`;
CREATE  TABLE `glpi_plugin_dataflows_configdfs` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `plugin_dataflows_configdffieldgroups_id` INT(11) UNSIGNED NOT NULL,
  `row` TINYINT UNSIGNED NOT NULL,
  `plugin_dataflows_configdfhaligns_id` INT(11) UNSIGNED NOT NULL COMMENT 'Left/Center/Right column or Full line',
  `plugin_dataflows_configdfdbfieldtypes_id` INT(11) UNSIGNED NOT NULL,
  `plugin_dataflows_configdfdatatypes_id` INT(11) UNSIGNED NOT NULL,
  `nosearch` CHAR(1) NOT NULL COMMENT '0=False/1=True',
  `massiveaction` CHAR(1) NOT NULL COMMENT '0=False/1=True',
  `forcegroupby` CHAR(1) NOT NULL COMMENT '0=False/1=True',
  `is_linked` TINYINT UNSIGNED NOT NULL COMMENT '0=False/1=True',
  `plugin_dataflows_configdflinks_id` INT(11) UNSIGNED,
  `linkfield` VARCHAR(255),
  `joinparams` VARCHAR(255),
  `description` VARCHAR(45) NOT NULL,
  `is_readonly` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '0=False/1=True',
  `is_deleted` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '0=False/1=True',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unicity` (`plugin_dataflows_configdffieldgroups_id`, `row`, `plugin_dataflows_configdfhaligns_id`),
  UNIQUE INDEX `plugin_dataflows_configdfs_name` (`name` ASC) )
 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'plugin_dataflows_flowgroups_id',0,1,6,10,6,1,0,0,1,19,'','',0,'Flow group',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'shortdescription',0,2,1,30,1,1,0,0,0,0,'','',0,'Short description',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'longdescription',1,3,1,31,8,1,0,0,1,0,'','',0,'Long description',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'plugin_dataflows_states_id',1,4,2,10,6,1,0,0,1,17,'','',0,'Status',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'statedate',1,4,6,41,3,1,0,0,1,0,'','',0,'Status StartDate',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'plugin_dataflows_modes_id',1,5,2,10,6,1,0,0,1,22,'','',0,'Mode Full/Delta',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'plugin_dataflows_patterns_id',1,5,6,10,6,1,0,0,1,23,'','',0,'Pattern',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'plugin_dataflows_types_id',1,6,2,10,6,1,0,0,1,18,'','',0,'Type',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'plugin_dataflows_indicators_id',1,6,6,10,6,1,0,0,1,20,'','',0,'Indicator',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'plugin_dataflows_transferprotocols_id',1,7,7,10,6,1,0,0,1,24,'','',0,'Transfer Protocol',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'plugin_dataflows_fromswcomponents_id',1,8,2,10,6,1,0,0,1,38,'','',0,'From application',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'plugin_dataflows_toswcomponents_id',1,8,6,10,6,1,0,0,1,39,'','',0,'To application',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'plugin_dataflows_sourceconnectors_id',1,9,2,10,6,1,0,0,1,25,'','',0,'Source Connector',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'plugin_dataflows_destinationconnectors_id',1,9,6,10,6,1,0,0,1,37,'','',0,'Destination Connector',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'plugin_dataflows_fromauthtypes_id',2,1,2,10,6,1,0,0,1,36,'','',0,'Source authentication type',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'plugin_dataflows_toauthtypes_id',2,1,6,10,6,1,0,0,1,44,'','',0,'Destination authentication type',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'plugin_dataflows_fromcredentials_id',2,2,2,10,6,1,0,0,1,45,'','',0,'Source User',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'plugin_dataflows_tocredentials_id',2,2,6,10,6,1,0,0,1,46,'','',0,'Destination User',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'plugin_dataflows_fromexternal',2,3,2,30,1,1,0,0,1,0,'','',0,'From external server',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'plugin_dataflows_toexternal',2,3,6,30,1,1,0,0,1,0,'','',0,'To external server',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'plugin_dataflows_srcuri',2,4,2,30,1,1,0,0,1,0,'','',0,'Source directory/ ProgramId/ port',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'plugin_dataflows_desturi',2,4,6,30,1,1,0,0,1,0,'','',0,'Destination directory/ ProgramId/ port',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'srcformat',2,5,2,30,1,1,0,0,1,0,'','',0,'Source format (Idoc, table, pattern, ...)',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'destformat',2,5,6,30,1,1,0,0,1,0,'','',0,'Dest. format (Idoc, table, pattern, ...)',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'plugin_dataflows_srcstructuretypes_id',2,6,2,10,6,1,0,0,1,35,'','',0,'Source structure type',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'plugin_dataflows_deststructuretypes_id',2,6,6,10,6,1,0,0,1,43,'','',0,'Destination structure type',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'srcstructure',2,7,2,32,8,1,0,0,1,0,'','',0,'Source data structure',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'deststructure',2,7,6,32,8,1,0,0,1,0,'','',0,'Destination data structure',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'extractmethod',2,8,2,30,1,1,0,0,1,0,'','',0,'Extract Method (Bapi, Stored Proc, ...)',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'loadmethod',2,8,6,30,1,1,0,0,1,0,'','',0,'Load Method (Bapi, Stored Proc, ...)',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'plugin_dataflows_srcpreprocs_id',2,9,2,10,6,1,0,0,1,31,'','',0,'Transfer Preprocessing',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'plugin_dataflows_destpostprocs_id',2,9,6,10,6,1,0,0,1,33,'','',0,'Transfer Postprocessing',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'plugin_dataflows_triggertypes_id',3,1,2,10,6,1,0,0,1,26,'','',0,'Transfer trigger',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'triggerformat',3,1,6,30,1,1,0,0,1,0,'','',0,'Trigger name',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'plugin_dataflows_transferfreqs_id',3,2,2,10,6,1,0,0,1,27,'','',0,'Transfer frequency',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'plugin_dataflows_transfertimetables_id',3,2,6,10,6,1,0,0,1,28,'','',0,'Transfer Timetable',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'plugin_dataflows_errorhandlings_id',3,3,2,10,6,1,0,0,1,34,'','',0,'Transfer Error handling',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'plugin_dataflows_holidayactions_id',3,3,6,10,6,1,0,0,1,29,'','',0,'Transfer On holiday',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'mappingdocurl',3,4,2,30,7,1,0,0,1,0,'','',0,'URL to functional doc (mapping, ...)',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'technicaldocurl',3,4,6,30,7,1,0,0,1,0,'','',0,'URL to technical doc (design, ...)',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'transfervolume',3,5,2,30,1,1,0,0,1,0,'','',0,'Transfer Volume (MB)',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'transferpriority',3,5,6,30,1,1,0,0,1,0,'','',0,'Priority',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'plugin_dataflows_servicelevels_id',3,6,2,10,6,1,0,0,1,21,'','',0,'Service Level',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'is_helpdesk_visible',3,6,6,20,2,1,0,0,1,0,'','',0,'Associable to a ticket',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'groups_id',4,1,2,10,6,1,0,0,1,13,'','',0,'Dataflow Follow-up',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'users_id',4,1,6,10,6,1,0,0,1,12,'','',0,'Dataflow Expert',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'plugin_dataflows_othergroups_id',4,2,2,10,6,1,0,0,1,40,'','',0,'Other group',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'plugin_dataflows_otherusers_id',4,2,6,10,6,1,0,0,1,42,'','',0,'Other expert',0);
INSERT INTO `glpi_plugin_dataflows_configdfs` (`id`,`name`,`plugin_dataflows_configdffieldgroups_id`,`row`,`plugin_dataflows_configdfhaligns_id`,`plugin_dataflows_configdfdbfieldtypes_id`,`plugin_dataflows_configdfdatatypes_id`,`nosearch`,`massiveaction`,`forcegroupby`,`is_linked`,`plugin_dataflows_configdflinks_id`,`linkfield`,`joinparams`,`is_readonly`,`description`,`is_deleted`) VALUES (null,'plugin_dataflows_supportgroups_id',4,3,2,10,6,1,0,0,1,41,'','',0,'Dataflow Support',0);

-- ----------------------------------
-- Statecheck rules
-- ----------------------------------
INSERT INTO `glpi_plugin_statecheck_tables` (`id`,`name`,`comment`,`statetable`,`stateclass`,`class`,`frontname`) VALUES (null,'glpi_plugin_dataflows_configdfs', 'Dataflows configuration', 'glpi_plugin_dataflows_configdfdatatypes', 'PluginDataflowsConfigdfDatatype', 'PluginDataflowsConfigdf', 'configdf');
SELECT @table_id := LAST_INSERT_ID();
INSERT INTO `glpi_plugin_statecheck_rules` (`id`,`entities_id`,`name`,`plugin_statecheck_tables_id`,`plugin_statecheck_targetstates_id`,`ranking`,`match`,`is_active`,`comment`,`successnotifications_id`,`failurenotifications_id`,`date_mod`,`is_recursive`) VALUES (null,0,'Dataflows configuration - reserved words',@table_id,0,1,'AND',true,'Do not delete',0,0,NOW(),true);
SELECT @rule_id := LAST_INSERT_ID();
INSERT INTO `glpi_plugin_statecheck_ruleactions` (`id`,`plugin_statecheck_rules_id`,`action_type`,`field`,`value`) VALUES (null,@rule_id,'isnot','name','name');
INSERT INTO `glpi_plugin_statecheck_ruleactions` (`id`,`plugin_statecheck_rules_id`,`action_type`,`field`,`value`) VALUES (null,@rule_id,'isnot','name','completename');
INSERT INTO `glpi_plugin_statecheck_ruleactions` (`id`,`plugin_statecheck_rules_id`,`action_type`,`field`,`value`) VALUES (null,@rule_id,'isnot','name','is_deleted');
INSERT INTO `glpi_plugin_statecheck_ruleactions` (`id`,`plugin_statecheck_rules_id`,`action_type`,`field`,`value`) VALUES (null,@rule_id,'isnot','name','entities_id');
INSERT INTO `glpi_plugin_statecheck_ruleactions` (`id`,`plugin_statecheck_rules_id`,`action_type`,`field`,`value`) VALUES (null,@rule_id,'isnot','name','id');
INSERT INTO `glpi_plugin_statecheck_ruleactions` (`id`,`plugin_statecheck_rules_id`,`action_type`,`field`,`value`) VALUES (null,@rule_id,'isnot','name','is_recursive');
INSERT INTO `glpi_plugin_statecheck_ruleactions` (`id`,`plugin_statecheck_rules_id`,`action_type`,`field`,`value`) VALUES (null,@rule_id,'isnot','name','sons_cache');
INSERT INTO `glpi_plugin_statecheck_ruleactions` (`id`,`plugin_statecheck_rules_id`,`action_type`,`field`,`value`) VALUES (null,@rule_id,'isnot','name','ancestors_cache');
INSERT INTO `glpi_plugin_statecheck_ruleactions` (`id`,`plugin_statecheck_rules_id`,`action_type`,`field`,`value`) VALUES (null,@rule_id,'isnot','name','date_mod');
INSERT INTO `glpi_plugin_statecheck_rules` (`id`,`entities_id`,`name`,`plugin_statecheck_tables_id`,`plugin_statecheck_targetstates_id`,`ranking`,`match`,`is_active`,`comment`,`successnotifications_id`,`failurenotifications_id`,`date_mod`,`is_recursive`) VALUES (null,0,'Dataflows configuration - mandatory fields',@table_id,0,1,'AND',true,'Do not delete',0,0,NOW(),true);
SELECT @rule_id := LAST_INSERT_ID();
INSERT INTO `glpi_plugin_statecheck_ruleactions` (`id`,`plugin_statecheck_rules_id`,`action_type`,`field`,`value`) VALUES (null,@rule_id,'isnotempty','row',null);
INSERT INTO `glpi_plugin_statecheck_ruleactions` (`id`,`plugin_statecheck_rules_id`,`action_type`,`field`,`value`) VALUES (null,@rule_id,'isnotempty','plugin_dataflows_configdfhaligns_id',null);
INSERT INTO `glpi_plugin_statecheck_ruleactions` (`id`,`plugin_statecheck_rules_id`,`action_type`,`field`,`value`) VALUES (null,@rule_id,'isnotempty','description',null);
INSERT INTO `glpi_plugin_statecheck_ruleactions` (`id`,`plugin_statecheck_rules_id`,`action_type`,`field`,`value`) VALUES (null,@rule_id,'isnotempty','plugin_dataflows_configdfdbfieldtypes_id',null);
INSERT INTO `glpi_plugin_statecheck_ruleactions` (`id`,`plugin_statecheck_rules_id`,`action_type`,`field`,`value`) VALUES (null,@rule_id,'isnotempty','plugin_dataflows_configdfdatatypes_id',null);
INSERT INTO `glpi_plugin_statecheck_rules` (`id`,`entities_id`,`name`,`plugin_statecheck_tables_id`,`plugin_statecheck_targetstates_id`,`ranking`,`match`,`is_active`,`comment`,`successnotifications_id`,`failurenotifications_id`,`date_mod`,`is_recursive`) VALUES (null,0,'Dataflows configuration - not dropdown',@table_id,0,1,'AND',true,'Do not delete
/nIf the field is not a dropdown,
/n- a name must be lowercase, start with a letter, contain only letters, numbers or underscores
/n- a name may not end with "s_id" ((?&#60;!a) is a negated lookbehind assertion that ensures, that before the end of the string (or row with m modifier), there is not the character "a")',0,0,NOW(),true);
SELECT @rule_id := LAST_INSERT_ID();
INSERT INTO `glpi_plugin_statecheck_ruleactions` (`id`,`plugin_statecheck_rules_id`,`action_type`,`field`,`value`) VALUES (null,@rule_id,'regex_check','name','/^[a-z][a-z0-9_]*$/');
INSERT INTO `glpi_plugin_statecheck_ruleactions` (`id`,`plugin_statecheck_rules_id`,`action_type`,`field`,`value`) VALUES (null,@rule_id,'regex_check','name','/.*(?&#60;!s_id)$/m');
INSERT INTO `glpi_plugin_statecheck_rulecriterias` (`id`,`plugin_statecheck_rules_id`,`criteria`,`condition`,`pattern`) VALUES (null,@rule_id,'plugin_dataflows_configdfdatatypes_id',1,6);
INSERT INTO `glpi_plugin_statecheck_rules` (`id`,`entities_id`,`name`,`plugin_statecheck_tables_id`,`plugin_statecheck_targetstates_id`,`ranking`,`match`,`is_active`,`comment`,`successnotifications_id`,`failurenotifications_id`,`date_mod`,`is_recursive`) VALUES (null,0,'Dataflows configuration - dropdown',@table_id,6,1,'AND',true,'Do not delete',0,0,NOW(),true);
SELECT @rule_id := LAST_INSERT_ID();
INSERT INTO `glpi_plugin_statecheck_ruleactions` (`id`,`plugin_statecheck_rules_id`,`action_type`,`field`,`value`) VALUES (null,@rule_id,'regex_check','name','/^[a-z][a-z0-9_]*s_id$/');
INSERT INTO `glpi_plugin_statecheck_ruleactions` (`id`,`plugin_statecheck_rules_id`,`action_type`,`field`,`value`) VALUES (null,@rule_id,'is','is_linked','1');
INSERT INTO `glpi_plugin_statecheck_ruleactions` (`id`,`plugin_statecheck_rules_id`,`action_type`,`field`,`value`) VALUES (null,@rule_id,'isnotempty','plugin_dataflows_configdflinks_id',null);
INSERT INTO `glpi_plugin_statecheck_ruleactions` (`id`,`plugin_statecheck_rules_id`,`action_type`,`field`,`value`) VALUES (null,@rule_id,'is','plugin_dataflows_configdfdbfieldtypes_id',10);

INSERT INTO `glpi_plugin_statecheck_tables` (`id`,`name`,`comment`,`statetable`,`stateclass`,`class`,`frontname`) VALUES (null,'glpi_plugin_dataflows_configdflinks', 'Dataflows configuration links', '', '', 'PluginDataflowsConfigdfLink', 'configdflink');
SELECT @table_id := LAST_INSERT_ID();
INSERT INTO `glpi_plugin_statecheck_rules` (`id`,`entities_id`,`name`,`plugin_statecheck_tables_id`,`plugin_statecheck_targetstates_id`,`ranking`,`match`,`is_active`,`comment`,`successnotifications_id`,`failurenotifications_id`,`date_mod`,`is_recursive`) VALUES (null,0,'Dataflows configuration links for dropdown',@table_id,0,1,'AND',true,'Do not delete : set temporarily inactive, if needed',0,0,NOW(),true);
SELECT @rule_id := LAST_INSERT_ID();
INSERT INTO `glpi_plugin_statecheck_ruleactions` (`id`,`plugin_statecheck_rules_id`,`action_type`,`field`,`value`) VALUES (null,@rule_id,'regex_check','name','/^PluginDataflows[a-zA-Z0-9]+$/');

INSERT INTO `glpi_plugin_statecheck_tables` (`id`,`name`,`comment`,`statetable`,`stateclass`,`class`,`frontname`) VALUES (null,'glpi_plugin_dataflows_configdffieldgroups', 'Dataflows field groups', '', '', 'PluginDataflowsConfigdfFieldgroup', 'configdffieldgroup');
SELECT @table_id := LAST_INSERT_ID();
INSERT INTO `glpi_plugin_statecheck_rules` (`id`,`entities_id`,`name`,`plugin_statecheck_tables_id`,`plugin_statecheck_targetstates_id`,`ranking`,`match`,`is_active`,`comment`,`successnotifications_id`,`failurenotifications_id`,`date_mod`,`is_recursive`) VALUES (null,0,'Dataflows Field Groups - mandatory fields',@table_id,0,1,'AND',true,'Do not delete',0,0,NOW(),true);
SELECT @rule_id := LAST_INSERT_ID();
INSERT INTO `glpi_plugin_statecheck_ruleactions` (`id`,`plugin_statecheck_rules_id`,`action_type`,`field`,`value`) VALUES (null,@rule_id,'isnotempty','name',null);
INSERT INTO `glpi_plugin_statecheck_ruleactions` (`id`,`plugin_statecheck_rules_id`,`action_type`,`field`,`value`) VALUES (null,@rule_id,'regex_check','name','/^[a-zA-Z][a-zA-Z0-9_]*$/');
INSERT INTO `glpi_plugin_statecheck_ruleactions` (`id`,`plugin_statecheck_rules_id`,`action_type`,`field`,`value`) VALUES (null,@rule_id,'isnotempty','comment',null);
INSERT INTO `glpi_plugin_statecheck_ruleactions` (`id`,`plugin_statecheck_rules_id`,`action_type`,`field`,`value`) VALUES (null,@rule_id,'isnotempty','sortorder',null);

INSERT INTO `glpi_displaypreferences` VALUES (NULL,'PluginDataflowsConfigdf',2,1,0);
INSERT INTO `glpi_displaypreferences` VALUES (NULL,'PluginDataflowsConfigdf',3,2,0);
INSERT INTO `glpi_displaypreferences` VALUES (NULL,'PluginDataflowsConfigdf',11,3,0);
INSERT INTO `glpi_displaypreferences` VALUES (NULL,'PluginDataflowsConfigdf',12,4,0);
INSERT INTO `glpi_displaypreferences` VALUES (NULL,'PluginDataflowsConfigdf',4,5,0);
INSERT INTO `glpi_displaypreferences` VALUES (NULL,'PluginDataflowsConfigdf',10,6,0);
