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

// Page variables



//********************************TEST***************************************//
// Temp testing permissions //
$permissions = array("inventory" => "1",
                     "drinks" =>  "1",
                     "extras" => "1",
                     "food" => 1,
                     "add_user" => "1",
                     "edit_user" => 1);
// End testing permissions //

// Content Testing //
// Small Table Test - the method should pull from the SQL and then it should //
// add the last line automatically. If a post variable exist for the table //
// then the post variable should be used rather then the SQL source //
$test_drink_trial = array(1 => array("drink_type_name" => "Amber Ale",
                                    "drink_type_desc" => "Amber Ale Desc."),
                         2 => array("drink_type_name" => "Bitter",
                                    "drink_type_desc" => "Bitter Ale Desc."),
                         3 => array("drink_type_name" => "Blonde Ale",
                                    "drink_type_desc" => "Blonde Ale Desc."),
                         4 => array("drink_type_name" => "Block",
                                    "drink_type_desc" => "Block Ale Desc."),
                         19 => array("drink_type_name" => "")); 


$test_drink_setti = array(1 => array("drink_type_name" => ["editPlain", false],
                                    "drink_type_desc" => ["textArea, value, 3, 4", true]),
                         2 => array("drink_type_name" => ["editPlain", false],
                                    "drink_type_desc" => ["textArea, value, 3, 4", true]),
                         3 => array("drink_type_name" => ["editPlain", false],
                                    "drink_type_desc" => ["textArea, value, 3, 4", true]),
                         4 => array("drink_type_name" => ["editPlain", false],
                                    "drink_type_desc" => ["textArea, value, 3, 4", true]),
                         19 => array("drink_type_name" => ["addText", false]));


$test_wine_list = array(1 => "Pinor Noir", 2 => "Tokay", 3 => "Chardonnary",
                        4 => "Riesling", 5 => "Merlot", 6 => "Tugboat Red",
                        7 => "Tugboat White", 8 => "Bordeaux", 9 =>'');

$test_wine_spec = array(4 => "edit", 9 => "new");

$test_size_list = array(1=> "Sample", 2 => "12oz.", 3 => "Pint",
                        4 => "Growler", 5 => '');

$test_size_spec = array(5 => "new");

//***************************************************************************//




//******************* Header & Format Arrays For Dishes *********************//
$dishes_edit = array( "Id" => array("food_id" => "id"), // id
                      "Plate"=> array("food_name" => "text, value"), // plain
                      "Type" => array("food_type" => "select, 1"), //select
                      "Price" => array("food_price" =>
                                       "number, value, .01, 8"), // number
                      "Edit" => array("edit" => "button, large"),  // button
                      "newrow" => array("newrow" => "newrow"), // number
                      "spacer" => array("spacer" => "plain"),  // plain
                      "food_desc" =>array("food_desc" =>
                                          "textarea, value, 3, 4") // text area
                      );

$dishes_display = array("Id" => array("food_id" => "id"), // id
                        "Plate"=> array("food_name" => "plain"), // plain
                        "Type" => array("food_type" => "plain"), //select
                        "Price" => array("food_price" => "plain"), // number
                        "Edit" => array("edit" => "button, large")  // button
                        );
//***************************************************************************//


//******************** Open The Page & Display Menu Bar *********************//
$title = "Manage Extras";
$section = ADMIN."Extras/";
include(SCAFFOLDING."head.php");
echo menubar($permissions, $section, $root);
//***************************************************************************//


//***************** Final Variable Processing & Cleaning *******************//
// Fututre home of SQL & $_POST processing methods
$processed_beer_cells = $test_drink_trial;
$processed_beer_settings = $test_drink_setti;

$processed_wines_list = $test_wine_list;
$processed_wine_speci = $test_wine_spec;

$processed_size_list = $test_size_list;
$processed_size_spec = $test_size_spec;

//***************************************************************************//


//********************************* Content *********************************//
// Beer Type Display and Editing Panel //
$beers = new SmallTable("drinkTypes", $processed_beer_cells, $processed_beer_settings, 4);
$beerPanel = new Panel("Varieties of Beer", $beers);
$beerPanel->addButton();

// Display The Panel //
echo $beerPanel;


// Wine Display and Editing Panel //
$wines = new ListView("wineTypes", $processed_wines_list, $special=$processed_wine_speci, $default='text');
$winePanel = new Panel("Wines", $wines, $size="half");

// Display The Panel
echo $winePanel;

// Drink Size Edit Panel //
$sizes = new ListView("wineTypes", $processed_size_list, $special=$processed_size_spec, $default='text');
$sizePanel = new Panel("Glasses, Jugs, &amp; Mugs", $sizes, $size="half");

// Display The Panel
echo $sizePanel;


// clearfix for right panel
echo '      <div class="clearfix visible-md-block"></div>';

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

 

