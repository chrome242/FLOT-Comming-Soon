<?php
// Section Settings:
$root = ADMIN;
// Basic Security
require_once(AUTHENTICATION."auth.db_con.php");
require_once(AUTHENTICATION.'auth.functions.php');
require_once(AUTHENTICATION.'auth.process.logout.php');
sec_session_start();
if(!isset($login)){
  if(login_check($mysqli_sec) != true ){
    if(!isset($thispage)){
      $error = '_101';
    } else {
      $error = '_on_'.$thispage;
    }
    session_logout($_SESSION);
    header('Location: /Login/?error=session_timeout' . $error);
  }
}

echo"This is the top var Dump";
echo"<pre>";
var_dump($_SESSION);
echo"</pre>";
if(($permissions = permissions_check($_SESSION, $mysqli_sec)) && !isset($login)){
  // will add a local check here.
  echo "permissions:<pre>";
  var_dump($permissions);
  echo "<br>Session<br>";
  var_dump($_SESSION);
  echo"</pre>";
} else {
  if(!isset($login)){ // prevents redirect loops
  echo "<pre>Session<br>";
  var_dump($_SESSION);
  echo"</pre>";
  //session_logout($_SESSION);
  //header('Location: /Login/?error=permissions_failure');
  }
}

// General Page Componets
include_once(SCAFFOLDING_ADMIN."menubars.php"); // menubars
include_once(SCAFFOLDING_ADMIN."panel/class.panel.php"); // panel wrapper
include_once(SCAFFOLDING_ADMIN."table/table.php"); // table
include_once(SCAFFOLDING_ADMIN."list/list.php"); // list
include_once(SCAFFOLDING_ADMIN."modals/modals.php"); // modals

// definitions

define("PROCESSING_HANDLERS", PROCESSING_ADMIN."handlers/"); // for the handlers
define("PROCESSING_FUNCTIONS", PROCESSING_ADMIN."functions/"); // functions
define("PROCESSING_MODALS", PROCESSING_ADMIN."modals/"); // Modals
define("PLATE_HANDLER", PROCESSING_HANDLERS."plates.handler.php"); // Plate Sizes
define("BREWS_HANDLER", PROCESSING_HANDLERS."drinks.handler.php"); // Beer Types
define("WINES_HANDLER", PROCESSING_HANDLERS."wine.handler.php"); // Wine Types
define("SIZE_HANDLER", PROCESSING_HANDLERS."size.handler.php"); // Drink Sizes
define("DISH_HANDLER", PROCESSING_HANDLERS."dish.handler.php"); // Food Items
define("BREWERY_HANDLER", PROCESSING_HANDLERS."brewery.handler.php"); // Brewery List
define("WINERY_HANDLER", PROCESSING_HANDLERS."winery.handler.php"); // Winery List
define("WINE_HANDLER", PROCESSING_HANDLERS."wine.inventory.handler.php"); // Wine Glasses
define("BEER_HANDLER", PROCESSING_HANDLERS."beer.inventory.handler.php"); // Beer Glasses
define("WINE_BAR", PROCESSING_HANDLERS."wine.bar.handler.php"); // The Bar view of wines
define("BEER_BAR", PROCESSING_HANDLERS."beer.bar.handler.php"); // The Bar view of Beers
define("GROUP_HANDLER", PROCESSING_HANDLERS."group.handler.php"); // User Group View
define("USER_MODAL_INVOKER", PROCESSING_MODALS."user.modals.php"); // User page modals
define("USER_HANDLER", PROCESSING_HANDLERS."user.handler.php");

// Test files
if (!ON_LINE){
  include_once(SCAFFOLDING_ADMIN."testing/test.data.php");
}