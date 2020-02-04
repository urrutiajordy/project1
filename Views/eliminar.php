<?php
		
		$registro = $local -> query("select id_registro, registro.dni as reg_dni, especialidad, fecha_cita, edad, paciente.nombre_apellido as nom_paciente,
							tipo_clinica.nombre as nombre_tip_cli, clinica.nombre as nom_clinica, turno_atencion, usu.nombre_apellido as nom_usuario,
							fecha_inicio, fecha_fin, operador, docente_clinica, diagnostico, papeleta_gen
							from registro
							inner join paciente on registro.dni=paciente.dni
							inner join tipo_clinica on tipo_clinica.id_tipo_clinica=registro.tipo_clinica
							inner join clinica on clinica.id_clinica=registro.n_clinica
							inner join usuario as usu on usu.id_usuario=registro.generado_por"); 
            while($registro2 = $registro->fetch_array()){
				$cantidad=$registro2['cantidad'];
				$precio=$registro2['precio'];
                echo '<table>
				<tr>
				<td>FECHA Y HORA INICIO:</td>
				<td>'.$registro2['fecha_cita'].'</td>
				<td>FECHA Y HORA FIN:</td>
				<td>'.$registro2['fecha_fin'].'</td>
				</tr>
				<tr>
				<td>DOCENTE CLINICA:</td>
				<td>'.$registro2['nom_docente_clinica'].'</td>
				<td>TIPO CLINICA:</td>
				<td><td>'.$registro2['nombre_tip_cli'].'</td></td>
				</tr>
				<tr>
				<td>OPERADOR:</td>
				<td>'.$registro2['nom_operador'].'</td>
				<td>N° CLINICA:</td>
				<td>'.$registro2['nom_clinica'].'</td>
				</tr>
				<tr>
				<td>PACIENTE:</td>
				<td>'.$registro2['nom_usuario'].'</td>
				<td>ESPECIALIDAD</td>
				<td>'.$registro2['especialidad'].'</td>
				</tr>
				<tr>
				<td>EDAD:</td>
				<td>'.$registro2['edad'].'</td>
				<td>TURNO ATENCIÓN:</td>
				<td>'.$registro2['turno_atencion'].'</td>
				</tr>
				<tr>
				<td>DNI:</td>
				<td>'.$registro2['reg_dni'].'</td>
				</tr>
				<tr>
				<td>DIAGNOSTICO:</td>
				<td>'.$registro2['diagnostico'].'</td>
				</tr>';       
            }
?>