<?php
 // Script che permette la registrazione delle attività su un file LOG

// IP del computer:
$host_ingresso2 = $_SERVER['REMOTE_ADDR'];
// Data e ora:
$data2= date ("d-m-Y");
$data3= date ("d-m-Y H:i:s");
// Username e Nominativo:
$username = $_SESSION['username'];

// crea il percorso: il file viene salvato nella cartella /ricerche
$nome_file1 = "LOG_".$data2."_".$host_ingresso2."_".$username.".txt";
$percorso_log = 'log_entrate\\'.$nome_file1;

// apre il file di testo:
$file = fopen($percorso_log,"a+");


if ($pagina == 1)
	fwrite($file, "\nDATE: $data3; USER: $username; ** ENTER: home.php \n"); 	
if ($pagina == 2)
	fwrite($file, "\nDATE: $data3; USER: $username; ** PAGINA NEW PATIENT: new_patient.php \n"); 
if ($pagina == 3)
	fwrite($file, "\nDATE: $data3; USER: $username; ** E' STATO INSERITO UN NUOVO PAZIENTE: id = $id_paziente \n"); 
if ($pagina == 4)
	fwrite($file, "\nDATE: $data3; USER: $username; ** E' STATA VISUALIZZATA UNA RICERCA \n"); 
if ($pagina == 5)
	fwrite($file, "\nDATE: $data3; USER: $username; ** ACCESSO AL MENU' DI AMMINISTRAZIONE \n"); 
if ($pagina == 6)
	fwrite($file, "\nDATE: $data3; USER: $username; ** E' STATO INSERITO UN NUOVO UTENTE: username : $new_username  \n"); 	
if ($pagina == 7)
	fwrite($file, "\nDATE: $data3; USER: $username; ** E' STATO ELIMINATO UN UTENTE: id = $id_utente \n"); 	
if ($pagina == 8)
	fwrite($file, "\nDATE: $data3; USER: $username; ** E' STATO MODIFICATO UN UTENTE: id = $id_utente \n");	
if ($pagina == 9)
	fwrite($file, "\nDATE: $data3; USER: $username; ** E' STATO VISUALIZZATO IL SEGUENTE PAZIENTE: id = $id_paziente \n");		
if ($pagina == 10)
	fwrite($file, "\nDATE: $data3; USER: $username; ** E' STATO ELIMINATO UN ESAME DELLA TABELLA: $nome_tabella	CON ID = $id_esame - PER IL PAZIENTE ID = $id_paziente \n");		
if ($pagina == 11)
	fwrite($file, "\nDATE: $data3; USER: $username; ** E' STATO ELIMINATO UN PAZIENTE E TUTTI I SUOI ESAMI (ID = $id_paziente)\n");		
if ($pagina == 12)
	fwrite($file, "\nDATE: $data3; USER: $username; ** SONO STATI MODIFICATI I DATI ANAGRAFICI DI UN PAZIENTE (ID = $id_paziente)\n");			
if ($pagina == 13)
	fwrite($file, "\nDATE: $data3; USER: $username; ** SONO STATI MODIFICATI I SINTOMI (ID = $id_sintomi) DI UN PAZIENTE (ID = $id_paziente)\n");	
if ($pagina == 14)
	fwrite($file, "\nDATE: $data3; USER: $username; ** SONO STATI MODIFICATI I DATI DELL'ESAME TC (ID = $id_esame_tc) DI UN PAZIENTE (ID = $id_paziente)\n");	
if ($pagina == 15)
	fwrite($file, "\nDATE: $data3; USER: $username; ** E' STATO INSERITO UN NUOVO ESAME TC PER IL PAZIENTE (ID = $id_paziente) CHE HA COME DATA $data_inserimento_esame_tc\n");	
if ($pagina == 16)
	fwrite($file, "\nDATE: $data3; USER: $username; ** E' STATO INSERITA UNA NUOVA MORFOLOGICA PER IL PAZIENTE (ID = $id_paziente) CHE HA COME DATA $data_inserimento_rm_morfologica\n");	
