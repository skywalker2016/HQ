<?php
session_start();
include ("accesso_db.php");


if ($permission == NULL)
	header("Location:errore.html");
	
include ("convertitore_date.php");
require_once('class/class.tabella.php');

$nome_tabella = $_REQUEST['nome_tabella'];

if ($nome_tabella == 'tumori_principali')
{
	$nome_colonna = 'valore';
	$nome_tabella1 = 'Tipo di tumore';
}
else if ($nome_tabella == 'sede')
{
	$nome_colonna = 'sede';
	$nome_tabella1 = 'Sede';
}


$tab = new tabella ($nome_tabella, $nome_colonna);


// Inserimento nuovo utente ********************************************************************************************
if ($_REQUEST['inserisci'] == 'INSERT')
{
	$tab -> setValore($_REQUEST['new_dato1']);

	if ($error_44 == 1);
	else
		$tab -> insert();
}
// *********************************************************************************************************************

// Eliminazione del valore *******************************************************************************************
if ($_REQUEST['elimina'] == 1)
{
	$id =$_REQUEST['id'];
	$tab -> delete($id);
}
// ********************************************************************************************************************


// retrive solo il numero dei dati:
$tab -> retrive(1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
// Javascript function *****************************************************************************************************
function eliminazione(id1, tab)
{
	var chiedi_conferma;
	var id_valore = id1;
	var nome_tabella = tab;

	chiedi_conferma =confirm("Are you sure?");
	if (chiedi_conferma == true)
	{ 
   	 	location.href=("modifica_tabella.php?id="+id_valore+"&elimina=1&nome_tabella="+nome_tabella); //ricarica la pagina 
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
Change data in this table
</font>
<br /><br />
<?php
if ($error_44 == 1)
	print ("<font face='Verdana, Arial, Helvetica, sans-serif' size='2' color='#F6F6A9'>You have left a empty field. The new value has not been inserted. </font><br><br>");
?>

<br /><br />

<table border="0" cellpadding="0" cellspacing="2" width="50%">
	<tr>
		<td width="5%" align="center" id='font3' bgcolor="#006699">	
		</td>
		<td width="5%" align="center" id='font3' bgcolor="#006699">	
		</td>
		<td width="90%" align="center" id='font3' bgcolor="#006699">
		Value
		</td>
	</tr>
</table>

<table border="0" cellpadding="0" cellspacing="2" width="50%">
<?php
	for ($i=0; $i<$n_valori; $i++)
	{

		$id_valore = $tab->getID_array($i);
		$tab -> setID($id_valore);
		$tab -> retrive(2);

		if($i& 1)
			$color='form2';
		else
			$color='form2_2';	
	
	
		print ("<tr>");
			print ("<td align='center' width='5%' id='$color'>");
			print ("<A HREF=\"#a\" onClick=\"window.open('modifica_tabella2.php?id=$id_valore&nome_tabella=$nome_tabella&nome_colonna=$nome_colonna', 'myWin', 'toolbar, status, width=500, height=300')\">");			
			print ("<img src='images/modifica.png' width='14' alt='Change' title='Change'>");
			print ("</a>");				
			print ("</td>");
			print ("<td align='center' width='5%' id='$color'>");
			print ("<a onClick=\"javascript:eliminazione('$id_valore', '$nome_tabella')\">");			
			print ("<img src='images/elimina.png' width='14' alt='Delete' title='Delete'>");
			print ("</a>");		
			print ("</td>");	
		
			print ("<td align='center' width='90%' id='$color'>");
				print ($tab -> getValore());
			print ("</td>");
				
		print ("</tr>");	
	}	
?>	
</table>

<br /><br /><br />
<font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#FFB7B7"> Insert new data in the table</font>
<br /><br />
<!-- Inserimento nuovo dato -->
<table border="0" cellpadding="0" cellspacing="2" width="30%">
	<tr>
		<td width="100%" align="center" id='font3' bgcolor="#006799">
			Value
		</td>
	</tr>
</table>
<form action="modifica_tabella.php" method="post" style="display:inline">
<table border="0" cellpadding="0" cellspacing="2" width="30%">
	<tr>
		<td width="100%" align="center" id='font3' bgcolor="#ACADAE">
			<input type="text" name='new_dato1' size='30'/>
		</td>
	</tr>
</table>
<br />
<input type="submit" name='inserisci' value='INSERT' id='form2'/>
<input type="hidden" name='nome_tabella' value='<?php print $nome_tabella; ?>' />
<input type="hidden" name='nome_colonna' value='<?php print $nome_colonna; ?>' />
</form>
<!-- --------------------------------------------------------------------------------------------------- -->

<br />
</div>
</body>
</html>