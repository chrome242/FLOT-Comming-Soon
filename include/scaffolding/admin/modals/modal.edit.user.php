<?php

/**
 * A function to display the user edit modal.
 *
 * @param array $user_info the array of user info to display
 * @param array $admin_access the array of people with admin edit access
 *
 * @return str the modal
 */
function userEditModal($user_info, $admin_access){
  
  echo"check admin: " . var_dump(checkEditAdmin($admin_access)) . "<br>";
  echo"user_info:<br><pre>";
  var_dump($user_info);

  echo"</pre>";
}