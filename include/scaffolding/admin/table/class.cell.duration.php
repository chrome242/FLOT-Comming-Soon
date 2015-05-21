<?php

/**
 * Duration Cell
 *
 * Extends cell.
 * The Duration cell is an extension of cell that processes a pair of timestamps into 
 * while this is largely simular to a generic cell in it's output, it requires a timestamp
 * to be passed into the cell on creation. A second cell can be passed though as well, but
 * is only nesicarry if the duration being calculated is not trucated with the current time.
 *
 * It may be useful to use this class with the Timestamp class, but as to not code a specific
 * case that assumes that a Timestamp was used in getting a value for the date, the value from
 * a Timestamp cell should be gotten via the timestamp's getValue() function and then passed
 * to the Duration cel.
 *
 * By default, the Duration cell sets the cell tooltip on and floats the ammount of time between
 * the first/only datestamp and the second datestamp/now as a tooltip if the value = a current
 *
 * The output cell will either return a value of X Days, Current, or New.
 *
 * first cell is ontap
 * second cell is offtap
 * 
 * Current if only one stamp passed (stamp to today)
 * Current if offtap = 0 & ontap != 0
 * New if offtap = 0, ontap = 0
 * Amount of days ran if offtap > ontap
 * 
 *
 * 
 * 
 */
class Duration extends Cell {
  
  
  /**
   * Sets the $_name and $_id to the same thing on construction.
   *
   *  This extension changes the default behavior of the Cell class by moving
   *  the name and id to the inner input of the cell, and not the cell itself.
   *
   *  The HTML class will still apply to the td.
   *
   *  If the second timestamp is not set, it will return the unix epoc time, as it
   *  should only read zero when an event has not occured yet.
   *
   *  Because there's some vodoo going on with the specifics of how these timestamps
   *  can be handled, I've used task specific names so that there's easy follow
   *  though for later reading
   *  
   * @param str $name: the name & id of the Cell
   * @param int $onTap: the timestamp
   * @param int $offTap: if null then zero.
   */
  public function __construct($name, $onTap, $offTap=0){
    $this->_id = $name;
    $this->_name = $name;
    
    // if onTap is greater then $offTap then it is onTap & current always
    if($onTap > $offTap){
      $this->setToolTip($this->makeToolTip($onTap, time()));
      $this->_content = "Current";
      
    // New beer, both zero or null
    } elseif ($onTap == 0 && $offTap == 0) {
      $this->_content = "New";
    
    // Beer now on deck, kicked in the past
    } elseif ($onTap == 0 && $offTap !=0) {
      $this->_content = "Restocked";
    
    // if offTap is > then onTap, it is currently off tap and should show
    // how long the keg lasted
    } elseif($offTap > $onTap && $onTap != 0) {
      $this->_content = $this->makeContent($onTap, $offTap);
    
    // unexpected edge case, check input
    } else {
      $this->_content = "Error";
    }

  }
  
  /**
   * Returns a string of the number of days between a timestamp and a second.
   * presumes that there are two actual timestamps because this is designed
   * for the time elapsed between two dates in the past.
   */
  public function makeContent($onTap, $offTap){
    // how many days from onTap -> offTap
    $number = $this->makeDays($onTap, $offTap);
    if ($number == 1){ return "1 Day";}
    else { return $number . " Days";}
  }
  
  /**
   * Returns a string of the number of days between a timestamp and a second,
   * along with some text. This is really just a wrapper for makeDays()
   *
   * @param int $timestamp: A timestamp
   * @param int $secondtimestamp: a second optional timestamp..
   *
   * @return str $output: A string of the number of days and commentary
   */
  public function makeToolTip($onTap, $today){
    $days =  $this->makeDays($onTap, $today);
    return $days . " days running";
  }
  
  /**
   *
   * @param int $timestamp: A timestamp
   * @param int $secondtimestamp: a second optional timestamp..
   *
   * @return str the number of days between the two timestamps
   */
  protected function makeDays($olderTime, $newerTime){
    // second timesamp should be the newer of the two
    $raw_time = $newerTime - $olderTime;
    $day = (24 * 60 * 60);
    $refined_time = intval($raw_time / $day);
    return $refined_time;
  }
  
  

  
  // this class should utilize the default toString
}