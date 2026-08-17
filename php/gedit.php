<!DOCTYPE html>
<html>
<head>
	<title>Карточка основного средства</title>
	<link rel="stylesheet" type="text/css" href="../css/admin.css">
</head>
<body>
	<div id="side">
		<ul id="nav">
			<li><a href="a_admin.php">ГЛАВНАЯ</a></li>
			<li><a href="goods.php">ИМУЩЕСТВО</a></li>
			<li><a href="users.php">О пользователе</a></li>
			<li><a href="files.php">Файлы</a></li>
			<li><a href="logout.php">ВЫйти</a></li>
		</ul>
	</div>
		
	<div id="content">
		
		<h2>Карточка основного средства</h2>

		<div id="fcon">
		<?php
			include 'connect.php'; session_start(); $goo = $_SESSION['ggg']; $num = $_SESSION['invent'];$name = $_SESSION['nameus'];
			
			$gdata = mysqli_query($connection,"SELECT * FROM `equipment` WHERE `thing` = '$goo' AND `inventnum`='$num' AND `login`='$name';");
			while ($ud=mysqli_fetch_assoc($gdata)) {
					echo "<img src='".$ud['image']."'>";
			}

		?>
		</div>
		
		<div id="scon">
		<?php
			$add = "";
			echo "<form id='u' method='POST' enctype = 'multipart/form-data'>";
			echo "<fieldset id='fset'>";
			echo "<legend>Объект:".$goo." - ".$add."</legend>";
			
			$guser = mysqli_query($connection,"SELECT * FROM `usersinfo` WHERE `login` = '$name';");
			
			echo "<select id='txt' name='ulist'>";
				while ($userlist=mysqli_fetch_assoc($guser)) {
					echo "<option value='".$userlist['login']."'>".$userlist['fullname']."</option>";
				}
			echo "</select><br>";
			
			
			$gdata = mysqli_query($connection,"SELECT * FROM `equipment` WHERE `thing` = '$goo' AND `inventnum`='$num' AND `login`='$name' ;");
			
			while ($ud=mysqli_fetch_assoc($gdata)) {
					echo "<input name='thing' id='txt' placeholder='Название' type='text' value='".$ud['thing']."'><br>";
					echo "<input name='inventnum' id='txt' placeholder='Инвентарный номер' type='text' value='".$ud['inventnum']."'><br>";
					echo "<input type='file' name='file'><br>";
					echo "<input name='pub' id='sub' type='submit' value='ОБНОВИТЬ ДАННЫЕ'>";
					
			}
			
			echo "</form>";

			if (isset($_POST['pub'])) {
				
				$dir='images/'.$name; // определение папки для пользователя с именем name для загрузки файлов (по умолчанию php/images/..)
				
				if(!is_dir($dir)) {
					mkdir($dir, 0777, true); // создаем папку с именем пользователя если она не существовала
				} else {
				
				$first=$_POST['thing'];
				$login=$_POST['ulist'];
				$second=$_POST['inventnum'];
				$upname=basename($_FILES['file']['name']);//записываем имя файла
				$uploadpath=$dir.'/'.$upname; // имя папки + имя файла
				
				//перемещение загруженного файла из временной папки сервера в папку, которую указали (uploadpath)

				if  (move_uploaded_file($_FILES['file']['tmp_name'], $uploadpath)) {
				
				$sql=mysqli_query($connection,"UPDATE `equipment` SET `login`='$login', `thing`='$first',`inventnum`='$second',`image`='$uploadpath' WHERE `thing`='$goo' AND `inventnum` = '$num';");
					} else {
				$sql=mysqli_query($connection,"UPDATE `equipment` SET `login`='$login',`thing`='$first',`inventnum`='$second' WHERE `thing`='$goo';");		
					}

				if ($sql) {
							header("Location:goods.php");
						}
				}
			}

		?>
		</div>
	
	</div>

</body>
</html>