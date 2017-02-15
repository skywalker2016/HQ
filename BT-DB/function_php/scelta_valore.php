<?php
// Script per la scelta del VALORE nel motore di ricerca **************************************************

// return (0) --> casella testo
// return (1) --> doppia casella testo (operazione TRA)
// return (2) --> reparto_provenienza
// return (3) --> SI / NO
// return (4) --> Tipo contrasto
// return (5) --> sede
// return (6) --> motorio sede
// return (7) --> sensitiva sede
// return (8) --> DWI
// return (9) --> ADC
// return (10) --> cbv
// return (11) --> TE
// return (12) --> Data sintomi
// return (13) -->DTI
// return (13) -->SESSO

function valore($nome, $operazione)
{
	if ($nome == 'data_inserimento')
	{
		if ($operazione == 'between')
			return (1);
		else
			return (0);
	}	


	// Anagrafica ------------------------------------
	if ( ($nome == 'eta') || ($nome == 'data_decesso') )
	{
		if ($operazione == 'between')
			return (1);
		else
			return (0);
	}	
	if ($nome == 'reparto_provenienza')
		return (2);
	if ($nome == 'sex')
		return (14);
		
	// Chemioterapia ------------------------------------
	if ( ($nome == 'temozolomide') || ($nome == 'pc_v') || ($nome == 'fotemustina') )	
			return (3);
	if ( ($nome == 'data_temozolomide') || ($nome == 'data_pc_v') || ($nome == 'data_fotemustina') )	
	{
		if ($operazione == 'between')
			return (1);
		else
			return (0);	
	}
	if ( ($nome == 'cicli_temozolomide') || ($nome == 'cicli_pc_v') || ($nome == 'cicli_fotemustina') )	
	{
		if ($operazione == 'between')
			return (1);
		else
			return (0);	
	}	
	if ( ($nome == 'altro') || ($nome == 'terapia_supporto') )	
			return (0);		
	if ( ($nome == 'data_altro') || ($nome == 'data_terapia_supporto') )	
	{
		if ($operazione == 'between')
			return (1);
		else
			return (0);	
	}
	
	
	// Esame TC ------------------------------------
	if ( ($nome == 'extrassiale') || ($nome == 'intrassiale') || ($nome == 'dubbia') || ($nome == 'contrasto') )	
			return (3);
	if ($nome == 'tipo_contrasto')	
			return (4);
	if ($nome == 'sede')	
			return (5);	
	
	
	// Intervento ------------------------------------	
	if ( ($nome == 'biopsia') || ($nome == 'resezione_totale') || ($nome == 'resezione_parziale') || ($nome == 'resezione_gliadel') )	
			return (3);	
	if ( ($nome == 'data_biopsia') || ($nome == 'data_resezione_totale') || ($nome == 'data_resezione_parziale') || ($nome == 'data_resezione_gliadel') )	
	{
		if ($operazione == 'between')
			return (1);
		else
			return (0);	
	}	
	
	// Istologia ------------------------------------	
	if ( ($nome == 'tumore') || ($nome == 'note_tumore') )	
			return (0);		
	if ($nome == 'data_risultato')
	{
		if ($operazione == 'between')
			return (1);
		else
			return (0);	
	}		
	
	// Permeabilita' ------------------------------------		
	if ( ($nome == 'k_trans') || ($nome == 'vi') )	
	{
		if ($operazione == 'between')
			return (1);
		else
			return (0);	
	}		
	
	// RM-BOLD ------------------------------------		
	if ($nome == 'motorio_sede')
		return (6);	
	if ( ($nome == 'motorio_anteriore') || ($nome == 'motorio_posteriore') || ($nome == 'motorio_mediale') || ($nome == 'motorio_intralesionale') || ($nome == 'motorio_laterale') || ($nome == 'motorio_inferiore') || ($nome == 'motorio_superiore') )      
		return (3);	
	if ($nome == 'motorio_altro')
		return (0);	
	if ($nome == 'sensitiva_sede')
		return (0);			
	if ( ($nome == 'sensitiva_anteriore') || ($nome == 'sensitiva_posteriore') || ($nome == 'sensitiva_mediale') || ($nome == 'sensitiva_intralesionale') || ($nome == 'sensitiva_laterale') || ($nome == 'sensitiva_inferiore') || ($nome == 'sensitiva_superiore') )      
		return (3);	
	if ($nome == 'sensitiva_altro')
		return (0);			
	if ($nome == 'linguaggio_broca')
		return (3);		
	if ($nome == 'linguaggio_wernicke')
		return (3);			
	
	// RM-DTI ------------------------------------			
	if ($nome == 'valore_fa')
	{
		if ($operazione == 'between')
			return (1);
		else
			return (0);	
	}	
	if ($nome == 'cortico_spinale')
		return (13);		
	if ($nome == 'arcuato')
		return (13);		
	if ($nome == 'longitudinale_inferiore')
		return (13);		
	if ($nome == 'vie_ottiche')
		return (13);	
	
	// RM-morfologica ------------------------------------		
	if ($nome == 'extrassiale')
		return (3);	
	if ($nome == 'intrassiale')
		return (3);		
	if ($nome == 't2_flair')
		return (3);		
	if ($nome == 'flair_3d')
		return (3);		
	if ($nome == 'volume_neo')
	{
		if ($operazione == 'between')
			return (1);
		else
			return (0);	
	}	
	if ($nome == 'dwi')
		return (3);		
	if ($nome == 'dwi_ristretta')
		return (8);		
	if ($nome == 'adc')
		return (3);	
	if ($nome == 'tipo_adc')
		return (9);			
	if ($nome == 'valore_adc')
	{
		if ($operazione == 'between')
			return (1);
		else
			return (0);	
	}		
	if ($nome == 'ce')
		return (3);			
	if ($nome == 'tipo_ce')
		return (4);			
	
	// Perfusione -------------------------
	if ($nome == 'r_cbv')
		return (10);	
	if ($nome == 'valore_r_cbv')
	{
		if ($operazione == 'between')
			return (1);
		else
			return (0);	
	}	
		
		
	// Spettroscopia -------------------------
	if ($nome == 'naa_ridotto')
		return (3);	
	if ($nome == 'valore_naa_cr')
	{
		if ($operazione == 'between')
			return (1);
		else
			return (0);	
	}					
	if ($nome == 'cho_cr')
	{
		if ($operazione == 'between')
			return (1);
		else
			return (0);	
	}		
	if ($nome == 'lipidi_lattati')
		return (3);		
	if ($nome == 'mioinositolo')
		return (3);		
	if ($nome == 'tipo_spettro')
		return (3);		
	if ($nome == 'te')
		return (11);			
		
	// Sintomi -------------------------
	if ($nome == 'deficit')
		return (3);	
	if ($nome == 'crisi_epilettica')
		return (3);	
	if ($nome == 'note')
		return (0);	
	if ($nome == 'disturbi_comportamento')
		return (3);	
	if ($nome == 'cefalea')
		return (3);	
	if ($nome == 'deficit_motorio')
		return (3);	
	if ($nome == 'data_sintomi')
		return (12);			
		
	// Terapia -------------------------
	if ($nome == 'rt_conformazionale')
		return (3);	
	if ($nome == 'data_rt_conformazionale')
	{
		if ($operazione == 'between')
			return (1);
		else
			return (0);	
	}
	if ($nome == 'radiochirurgia')
		return (3);	
	if ($nome == 'data_radiochirurgia')
	{
		if ($operazione == 'between')
			return (1);
		else
			return (0);	
	}		

}
?>