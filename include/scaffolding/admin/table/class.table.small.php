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
 * Extensions that should work with the class, might impliment constructor:
 * checkbox - a checkbox
 * drop - not placed in the table (h)
 * number, x, y(o), z(o), where x = number or placeholder y= step(o), z= size(o)(b)
 * select, x(o), y(o), z(o) where x = selected value(o), y= multiple(o), z= size(o)(b)
 *
 * NEW cell interfaces for this class-
 * editPlain - a basic cell with a buton for an edit included
 * editText - an edit cell with a button for drop and a button for edit (active)
 * (sets text to text)
 * addText - an edit cell set to disabled with a add cell button
 * (sets text to placeholder)
 */
class SmallTable extends Table{ 
  
  // class attribute overrides
  protected $_table_id = false; // the table id
  protected $_table_class = false; // the table class
  protected $_form_id = false; // the form id
  protected $_form_class = false; // the form class
  
  // member portion attributes
  protected $_cells;  //the array of cells
  
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
 
    $this->_format = $format;
    $this->_rows = $cols;
    
    $this->makeCellArray($cells, $format);
    
  }
  
  
  // takes the number of columns, and subtracts from it the colspan of the cell,
  // and uses this to determine when the new row should start.
  
  // the cells created for this table type will have ids of form[cellname]
  
  /**
   * Returns an array of cells encapsulating the information in the $cells array.
   * It uses the the $format array to determine how to make them.
   *
   * @param array $data: an array of data to make one ore more cells.
   * @param array $format: an array to formate one or more cells.
   *
   * @return array: an array of cell objects.
   */
  protected function makeCellArray($data, $format){
    // break down the data array to indivdual field arrays
    
    foreach($data as $record => $fields){
      // get the record portion of the name
      $recordName = $record;
      
      // check each indivdual datapoint
      foreach($fields as $key => $value){
        
        // get the field name
        $fieldName = $key;
        
        // get the cell type and the hidden state from the format array
        list($cellType, $hidden) = $format[$recordName][$fieldName];
        $cellName = $this->_name . '[' . $recordName . ']['. $fieldName .']';
        
        // make the indivdual cell
        $thisCell = $this->makeCell($cellName, $cellType, $value);
        
        // set hidden if hidden:
        if($hidden){ $thisCell->setHidden();}
        
        // add the cell to the list
        $this->_cells[$cellName] = $thisCell;
      }  
    }
    
  }
  
  
  protected function makeCell($cellName, $cellType, $value){
    // plain text cell
    if($cellType == 'plain'){ $thisCell = new Cell($cellName, $value);}
    
    // purpose specific edit plain cell
    if($cellType == "editPlain"){
      $thisCell = new Cell($cellName, $value);
      $thisCell->setId(Null);
      $thisCell->setClass("col-xs-3");
      $thisCell->showDetails();
      $thisCell->addButton($this->_name, $cellName, "edit", "glyphicon-cog", false, false, true);
    }
    //button cell      
    if($cellType == 'button'){ $thisCell = new Button($this->_tableName, $cellName, $value); }
    
    // URL cell
    if($cellType == 'url'){ $thisCell = new UrlCell($cellName, $value);}
    
    //text cell
    if(stripos($cellType, 'text,') !== false){
      $pieces = explode(",",$cellType);
      $type = trim($pieces[1]);
      $thisCell = new Text($cellName, $value, $type);
      
    }
    
    // purpose specific edit text cell
    if($cellType == 'editText'){
      $thisCell = new Text($cellName, $value, "text");
      $thisCell->editFieldSmall();
      $thisCell->setClass("col-xs-3");
      $thisCell->addButton($this->_name, $cellName, "edit", "glyphicon-cog", false, true, true);
      $thisCell->addButton($this->_name, $cellName, "drop", "Drop", true, false, true);
    }
    
    if($cellType == 'addText'){
      $thisCell = new Text($cellName, $value, "placeholder");
      $thisCell->editFieldSmall();
      $thisCell->setClass("col-xs-3");
      $thisCell->disabled();
      $thisCell->addButton($this->_name, $cellName, "edit", "glyphicon-plus", false, false, true);      
    }
    
    // textarea 
    if(stripos($cellType, 'textarea,') !== false){
      $pieces = explode(",", $cellType);
      $type = trim($pieces[1]);
      $row = null;
      $colspan = null;
      
      if (count($pieces) > 2){
        if ($pieces[2] != 'none'){$row = trim($pieces[2]);}
        if ($pieces[3] != 'none'){$size = trim($pieces[3]);}
      }
      
      $thisCell = new Textarea($cellName, $value, $type, $row, $colspan);
  
    }
    return $thisCell;
  }
  
  /**
   * output test function
   */
  public function test(){
    echo "<pre>";
    var_dump($this->_cells);
    echo "</pre>";
  }
  
  
  public function __toString(){
    // make the output variable
    $output = '';
    
    $newrow = '
                <tr>';
    $endrow = '
                </tr>';
    
    // open the table
    $form_attribs = '';
    $table_attribs = '';
    if($this->_form_class){$form_attribs .= ' class="' . $form_class . '"';}
    if($this->_form_id){$form_attribs .= ' id="' . $form_id . '"';}
    if($this->_table_class){$table_attribs .= ' class="' . $table_class . '"';}
    if($this->_table_id){$table_attribs .= ' id="' . $table_id . '"';}

    $output .='
        <form name="' . $this->_name . '"' . $form_attribs . ' method="post">
          <div class="table">
            <table class="table table-bordered"' . $table_attribs . '>
              <tbody>';

              
    // Set up the row production.
    $total_cols_this_row = 0;
    $total_cols_hidden_row = 0;
    $max_cols = $this->_rows;
     
    // row vital vars:
    $thisrow = '';
    $thishidden = '';
    $hiddenrow = array();
    
    // loop though the cells
    foreach($this->_cells as $cell){
      
      // check if the cell is hidden.
      if($cell->getHidden()){
        // if so, add it to the hidden row
        array_push($hiddenrow, $cell);
      // if not, check if the cell size will fit in the row.
      } else{
        
        // if it fits, add it to the current row.
        if($total_cols_this_row + $cell->getSpan() <= $max_cols){
          $total_cols_this_row += $cell->getSpan();
          $thisrow .= $cell; // invoke the __toString()
        
        // if it doesn't fit, make the previous row, make any hidden rows,
        // start new rows. This will need to be reused for remaining items
        // following looping.
        } else {
          
          // concat the strings.
          $output .= $newrow . $thisrow . $endrow;
          
          // set the $total_cols_this_row to the size of the cell
          $total_cols_this_row = $cell->getSpan();
          // start $thisrow anew
          $thisrow = '' . $cell;
          
          // deal with the hidden row(s)
          foreach($hiddenrow as $hiddencell){
            if($total_cols_hidden_row + $hiddencell->getSpan() <= $max_cols){
              $total_cols_hidden_row += $hiddencell->getSpan();
              $thishidden .= $hiddencell; // invoke the __toString()
            
            // if it doesn't fit, make the previous row, make any hidden rows,
            // start new rows. This will need to be reused for remaining items
            // following looping.
            } else {
              // concat the strings.
              $output .= $newrow . $thishidden . $endrow;
              
              // start the vars back up:
              $total_cols_hidden_row = $hiddencell->getSpan();
              $thishidden = '' . $hiddencell;
            }
          }
          
          // deal with any "lose" hidden cells before starting a new row.
          if ($thishidden != ''){
            $fillerCell = new Cell('Filler', '');
            $fillerCell->setHidden();
            $filler_cols_need = $max_cols - $total_cols_hidden_row;
            for($i=0; $i<$filler_cols_need; $i++){
              $thishidden .= $fillerCell;
            }
            
            // add the lose ones to the table
            $output .= $newrow .$thishidden .$endrow; 
          }
          
          // clear out the hidden array
          $hiddenrow = array(); 
        }
      }
    }
    
    // TODO: Check the indentation level here
    // deal with remaining cells after all full rows have been constructed.
    if($thisrow != ''){
      $fillerCell = new Cell('Filler', '');
      $filler_cols_need = $max_cols - $total_cols_this_row;
      for($i=0; $i<$filler_cols_need; $i++){
        $thisrow .= $fillerCell;
      }
      
      $output .= $newrow . $thisrow . $endrow;
    }
    
    if(isset($hiddenrow[0])){
      foreach($hiddenrow as $hiddencell){
        if($total_cols_hidden_row + $hiddencell->getSpan() <= $max_cols){
          $total_cols_hidden_row += $hiddencell->getSpan();
          $thishidden .= $hiddencell; // invoke the __toString()
        
        // if it doesn't fit, make the previous row, make any hidden rows,
        // start new rows. This will need to be reused for remaining items
        // following looping.
        } else {
          // concat the strings.
          $output .= $newrow . $thishidden . $endrow;
          
          // start the vars back up:
          $total_cols_hidden_row = $hiddencell->getSpan();
          $thishidden = '' . $hiddencell;
        }
      }
    }
    
    
    // deal with any remaining hidden cells
    if ($thishidden != ''){
      $fillerCell = new Cell('Filler', '');
      $fillerCell->setHidden();
      $filler_cols_need = $max_cols - $total_cols_hidden_row;
      for($i=0; $i<$filler_cols_need; $i++){
        $thishidden .= $fillerCell;
      }
      
      // add the lose ones to the table
      $output .= $newrow .$thishidden .$endrow; 
    }
    
    //Close table
    $output .='
              </tbody>
            </table>
          </div>
        </form>';
  
  return $output;
  }
  
  
}