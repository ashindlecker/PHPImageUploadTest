
<html>
<body>
<?php
include "Image.php";

if(!sessionIsAllowed())
{
	?>
	
	<h2>
	You need to be signed in, create an account or sign in:
	</h2>
	
	Login:
	<form action="loginPost.php" method="post">
	Username: <input type="text" name="user">
	Password: <input type="password" name="password">
	<input type="submit" name="submit" value="Submit">
	</form>
	<br/>
	Register:
	<form action="registerPost.php" method="post">
	Username: <input type="text" name="user">
	Password: <input type="password" name="password">
	<input type="submit" name="submit" value="Submit">
	</form>
	<?php
}
else
{
	?>
	<h1>Welcome <?php echo $_SESSION["user"] ?> </h1>
	<form action="logout.php" method="post">
	<input type="submit" name="submit" value="logout">
	</form>
	<?php
}
?>

	<form action="uploadImage.php" method="post"
	enctype="multipart/form-data">
	<label for="file">Filename:</label>
	<input type="file" name="file" id="file"><br>
	<input type="submit" name="submit" value="Submit">
	</form>
	
	<?php
	$connection = mysql_connect(Globals::$SERVER_HOST, Globals::$SERVER_USERNAME, Globals::$SERVER_PASSWORD);
	mysql_select_db(Globals::$DATABASE_NAME, $connection);
	
	$IMAGES_TABLE = Globals::$IMAGES_TABLE;
	$result = mysql_query("SELECT * FROM $IMAGES_TABLE", $connection);
	
	while($row = mysql_fetch_array($result))
	{
		$rowImage = new Image();
		$rowImage->Load($row["fileID"]);
		
		echo "<a href='viewImage.php?imageID=$rowImage->FileId'>";
		echo "<image src='uploads/$rowImage->FileId' width='150' height='150'/>";
		echo "</a>";
		echo $rowImage->Owner . " (" . $rowImage->Score . ")<br/>";
	}
	
	?>

</body>
</html>