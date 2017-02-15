<?php
// script per la creazione del PDF ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

session_start();
include ("accesso_db.php");

include ("convertitore_date.php");
include ("function_php/try_format_date.php");
require_once('class/class.patient.php');
require_once('class/class.dataExamInsert.php');
require_once('class/class.sintomi.php');
require_once('class/class.esame_tc.php');
require_once('class/class.rm_morfologica.php');
require_once('class/class.rm_perfusione.php');
require_once('class/class.rm_spettroscopica.php');
require_once('class/class.rm_bold.php');
require_once('class/class.rm_dti.php');
require_once('class/class.xx.php');  // classe permeabilità rinominata perchè creava dei problemi!
require_once('class/class.intervento.php');
require_once('class/class.istologia.php');
require_once('class/class.terapia.php');
require_once('class/class.chemioterapia.php');


if ($permission == NULL)
	header("Location:errore.html");

$id_paziente = $_REQUEST['id_paziente'];

	
define('FPDF_FONTPATH','fpdf151/font/');   // <--- cartella dei FONTS
//questo file e la cartella font si trovano nella stessa directory
require('fpdf151/fpdf.php');	


// nome e cognome del paziente:
$paziente = new patient($id_paziente, NULL, NULL);
$paziente -> retrive_by_ID($id_paziente);
$nome = $paziente->getName();
$cognome = $paziente->getSurname();
$nascita = $paziente->getBirthday();

$data_ins = new dataExaminsert(NULL);
$data_ins -> setID_paziente($id_paziente);
$data_ins -> retrive_data(); 
$data_inserimento = $data_ins->getData_inserimento();

$sintomi1 = new sintomi(NULL, NULL);   
$sintomi1->retrive_by_id($id_paziente);

// creazione della pagina PDF:
$p = new fpdf();
$p->Open();
$p->AddPage();

$data = date("d.m.y");

$p->SetTextColor(176,176,176); // Con queste due funzioni imposto il carattere
$p->SetFont('Arial', '', 8);
$testo = $data." ___________________________________________________________________________________ BrainTumors Database (c)";
$p->Text(12, 14,$testo);


// ++++++++++++++++ DATI ANAGRAFICI	E SINTOMI - page 1 +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// nome e cognome:
$p->SetTextColor(0,0,255); // Con queste due funzioni imposto il carattere
$p->SetFont('Arial', '', 17);
$testo = $cognome." ".$nome." - (".data_convert_for_utente($data_inserimento).")";
$p->Text(15, 25,$testo);

// data nascita:
$p->SetTextColor(0); // Con queste due funzioni imposto il carattere
$p->SetFont('Arial', '', 10);
$testo = "Data di nascita: ". $nascita;
$p->Text(18, 35,$testo);

// indirizzo:
$p->SetTextColor(0); // Con queste due funzioni imposto il carattere
$p->SetFont('Arial', '', 10);
$testo = "Indirizzo: ".$paziente->getAddress();
$p->Text(18, 40,$testo);

// telefono:
$p->SetTextColor(0); // Con queste due funzioni imposto il carattere
$p->SetFont('Arial', '', 10);
$testo = "Telefono: ".$paziente->getTelephone();
$p->Text(18, 45,$testo);

// Reparto di provenienza:
$p->SetTextColor(0); // Con queste due funzioni imposto il carattere
$p->SetFont('Arial', '', 10);
$testo = "Reparto di provenienza: ".$paziente->getReparto_provenienza();
$p->Text(18, 55,$testo);

// Note:
$p->SetTextColor(0); // Con queste due funzioni imposto il carattere
$p->SetFont('Arial', '', 10);
$testo = "Note: ".$paziente->getNote();
$p->Text(18, 65,$testo);

// Sintomi:
$p->SetTextColor(0); // Con queste due funzioni imposto il carattere
$p->SetFont('Arial', '', 13);
$testo = "SINTOMI _____________________________________________";
$p->Text(16, 95,$testo);

// Data inserimento sintomi:
$p->SetTextColor(0); // Con queste due funzioni imposto il carattere
$p->SetFont('Arial', '', 10);

$data_sintomi = $sintomi1->getData_sintomi();
if ($data_sintomi == 'piu_sei_mesi')
	$data_sintomi = 'Più di sei mesi';
if ($data_sintomi == 'ultima_settimana')
	$data_sintomi = 'Ultima settimana';
if ($data_sintomi == 'ultimo_mese')
	$data_sintomi = 'Ultimo mese';
if ($data_sintomi == 'ultimi_sei_mesi')
	$data_sintomi = 'Ultimi sei mesi';
	
