<?php
	session_start();
	require_once "connect.php";
	
	mysqli_report(MYSQLI_REPORT_STRICT);
	
	try{
		$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
		if($polaczenie->connect_errno!=0){
			throw new Exception(mysqli_connect_errno());
		} else {
			$raport_deleted_id = $_GET['raportId'];
			if($polaczenie->query("DELETE FROM music_raport WHERE raport_id=$raport_deleted_id")){
				if($polaczenie->query("DELETE FROM raport WHERE raport_id=$raport_deleted_id")){
					header('Location: raports.php');
				}			
			}

			$polaczenie->close();
		}
	} catch (Exception $exception){
		echo 'Błąd serwera! Coś poszło nie tak!'.$exception;
	}
?>