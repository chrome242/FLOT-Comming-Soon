
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

// Page variables
                
$title = "Manage Dishes";
$section = ADMIN."Dishes/";


// open the page
include(SCAFFOLDING."head.php");

 // Menu Bar
echo menubar($permissions, $section, $root);

// make the small table for plate types

// make the panel table for indivudual dishes


// close the page
include(SCAFFOLDING_ADMIN."footer.php");