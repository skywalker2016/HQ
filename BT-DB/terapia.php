<?php
session_start();
include ("accesso_db.php");

if ($permission == NULL)
	header("Location:errore.html");
	
include ("convertitore_date.php");
include ("function_php/try_format_date.php");
require_once('class/class.patient.php');
require_once('class/class.terapia.php');
require_once('class/class.chemioterapia.php');
require_once('class/class.dataExamInsert.php');

$id_paziente =$_REQUEST['id_paziente'];

// Funzione recupero dati tramite $_REQUEST ++++++++++++
function recupero()
{
	global $rt_conformazionale;
	global $data_rt_conformazionale;
	global $radiochirurgia;
	global $data_radiochirurgia;
	global $temozolomide;
	global $data_temozolomide;
	global $cicli_temozolomide;
	global $pc_v;
	global $data_pc_v;
	global $cicli_pc_v;
	global $fotemustina;
	global $data_fotemustina;
	global $cicli_fotemustina;
	global $altro;
	global $data_altro;
	global $terapia_supporto;
	global $data_terapia_supporto;	
	
	$rt_conformazionale= $_REQUEST['rt_conformazionale'];
	$data_rt_conformazionale = $_REQUEST['data_rt_conformazionale'];
	$radiochirurgia= $_REQUEST['radiochirurgia'];
	$data_radiochirurgia = $_REQUEST['data_radiochirurgia'];
	$temozolomide = $_REQUEST['temozolomide'];
	$data_temozolomide = $_REQUEST['data_temozolomide'];
	$cicli_temozolomide= $_REQUEST['cicli_temozolomide'];
	$pc_v = $_REQUEST['pc_v'];
	$data_pc_v = $_REQUEST['data_pc_v'];
	$cicli_pc_v = $_REQUEST['cicli_pc_v'];
	$fotemustina = $_REQUEST['fotemustina'];
	$data_fotemustina = $_REQUEST['data_fotemustina'];
	$cicli_fotemustina = $_REQUEST['cicli_fotemustina'];
	$altro = $_REQUEST['altro'];
	$data_altro = $_REQUEST['data_altro'];
	$terapia_supporto = $_REQUEST['terapia_supporto'];
	$data_terapia_supporto = $_REQUEST['data_terapia_supporto'];
}


