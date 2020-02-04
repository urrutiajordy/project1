<?php
date_default_timezone_set('America/Lima');
require_once 'conexion1.php';

class incidencia{
	private $id_diagnostico;
	private $fecha_registro;
	private $n_boleta;
	private $historia_clinica;
	private $apellido_nombre;
	private $dni;
	private $edad;
	private $pre;
	private $pos;
	private $operador;
	private $anio;
	private $cod_interno;


public function getid_diagnostico(){ return $this->id_diagnostico;} 
public function setid_diagnostico($id_diagnostico){ $this->id_diagnostico=$id_diagnostico;}
public function getfecha_registro(){ return $this->fecha_registro;} 
public function setfecha_registro($fecha_registro){ $this->fecha_registro=$fecha_registro;}
public function getn_boleta(){ return $this->n_boleta;} 
public function setn_boleta($n_boleta){ $this->n_boleta=$n_boleta;}
public function gethistoria_clinica(){ return $this->historia_clinica;} 
public function sethistoria_clinica($historia_clinica){ $this->historia_clinica=$historia_clinica;}
public function getapellido_nombre(){ return $this->apellido_nombre;} 
public function setapellido_nombre($apellido_nombre){ $this->apellido_nombre=$apellido_nombre;}
public function getdni(){ return $this->dni;} 
public function setdni($dni){ $this->dni=$dni;}
public function getedad(){ return $this->edad;} 
public function setedad($edad){ $this->edad=$edad;}
public function getpre(){ return $this->pre;} 
public function setpre($pre){ $this->pre=$pre;}
public function getpos(){ return $this->pos;} 
public function setpos($pos){ $this->pos=$pos;}
public function getoperador(){ return $this->operador;} 
public function setoperador($operador){ $this->operador=$operador;}
public function getanio(){ return $this->anio;} 
public function setanio($anio){ $this->anio=$anio;}
public function getcod_interno(){ return $this->cod_interno;} 
public function setcod_interno($cod_interno){ $this->cod_interno=$cod_interno;}


public function registrar(){
	$fecha_actual=date( 'Y-m-d H:i:s');
 $sql = "INSERT INTO diagnostico (cod_interno, fecha_registro, n_boleta, historia_clinica, apellido_nombre, dni, edad, pre, pos, operador, anio, activo) 
				VALUES  ('$this->cod_interno','$fecha_actual','$this->n_boleta','$this->historia_clinica','$this->apellido_nombre','$this->dni','$this->edad','$this->pre', '$this->pos', '$this->operador','$this->anio', '1')";
$resultado = mysqli_query(conexion::conectar(),$sql);
		return $resultado;

}

public function modificar(){
	$sql = "UPDATE diagnostico 
		SET activo='2'
		WHERE cod_interno='$this->cod_interno'";
		$resultado = mysqli_query(conexion::conectar(),$sql);
		return $resultado;
}

public function paciente(){
 $sql = "INSERT INTO paciente (nombre_apellido, dni, his_clinica, activo) 
				VALUES  ('$this->apellido_nombre','$this->dni','$this->historia_clinica','1')";
$resultado = mysqli_query(conexion::conectar(),$sql);
return $resultado;
}

public function mod_paciente(){
	$sql = "UPDATE paciente 
		SET nombre_apellido='$this->apellido_nombre', dni='$this->dni'
		WHERE his_clinica='$this->historia_clinica'";

$resultado = mysqli_query(conexion::conectar(),$sql);
return $resultado;
}
}
?>