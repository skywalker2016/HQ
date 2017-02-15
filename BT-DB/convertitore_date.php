<?php
// funzione che controlla la data:
function controllo_data($data)
{
	// controlla che la lunghezza della data � di 10 caratteri
	$lunghezza = strlen($data);
	if ($lunghezza != 10)
		$errore = 1;
	elseif ($lunghezza == 10)
	{
		if (($data[2] == '/') && ($data[5] == '/'))
			$errore = 0;
		else
			$errore = 1;	
	}	

return ($errore);		
}

// funzione che converte la data da: gg/mm/aaaa in aaaa-mm-gg (per mysql)
function data_convert_for_mysql($data)
{
	for ($i=0; $i<10; $i++)   // Crea la variabili new_data e mette tutti i valori dell'array a 0
		$new_data[$i] = 0;      
	// recupera l'anno dalla fine dalla data e lo mette nelle posizioni iniziali.	
	$q=0;	
	for ($i=6; $i<10; $i++)
	{
		$new_data[$q] = $data[$i];
		$q = $q+1;
	}
	// recupera il mese.	
	$q=5;	
	for ($i=3; $i<5; $i++)
	{
		$new_data[$q] = $data[$i];
		$q = $q+1;
	}	
	// recupera il giorno.	
	$q=8;	
	for ($i=0; $i<3; $i++)
	{
		$new_data[$q] = $data[$i];
		$q = $q+1;
	}		
// Unisce l'array della nuova data in una unica variabile	
$data_convertita = $new_data[0] . $new_data[1] . $new_data[2] . $new_data[3] . "-" . $new_data[5] . $new_data[6] . "-" . $new_data[8] . $new_data[9];
return ($data_convertita);
}

function data_convert_for_utente($data)
{
	for ($i=0; $i<10; $i++)   // Crea la variabili new_data e mette tutti i valori dell'array a 0
		$new_data[$i] = 0;      	
	// recupera l'anno all'inizio dalla data e lo mette nelle posizioni finali.	
	$q=6;	
	for ($i=0; $i<4; $i++)
	{
		$new_data[$q] = $data[$i];
		$q = $q+1;
	}
	// recupera il mese.	
	$q=3;	
	for ($i=5; $i<7; $i++)
	{
		$new_data[$q] = $data[$i];
		$q = $q+1;
	}	
	// recupera il giorno.	
	$q=0;	
	for ($i=8; $i<10; $i++)
	{
		$new_data[$q] = $data[$i];
		$q = $q+1;
	}	
	
// Unisce l'array della nuova data in una unica variabile	
$data_convertita = $new_data[0] . $new_data[1] . "/" . $new_data[3] . $new_data[4] . "/" . $new_data[6] . $new_data[7] . $new_data[8] . $new_data[9];
return ($data_convertita);
}


?>