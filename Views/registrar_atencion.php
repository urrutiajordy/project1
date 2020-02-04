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
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "2";
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
<?php require_once('../Connections/local.php');?>
<?php
if(!function_exists("GetSQLValueString"))
{
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }
 // $theValue = function_exists("mysql_real_escape_string") ? $mysqli->real_escape_string($theValue) : $mysqli->escape_string($theValue);
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
date_default_timezone_set('America/Lima');
?>
<html><!-- InstanceBegin template="/Templates/plantilla administrador.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<link rel="shortcut icon" type="image/x-icon" href="../imagenes/favicon.ico"/>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
<script src="../js/jquery.js"></script>
<script src="../js/myjava.js"></script>
<!-- InstanceBeginEditable name="head" -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel='stylesheet' href='../amaran/amaran.min.css'/>
        <link rel='stylesheet' href='../amaran/animate.min.css'/>
        <script src='../amaran/jquery.amaran.js'></script>
        <script src='../amaran/jquery.amaran.min.js'></script>
        <link href='//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css' rel='stylesheet'>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
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
<script>
function soloLetras(e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
    especiales = [8, 37, 39, 46];

    tecla_especial = false
    for(var i in especiales) {
        if(key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }

    if(letras.indexOf(tecla) == -1 && !tecla_especial)
        return false;
}
</script>
<script languaje="JavaScript"> 
function soloNumeros(e){
  var key = window.Event ? e.which : e.keyCode
  return (key >= 48 && key <= 57)
}
function mayus(e) {
    e.value = e.value.toUpperCase();
}
</script>
<script>
var mipopup;
function popup()
{
mipopup = window.open("popup.php","form","width=700,height=300,menubar=si");
mipopup.focus()

}
</script> 
<script>
    $(".readonly").on('keydown paste', function(e){
        e.preventDefault();
    });
</script>
</head>
<body>
<!-- InstanceBeginEditable name="cuerpo2" -->
<div align="right">
<a href="<?php echo $logoutAction ?>"><strong>Cerrar Sessión(<?php echo $row_Recordset2['nombre_apellido'];?>)</a><!-- InstanceEndEditable -->
<div align="left"><a href="central_citas.php"><img src="../imagenes/logo1.png" width="200px" Id="Insert_logo" /></a></div>
</div>
<!--Menú-->
<?php include("../menu/menu_cc.php"); ?>
  <!--FIN MENU-->
<div class="motorcategoria">
<form class="form-horizontal" name="form" method="POST" action="../Controllers/CRegistro.php" enctype="multipart/form-data" >
<table border="0" align="center" >
<tr>
<td colspan="6"><h3><div align="center"><span class="label label-info">SOLICITUD CITA</span></div></h3></td>
</tr>
<tr>
<td ><h4><div align="center"><span class="label label-info">FECHA REGISTRO</span></div></h4></td>
<td><div class='input-group date'>
	<input class='form-control input-field'	name='fecha_registro' readonly	type='text'  value="<?php echo date ( 'Y-m-d H:i');?>" /> <span class='input-group-addon'>
	<span class='glyphicon glyphicon-calendar'></span>
	</span>
	</div></td>
</tr>
<tr>
<td align="center"><button type="button" class="btn btn-danger" title="BUSCAR PACIENTE" onclick="popup()"><strong>BUSCAR PACIENTE</strong></button></td>
<td colspan="2"><input type="text" name="nom_paciente" id="nom_paciente" class="form-control" required data-readonly /></td>
</tr>
<tr>
<td ><h4><div align="center"><span class="label label-info">EDAD</span></div></h4></td>
<td><input class="form-control" type="text" name="edad" id="edad" required data-readonly /></td>
<td ><h4><div align="center"><span class="label label-info">DNI</span></div></h4></td>
<td><input type="text" name="dni" id="dni" class="form-control" required data-readonly />
<input type="hidden" name="correo" id="correo" class="form-control" required data-readonly /></td>
</tr>
<tr>
<td><h4><div align="center"><span class="label label-info">TIPO CLINICA</span></div></h4></td>
<td><span id="spryselect1"><select id="tipo_clinica" name="tipo_clinica" class="form-control">
  <?php  
		$lug = $local->query("SELECT * FROM tipo_clinica where activo='1' order by nombre desc ");
		echo '<option selected="selected" disabled="disabled" >--Seleccione--</option>';
		while($lug2 = $lug->fetch_array()){
			echo '<option value="'.$lug2['id_tipo_clinica'].'">'.$lug2['nombre'].'</option>';
		}
	?>
</select></span>
</td>
<td><h4><div align="center"><span class="label label-info">N° CLINICA</span></div></h4></td>
<td><span id="spryselect2"><select id="n_clinica" name="n_clinica" class="form-control"><option>--Seleccione--</option></select></span>
</td>
</tr>
<tr>
<td><h4><div align="center"><span class="label label-info">ESPECIALIDAD</span></div></h4></td>
<td><span id="spryselect3">
<select id="especialidad" name="especialidad" class="form-control">
<option>--Seleccione--</option></select>
</span>
</td>
<td>
<button type="button" class="btn btn-warning" title="REGISTRAR NUEVA ESPECIALIDAD" data-toggle="modal" data-target="#exampleModalLong">+</button>
</td>
</tr>
<tr>
<td><h4><div align="center"><span class="label label-info">SERVICIO</span></div></h4></td>
<td>
<select id="servicio" name="servicio" class="form-control selectpicker" data-live-search="true">
<?php
$lug = $local->query("SELECT * FROM servicios where activo='1'");
		echo "<option value='0' selected='selected'>--Seleccione--</option>";
		while($lug2 = $lug->fetch_array()){
			echo '<option value="'.$lug2['id_servicio'].'">'.$lug2['nombre_servicio'].'</option>';
		}
?>
</select>
</td>
<td ><h4><div align="center"><span class="label label-info">CONTRATO</span></div></h4></td>
<td><input class="form-control" type="text" name="contrato" id="contrato" /></td>
<td><button type="button" class="btn btn-warning" onclick="reg_contrato()"><span title="Agregar Contrato" class="glyphicon glyphicon-edit"></span></button></td>
</tr>
<tr>
<td><h4><div align="center"><span class="label label-info">FECHA Y HORA DE CITA</span></div></h4></td>
<td>
	<div class='input-group date form_date' data-date-format='yyyy-mm-dd hh:ii'>
	<input class='form-control input-field'	name='fecha_cita'	type='text'  value="<?php echo date ( 'Y-m-d H:i');?>" /> <span class='input-group-addon'>
	<span class='glyphicon glyphicon-calendar'></span>
	</span>
	</div>
</td>
<td ><h4><div align="center"><span class="label label-info">HISTORIA CLINICA</span></div></h4></td>
<td><input class="form-control" type="text" name="his_cli" id="his_cli" readonly /></td>
</tr>
<tr>
<td><h4><div align="center"><span class="label label-info">OPERADOR</span></div></h4></td>
<td><select class="form-control selectpicker" data-live-search="true"  id="operador" name="operador" >
<?php
$lug = $local->query("SELECT * FROM usuario where id_perfil='6' and activo='1' order by nombre_apellido asc");
		echo "<option value='' selected='selected' >--Seleccione--</option>";
		echo "<option value='999999'>SIN OPERADOR</option>";
		while($lug2 = $lug->fetch_array()){
			echo '<option value="'.$lug2['id_usuario'].'">'.$lug2['nombre_apellido'].'</option>';
		}
?>
</select>
</td>
<td><h4><div align="center"><span class="label label-info">DOCENTE CLINICA</span></div></h4></td>
<td><select class="form-control selectpicker" data-live-search="true"  id="docente_clinica" name="docente_clinica">
<?php
$lug = $local->query("SELECT * FROM usuario where id_perfil='7' and activo='1' order by nombre_apellido asc");
		echo "<option value='999999' selected='selected'  >--Seleccione--</option>";
		while($lug2 = $lug->fetch_array()){
			echo '<option value="'.$lug2['id_usuario'].'">'.$lug2['nombre_apellido'].'</option>';
		}
?>
</select>
</td>
</tr>
<tr>
<td><h4><div align="center"><span class="label label-info">AÑO OPERADOR</span></div></h4></td>
<td><input type="text" name="ano_operador" id="ano_operador" class="form-control" required /></td>
</tr>
<tr>
<td colspan="4"><select id="monto" name="monto" style="visibility:hidden">
  <option value='0' selected='selected'  >--Seleccione--</option>
</select>
</td>
</tr>
<tr>
<input type="hidden" name="generado_por" value="<?php echo $row_Recordset2['id_usuario']; ?>" />
<input class="form-control" type="hidden" name="id_paciente" id="id_paciente" />
<td colspan="4"><center><input class="btn btn-primary" type="submit" value="REGISTRAR" name="Registrar_Citas" /></center></td>
</tr>
</table>

</form>
</div>

  <!-- Modal  buscar usuario-->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
	   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
	   <h4 class="modal-title" align="left" id="myModalLabel"><b>REGISTRAR ESPECIALIDAD</b></h4>
      </div>
      <div class="modal-body">
    <form name="formulario" id="formulario"  class="formulario" method="POST" action="../Controllers/CRegistro.php" enctype="multipart/form-data" >

<table align="center">
<tr>
<td><h4><div align="center"><span class="label label-info">TIPO CLINICA</span></div></h4></td>
<td><span id="spryselect7"><select id="modal_tipo_clinica" name="modal_tipo_clinica" class="form-control">
  <?php  
		$lug = $local->query("SELECT * FROM tipo_clinica where activo='1' order by nombre desc ");
		echo '<option selected="selected" disabled="disabled" >--Seleccione--</option>';
		while($lug2 = $lug->fetch_array()){
			echo '<option value="'.$lug2['id_tipo_clinica'].'">'.$lug2['nombre'].'</option>';
		}
	?>
</select></span>
</td>
</tr>
<tr>
<td><h4><div align="center"><span class="label label-info">N° CLINICA</span></div></h4></td>
<td><span id="spryselect7"><select id="modal_n_clinica" name="modal_n_clinica" class="form-control"><option>--Seleccione--</option></select></span>
</td>
</tr>
<tr>
<td><h4><div align="center"><span class="label label-info">ESPECIALIDAD</span></div></h4></td>
<td><input type="text" name="modal_especialidad" class="form-control" />
</td>
	</tr>
	</table>
		</div>
      <div class="modal-footer">
	   <input type="submit" class="btn btn-primary" name="Especialidad" value="REGISTRAR"/>
      </div>
	  </form>
    </div>
  </div>
</div>


<?php include("flooter.php"); ?>
<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
var spryselect6 = new Spry.Widget.ValidationSelect("spryselect6");
var spryselect7 = new Spry.Widget.ValidationSelect("spryselect7");
var spryselect8 = new Spry.Widget.ValidationSelect("spryselect8");
</script>
</body>
<!-- InstanceEnd --></html>
<?php 
$Recordset2->free_result();	
?>