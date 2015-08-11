<?php

//****************** Configuration & Inclusions *****************************//
include_once("../../include/config.php");
include_once(SCAFFOLDING_ADMIN."admin.include.php"); // centeralized admin includes
//***************************************************************************//

//***************** Check for Correct Orign Point ***************************//
$process = $_POST;
//if(isset($process["drinkTypes-token"]) && strlen($process["drinkTypes-token"]) === 4 ){
//  include(BREWS_HANDLER); // pull the new table
//} else
if (isset($process["wineTypes-token"]) && strlen($process["wineTypes-token"]) === 4) {
  include(WINES_HANDLER); //pull the new table
} else if (isset($process["sizeTypes-token"]) && strlen($process["sizeTypes-token"]) === 4) {
  include(SIZE_HANDLER); //pull the new table
} else {
  header('Location: '.ADMIN); // redirect
}
//***************************************************************************//
