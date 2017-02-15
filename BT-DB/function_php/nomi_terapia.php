<?php
// Script per i nominativi per terapia **************************************************

function nomi_terapia($nome)
{
	if ( ($nome == 'id') || ($nome == 'id_paziente') );

	else if ( $nome == 'rt_conformazionale') 	
		return ('Conformational RT');
	else if ( $nome == 'data_rt_conformazionale') 	
		return ('Conformational RT Date');	
	else if ( $nome == 'radiochirurgia') 	
		return ('Radiosurgery');
	else if ( $nome == 'data_radiochirurgia') 	
		return ('Date of Radiosurgery');	
	
	else
		return ucfirst($nome);
}
?>