<?php

// *** Open the Database Connection and Select the Correct DB credientals *** //

// Will be usings the login script db con
include_once("../../include/config.php");
include_once(SCAFFOLDING_ADMIN."admin.include.php");  // for templates
include_once(PROCESSING_ADMIN."modal.processing.php");  // for functions

if(!isset($process) || !isset($process['action'])){header('Location: '. ADMIN);} // Shouldn't be here, redirect.

// edit request
if($process['action'] == "edit") {
  $user_info = querryUser($process["record"], $mysqli_sec); //returns an array or false
  
  if(!$user_info){ // if the user somehow does not exist, then make into an add
    $process['action'] = "add";
    
  } elseif($user_info['admin'] && !checkEditAdmin($SUPER_USERS)){ // if the user is an admin and the editor does not have permissions to edit admin
    echo failModal();
    
  } else { // looks good, do the work
    echo userEditModal($user_info, $SUPER_USERS, $LOCKED_RECORDS, $mysqli_sec); //todo
  }

// view request
} elseif($process['action'] == "view") {
  $user_info = querryUser($process["record"], $mysqli_sec); //returns an array or false
  
  if(!$user_info){ // if the user somehow does not exist, then make into a fail
    echo failModal();
    
  } else { // looks good, do the work
    echo userViewModal($user_info);
  }

// request to change password
} elseif($process['action'] == "password") {
   $user_info = querryUser($process["record"], $mysqli_sec); //returns an array or false
  
  if(!$user_info){ // if the user somehow does not exist, then fail
    echo failModal();
    
  } elseif($user_info['admin'] && !checkEditAdmin($SUPER_USERS)){ // if the user is an admin and the editor does not have permissions to edit admin
   echo failModal();
    
  } else { // looks good, do the work
    echo userPasswordModal($user_info);
  }

// request to drop a user
} elseif($process['action'] == "drop") {
  $user_info = querryUser($process["record"], $mysqli_sec); //returns an array or false
  
  if(!$user_info){
    echo failModal();
    
  } elseif($user_info['admin'] && !checkEditAdmin($SUPER_USERS)){ // if the user is an admin and the editor does not have permissions to edit admin
    echo failModal();
    
  } else { // looks good, do the work
    echo userDropModal($user_info);
  }

// request 
} elseif($process['action'] == "add") {
  echo userAddModal();

} elseif($process['action'] == "fail"){
  echo failModal();
} else {
  header('Location: '. ADMIN); // Shouldn't be here, redirect.
}