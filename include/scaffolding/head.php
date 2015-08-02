<!DOCTYPE = html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="The website for Finger Lakes On Tap">
    <meta name="keywords" content="tavern, pub, bar, microbrew, microbrewery, finger lakes, flot, alehouse, beer">
    <meta name="author" content="William LaMorie, wjl10@cornell.edu">
    <link rel="icon" href="/<?php echo IMAGES; ?>general/favicon.ico">

    <title><?php if(isset($title)){echo $title;} else{echo"Finger Lakes On Tap!";}?></title>

    <!-- JQuery-->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <!-- Bootstrap core CSS & JS-->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <script type="text/javascript" src="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <!-- Custom styles for the site -->
    <link rel="stylesheet" type="text/css" href="/<?php
    if(isset($root) && ($root == ADMIN))
    {echo CSS."admin.css";} else {echo CSS."style.css";};?>">
    <!-- Custom JS for the site -->
    <script type="text/javascript" src="/<?php echo JAVASCRIPT; ?>javascript.js"></script>
<?php if(isset($root) && ($root == ADMIN)){echo'    <script type="text/javascript" src="/'.JAVASCRIPT .'admin.js"></script>'. PHP_EOL;}?>
<?php if(isset($root) && ($root == ADMIN)){echo'    <script type="text/JavaScript" src="/'.JAVASCRIPT. 'sha512.js"></script>'. PHP_EOL;}?>
<?php if(isset($root) && ($root == ADMIN)){echo'    <script type="text/JavaScript" src="/'.JAVASCRIPT. 'forms.js"></script>'. PHP_EOL;}?>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/<?php echo JAVASCRIPT; ?>ie10-viewport-bug-workaround.js"></script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
   
  </head>
  <body>
    <div class="container">