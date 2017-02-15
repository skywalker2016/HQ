<?php
// script to retrive the TC_RM data from SESSION:

function si_no($var)
{
	if ($var == 'on')
		$var = 'SI';	
	else if ($var == 'off')
		$var = 'NO';
	else
		$var = '-';	

	return ($var);
}

// Retrive all variables from SESSION:
$extrassiale_new = $_SESSION['extrassiale'];
$extrassiale_new = si_no($extrassiale_new);

$intrassiale_new = $_SESSION['intrassiale'];
$intrassiale_new = si_no($intrassiale_new);

$dubbia_new = $_SESSION['dubbia'];
$dubbia_new = si_no($dubbia_new);

$contrasto_new = $_SESSION['contrasto'];
$contrasto_new = si_no($contrasto_new);

$tipo_contrasto_new = $_SESSION['tipo_contrasto'];
if ($tipo_contrasto_new == 'omogeneo')
	$tipo_contrasto_new = 'Omogeneo';
else if ($tipo_contrasto_new == 'disomogeneo')
	$tipo_contrasto_new = 'Disomogeneo';
else if ($tipo_contrasto_new == 'ad_anello')
	$tipo_contrasto_new = 'Ad anello';		
	
$sede_new = $_SESSION['sede'];

$extrassiale_rm_new = $_SESSION['extrassiale_rm'];	
$extrassiale_rm_new = si_no($extrassiale_rm_new);

$intrassiale_rm_new = $_SESSION['intrassiale_rm'];
$intrassiale_rm_new = si_no($intrassiale_rm_new);

$t2_flair_new = $_SESSION['t2_flair'];
$t2_flair_new = si_no($t2_flair_new);

$flair_3d_new = $_SESSION['flair_3d'];
$flair_3d_new = si_no($flair_3d_new);

$calcolo_volume_neo_new = $_SESSION['calcolo_volume_neo'];
if ($calcolo_volume_neo_new == NULL)
	$calcolo_volume_neo_new = '-';
	
$dwi_new = $_SESSION['dwi'];
$dwi_new = si_no($dwi_new);

$dwi_ristretta_new = $_SESSION['dwi_ristretta'];

$adc_new = $_SESSION['adc'];
$adc_new = si_no($adc_new);

$tipo_adc_new = $_SESSION['tipo_adc'];

$valore_adc_new = $_SESSION['valore_adc'];
if ($valore_adc_new == NULL)
	$valore_adc_new = '-';

$ce_new = $_SESSION['ce'];
$ce_new = si_no($ce_new);

$tipo_ce_new = $_SESSION['tipo_ce'];
if ($tipo_ce_new == 'omogeneo')
	$tipo_ce_new = 'Omogeneo';
else if ($tipo_ce_new == 'disomogeneo')
	$tipo_ce_new = 'Disomogeneo';
else if ($tipo_ce_new == 'ad_anello')
	$tipo_ce_new = 'Ad anello';	


// Spettroscopica con TE BREVE --------------------------------	
			
$tipo_spettro_new_breve = $_SESSION['tipo_spettro_breve'];	

$te_new_breve = $_SESSION['te_breve'];
	
$naa_new_breve = $_SESSION['naa_breve'];
$naa_new_breve = si_no($naa_new_breve);

$valore_naa_cr_new_breve = $_SESSION['valore_naa_cr_breve'];
if ($valore_naa_cr_new_breve == NULL)
	$valore_naa_cr_new_breve = '-';
	
$valore_cho_cr_new_breve = $_SESSION['valore_cho_cr_breve'];
if ($valore_cho_cr_new_breve == NULL)
	$valore_cho_cr_new_breve = '-';
	
$lipidi_lattati_new_breve = $_SESSION['lipidi_lattati_breve'];		
$lipidi_lattati_new_breve = si_no($lipidi_lattati_new_breve);	
	
$mioinositolo_new_breve = $_SESSION['mioinositolo_breve'];	
$mioinositolo_new_breve = si_no($mioinositolo_new_breve);		

// Spettroscopica con TE intermedio --------------------------------	
$tipo_spettro_new_intermedio = $_SESSION['tipo_spettro_intermedio'];	

$te_new_intermedio = $_SESSION['te_intermedio'];
	
