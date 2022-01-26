<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/conexion.php";

Class Reserva
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	public function insertar($id_usuario,$fecha,$hora_inicio,$hora_fin,$cantidad_horas,$monto,$descuento,$total,$detalles,$id_estado)
	{	
		if(!$id_usuario){
			$id_usuario = $_SESSION['id_usuario'];
			$id_estado = 1;
		}
		$sql="INSERT INTO reserva (id_usuario,fecha,hora_inicio,hora_fin,cantidad_horas,monto,descuento,total,id_estado) VALUES ('$id_usuario','$fecha','$hora_inicio','$hora_fin','$cantidad_horas[0]','$monto','$descuento','$total','$id_estado')";
		$id_reserva = ejecutarConsulta_retornarID($sql);

		foreach($detalles as $id_bicicleta){
			$subtotal = $cantidad_horas[1]*10;
			$sql="INSERT INTO detalle_reserva(id_reserva,id_bicicleta,precio,cantidad_horas,subtotal) VALUES ('$id_reserva',$id_bicicleta,'10',$cantidad_horas[1],'$subtotal')";
			$rspta = ejecutarConsulta($sql);
		}
		return $rspta;	
	}

	public function editar($id_reserva,$id_usuario,$fecha,$hora_inicio,$hora_fin,$cantidad_horas,$monto,$descuento,$total,$detalles,$id_estado)
	{
		$sql="UPDATE reserva SET id_usuario='$id_usuario',fecha='$fecha',hora_inicio='$hora_inicio',hora_fin='$hora_fin', cantidad_horas='$cantidad_horas[0]',monto='$monto',descuento='$descuento',total='$total',id_estado='$id_estado' WHERE id_reserva='$id_reserva'";
		$rspta = ejecutarConsulta($sql);

		$sql="DELETE FROM detalle_reserva WHERE id_reserva ='$id_reserva'";
		$rspta = ejecutarConsulta($sql);

		foreach($detalles as $id_bicicleta){
			$subtotal = $cantidad_horas[1]*10;
			$sql="INSERT INTO detalle_reserva(id_reserva,id_bicicleta,precio,cantidad_horas,subtotal) VALUES ('$id_reserva',$id_bicicleta,'10',$cantidad_horas[1],'$subtotal')";
			$rspta = ejecutarConsulta($sql);
		}
		return $rspta;
	}

	public function listar()
	{
		$sql="SELECT r.id_reserva, r.monto, r.descuento, r.total, r.fecha, r.hora_inicio, r.hora_fin, r.cantidad_horas, u.nombres, u.apepaterno, e.descripcion as 'estado', e.id_estado FROM reserva r INNER JOIN usuario u ON r.id_usuario = u.id_usuario INNER JOIN estado_reserva e ON r.id_estado = e.id_estado";
		$reservas = ejecutarConsulta($sql);	
		return $reservas;	
	}

	public function listar_mis_reservas()
	{
		$id_usuario = $_SESSION["id_usuario"];
		$sql="SELECT r.id_reserva, r.monto, r.descuento, r.total, r.fecha, r.hora_inicio, r.hora_fin, r.cantidad_horas, u.nombres, u.apepaterno, e.descripcion as 'estado', e.id_estado FROM reserva r INNER JOIN usuario u ON r.id_usuario = u.id_usuario INNER JOIN estado_reserva e ON r.id_estado = e.id_estado WHERE u.id_usuario = '$id_usuario'";
		$reservas = ejecutarConsulta($sql);	
		return $reservas;	
	}
	
	public function cliente()
	{
		$sql="SELECT * FROM usuario WHERE tipo='cliente'";
		$usuarios = ejecutarConsulta($sql);	
		return $usuarios;	
	}

	public function estado()
	{
		$sql="SELECT * FROM estado_reserva";
		$estados = ejecutarConsulta($sql);	
		return $estados;	
	}

	public function listadodetalles()
	{
		$sql="SELECT b.id_bicicleta, b.id_usuario, b.marca, b.modelo, b.color, b.imagen, b.serie, b.accesorios, b.id_estado, e.descripcion as estado FROM bicicleta b INNER JOIN estado_bicicleta e ON b.id_estado = e.id_estado";
		$estados = ejecutarConsulta($sql);	
		return $estados;	
	}

	public function listareservas($id_bicicleta)
	{
		$sql="SELECT r.hora_inicio, r.hora_fin, dr.cantidad_horas, e.id_estado, e.descripcion as estado FROM reserva r INNER JOIN detalle_reserva dr ON r.id_reserva = dr.id_reserva INNER JOIN estado_reserva e ON e.id_estado = r.id_estado WHERE e.id_estado = 1 AND dr.id_bicicleta = '$id_bicicleta' ORDER BY r.hora_inicio";
		$reservas = ejecutarConsulta($sql);	
		return $reservas;	
	}

	public function listarmarcados($id_reserva)
	{
		$sql="SELECT * FROM detalle_reserva WHERE id_reserva = '$id_reserva'";
		$marcados = ejecutarConsulta($sql);	
		return $marcados;	
	}

	public function detalle_reserva($id_reserva)
	{
		$sql="SELECT * FROM detalle_reserva dr INNER JOIN bicicleta b ON b.id_bicicleta = dr.id_bicicleta INNER JOIN estado_bicicleta e ON b.id_estado = e.id_estado WHERE dr.id_reserva = '$id_reserva'";
		$detalles = ejecutarConsulta($sql);	
		return $detalles;	
	}

	public function mostrar($id_reserva)
	{
		$sql="SELECT r.id_reserva, r.monto, r.descuento, r.total, r.fecha, r.hora_inicio, r.hora_fin, r.cantidad_horas, u.id_usuario, r.id_estado FROM reserva r INNER JOIN usuario u ON r.id_usuario = u.id_usuario WHERE id_reserva = '$id_reserva'";
		$reserva = ejecutarConsultaSimpleFila($sql);
		return $reserva;
	}

	public function imagen($id_reserva)
	{
		$sql="SELECT * FROM reserva WHERE id_reserva = '$id_reserva'";
		$x = ejecutarConsulta($sql)->fetch_object();
		$imagen = $x->imagen;
		return $imagen;
	}

	public function validar($hora_inicio, $hora_fin, $id_bicicleta, $id_reserva)
	{
		$sql="SELECT r.id_reserva, r.hora_inicio, r.hora_fin, r.id_estado, dr.cantidad_horas, e.descripcion as estado FROM reserva r INNER JOIN detalle_reserva dr ON r.id_reserva = dr.id_reserva INNER JOIN estado_reserva e ON e.id_estado = r.id_estado WHERE r.id_reserva NOT IN ('$id_reserva') AND r.id_estado = 1 and dr.id_bicicleta = '$id_bicicleta' AND (r.hora_inicio BETWEEN '$hora_inicio' AND '$hora_fin' OR r.hora_fin BETWEEN '$hora_inicio' AND '$hora_fin')";
		$validacion = ejecutarConsulta($sql);
		return $validacion;
	}

}

?>