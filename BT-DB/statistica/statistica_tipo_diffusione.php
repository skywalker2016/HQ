<?php
	// Statistica e grafico per i valori in cui compaioni i numeri
?>
<!-- Tabella MEDIA-DEV.STANDARD....ecc... ****************************************** -->		
<font size='5' color='#FBF8D5' face='Verdana, Arial, Helvetica, sans-serif'><?php print $nome_campo1; ?></font>

<table border='0' width='40%'>
<tr> 
	<td width='10%' id='font3' align="center" bgcolor="#006699"><font color='#FFFFCC'> N </td>
	<td width='50%' id='font3' bgcolor="#006699"><font color='#FFFFCC'>Nu,ber of patients</font></td>
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
			<td width='50%' id='font3' bgcolor="#006699"><font color='#FFFFCC'># HYPER </font>
			</td>
			<td width='40%' id='form2'>
			<?php print ("$n_iper");?>
			</td>
		</tr>  
		<tr> 
			<td width='10%' id='font3' align="center" bgcolor="#006699"><font color='#FFFFCC'> 1 </td>
			<td width='50%' id='font3' bgcolor="#006699"><font color='#FFFFCC'># HYPO</font>
			</td>
			<td width='40%' id='form2'>
			<?php print ("$n_ipo");?>
			</td>
		</tr> 
		<tr> 
			<td width='10%' id='font3' align="center" bgcolor="#006699"><font color='#FFFFCC'> 2 </td>
			<td width='50%' id='font3' bgcolor="#006699"><font color='#FFFFCC'># Normal</font>
			</td>
			<td width='40%' id='form2'>
			<?php print ("$n_normale");?>
			</td>
		</tr>
<?php
}
?>				
</table>
<?php
	if ($n_iper != 0)
		$n_valori['Hyper'] = $n_iper;
	if ($n_ipo != 0)	
		$n_valori['Hypo'] = $n_ipo;
	if ($n_normale != 0)	
		$n_valori['Normal'] = $n_normale;
	
	$n_niente=$n_pazienti-$n_iper-$n_ipo-$n_normale;
	if (($n_iper+$n_ipo+$n_normale) != $n_pazienti)
		$n_valori['Nothing']=$n_niente;
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
		
	$rm = new rm_morfologica ($id_paz, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
	$rm->retrive_by_id_paziente();	
	$id = $rm -> getID_array(0);
	$rm -> retrive_by_id($id);

	if ($permission == 3)
	{
		$cognome = '**********';
		$nome = '**********';
	}
	
	$val_dif = $rm->getDwi_ristretta();	
	
	if ($val_dif == 'iper')
		$val_dif = 'Hyper';
	if ($val_dif == 'ipo')
		$val_dif = 'Hypo';			
	if ($val_dif == 'normale')
		$val_dif = 'Normal';

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