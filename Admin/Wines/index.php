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

//***************************************************************************//


//******************** Open The Page & Display Menu Bar *********************//
$title = "Wine Inventory";
$section = ADMIN . "Wines/";
include(SCAFFOLDING."head.php");
echo menubar($permissions, $section, $root);

//***************************************************************************//


//****************** Process the wine tables and Data: **********************//
include(WINE_BAR);

//***************************************************************************//


//********************************* Content *********************************//
// Make the table, echo it out
$wines = new Table("wines", $winesPROCESSED,
                         $wines_view, $wines_view,
                         $winesTYPE);
echo $wines;
//***************************************************************************//


//******************************** Footer ***********************************//
include(SCAFFOLDING_ADMIN."footer.php");
//***************************************************************************//

 

