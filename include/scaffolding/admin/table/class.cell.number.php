<?php

/**
 * Number Cell
 *
 * Extends input.
 * The Number cell is an extension of cell that allows the cell to contain a Number input.
 * Number has an additional property $_placeholder for either "placeholder" or "value", with
 * the default being placeholder. It will be created with the form-control class on
 * the input unless the controlOff() method is called.
 *
 * important methods for this extension:
 * controlOff() removes the form-control class from the input.
 * 
 */

class Number extends Input {
  
  // text additional properties.
  protected $_format; // placeholder or value string
  protected $_form = true; // add the form-control class by default
  protected $_step = "0.001";
  protected $_size;
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
   * @param str $content: The value of the cell
   * @param str $type: if a placeholder value or a real value
   * @param float $step: the amount of the step size. 0.001 by default
   * @param int $size: the amount of the size attrib. Not set by default.
   */
  public function __construct($name, $content, $type="placeholder",
                              $step=null, $size=null){
    $this->_id = $name;
    $this->_name = $name;
    $this->_type = "number";
    $this->_content = $content;
    $this->_size = $size;
    if($type == "placeholder") {
      $this->_format = ' placeholder=';
    } else {
      $this->_format = ' value=';
    }
    
    if($step != null){$this->_step = $step;}
    if($size != null){$this->_size = ' size="' . $size . '"';}
  }
  
  
  /**
   * makes the cell $_input string. This used to be fire at time of cell creation,
   * however, it is no nessicary until a toString is fired, and would require a
   * re-write of the class methods to set ids and names and such
   */
  private function makeInput(){
    $details = ' step="' . $this->_step . '"';
    
    if($this->_form){$details .= ' class="form-control" ';}
    
    if($this->_showDetails){$details .= 'id="'. $this->_id . '" name="' . $this->_name . '"';}
    
    $details .= $this->_format . '"' . $this->_content . '"';
    
    $content = '<input type="'. $this->_type .'"'. $details .'';
    
    if($this->_size != null){$content .= $this->_size;}
    
    if($this->_disabled){$content .= " disabled";}
    
    $content .=">";
    return $content;
  }
  
  
  /**
   * turn off the form control class inclusion
   */
  public function  controlOff(){
    $this->_form = false;
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