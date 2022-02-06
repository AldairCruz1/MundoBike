<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
session_start();
require_once "../modelos/Atender.php";

$atender = new Atender();

$id_reserva=isset($_POST["id_reserva"])? limpiarCadena($_POST["id_reserva"]):"";
$id_usuario=isset($_POST["id_usuario"])? limpiarCadena($_POST["id_usuario"]):"";
$id_bicicleta=isset($_POST["id_bicicleta"])? limpiarCadena($_POST["id_bicicleta"]):"";
$fecha=isset($_POST["fecha"])? limpiarCadena($_POST["fecha"]):"";
$hora_inicio=isset($_POST["hora_inicio"])? limpiarCadena($_POST["hora_inicio"]):"";
$hora_fin=isset($_POST["hora_fin"])? limpiarCadena($_POST["hora_fin"]):"";
$monto=isset($_POST["monto"])? limpiarCadena($_POST["monto"]):"";
$descuento=isset($_POST["descuento"])? limpiarCadena($_POST["descuento"]):"";
$total=isset($_POST["total"])? limpiarCadena($_POST["total"]):"";
$id_estado=isset($_POST["id_estado"])? limpiarCadena($_POST["id_estado"]):"";
$detalles=$_POST["detalles"];
$id_bicicletas=$_POST["id_bicicletas"];

