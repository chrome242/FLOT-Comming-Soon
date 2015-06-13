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
 * Optional bool param for protected views. This is for allowing view of
 * a table with input elements to untrusted viewers. Will remove all IDs,
 * & names from inputs, and disable the cells.
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
 *  (b) = allows in field buttons:
 *      duration
 *      number
 *      private
 *      plain
 *      select
 *      text
 *      textarea
 *      time
 *      
 *  (h) = denotes a cell that has special effects on the header.
 *      drop (cell not kept)
 *      newrow (halts further headers, makes record move to new row)
 *      private (no addition to header, cells in row go to private array)
 *      time (can be set to private when that occurs, cell act like above)
 *      
 *  (o) = optional part of string:
 *  NOTE THAT IF A STRING HAS OPTIONAL PARTS, THEY MUST BE INCLUDED IN ORDER,
 *  AND CAN BE PASSED OVER WITH A VALUE OF 'none' (e.g. number, x, none, 42)
 *
 *
 *  
 * Short Cell Docs:
 * 
 * button, x(o) where x is 'right' if right justifed. - an inline button. 
 * checkbox - x(o) where x is 'off' if disabled
 * drop - not placed in the table (h)
 * duration, x, y(o) where x & y are either timestamps or cell names (b)
 * id - plain text cell who's value is attached to the row name (b)
 * newrow - a cell that produces a visual new row while allowing continued record (h)
 * number, x, y(o), z(o), where x = number or placeholder y= step(o), z= size(o)(b)
 * password, x = a password entry where x = text or placeholder (b)
 * private - placed in the internal cell array as basic text (h) (b)
 * plain - a basic cell (b)
 * radio, # - a radio set of # cells
 * select, x(o), y(o), z(o) where x = default value(o), y= multiple(o), z= size(o)(b)
 * text, x = a text entry where x = text or placeholder (b)
 * textarea, x, y(o), z(o), where x = text or placeholder y= rows(o), z= colspan(o)(b)
 * time, x - a timestamp where x = show or private (h)(b)
 * url - a URL cell. much like basic text
 *
 *
 * Notable class methods-
 * 
 *  constructor:
 *  public function __construct($name, $cells, $format)
 *
 *  Class getters:
 *  public function getName()
 *
 *  Setters for HTML attributes:
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
 *  public function addCellButton($cell, $suffix, $content, $text)
 * 
 * Expanding use of class:
 *  To add new cell types the logic in makeCells must be updated
 *  Any input cells need to have a setup for $protected in their makeCell
 * 
 */
class Row {
  
  // class attributes for the row
  protected $_name; // the name of the row.
  protected $_class = null;
  protected $_id = null;
  protected $_tableName; // the name passed in from the table
  protected $_rowShortName; // either the name if no ID cell, or the ID cell id
  
  // class attributes for member cell storage
  // the below is stored by cell id (not name) due to radio buttons
  protected $_cells; //an array of cells prior to string construction.
  protected $_privateCells; //cells for internal use, such as timestamp math
  
  // class attributes for output
  protected $_output; //the output string
  
  /**
   * Constructor
   *
   * constructs a basic row from the $array and $types vars.
   * If the array length does not equal the length of the split
   * string from vars, it will raise an error.
   *
   * @param str $name the name of the row or partial name of the row
   * @param array mixed $cells: the cells that belong to the row
   * @param array str $format: an array of cell types
   * @param bool $protected: a bool for if this is a protected view or not
   */
  public function __construct($name, $cells, $format, $protected=false){
    $this->_name = $this->makeName($name, $cells, $format);
    $this->makeCells($cells, $format, $protected);
  }
  
