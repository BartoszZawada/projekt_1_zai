<?php
	session_start();
	if(!isset($_SESSION['logged'])){
		header('Location: index.php');
		exit();
	}
	require_once "connect.php";
	if(isset($_POST['counter'])){
		$wszystko_ok = true;
		$count = $_POST['counter'];
		
		mysqli_report(MYSQLI_REPORT_STRICT);
		try {
			$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
			if($polaczenie->connect_errno!=0){
				throw new Exception(mysqli_connect_errno());
			} else {
				if($wszystko_ok==true){
					//OK
					$raportID = $_GET['raportId'];
					$musicID = $_GET['musicId'];
					if($polaczenie->query("UPDATE music_raport SET count='$count' WHERE music_id=$musicID AND raport_id='$raportID'")){
						header('Location: showRaport.php?raportId='.$raportID.'');
					} else {
						echo $polaczenie->error;
					}
				} 
				else{
					throw new Exception($polaczenie->error);
				}
				$polaczenie->close();
			}
		} catch(Exception $exception) {
			echo 'Błąd serwera! Coś poszło nie tak!'.$exception;
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
<?php
	if(isset($_SESSION['logged'])){
		echo "<p>Witaj ".$_SESSION['username'].'! <a href="wyloguj.php"><button> Wyloguj się! </button></a></p>';
	}
	$raportID = $_GET['raportId'];
	$musicID = $_GET['musicId'];
	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	$sql = "SELECT * FROM music_raport WHERE raport_id='$raportID'";
	$wynik = $polaczenie->query($sql);
		if($wynik->num_rows == 0){
			echo "<p> Nie znaleziono wpisu pasującego do podanych danych.";
		} else {
			$data = $wynik->fetch_assoc();
			$count = $data['count'];
			echo '<form method="post">';
			echo "Ilość odtworzeń: ".'<br /> <input type="number" name="counter" value="'.$count.'"/> <br /><br />'."";
			echo '<input type="submit" value="Edytuj ilość odtworzeń!"/>';
			echo "</form>";
		}
	echo "<br />";
	echo '<div class="buttons">';
	echo '<a href="index.php" style="text-align: center;"><button> Wróć do strony głównej! </button></a>';
	echo '</div>';
	$polaczenie->close();
?>
	
	</body>
</html>