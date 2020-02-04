<?php
error_reporting(E_ALL ^ E_DEPRECATED);
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_local = "localhost";
$database_local = "unmsmfac_odontologia";
$username_local = "root";
$password_local = "";
$local = new mysqli($hostname_local, $username_local, $password_local) or trigger_error($local->error,E_USER_ERROR); 
date_default_timezone_set('America/Lima');
mysqli_set_charset( $local, 'utf8');
?>