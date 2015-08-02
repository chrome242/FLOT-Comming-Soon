<?php

include("../../include/config.php");
$login = true; // to kill loops
$sec_cred = unserialize(LOGIN_SCRIPT_CREDENTIALS);
require_once(AUTHENTICATION.'auth.functions.php');
include_once(AUTHENTICATION.'auth.process.login.php');

if (login_check($mysqli_sec) == true) {
  header('Location: '.ADMIN);
} else {
  header('Location: /Login/');
}
