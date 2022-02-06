/*var tabla;*/


var barChart;
// var id_bicicleta;
// var id_bicicleta2;
// var name;
// var name2;
//let barChartCanvas;

$(function () {
    
    //$("#id_bicicleta").change(compareteBicicle);
    //("#id_bicicleta2").change(compareteBicicle);

  
    //Initialize Select2 Elements
    $('.select2').select2()
  
    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
  
    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', {
      'placeholder': 'dd/mm/yyyy'
    })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', {
      'placeholder': 'mm/dd/yyyy'
    })
    //Money Euro
    $('[data-mask]').inputmask()
  
    //Date picker
    $('#reservationdate').datetimepicker({
      format: 'L'
    });
  
    //Date and time picker
    $('#reservationdatetime').datetimepicker({
      icons: {
        time: 'far fa-clock'
      }
    });
  
    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker({
        ranges: {
          'Today': [moment(), moment()],
          'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days': [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month': [moment().startOf('month'), moment().endOf('month')],
          'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate: moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )
  
    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })
  
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()
  
    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()
  
    $('.my-colorpicker2').on('colorpickerChange', function (event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    })
  
    $("input[data-bootstrap-switch]").each(function () {
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })
  
  })

  var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 2000
  });
  
  
  //Funciones -------------------------------------------------------------------------------
  
  $('#borrarGrafico').hide();

  //limpiar();
  ventasMeses();
  reservasTotalMeses();
  //compareteBicicle();
  listar();
  $("#fecha_inicio").change(listar);
  $("#fecha_fin").change(listar);


  function limpiar() {
    $("#id_bicicleta").val(null).trigger("change")
    $("#id_bicicleta2").val(null).trigger("change")
  }

  $.post("../../controladores/reportes.php?op=nombre", function (r) {
    $("#id_bicicleta").html(r);
    $("#id_bicicleta").select2({
      placeholder: "Seleccione Bicicleta"
    });
    $("#id_bicicleta2").html(r);
    $("#id_bicicleta2").select2({
      placeholder: "Seleccione Bicicleta"
    });
    limpiar();
  });

  function listar(){

    var fecha_inicio = $("#fecha_inicio").val();
    var fecha_fin = $("#fecha_fin").val();

    //console.log(data);

    /*tabla=*/$('#registros').DataTable({
      "destroy": true,  
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      dom: 'Bfrtip',
      buttons: [/*"copy",*/ "excel", "pdf", "print"/*,"colvis"*/],
      "ajax": 
              {
                url: '../../controladores/reportes.php?op=reportesfecha',
                data:{fecha_inicio: fecha_inicio,fecha_fin: fecha_fin},
                type: "get",
                dataType: "json",
                error: function (e) {
                  console.log(e.responseText);
                }
              },
      "iDisplayLength": 8, //Paginación
    }) /*.DataTable();*/
  }

  $.post("../../controladores/reportes.php?op=getdatos", {
  }, function (data, status) {
    data = JSON.parse(data);
    $("#totalu").html(data.allUsers);
    $("#allBikes").html(data.allBikes);
    $("#allReservations").html(data.allReservations);
    $("#totalReservations").html(data.totalReservations);
    //alert(data.allBikes);
  })

  function ventasMeses(){
    $.ajax({
      url: "../../controladores/reportes.php?op=ventasMeses",
      type: "post",
    }).done(function(data){
      //alert(data);
      var fecha=[];
      var total=[];
    
      var data = JSON.parse(data);
      //alert(data1);
      //console.log(data[0]);
      /*for (i = 0 ;i < data.length; i++ ){
        fecha.push(data[i][0]);
        total.push(data[i][1]);
      }*/
      data.forEach( function(valor, indice, array) {
        //console.log('mes:'+valor[0]+'-total:'+valor[1]);
        fecha.push(valor[0]);
        total.push(valor[1]);
      });

      //console.log(fecha);
      //console.log(total);

      //----------BAR CHAR-----------------//
      var ctx = document.getElementById('myChart1');
      var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: fecha,
                datasets: [{
                    label: 'Ventas en S/. de los últimos 12 meses',
                    data: total,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },          
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
      
    })
  }

  function reservasTotalMeses(){
    $.ajax({
      url: "../../controladores/reportes.php?op=reservasTotalMeses",
      type: "post",
    }).done(function(data){
      //alert(data);
      //console.log(data);
      var marca=[];
      var cantidad=[];
    
      var data = JSON.parse(data);
      //alert(data1);
      //console.log(data[0]);
      /*for (i = 0 ;i < data.length; i++ ){
        fecha.push(data[i][0]);
        total.push(data[i][1]);
      }*/
      data.forEach( function(valor, indice, array) {
        //console.log('mes: '+valor[0]+'-total: '+valor[1]);
        marca.push(valor[0]);
        cantidad.push(valor[1]);
      });

      //console.log(marca);
      //console.log(cantidad);

      //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('#myChart2').get(0).getContext('2d')
    var donutData        = {
      labels: marca,
      datasets: [
        {
          data: cantidad,
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions
    })

    })
  }

  function compareteBicicle() {
    var id_bicicleta = $("#id_bicicleta").val();
    var id_bicicleta2 = $("#id_bicicleta2").val();

    if (id_bicicleta == null || id_bicicleta2 == null) {
      Toast.fire({
        icon: 'info',
        title: 'Seleccione ambas bicicletas'
      });
    } 
    else{

      $('#generarGrafico').click(function(){
        $('#generarGrafico').hide();
        $('#borrarGrafico').show();
      });
      $('#borrarGrafico').click(function(){
        $('#borrarGrafico').hide();
        $('#generarGrafico').show();
      });
          
      var name_bicicleta2 = $("#select2-id_bicicleta2-container").html();
      var name_bicicleta = $("#select2-id_bicicleta-container").html();

      $.ajax({
        url: "../../controladores/reportes.php?op=compareteBicicle",
        data: {
          id_bicicleta: id_bicicleta,
          id_bicicleta2: id_bicicleta2
        },
        type: "post",
      }).done(function (data) {
        //alert(data);
        console.log(data);
        var fecha = [];
        var monto = [];
        var id_bicicleta = [];
        var fecha2 = [];
        var monto2 = [];
        var id_bicicleta2 = [];

        var data = JSON.parse(data);
        //alert(data1);
        //console.log(data[0]);
        /*for (i = 0 ;i < data.length; i++ ){
          fecha.push(data[i][0]);
          total.push(data[i][1]);
        }*/
        data.forEach(function (valor, indice, array) {
          console.log('Fecha: ' + valor[0] + ' -Monto: ' + valor[1] + ' -ID_BICICLETA: ' + valor[2] + ' *** Fecha2: ' + valor[3] + ' -Monto2: ' + valor[4] + ' -ID_BICICLETA2: ' + valor[5]);
          fecha.push(valor[0]);
          monto.push(valor[1]);
          id_bicicleta.push(valor[2]);
          fecha2.push(valor[3]);
          monto2.push(valor[4]);
          id_bicicleta2.push(valor[5]);
        });

        //console.log(id_bicicleta);
        console.log(fecha);
        console.log(fecha2);
        console.log(monto, monto2);

        //- BAR CHART -
        //-------------
        var barChartCanvas = $('#myChart3').get(0).getContext('2d')

        var barChartData = {
          labels: fecha,
          datasets: [{
              label: name_bicicleta2,
              backgroundColor: 'rgba(60,141,188,0.9)',
              borderColor: 'rgba(60,141,188,0.8)',
              pointRadius: false,
              pointColor: '#3b8bba',
              pointStrokeColor: 'rgba(60,141,188,1)',
              pointHighlightFill: '#fff',
              pointHighlightStroke: 'rgba(60,141,188,1)',
              data: monto2
            },
            {
              label: name_bicicleta,
              backgroundColor: 'rgba(210, 214, 222, 1)',
              borderColor: 'rgba(210, 214, 222, 1)',
              pointRadius: false,
              pointColor: 'rgba(210, 214, 222, 1)',
              pointStrokeColor: '#c1c7d1',
              pointHighlightFill: '#fff',
              pointHighlightStroke: 'rgba(220,220,220,1)',
              data: monto
            },

          ]
        }
        var temp0 = barChartData.datasets[0]
        var temp1 = barChartData.datasets[1]
        barChartData.datasets[0] = temp1
        barChartData.datasets[1] = temp0


        var barChartOptions = {
          responsive: true,
          maintainAspectRatio: false,
          datasetFill: false
        }

        barChart = new Chart(barChartCanvas, {
          type: 'bar',
          data: barChartData,
          options: barChartOptions
        })


      })
    }
    
  }

  function destroy(){
    barChart.destroy();
  }

  

  


  

    


  


  


