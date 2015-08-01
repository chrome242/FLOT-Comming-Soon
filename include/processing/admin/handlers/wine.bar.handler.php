<?php

// *** Open the Database Connection and Select the Correct DB credientals *** //

$db_cred = unserialize(MENU_ADMIN_CREDENTIALS);
require_once(INCLUDES."db_con.php");
include_once(PROCESSING_ADMIN."table.processing.php");

// ************************************************************************** //


// *********** Wine Glass invokation Rules. To format the Model ************ //

// the type definers for the active array
$wines_view   =  array("Id" => array("id" => "id"),
                      "Winery" => array("winery_name" => 'select'),
                      "Wine" => array('wine_name' => 'text, value'),
                      "Year" => array('wine_year' => 'number, value, 1, none'),
                      "Stocked" => array("wine_stock" => 'checkbox')
                      );

// ************************************************************************** //


// ****************************** Templates ******************************** //
// edit disp add
$wines_templates = array( array( "id" => "",
                                "winery_name" => $winery_selector,
                                "wine_name" => "",
                                "wine_year" => "",
                                "wine_stock" => true),
                          array( "id" => "",
                                "winery_name" => $winery_selector,
                                "wine_name" => "",
                                "wine_year" => "",
                                "wine_stock" => true),
                          array("addrow" => "newrow",
                                "new_id" => "+",
                                "s1" => "",
                                "add" => "add")  // button)
                       );
// ************************************************************************** //


// ********** Generating the winery model. View invoked in index. ********** //

// make the two arrays of contents match in format
$winesSQL = sqltoTable($mysqli, 'wines', 'id', null, true);
$winesPOST = postToTable($_POST, 'wines');

// processTypes will do all the new SQL and array updates.
$requery_sql = processInput("wines", $mysqli, $_POST, $wines_templates,
                            $winesSQL, $winesPOST, 'id', true);
if($requery_sql){$winesSQL = sqlToTable($mysqli, 'wines',
                                          'id', null, true);}

// Now that any updates are tested for, do the final build of the object.
$winesMERGE = mergeTwoDArrays($winesSQL, $winesPOST);
$winesTYPE = getActiveMembers($winesPOST);

// Make the final output
$winesPROCESSED = make_table_output($winesMERGE, $winesTYPE,
                                      $wines_templates, null,
                                      $add=false);

// ************************************************************************** //

