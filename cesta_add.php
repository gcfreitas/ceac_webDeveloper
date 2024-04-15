<?php
	
	//Start session
	session_set_cookie_params(['httponly' => true]);
	
	session_start();
	
	session_regenerate_id(true);
	
	//Include connection script to database
	include("_connection.php");
	
	//Verify client
	if(isset($_SESSION['uid'])){
		
		$id_user = $_SESSION['uid'];
		$query = mysqli_query($dbc, "SELECT * FROM users WHERE user_id='".$id_user."'");
		$row = mysqli_fetch_array($query);
		$cliente = $row['first_name'];
		$icon = "bi bi-person-fill";
		$op1 = "Logout";
		$f1 = "logout.php";
		$op2 = "Meus dados";
		$f2 = "myaccount.php";
		
	}else{
		
		$cliente = "Cliente";
		$icon = "bi bi-person";
		$op1 = "Login";
		$f1 = "login.php";
		$op2 = "Criar conta";
		$f2 = "cconta.php";
		
	}
	
	//processing form

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		$user_id = $_POST['userid'];
		$book_id = $_POST['livroid'];
		$pg_act = $_POST['pg_act'];
		

		if(!empty($user_id) &&!empty($book_id)){
			include('_connection.php');
			
			mysqli_query($dbc, "INSERT INTO cesta(user_id,livro_id) VALUES('$user_id','$book_id')");
			
			$registered = mysqli_affected_rows($dbc);
			
			header('Refresh: 0; URL='.$_POST['pg_act']);
		}else{
			header('Refresh: 0; URL='.$_POST['pg_act']);
		}
	}else{
		header("Refresh: 0; URL=index.php");
	}
?>