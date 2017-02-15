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
<?php
if ($n_pazienti != 0)
{
?>


			<tr> 
			<td width='60%' id='font3' bgcolor="#006699"><font color='#FFFFCC'>Exams with frontal attivation:</font>
			</td>
			<td width='40%' id='form2'>
			<?php  print $n_anteriore ?>
			</td>
			</tr>  
			<tr> 
			<td width='60%' id='font3' bgcolor="#006699"><font color='#FFFFCC'>Exams with rearward attivation:</font>
			</td>
			<td width='40%' id='form2'>
			<?php  print $n_posteriore ?>
			</td>
			</tr> 
			<tr> 
			<td width='60%' id='font3' bgcolor="#006699"><font color='#FFFFCC'>Exams with medial attivation:</font>
			</td>
			<td width='40%' id='form2'>
			<?php  print $n_mediale ?>
			</td>
			</tr> 
			<tr> 
			<td width='60%' id='font3' bgcolor="#006699"><font color='#FFFFCC'>Exams with Intralesional attivation:</font>
			</td>
			<td width='40%' id='form2'>
			<?php  print $n_intralesionale ?>
			</td>
			</tr> 
			<tr> 
			<td width='60%' id='font3' bgcolor="#006699"><font color='#FFFFCC'>Exams with Lateral attivation:</font>
			</td>
			<td width='40%' id='form2'>
			<?php  print $n_laterale ?>
			</td>
			</tr> 
			<tr> 
			<td width='60%' id='font3' bgcolor="#006699"><font color='#FFFFCC'>Exams with Lower attivation:</font>
			</td>
			<td width='40%' id='form2'>
			<?php  print $n_inferiore ?>
			</td>
			</tr> 
			<tr> 
			<td width='60%' id='font3' bgcolor="#006699"><font color='#FFFFCC'>Exams with Upperl attivation:</font>
			</td>
			<td width='40%' id='form2'>
			<?php  print $n_superiore ?>
			</td>
			</tr> 
			<tr> 
			<td width='60%' id='font3' bgcolor="#006699"><font color='#FFFFCC'>Exams with attivation in other parts:</font>
			</td>
			<td width='40%' id='form2'>
			<?php  print $n_altro ?>
			</td>
			</tr> 
<?php
}
?>
</table>

<br /><br />
<!-- GRAFICO soggetti ********************************************************************* -->
<img src="graph.php?title=<?php echo ($nome_campo1); ?>&mydata=<?php echo urlencode(serialize($valori)); ?>" />
<br />
<br /><br />
