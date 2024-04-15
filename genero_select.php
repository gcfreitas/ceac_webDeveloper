<?php
	
	//Include connection script to database
	include("_connection.php");
	
	$g = mysqli_query($dbc,"SELECT * FROM generos WHERE cat_id = '".$_GET['lcat_id']."'");
	
	echo '<option value="">Selecione um genero</option>';
	while($g_row = mysqli_fetch_array($g)){?>
	<option value="<?php echo $g_row['genero_id']?>"><?php echo $g_row['genero']?></option>
	<?php }?>