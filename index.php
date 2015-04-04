<?php

// section setup
require_once("include/config.php");
$section = HOME;

// database requirements
$db_cred= unserialize(MAIL_CREDENTIALS);
include_once(INCLUDES."db_con.php");

// page scaffolding:
include(SCAFFOLDING."head.php");

// image and page open
echo <<<EOT
      <div class="text-center col-xs-12 lakesightFont">
        <h1>Coming Soon</h1>
      </div>
      <div class="col-xs-12">
        <img src="images/general/Finger-Lakes-on-Tap-Logo-2.png" alt="Finger Lakes on Tap Logo" class="img-responsive center-block logo">
      </div>
EOT;

// the logic for checking/handling request.
// TODO: move to an include.
$error = "";

// check for email header injection
foreach($_REQUEST as $value){
  if (stripos($value, 'Conetent-Type:') !== FALSE ) {
    $error = "<p>This request can not be processed at this time.";
    $header_injection = true;
  }
}

//process the submission
if($_SERVER["REQUEST_METHOD"] != "POST") { //check for correct method
  $showform = true; // not a post, ignore
  
} else if($header_injection){
  $showform = true;

} else if($_POST["address"] != "") { // check honeypot
  $error = "<p>There seems to be an issue with your form submission.</p>";
  $showform = true;
  
} else if($_POST["email"] == "") { // no email entered
  $error = "<p>Please enter an Email Address</p>";
  $showform = true;
  
} else { // sanitize & clean email
  $email = trim($_POST["email"]); //white space removal
  $clean_email = filter_var($email, FILTER_SANITIZE_EMAIL);
  
  if($clean_email != $email){ // check clean email == email
    $error = "<p>There seems to be a problem with your email address. Please try again.</p>";
    $showform = true;
    
  } else if(!filter_var($clean_email, FILTER_VALIDATE_EMAIL)) { //check email validity
    $error = "<p>There seems to be a problem with your email address. Please try again.</p>";
    $showform = true;
    
  } else { //email is good. Time to check the database for the email
    $prep_stmt = "SELECT id FROM contact_list WHERE email = ?";
    $stmt = $mysqli->prepare($prep_stmt);
    
    if($stmt){
      $stmt->bind_param('s', $clean_email);
      $stmt->execute();
      $stmt->store_result();
      
      if($stmt->num_rows == 1) { //already in the database
        $error = "<p>Thanks, but you're already on the mailing list!</p>";
        $showform = true;
        $stmt->close(); //close the query
      }
      
      $stmt->close(); //close the query
      
    } else { //SQL connection error
      $error = "<p>Sorry, we're having some issues right now, please try again later.</p>";
      $showform = true;
    }
    
    if (empty($error)) { //final extra logic check before checking form fields
      if(isset($_POST['mailinglist'])){ 
        // at this point, if they have messed with the form, they're just gonna get added to the
        // mailing list. The value of this var doesn't matter, only set state does.
        $mailinglist = 1;
        
      } else { // not on the mailing list
        $mailinglist = 0;
      }
      
      //build the insert statement.
      if($insert_stmt = $mysqli->prepare("INSERT INTO contact_list (email, mailing_list) VALUES(?, ?)")){
        $insert_stmt->bind_param('si', $clean_email, $mailinglist);
        
        if(! $insert_stmt->execute()){ // couldn't insert to the DB
          $error = "<p>Looks like the database is busy, please try back in a few";
          $showform = true;
        
        } else {
          //success with the DB addition
          $newuser = true;
        }
        
      }
    }
    
  }
}

// display the thank you message, check to see if email should be sent, send email
// TODO: pull email out to a separate fnx.
if($newuser){ 
  if(isset($_POST['thanks'])){
    // at this point, if they have messed with the form, they're just gonna get the
    // thank you mail. The value of this var doesn't matter, only set state does.

    require_once(MAILER."class.phpmailer.php");
    $mail = new PHPMailer();
    
    if(!$mail->ValidateAddress($clean_email)){
      $error ="<p>Please enter a valid Email address!</p>";
      $showform = true;
    }
    
    if(!$showform){
      // this will be replaced with a responsive message
      $message = "Thank you for signing-up to receive emails regarding our path towards opening! Expect to see exciting new details soon!";
      $name = "Finger Lakes On Tap";
      $email = "donotreply@FingerLakesOnTap.com";
      
      //build the email
      $email_body = "";
      $email_body = $email_body . $message;
      
      //config the email
      $mail->setFrom($email, $name);
      $mail->addAddress($clean_email);
      $mail->Subject = "Finger Lakes On Tap Email Validation.";
      
      ///send it as HTML
      $mail->msgHTML($email_body);
      
      if(!$mail->send()){ // if the mail failed to send
        $error = "There was a problem sending the email. Try a different Account.";
        $showform = true;
      }
    }
  }
  
  if(!$showform){
echo <<<EOT

      <div class="col-xs-12 text-center lakesightFont">
        <h3>Thank You!</h3>
        <h4>Look for additional information about the upcoming opening of Finger Lakes on Tap in your inbox in the near future!</h4>
      </div>
EOT;
  }
}


// determine what the rest of the page should be
if($showform){

// form with hidden honeypot
echo <<<EOT

      <div class="col-xs-12 text-center lakesightFont">
        <form method="post" action="/">
          <h3>Sign Up for Updates on Our Opening:</h3>
          $error
          <label for="email">Email:</label>
          <input type="email" name="email" id="email"><br>
          <input type="checkbox" name="thanks" id="thanks" value="true" checked>Send Me a Thank You/Verification Email<br>
          <input type="checkbox" name="mailinglist" id="mailinglist" value="true"> Join the Mailing List<br>
          <input type="text" name="address" id="address" class="hp" placeholder="Don't fill me out, I'm a honeypot">
          <input type="submit" value="Sign Up!">
        </form>
      </div>
EOT;
}


echo <<<EOT

    </div>
  </body>
</html>
EOT;

