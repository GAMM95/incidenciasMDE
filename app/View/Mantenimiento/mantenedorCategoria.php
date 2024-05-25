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

<body class="bg-gray-100 flex items-center justify-center min-h-screen overflow-x-hidden">

  <main class="bg-[#eeeff1] flex-1 p-4 overflow-y-auto">
    <h1 class="text-2xl font-bold mb-4 ">Módulo / Categoría</h1>

    <form id="formcategoria" action="modulo-categoria.php?action=registrar" method="POST" class="border bg-white shadow-md p-6 w-full text-sm rounded-md">

      <!-- PRIMERA FILA: campo para mostrar el numero de Persona -->
      <div class="flex justify-center -mx-2 mb-5">
        <div class="w-full sm:w-1/4 px-2 mb-2">
          <div class="flex items-center">
            <label for="CodCategoria" class="block font-bold mb-1 mr-3 text-lime-500">Código de categoría:</label>
            <input type="text" id="CodCategoria" name="CodCategoria" class="w-20 border border-gray-200 bg-gray-100 rounded-md p-2 text-sm text-center" readonly disabled>
          </div>
        </div>
      </div>

      <div class="flex flex-wrap -mx-2">
        <div class="w-full sm:w-1/4 px-2 mb-2">
          <label for="NombreCategoria" class="block mb-1 font-bold text-sm">Nombre categoría:</label>
          <input type="text" id="NombreCategoria" name="NombreCategoria" class="border p-2 w-full text-sm">
        </div>
      </div>

      <script>
        // Uso de PHP para setear los valores en el formulario si hay una categoría registrada
        document.getElementById('CodCategoria').value = '<?php echo $CategoriaRegistrada ? $CategoriaRegistrada['CAT_codigo'] : ''; ?>';
        document.getElementById('NombreCategoria').value = '<?php echo $CategoriaRegistrada ? $CategoriaRegistrada['CAT_nombre'] : ''; ?>';
      </script>

      <div class="flex justify-center space-x-4">
        <button type="button" id="guardar-categoria" class="bg-[#87cd51] text-white font-bold hover:bg-[#8ce83c] py-2 px-4 rounded">
          Guardar
        </button>
        <button type="button" class="bg-blue-500 text-white font-bold hover:bg-blue-600 py-2 px-4 rounded">
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

    <div class="relative max-h-[450px] overflow-x-hidden shadow-md sm:rounded-lg mt-5">
      <table class="w-full text-sm text-left rtl:text-right text-gray-500">
        <thead class="sticky top-2 text-xs text-gray-70 uppercase bg-lime-300">
          <tr>
            <th scope="col" class="px-10 py-3 w-1/6">N°</th>
            <th scope="col" class="px-6 py-3 w-5/6">Categoría</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $categorias = $categoriaModel->listarCategoria();
          foreach ($categorias as $categoria) {
            echo "<tr class='bg-white hover:bg-green-100 hover:scale-[101%] transition-all hover:cursor-pointer border-b'>";
            echo "<th scope='col' class='px-10 py-4 font-medium text-gray-900 whitespace-nowrap' data-codcategoria='" . htmlspecialchars($categoria['CAT_codigo']) . "'>";
            echo $categoria['CAT_codigo'];
            echo "</th>";
            echo "<th scope='row' class='px-6 py-4 font-medium text-gray-900 whitespace-nowrap' data-categoria='" . htmlspecialchars($categoria['CAT_nombre']) . "'>";
            echo $categoria['CAT_nombre'];
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
      var cod = $(this).find('th[data-codcategoria]').data('codcategoria');
      var nom = $(this).find('th[data-categoria]').data('categoria'); // Asegúrate de que el nombre del dataset sea correcto

      $('#CodCategoria').val(cod);
      $('#NombreCategoria').val(nom);
      $(this).addClass('bg-blue-200 font-semibold');
      $('tr').not(this).removeClass('bg-blue-200 font-semibold');
    });
  });

  function limpiarCampos() {
    const form = document.getElementById('formcategoria');
    form.reset();
  }
  const btnLimpiar = document.getElementById('limpiarCampos');
  btnLimpiar.addEventListener('click', limpiarCampos);

  function nuevoRegistro() {
    const form = document.getElementById('formcategoria');
    form.reset();
  }
  const btnNuevo = document.getElementById('nuevoRegistro');
  btnNuevo.addEventListener('click', nuevoRegistro);

  $(document).ready(function() {
    $("#guardar-categoria").on("click", function() {
      var formData = $("form").serialize();

      $.ajax({
        url: "modulo-categoria.php?action=registrar",
        method: "POST",
        data: formData,
        success: function(response) {
          toastr.success("Categoría guardada exitosamente");
        },
        error: function(xhr, status, error) {
          console.log(xhr.responseText);
          toastr.error("Error al guardar la categoría");
        }
      });
    });
  });
</script>

</html>