<?php

/**
 * Text Cell
 *
 * Extends cell.
 * The Text cell is an extension of cell that allows the cell to contain a text input.
 * Text has an additional property $_placeholder for either "placeholder" or "value", with
 * the default being placeholder. It will be created with the form-control class on
 * the input unless the controlOff() method is called.
 *
 * important methods for this extension:
 * controlOff() removes the form-control class from the input.
 * 
 */
class Text extends Input {
  
  // text additional properties.
  protected $_format; // placeholder or value string
  protected $_form = true; // add the form-control class by default
  
  // text uses $this->_content for the text
  
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
   * @param str $content: The text of the cell
   * @param str $type: if a placeholder value or a real value
   */
  public function __construct($name, $content, $type="placeholder"){
    $this->_id = $name;
    $this->_name = $name;
    $this->_type = "text";
    $this->_content = $content;
    if($type == "placeholder") {
      $this->_format = ' placeholder=';
    } else {
      $this->_format = ' value=';
    }
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
    
    if($this->_showDetails){$details .= 'id="'. $this->_id . '" name="' . $this->_name . '"';}
    
    $details .= $this->_format . '"' . $this->_content . '"';
    
    $content = '<input type="'. $this->_type .'"'. $details .'';
    
    if($this->_disabled){$content .= " disabled";}
    
    $content .=">";
    
    foreach($this->_buttons as $button){
      $content .='
                  '. $button .'';
    }
    return $content;
  }
  
  
  /**
   * turn off the form control class inclusion
   */
  public function controlOff(){
    $this->_form = false;
  }
  
  
  public function __toString(){
    
    // make the cell input field:
    $this->_input = $this->makeInput();
    
    // make the string:
    if ($this->_class != null){
    $output = '
                  <td class="'.$this->_class.'"' . $this->_tooltip .'>
                    '. $this->_input . '
                  </td>'; 
    } else {
    $output = '
                  <td ' . $this->_tooltip . '>
                    '. $this->_input . '
                  </td>'; 
    }
    return $output;
  }
}