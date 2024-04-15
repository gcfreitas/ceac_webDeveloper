<?php
	
	error_reporting(0);
	
//Start session
	session_set_cookie_params(['httponly' => true]);
	
	session_start();
	
	session_regenerate_id(true);
	
	error_reporting(0);
	
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
	
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		if(!empty($_POST["genero"]) &&!empty($_POST["cat_id"])){
			$q = mysqli_query($dbc, "UPDATE generos SET genero='".$_POST['genero']."' ,cat_id='".$_POST['cat_id']."' WHERE genero_id='".$_POST['gen_id']."'");
		}
		
		
		if(mysqli_affected_rows($dbc) == 1){
			echo "O gênero foi atualizado com sucesso!";
			header('Refresh: 5; URL=classificacao.php');
		}else{
			echo "Erro! Alteração falhou...";
			header('Refresh: 5; URL=classificacao.php');
		}
		
		
	}else{
		echo "<a href='login.html'>Faça Login</a>";
	}
	

?>
