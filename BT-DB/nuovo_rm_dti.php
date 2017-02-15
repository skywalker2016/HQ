<?php
session_start();
include ("accesso_db.php");

if ($permission == NULL)
	header("Location:errore.html");
	
include ("convertitore_date.php");
include ("function_php/try_format_date.php");
require_once('class/class.patient.php');
require_once('class/class.rm_dti.php');
require_once('class/class.dataExamInsert.php');

// Funzione che recupera i dati tramite REQUEST +++++++++++++++++++++++++++
function recupero_dati()
{
	global $valore_fa;
	global $cortico_spinale;
	global $arcuato;
	global $long;
	global $vie_ottiche;
	global $data_inserimento_rm_dti;				

	$valore_fa=$_REQUEST['valore_fa'];
	$cortico_spinale=$_REQUEST['cortico_spinale'];
	$arcuato=$_REQUEST['arcuato'];
	$long=$_REQUEST['long'];
	$vie_ottiche=$_REQUEST['vie_ottiche'];
	$data_inserimento_rm_dti=$_REQUEST['data_inserimento_rm_dti'];
}
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++



$flag_query = $_REQUEST['flag_query']; // Se la variabile $query=1 vuol dire che la agina � query_rm_morfologica.
// RECUPERA I DATI DALLA TABELLA RM_FUNZIONALE PER VISUALIZZARLI NELLA PAGINA ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
if ($flag_query == 1)
{
	$id_paziente =$_REQUEST['id_paziente'];
	$_SESSION['id_paziente'] = $id_paziente;

	$id_rm_dti =$_REQUEST['id_rm_dti'];
	$_SESSION['id_rm_dti'] = $id_rm_dti;
	
	// recupera i dati dal database:	
	$rm_dti = new rm_dti($id_paziente, NULL, NULL, NULL, NULL, NULL);
	$rm_dti->retrive_by_id($id_rm_dti);
	$data_inserimento_rm_dti = $rm_dti->getData_inserimento();
	$data_inserimento_rm_dti = data_convert_for_utente($data_inserimento_rm_dti);

	$valore_fa = $rm_dti->getValore_fa();
	$cortico_spinale=$rm_dti->getCortico_spinale();
	$arcuato=$rm_dti->getArcuato();
	$long=$rm_dti->getLongitudinale_inferiore();
	$vie_ottiche=$rm_dti->getVie_ottiche();

	$flag_aggiorna =1;
	$_SESSION['flag_aggiorna'] = $flag_aggiorna;
}
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


