<?php
	// Statistica e grafico per i valori in cui compaioni i numeri
?>
<!-- Tabella MEDIA-DEV.STANDARD....ecc... ****************************************** -->		
<font size='5' color='#FBF8D5' face='Verdana, Arial, Helvetica, sans-serif'><?php print $nome_campo1; ?></font>

<table border='0' width='50%'>
<tr> 
	<td width='10%' id='font3' align="center" bgcolor="#006699"><font color='#FFFFCC'> N </td>
	<td width='50%' id='font3' bgcolor="#006699"><font color='#FFFFCC'>Number of patients with Language Test activation</font></td>
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
			<td width='50%' id='font3' bgcolor="#006699"><font color='#FFFFCC'># Broca activation </font>
			</td>
			<td width='40%' id='form2'>
			<?php print ("$n_on_b");?>
			</td>
		</tr>  
		<tr> 
			<td width='10%' id='font3' align="center" bgcolor="#006699"><font color='#FFFFCC'> 1 </td>
			<td width='50%' id='font3' bgcolor="#006699"><font color='#FFFFCC'># Wernicke activation </font>
			</td>
			<td width='40%' id='form2'>
			<?php print ("$n_on_w");?>
			</td>
		</tr> 
<?php
}
?>
</table>
<?php
	$n_valori['Broca'] = $n_on_b;
	$n_valori['Wernicke'] = $n_on_w; 
?>

<br /><br />
<img src="graph2.php?title=<?php echo ($nome_campo1); ?>&mydata=<?php echo urlencode(serialize($n_valori)); ?>" />
<br /><br />

