<?php 
include('../php/conexion.php');

include '../Models/Mcambiarclave.php';
$tipo = new tipo();

if (isset($_REQUEST['Modificar'])){
      $tipo->setid_usuario($_REQUEST['codigoestado']);           
     $tipo->setclave($_REQUEST['cla']);
	  $id=$_POST['codigoestado'];
	  $clant=$_POST['antcla'];
	  $nue=$_POST['cla'];
	  $con=$_POST['concla'];
	  
	  $clave_antigua = $conexion->query("SELECT clave FROM usuario where id_usuario='$id'");
		while($clave_antigua1 = $clave_antigua->fetch_array()){
            $pass_ant=$clave_antigua1['clave'];
				}
			
	  if($pass_ant==$clant and $nue==$con){
        if($tipo->modificar()){  
                echo ("<script>alert('CAMBIO DE CLAVE CORRECTAMENTE');</script>");
				echo "<META HTTP-EQUIV=Refresh CONTENT=0;URL='../Views/cambiarclave.php?id=$id'>";
                }
		}
		else{
		echo '<script>alert("NO COINCIDE LAS CLAVES") </script>';
		echo "<META HTTP-EQUIV=Refresh CONTENT=0;URL='../Views/cambiarclave.php?id=$id'>";
		}
		}
		?>