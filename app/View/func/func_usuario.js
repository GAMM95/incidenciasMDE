$(document).ready(function () {
  $(document).ready(function () {
    // Fetch personas
    console.log("FETCHING PERSONAS");
    $.ajax({
      url: 'ajax/getPersona.php',
      type: 'GET',
      dataType: 'json',
      success: function (data) {
        var select = $('#cbo_persona');
        select.empty();
        // Agregar la opción "Seleccione una persona" al principio
        select.append('<option value="" selected disabled>Seleccione una persona</option>');
        // Llenar el select con los datos recibidos
        $.each(data, function (index, value) {
          console.log(value); // Verificar las claves recibidas
          select.append('<option value="' + value.PER_codigo + '">' + value.persona + '</option>');
        });
        // Seleccionar la opción predeterminada, si está definida
        var usuarioRegistrado = '<?php echo isset($usuarioRegistrado) ? $usuarioRegistrado["PER_codigo"] : ""; ?>';
        if (usuarioRegistrado !== "") {
          $('#cbo_persona').val(usuarioRegistrado);
        }
      },
      error: function (error) {
        console.error("Error fetching personas:", error);
      }
    });
  });

  $(document).ready(function () {
    // Fetch áreas
    console.log("FETCHING AREAS");
    $.ajax({
      url: 'ajax/getAreaData.php',
      type: 'GET',
      dataType: 'json',
      success: function (data) {
        var select = $('#cbo_area');
        select.empty();
        // Agregar la opción "Seleccione un área" al principio
        select.append('<option value="" selected disabled>Seleccione un área</option>');
        // Llenar el select con los datos recibidos
        $.each(data, function (index, value) {
          console.log(value); // Depurar y verificar las claves recibidas
          select.append('<option value="' + value.ARE_codigo + '">' + value.ARE_nombre + '</option>');
        });
        // Seleccionar la opción "Seleccione un área"
        $('#cbo_area').val('');
      },
      error: function (error) {
        console.error("Error fetching areas:", error);
      }
    });
  });


  // Fetch roles
  console.log("FETCHING ROLES");
  $.ajax({
    url: 'ajax/getRol.php',
    type: 'GET',
    dataType: 'json',
    success: function (data) {
      var select = $('#cbo_rol');
      select.empty();
      $.each(data, function (index, value) {
        console.log(value); // Depurar y verificar las claves recibidas
        select.append('<option value="' + value.ROL_codigo + '">' + value.ROL_nombre + '</option>');
      });
      $('#cbo_rol').val('<?php echo isset($usuarioRegistrado) ? $usuarioRegistrado["PER_codigo"] : ""; ?>');
    },
    error: function (error) {
      console.error("Error fetching roles:", error);
    }
  });

  // Evento de clic en una fila de la tabla
  $('table').on('click', 'tr', function () {
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
    $('#txt_codUsuario').val(cod);
    $('#txt_dni').val(dni);
    $('#txt_nombre').val(nombre);
    $('#txt_apellidoPaterno').val(apellidoPaterno);
    $('#txt_apellidoMaterno').val(apellidoMaterno);
    $('#txt_celular').val(celular);
    $('#txt_email').val(email);

    // Aplicar estilos de selección a la fila seleccionada y quitarlos de las demás filas
    $('tr').removeClass('bg-blue-200 font-semibold'); // Limpiar estilos
    $(this).addClass('bg-blue-200 font-semibold'); // Aplicar estilos a la fila seleccionada
  });
});
