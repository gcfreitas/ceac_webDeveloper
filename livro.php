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
		$i1 = "bi bi-box-arrow-in-right";
		$f1 = "login.php";
		$op2 = "Criar conta";
		$i2 = "bi bi-person-add";
		$f2 = "cconta.php";
		
	}
	
	//Var list
	$pg_act="catalogo.php";
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
					<a class="navbar-brand" href="index.php"><img src="Imagens/logo.png" style="height:45px; margin-top:-10px;" alt="Logo"> Rubi Livraria </a>
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav-collapse-header" aria-controls="nav-collapse-header" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="nav-collapse-header">
						<ul class="navbar-nav me-auto mb-2 mb-lg-0">
							<li class="nav-item">
								<a class="nav-link" href="index.php"><i class="bi bi-gem"></i> Home</a>
							</li>
							<li class="nav-item">
								<a class="nav-link active text-danger" href="catalogo.php"><i class="bi bi-book-fill text-danger"></i> Catálogo</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="cesta.php"><i class="bi bi-bag"></i> Cesta</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="sobre.php"><i class="bi bi-info-square"></i> Sobre</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="contacto.php"><i class="bi bi-chat-text"></i> Ajuda</a>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
									<i class="<?php echo $icon; ?>"></i> <?php echo $cliente; ?>
								</a>
								<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
								<li><a class="dropdown-item" href="<?php echo $f1; ?>"><i class="<?php echo $i1; ?>"></i> <?php echo $op1; ?></a></li>
								<li><a class="dropdown-item" href="<?php echo $f2; ?>"><i class="<?php echo $i2; ?>"></i> <?php echo $op2; ?></a></li>
								</ul>
							</li>
						</ul>
						<form class="d-flex" method="get" action="search.php">
							<input class="form-control me-2" name="search_var" type="search" placeholder="Search" aria-label="Search">
							<button class="btn btn-outline-dark" type="submit">
								<i class="bi bi-search"></i>
							</button>
						</form>
					</div>
				</div>
			</nav>
		</header>
		
			<div class="mt-4 p-5 text-dark">
				<div class="container-fluid">
		
				<h1 class="text-center">Detalhes do Livro</h1>
				<?php
				$l = mysqli_query($dbc, "SELECT * FROM livros WHERE livro_id='".$_POST['livroid']."'");
				$l_row = mysqli_fetch_array($l);
				$c = mysqli_query($dbc, "SELECT * FROM categorias WHERE categoria_id='".$l_row['l_cat_id']."'");
				$c_row = mysqli_fetch_array($c);
				$g = mysqli_query($dbc, "SELECT * FROM generos WHERE genero_id='".$l_row['l_gen_id']."'");
				$g_row = mysqli_fetch_array($g);
				?>
				<div class="row">
					<div class="col-sm-5">
						<img src="<?php echo 'Imagens/'.$l_row['l_imagem']; ?>" alt="<?php echo $l_row['l_nome']; ?>"/>
					</div>
					<div class="col-sm-7">
					<h4><?php echo $l_row['l_nome']; ?></h4>
						<?php if($cliente == "Cliente"){
							echo '<p class="card-text" style="text-align: right">&euro;'.number_format($l_row['l_preco'],2).' <a href="login.php" class="btn btn-outline-danger"><i class="bi bi-bag-plus"></i></a></p>';
						}else{
							echo '<form method="post" action="cesta_add.php">
								<input type="hidden" name="userid" size="20" maxlength="50" value="'.$id_user.'" />
								<input type="hidden" name="livroid" size="50" maxlength="50" value="'.$l_row['livro_id'].'" />
								<input type="hidden" name="pg_act" size="50" maxlength="50" value="'.$pg_act.'" />
							<p class="card-text" style="text-align: right">&euro;'.number_format($l_row['l_preco'],2).'
							<button type="submit" class="btn btn-outline-danger"> <i class="bi bi-bag-plus"></i> </button>
							</form>';
						}
						?>
						<p>Autor do Livro: <b><?php echo $l_row['l_autor']; ?></b> </p>
						<p>ISNB: <b><?php echo $l_row['isnb']; ?></b></p>
						<p>Edição: <b><?php echo $l_row['l_edicao']; ?></b></p>
						<p>Editor: <b><?php echo $l_row['l_editor']; ?></b></p>
						<p>Idioma: <b><?php echo $l_row['l_idioma']; ?></b></p>
						<p>Dimensão: <b><?php echo $l_row['l_dimensao']; ?></b></p>
						<p>Encadernação: <b><?php echo $l_row['l_encaderna']; ?></b></p>
						<p>Paginas: <b><?php echo $l_row['l_paginas']; ?></b></p>
						<p>Categoria: <b><?php echo $c_row['categoria']; ?></b></p>
						<p>Genero: <b><?php echo $g_row['genero']; ?></b></p>
						<p>Sinopse:</p>
						<p> <?php echo nl2br($l_row['l_sinopse']); ?>" </p>
						
				</div>
				</div>
				</div>
			</div>
		
		<footer>
			
			<?php include '_footer.html'; ?>
			
		</footer>

		<!-- Option 1: Bootstrap Bundle with Popper -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	
	</body>
</html>