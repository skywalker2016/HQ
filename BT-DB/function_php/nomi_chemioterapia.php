<?php
// Script per i nominativi della chemioterapia **************************************************

function nomi_chemioterapia($nome)
{
	if ( ($nome == 'id') || ($nome == 'id_paziente') );

	else if ( $nome == 'data_temozolomide') 	
		return ('Date begin temozolomide');
	else if ( $nome == 'cicli_temozolomide') 	
		return ('Number cycles temozolomide');
	else if ( $nome == 'pc_v') 	
		return ('PC(V)');		
	else if ( $nome == 'data_pc_v') 	
		return ('Date begin PC(V)');
	else if ( $nome == 'cicli_pc_v') 	
		return ('Number cycles PC(V)');
	else if ( $nome == 'data_fotemustina') 	
		return ('Date begin fotemustina');
	else if ( $nome == 'cicli_fotemustina') 	
		return ('Number cycles fotemustina');
	else if ( $nome == 'altro') 	
		return ('Other');
	else if ( $nome == 'data_altro') 	
		return ('Data Other');
	else if ( $nome == 'terapia_supporto') 	
		return ('Supportive Therapy');
	else if ( $nome == 'data_terapia_supporto') 	
		return ('Date of Supportive Therapy');
	else
		return ucfirst($nome);
}
?>