<?php
include_once("../config.php");

include_once 'auth.functions.php';
 
sec_session_start(); // Our custom secure way of starting a PHP session.
 
if (isset($_POST['email'], $_POST['p'])) {
    $email = $_POST['email'];
    $password = $_POST['p']; // The hashed password.
 
    if (login($email, $password, $mysqli) == true) {
        // Login success 
        header('Location: '.ADMIN);
    } else {
        // Login failed 
        header('Location: '.ADMIN.'/Login/?error=login_failed');
    }
} else {
    // The correct POST variables were not sent to this page. 
    echo 'Invalid Request';
}