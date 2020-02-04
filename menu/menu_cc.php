<nav class="navbar navbar-default">
  <div class="container-fluid">
  <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"></a>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
       <li><a href="pacientes_cc.php">PACIENTES</a></li>
	   <li><a href="registrar_atencion.php">REGISTRAR CITA</a></li>
	   <li><a href="central_citas.php">LISTAR CITA</a></li>
	  
		<li class="dropdown">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">REPORTE<span class="caret"></span></a>
			  <ul class="dropdown-menu">
		   <li><a href="rep_cant_citas_cc.php">CANTIDAD CITAS</a></li>
		   <li><a href="rep_num_cli_cc.php">CITAS POR CLINICA</a></li>
	<li><a href="rep_cant_atencion_ope_cc.php">OPERADORES</a></li>
	<li><a href="rep_cant_usuario_cc.php">POR USUARIO</a></li>
			  </ul>
		  </li>	 
		<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">USUARIO<span class="caret"></span></a>
          <ul class="dropdown-menu">
          <li><a href="javascript:window.open('cambiarclave.php?id=<?php echo $row_Recordset2['id_usuario'];?>','popup','width=400px,height=200px,left=180px, top=100px');">CAMBIAR CLAVE</a></li>
		</ul>
        </li>

      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>