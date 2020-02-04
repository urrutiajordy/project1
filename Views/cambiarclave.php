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
<html>
<head>
 <meta charset="UTF-8">
 <link href="../css/estilo.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
<body>
<form method="POST" action="../Controllers/Ccambiarclave.php" enctype="multipart/form-data" >

             <?php
			 $USUARIO=$_GET['id'];
			 ?>
<input type="hidden" name="codigoestado" value="<?php echo $USUARIO; ?>"/>
			
			<table align="center" style="padding:5px">
			<tr>
			<td colspan="2"><strong><center>CAMBIAR CONTRASEÑA</center></strong></td>
			</tr>
			<tr>
			<td>Anterior Contraseña</td>
			<td><div class="col-xs">
			<input type="password" required name="antcla" class="form-control" />
			</div></td>
			</tr>
			<tr>
			<td>Nueva Contraseña</td>
			<td><div class="col-xs">
			<input type="password" required name="cla" class="form-control" />
			</div></td>
			</tr>
			<tr>
			<td>Confirmar Contraseña</td>
			<td><div class="col-xs">
			<input type="password" required name="concla" class="form-control" />
			</div></td>
			</tr>
			<tr>
			<td><br></td>
			</tr>
			<tr>
			<td colspan="2"><div align="center"><input type="submit" value="CAMBIAR CONTRASEÑA" name="Modificar" class="btn btn-primary"></div></td>
			</tr>
			</table>
</form>
</body>
</html>