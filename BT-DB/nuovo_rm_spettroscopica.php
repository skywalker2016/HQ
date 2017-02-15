<?php
session_start();
include ("accesso_db.php");

if ($permission == NULL)
	header("Location:errore.html");
	
include ("convertitore_date.php");
include ("function_php/try_format_date.php");
require_once('class/class.patient.php');
require_once('class/class.rm_spettroscopica.php');
require_once('class/class.dataExamInsert.php');


// Funzione che libera tutte le sessioni: -----------------------------------------------------
function delete_session()
{
	$_SESSION['data_inserimento_rm_spettroscopica'] = NULL;
	$_SESSION['flag_aggiorna'] = NULL;
	$_SESSION['te'] = NULL;
	$_SESSION['spettro'] = NULL;
	$_SESSION['naa'] = NULL;
	$_SESSION['valore_naa_cr'] = NULL;
	$_SESSION['valore_cho_cr'] = NULL;
	$_SESSION['lipidi_lattati'] = NULL;
	$_SESSION['mioinositolo'] = NULL;
}
// --------------------------------------------------------------------------------------------

// Funzione che recupera i dati dalle sessioni: -----------------------------------------------------
function recupero_session()
{
	global $data_inserimento_rm_spettroscopica;
	global $flag_aggiorna;
	global $te;
	global $spettro;
	global $naa;
	global $valore_naa_cr;
	global $valore_cho_cr;
	global $lipidi_lattati;
	global $mioinositolo;

	$flag_aggiorna = $_SESSION['flag_aggiorna'];
	$data_inserimento_rm_spettroscopica = $_SESSION['data_inserimento_rm_spettroscopica'];
	$valore_r_cbv=$_SESSION['valore_r_cbv'];	
	$te=$_SESSION['te'];
	$spettro=$_SESSION['spettro'];
	$naa=$_SESSION['naa'];
	$valore_naa_cr=$_SESSION['valore_naa_cr'];
	$valore_cho_cr=$_SESSION['valore_cho_cr'];
	$lipidi_lattati=$_SESSION['lipidi_lattati'];
	$mioinositolo=$_SESSION['mioinositolo'];
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
	$id_rm_spettroscopica = $_REQUEST['id_rm_spettroscopica'];
	$_SESSION['id_paziente'] = $id_paziente;
	$_SESSION['id_rm_spettroscopica'] = $id_rm_spettroscopica;		

	// recupera i dati dal database:
	
	$rm_spettroscopica = new rm_spettroscopica($id_paziente, NULL, NULL, NULL, NULL, NULL, NULL, NULL);	
	$rm_spettroscopica->retrive_by_id($id_rm_spettroscopica);
	$data_inserimento_rm_spettroscopica = $rm_spettroscopica->getData_inserimento();
	$data_inserimento_rm_spettroscopica = data_convert_for_utente($data_inserimento_rm_spettroscopica);

	$naa = $rm_spettroscopica -> getNaa_ridotto();
	$valore_naa_cr = $rm_spettroscopica -> getValore_naa_cr();
	$valore_cho_cr = $rm_spettroscopica -> getCho_cr();
	$lipidi_lattati = $rm_spettroscopica -> getLipidi_lattati();	
	$mioinositolo = $rm_spettroscopica -> getMioinositolo();
	$spettro = $rm_spettroscopica -> getTipo_spettro();
	$te = $rm_spettroscopica -> getTe();

	if ($valore_naa_cr== -1000)
		$valore_naa_cr = NULL;

	if ($valore_cho_cr == -1000)
		$cho_cr = NULL;

	// registra tutte le sessioni:
	$_SESSION['naa'] = $naa;
	$_SESSION['valore_naa_cr'] = $valore_naa_cr;
	$_SESSION['valore_cho_cr'] = $valore_cho_cr;
	$_SESSION['lipidi_lattati'] = $lipidi_lattati;
	$_SESSION['mioinositolo'] = $mioinositolo;
	$_SESSION['spettro'] = $spettro;
	$_SESSION['te'] = $te;
	$_SESSION['data_inserimento_rm_spettroscopica'] = $data_inserimento_rm_spettroscopica;

	$flag_aggiorna =1;
	$_SESSION['flag_aggiorna'] = $flag_aggiorna;
}
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


