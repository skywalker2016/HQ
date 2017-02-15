<?php
// Script per i nominativi per RM Perfusione **************************************************

function nomi_rm_perfusione($nome)
{
	if ( ($nome == 'id') || ($nome == 'id_paziente') );

	else if ( $nome == 'data_inserimento') 	
		return ('Date of exam');
	else if ( $nome == 'r_cbv') 	
		return ('r-CBV');
	else if ( $nome == 'valore_r_cbv') 	
		return ('Value of r-CBV');
	else
		return ucfirst($nome);
}
?>