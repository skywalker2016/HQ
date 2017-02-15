<?php
session_start();
include ("accesso_db.php");
if ($permission == NULL)
	header("Location:errore.html");
	
$start = $_REQUEST['start'];


// Elimina le vecchie ricerche: *******************
$_SESSION['numero_totale_pazienti'] = NULL;
$_SESSION['id_paz'] = NULL;
// ************************************************

// Record the session variable (name_page) for the menu:
if ($_REQUEST['start'] == 1)
{
	$_SESSION['name_page'] = 'home';
	// Check the permission: if the user has permission=0 (administrator) there will be a
	// ALERT window:
	if ($permission == '0')
	{
		print ("<script type=\"text/javascript\">");
		print ("alert (\"Be careful. You are using this database as Administrator");
		print ("</script>");
	}	
}

if ($_REQUEST['start'] == 2)
	$_SESSION['name_page'] = 'home';
	
if ($_REQUEST['start'] == 3)
	$_SESSION['name_page'] = 'new_patient';	

if ($_REQUEST['start'] == 4)
	$_SESSION['name_page'] = 'amministrazione';	

if ($_REQUEST['start'] == 5)
	$_SESSION['name_page'] = 'ricerca';
	
if ($_REQUEST['start'] == 6)
	$_SESSION['name_page'] = 'tumors_engine';	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--单独写html标签是没有声明文档的命名空间的，而加上xmlns="http://www.w3.org/1999/xhtml",声明了文档的命名空间，
    浏览器在解析HTML文档的标签时，就会按照这个规范进行。一般情况，两者区别不大
    特殊情况在于一些特殊的标签的解析上，比如XHTML的命名规范，要求标签都必须严格闭合，单标签要在末尾加上“/”，如果不加则无法解析
    所以好的书写习惯是建议都加上结束标签-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include ("js_files/date.js"); ?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="style.css" />
<title>Tumors Database</title>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<div align="center">

<?php include ("barra_titolo.html"); ?>

<hr id='hr1' size='5px'/>
<table border="0" cellpadding="0" cellspacing="0" width="80%">
	<tr>
		<td width="100%" align="right">
		<font id='font3'>
			 <script language="JavaScript">   
  			 document.write(""+day+" "+date+" "+month+", "+year+"");
 			 </script> 
		</font> 
		</td>
	</tr>
</table>	
<table width="95%" border='0' cellpadding="0" cellspacing="0">
<tr>
	<!-- Menu coloum  ****************************************************************************************** -->
	<td width="25%" align="center" valign="top">
	<?php include ("menu.php"); ?>
	</td>
	
	<!-- Body coloum ******************************************************************************************** -->
	<td width="75%" align="center" valign="top">
	<?php
	if (($start == 1) || ($start == 2)) 
		print ("<iframe src='home2.php' width='100%' height='650' frameborder='0' scrolling='auto' name='corpo'></iframe>");
	if ($start == 3)
		print ("<iframe src='new_patient.php' width='100%' height='650' frameborder='0' scrolling='auto' name='corpo'></iframe>");		
	if ($start == 4)
		print ("<iframe src='amministrazione.php' width='100%' height='650' frameborder='0' scrolling='auto' name='corpo'></iframe>");	
	if ($start == 5)
		print ("<iframe src='ricerca.php?delete_session=1' width='100%' height='720' frameborder='0' scrolling='auto' name='corpo'></iframe>");
	if ($start == 6)
		print ("<iframe src='tumors_engine.php?clear=1' width='100%' height='720' frameborder='0' scrolling='auto' name='corpo'></iframe>");
	?>
	</td>
</tr>
</table>
</div>
</body>
</html>
