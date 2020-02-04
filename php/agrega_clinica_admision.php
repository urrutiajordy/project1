<?php require_once('conexion.php'); ?>
<?php
$id = $_POST['id'];
	$sql = "SELECT id_clinica, nombre from clinica where id_tipo_clinica='$id' order by nombre asc  ";
$result = $conexion->query($sql);
 echo ' <option selected="selected" disabled="disabled">--Seleccione--</option>';
  echo ' <option value="all">TODOS</option>';
 while ($row = $result->fetch_assoc())
 {
 echo '<option value="'.$row['id_clinica'].'">'.$row['nombre'].'</option>';  
}
?>
