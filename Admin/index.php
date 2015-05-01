<?php
include("../include/config.php");
include(SCAFFOLDING_ADMIN."menubars.php");

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

include(SCAFFOLDING_ADMIN."footer.php");