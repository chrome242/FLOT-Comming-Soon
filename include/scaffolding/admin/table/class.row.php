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
 * hidden -not placed in the table
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
  protected $_output_cells; //an array of cells prior to string construction.
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
      $cell_name = $this->_name . '['. $name . ']';
      echo $cell_name .'<br>';
      if($format[$name] == 'plain'){ array_push($output, $this->makePlain($cell_name, $value));}
    }
    $this->_output_cells = $output;
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
   * test function
   *
   * @return the toString for all objects in the output_cells array
   */
  public function test(){
    foreach($this->_output_cells  as $a_cell){
      echo $a_cell;
    }
  }
  
}

//
//class test { function sts() { return "hey"; } }
//$tst = new test;
//$met = "sts";
//echo $tst->$met();