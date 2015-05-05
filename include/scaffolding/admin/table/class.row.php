<?php
// move cell includes here?

/**
 * Row
 *
 * The purpose of the row class is pretty simple:
 *
 * Takes an array of format name => value in order
 * Takes an array of format name => type to establish type
 *
 * Ways to make cells:
 * drop -not placed in the table
 * plain -a basic cell
 * checkbox -a checkbox
 * radio, # -a radio set of # cells
 *
 * cells can be accessed via calling methods defined below, rather than
 * the methods on the cell class, as I would like to have the cell objects
 * protected.
 *
 * to add new cell types the switch in makeCells must be updated and
 * a handler function for the cell type must be included.
 * 
 */
class Row {
  
  // class attribs
  protected $_name; // the name of the rows.
  // the below is stored by cell id (not name) for reasons that will become clear.
  protected $_cells; //an array of cells prior to string construction.
  protected $_output; //the output string
  
  /**
   * constructs a basic row from the $array and $types vars.
   * If the array length does not equal the length of the split
   * string from vars, it will raise an error.
   *
   * @param str $name the name of the row
   * @param array mixed $array: the cells that belong to the row
   * @param array str $types: an array of cell types
   */
  public function __construct($name, $cells, $format){
    $this->_name = $name;
    $this->makeCells($cells, $format);
  }
  
  /**
   * takes the $cells and the $format arrays and
   * sorts them out and sends them to the correct handler
   * function to be parsed into cells and added to the
   * $output array
   *
   * @param array $cells the array of cell contents
   * @parm array $format the array of cell format types
   *
   * @return array $output the array of cells
   */
  private function makeCells($cells, $format){
    $output = array();
    foreach($cells as $name => $value){
      $cell_name = $this->_name . '['. $name . ']'; // should work for non-radios
      
      // text cell
      if($format[$name] == 'plain'){ $output[$cell_name] = $this->makePlain($cell_name, $value);}
      
      //checkbox cell
      if($format[$name] == 'checkbox'){ $output[$cell_name] = $this->makeCheckbox($cell_name, $value);}
      
      //radio cell madness
      
    }
    $this->_cells = $output;
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
  public function makeCheckbox($name, $value){
    return new Checkbox($name, $value);
  }
  
  /**
   * A function to allow cell methods to be passed to an individual cell in the
   * row with out having to access the cell array directly. Methods that need to be passed
   * args will have the row name added to the front of them (to preserve id and
   * name conventions), unless they are an array, in which case it will be passed
   * straight though. this can also be overriden. WARNING: The array in the cell list
   * is indexed by the name at time of inseption. It will still have to be accessed with
   * that name unless changed elsehwere.
   *
   * This method will not let you change the name of radio cells (but will allow ID change)
   *
   * @param str $cell the cell name within the array (eg beer[1][type] $cell = [type])
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
    
    // handle diffrent cases, unless radio & name
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
  
}

//
//class test { function sts() { return "hey"; } }
//$tst = new test;
//$met = "sts";
//echo $tst->$met();