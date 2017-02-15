<?php
// Script per i nominativi per RM BOLD **************************************************

function nomi_rm_bold($nome)
{
	if ( ($nome == 'id') || ($nome == 'id_paziente') );

	else if ( $nome == 'data_inserimento') 	
		return ('Insertion date');
	else if ( $nome == 'motorio_sede') 	
		return ('Site Motor Test');
	else if ( $nome == 'motorio_posteriore') 	
		return ('Motor - Rearward');
	else if ( $nome == 'motorio_anteriore') 	
		return ('Motor - Frontal');
	else if ( $nome == 'motorio_mediale') 	
		return ('Motor - Medial');
	else if ( $nome == 'motorio_intralesionale') 	
		return ('Motor - Intralesional');
	else if ( $nome == 'motorio_laterale') 	
		return ('Motor - Lateral');
	else if ( $nome == 'motorio_inferiore') 	
		return ('Motor - Lower');
	else if ( $nome == 'motorio_superiore') 	
		return ('Motor - Upper');
	else if ( $nome == 'motorio_altro') 	
		return ('Motor - Other');
	
	else if ( $nome == 'sensitiva_sede') 	
		return ('Site Sensory Test');
	else if ( $nome == 'sensitiva_posteriore') 	
		return ('Sensory - Rearward');
	else if ( $nome == 'sensitiva_anteriore') 	
		return ('Sensory - Frontal');
	else if ( $nome == 'sensitiva_mediale') 	
		return ('Sensory - Medial');
	else if ( $nome == 'sensitiva_intralesionale') 	
		return ('Sensory - Intralesional');
	else if ( $nome == 'sensitiva_laterale') 	
		return ('Sensory - Lateral');
	else if ( $nome == 'sensitiva_inferiore') 	
		return ('Sensory - Lower');
	else if ( $nome == 'sensitiva_superiore') 	
		return ('Sensory - Upper');
	else if ( $nome == 'sensitiva_altro') 	
		return ('Sensory - Other');
	else if ( $nome == 'linguaggio_broca') 	
		return ('Broca Activation');
	else if ( $nome == 'linguaggio_wernicke') 	
		return ('Wernicke Activation');
	else
		return ucfirst($nome);
}
?>