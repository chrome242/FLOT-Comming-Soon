
<?php

//****************** Configuration & Inclusions *****************************//
include("../../include/config.php");
include(SCAFFOLDING_ADMIN."admin.include.php"); // centeralized admin includes
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


//****************** Process the wine tables and Data: **********************//
include(BEER_HANDLER);

//***************************************************************************//


//****************** Process the wine tables and Data: **********************//
include(WINE_HANDLER);

//***************************************************************************//


//***************** Process the brewery tables and Data: ********************//
include(BREWERY_HANDLER);

//***************************************************************************//


//**************** Process the wineries tables and Data: ********************//
include(WINERY_HANDLER);

//***************************************************************************//


//********************************* Content *********************************//

// Beer Management Drop
echo '      <div class="collapse'.$inBeers.'" id="beerManagement"> <!-- Beers -->';
echo sortbar($optionsBeer, 'all'); // Beer Sort Bar
// TODO: make handler for beer table
echo '      </div>';


// Wine Management Drop
echo '      <div class="collapse'.$inWines.'" id="wineManagement"> <!-- Wines -->';
echo sortbar($optionsWine, 'WineAll');  // Wines Sort Bar

// Make the table, echo it out
$wines = new Table("wines", $winesPROCESSED,
                         $wines_display, $wines_edit,
                         $winesTYPE);
$wines->setCellClass("winery_name", "col-xs-2");
$wines->setCellClass("wine_name", "col-xs-2");
$wines->setCellClass("wine_year", "col-xs-2");
$wines->addCellButton("wine_desc", "drop", "Drop", "large");//add final button
echo $wines;

echo '      </div>';

// Brewery Management Drop
echo '      <div class="collapse'.$inBreweries.'" id="breweryManagement"> <!-- Breweries -->';

// Make the table, echo it out
$brewery = new Table("breweries", $breweryPROCESSED,
                         $brewery_display, $brewery_edit,
                         $breweryTYPE);
echo $brewery;

echo '      </div>';

// Winery Managment Drop
echo '      <div class="collapse'.$inWineries.'" id="wineryManagement"> <!-- Wineries -->';

// Make the table, echo it out
$winery = new Table("wineries", $wineryPROCESSED,
                         $winery_display, $winery_edit,
                         $wineryTYPE);
echo $winery;

echo '      </div>';
//***************************************************************************//


//********************************TEST***************************************//

/* The array will have to be processed in the following way:
 * first, check for an add. If add exist, then 
 */
if(isset($_POST)){
  echo "Post contents:<br><pre>";
  var_dump($_POST);
  echo "</pre>";
  
}


//******************************** Footer ***********************************//
include(SCAFFOLDING_ADMIN."footer.php");
//***************************************************************************//

 

