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
	
	//Var list
	$pg_act="catalogo.php";
	
	$g = mysqli_query($dbc, "SELECT * FROM generos WHERE genero_id = '".$_GET['gen']."'");
	$g_row = mysqli_fetch_array($g);
	$gen = $g_row['genero'];
	
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
		
		<main class="mt-4 p-5 text-dark">
			<div class="container-fluid">
		
				<div class="row">
					<div class="col-lg-12">
						<br><h5><?php echo $gen; ?></h5><br>
					</div>
				</div>
				
				<?php
					
					//Number of records to be displayed per page
					$display = 6;
					$prat = $gen;
					
					//Determine how many pages there are
					if(isset($_GET['p4']) && is_numeric($_GET['p4'])){
						//Already been determined
						$pages4 = $_GET['p4'];
					}else{
						//Needs to be determined
						//Count the number of records
						$q = "SELECT COUNT(livro_id) FROM livros WHERE l_gen_id='".$_GET['gen']."'";
						$r = mysqli_query($dbc, $q);
						$row = mysqli_fetch_array($r, MYSQLI_NUM);
						$records = $row[0];
						
						//Calculate the number of pages
						$pages4 = ceil($records/$display);
					}
					
					//Determine where in the database to start returning results
					if(isset($_GET['s4']) && is_numeric($_GET['s4'])){
						$start4 = $_GET['s4'];
					}else{
						$start4 = 0;
					}
					
					$q = "SELECT * FROM livros WHERE l_gen_id='".$_GET['gen']."' ORDER BY l_nome ASC LIMIT $start4, $display";
					
					$r = mysqli_query($dbc, $q);
					
					$num = mysqli_num_rows($r);
					
					if($num > 0){
						echo '<div class="row">';
							while($row = mysqli_fetch_array($r)){
								if($cliente == "Cliente"){
									echo '<div class="col-lg-2">
										<div class="card border-light" style="width:150px">
											<form action="livro.php" method="post">
												<a href="javascript:;" onclick="parentNode.submit();"><img class="card-img-top" src="Imagens/'.$row['l_imagem'].'" /></a>
												<input type="hidden" name="livroid" size="50" maxlength="50" value="'.$row['livro_id'].'" />
											</form>
											<div class="card-body">
												<p class="card-text" style="text-align: right">&euro;'.number_format($row['l_preco'],2).' <a href="login.php" class="btn btn-outline-danger"><i class="bi bi-bag-plus"></i></a></p>
												<p class="card-text" style="text-align: left"><b>'.$row['l_nome'].'</b> </p>
												<p class="card-text" style="text-align: left">'.$row['l_autor'].' </p>
											</div>
										</div>
									</div>';
								}else{
									echo '<div class="col-lg-2">
										<div class="card border-light" style="width:150px">
											<form action="livro.php" method="post">
												<a href="javascript:;" onclick="parentNode.submit();"><img class="card-img-top" src="Imagens/'.$row['l_imagem'].'" /></a>
												<input type="hidden" name="livroid" size="50" maxlength="50" value="'.$row['livro_id'].'" />
											</form>
											<div class="card-body">
												<form method="post" action="cesta_add.php">
													<input type="hidden" name="userid" size="20" maxlength="50" value='.$id_user.' />
													<input type="hidden" name="livroid" size="50" maxlength="50" value="'.$row['livro_id'].'" />
													<input type="hidden" name="pg_act" size="50" maxlength="50" value="'.$pg_act.'" />
												<p class="card-text" style="text-align: right">&euro;'.number_format($row['l_preco'],2).'
												<button type="submit" class="btn btn-outline-danger"> <i class="bi bi-bag-plus"></i> </button>
												</p></form>
												<p class="card-text" style="text-align: left"><b>'.$row['l_nome'].'</b></p>
												<p class="card-text" style="text-align: left">'.$row['l_autor'].' </p>												
											</div>
										</div>
									</div>';
								}
							}
						'</div>';
					}
					//Close mysql connection
					//mysqli_close($dbc);
					
					//Make the links to other pages
					if($pages4 > 1){
						echo '<br /><p><center>';
						
						//Determine what page the script is
						$current_page4 = ($start4/$display) +1;
						
						//If not the first page create previous link
						If($current_page4 != 1){
							echo '<a class="text-body" style="text-decoration: none;" href="genero.php?gen=' .$_GET['gen']. '&s4=' .($start4 - $display). '&p4=' .$pages4. '"> <i class="bi bi-chevron-compact-left"></i> </a> ';
						} 
						
						//Make all the numbers pages
						for($i4=1;$i4<=$pages4;$i4++){
							if($i4 != $current_page4){
								echo '<a class="text-body" style="text-decoration: none; margin: 0 3px;" href="genero.php?gen=' .$_GET['gen']. '&s4=' .($display *($i4 - 1)). '&p4=' .$pages4. '"> '.$i4.' </a>';
							}else{
								echo '<a class="text-danger" style="text-decoration: none; margin: 0 3px;"> '.$i4.' </a>';
							}
						}
						
						//if it's not the last page, make a NEXT button
						if($current_page4 != $pages4){
							echo '<a class="text-body" style="text-decoration: none;" href="genero.php?gen=' .$_GET['gen']. '&s4=' .($start4 + $display). '&p4=' .$pages4. '"> <i class="bi bi-chevron-compact-right"></i> </a>';
						}
					}
				?>
			</div>
		</main>
		
		<footer>
			
			<?php include '_footer.html'; ?>
			
		</footer>

		<!-- Option 1: Bootstrap Bundle with Popper -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	
	</body>
</html>