<?php
// Statistica e grafico per i valori in cui compaioni le date

// calcola il numero dei pazienti inseriti in base all'anno: *******************************************************
for ($i=0; $i<$n_pazienti; $i++)
{
	$val = $valori[$i];
	$anno = NULL;
	for ($o=0; $o<4; $o++)
		$anno = $anno.$val[$o];
	
	$solo_anno[$i] = $anno;
}

sort($solo_anno);
$f=0;
$valori_1 = array();
$valori_1[0] = $solo_anno[0];
for ($i=0; $i<$n_pazienti; $i++)
{
	$ww=$i+1;
	if ($valori_1[$f] == $solo_anno[$ww]);
	else
	{
		$f=$f+1;
		$valori_1[$f] = $solo_anno[$ww];
	}
}
array_pop($valori_1); // elimina l'ultimo valore dall'array che è nullo

$nn=count($valori_1);

$valori_date = array();
$valori_fin = array();

for ($i=0; $i<$nn; $i++)
{
	$query = "SELECT id_paziente FROM inserimento WHERE data_inserimento LIKE '%$valori_1[$i]%'";
	$rs = mysql_query($query);
	$n_paz=0;
	while(list($id) = mysql_fetch_row($rs))	
	{	
		for ($ii=0; $ii<$n_pazienti; $ii++)
		{
			if ($id == $id_finali_new2[$ii])
				$n_paz = $n_paz+1;
			else;
		}
	}
	$valori_date[$valori_1[$i]]=$n_paz;
}
// ******************************************************************************************************************
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

<img src="graph.php?title=<?php echo ($nome_campo1); ?>&mydata=<?php echo urlencode(serialize($valori_date)); ?>" />

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