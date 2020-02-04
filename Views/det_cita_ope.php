<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "../index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
date_default_timezone_set('America/Lima');
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "6";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php require_once('../Connections/local.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

//  $theValue = function_exists("mysql_real_escape_string") ? $mysqli->real_escape_string($theValue) : $mysqli->escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_Recordset2 = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Recordset2 = $_SESSION['MM_Username'];
}
$local->select_db($database_local);
$query_Recordset2 = sprintf("SELECT * FROM usuario WHERE Usuario = %s", GetSQLValueString($colname_Recordset2, "text"));
$Recordset2 = $local->query($query_Recordset2) or die($mysqli->error);
$row_Recordset2 = $Recordset2->fetch_assoc();
$totalRows_Recordset2 = $Recordset2->num_rows;


$maxRows_DetailRS1 = 10;
$pageNum_DetailRS1 = 0;
if (isset($_GET['pageNum_DetailRS1'])) {
  $pageNum_DetailRS1 = $_GET['pageNum_DetailRS1'];
}
$startRow_DetailRS1 = $pageNum_DetailRS1 * $maxRows_DetailRS1;

$colname_DetailRS1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
$local->select_db($database_local);
$query_DetailRS1 = sprintf("select id_registro, registro.dni as reg_dni, especialidad, fecha_registro, fecha_cita, edad, paciente.nombre_apellido as nom_paciente,
							tipo_clinica.nombre as nombre_tip_cli, clinica.nombre as nom_clinica, turno_atencion, usu.nombre_apellido as nom_usuario,
							fecha_inicio, fecha_fin, operador, docente_clinica, ano_operador, diagnostico, papeleta_gen, paciente.his_clinica	 as h_clinica, paciente.contrato as contrato
							from registro
							inner join paciente on registro.id_paciente=paciente.id_paciente
							inner join tipo_clinica on tipo_clinica.id_tipo_clinica=registro.tipo_clinica
							inner join clinica on clinica.id_clinica=registro.n_clinica
							inner join usuario as usu on usu.id_usuario=registro.generado_por
							where  id_registro = %s", GetSQLValueString($colname_DetailRS1, "-1"));
$query_limit_DetailRS1 = sprintf("%s LIMIT %d, %d", $query_DetailRS1, $startRow_DetailRS1, $maxRows_DetailRS1);
$DetailRS1 = $local->query($query_limit_DetailRS1) or die($mysqli->error);
$row_DetailRS1 = $DetailRS1->fetch_assoc();
?>
<html><!-- InstanceBegin template="/Templates/plantilla administrador.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<link rel="shortcut icon" type="image/x-icon" href="../imagenes/favicon.ico"/>
<!-- InstanceBeginEditable name="head" -->
<script src="../js/jquery.js"></script>
<script src="../js/myjava.js"></script>
 <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css"/>
	<script src="../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<link href="../bootstrap/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<script src="../bootstrap/js/bootstrap-datetimepicker.js" type="text/javascript"></script>
<link href="../bootstrap/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
<script src="../bootstrap/js/bootstrap-select.min.js" type="text/javascript"></script>
<!-- InstanceEndEditable -->
<title>UNMSM</title>
<link href="../css/estilo.css" rel="stylesheet" type="text/css"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body >
<!-- InstanceBeginEditable name="cuerpo2" -->
<div align="right">
<a href="<?php echo $logoutAction ?>"><strong>Cerrar Sessión(<?php echo $row_Recordset2['nombre_apellido'];?>)</a><!-- InstanceEndEditable -->
<div align="left"><a href="operador.php"><img src="../imagenes/logo1.png" width="200px" Id="Insert_logo" /></a></div>
</div>
<!--Menú-->
<?php include("../menu/menu_operador.php"); ?>
  <!--FIN MENU-->
<p>
<?php
 $id_docente=$row_DetailRS1['docente_clinica'];

 
	 	$res7=$local->query("SELECT * FROM usuario where id_usuario='$id_docente'");
            ?>
      		<?php 
			while($fila7=$res7->fetch_array()){
				$optionC = $fila7["nombre_apellido"];
            }
 
?>
<div class="row">
  <div class="col-xs-12"><center>DETALLE CITA</center></div>
  <div class="col-xs-12">FECHA REGISTRO</div>
  <div class="col-xs-12 "><div class='input-group date'>
	<input class='form-control input-field'	name='fecha_registro' data-readonly	type='text'  value="<?php echo $row_DetailRS1['fecha_registro'];?>" /> <span class='input-group-addon'>
	<span class='glyphicon glyphicon-calendar'></span>
	</span>
	</div></div>
	<div class="col-xs-12">PACIENTE</div>
	<div class="col-xs-12"><input type="text" name="nom_paciente" id="nom_paciente" class="form-control" value="<?php echo $row_DetailRS1['nom_paciente']; ?>" data-readonly /></div>
	<div class="col-xs-12">EDAD</div>
	<div class="col-xs-12"><input class="form-control" type="text" name="edad" id="edad" value="<?php echo $row_DetailRS1['edad']; ?>" data-readonly /></div>
	<div class="col-xs-12">DNI</div>
	<div class="col-xs-12"><input type="text" name="dni" id="dni" value="<?php echo $row_DetailRS1['reg_dni'];?>"  class="form-control" data-readonly /></div>
	<div class="col-xs-12">TIPO CLINICA</div>
	<div class="col-xs-12"><input type="text" name="dni" id="dni" value="<?php echo $row_DetailRS1['nombre_tip_cli'];?>"  class="form-control" data-readonly /></div>
	<div class="col-xs-12">N° CLINICA</div>
	<div class="col-xs-12"><input type="text" name="dni" id="dni" value="<?php echo $row_DetailRS1['nom_clinica'];?>"  class="form-control" data-readonly /></div>
	<div class="col-xs-12">ESPECIALIDAD</div>
	<div class="col-xs-12"><input type="text" name="dni" id="dni" value="<?php echo $row_DetailRS1['especialidad'];?>"  class="form-control" data-readonly /></div>
	<div class="col-xs-12">FECHA Y HORA DE CITA</div>
	<div class="col-xs-12"><div class='input-group date' data-date-format='yyyy-mm-dd hh:ii'>
	<input class='form-control input-field'	name='fecha_cita'	type='text'  value="<?php echo $row_DetailRS1['fecha_cita']; ?>" /> <span class='input-group-addon'>
	<span class='glyphicon glyphicon-calendar'></span>
	</span>
	</div></div>
	<div class="col-xs-12">TURNO DE ATENCION</div>
	<div class="col-xs-12"><input class="form-control" type="text" value="<?php echo $row_DetailRS1['turno_atencion'];?>"  data-readonly /></div>
	<div class="col-xs-12">HISTORIA CLINICA</div>
	<div class="col-xs-12"><input class="form-control" type="text" name="his_cli" id="his_cli" data-readonly value="<?php echo $row_DetailRS1['h_clinica'];?>" /></div>
	<div class="col-xs-12">CONTRATO</div>
	<div class="col-xs-12"><input class="form-control" type="text" name="contrato" id="contrato" data-readonly value="<?php echo $row_DetailRS1['contrato'];?>" /></div>
	<div class="col-xs-12">DOCENTE CLINICA</div>
	<div class="col-xs-12"><input class="form-control" type="text" name="contrato" id="contrato" data-readonly value="<?php echo $optionC;?>" /></div>

</div>
<br>
<br> 
<?php include("flooter.php"); ?>  
</body>
<!-- InstanceEnd -->
</html>

