<?php
/* For the bewery view for the Brewery management tab of the manage drinks
 * section.
 */

// *** Open the Database Connection and Select the Correct DB credientals *** //
include_once("../../include/config.php");
include_once(SCAFFOLDING_ADMIN."admin.include.php");
$db_cred = $MENU_CREDS;
require_once(INCLUDES."db_con.php");
include_once(PROCESSING_ADMIN."table.processing.php");

// ************************************************************************** //


// ************* Breweries invokation Rules. To format the Model ************ //

// the type definers for the active array
$brewery_edit  = array( "Id" => array("id" => 'id'),
                        "Name" => array("brewery_name" => 'text, value'),
                        "City" => array("brewery_city" => 'text, value'),
                        "State" => array("state_name" => "select, 32"),
                        "Website" => array("brewery_url" => 'text, value'),
                        "Edit" => array("edit" => "button, large, active, disabled"),
                        "newrow" => array("newrow" => "newrow"),
                        "spacer" => array("spacer" => "plain"),  // plain
                        "brewery_desc" => array("brewery_desc" => "textarea, value, 3, 4"),
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
$brewery_display = array("Id" => array("id" => 'id'),
                         "Name" => array("brewery_name" => 'plain'),
                         "City" => array("brewery_city" => 'plain'),
                         "State" => array("state_name" => 'plain'),
                         "Website" => array("brewery_url" => 'url'),
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
$brewery_selectors = array($state_info[2] => $state_selector);
// ************************************************************************** //


// ****************************** Templates ******************************** //
$brewery_templates = array( array("id" => "",
                                  "brewery_name" => "",
                                  "brewery_city" => "",
                                  "state_name" =>$state_selector,
                                  "brewery_url" =>"",
                                  "edit" => "Edit",
                                  "newrow" => "newrow",
                                  "spacer" => "",
                                  "brewery_desc" => "",
                                  "drop" => "Drop"),
                            array("id" => "",
                                  "brewery_name" => "",
                                  "brewery_city" => "",
                                  "state_name" =>$state_selector,
                                  "brewery_url" =>"",
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


// ********** Generating the brewery model. View invoked in index. ********** //

// make the two arrays of contents match in format
$brewerySQL = sqltoTable($mysqli, 'breweries', 'id', null, true);
$breweryPOST = postToTable($_POST, 'breweries');

// processTypes will do all the new SQL and array updates.
$requery_sql = processInput("breweries", $mysqli, $_POST, $brewery_templates,
                            $brewerySQL, $breweryPOST, 'id', true);
if($requery_sql){$brewerySQL = sqlToTable($mysqli, 'breweries',
                                          'id', null, true);}

// Now that any updates are tested for, do the final build of the object.
$breweryMERGE = mergeTwoDArrays($brewerySQL, $breweryPOST);
$breweryTYPE = getActiveMembers($breweryPOST);

// Make the final output
$breweryPROCESSED = make_table_output($breweryMERGE, $breweryTYPE,
                                      $brewery_templates, $brewery_selectors,
                                      $add=true);

// Make the table, echo it out
$brewery = new Table("breweries", $breweryPROCESSED,
                         $brewery_display, $brewery_edit,
                         $breweryTYPE);
echo $brewery;
// ************************************************************************** //

