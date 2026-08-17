<!DOCTYPE html>
<html>
<head>
	<title>Страница администратора</title>
	<link rel="stylesheet" type="text/css" href="css/maxcss.css">
	<script type="text/javascript" src="js/script.js"></script>
</head>
<body>


	<div id="regs">

		<form id="reg" method="POST" action="phpadmin/sign.php">
		<fieldset id="fset">
			<legend>Форма авторизации для администратора</legend>
			<input id="txt" type="text" name="username"><br>
			<input id="psw" type="password" name="passname"><br>
			<input id="sub" type="submit" value="АВТОРИЗАЦИЯ" name="subin">
		</fieldset>
		</form>
	</div>

</body>
</html>