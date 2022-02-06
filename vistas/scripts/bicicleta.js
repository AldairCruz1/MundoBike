$(function () {
  //$('#listado').hide();
  $.post("../../controladores/bicicleta.php?op=propietario", function (r) {
    $("#id_usuario").html(r);
    $("#id_usuario").select2({
      placeholder: "Seleccione al propietario"
    });
  });

  $.post("../../controladores/bicicleta.php?op=estado", function (r) {
    $("#id_estado").html(r);
    $("#id_estado").select2({
      placeholder: "Seleccione estado"
    });
  });

  listar();

  $("#formulario").on("submit", function (e) {
    guardaryeditar(e);
  });

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


bsCustomFileInput.init();
/*
// BS-Stepper Init
document.addEventListener('DOMContentLoaded', function () {
  window.stepper = new Stepper(document.querySelector('.bs-stepper'))
})

// DropzoneJS Demo Code Start
Dropzone.autoDiscover = false
/*
// Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
var previewNode = document.querySelector("#template")
previewNode.id = ""
var previewTemplate = previewNode.parentNode.innerHTML
previewNode.parentNode.removeChild(previewNode)
*/
/*
var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
  url: "/target-url", // Set the url
  thumbnailWidth: 80,
  thumbnailHeight: 80,
  parallelUploads: 20,
  previewTemplate: previewTemplate,
  autoQueue: false, // Make sure the files aren't queued until manually added
  previewsContainer: "#previews", // Define the container to display the previews
  clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
})

myDropzone.on("addedfile", function (file) {
  // Hookup the start button
  file.previewElement.querySelector(".start").onclick = function () {
    myDropzone.enqueueFile(file)
  }
})

// Update the total progress bar
myDropzone.on("totaluploadprogress", function (progress) {
  document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
})

myDropzone.on("sending", function (file) {
  // Show the total progress bar when upload starts
  document.querySelector("#total-progress").style.opacity = "1"
  // And disable the start button
  file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
})

// Hide the total progress bar when nothing's uploading anymore
myDropzone.on("queuecomplete", function (progress) {
  document.querySelector("#total-progress").style.opacity = "0"
})

// Setup the buttons for all transfers
// The "add files" button doesn't need to be setup because the config
// `clickable` has already been specified.
document.querySelector("#actions .start").onclick = function () {
  myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
}
document.querySelector("#actions .cancel").onclick = function () {
  myDropzone.removeAllFiles(true)
}*/

//Funciones -------------------------------------------------------------------------------

var Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 2000
});

mostrarform(false);

function mostrarform(flag) {
  if(flag){
    $('#form').show();
    $('#listado').hide();
  }
  else{
    $('#form').hide();
    $('#listado').show();
  }
}

function mostrar(id_bicicleta) {
  $.post("../../controladores/bicicleta.php?op=mostrar", {
    id_bicicleta: id_bicicleta
  }, function (data, status) {
    data = JSON.parse(data);
    limpiar();
    mostrarform(true);
    $("#id_bicicleta").val(data.id_bicicleta);
    $("#marca").val(data.marca);
    $("#modelo").val(data.modelo);
    $("#color").val(data.color);
    $("#ganancia").val(data.ganancia);
    $("#serie").val(data.serie);
    $("#accesorios").val(data.accesorios);
    $('#id_usuario').val(data.id_usuario).trigger('change.select2');
    $('#id_estado').val(data.id_estado).trigger('change.select2');
    $('#listado').hide();
  })
}

function limpiar(){
  $("#id_bicicleta").val("");
  $("#marca").val("");
  $("#modelo").val("");
  $("#color").val("");
  $("#ganancia").val("");
  $("#serie").val("");
  $("#accesorios").val("");
  $("#id_usuario").val(null).trigger("change")
  $("#id_estado").val(null).trigger("change")
  $("#imagen").val("");
  $('#imagen').next('label').html('Agregue una foto');
}

$("#btn-agregar").click(function () {
  $('#listado').hide();
  mostrarform(true);
  limpiar();
})

$("#btn-cancelar").click(function () {
  limpiar();
  mostrarform(false);
})

function listar(){

  $('#registros').DataTable({
    "language": {
      "url": "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
    },
    "paging": true,
    "lengthChange": false,
    "searching": true,
    "ordering": true,
    "info": true,
    "autoWidth": false,
    "responsive": true,
    //dom: 'Bfrtip',
    //buttons: ["copy", "excel", "pdf", "print", "colvis"],
    "ajax": {
      url: '../../controladores/bicicleta.php?op=listar',
      type: "get",
      dataType: "json",
      error: function (e) {
        console.log(e.responseText);
      }
    },
    "iDisplayLength": 8,
  });
}

function guardaryeditar(e) {
  e.preventDefault();
  //$("#btnGuardar").prop("disabled", true);
  var formData = new FormData($("#formulario")[0]);

  $.ajax({
    url: "../../controladores/bicicleta.php?op=guardaryeditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,

    success: function (data) {
      alert(data)
      data = JSON.parse(data);
      if (data.condicion == 1) {
        Toast.fire({
          icon: 'success',
          title: data.mensaje
        });
        mostrarform(false);
        //$('#listado').show();
        $('#registros').DataTable().ajax.reload();
        limpiar();
      }
      else if (data.condicion == 2) {
        Toast.fire({
          icon: 'error',
          title: data.mensaje
        });
        mostrarform(false);
        //$('#listado').show();
        $('#registros').DataTable().ajax.reload();
        limpiar();
      }
      else{
        Toast.fire({
          icon: 'error',
          title: data.mensaje
        })
      }
    }

  });
}

function imagen(url){
  $("#modalimg").html('<img style="width: 90%; margin: auto;"src="'+url+'">');
}
// DropzoneJS Demo Code End