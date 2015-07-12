<?php

// A few simple functions to allow the listView to use the small table processing
// functions for their processing as well.

/**
 *  A function to make a new array based on the array passed in, where the new
 *  array will have the top level keys of the old array, and the contents of a
 *  2nd level key below it. For example [1] => [foo] => yes, [bar] => no would
 *  return with elevate_field_array($example, $foo): [1] =? yes
 *
 *  @param array $array: the array to be used as a source
 *  @param mixed $field: the key of the 2nd level array to be elevated up
 *
 *  @return a 1d array of key value format.
 */
function elevate_field_array($array, $field){
  $return = array();
  foreach($array as $keep_key => $drop_key){
    $return[$keep_key] = $array[$keep_key][$field];
  }
  
  return $return;
}

/**
 * A that wrappes elevate_field_array, and futher modifies the return array by
 * striping out the entries where the value is equal to the $default value
 *
 *  @param array $array: the array to be used as a source
 *  @param mixed $field: the key of the 2nd level array to be elevated up
 *  @param str $default: the value to be removed from the array
 *  
 *  @return a 1d array of key value format.
 */
function make_special_list($array, $field, $default){
  $return = array();
  $intermedate = elevate_field_array($array, $field);
  foreach($intermedate as $key => $value){
    if($value != $default){$return[$key] = $value;}
  }
  
  return $return;
  
}