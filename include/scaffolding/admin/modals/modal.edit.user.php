<?php

/**
 * A function to display the user edit modal.
 *
 * @param array $user_info the array of user info to display
 * @param array $admin_access the array of people with admin edit access
 * @param obj $mysqli_sec the mysqli object
 * 
 * @return str the modal
 */
function userEditModal($user_info, $admin_access, $mysqli_sec, $locked){
  $table = array("user_groups", "id", "group_name");
  echo"check admin: " . var_dump(checkEditAdmin($admin_access)) . "<br>";
  echo"user_info:<br><pre>";
  var_dump($user_info);
  echo"<br>limitedSelector:";
  var_dump(limitedSelector($table, $mysqli_sec, $locked));
  echo"</pre>";
}