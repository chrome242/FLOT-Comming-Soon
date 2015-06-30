<?php

/**
 * Helper functions for bridging the design of the array from SQL output to
 * php format desired by display models
 */

 /**
	* Formats the results of a MySQL querry and returns it in a format desired by the
	* class SmallTable. In essence, this takes the 'id' field from the row and 3
	*
	* @param obj $mysqli - the mysqli connection object.
	* @param array $sql - the SQL array
	* @param str $id - the field that has the id of the record
	*
	* @return array - an array in the form desired by SmallTable.
	*/
function sqlToSmallTable($mysqli, $table, $id='id'){
  $results = $mysqli->query("SELECT * FROM $table ORDER BY $id");
	$output = array();
	while($row = $results->fetch_array(MYSQLI_ASSOC)){
		$key = $row[$id];
		unset($row[$id]);
		$array = $row;
		$output[$key] = $array;
	}
	return $output;
}

 /**
	* A small amount of extra overhead used to allow function swapping and some
	* level of consistancy in API and code flow. Pretty much, this just makes
	* an array of the portion of $post with the name $formname
	*
	* @param array $post the $_POST or other preformated array
	* @param str $formname the name of the form key in the $_POST array
	*
	* @return array the form's array
	*/
function postToSmallTable($post, $formname){
	if(isset($post[$formname])){
	return $post[$formname];
	} else {
		return array();
	}
}


/**
 * A function that merges two arrays with the same format for the table classes.
 * I've used this rather then array_merge or array() + array() because the typing
 * for the array keys is less then consistant, and I want to be sure they are handled
 * in a consistant way.
 *
 * @param $static_source the array to be modified
 * @param $active_source the array to modify the other array
 *
 * @return array the joined array
 */
function mergeTableArrays($static_source, $active_source){
	foreach ($active_source as $key => $value){
		$static_source[$key] = $value;
	}
	return $static_source;
}


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

/** UNTESTED
 * --FOR A DROP--
 * Removes a record from both the active array and the mysqli DB.
 * Checks to see if the record is established or new (has an n in the name)
 * if new, just unsets it from the array, if established, removes it from the DB
 * as well.
 *
 * @param str $record_id the id of the record to be removed
 * @param str $table the mysql table to remove the record from.
 * @param array $active_array the array of active records
 * @param obj $mysqli the mysqli connection object
 *
 * No return
 */
function removeRecord($record_id, $table, &$active_array, $mysqli, $id='id'){
  // the n term will never == pos 0, so can do this with some lose casting
  if(strpos($record_id, 'n')){ $in_db = false;} else { $in_db = true;}
  
  // if the record is in the DB, drop it from there
  if($in_db){
    $query = "DELETE FROM $table WHERE $id=$record_id";
    $mysqli->query($query);
  }
  
  unset($active_array[$record_id]);
}

/** UNTESTED
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
      updateRecordDB($table, $item_id, $item_record, $id);
    }
    
    // if not null then do query
    if($sql != null){$mysqli->query($sql);}
    
  }
  
  // clear the active array
  unset($active_array);
}

/** UNTESTED
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
   
   return $statement;
   
}

/** UNTESTED
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
  }
  
  // close it.
  $statement .=" WHERE $id=$item_id";
  
  return $statement;
}

/**
 * A function that checks the array for keys of the format n# and returns
 * a string of the format n# where the new #n is 1 greater then the last
 * one found.
 *
 * @param array $arry an array of the format produced by the small table f(x)ns
 *
 * @return str the string of the letter 'n' & the number
 */
function getNumberNew($array){
	$newcount = 1; // for if $addnew
  
	foreach ($array as $key => $fields){
    
		// check for keys with the name format '#n'
		if (strstr($key, 'n')){
			$count = intval(strstr($key, 'n', true));
			// if there is a key with an 'n' set count to n + 1
			if ($newcount <= $count){$newcount = $count + 1;}
		}
	}

	return $newcount . 'n';
}


/** UNTESTED
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
 * A function used to construct the type array from the merged array and the
 * parent active array and the type rules array. Also this function can be used
 * to add a entry to the end of the $mergedArray and the end of return array.
 * This should essentally be the final method called before display of the table
 *
 * @param array $mergedArray the array include all members of the post array
 *        as well as any additional member elements in the same format.
 * @param array $postArray the array of members that the active rule is to be
 *        applied too.
 * @param array $typeRules an array of keys for the other two arrays, and how
 *        to apply them based on their status as 'active' or 'static'.
 * @param bool $addNew a toggle for if the arrays should have new empty cells
 *        on the end.
 *
 * @return array the formating array for the table.
 */
function setSmallTypes($mergedArray, $postArray, $typeRules, $addNew=true){
	$type_array = array(); // for the return
	foreach ($mergedArray as $key => $fields){
		$type_array[$key] =array();
		foreach($fields as $field => $value){
			if(array_key_exists($key, $postArray)){
				$type_array[$key][$field] = $typeRules[$field]["active"];
			} else{
				$type_array[$key][$field] = $typeRules[$field]["static"];
			}
		}
	}
	if($addNew){
		$newcount = getNumberNew($mergedArray);
		// this number will change if there is already new cells (eg n1)
		$mergedArray[$newcount] = array();
		foreach($typeRules as $key => $value){
			// add new values
			$mergedArray[$newcount][$key] = "";
      if(isset($typeRules[$key]["new"])){
        $type_array[$newcount][$key] = $typeRules[$key]["new"];
      }
		}
	}
	return $type_array;
}

