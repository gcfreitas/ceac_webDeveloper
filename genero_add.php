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
	
	//processing form

	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		if(!empty($_POST["lgenero"]) &&!empty($_POST["lcat"])){
			$c = mysqli_query($dbc, "SELECT categoria_id FROM categorias WHERE categoria = '".$_POST["lcat"]."'");
			$cat_row = mysqli_fetch_array($c);
			$q = mysqli_query($dbc, "SELECT COUNT(genero_id) FROM generos WHERE genero = '".$_POST["lgenero"]."' AND cat_id = '".$cat_row["categoria_id"]."'");
			$row = mysqli_fetch_array($q, MYSQLI_NUM);
			$records = $row[0];
			if($records > 0){
				echo "<h4>Esse gênero já existe</h4>";
				header('Refresh: 5; URL=classificacao.php');
			}else{
				
				mysqli_query($dbc, "INSERT INTO generos(genero, cat_id) VALUES('".$_POST["lgenero"]."','".$cat_row["categoria_id"]."')");
				
				echo "<h3>Gênero adicionado com sucesso!</h3>";
				header('Refresh: 5; URL=classificacao.php');
			}
		}else{
			echo "ERROR: Please fill all values of the form";
		}
	}else{
		echo "<h3>Por favor, complete o formulário.</h3>";
	}
?>