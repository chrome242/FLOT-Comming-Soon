<?php
try {
	$mysqli = new mysqli($host=$db_cred["host"], $username=$db_cred["username"],
                           $passwd=$db_cred["passwd"], $dbname=$db_cred["dbname"]);	
} catch(Exception $e) {
  echo "Unable to Complete Request.";
  exit;
}