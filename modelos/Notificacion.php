<?php 
//Incluímos inicialmente la conexión a la base de datos
date_default_timezone_set('America/Lima');
require "../config/conexion.php";

Class Notificacion
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	public function notificaciones()
	{
		$sql="  SELECT 'users' AS tipo, COUNT(*) AS cantidad FROM usuario WHERE notificacion = '0'
                    UNION
                SELECT 'bikes' AS tipo, COUNT(*) AS cantidad FROM bicicleta WHERE notificacion = '0'
                    UNION
                SELECT 'reservations' AS tipo, COUNT(*) AS cantidad FROM reserva WHERE notificacion = '0'";
		$rspta = ejecutarConsulta($sql);
		return $rspta;
	}

}

?>