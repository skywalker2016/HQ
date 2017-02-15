<?php
session_start();
include ("accesso_db.php");

// Delete the SESSION variables
$_SESSION['username'] = NULL;
$_SESSION['password'] = NULL;
$_SESSION['permission'] = NULL;      //权限

// Retrive the information about Username and Password from FORM:
if ($_REQUEST['entrata'])            //入口
{
	$username = $_REQUEST['username'];
	$password = $_REQUEST['password'];

	// Check if the Username and Password are correct:
	$query = "SELECT permission FROM user WHERE username='$username' AND password='$password' ";
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
		$_SESSION['password'] = $password;
		$_SESSION['permission'] = $permission;
		// Send the USER to page: home.php
		header("Location:home.php?start=1");
	}
}

if ($_REQUEST['entrata_ER'])
{
	// In this case, the USER will has to insert the ER password in order to have access at the database:
	header("Location:password_er.php");
}	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="style.css">
<title>Database Tumori</title>
</head>
<body>
<div align='center'>
<font id='font1'> Tumors Database </font>
<br />
<hr id='hr1' size='5px'/>
<br /><br /><br />
<font id='font2'> Insert Username and Password</font>
<br /><br />
<?php
if ($error1 == 1)
	print ("<font id='font7'>The password is not correct/font> <br /><br />");
?>
<br />
<font id='font3'>
<form action="index.php" style="display:inline">
<table border="0" width="35%" cellpadding="0" cellspacing="2px">
	<tr>
		<td width="40%" align="center"> Username &nbsp;</td>
		<td width="60%" align="left"><input type='text' name='username' size='35' id="form1"/></td>
	</tr>	
	<tr>
		<td width="40%" align="center"> Password &nbsp;</td>
		<td width="60%" align="left"><input type='password' name='password' size='35' id="form1"/></td>
	</tr>	
</table>
</font>
<br /><br />
<table border="0" width="25%" cellpadding="0" cellspacing="2px">
	<tr>
		<td width="50%" align="center"><input type='submit' name='entrata' value='GO DATABASE' id='form2'/></td>
		<td width="50%" align="center"><input type='submit' name='entrata_ER' value=' E.R.' id='form3'/></td>
	</tr>	
</table>
</form>
<br /><br /><br /><br /><br /><br /><br />
<hr width="40%" />
<br />
<font id='font4'>
Tumors Database - v2.0 - maurizio.bergamino@gmail.com
</font>
</div>
</body>
</html>