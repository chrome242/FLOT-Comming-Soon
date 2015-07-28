<?php

// a collection of functions to help deal with raw info from the SQL database
// and get it ready for use elsewhere

/**
 * A function to make an array in the form of $id => $display from the SQL
 *
 * Can accept either vars for all the info, or an array with all the info
 *
 * @param obj $mysqli the mySQL object
 * @param mixed $table either the table name or any array of name, id, target field
 * @param str $id the id column of the table, to be used as the value
 * @param str $display the column of the text to be displayed.
 *
 * @return array the selector array
 */
function make_selector($mysqli, $table, $id=null, $display=null){
  
  // processes usage case
  if(is_null($id) && is_null($display)){
    $id = $table[1];
    $display = $table[2];
    $use_table = $table[0];
  } else {
    $use_table = $table;
  }
  
  $results = $mysqli->query("SELECT $id, $display FROM $use_table ORDER BY $id");
  $return = array(); // return array
  
  
  while($row = $results->fetch_array(MYSQLI_ASSOC)){
    $key = $row[$id];
    $value = $row[$display];
    $return[$key] = $value;
  }
  
  return $return;
}

/**
 * A simple function to return a value from an array. Really just exist so that
 * it's more clear what's happening in the code.
 *
 * @param mixed $value: the key value in the array, analoge to the HTML value
 * @param array $arry: the selector array
 *
 * @return the value of the array at value key.
 */
function selector_to_text($value, $array){
  if(isset($array[$value])){
    return $array[$value];
  } else {
    return "Set Value!";
  }
}