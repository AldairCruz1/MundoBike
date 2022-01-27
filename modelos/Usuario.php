<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/conexion.php";

Class Usuario
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	public function listar()
	{
		$sql="SELECT * FROM usuario";
		$usuarios = ejecutarConsulta($sql);	
		return $usuarios;	
	}
	
	public function mostrar($id_usuario)
	{
		$sql="SELECT * FROM usuario WHERE id_usuario='$id_usuario'";
		$usuario = ejecutarConsultaSimpleFila($sql);
		return $usuario;
	}

	public function editar($id_usuario,$login,$password,$nombres,$apepaterno,$apematerno,$dni,$tipo,$celular,$permisos)
	{
		$sql="UPDATE usuario SET login='$login',nombres='$nombres', apepaterno='$apepaterno',apematerno='$apematerno', dni='$dni',tipo='$tipo',celular='$celular' WHERE id_usuario='$id_usuario'";
		$rspta = ejecutarConsulta($sql);

		$sql="DELETE FROM usuario_permiso WHERE id_usuario ='$id_usuario'";
		$rspta = ejecutarConsulta($sql);

		foreach($permisos as $id_permiso){
			$sql="INSERT INTO usuario_permiso (id_usuario,id_permiso) VALUES ('$id_usuario',$id_permiso)";
			$rspta = ejecutarConsulta($sql);
		}
		return $rspta;	
	}

	public function editar_perfil($id_usuario,$celular,$email,$ubicacion)
	{
		if($ubicacion == 1){
			$sql="UPDATE usuario SET celular='$celular',email='$email' WHERE id_usuario='$id_usuario'";
			$rspta = ejecutarConsulta($sql);
		}
		else{
			$sql="UPDATE usuario SET celular='$celular',email='$email', avatar='$ubicacion' WHERE id_usuario='$id_usuario'";
			$rspta = ejecutarConsulta($sql);
		}
		
		return $rspta;	
	}

	public function insertar($login,$password,$nombre,$apepaterno,$apematerno,$dni,$tipo,$celular,$permisos)
	{
		$creado_por = $_SESSION["id_usuario"];
		$sql="INSERT INTO usuario (login,password,nombres, apepaterno, apematerno, dni, tipo, celular, creado_por, estado) VALUES ('$dni','$password','$nombre','$apepaterno','$apematerno','$dni','$tipo','$celular','$creado_por','1')";
		$id_usuario = ejecutarConsulta_retornarID($sql);

		if($permisos){
			foreach($permisos as $id_permiso){
			$sql="INSERT INTO usuario_permiso(id_usuario,id_permiso) VALUES ('$id_usuario',$id_permiso)";
			$rspta = ejecutarConsulta($sql);
			}
		}
		else{
			$rspta = $id_usuario;
		}
		return $rspta;	
	}

	public function desactivar($id_usuario)
	{
		$sql="UPDATE usuario SET estado='0' WHERE id_usuario='$id_usuario'";
		$estado = ejecutarConsulta($sql);
		return $estado;
	}

	public function validarDNI($dni)
	{
		$sql="SELECT * FROM usuario WHERE dni='$dni'";
		$rspta = ejecutarConsultaSimpleFila($sql);
		$dni = $rspta["dni"];
		return $dni;
	}

	public function activar($id_usuario)
	{
		$sql="UPDATE usuario SET estado='1' WHERE id_usuario='$id_usuario'";
		$estado = ejecutarConsulta($sql);
		return $estado;
	}

	public function verificar($login,$password)
    {
		//$password=md5($password);
    	$sql="SELECT * FROM usuario WHERE login='$login' AND password='$password' AND estado='1'"; 
		$datoUsuario = ejecutarConsulta($sql);
		return $datoUsuario;
    }

	public function permisos($id_usuario)
	{
		$sql="SELECT p.id_permiso, p.nombre AS permiso, p.descripcion, p.url, p.id_categoria, cp.nombre AS categoria, p.icono AS iconop, cp.icono AS iconoc FROM usuario_permiso up INNER JOIN permiso p ON up.id_permiso = p.id_permiso INNER JOIN categoria_permiso cp ON cp.id_categoria = p.id_categoria WHERE up.id_usuario = '$id_usuario'";
		$permisos = ejecutarConsulta($sql);
		return $permisos;
	}

	public function listarpermisos()
	{
		$sql="SELECT p.id_permiso, p.nombre AS permiso, p.descripcion, p.url, p.id_categoria, cp.nombre AS categoria, p.icono AS iconop, cp.icono AS iconoc FROM usuario_permiso up RIGHT JOIN permiso p ON up.id_permiso = p.id_permiso INNER JOIN categoria_permiso cp ON cp.id_categoria = p.id_categoria";
		$permisos = ejecutarConsulta($sql);
		return $permisos;
	}

	public function imagen($id_usuario)
	{
		$sql="SELECT * FROM usuario WHERE id_usuario = '$id_usuario'";
		$x = ejecutarConsulta($sql)->fetch_object();
		$imagen = $x->avatar;
		return $imagen;
	}

	public function validarPassword($id_usuario)
	{
		$sql="SELECT * FROM usuario WHERE id_usuario = '$id_usuario'";
		$x = ejecutarConsulta($sql)->fetch_object();
		$password = $x->password;
		return $password;
	}

	public function actualizarPassword($id_usuario, $contraseña_nueva)
	{
		$sql="UPDATE usuario SET password='$contraseña_nueva' WHERE id_usuario='$id_usuario'";
		$rspta = ejecutarConsulta($sql);
		return $rspta;
	}

}

?>