ALTER TABLE `glpi_plugin_dataflows_dataflows` 
	CHANGE COLUMN `plugin_dataflows_fromwebapplications_id` `plugin_dataflows_fromswcomponents_id` INT(11) NOT NULL default '0' COMMENT 'from swcomponent',
	CHANGE COLUMN `plugin_dataflows_towebapplications_id` `plugin_dataflows_toswcomponents_id` INT(11) NOT NULL default '0' COMMENT 'to swcomponent',
	DROP INDEX `plugin_dataflows_fromwebapplications_id`,
	DROP INDEX `plugin_dataflows_towebapplications_id`,
	ADD INDEX `plugin_dataflows_fromswcomponents_id` (`plugin_dataflows_fromswcomponents_id`),
	ADD INDEX `plugin_dataflows_toswcomponents_id` (`plugin_dataflows_toswcomponents_id`);

DROP VIEW IF EXISTS `glpi_plugin_dataflows_fromwebapplications`;
DROP VIEW IF EXISTS `glpi_plugin_dataflows_towebapplications`;
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
