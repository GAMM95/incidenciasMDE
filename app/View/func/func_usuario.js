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
      select.append('<option value="" selected disabled>Seleccione una persona</option>');
      $.each(data, function (index, value) {
        select.append('<option value="' + value.PER_codigo + '">' + value.persona + '</option>');
      });
    },
    error: function (error) {
      console.error("Error fetching personas:", error);
    }
  });

  // Fetch áreas
  console.log("FETCHING AREAS");
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
      console.error("Error fetching areas:", error);
    }
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
      select.append('<option value="" selected disabled>Seleccione un rol</option>');
      $.each(data, function (index, value) {
        select.append('<option value="' + value.ROL_codigo + '">' + value.ROL_nombre + '</option>');
      });
    },
    error: function (error) {
      console.error("Error fetching roles:", error);
    }
  });

  // Evento de clic en una fila de la tabla
  $('table').on('click', 'tr', function () {
    var cod = $(this).find('td[data-codusuario]').data('codusuario');

    var codPersona = $(this).find('td[data-codpersona]').data('persona');
    var codArea = $(this).find('td[data-area]').data('codarea');
    var codRol = $(this).find('td[data-codrol]').data('codrol');
    var usuario = $(this).find('td[data-usuario]').text();
    var password = $(this).find('td[data-password]').text();

    $('#txt_codigoUsuario').val(cod);
    $('#cbo_persona').val(codPersona);
    $('#cbo_area').val(codArea);
    $('#cbo_rol').val(codRol);
    $('#txt_nombreUsuario').val(usuario);
    $('#txt_password').val(password);

    $('tr').removeClass('bg-blue-200 font-semibold');
    $(this).addClass('bg-blue-200 font-semibold');
  });

  // Validación del formulario
  $('#formUsuario').on('submit', function (e) {
    e.preventDefault();
    var valid = true;

    if ($('#cbo_persona').val() === '') {
      valid = false;
      toastr.error('Por favor, seleccione una persona.');
    }

    if ($('#cbo_area').val() === '') {
      valid = false;
      toastr.error('Por favor, seleccione un área.');
    }

    if ($('#cbo_rol').val() === '') {
      valid = false;
      toastr.error('Por favor, seleccione un rol.');
    }

    if ($('#txt_nombreUsuario').val() === '' || !$('#txt_nombreUsuario').val().match(/^\d{1,8}$/)) {
      valid = false;
      toastr.error('Por favor, ingrese un nombre de usuario válido.');
    }

    if ($('#txt_password').val() === '') {
      valid = false;
      toastr.error('Por favor, ingrese una contraseña.');
    }

    if (valid) {
      this.submit();
    }
  });
});
