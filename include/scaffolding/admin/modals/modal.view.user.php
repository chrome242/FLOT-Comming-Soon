<?php

/**
 * A function to display the user view modal.
 *
 * @param array $user_info the array of user info to display
 * 
 * @return str the modal
 */
function userViewModal($user_info){
  // local variables because better then arrays
  extract($user_info); // id, username, email, new_user (b), group (#), admin (b), group_name

  $modal = '<div class="modal-header user-modal">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="viewModalLabel">View User: '. $username . ' (ID: <span id="userID">'. $id .'</span>)</h4>
      </div>
      <div class="modal-body">
        <form name="members" method="post">
          <div class="form-group">
            <label for="name" class="control-label">User Name:</label>
            <p id="name">'.$username.'</p>
          </div>
          <div class="form-group">
            <label for="email" class="control-label">User Email:</label>
            <p id="email">'.$email.'</p>
          </div>
          <div class="form-group">
            <label for="group" class="control-label">User Group:</label>'.
              '<p id="group">'.$group_name.'</p>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
          ';
  
  return $modal;
}
