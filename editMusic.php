<?php
	session_start();
		require_once "connect.php";
	
	if(isset($_POST['ISRC'])){
		$wszystko_ok = true;
		$music_update_id = $_GET['musicId'];
		$fileName = $_POST['file_name'];
		$title = $_POST['title'];
		$ISRC = $_POST['ISRC'];
		$composer = $_POST['composer'];
		$author = $_POST['author'];
		$author2 = $_POST['author_2'];
		$time = $_POST['time'];
		
		if(strlen($ISRC)<20){
			$wszystko_ok = false;
			$_SESSION['e_isrc'] = "ISRC musi być dłuższy niż 20 znaków.";
		}
		
		mysqli_report(MYSQLI_REPORT_STRICT);
		try {
			$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
			if($polaczenie->connect_errno!=0){
				throw new Exception(mysqli_connect_errno());
			} else {
				if($wszystko_ok==true){
					//OK
					echo $fileName."RRRRR";
					if($polaczenie->query("UPDATE music SET file_name='$fileName', title='$title', ISRC='$ISRC', composer='$composer', author='$author', author_2='$author2', time='$time' WHERE music_id=$music_update_id")){
						header('Location: music.php');
					} else {
						//echo $polaczenie->error;
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
		<form method="post">
<?php
	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	$musicId = $_GET['musicId'];
	if($rezultat = $polaczenie->query("SELECT * FROM music WHERE music_id=$musicId")){
		$wynik = $rezultat->fetch_assoc();
		$nazwa = $wynik['file_name'];
		$tytul = $wynik['title'];
		$ISRC = $wynik['ISRC'];
		$kompozytor = $wynik['composer'];
		$autor = $wynik['author'];
		$autor_2 = $wynik['author_2'];
		$czas = $wynik['time'];
		
		echo "Nazwa pliku: ".'<br /> <input type="text" name="file_name" value="'.$nazwa.'"/> <br /><br />'."";
		echo "Tytul: ".'<br /> <input type="text" name="title" value="'.$tytul.'"/> <br /><br />'."";
		echo "ISRC: ".'<br /> <input type="text" name="ISRC" value="'.$ISRC.'"/> <br /><br />'."";
		if (isset($_SESSION['e_isrc'])){
				echo '<div class="error">'.$_SESSION['e_isrc'].'</div>';
				unset($_SESSION['e_isrc']);
			}
		echo "Kompozytor: ".'<br /> <input type="text" name="composer" value="'.$kompozytor.'"/> <br /><br />'."";
		echo "Autor: ".'<br /> <input type="text" name="author" value="'.$autor.'"/> <br /><br />'."";
		echo "Autor opracowania: ".'<br /> <input type="text" name="author_2" value="'.$autor_2.'"/> <br /><br />'."";
		echo "Czas [s]: ".'<br /> <input type="number" name="time" value="'.$czas.'"/> <br /><br />'."";
		echo '<input type="submit" value="Edytuj utwór!"/>';
	}
?>
		</form>
	
	</body>
</html>