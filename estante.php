<?php
	
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
	
	//Number of records to be displayed per page
	$display = 15;
	
	//Determine how many pages there are
	if(isset($_GET['p']) && is_numeric($_GET['p'])){
		//Already been determined
		$pages = $_GET['p'];
	}else{
		//Needs to be determined
		//Count the number of records
		$q = "SELECT COUNT(livro_id) FROM livros";
		$r = mysqli_query($dbc, $q);
		$row = mysqli_fetch_array($r, MYSQLI_NUM);
		$records = $row[0];
		
		//Calculate the number of pages
		$pages = ceil($records/$display);
		
		
	}
	//Determine where in the database to start returning results
	if(isset($_GET['s']) && is_numeric($_GET['s'])){
		$start = $_GET['s'];
	}else{
		$start = 0;
	}
	$q = "SELECT * FROM livros ORDER BY l_nome ASC LIMIT $start, $display";
	
	$r = mysqli_query($dbc, $q);
	
	$num = mysqli_num_rows($r);
	
	if($num > 0){
		echo "<div class='mt-4 p-5 text-dark'>
			<div class='container-fluid'>
				<h6>Existem ".$num." livros registados.</h6>";
			
				echo "<h5><center><a href='livro_add.php'><i class='bi bi-plus-square text-dark'></i></a></center></h5>";
				
				echo "<table align='center' border='1' cellspacing='2' cellpadding='10' width='100%'>
				<tr>
					<td align='left'><b>Imagem</b></td>
					<td align='left'><b>Nome</b></td>
					<td align='left'><b>Autor</b></td>
					<td align='left'><b>Categoria</b></td>
					<td align='left'><b>Genero</b></td>
					<td align='left'><b>Preço</b></td>
					<td align='left'><b></b></td>
					<td align='left'><b></b></td>
				</tr>";
					while($row = mysqli_fetch_array($r)){
						$c = mysqli_query($dbc,"SELECT * FROM categorias WHERE categoria_id = '".$row['l_cat_id']."'");
						$c_row = mysqli_fetch_array($c);
						$g = mysqli_query($dbc,"SELECT * FROM generos WHERE genero_id = '".$row['l_gen_id']."'");
						$g_row = mysqli_fetch_array($g);
						echo "<tr>
							<td align='left'><img src='Imagens/".$row['l_imagem']."' style='width:40%;height:40%;' /></td>
							<td align='left'>".$row['l_nome']."</td>
							<td align='left'>".$row['l_autor']."</td>
							<td align='left'>".$c_row['categoria']."</td>
							<td align='left'>".$g_row['genero']."</td>
							<td align='left'>".$row['l_preco']."</td>
							<td align='left'><a href='livro_dados.php?livro_id=".$row['livro_id']."'><i class='bi bi-pencil text-dark'></i></a></td>
							<td align='left'><a href='livro_delete.php?livro_id=".$row['livro_id']."'><i class='bi bi-trash3 text-dark'></i></a></td>
						</tr>";
					}
				echo "</table>
			</div>
		</div>";
	}else{
		echo "<br><br><p>Atualmente não há livros registrados!</p>";
		
		echo "<p><a href='livro_add.php'>Adicionar Livro</a></p>";
	}
	//Close mysql connection
	mysqli_close($dbc);
	
	//Make the links to other pages
	if($pages > 1){
		echo '<br /><p><center>';
		
		//Determine what page the script is
		$current_page = ($start/$display) +1;
		
		//If not the first page create previous link
		If($current_page != 1){
			echo '<a href="estante.php?s=' .($start - $display). '&p=' .$pages. '"> <i class="bi bi-caret-left text-dark"></i> </a> ';
		} 
		
		//Make all the numbers pages
		for($i=1;$i<=$pages;$i++){
			if($i != $current_page){
				echo '<a href="estante.php?s=' .($display *($i - 1)). '&p=' .$pages. '"> '.$i.' </a>';
			}else{
				echo $i. '';
			}
		}
		
		//if it's not the last page, make a NEXT button
		if($current_page != $pages){
			echo '<a href="estante.php?s=' .($start + $display). '&p=' .$pages. '"> <i class="bi bi-caret-right text-dark"></i> </a>';
		}
	}
	echo "</center>";
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
		
		<footer>
			
			<?php include '_footer.html'; ?>
			
		</footer>

		<!-- Option 1: Bootstrap Bundle with Popper -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	
	</body>
</html>