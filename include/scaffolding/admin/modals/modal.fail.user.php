<?php

/**
 * A function to display the user drop modal.
 *
 * @param array $user_info the array of user info to display
 * 
 * @return str the modal
 */
function failModal(){


  $modal = '<div class="modal-header fail-modal">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="failModalLabel">Action failed</h4>
      </div>
      <div class="modal-body">
        <p>I\'m sorry, it doesn\'t seem like you can currently do that. Please refresh the web browser and see if the problem has been resolved.</p>
        <br>
        <p>If the problem persist, please contact the system admin.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Acknowledge</button>
      </div>
          ';
  
  return $modal;
}
