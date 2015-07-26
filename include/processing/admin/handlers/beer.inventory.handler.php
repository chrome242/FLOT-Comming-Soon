<?php

// *** Open the Database Connection and Select the Correct DB credientals *** //

$db_cred = unserialize(MENU_ADMIN_CREDENTIALS);
require_once(INCLUDES."db_con.php");
include_once(PROCESSING_ADMIN."table.processing.php");

// ************************************************************************** //


// *********** Wine Glass invokation Rules. To format the Model ************ //

// the type definers for the active array
$beer_edit = array( "beer_offtap" => array("beer_offtap" => "time, private"),
                    "beer_ontap" => array("beer_ontap" => "time, private"),
                    "Id" => array("id" => "id"),
                    "Brewery" => array("brewery_name" => "select"),
                    "Beer" => array("beer_name" => "text, value"),
                    "Status" => array("beer_status" => "select"),
                    "ABV" => array("beer_abv" => "number, value, .001"),
                    "Size" => array("drink_size_val" => "select"),
                    "Price" => array("beer_price" => "number, value, .01"),
                    "Time on Tap" => array("process_time", "timestamp, beer_offtap, beer_ontap"),
                    "Edit" => array("edit" => "button, large"),
                    "nextrow" => array('nextrow' => "newrow"),
                    "beer_type" => array("drink_type_name"=> "select"),
                    "beer_desc" => array("beer_desc" => "textarea, value, 3, 6"),
                    "drop" => array("drop" => "button, large"),
                    "addrow" => array("addrow" => "newrow"),
                    "new_id" => array("new_id" => "plain"),
                    "s1" => array("s1" => "plain"),
                    "s2" => array("s2" => "plain"),
                    "s3" => array("s3" => "plain"),
                    "s4" => array("s4" => "plain"),
                    "s5" => array("s5" => "plain"),
                    "s6" => array("s6" => "plain"),
                    "add" => array("add" => "button, large")
                     );     
                   
// the type definers for the static array
$beer_display = array("beer_offtap" => array("beer_offtap" => "time, private"),
                      "beer_ontap" => array("beer_ontap" => "time, private"),
                      "Id" => array("id" => "id"),
                      "Brewery" => array("brewery_name" => "plain"),
                      "Beer" => array("beer_name" => "plain"),
                      "Status" => array("beer_status" => "plain"),
                      "ABV" => array("beer_abv" => "plain"),
                      "Size" => array("drink_size_val" => "plain"),
                      "Price" => array("beer_price" => "plain"),
                      "Time on Tap" => array("process_time", "timestamp, beer_offtap, beer_ontap"),
                      "Edit" => array("edit" => "button, large"),
                      "addrow" => array("addrow" => "newrow"),
                      "new_id" => array("new_id" => "plain"),
                      "s1" => array("s1" => "plain"),
                      "s2" => array("s2" => "plain"),
                      "s3" => array("s3" => "plain"),
                      "s4" => array("s4" => "plain"),
                      "s5" => array("s5" => "plain"),
                      "s6" => array("s6" => "plain"),
                      "add" => array("add" => "button, large")
                     );

// ************************************************************************** //


// ************************* Selector Contstruction ************************* //
$winery_info = array("wineries", "id", "winery_name");
$winery_selector = make_selector($mysqli, $winery_info[0],
                                $winery_info[1], $winery_info[2]);
$wine_type_info = array("wineTypes", "id", "wine_type_name");
$wine_type_selector = make_selector($mysqli, $wine_type_info[0],
                                $wine_type_info[1], $wine_type_info[2]);
$wines_selectors = array($winery_info[2] => $winery_selector,
                          $wine_type_info[2] => $wine_type_selector);
// ************************************************************************** //


// ****************************** Templates ******************************** //
// edit disp add
$wines_templates = array( array( "id" => "",
                                "winery_name" => $winery_selector,
                                "wine_name" => "",
                                "wine_year" => "",
                                "wine_glass_price" => "",
                                "wine_bottle_price" => "",
                                "wine_stock" => true,
                                "edit" => "Edit",
                                "newrow" => "newrow",
                                "spacer" => "",
                                "wine_type_name" => $wine_type_selector,
                                "wine_desc" => ""),
                          array("id" => "",
                                "winery_name" => $winery_selector,
                                "wine_name" => "",
                                "wine_year" => "",
                                "wine_glass_price" => "",
                                "wine_bottle_price" => "",
                                "wine_stock" => true,
                                "edit" => "Edit"),
                          array("addrow" => "newrow",
                                "new_id" => "+",
                                "s1" => "",
                                "s2" => "",
                                "s3" => "",
                                "s4" => "",
                                "s5" => "",
                                "s6" => "",
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
                                      $wines_templates, $wines_selectors,
                                      $add=true);

// ************************************************************************** //

