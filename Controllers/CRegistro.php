<?php
include('../php/conexion.php');
include '../Models/MRegistro.php';
require_once('../Connections/local.php');
$local->select_db($database_local);
$sistema = new sistema();

if (isset($_REQUEST['Registrar'])){       

$f_cita=$_POST['fecha_cita'];
$t_cli=$_POST['tipo_clinica'];
$n_cli=$_POST['n_clinica'];
$fecha = date('Y-m-d',strtotime($f_cita));
$turno = $conexion->query("SELECT COUNT(id_registro) as registro FROM registro where fecha_cita LIKE '$fecha%' and tipo_clinica='$t_cli' and n_clinica='$n_cli' ");
		while($turno_ate = $turno->fetch_array()){
            $turno_atencion=$turno_ate['registro'];
			$sig_turno_atencion=$turno_atencion+1;
				}		
				
	$generado_por1=$_POST['generado_por'];
	$sistema->setid_paciente($_REQUEST['id_paciente']); 
	 $sistema->setdni($_REQUEST['dni']);  
	 $sistema->setedad($_REQUEST['edad']);   
	 $sistema->setespecialidad($_REQUEST['especialidad']);
	 $sistema->settipo_clinica($_REQUEST['tipo_clinica']);
	 $sistema->setn_clinica($_REQUEST['n_clinica']);
	 $sistema->setfecha_cita($_REQUEST['fecha_cita']);
	 $sistema->setturno_atencion($sig_turno_atencion);
	 $sistema->setgenerado_por($_REQUEST['generado_por']);
	 $sistema->setoperador($_REQUEST['operador']);
	 $sistema->setdocente_clinica($_REQUEST['docente_clinica']);
	 $sistema->setid_servicio($_REQUEST['servicio']);
	 $sistema->setmonto($_REQUEST['monto']);
	 $sistema->setano_operador($_REQUEST['ano_operador']);

	 
	 
     if($sistema->registrar()){
					
			$ult_reg = $conexion->query("SELECT MAX(id_registro) as registro FROM registro where generado_por='$generado_por1'");
		while($ult_reg1 = $ult_reg->fetch_array()){
            $ult_reg2=$ult_reg1['registro'];
				}
				
			echo ("<script>alert('REGISTRADO CORRECTAMENTE');</script>");
            echo "<META HTTP-EQUIV=Refresh CONTENT=0;URL='../Views/det_cita_medica_adm.php?recordID=$ult_reg2'>";
                }else{
            echo ("<script>alert('ERROR - COMUNICARSE CON EL ADMINISTRADOR');</script>");
            echo "<META HTTP-EQUIV=Refresh CONTENT=0;URL='../Views/registrar_atencion_adm.php'>";}
			
		$nom_paciente=$_POST['nom_paciente'];
		$dni=$_POST['dni'];
		$correo=$_POST['correo'];
		$fecha_cita=$_POST['fecha_cita'];
		$ti_cli=$_POST['tipo_clinica'];
		$num_cli=$_POST['n_clinica'];
		$especialidad=$_POST['especialidad'];
		$operador=$_POST['operador'];
		$doc_med=$_POST['docente_clinica'];
		$lug = $local->query("SELECT * FROM tipo_clinica where id_tipo_clinica='$ti_cli' ");
		while($lug2 = $lug->fetch_array()){
			$nombre_clinica=$lug2['nombre'];
			}
			$n_cli = $local->query("SELECT * FROM clinica where id_clinica='$num_cli' ");
		while($n_cli2 = $n_cli->fetch_array()){
			$num_clinica=$n_cli2['nombre'];
			}
			$ope = $local->query("SELECT * FROM usuario where id_usuario='$operador' ");
		while($ope2 = $ope->fetch_array()){
			$nom_operador=$ope2['nombre_apellido'];
			}
			$docente = $local->query("SELECT * FROM usuario where id_usuario='$doc_med' ");
		while($docente2 = $docente->fetch_array()){
			$nom_docente=$docente2['nombre_apellido'];
			}
	// Varios destinatarios
$para = $correo;

// título
$título = 'CITA MEDICA - FACULTAD DE ODONTOLOGIA UNMSM';

// mensaje
$mensaje = '
<html>
<head>
  <title>FACULTAD DE ODONTOLOGIA UNMSM</title>
</head>
<body>
 <table>
<tr>
<td colspan="2"><strong><center>CITA MEDICA</center></strong></td>
</tr>
<tr>
<td colspan="2"><hr></td>
</tr>
<tr>
<td>PACIENTE:</td>
<td>'.$nom_paciente.'</td>
</tr>
<tr>
<td>DNI:</td>
<td>'.$dni.'</td>
</tr>
<tr>
<td>FECHA Y HORA CITA:</td>
<td>'.$fecha_cita.'</td>
</tr>
<tr>
<td>TIPO CLINICA:</td>
<td>'.$nombre_clinica.'</td>
</tr>
<tr>
<td>N° CLINICA:</td>
<td>'.$num_clinica.'</td>
</tr>
<tr>
<td>ESPECIALIDAD:</td>
<td>'.$especialidad.'</td>
</tr>
<tr>
<td>OPERADOR:</td>
<td>'.$nom_operador.'</td>
</tr>
<tr>
<td>DOCENTE CLINICA:</td>
<td>'.$nom_docente.'</td>
</tr>
<tr>
<td>TURNO ATENCIÓN:</td>
<td>'.$sig_turno_atencion.'</td>
</tr>
<tr>
<td colspan="2"><em>*Llegar 15 minutos antes de su cita.<em></td>
</tr>
<tr>
<td colspan="2"><hr></td>
</tr>
<tr>
<td colspan="2"><strong><CENTER>¡CLÍNICA CENTRAL DE ODONTÓLOGIA A SU SERVICIO!</CENTER></strong></td>
</tr>
</table> 
  
</body>
</html>
';

// Para enviar un correo HTML, debe establecerse la cabecera Content-type
$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

$cabeceras .= 'From: FACULTAD ODONTOLOGIA UNMSM <cumples@example.com>' . "\r\n";

// Enviarlo
mail($para, $título, $mensaje, $cabeceras);
	//FIN//	
   
}

