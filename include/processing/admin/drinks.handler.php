<?php

// *** Open the Database Connection and Select the Correct DB credientals *** //

$db_cred = unserialize(MENU_ADMIN_CREDENTIALS);
require_once(INCLUDES."db_con.php");
include_once(PROCESSING_ADMIN."smallTable.processing.php");

// ************************************************************************** //


// ************* Drink invokation Rules. To format the Model **************** //
$drink_type_rule = array("food_type_name" =>array(
                         "active" => ["editText", false],
                         "static" => ["editPlain", false],
                         "new" => ["addText", false])
                        );
// ************************************************************************** //

                        
// ********** Generating the drink model. View invoked in index. ************ //

// make the two arrays of contents match in format
//$platesSQL = $test_food_trial;
$drinksSQL = sqlToSmallTable($mysqli, 'drinkType');
$drinksPOST = postToSmallTable($_POST, 'drinkType');

// processTypes will do all the new SQL and array updates.
$requery_sql = processInput("drinkType", $mysqli, $_POST, $drink_type_rule, $drinksSQL, $drinksPOST);
if($requery_sql){$platesSQL = sqlToSmallTable($mysqli, 'drinkType');}

// Now that any updates are tested for, do the final build of the object.
$drinksMERGE = mergeTableArrays($drinksSQL, $drinksPOST);
$drinksTYPE = setSmallTypes($drinksMERGE, $drinksPOST, $drink_type_rule, $addNew=true, $count=2);
// ************************************************************************** //

