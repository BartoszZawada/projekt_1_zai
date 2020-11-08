<?php
	session_start();
	
	if((isset($_SESSION['logged'])) && ($_SESSION['logged']==true)){
		header('Location: homePage.php');
		exit();
	}
?>
<!DOCTYPE HTML>
<html lang="pl">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title>Projekt 1 - Zaawansowane Aplikacje Internetowe</title>
		<link rel="stylesheet" type="text/css" href="style.php"/>
	</head>
	
	<body>
	<div class="mainContainer">
		<p> Projekt 1 - Zaawansowane Aplikacje Internetowe </p>
		<p> Prowadzący: dr inż. Przemysław Korpas </p>
		<p> Autor: inż. Bartosz Zawada </p>
		<p> System do raportowania ilości emisji utworów muzycznych </p>
		<br/> <br/>
		<div class="buttons">
			<a style="text-align: left;" href="music.php">
				<button> Sprawdź utwory w bazie danych bez rejestracji! </button>
			</a><br /><br />
			<a style="text-align: right;" href="raports.php">
				<button> Sprawdź raporty w bazie danych bez rejestracji! </button>
			</a> <br /><br />
		</div>

		<form action="zaloguj.php" method="post">
	
		Login: <br /> <input type="text" name="login" /> <br />
		Hasło: <br /> <input type="password" name="haslo" /> <br /><br />
		<input type="submit" value="Zaloguj się" />	
	</form>
<?php
	if(isset($_SESSION['loginError'])) echo $_SESSION['loginError'];
?>
	</div>
	</body>
</html>