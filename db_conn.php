<?php
error_reporting(0);
$sname     = "localhost";
$unmae     = "root";
$password  = "";
$db_name   = "test";

$conn = mysqli_connect($sname, $unmae, $password, $db_name);

if ($conn) 
{
	echo "";
}
else
{
	echo "Connection failed!";
}
?>