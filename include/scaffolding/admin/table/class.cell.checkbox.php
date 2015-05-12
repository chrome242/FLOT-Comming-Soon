<?php

/**
 * Checkbox Cell
 *
 * Extends cell.
 * The checkbox cell is an extension of cell that allows the cell to contain a checkbox element.
 * all checkboxes are required to have a name and a state (checked or unchecked)
 * support included for disabled checkboxes as well. 
 * 
 */
class Checkbox extends Input {
  
  // Checkbox additional properties.
  protected $_value; // optional value property
  
  // Checkbox uses $this->_content for the state of the cell (checked or
  // unchecked)
  
  /**
   * Sets the $_name and $_id to the same thing on construction.
   *
   *  This extension changes the default behavior of the Cell class by moving
   *  the name and id to the inner input of the cell, and not the cell itself.
   *
   *  The HTML class will still apply to the td.
   *
   *  This extension produces a checkbox class input with a checked status of
   *  state. Can futher call methods to make it disbaled.
   *  
   * @param str $name: the name & id of the Cell
   * @param bool $state: if true, the cell is checked.
   * @param mixed $value: false or the value property of the checkbox input
   */
  public function __construct($name, $state, $value=false){
    $this->_id = $name;
    $this->_name = $name;
    $this->_type = "checkbox";
    $this->_content = $state;
    $this->_value = $value;
  }
  
  
  /**
   * makes the cell $_input string. This used to be fire at time of cell creation,
   * however, it is no nessicary until a toString is fired, and would require a
   * re-write of the class methods to set ids and names and such
   */
  private function makeInput(){
    $details = '';
    
    if($this->_showDetails){$details = 'id="'. $this->_id . '" name="' . $this->_name . '"';}
    
    if($this->_value !== false){$details .= ' value="' . $this->_value . '"';}
    
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
    return $this->_state;
  }
  
  
  public function __toString(){
    
    // make the cell input field:
    $this->_input = $this->makeInput();
    
    // make the string:
    if ($this->_class != null){
    $output = '
                <td class="'.$this->_class.'">
                  '. $this->_input . '
                </td>'; 
    } else {
    $output = '
                <td>
                  '. $this->_input . '
                </td>'; 
    }
    return $output;
  }
}