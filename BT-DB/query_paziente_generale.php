<?php
session_start();
include ("accesso_db.php");

if ($permission == NULL)
	header("Location:errore.html");

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
require_once('class/class.intervento.php');
require_once('class/class.terapia.php');
require_once('class/class.chemioterapia.php');
require_once('class/class.istologia.php');
require_once('class/class.permeabilita.php');

// delete tutte le sessioni:
$_SESSION['flag_aggiorna'] = NULL;

$id_paziente = $_REQUEST['id'];
$paziente = new patient($id_paziente, NULL, NULL);
$paziente -> retrive_by_ID($id_paziente);

$pagina = 9;
include ("log.php");

$sintomi = new sintomi(NULL);

$inserimento= new dataExamInsert(NULL);
$inserimento->setID_paziente($id_paziente);
$inserimento->retrive_data();
$data_inserimento_paziente = $inserimento->getData_inserimento();
$data_inserimento_paziente = data_convert_for_utente($data_inserimento_paziente);

$esame_tc= new esame_tc($id_paziente, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
$esame_tc->retrive_by_id_paziente();

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

$intervento = new intervento($id_paziente, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL); 
$intervento -> retrive_by_id_paziente();

$terapia = new terapia($id_paziente, NULL, NULL, NULL, NULL);
$terapia -> retrive_by_id_paziente();

$chemioterapia = new chemioterapia($id_paziente, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
$chemioterapia -> retrive_by_id_paziente();

$istologia = new istologia($id_paziente, NULL, NULL);
$istologia -> retrive_by_id_paziente();

$permeabilita = new permeabilita($id_paziente, NULL, NULL);
$permeabilita -> retrive_by_id_paziente();

// Carica le pagine per inserire li nuovi esami di imaging: +++++++++++++++++++++++++++++++++++
if ($_REQUEST['carica'] == 1)
{
	echo("<script language=\"javascript\">"); 

	if ($_REQUEST['nuovo_imaging'] == 'esame_tc')
		echo("window.open('nuovo_esame_tc.php?id_paziente=$id_paziente&start=1');");
	else if ($_REQUEST['nuovo_imaging'] == 'rm_morfologica')
		echo("window.open('nuovo_rm_morfologica.php?id_paziente=$id_paziente&start=1');");
	else if ($_REQUEST['nuovo_imaging'] == 'rm_perfusione')
		print("window.open('nuovo_rm_perfusione.php?id_paziente=$id_paziente&start=1');");
	else if ($_REQUEST['nuovo_imaging'] == 'rm_spettroscopica')
		print("window.open('nuovo_rm_spettroscopica.php?id_paziente=$id_paziente&start=1');");	
	else if ($_REQUEST['nuovo_imaging'] == 'rm_bold')
		print("window.open('nuovo_rm_bold.php?id_paziente=$id_paziente&start=1');");	
	else if ($_REQUEST['nuovo_imaging'] == 'rm_dti')
		print("window.open('nuovo_rm_dti.php?id_paziente=$id_paziente&start=1');");
	else if ($_REQUEST['nuovo_imaging'] == 'rm_permeabilita')
		print("window.open('nuovo_permeabilita.php?id_paziente=$id_paziente&start=1');");					
	else;			
				
	echo("</script>"); 
}


// ELIMINA I DATI DALLE TABELLE **********************************************************************************************
// ***************************************************************************************************************************
if ($_REQUEST['elimina'] == 1)
{
	$nome_tabella = $_REQUEST['tabella3'];
	$id_esame = $_REQUEST['id_esame'];

	if ($nome_tabella == 'esame_tc')
		$esame_tc->delete($id_esame);
	else if ($nome_tabella == 'rm_morfologica')
		$rm_morfologica->delete($id_esame);
	else if ($nome_tabella == 'rm_perfusione')
		$rm_perfusione->delete($id_esame);
	else if ($nome_tabella == 'rm_spettroscopica')
		$rm_spettroscopica->delete($id_esame);
	else if ($nome_tabella == 'rm_bold')
		$rm_bold->delete($id_esame);
	else if ($nome_tabella == 'rm_dti')
		$rm_dti->delete($id_esame);
	else if ($nome_tabella == 'intervento')
		$intervento->delete($id_esame);
	else if ($nome_tabella == 'istologia')
		$istologia->delete($id_esame);
	else if ($nome_tabella == 'permeabilita')
		$permeabilita->delete($id_esame);
			
	// Terapia:
	else if ($nome_tabella == 'rt_conformazionale')
		$terapia->delete_rt_conformazionale($id_esame);
	else if ($nome_tabella == 'radiochirurgia')
		$terapia->delete_radiochirurgia($id_esame);

	// Chemioterapia:
	else if ($nome_tabella == 'temozolomide')
		$chemioterapia->delete_temozolomide($id_esame);	
	else if ($nome_tabella == 'pc_v')
		$chemioterapia->delete_pc_v($id_esame);	
	else if ($nome_tabella == 'fotemustina')
		$chemioterapia->delete_fotemustina($id_esame);	
	else if ($nome_tabella == 'altro')
		$chemioterapia->delete_altro($id_esame);	
	else if ($nome_tabella == 'terapia_supporto')
		$chemioterapia->delete_terapia_supporto($id_esame);

	$pagina = 10;
	include ("log.php");

	print("<script type='text/javascript'>alert('Si prega di aggiornare la pagina per visualizzare le modifiche');</script>");
}

// Arriva dalla pagina della ricerca:
$ricerca = $_REQUEST['ricerca'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
// Javascript function *****************************************************************************************************
function conferma(tabe, id1, id_esame1, delete1)
{
	var chiedi_conferma;
	var tabella2 = tabe;
	var id = id1;
	var id_esame = id_esame1;
	var del = delete1;

	chiedi_conferma=confirm("Are you sure");
	if (chiedi_conferma == true)
	{ 
   	 	location.href=("query_paziente_generale.php?tabella3="+tabella2+"&id="+id+"&id_esame="+id_esame1+"&elimina="+del); //ricarica la pagina 
  	} 
}

function eliminazione_paziente(id1)
{
	var chiedi_conferma;
	var id_paziente = id1;

	chiedi_conferma =confirm("Do you want to remove this patient togheter her/his exams?");
	if (chiedi_conferma == true)
	{ 
   	 	location.href=("eliminazione_paziente.php?id="+id_paziente); //ricarica la pagina 
  	} 

}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="style.css">
<title></title>
</head>
<body>

<div id='query_paziente' align="center">
	<br />
	<table border="0" width="100%">
		<tr>
			<td width="20%" align="center">
			<?php
			if ($paziente->getSex() == 'F')
				print ("<img src='images/donna.gif' width='150' id='border'/>");
			else
				print ("<img src='images/uomo.gif' width='150' id='border'/>");
			?>
			</td>
			<td width="80%" align="left">
			<?php
			$cognome = $paziente->getSurname();
			$nome = $paziente->getName();
			$data_nascita = $paziente->getBirthday();
			if ($permission == 3)
			{
				$cognome = $cognome[0]."************";
				$nome = $nome[0]."************";
				$data_nascita = "************";		
			}
			
			print ("<table border='0' width='80%'>");
			print ("<tr>");
				print ("<td align='left' width='40%'  bgcolor='#6464A1'>");
					print ("<font color='#00CCCC' face='Verdana, Arial, Helvetica, sans-serif'> Last name: </font>");
				print ("</td>");
				print ("<td align='left' width='60%' bgcolor='#6464A1'>");
					print ("<font color='#A4B8F2' face='Verdana, Arial, Helvetica, sans-serif'> $cognome </font>");
				print ("</td>");						
			print ("</tr>");
			print ("<tr>");
				print ("<td align='left' width='40%' bgcolor='#6464A1'>");
					print ("<font color='#00CCCC' face='Verdana, Arial, Helvetica, sans-serif'> Name: </font>");
				print ("</td>");
				print ("<td align='left' width='60%' bgcolor='#6464A1'>");
					print ("<font color='#A4B8F2' face='Verdana, Arial, Helvetica, sans-serif'> $nome </font><br>");
				print ("</td>");						
			print ("</tr>");
			print ("<tr>");
				print ("<td align='left' width='40%' bgcolor='#6464A1'>");
					print ("<font color='#00CCCC' face='Verdana, Arial, Helvetica, sans-serif'> Date of birth: </font>");
				print ("</td>");
				print ("<td align='left' width='60%' bgcolor='#6464A1'>");
					print ("<font color='#A4B8F2' face='Verdana, Arial, Helvetica, sans-serif'> $data_nascita </font><br>");
				print ("</td>");						
			print ("</tr>");
			print ("<tr>");
				print ("<td align='left' width='40%' bgcolor='#6464A1'>");
					print ("<font color='#00CCCC' face='Verdana, Arial, Helvetica, sans-serif'> Date: </font>");
				print ("</td>");
				print ("<td align='left' width='60%' bgcolor='#6464A1'>");
					print ("<font color='#A4B8F2' face='Verdana, Arial, Helvetica, sans-serif'> $data_inserimento_paziente </font><br>");
				print ("</td>");						
			print ("</tr>");
			print ("</table>");
			?>
			</td>
	</tr>
	</table>
	<br />
	<!-- tabella eliminazione paziente ***************************************************************************************** -->
	<table border='0' width='100%' cellpadding="4" cellspacing="2">
		<tr>
			<td width="5%" align="center"></td>
			<td width="3%" align="center">
				<?php
				if ($permission == 3);
				else
					print ("<a onClick=\"javascript:eliminazione_paziente($id_paziente)\">");				
				?>
				
				<img src="images/elimina.png" width="15" alt="Delete this patient" title="Delete this patient" border="0"/>
			</td>
			<td width="20%" align="left">
					<font face="Verdana, Arial, Helvetica, sans-serif" color="#FFFFA4" size="2">Delete this patient</font>
			</td>
			<td width="3%" align="center">
				<?php
				print ("<a href='creazione_pdf.php?id_paziente=$id_paziente' target='_blank'>");
				?>
				<img src="images/printer_pdf.jpg" width="15" alt="PDF buiding" title="PDF buiding" border="0"/>
				</a>
			</td>
			<td width="20%" align="left">
				<font face="Verdana, Arial, Helvetica, sans-serif" color="#FFFFA4" size="2">pdf creation</font>
			</td>
			
			<td width="3%" align="center">
				<?php
				print ("<a href='gestione_files.php?id_paziente=$id_paziente' target='_blank'>");
				?>
				<img src="images/ins_files.png" width="17" alt="Files management" title="Files management" border="0"/>
				</a>
			</td>
			<td width="20%" align="left">
				<font face="Verdana, Arial, Helvetica, sans-serif" color="#FFFFA4" size="2">File management</font>
			</td>			
			<td width="28%" align="left"></td>
		</tr>
	</table>
	<br />
</div>
<br />

<div align="center">
<table border="0" width="95%">
<tr>
	<td width="90%" align="left">

		<!-- tabella dati anagrafici ***************************************************************************************** -->
		<table border="0" width="100%">
			<tr>
				<td width="5%" align="center" id='tabella_10'>
				<a href='query_paziente.php?id=<?php print $id_paziente;?>' target="_blank">
				<img src="images/view.png" width="16" alt="Show" title="Show" border="0"/>
				</a>
				</td>
				<td width="85%" align="left" id='tabella_10'>
					<font id='font8'>Patient personal data and Date of death</font>
				</td>
				<td width="10%" align="left">
				</td>		
			</tr>
		</table>
		<!-- fine tabella dati anagrafici ************************************************************************************* -->
		
		<!-- Tabella DECESSO ************************************************************************************************** -->
		
		<?php
		if ($paziente->getData_decesso() != NULL)
		{
			$data_nascita =  data_convert_for_mysql($paziente->getBirthday());
			$data_decesso = $paziente->getData_decesso();
			// deve calcolare gli anni di vita:
			$anno_morte = NULL;
			$anno_nascita = NULL;
			for ($pp=0; $pp<4; $pp++)
				$anno_morte = $anno_morte.$data_decesso[$pp];
			for ($pp=0; $pp<4; $pp++)
				$anno_nascita = $anno_nascita.$data_nascita[$pp];			
											
			$durata_anno =$anno_morte-$anno_nascita;		
		?>
			<table border="0" width="100%">	
				<tr>
					<td width="5%" align="center" id='tabella_10'>
					</td>
					<td width="85%" align="left" id='tabella_10'>
						<font id='font8'>Date of death: </font>
						<font face="Verdana, Arial, Helvetica, sans-serif" size='2' color="#F9B7FF">
						<?php print data_convert_for_utente($paziente->getData_decesso()); 
						print (" - Year: $durata_anno");
						?>
						</font>
					</td>
					<td width="10%" align="left">
					</td>		
				</tr>
			</table>		
		<?php
		}
		?>
		
		<br />
		
		<!-- tabella dati Sintomi ********************************************************************************************* -->
		<?php
		// Controlla quanti sintomi registrati ha il paziente:
		$sintomi -> retrive_by_ID($id_paziente);
		?>
		<table border="0" width="100%">
			<tr>
				<td width="40%" align="left" bgcolor="#AAB3D1">
				<font face="Verdana, Arial, Helvetica, sans-serif" color="#000066" size="3">
				Clinical presentation
				</font>
				</td>	
				<td width="60%" align="left">
				</td>		
			</tr>
		</table>

		<table border="0" width="100%">
		<?php
		for ($i=0; $i<$n_id_sintomi; $i++)
		{
			$sintomi -> retrive_by_ID_sintomi($sintomi->getID_sintomi_array($i));
			$data_inserimento_sintomi = $sintomi->getData_inserimento();
			$data_inserimento_sintomi = data_convert_for_utente($data_inserimento_sintomi);
			
		?>	
			<tr>
				<td width="5%" align="center" id='tabella_10'>
				<?php 
				$id_sintomi = $sintomi->getID_sintomi();
				print ("<a href='query_sintomi.php?id_paziente=$id_paziente&id_sintomi=$id_sintomi' target='_blank' >");
				?>
				<img src="images/view.png" width="16" alt="Show" title="Show" border="0"/>
				</td>
				<td width="85%" align="left" id='tabella_10'>
					<font id='font8'>Clinical sign</font>
					<font face="Verdana, Arial, Helvetica, sans-serif" size='2' color="#FFFFCC">
					- Date 
					<?php print $data_inserimento_sintomi; ?>
					</font>
				</td>
				<td width="10%" align="left">
				</td>		
			</tr>
		<?php
		}
		?>
		</table>
		<!-- fine tabella dati Sintomi ***************************************************************************************** -->

		<br />
		
		<!-- tabella dati Imaging ********************************************************************************************* -->
		<table border="0" width="100%">
			<tr>
				<td width="40%" align="left" bgcolor="#AAB3D1">
				<font face="Verdana, Arial, Helvetica, sans-serif" color="#000066" size="3">
				Imaging
				</font>
				</td>	
				<td width="60%" align="left">
				</td>		
			</tr>
		</table>
			<table border="0" width="100%">
			<!-- tabella esame_tc +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
			<?php		
			for ($i=0; $i<$n_esame_tc; $i++)
			{	
				$id_esame_tc = $esame_tc->getID_esame_tc_array($i);	
				$esame_tc -> retrive_by_id($id_esame_tc);
				
				$data_inserimento_esame_tc=$esame_tc->getData_inserimento();
				$data_inserimento_esame_tc = data_convert_for_utente($data_inserimento_esame_tc);
			?>	
				<tr>
					<td width="5%" align="center" id='tabella_10'>
					<?php 
					print ("<a href='query_esame_tc.php?id_paziente=$id_paziente&id_esame_tc=$id_esame_tc&start=1' target='_blank' >");
					?>
					<img src="images/view.png" width="16" alt="Show" title="Show" border="0"/>
					</td>
					<td width="5%" align="center" id='tabella_10'>
					<?php
					if ($permission == 3);
					else
						print ("<a onClick=\"javascript:conferma('esame_tc', $id_paziente, $id_esame_tc, 1)\">");
					?>
					<img src="images/elimina.png" width="16" alt="Delete" title="Delete" border="0"/>
					</td>
					<td width="80%" align="left" id='tabella_10'>
						<font id='font8'>TC scan</font>
						<font face="Verdana, Arial, Helvetica, sans-serif" size='2' color="#FFFFCC">
						- Recorderd in date 
						<?php print $data_inserimento_esame_tc; ?>
						</font>
					</td>
					<td width="10%" align="left">
					</td>		
				</tr>
			<?php
			}
			?>			
			<!-- tabella RM morfologica +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
			<?php			
			for ($i=0; $i<$n_rm_morfologica; $i++)
			{	
				$id_rm_morfologica = $rm_morfologica->getID_array($i);	
				$rm_morfologica -> retrive_by_id($id_rm_morfologica);
				
				$data_inserimento_rm_morfologica=$rm_morfologica->getData_inserimento();
				$data_inserimento_rm_morfologica = data_convert_for_utente($data_inserimento_rm_morfologica);
			?>	
				<tr>
					<td width="5%" align="center" id='tabella_10'>
					<?php 
					print ("<a href='nuovo_rm_morfologica.php?id_paziente=$id_paziente&id_rm_morfologica=$id_rm_morfologica&flag_query=1&start=2' target='_blank' >");
					?>
					<img src="images/view.png" width="16" alt="Show" title="Show" border="0"/>
					</td>
					<td width="5%" align="center" id='tabella_10'>
					<?php
					if ($permission == 3);
					else					
						print ("<a onClick=\"javascript:conferma('rm_morfologica', $id_paziente, $id_rm_morfologica, 1)\">");
					?>
					<img src="images/elimina.png" width="16" alt="Elimina" title="Elimina" border="0"/>
					</td>					
					<td width="80%" align="left" id='tabella_10'>
						<font id='font8'>Morphological RM</font>
						<font face="Verdana, Arial, Helvetica, sans-serif" size='2' color="#FFFFCC">
						- Recorderd in date 
						<?php print $data_inserimento_rm_morfologica; ?>
						</font>
					</td>
					<td width="10%" align="left">
					</td>		
				</tr>
			<?php
			}
			?>	

			<!-- tabella RM perfusione +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
			<?php			
			for ($i=0; $i<$n_rm_perfusione; $i++)
			{	
				$id_rm_perfusione = $rm_perfusione->getID_rm_perfusione_array($i);
				$rm_perfusione -> retrive_by_id($id_rm_perfusione);

				$data_inserimento_rm_perfusione=$rm_perfusione->getData_inserimento();
				$data_inserimento_rm_perfusione = data_convert_for_utente($data_inserimento_rm_perfusione);
			?>	
				<tr>
					<td width="5%" align="center" id='tabella_10'>
					<?php 
					print ("<a href='nuovo_rm_perfusione.php?id_paziente=$id_paziente&id_rm_perfusione=$id_rm_perfusione&flag_query=1&start=2' target='_blank' >");
					?>
					<img src="images/view.png" width="16" alt="Show" title="Show" border="0"/>
					</td>
					<td width="5%" align="center" id='tabella_10'>
					<?php
					if ($permission == 3);
					else					
						print ("<a onClick=\"javascript:conferma('rm_perfusione', $id_paziente, $id_rm_perfusione, 1)\">");
					?>
					<img src="images/elimina.png" width="16" alt="Elimina" title="Elimina" border="0"/>
					</td>					
					<td width="80%" align="left" id='tabella_10'>
						<font id='font8'>Perfusion RM</font>
						<font face="Verdana, Arial, Helvetica, sans-serif" size='2' color="#FFFFCC">
						- Recorderd in date  
						<?php  print $data_inserimento_rm_perfusione; ?>
						</font>
					</td>
					<td width="10%" align="left">
					</td>		
				</tr>
			<?php
			}
			?>	

			<!-- tabella RM spettroscopica +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
			<?php			
			for ($i=0; $i<$n_rm_spettroscopica; $i++)
			{	
				$id_rm_spettroscopica = $rm_spettroscopica->getID_array($i);
				$rm_spettroscopica -> retrive_by_id($id_rm_spettroscopica);

				$data_inserimento_rm_spettroscopica=$rm_spettroscopica ->getData_inserimento();
				$data_inserimento_rm_spettroscopica = data_convert_for_utente($data_inserimento_rm_spettroscopica);

				// recupera il valore del T.E. 
				$te1= $rm_spettroscopica->getTe();
			?>	
				<tr>
					<td width="5%" align="center" id='tabella_10'>
					<?php 
					print ("<a href='nuovo_rm_spettroscopica.php?id_paziente=$id_paziente&id_rm_spettroscopica=$id_rm_spettroscopica&flag_query=1&start=2' target='_blank' >");
					?>
					<img src="images/view.png" width="16" alt="Show" title="Show" border="0"/>
					</td>
					<td width="5%" align="center" id='tabella_10'>
					<?php
					if ($permission == 3);
					else					
						print ("<a onClick=\"javascript:conferma('rm_spettroscopica', $id_paziente, $id_rm_spettroscopica, 1)\">");
					?>
					<img src="images/elimina.png" width="16" alt="Delete" title="Delete" border="0"/>
					</td>					
					<td width="80%" align="left" id='tabella_10'>
						<font id='font8'>RM Spectroscopy</font>
						<font face="Verdana, Arial, Helvetica, sans-serif" size='2' color="#FFFFCC">
						 - Recorderd in date  
						<?php  print $data_inserimento_rm_spettroscopica; ?>
						</font>
					</td>
					<td width="10%" align="left">
					</td>		
				</tr>
			<?php
			}
			?>	
			
			<!-- tabella RM BOLD ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
			<?php			
			for ($i=0; $i<$n_rm_bold; $i++)
			{			
				$id_rm_bold = $rm_bold->getID_array($i);
				$rm_bold -> retrive_by_id($id_rm_bold );

				$data_inserimento_rm_bold=$rm_bold ->getData_inserimento();
				$data_inserimento_rm_bold = data_convert_for_utente($data_inserimento_rm_bold);
			?>	
				<tr>
					<td width="5%" align="center" id='tabella_10'>
					<?php 
					print ("<a href='nuovo_rm_bold.php?id_paziente=$id_paziente&id_rm_bold=$id_rm_bold&flag_query=1&start=2' target='_blank' >");
					?>
					<img src="images/view.png" width="16" alt="Show" title="Show" border="0"/>
					</td>
					<td width="5%" align="center" id='tabella_10'>
					<?php
					if ($permission == 3);
					else					
						print ("<a onClick=\"javascript:conferma('rm_bold', $id_paziente, $id_rm_bold, 1)\">");
					?>
					<img src="images/elimina.png" width="16" alt="Delete" title="Delete" border="0"/>
					</td>						
					<td width="80%" align="left" id='tabella_10'>
						<font id='font8'>RM BOLD</font>
						<font face="Verdana, Arial, Helvetica, sans-serif" size='2' color="#FFFFCC">
						 - Recorderd in date 
						<?php  print $data_inserimento_rm_bold; ?>
						</font>
					</td>
					<td width="10%" align="left">
					</td>		
				</tr>
			<?php
			}
			?>	
			
			<!-- tabella RM DTI ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
			<?php			
			for ($i=0; $i<$n_rm_dti; $i++)
			{	
				$id_rm_dti = $rm_dti->getID_array($i);
				$rm_dti -> retrive_by_id($id_rm_dti);
				
				$data_inserimento_rm_dti=$rm_dti ->getData_inserimento();
				$data_inserimento_rm_dti = data_convert_for_utente($data_inserimento_rm_dti);		
			?>	
				<tr>
					<td width="5%" align="center" id='tabella_10'>
					<?php 
					print ("<a href='nuovo_rm_dti.php?id_paziente=$id_paziente&id_rm_dti=$id_rm_dti&flag_query=1&start=2' target='_blank' >");
					?>
					<img src="images/view.png" width="16" alt="Show" title="Show" border="0"/>
					</td>
					<td width="5%" align="center" id='tabella_10'>
					<?php
					if ($permission == 3);
					else					
						print ("<a onClick=\"javascript:conferma('rm_dti', $id_paziente, $id_rm_dti, 1)\">");
					?>
					<img src="images/elimina.png" width="16" alt="Delete" title="Delete" border="0"/>
					</td>					
					<td width="80%" align="left" id='tabella_10'>
						<font id='font8'>RM DTI</font>
						<font face="Verdana, Arial, Helvetica, sans-serif" size='2' color="#FFFFCC">
						 - Recorderd in date  
						<?php  print $data_inserimento_rm_dti; ?>
						</font>
					</td>
					<td width="10%" align="left">
					</td>		
				</tr>
			<?php
			}
			?>	
			
			<!-- tabella PERMEABILITA' ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
			<?php			
			for ($i=0; $i<$n_permeabilita; $i++)
			{	
				$id_permeabilita = $permeabilita->getID_array($i);
				$permeabilita -> retrive_by_id($id_permeabilita);
				
				$data_inserimento_permeabilita=$permeabilita ->getData_inserimento();
				$data_inserimento_permeabilita = data_convert_for_utente($data_inserimento_permeabilita);		
			?>	
				<tr>
					<td width="5%" align="center" id='tabella_10'>
					<?php 
					print ("<a href='nuovo_permeabilita.php?id_paziente=$id_paziente&id_permeabilita=$id_permeabilita&flag_query=1&start=2' target='_blank' >");
					?>
					<img src="images/view.png" width="16" alt="Show" title="Show" border="0"/>
					</td>
					<td width="5%" align="center" id='tabella_10'>
					<?php
					if ($permission == 3);
					else					
						print ("<a onClick=\"javascript:conferma('permeabilita', $id_paziente, $id_permeabilita, 1)\">");
					?>
					<img src="images/elimina.png" width="16" alt="Delete" title="Delete" border="0"/>
					</td>					
					<td width="80%" align="left" id='tabella_10'>
						<font id='font8'>RM permeability</font>
						<font face="Verdana, Arial, Helvetica, sans-serif" size='2' color="#FFFFCC">
						 - Recorderd in date  
						<?php  print $data_inserimento_permeabilita; ?>
						</font>
					</td>
					<td width="10%" align="left">
					</td>		
				</tr>
			<?php
			}
			?>							
			</table>
			<!-- tabella inserisci nuovo imaging +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
			<form action="query_paziente_generale.php" method="post" style='display:inline'>	
			<table border="0" width="100%">
			<tr>
				<td width="5%" align="center" id='tabella_10'>
				<img src="images/new.png" />
				</td>
				<td width="85%" align="left" id='tabella_10'><font id='font8'>&nbsp; &nbsp; Insert</font> &nbsp; &nbsp;
				<select name='nuovo_imaging' size='1' cols='10' id="form1">
				<OPTION VALUE='-'> - </OPTION>			
				<OPTION VALUE='esame_tc'>TC scan</OPTION>
				<OPTION VALUE='rm_morfologica'>Morphological MR</OPTION>	
				<OPTION VALUE='rm_perfusione'>Perfusion MR</OPTION>	
				<OPTION VALUE='rm_spettroscopica'>Spectorscopy MR</OPTION>
				<OPTION VALUE='rm_bold'>RM BOLD</OPTION>		
				<OPTION VALUE='rm_dti'>RM DTI</OPTION>	
				<OPTION VALUE='rm_permeabilita'>RM Permeability</OPTION>			
				</select>
				&nbsp; &nbsp;
				<?php
				if ($permission == 3);
				else
					print("<input type='submit' name='new_imaging' value=' OK ' />");
				?>
				<input type="hidden" name='id' value='<?php print $id_paziente; ?>' />
				<input type="hidden" name='carica' value='1' />
				</td>
				<td width="10%" align="left">
				</td>		
			</tr>		
			</table>					
			</form>
		<!-- fine tabella dati Imaging ***************************************************************************************** -->

		<br />
	
		<!-- tabella Intervento ********************************************************************************************* -->
		<table border="0" width="100%">
			<tr>
				<td width="40%" align="left" bgcolor="#AAB3D1">
				<font face="Verdana, Arial, Helvetica, sans-serif" color="#000066" size="3">
				Medical Surgery
				</font>
				</td>	
				<td width="60%" align="left">
				</td>		
			</tr>
		</table>
		
		<table border="0" width="100%">
			<?php
			for ($i=0; $i<$n_intervento; $i++)
			{
				$id_intervento = $intervento->getID_array($i);
				$intervento -> retrive_by_id($id_intervento);
			
				$data_inserimento_intervento=$intervento ->getData_inserimento();
				$data_inserimento_intervento = data_convert_for_utente($data_inserimento_intervento);			
			?>	
			<tr>
				<td width="5%" align="center" id='tabella_10'>
				<?php 
				print ("<a href='intervento.php?id_paziente=$id_paziente&id_intervento=$id_intervento&start=2' target='_blank' >");
				?>
				<img src="images/view.png" width="16" alt="Show" title="Show" border="0"/>
				</td>
				<td width="5%" align="center" id='tabella_10'>
					<?php
					if ($permission == 3);
					else					
						print ("<a onClick=\"javascript:conferma('intervento', $id_paziente, $id_intervento, 1)\">");
					?>
					<img src="images/elimina.png" width="16" alt="Delete" title="Delete" border="0"/>
				</td>					
				<td width="80%" align="left" id='tabella_10'>
					<font id='font8'>Medical Surgery</font>
					<font face="Verdana, Arial, Helvetica, sans-serif" size='2' color="#FFFFCC">
					- Date of last changed:
					<?php print $data_inserimento_intervento; ?>
					</font>
				</td>
				<td width="10%" align="left">
				</td>		
			</tr>
			<?php
			}
			?>
			<tr>
				<td width="5%" align="center" id='tabella_10'>
				<?php 
					if ($permission == 3);
					else				
						print ("<a href='intervento.php?id_paziente=$id_paziente&start=1' target='_blank' >");
				?>
				<img src="images/new.png" alt="New" title="New" border="0"/>
				</a>
				</td>
				<td width="5%" align="left" id='tabella_10'></td>
				<td width="80%" align="left" id='tabella_10'>
					<font id='font8'>Insert new Medical Surgery</font>
				</td>
				<td width="10%" align="left">
				</td>		
			</tr>		
		</table>
		<!-- fine tabella Intervento ***************************************************************************************** -->

		<br />
	
		<!-- tabella diagnosi istologica ********************************************************************************************* -->
		<table border="0" width="100%">
			<tr>
				<td width="40%" align="left" bgcolor="#AAB3D1">
				<font face="Verdana, Arial, Helvetica, sans-serif" color="#000066" size="3">
				Histological diagnosis
				</font>
				</td>	
				<td width="60%" align="left">
				</td>		
			</tr>
		</table>
		
		<table border="0" width="100%">
		<?php // Inserire tutta la parte per vedere quanti interventi ci sono. ?>	
			<?php
			for ($i=0; $i<$n_istologia; $i++)
			{
				$id_istologia = $istologia->getID_array($i);
				$istologia -> retrive_by_id($id_istologia);
			
				$data_inserimento_istologia=$istologia ->getData_risultato();
				$data_inserimento_istologia = data_convert_for_utente($data_inserimento_istologia);		
			?>	
			<tr>
				<td width="5%" align="center" id='tabella_10'>
				<?php 
				print ("<a href='see_istologia.php?id_paziente=$id_paziente&id_istologia=$id_istologia' target='_blank' >");
				?>
				<img src="images/view.png" width="16" alt="Show" title="Show" border="0"/>
				</td>
				<td width="5%" align="center" id='tabella_10'>
					<?php
					if ($permission == 3);
					else					
						print ("<a onClick=\"javascript:conferma('istologia', $id_paziente, $id_istologia, 1)\">");
					?>
					<img src="images/elimina.png" width="16" alt="Delete" title="Delete" border="0"/>
				</td>					
				<td width="80%" align="left" id='tabella_10'>
					<font id='font8'>Histology</font>
					<font face="Verdana, Arial, Helvetica, sans-serif" size='2' color="#FFFFCC">
					- Date of result:
					<?php print $data_inserimento_istologia; ?>
					</font>
				</td>
				<td width="10%" align="left">
				</td>		
			</tr>
			<?php
			}
			?>		
			<tr>
				<td width="5%" align="center" id='tabella_10'>
				<?php
					if ($permission == 3);
					else
						print ("<a href='istologia.php?start=1&id_paziente=$id_paziente' target='_blank' >");
				?>
				
				<img src="images/new.png" alt="New" title="New" border="0"/>
				</a>
				</td>
				<td width="5%" align="center" id='tabella_10'></td>
				<td width="80%" align="left" id='tabella_10'>
					<font id='font8'>Insert new Histological diagnosis</font>
				</td>
				<td width="10%" align="left">
				</td>		
			</tr>		
		</table>
		<!-- fine tabella diagnosi istologica ***************************************************************************************** -->

		<br />

		<!-- tabella Terapia ********************************************************************************************* -->
		<table border="0" width="100%">
			<tr>
				<td width="40%" align="left" bgcolor="#AAB3D1">
				<font face="Verdana, Arial, Helvetica, sans-serif" color="#000066" size="3">
				Medical Therapy
				</font>
				</td>	
				<td width="60%" align="left">
				</td>		
			</tr>
		</table>
		
		<table border="0" width="100%">
		<!-- TABELLE VISUALIZZAZIONE TERAPIA ------------------------------------------------------------------------- -->
		<?php
			for ($i=0; $i<$n_terapia; $i++)
			{
				$id_terapia = $terapia->getID_array($i);
			
				// deve recuperare i valori di RT-conformazionale e Radiochirurgia:
				$terapia -> retrive_by_id($id_terapia);
							
				// RT_CONFORMAZIONALE ************************************************************
				if (($terapia -> getRt_conformazionale()) == 'on')
				{
					print ("
							<tr>
								<td width='5%' align='center' id='tabella_10'> </td>
								<td width='5%' align='center' id='tabella_10'>");
								
								if ($permission == 3);
								else
									print ("<a onClick=\"javascript:conferma('rt_conformazionale', $id_paziente, $id_terapia, 1)\">");
									
								print("<img src='images/elimina.png' width='16' alt='Delete' title='Delete' border='0'/>");
								print ("
								</td>				
								<td width='80%' align='left' id='tabella_10'>
									<font id='font8'>Conformational radiation therapy</font>
									<font face='Verdana, Arial, Helvetica, sans-serif' size='2' color='#FFFFCC'>
									- Data inizio: 
							");
						print data_convert_for_utente($terapia -> getData_rt_conformazionale());		
						print ("
								</font>
								</td>
								<td width='10%' align='left'></td>		
								</tr>
							");
				}
				
				// RADIOTERAPIA ************************************************************
				if (($terapia -> getRadiochirurgia()) == 'on')
				{
					print ("
							<tr>
								<td width='5%' align='center' id='tabella_10'> </td>
								<td width='5%' align='center' id='tabella_10'>");
								
								if ($permission == 3);
								else								
									print ("<a onClick=\"javascript:conferma('radiochirurgia', $id_paziente, $id_terapia, 1)\">");
								
								print("<img src='images/elimina.png' width='16' alt='Delete' title='Delete' border='0'/>
								</td>
																
								<td width='80%' align='left' id='tabella_10'>
									<font id='font8'>Radiosurgery</font>
									<font face='Verdana, Arial, Helvetica, sans-serif' size='2' color='#FFFFCC'>
									- Date: 
							");
						print data_convert_for_utente($terapia -> getData_radiochirurgia());		
						print ("
								</font>
								</td>
								<td width='10%' align='left'></td>		
								</tr>
							");
				}
			}	
			?>
			
			<!-- TABELLE VISUALIZZAZIONE CHEMIOTERAPIA ---------------------------------------------------------------------- -->
			
		<?php
			for ($i=0; $i<$n_chemioterapia; $i++)
			{
				$id_chemioterapia= $chemioterapia->getID_array($i);
			
				// deve recuperare i valori di RT-conformazionale e Radiochirurgia:
				$chemioterapia -> retrive_by_id($id_chemioterapia);
							
				// TEMOZOLOMIDE ************************************************************
				if (($chemioterapia -> getTemozolomide()) == 'on')
				{
					print ("
							<tr>
								<td width='5%' align='center' id='tabella_10'> </td>
								<td width='5%' align='center' id='tabella_10'>");
								
								if ($permission == 3);
								else	
									print ("<a onClick=\"javascript:conferma('temozolomide', $id_paziente, $id_chemioterapia, 1)\">");
									
								print ("<img src='images/elimina.png' width='16' alt='Delete' title='Delete' border='0'/>
								</td>								
								
								<td width='80%' align='left' id='tabella_10'>
									<font id='font8'>Temozolomide</font>
									<font face='Verdana, Arial, Helvetica, sans-serif' size='2' color='#FFFFCC'>
									- Date: 
							");
						print data_convert_for_utente($chemioterapia -> getData_temozolomide());		
						print (" - Cycles: "); 
						print $chemioterapia -> getCicli_temozolomide();			
						print ("
								</font>
								</td>
								<td width='10%' align='left'></td>		
								</tr>
							");
				}

				// PC (V) ************************************************************
				if (($chemioterapia -> getPc_v()) == 'on')
				{
					print ("
							<tr>
								<td width='5%' align='center' id='tabella_10'> </td>
								<td width='5%' align='center' id='tabella_10'>");
								
								if ($permission == 3);
								else
									print ("<a onClick=\"javascript:conferma('pc_v', $id_paziente, $id_chemioterapia, 1)\">");
								
								print("<img src='images/elimina.png' width='16' alt='Delete' title='Delete' border='0'/>
								</td>
																
								<td width='80%' align='left' id='tabella_10'>
									<font id='font8'>PC (V)</font>
									<font face='Verdana, Arial, Helvetica, sans-serif' size='2' color='#FFFFCC'>
									- Date: 
							");
						print data_convert_for_utente($chemioterapia -> getData_pc_v());		
						print (" - Cycles: "); 
						print $chemioterapia -> getCicli_pc_v();			
						print ("
								</font>
								</td>
								<td width='10%' align='left'></td>		
								</tr>
							");
				}				

				// FOTEMUSTINA ************************************************************
				if (($chemioterapia -> getFotemustina()) == 'on')
				{
					print ("
							<tr>
								<td width='5%' align='center' id='tabella_10'> </td>
								<td width='5%' align='center' id='tabella_10'>");
								
								if ($permission == 3);
								else
									print ("<a onClick=\"javascript:conferma('fotemustina', $id_paziente, $id_chemioterapia, 1)\">");
									
								print ("<img src='images/elimina.png' width='16' alt='Delete' title='Delete' border='0'/>
								</td>								
								
								<td width='80%' align='left' id='tabella_10'>
									<font id='font8'>Fotemustina - Bevacizumab</font>
									<font face='Verdana, Arial, Helvetica, sans-serif' size='2' color='#FFFFCC'>
									- Data inizio: 
							");
						print data_convert_for_utente($chemioterapia -> getData_fotemustina());		
						print (" - Cycles: "); 
						print $chemioterapia -> getCicli_fotemustina();			
						print ("
								</font>
								</td>
								<td width='10%' align='left'></td>		
								</tr>
							");
				}

				// ALTRO ************************************************************
				if (($chemioterapia -> getAltro()) != NULL)
				{
					print ("
							<tr>
								<td width='5%' align='center' id='tabella_10'> </td>
								<td width='5%' align='center' id='tabella_10'>");
								
								if ($permission == 3);
								else
									print ("<a onClick=\"javascript:conferma('altro', $id_paziente, $id_chemioterapia, 1)\">");
								
								print ("<img src='images/elimina.png' width='16' alt='Delete' title='Delete' border='0'/>
								</td>								
									
								<td width='80%' align='left' id='tabella_10'>
									<font id='font8'>
							");
							print $chemioterapia -> getAltro();
							print("		
									</font>
									<font face='Verdana, Arial, Helvetica, sans-serif' size='2' color='#FFFFCC'>
									- Date: 
							");
						print data_convert_for_utente($chemioterapia -> getData_altro());		
						print ("
								</font>
								</td>
								<td width='10%' align='left'></td>		
								</tr>
							");
				}
				
				// TERAPIA SUPPORTO ************************************************************
				if (($chemioterapia -> getTerapia_supporto()) != NULL)
				{
					print ("
							<tr>
								<td width='5%' align='center' id='tabella_10'> </td>
								<td width='5%' align='center' id='tabella_10'>");
								
								if ($permission == 3);
								else
									print ("<a onClick=\"javascript:conferma('terapia_supporto', $id_paziente, $id_chemioterapia, 1)\">");
									
								print ("<img src='images/elimina.png' width='16' alt='Delete' title='Delete' border='0'/>
								</td>									
								
								<td width='80%' align='left' id='tabella_10'>
									<font id='font8'>Supportive Therapy: 
							");
							print $chemioterapia -> getTerapia_supporto();
							print("		
									</font>
									<font face='Verdana, Arial, Helvetica, sans-serif' size='2' color='#FFFFCC'>
									- Data inizio: 
							");
						print data_convert_for_utente($chemioterapia -> getData_terapia_supporto());		
						print ("
								</font>
								</td>
								<td width='10%' align='left'></td>		
								</tr>
							");
				}
				
			}	
			?>			

			<tr>
				<td width="5%" align="center" id='tabella_10'>
				<?php
				if ($permission == 3);
				else
					print ("<a href='terapia.php?id_paziente=$id_paziente' target='_blank' >");
				?>
				
				<img src="images/new.png" alt='New' title='New' border='0'/>
				</a>
				</td>
				<td width="5%" align="center" id='tabella_10'></td>
				<td width="80%" align="left" id='tabella_10'>
					<font id='font8'>Insert a Medical Therapy</font>
				</td>
				<td width="10%" align="left">
				</td>		
			</tr>		
		</table>
		<!-- fine tabella terapia ***************************************************************************************** -->

	</td>
	<td width="10%" align="left">
	</td>
</tr>
</table>
<br /><br />

	<table border="0" width="90%">
		<tr>
			<td width="30%" align="center">
			<?php
				if ($ricerca == 1)
				{
					print("
					<form action='visualizza_ricerca.php'>
					<input type='submit' name='aggiorna' value='RETURN' id='form2_3'/>		
					</form>
					");
				}
			?>
			</td>
			<td width="30%" align="center">
				<form action="query_paziente_generale.php" method="post">
				<input type="submit" name='ritorno' value='UPDATE THIS PAGE' id='form2_3'/>
				<input type="hidden" name='id' value='<?php print $id_paziente; ?>'  />
				<input type="hidden" name='ricerca' value='<?php print $ricerca; ?>'  />
				</form>
			</td>
			<td width="40%" align="center">
				
			</td>
		</tr>
	</table>
	
	<br />
</div>

</body>
</html>