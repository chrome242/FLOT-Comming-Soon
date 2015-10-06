<?php
//****************** Configuration & Inclusions *****************************//
$thispage = "Admin";
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

//****************** Process the wine tables and Data: **********************//
include(BEER_BAR);

//***************************************************************************//


//********************************* Content *********************************//
$beers = new Table("beers", $beersPROCESSED,
                         $beer_display, $beer_display,
                         $beersTYPE);
$beers->addCounter("Total on Tap:", "beer_status", "1");
$beers->offlineCheck();
echo $beers;
//***************************************************************************//

//********************************TEST***************************************//

/* The array will have to be processed in the following way:
 * first, check for an add. If add exist, then 
 */
if(isset($_POST)){
  echo "Session contents:<br><pre>";
  var_dump($_SESSION);
  var_dump($_POST);
  var_dump($_GET);
  echo "</pre>";
  
}


//******************************** Footer ***********************************//
include(SCAFFOLDING_ADMIN."footer.php");
//***************************************************************************//

 

