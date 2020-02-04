<?php error_reporting (0);?>
<?php
$conexion = new mysqli('localhost', 'root', '');
$conexion->select_db('unmsmfac_odontologia');
$conexion->query("SET NAMES 'utf8'");
?>