// INSERIMENTO DATI DI UNA NUOVA RM MORFOLOGICA ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
if ($_REQUEST['inserisci'] == 'INSERT') // Inserisce i dati nel database:
{
	// recupera i dati:
	recupero_dati();
	$id_paziente = $_SESSION['id_paziente'];
	
	$rm_dti = new rm_dti($id_paziente, $valore_fa, $cortico_spinale, $arcuato, $long, $vie_ottiche);
	
	$errore_data_inserimento_rm_dti=controllo_data($data_inserimento_rm_dti);
	
	if ($errore_data_inserimento_rm_dti == 1);
	else
	{
		$data_inserimento_rm_dti1=data_convert_for_mysql($data_inserimento_rm_dti);
		$rm_dti -> setData_inserimento($data_inserimento_rm_dti1);
		$rm_dti->insert();
		
		$pagina = 22;
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
	// recupera i dati:
	recupero_dati();
	$id_paziente = $_SESSION['id_paziente'];

	$rm_dti = new rm_dti($id_paziente, NULL, NULL, NULL, NULL, NULL);

	// controlla la data:
	$errore_data_inserimento_rm_dti=controllo_data($data_inserimento_rm_dti);

	if ($errore_data_inserimento_rm_dti == 1);
	else
	{
		$data_inserimento_rm_dti=data_convert_for_mysql($data_inserimento_rm_dti);
		
		if ($valore_fa == NULL)
			$valore_fa = -1000;
	
		$query= "UPDATE rm_dti SET
				data_inserimento = '$data_inserimento_rm_dti',
				valore_fa = '$valore_fa',
				cortico_spinale = '$cortico_spinale',
				arcuato = '$arcuato',
				longitudinale_inferiore = '$long',
				vie_ottiche = '$vie_ottiche'
				WHERE id = '$id_rm_dti' ";
		 $rs2 = mysql_query($query);	

	$pagina = 23;
	include ("log.php");
		 
		$data_inserimento_rm_dti=data_convert_for_utente($data_inserimento_rm_dti);	
		
		if ($valore_fa == -1000)
			$valore_fa = NULL;
	
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
	}	
	else if ($start == 2);
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
<font face="Verdana, Arial, Helvetica, sans-serif" color="#FFFFCC" size='2'>The data will be inserted in the database only when you see the confirm and when you see the tab 'CLOSE'</font>
<br />
<br />
<font id="font2">
RM DTI</font>
<br /><br />
<form action="nuovo_rm_dti.php" method="post" name='esame'>

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

<table border="0" width="53%" cellpadding="0" cellspacing="0">
	<tr>
		<td width="39%" align="right" id='font3'>Date &nbsp;</td>
		<td width="61%" align="left">		
		<?php
		if ($errore_data_inserimento_rm_dti == 1)
			print ("<input type='text' name='data_inserimento_rm_dti' value='$data_inserimento_rm_dti' size='20' id='form1_A'/>");
		else
			if (($permission == 3) || ($ok_inserimento == 1))
				print ("<font face='Verdana, Arial, Helvetica, sans-serif' size='3' color='#2ECCFA'>$data_inserimento_rm_dti</font>");
			else
				print ("<input type='text' name='data_inserimento_rm_dti' value='$data_inserimento_rm_dti' size='20' id='form1'/>");
		?>	
		<font id='font4'>(gg/mm/aaaa)</font>
		</td>	
	</tr>
</table>	
<br />

<?php
$langhezza_table = '60%';
?>

<table border="0" width="<?php print $langhezza_table; ?>" cellpadding="1" cellspacing="2">
	<tr>
		<td width="30%" align="right"><font id="font3_A">FA Value</font>&nbsp;</td>
		<td width="70%" align="left" id='form1'>
		<?php
		if (($permission == 3) || ($ok_inserimento == 1))
			print ("<font id='font20'> $valore_fa </font>");
		else
			print ("<input type='text' name='valore_fa' value='$valore_fa' size='10'>");
		?>
		</td>
	</tr>
	<tr>
		<td width="30%" align="right"><font id="font3_A">Corticospinal tract</font>&nbsp;</td>
		<td width="70%" align="left" id='form1'>
		<?php
		if (($permission == 3) || ($ok_inserimento == 1))
		{
			if ($cortico_spinale == 'infiltrato')
				print ("<font id='font20'> Infiltrated </font>");
			else if ($cortico_spinale == 'compresso')
				print ("<font id='font20'> Compressed </font>");	
		}
		else
		{
			if ($cortico_spinale == 'infiltrato')
			{
				print ("<input type='radio' name='cortico_spinale' value='infiltrato' checked='checked'><font id='font9_A'> Infiltrated</font> &nbsp;");
				print ("<input type='radio' name='cortico_spinale' value='compresso'><font id='font9_A'> Compressed</font> &nbsp;");
			}		
			else if ($cortico_spinale == 'compresso')
			{
				print ("<input type='radio' name='cortico_spinale' value='infiltrato' ><font id='font9_A'> Infiltrated</font> &nbsp;");
				print ("<input type='radio' name='cortico_spinale' value='compresso' checked='checked'><font id='font9_A'> Compressed</font> &nbsp;");
			}		
			else
			{
				print ("<input type='radio' name='cortico_spinale' value='infiltrato' ><font id='font9_A'> Infiltrated</font> &nbsp;");
				print ("<input type='radio' name='cortico_spinale' value='compresso' ><font id='font9_A'> Compressed</font> &nbsp;");
			}
		}				
		?>
		</td>
	</tr>	
	<tr>
		<td width="30%" align="right"><font id="font3_A">Fascicle Arcuate</font>&nbsp;</td>
		<td width="70%" align="left" id='form1'>
		<?php
		if (($permission == 3) || ($ok_inserimento == 1))
		{
			if ($arcuato == 'infiltrato')
				print ("<font id='font20'> Infiltrated </font>");
			else if ($arcuato == 'compresso')
				print ("<font id='font20'> Compressed </font>");	
		}
		else
		{		
			if ($arcuato == 'infiltrato')
			{
				print ("<input type='radio' name='arcuato' value='infiltrato' checked='checked'><font id='font9_A'> Infiltrated</font> &nbsp;");
				print ("<input type='radio' name='arcuato' value='compresso'><font id='font9_A'> Compressed</font> &nbsp;");
			}		
			else if ($arcuato == 'compresso')
			{
				print ("<input type='radio' name='arcuato' value='infiltrato'><font id='font9_A'> Infiltrated</font> &nbsp;");
				print ("<input type='radio' name='arcuato' value='compresso' checked='checked'><font id='font9_A'> Compressed</font> &nbsp;");
			}		
			else
			{
				print ("<input type='radio' name='arcuato' value='infiltrato'><font id='font9_A'> Infiltrated</font> &nbsp;");
				print ("<input type='radio' name='arcuato' value='compresso'><font id='font9_A'> Compressed</font> &nbsp;");
			}	
		}			
		?>
		</td>
	</tr>		
	<tr>
		<td width="30%" align="right"><font id="font3_A">Superior Longitudinal Fascicle</font>&nbsp;</td>
		<td width="70%" align="left" id='form1'>
		<?php
		if (($permission == 3) || ($ok_inserimento == 1))
		{
			if ($long == 'infiltrato')
				print ("<font id='font20'> Infiltrated </font>");
			else if ($long == 'compresso')
				print ("<font id='font20'> Compressed </font>");	
		}
		else
		{			
			if ($long == 'infiltrato')
			{	
				print ("<input type='radio' name='long' value='infiltrato' checked='checked'><font id='font9_A'> Infiltrated</font> &nbsp;");
				print ("<input type='radio' name='long' value='compresso'><font id='font9_A'> Compressed</font> &nbsp;");
			}		
			else if ($long == 'compresso')
			{
				print ("<input type='radio' name='long' value='infiltrato'><font id='font9_A'> Infiltrated</font> &nbsp;");
				print ("<input type='radio' name='long' value='compresso' checked='checked'><font id='font9_A'> Compressed</font> &nbsp;");
			}		
			else
			{
				print ("<input type='radio' name='long' value='infiltrato'><font id='font9_A'> Infiltrated</font> &nbsp;");
				print ("<input type='radio' name='long' value='compresso'><font id='font9_A'> Compressed</font> &nbsp;");
			}
		}				
		?>
		</td>
	</tr>		
	<tr>
		<td width="30%" align="right"><font id="font3_A">Optic Pathway</font>&nbsp;</td>
		<td width="70%" align="left" id='form1'>
		<?php
		if (($permission == 3) || ($ok_inserimento == 1))
		{
			if ($vie_ottiche == 'infiltrato')
				print ("<font id='font20'> Infiltrated </font>");
			else if ($vie_ottiche == 'compresso')
				print ("<font id='font20'> Compressed </font>");	
		}
		else
		{			
			if ($vie_ottiche == 'infiltrato')
			{	
				print ("<input type='radio' name='vie_ottiche' value='infiltrato' checked='checked'><font id='font9_A'> Infiltrated</font> &nbsp;");
				print ("<input type='radio' name='vie_ottiche' value='compresso'><font id='font9_A'> Compressed</font> &nbsp;");
			}		
			else if ($vie_ottiche == 'compresso')
			{
				print ("<input type='radio' name='vie_ottiche' value='infiltrato'><font id='font9_A'> Infiltrated</font> &nbsp;");
				print ("<input type='radio' name='vie_ottiche' value='compresso' checked='checked'><font id='font9_A'> Compressed</font> &nbsp;");
			}		
			else
			{
				print ("<input type='radio' name='vie_ottiche' value='infiltrato'><font id='font9_A'> Infiltrated</font> &nbsp;");
				print ("<input type='radio' name='vie_ottiche' value='compresso'><font id='font9_A'> Compressed</font> &nbsp;");
			}	
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
	if ($errore_data_inserimento_rm_dti == 1)
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