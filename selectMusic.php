<?php
	session_start();
	if(!isset($_SESSION['logged'])){
		header('Location: index.php');
		exit();
	}
		require_once "connect.php";
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
	<?php
	if (isset($_SESSION['e_isrc'])){
		echo '<div class="error">'.$_SESSION['e_isrc'].'</div>';
		unset($_SESSION['e_nick']);
	}
	if(isset($_SESSION['logged'])){
		echo "<p>Witaj ".$_SESSION['username'].'! <a href="wyloguj.php"><button>Wyloguj się!</button></a></p>';
	}
	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	$sql = "SELECT * FROM music";
	$wynik = $polaczenie->query($sql);
	echo "<p> Wybierz piosenki, które chciałbyś umieścić w raporcie! ".'<br />';
	echo '<table cellpadding=2 border=1 class="center">';
		echo "<tr>";
		echo "<th>Lp.</th>";
		echo "<th>Tytuł</th>";
		echo "<th></th>";
		echo "</tr>";
	while($r = $wynik->fetch_assoc()){
		echo "<tr>";
		echo "<td>".$r['music_id']."</td>";
		echo "<td>".$r['title']."</td>";
		if(isset($_SESSION['logged'])){
			echo "<td>";
			echo '<a href="addToReport.php?musicId='.$r['music_id'].'"><button>Dodaj do raportu! </button></a>';
			echo "</td>";
		}
		echo "</tr>";
	}
	echo "</table>";
	echo "<br />";
	
	echo '<div class="buttons">';
	echo '<a href="index.php"><button>Wróć do strony głównej!</button></a>';
	echo "</div>";
	$polaczenie->close();
?>
	
	</body>
</html>