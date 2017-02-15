<?php
session_start();
include ("accesso_db.php");

$pagina = 5;
include ("log.php");

if ($permission == NULL)
	header("Location:errore.html");
	
include ("convertitore_date.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
// Javascript function *****************************************************************************************************
function table(link)
{
	var nome_tabella=link[link.selectedIndex].value;

	if (nome_tabella == '');
	else
	{
		var destination_page = "modifica_tabella.php";
		location.href = destination_page+"?nome_tabella="+nome_tabella;
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="style.css">
<title></title>
</head>
<body>
<div align="center">
<br />
<font id="font2">
Database Administration
</font>
<br /><br /><br />

<a href='modifica_users.php'>
	<div id='menu_amministrazione'>
		Insert or modify Users
	</div>
</a>

<br /><br />

<div id='menu_amministrazione'>
	Insert or modify data in table:<br />
	<select name='tabella' size='1' cols='10'  onChange="table(this)">	
	<OPTION VALUE=''>-----------------</OPTION>		
	<OPTION VALUE='sede'>Site</OPTION>
	</select>
</div>

<br /><br />

<div id='menu_amministrazione'>
	Database Backup
</div>

<br />
</div>
</body>
</html>