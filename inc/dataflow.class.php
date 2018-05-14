<?php
/*
 * @version $Id: HEADER 15930 2011-10-30 15:47:55Z tsmr $
 -------------------------------------------------------------------------
 dataflows plugin for GLPI
 Copyright (C) 2009-2016 by the dataflows Development Team.

 https://github.com/InfotelGLPI/dataflows
 -------------------------------------------------------------------------

 LICENSE
      
 This file is part of dataflows.

 dataflows is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 dataflows is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with dataflows. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 */

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access directly to this file");
}

class PluginDataflowsDataflow extends CommonDBTM {

   public $dohistory=true;
   static $rightname = "plugin_dataflows";
   protected $usenotepad         = true;
   
   static $types = array('Computer','Software', 'SoftwareLicense');

   static function getTypeName($nb=0) {

      return _n('Dataflow', 'Dataflows', $nb, 'dataflows');
   }

   public static function canCreate() {
      return Session::haveRight(static::$rightname, UPDATE);
   }

   public static function canView() {
      return Session::haveRight(static::$rightname, READ);
   }

   function getTabNameForItem(CommonGLPI $item, $withtemplate=0) {

      if ($item->getType()=='Supplier') {
         if ($_SESSION['glpishow_count_on_tabs']) {
            return self::createTabEntry(self::getTypeName(2), self::countForItem($item));
         }
         return self::getTypeName(2);
      }
      return '';
   }


   static function displayTabContentForItem(CommonGLPI $item, $tabnum=1, $withtemplate=0) {

      if ($item->getType()=='Supplier') {
         $self = new self();
         $self->showPluginFromSupplier($item->getField('id'));
      }
      return true;
   }

   static function countForItem(CommonDBTM $item) {

      return countElementsInTable('glpi_plugin_dataflows_dataflows',
                                  "`suppliers_id` = '".$item->getID()."'");
   }

   //clean if dataflows are deleted
   function cleanDBonPurge() {

//      $temp = new PluginDataflowsDataflow_Item();
//      $temp->deleteByCriteria(array('plugin_dataflows_dataflows_id' => $this->fields['id']));
   }