$testo = "Data: ".$data_sintomi;
$p->Text(16, 105,$testo);

// Tipo sintomi:
$sin[0]=$sintomi1->getDeficit();
$sin[1]=$sintomi1->getDeficit_motorio();
$sin[2]=$sintomi1->getCrisi_epilettica();
$sin[3]=$sintomi1->getDisturbi_comportamento();
$sin[4]=$sintomi1->getCefalea();

$title[0]='Deficit sensitivo: ';
$title[1]='Deficit motorio: ';
$title[2]='Crisi epilettica: ';
$title[3]='Disturbi comportamento: ';
$title[4]='Cefalea: ';

$y=110;
for ($i=0; $i<5; $i++)
{
	if ($sin[$i] == 'on')
		$var = 'Si';
	else
		$var = 'No';	

	$testo = $title[$i].$var;
	$p->Text(18, $y, $testo);

	$y=$y+5;
}

$testo = "Altro: ".$sintomi1->getSintomi_altro();
$p->Text(18, 140, $testo);

$testo = "Note: ".$sintomi1->getNote();
$p->Text(18, 150, $testo);

// Data del decesso:
$p->SetTextColor(160,0,0); // Con queste due funzioni imposto il carattere
$p->SetFont('Arial', '', 12);
$testo = "Data del decesso: ".data_convert_for_utente($paziente->getData_decesso());
$p->Text(16, 250,$testo);

// ++++++++++++++++ FINE DATI ANAGRAFICI E SINTOMI  +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


// ******************** IMAGING - **************************************************************************************************************************************
// *********************************************************************************************************************************************************************

