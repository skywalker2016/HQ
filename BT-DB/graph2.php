<?php 
$data = unserialize(urldecode(stripslashes($_GET['mydata'])));
$title = $_REQUEST['title'];

include("phpgraphlib.php"); 
$graph=new PHPGraphLib(700,400);
$graph->addData($data);
$graph->setupXAxis(22);
$graph->setTitle($title);
$graph->setGradient("red", "maroon");
$graph->createGraph();
?>