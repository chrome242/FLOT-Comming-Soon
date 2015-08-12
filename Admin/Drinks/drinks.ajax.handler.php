<?php

//****************** Configuration & Inclusions *****************************//
include_once("../../include/config.php");
include_once(SCAFFOLDING_ADMIN."admin.include.php"); // centeralized admin includes
//***************************************************************************//

//***************** Check for Correct Orign Point ***************************//
$process = $_POST;
if(isset($process["beers-token"]) && strlen($process["beers-token"]) === 4 ){
  include(BEER_HANDLER); // pull the new table
} else if (isset($process["wines-token"]) && strlen($process["wines-token"]) === 4){
  include(WINE_HANDLER); // pull the new table
} else if (isset($process["breweries-token"]) && strlen($process["breweries-token"]) === 4){
  include(BREWERY_HANDLER); // pull the new table
} else if (isset($process["wineries-token"]) && strlen($process["wineries-token"]) === 4){
  include(WINERY_HANDLER); // pull the new table
} else {
  header('Location: '.ADMIN); // redirect
}
//***************************************************************************//
