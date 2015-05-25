<?php
include("../../include/config.php");
include(SCAFFOLDING_ADMIN."menubars.php");
include(SCAFFOLDING_ADMIN."list/class.listView.php");
include(SCAFFOLDING_ADMIN."panel/class.panel.php");
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

$cells = array("Id" => '3',
               "Thing" => "Thing 1",
               "Another Thing" => "Thing 2",
               "Checkmeout" => False,
               "RadioGaGa" => 3,
               "TimeandSpace" => time(),
               "Blurb" => "Some Text",
               "Count" => '3.26666',
               "TextArea" => "A house, in the hills",
               "ASelect" => $permissions);

$format = array("Id" => 'id',
                "Thing" => "plain",
                "Another Thing" => "plain",
                "Checkmeout" => "checkbox",
                "RadioGaGa" => "radio, 6",
                "TimeandSpace" => "time, private",
                "Blurb" => "text, placeholder",
                "Count" => "number, value, 4, 8",
                "TextArea" => "textarea, value",
                "ASelect" => "select");


function testWrap($str){
  $array = explode("\n", $str);
  $output = '';
  foreach($array as $line){
    $output .= "  " . $line ."\n";
  }
  return $output;
}


include(SCAFFOLDING."head.php");

echo menubar($permissions, $section, $root);

echo '
        <div class="container">
          <form name="beerManagement" method="post">
            <table class="table table-hover" id="beer">
              <thead>';


$test1 = new Text("Test", "Some test content", $type="text");
$test2 = new Number("Num Test", 4.00, "placeholder", 2, 5);

$test_text = "The Quick Brown Fox Jumped Over the Lazy Dog.";
$test3 = new Textarea("TestArea", $test_text, "placeholder");
$test4 = new Select("SelectTest", $format, "Id", true, 1);
$test0 = new NewRow();
$test5 = new Duration("Test", (time() - (2*24*60*60)), (time() - (2*24*60*60)));
$test6 = new Text("test2333", "some text");
$test7 = new Button("form", "Something Good", "submit");
$test8 = new Cell("ButtonCell", "Look");
$test1->addButton("form", "record", "action", "btntxt", $text=true, $active=false);
$test4->addButton("form", "record", "anotheraction", "moarbtn", $text=true, $active=false);
//$test1->controlOff();
//$test1->disabled();
echo $test1;
echo $test2;
echo $test3;
//echo $test4;
//echo $test0;
//echo $test8;
echo $test5;
echo $test6;
$thing =  testWrap($test4);
echo $thing;
echo $test7;

$strtest = '
123456789
123456789
123456789';

echo $strtest;
echo $strtest;
echo testWrap($strtest);

$test3 = new Row("beer", $cells, $format);
$test3->setCellClass("Blurb", "col-xs-2");
echo $test3;

echo "<br><pre>";
if(isset($_POST)){
  var_dump($_POST);
}
echo "</pre>";

include(SCAFFOLDING_ADMIN."footer.php");