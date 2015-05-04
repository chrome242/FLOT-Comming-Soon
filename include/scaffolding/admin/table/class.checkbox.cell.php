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
class Checkbox extends Cell {
  
  // for entry types by default the details are shown.
  protected $_showDetails = true;
  protected $_state;
  protected $_disabled = false;
  
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
   */
  public function __construct($name, $state){
    $this->_id = $name;
    $this->_name = $name;
    $this->_state = $state;
    $this->_content = $this->makeInput();
  }
  
  private function makeInput(){
    if(!$this->_showDetails){
      $content = '<input type="checkbox"';
    } else {
      $content = '<input type="checkbox" id="'.$this->_id.'" name="'.$this->_name.'"';
    }
    
    if($this->_state){ $content .= " checked";} 
    if($this->_disabled) {$content .= " disabled";}
    
    $content .=">";
    
    return $content;
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
  
  /**
   * Sets a cell to disabled. 
   */
  public function disabled(){
    $this->_disabled = true;
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