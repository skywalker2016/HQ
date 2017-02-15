<?php
session_start();
include ("accesso_db.php");
require_once('class/class.patient.php');
require_once('class/class.dataExamInsert.php');
include ("convertitore_date.php");
include ("function_php/try_format_date.php");

$permission = $_SESSION['permission'];
if ($permission == NULL)
	header("Location:errore.html");

// **************** AGGIORNA I DATI DEL PAZIENTE ***********************************************
// *********************************************************************************************
if ($_REQUEST['aggiorna'])
{
	$id_paziente = $_REQUEST['id_paziente'];
	$data_inserimento = $_REQUEST['data_inserimento'];
	$data_nascita = $_REQUEST['data_nascita'];
	$data_decesso = $_REQUEST['data_decesso'];	

	if ($data_decesso == NULL)
		$data_decesso = '00/00/0000';

	// controlla le date:
	$errore_data_inserimento = controllo_data($data_inserimento);
	$errore_data_nascita1 = controllo_data($data_nascita);
	$errore_data_decesso1 = controllo_data($data_decesso);
	
	if (($errore_data_inserimento == 1) || ($errore_data_nascita1 == 1) || ($errore_data_decesso1 == 1))
		$errore = 1;
	else
	{
		$data_inserimento = data_convert_for_mysql($_REQUEST['data_inserimento']);
		$data_nascita = data_convert_for_mysql($_REQUEST['data_nascita']);
		$data_decesso = data_convert_for_mysql($data_decesso);

		// Aggiornamento della tabella del Paziente
		$query= "UPDATE patient SET
			surname ='".strtoupper($_REQUEST['cognome'])."',
			name = '".strtoupper($_REQUEST['nome'])."',
			date_birthday ='".$data_nascita."',
			sex ='".$_REQUEST['sex']."',
			address ='".$_REQUEST['indirizzo']."',
			telephone ='".$_REQUEST['telefono']."',
			note ='".$_REQUEST['note_paziente']."',
			reparto_provenienza ='".$_REQUEST['reparto_provenienza']."',
			data_decesso ='".$data_decesso."'
			WHERE id = '$id_paziente' ";
		$rs1 = mysql_query($query);

		// Aggiornamento della tabella Inserimento
		$query= "UPDATE inserimento SET
		data_inserimento ='".$data_inserimento."'
		WHERE id_paziente = '$id_paziente' ";
		$rs2 = mysql_query($query);	
		
		
		$pagina = 12;
		include ("log.php");	
	}	
	
	 if ( ($rs1 == NULL) || ($rs2 == NULL) )  // C'� un errore -> il formato delle date non � corretto
	 	$errore = 1;	

}
// *********************************************************************************************
// *********************************************************************************************
else
	$id_paziente = $_REQUEST['id'];

// ****** VISUALIZZA LA PAGINA DEI SINTOMI D'ESORDIO *****************************************	
if ($_REQUEST['sintomi'])
{
	$id_paziente = $_REQUEST['id_paziente'];
	header("Location:query_sintomi.php?id_paziente=$id_paziente");
}
// *********************************************************************************************

$paziente = new patient($id_paziente, NULL, NULL);
$paziente -> retrive_by_ID($id_paziente);

// Retrive the insert_data from Inserimento table by id_patient.
$inserimento= new dataExamInsert(NULL);
$inserimento -> setID_paziente($id_paziente);
$inserimento -> retrive_data();
$data_inserimento=$inserimento -> getData_inserimento();
$data_inserimento=data_convert_for_utente($data_inserimento);

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
	
<?php
if ($errore == 1)
	print ("<font id='font4'> ERROR. Please chek the data format. <br><br>");
