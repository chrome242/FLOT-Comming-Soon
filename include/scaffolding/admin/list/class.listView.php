<?php

/**
 * This class will take a form name, an array of value arrays of the form of
 * $key => $value, and an array of 'special items', which will be an array of
 * $key => format. It will generate listItem class objects (which are dervied from
 * my base cell classes) with these two arrays.
 *
 * The list class will have an optional arg to change the default type of item
 * created. As inner object creation will happen when the list is brought into
 * existance, that seemed the best time to set the list types. It could be done
 * after creation by replacing array items after pulling out the inner value of
 * the li, but that seems to be a bit more of an effort than it would be worth.
 *
 * types of list items:
 * text (default)  li of id formname[key] with text and a button to edit
 * edit li of text field, with 2 buttons, drop and edit(active)
 * new a disabled text field with a plus button.
 * 
 */

class ListView {
  
  // the name of the form
  protected $_formName;
  
  // the array of listItems
  protected $_listItems;
  
  
  // optional setters for the form and the ul
  protected $_formId = '';
  protected $_formClass = '';
  protected $_listClass = ' class="list-group"';
  protected $_listId = '';
  
  /**
   * A class for creating the HTML view of a form in a list style.
   * Makes an array of listItem class items (and decendants thereof)
   * Makes a form from the name
   *
   * echos out the form, any items set with the setters, and all included
   * array items
   *
   * @param str $name the name of the form
   * @param array $listitems an array of key => value arrays for the list members
   * @param mixed $special either a bool false or an array of key => value arrays
   * @param str $default a keyword for the default type of list items to be built.
   */
  public function __construct($name, $listitems, $special=false, $default='text'){
    //set the name
    $this->_formName = $name;
    
    // process special
    if(is_array($special) === false){$special = false;}
    
    // use list item construction function
    $this->_listItems = $this->makeItems($listitems, $special, $default);
    
  }
  
  /**
   * Produces an array of objects of listiem class and it's extensions from
   * an array of items. A second variable is passed to it that is either a bool
   * of false or an array. $default determines what the type of the default li
   * should be.
   *
   * the types of listitems that are supported are:
   * 'text' -  a plain li with a button of the name form-edit and value of the
   *           list item id (key)
   *  'edit' - a text edit li with a button of the name form-drop and a value of
   *           list item id (key) and a second inactive buttton for show.
   *  'new'  - an inactive text edit li with a button of the name form-new and
   *           a value of newitem and.
   *           
   *  @param array mixed $listitems = a key value array of li contents
   *  @param mixed $special = a bool false or an array of li with not default types
   *  @param str $default = a string with the type of the default;
   * 
   */
  protected function makeItems($listitems, $special, $default){
    
    $temp_array = array();
    // loop though the list items
    foreach($listitems as $id => $value){
      
      // presume that the type is the default
      $item_type = $default;
      
      // test the above presumption-
      
      // if the special arg is not false.
      if($special){  
        // if this id also appears on the special array, use this value
        if(isset($special[$id])){ $item_type = $special[$id];}
      }
    
      // make the list item. This could be it's own thing, and should be for
      // strict OOP, but that's beyond the scope of this job
      
      if($item_type == 'text'){
        $list_item = new ListItem($id, $value);
        $list_item->addButton($this->_formName, $id, "edit", "glyphicon-cog",
                              $text=false, $active=false);
      }
      
      if($item_type == 'edit'){
        $list_item = new ListText($id, $value, $type="value");
        $list_item->addButton($this->_formName, $id, "drop", "Drop",
                              $text=true, $active=false);
        $list_item->addButton($this->_formName, $id, "edit", "glyphicon-cog",
                              $text=false, $active=true);
      }
      
      if($item_type == 'new') {
        $list_item = new ListText('blankItem', 'Add new item', $type="placeholder");
        $list_item->disabled();
        $list_item->addButton($this->_formName, $id, "edit", "glyphicon-plus",
                              $text=false, $active=true);
      }
    
      $temp_array[$id] = $list_item;
    }
    
    return $temp_array;
  }
  
  
  /* Getter for the form name */
  public function getName(){
    return $this->_formName;
  }
  
  
  /* setter for the form ID */
  public function setFormId($id){
    $this->_formId = ' id="' . $id . '"' ;
  }
  
  
  /* setter for the form class */
  public function setFormClass($class){
    $this->_formClass = ' class="' . $class . '"';
  }
  
  
  /* setter for the list ID */
  public function setListId($id){
    $this->_listId = ' id="' . $id . '"';
  }
  
  
  /**
   * setter for the list class
   *
   * @param option bool $listgroup adds the Bootstrap class "list-group"
   *  unless false
   */
  public function setListClass($class, $listgroup=true){
    if($listgroup){ $class .= ' list-group';}
    $this->_listClass = ' class="' . $class . '"';
  }
  
  
  public function __toString(){
  $output ='
            <form name="'. $this->_formName .'"' . $this->_formClass . $this->_formId . ' method="post">
              <ul' . $this->_listClass . $this->_listId . '>';

  foreach($this->_listItems as $item){
    $output .= $item;
  }
  
  $output .='
              </ul>
            </form>';
            
  return $output;
  }
  
  
}

