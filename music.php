<?php
	session_start();
	
	//if(!isset($_SESSION['logged'])){
	//	header('Location: index.php');
	//	exit();
	//}
	
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
		unset($_SESSION['e_isrc']);
	}
	if(isset($_SESSION['logged'])){
		echo "<p>Witaj ".$_SESSION['username'].'! <a href="wyloguj.php"><button>Wyloguj się!</button></a></p>';
	}
	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	$sql = "SELECT * FROM music";
	$wynik = $polaczenie->query($sql);
	echo '<table cellpadding=2 border=1 class="center"';
		echo "<tr>";
		echo "<th>Lp.</th>";
		echo "<th>Nazwa pliku</th>";
		echo "<th>Tytuł</th>";
		echo "<th>ISRC</th>";
		echo "<th>Kompozytor</th>";
		echo "<th>Autor</th>";
		echo "<th>Autor opracowania</th>";
		echo "<th>Czas [s]</th>";
		echo "</tr>";
		$lp = 0;
	while($r = $wynik->fetch_assoc()){
		$lp++;
		echo "<tr>";
		echo "<td>".$lp."</td>";
		echo "<td>".$r['file_name']."</td>";
		echo "<td>".$r['title']."</td>";
		echo "<td>".$r['ISRC']."</td>";
		echo "<td>".$r['composer']."</td>";
		echo "<td>".$r['author']."</td>";
		echo "<td>".$r['author_2']."</td>";
		echo "<td>".$r['time']."</td>";
		if(isset($_SESSION['logged'])){
			echo "<td>";
			echo '<a href="editMusic.php?musicId='.$r['music_id'].'"><button> Edytuj utwór! </button></a>';
			echo "</td>";
		}
		if(isset($_SESSION['logged'])){
			echo "<td>";
			echo '<a href="deleteMusic.php?musicId='.$r['music_id'].'"><button> Usuń utwór! </button></a>';
			echo "</td>";
		}
		echo "</tr>";
	}
	echo "</table>";
	echo "<br />";
	echo '<div class="buttons">';
	if(isset($_SESSION['logged'])){
		echo '<a href="homePage.php"><button> Wróć do strony głównej! </button></a> <a href="addMusic.php"><button> Dodaj utwór do bazy danych! </button></a>';
	} else {
		echo '<a href="homePage.php"><button> Wróć do strony głównej! </button></a>';
	}
	echo "</div>";
	$polaczenie->close();
?>
	
</body>
</html>