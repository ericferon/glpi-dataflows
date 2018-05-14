<?php
/*
 * @version $Id: HEADER 15930 2011-10-30 15:47:55Z tsmr $
 -------------------------------------------------------------------------
 dataflows plugin for GLPI
 Copyright (C) 2009-2016 by the dataflows Development Team.

 https://github.com/InfotelGLPI/dataflows
 -------------------------------------------------------------------------

 LICENSE
      
 This file is part of dataflows.

 dataflows is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 dataflows is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with dataflows. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 */

include ('../../../inc/includes.php');

$dropdown = new PluginDataflowsType();
include (GLPI_ROOT . "/front/dropdown.common.php");

?>
