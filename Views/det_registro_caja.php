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
$MM_authorizedUsers = "8";
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
							tipo_clinica.nombre as nombre_tip_cli, clinica.nombre as nom_clinica, turno_atencion, usuario.nombre_apellido as nom_usuario,
							operador, docente_clinica, monto, abono1, abono2
							from registro
							inner join paciente on registro.dni=paciente.dni
							inner join tipo_clinica on tipo_clinica.id_tipo_clinica=registro.tipo_clinica
							inner join clinica on clinica.id_clinica=registro.n_clinica
							inner join usuario on usuario.id_usuario=registro.generado_por
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
<!-- InstanceEndEditable -->
<title>UNMSM</title>
<link href="../css/estilo.css" rel="stylesheet" type="text/css"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

</head>
<body >
<!-- InstanceBeginEditable name="cuerpo2" -->

<div class="header" align="right">
<a href="<?php echo $logoutAction ?>"><strong>Cerrar Sessión( <?php echo $row_Recordset2['nombre_apellido'];?>)</a><!-- InstanceEndEditable -->
<div align="left"><a href="caja.php"><img src="../imagenes/logo1.png" width="200px" Id="Insert_logo" /></a></div>
</div>
<!--Menú-->
<?php include("../menu/menu_caja.php"); ?>
  <!--FIN MENU-->
<div class="motorcategoria">
<form class="form-horizontal" name="form" method="POST" action="../Controllers/CRegistro.php" enctype="multipart/form-data" >
<table border="0" align="center" >
<tr>
<td colspan="6"><h3><div align="center"><span class="label label-info">REGISTRO N° <?php echo $row_DetailRS1['id_registro']; ?> </span></div></h3></td>
</tr>
<tr>
<td ><h4><div align="center"><span class="label label-info">PACIENTE</span></div></h4></td>
<td colspan="2"><input type="text" name="nom_paciente" id="nom_paciente" class="form-control" data-readonly value="<?php echo $row_DetailRS1['nom_paciente']; ?> " /></td>
</tr>
<tr>
<td ><h4><div align="center"><span class="label label-info">EDAD</span></div></h4></td>
<td><input class="form-control" type="text" value="<?php echo $row_DetailRS1['edad']; ?> " data-readonly /></td>
<td ><h4><div align="center"><span class="label label-info">DNI</span></div></h4></td>
<td><input type="text" value="<?php echo $row_DetailRS1['reg_dni'];?>"  class="form-control" data-readonly /></td>
</tr>
<tr>
<td ><h4><div align="center"><span class="label label-info">ESPECIALIDAD</span></div></h4></td>
<td><input class="form-control" type="text" value="<?php echo $row_DetailRS1['especialidad'];?>"  data-readonly /></td>
</tr>
<tr>
<td ><h4><div align="center"><span class="label label-info">TIPO CLINICA</span></div></h4></td>
<td><input class="form-control" type="text" value="<?php echo $row_DetailRS1['nombre_tip_cli'];?>"  data-readonly /></td>
<td ><h4><div align="center"><span class="label label-info">N° CLINICA</span></div></h4></td>
<td><input class="form-control" type="text" value="<?php echo $row_DetailRS1['nom_clinica'];?>"  data-readonly /></td>
</tr>
<tr>
<td ><h4><div align="center"><span class="label label-info">FECHA Y HORA DE CITA</span></div></h4></td>
<td><input class="form-control" type="text" value="<?php echo $row_DetailRS1['fecha_cita'];?>"  data-readonly /></td>

   
<td ><h4><div align="center"><span class="label label-info">TURNO DE ATENCION</span></div></h4></td>
<td><input class="form-control" type="text" value="<?php echo $row_DetailRS1['turno_atencion'];?>"  data-readonly /></td>
</tr>
<tr>
<td><h4><div align="center"><span class="label label-info">OPERADOR</span></div></h4></td>
<td><span id="spryselect4"><select class="form-control selectpicker" data-live-search="true"  id="operador" name="operador" >
<?php
$id_operador=$row_DetailRS1['operador'];
	$lug = $local->query("SELECT * FROM usuario where id_usuario='$id_operador'");
			while($lug2 = $lug->fetch_array()){
				$nom_operador=$lug2['nombre_apellido'];
			echo '<option value="'.$lug2['id_usuario'].'">'.$nom_operador.'</option>';
 }
 
