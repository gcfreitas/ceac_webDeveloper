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
	$pg_act="cesta.php";
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
								<a class="nav-link active text-danger" href="cesta.php"><i class="bi bi-bag-fill text-danger"></i> Cesta</a>
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
				<h1 class="text-center">Cesta</h1>
				
					<?php
					
						if($cliente == "Cliente"){
							echo '<div class="row">
								<div class="col-lg-12">
									<h5 class="text-center">Para ver a cesta, faça o login!</h5>
								</div>
							</div>';
						}else{
							
							//Number of records to be displayed per page
							$display = 30;
							
							//Determine how many pages there are
							if(isset($_GET['p']) && is_numeric($_GET['p'])){
								//Already been determined
								$pages = $_GET['p'];
							}else{
								//Needs to be determined
								//Count the number of records
								$q = "SELECT COUNT(DISTINCT livro_id) FROM cesta WHERE user_id ='".$id_user."'";
								$r = mysqli_query($dbc, $q);
								$row = mysqli_fetch_array($r, MYSQLI_NUM);
								$records = $row[0];
								
								//Calculate the number of pages
								$pages = ceil($records/$display);
							}
							
							//Determinar se cesta esta vazia
							if($pages == 0){
								echo '<div class="row">
									<div class="col-lg-12">
										<h5 class="text-center">A tua cesta de compras está vazia!</h5>
									</div>
								</div>';
							}else{
								//Determine where in the database to start returning results
								if(isset($_GET['s']) && is_numeric($_GET['s'])){
									$start = $_GET['s'];
								}else{
									$start = 0;
								}
								
								$q = "SELECT DISTINCT * FROM livros WHERE EXISTS (SELECT DISTINCT livro_id FROM cesta WHERE cesta.livro_id = livros.livro_id AND user_id ='".$id_user."') ORDER BY livros.l_nome ASC LIMIT $start, $display";
								
								$r = mysqli_query($dbc, $q);
								
								$num = mysqli_num_rows($r);
								
								if($num > 0){
									
									echo "<table align='center' border='0' cellspacing='2' cellpadding='3' width='100%'>
									<tr>
										<th align='left' width='15%'>Imagem</th>
										<td align='left'><b>Nome</b></td>
										<td align='left'><b>Autor</b></td>
										<!--<td align='left'><b>Genero</b></td>-->
										<td align='left'><b>Quant.</b></td>
										<!--<td align='left'><b>Preço</b></td>-->
										<td align='left'><b>Total</b></td>
										<th align='left' width='2%'></th>
										<th align='left' width='2%'></th>
									</tr>";
									$tot = 0;
										while($row = mysqli_fetch_array($r)){
											$d = "SELECT COUNT(id_cesta) FROM cesta WHERE user_id ='".$id_user."' AND livro_id = '".$row['livro_id']."'";
											$dd = mysqli_query($dbc, $d);
											$li = mysqli_fetch_array($dd, MYSQLI_NUM);
											$quant = $li[0];
								
											echo "<tr>
												<td align='left'>
													<form action='livro.php' method='post'>
														<a href='javascript:;' onclick='parentNode.submit();'><img src='Imagens/".$row['l_imagem']."' style='width:40%;height:40%;' /></a>
														<input type='hidden' name='livroid' size='50' maxlength='50' value='".$row['livro_id']."' />
													</form>
												</td>
												<td align='left'>".$row['l_nome']."</td>
												<td align='left'>".$row['l_autor']."</td>
												<!--<td align='left'>".$row['l_genero']."</td>-->
												<td align='left'>".$quant."</td>
												<!--<td align='left'>&euro;".number_format($row['l_preco'],2)."</td>-->
												<td align='left'>&euro;".number_format($row['l_preco']*$quant,2)."</td>
												<td align='left'><form method='post' action='cesta_rem.php'>
													<input type='hidden' name='userid' size='20' maxlength='50' value='$id_user' />
													<input type='hidden' name='livroid' size='50' maxlength='50' value=".$row['livro_id']." />
													<button type='submit' class='btn btn-sm btn-outline-danger'> <i class='bi bi-dash-lg'></i> </button>
												</form></td>
												<td align='left'><form method='post' action='cesta_add.php'>
													<input type='hidden' name='userid' size='20' maxlength='50' value='$id_user' />
													<input type='hidden' name='livroid' size='50' maxlength='50' value=".$row['livro_id']." />
													<input type='hidden' name='pg_act' size='50' maxlength='50' value=".$pg_act." />
													<button type='submit' class='btn btn-sm btn-outline-dark'> <i class='bi bi-plus-lg'></i> </button>
												</form></td>
											</tr>";
											$tot = $tot+$row['l_preco']*$quant;
										}
										//$r2 = mysqli_query($dbc, "SELECT SUM(l_preco) FROM livros WHERE EXISTS (SELECT livro_id FROM cesta WHERE cesta.livro_id = livros.livro_id AND user_id ='".$id_user."'");
										//$tot = mysqli_fetch_array($r2);
										//$tot = $row1['l_preco'];
										echo "<tr>
										<td align='left'><b></b></td>
										<td align='left'><b></b></td>
										<td align='left'><b></b></td>
										<!--<td align='left'><b></b></td>-->
										<td align='left'><b></b></td>
										<td align='left'><b></b></td>
										<td align='left'><b>&euro;".number_format($tot,2)."</b></td>
										<td align='left'><form method='post' action='venda.php'>
											<input type='hidden' name='userid' size='20' maxlength='50' value='$id_user' />
											<input type='hidden' name='v_total' size='50' maxlength='50' value='$tot' />
											<button type='submit' class='btn btn-sm btn-outline-dark'> Comprar </button>
										</form></td>
										<td align='left'><b></b></td>
									</tr>";
									echo "</table>";
								}else{
									echo "<br><br><p>Atualmente não há livros registrados!</p>";
									
									echo "<p><a href='livro_add.php'>Adicionar Livro</a></p>";
								}
								
								//Close mysql connection
								//mysqli_close($dbc);
								
								//Make the links to other pages
								if($pages > 1){
									echo '<br /><p><center>';
									
									//Determine what page the script is
									$current_page = ($start/$display) +1;
									
									//If not the first page create previous link
									If($current_page != 1){
										echo '<a href="cesta.php?s=' .($start - $display). '&p=' .$pages. '"> <= </a> ';
									} 
									
									//Make all the numbers pages
									for($i=1;$i<=$pages;$i++){
										if($i != $current_page){
											echo '<a href="cesta.php?s=' .($display *($i - 1)). '&p=' .$pages. '"> '.$i.' </a>';
										}else{
											echo $i. '';
										}
									}
									
									//if it's not the last page, make a NEXT button
									if($current_page != $pages){
										echo '<a href="cesta.php?s=' .($start + $display). '&p=' .$pages. '"> => </a>';
									}
								}
								echo "</center>";
							}
						}
					?>
					
					
					
				</br>
				
				
			</div>
				
		</div>
			
		<footer class="fixed-bottom">
			
			<?php include '_footer.html'; ?>
			
		</footer>

		<!-- Option 1: Bootstrap Bundle with Popper -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	
	</body>
</html>