<?php
include "functions.php";

	if(sessionIsAllowed())
	{
		$file = $_FILES["file"];
		
		if($file["error"] > 0)
		{
			echo "Error: " + $file["error"];
		}
		else
		{
			//save image
			move_uploaded_file($file["tmp_name"], "uploads/" . $file["name"]);
			
			$connection = mysql_connect(Globals::$SERVER_HOST, Globals::$SERVER_USERNAME, Globals::$SERVER_PASSWORD);
			mysql_select_db(Globals::$DATABASE_NAME, $connection);
			
			$images_table = Globals::$IMAGES_TABLE;
			$sessionUser = $_SESSION["user"];
			$imageName = "TODO: add ability to change name of image";
			$fileID = mysql_real_escape_string($file["name"]);
			mysql_query("INSERT INTO $images_table (ownerid, name, fileID) VALUES ('$sessionUser', '$imageName', '$fileID')", $connection);
			mysql_close($connection);
		}
	}
	else
	{
		echo "You are not logged in, YA CAN'T DO THAT";
	}
	
	header( "Location:index.php");
?>