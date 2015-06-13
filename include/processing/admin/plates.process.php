<?php
// Open the Database Connection and Select the Correct DB credientals //
$db_cred = unserialize(MENU_ADMIN_CREDENTIALS);
require_once(INCLUDES."db_con.php");

function testSQL($mysqli){
  $results = $mysqli->query("SELECT * FROM foodType ORDER BY id");
  echo"<pre>";
  while($row = $results->fetch_array(MYSQLI_ASSOC)){
    var_dump($row);
  }
  echo"</pre>";
}

/**
 * processes data from SQL and updates from $_POST and formats for an object of
 * the class small table. Returns an array processed from the two for the types
 * table
 *
 * @param str $form_name the name of the form
 * @param array $sql_output an array of the form id => array(K=>V)
 * @param array $post_output the post file
 */
function processTypes($form_name, $sql_object, $post_output){
  // Do the inital SQL querry and get the form, if it's set:
  $results = $sql_object->query("SELECT * FROM ".$form_name." ORDER BY id");
  if(isset($post_output[$form_name])){$form = $post_output[$form_name];}
  $form_set = true;
  
  // Determine which submit was pressed:
  if(isset($post_output[$form_name.'-new'])){ $new = true;}
  if(isset($post_output[$form_name.'-drop'])){ $drop = $post_output[$form_name.'-drop'];}
  if(isset($post_output[$form_name.'-submit'])){$update = true;}
  if(isset($post_output[$form_name.'-edit'])){$edit = $post_output[$form_name.'-edit'];}
  
  if($new){
    // check to see if any other un-submited new cells exist at this time
    $newcount = 1;
    
    if(isset($post_output[$form_name])){
    $cells = array_keys($post_output[$form_name]);
    $last_cell = array_pop($cells);
      if(stripos($last_cell, 'n') !== false){
        $newcount = intval(strstr($last_cell, 'n')) + 1;
      }
    }
  }
  
  if($drop){
    // this should get the record ID from the $_POST
    $drop_cell = strstr(strstr($drop, '['), ']', true);
    // set update to true
    $update = true;
  }
  
  if($edit){
    // this should get the record ID from the $_POST
    $edit_cell = strstr(strstr($edit, '['), ']', true); 
  }
  
  if($update){

    // TODO: check to see if there's been a drop, if so, conduct the drop
    if(isset($drop_cell)){
      $sql_object->query("DELETE from " . $form_name . " WHERE id=".$drop_cell);
      unset($form[$drop_cell]);
      $results = $sql_object->query("SELECT * FROM ".$form_name." ORDER BY id");    
    }
    // TODO: update SQL record when these options are picked.
    // TODO: reload the SQL and set the $sql_output to the new load
    
    // TODO: if the update isn't from a drop, in addition to updates, insert
    //       all values that are new to the table
    // TODO: if the update isn't from a drop, ignore the existance of the $_POST
    //       following the update
  } else {
    // get every key value from post[form] for these, replace any sql array info
    // with info from the post array, set type to edit
    
    // set type of new edits to edit
    
    // add an add box to the end of the arry
  }
  
  
  
  
}