<?php
try {
	$mysqli_sec = new mysqli(HOST, SEC_USER, "TLOZBmgpB,X^", SEC_DATABASE);	
} catch(Exception $e) {
  echo "Unable to Complete Request.";
  exit;
}