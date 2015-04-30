<?php
include("../../include/config.php");
include(SCAFFOLDING_ADMIN."menubars.php");

$title = "Wine Inventory";
$root = ADMIN;
$section = ADMIN."Wines/";


include(SCAFFOLDING."head.php");

echo menubar($permissions, $section, $root);

