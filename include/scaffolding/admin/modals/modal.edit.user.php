<?php

/**
 * A function to display the user edit modal.
 *
 * @param array $user_info the array of user info to display
 * @param array $admin_access the array of people with admin edit access
 * @param obj $mysqli_sec the mysqli object
 * @param array $locked the recors that should be locked to those without
 *              admin access
 * 
 * @return str the modal
 */
function userEditModal($user_info, $admin_access, $locked, $mysqli_sec){
  // local variables because better then arrays
  extract($user_info); // id, username, email, new_user (b), group (#), admin (b)

  // DB params for selector construction
  $sel_params = array("user_groups", "id", "group_name");

  // build a name prefix & sufix for the form submission
  $prefix = 'name="members['.$id.'][';
  $sufix = ']"';
  $sel_name = "members[$id][group]"; // for the selector
  
  // check which selector type to build
  if(checkEditAdmin($admin_access)){
    $options = make_selector($mysqli_sec, $sel_params);
  }else{
    $options = limitedSelector($sel_params, $locked, $mysqli_sec);
  }
  
  $group_selector = modalSelector($name=$sel_name, $options=$options, $selected=$group);
  
  // start making the modal
  $modal = '<div class="modal-header user-modal">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="userModalLabel">Edit User: '. $username . ' (ID:<span id="userID">'. $id .'</span>)</h4>
      </div>
      <div class="modal-body">
        <form name="members" method="post">
          <div class="form-group">
            <label for="name" class="control-label">User Name:</label>
            <input type="text" id="name" class="form-control" '. $prefix.'username'.$sufix . ' value="'.$username.'">
          </div>
          <div class="form-group">
            <label for="email" class="control-label">User Email:</label>
            <input type="email" id="email" class="form-control" '. $prefix.'email'.$sufix . ' value="'.$email.'">
          </div>
          <div class="form-group">
            <label for="group" class="control-label">User Group:</label>'.
            $group_selector.'
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="submit-editModal">Update</button>
      </div>
          ';
  
  return $modal;
}



// testing code
//function userEditModal($user_info, $admin_access, $locked, $mysqli_sec){
//  $table = array("user_groups", "id", "group_name");
//  echo"check admin: " . var_dump(checkEditAdmin($admin_access)) . "<br>";
//  echo"user_info:<br><pre>";
//  var_dump($user_info);
//  echo"<br>limitedSelector:";
//  var_dump(limitedSelector($table, $mysqli_sec, $locked));
//  echo"</pre>";
//}