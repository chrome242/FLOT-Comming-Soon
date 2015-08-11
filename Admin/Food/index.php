<?php

//****************** Configuration & Inclusions *****************************//
$pageJavaScript = 'food';
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


//******************** Open The Page & Display Menu Bar *********************//
$title = "Manage Dishes";
$section = ADMIN."Food/";
include_once(SCAFFOLDING."head.php");
echo menubar($permissions, $section, $root);
//***************************************************************************//


//**************************** View Construction ****************************//

echo '
        <div id="plateView" token="'.rand(1000, 9999).'"> <!-- Plate Definitions -->';
include(PLATE_HANDLER);
echo '      </div>';

echo '
        <div id="dishView" token="'.rand(1000, 9999).'"> <!-- Dish Definitions -->';
include(DISH_HANDLER);
echo '      </div>';
//***************************************************************************//


//******************************** Footer ***********************************//
include(SCAFFOLDING_ADMIN."footer.php");
//***************************************************************************//

 

