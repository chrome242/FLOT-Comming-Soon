<?php

// todo: replace $cell_name = $this->_name . '['. $name . ']'; with a function as I do it a lot

/**
 * Row
 *
 * The purpose of the row class is pretty simple:
 *
 * Takes a string of name
 * Takes an array of format name => value in order
 * Takes an array of format name => type to establish type
 *
 * Produces two general types of cells:
 *
 * Public cells: These are used for display and getting input. Echos out to
 * the 
 *
 * Private cells: private cells are used for some row internal purpose,
 * and kept in the $_privateCells array and not added to the _toString()
 *
 * Constructing cells:
 *
 *  (o) = optional part of string:
 *  NOTE THAT IF A STRING HAS OPTIONAL PARTS, THEY MUST BE INCLUDED IN ORDER,
 *  AND CAN BE PASSED OVER WITH A VALUE OF 'none' (eg number, x, none, 42)
 *
 * Cell types:
 * 
 * id - plain text cell who's value is attached to the row name
 * checkbox - a checkbox
 * drop - not placed in the table
 * number, x, y(o), z(o), where x = number or placeholder y= step(o), z= size(o)
 * private - placed in the internal cell array as basic text
 * plain - a basic cell
 * radio, # - a radio set of # cells
 * text, x = a text entry where x = text or placeholder
 * textarea, x, y(o), z(o), where x = text or placeholder y= rows(o), z= colspan(o)
 * time, x - a timestamp where x = show or private
 *
 *
 * Notable class methods-
 * 
 *  constructor:
 *  public function __construct($name, $cells, $format)
 *
 *  Setters for HTML attribs:
 *  public function setId() optional arg $id else $id = $name
 *  public function setClass($class)
 *
 *  Get the inner value of a cell from either cell array:
 *  public function getHidden($cell)
 *  public function getCell($cell)
 *
 *  Setters for commonly used cell methods- these push down to cell method of
 *  the same name or purpose:
 *  public function setDisabled($cell, $value=null)
 *  public function setCellClass($cell, $class)
 * 
 * Expanding use of class:
 *  To add new cell types the logic in makeCells must be updated 
 * 
 */
class Row {
  
  // class attribs for the row
  protected $_name; // the name of the row.
  protected $_class = null;
  protected $_id = null;
  
  // class attribs for member cell storage
  // the below is stored by cell id (not name) due to radio buttons
  protected $_cells; //an array of cells prior to string construction.
  protected $_privateCells; //cells for internal use, such as timestamp math
  
  // class attribs for output
  protected $_output; //the output string
  
  /**
   * Constructor
   *
   * constructs a basic row from the $array and $types vars.
   * If the array length does not equal the length of the split
   * string from vars, it will raise an error.
   *
   * @param str $name the name of the row or partial name of the row
   * @param array mixed $array: the cells that belong to the row
   * @param array str $types: an array of cell types
   */
  public function __construct($name, $cells, $format){
    $this->_name = $this->makeName($name, $cells, $format);
    $this->makeCells($cells, $format);
  }
  
  /**
   * getter function for the row name
   *
   *
   * @return str  $output the name of the row object
   */
  public function getName(){
    
    return $this->_name;
  }
  
  /**
   * setter for the row id
   *
   * if the $id is not set for the row and the method is invoked, then the row
   * id will be set to the row name.
   *
   * @param str $id: the id for the HTLM output
   */
  public function setId($id=null){
    if($id != null){$this->_id = $id;}
    else{$this->_id = $this->_name;}
  }
  
   /**
   * setter for the row class
   *
   * @param str $class: the class for the HTLM output
   */
  public function setClass($class){
    $this->_class = $class;
  }
  
  /**
   * checks to see if any of the cells are of format id, if so it adds their
   * value to the name passed into the class. It will only access the $cells
   * array if the $format array has a field of format id
   *
   * @param str $name the name passed in (typically the table name)
   * @param array $format the format array passed into the row
   *  
   * @return str $output the name for the cell
   */
  
  private function makeName($name, $cells, $format){

    $output = $name;
    foreach($format as $cell_name => $type){
      if($type == "id"){$output .= '['.$cells[$cell_name].']';}
    }
    return $output;
  }
  
