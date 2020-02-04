<?php 
include '../Models/MArchivo.php';
require_once('../Connections/local.php');
$local->select_db($database_local);

$incidencia = new incidencia();

if (isset($_REQUEST['Registrar'])){  
		
	$valida_dni=$_POST['dni'];
	
		
	 $incidencia->setnombre_apellido($_REQUEST['nombre_apellido']);
     $incidencia->setdni($_REQUEST['dni']);
     $incidencia->setsexo($_REQUEST['sexo']);
	 $incidencia->setfecha_nacimiento($_REQUEST['fecha_nacimiento']);   
     $incidencia->setdireccion($_REQUEST['direccion']);
	 $incidencia->setdistrito($_REQUEST['distrito']);
	 $incidencia->setestado_civil($_REQUEST['estado_civil']);
	 $incidencia->setcorreo($_REQUEST['correo']);
	 $incidencia->sethis_clinica($_REQUEST['h_clinica']);
	 $incidencia->setcontrato($_REQUEST['contrato']);
	 $incidencia->setfecha_historia($_REQUEST['date_h_clinica']);
	 $incidencia->setfecha_contrato($_REQUEST['date_contrato']); 
	 $incidencia->setcelular($_REQUEST['celular']);	 
	 $incidencia->setar_ocupacion($_REQUEST['ocupacion']);
	 $incidencia->setar_operador($_REQUEST['operador']);
	 $incidencia->setar_dni_operador($_REQUEST['dni_operador']);
	 $incidencia->setar_grado_paciente($_REQUEST['grado_paciente']);
	 $incidencia->setar_grupo_sanguineo($_REQUEST['grupo_sanguineo']);
	 $incidencia->setar_anio_alum($_REQUEST['anio_alumno']);
	 $incidencia->setar_alum_transferido($_REQUEST['alum_tranferido']);
	 $incidencia->setar_anio_estudio($_REQUEST['anio_estudio']);
	 $incidencia->setar_dni_transferido	($_REQUEST['dni_transferido']);


	  
     
	 $query = $local->prepare("SELECT * FROM paciente WHERE dni='$valida_dni' and activo='1' ");
	 $query->execute();
	 $query->store_result();
     $rows = $query->num_rows;
	 
	 if($rows != 0)
	 {
		echo ("<script>alert('DNI YA SE ENCUENTRA REGISTRADO');</script>");
        echo ("<script>window.history.go(-1);</script>");	
	 }
	 else
	 {
		if($incidencia->registrar()){ 
		echo ("<script>alert('REGISTRADO CORRECTAMENTE');</script>");
        echo ("<script>window.history.go(-1);</script>");
        }else{
        echo ("<script>alert('ERROR - COMUNICARSE CON EL ADMINISTRADOR');</script>");
        echo ("<script>window.history.go(-1);</script>");
		}
			
	 }
            
		
}		

else if (isset($_REQUEST['Modificar'])){
      
      
	 $incidencia->setcod_archivo($_REQUEST['cod_archivo']);
	 $incidencia->setnombre_apellido($_REQUEST['nombre_apellido']);
     $incidencia->setdni($_REQUEST['dni']);
     $incidencia->setsexo($_REQUEST['sexo']);
	 $incidencia->setfecha_nacimiento($_REQUEST['fecha_nacimiento']);   
     $incidencia->setdireccion($_REQUEST['direccion']);
	 $incidencia->setdistrito($_REQUEST['distrito']);
	 $incidencia->setestado_civil($_REQUEST['estado_civil']);
	 $incidencia->setcorreo($_REQUEST['correo']);
	 $incidencia->sethis_clinica($_REQUEST['h_clinica']);
	 $incidencia->setcontrato($_REQUEST['contrato']);
	 $incidencia->setfecha_historia($_REQUEST['date_h_clinica']);
	 $incidencia->setfecha_contrato($_REQUEST['date_contrato']); 
	 $incidencia->setcelular($_REQUEST['celular']);	 
	 $incidencia->setar_ocupacion($_REQUEST['ocupacion']);
	 $incidencia->setar_operador($_REQUEST['operador']);
	 $incidencia->setar_dni_operador($_REQUEST['dni_operador']);
	 $incidencia->setar_grado_paciente($_REQUEST['grado_paciente']);
	 $incidencia->setar_grupo_sanguineo($_REQUEST['grupo_sanguineo']);
	 $incidencia->setar_anio_alum($_REQUEST['anio_alumno']);
	 $incidencia->setar_alum_transferido($_REQUEST['alum_tranferido']);
	 $incidencia->setar_anio_estudio($_REQUEST['anio_estudio']);
	 $incidencia->setar_dni_transferido	($_REQUEST['dni_transferido']);
     $incidencia->setcontrato_pasado($_REQUEST['contrato_pass']);
     $incidencia->setcontrato_actualizado($_REQUEST['contrato_new']);
     $incidencia->setfecha_actualizacion($_REQUEST['date_update']);
	 
		 if($incidencia->modificar()){  
            echo ("<script>alert('ACTUALIZACION REGISTRADA CORRECTAMENTE');</script>");
            echo ("<script>window.history.go(-1);</script>");
                }else{
            echo ("<script>alert('ERROR - COMUNICARSE CON EL ADMINISTRADOR');</script>");
            echo ("<script>window.history.go(-1);</script>");
	}
	 }
	
	 
 ?>