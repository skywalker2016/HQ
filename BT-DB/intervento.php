<?php
session_start();
include ("accesso_db.php");

if ($permission == NULL)
	header("Location:errore.html");
	
include ("convertitore_date.php");
include ("function_php/try_format_date.php");
require_once('class/class.patient.php');
require_once('class/class.intervento.php');
require_once('class/class.dataExamInsert.php');

$data_inserimento_intervento=date("d/m/Y");

// Funzione recupero dati tramite $_REQUEST ++++++++++++
function recupero()
{
	global $biopsia;
	global $data_biopsia;
	global $resezione_totale;
	global $data_resezione_totale;
	global $resezione_parziale;
	global $data_resezione_parziale;
	global $resezione_gliadel;
	global $data_resezione_gliadel;

	$biopsia = $_REQUEST['biopsia'];
	$data_biopsia = $_REQUEST['data_biopsia'];
	$resezione_totale = $_REQUEST['resezione_totale'];
	$data_resezione_totale = $_REQUEST['data_resezione_totale'];
	$resezione_parziale = $_REQUEST['resezione_parziale'];
	$data_resezione_parziale = $_REQUEST['data_resezione_parziale'];
	$resezione_gliadel = $_REQUEST['resezione_gliadel'];
	$data_resezione_gliadel = $_REQUEST['data_resezione_gliadel'];
}

$inserisci = $_REQUEST['inserisci'];

