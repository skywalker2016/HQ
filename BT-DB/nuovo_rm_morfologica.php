<?php
session_start();
include ("accesso_db.php");

if ($permission == NULL)
	header("Location:errore.html");
	
include ("convertitore_date.php");
include ("function_php/try_format_date.php");
require_once('class/class.patient.php');
require_once('class/class.rm_morfologica.php');
require_once('class/class.dataExamInsert.php');

// Funzione che libera tutte le sessioni: -----------------------------------------------------
function delete_session()
{
	$_SESSION['data_inserimento_rm_morfologica'] = NULL;
	$_SESSION['extrassiale_rm'] = NULL;
	$_SESSION['intrassiale_rm'] = NULL;
	$_SESSION['t2_flair'] = NULL;
	$_SESSION['flair_3d'] = NULL;
	$_SESSION['calcolo_volume_neo'] = NULL;
	$_SESSION['dwi'] = NULL;
	$_SESSION['dwi_ristretta'] = NULL;
	$_SESSION['adc'] = NULL;
	$_SESSION['valore_adc'] = NULL;			
	$_SESSION['tipo_adc'] = NULL;	
	$_SESSION['ce'] = NULL;
	$_SESSION['tipo_ce'] = NULL;
	$_SESSION['flag_aggiorna'] = NULL;
}
// --------------------------------------------------------------------------------------------

// Funzione che recupera i dati dalle sessioni: -----------------------------------------------------
function recupero_session()
{

	global $data_inserimento_rm_morfologica;
	global $extrassiale_rm;
	global $intrassiale_rm;
	global $t2_flair;
	global $flair_3d;
	global $calcolo_volume_neo;
	global $dwi;
	global $dwi_ristretta;
	global $adc;
	global $tipo_adc;
	global $valore_adc;
	global $ce;
	global $tipo_ce;
	global $flag_aggiorna;

	$data_inserimento_rm_morfologica = $_SESSION['data_inserimento_rm_morfologica'];
	$extrassiale_rm = $_SESSION['extrassiale_rm'];	
	$intrassiale_rm = $_SESSION['intrassiale_rm'];	
	$t2_flair = $_SESSION['t2_flair'];	
	$flair_3d = $_SESSION['flair_3d'];
	$calcolo_volume_neo = $_SESSION['calcolo_volume_neo'];
	$dwi = $_SESSION['dwi'];
	$dwi_ristretta = $_SESSION['dwi_ristretta'];
	$adc = $_SESSION['adc'];
	$tipo_adc = $_SESSION['tipo_adc'];
	$valore_adc = $_SESSION['valore_adc'];
	$ce = $_SESSION['ce'];
	$tipo_ce = $_SESSION['tipo_ce'];
	$flag_aggiorna = $_SESSION['flag_aggiorna'];
}
// --------------------------------------------------------------------------------------------

