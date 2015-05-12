<?php
// move cell includes here?

/**
 * Timestamp Cell
 *
 * Extends cell.
 * The timestamp cell is an extension of cell that allows the cell to contain a timestamp.
 * while this is largely simular to a generic cell, it adds the method toDate() and the
 * constructior option for making the cell as a date rather than a string literal of a
 * timestamp.
 */
class Timestamp extends Cell {
  
  // timestamps will default to showing the details
  protected $_showDetails = true; 
  
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
  
  /**
   * Hide the details on a timestamp. As a timestamp that is formated for
   * a date, as the timestamp form of the cell is presumed to be used in
   * hidden arrays only.
   */
  public function hideDetails(){
    $this->_showDetails = false;
    $this->_content = $this->formatDate($value);
  }
  
  
  // this class should utilize the default toString
}