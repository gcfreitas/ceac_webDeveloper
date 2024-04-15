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
		

		if(!empty($user_id) &&!empty($book_id)){
			
			
			$query1 = mysqli_query($dbc, "SELECT * FROM cesta WHERE user_id = '".$user_id."' AND livro_id = '".$book_id."'");
			$row1 = mysqli_fetch_array($query1);
			$cesta_id = $row1['id_cesta'];
			$result = mysqli_query($dbc, "DELETE FROM cesta WHERE id_cesta = '$cesta_id'");
			header('Refresh: 0; URL=cesta.php');
		}
	}else{
		header('Refresh: 0; URL=cesta.php');
	}

?>