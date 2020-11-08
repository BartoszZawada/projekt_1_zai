<?php
	session_start();
	require_once "connect.php";
	
	mysqli_report(MYSQLI_REPORT_STRICT);
	$wszystko_ok=true;
		try {
			$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
			if($polaczenie->connect_errno!=0){
				throw new Exception(mysqli_connect_errno());
			} else {
				if($wszystko_ok==true){
					$musicID = $_GET['musicId'];
					if($polaczenie->query("DELETE FROM music_raport WHERE music_id=$musicID")){
						if($polaczenie->query("DELETE FROM music WHERE music_id=$musicID")){
							header('Location: music.php');
						} else {
							echo $polaczenie->error;
						}
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
			echo 'Coś poszło nie tak!'.$exception;
		}
?>