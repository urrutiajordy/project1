
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
$MM_authorizedUsers = "9";
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

?>
<?php require_once('../Connections/local2.php'); ?>
<html><!-- InstanceBegin template="/Templates/plantilla administrador.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<link rel="shortcut icon" type="image/x-icon" href="../imagenes/favicon.ico"/>
<!-- InstanceBeginEditable name="head" -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
		<script src="../js/jquery.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../js/myjava.js"></script>
<script type="text/javascript" src="../datatables/jquery-3.3.1.js"></script>

<link rel="stylesheet" href="../bootstrap/css/bootstrap-iso.css" />
<script type="text/javascript" src="../bootstrap/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="../bootstrap/css/bootstrap-datepicker3.css"/> 
<!-- InstanceEndEditable -->
<title>UNMSM</title>
<link href="../css/estilo.css" rel="stylesheet" type="text/css"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style type="text/css">
#container, #sliders {
	min-width: 310px; 
	max-width: 800px;
	margin: 0 auto;
}
#container {
	height: 400px; 
}
		</style>
		<script type="text/javascript">
$(function () {
    // Set up the chart
    var chart = new Highcharts.Chart({
        chart: {
            renderTo: 'container',
            type: 'column',
            margin: 75,
            options3d: {
                enabled: true,
                alpha: 15,
                beta: 15,
                depth: 50,
                viewDistance: 25
            }
        },
		
        title: {
            text: 'INGRESO CLINICA'
        },
        plotOptions: {
          column: {
                dataLabels: {
                    enabled: true
                }
            }
        },
		xAxis: {
            categories: [	
							['UNMSM']
	],
	
        },
        yAxis: {
            title: {
                text: 'CANTIDAD'
            }
        },
        series: [{
			name: 'TOTAL',
            data: [	
<?php 
$bus2=$_POST["fechainicio"];
	$bus3=$_POST["fechafin"];
$sql=$local->query("select SUM(monto) as monto_total
				from registro
				where fecha_registro between '".$bus2." 00:00:00' and  '".$bus3." 23:59:59'");
while($res=$sql->fetch_array()){			
?>		
				[<?php echo $res['monto_total'] ?>],
	<?php
}
?>	
	]	
        }, {
        name: 'ABONOS',
        data: [	
<?php 
$bus2=$_POST["fechainicio"];
	$bus3=$_POST["fechafin"];
$sql=$local->query("select SUM(abono1) as abono1, SUM(abono2) as abono2
				from registro
				where fecha_registro between '".$bus2." 00:00:00' and  '".$bus3." 23:59:59'");
while($res=$sql->fetch_array()){			
?>		
				[<?php echo $res['abono1']+$res['abono2'] ?>],
	<?php
}
?>	
	]
    }, {
        name: 'PRE GRADO',
        data: [	
<?php 
$bus2=$_POST["fechainicio"];
	$bus3=$_POST["fechafin"];
$sql=$local->query("select SUM(monto) as total_pre
				from registro
				where tipo_clinica='1' and fecha_registro between '".$bus2." 00:00:00' and  '".$bus3." 23:59:59'");
while($res=$sql->fetch_array()){			
?>		
				[<?php echo $res['total_pre'] ?>],
	<?php
}
?>	
	]
    }, {
        name: 'POST GRADO',
        data: [	
<?php 
$bus2=$_POST["fechainicio"];
	$bus3=$_POST["fechafin"];
$sql=$local->query("select SUM(monto) as total_post
				from registro
				where tipo_clinica='2' and fecha_registro between '".$bus2." 00:00:00' and  '".$bus3." 23:59:59'");
while($res=$sql->fetch_array()){			
?>		
				[<?php echo $res['total_post'] ?>],
	<?php
}
?>	
	]
    }]
    });

    function showValues() {
        $('#R0-value').html(chart.options.chart.options3d.alpha);
        $('#R1-value').html(chart.options.chart.options3d.beta);
    }

    // Activate the sliders
    $('#R0').on('change', function () {
        chart.options.chart.options3d.alpha = this.value;
        showValues();
        chart.redraw(false);
    });
    $('#R1').on('change', function () {
        chart.options.chart.options3d.beta = this.value;
        showValues();
        chart.redraw(false);
    });

    showValues();
});
		</script>
<script>
    $(document).ready(function(){
      var date_input=$('input[name="fechainicio"]'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
      var options={
        format: 'yyyy-mm-dd',
        container: container,
        todayHighlight: true,
        autoclose: true,
      };
      date_input.datepicker(options);
    })
</script>
<script>
    $(document).ready(function(){
      var date_input=$('input[name="fechafin"]'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
      var options={
        format: 'yyyy-mm-dd',
        container: container,
        todayHighlight: true,
        autoclose: true,
      };
      date_input.datepicker(options);
    })
</script>
</head>
<body >
<!-- InstanceBeginEditable name="cuerpo2" -->
<div align="right">
<a href="<?php echo $logoutAction ?>"><strong>Cerrar Sessión(<?php echo $row_Recordset2['nombre_apellido'];?>)</a><!-- InstanceEndEditable -->
<div align="left"><a href="caja_adm.php"><img src="../imagenes/logo1.png" width="200px" Id="Insert_logo" /></a></div>
</div>
<!--MENU--->
<?php include("../menu/menu_caja_admin.php"); ?>
<?php
$fecha = date('Y-m-d 00:00:00');
$nuevafecha = strtotime ( '-0 day' , strtotime ( $fecha ) ) ;
$nuevafecha = date ( 'Y-m-d 00:00' , $nuevafecha );
 
?>
<!-- InstanceBeginEditable name="cuerpo" -->
<h2><div align="center"><h3><span class="label label-info">INGRESO</span></h3></div></h2>
<br>
 <form method="post">
  <table align="center">
 <tr>
    <th><center><h4><span class="label label-info">FECHA INICIO</span></h4></center></th>
	<td><div class="col-xs-12">
	<div class="bootstrap-iso">
	<div class="input-group">
<input class="form-control" id="fechainicio" name="fechainicio" autocomplete="off" placeholder="MM/DD/YYY" type="text" value=<?php echo date('Y-m-d'); ?> /> <span class='input-group-addon'>
	<span class='glyphicon glyphicon-calendar'></span>
	</span>
</div>
	</div>
	</div>
   </tr>
   <tr>
	</td>
    <th><center><h4><span class="label label-info">FECHA FIN</span></h4></center></th>
    <td><div class="col-xs-12">
	<div class="bootstrap-iso">
	<div class="input-group">
<input class="form-control" id="fechafin" name="fechafin" autocomplete="off" placeholder="MM/DD/YYY" type="text" value=<?php echo date('Y-m-d'); ?> /> <span class='input-group-addon'>
	<span class='glyphicon glyphicon-calendar'></span>
	</span>
</div>
	</div>
	</div>
	</td>
  </tr>
  
  <tr>
  <td height="15"></td>
  </tr>
  <tr>
      <td colspan="4"><div align="center"><input type="submit" name="btn1"  value="CONSULTAR" class="btn btn-primary" /></div></td>
  </tr>
</table>
</form>
<script src="../Highcharts-4.1.5/js/highcharts.js"></script>
<script src="../Highcharts-4.1.5/js/modules/exporting.js"></script>
<div id='container' style='min-width: 310px; height: 0 auto; max-width: 600px; margin: 0 auto'></div>


<div id='REPORTE_INGRESO' align='center'>
<!-------------------EXCEL EXPORTAR------------------------->
<table  border="0" class="toggle" style="font-size:12">
<thead>
<tr class='active'>
      <th><div align="center">N</div></th>
       <th><div align="center">FECHA CITA</div></th>
	   <th><div align="center">NOMBRE Y APELLIDO</div></th>
	   <th><div align="center">DNI</div></th>
	   <th><div align="center">TIPO CLINICA</div></th>
	   <th><div align="center">NRO CLINICA</div></th>
	   <th><div align="center">ESPECIALIDAD</div></th>
	   <th><div align="center">SERVICIO</div></th>
	   <th><div align="center">OPERADOR</div></th>
	   <th><div align="center">DOCENTE</div></th>
	   <th><div align="center">MONTO TOTAL</div></th>
	   <th><div align="center">ABONO 1</div></th>
	   <th><div align="center">GENERADOR ABONO 1</div></th>
	   <th><div align="center">ABONO 2</div></th>
   	   <th><div align="center">GENERADOR ABONO 2</div></th>
	   <th><div align="center">TOTAL ABONO</div></th>
	   <th><div align="center">DEUDA</div></th>
	   </tr>
</thead>
<?php
if(isset($_POST["btn1"])){
	$btn=$_POST["btn1"];
	$bus2=$_POST["fechainicio"];
	$bus3=$_POST["fechafin"];
	if($btn=="CONSULTAR"){

	$sql="select id_registro, fecha_cita, registro.dni as reg_dni, especialidad, paciente.nombre_apellido as nombre_paciente,tipo_clinica.nombre as nombre_tip_cli, 
				clinica.nombre as nom_clinica, nombre_servicio, monto, abono1, abono2, opera.nombre_apellido as nom_operador, docent.nombre_apellido as nombre_docente
				from registro
				inner join paciente on registro.dni=paciente.dni
				inner join tipo_clinica on tipo_clinica.id_tipo_clinica=registro.tipo_clinica
				inner join clinica on clinica.id_clinica=registro.n_clinica
				inner join servicios on registro.id_servicio=servicios.id_servicio
				inner join usuario as opera on opera.id_usuario=registro.operador
				inner join usuario as docent on docent.id_usuario=registro.docente_clinica
				where  fecha_registro between '".$bus2." 00:00:00' and  '".$bus3." 23:59:59' ";
$result= mysqli_query($conn,$sql) or die('Error');
$item=0;
while($row= mysqli_fetch_assoc($result)){
	$t_abo=$row['abono1']+$row['abono2'];
	$deuda=$row['monto']-$t_abo;
$item=$item+1;
	echo "<tr>"
	. "<td>$item</td>"
	. "<td>{$row['fecha_cita']}</td>"
	. "<td>{$row['nombre_paciente']}</td>"
	. "<td>{$row['reg_dni']}</td>"
	. "<td>{$row['nombre_tip_cli']}</td>"
	. "<td>{$row['nom_clinica']}</td>"
	. "<td>{$row['especialidad']}</td>"
	. "<td>{$row['nombre_servicio']}</td>"
	. "<td>{$row['nom_operador']}</td>"
	. "<td>{$row['nombre_docente']}</td>"
	. "<td>{$row['monto']}</td>"	
	. "<td>{$row['abono1']}</td>"	
	. "<td>{$row['abono2']}</td>"	
	. "<td>{$t_abo}</td>"
	. "<td>{$deuda}</td>"
	. "</tr>";

}

$sql1="select SUM(monto) as monto_total
		from registro
			where	fecha_registro between '".$bus2." 00:00:00' and  '".$bus3." 23:59:59' ";
$result1= mysqli_query($local,$sql1) or die('Error');
while($row1= mysqli_fetch_assoc($result1)){
	$monto_total=$row1['monto_total'];
}
$sql2="select SUM(abono1) as tota_abono1, SUM(abono2) as tota_abono2
		from registro
		where		fecha_registro between '".$bus2." 00:00:00' and  '".$bus3." 23:59:59' ";
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
</table>
</div>
<link href="../css/tableexport.min.css" rel="stylesheet" type="text/css"/>
<script src="../js/FileSaver.min.js" type="text/javascript"></script>
<script src="../js/tableexport.min.js" type="text/javascript"></script>
<script>
$('#REPORTE_INGRESO').tableExport();
</script>

<?php
if(isset($connection))
{
	mysqli_close($connection);
}
?>
<br>
<?php include("flooter.php"); ?>
</body>
<!-- InstanceEnd -->
</html>