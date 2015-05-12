<?php

/**
 * Radio Cell
 *
 * Extends cell.
 * The radio cell is an extension of cell that allows the cell to contain a radio element.
 * all checkboxes are required to have a name and a value.
 * methods are used to set to checked and disabled.
 * 
 * 
 */
class Radio extends Cell {
  
  // for entry types by default the details are shown.
  protected $_showDetails = true;
  protected $_state;
  protected $_disabled = false;
  protected $_value;
  
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
   * @param int $value: the enum state the cell represents.
   */
  public function __construct($name, $value, $state=false){
    $this->_id = $name . '[' . $value . ']';
    $this->_name = $name;
    $this->_value = $value;
    $this->_state = $state;
    $this->_content = $this->makeInput();
  }
  
  /**
   * Deals with producing the input field of the cell.
   */
  private function makeInput(){
    if(!$this->_showDetails){
      $content = '<input type="radio"';
    } else {
      $content = '<input type="radio" id="'.$this->_id.'" name="'.$this->_name.'"';
    }
    
    $content .= ' value="' . $this->_value . '"';
    
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
   * a getter for the state of the cell
   */
  public function getState(){
    return $this->_state;
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