<?php

// *** Open the Database Connection and Select the Correct DB credientals *** //

$db_cred = unserialize(MENU_ADMIN_CREDENTIALS);
require_once(INCLUDES."db_con.php");
include_once(PROCESSING_ADMIN."listView.processing.php");

// ************************************************************************** //


// ************* Drink invokation Rules. To format the Model **************** //
$wine_rule_type = array("active" => "edit",
                        "static" => "text",
                        "new" => "new");
// ************************************************************************** //

// ********** Generating the drink model. View invoked in index. ************ //

// make the two arrays of contents match in format
//$platesSQL = $test_food_trial;
$drinksSQL = sqlToSmallTable($mysqli, 'drinkTypes');
$drinksPOST = postToSmallTable($_POST, 'drinkTypes');

// processTypes will do all the new SQL and array updates.
$requery_sql = processInput("drinkTypes", $mysqli, $_POST, $drink_type_rule, $drinksSQL, $drinksPOST);
if($requery_sql){$drinksSQL = sqlToSmallTable($mysqli, 'drinkTypes');}

// Now that any updates are tested for, do the final build of the object.
$drinksMERGE = mergeTwoDArrays($drinksSQL, $drinksPOST);
$drinksTYPE = setSmallTypes($drinksMERGE, $drinksPOST, $drink_type_rule, $addNew=true, $count=2);
// ************************************************************************** //

