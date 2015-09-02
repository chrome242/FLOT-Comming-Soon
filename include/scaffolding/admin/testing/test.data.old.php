<?php
// dumb var names so they aren't used by mistake elsewhere
$test_date_week = (7 * 24 * 60 * 60); // a week
// Temp testing permissions //
$permissions = array("inventory" => "1",
                     "drinks" =>  "1",
                     "extras" => "1",
                     "food" => 1,
                     "add_user" => "1",
                     "edit_user" => 1);
// End testing permissions //
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
$beer_test_cells = array(array("beer_id" => 1,
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
                          "beer_ontap" => (time() - ($test_date_week * 8)),
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
                          "beer_ontap" => 0,
                          "beer_offtap" => (time() - $test_date_week * 55)),
                    array("beer_id" => 7,
                          "beer_brewery" => "Sarnac", // returning beer, kicked not offline, allowed
                          "beer_name" => "Into The Dark",
                          "beer_status" => "2",
                          "beer_ontap" => (time() - ($test_date_week * 3)),
                          "beer_offtap" => (time() - $test_date_week * 2)),
                    array("beer_id" => 8,
                          "beer_brewery" => "Buddwiser", // returning beer, offline, or dead beer
                          "beer_name" => "Swill",
                          "beer_status" => "3",
                          "beer_ontap" => (time() - ($test_date_week * 11)),
                          "beer_offtap" => (time() - $test_date_week * 3))
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


// Temp testing permissions //
$permissions = array("inventory" => "1",
                     "drinks" =>  "1",
                     "extras" => "1",
                     "food" => 1,
                     "add_user" => "1",
                     "edit_user" => 1);
// End testing permissions //


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
                          
$testlist = array("1" => "Pie",
                  "3" => "Grape",
                  "11" => 'Mellow',
                  "06" => "tofurkey",
                  "2" => "Orange");

$testlistspecial = array("06" => "new",
                         "1" => 'edit');

                         
//********************************Extras***************************************//


// Content Testing //
// Small Table Test - the method should pull from the SQL and then it should //
// add the last line automatically. If a post variable exist for the table //
// then the post variable should be used rather then the SQL source //
$test_drink_trial = array(1 => array("drink_type_name" => "Amber Ale",
                                    "drink_type_desc" => "Amber Ale Desc."),
                         2 => array("drink_type_name" => "Bitter",
                                    "drink_type_desc" => "Bitter Ale Desc."),
                         3 => array("drink_type_name" => "Blonde Ale",
                                    "drink_type_desc" => "Blonde Ale Desc."),
                         4 => array("drink_type_name" => "Block",
                                    "drink_type_desc" => "Block Ale Desc."),
                         19 => array("drink_type_name" => "")); 


$test_drink_setti = array(1 => array("drink_type_name" => ["editPlain", false],
                                    "drink_type_desc" => ["dropArea, value, 3, 4", true]),
                         2 => array("drink_type_name" => ["editPlain", false],
                                    "drink_type_desc" => ["dropArea, value, 3, 4", true]),
                         3 => array("drink_type_name" => ["editPlain", false],
                                    "drink_type_desc" => ["dropArea, value, 3, 4", true]),
                         4 => array("drink_type_name" => ["editPlain", false],
                                    "drink_type_desc" => ["dropArea, value, 3, 4", true]),
                         19 => array("drink_type_name" => ["addText", false]));


$test_wine_list = array(1 => "Pinor Noir", 2 => "Tokay", 3 => "Chardonnary",
                        4 => "Riesling", 5 => "Merlot", 6 => "Tugboat Red",
                        7 => "Tugboat White", 8 => "Bordeaux", 9 =>'');

$test_wine_spec = array(4 => "edit", 9 => "new");

$test_size_list = array(1=> "Sample", 2 => "12oz.", 3 => "Pint",
                        4 => "Growler", 5 => '');

$test_size_spec = array(5 => "new");

//***************************************************************************//

//********************************Food***************************************//

// Content Testing //


// Panel Table Test
$test_pantab_trial = array( array("food_id" => 55, // id
                                  "food_name" => "Grilled Asparagus (V)",  //plain
                                  "food_type" => array(
                                                       array(1 => "Appetizer", 2 => "Tapas", 3 => "Full Plate"),
                                                       2), //select
                                  "food_price" => "6.59", // number
                                  "edit" => "Edit",  // button
                                  "newrow" => "newrow", // number
                                  "spacer" => "",  // plain
                                  "food_desc" => "Asparagus is grilled with a little oil, salt, and pepper
                                  for a simple summer side dish... The special thing about this recipe is
                                  that it's so simple. Fresh asparagus with a little oil, salt, and pepper
                                  is cooked quickly over high heat on the grill. Enjoy the natural flavor
                                  of your veggies.", // text area
                                  ),
                            array("food_id" => "2", // id
                                  "food_name" => "Grilled AwesomeTest (V)",  //plain
                                  "food_type" => "Tapas",
                                  "food_price" => "5.59", // number
                                  "edit" => "edit"),
                            array("food_id" => "3", // id
                                  "food_name" => "Grilled Mushrooms (V)",  //plain
                                  "food_type" => "Tapas",
                                  "food_price" => "5.59", // number
                                  "edit" => "edit",
                                  "addrow" => "newrow",
                                  "new_id" => "+",
                                  "s1" => "",
                                  "s2" => "",
                                  "s3" => "",
                                  "add" => "add"),  // button

                          );

$test_active = array(55);
//***************************************************************************//

//********************************Wine***************************************//
$wine_test_cells = array(array("wine_id" => 1,
                          "wine_winery" => "Lucas Vineyards", // new beer, on tap
                          "wine_name" => "Tugboat Red",
                          "wine_year" => "2014",
                          "wine_instock" => true),
                         array("wine_id" => 2,
                          "wine_winery" => "Lucas Vineyards", // new beer, on tap
                          "wine_name" => "Tugboat White",
                          "wine_year" => "2014",
                          "wine_instock" => true),
                         array("wine_id" => 3,
                          "wine_winery" => "Thirsty Owl", // new beer, on tap
                          "wine_name" => "Reisling",
                          "wine_year" => "2013",
                          "wine_instock" => false),
                         array("wine_id" => 4,
                          "wine_winery" => "Thirsty Owl", // new beer, on tap
                          "wine_name" => "Lot 99",
                          "wine_year" => "2013",
                          "wine_instock" => true),
                         array("wine_id" => 5,
                          "wine_winery" => "Sheldrake Point", // new beer, on tap
                          "wine_name" => "Gewürztraminer",
                          "wine_year" => "2012",
                          "wine_instock" => false),
                         array("wine_id" => 6,
                          "wine_winery" => "Sheldrake Point", // new beer, on tap
                          "wine_name" => "Reisling",
                          "wine_year" => "2014",
                          "wine_instock" => true),
                         array("wine_id" => 7,
                          "wine_winery" => "Six Mile Creek", // new beer, on tap
                          "wine_name" => "Reisling",
                          "wine_year" => "2008",
                          "wine_instock" => true),                         
                         );

//********************************users***************************************//
$test_group_cells = array(array("rights_id" => 1,
                                "rights_name" => "Owner",
                                "rights_inventory" => true, 
                                "rights_drinks" => true, 
                                "rights_extras" => true,
                                "rights_food" => true,
                                "rights_add_user" => true,
                                "rights_edit_user" => true,
                                "edit" => "edit"
                                ),
                          array("rights_id" => 2,
                                "rights_name" => "Manager",
                                "rights_inventory" => true, 
                                "rights_drinks" => true, 
                                "rights_extras" => true,
                                "rights_food" => true,
                                "rights_add_user" => true,
                                "rights_edit_user" => false,
                                "edit" => "edit"
                                ),
                          array("rights_id" => 3,
                                "rights_name" => "Bartender",
                                "rights_inventory" => true, 
                                "rights_drinks" => false, 
                                "rights_extras" => false,
                                "rights_food" => false,
                                "rights_add_user" => false,
                                "rights_edit_user" => false,
                                "edit" => "edit",
                                "newrow" => "newrow",
                                "new_id" => "+",
                                "placeholder1" => " ",
                                "placeholder2" => " ",
                                "placeholder3" => " ",
                                "placeholder4" => " ",
                                "placeholder5" => " ",
                                "placeholder6" => " ",
                                "placeholder7" => " ",
                                "add" => "add"
                                )
                         );
$test_group_special_cells = array(3);

$user_group_names = array(1 => "Owner", 2=> "Manager", 3 => "Bartender", 4 => "Waitstaff");
$user_special_cells_test = array(2);
$users_test = array(array("user_id" => "1",
                          "user_name" => "Tom",
                          "user_group" => "Owner",
                          "user_password" => "Password",
                          "new_pw" => "new Password",
                          "edit" => ["edit", "exampleModal"],
                          "drop" => "drop"
                          ),
                    array("user_id" => "2",
                          "user_name" => "Moe",
                          "user_group" => array($user_group_names, "2"),
                          "user_password" => "Enter New Password",
                          "new_pw" => "new Password",
                          "edit" => ["edit", "exampleModal"],
                          "drop" => "drop"
                          ),
                    array("user_id" => "3",
                          "user_name" => "Shem",
                          "user_group" => array($user_group_names, "1"),
                          "user_password" => "Another Password",
                          "new_pw" => "new Password",
                          "edit" => ["edit", "exampleModal"],
                          "drop" => "drop",
                          "newrow" => "newrow",
                          "placeholder1" => " ",
                          "placeholder2" => " ",
                          "placeholder3" => " ",
                          "placeholder4" => " ",
                          "placeholder5" => " ",
                          "placeholder5" => " ",
                          "add" => "add")
                    );

$smallTest = array("Record ID" => array("Key 1" => "value 1", "Key 2" => "value 2"));

$smallFormat = array("Record ID" => array("Key 1" => array("plain", false), "Key 2" => array("plain", true)));