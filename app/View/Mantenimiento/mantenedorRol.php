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
    <h1 class="text-2xl font-bold mb-4 ">M&oacute;dulo / Rol</h1>

    <form id="formrol" action="modulo-rol.php?action=registrar" method="POST" class="border bg-white shadow-md p-6 w-full text-sm rounded-md">
      <!-- PRIMERA FILA Campo para mostrar el número de incidencia -->
      <div class="flex justify-center -mx-2 mb-5">
        <div class="flex items-center mb-4">
          <div class="flex items-center">
            <label for="CodRol" class="block font-bold mb-1 mr-3 text-lime-500">C&oacute;digo de Rol:</label>
            <input type="text" id="txt_codigoRol" name="CodRol" class="w-20 border border-gray-200 bg-gray-100 rounded-md p-2 text-sm text-center" readonly disabled>
          </div>
        </div>
      </div>

      <!-- SEGUNDA FILA: campo para ingresar e nuevo nombre del rol -->
      <div class="flex flex-wrap -mx-2">
        <div class="w-full sm:w-1/4 px-2 mb-2">
          <label for="NombreRol" class="block mb-1 font-bold text-sm">Nombre rol:</label>
          <input type="text" id="txt_nombreRol" name="NombreRol" class="border p-2 w-full text-sm">
        </div>
      </div>

      <script>
        document.addEventListener("DOMContentLoaded", function() {
          document.getElementById('txt_codigoRol').value = '<?php echo isset($RolRegistrado) ? htmlspecialchars($RolRegistrado['ROL_codigo']) : ''; ?>';
          document.getElementById('txt_nombreRol').value = '<?php echo isset($RolRegistrado) ? htmlspecialchars($RolRegistrado['ROL_nombre']) : ''; ?>';
        })
      </script>

      <!-- TERCERA FILA: botones -->
      <div class="flex justify-center space-x-4">
        <button type="button" id="guardar-rol" class="bg-[#87cd51] text-white font-bold hover:bg-[#8ce83c] py-2 px-4 rounded">
          Guardar
        </button>
        <button type="button" id="editar-rol" class="bg-blue-500 text-white font-bold hover:bg-blue-600 py-2 px-4 rounded">
          Editar
        </button>
        <button type="button" id="nuevo-registro" class="bg-gray-500 text-white font-bold hover:bg-gray-600 py-2 px-4 rounded w-full md:w-auto mt-2 md:mt-0">
          Nuevo
        </button>
      </div>

    </form>

    <!-- TABLA -->
    <div class="relative max-h-[300px] overflow-x-hidden shadow-md sm:rounded-lg mt-5">
      <table class="w-full text-sm text-left rtl:text-right text-gray-500">
        <!-- ENCABEZADO DE LA TABLA -->
        <thead class="sticky top-2 text-xs text-gray-70 uppercase bg-lime-300">
          <tr>
            <th scope="col" class="px-10 py-3 w-1/6"> N°</th>
            <th scope="col" class="px-6 py-3 w-5/6"> Rol</th>
          </tr>
        </thead>
        <!-- CUERPO DE LA TABLA -->
        <tbody>
          <?php
          require_once './app/Model/RolModel.php';
          $rolModel = new RolModel($nombre);
          $roles = $rolModel->listarRol();
          foreach ($roles as $rol) {
            echo "<tr class='bg-white hover:bg-green-100 hover:scale-[101%] transition-all hover:cursor-pointer border-b'>";
            echo "<th scope='col' class='px-10 py-4 font-medium text-gray-900 whitespace-nowrap' data-codrol='" . htmlspecialchars($rol['ROL_codigo']) . "'>";
            echo htmlspecialchars($rol['ROL_codigo']);
            echo "</th>";
            echo "<th scope='row' class='px-6 py-4 font-medium text-gray-900 whitespace-nowrap' data-rol='" . htmlspecialchars($rol['ROL_nombre']) . "'>";
            echo htmlspecialchars($rol['ROL_nombre']);
            echo "</th>";
            echo "</tr>";
          }
          ?>
        </tbody>
      </table>
    </div>

  </main>

</body>
<script src="./app/View/func/func_rol.js"></script>

</html>