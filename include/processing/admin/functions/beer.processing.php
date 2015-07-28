<?php

/**
 * Functions specific to the beer table(s) construction and display and the
 * associated SQL updates.
 */

 
/**
 * Takes two values from 1 to 4, which represent on tap, on deck, kicked and
 * off line. returns an array of timestamps based on what the old status was
 * and what the new status is. This is pretty much a site specific function.
 *
 * @param int $select_value the new value
 * @param int $old_value the old value
 * @param bool $same_day if true assigns a 1 day period to something that has
 *        gone from on ondeck to kicked or offline in a single action.
 *
 * @return an array of numbers/nulls where the first item is the onTap value
 * 				 and the second is the offTap value.
 */
function tapLogic($select_value, $old_value, $same_day=true){
	
	// assign the numbers to vars just for ease of seeing what's going on.
	$onTap = 1;	$onDeck = 2;	$kicked = 3;	$offLine = 4;
	
	// onTap to anything else - set offtap to today
	if($old_value == $onTap && $select_value != $onTap){return array(null, time());}

	// anything to onTap - set on tap to today
	if($old_value != $onTap && $select_value == $onTap){return array(time(), null);}
	
	// onDeck to kicked or offline - set on tap to yesterday, off to today (1d)
	if($old_value == $onDeck && ($select_value == $kicked || $select_value == $offLine)){
		if($same_day){return array((time() - (24 * 60 * 60)), time());}
	}
	
	// kicked to onDeck or offline - no change
	// no change
	// offline to onDeck, kicked or offline - no change
	return array(null, null);
}

/**
 * Checks the post array against the mySQL array using the tapLogic function. If
 * there is a change in the select value from the post array, then it updates the
 * post array to include the new times, based on the output from tap logic. Will
 * also set up times for new beers coming into the DB and going on tap the same
 * day. This function is task specific to the beer table
 *
 * @param array $post_array the array to carry the updates
 * @param array $mysql_array the array to serve as the old value
 * @param bool $same_day to pass though to tapLogic, the value for the param
 *
 * @return no return, modifies $post_array as a side-effect
 */
function timeUpdate(&$post_array, $mysql_array, $same_day=true){
	
	// itterate across post, as it should typically be smaller then the DB
	foreach($post_array as $key => $value){
		
		// checks for an old value
		$select_value = $value["beer_status"];
		if(isset($mysql_array[$key])){
			$old_value = $mysql_array[$key]["beer_status"];
		
		// no old value, is a new entry. .: started off as new arival (onDeck)
		} else {
			$old_value = 2;
		}
	
		// values are now set. plug them into tapLogic and get results
		$newTimes = tapLogic($select_value, $old_value, $same_day);
		if(!is_null($newTime[0])){$post_array[$key]["beer_ontap"] = $newTime[0];}
		if(!is_null($newTime[1])){$post_array[$key]["beer_offtap"] = $newTime[1];}
	}
}
