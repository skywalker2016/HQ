<?php
session_start();
include ("accesso_db.php");

if ($permission == NULL)
	header("Location:errore.html");
	
require_once('class/class.patient.php');
require_once('class/class.dataExamInsert.php');
include ("convertitore_date.php");
include ("function_php/calcolo_frequenza.php");
require_once('class/class.chemioterapia.php');
require_once('class/class.esame_tc.php');
require_once('class/class.dataExaminsert.php');
require_once('class/class.intervento.php');
require_once('class/class.permeabilita.php');
require_once('class/class.rm_bold.php');
require_once('class/class.rm_dti.php');
require_once('class/class.rm_morfologica.php');
require_once('class/class.rm_perfusione.php');
require_once('class/class.rm_spettroscopica.php');
require_once('class/class.sintomi.php');
require_once('class/class.terapia.php');




// Funzione che calcola la media: ********************
function media($n, $var)
{
	$sum=0;
	for ($i=0; $i<$n; $i++)
        {
	    $sum = $sum + $var[$i];
        }

	$average = $sum / $n;
	return ($average);
}
// Function to calculate the SD:
function SD($n, $var, $mean)
{
	$sum=0;
	for ($i=0; $i<$n; $i++)
        {
            $sum = $sum + (($mean-$var[$i])*($mean-$var[$i]));
        }

	$sd = sqrt(($sum/($n)));
	return ($sd);
}
// Function to calculate the min and max:
function min_max($n, $var, $nome_campo1)
{
	$q=$n-1;
	sort($var);
	$value[0] = $var[0];   // minimun value
	$value[1] = $var[$q];  // max value
        
    if ( ($nome_campo1 == 'VALORE DI K TRANS') || ($nome_campo1 == 'VALORE DI vi') )
	{
	    $value[0]=number_format($value[0],4,".","");
        $value[1]=number_format($value[1],4,".","");	
	}
	else	
	{
	    $value[0]=number_format($value[0],2,".","");
        $value[1]=number_format($value[1],2,".","");
    }
	
	 return ($value);
}
// Function to calculate the median:
function mediana($numbers=array())
{
	if (!is_array($numbers))
		$numbers = func_get_args();
	
	rsort($numbers);
	$mid = (count($numbers) / 2);

	return ($mid % 2 != 0) ? $numbers{$mid-1} : (($numbers{$mid-1}) + $numbers{$mid}) / 2;
}



$n_pazienti = $_SESSION['n'];
$id_finali = $_SESSION['id_finali'];

$nome_tabella = $_REQUEST['nome_val'];
$nome_campo = $_REQUEST['nome_stat'];

$paziente = new patient (NULL, NULL, NULL);

$pagina = 31;
include ("log.php");






// ************************** ANAGRAFICA *************************************************************************************
// CAMPO ETA' ---------------------------------------------------------------------------------------------
if ($nome_campo == 'eta')
{
	$nome_campo1 = "AGE (years)";
	// deve calcolare l'eta dei pazienti:
	$anno= date(Y);	

	// recupera la data di nascita del paziente:
	for ($i=0; $i<$n_pazienti; $i++)
	{
		$paziente -> retrive_by_ID($id_finali[$i]);
		$nascita = $paziente -> getBirthday();
		$nascita=data_convert_for_mysql($nascita);

		$anno_nascita =NULL;
		for ($q=0; $q<4; $q++)
			$anno_nascita=$anno_nascita.$nascita[$q];

		$valori[$i] = $anno-$anno_nascita;

		$id_finali_new2[$i] = $id_finali[$i];
	}
}

// CAMPO REPARTO DI PROVENIENZA -----------------------------------------------------------------------------
if ($nome_campo == 'reparto_provenienza')
{
	$nome_campo1 = "ORIGIN DEPARTMENT";

	// Deve vedere i reparti di provenienza presenti all'interno del database per questi pazienti:
	$query = "SELECT DISTINCT reparto_provenienza FROM patient";
	$rs = mysql_query($query);
	$n_reparto = 0;
	while(list($reparto_provenienza) = mysql_fetch_row($rs))
	{
		$reparto[$n_reparto] = $reparto_provenienza;
		$n_reparto = $n_reparto + 1;
	}	
}

// CAMPO ANNI DI VITA -----------------------------------------------------------------------------
if ($nome_campo == 'anni_vita')
{
		$nome_campo1 = "YEARS OF LIVE (Years)";

		$n8=0;
		for ($i=0; $i<$n_pazienti; $i++)
		{
			$paziente -> retrive_by_ID($id_finali[$i]);
			$nascita = $paziente -> getBirthday();
			$nascita = data_convert_for_mysql($nascita);
	
			$morte = $paziente -> getData_decesso();
			
			if ($morte != NULL)
			{
				$anno_morte = NULL;
				$anno_nascita = NULL;
				for ($pp=0; $pp<4; $pp++)
					$anno_morte = $anno_morte.$morte[$pp];
				for ($pp=0; $pp<4; $pp++)
					$anno_nascita = $anno_nascita.$nascita[$pp];			
												
				$durata_anno =$anno_morte-$anno_nascita;				
				$valori[$n8] = $durata_anno;
			
				$id_finali_new2[$n8] = $id_finali[$i];
				$n8=$n8+1;
			}		
			else;
		}	
	$n_pazienti = $n8;
}
// *****************************************************************************************************************************


