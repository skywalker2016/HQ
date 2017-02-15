<?php
session_start();
include ("accesso_db.php");

if ($permission == NULL)
	header("Location:errore.html");
	
include ("convertitore_date.php");
include ("function_php/try_format_date.php");
require_once('class/class.patient.php');
require_once('class/class.esame_tc.php');
require_once('class/class.dataExamInsert.php');


// **************** AGGIORNA I DATI DEL PAZIENTE ***********************************************
// *********************************************************************************************
if  ($_REQUEST['aggiorna']) 
{
	// controlla il formato della data:
	$data_inserimento_esame_tc = $_SESSION['data_inserimento_esame_tc'];
	
	$esame_tc = new esame_tc(NULL, NULL, NULL, NULL, NULL, NULL, NULL);
	$errore_data_inserimento_esame_tc = controllo_data($data_inserimento_esame_tc);
	
	$id_esame_tc = $_SESSION['id_esame_tc'];	

	if ($_REQUEST['contrasto'] == NULL)
		$tipo_contrasto = NULL;
	else
		$tipo_contrasto = $_REQUEST['tipo_contrasto'];

	if ($errore_data_inserimento_esame_tc == 1)
		$error = 1;
	else
	{	
		// Aggiornamento della tabella esame_tc
		$query= "UPDATE esame_tc SET
			extrassiale ='".$_REQUEST['extrassiale']."',
			intrassiale = '".$_REQUEST['intrassiale']."',
			dubbia ='".$_REQUEST['dubbia']."',
			contrasto ='".$_REQUEST['contrasto']."',
			tipo_contrasto ='".$tipo_contrasto."',
			sede ='".$_REQUEST['sede']."',
			data_inserimento ='".data_convert_for_mysql($_REQUEST['data_inserimento_esame_tc'])."'
			WHERE id = '$id_esame_tc' ";
		 $rs1 = mysql_query($query);	
		 
		 $pagina = 14;
		 include ("log.php");
		 
		if ($rs1 != 1)
			$error = 1;
		else
			$error = 2;	
		}	
}
// *********************************************************************************************
// *********************************************************************************************

if ($_REQUEST['start'] == 1)
{

	$id_paziente = $_REQUEST['id_paziente'];
	$_SESSION['id_paziente'] = $id_paziente;
	$id_esame_tc = $_REQUEST['id_esame_tc'];
	$_SESSION['id_esame_tc'] = $id_esame_tc;	
		
	$paziente = new patient($id_paziente, NULL, NULL);
	$paziente -> retrive_by_ID($id_paziente);	

	$esame_tc = new esame_tc($id_paziente, NULL, NULL, NULL, NULL, NULL, NULL);
	$esame_tc -> retrive_by_id($id_esame_tc);
	
	$data_inserimento_esame_tc = data_convert_for_utente($esame_tc->getData_inserimento());

	$cognome = $paziente->getSurname();
	$_SESSION['cognome'] = $cognome;
	$nome = $paziente->getName();	
	$_SESSION['nome'] = $nome;
	
	$extrassiale = $esame_tc->getExtrassiale();
	$_SESSION['extrassiale'] = $extrassiale;
	$intrassiale = $esame_tc->getIntrassiale();
	$_SESSION['intrassiale'] = $intrassiale;
	$dubbia= $esame_tc->getDubbia();
	$_SESSION['dubbia'] = $dubbia;
	$contrasto= $esame_tc->getContrasto();
	$_SESSION['contrasto'] = $contrasto;	
	$tipo_contrasto = $esame_tc->getTipo_contrasto();
	$_SESSION['tipo_contrasto'] = $tipo_contrasto;	
	$sede = $esame_tc->getSede();
	$_SESSION['sede'] = $sede;		
}
else
{
		$id_paziente = $_SESSION['id_paziente'];
		$id_esame_tc = $_SESSION['id_esame_tc'];	

		$esame_tc = new esame_tc($id_paziente, NULL, NULL, NULL, NULL, NULL, NULL);
		$esame_tc -> retrive_by_id($id_esame_tc);
		$data_inserimento_esame_tc = data_convert_for_utente($esame_tc->getData_inserimento());	
	
		// DATA INSERIMENTO ESAME TC ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		if ($_REQUEST['data_inserimento_esame_tc'])
				$_SESSION['data_inserimento_esame_tc'] = $_REQUEST['data_inserimento_esame_tc'];	
			else;
			//$data_inserimento_esame_tc = $_SESSION['data_inserimento_esame_tc'];
		// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
				
		// EXTRASSIALE ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		if ($_REQUEST['extrassiale'])
				$_SESSION['extrassiale'] = $_REQUEST['extrassiale'];	
		else;
		$extrassiale = $_SESSION['extrassiale'];
		// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		
		// INTRASSIALE ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		if ($_REQUEST['intrassiale'])
				$_SESSION['intrassiale'] = $_REQUEST['intrassiale'];	
			else;
			$intrassiale = $_SESSION['intrassiale'];
		// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
		// DUBBIA ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		if ($_REQUEST['dubbia'])
				$_SESSION['dubbia'] = $_REQUEST['dubbia'];	
			else;
			$dubbia = $_SESSION['dubbia'];
		// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
		// CONTRASTO ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		if ($_REQUEST['contrasto'])
				$_SESSION['contrasto'] = $_REQUEST['contrasto'];	
			else;
			$contrasto = $_SESSION['contrasto'];
			
				// tipo contrasto -------------------------------------------
				if ($contrasto == 'off')
					$_SESSION['tipo_contrasto'] = NULL;	
				
				if ($_REQUEST['tipo_contrasto'])
					$_SESSION['tipo_contrasto'] = $_REQUEST['tipo_contrasto'];
				else;
				$tipo_contrasto = $_SESSION['tipo_contrasto'];	
				// -----------------------------------------------------------
			
		// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
		// SEDE +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			if ($_REQUEST['sede'])
				$_SESSION['sede'] = $_REQUEST['sede'];
			else;
			$sede = $_SESSION['sede'];
		
			if ($sede == '-')
				$_SESSION['sede'] = NULL;	
		// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
}