  /**
   * getter function for the row name
   *
   * @param bool $short if set then return the short name
   *
   * @return str  $output the name of the row object
   */
  public function getName($short=false){
    if($short) { return $this->_rowShortName; }
    else { return $this->_name; }
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
  
  protected function makeName($name, $cells, $format){

    $output = $name;
    $this->_tableName = $name;
    $this->_rowShortName = $name; // if this row encapsulates the entire data set
    foreach($format as $cell_name => $type){
      if($type == "id"){
        $output .= '['.$cells[$cell_name].']';
        $this->_rowShortName = $cells[$cell_name]; // most the time this will be the case
      }
      
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
  protected function makeCells($cells, $format, $protected){

    foreach($cells as $name => $value){
      if(isset($format[$name])){
        $cell_name = $this->_name . '['. $name . ']'; // should work for non-radios
        
        // TODO: consider replacing simple string checking with an explosion and check for
        // the value of position 1, so as to not restrict word use in cell names for
        // cell types that take args which can contain words.
        
        // id cell
        if($format[$name] == 'id'){$this->_cells[$cell_name] = new Cell($name, $value);}
        
        // text cell
        if($format[$name] == 'plain'){ $this->_cells[$cell_name] = new Cell($name, $value);}
        
        // URL cell
        if($format[$name] == 'url'){$this->_cells[$cell_name] = new UrlCell($name, $value);}
        
        // new row
        if($format[$name] == 'newrow'){$this->_cells[$cell_name] = new NewRow();}
        
        // private (text) cell private
        if($format[$name] == 'private'){ $this->_privateCells[$cell_name] = new Cell($name, $value);}
        
        // button cell
        if(stripos($format[$name], 'button') !== false){
          
          $this->_cells[$cell_name] = new Button($this->_tableName, $this->_rowShortName, $value);
          
          // if it has args
          if(stripos($format[$name], 'button,') !== false){
            $this->_cells[$cell_name]->setButtonClasses("btn btn-primary edit-icon");
          }
          
          if($protected){
            // make an empty cell if the table is in a protected view
            $this->_cells[$cell_name] = new Cell($name, '');
          }
        }
        
        //checkbox cell
        if(stripos($format[$name], 'checkbox') !== false){
          if(stripos($format[$name], 'checkbox,') !== false){
            $this->_cells[$cell_name] = new Checkbox($cell_name, $value);
            $this->_cells[$cell_name]->disabled();
            if($protected){
              $this->_cells[$cell_name]->hideDetails();
            }
          }
          else {
            $this->_cells[$cell_name] = new Checkbox($cell_name, $value);
            if($protected){
              $this->_cells[$cell_name]->disabled();
              $this->_cells[$cell_name]->hideDetails();
            }
          }
        }
        
        //timestamp cell
        if(stripos($format[$name], 'time,') !== false){
          $pieces = explode(",", $format[$name]);
          $where_to = trim($pieces[1]);
          
          if($where_to != "private") {
            $this->_cells[$cell_name] = new Timestamp($cell_name, $value, true);
          }
          else{
            $this->_privateCells[$cell_name] = new Timestamp($cell_name, $value, false);
          }
        }
        
        //text cell
        if(stripos($format[$name], 'text,') !== false){
          $pieces = explode(",", $format[$name]);
          $type = trim($pieces[1]);
          $cell_value = $value;
          if(is_array($value)){
            $cell_value = $value[0][$value[1]];
          }
          
          $this->_cells[$cell_name] = new Text($cell_name, $cell_value, $type);
          
          if($protected){
            $this->_cells[$cell_name]->disabled();
            $this->_cells[$cell_name]->hideDetails();
          }
        }
        
        if(stripos($format[$name], "password") !== false){
          $pieces = explode(",", $format[$name]);
          $type = trim($pieces[1]);
          $this->_cells[$cell_name] = new Text($cell_name, $value, $type, true);
          
          if($protected){
            $this->_cells[$cell_name]->disabled();
            $this->_cells[$cell_name]->hideDetails();
          }
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
          
          $this->_cells[$cell_name] = new Number($cell_name, $value, $type, $step, $size);
          
          if($protected){
            $this->_cells[$cell_name]->disabled();
            $this->_cells[$cell_name]->hideDetails();
          }
        }
        
        // textarea -surprisingly identical to number... might need to functionality
        if(stripos($format[$name], 'textarea,') !== false){
          $pieces = explode(",", $format[$name]);
          $type = trim($pieces[1]);
          $row = null;
          $colspan = null;
          
          if (count($pieces) > 2){
            if ($pieces[2] != 'none'){$row = trim($pieces[2]);}
            if ($pieces[3] != 'none'){$colspan = trim($pieces[3]);}
          }
          
          $this->_cells[$cell_name] = new Textarea($cell_name, $value, $type, $row, $colspan);
          
          if($protected){
            $this->_cells[$cell_name]->disabled();
            $this->_cells[$cell_name]->hideDetails();
          }
        }
        
        // duration cells
        // using the same task specific names as the target class to keep things simple
        // any cells being used for the math-foo here must, obviously, be declared first
        // and must be in the hidden array for the row.
        if(stripos($format[$name], 'duration,') !== false){
          $pieces = explode(",", $format[$name]);
          $ontap = trim($pieces[1]);
          $offtap = 0;
          
          if(count($pieces) > 2 ){
            $offtap = trim($pieces[2]);
          }
          
          //functionalize this if I end up using it more then these 2 times
          if(is_numeric($ontap)){
            $processed_ontap = $ontap;
          } else{
            $processed_ontap = $this->getHidden($ontap);
          }
          
          if(is_numeric($offtap)){
            $processed_offtap = $offtap;
          } else{
            $processed_offtap = $this->getHidden($offtap);
          }
          
          $this->_cells[$cell_name] = new Duration($cell_name, $processed_ontap,$processed_offtap);
        }
        
        // select cells
        if(stripos($format[$name], 'select') !== false){
          
          $inner_value = $value;
          
          // check if the value is an 2 dimensional array, if that is the case
          // then the first arg is array of values and the second arg is the
          // selected value
          if (is_array($value[1])){
            $inner_value = $value[1];
            $selected = $value[2];
          }
          
          // if it has args
          if(stripos($format[$name], 'select,') !== false){
            $pieces = explode(",", $format[$name]);
            if(!isset($selected) && $pieces[1] != 'none'){
             $selected = trim($pieces[1]); //default selected value
            }
            $mutiple = null;
            $size = null;
            
            if (count($pieces) > 2){
              if ($pieces[2] != 'none'){$mutiple = trim($pieces[2]);}
              if ($pieces[3] != 'none'){$size = trim($pieces[3]);}
            }
            
            $this->_cells[$cell_name] = new Select($cell_name, $inner_value,
                                                   $selected, $mutiple, $size);
          }
          // if no args
          if(stripos($format[$name], 'select,') === false){
            if(!isset($selected)){
              $this->_cells[$cell_name] = new Select($cell_name, $inner_value);
            }
            else {
              $this->_cells[$cell_name] = new Select($cell_name, $inner_value, $selected);
            }
          }
          
          if($protected){
            $this->_cells[$cell_name]->disabled();
            $this->_cells[$cell_name]->hideDetails();
          }
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
              $this->_cells[$radio_cell_name] = new Radio($cell_name, $cell_value, true);
              
              if($protected){
                $this->_cells[$radio_cell_name]->disabled();
                $this->_cells[$radio_cell_name]->hideDetails();
              }
            }
            else {
              $this->_cells[$radio_cell_name] = new Radio($cell_name, $cell_value, false);
              
              if($protected){
                $this->_cells[$radio_cell_name]->disabled();
                $this->_cells[$radio_cell_name]->hideDetails();
              }
            }
            
            $cell_value ++;
          }
        }
        
        // dropped cells
        if($format[$name] == 'drop'){ }
        
      }
    }
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
   * @param str $cell: the name of the cell
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
   * @param str $cell: the name of the cell
   * @param str $class: the class to be added to the cell
   */
  public function setCellClass($cell, $class){
    // construct name
    $cell_name = $this->_name . '['. $cell . ']';
    
    // do job
    if(isset($this->_cells[$cell_name])){
      $this->_cells[$cell_name]->setClass($class);
    }
  }
  

  /**
   * Adds a in cell button to any of the cell elements that can support it for
   * cell of a given name of cell
   *
   * @param str $cell: the name of the cell
   * @param str $suffix: the item to be appened to the cell id for the button
   * @param str $content: the text for the cell or the name of the glyphicon
   * @param bool $text: if the $content is a text string (t) or a glypicon (f)
   */
  public function addCellButton($form, $cell, $suffix, $content, $text){
    // construct name
    $cell_name = $this->_name . '['. $cell . ']';
    
    // do job
    if(isset($this->_cells[$cell_name])){
      $this->_cells[$cell_name]->addButton($form, $this->_rowShortName, $suffix, $content, $text);
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

