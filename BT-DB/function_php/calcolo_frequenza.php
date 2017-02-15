<?php
function frequenza($min, $max, $n_pazienti, $valori, $nome_campo1)
{

function min_max1($min, $max ,$field, $nome_campo1)
{
	if ( ($nome_campo1 == 'VALORE DI K TRANS') || ($nome_campo1 == 'VALORE DI vi') )
	{
		$val_M[0]=number_format($min,4,".","");
		$val_M[1]= number_format($max,4,".","");
	}
	if ( ($nome_campo1 == 'VALORE DI FA') )
	{
		$val_M[0]=number_format($min,3,".","");
		$val_M[1]= number_format($max,3,".","");
	}
	if ( ($nome_campo1 == 'VALORE r-CBV') )
	{
		$val_M[0]=number_format($min,3,".","");
		$val_M[1]= number_format($max,3,".","");
	}
	else
	{
		$val_M[0]=number_format($min,1,".","");
		$val_M[1]= number_format($max,1,".","");
	}	
	
	return ($val_M);
}


	$delta = ($max-$min)/10;	
	$field = $valori;
	$frequency[] = 0;		
	for ($i=0; $i<$n_pazienti; $i++)
	{
	    $n=$i+1;
	    if ($i==0)
			$number_of_subject[$i]=1;
	    else	
			$number_of_subject[$i]=$n;
	    
	    $var1[$n]=$field[$i]; // Use var1 because the graph axe X MUST start by 1 and not 0
	    
		$freq_var[$n]=$var1[$n];
						
			if( ($freq_var[$n] > ($min-$delta)) && ($freq_var[$n] < ($min+$delta)) )	
				$frequency[0] = $frequency[0] + 1;						
			else if ( ($freq_var[$n] >= ($min+$delta)) && ($freq_var[$n] < ($min+2*$delta)) )	
				$frequency[1] = $frequency[1] + 1;					
			else if ( ($freq_var[$n] >= ($min+2*$delta)) && ($freq_var[$n] < ($min+3*$delta)) )	
				$frequency[2] = $frequency[2] + 1;
			else if ( ($freq_var[$n] >= ($min+3*$delta)) && ($freq_var[$n] < ($min+4*$delta)) )	
				$frequency[3] = $frequency[3] + 1;
			else if ( ($freq_var[$n] >= ($min+4*$delta)) && ($freq_var[$n] < ($min+5*$delta)) )	
				$frequency[4] = $frequency[4] + 1;
			else if ( ($freq_var[$n] >= ($min+5*$delta)) && ($freq_var[$n] < ($min+6*$delta)) )	
				$frequency[5] = $frequency[5] + 1;
			else if ( ($freq_var[$n] >= ($min+6*$delta)) && ($freq_var[$n] < ($min+7*$delta)) )	
				$frequency[6] = $frequency[6] + 1;								
			else if ( ($freq_var[$n] >= ($min+7*$delta)) && ($freq_var[$n] < ($min+8*$delta)) )	
				$frequency[7] = $frequency[7] + 1;		
			else if ( ($freq_var[$n] >= ($min+8*$delta)) && ($freq_var[$n] < ($min+9*$delta)) )	
				$frequency[8] = $frequency[8] + 1;		
			else if ( ($freq_var[$n] >= ($min+9*$delta)) && ($freq_var[$n] < ($min+11*$delta)) )	
				$frequency[9] = $frequency[9] + 1;
	}
	for ($rr=0; $rr<10; $rr++)
	{
		if ($frequency[$rr] == 0)
			$frequency[$rr] = 0.0000001;
		else
			$frequency[$rr] = $frequency[$rr];
	}

	
// ciclo FOR che serve per creare i valori dell'asse delle X
		for ($t=0; $t<10; $t++)
		{
			if ($t == 0)
			{	
				$min1 = $min;
				$max1 = $delta+$min;
				$val_M=min_max1($min1, $max1 ,$field, $nome_campo1);
				$val_x[$t] = "$val_M[0]-$val_M[1]";
			}			
			else if ($t == 1)
			{	
				$min1 = $delta+$min;
				$max1 = 2*$delta+$min;
				$val_M=min_max1($min1, $max1 ,$field, $nome_campo1);
				$val_x[$t] = "$val_M[0]-$val_M[1]";
			}		
			else if ($t == 2)
			{	
				$min1 = 2*$delta+$min;
				$max1 = 3*$delta+$min;
				$val_M=min_max1($min1, $max1 ,$field, $nome_campo1);
				$val_x[$t] = "$val_M[0]-$val_M[1]";
			}		
			else if ($t == 3)
			{	
				$min1 = 3*$delta+$min;
				$max1 = 4*$delta+$min;
				$val_M=min_max1($min1, $max1 ,$field, $nome_campo1);
				$val_x[$t] = "$val_M[0]-$val_M[1]";
			}		
			else if ($t == 4)
			{	
				$min1 = 4*$delta+$min;
				$max1 = 5*$delta+$min;
				$val_M=min_max1($min1, $max1 ,$field, $nome_campo1);
				$val_x[$t] = "$val_M[0]-$val_M[1]";
			}		
			else if ($t == 5)
			{	
				$min1 = 5*$delta+$min;
				$max1 = 6*$delta+$min;
				$val_M=min_max1($min1, $max1 ,$field, $nome_campo1);
				$val_x[$t] = "$val_M[0]-$val_M[1]";
			}
			else if ($t == 6)
			{	
				$min1 = 6*$delta+$min;
				$max1 = 7*$delta+$min;
				$val_M=min_max1($min1, $max1 ,$field, $nome_campo1);
				$val_x[$t] = "$val_M[0]-$val_M[1]";
			}			
			else if ($t == 7)
			{	
				$min1 = 7*$delta+$min;
				$max1 = 8*$delta+$min;
				$val_M=min_max1($min1, $max1 ,$field, $nome_campo1);
				$val_x[$t] = "$val_M[0]-$val_M[1]";
			}	
			else if ($t == 8)
			{	
				$min1 = 8*$delta+$min;
				$max1 = 9*$delta+$min;
				$val_M=min_max1($min1, $max1 ,$field, $nome_campo1);
				$val_x[$t] = "$val_M[0]-$val_M[1]";
			}	
			else if ($t == 9)
			{	
				$min1 = 9*$delta+$min;
				$max1 = 10*$delta+$min;
				$val_M=min_max1($min1, $max1 ,$field, $nome_campo1);
				$val_x[$t] = "$val_M[0]-$val_M[1]";
			}		
		}
	
	$data2= array( 	
		$val_x[0] => $frequency[0],
		$val_x[1] => $frequency[1],
		$val_x[2] => $frequency[2], 
		$val_x[3] => $frequency[3], 
		$val_x[4] => $frequency[4], 
		$val_x[5] => $frequency[5], 
		$val_x[6] => $frequency[6],
		$val_x[7] => $frequency[7],
		$val_x[8] => $frequency[8],						
		$val_x[9] => $frequency[9]);

	return ($data2);
}
?>