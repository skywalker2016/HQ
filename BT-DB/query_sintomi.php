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
$id_sintomi = $_REQUEST['id_sintomi'];


// **************** AGGIORNA I DATI DEL PAZIENTE ***********************************************
// *********************************************************************************************
if ($_REQUEST['aggiorna'])
{

	$data_inserimento_sintomi = $_REQUEST['data_inserimento_sintomi'];

	$errore_data_inserimento_sintomi1 = controllo_data($data_inserimento_sintomi);

	if ($errore_data_inserimento_sintomi1 == 1);
	else
	{
		// Aggiornamento della tabella del sintomi
		$query= "UPDATE sintomi SET
			data_sintomi ='".$_REQUEST['data_sintomi']."',
			deficit = '".$_REQUEST['deficit']."',
			crisi_epilettica ='".$_REQUEST['crisi_epilettica']."',
			note ='".$_REQUEST['note']."',
			disturbi_comportamento ='".$_REQUEST['disturbi_comportamento']."',
			cefalea ='".$_REQUEST['cefalea']."',
			altro ='".$_REQUEST['sintomi_altro']."',
			deficit_motorio = '".$_REQUEST['deficit_motorio']."',
			data_inserimento = '".data_convert_for_mysql($data_inserimento_sintomi)."'
			WHERE id = '$id_sintomi' ";
		$rs1 = mysql_query($query);	
	
		$pagina = 13;
		include ("log.php");	
	}
}
// *********************************************************************************************
// *********************************************************************************************

$paziente = new patient($id_paziente, NULL, NULL);
$paziente -> retrive_by_ID($id_paziente);

$sintomi = new sintomi(NULL);
$sintomi -> retrive_by_id_sintomi($id_sintomi);


$data_inserimento_sintomi = $sintomi->getData_inserimento();
$data_inserimento_sintomi= data_convert_for_utente($data_inserimento_sintomi);

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
Clinical presentation</font>
<br /><br />
<form action="query_sintomi.php" method="post">
<?php
$cognome = $paziente->getSurname();
$nome = $paziente->getName();	
if ($permission == 3)
{
	$cognome = $cognome[0]."*******";
	$nome = $nome[0]."*******";
}
?>
<table border="0" width="60%" cellspacing="3">
	<tr>
		<td width="25%" align="center" bgcolor="#CACACA">
		<font face="Verdana, Arial, Helvetica, sans-serif" size="2">Last name</font>
		</td>
		<td width="25%" align="center" id='form1'>
		<font face="Verdana, Arial, Helvetica, sans-serif" size="2"><?php print $cognome; ?></font>
		</td>
		<td width="25%" align="center" bgcolor="#CACACA">
		<font face="Verdana, Arial, Helvetica, sans-serif" size="2">Name</font>
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
		<td width="35%" align="right" id='font3'>Date &nbsp;</td>
		<td width="65%" align="left">		
		<?php
		if ($permission == 3)
			print "<input type='text' name='data_inserimento_sintomi' value='".$data_inserimento_sintomi."' size='15' id='form1' disabled='disabled'/>";
		else
			if ($errore_data_inserimento_sintomi1 == 1)
			{
				$data_inserimento_sintomi = NULL;
				print "<input type='text' name='data_inserimento_sintomi' value='".$data_inserimento_sintomi."' size='15' id='form1_A'/>";
			}
			else
				print "<input type='text' name='data_inserimento_sintomi' value='".$data_inserimento_sintomi."' size='15' id='form1'/>";	
		?>	
		</td>	
	</tr>
