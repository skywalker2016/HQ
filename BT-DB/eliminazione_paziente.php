<?php
session_start();
include ("accesso_db.php");

if ($permission == NULL)
	header("Location:errore.html");
	
include ("convertitore_date.php");

require_once('class/class.patient.php');
require_once('class/class.dataExamInsert.php');
require_once('class/class.sintomi.php');
require_once('class/class.esame_tc.php');
require_once('class/class.rm_morfologica.php');
require_once('class/class.rm_perfusione.php');
require_once('class/class.rm_spettroscopica.php');
require_once('class/class.rm_bold.php');
require_once('class/class.rm_dti.php');
require_once('class/class.intervento.php');
require_once('class/class.terapia.php');
require_once('class/class.chemioterapia.php');
require_once('class/class.istologia.php');
require_once('class/class.permeabilita.php');

$id_paziente = $_REQUEST['id'];

// Script per l'eliminazione del paziente e dei suoi dati **************************************************************************************
// Aggiungere nuove eliminazioni se si inseriscono altri dati relativi al paziente *************************************************************

// ++ paziente:
$paziente = new patient(NULL, NULL, NULL);
$paziente -> delete_patient($id_paziente);

// ++ Inserimento:
$inserimento= new dataExamInsert(NULL);
$inserimento->delete_patient($id_paziente);

// ++ Sintomi:
$sintomi = new sintomi(NULL);
$sintomi->delete_patient($id_paziente);

// ++ Esame TC
$esame_tc= new esame_tc(NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
$esame_tc->delete_patient($id_paziente);

// ++ RM Morfologica
$rm_morfologica = new rm_morfologica(NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
$rm_morfologica->delete_patient($id_paziente);

// ++ RM perfusione
$rm_perfusione = new rm_perfusione(NULL, NULL, NULL, NULL);
$rm_perfusione->delete_patient($id_paziente);

// ++ RM spettroscopica
$rm_spettroscopica = new rm_spettroscopica($id_paziente, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
$rm_spettroscopica->delete_patient($id_paziente);

// ++ RM BOLD
$rm_bold = new rm_bold(NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL ,NULL ,NULL, NULL, NULL, NULL, NULL, NULL);
$rm_bold->delete_patient($id_paziente);

// ++ RM DTI
$rm_dti = new rm_dti (NULL, NULL, NULL, NULL, NULL, NULL);
$rm_dti->delete_patient($id_paziente);

// ++ RM permeabilità
$permeabilita = new permeabilita(NULL, NULL, NULL);
$permeabilita->delete_patient($id_paziente);

// ++ INTERVENTO
$intervento = new intervento(NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL); 
$intervento->delete_patient($id_paziente);

// ++ ISTOLOGIA
$istologia = new istologia(NULL, NULL, NULL);
$istologia->delete_patient($id_paziente);

// ++ TERAPIA
$terapia = new terapia(NULL, NULL, NULL, NULL, NULL);
$terapia->delete_patient($id_paziente);

// ++ CHEMIOTERAPIA
$chemioterapia = new chemioterapia(NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
$chemioterapia->delete_patient($id_paziente);

$pagina = 11;
include ("log.php");

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
<br /><br /><br />
<div id='conferma'>
Thi patient has been removed from the database
</div>
<br /><br /><br /><br /><br /><br />
<form action="home2.php">
<input type="submit" value=' HOME ' id='form2'/>
</form>

<br />
</div>
</body>
</html>