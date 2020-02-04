<?php
include('conexion.php');

$id = $_POST['id'];

//OBTENEMOS LOS VALORES DEL PRODUCTO

$valores = $conexion->query("SELECT id_paciente, nombre_apellido, dni, sexo, fecha_nacimiento, direccion, distrito, estado_civil, his_clinica, contrato, correo, celular, fecha_historia, fecha_contrato, ar_ocupacion, ar_operador, ar_dni_operador, ar_grado_paciente, ar_grupo_sanguineo, ar_anio_alum, ar_alum_transferido, ar_anio_estudio, ar_dni_transferido, contrato_pasado, contrato_actualizado, fecha_actualizacion, cod_archivo
	from archivo 
	where id_paciente = '$id'");
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
				12 => $valores2['fecha_historia'],
				13 => $valores2['fecha_contrato'],
				14 => $valores2['ar_ocupacion'], 
				15 => $valores2['ar_operador'],   
				16 => $valores2['ar_dni_operador'],
				17 => $valores2['ar_grado_paciente'], 
				18 => $valores2['ar_grupo_sanguineo'],  
				19 => $valores2['ar_anio_alum'], 
				20 => $valores2['ar_alum_transferido'],
				21 => $valores2['ar_anio_estudio'],
				22 => $valores2['ar_dni_transferido'],
				23 => $valores2['contrato_pasado'],
				24 => $valores2['contrato_actualizado'],
				25 => $valores2['fecha_actualizacion'],
				26 => $valores2['cod_archivo']
				);
echo json_encode($datos);
?>