<?php 
require_once('../Connections/local.php');
$local->select_db($database_local);
include '../Models/MDiagnostico.php';
$incidencia = new incidencia();

if (isset($_REQUEST['Registrar'])){  
		
	//$valida_dni=$_POST['dni'];	
	$incidencia->setcod_interno($_REQUEST['cod_interno']);
	 $incidencia->setn_boleta($_REQUEST['n_boleta']);
	 $incidencia->sethistoria_clinica($_REQUEST['historia_clinica']);
	 $incidencia->setapellido_nombre($_REQUEST['apellido_nombre']);
	 $incidencia->setdni($_REQUEST['dni']);
	 $incidencia->setedad($_REQUEST['edad']);
	 $incidencia->setpre($_REQUEST['pre']);
	 $incidencia->setpos($_REQUEST['pos']);
	 $incidencia->setoperador($_REQUEST['operador']);
	 $incidencia->setanio($_REQUEST['anio']);

	 // $query = $local->prepare("SELECT * FROM diagnostico WHERE dni='$valida_dni' and activo='1' ");
	 // $query->execute();
	 // $query->store_result();
  //    $rows = $query->num_rows;
	 
	 // if($rows != 0)
	 // {
		// echo ("<html>
  //           	<head>
  //           	<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js'></script>
  //           	<link href='//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css' rel='stylesheet'>
		// 		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
		// 		<link rel='stylesheet' href='../amaran/amaran.min.css'/>
		// 		<link rel='stylesheet' href='../amaran/animate.min.css'/>
		// 		<script src='../amaran/jquery.amaran.js'></script>
		// 		<script src='../amaran/jquery.amaran.min.js'></script>
		// 		</head>
		// 		<body>
		// 		<script>
		// 	    $.amaran({
		// 	        'theme' :'awesome error',
  //       			'content':{
  //           		title:'NO REGISTRO - DNI YA SE ENCUENTRA REGISTRADO',
  //           		message:'',
  //           		info:'',
  //           		icon:'fa fa-ban'
  //       },
  //       'position'  :'top right',
  //       'outEffect' :'slideBottom'
		// 	    });
		// 		</script>
		// 		</body>
		// 		</html>");
  //           echo "<META HTTP-EQUIV=Refresh CONTENT=2;URL='../Views/diagnostico.php'>";	
	 // }
	 // else
	 // {
		if($incidencia->registrar()){ 
		if($incidencia->paciente()){ 
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
        echo "<META HTTP-EQUIV=Refresh CONTENT=2;URL='../Views/diagnostico.php'>";	
        }
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
        echo "<META HTTP-EQUIV=Refresh CONTENT=2;URL='../Views/diagnostico.php'>";	
		}
       
		
}		

else if (isset($_REQUEST['Modificar'])){
      
  	 $incidencia->setn_boleta($_REQUEST['n_boleta']);
  	 $incidencia->setcod_interno($_REQUEST['cod_interno']);
	 $incidencia->sethistoria_clinica($_REQUEST['historia_clinica']);
	 $incidencia->setapellido_nombre($_REQUEST['apellido_nombre']);
	 $incidencia->setdni($_REQUEST['dni']);
	 $incidencia->setedad($_REQUEST['edad']);
	 $incidencia->setpre($_REQUEST['pre']);
	 $incidencia->setpos($_REQUEST['pos']);
	 $incidencia->setoperador($_REQUEST['operador']);
	 $incidencia->setanio($_REQUEST['anio']);
	 
		 if($incidencia->modificar()){ 
		 if($incidencia->mod_paciente()){ 
		 if($incidencia->registrar()){  
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
        echo "<META HTTP-EQUIV=Refresh CONTENT=1.5;URL='../Views/diagnostico.php'>";
                }
		 }
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
        echo "<META HTTP-EQUIV=Refresh CONTENT=2;URL='../Views/diagnostico.php'>";
	}
	 }
	
	 
 ?>