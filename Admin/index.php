<?php
include("../include/config.php");
include(SCAFFOLDING_ADMIN."menubars.php"); // menubars
include(SCAFFOLDING_ADMIN."panel/class.panel.php"); // panel wrapper
include(SCAFFOLDING_ADMIN."table/table.php"); // table
include(SCAFFOLDING_ADMIN."list/list.php"); // list
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


$test5 = new Table("Beer", $test_cells, $test_headers);
$test5->addCounter("Total on Tap:", "beer_status", "0");
$test5->offlineCheck();
$testList = new ListView("A list", $testlist, $testlistspecial, $default='text');
$test6 = new Panel("Test Panel", $testList, $size="default");
$test6->addButton();
echo $test6;
//echo $testList;

//echo "<br><pre>";
//if(isset($_POST)){
//  var_dump($_POST);
//}
//echo"</pre>";


include(SCAFFOLDING_ADMIN."footer.php");