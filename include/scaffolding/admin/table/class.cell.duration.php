<?php

/**
 * Duration Cell
 *
 * Extends cell.
 * The Duration cell is an extension of cell that processes a pair of timestamps into 
 * while this is largely simular to a generic cell in it's output, it requires a timestamp
 * to be passed into the cell on creation. A second cell can be passed though as well, but
 * is only nesicarry if the duration being calculated is not trucated with the current time.
 *
 * It may be useful to use this class with the Timestamp class, but as to not code a specific
 * case that assumes that a Timestamp was used in getting a value for the date, the value from
 * a Timestamp cell should be gotten via the timestamp's getValue() function and then passed
 * to the Duratuon cel.
 *
 * By default, the Duration cell sets the cell tooltip on and floats the ammount of time between
 * the first/only datestamp and the second datestamp/now as a tooltip if the value = a current
 *
 * The output cell will either return a value of X Days, Current, or New.
 *
 * first cell is ontap
 * second cell is offtap
 * 
 * Current if only one stamp passed (stamp to today)
 * Current if offtap = 0 & ontap != 0
 * New if offtap = 0, ontap = 0
 * Amount of days ran if offtap > ontap
 * 
 */
class Duration extends Cell {
  
  
  /**
   * Sets the $_name and $_id to the same thing on construction.
   *
   *  This extension changes the default behavior of the Cell class by moving
   *  the name and id to the inner input of the cell, and not the cell itself.
   *
   *  The HTML class will still apply to the td.
   *
   *  If the timestamp is not set, it will return the unix epoc time, as it
   *  should only read zero when an event has not occured yet.
   *  
   * @param str $name: the name & id of the Cell
   * @param int $value: the timestamp
   * @param bool $format: if false, then a time stamp. If true, then a date.
   */
  public function __construct($name, $value, $format=false){
    $this->_id = $name;
    $this->_name = $name;
    
    // logic for format.
    if (!is_null($value)){
      if ($format == false) { $this->_content = $value;}
      if ($format == true) {$this->_content = $this->formatDate($value);}
    } else {
      $this->_content = null;
    }
  }
  
  /**
   * Applies a format to the date of Month Day, Year
   *
   * @param int $value: A timestamp
   *
   * @return str $output: The date formated for human viewing
   */
  private function formatDate($value){
    $output = date("F j, Y", $value);
    return $output;
  }
  

  
  // this class should utilize the default toString
}