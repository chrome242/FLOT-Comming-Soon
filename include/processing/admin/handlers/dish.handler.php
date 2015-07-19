<?php

// *** Open the Database Connection and Select the Correct DB credientals *** //

$db_cred = unserialize(MENU_ADMIN_CREDENTIALS);
require_once(INCLUDES."db_con.php");
include_once(PROCESSING_ADMIN."table.processing.php");

// ************************************************************************** //


// ************* Dish invokation Rules. To format the Model **************** //

// the type definers for the active array
$dishes_edit = array( "Id" => array("food_id" => "id"), // id
                      "Plate"=> array("food_name" => "text, value"), // plain
                      "Type" => array("food_type" => "select, 1"), //select
                      "Price" => array("food_price" =>
                                       "number, value, .01, 8"), // number
                      "Edit" => array("edit" => "button, large, active"),  // button
                      "newrow" => array("newrow" => "newrow"),
                      "spacer" => array("spacer" => "plain"),  // plain
                      "food_desc" =>array("food_desc" =>
                                          "textarea, value, 3, 4"), // text area
                      "addnew" => array("addrow" => "newrow"), // this and below for last record, to add new
                      "new_id" => array("new_id" => "plain"),
                      "s1" => array("s1" => "plain"),
                      "s2" => array("s2" => "plain"),
                      "s3" => array("s3" => "plain"),
                      "add" => array("add" => "button, large")
                    );

// the type definers for the static array
$dishes_display = array("Id" => array("food_id" => "id"), // id
                        "Plate"=> array("food_name" => "plain"), // plain
                        "Type" => array("food_type" => "plain"), //select
                        "Price" => array("food_price" => "plain"), // number
                        "Edit" => array("edit" => "button, large"),  // button
                        "addnew" => array("addrow" => "newrow"), // this and below for last record, to add new
                        "new_id" => array("new_id" => "plain"),  // all of these will only be shown if there's
                        "s1" => array("s1" => "plain"),          // actually a placeholder value inserted.
                        "s2" => array("s2" => "plain"),
                        "s3" => array("s3" => "plain"),
                        "add" => array("add" => "button, large")
                        );

// to be appended to the end of the last element on the table for the new row.
$dishes_addrow  = array("addrow" => "newrow",
                        "new_id" => "+",
                        "s1" => "",
                        "s2" => "",
                        "s3" => "",
                        "add" => "add");

// to be removed from view only records:
$edit_only_fields = array("food_desc");

// ************************************************************************** //


// ************************* Selector Contstruction ************************* //
$types_info = array("foodType", "id", "food_type_name");
$dish_selector = make_selector($mysqli, $types_info[0], $types_info[1], $types_info[2]);
// ************************************************************************** //


// ********** Generating the drink model. View invoked in index. ************ //

// make the two arrays of contents match in format
$dishSQL = sqlToSmallTable($mysqli, 'dishType');
$dishPOST = postToSmallTable($_POST, 'dishType');
//
//// processTypes will do all the new SQL and array updates.
//$requery_sql = processInput("drinkTypes", $mysqli, $_POST, $drink_type_rule, $drinksSQL, $drinksPOST);
//if($requery_sql){$drinksSQL = sqlToSmallTable($mysqli, 'drinkTypes');}
//
//// Now that any updates are tested for, do the final build of the object.
$dishMERGE = mergeTwoDArrays($dishSQL, $dishPOST);
$dishTYPE = getActiveMembers($dishPOST);

// ************************************************************************** //

