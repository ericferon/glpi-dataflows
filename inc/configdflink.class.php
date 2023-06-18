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

class PluginDataflowsConfigdfLink extends CommonDropdown {

   static $rightname = "plugin_dataflows_configuration";
   var $can_be_translated  = true;
   
   static function getTypeName($nb=0) {

      return _n('Link class','Link classes',$nb);
   }
   public function getAdditionalFields() {
      return [
            [
                  'name'      => 'has_dropdown',
                  'type'      => 'bool',
                  'label'     => __('Has own dropdown', 'dataflows'),
                  'list'      => false
            ],
            [
                  'name'      => 'is_entity_limited',
                  'type'      => 'bool',
                  'label'     => __('Is limited by entity', 'dataflows'),
                  'list'      => false
            ],
            [
                  'name'      => 'is_tree_dropdown',
                  'type'      => 'bool',
                  'label'     => __('Is hierarchical dropdown', 'dataflows'),
                  'list'      => false
            ],
            [
                  'name'      => 'as_view_on',
                  'type'      => 'text',
                  'label'     => __('As view on table', 'dataflows'),
                  'list'      => false
            ],
            [
                  'name'      => 'viewlimit',
                  'type'      => 'text',
                  'label'     => __('View limited by WHERE clause', 'dataflows'),
                  'list'      => false
            ]
		];
   }
   function rawSearchOptions() {
	  $opt = CommonDropdown::rawSearchOptions();
//      $sopt['common'] = __("App structures", "dataflows");

      $opt[2400]['id']          = 2400;
      $opt[2400]['table']       = $this->getTable();
      $opt[2400]['field']       = 'has_dropdown';
      $opt[2400]['name']        = __('Has own dropdown', 'dataflows');
      $opt[2400]['datatype']    = 'boolean';

      $opt[2401]['id']          = 2401;
      $opt[2401]['table']       = $this->getTable();
      $opt[2401]['field']       = 'is_entity_limited';
      $opt[2401]['name']        = __('Is limited by entity', 'dataflows');
      $opt[2401]['datatype']    = 'boolean';

      $opt[2402]['id']          = 2402;
      $opt[2402]['table']       = $this->getTable();
      $opt[2402]['field']       = 'is_tree_dropdown';
      $opt[2402]['name']        = __('Is hierarchical dropdown', 'dataflows');
      $opt[2402]['datatype']    = 'boolean';

      $opt[2403]['id']          = 2403;
      $opt[2403]['table']       = $this->getTable();
      $opt[2403]['field']       = 'as_view_on';
      $opt[2403]['name']        = __('As view on table', 'dataflows');
      $opt[2403]['datatype']    = 'text';

      return $opt;
   }
}

?>
