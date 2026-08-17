<!DOCTYPE html>
<html>
<head>
	<title>Управление основными средствами</title>
	<link rel="stylesheet" type="text/css" href="../css/admin.css">
</head>
<body>
	<div id="side">
		<ul id="nav">
			<li><a href="a_admin.php">ГЛАВНАЯ</a></li>
			<li><a href="goods.php">ИМУЩЕСТВО</a></li>
			<li><a href="users.php">О ПОЛЬЗОВАТЕЛЕ</a></li>
			<li><a href="files.php">Файлы</a></li>
			<li><a href="logout.php">ВЫйти</a></li>
		</ul>
	</div>
		
	<div id="content">
		<h2>Управление основными средствами</h2>
			
			<?php

			session_start();
			if (empty($_SESSION['nameus'])) {
				echo 'Доступ запрещен!';
				die;
			}
		
		echo "<table border='0'>";
		
		/*форма для импорта данных из Excel*/
		
		echo "<tr>";
		echo "<td>";
		
			echo "<form method='POST' action = 'xlsimport/xlsimport.php' enctype='multipart/form-data'>";
				echo "<input type='file' name='excel-file'>";
				echo "<input type='submit' name='impex' id='sub' value='ИМПОРТ ИЗ EXCEL'>";
			echo "</form>";
		
		echo "</td>";
		
		echo "<td>";
		/*форма для экспорта данных в Excel*/

			echo "<form method='POST' action = 'export/export.php'>";
					echo "&nbsp;&nbsp;<input name='export' id='sub' type='submit' value='ЭКСПОРТ В EXCEL'>";
			echo "</form>";
		
		echo "</td>";
		echo "<tr>";
		
		echo "</table><br>";
		
		/*вывод списка имущества в форме таблицы для просмотра*/
			
			echo "<table cellpadding='0' cellspacing='0' border='1' id='tbl'>";
			echo "<tr>";
			echo "<td>Название</td>";
			echo "<td>Инвентарный номер</td>";
			echo "<td>Проверка наличия</td>";
			echo "<td>Изображение</td>";
			echo "<td>Редактирование</td>";
			echo "<td>Удаление</td>";
			echo "</tr>";

			include 'connect.php';
			$name = $_SESSION['nameus'];

			$take = mysqli_query($connection,"SELECT * FROM `equipment` WHERE `login` = '$name';");

				while ($data=mysqli_fetch_array($take)) {
					echo "<tr>";
					echo "<form method='POST' action=''>";
					echo "<input type='hidden' name='id' value='".$data['id']."'>";
					echo "<td><input type='hidden' name='thing' value='".$data['thing']."'>".$data['thing']."</td>";
					echo "<td><input type='hidden' name='inventnum' value='".$data['inventnum']."'>".$data['inventnum']."</td>";
					echo "<td><input type='hidden' name='inventnumcheck' value='".$data['inventnumcheck']."'>".$data['inventnumcheck']."</td>";
					echo "<td><a href='".$data['image']."'>Просмотр</a></td>";
					echo "<td><input type='submit' name='edt' value='Редактировать'></td>";
					echo "<td><input type='submit' name='dlt' value='Удалить'></td>";
					echo "</form>";
					echo "</tr>";
			}
			echo "</table>";
		

				if (isset($_POST['edt'])) {
					$_SESSION['ggg']=$_POST['thing'];
					$_SESSION['invent']=$_POST['inventnum'];

					echo "<script>window.location.href = 'gedit.php';</script>";
			}

				if (isset($_POST['dlt'])) {
					$id=$_POST['id'];
					mysqli_query($connection,"DELETE FROM `equipment` WHERE `id` = '$id' AND `login`='$name';");
					echo "<script>window.location.href = 'goods.php';</script>";
			}

		?>
		
		<br>
		
				
		

		<!--форма для добавления товара-->

		<h2>Добавление основного средства по одному</h2>

		<?php
			echo "<form id='u' method='POST' enctype = 'multipart/form-data'>";
			echo "<fieldset id='fset'>";
			echo "<legend>Введите все данные</legend>";
					echo "<input name='thing' id='txt' placeholder='Название' type='text'><br>";
					echo "<input name='inventnum' id='txt' placeholder='Инвентарный номер' type='text'><br>";
					echo "<input type='file' name='file'><br>";
					echo "<input name='pub' id='sub' type='submit' value='ДОБАВИТЬ В БАЗУ ДАННЫХ'>";
		
			echo "</form>";

			/*добавление товара*/

			if (isset($_POST['pub'])) {

	require_once __DIR__ . '/../config.php';
	$host = DB_HOST;
	$user = DB_USER;
	$pass = DB_PASS;
	$dbnm = DB_NAME;

				$link=mysqli_connect($host,$user,$pass,$dbnm);
				
				$dir='images/'.$name; // определение папки для пользователя с именем name для загрузки файлов (по умолчанию php/images/..)
				
				if(!is_dir($dir)) {
					mkdir($dir, 0777, true); // создаем папку с именем пользователя если она не существовала
				} else {
				
				$first=$_POST['thing'];
				$second=$_POST['inventnum'];
				$upname=basename($_FILES['file']['name']);//записываем имя файла
				$uppath=$dir.'/'.$upname; // имя папки + имя файла
				
				//перемещение загруженного файла из временной папки сервера в папку, которую указали (uploadpath)

				if  (move_uploaded_file($_FILES['file']['tmp_name'], $uppath)) {
				/*запись нового основного средства c изображением*/
				$adding = mysqli_query($link,"INSERT INTO `equipment` (`thing`,`inventnum`,`login`,`image`) VALUES ('$first','$second','$name','$uppath');"); 
					} else {
				/*запись нового товара без изображения*/
				$adding = mysqli_query($connection,"INSERT INTO `equipment` (`thing`,`inventnum`,`login`,`image`) VALUES ('$first','$second','$name','');");  
					}
				
				if ($adding) {
							echo "<script>window.location.href = 'goods.php';</script>";
						}
			}
			}

		?>
		
	</div>
</body>
</html>