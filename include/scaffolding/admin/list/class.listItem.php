<?php

/**
 * ListItem
 *
 * This creates listItem for a list (<li></li>)
 *
 * The base listItem class creates a li that contains contents generated
 * elsewhere. This is intended for receiving text or low interactivity
 * content. Extension of this class will generate more complex li
 * types to be used with forms.
 * 
 */
class ListItem {
  
  // all lis will have names & ids, which can be shown, and text.
  protected $_name;
  protected $_id;
  protected $_showDetails = false; //by default it doesn't show the name and ID.
  protected $_class; // for the li class
  protected $_content;
  protected $_tooltip = ''; // for tool tips, which may be of use in base & extensions
  protected $_buttons = array(); // for lis extended with buttons
  
  /**
   * Sets the $_name and $_id to the same thing on construction.
   *
   * @param str $name: the name & id of the li
   * @param str $text: the text content of the li
   */
  public function __construct($name, $text){
    $this->_id = $name;
    $this->_name = $name;
    $this->_content = $text;
  }
  
  /**
   *  Adds a button to the li, for control of various items related to
   *  the given text.
   *
   *  @param str $form: the form the button is associated with
   *  @param str $record: the specific record the inline button is for.
   *  @param str $action: a suffix to be passed to the processor for the action.
   *  @param str $display: either text or the name of a glyphicon for button
   *  @param bool $text: if the $display is a text or a glyphicon
   *  @param bool $active: if the button should be disabled.
   */
  public function addButton($form, $record, $action, $display, $text=false, $active=false){
    $button_text = $display;
    $button_name = $form . '-' . $action;
    $button_id = $form.'['.$record.']['. $button_name.']';
    if ($text){ $button_content = ucwords($display);}
    else {$button_content = '<span class="glyphicon '. $display . '"></span>';}
    $output = '<button type="submit" class="btn btn-primary edit-icon btn-xs"';
    $output.= ' id="' . $button_id .'" name="' . $button_name .'" value="';
    $output.= $record .'">' . $button_content ."</button>";
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
   * Sets a bootstrap floating tooltip on the li.
   *
   * @param str $tip = the tool tip for the li
   * @param str $placement (o) the data placement attribute
   */
  public function setToolTip($tip, $placement="right"){
    $this->_tooltip = ' data-toggle="tooltip" data-placement="' . $placement . '" title="' . $tip . '"';
  }
  
  /**
   * Sets the li to show the li name and id
   */
  public function showDetails(){
    $this->_showDetails = true;
  }

  /**
   * Gets the li name
   *
   * @return str the li name
   */
  public function getName(){
    return $this->_name;
  }
  
  /**
   * Gets the li id
   *
   * @return str the li id
   */
  public function getId(){
    return $this->_id;
  }
  
  /**
   * Gets the li value
   */
  public function getValue(){
    return $this->_content;
  }

  public function __toString(){
    $text = $this->_content;
    foreach($this->_buttons as $button){
      $text .= $button;
    }
    $attribs = '';
    if ($this->_showDetails == true){
      if ($this->_class != null){$attribs .= ' class="'. $this->_class . '"';}
      if ($this->_id != null){$attribs .= ' id="' . $this->_id . '"';}
    }
    
    $attribs .= $this->_tooltip;
    
    $output = '
                  <li' . $attribs . '>'. $text . '</li>';
    

    return $output;
  }
}