<?php
// Script per i nominativi per esame TC **************************************************

function nomi_esame_tc($nome)
{
	if ( ($nome == 'id') || ($nome == 'id_paziente') );

	else if ( $nome == 'tipo_contrasto') 	
		return ('Kind of contrast');
	else if ( $nome == 'data_inserimento') 	
		return ('Insertion date');	
	else if ( $nome == 'extrassiale') 	
		return ('Extra axial');	
	else if ( $nome == 'intrassiale') 	
		return ('Intra axial');
	else if ( $nome == 'dubbia') 	
		return ('Doubtfu');
	else if ( $nome == 'contrasto') 	
		return ('Contrast Enhancement');
	else if ( $nome == 'sede') 	
		return ('Site');
	else
		return ucfirst($nome);
}
?>