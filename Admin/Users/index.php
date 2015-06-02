
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
             
$title = "Manage Users";
$section = ADMIN."Users/";


$sectionWrappers = array("userGroups" => ["User Group Definitions", false],
                         "userManagement" => ["User Management", false]);

// open the page
include(SCAFFOLDING."head.php");

 // Menu Bar
echo menubar($permissions, $section, $root);

// group management wrapper
echo '      <div class="collapse" id="UserGroups"> <!-- Group Definitions -->';
// TODO: make handler for group table
echo '      </div>';


// user management wrapper
echo '      <div class="collapse" id="userManagement"> <!-- Users -->';
// TODO: make handler for beer table
echo '      </div>';

// close the page
include(SCAFFOLDING_ADMIN."footer.php");