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
				$sql="SELECT id_usuario, nombre_apellido, usuario, correo,celular, perfil.nombre as nombre_perfil 
				FROM usuario 
				inner join perfil on usuario.id_perfil=perfil.id_perfil
				WHERE nombre_apellido like '%".$valor."%' and (usuario.id_perfil=1 or usuario.id_perfil=2 or usuario.id_perfil=3 or usuario.id_perfil=4 or usuario.id_perfil=5 ) order by nombre_apellido asc LIMIT $inicio,$limite";
			}
			else{
				$sql="SELECT id_usuario, nombre_apellido, usuario, correo,celular, perfil.nombre as nombre_perfil 
				FROM usuario 
				inner join perfil on usuario.id_perfil=perfil.id_perfil
				WHERE nombre_apellido like '%".$valor."%' and (usuario.id_perfil=1 or usuario.id_perfil=2 or usuario.id_perfil=3 or usuario.id_perfil=4 or usuario.id_perfil=5) order by nombre_apellido asc ";
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