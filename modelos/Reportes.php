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

    

    public function getdatos()
	{
		$sql="SELECT 
        (SELECT COUNT(*) FROM usuario) as 'allUsers',
        (SELECT COUNT(*) FROM bicicleta) as 'allBikes',
        (SELECT COUNT(*) FROM reserva r WHERE DATE(r.hora_inicio) = DATE(NOW())) as 'allReservations',
        (SELECT CONCAT('S/ ',ifNULL(SUM(MONTO),0)) FROM reserva r WHERE DATE(r.hora_inicio) = DATE(NOW()) AND r.id_estado in (2,4)) as 'totalReservations'";
		$rspta = ejecutarConsultaSimpleFila($sql);
        return $rspta;
	}

    public function ventasMeses()
    {
        $sql="SELECT date_format(hora_inicio,'%Y %M') AS fecha, sum(monto) as total from reserva GROUP by month(hora_inicio) ORDER by hora_inicio ASC LIMIT 0,12";
        $rspta = ejecutarConsulta($sql);
        return $rspta;
    }

    public function reservasTotalMeses()
    {
        $sql="SELECT b.marca as marca, COUNT(*) as cantidad FROM reserva r INNER JOIN usuario u ON r.id_usuario=u.id_usuario INNER JOIN estado_reserva er ON r.id_estado=er.id_estado INNER JOIN detalle_reserva dr ON dr.id_reserva=r.id_reserva INNER JOIN bicicleta b ON b.id_bicicleta=dr.id_bicicleta WHERE r.id_estado IN (1,2,4) AND YEAR(Fecha) =YEAR(NOW()) and MONTH(Fecha) =MONTH(NOW()) GROUP BY b.marca";
        $rspta = ejecutarConsulta($sql);
        return $rspta;
    }

    public function compareteBicicle()
    {
        $sql="SELECT date_format(fecha,'%Y %M') AS fecha,b.id_bicicleta, sum(monto) as total from reserva r INNER JOIN detalle_reserva dr ON dr.id_reserva=r.id_reserva INNER JOIN bicicleta b ON b.id_bicicleta=dr.id_bicicleta WHERE r.id_estado IN (1,2,4) GROUP by month(fecha) ORDER by fecha ASC LIMIT 0,12";
        $rspta = ejecutarConsulta($sql);
        return $rspta;
    }
    
    public function compareteBicicle1($id_bicicleta,$id_bicicleta2)
    {
        $sql="Call compare_bikes1('$id_bicicleta','$id_bicicleta2')";
        $rspta = ejecutarConsulta($sql);
        return $rspta;
    }

    public function nombre()
	{
		$sql="SELECT id_bicicleta, CONCAT('BK',LPAD((id_bicicleta),3,'0')) as nombre FROM bicicleta";
		$marca = ejecutarConsulta($sql);	
		return $marca;	
	}
}

?>