// **************** INSERISCE I DATI DEL PAZIENTE ***********************************************
// *********************************************************************************************
if  ($inserisci == 'INSERT') 
{
	$start = 1;
	$id_paziente = $_SESSION['id_paziente'];
	recupero();

	$data_biopsia1=data_convert_for_mysql($data_biopsia);
	$data_resezione_totale1=data_convert_for_mysql($data_resezione_totale);
	$data_resezione_parziale1=data_convert_for_mysql($data_resezione_parziale);
	$data_resezione_gliadel1=data_convert_for_mysql($data_resezione_gliadel);
				
	if ($biopsia == NULL)
	{
		$data_biopsia1 = '0000-00-00';
		$data_biopsia = NULL;
	}
	if ($resezione_totale == NULL)
	{
		$data_resezione_totale1 = '0000-00-00';	
		$data_resezione_totale = NULL;
	}
	if ($resezione_parziale == NULL)
	{
		$data_resezione_parziale1 = '0000-00-00';
		$data_resezione_parziale = NULL;
	}
	if ($resezione_gliadel == NULL)
	{
		$data_resezione_gliadel1 = '0000-00-00';		
		$data_resezione_gliadel = NULL;
	}				
						
	$intervento = new intervento ($id_paziente, $biopsia, $data_biopsia1, $resezione_totale, $data_resezione_totale1, $resezione_parziale, $data_resezione_parziale1,$resezione_gliadel, $data_resezione_gliadel1);

	// controlla la Data inserimento:
	$errore_data_inserimento=controllo_data($data_inserimento_intervento);

	if ($errore_data_inserimento == 1);
	else
	{
		// inserisce i dati del database:
		$data_inserimento_intervento1=data_convert_for_mysql($data_inserimento_intervento);
		$intervento -> setData_inserimento($data_inserimento_intervento1);
		$intervento -> insert();

		$pagina = 26;
		include ("log.php");

		if ($error != 1)
		{
			$ok_inserimento = 1;
		}	
	}
}
// *********************************************************************************************
// AGGIORNA I DATI *****************************************************************************
else if ($inserisci == 'UPDATE')
{ 
	$start = 3;
	$id_paziente = $_SESSION['id_paziente'];
	$id_intervento = $_SESSION['id_intervento'];
	recupero();
	
	// controlla la data:
	$errore_data_inserimento=controllo_data($data_inserimento_intervento);
	if ($errore_data_inserimento == 1);
	else
	{	
		// converte tutte le date:
		$data_inserimento_intervento1=data_convert_for_mysql($data_inserimento_intervento);
		$data_biopsia1=data_convert_for_mysql($data_biopsia);
		$data_resezione_totale1=data_convert_for_mysql($data_resezione_totale);
		$data_resezione_parziale1=data_convert_for_mysql($data_resezione_parziale);
		$data_resezione_gliadel1=data_convert_for_mysql($data_resezione_gliadel);
	
		if ($biopsia == NULL)
		{
			$data_biopsia1 = '0000-00-00';
			$data_biopsia = NULL;
		}
		if ($resezione_totale == NULL)
		{
			$data_resezione_totale1 = '0000-00-00';	
			$data_resezione_totale = NULL;
		}
		if ($resezione_parziale == NULL)
		{
			$data_resezione_parziale1 = '0000-00-00';
			$data_resezione_parziale = NULL;
		}
		if ($resezione_gliadel == NULL)
		{
			$data_resezione_gliadel1 = '0000-00-00';		
			$data_resezione_gliadel = NULL;
		}
		
		$query= "UPDATE intervento SET
				data_inserimento = '$data_inserimento_intervento1',
				biopsia = '$biopsia',
				data_biopsia = '$data_biopsia1',
				resezione_totale = '$resezione_totale',
				data_resezione_totale = '$data_resezione_totale1',
				resezione_parziale = '$resezione_parziale',
				data_resezione_parziale = '$data_resezione_parziale1',
				resezione_gliadel = '$resezione_gliadel',
				data_resezione_gliadel = '$data_resezione_gliadel1'				
				WHERE id = '$id_intervento' ";
		 $rs2 = mysql_query($query);		

		$pagina = 27;
		include ("log.php");
			
		if ($rs2 == 1)
			$ok_aggiornamento = 1; 
	}	
}
else
{	
	$start = $_REQUEST['start'];
	// Arriva dalla pagina query_paziente_generale.php +++++++++++++++++++++++++++++++++++++++++++++++
	if ($start == 1)
	{
		$id_paziente =$_REQUEST['id_paziente'];
		$_SESSION['id_paziente'] = $id_paziente;
	}

	if ($start == 2)
	{
		$id_paziente =$_REQUEST['id_paziente'];
		$_SESSION['id_paziente'] = $id_paziente;
		$id_intervento =$_REQUEST['id_intervento'];
		$_SESSION['id_intervento'] = $id_intervento;
	
		// recupera i dati dià inseriti dal database:
		$intervento = new intervento($id_paziente, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL); 
		$intervento->retrive_by_id($id_intervento);
		$data_inserimento_intervento = $intervento->getData_inserimento();
		$data_inserimento_intervento = data_convert_for_utente($data_inserimento_intervento);
	
		$biopsia = $intervento->getBiopsia();
		$data_biopsia = $intervento->getData_biopsia();
		$resezione_totale = $intervento->getResezione_totale();
		$data_resezione_totale = $intervento->getData_resezione_totale();
		$resezione_parziale = $intervento->getResezione_parziale();
		$data_resezione_parziale = $intervento->getData_resezione_parziale();
		$resezione_gliadel = $intervento->getResezione_gliadel();
		$data_resezione_gliadel = $intervento->getData_resezione_gliadel();
	
		$data_biopsia = data_convert_for_utente($data_biopsia);	
		$data_resezione_totale = data_convert_for_utente($data_resezione_totale);	
		$data_resezione_parziale = data_convert_for_utente($data_resezione_parziale);	
		$data_resezione_gliadel = data_convert_for_utente($data_resezione_gliadel);	
		
		if ($data_biopsia == '00/00/0000')
		{	
			$data_biopsia = NULL;
		}	
		if ($data_resezione_totale == '00/00/0000')
		{	
			$data_resezione_totale = NULL;
		}	
		if ($data_resezione_parziale == '00/00/0000')
		{	
			$data_resezione_parziale = NULL;
		}	
		if ($data_resezione_gliadel == '00/00/0000')
		{	
			$data_resezione_gliadel = NULL;
		}		
	}
}

