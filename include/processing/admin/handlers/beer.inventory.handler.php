<?php
/* This is full inventory and details editing screen for the beers on the
 * drink management tab. 
 */

// *** Open the Database Connection and Select the Correct DB credientals *** //
include_once("../../include/config.php");
include_once(SCAFFOLDING_ADMIN."admin.include.php");
$db_cred = unserialize(MENU_ADMIN_CREDENTIALS);
require_once(INCLUDES."db_con.php");
include_once(PROCESSING_ADMIN."table.processing.php");

// ************************************************************************** //


// *********** Wine Glass invokation Rules. To format the Model ************ //

// the type definers for the active array
$beer_edit = array( "beer_offtap" => array("beer_offtap" => "time, private"),
                    "beer_ontap" => array("beer_ontap" => "time, private"),
                    "Id" => array("id" => "id"),
                    "Brewery" => array("brewery_name" => "select"), //selector x
                    "Beer" => array("beer_name" => "text, value"),
                    "Status" => array("beer_status" => "select, 2"), //selector x
                    "ABV" => array("beer_abv" => "number, value, .001"),
                    "Size" => array("drink_size_val" => "select"), //selector x
                    "Price" => array("beer_price" => "number, value, .01"),
                    "Time on Tap" => array("process_time" => "duration, beer_ontap, beer_offtap"),
                    "Edit" => array("edit" => "button, large, active, disabled"),
                    "newrow" => array('newrow' => "newrow"),
                    "spacer" => array("spacer" => "plain"),
                    "beer_type" => array("drink_type_name"=> "select"), //selector x
                    "beer_desc" => array("beer_desc" => "textarea, value, 3, 7"),
                    "addrow" => array("addrow" => "newrow"),
                    "new_id" => array("new_id" => "plain"),
                    "s1" => array("s1" => "plain"),
                    "s2" => array("s2" => "plain"),
                    "s3" => array("s3" => "plain"),
                    "s4" => array("s4" => "plain"),
                    "s5" => array("s5" => "plain"),
                    "s6" => array("s6" => "plain"),
                    "s7" => array("s7" => "plain"),
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
                      "Time on Tap" => array("process_time" => "duration, beer_ontap, beer_offtap"),
                      "Edit" => array("edit" => "button, large"),
                      "addrow" => array("addrow" => "newrow"),
                      "new_id" => array("new_id" => "plain"),
                      "s1" => array("s1" => "plain"),
                      "s2" => array("s2" => "plain"),
                      "s3" => array("s3" => "plain"),
                      "s4" => array("s4" => "plain"),
                      "s5" => array("s5" => "plain"),
                      "s6" => array("s6" => "plain"),
                      "s7" => array("s7" => "plain"),
                      "add" => array("add" => "button, large")
                     );

// ************************************************************************** //


// ************************* Selector Contstruction ************************* //
$brewery_info = array("breweries", "id", "brewery_name");
$brewery_selector = make_selector($mysqli, $brewery_info);

$status_column = "beer_status";
$status_selector = array(1 => "On Tap", 2 => "On Deck",
                         3 => "Kicked", 4 => "Off Line");

$size_info = array("sizeTypes", "id", "drink_size_val");
$size_selector = make_selector($mysqli, $size_info);

$type_info = array("drinkTypes", "id", "drink_type_name");
$type_selector = make_selector($mysqli, $type_info);

$beers_selectors = array($brewery_info[2] => $brewery_selector,
                          $status_column => $status_selector,
                          $size_info[2] => $size_selector,
                          $type_info[2] => $type_selector);
// ************************************************************************** //


// ****************************** Templates ******************************** //
// edit disp add
$beers_templates = array( array( "id" => "",
                                "beer_ontap" => "1",
                                "beer_offtap" => "1",
                                "brewery_name" => $brewery_selector,
                                "beer_name" => "",
                                "beer_status" => $status_selector,
                                "beer_abv" => "",
                                "drink_size_val" => $size_selector,
                                "beer_price" => "",
                                "process_time" => "0",
                                "edit" => "Edit",
                                "newrow" => "newrow",
                                "spacer" => "",
                                "drink_type_name" => $type_selector,
                                "beer_desc" => ""),
                          array("id" => "",
                                "beer_ontap" => "1",
                                "beer_offtap" => "1",
                                "brewery_name" => $brewery_selector,
                                "beer_name" => "",
                                "beer_status" => $status_selector,
                                "beer_abv" => "",
                                "drink_size_val" => $size_selector,
                                "beer_price" => "",
                                "process_time" => "0",
                                "edit" => "Edit",),
                          array("addrow" => "newrow",
                                "new_id" => "+",
                                "s1" => "",
                                "s2" => "",
                                "s3" => "",
                                "s4" => "",
                                "s5" => "",
                                "s6" => "",
                                "s7" => "",
                                "add" => "add")  // button)
                       );
// ************************************************************************** //


// ********** Generating the winery model. View invoked in index. ********** //

// make the two arrays of contents match in format
$beersSQL = sqltoTable($mysqli, 'beers', 'id', null, true);
$beersPOST = postToTable($_POST, 'beers');

// for beers- special processing to deal with the tap updates:
timeUpdate($beersPOST, $beersSQL, $same_day=true, $restock=true);

// processTypes will do all the new SQL and array updates.
$requery_sql = processInput("beers", $mysqli, $_POST, $beers_templates,
                            $beersSQL, $beersPOST, 'id', true);
if($requery_sql){$beersSQL = sqlToTable($mysqli, 'beers',
                                          'id', null, true);}

// Now that any updates are tested for, do the final build of the object.
$beersMERGE = mergeTwoDArrays($beersSQL, $beersPOST);
$beersTYPE = getActiveMembers($beersPOST);

// Make the final output
$beersPROCESSED = make_table_output($beersMERGE, $beersTYPE,
                                      $beers_templates, $beers_selectors,
                                      $add=true);

// make the table, echo it out
$beers = new Table("beers", $beersPROCESSED,
                         $beer_display, $beer_edit,
                         $beersTYPE);
$beers->setCellClass("brewery_name", "col-xs-2");
$beers->setCellClass("beer_name", "col-xs-2");
$beers->setCellClass("beer_abv", "col-xs-1");
$beers->setCellClass("beer_price", "col-xs-1");
$beers->addCellButton("beer_desc", "drop", "Drop", "large");//add final button
echo $beers;
// ************************************************************************** //

