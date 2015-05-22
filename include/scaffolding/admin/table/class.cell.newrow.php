<?php

// A 'cell' to make a new row. Really it's just a cell to maintain the
// method of table construction.


class NewRow extends Cell{
  
  /**
   * This class is intended to be a pure text dump, however, an optional name
   * arg is allowed if needed for some reason. In this case the name is treated
   * as name only, and id is null, unless set.
   *
   * @param str $name: an optional name
   */
  public function __construct($name=''){
    $this->_name = $name;

  }
  
  public function __toString(){
    //make the output string
    
    //add attributes if needed
    $attribs = '';
    if(isset($this->_id)){$attribs .= ' id="' . $this->_id . '"';}
    if(isset($this->_class)){$attribs .= ' class="' . $this->_class . '"';}
    $output = '
              </tr>';
    $output .= '
              <tr' . $attribs .'>';

              
    return $output;
  }
}