<?php
session_start();
include ("accesso_db.php");

if ($permission == NULL)
	header("Location:errore.html");
	
include ("convertitore_date.php");
include ("function_php/try_format_date.php");
require_once('class/class.patient.php');
require_once('class/class.istologia.php');

$id_paziente = $_REQUEST['id_paziente'];
$id_istologia = $_REQUEST['id_istologia'];

// retrive all information about istology
$istologia = new istologia($id_paziente, NULL, NULL);
$istologia -> retrive_by_id($id_istologia);
$name_tumor = $istologia -> getTumore();
$note = $istologia -> getNote_tumore();
$data = $istologia -> getData_risultato();
$data=data_convert_for_utente($data);

$paziente = new patient($id_paziente, NULL, NULL);
$paziente -> retrive_by_ID($id_paziente)
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="style.css">
<title>Documento senza titolo</title>
</head>

<body>
<div align="center">
<?php include ("barra_titolo.html"); ?>
<hr id='hr1' size='5px'/>
<br />
<font id="font2">
Histological diagnosis</font>
<br /><br />
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

		<?php
		// retrive all information about tumor
		$query1 = "SELECT DISTINCT definition, link, icd_o_code, grade FROM tumors WHERE name_2 ='$name_tumor' ";
		$rs1 = mysql_query($query1);	
		while(list($definition, $link, $code, $grade) = mysql_fetch_row($rs1))
		{
			$definition1 = $definition;
			$link1 = $link;
			$code1 = $code;
			$grade1 = $grade;
		}
	
		$code1=str_replace("-", "/", $code1);	
		?>
		<div id='see_tumor'>
		<table border="0" width="60%" cellpadding="0" cellspacing="7">
			<tr>
				<td width="60%" align="right" id='font3'>Histology inserted in date: &nbsp;</td>
				<td width="40%" align="left" id='form1'><font id='font9'><?php print $data; ?></font></td> 
			</tr>	
		</table>
		<table border="0" width="90%" cellpadding="0" cellspacing="7">					
			<tr>
				<td width="20%" align="right" id='font3'>Name &nbsp;</td>
				<td width="80%" align="left" id='form1'><font id='font9'><?php print $name_tumor; ?></font></td> 
			</tr>
			<tr>
				<td width="20%" align="right" id='font3'>ICD-CODE &nbsp;</td>
				<td width="80%" align="left" id='form1'><font id='font9'><?php print $code1; ?></font></td> 
			</tr>	
			<tr>
				<td width="20%" align="right" id='font3'>WHO Grade &nbsp;</td>
				<td width="80%" align="left" id='form1'><font id='font9'><?php print $grade1; ?></font></td> 
			</tr>		
			<tr>
				<td width="20%" align="right" id='font3'>Definition &nbsp;</td>
				<td width="80%" align="left" id='form1'><font id='font9'><?php print $definition1; ?></font></td> 
			</tr>	
			<tr>
				<td width="20%" align="right" id='font3'>Link Wikipedia &nbsp;</td>
				<td width="80%" align="left" id='form1'>
				<a href='<?php print $link1; ?>' target="_blank"><font color="#663300" size="3"><?php print $link1; ?></font></a>
				</td> 
			</tr>	
		</table>
		<table border="0" width="90%" cellpadding="0" cellspacing="7">		
			<tr>
				<td width="20%" align="right" id='font3'>Note &nbsp;</td>
				<td width="80%" align="left" id='form1'> 
				<div>
				<font id='font9'><?php print $note; ?></font>
				</div>
				</td>
			</tr>
		</table>
</div>

<br /><br /><br />
<input type="button" onclick="javascript:window.close();" value='CLOSE' id='form2_3'/>
<br />

</body>
</html>
