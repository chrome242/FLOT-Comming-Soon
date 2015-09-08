<?php
/**
 * Functions to help process modals used in the admin section of the app.
 */

/**
 * A function to check the params of a user account in the DB
 *
 * @param int $id the user's id
 * @param obj $mysqli_sec the $mysqli_sec connection object.
 *
 * @return array of user name, email, and group.
 */
function querryUser($id, $mysqli_sec) {
  // Using prepared statements means that SQL injection is not possible. 
  if ($stmt = $mysqli_sec->prepare("SELECT username, email, user_group
    FROM members WHERE id = ? LIMIT 1")){
    $stmt->bind_param('i', $id);  // Bind "$email" to parameter.
    $stmt->execute();    // Execute the prepared query.
    $stmt->store_result();

    // get variables from result.
    $stmt->bind_result($username, $email, $group);
    $stmt->fetch();

    if ($stmt->num_rows == 1) {

      $return_array = array("username" => $username,
                            "email" => $email,
                            "new_user" => false,
                            "group" => $group);
      if ($stmt = $mysqli_sec->prepare("SELECT edit_user FROM user_groups 
                                       WHERE id = ? LIMIT 1")) {
        $stmt->bind_param('i', $group);
        $stmt->execute();   
        $stmt->bind_result($intr);
        $stmt->fetch();
        if (isset($intr)){
          if($intr != 1){$return_array["admin"] = false;}
          if($intr > 0){$return_array["admin"] = true;}
          
          // everything checks
          return $return_array;
        } else {
          return $stmt->num_rows;
        }
      } else {
        return false;
      }
    } else {
      return false;
    }
  } else{
    return false;
  }
  return false;
}

/**
 * a function to check if the user has the rights to edit an admin account.
 *
 * @return bool if the user has admin edit rights.
 */
function checkEditAdmin($admin_access){
  return in_array($_SESSION['user_email'], $admin_access, true);
}