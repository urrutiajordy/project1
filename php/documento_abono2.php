<?php
date_default_timezone_set('America/Lima');
include('conexion.php');
header("Content-Type: text/html;charset=utf-8");

$doc = $_GET['doc2'];
$date=date('Y-m-d H_i_s');
$id_registro = $_GET['id_registro2'];
$id_usuario = $_GET['id_usuario2'];


$foto = trim($_FILES['foto2']['name']);

$nombre_archivo=$date.'_'.$foto;

		$consulta = "INSERT INTO documento_abono2 (documento,fecha_registro,id_registro,id_usuario,ruta)VALUES('$doc','$date', '$id_registro','$id_usuario','$nombre_archivo')";
		mysqli_query($conexion, $consulta);


move_uploaded_file($_FILES['foto']['tmp_name'], '../archivos/'.$date.'_'.$foto);

//ACTUALIZAMOS LOS REGISTROS Y LOS OBTENEMOS


$registro = $local->query("SELECT *
								FROM documento_abono2
								inner join usuario on usuario.id_usuario=documento_abono2.id_usuario
								where id_registro='$id_registro'");
            
				while($registro2 = $registro->fetch_array()){
					echo '<tr>
						<td>'.$registro2['documento'].'</td>
						<td>'.$registro2['fecha_registro'].'</td>
						<td><a href="../archivos/'.$registro2['ruta'].'" target="_blank" class="btn btn-info">Descargar</a></td>
						<td>'.$registro2['nombre_apellido'].'</td>
						<td><div align="center"><a href="javascript:eliminarArchivoDetalle('.$registro2['id_doc_abono1'].');" class="glyphicon glyphicon-remove-circle"></a></div></td>
						</tr>
						</table>';
					}


?>