if ($pagina == 17)
	fwrite($file, "\nDATE: $data3; USER: $username; ** SONO STATI MODIFICATI I DATI DI UNA MORFOLOGICA (ID = $id_rm_morfologica) DI UN PAZIENTE (ID = $id_paziente)\n");
if ($pagina == 18)
	fwrite($file, "\nDATE: $data3; USER: $username; ** E' STATO INSERITA UNA NUOVA SPETTROSCOPIA PER IL PAZIENTE (ID = $id_paziente) CHE HA COME DATA $data_inserimento_rm_spettroscopica\n");
if ($pagina == 19)
	fwrite($file, "\nDATE: $data3; USER: $username; ** SONO STATI MODIFICATI I DATI DI UNA SPETTROSCOPIA (ID = $id_rm_spettroscopica) DI UN PAZIENTE (ID = $id_paziente)\n");
if ($pagina == 20)
	fwrite($file, "\nDATE: $data3; USER: $username; ** E' STATO INSERITA UNA NUOVA RM BOLD PER IL PAZIENTE (ID = $id_paziente) CHE HA COME DATA $data_inserimento_rm_bold \n");
if ($pagina == 21)
	fwrite($file, "\nDATE: $data3; USER: $username; ** SONO STATI MODIFICATI I DATI DI UNA RM BOLD (ID = $id_rm_bold) DI UN PAZIENTE (ID = $id_paziente)\n");
if ($pagina == 22)
	fwrite($file, "\nDATE: $data3; USER: $username; ** E' STATO INSERITA UNA NUOVA RM DTI PER IL PAZIENTE (ID = $id_paziente) CHE HA COME DATA $data_inserimento_rm_dti \n");
if ($pagina == 23)
	fwrite($file, "\nDATE: $data3; USER: $username; ** SONO STATI MODIFICATI I DATI DI UNA RM DTI (ID = $id_rm_dti) DI UN PAZIENTE (ID = $id_paziente)\n");
if ($pagina == 24)
	fwrite($file, "\nDATE: $data3; USER: $username; ** E' STATO INSERITA UNA NUOVA RM PERMEABILITA' PER IL PAZIENTE (ID = $id_paziente) CHE HA COME DATA $data_inserimento \n");
if ($pagina == 25)
	fwrite($file, "\nDATE: $data3; USER: $username; ** SONO STATI MODIFICATI I DATI DI UNA RM PERMEABILITA (ID = $id_permeabilita) DI UN PAZIENTE (ID = $id_paziente)\n");
if ($pagina == 26)
	fwrite($file, "\nDATE: $data3; USER: $username; ** E' STATO INSERITO UN NUOVO INTERVENTO PER IL PAZIENTE (ID = $id_paziente) CHE HA COME DATA $data_inserimento_intervento \n");
if ($pagina == 27)
	fwrite($file, "\nDATE: $data3; USER: $username; ** E' STATO MODIFICATO UN INTEVRVENTO (ID = $id_intervento) DI UN PAZIENTE (ID = $id_paziente)\n");
if ($pagina == 28)
	fwrite($file, "\nDATE: $data3; USER: $username; ** E' STATA INSERITA UNA NUOVA ISTOLOGIA PER IL PAZIENTE (ID = $id_paziente) CHE HA COME DATA $data_risultato \n");
if ($pagina == 29)
	fwrite($file, "\nDATE: $data3; USER: $username; ** E' STATA MODIFICATA UNA NUOVA ISTOLOGIA (ID = $id_istologia) DI UN PAZIENTE (ID = $id_paziente)\n");
if ($pagina == 30)
	fwrite($file, "\nDATE: $data3; USER: $username; ** E' STATA INSERITA UNA NUOVA TERAPIA PER IL PAZIENTE (ID = $id_paziente) \n");
if ($pagina == 31)
	fwrite($file, "\nDATE: $data3; USER: $username; ** SONO STATE VISUALIZZATE DELLE STATISTICHE PER LA TABELLA: $nome_tabella\n");
if ($pagina == 32)
	fwrite($file, "\nDATE: $data3; USER: $username; ** USO DEL TUMORS ENGINE: $nome_tabella\n");






?>