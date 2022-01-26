<?php
require_once "../modelos/Reportes.php";

$reportes = new Reportes();

switch ($_GET["op"]){

    case 'reportesfecha':

        $fecha_inicio=$_REQUEST["fecha_inicio"];
        $fecha_fin=$_REQUEST["fecha_fin"];

        $rspta=$reportes->reportesfecha($fecha_inicio,$fecha_fin);

        $data = Array();

        while ($reg = $rspta->fetch_object()){

            switch ($reg->id_estado){
				case '1':
					$estado = "<span class = 'badge badge-success'> $reg->estado </span>";
				break;

				case '2':
					$estado = "<span class = 'badge badge-secondary'> $reg->estado </span>";
				break;

				case '3':
					$estado = "<span class = 'badge badge-danger'> $reg->estado </span>";
				break;

				case '4':
					$estado = "<span class = 'badge bg-cyan'> $reg->estado </span>";
				break;

				default:
					$estado = "<span class = 'badge'> $reg->estado </span>";
				break;
			}

            $data[] = array(
                "0"=>$reg->id_reserva,
                "1"=>$reg->fecha,
                "2"=>$reg->usuario,
                "3"=>$reg->hora_inicio,
                "4"=>$reg->hora_fin,
                "5"=>$reg->cantidad_horas,
                "6"=>$reg->monto,
                "7"=>$estado,
            );
        }

        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);

    break;

    case 'reportesfechacliente':

        $fecha_inicio=$_REQUEST["fecha_inicio"];
        $fecha_fin=$_REQUEST["fecha_fin"];
        $id_cliente=$_REQUEST["id_cliente"];

        $rspta=$reportes->reportesfechacliente($fecha_inicio,$fecha_fin,$id_cliente);

        $data = Array();

        while ($reg = $rspta->fetch_object()){

            switch ($reg->id_estado){
				case '1':
					$estado = "<span class = 'badge badge-success'> $reg->estado </span>";
				break;

				case '2':
					$estado = "<span class = 'badge badge-secondary'> $reg->estado </span>";
				break;

				case '3':
					$estado = "<span class = 'badge badge-danger'> $reg->estado </span>";
				break;

				case '4':
					$estado = "<span class = 'badge bg-cyan'> $reg->estado </span>";
				break;

				default:
					$estado = "<span class = 'badge'> $reg->estado </span>";
				break;
			}

            $data[] = array(
                "0"=>$reg->id_reserva,
                "1"=>$reg->fecha,
                "2"=>$reg->usuario,
                "3"=>$reg->hora_inicio,
                "4"=>$reg->hora_fin,
                "5"=>$reg->cantidad_horas,
                "6"=>$reg->monto,
                "7"=>$estado,
            );
        }

        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);

    break;

    

}

?>