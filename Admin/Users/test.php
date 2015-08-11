
<?php

//****************** Configuration & Inclusions *****************************//
$pageJavaScript = 'logout';
include("../../include/config.php");
include(SCAFFOLDING_ADMIN."admin.include.php"); // centeralized admin includes
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
echo sectionbar($sectionWrappers, "Zonks"); // With Logout Dummy for JS

//***************************************************************************//

//****************** Process the beer tables and Data: **********************//
include(GROUP_HANDLER);

//***************************************************************************//


//***************** Final Variable Processing & Cleaning *******************//
// Fututre home of SQL & $_POST processing methods
//$processed_group_cells = $test_group_cells;
//$group_special_cells = $test_group_special_cells;
//$processed_user_cells = $test_user_cells;
//$user_specal_cells = $user_special_cells_test;
//***************************************************************************//


//********************************* Content *********************************//

// User Group drop //
//$groupsTable = new Table("userGroups", $processed_group_cells, $groups_disp,
//                         $groups_edit, $group_special_cells);

// Echo the wrapped table
echo '      <div class="collapse'.$inGroups.'" id="userGroups"> <!-- Group Definitions -->';
$groups = new Table("user_groups", $user_groupsPROCESSED,
                         $groups_disp, $groups_edit,
                         $user_groupsTYPE);
echo $groups;
echo '      </div>';


// User Management drop //
//$userTable = new Table("users", $processed_user_cells, $users_disp,
//                       $users_edit, $user_special_cells);

// Echo the wrapped table
echo '      <div class="collapse" id="userManagement"> <!-- Users -->';
//echo $userTable;
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
include(SCAFFOLDING_ADMIN."footer.php");
//***************************************************************************//

 


echo"
<script>
  $('#exampleModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-title').text('New message to ' + recipient)
  modal.find('.modal-body input').val(recipient)
});

$(function(){
  
});

var formAjax = function (event, div, fileName){
  $('div#'+div+' button, div#'+div+ ' input[type=\"submit\"]').on('click', function(event){
    event.preventDefault();
    var data_save = $(this).parents('form').serializeArray();
    data_save.push ({ name: $(this).attr('name'), value: $(this).val()})
    $.ajax({
      type: 'POST',
      url: fileName+'.php',
      data: data_save,
      success: function(foo){
           $('#'+div+'').html(foo);
           alert('success!');
      }
    });
  });
}

$(function(){
  $(document.body).ready(formAjax(event, 'userGroups', 'testpost'));
});

//$(function(){
//  $(document.body).on('click', 'div#userGroups button, div#userGroups input[type=\"submit\"]', function(e){
//    var data_save = $(this).parents('form').serializeArray();
//    data_save.push ({ name: $(this).attr('name'), value: $(this).val()})
//    event.preventDefault();
//    alert('Name =' + $(this).attr('name') +'/nValue= ' + $(this).val());
//    $.ajax({
//      type: 'POST', //or POST
//      url: 'testpost.php',
//      data: data_save,
//      success: function(foo){
//           $('#userGroups').html(foo);
//           alert('success!');
//      }
//    });
//  });
//});

</script>
";