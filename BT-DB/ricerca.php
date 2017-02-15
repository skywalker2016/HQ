<?php
session_start();
include ("accesso_db.php");

// Inclusione funzioni per i nominativi delle varie tabelle:
include ("function_php/nomi_chemioterapia.php"); // Chemioterapia
include ("function_php/nomi_esame_tc.php"); // Esame TC
include ("function_php/nomi_intervento.php"); // Intervento
include ("function_php/nomi_istologia.php"); // Istologia
include ("function_php/nomi_permeabilita.php"); // Istologia
include ("function_php/nomi_rm_bold.php"); // RM BOLD
include ("function_php/nomi_rm_dti.php"); // RM DTI
include ("function_php/nomi_rm_morfologica.php"); // RM Morfologica
include ("function_php/nomi_rm_perfusione.php"); // RM Perfusione
include ("function_php/nomi_rm_spettroscopica.php"); // RM spettroscopica
include ("function_php/nomi_sintomi.php"); // RM spettroscopica
include ("function_php/nomi_terapia.php"); // RM terapia
include ("function_php/nomi_anagrafica.php"); // RM Anagrafica
include ("function_php/scelta_operazione.php"); // Scelta dell'operazione che deve visualizzare
include ("function_php/scelta_valore.php"); // Scelta del valore che deve visualizzare

if ($permission == NULL)
	header("Location:errore.html");
	
include ("convertitore_date.php");

require_once('class/class.mostra_tabelle.php');

$delete_session = $_REQUEST['delete_session'];
// Cancellazione SESSION:
if ($delete_session == 1)
{
	$_SESSION['tabella0'] = NULL;
	$_SESSION['tabella1'] = NULL;
	$_SESSION['tabella2'] = NULL;
	$_SESSION['tabella3'] = NULL;
	$_SESSION['tabella4'] = NULL;
	$_SESSION['tabella5'] = NULL;
	$_SESSION['tabella6'] = NULL;
	$_SESSION['tabella7'] = NULL;
	$_SESSION['tabella8'] = NULL;
	$_SESSION['tabella9'] = NULL;

	$_SESSION['nome_tabella'] = NULL;

	$_SESSION['campo0'] = NULL;
	$_SESSION['campo1'] = NULL;
	$_SESSION['campo2'] = NULL;
	$_SESSION['campo3'] = NULL;
	$_SESSION['campo4'] = NULL;
	$_SESSION['campo5'] = NULL;
	$_SESSION['campo6'] = NULL;
	$_SESSION['campo7'] = NULL;
	$_SESSION['campo8'] = NULL;
	$_SESSION['campo9'] = NULL;

	$_SESSION['nome_campo'] = NULL;
	
	$_SESSION['operazione0'] = NULL;
	$_SESSION['operazione1'] = NULL;
	$_SESSION['operazione2'] = NULL;
	$_SESSION['operazione3'] = NULL;
	$_SESSION['operazione4'] = NULL;
	$_SESSION['operazione5'] = NULL;
	$_SESSION['operazione6'] = NULL;
	$_SESSION['operazione7'] = NULL;
	$_SESSION['operazione8'] = NULL;
	$_SESSION['operazione9'] = NULL;

	$_SESSION['nome_operazione'] = NULL;

	$_SESSION['valoree0'] = NULL;
	$_SESSION['valoree1'] = NULL;
	$_SESSION['valoree2'] = NULL;
	$_SESSION['valoree3'] = NULL;
	$_SESSION['valoree4'] = NULL;
	$_SESSION['valoree5'] = NULL;
	$_SESSION['valoree6'] = NULL;
	$_SESSION['valoree7'] = NULL;
	$_SESSION['valoree8'] = NULL;
	$_SESSION['valoree9'] = NULL;

	$_SESSION['nome_valoree'] = NULL;
}

$numero = $_REQUEST['numero'];
$numero1 = $_REQUEST['numero1'];
$numero2 = $_REQUEST['numero2'];
$numero3 = $_REQUEST['numero3'];

// ************************************************ REGISTRAZIONE SESSIONE  **********************************************************************************************************************************************
// Registra le sessioni per le tabelle:
$variabile = $_REQUEST['nome'];
$variabile_campo = $_REQUEST['nome_c'];
$variabile_operazione = $_REQUEST['nome_op'];
$variabile_valoree = $_REQUEST['nome_val'];

function registrazione_tabella_session()
{
	$nome_tabella= array($_SESSION['tabella0'], $_SESSION['tabella1'], $_SESSION['tabella2'], $_SESSION['tabella3'], $_SESSION['tabella4'], $_SESSION['tabella5'], $_SESSION['tabella6'], $_SESSION['tabella7'], $_SESSION['tabella8'], $_SESSION['tabella9']);
	
	$_SESSION['nome_tabella'] = $nome_tabella;
}

function registrazione_campo_session()
{
	$nome_campo= array($_SESSION['campo0'], $_SESSION['campo1'], $_SESSION['campo2'], $_SESSION['campo3'], $_SESSION['campo4'], $_SESSION['campo5'], $_SESSION['campo6'], $_SESSION['campo7'], $_SESSION['campo8'], $_SESSION['campo9']);
	
	$_SESSION['nome_campo'] = $nome_campo;
}

function registrazione_oerazione_session()
{
	$nome_operazione= array($_SESSION['operazione0'], $_SESSION['operazione1'], $_SESSION['operazione2'], $_SESSION['operazione3'], $_SESSION['operazione4'], $_SESSION['operazione5'], $_SESSION['operazione6'], $_SESSION['operazione7'], $_SESSION['operazione8'], $_SESSION['operazione9']);
	
	$_SESSION['nome_operazione'] = $nome_operazione;
}

