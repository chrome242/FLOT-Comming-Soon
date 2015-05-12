<?php

/**
 * Input Cell
 *
 * Extends Cell.
 *
 * Input is in essance an interface to be used for making input cells that
 * interface in a consistant way with the broader table framework.
 *
 * Specific input cell types should only need to consider:
 * additional attribs
 * constructor
 * additional setters
 * makeInput()
 * 
 * 
 */
class Input extends Cell {
  
  // Input over-rides the default behavior and shows details by default
  protected $_showDetails = true;
  
  // Added in the Input extension 
  protected $_disabled = false; //determines if the input is disabled
  protected $_type; // the type of input
  protected $_input; // the content formated.
  
  // $_input is used as oppsed to the $_content because this allows the content
  // variable to be used in things such as the text input type as any placeholder
  // or value that can then be accessed with the cell class getValue() making
  // a number of things much simpler.
  
  
  /**
   * As with cell, sets the name and the ID to the same thing by default
   *
   * If any content is required by decendant cell types, the construct
   * must be rebuilt for that cell.
   *  
   * @param str $name: the name & id of the Cell
   * @param bool $state: if true, the cell is checked.
   */
  public function __construct($name, $type){
    $this->_id = $name;
    $this->_name = $name;
    $this->_type = $type;
  }
  
  /**
   * makes the cell $_input string. This used to be fire at time of cell creation,
   * however, it is no nessicary until a toString is fired, and would require a
   * re-write of the class methods to set ids and names and such
   */
  private function makeInput(){
    if(!$this->_showDetails){
      $content = '<input type="'. $this->_type .'"';
    } else {
      $content = '<input type="'. $this->_type .'" id="'.$this->_id.'" name="'.$this->_name.'"';
    }
    
    if($this->_disabled) {$content .= " disabled";}
    
    $content .=">";
    
    return $content;
  }
  
  /**
   * Sets the details for the cell to hidden.
   */
  public function hideDetails(){
    $this->_showDetails = false;
  }
  
  /**
   * Sets a cell to disabled. 
   */
  public function disabled(){
    $this->_disabled = true;
  }
  
  /**
   * The input toString overwrite replaces the default behavior of the
   * cell class by moving the HTML id attribs to the input while keeping
   * the class with the td, for layout purposes.
   *
   * This method can be preserved in child elements because the class
   * specifics are called in the makeInput() internal method.
   */
  public function __toString(){
    
    // make the cell input field:
    $this->makeInput();
    
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