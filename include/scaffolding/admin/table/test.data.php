<?php
// dumb var names so they aren't used by mistake elsewhere
$test_date_week = (7 * 24 * 60 * 60); // a week

//cases to test:
/*
 * new beer, on tap           expected: no offline
 * new beer, on deck          expected: no offline
 * new beer, kicked           expected: offline possible
 * new beer, off line         expected: offline
 * returning beer, on tap     expected: no offline
 * returning beer, on deck    expected: no offline
 * returning beer, kicked     expected: offline possible
 * returning beer, offline    expected: offline
 * dead beer                  (same as previous)
 *
 * Where offline is possible, it will be able to go offline when the
 * time between when offline and now is > the value in the config for TIME_TO_OFF_LINE
 *
 * The process form for any updates will have to include a function to set the
 * database value for the beer_offtap field to 0 or null
 *
 * logic:
 * if ontap is more recent then kicked, then can not be off line
 * if ontap is not set or 0, then can not be off line
 * if ontap is older then offtap then can be be off line if > TIME_TO_OFF_LINE
 */
$test_cells = array(array("beer_id" => 1,
                          "beer_brewery" => "Ithaca Beer", // new beer, on tap
                          "beer_name" => "Flower Power",
                          "beer_status" => "0",
                          "beer_ontap" => (time() - $test_date_week),
                          "beer_offtap" => 0),
                    array("beer_id" => 2,
                          "beer_brewery" => "Ithaca Beer", // new beer, on deck
                          "beer_name" => "Green Tail",
                          "beer_status" => "1",
                          "beer_ontap" => 0,
                          "beer_offtap" => 0),
                    array("beer_id" => 3,
                          "beer_brewery" => "Ommeganag", // new beer, kicked not offline, not allowed
                          "beer_name" => "Hop House",
                          "beer_status" => "2",
                          "beer_ontap" => (time() - ($test_date_week * 3)),
                          "beer_offtap" => (time() - ($test_date_week * 2))),
                    array("beer_id" => 4,
                          "beer_brewery" => "Ommeganag", // new beer, kicked, offline
                          "beer_name" => "Gnomegang",
                          "beer_status" => "3",
                          "beer_ontap" => (time() - ($test_date_week * 8)),
                          "beer_offtap" => (time() - $test_date_week)),
                    array( "beer_id" => 5,
                          "beer_brewery" => "Ommeganag", // returning beer, on tap
                          "beer_name" => "Three Philosophers",
                          "beer_status" => "0",
                          "beer_ontap" => (time() - ($test_date_week)),
                          "beer_offtap" => (time() - $test_date_week * 3)),
                    array("beer_id" => 6,
                          "beer_brewery" => "Sarnac", // returning beer, on tap
                          "beer_name" => "Pale Ale",
                          "beer_status" => "1",
                          "beer_ontap" => (time() - ($test_date_week)),
                          "beer_offtap" => (time() - $test_date_week * 55)),
                    array("beer_id" => 7,
                          "beer_brewery" => "Sarnac", // returning beer, kicked not offline, allowed
                          "beer_name" => "Into The Dark",
                          "beer_status" => "2",
                          "beer_ontap" => (time() - ($test_date_week)),
                          "beer_offtap" => (time() - $test_date_week * 3)),
                    array("beer_id" => 8,
                          "beer_brewery" => "Buddwiser", // returning beer, offline, or dead beer
                          "beer_name" => "Swill",
                          "beer_status" => "3",
                          "beer_ontap" => (time() - ($test_date_week)),
                          "beer_offtap" => (time() - $test_date_week * 3))
                    );
                                      
/*
 *  Ways to make cells:
 * id - plain text cell who's value is attached to the row name
 * drop - not placed in the table
 * private - placed in the internal cell array as basic text
 * plain - a basic cell
 * checkbox - a checkbox
 * radio, # - a radio set of # cells
 * time, x - a timestamp where x = show or private
 */

$test_headers = array("Id" => array("beer_id" => 'id'),
                      "Brewery" => array("beer_brewery" => "plain"),
                      "Beer" => array("beer_name" => "plain"),
                      "On Tap" =>  array("beer_status" => "radio, 4"),
                      "On Deck" => 2,
                      "Kicked" => 3,
                      "Off Line" => 4,
                      "timeontap" => array("beer_ontap" => "time, private"),
                      "timeofftap" => array("beer_offtap" => "time, private")
                      );

