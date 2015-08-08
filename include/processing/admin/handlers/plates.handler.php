<?php
/*The plate type menu division view.
 */
// *** Open the Database Connection and Select the Correct DB credientals *** //

$db_cred = unserialize(MENU_ADMIN_CREDENTIALS);
require_once(INCLUDES."db_con.php");
include_once(PROCESSING_ADMIN."smallTable.processing.php");

// ************************************************************************** //


// ************* Plate invokation Rules. To format the Model **************** //
$dish_type_rules = array("food_type_name" =>array(
                          "active" => ["editText", false],
                          "static" => ["editPlain", false],
                          "new" => ["addText", false])
                        );
// ************************************************************************** //

                        
// ********** Generating the plate model. View invoked in index. ************ //

// make the two arrays of contents match in format
//$platesSQL = $test_food_trial;
$platesSQL = sqlToSmallTable($mysqli, 'foodType');
$platesPOST = postToSmallTable($_POST, 'foodType');

// processTypes will do all the new SQL and array updates.
$requery_sql = processInput("foodType", $mysqli, $_POST, $dish_type_rules, $platesSQL, $platesPOST);
if($requery_sql){$platesSQL = sqlToSmallTable($mysqli, 'foodType');}

// Now that any updates are tested for, do the final build of the object.
$platesMERGE = mergeTableArrays($platesSQL, $platesPOST);
$platesTYPE = setSmallTypes($platesMERGE, $platesPOST, $dish_type_rules, $addNew=true, $count=1);
// ************************************************************************** //

