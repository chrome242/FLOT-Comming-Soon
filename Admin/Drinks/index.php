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
$test2 = new Number("Num Test", 4.00, "placeholder", 2, 5);
//$test1->controlOff();
//$test1->disabled();
echo $test1;
echo $test2;
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
               "Blurb" => "Some Text",
               "Count" => '3.26666');

$format = array("Id" => 'id',
                "Thing" => "plain",
                "Another Thing" => "plain",
                "Checkmeout" => "checkbox",
                "RadioGaGa" => "radio, 6",
                "TimeandSpace" => "time, private",
                "Blurb" => "text, placeholder",
                "Count" => "number, value, 4, 8");

$test3 = new Row("beer", $cells, $format);
$test3->setCellClass("Blurb", "col-xs-2");
echo $test3;
                
include(SCAFFOLDING_ADMIN."footer.php");