// ************************** CHEMIOTERAPIA *************************************************************************************
// CAMPI SI/NO ---------------------------------------------------------------------------------------------
if  ( ($nome_campo == 'temozolomide') || ($nome_campo == 'pc_v') || ($nome_campo == 'fotemustina') ) 
{
	if ($nome_campo == 'temozolomide')	
		$nome_campo1 = "TEMOZOLOMIDE";
	if ($nome_campo == 'pc_v')	
		$nome_campo1 = "PC(V)";
	if ($nome_campo == 'fotemustina')	
		$nome_campo1 = "FOTEMUSTINA";

	$n8=0;
	$n_on=0;
	for ($i=0; $i<$n_pazienti; $i++)
	{
		$chemioterapia = new chemioterapia($id_finali[$i], NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
		$chemioterapia->retrive_by_id_paziente();	
		
		if ($chemioterapia -> getID_array(0) != NULL)
		{
			$id = $chemioterapia -> getID_array(0);
			$chemioterapia -> retrive_by_id($id);
			
			if ($nome_campo == 'temozolomide')	
				$valori[$n8] = $chemioterapia->getTemozolomide();
			if ($nome_campo == 'pc_v')	
				$valori[$n8] = $chemioterapia->getPc_v();
			if ($nome_campo == 'fotemustina')	
				$valori[$n8] = $chemioterapia->getFotemustina();
							
			if ($valori[$n8] == 'on')
				$n_on = $n_on + 1;
			
			$id_finali_new[$n8] = $id_finali[$i];
			$n8 = $n8+1;
		}
	}
	$n_pazienti = $n8;
}

// CAMPI NUMERO  ---------------------------------------------------------------------------------------------
if  ( ($nome_campo == 'cicli_temozolomide') || ($nome_campo == 'cicli_pc_v') || ($nome_campo == 'cicli_fotemustina') ) 
{
	if ($nome_campo == 'cicli_temozolomide')	
	$nome_campo1 = "N. CYCLES OF TEMOZOLOMIDE";
	if ($nome_campo == 'cicli_pc_v')	
	$nome_campo1 = "N. CYCLES OF PC(V)";		
	if ($nome_campo == 'cicli_fotemustina')	
	$nome_campo1 = "N. CYCLES OF FOTEMUSTINA";	
	
	$n8=0;
	for ($i=0; $i<$n_pazienti; $i++)
	{	
		$chemioterapia = new chemioterapia($id_finali[$i], NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
		$chemioterapia->retrive_by_id_paziente();	

		if ($chemioterapia -> getID_array(0) != NULL)
		{	
			$id = $chemioterapia -> getID_array(0);
			$chemioterapia -> retrive_by_id($id);
			
			if ($nome_campo == 'cicli_temozolomide')			
				$valori_1 = $chemioterapia->getCicli_temozolomide();
			if ($nome_campo == 'cicli_pc_v')			
				$valori_1 = $chemioterapia->getCicli_pc_v();
			if ($nome_campo == 'cicli_fotemustina')			
				$valori_1 = $chemioterapia->getCicli_fotemustina();
							
			if ($valori_1 == -1000);		
			else
			{
				$valori[$n8] = $valori_1;
				$id_finali_new2[$n8] = $id_finali[$i];
				$n8 = $n8+1;
			}
		}
	}
	$n_pazienti = $n8;
}

// CAMPI DATE  ---------------------------------------------------------------------------------------------
if  ( ($nome_campo == 'data_temozolomide') || ($nome_campo == 'data_pc_v') || ($nome_campo == 'data_fotemustina') ) 
{
	if ($nome_campo == 'data_temozolomide')	
	$nome_campo1 = "DATE BEGIN TEMOZOLOMIDE";
	if ($nome_campo == 'data_pc_v')	
	$nome_campo1 = "DATE BEGIN PC(V)";
	if ($nome_campo == 'data_fotemustina')	
	$nome_campo1 = "DATE BEGIN FOTEMUSTINA";
		
	$n8=0;
	for ($i=0; $i<$n_pazienti; $i++)
	{	
		$chemioterapia = new chemioterapia($id_finali[$i], NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
		$chemioterapia->retrive_by_id_paziente();	

		if ($chemioterapia -> getID_array(0) != NULL)
		{	
			$id = $chemioterapia -> getID_array(0);
			$chemioterapia -> retrive_by_id($id);
			
			if ($nome_campo == 'data_temozolomide')			
				$valori_1 = $chemioterapia->getData_temozolomide();
			if ($nome_campo == 'data_pc_v')			
				$valori_1 = $chemioterapia->getData_pc_v();
			if ($nome_campo == 'data_fotemustina')			
				$valori_1 = $chemioterapia->getData_fotemustina();
											
			if ($valori_1 == '0000-00-00');		
			else
			{
				$valori[$n8] = $valori_1;
				$id_finali_new2[$n8] = $id_finali[$i];
				$n8 = $n8+1;
			}
		}
	}
	$n_pazienti = $n8;
}
// *****************************************************************************************************************************


// ************************** ESAME TC ************************************************************************************************
// CAMPI SI/NO ---------------------------------------------------------------------------------------------
if  ( ($nome_campo == 'extrassiale') || ($nome_campo == 'intrassiale') || ($nome_campo == 'dubbia') || ($nome_campo == 'contrasto') ) 
{
	if ($nome_campo == 'extrassiale')	
	$nome_campo1 = "EXTRASSIAL";
	if ($nome_campo == 'intrassiale')	
	$nome_campo1 = "INTRASSIAL";
	if ($nome_campo == 'dubbia')	
	$nome_campo1 = "DOUBTFUL";
	if ($nome_campo == 'contrasto')	
	$nome_campo1 = "CONTRAST";

	$n8=0;
	$n_on=0;
	for ($i=0; $i<$n_pazienti; $i++)
	{
		$esame = new esame_tc($id_finali[$i], NULL, NULL, NULL, NULL, NULL, NULL);
		$esame->retrive_by_id_paziente();	
		
		if ($esame -> getID_esame_tc_array(0) != NULL)
		{
			$id = $esame -> getID_esame_tc_array(0);
			$esame -> retrive_by_id($id);
			
			if ($nome_campo == 'extrassiale')	
				$valori[$n8] = $esame->getExtrassiale();
			if ($nome_campo == 'intrassiale')	
				$valori[$n8] = $esame->getIntrassiale();
			if ($nome_campo == 'dubbia')	
				$valori[$n8] = $esame->getDubbia();
			if ($nome_campo == 'contrasto')	
				$valori[$n8] = $esame->getContrasto();
											
			if ($valori[$n8] == 'on')
				$n_on = $n_on + 1;
			
			$id_finali_new[$n8] = $id_finali[$i];
			$n8 = $n8+1;
		}
	}
	$n_pazienti = $n8;
}

// CAMPO TIPO DI CONTRASTO -----------------------------------------------------------------------------
if ($nome_campo == 'tipo_contrasto')
{
	$nome_campo1 = "KIND OF CONTRAST";

	$query = "SELECT DISTINCT tipo_contrasto FROM esame_tc";
	$rs = mysql_query($query);
	$n8= 0;
	while(list($var2) = mysql_fetch_row($rs))
	{
		$var_1[$n8] = $var2;
		$n8 = $n8+1;
	}	
}

// CAMPO SEDE --------------------------------------------------------------------------------------------
if ($nome_campo == 'sede')
{
	$nome_campo1 = "SITE";

	$query = "SELECT DISTINCT sede FROM esame_tc";
	$rs = mysql_query($query);
	$n8= 0;
	while(list($var2) = mysql_fetch_row($rs))
	{
		$var_1[$n8] = $var2;
		$n8 = $n8+1;
	}	
}

// CAMPI DATE  ---------------------------------------------------------------------------------------------
if  ($nome_campo == 'data_inserimento') 
{
	if ($nome_campo == 'data_inserimento')	
	$nome_campo1 = "DATA EXAM";
		
	$n8=0;
	for ($i=0; $i<$n_pazienti; $i++)
	{	
		$esame = new esame_tc($id_finali[$i], NULL, NULL, NULL, NULL, NULL, NULL);
		$esame ->retrive_by_id_paziente();	

		if ($esame  -> getID_esame_tc_array(0) != NULL)
		{	
			$id = $esame  -> getID_esame_tc_array(0);
			$esame  -> retrive_by_id($id);
			
			if ($nome_campo == 'data_inserimento')			
				$valori_1 = $esame ->getData_inserimento();
											
			if ($valori_1 == '0000-00-00');		
			else
			{
				$valori[$n8] = $valori_1;
				$id_finali_new2[$n8] = $id_finali[$i];
				$n8 = $n8+1;
			}
		}
	}
	$n_pazienti = $n8;
}
// *****************************************************************************************************************************


// ************************** DATA INSERIMENTO **********************************************************************************
// CAMPI DATE  ---------------------------------------------------------------------------------------------
if  ($nome_campo == 'data') 
{
	if ($nome_campo == 'data')	
	$nome_campo1 = "INSERTION DATE";
		
	$n8=0;
	for ($i=0; $i<$n_pazienti; $i++)
	{	
		$data = new dataExamInsert(NULL);
		$data -> setID_paziente($id_finali[$i]);
		$data -> retrive_data();	
				
		$valori_1 = $data ->getData_inserimento();
										
		if ($valori_1 == '0000-00-00');		
		else
		{
			$valori[$n8] = $valori_1;
			$id_finali_new2[$n8] = $id_finali[$i];
			$n8 = $n8+1;
		}		
	}
	$n_pazienti = $n8;
}
// *****************************************************************************************************************************


// ************************** INERTVENTO ************************************************************************************************
// CAMPI SI/NO ---------------------------------------------------------------------------------------------
if  ( ($nome_campo == 'biopsia') || ($nome_campo == 'resezione_totale') || ($nome_campo == 'resezione_parziale') || ($nome_campo == 'gliadel') ) 
{
	if ($nome_campo == 'biopsia')	
	$nome_campo1 = "BIOPSY";
	if ($nome_campo == 'resezione_totale')	
	$nome_campo1 = "Total tumor resection";
	if ($nome_campo == 'resezione_parziale')	
	$nome_campo1 = "Partial tumor resection";
	if ($nome_campo == 'gliadel')	
	$nome_campo1 = "GLIADEL";

	$n8=0;
	$n_on=0;
	for ($i=0; $i<$n_pazienti; $i++)
	{
		$esame = new intervento($id_finali[$i], NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
		$esame->retrive_by_id_paziente();	
		
		if ($esame -> getID_array(0) != NULL)
		{
			$id = $esame -> getID_array(0);
			$esame -> retrive_by_id($id);
			
			if ($nome_campo == 'biopsia')	
				$valori[$n8] = $esame->getBiopsia();
			if ($nome_campo == 'resezione_totale')	
				$valori[$n8] = $esame->getResezione_totale();
			if ($nome_campo == 'resezione_parziale')	
				$valori[$n8] = $esame->getResezione_parziale();
			if ($nome_campo == 'gliadel')	
				$valori[$n8] = $esame->getResezione_gliadel();
											
			if ($valori[$n8] == 'on')
				$n_on = $n_on + 1;
			
			$id_finali_new[$n8] = $id_finali[$i];
			$n8 = $n8+1;
		}
	}
	$n_pazienti = $n8;
}

// CAMPI DATE  ---------------------------------------------------------------------------------------------------------------------------------------------------------
if  ( ($nome_campo == 'data_biopsia') || ($nome_campo == 'data_resezione_totale') || ($nome_campo == 'data_resezione_parziale') || ($nome_campo == 'data_gliadel') ) 
{
	if ($nome_campo == 'data_biopsia')	
	$nome_campo1 = "DATE OF BIOPSY";
	if ($nome_campo == 'data_resezione_totale')	
	$nome_campo1 = "DATE TOTAL TUMOR RESECTION";
	if ($nome_campo == 'data_resezione_parziale')	
	$nome_campo1 = "DATE PARTIAL TUMOR RESECTION";
	if ($nome_campo == 'data_gliadel')	
	$nome_campo1 = "DATE GLIADEL";
		
	$n8=0;
	for ($i=0; $i<$n_pazienti; $i++)
	{	
		$esame = new intervento($id_finali[$i], NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
		$esame->retrive_by_id_paziente();

		if ($esame  -> getID_array(0) != NULL)
		{	
			$id = $esame  -> getID_array(0);
			$esame  -> retrive_by_id($id);
			
			if ($nome_campo == 'data_biopsia')	
				$valori_1 = $esame->getData_biopsia();
			if ($nome_campo == 'data_resezione_totale')	
				$valori_1 = $esame->getData_resezione_totale();
			if ($nome_campo == 'data_resezione_parziale')	
				$valori_1 = $esame->getData_resezione_parziale();
			if ($nome_campo == 'data_gliadel')	
				$valori_1 = $esame->getData_resezione_gliadel();
											
			if ($valori_1 == '0000-00-00');		
			else
			{
				$valori[$n8] = $valori_1;
				$id_finali_new2[$n8] = $id_finali[$i];
				$n8 = $n8+1;
			}
		}
	}
	$n_pazienti = $n8;
}
// *****************************************************************************************************************************


// ************************** PERMEABILITA' *************************************************************************************
// CAMPI NUMERO  ---------------------------------------------------------------------------------------------
if  ( ($nome_campo == 'valore_k_trans') || ($nome_campo == 'valore_vi') ) 
{
	if ($nome_campo == 'valore_k_trans')	
		$nome_campo1 = "K trans VALUE";
	if ($nome_campo == 'valore_vi')	
		$nome_campo1 = "vi VALUE";		
		
	$n8=0;
	for ($i=0; $i<$n_pazienti; $i++)
	{	
		$perm = new permeabilita($id_finali[$i], NULL, NULL);
		$perm->retrive_by_id_paziente();	

		if ($perm -> getID_array(0) != NULL)
		{	
			$id = $perm -> getID_array(0);
			$perm -> retrive_by_id($id);
			
			if ($nome_campo == 'valore_k_trans')			
				$valori_1 = $perm->getK_trans();
			if ($nome_campo == 'valore_vi')			
				$valori_1 = $perm->getVi();
							
			if ($valori_1 == -1000);		
			else
			{
				$valori[$n8] = $valori_1;
				$id_finali_new2[$n8] = $id_finali[$i];
				$n8 = $n8+1;
			}
		}
	}
	$n_pazienti = $n8;
}

// CAMPI DATE  ---------------------------------------------------------------------------------------------
if  ($nome_campo == 'data_inserimento_p') 
{
	if ($nome_campo == 'data_inserimento_p')	
	$nome_campo1 = "DATA OF EXAM";
		
	$n8=0;
	for ($i=0; $i<$n_pazienti; $i++)
	{	
		$perm = new permeabilita($id_finali[$i], NULL, NULL);
		$perm  ->retrive_by_id_paziente();	

		if ($perm   -> getID_array(0) != NULL)
		{	
			$id = $perm  -> getID_array(0);
			$perm -> retrive_by_id($id);
			
			if ($nome_campo == 'data_inserimento_p')			
				$valori_1 = $perm ->getData_inserimento();
											
			if ($valori_1 == '0000-00-00');		
			else
			{
				$valori[$n8] = $valori_1;
				$id_finali_new2[$n8] = $id_finali[$i];
				$n8 = $n8+1;
			}
		}
	}
	$n_pazienti = $n8;
}
// *****************************************************************************************************************************

// ************************** RM BOLD ******************************************************************************************
// CAMPI SI/NO  AREA MOTORIA RM BOLD-----------------------------------------------------------------------
if  ($nome_campo == 'area_attivazione_motoria') 
{
	$nome_campo1 = "Activation area for motor test";

	$n_anteriore=0;
	$n_posteriore=0;
	$n_mediale=0;
	$n_intralesionale=0;
	$n_laterale=0;
	$n_inferiore=0;
	$n_superiore=0;
	$n_altro=0;
		
	for ($i=0; $i<$n_pazienti; $i++)
	{	
		$esame = new rm_bold($id_finali[$i], NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL ,NULL ,NULL, NULL, NULL, NULL, NULL, NULL);
		
		$esame -> retrive_by_id_paziente();
		$id = $esame  -> getID_array(0);
		$esame -> retrive_by_id($id);

		// calcola il numero di ON per ogni area di attivadione:
		if ($esame->getMotorio_anteriore() == 'on')
			$n_anteriore=$n_anteriore+1;
		if ($esame->getMotorio_posteriore() == 'on')
			$n_posteriore=$n_posteriore+1;		
		if ($esame->getMotorio_mediale() == 'on')
			$n_mediale=$n_mediale+1;
		if ($esame->getMotorio_intralesionale() == 'on')
			$n_intralesionale=$n_intralesionale+1;
		if ($esame->getMotorio_laterale() == 'on')
			$n_laterale=$n_laterale+1;
		if ($esame->getMotorio_inferiore() == 'on')
			$n_inferiore=$n_inferiore+1;
		if ($esame->getMotorio_superiore() == 'on')
			$n_superiore=$n_superiore+1;
		if ($esame->getMotorio_altro() != NULL)
			$n_altro=$n_altro+1;
	}
	$valori = array( 	
	'Front' => $n_anteriore,
	'Rearward' => $n_posteriore,
	'Medial' => $n_mediale, 
	'Intralesional' => $n_intralesionale, 
	'Lateral' => $n_laterale, 
	'Lower' => $n_inferiore, 
	'Upper' => $n_superiore,
	'Other' => $n_altro);
}

// CAMPI SI/NO  AREA sensitiva RM BOLD-----------------------------------------------------------------------
if  ($nome_campo == 'area_attivazione_sensitiva') 
{
	$nome_campo1 = "Activation area for sensory test";

	$n_anteriore=0;
	$n_posteriore=0;
	$n_mediale=0;
	$n_intralesionale=0;
	$n_laterale=0;
	$n_inferiore=0;
	$n_superiore=0;
	$n_altro=0;
		
	for ($i=0; $i<$n_pazienti; $i++)
	{	
		$esame = new rm_bold($id_finali[$i], NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL ,NULL ,NULL, NULL, NULL, NULL, NULL, NULL);
		
		$esame -> retrive_by_id_paziente();
		$id = $esame  -> getID_array(0);
		$esame -> retrive_by_id($id);

		// calcola il numero di ON per ogni area di attivadione:
		if ($esame->getSensitiva_anteriore() == 'on')
			$n_anteriore=$n_anteriore+1;
		if ($esame->getSensitiva_posteriore() == 'on')
			$n_posteriore=$n_posteriore+1;		
		if ($esame->getSensitiva_mediale() == 'on')
			$n_mediale=$n_mediale+1;
		if ($esame->getSensitiva_intralesionale() == 'on')
			$n_intralesionale=$n_intralesionale+1;
		if ($esame->getSensitiva_laterale() == 'on')
			$n_laterale=$n_laterale+1;
		if ($esame->getSensitiva_inferiore() == 'on')
			$n_inferiore=$n_inferiore+1;
		if ($esame->getSensitiva_superiore() == 'on')
			$n_superiore=$n_superiore+1;
		if ($esame->getSensitiva_altro() != NULL)
			$n_altro=$n_altro+1;
	}
	$valori = array( 	
	'Front' => $n_anteriore,
	'Rearward' => $n_posteriore,
	'Medial' => $n_mediale, 
	'Intralesional' => $n_intralesionale, 
	'Lateral' => $n_laterale, 
	'Lower' => $n_inferiore, 
	'Upper' => $n_superiore,
	'Other' => $n_altro);
}

// CAMPI DATE  ---------------------------------------------------------------------------------------------
if  ($nome_campo == 'data_inserimento_bold') 
{
	if ($nome_campo == 'data_inserimento_bold')	
	$nome_campo1 = "DATE OF EXAM";
		
	$n8=0;
	for ($i=0; $i<$n_pazienti; $i++)
	{	
		$esame = new rm_bold($id_finali[$i], NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL ,NULL ,NULL, NULL, NULL, NULL, NULL, NULL);		
		$esame -> retrive_by_id_paziente();

		if ($esame   -> getID_array(0) != NULL)
		{	
			$id = $esame  -> getID_array(0);
			$esame -> retrive_by_id($id);
			
			if ($nome_campo == 'data_inserimento_bold')			
				$valori_1 = $esame ->getData_inserimento();
											
			if ($valori_1 == '0000-00-00');		
			else
			{
				$valori[$n8] = $valori_1;
				$id_finali_new2[$n8] = $id_finali[$i];
				$n8 = $n8+1;
			}
		}
	}
	$n_pazienti = $n8;
}

// CAMPI SI/NO (linguaggio)---------------------------------------------------------------------------------------------
if  ( ($nome_campo == 'linguaggio') ) 
{
	if ($nome_campo == 'linguaggio')	
	$nome_campo1 = "LANGUAGE TEST";

	$n8=0;
	$n_on_b=0;
	$n_on_w=0;
	for ($i=0; $i<$n_pazienti; $i++)
	{
		$esame = new rm_bold($id_finali[$i], NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL ,NULL ,NULL, NULL, NULL, NULL, NULL, NULL);		
		$esame -> retrive_by_id_paziente();
		
		if ($esame -> getID_array(0) != NULL)
		{
			$id = $esame -> getID_array(0);
			$esame -> retrive_by_id($id);
			
			if ($nome_campo == 'linguaggio')
			{	
				$valori_broca[$n8] = $esame->getLinguaggio_broca();
				$valori_w[$n8] = $esame->getLinguaggio_wermicke();			
			}
								
			if ($valori_broca[$n8] == 'on')
				$n_on_b = $n_on_b + 1;

			if ($valori_w[$n8] == 'on')
				$n_on_w = $n_on_w + 1;
			
			$id_finali_new[$n8] = $id_finali[$i];
			$n8 = $n8+1;
		}
	}
	$n_pazienti = $n8;
}
// *****************************************************************************************************************************

// ************************** RM DTI ******************************************************************************************
// CAMPI NUMERO  ---------------------------------------------------------------------------------------------
if  ( ($nome_campo == 'valore_fa') ) 
{
	if ($nome_campo == 'valore_fa')	
		$nome_campo1 = "FA VALUE";
	
		
	$n8=0;
	for ($i=0; $i<$n_pazienti; $i++)
	{	
		$rm = new rm_dti ($id_finali[$i], NULL, NULL, NULL, NULL, NULL);
	
		$rm->retrive_by_id_paziente();	

		if ($rm -> getID_array(0) != NULL)
		{	
			$id = $rm -> getID_array(0);
			$rm -> retrive_by_id($id);
			
			if ($nome_campo == 'valore_fa')			
				$valori_1 = $rm->getValore_fa();
							
			if ($valori_1 == -1000);		
			else
			{
				$valori[$n8] = $valori_1;
				$id_finali_new2[$n8] = $id_finali[$i];
				$n8 = $n8+1;
			}
		}
	}
	$n_pazienti = $n8;
}
	

// CAMPI SI/NO ---------------------------------------------------------------------------------------------
if  ( ($nome_campo == 'fascio_cortico_spinale') || ($nome_campo == 'fascio_arcuato') || ($nome_campo == 'fascicolo_long_inf') || ($nome_campo == 'vie_ottiche') ) 
{
	if ($nome_campo == 'fascio_cortico_spinale')	
	$nome_campo1 = "Corticospinal tract";
	if ($nome_campo == 'fascio_arcuato')	
	$nome_campo1 = "Fascicle Arcuate";
	if ($nome_campo == 'fascicolo_long_inf')	
	$nome_campo1 = "Superior Longitudinal Fascicle";
	if ($nome_campo == 'vie_ottiche')	
	$nome_campo1 = "Optic Pathway";

	$n8=0;
	$n_on=0;
	for ($i=0; $i<$n_pazienti; $i++)
	{
		$rm = new rm_dti ($id_finali[$i], NULL, NULL, NULL, NULL, NULL);
		$rm->retrive_by_id_paziente();	
		
		if ($rm -> getID_array(0) != NULL)
		{
			$id = $rm -> getID_array(0);
			$rm -> retrive_by_id($id);
			
			if ($nome_campo == 'fascio_cortico_spinale')
			{	
				$valori[$n8] = $rm->getCortico_spinale();
				if ($valori[$n8] == 'compresso')
					$valori[$n8] ='on';
				else
					$valori[$n8] = NULL;			
			}
			if ($nome_campo == 'fascio_arcuato')
			{	
				$valori[$n8] = $rm->getArcuato();
				if ($valori[$n8] == 'compresso')
					$valori[$n8] ='on';
				else
					$valori[$n8] = NULL;			
			}				
			if ($nome_campo == 'fascicolo_long_inf')	
			{	
				$valori[$n8] = $rm->getLongitudinale_inferiore();
				if ($valori[$n8] == 'compresso')
					$valori[$n8] ='on';
				else
					$valori[$n8] = NULL;			
			}				
			if ($nome_campo == 'vie_ottiche')	
			{	
				$valori[$n8] = $rm->getVie_ottiche();
				if ($valori[$n8] == 'compresso')
					$valori[$n8] ='on';
				else
					$valori[$n8] = NULL;			
			}			
								
			if ($valori[$n8] == 'on')
				$n_on = $n_on + 1;
			
			$id_finali_new[$n8] = $id_finali[$i];
			$n8 = $n8+1;
		}
	}
	$n_pazienti = $n8;
}

// CAMPI DATE  ---------------------------------------------------------------------------------------------
if  ($nome_campo == 'data_inserimento_dti') 
{
	if ($nome_campo == 'data_inserimento_dti')	
	$nome_campo1 = "DATE OF EXAM";
		
	$n8=0;
	for ($i=0; $i<$n_pazienti; $i++)
	{	
		$rm = new rm_dti ($id_finali[$i], NULL, NULL, NULL, NULL, NULL);
		$rm->retrive_by_id_paziente();	

		if ($rm   -> getID_array(0) != NULL)
		{	
			$id = $rm  -> getID_array(0);
			$rm -> retrive_by_id($id);
			
			if ($nome_campo == 'data_inserimento_dti')			
				$valori_1 = $rm ->getData_inserimento();
											
			if ($valori_1 == '0000-00-00');		
			else
			{
				$valori[$n8] = $valori_1;
				$id_finali_new2[$n8] = $id_finali[$i];
				$n8 = $n8+1;
			}
		}
	}
	$n_pazienti = $n8;
}
// *****************************************************************************************************************************


// ************************** RM MORFOLOGICA  **********************************************************************************
	
// CAMPI SI/NO ---------------------------------------------------------------------------------------------
if  ( ($nome_campo == 'extrassiale_m') || ($nome_campo == 'intrassiale_m') || ($nome_campo == 't2_flair') || ($nome_campo == 'flair_3d') || ($nome_campo == 'diffusione') || ($nome_campo == 'adc') || ($nome_campo == 'ce') ) 
{
	if ($nome_campo == 'extrassiale_m')	
	$nome_campo1 = "EXTRASSIAL";
	if ($nome_campo == 'intrassiale_m')	
	$nome_campo1 = "INTRASSIAL";
	if ($nome_campo == 't2_flair')	
	$nome_campo1 = "T2 FLAIR";
	if ($nome_campo == 'flair_3d')	
	$nome_campo1 = "FLAIR 3D";
	if ($nome_campo == 'diffusione')	
	$nome_campo1 = "DIFFUSION";
	if ($nome_campo == 'adc')	
	$nome_campo1 = "ADC";
	if ($nome_campo == 'ce')	
	$nome_campo1 = "CE";
		
	$n8=0;
	$n_on=0;
	for ($i=0; $i<$n_pazienti; $i++)
	{
		$rm = new rm_morfologica ($id_finali[$i], NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
		$rm->retrive_by_id_paziente();	
		
		if ($rm -> getID_array(0) != NULL)
		{
			$id = $rm -> getID_array(0);
			$rm -> retrive_by_id($id);
			
			if ($nome_campo == 'extrassiale_m')
					$valori[$n8] = $rm->getExtrassiale();

			if ($nome_campo == 'intrassiale_m')
					$valori[$n8] = $rm->getIntrassiale();					
			
			if ($nome_campo == 't2_flair')
					$valori[$n8] = $rm->getT2_flair();			
			
			if ($nome_campo == 'flair_3d')
					$valori[$n8] = $rm-> getFlair_3d();		
				
			if ($nome_campo == 'diffusione')
					$valori[$n8] = $rm-> getDwi();				
			
			if ($nome_campo == 'adc')
					$valori[$n8] = $rm-> getAdc();			
			
			if ($nome_campo == 'ce')
					$valori[$n8] = $rm-> getCe();	
																
			if ($valori[$n8] == 'on')
				$n_on = $n_on + 1;
			
			$id_finali_new[$n8] = $id_finali[$i];
			$n8 = $n8+1;
		}
	}
	$n_pazienti = $n8;
}

// CAMPI NUMERO  ---------------------------------------------------------------------------------------------
if  ( ($nome_campo == 'volume_neo') || ($nome_campo == 'valore_adc') ) 
{
	if ($nome_campo == 'volume_neo')	
		$nome_campo1 = "VOLUME NEO";
	if ($nome_campo == 'valore_adc')	
		$nome_campo1 = "ADC VALUE";	
		
	$n8=0;
	for ($i=0; $i<$n_pazienti; $i++)
	{	
		$rm = new rm_morfologica ($id_finali[$i], NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
		$rm->retrive_by_id_paziente();

		if ($rm -> getID_array(0) != NULL)
		{	
			$id = $rm -> getID_array(0);
			$rm -> retrive_by_id($id);
			
			if ($nome_campo == 'volume_neo')			
				$valori_1 = $rm->getVolume_neo();
			if ($nome_campo == 'valore_adc')			
				$valori_1 = $rm->getValore_adc_ridotto();
				
			if ($valori_1 == -1000);		
			else
			{
				$valori[$n8] = $valori_1;
				$id_finali_new2[$n8] = $id_finali[$i];
				$n8 = $n8+1;
			}
		}
	}
	$n_pazienti = $n8;
}

// tipo di diffusione -------------------------------------------------------------------------------------------------------
if  ( ($nome_campo == 'tipo_diffusione') ) 
{
	if ($nome_campo == 'tipo_diffusione')	
		$nome_campo1 = "KIND OF DIFFUSION";

	$n8=0;
	$n_iper=0;
	$n_ipo=0;
	$n_normale=0;		
	for ($i=0; $i<$n_pazienti; $i++)
	{
		$rm = new rm_morfologica ($id_finali[$i], NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
		$rm->retrive_by_id_paziente();
		
		if ($rm -> getID_array(0) != NULL)
		{
			$id = $rm -> getID_array(0);
			$rm -> retrive_by_id($id);
			
			if ($nome_campo == 'tipo_diffusione')
			{	
				$valori[$n8] = $rm->getDwi_ristretta();		
			}
								
			if ($valori[$n8] == 'iper')
				$n_iper = $n_iper + 1;
			if ($valori[$n8] == 'ipo')
				$n_ipo = $n_ipo + 1;
			if ($valori[$n8] == 'normale')
				$n_normale = $n_normale + 1;
		
			$id_finali_new[$n8] = $id_finali[$i];
			$n8 = $n8+1;
		}
	}
	$n_pazienti = $n8;
}

// tipo di ADC -------------------------------------------------------------------------------------------------------
if  ( ($nome_campo == 'tipo_adc') ) 
{
	if ($nome_campo == 'tipo_adc')	
		$nome_campo1 = "KIND OF ADC";

	$n8=0;
	$n_1=0;
	$n_2=0;
	$n_normale=0;		
	for ($i=0; $i<$n_pazienti; $i++)
	{
		$rm = new rm_morfologica ($id_finali[$i], NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
		$rm->retrive_by_id_paziente();
		
		if ($rm -> getID_array(0) != NULL)
		{
			$id = $rm -> getID_array(0);
			$rm -> retrive_by_id($id);
			
			if ($nome_campo == 'tipo_adc')
			{	
				$valori[$n8] = $rm->getAdc_ridotto();	
			}
								
			if ($valori[$n8] == 'ridotta')
				$n_1 = $n_1 + 1;
			if ($valori[$n8] == 'aumentata')
				$n_2 = $n_2 + 1;
		
			$id_finali_new[$n8] = $id_finali[$i];
			$n8 = $n8+1;
		}
	}
	$n_pazienti = $n8;
}

// tipo CE -------------------------------------------------------------------------------------------------------
if  ( ($nome_campo == 'tipo_ce') ) 
{
	if ($nome_campo == 'tipo_ce')	
		$nome_campo1 = "KIND OF CE";

	$n8=0;
	$n_1=0;
	$n_2=0;
	$n_3=0;	
	$n_normale=0;		
	for ($i=0; $i<$n_pazienti; $i++)
	{
		$rm = new rm_morfologica ($id_finali[$i], NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
		$rm->retrive_by_id_paziente();
		
		if ($rm -> getID_array(0) != NULL)
		{
			$id = $rm -> getID_array(0);
			$rm -> retrive_by_id($id);
			
			if ($nome_campo == 'tipo_ce')
			{	
				$valori[$n8] = $rm->getTipo_ce();	
			}
								
			if ($valori[$n8] == 'omogeneo')
				$n_1 = $n_1 + 1;
			if ($valori[$n8] == 'disomogeneo')
				$n_2 = $n_2 + 1;
			if ($valori[$n8] == 'ad_anello')
				$n_3 = $n_3 + 1;
						
			$id_finali_new[$n8] = $id_finali[$i];
			$n8 = $n8+1;
		}
	}
	$n_pazienti = $n8;
}

// CAMPI DATE  ---------------------------------------------------------------------------------------------
if  ($nome_campo == 'data_inserimento_morfo') 
{
	if ($nome_campo == 'data_inserimento_morfo')	
	$nome_campo1 = "DATE OF EXAM";
		
	$n8=0;
	for ($i=0; $i<$n_pazienti; $i++)
	{	
		$rm = new rm_morfologica ($id_finali[$i], NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
		$rm->retrive_by_id_paziente();	

		if ($rm   -> getID_array(0) != NULL)
		{	
			$id = $rm  -> getID_array(0);
			$rm -> retrive_by_id($id);
			
			if ($nome_campo == 'data_inserimento_morfo')			
				$valori_1 = $rm ->getData_inserimento();
											
			if ($valori_1 == '0000-00-00');		
			else
			{
				$valori[$n8] = $valori_1;
				$id_finali_new2[$n8] = $id_finali[$i];
				$n8 = $n8+1;
			}
		}
	}
	$n_pazienti = $n8;
}
// *****************************************************************************************************************************

// ************************** RM PERFUSIONE **********************************************************************************
// CAMPI DATE  ---------------------------------------------------------------------------------------------
if  ($nome_campo == 'data_inserimento_perfusione') 
{
	$nome_campo1 = "DATE OF EXAM";
		
	$n8=0;
	for ($i=0; $i<$n_pazienti; $i++)
	{	
		$rm = new rm_perfusione ($id_finali[$i], NULL, NULL, NULL);
		$rm->retrive_by_id_paziente($id_finali[$i]);	

		if ($rm   -> getID_rm_perfusione_array(0) != NULL)
		{	
			$id = $rm  -> getID_rm_perfusione_array(0);
			$rm -> retrive_by_id($id);
			
			if ($nome_campo == 'data_inserimento_perfusione')			
				$valori_1 = $rm ->getData_inserimento();
											
			if ($valori_1 == '0000-00-00');		
			else
			{
				$valori[$n8] = $valori_1;
				$id_finali_new2[$n8] = $id_finali[$i];
				$n8 = $n8+1;
			}
		}
	}
	$n_pazienti = $n8;
}

// CAMPI NUMERO  ---------------------------------------------------------------------------------------------
if  ( ($nome_campo == 'r_cbv') ) 
{
	$nome_campo1 = "r-CBV VALUE";

		
	$n8=0;
	for ($i=0; $i<$n_pazienti; $i++)
	{	
		$rm = new rm_perfusione ($id_finali[$i], NULL, NULL, NULL);
		$rm->retrive_by_id_paziente($id_finali[$i]);	

		if ($rm   -> getID_rm_perfusione_array(0) != NULL)
		{	
			$id = $rm  -> getID_rm_perfusione_array(0);
			$rm -> retrive_by_id($id);
			
			if ($nome_campo == 'r_cbv')			
				$valori_1 = $rm->getValore_r_cbv();

			if ($valori_1 == -1000);		
			else
			{
				$valori[$n8] = $valori_1;
				$id_finali_new2[$n8] = $id_finali[$i];
				$n8 = $n8+1;
			}
		}
	}
	$n_pazienti = $n8;
}

// r_CBV-------------------------------------------------------------------------------------------------------
if  ( ($nome_campo == 'r_cbv_1') ) 
{
	$nome_campo1 = "r-CBV";

	$n8=0;
	$n_1=0;
	$n_2=0;
	$n_normale=0;		
	for ($i=0; $i<$n_pazienti; $i++)
	{
		$rm = new rm_perfusione ($id_finali[$i], NULL, NULL, NULL);
		$rm->retrive_by_id_paziente($id_finali[$i]);
		
		if ($rm   -> getID_rm_perfusione_array(0) != NULL)
		{	
			$id = $rm  -> getID_rm_perfusione_array(0);
			$rm -> retrive_by_id($id);
			
			$valori[$n8] = $rm->getR_cbv();	
								
			if ($valori[$n8] == 'inf')
				$n_1 = $n_1 + 1;
			if ($valori[$n8] == 'sup')
				$n_2 = $n_2 + 1;
						
			$id_finali_new[$n8] = $id_finali[$i];
			$n8 = $n8+1;
		}
	}
	$n_pazienti = $n8;
}

// *****************************************************************************************************************************

// ************************** RM SPETTRO ***************************************************************************************
// Tempo di Eco TE ----------------------------------------------------------------
if  ( ($nome_campo == 'te') ) 
{
	$nome_campo1 = "ECHO TIME(TE)";

	$n8=0;
	$n_1=0;
	$n_2=0;
	$n_3=0;	
	$n_normale=0;		
	for ($i=0; $i<$n_pazienti; $i++)
	{
		$rm = new rm_spettroscopica ($id_finali[$i], NULL, NULL, NULL, NULL, NULL, NULL, NULL);
		$rm->retrive_by_id_paziente();
		
		if ($rm -> getID_array(0) != NULL)
		{
			$id = $rm -> getID_array(0);
			$rm -> retrive_by_id($id);
			
			$valori[$n8] = $rm->getTe();	
								
			if ($valori[$n8] == 'breve')
				$n_1 = $n_1 + 1;
			if ($valori[$n8] == 'intermedio')
				$n_2 = $n_2 + 1;
			if ($valori[$n8] == 'lungo')
				$n_3 = $n_3 + 1;
						
			$id_finali_new[$n8] = $id_finali[$i];
			$n8 = $n8+1;
		}
	}
	$n_pazienti = $n8;
}

// Tipo di spettro ----------------------------------------------------------------
if  ( ($nome_campo == 'tipo_spettro') ) 
{
	$nome_campo1 = "KIND OF SPECTRUM";

	$n8=0;
	$n_1=0;
	$n_2=0;
	$n_normale=0;		
	for ($i=0; $i<$n_pazienti; $i++)
	{
		$rm = new rm_spettroscopica ($id_finali[$i], NULL, NULL, NULL, NULL, NULL, NULL, NULL);
		$rm->retrive_by_id_paziente();
		
		if ($rm -> getID_array(0) != NULL)
		{
			$id = $rm -> getID_array(0);
			$rm -> retrive_by_id($id);
			
			$valori[$n8] = $rm ->getTipo_spettro();	
								
			if ($valori[$n8] == 'svs')
				$n_1 = $n_1 + 1;
			if ($valori[$n8] == 'csi')
				$n_2 = $n_2 + 1;
						
			$id_finali_new[$n8] = $id_finali[$i];
			$n8 = $n8+1;
		}
	}
	$n_pazienti = $n8;
}


// CAMPI NUMERO  ---------------------------------------------------------------------------------------------
if  ( ($nome_campo == 'valore_naa_cr') || ($nome_campo == 'valore_cho_cr') ) 
{
	if ($nome_campo == 'valore_naa_cr')	
		$nome_campo1 = "NAA/CR VALUE";
	if ($nome_campo == 'valore_cho_cr')	
		$nome_campo1 = "CHO/CR VALUE";	
		
	$n8=0;
	for ($i=0; $i<$n_pazienti; $i++)
	{	
		$rm = new rm_spettroscopica ($id_finali[$i], NULL, NULL, NULL, NULL, NULL, NULL, NULL);
		$rm->retrive_by_id_paziente();

		if ($rm -> getID_array(0) != NULL)
		{	
			$id = $rm -> getID_array(0);
			$rm -> retrive_by_id($id);
			
			if ($nome_campo == 'valore_naa_cr')			
				$valori_1 = $rm->getValore_naa_cr();
			if ($nome_campo == 'valore_cho_cr')			
				$valori_1 = $rm->getCho_cr();
				
			if ($valori_1 == -1000);		
			else
			{
				$valori[$n8] = $valori_1;
				$id_finali_new2[$n8] = $id_finali[$i];
				$n8 = $n8+1;
			}
		}
	}
	$n_pazienti = $n8;
}

// CAMPI SI/NO ---------------------------------------------------------------------------------------------
if  ( ($nome_campo == 'lipidi_lattati') || ($nome_campo == 'mioinositolo') ) 
{
	if ($nome_campo == 'lipidi_lattati')	
	$nome_campo1 = "Lipids / Lactates";
	if ($nome_campo == 'mioinositolo')	
	$nome_campo1 = "Myo Inositol";


	$n8=0;
	$n_on=0;
	for ($i=0; $i<$n_pazienti; $i++)
	{
		$rm = new rm_spettroscopica ($id_finali[$i], NULL, NULL, NULL, NULL, NULL, NULL, NULL);
		$rm->retrive_by_id_paziente();	
		
		if ($rm -> getID_array(0) != NULL)
		{
			$id = $rm -> getID_array(0);
			$rm -> retrive_by_id($id);
			
			if ($nome_campo == 'lipidi_lattati')
			{	
				$valori[$n8] =$rm -> getLipidi_lattati();	
			}
			if ($nome_campo == 'mioinositolo')
			{	
				$valori[$n8] = $rm ->getMioinositolo();			
			}				
			
								
			if ($valori[$n8] == 'on')
				$n_on = $n_on + 1;
			
			$id_finali_new[$n8] = $id_finali[$i];
			$n8 = $n8+1;
		}
	}
	$n_pazienti = $n8;
}

// CAMPI DATE  ---------------------------------------------------------------------------------------------
if  ($nome_campo == 'data_inserimento_spettro') 
{
	$nome_campo1 = "DATE OF EXAM";
		
	$n8=0;
	for ($i=0; $i<$n_pazienti; $i++)
	{	
		$rm = new rm_spettroscopica ($id_finali[$i], NULL, NULL, NULL, NULL, NULL, NULL, NULL);
		$rm->retrive_by_id_paziente();		

		if ($rm -> getID_array(0) != NULL)
		{
			$id = $rm -> getID_array(0);
			$rm -> retrive_by_id($id);
		
			if ($nome_campo == 'data_inserimento_spettro')			
				$valori_1 = $rm ->getData_inserimento();
											
			if ($valori_1 == '0000-00-00');		
			else
			{
				$valori[$n8] = $valori_1;
				$id_finali_new2[$n8] = $id_finali[$i];
				$n8 = $n8+1;
			}
		}
	}
	$n_pazienti = $n8;
}
// *****************************************************************************************************************************


// ************************** SINTOMI ******************************************************************************************	
// Data inizio sintom  ----------------------------------------------------------------
if  ( ($nome_campo == 'data_sintomi') ) 
{
	$nome_campo1 = "Date of first clinical sign";

	$n8=0;
	$n_1=0;
	$n_2=0;
	$n_3=0;	
	$n_4=0;		
	$n_normale=0;		
	for ($i=0; $i<$n_pazienti; $i++)
	{
		$rm = new sintomi (NULL);
		$rm->retrive_by_id($id_finali[$i]);
		
		if ($rm -> getID_sintomi_array(0) != NULL)
		{
			$id = $rm -> getID_sintomi_array(0);
			$rm -> retrive_by_id_sintomi($id);

			$valori[$n8] = $rm->getData_sintomi();	
								
			if ($valori[$n8] == 'ultima_settimana')
				$n_1 = $n_1 + 1;
			if ($valori[$n8] == 'ultimo_mese')
				$n_2 = $n_2 + 1;
			if ($valori[$n8] == 'ultimi_sei_mesi')
				$n_3 = $n_3 + 1;
			if ($valori[$n8] == 'piu_sei_mesi')
				$n_3 = $n_3 + 1;
						
			$id_finali_new[$n8] = $id_finali[$i];
			$n8 = $n8+1;
		}
	}
	$n_pazienti = $n8;
}

// CAMPI SI/NO ---------------------------------------------------------------------------------------------
if  ( ($nome_campo == 'sensitivo') || ($nome_campo == 'motorio') || ($nome_campo == 'crisi_epilettica') || ($nome_campo == 'disturbi_comportamentali') || ($nome_campo == 'cefalea')) 
{
	if ($nome_campo == 'sensitivo')	
	$nome_campo1 = "Sensory deficit";
	if ($nome_campo == 'motorio')	
	$nome_campo1 = "Motor deficit";
	if ($nome_campo == 'crisi_epilettica')	
	$nome_campo1 = "Epilepsy";
	if ($nome_campo == 'disturbi_comportamentali')	
	$nome_campo1 = "Behavioral disorder";
	if ($nome_campo == 'cefalea')	
	$nome_campo1 = "Headache";
			
	$n8=0;
	$n_on=0;
	for ($i=0; $i<$n_pazienti; $i++)
	{
		$rm = new sintomi (NULL);
		$rm->retrive_by_id($id_finali[$i]);
		
		if ($rm -> getID_sintomi_array(0) != NULL)
		{
			$id = $rm -> getID_sintomi_array(0);
			$rm -> retrive_by_id_sintomi($id);
			
			if ($nome_campo == 'sensitivo')
			{	
				$valori[$n8] =$rm -> getDeficit();	
			}
			if ($nome_campo == 'motorio')
			{	
				$valori[$n8] = $rm ->getDeficit_motorio();			
			}				
			if ($nome_campo == 'crisi_epilettica')
			{	
				$valori[$n8] = $rm ->getCrisi_epilettica();			
			}
			if ($nome_campo == 'disturbi_comportamentali')
			{	
				$valori[$n8] = $rm ->getDisturbi_comportamento();			
			}			
			if ($nome_campo == 'cefalea')
			{	
				$valori[$n8] = $rm ->getCefalea();			
			}			
							
			if ($valori[$n8] == 'on')
				$n_on = $n_on + 1;
			
			$id_finali_new[$n8] = $id_finali[$i];
			$n8 = $n8+1;
		}
	}
	$n_pazienti = $n8;
}

// CAMPI DATE  ---------------------------------------------------------------------------------------------
if  ($nome_campo == 'data_inserimento_sintomi') 
{
	$nome_campo1 = "DATE OF EXAM";
		
	$n8=0;
	for ($i=0; $i<$n_pazienti; $i++)
	{	
		$rm = new sintomi (NULL);
		$rm->retrive_by_id($id_finali[$i]);	

		if ($rm -> getID_sintomi_array(0) != NULL)
		{
			$id = $rm -> getID_sintomi_array(0);
			$rm -> retrive_by_id_sintomi($id);
		
			if ($nome_campo == 'data_inserimento_sintomi')			
				$valori_1 = $rm ->getData_inserimento();
											
			if ($valori_1 == '0000-00-00');		
			else
			{
				$valori[$n8] = $valori_1;
				$id_finali_new2[$n8] = $id_finali[$i];
				$n8 = $n8+1;
			}
		}
	}
	$n_pazienti = $n8;
}
// *****************************************************************************************************************************


// ************************** TERAPIA ******************************************************************************************
// CAMPI SI/NO ---------------------------------------------------------------------------------------------
if  ( ($nome_campo == 'rt_conformazionale') || ($nome_campo == 'radiochirurgia')) 
{
	if ($nome_campo == 'rt_conformazionale')	
	$nome_campo1 = "Conformational radiation therapy";
	if ($nome_campo == 'radiochirurgia')	
	$nome_campo1 = "Radiosurgery";

			
	$n8=0;
	$n_on=0;
	for ($i=0; $i<$n_pazienti; $i++)
	{
		$rm = new terapia($id_finali[$i], NULL, NULL, NULL, NULL);
		$rm->retrive_by_id_paziente();
		
		if ($rm -> getID_array(0) != NULL)
		{
			$id = $rm -> getID_array(0);
			$rm -> retrive_by_id($id);
			
			if ($nome_campo == 'rt_conformazionale')
			{	
				$valori[$n8] =$rm -> getRt_conformazionale();	
			}
			if ($nome_campo == 'radiochirurgia')
			{	
				$valori[$n8] = $rm ->getRadiochirurgia();			
			}							
							
			if ($valori[$n8] == 'on')
				$n_on = $n_on + 1;
			
			$id_finali_new[$n8] = $id_finali[$i];
			$n8 = $n8+1;
		}
	}
	$n_pazienti = $n8;
}

// CAMPI DATE  ---------------------------------------------------------------------------------------------------------------------------------------------------------
if  ( ($nome_campo == 'data_rt_conformazionale') || ($nome_campo == 'data_radiochirurgia') ) 
{
	if ($nome_campo == 'data_rt_conformazionale')	
	$nome_campo1 = "Begin Conformational radiation therapy";
	if ($nome_campo == 'data_radiochirurgia')	
	$nome_campo1 = "Begin radiochirurgia";
		
	$n8=0;
	for ($i=0; $i<$n_pazienti; $i++)
	{	
		$rm = new terapia($id_finali[$i], NULL, NULL, NULL, NULL);
		$rm->retrive_by_id_paziente();

		if ($rm -> getID_array(0) != NULL)
		{
			$id = $rm -> getID_array(0);
			$rm -> retrive_by_id($id);
			
			if ($nome_campo == 'data_rt_conformazionale')	
				$valori_1 = $rm->getData_rt_conformazionale();
			if ($nome_campo == 'data_radiochirurgia')	
				$valori_1 = $rm->getData_radiochirurgia();
											
			if ($valori_1 == '0000-00-00');		
			else
			{
				$valori[$n8] = $valori_1;
				$id_finali_new2[$n8] = $id_finali[$i];
				$n8 = $n8+1;
			}
		}
	}
	$n_pazienti = $n8;
}
// *****************************************************************************************************************************



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
// Javascript function *****************************************************************************************************
function stat_function(link, nome_tab)
{
	var nome_tabella1=link[link.selectedIndex].value;
	var nome_tt = nome_tab;

	if (nome_tabella1 == '-')
	{}
	else
	{
		var destination_page = "statistiche.php";
		location.href = destination_page+"?nome_stat="+nome_tabella1+"&nome_val="+nome_tt;
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="style.css">
<title></title>
</head>
<body>
<div align="center">
<?php include ("barra_titolo.html"); ?>
<br />
<hr id='hr1' size='5px'/>
<br />		
<font size='5' color="#FFFFCC" face="Verdana, Arial, Helvetica, sans-serif">		
Statistics on
<?php
if ($nome_tabella == 'data_inserimento')
	print ucfirst('Insertion date');	
else if ($nome_tabella == 'esame_tc')
	print ucfirst('TC Scan');	
else if ($nome_tabella == 'rm_bold')
	print ucfirst('RM BOLD');	
else if ($nome_tabella == 'rm_dti')
	print ucfirst('RM DTI');		
else if ($nome_tabella == 'rm_morfologica')
	print ucfirst('Morfological RM');		
else if ($nome_tabella == 'rm_perfusione')
	print ucfirst('Perfusion RM');
else if ($nome_tabella == 'anagrafica')
	print ucfirst('Patient\'s registry');
else if ($nome_tabella == 'chemioterapia')
	print ucfirst('Chemotherapy');
else if ($nome_tabella == 'intervento')
	print ucfirst('Medical Surgery');	
else if ($nome_tabella == 'permeabilita')
	print ucfirst('Permeability');		
else if ($nome_tabella == 'spettroscopia')
	print ucfirst('Spectroscopy');	
else if ($nome_tabella == 'sintomi')
	print ucfirst('Clinical presentation');		
else if ($nome_tabella == 'terapia')
	print ucfirst('Medical Therapy');	
else
	print ucfirst($nome_tabella); 


?>
</font>
<br /><br />
<font size='4' color='#A3A96D' face='Verdana, Arial, Helvetica, sans-serif'>Select the statistic that you want see:</font>
&nbsp; &nbsp; &nbsp; 

<?php
// Tabella anagrafica *************************************************************************************************************************************
if ($nome_tabella == 'anagrafica')
{
	print ("<select name='tabella_statistica' size='1' cols='10' onChange=\"stat_function(this, '$nome_tabella')\" id='form_statistica'>");
	print ("<OPTION VALUE='-'> </OPTION>");
	print ("<OPTION VALUE='eta'>Age </OPTION>");
	print ("<OPTION VALUE='reparto_provenienza'>Origin Department </OPTION>");
	print ("<OPTION VALUE='anni_vita'>Year of live </OPTION>");
	print ("</select>");
}

// Tabella chemioterapia *************************************************************************************************************************************
if ($nome_tabella == 'chemioterapia')
{
	print ("<select name='tabella_statistica' size='1' cols='10' onChange=\"stat_function(this, '$nome_tabella')\" id='form_statistica'>");
	print ("<OPTION VALUE='-'> </OPTION>");
	print ("<OPTION VALUE='temozolomide'>Temozolomide </OPTION>");
	print ("<OPTION VALUE='pc_v'>PC(V) </OPTION>");
	print ("<OPTION VALUE='fotemustina'>Fotemustina </OPTION>");
	print ("<OPTION VALUE='cicli_temozolomide'>N. Cicli Temozolomide </OPTION>");
	print ("<OPTION VALUE='cicli_pc_v'>N. Cicli PC(V) </OPTION>");
	print ("<OPTION VALUE='cicli_fotemustina'>N. Cicli Fotemustina </OPTION>");
	print ("<OPTION VALUE='data_temozolomide'>Date inizio Temozolomide </OPTION>");	
	print ("<OPTION VALUE='data_pc_v'>Date inizio PC(V) </OPTION>");			
	print ("<OPTION VALUE='data_fotemustina'>Date inizio Fotemustina </OPTION>");		
	print ("</select>");	
}

// Tabella Esame TC *************************************************************************************************************************************
if ($nome_tabella == 'esame_tc')
{
	print ("<select name='tabella_statistica' size='1' cols='10' onChange=\"stat_function(this, '$nome_tabella')\" id='form_statistica'>");
	print ("<OPTION VALUE='-'> </OPTION>");
	print ("<OPTION VALUE='extrassiale'>Extrassial </OPTION>");
	print ("<OPTION VALUE='intrassiale'>Intrassial </OPTION>");
	print ("<OPTION VALUE='dubbia'>Dubtful </OPTION>");
	print ("<OPTION VALUE='contrasto'>Contrast </OPTION>");
	print ("<OPTION VALUE='tipo_contrasto'>Kind of Contrast </OPTION>");
	print ("<OPTION VALUE='sede'>Site </OPTION>");
	print ("<OPTION VALUE='data_inserimento'>Exam date </OPTION>");
	print ("</select>");	
}

// Tabella Data inserimento ******************************************************************************************************************************
if ($nome_tabella == 'data_inserimento')
{
	print ("<select name='tabella_statistica' size='1' cols='10' onChange=\"stat_function(this, '$nome_tabella')\" id='form_statistica'>");
	print ("<OPTION VALUE='-'> </OPTION>");
	print ("<OPTION VALUE='data'>Insertion Date </OPTION>");
	print ("</select>");	
}

// Tabella Intervento ************************************************************************************************************************************
if ($nome_tabella == 'intervento')
{
	print ("<select name='tabella_statistica' size='1' cols='10' onChange=\"stat_function(this, '$nome_tabella')\" id='form_statistica'>");
	print ("<OPTION VALUE='-'> </OPTION>");
	print ("<OPTION VALUE='biopsia'>Biopsy </OPTION>");
	print ("<OPTION VALUE='resezione_totale'>Total tumor resection</OPTION>");	
	print ("<OPTION VALUE='resezione_parziale'>Partial tumor resection</OPTION>");		
	print ("<OPTION VALUE='gliadel'>Gliadel </OPTION>");		
	print ("<OPTION VALUE='data_biopsia'>Date Biopsy </OPTION>");
	print ("<OPTION VALUE='data_resezione_totale'>Date Total tumor resection </OPTION>");	
	print ("<OPTION VALUE='data_resezione_parziale'>Date Partial tumor resection </OPTION>");		
	print ("<OPTION VALUE='data_gliadel'>Date Gliadel </OPTION>");		
	print ("</select>");	
}

// Tabella Permeabilità ************************************************************************************************************************************
if ($nome_tabella == 'permeabilita')
{
	print ("<select name='tabella_statistica' size='1' cols='10' onChange=\"stat_function(this, '$nome_tabella')\" id='form_statistica'>");
	print ("<OPTION VALUE='-'> </OPTION>");
	print ("<OPTION VALUE='valore_k_trans'>K trans value</OPTION>");
	print ("<OPTION VALUE='valore_vi'>vi value </OPTION>");
	print ("<OPTION VALUE='data_inserimento_p'>Date of exam </OPTION>");
	print ("</select>");	
}

// Tabella RM BOLD ************************************************************************************************************************************
if ($nome_tabella == 'rm_bold')
{
	print ("<select name='tabella_statistica' size='1' cols='10' onChange=\"stat_function(this, '$nome_tabella')\" id='form_statistica'>");
	print ("<OPTION VALUE='-'> </OPTION>");
	print ("<OPTION VALUE='area_attivazione_motoria'>MOTOR TEST </OPTION>");
	print ("<OPTION VALUE='area_attivazione_sensitiva'>SENSORY TEST </OPTION>");
	print ("<OPTION VALUE='linguaggio'>LANGUAGE TEST </OPTION>");
	print ("<OPTION VALUE='data_inserimento_bold'>Date of Exam </OPTION>");
		
	print ("</select>");	
}

// Tabella RM DTI ************************************************************************************************************************************
if ($nome_tabella == 'rm_dti')
{
	print ("<select name='tabella_statistica' size='1' cols='10' onChange=\"stat_function(this, '$nome_tabella')\" id='form_statistica'>");
	print ("<OPTION VALUE='-'> </OPTION>");
	print ("<OPTION VALUE='valore_fa'>FA value </OPTION>");
	print ("<OPTION VALUE='fascio_cortico_spinale'>Corticospinal tract </OPTION>");
	print ("<OPTION VALUE='fascio_arcuato'>Fascicle Arcuate </OPTION>");	
	print ("<OPTION VALUE='fascicolo_long_inf'>Superior Longitudinal Fascicle</OPTION>");		
	print ("<OPTION VALUE='vie_ottiche'>Optic Pathway</OPTION>");	
	print ("<OPTION VALUE='data_inserimento_dti'>Date of exam </OPTION>");			
	print ("</select>");	
}

// Tabella RM Morfologica *******************************************************************************************************************************
if ($nome_tabella == 'rm_morfologica')
{
	print ("<select name='tabella_statistica' size='1' cols='10' onChange=\"stat_function(this, '$nome_tabella')\" id='form_statistica'>");
	print ("<OPTION VALUE='-'> </OPTION>");
	print ("<OPTION VALUE='extrassiale_m'>Extrassial </OPTION>");
	print ("<OPTION VALUE='intrassiale_m'>Intrassial </OPTION>");
	print ("<OPTION VALUE='t2_flair'>T2 / Flair </OPTION>");
	print ("<OPTION VALUE='flair_3d'>Flair 3D </OPTION>");	
	print ("<OPTION VALUE='diffusione'>Diffusion </OPTION>");		
	print ("<OPTION VALUE='adc'>ADC </OPTION>");	
	print ("<OPTION VALUE='ce'>Contrast Enhancement </OPTION>");	
	print ("<OPTION VALUE='volume_neo'>Volume NEO </OPTION>");	
	print ("<OPTION VALUE='valore_adc'>ADC value </OPTION>");		
	print ("<OPTION VALUE='tipo_diffusione'>Kind of diffusion </OPTION>");	
	print ("<OPTION VALUE='tipo_adc'>Kind of ADC </OPTION>");		
	print ("<OPTION VALUE='tipo_ce'>Kind of CE </OPTION>");	
	print ("<OPTION VALUE='data_inserimento_morfo'>Date of exam </OPTION>");		
	print ("</select>");	
}

// Tabella RM Perfusione *******************************************************************************************************************************
if ($nome_tabella == 'rm_perfusione')
{
	print ("<select name='tabella_statistica' size='1' cols='10' onChange=\"stat_function(this, '$nome_tabella')\" id='form_statistica'>");
	print ("<OPTION VALUE='-'> </OPTION>");
	print ("<OPTION VALUE='r_cbv_1'>r-CBV (Y/N)</OPTION>");		
	print ("<OPTION VALUE='r_cbv'>r-CBV value</OPTION>");	
	print ("<OPTION VALUE='data_inserimento_perfusione'>Data exam </OPTION>");		
	print ("</select>");	
}

// Tabella RM Spettroscopia *******************************************************************************************************************************
if ($nome_tabella == 'spettroscopia')
{
	print ("<select name='tabella_statistica' size='1' cols='10' onChange=\"stat_function(this, '$nome_tabella')\" id='form_statistica'>");
	print ("<OPTION VALUE='-'> </OPTION>");
	print ("<OPTION VALUE='te'>Echo time (TE) </OPTION>");
	print ("<OPTION VALUE='tipo_spettro'>Kind of spettrum </OPTION>");
	print ("<OPTION VALUE='valore_naa_cr'>Naa/Cr Value </OPTION>");
	print ("<OPTION VALUE='valore_cho_cr'>Cho/Cr Value</OPTION>");
	print ("<OPTION VALUE='lipidi_lattati'>Lipids / Lactates </OPTION>");
	print ("<OPTION VALUE='mioinositolo'>Myo Inositol  </OPTION>");	
	print ("<OPTION VALUE='data_inserimento_spettro'>Date of Exam </OPTION>");				
	print ("</select>");	
}

// Tabella Sintomi *******************************************************************************************************************************
if ($nome_tabella == 'sintomi')
{
	print ("<select name='tabella_statistica' size='1' cols='10' onChange=\"stat_function(this, '$nome_tabella')\" id='form_statistica'>");
	print ("<OPTION VALUE='-'> </OPTION>");
	print ("<OPTION VALUE='data_sintomi'>Date of first clinical sign </OPTION>");
	print ("<OPTION VALUE='sensitivo'>Sensory deficit   </OPTION>");
	print ("<OPTION VALUE='motorio'>Motro deficit   </OPTION>");
	print ("<OPTION VALUE='crisi_epilettica'>Epilepsy </OPTION>");
	print ("<OPTION VALUE='disturbi_comportamentali'>Behavioral disorder  </OPTION>");
	print ("<OPTION VALUE='cefalea'>Headache</OPTION>");
	print ("<OPTION VALUE='data_inserimento_sintomi'>Date of exam </OPTION>");	
	print ("</select>");	
}

// Tabella Terapia *******************************************************************************************************************************
if ($nome_tabella == 'terapia')
{
	print ("<select name='tabella_statistica' size='1' cols='10' onChange=\"stat_function(this, '$nome_tabella')\" id='form_statistica'>");
	print ("<OPTION VALUE='-'> </OPTION>");
	print ("<OPTION VALUE='rt_conformazionale'>Conformational radiation therapy </OPTION>");
	print ("<OPTION VALUE='radiochirurgia'>Radiosurgery </OPTION>");
	print ("<OPTION VALUE='data_rt_conformazionale'>Date begin Conformational RT</OPTION>");			
	print ("<OPTION VALUE='data_radiochirurgia'>Date begin Radiosurgery</OPTION>");	
	print ("</select>");	
}



?>

<br /><br />
<?php
// ************************************* ETA' ******************************************************************************************************************
// *************************************************************************************************************************************************************
if ($nome_campo == 'eta')
{
	include ("statistica/statistica_numeri.php");
}
// ************************************* FINE ETA' *************************************************************************************************************
// *************************************************************************************************************************************************************

// ************************************* REPARTO DI PROVENIENZA ************************************************************************************************
// *************************************************************************************************************************************************************
if ($nome_campo == 'reparto_provenienza')
{
	include ("statistica/statistica_reparto_provenienza.php");
}
// ************************************* FINE REPARTO DI PROVENIENZA *******************************************************************************************
// *************************************************************************************************************************************************************

// ************************************* ANNI DI VITA **********************************************************************************************************
// *************************************************************************************************************************************************************
if ($nome_campo == 'anni_vita')
{
	include ("statistica/statistica_numeri.php");
}
// ************************************* FINE ANNI DI VITA *****************************************************************************************************
// *************************************************************************************************************************************************************


// ************************************* TEMOZOLOMIDE - PC(V) - FOTEMUSTINA ************************************************************************************
// *************************************************************************************************************************************************************
if  ( ($nome_campo == 'temozolomide') || ($nome_campo == 'pc_v') || ($nome_campo == 'fotemustina') ) 
{
	include ("statistica/statistica_si_no.php");
}
// ************************************* FINE EMOZOLOMIDE - PC(V) - FOTEMUSTINA ********************************************************************************
// *************************************************************************************************************************************************************

// ************************************* CICLI *****************************************************************************************************************
// *************************************************************************************************************************************************************
if  ( ($nome_campo == 'cicli_temozolomide') || ($nome_campo == 'cicli_pc_v') || ($nome_campo == 'cicli_fotemustina') ) 
{
	include ("statistica/statistica_numeri.php");
}
// *************************************FINE  CICLI ************************************************************************************************************
// *************************************************************************************************************************************************************

// ************************************* DATE *****************************************************************************************************************
// *************************************************************************************************************************************************************
if  ( ($nome_campo == 'data_temozolomide') || ($nome_campo == 'data_pc_v') || ($nome_campo == 'data_fotemustina') ) 
{
	include ("statistica/statistica_date.php");
}
// *************************************FINE  DATE ************************************************************************************************************
// *************************************************************************************************************************************************************

// ************************************* SI/NO per ESAME TC ****************************************************************************************************
// *************************************************************************************************************************************************************
if  ( ($nome_campo == 'extrassiale') || ($nome_campo == 'intrassiale') || ($nome_campo == 'dubbia') || ($nome_campo == 'contrasto') ) 
{
	include ("statistica/statistica_si_no.php");
}
// *************************************FINE  SI/NO per ESAME TC ***********************************************************************************************
// *************************************************************************************************************************************************************

// ************************************* REPARTO DI PROVENIENZA ************************************************************************************************
// *************************************************************************************************************************************************************
if ($nome_campo == 'tipo_contrasto')
{
	include ("statistica/statistica_tipo_contrasto.php");
}
// ************************************* FINE REPARTO DI PROVENIENZA *******************************************************************************************
// *************************************************************************************************************************************************************

// ************************************* SEDE ******************************************************************************************************************
// *************************************************************************************************************************************************************
if ($nome_campo == 'sede')
{
	include ("statistica/statistica_sede.php");
}
// ************************************* FINE SEDE *************************************************************************************************************
// *************************************************************************************************************************************************************

// ************************************* DATE *****************************************************************************************************************
// *************************************************************************************************************************************************************
if  ($nome_campo == 'data_inserimento')
{
	include ("statistica/statistica_date.php");
}
// *************************************FINE  DATE ************************************************************************************************************
// *************************************************************************************************************************************************************

// ************************************* DATA INSERIMENTO ******************************************************************************************************
// *************************************************************************************************************************************************************
if  ($nome_campo == 'data') 
{
	include ("statistica/statistica_data_inserimento.php");
}
// *************************************FINE  DATA INSERIMENTO *************************************************************************************************
// *************************************************************************************************************************************************************

// ************************************* SI/NO per INTERVENTO **************************************************************************************************
// *************************************************************************************************************************************************************
if  ( ($nome_campo == 'biopsia') || ($nome_campo == 'resezione_totale') || ($nome_campo == 'resezione_parziale') || ($nome_campo == 'gliadel') ) 
{
	include ("statistica/statistica_si_no.php");
}
// ************************************* FINE SI/NO per INTERVENTO *********************************************************************************************
// *************************************************************************************************************************************************************

// ************************************* DATE *****************************************************************************************************************
// *************************************************************************************************************************************************************
if  ( ($nome_campo == 'data_biopsia') || ($nome_campo == 'data_resezione_totale') || ($nome_campo == 'data_resezione_parziale') || ($nome_campo == 'data_gliadel') ) 
{
	include ("statistica/statistica_date.php");
}
// *************************************FINE  DATE ************************************************************************************************************
// *************************************************************************************************************************************************************


// ************************************* NUMERO - PERMEABILITA' ************************************************************************************************
// *************************************************************************************************************************************************************
if  ( ($nome_campo == 'valore_k_trans') || ($nome_campo == 'valore_vi') )
{
	include ("statistica/statistica_numeri.php");
}
// ************************************* FINE NUMERO - PERMEABILITA' *******************************************************************************************
// *************************************************************************************************************************************************************


// ************************************* DATE *****************************************************************************************************************
// *************************************************************************************************************************************************************
if  ($nome_campo == 'data_inserimento_p') 
{
	include ("statistica/statistica_date.php");
}
// *************************************FINE  DATE ************************************************************************************************************
// *************************************************************************************************************************************************************


// ************************************* ATTIVAZIONE MOTORIA ***************************************************************************************************
// *************************************************************************************************************************************************************
if ( ($nome_campo == 'area_attivazione_motoria') || ($nome_campo == 'area_attivazione_sensitiva') ) 
{
	include ("statistica/statistica_attivazione.php");
} 
// ************************************* FINE ATTIVAZIONE MOTORIA **********************************************************************************************
// *************************************************************************************************************************************************************


// ************************************* DATE *****************************************************************************************************************
// *************************************************************************************************************************************************************
if  ($nome_campo == 'data_inserimento_bold') 
{
	include ("statistica/statistica_date.php");
}
// *************************************FINE  DATE ************************************************************************************************************
// *************************************************************************************************************************************************************


// ************************************* SI/NO per linguaggio **************************************************************************************************
// *************************************************************************************************************************************************************
if  ( ($nome_campo == 'linguaggio') ) 
{
	include ("statistica/statistica_linguaggio.php");
}

// ************************************* FINE SI/NO per linguaggio ********************************************************************************************
// *************************************************************************************************************************************************************


// ************************************* VALORE FA *************************************************************************************************************
// *************************************************************************************************************************************************************
if  ($nome_campo == 'valore_fa') 
{
	include ("statistica/statistica_numeri.php");
}
// *************************************FINE  VALORE FA ********************************************************************************************************
// *************************************************************************************************************************************************************


// ************************************* SI/NO per DTI ********************************************************************************************************
// *************************************************************************************************************************************************************
if  ( ($nome_campo == 'fascio_cortico_spinale') || ($nome_campo == 'fascio_arcuato') || ($nome_campo == 'fascicolo_long_inf') || ($nome_campo == 'vie_ottiche') ) 
{
	include ("statistica/statistica_dti.php");
}
// ************************************* FINE SI/NO per DTI ****************************************************************************************************
// *************************************************************************************************************************************************************


// ************************************* DATE *****************************************************************************************************************
// *************************************************************************************************************************************************************
if  ($nome_campo == 'data_inserimento_dti') 
{
	include ("statistica/statistica_date.php");
}
// *************************************FINE  DATE ************************************************************************************************************
// *************************************************************************************************************************************************************


// ************************************* SI/NO per Morfologica ************************************************************************************************
// *************************************************************************************************************************************************************
if  ( ($nome_campo == 'extrassiale_m') || ($nome_campo == 'intrassiale_m') || ($nome_campo == 't2_flair') || ($nome_campo == 'flair_3d') || ($nome_campo == 'diffusione') || ($nome_campo == 'adc') || ($nome_campo == 'ce') ) 
{
	include ("statistica/statistica_si_no.php");
}
// ************************************* FINE SI/NO per Morfologica ********************************************************************************************
// *************************************************************************************************************************************************************


// ************************************* numero per Morfologica *************************************************************************************************
// *************************************************************************************************************************************************************
if  ( ($nome_campo == 'volume_neo') || ($nome_campo == 'valore_adc') ) 
{
	include ("statistica/statistica_numeri.php");
}
// ************************************* FINE numero per Morfologica *******************************************************************************************
// *************************************************************************************************************************************************************


// ************************************* tipo diffusione ******************************************************************************************************
// *************************************************************************************************************************************************************
if  ( ($nome_campo == 'tipo_diffusione') ) 
{
	include ("statistica/statistica_tipo_diffusione.php");
}
// ************************************* FINE tipo diffusione **************************************************************************************************
// *************************************************************************************************************************************************************


// ************************************* tipo ADC ******************************************************************************************************
// *************************************************************************************************************************************************************
if  ( ($nome_campo == 'tipo_adc') ) 
{
	include ("statistica/statistica_tipo_adc.php");
}
// ************************************* FINE tipo ADC  **************************************************************************************************
// *************************************************************************************************************************************************************


// ************************************* tipo CE ******************************************************************************************************
// *************************************************************************************************************************************************************
if  ( ($nome_campo == 'tipo_ce') ) 
{
	include ("statistica/statistica_tipo_ce.php");
}
// ************************************* FINE tipo CE  **************************************************************************************************
// *************************************************************************************************************************************************************


// ************************************* DATE *****************************************************************************************************************
// *************************************************************************************************************************************************************
if  ($nome_campo == 'data_inserimento_morfo') 
{
	include ("statistica/statistica_date.php");
}
// *************************************FINE  DATE ************************************************************************************************************
// *************************************************************************************************************************************************************


// ************************************* DATE *****************************************************************************************************************
// *************************************************************************************************************************************************************
if  ($nome_campo == 'data_inserimento_perfusione') 
{
	include ("statistica/statistica_date.php");
}
// *************************************FINE  DATE ************************************************************************************************************
// *************************************************************************************************************************************************************


// ************************************* numero per r-CBV *****************************************************************************************************
// *************************************************************************************************************************************************************
if  ( ($nome_campo == 'r_cbv') ) 
{
	include ("statistica/statistica_numeri.php");
}
// ************************************* FINE numero per r-CBV *************************************************************************************************
// *************************************************************************************************************************************************************

// ************************************* r-CBV *****************************************************************************************************************
// *************************************************************************************************************************************************************
if  ( ($nome_campo == 'r_cbv_1') ) 
{
	include ("statistica/statistica_r_cbv.php");
}
// ************************************* FINE  r-CBV **********************************************************************************************************
// *************************************************************************************************************************************************************


// ************************************* TE *****************************************************************************************************************
// *************************************************************************************************************************************************************
if  ( ($nome_campo == 'te') ) 
{
	include ("statistica/statistica_te.php");
}
// ************************************* FINE TE *****************************************************************************************************************
// *************************************************************************************************************************************************************


// ************************************* tIPO SPETTRO *****************************************************************************************************************
// *************************************************************************************************************************************************************
if  ( ($nome_campo == 'tipo_spettro') ) 
{
	include ("statistica/statistica_tipo_spettro.php");
}
// ************************************* fine Tipo spettro *****************************************************************************************************************
// *************************************************************************************************************************************************************


// ************************************* numero  *****************************************************************************************************
// *************************************************************************************************************************************************************
if  ( ($nome_campo == 'valore_naa_cr') || ($nome_campo == 'valore_cho_cr') ) 
{
	include ("statistica/statistica_numeri.php");
}
// ************************************* FINE  *************************************************************************************************
// *************************************************************************************************************************************************************


// ************************************* SI/NO  *****************************************************************************************************
// *************************************************************************************************************************************************************
if  ( ($nome_campo == 'lipidi_lattati') || ($nome_campo == 'mioinositolo') ) 
{
	include ("statistica/statistica_si_no.php");
}
// ************************************* fine SI/NO  *****************************************************************************************************
// *************************************************************************************************************************************************************


// ************************************* DATA  *****************************************************************************************************
// *************************************************************************************************************************************************************
if  ($nome_campo == 'data_inserimento_spettro') 
{
	include ("statistica/statistica_date.php");
}
// *************************************FINE  DATE ************************************************************************************************************
// *************************************************************************************************************************************************************


// ************************************* DATA SITNOMI  *****************************************************************************************************
// *************************************************************************************************************************************************************

if  ( ($nome_campo == 'data_sintomi') )
{
	include ("statistica/statistica_data_sintomi.php");
}

// ************************************* FINE DATA SITNOMI  *****************************************************************************************************
// *************************************************************************************************************************************************************


// ************************************* SI/NO  *****************************************************************************************************
// *************************************************************************************************************************************************************
if  ( ($nome_campo == 'sensitivo') || ($nome_campo == 'motorio') || ($nome_campo == 'crisi_epilettica') || ($nome_campo == 'disturbi_comportamentali') || ($nome_campo == 'cefalea'))
 {
	include ("statistica/statistica_si_no.php");
}
// ************************************* fine SI/NO  *****************************************************************************************************
// *************************************************************************************************************************************************************


// ************************************* DATA  *****************************************************************************************************
// *************************************************************************************************************************************************************
if  ($nome_campo == 'data_inserimento_sintomi')
{
	include ("statistica/statistica_date.php");
}
// *************************************FINE  DATE ************************************************************************************************************
// *************************************************************************************************************************************************************


// ************************************* SI/NO  *****************************************************************************************************
// *************************************************************************************************************************************************************
if  ( ($nome_campo == 'rt_conformazionale') || ($nome_campo == 'radiochirurgia')) 
{
	include ("statistica/statistica_si_no.php");
}
// ************************************* fine SI/NO  *****************************************************************************************************
// *************************************************************************************************************************************************************


// ************************************* DATA  *****************************************************************************************************
// *************************************************************************************************************************************************************
if  ( ($nome_campo == 'data_rt_conformazionale') || ($nome_campo == 'data_radiochirurgia') ) 
{
	include ("statistica/statistica_date.php");
}
// *************************************FINE  DATE ************************************************************************************************************
// *************************************************************************************************************************************************************


?>


<br /><br />
</div>
</body>
</html>