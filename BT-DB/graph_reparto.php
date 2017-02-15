<?php 
$data = unserialize(urldecode(stripslashes($_GET['mydata'])));
$title = $_REQUEST['title'];

include('phpgraphlib.php');
include('phpgraphlib_pie.php');
$graph = new PHPGraphLibPie(600, 300);

$graph->addData($data);
$graph->setTitle($title);
$graph->setLabelTextColor('30,30,30');
$graph->setLegendTextColor('30,30,30');
$graph->createGraph();
?>