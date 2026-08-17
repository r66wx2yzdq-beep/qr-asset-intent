<?php

	require_once __DIR__ . '/../../config.php';
	$host = DB_HOST;
	$user = DB_USER;
	$pass = DB_PASS;
	$dbnm = DB_NAME;

$connection=mysqli_connect($host,$user,$pass,$dbnm);

session_start(); $name = $_SESSION['nameus'];

if(isset($_POST["erase"]))
{
 
	$query = mysqli_query($connection,"UPDATE `equipment` SET `inventnumcheck`=''");
	if ($query) 
	{
		header("location:../goods.php");
	}
 
}

?>