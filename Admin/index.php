<?php

include("../include/config.php");
include(SCAFFOLDING_ADMIN."admin.include.php"); // centeralized admin includes

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
$options = array("inhouse" => "In House",
                 "ondeck" => "On Deck",
                 "kicked" => "Kicked",
                 "all" => "All");
           
$title = "Beer Inventory";
$section = ADMIN; // This will be a concat for child pages


// open the page
include(SCAFFOLDING."head.php");

// Menu Bar
echo menubar($permissions, $section, $root);

// All pages in the admin section will post to themselves. Check to see if
// Anything relevant to the page is in the $_POST() array and if so, process
// it here. If not, then process it 


// Sort Bar
echo sortbar($options, "all");

// TODO: Get Table from Database
// makeBeerView();


// TODO: include Processing Files


// close the page
include(SCAFFOLDING_ADMIN."footer.php");