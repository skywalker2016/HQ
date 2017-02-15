<?php
session_start();
include ("accesso_db.php");

if ($permission == NULL)
	header("Location:errore.html");
	
include ("convertitore_date.php");
include ("function_php/try_format_date.php");
require_once('class/class.patient.php');
require_once('class/class.rm_bold.php');
require_once('class/class.dataExamInsert.php');

// Funzione che libera tutte le sessioni: -----------------------------------------------------
function delete_session()
{
	$_SESSION['data_inserimento_rm_bold'] = NULL;
	$_SESSION['flag_aggiorna'] = NULL;

	$_SESSION['sede1'] = NULL;			
	$_SESSION['motorio_anteriore'] = NULL;					
	$_SESSION['motorio_posteriore'] = NULL;				
	$_SESSION['motorio_mediale'] = NULL;		
	$_SESSION['motorio_intralesionale'] = NULL;		
	$_SESSION['motorio_laterale'] = NULL;		
	$_SESSION['motorio_inferiore'] = NULL;		
	$_SESSION['motorio_superiore'] = NULL;		
	$_SESSION['motorio_altro'] = NULL;		
	$_SESSION['sede2'] = NULL;		
	$_SESSION['sensitiva_anteriore'] = NULL;					
	$_SESSION['sensitiva_posteriore'] = NULL;				
	$_SESSION['sensitiva_mediale'] = NULL;		
	$_SESSION['sensitiva_intralesionale'] = NULL;		
	$_SESSION['sensitiva_laterale'] = NULL;		
	$_SESSION['sensitiva_inferiore'] = NULL;		
	$_SESSION['sensitiva_superiore'] = NULL;		
	$_SESSION['sensitiva_altro'] = NULL;		
	$_SESSION['broca'] = NULL;		
	$_SESSION['wernicke'] = NULL;		
	$_SESSION['sensitiva_area_altro']=NULL;	
}
// --------------------------------------------------------------------------------------------

