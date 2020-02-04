<?php
	$server = "localhost";
	$user = "unmsmfacuodon";
	$sharset = "utf8";
	$password = "=oNqy$[@Aem6";
	$bd = "unmsmfac_odontologia";

	$conexion = mysqli_connect($server, $user, $password, $bd);
	mysqli_set_charset($conexion, $sharset);
	if (!$conexion){ 
		die('Error de Conexión: ' . mysqli_connect_errno());	
	}	
?>

