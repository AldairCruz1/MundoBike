$(function () {
  listar();
  limpiar();

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

// Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
/*var previewNode = document.querySelector("#template")
previewNode.id = ""
var previewTemplate = previewNode.parentNode.innerHTML
previewNode.parentNode.removeChild(previewNode)*/

/*var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
  url: "/target-url", // Set the url
  thumbnailWidth: 80,
  thumbnailHeight: 80,
  parallelUploads: 20,
  previewTemplate: previewTemplate,
  autoQueue: false, // Make sure the files aren't queued until manually added
  previewsContainer: "#previews", // Define the container to display the previews
  clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
})*/

/*myDropzone.on("addedfile", function (file) {
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

function mostrar(id_usuario) {
  $.post("../../controladores/usuario.php?op=mostrar", {
    id_usuario: id_usuario
  }, function (data, status) {
    data = JSON.parse(data);

    mostrarform(true);
    $("#login").val(data.login);
    $("#password").val(data.password);
    $("#nombres").val(data.nombres);
    $("#apepaterno").val(data.apepaterno);
    $("#apematerno").val(data.apematerno);
    $("#dni").val(data.dni);
    $("#tipo").val(data.tipo);
    $("#celular").val(data.celular);
    $("#id_usuario").val(data.id_usuario);
    $('#tipo').val(data.tipo).trigger('change.select2');
    if(data.tipo == "administrador" || data.tipo == "asistente"){
      checkpermisos(id_usuario);
    }
  })
}

function checkpermisos(id_usuario) {
  $.post("../../controladores/usuario.php?op=checkpermisos", {
    id_usuario: id_usuario
  }, function (r) {
    $("#listado-check").html(r);
  });
}

function limpiar(){
  $("#login").val("");
  $("#password").val("");
  $("#nombres").val("");
  $("#apematerno").val("");
  $("#apepaterno").val("");
  $("#dni").val("");
  $("#tipo").attr("");
  $("#celular").val("");
  $("#validacion").html("");
  $("#id_usuario").val("");
  $("#tipo").val(null).trigger("change");
  $("#validacion").removeAttr("style");
  $("#validacion").html("");
}

$("#btn-agregar").click(function () {
  limpiar();
  mostrarform(true);
})

$("#btn-cancelar").click(function () {;
  limpiar();
  mostrarform(false);
})

$("#tipo").on("change", function (e) {
  tipo = $("#tipo").val();
  id_usuario = $("#id_usuario").val();
  if(tipo == "asistente" || tipo == "administrador") {
    checkpermisos(id_usuario);
  }
  else{
    $("#listado-check").html("");
  }
});

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
    //dom: 'Bfrtip'
    //buttons: ["copy", "excel", "pdf", "print", "colvis"],
    "ajax": {
      url: '../../controladores/usuario.php?op=listar',
      type: "get",
      dataType: "json",
      error: function (e) {
        console.log(e.responseText);
      }
    },
    "iDisplayLength": 5, //Paginación
  }) /*.DataTable();*/
}

function guardaryeditar(e) {
  e.preventDefault();
  //$("#btnGuardar").prop("disabled", true);
  var formData = new FormData($("#formulario")[0]);

  $.ajax({
    url: "../../controladores/usuario.php?op=guardaryeditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,

    success: function (data) {
      data = JSON.parse(data);
      if (data.condicion == 1) {
        Toast.fire({
          icon: 'success',
          title: data.mensaje
        });
        $("#navegacion-usuario").load('../formularios/navegacion.php');
        mostrarform(false);
        $('#registros').DataTable().ajax.reload();
        limpiar();
      }
      else if (data.condicion == 2) {
        Toast.fire({
          icon: 'error',
          title: data.mensaje
        });
        mostrarform(false);
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

function desactivar(id_usuario) {
  alertify.confirm("¿Está Seguro de desactivar el usuario?", function (result) {
    if (result) {
      $.post("../../controladores/usuario.php?op=desactivar", {
        id_usuario: id_usuario
      }, function (data) {

        data = JSON.parse(data);
        if (data.condicion == 1) {
          Toast.fire({
            icon: 'error',
            title: data.mensaje,
          });
          $('#registros').DataTable().ajax.reload();
        }
        else{
          Toast.fire({
            icon: 'success',
            title: data.mensaje
          });
          $('#registros').DataTable().ajax.reload();
        } 
      });
    }
  })
}

function activar(id_usuario) {
  alertify.confirm("¿Está Seguro de desactivar el usuario?", function (result) {
    if (result) {
      $.post("../../controladores/usuario.php?op=activar", {
        id_usuario: id_usuario
      }, function (data) {

        data = JSON.parse(data);
        if (data.condicion == 1) {
          Toast.fire({
            icon: 'success',
            title: data.mensaje,
          });
          $('#registros').DataTable().ajax.reload();
        } else {
          Toast.fire({
            icon: 'error',
            title: data.mensaje
          });
          $('#registros').DataTable().ajax.reload();
        }
      });
    }
  })
}
// DropzoneJS Demo Code End