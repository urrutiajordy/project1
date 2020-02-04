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

?>
<?php require_once('../Connections/local2.php'); ?>
<html><!-- InstanceBegin template="/Templates/plantilla administrador.dwt" codeOutsideHTMLIsLocked="false" -->
<link rel="shortcut icon" type="image/x-icon" href="../imagenes/favicon.ico"/>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
<!-- InstanceBeginEditable name="head" -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
		<script src="../js/jquery.js"></script>
		<script src="../js/myjava.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
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
            text: 'CANTIDAD DE CITAS MEDICAS'
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
							['CITAS MEDICAS']
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
$sql=$local->query("select count(id_registro) as cantidad
				from registro
				where activo='1' and fecha_registro between '".$bus2." 00:00:00' and  '".$bus3." 23:59:59'");
while($res=$sql->fetch_array()){			
?>		
				[<?php echo $res['cantidad'] ?>],
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
$sql=$local->query("select count(id_registro) as cantidad
				from registro
				where activo='1' and  tipo_clinica='1' and fecha_registro between '".$bus2." 00:00:00' and  '".$bus3." 23:59:59'");
while($res=$sql->fetch_array()){			
?>		
				[<?php echo $res['cantidad'] ?>],
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
$sql=$local->query("select count(id_registro) as cantidad
				from registro
				where activo='1' and  tipo_clinica='2' and fecha_registro between '".$bus2." 00:00:00' and  '".$bus3." 23:59:59'");
while($res=$sql->fetch_array()){			
?>		
				[<?php echo $res['cantidad'] ?>],
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
<div class="header" align="right">
<a href="<?php echo $logoutAction ?>"><strong>Cerrar Sessión( <?php echo $row_Recordset2['nombre_apellido'];?>)</a><!-- InstanceEndEditable -->
<div align="left"><a href="admision.php"><img src="../imagenes/logo1.png" width="200px" Id="Insert_logo" /></a></div>
</div>
<!--Menú-->
<?php include("../menu/menu_adm.php"); ?>

<!-- InstanceBeginEditable name="cuerpo" -->
<h2><div align="center"><h3><span class="label label-info">REPORTE DE CITAS</span></h3></div></h2>
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
<script src="../Highcharts-4.1.5/js/highcharts-3d.js"></script>
<div id="container"></div>
<div id="sliders">
	<table>
		<tr><td>Alpha Angle</td><td><input id="R0" type="range" min="0" max="45" value="15"/> <span id="R0-value" class="value"></span></td></tr>
	    <tr><td>Beta Angle</td><td><input id="R1" type="range" min="0" max="45" value="15"/> <span id="R1-value" class="value"></span></td></tr>
	</table>
</div>

<div id='REPORTE_CANTIDAD_CITAS' align='center'>
<!-------------------EXCEL EXPORTAR------------------------->
<table  border="0" class="toggle" style="font-size:12">
<thead>
<tr class='active'>
      <th><div align="center">N</div></th>
       <th><div align="center">FECHA REGISTRO</div></th>
       <th><div align="center">FECHA CITA</div></th>
	   <th><div align="center">NOMBRE Y APELLIDO</div></th>
	   <th><div align="center">TIPO CLINICA</div></th>
	   <th><div align="center">NRO CLINICA</div></th>
	   <th><div align="center">ESPECIALIDAD</div></th>
	   <th><div align="center">TURNO ATENCION</div></th>
	   <th><div align="center">GENERADO POR</div></th>
	   </tr>
</thead>
<?php
if(isset($_POST["btn1"])){
	$btn=$_POST["btn1"];
	$bus2=$_POST["fechainicio"];
	$bus3=$_POST["fechafin"];
	if($btn=="CONSULTAR"){

	$sql="select id_registro, fecha_registro, fecha_cita, paciente.nombre_apellido as nom_paciente,tipo_clinica.nombre as nombre_tip_cli, clinica.nombre as nom_clinica, turno_atencion, especialidad, usuario.nombre_apellido as generado
				from registro
				inner join paciente on registro.dni=paciente.dni
				inner join tipo_clinica on tipo_clinica.id_tipo_clinica=registro.tipo_clinica
				inner join clinica on clinica.id_clinica=registro.n_clinica
				inner join usuario on usuario.id_usuario=registro.generado_por
				where registro.activo='1' and fecha_registro between '".$bus2." 00:00:00' and  '".$bus3." 23:59:59'";
$result= mysqli_query($conn,$sql) or die('Error');
$item=0;
while($row= mysqli_fetch_assoc($result)){
$item=$item+1;
	echo "<tr>"
	. "<td>$item</td>"
	. "<td>{$row['fecha_registro']}</td>"
	. "<td>{$row['fecha_cita']}</td>"
	. "<td>{$row['nom_paciente']}</td>"
	. "<td>{$row['nombre_tip_cli']}</td>"
	. "<td>{$row['nom_clinica']}</td>"
	. "<td>{$row['especialidad']}</td>"
	. "<td>{$row['turno_atencion']}</td>"
	. "<td>{$row['generado']}</td>"

	. "</tr>";

}
}		
}
?>
</table>
</div>

<link href="../css/tableexport.min.css" rel="stylesheet" type="text/css"/>
<script src="../js/FileSaver.min.js" type="text/javascript"></script>
<script src="../js/tableexport.min.js" type="text/javascript"></script>
<script>
$('#REPORTE_CANTIDAD_CITAS').tableExport();
</script>

<?php
if(isset($connection))
{
	mysqli_close($connection);
}
?>
<br>
<?php include("flooter.php"); ?>
<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
</script>
</body>
<!-- InstanceEnd -->
</html>