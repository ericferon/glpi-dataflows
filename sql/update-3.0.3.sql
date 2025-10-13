-- -----------------------------------------------------
-- Increase name and shortdescription field length
-- -----------------------------------------------------
ALTER TABLE `glpi_plugin_dataflows_dataflows` MODIFY `name` VARCHAR(100) NOT NULL COMMENT 'flow name (or code)';
ALTER TABLE `glpi_plugin_dataflows_dataflows` MODIFY `shortdescription` VARCHAR(200) NULL;
