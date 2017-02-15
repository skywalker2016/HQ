<?php
// Script per i nominativi per RM spettroscopica **************************************************

function nomi_rm_spettroscopica($nome)
{
	if ( ($nome == 'id') || ($nome == 'id_paziente') );

	else if ( $nome == 'data_inserimento') 	
		return ('Date of exam');
	else if ( $nome == 'te') 	
		return ('T.E.');
	else if ( $nome == 'tipo_spettro') 	
		return ('Kind of spectrum');
	else if ( $nome == 'naa_ridotto') 	
		return ('Naa reduced');
	else if ( $nome == 'valore_naa_ridotto') 	
		return ('Value of Naa reduced');	
	else if ( $nome == 'cho_cr') 	
		return ('Value Cho/Cr');
	else if ( $nome == 'lipidi_lattati') 	
		return ('Lipids / Lactates');
	else if ( $nome == 'mioinositolo') 	
		return ('Myo Inositol');
	else if ( $nome == 'valore_naa_cr') 	
		return ('Value of NAA / CR');	
	else
		return ucfirst($nome);
}
?>