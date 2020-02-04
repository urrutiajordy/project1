<?php 
$conn= mysqli_connect("localhost","root","","unmsmfac_odontologia") or die ("Error");
if (!$conn->set_charset("utf8")) {//asignamos la codificación comprobando que no falle
       die("Error cargando el conjunto de caracteres utf8");
}
?>