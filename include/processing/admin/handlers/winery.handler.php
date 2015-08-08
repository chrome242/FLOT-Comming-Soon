<?php
/* The Winery edit view
 */

 
// *** Open the Database Connection and Select the Correct DB credientals *** //

$db_cred = unserialize(MENU_ADMIN_CREDENTIALS);
require_once(INCLUDES."db_con.php");
include_once(PROCESSING_ADMIN."table.processing.php");

// ************************************************************************** //


// ************* Breweries invokation Rules. To format the Model ************ //

// the type definers for the active array
$winery_edit  = array( "Id" => array("id" => 'id'),
                        "Name" => array("winery_name" => 'text, value'),
                        "Region" => array("winery_city" => 'text, value'),
                        "State" => array("state_name" => "select, 1"),
                        "Website" => array("winery_url" => 'text, value'),
                        "Edit" => array("edit" => "button, large, active, disabled"),
                        "newrow" => array("newrow" => "newrow"),
                        "spacer" => array("spacer" => "plain"),  // plain
                        "winery_desc" => array("winery_desc" => "textarea, value, 3, 4"),
                        "drop" => array("drop" => "button, large"),
                        "addrow" => array("addrow" => "newrow"),
                        "new_id" => array("new_id" => "plain"),
                        "s1" => array("s1" => "plain"),
                        "s2" => array("s2" => "plain"),
                        "s3" => array("s3" => "plain"),
                        "s4" => array("s4" => "plain"),
                        "add" => array("add" => "button, large")
                   );

                    
// the type definers for the static array
$winery_display = array("Id" => array("id" => 'id'),
                         "Name" => array("winery_name" => 'plain'),
                         "Region" => array("winery_city" => 'plain'),
                         "State" => array("state_name" => 'plain'),
                         "Website" => array("winery_url" => 'url'),
                         "Edit" => array("edit" => "button, large"),
                         "addrow" => array("addrow" => "newrow"),
                         "new_id" => array("new_id" => "plain"),
                         "s1" => array("s1" => "plain"),
                         "s2" => array("s2" => "plain"),
                         "s3" => array("s3" => "plain"),
                         "s4" => array("s4" => "plain"),
                         "add" => array("add" => "button, large")
                   );


// ************************************************************************** //


// ************************* Selector Contstruction ************************* //
$state_info = array("state", "id", "state_name");
$state_selector = make_selector($mysqli, $state_info[0],
                                $state_info[1], $state_info[2]);
$winery_selectors = array($state_info[2] => $state_selector);
// ************************************************************************** //


// ****************************** Templates ******************************** //
$winery_templates = array( array("id" => "",
                                  "winery_name" => "",
                                  "winery_city" => "",
                                  "state_name" =>$state_selector,
                                  "winery_url" =>"",
                                  "edit" => "Edit",
                                  "newrow" => "newrow",
                                  "spacer" => "",
                                  "winery_desc" => "",
                                  "drop" => "Drop"),
                            array("id" => "",
                                  "winery_name" => "",
                                  "winery_city" => "",
                                  "state_name" =>$state_selector,
                                  "winery_url" =>"",
                                  "edit" => "Edit"),
                            array("addrow" => "newrow",
                                  "new_id" => "+",
                                  "s1" => "",
                                  "s2" => "",
                                  "s3" => "",
                                  "s4" => "",
                                  "add" => "add")  // button)
                         );
// ************************************************************************** //


// ********** Generating the winery model. View invoked in index. ********** //

// make the two arrays of contents match in format
$winerySQL = sqltoTable($mysqli, 'wineries', 'id', null, true);
$wineryPOST = postToTable($_POST, 'wineries');

// processTypes will do all the new SQL and array updates.
$requery_sql = processInput("wineries", $mysqli, $_POST, $winery_templates,
                            $winerySQL, $wineryPOST, 'id', true);
if($requery_sql){$winerySQL = sqlToTable($mysqli, 'wineries',
                                          'id', null, true);}

// Now that any updates are tested for, do the final build of the object.
$wineryMERGE = mergeTwoDArrays($winerySQL, $wineryPOST);
$wineryTYPE = getActiveMembers($wineryPOST);

// Make the final output
$wineryPROCESSED = make_table_output($wineryMERGE, $wineryTYPE,
                                      $winery_templates, $winery_selectors,
                                      $add=true);

// ************************************************************************** //

