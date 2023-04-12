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

include ("../../../inc/includes.php");

$configbp = new PluginDataflowsConfigdf();

if (isset($_POST["add"])) {

   $configbp->check(-1, CREATE,$_POST);
   $newID=$configbp->add($_POST);
   if ($_SESSION['glpibackcreated']) {
      Html::redirect($configbp->getFormURL()."?id=".$newID);
   }
   Html::back();

} else if (isset($_POST["delete"])) {

   $configbp->check($_POST['id'], DELETE);
   $configbp->delete($_POST);
   $configbp->redirectToList();

} else if (isset($_POST["restore"])) {

   $configbp->check($_POST['id'], PURGE);
   $configbp->restore($_POST);
   $configbp->redirectToList();

} else if (isset($_POST["purge"])) {

   $configbp->check($_POST['id'], PURGE);
   $configbp->delete($_POST,1);
   $configbp->redirectToList();

} else if (isset($_POST['update'])) {
   $configbp->check($_POST['id'], UPDATE);
   $configbp->update($_POST);
   Html::back();
} else {

   $configbp->checkGlobal(READ);

   Html::header(PluginDataflowsConfigdf::getTypeName(2), '', "configdf", "plugindataflowsconfigdfmenu");
   $configbp->display($_GET);

   Html::footer();
}
