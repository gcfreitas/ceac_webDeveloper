
<?php

$connect_hostname = "localhost";
$connect_username = "root";
$connect_password = "";
$connect_dbname = "rubi_livraria";

//conectando ao mysql

$dbc = mysqli_connect($connect_hostname, $connect_username, $connect_password ,$connect_dbname) OR die("coult not connect to database, ERROR: ".mysqli_connect_error());

//set encoding

mysqli_set_charset($dbc, "utf8");

?>