<?php
//****************** Configuration & Inclusions *****************************//
include("../include/config.php");
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

$sort_options = array("inhouse" => "In House", "ondeck" => "On Deck",
                 "kicked" => "Kicked", "all" => "All");

$beer_headers = array("Id" => array("beer_id" => 'id'),
                      "Brewery" => array("beer_brewery" => "plain"),
                      "Beer" => array("beer_name" => "plain"),
                      "On Tap" =>  array("beer_status" => "radio, 4"),
                      "On Deck" => 2,
                      "Kicked" => 3,
                      "Off Line" => 4,
                      "timeontap" => array("beer_ontap" => "time, private"),
                      "timeofftap" => array("beer_offtap" => "time, private"),
                      );


//***************************************************************************//


//******************** Open The Page & Display Menu Bar *********************//
$title = "Beer Inventory";
$section = ADMIN; // This will be a concat for child pages
include(SCAFFOLDING."head.php");
echo menubar($permissions, $section, $root);
echo sortbar($sort_options, "all");
//***************************************************************************//


//***************** Final Variable Processing & Cleaning *******************//
// Fututre home of SQL & $_POST processing methods
$processed_beer_cells = $beer_test_cells;
//***************************************************************************//


//********************************* Content *********************************//
// Plate Type Display and Editing Panel //
$beerTable = new Table("Beer", $processed_beer_cells, $beer_headers);
$beerTable->addCounter("Total on Tap:", "beer_status", "0");
$beerTable->offlineCheck();

// Display The Panel //
echo $beerTable;
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

 

