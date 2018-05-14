ALTER TABLE `glpi_plugin_dataflows_dataflows` 
	ADD COLUMN `plugin_dataflows_fromexternal` VARCHAR(100) NULL COMMENT 'from external address' AFTER `plugin_dataflows_tocomputers_id`,
	ADD COLUMN `plugin_dataflows_toexternal` VARCHAR(100) NULL COMMENT 'to external address' AFTER `plugin_dataflows_fromexternal`,
	ADD COLUMN `plugin_dataflows_srcuri` VARCHAR(100) NULL AFTER `plugin_dataflows_srcuris_id`,
	ADD COLUMN `plugin_dataflows_desturi` VARCHAR(100) NULL AFTER `plugin_dataflows_desturis_id`,
	ADD COLUMN `plugin_dataflows_errorhandlings_id` INT(11) NOT NULL default '0' AFTER `plugin_dataflows_destpostprocs_id`,
	ADD COLUMN `mappingdocurl` varchar(255) default NULL AFTER `plugin_dataflows_errorhandlings_id`,
	ADD COLUMN `technicaldocurl` varchar(255) default NULL AFTER `mappingdocurl`,
	ADD COLUMN `triggerformat` varchar(100) default NULL AFTER `mappingdocurl`,
	ADD INDEX `plugin_dataflows_errorhandlings_id` (`plugin_dataflows_errorhandlings_id`),
	MODIFY `longdescription` TEXT
	MODIFY loadmethod TINYTEXT,
	MODIFY extractmethod TINYTEXT,
	MODIFY srcformat TINYTEXT,
	MODIFY destformat TINYTEXT;
	
DROP INDEX `flowname_UNIQUE` on glpi_plugin_dataflows_dataflows;
CREATE UNIQUE INDEX `flowname_UNIQUE` ON glpi_plugin_dataflows_dataflows(`name`,`plugin_dataflows_transferprotocols_id`);


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
ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
