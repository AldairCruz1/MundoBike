$(function () {
  moment.locale('es');

  presentar();

  // $.timer(2000, function () {
  //   alert("hola, pasaron 2 segundos");
  // })

  $("#formulario").on("submit", function (e) {
    editar(e);
  });

  $("#formulario2").on("submit", function (e) {
      editar2(e);
  });

  $("#btnGuardarPass").prop('disabled', true);

  $.post("../../controladores/usuario.php?op=presentar", {}, function (data, status) {
    data = JSON.parse(data);
    getFecha = moment(data.creado_a, 'YYYY-MM-DD HH:mm:ss');
    fechaCreate = getFecha.format('D MMM YYYY');
    horaCreate = getFecha.format('HH:mm');
    $("#create-date").html(fechaCreate);
    $("#create-hour").append(horaCreate);
    date = new Date();
    hoy = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
    fechaUpdate = moment(hoy, 'YYYY-MM-DD');
    fechaUpdate = fechaUpdate.format('D MMM YYYY');
    $("#update-date").html(fechaUpdate);
  })



  //fecha = new Date();
  

  // var fechaEjemplo = moment('2016-01-30', 'YYYY/MM/dd');
  // fechaEjemplo = fechaEjemplo.format('D MMM YYYY');

  // alert(fechaEjemplo)

//   //Initialize Select2 Elements
//   $('.select2').select2()

//   //Initialize Select2 Elements
//   $('.select2bs4').select2({
//     theme: 'bootstrap4'
//   })

//   //Datemask dd/mm/yyyy
//   $('#datemask').inputmask('dd/mm/yyyy', {
//     'placeholder': 'dd/mm/yyyy'
//   })
//   //Datemask2 mm/dd/yyyy
//   $('#datemask2').inputmask('mm/dd/yyyy', {
//     'placeholder': 'mm/dd/yyyy'
//   })
//   //Money Euro
//   $('[data-mask]').inputmask()

//   //Date picker
//   $('#reservationdate').datetimepicker({
//     format: 'L'
//   });

//   //Date and time picker
//   $('#reservationdatetime').datetimepicker({
//     icons: {
//       time: 'far fa-clock'
//     }
//   });

//   //Date range picker
//   $('#reservation').daterangepicker()
//   //Date range picker with time picker
//   $('#reservationtime').daterangepicker({
//     timePicker: true,
//     timePickerIncrement: 30,
//     locale: {
//       format: 'MM/DD/YYYY hh:mm A'
//     }
//   })
//   //Date range as a button
//   $('#daterange-btn').daterangepicker({
//       ranges: {
//         'Today': [moment(), moment()],
//         'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
//         'Last 7 Days': [moment().subtract(6, 'days'), moment()],
//         'Last 30 Days': [moment().subtract(29, 'days'), moment()],
//         'This Month': [moment().startOf('month'), moment().endOf('month')],
//         'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
//       },
//       startDate: moment().subtract(29, 'days'),
//       endDate: moment()
//     },
//     function (start, end) {
//       $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
//     }
//   )

//   //Timepicker
//   $('#timepicker').datetimepicker({
//     format: 'LT'
//   })

//   //Bootstrap Duallistbox
//   $('.duallistbox').bootstrapDualListbox()

//   //Colorpicker
//   $('.my-colorpicker1').colorpicker()
//   //color picker with addon
//   $('.my-colorpicker2').colorpicker()

//   $('.my-colorpicker2').on('colorpickerChange', function (event) {
//     $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
//   })

//   $("input[data-bootstrap-switch]").each(function () {
//     $(this).bootstrapSwitch('state', $(this).prop('checked'));
//   })

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
    $("#nombre").val(data.nombres + " " + data.apepaterno + " " + data.apematerno);
    $("#nombres").val(data.nombres);
    $("#apepaterno").val(data.apepaterno);
    $("#apematerno").val(data.apematerno);
    $("#dni").val(data.dni);
    $("#tipo").val(data.tipo);
    $("#email").val(data.email);
    $("#celular").val(data.celular);
    $("#id_usuario").val(data.id_usuario);
    $('#tipo').val(data.tipo).trigger('change.select2');
    if(data.tipo == "administrador" || data.tipo == "asistente"){
    }
  })
}

