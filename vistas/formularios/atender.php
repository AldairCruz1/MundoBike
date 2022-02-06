<?php
ob_start();
session_start();

if (!isset($_SESSION["nombres"]))
{
  header("Location: login.php");
}
else
{
require 'header.php';
if ($_SESSION['atender']==1){
    
?>

<!-- Preloader -->
<div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="../../dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
</div>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Reservas
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Reservas</li>
                </ol>
            </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="container-fluid">
        <!-- SELECT2 EXAMPLE -->
        <div id="listado" class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Lista de Reservas</h3>
                <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="registros" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th></th>
                        <th>Cliente</th>
                        <th>DNI</th>
                        <th>Hora Inicio</th>
                        <th>Hora Fin</th>
                        <th>Monto</th>
                        <th>Desc.</th>
                        <th>Total</th>
                        <th>Estado</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th></th>
                        <th>Cliente</th>
                        <th>DNI</th>
                        <th>Hora Inicio</th>
                        <th>Hora Fin</th>
                        <th>Monto</th>
                        <th>Desc.</th>
                        <th>Total</th>
                        <th>Estado</th>
                    </tr>
                    </tfoot>
                </table>
                <!-- /.row -->
            </div>
            <!-- /.card-body -->
            <!-- <div class="card-footer">
                Visit <a href="#">Select2 documentation</a> for more examples and information
                about
                the plugin.
            </div> -->
          </div>
        <!-- SELECT2 EXAMPLE -->
      </div>

    <!-- /.modal -->

    </section>
    <!-- /.content -->
</div>

<?php
}

else{
  require 'no_acceso.php';
}
    require 'footer.php';
?>
<!-------------------------------------------------------------------------------------------------->
<!-- Script Bicicleta -->
  <script src="../scripts/atender.js"></script>

<?php
}
ob_end_flush();
?>  