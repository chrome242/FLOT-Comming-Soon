<?php

/**
 * A function to display the user drop modal.
 *
 * @param array $user_info the array of user info to display
 * 
 * @return str the modal
 */
function userDropModal($user_info){
  // local variables because better then arrays
  extract($user_info); // id, username, email, new_user (b), group (#), admin (b), group_name

  $prefix = 'name="members['.$id.'][';
  $sufix = ']"';

  $modal = '<div class="modal-header user-modal">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="deleteModalLabel">Retire User: '. $username . ' (ID: <span id="userID">'. $id .'</span>)</h4>
      </div>
      <div class="modal-body">
        <h4><b>Please Confirm User Retirement</b></h4>
        <p>Please press the confirm button below to enable user retirement.</p>
        <p>Once you\'ve pressed the confrim button, click on the Drop button in the corner to finish the operation.</p>
        <form name="members" method="post">
          <div class="form-group">
            <label for="confirm" class="control-label">Confirm:</label>
            <button type="button" id="confirm" class="btn btn-danger" '. $prefix.'active'.$sufix . '>Confirm</confirm>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary dis-btn-jqtg" id="submit-dropModal" name="submit" data-dismiss="modal" disabled>Drop</button>
      </div>
          ';
  
  return $modal;
}
