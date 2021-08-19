-- -----------------------------------------------------
-- Table `glpi_plugin_dataflows_fromcredentials`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `glpi_plugin_dataflows_fromcredentials`;
CREATE OR REPLACE VIEW glpi_plugin_dataflows_fromcredentials as
SELECT `id`,`name`, `login` as comment FROM glpi_plugin_accounts_accounts;
-- -----------------------------------------------------
-- Table `glpi_plugin_dataflows_tocredentials`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `glpi_plugin_dataflows_tocredentials`;
CREATE OR REPLACE VIEW glpi_plugin_dataflows_tocredentials as
SELECT `id`,`name`, `login` as comment FROM glpi_plugin_accounts_accounts;
