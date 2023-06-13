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
   
   static $types = ['Computer','Software', 'SoftwareLicense', 'Contract', 'Project', 'ProjectTask', 'PluginAccountsAccount', "PluginDataflowsSwcomponent", "Certificate", "Appliance"];

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

   // search fields from GLPI 9.3 on
   function rawSearchOptions() {
   global $DB;

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

      $linktable = [];
      $tablequery = "SELECT * FROM `glpi_plugin_dataflows_configdflinks`";
      $tableresult = $DB->query($tablequery);
      while ($tabledata = $DB->fetchAssoc($tableresult)) {
         $linktable[$tabledata['id']]['name'] = $tabledata['name'];
         $linktable[$tabledata['id']]['has_dropdown'] = $tabledata['has_dropdown'];
         $linktable[$tabledata['id']]['is_entity_limited'] = $tabledata['is_entity_limited'];
      }

      $datatypetable = [];
      $datatypequery = "SELECT * FROM `glpi_plugin_dataflows_configdfdatatypes`";
      $datatyperesult = $DB->query($datatypequery);
      while ($datatypedata = $DB->fetchAssoc($datatyperesult)) {
         $datatypetable[$datatypedata['id']]['name'] = $datatypedata['name'];
      }

      $fieldquery = "SELECT * 
                FROM `glpi_plugin_dataflows_configdfs` 
                WHERE `is_deleted` = 0 
                ORDER BY `id`";
      $fieldresult = $DB->query($fieldquery);
      $rowcount = $DB->numrows($fieldresult);
      $tabid = 1; // tabid 1 is used for name
      $tabtable = $this->getTable();
      while ($fielddata = $DB->fetchAssoc($fieldresult)) {
         $tabid = 1 + $fielddata['id'];
         $datatypeid = $fielddata['plugin_dataflows_configdfdatatypes_id'];
         switch($datatypeid) {
            case 1: //Text
            case 2: //Boolean
            case 3: //Date
            case 4: //Date and time
            case 5: //Number
            case 8: //Textarea
               $tab[] = [
                  'id'       => $tabid,
                  'table'    => $tabtable,
                  'field'    => $fielddata['name'],
                  'name'     => __($fielddata['description'],'dataflows'),
                  'datatype' => $datatypetable[$datatypeid]['name'],
                  'massiveaction' => $fielddata['massiveaction'],
                  'nosearch' => $fielddata['nosearch']
               ];
               break;
            case 6: //Dropdown
               $linktableid = $fielddata['plugin_dataflows_configdflinks_id'];
               $itemtype = $linktable[$linktableid]['name'];
               $tablename = $this->getTable($itemtype);
               $tab[] = [
                  'id'       => $tabid,
                  'table'    => $tablename,
                  'field'    => 'name',
                  'name'     => __($fielddata['description'],'dataflows'),
                  'datatype' => $datatypetable[$datatypeid]['name']
               ];
               break;
            case 7: //Itemlink
               break;
         }
      }

      $tabid++;
      $tab[] = [
         'id'       => $tabid++,
         'table'    => $this->getTable(),
         'field'    => 'id',
         'name'     => __('ID'),
         'datatype' => 'number'
      ];

      $tab[] = [
         'id'       => $tabid++,
         'table'    => $this->getTable(),
         'field'    => 'is_recursive',
         'name'     => __('Child entities'),
         'datatype' => 'bool'
      ];

      $tab[] = [
         'id'            => $tabid++,
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
         'id'       => $tabid++,
         'table'    => 'glpi_entities',
         'field'    => 'completename',
         'name'     => __('Entity'),
         'datatype' => 'dropdown'
      ];

      $tab[] = [
         'id'    => $tabid++,
         'table' => 'glpi_entities',
         'field' => 'entities_id',
         'name'  => __('Entity') . "-" . __('ID'),
      ];

      $tab[] = [
         'id'                 => $tabid++,
         'table'        	  => 'glpi_projects',
         'field'              => 'name',
         'name'               => Project::getTypeName(2)." - ".__('Name'),
         'linkfield'		  => 'items_id',
         'datatype'           => 'itemlink',
         'massiveaction'      => false,
         'forcegroupby'       => true,
         'itemlink_type'	  => Project::getType(),
         'joinparams'    	  => [
								'beforejoin'=> ['table'      => 'glpi_plugin_dataflows_dataflows_items',
												'joinparams' => ['jointype' => 'itemtype_item',
																'linkfield'		  => 'items_id'
																]
												]
								]
      ];

      $tab[] = [
         'id'                 => $tabid++,
         'table'        	  => 'glpi_projecttasks',
         'field'              => 'name',
         'name'               => ProjectTask::getTypeName(2)." - ".__('Name'),
         'linkfield'		  => 'items_id',
         'datatype'           => 'itemlink',
         'massiveaction'      => false,
         'forcegroupby'       => true,
         'itemlink_type'	  => ProjectTask::getType(),
         'joinparams'    	  => [
								'beforejoin'=> ['table'      => 'glpi_plugin_dataflows_dataflows_items',
												'joinparams' => ['jointype' => 'itemtype_item',
																'linkfield'		  => 'items_id'
																]
												]
								]
      ];

      return $tab;
   }

   //define header form
   function defineTabs($options=[]) {

      $ong = [];
      $this->addDefaultFormTab($ong);
//      $this->addStandardTab('PluginDataflowsMapping', $ong, $options);
      $this->addImpactTab($ong, $options);
      $this->addStandardTab('PluginDataflowsDataflow_Item', $ong, $options);
      $this->addStandardTab('Ticket', $ong, $options);
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
   global $DB;

      // check whether there are "center" columns
      $columnquery = "SELECT * 
                FROM `glpi_plugin_dataflows_configdfs` 
                WHERE `is_deleted` = 0 AND `plugin_dataflows_configdfhaligns_id` in (3,4,5)";
      $columnresult = $DB->query($columnquery);
      $rowcount = $DB->numrows($columnresult);
      if ($rowcount == 0) {
         $columncount = 4;
         $colwidth = "25%";
      } else {
         $columncount = 6;
         $colwidth = "16%";
      }

      $options['colspan'] = $columncount;
      $this->initForm($ID, $options);
      $this->showFormHeader($options);

      // define class for right alignment
      echo "<style>.alignright { text-align: right; }</style>";
      
      // Line: 1
      $curline = 1;
      echo "<tr class='tab_bg_1'>";
      //name of dataflows
      echo "<td>".__('Name')."</td>";
      echo "<td>";
      echo Html::input('name',['value' => $this->fields['name'], 'id' => "name"]);
      echo "</td>";
      $halign = 3;

      $linktable = [];
      $tablequery = "SELECT * FROM `glpi_plugin_dataflows_configdflinks`";
      $tableresult = $DB->query($tablequery);
      while ($tabledata = $DB->fetchAssoc($tableresult)) {
         $linktable[$tabledata['id']]['name'] = $tabledata['name'];
         $linktable[$tabledata['id']]['has_dropdown'] = $tabledata['has_dropdown'];
         $linktable[$tabledata['id']]['is_entity_limited'] = $tabledata['is_entity_limited'];
      }

      $fieldquery = "SELECT * 
                FROM `glpi_plugin_dataflows_configdfs` 
                WHERE `is_deleted` = 0 AND `plugin_dataflows_configdffieldgroups_id` = 0 
                ORDER BY `row`, `plugin_dataflows_configdfhaligns_id`";
      $fieldresult = $DB->query($fieldquery);
      $rowcount = $DB->numrows($fieldresult);
      if ($rowcount > 0) {
         $fgroupname = '';
         $rownbr = $curline;
//         $halign = 5;
         $tonextrow = false;
         while ($fielddata = $DB->fetchAssoc($fieldresult)) {
            $fieldtype = $fielddata['plugin_dataflows_configdfhaligns_id'];
            if ($fielddata['row'] != $rownbr) {
               if ($rownbr != $curline) {
                  // If not the first row, end preceding table row
                  echo "</tr>";
               }
               // Set current rownbr
               $rownbr = $fielddata['row'];
               // Start new table row
               echo "<tr class='tab_bg_1'>";
               $halign = 1;
               $tonextrow = false;
            } else if ($tonextrow) {
               continue; // skip this field which is located on the same row (and should not)
            }
            
            //Display field
               switch($fieldtype) {
               case 1: // Full row
                  if ($halign == 1) {
                     $colspan = $columncount - 1;
                     $this->displayField($fielddata, $colspan, $linktable);
                     $halign += 1 + $colspan; // move halign to next column to write into
                     $tonextrow = true;
                  }
                  break;
               case 2: // Left column
                  if ($halign == 1) {
                     $colspan = 1;
                     $this->displayField($fielddata, $colspan, $linktable);
                     $halign += 1 + $colspan; // move halign to next column to write into
                     $tonextrow = false;
                  }
                  break;
               case 3: // Left+Center columns
                  if ($halign == 1) {
                     $colspan = 3;
                    $this->displayField($fielddata, $colspan, $linktable);
                     $halign += 1 + $colspan; // move halign to next column to write into
                     $tonextrow = true;
                  }
                  break;
               case 4: // Center column
                  if ($halign <= 3) {
                     $colspan = 1;
                     while ($halign < 3) { // fill empty columns
                        echo "<td/>";
                        $halign++;
                     }
                     $this->displayField($fielddata, $colspan, $linktable);
                     $halign += 1 + $colspan; // move halign to next column to write into
                     $tonextrow = false;
                  }
                  break;
               case 5: // Center+Right columns
                  if ($halign <= 3) {
                     $colspan = 3;
                     while ($halign < 3) { // fill empty columns
                        echo "<td/>";
                        $halign++;
                     }
                     $this->displayField($fielddata, $colspan, $linktable);
                     $halign += 1 + $colspan; // move halign to next column to write into
                     $tonextrow = true;
                  }
                  break;
               case 6: // Right column
                  if ($halign <= $columncount - 1) {
                     $colspan = 1;
                     while ($halign < $columncount - 1) { // fill empty columns
                        echo "<td/>";
                        $halign++;
                     }
                     $this->displayField($fielddata, $colspan, $linktable);
                     $halign += 1 + $colspan; // move halign to next column to write into
                     $tonextrow = false;
                  }
                  break;
               case 7: // Straddling 2 columns
                  if ($halign < 2) {
                     $colspan = 1;
                     while ($halign < 2) { // fill empty columns
                        echo "<td/>";
                        $halign++;
                     }
                     $this->displayField($fielddata, $colspan, $linktable);
                     $halign += 1 + $colspan; // move halign to next column to write into
                     $tonextrow = false;
                  }
                  break;
               }
            }
            // End last table row
            echo "</tr>";
      }

      // Generate accordions according to groups named in configbpfieldgroups

      $fgroupquery = "SELECT * 
                FROM `glpi_plugin_dataflows_configdffieldgroups` 
                ORDER BY `sortorder`";
      $fgroupresult = $DB->query($fgroupquery);

      while ($fgroupdata = $DB->fetchAssoc($fgroupresult)) {
         $fgroupid = $fgroupdata['id'];
         $fgroupname = $fgroupdata['name']."tbl"; //name of the grouping table
         $fgroupcomment = $fgroupdata['comment'];
         $fgroupexpanded = ($fgroupdata['is_visible'] != 0)?'collapse show':'collapse';

         $fieldquery = "SELECT * 
                FROM `glpi_plugin_dataflows_configdfs` 
                WHERE `is_deleted` = 0 AND `plugin_dataflows_configdffieldgroups_id` = $fgroupid 
                ORDER BY `row`, `plugin_dataflows_configdfhaligns_id`";
         $fieldresult = $DB->query($fieldquery);
         $rowcount = $DB->numrows($fieldresult);
         if ($rowcount > 0) {
            // Accordion separator
            echo "<tr class='badge accordion-header'><td><button class='accordion-button' type='button' data-bs-toggle='collapse' data-bs-target='.".$fgroupname."'>".$fgroupcomment."</button></td></tr>";

            $rownbr = '';
            while ($fielddata = $DB->fetchAssoc($fieldresult)) {
               if ($fielddata['row'] != $rownbr) {
                  if ($rownbr != '') {
                     // If not the first row, end preceding table row
                     echo "</tr>";
                  }
                  // Set current rownbr
                  $rownbr = $fielddata['row'];
                  // Start new table row
                  echo "<tr class='tab_bg_1 ".$fgroupname." accordion-collapse  ".$fgroupexpanded."'>";
                  $halign = 1;
                  $tonextrow = false;
               } else if ($tonextrow) {
                  continue; // skip this field which is located on the same row (and should not)
               }
            
               //Display field
               $fieldtype = $fielddata['plugin_dataflows_configdfhaligns_id'];
               switch($fieldtype) {
               case 1: // Full row
                  if ($halign == 1) {
                     $colspan = $columncount - 1;
                     $this->displayField($fielddata, $colspan, $linktable);
                     $halign += 1 + $colspan; // move halign to next column to write into
                     $tonextrow = true;
                  }
                  break;
               case 2: // Left column
                  if ($halign == 1) {
                     $colspan = 1;
                     $this->displayField($fielddata, $colspan, $linktable);
                     $halign += 1 + $colspan; // move halign to next column to write into
                     $tonextrow = false;
                  }
                  break;
               case 3: // Left+Center columns
                  if ($halign == 1) {
                     $colspan = 3;
                     $this->displayField($fielddata, $colspan, $linktable);
                     $halign += 1 + $colspan; // move halign to next column to write into
                     $tonextrow = true;
                  }
                  break;
               case 4: // Center column
                  if ($halign <= 3) {
                     $colspan = 1;
                     while ($halign < 3) { // fill empty columns
                        echo "<td/>";
                        $halign++;
                     }
                     $this->displayField($fielddata, $colspan, $linktable);
                     $halign += 1 + $colspan; // move halign to next column to write into
                     $tonextrow = false;
                  }
                  break;
               case 5: // Center+Right columns
                  if ($halign <= 3) {
                     $colspan = 3;
                     while ($halign < 3) { // fill empty columns
                        echo "<td/>";
                        $halign++;
                     }
                     $this->displayField($fielddata, $colspan, $linktable);
                     $halign += 1 + $colspan; // move halign to next column to write into
                     $tonextrow = true;
                  }
                  break;
               case 6: // Right column
                  if ($halign <= $columncount - 1) {
                     $colspan = 1;
                     while ($halign < $columncount - 1) { // fill empty columns
                        echo "<td/>";
                        $halign++;
                     }
                     $this->displayField($fielddata, $colspan, $linktable);
                     $halign += 1 + $colspan; // move halign to next column to write into
                     $tonextrow = false;
                  }
                  break;
               case 7: // Straddling 2 columns
                  if ($halign < 2) {
                     $colspan = 1;
                     while ($halign < 2) { // fill empty columns
                        echo "<td/>";
                        $halign++;
                     }
                     $this->displayField($fielddata, $colspan, $linktable);
                     $halign += 1 + $colspan; // move halign to next column to write into
                     $tonextrow = false;
                  }
                  break;
                }
            }
            // End last table row
            echo "</tr>";
         }
      }


      $this->showFormButtons($options);

      return true;
   }
   
   function displayField($fielddata, $colspan = 1, $linktable=[]) {
      $fieldname = $fielddata['name'];
      $fielddescription = $fielddata['description'];
      $fieldreadonly = $fielddata['is_readonly']?'true':'false';
      $fieldtype = $fielddata['plugin_dataflows_configdfhaligns_id'];
      $fieldhalign = ($fieldtype == '7') ? "class='alignright'":"";
      $params = [];
      $params['value'] = $this->fields[$fieldname];
      if ($fielddata['is_readonly']) {
         $params['readonly'] = 'true';
      }
      switch($fielddata['plugin_dataflows_configdfdatatypes_id']) {
         case 1: //Text
            echo "<td $fieldhalign>".__($fielddescription, 'archibp')."</td>";
            echo "<td colspan='".$colspan."'>";
            $params['id'] = $fieldname;
            $params['width'] = '100%';
            echo Html::input($fieldname,$params);
            echo "</td>";
            break;
         case 2: //Boolean
            echo "<td $fieldhalign>".__($fielddescription, 'archibp')."</td>";
            echo "<td colspan='".$colspan."'>";
            Dropdown::showYesNo($fieldname,$this->fields[$fieldname], -1);
            echo "</td>";
            break;
         case 3: //Date
            echo "<td $fieldhalign>".__($fielddescription, 'archibp')."</td>";
            echo "<td colspan='".$colspan."'>";
            Html::showDateField($fieldname, ['value' => empty($this->fields[$fieldname])?date("Y-m-d"):$this->fields[$fieldname], 'readonly' => $fieldreadonly]);
            echo "</td>";
            break;
         case 4: //Date and time
            echo "<td $fieldhalign>".__($fielddescription, 'archibp')."</td>";
            echo "<td colspan='".$colspan."'>";
            Html::showDateTimeField($fieldname, ['value' => empty($this->fields[$fieldname])?date("Y-m-d H:i:s"):$this->fields[$fieldname], 'readonly' => $fieldreadonly]);
            echo "</td>";
            break;
         case 5: //Number
            echo "<td $fieldhalign>".__($fielddescription, 'archibp')."</td>";
            echo "<td colspan='".$colspan."'>";
            Dropdown::showNumber($fieldname, $params);
            echo "</td>";
            break;
         case 6: //Dropdown
         case 9: //Dropdown
            if ($linktable[$fielddata['plugin_dataflows_configdflinks_id']]['is_entity_limited']) {
               $params['entity'] = $this->fields["entities_id"];
            }
            if ($linktable[$fielddata['plugin_dataflows_configdflinks_id']]['name'] == 'User') {
               $params['right'] = 'interface';
            }
            echo "<td $fieldhalign>".__($fielddescription, 'archibp')."</td>";
            echo "<td colspan='".$colspan."'>";
            if ($linktable[$fielddata['plugin_dataflows_configdflinks_id']]['has_dropdown']) {
               $linktable[$fielddata['plugin_dataflows_configdflinks_id']]['name']::dropdown($params);
            }
            else {
               Dropdown::show($linktable[$fielddata['plugin_dataflows_configdflinks_id']]['name'], $params);
            }
            echo "</td>";
            break;
         case 7: //Itemlink
            echo "<td $fieldhalign>";
            echo Html::link(__($fielddescription, 'archibp'), $this->fields[$fieldname]);
            echo "</td>";
            echo "<td colspan='".$colspan."'>";
            $params['id'] = $fieldname;
            $params['width'] = '100%';
            echo Html::input($fieldname,$params);
            echo "</td>";
            break;
         case 8: //Textarea
            echo "<td $fieldhalign>".__($fielddescription, 'archibp')."</td>";
            echo "<td colspan='".$colspan."'>";
            echo Html::textarea(['name' => $fieldname, 'value' => $this->fields[$fieldname], 'editor_id' => $fieldname, 
                                'enable_richtext' => true, 'display' => false, 'rows' => 3, 'readonly' => $fieldreadonly]);
            echo "</td>";
            break;      
      }
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
                                            Plugin::getWebDir("dataflows")."/ajax/dropdownFlowgroupDataflows.php",
                                            $params, false);
      $out .= "<span id='show_".$p['name']."$rand'>";
      $out .= "</span>\n";

      $params['flowgroup'] = 0;
      $out .= Ajax::updateItem("show_".$p['name'].$rand,
                               Plugin::getWebDir("dataflows")."/ajax/dropdownFlowgroupDataflows.php",
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
    * Type that could be linked to a dataflow
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

      if ($withtemplate!=2) echo "<form method='post' action=\"".Plugin::getPhpDir("dataflows")."/front/dataflow.form.php\">";

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
            echo "<td class='center'><a href='".Plugin::getPhpDir("dataflows")."/front/dataflow.form.php?id=".$data["id"]."'>".$data["name"];
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
