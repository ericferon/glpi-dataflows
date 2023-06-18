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

class PluginDataflowsConfigdf extends CommonDBTM {

   public $dohistory=true;
   static $rightname = "plugin_dataflows_configuration";
   protected $usenotepad         = true;
   
   static function getTypeName($nb=0) {

      return __('Dataflows Config', 'dataflows');
   }

   // search fields from GLPI 9.3 on
   function rawSearchOptions() {

      $tab = [];
//      if (version_compare(GLPI_VERSION,'9.2','le')) return $tab;

      $tab[] = [
         'id'   => 'common',
         'name' => self::getTypeName(2)
      ];

      $tab[] = [
         'id'            => '2',
         'table'         => $this->getTable(),
         'field'         => 'name',
         'name'          => __('Name'),
         'datatype'		 => 'itemlink',
		 'massiveaction' => false
      ];


      $tab[] = [
         'id'       => '3',
         'table'    => PluginDataflowsConfigdfFieldgroup::getTable(),
         'field'    => 'name',
         'name'     => PluginDataflowsConfigdfFieldgroup::getTypeName(1),
         'datatype' => 'dropdown'
      ];

      $tab[] = [
         'id'       => '4',
         'table'    => PluginDataflowsConfigdfDatatype::getTable(),
         'field'    => 'name',
         'name'     => PluginDataflowsConfigdfDatatype::getTypeName(1),
         'datatype' => 'dropdown'
      ];

      $tab[] = [
         'id'       => '5',
         'table'    => PluginDataflowsConfigdfDbfieldtype::getTable(),
         'field'    => 'name',
         'name'     => PluginDataflowsConfigdfDbfieldtype::getTypeName(1),
         'datatype' => 'dropdown'
      ];

      $tab[] = [
         'id'       => '10',
         'table'    => $this->getTable(),
         'field'    => 'description',
         'name'     => __('Description'),
         'datatype' => 'text'
      ];

      $tab[] = [
         'id'       => '11',
         'table'    => $this->getTable(),
         'field'    => 'row',
         'name'     => __('Row', 'dataflows'),
         'datatype' => 'text'
      ];

      $tab[] = [
         'id'       => '12',
         'table'    => PluginDataflowsConfigdfHalign::getTable(),
         'field'    => 'name',
         'name'     => PluginDataflowsConfigdfHalign::getTypeName(1),
         'datatype' => 'dropdown'
      ];

      $tab[] = [
         'id'       => '13',
         'table'    => $this->getTable(),
         'field'    => 'is_linked',
         'name'     => __('Is linked to another class', 'dataflows'),
         'datatype' => 'bool'
      ];

      $tab[] = [
         'id'       => '14',
         'table'    => PluginDataflowsConfigdfLink::getTable(),
         'field'    => 'name',
         'name'     => PluginDataflowsConfigdfLink::getTypeName(1),
         'datatype' => 'dropdown'
      ];

      $tab[] = [
         'id'       => '15',
         'table'    => $this->getTable(),
         'field'    => 'nosearch',
         'name'     => __('Massive action allowed ?', 'dataflows'),
         'datatype' => 'bool'
      ];

      $tab[] = [
         'id'       => '16',
         'table'    => $this->getTable(),
         'field'    => 'forcegroupby',
         'name'     => __('Force group by ?', 'dataflows'),
         'datatype' => 'bool'
      ];

       $tab[] = [
         'id'            => '72',
         'table'         => $this->getTable(),
         'field'         => 'id',
         'name'          => __('ID'),
         'datatype'      => 'number'
      ];

      return $tab;
   }

   //define header form
   function defineTabs($options=[]) {

      $ong = [];
      $this->addDefaultFormTab($ong);
      $this->addStandardTab('Log', $ong, $options);

      return $ong;
   }

