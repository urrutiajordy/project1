<?php require_once('conexion.php'); ?>
<?php
$id = $_POST['id'];
	$sql = "SELECT * from servicios where id_servicio='$id' ";
$result = $conexion->query($sql);
 while ($row = $result->fetch_assoc())
 {
 echo '<option value="'.$row['precio'].'">'.$row['precio'].'</option>';  
}
?>
