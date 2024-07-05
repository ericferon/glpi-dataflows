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

// Init the hooks of the plugins -Needed
function plugin_init_dataflows() {
   global $PLUGIN_HOOKS, $CFG_GLPI;

   $PLUGIN_HOOKS['csrf_compliant']['dataflows'] = true;
   $PLUGIN_HOOKS['change_profile']['dataflows'] = ['PluginDataflowsProfile', 'initProfile'];
   $PLUGIN_HOOKS['assign_to_ticket']['dataflows'] = true;
   
   //$PLUGIN_HOOKS['assign_to_ticket_dropdown']['dataflows'] = true;
   //$PLUGIN_HOOKS['assign_to_ticket_itemtype']['dataflows'] = ['PluginDataflowsDataflow_Item'];
   
   Plugin::registerClass('PluginDataflowsDataflow', [
//         'linkgroup_tech_types'   => true,
//         'linkuser_tech_types'    => true,
         'document_types'         => true,
         'ticket_types'           => true,
         'helpdesk_visible_types' => true//,
//         'addtabon'               => 'Supplier'
   ]);
   Plugin::registerClass('PluginDataflowsProfile',
                         ['addtabon' => 'Profile']);
                         
   //Plugin::registerClass('PluginDataflowsDataflow_Item',
   //                      ['ticket_types' => true]);

   $CFG_GLPI['impact_asset_types']['PluginDataflowsDataflow'] = Plugin::getWebDir("dataflows", false)."/dataflows.png";

   // Add links to other plugins
   $types = ['PluginAccountsAccount'];
   foreach ($types as $itemtype) {
      if (class_exists($itemtype)) {
         $itemtype::registerType('PluginDataflowsDataflow');
      }
   }
// Add other plugin associations (in side panel)
   $associatedtypes = [];
   if (class_exists('PluginDataflowsDataflow'))
	  foreach ($associatedtypes as $itemtype) {
		if (class_exists($itemtype)) {
			$itemtype::registerType('PluginDataflowsDataflow');
		}
	  }
//   if (class_exists('PluginAccountsAccount')) {
//      PluginAccountsAccount::registerType('PluginDataflowsDataflow');
//   }
      
   if (Session::getLoginUserID()) {

      // link to fields plugin
      $plugin = new Plugin();
      if ($plugin->isActivated('fields')
      && Session::haveRight("plugin_dataflows", READ))
      {
         $PLUGIN_HOOKS['plugin_fields']['dataflows'] = 'PluginDataflowsDataflow';
      }

      if (Session::haveRight("plugin_dataflows", READ)) {

         $PLUGIN_HOOKS['menu_toadd']['dataflows']['assets'] = 'PluginDataflowsMenu';
      }

      if (Session::haveRight("plugin_dataflows_configuration", READ)) {

         $PLUGIN_HOOKS['menu_toadd']['dataflows']['config'] = 'PluginDataflowsConfigdfMenu';
      }

      if (Session::haveRight("plugin_dataflows", READ)
          || Session::haveRight("config", UPDATE)) {
         $PLUGIN_HOOKS['config_page']['dataflows']        = 'front/configdf.php';
      }

      if (Session::haveRight("plugin_dataflows", UPDATE)) {
         $PLUGIN_HOOKS['use_massive_action']['dataflows']=1;
      }

      if (class_exists('PluginDataflowsDataflow_Item')) { // only if plugin activated
         $PLUGIN_HOOKS['plugin_datainjection_populate']['dataflows'] = 'plugin_datainjection_populate_dataflows';
      }

      // End init, when all types are registered
      $PLUGIN_HOOKS['post_init']['dataflows'] = 'plugin_dataflows_postinit';

      // Import from Data_Injection plugin
      $PLUGIN_HOOKS['migratetypes']['dataflows'] = 'plugin_datainjection_migratetypes_dataflows';
	  
      $PLUGIN_HOOKS['pre_item_update']['dataflows'] = ['PluginDataflowsConfigdf' => 'hook_pre_item_update_dataflows_configdf', 
                                                   'PluginDataflowsConfigdfLink' => 'hook_pre_item_update_dataflows_configdflink'];
      $PLUGIN_HOOKS['pre_item_add']['dataflows'] = ['PluginDataflowsConfigdf' => 'hook_pre_item_add_dataflows_configdf', 
                                                   'PluginDataflowsConfigdfLink' => 'hook_pre_item_add_dataflows_configdflink'];
      $PLUGIN_HOOKS['pre_item_purge']['dataflows'] = ['PluginDataflowsConfigdf' => 'hook_pre_item_purge_dataflows_configdf', 
                                                   'PluginDataflowsConfigdfLink' => 'hook_pre_item_purge_dataflows_configdflink'];
   }
}

