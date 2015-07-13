<?php

// a collection of functions to help deal with raw info from the SQL database
// and get it ready for use elsewhere

/**
 * A function to make an array in the form of $id => $display from the SQL
 */
function make_selector($mysqli, $table, $id, $display){
  // the mysql statement
  $results = $mysqli->query("SELECT $id, $display FROM $table ORDER BY $id");
  $return = array(); // return array
  
  while($row = $results->fetch_array(MYSQLI_ASSOC)){
    $key = $row[$id];
    $value = $row[$display];
    $return[$key] = $value;
  }
  
  return $return;
}