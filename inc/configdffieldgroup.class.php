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

class PluginDataflowsConfigdfFieldgroup extends CommonDropdown {

   static $rightname = "plugin_archibp";
   var $can_be_translated  = true;
   
   static function getTypeName($nb=0) {

      return _n('Field group','Field groups',$nb);
   }
   
   public function getAdditionalFields() {
      return [
            [
                  'name'      => 'sortorder',
                  'type'      => 'text',
                  'label'     => __('Sort order', 'archibp'),
                  'list'      => false
            ],
            [
                  'name'      => 'is_visible',
                  'type'      => 'bool',
                  'label'     => __('Is visible on opening', 'archibp'),
                  'list'      => false
            ]
		];
   }
   
   function rawSearchOptions() {
	  $opt = CommonDropdown::rawSearchOptions();
//      $sopt['common'] = __("App structures", "archibp");

      $opt[2400]['id']          = 2400;
      $opt[2400]['table']       = $this->getTable();
      $opt[2400]['field']       = 'sortorder';
      $opt[2400]['name']        = __('Sort order', 'archibp');
      $opt[2400]['datatype']    = 'text';

      $opt[2401]['id']          = 2401;
      $opt[2401]['table']       = $this->getTable();
      $opt[2401]['field']       = 'is_visible';
      $opt[2401]['name']        = __('Is visible on opening', 'archibp');
      $opt[2401]['datatype']    = 'bool';

      return $opt;
   }
}

?>
