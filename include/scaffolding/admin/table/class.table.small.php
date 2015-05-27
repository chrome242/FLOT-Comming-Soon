<?php

/**
 * Small Table
 *
 * This is a heavy rework of the table class. This class does not use row as
 * an interface with the cell class, but rather produces cells directly. 
 * This class presumes that a single record can be one or more then one cells,
 * generates them all, and then hides some (later iterations of this class may
 * do other fun things as well) and that a row only has a set column width. The
 * row is passed a list of records in the form of record_id => (key => value,
 * key => value) which is the basis of what the cells will contain and what they
 * will post too. These will be used to make the cells for all keys. A second
 * array will be in the in the form of record_id => (key => (cell string, hidden=bool))
 *
 * Hidden cells are forced into their own row below the parent row, however, if the
 * colspan of the hidden fields is diffent then that of their parents, it will
 * react as such, mostly just using a modulious, so the smart way to deal with
 * this is to make the hidden elements either full length or the size of the parents
 * or a mutiple of the size of the parents that the width of the row is divisable by
 *  
 * Extensions of the cell class that will be assured to be supported by this class:
 * 
 * button - an inline button. 
 * plain - a basic cell (b)
 * text, x = a text entry where x = text or placeholder (b)
 * textarea, x, y(o), z(o), where x = text or placeholder y= rows(o), z= colspan(o)(b)
 * url - a URL cell. much like basic text
 *
 * Extensions that should work with the class, will have constructor:
 * checkbox - a checkbox
 * drop - not placed in the table (h)
 * number, x, y(o), z(o), where x = number or placeholder y= step(o), z= size(o)(b)
 * select, x(o), y(o), z(o) where x = selected value(o), y= multiple(o), z= size(o)(b)
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
   * a basic table & form constructor for use making a table of non-row
   * tied records and producing HTML with bootstrap classing. The table is
   * also a record editing form structure.
   *
   * @param str $name: the name of the table form
   * @param array $cells: An array of records to be made into cells.
   * @param array $format: An array to direct the formating of the cells
   * @param int $cols: the # of columns for the table
   */
  public function __construct($name, $cells, $format, $cols){
    $this->_name = $name;
    $this->_cells = $cells;
    $this->_header = $format;
    $this->_rows = $cols;
    
  }
  
  
  // takes the number of columns, and subtracts from it the colspan of the cell,
  // and uses this to determine when the new row should start.
  
  // the cells created for this table type will have ids of form[cellname]
  
  
  private function hiddenCheck($cell){
    
  }
  
  /**
   * output test function
   */
  public function test(){
    echo "<pre>";
    var_dump($this->_cells);
  }
  
  
}