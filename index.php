<?php require_once('Connections/local.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

 // $theValue = function_exists("mysqli_real_escape_string") ? $mysqli->real_escape_string($theValue) : $mysqli->escape_string($theValue);

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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['usuario'])) {
  $loginUsername=$_POST['usuario'];
  $password=$_POST['clave'];
  $MM_fldUserAuthorization = "id_perfil";
  $MM_redirectLoginSuccess = "Views/admin.php";
  $MM_redirectLoginFailed = "index.php";
  $MM_redirecttoReferrer = false;
  $local->select_db($database_local);
  	
  $LoginRS__query=sprintf("SELECT usuario, clave, id_perfil FROM usuario WHERE usuario=%s AND clave=%s AND activo='1'",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = $local->query($LoginRS__query) or die($mysqli->error);
  $loginFoundUser = $LoginRS->num_rows;
  if ($loginFoundUser) {
    
    $LoginRS->data_seek(0); $loginStrGroup  = $LoginRS->fetch_array()['id_perfil'];
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
   echo ("<script>alert('CLAVE O USUARIO INCORRECTO');</script>");
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="shortcut icon" type="image/x-icon" href="imagenes/favicon.ico"/>
<link href="css/login.css" rel="stylesheet" type="text/css">
<script src="css/login.js" type="text/javascript"></script>
<title>UNMSM</title>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<form id="form1" name="form1" method="POST" action="<?php echo $loginFormAction; ?>">

<div class="login-page">
<div class="form">
<img src="imagenes/logo.png"  width="150" height="150" />
<p>    <form class="login-form">
<span id="sprytextfield1"><input type="text" name="usuario" placeholder="username"/><span class="textfieldRequiredMsg">Ingrese el usuario.</span></span>
<span id="sprytextfield2"><input type="password" name="clave" placeholder="password"/><span class="textfieldRequiredMsg">Ingrese la Clave.</span></span>
      <button type="submit" name="button" id="button" >login</button>
    </form>
  </div>
</div>
</form>
  <!-- end .container -->
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
</script>
</body>
</html>