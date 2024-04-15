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
								<a class="nav-link active" href="estante.php"><i class="bi bi-bookshelf"></i> Estante de Livros</a>
							</li>
							<li class="nav-item">
								<a class="nav-link active text-danger" href="classificacao.php"><i class="bi bi-collection-fill text-danger"></i> Classificacao</a>
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
		
		<div class="container-fluid pt-5 text-dark">
		<br>
			<div class="row">
				
			</div>
			<div class="row">
				<div class="col-sm-5">
					<?php
						//Number of records to be displayed per page
						$display = 15;
						
						//Determine how many pages there are
						if(isset($_GET['p1']) && is_numeric($_GET['p1'])){
							//Already been determined
							$c_pages = $_GET['p1'];
						}else{
							//Needs to be determined
							//Count the number of records
							$cq = mysqli_query($dbc, "SELECT COUNT(categoria_id) FROM categorias");
							$c_row = mysqli_fetch_array($cq, MYSQLI_NUM);
							$c_records = $c_row[0];
							
							//Calculate the number of pages
							$c_pages = ceil($c_records/$display);
							
							
						}
						//Determine where in the database to start returning results
						if(isset($_GET['s1']) && is_numeric($_GET['s1'])){
							$c_start = $_GET['s1'];
						}else{
							$c_start = 0;
						}
						
						$c = mysqli_query($dbc, "SELECT * FROM categorias ORDER BY categoria ASC LIMIT $c_start, $display");
						$c_num = mysqli_num_rows($c);
						
						if($c_num > 0){
							echo "
								<div class='container-fluid text-dark'>
									<h6>Existem ".$c_records." categorias registadas.</h6>";
								
									echo "<h5><center><a class='btn btn-light' data-bs-toggle='offcanvas' href='#offcanvas_add_cat' role='button' aria-controls='offcanvas_add_cat'>
										<i class='bi bi-plus-square text-dark'></i>
									</a></center></h5>
									<div class='offcanvas offcanvas-start' tabindex='-1' id='offcanvas_add_cat' aria-labelledby='offcanvas_add_cat_Label'>
										<div class='offcanvas-header'>
											<h5 class='offcanvas-title' id='offcanvas_add_cat_Label'>Nova categoria</h5>
											<button type='button' class='btn-close' data-bs-dismiss='offcanvas' aria-label='Close'></button>
										</div>
										<div class='offcanvas-body'>
											<div>
												<form method='post' action='categoria_add.php'>
												<p>Nome: <input type='text' name='lcategoria' size='45' maxlength='50' /></p>
												<p><input type='submit' class='btn btn-outline-danger' name='submit' value='Adicionar'/></p>
												</form>
											</div>
										</div>
									</div>";
									//<!--<a href='categoria_add.php'><i class='bi bi-plus-square text-dark'></i></a></center></h5>-->";
									
									echo "<table align='center' border='1' cellspacing='2' cellpadding='10' width='100%'>
									<tr>
										<td align='left'><b>Categorias</b></td>
										<td align='left'><b></b></td>
										<td align='left'><b></b></td>
									</tr>";
										while($c_row = mysqli_fetch_array($c)){
											echo "
											<tr>
												<td align='left'>".$c_row['categoria']."</td>
												<td align='left'><a href='categoria_dados.php?cat_id=".$c_row['categoria_id']."'><i class='bi bi-pencil text-dark'></i></a></td>
												<td align='left'><a href='categoria_delete.php?cat_id=".$c_row['categoria_id']."'><i class='bi bi-trash3 text-dark'></i></a></td>
											</tr>";
										}
									echo "</table>
								</div>";
						}else{
							echo "<br><br><p>Atualmente não há categorias registadas!</p>";
							
							echo "<p><a href='categoria_add.php'>Adicionar categoria</a></p>";
						}
						//Make the links to other pages
						if($pages1 > 1){
							echo '<br /><p><center>';
							
							//Determine what page the script is
							$c_current_page = ($c_start/$display) +1;
							
							//If not the first page create previous link
							If($c_current_page != 1){
								echo '<a href="classificacao.php?s1=' .($c_start - $display). '&p1=' .$c_pages. '"> <i class="bi bi-caret-left text-dark"></i> </a> ';
							} 
							
							//Make all the numbers pages
							for($ci=1;$ci<=$c_pages;$ci++){
								if($ci != $c_current_page){
									echo '<a href="classificacao.php?s1=' .($display *($ci - 1)). '&p1=' .$c_pages. '"> '.$ci.' </a>';
								}else{
									echo $ci. '';
								}
							}
							
							//if it's not the last page, make a NEXT button
							if($c_current_page != $c_pages){
								echo '<a href="classificacao.php?s1=' .($c_start + $display). '&p1=' .$c_pages. '"> <i class="bi bi-caret-right text-dark"></i> </a>';
							}
						}
						echo "</center>";
					?>
				</div>
				<div class="col-sm-7">
					<?php
						//Determine how many pages there are
						if(isset($_GET['p2']) && is_numeric($_GET['p2'])){
							//Already been determined
							$g_pages = $_GET['p2'];
						}else{
							//Needs to be determined
							//Count the number of records
							$gq = mysqli_query($dbc, "SELECT COUNT(genero_id) FROM generos");
							$g_row = mysqli_fetch_array($gq, MYSQLI_NUM);
							$g_records = $g_row[0];
							
							//Calculate the number of pages
							$g_pages = ceil($g_records/$display);
							
							
						}
						//Determine where in the database to start returning results
						if(isset($_GET['s2']) && is_numeric($_GET['s2'])){
							$g_start = $_GET['s2'];
						}else{
							$g_start = 0;
						}
						
						$g = mysqli_query($dbc, "SELECT * FROM generos ORDER BY genero ASC LIMIT $g_start, $display");
						$g_num = mysqli_num_rows($g);
						
						if($g_num > 0){
							echo "
								<div class='container-fluid text-dark'>
									<h6>Existem ".$g_records." generos registados.</h6>";
									
									echo "<h5><center><a class='btn btn-light' data-bs-toggle='offcanvas' href='#offcanvas_add_gen' role='button' aria-controls='offcanvas_add_gen'>
										<i class='bi bi-plus-square text-dark'></i>
									</a></center></h5>
									<div class='offcanvas offcanvas-end' tabindex='-1' id='offcanvas_add_gen' aria-labelledby='offcanvas_add_gen_Label'>
										<div class='offcanvas-header'>
											<h5 class='offcanvas-title' id='offcanvas_add_gen_Label'>Novo gênero</h5>
											<button type='button' class='btn-close' data-bs-dismiss='offcanvas' aria-label='Close'></button>
										</div>
										<div class='offcanvas-body'>
											<div>
												<form method='post' action='genero_add.php'>
												<label for='sel_cat' class='form-label'>Categoria:</label>
												<select class='form-select' id='sel_cat' name='lcat'>";
													$c = mysqli_query($dbc, "SELECT categoria FROM categorias ORDER BY categoria ASC");
													while($cat_row = mysqli_fetch_array($c)){
														echo "<option>".$cat_row['categoria']."</option>";
													}
												echo "</select><br>
												<p>Gênero: <input type='text' name='lgenero' size='45' maxlength='50' /></p>
												<p><input type='submit' class='btn btn-outline-danger' name='submit' value='Adicionar'/></p>
												</form>
											</div>
										</div>
									</div>";
								
									echo "<table align='center' border='1' cellspacing='2' cellpadding='10' width='100%'>
									<tr>
										<td align='left'><b>Gêneros</b></td>
										<td align='left'><b>Categoria</b></td>
										<td align='left'><b></b></td>
										<td align='left'><b></b></td>
									</tr>";
										while($g_row = mysqli_fetch_array($g)){
											$gc = mysqli_query($dbc, "SELECT * FROM categorias WHERE categoria_id='".$g_row['cat_id']."'");
											$gc_row = mysqli_fetch_array($gc);
											echo "
											<tr>
												<td align='left'>".$g_row['genero']."</td>
												<td align='left'>".$gc_row['categoria']."</td>
												<td align='left'><a href='genero_dados.php?gen_id=".$g_row['genero_id']."'><i class='bi bi-pencil text-dark'></i></a></td>
												<td align='left'><a href='genero_delete.php?gen_id=".$g_row['genero_id']."'><i class='bi bi-trash3 text-dark'></i></a></td>
											</tr>";
										}
									echo "</table>
								</div>";
						}else{
							echo "<br><br><p>Atualmente não há gêneros registadas!</p>";
							
							echo "<p><a href='genero_add.php'>Adicionar genero</a></p>";
						}
						//Close mysql connection
						mysqli_close($dbc);
						
						//Make the links to other pages
						if($g_pages > 1){
							echo '<br /><p><center>';
							
							//Determine what page the script is
							$current_page = ($g_start/$display) +1;
							
							//If not the first page create previous link
							If($current_page != 1){
								echo '<a href="classificacao.php?s2=' .($g_start - $display). '&p2=' .$g_pages. '"> <i class="bi bi-caret-left text-dark"></i> </a> ';
							} 
							
							//Make all the numbers pages
							for($i=1;$i<=$g_pages;$i++){
								if($i != $current_page){
									echo '<a href="classificacao.php?s2=' .($display *($i - 1)). '&p2=' .$g_pages. '"> '.$i.' </a>';
								}else{
									echo $i. '';
								}
							}
							
							//if it's not the last page, make a NEXT button
							if($current_page != $g_pages){
								echo '<a href="classificacao.php?s2=' .($g_start + $display). '&p2=' .$g_pages. '"> <i class="bi bi-caret-right text-dark"></i> </a>';
							}
						}
						echo "</center>";
					?>
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