<?php
// Script per i nominativi per istologia **************************************************

function nomi_istologia($nome)
{
	if ( ($nome == 'id') || ($nome == 'id_paziente') );

	else if ( $nome == 'data_risultato') 	
		return ('Date of results');
	else if ( $nome == 'nome_tumore') 	
		return ('Tumor');
	else if ( $nome == 'note') 	
		return ('Note on the tumor');
	else
		return ucfirst($nome);
}
?>