<?php
session_start();
include ("accesso_db.php");

if ($permission == NULL)
	header("Location:errore.html");
	
include ("convertitore_date.php");
include ("function_php/try_format_date.php");
require_once('class/class.patient.php');
require_once('class/class.istologia.php');
require_once('class/class.chemioterapia.php');
require_once('class/class.dataExamInsert.php');

$id_paziente =$_REQUEST['id_paziente'];
$clear =$_REQUEST['clear'];

if ($clear == 'CLEAR')
	$start = 1;
else
{	

	$start = $_REQUEST['start'];
	if ($start == 1)
	{
		$query = 'TRUNCATE TABLE tumors_prov';
		$rs = mysql_query($query);	
	}
}

// FIND a tumor option **********************************************************************
$find_tumor=$_REQUEST['find_tumor'];
if ($find_tumor == 'FIND')
{
	$query = 'TRUNCATE TABLE tumors_prov';
	$rs = mysql_query($query);	

	$name_tumor=$_REQUEST['name_tumor'];
	$search_type=$_REQUEST['search_type'];

	if ($name_tumor == NULL)
		$start = 1;
	else
	{		
			if ($search_type == 'name')
			{	
				for ($i=0; $i<3; $i++)
				{
					if ($i==0)
						$query = "SELECT id FROM tumors WHERE main LIKE '%$name_tumor%'";				
					if ($i==1)
						$query = "SELECT id FROM tumors WHERE name_1 LIKE '%$name_tumor%'";				
					if ($i==2)
						$query = "SELECT id FROM tumors WHERE name_2 LIKE '%$name_tumor%'";				
					
					$rs = mysql_query($query);
					while(list($id) = mysql_fetch_row($rs))
					{
						// insert the data in the table prov:
						$query1 = "INSERT INTO tumors_prov
								(id, id_tumor)
								VALUES
								(NULL, '$id')";
						$rs1 = mysql_query($query1);		
					}
				}
			}	
			if ($search_type == 'code')
			{	
				$query = "SELECT id FROM tumors WHERE icd_o_code LIKE '%$name_tumor%'";			
				$rs = mysql_query($query);
				while(list($id) = mysql_fetch_row($rs))
				{
					// insert the data in the table prov:
					$query1 = "INSERT INTO tumors_prov
							(id, id_tumor)
							VALUES
							(NULL, '$id')";
					$rs1 = mysql_query($query1);		
				}		
			}
	}
	$name_tumor = NULL;
	$find_tumor = NULL;	
}
// ******************************************************************************************

// REGISTRAZIONE VAR Javascript **************************************************
if ($_REQUEST['reg'] == 1)
	$main1 = $_REQUEST['main'];
if ($_REQUEST['reg'] == 2)
{	
	$main1 = $_REQUEST['main'];
	$name_1_new = $_REQUEST['name1'];	
}	
// ********************************************************************

// SEE tumor **********************************************************************
$see_tumor=$_REQUEST['see_tumor'];
if ($see_tumor == 'SEE TUMOR')
{
	$main1 = $_REQUEST['main'];
	$name_1_new = $_REQUEST['name_1_2'];
	$name_2_new = $_REQUEST['name_2'];

	$name_tumor = $name_2_new;
	$start = 2;
}
// **********************************************************************************

