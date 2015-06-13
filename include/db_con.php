<?php
// make a connection to the mysql db
try {
	$mysqli = new mysqli($db_cred[0], $db_cred[3], $db_cred[4], $db_cred[1]);	
} catch(Exception $e) {
  echo "Unable to Complete Request.";
  exit;
}