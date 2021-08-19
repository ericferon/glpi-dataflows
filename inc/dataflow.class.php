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

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access directly to this file");
}

class PluginDataflowsDataflow extends CommonDBTM {

   public $dohistory=true;
   static $rightname = "plugin_dataflows";
   protected $usenotepad         = true;
   
   static $types = ['Computer','Software', 'SoftwareLicense', 'Contract', 'Project'];

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

      $dbu = new DbUtils();
      return $dbu->countElementsInTable('glpi_plugin_dataflows_dataflows',
                                  "`suppliers_id` = '".$item->getID()."'");
   }

   //clean if dataflows are deleted
   function cleanDBonPurge() {

//      $temp = new PluginDataflowsDataflow_Item();
//      $temp->deleteByCriteria(['plugin_dataflows_dataflows_id' => $this->fields['id']]);
   }

   function getSearchOptions() {

      $tab                       = [];
      if (version_compare(GLPI_VERSION,'9.3','ge')) return $tab;

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

      $tab[12]['table']          = 'glpi_users';
      $tab[12]['field']          = 'name';
      $tab[12]['linkfield']      = 'users_id';
      $tab[12]['name']           = __('Dataflow Expert', 'dataflows');
      $tab[12]['datatype']       = 'dropdown';
      $tab[12]['right']          = 'interface';

      $tab[13]['table']          = 'glpi_groups';
      $tab[13]['field']          = 'name';
      $tab[13]['linkfield']      = 'groups_id';
      $tab[13]['name']           = __('Dataflow Follow-up', 'dataflows');
      $tab[13]['condition']      = '`is_assign`';
      $tab[13]['datatype']       = 'dropdown';

      $tab[15]['table']			 = $this->getTable();
      $tab[15]['field']			 = 'extractmethod';
      $tab[15]['name']			 = __('Extract Method (Bapi, Stored Proc, ...)', 'dataflows');
      $tab[15]['datatype']		 = 'text';

      $tab[16]['table']			 = $this->getTable();
      $tab[16]['field']			 = 'loadmethod';
      $tab[16]['name']			 = __('Load Method (Bapi, Stored Proc, ...)', 'dataflows');
      $tab[16]['datatype']		 = 'text';

      $tab[17]['table']			 = 'glpi_plugin_dataflows_indicators';
      $tab[17]['field']			 = 'name';
      $tab[17]['name']			 = __('Indicator', 'dataflows');
      $tab[17]['datatype']		 = 'dropdown';
      
      $tab[18]['table']			 = $this->getTable();
      $tab[18]['field']			 = 'date_mod';
      $tab[18]['massiveaction']  = false;
      $tab[18]['name']			 = __('Last update');
      $tab[18]['datatype']		 = 'datetime';
            
      $tab[19]['table']          = $this->getTable();
      $tab[19]['field']          = 'statedate';
      $tab[19]['massiveaction']  = false;
      $tab[19]['name']           = __('Status StartDate', 'dataflows');
      $tab[19]['datatype']       = 'datetime';

      $tab[20]['table']			 = 'glpi_plugin_dataflows_transferfreqs';
      $tab[20]['field']			 = 'name';
      $tab[20]['name']			 = __('Transfer frequency (def : per day)', 'dataflows');
      $tab[20]['datatype']		 = 'dropdown';
           
      $tab[21]['table']			 = 'glpi_plugin_dataflows_transfertimetables';
      $tab[21]['field']			 = 'name';
      $tab[21]['name']			 = __('Transfer Timetable', 'dataflows');
      $tab[21]['datatype']		 = 'dropdown';
           
      $tab[22]['table']			 = 'glpi_plugin_dataflows_srcpreprocs';
      $tab[22]['field']			 = 'name';
      $tab[22]['name']			 = __('Transfer Preprocessing', 'dataflows');
      $tab[22]['datatype']		 = 'dropdown';
           
      $tab[23]['table']			 = 'glpi_plugin_dataflows_destpostprocs';
      $tab[23]['field']			 = 'name';
      $tab[23]['name']			 = __('Transfer Postprocessing', 'dataflows');
      $tab[23]['datatype']		 = 'dropdown';
            
      $tab[24]['table']			 = $this->getTable();
      $tab[24]['field']			 = 'transferpriority';
      $tab[24]['name']			 = __('Priority', 'dataflows');
      $tab[24]['datatype']		 = 'text';
           
      $tab[26]['table']			 = $this->getTable();
      $tab[26]['field']			 = 'srcformat';
      $tab[26]['name']			 = __('Source format (Idoc, table, file pattern, ...)', 'dataflows');
      $tab[26]['datatype']		 = 'text';
      
      $tab[27]['table']			 = $this->getTable();
      $tab[27]['field']			 = 'destformat';
      $tab[27]['name']			 = __('Destination format (Idoc, table, file pattern, ...)', 'dataflows');
      $tab[27]['datatype']		 = 'text';
      
      $tab[28]['table']			 = 'glpi_plugin_dataflows_servicelevels';
      $tab[28]['field']			 = 'name';
      $tab[28]['name']			 = __('Service Level', 'dataflows');
      $tab[28]['datatype']		 = 'dropdown';

      $tab[29]['table']			 = 'glpi_plugin_dataflows_otherusers';
      $tab[29]['field']			 = 'name';
      $tab[29]['name']			 = __('Other expert', 'dataflows');
      $tab[29]['datatype']		 = 'user';
      
      $tab[30]['table']			 = 'glpi_plugin_dataflows_othergroups';
      $tab[30]['field']			 = 'name';
      $tab[30]['name']			 = __('Other group', 'dataflows');
      $tab[30]['datatype']		 = 'dropdown';

      $tab[31]['table']			 = 'glpi_plugin_dataflows_supportgroups';
      $tab[31]['field']			 = 'name';
      $tab[31]['name']			 = __('Dataflow Support', 'dataflows');
      $tab[31]['datatype']		 = 'dropdown';

      $tab[60]['table']          = $this->getTable();
      $tab[60]['field']          = 'id';
      $tab[60]['name']           = __('ID');
      $tab[60]['datatype']       = 'number';

      $tab[61]['table']			 = $this->getTable();
      $tab[61]['field']			 = 'is_helpdesk_visible';
      $tab[61]['name']			 = __('Associable to a ticket');
      $tab[61]['datatype']		 = 'bool';

      $tab[62]['table']			 = $this->getTable();
      $tab[62]['field']			 = 'is_recursive';
      $tab[62]['name']			 = __('Child entities');
      $tab[62]['datatype']		 = 'bool';

      $tab[70]['table']           = 'glpi_plugin_dataflows_dataflows_items';
      $tab[70]['field']           = 'items_id';
      $tab[70]['nosearch']        = true;
      $tab[70]['massiveaction']   = false;
      $tab[70]['name']            = _n('Associated item' , 'Associated items', 2);
      $tab[70]['forcegroupby']    = true;
      $tab[70]['joinparams']      = ['jointype' => 'child'];

      $tab[80]['table']          = 'glpi_entities';
      $tab[80]['field']          = 'completename';
      $tab[80]['name']           = __('Entity');
      $tab[80]['datatype']       = 'dropdown';
      
      $tab[81]['table']       = 'glpi_entities';
      $tab[81]['field']       = 'entities_id';
      $tab[81]['name']        = __('Entity')."-".__('ID');
      
      return $tab;
   }

   // search fields from GLPI 9.3 on
   function rawSearchOptions() {

      $tab = [];
      if (version_compare(GLPI_VERSION,'9.2','le')) return $tab;

      $tab[] = [
         'id'   => 'common',
         'name' => self::getTypeName(2)
      ];

      $tab[] = [
         'id'            => '1',
         'table'         => $this->getTable(),
         'field'         => 'name',
         'name'          => __('Name'),
         'datatype'      => 'itemlink',
         'itemlink_type' => $this->getType()
      ];

      $tab[] = [
         'id'       => '2',
         'table'    => 'glpi_plugin_dataflows_flowgroups',
         'field'    => 'name',
         'name'     => PluginDataflowsFlowgroup::getTypeName(1),
         'datatype' => 'dropdown'
      ];

      $tab[] = [
         'id'       => '3',
         'table'    => 'glpi_plugin_dataflows_transferprotocols',
         'field'    => 'name',
         'name'     => PluginDataflowsTransferProtocol::getTypeName(1),
         'datatype' => 'dropdown'
      ];

      $tab[] = [
         'id'       => '4',
         'table'    => 'glpi_plugin_dataflows_states',
         'field'    => 'name',
         'name'     => PluginDataflowsState::getTypeName(1),
         'datatype' => 'dropdown'
      ];

      $tab[] = [
         'id'       => '5',
         'table'    => 'glpi_plugin_dataflows_fromswcomponents',
         'field'    => 'name',
         'name'     => PluginDataflowsFromSwcomponent::getTypeName(1),
         'datatype' => 'dropdown'
      ];

      $tab[] = [
         'id'       => '6',
         'table'    => 'glpi_plugin_dataflows_toswcomponents',
         'field'    => 'name',
         'name'     => PluginDataflowsToSwcomponent::getTypeName(1),
         'datatype' => 'dropdown'
      ];

      $tab[] = [
         'id'       => '7',
         'table'    => 'glpi_plugin_dataflows_sourceconnectors',
         'field'    => 'name',
         'name'     => PluginDataflowsSourceConnector::getTypeName(1),
         'datatype' => 'dropdown'
      ];

      $tab[] = [
         'id'       => '8',
         'table'    => 'glpi_plugin_dataflows_destinationconnectors',
         'field'    => 'name',
         'name'     => PluginDataflowsDestinationConnector::getTypeName(1),
         'datatype' => 'dropdown'
      ];

      $tab[] = [
         'id'       => '9',
         'table'    => 'glpi_plugin_dataflows_types',
         'field'    => 'name',
         'name'     => PluginDataflowsType::getTypeName(1),
         'datatype' => 'dropdown'
      ];

      $tab[] = [
         'id'        => '11',
         'table'     => 'glpi_users',
         'field'     => 'name',
         'linkfield' => 'users_id',
         'name'      => __('Dataflow Expert', 'dataflows'),
         'datatype'  => 'dropdown',
         'right'     => 'interface'
      ];

      $tab[] = [
         'id'        => '13',
         'table'     => 'glpi_groups',
         'field'     => 'name',
         'linkfield' => 'groups_id',
         'name'      => __('Dataflow Follow-up', 'dataflows'),
         'condition' => '`is_assign`',
         'datatype'  => 'dropdown'
      ];

      $tab[] = [
         'id'        => '15',
         'table'     => $this->getTable(),
         'field'     => 'extractmethod',
         'name'      => __('Extract Method (Bapi, Stored Proc, ...)', 'dataflows'),
         'datatype'  => 'text'
      ];

      $tab[] = [
         'id'        => '16',
         'table'     => $this->getTable(),
         'field'     => 'loadmethod',
         'name'      => __('Load Method (Bapi, Stored Proc, ...)', 'dataflows'),
         'datatype'  => 'text'
      ];

      $tab[] = [
         'id'        => '17',
         'table'     => 'glpi_plugin_dataflows_indicators',
         'field'     => 'name',
         'name'      => __('Indicator', 'dataflows'),
         'datatype'  => 'dropdown'
      ];

      $tab[] = [
         'id'            => '18',
         'table'         => $this->getTable(),
         'field'         => 'date_mod',
         'massiveaction' => false,
         'name'          => __('Last update'),
         'datatype'      => 'datetime'
      ];

      $tab[] = [
         'id'            => '19',
         'table'         => $this->getTable(),
         'field'         => 'statedate',
         'massiveaction' => false,
         'name'          => __('Status StartDate', 'dataflows'),
         'datatype'      => 'datetime'
      ];

      $tab[] = [
         'id'        => '20',
         'table'     => 'glpi_plugin_dataflows_transferfreqs',
         'field'     => 'name',
         'name'      => __('Transfer frequency (def : per day)', 'dataflows'),
         'datatype'  => 'dropdown'
      ];

      $tab[] = [
         'id'        => '21',
         'table'     => 'glpi_plugin_dataflows_transfertimetables',
         'field'     => 'name',
         'name'      => __('Transfer Timetable', 'dataflows'),
         'datatype'  => 'dropdown'
      ];
           
      $tab[] = [
         'id'        => '22',
         'table'     => 'glpi_plugin_dataflows_srcpreprocs',
         'field'     => 'name',
         'name'      => __('Transfer Preprocessing', 'dataflows'),
         'datatype'  => 'dropdown'
      ];
           
      $tab[] = [
         'id'        => '23',
         'table'     => 'glpi_plugin_dataflows_destpostprocs',
         'field'     => 'name',
         'name'      => __('Transfer Postprocessing', 'dataflows'),
         'datatype'  => 'dropdown'
      ];
            
      $tab[] = [
         'id'        => '24',
         'table'     => $this->getTable(),
         'field'     => 'transferpriority',
         'name'      => __('Priority', 'dataflows'),
         'datatype'  => 'text'
      ];
      
      $tab[] = [
         'id'        => '26',
         'table'     => $this->getTable(),
         'field'     => 'srcformat',
         'name'      => __('Source format (Idoc, table, file pattern, ...)', 'dataflows'),
         'datatype'  => 'text'
      ];
      
      $tab[] = [
         'id'        => '27',
         'table'     => $this->getTable(),
         'field'     => 'destformat',
         'name'      => __('Destination format (Idoc, table, file pattern, ...)', 'dataflows'),
         'datatype'  => 'text'
      ];
     
      $tab[] = [
         'id'        => '28',
         'table'     => 'glpi_plugin_dataflows_servicelevels',
         'field'     => 'name',
         'name'      => __('Service Level', 'dataflows'),
         'datatype'  => 'dropdown'
      ];

      $tab[] = [
         'id'        => '29',
         'table'     => 'glpi_users',
         'field'     => 'name',
         'linkfield' => 'plugin_dataflows_otherusers_id',
         'name'      => __('Other Expert', 'dataflows'),
         'datatype'  => 'dropdown',
         'right'     => 'interface'
      ];
      
      $tab[] = [
         'id'        => '30',
         'table'     => 'glpi_groups',
         'field'     => 'name',
         'linkfield' => 'plugin_dataflows_othergroups_id',
         'name'      => __('Other group', 'dataflows'),
         'condition' => '`is_assign`',
         'datatype'  => 'dropdown'
      ];

      $tab[] = [
         'id'        => '31',
         'table'     => 'glpi_groups',
         'field'     => 'name',
         'linkfield' => 'plugin_dataflows_supportgroups_id',
         'name'      => __('Dataflow Support', 'dataflows'),
         'condition' => '`is_assign`',
         'datatype'  => 'dropdown'
      ];

      $tab[] = [
         'id'       => '60',
         'table'    => $this->getTable(),
         'field'    => 'id',
         'name'     => __('ID'),
         'datatype' => 'number'
      ];

      $tab[] = [
         'id'       => '61',
         'table'    => $this->getTable(),
         'field'    => 'is_helpdesk_visible',
         'name'     => __('Associable to a ticket'),
         'datatype' => 'bool'
      ];

      $tab[] = [
         'id'       => '62',
         'table'    => $this->getTable(),
         'field'    => 'is_recursive',
         'name'     => __('Child entities'),
         'datatype' => 'bool'
      ];

      $tab[] = [
         'id'        => '63',
         'table'     => $this->getTable(),
         'field'     => 'shortdescription',
         'name'      => __('Short description', 'dataflows'),
         'datatype'  => 'text'
      ];
      
      $tab[] = [
         'id'        => '64',
         'table'     => $this->getTable(),
         'field'     => 'longdescription',
         'name'      => __('Long description', 'dataflows'),
         'datatype'  => 'text'
      ];
      
      $tab[] = [
         'id'            => '71',
         'table'         => 'glpi_plugin_dataflows_dataflows_items',
         'field'         => 'items_id',
         'nosearch'      => true,
         'massiveaction' => false,
         'name'          => _n('Associated item', 'Associated items', 2),
         'forcegroupby'  => true,
         'joinparams'    => [
            'jointype' => 'child'
         ]
      ];

      $tab[] = [
         'id'       => '80',
         'table'    => 'glpi_entities',
         'field'    => 'completename',
         'name'     => __('Entity'),
         'datatype' => 'dropdown'
      ];

      $tab[] = [
         'id'    => '81',
         'table' => 'glpi_entities',
         'field' => 'entities_id',
         'name'  => __('Entity') . "-" . __('ID')
      ];

      return $tab;
   }

   //define header form
   function defineTabs($options=[]) {

      $ong = [];
      $this->addDefaultFormTab($ong);
      $this->addStandardTab('PluginDataflowsDataflow_Item', $ong, $options);
//      $this->addStandardTab('PluginDataflowsInstance', $ong, $options);
//      $this->addStandardTab('PluginDataflowsScript', $ong, $options);
      $this->addStandardTab('Ticket', $ong, $options);
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
   function showForm ($ID, $options=[]) {

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
      Dropdown::show('PluginDataflowsFlowgroup', ['name' => "plugin_dataflows_flowgroups_id", 'value' => $this->fields["plugin_dataflows_flowgroups_id"], 'entity' => $this->fields["entities_id"]]);
      echo "</td>";
      echo "</tr>";

      echo "<tr class='tab_bg_1'>";
      //short description of dataflows
      echo "<td>".__('Short description', 'dataflows')."</td>";
      echo "<td class='top center' colspan='4'>";
//      echo "<textarea cols='100' rows='1' name='shortdescription'>".$this->fields["shortdescription"]."</textarea>";
      Html::autocompletionTextField($this,"shortdescription",['option' => 'style="width:98%"']);
      echo "</td>";
      echo "</tr>";

      echo "<tr class='tab_bg_1'>";
      //long description of dataflows
      echo "<td>".__('Long description', 'dataflows')."</td>";
      echo "<td class='top center' colspan='4'>";
      echo "<textarea cols='100' rows='3' name='longdescription'>".$this->fields["longdescription"]."</textarea>";
      echo "</td>";
      echo "</tr>";

      echo "<tr class='tab_bg_1'>";
      //status of dataflows
      echo "<td>".__('Status')."</td>";
      echo "<td>";
      Dropdown::show('PluginDataflowsState', ['name' => "plugin_dataflows_states_id", 'value' => $this->fields["plugin_dataflows_states_id"], 'entity' => $this->fields["entities_id"]]);
      echo "</td>";
      //status date of dataflows
      echo "<td>".__('Status StartDate', 'dataflows')."</td>";
      echo "<td>";
      Html::showDateField("statedate", ['value' => $this->fields["statedate"]]);
      echo "</td>";
      echo "</tr>";

      echo "<tr class='tab_bg_1'>";
      //transfer protocol
      echo "<td class='top center' colspan='4'>". __('Transfer Protocol', 'dataflows').": ";
      Dropdown::show('PluginDataflowsTransferProtocol', ['name' => "plugin_dataflows_transferprotocols_id", 'value' => $this->fields["plugin_dataflows_transferprotocols_id"]]);
      echo "</td>";
      echo "</tr>";

      echo "<tr class='tab_bg_1'>";
      //from application
      echo "<td>".__('From application', 'dataflows').": </td><td>";
      Dropdown::show('PluginDataflowsFromSwcomponent', ['name' => "plugin_dataflows_fromswcomponents_id", 'value' => $this->fields["plugin_dataflows_fromswcomponents_id"],'entity' => $this->fields["entities_id"]]);
      echo "</td>";
      //to application
      echo "<td>".__('To application', 'dataflows').": </td>";
      echo "<td>";
      Dropdown::show('PluginDataflowsToSwcomponent', ['name' => "plugin_dataflows_toswcomponents_id", 'value' => $this->fields["plugin_dataflows_toswcomponents_id"],'entity' => $this->fields["entities_id"]]);
      echo "</td>";
      echo "</tr>";

      echo "<tr class='tab_bg_1'>";
      //source connector
      echo "<td>".__('Source Connector', 'dataflows').": </td>";
      echo "<td>";
      Dropdown::show('PluginDataflowsSourceConnector', ['name' => "plugin_dataflows_sourceconnectors_id", 'value' => $this->fields["plugin_dataflows_sourceconnectors_id"]]);
      echo "</td>";
      //destination connector
      echo "<td>".__('Destination Connector', 'dataflows').": </td>";
      echo "<td>";
      Dropdown::show('PluginDataflowsDestinationConnector', ['name' => "plugin_dataflows_destinationconnectors_id", 'value' => $this->fields["plugin_dataflows_destinationconnectors_id"]]);
      echo "</td>";
	  echo "</tr>";
	  
	if (class_exists('PluginAccountsAccount')) {
      echo "<tr class='tab_bg_1'>";
      //from credential
      echo "<td>".__('Source User', 'dataflows').": </td><td>";
      Dropdown::show('PluginDataflowsFromCredential', ['name' => "plugin_dataflows_fromcredentials_id", 'value' => $this->fields["plugin_dataflows_fromcredentials_id"],'entity' => $this->fields["entities_id"]]);
      echo "</td>";
      //to credential
      echo "<td>".__('Destination User', 'dataflows').": </td><td>";
      Dropdown::show('PluginDataflowsToCredential', ['name' => "plugin_dataflows_tocredentials_id", 'value' => $this->fields["plugin_dataflows_tocredentials_id"],'entity' => $this->fields["entities_id"]]);
//      Dropdown::show('PluginAccountsAccount', ['value' => $this->fields["plugin_dataflows_tocredentials_id"],'entity' => $this->fields["entities_id"]]);
      echo "</td>";
	  echo "</tr>";
	}

      echo "<tr class='tab_bg_1'>";
      //source path
      echo "<td>".__('From external server', 'dataflows').": </td>";
      echo "<td>";
      Html::autocompletionTextField($this,"plugin_dataflows_fromexternal",['size' => 65]);
      echo "</td>";
      //destination path
      echo "<td>".__('To external server', 'dataflows').": </td>";
      echo "<td>";
      Html::autocompletionTextField($this,"plugin_dataflows_toexternal",['size' => 65]);
      echo "</td>";
	  echo "</tr>";

      echo "<tr class='tab_bg_1'>";
      //source path
      echo "<td>".__('Source directory/ ProgramId/ port', 'dataflows').": </td>";
      echo "<td>";
      Html::autocompletionTextField($this,"plugin_dataflows_srcuri",['size' => 65]);
      echo "</td>";
      //destination path
      echo "<td>".__('Destination directory/ ProgramId/ port', 'dataflows').": </td>";
      echo "<td>";
      Html::autocompletionTextField($this,"plugin_dataflows_desturi",['size' => 65]);
      echo "</td>";
	  echo "</tr>";

      echo "<tr class='tab_bg_1'>";
      //source format
      echo "<td>".__('Source format (Idoc, table, file pattern, ...)', 'dataflows').": </td>";
      echo "<td>";
      Html::autocompletionTextField($this,"srcformat",['size' => 45]);
      echo "</td>";
      //destination format
      echo "<td>".__('Destination format (Idoc, table, file pattern, ...)', 'dataflows').": </td>";
      echo "<td>";
      Html::autocompletionTextField($this,"destformat",['size' => 45]);
      echo "</td>";
	  echo "</tr>";
	  
      echo "<tr class='tab_bg_1'>";
      //extract method
      echo "<td>".__('Extract Method (Bapi, Stored Proc, ...)', 'dataflows').": </td>";
      echo "<td>";
      Html::autocompletionTextField($this,"extractmethod",['size' => 45]);
      echo "</td>";
      //load method
      echo "<td>".__('Load Method (Bapi, Stored Proc, ...)', 'dataflows').": </td>";
      echo "<td>";
      Html::autocompletionTextField($this,"loadmethod",['size' => 45]);
      echo "</td>";
      
      echo "<tr class='tab_bg_1'>";
      //source preprocessing
      echo "<td>".__('Transfer Preprocessing', 'dataflows').": </td>";
      echo "<td>";
      Dropdown::show('PluginDataflowsSrcPreproc', ['name' => "plugin_dataflows_srcpreprocs_id", 'value' => $this->fields["plugin_dataflows_srcpreprocs_id"]]);
      echo "</td>";
      //destination postprocessing
      echo "<td>".__('Transfer Postprocessing', 'dataflows').": </td>";
      echo "<td>";
      Dropdown::show('PluginDataflowsDestPostproc', ['name' => "plugin_dataflows_destpostprocs_id", 'value' => $this->fields["plugin_dataflows_destpostprocs_id"]]);
      echo "</td>";
	  echo "</tr>";
	  
      echo "<tr class='tab_bg_1'>";
      //transfer trigger
      echo "<td class='top center' colspan='4'>".__('Transfer trigger', 'dataflows').": ";
//      echo "<td>".$LANG['plugin_dataflows'][32].": </td>";
//      echo "<td>";
      Dropdown::show('PluginDataflowsTriggerType', ['name' => "plugin_dataflows_triggertypes_id", 'value' => $this->fields["plugin_dataflows_triggertypes_id"]]);
//      echo "</td>";
      //trigger format
//      echo "<td>"
	  echo " (".__('Trigger name', 'dataflows').": ";
//      echo "</td><td>";
      Html::autocompletionTextField($this,"triggerformat",['size' => 45]);
      echo ")</td>";
      echo "</tr>";
      
      echo "<tr class='tab_bg_1'>";
      //transfer frequency
      echo "<td>".__('Transfer frequency (def : per day)', 'dataflows').": </td><td>";
      Dropdown::show('PluginDataflowsTransferFreq', ['name' => "plugin_dataflows_transferfreqs_id", 'value' => $this->fields["plugin_dataflows_transferfreqs_id"]]);
      echo "</td>";
      
      //transfer timetable
      echo "<td>".__('Transfer Timetable', 'dataflows').": </td>";
      echo "<td>";
      Dropdown::show('PluginDataflowsTransferTimetable', ['name' => "plugin_dataflows_transfertimetables_id", 'value' => $this->fields["plugin_dataflows_transfertimetables_id"]]);
      echo "</td>";
      echo "</tr>";

      echo "<tr class='tab_bg_1'>";
      //error handling
      echo "<td>".__('Transfer Error handling', 'dataflows').": </td>";
      echo "<td>";
      Dropdown::show('PluginDataflowsErrorHandling', ['name' => "plugin_dataflows_errorhandlings_id", 'value' => $this->fields["plugin_dataflows_errorhandlings_id"]]);
      echo "</td>";
      
      //transfer on holiday
      echo "<td>".__('Transfer On holiday', 'dataflows').": </td>";
      echo "<td>";
      Dropdown::show('PluginDataflowsHolidayAction', ['name' => "plugin_dataflows_holidayactions_id", 'value' => $this->fields["plugin_dataflows_holidayactions_id"]]);
      echo "</td>";
      echo "</tr>";

      echo "<tr class='tab_bg_1'>";
      //url of functional documentation
      echo "<td>".__('URL to functional doc (mapping, ...)', 'dataflows').": </td>";
      echo "<td>";
      Html::autocompletionTextField($this,"mappingdocurl",['size' => 65]);
      echo "</td>";
      //url of technical documentation
      echo "<td>".__('URL to technical doc (design, ...)', 'dataflows').": </td>";
      echo "<td>";
      Html::autocompletionTextField($this,"technicaldocurl",['size' => 65]);
      echo "</td>";
	  echo "</tr>";

      echo "<tr class='tab_bg_1'>";
      //transfer volume
      echo "<td>".__('Transfer Volume (MB)', 'dataflows').": </td>";
      echo "<td>";
      Html::autocompletionTextField($this,"transfervolume",['size' => 45]);
      echo "</td>";
      //transfer priority
      echo "<td>".__('Priority', 'dataflows').": </td>";
      echo "<td>";
      Html::autocompletionTextField($this,"transferpriority",['size' => 45]);
      echo "</td>";
      echo "</tr>";
	  
      echo "<tr class='tab_bg_1'>";
      //type
      echo "<td>".__('Type').": </td>";
      echo "<td>";
      Dropdown::show('PluginDataflowsType', ['name' => "plugin_dataflows_types_id", 'value' => $this->fields["plugin_dataflows_types_id"]]);
      echo "</td>";
      //indicator
      echo "<td>".__('Indicator', 'dataflows').": </td>";
      echo "<td>";
      Dropdown::show('PluginDataflowsIndicator', ['name' => "plugin_dataflows_indicators_id", 'value' => $this->fields["plugin_dataflows_indicators_id"]]);
      echo "</td>";
      echo "</tr>";
	  
      echo "<tr class='tab_bg_1'>";
      //service level of dataflows
      echo "<td>".__('Service Level', 'dataflows').": </td>";
      echo "<td>";
      Dropdown::show('PluginDataflowsServicelevel', ['name' => "plugin_dataflows_servicelevels_id", 'value' => $this->fields["plugin_dataflows_servicelevels_id"]]);
      echo "</td>";
      //is_helpdesk_visible
      echo "<td>" . __('Associable to a ticket') . "</td><td>";
      Dropdown::showYesNo('is_helpdesk_visible',$this->fields['is_helpdesk_visible']);
      echo "</td>";

      echo "</tr>";

      echo "<tr class='tab_bg_1'>";
      //data owner
      echo "<td>".__('Dataflow Follow-up', 'dataflows')."</td><td>";
      Group::dropdown(['name'      => 'groups_id', 
                        'value'     => $this->fields['groups_id'], 
                        'entity'    => $this->fields['entities_id'], 
                        'condition' => ['is_assign' => 1]]);
      echo "</td>";
      //technical maintainer
      echo "<td>".__('Dataflow Expert', 'dataflows')."</td><td>";
      User::dropdown(['name' => "users_id", 'value' => $this->fields["users_id"], 'entity' => $this->fields["entities_id"], 'right' => 'interface']);
      echo "</td>";
      echo "</tr>";


      echo "<tr class='tab_bg_1'>";
      //other group
      echo "<td>".__('Other group', 'dataflows')."</td>";
      echo "<td>";
      Dropdown::show('PluginDataflowsOtherGroup', ['name' => "plugin_dataflows_othergroups_id", 'value' => $this->fields["plugin_dataflows_othergroups_id"], 'entity' => $this->fields["entities_id"]]);
      echo "</td>";
      //other expert
      echo "<td>".__('Other expert', 'dataflows').": </td>";
      echo "<td>";
      Dropdown::show('PluginDataflowsOtherUser', ['value' => $this->fields["plugin_dataflows_otherusers_id"],'entity' => $this->fields["entities_id"]]);
      echo "</td>";
      echo "</tr>";

      echo "<tr class='tab_bg_1'>";
      //support group
      echo "<td>".__('Dataflow Support', 'dataflows').": </td><td>";
      Dropdown::show('PluginDataflowsSupportGroup', ['value' => $this->fields["plugin_dataflows_supportgroups_id"],'entity' => $this->fields["entities_id"]]);
      echo "</td>";
      //modification date
/*      echo "<td class='center' colspan = '4'>";
      printf(__('Last update on %s'), Html::convDateTime($this->fields["date_mod"]));
      echo "</td>";
*/
      echo "</tr>";

      $this->showFormButtons($options);

      return true;
   }
   
   /**
    * Make a select box for link dataflow
    *
    * Parameters which could be used in options array :
    *    - name : string / name of the select (default is plugin_dataflows_flowgroups_id)
    *    - entity : integer or array / restrict to a defined entity or array of entities
    *                   (default -1 : no restriction)
    *    - used : array / Already used items ID: not to display in dropdown (default empty)
    *
    * @param $options array of possible options
    *
    * @return nothing (print out an HTML select box)
   **/
   static function dropdownDataflow($options=[]) {
      global $DB, $CFG_GLPI;


      $p['name']    = 'plugin_dataflows_dataflows_id';
      $p['entity']  = '';
      $p['used']    = [];
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
                FROM `glpi_plugin_dataflows_flowgroups`
                WHERE `id` IN (SELECT DISTINCT `plugin_dataflows_flowgroups_id`
                               FROM `glpi_plugin_dataflows_dataflows`
                             $where)
                ORDER BY `name`";
      $result = $DB->query($query);

      $values = [0 => Dropdown::EMPTY_VALUE];

      while ($data = $DB->fetchAssoc($result)) {
         $values[$data['id']] = $data['name'];
      }
      $rand = mt_rand();
      $out  = Dropdown::showFromArray('_flowgroup', $values, ['width'   => '30%',
                                                                     'rand'    => $rand,
                                                                     'display' => false]);
      $field_id = Html::cleanId("dropdown__flowgroup$rand");

      $params   = ['flowgroup' => '__VALUE__',
                        'entity' => $p['entity'],
                        'rand'   => $rand,
                        'myname' => $p['name'],
                        'used'   => $p['used']];

      $out .= Ajax::updateItemOnSelectEvent($field_id,"show_".$p['name'].$rand,
                                            $CFG_GLPI["root_doc"]."/plugins/dataflows/ajax/dropdownFlowgroupDataflows.php",
                                            $params, false);
      $out .= "<span id='show_".$p['name']."$rand'>";
      $out .= "</span>\n";

      $params['flowgroup'] = 0;
      $out .= Ajax::updateItem("show_".$p['name'].$rand,
                               $CFG_GLPI["root_doc"]. "/plugins/dataflows/ajax/dropdownFlowgroupDataflows.php",
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
            self::dropdownDataflow([]);
            echo "&nbsp;".
                 Html::submit(_x('button','Post'), ['name' => 'massiveaction']);
            return true;
            break;
         case "install" :
            Dropdown::showSelectItemFromItemtypes(['items_id_name' => 'item_item',
                                                        'itemtype_name' => 'typeitem',
                                                        'itemtypes'     => self::getTypes(true),
                                                        'checkright'
                                                                        => true,
                                                  ]);
            echo Html::submit(_x('button', 'Post'), ['name' => 'massiveaction']);
            return true;
            break;
         case "uninstall" :
            Dropdown::showSelectItemFromItemtypes(['items_id_name' => 'item_item',
                                                        'itemtype_name' => 'typeitem',
                                                        'itemtypes'     => self::getTypes(true),
                                                        'checkright'
                                                                        => true,
                                                  ]);
            echo Html::submit(_x('button', 'Post'), ['name' => 'massiveaction']);
            return true;
            break;
         case "duplicate" :
		    $options = [];
			$options['value'] = 1;
			$options['min'] = 1;
			$options['max'] = 20;
			$options['unit'] = "times";
            Dropdown::showNumber('repeat', $options);
            echo Html::submit(_x('button','Post'), ['name' => 'massiveaction']);
            return true;
            break;
         case "transfer" :
            Dropdown::show('Entity');
            echo Html::submit(_x('button','Post'), ['name' => 'massiveaction']);
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
               $input = ['plugin_dataflows_dataflowtypes_id' => $input['plugin_dataflows_dataflowtypes_id'],
                                 'items_id'      => $id,
                                 'itemtype'      => $item->getType()];
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
                  $values = ['plugin_dataflows_dataflows_id' => $key,
                                 'items_id'      => $input["item_item"],
                                 'itemtype'      => $input['typeitem']];
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
				  $success = [];
				  $failure = [];
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
