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
		$f2 = "user_dados.php";
		
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
	
	//processing form
	
	$registered = 0;

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		$contact_name = $_POST['contact_name'];
		$contact_email = $_POST['contact_email'];
		$contact_subject = $_POST['contact_subject'];
		$contact_mssage = $_POST['contact_mssage'];
		

		if(!empty($contact_name) &&!empty($contact_email) &&!empty($contact_subject) &&!empty($contact_mssage)){
			include('_connection.php');
			
			mysqli_query($dbc, "INSERT INTO help(h_name,h_email,h_subject,h_text,registration_date) VALUES('$contact_name','$contact_email','$contact_subject','$contact_mssage',NOW())");
			
			$registered = mysqli_affected_rows($dbc);
			header('Refresh: 5; URL=contacto.php');
		}
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
								<a class="nav-link" href="catalogo.php"><i class="bi bi-book"></i> Catálogo</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="cesta.php"><i class="bi bi-bag"></i> Cesta</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="sobre.php"><i class="bi bi-info-square"></i> Sobre</a>
							</li>
							<li class="nav-item">
								<a class="nav-link active text-danger" href="contacto.php"><i class="bi bi-chat-text-fill text-danger"></i> Ajuda</a>
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
		
			<h1 class="text-center">Fale conosco</h1>
			
				<?php if($registered == 1){
					echo '<div class="alert alert-success alert-dismissible">
						<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
						<strong>Mensagem enviada com sucesso!</strong>.
					</div>';
				}?>
				<div class="row">
					<div class="col-lg-4">
						<h4 class="text-center"><strong>Fale conosco!<br>Use as informações abaixo:</strong></h4>
						<address>
							<strong>Rubi Livraria</strong><br>
							Costa da Caparica, Portugal 2825-399<br>
							<abbr title="Phone">Tm:</abbr> +351 910.756.478
						</address>
					</div>
					<div class="col-lg-8">
						<form method="post" action="contacto.php" class="form-horizontal" role="form">
							<div class="form-group">
								<label for="contact_name" class="col-lg-2 control-label">Nome</label>
								<div class="col-lg-10">
									<input type="text" class="form-control" name="contact_name" id="contact_name" placeholder="Nome">
								</div>
							</div>
							<div class="form-group">
								<label for="contact_email" class="col-lg-2 control-label">Email</label>
								<div class="col-lg-10">
									<input type="text" class="form-control" name="contact_email" id="contact_email" placeholder="Email">
								</div>
							</div>
							<div class="form-group">
								<label for="contact_subject" class="col-lg-2 control-label">Assunto</label>
								<div class="col-lg-10">
									<input type="text" class="form-control" name="contact_subject" id="contact_subject" placeholder="Assunto">
								</div>
							</div>
							<div class="form-group">
								<label for="contact_msg" class="col-lg-2 control-label">Mensagem</label>
								<div class="col-lg-10">
									<textarea name="contact_mssage" id="contact_mssage" class="form-control" cols="30" rows="10" placeholder="Mensagem"></textarea>
								</div>
							</div>
							<br><p><input class="btn btn-outline-danger" type="submit" value="Enviar" /></p>
						</form>
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