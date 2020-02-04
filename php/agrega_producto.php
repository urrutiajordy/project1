<?php
date_default_timezone_set('America/Lima');
include('conexion.php');
$id = $_POST['id-prod'];
$proceso = $_POST['pro'];
$id_prodreser = $_POST['id'];
$codigo= $_POST['codigo'];
$tratamiento= $_POST['tratamiento'];
$cantidad= $_POST['cantidad'];
$indicaciones= $_POST['indicaciones'];
$precio= $_POST['precio'];
$procedimiento= $_POST['procedimiento'];
$registrado_por=$_POST['gen'];

//VERIFICAMOS EL PROCESO

switch($proceso){
	case 'Registro':
		$consulta = "INSERT INTO registro_tratamiento (codigo,id_registro,tratamiento,procedimiento,cantidad,indicaciones,precio,registrado_por) VALUES ('$codigo','$id_prodreser','$tratamiento','$procedimiento','$cantidad','$indicaciones','$precio','$registrado_por')";
		mysqli_query($conexion, $consulta);
	break;
	
	case 'Edicion':
		  $consulta1 = "UPDATE registro_tratamiento SET 
		  id_producto='$id_producto',
		  id_registro = '$id_prodreser', 
		  cantidad = '$cantidad'
		  WHERE id_producto_reserva = '$id'";
  		mysqli_query($conexion, $consulta1);

	  break;
  }


//ACTUALIZAMOS LOS REGISTROS Y LOS OBTENEMOS

$registro = $conexion->query("SELECT codigo, tratamiento, procedimiento, cantidad,indicaciones,precio
								FROM registro_tratamiento 
								where id_registro='$id_prodreser' order by codigo asc");
$item=0;
//CREAMOS NUESTRA VISTA Y LA DEVOLVEMOS AL AJAX

echo '<table class="table table-hover" style="font-size:13px">
        	<tr class="active">
			 <th>CODIGO</th>
                <th>TRATAMIENTO</th>
				<th>PROCEDIMIENTO</th>
				<th>CANTIDAD</th>
				<th>INDICACIONES</th>
				<th>PRECIO</th>
            </tr>';
            while($registro2 = $registro->fetch_array()){
				
                echo '<tr>
				 <td>'.$registro2['codigo'].'</td> 
                        <td>'.$registro2['tratamiento'].'</td> 
						<td>'.$registro2['procedimiento'].'</td> 
						<td>'.$registro2['cantidad'].'</td> 
						<td>'.$registro2['indicaciones'].'</td> 
						<td>'.$registro2['precio'].'</td> 
			 </tr>';
	}

echo '</table>';
?>