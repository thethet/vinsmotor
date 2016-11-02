<?php
	$conn = mysql_connect("localhost","root","monkeycool");
	if (!$conn)
	{
		echo "Not connected to database";	
	}
	mysql_select_db('phbathroom');
?>