<?php 
	class queryincidencia
	{
		private $conexion;
		
		public function __construct()
		{
			require_once('conexion.php');
			$this->conexion= new conexion();
			$this->conexion->conectar();
		}

		function MListar_Registro($valor,$inicio=FALSE,$limite=FALSE)
		{
			
			if ($inicio!==FALSE && $limite!==FALSE) {
				$sql="select id_registro, fecha_cita, paciente.nombre_apellido as nombre_paciente, paciente.his_clinica as his_clinica, paciente.contrato as contrato,registro.dni as reg_dni, tipo_clinica.nombre as nombre_tip_cli, clinica.nombre as nom_clinica, especialidad, usu.nombre_apellido as nombre_operador, medico.nombre_apellido as nombre_docente_clinica
				from registro
				inner join paciente on registro.id_paciente=paciente.id_paciente
				inner join tipo_clinica on tipo_clinica.id_tipo_clinica=registro.tipo_clinica
				inner join clinica on clinica.id_clinica=registro.n_clinica
				inner join usuario as usu on registro.operador=usu.id_usuario
				inner join usuario as medico on registro.docente_clinica=medico.id_usuario
				where  registro.operador='$valor' order by fecha_cita desc LIMIT $inicio,$limite";
			}
			else{
				$sql="select id_registro, fecha_cita, paciente.nombre_apellido as nombre_paciente, paciente.his_clinica as his_clinica, paciente.contrato as contrato, registro.dni as reg_dni, tipo_clinica.nombre as nombre_tip_cli, clinica.nombre as nom_clinica, especialidad, usu.nombre_apellido as nombre_operador, medico.nombre_apellido as nombre_docente_clinica
				from registro
				inner join paciente on registro.id_paciente=paciente.id_paciente
				inner join tipo_clinica on tipo_clinica.id_tipo_clinica=registro.tipo_clinica
				inner join clinica on clinica.id_clinica=registro.n_clinica
				inner join usuario as usu on registro.operador=usu.id_usuario
				inner join usuario as medico on registro.docente_clinica=medico.id_usuario
				where  registro.operador='$valor' order by fecha_cita desc";
			}
			$this->conexion->conexion->set_charset('utf8');
			$resultados=$this->conexion->conexion->query($sql);
			$arreglo = array();
			while ($re=$resultados->fetch_array(MYSQLI_NUM)) {
				$arreglo[]=$re;
			}
			return $arreglo;
			$this->conexion->cerrar();
			

		}
		
	}

	
	
?>
