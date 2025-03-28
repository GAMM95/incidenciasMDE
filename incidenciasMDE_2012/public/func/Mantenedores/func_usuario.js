$(document).ready(function () {
  // Configuración de Toastr
  toastr.options = {
    "positionClass": "toast-bottom-right",
    "progressBar": true,
    "timeOut": "2000"
  };

  // Evento para manejar la tecla Enter cuando una fila está seleccionada
  $(document).on('keydown', function (e) {
    // Verificar si la tecla presionada es Enter
    if (e.key === 'Enter') {
      // Si la fila está seleccionada, proceder a actualizar
      if ($('.bg-blue-200.font-semibold').length > 0) {
        e.preventDefault();
        enviarFormulario('editar');
      }
    }
  });

  $(document).keydown(function (event) {
    // Verificar si la tecla presionada es ESC
    if (event.key === 'Escape') {
      nuevoRegistro();
    }
  });

  // Carga de datos en el combo persona
  $.ajax({
    url: 'ajax/getPersona.php',
    type: 'GET',
    dataType: 'json',
    success: function (data) {
      var select = $('#persona');
      select.empty();
      select.append('<option value="" selected disabled>Seleccione una persona</option>');
      $.each(data, function (index, value) {
        select.append('<option value="' + value.PER_codigo + '">' + value.persona + '</option>');
      });
    },
    error: function (error) {
      console.error("Error fetching personas:", error);
    }
  });

  // Evento para capturar el cambio de selección en el combo de persona
  $('#persona').on('change', function () {
    var selectedCodigo = $(this).val(); // Obtener el valor del option seleccionado (PER_codigo)
    $('#codigoPersona').val(selectedCodigo); // Establecer el valor en el input hidden
  });

  // Carga de datos en el combo area
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
    },
    error: function (error) {
      console.error("Error fetching areas:", error);
    }
  });

  // Carga de datos en el combo rol
  $.ajax({
    url: 'ajax/getRol.php',
    type: 'GET',
    dataType: 'json',
    success: function (data) {
      var select = $('#rol');
      select.empty();
      select.append('<option value="" selected disabled>Seleccione un rol</option>');
      $.each(data, function (index, value) {
        select.append('<option value="' + value.ROL_codigo + '">' + value.ROL_nombre + '</option>');
      });
    },
    error: function (error) {
      console.error("Error fetching roles:", error);
    }
  });

  // Buscador para los combos persona, area y rol
  $('#persona, #area, #rol').select2({
    allowClear: true,
    width: '100%',
    dropdownCssClass: 'text-xs',
    language: {
      noResults: function () {
        return "No se encontraron resultados";
      }
    }
  });

  // Evento para guardar al usuario
  $('#guardar-usuario').on('click', function (e) {
    e.preventDefault();
    enviarFormulario($('#form-action').val());
  });

  // Evento para editar usuario
  $('#editar-usuario').on('click', function (e) {
    e.preventDefault();
    console.log('Botón editar clickeado');
    enviarFormulario('editar');
  });

  // Evento para nuevo registro
  $('#nuevo-registro').on('click', nuevoRegistro);

});


