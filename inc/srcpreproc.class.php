<?php
/*
 -------------------------------------------------------------------------
 Dataflows plugin for GLPI
<<<<<<< HEAD
 Copyright (C) 2009-2018 by Eric Feron.
=======
 Copyright C 2009-2018 by Eric Feron.
>>>>>>> 1b4f030a8369c661491e054aea26383b6fd29638
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


if (!defined('GLPI_ROOT')) {
	die("Sorry. You can't access directly to this file");
}

class PluginDataflowsSrcPreproc extends CommonDropdown {

   static $rightname = "plugin_dataflows";
   var $can_be_translated  = true;
   
   static function getTypeName($nb=0) {

      return _n('Transfer Preprocessing','Transfer Preprocessings',$nb);
   }
}

?>