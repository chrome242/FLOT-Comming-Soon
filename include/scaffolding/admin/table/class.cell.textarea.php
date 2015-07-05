<?php

/**
 * Textarea Cell
 *
 * Extends Input.
 *
 * Constructs a cell with a form element of type textarea. This cell will have
 * a colspan attribute unless set otherwise. This cell will also use the Bootstrap
 * form-control class on the textarea unless instructed otherwise. The class
 * uses the additional properties for how to handle all the above. The methods
 * controlOff() and colspanOff() turn off their respective HTML tags.
 *
 * 
 * 
 * 
 */

class Textarea extends Input {
  
  // textarea additional properties.
  protected $_placeholder; // placeholder (true) or value (false)bool
  protected $_form = true; // add the form-control class by default
  protected $_row; //default number of rows in the view for this class
  protected $_colspan; // the colspan attribute for the td, useful for this class
  
  
  // textarea uses $this->_content for the text
  
  
  /**
  * Sets the $_name and $_id to the same thing on construction.
   *
   *  This extension changes the default behavior of the Cell class by moving
   *  the name and id to the inner input of the cell, and not the cell itself.
   *  Additionally, the class "form-control' will be added to the input unless
   *  turned off.
   *  
   *  The HTML class will still apply to the td.
   *
   *  This extension produces a text 
   *  
   * @param str $name: the name & id of the Cell
   * @param str $content: the cell text
   * @param str $type: placeholder or value
   * @param int $rows: the number of rows for the textbox on spawn
   * @param int $colspan: the value of the colspan attribute on the td
   */
  public function __construct($name, $content, $type="placeholder",
                              $rows=3, $colspan=6){
    $this->_id = $name;
    $this->_name = $name;
    $this->_type = "textarea";
    $this->_row = $rows;
    $this->_colspan = $colspan;
    $this->_content = $content;
    if($type == "placeholder"){$this->_placeholder = true;}
    if($type != "placeholder"){$this->_placeholder = false;}
  }
  
  /**
   * makes the cell $_input string. This used to be fire at time of cell creation,
   * however, it is no necessary until a toString is fired, and would require a
   * re-write of the class methods to set ids and names and such
   */
  private function makeInput(){
    $details = '';
    
    //class logic
    if($this->_form && isset($this->_buttons[0])){$details .= ' class="form-control edit-field"';}
    elseif(isset($this->_buttons[0])){$details .= ' class="edit-field"';}
    elseif($this->_form){$details .= ' class="form-control"';}
    
    $details .= 'rows="' . $this->_row .'"';
    
    if($this->_showDetails){$details .= ' id="'. $this->_id . '" name="' . $this->_name . '"';}
    
    if($this->_placeholder){$details .= ' placeholder="' . $this->_content . '"';}
    
    $content = '<'. $this->_type .''. $details;
    
    if($this->_disabled){$content .= " disabled";}
    
    $content .='>';
    
    if(!$this->_placeholder){$content .= $this->_content;}
    
    $content .="</textarea>";
    
    foreach($this->_buttons as $button){
      $content .='
                    '. $button .'';
    }
    
    return $content;
  }

  /**
   * turn off the form control class inclusion
   */
  public function  controlOff(){
    $this->_form = false;
  }
  
  /**
   * turn off the colspan attribute
   */
  public function colspanOff(){
    $this->_colspan = null;
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
    if($this->_colspan != null){$attribs .= ' colspan="' . $this->_colspan . '"';}
    
    $attribs .= $this->_tooltip;
  
    if($this->_hidden){$attribs .= " hidden";}
    
    // make the string:
    $output = '
                  <td' . $attribs . '>
                    '. $this->_input . '
                  </td>'; 

    return $output;
  }
}