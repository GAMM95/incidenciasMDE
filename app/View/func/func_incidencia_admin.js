

// TODO: SETEO DE COMBO AREA
$(document).ready(function () {
  console.log("FETCHING")
  $.ajax({
    url: 'ajax/getAreaData.php',
    type: 'GET',
    dataType: 'json',
    success: function (data) {
      var select = $('#cbo_area');
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
  console.log("FETCHING");
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

      // Verificar y establecer el valor seleccionado
      if (categoriaRegistrada !== '') {
        select.val(categoriaRegistrada);
      } else {
        select.val('');
      }
    },
    error: function (error) {
      console.error('Error en la carga de categorías:', error);
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
    var faltaCategoria = ($('#cbo_categoria').val() === null || $('#cbo_categoria').val() === '');
    var faltaArea = ($('#cbo_area').val() === null || $('#cbo_area').val() === '');
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