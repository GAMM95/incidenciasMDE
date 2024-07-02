// TODO: SETEAR LOS VALORES DEL COMBO OPERATIVIDAD
$(document).ready(function () {
  console.log("FETCHING");
  $.ajax({
    url: 'ajax/getOperatividad.php',
    type: 'GET',
    dataType: 'json',
    success: function (data) {
      var select = $('#operatividad');
      select.empty();
      select.append('<option value="" selected disabled>Seleccione operatividad</option>');
      $.each(data, function (index, value) {
        select.append('<option value="' + value.OPE_codigo + '">' + value.OPE_descripcion + '</option>');
      });

      if (operatividadRegistrada !== '') {
        select.val(operatividadRegistrada);
      } else {
        select.val('');
      }
    },
    error: function (error) {
      console.error(error);
    }
  });
});

// TODO: METODO PARA HACER BUSQUEDA DE LA PRIMERA TABLA
$('#searchInput').on('input', function () {
  filtrarTablaRecepcionesSinCerrar();
});

// TODO: FILTRADO DE TABLA DE INCIDENCIAS SIN RECEPCIONAR
function filtrarTablaRecepcionesSinCerrar() {
  var input, filter, table, rows, cells, i, j, match;
  input = document.getElementById('searchInput');
  filter = input.value.toUpperCase();
  table = document.getElementById('tablaRecepcionesSinCerrar');
  rows = table.getElementsByTagName('tr');

  for (i = 1; i < rows.length; i++) {
    cells = rows[i].getElementsByTagName('td');
    match = false;
    for (j = 0; j < cells.length; j++) {
      if (cells[j].innerText.toUpperCase().indexOf(filter) > -1) {
        match = true;
        break;
      }
    }
    rows[i].style.display = match ? '' : 'none';
  }
}

// TODO: FUNCION PARA CAMBIAR PAGINAS DE LA TABLA DE RECEPCIONES SIN CERRAR
function changePageTablaSinCerrar(page) {
  fetch(`?page=${page}`)
    .then(response => response.text())
    .then(data => {
      const parser = new DOMParser();
      const newDocument = parser.parseFromString(data, 'text/html');
      const newTable = newDocument.querySelector('#tablaRecepcionesSinCerrar');
      const newPagination = newDocument.querySelector('.flex.justify-end.items-center.mt-1');

      // Reemplazar la tabla actual con la nueva tabla obtenida
      document.querySelector('#tablaRecepcionesSinCerrar').parentNode.replaceChild(newTable, document.querySelector('#tablaRecepcionesSinCerrar'));

      // Reemplazar la paginación actual con la nueva paginación obtenida
      const currentPagination = document.querySelector('.flex.justify-end.items-center.mt-1');
      if (currentPagination && newPagination) {
        currentPagination.parentNode.replaceChild(newPagination, currentPagination);
      }
    })
    .catch(error => {
      console.error('Error al cambiar de página:', error);
    });
}

$(document).ready(function () {
  //Evento de clic en las filas de la tabla de recepciones sin cerrar
  $(document).on('click', '#tablaRecepcionesSinCerrar tbody tr', function () {
    var id = $(this).find('th').html();
    $('#tablaRecepcionesSinCerrar tbody tr').removeClass('bg-blue-200 font-semibold');
    $(this).addClass('bg-blue-200 font-semibold');
    $('#num_recepcion').val(id);
  });
})
// Add a listener to every row of the table
// $(document).ready(function () {
//   $('tr').click(function () {
//     var id = $(this).find('th').html();
//     $('tr').removeClass('bg-blue-200 font-semibold');
//     $(this).addClass('bg-blue-200 font-semibold');
//     $('#REC_numero').val(id);
//     $('#REC_codigo_visible').val(id);
//   });
// });

$(document).ready(function () {
  $('#submitButton').click(function () {
    var form = $('form');
    var data = form.serialize();
    console.log(data);
  });
});

$(document).ready(function () {
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
});

function limpiarCampos() {
  // Obtener el formulario por su ID
  const form = document.getElementById('formCierre');
  // Limpiar los campos del formulario
  form.reset();
}
const btnLimpiar = document.getElementById('limpiarCampos');
btnLimpiar.addEventListener('click', limpiarCampos);

function nuevoRegistro() {
  const form = document.getElementById('formCierre');
  // Restablecer el formulario
  form.reset();
}
// Asignar el evento 'click' al botón 'Nuevo Registro'
const btnNuevo = document.getElementById('nuevoRegistro');
btnNuevo.addEventListener('click', nuevoRegistro);

// GUARDAR DATOS
$(document).ready(function () {
  $("#guardar-cierre").on("click", function () {
    // Obtener los datos del formulario
    var formData = $("form").serialize(); // Obtener los datos del formulario

    $.ajax({
      url: 'registro-cierre-admin.php' + action, // Reemplaza "tu_archivo_de_backend.php" con tu ruta de backend
      type: "POST",
      data: formData,
      success: function (response) {
        if (action === 'registrar') {
          toastr.success('Cierre registrado');
        } else if (action === 'editar') {
          toastr.success('Cierre actualizado');
        }
        setTimeout(function () {
          location.reload();
        }, 1500);
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText);
        toastr.error('Error al guardar cierre');
      },
    });
  });
});

// Mostrar mensajes de error desde la sesión
$(document).ready(function () {
  if (errorMessage) {
    toastr.error(errorMessage);
  }
});