// Metodo para enviar formulario
function enviarFormulario(action) {
  if (action === 'registrar') {
    if (!validarCamposRegistroUsuario()) {
      return;
    }
  }

  var url = 'modulo-usuario.php?action=' + action;
  var data = $('#formUsuario').serialize();
  console.log('Datos enviados:', data); // Añadir esta línea para depuración

  $.ajax({
    url: url,
    method: 'POST',
    data: data,
    dataType: 'text',
    success: function (response) {
      try {
        var jsonResponse = JSON.parse(response);
        console.log('Parsed JSON:', jsonResponse);

        if (jsonResponse.success) {
          if (action === 'registrar') {
            toastr.success(jsonResponse.message, 'Mensaje');
          } else if (action === 'editar') {
            toastr.success(jsonResponse.message, 'Mensaje');
          }
          setTimeout(function () {
            location.reload();
          }, 1500);
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

// Función para validar campos antes de enviar
function validarCamposRegistroUsuario() {
  var valido = true;
  var mensajeError = '';

  // Validar campos
  var faltaPersona = ($('#persona').val() === null || $('#persona').val() === '');
  var faltaArea = ($('#area').val() === null || $('#area').val() === '');
  var faltaRol = ($('#rol').val() === null || $('#rol').val() === '');
  var faltaUsername = ($('#username').val() === null || $('#username').val() === '');
  var faltaPassword = ($('#password').val() === null || $('#password').val() === '');

  if (faltaPersona && faltaArea && faltaRol && faltaUsername && faltaPassword) {
    mensajeError += 'Debe completar todos los campos.';
    valido = false;
  } else if (faltaPersona) {
    mensajeError += 'Debe seleccionar un trabajador.';
    valido = false;
  } else if (faltaArea) {
    mensajeError += 'Debe seleccionar un &aacute;rea.';
    valido = false;
  } else if (faltaRol) {
    mensajeError += 'Debe seleccionar un rol.';
    valido = false;
  } else if (faltaUsername) {
    mensajeError += 'Debe ingresar un nombre de usuario.';
    valido = false;
  } else if (faltaPassword) {
    mensajeError += 'Debe ingresar una contrase&ntilde;a.';
    valido = false;
  }

  // Mostrar mensaje de error si hay
  if (!valido) {
    toastr.warning(mensajeError.trim(), 'Advertencia');
  }
  return valido;
}

// Seteo de valores en los inputs y combos
$(document).on('click', '#tablaListarUsuarios tbody tr', function () {
  $('#tablaListarUsuarios tbody tr').removeClass('bg-blue-200 font-semibold');
  $(this).addClass('bg-blue-200 font-semibold');

  // Establecer valores en el formulario según la fila seleccionada
  const celdas = $(this).find('td');
  const codUsuario = $(this).find('th').text().trim();
  const personaValue = celdas.eq(2).text().trim();
  const areaValue = celdas.eq(3).text().trim();
  const usernameValue = celdas.eq(4).text().trim();
  const passwordValue = celdas.eq(11).text().trim();
  const rolValue = celdas.eq(6).text().trim();

  // Seteo del codigo de usuario en el formulario principal
  $('#CodUsuario').val(codUsuario);
  $('#username').val(usernameValue);
  $('#password').val(passwordValue);

  // Setear código de usuario en el modal
  $('#codigoUsuarioModal').val(codUsuario); // Asumiendo que el modal tiene un input con id modalCodUsuario
  $('#usernameModal').val(usernameValue);
  $('#nombreModal').val(personaValue);

  setComboValue('persona', personaValue);
  setComboValue('area', areaValue);
  setComboValue('rol', rolValue);

  // Bloquear el combo de persona
  $('#persona').prop('disabled', true);

  // Bloquear el campo de contraseña
  $('#password').prop('disabled', true);  // Desactivar el campo de contraseña

  // Cambiar estado de los botones
  $('#guardar-usuario').prop('disabled', true);
  $('#editar-usuario').prop('disabled', false);
  $('#nuevo-registro').prop('disabled', false);
  // Activar el botón del modal al seleccionar una fila
  $('#botonModalCambiarPassword').prop('disabled', false);  // Activar el botón modal

  // Cambiar la acción a editar
  $('#form-action').val('editar');
});

function setComboValue(comboId, value) {
  const select = document.getElementById(comboId);
  const options = select.options;

  let valueFound = false;
  for (let i = 0; i < options.length; i++) {
    if (options[i].text.trim() === value) {
      select.value = options[i].value;
      valueFound = true;
      break;
    }
  }
  if (!valueFound) {
    select.value = '';
  }
  $(select).trigger('change');
}

// Función para limpiar los campos del formulario y reactivar tablas
function nuevoRegistro() {
  document.getElementById('formUsuario').reset(); // Resetear el formulario completo

  // Limpiar los valores específicos de inputs y combos
  $('#CodUsuario').val('');
  $('#username').val('');
  $('#password').val('');

  // Limpiar los combos y forzar la actualización con Select2
  $('#persona').val('').trigger('change');
  $('#area').val('').trigger('change');
  $('#rol').val('').trigger('change');

  // Remover clases de selección y estilos de todas las filas de ambas tablas
  $('tr').removeClass('bg-blue-200 font-semibold');

  // Reactivar ambas tablas
  $('#tablaListarUsuarios tbody tr').removeClass('pointer-events-none opacity-50');

  // Desbloquear el combo de persona
  $('#persona').prop('disabled', false);

  // Activar el campo de contraseña
  $('#password').prop('disabled', false);  // Activar el campo de contraseña

  // Configurar los botones en su estado inicial
  $('#form-action').val('registrar');  // Cambiar la acción a registrar
  $('#guardar-usuario').prop('disabled', false);  // Activar el botón de guardar
  $('#editar-usuario').prop('disabled', true);    // Desactivar el botón de editar
  $('#nuevo-registro').prop('disabled', false);     // Asegurarse que el botón de nuevo registro está activo
  // Desactivar el botón del modal al crear un nuevo registro
  $('#botonModalCambiarPassword').prop('disabled', true);  // Desactivar el botón modal
}

// función para filtrar la tabla de trabajadores
function filtrarTablaUsuario() {
  var input, filtro, tabla, filas, celdas, i, j, match;
  input = document.getElementById('termino');
  filtro = input.value.toUpperCase();
  tabla = document.getElementById('tablaListarUsuarios');
  filas = tabla.getElementsByTagName('tr');

  for (i = 1; i < filas.length; i++) {
    celdas = filas[i].getElementsByTagName('td');
    match = false;
    for (j = 0; j < celdas.length; j++) {
      if (celdas[j].innerText.toUpperCase().indexOf(filtro) > -1) {
        match = true;
        break;
      }
    }
    filas[i].style.display = match ? '' : 'none';
  }
}

// Habilitar y desahbilitar usuario
$(document).ready(function () {
  $('.switch-usuario').on('change', function () {
    var isChecked = $(this).is(':checked');
    var usuarioCodigo = $(this).data('id');
    var url = isChecked ? 'modulo-usuario.php?action=habilitar' : 'modulo-usuario.php?action=deshabilitar';

    $.ajax({
      url: url,
      type: 'POST',
      data: {
        codigoUsuario: usuarioCodigo
      },
      dataType: 'json',
      success: function (response) {
        console.log('Estado: ', usuarioCodigo);
        var jsonResponse = JSON.parse(response);
        console.log('Parsed JSON:', jsonResponse);

        if (response.success) {
          toastr.success(jsonResponse.message);
          setTimeout(function () {
            location.reload();
          }, 1000);
        } else {
          toastr.error(jsonResponse.message);
        }
      },
      error: function (xhr, status, error) {
        toastr.success('Estado de usuario actualizado.', 'Mensaje');
        setTimeout(function () {
          location.reload();
        }, 1000);
      }
    });
  });
});

function uppercaseInput(element) {
  element.value = element.value.toUpperCase();
}