$flag_query = $_REQUEST['flag_query']; // Se la variabile $query=1 vuol dire che la agina � query_rm_morfologica.
// RECUPERA I DATI DALLA TABELLA RM_FUNZIONALE PER VISUALIZZARLI NELLA PAGINA ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
if ($flag_query == 1)
{
	// Libera tutte le sessioni:
	delete_session();

	$id_paziente = $_REQUEST['id_paziente'];
	$id_rm_morfologica = $_REQUEST['id_rm_morfologica'];
	$_SESSION['id_paziente'] = $id_paziente;
	$_SESSION['id_rm_morfologica'] = $id_rm_morfologica ;	

	// recupera i dati dal database:
	$rm = new rm_morfologica ($id_paziente, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
	$rm -> retrive_by_id($id_rm_morfologica);
	$data_inserimento_rm_morfologica = $rm -> getData_inserimento();
	$data_inserimento_rm_morfologica = data_convert_for_utente($data_inserimento_rm_morfologica);
	$extrassiale_rm = $rm -> getExtrassiale();
	$intrassiale_rm = $rm -> getIntrassiale();
	$t2_flair = $rm -> getT2_flair();
	$flair_3d = $rm -> getFlair_3d();
	$calcolo_volume_neo = $rm -> getVolume_neo();
	$dwi = $rm -> getDwi();
	$dwi_ristretta = $rm -> getDwi_ristretta();
	$adc = $rm -> getAdc();
	$tipo_adc = $rm -> getAdc_ridotto();
	$valore_adc = $rm -> getValore_adc_ridotto();	
	$ce = $rm -> getCe();	
	$tipo_ce = $rm -> getTipo_ce();		
	
	if ($calcolo_volume_neo == -1000)
		$calcolo_volume_neo = NULL;
	if ($valore_adc == -1000)
		$valore_adc = NULL;	
		
	// registra tutte le sessioni:
	$_SESSION['data_inserimento_rm_morfologica'] = $data_inserimento_rm_morfologica;
	$_SESSION['extrassiale_rm'] = $extrassiale_rm;
	$_SESSION['intrassiale_rm'] = $intrassiale_rm;
	$_SESSION['t2_flair'] = $t2_flair;
	$_SESSION['flair_3d'] = $flair_3d;
	$_SESSION['calcolo_volume_neo'] = $calcolo_volume_neo;
	$_SESSION['dwi'] = $dwi;
	$_SESSION['dwi_ristretta'] = $dwi_ristretta;
	$_SESSION['adc'] = $adc;
	$_SESSION['valore_adc'] = $valore_adc;			
	$_SESSION['tipo_adc'] = $tipo_adc;	
	$_SESSION['ce'] = $ce;
	$_SESSION['tipo_ce'] = $tipo_ce;
	
	$flag_aggiorna =1;
	$_SESSION['flag_aggiorna'] = $flag_aggiorna ;	
}
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


// INSERIMENTO DATI DI UNA NUOVA RM MORFOLOGICA ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
if ($_REQUEST['inserisci'] == 'INSERT') // Inserisce i dati nel database:
{
	$id_paziente = $_SESSION['id_paziente'];
	// recupera tutti i dati dalle sessioni:
	recupero_session();

	$rm_morfologica = new rm_morfologica($id_paziente, $extrassiale_rm, $intrassiale_rm, $t2_flair, $flair_3d, $calcolo_volume_neo, $dwi, $dwi_ristretta, $adc, $tipo_adc, $valore_adc, $ce, $tipo_ce);

	$errore_data_inserimento_rm_morfologica = controllo_data($data_inserimento_rm_morfologica);
	if ($errore_data_inserimento_rm_morfologica == 1);
	else
	{
		$data_inserimento_rm_morfologica1=data_convert_for_mysql($data_inserimento_rm_morfologica);
		$rm_morfologica -> setData_inserimento($data_inserimento_rm_morfologica1);
		$rm_morfologica->insert();
				
		$pagina = 16;
		include ("log.php");
		
		if ($error != 1)
		{
			$ok_inserimento = 1;
		}	
	}
} 
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

// AGGIORNAMENTO DEI DATI ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
if ($_REQUEST['inserisci'] == 'UPDATE') // Aggir�orna i dati nel database:
{
	// RECUPERA I DATI DALLE SESSIONI:	
	recupero_session();
	$id_rm_morfologica = $_SESSION['id_rm_morfologica'] ;

	// controlla la data:
	$rm = new rm_morfologica (NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
	
	$errore_data_inserimento_rm_morfologica = controllo_data($data_inserimento_rm_morfologica);
	
	if ($errore_data_inserimento_rm_morfologica == 1);
	else
	{
		if ($calcolo_volume_neo == NULL)
			$calcolo_volume_neo = -1000;
		if ($valore_adc == NULL)
			$valore_adc = -1000;
		
		$data_inserimento_rm_morfologica=data_convert_for_mysql($data_inserimento_rm_morfologica);

		$query= "UPDATE rm_morfologica SET
				extrassiale = '$extrassiale_rm',
				intrassiale = '$intrassiale_rm',
				t2_flair = '$t2_flair',
				flair_3d = '$flair_3d',
				volume_neo = '$calcolo_volume_neo',
				dwi = '$dwi',
				dwi_ristretta = '$dwi_ristretta',
				adc = '$adc',
				tipo_adc = '$tipo_adc',
				valore_adc = '$valore_adc',
				ce = '$ce',
				tipo_ce ='$tipo_ce',
				data_inserimento = '$data_inserimento_rm_morfologica'
				WHERE id = '$id_rm_morfologica' ";
		 $rs2 = mysql_query($query);	
	
		if ($calcolo_volume_neo == -1000)
			$calcolo_volume_neo = NULL;
		if ($valore_adc == -1000)
			$valore_adc = NULL;		
			
		$data_inserimento_rm_morfologica=data_convert_for_utente($data_inserimento_rm_morfologica);	

		$pagina = 17;
		include ("log.php");
			
		if ($rs2 == 1)
			$ok_aggiornamento = 1;
	}	

}
else
{
	if ($_REQUEST['start'] == 1)
	{
		$id_paziente =$_REQUEST['id_paziente'];
		$_SESSION['id_paziente'] = $id_paziente;
		
		// Libera tutte le sessioni:
		delete_session();

		// recupera tutti i dati dalle sessioni:
		recupero_session();	
	} 
	else if ($_REQUEST['start'] == 2);
	else  
	{
		$id_paziente = $_SESSION['id_paziente'];
		$flag_aggiorna = $_SESSION['flag_aggiorna'];
	
		// DATA INSERIMENTO RM MORFOLOGICA +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		if ($_REQUEST['data_inserimento_rm_morfologica'])
			$_SESSION['data_inserimento_rm_morfologica'] = $_REQUEST['data_inserimento_rm_morfologica'];	
		else;
		$data_inserimento_rm_morfologica = $_SESSION['data_inserimento_rm_morfologica'];
		// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		
		// EXTRASSIALE RM +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		if ($_REQUEST['extrassiale_rm'])
			$_SESSION['extrassiale_rm'] = $_REQUEST['extrassiale_rm'];
		else;
		$extrassiale_rm = $_SESSION['extrassiale_rm'];				
		// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
		
		// INTRASSIALE RM +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		if ($_REQUEST['intrassiale_rm'])
			$_SESSION['intrassiale_rm'] = $_REQUEST['intrassiale_rm'];
		else;
		$intrassiale_rm = $_SESSION['intrassiale_rm'];		
		// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
		
		// T2/FLAIR +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		if ($_REQUEST['t2_flair'])
			$_SESSION['t2_flair'] = $_REQUEST['t2_flair'];
		else;
		$t2_flair = $_SESSION['t2_flair'];		
		// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++			
		
		// FLAIR 3D +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		if ($_REQUEST['flair_3d'])
			$_SESSION['flair_3d'] = $_REQUEST['flair_3d'];
		else;
		$flair_3d = $_SESSION['flair_3d'];
			
			// Calcolo volume NEO --------------------------------------------------
			if ($flair_3d == 'off')
				$_SESSION['calcolo_volume_neo'] = NULL;	
		
			if ($_REQUEST['calcolo_volume_neo'])
				$_SESSION['calcolo_volume_neo'] = $_REQUEST['calcolo_volume_neo'];
			else;
			$calcolo_volume_neo = $_SESSION['calcolo_volume_neo'];
		
			if ($calcolo_volume_neo== 'NULL')
				$_SESSION['calcolo_volume_neo'] = NULL;	
			// --------------------------------------------------------------------		
		// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
		
		// DIFFUSIONE (DWI)++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		if ($_REQUEST['dwi'])
			$_SESSION['dwi'] = $_REQUEST['dwi'];
		else;
		$dwi = $_SESSION['dwi'];
			// DWI ristretta --------------------------------------------------
			if ($dwi == 'off')
				$_SESSION['dwi_ristretta'] = NULL;	
				
			if ($_REQUEST['dwi_ristretta'])
				$_SESSION['dwi_ristretta'] = $_REQUEST['dwi_ristretta'];
			else;
			$dwi_ristretta = $_SESSION['dwi_ristretta'];		
			// ----------------------------------------------------------------
		// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
		
		// ADC ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		if ($_REQUEST['adc'])
			$_SESSION['adc'] = $_REQUEST['adc'];
		else;
		$adc = $_SESSION['adc'];
			// 	ADC ridotto e valore ----------------------------------------
			if ($adc == 'off')
			{
				$_SESSION['valore_adc'] = NULL;			
				$_SESSION['tipo_adc'] = NULL;	
			}
			
			if ($_REQUEST['tipo_adc'])
				$_SESSION['tipo_adc'] = $_REQUEST['tipo_adc'];
			else;
			$tipo_adc = $_SESSION['tipo_adc'];
						
			if ($_REQUEST['valore_adc'])
				$_SESSION['valore_adc'] = $_REQUEST['valore_adc'];
			else;
			$valore_adc = $_SESSION['valore_adc'];
				
			if ( $valore_adc== 'NULL')
				$_SESSION['valore_adc'] = NULL;			
			// ---------------------------------------------------------------
		// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
				
		// CE +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		if ($_REQUEST['ce'])
			$_SESSION['ce'] = $_REQUEST['ce'];
		else;
		$ce = $_SESSION['ce'];
			// tipo_ce ------------------------------------------------
			if ($ce == 'off')
				$_SESSION['tipo_ce'] = NULL;					
				
			if ($_REQUEST['tipo_ce'])
				$_SESSION['tipo_ce'] = $_REQUEST['tipo_ce'];
			else;
			$tipo_ce = $_SESSION['tipo_ce'];	
			// --------------------------------------------------------		
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
	var data = document.esame.data_inserimento_rm_morfologica.value;

	var destination_page = "nuovo_rm_morfologica.php";
	location.href = destination_page+"?data_inserimento_rm_morfologica="+data;	
}

function calcolo_volume()
{
	var volume_neo = document.esame.calcolo_volume_neo.value;
	
	var destination_page = "nuovo_rm_morfologica.php";
	
	if (!isNaN(volume_neo))
	{
		if (volume_neo == "")
			volume_neo="NULL";
	
		location.href = destination_page+"?calcolo_volume_neo="+volume_neo;
	}
	else
	{
		location.href = destination_page+"?calcolo_volume_neo=NULL";
		alert ('ATTENZIONE: non hai inserito un valore adeguato');
	}	
	
}

function val_adc()
{
	var valore_adc = document.esame.valore_adc.value;
	
	var destination_page = "nuovo_rm_morfologica.php";
			
	if (!isNaN(valore_adc))
	{
		if (valore_adc == "")
			valore_adc="NULL";
	
		location.href = destination_page+"?valore_adc="+valore_adc;	
	}
	else
	{
		location.href = destination_page+"?valore_adc=NULL";	
		alert ('ATTENZIONE: non hai inserito un valore adeguato');
	}	
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
<font face="Verdana, Arial, Helvetica, sans-serif" color="#FFFFCC" size='2'>The data will be inserted in the database only when you see the confirm and when you see the tab 'CLOSE'</font>
<br />
<br />
<font id="font2">
Morphological MR</font>
<br /><br />
<form action="nuovo_rm_morfologica.php" method="post" name='esame'>

<table border="0" width="60%" cellspacing="3">
	<tr>
		<td width="25%" align="center" bgcolor="#CACACA">
		<font face="Verdana, Arial, Helvetica, sans-serif" size="2">Last name</font>
		</td>
		<td width="25%" align="center" id='form1'>
		<font face="Verdana, Arial, Helvetica, sans-serif" size="2">
		<?php
		if ($permission == 3)
			print ("***********");
		else 
			print $paziente->getSurname(); 
		?>
		</font>
		</td>
		<td width="25%" align="center" bgcolor="#CACACA">
		<font face="Verdana, Arial, Helvetica, sans-serif" size="2">Name</font>
		</td>
		<td width="25%" align="center" id='form1'>
		<font face="Verdana, Arial, Helvetica, sans-serif" size="2">
		<?php
		if ($permission == 3)
			print ("***********");
		else 
			print $paziente->getName(); 
		?>		
		</font>
		</td>
	</tr>
</table>
<hr width="60%" size='4'/>
<br />

<table border="0" width="55%" cellpadding="0" cellspacing="0">
	<tr>
		<td width="39%" align="right" id='font3'>Date &nbsp;</td>
		<td width="61%" align="left">		
		<?php
		if ($errore_data_inserimento_rm_morfologica == 1)
			print ("<input type='text' name='data_inserimento_rm_morfologica' value='$data_inserimento_rm_morfologica' size='15' id='form1_A' onchange=\"data_inserimento()\" />");
		else
			if (($permission == 3) || ($ok_inserimento == 1))
				print ("<font face='Verdana, Arial, Helvetica, sans-serif' size='3' color='#2ECCFA'>$data_inserimento_rm_morfologica</font>");
			else
				print ("<input type='text' name='data_inserimento_rm_morfologica' value='$data_inserimento_rm_morfologica' size='15' id='form1' onchange=\"data_inserimento()\" />");
		?>	
		<font id='font4'>(dd/mm/yyyy)</font>
		</td>	
	</tr>
</table>	

<table border="0" width="60%" cellpadding="0" cellspacing="4">	
	<tr>
		<td width="35%" align="right" id='font3'>Extra axial &nbsp;</td>
		<td width="25%" align="left" id='form1'> 
			<?php
			if (($permission == 3) || ($ok_inserimento == 1))
			{
				if ($extrassiale_rm == 'on')
					print ("<font id='font20'>Yes </font>");
			}
			else
			{
				if ($extrassiale_rm == 'on')
					print ("<input type='checkbox' name='extrassiale_rm' value='' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?extrassiale_rm=off'\" checked='checked'/>");
				else
					print ("<input type='checkbox' name='extrassiale_rm' value='' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?extrassiale_rm=on'\"/>");
			}			
			?>
		</td>
		<td width="30%" align="left"></td>	
	</tr>
	<tr>
		<td width="35%" align="right" id='font3'>Inta axial &nbsp;</td>
		<td width="25%" align="left" id='form1'> 
			<?php
			if (($permission == 3) || ($ok_inserimento == 1))
			{
				if ($intrassiale_rm == 'on')
					print ("<font id='font20'>Yes </font>");
			}
			else
			{
				if ($intrassiale_rm == 'on')
					print "<input type='checkbox' name='intrassiale_rm' checked='checked' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?intrassiale_rm=off'\"/>  ";
				else
					print "<input type='checkbox' name='intrassiale_rm' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?intrassiale_rm=on'\"/>  ";	
			}				
			?>	
		</td>
		<td width="30%" align="left"></td>	
	</tr>
	<tr>
		<td width="35%" align="right" id='font3'>T2/FLAIR &nbsp;</td>
		<td width="25%" align="left" id='form1'> 
			<?php
			if (($permission == 3) || ($ok_inserimento == 1))
			{
				if ($t2_flair == 'on')
					print ("<font id='font20'>Yes </font>");	
			}
			else
			{
				if ($t2_flair == 'on')
					print "<input type='checkbox' name='t2_flair' checked='checked' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?t2_flair=off'\"/>  ";
				else
					print "<input type='checkbox' name='t2_flair' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?t2_flair=on'\"/>  ";	
			}			
			?>	
		</td>
		<td width="30%" align="left"></td>	
	</tr>	
	<tr>
			<td width="20%" align="right"><font id="font3">FLAIR 3D</font>&nbsp;</td>
			<td width="80%" align="left" id='form1'>
			<?php
			if (($permission == 3) || ($ok_inserimento == 1))
			{
				if ($flair_3d == 'on')
					print ("<font id='font20'>Yes </font>");
			}
			else
			{
				if ($flair_3d == 'on')
					print ("<input type='checkbox' name='flair_3d' value='' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?flair_3d=off'\" checked='checked'/>");
				else
					print ("<input type='checkbox' name='flair_3d' value='' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?flair_3d=on'\"/>");
			}		
			?>			
			 </td>
	</tr>
	<?php
		if ($flair_3d == 'on')
		{
	?>	
		<tr>
			<td width="20%" align="right"></td>
			<td width="80%" align="left" id='form1_B'><font id='font9_A'> Tumor volume: </font>
			<?php
			if (($permission == 3) || ($ok_inserimento == 1))
				print ("$calcolo_volume_neo");
			else
			{	
			?>
				<input type='text' name="calcolo_volume_neo" value='<?php print $calcolo_volume_neo; ?>' size='5' onchange='calcolo_volume()' />
			<?php } ?>	
			</td>
		</tr>	
	<?php
		}
	?>		

	<tr>
		<td width="20%" align="right"><font id="font3">Diffusion</font>&nbsp;</td>
		<td width="80%" align="left" id='form1'>
<?php
			if (($permission == 3) || ($ok_inserimento == 1))
			{
				if ($dwi == 'on')
					print ("<font id='font20'>Yes </font>");
			}
			else
			{
				if ($dwi == 'on')
					print ("<input type='checkbox' name='dwi' value='' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?dwi=off'\" checked='checked'/>");
				else
					print ("<input type='checkbox' name='dwi' value='' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?dwi=on'\"/>");
			}			
?>	

		 </td>
	</tr>
<?php
	if ($dwi == 'on')
	{
?>	
	<tr>
		<td width="20%" align="right"></td>
		<td width="80%" align="left" id='form1_B'>
<?php
		if (($permission == 3) || ($ok_inserimento == 1))
		{
			print "<font face='Verdana, Arial, Helvetica, sans-serif' size='2'> ".strtoupper($dwi_ristretta)."</font>";
		}
		else
		{
		
			if ($dwi_ristretta == 'iper')
			{
				print ("<input type='radio' name='dwi_ristretta' value='iper' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?dwi_ristretta=iper'\" checked='checked'/><font id='font9_A'> HYPER</font> &nbsp;");
				print ("<input type='radio' name='dwi_ristretta' value='ipo' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?dwi_ristretta=ipo'\"/><font id='font9_A'> HYPO</font> &nbsp;");
				print ("<input type='radio' name='dwi_ristretta' value='normale' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?dwi_ristretta=normale'\"/><font id='font9_A'> NORMAL</font> &nbsp;");
			}
			else if ($dwi_ristretta == 'ipo')
			{
				print ("<input type='radio' name='dwi_ristretta' value='iper' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?dwi_ristretta=iper'\"/><font id='font9_A'> HYPER</font> &nbsp;");
				print ("<input type='radio' name='dwi_ristretta' value='ipo' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?dwi_ristretta=ipo'\" checked='checked'/><font id='font9_A'> HYPO</font> &nbsp;");
				print ("<input type='radio' name='dwi_ristretta' value='normale' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?dwi_ristretta=normale'\"/><font id='font9_A'> NORMAL</font> &nbsp;");			
			}		
			else if ($dwi_ristretta == 'normale')
			{
				print ("<input type='radio' name='dwi_ristretta' value='iper' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?dwi_ristretta=iper'\"/><font id='font9_A'> HYPER</font> &nbsp;");
				print ("<input type='radio' name='dwi_ristretta' value='ipo' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?dwi_ristretta=ipo'\" /><font id='font9_A'> HYPO</font> &nbsp;");
				print ("<input type='radio' name='dwi_ristretta' value='normale' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?dwi_ristretta=normale'\" checked='checked'/><font id='font9_A'> NORMAL</font> &nbsp;");			
			}				
			else
			{
				print ("<input type='radio' name='dwi_ristretta' value='iper' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?dwi_ristretta=iper'\"/><font id='font9_A'> HYPER</font> &nbsp;");
				print ("<input type='radio' name='dwi_ristretta' value='ipo' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?dwi_ristretta=ipo'\"/><font id='font9_A'> HYPO</font> &nbsp;");
				print ("<input type='radio' name='dwi_ristretta' value='normale' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?dwi_ristretta=normale'\"/><font id='font9_A'> NORMAL</font> &nbsp;");			
			}			

		}
?>	
		</td>
	</tr>	
<?php
	}
?>	

	<tr>
			<td width="20%" align="right"><font id="font3">ADC </font>&nbsp;</td>
			<td width="80%" align="left" id='form1'>
	<?php
			if (($permission == 3) || ($ok_inserimento == 1))
			{
				if ($adc == 'on')
					print ("<font id='font20'>Yes </font>");
			}
			else
			{
				if ($adc == 'on')
					print ("<input type='checkbox' name='adc' value='' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?adc=off'\" checked='checked'/>");
				else
					print ("<input type='checkbox' name='adc' value='' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?adc=on'\"/>");
			}		
	?>		
			 </td>
		</tr>

	<?php
		if ($adc == 'on')
		{
	?>	
		<tr>
			<td width="20%" align="right"></td>
			<td width="80%" align="left" id='form1_B'>
	<?php
		if (($permission == 3) || ($ok_inserimento == 1))
		{
			print "<font face='Verdana, Arial, Helvetica, sans-serif' size='2'> ".strtoupper($tipo_adc)."</font>";
		}
		else
		{	

			if ($tipo_adc == 'ridotta')
			{
				print ("<input type='radio' name='tipo_adc' value='ridotta' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?tipo_adc=ridotta'\" checked='checked'/><font id='font9_A'> Reduced</font> &nbsp;");
				print ("<input type='radio' name='tipo_adc' value='aumentata' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?tipo_adc=aumentata'\"/><font id='font9_A'> Increased</font> &nbsp;");
			}
			else if ($tipo_adc == 'aumentata')
			{
				print ("<input type='radio' name='tipo_adc' value='ridotta' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?tipo_adc=ridotta'\"/><font id='font9_A'> Reduced</font> &nbsp;");
				print ("<input type='radio' name='tipo_adc' value='aumentata' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?tipo_adc=aumentata'\" checked='checked'/><font id='font9_A'> Increased</font> &nbsp;");
			}		
			else
			{
				print ("<input type='radio' name='tipo_adc' value='ridotta' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?tipo_adc=ridotta'\"/><font id='font9_A'> Reduced</font> &nbsp;");
				print ("<input type='radio' name='tipo_adc' value='aumentata' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?tipo_adc=aumentata'\"/><font id='font9_A'> Increased</font> &nbsp;");
			}			

		}
	?>		
	
			<font id='font9_A'>&nbsp; &nbsp; &nbsp; Value: </font>
			<?php
			if (($permission == 3) || ($ok_inserimento == 1))
			{
				print "<font face='Verdana, Arial, Helvetica, sans-serif' size='2'> ".$valore_adc."</font>";
			}
			else
			 	print("<input type='text' name=\"valore_adc\" value='$valore_adc' size='5' onchange='val_adc()' />");
			  ?>			
			</td>
		</tr>	
	<?php
		}
	?>	
<tr>
		<td width="20%" align="right"><font id="font3">Contrast Enhancement </font>&nbsp;</td>
		<td width="80%" align="left" id='form1'>
<?php
			if (($permission == 3) || ($ok_inserimento == 1))
			{
				if ($ce == 'on')
					print ("<font id='font20'>Yes </font>");
			}
			else
			{
				if ($ce == 'on')
					print ("<input type='checkbox' name='ce' value='' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?ce=off'\" checked='checked'/>");
				else
					print ("<input type='checkbox' name='ce' value='' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?ce=on'\"/>");
			}	

?>		
		 </td>
	</tr>
<?php
	if ($ce == 'on')
	{
?>	
	<tr>
		<td width="20%" align="right"></td>
		<td width="80%" align="left" id='form1_B'>
<?php		
		if (($permission == 3) || ($ok_inserimento == 1))
		{
			print "<font face='Verdana, Arial, Helvetica, sans-serif' size='2'> ".strtoupper($tipo_ce)."</font>";
		}
		else
		{

			if ($tipo_ce == 'omogeneo')
			{
				print ("<input type='radio' name='tipo_ce' value='omogeneo' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?tipo_ce=omogeneo'\" checked='checked'/><font id='font9_A'>Homogeneous</font> &nbsp;");
				print ("<input type='radio' name='tipo_ce' value='disomogeneo' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?tipo_ce=disomogeneo'\"/><font id='font9_A'>Inhomogeneous</font> &nbsp;");			
				print (" <input type='radio' name='tipo_ce' value='ad_anello' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?tipo_ce=ad_anello'\"/><font id='font9_A'>Ring</font>");
			}
			else if ($tipo_ce == 'disomogeneo')
			{
				print ("<input type='radio' name='tipo_ce' value='omogeneo' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?tipo_ce=omogeneo'\"/><font id='font9_A'>Homogeneous</font> &nbsp;");
				print ("<input type='radio' name='tipo_ce' value='disomogeneo' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?tipo_ce=disomogeneo'\" checked='checked'/><font id='font9_A'>Inhomogeneous</font> &nbsp;");
				print (" <input type='radio' name='tipo_ce' value='ad_anello' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?tipo_ce=ad_anello'\"/><font id='font9_A'>Ring</font>");
			}		
			else if ($tipo_ce == 'ad_anello')
			{
				print ("<input type='radio' name='tipo_ce' value='omogeneo' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?tipo_ce=omogeneo'\"/><font id='font9_A'>OHomogeneous</font> &nbsp;");
				print ("<input type='radio' name='tipo_ce' value='disomogeneo' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?tipo_ce=disomogeneo'\"/><font id='font9_A'>Inhomogeneous</font> &nbsp;");
				print (" <input type='radio' name='tipo_ce' value='ad_anello' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?tipo_ceo=ad_anello'\" checked='checked'/><font id='font9_A'>Ring</font>");
			}		
			else
			{
				print ("<input type='radio' name='tipo_ce' value='omogeneo' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?tipo_ce=omogeneo'\"/><font id='font9_A'>Homogeneous</font> &nbsp;");
				print ("<input type='radio' name='tipo_ce' value='disomogeneo' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?tipo_ce=disomogeneo'\"/><font id='font9_A'>Inhomogeneous</font> &nbsp;");
				print (" <input type='radio' name='tipo_ce' value='ad_anello' onClick=\"javascript:location.href='nuovo_rm_morfologica.php?tipo_ceo=ad_anello'\"/><font id='font9_A'>Ring</font>");
			}				
		
		}
?>		
		 </td>
	</tr>	
<?php
	}
?>	

</table>	
<br />
<?php
if ($ok_inserimento == 1)
	print ("<font id='font4_N'>The data have been inserted in the database</font><br>");
else
{
?>
	<table border="0" width="65%">
	<tr>
		<td width="70%" align="center"><hr width="96%" /></td>
		<td width="30%" align="center">		
		<?php
		if ($permission == 3);
		else
		{
			if ($flag_aggiorna == 1)
				print ("<input type='submit' name='inserisci' value='UPDATE' id='form2'/>");
			else
				print ("<input type='submit' name='inserisci' value='INSERT' id='form2'/>");
		}		
		?>		
		</td>
	</tr>
	</table>
<?php
}
?>
<br />
	<?php
		if ($errore_data_inserimento_rm_morfologica == 1)
			print ("<font id='font4_N'>Please check the date format</font><br>");
			
		if ($error == 1)
			print ("<font id='font4_N'>There was an error. The data are not inserted in the database<br>
				Contact the administrator.</font><br>");	
			
		if ($ok_aggiornamento == 1)
			print ("<font id='font4_N'>Data are updated correctly</font><br>");		
	?>	

</form>
	
<br />
<?php
if (($ok_inserimento == 1) || ($ok_aggiornamento == 1) || ($permission == 3))
	print ("<input type=\"button\" onclick=\"javascript:window.close();\" value='CHIUDI' id='form2_3'/>");
?>
<br />
</div>
</body>
</html>