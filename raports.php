<?php
	session_start();
	require_once "connect.php";
	
	if(isset($_POST['count'])){
		$wszystko_ok = true;
		$count = $_POST['count'];
		$music_id = $_GET['musicId'];
		if($count == null){
			$wszystko_ok = false;
			$_SESSION['e_count'] = "Musisz podać ilość odtworzeń.";
		}
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		try {
			$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
			if($polaczenie->connect_errno!=0){
				throw new Exception(mysqli_connect_errno());
			} else {
				if($wszystko_ok==true) {
					if($polaczenie->query("INSERT INTO musicOrder VALUES(DEFAULT,'$month','$year','$count','$music_id',NULL)")){
						header('Location: music.php');
					}
					else {
						echo $polaczenie->error;
					}
				} else{
					throw new Exception($polaczenie->error);
				}
				$polaczenie->close();
			}
		} catch(Exception $exception) {
			echo 'Błąd serwera! Coś poszło nie tak!';
		}
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
	<div class="buttons">
	<?php
	if (isset($_SESSION['e_isrc'])){
		echo '<div class="error">'.$_SESSION['e_isrc'].'</div>';
		unset($_SESSION['e_isrc']);
	}
	if(isset($_SESSION['logged'])){
		echo "<p>Witaj ".$_SESSION['username'].'! <a href="wyloguj.php"><button> Wyloguj się! </button></a></p>';
	}
	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	$sql = "SELECT * FROM raport";
	$wynik = $polaczenie->query($sql);
	if($wynik->num_rows==0){
		echo "<p>W bazie danych nie ma utworzonych żadnych raportów!".'<br />';
	} else {
	echo '<table cellpadding=2 border=1 class="center"';
		echo "<tr>";
		echo "<th>Lp.</th>";
		echo "<th>Nazwa raportu</th>";
		echo "<th>Miesiąc</th>";
		echo "<th>Rok</th>";
		echo "</tr>";
		$lp = 0;
	while($r = $wynik->fetch_assoc()){
		$lp++;
		echo "<tr>";
		echo "<td>".$lp."</td>";
		echo "<td>".$r['name']."</td>";
		echo "<td>".$r['month']."</td>";
		echo "<td>".$r['year']."</td>";
		if(isset($_SESSION['logged'])){
			echo "<td>";
			echo '<a href="showRaport.php?raportId='.$r['raport_id'].'"><button> Pokaż raport! </button></a>';
			echo "</td>";
		}
		if(isset($_SESSION['logged'])){
			echo "<td>";
			echo '<a href="deleteRaport.php?raportId='.$r['raport_id'].'"><button> Usuń raport! </button></a>';
			echo "</td>";
		}
		echo "</tr>";
	}
	echo "</table>";
	}
	echo "<br />";
	if(isset($_SESSION['logged'])){
		echo "<td>";
		echo '<a href="homePage.php"><button> Wróć do strony głównej! </button></a> <a href="addRaport.php"><button> Utwórz nowy raport! </button></a>';
		echo "</td>";
	} else {
		echo '<a href="homePage.php"><button> Wróć do strony głównej! </button></a>';	
	}
	$polaczenie->close();
?>
	</div>
	</body>
</html>