elseif (isset($_REQUEST['Registrar_Citas'])){       

$id_pac= $_POST['id_paciente'];
$f_cita=$_POST['fecha_cita'];
$t_cli=$_POST['tipo_clinica'];
$n_cli=$_POST['n_clinica'];
$ope=$_POST['operador'];
$fecha = date('Y-m-d',strtotime($f_cita));
$turno = $conexion->query("SELECT COUNT(id_registro) as registro FROM registro where fecha_cita LIKE '$fecha%' and tipo_clinica='$t_cli' and n_clinica='$n_cli' ");
		while($turno_ate = $turno->fetch_array()){
            $turno_atencion=$turno_ate['registro'];
			$sig_turno_atencion=$turno_atencion+1;
				}
				
				
	$generado_por1=$_POST['generado_por'];
	$sistema->setid_paciente($_REQUEST['id_paciente']);  
	 $sistema->setdni($_REQUEST['dni']);  
	 $sistema->setedad($_REQUEST['edad']);   
	 $sistema->setespecialidad($_REQUEST['especialidad']);
	 $sistema->settipo_clinica($_REQUEST['tipo_clinica']);
	 $sistema->setn_clinica($_REQUEST['n_clinica']);
	 $sistema->setfecha_cita($_REQUEST['fecha_cita']);
	 $sistema->setturno_atencion($sig_turno_atencion);
	 $sistema->setgenerado_por($_REQUEST['generado_por']);
	 $sistema->setoperador($_REQUEST['operador']);
	 $sistema->setdocente_clinica($_REQUEST['docente_clinica']);
	 $sistema->setid_servicio($_REQUEST['servicio']);
	 $sistema->setmonto($_REQUEST['monto']);
	 $sistema->setano_operador($_REQUEST['ano_operador']);
	 
	// if($id_pac == '' or $id_pac == 0 or $ope == '999999')
	 if($id_pac == '' or $id_pac == 0 or $ope == 0 )
	 {	
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
			        'theme' :'awesome error',
        			'content':{
            		title:'¡ERROR NO SE REGISTRO! - NO SELECCIONO AL PACIENTE O AL OPERADOR',
            		message:'',
            		info:'',
            		icon:'fa fa-ban'
        },
        'position'  :'top right',
        'outEffect' :'slideBottom'
			    });
				</script>
				</body>
				</html>");
            echo "<META HTTP-EQUIV=Refresh CONTENT=2;URL='../Views/registrar_atencion.php'>";
	 }else{
	 if($sistema->registrar()){					
			$ult_reg = $conexion->query("SELECT MAX(id_registro) as registro FROM registro where generado_por='$generado_por1'");
		while($ult_reg1 = $ult_reg->fetch_array()){
            $ult_reg2=$ult_reg1['registro'];
				}
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
            		title:'REGISTRADO CORRECTAMENTE!',
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
            echo "<META HTTP-EQUIV=Refresh CONTENT=1.5;URL='../Views/det_cita_medica.php?recordID=$ult_reg2'>";
                }else{
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
			        'theme' :'awesome error',
        			'content':{
            		title:'ERROR - COMUNICARSE CON EL ADMINISTRADOR',
            		message:'',
            		info:'',
            		icon:'fa fa-ban'
		        },
		        'position'  :'top right',
		        'outEffect' :'slideBottom'
			    });
				</script>
				</body>
				</html>");
            echo "<META HTTP-EQUIV=Refresh CONTENT=2;URL='../Views/registrar_atencion.php'>";
        }	
	 }
     
			
