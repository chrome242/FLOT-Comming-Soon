<?php

//****************** Configuration & Inclusions *****************************//
include_once("../../include/config.php");
include_once(SCAFFOLDING_ADMIN."admin.include.php"); // centeralized admin includes
//***************************************************************************//

//***************** Check for Correct Orign Point ***************************//
$process = $_POST;
if(isset($process["foodtype-token"]) && strlen($process["foodtype-token"]) === 4 ){
  include(PLATE_HANDLER); // pull the new table
} else if (isset($process["dishtype-token"]) && strlen($process["dishtype-token"]) === 4) {
  include(DISH_HANDLER); //pull the new table
} else {
  header('Location: '.ADMIN); // redirect
}
//***************************************************************************//
