<?php
session_start();
include ("accesso_db.php");

if ($permission == NULL)
	header("Location:errore.html");
	
include ("convertitore_date.php");
include ("function_php/try_format_date.php");
require_once('class/class.patient.php');
require_once('class/class.permeabilita.php');
require_once('class/class.dataExamInsert.php');

// Funzione che recupera i dati tramite REQUEST +++++++++++++++++++++++++++
function recupero_dati()
{
	global $k_trans;
	global $vi;
	global $data_inserimento;

	$k_trans=$_REQUEST['k_trans'];
	$vi=$_REQUEST['vi'];
	$data_inserimento=$_REQUEST['data_inserimento'];	
}
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

$flag_query = $_REQUEST['flag_query']; // Se la variabile $query=1 vuol dire che la agina � query_rm_morfologica.
// RECUPERA I DATI DALLA TABELLA RM_FUNZIONALE PER VISUALIZZARLI NELLA PAGINA ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
if ($flag_query == 1)
{
	$id_paziente =$_REQUEST['id_paziente'];
	$_SESSION['id_paziente'] = $id_paziente;
	
	$id_permeabilita =$_REQUEST['id_permeabilita'];
	$_SESSION['id_permeabilita'] = $id_permeabilita;
	
	// recupera i dati dal database:	
	$permeabilita = new permeabilita($id_paziente, NULL, NULL);
	$permeabilita->retrive_by_id($id_permeabilita);
	$data_inserimento = $permeabilita->getData_inserimento();
	$data_inserimento = data_convert_for_utente($data_inserimento);

	$k_trans= $permeabilita->getK_trans();
	$vi=$permeabilita->getVi();

	$flag_aggiorna =1;
	$_SESSION['flag_aggiorna'] = $flag_aggiorna;	
}
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


// INSERIMENTO DATI DI UNA PERMEABILITA' +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
if ($_REQUEST['inserisci'] == 'INSERT') // Inserisce i dati nel database:
{
	// recupera i dati:
	recupero_dati();
	$id_paziente = $_SESSION['id_paziente'];
	
	$permeabilita = new permeabilita($id_paziente, $k_trans, $vi);
	
	$errore_data_inserimento=controllo_data($data_inserimento);
	
	if ($errore_data_inserimento == 1);
	else
	{
		$data_inserimento1=data_convert_for_mysql($data_inserimento);
		$permeabilita -> setData_inserimento($data_inserimento1);
		$permeabilita->insert();

		$pagina = 24;
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

	$permeabilita = new permeabilita($id_paziente, NULL, NULL);

	// controlla la data:
	$errore_data_inserimento=controllo_data($data_inserimento);

	if ($errore_data_inserimento == 1);
	else
	{
		$data_inserimento=data_convert_for_mysql($data_inserimento);
		
		if ($k_trans == NULL)
			$k_trans = -1000;

		if ($vi == NULL)
			$vi = -1000;
				
		$query= "UPDATE permeabilita SET
				data_inserimento = '$data_inserimento',
				k_trans = '$k_trans',
				vi = '$vi'
				WHERE id = '$id_permeabilita' ";
		 $rs2 = mysql_query($query);	

		$pagina = 25;
		include ("log.php");
				 
		$data_inserimento=data_convert_for_utente($data_inserimento);	
		
		if ($k_trans == -1000)
			$k_trans = NULL;

		if ($vi == -1000)
			$vi = NULL;
				
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

<form action="nuovo_permeabilita.php" method="post" name='esame'>

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
		<td width="39%" align="right" id='font3'>Datee &nbsp;</td>
		<td width="61%" align="left">		
		<?php
		if ($errore_data_inserimento == 1)
			print ("<input type='text' name='data_inserimento' value='$data_inserimento' size='20' id='form1_A'/>");
		else
			if (($permission == 3) || ($ok_inserimento == 1))
				print ("<font face='Verdana, Arial, Helvetica, sans-serif' size='3' color='#2ECCFA'>$data_inserimento</font>");
			else
				print ("<input type='text' name='data_inserimento' value='$data_inserimento' size='20' id='form1'/>");
		?>	
		<font id='font4'>(gg/mm/aaaa)</font>
		</td>	
	</tr>
</table>	
<br />

<?php
$langhezza_table = '50%';
?>

<table border="0" width="<?php print $langhezza_table; ?>" cellpadding="1" cellspacing="2">
	<tr>
		<td width="30%" align="right"><font id="font3_A">K trans Value</font>&nbsp;</td>
		<td width="70%" align="left" id='form1'>
		<?php
		if (($permission == 3) || ($ok_inserimento == 1))
			print ("<font id='font20'> $k_trans </font>");
		else
			print ("<input type='text' name='k_trans' value='$k_trans' size='10'>");
		?>
		</td>
	</tr>
	<tr>
		<td width="30%" align="right"><font id="font3_A">Ve Value</font>&nbsp;</td>
		<td width="70%" align="left" id='form1'>
		<?php
		if (($permission == 3) || ($ok_inserimento == 1))
			print ("<font id='font20'> $vi </font>");
		else
			print ("<input type='text' name='vi' value='$vi' size='10'>");
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
	if ($errore_data_inserimento == 1)
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