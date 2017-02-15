<?php
// Statistiche per il reparto di provenienza
?>

<font size='5' color='#FBF8D5' face='Verdana, Arial, Helvetica, sans-serif'><?php print $nome_campo1; ?></font>

<table border='0' width='40%'>
<tr> 
<td width='10%' id='font3' bgcolor="#006699" align="center"><font color='#FFFFCC'>#</font></td>
<td width='50%' id='font3' bgcolor="#006699"><font color='#FFFFCC'>Number of patients</font></td>
<td width='40%' id='form2'>
<?php print ("$n_pazienti");?>
</td>
</tr>
<?php
for ($i=0; $i<$n8; $i++)
{	

	// recupera il numero di pazienti di quel reparto:
	$query = "SELECT id_paziente FROM esame_tc WHERE sede = '$var_1[$i]' ";
	$rs = mysql_query($query);
	$n3=0;
	while(list($id1) = mysql_fetch_row($rs))
	{
		for ($t=0; $t<$n_pazienti; $t++)
		{	
			if ($id_finali[$t] == $id1) 
			{
				$nome_reparto[$i] = $var_1[$i]; 
				$n3=$n3+1;
				$numero_paz_reparto[$i] = $n3;				
			}	
			else;
		}		
	}

	if ($n3 == 0);
	else
	{
		print ("
			<tr> 
			<td width='10%' id='font3' bgcolor='#006699' align='center'><font color='#FFFFCC'>$i</font></td>
			<td width='50%' id='font3' bgcolor='#006699'><font color='#FFFFCC'># Patients with: $var_1[$i]</font></td>
			<td width='40%' id='form2'>
			$numero_paz_reparto[$i]
			</td>
			</tr>
		");
	}
}	
?>
</table>
<br /><br />

<img src="graph_reparto.php?title=<?php echo ($nome_campo1); ?>&mydata=<?php echo urlencode(serialize($numero_paz_reparto)); ?>" />