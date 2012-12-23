<?php
include "functions.php";

$comment = mysql_real_escape_string($_POST["comment"]);
$imageId = mysql_real_escape_string($_POST["imageId"]);


if(sessionIsAllowed())
{
	$connection = mysql_connect(Globals::$SERVER_HOST, Globals::$SERVER_USERNAME, Globals::$SERVER_PASSWORD);
	mysql_select_db(Globals::$DATABASE_NAME, $connection);
	
	$userId = $_SESSION["user"];
	$commentTable = Globals::$COMMENTS_TABLE;
	
	mysql_query("INSERT INTO $commentTable (userID, comment, imageID) VALUES ('$userId', '$comment', '$imageId')");
	echo mysql_error();
	mysql_close($connection);
}

header("Location: viewImage.php?imageID=$imageId");
?>