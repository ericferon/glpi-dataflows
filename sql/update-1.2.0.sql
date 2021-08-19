ALTER TABLE `glpi_plugin_dataflows_dataflows` 
	ADD COLUMN `plugin_dataflows_triggertypes_id` INT(11) NOT NULL default '0' AFTER `plugin_dataflows_toswcomponents_id`,
	ADD COLUMN `plugin_dataflows_transferfreqs_id` INT(11) NOT NULL default '0' AFTER `transfertimetable`,
	ADD COLUMN `plugin_dataflows_transfertimetables_id` INT(11) NOT NULL default '0' AFTER `plugin_dataflows_transferfreqs_id`,
	ADD COLUMN `plugin_dataflows_holidayactions_id` INT(11) NOT NULL default '0' AFTER `plugin_dataflows_transfertimetables_id`,
	ADD COLUMN `srcformat` VARCHAR(100) NULL AFTER `extractmethod`,
	ADD COLUMN `plugin_dataflows_srcuris_id` INT(11) NOT NULL default '0' AFTER `srcformat`,
	ADD COLUMN `plugin_dataflows_srcpreprocs_id` INT(11) NOT NULL default '0' AFTER `plugin_dataflows_srcuri`,
	ADD COLUMN `plugin_dataflows_srccomputers_id` INT(11) NOT NULL default '0' AFTER `plugin_dataflows_srcpreprocs_id`,
	ADD COLUMN `destformat` VARCHAR(100) NULL AFTER `loadmethod`,
	ADD COLUMN `plugin_dataflows_desturis_id` INT(11) NOT NULL default '0' AFTER `destformat`,
	ADD COLUMN `plugin_dataflows_destpostprocs_id` INT(11) NOT NULL default '0' AFTER `plugin_dataflows_desturi`,
	ADD COLUMN `plugin_dataflows_destcomputers_id` INT(11) NOT NULL default '0' AFTER `plugin_dataflows_srccomputers_id`,
	ADD INDEX `plugin_dataflows_triggertypes_id` (`plugin_dataflows_triggertypes_id`),
	ADD INDEX `plugin_dataflows_transferfreqs_id` (`plugin_dataflows_transferfreqs_id`),
	ADD INDEX `plugin_dataflows_transfertimetables_id` (`plugin_dataflows_transfertimetables_id`),
	ADD INDEX `plugin_dataflows_holidayactions_id` (`plugin_dataflows_holidayactions_id`),
	ADD INDEX `plugin_dataflows_srcuris_id` (`plugin_dataflows_srcuris_id`),
	ADD INDEX `plugin_dataflows_srcpreprocs_id` (`plugin_dataflows_srcpreprocs_id`),
	ADD INDEX `plugin_dataflows_desturis_id` (`plugin_dataflows_desturis_id`),
	ADD INDEX `plugin_dataflows_destpostprocs_id` (`plugin_dataflows_destpostprocs_id`);

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
ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
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
ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

insert into glpi_plugin_dataflows_transferfreqs (name)
select distinct transferfrequency from glpi_plugin_dataflows_dataflows;
update glpi_plugin_dataflows_dataflows as toupdate
inner join glpi_plugin_dataflows_transferfreqs as fromref
on toupdate.transferfrequency = fromref.name
set toupdate.plugin_dataflows_transferfreqs_id = fromref.id;

insert into glpi_plugin_dataflows_transfertimetables (name)
select distinct transfertimetable from glpi_plugin_dataflows_dataflows;
update glpi_plugin_dataflows_dataflows as toupdate
inner join glpi_plugin_dataflows_transfertimetables as fromref
on toupdate.transfertimetable = fromref.name
set toupdate.plugin_dataflows_transfertimetables_id = fromref.id;
