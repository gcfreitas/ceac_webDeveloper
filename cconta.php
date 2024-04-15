<?php

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
	
	//processing form
	
	$registered = 0;
	
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		$reg_fname = $_POST['reg_fname'];
		$reg_lname = $_POST['reg_lname'];
		$reg_email = $_POST['reg_email'];
		$reg_password = $_POST['reg_password'];
		$reg_address = $_POST['reg_address'];
		$reg_zip = $_POST['reg_zip'];
		$reg_birthday = $_POST['reg_birthday'];

		if(!empty($reg_fname) &&!empty($reg_lname) &&!empty($reg_email) &&!empty($reg_password) &&!empty($reg_address) &&!empty($reg_zip) &&!empty($reg_birthday)){
			include('_connection.php');
			
			mysqli_query($dbc, "INSERT INTO users(first_name,last_name,email,password,address,zip,birthday,registration_date) VALUES('$reg_fname','$reg_lname','$reg_email','$reg_password','$reg_address','$reg_zip','$reg_birthday',NOW())");
			
			$registered = mysqli_affected_rows($dbc);
			
			echo "<h3>You have registered successfully! Please login <a href='login.php'>HERE</a></h3>";
			header('Refresh: 5; URL=login.php');
		}else{
			echo "ERROR: Please fill all values of the form";
			header('Refresh: 5; URL=cconta.php');
		}
	}else{
		echo "<h3>Please complete the form.</h3>";
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
		
		<div class="mt-4 p-5">
			<div class="container">
				<ul class="nav nav-tabs nav-light">
					<li class="nav-item">
						<a class="nav-link text-dark" style="background: #FAF0E6; width: 200px; text-align: center;" href="login.php">Login</a>
					</li>
					<li class="nav-item">
						<a class="nav-link active text-danger" style="width: 200px; text-align: center;" href="cconta.php">Criar conta</a>
					</li>
				</ul>
				
				</br>
				<?php if($registered == 1){
					echo '<div class="alert alert-success">
						<strong>Conta criada com sucesso!</strong> Faca o <a href="login.php" class="alert-link">login</a>.
					</div>';
				}?>
				<form method="post" action="cconta.php">
					<div class="row">
						<div class="col-sm-4">
							<p>Nome: <input type="text" class="form-control" name="reg_fname" size="50" maxlength="50"/></p>
						</div>
						<div class="col-sm-4">
							<p>Sobrenome: <input type="text" class="form-control" name="reg_lname" size="50" maxlength="50"/></p>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-5">
							<p>Email: <input type="text" class="form-control" name="reg_email" size="50" maxlength="50"/></p>
						</div>
						<div class="col-sm-3">
							<p>Password: <input type="password" class="form-control" name="reg_password" size="50" maxlength="50"/></p>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<p>Endereço: <input type="text" class="form-control" name="reg_address" size="50" maxlength="50"/></p>
						</div>
						<div class="col-sm-2">
							<p>Código postal: <input type="text" class="form-control" name="reg_zip" size="50" maxlength="50"/></p>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-2">
							<p>Data de Nascimento: <input type="date" class="form-control" name="reg_birthday" size="50" maxlength="50"/></p>
						</div>
						<div class="col-sm-4">
							<br><p><input class="btn btn-outline-danger" type="submit" value="Criar conta" /></p>
						</div>
					</div>
					
				</form>
			</div>
		</div>
			
		<footer class="fixed-bottom">
			
			<?php include '_footer.html'; ?>
			
		</footer>

		<!-- Option 1: Bootstrap Bundle with Popper -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	
	</body>
</html>