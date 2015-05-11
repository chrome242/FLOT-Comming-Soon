<?php
// move cell includes here?

// todo: replace $cell_name = $this->_name . '['. $name . ']'; with a function as I do it a lot

/**
 * Row
 *
 * The purpose of the row class is pretty simple:
 *
 * Takes an array of format name => value in order
 * Takes an array of format name => type to establish type
 *
 * Private cells: private cells are used for some row internal purpose,
 * and kept in the $_privateCells array
 *
 * Ways to make cells:
 * id - plain text cell who's value is attached to the row name
 * drop - not placed in the table
 * private - placed in the internal cell array as basic text
 * plain - a basic cell
 * checkbox - a checkbox
 * radio, # - a radio set of # cells
 * time, x - a timestamp where x = show or private
 *
 * Cells can be accessed via calling methods defined below, rather than
 * the methods on the cell class, as I would like to have the cell objects
 * protected.
 *
 * notable class methods-
 *  constructor:
 *  public function __construct($name, $cells, $format)
 *
 *  Setters for HTML attribs:
 *  public function setId() optional arg $id else $id = $name
 *  public function setClass($class)
 *
 *  Member cell method accessor:
 *  public function method($cell, $method, $input=null, $override=false)
 *
 *  Get the inner value of a cell from the hidden cell array
 *  public function getHidden($cell)
 * 
 * To add new cell types the switch in makeCells must be updated and
 * a handler function for the cell type must be included.
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
      if($format[$name] == 'id'){$output[$cell_name] = $this->makePlain($cell_name, $value);}
      // text cell
      if($format[$name] == 'plain'){ $output[$cell_name] = $this->makePlain($cell_name, $value);}
      
      // private (text) cell private
      if($format[$name] == 'private'){ $hidden[$cell_name] = $this->makePlain($cell_name, $value);}
      
      //checkbox cell
      if($format[$name] == 'checkbox'){ $output[$cell_name] = $this->makeCheckbox($cell_name, $value);}
      
      //timestamp cell
      if(stripos($format[$name], 'time,') !== false){
        $pieces = explode(",", $format[$name]);
        $where_to = trim($pieces[1]);
        if($where_to == "show") {
          $output[$cell_name] = $this->makeTimestamp($cell_name, $value, true);
        }else{
          $hidden[$cell_name] = $this->makeTimestamp($cell_name, $value, false);
        }
      }
      
      //radio cell madness
      if(strpos($format[$name], 'radio,') !== false){
        $pieces = explode(",", $format[$name]);
        $cell_number = intval(trim($pieces[1]));
        $cell_value =0;
        while ($cell_value < $cell_number){
          // $value above == the value where state== true
          $radio_cell_name = $cell_name . '[' . $cell_value . ']';
          if($cell_value == $value) {
            $output[$radio_cell_name] = $this->makeRadio($cell_name, $cell_value, true);
          } else {
            $output[$radio_cell_name] = $this->makeRadio($cell_name, $cell_value, false);
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
   * A handler function to make a text cell from input.
   *
   * This function is public because alternately to the intended use someone
   * could just make a table on the fly with it, cell by cell.
   *
   * @param str $name the name of the cell
   * @param str $value the text of the cell
   * @return obj a cell of type plain
   */
  public function makePlain($name, $value){
    return new Cell($name, $value);
  }
  
  /**
   * A handler function to make a checkbox cell from input
   *
   * This function is public because alternately to the intended use someone
   * could just make a table on the fly with it, cell by cell.
   *
   * @param str $name the name of the cell
   * @param bool $state the state of the cell
   * @return obj a cell of type plain
   */
  public function makeCheckbox($name, $state){
    return new Checkbox($name, $value);
  }
  
  /**
   * A handler function to make a radio cell from input
   *
   * This function is public because alternately to the intended use someone
   * could just make a table on the fly with it, cell by cell.
   *
   * @param str $name the name of the cell
   * @param int $value
   * @param bool $state the state of the cell
   * @return obj a cell of type plain
   */
  public function makeRadio($name, $value, $state){
    return new Radio($name, $value, $state);
  }
  
  /**
   * A handler function to make a time stamp cell
   *
   * This function is public because alternately to the intended use someone
   * could just make a table on the fly with it, cell by cell.
   *
   * @param str $name the name of the cell
   * @param int $value the timestamp
   * @param bool $show if the timestamp should be shown or not.
   * @return obj a cell of type timestamp
   */
  public function makeTimestamp($name, $value, $show){
    return new Timestamp($name, $value, $show);
  }
  
  
  /**
   * A function to allow cell methods to be passed to an individual cell in the
   * row with out having to access the cell array directly. Methods that need to be passed
   * args will have the row name added to the front of them (to preserve id and
   * name conventions), unless they are an array, in which case it will be passed
   * straight though. this can also be overridden. WARNING: The array in the cell list
   * is indexed by the name at time of inception. It will still have to be accessed with
   * that name unless changed elsewhere.
   *
   * This method is for public cells. All hidden cells should be accessed with task
   * specific getters and setters.
   *
   * This method will not let you change the name of radio cells (but will allow ID change)
   *
   * @param str $cell the cell name within the array (e.g. beer[1][type] $cell = [type])
   * @param str $method the method to be called on the target cell
   * @param mixed $input (optional) any args to be passed to the method
   * @param bool $override (optional) overrides the default behavior
   */
  public function method($cell, $method, $input=null, $override=false){
    $radio = false;
    
    // deal with normal cells
    if(substr($cell, -1) != "]"){$cell_name = $this->_name . '['. $cell . ']';}
    //deal with radio cells
    if(substr($cell, -1) == "]"){$cell_name = $this->_name . '['. $cell . ']'; $radio = true;}
    
    // handle different cases, unless radio & name
    if($radio && $method="setName"){
      continue;
    } else {
      if($input == null && $override == false){
        $this->_cells[$cell_name]->$method();
      
      } elseif(gettype($input) == "array" || $override== true) {
        $this->_cells[$cell_name]->$method($input);
        
      } else {
        $cell_input = $this->_name . '['. $input . ']';
        $this->_cells[$cell_name]->$method($cell_input);
      }
    }
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
    
    //get the cell into a var, and explode.
    $a_cell = explode("\n", $this->_privateCells[$cell_name]);
    
    // this offset is 2 not 1 because of the structure of the text in my cell
    // classes. If further explination is required, see those classes.
    return $a_cell[2];
    
  }
  
  /**
   * test function
   *
   * @return the toString for all objects in the output_cells array
   */
  public function test(){
    foreach($this->_cells  as $a_cell){
      $a_cell->showDetails();
      echo $a_cell;
    }
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

//
//class test { function sts() { return "hey"; } }
//$tst = new test;
//$met = "sts";
//echo $tst->$met();