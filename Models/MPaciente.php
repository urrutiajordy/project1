<?php 	
require_once 'conexion1.php';

class incidencia{
	private $id_paciente;
    private $nombre_apellido;
	private $dni;
    private $sexo;
	private $fecha_nacimiento;
	private $direccion;
	private $distrito;
	private $estado_civil;
	private $correo;
	private $celular;
	private $id_usuario;	
	private $usuario;
	private $clave;
	private $id_perfil;
	private $his_clinica;
	private $contrato;
	
		public function gethis_clinica(){ return $this->his_clinica;} 
public function sethis_clinica($his_clinica){ $this->his_clinica=$his_clinica;}

	public function getcontrato(){ return $this->contrato;} 
public function setcontrato($contrato){ $this->contrato=$contrato;}

	public function getid_paciente(){ return $this->id_paciente;} 
public function setid_paciente($id_paciente){ $this->id_paciente=$id_paciente;}
  
  public function getnombre_apellido(){ return $this->nombre_apellido;} 
public function setnombre_apellido($nombre_apellido){ $this->nombre_apellido=$nombre_apellido;}

public function getdni(){ return $this->dni;} 
public function setdni($dni){ $this->dni=$dni;}

public function getsexo(){ return $this->sexo;} 
public function setsexo($sexo){ $this->sexo=$sexo;}

public function getfecha_nacimiento(){ return $this->fecha_nacimiento;} 
public function setfecha_nacimiento($fecha_nacimiento){ $this->fecha_nacimiento=$fecha_nacimiento;}

public function getdireccion(){ return $this->direccion;} 
public function setdireccion($direccion){ $this->direccion=$direccion;}

public function getdistrito(){ return $this->distrito;} 
public function setdistrito($distrito){ $this->distrito=$distrito;}

public function getestado_civil(){ return $this->estado_civil;} 
public function setestado_civil($estado_civil){ $this->estado_civil=$estado_civil;}

public function getcorreo(){ return $this->correo;} 
public function setcorreo($correo){ $this->correo=$correo;}

public function getcelular(){ return $this->celular;} 
public function setcelular($celular){ $this->celular=$celular;}

public function getusuario(){ return $this->usuario;} 
public function setusuario($usuario){ $this->usuario=$usuario;}

public function getclave(){ return $this->clave;} 
public function setclave($clave){ $this->clave=$clave;}

public function getid_perfil(){ return $this->id_perfil;} 
public function setid_perfil($id_perfil){ $this->id_perfil=$id_perfil;}

public function getid_usuario(){ return $this->id_usuario;} 
public function setid_usuario($id_usuario){ $this->id_usuario=$id_usuario;}

public function registrar(){
	
 $sql = "INSERT INTO paciente (nombre_apellido, dni, sexo, fecha_nacimiento, direccion, distrito, estado_civil, his_clinica, contrato,  correo, celular, activo) 
				VALUES  ('$this->nombre_apellido','$this->dni','$this->sexo','$this->fecha_nacimiento','$this->direccion','$this->distrito','$this->estado_civil','$this->his_clinica','$this->contrato','$this->correo','$this->celular', '1')";
$resultado = mysqli_query(conexion::conectar(),$sql);
		return $resultado;

		}

public function modificar(){
        $sql = "UPDATE paciente SET nombre_apellido='$this->nombre_apellido'
		,dni='$this->dni'
		,sexo='$this->sexo'
		,fecha_nacimiento='$this->fecha_nacimiento'
		,direccion='$this->direccion'
		,distrito='$this->distrito'
		,estado_civil='$this->estado_civil'
		,correo='$this->correo'
		,his_clinica='$this->his_clinica'
		,contrato='$this->contrato'
		,celular='$this->celular'
		WHERE id_paciente='$this->id_paciente'";
	$resultado = mysqli_query(conexion::conectar(),$sql);
			return $resultado;
}

public function registrar_usuario(){
	
 $sql = "INSERT INTO usuario (usuario,clave,nombre_apellido, correo, celular, id_perfil, activo) 
				VALUES  ('$this->usuario','$this->clave','$this->nombre_apellido','$this->correo','$this->celular','$this->id_perfil', '1')";
$resultado = mysqli_query(conexion::conectar(),$sql);
		return $resultado;

		}
public function modificar_usuario(){
        $sql = "UPDATE usuario SET clave='$this->clave', nombre_apellido='$this->nombre_apellido'
		,correo='$this->correo'
		,celular='$this->celular'
		,id_perfil='$this->id_perfil'
		WHERE id_usuario='$this->id_usuario'";
	$resultado = mysqli_query(conexion::conectar(),$sql);
			return $resultado;
}
}
?>