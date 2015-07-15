<?php

/**
 * Helper functions for bridging the design of the array from SQL output to
 * php format desired by display models
 */

 
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
	*
	* @return array - an array in the form desired by SmallTable.
	*/
function sqlToTable($mysqli, $table, $id='id', $fields=null){
	
	if($fields == null){
		$results = $mysqli->query("SELECT * FROM $table ORDER BY $id");
	} else {
		$selectables = implode("', '", $fields);
		$results = $mysqli->query("SELECT $selectables FROM $table ORDER BY $id");
	}
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
		//echo gettype($value); good debug option.
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
function format_for_static(&$merged_array, $edit_array, $remove_array=null, $selects_array=null){
	
}
