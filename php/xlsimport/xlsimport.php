<?php

/*получаем логин пользователя из глобальной переменной*/
session_start();
$name = $_SESSION['nameus'];

/*подключаем composer и библиотеки для работы с Excel*/
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader;

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
	
	/*echo "<pre>";
	print_r($data);*/
	
	/*переносим полученные данные из PHP массива в базу данных*/
	foreach ($data as $row) 
	{
		$thing = $row['0'];
		$inventnum = $row['1'];		
		
	require_once __DIR__ . '/../../config.php';
	$host = DB_HOST;
	$user = DB_USER;
	$pass = DB_PASS;
	$dbnm = DB_NAME;
		
		$LINK=mysqli_connect($host,$user,$pass,$dbnm);
		$insert_query=mysqli_query($LINK,"INSERT INTO `equipment` (`thing`,`inventnum`,`inventnumcheck`,`login`,`image`) VALUES ('$thing','$inventnum','','$name','');");
		
		if ($insert_query) 
		{
			header("Location:..\goods.php");
		}
		
	}
	
	
}
		
	

?>

