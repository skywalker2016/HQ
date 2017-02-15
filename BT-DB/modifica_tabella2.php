<?php
session_start();
include ("accesso_db.php");

if ($permission == NULL)
	header("Location:errore.html");
	
include ("convertitore_date.php");

require_once('class/class.tabella.php');

// recupera i dati dell'utente:
$id_valore = $_REQUEST['id'];
$nome_tabella = $_REQUEST['nome_tabella'];
$nome_colonna = $_REQUEST['nome_colonna'];

// Modifica questo utente **********************************************************************************************
if ($_REQUEST['modifica_user'] == 'CHANGE')
{
	$new_dato1 = $_REQUEST['new_dato1'];

	if ($new_dato1 == NULL)
		$error3 = 1;
	else // modifica i dati:
	{
		$query= "UPDATE $nome_tabella SET
				$nome_colonna = '$new_dato1'
				WHERE id = '$id_valore' ";
		 $rs2 = mysql_query($query);	
	}
}
// *********************************************************************************************************************

$tab = new tabella ($nome_tabella, $nome_colonna);
$tab -> setID($id_valore);
$tab -> retrive(2);
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
Change this value
</font>
<br /><br />
<?php
if ($error3 == 1)
	print ("<font face='Verdana, Arial, Helvetica, sans-serif' size='2' color='#F6F6A9'>You have left a empty field. The new value has not been inserted. </font><br>");
?>

<br />

<form action="modifica_tabella2.php" method="post" style="display:inline">
<!-- Modifica dato -->
<table border="0" cellpadding="0" cellspacing="2" width="70%">
	<tr>
		<td width="100%" align="center" id='font3' bgcolor="#006799">
			Value
		</td>
	</tr>
</table>
<form action="modifica_tabella.php" method="post" style="display:inline">
<table border="0" cellpadding="0" cellspacing="2" width="70%">
	<tr>
		<td width="100%" align="center" id='font3' bgcolor="#ACADAE">
			<input type="text" name='new_dato1' size='30' value='<?php print $tab->getValore(); ?>'/>
		</td>
	</tr>
</table>
<br />
<input type="submit" name='modifica_user' value='CHANGE' id='form2'/>
<input type="hidden" name='nome_tabella' value='<?php print $nome_tabella; ?>' />
<input type="hidden" name='nome_colonna' value='<?php print $nome_colonna; ?>' />
<input type='hidden' name="id" value="<?php print $id_valore; ?>" />
</form>
<!-- --------------------------------------------------------------------------------------------------- -->
<br />

</form>
<br />
</div>
</body>
</html>