$paziente = new patient($id_paziente, NULL, NULL);
$paziente -> retrive_by_ID($id_paziente);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<script type="text/javascript">
// Javascript function *****************************************************************************************************
function data_inserimento()
{
	var data = document.esame.data_inserimento_esame_tc.value;

	var destination_page = "query_esame_tc.php";
	location.href = destination_page+"?data_inserimento_esame_tc="+data;	
}

function sede1_function(link)
{
	var sede_name=link[link.selectedIndex].value;

	var destination_page = "query_esame_tc.php";
	location.href = destination_page+"?sede="+sede_name;

}
</script>

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
TC scan</font>
<br /><br />
<form action="query_esame_tc.php" method="post" name='esame'>
<?php

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
<font face="Verdana, Arial, Helvetica, sans-serif" color="#FFFFCC" size='2'>The data will be inserted in the database only when you see the confirm and when you see the tab 'CLOSE'</font>
<br />
<br /><br />
<table border="0" width="53%" cellpadding="0" cellspacing="0">
	<tr>
		<td width="39%" align="right" id='font3'>Date &nbsp;</td>
		<td width="61%" align="left">
		<?php
		if ($permission == 3)
			print "<input type='text' name='data_inserimento_esame_tc' value='$data_inserimento_esame_tc' size='15' id='form1' disabled='disabled'/>";
		else
			if ($error == 1)
				print "<input type='text' name='data_inserimento_esame_tc' value='$data_inserimento_esame_tc' size='15' id='form1_A' onchange=\"data_inserimento()\"/>";
			else
				print "<input type='text' name='data_inserimento_esame_tc' value='$data_inserimento_esame_tc' size='15' id='form1' onchange=\"data_inserimento()\"/>";	
		?>	
		</td>	
	</tr>
</table>	

