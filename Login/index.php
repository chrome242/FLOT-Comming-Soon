<?php

//****************** Configuration & Inclusions *****************************//
include("../include/config.php");
$thispage = "Login";
$login = true; // to kill loops
include(SCAFFOLDING_ADMIN."admin.include.php"); // centeralized admin includes
include_once(AUTHENTICATION.'auth.process.login.php');
//***************************************************************************//


//******************** Basic logged-in to redirect check ********************//
if (isset($_GET['logout'])){
    $error =  '
        <p class="error">Logged Out!</p>';
}

// check for a login
if (count($_POST) > 0){
  process_login($_POST, $mysqli_sec);
}
// check for redirect
if (login_check($mysqli_sec) == true) {
  header('Location: '.ADMIN);
}

// check for an error
if (isset($_GET['error'])) {
  $error =  '
        <p class="error">Error Logging In!</p>';
}
if (!isset($error)){
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
            <input type="email" class="form-control" id="email" name="email" placeholder="email">
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
 

