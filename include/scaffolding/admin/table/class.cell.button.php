<?php

// button should be used to add a button to add or edit or drop a record on an
// individual row scale.
// to do this it will need to:
// have a value of the current row (w/o the table name)
// add a suffix for the action for the name (so tablename-sufix)
// have a text value that likely matches the name if not overridden

/**
 * Button
 *
 * This creates a button using the button tag rather then the input submit type
 *
 * The button deviates from a normal cell construction in the following ways:
 * the $name is the name of the form not the cell
 *
 * The button will also have the classes of button and btn-primary by default
 * and be not-active (unpressed) by default. These can be over-ridden with the
 * functions setButtonClasses() and setActive().
 * The type change be changed with the setType() method.
 *
 */
 class Button extends Input{
  
  // overrides for default Cell & Input attributes
  protected $_type = "submit"; // in case of eventual extensions
  
  // class specific attributes:
  protected $_button_classes = "btn btn-primary";// for bootstrap
  protected $_active = false; // if it's active or not.
  protected $_record; // the record value
  
  /**
   *  This cell is specialized. It doesn't use the same conventions as other
   *  cells. It will use the form name as it's name.action, and it will create an id
   *  that marks it by form[record][button. - . action]
   *
   *  @param str $form: the name of the parent form
   *  @param str $record: the record (row) name
   *  @param str $action: a suffix to be passed to the processor for the action.
   */
  public function __construct($form, $record, $action){
    $this->_record = $record;
    $this->_name = $form . '-' . $action;
    $this->_id = $form.'['.$record.']['. $this->_name .']';
    $this->_content = ucwords($action);
  }
  
  /**
   * sets the button classes to the value passed in.
   *
   * @param str $classes a string of the button classes
   */
  public function setButtonClasses($classes){
    $this->_button_classes = $classes;
  }
  
  /**
   * Sets active to true for the button
   */
  public function setActive(){
    $this->_active = true;
  }
  
  public function setType($type){
    $this->_type = $type;
  }
  
  private function makeInput(){
    $details = 'class="' . $this->_button_classes . '"';
    
    if($this->_showDetails){$details .= ' id="'. $this->_id . '" name="' . $this->_name . '"';}
    
    $content = '<button type="' . $this->_type . '"' . $details . ' value="' .$this->_record .'">';
    
    $content .= $this->_content . '</button>';
    
    return $content;
  }
  
  /**
   * The input toString overwrite replaces the default behavior of the
   * cell class by moving the HTML id attributes to the input while keeping
   * the class with the td, for layout purposes.
   *
   * This method must be reused in child elements because the class
   * specifics are called in the makeInput() internal method.
   */
  public function __toString(){
    
    // make the cell input field:
    $this->_input = $this->makeInput();
    
    // set attributes on the TD
    $attribs = '';
    if($this->_class != null){$attribs .= ' class="' . $this->_class . '"';}
    $attribs .= $this->_tooltip;
    
    // make the string:
    $output = '
                  <td' . $attribs . '>
                    '. $this->_input . '
                  </td>'; 

    return $output;
  }
  
}
 
