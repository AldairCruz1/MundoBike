<?php
session_start();
require_once "../modelos/Bicicleta.php";

$bicicleta = new Bicicleta();

$id_bicicleta=isset($_POST["id_bicicleta"])? limpiarCadena($_POST["id_bicicleta"]):"";
$id_usuario=isset($_POST["id_usuario"])? limpiarCadena($_POST["id_usuario"]):"";
$modelo=isset($_POST["modelo"])? limpiarCadena($_POST["modelo"]):"";
$ganancia=isset($_POST["ganancia"])? limpiarCadena($_POST["ganancia"]):"";
$marca=isset($_POST["marca"])? limpiarCadena($_POST["marca"]):"";
$color=isset($_POST["color"])? limpiarCadena($_POST["color"]):"";
$serie=isset($_POST["serie"])? limpiarCadena($_POST["serie"]):"";
$accesorios=isset($_POST["accesorios"])? limpiarCadena($_POST["accesorios"]):"";
$id_estado=isset($_POST["id_estado"])? limpiarCadena($_POST["id_estado"]):"";

switch ($_GET["op"]){

	case 'guardaryeditar':
		$file = $_FILES["imagen"];
		if(empty($id_bicicleta)){
            if($file["type"] == "image/png" || $file["type"] == "image/jpeg"){
                $nombre = $file["name"];
				$guardado = $file["tmp_name"];
				$url = explode("\\",$guardado);
				$url = explode(".",end($url));
				$ubicacion = "../files/".$url[0]."-".$nombre;
                if(move_uploaded_file($guardado, $ubicacion)){
					$ubicacion = "../".$ubicacion;
                    $rspta = $bicicleta->insertar($id_usuario,$modelo,$ganancia,$marca,$color,$serie,$accesorios,$ubicacion,$id_estado);
					if($rspta){
						$data["condicion"] = 1;
						$data["mensaje"] = "Bicicleta registrada";
					}
					else{
						$data["condicion"] = 2;
						$data["mensaje"] = "Bicicleta no registrada";
					}
                }
                else{
                    $data["condicion"] = 2;
					$data["mensaje"] = "Error de guardar imagen";
                }
			}
			else{
				$data["condicion"] = 3;
				$data["mensaje"] = "Agregue una imagen válida";
			}
			echo json_encode($data);	
		}
		else{
			if(!$file["name"]){
				$rspta = $bicicleta->editar($id_bicicleta,$id_usuario,$modelo,$ganancia,$marca,$color,$serie,$accesorios,1,$id_estado);
				if($rspta){
						$data["condicion"] = 1;
						$data["mensaje"] = "Bicicleta actualizada";
					}
					else{
						$data["condicion"] = 2;
						$data["mensaje"] = "Bicicleta no actualizada";
					}
			}
			else{
				if($file["type"] == "image/png" || $file["type"] == "image/jpeg"){
					$nombre = $file["name"];
					$guardado = $file["tmp_name"];
					$url = explode("\\",$guardado);
					$url = explode(".",end($url));
					$ubicacion = "../files/".$url[0]."-".$nombre;
					if(move_uploaded_file($guardado, $ubicacion)){
						$imagen = $bicicleta->imagen($id_bicicleta);
						$imagen = substr($imagen, 3);
						unlink($imagen);
						$ubicacion = "../".$ubicacion;
						$rspta = $bicicleta->editar($id_bicicleta,$id_usuario,$modelo,$ganancia,$marca,$color,$serie,$accesorios,$ubicacion,$id_estado);
						if($rspta){
							$data["condicion"] = 1;
							$data["mensaje"] = "Bicicleta actualizada";
						}
						else{
							$data["condicion"] = 2;
							$data["mensaje"] = "Bicicleta no actualizada";
						}
					}
					else{
						$data["condicion"] = 2;
						$data["mensaje"] = "Bicicleta no actualizada";
					}
				}
				else{
					$data["condicion"] = 3;
					$data["mensaje"] = "Agregue una imagen válida";
				}
			}
			echo json_encode($data);	
		}

	break;

	case 'listar':
		$rspta = $bicicleta->listar();
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){

			switch ($reg->id_estado){

				case '1':
					$estado = "<span class = 'badge badge-warning'> $reg->estado </span>";
				break;

				case '2':
					$estado = "<span class = 'badge bg-cyan'> $reg->estado </span>";
				break;

				case '3':
					$estado = "<span class = 'badge badge-success'> $reg->estado </span>";
				break;

				case '4':
					$estado = "<span class = 'badge badge-primary'> $reg->estado </span>";
				break;

				case '5':
					$estado = "<span class = 'badge badge-secondary'> $reg->estado </span>";
				break;

				case '6':
					$estado = "<span class = 'badge badge-danger'> $reg->estado </span>";
				break;

				default:
					$estado = "<span class = 'badge'> $reg->estado </span>";
				break;
			}

 			$data[]=array(
				"0"=>$reg->id_bicicleta,
 				"1"=>'<div class="btn-group"> <button class="btn btn-xs btn-warning" onclick="mostrar('. $reg->id_bicicleta .')"><i class="fa fa-edit"></i>  <button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#modal-default" onclick="imagen(\''. $reg->imagen .'\')"><i class="fa fa-bicycle"></i></button> </div>',
 				"2"=>"$reg->nombres $reg->apepaterno",
 				"3"=>$reg->marca,
 				"4"=>$reg->modelo,
 				"5"=>$reg->color,
				"6"=>"$reg->ganancia %",
				"7"=>$estado
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
	break;

	case "propietario":
 
        $rspta = $bicicleta->dueño();

		//echo '<option> --- Seleccione --- </option>';

        while ($reg = $rspta->fetch_object())
            {
                echo '<option value = ' . $reg->id_usuario . '>' . $reg->nombres. ' ' . $reg->apepaterno. ' ' . $reg->apematerno.'</option>';
            }
    break;

	case "estado":
 
        $rspta = $bicicleta->estado();

		//echo '<option> --- Seleccione --- </option>';

        while ($reg = $rspta->fetch_object())
            {
                echo '<option value=' . $reg->id_estado . '>' . $reg->descripcion. '</option>';
            }
    break;

	case 'mostrar':
		$rspta = $bicicleta->mostrar($id_bicicleta);
 		echo json_encode($rspta);
	break;

}