// Get the name and the version of the plugin - Needed
function plugin_version_dataflows() {

   return array (
      'name' => _n('Dataflow', 'Dataflows', 2, 'dataflows'),
      'version' => '3.0.11',
      'author'  => "Eric Feron",
      'license' => 'GPLv2+',
      'homepage'=> 'https://github.com/ericferon/glpi-dataflows',
      'requirements' => [
         'glpi' => [
            'min' => '9.5',
            'dev' => false
         ]
      ]
   );

}

// Optional : check prerequisites before install : may print errors or add to message after redirect
function plugin_dataflows_check_prerequisites() {
   global $DB;
   if (version_compare(GLPI_VERSION, '10.0', 'lt')
       || version_compare(GLPI_VERSION, '10.1', 'ge')) {
      if (method_exists('Plugin', 'messageIncompatible')) {
         echo Plugin::messageIncompatible('core', '10.0');
      }
      return false;
   } else {
		$query = "select * from glpi_plugins where directory in ('archisw', 'statecheck') and state = 1";
		$result_query = $DB->query($query);
		if($DB->numRows($result_query) == 2) {
			return true;
		} else {
			echo "The 2 plugins 'archisw' (a.k.a Apps structure inventory) and 'statecheck' must be installed before using 'dataflows' (Dataflows)";
		}
	}
}

// Uninstall process for plugin : need to return true if succeeded : may display messages or add to message after redirect
function plugin_dataflows_check_config() {
   return true;
}

function plugin_datainjection_migratetypes_dataflows($types) {
   $types[2400] = 'PluginDataflowsDataflow';
   return $types;
}

// Uninstall process for plugin : need to return true if succeeded : may display messages or add to message after redirect
function hook_pre_item_add_dataflows_configdf(CommonDBTM $item) {
   global $DB;
   Toolbox::logInFile("debug",print_r($item, true));
   $fieldname = $item->fields['name'];
   $dbfield = new PluginDataflowsConfigdfDbfieldtype;
   if ($dbfield->getFromDB($item->fields['plugin_dataflows_configdfdbfieldtypes_id'])) {
      $fieldtype = $dbfield->fields['name'];
      $query = "ALTER TABLE `glpi_plugin_dataflows_dataflows` ADD COLUMN IF NOT EXISTS $fieldname $fieldtype";
      if($item->fields['plugin_dataflows_configdfdatatypes_id'] == 6) {// if dropdown, add key
         $query .= ", ADD KEY IF NOT EXISTS $fieldname ($fieldname)";
      }
      $result = $DB->query($query);
      return true;
   }
   return false;
}
function hook_pre_item_update_dataflows_configdf(CommonDBTM $item) {
   global $DB;
   $oldfieldname = $item->fields['name'];
   $newfieldname = $item->input['name'];
   $dbfield = new PluginDataflowsConfigdfDbfieldtype;
   if ($dbfield->getFromDB($item->fields['plugin_dataflows_configdfdbfieldtypes_id'])) {
      $fieldtype = $dbfield->fields['name'];
      if ($oldfieldname != $newfieldname) {
         $query = "ALTER TABLE `glpi_plugin_dataflows_dataflows` CHANGE COLUMN $oldfieldname $newfieldname $fieldtype";
      } else {
         $query = "ALTER TABLE `glpi_plugin_dataflows_dataflows` MODIFY $newfieldname $fieldtype";
      }
      if($item->input['plugin_dataflows_configdfdatatypes_id'] == 6) {// if dropdown, add key
         $query .= ", ADD KEY IF NOT EXISTS $newfieldname ($newfieldname)";
      }
      $result = $DB->query($query);
      return true;
   }
   return false;
}
function hook_pre_item_purge_dataflows_configdf(CommonDBTM $item) {
   global $DB;
   $oldid = $item->fields['id'];
   $oldfieldname = $item->fields['name'];
   // suppress in glpi_plugin_dataflows_labeltranslations
   $query = "DELETE FROM `glpi_plugin_dataflows_labeltranslations` WHERE `items_id` = '".$oldid."'";
   $result = $DB->query($query);
   // suppress column
   $query = "ALTER TABLE `glpi_plugin_dataflows_dataflows` DROP COLUMN IF EXISTS $oldfieldname";
   $result = $DB->query($query);
   return true;
}
?>
