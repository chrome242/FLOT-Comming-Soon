<?php

// *** Open the Database Connection and Select the Correct DB credientals *** //

// Will be usings the login script db con
include_once("../../include/config.php");
include_once(SCAFFOLDING_ADMIN."admin.include.php");
//include_once(PROCESSING_ADMIN."modal.processing.php"); //todo

if(!isset($process) || !isset($process['action'])){header('Location: '. ADMIN);} // Shouldn't be here, redirect.}

if($process['action'] == "edit") {
  $user_info = querryUser($process["record"], $mysqli_sec); //returns an array or false
  echo"<pre>";
  var_dump($user_info);
  echo"</pre>";
} elseif($process['action'] == "add") {
  
} elseif($process['action'] == "view") {
  
} elseif($process['action'] == "password") {
  
} elseif($process['action'] == "drop") {

} else {
  header('Location: '. ADMIN);
} // Shouldn't be here, redirect.}