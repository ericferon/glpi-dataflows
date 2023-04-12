<?php
/*
 -------------------------------------------------------------------------
 Dataflows plugin for GLPI
 Copyright (C) 2020-2022 by Eric Feron.
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
class PluginDataflowsConfigdfMenu extends CommonGLPI {
   static $rightname = 'plugin_dataflows';

   static function getMenuName() {
      return _n('Dataflows configuration', 'Dataflows configuration', 2, 'dataflows');
   }

   static function getMenuContent() {
      global $CFG_GLPI;

		$menu                                           = [];
		$menu['title']                                  = self::getMenuName();
		$menu['page']                                   = "/".Plugin::getWebDir('dataflows', false)."/front/configdf.php";
		$menu['links']['search']                        = PluginDataflowsConfigdf::getSearchURL(false);
		if (PluginDataflowsConfigdf::canCreate()) {
			$menu['links']['add']                        = PluginDataflowsConfigdf::getFormURL(false);
		}
		$menu['icon'] = self::getIcon();

		return $menu;
	}

	static function getIcon() {
		return "fas fa-cog";
	}

   static function removeRightsFromSession() {
      if (isset($_SESSION['glpimenu']['configdf']['types']['PluginDataflowsConfigdfMenu'])) {
         unset($_SESSION['glpimenu']['configdf']['types']['PluginDataflowsConfigdfMenu']); 
      }
      if (isset($_SESSION['glpimenu']['configdf']['content']['pluginarchibpconfigbpmenu'])) {
         unset($_SESSION['glpimenu']['configdf']['content']['pluginarchibpconfigbpmenu']); 
      }
   }
}
