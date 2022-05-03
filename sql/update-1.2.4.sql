ALTER TABLE `glpi_plugin_dataflows_dataflows` 
	ADD COLUMN `plugin_dataflows_modes_id` INT(11) NOT NULL default '0' COMMENT 'other group' AFTER `plugin_dataflows_servicelevels_id`,
	ADD COLUMN `plugin_dataflows_patterns_id` INT(11) NOT NULL default '0' COMMENT 'support group' AFTER `plugin_dataflows_modes_id`,
	ADD COLUMN `srcstructure` MEDIUMTEXT NULL COMMENT 'source data structure' AFTER `srcformat`,
	ADD COLUMN `deststructure` MEDIUMTEXT NULL COMMENT 'destination data structure' AFTER `destformat`,
	ADD INDEX  `plugin_dataflows_modes_id` (`plugin_dataflows_modes_id`),
	ADD INDEX `plugin_dataflows_patterns_id` (`plugin_dataflows_patterns_id`);
	
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
