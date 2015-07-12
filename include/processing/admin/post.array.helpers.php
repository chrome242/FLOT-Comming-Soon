<?php

// A number of helper functions for dealing with the content of the $_POST array

/**
 * To be used with submit button returns from forms with more then one submit
 * button. Takes a $_POST ["formname-function"] => formname[record][field]
 * and trims out the record to return it.
 *
 * @param str $record the uncleaned value of the ["formname-function"] array
 *
 * @return str the value of the record name.
 */
function trimNumber($record){
  
  // this will be of the form "[Thing I want][stuff]"
  $record = strstr(strstr($record, '['), ']', true);
  // is now of the form "[thing I want"
  $record = substr($record, 1);
  // clean, return it.
  return $record;
}

/**
 * Checks the $_POST super global for a clicked button that sets a return with
 * the format of [formname-job], and if is found, returns the job type, and the
 * record to do it to, if applicabale, as an array of the order [jobtype,
 * record(o)] returns an empty array otherwise. Esentally, this is a jazzed up
 * enum with the option to pass though a variable as well.
 *
 * @param str $form_name: the name of the form to search the $_POST array for
 * @param array $post: the $_POST superglobal or a subset thereof
 *
 * @return array the array as described above.
 */
function standardSelector($form_name, $post){
  $return = array();
  // check to see if the $_POST contains either of the non-record specific options.
  if(isset($post[$form_name.'-new'])) { $return[0] = "new";}
  if(isset($post[$form_name.'-add'])) { $return[0] = "new";}
  if(isset($post[$form_name.'-update'])) { $return[0] = "update";}
  
  // deal with record specific return options.
  if(isset($post[$form_name.'-drop'])) {
    $return[0] = "drop";
    $return[1] = trimNumber($post[$form_name.'-drop']);
  }
  if(isset($post[$form_name.'-edit'])) {
    $return[0] = "edit";
    $return[1] = trimNumber($post[$form_name.'-edit']);
  }
  
  // return varies based on if something was set.
  if(isset($return[0])){ return $return;}
  
  return array(null);
}
