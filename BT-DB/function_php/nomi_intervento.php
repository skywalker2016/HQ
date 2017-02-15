<?php
// Script per i nominativi per intervento **************************************************

function nomi_intervento($nome)
{
	if ( ($nome == 'id') || ($nome == 'id_paziente') );

	else if ( $nome == 'data_biopsia') 	
		return ('Date of Biopsy');
	else if ( $nome == 'resezione_totale') 	
		return ('Total tumor resection');
	else if ( $nome == 'data_resezione_totale') 	
		return ('Date Total tumor resection ');
	else if ( $nome == 'resezione_parziale') 	
		return ('Partial tumor resection');
	else if ( $nome == 'data_resezione_parziale') 	
		return ('Date Partial tumor resection');
	else if ( $nome == 'resezione_gliadel') 	
		return ('GLIADEL');
	else if ( $nome == 'data_resezione_gliadel') 	
		return ('Date of GLIADEL');
	else if ( $nome == 'data_inserimento') 	
		return ('Insertion date');		
	else if ( $nome == 'biopsia') 	
		return ('Biopsy');			
		
	else
		return ucfirst($nome);
}
?>