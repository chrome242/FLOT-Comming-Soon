<?php

/**
 * Radio Cell
 *
 * Extends cell.
 * The radio cell is an extension of cell that allows the cell to contain a radio element.
 * 
 * 
 */
class Radio extends Input {
  
  // Radio additional properties.
  protected $_value; //The value of this radio button in the radio enum set
  
  // Radio uses $this->_content for the state of the cell (checked or
  // unchecked)
  /**
   *  This extension changes the default behavior of the Cell class by moving
   *  the name and id to the inner input of the cell, and not the cell itself.
   *  Futhermore, the id field in this extension will add the value field to
   *  the end of the name (eg name="beer[1][status]", id="beer[1][status][1]").
   *
   *  The HTML class will still apply to the td.
   *
   *  This extension produces a radio class input with a default state of
   *  unselected. Optional param sets the field to checked. (Due to the
   *  asumption that most radials will be unchecked.)
   *  Can futher call methods to make it disbaled
   *  
   * @param str $name: the name
   * @param int $enum: the enum state the cell represents.
   * @param bool $state: if the radio button is selected
   */
  public function __construct($name, $enum, $state=false){
    $this->_id = $name . '[' . $enum . ']';
    $this->_name = $name; // must be the same for the whole set
    $this->_type = "radio";
    $this->_value = $enum;
    $this->_content = $state;
  }
  
  /**
   * makes the cell $_input string. This used to be fire at time of cell creation,
   * however, it is no nessicary until a toString is fired, and would require a
   * re-write of the class methods to set ids and names and such
   */
  private function makeInput(){
    $details = '';
    
    if($this->_showDetails){$details = 'id="'. $this->_id . '" name="' . $this->_name . '"';}
    
    $details .= ' value="' . $this->_value . '"';
    
    $content = '<input type="'. $this->_type .'"'. $details .'';
    
    if($this->_content){$content .= " checked";} 
    if($this->_disabled){$content .= " disabled";}
    
    $content .=">";
    return $content;
  }

  /**
   * Gets the state setting for the cell.
   */
  public function getState(){
    return $this->_content;
  }

  
  public function __toString(){
    
    // make the cell input field:
    $this->_input = $this->makeInput();
    
    // make the string:
    if ($this->_class != null){
    $output = '
                <td class="'.$this->_class.'" ' . $this->_tooltip .'>
                  '. $this->_input . '
                </td>'; 
    } else {
    $output = '
                <td' . $this->_tooltip . '>
                  '. $this->_input . '
                </td>'; 
    }
    return $output;
  }
}