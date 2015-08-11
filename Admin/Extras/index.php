<?php

//****************** Configuration & Inclusions *****************************//
$pageJavaScript = 'extras';
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


//******************** Open The Page & Display Menu Bar **********************//
$title = "Manage Extras";
$section = ADMIN."Extras/";
include(SCAFFOLDING."head.php");
echo menubar($permissions, $section, $root);
//****************************************************************************//


//********************************* Content *********************************//

// Beer type & desc editing panel //
echo '
        <div id="brewsView" token="'.rand(1000, 9999).'"> <!-- Beer Type Definitions -->';
        
include(BREWS_HANDLER);

echo '
        </div>';

// Wine Display and Editing Panel //
echo '
        <div id="wineView" token="'.rand(1000, 9999).'"> <!-- Wine Type Definitions -->';

include(WINES_HANDLER);
        
echo '
        </div>';

// Drink Size Edit Panel //
echo '
        <div id="sizeView" token="'.rand(1000, 9999).'"> <!-- Size Type Definitions -->';
        
include(SIZE_HANDLER);

echo '
        </div>';


// clearfix for right panel
echo '      <div class="clearfix visible-md-block"></div>';

//***************************************************************************//


//******************************** Footer ***********************************//
include(SCAFFOLDING_ADMIN."footer.php");
//***************************************************************************//

 