<table border="0" width="65%" cellpadding="0" cellspacing="4">	
	<tr>
		<td width="35%" align="right" id='font3'>Extra axial &nbsp;</td>
		<td width="25%" align="left" id='form1'> 
			<?php
			if ($permission == 3)
			{
				if ($extrassiale == 'on')
					print "<input type='checkbox' name='extrassiale' checked='checked' disabled='disabled'/>  ";
				else
					print "<input type='checkbox' name='extrassiale' disabled='disabled'/>  ";			
			}
			else
			{
				if ($extrassiale == 'on')
					print "<input type='checkbox' name='extrassiale' checked='checked' onClick=\"javascript:location.href='query_esame_tc.php?extrassiale=off'\"/>  ";
				else
					print "<input type='checkbox' name='extrassiale' onClick=\"javascript:location.href='query_esame_tc.php?extrassiale=on'\"/>  ";			
			}		
			?>
		</td>
		<td width="30%" align="left"></td>	
	</tr>
	<tr>
		<td width="35%" align="right" id='font3'>Intra axial &nbsp;</td>
		<td width="25%" align="left" id='form1'> 
			<?php
			if ($permission == 3)
			{
				if ($intrassiale  == 'on')
					print "<input type='checkbox' name='intrassiale' checked='checked' disabled='disabled'/>  ";
				else
					print "<input type='checkbox' name='intrassiale' disabled='disabled'/>  ";			
			}
			else
			{
				if ($intrassiale  == 'on')
					print "<input type='checkbox' name='intrassiale' checked='checked' onClick=\"javascript:location.href='query_esame_tc.php?intrassiale=off'\"/>  ";
				else
					print "<input type='checkbox' name='intrassiale' onClick=\"javascript:location.href='query_esame_tc.php?intrassiale=on'\"/>  ";			
			}		
			?>
		</td>
		<td width="30%" align="left"></td>	
	</tr>
	<tr>
		<td width="35%" align="right" id='font3'>Doubtful&nbsp;</td>
		<td width="25%" align="left" id='form1'> 
			<?php
			if ($permission == 3)
			{
				if ($dubbia == 'on')
					print "<input type='checkbox' name='dubbia' checked='checked' disabled='disabled'/>  ";
				else
					print "<input type='checkbox' name='dubbia' disabled='disabled'/>  ";			
			}
			else
			{
				if ($dubbia == 'on')
					print "<input type='checkbox' name='dubbia' checked='checked' onClick=\"javascript:location.href='query_esame_tc.php?dubbia=off'\"/>  ";
				else
					print "<input type='checkbox' name='dubbia' onClick=\"javascript:location.href='query_esame_tc.php?dubbia=on'\"/>  ";			
			}		
			?>
		</td>
		<td width="30%" align="left"></td>	
	</tr>
	<tr>
		<td width="35%" align="right" id='font3'>Contrast Enhancement &nbsp;</td>
		<td width="25%" align="left" id='form1'> 
			<?php
			if ($permission == 3)
			{
				if ($contrasto == 'on')
					print "<input type='checkbox' name='contrasto' checked='checked' disabled='disabled' />";
				else
					print "<input type='checkbox' name='contrasto' disabled='disabled' />  ";			
			}
			else
			{
				if ($contrasto == 'on')
					print "<input type='checkbox' name='contrasto' checked='checked' onClick=\"javascript:location.href='query_esame_tc.php?contrasto=off'\"/>  ";
				else
					print "<input type='checkbox' name='contrasto' onClick=\"javascript:location.href='query_esame_tc.php?contrasto=on'\"/>  ";			
			}		
			?>
		</td>
		<td width="30%" align="left"></td>	
	</tr>
