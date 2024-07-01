$(document).ready(function () {
  console.log("FETCHING")
  $.ajax({
    url: 'ajax/getAreaData.php',
    type: 'GET',
    dataType: 'json',
    success: function (data) {
      var select = $('#cbo_area');
      select.empty();
      select.append('<option value="" selected disabled>Seleccione un área</option>');
      $.each(data, function (index, value) {
        select.append('<option value="' + value.ARE_codigo + '">' + value.ARE_nombre + '</option>');
      });
      document.getElementById('area').value = '<?php echo $incidenciaRegistrada ? $incidenciaRegistrada["ARE_codigo"] : "; ?>';
    },
    error: function (error) {
      console.error(error);
    }
  });
});

// TODO: SETEO DEL COMBO CATEGORIA
$(document).ready(function () {
  console.log("FETCHING")
  $.ajax({
    url: 'ajax/getCategoryData.php',
    type: 'GET',
    dataType: 'json',
    success: function (data) {
      var select = $('#cbo_categoria');
      select.empty();
      select.append('<option value="" selected disabled>Seleccione una categoría</option>');
      $.each(data, function (index, value) {
        select.append('<option value="' + value.CAT_codigo + '">' + value.CAT_nombre + '</option>');
      });
      document.getElementById('categoria').value = '<?php echo $incidenciaRegistrada ? $incidenciaRegistrada["CAT_codigo"] : "; ?>';
    },
    error: function (error) {
      console.error(error);
    }
  });
});


$(document).ready(function () {
  console.log("FETCHING")
  $.ajax({
    url: '../../../ajax/getLastIncidencia.php',
    type: 'GET',
    dataType: 'json',
    success: function (data) {
      console.log(data);
      var select = $('#numero_incidencia');
      if (select.val() === '') {
        select.empty();
        select.val(data.INC_numero);
      }
    },
    error: function (error) {
      console.error(error);
    }
  });
});

function changePage(page) {
  // Realizar la petición AJAX
  fetch(`?page=${page}`)
    .then(response => response.text())
    .then(data => {
      // Actualizar el contenido de la tabla y de la paginación
      const parser = new DOMParser();
      const newDocument = parser.parseFromString(data, 'text/html');
      const newTable = newDocument.querySelector('table');
      const newPagination = newDocument.querySelector('.flex.justify-center.items-center.mt-4');

      // Reemplazar la tabla y la paginación actual
      const currentTable = document.querySelector('table');
      currentTable.parentNode.replaceChild(newTable, currentTable);

      const currentPagination = document.querySelector('.flex.justify-center.items-center.mt-4');
      currentPagination.parentNode.replaceChild(newPagination, currentPagination);
    })
    .catch(error => {
      console.error('Error al cambiar de página:', error);
    });
}



function limpiarCampos() {
  // Obtener el formulario por su ID
  const form = document.getElementById('formIncidencia');
  // Limpiar los campos del formulario
  form.reset();
}
const btnLimpiar = document.getElementById('limpiarCampos');
btnLimpiar.addEventListener('click', limpiarCampos);

function nuevoRegistro() {
  const form = document.getElementById('formIncidencia');

  // Restablecer el formulario
  form.reset();
}
// Asignar el evento 'click' al botón 'Nuevo Registro'
const btnNuevo = document.getElementById('nuevoRegistro');
btnNuevo.addEventListener('click', nuevoRegistro);

//GUARDAR DATOS
$(document).ready(function () {
  $("#guardar-incidencia").on("click", function () {
    var formData = $("form").serialize();

    $.ajax({
      url: 'registro-incidencia-admin.php' + action,
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
        console.error(xhr.responseText);
        toastr.error('Error al guardar la incidencia');
      }
    });
  });
});