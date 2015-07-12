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




//******************** Open The Page & Display Menu Bar **********************//
$title = "Manage Extras";
$section = ADMIN."Extras/";
include(SCAFFOLDING."head.php");
echo menubar($permissions, $section, $root);
//****************************************************************************//


//****************** Process the brews tables and Data: **********************//
// This file inclues all items need for brew model construction.
include(BREWS_HANDLER);
//***************************************************************************//


//****************** Process the wine tables and Data: **********************//
// This file inclues all items need for bwinerew model construction.
include(WINES_HANDLER);
//***************************************************************************//


//****************** Process the wine tables and Data: **********************//
// This file inclues all items need for bwinerew model construction.
include(SIZE_HANDLER);
//***************************************************************************//


//********************************* Content *********************************//

// Beer type & desc editing panel //
$beers = new SmallTable("drinkTypes", $drinksMERGE, $drinksTYPE, 4);
$beerPanel = new Panel("Varieties of Beer", $beers);
$beerPanel->addButton();

// Display The Panel //
echo $beerPanel;


// Wine Display and Editing Panel //
$wines = new ListView("wineTypes", $WRAPPED_winesMERGE, $special=$WRAPPED_winesTYPE,
                      $wine_default, $wine_desc_field);
$winePanel = new Panel("Wines", $wines, $size="half");
$winePanel->addButton();

// Display The Panel
echo $winePanel;


// Drink Size Edit Panel //
$sizes = new ListView("sizeTypes", $WRAPPED_sizesMERGE, $special=$WRAPPED_sizesTYPE,
                      $size_default, $size_desc_field);
$sizePanel = new Panel("Glasses, Jugs, &amp; Mugs", $sizes, $size="half");
$sizePanel->addButton();

// Display The Panel
echo $sizePanel;


// clearfix for right panel
echo '      <div class="clearfix visible-md-block"></div>';

//***************************************************************************//


//******************************** Footer ***********************************//
include(SCAFFOLDING_ADMIN."footer.php");
//***************************************************************************//

 

