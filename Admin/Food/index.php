<?php

include("../../include/config.php");
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

// TEST VARIABLES //
// Temp testing permissions //
$permissions = array("inventory" => "1",
                     "drinks" =>  "1",
                     "extras" => "1",
                     "food" => 1,
                     "add_user" => "1",
                     "edit_user" => 1);
// End testing permissions //
// Content Testing //
$test_food_trial = array(1 => array("food_type_name" => "Appetizer"),
                         2 => array("food_type_name" => "Tapas"),
                         3 => array("food_type_name" => "Full Plate"),
                         4 => array("food_type_name" => "Dessert"),
                         5 => array("food_type_name" => "")); 


$test_food_setti = array(1 => array("food_type_name" => ["editPlain", false]),
                         2 => array("food_type_name" => ["editPlain", false]),
                         3 => array("food_type_name" => ["editText", false]),
                         4 => array("food_type_name" => ["editPlain", false]),
                         5 => array("food_type_name" => ["addText", false])); 
              
$title = "Manage Dishes";
$section = ADMIN."Food/";


// open the page
include(SCAFFOLDING."head.php");

 // Menu Bar
echo menubar($permissions, $section, $root);

// All pages in the admin section will post to themselves. Check to see if
// Anything relevant to the page is in the $_POST() array and if so, process
// it here. If not, then process it 
$processed_food_cells = $test_food_trial;
$processed_food_settings = $test_food_setti;

// make the small table for plate types
$plates = new SmallTable("foodType", $processed_food_cells, $processed_food_settings, 4);
$platesPanel = new Panel("Plate Types", $plates);
$platesPanel->addButton();

echo $platesPanel;
// make the panel table for indivudual dishes



// close the page
include(SCAFFOLDING_ADMIN."footer.php");


 

