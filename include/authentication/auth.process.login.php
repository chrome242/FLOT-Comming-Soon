<?php

/**
 * A function to check the login credentials against the mysql db, and report an
 * error based on what sort of fail happens if a fail occurs.
 */
function process_login($post, $mysqli){
  if (isset($post['email'], $post['p'])) {
      $email = $post['email'];
      $password = $post['p']; // The hashed password.
   
      if (login($email, $password, $mysqli) == true) {
          // Login success 
          header('Location: '.ADMIN);
      } else {
          // Login failed 
          header('Location: '.'/Login/?error=login_failed');
      }
  }  else {
    // incorrect post.
     header('Location: '.'/Login/?error=submit_error');
  }
}