   function getSearchOptions() {

      $tab                       = array();

      $tab['common']             = self::getTypeName(2);

      $tab[1]['table']           = $this->getTable();
      $tab[1]['field']           = 'name';
      $tab[1]['name']            = __('Name');
      $tab[1]['datatype']        = 'itemlink';
      $tab[1]['itemlink_type']   = $this->getType();

      $tab[2]['table']			 = $this->getTable();
      $tab[2]['field']			 = 'shortdescription';
      $tab[2]['name']            = __('Description');
      $tab[2]['datatype']        = 'text';

      $tab[3]['table']           = 'glpi_plugin_dataflows_flowgroups';
      $tab[3]['field']           = 'name';
      $tab[3]['name']            = PluginDataflowsFlowgroup::getTypeName(1);
      $tab[3]['datatype']        = 'dropdown';

      $tab[5]['table']          = 'glpi_plugin_dataflows_transferprotocols';
      $tab[5]['field']          = 'name';
      $tab[5]['name']           = PluginDataflowsTransferProtocol::getTypeName(1);
      $tab[5]['datatype']       = 'dropdown';

      $tab[6]['table']          = 'glpi_plugin_dataflows_states';
      $tab[6]['field']          = 'name';
      $tab[6]['name']           = PluginDataflowsState::getTypeName(1);
      $tab[6]['datatype']       = 'dropdown';

      $tab[7]['table']          = 'glpi_plugin_dataflows_fromswcomponents';
      $tab[7]['field']          = 'name';
      $tab[7]['name']           = PluginDataflowsFromSwcomponent::getTypeName(1);
      $tab[7]['datatype']       = 'dropdown';

      $tab[8]['table']          = 'glpi_plugin_dataflows_toswcomponents';
      $tab[8]['field']          = 'name';
      $tab[8]['name']           = PluginDataflowsToSwcomponent::getTypeName(1);
      $tab[8]['datatype']       = 'dropdown';

      $tab[9]['table']          = 'glpi_plugin_dataflows_sourceconnectors';
      $tab[9]['field']          = 'name';
      $tab[9]['name']           = PluginDataflowsSourceConnector::getTypeName(1);
      $tab[9]['datatype']       = 'dropdown';

      $tab[10]['table']          = 'glpi_plugin_dataflows_destinationconnectors';
      $tab[10]['field']          = 'name';
      $tab[10]['name']           = PluginDataflowsDestinationConnector::getTypeName(1);
      $tab[10]['datatype']       = 'dropdown';

      $tab[11]['table']          = 'glpi_plugin_dataflows_types';
      $tab[11]['field']          = 'name';
      $tab[11]['name']           = PluginDataflowsType::getTypeName(1);
      $tab[11]['datatype']       = 'dropdown';

/*      $tab[12]['table']          = 'glpi_users';
      $tab[12]['field']          = 'name';
      $tab[12]['linkfield']      = 'users_id';
      $tab[12]['name']           = __('Dataflow Expert');
      $tab[12]['datatype']       = 'dropdown';
      $tab[12]['right']          = 'interface';

      $tab[13]['table']          = 'glpi_groups';
      $tab[13]['field']          = 'name';
      $tab[13]['linkfield']      = 'groups_id';
      $tab[13]['name']           = __('Dataflow Follow-up');
      $tab[13]['condition']      = '`is_assign`';
      $tab[13]['datatype']       = 'dropdown';

      $tab[4]['table']           = 'glpi_locations';
      $tab[4]['field']           = 'completename';
      $tab[4]['name']            = __('Location');
      $tab[4]['datatype']        = 'dropdown';
*/
      $tab[15]['table']           = 'glpi_suppliers';
      $tab[15]['field']           = 'name';
      $tab[15]['name']            = __('Supplier');
      $tab[15]['datatype']        = 'dropdown';

      $tab[16]['table']           = 'glpi_manufacturers';
      $tab[16]['field']           = 'name';
      $tab[16]['name']            = __('Editor', 'dataflows');
      $tab[16]['datatype']        = 'dropdown';

/*      $tab[7]['table']           = 'glpi_plugin_dataflows_dataflows_items';
      $tab[7]['field']           = 'items_id';
      $tab[7]['nosearch']        = true;
      $tab[7]['massiveaction']   = false;
      $tab[7]['name']            = _n('Associated item' , 'Associated items', 2);
      $tab[7]['forcegroupby']    = true;
      $tab[7]['joinparams']      = array('jointype' => 'child');

      $tab[18]['table']          = $this->getTable();
      $tab[18]['field']          = 'date_mod';
      $tab[18]['massiveaction']  = false;
      $tab[18]['name']           = __('Last update');
      $tab[18]['datatype']       = 'datetime';
*/
      $tab[30]['table']          = $this->getTable();
      $tab[30]['field']          = 'id';
      $tab[30]['name']           = __('ID');
      $tab[30]['datatype']       = 'number';

      $tab[80]['table']          = 'glpi_entities';
      $tab[80]['field']          = 'completename';
      $tab[80]['name']           = __('Entity');
      $tab[80]['datatype']       = 'dropdown';
      
      $tab[81]['table']       = 'glpi_entities';
      $tab[81]['field']       = 'entities_id';
      $tab[81]['name']        = __('Entity')."-".__('ID');
      
      return $tab;
   }

   //define header form
   function defineTabs($options=array()) {

      $ong = array();
      $this->addDefaultFormTab($ong);
      $this->addStandardTab('PluginDataflowsDataflow_Item', $ong, $options);
//      $this->addStandardTab('PluginDataflowsInstance', $ong, $options);
//      $this->addStandardTab('PluginDataflowsScript', $ong, $options);
//      $this->addStandardTab('Ticket', $ong, $options);
//      $this->addStandardTab('Item_Problem', $ong, $options);
//      $this->addStandardTab('Document_Item', $ong, $options);
      $this->addStandardTab('Notepad', $ong, $options);
      $this->addStandardTab('Log', $ong, $options);

      return $ong;
   }

