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
			<li><a href="users.php">о пользователе</a></li>
			<li><a href="files.php">Файлы</a></li>
			<li><a href="logout.php">ВЫйти</a></li>
		</ul>
	</div>

	<div id="content">

		<h2>Управление учетной записью</h2>

		<?php

		/*вывод зарегистрированного списка пользователей в форме таблицы для просмотра*/
			
			echo "<table cellpadding='0' cellspacing='0' border='1' id='tbl'>";
			echo "<tr>";
			echo "<td>Логин</td>";
			echo "<td>ФИО</td>";
			echo "<td>Расположение</td>";
			echo "<td>Фотография</td>";
			echo "</tr>";

			include 'connect.php';

			session_start();
			$name = $_SESSION['nameus'];
		
			if (empty($_SESSION['nameus'])) {
				echo 'Доступ запрещен!';
				die;
			}
		
			$take = mysqli_query($connection,"SELECT * FROM `usersinfo` WHERE `login` = '$name';");
		

				while ($data=mysqli_fetch_array($take)) {
					echo "<tr>";
					echo "<td>".$data['login']."</td>";
					echo "<td>".$data['fullname']."</td>";
					echo "<td>".$data['location']."</td>";
					echo "<td><a href='".$data['image']."'>Просмотр</a></td>";
					echo "</tr>";
			}

			echo "</table>";

		?>

		<?php

			/*начало вывода списка пользователей в выпадающем списке*/

			echo "<form id='u' method='POST'><br>";
			echo "<fieldset id='fset'>";
			echo "<legend>ПОЛЬЗОВАТЕЛЬ &nbsp;";
			$userdata = mysqli_query($connection,"SELECT * FROM `usersinfo` WHERE `login` = '$name';");
			
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
					$userquery1 = mysqli_query($connection,"UPDATE `users` SET `login`= '$newname' WHERE `login`='$name';");
					if ($userquery1) {
							header ('Location:users.php');
						}
				}

			/*изменение только пароля пользователя, после выбора соответствующего из списка*/

				if (isset($_POST['upd']) && $_POST['newpassword']!='') {
					$cnguser = $_POST['chng'];
					$newpassword = $_POST['newpassword'];
					$userquery2 = mysqli_query($connection,"UPDATE `users` SET `passw`= '$newpassword' WHERE `login`='$name';");
					if ($userquery2) {
							header ('Location:users.php');
						}
				}


		?>
		
	</div>
</body>
</html>