$paziente = new patient($id_paziente, NULL, NULL);
$paziente -> retrive_by_ID($id_paziente);

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
Medical Surgery</font>
<br /><br />
<?php
	if ($ok_aggiornamento == 1)
		print ("<font id='font4_N'>Data have been updated</font><br>");	

	if ($errore_data_inserimento == 1)
		print ("<font id='font4_N'>Please, check the date format</font><br>");
		
	if ($error == 1)
		print ("<font id='font4_N'>There was an error. The data are not inserted in the database<br>
				Contact the administrator.</font><br>");			
?>
<form action="intervento.php" method="post">
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
		<font face="Verdana, Arial, Helvetica, sans-serif" size="2">Lastname</font>
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
<table border="0" width="60%" cellpadding="0" cellspacing="4">	
	<tr>
		<td width="35%" align="right" id='font3'>Biopsy &nbsp;</td>
		<td width="15%" align="left" id='form1'> 
			<?php
			if (($permission == 3) || ($ok_inserimento == 1))
			{
				if ($biopsia  == 'on')
					print "<font id='font20'>Yes </font>";		
			}
			else
			{
				if ($biopsia  == 'on')
					print "<input type='checkbox' name='biopsia' checked='checked'/>  ";
				else
					print "<input type='checkbox' name='biopsia'/>  ";				
			}
			?>
		</td>

		<td width="50%" align="left" id='form1'><font id="font4_A"> &nbsp; <strong>in date:</strong></font>
			<?php 
				if (($permission == 3) || ($ok_inserimento == 1))
					print "<font id='font20'>$data_biopsia </font>";		
				else	
					print("<input type='text' name='data_biopsia' value='$data_biopsia' size='15'/>"); 
			?>
			<font id="font4_A">gg/mm/aaaa</font>
		</td>	
	</tr>
	<tr>
		<td width="35%" align="right" id='font3'>Macroscopic total tumor resection &nbsp;</td>
		<td width="15%" align="left" id='form1'> 
			<?php
			if (($permission == 3) || ($ok_inserimento == 1))
			{
				if ($resezione_totale  == 'on')
					print "<font id='font20'>Yes </font>";		
			}	
			else
			{
				if ($resezione_totale  == 'on')
					print "<input type='checkbox' name='resezione_totale' checked='checked'/>  ";
				else
					print "<input type='checkbox' name='resezione_totale'/>  ";				
			}
			?>
		</td>
		<td width="50%" align="left" id='form1'><font id="font4_A"> &nbsp; <strong>in date:</strong></font>
		<?php 
			if (($permission == 3) || ($ok_inserimento == 1))
				print "<font id='font20'>$data_resezione_totale </font>";		
			else			
				print("<input type='text' name='data_resezione_totale' value='$data_resezione_totale' size='15' />");
		
		 ?>	
			<font id="font4_A">gg/mm/aaaa</font>
		</td>	
	</tr>
	<tr>
		<td width="35%" align="right" id='font3'>Partial tumor resection &nbsp;</td>
		<td width="15%" align="left" id='form1'> 
			<?php
			if (($permission == 3) || ($ok_inserimento == 1))
			{
				if ($resezione_parziale  == 'on')
					print "<font id='font20'>Yes </font>";		
			}	
			else
			{
				if ($resezione_parziale  == 'on')
					print "<input type='checkbox' name='resezione_parziale' checked='checked'/>  ";
				else
					print "<input type='checkbox' name='resezione_parziale'/>  ";				
			}
			?>
		</td>
		<td width="50%" align="left" id='form1'><font id="font4_A"> &nbsp; <strong>in date:</strong></font>
		<?php 
			if (($permission == 3) || ($ok_inserimento == 1))
				print "<font id='font20'>$data_resezione_parziale </font>";		
			else	
				print("<input type='text' name='data_resezione_parziale' value='$data_resezione_parziale' size='15'/>"); 
			?>		
			<font id="font4_A">gg/mm/aaaa</font>
		</td>	
	</tr>
	<tr>
		<td width="35%" align="right" id='font3'>GLIADEL &nbsp;</td>
		<td width="15%" align="left" id='form1'> 
			<?php
			if (($permission == 3) || ($ok_inserimento == 1))
			{
				if ($resezione_gliadel  == 'on')
					print "<font id='font20'>Yes </font>";		
			}	
			else
			{
				if ($resezione_gliadel  == 'on')
					print "<input type='checkbox' name='resezione_gliadel' checked='checked'/>  ";
				else
					print "<input type='checkbox' name='resezione_gliadel'/>  ";				
			}
			?>
		</td>
		<td width="50%" align="left" id='form1'><font id="font4_A"> &nbsp; <strong>in date:</strong></font>
		<?php 
		if (($permission == 3) || ($ok_inserimento == 1))
				print "<font id='font20'>$data_resezione_gliadel </font>";		
			else
				print("<input type='text' name='data_resezione_gliadel' value='$data_resezione_gliadel' size='15'/>"); 
		?>			
			<font id="font4_A">gg/mm/aaaa</font>		
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
		<td width="30%" align="center">
		<?php
		if ($start == 1)
			print ("<input type='submit' name='inserisci' value='INSERT' id='form2'/>");
		else if (($start == 2) || ($start = 3))
			print ("<input type='submit' name='inserisci' value='UPDATE' id='form2'/>");
		?>
		<input type="hidden" name='id_paziente' value='<?php print $id_paziente; ?>' />
		 </td>
	</tr>
	</table>
<?php
}
?>
</form>
<br />
<font face="Verdana, Arial, Helvetica, sans-serif" size="3" color="#FF5B5B"></font>
<br /><br />
<input type="button" onclick="javascript:window.close();" value='CLOSE' id='form2_3'/>
<br />
</div>
</body>
</html>