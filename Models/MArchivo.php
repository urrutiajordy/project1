<?php
date_default_timezone_set('America/Lima');
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
	private $fecha_historia;
	private $fecha_contrato;
	private $ar_ocupacion;
	private $ar_operador;
	private $ar_dni_operador;
	private $ar_grado_paciente;
	private $ar_grupo_sanguineo;
	private $ar_anio_alum;
	private $ar_alum_transferido;
	private $ar_anio_estudio;
	private $ar_dni_transferido;
	private $contrato_pasado;
	private $contrato_actualizado;
	private $fecha_actualizacion;
	private $cod_archivo;

public function getcod_archivo(){ return $this->cod_archivo;} 
public function setcod_archivo($cod_archivo){ $this->cod_archivo=$cod_archivo;}
public function getfecha_actualizacion(){ return $this->fecha_actualizacion;} 
public function setfecha_actualizacion($fecha_actualizacion){ $this->fecha_actualizacion=$fecha_actualizacion;}
public function getcontrato_actualizado(){ return $this->contrato_actualizado;} 
public function setcontrato_actualizado($contrato_actualizado){ $this->contrato_actualizado=$contrato_actualizado;}
public function getcontrato_pasado(){ return $this->contrato_pasado;} 
public function setcontrato_pasado($contrato_pasado){ $this->contrato_pasado=$contrato_pasado;}
public function getfecha_historia(){ return $this->fecha_historia;} 
public function setfecha_historia($fecha_historia){ $this->fecha_historia=$fecha_historia;}
public function getfecha_contrato(){ return $this->fecha_contrato;} 
public function setfecha_contrato($fecha_contrato){ $this->fecha_contrato=$fecha_contrato;}
public function getar_ocupacion(){ return $this->ar_ocupacion;} 
public function setar_ocupacion($ar_ocupacion){ $this->ar_ocupacion=$ar_ocupacion;}
public function getar_operador(){ return $this->ar_operador;} 
public function setar_operador($ar_operador){ $this->ar_operador=$ar_operador;}
public function getar_dni_operador(){ return $this->ar_dni_operador;} 
public function setar_dni_operador($ar_dni_operador){ $this->ar_dni_operador=$ar_dni_operador;}
public function getar_grado_paciente(){ return $this->ar_grado_paciente;} 
public function setar_grado_paciente($ar_grado_paciente){ $this->ar_grado_paciente=$ar_grado_paciente;}
public function getar_grupo_sanguineo(){ return $this->ar_grupo_sanguineo;} 
public function setar_grupo_sanguineo($ar_grupo_sanguineo){ $this->ar_grupo_sanguineo=$ar_grupo_sanguineo;}
public function getar_anio_alum(){ return $this->ar_anio_alum;} 
public function setar_anio_alum($ar_anio_alum){ $this->ar_anio_alum=$ar_anio_alum;}
public function getar_alum_transferido(){ return $this->ar_alum_transferido;} 
public function setar_alum_transferido($ar_alum_transferido){ $this->ar_alum_transferido=$ar_alum_transferido;}
public function getar_anio_estudio(){ return $this->ar_anio_estudio;} 
public function setar_anio_estudio($ar_anio_estudio){ $this->ar_anio_estudio=$ar_anio_estudio;}
public function getar_dni_transferido(){ return $this->ar_dni_transferido;} 
public function setar_dni_transferido($ar_dni_transferido){ $this->ar_dni_transferido=$ar_dni_transferido;}
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
	
 $sql = "INSERT INTO archivo (nombre_apellido, dni, sexo, fecha_nacimiento, direccion, distrito, estado_civil, correo, his_clinica, contrato,  fecha_historia, fecha_contrato, celular, activo, ar_ocupacion, ar_operador, ar_dni_operador, ar_grado_paciente, ar_grupo_sanguineo, ar_anio_alum, ar_alum_transferido, ar_anio_estudio, ar_dni_transferido ) 
				VALUES  ('$this->nombre_apellido','$this->dni','$this->sexo','$this->fecha_nacimiento','$this->direccion','$this->distrito','$this->estado_civil', '$this->correo', '$this->his_clinica','$this->contrato', '$this->fecha_historia','$this->fecha_contrato', '$this->celular', '1',	'$this->ar_ocupacion','$this->ar_operador',	'$this->ar_dni_operador','$this->ar_grado_paciente', '$this->ar_grupo_sanguineo','$this->ar_anio_alum',	'$this->ar_alum_transferido','$this->ar_anio_estudio','$this->ar_dni_transferido')";
$resultado = mysqli_query(conexion::conectar(),$sql);
		return $resultado;

		}

public function modificar(){
	$date=date('Y-m-d H:i:s');
        $sql = "INSERT INTO archivo (cod_archivo, nombre_apellido, dni, sexo, fecha_nacimiento, direccion, distrito, estado_civil, correo, his_clinica, contrato, contrato_pasado, contrato_actualizado, fecha_historia, fecha_contrato, celular, activo, ar_ocupacion, ar_operador, ar_dni_operador, ar_grado_paciente, ar_grupo_sanguineo, ar_anio_alum, ar_alum_transferido, ar_anio_estudio, ar_dni_transferido, fecha_registro, fecha_actualizacion ) 
				VALUES  ('$this->cod_archivo', '$this->nombre_apellido','$this->dni','$this->sexo','$this->fecha_nacimiento','$this->direccion','$this->distrito','$this->estado_civil', '$this->correo', '$this->his_clinica','$this->contrato', '$this->contrato_pasado', '$this->contrato_actualizado', '$this->fecha_historia','$this->fecha_contrato', '$this->celular', '1',	'$this->ar_ocupacion','$this->ar_operador',	'$this->ar_dni_operador','$this->ar_grado_paciente', '$this->ar_grupo_sanguineo','$this->ar_anio_alum',	'$this->ar_alum_transferido','$this->ar_anio_estudio','$this->ar_dni_transferido', '$date', '$this->fecha_actualizacion' )";
	$resultado = mysqli_query(conexion::conectar(),$sql);
			return $resultado;
}

}
?>