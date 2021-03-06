<?php
/* The handler for the dish menu on the food management screen
 */
// *** Open the Database Connection and Select the Correct DB credientals *** //

$db_cred = $MENU_CREDS;
include_once("../../include/config.php");
require_once(INCLUDES."db_con.php");
include_once(SCAFFOLDING_ADMIN."admin.include.php");
include_once(PROCESSING_ADMIN."table.processing.php");

// ************************************************************************** //


// ************* Dish invokation Rules. To format the Model **************** //

// the type definers for the active array
$dishes_edit = array( "Id" => array("id" => "id"), // id
                      "Plate"=> array("food_name" => "text, value"), // plain
                      "Type" => array("food_type_name" => "select, 1"), //select
                      "Price" => array("food_price" =>
                                       "number, value, .01, 8"), // number
                      "Edit" => array("edit" => "button, large, active, disabled"),  // button
                      "newrow" => array("newrow" => "newrow"),
                      "spacer" => array("spacer" => "plain"),  // plain
                      "food_desc" =>array("food_desc" =>
                                          "textarea, value, 3, 4"), // text area
                      "addnew" => array("addrow" => "newrow"), 
                      "new_id" => array("new_id" => "plain"),
                      "s1" => array("s1" => "plain"),
                      "s2" => array("s2" => "plain"),
                      "s3" => array("s3" => "plain"),
                      "add" => array("add" => "button, large")
                    );

                    
// the type definers for the static array
$dishes_display = array("Id" => array("id" => "id"), // id
                        "Plate"=> array("food_name" => "plain"), // plain
                        "Type" => array("food_type_name" => "plain"), //select
                        "Price" => array("food_price" => "plain"), // number
                        "Edit" => array("edit" => "button, large"),  // button
                        "addnew" => array("addrow" => "newrow"), 
                        "new_id" => array("new_id" => "plain"),
                        "s1" => array("s1" => "plain"),
                        "s2" => array("s2" => "plain"),
                        "s3" => array("s3" => "plain"),
                        "add" => array("add" => "button, large")
                        );



// ************************************************************************** //


// ************************* Selector Contstruction ************************* //
$types_info = array("foodtype", "id", "food_type_name");
$dish_selector = make_selector($mysqli, $types_info[0], $types_info[1], $types_info[2]);
$dish_selectors = array($types_info[2] => $dish_selector);
// ************************************************************************** //


// ****************************** Templates ******************************** //
$dish_templates = array( array("id" => "",
                               "food_name" => "",
                               "food_type_name" =>$dish_selector,
                               "food_price" =>"",
                               "edit" => "Edit",
                               "newrow" => "newrow",
                               "spacer" => "",
                               "food_desc" => ""),
                         array("id" => "",
                               "food_name" => "",
                               "food_type_name" =>"",
                               "food_price" =>"",
                               "edit" => "Edit"),
                         array("addrow" => "newrow",
                               "new_id" => "+",
                               "s1" => "",
                               "s2" => "",
                               "s3" => "",
                               "add" => "add")  // button)
                         );
// ************************************************************************** //


// ********** Generating the drink model. View invoked in index. ************ //

// make the two arrays of contents match in format
$dishSQL = sqltoTable($mysqli, 'dishtype', 'id', null, true);
$dishPOST = postToTable($_POST, 'dishtype');

// processTypes will do all the new SQL and array updates.
$requery_sql = processInput("dishtype", $mysqli, $_POST, $dish_templates, $dishSQL, $dishPOST, 'id', true);
if($requery_sql){$dishSQL = sqlToTable($mysqli, 'dishtype', 'id', null, true);}

// Now that any updates are tested for, do the final build of the object.
$dishMERGE = mergeTwoDArrays($dishSQL, $dishPOST);
$dishTYPE = getActiveMembers($dishPOST);

// Make the final output
$dishPROCESSED = make_table_output($dishMERGE, $dishTYPE, $dish_templates, $dish_selectors, $add=true);

// ************************************************************************** //

// ************ Generating the dish view and invoking it here. ************** //

// Dish Display and Editing Panel //
$dishes = new PanelTable("dishtype", $dishPROCESSED,
                         $dishes_display, $dishes_edit,
                         $dishTYPE);
// width formating
$dishes->setCellClass("food_name", "col-xs-3");
$dishes->setCellClass("food_type_name", "col-xs-3");
$dishes->setCellClass("food_price", "col-xs-3");

//add final button
$dishes->addCellButton("food_desc", "drop", "Drop", "large");

// make the panel wrapper
$dishesPanel = new Panel("Dishes", $dishes);
$dishesPanel->addButton();

// Display The Panel //
echo $dishesPanel;

// ************************************************************************** //