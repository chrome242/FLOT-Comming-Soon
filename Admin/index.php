<?php
include("../include/config.php");
include(SCAFFOLDING."back/menubar.php");

$root = ADMIN;
$section = "/";

include(SCAFFOLDING."head.php");

// test case.... move to a suite of these
$permissions = array("inventory" => "1",
                     "drinks" =>  "1",
                     "extras" => "1",
                     "food" => 0,
                     "add_user" => "1",
                     "edit_user" => 1);


echo menubar($permissions, $section, $root);

