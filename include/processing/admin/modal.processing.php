<?php
include_once(PROCESSING_FUNCTIONS."sql.array.helpers.php"); //for making things like selects.
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

      $return_array = array("id" => $id,
                            "username" => $username,
                            "email" => $email,
                            "new_user" => false,
                            "group" => $group);
      if ($stmt = $mysqli_sec->prepare("SELECT group_name, edit_user FROM user_groups 
                                       WHERE id = ? LIMIT 1")) {
        $stmt->bind_param('i', $group);
        $stmt->execute();   
        $stmt->bind_result($group_name, $intr);
        $stmt->fetch();
        $return_array["group_name"] = $group_name;
        if (isset($intr)){
          if($intr != 1){$return_array["admin"] = false;}
          if($intr > 0){$return_array["admin"] = true;}
          
          // everything checks
          return $return_array;
        } else {
          return false;
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

/**
 * a function for making the user selector for selecting user groups. The function
 * does not allow for placing users into the admin group or the new group unless
 * the user is on the $admin_access array.
 *
 * @param array $table an array of table name, id field, display field
 * @param array $locked an array of records not to be accessed.
 * @param obj $mysqli_sec the mysqli object
 *
 * @return an array sanatized of the options from $locked
 *
 */
function limitedSelector($mysqli_sec, $table, $locked){
  $full_selector = make_selector($mysqli_sec, $table);
  
  foreach($locked as $remove){
    unset($full_selector[$remove]);
  }
  
  return $full_selector;
}


/**
 * builds a selectior for use in a modal
 *
 * @param str $name the name to be used for the selector
 * @param array $options the list of options to chose from
 * @param mixed $selected the selected option (optional)
 * @param str $id the FULL STRING WITH LEADING SPACE
 * 
 */
function modalSelector($name, $options, $selected=null, $id=''){
  $return_string = '          <select class="form-control"'.$id.' name="'.$name.'">';
  
  // make the options
  foreach($options as $value => $text){
    if($value == $selected){$sel = ' selected';} else {$sel = '';}  // check for selected
    $option = '  <option value="'.$value.'">'.$text.'</option>'; // make the option
    
    //add to the string
    $return_string .= '
  '. $option .'';
  }
  
  //close the string
  $return_string .='
          </select>';
          
  return $return_string;
}






