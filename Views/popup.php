<html>
<head>
<script>
function datos(nom_paciente,edad,dni,his_cli,contrato,correo,id_paciente){
	 opener.document.form.nom_paciente.value = nom_paciente;
	 opener.document.form.edad.value = edad;
	 opener.document.form.dni.value = dni;
	 opener.document.form.his_cli.value = his_cli;
	 opener.document.form.contrato.value = contrato;
	 opener.document.form.correo.value = correo;
	 opener.document.form.id_paciente.value = id_paciente;
     localStorage.setItem('unmsm_id_pac', id_paciente);
	 window.close();
}


function Resaltar_On(GridView)
{
    if(GridView != null)
    {
    GridView.originalBgColor = GridView.style.backgroundColor;
    GridView.style.backgroundColor='#DBE7F6';
    GridView.style.cursor = 'hand'; 
    }
}

function Resaltar_Off(GridView)
{
    if(GridView != null)
    {
    GridView.style.backgroundColor = GridView.originalBgColor;    
    }
}
function Close() {    
    window.close();
}

</script>
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css"/>
	<script src="../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</head>
<body>
<?php error_reporting (0);?>
<?php 
if($_GET{"enviar"}<>""){
    if($_GET{"seleccion"}==1){
        $valor="selected";
        $qq="nombre_apellido";
    }
	if($_GET{"seleccion"}==2){
        $valor="selected";
        $qq="dni";
    }
	if($_GET{"seleccion"}==3){
        $valor="selected";
        $qq="his_clinica";
    }
	if($_GET{"seleccion"}==4){
        $valor="selected";
        $qq="contrato";
    }
}
?>
<form id="form1" name="form1" method="get" action="?">
  <label for="seleccion"></label>
  <div class="col-xs-4"><select name="seleccion" id="seleccion" class="form-control">
    <option value="1" >NOMBRE Y APELLIDO</option>
	<option value="2">DNI</option>
	<option value="3">NUM. HISTORIA</option>
	<option value="4">NUM. CONTRATO</option>
  </select>
  </div>
  <label for="q"></label>
  <div class="col-xs-6">
  <input type="text" name="q" id="q" class="form-control"/>
  </div>
  <input type="submit" class="btn btn-primary" name="enviar" id="enviar" value="BUSCAR" />
</form>
<FORM onkeypress="javascript:return WebForm_FireDefaultButton(event, &#39;ctl00_ContentPlaceMain_btnBuscar&#39;)">

<table   border="1" cellspacing="0" cellpadding="0">
  <tr bgcolor="#AEE4FF">
	<td width="20">ID</td>
    <td  width="66">DNI</td>
    <td width="240">NOMBRE Y APELLIDO</td>
    <td width="208">DIRECCIÓN</td>
	<td width="208">CORREO</td>
  </tr>

<?php
    if($_GET["q"]<>""){
    $i=0;
  
	$servidor="localhost";
        $userbase="root";
        $passbase="";
        $basedatos="unmsmfac_odontologia";
  
        // Connect to the database and checks if the user / password
        // combinaison matches any existing database entry
        $mysql_link = new mysqli($servidor,$userbase,$passbase) or die("Error en la base de datos - Comunicarse con el Administrador");
        $mysql_link->select_db($basedatos) or die ("falla!");
        $query = "SELECT id_paciente, dni,nombre_apellido,fecha_nacimiento, direccion, his_clinica, contrato, celular, correo
						FROM paciente
				   WHERE ".$qq." LIKE '%".$_GET['q']."%'  and activo='1' 
				   Order by nombre_apellido asc";
        //echo $query;
        // $r_query = mysql_query($query, $mysql_link);// or mysql_error() and die("Failed to execute_query");
        $r_query = $mysql_link->query($query) or die("No se Encontro el Dato");
        
        while ($row = $r_query->fetch_array()) {
				
			$id_cli=$row{'id_paciente'};
            $id_cli=str_replace(" ", "&nbsp;", $id_cli);
            $dni=$row{'dni'};
            $dni=str_replace(" ", "&nbsp;", $dni);
            $nombre=$row{'nombre_apellido'};
			$nombre=str_replace(" ", "&nbsp;", $nombre);
            $fecha_nacimiento=$row{'fecha_nacimiento'};
			$fecha_nacimiento=str_replace(" ", "&nbsp;", $fecha_nacimiento);
			$direccion=$row{'direccion'};
			$direccion=str_replace(" ", "&nbsp;", $direccion);
			$celular=$row{'celular'};
			$celular=str_replace(" ", "&nbsp;", $celular);
			$cumpleanos = new DateTime($fecha_nacimiento);
			$his_clinica=$row{'his_clinica'};
			$his_clinica=str_replace(" ", "&nbsp;", $his_clinica);
			$contrato=$row{'contrato'};
			$contrato=str_replace(" ", "&nbsp;", $contrato);
			$correo=$row{'correo'};
			$correo=str_replace(" ", "&nbsp;", $correo);
    $hoy = new DateTime();
    $annos = $hoy->diff($cumpleanos);
            echo "<tr OnMouseOver='Resaltar_On(this);' OnMouseOut='Resaltar_Off(this);' OnClick=datos('$nombre','$annos->y','$dni','$his_clinica','$contrato','$correo','$id_cli')><td>$id_cli</td><td>$dni</td><td>$nombre</td><td>$direccion</td><td>$correo</td></tr>";
      }
    }
?>
</table>
</FORM>
</body>
</html>
