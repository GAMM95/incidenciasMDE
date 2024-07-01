// $(document).ready(function () {
//   // Función para cargar valores por defecto en los combos de prioridad e impacto
//   function cargarValoresPorDefecto() {
//     // Obtener el valor de la prioridad registrada (PHP)
//     var prioridadRegistrada = '<?php echo $recepcionRegistrada ? $recepcionRegistrada["PRI_codigo"] : ""; ?>';

//     // Obtener el valor del impacto registrado (PHP)
//     var impactoRegistrado = '<?php echo $recepcionRegistrada ? $recepcionRegistrada["IMP_codigo"] : ""; ?>';

//     // Llenar el select de prioridad
//     $.ajax({
//       url: 'ajax/getPrioridadData.php',
//       type: 'GET',
//       dataType: 'json',
//       success: function (data) {
//         var select = $('#prioridad');
//         select.empty();
//         select.append('<option value="">Seleccione una prioridad</option>');
//         $.each(data, function (index, value) {
//           select.append('<option value="' + value.PRI_codigo + '">' + value.PRI_nombre + '</option>');
//         });

//         // Establecer el valor por defecto
//         if (prioridadRegistrada !== '') {
//           select.val(prioridadRegistrada);
//         } else {
//           select.val('');
//         }
//       },
//       error: function (error) {
//         console.error(error);
//       }
//     });

//     // Llenar el select de impacto
//     $.ajax({
//       url: 'ajax/getImpactoData.php',
//       type: 'GET',
//       dataType: 'json',
//       success: function (data) {
//         var select = $('#impacto');
//         select.empty();
//         select.append('<option value="">Seleccione un impacto</option>');
//         $.each(data, function (index, value) {
//           select.append('<option value="' + value.IMP_codigo + '">' + value.IMP_descripcion + '</option>');
//         });

//         // Establecer el valor por defecto
//         if (impactoRegistrado !== '') {
//           select.val(impactoRegistrado);
//         } else {
//           select.val('');
//         }
//       },
//       error: function (error) {
//         console.error(error);
//       }
//     });
//   }

//   // Llamar a la función para cargar valores por defecto al cargar la página
//   cargarValoresPorDefecto();

//   // Add a listener to every row of the table
//   $('tr').click(function () {
//     var id = $(this).find('th').html();
//     $('tr').removeClass('bg-blue-200 font-semibold');
//     $(this).addClass('bg-blue-200 font-semibold');
//     $('#INC_numero').val(id);
//     $('#INC_codigo_visible').val(id);
//   });

//   $('#submitButton').click(function () {
//     var form = $('form');
//     var data = form.serialize();
//     console.log(data);
//   });

//   console.log("FETCHING");
//   $.ajax({
//     url: '../../../ajax/getLastRecepcion.php',
//     type: 'GET',
//     dataType: 'json',
//     success: function (data) {
//       var input = $('#num_recepcion');
//       input.empty();
//       input.val(data.REC_codigo);
//     },
//     error: function (error) {
//       console.error(error);
//     }
//   });
// });

// function filtrarTablaIncidenciasSinRecepcionar() {
//   const input = document.getElementById('searchInput');
//   const filter = input.value.toLowerCase();
//   const table = document.querySelector('table');
//   const rows = table.getElementsByTagName('tr');

//   for (let i = 1; i < rows.length; i++) {
//     let cells = rows[i].getElementsByTagName('td');
//     let match = false;
//     for (let j = 0; j < cells.length; j++) {
//       if (cells[j]) {
//         if (cells[j].innerText.toLowerCase().indexOf(filter) > -1) {
//           match = true;
//           break;
//         }
//       }
//     }
//     rows[i].style.display = match ? "" : "none";
//   }
// }

// // Función para limpiar campos del formulario
// function limpiarCampos() {
//   const form = document.getElementById('formRecepcion');
//   form.reset();
// }

// // Asignar el evento 'click' al botón 'Limpiar'
// $('#limpiarCampos').click(limpiarCampos);

// // Función para nuevo registro (resetear formulario y cargar valores por defecto)
// function nuevoRegistro() {
//   limpiarCampos(); // Limpiar campos del formulario
//   cargarValoresPorDefecto(); // Cargar valores por defecto en los combos
// }

// // Asignar el evento 'click' al botón 'Nuevo Registro'
// $('#nuevoRegistro').click(nuevoRegistro);

// // GUARDAR DATOS
// $("#guardar-recepcion").on("click", function () {
//   var formData = $("form").serialize(); // Obtener los datos del formulario

//   $.ajax({
//     url: 'registro-recepcion-admin.php' + action,
//     type: "POST",
//     data: formData,
//     success: function (response) {
//       if (action === 'registrar') {
//         toastr.success('Incidencia registrada');
//       } else if (action === 'editar') {
//         toastr.success('Incidencia actualizada');
//       }
//       setTimeout(function () {
//         location.reload();
//       }, 1500);
//     },
//     error: function (xhr, status, error) {
//       console.log(xhr.responseText);
//       toastr.error('Error al guardar persona');
//     },
//   });
// });

