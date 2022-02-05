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
        $html = '
		<a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge">'.$count.'</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">'.$count.' Notificaciones</span>
            <div class="dropdown-divider"></div>
            <a href="reservas.php" class="dropdown-item">
              <i class="fas fa-paste mr-2"></i> '.$newReservations.' nuevas Reservas
              <span class="float-right text-muted text-sm">3 mins</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="usuarios.php" class="dropdown-item">
              <i class="fas fa-users mr-2"></i> '.$newUsers.' nuevos Usuarios
              <span class="float-right text-muted text-sm">12 hours</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="bicicletas.php" class="dropdown-item">
              <i class="fas fa-biking mr-2"></i> '.$newBikes.' nuevas Bicicletas
              <span class="float-right text-muted text-sm">2 days</span>
            </a>
            <!-- <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a> -->
          </div>';
		echo $html;
	break;
}