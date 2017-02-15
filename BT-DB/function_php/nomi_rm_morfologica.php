<?php
// Script per i nominativi per RM Morfologica **************************************************

function nomi_rm_morfologica($nome)
{
	if ( ($nome == 'id') || ($nome == 'id_paziente') );

	else if ( $nome == 'data_inserimento') 	
		return ('Date of exam');
	else if ( $nome == 't2_flair') 	
		return ('T2 FLAIR');
	else if ( $nome == 'flair_3d') 	
		return ('FLAIR 3D');
	else if ( $nome == 'volume_neo') 	
		return ('Volume NEO');
	else if ( $nome == 'dwi') 	
		return ('DWI');
	else if ( $nome == 'dwi_ristretta') 	
		return ('DWI restricted');
	else if ( $nome == 'adc') 	
		return ('ADC');
	else if ( $nome == 'tipo_adc') 	
		return ('Kind of ADC');
	else if ( $nome == 'valore_adc') 	
		return ('Value of ADC');
	else if ( $nome == 'ce') 	
		return ('CE');
	else if ( $nome == 'tipo_ce') 	
		return ('Kind of CE');
	else
		return ucfirst($nome);
}
?>