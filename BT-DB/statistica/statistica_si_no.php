<?php
	// Statistica e grafico per i valori in cui compaioni i numeri
?>
<!-- Tabella MEDIA-DEV.STANDARD....ecc... ****************************************** -->		
<font size='5' color='#FBF8D5' face='Verdana, Arial, Helvetica, sans-serif'><?php print $nome_campo1; ?></font>

<table border='0' width='40%'>
<tr> 
	<td width='10%' id='font3' align="center" bgcolor="#006699"><font color='#FFFFCC'> N </td>
	<td width='50%' id='font3' bgcolor="#006699"><font color='#FFFFCC'>Number of patients with <?php print $nome_tabella; ?></font></td>
	<td width='40%' id='form2'>
	<?php print ("$n_pazienti");?>
	</td>
</tr>
<tr> 
	<td width='10%' id='font3' align="center" bgcolor="#006699"><font color='#FFFFCC'> 0 </td>
	<td width='50%' id='font3' bgcolor="#006699"><font color='#FFFFCC'># YES <?php print $nome_campo1; ?></font>
	</td>
	<td width='40%' id='form2'>
	<?php print ("$n_on");?>
	</td>
</tr>  
<tr> 
	<td width='10%' id='font3' align="center" bgcolor="#006699"><font color='#FFFFCC'> 1 </td>
	<td width='50%' id='font3' bgcolor="#006699"><font color='#FFFFCC'># NO  <?php print $nome_campo1; ?></font>
	</td>
	<td width='40%' id='form2'>
	<?php print 
	$n_off = $n_pazienti-$n_on;?>
	</td>
</tr> 
</table>
<?php
	$var_1='YES';
	$var_2='NO';

	if ($n_on == 0)
		$n_valori[$var_2] =$n_pazienti;
	else if ($n_off == 0)
		$n_valori[$var_1] =$n_pazienti;
	else
	{
		$n_valori[$var_1] = $n_on;
		$n_valori[$var_2] =$n_off;		
	}	 	
	
?>

<br /><br />
<img src="graph_reparto.php?title=<?php echo ($nome_campo1); ?>&mydata=<?php echo urlencode(serialize($n_valori)); ?>" />
<br /><br />

<table border="0" cellpadding="0" cellspacing="2" width="40%">
<?php
for ($i=0; $i<$n_pazienti; $i++)
{
	$paziente -> retrive_by_ID($id_finali_new[$i]);
	$cognome = $paziente->getSurname();
	$nome = $paziente->getName();

	if($i& 1)
		$color='form2';
	else
		$color='form2_2';

	if ($valori[$i] == 'on')
		$valori[$i] = 'YES';
	else
		$valori[$i] = 'NO';
	
	if ($permission == 3)
	{
		$cognome = '**********';
		$nome = '**********';
	}

	print ("
	<tr>
		<td align='center' width='30%' id='$color' bgcolor='#006699'>
			$cognome
		</td>
		<td align='center' width='30%' id='$color' bgcolor='#006699'>
			$nome
		</td>
		<td align='center' width='40%' id='$color' bgcolor='#006699'>
			$valori[$i]
		</td>		
	</tr>
	");
}
?>
</table>