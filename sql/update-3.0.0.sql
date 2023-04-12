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
