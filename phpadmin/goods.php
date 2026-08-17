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
			<li><a href="users.php">ПОЛЬЗОВАТЕЛИ</a></li>
			<li><a href="files.php">Файлы</a></li>
			<li><a href="logout.php">ВЫйти</a></li>
		</ul>
	</div>
		
	<div id="content">
		<h2>Управление основными средствами</h2>
		
		<?php
		
		echo "<table border='0'>";
		
		/*форма для импорта данных из Excel*/
		
		echo "<tr>";
			echo "<td>"; /*форма для очистки проверки наличия*/
				echo "<form method='POST' action = 'erase/erase.php'>";
				echo "<input name='erase' id='sub' type='submit' value='НАЧАТЬ ПРОВЕРКУ'>";
				echo "</form><br>";
			echo "</td>";
			
			echo "<td>"; /*форма для экспорта всех данных*/
				echo "<form method='POST' action = 'export/export.php'>";
				echo "<input name='export' id='sub' type='submit' value='ЭКСПОРТ В EXCEL'>";
				echo "</form><br>";
			echo "</td>";
		
			echo "<td>"; /*форма для сортировки всех данных*/
				echo "<form method='POST' action = ''>";
				echo "<input name='insort' id='txt' type='text' placeholder='Введите логин'>&nbsp;";
				echo "<input name='sort' id='sub' type='submit' value='СОРТИРОВКА ПО ЛОГИНУ'>";
				echo "</form><br>";
			echo "</td>";
		
		echo "</tr>";

		echo "</table>";
		
		?>
			
		
		<?php
		
		
		
		?>
		
			<?php
				
			
				
			if (!isset($_POST['sort'])) {
			
				$login = '%%';
			
			session_start();
			if (empty($_SESSION['nameus'])) {
				echo 'Доступ запрещен!';
				die;
			}
		
		/*вывод списка имущества в форме таблицы для просмотра*/
			
			echo "<table cellpadding='0' cellspacing='0' border='1' id='tbl'>";
			echo "<tr>";
			echo "<td>Название</td>";
			echo "<td>Инвентарный номер</td>";
			echo "<td>Проверка наличия</td>";
			echo "<td>Ответственное лицо</td>";
			echo "<td>Изображение</td>";
			echo "<td>Редактирование</td>";
			echo "</tr>";

			include 'connect.php';
			$name = $_SESSION['nameus'];
		
			if ($name = 'admin') {
			
			$take = mysqli_query($connection,"SELECT * FROM `equipment` WHERE `login` LIKE '$login';");

				while ($data=mysqli_fetch_array($take)) {
					echo "<tr>";
					echo "<form method='POST' action=''>";
					echo "<input type='hidden' name='id' value='".$data['id']."'>";
					echo "<td><input type='hidden' name='thing' value='".$data['thing']."'>".$data['thing']."</td>";
					echo "<td><input type='hidden' name='inventnum' value='".$data['inventnum']."'>".$data['inventnum']."</td>";
					echo "<td><input type='hidden' name='inventnumcheck' value='".$data['inventnumcheck']."'>".$data['inventnumcheck']."</td>";
					echo "<td><input type='hidden' name='login' value='".$data['login']."'>".$data['login']."</td>";

					echo "<td><a href='".'/php/'.$data['image']."'>Просмотр</a></td>";
					echo "<td><input type='submit' name='edt' value='Редактировать'></td>";
					echo "</form>";
					echo "</tr>";
			}
			echo "</table>";
		

				if (isset($_POST['edt'])) {
					$_SESSION['ggg']=$_POST['thing'];
					$_SESSION['invent']=$_POST['inventnum'];

					echo "<script>window.location.href = 'gedit.php';</script>";
			}

				
			}
					} 
		
		else if (isset($_POST['sort'])) {
		
			$login = $_POST['insort'];
			
			session_start();
			if (empty($_SESSION['nameus'])) {
				echo 'Доступ запрещен!';
				die;
			}
		
		/*вывод списка имущества в форме таблицы для просмотра*/
			
			echo "<table cellpadding='0' cellspacing='0' border='1' id='tbl'>";
			echo "<tr>";
			echo "<td>Название</td>";
			echo "<td>Инвентарный номер</td>";
			echo "<td>Проверка наличия</td>";
			echo "<td>Ответственное лицо</td>";
			echo "<td>Изображение</td>";
			echo "<td>Редактирование</td>";
			echo "</tr>";

			include 'connect.php';
			$name = $_SESSION['nameus'];
		
			if ($name = 'admin') {
			
			$take = mysqli_query($connection,"SELECT * FROM `equipment` WHERE `login` LIKE '$login';");

				while ($data=mysqli_fetch_array($take)) {
					echo "<tr>";
					echo "<form method='POST' action=''>";
					echo "<input type='hidden' name='id' value='".$data['id']."'>";
					echo "<td><input type='hidden' name='thing' value='".$data['thing']."'>".$data['thing']."</td>";
					echo "<td><input type='hidden' name='inventnum' value='".$data['inventnum']."'>".$data['inventnum']."</td>";
					echo "<td><input type='hidden' name='inventnumcheck' value='".$data['inventnumcheck']."'>".$data['inventnumcheck']."</td>";
					echo "<td><input type='hidden' name='login' value='".$data['login']."'>".$data['login']."</td>";

					echo "<td><a href='".'/php/'.$data['image']."'>Просмотр</a></td>";
					echo "<td><input type='submit' name='edt' value='Редактировать'></td>";
					echo "</form>";
					echo "</tr>";
			}
			echo "</table>";
		

				if (isset($_POST['edt'])) {
					$_SESSION['ggg']=$_POST['thing'];
					$_SESSION['invent']=$_POST['inventnum'];

					echo "<script>window.location.href = 'gedit.php';</script>";
			}

				
			}
			
		}

		?>
		
		
		

		<!--форма для добавления товара-->

		<h2>Добавление основного средства по одному</h2>
		
		<?php
			echo "<form id='u' method='POST' enctype = 'multipart/form-data'>";
			echo "<fieldset id='fset'>";
			echo "<legend>Введите все данные</legend>";
		
				
			$gotouser = mysqli_query($connection,"SELECT `users`.`login`,
														 `usersinfo`.`login`,`usersinfo`.`fullname`
											FROM `users`,`usersinfo` 
											WHERE `usersinfo`.`login` = `users`.`login`;");
			
			echo "<select id='txt' name='ulist'>";
					while ($userlist=mysqli_fetch_assoc($gotouser)) {
						echo "<option value='".$userlist['login']."'>".$userlist['fullname']."</option>";
					}
			echo "</select><br>";
					
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
				
				$tempname=$_POST['ulist'];

				$link=mysqli_connect($host,$user,$pass,$dbnm);
				
				// определение папки для пользователя с именем name для загрузки файлов (по умолчанию php/images/..)
				$dir='../php/images/'.$tempname; 
								
				if(!is_dir($dir)) {
					mkdir($dir, 0777, true); // создаем папку с именем пользователя если она не существовала
				} else {
				
				$first=$_POST['thing'];
				$second=$_POST['inventnum'];
				$last=$_POST['ulist'];
				$upname=basename($_FILES['file']['name']);//записываем имя файла
				$uppath=$dir.'/'.$upname; // имя папки + имя файла
				
				//перемещение загруженного файла из временной папки сервера в папку, которую указали (uploadpath)

				if  (move_uploaded_file($_FILES['file']['tmp_name'], $uppath)) {
				/*запись нового основного средства c изображением*/
				$adding = mysqli_query($link,"INSERT INTO `equipment` (`thing`,`inventnum`,`login`,`image`) VALUES ('$first','$second','$last','$uppath');"); 
					} else {
				/*запись нового товара без изображения*/
				$adding = mysqli_query($connection,"INSERT INTO `equipment` (`thing`,`inventnum`,`login`,`image`) VALUES ('$first','$second','$last','$four','');");  
					}
				
				if ($adding) {
							echo "<script>window.location.href = 'goods.php';</script>";
							header("Location:goods.php");
						}
			}
			}

		?>
		
	</div>
</body>
</html>