function registrazione_v_session()
{
	$nome_valoree= array($_SESSION['valoree0'], $_SESSION['valoree1'], $_SESSION['valoree2'], $_SESSION['valoree3'], $_SESSION['valoree4'], $_SESSION['valoree5'], $_SESSION['valoree6'], $_SESSION['valoree7'], $_SESSION['valoree8'], $_SESSION['valoree9']);
	
	$_SESSION['nome_valoree'] = $nome_valoree;
}	
	
	
	if ($numero3 == NULL)
	{

		if ($numero2 == NULL)
		{
		
			if ($numero1 == NULL)
			{
		
				if ($numero == 0) 
				{
					$_SESSION['tabella0'] = $variabile;
					registrazione_tabella_session();
					
					$_SESSION['campo0'] = NULL;
					registrazione_campo_session();
				
					$_SESSION['operazione0'] = NULL;
					registrazione_oerazione_session();				

					$_SESSION['valoree0'] = NULL;
					registrazione_v_session();					
				}
				else if ($numero == 1)
				{
					$_SESSION['tabella1'] = $variabile;
					registrazione_tabella_session();

					$_SESSION['campo1'] = NULL;
					registrazione_campo_session();
				
					$_SESSION['operazione1'] = NULL;
					registrazione_oerazione_session();				

					$_SESSION['valoree1'] = NULL;
					registrazione_v_session();	
				}
				else if ($numero == 2)
				{
					$_SESSION['tabella2'] = $variabile;
					registrazione_tabella_session();
					
					$_SESSION['campo2'] = NULL;
					registrazione_campo_session();
				
					$_SESSION['operazione2'] = NULL;
					registrazione_oerazione_session();				

					$_SESSION['valoree2'] = NULL;
					registrazione_v_session();					
				}
				else if ($numero == 3)
				{
					$_SESSION['tabella3'] = $variabile;
					registrazione_tabella_session();
					
					$_SESSION['campo3'] = NULL;
					registrazione_campo_session();
				
					$_SESSION['operazione3'] = NULL;
					registrazione_oerazione_session();				

					$_SESSION['valoree3'] = NULL;
					registrazione_v_session();					
				}
				else if ($numero == 4)
				{
					$_SESSION['tabella4'] = $variabile;
					registrazione_tabella_session();
					
					$_SESSION['campo4'] = NULL;
					registrazione_campo_session();
				
					$_SESSION['operazione4'] = NULL;
					registrazione_oerazione_session();				

					$_SESSION['valoree4'] = NULL;
					registrazione_v_session();							
				}
				else if ($numero == 5)
				{
					$_SESSION['tabella5'] = $variabile;
					registrazione_tabella_session();
				
					$_SESSION['campo5'] = NULL;
					registrazione_campo_session();
				
					$_SESSION['operazione5'] = NULL;
					registrazione_oerazione_session();				

					$_SESSION['valoree5'] = NULL;
					registrazione_v_session();					
				}
				else if ($numero == 6)
				{
					$_SESSION['tabella6'] = $variabile;
					registrazione_tabella_session();

					$_SESSION['campo6'] = NULL;
					registrazione_campo_session();
				
					$_SESSION['operazione6'] = NULL;
					registrazione_oerazione_session();				

					$_SESSION['valoree6'] = NULL;
					registrazione_v_session();	
				}
				else if ($numero == 7)
				{
					$_SESSION['tabella7'] = $variabile;
					registrazione_tabella_session();
				
					$_SESSION['campo7'] = NULL;
					registrazione_campo_session();
				
					$_SESSION['operazione7'] = NULL;
					registrazione_oerazione_session();				

					$_SESSION['valoree7'] = NULL;
					registrazione_v_session();					
				}
				else if ($numero == 8)
				{
					$_SESSION['tabella8'] = $variabile;
					registrazione_tabella_session();

					$_SESSION['campo8'] = NULL;
					registrazione_campo_session();
				
					$_SESSION['operazione8'] = NULL;
					registrazione_oerazione_session();				

					$_SESSION['valoree8'] = NULL;
					registrazione_v_session();	
				}
				else if ($numero == 9)
				{
					$_SESSION['tabella9'] = $variabile;
					registrazione_tabella_session();

					$_SESSION['campo9'] = NULL;
					registrazione_campo_session();
				
					$_SESSION['operazione9'] = NULL;
					registrazione_oerazione_session();				

					$_SESSION['valoree9'] = NULL;
					registrazione_v_session();	
				}
			}
			else
			{
				if ($numero1 == 0) 
				{
					$_SESSION['campo0'] = $variabile_campo;
					registrazione_campo_session();

					$_SESSION['operazione0'] = NULL;
					registrazione_oerazione_session();				

					$_SESSION['valoree0'] = NULL;
					registrazione_v_session();	
				}
				else if ($numero1 == 1) 
				{
					$_SESSION['campo1'] = $variabile_campo;
					registrazione_campo_session();

					$_SESSION['operazione1'] = NULL;
					registrazione_oerazione_session();				

					$_SESSION['valoree1'] = NULL;
					registrazione_v_session();	
				}
				else if ($numero1 == 2) 
				{
					$_SESSION['campo2'] = $variabile_campo;
					registrazione_campo_session();

					$_SESSION['operazione2'] = NULL;
					registrazione_oerazione_session();				

					$_SESSION['valoree2'] = NULL;
					registrazione_v_session();	
				}
				else if ($numero1 == 3) 
				{
					$_SESSION['campo3'] = $variabile_campo;
					registrazione_campo_session();

					$_SESSION['operazione3'] = NULL;
					registrazione_oerazione_session();				

					$_SESSION['valoree3'] = NULL;
					registrazione_v_session();	
				}
				else if ($numero1 == 4) 
				{
					$_SESSION['campo4'] = $variabile_campo;
					registrazione_campo_session();

					$_SESSION['operazione4'] = NULL;
					registrazione_oerazione_session();				

					$_SESSION['valoree4'] = NULL;
					registrazione_v_session();	
				}
				else if ($numero1 == 5) 
				{
					$_SESSION['campo5'] = $variabile_campo;
					registrazione_campo_session();

					$_SESSION['operazione5'] = NULL;
					registrazione_oerazione_session();				

					$_SESSION['valoree5'] = NULL;
					registrazione_v_session();	
				}
				else if ($numero1 == 6) 
				{
					$_SESSION['campo6'] = $variabile_campo;
					registrazione_campo_session();

					$_SESSION['operazione6'] = NULL;
					registrazione_oerazione_session();				

					$_SESSION['valoree6'] = NULL;
					registrazione_v_session();	
				}
				else if ($numero1 == 7) 
				{
					$_SESSION['campo7'] = $variabile_campo;
					registrazione_campo_session();

					$_SESSION['operazione7'] = NULL;
					registrazione_oerazione_session();				

					$_SESSION['valoree7'] = NULL;
					registrazione_v_session();		
				}
				else if ($numero1 == 8) 
				{
					$_SESSION['campo8'] = $variabile_campo;
					registrazione_campo_session();

					$_SESSION['operazione8'] = NULL;
					registrazione_oerazione_session();				

					$_SESSION['valoree8'] = NULL;
					registrazione_v_session();	
				}
				else if ($numero1 == 9) 
				{
					$_SESSION['campo9'] = $variabile_campo;
					registrazione_campo_session();

					$_SESSION['operazione9'] = NULL;
					registrazione_oerazione_session();				

					$_SESSION['valoree9'] = NULL;
					registrazione_v_session();	
				}
			} 
		
		}
		else
		{
		
				if ($numero2 == 0) 
				{
					$_SESSION['operazione0'] = $variabile_operazione;
					registrazione_oerazione_session();

					$_SESSION['valoree0'] = NULL;
					registrazione_v_session();	
				}			
				if ($numero2 == 1) 
				{
					$_SESSION['operazione1'] = $variabile_operazione;
					registrazione_oerazione_session();

					$_SESSION['valoree1'] = NULL;
					registrazione_v_session();	
				}	
				if ($numero2 == 2) 
				{
					$_SESSION['operazione2'] = $variabile_operazione;
					registrazione_oerazione_session();

					$_SESSION['valoree2'] = NULL;
					registrazione_v_session();	
				}	
				if ($numero2 == 3) 
				{
					$_SESSION['operazione3'] = $variabile_operazione;
					registrazione_oerazione_session();

					$_SESSION['valoree3'] = NULL;
					registrazione_v_session();	
				}	
				if ($numero2 == 4) 
				{
					$_SESSION['operazione4'] = $variabile_operazione;
					registrazione_oerazione_session();

					$_SESSION['valoree4'] = NULL;
					registrazione_v_session();	
				}	
				if ($numero2 == 5) 
				{
					$_SESSION['operazione5'] = $variabile_operazione;
					registrazione_oerazione_session();

					$_SESSION['valoree5'] = NULL;
					registrazione_v_session();	
				}	
				if ($numero2 == 6) 
				{
					$_SESSION['operazione6'] = $variabile_operazione;
					registrazione_oerazione_session();

					$_SESSION['valoree6'] = NULL;
					registrazione_v_session();	
				}	
				if ($numero2 == 7) 
				{
					$_SESSION['operazione7'] = $variabile_operazione;
					registrazione_oerazione_session();

					$_SESSION['valoree7'] = NULL;
					registrazione_v_session();	
				}	
				if ($numero2 == 8) 
				{
					$_SESSION['operazione8'] = $variabile_operazione;
					registrazione_oerazione_session();

					$_SESSION['valoree8'] = NULL;
					registrazione_v_session();	
				}	
				if ($numero2 == 9) 
				{
					$_SESSION['operazione9'] = $variabile_operazione;
					registrazione_oerazione_session();

					$_SESSION['valoree9'] = NULL;
					registrazione_v_session();	
				}								
		}
							
	}
	else
	{
			if ($numero3 == 0) 
			{
				$_SESSION['valoree0'] = $variabile_valoree;
				registrazione_v_session();
			}			
			if ($numero3 == 1) 
			{
				$_SESSION['valoree1'] = $variabile_valoree;
				registrazione_v_session();
			}	
			if ($numero3 == 2) 
			{
				$_SESSION['valoree2'] = $variabile_valoree;
				registrazione_v_session();
			}	
			if ($numero3 == 3) 
			{
				$_SESSION['valoree3'] = $variabile_valoree;
				registrazione_v_session();
			}	
			if ($numero3 == 4) 
			{
				$_SESSION['valoree4'] = $variabile_valoree;
				registrazione_v_session();
			}	
			if ($numero3 == 5) 
			{
				$_SESSION['valoree5'] = $variabile_valoree;
				registrazione_v_session();
			}	
			if ($numero3 == 6) 
			{
				$_SESSION['valoree6'] = $variabile_valoree;
				registrazione_v_session();
			}	
			if ($numero3 == 7) 
			{
				$_SESSION['valoree7'] = $variabile_valoree;
				registrazione_v_session();
			}	
			if ($numero3 == 8) 
			{
				$_SESSION['valoree8'] = $variabile_valoree;
				registrazione_v_session();
			}	
			if ($numero3 == 9) 
			{
				$_SESSION['valoree9'] = $variabile_valoree;
				registrazione_v_session();
			}	

	}
