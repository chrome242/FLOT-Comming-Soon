<?php

/**
 * A function to deal with processing the input to a small table data structure.
 * This function will give a return of true if there is a change to the myslq
 * database that would result in the need for a re-pull of the SQL data. This
 * should only be the case when the submit form is an "update"
 *
 * @param str $form_name the name of the form and assoicated table
 * @param obj $sql_obj the mysqli object
 * @param array $post_array the $_POST superglobal or some subsect of it
 * @param array $type_rules the array of display rules
 * @param array $processedSQL the SQL already processed into a better form
 * @param array $processedPOST the POST subitems needed for the table
 * @param str $pkey the primary key of the SQL table
 *
 * @return null/bool  true if SQL DB needs to be repolled
 */

function processInput($form_name, $sql_obj, $post_array, $type_rules,
                      &$processedSQL, &$processedPOST, $pkey="id", $full=false){
  
  // determine what type of submit button was pressed
  $type_of_submit = standardSelector($form_name, $post_array, $full);
  
  // first check the options that don't include SQL access.
  if($type_of_submit[0] == "new"){ // for a new entry
    if (!$full){addNewRecord($processedPOST, $type_rules);}
    if ($full){newTableRecord($processedPOST, $type_rules, $pkey);}
  }
  if($type_of_submit[0] == "edit"){ // for an edit
    passiveToActive($type_of_submit[1], $processedSQL, $processedPOST);
  }
  
  // on a delete, the specific record gets changed, but it should not be assumed
  // that anything else has been finalized to be altered. So a drop will either
  // drop a new record if it has not been posted yet, or it will drop an existing
  // record and it's references in the database. AGAIN, it will NOT update or
  // insert to the database for other records.
  if($type_of_submit[0] == "drop"){
    removeRecord($type_of_submit[1], $form_name, $processedSQL,
                 $processedPOST, $sql_obj, $pkey);
  }
  
  // this function calls two other functions to aid in how it deals with anything
  // in the submit that is either an update or a new post. This alters the database
  // and should clear the active array so that all items in the DB are shown in
  // view and not edit mode.
  if($type_of_submit[0] == "update"){
    // first the DB should be updated.
    updateDB($form_name, $processedPOST, $sql_obj, $pkey);
    
    return true;
  }  
}