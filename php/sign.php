<?php
session_start();
include 'connect.php';

/*вход для пользователей с проверкой данных о пользователе и пароле*/

if (isset($_POST['subin'])) {
	$username=$_POST['username'];
	$passname=$_POST['passname'];
	$_SESSION['nameus']=$_POST['username'];

		$ueject = mysqli_query($connection,"SELECT `uid`,`passw` FROM `users` WHERE `login` = '$username';");
	

		while ($udata=mysqli_fetch_assoc($ueject)) {
			if ($passname==$udata['passw']) {
				header("Location:a_admin.php");
			}
			else {
				header("Location:https://qrintent.ictlab.kz");
			}
		}
}

if (isset($_POST['pu'])) {
	header("Location:https://qrintent.ictlab.kz/iamadmin.php");
}

?>