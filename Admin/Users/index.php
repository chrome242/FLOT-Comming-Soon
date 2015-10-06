<?php

//****************** Configuration & Inclusions *****************************//
$pageJavaScript = 'logout';
include_once("../../include/config.php");
include_once(SCAFFOLDING_ADMIN."admin.include.php"); // centeralized admin includes
//***************************************************************************//


//********************* Check for logout redirection prompt *****************//
if (isset($_GET['Logout'])){
  session_logout($_SESSION);
  header('Location: /Login/?logout=true');
}
//***************************************************************************//


//******************* Header & Format Arrays For Beer Table *****************//

$active = getActivePanels($_POST); // see if any panels are open.

// check to set the panel classes
if($active == "user_groups"){$inGroups = " in";} else {$inGroups = '';}
//if($active == "user_groups"){$inGroups = " in";} else {$inGroups = '';}

$sectionWrappers = array("userGroups" => ["User Group Definitions", false, 'user_groups'],
                         "userManagement" => ["User Management", false]);


include(SCAFFOLDING_ADMIN.'testing/test.data.old.php');
$users_edit = array("Id" => array("user_id" => "id"),
                    "Name" => array("user_name" => "plain"),
                    "Group" => array("user_group" => "select, 1"),
                    "Password" => array("user_password" => "password, placeholder"),
                    "Password Reset" => array("new_pw" => "modal, large"),
                    "Edit" => array("edit" => "modal, large"),
                    "Drop" => array("drop" => "modal, large"),
                    "newrow" => array("newrow" => "newrow"),
                    "new_id" => array("new_id" => "plain"),
                    "placeholder1" => array("placeholder1" => "plain"),
                    "placeholder2" => array("placeholder2" => "plain"),
                    "placeholder3" => array("placeholder3" => "plain"),
                    "placeholder4" => array("placeholder4" => "plain"),
                    "placeholder5" => array("placeholder5" => "plain"),// call x5
                    "add" => array("add" => "modal, large")
                    );
$users_disp = array("Id" => array("user_id" => "id"),
                    "Name" => array("user_name" => "plain"),
                    "Group" => array("user_group" => "plain"),
                    "Password" => array("user_password" => "password, value"),
                    "Password Reset" => array("new_pw" => "modal, large"),
                    "Edit" => array("edit" => "modal, large"),
                    "Drop" => array("drop" => "modal, large"),
                    "newrow" => array("newrow" => "newrow"),
                    "new_id" => array("new_id" => "plain"),
                    "placeholder1" => array("placeholder1" => "plain"),
                    "placeholder2" => array("placeholder2" => "plain"),
                    "placeholder3" => array("placeholder3" => "plain"),
                    "placeholder4" => array("placeholder4" => "plain"),
                    "placeholder5" => array("placeholder5" => "plain"),// call x5
                    "add" => array("add" => "modal, large")
                    );

//***************************************************************************//


//******************** Open The Page & Display Menu Bar *********************//
$title = "Manage Users";
$section = ADMIN."Users/";
include_once(SCAFFOLDING."head.php");
echo menubar($permissions, $section, $root);
echo sectionbar($sectionWrappers, "Logout"); // With Logout Dummy for JS

//***************************************************************************//


//***************** Final Variable Processing & Cleaning *******************//
// Fututre home of SQL & $_POST processing methods
//$processed_group_cells = $test_group_cells;
//$group_special_cells = $test_group_special_cells;
$processed_user_cells = $users_test;
$user_specal_cells = $user_special_cells_test;
//***************************************************************************//


//********************************* Content *********************************//

// User Group drop //
// Echo the wrapped table
echo '
        <div class="collapse'.$inGroups.'" id="userGroups" token="'.rand(1000, 9999).'"> <!-- Group Definitions -->';
include(GROUP_HANDLER);
echo '      </div>';


// User Management drop  Testing//
$userTable = new Table("users", $processed_user_cells, $users_disp,
                       $users_edit, $user_specal_cells);

// Echo the wrapped table
echo '      <div class="collapse" id="userManagement" token="'.rand(1000, 9999).'"> <!-- Users -->';
echo $userTable;
// testing below
echo'
<div class="modal fade" id="targetModal" tabindex="-1" role="dialog" aria-labelledby="targetModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    </div>
  </div>
</div>';

echo '      </div>';

//***************************************************************************//


//********************************TEST***************************************//

/* The array will have to be processed in the following way:
 * first, check for an add. If add exist, then 
 */
if(isset($_POST)){
  echo "Post contents:<br><pre>";
  var_dump($_POST);
  var_dump($_GET);
  echo "</pre>";
  
}


//******************************** Footer ***********************************//
include_once(SCAFFOLDING_ADMIN."footer.php");
//***************************************************************************//

 

