<?php
	
	//Start session
	session_set_cookie_params(['httponly' => true]);
	
	session_start();
	
	session_regenerate_id(true);
	
	error_reporting(0);
	
	//Include connection script to database
	include("_connection.php");
	
	//grab values email and password from login form
	
	$login_email = $_POST['login_email'];
	$login_password = $_POST['login_password'];
	
	//Verify client
	if(isset($_SESSION['uid'])){
		
		$id_user = $_SESSION['uid'];
		$query = mysqli_query($dbc, "SELECT * FROM users WHERE user_id='".$id_user."'");
		$row = mysqli_fetch_array($query);
		$cliente = $row['first_name'];
		$icon = "bi bi-person-fill text-danger";
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
	
	//create the query and number of rows returned from the query

	$query = mysqli_query($dbc, "SELECT * FROM users WHERE email='".$login_email."'");
	$numrows = mysqli_num_rows($query);
	
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		//check if there is rows with that email
		
		if($numrows != 0){
	
			//grab the email and password from that row returned before
			
			while($row = mysqli_fetch_array($query)){
				$dbemail = $row['email'];
				$dbpass = $row['password'];
				$dbfirstname = $row['first_name'];
				$dbid = $row['user_id'];
			}
				
			//check email and password

			if($login_password==$dbpass){
				$_SESSION['uid'] = $dbid;
				if($login_email=="admin@rubilivraria.com"){
					header('Refresh: 0; URL=estante.php?');
				}else{
					header('Refresh: 0; URL=catalogo.php?');
				}
				
				
			}else{
				echo "Sua password está incorreta! Volte ao LOGIN";
				header('Refresh: 5; URL=login.php');
			}
		}else{
			echo "<p>Email inválido! Se você não estiver registrado, registre-se <a href='cconta.php'>AQUI</a></p>";
			echo "<p>Ou volte ao <a href='login.php'>LOGIN</a></p>";
		}
	}else{
		echo "<h3>Você deve fazer o <a href='login.php'>LOGIN</a></h3>";
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
								<a class="nav-link" href="contacto.php"><i class="bi bi-chat-text"></i> Ajuda</a>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link active dropdown-toggle text-danger" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
		
		<main class="mt-4 p-5">
			<div class="container">
				<ul class="nav nav-tabs nav-light">
					<li class="nav-item">
						<a class="nav-link active text-danger" style="width: 200px; text-align: center;" href="login.php">Login</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-dark" style="background: #FAF0E6; width: 200px; text-align: center;" href="cconta.php">Criar conta</a>
					</li>
				</ul>

				</br>
				
				<form method="post" action="login.php">
					<div class="row">
						<div class="col-sm-4 mb-3 mt-3">
							<input type="email" class="form-control" id="email" placeholder="Email" name="login_email">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4 mb-3">
							<input type="password" class="form-control" id="pwd" placeholder="Password" name="login_password">
						</div>
					</div>
					<p><input class="btn btn-outline-danger" type="submit" value="Iniciar Sessão" /></p>
				</form>
			</div>
		</main>
			
		<footer class="fixed-bottom">
			
			<?php include '_footer.html'; ?>
			
		</footer>

		<!-- Option 1: Bootstrap Bundle with Popper -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	
	</body>
</html>