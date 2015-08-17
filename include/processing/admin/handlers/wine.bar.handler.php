<?php
/* The Wine view for the active inventory tab.
 */
// *** Open the Database Connection and Select the Correct DB credientals *** //

$db_cred = $MENU_CREDS;
require_once(INCLUDES."db_con.php");
include_once(PROCESSING_ADMIN."table.processing.php");

// ************************************************************************** //


// ********** Wine inventory invokation Rules. To format the Model ********** //

// the type definers for the active array
$wines_view   =  array("Id" => array("id" => "id"),
                      "Winery" => array("winery_name" => 'plain'),
                      "Wine" => array('wine_name' => 'plain'),
                      "Year" => array('wine_year' => 'plain'),
                      "Stocked" => array("wine_stock" => 'checkbox')
                      );

// ************************************************************************** //


// ************************* Selector Contstruction ************************* //
$winery_info = array("wineries", "id", "winery_name");
$winery_selector = make_selector($mysqli, $winery_info);
$wines_selectors = array($winery_info[2] => $winery_selector);
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


// ********** Generating the Wines model. View invoked in index. ************ //

// make the two arrays of contents match in format
$winesSQL = sqltoTable($mysqli, 'wines', 'id', null, true);
$winesPOST = postToTable($_POST, 'wines');

// processTypes will do all the new SQL and array updates.
$requery_sql = processInput("wines", $mysqli, $_POST, $wines_templates,
                            $winesSQL, $winesPOST, 'id', true, false);
if($requery_sql){$winesSQL = sqlToTable($mysqli, 'wines',
                                          'id', null, true);}

// Now that any updates are tested for, do the final build of the object.
$winesMERGE = mergeTwoDArrays($winesSQL, $winesPOST);
$winesTYPE = getActiveMembers($winesPOST);

// Make the final output
$winesPROCESSED = make_table_output($winesMERGE, $winesTYPE,
                                      $wines_templates, $wines_selectors,
                                      $add=false);

// ************************************************************************** //