$naa_new_intermedio = $_SESSION['naa_intermedio'];
$naa_new_intermedio = si_no($naa_new_intermedio);

$valore_naa_cr_new_intermedio = $_SESSION['valore_naa_cr_intermedio'];
if ($valore_naa_cr_new_intermedio == NULL)
	$valore_naa_cr_new_intermedio = '-';
	
$valore_cho_cr_new_intermedio = $_SESSION['valore_cho_cr_intermedio'];
if ($valore_cho_cr_new_intermedio == NULL)
	$valore_cho_cr_new_intermedio = '-';
	
$lipidi_lattati_new_intermedio = $_SESSION['lipidi_lattati_intermedio'];		
$lipidi_lattati_new_intermedio = si_no($lipidi_lattati_new_intermedio);	
	
$mioinositolo_new_intermedio = $_SESSION['mioinositolo_intermedio'];	
$mioinositolo_new_intermedio = si_no($mioinositolo_new_intermedio);	

// Spettroscopica con TE lungo --------------------------------	
$tipo_spettro_new_lungo = $_SESSION['tipo_spettro_lungo'];	

$te_new_lungo = $_SESSION['te_lungo'];
	
$naa_new_lungo = $_SESSION['naa_lungo'];
$naa_new_lungo = si_no($naa_new_lungo);

$valore_naa_cr_new_lungo = $_SESSION['valore_naa_cr_lungo'];
if ($valore_naa_cr_new_lungo == NULL)
	$valore_naa_cr_new_lungo = '-';
	
$valore_cho_cr_new_lungo = $_SESSION['valore_cho_cr_lungo'];
if ($valore_cho_cr_new_lungo == NULL)
	$valore_cho_cr_new_lungo = '-';
	
$lipidi_lattati_new_lungo = $_SESSION['lipidi_lattati_lungo'];		
$lipidi_lattati_new_lungo = si_no($lipidi_lattati_new_lungo);	
	
$mioinositolo_new_lungo = $_SESSION['mioinositolo_lungo'];	
$mioinositolo_new_lungo = si_no($mioinositolo_new_lungo);

	
$r_cbv_new = $_SESSION['r_cbv'];	
if ($r_cbv_new == 'inf')
	$r_cbv_new = 'Inferiore a 1.75';
else if ($r_cbv_new == 'sup')
	$r_cbv_new = 'Superiore a 1.75';	
else if ($r_cbv_new == NULL)
	$r_cbv_new = '-';		
	
$valore_r_cbv_new = $_SESSION['valore_r_cbv'];		
if ($valore_r_cbv_new == NULL)
	$valore_r_cbv_new= '-';	
	
$sede1_new = $_SESSION['sede1'];	
if ($sede1_new == 'mano')
	$sede1_new = 'Mano';
else if ($sede1_new == 'piede')
	$sede1_new = 'Piede';	
else if ($sede1_new == NULL)
	$sede1_new = '-';		
	
	
$n_motoria =0;
$motorio_anteriore_new = $_SESSION['motorio_anteriore'];
if ($motorio_anteriore_new == 'on')
{
	$motoria_variable[$n_motoria] = 'Anteriore';
	$n_motoria = $n_motoria+1;
}

$motorio_posteriore_new = $_SESSION['motorio_posteriore'];	
if ($motorio_posteriore_new == 'on')
{
	$motoria_variable[$n_motoria] = 'Posteriore';
	$n_motoria = $n_motoria+1;
}
	
$motorio_mediale_new = $_SESSION['motorio_mediale'];
if ($motorio_mediale_new == 'on')
{
	$motoria_variable[$n_motoria] = 'Mediale';
	$n_motoria = $n_motoria+1;
}
	
$motorio_intralesionale_new = $_SESSION['motorio_intralesionale'];	
if ($motorio_intralesionale_new == 'on')
{
	$motoria_variable[$n_motoria] = 'Intralesionale';
	$n_motoria = $n_motoria+1;
}

$motorio_laterale_new = $_SESSION['motorio_laterale'];	
if ($motorio_laterale_new == 'on')
{
	$motoria_variable[$n_motoria] = 'Laterale';
	$n_motoria = $n_motoria+1;
}