   /*
    * Return the SQL command to retrieve linked object
    *
    * @return a SQL command which return a set of (itemtype, items_id)
    */
/*   function getSelectLinkedItem () {
      return "SELECT `itemtype`, `items_id`
              FROM `glpi_plugin_dataflows_dataflows_items`
              WHERE `plugin_dataflows_dataflows_id`='" . $this->fields['id']."'";
   }
*/
   function showForm ($ID, $options=array()) {

      $plugin = new Plugin();
	  if ($plugin->isActivated("statecheck")) {
			Session::addMessageAfterRedirect('<font color="red"><b>'.__('!! Highlighted fields are controlled !!').'</b></font>');
			Html::displayMessageAfterRedirect();
	  }
      $this->initForm($ID, $options);
      $this->showFormHeader($options);

      echo "<tr class='tab_bg_1'>";
      //name of dataflows
      echo "<td>".__('Name')."</td>";
      echo "<td>";
      Html::autocompletionTextField($this,"name");
      echo "</td>";
      //flowgroup of dataflows
      echo "<td>".PluginDataflowsFlowgroup::getTypeName(1)."</td>";
      echo "<td>";
      Dropdown::show('PluginDataflowsFlowgroup', array('name' => "plugin_dataflows_flowgroups_id", 'value' => $this->fields["plugin_dataflows_flowgroups_id"], 'entity' => $this->fields["entities_id"]));
      echo "</td>";
      echo "</tr>";

      echo "<tr class='tab_bg_1'>";
      //short description of dataflows
      echo "<td>".__('Short description')."</td>";
      echo "<td class='top center' colspan='4'>";
//      echo "<textarea cols='100' rows='1' name='shortdescription'>".$this->fields["shortdescription"]."</textarea>";
      Html::autocompletionTextField($this,"shortdescription",array('size' => 100));
      echo "</td>";
      echo "</tr>";

      echo "<tr class='tab_bg_1'>";
      //long description of dataflows
      echo "<td>".__('Long description')."</td>";
      echo "<td class='top center' colspan='4'>";
      echo "<textarea cols='100' rows='3' name='longdescription'>".$this->fields["longdescription"]."</textarea>";
      echo "</td>";
      echo "</tr>";

      echo "<tr class='tab_bg_1'>";
      //status of dataflows
      echo "<td>".__('Status')."</td>";
      echo "<td>";
      Dropdown::show('PluginDataflowsState', array('name' => "plugin_dataflows_states_id", 'value' => $this->fields["plugin_dataflows_states_id"], 'entity' => $this->fields["entities_id"]));
      echo "</td>";
      //status date of dataflows
      echo "<td>".__('Status StartDate')."</td>";
      echo "<td>";
      Html::showDateField("statedate", array('value' => $this->fields["statedate"]));
      echo "</td>";
      echo "</tr>";

      echo "<tr class='tab_bg_1'>";
      //transfer protocol
      echo "<td class='top center' colspan='4'>". __('Transfer Protocol').": ";
      Dropdown::show('PluginDataflowsTransferProtocol', array('name' => "plugin_dataflows_transferprotocols_id", 'value' => $this->fields["plugin_dataflows_transferprotocols_id"]));
      echo "</td>";
      echo "</tr>";

      echo "<tr class='tab_bg_1'>";
      //from application
      echo "<td>".__('From application').": </td><td>";
      Dropdown::show('PluginDataflowsFromSwcomponent', array('name' => "plugin_dataflows_fromswcomponents_id", 'value' => $this->fields["plugin_dataflows_fromswcomponents_id"],'entity' => $this->fields["entities_id"]));
      echo "</td>";
      //to application
      echo "<td>".__('To application').": </td>";
      echo "<td>";
      Dropdown::show('PluginDataflowsToSwcomponent', array('name' => "plugin_dataflows_toswcomponents_id", 'value' => $this->fields["plugin_dataflows_toswcomponents_id"],'entity' => $this->fields["entities_id"]));
      echo "</td>";
      echo "</tr>";

      echo "<tr class='tab_bg_1'>";
      //source connector
      echo "<td>".__('Source Connector').": </td>";
      echo "<td>";
      Dropdown::show('PluginDataflowsSourceConnector', array('name' => "plugin_dataflows_sourceconnectors_id", 'value' => $this->fields["plugin_dataflows_sourceconnectors_id"]));
      echo "</td>";
      //destination connector
      echo "<td>".__('Destination Connector').": </td>";
      echo "<td>";
      Dropdown::show('PluginDataflowsDestinationConnector', array('name' => "plugin_dataflows_destinationconnectors_id", 'value' => $this->fields["plugin_dataflows_destinationconnectors_id"]));
      echo "</td>";
	  echo "</tr>";
	  
	if (class_exists('PluginAccountsAccount')) {
      echo "<tr class='tab_bg_1'>";
      //from credential
      echo "<td>".__('Source User').": </td><td>";
      Dropdown::show('PluginDataflowsFromCredential', array('name' => "plugin_dataflows_fromcredentials_id", 'value' => $this->fields["plugin_dataflows_fromcredentials_id"],'entity' => $this->fields["entities_id"]));
      echo "</td>";
      //to credential
      echo "<td>".__('Destination User').": </td><td>";
      Dropdown::show('PluginDataflowsToCredential', array('name' => "plugin_dataflows_tocredentials_id", 'value' => $this->fields["plugin_dataflows_tocredentials_id"],'entity' => $this->fields["entities_id"]));
//      Dropdown::show('PluginAccountsAccount', array('value' => $this->fields["plugin_dataflows_tocredentials_id"],'entity' => $this->fields["entities_id"]));
      echo "</td>";
	  echo "</tr>";
	}

      echo "<tr class='tab_bg_1'>";
      //source path
      echo "<td>".__('From external server').": </td>";
      echo "<td>";
      Html::autocompletionTextField($this,"plugin_dataflows_fromexternal",array('size' => 65));
      echo "</td>";
      //destination path
      echo "<td>".__('To external server').": </td>";
      echo "<td>";
      Html::autocompletionTextField($this,"plugin_dataflows_toexternal",array('size' => 65));
      echo "</td>";
	  echo "</tr>";

      echo "<tr class='tab_bg_1'>";
      //source path
      echo "<td>".__('Source directory/ ProgramId/ port').": </td>";
      echo "<td>";
      Html::autocompletionTextField($this,"plugin_dataflows_srcuri",array('size' => 65));
      echo "</td>";
      //destination path
      echo "<td>".__('Destination directory/ ProgramId/ port').": </td>";
      echo "<td>";
      Html::autocompletionTextField($this,"plugin_dataflows_desturi",array('size' => 65));
      echo "</td>";
	  echo "</tr>";

      echo "<tr class='tab_bg_1'>";
      //source format
      echo "<td>".__('Source format (Idoc, table, file pattern, ...)').": </td>";
      echo "<td>";
      Html::autocompletionTextField($this,"srcformat",array('size' => 45));
      echo "</td>";
      //destination format
      echo "<td>".__('Destination format (Idoc, table, file pattern, ...)').": </td>";
      echo "<td>";
      Html::autocompletionTextField($this,"destformat",array('size' => 45));
      echo "</td>";
	  echo "</tr>";
	  
      echo "<tr class='tab_bg_1'>";
      //extract method
      echo "<td>".__('Extract Method (Bapi, Stored Proc, ...)').": </td>";
      echo "<td>";
      Html::autocompletionTextField($this,"extractmethod",array('size' => 45));
      echo "</td>";
      //load method
      echo "<td>".__('Load Method (Bapi, Stored Proc, ...)').": </td>";
      echo "<td>";
      Html::autocompletionTextField($this,"loadmethod",array('size' => 45));
      echo "</td>";
      
      echo "<tr class='tab_bg_1'>";
      //source preprocessing
      echo "<td>".__('Transfer Preprocessing').": </td>";
      echo "<td>";
      Dropdown::show('PluginDataflowsSrcPreproc', array('name' => "plugin_dataflows_srcpreprocs_id", 'value' => $this->fields["plugin_dataflows_srcpreprocs_id"]));
      echo "</td>";
      //destination postprocessing
      echo "<td>".__('Transfer Postprocessing').": </td>";
      echo "<td>";
      Dropdown::show('PluginDataflowsDestPostproc', array('name' => "plugin_dataflows_destpostprocs_id", 'value' => $this->fields["plugin_dataflows_destpostprocs_id"]));
      echo "</td>";
	  echo "</tr>";
	  
      echo "<tr class='tab_bg_1'>";
      //transfer trigger
      echo "<td class='top center' colspan='4'>".__('Transfer trigger').": ";
//      echo "<td>".$LANG['plugin_dataflows'][32].": </td>";
//      echo "<td>";
      Dropdown::show('PluginDataflowsTriggerType', array('name' => "plugin_dataflows_triggertypes_id", 'value' => $this->fields["plugin_dataflows_triggertypes_id"]));
//      echo "</td>";
      //trigger format
//      echo "<td>"
	  echo " (".__('Trigger name').": ";
//      echo "</td><td>";
      Html::autocompletionTextField($this,"triggerformat",array('size' => 45));
      echo ")</td>";
      echo "</tr>";
      
      echo "<tr class='tab_bg_1'>";
      //transfer frequency
      echo "<td>".__('Transfer frequency (def : per day)').": </td><td>";
      Dropdown::show('PluginDataflowsTransferFreq', array('name' => "plugin_dataflows_transferfreqs_id", 'value' => $this->fields["plugin_dataflows_transferfreqs_id"]));
      echo "</td>";
      
      //transfer timetable
      echo "<td>".__('Transfer Timetable').": </td>";
      echo "<td>";
      Dropdown::show('PluginDataflowsTransferTimetable', array('name' => "plugin_dataflows_transfertimetables_id", 'value' => $this->fields["plugin_dataflows_transfertimetables_id"]));
      echo "</td>";
      echo "</tr>";

      echo "<tr class='tab_bg_1'>";
      //error handling
      echo "<td>".__('Transfer Error handling').": </td>";
      echo "<td>";
      Dropdown::show('PluginDataflowsErrorHandling', array('name' => "plugin_dataflows_errorhandlings_id", 'value' => $this->fields["plugin_dataflows_errorhandlings_id"]));
      echo "</td>";
      
      //transfer on holiday
      echo "<td>".__('Transfer On holiday').": </td>";
      echo "<td>";
      Dropdown::show('PluginDataflowsHolidayAction', array('name' => "plugin_dataflows_holidayactions_id", 'value' => $this->fields["plugin_dataflows_holidayactions_id"]));
      echo "</td>";
      echo "</tr>";

      echo "<tr class='tab_bg_1'>";
      //url of functional documentation
      echo "<td>".__('URL to functional doc (mapping, ...)').": </td>";
      echo "<td>";
      Html::autocompletionTextField($this,"mappingdocurl",array('size' => 65));
      echo "</td>";
      //url of technical documentation
      echo "<td>".__('URL to technical doc (design, ...)').": </td>";
      echo "<td>";
      Html::autocompletionTextField($this,"technicaldocurl",array('size' => 65));
      echo "</td>";
	  echo "</tr>";

      echo "<tr class='tab_bg_1'>";
      //transfer volume
      echo "<td>".__('Transfer Volume (MB)').": </td>";
      echo "<td>";
      Html::autocompletionTextField($this,"transfervolume",array('size' => 45));
      echo "</td>";
      //transfer priority
      echo "<td>".__('Priority').": </td>";
      echo "<td>";
      Html::autocompletionTextField($this,"transferpriority",array('size' => 45));
      echo "</td>";
      echo "</tr>";
	  
      echo "<tr class='tab_bg_1'>";
      //type
      echo "<td>".__('Type').": </td>";
      echo "<td>";
      Dropdown::show('PluginDataflowsType', array('name' => "plugin_dataflows_types_id", 'value' => $this->fields["plugin_dataflows_types_id"]));
      echo "</td>";
      //indicator
      echo "<td>".__('Indicator').": </td>";
      echo "<td>";
      Dropdown::show('PluginDataflowsIndicator', array('name' => "plugin_dataflows_indicators_id", 'value' => $this->fields["plugin_dataflows_indicators_id"]));
      echo "</td>";
      echo "</tr>";
	  
      echo "<tr class='tab_bg_1'>";
      //service level of dataflows
      echo "<td>".__('Service Level').": </td>";
      echo "<td>";
      Dropdown::show('PluginDataflowsServicelevel', array('name' => "plugin_dataflows_servicelevels_id", 'value' => $this->fields["plugin_dataflows_servicelevels_id"]));
      echo "</td>";
      //is_helpdesk_visible
      echo "<td>" . __('Associable to a ticket') . "</td><td>";
      Dropdown::showYesNo('is_helpdesk_visible',$this->fields['is_helpdesk_visible']);
      echo "</td>";

      echo "</tr>";

      echo "<tr class='tab_bg_1'>";
      //data owner
      echo "<td>".__('Dataflow Follow-up')."</td><td>";
      Group::dropdown(array('name'      => 'groups_id', 'value'     => $this->fields['groups_id'], 'entity'    => $this->fields['entities_id'], 'condition' => '`is_assign`'));
      echo "</td>";
      //technical maintainer
      echo "<td>".__('Dataflow Expert')."</td><td>";
      User::dropdown(array('name' => "users_id", 'value' => $this->fields["users_id"], 'entity' => $this->fields["entities_id"], 'right' => 'interface'));
      echo "</td>";
      echo "</tr>";


      echo "<tr class='tab_bg_1'>";
      //other group
      echo "<td>".__('Other group')."</td>";
      echo "<td>";
      Dropdown::show('PluginDataflowsOtherGroup', array('name' => "plugin_dataflows_othergroups_id", 'value' => $this->fields["plugin_dataflows_othergroups_id"], 'entity' => $this->fields["entities_id"]));
      echo "</td>";
      //other expert
      echo "<td>".__('Other expert').": </td>";
      echo "<td>";
      Dropdown::show('PluginDataflowsOtherUser', array('value' => $this->fields["plugin_dataflows_otherusers_id"],'entity' => $this->fields["entities_id"]));
      echo "</td>";
      echo "</tr>";

      echo "<tr class='tab_bg_1'>";
      //support group
      echo "<td>".__('Dataflow Support').": </td><td>";
      Dropdown::show('PluginDataflowsSupportGroup', array('value' => $this->fields["plugin_dataflows_supportgroups_id"],'entity' => $this->fields["entities_id"]));
      echo "</td>";
      //modification date
/*      echo "<td class='center' colspan = '4'>";
      printf(__('Last update on %s'), Html::convDateTime($this->fields["date_mod"]));
      echo "</td>";
*/
      echo "</tr>";

	  if ($this->canCreate() && $plugin->isActivated("statecheck")) {
			$classname = get_class($this);
			PluginStatecheckRule::plugin_statecheck_renderfields($classname);
	  }

      $this->showFormButtons($options);

      return true;
   }
   
