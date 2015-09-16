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
function userAddModal(){
  // local variables because better then arrays
  $id="NewUser";

  // DB params for selector construction
  $sel_params = array("user_groups", "id", "group_name");

  // build a name prefix & sufix for the form submission
  $prefix = 'name="members['.$id.'][';
  $sufix = ']"';
  $sel_name = "members[$id][group]"; // for the selector
  

  
  // start making the modal
  $modal = '<div class="modal-header user-modal">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="addModalLabel">Add User (ID: <span id="userID">'. $id .'</span>)</h4>
      </div>
      <div class="modal-body">
        <form name="members" method="post">
        <ul>
          <li>Usernames may contain only digits, upper and lowercase letters and underscores</li>
          <li>Emails must have a valid email format</li>
          <li>Passwords must be at least 6 characters long</li>
          <li>Passwords must contain-
            <ul>
              <li>At least one uppercase letter (A..Z)</li>
              <li>At least one lowercase letter (a..z)</li>
              <li>At least one number (0..9)</li>
            </ul>
          </li>
        </ul>
          <li>Passwords can not be recovered if forgoten, only reset.</li>
          <li>Your password and confirmation must match exactly</li>
          <div class="form-group">
            <label for="name" class="control-label">User Name:</label>
            <input type="text" id="name" class="form-control" '. $prefix.'username'.$sufix . ' placeholder="Enter Name">
          </div>
          <div class="form-group">
            <label for="email" class="control-label">User Email:</label>
            <input type="email" id="email" class="form-control" '. $prefix.'email'.$sufix . ' placeholder="Enter Email">
          </div>
          <div class="form-group">
            <label for="group" class="control-label">User Group:</label>
            <p>Group: New User</p>
          </div>
          <div class="form-group">
            <label for="password" class="control-label">Enter Password:</label>
            <input type="password" id="password" class="form-control" '. $prefix.'password'.$sufix . ' placeholder="Enter Password">
          </div>
          <div class="form-group">
            <label for="verify" class="control-label">Verify Password:</label>
            <input type="password" id="verify" class="form-control" '. $prefix.'verify'.$sufix . ' placeholder="Enter Password Again">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="submit-addModal" disabled>Update</button>
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