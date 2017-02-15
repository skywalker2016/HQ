<?php
// ****************** MOTORE RICERCA *************************************************************
session_start();
include ("accesso_db.php");

if ($permission == NULL)
	header("Location:errore.html");

include ("convertitore_date.php");
require_once('class/class.patient.php');


// delete SESSION:
$_SESSION['id_finali'] = NULL;

function controllo_formato_data_aaaa($data)  // controlla se il formato della data e' in AAAA
{
	if (strlen($data) != 4)
		return (1);
	else
	{
		for ($i=0; $i<4; $i++)
			if (is_numeric($data[$i]))
				$error = 0;
			else
			{
				return (1);		
			}

		return ($error);
	}
}

$ricerca_anagrafica = $_REQUEST['ricerca_anagrafica'];

// +++++++RICERCA DI TIPO ANAGRAFICO ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
if ($ricerca_anagrafica == 'GO')
{
	$paz = new patient(NULL, NULL, NULL);

	// recupera il dato per la ricerca
	$valore_anagrafica = $_REQUEST['valore_anagrafica'];

	// recupera il tipo di ricerca anagrafica (cognome / nome / data nascita / sesso)
	$tipo_anagrafica = $_REQUEST['tipo_anagrafica'];
	
		
	// ^^^^^^^^^^^^^^^^^ DATA DI NASCITA ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
	if ($tipo_anagrafica == 'data_nascita')
	{
		// controlla se la data e' in formato aaaa:
		$errore_data1 = controllo_formato_data_aaaa($valore_anagrafica);
		
		if ($errore_data1 == 1)
		{
			// controlla che la data sia nel formato gg/mm/aaaa:
			$errore_data2=controllo_data($valore_anagrafica);

			if ($errore_data2 == 1);
			else
			{		
				// converte la data:
				$data_nascita = data_convert_for_mysql($valore_anagrafica);
				// deve ricavare il numero dei pazienti che hanno questa data di nascita:
				$paz->retrive_by_anno(2, $data_nascita);			
				$numero_pazienti = $paz->getNumero_pazienti();

				// recupera gli ID dei pazienti:
				for ($i=0; $i<$numero_pazienti; $i++)
					$id_finali[$i] = $paz->getID_patient_array($i);
	
				// registra nella sessione gli ID dei pazienti trovati:
				$_SESSION['id_finali'] = $id_finali;
				$_SESSION['n'] = $numero_pazienti;
			
			header( "Location: visualizza_ricerca.php");
			} // fine IF controlla data in GG-MM-AAAA

		} // fine IF controlla data in AAAA
		else
		{
			// +++++++++++ ricerca per la data in AAAA ++++++++++
			$data_nascita = $valore_anagrafica;
				
			// deve ricavare il numero dei pazienti che hanno questa data di nascita:
			$paz->retrive_by_anno(1, $data_nascita);
			$numero_pazienti = $paz->getNumero_pazienti();

			// recupera gli ID dei pazienti:
			for ($i=0; $i<$numero_pazienti; $i++)
				$id_finali[$i] = $paz->getID_patient_array($i);

			// registra nella sessione gli ID dei pazienti trovati:
			$_SESSION['id_finali'] = $id_finali;
			$_SESSION['n'] = $numero_pazienti;
			
			header( "Location: visualizza_ricerca.php");
			
		} // fine ELSE controllo data in AAAA

	} // fine IF della data di nascita
	// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^


	// ^^^^^^^^^^^^^^^^^ SESSO ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
	if ($tipo_anagrafica == 'sesso')
	{
		// controlla se il formato del sesso Ã¨ corretto:
		if ( ($valore_anagrafica != 'F') &&  ($valore_anagrafica != 'f') && ($valore_anagrafica != 'M') && ($valore_anagrafica != 'm') )
			$error_sesso=1;  
		else
		{
			$sesso = strtolower($valore_anagrafica);

			// deve ricavare il numero dei pazienti che hanno questa data di nascita:
			$paz->retrive_by_generic_var(1, $sesso);
			$numero_pazienti = $paz->getNumero_pazienti();

			// recupera gli ID dei pazienti:
			for ($i=0; $i<$numero_pazienti; $i++)
				$id_finali[$i] = $paz->getID_patient_array($i);

			// registra nella sessione gli ID dei pazienti trovati:
			$_SESSION['id_finali'] = $id_finali;
			$_SESSION['n'] = $numero_pazienti;
			
			header( "Location: visualizza_ricerca.php");
		}
	} // fine IF del SESSO
	// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^


	// ^^^^^^^^^^^^^^^^^ COGNOME ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
	if ($tipo_anagrafica == 'cognome')
	{
		// controlla se il formato del sesso Ã¨ corretto:
		if ($valore_anagrafica == NULL)
			$error_nominativo=1;  
		else
		{
			$cognome = strtoupper($valore_anagrafica);

			// deve ricavare il numero dei pazienti che hanno questa data di nascita:
			$paz->retrive_by_generic_var(2, $cognome);
			$numero_pazienti = $paz->getNumero_pazienti();

			// recupera gli ID dei pazienti:
			for ($i=0; $i<$numero_pazienti; $i++)
				$id_finali[$i] = $paz->getID_patient_array($i);

			// registra nella sessione gli ID dei pazienti trovati:
			$_SESSION['id_finali'] = $id_finali;
			$_SESSION['n'] = $numero_pazienti;
			
			header( "Location: visualizza_ricerca.php");
		}
	} // fine IF del Cognome
	// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^


	// ^^^^^^^^^^^^^^^^^ NOME ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
	if ($tipo_anagrafica == 'nome')
	{
		// controlla se il formato del sesso Ã¨ corretto:
		if ($valore_anagrafica == NULL)
			$error_nominativo=1;  
		else
		{
			$nome = strtoupper($valore_anagrafica);

			// deve ricavare il numero dei pazienti che hanno questa data di nascita:
			$paz->retrive_by_generic_var(3, $nome);
			$numero_pazienti = $paz->getNumero_pazienti();

			// recupera gli ID dei pazienti:
			for ($i=0; $i<$numero_pazienti; $i++)
				$id_finali[$i] = $paz->getID_patient_array($i);

			// registra nella sessione gli ID dei pazienti trovati:
			$_SESSION['id_finali'] = $id_finali;
			$_SESSION['n'] = $numero_pazienti;
			
			header( "Location: visualizza_ricerca.php");
		}
	} // fine IF del Nome
	// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

}
// FINE RICERCA DI TIPO ANAGRAFICO+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


