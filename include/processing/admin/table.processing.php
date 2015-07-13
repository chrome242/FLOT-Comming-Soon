<?php

// This file contains all of the includes needed for processing the Table class
// data from users and DB

include_once(PROCESSING_ADMIN."post.array.helpers.php");  // for more generic array handling
include_once(PROCESSING_ADMIN."smallTable.array.helpers.php"); // deal with input
include_once(PROCESSING_ADMIN."smallTable.interaction.helpers.php"); // deal with output
include_once(PROCESSING_ADMIN."button.processing.php"); //processInput is the centeral function
include_once(PROCESSING_ADMIN."sql.array.helpers.php"); //for making things like selects.