// 		$nom_paciente=$_POST['nom_paciente'];
// 		$dni=$_POST['dni'];
// 		$correo=$_POST['correo'];
// 		$fecha_cita=$_POST['fecha_cita'];
// 		$ti_cli=$_POST['tipo_clinica'];
// 		$num_cli=$_POST['n_clinica'];
// 		$especialidad=$_POST['especialidad'];
// 		$operador=$_POST['operador'];
// 		$doc_med=$_POST['docente_clinica'];
// 		$lug = $local->query("SELECT * FROM tipo_clinica where id_tipo_clinica='$ti_cli' ");
// 		while($lug2 = $lug->fetch_array()){
// 			$nombre_clinica=$lug2['nombre'];
// 			}
// 			$n_cli = $local->query("SELECT * FROM clinica where id_clinica='$num_cli' ");
// 		while($n_cli2 = $n_cli->fetch_array()){
// 			$num_clinica=$n_cli2['nombre'];
// 			}
// 			$ope = $local->query("SELECT * FROM usuario where id_usuario='$operador' ");
// 		while($ope2 = $ope->fetch_array()){
// 			$nom_operador=$ope2['nombre_apellido'];
// 			}
// 			$docente = $local->query("SELECT * FROM usuario where id_usuario='$doc_med' ");
// 		while($docente2 = $docente->fetch_array()){
// 			$nom_docente=$docente2['nombre_apellido'];
// 			}
// 	// Varios destinatarios
// $para = $correo;

// // título
// $título = 'CITA MEDICA - FACULTAD DE ODONTOLOGIA UNMSM';

// // mensaje
// $mensaje = '
// <html>
// <head>
//   <title>FACULTAD DE ODONTOLOGIA UNMSM</title>
// </head>
// <body>
//  <table>
// <tr>
// <td colspan="2"><strong><center>CITA MEDICA</center></strong></td>
// </tr>
// <tr>
// <td colspan="2"><hr></td>
// </tr>
// <tr>
// <td>PACIENTE:</td>
// <td>'.$nom_paciente.'</td>
// </tr>
// <tr>
// <td>DNI:</td>
// <td>'.$dni.'</td>
// </tr>
// <tr>
// <td>FECHA Y HORA CITA:</td>
// <td>'.$fecha_cita.'</td>
// </tr>
// <tr>
// <td>TIPO CLINICA:</td>
// <td>'.$nombre_clinica.'</td>
// </tr>
// <tr>
// <td>N° CLINICA:</td>
// <td>'.$num_clinica.'</td>
// </tr>
// <tr>
// <td>ESPECIALIDAD:</td>
// <td>'.$especialidad.'</td>
// </tr>
// <tr>
// <td>OPERADOR:</td>
// <td>'.$nom_operador.'</td>
// </tr>
// <tr>
// <td>DOCENTE CLINICA:</td>
// <td>'.$nom_docente.'</td>
// </tr>
// <tr>
// <td>TURNO ATENCIÓN:</td>
// <td>'.$sig_turno_atencion.'</td>
// </tr>
// <tr>
// <td colspan="2"><em>*Llegar 15 minutos antes de su cita.<em></td>
// </tr>
// <tr>
// <td colspan="2"><hr></td>
// </tr>
// <tr>
// <td colspan="2"><strong><CENTER>¡CLÍNICA CENTRAL DE ODONTÓLOGIA A SU SERVICIO!</CENTER></strong></td>
// </tr>
// </table> 
  
