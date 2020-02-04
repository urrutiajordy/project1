<?php 
include '../Models/MAdmin.php';
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
	 
	 $incidencia->sethis_clinica($_REQUEST['h_clinica']);
	 $incidencia->setcontrato($_REQUEST['contrato']);
	  
	 $incidencia->setcorreo($_REQUEST['correo']);
	 
	  $incidencia->setcelular($_REQUEST['celular']);
     
	 $query = $local->prepare("SELECT * FROM paciente WHERE dni='$valida_dni'");
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
      	  
	  	$incidencia->setid_paciente($_REQUEST['id_paciente']);
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
		$incidencia->setcelular($_REQUEST['celular']);
     
	 
		 if($incidencia->modificar()){  
            echo ("<script>alert('MODIFICADO CORRECTAMENTE');</script>");
            echo ("<script>window.history.go(-1);</script>");
                }else{
            echo ("<script>alert('ERROR - COMUNICARSE CON EL ADMINISTRADOR');</script>");
            echo ("<script>window.history.go(-1);</script>");
	}
	 }
	
else if (isset($_REQUEST['Registrar_Usuario'])){
      
	  	  $valida_usuario=$_POST['usuario'];

	  	$incidencia->setusuario($_REQUEST['usuario']);
		$incidencia->setclave($_REQUEST['clave']);
		$incidencia->setnombre_apellido($_REQUEST['nombre_apellido']);
		$incidencia->setcorreo($_REQUEST['correo']);
		$incidencia->setcelular($_REQUEST['celular']);
		$incidencia->setid_perfil($_REQUEST['id_perfil']);
     
	 
		$query = $local->prepare("SELECT * FROM usuario WHERE usuario='$valida_usuario'");
	 $query->execute();
	 $query->store_result();
     $rows = $query->num_rows;
	 
	 if($rows != 0)
	 {
		echo ("<script>alert('USUARIO FUE REGISTRADO ANTERIORMENTE');</script>");
        echo ("<script>window.history.go(-1);</script>");	
	 }
	 else
	 { if($incidencia->registrar_usuario()){  
            echo ("<html>
            	<head>
            	<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js'></script>
            	<link href='//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css' rel='stylesheet'>
				<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
				<link rel='stylesheet' href='../amaran/amaran.min.css'/>
				<link rel='stylesheet' href='../amaran/animate.min.css'/>
				<script src='../amaran/jquery.amaran.js'></script>
				<script src='../amaran/jquery.amaran.min.js'></script>
				
				</head>
				<body>
				<script>
			    $.amaran({
			        'theme' :'awesome ok',
        			'content':{
            		title:'REGISTRADO CORRECTAMENTE',
            		message:'',
            		info:'',
            		icon:'fa fa-check-square-o'
        },
        'position'  :'top right',
        'outEffect' :'slideBottom'
			    });
				</script>
				</body>
				</html>");
            echo "<META HTTP-EQUIV=Refresh CONTENT=1.5;URL='../Views/usuario_admin.php'>";
                }else{
            echo ("<script>alert('ERROR - COMUNICARSE CON EL ADMINISTRADOR');</script>");
            echo ("<script>window.history.go(-1);</script>");
	}
	 }
	 }	

else if (isset($_REQUEST['Modificar_Usuario'])){
      
	  	$incidencia->setid_usuario($_REQUEST['id_usuario']);
	  	$incidencia->setusuario($_REQUEST['usuario']);
		$incidencia->setclave($_REQUEST['clave']);
		$incidencia->setnombre_apellido($_REQUEST['nombre_apellido']);
		$incidencia->setcorreo($_REQUEST['correo']);
		$incidencia->setcelular($_REQUEST['celular']);
		$incidencia->setid_perfil($_REQUEST['id_perfil']);
     
	  if($incidencia->modificar_usuario()){  
            echo ("<script>alert('USUARIO MODIFICADO CORRECTAMENTE');</script>");
            echo ("<script>window.history.go(-1);</script>");
                }else{
            echo ("<script>alert('ERROR - COMUNICARSE CON EL ADMINISTRADOR');</script>");
            echo ("<script>window.history.go(-1);</script>");
	}
	 
	 }
	 
 ?>