<?php

/*подключаем composer и библиотеки для работы с Excel*/
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader;

$globaluser = '';

if(isset($_POST['impex'])) {
	
	/*загружаем файл во временную папку на сервере и проверяем тип файла на соответствие Excel(xls,xlsx)*/
	$upload = $_FILES['excel-file']['name'];
	$extension = pathinfo($upload,PATHINFO_EXTENSION);
	if ($extension == 'xlsx' || $extension == 'xls') {
		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
					
	}
	$spreadsheet=$reader->load($_FILES['excel-file']['tmp_name']);
	
	/*переносим полученные данные из Excel в PHP массив*/
	$data = $spreadsheet->getActiveSheet()->toArray();
	
	/*переносим полученные данные из PHP массива в базу данных*/
	foreach ($data as $row) 
	{
		$username = $row['0'];
		$password = $row['1'];
		$fullname = $row['2'];		

		
	require_once __DIR__ . '/../../config.php';
	$host = DB_HOST;
	$user = DB_USER;
	$pass = DB_PASS;
	$dbnm = DB_NAME;
		
		/*переносим полученные данные из PHP массива в таблицу логинов и паролей*/
		
		$LINK=mysqli_connect($host,$user,$pass,$dbnm);
		$insert_query=mysqli_query($LINK,"INSERT INTO `users` (`login`,`passw`) VALUES ('$username','$password');");
		
		
		$LINK1=mysqli_connect($host,$user,$pass,$dbnm);
		
		$select_query = mysqli_query($LINK1,"SELECT * FROM `users` WHERE `login`='$username'");
		
		while ($newdata = mysqli_fetch_assoc($select_query)) {

			$globaluser = $newdata['login'];
			
		}
		
		echo $globaluser;
		
		$LINK2=mysqli_connect($host,$user,$pass,$dbnm);
		
		$insert_query1 = mysqli_query($LINK2,"INSERT INTO `usersinfo` (`login`,`fullname`,`location`,`image`) VALUES ('$globaluser','$fullname','','');");
		
		if ($insert_query1)
		{
			header("location:../users.php");
		}
		
	}
	
	
}
		
	

?>

