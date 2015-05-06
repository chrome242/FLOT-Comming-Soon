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
  
  
  /**
   * Sets the $_name and $_id to the same thing on construction.
   *
   *  This extension changes the default behavior of the Cell class by moving
   *  the name and id to the inner input of the cell, and not the cell itself.
   *
   *  The HTML class will still apply to the td.
   *
   *  This extension produces a 
   *  
   * @param str $name: the name & id of the Cell
   * @param int $value: the timestamp
   * @param bool $format: if true, change content to a formated date
   */
  public function __construct($name, $value, $format=false){
    $this->_id = $name;
    $this->_name = $name;
    
    // logic for format.
    if ($format == false) { $this->_content = $value;}
    if ($format == true) {$this->_content = $this->formatDate($value);}
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
   * Sets the details for the cell to hidden. This would really only be useful
   * for a protected view if there's concerns that someone in the business
   * might want to try to hack forms so some people only have access to view
   * the forms as they stand at the moment.
   */
  public function hideDetails(){
    $this->_showDetails = false;
    $this->_content = $this->makeInput();
  }
  
  
  public function __toString(){
    if ($this->_class != null){
    $output = '
                <td class="'.$this->_class.'">
                  '. $this->_content . '
                </td>'; 
    } else {
    $output = '
                <td>
                  '. $this->_content . '
                </td>'; 
    }
    return $output;
  }
}