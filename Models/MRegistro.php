<?php
date_default_timezone_set('America/Lima');
require_once 'conexion1.php';
class sistema{
	private $id_paciente;
    private $id_registro;
    private $fecha_registro;
    private $dni;
	private $edad;
	private $especialidad;
	private $tipo_clinica;
	private $n_clinica;
	private $fecha_cita;
	private $turno_atencion;
	private $generado_por;

	private $fecha_inicio;
	private $fecha_fin;
	private $operador;
	private $docente_clinica;
	private $diagnostico;
	private $papeleta_gen;
	private $id_servicio;
	private $monto;
	private $abono1;
	private $abono2;
	private $id_usu_abono1;
	private $id_usu_abono2;	
	private $ano_operador;	
	
	private $id_tipo_clinica;
	private $id_clinica;	
	private $nombre_especialidad;	
	
			public function getid_paciente(){ return $this->id_paciente;} 
  public function setid_paciente($id_paciente){	$this->id_paciente=$id_paciente;}
  
  
		public function getid_tipo_clinica(){ return $this->id_tipo_clinica;} 
  public function setid_tipo_clinica($id_tipo_clinica){	$this->id_tipo_clinica=$id_tipo_clinica;}
  
  	public function getid_clinica(){ return $this->id_clinica;} 
  public function setid_clinica($id_clinica){	$this->id_clinica=$id_clinica;}
  
  	public function getnombre_especialidad(){ return $this->nombre_especialidad;} 
  public function setnombre_especialidad($nombre_especialidad){	$this->nombre_especialidad=$nombre_especialidad;}
	
	public function getano_operador(){ return $this->ano_operador;} 
  public function setano_operador($ano_operador){	$this->ano_operador=$ano_operador;}
  
