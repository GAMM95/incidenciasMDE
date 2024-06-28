$(document).ready(function () {
  console.log("FETCHING");
  $.ajax({
    url: 'ajax/getPrioridadData.php',
    type: 'GET',
    dataType: 'json',
    success: function (data) {
      var select = $('#prioridad');
      select.empty();
      select.append('<option value="" selected disabled>Seleccione una prioridad</option>');
      $.each(data, function (index, value) {
        select.append('<option value="' + value.PRI_codigo + '">' + value.PRI_nombre + '</option>');
      });
      document.getElementById('prioridad').value = recepcionRegistrada ? recepcionRegistrada.PRI_codigo : '';
    },
    error: function (error) {
      console.error(error);
    }
  });
});

$(document).ready(function () {
  console.log("FETCHING");
  $.ajax({
    url: 'ajax/getImpactoData.php',
    type: 'GET',
    dataType: 'json',
    success: function (data) {
      var select = $('#impacto');
      select.empty();
      select.append('<option value="" selected disabled>Seleccione nivel de impacto</option>');
      $.each(data, function (index, value) {
        select.append('<option value="' + value.IMP_codigo + '">' + value.IMP_descripcion + '</option>');
      });
      document.getElementById('impacto').value = recepcionRegistrada ? recepcionRegistrada.IMP_codigo : '';
    },
    error: function (error) {
      console.error(error);
    }
  });
});

// Add a listener to every row of the table
$(document).ready(function () {
  $('tr').click(function () {
    var id = $(this).find('th').html();
    $('tr').removeClass('bg-blue-200 font-semibold');
    $(this).addClass('bg-blue-200 font-semibold');
    $('#INC_codigo').val(id);
    $('#INC_codigo_visible').val(id);
  });
});

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
  const form = document.getElementById('formRecepcion');
  // Limpiar los campos del formulario
  form.reset();
}
const btnLimpiar = document.getElementById('limpiarCampos');
btnLimpiar.addEventListener('click', limpiarCampos);

function nuevoRegistro() {
  const form = document.getElementById('formRecepcion');
  // Restablecer el formulario
  form.reset();
}
// Asignar el evento 'click' al botón 'Nuevo Registro'
const btnNuevo = document.getElementById('nuevoRegistro');
btnNuevo.addEventListener('click', nuevoRegistro);

// GUARDAR DATOS
$(document).ready(function () {
  $("#guardar-recepcion").on("click", function () {
    // Obtener los datos del formulario
    var formData = $("form").serialize(); // Obtener los datos del formulario

    $.ajax({
      url: 'registro-recepcion-admin.php' + action, // Reemplaza "tu_archivo_de_backend.php" con tu ruta de backend
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
});

// Mostrar mensajes de error desde la sesión
$(document).ready(function () {
  if (errorMessage) {
    toastr.error(errorMessage);
  }
});
