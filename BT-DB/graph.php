<?php 
$data = unserialize(urldecode(stripslashes($_GET['mydata'])));
$title = $_REQUEST['title'];

include("phpgraphlib.php"); 
$graph=new PHPGraphLib(700,350);
$graph->addData($data);
$graph->setTitle($title);

if ($title == 'AREA DI ATTIVAZIONE MOTORIA')
	$graph->setXValuesHorizontal(true);
else if ($title == 'AREA DI ATTIVAZIONE SENSITIVA')
	$graph->setXValuesHorizontal(true);	
else
	$graph->setXValuesHorizontal(false);


$graph->setGradient("red", "maroon");
$graph->createGraph();
?>