</table>	
<table border="0" width="53%" cellpadding="0" cellspacing="0">
	<tr>
		<td width="35%" align="right" id='font3'>Date of first clinical sign &nbsp;</td>
		<td width="65%" align="left">
		<?php
		if ($permission == 3)
			print "<input type='text' name='data_sintomi' value='".$data_sintomi."' size='15' id='form1' disabled='disabled'/>";
		else
			print ("<select name='data_sintomi' size='1' cols='10' id='form1'>");
			
			if (($sintomi->getData_sintomi() == '-') ||($sintomi->getData_sintomi() == NULL));
			else
			{
				if ($sintomi->getData_sintomi() == 'ultima_settimana')
					$data_sintomi1 = 'Last week';
				else if ($sintomi->getData_sintomi() == 'ultimo_mese')
					$data_sintomi1 = 'Last month';			
				else if ($sintomi->getData_sintomi() == 'ultimi_sei_mesi')
					$data_sintomi1 = 'Last 6 months';				
				else if ($sintomi->getData_sintomi() == 'piu_sei_mesi')
					$data_sintomi1 = 'More than 6 months';			
			
				print "<OPTION VALUE='".$sintomi->getData_sintomi()."'>".$data_sintomi1."</OPTION>";
			}
			
			print ("<OPTION VALUE='-'>-</OPTION>
					<OPTION VALUE='ultima_settimana'>Last week</OPTION>
					<OPTION VALUE='ultimo_mese'>Last month</OPTION>
					<OPTION VALUE='ultimi_sei_mesi'>Last 6 months</OPTION>
					<OPTION VALUE='piu_sei_mesi'>More than 6 months</OPTION>						
					</select>			
				");	
		?>		
		</td>	
	</tr>
</table>	
<table border="0" width="51%" cellpadding="0" cellspacing="4">	
	<tr>
		<td width="35%" align="right" id='font3'>Clinical sign &nbsp;</td>
		<td width="50%" align="left" id='form1'> <strong><font face="Verdana, Arial, Helvetica, sans-serif" color="#000080" size="2">
		Sensory deficit</font></strong> &nbsp;</td>
		<td width="15%" align="left" id='form1'>
		<?php
		if ($permission == 3)
		{
			if ($sintomi->getDeficit() == 'on')
				print "<input type='checkbox' name='deficit' checked='checked' disabled='disabled'/>  ";
			else
				print "<input type='checkbox' name='deficit' disabled='disabled'/>  ";			
		}
		else
		{
			if ($sintomi->getDeficit() == 'on')
				print "<input type='checkbox' name='deficit' checked='checked'/>  ";
			else
				print "<input type='checkbox' name='deficit'/>  ";			
		}
		?>	
		</td>	
	</tr>
	<tr>
		<td width="35%" align="right" id='font3'></td>
		<td width="50%" align="left" id='form1'> <strong><font face="Verdana, Arial, Helvetica, sans-serif" color="#000080" size="2">
		Motor deficit</font></strong> &nbsp;</td>
		<td width="15%" align="left" id='form1'>
		<?php
		if ($permission == 3)
		{
			if ($sintomi->getDeficit_motorio() == 'on')
				print "<input type='checkbox' name='deficit_motorio' checked='checked' disabled='disabled'/>  ";
			else
				print "<input type='checkbox' name='deficit_motorio' disabled='disabled'/>  ";			
		}
		else
		{
			if ($sintomi->getDeficit_motorio() == 'on')
				print "<input type='checkbox' name='deficit_motorio' checked='checked'/>  ";
			else
				print "<input type='checkbox' name='deficit_motorio'/>  ";			
		}
		?>	
		</td>	
	</tr>
	<tr>
		<td width="35%" align="right" id='font3'></td>
		<td width="50%" align="left" id='form1'> <strong><font face="Verdana, Arial, Helvetica, sans-serif" color="#000080" size="2">
		Epilepsy</font></strong> &nbsp; </td>
		<td width="15%" align="left" id='form1'>
		<?php
		if ($permission == 3)
		{
			if ($sintomi->getCrisi_epilettica() == 'on')
				print "<input type='checkbox' name='crisi_epilettica' checked='checked' disabled='disabled'/>  ";
			else
				print "<input type='checkbox' name='crisi_epilettica' disabled='disabled'/>  ";			
		}
		else
		{
			if ($sintomi->getCrisi_epilettica() == 'on')
				print "<input type='checkbox' name='crisi_epilettica' checked='checked'/>  ";
			else
				print "<input type='checkbox' name='crisi_epilettica'/>  ";			
		}
		?>	
		</td>	
	</tr>
	<tr>
		<td width="35%" align="right" id='font3'></td>
		<td width="50%" align="left" id='form1'> <strong><font face="Verdana, Arial, Helvetica, sans-serif" color="#000080" size="2">
		Behavioral disorder</font></strong> &nbsp; </td>
		<td width="15%" align="left" id='form1'>
		<?php
		if ($permission == 3)
		{
			if ($sintomi->getDisturbi_comportamento() == 'on')
				print "<input type='checkbox' name='disturbi_comportamento' checked='checked' disabled='disabled'/>  ";
			else
				print "<input type='checkbox' name='disturbi_comportamento' disabled='disabled'/>  ";			
		}
		else
		{
			if ($sintomi->getDisturbi_comportamento() == 'on')
				print "<input type='checkbox' name='disturbi_comportamento' checked='checked'/>  ";
			else
				print "<input type='checkbox' name='disturbi_comportamento' />  ";			
		}
		?>	
		</td>	
	</tr>
	<tr>
		<td width="35%" align="right" id='font3'></td>
		<td width="50%" align="left" id='form1'> <strong><font face="Verdana, Arial, Helvetica, sans-serif" color="#000080" size="2">
		Headache</font></strong> &nbsp; </td>
		<td width="15%" align="left" id='form1'>
		<?php
		if ($permission == 3)
		{
			if ($sintomi->getCefalea() == 'on')
				print "<input type='checkbox' name='cefalea' checked='checked' disabled='disabled'/>  ";
			else
				print "<input type='checkbox' name='cefalea' disabled='disabled'/>  ";			
		}
		else
		{
			if ($sintomi->getCefalea() == 'on')
				print "<input type='checkbox' name='cefalea' checked='checked'/>  ";
			else
				print "<input type='checkbox' name='cefalea'/>  ";			
		}
		?>	
		</td>	
	</tr>
</table>
<table border="0" width="51%" cellpadding="0" cellspacing="0">
<tr>
	<td width="35%" align="right" id='font3'>Other &nbsp;</td>
	<td width="65%" align="left">
	<?php
	if ($permission == 3)
		print "<input type='text' name='sintomi_altro' value='".$sintomi->getSintomi_altro()."' size='43' id='form1' disabled='disabled'/>";
	else
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
		if ($permission == 3)
			print "<textarea id='form1' cols='39' rows='3' name='note' disabled='disabled'>".$sintomi->getNote()."</textarea>";
		else
			print "<textarea id='form1' cols='39' rows='3' name='note'>".$sintomi->getNote()."</textarea>";		
		?>	
		</td>	
	</tr>
</table>
<br />
<?php
if ($permission == 3);
else
{
?>
	<table border="0" width="65%">
	<tr>
		<td width="70%" align="center"><hr width="96%" /></td>
		<td width="30%" align="center"><input type='submit' name="aggiorna" value='UPDATE' id='form2'/>
		<input type="hidden" name='id_paziente' value='<?php print $id_paziente; ?>' />
		<input type="hidden" name='id_sintomi' value='<?php print $id_sintomi; ?>' />
		 </td>
	</tr>
	</table>
<?php
}
?>
</form>
	
<br />
<input type="button" onclick="javascript:window.close();" value='CLOSE' id='form2_3'/>
<br />
</div>
</body>
</html>