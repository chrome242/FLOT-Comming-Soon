<?php

//****************** Configuration & Inclusions *****************************//
include_once("../../include/config.php");
include_once(SCAFFOLDING_ADMIN."admin.include.php"); // centeralized admin includes
//***************************************************************************//

//***************** Check for Correct Orign Point ***************************//
$process = $_POST;
//if(isset($process["drinktypes-token"]) && strlen($process["drinktypes-token"]) === 4 ){
//  include(BREWS_HANDLER); // pull the new table
//} else
if (isset($process["winetypes-token"]) && strlen($process["winetypes-token"]) === 4) {
  include(WINES_HANDLER); //pull the new table
} else if (isset($process["sizetypes-token"]) && strlen($process["sizetypes-token"]) === 4) {
  include(SIZE_HANDLER); //pull the new table
} else {
  header('Location: '.ADMIN); // redirect
}
//***************************************************************************//
