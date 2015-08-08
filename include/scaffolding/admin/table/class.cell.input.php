<?php

/**
 * Input Cell
 *
 * Extends Cell.
 *
 * Input is in essence an interface to be used for making input cells that
 * interface in a consistent way with the broader table framework.
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
  protected $_input; // the content formatted.
  
  // $_input is used as opposed to the $_content because this allows the content
  // variable to be used in things such as the text input type as any placeholder
  // or value that can then be accessed with the cell class getValue() making
  // a number of things much simpler.
  
  
  /**
   * As with cell, sets the name and the ID to the same thing by default
   *
   * If any content is required by descendent cell types, the construct
   * must be rebuilt for that cell.
   *  
   * @param str $name: the name & id of the Cell
   * @param str $type: the type of cell
   */
  public function __construct($name, $type){
    $this->_id = $name;
    $this->_name = $name;
    $this->_type = $type;
  }
  
  /**
   * makes the cell $_input string. This used to be fire at time of cell creation,
   * however, it is no necessary until a toString is fired, and would require a
   * re-write of the class methods to set ids and names and such
   */
  private function makeInput(){
    $details = '';
    
    if($this->_showDetails){$details = 'id="'. $this->_id . '" name="' . $this->_name . '"';}
    
    $content = '<input type="'. $this->_type .'"'. $details;
    
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
  public function disabled(){  //legacy came
    $this->_disabled = true;
  }
  public function setDisabled(){
    $this->_disabled = true;
  }
  
  /**
   * The input toString overwrite replaces the default behavior of the
   * cell class by moving the HTML id attribs to the input while keeping
   * the class with the td, for layout purposes.
   *
   * This method must be reused in child elements because the class
   * specifics are called in the makeInput() internal method.
   */
  public function __toString(){
    
    // make the cell input field:
    $this->_input = $this->makeInput();
    
    if($this->_hidden){$this->_tooltip .= " hidden";}
    
    // make the string:
    if ($this->_class != null){
    $output = '
                  <td class="'.$this->_class .'"'. $this->_tooltip .'>
                    '. $this->_input . '
                  </td>'; 
    } else {
    $output = '
                  <td'. $this->_tooltip .'>
                    '. $this->_input . '
                  </td>'; 
    }
    return $output;
  }
}