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
							tipo_clinica, clinica.nombre as nom_clinica, turno_atencion, usuario.nombre_apellido as nom_usuario,
							operador, docente_clinica, registro.n_clinica as num_cli, registro.id_servicio as id_ser, servicios.nombre_servicio as nom_servicio, registro.monto as monto, tipo_clinica.nombre as nombre_tip_cli
							from registro
							inner join paciente on registro.dni=paciente.dni
							inner join clinica on clinica.id_clinica=registro.n_clinica
							inner join usuario on usuario.id_usuario=registro.generado_por
							inner join servicios on servicios.id_servicio=registro.id_servicio
							inner join tipo_clinica on tipo_clinica.id_tipo_clinica=registro.tipo_clinica
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
<!-- InstanceEndEditable -->
<title>UNMSM</title>
<link href="../css/estilo.css" rel="stylesheet" type="text/css"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
<div align="left"><a href="central_citas.php"><img src="../imagenes/logo1.png" width="200px" Id="Insert_logo" /></a></div>
</div>
<!--Menú-->
<?php include("../menu/menu_cc.php"); ?>
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
<td ><h4><div align="center"><span class="label label-info">HISTORIA CLINICA</span></div></h4></td>
<td><input class="form-control" type="text" name="his_cli" id="his_cli" data-readonly value="<?php echo $row_DetailRS1['reg_dni'];?>" /></td>
</tr>
<tr>
<input type="hidden" name="generado_por" value="<?php echo $row_Recordset2['id_usuario']; ?>" />
<input type="hidden" name="id_registro" value="<?php echo $row_DetailRS1['id_registro']; ?>" />

<select id="monto" name="monto" style="visibility:hidden"><option value='<?php echo $row_DetailRS1['monto']; ?>' ><?php echo $row_DetailRS1['monto']; ?></option></select>
<td colspan="4"><br><center><input class="btn btn-warning" type="submit" value="MODIFICAR" name="Modificar" title="MODIFICAR DATOS REGISTRADOS" /> <input class="btn btn-Danger" type="submit" value="ANULAR" name="Anular" title="ANULAR REGISTRO"/></center></td>
</tr>
</table>
</form>
 </div>
 <br>
 <!---REPORTE--
 <tr>
<td colspan="2"><div align="left"><img src="../imagenes/logo1.png" width="200px" /></div></td>
</tr>-->
 <div id='boleta' class="ticket">
<table>
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
<?php include("flooter.php"); ?>  
</body>
<!-- InstanceEnd -->
</html>