<?php
session_start();
include ("accesso_db.php");

require_once('class/class.patient.php');
require_once('class/class.dataExamInsert.php');
include ("convertitore_date.php");
include ("function_php/try_format_date.php");

$pagina = 4;
include ("log.php");

if ($permission == NULL)
	header("Location:errore.html");

// Ritorna dalla pagina query_paziente.php : +++++++++++++++++++++++
if ($_REQUEST['ultima_ricerca'] != NULL)
{
	$n_totale_pazienti = $_SESSION['n_totale_pazienti'];
	$id_paz = $_SESSION['id_paz'];
}	
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Arriva da Home2.php +++++++++++++++++++++++++++++++++++++++++++++
else
{
	if ($_REQUEST['all'] != NULL)
	{
		$query = "SELECT id FROM patient ";	
		$rs = mysql_query($query);
		$n_totale_pazienti=0;
		while(list($id) = mysql_fetch_row($rs))
		{
			$id_paz[$n_totale_pazienti] = $id;
			$n_totale_pazienti=$n_totale_pazienti+1;
		}
	
		if ($n_totale_pazienti != 0)
		sort($id_paz);
	}
	else
	{
		$n_totale_pazienti = 0;
		
		// Retrive the name of patient from home2.php
		$nominativo_paziente = $_REQUEST['nominativo_paziente'];
		if ($nominativo_paziente == "")
			$nominativo_paziente ='(()))((()))(((()))';
		
		$paziente = new patient(NULL, NULL, NULL);
		
		// Search the patiente by COGNOME:
		$paziente->setSurname($nominativo_paziente);
		$paziente->retrive_2(1);
		
		$numero_pazienti_cognome = $paziente->getNumero_pazienti();
		
		for ($i=0; $i<$numero_pazienti_cognome; $i++)
		{
			$id_paz_nome[$i] = $paziente->getID_patient_array($i);
		}	
		
		// Search the patiente by NOME:
		$paziente->setName($nominativo_paziente);
		$paziente->retrive_2(2);
		
		$numero_pazienti_nome = $paziente->getNumero_pazienti();
		
		for ($i=0; $i<$numero_pazienti_nome; $i++)
		{
			$id_paz_cognome[$i] = $paziente->getID_patient_array($i);
		}	
		
		if ($id_paz_cognome == NULL)
			$id_paz = $id_paz_nome;
		
		if ($id_paz_nome == NULL)
			$id_paz = $id_paz_cognome;	
			
		if (($id_paz_nome == NULL) && ($id_paz_cognome == NULL));
			
		if (($id_paz_nome != NULL) && ($id_paz_cognome != NULL))	
			$id_paz = array_merge($id_paz_cognome, $id_paz_nome);  // Fonde i due array in un unico array
		
		$n_totale_pazienti = $numero_pazienti_nome + $numero_pazienti_cognome;
		
		if ($n_totale_pazienti != 0)
			sort($id_paz);
	}
		// ***** Registra nelle sessioni il numero totale dei pazienti e tutti gli ID ******************
		// ***** in modo tale da poter rcuperare i risultati quando l'utente utilizza 'Ritorno Ricerca'*
		$_SESSION['n_totale_pazienti'] = $n_totale_pazienti;
		$_SESSION['id_paz'] = $id_paz;
		// **********************************************************************************************

}
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
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
<font id="font2">
Ricerca paziente
</font>
<br /><br />
<font id="font3">
<?php
if ($n_totale_pazienti == 0)
	print ("Non sono stati trovati pazienti");
else if ($n_totale_pazienti == 1)
	print ("E' stato trovato un solo paziente");
else
	print ("Sono stati trovati $n_totale_pazienti pazienti");	
?>
</font>
<br /><br />
<?php
if ($n_totale_pazienti == 0);
else
{
?>
		<table border="0" cellpadding="0" cellspacing="2" width="80%">
		<tr>
			<td align="center" width="25%" id='font3' bgcolor="#006699">
				COGNOME
			</td>
			<td align="center" width="25%" id='font3' bgcolor="#006699">
				NOME
			</td>
			<td align="center" width="25%" id='font3' bgcolor="#006699">
				DATA NASCITA
			</td>	
			<td align="center" width="25%" id='font3' bgcolor="#006699">
				DATA INSERIMENTO
			</td>	
		</tr>
		</table>
		<table border="0" cellpadding="0" cellspacing="2" width="80%">
		<?php
		for ($i=0; $i<$n_totale_pazienti; $i++)
		{
			if ($id_paz[$q] == $id_paz[$i]);
			else
			{
				$paziente2 = new patient(NULL, NULL, NULL);
				$paziente2->retrive_by_ID($id_paz[$i]);
				$cognome = $paziente2->getSurname();
				$nome = $paziente2->getName();
				$data_nascita = $paziente2->getBirthday();	
				
				// Retrive the insert_data from Inserimento table by id_patient.
				$inserimento= new dataExamInsert(NULL);
				$inserimento -> setID_paziente($id_paz[$i]);
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
						<a href='query_paziente_generale.php?id=$id_paz[$i]'>$cognome</a>
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
			$q=$i;
		}
		?>
		</table>
<?php
}
?>
</body>
</html>