$esame_tc = new esame_tc($id_paziente, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
$esame_tc -> retrive_by_id_paziente();

$rm_morfologica = new rm_morfologica($id_paziente, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
$rm_morfologica->retrive_by_id_paziente();

$rm_perfusione = new rm_perfusione($id_paziente, NULL, NULL, NULL);
$rm_perfusione->retrive_by_id_paziente($id_paziente);

$rm_spettroscopica = new rm_spettroscopica($id_paziente, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
$rm_spettroscopica->retrive_by_id_paziente();

$rm_bold = new rm_bold($id_paziente, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL ,NULL ,NULL, NULL, NULL, NULL, NULL, NULL);
$rm_bold->retrive_by_id_paziente();

$rm_dti = new rm_dti ($id_paziente, NULL, NULL, NULL, NULL, NULL);
$rm_dti->retrive_by_id_paziente();

$permeabilita = new xx($id_paziente, NULL, NULL);
$permeabilita -> retrive_by_id_paziente();

	// esame TC+++++++++++++++++++++++++++++++++++++++++++++++++++++++
	$p->AddPage();

	$p->SetTextColor(176,176,176); 
	$p->SetFont('Arial', '', 8);
	$testo = $data." ___________________________________________________________________________________ BrainTumors Database (c)";
	$p->Text(12, 14,$testo);
	
	$p->SetTextColor(0,0,255); // Con queste due funzioni imposto il carattere
	$p->SetFont('Arial', '', 13);
	$testo = "IMAGING __________________________________________";
	$p->Text(16, 30,$testo);	
	
	$p->SetTextColor(0); 
	$p->SetFont('Arial', '', 11);
	$testo = "ESAME TC";
	$p->Text(18, 40,$testo);
			
	$y=45;	
	for ($i=0; $i<$n_esame_tc; $i++)
	{
		$id = $esame_tc -> getID_esame_tc_array($i);
		$esame_tc -> retrive_by_id($id);

		$p->SetFont('Arial', '', 10);
		if ($esame_tc -> getExtrassiale() == 'on')
			$var = 'Si';
		else
			$var ='No';
		$testo = "Extrassiale: ".$var;
		$p->Text(19, $y,$testo);
		
		if ($esame_tc -> getIntrassiale() == 'on')
			$var = 'Si';
		else
			$var ='No';
		$testo = "Intrassiale: ".$var;
		$p->Text(19, $y+5,$testo);
		
		if ($esame_tc -> getDubbia() == 'on')
			$var = 'Si';
		else
			$var ='No';
		
		$testo = "Dubbia: ".$var;
		$p->Text(19, $y+10,$testo);
		
		if ($esame_tc -> getContrasto() == 'on')
			$var = 'Si';
		else
			$var ='No';
		
		$testo = "Contrast Enhancement: ".$var." - ".$esame_tc -> getTipo_contrasto();
		$p->Text(19, $y+15,$testo);
		
		$testo = "Sede: ".$esame_tc -> getSede();
		$p->Text(19, $y+20,$testo);
		
		$testo = "___________________ Inserito in data: ".data_convert_for_utente($esame_tc -> getData_inserimento());
		$p->Text(16, $y+25,$testo);
		
		$y=$y+35;
	}	
	// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	// RM MORFOLOGICA +++++++++++++++++++++++++++++++++++++++++++++++++++++++
	$p->AddPage();

	$p->SetTextColor(176,176,176); 
	$p->SetFont('Arial', '', 8);
	$testo = $data." ___________________________________________________________________________________ BrainTumors Database (c)";
	$p->Text(12, 14,$testo);
	
	$p->SetTextColor(0,0,255); // Con queste due funzioni imposto il carattere
	$p->SetFont('Arial', '', 13);
	$testo = "IMAGING __________________________________________";
	$p->Text(16, 30,$testo);	
	
	$y=40;
	
	$p->SetTextColor(0); 
	$p->SetFont('Arial', '', 11);
	$testo = "RM MORFOLOGICA";
	$p->Text(18, $y,$testo);

	$y=$y+5;
	for ($i=0; $i<$n_rm_morfologica; $i++)
	{
		$id = $rm_morfologica -> getID_array($i);
		$rm_morfologica -> retrive_by_id($id);

		$p->SetFont('Arial', '', 10);
		if ($rm_morfologica -> getExtrassiale() == 'on')
			$var = 'Si';
		else
			$var ='No';
		$testo = "Extrassiale: ".$var;
		$p->Text(19, $y, $testo);

		$p->SetFont('Arial', '', 10);
		if ($rm_morfologica -> getIntrassiale() == 'on')
			$var = 'Si';
		else
			$var ='No';
		$testo = "Intrassiale: ".$var;
		$p->Text(19, $y+5, $testo);
		
		$p->SetFont('Arial', '', 10);
		if ($rm_morfologica -> getT2_flair() == 'on')
			$var = 'Si';
		else
			$var ='No';
		$testo = "T2 / FLAIR: ".$var;
		$p->Text(19, $y+10, $testo);		
		
		
		$p->SetFont('Arial', '', 10);
		if ($rm_morfologica -> getFlair_3d() == 'on')
			$var = 'Si';
		else
			$var ='No';
			
		if ($rm_morfologica -> getVolume_neo() == -1000)
			$valore = NULL;
		else
			$valore = $rm_morfologica -> getVolume_neo();			
		$testo = "FLAIR 3D: ".$var. " - Volume NEO: ".$valore;
		$p->Text(19, $y+15, $testo);		
		
		$p->SetFont('Arial', '', 10);
		if ($rm_morfologica -> getDwi() == 'on')
			$var = 'Si';
		else
			$var ='No';
		$testo = "Diffusione: ".$var. " - ".$rm_morfologica -> getDwi_ristretta();
		$p->Text(19, $y+20, $testo);		
		
		$p->SetFont('Arial', '', 10);
		if ($rm_morfologica -> getAdc() == 'on')
			$var = 'Si';
		else
			$var ='No';
			
		if ($rm_morfologica -> getValore_adc_ridotto() == -1000)
			$valore = NULL;
		else
			$valore = $rm_morfologica -> getValore_adc_ridotto();	
		$testo = "ADC: ".$var. " - ".$rm_morfologica -> getAdc_ridotto()." - Valore: ".$valore;
		$p->Text(19, $y+25, $testo);		
		
		$p->SetFont('Arial', '', 10);
		if ($rm_morfologica -> getCe() == 'on')
			$var = 'Si';
		else
			$var ='No';
		$testo = "Contrast Enhancement: ".$var." - ".$rm_morfologica -> getTipo_ce();
		$p->Text(19, $y+30, $testo);		

		$testo = "___________________ Inserito in data: ".data_convert_for_utente($rm_morfologica -> getData_inserimento());
		$p->Text(16, $y+35,$testo);
		
		$y=$y+45;
	}
	// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	// RM PERFUSIONE +++++++++++++++++++++++++++++++++++++++++++++++++++++++
	$p->AddPage();

	$p->SetTextColor(176,176,176); 
	$p->SetFont('Arial', '', 8);
	$testo = $data." ___________________________________________________________________________________ BrainTumors Database (c)";
	$p->Text(12, 14,$testo);
	
	$p->SetTextColor(0,0,255); // Con queste due funzioni imposto il carattere
	$p->SetFont('Arial', '', 13);
	$testo = "IMAGING __________________________________________";
	$p->Text(16, 30,$testo);	
	
	$y=40;

	$p->SetTextColor(0); 
	$p->SetFont('Arial', '', 11);
	$testo = "RM PERFUSIONE";
	$p->Text(18, $y,$testo);
	
	$y=$y+5;
	for ($i=0; $i<$n_rm_perfusione; $i++)
	{	
		$id = $rm_perfusione -> getID_rm_perfusione_array($i);
		$rm_perfusione -> retrive_by_id($id);	
	
		$p->SetFont('Arial', '', 10);
		if ($rm_perfusione -> getR_cbv() == 'inf')
			$var = 'INFERIORE A 1.75  ';
		else
			$var ='SUPERIORE A 1.75  ';
			
		if ($rm_perfusione -> getValore_r_cbv() == -1000)
			$valore = NULL;
		else
			$valore = $rm_perfusione -> getValore_r_cbv();			
		$testo = "r-CBV: ".$var. " - Valore: ".$valore;
		$p->Text(19, $y, $testo);

		$testo = "___________________ Inserito in data: ".data_convert_for_utente($rm_perfusione -> getData_inserimento());
		$p->Text(16, $y+5,$testo);
		
		$y=$y+15;
	}
	// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


	// RM SPETTORSCOPICA +++++++++++++++++++++++++++++++++++++++++++++++++++++++
	$p->AddPage();

	$p->SetTextColor(176,176,176); 
	$p->SetFont('Arial', '', 8);
	$testo = $data." ___________________________________________________________________________________ BrainTumors Database (c)";
	$p->Text(12, 14,$testo);
	
	$p->SetTextColor(0,0,255); // Con queste due funzioni imposto il carattere
	$p->SetFont('Arial', '', 13);
	$testo = "IMAGING __________________________________________";
	$p->Text(16, 30,$testo);	
	
	$y=40;

	$p->SetTextColor(0); 
	$p->SetFont('Arial', '', 11);
	$testo = "RM SPETTROSCOPICA";
	$p->Text(18, $y,$testo);
	
	$y=$y+5;
	for ($i=0; $i<$n_rm_spettroscopica; $i++)  //$n_rm_spettroscopica
	{	
		$id = $rm_spettroscopica -> getID_array($i);
		$rm_spettroscopica -> retrive_by_id($id);

		$p->SetFont('Arial', '', 10);
		if ($rm_spettroscopica -> getTe() == 'breve')
			$var = 'Breve ';
		if ($rm_spettroscopica -> getTe() == 'intermedio')
			$var = 'Intermedio ';
		if ($rm_spettroscopica -> getTe() == 'lungo')
			$var = 'Lungo ';
		$testo = "T.E.: ".$var;
		$p->Text(19, $y, $testo);

		$p->SetFont('Arial', '', 10);
		$testo = "Tipo di spettro: ".$rm_spettroscopica -> getTipo_spettro();
		$p->Text(19, $y+5, $testo);

		$p->SetFont('Arial', '', 10);
		if ($rm_spettroscopica -> getNaa_ridotto() == 'on')
			$var = 'Si';
		else
			$var ='No';
			
		if ($rm_spettroscopica -> getValore_naa_cr() == -1000)
			$valore = NULL;
		else
			$valore = $rm_spettroscopica -> getValore_naa_cr();			
		$testo = "Naa Ridotto: ".$var. " - Naa/Cr Valore: ".$valore;
		$p->Text(19, $y+10, $testo);	


		$p->SetFont('Arial', '', 10);			
		if ($rm_spettroscopica -> getCho_cr() == -1000)
			$valore = NULL;
		else
			$valore = $rm_spettroscopica -> getCho_cr();			
		$testo = "Valore Cho/Cr: ".$valore;
		$p->Text(19, $y+15, $testo);	


		$p->SetFont('Arial', '', 10);
		if ($rm_spettroscopica -> getLipidi_lattati() == 'on')
			$var = 'Si';
		else
			$var ='No';			
		$testo = "Lipidi / Lattati: ".$var;
		$p->Text(19, $y+20, $testo);


		$p->SetFont('Arial', '', 10);
		if ($rm_spettroscopica -> getMioinositolo() == 'on')
			$var = 'Si';
		else
			$var ='No';			
		$testo = "Mioinositolo: ".$var;
		$p->Text(19, $y+25, $testo);

		$testo = "___________________ Inserito in data: ".data_convert_for_utente($rm_spettroscopica -> getData_inserimento());
		$p->Text(16, $y+30,$testo);
		
		$y=$y+40;
	}
	// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


	// RM  BOLD +++++++++++++++++++++++++++++++++++++++++++++++++++++++
	$p->AddPage();

	$p->SetTextColor(176,176,176); 
	$p->SetFont('Arial', '', 8);
	$testo = $data." ___________________________________________________________________________________ BrainTumors Database (c)";
	$p->Text(12, 14,$testo);
	
	$p->SetTextColor(0,0,255); // Con queste due funzioni imposto il carattere
	$p->SetFont('Arial', '', 13);
	$testo = "IMAGING __________________________________________";
	$p->Text(16, 30,$testo);	
	
	$y=40;

	$p->SetTextColor(0); 
	$p->SetFont('Arial', '', 11);
	$testo = "RM BOLD";
	$p->Text(18, $y,$testo);
	
	$y=$y+5;
	for ($i=0; $i<$n_rm_bold; $i++)  //$n_rm_bold
	{	
		$id = $rm_bold -> getID_array($i);
		$rm_bold -> retrive_by_id($id);

		$p->SetFont('Arial', '', 10);
		$testo = "MOTORIO";
		$p->Text(19, $y, $testo);

		$p->SetFont('Arial', '', 10);
		$testo = "Sede: ".$rm_bold -> getMotorio_sede();
		$p->Text(19, $y+5, $testo);

		$p->SetFont('Arial', '', 10);		
		$motorio_anteriore =$rm_bold -> getMotorio_anteriore();
		if ($motorio_anteriore == 'on')
			$var1 = 'Anteriore';
		$motorio_posteriore =$rm_bold -> getMotorio_posteriore();
		if ($motorio_posteriore == 'on')
			$var2 = 'Posteriore';		
		$motorio_mediale =$rm_bold -> getMotorio_mediale();
		if ($motorio_mediale == 'on')
			$var3 = 'Mediale';			
		$motorio_intralesionale =$rm_bold -> getMotorio_intralesionale();
		if ($motorio_intralesionale == 'on')
			$var4 = 'Intralesionale';		
		$motorio_laterale =$rm_bold -> getMotorio_laterale();
		if ($motorio_laterale == 'on')
			$var5 = 'Laterale';				
		$motorio_inferiore =$rm_bold -> getMotorio_inferiore();
		if ($motorio_inferiore == 'on')
			$var6 = 'Inferiore';					
		$motorio_superiore =$rm_bold -> getMotorio_superiore();
		if ($motorio_superiore == 'on')
			$var7 = 'Superiore';			
		$motorio_altro =$rm_bold -> getMotorio_altro();
		$testo = $var1." - ".$var2." - ".$var3." - ".$var4." - ".$var5." - ".$var6." - ".$var7." - Altro: ".$motorio_altro;
		$p->Text(19, $y+10, $testo);		


		$p->SetFont('Arial', '', 10);
		$testo = "SENSITIVO";
		$p->Text(19, $y+20, $testo);

		$p->SetFont('Arial', '', 10);
		$testo = "Sede: ".$rm_bold -> getSensitiva_sede();
		$p->Text(19, $y+25, $testo);

		$p->SetFont('Arial', '', 10);		
		$sensitivo_anteriore =$rm_bold -> getSensitiva_anteriore();
		if ($sensitivo_anteriore == 'on')
			$var11 = 'Anteriore';
		$sensitivo_posteriore =$rm_bold -> getSensitiva_posteriore();
		if ($sensitivo_posteriore == 'on')
			$var12 = 'Posteriore';		
		$sensitivo_mediale =$rm_bold -> getSensitiva_mediale();
		if ($sensitivo_mediale == 'on')
			$var13 = 'Mediale';			
		$sensitivo_intralesionale =$rm_bold -> getSensitiva_intralesionale();
		if ($sensitivo_intralesionale == 'on')
			$var14 = 'Intralesionale';		
		$sensitivo_laterale =$rm_bold -> getSensitiva_laterale();
		if ($sensitivo_laterale == 'on')
			$var15 = 'Laterale';				
		$sensitivo_inferiore =$rm_bold -> getSensitiva_inferiore();
		if ($sensitivo_inferiore == 'on')
			$var16 = 'Inferiore';					
		$sensitivo_superiore =$rm_bold -> getSensitiva_superiore();
		if ($sensitivo_superiore == 'on')
			$var17 = 'Superiore';			
		$sensitivo_altro =$rm_bold -> getSensitiva_altro();
		$testo = $var11." - ".$var12." - ".$var13." - ".$var14." - ".$var15." - ".$var16." - ".$var17." - Altro: ".$sensitiva_altro;
		$p->Text(19, $y+30, $testo);

		$p->SetFont('Arial', '', 10);
		$testo = "LINGUAGGIO";
		$p->Text(19, $y+40, $testo);

		$p->SetFont('Arial', '', 10);
		if ($rm_bold -> getLinguaggio_broca() == 'on')
			$var = 'Si';
		else
			$var ='No';			
		$testo = "Attivazione circonvoluzione frontale inferiore (Broca): ".$var;
		$p->Text(19, $y+45, $testo);


		$p->SetFont('Arial', '', 10);
		if ($rm_bold -> getLinguaggio_wermicke() == 'on')
			$var = 'Si';
		else
			$var ='No';			
		$testo ="Attivazione temporale postero-superiore (Wernicke) ".$var;
		$p->Text(19, $y+50, $testo);


		$testo = "___________________ Inserito in data: ".data_convert_for_utente($rm_bold -> getData_inserimento());
		$p->Text(16, $y+60,$testo);
		
		$y=$y+70;
	}
	// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


	// RM  DTI ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	$p->AddPage();

	$p->SetTextColor(176,176,176); 
	$p->SetFont('Arial', '', 8);
	$testo = $data." ___________________________________________________________________________________ BrainTumors Database (c)";
	$p->Text(12, 14,$testo);
	
	$p->SetTextColor(0,0,255); // Con queste due funzioni imposto il carattere
	$p->SetFont('Arial', '', 13);
	$testo = "IMAGING __________________________________________";
	$p->Text(16, 30,$testo);	
	
	$y=40;

	$p->SetTextColor(0); 
	$p->SetFont('Arial', '', 11);
	$testo = "RM DTI";
	$p->Text(18, $y,$testo);
	
	$y=$y+5;
	for ($i=0; $i<$n_rm_dti; $i++)  //$n_rm_dti
	{	
		$id = $rm_dti -> getID_array($i);
		$rm_dti -> retrive_by_id($id);


		$p->SetFont('Arial', '', 10);
		if ($rm_dti -> getValore_fa() == -1000)
			$valore = NULL;
		else
			$valore = $rm_dti -> getValore_fa();			
		$testo = "Valore di FA: ".$valore;
		$p->Text(19, $y, $testo);	

	
		$testo = "Fascio cortico-spinale: ".$rm_dti -> getCortico_spinale();
		$p->Text(19, $y+5, $testo);

		$testo = "Fascio arcuato: ".$rm_dti -> getArcuato();
		$p->Text(19, $y+10, $testo);

		$testo = "Fascicolo long.inf: ".$rm_dti -> getLongitudinale_inferiore();
		$p->Text(19, $y+15, $testo);

		$testo = "Vie ottiche: ".$rm_dti -> getVie_ottiche();
		$p->Text(19, $y+20, $testo);


		$testo = "___________________ Inserito in data: ".data_convert_for_utente($rm_dti -> getData_inserimento());
		$p->Text(16, $y+25,$testo);
		
		$y=$y+35;
	}
	// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


	// RM  PERMEABILITA' ++++++++++++++++++++++++++++++++++++++++++++++++++++
	$p->AddPage();

	$p->SetTextColor(176,176,176); 
	$p->SetFont('Arial', '', 8);
	$testo = $data." ___________________________________________________________________________________ BrainTumors Database (c)";
	$p->Text(12, 14,$testo);
	
	$p->SetTextColor(0,0,255); // Con queste due funzioni imposto il carattere
	$p->SetFont('Arial', '', 13);
	$testo = "IMAGING __________________________________________";
	$p->Text(16, 30,$testo);	
	
	$y=40;

	$p->SetTextColor(0); 
	$p->SetFont('Arial', '', 11);
	$testo = "PERMEABILITA'";
	$p->Text(18, $y,$testo);
	
	$y=$y+5;
	for ($i=0; $i<$n_permeabilita; $i++)  
	{
		$id = $permeabilita -> getID_array($i);
		$permeabilita-> retrive_by_id($id);

		$p->SetFont('Arial', '', 10);
		if ($permeabilita -> getK_trans() == -1000)
			$valore = NULL;
		else
			$valore = $permeabilita -> getK_trans();			
		$testo = "Valore di K trans: ".$valore;
		$p->Text(19, $y, $testo);	

		$p->SetFont('Arial', '', 10);
		if ($permeabilita -> getVi() == -1000)
			$valore = NULL;
		else
			$valore = $permeabilita -> getVi();			
		$testo = "Valore di Vi: ".$valore;
		$p->Text(19, $y+5, $testo);


		$testo = "___________________ Inserito in data: ".data_convert_for_utente($permeabilita -> getData_inserimento());
		$p->Text(16, $y+10,$testo);
		
		$y=$y+25;
	}
	// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
// ********************FINE IMAGING - **********************************************************************************************************************************
// *********************************************************************************************************************************************************************	
	
	
// ********************INTERVENTO - ************************************************************************************************************************************
// *********************************************************************************************************************************************************************		
$intervento = new intervento($id_paziente, NULL, NULL, NULL, NULL, NULL, NULL,NULL, NULL);
$intervento -> retrive_by_id_paziente();

$p->AddPage();

$p->SetTextColor(176,176,176); 
$p->SetFont('Arial', '', 8);
$testo = $data." ___________________________________________________________________________________ BrainTumors Database (c)";
$p->Text(12, 14,$testo);

$p->SetTextColor(0,0,255); // Con queste due funzioni imposto il carattere
$p->SetFont('Arial', '', 13);
$testo = "INTERVENTO ________________________________________";
$p->Text(16, 30,$testo);	

$p->SetTextColor(0); 
$p->SetFont('Arial', '', 11);
	
$y=40;
for ($i=0; $i<$n_intervento; $i++)  
{
	$id = $intervento -> getID_array($i);
	$intervento -> retrive_by_id($id);

	$p->SetFont('Arial', '', 10);
	if ($intervento -> getBiopsia() == 'on')
	{
		$valore = 'Si';
		$testo = "Biopsia: ".$valore." - eseguita in data: ".data_convert_for_utente($intervento -> getData_biopsia() );
		$p->Text(19, $y, $testo);	
	}
	else;		


	$p->SetFont('Arial', '', 10);
	if ($intervento -> getResezione_totale() == 'on')
	{
		$valore = 'Si';
		$testo = "Resezione totale: ".$valore." - eseguita in data: ".data_convert_for_utente($intervento -> getData_resezione_totale() );
		$p->Text(19, $y+5, $testo);	
	}
	else;


	$p->SetFont('Arial', '', 10);
	if ($intervento -> getResezione_parziale() == 'on')
	{
		$valore = 'Si';
		$testo = "Resezione parziale: ".$valore." - eseguita in data: ".data_convert_for_utente($intervento -> getData_resezione_parziale() );
		$p->Text(19, $y+10, $testo);	
	}
	else;

	$p->SetFont('Arial', '', 10);
	if ($intervento -> getResezione_gliadel() == 'on')
	{
		$valore = 'Si';
		$testo = "Gliadel: ".$valore." - eseguita in data: ".data_convert_for_utente($intervento -> getData_resezione_gliadel() );
		$p->Text(19, $y+15, $testo);	
	}
	else;

	$y=$y+25;
}
	
// ********************FINE INTERVENTO - *******************************************************************************************************************************
// *********************************************************************************************************************************************************************	
	
	
// ********************ISTOLOGIA - *************************************************************************************************************************************
// *********************************************************************************************************************************************************************	
$isto = new istologia($id_paziente, NULL, NULL);
$isto -> retrive_by_id_paziente();

$p->AddPage();

$p->SetTextColor(176,176,176); 
$p->SetFont('Arial', '', 8);
$testo = $data." ___________________________________________________________________________________ BrainTumors Database (c)";
$p->Text(12, 14,$testo);

$p->SetTextColor(0,0,255); // Con queste due funzioni imposto il carattere
$p->SetFont('Arial', '', 13);
$testo = "ISTOLOGIA __________________________________________";
$p->Text(16, 30,$testo);	

$p->SetTextColor(0); 
$p->SetFont('Arial', '', 11);
	
$y=40;	
for ($i=0; $i<$n_istologia; $i++)  
{
	$id = $isto -> getID_array($i);
	$isto -> retrive_by_id($id);
	
	$testo = "Data risultato istologico: ".data_convert_for_utente($isto -> getData_risultato());
	$p->Text(19, $y, $testo);	
	
	$testo = "Tipo di tunore: ".$isto -> getTumore();
	$p->Text(19, $y+5, $testo);

	$testo = "NOTE: ".$isto -> getNote_tumore();
	$p->Text(19, $y+15, $testo);

	$testo = "___________________________";
	$p->Text(19, $y+20, $testo);
	
	$y=$y+40;
}	
// ******************** FINE ISTOLOGIA - *******************************************************************************************************************************
// *********************************************************************************************************************************************************************		
	
	
// ********************TERAPIA E CHEMIO - ******************************************************************************************************************************
// *********************************************************************************************************************************************************************	
$terapia = new terapia($id_paziente, NULL, NULL, NULL, NULL);
$terapia -> retrive_by_id_paziente();

$chemioterapia = new chemioterapia($id_paziente, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
$chemioterapia -> retrive_by_id_paziente();


$p->AddPage();

$p->SetTextColor(176,176,176); 
$p->SetFont('Arial', '', 8);
$testo = $data." ___________________________________________________________________________________ BrainTumors Database (c)";
$p->Text(12, 14,$testo);

$p->SetTextColor(0,0,255); // Con queste due funzioni imposto il carattere
$p->SetFont('Arial', '', 13);
$testo = "TERAPIA _____________________________________________";
$p->Text(16, 30,$testo);	

$p->SetTextColor(0); 
$p->SetFont('Arial', '', 11);	

$y=40;	
for ($i=0; $i<$n_terapia; $i++)  
{
	$id = $terapia -> getID_array($i);
	$terapia -> retrive_by_id($id);
	
	$p->SetFont('Arial', '', 10);
	if ($terapia -> getRt_conformazionale() == 'on')
	{
		$valore = 'Si';
		$testo = "RT conformazionale: ".$valore." - eseguita in data: ".data_convert_for_utente($terapia -> getData_rt_conformazionale() );
		$p->Text(19, $y, $testo);	
	}
	else
	{
		$testo = "RT conformazionale: No";
		$p->Text(19, $y, $testo);	
	}
	
	
	$p->SetFont('Arial', '', 10);
	if ($terapia -> getRadiochirurgia() == 'on')
	{
		$valore = 'Si';
		$testo = "Radiochirurgia: ".$valore." - eseguita in data: ".data_convert_for_utente($terapia -> getData_radiochirurgia() );
		$p->Text(19, $y+5, $testo);	
	}
	else
	{
		$testo = "Radiochirurgia: No";
		$p->Text(19, $y+5, $testo);	
	}


	$id1 = $chemioterapia -> getID_array($i);
	$chemioterapia -> retrive_by_id($id1);

	$p->SetFont('Arial', '', 10);
	if ($chemioterapia -> getTemozolomide() == 'on')
	{
		$valore = 'Si';
		$testo = "Temozolomide: ".$valore." - eseguita in data: ".data_convert_for_utente($chemioterapia -> getData_temozolomide() )." - N° cicli: ".$chemioterapia -> getCicli_temozolomide();
		$p->Text(19, $y+10, $testo);	
	}
	else
	{
		$testo = "Temozolomide: No";
		$p->Text(19, $y+10, $testo);	
	}


	$p->SetFont('Arial', '', 10);
	if ($chemioterapia -> getPc_v() == 'on')
	{
		$valore = 'Si';
		$testo = "PC(V): ".$valore." - eseguita in data: ".data_convert_for_utente($chemioterapia -> getData_pc_v() )." - N° cicli: ".$chemioterapia -> getCicli_pc_v();
		$p->Text(19, $y+15, $testo);	
	}
	else
	{
		$testo = "PC(V): No";
		$p->Text(19, $y+15, $testo);	
	}


	$p->SetFont('Arial', '', 10);
	if ($chemioterapia -> getFotemustina() == 'on')
	{
		$valore = 'Si';
		$testo = "Fotemustina+bevactizumab: ".$valore." - eseguita in data: ".data_convert_for_utente($chemioterapia -> getData_fotemustina() )." - N° cicli: ".$chemioterapia -> getCicli_fotemustina();
		$p->Text(19, $y+20, $testo);	
	}
	else
	{
		$testo = "Fotemustina+bevactizumab: No";
		$p->Text(19, $y+20, $testo);	
	}


	$p->SetFont('Arial', '', 10);
	if ($chemioterapia -> getAltro() == 'on')
	{
		$valore = 'Si';
		$testo = "Altro: ".$valore." - eseguita in data: ".data_convert_for_utente($chemioterapia -> getData_altro() );
		$p->Text(19, $y+25, $testo);	
	}
	else
	{
		$testo = "Altro: No";
		$p->Text(19, $y+25, $testo);	
	}


	$p->SetFont('Arial', '', 10);
	if ($chemioterapia -> getTerapia_supporto() == 'on')
	{
		$valore = 'Si';
		$testo = "Terapia di supporto: ".$valore." - eseguita in data: ".data_convert_for_utente($chemioterapia -> getData_terapia_supporto() );
		$p->Text(19, $y+30, $testo);	
	}
	else
	{
		$testo = "Terapia di supporto: No";
		$p->Text(19, $y+30, $testo);	
	}

	$testo = "___________________________";
	$p->Text(19, $y+35, $testo);

	$y=$y+45;
}		

// ********************FINE TERAPIA E CHEMIO - *************************************************************************************************************************
// *********************************************************************************************************************************************************************

$p->output(); // Senza parametri rende il file al browser
?>