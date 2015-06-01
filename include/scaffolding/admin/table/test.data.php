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
                          "test_backend" => "works"),
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
                          "test_backend" => "submit")
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
                      "Test" => array("test_backend" => "button")
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
                          
                    
$test_form = <<<EOT
              <form name="Beer" method="post">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Brewery</th>
                      <th>Beer</th>
                      <th>On Tap</th>
                      <th>On Deck</th>
                      <th>Kicked</th>
                      <th>Off Line</th>
                      <th>Test</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td>Ithaca Beer</td>
                      <td>Flower Power</td>
                      <td>
                        <input type="radio"id="Beer[1][beer_status][0]" name="Beer[1][beer_status]" value="0" checked>
                      </td>
                      <td>
                        <input type="radio"id="Beer[1][beer_status][1]" name="Beer[1][beer_status]" value="1">
                      </td>
                      <td>
                        <input type="radio"id="Beer[1][beer_status][2]" name="Beer[1][beer_status]" value="2">
                      </td>
                      <td>
                        <input type="radio"id="Beer[1][beer_status][3]" name="Beer[1][beer_status]" value="3" disabled>
                      </td>
                      <td>
                        <button type="submit"class="btn btn-primary" id="Beer[1][Beer-works]" name="Beer-works" value="1">Works</button>
                      </td>
                    </tr>
                    <tr>
                      <td>2</td>
                      <td>Ithaca Beer</td>
                      <td>Green Tail</td>
                      <td>
                        <input type="radio"id="Beer[2][beer_status][0]" name="Beer[2][beer_status]" value="0">
                      </td>
                      <td>
                        <input type="radio"id="Beer[2][beer_status][1]" name="Beer[2][beer_status]" value="1" checked>
                      </td>
                      <td>
                        <input type="radio"id="Beer[2][beer_status][2]" name="Beer[2][beer_status]" value="2">
                      </td>
                      <td>
                        <input type="radio"id="Beer[2][beer_status][3]" name="Beer[2][beer_status]" value="3" disabled>
                      </td>
                      <td>
                        <button type="submit"class="btn btn-primary" id="Beer[2][Beer-submit]" name="Beer-submit" value="2">Submit</button>
                      </td>
                    </tr>
                    <tr>
                      <td>3</td>
                      <td>Ommeganag</td>
                      <td>Hop House</td>
                      <td>
                        <input type="radio"id="Beer[3][beer_status][0]" name="Beer[3][beer_status]" value="0">
                      </td>
                      <td>
                        <input type="radio"id="Beer[3][beer_status][1]" name="Beer[3][beer_status]" value="1">
                      </td>
                      <td>
                        <input type="radio"id="Beer[3][beer_status][2]" name="Beer[3][beer_status]" value="2" checked>
                      </td>
                      <td>
                        <input type="radio"id="Beer[3][beer_status][3]" name="Beer[3][beer_status]" value="3">
                      </td>
                      <td>
                        <button type="submit"class="btn btn-primary" id="Beer[3][Beer-submit]" name="Beer-submit" value="3">Submit</button>
                      </td>
                    </tr>
                    <tr>
                      <td>4</td>
                      <td>Ommeganag</td>
                      <td>Gnomegang</td>
                      <td>
                        <input type="radio"id="Beer[4][beer_status][0]" name="Beer[4][beer_status]" value="0">
                      </td>
                      <td>
                        <input type="radio"id="Beer[4][beer_status][1]" name="Beer[4][beer_status]" value="1">
                      </td>
                      <td>
                        <input type="radio"id="Beer[4][beer_status][2]" name="Beer[4][beer_status]" value="2">
                      </td>
                      <td>
                        <input type="radio"id="Beer[4][beer_status][3]" name="Beer[4][beer_status]" value="3" checked>
                      </td>
                      <td>
                        <button type="submit"class="btn btn-primary" id="Beer[4][Beer-submit]" name="Beer-submit" value="4">Submit</button>
                      </td>
                    </tr>
                    <tr>
                      <td>5</td>
                      <td>Ommeganag</td>
                      <td>Three Philosophers</td>
                      <td>
                        <input type="radio"id="Beer[5][beer_status][0]" name="Beer[5][beer_status]" value="0" checked>
                      </td>
                      <td>
                        <input type="radio"id="Beer[5][beer_status][1]" name="Beer[5][beer_status]" value="1">
                      </td>
                      <td>
                        <input type="radio"id="Beer[5][beer_status][2]" name="Beer[5][beer_status]" value="2">
                      </td>
                      <td>
                        <input type="radio"id="Beer[5][beer_status][3]" name="Beer[5][beer_status]" value="3" disabled>
                      </td>
                      <td>
                        <button type="submit"class="btn btn-primary" id="Beer[5][Beer-submit]" name="Beer-submit" value="5">Submit</button>
                      </td>
                    </tr>
                    <tr>
                      <td>6</td>
                      <td>Sarnac</td>
                      <td>Pale Ale</td>
                      <td>
                        <input type="radio"id="Beer[6][beer_status][0]" name="Beer[6][beer_status]" value="0">
                      </td>
                      <td>
                        <input type="radio"id="Beer[6][beer_status][1]" name="Beer[6][beer_status]" value="1" checked>
                      </td>
                      <td>
                        <input type="radio"id="Beer[6][beer_status][2]" name="Beer[6][beer_status]" value="2">
                      </td>
                      <td>
                        <input type="radio"id="Beer[6][beer_status][3]" name="Beer[6][beer_status]" value="3" disabled>
                      </td>
                      <td>
                        <button type="submit"class="btn btn-primary" id="Beer[6][Beer-submit]" name="Beer-submit" value="6">Submit</button>
                      </td>
                    </tr>
                    <tr>
                      <td>7</td>
                      <td>Sarnac</td>
                      <td>Into The Dark</td>
                      <td>
                        <input type="radio"id="Beer[7][beer_status][0]" name="Beer[7][beer_status]" value="0">
                      </td>
                      <td>
                        <input type="radio"id="Beer[7][beer_status][1]" name="Beer[7][beer_status]" value="1">
                      </td>
                      <td>
                        <input type="radio"id="Beer[7][beer_status][2]" name="Beer[7][beer_status]" value="2" checked>
                      </td>
                      <td>
                        <input type="radio"id="Beer[7][beer_status][3]" name="Beer[7][beer_status]" value="3" disabled>
                      </td>
                      <td>
                        <button type="submit"class="btn btn-primary" id="Beer[7][Beer-submit]" name="Beer-submit" value="7">Submit</button>
                      </td>
                    </tr>
                    <tr>
                      <td>8</td>
                      <td>Buddwiser</td>
                      <td>Swill</td>
                      <td>
                        <input type="radio"id="Beer[8][beer_status][0]" name="Beer[8][beer_status]" value="0">
                      </td>
                      <td>
                        <input type="radio"id="Beer[8][beer_status][1]" name="Beer[8][beer_status]" value="1">
                      </td>
                      <td>
                        <input type="radio"id="Beer[8][beer_status][2]" name="Beer[8][beer_status]" value="2">
                      </td>
                      <td>
                        <input type="radio"id="Beer[8][beer_status][3]" name="Beer[8][beer_status]" value="3" checked>
                      </td>
                      <td>
                        <button type="submit"class="btn btn-primary" id="Beer[8][Beer-submit]" name="Beer-submit" value="8">Submit</button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              <span class="label label-info">Total on Tap: <span id="counter" class="label label-success">2</span></span>
              </form>
EOT;

$testlist = array("1" => "Pie",
                  "3" => "Grape",
                  "11" => 'Mellow',
                  "06" => "tofurkey",
                  "2" => "Orange");

$testlistspecial = array("06" => "new",
                         "1" => 'edit');

                         
                         
$smallTest = array("Record ID" => array("Key 1" => "value 1", "Key 2" => "value 2"));

$smallFormat = array("Record ID" => array("Key 1" => array("plain", false), "Key 2" => array("plain", true)));