// **************** INSERISCE I DATI DEL PAZIENTE **********************************************
// *********************************************************************************************
if  ($_REQUEST['inserisci']) 
{
		recupero();
		
		// **** TERAPIA ******************************************
		if ($rt_conformazionale == NULL)
			$data_rt_conformazionale = NULL;
			
		if ($radiochirurgia == NULL)
			$data_radiochirurgia= NULL;	
	
		if ( ($rt_conformazionale != NULL) || ($radiochirurgia != NULL) )
		{
		
			$data_rt_conformazionale1=data_convert_for_mysql($data_rt_conformazionale);
			$data_radiochirurgia1=data_convert_for_mysql($data_radiochirurgia);
						
			$terapia = new terapia ($id_paziente, $rt_conformazionale, $data_rt_conformazionale1, $radiochirurgia, $data_radiochirurgia1);	
			// inserisce i dati del database:
			$terapia -> insert();
	
			if ($error != 1)
			{
				$ok_inserimento = 1;
			}	
		}
		else
			$ok_inserimento = 1;
			
		
		// **** CHEMIOTERAPIA ******************************************
		if ($temozolomide == NULL)
		{
			$data_temozolomide = NULL;		
			$cicli_temozolomide = -1000;	
		}
				
		if ($pc_v == NULL)
		{
			$data_pc_v = NULL;		
			$cicli_pc_v = -1000;	
		}
				
		if ($fotemustina == NULL)
		{
			$data_fotemustina= NULL;		
			$cicli_fotemustina = -1000;	
		}		
		
		if ($altro == NULL)
			$data_altro= NULL;		
		
		if ($terapia_supporto == NULL)
			$terapia_supporto= NULL;			
		
		if ( ($temozolomide != NULL) || ($pc_v != NULL)  || ($fotemustina != NULL) || ($altro!= NULL) || ($terapia_supporto != NULL) )
		{			
			 $data_temozolomide1=data_convert_for_mysql($data_temozolomide);
			 $data_pc_v1=data_convert_for_mysql($data_pc_v);			
			 $data_fotemustina1=data_convert_for_mysql($data_fotemustina);		
			 $data_altro1=data_convert_for_mysql($data_altro);				
			 $data_terapia_supporto1=data_convert_for_mysql($data_terapia_supporto);				
						
			$chemioterapia = new chemioterapia ($id_paziente, $temozolomide, $data_temozolomide1, $cicli_temozolomide, $pc_v, $data_pc_v1, $cicli_pc_v, $fotemustina, $data_fotemustina1, $cicli_fotemustina, $altro, $data_altro1, $terapia_supporto, $data_terapia_supporto1);
			
			// inserisce i dati del database:
			$chemioterapia -> insert();
	
			if ($error_chemio != 1)
			{
				$ok_inserimento_chemio = 1;
			}	
		
		if ($cicli_temozolomide == -1000)
			$cicli_temozolomide = NULL;
		
		if ($cicli_pc_v == -1000)
			$cicli_pc_v = NULL;		
		
		if ($cicli_fotemustina== -1000)
			$cicli_fotemustina = NULL;		
		}
		else
			$ok_inserimento_chemio = 1;	
			
		$pagina = 30;
		include ("log.php");	
}
// *********************************************************************************************
// *********************************************************************************************
else;

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
Terapia</font>
<br /><br />
<?php
	if (($ok_inserimento == 1) && ($ok_inserimento_chemio == 1))
		print ("<font id='font4_N'>The data have been inserted in the database</font><br>");	
	
	if (($error == 1) || ($error_chemio == 1))
		print ("<font id='font4_N'>There was an error. The data are not inserted in the database<br>
				Contact the administrator.</font><br>");			
?>
<form action="terapia.php" method="post">
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
		<td width="35%" align="right" id='font3'>Conformational radiation therapy &nbsp;</td>
		<td width="10%" align="left" id='form1'> 
			<?php
				if (($permission == 3) || ($ok_inserimento == 1) || ($ok_inserimento_chemio == 1))
				{
					if ($rt_conformazionale  == 'on')
						print "<font id='font20'>Yes </font>";			
				}
				else
				{
					if ($rt_conformazionale == 'on')
						print "<input type='checkbox' name='rt_conformazionale' checked='checked'/>  ";
					else
						print "<input type='checkbox' name='rt_conformazionale'/>  ";				
				}
			?>
		</td>
		<td width="55%" align="left" id='form1'>
			<font id="font4_A"> &nbsp; <strong>in date:</strong></font>
			<?php
				if (($permission == 3) || ($ok_inserimento == 1) || ($ok_inserimento_chemio == 1))
				{
					print ("<font id='font20'>$data_rt_conformazionale</font>");		
				}			
				else
				{
					print ("<input type='text' name='data_rt_conformazionale' size='15'/><font id='font4_A'>dd/mm/yyyy</font>");		
				}					
			?>		
		</td>	
	</tr>
	
	<tr>
		<td width="35%" align="right" id='font3'>Radiosurgery &nbsp;</td>
		<td width="10%" align="left" id='form1'> 
			<?php
				if (($permission == 3) || ($ok_inserimento == 1) || ($ok_inserimento_chemio == 1))
				{
					if ($radiochirurgia   == 'on')
						print "<font id='font20'>Yes </font>";			
				}
				else
				{			
					if ($radiochirurgia  == 'on')
						print "<input type='checkbox' name='radiochirurgia' checked='checked'/>  ";
					else
						print "<input type='checkbox' name='radiochirurgia'/>  ";						
				}
			?>
		</td>
		<td width="55%" align="left" id='form1'>
			<font id="font4_A"> &nbsp; <strong>in date:</strong></font>
			<?php
				if (($permission == 3) || ($ok_inserimento == 1) || ($ok_inserimento_chemio == 1))
				{
					print ("<font id='font20'>$data_radiochirurgia</font>");		
				}			
				else
				{
					print ("<input type='text' name='data_radiochirurgia' size='15'/><font id='font4_A'>dd/mm/yyyy</font>");		
				}					
			?>			
		</td>	
	</tr>
</table>


<table border="0" width="40%" cellpadding="0" cellspacing="4">
	<tr>
		<td width="100%" align="left">
			<font color="#00CCFF" size="3" face="Verdana, Arial, Helvetica, sans-serif">Chemoterapy</font>
		</td>
	</tr>	
</table>	


<table border="0" width="60%" cellpadding="0" cellspacing="4">
	<tr>
		<td width="35%" align="right" id='font3'>Temozolomide &nbsp;</td>
		<td width="10%" align="left" id='form1'> 
			<?php
				if (($permission == 3) || ($ok_inserimento == 1) || ($ok_inserimento_chemio == 1))
				{
					if ($temozolomide   == 'on')
						print "<font id='font20'>Yes </font>";			
				}
				else
				{				
					if ($temozolomide == 'on')
						print "<input type='checkbox' name='temozolomide' checked='checked'/>  ";
					else
						print "<input type='checkbox' name='temozolomide'/>  ";				
				}
			?>
		</td>
		<td width="55%" align="left" id='form1'>
			<font id="font4_A"> &nbsp; <strong>date begin:</strong></font>
			<?php
			if (($permission == 3) || ($ok_inserimento == 1) || ($ok_inserimento_chemio == 1))
			{
				print ("<font id='font20'>$data_temozolomide &nbsp; &nbsp; cycles $cicli_temozolomide</font>");		
			}			
			else
			{
				print ("
						<input type='text' name='data_temozolomide' size='15'/>
						<font id='font4_A'>dd/mm/yyyy</font>
						<font id='font4_A'> &nbsp; &nbsp; <strong># cycles</strong></font>
						<input type='text' name='cicli_temozolomide' size='5'/>
					");	
			}
			?>
		</td>	
	</tr>
	<tr>
		<td width="35%" align="right" id='font3'>PC (V) &nbsp;</td>
		<td width="10%" align="left" id='form1'> 
			<?php
				if (($permission == 3) || ($ok_inserimento == 1) || ($ok_inserimento_chemio == 1))
				{
					if ($pc_v   == 'on')
						print "<font id='font20'>Yes </font>";			
				}
				else
				{				
					if ($pc_v == 'on')
						print "<input type='checkbox' name='pc_v' checked='checked'/>  ";
					else
						print "<input type='checkbox' name='pc_v'/>  ";				
				}
			?>
		</td>
		<td width="55%" align="left" id='form1'>
			<font id="font4_A"> &nbsp; <strong>date begin:</strong></font>
			<?php
			if (($permission == 3) || ($ok_inserimento == 1) || ($ok_inserimento_chemio == 1))
			{
				print ("<font id='font20'>$data_pc_v &nbsp; &nbsp; cycles $cicli_pc_v</font>");		
			}			
			else
			{
				print ("
						<input type='text' name='data_pc_v' size='15'/>
						<font id='font4_A'>dd/mm/yyyy</font>
						<font id='font4_A'> &nbsp; &nbsp; <strong># cycles</strong></font>
						<input type='text' name='cicli_pc_v' size='5'/>
					");	
			}
			?>			
		</td>	
	</tr>
	<tr>
		<td width="35%" align="right" id='font3'>Fotemustina+bevactizumab &nbsp;</td>
		<td width="10%" align="left" id='form1'> 
			<?php
				if (($permission == 3) || ($ok_inserimento == 1) || ($ok_inserimento_chemio == 1))
				{
					if ($fotemustina   == 'on')
						print "<font id='font20'>Yes </font>";			
				}
				else
				{				
					if ($fotemustina == 'on')
						print "<input type='checkbox' name='fotemustina' checked='checked'/>  ";
					else
						print "<input type='checkbox' name='fotemustina'/>  ";				
				}
			?>		
		</td>
		<td width="55%" align="left" id='form1'>
			<font id="font4_A"> &nbsp; <strong>date begin:</strong></font>
			<?php
			if (($permission == 3) || ($ok_inserimento == 1) || ($ok_inserimento_chemio == 1))
			{
				print ("<font id='font20'>$data_fotemustina &nbsp; &nbsp; cycles $cicli_fotemustina</font>");		
			}			
			else
			{
				print ("
						<input type='text' name='data_fotemustina' size='15'/>
						<font id='font4_A'>dd/mm/yyyy</font>
						<font id='font4_A'> &nbsp; &nbsp; <strong># cycles</strong></font>
						<input type='text' name='cicli_fotemustina' size='5'/>
					");	
			}
			?>				
		</td>	
	</tr>
</table>

<table border="0" width="60%" cellpadding="0" cellspacing="4">
	<tr>
		<td width="35%" align="right" id='font3'>Other &nbsp;</td>
		<td width="65%" align="left" id='form1'> 
			<?php
				if (($permission == 3) || ($ok_inserimento == 1) || ($ok_inserimento_chemio == 1))
				{
						print "<font id='font20'>$altro </font>";			
				}
				else
				{				
					print ("<input type='text' name='altro' size='40'/>");			
				}
			?>		
			<font id="font4_A"> &nbsp; <strong>date:</strong></font>
			<?php
				if (($permission == 3) || ($ok_inserimento == 1) || ($ok_inserimento_chemio == 1))
				{
					print ("<font id='font20'>$data_altro</font>");		
				}			
				else
				{
					print ("<input type='text' name='data_altro' size='10'/>");		
				}					
			?>				
		</td>
	</tr>	
	<tr>
		<td width="35%" align="right" id='font3'>Supportive Therapy &nbsp;</td>
		<td width="65%" align="left" id='form1'> 
			<?php
				if (($permission == 3) || ($ok_inserimento == 1) || ($ok_inserimento_chemio == 1))
				{
						print "<font id='font20'>$terapia_supporto </font>";			
				}
				else
				{				
					print ("<input type='text' name='terapia_supporto' size='40'/>");			
				}
			?>			
			<font id="font4_A"> &nbsp; <strong>date:</strong></font>
			<?php
				if (($permission == 3) || ($ok_inserimento == 1) || ($ok_inserimento_chemio == 1))
				{
					print ("<font id='font20'>$data_terapia_supporto</font>");		
				}			
				else
				{
					print ("<input type='text' name='data_terapia_supporto' size='10'/>");		
				}					
			?>			
		</td>
	</tr>	
</table>	
<br />
<?php
if (($permission == 3) || ($ok_inserimento == 1) || ($ok_inserimento_chemio == 1));
else
{
?>
	<table border="0" width="65%">
	<tr>
		<td width="70%" align="center"><hr width="96%" /></td>
		<td width="30%" align="center"><input type='submit' name="inserisci" value='INSERT' id='form2'/>
		<input type="hidden" name='id_paziente' value='<?php print $id_paziente; ?>' />
		 </td>
	</tr>
	</table>
<?php
}
?>
</form>
	
<br />
<input type="button" onclick="javascript:window.close();" value='CLOSE' id='form2_3'/>
<br />
</div>
</body>
</html>