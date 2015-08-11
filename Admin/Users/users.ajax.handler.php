<?php

//****************** Configuration & Inclusions *****************************//
include_once("../../include/config.php");
include_once(SCAFFOLDING_ADMIN."admin.include.php"); // centeralized admin includes
//***************************************************************************//

//***************** Check for Correct Orign Point ***************************//
$process = $_POST;
if(isset($process["user_groups-token"]) && strlen($process["user_groups-token"]) === 4 ){
  include(GROUP_HANDLER); // pull the new table
} else if (isset($process["members-token"]) && strlen($process["members-token"]) === 4){
  echo"PLEASE SET THE USER HANDLER";
} else {
  header('Location: '.ADMIN); // redirect
}
//***************************************************************************//
