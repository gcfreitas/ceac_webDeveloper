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
		<div class="mt-4 p-5 text-dark">
			<div class="container-fluid">
				<?php
				$l = mysqli_query($dbc, "SELECT * FROM livros WHERE livro_id='".$_GET['livro_id']."'");
				$l_row = mysqli_fetch_array($l);
				?>
				<div class="row">
					<div class="col-sm-5">
						<img src="<?php echo 'Imagens/'.$l_row['l_imagem']; ?>" alt="<?php echo $l_row['l_nome']; ?>"/>
					</div>
					<div class="col-sm-7">
					<h4>Editar informações do livro</h4>
				
						<form method="post" action="livro_edit.php">
							
							<p><input type="hidden" name="livroid" size="50" maxlength="50" value="<?php echo $l_row['livro_id']; ?>" /></p>
							<p>Nome do Livro: <input type="text" name="lnome" size="50" maxlength="50" value="<?php echo $l_row['l_nome']; ?>" /></p>
							<p>Autor do Livro: <input type="text" name="lautor" size="50" maxlength="50" value="<?php echo $l_row['l_autor']; ?>" /></p>
							<p>ISNB: <input type="text" name="lisnb" size="20" maxlength="20" value="<?php echo $l_row['isnb']; ?>" /></p>
							<p>Edição: <input type="number" name="ledicao" size="4" maxlength="4" value="<?php echo $l_row['l_edicao']; ?>" /></p>
							<p>Editor: <input type="text" name="leditor" size="50" maxlength="50" value="<?php echo $l_row['l_editor']; ?>" /></p>
							<label for="sel_2" class="form-label">Idioma:</label>
							<select class="form-select" id="sel_2" name="lidioma">
							  
								<?php 
								echo "<option>".$l_row['l_idioma']."</option>";
								$idioma = mysqli_query($dbc, "SELECT idioma FROM idiomas WHERE idioma <> '".$l_row['l_idioma']."' ORDER BY idioma ASC");
								while($idioma_row = mysqli_fetch_array($idioma)){
									echo "<option>".$idioma_row['idioma']."</option>";
								}?>
							</select><br>
							<p>Dimensão: <input type="text" name="ldimensao" size="20" maxlength="50" value="<?php echo $l_row['l_dimensao']; ?>" /></p>
							<p>Encadernação: <input type="text" name="lencaderna" size="20" maxlength="20" value="<?php echo $l_row['l_encaderna']; ?>" /></p>
							<p>Paginas: <input type="number" name="lpaginas" size="6" maxlength="6" value="<?php echo $l_row['l_paginas']; ?>" /></p>
							<?php 
								$c = mysqli_query($dbc,"SELECT * FROM categorias WHERE categoria_id = '".$l_row['l_cat_id']."'");
								$c_row = mysqli_fetch_array($c);
								$g = mysqli_query($dbc,"SELECT * FROM generos WHERE genero_id = '".$l_row['l_gen_id']."'");
								$g_row = mysqli_fetch_array($g);
							?>
							<label for='lcat_id' class='form-label'>Categoria:</label>
							<select class='form-select' id='lcat_id' name='lcat_id'>
							<option value='<?php echo $c_row["categoria_id"];?>'><?php echo $c_row["categoria"];?></option>
							<?php 
							$opc = mysqli_query($dbc, "SELECT * FROM categorias WHERE categoria <> '".$c_row['categoria']."' ORDER BY categoria ASC");
							while($opc_row = mysqli_fetch_array($opc)){?>
								<option value='<?php echo $opc_row["categoria_id"];?>'><?php echo $opc_row["categoria"];?></option>
							<?php } ?>
							
							</select>
							<label for='lgen_id' class='form-label'>Genero:</label>
							<select class='form-select' id='lgen_id' name='lgen_id'>
								<option value='<?php echo $g_row["genero_id"];?>'><?php echo $g_row["genero"];?></option>
							</select>
							<p>Sinopse:</p>
							<textarea rows="10" cols="85" name="lsinopse"> <?php echo $l_row['l_sinopse']; ?> </textarea></p>
							<p>Imagem do Livro: <input type="file" name="limagem" accept="image/png,image/jpeg"/></p>
							<p>Preço do Livro: <input type="number" name="lpreco" min="0" max="1000" step="0.01" value="<?php echo $l_row['l_preco']; ?>" /></p>
							<p><input type="submit" class="btn btn-outline-danger" name="submit" value="Alterar"/> <a class="btn btn-outline-dark" href="estante.php">Voltar</a></p>
						</form>
					</div>
				</div>
			</div>
		</div>
		<footer>
			
			<?php include '_footer.html'; ?>
			
		</footer>

		<!-- Option 1: Bootstrap Bundle with Popper -->
		<script src="function.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	
	</body>
</html>