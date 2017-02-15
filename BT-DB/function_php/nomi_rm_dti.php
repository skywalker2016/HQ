<?php
// Script per i nominativi per RM DTI **************************************************

function nomi_rm_dti($nome)
{
	if ( ($nome == 'id') || ($nome == 'id_paziente') );

	else if ( $nome == 'data_inserimento') 	
		return ('Date of exam');
	else if ( $nome == 'valore_fa') 	
		return ('FA');
	else if ( $nome == 'cortico_spinale') 	
		return ('Corticospinal tract');	
	else if ( $nome == 'arcuato') 	
		return ('Fascicle Arcuate');		
	else if ( $nome == 'longitudinale_inferiore') 	
		return ('Superior Longitudinal Fascicle');	
	else if ( $nome == 'vie_ottiche') 	
		return ('Optic Pathway');		
	else
		return ucfirst($nome);
}
?>