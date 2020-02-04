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
$MM_authorizedUsers = "3";
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
$query_DetailRS1 = sprintf("select id_registro, registro.dni as reg_dni, especialidad, fecha_cita, edad, paciente.nombre_apellido as nom_paciente,
							tipo_clinica.nombre as nombre_tip_cli, clinica.nombre as nom_clinica, turno_atencion, usu.nombre_apellido as nom_usuario,
							fecha_inicio, fecha_fin, operador,ano_operador,registro.n_clinica as num_cli, docente_clinica, diagnostico, papeleta_gen, paciente.his_clinica	 as h_clinica, paciente.contrato as contrato
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
<script languaje="JavaScript"> 
function soloNumeros(e){
  var key = window.Event ? e.which : e.keyCode
  return (key >= 48 && key <= 57)
}
</script>
<script languaje="JavaScript"> 
function soloPrecio(e){
  var tecla;
  tecla=(document.all)? e.keyCode: e.which;
  if(tecla==8)
  {return true;}
var patron;
patron= /[0-9.]/
var te;
te= String.fromCharCode(tecla);
return patron.test(te);
}
</script>
<script type="text/javascript">
function imprimir(papeleta)
{
	var ficha=document.getElementById(papeleta);
	var ventimp=window.open(' ','popimpr');
	ventimp.document.write(ficha.innerHTML);
	ventimp.document.close();
	ventimp.print();
	ventimp.close();
}
</script>
<script type="text/javascript">
function imprimir(boleta)
{
	var ficha=document.getElementById(boleta);
	var ventimp=window.open(' ','popimpr');
	ventimp.document.write(ficha.innerHTML);
	ventimp.document.close();
	ventimp.print();
	ventimp.close();
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
<body >
<!-- InstanceBeginEditable name="cuerpo2" -->
<div class="header" align="right">
<a href="<?php echo $logoutAction ?>"><strong>Cerrar Sessión( <?php echo $row_Recordset2['nombre_apellido'];?>)</a><!-- InstanceEndEditable -->
<div align="left"><a href="admision.php"><img src="../imagenes/logo1.png" width="200px" Id="Insert_logo" /></a></div>
</div>
<!--Menú-->
<?php include("../menu/menu_adm.php"); ?>
  <!--FIN MENU-->
<p>
<div class="motorcategoria">
<form class="form-horizontal" name="form" method="POST" action="../Controllers/CRegistro.php" enctype="multipart/form-data" onsubmit="return confirm('¿Estas segúro de Modificar/Anular?');" >

<table border="0" align="center" >
<tr>
<td colspan='4'><div align="right"><a href="javascript:imprimir('boleta')"><h4><span class="label label-danger"><span class="glyphicon glyphicon-print"></span> IMPRIMIR</span></h4></a></div></td>
</tr>
<tr>
<td colspan="4"><h3><div align="center"><span class="label label-info">REGISTRO N° <?php echo $row_DetailRS1['id_registro']; ?> </span></div></h3></td>
</tr>
<tr>
<td>
<h4><div align="center"><span class="label label-info">FECHA REGISTRO</span></div></h4></td>
<td>
<div class='input-group date'>
	<input class='form-control input-field'	name='fecha_registro' data-readonly	type='text'  value="<?php echo date ( 'Y-m-d H:i');?>" /> <span class='input-group-addon'>
	<span class='glyphicon glyphicon-calendar'></span>
	</span>
	</div>
</td>
<td ><h4><div align="center"><span class="label label-info">COLABORADORA</span></div></h4></td>
<td colspan="2"><input class="form-control" type="text" name="colaboradora" value="<?php echo $row_DetailRS1['nom_usuario'];?>" data-readonly /></td>
</tr>
<tr>
<td ><h4><div align="center"><span class="label label-info">PACIENTE</span></div></h4></td>
<td colspan="2"><input type="text" name="nom_paciente" id="nom_paciente" class="form-control" value="<?php echo $row_DetailRS1['nom_paciente']; ?>" data-readonly /></td>
<td><button type="button" class="btn btn-danger" title="BUSCAR PACIENTE" onclick="popup()"><strong>BUSCAR PACIENTE</strong></button></td>
</tr>
<tr>
<td><h4><div align="center"><span class="label label-info">EDAD</span></div></h4></td>
<td><input class="form-control" type="text" name="edad" id="edad" value="<?php echo $row_DetailRS1['edad']; ?>" data-readonly /></td>
<td><h4><div align="center"><span class="label label-info">DNI</span></div></h4></td>
<td><input type="text" name="dni" id="dni" value="<?php echo $row_DetailRS1['reg_dni'];?>"  class="form-control" data-readonly />
<input type="hidden" name="correo" id="correo" class="form-control" required data-readonly /></td>
</tr>
<tr>
<td ><h4><div align="center"><span class="label label-info">TIPO CLINICA</span></div></h4></td>
<td>
<select class="form-control" id="tipo_clinica" name="tipo_clinica">
        <?php 
	 //DATOS DEL USUARIO
          $id_tipo_cli =$row_DetailRS1['tipo_clinica'];
			//FIN DATOS
          	$res7=$local->query("SELECT * FROM tipo_clinica where activo='1' order by nombre desc ");
            ?>
      		<?php 
			while($fila7=$res7->fetch_array()){
				$optionC = "<option value='".$fila7["id_tipo_clinica"]."'"; //iniciamos el codigo del option
				
				if($id_tipo_cli == $fila7["id_tipo_clinica"]){ //si el id  es igual al del usuario lo seleccionamos
					$optionC .= " selected='selected'";
				}
				
				$optionC .= ">".$fila7["nombre"]."</option>"; //terminamos el codigo del option
				
				echo $optionC; //imprimimos en pantalla el codigo que se armo
            }
			?>
      </select>
</td>
<td ><h4><div align="center"><span class="label label-info">N° CLINICA</span></div></h4></td>
<td><select class="form-control" id="n_clinica" name="n_clinica" >
<option value="<?php echo $row_DetailRS1['num_cli'];?>"><?php echo $row_DetailRS1['nom_clinica'];?></option>
</select></td>
</tr>
<tr>
<td ><h4><div align="center"><span class="label label-info">ESPECIALIDAD</span></div></h4></td>
<td><select class="form-control" id="especialidad" name="especialidad" >
<option value="<?php echo $row_DetailRS1['especialidad'];?>"><?php echo $row_DetailRS1['especialidad'];?></option>
</select></td>
</tr>
<tr>
<td><h4><div align="center"><span class="label label-info">SERVICIO</span></div></h4></td>
<td>
<select id="servicio" name="servicio" class="form-control selectpicker" data-live-search="true">
<?php
 
	 //DATOS DEL USUARIO
          $id_ser =$row_DetailRS1['id_ser'];
			//FIN DATOS
          	$res7=$local->query("SELECT * FROM servicios where activo='1' ");
            ?>
      		<?php 
			while($fila7=$res7->fetch_array()){
				$optionC = "<option value='".$fila7["id_servicio"]."'"; //iniciamos el codigo del option
				
				if($id_ser == $fila7["id_servicio"]){ //si el id  es igual al del usuario lo seleccionamos
					$optionC .= " selected='selected'";
				}
				
				$optionC .= ">".$fila7["nombre_servicio"]."</option>"; //terminamos el codigo del option
				
				echo $optionC; //imprimimos en pantalla el codigo que se armo
            }
			?>

</select>
</td>
</tr>
<tr>
<td ><h4><div align="center"><span class="label label-info">FECHA Y HORA DE CITA</span></div></h4></td>
<td>
	<div class='input-group date form_date' data-date-format='yyyy-mm-dd hh:ii'>
	<input class='form-control input-field'	name='fecha_cita'	type='text'  value="<?php echo $row_DetailRS1['fecha_cita']; ?>" /> <span class='input-group-addon'>
	<span class='glyphicon glyphicon-calendar'></span>
	</span>
	</div>
	
   </td>
<td ><h4><div align="center"><span class="label label-info">TURNO DE ATENCION</span></div></h4></td>
<td><input class="form-control" type="text" value="<?php echo $row_DetailRS1['turno_atencion'];?>"  data-readonly /></td>
</tr>
<tr>
<td><h4><div align="center"><span class="label label-info">HISTORIA CLINICA</span></div></h4></td>
<td><input class="form-control" type="text" name="his_cli" id="his_cli" data-readonly value="<?php echo $row_DetailRS1['h_clinica'];?>" /></td>
<td><h4><div align="center"><span class="label label-info">CONTRATO</span></div></h4></td>
<td><input class="form-control" type="text" name="contrato" id="contrato" data-readonly value="<?php echo $row_DetailRS1['contrato'];?>" /></td>
</tr>
<tr>
<td><h4><div align="center"><span class="label label-info">OPERADOR</span></div></h4></td>
<td><span id="spryselect4"><select class="form-control selectpicker" data-live-search="true"  id="operador" name="operador" >
 <?php 
	 //DATOS DEL USUARIO
          $id_ope =$row_DetailRS1['operador'];
			//FIN DATOS
	if($id_ope =='999999')
{
	$lug = $local->query("SELECT * FROM usuario where id_perfil='6' and activo='1'");
		echo "<option value='999999' selected='selected' >--Seleccione--</option>";
		while($lug2 = $lug->fetch_array()){
			echo '<option value="'.$lug2['id_usuario'].'">'.$lug2['nombre_apellido'].'</option>';
		}
}else
{
          	$res7=$local->query("SELECT * FROM usuario where id_perfil='6' and activo='1' order by nombre_apellido asc ");
            ?>
      		<?php 
			while($fila7=$res7->fetch_array()){
				
				$optionC = "<option value='".$fila7["id_usuario"]."'"; //iniciamos el codigo del option
				
				if($id_ope == $fila7["id_usuario"]){ //si el id  es igual al del usuario lo seleccionamos
					$optionC .= " selected='selected'";
				}
				
				$optionC .= ">".$fila7["nombre_apellido"]."</option>"; //terminamos el codigo del option
				
				echo $optionC; //imprimimos en pantalla el codigo que se armo
            }
}
			?>
</select></span>
</td>
<td><h4><div align="center"><span class="label label-info">DOCENTE CLINICA</span></div></h4></td>
<td><span id="spryselect5"><select class="form-control selectpicker" data-live-search="true"  id="docente_clinica" name="docente_clinica">
<?php
 $id_docente=$row_DetailRS1['docente_clinica'];
 if($id_docente=='999999')
 {
	 $lug = $local->query("SELECT * FROM usuario where id_perfil='7' and activo='1' order by nombre_apellido asc");
		echo "<option value='999999' selected='selected'  >--Seleccione--</option>";
		while($lug2 = $lug->fetch_array()){
			echo '<option value="'.$lug2['id_usuario'].'">'.$lug2['nombre_apellido'].'</option>';
		}
 }else{
 
	 	$res7=$local->query("SELECT * FROM usuario where id_perfil='7' and activo='1' order by nombre_apellido asc ");
            ?>
      		<?php 
			while($fila7=$res7->fetch_array()){
				$optionC = "<option value='".$fila7["id_usuario"]."'"; //iniciamos el codigo del option
				
				if($id_docente == $fila7["id_usuario"]){ //si el id  es igual al del usuario lo seleccionamos
					$optionC .= " selected='selected'";
				}
				
				$optionC .= ">".$fila7["nombre_apellido"]."</option>"; //terminamos el codigo del option
				
				echo $optionC; //imprimimos en pantalla el codigo que se armo
            }
 }
?>
</select>
</span>
</td>
</tr>
<tr>
<td><h4><div align="center"><span class="label label-info">AÑO OPERADOR</span></div></h4></td>
<td><input type="text" name="ano_operador" class="form-control" value="<?php echo $row_DetailRS1['ano_operador'] ?>" /></td>
</tr>
<tr>
<input type="hidden" name="generado_por" value="<?php echo $row_Recordset2['id_usuario']; ?>" />
<input type="hidden" name="id_registro" value="<?php echo $row_DetailRS1['id_registro']; ?>" />
<input class="form-control" type="hidden" name="id_paciente" id="id_paciente" value="<?php echo $row_DetailRS1['id_reg_pac']; ?>" />
<select id="monto" name="monto" style="visibility:hidden"><option value='<?php echo $row_DetailRS1['monto']; ?>' ><?php echo $row_DetailRS1['monto']; ?></option></select>
<td colspan="4"><br><center><input class="btn btn-warning" type="submit" value="MODIFICAR" name="Modificar" title="MODIFICAR DATOS REGISTRADOS" /> <input class="btn btn-Danger" type="submit" value="ANULAR" name="Anular_admision" title="ANULAR REGISTRO"/></center></td>
</tr>
</table>
</form>
</div>
<hr>
<div class="papeleta">
<h3><div align="center"><span class="label label-info">PAPELETA DE ATENCIÓN <?php echo $row_DetailRS1['id_registro']; ?></span></div></h3>
<form class="form-horizontal" name="form1" method="POST" action="../Controllers/CRegistro.php" enctype="multipart/form-data" >

<table align="center" >
<tr>
<td colspan='4'><div align="right"><a href="javascript:imprimir('papeleta')"><h4><span class="label label-danger"><span class="glyphicon glyphicon-print"></span> IMPRIMIR</span></h4></a></div></td>
</tr>
<tr>
<td><h4><div align="center"><span class="label label-info">FECHA Y HORA DE INICIO</span></div></h4></td>

<?php
if ($row_DetailRS1['fecha_inicio'] == NULL){
echo '<td><input type="datetime-local" required class="form-control" name="fecha_inicio" /></td>';
}
else{
echo '<td><input type="type" class="form-control" required name="fecha_inicio" value="'.$row_DetailRS1['fecha_inicio'].'" /></td>';
}
?>
<td><h4><div align="center"><span class="label label-info">FECHA Y HORA DE FIN</span></div></h4></td>
<?php
if ($row_DetailRS1['fecha_fin'] == NULL){
echo '<td><input type="datetime-local" required class="form-control" name="fecha_fin" /></td>';
}
else{
echo '<td><input type="type" class="form-control" required name="fecha_fin" value="'.$row_DetailRS1['fecha_fin'].'" /></td>';
}
?></tr>
<tr>
<td><h4><div align="center"><span class="label label-info">OPERADOR</span></div></h4></td>
<td><span id="spryselect4"><select class="form-control selectpicker" data-live-search="true"  id="operador" name="operador" >
 <?php 
	 //DATOS DEL USUARIO
          $id_ope =$row_DetailRS1['operador'];
			//FIN DATOS
	if($id_ope =='999999')
{
	$lug = $local->query("SELECT * FROM usuario where id_perfil='6' and activo='1'");
		echo "<option value='0' selected='selected' >--Seleccione--</option>";
		while($lug2 = $lug->fetch_array()){
			echo '<option value="'.$lug2['id_usuario'].'">'.$lug2['nombre_apellido'].'</option>';
		}
}else
{
          	$res7=$local->query("SELECT * FROM usuario where id_perfil='6' and activo='1' order by nombre_apellido asc ");
            ?>
      		<?php 
			while($fila7=$res7->fetch_array()){
				
				$optionC = "<option value='".$fila7["id_usuario"]."'"; //iniciamos el codigo del option
				
				if($id_ope == $fila7["id_usuario"]){ //si el id  es igual al del usuario lo seleccionamos
					$optionC .= " selected='selected'";
				}
				
				$optionC .= ">".$fila7["nombre_apellido"]."</option>"; //terminamos el codigo del option
				
				echo $optionC; //imprimimos en pantalla el codigo que se armo
            }
}
			?>
</select></span>
</td>
<td><h4><div align="center"><span class="label label-info">DOCENTE CLINICA</span></div></h4></td>
<td><span id="spryselect5"><select class="form-control selectpicker" data-live-search="true"  id="docente_clinica" name="docente_clinica">
<?php
 $id_docente=$row_DetailRS1['docente_clinica'];
 if($id_docente=='999999')
 {
	 $lug = $local->query("SELECT * FROM usuario where id_perfil='7' and activo='1'");
		echo "<option value='0' selected='selected'  >--Seleccione--</option>";
		while($lug2 = $lug->fetch_array()){
			echo '<option value="'.$lug2['id_usuario'].'">'.$lug2['nombre_apellido'].'</option>';
		}
 }else{
 
	 	$res7=$local->query("SELECT * FROM usuario where id_perfil='7' and activo='1' order by nombre_apellido asc ");
            ?>
      		<?php 
			while($fila7=$res7->fetch_array()){
				$optionC = "<option value='".$fila7["id_usuario"]."'"; //iniciamos el codigo del option
				
				if($id_docente == $fila7["id_usuario"]){ //si el id  es igual al del usuario lo seleccionamos
					$optionC .= " selected='selected'";
				}
				
				$optionC .= ">".$fila7["nombre_apellido"]."</option>"; //terminamos el codigo del option
				
				echo $optionC; //imprimimos en pantalla el codigo que se armo
            }
 }
?>
</select>
</span>
</td>
</tr>
<tr>
<td><h4><div align="center"><span class="label label-info">DIAGNOSTICO</span></div></h4></td>
<td colspan="3"><input type="text" class="form-control" name="diagnostico" value="<?php echo $row_DetailRS1['diagnostico']; ?>" autocomplete="off"/></td>
</tr>
<tr>
<input type="hidden" name="id_registro" value="<?php echo $row_DetailRS1['id_registro']; ?>" />
<input type="hidden" name="papeleta_gen" value="<?php echo $row_Recordset2['id_usuario']; ?>" />
<?php
if($row_DetailRS1['papeleta_gen']== NULL)
{
	echo '<td colspan="4"><center><input type="submit" class="btn btn-primary" name="Papeleta" value="REGISTRAR" /></center></td>';
}else
{
	echo '<td colspan="4"><center><input type="submit" class="btn btn-warning" name="Modificar_Papeleta" value="MODIFICAR" /></center></td>';	
}
?>
</tr>
</table>
</form>
<p>
<div>
<table align="center">
<td colspan="2" align="center">
<button id="nuevo-seguimiento" class="btn btn-success">AÑADIR</button>
</td>
</table>
</div>
</div>
<br>

<!-- AGREGAR PRODUCTO A LA RESERVA-->
    <div class="modal fade" id="registra-seguimiento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" align="left" id="myModalLabel"><b>AÑADIR</b></h4>
            </div>
            <form id="seguimiento" class="seguimiento" onSubmit="return agregaSeguimiento();">
            <div class="modal-body">
				<table border="0" width="100%">
                <tr>
                <td colspan="2"><input type="hidden" required readonly id="id-prod" name="id-prod" readonly="readonly" /></td>
                </tr>
               		 <tr>
                     <td><input type="hidden" readonly id="pro" name="pro"/></td>
                    </tr>					
                	<tr>
                    	<td>CODIGO:</td>
                        <td>
						<input type="text" class="form-control" required name="codigo" id="codigo" autocomplete="off" />
						</td>
                    </tr>
					<tr>
                    	<td>TRATAMIENTO:</td>
                        <td>
						<input type="text" class="form-control" required name="tratamiento" id="tratamiento" autocomplete="off" />
						</td>
                    </tr>
                    <tr>
                    	<td>PROCEDIMIENTO:</td>
                        <td>
						<input type="text" class="form-control" required name="procedimiento" id="procedimiento" autocomplete="off" />
						</td>
                    </tr>
					<tr>
                    	<td>CANTIDAD:</td>
                        <td>
						<input type="text" class="form-control" required name="cantidad" id="cantidad" onkeypress="return soloNumeros(event)" autocomplete="off"/>
						</td>
                    </tr>
					<tr>
                    	<td>INDICACIONES:</td>
                        <td>
						<input type="text" class="form-control" required name="indicaciones" id="indicaciones" autocomplete="off"/>
						</td>
                    </tr>
					<tr>
                    	<td>PRECIO:</td>
                        <td>
						<input type="text" class="form-control" required name="precio" id="precio" onkeypress="return soloPrecio(event)" autocomplete="off" />
						</td>
                    </tr>
                    <tr>
                    	<td colspan="2">
                        	<div id="mensaje"></div>
                        </td>
                    </tr>
                </table>
				
            </div>
            <div class="modal-footer">
			<input type="hidden" class="form-control" name="gen" value="<?php echo $row_Recordset2['id_usuario'];?>"/>
			<input type="hidden" class="form-control" id="id" name="id" value="<?php echo $row_DetailRS1['id_registro']; ?>">
            <input type="submit" value="Registrar" class="btn btn-success" id="reg"/>
            <input type="submit" style="display: none;" value="Editar" class="btn btn-warning"  id="edi"/>
			<input type="button" id="guardar" class="btn btn-default" value="Guardar"/>
                
            </div>
             <!--Vista-->
  <div class="" id="agrega-seguimiento">
        <table class='table table-hover' style='font-size:13px'>
            <tr class="active">
             <th>CODIGO</th>
                  <th>TRATAMIENTO</th>
				<th>PROCEDIMIENTO</th>
				<th>CANTIDAD</th>
				<th>INDICACIONES</th>
				<th>PRECIO</th>
            </tr>
        <?php
		$id_reg_pro=$row_DetailRS1['id_registro'];
		$registro = $local -> query("SELECT codigo, tratamiento, procedimiento,cantidad,indicaciones,precio
								FROM registro_tratamiento 
								where id_registro='$id_reg_pro' order by codigo asc"); 
			$item=0;
            while($registro2 = $registro->fetch_array()){
				$cantidad=$registro2['cantidad'];
				$precio=$registro2['precio'];
				$item=$item+1;
                echo '<tr>
				<td>'.$registro2['codigo'].'</td> 
                        <td>'.$registro2['tratamiento'].'</td> 
						<td>'.$registro2['procedimiento'].'</td>
						<td>'.$registro2['cantidad'].'</td> 
						<td>'.$registro2['indicaciones'].'</td> 
						<td>'.$registro2['precio'].'</td>
			 </tr>';       
            }
echo '</table>';
        ?>
  </div>
            </form>
          </div>
        </div>
  </div>
 

 <div id='papeleta' class="ticket">
<table>
<tr>
<td colspan="4"><div align="left"><img src="../imagenes/logo2.png" width="180px" /></div></td>
</tr>
<tr>
<td colspan="4"><CENTER>PAPELETA DE ATENCION <?php echo $row_DetailRS1['id_registro'];?></CENTER></td>
</tr>
<tr>
<td>FECHA Y HORA INICIO:</td>
<td><?php $f_inicio=$row_DetailRS1['fecha_inicio'];
if ($f_inicio == NULL){
echo '<img src="../imagenes/fecha_inicio.png" width="220px"></img>';
}
else{
echo $f_inicio; 
}?></td>
<td>FECHA Y HORA FIN:</td>
<td>
<?php $f_fin=$row_DetailRS1['fecha_fin'];
if ($f_inicio == NULL){
echo '<img src="../imagenes/fecha_inicio.png" width="220px"></img>';
}
else{
echo $f_fin; 
}?>
</td>
</tr>
<tr>
<td>DOCENTE CLINICA:</td>
<td><?php $id_doc2 =$row_DetailRS1['docente_clinica'];
$ope = $local->query("SELECT * FROM usuario where id_usuario='$id_doc2'");
		while($lug2 = $ope->fetch_array()){
			$nom_doc_clinica=$lug2['nombre_apellido'];
		}
	echo $nom_doc_clinica;
?></td>
<td>TIPO CLINICA:</td>
<td><?php echo $row_DetailRS1['nombre_tip_cli'];?></td>
</tr>
<tr>
<td>OPERADOR:</td>
<td><?php $id_ope2 =$row_DetailRS1['operador'];
$ope = $local->query("SELECT * FROM usuario where id_usuario='$id_ope2'");
		while($lug2 = $ope->fetch_array()){
			$nom_operador=$lug2['nombre_apellido'];
		}
	echo $nom_operador;
?></td>
<td>N° CLINICA:</td>
<td><?php echo $row_DetailRS1['nom_clinica'];?></td>
</tr>
<tr>
<td>PACIENTE:</td>
<td><?php echo $row_DetailRS1['nom_paciente'];?></td>
<td>ESPECIALIDAD</td>
<td><?php echo $row_DetailRS1['especialidad'];?></td>
</tr>
<tr>
<td>EDAD:</td>
<td><?php echo $row_DetailRS1['edad'];?></td>
<td>TURNO ATENCIÓN:</td>
<td><?php echo $row_DetailRS1['turno_atencion'];?></td>
</tr>
<tr>
<td>DNI:</td>
<td><?php echo $row_DetailRS1['reg_dni'];?></td>
</tr>
<tr>
<td>DIAGNOSTICO:</td>
<td><?php echo $row_DetailRS1['diagnostico'];?></td>
</tr>
</table>


<table border="1" width="100%">
<tr>
<th>COD</th>
<th>TRATAMIENTO</th>
<th>PROCEDIMIENTO</th>
<th>CANT.</th>
<th>INDICACIONES</th>
</tr>
<?php
 $id_reg_pro=$row_DetailRS1['id_registro'];
		$query = $local->prepare("SELECT * FROM registro_tratamiento WHERE id_registro='$id_reg_pro' ");
	 $query->execute();
	 $query->store_result();
     $rows = $query->num_rows;
	 
	 if($rows != 0)
	 {
		
		$registro = $local -> query("SELECT codigo, tratamiento, procedimiento,cantidad,indicaciones,precio
								FROM registro_tratamiento 
								where id_registro='$id_reg_pro' order by codigo asc"); 
            while($registro2 = $registro->fetch_array()){
				$cantidad=$registro2['cantidad'];
				$precio=$registro2['precio'];
                echo '<tr>
				<td>'.$registro2['codigo'].'</td> 
                        <td>'.$registro2['tratamiento'].'</td> 
						<td>'.$registro2['procedimiento'].'</td>
						<td>'.$registro2['cantidad'].'</td> 
						<td>'.$registro2['indicaciones'].'</td> 
			 </tr>';       
            }
	 }else
	 {
		 echo '<tr>
				<td></td> 
                        <td>&nbsp;</td> 
						<td>&nbsp;</td>
						<td>&nbsp;</td> 
						<td>&nbsp;</td>
			 </tr>';
			  echo '<tr>
				<td></td> 
                        <td>&nbsp;</td> 
						<td>&nbsp;</td>
						<td>&nbsp;</td> 
						<td>&nbsp;</td> 
			 </tr>';
			  echo '<tr>
				<td></td> 
                        <td>&nbsp;</td> 
						<td>&nbsp;</td>
						<td>&nbsp;</td> 
						<td>&nbsp;</td>
			 </tr>';
	 }
	 
echo '</table>';
echo '<br>';
	  echo '<br>';
	   echo '<br>';
	   echo '<br>';
echo '<table width="100%" border="0">
<tr>
<td><center>___________________________</center></td>
<td><center>___________________________</center></td>
</tr>
<tr>
<td><center>DOCENTE</center></td>
<td><center>OPERADOR</center></td>
</tr>
<tr>
<td><center>COP. <img src="../imagenes/cod_docente.png" width="150px"></img> </center></td>
<td><center>COD. <img src="../imagenes/cod_operador.png" width="240px"></img></center></td>
</tr>
</table>';
 ?>

</div>
<!---REPORTE--
 <tr>
<td colspan="2"><div align="left"><img src="../imagenes/logo1.png" width="200px" /></div></td>
</tr>-->
 <div id='boleta' class="ticket">
<table>
<tr>
<td colspan="2"><div align="left"><img src="../imagenes/logo2.png" width="220px" /></div></td>
</tr>
<tr>
<td colspan="2"><strong><center>CITA MEDICA</center></strong></td>
</tr>
<tr>
<td colspan="2"><hr></td>
</tr>
<tr>
<td>PACIENTE:</td>
<td><?php echo $row_DetailRS1['nom_paciente'];?></td>
</tr>
<tr>
<td>DNI:</td>
<td><?php echo $row_DetailRS1['reg_dni'];?></td>
</tr>
<tr>
<td>FECHA Y HORA CITA:</td>
<td><?php echo $row_DetailRS1['fecha_cita'];?></td>
</tr>
<tr>
<td>TIPO CLINICA:</td>
<td><?php echo $row_DetailRS1['nombre_tip_cli'];?></td>
</tr>
<tr>
<td>N° CLINICA:</td>
<td><?php echo $row_DetailRS1['nom_clinica'];?></td>
</tr>
<tr>
<td>ESPECIALIDAD:</td>
<td><?php echo $row_DetailRS1['especialidad'];?></td>
</tr>
<tr>
<td>OPERADOR:</td>
<td><?php $id_ope2 =$row_DetailRS1['operador'];
$ope = $local->query("SELECT * FROM usuario where id_usuario='$id_ope2'");
		while($lug2 = $ope->fetch_array()){
			$nom_operador=$lug2['nombre_apellido'];
		}
	echo $nom_operador;
?></td>
</tr>
<tr>
<td>DOCENTE CLINICA:</td>
<td><?php $id_doc2 =$row_DetailRS1['docente_clinica'];
$ope = $local->query("SELECT * FROM usuario where id_usuario='$id_doc2'");
		while($lug2 = $ope->fetch_array()){
			$nom_doc_clinica=$lug2['nombre_apellido'];
		}
	echo $nom_doc_clinica;
?></td>
</tr>
<tr>
<td>TURNO ATENCIÓN:</td>
<td><?php echo $row_DetailRS1['turno_atencion'];?></td>
</tr>
<tr>
<td colspan="2"><em>*Llegar 15 minutos antes de su cita.<em></td>
</tr>
<tr>
<td colspan="2"><em>*Tener en cuenta que toda atención previo pago en caja.<em></td>
</tr>
<tr>
<td colspan="2"><hr></td>
</tr>
<tr>
<td colspan="2"><strong><CENTER>¡CLÍNICA CENTRAL DE ODONTÓLOGIA A SU SERVICIO!</CENTER></strong></td>
</tr>
</table>
</div>
 <!----------> 
<br>
<br> 
<?php include("flooter.php"); ?>  
</body>
<!-- InstanceEnd -->
</html>

