<?php 
	require_once("../Models/MListar_Operador.php");
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
		$ins=new queryincidencia();
		$a= $ins->MListar_Registro($valor);
		$b=count($a);
		$c= $ins->MListar_Registro($valor,$inicio,$limite);
		
		echo json_encode($c)."*".$b;
	}
		
?>