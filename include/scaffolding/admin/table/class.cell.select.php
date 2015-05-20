<?php

/**
 * Select Cell
 *
 * extends input
 * The select extension allows for the creation of a select box with
 * the associated option listings. It will be created with the form-control
 * class for bootstrap unless stated otherwise, using the controlOff() method.
 * It can not currently be created with option groups.
 * Individual option disabling not currently supported.
 *
 * The default behavior of cell is modified by making the content either null
 * or the text of the selected option if one is selected.
 *
 * This method is a departure from the other cell methods in that the input is
 * an array rather than a string.
 *
 * This method signature requires the following:
 * $name - the cell name
 * $content - a keyed array (or the numbers will be used) for the value => text
 *
 * optionals are, in order:
 * $selected - the selected value at loadin for the input (none)
 * $mutiple - if the selector is mutiple select or not (no)
 * $size- the char size of the select (none)
 */
class Select extends Input{
  
  // select specific variables:
  protected $_mutiple; // no mutiple select by default (breaks boostrap)
  protected $_selected; // must match a value 
  protected $_size; // if null then not specified
  protected $_form = true; // add the form-control class by default
  protected $_option_array; // the option array for the cell
  
  
  /**
   * As with cell, sets the name and the ID to the same thing by default
   *
   * Takes a name, and an array of the form value => option. While this is totally
   * doable with an unkeyed array, it's likely not useful because of things like
   * SQL.
   *  
   * @param str $name: the name & id of the Cell
   * @param array mixed $options: the value => text array
   * @param mixed $selected the array value of a selected field.
   */
  public function __construct($name, $options, $selected=null,
                              $mutiple=false, $size=null){
    
    $this->_name = $name;
    $this->_id = $name;
    $this->_type = "select";
    $this->_selected = $selected;
    $this->_mutiple = $mutiple;
    $this->_size = $size;
    $this->_option_array = $options;
    if($selected != null){$this->_content = $options[$selected];}
    if($selected == null){$this->_content = "";}
    
  }

  /**
   * makes the cell $_input string. This used to be fire at time of cell creation,
   * however, it is no nessicary until a toString is fired, and would require a
   * re-write of the class methods to set ids and names and such
   */
  private function makeInput(){
    $details = '';
 
    
    if($this->_form){$details .= ' class="form-control"';}
    if($this->_showDetails){$details .= ' id="'. $this->_id . '" name="' . $this->_name . '"';}
    if($this->_disabled){$details .= " disabled";}
    if($this->_mutiple){$details .= " multiple";}
    $content = '<'. $this->_type .''. $details .'>';
    
    foreach($this->_option_array as $value => $text){
      
      if($value == $this->_selected){
        $sel_str = ' selected';
      }
      
      else {
        $sel_str = '';
      }
      
      $this_option = '  <option value="' . $value . '"' . $sel_str . '>';
      $this_option .= $text . '</option>';

      $content .= '
                  '. $this_option . '';
    }
    $content .= '
                  </select>';
    return $content;
  }  

  /**
   * Turns off the form-control class from showing.
   */
  public function  controlOff(){
    $this->_form = false;
  }
  
  
  public function __toString(){
    
    // make the cell input field:
    $this->_input = $this->makeInput();
    
    // set attribs on the TD
    $attribs = '';
    if($this->_class != null){$attribs .= ' class="' . $this->_class . '"';}
    if($this->_colspan != null){$attribs .= ' colspan="' . $this->_colspan . '"';}
    
    $attribs .= $this->_tooltip;
    
    // make the string:
    $output = '
                <td' . $attribs . '>
                  '. $this->_input . '
                </td>'; 

    return $output;
  }
  
  
}