// </body>
// </html>
// ';

// // Para enviar un correo HTML, debe establecerse la cabecera Content-type
// $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
// $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// $cabeceras .= 'From: FACULTAD ODONTOLOGIA UNMSM <cumples@example.com>' . "\r\n";

// // Enviarlo
// mail($para, $título, $mensaje, $cabeceras);
// 	//FIN//	
   
}

elseif (isset($_REQUEST['Modificar'])){       

$id=$_POST['id_registro'];
$f_cita=$_POST['fecha_cita'];
$t_cli=$_POST['tipo_clinica'];
$n_cli=$_POST['n_clinica'];
$id_pac=$_POST['id_paciente'];
$id_ope=$_POST['operador'];
$fecha = date('Y-m-d',strtotime($f_cita));
$turno = $conexion->query("SELECT COUNT(id_registro) as registro FROM registro where fecha_cita LIKE '$fecha%' and tipo_clinica='$t_cli' and n_clinica='$n_cli' ");
		while($turno_ate = $turno->fetch_array()){
            $turno_atencion=$turno_ate['registro'];
			$sig_turno_atencion=$turno_atencion+1;
				}			
	$generado_por1=$_POST['generado_por'];
	 $sistema->setid_registro($_REQUEST['id_registro']);
	 $sistema->setid_paciente($_REQUEST['id_paciente']);  
	 $sistema->setdni($_REQUEST['dni']);  
	 $sistema->setedad($_REQUEST['edad']);   
	 $sistema->setespecialidad($_REQUEST['especialidad']);
	 $sistema->settipo_clinica($_REQUEST['tipo_clinica']);
	 $sistema->setn_clinica($_REQUEST['n_clinica']);
	 $sistema->setfecha_cita($_REQUEST['fecha_cita']);
	 $sistema->setturno_atencion($sig_turno_atencion);
	 $sistema->setgenerado_por($_REQUEST['generado_por']);
	 $sistema->setoperador($_REQUEST['operador']);
	 $sistema->setdocente_clinica($_REQUEST['docente_clinica']);
	 $sistema->setid_servicio($_REQUEST['servicio']);
	 $sistema->setmonto($_REQUEST['monto']);
	 $sistema->setano_operador($_REQUEST['ano_operador']);
	 
if($id_pac == '' or $id_pac == 0){
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
			        'theme' :'awesome error',
        			'content':{
            		title:'¡ERROR NO SE ACTUALIZO! - NO SELECCIONO AL PACIENTE O AL OPERADOR',
            		message:'',
            		info:'',
            		icon:'fa fa-ban'
        },
        'position'  :'top right',
        'outEffect' :'slideBottom'
			    });
				</script>
				</body>
				</html>");
    echo "<META HTTP-EQUIV=Refresh CONTENT=2;URL='../Views/det_cita_medica.php?recordID=$id'>";
}else{
	if($sistema->modificar()){
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
            		title:'MODIFICADO CORRECTAMENTE!',
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
            echo "<META HTTP-EQUIV=Refresh CONTENT=1.5;URL='../Views/det_cita_medica.php?recordID=$id'>";
                }else{
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
			        'theme' :'awesome error',
        			'content':{
            		title:'ERROR - COMUNICARSE CON EL ADMINISTRADOR',
            		message:'',
            		info:'',
            		icon:'fa fa-ban'
        },
        'position'  :'top right',
        'outEffect' :'slideBottom'
			    });
				</script>
				</body>
				</html>");
            echo "<META HTTP-EQUIV=Refresh CONTENT=1.5;URL='../Views/det_cita_medica.php?recordID=$id'>";
			}
}
     
			
}

elseif (isset($_REQUEST['Anular'])){       

	 $sistema->setid_registro($_REQUEST['id_registro']);
	 
     if($sistema->anular()){
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
            		title:'ANULADO CORRECTAMENTE!',
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
            echo "<META HTTP-EQUIV=Refresh CONTENT=1.5;URL='../Views/central_citas.php>";
                }else{
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
			        'theme' :'awesome error',
        			'content':{
            		title:'ERROR - COMUNICARSE CON EL ADMINISTRADOR',
            		message:'',
            		info:'',
            		icon:'fa fa-ban'
        },
        'position'  :'top right',
        'outEffect' :'slideBottom'
			    });
				</script>
				</body>
				</html>");
            echo "<META HTTP-EQUIV=Refresh CONTENT=1.5;URL='../Views/det_cita_medica.php?recordID=$id'>";}
			
}

