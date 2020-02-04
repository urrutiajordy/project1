<?php require_once('conexion.php'); ?>
<?php
$id = $_POST['id'];
	$sql = "SELECT id_especialidad, nombre_especialidad from especialidad where id_clinica='$id' ";
$result = $conexion->query($sql);
 while ($row = $result->fetch_assoc())
 {
 echo '<option value="'.$row['nombre_especialidad'].'">'.$row['nombre_especialidad'].'</option>';  
}
?>