   /**
    * Make a select box for link dataflow
    *
    * Parameters which could be used in options array :
    *    - name : string / name of the select (default is plugin_dataflows_dataflowtypes_id)
    *    - entity : integer or array / restrict to a defined entity or array of entities
    *                   (default -1 : no restriction)
    *    - used : array / Already used items ID: not to display in dropdown (default empty)
    *
    * @param $options array of possible options
    *
    * @return nothing (print out an HTML select box)
   **/
   static function dropdownDataflow($options=array()) {
      global $DB, $CFG_GLPI;


      $p['name']    = 'plugin_dataflows_dataflows_id';
      $p['entity']  = '';
      $p['used']    = array();
      $p['display'] = true;

      if (is_array($options) && count($options)) {
         foreach ($options as $key => $val) {
            $p[$key] = $val;
         }
      }

      $where = " WHERE `glpi_plugin_dataflows_dataflows`.`is_deleted` = '0' ".
                       getEntitiesRestrictRequest("AND", "glpi_plugin_dataflows_dataflows", '', $p['entity'], true);

      $p['used'] = array_filter($p['used']);
      if (count($p['used'])) {
         $where .= " AND `id` NOT IN (0, ".implode(",",$p['used']).")";
      }

      $query = "SELECT *
                FROM `glpi_plugin_dataflows_dataflowtypes`
                WHERE `id` IN (SELECT DISTINCT `plugin_dataflows_dataflowtypes_id`
                               FROM `glpi_plugin_dataflows_dataflows`
                             $where)
                ORDER BY `name`";
      $result = $DB->query($query);

      $values = array(0 => Dropdown::EMPTY_VALUE);

      while ($data = $DB->fetch_assoc($result)) {
         $values[$data['id']] = $data['name'];
      }
      $rand = mt_rand();
      $out  = Dropdown::showFromArray('_dataflowtype', $values, array('width'   => '30%',
                                                                     'rand'    => $rand,
                                                                     'display' => false));
      $field_id = Html::cleanId("dropdown__dataflowtype$rand");

      $params   = array('dataflowtype' => '__VALUE__',
                        'entity' => $p['entity'],
                        'rand'   => $rand,
                        'myname' => $p['name'],
                        'used'   => $p['used']);

      $out .= Ajax::updateItemOnSelectEvent($field_id,"show_".$p['name'].$rand,
                                            $CFG_GLPI["root_doc"]."/plugins/dataflows/ajax/dropdownTypeDataflows.php",
                                            $params, false);
      $out .= "<span id='show_".$p['name']."$rand'>";
      $out .= "</span>\n";

      $params['dataflowtype'] = 0;
      $out .= Ajax::updateItem("show_".$p['name'].$rand,
                               $CFG_GLPI["root_doc"]. "/plugins/dataflows/ajax/dropdownTypeDataflows.php",
                               $params, false);
      if ($p['display']) {
         echo $out;
         return $rand;
      }
      return $out;
   }

