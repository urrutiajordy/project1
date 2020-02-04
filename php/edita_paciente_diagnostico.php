<?php
include('conexion.php');

$id = $_POST['id'];

//OBTENEMOS LOS VALORES DEL PRODUCTO

$valores = $conexion->query("SELECT id_diagnostico, cod_interno, fecha_registro, n_boleta, historia_clinica, apellido_nombre, dni, edad, pre, pos, operador, anio
	from diagnostico 
	where id_diagnostico = '$id'");
$valores2 = $valores->fetch_array();

$datos = array(
				0 => $valores2['id_diagnostico'], 
				1 => $valores2['fecha_registro'], 
				2 => $valores2['n_boleta'], 
				3 => $valores2['historia_clinica'], 
				4 => $valores2['apellido_nombre'], 
				5 => $valores2['dni'], 
				6 => $valores2['edad'], 
				7 => $valores2['pre'], 
				8 => $valores2['pos'], 
				9 => $valores2['operador'], 
				10 => $valores2['anio'],
				11 => $valores2['cod_interno']
				);
echo json_encode($datos);
?>