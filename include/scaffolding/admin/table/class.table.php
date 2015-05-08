<?php
// check to see if depaancy includes should be in the highest level abstraction
// class (eg, row should included here? with cells included there?)

/**
 * Table
 *
 * The Table class should be a near top level (top/wrapped in panel)
 * abstraction of the backend of the site.
 *
 * The Table class will need the following functionality out of the gate:
 *
 * open and close a table structure
 *
 * set the class, id, name, et al of the table.
 * 
 * take an array of header names to make a header and row rules
 * the header array should be in the form of array(header => array(cell => rule))
 * this will implicitly associate the header with a cell name and a way to make
 * that cell.
 * 
 * take an array of format: row name => array(cell name => values)
 *  -use that array to generate a list of rows with cell named cells
 *  -alternate between sets of rows if need be
 *  -set some rows to hidden, allow them to be shown if need be
 *  -use a set of setters to set values for all rows of given type
 *  -use a set of getters to access cells from either the exposed or
 *   the hidden cells of a given row.
 *  -include a task specific method to set some cell values based on other
 *   cell values, applying this to all rows.
 *
 * indivudual rows should be accessed via getters and setters, and while it
 * shouldn't be used much, it should be resonable to use a row setter to
 * push down to a cell setter from a the table level.
 * 
 * 
 */
class Table {
  
  // class attributes
  protected $_name;
  protected $_id = null;
  protected $_class = null;
  
  // member portion attributes
  protected $_header;
  protected $_rows;
  protected $_privateRows;
  
  
  
}