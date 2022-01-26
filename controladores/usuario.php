<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
session_start();
require_once "../modelos/Usuario.php";

$usuario = new Usuario();

$id_usuario=isset($_POST["id_usuario"])? limpiarCadena($_POST["id_usuario"]):"";
$login=isset($_POST["login"])? limpiarCadena($_POST["login"]):"";
$password=isset($_POST["password"])? limpiarCadena($_POST["password"]):"";
$nombres=isset($_POST["nombres"])? limpiarCadena($_POST["nombres"]):"";
$apepaterno=isset($_POST["apepaterno"])? limpiarCadena($_POST["apepaterno"]):"";
$apematerno=isset($_POST["apematerno"])? limpiarCadena($_POST["apematerno"]):"";
$dni=isset($_POST["dni"])? limpiarCadena($_POST["dni"]):"";
$tipo=isset($_POST["tipo"])? limpiarCadena($_POST["tipo"]):"";
$celular=isset($_POST["celular"])? limpiarCadena($_POST["celular"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
$permisos=$_POST["permisos"];



switch ($_GET["op"]){

	case 'listar':
		$rspta = $usuario->listar();
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->id_usuario,
				"1"=>($reg->estado)?'<div class="btn-group"><button class="btn btn-xs btn-sm btn-warning" onclick="mostrar('.$reg->id_usuario.')"><i class="fa fa-edit"></i></button>'.
					'<button class="btn btn-sm btn-xs btn-danger" onclick="desactivar('.$reg->id_usuario.')"><i class="fa fa-user"></i></button>':
					'<div class="btn-group"><button class="btn btn-xs btn-sm btn-warning" onclick="mostrar('.$reg->id_usuario.')"><i class="fa fa-edit"></i></button>'.
					'<button class="btn btn-xs btn-success" onclick="activar('.$reg->id_usuario.')"><i class="fa fa-user"></i></button></div>',
 				"2"=>"$reg->nombres $reg->apepaterno $reg->apematerno",
 				"3"=>$reg->celular,
 				"4"=>$reg->dni,
 				"5"=>$reg->tipo,
				"6"=>($reg->estado)?'<span class="badge badge-success">Activado</span>':
					'<span class="badge badge-danger">Desactivado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
	break;

	case 'mostrar':
		$rspta=$usuario->mostrar($id_usuario);
 		echo json_encode($rspta);
	break;

	case 'presentar':
		$id_usuario = $_SESSION["id_usuario"];
		$rspta=$usuario->mostrar($id_usuario);
 		echo json_encode($rspta);
	break;

	case 'guardaryeditar':

		if($dni){
            if(strlen($dni)==8){

				$password=md5($dni);
					if (empty($id_usuario)){

						$rspta=$usuario->validarDNI($dni);
						if($rspta == $dni){
							$data["condicion"] = 2;
							$data["mensaje"] = "El DNI:".$dni." ya existe";
						}
						else{
							//$datos = file_get_contents("https://api.reniec.cloud/dni/".$dni);
							$datos = file_get_contents("https://api.apis.net.pe/v1/dni?numero=".$dni);
							if($datos){
								$rspta = $usuario->insertar($login,$password,$nombres,$apepaterno,$apematerno,$dni,$tipo,$celular,$permisos);
								if($rspta){
									$data["condicion"] = 1;
									$data["mensaje"] = "Usuario registrado";
								}
								else{
									$data["condicion"] = 2;
									$data["mensaje"] = "Usuario no registrado";
								}
								
							}
							else{
								$data["condicion"] = 2;
								$data["mensaje"] = "El DNI no es válido"; 
							}
						}
					}
					else {
						$rspta = $usuario->editar($id_usuario,$login,$password,$nombres,$apepaterno,$apematerno,$dni,$tipo,$celular,$permisos);
						if($rspta){
							$data["condicion"] = 1;
							$data["mensaje"] = "Usuario actualizado";
						}
						else{
							$data["condicion"] = 2;
							$data["mensaje"] = "Usuario no actualizado";
						}	
					}
            }
            else{
				$data["condicion"] = 2;
				$data["mensaje"] = "El DNI debe tener 8 caracteres";  
                
            }
        }
        else{
			$data["condicion"] = 2;
			$data["mensaje"] = "El DNI debe tener 8 caracteres"; 
		}
		//$data["mensaje"] = $rspta;
		echo json_encode($data);

	break;

	case 'editar': 
		$file = $_FILES["imagen"];
        if($_SESSION["id_usuario"] == $id_usuario){
			if(!$file["name"]){
				$rspta = $usuario->editar_perfil($id_usuario,$celular,$email,1);
				if($rspta){
					$data["condicion"] = 1;
					$data["mensaje"] = "Datos actualizados";
				}
				else{
					$data["condicion"] = 2;
					$data["mensaje"] = "Datos no actualizados";
				}
			}
			else{
				if($file["type"] == "image/png" || $file["type"] == "image/jpeg"){
					$nombre = $file["name"];
					$guardado = $file["tmp_name"];
					$url = explode("\\",$guardado);
					$url = explode(".",end($url));
					$ubicacion = "../files/avatar/".$url[0]."-".$nombre;
					if(move_uploaded_file($guardado, $ubicacion)){
						$imagen = $usuario->imagen($id_usuario);
						$imagen = substr($imagen, 3);
						unlink($imagen);
						$ubicacion = "../".$ubicacion;
						$rspta = $usuario->editar_perfil($id_usuario,$celular,$email,$ubicacion);
						if($rspta){
							$data["condicion"] = 1;
							$data["mensaje"] = "Datos actualizados";
							$_SESSION["avatar"] = $ubicacion;
						}
						else{
							$data["condicion"] = 2;
							$data["mensaje"] = "Datos no actualizados";
						}
					}
					else{
						$data["condicion"] = 2;
						$data["mensaje"] = "Datos no actualizados";
					}
				}
				else{
					$data["condicion"] = 3;
					$data["mensaje"] = "Agregue una imagen válida";
				}
			}
		}
		else{
			$data["condicion"] = 2;
			$data["mensaje"] = "Usuario no identificado";
		}
		
		echo json_encode($data);
	break;

	case 'desactivar':
		$rspta=$usuario->desactivar($id_usuario);
		if($rspta){
			$data["condicion"] = 1;
			$data["mensaje"] = "Usuario Desactivado";
		}
		else{
			$data["condicion"] = 2;
			$data["mensaje"] = "Usuario no se pudo desactivar";
		}
		echo json_encode($data);	
	break;

	case 'activar':
		$rspta=$usuario->activar($id_usuario);
		if($rspta){
			$data["condicion"] = 1;
			$data["mensaje"] = "Usuario Activado";
		}
		else{
			$data["condicion"] = 2;
			$data["mensaje"] = "Usuario no se pudo activar";
		}
		echo json_encode($data);	
	break;

	case 'verificar':
		$login=$_POST['login'];
		$password=$_POST['password'];
		$password=md5($password);

		$rspta=$usuario->verificar($login, $password);
		$fetch=$rspta->fetch_object();

		if (isset($fetch))
	    {
			//VARIABLES DE SESION
	        $_SESSION['id_usuario']=$fetch->id_usuario;
			$_SESSION['nombres']=$fetch->nombres;
			$_SESSION['apepaterno']=$fetch->apepaterno;
			$_SESSION['apematerno']=$fetch->apematerno;
			$_SESSION['login']=$fetch->login;
			$_SESSION['password']=$fetch->password;
			$_SESSION['tipo']=$fetch->tipo;
			if($fetch->avatar == ""){
				$_SESSION['avatar'] = "../../files/avatar/user.jpg";
			}
			else{
				$_SESSION['avatar'] = $fetch->avatar;
			}
			
		}
		
		if($_SESSION['tipo']=="administrador")
		{
			$_SESSION['Usuarios']=1;
			$_SESSION['Alumnos']=1;
			$_SESSION['Cursos']=1;
		}

		$permisos=$usuario->permisos($fetch->id_usuario);

		while ($permiso = $permisos->fetch_object()){
					$lista_permisos[$permiso->categoria]["icono"] = $permiso->iconoc;
					$lista_permisos[$permiso->categoria]["detalle"][$permiso->permiso]["nombre"] = $permiso->permiso;
					$lista_permisos[$permiso->categoria]["detalle"][$permiso->permiso]["url"] = $permiso->url;
					$lista_permisos[$permiso->categoria]["detalle"][$permiso->permiso]["icono"] = $permiso->iconop;
					$_SESSION[$permiso->permiso]=1;
			}

		$_SESSION['Permisos'] = $lista_permisos;
	

		echo json_encode($fetch);
		
	break;

	case "checkpermisos":

		$html = '';

		if($_SESSION["tipo"] == "administrador"){

			$listado_permisos = $usuario->listarpermisos();
			$marcados  = $usuario->permisos($id_usuario);
			$valores=array();
			

			//almacenar los detalles de la reserva
			while ($det = $marcados->fetch_object()) {
				array_push($valores, $det->id_permiso);
			}

			while ($permiso = $listado_permisos->fetch_object()){
					$lista_permisos[$permiso->categoria][$permiso->id_permiso]["nombre"] = $permiso->permiso;
					$lista_permisos[$permiso->categoria][$permiso->id_permiso]["id"] = $permiso->id_permiso;
			}

			$html .= '<label>Permisos</label>';
			$html .= '<div class="row">';
			
			foreach ($lista_permisos as $key => $row) {

				$html .= '<div class="col-md-6">
							<div class="form-group mx-2">	
							<h7>'.$key.' ▼</h7>';
							foreach ($row as $key => $reg) {
								$sw = in_array($reg["id"], $valores)?'checked':'';
								$html .='<div class="custom-control custom-checkbox">		
											<input class="custom-control-input custom-control-input-success custom-control-input-outline" type="checkbox" id="customCheckbox'.$reg["id"].'" name="permisos[]" value ="'.$reg["id"].'"'.$sw.'>
											<label for="customCheckbox'.$reg["id"].'" class="custom-control-label">'.$reg["nombre"].'</label>
										</div>';
							}
				$html .=	'</div>
						</div>';
			}
			$html .= '</div>';

		}

		echo $html;
		//echo var_dump($lista_permisos);
    break;

	case 'validarDNI':
        
        if($dni){
            if(strlen($dni)==8){
                $rspta=$usuario->validarDNI($dni);
                if($rspta == $dni){
					$obj["mensaje"] = "DNI ya registrado"; 
					$obj["color"] = "red";
                }
                else{
					//$datos = file_get_contents("https://api.reniec.cloud/dni/".$dni);
					$datos = file_get_contents("https://api.apis.net.pe/v1/dni?numero=".$dni);
					if($datos){
						$obj["mensaje"] = "Disponible";
						$obj["color"] = "green";
						$obj["datos"] = $datos;
					}
					else{
						$obj["mensaje"] = "No Disponible"; 
						$obj["color"] = "red"; 
						$obj["datos"] = $datos;
					}
                }
            }
            else{
				$obj["mensaje"] = "Minimo 8 caracteres";  
				$obj["color"] = "red";
                
            }
        }
        else{
            $obj["mensaje"] = "Minimo 8 caracteres";
			$obj["color"] = "red";
		}
		//$obj["mensaje"] = $rspta;
		echo json_encode($obj);
        
    break;

	case 'salir': 
        session_unset();
        session_destroy();
        header("Location: ../index.php");
	break;

}