   /**
    * For other plugins, add a type to the linkable types
    *
    * @since version 1.3.0
    *
    * @param $type string class name
   **/
   static function registerType($type) {
      if (!in_array($type, self::$types)) {
         self::$types[] = $type;
      }
   }


   /**
    * Type than could be linked to a Rack
    *
    * @param $all boolean, all type, or only allowed ones
    *
    * @return array of types
   **/
   static function getTypes($all=false) {

      if ($all) {
         return self::$types;
      }

      // Only allowed types
      $types = self::$types;

      foreach ($types as $key => $type) {
         if (!class_exists($type)) {
            continue;
         }

         $item = new $type();
         if (!$item->canView()) {
            unset($types[$key]);
         }
      }
      return $types;
   }

   function showPluginFromSupplier($ID,$withtemplate='') {
      global $DB,$CFG_GLPI;

      $item = new Supplier();
      $canread = $item->can($ID,READ);
      $canedit = $item->can($ID,UPDATE);

      $query = "SELECT `glpi_plugin_dataflows_dataflows`.* "
        ."FROM `glpi_plugin_dataflows_dataflows` "
        ." LEFT JOIN `glpi_entities` ON (`glpi_entities`.`id` = `glpi_plugin_dataflows_dataflows`.`entities_id`) "
        ." WHERE `suppliers_id` = '$ID' "
        . getEntitiesRestrictRequest(" AND ","glpi_plugin_dataflows_dataflows",'','',$this->maybeRecursive());
      $query.= " ORDER BY `glpi_plugin_dataflows_dataflows`.`name` ";

      $result = $DB->query($query);
      $number = $DB->numrows($result);

      if (Session::isMultiEntitiesMode()) {
         $colsup=1;
      } else {
         $colsup=0;
      }

      if ($withtemplate!=2) echo "<form method='post' action=\"".$CFG_GLPI["root_doc"]."/plugins/dataflows/front/dataflow.form.php\">";

      echo "<div align='center'><table class='tab_cadre_fixe'>";
      echo "<tr><th colspan='".(4+$colsup)."'>"._n('Dataflow associated', 'Dataflows associated', 2, 'dataflows')."</th></tr>";
      echo "<tr><th>".__('Name')."</th>";
      if (Session::isMultiEntitiesMode())
         echo "<th>".__('Entity')."</th>";
      echo "<th>".PluginDataflowsDataflowCategory::getTypeName(1)."</th>";
      echo "<th>".__('Type')."</th>";
      echo "<th>".__('Comments')."</th>";

      echo "</tr>";

      while ($data=$DB->fetch_array($result)) {

         echo "<tr class='tab_bg_1".($data["is_deleted"]=='1'?"_2":"")."'>";
         if ($withtemplate!=3 && $canread && (in_array($data['entities_id'],$_SESSION['glpiactiveentities']) || $data["is_recursive"])) {
            echo "<td class='center'><a href='".$CFG_GLPI["root_doc"]."/plugins/dataflows/front/dataflow.form.php?id=".$data["id"]."'>".$data["name"];
         if ($_SESSION["glpiis_ids_visible"]) echo " (".$data["id"].")";
            echo "</a></td>";
         } else {
            echo "<td class='center'>".$data["name"];
            if ($_SESSION["glpiis_ids_visible"]) echo " (".$data["id"].")";
            echo "</td>";
         }
         echo "</a></td>";
         if (Session::isMultiEntitiesMode())
            echo "<td class='center'>".Dropdown::getDropdownName("glpi_entities",$data['entities_id'])."</td>";
         echo "<td>".Dropdown::getDropdownName("glpi_plugin_dataflows_dataflowtypes",$data["plugin_dataflows_dataflowtypes_id"])."</td>";
         echo "<td>".Dropdown::getDropdownName("glpi_plugin_dataflows_servertypes",$data["plugin_dataflows_servertypes_id"])."</td>";
         echo "<td>".$data["comment"]."</td></tr>";
      }
      echo "</table></div>";
      Html::closeForm();
   }
   