// // Mostrar mensajes de error desde la sesión
// if (errorMessage) {
//   toastr.error(errorMessage);
// }



$(document).ready(function () {
  cargarValoresPorDefecto();

  $('tr').click(function () {
    var id = $(this).find('th').html();
    $('tr').removeClass('bg-blue-200 font-semibold');
    $(this).addClass('bg-blue-200 font-semibold');
    $('#INC_numero').val(id);
    $('#INC_codigo_visible').val(id);
  });

  $('#submitButton').click(function () {
    var form = $('form');
    var data = form.serialize();
    console.log(data);
  });

  console.log("FETCHING");
  $.ajax({
    url: '../../../ajax/getLastRecepcion.php',
    type: 'GET',
    dataType: 'json',
    success: function (data) {
      var input = $('#num_recepcion');
      input.empty();
      input.val(data.REC_codigo);
    },
    error: function (error) {
      console.error(error);
    }
  });

  $('#limpiarCampos').click(limpiarCampos);
  $('#nuevoRegistro').click(nuevoRegistro);

  $("#guardar-recepcion").on("click", function () {
    var formData = $("form").serialize();

    $.ajax({
      url: 'registro-recepcion-admin.php' + action,
      type: "POST",
      data: formData,
      success: function (response) {
        if (action === 'registrar') {
          toastr.success('Incidencia registrada');
        } else if (action === 'editar') {
          toastr.success('Incidencia actualizada');
        }
        setTimeout(function () {
          location.reload();
        }, 1500);
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText);
        toastr.error('Error al guardar persona');
      },
    });
  });

  if (errorMessage) {
    toastr.error(errorMessage);
  }
});

function cargarValoresPorDefecto() {
  var prioridadRegistrada = '<?php echo $recepcionRegistrada ? $recepcionRegistrada["PRI_codigo"] : ""; ?>';
  var impactoRegistrado = '<?php echo $recepcionRegistrada ? $recepcionRegistrada["IMP_codigo"] : ""; ?>';

  $.ajax({
    url: 'ajax/getPrioridadData.php',
    type: 'GET',
    dataType: 'json',
    success: function (data) {
      var select = $('#prioridad');
      select.empty();
      select.append('<option value="">Seleccione una prioridad</option>');
      $.each(data, function (index, value) {
        select.append('<option value="' + value.PRI_codigo + '">' + value.PRI_nombre + '</option>');
      });

      if (prioridadRegistrada !== '') {
        select.val(prioridadRegistrada);
      } else {
        select.val('');
      }
    },
    error: function (error) {
      console.error(error);
    }
  });

  $.ajax({
    url: 'ajax/getImpactoData.php',
    type: 'GET',
    dataType: 'json',
    success: function (data) {
      var select = $('#impacto');
      select.empty();
      select.append('<option value="">Seleccione un impacto</option>');
      $.each(data, function (index, value) {
        select.append('<option value="' + value.IMP_codigo + '">' + value.IMP_descripcion + '</option>');
      });

      if (impactoRegistrado !== '') {
        select.val(impactoRegistrado);
      } else {
        select.val('');
      }
    },
    error: function (error) {
      console.error(error);
    }
  });
}

function filtrarTablaIncidenciasSinRecepcionar() {
  const input = document.getElementById('searchInput');
  const filter = input.value.toLowerCase();
  const table = document.querySelector('table');
  const rows = table.getElementsByTagName('tr');

  for (let i = 1; i < rows.length; i++) {
    let cells = rows[i].getElementsByTagName('td');
    let match = false;
    for (let j = 0; j < cells.length; j++) {
      if (cells[j]) {
        if (cells[j].innerText.toLowerCase().indexOf(filter) > -1) {
          match = true;
          break;
        }
      }
    }
    rows[i].style.display = match ? "" : "none";
  }
}

function limpiarCampos() {
  const form = document.getElementById('formRecepcion');
  form.reset();
}

function nuevoRegistro() {
  limpiarCampos();
}

function changePageTablaSinRecepcionar(page) {
  // Realizar la petición AJAX
  fetch(`?page=${page}`)
    .then(response => response.text())
    .then(data => {
      // Actualizar el contenido de la tabla y de la paginación
      const parser = new DOMParser();
      const newDocument = parser.parseFromString(data, 'text/html');
      const newTable = newDocument.querySelector('table');
      const newPagination = newDocument.querySelector('.flex.justify-end.items-center.mt-1');

      // Reemplazar la tabla y la paginación actual
      const currentTable = document.querySelector('table');
      currentTable.parentNode.replaceChild(newTable, currentTable);

      const currentPagination = document.querySelector('.flex.justify-end.items-center.mt-1');
      currentPagination.parentNode.replaceChild(newPagination, currentPagination);
    })
    .catch(error => {
      console.error('Error al cambiar de página:', error);
    });
}