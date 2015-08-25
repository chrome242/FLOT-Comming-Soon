<?php
/* The wines view for the management tab
 */

 
// *** Open the Database Connection and Select the Correct DB credientals *** //
include_once("../../include/config.php");
include_once(SCAFFOLDING_ADMIN."admin.include.php");
$db_cred = $MENU_CREDS;
require_once(INCLUDES."db_con.php");
include_once(PROCESSING_ADMIN."table.processing.php");

// ************************************************************************** //


// *********** Wine Glass invokation Rules. To format the Model ************ //

// the type definers for the active array
$wines_edit   =  array("Id" => array("id" => "id"),
                      "Winery" => array("winery_name" => 'select'),
                      "Wine" => array('wine_name' => 'text, value'),
                      "Year" => array('wine_year' => 'number, value, 1, none'),
                      "Price" => array('wine_glass_price' => 'number, value, .01'),
                      "Bottle Price" => array('wine_bottle_price' => 'number, value, .01'),
                      "Stocked" => array("wine_stock" => 'checkbox'),
                      "Edit" => array("edit" => 'button, large, active, disabled'),
                      "newrow" => array("newrow" => "newrow"),
                      "spacer" => array("spacer" => "plain"),  // plain
                      "wine_type_name" => array("wine_type_name"=> "select"),
                      "wine_desc" => array("wine_desc" => "textarea, value, 3, 6"),
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
$wines_display =  array( "Id" => array("id" => "id"),
                        "Winery" => array("winery_name" => 'plain'),
                        "Wine" => array('wine_name' => 'plain'),
                        "Year" => array('wine_year' => 'plain'),
                        "Price" => array('wine_glass_price' => 'plain'),
                        "Bottle Price" => array('wine_bottle_price' => 'plain'),
                        "Stocked" => array("wine_stock" => 'checkbox, off'),
                        "Edit" => array("edit" => 'button, large'),
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
$winery_selector = make_selector($mysqli, $winery_info);
$wine_type_info = array("winetypes", "id", "wine_type_name");
$wine_type_selector = make_selector($mysqli, $wine_type_info);
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

// Make the table, echo it out
$wines = new Table("wines", $winesPROCESSED,
                         $wines_display, $wines_edit,
                         $winesTYPE);
$wines->setCellClass("winery_name", "col-xs-2");
$wines->setCellClass("wine_name", "col-xs-2");
$wines->setCellClass("wine_year", "col-xs-2");
$wines->addCellButton("wine_desc", "drop", "Drop", "large");//add final button
echo $wines;

// ************************************************************************** //

