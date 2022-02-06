<?php
ob_start();
session_start();

if (!isset($_SESSION["nombres"]))
{
  header("Location:login.php");
}
else
{
require_once 'header.php';

if ($_SESSION['dashboard']==1)
{
  

?>

<!-- Preloader -->
<div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="../../dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
</div>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Principal</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3 id="totalReservations"></h3>
                <p>Recaudado en el Día</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="reservas.php" class="small-box-footer">Reservas <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3 id="allReservations"></h3>
                <p>Reservas del Día</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="reservas.php" class="small-box-footer">Reservas <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-teal">
              <div class="inner">
                <h3 id="totalu">
                </h3>
                <p style="color: white;">Usuarios Registrados</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="usuarios.php" class="small-box-footer">Usuarios <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3 id="allBikes"></h3>

                <p>Bicicletas Registradas</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="bicicletas.php" class="small-box-footer">Bicicletas <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-6 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->

            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="far fa-chart-bar"></i>
                  Reservas Totales por mes                
                </h3>
                <!--<button class="btn btn-primary" onclick="ventasMeses()">Respuesta</button>-->
              </div>
              <div class="card-body">
                <!--<div id="bar-chart" style="height: 300px;"></div>-->
                <!-- <canvas id="myChart1" width="400" height="400"></canvas> -->
                <canvas id="myChart1" style="min-height: 250px; height: 465px; max-height: 500px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body-->
            </div>   
            <!-- /.card -->         
          </section>

          <!-- <section class="col-lg-6 connectedSortable">
            <div class="card card-success card-outline">
              <div class="card-header">
                <h3 class="card-title"><i class="far fa-chart-bar"></i>  Montos generado por Bicicletas por Meses</h3>
              </div>
              <div class="card-body">
                <div class="row">
                  <select id="id_bicicleta" name="id_bicicleta" class="form-control select2"  style="width: 25%;"></select>
                  <select id="id_bicicleta2" name="id_bicicleta2" class="form-control select2" style="width: 25%;"></select>
                  <button id="generarGrafico" class="btn btn-primary btn-block" onclick="compareteBicicle()" style="width: 50%;"><i class="far fa-chart-bar"></i> Generar Gráfico</button>
                  <button id="borrarGrafico" class="btn btn-danger btn-block" onclick="destroy()" style="width: 50%;"><i class="fa fa-bell"></i> Borrar Grafico</button>                 
                </div>                       
                <div class="chart">
                  <br>
                  <canvas id="myChart3" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
            </div>
          </section> -->

          <section class="col-lg-6 connectedSortable">
          <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title"><i class="far fa-chart-bar"></i> Montos generado por Bicicletas por Meses</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                  <div class="row">
                    <div class="col-sm-4">
                      <!-- select -->
                      <div class="form-group">
                        <label>Seleccione Bicicleta #1</label>
                        <select id="id_bicicleta" name="id_bicicleta" class="form-control select2"></select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Seleccione Bicicleta #2</label>
                        <select id="id_bicicleta2" name="id_bicicleta2" class="form-control select2"></select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <br>                 
                        <button id="generarGrafico" class="btn btn-primary btn-block" onclick="compareteBicicle()"><i class="far fa-chart-bar"></i> Generar Gráfico</button>
                        <button id="borrarGrafico" class="btn btn-danger btn-block" onclick="destroy()"><i class="fa fa-bell"></i> Borrar Grafico</button>   
                      </div>              
                    </div>
                  </div>  
                  <div class="chart">
                    <br>
                    <canvas id="myChart3" style="min-height: 350px; height: 350px; max-height: 250px; max-width: 100%;"></canvas>
                  </div>       
              </div>
              <!-- /.card-body -->
            </div>
          </section>


          <section class="col-lg-6 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card card-danger">
              <div class="card-header">          
                <h3 class="card-title"><i class="far fa-chart-bar"></i> Reservas Totales por Marcas durante el mes</h3> 
              </div>
              <div class="card-body">
                <canvas id="myChart2" style="min-height: 250px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->         
          </section>

          
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
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
</body>

<script src="../scripts/reportes.js"></script>


    
<?php
}
ob_end_flush();
?>