// *********************************************************************************************************************************************************************************************************************

$nome_tabella1 = $_SESSION['nome_tabella'];
$nome_campo1 = $_SESSION['nome_campo'];
$nome_operazione1 = $_SESSION['nome_operazione'];
$nome_valoree1 = $_SESSION['nome_valoree'];

$tab=new mostra_tabelle();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
// Javascript function *****************************************************************************************************
function tabella_function(link, n)
{
	var nome_tabella=link[link.selectedIndex].value;
	var num = n;

	var destination_page = "ricerca.php";
	location.href = destination_page+"?nome="+nome_tabella+"&numero="+num;
}
function campo_function(link, nn)
{
	var nome_campo=link[link.selectedIndex].value;
	var num1 = nn;

	var destination_page = "ricerca.php";
	location.href = destination_page+"?nome_c="+nome_campo+"&numero1="+num1;
}
function operazione_function(link, nn)
{
	var nome_operazione=link[link.selectedIndex].value;
	var num2 = nn;

	var destination_page = "ricerca.php";
	location.href = destination_page+"?nome_op="+nome_operazione+"&numero2="+num2;
}

function ricerc1(n)
{
	var num3=n;

	if (num3 == 0)
		var data = document.esame.a0.value;
	else if (num3 == 1)
		var data = document.esame.a1.value;
	else if (num3 == 2)
		var data = document.esame.a2.value;
	else if (num3 == 3)
		var data = document.esame.a3.value;		
	else if (num3 == 4)
		var data = document.esame.a4.value;	
	else if (num3 == 5)
		var data = document.esame.a5.value;	
	else if (num3 == 6)
		var data = document.esame.a6.value;	
	else if (num3 == 7)
		var data = document.esame.a7.value;	
	else if (num3 == 8)
		var data = document.esame.a8.value;	
	else if (num3 == 9)
		var data = document.esame.a9.value;	

	var destination_page = "ricerca.php";
	location.href = destination_page+"?nome_val="+data+"&numero3="+num3;	
}

