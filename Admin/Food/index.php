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

//***************************************************************************//


//**************************** View Construction ****************************//
// Plate Type Display and Editing Panel //
$plates = new SmallTable("foodType", $platesMERGE, $platesTYPE, 4);
$platesPanel = new Panel("Plate Types", $plates);
$platesPanel->addButton();

// Display The Panel //
echo $platesPanel;


// Dish Display and Editing Panel //
$dishes = new PanelTable("dishType", $dishPROCESSED,
                         $dishes_display, $dishes_edit,
                         $dishTYPE);
// width formating
$dishes->setCellClass("food_name", "col-xs-3");
$dishes->setCellClass("food_type_name", "col-xs-3");
$dishes->setCellClass("food_price", "col-xs-3");

//add final button
$dishes->addCellButton("food_desc", "drop", "Drop", "large");

// make the panel wrapper
$dishesPanel = new Panel("Dishes", $dishes);
$dishesPanel->addButton();

// Display The Panel //
echo $dishesPanel;

//***************************************************************************//


//******************************** Footer ***********************************//
include(SCAFFOLDING_ADMIN."footer.php");
//***************************************************************************//

 

