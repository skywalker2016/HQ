<?php
session_start();
include ("accesso_db.php");

if ($permission == NULL)
	header("Location:errore.html");
	
include ("convertitore_date.php");
require_once('class/class.utenti.php');

$utente = new utenti (NULL, NULL, NULL);

// Eliminazione dell'utente *******************************************************************************************
if ($_REQUEST['elimina'] == 1)
{
	$id_utente =$_REQUEST['id'];
	$utente -> delete($id_utente);

	$pagina = 7;
	include ("log.php");
}
// *********************************************************************************************************************

// Inserimento nuovo utente ********************************************************************************************
if ($_REQUEST['new_user'] == 'INSERT')
{
	$utente -> setUsername($_REQUEST['new_username']);
	$utente -> setPassword($_REQUEST['new_password']);
	$utente -> setPermission($_REQUEST['new_permessi']);

	if ($error_1 == 1);
	else
		$utente -> insert();

	$pagina = 6;
	include ("log.php");

}
// *********************************************************************************************************************

// retrive solo il numero degli utenti:
$utente -> retrive(1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
// Javascript function *****************************************************************************************************
function eliminazione(id1)
{
	var chiedi_conferma;
	var id_utente = id1;

	chiedi_conferma =confirm("Are you sure?");
	if (chiedi_conferma == true)
	{ 
   	 	location.href=("modifica_users.php?id="+id_utente+"&elimina=1"); //ricarica la pagina 
  	} 

}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="style.css">
<title></title>
</head>
<body>
<div align="center">
<font id="font2">
Insert / Modify users and passwords
</font>
<br /><br />
<?php
if ($error_1 == 1)
	print ("<font face='Verdana, Arial, Helvetica, sans-serif' size='2' color='#F6F6A9'>Hai lasciato dei campi vuoti (username o password). Non e' stato possibile inserire l'utente </font><br><br>");
?>
<font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#FFB7B7">
	In this page the administrator can insert a new user or modify the users already inserted.
</font>

<br /><br />

<!-- Tabella di utenti abilitati a usare il database -->
<table border="0" cellpadding="0" cellspacing="2" width="80%">
	<tr>
		<td width="5%" align="center" id='font3' bgcolor="#006699">	
		</td>
		<td width="5%" align="center" id='font3' bgcolor="#006699">	
		</td>
		<td width="30%" align="center" id='font3' bgcolor="#006699">
			Username
		</td>
		<td width="30%" align="center" id='font3' bgcolor="#006699">
			Password
		</td>
		<td width="30%" align="center" id='font3' bgcolor="#006699">
			Permission
		</td>
	</tr>
</table>

<table border="0" cellpadding="0" cellspacing="2" width="80%">
<?php
	for ($i=0; $i<$n_utenti; $i++)
	{
		if($i& 1)
			$color='form2';
		else
			$color='form2_2';	
	
		$id_utente = $utente->getID_array($i);
		$utente -> setID($id_utente);
		$utente -> retrive(2);
		
		$permesso=$utente -> getPermission();
	
		print ("<tr>");
			print ("<td align='center' width='5%' id='$color'>");
			print ("<A HREF=\"#a\" onClick=\"window.open('modifica_users2.php?id=$id_utente', 'myWin', 'toolbar, status, width=500, height=300')\">");			
			print ("<img src='images/modifica.png' width='14' alt='Change' title='Change'>");
			print ("</a>");				
			print ("</td>");
			print ("<td align='center' width='5%' id='$color'>");
			print ("<a onClick=\"javascript:eliminazione($id_utente)\">");			
			print ("<img src='images/elimina.png' width='14' alt='Delete' title='Delete'>");
			print ("</a>");		
			print ("</td>");	
		
			print ("<td align='center' width='30%' id='$color'>");
				print ($utente -> getUsername());
			print ("</td>");
			
			print ("<td align='center' width='30%' id='$color'>");
				print ($utente -> getPassword());
			print ("</td>");		
			
			print ("<td align='center' width='30%' id='$color'>");
			if ($permesso == 0)
			{
				print ("Administrator");
			}	
			else if ($permesso == 1)
			{
				print ("Manager or E.R.");
			}					
			else if ($permesso == 3)
			{
				print ("Simple User");
			}	
			else;				
			print ("</td>");	
		print ("</tr>");	
	}	
?>	
</table>
<!-- --------------------------------------------------------------------------------------------------- -->

<br /><br /><br />
<font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#FFB7B7"> New User </font>
<br /><br />
<!-- Inserimento nuovo utente -->
<table border="0" cellpadding="0" cellspacing="2" width="70%">
	<tr>
		<td width="30%" align="center" id='font3' bgcolor="#006799">
			Username
		</td>
		<td width="30%" align="center" id='font3' bgcolor="#006799">
			Password
		</td>
		<td width="40%" align="center" id='font3' bgcolor="#006799">
			Permission
		</td>
	</tr>
</table>
<form action="modifica_users.php" method="post" style="display:inline">
<table border="0" cellpadding="0" cellspacing="2" width="70%">
	<tr>
		<td width="30%" align="center" id='font3' bgcolor="#ACADAE">
			<input type="text" name='new_username' size='20'/>
		</td>
		<td width="30%" align="center" id='font3' bgcolor="#ACADAE">
			<input type="text" name='new_password' size='20'/>
		</td>
		<td width="40%" align="center" id='font3' bgcolor="#ACADAE">
			<select name='new_permessi' size='1' cols='10'>			
			<OPTION VALUE='3'>Simple User</OPTION>
			<OPTION VALUE='1'>Manager / E.R.</OPTION>
			<OPTION VALUE='0'>Administrator</OPTION>
			</select>
		</td>
	</tr>
</table>
<br />
<input type="submit" name='new_user' value='INSERT' id='form2'/>
</form>
<!-- --------------------------------------------------------------------------------------------------- -->

<br />
<br /><br /><br />
<font face='Verdana, Arial, Helvetica, sans-serif' size='2' color='#F6F6A9'>
When your password is deleted, you can use this database until your sign-out<br />
Then you will have to use the new password.
</font>

</div>
</body>
</html>