$motorio_inferiore_new = $_SESSION['motorio_inferiore'];	
if ($motorio_inferiore_new == 'on')
{
	$motoria_variable[$n_motoria] = 'Inferiore';
	$n_motoria = $n_motoria+1;
}

$motorio_superiore_new = $_SESSION['motorio_superiore'];
if ($motorio_superiore_new == 'on')
{
	$motoria_variable[$n_motoria] = 'Superiore';
	$n_motoria = $n_motoria+1;
}

$motorio_altro_new = $_SESSION['motorio_altro'];	
if ($motorio_altro_new != NULL)
{
	$motoria_variable[$n_motoria] = $motorio_altro;
	$n_motoria = $n_motoria+1;
}

$sede2_new = $_SESSION['sede2'];	
if ($sede2_new == 'mano')
	$sede2_new = 'Mano';
else if ($sede2_new == 'piede')
	$sede2_new = 'Piede';	
else if ($sede2_new == NULL)
	$sede2_new = '-';	
	
$n_sensitiva =0;
$sensitiva_anteriore_new = $_SESSION['sensitiva_anteriore'];
if ($sensitiva_anteriore_new == 'on')
{
	$sensitiva_variable[$n_sensitiva] = 'Anteriore';
	$n_sensitiva = $n_sensitiva+1;
}

$sensitiva_posteriore_new = $_SESSION['sensitiva_posteriore'];	
if ($sensitiva_posteriore_new == 'on')
{
	$sensitiva_variable[$n_sensitiva] = 'Posteriore';
	$n_sensitiva = $n_sensitiva+1;
}
	
$sensitiva_mediale_new = $_SESSION['sensitiva_mediale'];
if ($sensitiva_mediale_new == 'on')
{
	$sensitiva_variable[$n_sensitiva] = 'Mediale';
	$n_sensitiva = $n_sensitiva+1;
}
	
$sensitiva_intralesionale_new = $_SESSION['sensitiva_intralesionale'];	
if ($sensitiva_intralesionale_new == 'on')
{
	$sensitiva_variable[$n_sensitiva] = 'Intralesionale';
	$n_sensitiva = $n_sensitiva+1;
}

$sensitiva_laterale_new = $_SESSION['sensitiva_laterale'];	
if ($sensitiva_laterale_new == 'on')
{
	$sensitiva_variable[$n_sensitiva] = 'Laterale';
	$n_sensitiva = $n_sensitiva+1;
}

$sensitiva_inferiore_new = $_SESSION['sensitiva_inferiore'];	
if ($sensitiva_inferiore_new == 'on')
{
	$sensitiva_variable[$n_sensitiva] = 'Inferiore';
	$n_sensitiva = $n_sensitiva+1;
}

$sensitiva_superiore_new = $_SESSION['sensitiva_superiore'];
if ($sensitiva_superiore_new == 'on')
{
	$sensitiva_variable[$n_sensitiva] = 'Superiore';
	$n_sensitiva = $n_sensitiva+1;
}

$sensitiva_altro_new = $_SESSION['sensitiva_altro'];	
if ($sensitiva_altro_new != NULL)
{
	$sensitiva_variable[$n_sensitiva] = $sensitiva_altro;
	$n_sensitiva = $n_sensitiva+1;
}

$broca_new = $_SESSION['broca'];	
if ($broca_new != NULL)
	$broca_new = "Attivazione circonvoluzione frontale inferiore (Broca)";

$wernicke_new = $_SESSION['wernicke'];
if ($wernicke_new != NULL)
	$wernicke_new ="Attivazione temporale postero-superiore (Wernicke)";

$fa_new = $_SESSION['fa'];
if ($fa_new == NULL)
	$fa_new = "-";

$cortico_spinale_new = $_SESSION['cortico_spinale'];	
if ($cortico_spinale_new == NULL)
	$cortico_spinale_new ='-';

$arcuato_new = $_SESSION['arcuato'];
if ($arcuato_new == NULL)
	$arcuato_new ='-';

$longitudinale_inferiore_new = $_SESSION['longitudinale_inferiore'];	
if ($longitudinale_inferiore_new == NULL)
	$longitudinale_inferiore_new ='-';

$vie_ottiche_new = $_SESSION['vie_ottiche'];
if ($vie_ottiche_new == NULL)
	$vie_ottiche_new ='-';
?>