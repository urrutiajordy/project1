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
$MM_authorizedUsers = "5";
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
<title>UNMSM</title>
<script src="../js/jquery.js"></script>
<script src="../js/myjava.js"></script>

<link href="../css/estilo.css" rel="stylesheet" type="text/css"/>

<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css"/>

<link rel="stylesheet" href="../datatables/jquery_dataTables_min.css"/>
<link rel="stylesheet" href="../datatables/buttons.dataTables.min.css"/>
<script type="text/javascript" src="../datatables/jquery-3.3.1.js"></script>
<script type="text/javascript" src="../datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../datatables/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="../datatables/buttons.flash.min.js"></script>
<script type="text/javascript" src="../datatables/jszip.min.js"></script>
<script type="text/javascript" src="../datatables/pdfmake.min.js"></script>
<script type="text/javascript" src="../datatables/vfs_fonts.js"></script>
<script type="text/javascript" src="../datatables/buttons.html5.min.js"></script>
<script type="text/javascript" src="../datatables/buttons.print.min.js"></script>
<script src="../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="../bootstrap/css/bootstrap-iso.css" />
<script type="text/javascript" src="../bootstrap/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="../bootstrap/css/bootstrap-datepicker3.css"/>
<script>
$(document).ready(function() {
    $('#example').DataTable( 
	{
        dom: 'Bfrtip',
		language: {
            "lengthMenu": "Muestre _MENU_ filas por pagina",
            "zeroRecords": "NINGUN RESULTADO",
            "info": "Páginas _PAGE_ de _PAGES_",
            "infoEmpty": "Ningun Resultado",
            "infoFiltered": "(filtered from _MAX_ total records)"
        },
        buttons: [
           'excel', 'pdf', 'print'
        ]
    },
	);
} );
</script>
</head>
<body>
<!-- InstanceBeginEditable name="cuerpo2" -->
<div align="right">
<a href="<?php echo $logoutAction ?>"><strong>Cerrar Sessión(<?php echo $row_Recordset2['nombre_apellido'];?>)</a><!-- InstanceEndEditable -->
<div align="left"><a href="admision.php"><img src="../imagenes/logo1.png" width="200px" Id="Insert_logo" /></a></div>
</div>
<!--Menú-->
<?php include("../menu/menu_cli.php"); ?>
  <!--FIN MENU-->
<h3><div align="center"><span class="label label-info">PACIENTES</span></div></h3>

  <table id="example" class="display nowrap" style="font-size:14">
  <thead>
	<tr>
	   <th><div align="center">NOMBRE Y APELLIDO</div></th>
	   <th><div align="center">DNI</div></th>
	   <th><div align="center">SEXO</div></th>
	   <th><div align="center">FECHA NACIMIENTO</div></th>
	   <th><div align="center">DISTRITO</div></th>
	   <th><div align="center">DIRECCION</div></th>
	   <th><div align="center">ESTADO CIVIL</div></th>
	   <th><div align="center">CORREO</div></th>
	   <th><div align="center">CELULAR</div></th>
</tr>
</thead>
<?php
$sql="select * from paciente";
$result= mysqli_query($local,$sql) or die('Error');

while($row= mysqli_fetch_assoc($result)){
	echo "<tr>"
	. "<td>{$row['nombre_apellido']}</td>"
	. "<td>{$row['dni']}</td>"
	. "<td>{$row['sexo']}</td>"
	. "<td>{$row['fecha_nacimiento']}</td>"
	. "<td>{$row['distrito']}</td>"
	. "<td>{$row['direccion']}</td>"
	. "<td>{$row['estado_civil']}</td>"
	. "<td>{$row['correo']}</td>"
	. "<td>{$row['celular']}</td>"
	. "</tr>";
}
?>
</table>
<?php include("flooter.php"); ?>
  
</body>
<!-- InstanceEnd -->
</html>
<?php 
$Recordset2->free_result();
?>