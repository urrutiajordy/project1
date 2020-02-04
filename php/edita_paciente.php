<?php
include('conexion.php');

$id = $_POST['id'];

//OBTENEMOS LOS VALORES DEL PRODUCTO

$valores = $conexion->query("SELECT id_paciente, nombre_apellido, dni, sexo, fecha_nacimiento, direccion, distrito, estado_civil, his_clinica, contrato, correo, celular from paciente where id_paciente = '$id'");
$valores2 = $valores->fetch_array();

$datos = array(
				0 => $valores2['id_paciente'], 
				1 => $valores2['nombre_apellido'], 
				2 => $valores2['dni'], 
				3 => $valores2['sexo'], 
				4 => $valores2['fecha_nacimiento'], 
				5 => $valores2['direccion'], 
				6 => $valores2['distrito'], 
				7 => $valores2['estado_civil'], 
				8 => $valores2['his_clinica'], 
				9 => $valores2['contrato'], 
				10 => $valores2['correo'], 
				11 => $valores2['celular'], 
				);
echo json_encode($datos);
?>