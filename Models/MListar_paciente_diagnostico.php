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
				$sql="SELECT id_diagnostico, n_boleta, historia_clinica, apellido_nombre, dni, edad, fecha_registro, pre, pos, operador, anio
				FROM diagnostico
				WHERE activo=1 and (apellido_nombre like '%".$valor."%' OR historia_clinica like '%".$valor."%' OR dni like '%".$valor."%' OR fecha_registro like '%".$valor."%' OR operador like '%".$valor."%') order by historia_clinica desc LIMIT $inicio,$limite";
			}
			else{
				$sql="SELECT id_diagnostico, n_boleta, historia_clinica, apellido_nombre, dni, edad, fecha_registro, pre, pos, operador, anio
				FROM diagnostico
				WHERE activo=1 and (apellido_nombre like '%".$valor."%' OR historia_clinica like '%".$valor."%' OR dni like '%".$valor."%' OR fecha_registro like '%".$valor."%' OR operador like '%".$valor."%') order by historia_clinica desc";
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