   function showForm ($ID, $options=[]) {

      $this->initForm($ID, $options);
      $this->showFormHeader($options);

      echo "<tr class='tab_bg_1'>";
     //name
      echo "<td>".__('Name')."</td>";
      echo "<td>";
      echo Html::input('name',['value' => $this->fields['name'], 'id' => "name" , 'width' => '100%']);
      echo Html::showToolTip("A name must be lowercase, start with a letter, contain only letters, numbers or underscores.<br/>If the field is a dropdown, the name must end with '_id', otherwise it may not end with '_id'.<br/>Some words are reserved : name, completename, id, date_mod, is_recursive, entities_id, is_deleted, ancestors_cache, sons_cache.",['applyto' => 'name']);
      echo "</td>";
      //skip 2nd column
      echo "<td></td>";
      echo "<td></td>";
     //name
      echo "<td>".__('Description')."</td>";
      echo "<td>";
      echo Html::input('description',['value' => $this->fields['description'], 'id' => "description" , 'width' => '100%']);
      echo "</td>";
 	  echo "</tr>";

      echo "<tr class='tab_bg_1'>";
      //field group
      echo "<td>".__('Field group', 'dataflows').": </td>";
      echo "<td>";
      Dropdown::show('PluginDataflowsConfigdfFieldgroup', ['value' => $this->fields['plugin_dataflows_configdffieldgroups_id']]);
      echo "</td>";
      //row
      echo "<td>".__('Row', 'dataflows')."</td>";
      echo "<td>";
      echo Html::input('row',['value' => $this->fields['row'], 'id' => "row", 'size' => 2]);
      echo "</td>";
      //horizontal alignment
      echo "<td>".__('Hor.alignment', 'dataflows')."</td>";
      echo "<td>";
      Dropdown::show('PluginDataflowsConfigdfHalign', ['value' => $this->fields['plugin_dataflows_configdfhaligns_id']]);
      echo "</td>";
	  echo "</tr>";

      echo "<tr class='tab_bg_1'>";
      //db field type
      echo "<td>".__('DB Field Type', 'dataflows').": </td>";
      echo "<td>";
      Dropdown::show('PluginDataflowsConfigdfDbfieldtype', ['value' => $this->fields['plugin_dataflows_configdfdbfieldtypes_id']]);
      echo "</td>";
      //search datatype
      echo "<td>".__('Search Data Type', 'dataflows').": </td>";
      echo "<td>";
      Dropdown::show('PluginDataflowsConfigdfDatatype', ['value' => $this->fields['plugin_dataflows_configdfdatatypes_id']]);
      echo "</td>";
      //readonly
      echo "<td>".__('Is read-only ?', 'dataflows').": </td>";
      echo "<td>";
      Dropdown::showYesNo('is_readonly',$this->fields['is_readonly']);
      echo "</td>";
	  echo "</tr>";
	  
      echo "<tr class='tab_bg_1'>";
      //nosearch
      echo "<td>".__('Search allowed ?', 'dataflows').": </td>";
      echo "<td>";
      Dropdown::showYesNo('nosearch',$this->fields['nosearch']);
      echo "</td>";
      //massiveaction
      echo "<td>".__('Massive action allowed ?', 'dataflows')."</td>";
      echo "<td>";
      Dropdown::showYesNo('massiveaction',$this->fields['massiveaction']);
      echo "</td>";
      //forcegroupby
      echo "<td>".__('Force group by ?', 'dataflows')."</td>";
      echo "<td>";
      Dropdown::showYesNo('forcegroupby',$this->fields['forcegroupby']);
      echo "</td>";
	  echo "</tr>";
	  
      echo "<tr class='tab_bg_1'>";
      //islinked
      echo "<td>".__('Is linked to another class ?', 'dataflows').": </td>";
      echo "<td>";
      Dropdown::showYesNo('is_linked',$this->fields['is_linked']);
      echo "</td>";
      //linked table
      echo "<td>".__('Linked class', 'dataflows')."</td>";
      echo "<td>";
      Dropdown::show('PluginDataflowsConfigdfLink', ['value' => $this->fields['plugin_dataflows_configdflinks_id']]);
      echo "</td>";
      //link field
      echo "<td>".__('Linked by field', 'dataflows')."</td>";
      echo "<td>";
      echo Html::input('linkfield',['value' => $this->fields['linkfield'], 'id' => "linkfield"]);
      echo "</td>";
	  echo "</tr>";

      echo "<tr class='tab_bg_1'>";
      //join parameters
      echo "<td>".__('Join parameters', 'dataflows')."</td>";
      echo "<td colspan='5'>";
      echo Html::input('joinparams',['value' => $this->fields['joinparams'], 'id' => "joinparams"]);
      echo "</td>";
	  echo "</tr>";
      $this->showFormButtons($options);

      return true;
   }
}

?>
