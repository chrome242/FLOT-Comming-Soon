
<?php

include("../include/config.php");
include(SCAFFOLDING_ADMIN."admin.include.php"); // centeralized admin includes

// TODO: Add a test login to redirect function here
// if(!secureCheckLogin($_COOKIE)){header:Admin Login}
  // check to make sure the user is logged in
    // if logged in, check to make sure the token is valid
    // if not logged in, send to the Admin login page
  // if no admin access token, send to Main site

// TODO: Process the user's permission array from the session
// $permissions = $_COOKIE["admin_permissions"];

// Page variables

                 
$title = "Manage Drinks";
$section = ADMIN."Drinks/";

$sectionWrappers = array("beerManagement" => ["Beer Management", false],
                         "wineManagement" => ["Wine Management", false],
                         "breweryManagement" => ["Brewery Management", false],
                         "wineryManagement" => ["Winery Management", false]);

// variables for sections:
$optionsBeer = array("inhouse" => "In House",
                 "ondeck" => "On Deck",
                 "kicked" => "Kicked",
                 "all" => "All");

$optionsWine = array("instock" => "In Stock",
                 "outofstock" => "Out Of Stock",
                 "WineAll" => "All");

// open the page
include(SCAFFOLDING."head.php");

 // Menu Bar
echo menubar($permissions, $section, $root);

// section bar
echo sectionbar($sectionWrappers);

// beer management wrapper
echo '      <div class="collapse" id="beerManagement"> <!-- Beers -->';
echo sortbar($optionsBeer, 'all');
// TODO: make handler for beer table
echo '      </div>';


// wine management wrapper
echo '      <div class="collapse" id="wineManagement"> <!-- Wines -->';
echo sortbar($optionsWine, 'WineAll');
// TODO: make handler for wine table
echo '      </div>';

// brewery management wrapper
echo '      <div class="collapse" id="breweryManagement"> <!-- Breweries -->';
// TODO: make handler for brewery table
echo '      </div>';

// winery management wrapper
echo '      <div class="collapse" id="wineryManagement"> <!-- Breweries -->';
// TODO: make handler for brewery table
echo '      </div>';


// close the page
include(SCAFFOLDING_ADMIN."footer.php");