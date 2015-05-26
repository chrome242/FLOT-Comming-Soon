<?php

/**
 * Small Table
 *
 * This is a heavy rework of the table class. It's design presumes that each cell
 * is a distinct record and that said cell will be accessed directly via an enbedded
 * button. Any whole table operations (such as a submit) will be accessed via a
 * an extern update button indicating an update in this form via the <formname>-update
 * syntax.
 *
 * This class is also constructed so that a new toString will allow it be to extended
 * to a list handler rather than a table handler.
 *
 * 
 * 
 */
class SmallTable extends Table{ 
  
  // class attributes

  
  // member portion attributes
  protected $_cells;  //the array of cells
  protected $_rows; //the number cells per row
  
  // config attributes
  protected $_makeButton = false; //make a submit button

  
  
  /**
   * Constructor
   *
   * a basic table & form constructor.
   *
   */
  public function __construct($name, $cells, $cols){
    $this->_name = $name;
    $this->_cells = $tobeimplimented;
    $this->_rows = $cols;
    
  }
  
  
  // takes the number of columns, and subtracts from it the colspan of the cell,
  // and uses this to determine when the new row should start.
  
  // the cells created for this table type will have ids of form[cellname]
  
  
  /**
   * output test function
   */
  public function test(){
    echo "<pre>";
    var_dump($this->_cells);
  }
  
  
}