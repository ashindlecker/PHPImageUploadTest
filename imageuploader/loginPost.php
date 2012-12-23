<?php
include "functions.php";

$username = mysql_real_escape_string($_POST["user"]);
$pass = mysql_real_escape_string($_POST["password"]);

login($username, $pass);

header( "Location:index.php");
?>