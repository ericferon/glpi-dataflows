ALTER TABLE `glpi_plugin_dataflows_dataflows` 
	ADD COLUMN `plugin_dataflows_othergroups_id` INT(11) NOT NULL default '0' COMMENT 'other group' AFTER `groups_id`,
	ADD COLUMN `plugin_dataflows_supportgroups_id` INT(11) NOT NULL default '0' COMMENT 'support group' AFTER `plugin_dataflows_othergroups_id`,
	ADD COLUMN `plugin_dataflows_otherusers_id` INT(11) NOT NULL default '0' COMMENT 'other user' AFTER `users_id`,
	ADD COLUMN `plugin_dataflows_fromcredentials_id` INT(11) NOT NULL default '0' COMMENT 'login user to source' AFTER `plugin_dataflows_toexternal`,
	ADD COLUMN `plugin_dataflows_tocredentials_id` INT(11) NOT NULL default '0' COMMENT 'login user to destination' AFTER `plugin_dataflows_fromcredentials_id`,
	ADD INDEX  `plugin_dataflows_othergroups_id` (`plugin_dataflows_othergroups_id`),
	ADD INDEX  `plugin_dataflows_supportgroups_id` (`plugin_dataflows_supportgroups_id`),
	ADD INDEX `plugin_dataflows_otherusers_id` (`plugin_dataflows_otherusers_id`),
	ADD INDEX `plugin_dataflows_fromcredentials_id` (`plugin_dataflows_fromcredentials_id`),
	ADD INDEX `plugin_dataflows_tocredentials_id` (`plugin_dataflows_tocredentials_id`);
	
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

