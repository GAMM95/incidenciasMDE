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

<body class="bg-gray-100 flex items-center justify-center min-h-screen overflow-x-hidden">

  <!-- Contenido principal -->
  <main class="bg-[#eeeff1] flex-1 p-4 overflow-y-auto">
    <!-- Header -->
    <h1 class="text-2xl font-bold mb-4 ">M&oacute;dulo / &Aacute;rea</h1>

    <form id="formarea" action="modulo-rol.php?action=registrar" method="POST" class="border bg-white shadow-md p-6 w-full text-sm rounded-md">

      <!-- PRIMERA FILA Campo para mostrar el número de incidencia -->
      <div class="flex justify-center -mx-2 mb-5">
        <div class="flex items-center mb-4">
          <div class="flex items-center">
            <label for="CodRol" class="block font-bold mb-1 mr-3 text-lime-500">C&oacute;digo de &aacute;rea:</label>
            <input type="text" id="CodRol" name="CodRol" class="w-20 border border-gray-200 bg-gray-100 rounded-md p-2 text-sm" readonly disabled>
          </div>
        </div>
      </div>

      <!-- SEGUNDA fila: Área, Código Patrimonial -->
      <div class="flex flex-wrap -mx-2">

        <div class="w-full sm:w-1/4 px-2 mb-2">
          <label for="NombreArea" class="block mb-1 font-bold text-sm">Nombre &aacute;rea:</label>
          <input type="text" id="NombreArea" name="NombreArea" class="border p-2 w-full text-sm">
        </div>
      </div>

      <script>
        CodArea.getElementById('CodArea').value = '<?php echo $AreaRegistrada ? $AreaRegistrada['CodRol'] : ''; ?>';
        document.getElementById('NombreArea').value = '<?php echo $AreaRegistrada ? $AreaRegistrada['NombreArea'] : ''; ?>';
      </script>

      <!-- Botónes -->
      <div class="flex justify-center space-x-4">
        <button type="button" id="guardar-categoria" class="bg-[#87cd51] text-white font-bold hover:bg-[#8ce83c] py-2 px-4 rounded">
          Guardar
        </button>
        <button type="button" id='editar-area' class="bg-blue-500 text-white font-bold hover:bg-blue-600 py-2 px-4 rounded">
          Editar
        </button>
        <button type="button" id="nuevoRegistro" class="bg-gray-500 text-white font-bold hover:bg-gray-600 py-2 px-4 rounded w-full md:w-auto mt-2 md:mt-0">
          Nuevo
        </button>
      </div>

    </form>

    <!-- Tabla de Areas -->
    <div class="relative max-h-[550px] overflow-x-hidden shadow-md sm:rounded-lg mt-5">
      <table class="w-full text-sm text-left rtl:text-right text-gray-500">
        <thead class="sticky top-2 text-xs text-gray-70 uppercase bg-lime-300">
          <tr>
            <th scope="col" class="px-10 py-3 w-1/6"> N°</th>
            <th scope="col" class="px-6 py-3 w-5/6"> &Aacute;rea</th>
          </tr>
        </thead>
        <tbody>
          <?php
          require_once './app/Model/AreaModel.php';
          $AreaModel = new AreaModel($nombre);
          $areas = $AreaModel->listarArea();
          foreach ($areas as $area) {
            echo "<tr class='bg-white hover:bg-green-100 hover:scale-[101%] transition-all hover:cursor-pointer border-b'>";
            echo "<th scope='col' class='px-10 py-4 font-medium text-gray-900 whitespace-nowrap' data-rol='" . htmlspecialchars($area['ARE_codigo']) . "'>";
            echo $area['ARE_codigo'];
            echo "</th>";
            echo "<th scope='row' class='px-6 py-4 font-medium text-gray-900 whitespace-nowrap' data-rol='" . htmlspecialchars($area['ARE_nombre']) . "'>";
            echo $area['ARE_nombre'];
            echo "</th>";
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
      var cod = $(this).find('th[data-codarea]').data('codarea'); // Corrected line
      var cat = $(this).find('th[data-area]').data('area');


      $('#CodArea').val(cod);
      $('#NombreArea').val(nom);
      $(this).addClass('bg-blue-200 font-semibold');
      $('tr').not(this).removeClass('bg-blue-200 font-semibold');
    });
  });
  ////////////////////

  function limpiarCampos() {
    // Obtener el formulario por su ID
    const form = document.getElementById('formarea');
    // Limpiar los campos del formulario
    form.reset();
  }
  const btnLimpiar = document.getElementById('limpiarCampos');
  btnLimpiar.addEventListener('click', limpiarCampos);

  function nuevoRegistro() {
    const form = document.getElementById('formarea');

    // Restablecer el formulario
    form.reset();
  }
  // Asignar el evento 'click' al botón 'Nuevo Registro'
  const btnNuevo = document.getElementById('nuevoRegistro');
  btnNuevo.addEventListener('click', nuevoRegistro);

  //GUARDAR DATOS
  $(document).ready(function() {
    $("#guardar-categoria").on("click", function() {
      // Obtener los datos del formulario
      var formData = $("form").serialize(); // Obtener los datos del formulario

      $.ajax({
        url: "modulo-area.php", // Reemplaza "tu_archivo_de_backend.php" con tu ruta de backend
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