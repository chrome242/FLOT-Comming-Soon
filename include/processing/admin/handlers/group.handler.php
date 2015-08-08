<?php
/* The user group view
 */

// *** Open the Database Connection and Select the Correct DB credientals *** //

// Will be usings the login script db con
include_once(PROCESSING_ADMIN."table.processing.php");


// ************************************************************************** //


// *********** User Group invokation Rules. To format the Model ************ //

// the type definers for the active array
$groups_edit = array( "Id" => array("id" => "id"), 
                      "Role"=> array("group_name" => "text, value"), 
                      "Edit Inventory" => array("inventory" => "checkbox"), 
                      "Manage Drinks" => array("drinks" => "checkbox"), 
                      "Manage Extras" => array("extras" => "checkbox"),
                      "Manage Food" => array("food" => "checkbox"),
                      "Add User" => array("add_user" => "checkbox"),
                      "Edit User" => array("edit_user" => "checkbox"),
                      "Edit" => array("edit" => "button, large, active, disabled"), // button
                      "newrow" => array("addrow" => "newrow"),  // here and down are for last row
                      "new_id" => array("new_id" => "plain"),
                      "s1" => array("s1" => "plain"),
                      "s2" => array("s2" => "plain"),
                      "s3" => array("s3" => "plain"),
                      "s4" => array("s4" => "plain"),
                      "s5" => array("s5" => "plain"),
                      "s6" => array("s6" => "plain"),
                      "s7" => array("s7" => "plain"),// call x7
                      "add" => array("add" => "button, large")
                      );

$groups_disp = array( "Id" => array("id" => "id"), 
                      "Role"=> array("group_name" => "plain"), 
                      "Edit Inventory" => array("inventory" => "checkbox, off"), 
                      "Manage Drinks" => array("drinks" => "checkbox, off"), 
                      "Manage Extras" => array("extras" => "checkbox, off"),
                      "Manage Food" => array("food" => "checkbox, off"),
                      "Add User" => array("add_user" => "checkbox, off"),
                      "Edit User" => array("edit_user" => "checkbox, off"),
                      "Edit" => array("edit" => "button, large"), // button
                      "newrow" => array("addrow" => "newrow"),  // here and down are for last row
                      "new_id" => array("new_id" => "plain"),
                      "s1" => array("s1" => "plain"),
                      "s2" => array("s2" => "plain"),
                      "s3" => array("s3" => "plain"),
                      "s4" => array("s4" => "plain"),
                      "s5" => array("s5" => "plain"),
                      "s6" => array("s6" => "plain"),
                      "s7" => array("s7" => "plain"),// call x7
                      "add" => array("add" => "button, large")
                      );;

// ************************************************************************** //


// ****************************** Templates ******************************** //
// edit disp add
$group_templates = array( array( "id" => "",
                                "group_name" => "",
                                "inventory" => "",
                                "drinks" => "",
                                "extras" => "",
                                "food" => "",
                                "add_user" => "",
                                "edit_user" => "",
                                "edit" => "Edit"),
                          array("id" => "",
                                "group_name" => "",
                                "inventory" => "",
                                "drinks" => "",
                                "extras" => "",
                                "food" => "",
                                "add_user" => "",
                                "edit_user" => "",
                                "edit" => "Edit"),
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
$user_groupsSQL = sqltoTable($mysqli_sec, 'user_groups', 'id', null, true);
$user_groupsPOST = postToTable($_POST, 'user_groups');


// processTypes will do all the new SQL and array updates.
$requery_sql = processInput("user_groups", $mysqli_sec, $_POST, $group_templates,
                            $user_groupsSQL, $user_groupsPOST, 'id', true);
if($requery_sql){$user_groupsSQL = sqlToTable($mysqli_sec, 'user_groups',
                                          'id', null, true);}

// Now that any updates are tested for, do the final build of the object.
$user_groupsMERGE = mergeTwoDArrays($user_groupsSQL, $user_groupsPOST);
$user_groupsTYPE = getActiveMembers($user_groupsPOST);

// Make the final output
$user_groupsPROCESSED = make_table_output($user_groupsMERGE, $user_groupsTYPE,
                                      $group_templates, $selects_array=null,
                                      $add=true);

// ************************************************************************** //

