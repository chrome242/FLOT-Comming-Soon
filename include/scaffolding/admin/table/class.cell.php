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
   * @param str $id: the new value for the id
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
  
  //TODO clean this up some
  public function __toString(){
    if ($this->_class != null && $this->_showDetails == false){
    $output = '
                <td class="'.$this->_class.'">
                '. $this->_content . '
                </td>';
                
    } elseif ($this->_class != null && $this->_showDetails == true) {
    $output = '
                <td class="'.$this->_class.'" id="'.$this->_id.'" name="'.$this->_name.'">
                '. $this->_content . '
                </td>';
                
    } elseif ($this->_class == null && $this->_showDetails == true) {
    $output = '
                <td id="'.$this->_id.'" name="'.$this->_name.'">
                '. $this->_content . '
                </td>';    
    } else {
    $output = '
                <td>
                ' . $this->_content . '
                </td>';
    }
    return $output;
  }
}