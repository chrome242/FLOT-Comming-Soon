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
        <ul>
          <li><span id="nam">Usernames may contain only digits, upper and lowercase letters and underscores</span></li>
          <li><span id="mal">Emails must have a valid email format</span></li>
          <li><span id="len">Passwords must be at least 6 characters long</span></li>
          <li>Passwords must contain-
            <ul>
              <li><span id="ucase">At least one uppercase letter (A..Z)</span></li>
              <li><span id="lcase">At least one lowercase letter (a..z)</span></li>
              <li><span id="num">At least one number (0..9)</span></li>
            </ul>
          </li>
          <li>Passwords can not be recovered if forgoten, only reset.</li>
          <li>Your password and confirmation must match exactly</li>
        </ul>
        <form name="members" method="post">
          <div id="warning" hidden>
            <p class="bg-danger text-center"><strong>Passwords do not match!</strong></p>
          </div>
          <div id="nowarning">
            <p><br></p>
          </div>
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
          <div id="warning" hidden>
            <p class="bg-danger text-center">Passwords do not match!</p>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary dis-btn-jqtg" id="submit-addModal" name="submit" data-dismiss="modal" disabled>Update</button>
      </div>
          ';
  
  return $modal;
}
