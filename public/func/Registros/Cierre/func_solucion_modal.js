$(document).ready(function () {
  // Configuración de toastr
  toastr.options = {
    "positionClass": "toast-bottom-right",
    "progressBar": true,
    "timeOut": "2000"
  };

  $('#agregar-solucion').on('click', function (e) {
    e.preventDefault();
    agregarSolucion();
  });

  // Evento para agregar nueva solución al presionar "Enter"
  $('#form-solucion').on('keydown', function (e) {
    if (e.key === 'Enter') {
      e.preventDefault(); // Prevenir el envío por defecto del formulario
      agregarSolucion();
    }
  });

  // Evento para limpiar y resetear el modal al cerrarlo
  $('#solucionModal').on('hidden.bs.modal', function () {
    $(this).find('form').trigger('reset'); // Limpia los campos del formulario
    $(this).find('.is-invalid').removeClass('is-invalid'); // Elimina clases de validación anteriores
  });
});

// Función para agregar solución y actualizar el select
function agregarSolucion() {
  if (!validarCamposSolucion()) {
    return; // Salir si la validación de registro falla
  }

  var url = 'registro-cierre.php?action=agregar-solucion';
  var data = $('#form-solucion').serialize();

  $.ajax({
    url: url,
    method: 'POST',
    data: data,
    dataType: 'text',
    success: function (response) {
      console.log('Raw response:', response);
      // Convertir la respuesta en un objeto JSON
      try {
        var jsonResponse = JSON.parse(response);
        console.log('Parsed JSON:', jsonResponse);

        if (jsonResponse.success) {
          toastr.success(jsonResponse.message, 'Mensaje');

          // Cerrar el modal
          $('#solucionModal').modal('hide');
           // Llamar a la función global para actualizar el select de soluciones
           if (typeof actualizarSelectSoluciones === 'function') {
            actualizarSelectSoluciones(); // Llama a la función de actualizar el select
          } else {
            console.error('La función actualizarSelectSoluciones no está definida.');
          }
        } else {
          toastr.warning(jsonResponse.message, 'Advertencia');
        }
      } catch (e) {
        console.error('JSON parsing error:', e);
        toastr.error('Error al procesar la respuesta.', 'Mensaje de error');
      }
    },
    error: function (xhr, status, error) {
      console.error('AJAX Error:', error);
      toastr.error('Error en la solicitud AJAX.', 'Mensaje de error');
    }
  });
}

// Validar campos de registro de cierre antes de enviar formulario
function validarCamposSolucion() {
  var valido = true;
  var mensajeError = '';

  var faltaDescripcion = ($('#descripcionSolucion').val() === null || $('#descripcionSolucion').val() === '');

  if (faltaDescripcion) {
    mensajeError += 'Debe ingresar una nueva soluci&oacute;n.';
    valido = false;
  }

  // Mostrar el mensaje de error si hay
  if (!valido) {
    toastr.warning(mensajeError.trim(), 'Advertencia');
  }
  return valido;
}