<?php
	// Statistica e grafico per i valori in cui compaioni i numeri
?>
<!-- Tabella MEDIA-DEV.STANDARD....ecc... ****************************************** -->		
<font size='5' color='#FBF8D5' face='Verdana, Arial, Helvetica, sans-serif'><?php print $nome_campo1; ?></font>

<table border='0' width='40%'>
<tr> 
<td width='60%' id='font3' bgcolor="#006699"><font color='#FFFFCC'>Number of patients</font></td>
<td width='40%' id='form2'>
<?php print ("$n_pazienti");?>
</td>
</tr>
</table>
<br /><br />

<!-- Tabella soggetti ********************************************************************** -->
<table border="0" cellpadding="0" cellspacing="2" width="40%">
<tr>
	<td align="center" width="30%" id='font3' bgcolor="#006699">
		LASTNAME
	</td>
	<td align="center" width="30%" id='font3' bgcolor="#006699">
		NAME
	</td>
	<td align="center" width="40%" id='font3' bgcolor="#006699">
		<?php echo ($nome_campo1); ?>
	</td>		
</tr>
</table>

<table border="0" cellpadding="0" cellspacing="2" width="40%">
<?php
for ($i=0; $i<$n_pazienti; $i++)
{
	$paziente -> retrive_by_ID($id_finali_new2[$i]);
	$cognome = $paziente->getSurname();
	$nome = $paziente->getName();

	if($i& 1)
		$color='form2';
	else
		$color='form2_2';

	if ($permission == 3)
	{
		$cognome = '**********';
		$nome = '**********';
	}
	
	print "
	<tr>
		<td align='center' width='30%' id='$color' bgcolor='#006699'>
			$cognome
		</td>
		<td align='center' width='30%' id='$color' bgcolor='#006699'>
			$nome
		</td>
		<td align='center' width='40%' id='$color' bgcolor='#006699'>".data_convert_for_utente($valori[$i])."
		</td>		
	</tr>
	";
}
?>
</table>