<?php
include("../../include/config.php");
include(SCAFFOLDING_ADMIN."menubars.php");
include(SCAFFOLDING_ADMIN."table/table.php");

$title = "Manage Drinks";
$root = ADMIN;
$section = ADMIN."Drinks/";

$permissions = array("inventory" => "1",
                     "drinks" =>  "1",
                     "extras" => "1",
                     "food" => 1,
                     "add_user" => "1",
                     "edit_user" => 1);

include(SCAFFOLDING."head.php");

echo menubar($permissions, $section, $root);

$test1 = new Text("Test", "Some test content", $type="text");
//$test1->controlOff();
//$test1->disabled();
echo $test1;

echo '
        <div class="container">
          <form name="beerManagement">
            <table class="table table-hover" id="beer">
              <thead>';

$cells = array("Id" => '3',
               "Thing" => "Thing 1",
               "Another Thing" => "Thing 2",
               "Checkmeout" => False,
               "RadioGaGa" => 3,
               "TimeandSpace" => time(),
               "Blurb" => "Some Text");

$format = array("Id" => 'id',
                "Thing" => "plain",
                "Another Thing" => "plain",
                "Checkmeout" => "checkbox",
                "RadioGaGa" => "radio, 6",
                "TimeandSpace" => "time, private",
                "Blurb" => "text, placeholder");

$test2 = new Row("beer", $cells, $format);
$test2->setCellClass("Blurb", "col-xs-2");
echo $test2;
                
include(SCAFFOLDING_ADMIN."footer.php");