<?php
// check to see if depaancy includes should be in the highest level abstraction
// class (eg, row should included here? with cells included there?)



/**
 * Table
 *
 * The table class is a near top level abstraction for the backend of the
 * site. It would more correctly be called TableAndForm, as it wraps in a form
 * as well as a table, and presumes that the end user is either trusted enough
 * to not try and break the form, or that the form will be used.
 *
 * It constructs a table, form, and depending on extensions, other goodies that
 * are assoicated with the said form.
 *
 * Takes a name string, and an array of the format key => row array
 * (see class.row), and a header array in the format of Field Text => array(
 * cell name => cell type) or Field Text => placeholder int (for radios)
 * 
 *
 *
 * Noteable methods:
 *
 * Constructor: 
 * public function __construct($name, $rows, $header)
 *
 * Setters for HTML Classes and IDs:
 * public function setTableId($table_id)
 * public function setTableClass($table_class)
 * public function setFormId($form_id)
 * public function setFormClass($form_class)
 *
 * Methods to change functionality:
 * public function submitOff()
 * public function addCounter($text, $column, $value=null)
 *
 * Setters to do an action to each row:
 * public function setCellClass($cell, $class)
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
  protected $_extra = null; // extra items to put at the bottom of the row
  
  // config attributes
  protected $_makeButton = true; //make a submit button
  
  // specific task attributes (too few to make new class)
  protected $_offline_check = false; //for the beer display only
  
  /**
   * Constructor
   *
   * a basic table & form constructor.
   *
   * @param str $name the name of the form
   * @param mixed array $rows array of row name => (cell value array)
   * @param mixed array $header array of header name => array(cell name => format)
   * @param bool $protected -if the view is protected, disabling any inputs
   *
   * due to radio buttons, some of the values in the header array may not be
   * name => array but rather name => int where the in is just a placeholder
   * for keeping track of where in the radio set the table is
   */
  public function __construct($name, $rows, $header, $protected=false){
    $this->_name = $name;
    $this->_header = $this->makeHeader($header);
    $this->_format = $this->makeFormat($header);
    if($protected){$this->submitOff();}
    $this->_rows = $this->makeRows($rows, $this->_format, $protected);
    
  }
  
  /**
   * turns off the display of a form submit button
   */
  public function submitOff(){
    $this->_makeButton = false;
  }
  
  /**
   *
   * Setter for the HTML id attrib on the table opening tag.
   *
   * @param str $table_id the id to be added to the table
   */
  public function setTableId($table_id){
    $this->_table_id = $table_id;
  }
  
  /**
   *
   * Setter for the HTML class attrib on the table opening tag.
   *
   * @param str $table_class the class(es) to be added to the table
   */
  public function setTableClass($table_class){
    $this->_table_class = $table_class;
  }
  
  /**
   *
   * Setter for the HTML id attrib on the form opening tag.
   *
   * @param str $form_id the id to be added to the form
   */
  public function setFormId($form_id){
    $this->_form_id = $form_id;
  }
  
  /**
   *
   * Setter for the HTML class attrib on the form opening tag.
   *
   * @param str $form_class the class to be added to the form
   */
  public function setFormClass($form_class){
    $this->_form_class = $form_class;
  }
  
  protected function makeHeader($raw_header){
    $output = array();
    foreach($raw_header as $header => $inner_array){
      if(gettype($inner_array) != "array"){array_push($output, $header);}
      else{
        $temp_array = array_values($inner_array);
        if (strpos($temp_array[0], "private") === false){array_push($output, $header);}
      }
    }
    return $output;
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
  protected function makeFormat($raw_array){
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
   * @param bool $protected if the row is to be protected or not
   *
   * @return array $output an array of row objects with member cell objects
   */
  private function makeRows($rows, $format, $protected){
    // initalize the output array
    $output = array();

    // loop... because loops
    foreach($rows as $row => $rowContent){
      $a_row = new Row($this->_name, $rowContent, $format, $protected);
      $rowName = $a_row->getName();
      $output[$rowName] = $a_row;
    }
    
    return $output;
  }
  
 /**
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
  protected function openTable($name, $form_id=null, $form_class=null,
                               $table_id=null, $table_class=null){
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
   *
   * Returns a string for the table header on the table
   *
   * @param str $names the names of each form field
   *
   * @return str $output the HTML for the table header
   */
  protected function tableHeader($names){
    $output ='
              <thead>
                <tr>';
    foreach($names as $key => $name){
      $output .= '
                  <th>' .$name .'</th>';
    }
    $output .='
                </tr>';
    
    return $output;
  }
  
  /**
   * Sets the class of a cell for all cells with that name in all rows.
   *
   * @param str $cell: the name of the cell, cell name only
   * @param str $class: the class to be added to the cell
   */
  public function setCellClass($cell, $class){
    foreach($this->_rows as $name => $row){$row->setCellClass($cell, $class);}
  }
  
  /**** BEGIN OF BEER AND WINE INVENTORY EXTENSION METHODS ****/
  
  /**
   * Counts the number of checks or radio selects in a given column
   * 
   * @param str $column: the name of the column to querry in each row.
   * @param str $value: the enumn value if type radio
   *  
   * @return int $output: the number of tics in the column
   */
  public function countColumn($column, $value=null){
    $counter = 0;
    foreach($this->_rows as $name => $row){
      if($row->getCell($column, $value)){$counter ++;}
    }
    return $counter;
  }
  /**
   * adds a counter to the end of the table to display the total of a given
   * column. This sets an ID for JS to use, so only one copy can be used
   * unless the method is modified. The counter is added by adding the
   * text to the $_extra property of the table.
   *
   * @param str $text = the text for the button
   * @param str $column = the name of the column selected
   * @param str $value = the column value for radio buttons.
   *
   */
  public function addCounter($text, $column, $value=null){
    $output ='<span class="label label-info">';
    $output .= $text . ' ';
    $output .= '<span id="counter" class="label label-success">';
    $output .= $this->countColumn($column, $value);
    $output .='</span></span>';
    
    $this->_extra = $output;
  }
  
  /**
   * Setter function to activte the allowOffline function durring the toString
   * creation, off by default
   */
  public function offlineCheck(){
    $this->_offline_check = true;
  }
  
  /**
   *  checks each row to see if they are eligable for going offline due to lack
   *  of use within the bounds of the time defined by $constant.
   *
   *  While this method is called allowOffline it actually sets disabled where
   *  a row would not be allowed to be offline. If the row should be set to
   *  disable for offline, it does so, otherwise, it just passes.
   *  
   *  @param int $constant a defined constant for how long before opening up a
   *  drink to going off-line
   *  @param str $off the timestamp of when off-line
   *  @param str $on the timestamp of when on-line
   *  @param str $target the target cell, if this is a CSV, then the format
   *  is cellname[value] (for radio cells)
   *  
   */
  protected function allowOffline($constant, $off="beer_offtap",
                                  $on = "beer_ontap", $target="beer_status, 3"){
    foreach($this->_rows as $name => $row){
      $offtap = $row->getHidden($off);
      $ontap = $row->getHidden($on);
      
      // check if the $taget is for a radio cell:
      if(strpos($target, ",")){
        $pieces = explode(",", $target);
        $cell_name = $pieces[0];
        $cell_number = intval(trim($pieces[1]));
      } else{
        $cell_name = $target;
        $cell_number = null;
      }
      
      // I'm using really explicit logic here so that anyone can come back to
      // this and tinker with it as need be.
      
      // if offtap is null then it has never been kicked
      // if ontap is null then it has never been on tap (deck only)
      // in either case is not eligable to go offline
      if($offtap == null or $ontap == null){
        $row->setDisabled($cell_name, $cell_number);
        
      // if the ontap date is more recent then the kicked date, continue
      } elseif($ontap > $offtap) {
        $row->setDisabled($cell_name, $cell_number);
      
      // if offtap is greater then ontap
      } else {
        
        // if the diffrence is less then the constant
        if (($offtap - $ontap) < $constant) {
          $row->setDisabled($cell_name, $cell_number);
       // ok, in the remaing case the value is >= the $constant
        } else{
          continue;
        }
      }
    }
  }
  /**** END OF BEER AND WINE INVENTORY EXTENSION METHODS ****/
  
  /**
   *
   * Returns a string for the update button on the form.
   *
   * @param str $name the name of the form
   *
   * @return str $output the HTML for the update button
   */
  protected function updateButton($name){
    // See http://bavotasan.com/2009/processing-multiple-forms-on-one-page-with-php/
    $name .= "-update"; // for use in processing.
    $output ='
            <tr><input class="btn pull-right clearfix btn-primary" name="'. $name .'"type="submit" value="Update"></tr>';
    
    return $output;
  }
  

  /**
   * output test function
   */
  public function test(){
    echo "<pre>";
    var_dump($this->_rows);
  }
  
    /* closeTable()
   *
   * Returns a string to close up a table of the form opened by the openTable()
   * function.
   *
   * @param str $extra any extra text to be inserted between the close of the
   * table and the close of the form.
   *
   * @return str $output the HTML for the closing of the form.
   */
  
  private function closeTable($extra=null){
    $output ='
            </table>';
  
    if($extra != null) {$output .= $extra;}
    if($this->_makeButton){$output .=$this->updateButton($this->_name);}
    $output .='
          </form>
        </div><!-- Form & Table Wrapper-->';
    
    return $output;
  }
  
  public function __toString(){
    if($this->_offline_check){$this->allowOffline(TIME_TO_OFF_LINE);}
    $output = '';
    
    // open the table
    $output .= $this->openTable($this->_name, $this->_form_id, $this->_form_class,
                                $this->_table_id, $this->_table_class);
    
    // make the header
    $output .= $this->tableHeader($this->_header);
    
    // make all the rows
    foreach($this->_rows as $row){$output .= $row;}
    
    //close out the table
    $output .= $this->closeTable($this->_extra);
    
    // return the output
    return $output;
  }
  
}