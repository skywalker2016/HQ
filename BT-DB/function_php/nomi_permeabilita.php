<?php
// Script per i nominativi per Permeabilita **************************************************

function nomi_permeabilita($nome)
{
	if ( ($nome == 'id') || ($nome == 'id_paziente') );

	else if ( $nome == 'data_inserimento') 	
		return ('Insertion date');
	else if ( $nome == 'k_trans') 	
		return ('K trans');
	else if ( $nome == 'vi') 	
		return ('Vi');
	else
		return ucfirst($nome);
}
?>