</table>
<?php
// IF PER LA VISUALIZZAZIONE DEL TIPO DI CONTRASTO *********************************************************************************************************
if ($contrasto == 'on')
{
?>	
	<table border="0" width="65%" cellpadding="0" cellspacing="4">		

		<tr>
			<td width="39%" align="right" id='font3'></td>
			<td width="51%" align="left" id='form1_B'> 
				<?php
				
				
				if ($permission == 3)
				{
					print ("$tipo_contrasto");
				}
				else
				{
				
					if ($tipo_contrasto == 'omogeneo')
					{
						print ("<input type='radio' name='tipo_contrasto' value='omogeneo' checked='checked' onClick=\"javascript:location.href='query_esame_tc.php?tipo_contrasto=omogeneo'\" /><font id='font9_A'>Homogeneous</font> &nbsp;");
						print ("<input type='radio' name='tipo_contrasto' value='disomogeneo' onClick=\"javascript:location.href='query_esame_tc.php?tipo_contrasto=disomogeneo' \"/><font id='font9_A'>Inhomogeneous</font> &nbsp;");			
						print (" <input type='radio' name='tipo_contrasto' value='ad_anello' onClick=\"javascript:location.href='query_esame_tc.php?tipo_contrasto=ad_anello' \"/><font id='font9_A'>Ring</font>");
					}
					else if ($tipo_contrasto == 'disomogeneo')
					{
						print ("<input type='radio' name='tipo_contrasto' value='omogeneo' onClick=\"javascript:location.href='query_esame_tc.php?tipo_contrasto=omogeneo'\" /><font id='font9_A'>Homogeneous</font> &nbsp;");
						print ("<input type='radio' name='tipo_contrasto' value='disomogeneo' onClick=\"javascript:location.href='query_esame_tc.php?tipo_contrasto=disomogeneo'\"  checked='checked' /><font id='font9_A'>Inhomogeneous</font> &nbsp;");
						print (" <input type='radio' name='tipo_contrasto' value='ad_anello' onClick=\"javascript:location.href='query_esame_tc.php?tipo_contrasto=ad_anello'\" /><font id='font9_A'>Ring</font>");
					}		
					else if ($tipo_contrasto == 'ad_anello')
					{
						print ("<input type='radio' name='tipo_contrasto' value='omogeneo' onClick=\"javascript:location.href='query_esame_tc.php?tipo_contrasto=omogeneo'\" /><font id='font9_A'>Homogeneous</font> &nbsp;");
						print ("<input type='radio' name='tipo_contrasto' value='disomogeneo' onClick=\"javascript:location.href='query_esame_tc.php?tipo_contrasto=disomogeneo'\" /><font id='font9_A'>Inhomogeneous</font> &nbsp;");
						print (" <input type='radio' name='tipo_contrasto' value='ad_anello' onClick=\"javascript:location.href='query_esame_tc.php?tipo_contrasto=ad_anello'\"  checked='checked'/><font id='font9_A'>Ring</font>");
					}		
					else
					{
						print ("<input type='radio' name='tipo_contrasto' value='omogeneo' onClick=\"javascript:location.href='query_esame_tc.php?tipo_contrasto=omogeneo'\"/><font id='font9_A'>Homogeneous</font> &nbsp;");
						print ("<input type='radio' name='tipo_contrasto' value='disomogeneo' onClick=\"javascript:location.href='query_esame_tc.php?tipo_contrasto=disomogeneo'\" /><font id='font9_A'>Inhomogeneous</font> &nbsp;");
						print (" <input type='radio' name='tipo_contrasto' value='ad_anello' onClick=\"javascript:location.href='query_esame_tc.php?tipo_contrasto=ad_anello'\" /><font id='font9_A'>Ring</font>");
					}
				
				}
				?>
			</td>
			<td width="10%" align="right" id='font3'></td>
		</tr>	
	</table>
<?php
}
// FINE IF PER LA VISUALIZZAZIONE DEL TIPO DI CONTRASTO *****************************************************************************************************
?>

<table border="0" width="65%" cellpadding="0" cellspacing="4">	
	<tr>
		<td width="35%" align="right" id='font3'>Site &nbsp;</td>
		<td width="25%" align="left" id='form1'> 
			<?php
			if ($permission == 3)
			{
				print ("$sede");
			}
			else
			{
				print ("<select name='sede' size='1' cols='10' onChange=\"sede1_function(this)\">");
				if ($sede != NULL)
					print ("<OPTION VALUE=\"$sede\">$sede</OPTION>");
				
				print ("<OPTION VALUE=\"-\">-</OPTION>");
				$query = "SELECT id, sede FROM sede ORDER BY id ASC ";
				$rs = mysql_query($query);
				while(list($id, $sede_name) = mysql_fetch_row($rs))
				{
					if ($sede_name == $sede);
					else
						print ("<OPTION VALUE=\"$sede_name\">$sede_name</OPTION>");
		
				}	
				print ("</select>");		
			}		
			?>
		</td>
		<td width="30%" align="left"></td>	
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
		<input type="hidden" name='id_esame_tc' value='<?php print $id_esame_tc; ?>' />
		 </td>
	</tr>
	</table>
<?php
}
?>
</form>
	
<br />
<?php 
	if ($error == 1)
		print ("<font id='font4_N'>Please check the date format</font><br>");
	if ($error == 2)
	{
		print ("<font id='font4_N'>The data have been inserted in the database</font><br>");
		print ("<br /><input type='button' onclick=\"javascript:window.close();\" value='CLOSE' id='form2_3'/><br />");
	}
	else;		
?>

</div>
</body>
</html>