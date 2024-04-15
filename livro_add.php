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
	
	$lname = $_POST['name'];
	$lautor = $_POST['autor'];
	$lgenero = $_POST['genero'];
	$limagem = $_POST['imagem'];
	$lpreco = $_POST['preco'];
	
	if(!empty($_POST["lnome"]) &&!empty($_POST["lautor"]) &&!empty($_POST["lisnb"]) &&!empty($_POST["ledicao"]) &&!empty($_POST["leditor"]) &&!empty($_POST["lidioma"]) &&!empty($_POST["ldimensao"]) &&!empty($_POST["lencaderna"]) &&!empty($_POST["lpaginas"]) &&!empty($_POST["lcat_id"]) &&!empty($_POST["lgen_id"]) &&!empty($_POST["lsinopse"]) &&!empty($_POST["limagem"]) &&!empty($_POST["lpreco"])){
	
		include('_connection.php');
		
		mysqli_query($dbc, "INSERT INTO livros(l_nome, l_autor, isnb, l_edicao, l_editor, l_idioma, l_dimensao, l_encaderna, l_paginas, l_cat_id, l_gen_id, l_sinopse, l_imagem, l_preco) VALUES('".$_POST['lnome']."', '".$_POST["lautor"]."', '".$_POST["lisnb"]."', '".$_POST["ledicao"]."', '".$_POST["leditor"]."', '".$_POST["lidioma"]."', '".$_POST["ldimensao"]."', '".$_POST["lencaderna"]."', '".$_POST["lpaginas"]."', '".$_POST["lcat_id"]."', '".$_POST["lgen_id"]."', '".$_POST["lsinopse"]."', '".$_POST["limagem"]."', '".$_POST["lpreco"]."')");
		
		$registered = mysqli_affected_rows($dbc);
		
		echo "<h3>Livro adicionado com sucesso! você será redirecionado para a estante em 5 segundos...</h3>";
		header('Refresh: 0; URL=estante.php');
	}else{
		echo "ERROR: Please fill all values of the form";
	}
}else{
	echo "<h3>Por favor, complete o formulário.</h3>";
}
?>

<!doctype html>
<html lang="pt-PT">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
		<meta name="keywords" content="Store, Book, Manuais Escolares, Livros, Livraria, Buy, Cheap" />
		<meta name="desciption" content="Online Book Store" />
		<meta name="author" content="Gustavo Freitas" />
		
		<!-- Bootstrap CSS -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
		
		<!-- Title -->
		<title>Rubi Livraria</title>		
	</head>
	<body>
	<header>
		
			<!-- navbar --> 
			<nav class="navbar navbar-expand-lg fixed-top" style="background: #FAF0E6">
				<div class="container-fluid">
					<a class="navbar-brand" href="#"><img src="Imagens/logo.png" style="height:45px; margin-top:-10px;" alt="Logo"> Rubi Livraria </a>
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav-collapse-header" aria-controls="nav-collapse-header" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="nav-collapse-header">
						<ul class="navbar-nav me-auto mb-2 mb-lg-0">
							<li class="nav-item">
								<a class="nav-link active text-danger" href="estante.php"><i class="bi bi-bookshelf text-danger"></i> Estante de Livros</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="classificacao.php"><i class="bi bi-collection"></i> Classificacao</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="user_rel.php?"><i class="bi bi-person-rolodex"></i> Relação de Clientes</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="message.php?"><i class="bi bi-inboxes"></i> Mensagens</a>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
									<i class="<?php echo $icon; ?>"></i> <?php echo $cliente; ?>
								</a>
								<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
								<li><a class="dropdown-item" href="<?php echo $f1; ?>"><?php echo $op1; ?></a></li>
								<!--<li><a class="dropdown-item" href="<?php echo $f2; ?>"><?php echo $op2; ?></a></li>-->
								</ul>
							</li>
						</ul>
						<!--<form class="d-flex">
							<input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
							<button class="btn btn-outline-dark" type="submit">
								<i class="bi bi-search"></i>
							</button>
						</form>-->
					</div>
				</div>
			</nav>
		</header>
		<main class="mt-4 p-5 text-dark">
			<div class="container-fluid">
				<div class="row">
					<div class="col-sm-6">
						<h4>Adicionar livro</h4>
					
						<form method="post" action="livro_add.php">
							
							<p>Nome do Livro: <input type="text" name="lnome" size="50" maxlength="50" /></p>
							<p>Autor do Livro: <input type="text" name="lautor" size="50" maxlength="50" /></p>
							<p>ISNB: <input type="text" name="lisnb" size="20" maxlength="20" /></p>
							<p>Edição: <input type="number" name="ledicao" size="4" maxlength="4" /></p>
							<p>Editor: <input type="text" name="leditor" size="50" maxlength="50" /></p>
							<label for="sel_2" class="form-label">Idioma:</label>
							<select class="form-select" id="sel_2" name="lidioma">
							  
								<?php 
								echo "<option>".$l_row['l_idioma']."</option>";
								$idioma = mysqli_query($dbc, "SELECT idioma FROM idiomas WHERE idioma <> '".$l_row['l_idioma']."' ORDER BY idioma ASC");
								while($idioma_row = mysqli_fetch_array($idioma)){
									echo "<option>".$idioma_row['idioma']."</option>";
								}?>
							</select><br>
							<p>Dimensão: <input type="text" name="ldimensao" size="20" maxlength="50" /></p>
							<p>Encadernação: <input type="text" name="lencaderna" size="20" maxlength="20" /></p>
							<p>Paginas: <input type="number" name="lpaginas" size="6" maxlength="6" /></p>
							<label for="lcat_id" class="form-label">Categoria:</label>
							<select class='form-select' id='lcat_id' name='lcat_id'>
								<?php $nc = mysqli_query($dbc, "SELECT * FROM categorias ORDER BY categoria ASC");
								echo "<option value=''>Selecione uma categoria</option>";
								while($nc_row = mysqli_fetch_array($nc)){?>
									<option value='<?php echo $nc_row["categoria_id"] ?>'><?php echo $nc_row['categoria'] ?></option>
								<?php } ?>
							</select><br>
							<label for="lgen_id" class="form-label">Genero:</label>
							<select class="form-select" id="lgen_id" name="lgen_id">
								<option value="">Selecione uma categoria</option>
							</select>
							<p>Sinopse:</p>
							<textarea rows="10" cols="75" name="lsinopse"> </textarea></p>
							<p>Imagem do Livro: <input type="file" name="limagem" accept="image/png,image/jpeg"/></p>
							<p>Preço do Livro: <input type="number" name="lpreco" min="0" max="1000" step="0.01" /></p>
							<p><input type="submit" class="btn btn-outline-danger" name="submit" value="Adicionar"/> <a class="btn btn-outline-dark" href="estante.php">Voltar</a></p>
						</form>
					</div>
				</div>
			</div>
		</main>
		
		<footer>
			
			<?php include '_footer.html'; ?>
			
		</footer>

		<!-- Option 1: Bootstrap Bundle with Popper -->
		<script src="function.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	
	</body>
</html>