<?php
/* The drink size menu sort view.
 */

// *** Open the Database Connection and Select the Correct DB credientals *** //

include_once("../../include/config.php");
$db_cred = $MENU_CREDS;
require_once(INCLUDES."db_con.php");
include_once(SCAFFOLDING_ADMIN."admin.include.php");
include_once(PROCESSING_ADMIN."listView.processing.php");

// ************************************************************************** //


// ************* Wine invokation Rules. To format the Model **************** //
$size_rule_type = array("drink_size_val" =>array(
                          "active" => "edit",
                          "static" => "text",
                          "new" => "new"));

$size_default='text';
$size_desc_field = "drink_size_val";
// ************************************************************************** //

// ********** Generating the drink model. View invoked in index. ************ //

// make the two arrays of contents match in format
$sizesSQL = sqlToSmallTable($mysqli, 'sizetypes');
$sizesPOST = postToSmallTable($_POST, 'sizetypes');

// processTypes will do all the new SQL and array updates.
$requery_sql = processInput("sizetypes", $mysqli, $_POST, $size_rule_type, $sizesSQL, $sizesPOST);
if($requery_sql){$sizesSQL = sqlToSmallTable($mysqli, 'sizetypes');}

// Now that any updates are tested for, do the final build of the object.
$sizesMERGE = mergeTwoDArrays($sizesSQL, $sizesPOST);
$sizesTYPE = setSmallTypes($sizesMERGE, $sizesPOST, $size_rule_type, $addNew=true, $count=0);
$WRAPPED_sizesTYPE = make_special_list($sizesTYPE, $size_desc_field, $size_default);
$WRAPPED_sizesMERGE = elevate_field_array($sizesMERGE, $size_desc_field);

// ************************************************************************** //


// ********** Generating the drink size view and invoking it here. ********** //
$sizes = new ListView("sizetypes", $WRAPPED_sizesMERGE, $special=$WRAPPED_sizesTYPE,
                      $size_default, $size_desc_field);
$sizePanel = new Panel("Glasses, Jugs, &amp; Mugs", $sizes, $size="half");
$sizePanel->addButton();

// Display The Panel
echo $sizePanel;

// ************************************************************************** //
