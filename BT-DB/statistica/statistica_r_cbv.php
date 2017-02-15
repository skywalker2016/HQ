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
			<td width='50%' id='font3' bgcolor="#006699"><font color='#FFFFCC'># r_CBV < 1.75</font>
			</td>
			<td width='40%' id='form2'>
			<?php print ("$n_1");?>
			</td>
		</tr>  
		<tr> 
			<td width='10%' id='font3' align="center" bgcolor="#006699"><font color='#FFFFCC'> 1 </td>
			<td width='50%' id='font3' bgcolor="#006699"><font color='#FFFFCC'># r_CBV > 1.75 </font>
			</td>
			<td width='40%' id='form2'>
			<?php print ("$n_2");?>
			</td>
		</tr>
<?php
}
?>
</table>
<?php
	if ($n_1 != 0)
		$n_valori['Inferior'] = $n_1;
	if ($n_2 != 0)	
		$n_valori['Superior'] = $n_2;
	
	$n_niente=$n_pazienti-$n_1-$n_2;
	if (($n_1+$n_2) != $n_pazienti)
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
		
	$rm = new rm_perfusione ($id_paz, NULL, NULL, NULL);
	$rm->retrive_by_id_paziente($id_paz);
	$id = $rm  -> getID_rm_perfusione_array(0);
	$rm -> retrive_by_id($id);
	
	$val_dif = $rm->getR_cbv();	
	
	if ($val_dif == 'inf')
		$val_dif = 'Inferior';
	if ($val_dif == 'sup')
		$val_dif = 'Superior';			

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