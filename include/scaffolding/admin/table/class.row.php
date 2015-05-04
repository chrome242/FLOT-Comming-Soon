<?php
// move cell includes here?

/**
 * Row
 *
 * The purpose of the row class is pretty simple:
 *
 * Takes an array of format name => value in order
 * Takes a string of how to deal with the cells
 * makes an approriate row.
 *
 * Ways to make cells:
 * (h)idden -not placed in the table
 * (p)lain text -a basic cell
 * (c)heckbox -a checkbox
 * (#) -a set of radios of # number
 *
 * cells can be accessed via calling methods defined below, rather than
 * the methods on the cell class, as I would like to have the cell objects
 * protected.
 * 
 */
class Row {
  
  // class attribs
  protected $_cells; //an array of cells
  protected $_format; //an array of how to deal with the cells
}