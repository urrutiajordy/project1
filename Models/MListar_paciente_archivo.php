<?php 
	class querylistar_paciente
	{
		private $conexion;
		
		public function __construct()
		{
			require_once('conexion.php');
			$this->conexion= new conexion();
			$this->conexion->conectar();
		}

		function lista_paciente($valor,$inicio=FALSE,$limite=FALSE)
		{

			if ($inicio!==FALSE && $limite!==FALSE) {
				$sql="SELECT id_paciente, nombre_apellido, his_clinica, contrato, contrato_pasado, contrato_actualizado, fecha_historia, fecha_contrato, fecha_actualizacion, ar_operador, ar_dni_operador, ar_alum_transferido, ar_dni_transferido
				FROM archivo
				WHERE nombre_apellido like '%".$valor."%' OR his_clinica like '%".$valor."%' OR contrato like '%".$valor."%' OR contrato_pasado like '%".$valor."%' OR contrato_actualizado like '%".$valor."%' order by nombre_apellido  asc LIMIT $inicio,$limite";
			}
			else{
				$sql="SELECT id_paciente, nombre_apellido, his_clinica, contrato, contrato_pasado, contrato_actualizado, fecha_historia, fecha_contrato, fecha_actualizacion, ar_operador, ar_dni_operador, ar_alum_transferido, ar_dni_transferido
				FROM archivo
				WHERE nombre_apellido like '%".$valor."%' OR his_clinica like '%".$valor."%' OR contrato like '%".$valor."%' OR contrato_pasado like '%".$valor."%' OR contrato_actualizado like '%".$valor."%' order by nombre_apellido  asc ";
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