// TODO: SETEO DE COMBO AREA
$(document).ready(function () {
  console.log("FETCHING")
  $.ajax({
    url: 'ajax/getAreaData.php',
    type: 'GET',
    dataType: 'json',
    success: function (data) {
      var select = $('#area');
      select.empty();
      select.append('<option value="" selected disabled>Seleccione un &aacute;rea</option>');
      $.each(data, function (index, value) {
        select.append('<option value="' + value.ARE_codigo + '">' + value.ARE_nombre + '</option>');
      });
      if (areaRegistrada !== '') {
        select.val(areaRegistrada);
      } else {
        select.val('');
      }
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
      var select = $('#categoria');
      select.empty();
      select.append('<option value="" selected disabled>Seleccione una categor&iacute;a</option>');
      $.each(data, function (index, value) {
        select.append('<option value="' + value.CAT_codigo + '">' + value.CAT_nombre + '</option>');
      });
      if (categoriaRegistrada !== '') {
        select.val(categoriaRegistrada);
      } else {
        select.val('');
      }
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

// TODO: CAMBIAR PAGINAS DE LA TABLA DE INCIDENCIAS
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

// TODO: GUARDAR INCIDENCIA
$(document).ready(function () {
  $('#guardar-incidencia').click(function (event) {
    event.preventDefault();

    // Validar campos antes de enviar
    if (!validarCampos()) {
      return; // si hay campos invalidos, detener el envio
    }

    var form = $('#formIncidencia');
    var data = form.serialize();
    console.log(data); // verifica las veces de envio

    var action = form.attr('action');
    $.ajax({
      url: action,
      type: "POST",
      data: data,
      success: function (response) {
        if (action === 'registro-incidencia-admin.php?action=registrar') {
          toastr.success('Incidencia registrada');
        } else if (action === 'registro-incidencia-admin.php?action=editar') {
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

  // FUNCION PARA VALIDAR LOS CAMPOS ANTES DE ENVIAR
  function validarCampos() {
    var valido = true;
    var mensajeError = '';

    // validar combos
    var faltaCategoria = ($('#categoria').val() === null || $('#categoria').val() === '');
    var faltaArea = ($('#area').val() === null || $('#area').val() === '');
    var faltaAsunto = ($('#asunto').val() === null || $('#asunto').val() === '');
    var faltaDocumento = ($('#documento').val() === null || $('#documento').val() === '');


    if (faltaCategoria && faltaArea && faltaAsunto && faltaDocumento) {
      mensajeError += 'Debe completar los campos requeridos.';
      valido = false;
    } else if (faltaCategoria) {
      mensajeError += 'Debe seleccionar una categoria.';
      valido = false;
    } else if (faltaArea) {
      mensajeError += 'Debe seleccionar un area.';
      valido = false;
    } else if (faltaAsunto) {
      mensajeError += 'Ingrese asunto de la incidencia.';
      valido = false;
    } else if (faltaDocumento) {
      mensajeError += 'Ingrese documento de la incidencia';
      valido = false;
    }

    // Mostrar mensaje de error si hay
    if (!valido) {
      toastr.error(mensajeError.trim());
    }
    return valido;
  }
});
