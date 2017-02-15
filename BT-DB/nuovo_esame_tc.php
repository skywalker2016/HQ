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

if ($_REQUEST['inserisci'] != NULL) // Inserisce i dati nel database:
{
	// recupera tutti i dati dalle sessioni:
	$id_paziente = $_SESSION['id_paziente'];
	$data_inserimento_esame_tc = $_SESSION['data_inserimento_esame_tc'];
	$extrassiale = $_SESSION['extrassiale'];
	$intrassiale = $_SESSION['intrassiale'];
	$dubbia = $_SESSION['dubbia'];
	$contrasto = $_SESSION['contrasto'];
	$tipo_contrasto = $_SESSION['tipo_contrasto'];
	$sede = $_SESSION['sede'];
	
	$esame_tc = new esame_tc($id_paziente, $extrassiale, $intrassiale, $dubbia, $contrasto, $tipo_contrasto, $sede);
	
	$errore_data_inserimento_esame_tc = controllo_data($data_inserimento_esame_tc);
	if ($errore_data_inserimento_esame_tc == 1);
	else
	{
		$data_inserimento_esame_tc1=data_convert_for_mysql($data_inserimento_esame_tc);
		$esame_tc -> setData_inserimento($data_inserimento_esame_tc1);
		$esame_tc->insert();
		
		$pagina = 15;
		include ("log.php");
		
		if ($error != 1)
			$ok_inserimento = 1;
	}
} 
else
{
	if ($_REQUEST['start'] == 1)
	{
		$id_paziente =$_REQUEST['id_paziente'];
		$_SESSION['id_paziente'] = $id_paziente;
		
		// Libera tutte le sessioni:
		$_SESSION['data_inserimento_esame_tc'] = NULL;
		$_SESSION['extrassiale'] = NULL;
		$_SESSION['intrassiale'] = NULL;
		$_SESSION['dubbia'] = NULL;	
		$_SESSION['contrasto'] = NULL;		
		$_SESSION['tipo_contrasto'] = NULL;		
		$_SESSION['sede'] = NULL;	
		
		// recupera tutti i dati dalle sessioni:
		$data_inserimento_esame_tc = $_SESSION['data_inserimento_esame_tc'];
		$extrassiale = $_SESSION['extrassiale'];
		$intrassiale = $_SESSION['intrassiale'];
		$dubbia = $_SESSION['dubbia'];
		$contrasto = $_SESSION['contrasto'];
		$tipo_contrasto = $_SESSION['tipo_contrasto'];
		$sede = $_SESSION['sede'];		
	} 
	else  
	{
		$id_paziente = $_SESSION['id_paziente'];
	
		// DATA INSERIMENTO ESAME TC ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		if ($_REQUEST['data_inserimento_esame_tc'])
				$_SESSION['data_inserimento_esame_tc'] = $_REQUEST['data_inserimento_esame_tc'];	
			else;
			$data_inserimento_esame_tc = $_SESSION['data_inserimento_esame_tc'];
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

	var destination_page = "nuovo_esame_tc.php";
	location.href = destination_page+"?data_inserimento_esame_tc="+data;	
}

function sede1_function(link)
{
	var sede_name=link[link.selectedIndex].value;

	var destination_page = "nuovo_esame_tc.php";
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
<font face="Verdana, Arial, Helvetica, sans-serif" color="#FFFFCC" size='2'>
The data will be inserted in the database only when you see the confirm and when you see the tab 'CLOSE'</font>
<br />
<br /><br />
<font id="font2">
TC scan</font>
<br /><br />
<form action="nuovo_esame_tc.php" method="post" name='esame'>
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
		<td width="39%" align="right" id='font3'>Date &nbsp;</td>
		<td width="61%" align="left">		
		<?php
		if ($errore_data_inserimento_esame_tc == 1)
			print ("<input type='text' name='data_inserimento_esame_tc' value='$data_inserimento_esame_tc' size='15' id='form1_A' onchange=\"data_inserimento()\" />");
		else
			if ($ok_inserimento == 1)
				print ("<font face='Verdana, Arial, Helvetica, sans-serif' size='3' color='#2ECCFA'>$data_inserimento_esame_tc</font>");
			else
			   print ("<input type='text' name='data_inserimento_esame_tc' value='$data_inserimento_esame_tc' size='15' id='form1' onchange=\"data_inserimento()\" />");
		?>
		<font id='font4'>(dd/mm/yyyy)</font>	
		</td>	
	</tr>
</table>	

<table border="0" width="63%" cellpadding="0" cellspacing="4">	
	<tr>
		<td width="35%" align="right" id='font3'>Extra axial &nbsp;</td>
		<td width="25%" align="left" id='form1'> 
			<?php
			if ($ok_inserimento == 1)
			{
				if ($extrassiale == 'on')
					print ("<font id='font20'>Yes </font>");		
			}	
			else
			{
				if ($extrassiale == 'on')
					print "<input type='checkbox' name='extrassiale' checked='checked' onClick=\"javascript:location.href='nuovo_esame_tc.php?extrassiale=off'\"/>  ";
				else
					print "<input type='checkbox' name='extrassiale' onClick=\"javascript:location.href='nuovo_esame_tc.php?extrassiale=on'\"/>  ";				
			}
			?>
		</td>
		<td width="30%" align="left"></td>	
	</tr>
	<tr>
		<td width="35%" align="right" id='font3'>Intra axial &nbsp;</td>
		<td width="25%" align="left" id='form1'> 
			<?php
			if ($ok_inserimento == 1)
			{
				if ($intrassiale == 'on')
					print ("<font id='font20'>Yes </font>");				
			}	
			else
			{
				if ($intrassiale == 'on')
					print "<input type='checkbox' name='intrassiale' checked='checked' onClick=\"javascript:location.href='nuovo_esame_tc.php?intrassiale=off'\"/>  ";
				else
					print "<input type='checkbox' name='intrassiale' onClick=\"javascript:location.href='nuovo_esame_tc.php?intrassiale=on'\"/>  ";					
			}	
			?>	
		</td>
		<td width="30%" align="left"></td>	
	</tr>
	<tr>
		<td width="35%" align="right" id='font3'>Doubtful &nbsp;</td>
		<td width="25%" align="left" id='form1'> 
			<?php
			if ($ok_inserimento == 1)
			{
				if ($dubbia == 'on')
					print ("<font id='font20'>Yes </font>");					
			}	
			else
			{
				if ($dubbia == 'on')
					print "<input type='checkbox' name='dubbia' checked='checked' onClick=\"javascript:location.href='nuovo_esame_tc.php?dubbia=off'\"/>  ";
				else
					print "<input type='checkbox' name='dubbia' onClick=\"javascript:location.href='nuovo_esame_tc.php?dubbia=on'\"/>  ";						
			}				
			?>
		</td>
		<td width="30%" align="left"></td>	
	</tr>
	<tr>
		<td width="35%" align="right" id='font3'>Contrast Enhancement &nbsp;</td>
		<td width="25%" align="left" id='form1'> 
			<?php
			if ($ok_inserimento == 1)
			{
				if ($contrasto == 'on')
					print ("<font id='font20'>Yes </font>");						
			}	
			else
			{
				if ($contrasto == 'on')
					print "<input type='checkbox' name='contrasto' checked='checked' onClick=\"javascript:location.href='nuovo_esame_tc.php?contrasto=off'\"/>  ";
				else
					print "<input type='checkbox' name='contrasto' onClick=\"javascript:location.href='nuovo_esame_tc.php?contrasto=on'\"/>  ";							
			}			
			?>
		</td>
		<td width="30%" align="left"></td>	
	</tr>
</table>

	<?php 
	if ($contrasto == "on")
	{
	?>
		<table border="0" width="65%" cellpadding="0" cellspacing="4">		
			<tr>
				<td width="39%" align="right" id='font3'></td>
				<td width='51%' align='left' id='form1_B'>
				<?php
					if ($ok_inserimento == 1)
					{
						if ($tipo_contrasto == 'omogeneo')	
							$tipo_contrasto1 = 'Homogeneous';
						if ($tipo_contrasto == 'disomogeneo')	
							$tipo_contrasto1 = 'Inhomogeneous';					
						if ($tipo_contrasto == 'ad_anello')	
							$tipo_contrasto1 = 'Ring';					
					
					
						print ("<font face='Verdana, Arial, Helvetica, sans-serif' color='black' size='2'>$tipo_contrasto1</font>");
					}	
					else
					{
						if ($tipo_contrasto == 'omogeneo')
						{
							print ("<input type='radio' name='tipo_contrasto' value='omogeneo' checked='checked' onClick=\"javascript:location.href='nuovo_esame_tc.php?tipo_contrasto=omogeneo'\" /><font id='font9_A'>Homogeneous</font> &nbsp;");
							print ("<input type='radio' name='tipo_contrasto' value='disomogeneo' onClick=\"javascript:location.href='nuovo_esame_tc.php?tipo_contrasto=disomogeneo' \"/><font id='font9_A'>Inhomogeneous</font> &nbsp;");			
							print (" <input type='radio' name='tipo_contrasto' value='ad_anello' onClick=\"javascript:location.href='nuovo_esame_tc.php?tipo_contrasto=ad_anello' \"/><font id='font9_A'>Ring</font>");
						}
						else if ($tipo_contrasto == 'disomogeneo')
						{
							print ("<input type='radio' name='tipo_contrasto' value='omogeneo' onClick=\"javascript:location.href='nuovo_esame_tc.php?tipo_contrasto=omogeneo'\" /><font id='font9_A'>Homogeneous</font> &nbsp;");
							print ("<input type='radio' name='tipo_contrasto' value='disomogeneo' onClick=\"javascript:location.href='nuovo_esame_tc.php?tipo_contrasto=disomogeneo'\"  checked='checked' /><font id='font9_A'>Inhomogeneous</font> &nbsp;");
							print (" <input type='radio' name='tipo_contrasto' value='ad_anello' onClick=\"javascript:location.href='nuovo_esame_tc.php?tipo_contrasto=ad_anello'\" /><font id='font9_A'>Ring</font>");
						}		
						else if ($tipo_contrasto == 'ad_anello')
						{
							print ("<input type='radio' name='tipo_contrasto' value='omogeneo' onClick=\"javascript:location.href='nuovo_esame_tc.php?tipo_contrasto=omogeneo'\" /><font id='font9_A'>Homogeneous</font> &nbsp;");
							print ("<input type='radio' name='tipo_contrasto' value='disomogeneo' onClick=\"javascript:location.href='nuovo_esame_tc.php?tipo_contrasto=disomogeneo'\" /><font id='font9_A'>Inhomogeneous</font> &nbsp;");
							print (" <input type='radio' name='tipo_contrasto' value='ad_anello' onClick=\"javascript:location.href='nuovo_esame_tc.php?tipo_contrasto=ad_anello'\"  checked='checked'/><font id='font9_A'>Ring</font>");
						}		
						else
						{
							print ("<input type='radio' name='tipo_contrasto' value='omogeneo' onClick=\"javascript:location.href='nuovo_esame_tc.php?tipo_contrasto=omogeneo'\"/><font id='font9_A'>Homogeneous</font> &nbsp;");
							print ("<input type='radio' name='tipo_contrasto' value='disomogeneo' onClick=\"javascript:location.href='nuovo_esame_tc.php?tipo_contrasto=disomogeneo'\" /><font id='font9_A'>Inhomogeneous</font> &nbsp;");
							print (" <input type='radio' name='tipo_contrasto' value='ad_anello' onClick=\"javascript:location.href='nuovo_esame_tc.php?tipo_contrasto=ad_anello'\" /><font id='font9_A'>Ring</font>");
						}		
						
					}	
					?>
				</td>
				<td width="10%" align="right" id='font3'></td>
			</tr>	
		</table>
	<?php
	}
	?>

<table border="0" width="63%" cellpadding="0" cellspacing="4">	
	<tr>
		<td width="35%" align="right" id='font3'>Site &nbsp;</td>
		<td width="25%" align="left" id='form1'> 
		<?php
		if ($ok_inserimento == 1)
				print ("<font face='Verdana, Arial, Helvetica, sans-serif' color='black' size='2'>$sede</font>");
			else
			{   
				// Retrive the data from table SEDE:
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
if ($ok_inserimento == 1)
{	
	print ("<font id='font4_N'>The data have been inserted in the database</font><br><br>");
	print ("<input type='button' onclick=\"javascript:window.close();\" value='CLOSE' id='form2_3'/><br />");
}	
else
{
?>
	<table border="0" width="65%">
	<tr>
		<td width="70%" align="center"><hr width="96%" /></td>
		<td width="30%" align="center"><input type='submit' name="inserisci" value='INSERT' id='form2'/>
		</td>
	</tr>
	</table>
<?php
}
?>
</form>
	
<br />
<?php 
	if ($errore_data_inserimento_esame_tc == 1)
		print ("<font id='font4_N'>Please check the date format</font><br>");
		
	if ($error == 1)
	{
		print ("<font id='font4_N'>There was an error. The data are not inserted in the database<br>
				Contact the administrator.</font><br>");			
	}
	
?>
<br />
</div>
</body>
</html>