?>
</select></span>
</td>
<td><h4><div align="center"><span class="label label-info">DOCENTE CLINICA</span></div></h4></td>
<td><span id="spryselect5"><select class="form-control selectpicker" data-live-search="true"  id="docente_clinica" name="docente_clinica">
<?php
 $id_docente=$row_DetailRS1['docente_clinica'];
	$doc1 = $local->query("SELECT * FROM usuario where id_usuario='$id_docente'");
			while($doc3 = $doc1->fetch_array()){
				$nom_doc_clinica=$doc3['nombre_apellido'];
			echo '<option value="'.$doc3['id_usuario'].'">'.$nom_doc_clinica.'</option>';
 }
?>
</select>
</span>
</td>
</tr>
<tr>
<td><h4><div align="center"><span class="label label-danger">MONTO TOTAL</span></div></h4></td>
<td><input type="text" class="form-control" name="monto_total" value="<?php echo $row_DetailRS1['monto']; ?>" data-readonly /></td>
</tr>
<tr>
<input type="hidden" name="id_registro" value="<?php echo $row_DetailRS1['id_registro']; ?>" />
<td><h4><div align="center"><span class="label label-danger">ABONO 1</span></div></h4></td>
<td><input type="text" class="form-control" name="abono1" value="<?php echo $row_DetailRS1['abono1']; ?>" />
<input type="hidden" class="form-control" name="id_usu_abono1" value="<?php echo $row_Recordset2['id_usuario']; ?>" /></td>
<td><input type="submit" class="btn btn-warning" name="Abono1" value="✓" title="REGISTRAR ABONO N°1"/>
<button type="button" id="nuevo-archivo-detalle" class="btn btn-success">DOCUMENTO</button>
</td>
</tr>
<tr>
<?php
if ($row_DetailRS1['abono1'] != '0' and $row_DetailRS1['abono1'] != $row_DetailRS1['monto'])
{
$abo1=$row_DetailRS1['abono1'];
$tot=$row_DetailRS1['monto'];
$rest=$tot-$abo1;

echo '<input type="hidden" name="resta" value="'.$rest.'" />';
echo '<input type="hidden" class="form-control" name="id_usu_abono2" value="'.$row_Recordset2['id_usuario'].'" /></td>';
echo '<td><h4><div align="center"><span class="label label-danger">ABONO 2</span></div></h4></td>
<td><input type="text" class="form-control" name="abono2" value="'.$row_DetailRS1['abono2'].'" /></td>
<td><input type="submit" class="btn btn-warning" name="Abono2" value="✓" title="REGISTRAR ABONO N°2"/>
<button type="button" id="nuevo-archivo-detalle_abono2" class="btn btn-success">DOCUMENTO</button></td>';
}
?>
</tr>

</table>
</form>
 </div>
 
 <!---------->

    <div class="modal fade" id="registra-archivo-detalle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel"><b>AÑADIR DOCUMENTO ABONO 1</b></h4>
            </div>
<form id="subida-detalle" >
<div class="modal-body">
<table>
	<tr>
	<td>DOCUMENTO</td>
	<td><input type="text" id="doc" name="doc" class="form-control" />
	<input type="hidden" name="id_registro" id="id_registro" value="<?php echo $row_DetailRS1['id_registro'];  ?>" />
	<input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $row_Recordset2['id_usuario'];  ?>" />
	
	</td>
	</tr>
	<tr>
	<td>FECHA</td>
    	<td><input type="text" id="desc" name="desc" class="form-control" value="<?php echo date('Y-m-d H:i'); ?>" data-readonly/></td>
    </tr>
	<tr>
	<td>ADJUNTAR ARCHIVO</td>
    	<td><input type="file" id="foto" name="foto"/></td>
    </tr>
	</table>
</div>
<div class="modal-footer">
<td><input type="submit" class="btn btn-info" value="Publicar"/></td>
<td><input type="button" id="guardar1" class="btn btn-default" value="Guardar"/></td>
</div>

