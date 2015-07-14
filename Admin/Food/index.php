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


//******************** Open The Page & Display Menu Bar *********************//
$title = "Manage Dishes";
$section = ADMIN."Food/";
include(SCAFFOLDING."head.php");
echo menubar($permissions, $section, $root);
//***************************************************************************//


//****************** Process the plates tables and Data: ********************//
// This file inclues all items need for plate model construction.
include(PLATE_HANDLER);

//***************************************************************************//


//****************** Process the dish tables and Data: **********************//
include(DISH_HANDLER);

$processed_dish_cells = $test_pantab_trial;
$processed_active_rows = $test_active;
//***************************************************************************//


//**************************** View Construction ****************************//
// Plate Type Display and Editing Panel //
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
  var_dump($dishMERGE);
  echo "<br>mysql procesed<br>";
  var_dump($dishSQL);
  echo "<br>post procesed<br>";
  var_dump($dishPOST);
  echo "</pre>";
  
}
//***************************************************************************//


//******************************** Footer ***********************************//
include(SCAFFOLDING_ADMIN."footer.php");
//***************************************************************************//

 

