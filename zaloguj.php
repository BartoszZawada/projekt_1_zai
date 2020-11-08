<?php

	session_start();
	require_once "connect.php";

	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if($polaczenie->connect_errno!=0){
		echo "Error: ".$polaczenie->connect_errno;
	} else {		
		$login = htmlentities($_POST['login'], ENT_QUOTES, "UTF-8");
		$haslo = $_POST['haslo'];
		
		$haslo_hash = password_hash($haslo, PASSWORD_DEFAULT);
		
		if($rezultat = @$polaczenie->query(
		sprintf("SELECT * FROM user WHERE username='%s'",
		mysqli_real_escape_string($polaczenie,$login))
		)){
			$ilu_userow = $rezultat->num_rows;
			if($ilu_userow>0){
				$wiersz = $rezultat->fetch_assoc();
				if(password_verify($haslo, $wiersz['password'])){
					$_SESSION['logged'] = true;
					$_SESSION['username'] = $wiersz['username'];
					unset($_SESSION['loginError']);
					$rezultat->free_result();
					header('Location: homePage.php');
				}
			} else {
				$_SESSION['loginError'] = '<span style="color:red"> Nieprawidłowy login lub hasło! </span>';
				header('Location: index.php');
			}
		}
		
		$polaczenie->close();
	}
	
	
?>