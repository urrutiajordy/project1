<?php

 	$servidor="localhost";
 	$bd_nombre = "unmsmfac_odontologia";
	$usuario = "unmsmfacuodon";
	$contraseña = "=oNqy$[@Aem6";
	

	$json = array();

	if (isset($_GET['facultad'])&&  isset($_GET['escuela']) && isset($_GET['unidad_post']) && isset($_GET['seg_especi'])&& isset($_GET['diplom'])  && isset($_GET['sem_acad'])&& isset($_GET['años_estudio']) && isset($_GET['asigantur']) && isset($_GET['nombre_ape_doc']) && isset($_GET['pregunta1']) && isset($_GET['pregunt2'])  && isset($_GET['pregunta3'])  && isset($_GET['pregunta4'])  && isset($_GET['pregunta5'])  && isset($_GET['pregunta6'])  && isset($_GET['pregunta7']) && isset($_GET['pregunta8']) && isset($_GET['pregunta9']) && isset($_GET['pregunta10'])  ){

		$facultad = $_GET['facultad'];
		$escuela= $_GET['escuela'];
		$unidad_post = $_GET['unidad_post'];
		$seg_especi = $_GET['seg_especi'];
		$diplom = $_GET['diplom'];
		$sem_acad= $_GET['sem_acad'];
		$años_estudio= $_GET['años_estudio'];
		$asigantur= $_GET['asigantur'];
		$nombre_ape_doc= $_GET['nombre_ape_doc'];

		$pregunta1= $_GET['pregunta1'];
		$pregunt2= $_GET['pregunt2'];
		$pregunta3= $_GET['pregunta3'];
		$pregunta4= $_GET['pregunta4'];
		$pregunta5= $_GET['pregunta5'];
		$pregunta6= $_GET['pregunta6'];
		$pregunta7= $_GET['pregunta7'];
		$pregunta8= $_GET['pregunta8'];
		$pregunta9= $_GET['pregunta9'];
		$pregunta10= $_GET['pregunta10'];
		

		$conexion = mysqli_connect($servidor,$usuario,$contraseña,$bd_nombre);
		mysqli_set_charset($conexion,'utf8');

		///mysqli_set_charset($conexion, 'utf8mb4_unicode_ci');

		$insert = "insert into encuestado (facultad,escuela,unidad_post,seg_especi,diplom
,sem_acad,años_estudio,asigantur,nombre_ape_doc,pregunta1,pregunt2,pregunta3,pregunta4,pregunta5,pregunta6,pregunta7,pregunta8,pregunta9,pregunta10) values ('{$facultad}','{$escuela}','{$unidad_post}','{$seg_especi}','{$diplom}','{$sem_acad}','{$años_estudio}','{$asigantur}','{$nombre_ape_doc}','{$pregunta1}','{$pregunt2}','{$pregunta3}','{$pregunta4}','{$pregunta5}','{$pregunta6}','{$pregunta7}','{$pregunta8}','{$pregunta9}','{$pregunta10}')";

		$result  = mysqli_query($conexion,$insert);

		if ($result) {
			$mostrar = "SELECT * FROM encuestado where facultad= '{$facultad}' ";
			$resul = mysqli_query($conexion,$mostrar);
		
			if ($registro=mysqli_fetch_array($resul)) {
				$json ['lista'][] = $registro;
			}

			mysqli_close($conexion);
			echo json_encode($json);
		}else{
			/*$res["codigo"] = 'null';
			$res["fecha"] = 'null';
			$res["fecha_nac"] = 'null';
			$res["genero"] = 'null';
			$res["pais"] = 'null';
			$res["universidad"] = 'null';
			$res["tip_diente"] = 'null';
			$res["col_diente"] = 'null';
			$res["valores"] = 'null';*/
	

			$json['lista']=$resul;
			echo json_encode($json);
		}


	}

	?>
