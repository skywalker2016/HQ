<?php
session_start();
if ($_SESSION['username'] != null){
?>

<div id='titolo'>
	<table width="80%" border="0">
		<tr>
			<td width="30%" align="center">
				<img src="images/ECG1.gif" width="350" />
			</td>
			<td width="40%" align="center">
				<font id='font_titolo'>生理信号数据库</font>
			</td>
			<td width="15%" align="center" valign='bottom'>
				<font face="Georgia, Times New Roman, Times, serif" color="#33FF99" size="2">Logged in as&nbsp;:&nbsp;<?php echo $_SESSION['username']; ?></font>
			</td>
			<td width="15%" align="right" valign='bottom'>
				<font face="Georgia, Times New Roman, Times, serif" color="#33FF99" size="2">北京工业大学生命学院&nbsp;&nbsp;&nbsp;&nbsp;Version 1.0</font>
			</td>
		</tr>		
	</table>			
</div>
<?php }else{ ?>
<div id='titolo'>
	<table width="80%" border="0">
		<tr>
			<td width="30%" align="center">
				<img src="images/ECG1.gif" width="350" />
			</td>
			<td width="40%" align="center">
				<font id='font_titolo'>生理信号数据库</font>
			</td>
			<td width="30%" align="right" valign='bottom'>
				<font face="Georgia, Times New Roman, Times, serif" color="#33FF99" size="2">北京工业大学生命学院&nbsp;&nbsp;&nbsp;&nbsp;Version 1.0</font>
			</td>
		</tr>
	</table>
</div>
<?php } ?>