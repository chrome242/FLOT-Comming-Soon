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
// Small Table Test - the method should pull from the SQL and then it should //
// add the last line automatically. If a post variable exist for the table //
// then the post variable should be used rather then the SQL source //
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

// Panel Table Test
$test_pantab_trial = array( array("food_id" => 1, // id
                                  "food_name" => "Grilled Asparagus (V)",  //plain
                                  "food_type" => array(1 => "Appetizer", 2 => "Tapas", 3 => "Full Plate"), //select
                                  "food_price" => "6.59", // number
                                  "edit" => "Edit",  // button
                                  "newrow" => "newrow", // number
                                  "spacer" => "",  // plain
                                  "food_desc" => "Asparagus is grilled with a little oil, salt, and pepper
                                  for a simple summer side dish... The special thing about this recipe is
                                  that it's so simple. Fresh asparagus with a little oil, salt, and pepper
                                  is cooked quickly over high heat on the grill. Enjoy the natural flavor
                                  of your veggies.", // text area
                                  ),
                           array("food_id" => "+", // id
                                  "food_name" => "",  //plain
                                  "food_type" => "", //select
                                  "food_price" => "", // number
                                  "edit" => "Add",  // button

                                  ));

$test_active = array(1);
// End Testing files.




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
                        "Edit" => array("add" => "button, large")  // button
                        );
//***************************************************************************//


//******************** Open The Page & Display Menu Bar *********************//
$title = "Manage Dishes";
$section = ADMIN."Food/";
include(SCAFFOLDING."head.php");
echo menubar($permissions, $section, $root);
//***************************************************************************//


//***************** Final Variable Processing & Cleaning *******************//
// Fututre home of SQL & $_POST processing methods
$processed_food_cells = $test_food_trial;
$processed_food_settings = $test_food_setti;
$processed_dish_cells = $test_pantab_trial;
$processed_active_rows = $test_active;
//***************************************************************************//


//********************************* Content *********************************//
// Plate Type Display and Editing Panel //
$plates = new SmallTable("foodType", $processed_food_cells, $processed_food_settings, 4);
$platesPanel = new Panel("Plate Types", $plates);
$platesPanel->addButton();

// Display The Panel //
echo $platesPanel;


// Dish Display and Editing Panel //
$dishes = new PanelTable("food", $processed_dish_cells,
                         $dishes_display, $dishes_edit,
                         $processed_active_rows);
$dishes->setCellClass("food_name", "col-xs-3");
$dishes->setCellClass("food_type", "col-xs-3");
$dishes->setCellClass("food_price", "col-xs-3");

$dishes->addCellButton("food_desc", "drop", "Drop", "large");
$dishesPanel = new Panel("Dishes", $dishes);
$dishesPanel->addButton();

// Display The Panel //
echo $dishesPanel;
//***************************************************************************//


//******************************** Footer ***********************************//
include(SCAFFOLDING_ADMIN."footer.php");
//***************************************************************************//

 

