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
function trimRecord($record){
      $record = strstr(strstr($record, '['), ']', true);
      $record = substr($record, 1);
      return $record;
}