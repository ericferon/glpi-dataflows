<?php
/*
 -------------------------------------------------------------------------
 Dataflows plugin for GLPI
 Copyright (C) 2009-2018 by Eric Feron.
 -------------------------------------------------------------------------

 LICENSE
      
 This file is part of Dataflows.

 Dataflows is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 at your option any later version.

 Dataflows is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with Dataflows. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 */

function plugin_dataflows_install() {
   global $DB;

   include_once (Plugin::getPhpDir("dataflows")."/inc/profile.class.php");

   $update=false;
   if (!$DB->TableExists("glpi_plugin_dataflows_dataflows")) {

		$DB->runFile(Plugin::getPhpDir("dataflows")."/sql/empty-3.0.0.sql");
	}
	else {
		if ($DB->TableExists("glpi_plugin_dataflows_dataflows") && !$DB->FieldExists("glpi_plugin_dataflows_dataflows","plugin_dataflows_indicators_id")) {
			$update=true;
			$DB->runFile(Plugin::getPhpDir("dataflows")."/sql/update-1.0.1.sql");
		}
		if ($DB->TableExists("glpi_plugin_dataflows_dataflows") && (!$DB->FieldExists("glpi_plugin_dataflows_dataflows","plugin_dataflows_fromswcomponents_id") || !$DB->FieldExists("glpi_plugin_dataflows_dataflows","plugin_dataflows_toswcomponents_id"))) {
			$update=true;
			$DB->runFile(Plugin::getPhpDir("dataflows")."/sql/update-1.1.0.sql");
		}
		if ($DB->TableExists("glpi_plugin_dataflows_dataflows") && (!$DB->FieldExists("glpi_plugin_dataflows_dataflows","plugin_dataflows_triggertypes_id"))) {
			$update=true;
			$DB->runFile(Plugin::getPhpDir("dataflows")."/sql/update-1.2.0.sql");
		}
		if ($DB->TableExists("glpi_plugin_dataflows_dataflows") && (!$DB->FieldExists("glpi_plugin_dataflows_dataflows","plugin_dataflows_errorhandlings_id"))) {
			$update=true;
			$DB->runFile(Plugin::getPhpDir("dataflows")."/sql/update-1.2.1.sql");
		}
		if ($DB->TableExists("glpi_plugin_dataflows_dataflows") && (!$DB->FieldExists("glpi_plugin_dataflows_dataflows","plugin_dataflows_otherusers_id"))) {
			$update=true;
			$DB->runFile(Plugin::getPhpDir("dataflows")."/sql/update-1.2.3.sql");
		}
		if ($DB->TableExists("glpi_plugin_dataflows_dataflows") && (!$DB->FieldExists("glpi_plugin_dataflows_dataflows","plugin_dataflows_modes_id"))) {
			$update=true;
			$DB->runFile(Plugin::getPhpDir("dataflows")."/sql/update-1.2.4.sql");
		}
		if ($DB->TableExists("glpi_plugin_dataflows_dataflows") && (!$DB->FieldExists("glpi_plugin_dataflows_dataflows","plugin_dataflows_fromauthtypes_id"))) {
			$update=true;
			$DB->runFile(Plugin::getPhpDir("dataflows")."/sql/update-1.2.5.sql");
		}
		if (!$DB->TableExists("glpi_plugin_dataflows_srcstructuretypes")) {
			$update=true;
			$DB->runFile(Plugin::getPhpDir("dataflows")."/sql/update-1.2.6.sql");
		}
         if (!$DB->TableExists("glpi_plugin_dataflows_configdfs")) {
            $DB->runFile(Plugin::getPhpDir("dataflows")."/sql/update-3.0.0.sql");
        }
	}
    if (class_exists('PluginAccountsAccount')) {
			$DB->runFile(Plugin::getPhpDir("dataflows")."/sql/addon-accounts-1.2.3.sql");
    }

   // regenerate configured fields
   if ($DB->TableExists("glpi_plugin_dataflows_configdflinks") && $DB->TableExists("glpi_plugin_dataflows_configdfs")) {
      $query = "SELECT `glpi_plugin_dataflows_configdflinks`.`name` as `classname`, `is_entity_limited`, `is_tree_dropdown`, `as_view_on`, `viewlimit`
               FROM `glpi_plugin_dataflows_configdflinks` 
               JOIN `glpi_plugin_dataflows_configdfs`  ON `glpi_plugin_dataflows_configdflinks`.`id` = `glpi_plugin_dataflows_configdfs`.`plugin_dataflows_configdflinks_id` 
               WHERE `glpi_plugin_dataflows_configdflinks`.`name` like 'PluginDataflows%'";
      $result = $DB->query($query);
      $item = new CommonDBTM;
      while ($data = $DB->fetchAssoc($result)) {
         $item->input['name'] = $data['classname'];
         $item->input['is_entity_limited'] = $data['is_entity_limited'];
         $item->input['is_tree_dropdown'] = $data['is_tree_dropdown'];
         $item->input['as_view_on'] = $data['as_view_on'];
         $item->input['viewlimit'] = $data['viewlimit'];
         hook_pre_item_add_dataflows_configdflink($item); // simulate the creation of this field
      }
      // refresh with new files
      header("Refresh:0");
   }

   
   if ($DB->TableExists("glpi_plugin_dataflows_profiles")) {
   
      $notepad_tables = ['glpi_plugin_dataflows_dataflows'];

      foreach ($notepad_tables as $t) {
         // Migrate data
         if ($DB->FieldExists($t, 'notepad')) {
            $query = "SELECT id, notepad
                      FROM `$t`
                      WHERE notepad IS NOT NULL
                            AND notepad <>'';";
            foreach ($DB->request($query) as $data) {
               $iq = "INSERT INTO `glpi_notepads`
                             (`itemtype`, `items_id`, `content`, `date`, `date_mod`)
                      VALUES ('PluginDataflowsDataflow', '".$data['id']."',
                              '".addslashes($data['notepad'])."', NOW(), NOW())";
               $DB->queryOrDie($iq, "0.85 migrate notepad data");
            }
            $query = "ALTER TABLE `glpi_plugin_dataflows_dataflows` DROP COLUMN `notepad`;";
            $DB->query($query);
         }
      }
   }
   
   if ($update && $DB->TableExists("glpi_plugin_dataflows_profiles")) {
      $query_="SELECT *
            FROM `glpi_plugin_dataflows_profiles` ";
      $result_=$DB->query($query_);
      if ($DB->numrows($result_)>0) {

         while ($data=$DB->fetch_array($result_)) {
            $query="UPDATE `glpi_plugin_dataflows_profiles`
                  SET `profiles_id` = '".$data["id"]."'
                  WHERE `id` = '".$data["id"]."';";
            $result=$DB->query($query);

         }
      }

      $query="ALTER TABLE `glpi_plugin_dataflows_profiles`
               DROP `name` ;";
      $result=$DB->query($query);
   }

   PluginDataflowsProfile::initProfile();
   PluginDataflowsProfile::createFirstAccess($_SESSION['glpiactiveprofile']['id']);
   $migration = new Migration("2.0.0");
   $migration->dropTable('glpi_plugin_dataflows_profiles');
   
   return true;
}

