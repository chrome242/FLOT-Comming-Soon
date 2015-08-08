<?php
/* This is the type of beer view.
 */
// *** Open the Database Connection and Select the Correct DB credientals *** //

$db_cred = unserialize(MENU_ADMIN_CREDENTIALS);
require_once(INCLUDES."db_con.php");
include_once(PROCESSING_ADMIN."smallTable.processing.php");

// ************************************************************************** //


// ************* Drink invokation Rules. To format the Model **************** //
$drink_type_rule = array("drink_type_name" =>array(
                          "active" => ["linkedText", false],
                          "static" => ["editPlain", false],
                          "new" => ["addText", false]),
                         "drink_type_desc" => array(
                          "active" => ["linkedArea, value, 3, 4", false],
                          "static" => ["linkedArea, value, 3, 4", true],
                          "new" => ["linkedArea, value, 3, 4", true]),
                        );
// ************************************************************************** //

// ********** Generating the drink model. View invoked in index. ************ //

// make the two arrays of contents match in format
$drinksSQL = sqlToSmallTable($mysqli, 'drinkTypes');
$drinksPOST = postToSmallTable($_POST, 'drinkTypes');

// processTypes will do all the new SQL and array updates.
$requery_sql = processInput("drinkTypes", $mysqli, $_POST, $drink_type_rule, $drinksSQL, $drinksPOST);
if($requery_sql){$drinksSQL = sqlToSmallTable($mysqli, 'drinkTypes');}

// Now that any updates are tested for, do the final build of the object.
$drinksMERGE = mergeTwoDArrays($drinksSQL, $drinksPOST);
$drinksTYPE = setSmallTypes($drinksMERGE, $drinksPOST, $drink_type_rule, $addNew=true, $count=2);
// ************************************************************************** //

