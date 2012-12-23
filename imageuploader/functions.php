<?php
include "values.php";

//Create session
session_start();

function login($user, $pass)
{
	$connection = mysql_connect(Globals::$SERVER_HOST, Globals::$SERVER_USERNAME, Globals::$SERVER_PASSWORD);
	mysql_select_db(Globals::$DATABASE_NAME, $connection);
	
	$user = mysql_real_escape_string($user);
	$pass = hashString(mysql_real_escape_string($pass));
	
	$USERS_TABLE = Globals::$USERS_TABLE;
	
	$result = mysql_query("SELECT * FROM $USERS_TABLE WHERE name='$user'", $connection);
	
	while($row = mysql_fetch_array($result))
	{
		if($row["name"] == $user && $row["password"] == $pass)
		{
			$_SESSION["status"] = "loggedIn";
			$_SESSION["name"] = $user;
			$_SESSION["user"] = $user;
			
			if($connection)
				mysql_close($connection);
				
			return true;
		}
	}
	
	$_SESSION["status"] = "none";
	
	if($connection)
		mysql_close($connection);
		
	return false;
}

function register($user, $pass)
{
	$connection = mysql_connect(Globals::$SERVER_HOST, Globals::$SERVER_USERNAME, Globals::$SERVER_PASSWORD);
	mysql_select_db(Globals::$DATABASE_NAME, $connection);
	
	$user = mysql_real_escape_string($user);
	$pass = hashString(mysql_real_escape_string($pass));
	
	
	$USERS_TABLE = Globals::$USERS_TABLE;
	
	$result = mysql_query("SELECT * FROM " . $USERS_TABLE . " WHERE name='$user'", $connection);
	
	if($result != null && mysql_num_rows($result) != 0)
	{
		return false;
	}

	mysql_query("INSERT INTO $USERS_TABLE (name, password) VALUES('$user', '$pass')", $connection);
	
	return true;
}

function hashString($str)
{
	return md5($str . "//TODO: Add Salt");
}

function sessionIsAllowed()
{
	if(isset($_SESSION["status"]))
	{
		if($_SESSION["status"] == "loggedIn")
		{
			return true;
		}
	}
	return false;
}


?>