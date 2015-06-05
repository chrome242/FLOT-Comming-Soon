<?php

/**
 * PanelTable
 *
 * This extension of table alters the output to remove the div's from the
 * table class, so that it will not encounter some of the issues that table
 * does when trying to use it with a container div inside of a panel.
 *
 * The class overwrites the openTable and the closeTable methods, sets the
 * makeButton atrib to false, and reincludes the __toString because of PHP
 * and the lack of overrides.
 */
class PanelTable extends Table{
  
  // config attributes
  protected $_makeButton = false; //make a submit button
  
   
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
          <form name="' . $name . '"' . $form_attribs . ' method="post">
            <table class="table table-hover"' . $table_attribs . '>';
            
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
    $output = '';
    if($this->_makeButton){$output .=$this->updateButton($this->_name);}
    $output ='
              </tbody>
            </table>';
  
    if($extra != null) {$output .= $extra;}
    if($this->_makeButton){$output .=$this->updateButton($this->_name);}
    $output .='
          </form>';
    
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