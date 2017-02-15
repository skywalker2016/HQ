<?php
session_start();
include ("accesso_db.php");

$pagina = 32;
include ("log.php");

if ($permission == NULL)
	header("Location:errore.html");
	
include ("convertitore_date.php");

require_once('class/class.istologia.php');
require_once('class/class.patient.php');


$clear = $_REQUEST['clear'];
if ($clear == 1)
{
	$query = "TRUNCATE TABLE tumors_prov"; 
	$eliminazione = mysql_query($query);
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


// SEE Patients **********************************************************************
if ($_REQUEST['see_patients'] == 'See Patients')
{
	$main1 = $_REQUEST['main'];
	$name_1_new = $_REQUEST['name_1_2'];
	$name_2_new = $_REQUEST['name_2'];
	$name_tumor = $_REQUEST['name_tumor'];

	$see_tumor = 'SEE TUMOR';

	$isto = new istologia (NULL, NULL, NULL);
	$isto -> retrive_by_nome_tumore($name_tumor);
}
// **********************************************************************************

if ($_REQUEST['pubmed'] == 'PUBMED results')
{
	$main1 = $_REQUEST['main'];
	$name_1_new = $_REQUEST['name_1_2'];
	$name_2_new = $_REQUEST['name_2'];
	$name_tumor = $_REQUEST['name_tumor'];
	$see_tumor = 'SEE TUMOR';
	
	echo("<script language=\"javascript\">"); 
	echo("window.open('http://www.ncbi.nlm.nih.gov/pubmed?term=$name_tumor');");
	echo("</script>"); 
}


// TUMORS update **********************************************************************
if ($_REQUEST['tumors_update'] == 'Tumors UPDATE')
{
	// link of the repository:
	$link='http://tumorsdatabase.altervista.org/tumors.sql';
	// open the web page:
	$page = file_get_contents($link);

	$write_file = fopen("update_tumors/tumors.sql","w");
	fwrite($write_file,$page);
	fclose($write_file);

	$query = "TRUNCATE TABLE tumors"; 
	$eliminazione = mysql_query($query);

	$username_mysql = $_SESSION['username_mysql'];
	$password_mysql = $_SESSION['password_mysql'];
	
	$percorso_ripristino = 'update_tumors/tumors.sql';
	$ripristino=("mysql -u$username_mysql -p$password_mysql my_tumorsdatabase < ").$percorso_ripristino;  
	system($ripristino);

	$ripristino_ok=1;
}
// **********************************************************************************

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
// Javascript function *****************************************************************************************************
function main_function(link, id_paz)
{
	var main_name=link[link.selectedIndex].value;

	var destination_page = "tumors_engine.php";
	location.href = destination_page+"?reg=1&main="+main_name+"&id_paziente="+id_paz;
}

function name1_function(link, main_name, id_paz)
{
	var name1=link[link.selectedIndex].value;

	var destination_page = "tumors_engine.php";
	location.href = destination_page+"?reg=2&main="+main_name+"&id_paziente="+id_paz+"&name1="+name1;
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="style.css">
<title></title>
</head>
<body>
<div align="center">
<br />
<font id="font2">
Tumors Engine
</font>
<br /><br />

<form action="tumors_engine.php" method="post">
<table border="0" width="70%" cellpadding="0" cellspacing="4">
	<tr>
		<td width="20%" align="right" id='font3'>Find a tumor &nbsp;</td>
		<td width="70%" align="left" id='form1'> 
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
<form action="tumors_engine.php" method="post">
<table border="0" width="60%" cellpadding="0" cellspacing="4">
	<tr>
		<td width="30%" align="right" id='font3'>Choose a tumor (Family) &nbsp;</td>
		<td width="70%" align="left" id='form1'> 
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
<br />
<input type='submit' name='see_tumor' value="SEE TUMOR" />
<input type="hidden" name='id_paziente' value='<?php print $id_paziente; ?>' />
<input type="hidden" name='main' value='<?php print $nominativo_main; ?>' />
<input type="hidden" name='name_1_2' value='<?php print $name_1_new; ?>' />
</form>

<br />
	<?php
	if ( ($see_tumor == 'SEE TUMOR') )
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
		</div>
		<?php
	}
	?>	
<br /><br />

<form action="tumors_engine.php" method="post">
<div id='tumors_engine'>
	<table border="0" width="100%" cellpadding="0" cellspacing="2">
		<tr>
			<td align="center" width="20%">
			</td>		
			<td align="center" width="20%">
				<input type="submit" name='see_patients' value='See Patients' />
			</td>
			<td align="center" width="20%">
				<input type="submit" name='pubmed' value='PUBMED results' />
			</td>
			<td align="center" width="20%">
				<input type="submit" name='tumors_update' value='Tumors UPDATE' />
			</td>
			<td align="center" width="20%">
			</td>
		</tr>
	</table>
</div>
<input type="hidden" name='id_paziente' value='<?php print $id_paziente; ?>' />
<input type="hidden" name='main' value='<?php print $nominativo_main; ?>' />
<input type="hidden" name='name_1_2' value='<?php print $name_1_new; ?>' />
<input type="hidden" name='name_tumor' value='<?php print $name_tumor; ?>' />
<input type="hidden" name='name_2' value='<?php print $name_tumor; ?>' />
</form>

<br />

<?php
// Table to show the patients with this tumor ------------------------------------
// -------------------------------------------------------------------------------
if ($_REQUEST['see_patients'] == 'See Patients')
{
?>
<br />
	<font id='font3'>Patients with <?php print $name_tumor; ?></font>
	<table border="0" width="60%" cellpadding="0" cellspacing="1">
		<tr>
			<td align="center" width="30%" id='font3' bgcolor="#006699">Surname</td>
			<td align="center" width="30%" id='font3' bgcolor="#006699">Name</td>				
			<td align="center" width="40%" id='font3' bgcolor="#006699">Recorded on</td>
		</tr>
	</table>
	<table border="0" width="60%" cellpadding="0" cellspacing="1">
	<?php
	for ($i=0; $i<$n_istologia; $i++)
	{
		if($i& 1)
			$color='form2';
		else
			$color='form2_2';	
	
		$id_istologia = $isto -> getID_array($i);
		$isto -> retrive_by_id($id_istologia);
		
		$id_paziente = $isto -> getID_paziente();
		$paziente = new patient(NULL, NULL, NULL);
		$paziente -> retrive_by_ID($id_paziente);

		$surname = $paziente -> getSurname();
		$name = $paziente -> getName();
		$data_ris = data_convert_for_utente ($isto -> getData_risultato());
		
		if ($permission == 3) // Con Permission == 3 l'utente vede **** al posto di nome, cognome
		{
			$surname = $surname[0]."*******";
			$name = $name[0]."*******";
		}
		else;

		print ("
				<tr>
					<td align='center' width='30%' id='$color'>	$surname</td>
					<td align='center' width='30%' id='$color'>	$name</td>
					<td align='center' width='40%' id='$color'>	$data_ris</td>
				</tr>	
				");
	}
	?>
	</table>
<?php
}
// ---------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------
?>

<?php
if ($ripristino_ok == 1)
{
	print("
		<font face='Verdana, Arial, Helvetica, sans-serif' color='#FFFF99' size='4'>L'update dei tumori è avvenuto con successo</font>
		");
}
?>
<br />
</div>
</body>
</html>