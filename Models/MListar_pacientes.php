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
				$sql="SELECT id_paciente, nombre_apellido, dni, sexo, distrito, direccion, celular, his_clinica, contrato, correo, activo 
				FROM paciente 
				WHERE (contrato like '%".$valor."%' or his_clinica like '%".$valor."%' or nombre_apellido like '%".$valor."%' or dni like '%".$valor."%') and activo='1' LIMIT $inicio,$limite";
			}
			else{
				$sql="SELECT id_paciente, nombre_apellido, dni, sexo, distrito, direccion, celular, his_clinica, contrato, correo, activo 
				FROM paciente 
				WHERE (contrato like '%".$valor."%' or his_clinica like '%".$valor."%' or nombre_apellido like '%".$valor."%' or dni like '%".$valor."%') and activo='1'";
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