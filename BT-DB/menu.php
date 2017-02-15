<?php
$name_page = $_SESSION['name_page'];

print ("<br>");
// HOME PAGE:
if ($name_page == 'home')
{
	// home ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	print ("<div id='menu'>");
	print ("<a href='home.php?start=2' style='text-decoration:none'><font color='#A6D1EC'> Home </font> </a>");
	print ("<br><hr id='hr_menu' size='3'>");
	print ("</div>");
	print ("<br>");
	
	// nuovo paziente ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	if ($permission == 3)
	{
		print ("<div id='menu_permission3'>");
		print ("<font color='#A6D1EC'> New patient </font>");
		print ("<br><hr id='hr_menu' size='3'>");
		print ("</div>");
		print ("<br>");	
	}	
	else
	{
		print ("<div id='menu'>");
		print ("<a href='home.php?start=3'><font color='#A6D1EC'> New patient </font> </a>");
		print ("<br><hr id='hr_menu' size='3'>");
		print ("</div>");
		print ("<br>");	
	}

	// amministrazione ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	if ($permission == 3)
	{
		print ("<div id='menu_permission3'>");
		print ("<font color='#A6D1EC'> Administration </font>");
		print ("<br><hr id='hr_menu' size='3'>");
		print ("</div>");
		print ("<br>");	
	}	
	else
	{
		print ("<div id='menu'>");
		print ("<a href='home.php?start=4'><font color='#A6D1EC'> Administration </font> </a>");
		print ("<br><hr id='hr_menu' size='3'>");
		print ("</div>");
		print ("<br>");	
	}


	// Ricerca e statistica ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	print ("<div id='menu'>");
	print ("<a href='home.php?start=5' style='text-decoration:none'><font color='#A6D1EC'>Search and Statistics</font> </a>");
	print ("<br><hr id='hr_menu' size='3'>");
	print ("</div>");
	print ("<br>");

	// Tumor Engine ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	print ("<div id='menu'>");
	print ("<a href='home.php?start=6' style='text-decoration:none'><font color='#A6D1EC'>Tumors Engine</font> </a>");
	print ("<br><hr id='hr_menu' size='3'>");
	print ("</div>");
	print ("<br>");
	
	
	print ("<br><br><br>");

	// exit ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	print ("<div id='menu'>");
	print ("<a href='index.php'><font color='#A6D1EC'> Exit </font> </a>");		
	print ("<br><hr id='hr_menu' size='3'>");
	print ("</div>");		
}





// NEW PATIENT:
if ($name_page == 'new_patient')
{
	// home ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	print ("<div id='menu'>");
	print ("<a href='home.php?start=2'><font id='font_menu2'> Home </font></a>");
	print ("<br><hr id='hr_menu' size='3'>");
	print ("</div>");
	print ("<br>");
	
	// nuovo paziente ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	print ("<div id='menu_permission3'>");
	print ("<font id='font_menu2'> New patient </font>");	
	print ("<br><hr id='hr_menu' size='3'>");
	print ("</div>");
	print ("<br>");

	// amministrazione ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	print ("<div id='menu'>");
	print ("<a href='home.php?start=4'><font color='#A6D1EC'> Administration </font> </a>");
	print ("<br><hr id='hr_menu' size='3'>");
	print ("</div>");
	print ("<br>");	

	// Ricerca e statistica ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	print ("<div id='menu'>");
	print ("<a href='home.php?start=5' style='text-decoration:none'><font color='#A6D1EC'>Search and Statistics</font> </a>");
	print ("<br><hr id='hr_menu' size='3'>");
	print ("</div>");
	print ("<br>");	

	// Tumor Engine ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	print ("<div id='menu'>");
	print ("<a href='home.php?start=6' style='text-decoration:none'><font color='#A6D1EC'>Tumors Engine</font> </a>");
	print ("<br><hr id='hr_menu' size='3'>");
	print ("</div>");
	print ("<br>");
	
	// exit ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	print ("<br><br><br>");
	print ("<div id='menu'>");
	print ("<a href='index.php'><font color='#A6D1EC'> Exit </font> </a>");		
	print ("<br><hr id='hr_menu' size='3'>");
	print ("</div>");	
}


