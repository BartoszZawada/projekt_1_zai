<?php
	session_start();
	if(isset($_POST['count'])){
		$wszystko_ok = true;
		$count = $_POST['count'];
		if($count == null){
			$wszystko_ok = false;
			$_SESSION['e_count'] = "To pole nie może pozostać puste.";
		}
		if($count < 0){
			$wszystko_ok = false;
			$_SESSION['e_count'] = "Liczba odtworzeń musi być większa od 0.";
		}
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		$musicId = $_GET['musicId'];
		$raport_name = $_SESSION['currentRaport'];
		try {
			$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
			if($polaczenie->connect_errno!=0){
				throw new Exception(mysqli_connect_errno());
			} else {
				if($wszystko_ok==true){
					$result = $polaczenie->query("SELECT * FROM raport WHERE name='$raport_name'");
					$raport = $result->fetch_assoc();
					$raportId = $raport['raport_id'];
					echo "Nazwa raportu = ".$raport_name." Id:".$raportId;
					$sql = "SELECT * FROM music_raport WHERE music_id='$musicId' AND raport_id='$raportId'";
					$res = $polaczenie->query($sql);
					if($res->num_rows==0){
						if($polaczenie->query("INSERT INTO music_raport VALUES(DEFAULT,'$musicId','$raportId','$count')")){
							header('Location: showRaport.php?raportId='.$raportId.'');
						}
						else {
							echo $polaczenie->error;
						}
					} else {
						$row = $res->fetch_assoc();
						$new_counter = $row['count'];
						$new_counter+=$count;
						if($polaczenie->query("UPDATE music_raport SET count='$new_counter' WHERE music_id=$musicId AND raport_id='$raportId'")){
							header('Location: showRaport.php?raportId='.$raportId.'');
						}
						else {
							echo $polaczenie->error;
						}
						
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
		Ilość nadań: <br /> <input type="number" name="count" /> <br /> <br />
		<input type="submit" value="Dodaj do raportu!" /> <a href="index.php"><button> Wróć do strony głównej! </button></a>
	
	</form>
<?php
	if(isset($_SESSION['loginError'])) echo $_SESSION['loginError'];
?>
	
	</body>
</html>