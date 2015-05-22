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
                          "beer_offtap" => 0,
                          "test_backend" => "http://works.org"),
                    array("beer_id" => 2,
                          "beer_brewery" => "Ithaca Beer", // new beer, on deck
                          "beer_name" => "Green Tail",
                          "beer_status" => "1",
                          "beer_ontap" => 0,
                          "beer_offtap" => 0,
                          "test_backend" => "submit"),
                    array("beer_id" => 3,
                          "beer_brewery" => "Ommeganag", // new beer, kicked not offline, not allowed
                          "beer_name" => "Hop House",
                          "beer_status" => "2",
                          "beer_ontap" => (time() - ($test_date_week * 8)),
                          "beer_offtap" => (time() - ($test_date_week * 2)),
                          "test_backend" => "submit"),
                    array("beer_id" => 4,
                          "beer_brewery" => "Ommeganag", // new beer, kicked, offline
                          "beer_name" => "Gnomegang",
                          "beer_status" => "3",
                          "beer_ontap" => (time() - ($test_date_week * 8)),
                          "beer_offtap" => (time() - $test_date_week),
                          "test_backend" => "submit"),
                    array( "beer_id" => 5,
                          "beer_brewery" => "Ommeganag", // returning beer, on tap
                          "beer_name" => "Three Philosophers",
                          "beer_status" => "0",
                          "beer_ontap" => (time() - ($test_date_week)),
                          "beer_offtap" => (time() - $test_date_week * 3),
                          "test_backend" => "submit"),
                    array("beer_id" => 6,
                          "beer_brewery" => "Sarnac", // returning beer, on tap
                          "beer_name" => "Pale Ale",
                          "beer_status" => "1",
                          "beer_ontap" => 0,
                          "beer_offtap" => (time() - $test_date_week * 55),
                          "test_backend" => "submit"),
                    array("beer_id" => 7,
                          "beer_brewery" => "Sarnac", // returning beer, kicked not offline, allowed
                          "beer_name" => "Into The Dark",
                          "beer_status" => "2",
                          "beer_ontap" => (time() - ($test_date_week * 3)),
                          "beer_offtap" => (time() - $test_date_week * 2),
                          "test_backend" => "submit"),
                    array("beer_id" => 8,
                          "beer_brewery" => "Buddwiser", // returning beer, offline, or dead beer
                          "beer_name" => "Swill",
                          "beer_status" => "3",
                          "beer_ontap" => (time() - ($test_date_week * 11)),
                          "beer_offtap" => (time() - $test_date_week * 3),
                          "test_backend" => "submit.com")
                    );
                                      
/*
 * Cell types:
 * 
 * button - an inline button. 
 * checkbox - a checkbox
 * **drop - not placed in the table
 * duration, x, y(o) where x & y are either timestamps or cell names
 * id - plain text cell who's value is attached to the row name
 * **newrow - a cell that produces a visual new row while allowing contued record
 * number, x, y(o), z(o), where x = number or placeholder y= step(o), z= size(o)
 * **private - placed in the internal cell array as basic text
 * plain - a basic cell
 * radio, # - a radio set of # cells
 * select, x(o), y(o), z(o) where x = selected value(o), y= mutiple(o), z= size(o)
 * text, x = a text entry where x = text or placeholder
 * textarea, x, y(o), z(o), where x = text or placeholder y= rows(o), z= colspan(o)
 * **time, x - a timestamp where x = show or private
 * url - a url cell. much like basic text
 */

$test_headers = array("Id" => array("beer_id" => 'id'),
                      "Brewery" => array("beer_brewery" => "plain"),
                      "Beer" => array("beer_name" => "plain"),
                      "On Tap" =>  array("beer_status" => "radio, 4"),
                      "On Deck" => 2,
                      "Kicked" => 3,
                      "Off Line" => 4,
                      "timeontap" => array("beer_ontap" => "time, private"),
                      "timeofftap" => array("beer_offtap" => "time, private"),
                      "Test" => array("test_backend" => "url")
                      );

$text_blurb = "Gnomegang has a rich, translucent golden hue with a big, fluffy,
               white head. Distinctive clove aromas, combined with yeasty
               fruitiness typical of Chouffe beers. Flavors include ripe fruit,
               clove, light caramel, non-cloying candy sweetness, smooth
               maltiness, and well-balanced hopping. Dry, warming finish that
               lingers gracefull";
                      
$test_multi = array(array("beer_id" => 1,
                          "beer_brewery" => "Ithaca Beer", // new beer, on tap
                          "beer_name" => "Flower Power",
                          "beer_status" => "0",
                          "beer_ontap" => (time() - $test_date_week),
                          "beer_offtap" => 0,
                          "test_backend" => "http://works.org",
                          "pie" =>  "newrow",
                          "spacer" => '',
                          "beer_type" => "Belgian Pale Ale",
                          "another_url" => "www.google.com"),
                    array("beer_id" => 6,
                          "beer_brewery" => "Sarnac", // returning beer, on tap
                          "beer_name" => "Pale Ale",
                          "beer_status" => "1",
                          "beer_ontap" => 0,
                          "beer_offtap" => (time() - $test_date_week * 55),
                          "test_backend" => "submit"),
                    );

$multi_headers = array("Id" => array("beer_id" => 'id'),
                      "Brewery" => array("beer_brewery" => "plain"),
                      "Beer" => array("beer_name" => "plain"),
                      "On Tap" =>  array("beer_status" => "radio, 4"),
                      "On Deck" => 2,
                      "Kicked" => 3,
                      "Off Line" => 4,
                      "timeontap" => array("beer_ontap" => "time, private"),
                      "timeofftap" => array("beer_offtap" => "time, private"),
                      "Test" => array("test_backend" => "url"),
                      "newline" => array("pie" => "newrow"),
                      "spacer" => array("spacer" => "plain"),
                      "dontseeme" => array("beer_type" => "plain"),
                      "alsono" => array("another_url" => "url")
                      );
                          
                    
