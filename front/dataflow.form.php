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

include ('../../../inc/includes.php');

if (!isset($_GET["id"])) $_GET["id"] = "";
if (!isset($_GET["withtemplate"])) $_GET["withtemplate"] = "";

$dataflow=new PluginDataflowsDataflow();
$dataflow_item=new PluginDataflowsDataflow_Item();
//$options = array();

if (isset($_POST["add"])) {

   $dataflow->check(-1, CREATE,$_POST);
   $newID=$dataflow->add($_POST);
   if ($_SESSION['glpibackcreated']) {
		Html::redirect($dataflow->getFormURL()."?id=".$newID);
   }
   Html::back();

} else if (isset($_POST["delete"])) {

   $dataflow->check($_POST['id'], DELETE);
   $dataflow->delete($_POST);
   $dataflow->redirectToList();

} else if (isset($_POST["restore"])) {

   $dataflow->check($_POST['id'], PURGE);
   $dataflow->restore($_POST);
   $dataflow->redirectToList();

} else if (isset($_POST["purge"])) {

   $dataflow->check($_POST['id'], PURGE);
   $dataflow->delete($_POST,1);
   $dataflow->redirectToList();

} else if (isset($_POST["update"])) {

   $dataflow->check($_POST['id'], UPDATE);
   $dataflow->update($_POST);
   Html::back();

} else if (isset($_POST["additem"])) {

   if (!empty($_POST['itemtype'])&&$_POST['items_id']>0) {
      $dataflow_item->check(-1, UPDATE, $_POST);
      $dataflow_item->addItem($_POST);
   }
   Html::back();

} else if (isset($_POST["deleteitem"])) {

   foreach ($_POST["item"] as $key => $val) {
         $input = array('id' => $key);
         if ($val==1) {
            $dataflow_item->check($key, UPDATE);
            $dataflow_item->delete($input);
         }
      }
   Html::back();

} else if (isset($_POST["deletedataflows"])) {

   $input = array('id' => $_POST["id"]);
   $dataflow_item->check($_POST["id"], UPDATE);
   $dataflow_item->delete($input);
   Html::back();

} else {

   $dataflow->checkGlobal(READ);

   $plugin = new Plugin();
   if ($plugin->isActivated("environment")) {
      Html::header(PluginDataflowsDataflow::getTypeName(2),
                     '',"assets","pluginenvironmentdisplay","dataflows");
   } else {
      Html::header(PluginDataflowsDataflow::getTypeName(2), '', "assets",
                   "plugindataflowsmenu");
   }
   $dataflow->display($_GET);

   Html::footer();
}

?>