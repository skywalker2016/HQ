<?php
session_start();
include ("accesso_db.php");

if ($permission == NULL)
	header("Location:errore.html");

$id_paziente = $_REQUEST['id_paziente'];

$pagina = 3;
include ("log.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="style.css">
<title></title>
</head>

<body>
<div align="center">
<br /><br /><br /><br />
<div id='conferma'>
 The data have been inserted in the database
</div>
<br /><br />
<form action="query_paziente_generale.php" method="post">
<input type="submit" name='vai_paziente' value="SHOW THIS PATIENT AND HIS/HER EXAMS" id='form2'/>
<input type="hidden" name='id' value="<?php print $id_paziente; ?>" />
</form>

<br /><br /><br /><br /><br />
<form action="home2.php">
<input type="submit" value=' HOME ' id='form2'/>
</form>
<br />
</font>
</body>
</html>
