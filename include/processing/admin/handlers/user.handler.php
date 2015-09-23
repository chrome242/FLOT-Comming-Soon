<?php
/* The user group view
 */

// *** Open the Database Connection and Select the Correct DB credientals *** //

// Will be usings the login script db con
include_once("../../include/config.php");
include_once(SCAFFOLDING_ADMIN."admin.include.php");
include_once(PROCESSING_ADMIN."table.processing.php");


// ************************************************************************** //


// *********** User Group invokation Rules. To format the Model ************ //

// the type definers for the active array
$users_edit = array("Id" => array("id" => "id"),
                    "Name" => array("username" => "plain"),
                    "Group" => array("user_groups" => "select, 1"),
                    "Email" => array("email" => "plain"),
                    "Password Reset" => array("new_pw" => "modal, large"),
                    "Edit" => array("edit" => "modal, large"),
                    "Drop" => array("drop" => "modal, large"),
                    "newrow" => array("newrow" => "newrow"),
                    "new_id" => array("new_id" => "plain"),
                    "s1" => array("s1" => "plain"),
                    "s2" => array("s2" => "plain"),
                    "s3" => array("s3" => "plain"),
                    "s4" => array("s4" => "plain"),
                    "s5" => array("s5" => "plain"),// call x5
                    "add" => array("add" => "modal, large")
                    );
$users_disp = array("Id" => array("id" => "id"),
                    "Name" => array("username" => "plain"),
                    "Group" => array("user_groups" => "plain"),
                    "Email" => array("email" => "plain"),
                    "Password Reset" => array("new_pw" => "modal, large"),
                    "Edit" => array("edit" => "modal, large"),
                    "Drop" => array("drop" => "modal, large"),
                    "newrow" => array("newrow" => "newrow"),
                    "new_id" => array("new_id" => "plain"),
                    "s1" => array("s1" => "plain"),
                    "s2" => array("s2" => "plain"),
                    "s3" => array("s3" => "plain"),
                    "s4" => array("s4" => "plain"),
                    "s5" => array("s5" => "plain"),// call x5
                    "add" => array("add" => "modal, large")
                    );

// ************************************************************************** //


// ************************* Selector Contstruction ************************* //
$usergroup_info = array("user_groups", "id", "group_name");
$usergroup_selector = make_selector($mysqli=$mysqli_sec, $table=$usergroup_info);

$group_selector = array($usergroup_info[2] => $usergroup_selector);
// ************************************************************************** //


// ****************************** Templates ******************************** //
// edit disp add
$user_templates = array( array( "id" => "",
                                "username" => "",
                                "user_group" => "",
                                "email" => "",
                                "new_pw" => "New Password",
                                "edit" => "Edit",
                                "drop" => "Drop"),
                          array( "id" => "",
                                "username" => "",
                                "user_group" => "",
                                "email" => "",
                                "new_pw" => "New Password",
                                "edit" => "Edit",
                                "drop" => "Drop"),
                          array("addrow" => "newrow",
                                "new_id" => "+",
                                "s1" => "",
                                "s2" => "",
                                "s3" => "",
                                "s4" => "",
                                "s5" => "",
                                "add" => "Add")  // button)
                       );
// ************************************************************************** //


// ********* Generating the usergroup model. View invoked in index. ********* //


// make the two arrays of contents match in format
$users_SQL = sqltoTable($mysqli=$mysqli_sec, $table='members', $id='id', $fields=null, $internal_id=true);
$users_POST = postToTable($post=$_POST, $formname='members');


// processTypes will do all the new SQL and array updates.
$requery_sql = processInput($form_name="members", $sql_obj=$mysqli_sec, $post_array=$_POST, $type_rules=$user_templates,
                            $processedSQL=$users_SQL, $processedPOST=$users_POST, $pkay='id', $full=true);
if($requery_sql){$users_SQL = sqlToTable($mysqli=$mysqli_sec, $table='members',
                                          $id='id', $fields=null, $interal_id=true);}

// Now that any updates are tested for, do the final build of the object.
$usersMERGE = mergeTwoDArrays($static_source=$users_SQL, $active_source=$users_POST);
$usersTYPE = getActiveMembers($postArray=$users_POST);

// Make the final output
$usersPROCESSED = make_table_output($usersMERGE, $usersTYPE,
                                      $user_templates, $selects_array=$group_selector,
                                      $add=true);

// ************************************************************************** //



// ********** Generating the usergroup view and invoking it here. *********** //

$members = new Table("members", $usersPROCESSED,
                         $users_disp, $users_disp,
                         $usersTYPE);
$members->submitOff();
echo $members;
// ************************************************************************** //
