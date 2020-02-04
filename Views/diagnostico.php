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
$MM_authorizedUsers = "10";
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
<?php require_once('../Connections/local2.php'); ?>
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
<style>
            #diag table {
                border: none;
                width: 100%;
                border-collapse: collapse;
            }

            #diag td { 
                padding: 5px 10px;
                text-align: center;
                border: 1px solid #999;
            }

            #diag tr:nth-child(1) {
                background: #dedede;
                font-weight: bold;
            }
        </style>
</head>
<body onload="lista_paciente_diagnostico('','1');">
<!-- InstanceBeginEditable name="cuerpo2" -->
<div align="right">
<a href="<?php echo $logoutAction ?>"><strong>Cerrar Sessión(<?php echo $row_Recordset2['nombre_apellido'];?>)</a><!-- InstanceEndEditable -->
<div align="left"><a href="diagnostico.php"><img src="../imagenes/logo1.png" width="200px" Id="Insert_logo" /></a></div>
</div>
<!--Menú-->
<?php include("../menu/menu_diagnostico.php"); ?>
  <!--FIN MENU-->
<p>&nbsp;</p>
<!-- InstanceBeginEditable name="cuerpo" -->

  <section> 
  <table border="0" align="center">
   <tr>
      <td width="500"><input  type="text" name="buscar" id="buscar" class="form-control" onkeyup = "lista_paciente_diagnostico(this.value,'1');" placeholder="BUSCAR POR: NUM. HISTORIA, NOMBRE Y APELLIDO, DNI, OPERADOR"/></td>
    <td>&nbsp;</td><td width="100"><button id="nuevo-producto" class="btn btn-primary">Nuevo</button></td>
    </tr>
    </table>
     </section>
	 <div id='REPORTE_PACIENTE' align='center'>
<!-------------------EXCEL EXPORTAR------------------------->
<table  border="0" class="toggle" style="font-size:12">
<thead>
<tr class='active'>
      <th><div align="center">N</div></th>
       <th><div align="center">NUM. BOLETA</div></th>
       <th><div align="center">HISTORIA</div></th>
	   <th><div align="center">APELLIDOS Y NOMBRES</div></th>
	   <th><div align="center">DNI</div></th>
	   <th><div align="center">EDAD</div></th>
	   <th><div align="center">FECHA REGISTRO</div></th>
	   <th><div align="center">PRE</div></th>
	   <th><div align="center">POS</div></th>
   	   <th><div align="center">OPERADOR</div></th>
	   <th><div align="center">ANIO</div></th>
	   </tr>
</thead>
<?php
	$sql="select n_boleta, historia_clinica, apellido_nombre, dni, edad, fecha_registro, pre, pos, operador, anio
				from diagnostico
				where activo=1 ";
$result= mysqli_query($conn,$sql) or die('Error');
$item=0;
while($row= mysqli_fetch_assoc($result)){
$item=$item+1;
	echo "<tr>"
	. "<td>$item</td>"
	. "<td>{$row['n_boleta']}</td>"
	. "<td>{$row['historia_clinica']}</td>"
	. "<td>{$row['apellido_nombre']}</td>"
	. "<td>{$row['dni']}</td>"
	. "<td>{$row['edad']}</td>"
	. "<td>{$row['fecha_registro']}</td>"
	. "<td>{$row['pre']}</td>"
	. "<td>{$row['pos']}</td>"
	. "<td>{$row['operador']}</td>"
	. "<td>{$row['anio']}</td>"
	. "</tr>";
}
?>
</table>
</div>

<link href="../css/tableexport.min.css" rel="stylesheet" type="text/css"/>
<script src="../js/FileSaver.min.js" type="text/javascript"></script>
<script src="../js/tableexport.min.js" type="text/javascript"></script>
<script>
$('#REPORTE_PACIENTE').tableExport();
</script>

