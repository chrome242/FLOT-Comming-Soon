<?php

// The general files to be included for the Admin Section of the site //
// General Page Componets
include_once(SCAFFOLDING_ADMIN."menubars.php"); // menubars
include_once(SCAFFOLDING_ADMIN."panel/class.panel.php"); // panel wrapper
include_once(SCAFFOLDING_ADMIN."table/table.php"); // table
include_once(SCAFFOLDING_ADMIN."list/list.php"); // list

// Database interfaces

// Security


// Section Settings:
$root = ADMIN;

// definitions

define("PLATE_HANDLER", PROCESSING_ADMIN."plates.handler.php");
define("BREWS_HANDLER", PROCESSING_ADMIN."drinks.handler.php");
define("WINES_HANDLER", PROCESSING_ADMIN."wine.handler.php");
define("SIZE_HANDLER", PROCESSING_ADMIN."size.handler.php");
define("DISH_HANDLER", PROCESSING_ADMIN."dish.handler.php");

// Test files
include_once(SCAFFOLDING_ADMIN."testing/test.data.php");