?>
	<form action="query_paziente.php" method="post">
	<table border="0" width="60%">
		<tr>
			<td width="60%" align="right"><font face="Verdana, Arial, Helvetica, sans-serif" color="#99CCCC" size='3'>Date &nbsp;</font></td>
			<td width="40%" align="left">
			<?php  
			if ($permission == 3)
				print "<input type='text' name='data_inserimento' value='".$data_inserimento."' size='20' id='form1_D' disabled='disabled'/>";
			else
			{
				if ($errore_data_inserimento == 1)
				{
					$data_inserimento = NULL;
					print "<input type='text' name='data_inserimento' value='".$data_inserimento."' size='20' id='form1_A'/>";		
				}
				else
					print "<input type='text' name='data_inserimento' value='".$data_inserimento."' size='20' id='form1_D'/>";	

			}

			?>			
			</td>		
		</tr>
	</table>
	<br />
	<table border="0" width="60%" cellpadding="0" cellspacing="0">
		<tr>
			<td width="35%" align="right" id='font3'>Last name &nbsp;</td>
			<td width="65%" align="left">
			<?php
			if ($permission == 3)
			{
				$cognome = $paziente->getSurname();
				$cognome = $cognome[0]."************";
				print "<input type='text' name='cognome' value='".$cognome."' size='50' id='form1' disabled='disabled'/>";
			}
			else
				print "<input type='text' name='cognome' value='".$paziente->getSurname()."' size='50' id='form1'/>";	
			?>	
			</td>	
		</tr>
		<tr>
			<td width="30%" align="right" id='font3'>Name &nbsp;</td>
			<td width="70%" align="left">
			<?php
			if ($permission == 3)
			{
				$nome = $paziente->getName();
				$nome = $nome[0]."************";
				print "<input type='text' name='nome' value='".$nome."' size='50' id='form1' disabled='disabled'/>";
			}	
			else
				print "<input type='text' name='nome' value='".$paziente->getName()."' size='50' id='form1'/>";	
			?>	
			</td>	
		</tr>
		<tr>
			<td width="30%" align="right" id='font3'>Date of birth &nbsp;</td>
			<td width="70%" align="left">
			<?php
			$data_nascita = $paziente->getBirthday();
			if ($permission == 3)
			{
				$data_nascita = "************";
				print "<input type='text' name='data_nascita' value='".$data_nascita."' size='50' id='form1' disabled='disabled'/>";
			}						
			else
				if ($errore_data_nascita1 == 1)
				{
					$data_nascita = NULL;
					print "<input type='text' name='data_nascita' value='".$data_nascita."' size='50' id='form1_A'/>";
				}
				else
				{
					print "<input type='text' name='data_nascita' value='".$data_nascita."' size='50' id='form1'/>";	
				}
			?>	
			</td>	
		</tr>
		<tr>
			<td width="30%" align="right" id='font3'>Sex &nbsp;</td>
			<td width="70%" align="left">
			<?php
			if ($permission == 3)
			{	
				if ($paziente->getSex() == 'M')
				{	
					print ("<font id='font3'>M </font> <input type='radio' value='M' name='sex' checked='checked' disabled='disabled'/> &nbsp;");	
					print ("<font id='font3'>F </font> <input type='radio' value='F' name='sex' disabled='disabled'/> &nbsp;");	
				}
				if ($paziente->getSex() == 'F')
				{	
					print ("<font id='font3'>M </font> <input type='radio' value='M' name='sex' disabled='disabled'/> &nbsp;");	
					print ("<font id='font3'>F </font> <input type='radio' value='F' name='sex'checked='checked'  disabled='disabled'/> &nbsp;");	
				}
			}
			else
			{	
				if ($paziente->getSex() == 'M')
				{	
					print ("<font id='font3'>M </font> <input type='radio' value='M' name='sex' checked='checked' /> &nbsp;");	
					print ("<font id='font3'>F </font> <input type='radio' value='F' name='sex' /> &nbsp;");	
				}
				if ($paziente->getSex() == 'F')
				{	
					print ("<font id='font3'>M </font> <input type='radio' value='M' name='sex' /> &nbsp;");	
					print ("<font id='font3'>F </font> <input type='radio' value='F' name='sex'checked='checked'  /> &nbsp;");	
				}
			}
			?>	
			</td>	
		</tr>
		<tr>
			<td width="30%" align="right" id='font3'>Address &nbsp;</td>
			<td width="70%" align="left">
			<?php
			if ($permission == 3)
			{
				$indirizzo = $paziente->getAddress();
				$indirizzo  = "******************************";
				print "<input type='text' name='indirizzo' value='".$indirizzo."' size='50' id='form1' disabled='disabled'/>";
			}					
			else
				print "<input type='text' name='indirizzo' value='".$paziente->getAddress()."' size='50' id='form1'/>";	
			?>	
			</td>	
		</tr>
		<tr>
			<td width="30%" align="right" id='font3'>Telephone &nbsp;</td>
			<td width="70%" align="left">
			<?php
			if ($permission == 3)
			{
				$telefono = $paziente->getTelephone();
				$telefono  = "******************************";
				print "<input type='text' name='telefono' value='".$telefono."' size='50' id='form1' disabled='disabled'/>";
			}	
			else
				print "<input type='text' name='telefono' value='".$paziente->getTelephone()."' size='50' id='form1'/>";	
			?>	
			</td>	
		</tr>
		<tr>
			<td width="30%" align="right" id='font3'>Department &nbsp;</td>
			<td width="70%" align="left">
			<?php
			if ($paziente->getReparto_provenienza() == 'pronto_soccorso')
				$reparto = 'pronto soccorso';
			else
				$reparto = $paziente->getReparto_provenienza();
			
			if ($permission == 3)
				print "<input type='text' name='reparto_provenienza' value='".strtoupper($reparto)."' size='50' id='form1' disabled='disabled'/>";
			else
				print "<input type='text' name='reparto_provenienza' value='".strtoupper($reparto)."' size='50' id='form1'/>";	
			?>	
			</td>	
		</tr>
		<tr>
			<td width="30%" align="right" id='font3' valign="top">Note &nbsp;</td>
			<td width="70%" align="left">
			<?php
			if ($permission == 3)
				print "<textarea id='form1' cols='39' rows='3' name='note_paziente' disabled='disabled'>".$paziente->getNote()."</textarea>";
			else
				print "<textarea id='form1' cols='39' rows='3' name='note_paziente'>".$paziente->getNote()."</textarea>";		
			?>	
			</td>	
		</tr>
		<tr>
			<td width="30%" align="right" id='font3' valign="top"><br /></td>
			<td width="70%" align="left">
			<br /></td>	
		</tr>		
		<tr>
			<td width="30%" align="right" id='font3' valign="top"><font color="#D6F37E" size='3'>Date of death &nbsp; </font></td>
			<td width="70%" align="left">
			<?php
				$data_decesso=data_convert_for_utente($paziente->getdata_decesso());
				if ($data_decesso == '//')
					$data_decesso = NULL;
			
				if ($permission == 3)
					print "<input type='text' name='data_decesso' value='".$data_decesso."' size='50' id='form1' disabled='disabled'/>";
				else
				{
					if ($errore_data_decesso1 == 1)
					{
						$data_decesso = NULL;
						print "<input type='text' name='data_decesso' value='".$data_decesso."' size='50' id='form1_A'/>";	
					}
					else
					{
						print "<input type='text' name='data_decesso' value='".$data_decesso."' size='50' id='form1'/>";		
					}
				}
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
			 </td>
		</tr>
		</table>
	<?php
	}
	?>
	<input type="hidden" name='id_paziente' value='<?php print $id_paziente; ?>' />
	</form>	

<br /><br />
<input type="button" onclick="javascript:window.close();" value='CLOSE' id='form2_3'/>
<br />
</div>
</body>
</html>