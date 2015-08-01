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

  
define("PROCESSING_HANDLERS", PROCESSING_ADMIN."handlers/"); // for the handlers
define("PROCESSING_FUNCTIONS", PROCESSING_ADMIN."functions/"); // functions
define("PLATE_HANDLER", PROCESSING_HANDLERS."plates.handler.php"); // Plate Sizes
define("BREWS_HANDLER", PROCESSING_HANDLERS."drinks.handler.php"); // Beer Types
define("WINES_HANDLER", PROCESSING_HANDLERS."wine.handler.php"); // Wine Types
define("SIZE_HANDLER", PROCESSING_HANDLERS."size.handler.php"); // Drink Sizes
define("DISH_HANDLER", PROCESSING_HANDLERS."dish.handler.php"); // Food Items
define("BREWERY_HANDLER", PROCESSING_HANDLERS."brewery.handler.php"); // Brewery List
define("WINERY_HANDLER", PROCESSING_HANDLERS."winery.handler.php"); // Winery List
define("WINE_HANDLER", PROCESSING_HANDLERS."wine.inventory.handler.php"); // Wine Glasses
define("BEER_HANDLER", PROCESSING_HANDLERS."beer.inventory.handler.php"); // Beer Glasses
define("WINE_BAR", PROCESSING_HANDLERS."wine.bar.handler.php"); // The Bar view of wines
define("BEER_BAR", PROCESSING_HANDLERS."beer.bar.handler.php");

// Test files
include_once(SCAFFOLDING_ADMIN."testing/test.data.php");