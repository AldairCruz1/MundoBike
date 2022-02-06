<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
session_start();
require_once "../modelos/Notificacion.php";

$notificacion = new Notificacion();

switch ($_GET["op"]){

	case 'notificaciones': 
		$notificaciones = $notificacion->notificaciones();
		$count = 0;
    $html = "";
		while ($row = $notificaciones->fetch_object()){
			$count = $count + $row->cantidad;
            if($row->tipo == 'users'){
                $newUsers = $row->cantidad;
            } if($row->tipo == 'bikes'){
                $newBikes = $row->cantidad;
            } if($row->tipo == 'reservations'){
                $newReservations = $row->cantidad;
            }
		}

    if($count == 0){
          $html .= '
		      <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">Sin Notificaciones Nuevas</span>
          </div>';
    }
    else{
      if($count == 1){
        $countMessage = "Notificacion";
      }
      else{
        $countMessage = "Notificaciones";
      }

      $html .= '
		      <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge">'.$count.'</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">'.$count.' '.$countMessage.'</span>';

      if($newReservations > 0){
        if($newReservations == 1){
          $newReservationsMessage = "nueva Reserva";
        }
        else{
          $newReservationsMessage = "nuevas Reservas";
        }
        $html .= '
            <div class="dropdown-divider"></div>
            <a href="reservas.php" class="dropdown-item">
              <i class="fas fa-paste mr-2"></i> '.$newReservations.' '.$newReservationsMessage.'
              <span class="float-right text-muted text-sm">Ver</span>
            </a>';
      }

      if($newUsers > 0){
        if($newUsers == 1){
          $newUsersMessage = "nuevo Usuario";
        }
        else{
          $newUsersMessage = "nuevos Usuarios";
        }
        $html .= '
            <div class="dropdown-divider"></div>
            <a href="usuarios.php" class="dropdown-item">
              <i class="fas fa-users mr-2"></i> '.$newUsers.' '.$newUsersMessage.'
              <span class="float-right text-muted text-sm">Ver</span>
            </a>';
      }

      if($newBikes > 0){
        if($newBikes == 1){
          $newBikesMessage = "nueva Bicicleta";
        }
        else{
          $newBikesMessage = "nuevas Bicicletas";
        }
        $html .= '
            <div class="dropdown-divider"></div>
            <a href="bicicletas.php" class="dropdown-item">
              <i class="fas fa-biking mr-2"></i> '.$newBikes.' '.$newBikesMessage.'
              <span class="float-right text-muted text-sm">Ver</span>
            </a>';
      }

      $html .= '
            <!-- <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a> -->
          </div>';
    }
		echo $html;
	break;
}