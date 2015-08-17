<?php
try {
	$mysqli_sec = new mysqli($host=$LOGI_CREDS["host"], $username=$LOGI_CREDS["username"],
                           $passwd=$LOGI_CREDS["passwd"], $dbname=$LOGI_CREDS["dbname"]);	
} catch(Exception $e) {
  echo "Unable to Complete Request.";
  exit;
}