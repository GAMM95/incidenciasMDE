$(document).ready(function () {
  // Configuración de Toastr
  toastr.options = {
    "positionClass": "toast-bottom-right",
    "progressBar": true,
    "timeOut": "2000"
  };

  // SETEO DE COMBO usuario
  $.ajax({
    url: 'ajax/getPersonaAuditoria.php',
    type: 'GET',
    dataType: 'json',
    success: function (data) {
      var select = $('#usuarioEventoPersonas');
      select.empty();
      select.append('<option value="" selected disabled>Seleccione un usuario</option>');
      $.each(data, function (index, value) {
        select.append('<option value="' + value.USU_codigo + '">' + value.persona + '</option>');
      });
    },
    error: function (error) {
      console.error(error);
    }
  });

  // Setear campos del usuario seleccionado
  $('#usuarioEventoPersonas').change(function () {
    var selectedOption = $(this).find('option:selected');
    var codigoUsuario = selectedOption.val();
    var nombreUsuario = selectedOption.text();
    $('#codigoUsuarioEventoPersonas').val(codigoUsuario);
    $('#nombreUsuarioEventoPersonas').val(nombreUsuario);
  });

  // Buscador para el combo usuario
  $('#usuarioEventoPersonas').select2({
    allowClear: true,
    width: '100%',
    dropdownCssClass: 'text-xs', // Use Tailwind CSS class
    language: {
      noResults: function () {
        return "No se encontraron resultados";
      }
    }
  });

  // Función para realizar la consulta sin filtros (nueva consulta)
  function nuevaConsultaEventosPersonas() {
    // Limpiar los campos de fecha y el input de persona (resetea el formulario)
    $('#fechaInicioEventosPersonas').val('');
    $('#fechaFinEventosPersonas').val('');
    $('#usuarioEventoPersonas').val(null).trigger('change');  // Reset del select2 con trigger

    // Realizar la solicitud AJAX para obtener todos los registros (sin filtros)
    $.ajax({
      url: 'auditoria.php?action=consultarEventosPersonas',
      type: 'GET',
      dataType: 'html', // Esperamos HTML para renderizar la tabla
      success: function (response) {
        console.log("Resultados de nueva consulta (sin filtros):", response);
        // Limpia el contenido actual de la tabla antes de agregar nuevos datos
        $('#tablaEventosPersonas tbody').empty();
        // Actualiza el contenido de la tabla con la respuesta
        $('#tablaEventosPersonas tbody').html(response);
      },
      error: function (xhr, status, error) {
        console.error('Error en la consulta AJAX:', error);
      }
    });
  }

  // Evento para el botón de limpiar campos
  $('#limpiarCamposEventosPersonas').on('click', nuevaConsultaEventosPersonas);

  // Validación y envío del formulario
  $('#formAuditoriaPersonas').submit(function (event) {
    event.preventDefault(); // Evita el envío del formulario por defecto

    // Verifica si los campos y las fechas son válidos
    if (!validarCamposEventosPersonas() || !validarFechasEventosPersonas()) {
      return; // Detiene el envío si los campos o las fechas no son válidos
    }

    var formData = $(this).serializeArray(); // Recopila los datos del formulario
    var dataObject = {}; // Crea un objeto para los datos del formulario
    console.log(dataObject);

    // Recorre los datos del formulario y llena el objeto con los valores
    formData.forEach(function (item) {
      if (item.value.trim() !== '') {
        dataObject[item.name] = item.value;
      }
    });

    // Realiza la solicitud AJAX
    $.ajax({
      url: 'auditoria.php?action=consultarEventosPersonas',
      type: 'GET',
      data: dataObject,
      success: function (response) {
        console.log("Resultados filtrados:", response);
        $('#tablaEventosPersonas tbody').empty(); // Limpia el contenido actual de la tabla antes de agregar nuevos datos
        $('#tablaEventosPersonas tbody').html(response); // Actualiza el contenido de la tabla con la respuesta
      },
      error: function (xhr, status, error) {
        console.error('Error en la consulta AJAX:', error);
      }
    });

    // Función para validar los campos de usuario y fechas
    function validarCamposEventosPersonas() {
      var valido = false;
      var mensajeError = '';

      var faltaUsuario = ($('#usuarioEventoPersonas').val() !== null && $('#usuarioEventoPersonas').val().trim() !== '');
      var fechaInicioSeleccionada = ($('#fechaInicioEventosPersonas').val() !== null && $('#fechaInicioEventosPersonas').val().trim() !== '');
      var fechaFinSeleccionada = ($('#fechaFinEventosPersonas').val() !== null && $('#fechaFinEventosPersonas').val().trim() !== '');

      // Verificar si al menos un campo está lleno
      if (faltaUsuario || fechaInicioSeleccionada || fechaFinSeleccionada) {
        valido = true;
      } else {
        mensajeError = 'Debe completar al menos un campo para filtrar la tabla.';
      }

      if (!valido) {
        toastr.warning(mensajeError.trim(), 'Advertencia');
      }

      return valido;
    }
  });

  // Función para validar fechas
  function validarFechasEventosPersonas() {
    const fechaInicio = new Date($('#fechaInicioEventosPersonas').val());
    const fechaFin = new Date($('#fechaFinEventosPersonas').val());
    const fechaHoy = new Date();

    let valido = true;
    let mensajeError = '';

    if (fechaInicio > fechaHoy) {
      mensajeError = 'La fecha de inicio no puede ser posterior a la fecha actual.';
      valido = false;
    }

    if (fechaFin > fechaHoy) {
      mensajeError = 'La fecha fin no puede ser posterior a la fecha actual.';
      valido = false;
    }

    if (fechaInicio && fechaFin && fechaFin < fechaInicio) {
      mensajeError = 'La fecha fin debe ser posterior a la fecha de inicio.';
      valido = false;
    }

    if (!valido) {
      toastr.warning(mensajeError.trim(), 'Advertencia');
    }

    return valido;
  }

  // Agregar eventos para validar fechas cuando cambien
  $('#fechaInicioEventosPersonas, #fechaFinEventosPersonas').on('change', function () {
    validarFechasEventosPersonas();
  });
});
