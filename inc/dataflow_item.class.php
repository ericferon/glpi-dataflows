<?php
/*
 -------------------------------------------------------------------------
 Dataflows plugin for GLPI
 Copyright C 2009-2018 by Eric Feron.
 -------------------------------------------------------------------------

 LICENSE
      
 This file is part of dataflows.

 Dataflows is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 at your option any later version.

 Dataflows is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with dataflows. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 */

   static function showForItem(CommonDBTM $item, $withtemplate='') {
      global $DB, $CFG_GLPI;

      $ID = $item->getField('id');

      if ($item->isNewID($ID)) {
         return false;
      }
      if (!Session::haveRight('plugin_dataflows', READ)) {
         return false;
      }

      if (!$item->can($item->fields['id'], READ)) {
         return false;
      }

      if (empty($withtemplate)) {
         $withtemplate = 0;
      }

      $canedit       =  $item->canadditem('PluginDataflowsDataflow');
      $rand          = mt_rand();
      $is_recursive  = $item->isRecursive();

      $query = "SELECT `glpi_plugin_dataflows_dataflows_items`.`id` AS assocID,
                       `glpi_entities`.`id` AS entity,
                       `glpi_plugin_dataflows_dataflows`.`name` AS assocName,
                       `glpi_plugin_dataflows_dataflows`.*
                FROM `glpi_plugin_dataflows_dataflows_items`
                LEFT JOIN `glpi_plugin_dataflows_dataflows`
                 ON (`glpi_plugin_dataflows_dataflows_items`.`plugin_dataflows_dataflows_id`=`glpi_plugin_dataflows_dataflows`.`id`)
                LEFT JOIN `glpi_entities` ON (`glpi_plugin_dataflows_dataflows`.`entities_id`=`glpi_entities`.`id`)
                WHERE `glpi_plugin_dataflows_dataflows_items`.`items_id` = '$ID'
                      AND `glpi_plugin_dataflows_dataflows_items`.`itemtype` = '".$item->getType()."' ";

      $query .= getEntitiesRestrictRequest(" AND","glpi_plugin_dataflows_dataflows",'','',true);

      $query .= " ORDER BY `assocName`";

      $result = $DB->query($query);
      $number = $DB->numrows($result);
      $i      = 0;

      $dataflows      = array();
      $dataflow       = new PluginDataflowsDataflow();
      $used          = array();
      if ($numrows = $DB->numrows($result)) {
         while ($data = $DB->fetch_assoc($result)) {
            $dataflows[$data['assocID']] = $data;
            $used[$data['id']] = $data['id'];
         }
      }

      if ($canedit && $withtemplate < 2) {
         // Restrict entity for knowbase
         $entities = "";
         $entity   = $_SESSION["glpiactive_entity"];

         if ($item->isEntityAssign()) {
            /// Case of personal items : entity = -1 : create on active entity (Reminder case))
            if ($item->getEntityID() >=0 ) {
               $entity = $item->getEntityID();
            }

            if ($item->isRecursive()) {
               $entities = getSonsOf('glpi_entities',$entity);
            } else {
               $entities = $entity;
            }
         }
         $limit = getEntitiesRestrictRequest(" AND ","glpi_plugin_dataflows_dataflows",'',$entities,true);
         $q = "SELECT COUNT(*)
               FROM `glpi_plugin_dataflows_dataflows`
               WHERE `is_deleted` = '0'
               $limit";

         $result = $DB->query($q);
         $nb     = $DB->result($result,0,0);

         echo "<div class='firstbloc'>";


         if (Session::haveRight('plugin_dataflows', READ)
             && ($nb > count($used))) {
            echo "<form name='dataflow_form$rand' id='dataflow_form$rand' method='post'
                   action='".Toolbox::getItemTypeFormURL('PluginDataflowsDataflow')."'>";
            echo "<table class='tab_cadre_fixe'>";
            echo "<tr class='tab_bg_1'>";
            echo "<td colspan='4' class='center'>";
            echo "<input type='hidden' name='entities_id' value='$entity'>";
            echo "<input type='hidden' name='is_recursive' value='$is_recursive'>";
            echo "<input type='hidden' name='itemtype' value='".$item->getType()."'>";
            echo "<input type='hidden' name='items_id' value='$ID'>";
            if ($item->getType() == 'Ticket') {
               echo "<input type='hidden' name='tickets_id' value='$ID'>";
            }
            
            PluginDataflowsDataflow::dropdownDataflow(array('entity' => $entities ,
                                                     'used'   => $used));

            echo "</td><td class='center' width='20%'>";
            echo "<input type='submit' name='additem' value=\"".
                     _sx('button', 'Associate a dataflow', 'dataflows')."\" class='submit'>";
            echo "</td>";
            echo "</tr>";
            echo "</table>";
            Html::closeForm();
         }

         echo "</div>";
      }

      echo "<div class='spaced'>";
      if ($canedit && $number && ($withtemplate < 2)) {
         Html::openMassiveActionsForm('mass'.__CLASS__.$rand);
         $massiveactionparams = array('num_displayed'  => $number);
         Html::showMassiveActions($massiveactionparams);
      }
      echo "<table class='tab_cadre_fixe'>";

      echo "<tr>";
      if ($canedit && $number && ($withtemplate < 2)) {
         echo "<th width='10'>".Html::getCheckAllAsCheckbox('mass'.__CLASS__.$rand)."</th>";
      }
      echo "<th>".__('Name')."</th>";
      if (Session::isMultiEntitiesMode()) {
         echo "<th>".__('Entity')."</th>";
      }
      echo "<th>".PluginDataflowsServerType::getTypeName(1)."</th>";
      echo "<th>".PluginDataflowsDataflowCategory::getTypeName(1)."</th>";
      echo "<th>".__('Supplier')."</th>";
      echo "<th>".__('Editor', 'dataflows')."</th>";
      echo "</tr>";
      $used = array();

      if ($number) {

         Session::initNavigateListItems('PluginDataflowsDataflow',
                           //TRANS : %1$s is the itemtype name,
                           //        %2$s is the name of the item (used for headings of a list)
                                        sprintf(__('%1$s = %2$s'),
                                                $item->getTypeName(1), $item->getName()));


         foreach  ($dataflows as $data) {
            $dataflowID        = $data["id"];
            $link             = NOT_AVAILABLE;

            if ($dataflow->getFromDB($dataflowID)) {
               $link         = $dataflow->getLink();
            }

            Session::addToNavigateListItems('PluginDataflowsDataflow', $dataflowID);

            $used[$dataflowID]   = $dataflowID;
            $assocID             = $data["assocID"];

            echo "<tr class='tab_bg_1".($data["is_deleted"]?"_2":"")."'>";
            if ($canedit && ($withtemplate < 2)) {
               echo "<td width='10'>";
               Html::showMassiveActionCheckBox(__CLASS__, $data["assocID"]);
               echo "</td>";
            }
            echo "<td class='center'>$link</td>";
            if (Session::isMultiEntitiesMode()) {
               echo "<td class='center'>".Dropdown::getDropdownName("glpi_entities", $data['entities_id']).
                    "</td>";
            }
            echo "<td>".Dropdown::getDropdownName("glpi_plugin_dataflows_servertypes",$data["plugin_dataflows_servertypes_id"])."</td>";
            echo "<td>".Dropdown::getDropdownName("glpi_plugin_dataflows_dataflowtypes",$data["plugin_dataflows_dataflowtypes_id"])."</td>";
            echo "<td>".Dropdown::getDropdownName("glpi_manufacturers",$data["manufacturers_id"])."</td>";
            echo "<td>";
            echo "<a href=\"".$CFG_GLPI["root_doc"]."/front/supplier.form.php?id=".$data["suppliers_id"]."\">";
            echo Dropdown::getDropdownName("glpi_suppliers",$data["suppliers_id"]);
            if ($_SESSION["glpiis_ids_visible"] == 1 )
               echo " (".$data["suppliers_id"].")";
            echo "</a></td>";
            echo "</tr>";
            $i++;
         }
      }


      echo "</table>";
      if ($canedit && $number && ($withtemplate < 2)) {
         $massiveactionparams['ontop'] = false;
         Html::showMassiveActions($massiveactionparams);
         Html::closeForm();
      }
      echo "</div>";
   }
}

?>