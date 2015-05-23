<?php

/**
 * UrlCell
 *
 * a simple extension of cell that wraps the $_content in an anchor for output
 * while leaving it as a text string for the getValue method.
 * 
 */
class UrlCell extends Cell {
  
  // all cells will have names & ids, which can be shown, and text.
  
  /**
   * Sets the $_name and $_id to the same thing on construction.
   *
   * @param str $name: the name & id of the Cell
   * @param str $URL: the URL content of the Cell
   */
  public function __construct($name, $url){
    $this->_id = $name;
    $this->_name = $name;
    $this->_content = $this->checkFormat($url);
  }
  
  /**
   * Checks to see if the URL is in the format http://.... and makes it
   * as such if not.
   *
   * @param str $url: a supposed URL
   *
   * @return str $output: a supposedly better URL
   */
  private function checkFormat($url){
    if(stripos($url, 'http://') !== false){
      return $url;
    } else {
      return 'http://'.$url;
    }
  }
 
  /**
   * Setter for the $_content attribute
   */
  public function setContent($content){
    $this->_content = $this->checkFormat($content);
  }


  public function __toString(){
    $attribs = '';
    if ($this->_showDetails == true){
      if ($this->_class != null){$attribs .= ' class="'. $this->_class . '"';}
      if ($this->_id != null){$attribs .= ' id="' . $this->_id . '"';}
    }
    
    $attribs .= $this->_tooltip;
    
    $output = '
                  <td' . $attribs . '><a target="_blank" href="'. $this->_content . '">'.$this->_content.'</a></td>';
    

    return $output;
  }
}