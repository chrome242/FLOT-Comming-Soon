<?php

// *** Open the Database Connection and Select the Correct DB credientals *** //

$db_cred = unserialize(MENU_ADMIN_CREDENTIALS);
$BEER_TABLE_CALL = true; // needed for all beer tables to include time handler fnxs
require_once(INCLUDES."db_con.php");
include_once(PROCESSING_ADMIN."table.processing.php");

// ************************************************************************** //


// ********* Beer inventory invokation Rules. To format the Model *********** //

// the type definers for the active array

$beer_display = array("Id" => array("id" => "id"),
                      "Brewery" => array("brewery_name" => "plain"),
                      "Beer" => array("beer_name" => "plain"),
                      "On Tap" =>  array("beer_status" => "radio, 4"),
                      "On Deck" => 2,
                      "Kicked" => 3,
                      "Off Line" => 4,
                      "beer_ontap" => array("beer_ontap" => "time, private"),
                      "beer_offtap" => array("beer_offtap" => "time, private")
                     );

// ************************************************************************** //


// ************************* Selector Contstruction ************************* //
$brewery_info = array("breweries", "id", "brewery_name");
$brewery_selector = make_selector($mysqli, $brewery_info);

$beers_selectors = array($brewery_info[2] => $brewery_selector);
// ************************************************************************** //


// ****************************** Templates ******************************** //
// edit disp add
$beers_templates = array( array( "id" => "",
                                "brewery_name" => $brewery_selector,
                                "beer_name" => "",
                                "beer_status" => "",
                                "beer_ontap" => "1",
                                "beer_offtap" => "1",
                                ),
                          array("id" => "",
                                "brewery_name" => $brewery_selector,
                                "beer_name" => "",
                                "beer_status" => "",
                                "beer_ontap" => "1",
                                "beer_offtap" => "1",
                                ),
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
                                      $add=false);

// ************************************************************************** //

