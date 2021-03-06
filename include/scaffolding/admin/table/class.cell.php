<?php

/**
 * Cell
 *
 * This creates cells for a table (<td></td>)
 *
 * The base cell class creates a cell that contains contents generated
 * elsewhere. This is intended for receiving text or low interactivity
 * content. Extension of this class will generate more complex cell
 * types to be used with forms.
 * 
 */
class Cell {
  
  // all cells will have names & ids, which can be shown, and text.
  protected $_name;
  protected $_id;
  protected $_showDetails = false; //by default it doesn't show the name and ID.
  protected $_class; // for the cell class
  protected $_content;
  protected $_tooltip = ''; // for tool tips, which may be of use in base & extensions
  protected $_buttons = array(); // for cells extended with buttons
  protected $_colspan = 1; // for use with extensions.
  protected $_hidden= false;
  
  /**
   * Sets the $_name and $_id to the same thing on construction.
   *
   * @param str $name: the name & id of the Cell
   * @param str $text: the text content of the Cell
   */
  public function __construct($name, $text){
    $this->_id = $name;
    $this->_name = $name;
    $this->_content = $text;
  }
  
  /**
   *  Adds a button to the cell, for control of various items related to
   *  the given text.
   *
   *  @param str $form: the form the button is associated with
   *  @param str $record: the specific record the inline button is for.
   *  @param str $action: a suffix to be passed to the processor for the action.
   *  @param str $display: either text or the name of a glyphicon for button
   *  @param bool $text: if the $display is a text or a glyphicon
   *  @param bool $active: if the button should be disabled.
   *  @param bool $included: if the name already has the form included
   */
  public function addButton($form, $record, $action, $display, $text=false, $active=false, $included=false){
    $button_text = $display;
    $button_name = $form . '-' . $action;
    $if_active = '';
    $disabled = '';
    
    if($active){
      $if_active = " active";
      $disabled = ' disabled="disabled"';
      }
    
    // "included" for use in tables where the cell name is preprocessed
    if($included == false){
      $button_id = $form.'['.$record.']['. $button_name.']';
    }else{
      $button_id =  $record . '['. $button_name.']';
    }
    if ($text){ $button_content = ucwords($display);}
    else {$button_content = '<span class="glyphicon '. $display . '"></span>';}
    if ($text === true){
      $output = '<button type="submit" class="btn btn-primary edit-icon btn-xs'. $if_active.'"';
    } elseif ($text === "large"){
      $output = '<button type="submit" class="btn btn-primary edit-icon'. $if_active.'"';
    } else {
      $output = '<button type="submit" class="btn btn-primary edit-icon btn-sm'. $if_active.'"';
    }
    $output.= ' id="' . $button_id .'" name="' . $button_name .'" value="';
    $output.= $record .'"'. $disabled . '>' . $button_content ."</button>";
    $this->_buttons[] = $output;
    
  }
  
  /**
   * Setter for the $_name attribute
   *
   * @param str $name: the new value for the name
   */
  public function setName($name){
    $this->_name = $name;
  }
  
  /**
   * Setter for the $_id attribute
   *
   * @param str $id: the new value for the id
   */
  public function setId($id){
    $this->_id = $id;
  }

  /**
   * Setter for the $_class attribute
   *
   * @param str $class: the new value for the id
   */
  public function setClass($class){
    $this->_class = $class;
  }
  
  
  /**
   * Setter for the $_content attribute
   */
  public function setContent($content){
    $this->_content = $content;
  }
  
  /**
   * Sets the hidden attribute to true
   */
  public function setHidden(){
    $this->_hidden = true;
  }
  
  /**
   * Sets a bootstrap floating tooltip on the cell.
   *
   * @param str $tip = the tool tip for the cell
   * @param str $placement (o) the data placement attribute
   */
  public function setToolTip($tip, $placement="right"){
    $this->_tooltip = ' data-toggle="tooltip" data-placement="' . $placement . '" title="' . $tip . '"';
  }
  
  /**
   * Sets the cell to show the cell name and id
   */
  public function showDetails(){
    $this->_showDetails = true;
  }

  /**
   * Gets the cell name
   *
   * @return str the cell name
   */
  public function getName(){
    return $this->_name;
  }
  
  /**
   * Returns the state of hidden on the cell.
   */
  public function getHidden(){
    return $this->_hidden;
  }
  
  /**
   * Gets the cell id
   *
   * @return str the cell id
   */
  public function getId(){
    return $this->_id;
  }
  
  /**
   * Gets the column span value
   */
  public function getSpan(){
    return $this->_colspan;
  }
  
  /**
   * Gets the cell value
   */
  public function getValue(){
    return $this->_content;
  }

  public function __toString(){
    $text = $this->_content;
    foreach($this->_buttons as $button){
      $text .= '
                    '. $button;
    }
    $attribs = '';
    if ($this->_class != null){$attribs .= ' class="'. $this->_class . '"';}
    if ($this->_showDetails == true){  
      if ($this->_id != null){$attribs .= ' id="' . $this->_id . '"';}
    }
    
    $attribs .= $this->_tooltip;
    
    if($this->_hidden){$attribs .= " hidden";}
    
    //if(is_array($text)){echo"<pre>".var_dump($text)."</pre><br>";;}
    $output = '
                  <td' . $attribs . '>'. $text . '</td>';

    return $output;
  }
}