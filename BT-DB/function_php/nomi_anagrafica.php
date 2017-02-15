<?php
// Script per i nominativi per Anagrafica **************************************************

function nomi_anagrafica($nome)
{
	if ( ($nome == 'id') || ($nome == 'id_paziente') );

	else if ( $nome == 'eta') 	
		return ('Age');
	else if ( $nome == 'data_decesso') 	
		return ('Date of death');
	else if ( $nome == 'reparto_provenienza') 	
		return ('Origin Department');
	else if ( $nome == 'sex') 	
		return ('Sex');
	else
		return ucfirst($nome);
}
?>