<?php
include('conexion.php');
$id = $_POST['id'];
$contrato = $_POST['contrato'];

//ELIMINAMOS EL PRODUCTO
$conexion->query("UPDATE paciente SET contrato='$contrato' WHERE id_paciente = '$id'");
//mysqli_query("");

?>