  public function getid_registro(){ return $this->id_registro;} 
  public function setid_registro($id_registro){	$this->id_registro=$id_registro;}
  public function getfecha_registro(){ return $this->fecha_registro;} 
  public function setfecha_registro($fecha_registro){	$this->fecha_registro=$fecha_registro;}
  public function getdni(){ return $this->dni;} 
  public function setdni($dni){	$this->dni=$dni;}
  public function getedad(){ return $this->edad;} 
  public function setedad($edad){	$this->edad=$edad;}
  public function getespecialidad(){ return $this->especialidad;} 
  public function setespecialidad($especialidad){	$this->especialidad=$especialidad;}
  public function gettipo_clinica(){ return $this->tipo_clinica;} 
  public function settipo_clinica($tipo_clinica){	$this->tipo_clinica=$tipo_clinica;}
  public function getn_clinica(){ return $this->n_clinica;} 
  public function setn_clinica($n_clinica){	$this->n_clinica=$n_clinica;}
  public function getfecha_cita(){ return $this->fecha_cita;} 
  public function setfecha_cita($fecha_cita){	$this->fecha_cita=$fecha_cita;}
  public function getturno_atencion(){ return $this->turno_atencion;} 
  public function setturno_atencion($turno_atencion){	$this->turno_atencion=$turno_atencion;}
  public function getgenerado_por(){ return $this->generado_por;} 
  public function setgenerado_por($generado_por){	$this->generado_por=$generado_por;}
  public function getfecha_inicio(){ return $this->fecha_inicio;} 
  public function setfecha_inicio($fecha_inicio){	$this->fecha_inicio=$fecha_inicio;}
  public function getfecha_fin(){ return $this->fecha_fin;} 
  public function setfecha_fin($fecha_fin){	$this->fecha_fin=$fecha_fin;}
  public function getoperador(){ return $this->operador;} 
  public function setoperador($operador){	$this->operador=$operador;}
  public function getdocente_clinica(){ return $this->docente_clinica;} 
  public function setdocente_clinica($docente_clinica){	$this->docente_clinica=$docente_clinica;}
  public function getdiagnostico(){ return $this->diagnostico;} 
  public function setdiagnostico($diagnostico){	$this->diagnostico=$diagnostico;}
  public function getpapeleta_gen(){ return $this->papeleta_gen;} 
  public function setpapeleta_gen($papeleta_gen){	$this->papeleta_gen=$papeleta_gen;}
  public function getid_servicio(){ return $this->id_servicio;} 
  public function setid_servicio($id_servicio){	$this->id_servicio=$id_servicio;}
  public function getmonto(){ return $this->monto;} 
  public function setmonto($monto){	$this->monto=$monto;}
  public function getabono1(){ return $this->abono1;} 
  public function setabono1($abono1){	$this->abono1=$abono1;}
  public function getabono2(){ return $this->abono2;} 
  public function setabono2($abono2){	$this->abono2=$abono2;}
  public function getid_usu_abono1(){ return $this->id_usu_abono1;} 
  public function setid_usu_abono1($id_usu_abono1){	$this->id_usu_abono1=$id_usu_abono1;}
  public function getid_usu_abono2(){ return $this->id_usu_abono2;} 
  public function setid_usu_abono2($id_usu_abono2){	$this->id_usu_abono2=$id_usu_abono2;}
  
public function registrar(){
	$fecha_aper=date( 'Y-m-d H:i:s');
        $sql = "INSERT INTO registro (fecha_registro, id_paciente, dni, edad, especialidad, tipo_clinica, n_clinica, fecha_cita, turno_atencion, generado_por, operador, docente_clinica, id_servicio, monto,abono1,ano_operador,activo) VALUES  ('$fecha_aper', '$this->id_paciente', '$this->dni', '$this->edad', '$this->especialidad',
		'$this->tipo_clinica',
		'$this->n_clinica',
		'$this->fecha_cita',
		'$this->turno_atencion',
		'$this->generado_por',
		'$this->operador',
		'$this->docente_clinica',
		'$this->id_servicio',
		'$this->monto',
		'0',
		'$this->ano_operador',
		'1')";
		$resultado = mysqli_query(conexion::conectar(),$sql);
		return $resultado;
}
public function modificar(){
	$fecha_aper=date( 'Y-m-d H:i:s');
        $sql = "UPDATE registro 
		SET fecha_registro='$fecha_aper', 
		id_paciente='$this->id_paciente', 
		dni='$this->dni', 
		edad='$this->edad',
		especialidad='$this->especialidad',
		tipo_clinica='$this->tipo_clinica',
		n_clinica='$this->n_clinica',
		
		fecha_cita='$this->fecha_cita',
		turno_atencion='$this->turno_atencion',
		generado_por='$this->generado_por',
		operador='$this->operador',
		docente_clinica='$this->docente_clinica',
		id_servicio='$this->id_servicio',
		monto='$this->monto',
		ano_operador='$this->ano_operador'
		WHERE id_registro='$this->id_registro'";
		$resultado = mysqli_query(conexion::conectar(),$sql);
		return $resultado;
}
public function anular(){
        $sql = "UPDATE registro 
		SET activo='2'		
		WHERE id_registro='$this->id_registro'";
		$resultado = mysqli_query(conexion::conectar(),$sql);
		return $resultado;
}
public function papeleta(){
        $sql = "UPDATE registro 
		SET fecha_inicio='$this->fecha_inicio', 
		fecha_fin='$this->fecha_fin', 
		operador='$this->operador',
		docente_clinica='$this->docente_clinica',
		diagnostico='$this->diagnostico',
		papeleta_gen='$this->papeleta_gen'
		
		WHERE id_registro='$this->id_registro'";
		$resultado = mysqli_query(conexion::conectar(),$sql);
		return $resultado;
}
public function modificar_papeleta(){
        $sql = "UPDATE registro 
		SET fecha_inicio='$this->fecha_inicio', 
		fecha_fin='$this->fecha_fin', 
		operador='$this->operador',
		docente_clinica='$this->docente_clinica',
		diagnostico='$this->diagnostico',
		papeleta_gen='$this->papeleta_gen'
		
		WHERE id_registro='$this->id_registro'";
		$resultado = mysqli_query(conexion::conectar(),$sql);
		return $resultado;
}
public function Abono1(){
        $sql = "UPDATE registro 
		SET abono1='$this->abono1', id_usu_abono1='$this->id_usu_abono1'
		WHERE id_registro='$this->id_registro'";
		$resultado = mysqli_query(conexion::conectar(),$sql);
		return $resultado;
}
public function Abono2(){
        $sql = "UPDATE registro 
		SET abono2='$this->abono2', id_usu_abono2='$this->id_usu_abono2'
		WHERE id_registro='$this->id_registro'";
		$resultado = mysqli_query(conexion::conectar(),$sql);
		return $resultado;
}

public function especialidad(){
	
        $sql = "INSERT INTO especialidad (id_tipo_clinica, id_clinica, nombre_especialidad,activo) VALUES  ('$this->id_tipo_clinica', '$this->id_clinica', '$this->nombre_especialidad',
		'1')";
		$resultado = mysqli_query(conexion::conectar(),$sql);
		return $resultado;
}

}		
?>