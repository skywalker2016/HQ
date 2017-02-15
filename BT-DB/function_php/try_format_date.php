<?php
// Try format date:
function try_date($date)
{
	$n = strlen($date);
	
	if ($n != 10)
		$rs = 0;
	else
	{
		if (($date[2] != '/') || ($date[5] != '/'))
			$rs=0;
		else
		{
			$date=data_convert_for_mysql($date);
			
			$query = "INSERT INTO try_date
				(id, date)
				VALUES
				(NULL, '$date')";
			$rs = mysql_query($query);

			$query_del = "DELETE FROM try_date WHERE date = '$date'";
			$rs_del = mysql_query($query_del);	
			
			return ($rs);
		}
	}
}
?>