// AMMINISTRAZIONE:
if ($name_page == 'amministrazione')
{
	// home ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	print ("<div id='menu'>");
	print ("<a href='home.php?start=2'><font id='font_menu2'> Home </font></a>");
	print ("<br><hr id='hr_menu' size='3'>");
	print ("</div>");
	print ("<br>");
	
	// nuovo paziente ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	print ("<div id='menu'>");
	print ("<a href='home.php?start=3'><font color='#A6D1EC'> New patient </font> </a>");	
	print ("<br><hr id='hr_menu' size='3'>");
	print ("</div>");
	print ("<br>");

	// amministrazione ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	print ("<div id='menu'>");
	print ("<a href='home.php?start=4'><font color='#A6D1EC'> Administration </font> </a>");
	print ("<br><hr id='hr_menu' size='3'>");
	print ("</div>");
	print ("<br>");	

	// Ricerca e statistica ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	print ("<div id='menu'>");
	print ("<a href='home.php?start=5' style='text-decoration:none'><font color='#A6D1EC'>Search and Statistics</font> </a>");
	print ("<br><hr id='hr_menu' size='3'>");
	print ("</div>");
	print ("<br>");	
	
	// Tumor Engine ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	print ("<div id='menu'>");
	print ("<a href='home.php?start=6' style='text-decoration:none'><font color='#A6D1EC'>Tumors Engine</font> </a>");
	print ("<br><hr id='hr_menu' size='3'>");
	print ("</div>");
	print ("<br>");
	
		
	// exit ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	print ("<br><br><br>");
	print ("<div id='menu'>");
	print ("<a href='index.php'><font color='#A6D1EC'> Exit </font> </a>");		
	print ("<br><hr id='hr_menu' size='3'>");
	print ("</div>");	
}


// RICERCA:
if ($name_page == 'ricerca')
{
	// home ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	print ("<div id='menu'>");
	print ("<a href='home.php?start=2'><font id='font_menu2'> Home </font></a>");
	print ("<br><hr id='hr_menu' size='3'>");
	print ("</div>");
	print ("<br>");
	
	// nuovo paziente ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	print ("<div id='menu'>");
	print ("<a href='home.php?start=3'><font color='#A6D1EC'> New patient </font> </a>");	
	print ("<br><hr id='hr_menu' size='3'>");
	print ("</div>");
	print ("<br>");

	// amministrazione ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	print ("<div id='menu'>");
	print ("<a href='home.php?start=4'><font color='#A6D1EC'> Administration </font> </a>");
	print ("<br><hr id='hr_menu' size='3'>");
	print ("</div>");
	print ("<br>");	

	// Ricerca e statistica ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	print ("<div id='menu'>");
	print ("<a href='home.php?start=5' style='text-decoration:none'><font color='#A6D1EC'>Search and Statistics</font> </a>");
	print ("<br><hr id='hr_menu' size='3'>");
	print ("</div>");
	print ("<br>");	

	// Tumor Engine ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	print ("<div id='menu'>");
	print ("<a href='home.php?start=6' style='text-decoration:none'><font color='#A6D1EC'>Tumors Engine</font> </a>");
	print ("<br><hr id='hr_menu' size='3'>");
	print ("</div>");
	print ("<br>");
	
		
	// exit ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	print ("<br><br><br>");
	print ("<div id='menu'>");
	print ("<a href='index.php'><font color='#A6D1EC'> Exit </font> </a>");		
	print ("<br><hr id='hr_menu' size='3'>");
	print ("</div>");	
}


// TUMORS ENGINE:
if ($name_page == 'tumors_engine')
{
	// home ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	print ("<div id='menu'>");
	print ("<a href='home.php?start=2'><font id='font_menu2'> Home </font></a>");
	print ("<br><hr id='hr_menu' size='3'>");
	print ("</div>");
	print ("<br>");
	
	// nuovo paziente ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	print ("<div id='menu'>");
	print ("<a href='home.php?start=3'><font color='#A6D1EC'> New patient </font> </a>");	
	print ("<br><hr id='hr_menu' size='3'>");
	print ("</div>");
	print ("<br>");

	// amministrazione ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	print ("<div id='menu'>");
	print ("<a href='home.php?start=4'><font color='#A6D1EC'> Administration </font> </a>");
	print ("<br><hr id='hr_menu' size='3'>");
	print ("</div>");
	print ("<br>");	

	// Ricerca e statistica ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	print ("<div id='menu'>");
	print ("<a href='home.php?start=5' style='text-decoration:none'><font color='#A6D1EC'>Search and Statistics</font> </a>");
	print ("<br><hr id='hr_menu' size='3'>");
	print ("</div>");
	print ("<br>");	

	// Tumor Engine ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	print ("<div id='menu'>");
	print ("<a href='home.php?start=6' style='text-decoration:none'><font color='#A6D1EC'>Tumors Engine</font> </a>");
	print ("<br><hr id='hr_menu' size='3'>");
	print ("</div>");
	print ("<br>");
	
		
	// exit ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	print ("<br><br><br>");
	print ("<div id='menu'>");
	print ("<a href='index.php'><font color='#A6D1EC'> Exit </font> </a>");		
	print ("<br><hr id='hr_menu' size='3'>");
	print ("</div>");	
}

?>