// Funzione che recupera i dati dalle sessioni: -----------------------------------------------------
function recupero_session()
{
	global $data_inserimento_rm_bold;
	global $flag_aggiorna;

	global $sede1;			
	global $motorio_anteriore;					
	global $motorio_posteriore;				
	global $motorio_mediale;		
	global $motorio_intralesionale;		
	global $motorio_laterale;		
	global $motorio_inferiore;		
	global $motorio_superiore;		
	global $motorio_altro;		
	global $sede2;		
	global $sensitiva_anteriore;					
	global $sensitiva_posteriore;				
	global $sensitiva_mediale;		
	global $sensitiva_intralesionale;		
	global $sensitiva_laterale;	
	global $sensitiva_inferiore;		
	global $sensitiva_superiore;		
	global $sensitiva_altro;		
	global $broca;		
	global $wernicke;
	global $sensitiva_area_altro;

	$flag_aggiorna = $_SESSION['flag_aggiorna'];
	$data_inserimento_rm_bold = $_SESSION['data_inserimento_rm_bold'];

	$sede1=$_SESSION['sede1'];			
	$motorio_anteriore=$_SESSION['motorio_anteriore'];					
	$motorio_posteriore=$_SESSION['motorio_posteriore'];				
	$motorio_mediale=$_SESSION['motorio_mediale'];		
	$motorio_intralesionale=$_SESSION['motorio_intralesionale'];		
	$motorio_laterale=$_SESSION['motorio_laterale'];		
	$motorio_inferiore=$_SESSION['motorio_inferiore'];		
	$motorio_superiore=$_SESSION['motorio_superiore'];		
	$motorio_altro=$_SESSION['motorio_altro'];		
	$sede2=$_SESSION['sede2'];		
	$sensitiva_anteriore=$_SESSION['sensitiva_anteriore'];					
	$sensitiva_posteriore=$_SESSION['sensitiva_posteriore'];				
	$sensitiva_mediale=$_SESSION['sensitiva_mediale'];		
	$sensitiva_intralesionale=$_SESSION['sensitiva_intralesionale'];		
	$sensitiva_laterale=$_SESSION['sensitiva_laterale'];	
	$sensitiva_inferiore=$_SESSION['sensitiva_inferiore'];		
	$sensitiva_superiore=$_SESSION['sensitiva_superiore'];		
	$sensitiva_altro=$_SESSION['sensitiva_altro'];		
	$broca=$_SESSION['broca'];		
	$wernicke=$_SESSION['wernicke'];
	$sensitiva_area_altro=$_SESSION['sensitiva_area_altro'];			
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
	$id_rm_bold = $_REQUEST['id_rm_bold'];
	$_SESSION['id_paziente'] = $id_paziente;
	$_SESSION['id_rm_bold'] = $id_rm_bold;		

	// recupera i dati dal database:	
	$rm_bold = new rm_bold($id_paziente, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL ,NULL ,NULL, NULL, NULL, NULL, NULL, NULL);
	$rm_bold->retrive_by_id($id_rm_bold);
	$data_inserimento_rm_bold = $rm_bold->getData_inserimento();
	$data_inserimento_rm_bold = data_convert_for_utente($data_inserimento_rm_bold);

	$sede1=$rm_bold->getMotorio_sede();
	$motorio_anteriore=$rm_bold->getMotorio_anteriore();
	$motorio_posteriore=$rm_bold->getMotorio_posteriore();
	$motorio_mediale=$rm_bold->getMotorio_mediale();
	$motorio_intralesionale=$rm_bold->getMotorio_intralesionale();
	$motorio_laterale=$rm_bold->getMotorio_laterale();
	$motorio_inferiore=$rm_bold->getMotorio_inferiore();
	$motorio_superiore=$rm_bold->getMotorio_superiore();
	$motorio_altro=$rm_bold->getMotorio_altro();
	$sede2=$rm_bold->getSensitiva_sede();
	$sensitiva_anteriore=$rm_bold->getSensitiva_anteriore();
	$sensitiva_posteriore=$rm_bold->getSensitiva_posteriore();
	$sensitiva_mediale=$rm_bold->getSensitiva_mediale();
	$sensitiva_intralesionale=$rm_bold->getSensitiva_intralesionale();
	$sensitiva_laterale=$rm_bold->getSensitiva_laterale();
	$sensitiva_inferiore=$rm_bold->getSensitiva_inferiore();
	$sensitiva_superiore=$rm_bold->getSensitiva_superiore();
	$sensitiva_altro=$rm_bold->getSensitiva_altro();
	$broca=$rm_bold->getLinguaggio_broca();
	$wernicke=$rm_bold->getLinguaggio_wermicke();


	if (($sede2  != 'mano') || ($sede2 !='piede'))
	{
		$sensitiva_area_altro = $sede2;		
	}

	// registra tutte le sessioni:
	$_SESSION['data_inserimento_rm_bold']=$data_inserimento_rm_bold;
	$_SESSION['sede1']=$sede1;			
	$_SESSION['motorio_anteriore']=$motorio_anteriore;					
	$_SESSION['motorio_posteriore']=$motorio_posteriore;				
	$_SESSION['motorio_mediale']=$motorio_mediale;		
	$_SESSION['motorio_intralesionale']=$motorio_intralesionale;		
	$_SESSION['motorio_laterale']=$motorio_laterale;		
	$_SESSION['motorio_inferiore']=$motorio_inferiore;		
	$_SESSION['motorio_superiore']=$motorio_superiore;		
	$_SESSION['motorio_altro']=$motorio_altro;		
	$_SESSION['sede2']=$sede2;		
	$_SESSION['sensitiva_anteriore']=$sensitiva_anteriore;					
	$_SESSION['sensitiva_posteriore']=$sensitiva_posteriore;				
	$_SESSION['sensitiva_mediale']=$sensitiva_mediale;		
	$_SESSION['sensitiva_intralesionale']=$sensitiva_intralesionale;		
	$_SESSION['sensitiva_laterale']=$sensitiva_laterale;	
	$_SESSION['sensitiva_inferiore']=$sensitiva_inferiore;		
	$_SESSION['sensitiva_superiore']=$sensitiva_superiore;		
	$_SESSION['sensitiva_altro']=$sensitiva_altro;		
	$_SESSION['broca']=$broca;		
	$_SESSION['wernicke']=$wernicke;
	$_SESSION['sensitiva_area_altro']=$sensitiva_area_altro;

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

	$rm_bold = new rm_bold($id_paziente, $sede1, $motorio_anteriore, $motorio_posteriore, $motorio_mediale, $motorio_intralesionale,$motorio_laterale ,$motorio_inferiore, $motorio_superiore, $motorio_altro, $sede2, $sensitiva_anteriore, $sensitiva_posteriore, $sensitiva_mediale, $sensitiva_intralesionale ,$sensitiva_laterale ,$sensitiva_inferiore, $sensitiva_superiore, $sensitiva_altro, $broca, $wernicke, $sensitiva_area_altro);
	
	$errore_data_inserimento_rm_bold=controllo_data($data_inserimento_rm_bold);

	if ($errore_data_inserimento_rm_bold == 1);
	else
	{
		$data_inserimento_rm_bold1=data_convert_for_mysql($data_inserimento_rm_bold);
		$rm_bold -> setData_inserimento($data_inserimento_rm_bold1);
		$rm_bold->insert();
	
	$pagina = 20;
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

	$id_rm_bold = $_SESSION['id_rm_bold'];

	$rm_bold = new rm_bold(NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL ,NULL ,NULL, NULL, NULL, NULL, NULL, NULL);

	// controlla la data:
	$errore_data_inserimento_rm_bold=controllo_data($data_inserimento_rm_bold);

	if ($errore_data_inserimento_rm_bold == 1);
	else
	{
		$data_inserimento_rm_bold=data_convert_for_mysql($data_inserimento_rm_bold);
	
		if ($area_sensitiva_altro != NULL)
		{
			$sede2 = $area_sensitiva_altro;
		}
	
		$query= "UPDATE rm_bold SET
				data_inserimento = '$data_inserimento_rm_bold',
				motorio_sede =	'$sede1',
				motorio_anteriore =	'$motorio_anteriore',
				motorio_posteriore = '$motorio_posteriore',	
				motorio_mediale	= '$motorio_mediale',
				motorio_intralesionale = '$motorio_intralesionale',	
				motorio_laterale = '$motorio_laterale',	
				motorio_inferiore =	'$motorio_inferiore',
				motorio_superiore =	'$motorio_superiore',
				motorio_altro =	'$motorio_altro',
				sensitiva_sede = '$sede2',	
				sensitiva_anteriore = '$sensitiva_anteriore',	
				sensitiva_posteriore = '$sensitiva_posteriore',	
				sensitiva_mediale =	'$sensitiva_mediale',
				sensitiva_intralesionale = '$sensitiva_intralesionale',	
				sensitiva_laterale = '$sensitiva_laterale',	
				sensitiva_inferiore	= '$sensitiva_inferiore',
				sensitiva_superiore	= '$sensitiva_superiore',
				sensitiva_altro	= '$sensitiva_altro',
				linguaggio_broca = '$broca',	
				linguaggio_wernicke	= '$wernicke'
		WHERE id = '$id_rm_bold' ";
		 $rs2 = mysql_query($query);	
	
		$pagina = 20;
		include ("log.php");
		
		$data_inserimento_rm_bold=data_convert_for_utente($data_inserimento_rm_bold);	
	
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
		if ($_REQUEST['data_inserimento_rm_bold'])
			$_SESSION['data_inserimento_rm_bold'] = $_REQUEST['data_inserimento_rm_bold'];	
		else;
		$data_inserimento_rm_bold = $_SESSION['data_inserimento_rm_bold'];
		// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		
		
		// ++++++++ RM BOLD +++++++++++++++++++++++++++++++++++++++++++++++++++++++		
		if ($_REQUEST['sede1']) // for Motoria
			$_SESSION['sede1'] = $_REQUEST['sede1'];
		else;
		$sede1 = $_SESSION['sede1'];	
			 
		if ($_REQUEST['sede2']) // For Sensitiva
		{
			$_SESSION['sede2'] = $_REQUEST['sede2'];
			$sensitiva_area_altro = NULL;
			$_SESSION['sensitiva_area_altro'] = $sensitiva_area_altro;
		}
		else;
		$sede2 = $_SESSION['sede2'];		
						
		if ($_REQUEST['sensitiva_area_altro']) // For Sensitiva valore altro
		{
			$_SESSION['sensitiva_area_altro'] = $_REQUEST['sensitiva_area_altro'];
			$sede2 = $_REQUEST['sensitiva_area_altro'];
			$_SESSION['sede2'] = $sede2;
		}
		else;
		$sensitiva_area_altro = $_SESSION['sensitiva_area_altro'];				
			
		if ($_REQUEST['sensitiva_area_altro'] == 'NULL')
		{	
			$sensitiva_area_altro=NULL;
			$_SESSION['sensitiva_area_altro']=$sensitiva_area_altro;
		}
						
		// ** List of motoria_sede variables ********	
		if ($_REQUEST['motorio_anteriore'] == 'on')
			$_SESSION['motorio_anteriore'] = $_REQUEST['motorio_anteriore'];
		else if	($_REQUEST['motorio_anteriore'] == 'off')
				$_SESSION['motorio_anteriore'] = NULL;		
		else;
		$motorio_anteriore = $_SESSION['motorio_anteriore'];		
			
		if ($_REQUEST['motorio_posteriore'] == 'on')
			$_SESSION['motorio_posteriore'] = $_REQUEST['motorio_posteriore'];
		else if	($_REQUEST['motorio_posteriore'] == 'off')
				$_SESSION['motorio_posteriore'] = NULL;		
		else;
		$motorio_posteriore = $_SESSION['motorio_posteriore'];		
			
		if ($_REQUEST['motorio_mediale'] == 'on')
			$_SESSION['motorio_mediale'] = $_REQUEST['motorio_mediale'];
		else if	($_REQUEST['motorio_mediale'] == 'off')
				$_SESSION['motorio_mediale'] = NULL;		
		else;
		$motorio_mediale = $_SESSION['motorio_mediale'];	
	
		if ($_REQUEST['motorio_intralesionale'] == 'on')
			$_SESSION['motorio_intralesionale'] = $_REQUEST['motorio_intralesionale'];
		else if	($_REQUEST['motorio_intralesionale'] == 'off')
				$_SESSION['motorio_intralesionale'] = NULL;		
		else;
		$motorio_intralesionale = $_SESSION['motorio_intralesionale'];	
	
		if ($_REQUEST['motorio_laterale'] == 'on')
			$_SESSION['motorio_laterale'] = $_REQUEST['motorio_laterale'];
		else if	($_REQUEST['motorio_laterale'] == 'off')
				$_SESSION['motorio_laterale'] = NULL;		
		else;
		$motorio_laterale = $_SESSION['motorio_laterale'];	
		
		if ($_REQUEST['motorio_inferiore'] == 'on')
			$_SESSION['motorio_inferiore'] = $_REQUEST['motorio_inferiore'];
		else if	($_REQUEST['motorio_inferiore'] == 'off')
				$_SESSION['motorio_inferiore'] = NULL;		
		else;
		$motorio_inferiore = $_SESSION['motorio_inferiore'];			
			
		if ($_REQUEST['motorio_superiore'] == 'on')
			$_SESSION['motorio_superiore'] = $_REQUEST['motorio_superiore'];
		else if	($_REQUEST['motorio_superiore'] == 'off')
				$_SESSION['motorio_superiore'] = NULL;		
		else;
		$motorio_superiore = $_SESSION['motorio_superiore'];	
		
		if ($_REQUEST['motorio_altro'])
			$_SESSION['motorio_altro'] = $_REQUEST['motorio_altro'];			
		else;
		$motorio_altro = $_SESSION['motorio_altro'];		
		if ($_REQUEST['motorio_altro'] == "NULL")
			$_SESSION['motorio_altro'] = NULL;
		$motorio_altro = $_SESSION['motorio_altro'];		
			
			
		// ** List of sensitiva_sede variables ********			
		if ($_REQUEST['sensitiva_anteriore'] == 'on')
			$_SESSION['sensitiva_anteriore'] = $_REQUEST['sensitiva_anteriore'];
		else if	($_REQUEST['sensitiva_anteriore'] == 'off')
				$_SESSION['sensitiva_anteriore'] = NULL;		
		else;
		$sensitiva_anteriore = $_SESSION['sensitiva_anteriore'];		
			
		if ($_REQUEST['sensitiva_posteriore'] == 'on')
			$_SESSION['sensitiva_posteriore'] = $_REQUEST['sensitiva_posteriore'];
		else if	($_REQUEST['sensitiva_posteriore'] == 'off')
				$_SESSION['sensitiva_posteriore'] = NULL;		
		else;
		$sensitiva_posteriore = $_SESSION['sensitiva_posteriore'];		
			
		if ($_REQUEST['sensitiva_mediale'] == 'on')
			$_SESSION['sensitiva_mediale'] = $_REQUEST['sensitiva_mediale'];
		else if	($_REQUEST['sensitiva_mediale'] == 'off')
				$_SESSION['sensitiva_mediale'] = NULL;		
		else;
		$sensitiva_mediale = $_SESSION['sensitiva_mediale'];	
	
		if ($_REQUEST['sensitiva_intralesionale'] == 'on')
			$_SESSION['sensitiva_intralesionale'] = $_REQUEST['sensitiva_intralesionale'];
		else if	($_REQUEST['sensitiva_intralesionale'] == 'off')
				$_SESSION['sensitiva_intralesionale'] = NULL;		
		else;
		$sensitiva_intralesionale = $_SESSION['sensitiva_intralesionale'];	
	
		if ($_REQUEST['sensitiva_laterale'] == 'on')
			$_SESSION['sensitiva_laterale'] = $_REQUEST['sensitiva_laterale'];
		else if	($_REQUEST['sensitiva_laterale'] == 'off')
				$_SESSION['sensitiva_laterale'] = NULL;		
		else;
		$sensitiva_laterale = $_SESSION['sensitiva_laterale'];	
		
		if ($_REQUEST['sensitiva_inferiore'] == 'on')
			$_SESSION['sensitiva_inferiore'] = $_REQUEST['sensitiva_inferiore'];
		else if	($_REQUEST['sensitiva_inferiore'] == 'off')
				$_SESSION['sensitiva_inferiore'] = NULL;		
		else;
		$sensitiva_inferiore = $_SESSION['sensitiva_inferiore'];			
			
		if ($_REQUEST['sensitiva_superiore'] == 'on')
			$_SESSION['sensitiva_superiore'] = $_REQUEST['sensitiva_superiore'];
		else if	($_REQUEST['sensitiva_superiore'] == 'off')
				$_SESSION['sensitiva_superiore'] = NULL;		
		else;
		$sensitiva_superiore = $_SESSION['sensitiva_superiore'];		
			
		if ($_REQUEST['sensitiva_altro'])
			$_SESSION['sensitiva_altro'] = $_REQUEST['sensitiva_altro'];			
		else;
		$sensitiva_altro = $_SESSION['sensitiva_altro'];		
		if ($_REQUEST['sensitiva_altro'] == "NULL")
			$_SESSION['sensitiva_altro'] = NULL;			
				
		$sensitiva_altro = $_SESSION['sensitiva_altro'];
	
		// ** Linguaggio **************************
		if ($_REQUEST['broca'] == 'on')
			$_SESSION['broca'] = $_REQUEST['broca'];
		else if	($_REQUEST['broca'] == 'off')
				$_SESSION['broca'] = NULL;		
		else;
		$broca = $_SESSION['broca'];			
			
		if ($_REQUEST['wernicke'] == 'on')
			$_SESSION['wernicke'] = $_REQUEST['wernicke'];
		else if	($_REQUEST['wernicke'] == 'off')
				$_SESSION['wernicke'] = NULL;		
		else;
		$wernicke = $_SESSION['wernicke'];	
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
	var data = document.esame.data_inserimento_rm_bold.value;

	var destination_page = "nuovo_rm_bold.php";
	location.href = destination_page+"?data_inserimento_rm_bold="+data;	
}

function sensitiva_area_altro_function()
{

	var valore_sensitiva_area_altro = document.esame.sensitiva_area_altro.value;

	if (valore_sensitiva_area_altro == "")
		valore_sensitiva_area_altro = "NULL";

	var destination_page = "nuovo_rm_bold.php";
			
	location.href = destination_page+"?sensitiva_area_altro="+valore_sensitiva_area_altro;	
}

function motorio_altro_function()
{
	var valore_motorio_altro = document.esame.motorio_altro.value;

	if (valore_motorio_altro == "")
		valore_motorio_altro = "NULL";

	var destination_page = "nuovo_rm_bold.php";
			
	location.href = destination_page+"?motorio_altro="+valore_motorio_altro;	
}

function sensitiva_altro_function()
{
	var valore_sensitiva_altro = document.esame.sensitiva_altro.value;

	if (valore_sensitiva_altro == "")
		valore_sensitiva_altro = "NULL";

	var destination_page = "nuovo_rm_bold.php";
			
	location.href = destination_page+"?sensitiva_altro="+valore_sensitiva_altro;	
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
<font face="Verdana, Arial, Helvetica, sans-serif" color="#FFFFCC" size='2'>The data will be inserted in the database only when you see the confirm and when you see the tab 'CLOSE' <br /></font>
<br /><br />
<font id="font2">
RM BOLD</font>
<br /><br />
<form action="nuovo_rm_bold.php" method="post" name='esame'>

<table border="0" width="60%" cellspacing="3">
	<tr>
		<td width="25%" align="center" bgcolor="#CACACA">
		<font face="Verdana, Arial, Helvetica, sans-serif" size="2">Surname</font>
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

<table border="0" width="53%" cellpadding="0" cellspacing="0">
	<tr>
		<td width="39%" align="right" id='font3'>Date &nbsp;</td>
		<td width="61%" align="left">		
		<?php
		if ($errore_data_inserimento_rm_bold == 1)
			print ("<input type='text' name='data_inserimento_rm_bold' value='$data_inserimento_rm_bold' size='20' id='form1_A' onchange=\"data_inserimento()\" />");
		else
			if (($permission == 3) || ($ok_inserimento == 1))
				print ("<font face='Verdana, Arial, Helvetica, sans-serif' size='3' color='#2ECCFA'>$data_inserimento_rm_bold</font>");
			else
				print ("<input type='text' name='data_inserimento_rm_bold' value='$data_inserimento_rm_bold' size='20' id='form1' onchange=\"data_inserimento()\" />");
		?>	
		<font id='font4'>(gg/mm/aaaa)</font>
		</td>	
	</tr>
</table>	
<br />

<?php // TABELLA RM BOLD ***************************************************************************************************************
// ************************************************************************************************************************************* 
$langhezza_table = '65%';
?>

<?php // MOTORIA ++++++++++++++++++++++++++++++++++++++++++++++++ ?>
<table border="0" width="65%" cellpadding="0" cellspacing="0">
	<tr>
		<td width="45%" align="left" bgcolor="#618EC0"><font face="Verdana, Arial, Helvetica, sans-serif" color='#333333' size='4'><strong>MOTOR TEST</font></strong> </font></td>
		<td width="55%" align="left" bgcolor="#618EC0"></td>
	</tr>
</table>

<table border="0" width="<?php print $langhezza_table; ?>" cellpadding="1" cellspacing="2">
	<tr>
		<td width="20%" align="right"><font id="font3_A">Activation area</font>&nbsp;</td>
		<td width="80%" align="left" id='form1'><font id='font9_A'>Site: &nbsp; &nbsp;</font>
<?php
if (($permission == 3) || ($ok_inserimento == 1))
{
	if ($sede1 == 'mano')
		$sede1 = 'Hand';
	else
		$sede1 = 'Foot';	

	print "<font id='font20'>".ucfirst($sede1)."</font>";		
}
else
{
			if ($sede1 == 'mano')
			{
				print ("<input type='radio' name='sede1' value='mano' onClick=\"javascript:location.href='nuovo_rm_bold.php?sede1=mano'\" checked='checked'/><font id='font9_A'> Hand</font> &nbsp;");
				print ("<input type='radio' name='sede1' value='piede' onClick=\"javascript:location.href='nuovo_rm_bold.php?sede1=piede'\"/><font id='font9_A'> Foot</font> &nbsp;");
			}
			else if ($sede1 == 'piede')
			{
				print ("<input type='radio' name='sede1' value='mano' onClick=\"javascript:location.href='nuovo_rm_bold.php?sede1=mano' \"/><font id='font9_A'> Hand</font> &nbsp;");
				print ("<input type='radio' name='sede1' value='piede' onClick=\"javascript:location.href='nuovo_rm_bold.php?sede1=piede'\" checked='checked'/><font id='font9_A'> Foot</font> &nbsp;");
			}		
			else
			{
				print ("<input type='radio' name='sede1' value='mano' onClick=\"javascript:location.href='nuovo_rm_bold.php?sede1=mano'\"/><font id='font9_A'> Hand</font> &nbsp;");
				print ("<input type='radio' name='sede1' value='piede' onClick=\"javascript:location.href='nuovo_rm_bold.php?sede1=piede'\"/><font id='font9_A'> Foot</font> &nbsp;");
			}			
}
?>		
		</td>
	</tr>
	
	<tr>
		<td width="20%" align="right"></td>
		<td width="80%" align="left" id='form1'>
		<?php
if (($permission == 3) || ($ok_inserimento == 1))
{
	if ($motorio_anteriore == 'on')	
		print ("<font id='font20'>Front </font><br>");
	if ($motorio_posteriore == 'on')	
		print ("<font id='font20'>Rearward </font><br>");
	if ($motorio_mediale == 'on')	
		print ("<font id='font20'>Medial </font><br>");		
	if ($motorio_intralesionale == 'on')	
		print ("<font id='font20'>Intralesional </font><br>");		
	if ($motorio_laterale == 'on')		
		print ("<font id='font20'>Lateral </font><br>");			
	if ($motorio_inferiore == 'on')		
		print ("<font id='font20'>Lower </font><br>");		
	if ($motorio_superiore == 'on')		
		print ("<font id='font20'>Upper </font><br>");				
	if ($motorio_altro != NULL)		
		print "<font id='font20'>".ucfirst($motorio_altro)."</font><br>";					
}
else
{		
		if ($motorio_anteriore == 'on')	
			print ("<input type='checkbox' name='motorio_anteriore' value='$motorio_anteriore' onClick=\"javascript:location.href='nuovo_rm_bold.php?motorio_anteriore=off'\" checked='cheched'/><font id='font9_A'>Front &nbsp; &nbsp;</font> ");
		else	
			print ("<input type='checkbox' name='motorio_anteriore' value='$motorio_anteriore' onClick=\"javascript:location.href='nuovo_rm_bold.php?motorio_anteriore=on'\"/><font id='font9_A'>Front &nbsp; &nbsp;</font> ");			
			
		if ($motorio_posteriore == 'on')	
			print ("<input type='checkbox' name='motorio_posteriore' value='$motorio_posteriore' onClick=\"javascript:location.href='nuovo_rm_bold.php?motorio_posteriore=off'\" checked='cheched'/><font id='font9_A'>	
Rearward &nbsp; &nbsp;</font> ");
		else	
			print ("<input type='checkbox' name='motorio_posteriore' value='$motorio_posteriore' onClick=\"javascript:location.href='nuovo_rm_bold.php?motorio_posteriore=on'\"/><font id='font9_A'>	
Rearward &nbsp; &nbsp;</font> ");					
			
		if ($motorio_mediale == 'on')	
			print ("<input type='checkbox' name='motorio_mediale' value='$motorio_mediale' onClick=\"javascript:location.href='nuovo_rm_bold.php?motorio_mediale=off'\" checked='cheched'/><font id='font9_A'>Medial &nbsp; &nbsp;</font> ");
		else	
			print ("<input type='checkbox' name='motorio_mediale' value='$motorio_mediale' onClick=\"javascript:location.href='nuovo_rm_bold.php?motorio_mediale=on'\"/><font id='font9_A'>Medial &nbsp; &nbsp;</font> ");				
			
		if ($motorio_intralesionale == 'on')	
			print ("<input type='checkbox' name='motorio_intralesionale' value='$motorio_intralesionale' onClick=\"javascript:location.href='nuovo_rm_bold.php?motorio_intralesionale=off'\" checked='cheched'/><font id='font9_A'>Intralesional &nbsp; &nbsp;</font> ");
		else	
			print ("<input type='checkbox' name='motorio_intralesionale' value='$motorio_intralesionale' onClick=\"javascript:location.href='nuovo_rm_bold.php?motorio_intralesionale=on'\"/><font id='font9_A'>Intralesional &nbsp; &nbsp;</font> ");				

		if ($motorio_laterale == 'on')	
			print ("<input type='checkbox' name='motorio_laterale' value='$motorio_laterale' onClick=\"javascript:location.href='nuovo_rm_bold.php?motorio_laterale=off'\" checked='cheched'/><font id='font9_A'>Lateral &nbsp; &nbsp;</font> ");
		else	
			print ("<input type='checkbox' name='motorio_laterale' value='$motorio_laterale' onClick=\"javascript:location.href='nuovo_rm_bold.php?motorio_laterale=on'\"/><font id='font9_A'>Lateral &nbsp; &nbsp;</font> ");				
}			
		?>
		</td>
	</tr>
	<tr>
		<td width="20%" align="right"></td>
		<td width="80%" align="left" id='form1'>
		<?php
if (($permission == 3) || ($ok_inserimento == 1));
else
{	
		if ($motorio_inferiore == 'on')	
			print ("<input type='checkbox' name='motorio_inferiore' value='$motorio_inferiore' onClick=\"javascript:location.href='nuovo_rm_bold.php?motorio_inferiore=off'\" checked='cheched'/><font id='font9_A'>Lower &nbsp;&nbsp;</font> ");
		else	
			print ("<input type='checkbox' name='motorio_inferiore' value='$motorio_inferiore' onClick=\"javascript:location.href='nuovo_rm_bold.php?motorio_inferiore=on'\"/><font id='font9_A'>Lower &nbsp; &nbsp;</font> ");			
		
		if ($motorio_superiore == 'on')	
			print ("<input type='checkbox' name='motorio_superiore' value='$motorio_superiore' onClick=\"javascript:location.href='nuovo_rm_bold.php?motorio_superiore=off'\" checked='cheched'/><font id='font9_A'>Upper &nbsp; &nbsp;</font> ");
		else	
			print ("<input type='checkbox' name='motorio_superiore' value='$motorio_superiore' onClick=\"javascript:location.href='nuovo_rm_bold.php?motorio_superiore=on'\"/><font id='font9_A'>Upper&nbsp; &nbsp;</font> ");			
				
		print ("<font id='font9_A'>Other </font> <input type='text' name='motorio_altro' value='$motorio_altro' size='30' onchange='motorio_altro_function()'/> ");
}						
		?>
		</td>
	</tr>	
</table>

<?php // SENSITIVA ++++++++++++++++++++++++++++++++++++++++++++++++ ?>
<table border="0" width="65%" cellpadding="0" cellspacing="0">
	<tr>
		<td width="45%" align="left" bgcolor="#618EC0"><font face="Verdana, Arial, Helvetica, sans-serif" color='#333333' size='4'><strong>SENSORY TEST</font></strong> </font></td>
		<td width="55%" align="left" bgcolor="#618EC0"></td>
	</tr>
</table>

<table border="0" width="<?php print $langhezza_table; ?>" cellpadding="1" cellspacing="2">
	<tr>
		<td width="20%" align="right"><font id="font3_A">Activation area</font>&nbsp;</td>
		<td width="80%" align="left" id='form1'><font id='font9_A'>Side: &nbsp; &nbsp;</font>
<?php
if (($permission == 3) || ($ok_inserimento == 1))
{
	if ($sede2 == 'mano')
		$sede2_a = 'Hand';
	if ($sede2 == 'piede')
		$sede2_a = 'Foot';	
		
	print "<font id='font20'>".ucfirst($sede2_a)."</font>";		
}
else
{
		if ($sede2 == 'mano')
		{
			print ("<input type='radio' name='sede2' value='mano' onClick=\"javascript:location.href='nuovo_rm_bold.php?sede2=mano'\" checked='checked'/><font id='font9_A'> Hand</font> &nbsp;");
			print ("<input type='radio' name='sede2' value='piede' onClick=\"javascript:location.href='nuovo_rm_bold.php?sede2=piede'\"/><font id='font9_A'> Foot</font> &nbsp;");
		}
		else if ($sede2 == 'piede')
		{
			print ("<input type='radio' name='sede2' value='mano' onClick=\"javascript:location.href='nuovo_rm_bold.php?sede2=mano' \"/><font id='font9_A'> Hand</font> &nbsp;");
			print ("<input type='radio' name='sede2' value='piede' onClick=\"javascript:location.href='nuovo_rm_bold.php?sede2=piede'\" checked='checked'/><font id='font9_A'> Foot</font> &nbsp;");
		}		
		else
		{
			print ("<input type='radio' name='sede2' value='mano' onClick=\"javascript:location.href='nuovo_rm_bold.php?sede2=mano'\"/><font id='font9_A'> Hand</font> &nbsp;");
			print ("<input type='radio' name='sede2' value='piede' onClick=\"javascript:location.href='nuovo_rm_bold.php?sede2=piede'\"/><font id='font9_A'> Foot</font> &nbsp;");
		}			
}
?>		
		<?php
		if (($permission == 3) || ($ok_inserimento == 1));
		else
		{
			if 	(($sensitiva_area_altro == 'mano') || ($sensitiva_area_altro == 'piede'))
				$sensitiva_area_altro = ' ';
				
		?>		
			&nbsp; &nbsp; &nbsp; <font id='font9_A'> Other: </font>
			 <input type='text'  name='sensitiva_area_altro' value='<?php print $sensitiva_area_altro; ?>' size='20' onchange="sensitiva_area_altro_function()"/>
		<?php
		}
		?>
		</td>
	</tr>
	<tr>
		<td width="20%" align="right"></td>
		<td width="80%" align="left" id='form1'>
		<?php
if (($permission == 3) || ($ok_inserimento == 1))
{
	if ($sensitiva_anteriore == 'on')	
		print ("<font id='font20'>Front </font><br>");
	if ($sensitiva_posteriore == 'on')	
		print ("<font id='font20'>Rearward </font><br>");
	if ($sensitiva_mediale == 'on')	
		print ("<font id='font20'>Medial </font><br>");		
	if ($sensitiva_intralesionale == 'on')	
		print ("<font id='font20'>Intralesional </font><br>");		
	if ($sensitiva_laterale == 'on')		
		print ("<font id='font20'>Lateral </font><br>");			
	if ($sensitiva_inferiore == 'on')		
		print ("<font id='font20'>Lower </font><br>");		
	if ($sensitiva_superiore == 'on')		
		print ("<font id='font20'>Upper </font><br>");				
	if ($sensitiva_altro != NULL)		
		print "<font id='font20'>".ucfirst($sensitiva_altro)."</font><br>";					
}
else
{				
		if ($sensitiva_anteriore == 'on')	
			print ("<input type='checkbox' name='sensitiva_anteriore' value='$sensitiva_anteriore' onClick=\"javascript:location.href='nuovo_rm_bold.php?sensitiva_anteriore=off'\" checked='cheched'/><font id='font9_A'>Front &nbsp; &nbsp;</font> ");
		else	
			print ("<input type='checkbox' name='sensitiva_anteriore' value='$sensitiva_anteriore' onClick=\"javascript:location.href='nuovo_rm_bold.php?sensitiva_anteriore=on'\"/><font id='font9_A'>Front &nbsp; &nbsp;</font> ");			
			
		if ($sensitiva_posteriore == 'on')	
			print ("<input type='checkbox' name='sensitiva_posteriore' value='$sensitiva_posteriore' onClick=\"javascript:location.href='nuovo_rm_bold.php?sensitiva_posteriore=off'\" checked='cheched'/><font id='font9_A'>Rearward &nbsp; &nbsp;</font> ");
		else	
			print ("<input type='checkbox' name='sensitiva_posteriore' value='$sensitiva_posteriore' onClick=\"javascript:location.href='nuovo_rm_bold.php?sensitiva_posteriore=on'\"/><font id='font9_A'>Rearward &nbsp; &nbsp;</font> ");					
			
		if ($sensitiva_mediale == 'on')	
			print ("<input type='checkbox' name='sensitiva_mediale' value='$sensitiva_mediale' onClick=\"javascript:location.href='nuovo_rm_bold.php?sensitiva_mediale=off'\" checked='cheched'/><font id='font9_A'>Medial &nbsp; &nbsp;</font> ");
		else	
			print ("<input type='checkbox' name='sensitiva_mediale' value='$sensitiva_mediale' onClick=\"javascript:location.href='nuovo_rm_bold.php?sensitiva_mediale=on'\"/><font id='font9_A'>Medial &nbsp; &nbsp;</font> ");				
			
		if ($sensitiva_intralesionale == 'on')	
			print ("<input type='checkbox' name='sensitiva_intralesionale' value='$sensitiva_intralesionale' onClick=\"javascript:location.href='nuovo_rm_bold.php?sensitiva_intralesionale=off'\" checked='cheched'/><font id='font9_A'>Intralesional &nbsp; &nbsp;</font> ");
		else	
			print ("<input type='checkbox' name='sensitiva_intralesionale' value='$sensitiva_intralesionale' onClick=\"javascript:location.href='nuovo_rm_bold.php?sensitiva_intralesionale=on'\"/><font id='font9_A'>Intralesional &nbsp; &nbsp;</font> ");				

		if ($sensitiva_laterale == 'on')	
			print ("<input type='checkbox' name='sensitiva_laterale' value='$sensitiva_laterale' onClick=\"javascript:location.href='nuovo_rm_bold.php?sensitiva_laterale=off'\" checked='cheched'/><font id='font9_A'>Lateral &nbsp; &nbsp;</font> ");
		else	
			print ("<input type='checkbox' name='sensitiva_laterale' value='$sensitiva_laterale' onClick=\"javascript:location.href='nuovo_rm_bold.php?sensitiva_laterale=on'\"/><font id='font9_A'>Lateral&nbsp; &nbsp;</font> ");				
}		
		?>
		</td>
	</tr>
	<tr>
		<td width="20%" align="right"></td>
		<td width="80%" align="left" id='form1'>
		<?php
if (($permission == 3) || ($ok_inserimento == 1));		
else
{		
		if ($sensitiva_inferiore == 'on')	
			print ("<input type='checkbox' name='sensitiva_inferiore' value='$sensitiva_inferiore' onClick=\"javascript:location.href='nuovo_rm_bold.php?sensitiva_inferiore=off'\" checked='cheched'/><font id='font9_A'>Lower &nbsp;&nbsp;</font> ");
		else	
			print ("<input type='checkbox' name='sensitiva_inferiore' value='$sensitiva_inferiore' onClick=\"javascript:location.href='nuovo_rm_bold.php?sensitiva_inferiore=on'\"/><font id='font9_A'>Lower&nbsp; &nbsp;</font> ");			
		
		if ($sensitiva_superiore == 'on')	
			print ("<input type='checkbox' name='sensitiva_superiore' value='$sensitiva_superiore' onClick=\"javascript:location.href='nuovo_rm_bold.php?sensitiva_superiore=off'\" checked='cheched'/><font id='font9_A'>Upper &nbsp; &nbsp;</font> ");
		else	
			print ("<input type='checkbox' name='sensitiva_superiore' value='$sensitiva_superiore' onClick=\"javascript:location.href='nuovo_rm_bold.php?sensitiva_superiore=on'\"/><font id='font9_A'>Upper&nbsp; &nbsp;</font> ");			
								
		print ("<font id='font9_A'>Other </font> <input type='text' name='sensitiva_altro' value='$sensitiva_altro' size='30' onchange='sensitiva_altro_function()'/> ");				
}
		?>
		</td>
	</tr>	
</table>

<?php // LINGUAGGIO ++++++++++++++++++++++++++++++++++++++++++++++++ ?>
<table border="0" width="65%" cellpadding="0" cellspacing="0">
	<tr>
		<td width="45%" align="left" bgcolor="#618EC0"><font face="Verdana, Arial, Helvetica, sans-serif" color='#333333' size='4'><strong>LANGUAGE TEST</font></strong> </font></td>
		<td width="55%" align="left" bgcolor="#618EC0"></td>
	</tr>
</table>

<table border="0" width="<?php print $langhezza_table; ?>" cellpadding="1" cellspacing="2">
	<tr>
		<td width="20%" align="right"></td>
		<td width="80%" align="left" id='form1'>
		<?php
if (($permission == 3) || ($ok_inserimento == 1))		
{
	if ($broca == 'on')
		print ("<font id='font20'>Broca activation </font><br>");	
	if ($wernicke == 'on')	
		print ("<font id='font20'>Wernicke activation </font><br>");
}
else
{		
		if ($broca == 'on')	
			print ("<input type='checkbox' name='broca' value='$broca' onClick=\"javascript:location.href='nuovo_rm_bold.php?broca=off'\" checked='cheched'/><font id='font9_A'>Broca activation</font> ");
		else	
			print ("<input type='checkbox' name='broca' value='$broca' onClick=\"javascript:location.href='nuovo_rm_bold.php?broca=on'\"/><font id='font9_A'>Broca activation</font> ");	
			
		print ("<br>");	
			
		if ($wernicke == 'on')	
					print ("<input type='checkbox' name='wernicke' value='$wernicke' onClick=\"javascript:location.href='nuovo_rm_bold.php?wernicke=off'\" checked='cheched'/><font id='font9_A'>Wernicke activation</font> ");
				else	
					print ("<input type='checkbox' name='wernicke' value='$wernicke' onClick=\"javascript:location.href='nuovo_rm_bold.php?wernicke=on'\"/><font id='font9_A'>Wernicke activation</font> ");					
}		
		?>
		</td>
	</tr>
</table>
<?php // FINE TABELLA RM BOLD ***********************************************************************************************************
// ************************************************************************************************************************************* ?>

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
	if ($errore_data_inserimento_rm_bold == 1)
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