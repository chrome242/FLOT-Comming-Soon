<?php
// make a connection to the mysql db
try {
	$mysqli_sec = new mysqli($sec_cred[0], $sec_cred[3], $sec_cred[4], $sec_cred[1]);	
} catch(Exception $e) {
  echo "Unable to Complete Request.";
  exit;
}