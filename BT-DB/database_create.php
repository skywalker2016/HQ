<?php
session_start();

$create=$_REQUEST['create'];
$username=$_REQUEST['username'];
$password=$_REQUEST['password'];

if ($create != NULL)
{
	$database = mysql_connect('localhost', $username, $password);

	$query = "CREATE DATABASE my_tumorsdatabase"; 
	$ris= mysql_query($query);

	$query = "USE my_tumorsdatabase"; 
	$ris= mysql_query($query);


	$percorso_ripristino="backup//empty.sql";
	$ripristino=("mysql -u$username -p$password my_tumorsdatabase < ").$percorso_ripristino;  // *** da modificare il nome del database.
	system($ripristino);
		
	print ("<center><br><br><br><br><br>You have created TUMORS DB");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento senza titolo</title>
</head>

<body>
<center>
<br /><br /><br /><br /><br /><br />
<form action="database_create.php" method="post">
Insert MySQL username
<input type="text" name='username' size='30' /><br />
Insert MySQL password
<input type="text" name='password' size='30' /><br /><br />
<input type='submit' name='create' value='CREATE THE DATABASE' />
</form>
</body>
</html>