elseif (isset($_REQUEST['Anular_admision'])){       

	 $sistema->setid_registro($_REQUEST['id_registro']);
	 
     if($sistema->anular()){
					
			echo ("<script>alert('ANULADO CORRECTAMENTE');</script>");
            echo "<META HTTP-EQUIV=Refresh CONTENT=0;URL='../Views/admision.php>";
                }else{
            echo ("<script>alert('ERROR - COMUNICARSE CON EL ADMINISTRADOR');</script>");
            echo "<META HTTP-EQUIV=Refresh CONTENT=0;URL='../Views/det_cita_medica_adm.php?recordID=$id'>";}
			
}

elseif (isset($_REQUEST['Papeleta'])){       

$id= $_POST['id_registro'];
 	 $sistema->setid_registro($_REQUEST['id_registro']);  
	 $sistema->setfecha_inicio($_REQUEST['fecha_inicio']);  
	 $sistema->setfecha_fin($_REQUEST['fecha_fin']);   
	 $sistema->setoperador($_REQUEST['operador']);
	 $sistema->setdocente_clinica($_REQUEST['docente_clinica']);
	 $sistema->setdiagnostico($_REQUEST['diagnostico']);
	 $sistema->setpapeleta_gen($_REQUEST['papeleta_gen']);

            if($sistema->papeleta()){ 
			echo ("<script>alert('REGISTRADO CORRECTAMENTE');</script>");
            echo "<META HTTP-EQUIV=Refresh CONTENT=0;URL='../Views/det_cita_medica_adm.php?recordID=$id'>";
                }else{
            echo ("<script>alert('ERROR - COMUNICARSE CON EL ADMINISTRADOR');</script>");
            echo "<META HTTP-EQUIV=Refresh CONTENT=0;URL='../Views/det_cita_medica_adm.php?recordID=$id'>";}
			
}

elseif (isset($_REQUEST['Modificar_Papeleta'])){       

$id= $_POST['id_registro'];
 	 $sistema->setid_registro($_REQUEST['id_registro']);  
	 $sistema->setfecha_inicio($_REQUEST['fecha_inicio']);  
	 $sistema->setfecha_fin($_REQUEST['fecha_fin']);   
	 $sistema->setoperador($_REQUEST['operador']);
	 $sistema->setdocente_clinica($_REQUEST['docente_clinica']);
	 $sistema->setdiagnostico($_REQUEST['diagnostico']);
	 $sistema->setpapeleta_gen($_REQUEST['papeleta_gen']);

            if($sistema->modificar_papeleta()){ 
			echo ("<script>alert('MODIFICACION REGISTRADO CORRECTAMENTE');</script>");
            echo "<META HTTP-EQUIV=Refresh CONTENT=0;URL='../Views/det_cita_medica_adm.php?recordID=$id'>";
                }else{
            echo ("<script>alert('ERROR - COMUNICARSE CON EL ADMINISTRADOR');</script>");
            echo "<META HTTP-EQUIV=Refresh CONTENT=0;URL='../Views/det_cita_medica_adm.php?recordID=$id'>";}
			
}

