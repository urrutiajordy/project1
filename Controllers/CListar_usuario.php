<?php 
	require_once("../Models/MListar_usuario.php");
	$boton= $_POST['boton'];
	if($boton==='buscar')
	{
		$inicio = 0;
        $limite = 40;
        if (isset($_POST['pagina'])) {
        	$pagina=$_POST['pagina'];
            $inicio = ($pagina - 1) * $limite;
        }
        $valor=$_POST['valor'];
		$ins=new querylistar_paciente();
		$a= $ins->lista_paciente($valor);
		$b=count($a);
		$c= $ins->lista_paciente($valor,$inicio,$limite);
		
		echo json_encode($c)."*".$b;
	}
		
?>