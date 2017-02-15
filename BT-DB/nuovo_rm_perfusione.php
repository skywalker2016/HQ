<?php
session_start();
include ("accesso_db.php");

if ($permission == NULL)
	header("Location:errore.html");
	
include ("convertitore_date.php");
include ("function_php/try_format_date.php");
require_once('class/class.patient.php');
require_once('class/class.rm_perfusione.php');
require_once('class/class.dataExamInsert.php');


// Funzione che libera tutte le sessioni: -----------------------------------------------------
function delete_session()
{
	$_SESSION['data_inserimento_rm_perfusione'] = NULL;
	$_SESSION['r_cbv'] = NULL;
	$_SESSION['valore_r_cbv'] = NULL;
	$_SESSION['flag_aggiorna'] = NULL;
}
// --------------------------------------------------------------------------------------------

// Funzione che recupera i dati dalle sessioni: -----------------------------------------------------
function recupero_session()
{
	global $data_inserimento_rm_perfusione;
	global $r_cbv;
	global $valore_r_cbv;
	global $flag_aggiorna;

	$flag_aggiorna = $_SESSION['flag_aggiorna'];
	$data_inserimento_rm_perfusione = $_SESSION['data_inserimento_rm_perfusione'];
	$r_cbv=$_SESSION['r_cbv'];
	$valore_r_cbv=$_SESSION['valore_r_cbv'];	
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
	$id_rm_perfusione = $_REQUEST['id_rm_perfusione'];
	$_SESSION['id_paziente'] = $id_paziente;
	$_SESSION['id_rm_perfusione'] = $id_rm_perfusione;	

	// recupera i dati dal database:
	
	$perfusione = new rm_perfusione ($id_paziente, NULL, NULL, NULL);
	$perfusione->retrive_by_id($id_rm_perfusione);
	$data_inserimento_rm_perfusione = $perfusione->getData_inserimento();
	$data_inserimento_rm_perfusione = data_convert_for_utente($data_inserimento_rm_perfusione);
	$r_cbv = $perfusione->getR_cbv();
	$valore_r_cbv = $perfusione->getValore_r_cbv();
		
	if ($valore_r_cbv == -1000)
		$valore_r_cbv = NULL;
		
	// registra tutte le sessioni:
	$_SESSION['data_inserimento_rm_perfusione'] = $data_inserimento_rm_perfusione;
	$_SESSION['r_cbv'] = $r_cbv;
	$_SESSION['valore_r_cbv'] = $valore_r_cbv;

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

	$rm_perfusione = new rm_perfusione($id_paziente, NULL, $r_cbv, $valore_r_cbv);
	$errore_data_inserimento_rm_perfusione = controllo_data($data_inserimento_rm_perfusione);

	if ($errore_data_inserimento_rm_perfusione == 1);
	else
	{
		$data_inserimento_rm_perfusione1=data_convert_for_mysql($data_inserimento_rm_perfusione);
		$rm_perfusione -> setData_inserimento($data_inserimento_rm_perfusione1);
		$rm_perfusione->insert();
		
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

	$id_rm_perfusione = $_SESSION['id_rm_perfusione'];
	$perfusione = new rm_perfusione(NULL, NULL, NULL, NULL);

	// controlla la data:
	$errore_data_inserimento_rm_perfusione = controllo_data($data_inserimento_rm_perfusione);


	if ($errore_data_inserimento_rm_perfusione == 1);
	else
	{
		if ($valore_r_cbv == -1000)
			$valore_r_cbv = NULL;
		
		$data_inserimento_rm_perfusione=data_convert_for_mysql($data_inserimento_rm_perfusione);

		$query= "UPDATE rm_perfusione SET
				r_cbv = '$r_cbv',
				valore_r_cbv = '$valore_r_cbv',
				data_inserimento = '$data_inserimento_rm_perfusione'
				WHERE id = '$id_rm_perfusione' ";
		 $rs2 = mysql_query($query);	
	
		if ($valore_r_cbv == -1000)
			$valore_r_cbv = NULL;		
			
		$data_inserimento_rm_perfusione=data_convert_for_utente($data_inserimento_rm_perfusione);	
	
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
		if ($_REQUEST['data_inserimento_rm_perfusione'])
			$_SESSION['data_inserimento_rm_perfusione'] = $_REQUEST['data_inserimento_rm_perfusione'];	
		else;
		$data_inserimento_rm_perfusione = $_SESSION['data_inserimento_rm_perfusione'];
		// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		
		// DATA INSERIMENTO R-CBV +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		if ($_REQUEST['r_cbv'])
		{
			$_SESSION['r_cbv'] = $_REQUEST['r_cbv'];		
		}
		else;
		$r_cbv = $_SESSION['r_cbv'];
		
			// Valore:
			if ($_REQUEST['valore_r_cbv'])
				$_SESSION['valore_r_cbv'] = $_REQUEST['valore_r_cbv'];
			else;
			$valore_r_cbv = $_SESSION['valore_r_cbv'];	
			if ($valore_r_cbv == 'NULL')
			{
				$_SESSION['valore_r_cbv'] = NULL;
				$valore_r_cbv = $_SESSION['valore_r_cbv'];
			}
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
	var data = document.esame.data_inserimento_rm_perfusione.value;

	var destination_page = "nuovo_rm_perfusione.php";
	location.href = destination_page+"?data_inserimento_rm_perfusione="+data;	
}

function r_cbv_function()
{
	var valore_r_cbv = document.esame.valore_r_cbv.value;
	
	var destination_page = "nuovo_rm_perfusione.php";
			
	if (!isNaN(valore_r_cbv))	
	{
		if (valore_r_cbv == "")
		valore_r_cbv="NULL";	
			
		location.href = destination_page+"?valore_r_cbv="+valore_r_cbv;	
	}
	else
	{
		location.href = destination_page+"?valore_r_cbv=NULL";	
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
<div id='titolo'>
	<table width="80%" border="0">
		<tr>
			<td width="10%" align="center">
				<img src="images/human-brain.jpg" width="110" />
			</td>
			<td width="80%" align="center">
				<font id='font_titolo'>BRAIN TUMORS DATABASE</font>
			</td>	
			<td width="10%" align="center" valign='bottom'>
				<font face="Georgia, Times New Roman, Times, serif" color="#33FF99" size="2">Version 1.0</font>
			</td>		
		</tr>		
	</table>			
</div>
<hr id='hr1' size='5px'/>
<br />
<font face="Verdana, Arial, Helvetica, sans-serif" color="#FFFFCC" size='2'>The data will be inserted in the database only when you see the confirm and when you see the tab 'CLOSE'</font>
<br />
<br />
<font id="font2">
Perfusion RM</font>
<br /><br />

<form action="nuovo_rm_perfusione.php" method="post" name='esame'>

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
		?>		</font>
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

<table border="0" width="60%" cellpadding="0" cellspacing="0">
	<tr>
		<td width="39%" align="right" id='font3'>Date &nbsp;</td>
		<td width="61%" align="left">		
		<?php
		if ($errore_data_inserimento_rm_perfusione == 1)
			print ("<input type='text' name='data_inserimento_rm_perfusione' value='$data_inserimento_rm_perfusione' size='15' id='form1_A' onchange=\"data_inserimento()\" />");
		else
			if (($permission == 3) || ($ok_inserimento == 1))
				print ("<font face='Verdana, Arial, Helvetica, sans-serif' size='3' color='#2ECCFA'>$data_inserimento_rm_perfusione</font>");
			else
				print ("<input type='text' name='data_inserimento_rm_perfusione' value='$data_inserimento_rm_perfusione' size='15' id='form1' onchange=\"data_inserimento()\" />");
		?>	
		<font id='font4'>(gg/mm/aaaa)</font>
		</td>	
	</tr>
</table>	
<br />
<table border="0" width="65%" cellpadding="0" cellspacing="4">	
	<tr>
		<td width="35%" align="right" id='font3'>r-CBV &nbsp;</td>
		<td width="25%" align="left" id='form1'> 
		<?php
			if (($permission == 3) || ($ok_inserimento == 1))
			{
				if ($r_cbv == 'inf')
					print"<font id='font20'>Lower than 1.75 </font>";
				if ($r_cbv == 'sup')
					print"<font id='font20'>Upper than 1.75  </font>";	
				else;
			}
			else
			{
				if ($r_cbv == 'inf')
				{
					print ("<input type='radio' name='r_cbv' value='inf' onClick=\"javascript:location.href='nuovo_rm_perfusione.php?r_cbv=inf'\" checked='checked'/><font id='font9_A'> Lower than 1.75</font> &nbsp;");
					print ("<br>");
					print ("<input type='radio' name='r_cbv' value='sup' onClick=\"javascript:location.href='nuovo_rm_perfusione.php?r_cbv=sup'\"/><font id='font9_A'> Upper than 1.75</font> &nbsp;");
				}
				else if ($r_cbv == 'sup')
				{
					print ("<input type='radio' name='r_cbv' value='inf' onClick=\"javascript:location.href='nuovo_rm_perfusione.php?r_cbv=inf' \"/><font id='font9_A'> Lower than 1.75</font> &nbsp;");
					print ("<br>");
					print ("<input type='radio' name='r_cbv' value='sup' onClick=\"javascript:location.href='nuovo_rm_perfusione.php?r_cbv=sup'\" checked='checked'/><font id='font9_A'> Upper than 1.75</font> &nbsp;");
				}		
				else
				{
					print ("<input type='radio' name='r_cbv' value='inf' onClick=\"javascript:location.href='nuovo_rm_perfusione.php?r_cbv=inf'\"/><font id='font9_A'> Lower than 1.75</font> &nbsp;");
					print ("<br>");
					print ("<input type='radio' name='r_cbv' value='sup' onClick=\"javascript:location.href='nuovo_rm_perfusione.php?r_cbv=sup'\"/><font id='font9_A'> Upper than 1.75</font> &nbsp;");
				}			
			}
		?>		
		</td>
		<td width="30%" align="left"></td>	
	</tr>
	<tr>
		<td width="35%" align="right" id='font3'>Valore &nbsp;</td>
		<td width="25%" align="left" id='form1'> 
		<?php
			if (($permission == 3) || ($ok_inserimento == 1))
				print ("<font id='font20'> $valore_r_cbv  </font>");
			else
				print ("<input type='text' name='valore_r_cbv' value='$valore_r_cbv' size='10' onchange='r_cbv_function()' />");		
		?>	
		</td>
		<td width="30%" align="left"></td>	
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
	if ($errore_data_inserimento_rm_perfusione == 1)
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