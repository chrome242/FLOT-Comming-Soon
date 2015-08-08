<?php
/* the view for the wine menu division tab */

// *** Open the Database Connection and Select the Correct DB credientals *** //

$db_cred = unserialize(MENU_ADMIN_CREDENTIALS);
require_once(INCLUDES."db_con.php");
include_once(PROCESSING_ADMIN."listView.processing.php");

// ************************************************************************** //


// ************* Wine invokation Rules. To format the Model **************** //
$wine_rule_type = array("wine_type_name" =>array(
                          "active" => "edit",
                          "static" => "text",
                          "new" => "new"));

$wine_default='text';
$wine_desc_field = "wine_type_name";
// ************************************************************************** //

// ********** Generating the drink model. View invoked in index. ************ //

// make the two arrays of contents match in format
$winesSQL = sqlToSmallTable($mysqli, 'wineTypes');
$winesPOST = postToSmallTable($_POST, 'wineTypes');

// processTypes will do all the new SQL and array updates.
$requery_sql = processInput("wineTypes", $mysqli, $_POST, $wine_rule_type, $winesSQL, $winesPOST);
if($requery_sql){$winesSQL = sqlToSmallTable($mysqli, 'wineTypes');}

// Now that any updates are tested for, do the final build of the object.
$winesMERGE = mergeTwoDArrays($winesSQL, $winesPOST);
$winesTYPE = setSmallTypes($winesMERGE, $winesPOST, $wine_rule_type, $addNew=true, $count=0);
$WRAPPED_winesTYPE = make_special_list($winesTYPE, $wine_desc_field, $wine_default);
$WRAPPED_winesMERGE = elevate_field_array($winesMERGE, $wine_desc_field);

// ************************************************************************** //