// RICERCA AVANZATA+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
if ($_REQUEST['ricerca_avanzata'] =='Submit')
{
	// Funzione che inserisce i dati nella tabella temporanea ------------------------------------
	function insert_temporary_table($name_temporary_table, $id, $n)
	{
		$query = "INSERT INTO $name_temporary_table
			(id, id_soggetto, number)
			VALUES
			(NULL, '$id', '$n')";
		$rs = mysql_query($query);
	}
	// ---------------------------------------------------------------------------

	function retrive_motore_ricerca($flag, $nome_colonna, $operazione, $valore, $tabella, $name_temporary_table, $n)
	{
		if ($flag == 1)
			$query = "SELECT id_paziente FROM $tabella WHERE $nome_colonna $operazione '$valore'";
		if ($flag == 2)
			$query = "SELECT id_paziente FROM $tabella WHERE $nome_colonna LIKE '%$valore%'";
			
		$rs = mysql_query($query);
		while(list($id) = mysql_fetch_row($rs))
		{
			insert_temporary_table($name_temporary_table, $id, $n);		
		}
	}	
	
	function retrive_motore_ricerca_pt($flag, $nome_colonna, $operazione, $valore, $tabella, $name_temporary_table, $n)
	{
		if ($flag == 1)
			$query = "SELECT id FROM $tabella WHERE $nome_colonna $operazione '$valore'";
		if ($flag == 2)
			$query = "SELECT id FROM $tabella WHERE $nome_colonna LIKE '%$valore%'";
		
		$rs = mysql_query($query);
		while(list($id) = mysql_fetch_row($rs))
		{
			insert_temporary_table($name_temporary_table, $id, $n);		
		}
	}	
			
	// Recupera gli ARRAY tramite SESSION dei valori della ricerca avanzata:
	$nome_tabella = $_SESSION['nome_tabella'];
	$nome_campo = $_SESSION['nome_campo'];
	$nome_operazione = $_SESSION['nome_operazione'];
	$nome_valore = $_SESSION['nome_valoree'];
	$and_or = $_REQUEST['and_or'];

	// *********** La ricerca verrà ffettuata su tutti e 10 le righe ***********	
	$data = time();
	$name_temporary_table = "id_search".$data;
	
	// Create a temporary table to insert the id:
	$query_table = "CREATE TABLE $name_temporary_table (id INT(9) NOT NULL PRIMARY KEY AUTO_INCREMENT, id_soggetto INT(9), number INT(2))";
	$r_query_table = mysql_query($query_table);	


	// Inizio ciclo FOR +++++++++++++++++++++++++++++++++++++++++++++
	$n_campi = 0;
	for ($i=0; $i<10; $i++)
	{
		$n= $i+1;
			
		if ($nome_tabella[$i] != NULL)
			$n_campi = $n_campi +1;
			
			// controllo_operazioni:
			if ($nome_operazione[$i] == 'uguale')
			{
				$nome_operazione[$i] = '=';
				$flag = 1;
			}
			if ($nome_operazione[$i] == 'maggiore')
			{
				$nome_operazione[$i] = '>';
				$flag = 1;
			}	
			if ($nome_operazione[$i] == 'minore')
			{
				$nome_operazione[$i] = '<';
				$flag = 1;
			}		
			if ($nome_operazione[$i] == 'maggiore_uguale')
			{
				$nome_operazione[$i] = '>=';
				$flag = 1;
			}		
			if ($nome_operazione[$i] == 'minore_uguale')
			{
				$nome_operazione[$i] = '<=';
				$flag = 1;
			}		
			if ($nome_operazione[$i] == 'diverso')
			{
				$nome_operazione[$i] = '!=';
				$flag = 1;
			}		

			// controllo sulle variabili:
			if ($nome_valore[$i] == 'si')
				$nome_valore[$i] = 'on';				
			else if ($nome_valore[$i] == 'no')
				$nome_valore[$i] = NULL;	
		
		
		// ############ CHEMIOTERAPIA ###################
		if ($nome_tabella[$i] == 'chemioterapia')
		{		
			if ( ($nome_campo[$i] == 'data_temozolomide') || ($nome_campo[$i] == 'data_pc_v') || ($nome_campo[$i] == 'data_fotemustina') || ($nome_campo[$i] == 'data_altro') || ($nome_campo[$i] == 'data_terapia_supprto') )
				$nome_valore[$i] = data_convert_for_mysql($nome_valore[$i]);

			retrive_motore_ricerca($flag, $nome_campo[$i], $nome_operazione[$i], $nome_valore[$i], $nome_tabella[$i], $name_temporary_table, $n);
		} // fine chemioterapia

		// ############ ESAME TC ###################
		if ($nome_tabella[$i] == 'esame_tc')
		{		
			if ($nome_campo[$i] == 'data_inserimento')
				$nome_valore[$i] = data_convert_for_mysql($nome_valore[$i]);

			retrive_motore_ricerca($flag, $nome_campo[$i], $nome_operazione[$i], $nome_valore[$i], $nome_tabella[$i], $name_temporary_table, $n);
		} // fine esame_tc

		// ############ DATA INSERIMENTO ESAME ###################
		if ($nome_tabella[$i] == 'inserimento')
		{		
			if ($nome_campo[$i] == 'data_inserimento')
				$nome_valore[$i] = data_convert_for_mysql($nome_valore[$i]);

			retrive_motore_ricerca($flag, $nome_campo[$i], $nome_operazione[$i], $nome_valore[$i], $nome_tabella[$i], $name_temporary_table, $n);
		} // fine data inserimento esame


		// ############ INTERVENTO ###################
		if ($nome_tabella[$i] == 'intervento')
		{		
			if  ( ($nome_campo[$i] == 'data_inserimento') || ($nome_campo[$i] == 'data_biopsia') || ($nome_campo[$i] == 'data_resezione_totale') || ($nome_campo[$i] == 'data_resezione_parziale') || ($nome_campo[$i] == 'data_resezione_gliadel') ) 
				$nome_valore[$i] = data_convert_for_mysql($nome_valore[$i]);

			retrive_motore_ricerca($flag, $nome_campo[$i], $nome_operazione[$i], $nome_valore[$i], $nome_tabella[$i], $name_temporary_table, $n);
		} // fine intervento

		// ############ ISTOLOGIA ###################
		if ($nome_tabella[$i] == 'istologia')
		{		
			if  ($nome_campo[$i] == 'data_risultato') 
				$nome_valore[$i] = data_convert_for_mysql($nome_valore[$i]);
			else
				$flag=2;

			retrive_motore_ricerca($flag, $nome_campo[$i], $nome_operazione[$i], $nome_valore[$i], $nome_tabella[$i], $name_temporary_table, $n);
		} // fine istologia

		// ############ PERMEABILITA' ###################
		if ($nome_tabella[$i] == 'permeabilita')
		{		
			if  ($nome_campo[$i] == 'data_inserimento') 
				$nome_valore[$i] = data_convert_for_mysql($nome_valore[$i]);

			retrive_motore_ricerca($flag, $nome_campo[$i], $nome_operazione[$i], $nome_valore[$i], $nome_tabella[$i], $name_temporary_table, $n);
		} // fine permeabilità

		// ############ RM BOLD ###################
		if ($nome_tabella[$i] == 'rm_bold')
		{		
			if  ($nome_campo[$i] == 'data_inserimento') 
				$nome_valore[$i] = data_convert_for_mysql($nome_valore[$i]);
			if ( ($nome_campo[$i] == 'motorio_altro') || ($nome_campo[$i] == 'sensitiva_sede') || ($nome_campo[$i] == 'sensitiva_altro') )
				$flag = 2;

			retrive_motore_ricerca($flag, $nome_campo[$i], $nome_operazione[$i], $nome_valore[$i], $nome_tabella[$i], $name_temporary_table, $n);
		} // fine rm_bold

		// ############ RM DTI ###################
		if ($nome_tabella[$i] == 'rm_dti')
		{		
			if  ($nome_campo[$i] == 'data_inserimento') 
				$nome_valore[$i] = data_convert_for_mysql($nome_valore[$i]);

			retrive_motore_ricerca($flag, $nome_campo[$i], $nome_operazione[$i], $nome_valore[$i], $nome_tabella[$i], $name_temporary_table, $n);
		} // fine rm_dti

		// ############ RM MORFOLOGICA ###################
		if ($nome_tabella[$i] == 'rm_morfologica')
		{		
			if  ($nome_campo[$i] == 'data_inserimento') 
				$nome_valore[$i] = data_convert_for_mysql($nome_valore[$i]);

			retrive_motore_ricerca($flag, $nome_campo[$i], $nome_operazione[$i], $nome_valore[$i], $nome_tabella[$i], $name_temporary_table, $n);
		} // fine rm_morfologica

		// ############ RM PERFUSIONE ###################
		if ($nome_tabella[$i] == 'rm_perfusione')
		{		
			if  ($nome_campo[$i] == 'data_inserimento') 
				$nome_valore[$i] = data_convert_for_mysql($nome_valore[$i]);

			retrive_motore_ricerca($flag, $nome_campo[$i], $nome_operazione[$i], $nome_valore[$i], $nome_tabella[$i], $name_temporary_table, $n);
		} // fine rm_perfusione

		// ############ RM SPETTROSCOPICA ###################
		if ($nome_tabella[$i] == 'rm_spettroscopica')
		{		
			if  ($nome_campo[$i] == 'data_inserimento') 
				$nome_valore[$i] = data_convert_for_mysql($nome_valore[$i]);

			retrive_motore_ricerca($flag, $nome_campo[$i], $nome_operazione[$i], $nome_valore[$i], $nome_tabella[$i], $name_temporary_table, $n);
		} // fine rm_spettroscopica

		// ############ SINTOMI ###################
		if ($nome_tabella[$i] == 'sintomi')
		{		
			if  ($nome_campo[$i] == 'data_inserimento') 
				$nome_valore[$i] = data_convert_for_mysql($nome_valore[$i]);
			if ( ($nome_campo[$i] == 'note') || ($nome_campo[$i] == 'altro') )
				$flag = 2;				
				
			retrive_motore_ricerca($flag, $nome_campo[$i], $nome_operazione[$i], $nome_valore[$i], $nome_tabella[$i], $name_temporary_table, $n);
		} // fine sintomi

		// ############ TERAPIA ###################
		if ($nome_tabella[$i] == 'terapia')
		{		
			if  ( ($nome_campo[$i] == 'data_rt_conformazionale') || ($nome_campo[$i] == 'data_radiochirurgia') ) 
				$nome_valore[$i] = data_convert_for_mysql($nome_valore[$i]);			
				
			retrive_motore_ricerca($flag, $nome_campo[$i], $nome_operazione[$i], $nome_valore[$i], $nome_tabella[$i], $name_temporary_table, $n);;
		} // fine terapia

		// ############ ANAGRAFICA ###################
		if ($nome_tabella[$i] == 'anagrafica')
		{		
			if  ($nome_campo[$i] == 'data_decesso')
				$nome_valore[$i] = data_convert_for_mysql($nome_valore[$i]);
			if  ($nome_campo[$i] == 'reparto_provenienza')				
				$nome_valore[$i]=strtoupper($nome_valore[$i]);			
			if  ($nome_campo[$i] == 'eta')
			{				
				$nome_campo[$i]='date_birthday';
				// tramite l'età deve calcolare l'anno di nascita:
				$eta=$nome_valore[$i];
				$anno= date(Y);
				
				$anno_nascita = $anno-$eta;
				$nome_valore[$i] = $anno_nascita.'-01-01';
					
				// si deve invertire i segni:
				if ($nome_operazione[$i] == '>')
				{
					$nome_operazione[$i] = '<';
				}	
				else if ($nome_operazione[$i] == '<')
				{
					$nome_operazione[$i] = '>';
				}		
				else if ($nome_operazione[$i] == '>=')
				{
					$nome_operazione[$i] = '<=';
				}		
				else if ($nome_operazione[$i] == '<=')
				{
					$nome_operazione[$i] = '>=';
				}		
				else;			
			}

			$nome_tabella_new = 'patient';
			retrive_motore_ricerca_pt($flag, $nome_campo[$i], $nome_operazione[$i], $nome_valore[$i], $nome_tabella_new, $name_temporary_table, $n);						
		} // fine anagrafica

	}
	// FINE ciclo FOR +++++++++++++++++++++++++++++++++++++++++++++

	// *************** Dalla tabella temporanea deve recuperare gli ID trovati tramite  ditinct ***********************

	$query = "SELECT DISTINCT id_soggetto FROM $name_temporary_table ";	
	$rs = mysql_query($query);
	$n_soggetti = 0; 
	while(list($id) = mysql_fetch_row($rs))
	{
		$id1[$n_soggetti] = $id;
		$n_soggetti = $n_soggetti + 1;		
	}	

	// Se si ha OR :
	if ($and_or  == 'or')
		$id_finali = $id1;

	// Se si ha AND:
	$tt=0;
	if ($and_or  == 'and')
	{
		for ($i=0; $i<$n_soggetti; $i++)
		{
			// conta quante vole il soggetto è all'interno della tabella temporanea
			$query = "SELECT  COUNT(id_soggetto) FROM $name_temporary_table WHERE id_soggetto = '$id1[$i]' ";	
			$rs = mysql_query($query);
			while(list($n_id) = mysql_fetch_row($rs))
			{
				if ($n_id == $n_campi)
				{
					$id_finali[$tt] = $id1[$i];	
					$tt = $tt+1;
				}
			}	
		}
		$n_soggetti = $tt;	
	}

	// remove the temporary table:	
	$query_del = "DROP TABLE $name_temporary_table";
	$r_query_del = mysql_query($query_del);		


	// registra nella sessione gli ID dei pazienti trovati:
	$_SESSION['id_finali'] = $id_finali;
	$_SESSION['n'] = $n_soggetti;

	header( "Location: visualizza_ricerca.php");
}
// FINE RICERCA DI TIPO AVANZATO++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


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
<br><br><br>
<?php
if ($errore_data2 == 1)
	print ("<font size='4' color='#CCFF99' face='Verdana, Arial, Helvetica, sans-serif'> Non hai inserito il valore della data di nascita in maniera corretta. Ricontrolla!</font>");

if ($error_sesso == 1)
	print ("<font size='4' color='#CCFF99' face='Verdana, Arial, Helvetica, sans-serif'> Non hai inserito il valore del sesso in maniera corretta. Ricontrolla, deve essere F oppure M.</font>");

if ($error_nominativo == 1)
	print ("<font size='4' color='#CCFF99' face='Verdana, Arial, Helvetica, sans-serif'> Hai lasciato il campo vuoto. Ricontrolla! </font>");
?>
</div>
</body>
</html>