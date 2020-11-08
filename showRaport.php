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
	
<?php
	if(isset($_SESSION['logged'])){
		echo "<p>Witaj ".$_SESSION['username'].'! <a href="wyloguj.php"><button> Wyloguj się! </button></a></p>';
	}
	$raportID = $_GET['raportId'];
	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	$sql = "SELECT * FROM music_raport WHERE raport_id='$raportID'";
	$wynik = $polaczenie->query($sql);
	
	$queryRes = $polaczenie->query("SELECT * FROM raport WHERE raport_id='$raportID'");
	$raport = $queryRes->fetch_assoc();
	$_SESSION['currentRaport'] = $raport['name'];
		
		if($wynik->num_rows == 0){
			echo "<p> Ten raport jest pusty. Nie ma dodanych żadnych utworów.";
		} else {
		echo "<p> Nazwa raportu: ".$raport['name']."</p>";
		echo "<p> Raport za okres: ".$raport['month']." / ".$raport['year']."</p>".'<br />';
		echo '<table cellpadding=2 border=1 class="center"';
		echo "<tr>";
		echo "<th>Lp.</th>";
		echo "<th>Nazwa piosenki</th>";
		echo "<th>Ilość odtworzeń</th>";
		echo "</tr>";
		$lp = 0;
		while($r = $wynik->fetch_assoc()){
			$lp++;
			$musicId = $r['music_id'];
			$queryRes = $polaczenie->query("SELECT * FROM music WHERE music_id=$musicId");
			$music = $queryRes->fetch_assoc();
			echo "<tr>";
			echo "<td>".$lp."</td>";
			echo "<td>".$music['title']."</td>";
			echo "<td>".$r['count']."</td>";
			if(isset($_SESSION['logged'])){
				echo "<td>";
				echo '<a href="editMusicInRaport.php?musicId='.$r['music_id'].'&raportId='.$raportID.'"><button> Edytuj ilość odtworzeń! </button></a>';
				echo "</td>";
			}
			if(isset($_SESSION['logged'])){
				echo "<td>";
				echo '<a href="deleteFromRaport.php?musicId='.$r['music_id'].'&raportId='.$raportID.'"><button> Usuń z raportu! </button></a>';
				echo "</td>";
			}
			echo "</tr>";
		}
		}
	echo "</table>";
	echo "<br />";
	echo '<div class="buttons">';
	echo '<a href="raports.php"><button> Wróć do strony z raportami! </button></a>';
	
			if(isset($_SESSION['logged'])){
				//echo '<a href="addToReport.php?raportId='.$r['raport_id'].'"><button> Dodaj do raportu! </button></a>';
				echo ' <a href="selectMusic.php"><button> Dodaj utwór do raportu! </button></a>';
			}
	echo '</div>';
	$polaczenie->close();
?>
	
	</body>
</html>