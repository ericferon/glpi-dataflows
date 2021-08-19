ALTER TABLE `glpi_plugin_dataflows_dataflows` 
   ADD COLUMN `plugin_dataflows_indicators_id` INT(11) NOT NULL default '0' COMMENT 'flow indicators : undocumented, documented ...' AFTER `plugin_dataflows_types_id`,
   ADD INDEX `plugin_dataflows_indicators_id`(`plugin_dataflows_indicators_id`);

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
