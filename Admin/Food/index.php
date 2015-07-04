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


//******************* Header & Format Arrays For Dishes *********************//
$dish_type_rules = array("food_type_name" =>array(
                         "active" => ["editText", false],
                         "static" => ["editPlain", false],
                         "new" => ["addText", false])
                        );

$dishes_edit = array( "Id" => array("food_id" => "id"), // id
                      "Plate"=> array("food_name" => "text, value"), // plain
                      "Type" => array("food_type" => "select, 1"), //select
                      "Price" => array("food_price" =>
                                       "number, value, .01, 8"), // number
                      "Edit" => array("edit" => "button, large"),  // button
                      "newrow" => array("newrow" => "newrow"),
                      "spacer" => array("spacer" => "plain"),  // plain
                      "food_desc" =>array("food_desc" =>
                                          "textarea, value, 3, 4"), // text area
                      "addnew" => array("newrow" => "newrow"), // this and below for last record, to add new
                      "new_id" => array("new_id" => "plain"),
                      "s1" => array("s1" => "plain"),
                      "s2" => array("s2" => "plain"),
                      "s3" => array("s3" => "plain"),
                      "add" => array("add" => "button, large")
                    );

$dishes_display = array("Id" => array("food_id" => "id"), // id
                        "Plate"=> array("food_name" => "plain"), // plain
                        "Type" => array("food_type" => "plain"), //select
                        "Price" => array("food_price" => "plain"), // number
                        "Edit" => array("edit" => "button, large"),  // button
                        "addnew" => array("newrow" => "newrow"), // this and below for last record, to add new
                        "new_id" => array("new_id" => "plain"),
                        "s1" => array("s1" => "plain"),
                        "s2" => array("s2" => "plain"),
                        "s3" => array("s3" => "plain"),
                        "add" => array("add" => "button, large")
                        );
//***************************************************************************//


//******************** Open The Page & Display Menu Bar *********************//
$title = "Manage Dishes";
$section = ADMIN."Food/";
include(SCAFFOLDING."head.php");
echo menubar($permissions, $section, $root);
//***************************************************************************//


//****************** Process the plates tables and Data: ********************//
// include the file for processing the Dish Types
include(FOOD_PROCESSING);

// make the two arrays of contents match in format
//$platesSQL = $test_food_trial;
$platesSQL = sqlToSmallTable($mysqli, 'foodType');
$platesPOST = postToSmallTable($_POST, 'foodType');


// processTypes will do all the new SQL and array updates.
//echo "<pre>";
testUpdatedSelector("foodType", $_POST);
testSelector("foodType", $_POST, $platesSQL, $platesPOST);
processTypes("foodType", $mysqli, $_POST, $dish_type_rules, $platesSQL, $platesPOST);

// Now that any updates are tested for, do the final build of the object.
$platesMERGE = mergeTableArrays($platesSQL, $platesPOST);
$platesTYPE = setSmallTypes($platesMERGE, $platesPOST, $dish_type_rules, $addNew=true);


$processed_dish_cells = $test_pantab_trial;
$processed_active_rows = $test_active;
//***************************************************************************//


//********************************* Content *********************************//
// Plate Type Display and Editing Panel //
//$plates = new SmallTable("foodType", $processed_food_cells, $processed_food_settings, 4);
$plates = new SmallTable("foodType", $platesMERGE, $platesTYPE, 4);
$platesPanel = new Panel("Plate Types", $plates);
$platesPanel->addButton();

// Display The Panel //
echo $platesPanel;


// Dish Display and Editing Panel //
$dishes = new PanelTable("dishType", $processed_dish_cells,
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


//********************************TEST***************************************//

/* The array will have to be processed in the following way:
 * first, check for an add. If add exist, then 
 */
if(isset($_POST)){
  echo "Post contents:<br><pre>";
  var_dump($_POST);
  echo "</pre>";
  
}
//***************************************************************************//


//******************************** Footer ***********************************//
include(SCAFFOLDING_ADMIN."footer.php");
//***************************************************************************//

 

