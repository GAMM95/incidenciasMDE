$(document).ready(function () {
  console.log("FETCHING PERSONAS");
  $.ajax({
    url: 'ajax/getPersona.php',
    type: 'GET',
    dataType: 'json',
    success: function (data) {
      var select = $('#cbo_persona');
      select.empty();
      $.each(data, function (index, value) {
        console.log(value); // Añade esta línea para depurar y verificar las claves recibidas
        select.append('<option value="' + value.PER_codigo + '">' + value.persona + '</option>'); // Ajuste aquí
      });
      document.getElementById('cbo_persona').value = '<?php echo isset($usuarioRegistrado) ? $usuarioRegistrado["PER_codigo"] : ""; ?>';
    },
    error: function (error) {
      console.error(error);
    }
  })
});

$(document).ready(function () {
  console.log("FETCHING AREAS");
  $.ajax({
    url: 'ajax/getAreaData.php',
    type: 'GET',
    dataType: 'json',
    success: function (data) {
      var select = $('#cbo_area');
      select.empty();
      $.each(data, function (index, value) {
        console.log(value); // Añade esta línea para depurar y verificar las claves recibidas
        select.append('<option value="' + value.ARE_codigo + '">' + value.ARE_nombre + '</option>'); // Ajuste aquí
      });
      document.getElementById('cbo_area').value = '<?php echo isset($usuarioRegistrado) ? $usuarioRegistrado["PER_codigo"] : ""; ?>';
    },
    error: function (error) {
      console.error(error);
    }
  })
});

$(document).ready(function () {
  console.log("FETCHING AREAS");
  $.ajax({
    url: 'ajax/getRol.php',
    type: 'GET',
    dataType: 'json',
    success: function (data) {
      var select = $('#cbo_rol');
      select.empty();
      $.each(data, function (index, value) {
        console.log(value); // Añade esta línea para depurar y verificar las claves recibidas
        select.append('<option value="' + value.ROL_codigo + '">' + value.ROL_nombre + '</option>'); // Ajuste aquí
      });
      document.getElementById('cbo_rol').value = '<?php echo isset($usuarioRegistrado) ? $usuarioRegistrado["PER_codigo"] : ""; ?>';
    },
    error: function (error) {
      console.error(error);
    }
  })
});


$(document).ready(function () {
  // Evento de clic en una fila de la tabla
  $('tr').click(function () {
    var cod = $(this).find('th').data('cod');
    var dni = $(this).find('td[data-dni]').text();
    var nombreCompleto = $(this).find('td[data-nombre]').text();
    var celular = $(this).find('td[data-celular]').text();
    var email = $(this).find('td[data-email]').text();

    // Separar el nombre completo en partes: nombre, apellido paterno y apellido materno
    var partesNombre = nombreCompleto.split(' ');
    var nombre = partesNombre[0];
    var apellidoPaterno = partesNombre[1];
    var apellidoMaterno = partesNombre[2];

    // Establecer los valores en los campos del formulario
    $('#txt_codPersona').val(cod);
    $('#txt_dni').val(dni);
    $('#txt_nombre').val(nombre);
    $('#txt_apellidoPaterno').val(apellidoPaterno);
    $('#txt_apellidoMaterno').val(apellidoMaterno);
    $('#txt_celular').val(celular);
    $('#txt_email').val(email);

    // Aplicar estilos de selección a la fila seleccionada y quitarlos de las demás filas
    $('tr').removeClass('bg-blue-200 font-semibold'); // Limpiar estilos
    $(this).addClass('bg-blue-200 font-semibold'); // Aplicar estilos a la fila seleccionada
  })
});