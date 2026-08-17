<!DOCTYPE html>
<html>
<head>
	<title>Управление учетной записью</title>
	<link rel="stylesheet" type="text/css" href="../css/admin.css">
</head>
<body>
	<div id="side">
		<ul id="nav">
			<li><a href="a_admin.php">ГЛАВНАЯ</a></li>
			<li><a href="goods.php">имущество</a></li>
			<li><a href="users.php">ПОЛЬЗОВАТЕЛИ</a></li>
			<li><a href="files.php">Файлы</a></li>
			<li><a href="logout.php">ВЫйти</a></li>
		</ul>
	</div>

	<div id="content">

		<h2>Управление учетными записями пользователей</h2>

		<?php
		
			/*форма для импорта пользователей из Excel*/

			echo "<form method='POST' action = 'xlsimport/xlsimport.php' enctype='multipart/form-data'>";
				echo "<input type='file' name='excel-file'>";
				echo "<input type='submit' name='impex' id='sub' value='ИМПОРТ ИЗ EXCEL'>";
			echo "</form><br>";

		/*вывод зарегистрированного списка пользователей в форме таблицы для просмотра*/
			
			echo "<table cellpadding='0' cellspacing='0' border='1' id='tbl'>";
			echo "<tr>";
			echo "<td>Логин</td>";
			echo "<td>Пароль</td>";
			echo "<td>ФИО</td>";
			echo "<td>Расположение</td>";
			echo "<td>Фотография</td>";
			echo "<td>Удаление</td>";
			echo "</tr>";

			include 'connect.php';

			session_start();
			$name = $_SESSION['nameus'];
		
			if (empty($_SESSION['nameus'])) {
				echo 'Доступ запрещен!';
				die;
			}
		
			if ($name = 'admin') {
		
			$take = mysqli_query($connection,"SELECT * FROM `users`,`usersinfo` WHERE `users`.`login`=`usersinfo`.`login`;");
		

				while ($data=mysqli_fetch_array($take)) {
					echo "<tr>";
					echo "<form method='POST' action=''>";
					echo "<input type='hidden' name='id' value='".$data['uid']."'>";
					echo "<td>".$data['login']."</td>";
					echo "<td>".$data['passw']."</td>";
					echo "<td>".$data['fullname']."</td>";
					echo "<td>".$data['location']."</td>";
					echo "<td><a href='".$data['image']."'>Просмотр</a></td>";
					echo "<td><input type='submit' name='dlt' value='Удалить'></td>";
					echo "</form>";
					echo "</tr>";
			}

			echo "</table>";
			}
		
				if (isset($_POST['dlt'])) {
					$id=$_POST['id'];
					mysqli_query($connection,"DELETE FROM `users` WHERE `uid` = '$id';");
					echo "<script>window.location.href = 'users.php';</script>";
			}

		?>

		<?php

			/*начало вывода списка пользователей в выпадающем списке*/
			if ($name = 'admin') {
		
			echo "<form id='u' method='POST'><br>";
			echo "<fieldset id='fset'>";
			echo "<legend>ПОЛЬЗОВАТЕЛЬ &nbsp;";
			$userdata = mysqli_query($connection,"SELECT * FROM `usersinfo`;");
			
			echo "<select id='txt' name='chng'>";
			
			while ($ud=mysqli_fetch_assoc($userdata)) {
					echo "<option value='".$ud['login']."'>".$ud['fullname']."</option>";
			}
			echo "</select>";

			/*конец вывода списка пользователей в выпадающем списке*/

			echo "</legend>";

			echo "<input id='txt' type='text' name='newname' placeholder='Введите новый логин или..'><br>";
			echo "<input id='txt' type='password' name='newpassword' placeholder='Введите новый пароль'><br>";
			echo "<input type='submit' id='sub' name='upd' value='ОБНОВИТЬ ДАННЫЕ'>";
			echo "</form>";

			/*изменение только имени пользователя, после выбора соответствующего из списка*/

				if (isset($_POST['upd']) && $_POST['newname']!='') {
					$cnguser = $_POST['chng'];
					$newname = $_POST['newname'];
					$userquery1 = mysqli_query($connection,"UPDATE `users` SET `login`= '$newname' WHERE `login`='$cnguser';");
					if ($userquery1) {
							header ('Location:users.php');
						}
				}

			/*изменение только пароля пользователя, после выбора соответствующего из списка*/

				if (isset($_POST['upd']) && $_POST['newpassword']!='') {
					$cnguser = $_POST['chng'];
					$newpassword = $_POST['newpassword'];
					$userquery2 = mysqli_query($connection,"UPDATE `users` SET `passw`= '$newpassword' WHERE `login`='$cnguser';");
					if ($userquery2) {
							header ('Location:users.php');
						}
				}
			}

		?>
		
	</div>
</body>
</html>