<?php
session_start();
include ("accesso_db.php");

if ($permission == NULL)
	header("Location:errore.html");
	
include ("convertitore_date.php");
include ("function_php/try_format_date.php");
require_once('class/class.patient.php');
require_once('class/class.sintomi.php');
require_once('class/class.dataExamInsert.php');

$id_paziente =$_REQUEST['id_paziente'];

$paziente = new patient($id_paziente, NULL, NULL);
$paziente -> retrive_by_ID($id_paziente);

// Inserisce i dati nella tabella sintomi:
if ($_REQUEST['inserisci'])
{		
	$data_inserimento= $_REQUEST['data_inserimento_sintomi'];		

	$sintomi = new sintomi($data_inserimento);	
	$sintomi->setDeficit($_REQUEST['deficit']);
	$sintomi->setDeficit_motorio($_REQUEST['deficit_motorio']);	
	$sintomi->setCrisi_epilettica($_REQUEST['crisi_epilettica']);	
	$sintomi->setNote($_REQUEST['note']);		
	$sintomi->setData_sintomi($_REQUEST['data_sintomi']);
	$sintomi->setDisturbi_comportamento($_REQUEST['disturbi_comportamento']);	
	$sintomi->setCefalea($_REQUEST['cefalea']);
	$sintomi->setSintomi_altro($_REQUEST['sintomi_altro']);	
	
	$data_inserimento2=data_convert_for_mysql($data_inserimento);
	
	if ($errore_data_inserimento_sintomi == 1);
	else
	{
		$sintomi->insert($id_paziente, $data_inserimento2);	
		
		if ($error != 1)
			$ok_inserimento =1;
	}
}
else
{
	$ok_inserimento = NULL;
	$sintomi = new sintomi(NULL);
	$errore_data_inserimento_sintomi = NULL;
}
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
<?php include ("barra_titolo.html"); ?>
<hr id='hr1' size='5px'/>
<br />
<font id="font2">
Inserisci nuovi sintomi d'esordio</font>
<br /><br />
<?php
	if ($errore_data_inserimento_sintomi == 1)
		print ("<font id='font4'>Ricontrolla i dati: i formati delle date sono errate</font><br>");
		
	if ($error == 1)
		print ("<font id='font4'>C'e' stato un problema durante l'inserimento dei dati nel database. <br>
		I dati non sono stati inseriti correttamente. Riprovare o contattare l'amministratore.</font><br>");			
?>

<form action="nuovi_sintomi.php" method="post">
<?php
$cognome = $paziente->getSurname();
$nome = $paziente->getName();	
?>
<table border="0" width="60%" cellspacing="3">
	<tr>
		<td width="25%" align="center" bgcolor="#CACACA">
		<font face="Verdana, Arial, Helvetica, sans-serif" size="2">Cognome</font>
		</td>
		<td width="25%" align="center" id='form1'>
		<font face="Verdana, Arial, Helvetica, sans-serif" size="2"><?php print $cognome; ?></font>
		</td>
		<td width="25%" align="center" bgcolor="#CACACA">
		<font face="Verdana, Arial, Helvetica, sans-serif" size="2">Nome</font>
		</td>
		<td width="25%" align="center" id='form1'>
		<font face="Verdana, Arial, Helvetica, sans-serif" size="2"><?php print $nome; ?></font>
		</td>
	</tr>
</table>
<hr width="60%" size='4'/>
<br />
<table border="0" width="53%" cellpadding="0" cellspacing="0">
	<tr>
		<td width="35%" align="right" id='font3'>Data inserimento sintomi &nbsp;</td>
		<td width="65%" align="left">
		<?php
			if ($errore_data_inserimento_sintomi == 1)
				print "<input type='text' name='data_inserimento_sintomi' value='".$data_inserimento_sintomi."' size='15' id='form1_A'/>";	
			else
				print "<input type='text' name='data_inserimento_sintomi' value='".$data_inserimento_sintomi."' size='15' id='form1'/>";	
		?>
		<font id='font4'>(gg/mm/aaaa)</font>	
		</td>	
	</tr>
</table>	
<table border="0" width="53%" cellpadding="0" cellspacing="0">
	<tr>
		<td width="35%" align="right" id='font3'>Data sintomi &nbsp;</td>
		<td width="65%" align="left">
		<?php
			print "<input type='text' name='data_sintomi' value='".$sintomi->getData_sintomi()."' size='43' id='form1'/>";	
		?>	
		</td>	
	</tr>
</table>	
<table border="0" width="51%" cellpadding="0" cellspacing="4">	
	<tr>
		<td width="35%" align="right" id='font3'>Tipo sintomi &nbsp;</td>
		<td width="50%" align="left" id='form1'> <strong><font face="Verdana, Arial, Helvetica, sans-serif" color="#000080" size="2">
		Deficit sensitivo</font></strong> &nbsp;</td>
		<td width="15%" align="left" id='form1'>
		<?php
			if ($sintomi->getDeficit() == 'on')
				print "<input type='checkbox' name='deficit' checked='checked'/>  ";
			else
				print "<input type='checkbox' name='deficit'/>  ";			
		?>	
		</td>	
	</tr>
	<tr>
		<td width="35%" align="right" id='font3'>Tipo sintomi &nbsp;</td>
		<td width="50%" align="left" id='form1'> <strong><font face="Verdana, Arial, Helvetica, sans-serif" color="#000080" size="2">
		Deficit motorio</font></strong> &nbsp;</td>
		<td width="15%" align="left" id='form1'>
		<?php
			if ($sintomi->getDeficit_motorio() == 'on')
				print "<input type='checkbox' name='deficit_motorio' checked='checked'/>  ";
			else
				print "<input type='checkbox' name='deficit_motorio'/>  ";			
		?>	
		</td>	
	</tr>
	<tr>
		<td width="35%" align="right" id='font3'></td>
		<td width="50%" align="left" id='form1'> <strong><font face="Verdana, Arial, Helvetica, sans-serif" color="#000080" size="2">
		Crisi epilettica</font></strong> &nbsp; </td>
		<td width="15%" align="left" id='form1'>
		<?php
			if ($sintomi->getCrisi_epilettica() == 'on')
				print "<input type='checkbox' name='crisi_epilettica' checked='checked'/>  ";
			else
				print "<input type='checkbox' name='crisi_epilettica'/>  ";			
		?>	
		</td>	
	</tr>
	<tr>
		<td width="35%" align="right" id='font3'></td>
		<td width="50%" align="left" id='form1'> <strong><font face="Verdana, Arial, Helvetica, sans-serif" color="#000080" size="2">
		Disturbi comportamentali</font></strong> &nbsp; </td>
		<td width="15%" align="left" id='form1'>
		<?php
			if ($sintomi->getDisturbi_comportamento() == 'on')
				print "<input type='checkbox' name='disturbi_comportamento' checked='checked'/>  ";
			else
				print "<input type='checkbox' name='disturbi_comportamento' />  ";			
		?>	
		</td>	
	</tr>
	<tr>
		<td width="35%" align="right" id='font3'></td>
		<td width="50%" align="left" id='form1'> <strong><font face="Verdana, Arial, Helvetica, sans-serif" color="#000080" size="2">
		Cefalea</font></strong> &nbsp; </td>
		<td width="15%" align="left" id='form1'>
		<?php
			if ($sintomi->getCefalea() == 'on')
				print "<input type='checkbox' name='cefalea' checked='checked'/>  ";
			else
				print "<input type='checkbox' name='cefalea'/>  ";			
		?>	
		</td>	
	</tr>
</table>
<table border="0" width="51%" cellpadding="0" cellspacing="0">
<tr>
	<td width="35%" align="right" id='font3'>Altri sintomi &nbsp;</td>
	<td width="65%" align="left">
	<?php
		print "<input type='text' name='sintomi_altro' value='".$sintomi->getSintomi_altro()."' size='43' id='form1'/>";	
	?>	
	</td>	
</tr>
</table>	
<table border="0" width="39%" cellpadding="0" cellspacing="0">
	<tr>
		<td width="30%" align="right" id='font3'>Note &nbsp;</td>
		<td width="70%" align="left">
		<?php
			print "<textarea id='form1' cols='39' rows='3' name='note'>".$sintomi->getNote()."</textarea>";		
		?>	
		</td>	
	</tr>
</table>
<br />
<?php
if (($permission == 3) || ($ok_inserimento == 1));
else
{
?>
	<table border="0" width="65%">
	<tr>
		<td width="70%" align="center"><hr width="96%" /></td>
		<td width="30%" align="center"><input type='submit' name="inserisci" value='INSERISCI DATI' id='form2'/>
		<input type="hidden" name='id_paziente' value='<?php print $id_paziente; ?>' />
		 </td>
	</tr>
	</table>
<?php
}
?>
</form>
	
<br />
<input type="button" onclick="javascript:window.close();" value='CHIUDI' id='form2_3'/>
<br />
</div>
</body>
</html>