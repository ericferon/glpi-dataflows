ALTER TABLE `glpi_plugin_dataflows_dataflows` 
	ADD COLUMN `plugin_dataflows_fromauthtypes_id` INT(11) NOT NULL default '0' COMMENT 'source authentication type' AFTER `plugin_dataflows_tocredentials_id`,
	ADD COLUMN `plugin_dataflows_toauthtypes_id` INT(11) NOT NULL default '0' COMMENT 'destination authentication type' AFTER `plugin_dataflows_fromauthtypes_id`,
	ADD COLUMN `plugin_dataflows_srcstructuretypes_id` INT(11) NOT NULL default '0' COMMENT 'source structure type' AFTER `srcformat`,
	ADD COLUMN `plugin_dataflows_deststructuretypes_id` INT(11) NOT NULL default '0' COMMENT 'destination structure type' AFTER `destformat`,
	ADD INDEX  `plugin_dataflows_fromauthtypes_id` (`plugin_dataflows_fromauthtypes_id`),
	ADD INDEX  `plugin_dataflows_toauthtypes_id` (`plugin_dataflows_toauthtypes_id`),
	ADD INDEX  `plugin_dataflows_srcstructuretypes_id` (`plugin_dataflows_srcstructuretypes_id`),
	ADD INDEX `plugin_dataflows_deststructuretypes_id` (`plugin_dataflows_deststructuretypes_id`);
	
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
DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `glpi_plugin_dataflows_fromauthtypes` ( `id` , `name` , `comment` ) VALUES (1,'Basic authentication','Login/Password');

-- -----------------------------------------------------
-- Table `glpi_plugin_dataflows_toauthtypes`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `glpi_plugin_dataflows_toauthtypes`;
CREATE OR REPLACE VIEW glpi_plugin_dataflows_toauthtypes as
SELECT `id`,`name`, `comment` FROM glpi_plugin_dataflows_fromauthtypes;
