<!doctype html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE-edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="public/assets/logo.ico">

  <!-- Importación de librería jQuery -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
  <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  <!-- Agrega las hojas de estilo de Tailwind CSS -->
  <link href="http//cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Agrega la fuente Poppins desde Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700" rel="stylesheet">
  <!-- Implementación de funcionalidades para la vista cliente -->
  <script src="app/Views/Func/password-toggle.js"></script>
  <!-- Implementación de iconos-->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <!-- Incluye Alpine.js -->
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
  <title class="text-center text-3xl font-poppins">Sistema de Incidencias</title>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <!-- Contenido principal -->
  <main class="bg-[#eeeff1] flex-1 p-4 overflow-y-auto">
    <!-- Header -->
    <h1 class="text-2xl font-bold mb-4">Mantenimiento de Persona</h1>

    <form id="formPersona" action="mantenimiento-persona.php?action=registrar" method="POST" class="border bg-white shadow-md p-6 w-full text-sm rounded-md">
      <!-- PRIMERA FILA Campo para mostrar el número de incidencia -->
      <div class="flex flex-wrap -mx-2">
        <label for="CodPersona" class="block font-bold mb-1 mr-1 text-lime-500">Código de Persona:</label>
        <input type="text" id="CodPersona" name="CodPersona" class="w-20 border border-gray-200 bg-gray-100 rounded-md p-2 text-sm" readonly disabled>
        <!-- El atributo 'readonly' evita que el usuario edite este campo -->
      </div>
      <!-- SEGUNDA fila: Categoria, Prioridad, Fecha -->
      <div class="flex flex-wrap -mx-2">

        <div class="w-full sm:w-1/4 px-2 mb-2">
          <label for="dni" class="block mb-1 font-bold text-sm">DNI:</label>
          <input type="text" id="dni" name="dni" class="border p-2 w-full text-sm" class=" border p-2">

        </div>
        <div class="w-full sm:w-1/2 px-2 mb-2">
          <label for="nombre" class="block mb-1 font-bold text-sm">Nombre:</label>
          <input type="text" id="nombre" name="nombre" class="border p-2 w-full text-sm">
        </div>
      </div>
      <!-- CUARTA fila: Asunto -->
      <div class="flex flex-wrap -mx-2">
        <div class="w-full sm:w-1/4 px-2 mb-2">
          <label for="celular" class="block mb-1 font-bold text-sm">Celular:</label>
          <input type="text" id="celular" name="celular" class="border p-2 w-full text-sm">
        </div>
        <div class="w-full sm:w-1/2 px-2 mb-2">
          <label for="email" class="block mb-1 font-bold text-sm">Email:</label>
          <input type="text" id="email" name="email" class="border p-2 w-full text-sm">
        </div>
      </div>

      <script>
        document.getElementById('CodPersona').value = '<?php echo $PersonaRegistrada ? $PersonaRegistrada['CodPersona'] : ''; ?>';
        document.getElementById('dni').value = '<?php echo $PersonaRegistrada ? $PersonaRegistrada['DNI'] : ''; ?>';
        document.getElementById('nombre').value = '<?php echo $PersonaRegistrada ? $PersonaRegistrada['NombrePersona'] : ''; ?>';
        document.getElementById('celular').value = '<?php echo $PersonaRegistrada ? $PersonaRegistrada['Celular'] : ''; ?>';
        document.getElementById('email').value = '<?php echo $PersonaRegistrada ? $PersonaRegistrada['Email'] : ''; ?>';
      </script>

      <!-- Botónes -->
      <div class="flex justify-center space-x-4">
        <button type="submit" id="guardar-persona" class="bg-[#87cd51] text-white font-bold hover:bg-[#8ce83c] py-2 px-4 rounded">
          Guardar
        </button>
        <button type="button" id="editarpersona" class="bg-blue-500 text-white font-bold hover:bg-blue-600 py-2 px-4 rounded">
          Editar
        </button>
        <button type="button" id="imprimirDatos" class="bg-yellow-500 text-white font-bold hover:bg-yellow-600 py-2 px-4 rounded w-full md:w-auto mt-2 md:mt-0">
          Imprimir
        </button>
        <button type="button" id="limpiarCampos" class="bg-red-500 text-white font-bold hover:bg-red-600 py-2 px-4 rounded w-full md:w-auto mt-2 md:mt-0">
          Limpiar
        </button>
        <button type="button" id="nuevoRegistro" class="bg-gray-500 text-white font-bold hover:bg-gray-600 py-2 px-4 rounded w-full md:w-auto mt-2 md:mt-0">
          Nuevo
        </button>
      </div>

    </form>

    <div class="relative max-h-[300px] overflow-x-hidden shadow-md sm:rounded-lg">
      <table class="w-full text-sm text-left rtl:text-right text-gray-500">
        <thead class="sticky
                        top-2 text-xs text-gray-70 uppercase bg-lime-300">
          <tr>
            <th scope="col" class="px-6 py-1">
              °
            </th>
            <th scope="col" class="px-6 py-1">
              DNI
            </th>
            <th scope="col" class="px-6 py-3">
              Nombre
            </th>
            <th scope="col" class="px-6 py-3">
              Celular
            </th>
            <th scope="col" class="px-6 py-3">
              Email
            </th>
          </tr>
        </thead>
        <tbody>
          <?php
          require_once './app/models/MantPersonaModel.php';
          $mantPersonaModel = new PersonaModel();
          $personas = $mantPersonaModel->listarPersona();
          foreach ($personas as $persona) {
            echo "<tr class='bg-white hover:bg-green-100 hover:scale-[101%] transition-all hover:cursor-pointer border-b '>";
            echo "<th scope='col' class='px-6 py-4 font-medium text-gray-900 whitespace-nowrap ' data-cod='" . htmlspecialchars($persona['CodPersona']) . "' >";
            echo $persona['CodPersona'];
            echo "</th>";
            echo "<td class='px-6 py-4 ' data-dni='" . htmlspecialchars($persona['DNI']) . "' >";
            echo $persona['DNI'];
            echo "</td>";
            echo "<td class='px-6 py-4 ' data-nombre='" . htmlspecialchars($persona['NombrePersona']) . "' >";
            echo $persona['NombrePersona'];
            echo "</td>";
            echo "<td class='px-6 py-4' data-celular='" . htmlspecialchars($persona['Celular']) . "'>";
            echo $persona['Celular'];
            echo "</td>";
            echo "<td class='px-6 py-4' data-email='" . htmlspecialchars($persona['Email']) . "'>";
            echo $persona['Email'];
            echo "</td>";
            echo "</tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </main>

</body>
<script>
  $(document).ready(function() {
    $('tr').click(function() {
      var cod = $(this).find('th').data('cod');
      var dni = $(this).find('td[data-dni]').data('dni'); // Corrected line
      var nombre = $(this).find('td[data-nombre]').data('nombre'); // Corrected line
      var celular = $(this).find('td[data-celular]').data('celular'); // Corrected line
      var email = $(this).find('td[data-email]').data('email'); // Corrected line

      $('#CodPersona').val(cod);
      $('#dni').val(dni);
      $('#nombre').val(nombre);
      $('#celular').val(celular);
      $('#email').val(email);
      $(this).addClass('bg-blue-200 font-semibold');
      $('tr').not(this).removeClass('bg-blue-200 font-semibold');
    });
  });
  ////////////////////////////////////////////////////////////////////////

  function limpiarCampos() {
    // Obtener el formulario por su ID
    const form = document.getElementById('formPersona');
    // Limpiar los campos del formulario
    form.reset();
  }
  const btnLimpiar = document.getElementById('limpiarCampos');
  btnLimpiar.addEventListener('click', limpiarCampos);

  function editarpersona() {
    // Obtener el formulario por su ID
    const form = document.getElementById('formPersona');
    // Limpiar los campos del formulario
    $action = "editar";
    form.reset();

  }
  const btnEditar = document.getElementById('editarpersona');
  btnEditar.addEventListener('click', editarpersona);

  function nuevoRegistro() {
    const form = document.getElementById('formPersona');

    // Restablecer el formulario
    form.reset();
  }
  // Asignar el evento 'click' al botón 'Nuevo Registro'
  const btnNuevo = document.getElementById('nuevoRegistro');
  btnNuevo.addEventListener('click', nuevoRegistro);

  //GUARDAR DATOS
  $(document).ready(function() {
    $("#guardar-persona").on("click", function() {
      // Obtener los datos del formulario
      var formData = $("form").serialize(); // Obtener los datos del formulario

      $.ajax({
        url: "mantenimiento-persona.php", // Reemplaza "tu_archivo_de_backend.php" con tu ruta de backend
        type: "POST",
        data: formData,
        success: function(response) {
          // Manejar la respuesta del servidor si es necesario
          alert("Datos guardados exitosamente");
          // Puedes limpiar el formulario si lo deseas
          $("form")[0].reset();
        },
        error: function(xhr, status, error) {
          // Manejar los errores si la solicitud falla
          console.error(error);
          alert("Error al guardar los datos. Por favor, inténtalo de nuevo.");
        }
      });
    });
  });
</script>

</html>