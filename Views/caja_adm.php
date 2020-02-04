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
$MM_authorizedUsers = "9";
$MM_donotCheckaccess = "false";

// *** Restringir el acceso a la página: Conceda o denegue el acceso a esta página
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // Por razones de seguridad, comience asumiendo que el visitante NO está autorizado. 
  $isValid = False; 

  // Cuando un visitante ha iniciado sesión en este sitio, la variable de sesión MM_Username establece igual a su nombre de usuario.
  // Por lo tanto, sabemos que un usuario no está conectado si esa variable de sesión está en blanco.
  if (!empty($UserName)) { 
    // Además de haber iniciado sesión, puede restringir el acceso a sólo determinados usuarios basándose en un ID establecido al iniciar sesión.
    // Analizar las cadenas en matrices.
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // O, puede restringir el acceso a sólo ciertos usuarios basándose en su nombre de usuario.
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "operador.php";
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
date_default_timezone_set("America/Lima");
?>
<html>
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
<div align="right">
<a href="<?php echo $logoutAction ?>"><strong>Cerrar Sessión(<?php echo $row_Recordset2['nombre_apellido'];?>)</a><!-- InstanceEndEditable -->
<div align="left"><a href="caja_adm.php"><img src="../imagenes/logo1.png" width="200px" Id="Insert_logo" /></a></div>
</div>
<!--MENU--->
<?php include("../menu/menu_caja_admin.php"); ?>
<h3><div align="center"><span class="label label-info">CAJA</span></div></h3>
<br>
 <form method="post">

<table align="center">
<tr>
<td><h4><div align="center"><span class="label label-info">INGRESAR N° DNI:</span></div></h4></td>
<td><div class="col-xs-12">
<div class="bootstrap-iso">
<input class="form-control" id="dni" name="dni" autocomplete="off" type="text" />
</div>
</div>
</td>
</tr>
<tr><td><br></td></tr>
<tr>
<td colspan="2"><center><input class="btn btn-primary" type="submit" value="CONSULTAR" name="btn1" /></center></td>
</tr>
</table>
</form>
<div class="margen">
<table id="example" class="display nowrap" style="font-size:12">
<thead>
<tr>
      <th><div align="center">N</div></th>
       <th><div align="center">FECHA CITA</div></th>
	   <th><div align="center">NOMBRE Y APELLIDO</div></th>
	   <th><div align="center">DNI</div></th>
	   <th><div align="center">TIPO CLINICA</div></th>
	   <th><div align="center">NRO CLINICA</div></th>
	   <th><div align="center">ESPECIALIDAD</div></th>
	   <th><div align="center">SERVICIO</div></th>
	   <th><div align="center">MONTO TOTAL</div></th>
	   <th><div align="center">ABONO 1</div></th>
	   <th><div align="center">ABONO 2</div></th>
	   <th><div align="center">TOTAL ABONO</div></th>
	   <th><div align="center">DEUDA</div></th>
	   <th><div align="center">LEYENDA</div></th>
</tr>
</thead>
<?php
if(isset($_POST["btn1"])){
	$btn=$_POST["btn1"];
	$bus2=$_POST["dni"];
	if($btn=="CONSULTAR"){
	

	$sql="select id_registro, fecha_cita, registro.dni as reg_dni, especialidad, paciente.nombre_apellido as nombre_paciente,tipo_clinica.nombre as nombre_tip_cli, 
				clinica.nombre as nom_clinica, nombre_servicio, monto, abono1, abono2
				from registro
				inner join paciente on registro.dni=paciente.dni
				inner join tipo_clinica on tipo_clinica.id_tipo_clinica=registro.tipo_clinica
				inner join clinica on clinica.id_clinica=registro.n_clinica
				inner join servicios on registro.id_servicio=servicios.id_servicio
				where  registro.dni like '%".$bus2."%' ";
$result= mysqli_query($local,$sql) or die('Error');
$item=0;
while($row= mysqli_fetch_assoc($result)){
	$id=$row['id_registro'];
	$t_abo=$row['abono1']+$row['abono2'];
	$deuda=$row['monto']-$t_abo;
$item=$item+1;

	if($deuda=='0')
	{
		$color='blue';
	}
	else{
		$color='red';
	}
	echo "<tr style='color:".$color."' >"
	. "<td>$item</td>"
	. "<td><a href='det_registro_caja_adm.php?recordID=$id' target='_blank'>{$row['fecha_cita']}</a></td>"
	. "<td>{$row['nombre_paciente']}</td>"
	. "<td>{$row['reg_dni']}</td>"
	. "<td>{$row['nombre_tip_cli']}</td>"
	. "<td>{$row['nom_clinica']}</td>"
	. "<td>{$row['especialidad']}</td>"
	. "<td>{$row['nombre_servicio']}</td>"
	. "<td>{$row['monto']}</td>"	
	. "<td>{$row['abono1']}</td>"	
	. "<td>{$row['abono2']}</td>"	
	. "<td>{$t_abo}</td>"
	. "<td>{$deuda}</td>"
	. "</tr>";

}

$sql1="select SUM(monto) as monto_total
		from registro
				where  dni like '%".$bus2."%' ";
$result1= mysqli_query($local,$sql1) or die('Error');
while($row1= mysqli_fetch_assoc($result1)){
	$monto_total=$row1['monto_total'];
}
$sql2="select SUM(abono1) as tota_abono1, SUM(abono2) as tota_abono2
		from registro
				where  dni like '%".$bus2."%' ";
$result2= mysqli_query($local,$sql2) or die('Error');

while($row2= mysqli_fetch_assoc($result2)){
	$tota_abono1=$row2['tota_abono1'];
	$tota_abono2=$row2['tota_abono2'];
	$total_abonos=$tota_abono1+$tota_abono2;
}
$pendiente=$monto_total-$total_abonos;
	echo "<tr>"
	. "<td></td>"	
	. "<td></td>"	
	. "<td></td>"
	. "<td></td>"
	. "<td></td>"
	. "<td></td>"
	. "<td></td>"
	. "<td>TOTAL</td>"
	. "<td>{$monto_total}</td>"
	. "<td>{$tota_abono1}</td>"	
	. "<td>{$tota_abono2}</td>"	
	. "<td>{$total_abonos}</td>"	
	. "<td>{$pendiente}</td>"		
	. "<td></td>"		
	. "</tr>";
}		
}

?>
</div>
<br>
<?php include("flooter.php"); ?>  
</body>
</html>