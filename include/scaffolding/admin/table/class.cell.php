<?php

/**
 * Cell
 *
 * This creates cells for a table (<td></td>)
 *
 * The base cell class creates a cell that contains contents generated
 * elsewhere. This is intended for receiving text or low interactivity
 * content. Extension of this class will generate more complext cell
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
   * Setter for the $_name attrib
   *
   * @param str $name: the new value for the name
   */
  public function setName($name){
    $this->_name = $name;
  }
  
  /**
   * Setter for the $_id attrib
   *
   * @param str $id: the new value for the id
   */
  public function setId($id){
    $this->_id = $id;
  }

  /**
   * Setter for the $_class attrib
   *
   * @param str $class: the new value for the id
   */
  public function setClass($class){
    $this->_class = $class;
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
   * Gets the cell id
   *
   * @return str the cell id
   */
  public function getId(){
    return $this->_id;
  }
  
  /**
   * Gets the cell value
   */
  public function getValue(){
    return $this->_content;
  }

  public function __toString(){
    $attribs = '';
    if ($this->_showDetails == true){
      if ($this->_class != null){$attribs .= ' class="'. $this->_class . '"';}
      if ($this->_id != null){$attribs .= ' id="' . $this->_id . '"';}
    }
    
    $output = '
                <td' . $attribs . '>
                  '. $this->_content . '
                </td>';
    

    return $output;
  }
}