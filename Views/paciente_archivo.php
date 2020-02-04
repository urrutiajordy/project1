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
$MM_authorizedUsers = "4";
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
?>
<html><!-- InstanceBegin template="/Templates/plantilla administrador.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<link rel="shortcut icon" type="image/x-icon" href="../imagenes/favicon.ico"/>
<!-- InstanceBeginEditable name="head" -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="../js/jquery.js"></script>
	<script src="../js/myjava.js"></script>
	 <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css"/>
	<script src="../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
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
</head>
<body onload="lista_paciente_archivo('','1');">
<!-- InstanceBeginEditable name="cuerpo2" -->
<div align="right">
<a href="<?php echo $logoutAction ?>"><strong>Cerrar Sessión(<?php echo $row_Recordset2['nombre_apellido'];?>)</a><!-- InstanceEndEditable -->
<div align="left"><a href="archivo.php"><img src="../imagenes/logo1.png" width="200px" Id="Insert_logo" /></a></div>
</div>
<!--Menú-->
<?php include("../menu/menu_arch.php"); ?>
  <!--FIN MENU-->
<p>&nbsp;</p>
<!-- InstanceBeginEditable name="cuerpo" -->
<section> <table border="0" align="center">
	 <tr>
      <td width="500"><input  type="text" name="buscar" id="buscar" class="form-control" onkeyup = "lista_paciente_archivo(this.value,'1');" placeholder="BUSCAR POR: NOMBRE Y APELLIDO, OPERADOR, DNI OPERADOR, HISTORIA, CONTRATO"/></td>
	  <td>&nbsp;</td><td width="100"><button id="nuevo-producto" class="btn btn-primary">Nuevo</button></td>
	  </tr>
	  </table>
	   </section>
		<div id="paginador" class="text-center"></div>	   
	 <div >
	 <div id="lista"></div> 
	 </div>
	 <!-- MODAL PARA EL REGISTRO DE USUARIO-->
    <div class="modal fade" id="registra-producto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel"><b>PACIENTE</b></h4>
            </div>
            <form name="formulario" id="formulario"  class="formulario" method="POST" action="../Controllers/CArchivo.php" enctype="multipart/form-data" >
            <div class="modal-body">
            <input class="form-control" type="hidden" readonly="readonly" id="pro" name="pro"/>
            <table border="0" width="100%" align="center">
           <tr>
           <td>NOMBRE Y APELLIDO</td>
           <td><input class="form-control" type="text" autocomplete="off" required name="nombre_apellido" onkeypress="return soloLetras(event)" onkeyup="mayus(this);" placeholder="NOMBRE Y APELLIDO"/></td>
           
           <td>DNI</td>
           <td>
           <input class="form-control" type="text" required autocomplete="off" name="dni" maxlength="8" onkeypress="return soloNumeros(event)" placeholder="DNI"/></td>
           </tr>
           <tr>
           <td>SEXO</td>
           <td><select class="form-control" name="sexo">
           <option value="FEMENIMO">FEMENINO</option>
           <option value="MASCULINO">MASCULINO</option>
           </select></td>
           <td>FECHA NACIMIENTO</td>
           <td><input class="form-control" type="date"   name="fecha_nacimiento" /></td>
           </tr>
           <tr>
           <td>DIRECCIÓN</td>
           <td><input class="form-control" type="text" autocomplete="off" onkeyup="mayus(this);" required name="direccion" placeholder="DIRECCIÓN"/></td>
           <td>DISTRITO</td>
           <td><input class="form-control" type="text" autocomplete="off" onkeyup="mayus(this);" required name="distrito" placeholder="DISTRITO"/></td>
           </tr>
           <tr>
           <td>ESTADO CIVIL</td>
           <td><select class="form-control" name="estado_civil">
           <option value="CASADO">CASADO</option>
           <option value="DIVORSIADO">DIVORSIADO</option>
           <option selected="true" value="SOLTERO">SOLTERO</option>
           <option value="VIUDO">VIUDO</option>
           </select></td>
           <td>OCUPACION</td>
           <td><input type="text" name="ocupacion" placeholder="OCUPACION" class="form-control" ></td>
           </tr>
           <tr>
           <td>CORREO</td>
           <td><input class="form-control" type="text" autocomplete="off"  name="correo" placeholder="CORREO"/></td>
           <td>CELULAR</td>
           <td><input class="form-control" type="text" autocomplete="off"  name="celular" maxlength="9" onkeypress="return soloNumeros(event)" placeholder="CELULAR"/></td>
           </tr>
           <tr>
           <td>HISTORIA CLINICA</td>
           <td><input class="form-control" type="text" autocomplete="off"  name="h_clinica" placeholder="HISTORIA CLINICA"/></td>
           <td>FECHA HISTORIA CLINICA</td>
           <td><input class="form-control" type="date" autocomplete="off"  name="date_h_clinica"  /></td>
           </tr>
           <tr>
           <td>NUMERO CONTRATO</td>
           <td><input class="form-control" type="text" autocomplete="off"  name="contrato" placeholder="NUMERO CONTRATO"/></td>
           <td>FECHA CONTRATO</td>
           <td><input class="form-control" type="date" autocomplete="off"  name="date_contrato" /></td>
           </tr>
           <tr>
            <td>GRADO PACIENTE</td>
            <td><input type="text" name="grado_paciente" class="form-control" placeholder="GRADO PACIENTE"></td>
            <td>GRUPO SANGUINEO</td>
            <td><input type="text" name="grupo_sanguineo" class="form-control" placeholder="GRUPO SANGUINEO"></td>
           </tr>
           <tr>
            <td colspan="4"><hr></td>
           </tr>
           <tr>
            <td>OPERADOR</td>
            <td><input type="text" name="operador" class="form-control" placeholder="OPERADOR"></td>
            <td>DNI OPERADOR</td>
            <td><input type="text" name="dni_operador" class="form-control" placeholder="DNI OPERADOR"></td>
           </tr>

           <tr>
            <td>ALUMNO TRANSFERIDO</td>
            <td><input type="text" name="alum_tranferido" class="form-control" placeholder="ALUMNO TRANSFERIDO"></td>
            <td>DNI TRANSFERIDO</td>
            <td><input type="text" name="dni_transferido" class="form-control" placeholder="DNI TRANSFERIDO"></td>
           </tr>
           <tr>
            <td>AÑO ALUMNO</td>
            <td><input type="text" name="anio_alumno" class="form-control" placeholder="AÑO ALUMNO"></td>
            <td>AÑO ESTUDIO</td>
            <td><input type="text" name="anio_estudio"  class="form-control" placeholder="AÑO ESTUDIO"></td>
           </tr>
           <input type="hidden" name="id_paciente" />
            </table>
            </div>
            <div class="modal-footer">
              <input type="submit" value="Registrar" name="Registrar" class="btn btn-success" id="reg" />
            </div>
            </form>
          </div>
        </div>
      </div>
