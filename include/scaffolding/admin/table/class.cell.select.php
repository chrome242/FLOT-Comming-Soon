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
 * or the value of the selected option if one is selected.
 *
 * This method is a departure from the other cell methods in that the content is
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
  protected $_mutiple = false; // no mutiple select by default (breaks boostrap)
  protected $_selected; // must match a value 
  protected $_size; // if null then not specified
  protected $_form = true; // add the form-control class by default
  protected $_option_array; // the option array for the cell
  
  
  public function __construct($name, $options, $selected=null,
                              $mutiple=false, $size=null){
    
  }
}