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
if($active == "members"){$inUsers = " in";} else {$inUsers = '';}

$sectionWrappers = array("userGroups" => ["User Group Definitions", false, 'user_groups'],
                         "userManagement" => ["User Management", false, 'members']);




//******************** Open The Page & Display Menu Bar *********************//
$title = "Manage Users";
$section = ADMIN."Users/";
include_once(SCAFFOLDING."head.php");
echo menubar($permissions, $section, $root);
echo sectionbar($sectionWrappers, "Logout"); // With Logout Dummy for JS

//***************************************************************************//


//********************************* Content *********************************//

// User Group drop //
// Echo the wrapped table
echo '
        <div class="collapse'.$inGroups.'" id="userGroups" token="'.rand(1000, 9999).'"> <!-- Group Definitions -->';
include(GROUP_HANDLER);
echo '      </div>';




// Echo the wrapped table
echo '      <div class="collapse'.$inUsers.'" id="userManagement" token="'.rand(1000, 9999).'"> <!-- Users -->';
include(USER_HANDLER);
// testing below
echo'
<div class="modal fade" id="targetModal" tabindex="-1" role="dialog" aria-labelledby="targetModalLabel"  token="'.rand(1000, 9999).'">
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

 

