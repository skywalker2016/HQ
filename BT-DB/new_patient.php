<?php
session_start();
include ("accesso_db.php");

$pagina = 2;
include ("log.php");

if ($permission == NULL)
	header("Location:errore.html");
	
include ("convertitore_date.php");
include ("function_php/try_format_date.php");
require_once('class/class.patient.php');
require_once('class/class.dataExamInsert.php');
require_once('class/class.sintomi.php');

// script to check the FORM's data and insert the patient in the database: +++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
if ($_REQUEST['insert_patient'])
{

	$data_inserimento= $_REQUEST['data_inserimento'];
	$surname= $_REQUEST['surname'];
	$name= $_REQUEST['name'];
	$date_birthday= $_REQUEST['date_birthday'];
	$sex= $_REQUEST['sex'];
	$address= $_REQUEST['address'];
	$telephone= $_REQUEST['telephone'];
	$note_paziente= $_REQUEST['note_paziente'];	
	$sintomi_date= $_REQUEST['sintomi_date'];
	$deficit= $_REQUEST['deficit'];
	$deficit_motorio= $_REQUEST['deficit_motorio'];	
	$crisi_epilettica= $_REQUEST['crisi_epilettica'];
	$sintomi_note= $_REQUEST['sintomi_note'];
	$reparto_provenienza_altro = $_REQUEST['reparto_provenienza_altro'];	
	$disturbi_comportamentali = $_REQUEST['disturbi_comportamentali'];	
	$cefalea= $_REQUEST['cefalea'];	
	$sintomi_altro= $_REQUEST['sintomi_altro'];		
	
	// controlla le date:
	$errore_data_inserimento1 = controllo_data($data_inserimento);
	$errore_data_nascita1 = controllo_data($date_birthday);

	if ($reparto_provenienza_altro != NULL)
		$reparto_provenienza = $reparto_provenienza_altro;
	else	
		$reparto_provenienza = $_REQUEST['reparto_provenienza'];

	$paziente = new patient(NULL, $surname, $name);
	$paziente->SetData_nascita($date_birthday);
	
	$paziente->setSex($sex);
	$paziente->setAddress($address);
	$paziente->setTelephone($telephone);
	$paziente->setNote($note_paziente);
	$paziente->setReparto_provenienza($reparto_provenienza);	

	$insert_date = new dataExamInsert($data_inserimento);

	$sintomi = new sintomi(NULL);	
	$sintomi->setDeficit($deficit);
	$sintomi->setDeficit_motorio($deficit_motorio);	
	$sintomi->setCrisi_epilettica($crisi_epilettica);	
	$sintomi->setNote($sintomi_note);		
	$sintomi->setData_sintomi($sintomi_date);
	$sintomi->setDisturbi_comportamento($disturbi_comportamentali);	
	$sintomi->setCefalea($cefalea);
	$sintomi->setSintomi_altro($sintomi_altro);		
		
	if (($errore_data_inserimento1 == 1) || ($error_surname == 1) || ($error_name == 1) || ($errore_data_nascita1 == 1) || ($errore_data_sintomi == 1));
	else
	{
		// Before to insert the data in the database, it cheks if the patient is already present.
		$paziente->retrive($surname, $name, $date_birthday);
		$id_paziente_check =$paziente->getID_paziente(); 

		if ($id_paziente_check == NULL)
		{
			$paziente->insert();   // Insert the patient's data
			$id_patient = $paziente->getID_paziente();  // Retrive the ID for the patient just inserted
			$_SESSION['id_paziente_session'] = $id_patient;
	  					
			$insert_date->insert($id_patient);  // Insert the 'inserimento' date
			$data_inserimento=$insert_date->getData_inserimento(); // Retrive the ID for the 'inserimento'		
			$data_inserimento1= data_convert_for_mysql($data_inserimento);

			$id_data_inserimento=$insert_date->getID_data_inserimento(); // Retrive the ID for the 'inserimento'
			$_SESSION['id_inserimento_session'] = $id_data_inserimento;	
			
			$sintomi->insert($id_patient, $data_inserimento1);  // Insert i sintomi	
			
			header( "Location: conferma_inserimento.php?id_paziente=$id_patient");   // Page to insert the TC and RM exams 
		}
	}
}
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="style.css">
<title></title>
</head>
<body>
<div align="center">
<font id="font2">
Patient personal data
</font>
<br />
<?php
if (($errore_data_inserimento == 1) || ($error_surname == 1) || ($error_name == 1) || ($errore_data_nascita == 1) || ($errore_data_sintomi == 1))
	print ("<font id='font4'>You did not insert a require fields or date format is not correct </font><br>");