function presentar() {
  $.post("../../controladores/usuario.php?op=presentar", {
  }, function (data, status) {
    data = JSON.parse(data);
    $("#m-nombre").html(data.nombres + " " + data.apepaterno + " " + data.apematerno);
    $("#m-tipo").html(data.tipo);
    $("#m-nombres").html(data.nombres);
    $("#m-apellidos").html(data.apepaterno + " " + data.apematerno);
    $("#m-dni").html(data.dni);
    $("#m-celular").html(data.celular);
    $("#m-email").html(data.email);
  })
}


function limpiar(){
  $("#pass_old").val("");
  $("#pass_new").val("");
  $("#pass_new_2").val("");
  $("#icon_pass_old").attr("class", "");
  $("#icon_pass_new").attr("class", "");
  $("#icon_pass_new_2").attr("class", "");
  $("#pass_old").removeAttr("readonly");
  $("#pass_new").attr("readonly", "readonly");
  $("#pass_new_2").attr("readonly", "readonly");
  $("#apematerno").val("");
  $("#apepaterno").val("");
  $("#dni").val("");
  $("#tipo").attr("");
  $("#celular").val("");
  $("#validacion").html("");
  $("#id_usuario").val("");
  $("#tipo").val(null).trigger("change");
  $("#tipo").val(null).trigger("change");
  $("#validacion").removeAttr("style");
  $("#validacion").html("");
}

function editar(e) {
  e.preventDefault();
  var formData = new FormData($("#formulario")[0]);

  $.ajax({
    url: "../../controladores/usuario.php?op=editar",
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
        location.reload();
      }
      else if (data.condicion == 2) {
        Toast.fire({
          icon: 'error',
          title: data.mensaje
        });
      }
      else{
        Toast.fire({
          icon: 'error',
          title: data.mensaje
        })
      }
      $("#historial-tab").click();
    }

  });
}

function editar2(e) {
  e.preventDefault();
  var formData = new FormData($("#formulario2")[0]);

  $.ajax({
    url: "../../controladores/usuario.php?op=actualizarpass",
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
        $("#btnGuardarPass").prop('disabled', true);
      } else if (data.condicion == 2) {
        Toast.fire({
          icon: 'error',
          title: data.mensaje
        });
      } else {
        Toast.fire({
          icon: 'error',
          title: data.mensaje
        })
      }
      limpiar();
      $("#historial-tab").click();
    }

  });
}

$("#pass_old").change(function () {
  pass_old = $("#pass_old").val();
  $.post("../../controladores/usuario.php?op=validarpassword", {
    pass_old: pass_old
  }, function (data, status) {
    data = JSON.parse(data);
    if(data.condicion == 1){
      Toast.fire({
        icon: 'success',
        title: data.mensaje
      })
      $("#icon_pass_old").attr("class", "fas fa-check-circle text-success");
      $("#pass_old").attr("readonly", "readonly");
      $("#pass_new").removeAttr("readonly");
    }
    else{
      Toast.fire({
        icon: 'error',
        title: data.mensaje
      })
      $("#icon_pass_old").attr("class", "fas fa-times-circle text-danger");
    }
  })
})

$("#pass_new").change(function () {
  pass_new = $("#pass_new").val();
  if(pass_new.length <= 4){
    Toast.fire({
      icon: 'error',
      title: 'Minimo 5 caracteres'
    })
    $("#icon_pass_new").attr("class", "fas fa-times-circle text-danger");
  }
  else{
    $("#icon_pass_new").attr("class", "fas fa-check-circle text-success");
    $("#pass_new").attr("readonly", "readonly");
    $("#pass_new_2").removeAttr("readonly");
  }
})

$("#pass_new_2").change(function () {
  pass_new = $("#pass_new").val();
  pass_new2 = $("#pass_new_2").val();
  if (pass_new == pass_new2){
    $("#icon_pass_new_2").attr("class", "fas fa-check-circle text-success");
    $("#pass_new_2").attr("readonly", "readonly");
    $("#btnGuardarPass").prop('disabled', false);
  }
  else{
    Toast.fire({
      icon: 'error',
      title: 'Contrase??as no coinciden'
    })
    $("#icon_pass_new_2").attr("class", "fas fa-times-circle text-danger");
  }
  
})

$("#btnLimpiar").click(function () {
  limpiar();
  Toast.fire({
    icon: 'info',
    title: 'Campos limpiados'
  })
  $("#btnGuardarPass").prop('disabled', true);
})

// DropzoneJS Demo Code End