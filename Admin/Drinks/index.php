
<?php

//****************** Configuration & Inclusions *****************************//
$pageJavaScript = 'drinks';
include_once("../../include/config.php");
include_once(SCAFFOLDING_ADMIN."admin.include.php"); // centeralized admin includes
//***************************************************************************//

// TODO: Add a test login to redirect function here
// if(!secureCheckLogin($_COOKIE)){header:Admin Login}
  // check to make sure the user is logged in
    // if logged in, check to make sure the token is valid
    // if not logged in, send to the Admin login page
  // if no admin access token, send to Main site

// TODO: Process the user's permission array from the session
// $permissions = $_COOKIE["admin_permissions"];


//******************* Header & Format Arrays For Beer Table *****************//

$active = getActivePanels($_POST); // see if any panels are open.

// check to set the panel classes
if($active == "beers"){$inBeers = " in";} else {$inBeers = '';}
if($active == "wines"){$inWines = " in";} else {$inWines = '';}
if($active == "breweries"){$inBreweries = " in";} else {$inBreweries = '';}
if($active == "wineries"){$inWineries = " in";} else {$inWineries = '';}

$sectionWrappers = array("beerManagement" => ["Beer Management", false, "beers"],
                         "wineManagement" => ["Wine Management", false, "wines"],
                         "breweryManagement" => ["Brewery Management", false, "breweries"],
                         "wineryManagement" => ["Winery Management", false, "wineries"]);
$sectionWrappers = activatePanel($sectionWrappers, $active);

// TODO: make these buttons work: JS because we don't want to lose data.
// jQuery hooks
$optionsBeer = array( "inhouse" => "In House",
                      "ondeck" => "On Deck",
                      "kicked" => "Kicked",
                      "all" => "All");

$optionsWine = array( "instock" => "In Stock",
                      "outofstock" => "Out Of Stock",
                      "WineAll" => "All");
//***************************************************************************//


//******************** Open The Page & Display Menu Bar *********************//               
$title = "Manage Drinks";
$section = ADMIN."Drinks/";
include(SCAFFOLDING."head.php");
echo menubar($permissions, $section, $root);
echo sectionbar($sectionWrappers);

//***************************************************************************//


//********************************* Content *********************************//

// Beer Management Drop
echo '      <div class="collapse'.$inBeers.'" id="beerManagement"  token="'.rand(1000, 9999).'"> <!-- Beers -->';
echo sortbar($optionsBeer, 'all'); // Beer Sort Bar

include(BEER_HANDLER);

echo '      </div>';


// Wine Management Drop
echo '      <div class="collapse'.$inWines.'" id="wineManagement"  token="'.rand(1000, 9999).'"> <!-- Wines -->';
echo sortbar($optionsWine, 'WineAll');  // Wines Sort Bar

include(WINE_HANDLER);

echo '      </div>';

// Brewery Management Drop
echo '      <div class="collapse'.$inBreweries.'" id="breweryManagement"  token="'.rand(1000, 9999).'"> <!-- Breweries -->';

include(BREWERY_HANDLER);

echo '      </div>';

// Winery Managment Drop
echo '      <div class="collapse'.$inWineries.'" id="wineryManagement"  token="'.rand(1000, 9999).'"> <!-- Wineries -->';

include(WINERY_HANDLER);

echo '      </div>';
//***************************************************************************//


//******************************** Footer ***********************************//
include(SCAFFOLDING_ADMIN."footer.php");
//***************************************************************************//

 

