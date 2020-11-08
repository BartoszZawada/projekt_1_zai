<?php
	session_start();
	if(!isset($_SESSION['logged'])){
		header('Location: index.php');
		exit();
	}
	
	if(isset($_POST['month'])){
		$wszystko_ok = true;
		$name = $_POST['name'];
		$month = $_POST['month'];
		$year = $_POST['year'];
		if($name == null){
			$wszystko_ok = false;
			$_SESSION['e_name'] = "Nie podałeś nazwy raportu!";
		}
		if($month == null){
			$wszystko_ok = false;
			$_SESSION['e_month'] = "Musisz podać miesiąc transmisji.";
		}
		if($month < 0 || $month > 12){
			$wszystko_ok = false;
			$_SESSION['e_month'] = "Numer miesiąca musi być większy od 0 a mniejszy od 12.";
		}
		if($year == null){
			$wszystko_ok = false;
			$_SESSION['e_year'] = "Musisz podać rok transmisji.";
		}
		if($year < 0 ){
			$wszystko_ok = false;
			$_SESSION['e_year'] = "Numer roku musi być większy od 0.";
		}
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		try {
			$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
			if($polaczenie->connect_errno!=0){
				throw new Exception(mysqli_connect_errno());
			} else {
				if($wszystko_ok==true) {
					if($polaczenie->query("INSERT INTO raport VALUES(DEFAULT,'$name','$month','$year')")){
						$_SESSION['currentRaport'] = $name;
						header('Location: selectMusic.php');
					}
					else {
						//echo $polaczenie->error;
						echo "<p> Nie udało się dodać raportu o podanych wartościach do bazy danych! </p>";
						header('Location: raports.php');
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
		<form method="post">
		Nazwa raportu: <br /> <input type="text" name="name" /> <br /><br />
		<?php 
			if (isset($_SESSION['e_name'])){
				echo '<div class="error">'.$_SESSION['e_name'].'</div>';
				unset($_SESSION['e_name']);
			}
		?>
		Miesiac: <br /> <input type="number" name="month" /> <br /><br />
		<?php 
			if (isset($_SESSION['e_month'])){
				echo '<div class="error">'.$_SESSION['e_month'].'</div>';
				unset($_SESSION['e_month']);
			}
		?>
		Rok: <br /> <input type="number" name="year" /> <br /><br />
		<?php 
			if (isset($_SESSION['e_year'])){
				echo '<div class="error">'.$_SESSION['e_year'].'</div>';
				unset($_SESSION['e_year']);
			}
		?>
		<input type="submit" value="Dodaj raport!" />
	
	</form>
	
	</body>
</html>