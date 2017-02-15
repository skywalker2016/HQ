<?php
session_start();
include ("accesso_db.php");

$pagina = 1;
include ("log.php");

if ($permission == NULL)
	header("Location:errore.html");
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
<br />

<div id='benvenuto'>
	<br />
	<font face="Georgia, Times New Roman, Times, serif" size="7" color="#800040">BrainTumors DB</font>
	<br /><br />
</div>

<br /><br />
<hr width="50%" id="hr_home"/>
<br /><br />
<font id='font3_B'>Search a patient</font>
<form action="ricerca_paziente.php" method="post" style='display:inline'><br />
<input type="text" name='nominativo_paziente' size='30' id='form1' value=''/>&nbsp; &nbsp;
<input type="submit" name='go' value=' GO ' id='form2'/>

<br /><br /><br /><br /><br /><font face="Verdana, Arial, Helvetica, sans-serif" size="4" color="#FFFFCC">OR</font><br /><br />
<input type="submit" name='all' value="Show all patients" id='form2' />
</form>
<br />
</div>
</body>
</html>