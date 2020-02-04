	<?php 	
require_once 'conexion1.php';
class tipo{
	private $id_usuario;
    private $clave;
   
 public function getid_usuario(){ return $this->id_usuario;} 
  public function setid_usuario($id_usuario){	$this->id_usuario=$id_usuario;}
  public function getclave(){ return $this->clave;} 
  public function setclave($clave){	$this->clave=$clave;}
  


public function modificar(){
        $sql = "UPDATE usuario 
		SET clave='$this->clave'
		WHERE id_usuario='$this->id_usuario'";
		$resultado = mysqli_query(conexion::conectar(),$sql);
		return $resultado;
		

		}
}?>