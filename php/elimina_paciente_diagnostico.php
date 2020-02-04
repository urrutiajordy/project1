<?php
include('conexion.php');
$id = $_POST['id'];

//ELIMINAMOS EL PRODUCTO
$conexion->query("UPDATE diagnostico SET activo='2' WHERE id_diagnostico = '$id'");
//mysqli_query("");

?>