function tabella1_function(link, n)
{
	var nome_tabella=link[link.selectedIndex].value;
	var num3= n;

	var destination_page = "ricerca.php";
	location.href = destination_page+"?nome_val="+nome_tabella+"&numero3="+num3;
}

function tabella2_function(link, n)
{
	var nome_tabella=link[link.selectedIndex].value;
	var num3= n;

	var destination_page = "ricerca.php";
	location.href = destination_page+"?nome_val="+nome_tabella+"&numero3="+num3;
}

function tabella3_function(link, n)
{
	var nome_tabella=link[link.selectedIndex].value;
	var num3= n;

	var destination_page = "ricerca.php";
	location.href = destination_page+"?nome_val="+nome_tabella+"&numero3="+num3;
}

function tabella4_function(link, n)
{
	var nome_tabella=link[link.selectedIndex].value;
	var num3= n;

	var destination_page = "ricerca.php";
	location.href = destination_page+"?nome_val="+nome_tabella+"&numero3="+num3;
}
function tabella5_function(link, n)
{
	var nome_tabella=link[link.selectedIndex].value;
	var num3= n;

	var destination_page = "ricerca.php";
	location.href = destination_page+"?nome_val="+nome_tabella+"&numero3="+num3;
}
function tabella6_function(link, n)
{
	var nome_tabella=link[link.selectedIndex].value;
	var num3= n;

	var destination_page = "ricerca.php";
	location.href = destination_page+"?nome_val="+nome_tabella+"&numero3="+num3;
}
function tabella7_function(link, n)
{
	var nome_tabella=link[link.selectedIndex].value;
	var num3= n;

	var destination_page = "ricerca.php";
	location.href = destination_page+"?nome_val="+nome_tabella+"&numero3="+num3;
}
function tabella8_function(link, n)
{
	var nome_tabella=link[link.selectedIndex].value;
	var num3= n;

	var destination_page = "ricerca.php";
	location.href = destination_page+"?nome_val="+nome_tabella+"&numero3="+num3;
}
function tabella9_function(link, n)
{
	var nome_tabella=link[link.selectedIndex].value;
	var num3= n;

	var destination_page = "ricerca.php";
	location.href = destination_page+"?nome_val="+nome_tabella+"&numero3="+num3;
}
function tabella10_function(link, n)
{
	var nome_tabella=link[link.selectedIndex].value;
	var num3= n;

	var destination_page = "ricerca.php";
	location.href = destination_page+"?nome_val="+nome_tabella+"&numero3="+num3;
}
function tabella11_function(link, n)
{
	var nome_tabella=link[link.selectedIndex].value;
	var num3= n;

	var destination_page = "ricerca.php";
	location.href = destination_page+"?nome_val="+nome_tabella+"&numero3="+num3;
}
function tabella12_function(link, n)
{
	var nome_tabella=link[link.selectedIndex].value;
	var num3= n;

	var destination_page = "ricerca.php";
	location.href = destination_page+"?nome_val="+nome_tabella+"&numero3="+num3;
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="style.css">
<title></title>
</head>
<body>
<div align="center">
<font id="font2">				
Research and Statistics
</font>
<br /><br />
<form action="motore_ricerca.php" method="post" style="display:inline" name="esame">

<!-- RICERCA PER NOME, COGNOME E DATA DI NASCITA DEL PAZIENTE ************************************************************* -->
<div id='ricerca_anagrafica_paziente'>
	<font size='5'>Patient's Research </font><br /><br />
	
	<input type="text" name='valore_anagrafica' size="30" />  &nbsp; &nbsp;  &nbsp; &nbsp; <input type="submit" value='GO' name='ricerca_anagrafica' /><br />
	<input type='radio' name='tipo_anagrafica' value='cognome' checked='checked'/>Lastname
	<input type='radio' name='tipo_anagrafica' value='nome'/>Name
	<input type='radio' name='tipo_anagrafica' value='data_nascita'/>Date of birth
	<input type='radio' name='tipo_anagrafica' value='sesso'/>Sex	
	<br /><BR />
	
	<div align="left">
		<font size='2' color="#333300"> &nbsp; Birth date in dd/mm/yyyy; sex M / F</font>
	</div>

</div>
<!-- ********************************************************************************************************************* -->

<br /><br />

<!-- RICERCA AVANZATA ***************************************************************************************************** -->
<div id='ricerca_avanzata'>
	<font size='5'>Advanced Research </font><br /><br />
	
	<table border="0" width="90%" cellpadding="1" cellspacing="1">
		<tr>
			<td width="25%" id='font3' bgcolor="#006699" align="center">Table </td>
			<td width="25%" id='font3' bgcolor="#006699" align="center">Field </td>
			<td width="15%" id='font3' bgcolor="#006699" align="center">Operation </td>
			<td width="35%" id='font3' bgcolor="#006699" align="center">Value </td>
		</tr>
	</table>


	<?php
	for ($qq=0; $qq<10; $qq++)
	{  
	?>

		<table border="0" width="90%" cellpadding="1" cellspacing="1">
			<tr>
				<td width="25%" align="center">
					<select name='tabella' size='1' cols='10' onChange="tabella_function(this, '<?php print $qq; ?>')">
					<?php 
					$tab->retrive();
					// numero di tabelle presenti nel database:
					$n_tab = $tab->getNumero_tabelle();
	
					if ($nome_tabella1[$qq] != NULL)
					{
					
						if ($nome_tabella1[$qq] == 'chemioterapia')
							$nome_tabella2= 'Chemotherapy';	
						else if ($nome_tabella1[$qq] == 'anagrafica')
							$nome_tabella2= 'Patient\'s Registry';								
						else if ($nome_tabella1[$qq] == 'esame_tc')
							$nome_tabella2= 'TC scan';				
						else if ($nome_tabella1[$qq] == 'inserimento')
							$nome_tabella2= 'Insertion date';							
						else if ($nome_tabella1[$qq] == 'intervento')
							$nome_tabella2= 'Medical Surgery';							
						else if ($nome_tabella1[$qq] == 'istologia')
							$nome_tabella2= 'Histological diagnosis';						
						else if ($nome_tabella1[$qq] == 'permeabilita')
							$nome_tabella2= 'Permeability';
						else if ($nome_tabella1[$qq] == 'rm_morfologica')
							$nome_tabella2= 'Morphological RM';							
						else if ($nome_tabella1[$qq] == 'rm_perfusione')
							$nome_tabella2= 'Perfusion';														
						else if ($nome_tabella1[$qq] == 'rm_spettroscopica')
							$nome_tabella2= 'Spectroscopy';							
						else if ($nome_tabella1[$qq] == 'sintomi')
							$nome_tabella2= 'Clinical Presentation';					
						else if ($nome_tabella1[$qq] == 'terapia')
							$nome_tabella2= 'Medical teraphy';		
						else
							$nome_tabella2 = ucfirst($nome_tabella1[$qq]);

						print ("<OPTION VALUE='$nome_tabella1[$qq]'>$nome_tabella2</OPTION>");
					}					
					
					print ("<OPTION VALUE=''>-</OPTION>");
					print ("<OPTION VALUE='anagrafica'>Patient's Registry</OPTION>");

					for ($i=0; $i<$n_tab; $i++)
					{
						$nome_tab = $tab->getNome_tabella($i);
						
						if ( ($nome_tab == 'files') || ($nome_tab == 'tumors') || ($nome_tab == 'tumors_prov'));
						else
						{
							if ($nome_tab == 'chemioterapia')
								$nome_tab2= 'Chemotherapy';	
							else if ($nome_tab == 'esame_tc')
								$nome_tab2= 'TC scan';		
							else if ($nome_tab == 'inserimento')
								$nome_tab2= 'Insertion Date';								
							else if ($nome_tab == 'intervento')
								$nome_tab2= 'Medical Surgery';								
							else if ($nome_tab == 'istologia')
								$nome_tab2= 'Histological diagnosis';								
							else if ($nome_tab == 'permeabilita')
								$nome_tab2= 'Permeability';							
							else if ($nome_tab == 'rm_morfologica')
								$nome_tab2= 'Morphological RM';								
							else if ($nome_tab == 'rm_perfusione')
								$nome_tab2= 'Perfusion';									
							else if ($nome_tab == 'rm_spettroscopica')
								$nome_tab2= 'Spectroscopy';								
							else if ($nome_tab == 'sintomi')
								$nome_tab2= 'Clinical Presentation';							
							else if ($nome_tab == 'terapia')
								$nome_tab2= 'Medical therapy';								
							else
								$nome_tab2 = ucfirst($nome_tab);

							print ("<OPTION VALUE='$nome_tab'>$nome_tab2</OPTION>");
						}
					}
					?>
					</select>		
				</td>

				<td width="25%" align="center">
					<select name='campo' size='1' cols='10' onChange="campo_function(this, '<?php print $qq; ?>')">
					<?php
						if ($nome_campo1[$qq] != NULL)
						{
		
							if ($nome_tabella1[$qq] == 'chemioterapia')
									$campo_modificato2 = nomi_chemioterapia($nome_campo1[$qq]);									
							else if ($nome_tabella1[$qq] == 'anagrafica')
									$campo_modificato2 = nomi_anagrafica($nome_campo1[$qq]);													
							else if ($nome_tabella1[$qq] == 'esame_tc')
									$campo_modificato2 = nomi_esame_tc($nome_campo1[$qq]);						
							else if ($nome_tabella1[$qq] == 'inserimento')
									$campo_modificato2 = 'Insertion Date';							
							else if ($nome_tabella1[$qq] == 'intervento')
									$campo_modificato2 = nomi_intervento($nome_campo1[$qq]);							
							else if ($nome_tabella1[$qq] == 'istologia')
									$campo_modificato2 = nomi_istologia($nome_campo1[$qq]);						
							else if ($nome_tabella1[$qq] == 'permeabilita')
									$campo_modificato2 = nomi_permeabilita($nome_campo1[$qq]);							
							else if ($nome_tabella1[$qq] == 'rm_bold')
									$campo_modificato2 = nomi_rm_bold($nome_campo1[$qq]);							
							else if ($nome_tabella1[$qq] == 'rm_dti')
									$campo_modificato2 = nomi_rm_dti($nome_campo1[$qq]);							
							else if ($nome_tabella1[$qq] == 'rm_morfologica')
									$campo_modificato2 = nomi_rm_morfologica($nome_campo1[$qq]);							
							else if ($nome_tabella1[$qq] == 'rm_perfusione')
									$campo_modificato2 = nomi_rm_perfusione($nome_campo1[$qq]);
							else if ($nome_tabella1[$qq] == 'rm_spettroscopica')
									$campo_modificato2 = nomi_rm_spettroscopica($nome_campo1[$qq]);					
							else if ($nome_tabella1[$qq] == 'sintomi')
									$campo_modificato2 = nomi_sintomi($nome_campo1[$qq]);						
							else if ($nome_tabella1[$qq] == 'terapia')
									$campo_modificato2 = nomi_terapia($nome_campo1[$qq]);				
	
							print ("<OPTION VALUE='$nome_campo1[$qq]'>$campo_modificato2</OPTION>");
						
						}
						print ("<OPTION VALUE=''>--</OPTION>");
	
						if ($nome_tabella1[$qq] == 'anagrafica')  // solo per tabella anagrafica
						{	
							print ("<OPTION VALUE='eta'>Age</OPTION>");	
							print ("<OPTION VALUE='data_decesso'>Date of death</OPTION>");
							print ("<OPTION VALUE='reparto_provenienza'>Origin Department</OPTION>");
							print ("<OPTION VALUE='sex'>Sex</OPTION>");
						}
						else
						{
							$query = "SHOW COLUMNS FROM $nome_tabella1[$qq] FROM my_tumorsdatabase";						
							$rs = mysql_query($query);
							while(list($field) = mysql_fetch_row($rs))
							{
								if ( ($field == 'id') || ($field == 'id_paziente') );
								else
								{
									if ($nome_tabella1[$qq] == 'chemioterapia')
										$field_modificato = nomi_chemioterapia($field);
									else if ($nome_tabella1[$qq] == 'esame_tc')
										$field_modificato  = nomi_esame_tc($field);		
									else if ($nome_tabella1[$qq] == 'inserimento')
										$field_modificato  = 'Insertion Date';			
									else if ($nome_tabella1[$qq] == 'intervento')
										$field_modificato  = nomi_intervento($field);		
									else if ($nome_tabella1[$qq] == 'istologia')
										$field_modificato  = nomi_istologia($field);		
									else if ($nome_tabella1[$qq] == 'permeabilita')
										$field_modificato  = nomi_permeabilita($field);							
									else if ($nome_tabella1[$qq] == 'rm_bold')
										$field_modificato  = nomi_rm_bold($field);							
									else if ($nome_tabella1[$qq] == 'rm_dti')
										$field_modificato  = nomi_rm_dti($field);
									else if ($nome_tabella1[$qq] == 'rm_morfologica')
										$field_modificato  = nomi_rm_morfologica($field);
									else if ($nome_tabella1[$qq] == 'rm_perfusione')
										$field_modificato  = nomi_rm_perfusione($field);
									else if ($nome_tabella1[$qq] == 'rm_spettroscopica')
										$field_modificato  = nomi_rm_spettroscopica($field);
									else if ($nome_tabella1[$qq] == 'sintomi')
										$field_modificato  = nomi_sintomi($field);
									else if ($nome_tabella1[$qq] == 'terapia')
										$field_modificato  = nomi_terapia($field);
	
										print ("<OPTION VALUE='$field'>$field_modificato</OPTION>");		
								}
							}
						
						}
					?>
					</select>		
				 </td>
				 
				<td width="15%" align="center">
				<select name='operazione' size='1' cols='10' onChange="operazione_function(this, '<?php print $qq; ?>')">
				<?php 
				$operazione1= operazione($nome_campo1[$qq]);
	
				if ($nome_operazione1[$qq] != NULL)
				{
					if ($nome_operazione1[$qq] == 'uguale')
						$opp = ' = ';	
					else if ($nome_operazione1[$qq] == 'maggiore')
						$opp = ' > ';	
					else if ($nome_operazione1[$qq] == 'minore')
						$opp = ' < ';
					else if ($nome_operazione1[$qq] == 'maggiore_uguale')
						$opp = ' >= ';			
					else if ($nome_operazione1[$qq] == 'minore_uguale')
						$opp = ' <= ';					
					else if ($nome_operazione1[$qq] == 'diverso')
						$opp = ' != ';				
					else if ($nome_operazione1[$qq] == 'between')
						$opp = ' TRA ';					
					else if ($nome_operazione1[$qq] == 'simile')
						$opp = ' &#126; ';					
							
					print ("<OPTION VALUE='$nome_operazione1[$qq]'> $opp </OPTION>");
					print ("<OPTION VALUE=''></OPTION>");
				}

				// scelta di tutte le operazioni
				print ("<OPTION VALUE=''> </OPTION>");
				if ($operazione1 == 1) 
				{					
					print ("<OPTION VALUE='uguale'> = </OPTION>");
					print ("<OPTION VALUE='maggiore'> > </OPTION>");
					print ("<OPTION VALUE='minore'> < </OPTION>");
					print ("<OPTION VALUE='maggiore_uguale'> >= </OPTION>");
					print ("<OPTION VALUE='minore_uguale'> <= </OPTION>");
					print ("<OPTION VALUE='diverso'> != </OPTION>");
				}
				else if ($operazione1 == 2) 
				{
					print ("<OPTION VALUE='simile'> &#126; </OPTION>");
					print ("<OPTION VALUE='diverso'> != </OPTION>");
				}	
				else if ($operazione1 == 3) 
				{
					print ("<OPTION VALUE='uguale'> = </OPTION>");
				}								
				else if ($operazione1 == 4) 
				{
					print ("<OPTION VALUE='circa'> &#126; </OPTION>");
				}	
				else
					print ("<OPTION VALUE=''></OPTION>");
				?>
				</select>				
				 </td>
				<td width="35%" align="center">

				<?php 
				$tipo_valore = valore($nome_campo1[$qq], $nome_operazione1[$qq]);
			
				if  ( ($tipo_valore == 0) || ($tipo_valore == 1) )
				{
					if ($qq == 0)
						print ("<input type='text' name=\"a0\" value='$nome_valoree1[0]' size='20' onchange=\"ricerc1('$qq')\" />");
					else if ($qq == 1)
						print ("<input type='text' name=\"a1\" value='$nome_valoree1[1]' size='20' onchange=\"ricerc1('$qq')\" />");			
					else if ($qq == 2)
						print ("<input type='text' name=\"a2\" value='$nome_valoree1[2]' size='20' onchange=\"ricerc1('$qq')\" />");					
					else if ($qq == 3)
						print ("<input type='text' name=\"a3\" value='$nome_valoree1[3]' size='20' onchange=\"ricerc1('$qq')\" />");					
					else if ($qq == 4)
						print ("<input type='text' name=\"a4\" value='$nome_valoree1[4]' size='20' onchange=\"ricerc1('$qq')\" />");	
					else if ($qq == 5)
						print ("<input type='text' name=\"a5\" value='$nome_valoree1[5]' size='20' onchange=\"ricerc1('$qq')\" />");	
					else if ($qq == 6)
						print ("<input type='text' name=\"a6\" value='$nome_valoree1[6]' size='20' onchange=\"ricerc1('$qq')\" />");	
					else if ($qq == 7)
						print ("<input type='text' name=\"a7\" value='$nome_valoree1[7]' size='20' onchange=\"ricerc1('$qq')\" />");	
					else if ($qq == 8)
						print ("<input type='text' name=\"a8\" value='$nome_valoree1[8]' size='20' onchange=\"ricerc1('$qq')\" />");	
					else if ($qq == 9)
						print ("<input type='text' name=\"a9\" value='$nome_valoree1[9]' size='20' onchange=\"ricerc1('$qq')\" />");	
				}				
				else if ($tipo_valore == 2)
				{
					print ("<select name='reparto_provenienza' size='1' cols='10' onChange=\"tabella1_function(this, '$qq')\">	");
					
					if ($nome_valoree1[$qq] != NULL)
					{	
						$val_1 = ucfirst($nome_valoree1[$qq]);
						
						if ($nome_valoree1[$qq] == 'neurochirurgia')
							$val_1 = 'Neuroradiology';
						if ($nome_valoree1[$qq] == 'neurologia')
							$val_1 = 'Neurology';						
						if ($nome_valoree1[$qq] == 'pronto_soccorso')
							$val_1 = 'E.R.';	
						if ($nome_valoree1[$qq] == 'altro')
							$val_1 = 'Other';							
													
						print ("<OPTION VALUE='$nome_valoree1[$qq]'>$val_1</OPTION>");
					}
					print ("<OPTION VALUE=''> </OPTION>
					<OPTION VALUE='neurochirurgia'>Neuroradiology</OPTION>
					<OPTION VALUE='neurologia'>Neurology</OPTION>		
					<OPTION VALUE='pronto_soccorso'>E.R.</OPTION>
					<OPTION VALUE='altro'>Other</OPTION>			
					</select>	
					");
				}	
			
				else if ($tipo_valore == 3)
				{
					print ("<select name='si_no' size='1' cols='10' onChange=\"tabella2_function(this, '$qq')\">");
					
					if ($nome_valoree1[$qq] != NULL)
					{	
						$val_1=strtoupper($nome_valoree1[$qq]);
						print ("<OPTION VALUE='$nome_valoree1[$qq]'>$val_1</OPTION>");
					}
					print ("
					<OPTION VALUE=''> </OPTION>
					<OPTION VALUE='si'> YES </OPTION>			
					<OPTION VALUE='no'> NO </OPTION>
					</select>
					");
				}		
				else if ($tipo_valore == 4)
				{
					print ("<select name='tipo_contrasto' size='1' cols='10' onChange=\"tabella3_function(this, '$qq')\" >");
					if ($nome_valoree1[$qq] != NULL)
					{	
						$val_1 = ucfirst($nome_valoree1[$qq]);
						
						if ($nome_valoree1[$qq] == 'omogeneo')
							$val_1 = 'Homogeneous';
						if ($nome_valoree1[$qq] == 'disomogeneo')
							$val_1 = 'Inhomogeneous';						
						if ($nome_valoree1[$qq] == 'ad_anello')
							$val_1 = 'Ring';							
						
						print ("<OPTION VALUE='$nome_valoree1[$qq]'>$val_1</OPTION>");
					}
										
					print ("	
					<OPTION VALUE=''> </OPTION>
					<OPTION VALUE='omogeneo'> Homogeneous </OPTION>			
					<OPTION VALUE='disomogeneo'> Inhomogeneous </OPTION>
					<OPTION VALUE='ad_anello'> Ring </OPTION>					
					</select>
					");
				}				
				else if ($tipo_valore == 5)
				{
					print ("<select name='sede1' size='1' cols='10' onChange=\"tabella4_function(this, '$qq')\">");	
					if ($nome_valoree1[$qq] != NULL)
					{	
						print ("<OPTION VALUE='$nome_valoree1[$qq]'>$nome_valoree1[$qq]</OPTION>");
					}					
					
					$query ="SELECT sede FROM sede";
					$rs = mysql_query($query);
					print ("<OPTION VALUE=''> </OPTION>");
					while(list($sede) = mysql_fetch_row($rs))
					{	
						print ("<OPTION VALUE='$sede'>$sede</OPTION>");
					}	
					print ("</select>");
				}					
				else if ($tipo_valore == 6)
				{
					print ("<select name='sede_motoria' size='1' cols='10' onChange=\"tabella5_function(this, '$qq')\" >");
					if ($nome_valoree1[$qq] != NULL)
					{	
						$val_1 = ucfirst($nome_valoree1[$qq]);			
						print ("<OPTION VALUE='$nome_valoree1[$qq]'>$val_1</OPTION>");
						
						if ($nome_valoree1[$qq] == 'mano')
							$val_1 = 'Hand';
						if ($nome_valoree1[$qq] == 'piede')
							$val_1 = 'Foot';							
					}						
					print ("
					<OPTION VALUE=''> </OPTION>
					<OPTION VALUE='mano'> Hand </OPTION>			
					<OPTION VALUE='piede'> Foot </OPTION>				
					</select>
					");
				}						
				else if ($tipo_valore == 7)
				{
					print ("<select name='sede_sensitiva' size='1' cols='10' onChange=\"tabella6_function(this, '$qq')\" >");
					if ($nome_valoree1[$qq] != NULL)
					{	
					
						if ($nome_valoree1[$qq] == 'mano')
							$val_1 = 'Hand';
						if ($nome_valoree1[$qq] == 'piede')
							$val_1 = 'Foot';
						if ($nome_valoree1[$qq] == 'altro')
							$val_1 = 'Other';							
												
						$val_1 = ucfirst($nome_valoree1[$qq]);						
						print ("<OPTION VALUE='$nome_valoree1[$qq]'>$val_1</OPTION>");
					}									
					print ("	
					<OPTION VALUE=''> </OPTION>
					<OPTION VALUE='mano'> Hand </OPTION>			
					<OPTION VALUE='piede'> Foot </OPTION>				
					<OPTION VALUE='altro'> Other </OPTION>	
					</select>
					");
				}		
				else if ($tipo_valore == 8)
				{
					print ("<select name='valore_dwi' size='1' cols='10' onChange=\"tabella6_function(this, '$qq')\"> ");	
					if ($nome_valoree1[$qq] != NULL)
					{	$val_1=strtoupper($nome_valoree1[$qq]);
						print ("<OPTION VALUE='$nome_valoree1[$qq]'>$val_1</OPTION>");
					}						
					print("
					<OPTION VALUE=''> </OPTION>
					<OPTION VALUE='iper'> IPER </OPTION>			
					<OPTION VALUE='ipo'> IPO </OPTION>				
					<OPTION VALUE='normale'> NORMAL </OPTION>	
					</select>
					");
				}					
				else if ($tipo_valore == 9)
				{
					print ("<select name='valore_adc1' size='1' cols='10' onChange=\"tabella7_function(this, '$qq')\"> ");
					if ($nome_valoree1[$qq] != NULL)
					{	
						$val_1 = ucfirst($nome_valoree1[$qq]);	
						
						if ($nome_valoree1[$qq] == 'ridotta')
							$val_1 = 'Reduced';
						if ($nome_valoree1[$qq] == 'aumentata')
							$val_1 = 'Increased';	
													
						print ("<OPTION VALUE='$nome_valoree1[$qq]'>$val_1</OPTION>");
					}										
					print ("	
					<OPTION VALUE=''> </OPTION>
					<OPTION VALUE='ridotta'>  Reduced </OPTION>			
					<OPTION VALUE='aumentata'> Increased </OPTION>				
					</select>
					");
				}						
				else if ($tipo_valore == 10)
				{
					print ("<select name='valore_cbv1' size='1' cols='10' onChange=\"tabella8_function(this, '$qq')\">	");
					if ($nome_valoree1[$qq] != NULL)
					{	
						if ($nome_valoree1[$qq] == 'inf')
							$val_1 = ' < 1.75';
						if ($nome_valoree1[$qq] == 'sup')
							$val_1 = ' > 1.75';
												
						print ("<OPTION VALUE='$nome_valoree1[$qq]'>$val_1</OPTION>");
					}					
					print ("
					<OPTION VALUE=''> </OPTION>
					<OPTION VALUE='inf'> < 1.75</OPTION>			
					<OPTION VALUE='sup'> > 1.75</OPTION>				
					</select>
					");
				}				
				else if ($tipo_valore == 11)
				{
					print ("<select name='valore_te1' size='1' cols='10' onChange=\"tabella9_function(this, '$qq')\">");
					if ($nome_valoree1[$qq] != NULL)
					{	
						$val_1 = ucfirst($nome_valoree1[$qq]);	
						
						if ($nome_valoree1[$qq] == 'breve')
							$val_1 = 'Short';
						if ($nome_valoree1[$qq] == 'intermedio')
							$val_1 = 'Intermediate';
						if ($nome_valoree1[$qq] == 'lungo')
							$val_1 = 'Long';
																				
						print ("<OPTION VALUE='$nome_valoree1[$qq]'>$val_1</OPTION>");
					}						
					print ("	
					<OPTION VALUE=''> </OPTION>
					<OPTION VALUE='breve'> Short </OPTION>			
					<OPTION VALUE='intermedio'> Intermediate </OPTION>				
					<OPTION VALUE='lungo'> Long </OPTION>	
					</select>
					");
				}			
				else if ($tipo_valore == 12)
				{
					print ("<select name='valore_data_sintomi' size='1' cols='10' onChange=\"tabella10_function(this, '$qq')\">");
					if ($nome_valoree1[$qq] != NULL)
					{	
						$val_1 = ucfirst($nome_valoree1[$qq]);	

						if ($nome_valoree1[$qq] == 'ultima_settimana')
							$val_1 = 'Last week';
						if ($nome_valoree1[$qq] == 'ultimo_mese')
							$val_1 = 'Last month';
						if ($nome_valoree1[$qq] == 'ultimi_sei_mesi')
							$val_1 = 'Last 6 months';
						if ($nome_valoree1[$qq] == 'piu_sei_mesi')
							$val_1 = 'More than 6 months';
																				
						print ("<OPTION VALUE='$nome_valoree1[$qq]'>$val_1</OPTION>");
					}					
					print ("
					<OPTION VALUE=''> </OPTION>
					<OPTION VALUE='ultima_settimana'>Last week</OPTION>
					<OPTION VALUE='ultimo_mese'>Last month</OPTION>
					<OPTION VALUE='ultimi_sei_mesi'>Last 6 months</OPTION>
					<OPTION VALUE='piu_sei_mesi'>More than 6 months</OPTION>	
					</select>
					");
				}	
				else if ($tipo_valore == 13)
				{
					print ("<select name='valore_data_dti' size='1' cols='10' onChange=\"tabella11_function(this, '$qq')\">");
					if ($nome_valoree1[$qq] != NULL)
					{	
						$val_1 = ucfirst($nome_valoree1[$qq]);	
						
						if ($nome_valoree1[$qq] == 'infiltrato')
							$val_1 = 'Infiltrated';
						if ($nome_valoree1[$qq] == 'compresso')
							$val_1 = 'Compressed';
													
						print ("<OPTION VALUE='$nome_valoree1[$qq]'>$val_1</OPTION>");
					}					
					print ("
					<OPTION VALUE=''> </OPTION>
					<OPTION VALUE='infiltrato'>Infiltrated</OPTION>
					<OPTION VALUE='compresso'>Compressed</OPTION>
					</select>
					");
				}	
				else if ($tipo_valore == 14)
				{
					print ("<select name='valore_sex' size='1' cols='10' onChange=\"tabella12_function(this, '$qq')\">");
					if ($nome_valoree1[$qq] != NULL)
					{	
						$val_1 = ucfirst($nome_valoree1[$qq]);	
						print ("<OPTION VALUE='$nome_valoree1[$qq]'>$val_1</OPTION>");
					}					
					print ("
					<OPTION VALUE=''> </OPTION>
					<OPTION VALUE='M'>M</OPTION>
					<OPTION VALUE='F'>F</OPTION>
					</select>
					");
				}
				else 
					print ("<input type='text' name='valore_ricerca' value='' size='20'>");							
				?>
				 </td>
				 
			</tr>
		</table>

	<?php
	}
	?>
	</form>
	<br /><br />
	<form action="ricerca.php?delete_session=1" method="post" style="display:inline">
	<input type="submit" name='reset_1' value='Delete data' id='form3'/>
	</form>
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
	<form action="motore_ricerca.php" method="post" style="display:inline">
	<input type="radio" name='and_or' value='and' checked="checked" />AND 
	<input type="radio" name='and_or' value='or' />OR  &nbsp; &nbsp;
	<input type="submit" name='ricerca_avanzata' value='Submit' id='form2'/>
	<br /><br />	
</div>
<!-- ********************************************************************************************************************* -->

<br />
</div>
</body>
</html>