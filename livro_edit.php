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
		include("_connection.php");
		if(!empty($_POST["limagem"])){
			$q = mysqli_query($dbc, "UPDATE livros SET l_nome='".$_POST['lnome']."', l_autor='".$_POST["lautor"]."', isnb='".$_POST["lisnb"]."', l_edicao='".$_POST["ledicao"]."', l_editor='".$_POST["leditor"]."', l_idioma='".$_POST["lidioma"]."', l_dimensao='".$_POST["ldimensao"]."', l_encaderna='".$_POST["lencaderna"]."', l_paginas='".$_POST["lpaginas"]."', l_cat_id='".$_POST["lcat_id"]."', l_gen_id='".$_POST["lgen_id"]."', l_sinopse='".$_POST["lsinopse"]."', l_imagem='".$_POST["limagem"]."', l_preco='".$_POST["lpreco"]."' WHERE livro_id='".$_POST['livroid']."'");
		}else{
			$q = mysqli_query($dbc, "UPDATE livros SET l_nome='".$_POST['lnome']."', l_autor='".$_POST["lautor"]."', isnb='".$_POST["lisnb"]."', l_edicao='".$_POST["ledicao"]."', l_editor='".$_POST["leditor"]."', l_idioma='".$_POST["lidioma"]."', l_dimensao='".$_POST["ldimensao"]."', l_encaderna='".$_POST["lencaderna"]."', l_paginas='".$_POST["lpaginas"]."', l_cat_id='".$_POST["lcat_id"]."', l_gen_id='".$_POST["lgen_id"]."', l_sinopse='".$_POST["lsinopse"]."', l_preco='".$_POST["lpreco"]."' WHERE livro_id='".$_POST['livroid']."'");
		}
		
		
		if(mysqli_affected_rows($dbc) == 1){
			echo "As informações do livro foram atualizadas com sucesso!";
			header('Refresh: 5; URL=estante.php');
		}else{
			echo "Erro! Alteração falhou...";
			header('Refresh: 0; URL=estante.php');
		}
		
		
	}else{
		echo "<a href='login.html'>Faça Login</a>";
	}
		
?>