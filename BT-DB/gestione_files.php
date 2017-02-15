<?php
session_start();
include ("accesso_db.php");

if ($permission == NULL)
	header("Location:errore.html");

include ("convertitore_date.php");

$id_paziente = $_REQUEST['id_paziente'];


// Inserimento files nel database: -------------------------------------------------
if ($_REQUEST['upload1'] == 'Upload File')
{
	$target_path = "files/";
	
	$target_path = $target_path . basename( $_FILES['uploadedfile']['name']); 
	
	$nome_file =  $_FILES['uploadedfile']['name'];
		
	if ($_FILES['uploadedfile']['name'] == NULL);
	else
	{	
			if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) 
			{
				$upload_ok=1;
			} 
			else;
			
			$query = "INSERT INTO files
						(id, id_paziente, nome_file)
						VALUES
						(NULL, '$id_paziente', '$nome_file')";
			  $rs = mysql_query($query);
	  
		$_FILES['uploadedfile']['name'] = NULL;
 	}
}
// ----------------------------------------------------------------------------------

if ($_REQUEST['delete'] == 1)
{
	$nome_file = $_REQUEST['nome_file'];
	$query = "DELETE FROM files WHERE nome_file='$nome_file'";
	$rs = mysql_query($query);		

}
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
<?php include ("barra_titolo.html"); ?>
<hr id='hr1' size='5px'/>
<br />
<font id="font2">Files Menagement</font>
<br /><br /><br /><br />
<?php
if ($upload_ok==1)
print ("<font face='Geneva, Arial, Helvetica, sans-serif' size='4' color='#FFFFCC'>This file has been inserted in the database</font><br><br>");

?>
<form enctype="multipart/form-data" action="gestione_files.php" method="POST">
<input type="hidden" name="MAX_FILE_SIZE" value="600000" />
<font face="Verdana, Arial, Helvetica, sans-serif" color="#FF99CC" size="4">Choose a file to upload: </font>
<font face="Verdana, Arial, Helvetica, sans-serif" color="#FF99CC" size="4"><input name="uploadedfile" type="file" /></font><br /><br /><br />
<input type="submit" value="Upload File" name='upload1' />
<input type="hidden" name='id_paziente' value="<?php print $id_paziente; ?>"  />
</form>
<br /><br /><br /><br />
<font face="Verdana, Arial, Helvetica, sans-serif" color="#FF99CC" size="4">Files for this patient: </font><br /><br />
<table border="0" width="30%" cellpadding="0" cellspacing="1">
	<tr>
		<td align="center" width="10%" id='font3' bgcolor="#006699"></td>
	    <td align="center" width="10%" id='font3' bgcolor="#006699"></td>
		<td align="center" width="80%" id='font3' bgcolor="#006699">File Name</td>				
	</tr>
</table>
<table border="0" width="30%" cellpadding="0" cellspacing="1">
<?php
	$query = "SELECT nome_file FROM files WHERE id_paziente = '$id_paziente'";
	$rs = mysql_query($query);
	$i=0;
	while(list($name) = mysql_fetch_row($rs))
	{
		if($i& 1)
			$color='form2';
		else
			$color='form2_2';	
		
		print ("
			<tr>
				<td align='center' width='10%' id='$color'>
				<a href='files/$name' >
				<img src='images/download-driver-icon.png' width='17' alt='Download file' title='Download file' border='0'>
				</a>
				</td>
				<td align='center' width='10%' id='$color'>
				<a href='gestione_files.php?delete=1&id_paziente=$id_paziente&nome_file=$name' >
				<img src='images/elimina.png' width='17' alt='Remove file' title='Remove file' border='0'>
				</a>
				</td>
				<td align='center' width='80%' id='$color'>	$name</td>
			</tr>	
			");
	
		$i=$i+1;
	}
?>
</table>
</body>
</html>
