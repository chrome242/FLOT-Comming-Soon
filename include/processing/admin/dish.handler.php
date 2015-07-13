<?php

// *** Open the Database Connection and Select the Correct DB credientals *** //

$db_cred = unserialize(MENU_ADMIN_CREDENTIALS);
require_once(INCLUDES."db_con.php");
include_once(PROCESSING_ADMIN."table.processing.php");

// ************************************************************************** //


// ************* Dish invokation Rules. To format the Model **************** //
$dishes_edit = array( "Id" => array("food_id" => "id"), // id
                      "Plate"=> array("food_name" => "text, value"), // plain
                      "Type" => array("food_type" => "select, 1"), //select
                      "Price" => array("food_price" =>
                                       "number, value, .01, 8"), // number
                      "Edit" => array("edit" => "button, large"),  // button
                      "newrow" => array("newrow" => "newrow"),
                      "spacer" => array("spacer" => "plain"),  // plain
                      "food_desc" =>array("food_desc" =>
                                          "textarea, value, 3, 4"), // text area
                      "addnew" => array("newrow" => "newrow"), // this and below for last record, to add new
                      "new_id" => array("new_id" => "plain"),
                      "s1" => array("s1" => "plain"),
                      "s2" => array("s2" => "plain"),
                      "s3" => array("s3" => "plain"),
                      "add" => array("add" => "button, large")
                    );

$dishes_display = array("Id" => array("food_id" => "id"), // id
                        "Plate"=> array("food_name" => "plain"), // plain
                        "Type" => array("food_type" => "plain"), //select
                        "Price" => array("food_price" => "plain"), // number
                        "Edit" => array("edit" => "button, large"),  // button
                        "addnew" => array("newrow" => "newrow"), // this and below for last record, to add new
                        "new_id" => array("new_id" => "plain"),
                        "s1" => array("s1" => "plain"),
                        "s2" => array("s2" => "plain"),
                        "s3" => array("s3" => "plain"),
                        "add" => array("add" => "button, large")
                        );
// ************************************************************************** //


// ************************* Selector Contstruction ************************* //
$types_info = array("foodtype", "id", "food_type_name");
$test = make_selector($mysqli, $types_info[0], $types_info[1], $types_info[2]);
// ************************************************************************** //


// ********** Generating the drink model. View invoked in index. ************ //

//// make the two arrays of contents match in format
////$platesSQL = $test_food_trial;
//$drinksSQL = sqlToSmallTable($mysqli, 'drinkTypes');
//$drinksPOST = postToSmallTable($_POST, 'drinkTypes');
//
//// processTypes will do all the new SQL and array updates.
//$requery_sql = processInput("drinkTypes", $mysqli, $_POST, $drink_type_rule, $drinksSQL, $drinksPOST);
//if($requery_sql){$drinksSQL = sqlToSmallTable($mysqli, 'drinkTypes');}
//
//// Now that any updates are tested for, do the final build of the object.
//$drinksMERGE = mergeTwoDArrays($drinksSQL, $drinksPOST);
//$drinksTYPE = setSmallTypes($drinksMERGE, $drinksPOST, $drink_type_rule, $addNew=true, $count=2);
// ************************************************************************** //

