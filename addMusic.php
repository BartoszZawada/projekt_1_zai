<?php
	session_start();
	
	if(isset($_POST['ISRC'])){
		$wszystko_ok = true;
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
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		try {
			$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
			if($polaczenie->connect_errno!=0){
				throw new Exception(mysqli_connect_errno());
			} else {
				if($wszystko_ok==true){
					//OK
					$music = $polaczenie->query("SELECT * FROM music");
					$music_size = $music->num_rows;
					$music_size++;
					if($polaczenie->query("INSERT INTO music VALUES(DEFAULT,'$fileName','$title','$ISRC','$composer','$author','$author2','$time')")){
						header('Location: music.php');
					}
					else {
						echo $polaczenie->error;
					}
				} 
				else{
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
		<form method="post">
	
		Nazwa pliku: <br /> <input type="text" name="file_name" /> <br /><br />
		Tytuł: <br /> <input type="text" name="title" /> <br /><br />
		ISRC: <br /> <input type="text" name="ISRC" /> <br /><br />
		<?php 
			if (isset($_SESSION['e_isrc'])){
				echo '<div class="error">'.$_SESSION['e_isrc'].'</div>';
				unset($_SESSION['e_isrc']);
			}
		?>
		Kompozytor: <br /> <input type="text" name="composer" /> <br /><br />
		Autor: <br /> <input type="text" name="author" /> <br /><br />
		Autor opracowania: <br /> <input type="text" name="author_2" /> <br /><br />
		Czas [s]: <br /> <input type="number" name="time" /> <br /><br />
		<input type="submit" value="Dodaj utwór!" />
	
	</form>
	
	</body>
</html>