<!doctype html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="public/assets/logo.ico">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
  <script src="https://code.jquery.com/jquery-3.7.0.min.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700" rel="stylesheet">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
  <title class="text-center text-3xl font-poppins">Sistema de Incidencias</title>
</head>

<body class="bg-green-50 flex items-center justify-center min-h-screen overflow-x-hidden">

  <!-- Contenido principal -->
  <main class="bg-[#eeeff1] flex-1 p-4 overflow-y-auto">
    <!-- Header -->
    <h1 class="text-2xl font-bold mb-4">M&oacute;dulo / Usuario</h1>

    <form id="formUsuario" action="modulo-usuario.php" method="POST" class="border bg-white shadow-md p-6 w-full text-sm rounded-md">
      <input type="hidden" id="form-action" name="action" value="registrar">

      <!-- PRIMERA FILA Campo para mostrar el número de incidencia -->
      <div class="flex justify-center -mx-2 mb-5">
        <div class="w-full sm:w-1/4 px-2 mb-2">
          <div class="flex items-center">
            <label for="CodPersona" class="block font-bold mb-1 mr-3 text-lime-500">C&oacute;digo de Usuario:</label>
            <input type="text" id="txt_codUsuario" name="CodUsuario" class="w-20 border border-gray-200 bg-gray-100 rounded-md p-2 text-sm text-center" readonly disabled>
          </div>
        </div>
      </div>

      <!-- SEGUNDA fila: DNI, Nombres, Apellido Paterno y Apellido Materno -->
      <div class="flex flex-wrap -mx-2">
        <div class="w-full sm:w-1/3 px-2 mb-2">
          <label for="CodPersona" class="block mb-1 font-bold text-sm">Persona:</label>
          <select id="cbo_persona" name="CodPersona" class="border p-2 w-full text-sm">
          </select>
        </div>
        <div class="w-full sm:w-1/3 px-2 mb-2">
          <label for="CodPersona" class="block mb-1 font-bold text-sm">&Aacute;rea:</label>
          <select id="cbo_area" name="CodArea" class="border p-2 w-full text-sm">
          </select>
        </div>
        <div class="w-full sm:w-1/3 px-2 mb-2">
          <label for="CodRol" class="block mb-1 font-bold text-sm">Rol:</label>
          <select id="cbo_rol" name="CodRol" class="border p-2 w-full text-sm">
            <?php
            ?>
          </select>
        </div>
      </div>

      <!-- CUARTA fila: Celular, Email -->
      <div class="flex flex-wrap -mx-2">
        <div class="w-full sm:w-1/4 px-2 mb-2">
          <label for="dni" class="block mb-1 font-bold text-sm">Usuario:</label>
          <input type="text" id="txt_dni" name="dni" class="border p-2 w-full text-sm" maxlength="8" pattern="\d{1,8}" title="Ingrese solo dígitos" required>
        </div>

        <div class="w-full sm:w-1/4 px-2 mb-2">
          <label for="nombre" class="block mb-1 font-bold text-sm">Contrase&ntilde;a:</label>
          <input type="text" id="txt_nombre" name="nombre" class="border p-2 w-full text-sm" required>
        </div>
      </div>

      <!-- Botónes -->
      <div class="flex justify-center space-x-4 mt-2 mb-2">
        <button type="submit" id="guardar-usuario" class="bg-[#87cd51] text-white font-bold hover:bg-[#8ce83c] py-2 px-4 rounded">
          Guardar
        </button>
        <button type="button" id="editar-usuario" class="bg-blue-500 text-white font-bold hover:bg-blue-600 py-2 px-4 rounded">
          Editar
        </button>
        <button type="reset" id="nuevo-registro" class="bg-gray-500 text-white font-bold hover:bg-gray-600 py-2 px-4 rounded">
          Nuevo
        </button>
      </div>

    </form>

    <!-- Tabla de personas -->
    <div class="relative max-h-[450px] overflow-x-hidden shadow-md sm:rounded-lg mt-5">
      <table class="w-full text-sm text-left rtl:text-right text-gray-500">
        <thead class="sticky top-2 text-xs text-gray-70 uppercase bg-lime-300">
          <tr>
            <th scope="col" class="px-6 py-1"> N° </th>
            <th scope="col" class="px-6 py-1"> Nombre completo </th>
            <th scope="col" class="px-6 py-3"> &Aacute;rea </th>
            <th scope="col" class="px-6 py-3"> Usuario </th>
            <th scope="col" class="px-6 py-3"> Contrase&ntilde;a </th>
            <th scope="col" class="px-6 py-3"> Estado </th>
          </tr>
        </thead>
        <tbody>
          <?php
          $usuarios = $usuarioModel->listarUsuario();
          foreach ($usuarios as $usuario) {
            echo "<tr class='bg-white hover:bg-green-100 hover:scale-[101%] transition-all hover:cursor-pointer border-b '>";
            echo "<th scope='col' class='px-6 py-4 font-medium text-gray-900 whitespace-nowrap ' data-cod='"  . htmlspecialchars($persona['USU_codigo']) . "' >";
            echo $persona['USU_codigo'];
            echo "</th>";
            echo "<td class='px-6 py-4 ' data-nombre='" . htmlspecialchars($persona['PER_nombres']) . "' >";
            echo $persona['PER_nombres'] . ' ' . $persona['PER_apellidoPaterno'] . ' ' . $persona['PER_apellidoMaterno'];
            echo "</td>";
            echo "<td class='px-6 py-4 ' data-dni='" . htmlspecialchars($persona['PER_dni']) . "' >";
            echo $persona['PER_dni'];
            echo "</td>";
            echo "<td class='px-6 py-4' data-celular='" . htmlspecialchars($persona['PER_celular']) . "'>";
            echo $persona['PER_celular'];
            echo "</td>";
            echo "<td class='px-6 py-4' data-email='" . htmlspecialchars($persona['PER_email']) . "'>";
            echo $persona['PER_email'];
            echo "</td>";
            echo "<td class='px-6 py-4' data-email='" . htmlspecialchars($persona['PER_email']) . "'>";
            echo $persona['PER_email'];
            echo "</td>";
            echo "</tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </main>
  <script src="./app/View/func/func_usuario.js"></script>
</body>

<script>
  $(document).ready(function() {
    // Evento de clic en una fila de la tabla
    $('tr').click(function() {
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
    });



    // Evento de clic en el botón "Guardar Persona"
    $(document).ready(function() {
      $("#guardar-persona").on("click", function() {
        // Validar si los campos obligatorios están llenos
        if ($('#txt_dni').val() === '' || $('#txt_nombre').val() === '' || $('#txt_apellidoPaterno').val() === '' || $('#txt_apellidoMaterno').val() === '' || $('#txt_celular').val() === '' || $('#txt_email').val() === '') {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Por favor, complete todos los campos obligatorios.',
            confirmButtonColor: '#d33', // Cambiar el color del botón de confirmación a rojo
            confirmButtonText: 'OK'
          });
          return; // Detener el proceso de guardado si falta algún campo
        } else {
          Swal.fire({
            icon: 'success',
            title: 'Nueva persona registrada',
            text: '¡La nueva persona ha sido registrada exitosamente!',
            confirmButtonColor: '#3085d6', // Cambiar el color del botón de confirmación a azul
            confirmButtonText: 'Aceptar'
          });
        }

        // Obtener los datos del formulario
        var formData = $("form").serialize(); // Obtener los datos del formulario

        $.ajax({
          url: "modulo-usuario.php", // Reemplaza "tu_archivo_de_backend.php" con tu ruta de backend
          type: "POST",
          data: formData,
          success: function(response) {
            $("form")[0].reset();
          },
          error: function(xhr, status, error) {
            console.error(error);
            // alert("Error al guardar los datos. Por favor, inténtalo de nuevo.");
          }
        });
      });
    });

    // Evento de clic en el botón "Editar Persona"
    $('#editarpersona').click(function() {
      var codPersona = $('#txt_codPersona').val();
      var dni = $('#txt_dni').val();
      var nombre = $('#txt_nombre').val();
      var apellidoPaterno = $('#txt_apellidoPaterno').val();
      var apellidoMaterno = $('#txt_apellidoMaterno').val();
      var celular = $('#txt_celular').val();
      var email = $('#txt_email').val();

      if (!codPersona) {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Por favor, seleccione un registro para editar.',
          confirmButtonColor: '#d33', // Cambiar el color del botón de confirmación a rojo
          confirmButtonText: 'OK'
        });
        return;
      }

      // Aquí puedes realizar las acciones necesarias para editar el registro
      Swal.fire({
        icon: 'success',
        title: 'Registro editado',
        text: 'Los datos del registro han sido actualizados exitosamente.',
        confirmButtonColor: '#3085d6', // Cambiar el color del botón de confirmación a azul
        confirmButtonText: 'Aceptar'
      });
    });

    // Evento de clic en el botón "Limpiar Campos"
    $('#limpiarCampos').click(function() {
      const form = document.getElementById('formUsuario');
      form.reset();
    });

    // Evento de clic en el botón "Nuevo Registro"
    $('#nuevoRegistro').click(function() {
      const form = document.getElementById('formUsuario');
      form.reset();
    });
  });
</script>

</html>