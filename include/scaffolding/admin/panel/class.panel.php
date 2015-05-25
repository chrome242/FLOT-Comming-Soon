<?php

//TODO: Add a method to add an update button
//TODO: Add a method to add a table wrapper for the table
//TODO: Add method to pull the name off the table or list form if object


/* The panel class is designed to encapsulate another class that produces HTML
 * output inside of a Bootstrap panel for output.
 * 
 */

class Panel {
  
  // class attributes
  protected $_name; // the panel name
  protected $_id; 
  protected $_header; // the panel header.
  protected $_class = "panel panel-default";
  protected $_show_id = false; //no id for the panel by default
  
  // the inner html
  protected $_inner_html; // the inner html string or class that produces html w/ tostring
  
  // additional panel bits:
  
  
  
  /**
   * Constructs a panel to wrap the body arg. The body arg can be either a string
   * of html code or an abstraction that produces html on return.
   *
   * By default the panel has an ID attribute that equals the name, which can
   * be changed with the setID setter. The Panel header is also set to the name
   * by default, and this can be changed by way of the setHeader method, a blank
   * setting would remove the header from the panel.
   *
   * The responsive classing of the panel is set to bootstrap auto by default,
   * however, it can be changed by altering the $size on construction. $size may
   * be set to either "default" (no classing), "half" (xs-12 md-6) or an array
   * of 4 numbers or 'none' values for xs, sm, md, & lg.
   * 
   *
   * @param str $name: the name of the panel
   * @param mixed $body: the string or string generator to wrap in a panel
   * @param mixed $size: a string (default, half) or a 4 number array.
   */
  public function __construct($name, $body, $size="default"){
    // the attribs for the panel itself
    $this->_name = $name;
    $this->_id = $name;
    $this->_header = $name;
    
    // the inner html for the panel
    $this->_inner_html = $body;
    
    // the make bootstrap CSS classes
    $this->makeClass($size);
    
  }
  
  /**
   * A setter for the panel HTML id.
   *
   * @param str $id: the id to be applied to the panel
   */
  public function setID($id){
    $this->_id = $id;
  }
  
  /**
   * sets the panel ID atribute to be shown
   */
  public function showID(){
    $_show_id = true;
  }
  
  
  /**
   * A setter for the header string. If the input is a bool false rather than
   * a string, then the header will be supressed.
   *
   * @param mixed $header: either false or a header string.
   */
  public function setHeader($header=false){
    $this->_header = $header;
  }
  
  /**
   * I like well formated HTML. This function takes an input, explodes it line
   * by line, and returns it with more spacing. This is pretty awesome for times
   * when you want to take something and wrap it deeper in.
   */
  private function addIndent($str){
    $array = explode("\n", $str);
    $output = '';
    foreach($array as $line){
      $output .= "  " . $line ."\n";
    }
    return $output;
  }
  
  /**
   * a function to deal with the application of bootstrap responsive classing to
   * the panel. It can be used in one of two ways, either with a builtin text
   * keyword (currently default or half) or by passing in an array of 4 numbers
   * and or the string 'none' which will be used to make the col-size classes
   * for viewing
   *
   * @param mixed $size: see the detailed explination of this method.
   */
  private function makeClass($size){
    // grab the current class string
    $class = $this->_class;
    
    // check to see if the $size param is a string, if so, process as such
    if(gettype($size) == "string"){
      if($size == "default"){$class .='';  }
      if($size == "half") { $class .= " col-xs-12 col-md-6";}
    }
    
    // otherwise, make sure its an array in case of zanyness.
    if(gettype($size) == "array"){
      if($size[0] != "none"){$class .= " col-xs-" . $size[0];}
      if($size[1] != "none"){$class .= " col-sm-" . $size[1];}
      if($size[2] != "none"){$class .= " col-md-" . $size[2];}
      if($size[3] != "none"){$class .= " col-lg-" . $size[3];}
    }
    
    // set the class to the new class string
    $this->_class = $class; 
  }
  
  public function __toString(){
    
    // open the div, check for the ID setting
    if($this->_show_id == false){
      $opening = '
          <div class="' . $this->_class . '">';
    } else {
      $opening = '
          <div class="' . $this->_class . '" id="' . $this->_id . '">';
    }
    
    // build the header if needed
    if($this->_header !== false){
      $opening .= '
            <div class="panel-heading"><h4>' . $this->_header .'</h4></div>
';
    }
    
    // open table wrap here if table
    
    $body = $this->addIndent($this->_inner_html);
    
    // add button here if button
    // close table wrap here if table
    $closing = '
          </div>';
  
    $output = $opening . $body . $closing;
    return $output;
  
  }
  

  
}
