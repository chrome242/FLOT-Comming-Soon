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

define("PLATE_HANDLER", PROCESSING_ADMIN."handlers/plates.handler.php"); // Plate Sizes
define("BREWS_HANDLER", PROCESSING_ADMIN."handlers/drinks.handler.php"); // Beer Types
define("WINES_HANDLER", PROCESSING_ADMIN."handlers/wine.handler.php"); // Wine Types
define("SIZE_HANDLER", PROCESSING_ADMIN."handlers/size.handler.php"); // Drink Sizes
define("DISH_HANDLER", PROCESSING_ADMIN."handlers/dish.handler.php"); // Food Items
define("BREWERY_HANDLER", PROCESSING_ADMIN."handlers/brewery.handler.php"); // Brewery List
define("WINERY_HANDLER", PROCESSING_ADMIN."handlers/winery.handler.php"); // Winery List
define("WINE_HANDLER", PROCESSING_ADMIN."handlers/wine.inventory.handler.php"); // Wine Glasses
define("BEER_HANDLER", PROCESSING_ADMIN."handlers/beer.inventory.handler.php"); // Beer Glasses

// Test files
include_once(SCAFFOLDING_ADMIN."testing/test.data.php");