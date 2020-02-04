<?php
include('conexion.php');
$id = $_POST['id'];

//ELIMINAMOS EL PRODUCTO
$conexion->query("UPDATE paciente SET activo='2' WHERE id_paciente = '$id'");
//mysqli_query("");

?>