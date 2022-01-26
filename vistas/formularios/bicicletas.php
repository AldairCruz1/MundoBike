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
if ($_SESSION['bicicletas']==1){

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
          <h1>Bicicletas</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Bicicletas</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

      <!-- INICIO CARD LISTADO -->
      <div id="listado" class="card card-default">
        <!-- inicio Card Header -->
        <div class="card-header">
          <h3 class="card-title">Lista de Bicicletas 
            <button id="btn-agregar" type="button" class="btn btn-success btn-sm" onclick="mostrarform(true)"> 
              <i class="fas fa-bicycle"></i> Agregar
            </button>
          </h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <!-- fin Card Header -->

        <!-- inicio Card Body -->
        <div class="card-body">
          <table id="registros" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>ID</th>
                <th></th>
                <th>Dueño</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Color</th>
                <th>Ganancia</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
              <tr>
                <th>ID</th>
                <th></th>
                <th>Dueño</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Color</th>
                <th>Ganancia</th>
                <th>Estado</th>
              </tr>
            </tfoot>
          </table>
        </div>
        <!-- fin Card Body -->
      </div>
      <!-- FIN CARD LISTADO -->

      <!-- INICIO CARD FORMULARIO -->
      <div id="form"class="card card-default">
        <form name="formulario" id="formulario" method="POST">
          <!-- inicio Card Header -->
          <div class="card-header">
            <h3 class="card-title">Formulario de Bicicleta</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <!-- fin Card Header -->

          <!-- inicio Card Body -->
          <div class="card-body">
            <!-- inicio Fila --> 
            <div class="row">
              <div class="col-12 col-sm-6">
                <div class="form-group">
                  <label>Propietario</label>
                  <input type="hidden" id="id_bicicleta" name="id_bicicleta" class="form-control" style="width: 100%;">
                  <select id="id_usuario" name="id_usuario" class="form-control select2" style="width: 100%;" required>

                  </select>
                </div>
              </div>   
              <div class="col-12 col-sm-6">
                <div class="form-group">
                  <label>Marca</label>
                  <input id="marca" placeholder="Escriba la marca..." name="marca" class="form-control" style="width: 100%;" required>
                </div>
              </div>    
            </div>
            <!-- fin Fila --> 

            <!-- inicio Fila --> 
            <div class="row">
              <div class="col-12 col-sm-6">
                <div class="form-group">
                  <label>Modelo</label>
                  <input id="modelo" placeholder="Escriba el modelo..." name="modelo" class="form-control" style="width: 100%;" required>
                </div>         
              </div>   
              <div class="col-12 col-sm-6">
                <div class="form-group">
                  <label>Color</label>
                  <input id="color" placeholder="Escriba el color..." name="color" class="form-control" style="width: 100%;" required>
                </div> 
              </div>    
            </div>
            <!-- fin Fila --> 

            <!-- inicio Fila --> 
            <div class="row">
              <div class="col-12 col-sm-6">
                <div class="form-group">
                  <label>Ganancia</label>
                  <div class="input-group mb-3">
                    <input id="ganancia" placeholder="Escriba la ganancia..." name="ganancia" type="number" class="form-control" min="0" max="100" required>
                    <div class="input-group-append">
                      <span class="input-group-text">%</span>
                    </div>
                  </div>
                </div>
              </div>   
              <div class="col-12 col-sm-6">
                <div class="form-group">
                  <label>Estado</label>
                  <select id="id_estado" name="id_estado" class="form-control select2" style="width: 100%;" required>
                  
                  </select>
                </div>
              </div>    
            </div>
            <!-- fin Fila -->

            <!-- inicio Fila --> 
            <div class="row">
              <div class="col-12 col-sm-6">
                <div class="form-group">
                  <label for="exampleInputFile">Imagen</label>
                  <div class="input-group">
                    <div id="input-img" class="custom-file">
                      <input name="imagen" type="file" class="custom-file-input" id="imagen">
                      <label class="custom-file-label" for="exampleInputFile">Agregue una foto</label>
                    </div>
                  </div>
                </div> 
              </div>   
              <div class="col-12 col-sm-6">
                <div class="form-group">
                  <label>N° Serie</label>
                  <input id="serie" placeholder="Escriba el n° de serie..." name="serie" class="form-control" style="width: 100%;" required>
                </div> 
              </div>    
            </div>
            <!-- fin Fila -->
           
            <!-- inicio Fila --> 
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Accesorios Adicionales</label>
                  <textarea id="accesorios" placeholder="Mencione los accesorios adicionales..." name="accesorios" class="form-control" style="width: 100%;" required></textarea>
                </div>      
              </div>
            </div>
            <!-- inicio Fila --> 

            <!-- inicio Botones -->
            <div class="form-row" align="center">
              <div class="form-group col-md-12" id="form-buttons">
                <button class="btn btn-sm bg-primary text-white" type="submit" id="btnGuardar">
                  <i class="fa fa-save"></i> Guardar
                </button>
                <button class="btn btn-sm btn-danger" id="btn-cancelar" type="button">
                  <i class="fa fa-arrow-circle-left"></i> Cancelar
                </button>
              </div>
            </div>
            <!-- fin Botones -->

          </div>
          <!-- Fin Card Body -->
        </form>
      </div>
      <!-- INICIO CARD FORMULARIO -->
    </div>

    <!-- inicio Modal -->
    <div class="modal fade" id="modal-default">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Imagen</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div id="modalimg" class="modal-body" align="center">
            
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
          </div>
        </div>
      </div>
    </div>
    <!-- fin Modal -->
  </section>
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
<script src="../scripts/bicicleta.js"></script>

<?php
}
ob_end_flush();
?>  