<br>
<br>
<div class="modal fade" id="actualizar_registra-producto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel"><b>PACIENTE</b></h4>
            </div>
            <form name="formulario_act" id="formulario_act"  class="formulario" method="POST" action="../Controllers/CArchivo.php" enctype="multipart/form-data" >
            <div class="modal-body">
            <input class="form-control" type="hidden" readonly="readonly" id="pro" name="pro"/>
            <table border="0" width="100%" align="center">
           <tr>
           <td>NOMBRE Y APELLIDO</td>
           <td><input class="form-control" type="text" autocomplete="off" required name="nombre_apellido" id="nombre_apellido" onkeypress="return soloLetras(event)" onkeyup="mayus(this);" placeholder="NOMBRE Y APELLIDO"/></td>
           
           <td>DNI</td>
           <td>
           <input class="form-control" type="text" required autocomplete="off" name="dni" maxlength="8" onkeypress="return soloNumeros(event)" id="dni" placeholder="DNI"/></td>
           </tr>
           <tr>
           <td>SEXO</td>
           <td><select class="form-control" name="sexo" id="sexo">
           <option value="FEMENIMO">FEMENINO</option>
           <option value="MASCULINO">MASCULINO</option>
           </select></td>
           <td>FECHA NACIMIENTO</td>
           <td><input class="form-control" type="date"   name="fecha_nacimiento" id="fecha_nacimiento"/></td>
           </tr>
           <tr>
           <td>DIRECCIÓN</td>
           <td><input class="form-control" type="text" autocomplete="off" onkeyup="mayus(this);" required name="direccion" id="direccion" placeholder="DIRECCIÓN"/></td>
           <td>DISTRITO</td>
           <td><input class="form-control" type="text" autocomplete="off" onkeyup="mayus(this);" required name="distrito" id="distrito" placeholder="DISTRITO"/></td>
           </tr>
           <tr>
           <td>ESTADO CIVIL</td>
           <td><input type="text" class="form-control" name="estado_civil" id="estado_civil" /></td>
           <td>OCUPACION</td>
           <td><input type="text" name="ocupacion" id="ocupacion" placeholder="OCUPACION" class="form-control" ></td>
           </tr>
           <tr>
           <td>CORREO</td>
           <td><input class="form-control" type="text" autocomplete="off"  name="correo" id="correo" placeholder="CORREO"/></td>
           <td>CELULAR</td>
           <td><input class="form-control" type="text" autocomplete="off"  name="celular" maxlength="9" onkeypress="return soloNumeros(event)" id="celular" placeholder="CELULAR"/></td>
           </tr>
           <tr>
           <td>HISTORIA CLINICA</td>
           <td><input class="form-control" type="text" autocomplete="off"  name="h_clinica" id="h_clinica" placeholder="HISTORIA CLINICA"/></td>
           <td>FECHA HISTORIA CLINICA</td>
           <td><input class="form-control" type="date" autocomplete="off"  name="date_h_clinica" id="date_h_clinica" /></td>
           </tr>
           <tr>
           <td>CONTRATO</td>
           <td><input class="form-control" type="text" autocomplete="off"  name="contrato" id="contrato" placeholder="NUMERO CONTRATO"/></td>
           <td>FECHA CONTRATO</td>
           <td><input class="form-control" type="date" autocomplete="off"  name="date_contrato" id="date_contrato" /></td>
           </tr>
           <tr>
           <td>CONTRATO PASADO</td>
           <td><input class="form-control" type="text" autocomplete="off"  name="contrato_pass" id="contrato_pass" placeholder="NUMERO CONTRATO"/></td>
           <td>NUEVO CONTRATO </td>
           <td><input class="form-control" type="text" autocomplete="off"  name="contrato_new" id="contrato_new" /></td>
           </tr>
           <tr>
            <td>FECHA ACTUALIZACION</td>
            <td><input class="form-control" type="date" autocomplete="off"  name="date_update" id="date_update" /></td>
           </tr>
           <tr>
            <td>GRADO PACIENTE</td>
            <td><input type="text" name="grado_paciente" id="grado_paciente" class="form-control" placeholder="GRADO PACIENTE"></td>
            <td>GRUPO SANGUINEO</td>
            <td><input type="text" name="grupo_sanguineo" id="grupo_sanguineo" class="form-control" placeholder="GRUPO SANGUINEO"></td>
           </tr>
           <tr>
            <td colspan="4"><hr></td>
           </tr>
           <tr>
            <td>OPERADOR</td>
            <td><input type="text" name="operador" id="operador" class="form-control" placeholder="OPERADOR"></td>
            <td>DNI OPERADOR</td>
            <td><input type="text" name="dni_operador" id="dni_operador" class="form-control" placeholder="DNI OPERADOR"></td>
           </tr>

           <tr>
            <td>ALUMNO TRANSFERIDO</td>
            <td><input type="text" name="alum_tranferido" id="alum_tranferido" class="form-control" placeholder="ALUMNO TRANSFERIDO"></td>
            <td>DNI TRANSFERIDO</td>
            <td><input type="text" name="dni_transferido" id="dni_transferido" class="form-control" placeholder="DNI TRANSFERIDO"></td>
           </tr>
           <tr>
            <td>AÑO ALUMNO</td>
            <td><input type="text" name="anio_alumno" id="anio_alumno" class="form-control" placeholder="AÑO ALUMNO"></td>
            <td>AÑO ESTUDIO</td>
            <td><input type="text" name="anio_estudio" id="anio_estudio" class="form-control" placeholder="AÑO ESTUDIO"></td>
           </tr>
           <input type="hidden" id="id_paciente" name="id_paciente" />
            </table>
            </div>
            <div class="modal-footer">
                <input type="submit" value="Editar" name="Modificar" class="btn btn-warning"  id="edi"/>
            </div>
            </form>
          </div>
        </div>
      </div>
	<!-- InstanceEndEditable -->
<?php include("flooter.php"); ?>
  
</body>
<!-- InstanceEnd -->
</html>
<?php 
$Recordset2->free_result();
?>