   /**
    * @since version 0.85
    *
    * @see CommonDBTM::getSpecificMassiveActions()
   **/
   function getSpecificMassiveActions($checkitem=NULL) {
      $isadmin = static::canUpdate();
      $actions = parent::getSpecificMassiveActions($checkitem);

      if ($_SESSION['glpiactiveprofile']['interface'] == 'central') {
         if ($isadmin) {
            $actions['PluginDataflowsDataflow'.MassiveAction::CLASS_ACTION_SEPARATOR.'install']    = _x('button', 'Associate');
            $actions['PluginDataflowsDataflow'.MassiveAction::CLASS_ACTION_SEPARATOR.'uninstall'] = _x('button', 'Dissociate');
            $actions['PluginDataflowsDataflow'.MassiveAction::CLASS_ACTION_SEPARATOR.'duplicate'] = _x('button', 'Duplicate');

            if (Session::haveRight('transfer', READ)
                     && Session::isMultiEntitiesMode()
            ) {
               $actions['PluginDataflowsDataflow'.MassiveAction::CLASS_ACTION_SEPARATOR.'transfer'] = __('Transfer');
            }
         }
      }
      return $actions;
   }
   
   /**
    * @since version 0.85
    *
    * @see CommonDBTM::showMassiveActionsSubForm()
   **/
   static function showMassiveActionsSubForm(MassiveAction $ma) {

      switch ($ma->getAction()) {
         case 'plugin_dataflows_add_item':
            self::dropdownDataflow(array());
            echo "&nbsp;".
                 Html::submit(_x('button','Post'), array('name' => 'massiveaction'));
            return true;
            break;
         case "install" :
            Dropdown::showSelectItemFromItemtypes(array('items_id_name' => 'item_item',
                                                        'itemtype_name' => 'typeitem',
                                                        'itemtypes'     => self::getTypes(true),
                                                        'checkright'
                                                                        => true,
                                                  ));
            echo Html::submit(_x('button', 'Post'), array('name' => 'massiveaction'));
            return true;
            break;
         case "uninstall" :
            Dropdown::showSelectItemFromItemtypes(array('items_id_name' => 'item_item',
                                                        'itemtype_name' => 'typeitem',
                                                        'itemtypes'     => self::getTypes(true),
                                                        'checkright'
                                                                        => true,
                                                  ));
            echo Html::submit(_x('button', 'Post'), array('name' => 'massiveaction'));
            return true;
            break;
         case "duplicate" :
		    $options = array();
			$options['value'] = 1;
			$options['min'] = 1;
			$options['max'] = 20;
			$options['unit'] = "times";
            Dropdown::showNumber('repeat', $options);
            echo Html::submit(_x('button','Post'), array('name' => 'massiveaction'));
            return true;
            break;
         case "transfer" :
            Dropdown::show('Entity');
            echo Html::submit(_x('button','Post'), array('name' => 'massiveaction'));
            return true;
            break;
    }
      return parent::showMassiveActionsSubForm($ma);
   }
   
   
   /**
    * @since version 0.85
    *
    * @see CommonDBTM::processMassiveActionsForOneItemtype()
   **/
   static function processMassiveActionsForOneItemtype(MassiveAction $ma, CommonDBTM $item,
                                                       array $ids) {
      global $DB;
      
      $dataflow_item = new PluginDataflowsDataflow_Item();
      
      switch ($ma->getAction()) {
         case "plugin_dataflows_add_item":
            $input = $ma->getInput();
            foreach ($ids as $id) {
               $input = array('plugin_dataflows_dataflowtypes_id' => $input['plugin_dataflows_dataflowtypes_id'],
                                 'items_id'      => $id,
                                 'itemtype'      => $item->getType());
               if ($dataflow_item->can(-1,UPDATE,$input)) {
                  if ($dataflow_item->add($input)) {
                     $ma->itemDone($item->getType(), $id, MassiveAction::ACTION_OK);
                  } else {
                     $ma->itemDone($item->getType(), $ids, MassiveAction::ACTION_KO);
                  }
               } else {
                  $ma->itemDone($item->getType(), $ids, MassiveAction::ACTION_KO);
               }
            }

            return;
         case "transfer" :
            $input = $ma->getInput();
            if ($item->getType() == 'PluginDataflowsDataflow') {
            foreach ($ids as $key) {
                  $item->getFromDB($key);
                  $type = PluginDataflowsDataflowType::transfer($item->fields["plugin_dataflows_dataflowtypes_id"], $input['entities_id']);
                  if ($type > 0) {
                     $values["id"] = $key;
                     $values["plugin_dataflows_dataflowtypes_id"] = $type;
                     $item->update($values);
                  }

                  unset($values);
                  $values["id"] = $key;
                  $values["entities_id"] = $input['entities_id'];

                  if ($item->update($values)) {
                     $ma->itemDone($item->getType(), $key, MassiveAction::ACTION_OK);
                  } else {
                     $ma->itemDone($item->getType(), $key, MassiveAction::ACTION_KO);
                  }
               }
            }
            return;

         case 'install' :
            $input = $ma->getInput();
            foreach ($ids as $key) {
               if ($item->can($key, UPDATE)) {
                  $values = array('plugin_dataflows_dataflows_id' => $key,
                                 'items_id'      => $input["item_item"],
                                 'itemtype'      => $input['typeitem']);
                  if ($dataflow_item->add($values)) {
                     $ma->itemDone($item->getType(), $key, MassiveAction::ACTION_OK);
                  } else {
                     $ma->itemDone($item->getType(), $key, MassiveAction::ACTION_KO);
                  }
               } else {
                  $ma->itemDone($item->getType(), $key, MassiveAction::ACTION_NORIGHT);
                  $ma->addMessage($item->getErrorMessage(ERROR_RIGHT));
               }
            }
            return;
            
         case 'uninstall':
            $input = $ma->getInput();
            foreach ($ids as $key) {
               if ($val == 1) {
                  if ($dataflow_item->deleteItemByDataflowsAndItem($key,$input['item_item'],$input['typeitem'])) {
                     $ma->itemDone($item->getType(), $key, MassiveAction::ACTION_OK);
                  } else {
                     $ma->itemDone($item->getType(), $key, MassiveAction::ACTION_KO);
                  }
               }
            }
            return;

         case "duplicate" :
            $input = $ma->getInput();
            if ($item->getType() == 'PluginDataflowsDataflow') {
            foreach ($ids as $key) {
				  $success = array();
				  $failure = array();
                  $item->getFromDB($key);
				  $values = $item->fields;
				  $name = $values["name"];

                  unset($values["id"]);
				  for ($i = 1 ; $i <= $input['repeat'] ; $i++) {
					$values["name"] = $name . " (Copy $i)";

					if ($item->add($values)) {
						$success[] = $key;
					} else {
						$failure[] = $key;
					}
				  }
				  if ($success) {
				    $ma->itemDone('PluginDataflowsDataflow', $key, MassiveAction::ACTION_OK);
				  }
				  if ($failure) {
					$ma->itemDone('PluginDataflowsDataflow', $key, MassiveAction::ACTION_KO);
				  }
               }
            }
            return;

      }
      parent::processMassiveActionsForOneItemtype($ma, $item, $ids);
   }
   
}

?>