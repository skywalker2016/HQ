<?php
session_start();
include ("accesso_db.php");

if ($permission == NULL)
	header("Location:errore.html");
	
include ("convertitore_date.php");
require_once('class/class.patient.php');
require_once('class/class.dataExamInsert.php');

$pagina = 4;
include ("log.php");

$n_pazienti = $_SESSION['n'];
$id_finali = $_SESSION['id_finali'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
// Javascript function *****************************************************************************************************
function stat_function(link)
{
	var nome_tabella=link[link.selectedIndex].value;

	if (nome_tabella == '-')
	{}
	else
	{
		window.open('statistiche.php?nome_val='+nome_tabella);
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="style.css">
<title></title>
</head>
<body>
<div align="center">
<font id="font2">
Results
</font>
<br /><br />
<font id="font3">
<?php
if ($n_pazienti == 0)
	print ("No patient was found");
else if ($n_pazienti == 1)
	print ("It has found only 1 patient");
else
	print ("$n_pazienti pazienti have been found");	
?>
</font>
<br /><br />

<!-- STATISTICA ******************************************************** -->
<div id ='statistica'>
Statistics for &nbsp; &nbsp; &nbsp; &nbsp;  
<select name='stabella_statistica' size='1' cols='10' onChange="stat_function(this)" id='form_statistica'>
<OPTION VALUE='-'> </OPTION>
<OPTION VALUE='anagrafica'>Patient's registry </OPTION>
<OPTION VALUE='chemioterapia'>Chemoterapy </OPTION>
<OPTION VALUE='esame_tc'>TC scan </OPTION>
<OPTION VALUE='data_inserimento'>Insertion date </OPTION>
<OPTION VALUE='intervento'>Medical Surgery </OPTION>
<OPTION VALUE='permeabilita'>Permeability </OPTION>
<OPTION VALUE='rm_bold'>RM BOLD </OPTION>
<OPTION VALUE='rm_dti'>RM DTI </OPTION>
<OPTION VALUE='rm_morfologica'>Morphologic RM </OPTION>
<OPTION VALUE='rm_perfusione'>RM Perfusion </OPTION>
<OPTION VALUE='spettroscopia'>Spetttroscopy </OPTION>
<OPTION VALUE='sintomi'>Clinical presentation </OPTION>
<OPTION VALUE='terapia'>Medical Terapy </OPTION>
</select>
</div>

</br><br />
<?php
if ($n_pazienti == 0);
else
{
?>
		<table border="0" cellpadding="0" cellspacing="2" width="80%">
		<tr>
			<td align="center" width="25%" id='font3' bgcolor="#006699">
				LASTNAME
			</td>
			<td align="center" width="25%" id='font3' bgcolor="#006699">
				NAME
			</td>
			<td align="center" width="25%" id='font3' bgcolor="#006699">
				DATE OF BIRTH
			</td>	
			<td align="center" width="25%" id='font3' bgcolor="#006699">
				INSERTION DATE
			</td>	
		</tr>
		</table>
		<table border="0" cellpadding="0" cellspacing="2" width="80%">
	<?php
		for ($i=0; $i<$n_pazienti; $i++)
		{

				$paziente2 = new patient(NULL, NULL, NULL);
				$paziente2->retrive_by_ID($id_finali[$i]);
				$cognome = $paziente2->getSurname();
				$nome = $paziente2->getName();
				$data_nascita = $paziente2->getBirthday();	
				
				// Retrive the insert_data from Inserimento table by id_patient.
				$inserimento= new dataExamInsert(NULL);
				$inserimento -> setID_paziente($id_finali[$i]);
				$inserimento -> retrive_data();
				$data_inserimento=$inserimento -> getData_inserimento();
				
				$data_inserimento=data_convert_for_utente($data_inserimento);
				
				if($i& 1)
					$color='form2';
				else
					$color='form2_2';	
				
				if ($permission == 3) // Con Permission == 3 l'utente vede **** al posto di nome, cognome e data si nascita
				{
					$cognome = $cognome[0]."*******";
					$nome = $nome[0]."*******";
					$data_nascita = "*******";
				}
				else;
				
				print ("
					<tr>
						<td align='center' width='25%' id='$color'>	
						<a href='query_paziente_generale.php?id=$id_finali[$i]&ricerca=1'>$cognome</a>
						</td>
						<td align='center' width='25%' id='$color'>
							$nome
						</td>
						<td align='center' width='25%' id='$color'>
							$data_nascita
						</td>	
						<td align='center' width='25%' id='$color'>
							<strong>$data_inserimento</strong>
						</td>	
					</tr>	
				");
		}
		?>
		</table>
<?php
}
?>

<br />
</div>
</body>
</html>