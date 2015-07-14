<?php
// needs a re-write

/* Things to think about:
 * Let the Query get the entire thing.
 * keep the table definers as they are.
 * add a wrapper to trim the queries down as needed using type rules
 * setSmallTypes will not work
 * check passiveToActive below
 */


/**
 * Adds a new record to the $active_array, so that it's picked up by the
 * merge and made into a new edit record.
 *
 * @param array $active_array an array of active cells on the able
 * @param array $typeRules an array of rules for how to type the array
 *
 * No return.
 */
function addNewRecord(&$active_array, $typeRules){
  $newrecord = array(); // make a blank array
  $recordNumber = getNumberNew($active_array); // get the key name
  // add all member field names
  $fields = array_keys($typeRules);
  foreach($typeRules as $field_name => $rules){
    $newrecord[$field_name] = '';
  }
  
  $active_array[$recordNumber] = $newrecord;
}


//THIS NEEDS TO CHANGE
/**
 *  -- FOR AN EDIT --
 *  Takes an item from the static array and copies it on to the active array.
 *  This has the effect of, when used in combination with array merge and
 *  set(size)Type, of setting a record to into edit mode for display. 
 *
 *  @param str $record_id the id of the record to edit
 *  @param array $static_source the processed from sql array of statics
 *  @param array $active_source the processed from $_POST array of actives
 *
 *  No return, all side effects
 *  
 */
function passiveToActive($record_id, $static_source, &$active_source){
  $active_source[$record_id] = $static_source[$record_id];
}



/**
 * --FOR A DROP--
 * Removes a record from both the active array and the mysqli DB.
 * Checks to see if the record is established or new (has an n in the name)
 * if new, just unsets it from the array, if established, removes it from the DB
 * as well.
 *
 * @param str $record_id the id of the record to be removed
 * @param str $table the mysql table to remove the record from.
 * @param array $static_source the processed from sql array of statics
 * @param array $active_array the array of active records
 * @param obj $mysqli the mysqli connection object
 *
 * No return
 */
function removeRecord($record_id, $table, &$static_source, &$active_array, $mysqli, $id='id'){
  // the n term will never == pos 0, so can do this with some lose casting
  if(strpos($record_id, 'n')){ $in_db = false;} else { $in_db = true;}
  
  // if the record is in the DB, drop it from there
  if($in_db){
    $query = "DELETE FROM $table WHERE $id=$record_id";
    $mysqli->query($query);
  }
  
  unset($static_source[$record_id]);
  unset($active_array[$record_id]);
}



/** 
 *  -- FOR AN UPDATE --
 *  updates the DB on every item in the active record. If the item has an
 *  established ID, then it updates the record otherwise, it adds a new record
 *  to the table. Like all the functions in this set, it uses the denotation of
 *  #n to identify new records
 *  
 *  When done, it unsets the $active_array.
 *
 * @param str $table the mysql table to remove the record from.
 * @param array $active_array the array of active records
 * @param obj $mysqli the mysqli connection object
 */
function updateDB($table, &$active_array, $mysqli, $id='id'){
  
  // deal with each record in turn
  foreach($active_array as $item_id => $item_record){
    
    //initalize sql for new loop
    $sql = null;
    
    if(strpos($item_id, 'n')){
      // call insert function if a new record
      $sql = insertToDB($table, $item_record, $mysqli);
    }
    else{
      // call record update function if not new.
      $sql = updateRecordDB($table, $item_id, $item_record, $mysqli, $id);
    }
    
    // if not null then do query
    if($sql != null){$mysqli->query($sql);}
    
  }
  // clear the active array
  $active_array = array();

}



/** 
 *  A function to create an insert statement from a portion of a form received
 *  from $_POST.
 *  
 * @param str $table the mysql table to remove the record from.
 * @param array $item_record the array of record details
 * @param obj $mysqli the mysqli connection object
 *
 * @return str the SQL insert statement.
 */
function insertToDB($table, $item_record, $mysqli){
  
  $statement = "INSERT INTO $table ";
  
  // implode the array keys
  $statement .= " (".implode(", ", array_keys($item_record)).")";

   // implode values of the array
   $statement .= " VALUES ('".implode("', '", $item_record)."') ";
   
   // check for empty values
   foreach($item_record as $value){if($value == ""){$statement = null;}}
   
   return $statement;
   
}



/** 
 *  A function to create an update statement from a portion of a form received
 *  from $_POST.
 *  
 * @param str $table the mysql table to remove the record from.
 * @param str $item_id the pk value for the record
 * @param array $item_record the array of record details
 * @param obj $mysqli the mysqli connection object
 * @param str $id the name of the pk field in the table
 *
 * @return str the SQL insert statement.
 */
function updateRecordDB($table, $item_id, $item_record, $mysqli, $id){
  
  $first_item = true;
  $empty_value = false;
  
  // Start the statement
  $statement = "UPDATE $table";
  
  // check each value
  foreach($item_record as $field => $value){
    // if the first item, toggle it off when done
    if($first_item){
      $statement .= " SET $field='$value'";
      $first_item = false;
    }
    // do the remainder
    else{
      $statement .=" , $field='$value'";
    }
    
    if($value == ""){$empty_value = true;}
  }
  
  // close it.
  $statement .=" WHERE $id=$item_id";
  
  if($empty_value){return null;}
  return $statement;
}

