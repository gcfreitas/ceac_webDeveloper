<?php
	
	error_reporting(0);
	
//Start session
	session_set_cookie_params(['httponly' => true]);
	
	session_start();
	
	session_regenerate_id(true);
	
	error_reporting(0);
	
	//Include connection script to database
	if($_SERVER['REQUEST_METHOD']=='GET'){
		include("_connection.php");
		
		$result = mysqli_query($dbc, "DELETE FROM generos WHERE genero_id='".$_GET['gen_id']."'");
		echo "<h4>O gênero foi excluido!</h4>";
		header('Refresh: 5; URL=classificacao.php');
	}
		
?>