elseif (isset($_REQUEST['Registrar_Adm'])){       

$f_cita=$_POST['fecha_cita'];
$t_cli=$_POST['tipo_clinica'];
$n_cli=$_POST['n_clinica'];
$fecha = date('Y-m-d',strtotime($f_cita));
$turno = $conexion->query("SELECT COUNT(id_registro) as registro FROM registro where fecha_cita LIKE '$fecha%' and tipo_clinica='$t_cli' and n_clinica='$n_cli' ");
		while($turno_ate = $turno->fetch_array()){
            $turno_atencion=$turno_ate['registro'];
			$sig_turno_atencion=$turno_atencion+1;
				}
				
				
$generado_por1=$_POST['generado_por'];
	 $sistema->setdni($_REQUEST['dni']);  
	 $sistema->setedad($_REQUEST['edad']);   
	 $sistema->setespecialidad($_REQUEST['especialidad']);
	 $sistema->settipo_clinica($_REQUEST['tipo_clinica']);
	 $sistema->setn_clinica($_REQUEST['n_clinica']);
	 $sistema->setfecha_cita($_REQUEST['fecha_cita']);
	 $sistema->setturno_atencion($sig_turno_atencion);
	 $sistema->setgenerado_por($_REQUEST['generado_por']);
	 $sistema->setoperador($_REQUEST['operador']);
	 $sistema->setdocente_clinica($_REQUEST['docente_clinica']);
	 
            if($sistema->registrar()){
					
			$ult_reg = $conexion->query("SELECT MAX(id_registro) as registro FROM registro where generado_por='$generado_por1'");
		while($ult_reg1 = $ult_reg->fetch_array()){
            $ult_reg2=$ult_reg1['registro'];
				}
				
			echo ("<script>alert('REGISTRADO CORRECTAMENTE');</script>");
            echo "<META HTTP-EQUIV=Refresh CONTENT=0;URL='../Views/det_cita_medica_adm.php?recordID=$ult_reg2'>";
                }else{
            echo ("<script>alert('ERROR - COMUNICARSE CON EL ADMINISTRADOR');</script>");
            echo "<META HTTP-EQUIV=Refresh CONTENT=0;URL='../Views/det_cita_medica_adm.php'>";}
			
}

elseif (isset($_REQUEST['Abono1'])){       
	
	 $id=$_POST['id_registro'];
	 $monto_t=$_POST['monto_total'];
	 $abo1=$_POST['abono1'];
	 $sistema->setid_registro($_REQUEST['id_registro']);  
	 $sistema->setabono1($abo1);   
	 $sistema->setid_usu_abono1($_REQUEST['id_usu_abono1']);  

	 
if($abo1 <= $monto_t)
	
	{
    if($sistema->Abono1()){
							
	echo ("<script>alert('ABONO1 REGISTRADO CORRECTAMENTE');</script>");
          echo ("<script>window.history.go(-1);</script>"); 
    }else{
    echo ("<script>alert('ERROR - COMUNICARSE CON EL ADMINISTRADOR');</script>");
          echo ("<script>window.history.go(-1);</script>"); 
	}
	}else
	{
	 echo ("<script>alert('MONTO INGRESADO ES MAYOR AL TOTAL');</script>");
          echo ("<script>window.history.go(-1);</script>"); 
	}		
}
elseif (isset($_REQUEST['Abono2'])){       
	
	 $id=$_POST['id_registro'];
	 $resta=$_POST['resta'];
	 $abo2=$_POST['abono2'];
	 $sistema->setid_registro($_REQUEST['id_registro']);  
	 $sistema->setabono2($abo2);   
	 $sistema->setid_usu_abono2($_REQUEST['id_usu_abono2']);  

if($abo2 == $resta)
	
	{
    if($sistema->Abono2()){
							
	echo ("<script>alert('ABONO2 REGISTRADO CORRECTAMENTE');</script>");
          echo ("<script>window.history.go(-1);</script>"); 
    }else{
    echo ("<script>alert('ERROR - COMUNICARSE CON EL ADMINISTRADOR');</script>");
          echo ("<script>window.history.go(-1);</script>"); 
	}
	}else
	{
	 echo ("<script>alert('ABONO 2 DEBE SER LO FALTANTE');</script>");
          echo ("<script>window.history.go(-1);</script>"); 
	}		
}
elseif (isset($_REQUEST['Especialidad'])){       
	

	 $sistema->setid_tipo_clinica($_REQUEST['modal_tipo_clinica']);  
	 $sistema->setid_clinica($_REQUEST['modal_n_clinica']);   
	 $sistema->setnombre_especialidad($_REQUEST['modal_especialidad']);  


    if($sistema->especialidad()){
							
	echo ("<script>alert('REGISTRADO CORRECTAMENTE');</script>");
            echo "<META HTTP-EQUIV=Refresh CONTENT=0;URL='../Views/registrar_atencion.php'>";
    }else{
    echo ("<script>alert('ERROR - COMUNICARSE CON EL ADMINISTRADOR');</script>");
            echo "<META HTTP-EQUIV=Refresh CONTENT=0;URL='../Views/registrar_atencion.php'>";
	}
		
}
?>