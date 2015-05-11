<?php
// check to see if depaancy includes should be in the highest level abstraction
// class (eg, row should included here? with cells included there?)

/**
 * Table
 *
 * The Table class should be a near top level (top/wrapped in panel)
 * abstraction of the backend of the site.
 *
 * The Table class will need the following functionality out of the gate:
 *
 * open and close a table structure
 *
 * set the class, id, name, action, et al of the table.
 * 
 * take an array of header names to make a header and row rules
 * the header array should be in the form of array(header => array(cell => rule))
 * this will implicitly associate the header with a cell name and a way to make
 * that cell.
 * 
 * take an array of format: row name => array(cell name => values)
 *  -use that array to generate a list of rows with cell named cells
 *  -alternate between sets of rows if need be
 *  -use a set of setters to set values for all rows of given type
 *  -use a set of getters to access cells from either the exposed or
 *   the hidden cells of a given row.
 *  -include a task specific method to set some cell values based on other
 *   cell values, applying this to all rows.
 *   
 * allow the creation of an 'update' button to post to defined page
 * set up the name of the form from the table name
 *  
 * because there's a lot of customization in this class, it will need a number
 * of private methods for the toString method.
 *
 * indivudual rows should be accessed via getters and setters, and while it
 * shouldn't be used much, it should be resonable to use a row setter to
 * push down to a cell setter from a the table level.
 * 
 * 
 */
class Table {
  
  // class attributes
  protected $_name; // the form name.
  protected $_table_id = null; // the table id
  protected $_table_class = null; // the table class
  protected $_form_id = null; // the form id
  protected $_form_class = null; // the form class
  
  // member portion attributes
  protected $_header; // takes the header key
  protected $_format; // takes the header array value
  protected $_rows;  // the row array
  
  /**
   * Constructor
   *
   * a basic table & form constructor.
   *
   * @param str $name the name of the form
   * @param mixed array $rows array of row name => (cell value array)
   * @param mixed array $header array of header name => array(cell name => format)
   *
   * due to radio buttons, some of the valyes in the header array may not be
   * name => array but rather name => int where the in is just a placeholder
   * for keeping track of where in the radio set the table is
   */
  public function __construct($name, $rows, $header){
    $this->_name = $name;
    $this->_header = array_keys($header);
    $this->_format = $this->makeFormat($header);
    $this->_rows = $this->makeRows($rows, $this->_format);
    
  }
  
  /**
   * a method for some array foo.
   *
   * takes an array of the form old key => either:
   * new key => value or an int (for a drop)
   * drops all values where the old key => int, and makes a new array of
   * the form key => value from the old values.
   *
   * @param mixed array $raw_array: an array of the form above
   *
   * @return array $output: the new array
   */
  private function makeFormat($raw_array){
    // setup the return array
    $output = array();
    
    //itterate though the raw array because of mixed types
    foreach($raw_array as $key => $value){
      if(gettype($value) == "array"){ $output[array_keys($value)[0]] = array_values($value)[0]; }
    }
    
    return $output;
  }
  
  /**
   * makes the array of rows for the cell
   *
   * takes an array of row data, and returns rows of the format
   * 
   *
   * @param array $rows an array of row data
   * @param array $format an array of how to format the row cells
   * @param str $name optional name part, for use if no id row set
   *
   * @return array $output an array of row objects with member cell objects
   */
  private function makeRows($rows, $format){
    // initalize the output array
    $output = array();

    // loop... because loops
    foreach($rows as $row => $rowContent){
      $a_row = new Row($this->_name, $rowContent, $format);
      $rowName = $a_row->getName();
      $output[$rowName] = $a_row;
    }
    
    return $output;
  }
  
 /* openTable()
  *
  * Returns a string for the opening of a table wrapped in a form. This can
  * be wrapped in other functions because it's a string each table is also
  * wrapped in a container div.
  *
  * @param str $name the name of form to wrap table in.
  * @param str $form_id the id of the form
  * @param str $table_id the id of the table
  * @param str $form_class the class of the form
  * @param str $table_class the class of the table
  *
  * @return str $output the HTML for the opening of the form.
  */
  protected function openTable($name, $form_id, $form_class, $table_id, $table_class){
    $form_attribs = '';
    $table_attribs = '';
    if($form_class != null){$form_attribs .= ' class="' . $form_class . '"';}
    if($form_id != null){$form_attribs .= ' id="' . $form_id . '"';}
    if($table_class != null){$table_attribs .= ' class="' . $table_class . '"';}
    if($table_id != null){$table_attribs .= ' id="' . $table_id . '"';}

    
    $output ='
  
        <div class="container"><!-- Form & Table Wrapper -->
          <form name="' . $name . '"' . $form_attribs . ' method="post">
            <table class="table table-hover"' . $table_attribs . '>';
            
    return $output;
  }
  
  
  /**
   * output test function
   */
  public function test(){
    foreach($this->_rows as $arow){
      echo"<br><tr>";
      $arow->test();
      echo"</tr>";
    }
  }
  
  
  /**
   * __toString() method:
   *
   * print openTable()
   * for each row, print it
   * add button for update if needed
   * close table
   */
  
}