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
function userViewModal($user_info){
  // local variables because better then arrays
  extract($user_info); // id, username, email, new_user (b), group (#), admin (b), group_name

  $modal = '<div class="modal-header user-modal">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="userModalLabel">View User: '. $username . ' (ID: '. $id .')</h4>
      </div>
      <div class="modal-body">
        <form name="members" method="post">
          <div class="form-group">
            <label for="name" class="control-label">User Name:</label>
            <p>'.$username.'</p>
          </div>
          <div class="form-group">
            <label for="email" class="control-label">User Email:</label>
            <p>'.$email.'</p>
          </div>
          <div class="form-group">
            <label for="group" class="control-label">User Group:</label>'.
              '<p>'.$group_name.'</p>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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