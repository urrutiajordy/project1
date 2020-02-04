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

$MM_restrictGoTo = "caja.php";
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
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
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
    $(document).ready(function(){
      var date_input=$('input[name="date"]'); //our date input has the name "date"
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
<script type="text/javascript">
function imp_papeleta(pap)
{
	var ficha=document.getElementById(pap);
	var ventimp=window.open(' ','popimpr');
	ventimp.document.write(ficha.innerHTML);
	ventimp.document.close();
	ventimp.print();
	ventimp.close();
}
</script>
</head>
<body>
<div align="right">
<a href="<?php echo $logoutAction ?>"><strong>Cerrar Sessión(<?php echo $row_Recordset2['nombre_apellido'];?>)</a><!-- InstanceEndEditable -->
<div align="left"><a href="clinica.php"><img src="../imagenes/logo1.png" width="200px" Id="Insert_logo" /></a></div>
</div>
<!--MENU--->
<?php include("../menu/menu_cli.php"); ?>
<h3><div align="center"><span class="label label-info">CITAS MEDICAS</span></div></h3>
<br>
 <form method="post">

<table align="center">
<tr>
<td ><h4><div align="center"><span class="label label-info">FECHA CITA</span></div></h4></td>
<td>
<div class="bootstrap-iso">
<input class="form-control" id="date" name="date" required autocomplete="off" placeholder="MM/DD/YYY" type="text" value=<?php echo date('Y-m-d'); ?> />
</div>
   </td></tr>
<tr>
<td><h4><div align="center"><span class="label label-info">TIPO CLINICA</span></div></h4></td>
<td>
<span id="spryselect1">
<select id="tipo_clinica_all" name="tipo_clinica_all" class="form-control">
  <?php
		$query = $local -> query ("SELECT * FROM tipo_clinica where activo='1' order by nombre desc"); 
		echo '<option selected="selected" disabled="disabled" >--Seleccione--</option>';
	echo '<option value="t_all">TODOS</option>';
		while ($valores = mysqli_fetch_array($query))
		{              
		echo '<option value="'.$valores['id_tipo_clinica'].'">'.$valores['nombre'].'</option>';
		}
?>  
		
</select>
</span>
</td>
</tr>
<tr>
<td ><h4><div align="center"><span class="label label-info">N° CLINICA</span></div></h4></td>
<td>
<span id="spryselect2">
<select id="n_clinica_all" name="n_clinica_all" class="form-control">
<option >--Seleccione--</option>
</select>
</span>
</td>
</tr>
<tr><td><br></td></tr>
<tr>
<td colspan="2"><center><input class="btn btn-primary" type="submit" value="CONSULTAR" name="btn1" /></center></td>
</tr>
</table>
</form>
<a href="javascript:imp_papeleta('pap')"><h4><span class="label label-danger"><span class="glyphicon glyphicon-print"></span> IMPRIMIR PAPELETA</span></h4></a>
<table id="example" class="display nowrap" style="font-size:14">
<thead>
<tr>
      <th><div align="center">N</div></th>
       <th><div align="center">FECHA CITA</div></th>
	   <th><div align="center">NOMBRE Y APELLIDO</div></th>
	   <th><div align="center">DNI</div></th>
	   <th><div align="center">TIPO CLINICA</div></th>
	   <th><div align="center">NRO CLINICA</div></th>
	   <th><div align="center">ESPECIALIDAD</div></th>
	   <th><div align="center">OPERADOR</div></th>
	   <th><div align="center">DOCENTE CLINICA</div></th>
	   <th><div align="center">TURNO ATENCION</div></th>
</tr>
</thead>
<?php
if(isset($_POST["btn1"])){
	$btn=$_POST["btn1"];
	$bus2=$_POST["date"];
	$bus3=$_POST["n_clinica_all"];
	$bus4=$_POST["tipo_clinica_all"];
	if($btn=="CONSULTAR"){
	
	if( $bus3!='t_all' and $bus4!='all')
	{

	$sql="select id_registro, fecha_cita, registro.dni as reg_dni, especialidad, paciente.nombre_apellido as nombre_paciente,tipo_clinica.nombre as nombre_tip_cli, clinica.nombre as nom_clinica, turno_atencion,usu.nombre_apellido as nombre_operador, medico.nombre_apellido as nombre_docente_clinica
				from registro
				inner join paciente on registro.dni=paciente.dni
				inner join tipo_clinica on tipo_clinica.id_tipo_clinica=registro.tipo_clinica
				inner join clinica on clinica.id_clinica=registro.n_clinica
				inner join usuario as usu on registro.operador=usu.id_usuario
				inner join usuario as medico on registro.docente_clinica=medico.id_usuario
				where  fecha_cita like '%".$bus2."%' and n_clinica='$bus3' and registro.activo='1' order by nom_clinica ";
$result= mysqli_query($local,$sql) or die('Error');
$item=0;
while($row= mysqli_fetch_assoc($result)){
	$id=$row['id_registro'];
$item=$item+1;
	echo "<tr>"
	. "<td>$item</td>"
	. "<td>{$row['fecha_cita']}</td>"
	. "<td>{$row['nombre_paciente']}</td>"
	. "<td>{$row['reg_dni']}</td>"
	. "<td>{$row['nombre_tip_cli']}</td>"
	. "<td>{$row['nom_clinica']}</td>"
	. "<td>{$row['especialidad']}</td>"
	. "<td>{$row['nombre_operador']}</td>"
	. "<td>{$row['nombre_docente_clinica']}</td>"
	. "<td>{$row['turno_atencion']}</td>"
	. "</tr>";
}
}
	
	if( $bus3=='all' and $bus4=='t_all')
	{

	$sql="select id_registro, fecha_cita, registro.dni as reg_dni, especialidad, paciente.nombre_apellido as nombre_paciente,tipo_clinica.nombre as nombre_tip_cli, clinica.nombre as nom_clinica, turno_atencion,usu.nombre_apellido as nombre_operador, medico.nombre_apellido as nombre_docente_clinica
				from registro
				inner join paciente on registro.dni=paciente.dni
				inner join tipo_clinica on tipo_clinica.id_tipo_clinica=registro.tipo_clinica
				inner join clinica on clinica.id_clinica=registro.n_clinica
				inner join usuario as usu on registro.operador=usu.id_usuario
				inner join usuario as medico on registro.docente_clinica=medico.id_usuario
				where  fecha_cita like '%".$bus2."%' and registro.activo='1' order by nom_clinica";
$result= mysqli_query($local,$sql) or die('Error');
$item=0;
while($row= mysqli_fetch_assoc($result)){
	$id=$row['id_registro'];
$item=$item+1;
	echo "<tr>"
	. "<td>$item</td>"
	. "<td>{$row['fecha_cita']}</td>"
	. "<td>{$row['nombre_paciente']}</td>"
	. "<td>{$row['reg_dni']}</td>"
	. "<td>{$row['nombre_tip_cli']}</td>"
	. "<td>{$row['nom_clinica']}</td>"
	. "<td>{$row['especialidad']}</td>"
	. "<td>{$row['nombre_operador']}</td>"
	. "<td>{$row['nombre_docente_clinica']}</td>"
	. "<td>{$row['turno_atencion']}</td>"
	. "</tr>";
}
}

	if( $bus3=='all' and $bus4!='t_all')
	{

	$sql="select id_registro, fecha_cita, registro.dni as reg_dni, especialidad, paciente.nombre_apellido as nombre_paciente,tipo_clinica.nombre as nombre_tip_cli, clinica.nombre as nom_clinica, turno_atencion,usu.nombre_apellido as nombre_operador, medico.nombre_apellido as nombre_docente_clinica
				from registro
				inner join paciente on registro.dni=paciente.dni
				inner join tipo_clinica on tipo_clinica.id_tipo_clinica=registro.tipo_clinica
				inner join clinica on clinica.id_clinica=registro.n_clinica
				inner join usuario as usu on registro.operador=usu.id_usuario
				inner join usuario as medico on registro.docente_clinica=medico.id_usuario
				where  fecha_cita like '%".$bus2."%' and tipo_clinica='$bus4' and registro.activo='1' order by nom_clinica ";
$result= mysqli_query($local,$sql) or die('Error');
$item=0;
while($row= mysqli_fetch_assoc($result)){
	$id=$row['id_registro'];
$item=$item+1;
	echo "<tr>"
	. "<td>$item</td>"
	. "<td>{$row['fecha_cita']}</td>"
	. "<td>{$row['nombre_paciente']}</td>"
	. "<td>{$row['reg_dni']}</td>"
	. "<td>{$row['nombre_tip_cli']}</td>"
	. "<td>{$row['nom_clinica']}</td>"
	. "<td>{$row['especialidad']}</td>"
	. "<td>{$row['nombre_operador']}</td>"
	. "<td>{$row['nombre_docente_clinica']}</td>"
	. "<td>{$row['turno_atencion']}</td>"
	. "</tr>";
}
}

	}		
}
?>
</table>
<!--PRUEBA--->
<br>
 <div id='pap' class="ticket" >
<?php
		if(isset($_POST["btn1"])){
	$btn=$_POST["btn1"];
	$bus2=$_POST["date"];
	$bus3=$_POST["n_clinica_all"];
	$bus4=$_POST["tipo_clinica_all"];
	if($btn=="CONSULTAR"){
	
	if( $bus3!='t_all' and $bus4!='all')
	{
		$papeleta_total = $local -> query("select id_registro, registro.dni as reg_dni, especialidad, fecha_cita, edad, paciente.nombre_apellido as nom_paciente,
							tipo_clinica.nombre as nombre_tip_cli, clinica.nombre as nom_clinica, turno_atencion, usu.nombre_apellido as nom_usuario,
							fecha_inicio, fecha_fin, operador, docente_clinica, diagnostico, papeleta_gen
							from registro
							inner join paciente on registro.dni=paciente.dni
							inner join tipo_clinica on tipo_clinica.id_tipo_clinica=registro.tipo_clinica
							inner join clinica on clinica.id_clinica=registro.n_clinica
							inner join usuario as usu on usu.id_usuario=registro.generado_por
							where  fecha_cita like '%".$bus2."%' and n_clinica='$bus3' and registro.activo='1' order by nom_clinica"); 
            while($papeleta_total1 = $papeleta_total->fetch_array()){
				
                echo '
				<table>
				<tr>
				<td colspan="4"><div align="left"><img src="../imagenes/logo1.png" width="200px" /></div></td>
				</tr>
				<tr>
				<th colspan="4">PAPELETA DE ATENCION</th>
				</tr>
				<tr>
				<th>FECHA Y HORA INICIO:</th>
				<td>'.$papeleta_total1['fecha_cita'].'</td>
				<th>FECHA Y HORA FIN:</th>
				<td>'.$papeleta_total1['fecha_fin'].'</td>
				</tr>
				<tr>
				<th>DOCENTE CLINICA:</th>
				<td></td>
				<th>TIPO CLINICA:</th>
				<td>'.$papeleta_total1['nombre_tip_cli'].'</td>
				</tr>
				<tr>
				<th>OPERADOR:</th>
				<td></td>
				<th>N° CLINICA:</th>
				<td>'.$papeleta_total1['nom_clinica'].'</td>
				</tr>
				<tr>
				<th>PACIENTE:</th>
				<td>'.$papeleta_total1['nom_paciente'].'</td>
				<th>ESPECIALIDAD</th>
				<td>'.$papeleta_total1['especialidad'].'</td>
				</tr>
				<tr>
				<th>EDAD:</th>
				<td>'.$papeleta_total1['edad'].'</td>
				<th>TURNO ATENCIÓN:</th>
				<td>'.$papeleta_total1['turno_atencion'].'</td>
				</tr>
				<tr>
				<th>DNI:</th>
				<td>'.$papeleta_total1['reg_dni'].'</td>
				</tr>
				<tr>
				<th>DIAGNOSTICO:</th>
				<td>'.$papeleta_total1['diagnostico'].'</td>
				</tr>
				</table>
				<table border="1">
				<tr>
				<th>COD</th>
				<th>TRATAMIENTO</th>
				<th>PROCEDIMIENTO</th>
				<th>CANT.</th>
				<th>INDICACIONES</th>
				<th>PRECIO</th>
				</tr>
				<tr>
				<td>&nbsp;</td>
                <td>&nbsp;</td> 
				<td>&nbsp;</td>
				<td>&nbsp;</td> 
				<td>&nbsp;</td> 
				<td>&nbsp;</td>
			 </tr>
			 <tr>
				<td>&nbsp;</td>
                <td>&nbsp;</td> 
				<td>&nbsp;</td>
				<td>&nbsp;</td> 
				<td>&nbsp;</td> 
				<td>&nbsp;</td>
			 </tr>
			 </table>
			 PRÓXIMA CITA: ________DIAS
			 <hr>';       
            }
	
	}
	
	if( $bus3=='all' and $bus4=='t_all')
	{
		$papeleta_total = $local -> query("select id_registro, registro.dni as reg_dni, especialidad, fecha_cita, edad, paciente.nombre_apellido as nom_paciente,
							tipo_clinica.nombre as nombre_tip_cli, clinica.nombre as nom_clinica, turno_atencion, usu.nombre_apellido as nom_usuario,
							fecha_inicio, fecha_fin, operador, docente_clinica, diagnostico, papeleta_gen
							from registro
							inner join paciente on registro.dni=paciente.dni
							inner join tipo_clinica on tipo_clinica.id_tipo_clinica=registro.tipo_clinica
							inner join clinica on clinica.id_clinica=registro.n_clinica
							inner join usuario as usu on usu.id_usuario=registro.generado_por
							where  fecha_cita like '%".$bus2."%' and registro.activo='1' order by nom_clinica"); 
            while($papeleta_total1 = $papeleta_total->fetch_array()){
				
                echo '
				<table>
				<tr>
				<td colspan="4"><div align="left"><img src="../imagenes/logo1.png" width="200px" /></div></td>
				</tr>
				<tr>
				<th colspan="4">PAPELETA DE ATENCION</th>
				</tr>
				<tr>
				<th>FECHA Y HORA INICIO:</th>
				<td>'.$papeleta_total1['fecha_cita'].'</td>
				<th>FECHA Y HORA FIN:</th>
				<td>'.$papeleta_total1['fecha_fin'].'</td>
				</tr>
				<tr>
				<th>DOCENTE CLINICA:</th>
				<td></td>
				<th>TIPO CLINICA:</th>
				<td>'.$papeleta_total1['nombre_tip_cli'].'</td>
				</tr>
				<tr>
				<th>OPERADOR:</th>
				<td></td>
				<th>N° CLINICA:</th>
				<td>'.$papeleta_total1['nom_clinica'].'</td>
				</tr>
				<tr>
				<th>PACIENTE:</th>
				<td>'.$papeleta_total1['nom_paciente'].'</td>
				<th>ESPECIALIDAD</th>
				<td>'.$papeleta_total1['especialidad'].'</td>
				</tr>
				<tr>
				<th>EDAD:</th>
				<td>'.$papeleta_total1['edad'].'</td>
				<th>TURNO ATENCIÓN:</th>
				<td>'.$papeleta_total1['turno_atencion'].'</td>
				</tr>
				<tr>
				<th>DNI:</th>
				<td>'.$papeleta_total1['reg_dni'].'</td>
				</tr>
				<tr>
				<th>DIAGNOSTICO:</th>
				<td>'.$papeleta_total1['diagnostico'].'</td>
				</tr>
				</table>
				<table border="1">
				<tr>
				<th>COD</th>
				<th>TRATAMIENTO</th>
				<th>PROCEDIMIENTO</th>
				<th>CANT.</th>
				<th>INDICACIONES</th>
				<th>PRECIO</th>
				</tr>
				<tr>
				<td>&nbsp;</td>
                <td>&nbsp;</td> 
				<td>&nbsp;</td>
				<td>&nbsp;</td> 
				<td>&nbsp;</td> 
				<td>&nbsp;</td>
			 </tr>
			 <tr>
				<td>&nbsp;</td>
                <td>&nbsp;</td> 
				<td>&nbsp;</td>
				<td>&nbsp;</td> 
				<td>&nbsp;</td> 
				<td>&nbsp;</td>
			 </tr>
			 </table>
			 PRÓXIMA CITA: ________DIAS
			 <hr>';       
            }
	}

	if( $bus3=='all' and $bus4!='t_all')
	{
		$papeleta_total = $local -> query("select id_registro, registro.dni as reg_dni, especialidad, fecha_cita, edad, paciente.nombre_apellido as nom_paciente,
							tipo_clinica.nombre as nombre_tip_cli, clinica.nombre as nom_clinica, turno_atencion, usu.nombre_apellido as nom_usuario,
							fecha_inicio, fecha_fin, operador, docente_clinica, diagnostico, papeleta_gen
							from registro
							inner join paciente on registro.dni=paciente.dni
							inner join tipo_clinica on tipo_clinica.id_tipo_clinica=registro.tipo_clinica
							inner join clinica on clinica.id_clinica=registro.n_clinica
							inner join usuario as usu on usu.id_usuario=registro.generado_por
							where  fecha_cita like '%".$bus2."%' and tipo_clinica='$bus4' and registro.activo='1' order by nom_clinica "); 
            while($papeleta_total1 = $papeleta_total->fetch_array()){
				
                echo '
				<table>
				<tr>
				<td colspan="4"><div align="left"><img src="../imagenes/logo1.png" width="200px" /></div></td>
				</tr>
				<tr>
				<th colspan="4">PAPELETA DE ATENCION</th>
				</tr>
				<tr>
				<th>FECHA Y HORA INICIO:</th>
				<td>'.$papeleta_total1['fecha_cita'].'</td>
				<th>FECHA Y HORA FIN:</th>
				<td>'.$papeleta_total1['fecha_fin'].'</td>
				</tr>
				<tr>
				<th>DOCENTE CLINICA:</th>
				<td></td>
				<th>TIPO CLINICA:</th>
				<td>'.$papeleta_total1['nombre_tip_cli'].'</td>
				</tr>
				<tr>
				<th>OPERADOR:</th>
				<td></td>
				<th>N° CLINICA:</th>
				<td>'.$papeleta_total1['nom_clinica'].'</td>
				</tr>
				<tr>
				<th>PACIENTE:</th>
				<td>'.$papeleta_total1['nom_paciente'].'</td>
				<th>ESPECIALIDAD</th>
				<td>'.$papeleta_total1['especialidad'].'</td>
				</tr>
				<tr>
				<th>EDAD:</th>
				<td>'.$papeleta_total1['edad'].'</td>
				<th>TURNO ATENCIÓN:</th>
				<td>'.$papeleta_total1['turno_atencion'].'</td>
				</tr>
				<tr>
				<th>DNI:</th>
				<td>'.$papeleta_total1['reg_dni'].'</td>
				</tr>
				<tr>
				<th>DIAGNOSTICO:</th>
				<td>'.$papeleta_total1['diagnostico'].'</td>
				</tr>
				</table>
				<table border="1">
				<tr>
				<th>COD</th>
				<th>TRATAMIENTO</th>
				<th>PROCEDIMIENTO</th>
				<th>CANT.</th>
				<th>INDICACIONES</th>
				<th>PRECIO</th>
				</tr>
				<tr>
				<td>&nbsp;</td>
                <td>&nbsp;</td> 
				<td>&nbsp;</td>
				<td>&nbsp;</td> 
				<td>&nbsp;</td> 
				<td>&nbsp;</td>
			 </tr>
			 <tr>
				<td>&nbsp;</td>
                <td>&nbsp;</td> 
				<td>&nbsp;</td>
				<td>&nbsp;</td> 
				<td>&nbsp;</td> 
				<td>&nbsp;</td>
			 </tr>
			 </table>
			 PRÓXIMA CITA: ________DIAS
			 <hr>';       
            }
	}
}
}
?>

</div>
<br>
<?php include("flooter.php"); ?>  
<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
</script>
</body>
</html>