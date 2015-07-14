<?php

/**
 * Helper functions for bridging the design of the array from SQL output to
 * php format desired by display models. These have been moved to the included
 * Table.array.helpers.php, and wrappers for the small table version are included
 * here where they differ. smallTable only functions are also included here.
 */
include("Table.array.helpers.php");


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
	return sqlToTable($mysqli, $table, $id, $fields=null);
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
	return postToTable($post, $formname);
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

