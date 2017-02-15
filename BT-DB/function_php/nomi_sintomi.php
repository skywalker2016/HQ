<?php
// Script per i nominativi per sintomi **************************************************

function nomi_sintomi($nome)
{
	if ( ($nome == 'id') || ($nome == 'id_paziente') );

	else if ( $nome == 'data_inserimento') 	
		return ('Insertion date');
	else if ( $nome == 'data_sintomi') 	
		return ('Date of first clinical sign');
	else if ( $nome == 'crisi_epilettica') 	
		return ('Epilepsy');
	else if ( $nome == 'disturbi_comportamento') 	
		return ('Behavioral disorder');
	else if ( $nome == 'deficit_motorio') 	
		return ('Motor deficit');
	else if ( $nome == 'deficit') 	
		return ('Sensory deficit');	
	else if ( $nome == 'cefalea') 	
		return ('Headache');		
	else if ( $nome == 'altro') 	
		return ('Other');	
	  
	else
		return ucfirst($nome);
}
?>