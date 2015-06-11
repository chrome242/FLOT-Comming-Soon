
<?php

//****************** Configuration & Inclusions *****************************//
include("../../include/config.php");
include(SCAFFOLDING_ADMIN."admin.include.php"); // centeralized admin includes
//***************************************************************************//

// TODO: Add a test login to redirect function here
// if(!secureCheckLogin($_COOKIE)){header:Admin Login}
  // check to make sure the user is logged in
    // if logged in, check to make sure the token is valid
    // if not logged in, send to the Admin login page
  // if no admin access token, send to Main site

// TODO: Process the user's permission array from the session
// $permissions = $_COOKIE["admin_permissions"];

// TODO: make these buttons work: JS & or PHP
// Page variables

//******************* Header & Format Arrays For Beer Table *****************//

$sectionWrappers = array("userGroups" => ["User Group Definitions", false],
                         "userManagement" => ["User Management", false]);

$groups_edit = array( "Id" => array("rights_id" => "id"), 
                      "Role"=> array("rights_name" => "text, value"), 
                      "Edit Inventory" => array("rights_inventory" => "checkbox"), 
                      "Manage Drinks" => array("rights_drinks" => "checkbox"), 
                      "Manage Extras" => array("rights_extras" => "checkbox"),
                      "Manage Food" => array("rights_food" => "checkbox"),
                      "Add User" => array("rights_add_user" => "checkbox"),
                      "Edit User" => array("rights_edit_user" => "checkbox"),
                      "Edit" => array("edit" => "button, large"), // button
                      "newrow" => array("newrow" => "newrow"),  // here and down are for last row
                      "new_id" => array("new_id" => "plain"),
                      "placeholder1" => array("placeholder1" => "plain"),
                      "placeholder2" => array("placeholder2" => "plain"),
                      "placeholder3" => array("placeholder3" => "plain"),
                      "placeholder4" => array("placeholder4" => "plain"),
                      "placeholder5" => array("placeholder5" => "plain"),
                      "placeholder6" => array("placeholder6" => "plain"),
                      "placeholder7" => array("placeholder7" => "plain"),// call x7
                      "add" => array("add" => "button, large")
                      );

$groups_disp = array( "Id" => array("rights_id" => "id"), 
                      "Role"=> array("rights_name" => "plain"), 
                      "Edit Inventory" => array("rights_inventory" => "checkbox, off"), 
                      "Manage Drinks" => array("rights_drinks" => "checkbox"), 
                      "Manage Extras" => array("rights_extras" => "checkbox"),
                      "Manage Food" => array("rights_food" => "checkbox"),
                      "Add User" => array("rights_add_user" => "checkbox"),
                      "Edit User" => array("rights_edit_user" => "checkbox"),
                      "Edit" => array("edit" => "button, large"), // button
                      "newrow" => array("newrow" => "newrow"),  // here and down are for last row
                      "new_id" => array("new_id" => "plain"),
                      "placeholder1" => array("placeholder1" => "plain"),
                      "placeholder2" => array("placeholder2" => "plain"),
                      "placeholder3" => array("placeholder3" => "plain"),
                      "placeholder4" => array("placeholder4" => "plain"),
                      "placeholder5" => array("placeholder5" => "plain"),
                      "placeholder6" => array("placeholder6" => "plain"),
                      "placeholder7" => array("placeholder7" => "plain"),// call x7
                      "add" => array("add" => "button, large")
                      );

$users_edit = array("Id" => array("user_id" => "id"),
                    "Name" => array("user_name" => "plain"),
                    "Group" => array("user_group" => "select, 1"),
                    "Password" => array("user_password" => "password, placeholder"),
                    "Password Reset" => array("new_pw" => "button, large"),
                    "Edit" => array("edit" => "button, large"),
                    "Drop" => array("drop" => "button, large"),
                    "newrow" => array("newrow" => "newrow"),
                    "new_id" => array("new_id" => "plain"),
                    "placeholder1" => array("placeholder1" => "plain"),
                    "placeholder2" => array("placeholder2" => "plain"),
                    "placeholder3" => array("placeholder3" => "plain"),
                    "placeholder4" => array("placeholder4" => "plain"),
                    "placeholder5" => array("placeholder5" => "plain"),// call x5
                    "add" => array("add" => "button, large")
                    );
$users_disp = array("Id" => array("user_id" => "id"),
                    "Name" => array("user_name" => "plain"),
                    "Group" => array("user_group" => "plain"),
                    "Password" => array("user_password" => "password, value"),
                    "Password Reset" => array("new_pw" => "button, large"),
                    "Edit" => array("edit" => "button, large"),
                    "Drop" => array("drop" => "button, large"),
                    "newrow" => array("newrow" => "newrow"),
                    "new_id" => array("new_id" => "plain"),
                    "placeholder1" => array("placeholder1" => "plain"),
                    "placeholder2" => array("placeholder2" => "plain"),
                    "placeholder3" => array("placeholder3" => "plain"),
                    "placeholder4" => array("placeholder4" => "plain"),
                    "placeholder5" => array("placeholder5" => "plain"),// call x5
                    "add" => array("add" => "button, large")
                    );

//***************************************************************************//


//******************** Open The Page & Display Menu Bar *********************//
$title = "Manage Users";
$section = ADMIN."Users/";
include(SCAFFOLDING."head.php");
echo menubar($permissions, $section, $root);
echo sectionbar($sectionWrappers);

//***************************************************************************//


//***************** Final Variable Processing & Cleaning *******************//
// Fututre home of SQL & $_POST processing methods
$processed_group_cells = $test_group_cells;
$group_special_cells = $test_group_special_cells;
$processed_user_cells = $test_user_cells;
$user_specal_cells = $user_special_cells_test;
//***************************************************************************//


//********************************* Content *********************************//

// User Group drop //
$groupsTable = new Table("userGroups", $processed_group_cells, $groups_disp,
                         $groups_edit, $group_special_cells);

// Echo the wrapped table
echo '      <div class="collapse" id="userGroups"> <!-- Group Definitions -->';
echo $groupsTable;
echo '      </div>';


// User Management drop //
$userTable = new Table("users", $processed_user_cells, $users_disp,
                       $users_edit, $user_special_cells);

// Echo the wrapped table
echo '      <div class="collapse" id="userManagement"> <!-- Users -->';
echo $userTable;
echo '      </div>';

//***************************************************************************//


//********************************TEST***************************************//

/* The array will have to be processed in the following way:
 * first, check for an add. If add exist, then 
 */
if(isset($_POST)){
  echo "Post contents:<br><pre>";
  var_dump($_POST);
  echo "</pre>";
  
}


//******************************** Footer ***********************************//
include(SCAFFOLDING_ADMIN."footer.php");
//***************************************************************************//

 

