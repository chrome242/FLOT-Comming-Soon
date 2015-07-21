
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

// TODO: make these buttons work: JS & or PHP
// Page variables

//******************* Header & Format Arrays For Beer Table *****************//

$sectionWrappers = array("beerManagement" => ["Beer Management", false],
                         "wineManagement" => ["Wine Management", false],
                         "breweryManagement" => ["Brewery Management", false],
                         "wineryManagement" => ["Winery Management", false]);

// jQuery hooks
$optionsBeer = array( "inhouse" => "In House",
                      "ondeck" => "On Deck",
                      "kicked" => "Kicked",
                      "all" => "All");

$optionsWine = array( "instock" => "In Stock",
                      "outofstock" => "Out Of Stock",
                      "WineAll" => "All");
//***************************************************************************//


// Table Headers

$beer_display = array("beer_offtap" => array("beer_offtap" => "time, private"),
                      "beer_ontap" => array("beer_ontap" => "time, private"),
                      "Id" => array("beer_id" => "id"),
                      "Brewery" => array("beer_brewery" => "plain"),
                      "Beer" => array("beer_name" => "plain"),
                      "Status" => array("beer_status" => "plain"),
                      "ABV" => array("beer_abv" => "plain"),
                      "Size" => array("beer_size" => "plain"),
                      "Price" => array("beer_price" => "plain"),
                      "Time on Tap" => array("process_time", "timestamp, beer_offtap, beer_ontap"),
                      "Edit" => array("edit" => "button, large"),
                      "newrow" => array("newrow" => "newrow"),
                      "new_id" => array("new_id" => "plain"),
                      "placeholder1" => array("placeholder1" => "plain"),
                      "placeholder2" => array("placeholder2" => "plain"),
                      "placeholder3" => array("placeholder3" => "plain"),
                      "placeholder4" => array("placeholder4" => "plain"),
                      "placeholder5" => array("placeholder5" => "plain"),
                      "placeholder6" => array("placeholder6" => "plain"),
                      "placeholder7" => array("placeholder7" => "plain"),
                      "add" => array("add" => "button, large")
                     );

$beer_edit = array( "beer_offtap" => array("beer_offtap" => "time, private"),
                    "beer_ontap" => array("beer_ontap" => "time, private"),
                    "Id" => array("beer_id" => "id"),
                    "Brewery" => array("beer_brewery" => "select"),
                    "Beer" => array("beer_name" => "text, value"),
                    "Status" => array("beer_status" => "select"),
                    "ABV" => array("beer_abv" => "number, value, .001"),
                    "Size" => array("beer_size" => "select"),
                    "Price" => array("beer_price" => "number, value, .01"),
                    "Time on Tap" => array("process_time", "timestamp, beer_offtap, beer_ontap"),
                    "Edit" => array("edit" => "button, large"),
                    "nextrow" => array('nextrow' => "newrow"),
                    "beer_type" => array("wine_type"=> "select"),
                    "beer_desc" => array("wine_desc" => "textarea, value, 3, 6"),
                    "drop" => array("drop" => "button, large"),
                    "newrow" => array("newrow" => "newrow"),
                    "new_id" => array("new_id" => "plain"),
                    "placeholder1" => array("placeholder1" => "plain"),
                    "placeholder2" => array("placeholder2" => "plain"),
                    "placeholder3" => array("placeholder3" => "plain"),
                    "placeholder4" => array("placeholder4" => "plain"),
                    "placeholder5" => array("placeholder5" => "plain"),
                    "placeholder6" => array("placeholder6" => "plain"),
                    "placeholder7" => array("placeholder7" => "plain"),
                    "add" => array("add" => "button, large")
                     );         




//***************************************************************************//


//******************** Open The Page & Display Menu Bar *********************//               
$title = "Manage Drinks";
$section = ADMIN."Drinks/";
include(SCAFFOLDING."head.php");
echo menubar($permissions, $section, $root);
echo sectionbar($sectionWrappers);

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
echo '      <div class="collapse" id="beerManagement"> <!-- Beers -->';
echo sortbar($optionsBeer, 'all');
// TODO: make handler for beer table
echo '      </div>';


// Wine Management Drop
echo '      <div class="collapse" id="wineManagement"> <!-- Wines -->';
echo sortbar($optionsWine, 'WineAll');
$wines = new Table("wines", $winesPROCESSED,
                         $wines_display, $wines_edit,
                         $winesTYPE);
$wines->setCellClass("winery_name", "col-xs-2");
$wines->setCellClass("wine_name", "col-xs-2");
$wines->setCellClass("wine_yeae", "col-xs-2");

//add final button
$wines->addCellButton("wine_desc", "drop", "Drop", "large");
echo $wines;
echo '      </div>';

// Brewery Management Drop
echo '      <div class="collapse" id="breweryManagement"> <!-- Breweries -->';
$brewery = new Table("breweries", $breweryPROCESSED,
                         $brewery_display, $brewery_edit,
                         $breweryTYPE);

echo $brewery;
echo '      </div>';

// Winery Managment Drop
echo '      <div class="collapse" id="wineryManagement"> <!-- Wineries -->';
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

 

