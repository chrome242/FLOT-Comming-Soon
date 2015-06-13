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

define("FOOD_PROCESSING", PROCESSING_ADMIN."plates.process.php");

// Test files
include_once(SCAFFOLDING_ADMIN."testing/test.data.php");