// **************** INSERISCE I DATI DEL PAZIENTE **********************************************
// *********************************************************************************************
if  ($_REQUEST['inserisci'] == 'INSERT') 
{
	$ins=$_REQUEST['inserisci'];

	$main1 = $_REQUEST['main'];
	$name_1_new = $_REQUEST['name_1_2'];
	$name_2_new = $_REQUEST['name_2'];
	
	$name_altro = $_REQUEST['name_altro'];
	if ($name_altro != NULL)
		$name_tumor = $name_altro;	
	else
		$name_tumor = $name_2_new;
	
	$data_risultato=$_REQUEST['data_risultato'];
	$note=$_REQUEST['note'];
		
	// controllo della data:
	$errore_data_risultato=controllo_data($data_risultato);
	if ($errore_data_risultato == 1)
	{
		$see_tumor = 'SEE TUMOR';
		$ins=NULL;
	}	
	else
	{
		$istologia = new istologia($id_paziente, $name_tumor, $note);

		$data_risultato=data_convert_for_mysql($data_risultato);
		$istologia -> setData_risultato($data_risultato);
		$istologia->insert();
	
		$pagina =28;
		include ("log.php");
	
		if ($error != 1)
		{
			$ok_inserimento = 1;
			$data_risultato=data_convert_for_utente($data_risultato);
		}	
		else
		{
			$see_tumor = 'SEE TUMOR';
			$ins=NULL;
		}	
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
function main_function(link, id_paz)
{
	var main_name=link[link.selectedIndex].value;

	var destination_page = "istologia.php";
	location.href = destination_page+"?reg=1&main="+main_name+"&id_paziente="+id_paz;
}

function name1_function(link, main_name, id_paz)
{
	var name1=link[link.selectedIndex].value;

	var destination_page = "istologia.php";
	location.href = destination_page+"?reg=2&main="+main_name+"&id_paziente="+id_paz+"&name1="+name1;
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
Histological diagnosis</font>
<br /><br />
<?php
	if ($ok_aggiornamento == 1)
		print ("<font id='font4_N'>The data have been inserted in the database</font><br>");	

	if ($ok_inserimento == 1)
		print ("<font id='font4_N'>The data have been inserted in the database</font><br>");	
	
	if ($error == 1)
		print ("<font id='font4_N'>There was an error. The data are not inserted in the database<br>
				Contact the administrator.</font><br>");	
		
	if ($errore_data_risultato == 1)		
		print ("<font id='font4_N'>Please check the date format</font>");	
?>
<form action="istologia.php" method="post">
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
if  ($ins == 'INSERISCI');
else
{ 
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
?>

<table border="0" width="60%" cellpadding="0" cellspacing="4">
	<tr>
		<td width="35%" align="right" id='font3'>Find a tumor &nbsp;</td>
		<td width="55%" align="left" id='form1'> 
		<input type="text" name='name_tumor' value='' size='30' />
		<font face="Verdana, Arial, Helvetica, sans-serif" size="2">by NAME</font> <input type="radio" name='search_type' value='name' checked="checked"/>
		<font face="Verdana, Arial, Helvetica, sans-serif" size="2"> ICD-CODE</font> <input type="radio" name='search_type' value='code' />
		</td>
		<td width="10%" align="center"> 
		<input type="submit" name='find_tumor' value='FIND' />
		<input type="hidden" name='id_paziente' value='<?php print $id_paziente; ?>' />
		</td>
	</tr>
</table>
</form>
<br />
<form action="istologia.php" method="post">
<table border="0" width="45%" cellpadding="0" cellspacing="4">
	<tr>
		<td width="40%" align="right" id='font3'>Choose a tumor (Family) &nbsp;</td>
		<td width="60%" align="left" id='form1'> 
		<?php
			// FAMILY ----------------------------------------------------------------------
			print ("<select name='main' size='1' cols='10' onChange=\"main_function(this, '$id_paziente')\">");
			if ($main1 != NULL)
				print ("<OPTION VALUE='$main1'>$main1</OPTION>");
				
			print ("<OPTION VALUE='-'>--- </OPTION>");
			// Recupera i dati dalla tabella dei tumori:
			$query = "SELECT id_tumor FROM tumors_prov ORDER BY id_tumor ASC";			
			$rs = mysql_query($query);
			$main_old = NULL;
			while(list($id_t) = mysql_fetch_row($rs))
			{
				$query1 = "SELECT main FROM tumors WHERE id = '$id_t'";
				$rs1 = mysql_query($query1);							
				while(list($main) = mysql_fetch_row($rs1))			
				{
					if ($main_old == $main);
					else
					{	
						print ("<OPTION VALUE='$main'>$main</OPTION>");
						$main_old = $main;
					}
				}
			}
			print ("</select>");
		?>
		</td>
	</tr>
	
	<tr>
		<td width="40%" align="right" id='font3'>Choose a tumor (Name) &nbsp;</td>
		<td width="60%" align="left" id='form1'> 
		<?php
			$nominativo_main = $main1;
			// NAME_1 ----------------------------------------------------------------------
			print ("<select name='name1' size='1' cols='10' onChange=\"name1_function(this, '$nominativo_main', '$id_paziente')\">");
			if ($name_1_new != NULL)
				print ("<OPTION VALUE='$name_1_new'>$name_1_new</OPTION>");
				
			print ("<OPTION VALUE='-'>--- </OPTION>");
			// Recupera i dati dalla tabella dei tumori:
			$query1 = "SELECT DISTINCT name_1 FROM tumors WHERE main = '$main1'";
			$rs1 = mysql_query($query1);						
			while(list($name_1) = mysql_fetch_row($rs1))			
			{
					print ("<OPTION VALUE='$name_1'>$name_1</OPTION>");
			}
			print ("</select>");
		?>
		</td>
	</tr>	
</table>
<br />
<table border="0" width="45%" cellpadding="0" cellspacing="4">	
	<tr>
		<td width="40%" align="right" id='font3'>Tumor: &nbsp;</td>
		<td width="60%" align="left" id='form1'>
		<?php
			$nominativo_main = $main1;
			// NAME_2 ----------------------------------------------------------------------
			// Recupera i dati dalla tabella dei tumori:
			print ("<select name='name_2' size='1' cols='10'>");
			if ($name_2_new != NULL)
				print ("<OPTION VALUE='$name_2_new'>$name_2_new</OPTION>");
			
			print ("<OPTION VALUE='-'>--- </OPTION>");
			$query1 = "SELECT DISTINCT name_2 FROM tumors WHERE main = '$main1' AND name_1 = '$name_1_new'";
			$rs1 = mysql_query($query1);						
			while(list($name_2) = mysql_fetch_row($rs1))			
			{
				print ("<OPTION VALUE='$name_2'>$name_2</OPTION>");
			}
			print ("</select>");
		?>
		</td>
	</tr>		
</table>
<input type='submit' name='see_tumor' value="SEE TUMOR" />
<input type="hidden" name='id_paziente' value='<?php print $id_paziente; ?>' />
<input type="hidden" name='main' value='<?php print $nominativo_main; ?>' />
<input type="hidden" name='name_1_2' value='<?php print $name_1_new; ?>' />
<input type="hidden" name='start' value='<?php print $start; ?>' />

<br /><br />

	<?php
	if ( ($see_tumor == 'SEE TUMOR') && ($start != 1) )
	{
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
				<textarea cols='60' rows='4' name='note'> </textarea>
				</td>
			</tr>
		</table>
		</div>
		<?php
	}
	?>	

<br />
<?php
if ($start == 1)
{
?>
<div id='see_tumor'>
	<table border="0" width="45%" cellpadding="0" cellspacing="7">
		<tr>
			<td width="20%" align="right" id='font3'>Name &nbsp;</td>
			<td width="80%" align="left" id='form1'>
				<input type='text' name='name_altro' size='40' value=''>
			</td> 
		</tr>
		<tr>
			<td width="20%" align="right" id='font3'>Note &nbsp;</td>
			<td width="80%" align="left" id='form1'> 
			<textarea cols='60' rows='4' name='note'> </textarea>
			</td>
		</tr>
	</table>
</div>
<?php
}
?>
<br />

<br /><br>
<table border="0" width="53%" cellpadding="0" cellspacing="0">
	<tr>
		<td width="39%" align="right" id='font3'>Inserted in date: &nbsp;</td>
		<td width="61%" align="left">		
		<?php
		if ($errore_data_risultato == 1)
			print ("<input type='text' name='data_risultato' value='$data_risultato' size='20' id='form1_A'/>");
		else
			if (($permission == 3) || ($ok_inserimento == 1))
				print ("<font face='Verdana, Arial, Helvetica, sans-serif' size='3' color='#2ECCFA'>$data_risultato</font>");
			else
				print ("<input type='text' name='data_risultato' value='$data_risultato' size='20' id='form1'/>");
		?>	
		<font id='font4'>(gg/mm/aaaa)</font>
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
		<td width="70%" align="center"><hr width="86%" /></td>
		<td width="30%" align="center">
		<?php
			print ("<input type='submit' name='clear' value='CLEAR' id='form3'/> &nbsp &nbsp");	
			print ("<input type='submit' name='inserisci' value='INSERT' id='form2'/>");
		?>
		<input type="hidden" name='id_paziente' value='<?php print $id_paziente; ?>' />
		 </td>
	</tr>
	</table>
<?php
}
?>
</form>
	
<?php
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
}
?>	

<br />
<input type="button" onclick="javascript:window.close();" value='CLOSE' id='form2_3'/>
<br />
</div>
</body>
</html>