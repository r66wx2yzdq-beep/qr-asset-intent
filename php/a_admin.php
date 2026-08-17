<!DOCTYPE html>
<html>
<head>
	<title>Страница пользователя</title>
	<link rel="stylesheet" type="text/css" href="../css/admin.css">
</head>
<body>
	<div id="side">
		<ul id="nav">
			<li><a href="#">ГЛАВНАЯ</a></li>
			<li><a href="goods.php">Имущество</a></li>
			<li><a href="users.php">О пользователе</a></li>
			<li><a href="files.php">Файлы</a></li>
			<li><a href="logout.php">ВЫйти</a></li>


		</ul>
	</div>
		
	<div id="content">
		<?php
			
			
				
		
			include 'connect.php';
			session_start();
			$name = $_SESSION['nameus'];
		
			if (empty($_SESSION['nameus'])) {
				echo 'Доступ запрещен!';
				die;
			}
		
			/*вывод имени пользователя для просмотра*/
	
			$takename = mysqli_query($connection,"SELECT * FROM `usersinfo` WHERE `login` = '$name';");
		
			//if ($takename) {echo "All right!";}
			
			while ($data = mysqli_fetch_assoc($takename)) {
				echo "<h2>".$data['fullname']."</h2>";
			}
				
		
			echo "<h2>Добро пожаловать в личный кабинет!</h2>";

		?>
		
		
	<div id="content">
		
		<div id="fcon">
		<?php
			$userdata = mysqli_query($connection,"SELECT * FROM `usersinfo` WHERE `login` = '$name';");
			while ($ud=mysqli_fetch_assoc($userdata)) {
					echo "<img src='".$ud['image']."'>";
			}
		?>
		</div>
		
		<div id="scon">
		<?php
			echo "<form id='u' method='POST' enctype = 'multipart/form-data'>";
			echo "<fieldset id='fset'>";
			echo "<legend>Пользователь:".$name."</legend>";

			$userdata = mysqli_query($connection,"SELECT * FROM `usersinfo` WHERE `login` = '$name';");
			while ($ud=mysqli_fetch_assoc($userdata)) {
					echo "<input name='firname' id='txt' placeholder='ФИО' type='text' value='".$ud['fullname']."'><br>";
					echo "<input name='secname' id='txt' placeholder='Расположение' type='text' value='".$ud['location']."'><br>";
					echo "<input type='file' name='file'><br>";
					echo "<input name='pub' id='sub' type='submit' value='ОБНОВИТЬ ДАННЫЕ'>";
			}

			echo "</form>";

			if (isset($_POST['pub'])) {
				
	require_once __DIR__ . '/../config.php';
	$host = DB_HOST;
	$user = DB_USER;
	$pass = DB_PASS;
	$dbnm = DB_NAME;

				$link=mysqli_connect($host,$user,$pass,$dbnm);
				
				$dir='files/'.$name; // определение папки для пользователя с именем name для загрузки файлов (по умолчанию php/images/..)
				
				if(!is_dir($dir)) {
					mkdir($dir, 0777, true); // создаем папку с именем пользователя если она не существовала
				} else {
				
				$first=$_POST['firname'];
				$second=$_POST['secname'];
				$upname=basename($_FILES['file']['name']);//записываем имя файла
				$uploadpath=$dir.'/'.$upname; // имя папки + имя файла
				
				//перемещение загруженного файла из временной папки сервера в папку, которую указали (uploadpath)

				if  (move_uploaded_file($_FILES['file']['tmp_name'], $uploadpath)) {
				
				$sql=mysqli_query($link,"UPDATE `usersinfo` SET `fullname`='$first',`location`='$second',`image`='$uploadpath' WHERE `login`='$name';");
					} else {
				$sql=mysqli_query($link,"UPDATE `usersinfo` SET `fullname`='$first',`location`='$second' WHERE `login`='$name';");		
					}

				if ($sql) {
							header("Location:a_admin.php");
						}
				}
			}
		
		?>
		
		
	</div>
</body>
</html>