if ($id_paziente_check != NULL)
	print ("<font id='font4'>This patient is already present in the database. The data are not inserted </font><br>");
	
if ($error == 1)
	print ("<font id='font4'>There was an error. The data are not inserted in the database<br>
	Contact the administrator.</font><br>");	
?>
<br />
<form action="new_patient.php" style="display:inline">

<div id='nuovo_paziente'>
		<br />
		<table border="0" width="80%" cellpadding="0" cellspacing="0">
			<tr>
				<td width="30%" align="right"><font id="font8"><strong>Date*</strong> </font>&nbsp;</td>
				<td width="70%" align="left">
				<select name="byear">
				    <option value="1930" selected>1930</option>
				    <script language="JavaScripe">
					     var tmp_now=new Date();
						 for(i=1931;i<=tmp_now.getFullYear();i++)
						 {
							 document.write("<option value='"+i+"'"+">"+i+"</option>")
						 }
					</script>
				</select>
				/
				<select name="bmonth">
				    <option value="01" selected>1</option>
					<option value="02">2</option>
					<option value="03">3</option>
					<option value="04">4</option>
					<option value="05">5</option>
					<option value="06">6</option>
					<option value="07">7</option>
					<option value="08">8</option>
					<option value="09">9</option>
					<option value="10">10</option>
					<option value="11">11</option>
					<option value="12">12</option>
				</select>
				/
				<select name="bday">
				    <option value="01" selected>1</option>
					<option value="02">2</option>
					<option value="03">3</option>
					<option value="04">4</option>
					<option value="05">5</option>
					<option value="06">6</option>
					<option value="07">7</option>
					<option value="08">8</option>
					<option value="09">9</option>
					<option value="10">10</option>
					<option value="11">11</option>
					<option value="12">12</option>
					<option value="13">13</option>
					<option value="14">14</option>
					<option value="15">15</option>
					<option value="16">16</option>
					<option value="17">17</option>
					<option value="18">18</option>
					<option value="19">19</option>
					<option value="20">20</option>
					<option value="21">21</option>
					<option value="22">22</option>
					<option value="23">23</option>
					<option value="24">24</option>
					<option value="25">25</option>
					<option value="26">26</option>
					<option value="27">27</option>
					<option value="28">28</option>
					<option value="29">29</option>
					<option value="30">30</option>
					<option value="31">31</option>
				</select>
				<?php 
				/*if ($errore_data_inserimento1 == 1)
					print ("<input type='text' name='data_inserimento' value='' id='form1_A' size='11'/>");
				else
					print ("<input type='text' name='data_inserimento' value='$data_inserimento' id='form1' size='11'/>");*/
				?>		
				 <font id="font4">aaaa/mm/gg</font>
				 </td>
			</tr>
			<tr>
				<td width="30%" align="right"><font id="font3"><strong>Last name*</strong> </font>&nbsp;</td>
				<td width="70%" align="left">
				<?php 
				if ($error_surname == 1)
					print ("<input type='text' name='surname' id='form1_A' size='52'/>");
				else
				{
					if ($id_paziente_check != NULL)
						print ("<input type='text' name='surname' value='$surname' id='form1_B' size='52'/>");
					else
						print ("<input type='text' name='surname' value='$surname' id='form1' size='52'/>");
				}		
				?>
				</td>
			</tr>
			<tr>
				<td width="30%" align="right"><font id="font3"><strong>Name*</strong> </font>&nbsp;</td>
				<td width="70%" align="left">
				<?php 
				if ($error_name == 1)
					print ("<input type='text' name='name' id='form1_A' size='52'/>");
				else
				{
					if ($id_paziente_check != NULL)
						print ("<input type='text' name='name' value='$name' id='form1_B' size='52'/>");
					else
						print ("<input type='text' name='name' value='$name' id='form1' size='52'/>");
				}		
				?>
				</td>
			</tr>
			<tr>
				<td width="30%" align="right"><font id="font3"><strong>Date of Birth*</strong> </font>&nbsp;</td>
				<td width="70%" align="left">
				<?php 
				if ($errore_data_nascita1 == 1)
					print ("<input type='text' name='date_birthday' value='' id='form1_A' size='11'/>");
				else
				{
					if ($id_paziente_check != NULL)
						print ("<input type='text' name='date_birthday' value='$date_birthday' id='form1_B' size='11'/>");
					else
						print ("<input type='text' name='date_birthday' value='$date_birthday' id='form1' size='11'/>");
				}		
				?>				
				 <font id="font4">gg/mm/aaaa</font></td>
			</tr>
			<tr>
				<td width="30%" align="right"><font id="font3"><strong>Sex</strong> </font>&nbsp;</td>
				<td width="70%" align="left">
				<?php
				if ($sex == 'M')
				{
					print ("<input type='radio' name='sex' value='M' checked='checked'/><font id='font3'>M</font> &nbsp;");
					print ("<input type='radio' name='sex' value='F' /><font id='font3'>F</font>");
				}
				else if ($sex == 'F')
				{
					print ("<input type='radio' name='sex' value='M' /><font id='font3'>M</font> &nbsp;");
					print ("<input type='radio' name='sex' value='F' checked='checked'/><font id='font3'>F</font>");
				}		
				else
				{
					print ("<input type='radio' name='sex' value='M' /><font id='font3'>M</font> &nbsp;");
					print ("<input type='radio' name='sex' value='F' /><font id='font3'>F</font>");
				}			
				?>
				</td>
			</tr>
			<tr>
				<td width="30%" align="right"><font id="font3"><strong>Address</strong> </font>&nbsp;</td>
				<td width="70%" align="left"><input type="text" name='address' value='<?php print $address; ?>' id="form1" size='52'/></td>
			</tr>	
			<tr>
				<td width="30%" align="right"><font id="font3"><strong>Telephone</strong> </font>&nbsp;</td>
				<td width="70%" align="left"><input type="text" name='telephone' value='<?php print $telephone; ?>' id="form1" size='52'/></td>
			</tr>	
			<tr>
				<td width="30%" align="right"><font id="font3"><strong>Department</strong> </font>&nbsp;</td>
				<td width="70%" align="left">
					<select name='reparto_provenienza' size='1' cols='10' id="form1">
					<?php
					if ($reparto_provenienza != NULL)
						if ($reparto_provenienza == 'pronto_soccorso')
							print ("<OPTION VALUE='$reparto_provenienza'>E.R.</OPTION>");
						else
							print ("<OPTION VALUE='$reparto_provenienza'>").ucwords($reparto_provenienza).("</OPTION>");
					?>
					<OPTION VALUE=''> - </OPTION>			
					<OPTION VALUE='neurochirurgia'>Neurosurgery</OPTION>
					<OPTION VALUE='neurologia'>Neurology</OPTION>		
					<OPTION VALUE='pronto_soccorso'>E.R.</OPTION>			
					</select>
					&nbsp; &nbsp; <font id="font3">Other:</font> 
					<input type="text" name='reparto_provenienza_altro' value='<?php print $reparto_provenienza_altro; ?>' id="form1" size='20'/>
				</td>
			</tr>		
			<tr>
				<td width="30%" align="right"><font id="font3"><strong>Note</strong> </font>&nbsp;</td>
				<td width="70%" align="left">
					<?php
					print ("<textarea id='form1' cols='41' rows='3' name='note_paziente'>$note_paziente</textarea>");
					?>
				</td>
			</tr>		
		</table>
		<br />
		<table border="0" width="80%" cellpadding="0" cellspacing="0">
			<tr>
				<td width="50%" bgcolor="#5B5B86" align="left"><font id="font7"> &nbsp;Clinical Presentation</font></td>	
				<td width="50%"></td>	
			</tr>
		</table>
		<table border="0" width="80%" cellpadding="0" cellspacing="0">
			<tr>
				<td width="30%" align="right"><font id="font3"><strong>Date of first clinical sign</strong> </font>&nbsp;</td>
				<td width="70%" align="left">
				<select name='sintomi_date' size='1' cols='10' id='form1'>
				<?php
					if ($sintomi_date == 'ultima_settimana' )
						print ("<OPTION VALUE='ultima_settimana'>Last week/OPTION>");
					else if ($sintomi_date == 'ultimo_mese' )
						print ("<OPTION VALUE='ultimo_mese'>Last month</OPTION>");		
					else if ($sintomi_date == 'ultimi_sei_mesi' )
						print ("<OPTION VALUE='ultimi_sei_mesi'>Last 6 months</OPTION>");			
					else if ($sintomi_date == 'piu_sei_mesi' )
						print ("<OPTION VALUE='piu_sei_mesi'>More than 6 months</OPTION>");			
				?>
				<OPTION VALUE="">-</OPTION>
				<OPTION VALUE="ultima_settimana">Last week</OPTION>
				<OPTION VALUE="ultimo_mese">Last month</OPTION>
				<OPTION VALUE="ultimi_sei_mesi">Last 6 months</OPTION>
				<OPTION VALUE="piu_sei_mesi">More than 6 months</OPTION>						
				</select>		
			</tr>
			<tr>
				<td width="30%" align="right" valign="top"><font id="font3"><strong>Clinical sign</strong> </font>&nbsp;</td>
				<td width="70%" align="left">
				<?php
				if ($deficit == NULL)
					print ("<input type='checkbox' name='deficit'/><font id='font3'>Sensory deficit </font>&nbsp;");
				else
					print ("<input type='checkbox' name='deficit' checked='checked'/><font id='font3'>Sensory deficit </font>&nbsp;");	
		
				print ("<br>");
				
				if ($deficit_motorio == NULL)
					print ("<input type='checkbox' name='deficit_motorio'/><font id='font3'>Motor deficit </font>&nbsp;");
				else
					print ("<input type='checkbox' name='deficit_motorio' checked='checked'/><font id='font3'>Motor deficit </font>&nbsp;");	
				
				print ("<br>");
						
				if ($crisi_epilettica == NULL)
					print ("<input type='checkbox' name='crisi_epilettica' /><font id='font3'>Epilepsy </font>&nbsp;");
				else
					print ("<input type='checkbox' name='crisi_epilettica' checked='checked'/><font id='font3'>Epilepsy </font>&nbsp;");	
					
				print ("<br>");
				
				if ($disturbi_comportamentali == NULL)
					print ("<input type='checkbox' name='disturbi_comportamentali' /><font id='font3'>Bahavioral disorder </font>&nbsp;");
				else
					print ("<input type='checkbox' name='disturbi_comportamentali' checked='checked'/><font id='font3'>Bahavioral disorder </font>&nbsp;");		
		
				print ("<br>");
						
				if ($cefalea == NULL)
					print ("<input type='checkbox' name='cefalea' /><font id='font3'>Headache </font>&nbsp;");
				else
					print ("<input type='checkbox' name='cefalea' checked='checked'/><font id='font3'>Headache </font>&nbsp;");				
				?>
				<br><font id='font3'>Other:</font> <input type="text" name='sintomi_altro' value='<?php print $sintomi_altro; ?>' size='20' id='form1'/>
				
				</td>
			</tr>	
			<tr>
				<td width="30%" align="right"><font id="font3"><strong>Note</strong> </font>&nbsp;</td>
				<td width="70%" align="left">
				<?php
					print ("<textarea id='form1' cols='41' rows='3' name='sintomi_note'>$sintomi_note</textarea>");
				?>
				</td>
			</tr>	
		</table>
		<br />
		<input type="submit" name='insert_patient' value='INSERT' id='form2'/>
		</form>
		<br /><br />

</div>

</div>
</body>
</html>