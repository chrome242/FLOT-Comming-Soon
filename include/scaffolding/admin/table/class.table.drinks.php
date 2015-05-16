<?php
// check to see if depaancy includes should be in the highest level abstraction
// class (eg, row should included here? with cells included there?)

// DO PLEASE NOTE: THE METHOD TO ALLOW OFFTAP IS HARDCODED FOR TESTING AND LATER
// PRESUMED SINGLE USE. PLEASE CHANGE JUST IN CASE ONCE PAST TESTING

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
 * public function __construct($name, $rows, $header
 *
 * Setters:
 * public function setTableId($table_id)
 * public function setTableClass($table_class)
 * public function setFormId($form_id)
 * public function setFormClass($form_class)
 * public function submitOff()
 * 
 */
class DrinksTable extends Table {
  

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
  
}