<?php

/**
 * A function to display the user password modal.
 *
 * @param array $user_info the array of user info to display
 * 
 * @return str the modal
 */
function userPasswordModal($user_info){
  // local variables because better then arrays
  extract($user_info); // id, username, email, new_user (b), group (#), admin (b), group_name

  $prefix = 'name="members['.$id.'][';
  $sufix = ']"';

  $modal = '<div class="modal-header user-modal">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="passwordModalLabel">Change Password For: '. $username . ' (ID: <span id="userID">'. $id .'</span>)</h4>
      </div>
      <div class="modal-body">
        <h5><b>Please note the following:</b></h5>
        <ul>
          <li>Passwords must be at least 6 characters long</li>
          <li>Passwords must contain
            <ul>
              <li>At least one uppercase letter (A..Z)</li>
              <li>At least one lowercase letter (a..z)</li>
              <li>At least one number (0..9)</li>
            </ul>
          </li>
          <li>Passwords can not be recovered if forgoten, only reset.</li>
        </ul>
        <form name="members" method="post">
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
        <button type="button" class="btn btn-primary" id="submit-passwordModal" disabled>Update</button>
      </div>
          ';
  
  return $modal;
}
