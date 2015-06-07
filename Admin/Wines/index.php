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

//******************* Header & Format Arrays For Wine Table *****************//

$wine_headers = array("Id" => array("wine_id" => 'id'),
                      "Brewery" => array("wine_winery" => "plain"),
                      "Beer" => array("wine_name" => "plain"),
                      "On Tap" =>  array("wine_year" => "plain"),
                      "In Stock" => array("wine_instock" => "checkbox")
                      );


//***************************************************************************//


//******************** Open The Page & Display Menu Bar *********************//
$title = "Wine Inventory";
$section = ADMIN . "Wines/";
include(SCAFFOLDING."head.php");
echo menubar($permissions, $section, $root);

//***************************************************************************//


//***************** Final Variable Processing & Cleaning *******************//
// Fututre home of SQL & $_POST processing methods
$processed_wine_cells = $wine_test_cells;
//***************************************************************************//


//********************************* Content *********************************//
// Wine Type Display and Editing Panel //
$wineTable = new Table("Wine", $processed_wine_cells, $wine_headers);

// Display The Tabel //
echo $wineTable;
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

 