// INSERIMENTO DATI DI UNA NUOVA RM MORFOLOGICA ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
if ($_REQUEST['inserisci'] == 'INSERT') // Inserisce i dati nel database:
{
	// recupera tutti i dati dalle sessioni:
	$id_paziente = $_SESSION['id_paziente'];
	recupero_session();

	$rm_spettroscopica = new rm_spettroscopica($id_paziente, $naa, $valore_naa_cr, $valore_cho_cr, $lipidi_lattati, $mioinositolo, $spettro, $te);
	$errore_data_inserimento_rm_spettroscopica=controllo_data($data_inserimento_rm_spettroscopica);

	if ($errore_data_inserimento_rm_spettroscopica == 1);
	else
	{
		$data_inserimento_rm_spettroscopica1=data_convert_for_mysql($data_inserimento_rm_spettroscopica);
		$rm_spettroscopica -> setData_inserimento($data_inserimento_rm_spettroscopica1);
		$rm_spettroscopica->insert();
		
		$pagina = 18;
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

	$id_rm_spettroscopica = $_SESSION['id_rm_spettroscopica'];
	$rm_spettroscopica = new rm_spettroscopica(NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);	

	// controlla la data:
	$errore_data_inserimento_rm_spettroscopica=controllo_data($data_inserimento_rm_spettroscopica);

	if ($errore_data_inserimento_rm_spettroscopica == 1);
	else
	{
		if ($valore_naa_cr == NULL)
			$valore_naa_cr = -1000;
		
		if ($valore_cho_cr == NULL)
			$valore_cho_cr = -1000;

		$data_inserimento_rm_spettroscopica=data_convert_for_mysql($data_inserimento_rm_spettroscopica);

		$query= "UPDATE rm_spettroscopica SET
			naa_ridotto = '$naa',	
			valore_naa_cr = '$valore_naa_cr',	 
			cho_cr	= '$valore_cho_cr',
			lipidi_lattati	= '$lipidi_lattati',
			mioinositolo = '$mioinositolo',
			tipo_spettro = '$spettro',
			te = '$te',
			data_inserimento = '$data_inserimento_rm_spettroscopica'	
			WHERE id = '$id_rm_spettroscopica' ";
		 $rs2 = mysql_query($query);	

		$pagina = 19;
		include ("log.php");
	
		if ($valore_naa_cr== -1000)
			$valore_naa_cr = NULL;
	
		if ($valore_cho_cr == -1000)
			$valore_cho_cr = NULL;

			
		$data_inserimento_rm_spettroscopica=data_convert_for_utente($data_inserimento_rm_spettroscopica);	
	
		if ($rs2 == 1)
			$ok_aggiornamento = 1;  
	}	

}
else
{
	$start = $_REQUEST['start'];
	if ($start == 1)
	{
		$id_paziente =$_REQUEST['id_paziente'];
		$_SESSION['id_paziente'] = $id_paziente;
		
		// Libera tutte le sessioni:
		delete_session();

		// recupera tutti i dati dalle sessioni:
		recupero_session();	
	} 
	else if ($start == 2);
	else  
	{
		$id_paziente = $_SESSION['id_paziente'];
		$flag_aggiorna = $_SESSION['flag_aggiorna'];
	
		// DATA INSERIMENTO RM MORFOLOGICA +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		if ($_REQUEST['data_inserimento_rm_spettroscopica'])
			$_SESSION['data_inserimento_rm_spettroscopica'] = $_REQUEST['data_inserimento_rm_spettroscopica'];	
		else;
		$data_inserimento_rm_spettroscopica = $_SESSION['data_inserimento_rm_spettroscopica'];
		// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		
		// TE +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		if ($_REQUEST['te'])
			$_SESSION['te'] = $_REQUEST['te'];
		else;
		$te = $_SESSION['te'];		
		// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

		// Spettro ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		if ($_REQUEST['spettro'])
			$_SESSION['spettro'] = $_REQUEST['spettro'];
		else;
			$spettro = $_SESSION['spettro'];
		// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

		// Naa ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		if ($_REQUEST['naa'])
			$_SESSION['naa'] = $_REQUEST['naa'];
		else;
			$naa = $_SESSION['naa'];
		// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

		// Valore Naa/cr ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		if ($_REQUEST['valore_naa_cr'])
			$_SESSION['valore_naa_cr'] = $_REQUEST['valore_naa_cr'];
		else;
		$valore_naa_cr = $_SESSION['valore_naa_cr'];
		if ($valore_naa_cr== 'NULL')
			$_SESSION['valore_naa_cr'] = NULL;

		if ($naa == 'off')
			$_SESSION['valore_naa_cr'] = NULL;

		$valore_naa_cr = $_SESSION['valore_naa_cr'];		
		// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

		// Valore Naa/cr ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		if ($_REQUEST['valore_cho_cr'])
			$_SESSION['valore_cho_cr'] = $_REQUEST['valore_cho_cr'];
		else;
		$valore_cho_cr = $_SESSION['valore_cho_cr'];
		if ($valore_cho_cr== 'NULL')
			$_SESSION['valore_cho_cr'] = NULL;

		$valore_cho_cr = $_SESSION['valore_cho_cr'];	
		// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

		// Lipidi / Lattati +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		if ($_REQUEST['lipidi_lattati'])
			$_SESSION['lipidi_lattati'] = $_REQUEST['lipidi_lattati'];
		else;
			$lipidi_lattati = $_SESSION['lipidi_lattati'];
		// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

		// mioinositolo +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		if ($_REQUEST['mioinositolo'])
			$_SESSION['mioinositolo'] = $_REQUEST['mioinositolo'];
		else;
			$mioinositolo = $_SESSION['mioinositolo'];
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
	var data = document.esame.data_inserimento_rm_spettroscopica.value;

	var destination_page = "nuovo_rm_spettroscopica.php";
	location.href = destination_page+"?data_inserimento_rm_spettroscopica="+data;	
}

function naa_cr_function()
{
	var valore_naa_cr = document.esame.valore_naa_cr.value;
	
	var destination_page = "nuovo_rm_spettroscopica.php";
			
	if (!isNaN(valore_naa_cr))
	{
		if (valore_naa_cr == "")
		valore_naa_cr="NULL";
	
		location.href = destination_page+"?valore_naa_cr="+valore_naa_cr;	
	}
	else
	{
		location.href = destination_page+"?valore_naa_cr=NULL";	
		alert ('ATTENZIONE: non hai inserito un valore adeguato');
	}	
}

function cho_cr_function()
{
	var valore_cho_cr = document.esame.valore_cho_cr.value;
	
	var destination_page = "nuovo_rm_spettroscopica.php";
			
	if (!isNaN(valore_cho_cr))
	{
		if (valore_cho_cr == "")
		valore_cho_cr="NULL";	
	
		location.href = destination_page+"?valore_cho_cr="+valore_cho_cr;	
	}
	else
	{
		location.href = destination_page+"?valore_cho_cr=NULL";	
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
<font id="font2">
RM Spectroscopy</font>
<br /><br />
<form action="nuovo_rm_spettroscopica.php" method="post" name='esame'>

<table border="0" width="60%" cellspacing="3">
	<tr>
		<td width="25%" align="center" bgcolor="#CACACA">
		<font face="Verdana, Arial, Helvetica, sans-serif" size="2">Lastname</font>
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
<font face="Verdana, Arial, Helvetica, sans-serif" color="#FFFFCC" size='2'>The data will be inserted in the database only when you see the confirm and when you see the tab 'CLOSE'</font>
<br />
<br />

<table border="0" width="62%" cellpadding="0" cellspacing="0">
	<tr>
		<td width="39%" align="right" id='font3'>Date &nbsp;</td>
		<td width="61%" align="left">		
		<?php
		if ($errore_data_inserimento_rm_spettroscopica == 1)
			print ("<input type='text' name='data_inserimento_rm_spettroscopica' value='$data_inserimento_rm_spettroscopica' size='15' id='form1_A' onchange=\"data_inserimento()\" />");
		else
			if (($permission == 3) || ($ok_inserimento == 1))
				print ("<font face='Verdana, Arial, Helvetica, sans-serif' size='3' color='#2ECCFA'>$data_inserimento_rm_spettroscopica</font>");
			else
				print ("<input type='text' name='data_inserimento_rm_spettroscopica' value='$data_inserimento_rm_spettroscopica' size='15' id='form1' onchange=\"data_inserimento()\" />");
		?>	
		<font id='font4'>(gg/mm/aaaa)</font>
		</td>	
	</tr>
</table>	
<br />

<table border="0" width="61%" cellpadding="0" cellspacing="4">	
	<tr>
		<td width="35%" align="right" id='font3'>T.E. &nbsp;</td>
		<td width="65%" align="left" id='form1'> 
		<?php
			if (($permission == 3) || ($ok_inserimento == 1))
			{
				print ("<font id='font20'> $te </font>");
			}
			else
			{
if ($te == 'breve')
				{
					print ("<input type='radio' name='te' value='breve' onClick=\"javascript:location.href='nuovo_rm_spettroscopica.php?te=breve'\" checked='checked'/><font id='font9_A'> Short</font> &nbsp;");
					print ("<input type='radio' name='te' value='intermedio' onClick=\"javascript:location.href='nuovo_rm_spettroscopica.php?te=intermedio'\"/><font id='font9_A'> Intermediate</font> &nbsp;");
					print ("<input type='radio' name='te' value='lungo' onClick=\"javascript:location.href='nuovo_rm_spettroscopica.php?te=lungo'\"/><font id='font9_A'> Long</font> &nbsp;");
				}
				else if ($te == 'intermedio')
				{
					print ("<input type='radio' name='te' value='breve' onClick=\"javascript:location.href='nuovo_rm_spettroscopica.php?te=breve' \"/><font id='font9_A'> Short</font> &nbsp;");
					print ("<input type='radio' name='te' value='intermedio' onClick=\"javascript:location.href='nuovo_rm_spettroscopica.php?te=intermedio'\" checked='checked'/><font id='font9_A'> Intermediate</font> &nbsp;");
					print ("<input type='radio' name='te' value='lungo' onClick=\"javascript:location.href='nuovo_rm_spettroscopica.php?te=lungo'\"/><font id='font9_A'> Long</font> &nbsp;");
				}	
				else if ($te == 'lungo')
				{
					print ("<input type='radio' name='te' value='breve' onClick=\"javascript:location.href='nuovo_rm_spettroscopica.php?te=breve' \"/><font id='font9_A'> Short</font> &nbsp;");
					print ("<input type='radio' name='te' value='intermedio' onClick=\"javascript:location.href='nuovo_rm_spettroscopica.php?te=intermedio'\" /><font id='font9_A'> Intermediate</font> &nbsp;");
					print ("<input type='radio' name='te' value='lungo' onClick=\"javascript:location.href='nuovo_rm_spettroscopica.php?te=lungo'\" checked='checked'/><font id='font9_A'> Long</font> &nbsp;");
				}	
				else
				{
					print ("<input type='radio' name='te' value='breve' onClick=\"javascript:location.href='nuovo_rm_spettroscopica.php?te=breve' \"/><font id='font9_A'> Short</font> &nbsp;");
					print ("<input type='radio' name='te' value='intermedio' onClick=\"javascript:location.href='nuovo_rm_spettroscopica.php?te=intermedio'\" /><font id='font9_A'> Intermediate</font> &nbsp;");
					print ("<input type='radio' name='te' value='lungo' onClick=\"javascript:location.href='nuovo_rm_spettroscopica.php?te=lungo'\"/><font id='font9_A'> Long</font> &nbsp;");
				}				
			}
		?>		
		</td>
	</tr>
	
	<tr>
		<td width="35%" align="right" id='font3'>Spectrum &nbsp;</td>
		<td width="65%" align="left" id='form1'> 
		<?php
			if (($permission == 3) || ($ok_inserimento == 1))
			{
				if ($spettro == 'svs')
					print ("<font id='font20'> SVS </font>");
				else if ($spettro == 'csi')
					print ("<font id='font20'> CSI </font>");
				else;				
			}
			else
			{
				if ($spettro == 'svs')
				{
					print ("<input type='radio' name='spettro' value='svs' onClick=\"javascript:location.href='nuovo_rm_spettroscopica.php?spettro=svs'\" checked='checked'/><font id='font9_A'> SVS</font> &nbsp;");
					print ("<input type='radio' name='spettro' value='csi' onClick=\"javascript:location.href='nuovo_rm_spettroscopica.php?spettro=csi'\"/><font id='font9_A'> CSI</font> &nbsp;");
				}
				else if ($spettro == 'csi')
				{
					print ("<input type='radio' name='spettro' value='svs' onClick=\"javascript:location.href='nuovo_rm_spettroscopica.php?spettro=svs'\" /><font id='font9_A'> SVS</font> &nbsp;");
					print ("<input type='radio' name='spettro' value='csi' onClick=\"javascript:location.href='nuovo_rm_spettroscopica.php?spettro=csi'\" checked='checked'/><font id='font9_A'> CSI</font> &nbsp;");
				}	
				else
				{
					print ("<input type='radio' name='spettro' value='svs' onClick=\"javascript:location.href='nuovo_rm_spettroscopica.php?spettro=svs'\" /><font id='font9_A'> SVS</font> &nbsp;");
					print ("<input type='radio' name='spettro' value='csi' onClick=\"javascript:location.href='nuovo_rm_spettroscopica.php?spettro=csi'\" /><font id='font9_A'> CSI</font> &nbsp;");
				}
			}
		?>		
		</td>
	</tr>

	<tr>
		<td width="35%" align="right" id='font3'>Reduction of Naa &nbsp;</td>
		<td width="65%" align="left" id='form1'> 
		<?php
			if (($permission == 3) || ($ok_inserimento == 1))
			{
				if ($naa== 'on')
					print ("<font id='font20'>Yes </font>");
			}
			else
			{
				if ($naa== 'on')
					print ("<input type='checkbox' name='naa' value='' onClick=\"javascript:location.href='nuovo_rm_spettroscopica.php?naa=off'\" checked='checked'/>");
				else
					print ("<input type='checkbox' name='naa' value='' onClick=\"javascript:location.href='nuovo_rm_spettroscopica.php?naa=on'\"/>");				
			}
		?>

			<font id='font9_A'>&nbsp; &nbsp; &nbsp; Naa/Cr Value: </font>
			<?php	
				if ($valore_naa_cr == -1000)
					$valore_naa_cr = NULL;
			
				if (($permission == 3) || ($ok_inserimento == 1))
					print ("<font id='font20'> $valore_naa_cr</font>");
				else
					print ("<input type='text' name='valore_naa_cr' value='$valore_naa_cr' size='5' onchange=\"naa_cr_function()\" />");
			?>
		</td>
	</tr>

	<tr>
		<td width="35%" align="right" id='font3'>Value of Cho/Cr &nbsp;</td>
		<td width="65%" align="left" id='form1'> 

		<?php	
			if ($valore_cho_cr == -1000)
				 $valore_cho_cr = NULL;		
		
			if (($permission == 3) || ($ok_inserimento == 1))
				print ("<font id='font20'> $valore_cho_cr</font>");
			else
				print ("<input type='text' name='valore_cho_cr' value='$valore_cho_cr' size='5' onchange=\"cho_cr_function()\" />");
		?>
		</td>
		<td width="30%" align="left"></td>	
	</tr>

	<tr>
		<td width="35%" align="right" id='font3'>Lipids / Lactates &nbsp;</td>
		<td width="25%" align="left" id='form1'> 
		<?php
			if (($permission == 3) || ($ok_inserimento == 1))
			{
				if ($lipidi_lattati== 'on')
					print ("<font id='font20'>Yes </font>");
			}
			else
			{
				if ($lipidi_lattati == 'on')
					print ("<input type='checkbox' name='lipidi_lattati' value='' onClick=\"javascript:location.href='nuovo_rm_spettroscopica.php?lipidi_lattati=off'\" checked='checked'/>");
				else
					print ("<input type='checkbox' name='lipidi_lattati' value='' onClick=\"javascript:location.href='nuovo_rm_spettroscopica.php?lipidi_lattati=on'\"/>");				
			}
		?>
		</td>
	</tr>

	<tr>
		<td width="35%" align="right" id='font3'>Myo Inositol &nbsp;</td>
		<td width="65%" align="left" id='form1'> 
		<?php
			if (($permission == 3) || ($ok_inserimento == 1))
			{
				if ($mioinositolo== 'on')
					print ("<font id='font20'>Yes </font>");
			}
			else
			{
				if ($mioinositolo == 'on')
					print ("<input type='checkbox' name='mioinositolo' value='' onClick=\"javascript:location.href='nuovo_rm_spettroscopica.php?mioinositolo=off'\" checked='checked'/>");
				else
					print ("<input type='checkbox' name='mioinositolo' value='' onClick=\"javascript:location.href='nuovo_rm_spettroscopica.php?mioinositolo=on'\"/>");				
			}
		?>
		</td>
	</tr>
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
	if ($errore_data_inserimento_rm_spettroscopica == 1)
		print ("<font id='font4_N'>Please check the date format</font><br>");
		
	if ($error == 1)
		print ("<font id='font4_N'>There was an error. The data are not inserted in the database<br>
				Contact the administrator.</font><br>");	
		
	if ($ok_aggiornamento == 1)
		print ("<font id='font4_N'>The data have been inserted in the database</font><br>");		
?>
</form>
	
<br />
<?php
if (($ok_inserimento == 1) || ($ok_aggiornamento == 1) || ($permission == 3))
	print ("<input type=\"button\" onclick=\"javascript:window.close();\" value='CLOSE' id='form2_3'/>");
?>
<br />
</div>
</body>
</html>