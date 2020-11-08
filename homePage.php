<?php
	session_start();
	require_once "connect.php";
	if(!isset($_SESSION['logged'])){
		header('Location: index.php');
		exit();
	}
	
	if(isset($_SESSION['logged'])){
		echo "<p>Witaj ".$_SESSION['username'].'! <a href="wyloguj.php"><button>Wyloguj się!</button></a></p>';
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
	<br />
	<p> Projekt 1 - Zaawansowane Aplikacje Internetowe </p>
	<p> Prowadzący: dr inż. Przemysław Korpas </p>
	<p> Autor: inż. Bartosz Zawada </p>
	<div class="buttons">
<?php
	if(isset($_SESSION['logged'])){
		echo '<a href="music.php"><button> Pokaż utwory w bazie danych! </button></a> <a href="raports.php"><button> Pokaż raporty! </button></a>';
	} else {
		echo '<a href="homePage.php"><button> Wróć do strony głównej! </button></a>';
	}
?>
	</div>
	</body>
</html>