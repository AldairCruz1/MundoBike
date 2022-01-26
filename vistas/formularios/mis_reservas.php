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
if ($_SESSION['tipo']=='cliente' || $_SESSION['tipo']=='administrador' || $_SESSION['tipo']=='asistente'){

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
                <li class="breadcrumb-item active">Mis Reservas</li>
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
                <h3 class="card-title">Mis Reservas <button id="btn-agregar" type="button" class="btn btn-success btn-sm"> Nueva Reserva</button></h3>
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
                        <th>Reserva</th>
                        <th></th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Inicio</th>
                        <th>Fin</th>
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
                        <th>Reserva</th>
                        <th></th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Inicio</th>
                        <th>Fin</th>
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
          </div>
        <!-- SELECT2 EXAMPLE -->
          <div id="form" class="card card-default">
            <form name="formulario" id="formulario" method="POST">
                <div class="card-header">
                    <h3 class="card-title">Formulario de Reservas</h3>
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
                    <div class="row">
                      <div class="col-md-6">
                        <h6 id="titulo-reserva"></h6>
                      </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <!-- /.form-group -->
                            
                                <input type="hidden" id="id_reserva" name="id_reserva" class="form-control" style="width: 100%;" readonly>
                                <input type="hidden" id="id_usuario" name="id_usuario" class="form-control" style="width: 100%;" value="<?=$_SESSION["id_usuario"]?>" readonly required>
                            
                            <!-- /.form-group -->

                            <!-- /.form-group -->
                                <input type="hidden" id="fecha" placeholder="yy/mm/dd hh:mm:ss" name="fecha" class="form-control" style="width: 100%;" value="<?php echo date("Y-m-d");?>" step="7" required readonly>
                            <!-- /.form-group -->
                            
                            <!-- /.form-group -->
                            <div class="form-group">
                                <label>Inicio</label>
                                <input type="datetime-local" id="hora_inicio" placeholder="yy/mm/dd hh:mm:ss" name="hora_inicio" class="form-control rango" style="width: 100%;" required>
                            </div>
                            <!-- /.form-group -->

                            <!-- /.form-group -->
                            <div class="form-group">
                                <label>Fin</label>
                                <input type="datetime-local" id="hora_fin" placeholder="yy/mm/dd hh:mm:ss" name="hora_fin" class="form-control rango"
                                style="width: 100%;" required>
                            </div>
                            <!-- /.form-group -->                
                        </div>
                        <!-- /.col -->

                        <div class="col-md-6">
                            <!-- /.form-group -->
                            <div class="form-group">
                                <label>Monto</label>
                                <div class="input-group mb-3">
                                    <input id="monto" placeholder="Ingrese el monto..." name="monto" type="number" class="form-control" readonly required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">S/.</span>
                                    </div>
                                </div>
                            </div>
                            <!-- /.form-group -->

                            <!-- /.form-group -->
              
                                <input id="descuento" placeholder="Ingrese el descuento..." name="descuento" type="hidden" class="form-control" required>                      

                            <!-- /.form-group -->

                            <!-- /.form-group -->
                            <div class="form-group">
                                <label>Total</label>
                                <div class="input-group mb-3">
                                <input id="total" placeholder="Total" name="total" type="number" class="form-control" readonly required>
                                <div class="input-group-append">
                                    <span class="input-group-text">S/.</span>
                                </div>
                                </div>
                            </div>
                            <!-- /.form-group -->

                            <!-- /.form-group -->
              
                                <input id="id_estado" placeholder="Total" name="id_estado" type="hidden" class="form-control" value = "1" readonly required>
                           
                            <!-- /.form-group -->
                        </div>

                        <!-- /.col -->
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" id="btnAgregarBicicleta">
                            </div>
                        </div>
                    </div>
                    <div id="listado-check" class="form-group">
                            <!-- <div class="custom-control custom-checkbox">
                              <input class="custom-control-input custom-control-input-success custom-control-input-outline" type="checkbox" id="customCheckbox1" name="detalles[]" value ="Bicicleta1" checked>
                              <label for="customCheckbox1" class="custom-control-label">Bicicleta 1</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                              <input class="custom-control-input custom-control-input-success custom-control-input-outline" type="checkbox" id="customCheckbox2" name="detalles[]" value ="Bicicleta2" checked>
                              <label for="customCheckbox2" class="custom-control-label">Bicicleta 2</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                              <input class="custom-control-input custom-control-input-success custom-control-input-outline" type="checkbox" id="customCheckbox3" name="detalles[]" value ="Bicicleta3" checked>
                              <label for="customCheckbox3" class="custom-control-label">Bicicleta 3</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                              <input class="custom-control-input custom-control-input-success custom-control-input-outline" type="checkbox" id="customCheckbox4" name="detalles[]" value ="Bicicleta4" checked>
                              <label for="customCheckbox4" class="custom-control-label">Bicicleta 4</label>
                            </div> -->
                          </div>

                    <!-- /.row -->
                    

                    <div id="listado-agregados"class="row">
                    </div>
                    <!-- /.row -->
                    <br>
                    <div class="form-row" align="center">
                        <div class="form-group col-md-12" id="form-buttons">
                            <button class="btn btn-sm bg-primary text-white" type="submit" id="btnGuardar">
                                <i class="fa fa-save"></i>
                                Guardar
                            </button>
                            <button class="btn btn-sm btn-danger" id="btn-cancelar" type="button">
                                <i class="fa fa-arrow-circle-left"></i>
                                Cancelar
                            </button>
                        </div>
                    </div>
                </div>
            </form>
          </div>
        <!-- /.card -->

        <!-- /.row -->
        <div id="detalles" class="card card-solid">
          <div class="card-body pb-0">
            <div id="listado-detalles" class="row">
            </div>
          </div>
          <!-- /.card-body -->
        </div>
      </div>

    
    <!-- /.container-fluid -->
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title">Reservas</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div id="modalimg" class="modal-body" align="center">
            
            </div>
            <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
        <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- /.container-fluid -->
    <div class="modal fade" id="modal-default2">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title">Reservas Existentes</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div id="modalimg2" class="modal-body" align="center">
            
            </div>
            <div class="modal-footer justify-content-between">
            <button id="cerrarmodal" type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            <button id="modificarhoras"type="button" class="btn btn-primary">Modificar Hora Inicio y Fin</button>
            </div>
        </div>
        <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
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
  <script src="../scripts/mi_reserva.js"></script>

<?php
}
ob_end_flush();
?>  