<img src="../imagenes/LoaderIcon.gif" class="cargando" id="cargando"/>
<p>
</form>
<fieldset>
<table class="table table-hover" style="table-layout:fixed">
<tr class='active'>
<th>DOCUMENTO</th>
<th>FECHA</th>
<th>ARCHIVO</th>
<th>USUARIO</th>
<th>OPCION</th>
</tr> 
<div class="archivo" id="archivo">
           <?php
		   $id_reg=$row_DetailRS1['id_registro'];
            $registro = $local->query("SELECT *
								FROM documento_abono1
								inner join usuario on usuario.id_usuario=documento_abono1.id_usuario
								where id_registro='$id_reg'");
				while($registro2 = $registro->fetch_array()){
					echo '<tr>
						<td width="70">'.$registro2['documento'].'</td>
						<td width="70">'.$registro2['fecha_registro'].'</td>
						<td width="30"><a href="../archivos/'.$registro2['ruta'].'" target="_blank" class="btn btn-info">Descargar</a></td>
						<td width="70">'.$registro2['nombre_apellido'].'</td>
						<td width="8"><div align="center"><a href="javascript:eliminarArchivoDetalle('.$registro2['id_doc_abono1'].');" class="glyphicon glyphicon-remove-circle"></a></div></td>
						</tr>';
					}
 ?>
</table>
</div>
</fieldset>

</div>
  </div>
  </div>

  
  <!----------ABONO2------------------>
  
    <div class="modal fade" id="registra-archivo-detalle_abono2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel"><b>AÑADIR DOCUMENTO ABONO 2</b></h4>
            </div>
<form id="subida-detalle_abono2" >
<div class="modal-body">
<table>
	<tr>
	<td>DOCUMENTO</td>
	<td><input type="text" id="doc2" name="doc2" class="form-control" />
	<input type="hidden" name="id_registro2" id="id_registro2" value="<?php echo $row_DetailRS1['id_registro'];  ?>" />
	<input type="hidden" name="id_usuario2" id="id_usuario2" value="<?php echo $row_Recordset2['id_usuario'];  ?>" />
	
	</td>
	</tr>
	<tr>
	<td>FECHA</td>
    	<td><input type="text" id="desc2" name="desc2" class="form-control" value="<?php echo date('Y-m-d H:i'); ?>" data-readonly/></td>
    </tr>
	<tr>
	<td>ADJUNTAR ARCHIVO</td>
    	<td><input type="file" id="foto2" name="foto2"/></td>
    </tr>
	</table>
</div>
<div class="modal-footer">
<td><input type="submit" class="btn btn-info" value="Publicar"/></td>
<td><input type="button" id="guardar1" class="btn btn-default" value="Guardar"/></td>
</div>

<img src="../imagenes/LoaderIcon.gif" class="cargando" id="cargando"/>
<p>
</form>
<fieldset>
<table class="table table-hover" style="table-layout:fixed">
<tr class='active'>
<th>DOCUMENTO</th>
<th>FECHA</th>
<th>ARCHIVO</th>
<th>USUARIO</th>
<th>OPCION</th>
</tr> 
<div class="archivo" id="archivo">
           <?php
		   $id_reg=$row_DetailRS1['id_registro'];
            $registro = $local->query("SELECT *
								FROM documento_abono2
								inner join usuario on usuario.id_usuario=documento_abono2.id_usuario
								where id_registro='$id_reg'");
				while($registro2 = $registro->fetch_array()){
					echo '<tr>
						<td width="70">'.$registro2['documento'].'</td>
						<td width="70">'.$registro2['fecha_registro'].'</td>
						<td width="30"><a href="../archivos/'.$registro2['ruta'].'" target="_blank" class="btn btn-info">Descargar</a></td>
						<td width="70">'.$registro2['nombre_apellido'].'</td>
						<td width="8"><div align="center"><a href="javascript:eliminarArchivoDetalle('.$registro2['id_doc_abono2'].');" class="glyphicon glyphicon-remove-circle"></a></div></td>
						</tr>';
					}
 ?>
</table>
</div>
</fieldset>

</div>
  </div>
  </div>

<?php include("flooter.php"); ?>  
</body>
<!-- InstanceEnd -->
</html>

