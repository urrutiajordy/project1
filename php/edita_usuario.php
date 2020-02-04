<?php
include('conexion.php');

$id = $_POST['id'];

//OBTENEMOS LOS VALORES DEL PRODUCTO

$valores = $conexion->query("SELECT * from usuario where id_usuario = '$id'");
$valores2 = $valores->fetch_array();

$datos = array(
				0 => $valores2['id_usuario'], 
				1 => $valores2['usuario'], 
				2 => $valores2['clave'], 
				3 => $valores2['nombre_apellido'],
				4 => $valores2['correo'], 
				5 => $valores2['celular'], 
				6 => $valores2['id_perfil'], 
				);
echo json_encode($datos);
?>