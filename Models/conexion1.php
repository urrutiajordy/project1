<?php error_reporting (0);?>
<?php
class conexion {
    public static function conectar() {
        $conexion = new mysqli("localhost", "root", "");
        $conexion->query("SET NAMES 'utf8'");
        $conexion->select_db("unmsmfac_odontologia");
        return $conexion;
    }
}
?>