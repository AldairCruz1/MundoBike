$(function () {
  listar();

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

// bsCustomFileInput.init();
// // BS-Stepper Init
// document.addEventListener('DOMContentLoaded', function () {
//   window.stepper = new Stepper(document.querySelector('.bs-stepper'))
// })

// // DropzoneJS Demo Code Start
// Dropzone.autoDiscover = false

// Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
//var previewNode = document.querySelector("#template")
//previewNode.id = ""
//var previewTemplate = previewNode.parentNode.innerHTML
//previewNode.parentNode.removeChild(previewNode)

// var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
//   url: "/target-url", // Set the url
//   thumbnailWidth: 80,
//   thumbnailHeight: 80,
//   parallelUploads: 20,
//   previewTemplate: previewTemplate,
//   autoQueue: false, // Make sure the files aren't queued until manually added
//   previewsContainer: "#previews", // Define the container to display the previews
//   clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
// })

// myDropzone.on("addedfile", function (file) {
//   // Hookup the start button
//   file.previewElement.querySelector(".start").onclick = function () {
//     myDropzone.enqueueFile(file)
//   }
// })

// // Update the total progress bar
// myDropzone.on("totaluploadprogress", function (progress) {
//   document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
// })

// myDropzone.on("sending", function (file) {
//   // Show the total progress bar when upload starts
//   document.querySelector("#total-progress").style.opacity = "1"
//   // And disable the start button
//   file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
// })

// // Hide the total progress bar when nothing's uploading anymore
// myDropzone.on("queuecomplete", function (progress) {
//   document.querySelector("#total-progress").style.opacity = "0"
// })

// // Setup the buttons for all transfers
// // The "add files" button doesn't need to be setup because the config
// // `clickable` has already been specified.
// document.querySelector("#actions .start").onclick = function () {
//   myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
// }
// document.querySelector("#actions .cancel").onclick = function () {
//   myDropzone.removeAllFiles(true)
// }

//Funciones -------------------------------------------------------------------------------


var Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 2000
});

function listar() {

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
    "ajax": {
      url: '../../controladores/atender.php?op=listar',
      type: "get",
      dataType: "json",
      error: function (e) {
        console.log(e.responseText);
      }
    }
  });
}

function atender(id_reserva){

    $.post("../../controladores/atender.php?op=atender", {
        id_reserva: id_reserva
    }, function (response) {
        response = JSON.parse(response);
        Swal.fire({
            title: "Atencion de la Reserva "+response.reserva,
            html: response.html,
            showCancelButton: true,
            confirmButtonText: response.button,
            allowEscapeKey: false,
            closeOnCancel: true,
            cancelButtonColor: "#C43D2B",
            cancelButtonText: "Cancelar",
        }).then(resultado => {
            if (resultado.value) {
                Swal.fire({
                    title: "¿Esta seguro de realizar esta accion?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Si",
                    cancelButtonColor: "#C43D2B",
                    cancelButtonText: "No",
                }).then(confirmacion => {
                    if (confirmacion.value) {
                        $.post("../../controladores/atender.php?op=efectuar", {
                            id_reserva: id_reserva,
                            id_estado: response.estado
                        }, function (response) {
                            if(response == 1) {
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Reserva efectuada!!'
                                });
                            }
                            else if(response == 2) {
                                Toast.fire({
                                    icon: 'error',
                                    title: 'Reserva no efectuada!!'
                                });
                            }
                        });
                        $('#registros').DataTable().ajax.reload();
                    }
                });
            } else {
                // Dijeron que no
                //console.log("*NO se elimina la venta*");
            }   
        });
    });
    
}



// DropzoneJS Demo Code End