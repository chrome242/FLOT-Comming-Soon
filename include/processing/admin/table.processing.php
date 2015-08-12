<?php

// This file contains all of the includes needed for processing the Table class
// data from users and DB

include_once(PROCESSING_FUNCTIONS."post.array.helpers.php");  // for more generic array handling
include_once(PROCESSING_FUNCTIONS."Table.array.helpers.php"); // deal with input
include_once(PROCESSING_FUNCTIONS."smallTable.interaction.helpers.php"); // deal with output
include_once(PROCESSING_FUNCTIONS."button.processing.php"); //processInput is the centeral function
include_once(PROCESSING_FUNCTIONS."sql.array.helpers.php"); //for making things like selects.
include_once(PROCESSING_FUNCTIONS."beer.processing.php"); // if a beer table