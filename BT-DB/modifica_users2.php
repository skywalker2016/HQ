<?php
session_start();
include ("accesso_db.php");

if ($permission == NULL)
	header("Location:errore.html");
	
include ("convertitore_date.php");

require_once('class/class.utenti.php');

// recupera i dati dell'utente:
$id_utente = $_REQUEST['id'];

// Modifica questo utente **********************************************************************************************
if ($_REQUEST['modifica_user'] == 'CHANGE')
{
	$username_new = $_REQUEST['new_username'];
	$password_new = $_REQUEST['new_password'];
	$permessi_new = $_REQUEST['new_permessi'];

	if ( ($username_new == NULL) || ($password_new == NULL) || ($permessi_new == NULL) )
		$error3 = 1;
	else // modifica i dati:
	{
		$query= "UPDATE user SET
				username = '$username_new',
				password = '$password_new',
				permission = '$permessi_new'
				WHERE id = '$id_utente' ";
		 $rs2 = mysql_query($query);	
		 
		 $pagina = 8;
		include ("log.php");		 
	}
}
// *********************************************************************************************************************

$utente = new utenti (NULL, NULL, NULL);
$utente -> setID($id_utente);
$utente -> retrive(2);
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
<br /><br />
<font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#FFB7B7">
Modify this user
</font>
<br /><br />
<?php
if ($error3 == 1)
	print ("<font face='Verdana, Arial, Helvetica, sans-serif' size='2' color='#F6F6A9'>Hai lasciato dei campi vuoti. Non e' stato possibile modificare l'utente </font><br>");
?>

<br />

<form action="modifica_users2.php" method="post" style="display:inline">
<table border="0" cellpadding="0" cellspacing="2" width="70%">
	<tr>
		<td width="100%" align="center" id='font3' bgcolor="#ACADAE">
			<font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#0D0694">Username:</font> 
			<input type="text" name='new_username' size='20' value='<?php print $utente->getUsername(); ?>'/>
		</td>
	</tr>
	<tr>
		<td width="100%" align="center" id='font3' bgcolor="#ACADAE">
			<font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#0D0694">Password:</font>
			<input type="text" name='new_password' size='20' value='<?php print $utente->getPassword(); ?>'/>
		</td>
	</tr>
	<tr>
		<td width="100%" align="center" id='font3' bgcolor="#ACADAE">
			<font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#0D0694">Permission:</font> 
			<select name='new_permessi' size='1' cols='10'>	
			<?php
			if ($utente->getPermission() == 0)
				print("<OPTION VALUE='0'>Administrator</OPTION>");
			else if ($utente->getPermission() == 1)
				print("<OPTION VALUE='1'>Manager / E.R.</OPTION>");
			else if ($utente->getPermission() == 3)
				print("<OPTION VALUE='3'>Simple User</OPTION>");
			?>
			<OPTION VALUE=''>------------</OPTION>
			<OPTION VALUE='3'>Simple User</OPTION>
			<OPTION VALUE='1'>Manager / E.R.</OPTION>
			<OPTION VALUE='0'>Administrator</OPTION>
			</select>
		</td>
	</tr>
</table>
<br />
<input type="submit" name='modifica_user' value='CHANGE' id='form2'/>
<input type='hidden' name="id" value="<?php print $id_utente; ?>" />
</form>
<br />
</div>
</body>
</html>