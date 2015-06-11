
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


// Table Headers

$wine_display =  array( "Id" => array("wine_id" => "id"),
                        "Winery" => array("wine_winery" => 'plain'),
                        "Wine" => array('wine_name' => 'plain'),
                        "Year" => array('wine_year' => 'plain'),
                        "Price" => array('wine_price' => 'plain'),
                        "Bottle Price" => array('wine_bottle' => 'plain'),
                        "In Stock" => array("wine_instock" => 'checkbox, off'),
                        "Edit" => array("edit" => 'button, large'),
                        "newrow" => array("newrow" => "newrow"),
                        "new_id" => array("new_id" => "plain"),
                        "placeholder1" => array("placeholder1" => "plain"),
                        "placeholder2" => array("placeholder2" => "plain"),
                        "placeholder3" => array("placeholder3" => "plain"),
                        "placeholder4" => array("placeholder4" => "plain"),
                        "placeholder5" => array("placeholder5" => "plain"),
                        "placeholder6" => array("placeholder6" => "plain"),
                        "add" => array("add" => "button, large")
                      );

$wine_edit   =  array("Id" => array("wine_id" => "id"),
                      "Winery" => array("wine_winery" => 'text, value'),
                      "Wine" => array('wine_name' => 'text, value'),
                      "Year" => array('wine_year' => 'number, value, 1'),
                      "Price" => array('wine_price' => 'number, value, .01'),
                      "Bottle Price" => array('wine_bottle' => 'number, value, .01'),
                      "In Stock" => array("wine_instock" => 'checkbox'),
                      "Edit" => array("edit" => 'button, large'),
                      "nextrow" => array("newrow" => "newrow"),
                      "wine_type" => array("wine_type"=> "select"),
                      "wine_desc" => array("wine_desc" => "textarea, value, 3, 5"),
                      "drop" => array("drop" => "buton, large"),
                      "newrow" => array("newrow" => "newrow"),
                      "new_id" => array("new_id" => "plain"),
                      "placeholder1" => array("placeholder1" => "plain"),
                      "placeholder2" => array("placeholder2" => "plain"),
                      "placeholder3" => array("placeholder3" => "plain"),
                      "placeholder4" => array("placeholder4" => "plain"),
                      "placeholder5" => array("placeholder5" => "plain"),
                      "placeholder6" => array("placeholder6" => "plain"),
                      "add" => array("add" => "button, large")
                      );
                       

$brewery_display = array("Id" => array("brewery_id" => 'id'),
                         "Name" => array("brewery_name" => 'plain'),
                         "City" => array("brewery_city" => 'plain'),
                         "State" => array("brewery_state" => 'plain'),
                         "Website" => array("brewery_site" => 'url'),
                         "Edit" => array("edit" => "button, large"),
                         "newrow" => array("newrow" => "newrow"),
                         "new_id" => array("new_id" => "plain"),
                         "placeholder1" => array("placeholder1" => "plain"),
                         "placeholder2" => array("placeholder2" => "plain"),
                         "placeholder3" => array("placeholder3" => "plain"),
                         "placeholder4" => array("placeholder4" => "plain"),
                         "add" => array("add" => "button, large")
                   );

$brewery_edit  = array( "Id" => array("brewery_id" => 'id'),
                        "Name" => array("brewery_name" => 'text, value'),
                        "City" => array("brewery_city" => 'text, value'),
                        "State" => array("brewery_state" => 'text, value'),
                        "Website" => array("brewery_site" => 'text, value'),
                        "Edit" => array("edit" => "button, large"),
                        "contine" => array("continue" => "newrow"),
                        "brewery_desc" => array("brewery_desc" => "textarea, value, 3, 4"),
                        "drop" => array("drop" => "button, large"),
                        "newrow" => array("newrow" => "newrow"),
                        "new_id" => array("new_id" => "plain"),
                        "placeholder1" => array("placeholder1" => "plain"),
                        "placeholder2" => array("placeholder2" => "plain"),
                        "placeholder3" => array("placeholder3" => "plain"),
                        "placeholder4" => array("placeholder4" => "plain"),
                        "add" => array("add" => "button, large")
                   );

$winery_display = array("Id" => array("winery_id" => 'id'),
                         "Name" => array("winery_name" => 'plain'),
                         "Region" => array("winery_region" => 'plain'),
                         "State" => array("winery_state" => 'plain'),
                         "Website" => array("winery_site" => 'url'),
                         "Edit" => array("edit" => "button, large"),
                         "newrow" => array("newrow" => "newrow"),
                         "new_id" => array("new_id" => "plain"),
                         "placeholder1" => array("placeholder1" => "plain"),
                         "placeholder2" => array("placeholder2" => "plain"),
                         "placeholder3" => array("placeholder3" => "plain"),
                         "placeholder4" => array("placeholder4" => "plain"),
                         "add" => array("add" => "button, large")
                   );

$winery_edit  = array( "Id" => array("winery_id" => 'id'),
                        "Name" => array("winery_name" => 'text, value'),
                        "Region" => array("winery_region" => 'text, value'),
                        "State" => array("winery_state" => 'text, value'),
                        "Website" => array("winery_site" => 'text, value'),
                        "Edit" => array("edit" => "button, large"),
                        "contine" => array("continue" => "newrow"),
                        "winery_desc" => array("winery_desc" => "textarea, value, 3, 4"),
                        "drop" => array("drop" => "button, large"),
                        "newrow" => array("newrow" => "newrow"),
                        "new_id" => array("new_id" => "plain"),
                        "placeholder1" => array("placeholder1" => "plain"),
                        "placeholder2" => array("placeholder2" => "plain"),
                        "placeholder3" => array("placeholder3" => "plain"),
                        "placeholder4" => array("placeholder4" => "plain"),
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


//***************** Final Variable Processing & Cleaning *******************//
// Fututre home of SQL & $_POST processing methods

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
// TODO: make handler for wine table
echo '      </div>';

// Brewery Management Drop
echo '      <div class="collapse" id="breweryManagement"> <!-- Breweries -->';
// TODO: make handler for brewery table
echo '      </div>';

// Winery Managment Drop
echo '      <div class="collapse" id="wineryManagement"> <!-- Breweries -->';
// TODO: make handler for brewery table
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

 

