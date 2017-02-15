<?php
session_start();
include ("accesso_db.php");

if ($_REQUEST['submit_password_er'])
{
	$username = 'ER';
	$password_er=$_REQUEST['password_er'];

	// Check if the password is correct:
	$query = "SELECT permission FROM user WHERE username='$username' AND password='$password_er' ";
	$risultato = mysql_query($query);	
	while (list($permission1) = mysql_fetch_array($risultato))
	{
		$permission = $permission1;
	}

	if ($permission == NULL)
	{
		// Error, the username and password are not correct:
		$error1=1;
	}	
	else
	{
		// Now the database will record the Username and Password by SESSION variable:
		$_SESSION['username'] = $username;
		$_SESSION['password'] = $password_er;
		$_SESSION['permission'] = $permission;
		// Send the USER to page: home.php
		header("Location:home.php?start=1");
	}
}

if ($_REQUEST['back'])
	header("Location:index.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="style.css">
<title>Documento senza titolo</title>
</head>
<body>
<div align="center">
<font id='font1'> Tumors Database </font>
<br />
<hr id='hr1' size='5px'/>
<br /><br /><br />
<font id='font7'>Insert E.R. password.</font> <br /><br />
<?php
if ($error1 == 1)
	print ("<font id='font7'>The password is not correct</font> <br /><br />");
?>
<form action="password_er.php" style="display:inline">
<input type='password' name='password_er' size='40' id='form1'/>
<br /><br><br /><br />
<hr width="40%" />
<br>
<table border="0" cellpadding="0" cellspacing="0" width="30%">
<tr>
	<td width="50%" align="center">
		<input type="submit" name='submit_password_er' value='INSERT' id='form2'/>
	</td>
	<td width="50%" align="center">
		 <input type="submit" name='back' value='BACK' id='form3'/>
	</td>	
</tr>
</table>
</form>
<br />
</body>
</html>