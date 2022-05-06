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
   global $PLUGIN_HOOKS;

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

   if (class_exists('PluginAccountsAccount')) {
      PluginAccountsAccount::registerType('PluginDataflowsDataflow');
   }
      
   if (Session::getLoginUserID()) {

      if (Session::haveRight("plugin_dataflows", READ)) {

         $PLUGIN_HOOKS['menu_toadd']['dataflows'] = ['assets'   => 'PluginDataflowsMenu'];
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
	  
   }
}

// Get the name and the version of the plugin - Needed
function plugin_version_dataflows() {

   return array (
      'name' => _n('Dataflow', 'Dataflows', 2, 'dataflows'),
      'version' => '2.2.9',
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
   if (version_compare(GLPI_VERSION, '9.5', 'lt')
       || version_compare(GLPI_VERSION, '10.1', 'ge')) {
      if (method_exists('Plugin', 'messageIncompatible')) {
         echo Plugin::messageIncompatible('core', '9.5');
      }
      return false;
   } else {
		$query = "select * from glpi_plugins where directory = 'archisw' and state = 1";
		$result_query = $DB->query($query);
		if($DB->numRows($result_query) == 1) {
			return true;
		} else {
			echo "the plugin 'archisw' must be installed before using 'dataflows'";
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

?>