  /**
   * takes the $cells and the $format arrays and
   * sorts them out and sends them to the correct handler
   * function to be parsed into cells and added to the
   * $output array
   *
   * @param array $cells the array of cell contents
   * @param array $format the array of cell format types
   *
   * @return array $output the array of cells
   */
  private function makeCells($cells, $format){
    $output = array();
    $hidden = array();
    foreach($cells as $name => $value){
      $cell_name = $this->_name . '['. $name . ']'; // should work for non-radios
      
      // id cell
      if($format[$name] == 'id'){$output[$cell_name] = new Cell($name, $value);}
      // text cell
      if($format[$name] == 'plain'){ $output[$cell_name] = new Cell($name, $value);}
      
      // private (text) cell private
      if($format[$name] == 'private'){ $hidden[$cell_name] = new Cell($name, $value);}
      
      //checkbox cell
      if($format[$name] == 'checkbox'){ $output[$cell_name] = new Checkbox($name, $value);}
      
      //timestamp cell
      if(stripos($format[$name], 'time,') !== false){
        $pieces = explode(",", $format[$name]);
        $where_to = trim($pieces[1]);
        if($where_to != "private") {
          $output[$cell_name] = new Timestamp($cell_name, $value, true);
        }else{
          $hidden[$cell_name] = new Timestamp($cell_name, $value, false);
        }
      }
      
      //text cell
      if(stripos($format[$name], 'text,') !== false){
        $pieces = explode(",", $format[$name]);
        $type = trim($pieces[1]);
        $output[$cell_name] = new Text($cell_name, $value, $type);
      }
      
      //number cell
      if(stripos($format[$name], 'number,') !== false){
        $pieces = explode(",", $format[$name]);
        $type = trim($pieces[1]);
        $step = null;
        $size = null;
        if (count($pieces) > 2){
          if ($pieces[2] != 'none'){$step = trim($pieces[2]);}
          if ($pieces[3] != 'none'){$size = trim($pieces[3]);}
        }
        
        $output[$cell_name] = new Number($cell_name, $value, $type, $step, $size);
        
      }
      
      // textarea -suprizingly identical to number... might need to functionalize
      if(stripos($format[$name], 'textarea,') !== false){
        $pieces = explode(",", $format[$name]);
        $type = trim($pieces[1]);
        $row = null;
        $colspan = null;
        if (count($pieces) > 2){
          if ($pieces[2] != 'none'){$step = trim($pieces[2]);}
          if ($pieces[3] != 'none'){$size = trim($pieces[3]);}
        }
        
        $output[$cell_name] = new Number($cell_name, $value, $type, $row, $colpan);
        
      }
      
      //radio cell madness
      if(strpos($format[$name], 'radio,') !== false){
        $pieces = explode(",", $format[$name]);
        $cell_number = intval(trim($pieces[1]));
        $cell_value =0; // counter & id value
        while ($cell_value < $cell_number){
          // $value above == the value where state== true
          $radio_cell_name = $cell_name . '[' . $cell_value . ']';
          if($cell_value == $value) {
            $output[$radio_cell_name] = new Radio($cell_name, $cell_value, true);
          } else {
            $output[$radio_cell_name] = new Radio($cell_name, $cell_value, false);
          }
          $cell_value ++;
        }
      }
      
      // dropped cells
      if($format[$name] == 'drop'){ continue; }
      
    }
    $this->_cells = $output;
    $this->_privateCells = $hidden;
  }  

  
  /**
   * A getter method to return the inner value of a cell from the public array.
   *
   * @param str $cell the cell name within the array (e.g. beer[1][type] $cell = [type])
   * @param str $value the enum value if cell type is radio
   *
   * @return mixed $output the inner content of the cell
   */
  public function getCell($cell, $value=null){
    if($value==null){$cell_name = $this->_name . '['. $cell . ']';}
    else{$cell_name =  $this->_name . '['. $cell . '][' . $value . ']';}
    
    //get the cell in question
    $output = $this->_cells[$cell_name];

    return $output->getValue();
    
  }
  
  /**
   * A getter method to return the inner value of a cell from the private array.
   *
   * @param str $cell the cell name within the array (e.g. beer[1][type] $cell = [type])
   *
   * @return mixed $output the inner content of the cell
   */
  public function getHidden($cell){
    $cell_name = $this->_name . '['. $cell . ']';
    
    //get the cell in question
    $output = $this->_privateCells[$cell_name];
 
    return $output->getValue();
    
  }
  
  /**
   * A setter to push down to the cell, setting it disabled, for input cells and
   * extensions of input only.
   *
   * @param str $cel: the name of the cell
   * @param str $value: the enum value if the type of the cell is radio.
   */
  public function setDisabled($cell, $value=null){
    // construct name
    if($value==null){$cell_name = $this->_name . '['. $cell . ']';}
    else{$cell_name =  $this->_name . '['. $cell . '][' . $value . ']';}
    
    // do job
    $this->_cells[$cell_name]->disabled();
  }
  
    /**
   * A setter to push down to the cell, setting the cell class. 
   *
   * @param str $cel: the name of the cell
   * @param str $class: the enum value if the type of the cell is radio.
   */
  public function setCellClass($cell, $class){
    // construct name
    $cell_name = $this->_name . '['. $cell . ']';
    
    // do job
    $this->_cells[$cell_name]->setClass($class);
  }
  
  
  public function __toString(){
    //make the output string
    
    //add attributes if needed
    $attribs = '';
    if(isset($this->_id)){$attribs .= ' id="' . $this->_id . '"';}
    if(isset($this->_class)){$attribs .= ' class="' . $this->_class . '"';}
    
    $output = '
              <tr' . $attribs .'>';
    
    foreach($this->_cells as $a_cell){
      $output .= $a_cell; //this is a concat of the string and the object.

    }
    
    $output .= '
              </tr>';
              
    return $output;
  }
  
}

