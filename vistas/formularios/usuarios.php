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
if ($_SESSION['usuarios']==1){

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
          <h1>Usuarios</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Usuarios</li>
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
          <h3 class="card-title">Lista de Usuarios
            <button class="btn btn-sm btn-success" id="btnagregar" onclick="mostrarform(true)">
              <i class="fa fa-user-plus"></i> Agregar
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
                <th>Nombre y Apellidos</th>
                <th>Celular</th>
                <th>DNI</th>
                <th>Tipo</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
              <tr>
                <th>ID</th>
                <th></th>
                <th>Nombre y Apellidos</th>
                <th>Celular</th>
                <th>DNI</th>
                <th>Tipo</th>
                <th>Estado</th>
              </tr>
            </tfoot>
          </table>
        </div>
        <!-- fin Card Body --> 
      </div>
      <!-- FIN CARD LISTADO -->

      <!-- INICIO CARD FORMULARIO -->
      <div id="form" class="card card-default">
        <form name="formulario" id="formulario" method="POST">
          <!-- inicio Card Header --> 
          <div class="card-header" id="edicion">
            <h3 class="card-title">Formulario de Usuario</h3>
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
            <!-- <div class="row">
              <div class="col-12 col-sm-6">
                <div class="form-group">
                  <label>Login</label> -->
                  <input type="hidden" class="form-control" name="login" id="login" maxlength="50" placeholder="Login" required>
                <!--</div>
              </div>   
              <div class="col-12 col-sm-6">
                <div class="form-group">
                  <label>Password</label>
                  <input type="password" class="form-control" name="password" id="password" maxlength="50"
                                  placeholder="Password" required>
                </div>
              </div>    
            </div> -->
            <!-- fin Fila --> 

            <!-- inicio Fila --> 
            <div class="row">
              <div class="col-12 col-sm-6">
                <div class="form-group">
                  <label>DNI</label><span id="validacion"></span>
                  <input type="text" class="form-control" name="dni" id="dni" maxlength="50" placeholder="DNI" required>
                </div>
              </div> 

              <div class="col-12 col-sm-6">
                <div class="form-group">
                  <label>Nombres</label>
                  <input type="hidden" name="id_usuario" id="id_usuario">
                  <input type="text" class="form-control" name="nombres" id="nombres" maxlength="50" placeholder="Nombres" required>
                </div>
              </div>        
            </div>
            <!-- fin Fila --> 

            <!-- inicio Fila --> 
            <div class="row">
              <div class="col-12 col-sm-6">
                <div class="form-group">
                  <label>Apellido Paterno</label>
                  <input type="text" class="form-control" name="apepaterno" id="apepaterno" maxlength="50" placeholder="Apellido Paterno" required>
                </div>              
              </div>

              <div class="col-12 col-sm-6">
                <div class="form-group">
                  <label>Apellido Materno</label>
                  <input type="text" class="form-control" name="apematerno" id="apematerno" maxlength="50" placeholder="Apellido Materno" required>
                </div>
              </div>      
            </div>
            <!-- fin Fila --> 

            <!-- inicio Fila --> 
            <div class="row">
              <div class="col-12 col-sm-6">
                <div class="form-group">
                  <label>Tipo</label>
                  <select id="tipo" name="tipo" class="form-control select2" required>
                    <option value="administrador">Administrador</option>
                    <option value="asistente">Asistente</option>
                    <option value="cliente">Cliente</option>
                    <option value="proveedor">Proveedor</option>
                  </select>
                </div>
              </div>   
              <div class="col-12 col-sm-6">
                <div class="form-group">
                  <label>Celular</label>
                  <input type="text" class="form-control" name="celular" id="celular" maxlength="50" placeholder="Celular" required>
                </div>
              </div>    
            </div>
            <!-- fin Fila --> 
                      
            <!-- inicio Permisos --> 
       
            <div id="listado-check">

            </div>
            <!-- fin Permisos -->

            <br>

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
    </div>
  </section>
  <!-- Main content -->
</div>
<!-- /.content-wrapper -->
    
<?php
}

else{
  require 'no_acceso.php';
}
    require 'footer.php';
?>
<!-------------------------------------------------------------------------------------------------->
<!-- Script Usuario -->
<script src="../scripts/usuario.js"></script>
<script src="../scripts/apireniec.js"></script>

<?php
}
ob_end_flush();
?>  
    
