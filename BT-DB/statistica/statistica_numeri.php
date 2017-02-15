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
			<td width='60%' id='font3' bgcolor="#006699"><font color='#FFFFCC'>Average</font>
			</td>
			<td width='40%' id='form2'>
			<?php
				$media = media($n_pazienti, $valori);
				
				if ( ($nome_campo1 == 'VALORE DI K TRANS') || ($nome_campo1 == 'VALORE DI vi') )
					$media=number_format($media,4,".","");
				else	
					$media=number_format($media,2,".","");
				
				print ("$media");
			?>
			</td>
			</tr>  
			<tr> 
			<td width='60%' id='font3' bgcolor="#006699"><font color='#FFFFCC'>Stardard Deviation</font></td>
			<td width='40%' id='form2'>
			<?php
				$sd=SD($n_pazienti, $valori, $media);
				if ( ($nome_campo1 == 'VALORE DI K TRANS') || ($nome_campo1 == 'VALORE DI vi') )
					$sd=number_format($sd,4,".","");
				else	
					$sd=number_format($sd,2,".","");
			
				print ("$sd");?>
			</td>
			</tr> 
			<tr> 
			<td width='60%' id='font3' bgcolor="#006699"><font color='#FFFFCC'>Median</font></td>
			<td width='40%' id='form2'>
			<?php
				$mediana=mediana($valori);
				if ( ($nome_campo1 == 'VALORE DI K TRANS') || ($nome_campo1 == 'VALORE DI vi') )
					$mediana=number_format($mediana,4,".","");
				else	
					$mediana=number_format($mediana,2,".","");
				
				print ("$mediana");?>
			</td>
			</tr> 
			<tr> 
			<td width='60%' id='font3' bgcolor="#006699"><font color='#FFFFCC'>Minimun Value</font></td>
			<td width='40%' id='form2'>
			<?php
				$valu=min_max($n_pazienti, $valori, $nome_campo1);
				$min=$valu[0];
				print ("$min");?>
			</td>
			</tr>  	
			<tr> 
			<td width='60%' id='font3' bgcolor="#006699"><font color='#FFFFCC'>Maximun Value</font></td>
			<td width='40%' id='form2'>
			<?php
				$valu=min_max($n_pazienti, $valori, $nome_campo1);
				$max=$valu[1];
				print ("$max");?>
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

<font size='4' color='#A3A96D' face='Verdana, Arial, Helvetica, sans-serif'>Frequency plot</font>
<br />
<?php
$data2=frequenza($min, $max, $n_pazienti, $valori, $nome_campo1);	
?>
<!-- Grafico delle frequenze *************************************************************** -->
<img src="graph2.php?title=<?php echo ($nome_campo1); ?>&mydata=<?php echo urlencode(serialize($data2)); ?>"/>
<br /><br />

<!-- Tabella soggetti ********************************************************************** -->
<table border="0" cellpadding="0" cellspacing="2" width="40%">
<tr>
	<td align="center" width="10%" id='font3' bgcolor="#006699">
		N
	</td>
	<td align="center" width="30%" id='font3' bgcolor="#006699">
		LASTNAME
	</td>
	<td align="center" width="30%" id='font3' bgcolor="#006699">
		NAME
	</td>
	<td align="center" width="30%" id='font3' bgcolor="#006699">
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

	print ("
	<tr>
		<td align='center' width='10%' id='$color' bgcolor='#006699'>
			$i
		</td>	
		<td align='center' width='30%' id='$color' bgcolor='#006699'>
			$cognome
		</td>
		<td align='center' width='30%' id='$color' bgcolor='#006699'>
			$nome
		</td>
		<td align='center' width='30%' id='$color' bgcolor='#006699'>
			$valori[$i]
		</td>		
	</tr>
	");
}
?>
</table>