<?php
if(isset($connection))
{
	mysqli_close($connection);
}
?>
    <div id="paginador" class="text-center"></div>     
   <div >
   <div id="lista"></div> 
   </div>
   <!-- MODAL PARA EL REGISTRO DE USUARIO-->
   <?php
   $ult_his_cli = $local->query("SELECT MAX(historia_clinica) as historia_clinica FROM diagnostico where activo=1");
    while($ult_his_cli1 = $ult_his_cli->fetch_array()){
            $ult_his_cli2=$ult_his_cli1['historia_clinica'];
            $proximo_h_c= $ult_his_cli2 + 1;
        }

    $ult_cod_int = $local->query("SELECT MAX(cod_interno) as codigo_interno FROM diagnostico");
    while($ult_cod_int1 = $ult_cod_int->fetch_array()){
            $ult_cod_int2=$ult_cod_int1['codigo_interno'];
             $prox_cod_inter= $ult_cod_int2 + 1; 
        }

   ?>
   <input type="hidden" id="ult_h_c" value="<?php echo $ult_his_cli2; ?>">
    <div class="modal fade" id="registra-producto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel"><b>PACIENTE</b></h4>
            </div>
            <form name="formulario" id="formulario"  class="formulario" method="POST" action="../Controllers/CDiagnostico.php" enctype="multipart/form-data" >
            <div class="modal-body">
            <input class="form-control" type="hidden" readonly="readonly" id="pro" name="pro"/>
            <table border="0" width="100%" align="center">
            <tr>
            <th>N° DE BOLETA</th>
            <td><input class="form-control" type="text" autocomplete="off" name="n_boleta" placeholder="NUMERO DE BOLETA"/></td>
            </tr>
            <tr>
            <th>HISTORIA CLINICA</th>
            <td><input class="form-control" type="text" autocomplete="off" name="historia_clinica" value="<?php echo $proximo_h_c; ?>" placeholder="HISTORIA CLINICA" readonly /></td>
            </tr>
            <tr>
            <th>APELLIDOS Y NOMBRES</th>
            <td><input class="form-control" type="text" autocomplete="off" name="apellido_nombre" placeholder="APELLIDO Y NOMBRE" /></td>
            </tr>
            <tr>
            <th>DNI</th>
            <td><input class="form-control" type="text" autocomplete="off" name="dni" placeholder="DNI" /></td>
            </tr>
            <tr>
            <th>EDAD</th>
            <td><input class="form-control" type="text" autocomplete="off" name="edad" placeholder="EDAD" /></td>
            </tr>
            <tr>
            <th>PRE</th>
            <td><input class="form-control" type="text" autocomplete="off" name="pre" placeholder="PRE" /></td>
            </tr>
            <tr>
            <th>POS</th>
            <td><input class="form-control" type="text" autocomplete="off" name="pos" placeholder="POS" /></td>
            </tr>
            <tr>
            <th>OPERADOR</th>
            <td><input class="form-control" type="text" autocomplete="off" name="operador" placeholder="NOMBRE DEL OPERADOR" /></td>
            </tr>
            <tr>
            <th>AÑO</th>
            <td><input class="form-control" type="text" autocomplete="off" name="anio" placeholder="AÑO" /></td>
            </tr>
            </table>
            </div>
            <div class="modal-footer">
              <input class="form-control" type="hidden" value="<?php echo $prox_cod_inter; ?>" name="cod_interno" />
              <input type="submit" value="Registrar" name="Registrar" class="btn btn-success" id="reg" />
            </div>
            </form>
          </div>
        </div>
      </div>
<br>
<br>
<div class="modal fade" id="actualizar_registra-producto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel"><b>PACIENTE</b></h4>
            </div>
            <form name="formulario_act" id="formulario_act"  class="formulario" method="POST" action="../Controllers/CDiagnostico.php" enctype="multipart/form-data" >
            <div class="modal-body">
            <input class="form-control" type="hidden" readonly="readonly" id="pro" name="pro"/>
            <table border="0" width="100%" align="center">
            <tr>
            <td>N° DE BOLETA</td>
            <td><input class="form-control" type="text" autocomplete="off" id="n_boleta" name="n_boleta" placeholder="NUMERO DE BOLETA"/></td>
            </tr>
            <tr>
            <td>HISTORIA CLINICA</td>
            <td><input class="form-control" type="text" autocomplete="off" id="historia_clinica" name="historia_clinica" placeholder="HISTORIA CLINICA" /></td>
            </tr>
            <tr>
            <td>APELLIDOS Y NOMBRES</td>
            <td><input class="form-control" type="text" autocomplete="off" id="apellido_nombre" name="apellido_nombre" placeholder="APELLIDO Y NOMBRE" /></td>
            </tr>
            <tr>
            <td>DNI</td>
            <td><input class="form-control" type="text" autocomplete="off" id="dni" name="dni" placeholder="DNI" /></td>
            </tr>
            <tr>
            <td>EDAD</td>
            <td><input class="form-control" type="text" autocomplete="off" id="edad" name="edad" placeholder="EDAD" /></td>
            </tr>
            <tr>
            <td>PRE</td>
            <td><input class="form-control" type="text" autocomplete="off" id="pre" name="pre" placeholder="PRE" /></td>
            </tr>
            <tr>
            <td>POS</td>
            <td><input class="form-control" type="text" autocomplete="off" id="pos"  name="pos" placeholder="POS" /></td>
            </tr>
            <tr>
            <td>OPERADOR</td>
            <td><input class="form-control" type="text" autocomplete="off" id="operador" name="operador" placeholder="NOMBRE DEL OPERADOR" /></td>
            </tr>
            <tr>
            <td>AÑO</td>
            <td><input class="form-control" type="text" autocomplete="off" id="anio" name="anio" placeholder="AÑO" /></td>
            </tr>
           <input type="hidden" name="cod_interno" id="cod_interno"/>
            </table>
            </div>
            <div class="modal-footer">
              <input type="submit" value="Modificar" name="Modificar" class="btn btn-warning" id="edi" />
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