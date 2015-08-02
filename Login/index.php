<?php

//****************** Configuration & Inclusions *****************************//
include("../include/config.php");
$db_cred = unserialize(LOGIN_SCRIPT_CREDENTIALS);
require_once(INCLUDES."db_con.php");
include(SCAFFOLDING_ADMIN."admin.include.php"); // centeralized admin includes
include_once(AUTHENTICATION.'auth.functions.php');
include_once(AUTHENTICATION.'auth.process.login.php');
//***************************************************************************//


//******************** Basic logged-in to redirect check ********************//
sec_session_start();

// check for a login
if (count($_POST) > 0){
  process_login($_POST, $mysqli);
}
// check for redirect
if (login_check($mysqli) == true) {
    header('Location: '.ADMIN);
}

// check for an error
if (isset($_GET['error'])) {
  $error =  '
        <p class="error">Error Logging In!</p>';
} else {
  $error = '<br>';
}
//***************************************************************************//


//********************* Open The Page & setup for login *********************//
$title = "Login";
$section = ADMIN;
include(SCAFFOLDING."head.php");
//***************************************************************************//


//****************************** Login HTML *********************************//
echo'
      <div class="col-xs-12 text-center logo-wrapper">
        <h2>Admin Portal Login</h2>
        <img src="../images/general/Finger-Lakes-on-Tap-Logo-lg.png" alt="Finger Lakes on Tap Logo" class="img-responsive center-block logo">
        <p>Please Login to Continue.</p>'.
        $error.'
      </div>
      <div class="container text-center">
        <form method="post" name="login_form" class="form-inline">
          <div class="form-group">
            <label class="sr-only" for="email">Email:</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="email">
          </div>
          <div class="form-group">
            <label class="sr-only" for="password">Password:</label>
            <input type="password"class="form-control" name="password" id="password" placeholder="password">
          </div>
          
          <input class="btn btn-default" type="button" value="Login" onclick="formhash(this.form, this.form.password);"> 
        </form>
        
      </div>';
//***************************************************************************//


//******************************** Footer ***********************************//
include(SCAFFOLDING_ADMIN."footer.php");
//***************************************************************************//
 

