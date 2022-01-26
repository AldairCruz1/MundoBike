<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/conexion.php";

Class Bicicleta
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	public function insertar($id_usuario,$modelo,$ganancia,$marca,$color,$serie,$accesorios,$ubicacion,$id_estado)
	{
		$creado_por = $_SESSION["id_usuario"];
		$sql="INSERT INTO bicicleta (id_usuario,modelo,ganancia,marca,color,serie,accesorios,creado_por,imagen,id_estado) VALUES ('$id_usuario','$modelo','$ganancia','$marca','$color','$serie','$accesorios','$creado_by','$ubicacion','$id_estado')";
		$rspta = ejecutarConsulta($sql);
		return $rspta;	
	}

	public function editar($id_bicicleta,$id_usuario,$modelo,$ganancia,$marca,$color,$serie,$accesorios,$ubicacion,$id_estado)
	{
		if($ubicacion == 1){
			$sql="UPDATE bicicleta SET id_usuario='$id_usuario',modelo='$modelo',ganancia='$ganancia',marca='$marca', color='$color', serie='$serie', accesorios='$accesorios', id_estado='$id_estado' WHERE id_bicicleta='$id_bicicleta'";
			$rspta = ejecutarConsulta($sql);
			return $rspta;	
		}
		else{
			$sql="UPDATE bicicleta SET id_usuario='$id_usuario',modelo='$modelo',ganancia='$ganancia',marca='$marca', color='$color', serie='$serie', accesorios='$accesorios',imagen='$ubicacion',id_estado='$id_estado' WHERE id_bicicleta='$id_bicicleta'";
			$rspta = ejecutarConsulta($sql);
			return $rspta;
		}
	}

	public function listar()
	{
		//$sql="SELECT * FROM bicicleta";
		$sql="SELECT b.id_bicicleta, u.nombres, u.apepaterno, b.marca, b.modelo, b.color, b.ganancia, e.descripcion as 'estado', e.id_estado, b.imagen FROM bicicleta b INNER JOIN usuario u ON b.id_usuario = u.id_usuario INNER JOIN estado_bicicleta e ON b.id_estado = e.id_estado";
		$bicicletas = ejecutarConsulta($sql);	
		return $bicicletas;	
	}
	
	public function dueño()
	{
		$sql="SELECT * FROM usuario WHERE tipo IN ('proveedor','administrador') AND estado = 1";
		$usuarios = ejecutarConsulta($sql);	
		return $usuarios;	
	}

	public function estado()
	{
		$sql="SELECT * FROM estado_bicicleta";
		$estados = ejecutarConsulta($sql);	
		return $estados;	
	}

	public function mostrar($id_bicicleta)
	{
		$sql="SELECT * FROM bicicleta WHERE id_bicicleta = '$id_bicicleta'";
		$bicicleta = ejecutarConsultaSimpleFila($sql);
		return $bicicleta;
	}

	public function imagen($id_bicicleta)
	{
		$sql="SELECT * FROM bicicleta WHERE id_bicicleta = '$id_bicicleta'";
		$x = ejecutarConsulta($sql)->fetch_object();
		$imagen = $x->imagen;
		return $imagen;
	}

}

?>