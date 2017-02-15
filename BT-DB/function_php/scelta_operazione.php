<?php
// Script per la scelta delle operazione nel motore di ricerca **************************************************

// reutrn(1) --> Tutte le operazioni
// reutrn(2) --> silime o diverso
// reutrn(3) --> =
// return(4) --> solo circa

function operazione($nome)
{

	if ($nome == 'data_inserimento')
		return (1);	

	// anagrafica ---------------------------
	if ($nome == 'eta')
		return (1);	
	if ($nome == 'data_decesso')
		return (1);	
	if ($nome == 'reparto_provenienza')
		return (3);		
	if ($nome == 'sex')
		return (3);	
		
	// chemioterapia -------------------------
	if ( ($nome == 'temozolomide') || ($nome == 'pc_v') || ($nome == 'fotemustina') )
		return (3);	
	if ( ($nome == 'data_temozolomide') || ($nome == 'data_pc_v') || ($nome == 'data_fotemustina') || ($nome == 'cicli_temozolomide') || ($nome == 'cicli_pc_v') || ($nome == 'cicli_fotemustina') || ($nome == 'data_altro') || ($nome == 'data_terapia_supporto'))
		return (1);	
	if ( ($nome == 'altro') || ($nome == 'terapia_supporto') )
		return (2);				
	
	// esame_TC -------------------------
	if ($nome == 'extrassiale')
		return (3);	
	if ($nome == 'intrassiale')
		return (3);	
	if ($nome == 'dubbia')
		return (3);	
	if ($nome == 'contrasto')
		return (3);	
	if ($nome == 'tipo_contrasto')
		return (3);		
	if ($nome == 'sede')
		return (3);	

	// Intervento -------------------------
	if ($nome == 'biopsia')
		return (3);	
	if ($nome == 'data_biopsia')
		return (1);	
	if ($nome == 'resezione_totale')
		return (3);	
	if ($nome == 'data_resezione_totale')
		return (1);	
	if ($nome == 'resezione_parziale')
		return (3);	
	if ($nome == 'data_resezione_parziale')
		return (1);	
	if ($nome == 'resezione_gliadel')
		return (3);	
	if ($nome == 'data_resezione_gliadel')
		return (1);	

	// istologia -------------------------
	if ($nome == 'data_risultato')
		return (1);	
	if ($nome == 'tumore')
		return (4);	
	if ($nome == 'note_tumore')
		return (4);	
	
	// Permeabilità -------------------------
	if ($nome == 'k_trans')
		return (1);	
	if ($nome == 'vi')
		return (1);	
	
	// RM BOLD -------------------------
	if ($nome == 'motorio_sede')
		return (3);	
	if ( ($nome == 'motorio_anteriore') || ($nome == 'motorio_posteriore') || ($nome == 'motorio_mediale') || ($nome == 'motorio_intralesionale') || ($nome == 'motorio_laterale') || ($nome == 'motorio_inferiore') || ($nome == 'motorio_superiore') )      
		return (3);	
	if ($nome == 'motorio_altro')
		return (2);	
	if ($nome == 'sensitiva_sede')
		return (2);	
	if ( ($nome == 'sensitiva_anteriore') || ($nome == 'sensitiva_posteriore') || ($nome == 'sensitiva_mediale') || ($nome == 'sensitiva_intralesionale') || ($nome == 'sensitiva_laterale') || ($nome == 'sensitiva_inferiore') || ($nome == 'sensitiva_superiore') )      
		return (3);	
	if ($nome == 'sensitiva_altro')
		return (2);			
	if ($nome == 'linguaggio_broca')
		return (3);		
	if ($nome == 'linguaggio_wernicke')
		return (3);		
	
	// DTI -------------------------
	if ($nome == 'valore_fa')
		return (1);	
	if ($nome == 'cortico_spinale')
		return (3);		
	if ($nome == 'arcuato')
		return (3);		
	if ($nome == 'longitudinale_inferiore')
		return (3);		
	if ($nome == 'vie_ottiche')
		return (3);	
	
	// Morfologica -------------------------
	if ($nome == 'extrassiale')
		return (3);	
	if ($nome == 'intrassiale')
		return (3);		
	if ($nome == 't2_flair')
		return (3);		
	if ($nome == 'flair_3d')
		return (3);		
	if ($nome == 'volume_neo')
		return (1);		
	if ($nome == 'dwi')
		return (3);		
	if ($nome == 'dwi_ristretta')
		return (3);		
	if ($nome == 'adc')
		return (3);	
	if ($nome == 'tipo_adc')
		return (3);			
	if ($nome == 'valore_adc')
		return (1);			
	if ($nome == 'ce')
		return (3);			
	if ($nome == 'tipo_ce')
		return (3);			
				
	// Perfusione -------------------------
	if ($nome == 'r_cbv')
		return (3);	
	if ($nome == 'valore_r_cbv')
		return (1);		
	
	// Spettroscopia -------------------------
	if ($nome == 'naa_ridotto')
		return (3);	
	if ($nome == 'valore_naa_cr')
		return (1);			
	if ($nome == 'cho_cr')
		return (1);		
	if ($nome == 'lipidi_lattati')
		return (3);		
	if ($nome == 'mioinositolo')
		return (3);		
	if ($nome == 'tipo_spettro')
		return (3);		
	if ($nome == 'te')
		return (3);		

	// Sintomi -------------------------
	if ($nome == 'deficit')
		return (3);	
	if ($nome == 'crisi_epilettica')
		return (3);	
	if ($nome == 'note')
		return (4);	
	if ($nome == 'disturbi_comportamento')
		return (3);	
	if ($nome == 'cefalea')
		return (3);	
	if ($nome == 'deficit_motorio')
		return (3);	
	if ($nome == 'data_sintomi')
		return (3);		
	
	// Terapia -------------------------
	if ($nome == 'rt_conformazionale')
		return (3);	
	if ($nome == 'data_rt_conformazionale')
		return (1);
	if ($nome == 'radiochirurgia')
		return (3);	
	if ($nome == 'data_radiochirurgia')
		return (1);	
	
}
?>