<?php
require "../config/conexion.php";

Class Reportes
{
    //Implementamos nuestro constructor
	public function __construct()
	{

	}

    public function reportesfecha($fecha_inicio,$fecha_fin)
    {
        $sql = "SELECT DATE(r.fecha) as fecha,u.nombres as usuario,r.id_reserva,r.hora_inicio,r.hora_fin,r.cantidad_horas, r.monto,er.descripcion as 'estado', er.id_estado FROM reserva r INNER JOIN usuario u ON r.id_usuario=u.id_usuario INNER JOIN estado_reserva er ON r.id_estado=er.id_estado WHERE DATE(r.fecha)>='$fecha_inicio' AND DATE(r.fecha)<='$fecha_fin'";
		return ejecutarConsulta($sql);
    }

    public function reportesfechacliente($fecha_inicio,$fecha_fin,$id_usuario)
    {
        $sql = "SELECT DATE(r.fecha) as fecha,u.nombres as usuario,r.id_reserva,r.hora_inicio,r.hora_fin,r.cantidad_horas, r.monto,er.descripcion as 'estado', er.id_estado FROM reserva r INNER JOIN usuario u ON r.id_usuario=u.id_usuario INNER JOIN estado_reserva er ON r.id_estado=er.id_estado WHERE DATE(r.fecha)>='$fecha_inicio' AND DATE(r.fecha)<='$fecha_fin' AND r.id_usuario='$id_usuario'";
		return ejecutarConsulta($sql);
    }

    
}

?>