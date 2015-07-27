<?php

/**
 * Helper functions for bridging the design of the array from SQL output to
 * php format desired by display models
 */

 
/**
 * Takes two values from 1 to 4, which represent on tap, on deck, kicked and
 * off line. returns an array of timestamps based on what the old status was
 * and what the new status is. This is pretty much a site specific function.
 *
 * @param int $select_value the new value
 * @param int $old_value the old value
 *
 * @return an array of numbers/nulls where the first item is the onTap value
 * 				 and the second is the offTap value.
 */
function tapLogic($select_value, $old_value){
	
	// assign the numbers to vars just for ease of seeing what's going on.
	$onTap = 1;	$onDeck = 2;	$kicked = 3;	$offLine = 4;
	
	// onTap to anything else - set offtap to today
	if($old_value == $onTap && $select_value != $onTap){return array(null, time());}

	// anything to onTap - set on tap to today
	if($old_value != $onTap && $select_value == $onTap){return array(time(), null);}
	
	// onDeck to kicked or offline - set on tap to yesterday, off to today (1d)
	if($old_value == $onDeck && ($select_value == $kicked || $select_value == $offLine)){
		return array((time() - (24 * 60 * 60)), time());
	}
	
	// kicked to onDeck or offline - no change
	// no change
	// offline to onDeck, kicked or offline - no change
	return array(null, null);
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


 /**
	* Formats the results of a MySQL querry and returns it in a format desired by the
	* class SmallTable. In essence, this takes the 'id' field from the row and 3
	*
	* @param obj $mysqli - the mysqli connection object.
	* @param array $sql - the SQL array
	* @param str $id - the field that has the id of the record
	* @param array $fields - an array of fields to limit results to
	* @param bool $internal_id - if the ID should be shown in the results as well
	*
	* @return array - an array in the form desired by SmallTable.
	*/
function sqlToTable($mysqli, $table, $id='id', $fields=null, $internal_id=false){
	
	if($fields == null){
		$results = $mysqli->query("SELECT * FROM $table ORDER BY $id");
	} else {
		$selectables = implode("', '", $fields);
		$results = $mysqli->query("SELECT $selectables FROM $table ORDER BY $id");
	}
	$output = array();
	while($row = $results->fetch_array(MYSQLI_ASSOC)){
		$key = $row[$id];
		if(!$internal_id){unset($row[$id]);}
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
function postToTable($post, $formname){
	
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

function mergeTwoDArrays($static_source, $active_source){
	// check if the record exist
	foreach ($active_source as $key => $record){
		if(!isset($static_source[$key])){
			// if it does not, add it.
			$static_source[$key] = $record;
		
		// if it exist, check to see 
		} else {
			foreach($record as $field => $value){
				if(isset($active_source[$key][$field])){
					$static_source[$key][$field] = $active_source[$key][$field];
				}
			}
		}
	}
	return $static_source;
}

/**
 * A function wrapper for the array keys from the post array.
 * Serves to keep help keep the code more navagable and intautative
 *
 * @param array $postArray the array to retun the keys of
 *
 * @return array the keys of the array
 */
function getActiveMembers($postArray){
	
	return array_keys($postArray);
}

/**
 * A function that gets the last member of an associvate array by using the end()
 * command to move the pointer to the end of the array. Because the array passed in
 * is a copy, it should nto need a reset, however, we'll do that any how as it doesn't
 * have a lot of overhead.
 *
 * @param array $associative_array the array
 *
 * @return the key for the last array item
 */
function last_member($associative_array){
	// Note if things act odd with using this function and the resultant ordering, it
	// may require that it look for a natural order, as the pointer tracks by addition
	// to the array not by numeric or alphanumeric.
	end($associative_array);
	$key = key($associative_array);
	reset($associative_array);
	
	return $key;
}

/**
 * A function to find the last member of the array, and then append new elements
 * to it. Passes in the array by reference.
 *
 * @param array $associative_array the parent ray to be appended to.
 * @param array $new_elements the new elements to be added
 *
 * @return the new array
 */
function append_to_last(&$associative_array, $new_elements){
	
	$last = last_member($associative_array);
	$associative_array[$last] = array_merge($associative_array[$last], $new_elements);
	return $associative_array;
}


/**
 * A function I found on stack overflow to insert into an array at the position
 * prior to $position. Passes $array by reference.
 * 
 * @param array  $array: the array to be modified
 * @param mixed	 $position: the position (key) following the insert point
 * @param mixed  $insert: the item to be inserted.
 *
 * @return no return
 */
function array_insert_before(&$array, $position, $insert){
	
    if (is_int($position)) {
        array_splice($array, $position, 0, $insert);
    } else {
        $pos   = array_search($position, array_keys($array));
        $array = array_merge(
            array_slice($array, 0, $pos),
            $insert,
            array_slice($array, $pos)
        );
    }
}

/**
 * A function that will take an array of values for the table class and
 * make them workable for the static view of a record. It does this by
 * removing any fields earmarked for the active array as defined, and
 * replacing any values for a selector with their value from the selector
 * array(s)
 */
function make_table_output($merged_array, $edit_array, $templates_array,
													 $selects_array=null, $add=true, $id='id'){
	
	// break up the array
	$edit_template = $templates_array[0];
	$static_template = $templates_array[1];
	$add_template = $templates_array[2];
	
	// the return array
	$return_array = array();
	
	// the list of record id's
	$record_list = array_keys($merged_array);
	
	//populate $return_array with templates based on $merged_array and $edit_array
	foreach($record_list as $key){
		if(in_array($key, $edit_array)){$return_array[$key] = $edit_template;}
		else{$return_array[$key] = $static_template;}
	}
	
	//copy the values from the $merged_array where there is a key for it in the
	//return array
	foreach($merged_array as $record_key => $record){ // open the record
		foreach($record as $field => &$value){
			if(isset($return_array[$record_key][$field])){
				$return_array[$record_key][$field] = $value;
			}
		}
		// check for droped $id fields on new items between updates
		if($return_array[$record_key][$id] == ''){
			$return_array[$record_key][$id] = $record_key;
		}
	}
	
	
	//replace selects where they are not on the edit list, turn them into proper
	//format for edit ones.
	
	//selects array is in the format of field_name => select options
	if($selects_array !== null){
		foreach($record_list as $key){

			foreach($selects_array as $field => $list){
					if(in_array($key, $edit_array, true)){ // check to see if it's in the edit array

						if(isset($return_array[$key][$field])){
							$value = $return_array[$key][$field];
							
							// return with a selection if there is one to be had.
							if(isset($list[$value])){
								$return_array[$key][$field] = array($list, $value);
							
							// return with out a selection
							}else{
								$return_array[$key][$field] = $list;
							}
						}
					}
					
					// to make into text
					else{	
						if(isset($return_array[$key][$field])){
							$value = $return_array[$key][$field];
							$return_array[$key][$field] = selector_to_text($value, $list);
						}
					}
			}
		
		}
	}
	
	//add the add template to the end of the table
	if($add){
		append_to_last($return_array, $add_template);
	}
	
	
	return $return_array;
}
