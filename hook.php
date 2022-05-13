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

		$DB->runFile(Plugin::getPhpDir("dataflows")."/sql/empty-1.2.5.sql");
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
	}
    if (class_exists('PluginAccountsAccount')) {
			$DB->runFile(Plugin::getPhpDir("dataflows")."/sql/addon-accounts-1.2.3.sql");
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
   
	$tables = ["glpi_plugin_dataflows_dataflows",
					"glpi_plugin_dataflows_dataflows_items",
					"glpi_plugin_dataflows_profiles",
					"glpi_plugin_dataflows_states",
					"glpi_plugin_dataflows_types",
					"glpi_plugin_dataflows_categories",
					"glpi_plugin_dataflows_indicators",
					"glpi_plugin_dataflows_flowgroups",
					"glpi_plugin_dataflows_servicelevels",
					"glpi_plugin_dataflows_transferprotocols",
					"glpi_plugin_dataflows_sourceconnectors",
					"glpi_plugin_dataflows_triggertypes",
					"glpi_plugin_dataflows_transferfreqs",
					"glpi_plugin_dataflows_transfertimetables",
					"glpi_plugin_dataflows_holidayactions",
					"glpi_plugin_dataflows_srcuris",
					"glpi_plugin_dataflows_srcpreprocs",
					"glpi_plugin_dataflows_desturis",
					"glpi_plugin_dataflows_destpostprocs",
					"glpi_plugin_dataflows_errorhandlings"];

   foreach($tables as $table)
      $DB->query("DROP TABLE IF EXISTS `$table`;");

	$views = ["glpi_plugin_dataflows_sourceconnectors",
					"glpi_plugin_dataflows_fromswcomponents",
					"glpi_plugin_dataflows_toswcomponents"];
				
	foreach($views as $view)
		$DB->query("DROP VIEW IF EXISTS `$view`;");

	$tables_glpi = ["glpi_displaypreferences",
               "glpi_documents_items",
               "glpi_savedsearches",
               "glpi_logs",
               "glpi_items_tickets",
               "glpi_notepads",
               "glpi_dropdowntranslations"];

   foreach($tables_glpi as $table_glpi)
      $DB->query("DELETE FROM `$table_glpi` WHERE `itemtype` LIKE 'PluginDataflows%' ;");

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

/*
function plugin_dataflows_AssignToTicketDropdown($data) {
   global $DB, $CFG_GLPI;

   if ($data['itemtype'] == 'PluginDataflowsDataflow') {
      $table = getTableForItemType($data["itemtype"]);
      $rand = mt_rand();
      $field_id = Html::cleanId("dropdown_".$data['myname'].$rand);

      $p = ['itemtype'            => $data["itemtype"],
                 'entity_restrict'     => $data['entity_restrict'],
                 'table'               => $table,
                 'myname'              => $data["myname"]];

      if(isset($data["used"]) && !empty($data["used"])){
         if(isset($data["used"][$data["itemtype"]])){
            $p["used"] = $data["used"][$data["itemtype"]];
         }
      }

      echo Html::jsAjaxDropdown($data['myname'], $field_id,
                                 $CFG_GLPI['root_doc']."/ajax/getDropdownFindNum.php",
                                 $p);
      // Auto update summary of active or just solved tickets
      $params = ['items_id' => '__VALUE__',
                      'itemtype' => $data['itemtype']];

      Ajax::updateItemOnSelectEvent($field_id,"item_ticket_selection_information",
                                    $CFG_GLPI["root_doc"]."/ajax/ticketiteminformation.php",
                                    $params);

   } else if ($data['itemtype'] == 'PluginDataflowsDataflow_Item') {
      $sql = "SELECT `glpi_plugin_dataflows_dataflows`.`name`, "
              . "    `items_id`, `itemtype`, `glpi_plugin_dataflows_dataflows_items`.`id` "
              . " FROM `glpi_plugin_dataflows_dataflows_items`"
              . " LEFT JOIN `glpi_plugin_dataflows_dataflows`"
              . "    ON `plugin_dataflows_dataflows_id` = `glpi_plugin_dataflows_dataflows`.`id`";

      $result = $DB->query($sql);
      $elements = [];
      while ($res = $DB->fetch_array($result)) {
         $itemtype = $res['itemtype'];
         $item = new $itemtype;
         $item->getFromDB($res['items_id']);
         $elements[$res['name']][$res['id']] = $item->getName();
      }
      Dropdown::showFromArray('items_id', $elements, []);
   }
}


function plugin_dataflows_AssignToTicketDisplay($data) {
   global $DB;

   if ($data['itemtype'] == 'PluginDataflowsDataflow_Item') {
      $paDataflow = new PluginDataflowsDataflow();
      $item = new PluginDataflowsDataflow_Item();
      $itemtype = $data['data']['itemtype'];
      $iteminv = new $itemtype;
      $iteminv->getFromDB($data['data']['items_id']);
      $paDataflow->getFromDB($data['data']['plugin_dataflows_dataflows_id']);

      echo "<tr class='tab_bg_1'>";
      if ($data['canedit']) {
         echo "<td width='10'>";
         Html::showMassiveActionCheckBox('Item_Ticket', $data['data']["IDD"]);
         echo "</td>";
      }
      $typename = "<i>".PluginDataflowsDataflow::getTypeName()."</i><br/>".
              $iteminv->getTypeName();
      echo "<td class='center top' rowspan='1'>".$typename."</td>";
      echo "<td class='center'>";
      echo "<i>".Dropdown::getDropdownName("glpi_entities", $paDataflow->fields['entities_id'])."</i>";
      echo "<br/>";
      echo Dropdown::getDropdownName("glpi_entities", $iteminv->fields['entities_id']);
      echo "</td>";

      $linkDataflow     = Toolbox::getItemTypeFormURL('PluginDataflowsDataflow');
      $namelinkDataflow = "<a href=\"".$linkDataflow."?id=".
              $paDataflow->fields['id']."\">".$paDataflow->getName()."</a>";
      $link     = Toolbox::getItemTypeFormURL($data['data']['itemtype']);
      $namelink = "<a href=\"".$link."?id=".$data['data']['items_id']."\">".$iteminv->getName()."</a>";
      echo "<td class='center".
               (isset($iteminv->fields['is_deleted']) && $iteminv->fields['is_deleted'] ? " tab_bg_2_2'" : "'");
      echo "><i>".$namelinkDataflow."</i><br/>".$namelink;
      echo "</td>";
      echo "<td class='center'><i>".(isset($paDataflow->fields["serial"])? "".$paDataflow->fields["serial"]."" :"-").
              "</i><br/>".(isset($iteminv->fields["serial"])? "".$iteminv->fields["serial"]."" :"-").
           "</td>";
      echo "<td class='center'>".
             "<i>".(isset($iteminv->fields["otherserial"])? "".$iteminv->fields["otherserial"]."" :"-")."</i><br/>".
             (isset($iteminv->fields["otherserial"])? "".$iteminv->fields["otherserial"]."" :"-")."</td>";
      echo "</tr>";
      return false;
   }
   return true;
}


function plugin_dataflows_AssignToTicketGiveItem($data) {
   if ($data['itemtype'] == 'PluginDataflowsDataflow_Item') {
      $paDataflow = new PluginDataflowsDataflow();
      $paDataflow_item = new PluginDataflowsDataflow_Item();

      $paDataflow_item->getFromDB($data['name']);
      $itemtype = $paDataflow_item->fields['itemtype'];
      $paDataflow->getFromDB($paDataflow_item->fields['plugin_dataflows_dataflows_id']);
      $item = new $itemtype;
      $item->getFromDB($paDataflow_item->fields['items_id']);
      return $item->getLink(['comments' => true])." (".
              $paDataflow->getLink(['comments' => true]).")";
   }
}
*/

// Define dropdown relations
function plugin_dataflows_getDataflowRelations() {

   $plugin = new Plugin();
   if ($plugin->isActivated("dataflows"))
		return ["glpi_plugin_dataflows_fromswcomponents"=>["glpi_plugin_dataflows_dataflows"=>"plugin_dataflows_fromswcomponents_id"],
					 "glpi_plugin_dataflows_toswcomponents"=>["glpi_plugin_dataflows_dataflows"=>"plugin_dataflows_toswcomponents_id"],
					 "glpi_plugin_dataflows_dataflows"=>["glpi_plugin_dataflows_dataflows_items"=>"plugin_dataflows_dataflows_id"],
					 "glpi_plugin_dataflows_flowgroups"=>["glpi_plugin_dataflows_dataflows"=>"plugin_dataflows_flowgroups_id"],
					 "glpi_plugin_dataflows_types"=>["glpi_plugin_dataflows_dataflows"=>"plugin_dataflows_types_id"],
					 "glpi_plugin_dataflows_indicators"=>["glpi_plugin_dataflows_dataflows"=>"plugin_dataflows_indicators_id"],
					 "glpi_plugin_dataflows_states"=>["glpi_plugin_dataflows_dataflows"=>"plugin_dataflows_states_id"],
					 "glpi_plugin_dataflows_servicelevels"=>["glpi_plugin_dataflows_dataflows"=>"plugin_dataflows_servicelevels_id"],
					 "glpi_plugin_dataflows_transferprotocols"=>["glpi_plugin_dataflows_dataflows"=>"plugin_dataflows_transferprotocols_id"],
					 "glpi_plugin_dataflows_sourceconnectors"=>["glpi_plugin_dataflows_dataflows"=>"plugin_dataflows_sourceconnectors_id"],
					 "glpi_plugin_dataflows_triggertypes"=>["glpi_plugin_dataflows_dataflows"=>"plugin_dataflows_triggertypes_id"],
					 "glpi_plugin_dataflows_transferfreqs"=>["glpi_plugin_dataflows_dataflows"=>"plugin_dataflows_transferfreqs_id"],
					 "glpi_plugin_dataflows_transfertimetables"=>["glpi_plugin_dataflows_dataflows"=>"plugin_dataflows_transfertimetables_id"],
					 "glpi_plugin_dataflows_holidayactions"=>["glpi_plugin_dataflows_dataflows"=>"plugin_dataflows_holidayactions_id"],
					 "glpi_plugin_dataflows_srcuris"=>["glpi_plugin_dataflows_dataflows"=>"plugin_dataflows_srcuris_id"],
					 "glpi_plugin_dataflows_srcpreprocs"=>["glpi_plugin_dataflows_dataflows"=>"plugin_dataflows_srcpreprocs_id"],
					 "glpi_plugin_dataflows_desturis"=>["glpi_plugin_dataflows_dataflows"=>"plugin_dataflows_desturis_id"],
					 "glpi_plugin_dataflows_destpostprocs"=>["glpi_plugin_dataflows_dataflows"=>"plugin_dataflows_destpostprocs_id"],
					 "glpi_plugin_dataflows_errorhandlings"=>["glpi_plugin_dataflows_dataflows"=>"plugin_dataflows_errorhandlings_id"],
					 "glpi_entities"=>["glpi_plugin_dataflows_dataflows"=>"entities_id"],
					 "glpi_groups"=>["glpi_plugin_dataflows_dataflows"=>"dataowner"],
					 "glpi_users"=>["glpi_plugin_dataflows_dataflows"=>"technicalmaintainer"]
					 ];
   else
      return [];
}

// Define Dropdown tables to be manage in GLPI :
function plugin_dataflows_getDropdown() {

   $plugin = new Plugin();
   if ($plugin->isActivated("dataflows"))
		return ['PluginDataflowsFlowgroup'=>PluginDataflowsFlowgroup::getTypeName(2),
                'PluginDataflowsState'=>PluginDataflowsState::getTypeName(2),
                'PluginDataflowsType'=>PluginDataflowsType::getTypeName(2),
                'PluginDataflowsIndicator'=>PluginDataflowsIndicator::getTypeName(2),
                'PluginDataflowsServicelevel'=>PluginDataflowsServicelevel::getTypeName(2),
                'PluginDataflowsTransferprotocol'=>PluginDataflowsTransferprotocol::getTypeName(2),
                'PluginDataflowsSourceConnector'=>PluginDataflowsSourceConnector::getTypeName(2),
                'PluginDataflowsDestinationConnector'=>PluginDataflowsDestinationConnector::getTypeName(2),
                'PluginDataflowsTriggerType'=>PluginDataflowsTriggerType::getTypeName(2),
                'PluginDataflowsTransferFreq'=>PluginDataflowsTransferFreq::getTypeName(2),
                'PluginDataflowsTransferTimetable'=>PluginDataflowsTransferTimetable::getTypeName(2),
                'PluginDataflowsHolidayAction'=>PluginDataflowsHolidayAction::getTypeName(2),
                'PluginDataflowsSrcUri'=>PluginDataflowsSrcUri::getTypeName(2),
                'PluginDataflowsSrcPreproc'=>PluginDataflowsSrcPreproc::getTypeName(2),
                'PluginDataflowsDestUri'=>PluginDataflowsDestUri::getTypeName(2),
                'PluginDataflowsDestPostproc'=>PluginDataflowsDestPostproc::getTypeName(2),
                'PluginDataflowsErrorHandling'=>PluginDataflowsErrorHandling::getTypeName(2)
                ];
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

/*
function plugin_dataflows_MassiveActionsDisplay($options=[]) {

   $dataflow=new PluginDataflowsDataflow;

   if (in_array($options['itemtype'], PluginDataflowsDataflow::getTypes(true))) {

      $dataflow->dropdownDataflows("plugin_dataflows_dataflows_id");
      echo "<input type=\"submit\" name=\"massiveaction\" class=\"submit\" value=\""._sx('button', 'Post')."\" >";
   }
   return "";
}

function plugin_dataflows_MassiveActionsProcess($data) {

   $res = ['ok' => 0,
            'ko' => 0,
            'noright' => 0];

   $dataflow_item = new PluginDataflowsDataflow_Item();

   switch ($data['action']) {

      case "plugin_dataflows_add_item":
         foreach ($data["item"] as $key => $val) {
            if ($val == 1) {
               $input = ['plugin_dataflows_dataflows_id' => $data['plugin_dataflows_dataflows_id'],
                              'items_id'      => $key,
                              'itemtype'      => $data['itemtype']];
               if ($dataflow_item->can(-1,'w',$input)) {
                  if ($dataflow_item->can(-1,'w',$input)) {
                     $dataflow_item->add($input);
                     $res['ok']++;
                  } else {
                     $res['ko']++;
                  }
               } else {
                  $res['noright']++;
               }
            }
         }
         break;
   }
   return $res;
}
*/
function plugin_datainjection_populate_dataflows() {
   global $INJECTABLE_TYPES;
   $INJECTABLE_TYPES['PluginDataflowsDataflowInjection'] = 'datainjection';
}

/*
function plugin_dataflows_addSelect($type,$id,$num) {

   $searchopt = &Search::getOptions($type);
   $table = $searchopt[$id]["table"];
   $field = $searchopt[$id]["field"];
//echo "add select : ".$table.".".$field."<br/>";
   switch ($type) {

      case 'Ticket':

         if ($table.".".$field == "glpi_plugin_dataflows_dataflows.name") {
            return " GROUP_CONCAT(DISTINCT `glpi_plugin_dataflows_dataflows`.`id` SEPARATOR '$$$$') AS ITEM_$num, "
                    . " GROUP_CONCAT(DISTINCT `glpi_plugin_dataflows_dataflows_bis`.`id` SEPARATOR '$$$$') AS ITEM_".$num."_2,";
         }
         break;
   }
}



function plugin_dataflows_addLeftJoin($itemtype,$ref_table,$new_table,$linkfield,&$already_link_tables) {

   switch ($itemtype) {

      case 'Ticket':
         return " LEFT JOIN `glpi_plugin_dataflows_dataflows` AS glpi_plugin_dataflows_dataflows
            ON (`glpi_items_tickets`.`items_id` = `glpi_plugin_dataflows_dataflows`.`id`
                  AND `glpi_items_tickets`.`itemtype`='PluginDataflowsDataflow')

         LEFT JOIN `glpi_plugin_dataflows_dataflows_items`
            ON (`glpi_items_tickets`.`items_id` = `glpi_plugin_dataflows_dataflows_items`.`id`
                  AND `glpi_items_tickets`.`itemtype`='PluginDataflowsDataflow_Item')
         LEFT JOIN `glpi_plugin_dataflows_dataflows` AS glpi_plugin_dataflows_dataflows_bis
            ON (`glpi_plugin_dataflows_dataflows_items`.`plugin_dataflows_dataflows_id` = `glpi_plugin_dataflows_dataflows_bis`.`id`)";
         break;

   }
   return "";
}



function plugin_dataflows_addWhere($link,$nott,$type,$id,$val,$searchtype) {

   $searchopt = &Search::getOptions($type);
   $table = $searchopt[$id]["table"];
   $field = $searchopt[$id]["field"];

   switch ($type) {

      case 'Ticket':
         if ($table.".".$field == "glpi_plugin_dataflows_dataflows.name") {
            $out = '';
            switch ($searchtype) {
               case "contains" :
                  $SEARCH = Search::makeTextSearch($val, $nott);
                  break;

               case "equals" :
                  if ($nott) {
                     $SEARCH = " <> '$val'";
                  } else {
                     $SEARCH = " = '$val'";
                  }
                  break;

               case "notequals" :
                  if ($nott) {
                     $SEARCH = " = '$val'";
                  } else {
                     $SEARCH = " <> '$val'";
                  }
                  break;

            }
            if (in_array($searchtype, ['equals', 'notequals'])) {
               if ($table != getTableForItemType($type) || $type == 'States') {
                  $out = " $link (`glpi_plugin_dataflows_dataflows`.`id`".$SEARCH;
               } else {
                  $out = " $link (`glpi_plugin_dataflows_dataflows`.`$field`".$SEARCH;
               }
               if ($searchtype=='notequals') {
                  $nott = !$nott;
               }
               // Add NULL if $val = 0 and not negative search
               // Or negative search on real value
               if ((!$nott && $val==0) || ($nott && $val != 0)) {
                  $out .= " OR `glpi_plugin_dataflows_dataflows`.`id` IS NULL";
               }
//               $out .= ')';
               $out1 = $out;
               $out = str_replace(" ".$link." (", " ".$link." ", $out);
            } else {
               $out = Search::makeTextCriteria("`glpi_plugin_dataflows_dataflows`.".$field,$val,$nott,$link);
               $out1 = $out;
               $out = preg_replace("/^ $link/", $link.' (', $out);
            }
            $out2 = $out." OR ";
            $out2 .= str_replace("`glpi_plugin_dataflows_dataflows`",
                                 "`glpi_plugin_dataflows_dataflows_bis`", $out1)." ";
            $out2 = str_replace("OR   AND", "OR", $out2);
            $out2 = str_replace("OR   OR", "OR", $out2);
            $out2 = str_replace("AND   OR", "OR", $out2);
            $out2 = str_replace("OR  AND", "OR", $out2);
            $out2 = str_replace("OR  OR", "OR", $out2);
            $out2 = str_replace("AND  OR", "OR", $out2);
            return $out2.")";
         }
         break;
   }
}
*/
?>
