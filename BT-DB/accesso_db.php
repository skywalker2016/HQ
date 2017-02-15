<?php
session_start();
// recupera username e password da p.php
include ("p.php");

$_SESSION['username_mysql'] = $aa;
$_SESSION['password_mysql'] = $bb;

// MySQL database connection: *********************************************************************************
$database = mysql_connect('localhost', $aa, $bb); // These are the username and password
//$database = mysql_connect('localhost', 'tumorsdatabase', 'tesdivavce87');
$var=mysql_select_db('my_tumorsdatabase');   // Name of MySQL database (my_tumor)
//**************************************************************************************************************

$permission = $_SESSION['permission'];
?>