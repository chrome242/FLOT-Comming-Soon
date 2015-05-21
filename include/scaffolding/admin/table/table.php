<?php
// panel class
//include_once("class.panel.php");

// table class
include_once("class.table.php");

// row class
include_once("class.row.php");

// structure cells
//include_once("class.cell.rowbreak.php"); // to allow the same record many rows

// text cells
include_once("class.cell.php"); // basic cell class
include_once("class.cell.duration.php"); // a lot like timestamp, but diffrent
include_once("class.cell.timestamp.php"); // timestamp extension for cell class
//include_once("class.cell.urlcell.php); // text cell with a builtin anchor

// input cells
include_once("class.cell.input.php"); // the input template for cells
include_once("class.cell.checkbox.php"); //the checkbox cell type
include_once("class.cell.radio.php"); // the radio cell type
include_once("class.cell.text.php"); // the text cell type
include_once("class.cell.number.php"); // the numer cell type
include_once("class.cell.button.php"); // in-row button

// input like cells, use the input template
include_once("class.cell.textarea.php"); //text area input
include_once("class.cell.select.php"); // select box

// cells with mutiple elements
//include_once("class.cell.miniview.php"); // cells with button and text
//include_once("class.cell.miniedit.php); //cells with button and edit


// testing data
include_once("test.data.php");

// javaScript that needs to be done to support the above- the ones marked with
// an <a> are ajax calls and should have supporting php (mostly above)
// lock-button - lock edit button
// replace-row - replace an edit/not edit row with the other <a>
// replace-cell -support the above, used for extras and dishes <a>
// add-cell -to add a cell to the table <a>
// add-row -to add a row to the table


// See http://bavotasan.com/2009/processing-multiple-forms-on-one-page-with-php/
