<?php
	// Statistica e grafico per i valori in cui compaioni i numeri
?>
<!-- Tabella MEDIA-DEV.STANDARD....ecc... ****************************************** -->		
<font size='5' color='#FBF8D5' face='Verdana, Arial, Helvetica, sans-serif'><?php print $nome_campo1; ?></font>

<table border='0' width='40%'>
<tr> 
	<td width='10%' id='font3' align="center" bgcolor="#006699"><font color='#FFFFCC'> N </td>
	<td width='50%' id='font3' bgcolor="#006699"><font color='#FFFFCC'>Number of patients</font></td>
	<td width='40%' id='form2'>
	<?php print ("$n_pazienti");?>
	</td>
</tr>
<?php
if ($n_pazienti != 0)
{
?>
		<tr> 
			<td width='10%' id='font3' align="center" bgcolor="#006699"><font color='#FFFFCC'> 0 </td>
			<td width='50%' id='font3' bgcolor="#006699"><font color='#FFFFCC'># Last week</font>
			</td>
			<td width='40%' id='form2'>
			<?php print ("$n_1");?>
			</td>
		</tr>  
		<tr> 
			<td width='10%' id='font3' align="center" bgcolor="#006699"><font color='#FFFFCC'> 1 </td>
			<td width='50%' id='font3' bgcolor="#006699"><font color='#FFFFCC'># Last month </font>
			</td>
			<td width='40%' id='form2'>
			<?php print ("$n_2");?>
			</td>
		</tr> 
		<tr> 
			<td width='10%' id='font3' align="center" bgcolor="#006699"><font color='#FFFFCC'> 2 </td>
			<td width='50%' id='font3' bgcolor="#006699"><font color='#FFFFCC'># Last 6 months </font>
			</td>
			<td width='40%' id='form2'>
			<?php print ("$n_3");?>
			</td>
		</tr> 
		<tr> 
			<td width='10%' id='font3' align="center" bgcolor="#006699"><font color='#FFFFCC'> 3 </td>
			<td width='50%' id='font3' bgcolor="#006699"><font color='#FFFFCC'># More than 6 months </font>
			</td>
			<td width='40%' id='form2'>
			<?php print ("$n_4");?>
			</td>
		</tr>
<?php
}
?>		 
</table>
<?php
	if ($n_1 != 0)
		$n_valori['Last week'] = $n_1;
	if ($n_2 != 0)	
		$n_valori['Last month'] = $n_2;
	if ($n_3 != 0)	
		$n_valori['Last 6 months'] = $n_3;
	if ($n_4 != 0)	
		$n_valori['More than 6 months'] = $n_4;
		
					
	$n_niente=$n_pazienti-$n_1-$n_2-$n_3-$n_4;
	if (($n_1+$n_2+$n_3+$n_4) != $n_pazienti)
		$n_valori['Niente']=$n_niente;
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
	$id_paz = $paziente->getID_paziente();

	if($i& 1)
		$color='form2';
	else
		$color='form2_2';
		
	$rm = new sintomi (NULL);
	$rm->retrive_by_id($id_paz);
	$id = $rm -> getID_sintomi_array(0);
	$rm -> retrive_by_id_sintomi($id);
	
	$val_dif = $rm->getData_sintomi();
	if ($val_dif == 'ultima_settimana')
		$val_dif = 'last week';
	if ($val_dif == 'ultimo_mese')
		$val_dif = 'last month';		
	if ($val_dif == 'ultimi_sei_mesi')
		$val_dif = 'last 6 months';	
	if ($val_dif == 'piu_sei_mesi')
		$val_dif = 'more than 6 months';	
				
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
			$val_dif
		</td>		
	</tr>
	");
}
?>
</table>