switch ($_GET["op"]){

	case 'guardaryeditar2':
		$datetime1 = new DateTime($hora_inicio);
		$datetime2 = new DateTime($hora_fin);
		$interval = $datetime1->diff($datetime2);
		$cantidad_horas = $interval->format('%H');
		$cantidad_horas = $cantidad_horas*10;
		$x = 0;
		foreach($detalles as $selected){
			$x = $x + $cantidad_horas;
		}
		$data["condicion"] = 1;
		$data["mensaje"] = $x;
 		echo json_encode($data);
	break;

	case 'guardaryeditar':
		$hora_inicio = str_replace("T"," ",$hora_inicio);
		$hora_fin = str_replace("T"," ",$hora_fin);
		$datetime1 = new DateTime($hora_inicio);
		$datetime2 = new DateTime($hora_fin);
		$interval = $datetime1->diff($datetime2);
		$cantidad_horas[0] = $interval->format('%H:%I');
		$cantidad_horas[1] = $interval->format('%H');
		if(empty($id_reserva)){
			$rspta = $reserva->insertar($id_usuario,$fecha,$hora_inicio,$hora_fin,$cantidad_horas,$monto,$descuento,$total,$detalles,$id_estado);
			if($rspta){
				$data["condicion"] = 1;
				$data["mensaje"] = "Reserva registrada";
			}
			else{
				$data["condicion"] = 2;
				$data["mensaje"] = "Reserva no registrada";
			}
			echo json_encode($data);	
		}
		else{
			$rspta = $reserva->editar($id_reserva,$id_usuario,$fecha,$hora_inicio,$hora_fin,$cantidad_horas,$monto,$descuento,$total,$detalles,$id_estado);
			if($rspta){
				$data["condicion"] = 1;
				$data["mensaje"] = "Reserva actualizada";
			}
			else{
				$data["condicion"] = 2;
				$data["mensaje"] = "Reserva no actualizada";
			}		
			echo json_encode($data);	
		}

	break;

	case 'listar':
		$rspta = $atender->listar();
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){

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

			if($reg->id_reserva < 10){
			$numero_reserva = '000'.$reg->id_reserva;
			}
			else if ($reg->id_reserva < 100) {
			$numero_reserva = '00'.$reg->id_reserva;
			}
			else if ($reg->id_reserva < 1000) {
			$numero_reserva = '0'.$reg->id_reserva;
			}
			else{
			$numero_reserva = $reg->id_reserva;
			}

 			$data[]=array(
				"0"=>"N° $numero_reserva",
 				"1"=>'<div class="btn-group"> <button class="btn btn-xs btn-warning" onclick="atender('. $reg->id_reserva .')"><i class="fa fa-edit"></i></div>',
 				"2"=>"$reg->nombres $reg->apepaterno $reg->apematerno",
 				"3"=>$reg->dni,
 				"4"=>date_format(date_create($reg->hora_inicio), 'd/m/Y H:i:s'),
 				"5"=>date_format(date_create($reg->hora_fin), 'd/m/Y H:i:s'),
				"6"=>"S/. $reg->monto",
				"7"=>"S/. $reg->descuento",
				"8"=>"S/. $reg->total",
				"9"=>$estado
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
	break;

	case 'listar-mis-reservas':
		$rspta = $reserva->listar_mis_reservas();
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){

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

			if($reg->id_reserva < 10){
				$id_reserva = "000".$reg->id_reserva;
			} elseif($reg->id_reserva < 100){
				$id_reserva = "00".$reg->id_reserva;
			} elseif($reg->id_reserva < 1000){
				$id_reserva = "0".$reg->id_reserva;
			}else{
				$id_reserva = $reg->id_reserva;
			}

 			$data[]=array(
				"0"=>"N° $id_reserva",
 				"1"=>'<div class="btn-group"> <button class="btn btn-xs btn-warning" onclick="mostrar('. $reg->id_reserva .')"><i class="fa fa-edit"></i></div>',
 				"2"=>"$reg->nombres $reg->apepaterno",
 				"3"=>date_format(date_create($reg->fecha), 'd/m/Y'),
 				"4"=>date_format(date_create($reg->hora_inicio), 'd/m/Y H:i:s'),
 				"5"=>date_format(date_create($reg->hora_fin), 'd/m/Y H:i:s'),
				"6"=>"S/. $reg->monto",
				"7"=>"S/. $reg->descuento",
				"8"=>"S/. $reg->total",
				"9"=>$estado
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
	break;

	case "cliente":
 
        $rspta = $reserva->cliente();

		//echo '<option> --- Seleccione --- </option>';

        while ($reg = $rspta->fetch_object())
            {
                echo '<option value = ' . $reg->id_usuario . '>' . $reg->nombres. ' ' . $reg->apepaterno. ' ' . $reg->apematerno.'</option>';
            }
    break;

	case "estado":
 
        $rspta = $reserva->estado();

		//echo '<option> --- Seleccione --- </option>';

        while ($reg = $rspta->fetch_object())
            {
                echo '<option value=' . $reg->id_estado . '>' . $reg->descripcion. '</option>';
            }
    break;

	case "detalle-reserva":
 
        $rspta = $reserva->detalle_reserva($id_reserva);

		//echo '<option> --- Seleccione --- </option>';

		$html = '';

        while ($reg = $rspta->fetch_object())
            {
				if($reg->id_bicicleta < 10){
				$numero_bicicleta = '00'.$reg->id_bicicleta;
				}
				else if ($reg->id_bicicleta < 100) {
				$numero_bicicleta = '0'.$reg->id_bicicleta;
				}
				else{
				$numero_bicicleta = $reg->id_bicicleta;
				}
				
                $html .= '<div id="'.$reg->id_bicicleta.'-contend" class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
              				<div class="card bg-light d-flex flex-fill">
                				<div class="card-header text-muted border-bottom-0">BK
                  					'.$numero_bicicleta.'
                				</div>
                				<div class="card-body pt-0">
                  					<div class="row">
                    					<div class="col-7">
                      						<h2 class="lead"><b>'.$reg->descripcion.'</b></h2>
                      						<p class="text-muted text-sm"><b>Caracteristicas: </b> '.$reg->marca.' / '.$reg->modelo.' / '.$reg->color.'  / '.$reg->serie.'</p>
                    					</div>
                    					<div class="col-5 text-center">
                      						<img src="'.$reg->imagen.'" class="img-circle img-fluid">
                    					</div>
                  					</div>
                				</div>
                				<div class="card-footer">
                  					<div id="buttons-'.$reg->id_bicicleta.'"class="text-right">
                    					<button id="delete'.$reg->id_bicicleta.'" type="button" class="btn btn-sm bg-danger" onclick="quitar('.$reg->id_bicicleta.')">
                      						<i class="fas fa-retweet "></i> Cambiar 
                    					</button>
                    					<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-default" onclick="reservas('.$reg->id_bicicleta.')">
                      						<i class="fas fa-info-circle"></i> Ver Reservas
                    					</button>
                  					</div>
                				</div>
              				</div>
            			</div>';
				$data = $reg->id_bicicleta;
            }
		
		$response["html"] = $html;
		$response["data"] = $data;

		echo json_encode($response);
    break;

	case "listareservas":
 
        $rspta = $reserva->listareservas($id_bicicleta);

		$html = '<table class="table-sm" style="border: solid 1px; text-align:center; width: 100%;">
					<thead>
						<tr class="bg-dark">
							<th>Hora Inicio</th>
							<th>Hora Fin</th>
							<th>Horas</th>
							<th>Estado</th>
						</tr>
					</thead>
					</tbody>';

		//echo '<option> --- Seleccione --- </option>';

        while ($reg = $rspta->fetch_object())
            {

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

				default:
					$estado = "<span class = 'badge'> $reg->estado </span>";
				break;
			}
                $html.= '<tr style="border: solid 1px;">
							<td>'.date_format(date_create($reg->hora_inicio), 'd/m/Y H:i').'</td>
							<td>'.date_format(date_create($reg->hora_fin), 'd/m/Y H:i').'</td>
							<td>'.$reg->cantidad_horas.'</td>
							<td>'.$estado.'</td>
						</tr>';
            }
		
		$html .= '	</tbody>
				</table>';
		
		echo $html;
    break;

	case "listadodetalles":
 
        $rspta = $reserva->listadodetalles();
		$marcados  = $reserva->listarmarcados($id_reserva);
		$valores=array();
		$html = '';

		//almacenar los detalles de la reserva
		while ($det = $marcados->fetch_object()) {
			array_push($valores, $det->id_bicicleta);
		}

        while ($reg = $rspta->fetch_object()){

			if($reg->id_bicicleta < 10){
			$numero_bicicleta = 'BK00'.$reg->id_bicicleta;
			}
			else if ($reg->id_bicicleta < 100) {
			$numero_bicicleta = '0'.$reg->id_bicicleta;
			}
			else{
			$numero_bicicleta = $reg->id_bicicleta;
			}

			if( in_array($reg->id_estado, ["3","4","5"])){

				$sw = in_array($reg->id_bicicleta, $valores)?'<button id="delete'.$reg->id_bicicleta.'" type="button" class="btn btn-sm bg-danger" onclick="quitar('.$reg->id_bicicleta.')">
                      						<i class="fas fa-trash"></i> Quitar 
                    					</button>':'<button id="add'.$reg->id_bicicleta.'" type="button" class="btn btn-sm bg-teal" onclick="agregar('.$reg->id_bicicleta.')">
                      						<i class="fas fa-check-circle"></i> Seleccionar 
                    					</button>';

                $html .= '<div id="'.$reg->id_bicicleta.'-contend" class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
              				<div class="card bg-light d-flex flex-fill">
                				<div class="card-header text-muted border-bottom-0">BK
                  					'.$numero_bicicleta.'
                				</div>
                				<div class="card-body pt-0">
                  					<div class="row">
                    					<div class="col-7">
                      						<h2 class="lead"><b>'.$reg->estado.'</b></h2>
                      						<p class="text-muted text-sm"><b>Caracteristicas: </b> '.$reg->marca.' / '.$reg->modelo.' / '.$reg->color.'  / '.$reg->serie.'</p>
                    					</div>
                    					<div class="col-5 text-center">
                      						<img src="'.$reg->imagen.'" class="img-circle img-fluid">
                    					</div>
                  					</div>
                				</div>
                				<div class="card-footer">
                  					<div id="buttons-'.$reg->id_bicicleta.'"class="text-right">
                    					'.$sw.'
                    					<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-default" onclick="reservas('.$reg->id_bicicleta.')">
                      						<i class="fas fa-info-circle"></i> Ver Reservas
                    					</button>
                  					</div>
                				</div>
              				</div>
            			</div>';
			}
        }
		echo $html;
    break;

	case "listadodetalles2":
		
		$tipo_usuario = $_SESSION["tipo"];
        $rspta = $reserva->listadodetalles();
		$marcados  = $reserva->listarmarcados($id_reserva);
		$valores=array();
		$add = '';
		$free = '';

		//almacenar los detalles de la reserva
		while ($det = $marcados->fetch_object()) {
			array_push($valores, $det->id_bicicleta);
		}

        while ($reg = $rspta->fetch_object()){
			if($reg->id_bicicleta < 10){
			$numero_bicicleta = '00'.$reg->id_bicicleta;
			}
			else if ($reg->id_bicicleta < 100) {
			$numero_bicicleta = '0'.$reg->id_bicicleta;
			}
			else{
			$numero_bicicleta = $reg->id_bicicleta;
			}

			if( in_array($reg->id_estado, ["3","4","5"])){

				$sw = in_array($reg->id_bicicleta, $valores)?'<button id="delete'.$reg->id_bicicleta.'" type="button" class="btn btn-sm bg-danger" onclick="quitar('.$reg->id_bicicleta.')">
                      						<i class="fas fa-trash"></i> Quitar 
                    					</button>':'<button id="add'.$reg->id_bicicleta.'" type="button" class="btn btn-sm bg-teal" onclick="agregar('.$reg->id_bicicleta.')">
                      						<i class="fas fa-check-circle"></i> Seleccionar 
                    					</button>';

                $data = '<div id="'.$reg->id_bicicleta.'-contend" class="bpf col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
              				<div class="card bg-light d-flex flex-fill">
                				<div class="card-header text-muted border-bottom-0">BK'.$numero_bicicleta.'
                				</div>
                				<div class="card-body pt-0">
                  					<div class="row">
                    					<div class="col-7">
                      						<h2 class="lead"><b>'.$reg->estado.'</b></h2>
                      						<p class="text-muted text-sm"><b>Caracteristicas: </b> '.$reg->marca.' / '.$reg->modelo.' / '.$reg->color.'  / '.$reg->serie.'</p>
                    					</div>
                    					<div class="col-5 text-center">
                      						<img src="'.$reg->imagen.'" class="img-circle img-fluid">
                    					</div>
                  					</div>
                				</div>
                				<div class="card-footer">
                  					<div id="buttons-'.$reg->id_bicicleta.'"class="text-right">
                    					'.$sw.'
                    					<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-default" onclick="reservas('.$reg->id_bicicleta.')">
                      						<i class="fas fa-info-circle"></i> Ver Reservas
                    					</button>
                  					</div>
                				</div>
              				</div>
            			</div>';
				if(in_array($reg->id_bicicleta, $valores)){
					$add .= $data;
				}
				else{
					$free .= $data;
				}
			}
        }
		$html["add"] = $add;
		$html["free"] = $free;
		echo json_encode($html);
    break;

	case "listadodetalles3":
		
		$tipo_usuario = $_SESSION["tipo"];
        $rspta = $reserva->listadodetalles();
		$marcados  = $reserva->listarmarcados($id_reserva);
		$valores=array();
		$add = '';
		$free = '';

		//almacenar los detalles de la reserva
		while ($det = $marcados->fetch_object()) {
			array_push($valores, $det->id_bicicleta);
		}

        while ($reg = $rspta->fetch_object()){

			if( in_array($reg->id_estado, ["3","4","5"])){

				$sw = in_array($reg->id_bicicleta, $valores)?'<button id="delete'.$reg->id_bicicleta.'" type="button" class="btn btn-sm bg-danger" onclick="quitar('.$reg->id_bicicleta.')">
                      						<i class="fas fa-retweet"></i> Cambiar 
                    					</button>':'<button id="add'.$reg->id_bicicleta.'" type="button" class="btn btn-sm bg-teal" onclick="agregar('.$reg->id_bicicleta.')">
                      						<i class="fas fa-check-circle"></i> Seleccionar 
                    					</button>';

                $data = '<div id="'.$reg->id_bicicleta.'-contend" class="bpf col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
              				<div class="card bg-light d-flex flex-fill">
                				<div class="card-header text-muted border-bottom-0">
                  					'.$reg->id_bicicleta.'
                				</div>
                				<div class="card-body pt-0">
                  					<div class="row">
                    					<div class="col-7">
                      						<h2 class="lead"><b>'.$reg->estado.'</b></h2>
                      						<p class="text-muted text-sm"><b>Caracteristicas: </b> '.$reg->marca.' / '.$reg->modelo.' / '.$reg->color.'  / '.$reg->serie.'</p>
                    					</div>
                    					<div class="col-5 text-center">
                      						<img src="'.$reg->imagen.'" class="img-circle img-fluid">
                    					</div>
                  					</div>
                				</div>
                				<div class="card-footer">
                  					<div id="buttons-'.$reg->id_bicicleta.'"class="text-right">
                    					'.$sw.'
                    					<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-default" onclick="reservas('.$reg->id_bicicleta.')">
                      						<i class="fas fa-info-circle"></i> Ver Reservas
                    					</button>
                  					</div>
                				</div>
              				</div>
            			</div>';
				if(in_array($reg->id_bicicleta, $valores)){
					$add .= $data;
				}
				else{
					$free .= $data;
				}
			}
        }
		$html["add"] = $add;
		$html["free"] = $free;
		echo json_encode($html);
    break;

	case "checkdetalles":
 
        $listado_detalles = $reserva->listadodetalles();
		$marcados  = $reserva->listarmarcados($id_reserva);
		$valores=array();
		$html = '';

		//almacenar los detalles de la reserva
		while ($det = $marcados->fetch_object()) {
			array_push($valores, $det->id_bicicleta);
		}
		
		//mostramos la lista de bicicletas las reservas
		while ($reg=$listado_detalles->fetch_object()) {
			$sw = in_array($reg->id_bicicleta, $valores)?'checked':'';
			$html .= '	<div class="custom-control custom-checkbox">
							<input class="custom-control-input custom-control-input-success custom-control-input-outline" type="checkbox" id="customCheckbox'.$reg->id_bicicleta.'" name="detalles[]" value ="'.$reg->id_bicicleta.'"'.$sw.'>
							<label for="customCheckbox'.$reg->id_bicicleta.'" class="custom-control-label">Bicicleta '.$reg->id_bicicleta.'</label>
						</div>';
		}
		echo $html;
    break;

	case 'mostrar':
		$rspta = $reserva->mostrar($id_reserva);
 		echo json_encode($rspta);
	break;

	case 'validar':
		$hora_inicio = str_replace("T"," ",$hora_inicio);
		$hora_fin = str_replace("T"," ",$hora_fin);
		//var_dump($hora_inicio);
		//die();
		// $hora_inicio = new DateTime($hora_inicio);
		// $hora_fin = new DateTime($hora_fin);
		$rspta = $reserva->validar($hora_inicio, $hora_fin, $id_bicicleta,$id_reserva);
		//var_dump($rspta);
		//echo "<br>".mysqli_num_rows($rspta);
		$contador = 0;
 		//echo json_encode($rspta);
		$html = '<table class="table-sm" style="border: solid 1px; text-align:center; width: 100%;">
					<thead>
						<tr class="bg-dark">
							<th>Hora Inicio</th>
							<th>Hora Fin</th>
							<th>Horas</th>
							<th>Estado</th>
						</tr>
					</thead>
					</tbody>';

		//echo '<option> --- Seleccione --- </option>';

        while ($reg = $rspta->fetch_object())
            {

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

				default:
					$estado = "<span class = 'badge'> $reg->estado </span>";
				break;
			}
                $html.= '<tr style="border: solid 1px;">
							<td>'.date_format(date_create($reg->hora_inicio), 'd/m/Y H:i').'</td>
							<td>'.date_format(date_create($reg->hora_fin), 'd/m/Y H:i').'</td>
							<td>'.$reg->cantidad_horas.'</td>
							<td>'.$estado.'</td>
						</tr>';
				$contador++;
            }
		
		$html .= '	</tbody>
				</table>';
		
		$response["condicion"] = $contador;
		$response["html"] = $html;
		
		echo json_encode($response);
	break;

	case 'validar2':
		$hora_inicio = str_replace("T"," ",$hora_inicio);
		$hora_fin = str_replace("T"," ",$hora_fin);
		// $hora_inicio = new DateTime($hora_inicio);
		// $hora_fin = new DateTime($hora_fin);
		$contador = 0;
		foreach($id_bicicletas as $id_bicicleta){
			if($contador > 0){
				$contador = 1;
				break;
			}
			$bicicleta_reservada = $id_bicicleta;

			$html = '';
			$rspta = $reserva->validar($hora_inicio, $hora_fin, $id_bicicleta,$id_reserva);

			$html .= '<table class="table-sm" style="border: solid 1px; text-align:center; width: 100%;">
					<thead>
						<tr class="bg-dark">
							<th>Hora Inicio</th>
							<th>Hora Fin</th>
							<th>Horas</th>
							<th>Estado</th>
						</tr>
					</thead>
					</tbody>';

			//echo '<option> --- Seleccione --- </option>';

			while ($reg = $rspta->fetch_object())
			{

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

					default:
						$estado = "<span class = 'badge'> $reg->estado </span>";
					break;
				}
					$html.= '<tr style="border: solid 1px;">
								<td>'.date_format(date_create($reg->hora_inicio), 'd/m/Y H:i').'</td>
								<td>'.date_format(date_create($reg->hora_fin), 'd/m/Y H:i').'</td>
								<td>'.$reg->cantidad_horas.'</td>
								<td>'.$estado.'</td>
							</tr>';
					$contador++;
			}
			
			$html .= '	</tbody>
					</table>';

		}	
		
		$response["condicion"] = $contador;
		$response["html"] = $html;
		$response["bicicleta"] = $bicicleta_reservada;
		
		echo json_encode($response);
	break;

    case 'atender':
		
		$rspta = $atender->atender($id_reserva);
        $contador = 0;
        $html = '';
        while ($reg = $rspta->fetch_object())
		{
            if($contador < 1){
                $html .= '
                <table class="table table-condensed table-bordered table-hover" style="margin:auto">
                    <tr>
                        <td class="p-1" colspan="2">Cliente: '.$reg->nombres.'</td>
                    </tr>
                    <tr>
                        <td class="p-1">DNI: '.$reg->dni.'</td>
                        <td class="p-1">Fecha : 20/01/2022</td>
                    </tr>
                    <tr>
                        <td class="p-1" colspan="2">Inicio: '.$reg->hora_inicio.'</td>
                    </tr>
                    <tr>
                        <td class="p-1" colspan="2">Fin: '.$reg->hora_fin.'</td>
                    </tr>';
                $response["reserva"] = $reg->numero_reserva;
            }

            $html .= '
                    <tr>
                        <td class="">Bicicleta: '.$reg->numero_bicicleta.'</td>
                        <td class=""><img class="img-fluid" height="80" width="80" src="'.$reg->imagen.'"></td>
                    </tr>';

            $id_estado = $reg->id_estado;
            $contador++;
        }

        $html .= '</table>';

        if($id_estado == 1){
            $button = "Iniciar Reserva";
        } elseif($id_estado == 4){
            $button = "Terminar Reserva";
        }

        $response["html"] = $html;
        $response["button"] = $button;
        $response["estado"] = $id_estado;

        echo json_encode($response);


    break;

    case 'efectuar':
		
		$rspta = $atender->efectuar($id_reserva,$id_estado);

        if($rspta){
            $condicion = 1;
        }
        else{
            $condicion = 1;
        }

        echo $condicion;

    break;



}