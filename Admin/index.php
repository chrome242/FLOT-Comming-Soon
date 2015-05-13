<?php
include("../include/config.php");
include(SCAFFOLDING_ADMIN."menubars.php");
include(SCAFFOLDING_ADMIN."table/table.php");
$title = "Beer Inventory";
$root = ADMIN;
$section = ADMIN;

include(SCAFFOLDING."head.php");

// test case.... move to a suite of these
$permissions = array("inventory" => "1",
                     "drinks" =>  "1",
                     "extras" => "1",
                     "food" => 1,
                     "add_user" => "1",
                     "edit_user" => 1);
$options = array("inhouse" => "In House",
                 "ondeck" => "On Deck",
                 "kicked" => "Kicked",
                 "all" => "All");

$ariatest = array("userGroups" => ["User Group Buttons", false],
                  "userProfiles" => ["User Management", false]);
                 
echo menubar($permissions, $section, $root);
echo sortbar($options, "all");
echo sectionbar($ariatest);
//echo openTable("apple", "pie");
//echo tableHeader(array("One", "Two", "Three"));
//echo closeTable(updateButton("apple"));

//$test = new Cell("AwsomeCell", "Some Content");
//$test->setClass("Yummy Foods");
//echo $test;
//$test2 = new Checkbox("AnotherCell", true, "GoCart");
//$test2->disabled();
//$test2->hideDetails();
//echo $test2;
//$test3 = new Radio("Another[Test][Cell]", "1", true);
//echo $test3;

$cells = array("Id" => '3',
               "Thing" => "Thing 1",
               "Another Thing" => "Thing 2",
               "Checkmeout" => False,
               "RadioGaGa" => 3,
               "TimeandSpace" => time());

$format = array("Id" => 'id',
                "Thing" => "plain",
                "Another Thing" => "plain",
                "Checkmeout" => "checkbox",
                "RadioGaGa" => "radio, 6",
                "TimeandSpace" => "time, private");

//$test4 = new Row("beer", $cells, $format);
//$test4->method("Thing", "setId", "works", true);
//$test4->setId();
//echo $test4->getHidden("TimeandSpace");
//echo $test4;

//echo '<pre>';
$test5 = new Table("Beer", $test_cells, $test_headers);
//var_dump($test5);
echo $test5->addCounter("Total on Tap:", "beer_status", "0");
//echo '</pre>';
echo $test5;

//$test5->test();

//$test5 = new Timestamp("TimeyWimey", time(), false);
//echo $test5;

//TODO: make a test set of arrays as a seperate file
//$table_test = new Table("Name", $test_headers, $test_cells);

include(SCAFFOLDING_ADMIN."footer.php");