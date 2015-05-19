<?php
// panel class
//include_once("class.panel.php");

// table class
include_once("class.table.php");

// row class
include_once("class.row.php");


// text cells
include_once("class.cell.php"); // basic cell class
// TODO: extend timestamp for the day's running view. Extend row to handle it.
include_once("class.cell.timestamp.php"); // timestamp extension for cell class
//include_once("class.cell.button.php"); // in-row button

// input cells
include_once("class.cell.input.php"); // the input template for cells
include_once("class.cell.checkbox.php"); //the checkbox cell type
include_once("class.cell.radio.php"); // the radio cell type
include_once("class.cell.text.php"); // the text cell type
include_once("class.cell.number.php"); // the numer cell type

// input like cells, use the input template
include_once("class.cell.textarea.php"); //text area input
include_once("class.cell.select.php"); // select box

// cells with mutiple elements
//include_once("class.cell.extras.php"); // cells with buttons and text


// testing data
include_once("test.data.php");

// javaScript that needs to be done to support the above- the ones marked with
// an <a> are ajax calls and should have supporting php (mostly above)
// lock-button - lock edit button
// replace-row - replace an edit/not edit row with the other <a>
// replace-cell -support the above, used for extras and dishes <a>
// add-cell -to add a cell to the table <a>
// add-row -to add a row to the table

