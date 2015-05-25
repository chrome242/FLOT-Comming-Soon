<?php

/**
 * ListInput
 *
 * Extends ListItem.
 *
 * ListInput is in essence an interface to be used for making input lis that
 * interface in a consistent way with the broader table framework.
 *
 * Specific input li types should only need to consider:
 * additional attribs
 * constructor
 * additional setters
 * makeInput()
 * 
 * 
 */
class ListInput extends ListItem {
  
  // Input over-rides the default behavior and shows details by default
  protected $_showDetails = true;
  
  // Added in the Input extension 
  protected $_disabled = false; //determines if the input is disabled
  protected $_type; // the type of input
  protected $_input; // the content formatted.
  
  // $_input is used as opposed to the $_content because this allows the content
  // variable to be used in things such as the text input type as any placeholder
  // or value that can then be accessed with the li class getValue() making
  // a number of things much simpler.
  
  
  /**
   * As with li, sets the name and the ID to the same thing by default
   *
   * If any content is required by descendent li types, the construct
   * must be rebuilt for that li.
   *  
   * @param str $name: the name & id of the Li
   * @param str $type: the type of li
   */
  public function __construct($name, $type){
    $this->_id = $name;
    $this->_name = $name;
    $this->_type = $type;
  }
  
  /**
   * makes the li $_input string. This used to be fire at time of li creation,
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
   * Sets the details for the li to hidden.
   */
  public function hideDetails(){
    $this->_showDetails = false;
  }
  
  /**
   * Sets a li to disabled. 
   */
  public function disabled(){
    $this->_disabled = true;
  }
  
  /**
   * The input toString overwrite replaces the default behavior of the
   * li class by moving the HTML id attribs to the input while keeping
   * the class with the td, for layout purposes.
   *
   * This method must be reused in child elements because the class
   * specifics are called in the makeInput() internal method.
   */
  public function __toString(){
    
    // make the li input field:
    $this->_input = $this->makeInput();
    
    // make the string:
    if ($this->_class != null){
    $output = '
                  <li class="'.$this->_class .'"'. $this->_tooltip .'>
                    '. $this->_input . '
                  </li>'; 
    } else {
    $output = '
                  <li'. $this->_tooltip .'>
                    '. $this->_input . '
                  </li>'; 
    }
    return $output;
  }
}