function plugin_dataflows_uninstall() {
   global $DB;
   
   include_once (Plugin::getPhpDir("dataflows")."/inc/profile.class.php");
   include_once (Plugin::getPhpDir("dataflows")."/inc/menu.class.php");
   
   $query = "SELECT `id` FROM `glpi_plugin_statecheck_tables` WHERE `name` = 'glpi_plugin_dataflows_configdfs'";
   $result = $DB->query($query);
   $rowcount = $DB->numrows($result);
   if ($rowcount > 0) {
      while ($data = $DB->fetchAssoc($result)) {
         $tableid = $data['id'];
         $rulequery = "SELECT `id` FROM `glpi_plugin_statecheck_rules` WHERE `plugin_statecheck_tables_id` = '".$tableid."'";
         $ruleresult = $DB->query($rulequery);
         while ($ruledata = $DB->fetchAssoc($ruleresult)) {
            $ruleid = $ruledata['id'];
            $query = "DELETE FROM `glpi_plugin_statecheck_ruleactions` WHERE `plugin_statecheck_rules_id` = '".$ruleid."'";
            $DB->query($query);
            $query = "DELETE FROM `glpi_plugin_statecheck_rulecriterias` WHERE `plugin_statecheck_rules_id` = '".$ruleid."'";
            $DB->query($query);
         }
         $query = "DELETE FROM `glpi_plugin_statecheck_rules` WHERE `plugin_statecheck_tables_id` = '".$tableid."'";
         $DB->query($query);
      }
      $query = "DELETE FROM `glpi_plugin_statecheck_tables` WHERE `name` like 'glpi_plugin_dataflows_%'";
      $result = $DB->query($query);
   }

	$tables = ["glpi_plugin_dataflows_dataflows",
					"glpi_plugin_dataflows_dataflows_items",
                    "glpi_plugin_dataflows_configdfs",
                    "glpi_plugin_dataflows_configdffieldgroups",
                    "glpi_plugin_dataflows_configdfhaligns",
                    "glpi_plugin_dataflows_configdfdbfieldtypes",
                    "glpi_plugin_dataflows_configdfdatatypes",
                    "glpi_plugin_dataflows_configdflinks",
					"glpi_plugin_dataflows_profiles"];

   $query = "SELECT `name` FROM `glpi_plugin_dataflows_configdflinks` WHERE `name` like 'PluginDataflows%' AND (`as_view_on` IS NULL OR `as_view_on` = '')";
   $result = $DB->query($query);
   while ($data = $DB->fetchAssoc($result)) {
      $tablename = CommonDBTM::getTable($data['name']);
      if (!in_array($tablename,$tables))
         $tables[] = $tablename;
   }

   foreach($tables as $table)
      $DB->query("DROP TABLE IF EXISTS `$table`;");

	$views = ["glpi_plugin_dataflows_sourceconnectors",
					"glpi_plugin_dataflows_toauthtypes",
					"glpi_plugin_dataflows_deststructuretypes",
					"glpi_plugin_dataflows_fromswcomponents",
					"glpi_plugin_dataflows_toswcomponents"];
				
   $query = "SELECT `name` FROM `glpi_plugin_dataflows_configdflinks` WHERE `name` LIKE 'PluginDataflows%' AND (`as_view_on` IS NOT NULL AND `as_view_on` <> '')";
   $result = $DB->query($query);
   while ($data = $DB->fetchAssoc($result)) {
      $tablename = CommonDBTM::getTable($data['name']);
      if (!in_array($tablename,$tables))
         $views[] = $tablename;
   }
				
	foreach($views as $view)
		$DB->query("DROP VIEW IF EXISTS `$view`;");

	$tables_glpi = ["glpi_displaypreferences",
               "glpi_documents_items",
               "glpi_savedsearches",
               "glpi_logs",
               "glpi_items_tickets",
               "glpi_notepads",
               "glpi_dropdowntranslations",
               "glpi_impactitems"];

   foreach($tables_glpi as $table_glpi)
      $DB->query("DELETE FROM `$table_glpi` WHERE `itemtype` LIKE 'PluginDataflows%' ;");

   $DB->query("DELETE
                  FROM `glpi_impactrelations`
                  WHERE `itemtype_source` IN ('PluginDataflowsDataflow')
                    OR `itemtype_impacted` IN ('PluginDataflowsDataflow')");

   if (class_exists('PluginDatainjectionModel')) {
      PluginDatainjectionModel::clean(['itemtype'=>'PluginDataflowsDataflow']);
   }
   
   //Delete rights associated with the plugin
   $profileRight = new ProfileRight();
   foreach (PluginDataflowsProfile::getAllRights() as $right) {
      $profileRight->deleteByCriteria(['name' => $right['field']]);
   }
   PluginDataflowsMenu::removeRightsFromSession();
   PluginDataflowsProfile::removeRightsFromSession();
   
   return true;
}

function plugin_dataflows_postinit() {
   global $PLUGIN_HOOKS;

   $PLUGIN_HOOKS['item_purge']['dataflows'] = [];

   foreach (PluginDataflowsDataflow::getTypes(true) as $type) {

      $PLUGIN_HOOKS['item_purge']['dataflows'][$type]
         = ['PluginDataflowsDataflow_Item','cleanForItem'];

      CommonGLPI::registerStandardTab($type, 'PluginDataflowsDataflow_Item');
   }
}

function plugin_dataflows_AssignToTicket($types) {

   if (Session::haveRight("plugin_dataflows_open_ticket", "1")) {
      $types['PluginDataflowsDataflow']=PluginDataflowsDataflow::getTypeName(2);
   }
   return $types;
}


// Define dropdown relations
function plugin_dataflows_getDataflowRelations() {
   global $DB;

   $plugin = new Plugin();
   if ($plugin->isActivated("dataflows")) {
		$tables =  ["glpi_plugin_dataflows_dataflows"=>["glpi_plugin_dataflows_dataflows_items"=>"plugin_dataflows_dataflows_id"],
					 "glpi_entities"=>["glpi_plugin_dataflows_dataflows"=>"entities_id"],
					 "glpi_groups"=>["glpi_plugin_dataflows_dataflows"=>"dataowner"],
					 "glpi_users"=>["glpi_plugin_dataflows_dataflows"=>"technicalmaintainer"]
					 ];

      $query = "SELECT `name` FROM `glpi_plugin_dataflows_configdflinks` WHERE `name` like 'PluginDataflows%'";
      $result = $DB->query($query);
      while ($data = $DB->fetchAssoc($result)) {
         $tablename = CommonDBTM::getTable($data['name']);
         if (!in_array($tablename,$tables)) {
            $fieldname = substr($tablename, 5)."_id";
            $tables[$tablename] = ["glpi_plugin_dataflows_dataflows"=>$fieldname];
         }
      }
      return $tables;
   }
   else
      return [];
}

// Define Dropdown tables to be manage in GLPI :
function plugin_dataflows_getDropdown() {
   global $DB;

   $plugin = new Plugin();
   if ($plugin->isActivated("dataflows")) {
      $classes = [//'PluginDataflowsDataflowsType'=>PluginDataflowsDataflowsType::getTypeName(2),
					 'PluginDataflowsConfigdf'=>PluginDataflowsConfigdf::getTypeName(2),
					 'PluginDataflowsConfigdfFieldgroup'=>PluginDataflowsConfigdfFieldgroup::getTypeName(2),
					 'PluginDataflowsConfigdfHalign'=>PluginDataflowsConfigdfHalign::getTypeName(2),
					 'PluginDataflowsConfigdfDbfieldtype'=>PluginDataflowsConfigdfDbfieldtype::getTypeName(2),
					 'PluginDataflowsConfigdfDatatype'=>PluginDataflowsConfigdfDatatype::getTypeName(2),
					 'PluginDataflowsConfigdfLink'=>PluginDataflowsConfigdfLink::getTypeName(2)
		];

      if ($DB->TableExists("glpi_plugin_dataflows_configdflinks") && $DB->TableExists("glpi_plugin_dataflows_configdfs")) {
         $query = "SELECT `glpi_plugin_dataflows_configdflinks`.`name` as `classname`, `glpi_plugin_dataflows_configdfs`.`description` as `typename` 
               FROM `glpi_plugin_dataflows_configdflinks` 
               JOIN `glpi_plugin_dataflows_configdfs`  ON `glpi_plugin_dataflows_configdflinks`.`id` = `glpi_plugin_dataflows_configdfs`.`plugin_dataflows_configdflinks_id` 
               WHERE `glpi_plugin_dataflows_configdflinks`.`name` like 'PluginDataflows%' AND (`glpi_plugin_dataflows_configdflinks`.`as_view_on` IS NULL OR `glpi_plugin_dataflows_configdflinks`.`as_view_on` = '')";
         $result = $DB->query($query);
         while ($data = $DB->fetchAssoc($result)) {
            $classname = $data['classname'];
            if (!in_array($classname,$classes))
               $classes[$classname] = $data['typename'];
         }
      }
      return $classes;
   }
   else
      return [];
}

////// SEARCH FUNCTIONS ///////() {

function plugin_dataflows_getAddSearchOptions($itemtype) {

   $sopt=[];

   if (in_array($itemtype, PluginDataflowsDataflow::getTypes(true))) {
      if (Session::haveRight("plugin_dataflows", READ)) {

         $sopt[2410]['table']         ='glpi_plugin_dataflows_dataflows';
         $sopt[2410]['field']         ='name';
         $sopt[2410]['name']          = PluginDataflowsDataflow::getTypeName(2)." - ".__('Name');
         $sopt[2410]['forcegroupby']  = true;
         $sopt[2410]['datatype']      = 'itemlink';
         $sopt[2410]['massiveaction'] = false;
         $sopt[2410]['itemlink_type'] = 'PluginDataflowsDataflow';
         $sopt[2410]['joinparams']    = ['beforejoin'
                                                => ['table'      => 'glpi_plugin_dataflows_dataflows_items',
                                                         'joinparams' => ['jointype' => 'itemtype_item']]];


         $sopt[2411]['table']        = 'glpi_plugin_dataflows_flowgroups';
         $sopt[2411]['field']        = 'name';
         $sopt[2411]['name']         = PluginDataflowsDataflow::getTypeName(2)." - ".PluginDataflowsFlowgroup::getTypeName(1);
         $sopt[2411]['forcegroupby'] = true;
         $sopt[2411]['joinparams']   = ['beforejoin' => [
                                                   ['table'      => 'glpi_plugin_dataflows_dataflows',
                                                         'joinparams' => $sopt[2410]['joinparams']]]];
         $sopt[2411]['datatype']       = 'dropdown';
         $sopt[2411]['massiveaction']  = false;

         $sopt[2412]['table']        = 'glpi_plugin_dataflows_states';
         $sopt[2412]['field']        = 'name';
         $sopt[2412]['name']         = PluginDataflowsDataflow::getTypeName(2)." - ".PluginDataflowsState::getTypeName(1);
         $sopt[2412]['forcegroupby'] = true;
         $sopt[2412]['joinparams']   = ['beforejoin' => [
                                                   ['table'      => 'glpi_plugin_dataflows_dataflows',
                                                         'joinparams' => $sopt[2410]['joinparams']]]];
         $sopt[2412]['datatype']       = 'dropdown';
         $sopt[2412]['massiveaction']  = false;

         $sopt[2413]['table']        = 'glpi_plugin_dataflows_types';
         $sopt[2413]['field']        = 'name';
         $sopt[2413]['name']         = PluginDataflowsDataflow::getTypeName(2)." - ".PluginDataflowsType::getTypeName(1);
         $sopt[2413]['forcegroupby'] = true;
         $sopt[2413]['joinparams']   = ['beforejoin' => [
                                                   ['table'      => 'glpi_plugin_dataflows_dataflows',
                                                         'joinparams' => $sopt[2410]['joinparams']]]];
         $sopt[2413]['datatype']       = 'dropdown';
         $sopt[2413]['massiveaction']  = false;
      }
   }
   /*if ($itemtype == 'Ticket') {
      if (Session::haveRight("plugin_dataflows", READ)) {
         $sopt[2414]['table']         = 'glpi_plugin_dataflows_dataflows';
         $sopt[2414]['field']         = 'name';
         $sopt[2414]['linkfield']     = 'items_id';
         $sopt[2414]['datatype']      = 'itemlink';
         $sopt[2414]['massiveaction'] = false;
         $sopt[2414]['name']          = __('Dataflow', 'dataflows')." - ".
                                        __('Name');
      }
   }*/

   return $sopt;
}

function plugin_dataflows_giveItem($type,$ID,$data,$num) {
   global $DB;

   $searchopt=&Search::getOptions($type);
   $table=$searchopt[$ID]["table"];
   $field=$searchopt[$ID]["field"];

   switch ($table.'.'.$field) {
      case "glpi_plugin_dataflows_dataflows_items.items_id" :
         $query_device = "SELECT DISTINCT `itemtype`
                     FROM `glpi_plugin_dataflows_dataflows_items`
                     WHERE `plugin_dataflows_dataflows_id` = '".$data['id']."'
                     ORDER BY `itemtype`";
         $result_device = $DB->query($query_device);
         $number_device = $DB->numrows($result_device);
         $y = 0;
         $out='';
         $dataflows=$data['id'];
         if ($number_device>0) {
            for ($i=0 ; $i < $number_device ; $i++) {
               $column = "name";
               $itemtype = $DB->result($result_device, $i, "itemtype");

               if (!class_exists($itemtype)) {
                  continue;
               }
               $item = new $itemtype();
               if ($item->canView()) {
                  $table_item = getTableForItemType($itemtype);

                  $query = "SELECT `".$table_item."`.*, `glpi_plugin_dataflows_dataflows_items`.`id` AS items_id, `glpi_entities`.`id` AS entity "
                  ." FROM `glpi_plugin_dataflows_dataflows_items`, `".$table_item
                  ."` LEFT JOIN `glpi_entities` ON (`glpi_entities`.`id` = `".$table_item."`.`entities_id`) "
                  ." WHERE `".$table_item."`.`id` = `glpi_plugin_dataflows_dataflows_items`.`items_id`
                  AND `glpi_plugin_dataflows_dataflows_items`.`itemtype` = '$itemtype'
                  AND `glpi_plugin_dataflows_dataflows_items`.`plugin_dataflows_dataflows_id` = '".$dataflows."' "
                  . getEntitiesRestrictRequest(" AND ",$table_item,'','',$item->maybeRecursive());

                  if ($item->maybeTemplate()) {
                     $query.=" AND `".$table_item."`.`is_template` = '0'";
                  }
                  $query.=" ORDER BY `glpi_entities`.`completename`, `".$table_item."`.`$column`";

                  if ($result_linked = $DB->query($query))
                     if ($DB->numrows($result_linked)) {
                        $item = new $itemtype();
                        while ($data = $DB->fetchAssoc($result_linked)) {
                           if ($item->getFromDB($data['id'])) {
                              $out .= $item::getTypeName(1)." - ".$item->getLink()."<br>";
                           }
                        }
                     } else
                        $out.= ' ';
               } else
                  $out.=' ';
            }
         }
         return $out;
         break;

      case 'glpi_plugin_dataflows_dataflows.name':
         if ($type == 'Ticket') {
            $dataflows_id = [];
            if ($data['raw']["ITEM_$num"] != '') {
               $dataflows_id = explode('$$$$', $data['raw']["ITEM_$num"]);
            } else {
               $dataflows_id = explode('$$$$', $data['raw']["ITEM_".$num."_2"]);
            }
            $ret = [];
            $paDataflow = new PluginDataflowsDataflow();
            foreach ($dataflows_id as $ap_id) {
               $paDataflow->getFromDB($ap_id);
               $ret[] = $paDataflow->getLink();
            }
            return implode('<br>', $ret);
         }
         break;

   }
   return "";
}

////// SPECIFIC MODIF MASSIVE FUNCTIONS ///////

function plugin_dataflows_MassiveActions($type) {

    $plugin = new Plugin();
    if ($plugin->isActivated('dataflows')) {
        if (in_array($type,PluginDataflowsDataflow::getTypes(true))) {
            return ['PluginDataflowsDataflow'.MassiveAction::CLASS_ACTION_SEPARATOR.'plugin_dataflows__add_item' =>
                                                              __('Associate to the dataflow', 'dataflows')];
        }
    }
    return [];
}

function plugin_datainjection_populate_dataflows() {
   global $INJECTABLE_TYPES;
   $INJECTABLE_TYPES['PluginDataflowsDataflowInjection'] = 'datainjection';
}

function hook_pre_item_add_dataflows_configdflink(CommonDBTM $item) {
   global $DB;
   $dir = Plugin::getPhpDir("dataflows", true);
   $newclassname = $item->input['name'];
   $newistreedropdown = $item->input['is_tree_dropdown'];
   $newisentitylimited = $item->input['is_entity_limited'];
   $newasviewon = $item->input['as_view_on'];
   $newviewlimit = str_replace("\'", "'", $item->input['viewlimit']); // unescape single quotes
  if (substr($newclassname, 0, 15) == 'PluginDataflows') {
      $rootname = strtolower(substr($newclassname, 15));
      $tablename = 'glpi_plugin_dataflows_'.getPlural($rootname);
      $fieldname = 'plugin_dataflows_'.getPlural($rootname).'_id';
      if (!empty($newasviewon)) {
         $entities = ($newisentitylimited?" `entities_id`,":"");
         $name = ($newistreedropdown?" `completename`,":" `name`,");
         if (!$newistreedropdown) {
            // new simple dropdown view
            $query = "CREATE VIEW `$tablename` (`id`,$entities `name`, `comment`) AS 
                  SELECT `id`,$entities `name`, `comment` FROM $newasviewon".(empty($newviewlimit)?"":" WHERE $newviewlimit");
         } 
         else { // new treedropdon view
            $query = "CREATE VIEW `$tablename` (`id`,$entities `name`, `comment`, `completename`, `level`, `is_recursive`) AS 
                  SELECT `id`,$entities `name`, `comment`, `completename`, `level`, `is_recursive` FROM $newasviewon".(empty($newviewlimit)?"":" WHERE $newviewlimit");
         }
         $result = $DB->query($query);
      }
      else {
         $entities = ($newisentitylimited?"`entities_id` INT(11) UNSIGNED NOT NULL DEFAULT 0,":"");
         if (!$newistreedropdown) { //dropdown->create table
            $query = "CREATE TABLE IF NOT EXISTS `".$tablename."` (
                  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,".
                  $entities.
                  "`name` VARCHAR(45) NOT NULL,
                  `comment` VARCHAR(255) NULL,
                  `completename` MEDIUMTEXT NULL,
                  PRIMARY KEY (`id`) ,
                  UNIQUE INDEX `".$tablename."_name` (`name`) )
                  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
            $result = $DB->query($query);
         }
         else { //treedropdown->create table
            $query = "CREATE TABLE IF NOT EXISTS `".$tablename."` (
                        `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,".
                        $entities.
                        "`is_recursive` BIT NOT NULL DEFAULT 0,
                        `name` VARCHAR(45) NOT NULL,
                        $fieldname INT(11) UNSIGNED NOT NULL DEFAULT 0,
                        `completename` MEDIUMTEXT NULL,
                        `comment` VARCHAR(255) NULL,
                        `level` INT NOT NULL DEFAULT 0,
                        `sons_cache` LONGTEXT NULL,
                        `ancestors_cache` LONGTEXT NULL,
                        PRIMARY KEY (`id`) ,
                        UNIQUE INDEX `".$tablename."_name` (`name`) )
                        DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
            $result = $DB->query($query);
         }
      }
      create_plugin_dataflows_classfiles($dir, $newclassname, $newistreedropdown);
   }
}
function hook_pre_item_update_dataflows_configdflink(CommonDBTM $item) {
   global $DB;
   $dir = Plugin::getPhpDir("dataflows", true);
   $newclassname = $item->input['name'];
   $newistreedropdown = $item->input['is_tree_dropdown'];
   $newasviewon = $item->input['as_view_on'];
   $newviewlimit = str_replace("\'", "'", $item->input['viewlimit']); // unescape single quotes
   $oldclassname = $item->fields['name'];
   $oldistreedropdown = $item->fields['is_tree_dropdown'];
   $oldasviewon = $item->fields['as_view_on'];
   if (substr($newclassname, 0, 15) == 'PluginDataflows') {
      // class is owned by this plugin
      $newrootname = strtolower(substr($newclassname, 15));
      $newfilename = $newrootname;
      $newtablename = 'glpi_plugin_dataflows_'.getPlural($newrootname);
      $newfieldname = 'plugin_dataflows_'.getPlural($newrootname).'_id';
      if (substr($oldclassname, 0, 15) == 'PluginDataflows') { 
         //old and new types are owned by this plugin
         if ($oldclassname != $newclassname) { 
            //dropdown name modified->rename table
            $oldrootname = strtolower(substr($oldclassname, 15));
            $oldfilename = $oldrootname;
            $oldtablename = 'glpi_plugin_dataflows_'.getPlural($oldrootname);
            $oldfieldname = 'plugin_dataflows_'.getPlural($oldrootname).'_id';
            $query = "RENAME TABLE `".$oldtablename."` TO `".$newtablename."`";
            $result = $DB->query($query);
            $query = "UPDATE `glpi_plugin_dataflows_configdflinks` SET `name` = '".$newclassname."' WHERE `name` = '".$oldclassname."'";
            $result = $DB->query($query);
         }
         else {// no change dropdown name
            // if dropdown table is a view, replace the old view
            if (!empty($newasviewon)) {
               $entities = ($newisentitylimited?" `entities_id`,":"");
               $name = ($newistreedropdown?" `completename`,":" `name`,");
               if (!$newistreedropdown) {
                  // new simple dropdown view
                  $query = "CREATE OR REPLACE VIEW `$newtablename` (`id`,$entities `name`, `comment`) AS 
                        SELECT `id`,$entities `name`, `comment` FROM $newasviewon".(empty($newviewlimit)?"":" WHERE $newviewlimit");
               } 
               else { // new treedropdon view
                  $query = "CREATE OR REPLACE VIEW `$newtablename` (`id`,$entities `name`, `comment`, `completename`, `level`, `is_recursive`) AS 
                        SELECT `id`,$entities `name`, `comment`, `completename`, `level`, `is_recursive` FROM $newasviewon".(empty($newviewlimit)?"":" WHERE $newviewlimit");
               }
               $result = $DB->query($query);
            }
            else {
               // if dropdown table is really a table ...
               if (!$oldistreedropdown && $newistreedropdown) {
               // 'is_tree_dropdown' has changed
               // old type was dropdown and new one is treedropdown=>add the needed fields
                  $query = "ALTER TABLE $newtablename
                     ADD COLUMN `is_recursive` BIT NOT NULL DEFAULT 0 AFTER `id`,
                     ADD COLUMN $newfieldname INT(11) UNSIGNED NOT NULL DEFAULT 0 AFTER `name`,
                     ADD COLUMN `level` INT NOT NULL DEFAULT 0 AFTER `completename`,
                     ADD COLUMN `sons_cache` LONGTEXT NULL AFTER `level`,
                     ADD COLUMN `ancestors_cache` LONGTEXT NULL AFTER `sons_cache`";
                  $result = $DB->query($query);
               }
               else if ($oldistreedropdown && !$newistreedropdown) {
               // old type was treedropdown and new one is dropdown=>drop the unneeded fields
                  $query = "ALTER TABLE $newtablename
                     DROP COLUMN `is_recursive`,
                     DROP COLUMN $newfieldname,
                     DROP COLUMN `level`,
                     DROP COLUMN `sons_cache`,
                     DROP COLUMN `ancestors_cache`";
                  $result = $DB->query($query);
               }
               // 'is_entity_limited' has changed
               if (!$item->fields['is_entity_limited'] && $item->input['is_entity_limited']) { // 'is_entity_limited' changed from no to yes
               // => add 'entities_id' column to dropdown table
                  $query = "ALTER TABLE $newtablename ADD COLUMN IF NOT EXISTS `entities_id` INT(11) UNSIGNED NOT NULL DEFAULT 0 AFTER `id`";
                  $result = $DB->query($query);
               }
               else if ($item->fields['is_entity_limited'] && !$item->input['is_entity_limited']) { // 'is_entity_limited' changed from yes to no
               // => drop 'entities_id' column from dropdown table
                  $query = "ALTER TABLE $newtablename DROP COLUMN `entities_id`";
                  $result = $DB->query($query);
               }
            }
         }
      }
      else {// old type wasn't owned by this plugin, but the new one is well owned
         //dropdown new->create table or view
         if (!empty($newasviewon)) {
            $entities = ($newisentitylimited?" `entities_id`,":"");
            $name = ($newistreedropdown?" `completename`,":" `name`,");
            if (!$newistreedropdown) {
               // new simple dropdown view
               $query = "CREATE VIEW `$tablename` (`id`,$entities `name`, `comment`) AS 
                  SELECT `id`,$entities `name`, `comment` FROM $newasviewon".(empty($newviewlimit)?"":" WHERE $newviewlimit");
            } 
            else { // new treedropdon view
               $query = "CREATE VIEW `$tablename` (`id`,$entities `name`, `comment`, `completename`, `level`, `is_recursive`) AS 
                  SELECT `id`,$entities `name`, `comment`, `completename`, `level`, `is_recursive` FROM $newasviewon".(empty($newviewlimit)?"":" WHERE $newviewlimit");
            }
            $result = $DB->query($query);
         }
         else {
            $entities = ($item->input['is_entity_limited']?"`entities_id` INT(11) UNSIGNED NOT NULL DEFAULT 0,":""); // with or without 'entities_id' column
            if (!$newistreedropdown) {
               // new simple dropdown table
               $query = "CREATE TABLE IF NOT EXISTS `".$newtablename."` (
                  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,".
                  $entities.
                  "`name` VARCHAR(45) NOT NULL,
                  `comment` VARCHAR(255) NULL,
                  `completename` MEDIUMTEXT NULL,
                  PRIMARY KEY (`id`) ,
                  UNIQUE INDEX `".$newtablename."_name` (`name`) )
                  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
            } 
            else { // new treedropdon table
               $query = "CREATE TABLE IF NOT EXISTS `".$newtablename."` (
                  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,".
                  $entities.
                  "`is_recursive` BIT NOT NULL DEFAULT 0,
                  `name` VARCHAR(45) NOT NULL,
                  $newfieldname INT(11) UNSIGNED NOT NULL DEFAULT 0,
                  `completename` MEDIUMTEXT NULL,
                  `comment` VARCHAR(255) NULL,
                  `level` INT NOT NULL DEFAULT 0,
                  `sons_cache` LONGTEXT NULL,
                  `ancestors_cache` LONGTEXT NULL,
                  PRIMARY KEY (`id`) ,
                  UNIQUE INDEX `".$newtablename."_name` (`name`) )
                  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
            }
            $result = $DB->query($query);
         }
      }
      create_plugin_dataflows_classfiles($dir, $newclassname, $newistreedropdown);
   }
   if (substr($oldclassname, 0, 15) == 'PluginDataflows'
   && $oldclassname != $newclassname) {
      //old dropdown was owned by this plugin -> drop table if it hasn't been renamed
      $oldrootname = strtolower(substr($oldclassname, 15));
      $oldfilename = $oldrootname;
      $oldtablename = 'glpi_plugin_dataflows_'.getPlural($oldrootname);
      $oldfieldname = 'plugin_dataflows_'.getPlural($oldrootname).'_id';
      $tableorview = empty($oldasviewon)?"TABLE":"VIEW";
      $query = "DROP $tableorview IF EXISTS `".$oldtablename."`";
      $result = $DB->query($query);
      $query = "DELETE FROM `glpi_plugin_dataflows_configdflinks` WHERE `name` = '".$oldclassname."'";
      $result = $DB->query($query);
      // delete files in inc and front directories
      if (file_exists($dir.'/inc/'.$oldfilename.'.class.php')) 
         unlink($dir.'/inc/'.$oldfilename.'.class.php');
      if (file_exists($dir.'/front/'.$oldfilename.'.form.php')) 
         unlink($dir.'/front/'.$oldfilename.'.form.php');
      if (file_exists($dir.'/front/'.$oldfilename.'.php')) 
         unlink($dir.'/front/'.$oldfilename.'.php');
   }
}
function hook_pre_item_purge_dataflows_configdflink(CommonDBTM $item) {
   global $DB;
   $dir = Plugin::getPhpDir("dataflows", true);
   $oldclassname = $item->fields['name'];
   $oldasviewon = $item->fields['as_view_on'];
   $oldrootname = strtolower(substr($oldclassname, 15));
   $oldfilename = $oldrootname;
   $oldid = $item->fields['id'];
   // suppress in glpi_plugin_dataflows_configdfs
   $query = "UPDATE `glpi_plugin_dataflows_configdfs` SET `plugin_dataflows_configdflinks_id` = 0 WHERE `plugin_dataflows_configdflinks_id` = '".$oldid."'";
   $result = $DB->query($query);
   if (substr($oldclassname, 0, 15) == 'PluginDataflows') {
      $oldtablename = 'glpi_plugin_dataflows_'.getPlural($oldrootname);
      $oldfieldname = 'plugin_dataflows_'.getPlural($oldrootname).'_id';
      $tableorview = empty($oldasviewon)?"TABLE":"VIEW";
      $query = "DROP $tableorview IF EXISTS `".$oldtablename."`";
      $result = $DB->query($query);
      // delete files in inc and front directories
      if (file_exists($dir.'/inc/'.$oldfilename.'.class.php')) 
         unlink($dir.'/inc/'.$oldfilename.'.class.php');
      if (file_exists($dir.'/front/'.$oldfilename.'.form.php')) 
         unlink($dir.'/front/'.$oldfilename.'.form.php');
      if (file_exists($dir.'/front/'.$oldfilename.'.php')) 
         unlink($dir.'/front/'.$oldfilename.'.php');
   }
   return true;
}
function create_plugin_dataflows_classfiles($dir, $newclassname, $istreedropdown = false) {
   if (substr($newclassname, 0, 15) == 'PluginDataflows') {
      $newfilename = strtolower(substr($newclassname, 15));
      $dropdowntype = 'CommonDropdown';
      if ($istreedropdown) $dropdowntype = 'CommonTreeDropdown';
      // create files in inc and front directories, with read/write access
      file_put_contents($dir.'/inc/'.$newfilename.'.class.php', 
      "<?php
/*
 -------------------------------------------------------------------------
 Dataflows plugin for GLPI
 Copyright (C) 2009-2023 by Eric Feron.
 -------------------------------------------------------------------------

 LICENSE
      
 This file is part of Dataflows.

 Dataflows is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 at your option any later version.

 Dataflows is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with Dataflows. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 */
      if (!defined('GLPI_ROOT')) {
         die('Sorry. You cannott access directly to this file');
      }
      class $newclassname extends $dropdowntype {
      }
      ?>");
      file_put_contents($dir.'/front/'.$newfilename.'.form.php', 
      "<?php
/*
 -------------------------------------------------------------------------
 Dataflows plugin for GLPI
 Copyright (C) 2009-2023 by Eric Feron.
 -------------------------------------------------------------------------

 LICENSE
      
 This file is part of Dataflows.

 Dataflows is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 at your option any later version.

 Dataflows is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with Dataflows. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 */
      include ('../../../inc/includes.php');
      \$dropdown = new $newclassname();
      include (GLPI_ROOT . '/front/dropdown.common.form.php');
      ?>");
      file_put_contents($dir.'/front/'.$newfilename.'.php', 
      "<?php
/*
 -------------------------------------------------------------------------
 Dataflows plugin for GLPI
 Copyright (C) 2009-2023 by Eric Feron.
 -------------------------------------------------------------------------

 LICENSE
      
 This file is part of Dataflows.

 Dataflows is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 at your option any later version.

 Dataflows is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with Dataflows. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 */
      include ('../../../inc/includes.php');
      \$dropdown = new $newclassname();
      include (GLPI_ROOT . '/front/dropdown.common.php');
      ?>");
      chmod($dir.'/inc/'.$newfilename.'.class.php', 0660);
      chmod($dir.'/front/'.$newfilename.'.form.php', 0660);
      chmod($dir.'/front/'.$newfilename.'.php', 0660);
      // refresh with new files
//      header("Refresh:0");
//   Session::addMessageAfterRedirect(__('Please, refresh the display', 'dataflows'));
   }
   return true;
}
?>
