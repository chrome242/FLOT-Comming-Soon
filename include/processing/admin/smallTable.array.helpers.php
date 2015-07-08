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
		echo gettype($value);
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
 * @param int $count the length of the indivudual record array that is required
 * 				for it to be considered an active record. For example with a table
 * 				that passes in a hidden field with data, that data will always be
 * 				passed back, so you'd not want to make that active, and you'd want the
 * 				count to skip that one.
 *
 * @return array the formating array for the table.
 */
function setSmallTypes(&$mergedArray, $postArray,$typeRules,
											 $addNew=true, $count=1){
	$type_array = array(); // for the return
	foreach ($mergedArray as $key => $fields){
		$type_array[$key] =array();
		foreach($fields as $field => $value){
			if(array_key_exists($key, $postArray) && count($postArray[$key]) >= $count){
				$type_array[$key][$field] = $typeRules[$field]["active"];
			} else{
				$type_array[$key][$field] = $typeRules[$field]["static"];
			}
		}
	}
	if($addNew){
		if(isset($mergedArray["add"])){unset($mergedArray["add"]);}
		$mergedArray["add"] = array();
		foreach($typeRules as $key => $value){
			// add new values
			$mergedArray["add"][$key] = "";
      if(isset($typeRules[$key]["new"])){
        $type_array["add"][$key] = $typeRules[$key]["new"];
      }
		}
	}
	return $type_array;
}

