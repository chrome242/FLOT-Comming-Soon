<?php
// needs to display the inside of the unedit modal and the SQL querry driven modal.
if(isset($_POST["user_edit_id"])){ // then the user should be in the DB.
  $user_info = querryUser($_POST["user_edit_id"]); //TODO get username, email, and if group has admin priv
  $user_info["new_user"] = false;
} else{
  $user_info = array("username" => "New User",
                     "email" => "Enter Email",
                     "admin" => false,  // from the user group
                     "new_user" => true);
}

if($user_info["admin"]){ // don't allow changes unless is super user
  
} else { // allow changes by any admin
  
}

echo'
      <div class="modal-header user-modal">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="userModalLabel">Edit User: '.$name.'</h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="name" class="control-label">User Name:</label>
            <input type="text" class="form-control" id="name" '.$name_wrapper.'>
          </div>
          <div class="form-group">
            <label for="email" class="control-label">User Email:</label>
            <input type="email" class="form-control" id="email" '.$email_wrapper.'>
          </div>
          <div class="form-group">
            <label for="password" class="control-label">Password:</label>
            <input type="password" class="form-control" id="password">
          </div>
          <div class="form-group">
            <label for="verify" class="control-label">Password:</label>
             <input type="password" class="form-control" id="verify">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="submit-editModal">Update</button>
      </div>';